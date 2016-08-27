<?php
/**
 * Skinny functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Skinny
 */

if ( ! function_exists( 'skinny_setup' ) ) :
	
/*--------------------------*
/* Theme Setup
/*--------------------------*/
	
function skinny_setup() {
	
	load_theme_textdomain( 'skinny', get_template_directory() . '/languages' );
	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
    add_image_size('skinny-header', 1024, 678, true);

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'skinny' ),
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'post-formats', array(
		'gallery',
		'video',
	) );

}
endif;
add_action( 'after_setup_theme', 'skinny_setup' );

function skinny_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'skinny_content_width', 640 );
}
add_action( 'after_setup_theme', 'skinny_content_width', 0 );

/*--------------------------*
/* Register Widget Areas
/*--------------------------*/

function skinny_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'skinny' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'skinny' ),
		'id'            => 'footer-main',
		'before_widget' => '<nav id="%1$s" class="footer-nav widget %2$s">',
		'after_widget'  => '</nav>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'skinny' ),
		'id'            => 'footer-right',
		'before_widget' => '<nav id="%1$s" class="footer-nav widget %2$s">',
		'after_widget'  => '</nav>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'skinny' ),
		'id'            => 'shop',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'skinny_widgets_init' );

/*--------------------------*
/* Register Fonts
/*--------------------------*/

