<?php
if (have_rows('pb_content')):
	// loop through the rows of Data
	while (have_rows('pb_content')):
		the_row();
    
		if (get_row_layout() == 'block_content'):
			
	 	   $sclass='';
	 	   if(get_sub_field('light_nav') == 1) {
	 		   $sclass = 'sk-light';
	 	   }
			?>
				<section class="white-section br_editor sk-section <?php echo esc_attr($sclass); ?>" <?php if(get_sub_field('id')) { ?>
		  id="<?php echo esc_attr(get_sub_field('id')); ?>"
					<?php } ?>>
				<div class="center-holder">
					<?php echo get_sub_field('editor_content'); ?>
				</div>
			</section>
	      <?php
		  
		   // COLUMNS
		  
  		elseif (get_row_layout() == 'column_content'):if (get_sub_field('columns')):
	 	   $sclass='';
	 	   if(get_sub_field('light_nav') == 1) {
	 		   $sclass = 'sk-light';
	 	   }
  			?>
  				<section class="white-section br_editor sk-section <?php echo esc_attr($sclass); ?>" <?php if(get_sub_field('id')) { ?>
		  id="<?php echo esc_attr(get_sub_field('id')); ?>"
					<?php } ?>>
  				<div class="skinny-content skinny-cols">
						<?php 	while (has_sub_field('columns')): ?>
							<div class="skinny-col">
  					<?php echo wp_kses_post(get_sub_field('editor_columns')); ?>
				</div>
					<?php endwhile;
					endif; ?>
  				</div>
  			</section>
  	      <?php
												
		
	// ACCORDION
	
	elseif (get_row_layout() == 'accordion_content'):if (get_sub_field('ac_tab')): 
 	   $sclass='';
 	   if(get_sub_field('light_nav') == 1) {
 		   $sclass = 'sk-light';
 	   }
		?>
    <section <?php if(get_sub_field('id')) { ?>
	  id="<?php echo esc_attr(get_sub_field('id')); ?>"
				<?php } ?> class="white-section sk-section <?php echo esc_attr($sclass); ?>">
				<ul class="accordion">
					<?php
					while (has_sub_field('ac_tab')): ?>
					<li>
						<a><?php
							echo esc_attr(get_sub_field('title')); ?></a>
							
								<?php
									echo wp_kses_post(get_sub_field('text')); ?>
								
							</li>
							<?php
						endwhile; ?>
					</ul></section>
					<?php
				endif; ?>
			
				<?php
				
				
				// CONTACT
	
				elseif (get_row_layout() == 'contact_form'): 
					$top      = get_sub_field('padding_top');
					$bottom      = get_sub_field('padding_bottom');
			 	   $sclass='';
			 	   if(get_sub_field('light_nav') == 1) {
			 		   $sclass = 'sk-light';
			 	   }
					?>
			    <section <?php if(get_sub_field('id')) { ?>
				  id="<?php echo esc_attr(get_sub_field('id')); ?>"
							<?php } ?> class="white-section br_editor sk-section <?php echo esc_attr($sclass); ?>" style="padding-top:<?php echo esc_attr($top); ?>px; padding-bottom:<?php echo esc_attr($bottom); ?>px;">
							<div class="skinny-form-holder">
						<div class="skinny-contact-form">
								<?php
								$dv_form = get_sub_field('dv_select_form');
								
								 echo do_shortcode( '[contact-form-7 title="'.$dv_form.'"]' ); ?>
						
								 
						</div>
					</div>
				
				</section>
						<?php 

						$location = get_sub_field('location');

						if( !empty($location) ):
						?>
						<section sk-section>
						<div class="skinny-map">
							<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>" data-color="#36b1da" >
							<h4><?php esc_attr(the_sub_field('title')); ?></h4>
							<p class="address"><?php echo esc_attr($location['address']); ?></p>
							<?php esc_attr(the_sub_field('text')); ?>
							</div>
						</div>
					</section>
						<?php endif; ?>
			
			
			<style type="text/css">

			.skinny-map {
				width: 100%;
				height: 400px;
			}

			/* fixes potential theme css conflict */
			.skinny-map img {
			   max-width: inherit !important;
			}

			</style>
			<?php $sk_api = esc_attr(get_theme_mod('gmap')); ?>
		
			<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $sk_api; ?>&callback=initMap"></script>
			<script type="text/javascript">
			(function($) {

			/*
			*  new_map
			*
			*  This function will render a Google Map onto the selected jQuery element
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	4.3.0
			*
			*  @param	$el (jQuery element)
			*  @return	n/a
			*/

			function render_map( $el ) {
	
				// var
				var $markers = $el.find('.marker');
			    var dragging = true;

			      
				// vars
				var args = {
					zoom		: 16,
					draggable: dragging,
					scrollwheel: false,
					center		: new google.maps.LatLng(0, 0),
					mapTypeId	: google.maps.MapTypeId.ROADMAP,
		            styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#d6f3f9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
        
				};
	
				// create map	        	
				var map = new google.maps.Map( $el[0], args);
	
	
				// add a markers reference
				map.markers = [];
	
	
				// add markers
				$markers.each(function(){
		
			    	add_marker( $(this), map );
		
				});
	
	
				// center map
				center_map( map );
	
	
				
	
			}
			
			// create info window outside of each - then tell that singular infowindow to swap content based on click
			var infowindow = new google.maps.InfoWindow({
			content		: '' 
			});

			/*
			*  add_marker
			*
			*  This function will add a marker to the selected Google Map
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	4.3.0
			*
			*  @param	$marker (jQuery element)
			*  @param	map (Google Map object)
			*  @return	n/a
			*/

			function add_marker( $marker, map ) {

				// var
				var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
				var color = $marker.attr('data-color');
				var mark = pin;
				var icon = {
		            path: mark,
				    fillColor: color,
				    fillOpacity: .8,
				    strokeWeight: 0,
				    scale: .9
				}
				// create marker
				var marker = new google.maps.Marker({
					position	: latlng,
					map			: map,
					icon		: icon,
				});

				// add to array
				map.markers.push( marker );

				// if marker contains HTML, add it to an infoWindow
				if( $marker.html() )
				{
	
	
	

					// show info window when marker is clicked & close other markers
					google.maps.event.addListener(marker, 'click', function() {
						//swap content of that singular infowindow
								infowindow.setContent($marker.html());
						        infowindow.open(map, marker);
					});
	
					// close info window when map is clicked
					     google.maps.event.addListener(map, 'click', function(event) {
					        if (infowindow) {
					            infowindow.close(); }
							}); 
			
		
				}

				}
			/*
			*  center_map
			*
			*  This function will center the map, showing all markers attached to this map
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	4.3.0
			*
			*  @param	map (Google Map object)
			*  @return	n/a
			*/

			function center_map( map ) {

				// vars
				var bounds = new google.maps.LatLngBounds();

				// loop through all markers and create bounds
				$.each( map.markers, function( i, marker ){

					var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

					bounds.extend( latlng );

				});

				// only 1 marker?
				if( map.markers.length == 1 )
				{
					// set center of map
				    map.setCenter( bounds.getCenter() );
				    map.setZoom( 16 );
				}
				else
				{
					// fit to bounds
					map.fitBounds( bounds );
				}

			}

			/*
			*  document ready
			*
			*  This function will render each map when the document is ready (page has loaded)
			*
			*  @type	function
			*  @date	8/11/2013
			*  @since	5.0.0
			*
			*  @param	n/a
			*  @return	n/a
			*/
			// global var
			var map = null;

			$(document).ready(function(){

				$('.skinny-map').each(function(){

					// create map
					render_map( $(this) );

				});

			});

			})(jQuery);
			</script>
							<?php
		
		// FEATURES
		
		elseif (get_row_layout() == 'stats_content'):if (get_sub_field('stat')): 
	 	   $sclass='';
	 	   if(get_sub_field('light_nav') == 1) {
	 		   $sclass = 'sk-light';
	 	   }
			?>
		<section class="section sk-section <?php echo esc_attr($sclass); ?>"  <?php if(get_sub_field('id')) { ?>
				  id="<?php echo esc_attr(get_sub_field('id')); ?>"
							<?php } ?>>
			<div class="holder">
				<div class="container">
					<div class="feature-list">
						<?php
						  while (has_sub_field('stat')): 
							?>
						<div class="feature skinny-sr">
							<div class="icon-holder"><span class="<?php
								echo esc_attr(get_sub_field('icon')); ?>"></span></div>
							<div class="desc">
								<h3><a href="#"><?php
								echo esc_attr(get_sub_field('title')); ?></a></h3>
								<p><?php
									echo esc_attr(get_sub_field('text')); ?></p>
							</div>
						</div>
								<?php
							endwhile; ?>
							<?php
						endif; ?>
					</div>
				</div>
			</div>
		</section>
		

		<?php
	
	//SLIDER
	
	elseif (get_row_layout() == 'slider'):if (get_sub_field('slide')): 
 	   $sclass='';
 	   if(get_sub_field('light_nav') == 1) {
 		   $sclass = 'sk-light';
 	   }
		?>
	
