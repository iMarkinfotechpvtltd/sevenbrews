<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skinny
 */

?>
					<article>
						
						
							<div class="image-holder"><?php the_post_thumbnail(); ?></div>
							<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
							<?php if ( 'post' === get_post_type() ) : ?>
							<div class="entry-meta">
								<?php skinny_posted_on(); ?>
							</div><!-- .entry-meta -->
							<?php endif; ?>
							<?php the_excerpt(); ?>
						
						<footer class="entry-footer">
							<?php skinny_entry_footer(); ?>
						</footer><!-- .entry-footer -->
				
					</article>
					
