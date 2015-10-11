<?php
/**
 * Plugin Name: All products widget for WooCommerce
 * Description: Widget that displays a list of your products, grouped by categories on your site
 * Version: 0.0.1
 * Author: Roman Gritsay
 * Author URI: http://vk.com/ins1dethefire
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 */

// Bail if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'AllProductsWidget' ) ) {
	final class AllProductsWidget {
		/**
		 * @var string
		 */
		public static $version = '0.0.1';

		/**
		 * @var  Instance of the class
		 */
		protected static $_instance;

		/**
		 * Function used to create instance of class.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) )
				self::$_instance = new self();

			return self::$_instance;
		}


		/**
		 * This function sets up all of the actions and filters on instance. It also loads (includes)
		 * the required files and assets.
		 */
		function __construct( ) {
			// Load required assets
			//$this->includes();

			// Hooks
			add_action( 'widgets_init', array( $this, 'widgets_init' ) ); // Init Widgets
			$this->load_assets();
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		private function includes() {
			// All

			// Admin Only
			if ( is_admin() ) {

			}

			// Front-End Only
			if ( ! is_admin() ) { }
		}

		/**
		 * This function includes and initializes Note widgets.
		 */
		function widgets_init() {
		    
			include_once( 'includes/class-wc-widget-all-products.php' );
		}

		/********************
		 * Helper Functions *
		 ********************/

		/**
		 * This function returns the plugin url for Note without a trailing slash.
		 *
		 * @return string, URL for the Note plugin
		 */
		public static function plugin_url() {
			return untrailingslashit( plugins_url( '', __FILE__ ) );
		}

		/**
		 * This function returns the plugin directory for Note without a trailing slash.
		 *
		 * @return string, Directory for the Note plugin
		 */
		public static function plugin_dir() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * This function returns a reference to this Note class file.
		 *
		 * @return string
		 */
		public static function plugin_file() {
			return __FILE__;
		}
		
		private function load_assets() {
			wp_enqueue_style('all-products-widget', $this->plugin_url() . '/assets/style.css');
			wp_enqueue_script( 'all-products-widget', $this->plugin_url() . '/assets/main.js', array('jquery'));
		}

		/**
		 * This function returns a boolean result comparing against the current WordPress version.
		 *
		 * @return Boolean
		 */
		public static function wp_version_compare( $version, $operator = '>=' ) {
			global $wp_version;

			return version_compare( $wp_version, $version, $operator );
		}
	}

	/**
	 * Create an instance of the Note class.
	 */
	function AllProductsWidget() {
		return AllProductsWidget::instance();
	}

	AllProductsWidget(); // Note your content!
}