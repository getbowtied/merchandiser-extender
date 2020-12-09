<?php

// WP
include_once( dirname( __FILE__ ) . '/wp/banner.php' );
include_once( dirname( __FILE__ ) . '/wp/slider.php' );
include_once( dirname( __FILE__ ) . '/wp/title.php' );
include_once( dirname( __FILE__ ) . '/wp/blog-posts.php' );

// WC
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	include_once( dirname( __FILE__ ) . '/wc/products/recent-products.php' );
	include_once( dirname( __FILE__ ) . '/wc/products/featured-products.php' );
	include_once( dirname( __FILE__ ) . '/wc/products/sale-products.php' );
	include_once( dirname( __FILE__ ) . '/wc/products/best-selling-products.php' );
	include_once( dirname( __FILE__ ) . '/wc/products/top-rated-products.php' );
	include_once( dirname( __FILE__ ) . '/wc/products/product-by-category.php' );
	include_once( dirname( __FILE__ ) . '/wc/products/products-by-id.php' );
	include_once( dirname( __FILE__ ) . '/wc/products/products-by-attribute.php' );
	include_once( dirname( __FILE__ ) . '/wc/single-product.php' );
	include_once( dirname( __FILE__ ) . '/wc/product-categories.php' );
}

// Add Shortcodes to WP Bakery
if ( defined( 'WPB_VC_VERSION' ) ) {

	add_action( 'init', 'getbowtied_mc_visual_composer_shortcodes', 99 );
	function getbowtied_mc_visual_composer_shortcodes() {

		// Add new WP shortcodes to VC
		include_once( dirname( __FILE__ ) . '/editor/wp/banner.php' );
		include_once( dirname( __FILE__ ) . '/editor/wp/blog-posts.php' );
		include_once( dirname( __FILE__ ) . '/editor/wp/slider.php' );
		include_once( dirname( __FILE__ ) . '/editor/wp/title.php' );

		// Add new WC shortcodes to VC
		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

			include_once( dirname( __FILE__ ) . '/editor/wc/best-selling-products.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/featured-products.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/product-by-id-sku.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/product-categories.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/product-categories-grid.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/products-by-attribute.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/products-by-category.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/products-by-ids-skus.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/recent-products.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/sale-products.php' );
			include_once( dirname( __FILE__ ) . '/editor/wc/top-rated-products.php' );

		}
	}
}

add_action( 'wp_enqueue_scripts', 'getbowtied_mc_shortcodes_styles', 99 );
function getbowtied_mc_shortcodes_styles() {
	wp_register_style('merchandiser-banner-shortcode-styles',
		plugins_url( 'assets/css/wp/banner.css', __FILE__ ),
		NULL
	);

	wp_register_style('merchandiser-blog-posts-shortcode-styles',
		plugins_url( 'assets/css/wp/blog-posts.css', __FILE__ ),
		NULL
	);

	wp_register_style('merchandiser-slider-shortcode-styles',
		plugins_url( 'assets/css/wp/slider.css', __FILE__ ),
		NULL
	);

	wp_register_style('merchandiser-title-shortcode-styles',
		plugins_url( 'assets/css/wp/title.css', __FILE__ ),
		NULL
	);

	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

		wp_register_style('merchandiser-product-categories-shortcode-styles',
			plugins_url( 'assets/css/wc/product_categories.css', __FILE__ ),
			NULL
		);

		wp_register_style('merchandiser-products-list-shortcode-styles',
			plugins_url( 'assets/css/wc/products_list.css', __FILE__ ),
			NULL
		);

		wp_register_style('merchandiser-single-product-shortcode-styles',
			plugins_url( 'assets/css/wc/single_product.css', __FILE__ ),
			NULL
		);
	}
}

add_action( 'wp_enqueue_scripts', 'getbowtied_mc_shortcodes_scripts', 99 );
function getbowtied_mc_shortcodes_scripts() {

	wp_register_script('merchandiser-blog-posts-shortcode-script',
		plugins_url( 'assets/js/blog-posts.js', __FILE__ ),
		array('jquery')
	);

	wp_register_script('merchandiser-slider-shortcode-script',
		plugins_url( 'assets/js/slider.js', __FILE__ ),
		array('jquery')
	);
}
