<?php

/**
 * Plugin Name:       		Merchandiser Extender
 * Plugin URI:        		https://merchandiser.wp-theme.design/
 * Description:       		Extends the functionality of Merchandiser with Gutenberg elements.
 * Version:           		1.1
 * Author:            		GetBowtied
 * Author URI:        		https://getbowtied.com
 * Requires at least: 		5.0
 * Tested up to: 			5.0.3
 *
 * @package  Merchandiser Extender
 * @author   GetBowtied
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

global $theme;
$theme = wp_get_theme();

// Plugin Updater
require 'core/updater/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/getbowtied/merchandiser-extender/develop/core/updater/assets/plugin.json',
	__FILE__,
	'merchandiser-extender'
);

add_action( 'init', 'gbt_mc_gutenberg_blocks' );
if(!function_exists('gbt_mc_gutenberg_blocks')) {
	function gbt_mc_gutenberg_blocks() {

		if( is_plugin_active( 'gutenberg/gutenberg.php' ) || mc_is_wp_version('>=', '5.0') ) {
			include_once 'includes/gbt-blocks/index.php';
		} else {
			add_action( 'admin_notices', 'mc_theme_warning' );
		}
	}
}

if(!function_exists('mc_theme_warning')) {
	function mc_theme_warning() {

		?>

		<div class="error">
			<p>Merchandiser Extender plugin couldn't find the Block Editor (Gutenberg) on this site. 
				It requires WordPress 5+ or Gutenberg installed as a plugin.</p>
		</div>

		<?php
	}
}

if(!function_exists('mc_is_wp_version')) {
	function mc_is_wp_version( $operator = '>', $version = '4.0' ) {

		global $wp_version;

		return version_compare( $wp_version, $version, $operator );
	}
}
