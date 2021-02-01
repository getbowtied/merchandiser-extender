<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Enqueue Editor Assets
 */
add_action( 'enqueue_block_editor_assets', 'merchandiser_extender_banner_editor_assets' );
function merchandiser_extender_banner_editor_assets() {

	wp_register_script(
		'merchandiser-extender-banner-editor-scripts',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-components', 'wp-editor', 'wp-i18n', 'wp-element' )
	);

	wp_register_style(
		'merchandiser-extender-banner-editor-styles',
		plugins_url( 'assets/css/editor.css', __FILE__ ),
		array( 'wp-edit-blocks' )
	);
}

/**
 * Enqueue Frontend Assets
 */
add_action( 'enqueue_block_assets', 'merchandiser_extender_banner_assets' );
function merchandiser_extender_banner_assets() {

	wp_register_style(
		'merchandiser-extender-banner-styles',
		plugins_url( 'assets/css/style.css', __FILE__ ),
		array()
	);
}

/**
 * Register Block
 */
register_block_type( 'getbowtied/mc-banner', array(
	'editor_style'		=> 'merchandiser-extender-banner-editor-styles',
	'editor_script'		=> 'merchandiser-extender-banner-editor-scripts',
	'style'				=> 'merchandiser-extender-banner-styles',
));
