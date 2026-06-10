<?php
/**
 * Plugin Name: Hreflang Manager
 * Description: Set language and regional URL for better SEO performance. (Lite Version)
 * Version: 1.17
 * Author: DAEXT
 * Author URI: https://daext.com
 * Text Domain: hreflang-manager-lite
 * License: GPLv3
 *
 * @package hreflang-manager-lite
 */

use Daext\Daexthrmal\NoticesManager\DAEXT_Notices_Manager;

// Prevent direct access to this file.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// Set constants.
define( 'DAEXTHRMAL_EDITION', 'FREE' );

// Class shared across public and admin.
require_once plugin_dir_path( __FILE__ ) . 'shared/class-daexthrmal-shared.php';

// Rest API.
require_once plugin_dir_path( __FILE__ ) . 'inc/class-daexthrmal-rest.php';
add_action( 'plugins_loaded', array( 'Daexthrmal_Rest', 'get_instance' ) );

// Public.
require_once plugin_dir_path( __FILE__ ) . 'public/class-daexthrmal-public.php';
add_action( 'plugins_loaded', array( 'Daexthrmal_Public', 'get_instance' ) );

// Perform the Gutenberg related activities only if Gutenberg is present.
if ( function_exists( 'register_block_type' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'blocks/src/init.php';
}

/**
 * Get the total number of connections stored in the plugin "_connection" table.
 *
 * This helper is used to quickly retrieve how many hreflang connections are currently defined
 * without having to run a full query on the table contents.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @return int Total number of rows in the "*_connect" table. Returns 0 if the table does not exist.
 */
function daexthrmal_get_connections_count() {

	// Use a transient to avoid running the COUNT(*) query on every request.
	$transient_key = 'daexthrmal_connections_count';
	$cached_count  = get_transient( $transient_key );

	if ( false !== $cached_count ) {
		return (int) $cached_count;
	}

	global $wpdb;

	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}daexthrmal_connection" );

	/**
	 * Cache the result for a short period to reduce database load while keeping it reasonably fresh.
	 * Here we use 10 minutes (600 seconds) as a sensible default.
	 */
	set_transient( $transient_key, $count, 10 * MINUTE_IN_SECONDS );
	return $count;

}

/**
 * Initialize the plugin notices manager used to display documentation and review notices for this plugin.
 *
 * The notices are only relevant in the admin area, so we restrict the initialization to is_admin(),
 * which also avoids running the connections COUNT(*) query on front-end requests.
 */
if ( is_admin() ) {
	require_once __DIR__ . '/inc/daext-notices-manager/class-daext-notices-manager.php';
	DAEXT_Notices_Manager::get_instance( [
		'plugin_slug'        => 'hreflang-manager-lite',
		'plugin_file'        => __FILE__,
		'docs_url'           => 'https://daext.com/kb/hreflang-manager/',
		'review_url'         => 'https://wordpress.org/support/plugin/hreflang-manager-lite/reviews/#new-post',
		'plugin_prefix'      => 'daexthrmal',
		'settings_screen_id' => 'hreflang_page_daexthrmal_options',
		'feature_used'       => daexthrmal_get_connections_count() >= 5,
	] );
}

// Admin.
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	// Admin.
	require_once plugin_dir_path( __FILE__ ) . 'admin/class-daexthrmal-admin.php';
	add_action( 'plugins_loaded', array( 'Daexthrmal_Admin', 'get_instance' ) );

	// Activate.
	register_activation_hook( __FILE__, array( Daexthrmal_Admin::get_instance(), 'ac_activate' ) );

	// Deactivate.
	register_deactivation_hook( __FILE__, array( Daexthrmal_Admin::get_instance(), 'dc_deactivate' ) );

}

// Admin.
if ( is_admin() ) {

	require_once plugin_dir_path( __FILE__ ) . 'admin/class-daexthrmal-admin.php';

	// If this is not an AJAX request, create a new singleton instance of the admin class.
	if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
		add_action( 'plugins_loaded', array( 'Daexthrmal_Admin', 'get_instance' ) );
	}

	// Activate the plugin using only the class static methods.
	register_activation_hook( __FILE__, array( 'Daexthrmal_Admin', 'ac_activate' ) );

	// Deactivate the plugin only with static methods.
	register_deactivation_hook( __FILE__, array( 'Daexthrmal_Admin', 'dc_deactivate' ) );

}

/**
 * If we are in the admin area, update the plugin db tables and options if they are not up-to-date.
 */
if ( is_admin() ) {

	require_once plugin_dir_path( __FILE__ ) . 'admin/class-daexthrmal-admin.php';

	// If needed, create or update the database tables.
	Daexthrmal_Admin::ac_create_database_tables();

	// If needed, create or update the plugin options.
	Daexthrmal_Admin::ac_initialize_options();

}

/**
 * Customize the action links in the "Plugins" menu.
 *
 * @param array $actions An array of plugin action links.
 *
 * @return mixed
 */
function daexthrmal_customize_action_links( $actions ) {
	$actions[] = '<a href="https://daext.com/hreflang-manager/" target="_blank">' . esc_html__( 'Buy the Pro Version', 'hreflang-manager-lite' ) . '</a>';
	return $actions;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'daexthrmal_customize_action_links' );

/**
 * Load the plugin text domain for translation.
 *
 * @return void
 */
function daexthrmal_load_plugin_textdomain() {
	load_plugin_textdomain( 'hreflang-manager-lite', false, 'hreflang-manager-lite/lang/' );
}

add_action( 'init', 'daexthrmal_load_plugin_textdomain' );
