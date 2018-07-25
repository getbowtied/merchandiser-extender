<?php

// Social Media Profiles

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action( 'enqueue_block_editor_assets', 'getbowtied_mc_socials_editor_assets' );

if ( ! function_exists( 'getbowtied_mc_socials_editor_assets' ) ) {
    function getbowtied_mc_socials_editor_assets() {
    	
        wp_enqueue_script(
            'getbowtied-socials',
            plugins_url( 'block.js', __FILE__ ),
            array( 'wp-blocks', 'wp-components', 'wp-editor', 'wp-i18n', 'wp-element', 'jquery' )
        );

        wp_enqueue_style(
            'getbowtied-socials-styles',
            plugins_url( 'css/editor.css', __FILE__ ),
            array( 'wp-edit-blocks' )
        );
    }
}

add_action( 'enqueue_block_assets', 'getbowtied_mc_socials_assets' );

if ( ! function_exists( 'getbowtied_mc_socials_assets' ) ) {
    function getbowtied_mc_socials_assets() {
        
        wp_enqueue_style(
            'getbowtied-socials-css',
            plugins_url( 'css/style.css', __FILE__ ),
            array()
        );
    }
}

register_block_type( 'getbowtied/mc-socials', array(
	'attributes'     			=> array(
		'items_align'			=> array(
			'type'				=> 'string',
			'default'			=> 'left',
		),
        'fontSize'              => array(
            'type'              => 'number',
            'default'           => '24',
        ),
        'fontColor'             => array(
            'type'              => 'string',
            'default'           => '#000',
        ),
	),

	'render_callback' => 'getbowtied_mc_render_frontend_socials',
) );

function get_mc_social_media_icons() {
    $socials = array(
        array( 
            'link' => 'facebook_link',
            'icon' => 'fa fa-facebook',
            'name' => 'Facebook'
        ),
        array( 
            'link' => 'pinterest_link',
            'icon' => 'fa fa-pinterest',
            'name' => 'Pinterest'
        ),
        array( 
            'link' => 'linkedin_link',
            'icon' => 'fa fa-linkedin',
            'name' => 'Linkedin'
        ),
        array( 
            'link' => 'twitter_link',
            'icon' => 'fa fa-twitter',
            'name' => 'Twitter'
        ),
        array( 
            'link' => 'googleplus_link',
            'icon' => 'fa fa-google-plus',
            'name' => 'Google+'
        ),
        array( 
            'link' => 'rss_link',
            'icon' => 'fa fa-rss',
            'name' => 'RSS'
        ),
        array( 
            'link' => 'tumblr_link',
            'icon' => 'fa fa-tumblr',
            'name' => 'Tumblr'
        ),
        array( 
            'link' => 'instagram_link',
            'icon' => 'fa fa-instagram',
            'name' => 'Instagram'
        ),
        array( 
            'link' => 'youtube_link',
            'icon' => 'fa fa-youtube-play',
            'name' => 'Youtube'
        ),
        array( 
            'link' => 'vimeo_link',
            'icon' => 'fa fa-vimeo-square',
            'name' => 'Vimeo'
        ),
        array( 
            'link' => 'behance_link',
            'icon' => 'fa fa-behance',
            'name' => 'Behance'
        ),
        array( 
            'link' => 'dribbble_link',
            'icon' => 'fa fa-dribbble',
            'name' => 'Dribbble'
        ),
        array( 
            'link' => 'flickr_link',
            'icon' => 'fa fa-flickr',
            'name' => 'Flickr'
        ),
        array( 
            'link' => 'git_link',
            'icon' => 'fa fa-git',
            'name' => 'Git'
        ),
        array( 
            'link' => 'skype_link',
            'icon' => 'fa fa-skype',
            'name' => 'Skype'
        ),
        array( 
            'link' => 'weibo_link',
            'icon' => 'fa fa-weibo',
            'name' => 'Weibo'
        ),
        array( 
            'link' => 'foursquare_link',
            'icon' => 'fa fa-foursquare',
            'name' => 'Foursquare'
        ),
        array( 
            'link' => 'soundcloud_link',
            'icon' => 'fa fa-soundcloud',
            'name' => 'Soundcloud'
        ),
    );

    return $socials;
}

function getbowtied_mc_render_frontend_socials($attributes) {

	extract(shortcode_atts(
		array(
			'items_align' => 'left',
            'fontSize'    => '24',
            'fontColor'   => '#000',
		), $attributes));
    ob_start();

    $socials = get_mc_social_media_icons();

    $output = '<div class="wp-block-gbt-social-media">';

        $output .= '<div class="shortcode_socials">';
        $output .= '<ul class="' . esc_html($items_align) . '" style="font-size:'.$fontSize.'px;">';

        foreach($socials as $social) {

        	if ( get_theme_mod($social['link'], '') != '' ) {
        		$output .= '<li>';
        		$output .= '<a style="color:'.$fontColor.';" target="_blank" href="' . esc_url(get_theme_mod($social['link'], '')) . '">';
                $output .= '<i class="' . $social['icon'] . '"></i>';
        		$output .= '<span>' . $social['name'] . '</span>';
        		$output .= '</a></li>';
        	}
        }

        $output .= '</ul>';
        $output .= '</div>';

    $output .= '</div>';

	ob_end_clean();

	return $output;
}