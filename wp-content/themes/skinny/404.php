<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
		    <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found', 'skinny' ); ?></h1>
			  ?>
		    </div>
		  </div>
		</header>
			<main id="main" role="main">
		
				<div id="content">
					<div class="container">
						<div class="error-404">
	
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'skinny' ); ?></p>

					<?php
						get_search_form();

						the_widget( 'WP_Widget_Recent_Posts' );

						// Only show the widget if site has multiple categories.
						if ( skinny_categorized_blog() ) :
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'skinny' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->

					<?php
						endif;

						/* translators: %1$s: smiley */
						$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'skinny' ), convert_smilies( ':)' ) ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

						the_widget( 'WP_Widget_Tag_Cloud' );
					?>
				</div>
</div>
			</div>
	
				</main><!-- #main -->
			

<?php
get_footer();
