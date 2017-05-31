<?php
/**
 * The template for displaying individual production information
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

		<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large'); ?>
		<?php echo page_header($image[0], get_the_title($post->ID));?>

			<div class="container">

				<div class="show-details">
					<h2>Show details</h2>
					<div class="show-details-body">
						<?php
						$date = get_post_meta($post->ID, 'date', true);
						$venue = get_post_meta($post->ID, 'venue', true);
						$ticketCost = get_post_meta($post->ID, 'ticket_cost', true);
						$boxOffice = get_post_meta($post->ID, 'box_office', true);
						$title = get_the_title($post);

						echo $title ? '<div class="details-block"><h3>Title</h3><p>' . $title . '</p></div>' : '';
						echo $date ? '<div class="details-block"><h3>When</h3><p>' . $date . '</p></div>' : '';
						echo $venue ? '<div class="details-block"><h3>Where</h3><p>' . $venue . '</p></div>' : '' ;

						$members = unserialize(get_post_meta($post->ID, 'members', true));
						$m = 0;
						foreach ($members as $mem) {
							$member = get_post($mem['member']);
							if($member != NULL) {
								$class = $m == 0 ? 'divider' : '' ;
								?>
									<div class="details-block <?php echo $class;?>">
										<h3><?php echo $mem['title'];?></h3>
										<p><a href="<?php echo $member->guid;?>" title="view the bio for <?php echo $member->post_title;?>"><?php echo $member->post_title;?></a></p>
									</div>
								<?php
								$m++;
							}
						}

						echo $boxOffice ? '<div class="details-block divider"><h3>Box Office</h3><p><a href="' . $boxOffice . '">Visit the box office to book your ticket</a></p></div>' : '' ;

						$itemName = str_replace(" ", "_", strtolower($title));
						echo $ticketCost ? add_ticket_button($title, $itemName, $ticketCost) : '' ;
						?>
					</div>
				</div>

				<div class="synopsis">
					<h2>Synopsis</h2>
					<?php the_content();?>
				</div>

				<div class="cast">
					<div class="principal-cast-list">
						<h2>Principal Cast</h2>
						<ul>
							<?php
							$characters = unserialize(get_post_meta($post->ID, 'characters', true));
							foreach ($characters as $character) {
								$castMember = get_post($character['cast_member']);
								if($castMember != NULL) {
									$headShot = get_the_post_thumbnail($castMember->ID);
									?>
									<li>
										<a href="<?php echo get_site_url() . '/' . $castMember->guid;?>" title="view the bio for <?php echo $castMember->post_title;?>">
											<?php echo $headShot;?>
											<span class="name"><?php echo $castMember->post_title;?></span>
											<span class="role"><?php echo $character['title'];?></span>
										</a>
									</li>
									<?php
								}
							}

							?>
						</ul>
					</div>
					<div class="full-cast-list" data-height-determined-by=".role">
						<h2>Full cast list</h2>
						<ul>
							<?php
							$characters = unserialize(get_post_meta($post->ID, 'secondary_characters', true));
							foreach ($characters as $character) {
								$castMember = get_post($character['cast_member']);
								if($castMember != NULL) {
									?>
									<li>
										<span class="name"><?php echo $castMember->post_title;?></span>
										<span class="role"><?php echo $character['title'];?></span>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
				</div>

				<?php
				$galleryShortcode = get_post_meta($post->ID, 'gallery', true);
				if($galleryShortcode) {
					?>
					<div id="production-gallery">
						<h2>Show Gallery</h2>
						<?php echo do_shortcode(get_post_meta($post->ID, 'gallery', true)); ?>
					</div>
					<?php
				}
				?>

			</div>

			<?php
		}
	}
	?>
	<?php get_footer(); ?>
