<?php

if(!class_exists('Production'))
{
    class Production
    {
        const POST_TYPE = "production";

        private $_meta  = array(
            'date',
            'venue',
            'director',
            'ticket_url'
        );

        /**
         * The Constructor
         */
        public function __construct()
        {
            // register actions
            add_action('init', array($this, 'init'));
            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'remove_custom_fields'));
        }

        /**
         * hook into WP's init action hook
         */
        public function init()
        {
            // Initialize Post Type
            $this->create_post_type();
            add_action('save_post', array($this, 'save_post'));
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
         * Save the metaboxes for this custom post type
         */
        public function save_post($post_id)
        {
            // verify if this is an auto save routine.
            // If it is our form has not been submitted, so we dont want to do anything
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            {
                return;
            }

            if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
            {
                foreach($this->_meta as $field_name)
                {
                    // Update the post's meta field
                    update_post_meta($post_id, $field_name, $_POST[$field_name]);
                }
            }
            else
            {
                return;
            }
        }

        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
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

            // Add the primary cast members meta box
            add_meta_box(
                sprintf('%s_section', Cast_Member::POST_TYPE),
                sprintf('Select Primary %ss', ucwords(str_replace("_", " ", Cast_Member::POST_TYPE))),
                array($this, 'add_primary_cast_meta_box'),
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
         * Output primary cast selection meta box
         */
        public function add_primary_cast_meta_box()
        {
            // Collate all available cast members
            $castMembers = new WP_Query(array('post_type' => Cast_Member::POST_TYPE));

            if($castMembers->have_posts())
            {
                // Render the cast members metabox
                include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), Cast_Member::POST_TYPE));
            }
        }

        /**
         * Removes the custom fields block from the post edit screen
         */
        public function remove_custom_fields() {
            remove_meta_box( 'postcustom' , 'post' , 'normal' );
        }
    }
}
