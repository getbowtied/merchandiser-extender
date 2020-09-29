jQuery(function($) {

	"use strict";

	$('.gbt_18_mc_slider_container').each(function(i) {

		var mySwiper = new Swiper ($(this), {
		    direction: 'horizontal',
		    grabCursor: true,
		    autoplay: {
			    delay: 10000,
		  	},
			loop: true,
		    speed: 600,
			effect: 'slide',
		    pagination: {
		    	el: $('.gbt_18_mc_slider_pagination')[i],
		    	clickable: true,
				renderBullet: function (index, className) {
			        return '<span class="' + className + '">' + (index + 1) + '</span>';
			    }
		    },
		    navigation: {
			    nextEl: $('.gbt_18_mc_slider_button_next')[i],
			    prevEl: $('.gbt_18_mc_slider_button_prev')[i],
		  	},
		});
	});
});
