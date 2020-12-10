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
				0: {
			    	slidesPerView: 1,
			  	},
			  	768: {
					slidesPerView: 2,
				}
			},
		    pagination: {
		    	el: $('.gbt_18_mc_posts_pagination')[i],
		    	clickable: true,
				renderBullet: function (index, className) {
			        return '<span class="' + className + '">' + (index + 1) + '</span>';
			    }
		    },
		    navigation: {
			    nextEl: $('.swiper-button-next')[i],
			    prevEl: $('.swiper-button-prev')[i],
		  	},
		});
	});
});
