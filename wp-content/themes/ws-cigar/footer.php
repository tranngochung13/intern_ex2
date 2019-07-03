<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage WS theme
 * @since WS theme 1.0
 */


?>




		</div><!-- .site-content -->


	</div><!-- .site-inner -->
	    <!-- footer -->
    <div id="main-footer" class="main-footer">

    	<div class="container">

	        <!-- 1/3 -->
	        <div class="columns">
	            <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('footer-1-widget') ) ?>
	        </div>
	        <!-- /End 1/3 -->
	        <!-- 2/3 -->
	        <div class="columns">
	            <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('footer-2-widget') ) ?>
	        </div>
	        <!-- /End 2/3 -->
	        <!-- 3/3 -->
	        <div class="columns">
	            <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('footer-3-widget') ) ?>
	        </div>
	        <!-- /End 3/3 -->
	    </div> <!-- /End container -->

    </div>
    <!-- /End Footer -->


		<footer id="colophon" class="site-footer" role="contentinfo">
            <?php
				{
				?>
				<div class="footer-custom-code">
						<?php
						dynamic_sidebar('custom-footer');
						?>	
				</div>
				<?php	
				}
			?>
			<div class="site-info">
				<?php
					/**
					 * Fires before the ltheme footer text for footer customization.
					 *
					 * @since Ltheme 1.0
					 */
					do_action( 'ltheme_credits' );
				?>
		

			    <div class="lt-footer">
			        <p class="lt-footer-left"><a href="https://wooskins.com/free-woocommerce-wordpress-themes/" target="_blank" title="Free WooCommerce Wordpress themes">Free WooCommerce Wordpress themes</a>  by <a href="https://wooskins.com" target="_blank" title="Free WooCommerce themes">WooSkins</a>
			        </p>
			    </div>

			</div><!-- .site-info -->
		</footer><!-- .site-footer -->

<?php wp_footer(); ?>

</div><!-- .site -->
</body>
</html>
