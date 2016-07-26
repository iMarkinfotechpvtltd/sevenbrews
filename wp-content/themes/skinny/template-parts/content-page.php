<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


<?php 
if ( function_exists( 'get_field' )  ) {
			get_template_part( 'template-parts/content', 'pb' );
			?>
			<?php if ( class_exists( 'WooCommerce' ) && skinny_woocommerce())  { ?>
					<div class="holder">
					<div class="container">
						<?php
			 the_content();
			  ?>
		</div>
		</div>
		<?php }
		} else { ?>
			
				<div class="holder">
				<div class="container">
					<?php
		 the_content();
		  ?>
	</div>
	</div>
	
	<?php } ?>
</article><!-- #post-## -->
