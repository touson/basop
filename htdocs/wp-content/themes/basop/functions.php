<?php
/**
 * Basop functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()
) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Basop
 * @since Basop 1.0
 */


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own basop_setup() function to override in a child theme.
 *
 * @since Basop 1.0
 */
function basop_setup() {
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(1200, 9999);

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'basop'),
		'footer' => __('Footer Menu', 'basop')
		));

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
		)
	);

}

add_action('after_setup_theme', 'basop_setup');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Basop 1.0
 */
function basop_widgets_init() {
	register_sidebar(array(
		'name'          => __('Sidebar', 'basop'),
		'id'            => 'sidebar-1',
		'description'   => __('Add widgets here to appear in your sidebar.', 'basop'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
		)
	);
}

add_action('widgets_init', 'basop_widgets_init');

function add_ticket_button($show, $itemName, $amount) {
	return '<div class="details-block paypal">
		<h3>Buy Tickets Online</h3>
		<p>Buy your tickets for ' . $show . ' securely online using PayPal.</p>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="chris@touson.co.uk">
			<input type="hidden" name="lc" value="GB">
			<input type="hidden" name="item_name" value="' . $itemName . '">
			<input type="hidden" name="amount" value="' . $amount . '">
			<input type="hidden" name="currency_code" value="GBP">
			<input type="hidden" name="button_subtype" value="services">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="shipping" value="0.00">
			<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
			<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="Buy show tickets online now!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>';
}

function page_header($image, $title) {
	return "<div class=\"page-header\">
				<div class=\"container\" style=\"background-image:url($image)\">
					<div class=\"title\">$title</div>
				</div>
			</div>";
}
