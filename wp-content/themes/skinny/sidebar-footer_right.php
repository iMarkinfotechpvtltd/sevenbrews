<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Skinny
 */

if ( ! is_active_sidebar( 'footer-right' ) ) {
	return;
}
?>

<aside id="footer-right" class="widget-area">
	<?php dynamic_sidebar( 'footer-right' ); ?>
</aside><!-- #secondary -->
