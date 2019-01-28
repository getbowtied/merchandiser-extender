jQuery(function($) {
	
	"use strict";

	$('.gbt_18_mc_slider_container').each(function() {

		var mySwiper = new Swiper ($(this), {
			
			// Optional parameters
		    direction: 'horizontal',
		    grabCursor: true,
			preventClicks: true,
			preventClicksPropagation: true,
		    autoplay: {
			    delay: 10000,
		  	},
			loop: true,
			parallax: true,
		    speed: 600,
			effect: 'slide',
		    // If we need pagination
		    pagination: { 
		    	el: $(this).find('.gbt_18_mc_slider_pagination'),
		    	clickable: true 
		    },
		    // Navigation
		    navigation: {
			    nextEl: $(this).find('.gbt_18_mc_slider_button_next'),
			    prevEl: $(this).find('.gbt_18_mc_slider_button_prev'),
		  	},
		});
	});
});