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

		<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full'); ?>
		<div class="page-header" style="background-image:url(<?php echo $image[0];?>"></div>

			<div class="container">

				<div class="show-details">
					<h2>Show details</h2>
					<div class="show-details-body">
						<?php
						$date = get_post_meta($post->ID, 'date', true);
						$venue = get_post_meta($post->ID, 'venue', true);
						$director = get_post_meta($post->ID, 'director', true);

						echo get_the_title($post) ? '<div class="details-block"><h3>Title</h3><p>' . get_the_title($post) . '</p></div>' : '';
						echo $date ? '<div class="details-block"><h3>When</h3><p>' . $date . '</p></div>' : '';
						echo $venue ? '<div class="details-block"><h3>Where</h3><p>' . $venue . '</p></div>' : '' ;
						echo $director ? '<div class="details-block"><h3>Director</h3><p>' . $director . '</p></div>' : '' ;
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
										<a href="<?php echo $castMember->guid;?>" title="view the bio for <?php echo $castMember->post_title;?>">
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
					<div class="full-cast-list">
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

			</div>

			<?php
		}
	}
	?>
	<?php get_footer(); ?>
