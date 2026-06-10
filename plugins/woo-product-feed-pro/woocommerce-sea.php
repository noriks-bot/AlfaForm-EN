<?php
/**
 * Plugin Name: Product Feed PRO for WooCommerce
 * Version:     13.5.2.2
 * Plugin URI:  https://www.adtribes.io/support/?utm_source=wpadmin&utm_medium=plugin&utm_campaign=woosea_product_feed_pro
 * Description: Configure and maintain your WooCommerce product feeds for Google Shopping, Catalog managers, Remarketing, Bing, Skroutz, Yandex, Comparison shopping websites and over a 100 channels more.
 * Author:      AdTribes.io
 * Plugin URI:  https://wwww.adtribes.io/pricing/
 * Author URI:  https://www.adtribes.io
 * Developer:   AdTribes.io
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 5.4
 * Tested up to: 6.9.1
 *
 * Text Domain: woo-product-feed-pro
 * Domain Path: /languages
 *
 * WC requires at least: 4.4
 * WC tested up to: 10.5.3
 *
 * Product Feed PRO for WooCommerce is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Product Feed PRO for WooCommerce is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Product Feed PRO for WooCommerce. If not, see <http://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define plugin constants.
 */
define( 'WOOCOMMERCESEA_PLUGIN_VERSION', '13.5.2.2' );
define( 'WOOCOMMERCESEA_PLUGIN_NAME', 'woocommerce-product-feed-pro' );
define( 'WOOCOMMERCESEA_PLUGIN_NAME_SHORT', 'woo-product-feed-pro' );

