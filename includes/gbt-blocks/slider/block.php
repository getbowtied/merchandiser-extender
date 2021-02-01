<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Enqueue Editor Assets
 */
add_action( 'enqueue_block_editor_assets', 'merchandiser_extender_slider_editor_assets' );
function merchandiser_extender_slider_editor_assets() {

	wp_register_script(
		'merchandiser-extender-slide-editor-script',
		plugins_url( 'blocks/slide.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element' )
	);

	wp_register_script(
		'merchandiser-extender-slider-editor-script',
		plugins_url( 'blocks/slider.js', __FILE__ ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element' )
	);

	wp_register_style(
		'merchandiser-extender-slider-editor-styles',
		plugins_url( 'assets/css/backend/editor.css', __FILE__ ),
		array( 'wp-edit-blocks' )
	);
}

/**
 * Enqueue Frontend Assets
 */
add_action( 'enqueue_block_assets', 'merchandiser_extender_slider_assets' );
function merchandiser_extender_slider_assets() {

	if( function_exists( 'mc_extender_vendor_scripts' ) ) {
		mc_extender_vendor_scripts();
	}

	wp_enqueue_style( 'swiper' );
	wp_enqueue_script( 'swiper' );

	wp_register_style(
		'merchandiser-extender-slider-styles',
		plugins_url( 'assets/css/frontend/style.css', __FILE__ ),
		array()
	);

	wp_register_script(
		'merchandiser-extender-slider-scripts',
		plugins_url( 'assets/js/slider.js', __FILE__ ),
		array( 'jquery' )
	);
}

/**
 * Register Block
 */
register_block_type( 'getbowtied/mc-slider', array(
	'editor_style'		=> 'merchandiser-extender-slider-editor-styles',
 	'editor_script'		=> 'merchandiser-extender-slider-editor-script',
 	'style'				=> 'merchandiser-extender-slider-styles',
	'script'			=> 'merchandiser-extender-slider-scripts',
));

register_block_type( 'getbowtied/mc-slide', array(
   'editor_script'		=> 'merchandiser-extender-slide-editor-script',
));
