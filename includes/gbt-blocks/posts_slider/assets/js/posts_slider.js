jQuery(function($) {
	
	"use strict";

	var sliderPerView = 2;

	var update_blog_posts_slides_per_view = function() {
	    if ( $(window).width() <= 640 ) {
			sliderPerView = 1;
		} else {
		    sliderPerView = 2;
		}
	};

	update_blog_posts_slides_per_view();

	$('.gbt_18_mc_posts_slider_container').each(function() {

		var mySwiper = new Swiper ($(this), {
			
			// Optional parameters
		    direction: 'horizontal',
		    grabCursor: true,
			preventClicks: true,
			preventClicksPropagation: true,
		    autoplay: {
			    delay: 5000,
			    disableOnInteraction: true,
		  	},
			loop: true,
			slidesPerView: sliderPerView,
			parallax: true,
		    speed: 600,
			effect: 'slide',
		    // If we need pagination
		    pagination: { 
		    	el: $(this).find('.quickview-pagination'),
		    	clickable: true 
		    },
		    // Navigation
		    navigation: {
			    nextEl: $(this).find('.swiper-button-next'),
			    prevEl: $(this).find('.swiper-button-prev'),
		  	},
		});

		$(window).on("load resize",function() {
			update_blog_posts_slides_per_view();
			mySwiper.params.slidesPerView = sliderPerView;
		});
	});
});