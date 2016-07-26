<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
		<?php 
		$tabs = apply_filters( 'woocommerce_product_tabs', array() );

		if ( ! empty( $tabs ) ) : ?>
		<ul class="tabset">
			<?php
		foreach ( $tabs as $key => $tab ) : ?>
		<li><a href="#<?php echo esc_attr( $key ); ?>_tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a></li>
			
		<?php endforeach;  ?>
	</ul>
	<?php
	endif;
	?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<div class="total">
	<span class="amount"><?php echo $product->get_price_html(); ?></span>

	<meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>
</div>