jQuery(window).scroll(function() {
 var scrollTop = jQuery(this).scrollTop();
 if(scrollTop==0)
  {
    $nav.removeClass('scrolled');   
  }
  });