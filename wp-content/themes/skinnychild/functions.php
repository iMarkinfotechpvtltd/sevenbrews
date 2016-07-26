<?php
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style';

   wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style )
    );
    wp_enqueue_script( 'skinny-main', get_template_directory_uri() . '/js/jquery.skinny.js', array('jquery'), '20160303', true );
    if(!is_single()){
    wp_enqueue_script( 'skinny-child', get_stylesheet_directory_uri() . '/js/custom-jquery.js', array('jquery'), '20160303', true );
    }}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function pippin_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return $attachment[0]; 
}
?>