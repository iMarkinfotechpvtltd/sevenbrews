<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Skinny
 */

get_header(); ?>

	<main id="main" role="main">
		
		<div id="content">
			<div class="container">
		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content-single', get_post_format() );
			?>
		
			</div>
			
		</div>
		<?php

			// If comments are open or we have at least one comment, load up the comment template.
			

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->

<?php

get_footer();
