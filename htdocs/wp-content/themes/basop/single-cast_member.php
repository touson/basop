<?php
/**
 * The template for displaying individual cast member information
 *
 * @package WordPress
 * @subpackage Basop
 * @since Basop 1.0
 */

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();
		// Output page header
		$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_page_by_title('home')->ID),'full') ;?>

			<?php echo page_header($image[0], 'Cast Members');?>

			<div class="container">

				<div class="main-bio">
				<?php
					$attachId = get_post_meta($post->ID, '_image_id')[0];
				?>
					<img src="<?php echo wp_get_attachment_url($attachId);?>" class="main-bio-image" />
					<h1><?php the_title();?></h1>
					<?php the_content();?>
				</div>

			</div>

		<?php
	}
}
?>
<?php get_footer(); ?>
