<?php

// WP
include_once( dirname( __FILE__ ) . '/wp/banner.php' );
include_once( dirname( __FILE__ ) . '/wp/slider.php' );
include_once( dirname( __FILE__ ) . '/wp/title.php' );
include_once( dirname( __FILE__ ) . '/wp/blog-posts.php' );

// WC
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	include_once( dirname( __FILE__ ) . '/wc/recent-products-list.php' );
	include_once( dirname( __FILE__ ) . '/wc/featured-products-list.php' );
	include_once( dirname( __FILE__ ) . '/wc/sale-products-list.php' );
	include_once( dirname( __FILE__ ) . '/wc/best-selling-products-list.php' );
	include_once( dirname( __FILE__ ) . '/wc/top-rated-products-list.php' );
	include_once( dirname( __FILE__ ) . '/wc/product-category-list.php' );
	include_once( dirname( __FILE__ ) . '/wc/products-list.php' );
	include_once( dirname( __FILE__ ) . '/wc/products-by-attribute-list.php' );
	include_once( dirname( __FILE__ ) . '/wc/single-product.php' );
	include_once( dirname( __FILE__ ) . '/wc/product-categories.php' );
}

// Mixed
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	include_once( dirname( __FILE__ ) . '/mixed/recent-products-mixed.php' );
	include_once( dirname( __FILE__ ) . '/mixed/featured-products-mixed.php' );
	include_once( dirname( __FILE__ ) . '/mixed/sale-products-mixed.php' );
	include_once( dirname( __FILE__ ) . '/mixed/best-selling-products-mixed.php' );
	include_once( dirname( __FILE__ ) . '/mixed/top-rated-products-mixed.php' );
	include_once( dirname( __FILE__ ) . '/mixed/product-category-mixed.php' );
	include_once( dirname( __FILE__ ) . '/mixed/products-mixed.php' );
	include_once( dirname( __FILE__ ) . '/mixed/products-by-attribute-mixed.php' );
}
include_once( dirname( __FILE__ ) . '/mixed/blog-posts-mixed.php' );

// Add Shortcodes to WP Bakery
if ( defined( 'WPB_VC_VERSION' ) ) {
	
	add_action( 'init', 'getbowtied_mc_visual_composer_shortcodes', 99 );
	function getbowtied_mc_visual_composer_shortcodes() {
		
		// Add new WP shortcodes to VC
		include_once( dirname( __FILE__ ) . '/wb/wp/banner.php' );
		include_once( dirname( __FILE__ ) . '/wb/wp/blog-posts.php' );
		include_once( dirname( __FILE__ ) . '/wb/wp/slider.php' );
		include_once( dirname( __FILE__ ) . '/wb/wp/title.php' );
		
		// Add new WC shortcodes to VC
		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			
			include_once( dirname( __FILE__ ) . '/wb/wc/best-selling-products.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/featured-products.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/product-by-id-sku.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/product-categories.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/product-categories-grid.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/products-by-attribute.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/products-by-category.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/products-by-ids-skus.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/recent-products.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/sale-products.php' );
			include_once( dirname( __FILE__ ) . '/wb/wc/top-rated-products.php' );

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

	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		wp_enqueue_script('merchandiser-product-gutter-script', 
			plugins_url( 'assets/js/product-list-gutter.js', __FILE__ ),
			array('jquery')
		);
	}
}