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
    register_activation_hook(__FILE__, array('productions', 'activate'));
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
