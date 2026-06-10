<?php
/**
* Plugin Name: Woocommerce Side Cart Premium
* Plugin URI: http://xootix.com/side-cart-woocommerce
* Author: XootiX
* Version: 4.6
* Text Domain: side-cart-woocommerce
* Domain Path: /languages
* Author URI: http://xootix.com
* Description: Manage your cart from just a click away
* Tags: floating cart, cart popup, woocommerce, cart
*/


//Exit if accessed directly
if( !defined('ABSPATH') ){
	return;
}


define( 'XOO_WSC_PLUGIN_FILE', __FILE__ );
define( "XOO_WSC_PATH", plugin_dir_path( __FILE__ ) ); // Plugin path
define( "XOO_WSC_PLUGIN_BASENAME", plugin_basename( __FILE__ ) );
define( "XOO_WSC_URL", untrailingslashit( plugins_url( '', __FILE__ ) ) ); // plugin url
define( "XOO_WSC_VERSION", "4.6" ); //Plugin version


require_once XOO_WSC_PATH.'/includes/xoo-framework/xoo-framework.php';

if ( !function_exists('xoo_wsc_init') ) {
	
	/**
	 * Initialize
	 *
	 * @since    1.0.0
	 */
	function xoo_wsc_init(){
		
		if( !class_exists( 'woocommerce' ) ) return;

		do_action( 'xoo_wsc_before_plugin_activation' );

		if ( ! class_exists( 'Xoo_Wsc_Loader' ) ) {
			require_once 'includes/class-xoo-wsc-loader.php';
		}

		xoo_wsc();

		
	}
	add_action( 'plugins_loaded','xoo_wsc_init', 14 );

	function xoo_wsc(){
		return Xoo_Wsc_Loader::get_instance();
	}

}else{
	deactivate_plugins('side-cart-woocommerce/xoo-wsc-main.php');
}