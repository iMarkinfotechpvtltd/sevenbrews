<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 

$shop = get_option( 'woocommerce_shop_page_id' );

if( has_post_thumbnail($shop)) {
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($shop), 'large' );
	$url = $thumb['0'];
}
elseif(get_header_image()) {
	$url = get_header_image();
}
?>
		<header class="sk-fade">
		  <div class="headline" style="background:url(<?php echo esc_url($url);?>) no-repeat center center / cover;">
		    <div class="inner">
		     <h1><?php woocommerce_page_title(); ?></h1>
		       <p><?php if ( function_exists( 'get_field' )  ) { echo esc_attr(get_field('page_subtitle', $shop)); } ?></p>
		    </div>
		  </div>
		</header>
	

		
				<div class="container">
					<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
	
		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( have_posts() ) : ?>

			

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>
								
					<article class="post">
						<div class="detail sk-woo">
							<?php
								/**
								 * woocommerce_sidebar hook.
								 *
								 * @hooked woocommerce_get_sidebar - 10
								 */
								do_action( 'woocommerce_sidebar' );
							?>
						</div>
						<div class="text sk-woo">
						
							<div class="sk-count">
							<?php
								/**
								 * woocommerce_before_shop_loop hook.
								 *
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								do_action( 'woocommerce_before_shop_loop' );
							?>	
						</div>				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
	
</div>
</article>


	</div>

<?php get_footer( 'shop' ); ?>
