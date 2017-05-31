<?php
/**
 * Template Name: Latest News
 *
 * @package WordPress
 * @subpackage Basop
 * @since Basop 1.0
 */

get_header();

$news = new WP_Query( array( 'category_name' => 'latest-news', 'posts_per_page' => 10 ) );
?>

<div class="container">
	<div class="blog-content">
		<?php
		if ($news->have_posts()){
			// Start the loop.
			while ($news->have_posts()){
				$news->the_post();
				get_template_part( 'template-parts/content', 'latest-news' );
			}

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'basop' ),
				'next_text'          => __( 'Next page', 'basop' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'basop' ) . ' </span>',
				) );
		// If no content, include the "No posts found" template.
		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
		?>
	</div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
