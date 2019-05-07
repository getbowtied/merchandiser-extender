<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//==============================================================================
//	Enqueue Editor Assets
//==============================================================================
add_action( 'enqueue_block_editor_assets', 'gbt_18_mc_posts_slider_editor_assets' );
if ( ! function_exists( 'gbt_18_mc_posts_slider_editor_assets' ) ) {
	function gbt_18_mc_posts_slider_editor_assets() {
		
		wp_register_script(
			'gbt_18_mc_posts_slider_script',
			plugins_url( 'block.js', dirname(__FILE__) ),
			array( 'wp-api-request', 'wp-blocks', 'wp-i18n', 'wp-element' )
		);

		$language = isset($_GET['lang']) ? $_GET['lang'] : get_locale();

		wp_localize_script( 'gbt_18_mc_posts_slider_script', 'posts_grid_vars', array(
			'language' => $language
		) );

		wp_register_style(
			'gbt_18_mc_posts_slider_editor_styles',
			plugins_url( 'assets/css/editor.css', dirname(__FILE__) ),
			array( 'wp-edit-blocks' )
		);
	}
}

//==============================================================================
//	Enqueue Frontend Assets
//==============================================================================
add_action( 'enqueue_block_assets', 'gbt_18_mc_posts_slider_assets' );
if ( ! function_exists( 'gbt_18_mc_posts_slider_assets' ) ) {
	function gbt_18_mc_posts_slider_assets() {

		if( function_exists( 'mc_extender_vendor_scripts' ) ) {
			mc_extender_vendor_scripts();
		}

		wp_enqueue_style( 'merchandiser_swiper_style' );
		wp_enqueue_script( 'merchandiser_swiper_script' );
		
		wp_enqueue_style(
			'gbt_18_mc_posts_slider_styles',
			plugins_url( 'assets/css/style.css', dirname(__FILE__) ),
			array()
		);

		wp_enqueue_script(
			'gbt_18_mc_posts_slider_script',
			plugins_url( 'assets/js/posts_slider.js', dirname(__FILE__) ),
			array( 'jquery' )
		);
	}
}

//==============================================================================
//	Register Block Type
//==============================================================================
if ( function_exists( 'register_block_type' ) ) {
	register_block_type( 'getbowtied/mc-posts-slider', array(
		'editor_style'  	=> 'gbt_18_mc_posts_slider_editor_styles',
		'editor_script'		=> 'gbt_18_mc_posts_slider_script',
		'attributes'      					=> array(
			'number'						=> array(
				'type'						=> 'number',
				'default'					=> '12',
			),
			'categoriesSavedIDs'			=> array(
				'type'						=> 'string',
				'default'					=> '',
			),
			'align'							=> array(
				'type'						=> 'string',
				'default'					=> 'center',
			),
			'orderby'						=> array(
				'type'						=> 'string',
				'default'					=> 'date_desc',
			),
			'arrows'						=> array(
				'type'						=> 'boolean',
				'default'					=> true
			),
			'bullets'						=> array(
				'type'						=> 'boolean',
				'default'					=> true
			),
			'fontColor'						=> array(
				'type'						=> 'string',
				'default'					=> '#000'
			),
			'backgroundColor'				=> array(
				'type'						=> 'string',
				'default'					=> '#fff'
			),
		),

		'render_callback' => 'gbt_18_mc_render_frontend_posts_slider',
	) );
}