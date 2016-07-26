<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
						
							<div class="column-7">
<?php do_action( 'woocommerce_before_mini_cart' ); ?>
<h3>Your Items</h3>
<table class="item-list <?php echo $args['list_class']; ?>">

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						
						<td class="image">
							<div class="image-holder">
						<?php if ( ! $_product->is_visible() ) : ?>
							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
						<?php else : ?>
							<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
							</a>
						<?php endif; ?>
					</div>
				</td>
					<td>
						<h4><?php echo $product_name; ?></h4>
							<em><?php echo WC()->cart->get_item_data( $cart_item ); ?></e,>

						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity']) . '</span>', $cart_item, $cart_item_key ); ?>
					</td>
					<td class="price">
						<?php echo $product_price ?>
					</td>
					<td class="close">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="another gray remove" title="%s" data-product_id="%s" data-product_sku="%s"><span class="icon-close"></span></a>',
							esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
							__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
					</td>
				
					<?php
				}
			}
		?>

	<?php else : ?>

		<li class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>

	<?php endif; ?>

</tr><!-- end product list -->
</table>
</div>
<div class="column-5">
	<div class="summary-block">
<?php if ( ! WC()->cart->is_empty() ) : ?>
									<h3>Cart Totals</h3>
									<table class="bill">
										<thead>
											<tbody>
											<tr>
	<th><?php _e( 'Subtotal', 'woocommerce' ); ?>:</th> <th><em><?php echo WC()->cart->get_cart_subtotal(); ?></em></th>
	
</tr>
										</tbody>
										<tfoot>
	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	</table>
	<div class="btn-group">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn btn-default inverse wc-forward"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-success wc-forward"><?php _e( 'Checkout', 'woocommerce' ); ?></a>
	</div>

<?php endif; ?>
	<?php if ( WC()->cart->is_empty() ) : ?>
	<div class="icon-holder sk-empty"><span class="icon-cart-f"></span></div>
<?php endif ?>
</div>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>
