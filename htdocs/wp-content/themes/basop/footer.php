<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Basop
 * @since Basop 1.0
 */
?>

		<footer>
			<div class="container">
				<div class="footer-block left">
					<h4>In association with...</h4>
					<div class="associated">
						<img src="<?php echo get_template_directory_uri();?>/img/general/noda.jpg" alt="">
						<span>National Operatic and Dramatic Association</span>
					</div>
					<div class="associated">
						<img src="<?php echo get_template_directory_uri();?>/img/general/making-music.png" alt="">
						<span>National Federation of Music Societies</span>
					</div>
				</div>
				<div class="footer-block middle">
					<ul class="social">
						<li><a href="https://www.facebook.com/BasildonOperatic/" target="_blank">f</a></li>
						<li><a href="https://twitter.com/BasOperatic" target="_blank">w</a></li>
						<li><a href="http://www.basop.org.uk" target="_blank">y</a></li>
					</ul>
					<h3 class="script">"Bringing the big shows to the small stage"</h3>
				</div>
				<div class="footer-block right">
					<?php
					if (has_nav_menu('footer'))
					{
						?>
						<nav role="navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'basop' ); ?>" id="footer-nav">
						<h4>Further Info</h4>
							<?php
							wp_nav_menu(array(
								'theme_location' => 'footer',
								'menu_class'     => 'footer-menu',
							));
							?>
						</nav>
						<?php
					}
					?>
				</div>
				<p class="copyright">Copyright &copy; Basildon Operatic Society <?php date('Y');?></p>
			</div>
		</footer>

	</div>

<script src="<?php echo get_template_directory_uri();?>/js/core.js"></script>

</body>
</html>
