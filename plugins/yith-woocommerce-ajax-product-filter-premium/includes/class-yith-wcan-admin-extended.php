<?php
/**
 * Admin class
 *
 * @author  YITH
 * @package YITH\AjaxProductFilter\Classes
 * @version 4.0.0
 */

if ( ! defined( 'YITH_WCAN' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAN_Admin_Extended' ) ) {
	/**
	 * Admin class.
	 * This class manage all the admin features.
	 *
	 * @since 1.0.0
	 */
	class YITH_WCAN_Admin_Extended extends YITH_WCAN_Admin {

		/**
		 * Construct
		 *
		 * @access public
		 * @since  1.0.0
		 * @author Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function __construct() {
			parent::__construct();

			// updates available tabs.
			add_filter( 'yith_wcan_settings_tabs', array( $this, 'settings_tabs' ) );

			// Add premium options.
			add_filter( 'yith_wcan_panel_general_options', array( $this, 'add_general_options' ) );
			add_filter( 'yith_wcan_panel_seo_options', array( $this, 'add_seo_options' ) );
		}

		/* === PANEL METHODS === */

		/**
		 * Add premium plugin options
		 *
		 * @param array $settings List of filter options.
		 * @return array Filtered list of filter options.
		 */
		public function add_general_options( $settings ) {
			$options = $settings['general'];

			$additional_options_batch_1 = array(
				'instant_filter'    => array(
					'name'      => _x( 'Filter mode', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					'desc'      => _x( 'Choose to apply filters in real time using AJAX or whether to show a button to apply all filters', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					'id'        => 'yith_wcan_instant_filters',
					'type'      => 'yith-field',
					'yith-type' => 'radio',
					'default'   => 'yes',
					'options'   => array(
						'yes' => _x( 'Instant result', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
						'no'  => _x( 'By clicking "Apply filters" button', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					),
				),

				'ajax_filter'       => array(
					'name'      => _x( 'Show results', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					'desc'      => _x( 'Choose whether to load the results on the same page using AJAX or load the results on a new page', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					'id'        => 'yith_wcan_ajax_filters',
					'type'      => 'yith-field',
					'default'   => 'yes',
					'yith-type' => 'radio',
					'options'   => array(
						'yes' => _x( 'In same page using AJAX', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
						'no'  => _x( 'Reload the page without AJAX', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					),
				),

				'hide_empty_terms'  => array(
					'name'      => _x( 'Hide empty terms', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					'desc'      => _x( 'Enable to hide empty terms from filters section', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					'id'        => 'yith_wcan_hide_empty_terms',
					'type'      => 'yith-field',
					'default'   => 'no',
					'yith-type' => 'onoff',
				),

				'hide_out_of_stock' => array(
					'name'      => _x( 'Hide out of stock products', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					'desc'      => _x( 'Enable to hide "out of stock" products from the results.', '[ADMIN] General settings page', 'yith-woocommerce-ajax-navigation' ),
					'id'        => 'yith_wcan_hide_out_of_stock_products',
					'type'      => 'yith-field',
					'default'   => 'no',
					'yith-type' => 'onoff',
				),
			);

			$options = yith_wcan_merge_in_array( $options, $additional_options_batch_1, 'general_section_start' );

			$additional_options_batch_2 = array(
				'scroll_top' => array(
					'name'      => _x( 'Scroll top after filtering', '[ADMIN] Customization settings page', 'yith-woocommerce-ajax-navigation' ),
					'desc'      => _x( 'Enable this option if you want to scroll to top after filtering.', '[ADMIN] Customization settings page', 'yith-woocommerce-ajax-navigation' ),
					'id'        => 'yith_wcan_scroll_top',
					'default'   => 'no',
					'type'      => 'yith-field',
					'yith-type' => 'onoff',
				),
			);

			$options = yith_wcan_merge_in_array( $options, $additional_options_batch_2, 'reset_button_position' );

			$settings['general'] = $options;

			return $settings;
		}

		/**
		 * Add premium filter options
		 *
		 * @param array $settings List of filter options.
		 * @return array Filtered list of filter options.
		 */
		public function add_seo_options( $settings ) {
			$options = $settings['seo'];

			if ( ! isset( $options['change_url'] ) ) {
				return $settings;
			}

			// add premium options to existing settings.
			$options['change_url']['options'] = yith_wcan_merge_in_array(
				$options['change_url']['options'],
				array(
					'custom' => _x( 'Use plugin customized permalinks', '[ADMIN] Seo settings page', 'yith-woocommerce-ajax-navigation' ),
				),
				'yes',
				'before'
			);

			$settings['seo'] = $options;

			return $settings;
		}

		/**
		 * Add a panel under YITH Plugins tab
		 *
		 * @param array $tabs Array of available tabs.
		 *
		 * @return   array Filtered array of tabs
		 * @since    1.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 * @use      /Yit_Plugin_Panel class
		 * @see      plugin-fw/lib/yit-plugin-panel.php
		 */
		public function settings_tabs( $tabs ) {
			$tabs = yith_wcan_merge_in_array(
				$tabs,
				array(
					'customization' => _x( 'Customization', '[Admin] tab name', 'yith-woocommerce-ajax-navigation' ),
				),
				'general'
			);

			return $tabs;
		}

		/* === TOOLS === */

		/**
		 * Register available plugin tools
		 *
		 * @param array $tools Available tools.
		 * @return array Filtered array of tools.
		 */
		public function register_tools( $tools ) {
			$tools = parent::register_tools( $tools );

			$additional_tools = array(
				'clear_filter_sessions' => array(
					'name'     => _x( 'Clear Product Filter sessions', '[ADMIN] WooCommerce Tools tab, name of the tool', 'yith-woocommerce-ajax-navigation' ),
					'button'   => _x( 'Clear', '[ADMIN] WooCommerce Tools tab, button for the tool', 'yith-woocommerce-ajax-navigation' ),
					'desc'     => _x( 'This will clear all filter sessions on your site. It may be useful if you want to free some space (previously shared sessions won\'t be reachable any longer).', '[ADMIN] WooCommerce Tools tab, description of the tool', 'yith-woocommerce-ajax-navigation' ),
					'callback' => array( YITH_WCAN_Sessions(), 'delete_all' ),
				),
			);

			$tools = array_merge(
				$tools,
				$additional_tools
			);

			return $tools;
		}

	}
}
