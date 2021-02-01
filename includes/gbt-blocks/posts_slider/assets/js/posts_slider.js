jQuery(function($) {

	"use strict";

	$('.gbt_18_mc_posts_slider_container').each(function(i) {

		var data_id = $(this).attr('data-id');

		var mySwiper = new Swiper( '.swiper-' + data_id, {
		    direction: 'horizontal',
		    autoplay: {
			    delay: 5000
		  	},
			loop: true,
			slidesPerView: 2,
			slidesPerGroup: 2,
			breakpoints: {
				0: {
			    	slidesPerView: 1,
					slidesPerGroup: 1,
			  	},
			  	768: {
					slidesPerView: 2,
					slidesPerGroup: 2,
				}
			},
		    pagination: {
		    	el: '.swiper-' + data_id + ' .gbt_18_mc_posts_pagination',
		    	clickable: true,
				renderBullet: function (index, className) {
			        return '<span class="' + className + '">' + (index + 1) + '</span>';
			    }
		    },
		    navigation: {
			    nextEl: '.swiper-' + data_id + ' .swiper-button-next',
			    prevEl: '.swiper-' + data_id + ' .swiper-button-prev',
		  	},
		});
	});
});
