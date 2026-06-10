<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://noriks.com
 * @since             1.0.0
 * @package           Flores_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Flores WooCommerce
 * Description:       Advanced order tracking for WooCommerce - tracks UTMs, campaign IDs, adset IDs, ad IDs, landing pages & customer journeys.
 * Version:           5.0.0
 * Author:            Noriks
 * Author URI:        https://noriks.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       flores-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'FLORES_WOOCOMMERCE_VERSION', '5.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_flores_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-florex-woocommerce-activator.php';
	Flores_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_flores_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-florex-woocommerce-deactivator.php';
	Flores_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_flores_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_flores_woocommerce' );

/**
 * The core plugin class.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-florex-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_flores_woocommerce() {

	$plugin = new Flores_Woocommerce();
	$plugin->run();

}
run_flores_woocommerce();
