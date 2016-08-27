<?php
/**
 * The header for our theme.
 *
 * @package Skinny
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="sk-loader-bg"> <div class="sk-loader"></div></div>
	<div id="wrapper">
		<div class="content-block">
			 <?php if(get_theme_mod('menu_color') == 'dark') {
				 $sk_menu_color = 'sk-dark-nav';
			 } 
			 elseif (get_theme_mod('menu_color') == 'light') {
				 $sk_menu_color = 'sk-light-nav';
			 }
			 else {
				 $sk_menu_color = 'sk-smart-nav';
			 }
			 ?>
			<header id="header" class="sk-light <?php echo esc_attr($sk_menu_color); ?> <?php if(is_single()) { ?> scrolled<?php } ?>" >
				<div class="header-holder">
					<div class="logo">
						 <?php $sk_logo  = get_theme_mod('logo_image'); 
				          if(!empty($sk_logo)) { ?>
				 	       <a href="<?php echo esc_url(home_url('/')); ?>"> <img class="a sk-dd" src="<?php echo esc_attr($sk_logo);?>" alt=""> </a>
						    <?php $sk_logo_light  = get_theme_mod('logo_image_light'); ?>
							<a href="<?php echo esc_url(home_url('/')); ?>"> <img class="a sk-ll" src="<?php echo esc_attr($sk_logo_light);?>" alt=""> </a>
				 	       <?php }
				 	   		 else { ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php } ?>
					</div>
			
					<a href="#" class="nav-opener"><span></span></a>
					<?php if ( class_exists( 'WooCommerce' ) )  { ?>
                                                <a href="<?php if(WC()->cart->get_cart_contents_count()){ echo get_permalink(7);} else{ echo '#'; } ?>" class="cart-opener" data-modal="cart" data-productid=""><span class="icon-cart"></span><span class="counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span></a>
						<?php } ?>
				    
				       <div class="skinny-menu-container">
						   <?php if ( has_nav_menu( 'primary' ) ) { ?>
							<?php wp_nav_menu( array( 'container' => 'div', 'container_class' => 'skinny-menu', 'menu_id' => 'primary-menu', 'theme_location' => 'primary' ) ); ?>
							<?php } else { ?>
							<?php wp_nav_menu( array('menu_class' => 'skinny-menu') ); ?>
							<?php } ?>
						</div>
				</div>
			</header>