if ( ! defined( 'ADT_PFP_PLUGIN_FILE' ) ) {
    define( 'ADT_PFP_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'ADT_PFP_PLUGIN_DIR_PATH' ) ) {
    define( 'ADT_PFP_PLUGIN_DIR_PATH', plugin_dir_path( ADT_PFP_PLUGIN_FILE ) );
}

if ( ! defined( 'ADT_PFP_BASENAME' ) ) {
    define( 'ADT_PFP_BASENAME', plugin_basename( ADT_PFP_PLUGIN_FILE ) );
}

if ( ! defined( 'ADT_PFP_PLUGIN_URL' ) ) {
    define( 'ADT_PFP_PLUGIN_URL', plugin_dir_url( ADT_PFP_PLUGIN_FILE ) );
}

// Define the path to the plugin views.
if ( ! defined( 'ADT_PFP_VIEWS_ROOT_PATH' ) ) {
    define( 'ADT_PFP_VIEWS_ROOT_PATH', ADT_PFP_PLUGIN_DIR_PATH . 'views/' );
}

// Define the url to the plugin images.
if ( ! defined( 'ADT_PFP_IMAGES_URL' ) ) {
    define( 'ADT_PFP_IMAGES_URL', ADT_PFP_PLUGIN_URL . 'static/images/' );
}

// Define the url to the plugin js.
if ( ! defined( 'ADT_PFP_JS_URL' ) ) {
    define( 'ADT_PFP_JS_URL', ADT_PFP_PLUGIN_URL . 'static/js/' );
}

// Define the url to the plugin css.
if ( ! defined( 'ADT_PFP_CSS_URL' ) ) {
    define( 'ADT_PFP_CSS_URL', ADT_PFP_PLUGIN_URL . 'static/css/' );
}

// Define the path to the legacy channel classes.
if ( ! defined( 'ADT_PFP_CHANNEL_CLASS_ROOT_PATH' ) ) {
    define( 'ADT_PFP_CHANNEL_CLASS_ROOT_PATH', ADT_PFP_PLUGIN_DIR_PATH . 'classes/channels/' );
}

// Define the option name for the installed version.
if ( ! defined( 'ADT_PFP_OPTION_INSTALLED_VERSION' ) ) {
    define( 'ADT_PFP_OPTION_INSTALLED_VERSION', 'woocommercesea_option_installed_version' );
}

// Define the option name for temporary feed creation data.
if ( ! defined( 'ADT_OPTION_TEMP_PRODUCT_FEED' ) ) {
    define( 'ADT_OPTION_TEMP_PRODUCT_FEED', 'adt_temp_product_feed' );
}

if ( ! defined( 'ADT_PFP_CLEAN_UP_PLUGIN_OPTIONS' ) ) {
    define( 'ADT_PFP_CLEAN_UP_PLUGIN_OPTIONS', 'adt_clean_up_plugin_data' );
}

// Transient keys.
if ( ! defined( 'ADT_TRANSIENT_CUSTOM_ATTRIBUTES' ) ) {
    define( 'ADT_TRANSIENT_CUSTOM_ATTRIBUTES', 'adt_transient_custom_attributes' );
}

// Define usage tracking constants.
if ( ! defined( 'ADT_PFP_USAGE_ALLOW' ) ) {
    define( 'ADT_PFP_USAGE_ALLOW', 'adt_pfp_anonymous_data' );
}
if ( ! defined( 'ADT_PFP_USAGE_CRON_ACTION' ) ) {
    define( 'ADT_PFP_USAGE_CRON_ACTION', 'adt_pfp_usage_tracking_cron' );
}
if ( ! defined( 'ADT_PFP_USAGE_CRON_CONFIG' ) ) {
    define( 'ADT_PFP_USAGE_CRON_CONFIG', 'adt_pfp_usage_tracking_config' );
}
if ( ! defined( 'ADT_PFP_USAGE_LAST_CHECKIN' ) ) {
    define( 'ADT_PFP_USAGE_LAST_CHECKIN', 'adt_pfp_usage_tracking_last_checkin' );
}
if ( ! defined( 'ADT_PFP_SHOW_ALLOW_USAGE_NOTICE' ) ) {
    define( 'ADT_PFP_SHOW_ALLOW_USAGE_NOTICE', 'adt_pfp_show_allow_usage_notice' );
}

// Define the Action Scheduler hook for generating product feeds.
if ( ! defined( 'ADT_PFP_AS_GENERATE_PRODUCT_FEED' ) ) {
    define( 'ADT_PFP_AS_GENERATE_PRODUCT_FEED', 'adt_pfp_as_generate_product_feed' );
}
if ( ! defined( 'ADT_PFP_AS_GENERATE_PRODUCT_FEED_GROUP' ) ) {
    define( 'ADT_PFP_AS_GENERATE_PRODUCT_FEED_GROUP', 'adt_pfp_as_generate_product_feed_group' );
}
if ( ! defined( 'ADT_PFP_AS_GENERATE_PRODUCT_FEED_BATCH' ) ) {
    define( 'ADT_PFP_AS_GENERATE_PRODUCT_FEED_BATCH', 'adt_pfp_as_generate_product_feed_batch' );
}
if ( ! defined( 'ADT_PFP_AS_PRODUCT_FEED_UPDATE_STATS' ) ) {
    define( 'ADT_PFP_AS_PRODUCT_FEED_UPDATE_STATS', 'adt_pfp_as_product_feed_update_stats' );
}

// Define the Action Scheduler hook for fetching Google Product Taxonomy.
if ( ! defined( 'ADT_PFP_AS_FETCH_GOOGLE_PRODUCT_TAXONOMY' ) ) {
    define( 'ADT_PFP_AS_FETCH_GOOGLE_PRODUCT_TAXONOMY', 'adt_pfp_as_fetch_google_product_taxonomy' );
}

/***************************************************************************
 * Loads plugin text domain.
 * **************************************************************************
 *
 * Loads the plugin text domain for translation.
 */
function adt_pfp_load_textdomain() {

    load_plugin_textdomain(
        'woo-product-feed-pro',
        false,
        dirname( plugin_basename( __FILE__ ) ) . '/languages'
    );
}

add_action( 'init', 'adt_pfp_load_textdomain' );


/***************************************************************************
 * Loads the plugin.
 ***************************************************************************
 *
 * Load the plugin if all checks passed.
 */

/**
 * Our bootstrap class instance.
 *
 * @var AdTribes\PFP\App $app
 */
$app = require_once 'bootstrap/app.php';

$app->boot();

/**
 * Required Old classes.
 */
require plugin_dir_path( __FILE__ ) . 'classes/class-get-products.php';
require plugin_dir_path( __FILE__ ) . 'classes/class-admin-notifications.php';
require plugin_dir_path( __FILE__ ) . 'classes/class-google-remarketing.php';
require plugin_dir_path( __FILE__ ) . 'classes/class-caching.php';

// Old bootstrap.
require plugin_dir_path( __FILE__ ) . '/bootstrap-old.php';
