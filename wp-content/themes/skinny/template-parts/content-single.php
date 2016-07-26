<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */

?>
					<article class="post">
						<div class="detail">
							<?php get_sidebar('shop'); ?>
						</div>
						<div class="text">
							<div class="image-holder">
					 		<?php if ( function_exists( 'get_field' ) && has_post_format( 'video' ) ) { ?>
					 			<div class="skinny-vid">
					 		   <?php ( wp_oembed_get( get_field( 'post_video' ), array('width'=>700)) ); ?>
					 	   </div>
					 			 <?php  
					 		} elseif ( function_exists( 'get_field' ) && has_post_format( 'gallery' ) ) {
								if (get_field('post_gallery')): ?>
									<div class="slideshow">
										<div class="slideset">
				
												<?php $images = get_field('post_gallery'); ?>
						
																<?php
																foreach ($images as $image): ?>
																<div class="slide">
																<img src="<?php
																	echo esc_attr($image['sizes']['large']); ?>" alt="<?php
																	echo esc_attr($image['alt']); ?>" />
																</div>
																	<?php
																endforeach; ?>
							                                 </div>
			
										<ul class="control-nav">
											<?php foreach ($images as $image): ?>
												<li><a href="#">-</a></li>
										<?php endforeach; ?>
										</ul>
										  </div>
								<?php endif;
									}
								 elseif( has_post_thumbnail()) { ?>
								<a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail(); ?></a>
								<?php } ?>
							</div>
							<h2><?php the_title(); ?></h2>
							<?php
								the_content( sprintf(
									/* translators: %s: Name of current post. */
									wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'skinny' ), array( 'span' => array( 'class' => array() ) ) ),
									the_title( '<span class="screen-reader-text">"', '"</span>', false )
								) );

								
								 if(is_single()) : ?>
								<footer class="entry-footer">
									<?php skinny_entry_footer(); ?>
								</footer><!-- .entry-footer -->
							<?php endif;
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
							?>
								
						<?php $defaults = array(
		'before'           => '<ul class="sk-single pagination">' . __( '', 'skinny' ),
		'after'            => '</ul>',
		'link_before'      => '<li>',
		'link_after'       => '</li>',
		'next_or_number'   => 'next',
		'separator'        => ' ',
		'nextpagelink'     => __( 'Next page', 'skinny' ),
		'previouspagelink' => __( 'Previous page', 'skinny' ),
		'pagelink'         => '%',
		'echo'             => 1
	);
 
        wp_link_pages( $defaults );?>
					
						
				</div>
					</article>