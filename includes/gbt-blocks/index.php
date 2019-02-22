<?php

//==============================================================================
//	Main Editor Styles
//==============================================================================
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style(
    	'getbowtied-mc-product-blocks-editor-styles',
    	plugins_url( 'assets/css/editor.css', __FILE__ ),
    	array( 'wp-edit-blocks' )
    );
});

//==============================================================================
//	Main JS
//==============================================================================
add_action( 'admin_init', 'getbowtied_mc_product_blocks_scripts' );
if ( ! function_exists( 'getbowtied_mc_product_blocks_scripts' ) ) {
	function getbowtied_mc_product_blocks_scripts() {

		wp_enqueue_script(
			'getbowtied-mc-product-blocks-editor-scripts',
			plugins_url( 'assets/js/main.js', __FILE__ ),
			array( 'wp-blocks', 'jquery' )
		);

	}
}

//==============================================================================
//	Post Featured Image Helper
//==============================================================================
add_action('rest_api_init', 'gbt_18_mc_register_rest_post_images' );
if( !function_exists('gbt_18_mc_register_rest_post_images') ) {
    function gbt_18_mc_register_rest_post_images(){
        register_rest_field( array('post'),
            'fimg_url',
            array(
                'get_callback'    => 'gbt_18_mc_get_rest_post_featured_image',
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }
}

if( !function_exists('gbt_18_mc_get_rest_post_featured_image') ) {
    function gbt_18_mc_get_rest_post_featured_image( $object, $field_name, $request ) {
        if( $object['featured_media'] ){
            $img = wp_get_attachment_image_src( $object['featured_media'], 'app-thumb' );
            return $img[0];
        }
        return false;
    }
}

$theme = wp_get_theme();

//==============================================================================
//  Load Swiper
//==============================================================================

if ( $theme->template != 'merchandiser') {
    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    wp_enqueue_style(
        'getbowtied_swiper_styles',
        plugins_url( 'vendor/swiper/css/swiper'.$suffix.'.css', __FILE__ ),
        array(),
        filemtime(plugin_dir_path( __FILE__ ) . 'vendor/swiper/css/swiper'.$suffix.'.css')
    );
    wp_enqueue_script(
        'getbowtied_swiper_scripts',
        plugins_url( 'vendor/swiper/js/swiper'.$suffix.'.js', __FILE__ ),
        array()
    );
}

//==============================================================================
//  Load Blocks
//==============================================================================

// Merchandiser Dependent Blocks
if ( $theme->template == 'merchandiser') {
    include_once 'social_media_profiles/block.php';
}

include_once 'posts_grid/block.php';
include_once 'posts_slider/block.php';
include_once 'banner/block.php';
include_once 'slider/block.php';