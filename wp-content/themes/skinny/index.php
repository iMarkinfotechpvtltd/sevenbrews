<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */

get_header(); 
$url = '';
if( has_post_thumbnail('page_for_posts')) {
	
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_option( 'page_for_posts')), 'large' );
	$url = $thumb['0'];
}
elseif (get_header_image()) {
	$url = get_header_image();
}

?>
		<header class="sk-fade">
		  <div class="headline" style="background:url(<?php echo esc_url($url);?>) no-repeat center center / cover;">
		    <div class="inner">
				<?php if ( is_home() && ! is_front_page() ) { ?>
					
						<h1><?php single_post_title(); ?></h1>
					

				<?php
			} else { ?>
					
					<h1 class="entry-title"><?php _e('Latest Posts','skinny'); ?></h1>
					
					<?php } ?>
		     
	   	  <?php if ( function_exists( 'get_field' ) ) : ?>
	         <p><?php echo esc_attr(get_field('page_subtitle')); ?></p>
	           <?php endif; ?>
		    </div>
		  </div>
		</header>
		
		
	<main id="main">
		
		<div id="content">
			<div class="container">

		<?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;
			
			

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
				</div>
				
				<?php skinny_paging_nav(); ?>
				
	</div><!-- #primary -->
	
		</main><!-- #main -->
	

<?php
//get_sidebar();
get_footer();
