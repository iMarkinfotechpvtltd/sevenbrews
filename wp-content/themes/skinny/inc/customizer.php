<?php
/**
 * Skinny Theme Customizer.
 *
 * @package Skinny
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function skinny_customize_register( $wp_customize ) {
	
	$wp_customize->add_section( 'sk_logo', array(
	    'priority'       => 10,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => 'Logo',
	    'description'    => '',
	) );

	   //Logo Image
	   $wp_customize->add_setting( 'logo_image', array( 
	   	'sanitize_callback' => 'esc_url_raw',
	   ) );

	   $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_image', array(
	   	'label' => esc_html__( 'Logo Upload', 'skinny' ),
	   	'section' => 'sk_logo',
	   	'settings' => 'logo_image'
	
	   ) ) );
		
 	   //Light Logo Image
 	   $wp_customize->add_setting( 'logo_image_light', array( 
 	   	'sanitize_callback' => 'esc_url_raw',
 	   ) );

 	   $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_image_light', array(
 	   	'label' => esc_html__( 'Logo Upload (for light background)', 'skinny' ),
 	   	'section' => 'sk_logo',
 	   	'settings' => 'logo_image_light'
	
 	   ) ) );

	   	//Highlight Color
	     $wp_customize->add_setting( 'highlight_color', array(
	   	'default' => '#3997ab',
	   	'sanitize_callback' => 'sanitize_hex_color',
	     ) );
	

	
	   	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'highlight_color', array(
	   		'label'   => esc_html__( 'Site Colour', 'skinny' ),
	   		'section' => 'colors',
	   		'settings'   => 'highlight_color',
		
	   	) ) );
			
			
		   	//Nav Color
		     $wp_customize->add_setting( 'menu_color', array(
		   	'default' => 'smart',
		   	'sanitize_callback' => 'esc_attr',
		   	) );



		   	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'menu_color', array(
		   		'label'   => esc_html__( 'Menu Style', 'skinny' ),
		   		'section' => 'colors',
		   		'settings'   => 'menu_color',
				'type'     => 'radio',
						'choices'  => array(
							'smart'  => 'Smart Colour Switch (default)',
							'dark' => 'Dark Background',
						),
	
		   	) ) );
				
			   	//Footer Color
			     $wp_customize->add_setting( 'footer_color', array(
			   	'default' => '#ffffff',
			   	'sanitize_callback' => 'sanitize_hex_color',
			   	) );
	

	
			   	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color', array(
			   		'label'   => esc_html__( 'Footer Background Colour', 'skinny' ),
			   		'section' => 'colors',
			   		'settings'   => 'footer_color'
		
			   	) ) );
					
					   	//Text Color Footer
					     $wp_customize->add_setting( 'text_color_footer', array(
					   	'default' => '',
					   	'sanitize_callback' => 'sanitize_hex_color',
					   	) );
	

	
					   	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color_footer', array(
					   		'label'   => esc_html__( 'Footer Text Colour', 'skinny' ),
					   		'section' => 'colors',
					   		'settings'   => 'text_color_footer'
		
					   	) ) );
							
				   	     
							
							
							$wp_customize->add_section( 'sk_footer_options', array(
							    'priority'       => 180,
							    'capability'     => 'edit_theme_options',
							    'theme_supports' => '',
							    'title'          => 'Footer',
							    'description'    => '',
							) );
	
							//Copyright
						  $wp_customize->add_setting( 'copyright', array(
							  'default' => 'All Rights Reserved.',
							  'sanitize_callback' => 'esc_attr',
							) );
	

	
							$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'copyright', array(
								'label'   => esc_html__( 'Copyright', 'skinny' ),
								'section' => 'sk_footer_options',
								'settings'   => 'copyright',
				
							    )));
								
				
								//Social Settings
								$wp_customize->add_section( 'sk_social_options', array(
								    'priority'       => 170,
								    'capability'     => 'edit_theme_options',
								    'theme_supports' => '',
								    'title'          => 'Social Links',
								    'description'    => '',
								) );
	
								$wp_customize->add_setting( 'twitter_text', array(
									'default' => '',
									'sanitize_callback' => 'esc_attr',
									 'priority' => 1
								) );
	
								$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'twitter_text', array(
									'label'   => esc_html__( 'Twitter username', 'skinny' ),
									'section' => 'sk_social_options',
									'settings'   => 'twitter_text',
		
								) ) );
	
	
								$wp_customize->add_setting( 'facebook_text', array(
									'default' => '',
									'sanitize_callback' => 'esc_attr',
									 'priority' => 2
								) );
	
								$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'facebook_text', array(
									'label'   => esc_html__( 'Facebook username', 'skinny' ),
									'section' => 'sk_social_options',
									'settings'   => 'facebook_text',
		
								) ) );
	
								$wp_customize->add_setting( 'pinterest_text', array(
									'default' => '',
									'sanitize_callback' => 'esc_url_raw',
									 'priority' => 3
								) );
	
								$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'pinterest_text', array(
									'label'   => esc_html__( 'Pinterest url', 'skinny' ),
									'section' => 'sk_social_options',
									'settings'   => 'pinterest_text',
		
								) ) );
	
								$wp_customize->add_setting( 'google1_text', array(
									'default' => '',
									'sanitize_callback' => 'esc_url_raw',
									 'priority' => 4
								) );
								
								$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'google1_text', array(
									'label'   => esc_html__( 'Google+ url', 'skinny' ),
									'section' => 'sk_social_options',
									'settings'   => 'google1_text',
		
								) ) );
	
								$wp_customize->add_setting( 'linkedin_text', array(
									'default' => '',
									'sanitize_callback' => 'esc_url_raw',
									 'priority' => 1
								) );
	
								$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'linkedin_text', array(
									'label'   => esc_html__( 'LinkedIn url', 'skinny' ),
									'section' => 'sk_social_options',
									'settings'   => 'linkedin_text',
		
								) ) );
								
								//Google Maps
								
								$wp_customize->add_section( 'sk_map_options', array(
								    'priority'       => 190,
								    'capability'     => 'edit_theme_options',
								    'theme_supports' => '',
								    'title'          => 'Google Maps',
								    'description'    => 'Google Map API key now required to use map feature.',
								) );
	
								
							  $wp_customize->add_setting( 'gmap', array(
								  'default' => '',
								  'sanitize_callback' => 'esc_attr',
								) );
	

	
								$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gmap', array(
									'label'   => esc_html__( 'Map API', 'skinny' ),
									'section' => 'sk_map_options',
									'settings'   => 'gmap',
				
								    )));
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->remove_control( 'header_textcolor');
	$wp_customize->remove_section( 'background_image');
	$wp_customize->remove_control( 'background_color');
}
add_action( 'customize_register', 'skinny_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function skinny_customize_preview_js() {
	wp_enqueue_script( 'skinny_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'skinny_customize_preview_js' );
