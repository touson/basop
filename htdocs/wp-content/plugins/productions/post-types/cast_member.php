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

            if ( is_admin() ) {
                add_action( 'admin_init', array( &$this, 'admin_init' ) );
            }
        }

        /**
         * hook into WP's init action hook
         */
        public function init()
        {
            // Initialize Post Type
            $this->create_post_type();
            //add_action('save_post', array($this, 'save_post'));
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
         * Initialize the admin, adding actions to properly display and handle
         * the Cast custom post type add/edit page
         */
        public function admin_init() {
            global $pagenow;

            if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' ) {
                add_action( 'add_meta_boxes', array( &$this, 'meta_boxes' ) );
                add_action( 'save_post', array( &$this, 'meta_boxes_save' ), 1, 2 );
            }
        }

        /**
         * Add and remove meta boxes from the edit page
         */
        public function meta_boxes() {
            add_meta_box( 'cast-image', __( 'Cast Image' ), array( $this, 'cast_image_meta_box' ), self::POST_TYPE);
        }


        /**
         * Save meta boxes
         *
         * Runs when a post is saved and does an action which the write panel save scripts can hook into.
         */
        public function meta_boxes_save( $post_id, $post ) {
            if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
            if ( is_int( wp_is_post_revision( $post ) ) ) return;
            if ( is_int( wp_is_post_autosave( $post ) ) ) return;
            if ( ! current_user_can( 'edit_post', $post_id ) ) return;
            if ( $post->post_type != self::POST_TYPE ) return;

            $this->process_cast_meta( $post_id, $post );
        }


        /**
         * Function for processing and storing all cast data.
         */
        private function process_cast_meta( $post_id, $post ) {
            update_post_meta( $post_id, '_image_id', $_POST['upload_image_id'] );
        }

        /**
         * Display the image meta box
         */
        public function cast_image_meta_box($post) {
            // Render the production details metabox
            include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), "cast_image"));
        }
    }
}
