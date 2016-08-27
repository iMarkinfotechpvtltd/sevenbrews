
initLoadModal();

function initLoadModal() {
jQuery( function() {
    jQuery( '[data-modal]').on( 'click', function( e ) {
    	e.preventDefault();
	    jQuery( '.sk-loader-bg' ).addClass('show');
		var modal = jQuery( this ).data( 'modal' );
	    var poiID = jQuery( this ).data( 'content' );
			loadModal( modal, poiID );
  	
	
    } );
	var loadModal = function( modal, poiID ) {
		
			jQuery.post(
				sk_modals.ajax_url,
				{
					action: 'load_modal',
					modal:  modal,
					poi_id: poiID
				},
				/* Handle the response! */
				function ( response ) {
				
					if ( 0 != response ) {
					
						modal = jQuery.parseHTML( response );
					
						/* Add the modal to the body. */
						jQuery( 'body' ).append( modal );
					
						/* Take various actions when the modal is added.
					    $form = jQuery( '.product-type-variable').find( '.variations_form' );
					         if ($form) {
					   	$form.wc_variation_form();
					         } */
							 
						jQuery( 'body' ).addClass( 'popup-active' );
						jQuery( '.popup-section .another.white.sk' ).on( 'click', function( e ) {
									 e.preventDefault();
									 jQuery( 'body' ).removeClass( 'popup-active' );
									 jQuery( '.popup-section' ).remove();
									 jQuery( '.sk-loader-bg' ).removeClass('show');
								 } );
							    
		 			}
				
				}
			);
		
		}
		
});
}
jQuery(document).ready(function($) {
	$(document).on('click', '.single_add_to_cart_button', function() {
		
		if($(this).hasClass('product_type_variable')) return true;
		
		var context = this;
		
		var form = $(this).closest('form');
		
		$(this).addClass('thinking');
		
		$.ajax( {
			type: 'POST',
			url: form.attr( 'action' ),
			data: form.serialize(),
			success: function( response ) 
			{
				updateCartButtons(response);
				$(context).removeClass('thinking');
				$(context).addClass('complete');
				$(context).replaceWith( '<a href="'+getCartUrl()+'" class="btn btn-primary complete" data-poiID="">View Cart</a>' );
				
				if($(response).find('.woocommerce-error').length > 0) 
				{
					var div_to_insert = getMessageParentDiv(response, 'woocommerce-error');
					
					if($(document).find('.woocommerce-error').length > 0)
					{
						$(document).find('.woocommerce-error').fadeOut(500, function() {
							$(document).find('.woocommerce-error').remove();
							$(div_to_insert).before($(response).find('.woocommerce-error').wrap('<div>').parent().html()).fadeIn();
						});
					}
					else
					{
						$(div_to_insert).before($(response).find('.woocommerce-error').wrap('<div>').parent().html());
					}
				}
				
			}
		} );
		
		return false;
	});
	
	
	
	
	function getCartUrl() 
	{
		return sk_modals.cart_url;
	}
	
	function getCartButtons() 
	{
		return $('a[href="'+getCartUrl()+'"]:visible');
	}
	
	function updateCartButtons(new_source) 
	{
		
		var cart_buttons_length = getCartButtons().length;

		if(cart_buttons_length > 0)
		{
			getCartButtons().each(function(index) {
				if($(new_source).find('a[href="'+getCartUrl()+'"]:visible').eq(index).length > 0)
				{
					$(this).replaceWith($(new_source).find('a[href="'+getCartUrl()+'"]:visible').eq(index));
				}
			});
		}
		
		$supports_html5 = ( 'sessionStorage' in window && window['sessionStorage'] !== null );
		$fragment_refresh = {
			url: woocommerce_params.ajax_url,
			type: 'POST',
			data: { action: 'woocommerce_get_refreshed_fragments' },
			success: function( data ) {
				if ( data && data.fragments ) {

					$.each( data.fragments, function( key, value ) {
						$(key).replaceWith(value);
					});

					if ( $supports_html5 ) {
						sessionStorage.setItem( 'wc_fragments', JSON.stringify( data.fragments ) );
						sessionStorage.setItem( 'wc_cart_hash', data.cart_hash );
					}

					$('body').trigger( 'wc_fragments_refreshed' );
					
					/* Take various actions when the modal is added.
				    $form = jQuery( '.product-type-variable').find( '.variations_form' );
				         if ($form) {
				   	$form.wc_variation_form();
				         } 
					initTabs();
					initCustomForms();*/
				}
			}
		};

		$.ajax($fragment_refresh);
		
	}
	//initLoadModal();
});