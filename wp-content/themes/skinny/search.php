<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
		    <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'skinny' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content-search' );

			endwhile;

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
					</div>
				
					<?php skinny_paging_nav(); ?>
				
		</div><!-- #primary -->
	
			</main><!-- #main -->

<?php
get_footer();
