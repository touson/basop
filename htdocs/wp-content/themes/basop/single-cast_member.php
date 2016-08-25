<?php
/**
 * The template for displaying individual cast member information
 *
 * @package WordPress
 * @subpackage Basop
 * @since Basop 1.0
 */

get_header(); ?>

<?php
if (have_posts()) {
	while (have_posts()) {
		the_post(); ?>

		<div id="main-container">
			<div class="container">

				<div class="main-bio">
					<img src="<?php echo get_post(get_post_meta($post->ID, '_image_id')[0])->guid;?>" class="main-bio-image" />
					<h1><?php the_title();?></h1>
					<?php the_content();?>
				</div>

			</div>
		</div>

		<?php
	}
}
?>
<?php get_footer(); ?>
