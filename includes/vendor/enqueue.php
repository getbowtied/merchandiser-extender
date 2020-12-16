<?php

$theme = wp_get_theme();
if ( $theme->template != 'merchandiser') {

	add_action( 'wp_enqueue_scripts', 'mc_extender_vendor_scripts', 99 );
	function mc_extender_vendor_scripts() {

		wp_register_style(
			'swiper',
			plugins_url( 'swiper/css/swiper.min.css', __FILE__ ),
			array(),
			'6.4.1'
		);
		wp_register_script(
			'swiper',
			plugins_url( 'swiper/js/swiper-bundle.min.js', __FILE__ ),
			'6.4.1',
			true
		);
	}
}
