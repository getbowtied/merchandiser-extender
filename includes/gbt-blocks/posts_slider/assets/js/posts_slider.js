jQuery(function($) {
	
	"use strict";

	$('.gbt_18_mc_posts_slider_container').each(function() {

		var mySwiper = new Swiper ($(this), {
			
			// Optional parameters
		    direction: 'horizontal',
		    grabCursor: true,
			preventClicks: true,
			preventClicksPropagation: true,
		    autoplay: {
			    delay: 5000
		  	},
			loop: true,
			slidesPerView: 2,
			breakpoints: {
				640: {
			      slidesPerView: 1,
			    }
			},
			parallax: true,
		    speed: 600,
			effect: 'slide',
		    // If we need pagination
		    pagination: { 
		    	el: '.quickview-pagination',
		    	clickable: true 
		    },
		    // Navigation
		    navigation: {
			    nextEl: '.swiper-button-next',
			    prevEl: '.swiper-button-prev',
		  	},
		});
	});
});