<?php
/**
* The template for displaying the footer
*
* Contains the closing of the "off-canvas-wrap" div and all content after.
*
* @package WordPress
* @subpackage FoundationPress
* @since FoundationPress 1.0.0
* test
*/
?>
</section>
<footer>
	<?php
		global $topTwo;
		if (isset($topTwo)) {
			foreach ($topTwo as $key => $value) {
				$url = get_the_permalink($value);
				echo '<link rel="prefetch" href="' . $url . '">';
				echo '<link rel="prerender" href="'. $url .'">';
			}
		}
	?>
	<?php do_action( 'foundationpress_before_footer' ); ?>
	<div class="row collapse border">
		<div class="small-16 medium-8 columns">

				<?php
					$options = get_option('theme_options');
					if (!empty($options['logo'])) {
						echo "<div class=\"logo\">";
						echo "<a href=\"" . get_home_url() . "\">";
						echo "<img src=\"" . do_shortcode("[upload_dir]") . $options['logo'] . "\" />";
						echo "</a>";
						echo "</div>";
					}
				?>

		</div> <!-- / .small-16 -->
		<div class="small-8 medium-16 columns">
		</div><!--/.small-8-->
	</div> <!-- / .row -->

	<div class="row border">
		<div class="small-24 medium-24 columns end">
			<p>The information on this site has not been evaluated by the FDA. This product is not intended to diagnose, treat, cure or prevent any disease. Results in description and Testimonials may not be typical results and individual results may vary. All orders placed through this website are subject to acceptance, in its sole discretion.</p>
            <p id="testimonial-disclaimer">*Individual Results May Vary. Results in testimonials are atypical and results will vary on individual circumstances. We recommend all products with a healthy diet & exercise.</p>
			<ul class="footer-bar">
				<li>&copy; 2013-<?php echo date('Y');?>, <?php echo get_bloginfo('name'); ?></li>
				 <li><a href="<?php echo site_url();?>/privacy.php" data-reveal-id="docsModal" data-reveal-ajax="true">Privacy Policy</a></li>
				 <li><a href="<?php echo site_url();?>/terms.php" data-reveal-id="docsModal" data-reveal-ajax="true">Terms and Conditions</a></li>
				 <li><a href="<?php echo site_url();?>/testimonial-disclaimer.html" data-reveal-id="docsModal" data-reveal-ajax="true">Testimonial Disclaimer</a></li>
			</ul>
		</div> <!-- / .small-12 -->
	</div> <!-- / .row -->
	<div id="docsModal" class="reveal-modal medium" data-reveal>Garbage</div><!-- / #docsModal keep empty -->
	<?php do_action( 'foundationpress_after_footer' ); ?>
</footer>
<?php if ( get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
<a class="exit-off-canvas"></a>
<?php endif; ?>
<?php do_action( 'foundationpress_layout_end' ); ?>
<?php if ( get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
</div>
</div>
<?php endif; ?>
<?php wp_footer(); ?>
<?php do_action( 'foundationpress_before_closing_body' ); ?>

</body>
</html>
