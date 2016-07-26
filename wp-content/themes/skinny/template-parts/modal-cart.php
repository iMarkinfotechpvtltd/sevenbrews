<?php
/**
 * Template part for displaying modal contents.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $woocommerce;
?>

			<section class="popup-section" id="product">
				<div class="container">
					<a href="#" class="another white sk"><span class="icon-close"></span></a>
					<?php if ( !WC()->cart->is_empty() ) : ?>
					<div class="icon-holder"><span class="icon-cart-f"></span></div>
				<?php endif; ?>
					<div class="popup">
				
		<?php  
		
	          wc_get_template_part( 'cart/mini-cart' );
	       
		
		?>
	
</div>
</section>