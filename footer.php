<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package likhun
 */

if( get_theme_mod('copy_text') ):
?>

	<footer class="likhun-footer">
		<div class="container">

			<div class="col-md-12">
				<div class="footer-bottom">
					<div class="row">
						<div class="col-md-5">
							<?php echo wp_kses( get_theme_mod('copy_text'), 'allowed_html' ); ?>
						</div>
						<div class="col-md-7">
							<?php /* Footer navigation */
								wp_nav_menu(
									array(
										'theme_location' => 'footer_menu',
										'depth'          => 1,
										'container'      => false,
										'menu_class'     => 'footer-nav',
										'fallback_cb'    => 'likhun_primary_menu_fallback',
										//Process nav menu using our custom nav walker
										'walker'         => new WP_Bootstrap_Navwalker(),
									)
								);
							?>
						</div>
					</div>  
					
				</div>  
			</div>

		</div>		
	</footer><!-- End Footer -->

<?php endif; /* end copyright */ wp_footer(); ?>

</div><!-- End Body -->

</body>
</html>
