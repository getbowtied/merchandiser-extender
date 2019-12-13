<?php

/**
 * Plugin Name:       		Merchandiser Extender
 * Plugin URI:        		https://merchandiser.wp-theme.design/
 * Description:       		Extends the functionality of the Merchandiser theme by adding theme specific features.
 * Version:           		1.3.6
 * Author:            		GetBowtied
 * Author URI:        		https://getbowtied.com
 * Requires at least: 		5.0
 * Tested up to: 			5.3.1
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

// Plugin Updater
require 'core/updater/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/getbowtied/merchandiser-extender/master/core/updater/assets/plugin.json',
	__FILE__,
	'merchandiser-extender'
);


if ( ! class_exists( 'MerchandiserExtender' ) ) :

	/**
	 * MerchandiserExtender class.
	*/
	class MerchandiserExtender {

		/**
		 * The single instance of the class.
		 *
		 * @var MerchandiserExtender
		*/
		protected static $_instance = null;

		/**
		 * MerchandiserExtender constructor.
		 *
		*/
		public function __construct() {

			$theme = wp_get_theme();
			$parent_theme = $theme->parent();

			// Helpers
			include_once( dirname( __FILE__ ) . '/includes/helpers/helpers.php' );

			// Vendor
			include_once( dirname( __FILE__ ) . '/includes/vendor/enqueue.php' );

			if( ( $theme->template == 'merchandiser' && ( $theme->version >= '1.9' || ( !empty($parent_theme) && $parent_theme->version >= '1.9' ) ) ) || $theme->template != 'merchandiser' ) {

				// Shortcodes
				include_once( dirname( __FILE__ ) . '/includes/shortcodes/index.php' );

				// Social Media
				include_once( dirname( __FILE__ ) . '/includes/social-media/class-social-media.php' );

				add_action( 'footer_socials', function() {
					echo '<div class="footer-socials">' . do_shortcode('[socials]') . '</div>';
				} );
			}

			// Gutenberg Blocks
			add_action( 'init', array( $this, 'gbt_mc_gutenberg_blocks' ) );

			if( $theme->template == 'merchandiser' && ( $theme->version >= '1.9' || ( !empty($parent_theme) && $parent_theme->version >= '1.9' ) ) ) {

				// Addons
				if ( $theme->template == 'merchandiser' && is_plugin_active( 'woocommerce/woocommerce.php') ) {
					include_once( dirname( __FILE__ ) . '/includes/addons/class-wc-category-header-image.php' );
				}

				// Custom Code Section
				include_once( dirname( __FILE__ ) . '/includes/custom-code/class-custom-code.php' );

				// Social Sharing Buttons
				if ( is_plugin_active( 'woocommerce/woocommerce.php') ) {
					include_once( dirname( __FILE__ ) . '/includes/social-sharing/class-social-sharing.php' );
				}
			}
		}

		/**
		 * Loads Gutenberg blocks
		 *
		 * @return void
		*/
		public function gbt_mc_gutenberg_blocks() {

			if( is_plugin_active( 'gutenberg/gutenberg.php' ) || mc_is_wp_version('>=', '5.0') ) {
				include_once( dirname( __FILE__ ) . '/includes/gbt-blocks/index.php' );
			} else {
				add_action( 'admin_notices', 'mc_theme_warning' );
			}
		}

		/**
		 * Ensures only one instance of MerchandiserExtender is loaded or can be loaded.
		 *
		 * @return MerchandiserExtender
		*/
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}
endif;

$merchandiser_extender = new MerchandiserExtender;
