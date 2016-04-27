<?php

if(!class_exists('Cast_Member'))
{
    class Cast_Member
    {
        const POST_TYPE = "cast_member";

        /**
         * The Constructor
         */
        public function __construct()
        {
            // register actions
            add_action('init', array($this, 'init'));
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
            $lower = str_replace("_", " ", strtolower(self::POST_TYPE));
            $ucWords = ucwords($lower);

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
                'featured_image' => 'Headshot',
                'set_featured_image' => 'Set headshot',
                'remove_featured_image' => 'Remove headshot',
                'use_featured_image' => 'Use as headshot'
            );

            register_post_type(self::POST_TYPE,
                array(
                    'labels' => $labels,
                    'public' => true,
                    'has_archive' => true,
                    'description' => __("Cast member bio"),
                    'supports' => array(
                        'title', 'editor', 'thumbnail'
                    ),
                    'menu_icon' => 'dashicons-admin-users'
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
    }
}
