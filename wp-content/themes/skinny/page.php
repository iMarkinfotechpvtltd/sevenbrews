<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */

get_header();

if( has_post_thumbnail()) {
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
	$url = $thumb['0'];
}
elseif(get_header_image()) {
	$url = get_header_image();
}
?>
	
		<header class="sk-fade">
		  <div class="headline" style="background:url(<?php echo esc_url($url);?>) no-repeat center center / cover;">
		    <div class="inner">
		     <?php the_title( '<h1>','</h1>' ); ?>
		      <p><?php if ( function_exists( 'get_field' )  ) { echo esc_attr(get_field('page_subtitle')); } ?></p>
		    </div>
		  </div>
		</header>
						
	
	<main id="main">
		<div id="content">
				<div class="holder">
					<div id="sk-woo">
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) : ?>
				<div class="container">
					<?php comments_template(); ?>
				</div>
				<?php
				endif;

			endwhile; // End of the loop.
			?>
				</div>
				
					<?php
					if (function_exists('sk_custom_breadcrumbs')) {
					    sk_custom_breadcrumbs();
					}
					?>
				
		</div>
</div>
</main><!-- #main -->

<?php
get_footer();