function skinny_fonts_url() {
$font_url = '';

if ( 'off' !== _x( 'on', 'Google font: on or off', 'skinny' ) ) {
    $font_url = add_query_arg( 'family', urlencode( 'Open Sans:300,400&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
}
return $font_url;
}

/*--------------------------*
/* Enqueue Scripts/Styles
/*--------------------------*/

function skinny_scripts() {
	wp_enqueue_style( 'skinny-style', get_stylesheet_uri() );
	wp_enqueue_script( 'skinny-main', get_template_directory_uri() . '/js/jquery.skinny.js', array('jquery'), '20160303', true );
	$site_parameters = array(
	    'site_url' => get_site_url(),
	    'theme_directory' => get_template_directory_uri()
	    );
	wp_localize_script( 'skinny-main', 'SiteParameters', $site_parameters );
 if ( class_exists( 'WooCommerce' ) )  {
	wp_enqueue_script( 'wc-add-to-cart-variation', plugins_url() . '/woocommerce/assets/js/frontend/add-to-cart-variation.min.js', array('jquery'), '2.4.8', true );
}
	wp_enqueue_script( 'skinny-ajax', get_template_directory_uri() . '/js/sk-ajax.js', array('jquery') );
	if ( class_exists( 'WooCommerce' ) )  {
global $woocommerce;
$cart_url = $woocommerce->cart->get_cart_url();
} else {
$cart_url = '';
}

	    wp_localize_script( 'skinny-ajax', 'sk_modals',
	            array(
					 'ajax_url' => admin_url( 'admin-ajax.php' ),
			         'cart_url' => $cart_url,
			));
		

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'scroll-reveal', get_template_directory_uri() . '/js/scrollreveal.min.js', array('jquery'), '20160303', false );
	wp_enqueue_style( 'skinny-fonts', skinny_fonts_url(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'skinny_scripts' );

/*--------------------------*
/* Enqueue Admin Scripts/Styles
/*--------------------------*/

function skinny_admin_scripts_loader($hook){
    if(in_array($hook,array("post-new.php","post.php","edit.php"))) {
		wp_enqueue_style('skinny-style', get_template_directory_uri() . '/admin/css/jquery.fonticonpicker.min.css');
		wp_enqueue_style('skinny-theme-style', get_template_directory_uri() . '/admin/css/themes/grey-theme/jquery.fonticonpicker.grey.min.css');
		wp_enqueue_style('skinny-icons', get_template_directory_uri() . '/admin/css/icomoon.css');
        wp_enqueue_script('skinnyscript', get_template_directory_uri() . '/admin/js/jquery.fonticonpicker.min.js', array('jquery'), '20160303', false );
		wp_enqueue_script('skinny-icon-script', get_template_directory_uri() . '/admin/js/icon-select.js', array('jquery'), '20160303', false );
	 }
}
add_action("admin_enqueue_scripts","skinny_admin_scripts_loader");

/*--------------------------*
/* Custom Header
/*--------------------------*/

require get_template_directory() . '/inc/custom-header.php';

/*--------------------------*
/* Custom Template Tags
/*--------------------------*/

require get_template_directory() . '/inc/template-tags.php';

/*--------------------------*
/* Custom Independant Functions
/*--------------------------*/

require get_template_directory() . '/inc/extras.php';

/*--------------------------*
/* Customizer
/*--------------------------*/

require get_template_directory() . '/inc/customizer.php';

/*--------------------------*
/* Plugins
/*--------------------------*/

require get_template_directory() . '/inc/plugins/plugin.php';

/*--------------------------*
/* Jetpack Compatibility
/*--------------------------*/

require get_template_directory() . '/inc/jetpack.php';

/*--------------------------*
/* Custom Fields
/*--------------------------*/

$value= '';
require get_template_directory() . '/inc/custom-fields.php';


add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
	
}

/*--------------------------*
/* Map API
/*--------------------------*/

function sk_acf_init() {
	$dv_map_api = get_theme_mod('gmap');
	acf_update_setting('google_api_key', $sk_map_api);
}

add_action('acf/init', 'sk_acf_init');

/*--------------------------*
/* Page Builder Contact Form Select
/*--------------------------*/

function skinny_acf_load_contact_field( $field )
{
	// Reset choices
	$field['choices'] = array();
 
	$post_type = 'wpcf7_contact_form';
	
	$args = array (
		'post_type' => $post_type,
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
	);
	
	$contact_forms = get_posts($args);
	
	$choices = array();
	foreach( $contact_forms as $form) {
		$choices[$form->ID] = strip_tags($form->post_title);
	}
	// loop through array and add to field 'choices'
	if( is_array($choices) )
	{
		$field['choices']['none'] = 'none';
		foreach( $choices as $choice )
		{
			$field['choices'][ $choice ] = $choice;
		}
	}
 
    // Important: return the field
    return $field;
}
 
add_filter('acf/load_field/name=dv_select_form', 'skinny_acf_load_contact_field');

/*--------------------------*
/* Get POI pages
/*--------------------------*/ 
  
  add_filter('acf/fields/post_object/query/name=link_to_product', 'skinny_relationship_query', 10, 3);
  function skinny_relationship_query($args, $field, $post) {
      
	  // show only pages with this special template
	 	    $args['meta_key'] = '_wp_page_template';
	 	    $args['meta_value'] = 'page-poi.php';
	 	    return $args;
      
  }
  
/*--------------------------*
/* Ajax Modals
/*--------------------------*/

function skinny_ajax_load_modal() {
	  global $wpdb, $woocommerce;
	 
	ob_start();
  
	get_template_part( 'template-parts/modal', $_POST['modal'] );
	
	$modal = ob_get_clean();
	
	if ( $modal ) {
		
		echo $modal;
		
	} else {
		echo 0;
	}
	
	die();
}
add_action( 'wp_ajax_load_modal',  'skinny_ajax_load_modal' );
add_action( 'wp_ajax_nopriv_load_modal', 'skinny_ajax_load_modal' );

/*--------------------------*
/* Admin Styles
/*--------------------------*/
function skinny_customizer_css()
{
	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/css/custom-style.css' );
	
   require_once get_template_directory() . '/inc/custom-styles.php';


wp_add_inline_style( 'custom-style', $custom_inline_style );

}
	
add_action( 'wp_enqueue_scripts', 'skinny_customizer_css');

function skinny_admin_css() {
    wp_enqueue_style('pg-developer-admin-style', get_template_directory_uri() . '/css/admin-style.css');
}
add_action('admin_enqueue_scripts', 'skinny_admin_css');

/*--------------------------*
/* Woocommerce Hooks/Actions
/*--------------------------*/
if(  function_exists ( 'is_woocommerce' )) {
	
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

add_action( 'wp_enqueue_scripts', 'skinny_wp_enqueue_scripts_for_frontend', 99 );
function skinny_wp_enqueue_scripts_for_frontend(){
    if( is_checkout() ){
   }
  }
  add_action( 'wp_enqueue_scripts', 'skinny_dequeue_stylesandscripts', 100 );

  function skinny_dequeue_stylesandscripts() {
      if ( class_exists( 'woocommerce' ) ) {
          wp_dequeue_style( 'select2' );
          wp_deregister_style( 'select2' );

          wp_dequeue_script( 'select2');
          wp_deregister_script('select2');

      } 
  }
  
  function woocommerce_remove_sidebar_shop() {
      if( is_product() )
         remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
  }
  add_action( 'template_redirect', 'woocommerce_remove_sidebar_shop' );
  
  remove_action( 'woocommerce_cart_collaterals',
  'woocommerce_cross_sell_display' );
  add_action ('woocommerce_after_cart_table', 'woocommerce_cross_sell_display' );
  
  add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'mmx_remove_select_text');
  function mmx_remove_select_text( $args ){
      $args['show_option_none'] = '';
      return $args;
  }
  
/*--------------------------*
/* Custom Tabs
/*--------------------------*/

function skinny_custom_product_tab( $tabs ) {
   
    $custom_tab = array( 
      		'custom_tab' =>  array( 
    							'title' => __('Accessories', 'woocommerce'), 
    							'priority' => 12, 
    							'callback' => 'skinny_custom_product_tab_content' 
    						)
    				);
				    global $product;
				    $crosssells = get_post_meta( get_the_ID(), '_crosssell_ids',true);
				    if ( 0 != sizeof( $crosssells ) ) {
						return array_merge( $custom_tab, $tabs );
					} else {
						return ($tabs);
					}
}

function skinny_custom_product_tab_content() {
	
	
	wc_get_template_part( 'cart/cross-sells' );
	?>
	
<?php

}

add_filter( 'woocommerce_product_tabs', 'skinny_custom_product_tab' );


function skinny_rename_tabs( $tabs ) {

	$tabs['description']['title'] = __( 'Details', 'skinny' );		// Rename the description tab

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'skinny_rename_tabs', 98 );


/*--------------------------*
/* Cart Thumbnails
/*--------------------------*/

function skinny_cart_item_thumbnail( $thumb, $cart_item, $cart_item_key ) { 

 $product = get_product( $cart_item['product_id'] );
 return $product->get_image( 'cart_item_image_size' ); 
 } 
 
add_image_size( 'cart_item_image_size', 90, 90, true );
add_filter( 'woocommerce_cart_item_thumbnail', 'skinny_cart_item_thumbnail', 10, 3 );

/*--------------------------*
/* Ajax Cart
/*--------------------------*/

  add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

  function woocommerce_header_add_to_cart_fragment( $fragments ) {
  	ob_start();
  	?>
  <span class="counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
  	<?php
	
  	$fragments['.counter'] = ob_get_clean();
	
  	return $fragments;
	 
  }
  
/*--------------------------*
/* WooCommerce Check
/*--------------------------*/
  
  function skinny_woocommerce () {
          if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                  return true;
          }
          $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                          "woocommerce_terms_page_id" ,
                                          "woocommerce_cart_page_id" ,
                                          "woocommerce_checkout_page_id" ,
                                          "woocommerce_pay_page_id" ,
                                          "woocommerce_thanks_page_id" ,
                                          "woocommerce_myaccount_page_id" ,
                                          "woocommerce_edit_address_page_id" ,
                                          "woocommerce_view_order_page_id" ,
                                          "woocommerce_change_password_page_id" ,
                                          "woocommerce_logout_page_id" ,
                                          "woocommerce_lost_password_page_id" ) ;
          foreach ( $woocommerce_keys as $wc_page_id ) {
                  if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                          return true ;
                  }
          }
          return false;
  }
}

/*--------------------------*
/* More Link
/*--------------------------*/

function new_excerpt_more($more) {
       global $post;
	return '<a class="moretag" href="'. get_permalink($post->ID) . '">&nbsp;  Read more &#10141; </a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

/*--------------------------*
/* Yoast SEO Extension
/*--------------------------*/

function merchant_yoastseo_acf() {
	wp_enqueue_script( 'acf_yoastseo', get_template_directory_uri() . '/js/acf_yoastseo.js', 'jquery' );
}

add_action( 'admin_init', 'merchant_yoastseo_acf' );
