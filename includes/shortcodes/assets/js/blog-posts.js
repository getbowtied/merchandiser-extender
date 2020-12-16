jQuery(function($) {

	"use strict";

	if ($('.shortcode_getbowtied_blog_posts').length > 0) {

		$('.shortcode_getbowtied_blog_posts').each(function(){

			var data_id = $(this).attr('data-id');

			window.blog_posts = new Swiper( '.swiper-' + data_id, {
				// Optional parameters
			    direction: 'horizontal',
			    loop: true,
			    grabCursor: true,
				preventClicks: true,
				preventClicksPropagation: true,
				parallax: true,
				autoplay: {
				    delay: 10000,
			  	},
				speed: 600,
				effect: 'slide',
				slidesPerView: 2,
				breakpoints: {
					0: {
				      slidesPerView: 1,
				  },
					640: {
				      slidesPerView: 2,
				    }
				},
			    // If we need pagination
			    pagination: {
			    	el: '.swiper-' + data_id + ' .quickview-pagination',
			    	clickable: true
			    },
			    // Navigation
			    navigation: {
				    nextEl: '.swiper-' + data_id + ' .swiper-button-next',
				    prevEl: '.swiper-' + data_id + ' .swiper-button-prev',
			  	},
			});
		});
	}
});