<div class="sk-section skinny slideshow <?php echo esc_attr($sclass); ?>">
	<div class="mask">
		<?php while (has_sub_field('slide')): 
				$slide_img = get_sub_field('image');
				$imgsize = 'full';
				?>
			<div class="slide win-height">
				<div class="bg-stretch sk-dim">
					
					<?php echo wp_get_attachment_image( $slide_img, $imgsize ); ?>
					
				</div>
				<div class="caption">
					<div class="holder">
						<h1><?php echo esc_attr(get_sub_field('text')); ?></h1>
						<em class="slogan"><?php echo esc_attr(get_sub_field('subtext')); ?></em>
						<?php if (get_sub_field('buttons')): 
							?>
						<div class="btn-group">
							<?php while (has_sub_field('buttons')): 
								if (get_sub_field('highlight')) {
									$btn_class = 'btn-primary';
								} else {
									$btn_class = 'btn-default';
								}
								?>
							<a href="<?php echo esc_url(get_sub_field('link')); ?>" class="btn <?php echo esc_attr($btn_class); ?>"><?php echo esc_attr(get_sub_field('text')); ?></a>
						<?php endwhile; ?>
							
						</div>
					<?php endif; ?>
					</div>
				</div>
			</div>
			<?php  
		 endwhile; ?>
				
		
	</div>
	<?php if(count( get_sub_field( 'slide' )) > 1) { ?>
	<a class="btn-prev" href="#"><span class="icon-arrow-prev"></span></a>
	<a class="btn-next" href="#"><span class="icon-arrow-next"></span></a>
	<ul class="control-nav">
		<?php while (has_sub_field('slide')): ?>
			<li><a href="#">-</a></li>
	<?php endwhile; ?>
	</ul>
	
	<?php
}
endif;?>
</div>
  
	   
   <?php
   
	//BIG VIDEO
	
	elseif (get_row_layout() == 'hero_header'):  
 	   $sclass='';
 	   if(get_sub_field('light_nav') == 1) {
 		   $sclass = 'sk-light';
 	   }
		?>
	</div>
