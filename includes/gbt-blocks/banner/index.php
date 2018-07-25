<?php

// Banner

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action( 'enqueue_block_editor_assets', 'getbowtied_mc_banner_editor_assets' );

if ( ! function_exists( 'getbowtied_mc_banner_editor_assets' ) ) {
	function getbowtied_mc_banner_editor_assets() {

		wp_enqueue_script(
			'getbowtied-banner',
			plugins_url( 'block.js', __FILE__ ),
			array( 'wp-blocks', 'wp-components', 'wp-editor', 'wp-i18n', 'wp-element', 'jquery' )
		);

		wp_enqueue_style(
			'getbowtied-banner',
			plugins_url( 'css/editor.css', __FILE__ ),
			array( 'wp-edit-blocks' )
		);
	}
}

add_action( 'enqueue_block_assets', 'getbowtied_mc_banner_assets' );

if ( ! function_exists( 'getbowtied_mc_banner_assets' ) ) {
	function getbowtied_mc_banner_assets() {
		
		wp_enqueue_style(
			'getbowtied-banner-css',
			plugins_url( 'css/style.css', __FILE__ ),
			array()
		);
	}
}

register_block_type( 'getbowtied/mc-banner', array(
	'attributes'      	=> array(
		'title'							=> array(
			'type'						=> 'string',
			'default'					=> 'Banner Title',
		),
		'subtitle'						=> array(
			'type'						=> 'string',
			'default'					=> 'Banner Subtitle',
		),
		'imgURL'						=> array(
			'type'						=> 'string',
			'default'					=> '',
		),
		'url'							=> array(
			'type'						=> 'string',
			'default'					=> '#',
		),
		'blank'							=> array(
			'type'						=> 'boolean',
			'default'					=> true,
		),
		'titleColor'					=> array(
			'type'						=> 'string',
			'default'					=> '#fff',
		),
		'subtitleColor'					=> array(
			'type'						=> 'string',
			'default'					=> '#fff',
		),
		'titleSize'						=> array(
			'type'						=> 'integer',
			'default'					=> '64',
		),
		'subtitleSize'					=> array(
			'type'						=> 'integer',
			'default'					=> '21',
		),
		'titleFont'						=> array(
			'type'						=> 'string',
			'default'					=> 'primary_font',
		),
		'subtitleFont'					=> array(
			'type'						=> 'string',
			'default'					=> 'secondary_font',
		),
		'buttonToggle'					=> array(
			'type'						=> 'boolean',
			'default'					=> false,
		),
		'buttonText'					=> array(
			'type'						=> 'string',
			'default'					=> 'Button Text',
		),
		'buttonTextColor'				=> array(
			'type'						=> 'string',
			'default'					=> '#fff',
		),
		'buttonBgColor'					=> array(
			'type'						=> 'string',
			'default'					=> '#000',
		),
		'innerStrokeThickness'			=> array(
			'type'						=> 'integer',
			'default'					=> '2',
		),
		'innerStrokeColor'				=> array(
			'type'						=> 'string',
			'default'					=> '#fff',
		),
		'bgColor'						=> array(
			'type'						=> 'string',
			'default'					=> '#f3f3f4',
		),
		'height'						=> array(
			'type'						=> 'integer',
			'default'					=> '300',
		),
		'separatorPadding'				=> array(
			'type'						=> 'integer',
			'default'					=> '5',
		),
		'separatorColor'				=> array(
			'type'						=> 'string',
			'default'					=> '#fff',
		),
		'align'							=> array(
			'type'						=> 'string',
			'default'					=> 'center',
		),
	),

	'render_callback' => 'getbowtied_mc_render_banner',
) );

function getbowtied_mc_render_banner( $attributes ) {

	extract( shortcode_atts( array(
		'title' 				=> 'Banner Title',
		'subtitle' 				=> 'Banner Subtitle',
		'url' 					=> '#',
		'blank' 				=> '',
		'titleColor' 			=> '#fff',
		'subtitleColor' 		=> '#fff',
		'titleSize'				=> '64',
		'subtitleSize'			=> '21',
		'titleFont'				=> 'primary_font',
		'subtitleFont'			=> 'secondary_font',
		'buttonToggle'			=> false,
		'buttonText'			=> 'Button Text',
		'buttonTextColor'		=> '#fff',
		'buttonBgColor'			=> '#000',
		'innerStrokeThickness' 	=> '2px',
		'innerStrokeColor' 		=> '#fff',
		'bgColor' 				=> '#f3f3f4',
		'imgURL' 				=> '',
		'height' 				=> '300',
		'separatorPadding' 		=> '5',
		'separatorColor' 		=> '#fff',
		'align'					=> 'center'
	), $attributes));

	$banner_with_img = '';
	
	if (!empty($imgURL)) {
		$banner_with_img = 'banner_with_img';
	}

	$cursor = 'style="cursor:default;"';

	$link_tab = '';

	if( !$buttonToggle || !$buttonText ) {

		$cursor = 'style="cursor:pointer;"';

		if ($blank == 'true') {
			$link_tab = 'onclick="window.open(\''.$url.'\', \'_blank\');"';
		} else {
			$link_tab = 'onclick="location.href=\''.$url.'\';"';
		}
	}
	
	$getbowtied_banner = '
		<div class="wp-block-gbt-banner">
			<div ' . $cursor . ' class="shortcode_getbowtied_banner '.$banner_with_img.' '.$align.'" '.$link_tab.'>
				<div class="shortcode_getbowtied_banner_inner">
					<div class="shortcode_getbowtied_banner_bkg" style="background-color:'.$bgColor.'; background-image:url('.$imgURL.')"></div>
				
					<div class="shortcode_getbowtied_banner_inside" style="height:'.$height.'px; border: '.$innerStrokeThickness.' solid '.$innerStrokeColor.'">
						<div class="shortcode_getbowtied_banner_content">';
		if ($title) {
			$getbowtied_banner .= '<div><h3 class="shortcode_getbowtied_banner_title '.$titleFont.'" style="font-size:'.$titleSize.'px; color:'.$titleColor.' !important;">'.$title.'</h3></div>';
		}

		if ($title && $subtitle) {
			$getbowtied_banner .= '<div class="shortcode_getbowtied_banner_sep" style="margin:'.$separatorPadding.'px auto; background-color:'.$separatorColor.';"></div>';
		}

		if ($subtitle) {
			$getbowtied_banner .= '<div><h4 class="shortcode_getbowtied_banner_subtitle '.$subtitleFont.'" style="font-size:'.$subtitleSize.'px; color:'.$subtitleColor.' !important;">'.$subtitle.'</h4></div>';
		}

		if ($buttonToggle && $buttonText) {
			$target = '';
			if ($blank == 'true') {
				$target = 'target="_blank"';
			}
			$getbowtied_banner .= '<a href="'.$url.'" ' . $target . ' class="button" style="background-color:'.$buttonBgColor.'; color: '.$buttonTextColor.'">'.$buttonText.'</a>';
		}

	$getbowtied_banner .= '
					</div>
				</div>
			</div>
		</div>
	</div>';
	
	return $getbowtied_banner;
}