<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */

get_header(); 
if(get_header_image()) {
	$url = get_header_image();
}
?>
	
		<header class="sk-fade">
		  <div class="headline" style="background:url(<?php echo esc_url($url);?>) no-repeat center center / cover;">
		    <div class="inner">
		     <?php the_archive_title( '<h1>','</h1>' ); 
		      the_archive_description( '<p>', '</p>' );
			  ?>
		    </div>
		  </div>
		</header>
			<main id="main" role="main">
		
				<div id="content">
					<div class="container">
					
	
		<?php
		if ( have_posts() ) : ?>
		
		
				<div class="post">
					<div class="detail">
							<?php get_sidebar(); ?>
						</div>
						<div class="text">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content-search', get_post_format() );

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
	