<div class="sk-section skinny slideshow <?php echo esc_attr($sclass); ?>" id="video-bg">
	<div class="mask">
		<?php 
				$image = get_sub_field('image');
				$imgsize = 'full';
				?>
			<div class="slide win-height">
				<div class="bg-stretch sk-dim">
				
				        <?php  if (get_sub_field('video')): ?>
	 
				        <video autoplay loop muted id="video-background">
							
				   		  <?php while (has_sub_field('video')):  ?>
							  
							 <source type="video/<?php echo esc_attr(get_sub_field('file_type')); ?>" src="<?php echo esc_url(get_sub_field('url')); ?>"/>
      
				   	   <?php endwhile;?>  
				        </video>
	   			   	
						 <?php  if (get_sub_field('image')) { ?>
						<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="skinny-cover">
						<?php } endif;
					?>
					
				</div>
				<div class="caption">
					<div class="holder">
						<h1><?php echo esc_attr(get_sub_field('heading')); ?></h1>
						<em class="slogan"><?php echo esc_attr(get_sub_field('subheading')); ?></em>
							<?php if (get_sub_field('add_button')): 
								?>
							<div class="btn-group">
								<?php while (has_sub_field('add_button')): 
									if (get_sub_field('highlight')) {
										$btn_class = 'btn-primary';
									} else {
										$btn_class = 'btn-default';
									}
									?>
								<a href="<?php echo esc_url(get_sub_field('url')); ?>" class="btn <?php echo esc_attr($btn_class); ?>"><?php echo esc_attr(get_sub_field('text')); ?></a>
							<?php endwhile; ?>
							
							</div>
						<?php endif; ?>
							
						</div>
					
					</div>
				</div>
			</div>
			
				
		
	</div>
	
	

