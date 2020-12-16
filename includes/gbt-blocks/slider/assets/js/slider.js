jQuery(function($) {

	"use strict";

	function mc_generate_slider_unique_ID() {
		return Math.round(new Date().getTime() + (Math.random() * 100));
	}

	$('.gbt_18_mc_slider_wrapper .gbt_18_mc_slider_container').each(function(i) {
		var data_id = mc_generate_slider_unique_ID();
		$(this).addClass( 'swiper-' + data_id );

		var mySwiper = new Swiper( '.swiper-' + data_id, {
		    direction: 'horizontal',
		    grabCursor: true,
		    autoplay: {
			    delay: 10000,
		  	},
			loop: true,
		    speed: 600,
			effect: 'slide',
		    pagination: {
		    	el: '.swiper-' + data_id + ' .gbt_18_mc_slider_pagination',
		    	clickable: true,
				renderBullet: function (index, className) {
			        return '<span class="' + className + '">' + (index + 1) + '</span>';
			    }
		    },
		    navigation: {
			    nextEl: '.swiper-' + data_id + ' .gbt_18_mc_slider_button_next',
			    prevEl: '.swiper-' + data_id + ' .gbt_18_mc_slider_button_prev',
		  	},
		});
	});
});
