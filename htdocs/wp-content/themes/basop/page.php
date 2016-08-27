<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Basop
 * @since Basop 1.0
 */

get_header();

// Output page header
$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
$image = $image ? $image : wp_get_attachment_image_src(get_post_thumbnail_id(get_page_by_title('home')->ID),'full') ;
?>
<div class="page-header" style="background-image:url(<?php echo $image[0];?>">
	<?php echo the_title( '<div class="title">', '</div>' );?>
</div>

<div class="container">
	<?php
	while (have_posts())
	{
		the_post();
		the_content();
	}
	?>
</div>

<?php get_footer(); ?>