</div>
   <div>
	<?php
	//SPLIT BANNER
	
	elseif (get_row_layout() == 'split_banner'):
		$banner_img = get_sub_field('image');
		$imgsize = 'large';
		$imgsizebot = 'pg-developer-jumbotron';
		$imgvalues = get_sub_field('side');
		$identifier = rand(1, 299);
		$alignment ='right';
		if(in_array("left", $imgvalues )): 
			$alignment = 'left'?>
		<?php endif;
		$sk_left = get_sub_field('left');
		$sk_top = get_sub_field('top');
	   $pclass='';
	   if((get_sub_field('background') == 'image') || ((get_sub_field('background') == 'color') && (get_sub_field('color')))){
		   $pclass = 'bg';
	   }
	   $sclass='';
	   if(get_sub_field('light_nav') == 1) {
		   $sclass = 'sk-light';
	   }
	if(get_sub_field('background') == 'image') { 
		$btn = 'default';
	} else {
		$btn = 'primary';
	}
		?>
		
		<section class="section sk-section <?php echo esc_attr($pclass); ?><?php echo esc_attr($sclass); ?>" style="background-color:<?php echo esc_attr(get_sub_field('color')); ?>;" <?php if(get_sub_field('id')) { ?>
	  id="<?php echo esc_attr(get_sub_field('id')); ?>"
				<?php } ?>>
				<?php if(get_sub_field('background') == 'image') { 
					?>
				<div class="bg-stretch">
					<img src="<?php echo esc_attr(get_sub_field('sc_image')); ?>" alt="background">
				</div>
				<?php } ?>
			<div class="holder">
				<div class="container">
					
					<div class="image-holder skinny-sr <?php echo esc_attr($alignment); ?> <?php 
							echo esc_attr(get_sub_field('animate')); ?>" style="background-color:<?php echo esc_attr(get_sub_field('color')); ?>;">
							 <?php if (get_sub_field('overlay_image')): ?>
							<div class="sk-overlay-blend" style="background-image: url('<?php echo esc_url(get_sub_field('overlay_image')); ?>');"></div>
						<?php endif; ?>
						<?php echo wp_get_attachment_image( $banner_img, $imgsize ); 
						
				 	   
					   if (get_sub_field('poi')):
			   		 while (has_sub_field('poi')): 
						 $proLink = get_sub_field('link_to_product');
			   				$sk_left = get_sub_field('left');
			   				$sk_top = get_sub_field('top');
			   				
					   ?>
						<a href="#" data-modal="poi" data-content="<?php echo esc_attr($proLink); ?>" class="another skinny-sr" style="left:<?php echo esc_attr($sk_left); ?>%;top:<?php echo esc_attr($sk_top); ?>%;"><span class="icon-plus" ></span></a>
						<?php endwhile;
					endif;
						 ?>
				 	</div>
					<div class="description">
						<div class="holder">
							<h2><?php echo esc_attr(get_sub_field('title')); ?></h2>
							<?php echo wp_kses_post(get_sub_field('text')); ?>
							<?php if(get_sub_field('button_text')) : ?>
							<a class="btn btn-<?php echo esc_attr($btn); ?>" href="<?php echo esc_url(get_sub_field('button_link')); ?>" ><?php 
							echo esc_attr(get_sub_field('button_text')); ?></a>
						<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<?php 
		
		//PARALLAX
	
		elseif (get_row_layout() == 'parallax'): 
	 	   $sclass='';
	 	   if(get_sub_field('light_nav') == 1) {
	 		   $sclass = 'sk-light';
	 	   }
		   ?>
	
		<section class="section sk-section bg <?php echo esc_attr($sclass); ?>" <?php if(get_sub_field('id')) { ?>
		  id="<?php echo esc_attr(get_sub_field('id')); ?>"
					<?php } ?>>
				<div class="bg-stretch parallax-section" style="background-image: url(<?php echo esc_attr(get_sub_field('sc_image')); ?>)">
					
				</div>
				<div class="holder">
					<div class="container">
						<div class="description">
							<div class="holder">
								<div class="icon-holder">
									<span class="<?php echo esc_attr(get_sub_field('icon')); ?>"></span>
								</div>
								<h2><?php
			echo esc_attr(get_sub_field('title')); ?></h2>
								<p><?php echo esc_attr(get_sub_field('sub_title')); ?></p>
								<?php if(get_sub_field('button_text')) : ?>
								<a href="<?php echo esc_url(get_sub_field('button_link')); ?>" class="btn btn-default"><?php 
					echo esc_attr(get_sub_field('button_text')); ?></a>
				<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</section>
	
		<?php
		
		// PRODUCT IMAGES
		
		elseif (get_row_layout() == 'product_images'):if (get_sub_field('add_image')):
	 	   $sclass='';
	 	   if(get_sub_field('light_nav') == 1) {
	 		   $sclass = 'sk-light';
	 	   }
			?>
	<section class="section gray sk-section <?php echo esc_attr($sclass); ?>" <?php if(get_sub_field('id')) { ?>
				  id="<?php echo esc_attr(get_sub_field('id')); ?>"
							<?php } ?>>
		<div class="holder">
			<div class="container">
				<div class="description">
					<div class="holder">
						<h2 class="sk-squeek"><?php echo esc_attr(get_sub_field('title')); ?></h2>
						<p><em class="slogan"><?php echo esc_attr(get_sub_field('subtext')); ?></em></p>
						<div class="image-list">
							 <?php while (has_sub_field('add_image')):  ?>
							<div class="image-block skinny-sr"><a href="<?php echo esc_url(get_sub_field('image_link')); ?>"><img src="<?php echo esc_attr(get_sub_field('image')); ?>" alt="product"></a></div>
							
						<?php endwhile; ?>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
			<?php endif; ?>	
	
	<?php
		// HEADINGS
				
	elseif (get_row_layout() == 'heading_block'):
		$size       = get_sub_field('size');
		$color     = get_sub_field('color');
		$sub_size       = get_sub_field('sub_size');
		$sub_color       = get_sub_field('sub_color');
		$line_size       = get_sub_field('line_size');
		$position       = get_sub_field('alignment');
		$heading_text       = get_sub_field('text');
		$heading_subtext      = get_sub_field('subtext');
		$top      = get_sub_field('padding_top');
		$bottom      = get_sub_field('padding_bottom');
 	   $sclass='';
 	   if(get_sub_field('light_nav') == 1) {
 		   $sclass = 'sk-light';
 	   }
		?>
	    <section class="sk-section <?php echo esc_attr($sclass); ?>" <?php if(get_sub_field('id')) { ?>
		  id="<?php echo esc_attr(get_sub_field('id')); ?>"
					<?php } ?> style="background-color:<?php echo esc_attr(get_sub_field('bg_color')); ?>;background-image:url('<?php echo esc_attr(get_sub_field('background_image')); ?>');">
		<div class="white-section br_editor pg-developer-heading" style="text-align:<?php echo esc_attr($position); ?>; padding-top=:<?php echo esc_attr($top); ?>; padding-bottom:<?php echo esc_attr($bottom); ?>; ">
			<?php 

			$icona = get_sub_field('icon_upload');

			if( !empty($icona) ) { ?>

				<img src="<?php echo esc_url($icona['url']); ?>" alt="<?php echo esc_attr($icona['alt']); ?>" data-sr="move 16px scale up 20%, over 2s">

				<?php } else { ?>
				<span class="icon fa <?php
					echo esc_attr(get_sub_field('icon')); ?>"></span>
				<?php } ?>
		<h2 style="font-size:<?php echo esc_attr($size); ?>px;color:<?php echo esc_attr($color); ?>;"><?php echo esc_attr($heading_text); ?></h2>
		<span style="font-size:<?php echo esc_attr($sub_size); ?>px;line-height:<?php echo esc_attr($line_size);?>px;color:<?php echo esc_attr($sub_color); ?>;"><?php echo esc_attr(wp_strip_all_tags($heading_subtext)); ?></span>
	</div>
	</section>
		<?php	
		
		// SKINNY BANNER
				
	elseif (get_row_layout() == 'skinny_banner'):
 	   $sclass='';
 	   if(get_sub_field('light_nav') == 1) {
 		   $sclass = 'sk-light';
 	   }
		?>
	<div class="banner sk-section <?php echo esc_attr($sclass); ?>" style="background-color:<?php echo esc_attr(get_sub_field('color')); ?>;">
		<span class="title" style="color:<?php echo get_sub_field('font_color'); ?>;"><?php echo esc_attr(get_sub_field('title')); ?></span>
	</div>
	
	<?php
	             	

endif; ?>
 <?php
endwhile; else :
// no layouts found
endif;

?> 