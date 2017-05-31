<?php

if(!class_exists('Production'))
{
	class Production
	{
		const POST_TYPE = "production";

		private $_meta  = array(
			'date',
			'venue',
			'ticket_cost',
			'box_office',
			'gallery'
			);

		private $castMembers;
		private $members;
		private $saved;

        /**
         * The Constructor
         */
        public function __construct()
        {
        	$this->saved = false;
            // register actions
        	add_action('init', array($this, 'init'));
        	add_action('admin_init', array($this, 'admin_init'));
        	add_action('admin_menu', array($this, 'remove_custom_fields'));

        	$this->errorHandler = new WP_Error();
        }

        /**
         * hook into WP's init action hook
         */
        public function init()
        {
            // Initialize Post Type
        	$this->create_post_type();
            // Add error output hook
        	add_action('save_post', array($this, 'save_post'), 20, 3);
        	add_action('admin_notices', array($this, 'production_admin_notices'), 21);
        }

        /**
         * Create the post type
         */
        public function create_post_type()
        {
        	$lower = strtolower(self::POST_TYPE);
        	$ucWords = ucwords(self::POST_TYPE);

        	$labels = array(
        		'name' => sprintf('%ss', $ucWords),
        		'singular_name' => $ucWords,
        		'add_new' => sprintf('Add %s', $lower),
        		'add_new_item' => sprintf('Add new %s', $lower),
        		'edit_item' => sprintf('Edit %s', $lower),
        		'new_item' => sprintf('New %s', $lower),
        		'view_item' => sprintf('View %s', $lower),
        		'search_items' => sprintf('Search %ss', $lower),
        		'all_items' => sprintf('All %ss', $lower),
        		'featured_image' => sprintf('Main %s image', $lower),
        		'set_featured_image' => sprintf('Set main %s image', $lower),
        		'remove_featured_image' => sprintf('Remove main %s image', $lower),
        		'use_featured_image' => sprintf('Use as main %s image', $lower)
        		);

        	register_post_type(self::POST_TYPE,
        		array(
        			'labels' => $labels,
        			'public' => true,
        			'has_archive' => true,
        			'description' => __("This post type contains all information pertaining to a Production"),
        			'supports' => array(
        				'title', 'editor', 'excerpt', 'thumbnail'
        				),
        			'menu_icon' => 'dashicons-tickets'
        			)
        		);
        }

        /**
         * Save Post
         * ---------
         * Save the metaboxes for this custom post type
         */
        public function save_post($post_id, $post, $update)
        {
        	$this->saved = true;
            // verify if this is an auto save routine.
            // If it is our form has not been submitted, so we dont want to do anything
        	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        		return;

            // verify this came from the our screen and with proper authorization,
            // because save_post can be triggered at other times
        	if ( !isset( $_POST['dynamicMeta_noncename'] ) )
        		return;

            // Verify the nonce field
        	if ( !wp_verify_nonce($_POST['dynamicMeta_noncename'],'save_person'))
        		return;

        	if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
        	{

        		$types = [
        			'characters' => 'cast_member',
        			'secondary_characters' => 'cast_member',
        			'members' => 'member',
        		];

        		foreach($types as $type=>$key) {
        			if(isset($_POST[$type])) {
        				foreach($_POST[$type] as $id=>$vals) {
	        				if ($vals['title'] == '' || $vals[$key] == 'Select...')
	        					$this->errorHandler->add('invalid_' . $key, "ERROR: Please select a " . str_replace("_", " ", $key) . " and enter who they are playing");
	        			}
        			}
        		}

                // If we have an error, get us out of here and don't save anything
        		if(count($this->errorHandler->get_error_messages()) > 0) {
                    //echo '<pre>', print_r($this->errorHandler->get_error_messages()), '</pre>';
        			//return false;
        			// add_action('admin_notices', array($this, 'production_admin_notices'));
        		}

                // Update the post's meta field
        		foreach($this->_meta as $field_name)
        			update_post_meta($post_id, $field_name, $_POST[$field_name]);

        		foreach(['characters', 'secondary_characters', 'members'] as $memType) {
        			// Delete all existing characters associated to this production from the database
        			delete_post_meta($post_id, $memType);

        			// Save the posted characters
        			$member = $this->sanitizeMembers($_POST[$memType]);
        			update_post_meta($post_id, $memType, serialize($member));
        		}
        	}
        	else
        	{
        		return;
        	}
        }

        /**
         * Escape all user memers input
         * @param  Array  $membersArray The $_POST array for characters and members
         * @return [type]               Sanitized array of members
         */
        private function sanitizeMembers(Array $membersArray) {
        	$members = array_map(function($arr){
				array_walk($arr, function(&$value, $key){
					$value = esc_sql($value);
				});
				return $arr;
			}, $membersArray);

			return $members;
        }

        /**
         * Output Admin Errors
         * -------------------
         * Hook into the admin notices function to output any errors we have found
         */
        public function production_admin_notices()
        {
        	settings_errors();
        	$class = 'notice notice-error';

        	$errors = $this->errorHandler->get_error_messages();
        	if(count($errors) > 0)
        	{
        		foreach($errors as $error)
        		{
        			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($error) );
        		}
        	}
        }

        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
            // Collate all available cast members
        	$this->castMembers = new WP_Query([
        		'post_type' => Cast_Member::POST_TYPE,
        		'nopaging' => true,
        		'orderby' => 'name',
        		'order' => 'ASC'
        		]);

            // Add metaboxes
        	add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        }

        /**
         * hook into WP's add_meta_boxes action hook
         */
        public function add_meta_boxes()
        {
            // Add the production meta box
        	add_meta_box(
        		sprintf('%s_section', self::POST_TYPE),
        		sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE))),
        		array($this, 'add_production_info_meta_boxes'),
        		self::POST_TYPE
        		);

            // Add the production meta box
        	add_meta_box(
        		sprintf('%s_section', 'member'),
        		sprintf('%s Information', 'Supporting Members'),
        		array($this, 'add_members_meta_box'),
        		self::POST_TYPE
        		);

            // Add the primary cast members meta box
        	add_meta_box(
        		sprintf('%s_section', 'character'),
        		sprintf('Select Primary %ss', ucwords(str_replace("_", " ", Cast_Member::POST_TYPE))),
        		array($this, 'add_primary_cast_meta_box'),
        		self::POST_TYPE
        		);

            // Add the secondary cast members meta box
        	add_meta_box(
        		sprintf('%s_section', 'secondary_character'),
        		sprintf('Select Remaining %ss', ucwords(str_replace("_", " ", Cast_Member::POST_TYPE))),
        		array($this, 'add_secondary_cast_meta_box'),
        		self::POST_TYPE
        		);

        }

        /**
         * called off of the add meta box
         */
        public function add_production_info_meta_boxes($post)
        {
            // Render the production details metabox
        	include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), self::POST_TYPE));
        }

        /**
         * Output supporting members selection meta box
         */
        public function add_members_meta_box($post)
        {
        	if($this->castMembers->have_posts())
        	{
                // Render the cast members metabox
        		include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), 'member'));
        	}
        }

        /**
         * Output primary cast selection meta box
         */
        public function add_primary_cast_meta_box($post)
        {
        	if($this->castMembers->have_posts())
        	{
                // Render the cast members metabox
        		include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), 'cast_member'));
        	}
        }

        /**
         * Output secondary cast selection meta box
         */
        public function add_secondary_cast_meta_box($post)
        {
        	if($this->castMembers->have_posts())
        	{
                // Render the cast members metabox
        		include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), 'secondary_cast'));
        	}
        }

        /**
         * Removes the custom fields block from the post edit screen
         */
        public function remove_custom_fields() {
        	remove_meta_box( 'postcustom' , 'post' , 'normal' );
        }

        /**
         * Create cast member dropdown
         * ---------------------------
         * Creates a new HTML select box containing the cast memmebrs info
         *
         * @param  string   $name           The name of the select box
         * @param  int      $selectedCastId The DB ID of the cast member we want preselected in the select box
         * @return string                   HTML for the select box
         */
        public function create_cast_dropdown($name = false, $selectedCastId = false)
        {
        	$name = $name ? 'name="' . $name . '"' : '' ;
        	$select = '<select class="cast-member-selector" ' . $name . ' required><option>Select...</option>';
        	while ($this->castMembers->have_posts())
        	{
        		$this->castMembers->the_post();
        		$cast = $this->castMembers->post;
        		$selected = $selectedCastId == $cast->ID ? 'selected="selected"' : '' ;
        		$select .= '<option value="' . $cast->ID . '" ' . $selected . '>' . addslashes($cast->post_title) . '</option>';
        	}
        	$select .= '</select>';

        	return $select;
        }
    }
}
