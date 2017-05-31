<?php
/**
 * Template Name: Rehearsals
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
<?php echo page_header($image[0], get_the_title($post->ID));?>

<div class="container">
	<?php
	while (have_posts())
	{
		the_post();
		the_content();
		$custom_fields = get_post_custom($post->id);
  		echo $custom_fields['rehearsal map data'][0];
	}
	?>
</div>

<?php get_footer(); ?>
