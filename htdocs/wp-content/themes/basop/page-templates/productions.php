<?php
/**
 * Template Name: Productions
 */
get_header();


if (have_posts()) {
	while (have_posts()) {
		the_post();

        // Output page header
		$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		?>
		<?php echo page_header($image[0], get_the_title($post->ID));?>

		<div class="container">

			<?php
			echo get_post_meta($post->ID, 'opening_wording')[0];

			$productions = new Productions();

			if($productions) {
				?>
				<ul class="production-archive" data-height-determined-by="|.copy-container">
					<?php
					foreach($productions->get_production_archive() as $prod) {
						?>
						<li>
							<div class="image-container">
								<a href="/productions/<?php echo $prod['slug'];?>" class="full-details">
									<img src="<?php echo $prod['imgSrc'];?>" />
								</a>
							</div>
							<div class="copy-container">
								<h3><?php echo $prod['title'];?></h3>
								<p><?php echo $prod['short_description'];?></p>
							</div>
							<div class="production-details">
								<p><strong>Venue:</strong><?php echo $prod['venue'];?></p>
								<p><strong>Date:</strong><?php echo $prod['date'];?></p>
								<p><strong>Director:</strong><?php echo $prod['director'];?></p>
							</div>
							<a href="<?php echo get_site_url();?>/productions/<?php echo $prod['slug'];?>" class="full-details">full details</a>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
			}
			?>
		</div>
		<div class="container">
			<?php
			the_content();
			?>
		</div>
		<?php
	}
}

get_footer();?>
