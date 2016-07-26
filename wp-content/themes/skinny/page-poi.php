<?php
/**
 * Template Name: POI Template
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */

$post_id = $_POST['poi_id'];
$queried_post = get_post($post_id);
$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
 ?>
			    <section class="section poi-container">
					<div class="image sk-animate" style="background-image:url(<?php echo esc_url($feat_image); ?>);"></div>
			  <div class="text">
				<div class="description animated fadeInRight">
											<div class="holder">
												<h2><?php echo esc_attr($queried_post->post_title); ?></h2>
												<p><?php echo wpautop(do_shortcode( $queried_post->post_content )); ?></p>
												
											</div>
										</div>
			  </div>
			  
			</section>