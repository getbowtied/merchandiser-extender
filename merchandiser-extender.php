<?php

/**
 * Plugin Name:       		Merchandiser Extender
 * Plugin URI:        		https://merchandiser.wp-theme.design/
 * Description:       		Extends the functionality of the Merchandiser theme by adding theme specific features.
 * Version:           		2.2
 * Author:            		Get Bowtied
 * Author URI:        		https://getbowtied.com
 * Requires at least: 		5.0
 * Tested up to: 			6.6
 * Requires PHP:            7.4.1
 *
 * @package  Merchandiser Extender
 * @author   Get Bowtied
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

$version = ( isset(get_plugin_data( __FILE__ )['Version']) && !empty(get_plugin_data( __FILE__ )['Version']) ) ? get_plugin_data( __FILE__ )['Version'] : '1.0';
define ( 'MC_EXT_VERSION', $version );

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

            // Merchandiser Dependent Components
			if( class_exists('Merchandiser') ) {

				// Helpers
				//include_once( dirname( __FILE__ ) . '/includes/helpers/helpers.php' );

				// Vendor
				include_once( dirname( __FILE__ ) . '/includes/vendor/enqueue.php' );

				// Shortcodes
				include_once( dirname( __FILE__ ) . '/includes/shortcodes/index.php' );

				// Customizer
				include_once( dirname( __FILE__ ) . '/includes/customizer/repeater/class-mc-ext-repeater-control.php' );

				// Social Media
				include_once( dirname( __FILE__ ) . '/includes/social-media/class-social-media.php' );

				// Gutenberg Blocks
				include_once( dirname( __FILE__ ) . '/includes/gbt-blocks/index.php' );

                // Addons
				if ( $theme->template == 'merchandiser' && is_plugin_active( 'woocommerce/woocommerce.php') ) {
					include_once( dirname( __FILE__ ) . '/includes/addons/class-wc-category-header-image.php' );
				}

                // Custom Menu Section
				include_once( dirname( __FILE__ ) . '/includes/custom-menu/class-merchandiser-nav-menu.php' );
                include_once( dirname( __FILE__ ) . '/includes/custom-menu/class-merchandiser-nav-menu-output.php' );

				// Custom Code Section
				include_once( dirname( __FILE__ ) . '/includes/custom-code/class-custom-code.php' );

				// Social Sharing Buttons
				if ( is_plugin_active( 'woocommerce/woocommerce.php') ) {
					include_once( dirname( __FILE__ ) . '/includes/social-sharing/class-social-sharing.php' );
				}

				if ( is_admin() ) {
					include_once( dirname( __FILE__ ) . '/dashboard/index.php' );
				}
            }

            add_action( 'footer_socials', function() {
                echo '<div class="footer-socials">' . do_shortcode('[socials]') . '</div>';
            } );
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

add_action( 'after_setup_theme', function() {
    $merchandiser_extender = new MerchandiserExtender;
} );
