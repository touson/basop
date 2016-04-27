<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Basop
 * @since Basop 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php //wp_head(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/style.css" />
</head>

<body <?php body_class(); ?>>

	<header>
		<div class="container">
			<a href="/" id="logo"><img src="<?php echo get_template_directory_uri();?>/img/general/logo.jpg" /></a>
			<?php
			if (has_nav_menu('primary'))
			{
				?>
				<a id="nav-trigger">b</a>
				<nav role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'basop' ); ?>" id="main-nav">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'primary',
						'menu_class'     => 'primary-menu',
					));
					?>
				</nav>
				<?php
			}
			?>
		</div>
	</header>

