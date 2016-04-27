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
						<li>f</li>
						<li>w</li>
						<li>k</li>
						<li>i</li>
						<li>y</li>
					</ul>
					<h3 class="script">"Bringing the big shows to the small stage"</h3>
				</div>
				<div class="footer-block right">
					<h4>Get in touch</h4>
					<address>
						Basildon Operatic Society<br />
						5 Eagerton Drive<br />
						Langdon Hills<br />
						Basildon<br />
						Essex.  SS16 6EE
					</address>
				</div>
				<p class="copyright">Copyright &copy; Basildon Operatic Society <?php date('Y');?></p>
			</div>
		</footer>

	</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/core.js"></script>

</body>
</html>
