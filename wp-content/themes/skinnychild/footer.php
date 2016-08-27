<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Skinny
 */


$fclass = '';
if ( is_active_sidebar( 'footer-main' ) ) { 
	$fclass = 'fbord';
}
	?>
	
		<div class="footer-block <?php echo esc_attr($fclass); ?>">
			<?php if ( is_active_sidebar( 'footer-main' ) ) { ?>
			<aside class="footer-navigation">
				<div class="container">
					<?php get_sidebar('footer'); ?>
					<div class="subscribe-block">
						<?php get_sidebar('footer_right'); ?>
					</div>
				</div>
			</aside>
			<?php } ?>
			<footer id="footer">
				<div class="container">
					<span class="copyright"><?php $copyright = get_theme_mod( 'copyright' ) ?>
			<?php printf( esc_html__( '%1$s', 'skinny' ), $copyright ); ?></span>
			<?php
			$twitter  = get_theme_mod('twitter_text');  
			$facebook  = get_theme_mod('facebook_text');  
			$googleplus  = get_theme_mod('google1_text');  
			$dribbble  = get_theme_mod('dribbble_text');  
			$pinterest  = get_theme_mod('pinterest_text');  
			$vimeo  = get_theme_mod('vimeo_text');  
			$tumblr  = get_theme_mod('tumblr_text');  
			$youtube  = get_theme_mod('youtube_text');  
			 $stackof  = get_theme_mod('stackof_text');  
			  $instagram  = get_theme_mod('instagram_text');  
			   $linkedin  = get_theme_mod('linkedin_text'); 
			?>
					<ul class="doc">
						
							<?php if(!empty($facebook)){ ?>
								<li>
									<a href="http://facebook.com/<?php echo esc_attr($facebook);?>" target="_blank" class="facebook">
										<span class="icon-facebook"></span>
									</a>
								</li>
								<?php } ?>
							<?php if(!empty($googleplus)){ ?>
								<li>
									<a href="<?php echo esc_url($googleplus);?>" target="_blank" class="googleplus">
										<span class="icon-google-plus"></span>
									</a>
								</li>
								<?php } ?>
							<?php if(!empty($linkedin)){ ?>
								<li>
									<a href="<?php echo esc_url($linkedin);?>" target="_blank" class="linkedin">
										<span class="icon-linkedin"></span>
									</a>
								</li>
								<?php } ?>
							<?php if(!empty($pinterest)){ ?>
								<li>
									<a href="<?php echo esc_url($pinterest);?>" target="_blank" class="pinterest">
										<span class="icon-pinterest"></span>
									</a>
								</li>
                                                               
							<?php } ?>
                                                                 <li>
                                                                <a href="https://www.instagram.com/sevenbrews/" target="_blank">
                                                                    <span class="icon-instagram">instagram</span>
                                                               </a>  
                                                                </li>
                                                                <?php if(!empty($twitter)){ ?>
							<li>
								<a href="http://twitter.com/<?php echo esc_attr($twitter);?>" target="_blank" class="twitter">
									<span class="icon-twitter"></span>
								</a>
							</li>
							<?php } ?>
					</ul>
				</div>
			</footer>
		</div>
	</div>
	</div>  
<?php wp_footer(); ?>

</body>
</html>
