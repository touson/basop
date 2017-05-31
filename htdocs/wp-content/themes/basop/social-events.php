<?php
/**
 * Template Name: Social Events
 *
 * @package WordPress
 * @subpackage Basop
 * @since Basop 1.0
 */

get_header();

$events = new WP_Query( array( 'category_name' => 'social-events', 'posts_per_page' => 10 ) );
?>

<div class="container">
	<div class="blog-content">
		<?php
		if ($events->have_posts()){
			// Start the loop.
			while ($events->have_posts()){
				$events->the_post();
				get_template_part( 'template-parts/content', 'social-events' );
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
