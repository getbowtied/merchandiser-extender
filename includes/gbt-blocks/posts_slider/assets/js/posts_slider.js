jQuery(function($) {
	
	"use strict";

	$('.gbt_18_mc_posts_slider_container').each(function(i) {

		var mySwiper = new Swiper ($(this), {
		    direction: 'horizontal',
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
		    pagination: { 
		    	el: '.quickview-pagination',
		    	dynamicBullets: true,
		    	clickable: true 
		    },
		    navigation: {
			    nextEl: $('.swiper-button-next')[i],
			    prevEl: $('.swiper-button-prev')[i],
		  	},
		});
	});
});