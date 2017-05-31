<?php
/*
Plugin Name: Productions
Description: Administers theatre productions
Version:     1.0
Author:      Chris Sewell
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: basop
*/

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

if (!class_exists("Productions"))
{
	class Productions
	{
		public function __construct()
		{
			//In the class constructor register all of the actions that your base plugin needs
			//add_action('admin_init', array($this, 'admin_init'));
			//add_action('admin_menu', array($this, 'add_menu'));

			require_once(sprintf("%s/post-types/production.php", dirname(__FILE__)));
			require_once(sprintf("%s/post-types/cast_member.php", dirname(__FILE__)));
			$production = new Production();
			$castMember = new Cast_Member();
		}

		public function get_production_archive()
		{
			$productions = new WP_Query([
				'post_type'=>'production',
				'post_status'=>'published',
				'order'=>'DESC',
				'orderby'=>'post_date']);
			foreach($productions->posts as $p) {
				$prods[] = $prod = $this->get_production($p->ID);
			}

			return $prods;
		}

        /**
         * Get production
         * --------------
         * Returns a well formed array representing all details for a single production
         *
         * @param  INT      $prodId     The post ID for the production we want
         * @return ARRAY                The values of the requested production
         */
        public function get_production($prodId)
        {
        	$p = get_post($prodId);

            // send back a blank array if we have no post for supplied ID
        	if($p == NULL) {
        		return [];
        	}

        	$prod = [];

            // Get the image if it exists
        	$thumbnail = get_the_post_thumbnail_url($p->ID, 'medium');
        	$prod['imgSrc'] = $thumbnail ? $thumbnail : 'blank.jpg';

            // Get the main details for the production
        	$fields = [
        	'post_content' => 'description',
        	'post_excerpt' => 'short_description',
        	'post_title'=>'title',
        	'post_name'=>'slug',
        	'guid'=>'guid',
        	'post_date'=>'post_date'
        	];
        	foreach($fields as $metaKey => $realKey) {
        		$prod[$realKey] = $p->$metaKey;
        	}

            // Get all meta data
        	$m = get_post_meta($p->ID);

        	$keys = ['date','venue','director','ticket_url','characters','secondary_characters'];

        	foreach($keys as $key) {
        		if(strpos($key, 'character') !== false) {
        			//echo '<pre>', print_r($key), '</pre>';
        			//var_dump($m[$key]);
        			$prod[$key] = isset($m[$key]) ? $this->get_cast_member_from_serialized_string($m[$key][0]) : [];
        		}
        		else {
        			$prod[$key] = $m[$key][0];
        		}
        	}

        	return $prod;
        }

        /**
         * Get Cast Member
         * ---------------
         * Return a well formed array containing all details for a specific cast member
         *
         * @param  STRING $serializedData   A serialized array string containing
         *                                  references to all cast members we want
         * @return ARRAY                    An array of cast member values
         */
        public function get_cast_member_from_serialized_string($serializedData)
        {
        	$fields = [
        	'post_content' => 'bio',
        	'post_title'=>'name',
        	'post_name'=>'slug',
        	];

        	$castMembers = unserialize(unserialize($serializedData));

        	foreach($castMembers as &$member) {
        		$memberPost = get_post($member['cast_member']);
        		if($memberPost != NULL) {
        			foreach($fields as $metaKey=>$realKey) {
        				$member[$realKey] = $memberPost->$metaKey;
        			}
        		}
        	}

        	return $castMembers;
        }

		/**
		 * hook into WP's admin_init action hook
		 */
		public function admin_init()
		{
			$this->init_settings();
		}

		/**
		 * Initialize some custom settings
		 */
		public function init_settings()
		{
			// examples settings being set
			register_setting('Productions-group', 'setting_a');
			register_setting('productions-group', 'setting_b');
		}

		/**
		 * add a menu
		 */
		public function add_menu()
		{
			add_options_page('Productions Settings', 'Productions', 'manage_options', 'productions', array($this, 'plugin_settings_page'));
		}

		/**
		 * Menu Callback
		 */
		public function plugin_settings_page()
		{
		    // if(!current_user_can('manage_options'))
		    // {
		    //     wp_die(__('You do not have sufficient permissions to access this page.'));
		    // }

		    // Render the settings template
			include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
		}

		/**
         * Activate the plugin
         */
		public static function activate()
		{
            // Do nothing
		}

        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            // Do nothing
        }
    }
}

if(class_exists('Productions'))
{
    // Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Productions', 'activate'));
	register_deactivation_hook(__FILE__, array('Productions', 'deactivate'));

    // instantiate the plugin class
	$bspProductions = new Productions();
}

// Add a link to the settings page onto the plugin page
if(isset($bspProductions))
{
    // Add the settings link to the plugins page
	function plugin_settings_link($links)
	{
		$settings_link = '<a href="options-general.php?page=productions">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	$plugin = plugin_basename(__FILE__);
	add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
}
