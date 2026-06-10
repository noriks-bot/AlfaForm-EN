<?php

/**
 * Internationalization functionality
 *
 * @link       https://noriks.com
 * @since      1.0.0
 * @package    Flores_Woocommerce
 * @subpackage Flores_Woocommerce/includes
 */

class Flores_Woocommerce_i18n {

	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'flores-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
