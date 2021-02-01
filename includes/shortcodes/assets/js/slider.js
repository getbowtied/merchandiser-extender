jQuery(function($) {

	"use strict";

	$('.shortcode_getbowtied_slider').each(function(){

		var data_id = $(this).attr('data-id');

		var mySwiper = new Swiper( '.swiper-' + data_id, {
			// Optional parameters
		    direction: 'horizontal',
		    loop: true,
		    grabCursor: true,
			preventClicks: true,
			preventClicksPropagation: true,
			parallax: true,
			autoplay: {
			    delay: 10000
			},
			speed: 600,
			effect: 'slide',
		    // If we need pagination
		    pagination: {
		    	el: '.swiper-' + data_id + ' .swiper-pagination',
				clickable: true,
				renderBullet: function (index, className) {
			        return '<span class="' + className + '">' + (index + 1) + '</span>';
			    }
		    },
		    // Navigation
		    navigation: {
			    nextEl: '.swiper-' + data_id + ' .swiper-button-next',
			    prevEl: '.swiper-' + data_id + ' .swiper-button-prev',
		  	},
		})

	})
});
