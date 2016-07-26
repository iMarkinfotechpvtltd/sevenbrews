<?php
/**
 * Template Name: Blank Template
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */
get_header(); ?>
	
	<main id="main">
		<div id="content">
			<section>
				<div class="holder">
					
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
				</div>
				
					<?php
					if (function_exists('sk_custom_breadcrumbs')) {
					    sk_custom_breadcrumbs();
					}
					?>
				
				
		
	
		</section>
	</div><!-- content -->
</main><!-- #main -->

<?php
get_footer();
