<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Factories\Vite_App;
use AdTribes\PFP\Factories\Admin_Notice;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Usage tracking class.
 *
 * @since 13.4.7
 */
class Upsell extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Get the upsell l10n.
     *
     * @since 13.4.7
     * @return array
     */
    public function upsell_l10n() {
        $popup_upsells = array(
            'default'                   => array(
                'title'   => __( 'Upgrade to Product Feed Elite for WooCommerce', 'woo-product-feed-pro' ),
                'message' => __( 'In Product Feed Pro Elite for WooCommerce you get access to advanced features like extra fields (GTIN, MPN, EAN, etc.), advanced filters and rules, product data manupulation, and more. Perfect for scaling your e-commerce business across multiple platforms.', 'woo-product-feed-pro' ),
                'link'    => Helper::get_utm_url( 'pricing', 'pfp', 'upsell', 'modal' ),
            ),
            'rule_action_set_attribute' => array(
                'title'   => __( 'Upgrade to Set Attributes', 'woo-product-feed-pro' ),
                'message' => __( 'In Product Feed ELITE for WooCommerce you can dynamically set and modify product attributes on-the-fly. This is perfect for customizing product data for different channels, adding custom labels, and optimizing feed data without touching your product catalog.', 'woo-product-feed-pro' ),
                'link'    => Helper::get_utm_url( 'pricing', 'pfp', 'upsell', 'setattrrules' ),
            ),
            'rule_action_exclude'       => array(
                'title'   => __( 'Upgrade to Exclude Attributes with Rules', 'woo-product-feed-pro' ),
                'message' => __( 'In Product Feed ELITE for WooCommerce you can exclude specific attributes from your feed based on advanced rules and criteria. Perfect for removing sensitive data, hiding irrelevant fields, or omitting attributes that don\'t meet channel requirements—keeping your feed streamlined and compliant.', 'woo-product-feed-pro' ),
                'link'    => Helper::get_utm_url( 'pricing', 'pfp', 'upsell', 'excludeattributesrule' ),
            ),
            'custom_refresh_interval'   => array(
                'title'   => __( 'Upgrade to set custom refresh interval', 'woo-product-feed-pro' ),
                'message' => __( 'In Product Feed ELITE for WooCommerce you can set custom refresh intervals and specific times for your feeds. Schedule feeds to run hourly, daily, weekly, yearly or every X hours at specific times (e.g., daily at 11 PM). Perfect for optimizing server performance during off-peak hours and ensuring feeds complete before the next refresh cycle.', 'woo-product-feed-pro' ),
                'link'    => Helper::get_utm_url( 'pricing', 'pfp', 'upsell', 'customrefreshinterval' ),
            ),
            'import_feeds'              => array(
                'title'   => __( 'Upgrade to import feeds', 'woo-product-feed-pro' ),
                'message' => __( 'In Product Feed ELITE for WooCommerce you can import feed configurations from JSON files. Perfect for migrating feeds between sites, restoring backups, or bulk importing multiple feed setups at once. Save hours of manual configuration work.', 'woo-product-feed-pro' ),
                'link'    => Helper::get_utm_url( 'pricing', 'pfp', 'upsell', 'importfeeds' ),
            ),
        );

        /**
         * Filter the upsell l10n.
         *
         * @since 13.4.7
         * @param array $l10n The upsell l10n.
         * @return array The filtered upsell l10n.
         */
        $popup_upsells = apply_filters( 'adt_pfp_upsell_l10n', $popup_upsells );

        $upsell_l10n = array();
        foreach ( $popup_upsells as $key => $args ) {
            $upsell_l10n[ $key ]['title']   = $args['title'];
            $upsell_l10n[ $key ]['content'] = $this->_generate_upsell_popup_content( $args );
        }

        return $upsell_l10n;
    }

        /**
         * Generate upsell popup content html markup.
         *
         * @since 4.5.1
         * @access private
         *
         * @param array $args Content arguments.
         * @return string Content markup.
         */
    private function _generate_upsell_popup_content( $args ) {

        $args = wp_parse_args(
            $args,
            array(
                'title'   => '',
                'message' => '',
                'link'    => '',
            )
        );

        // Extracted variables are defined above.
        extract( $args ); // phpcs:ignore

        $html  = sprintf( '<img src="%1$s" alt="%2$s" />', ADT_PFP_IMAGES_URL . '/logo.svg', __( 'Product Feed Pro for WooCommerce', 'woo-product-feed-pro' ) );
        $html .= sprintf( '<h3>%s</h3>', $title );
        $html .= sprintf( '<p>%s</p>', $message );
        if ( ! empty( $link ) ) {
            $html .= sprintf( '<a href="%s" target="_blank">%s</a>', $link, __( 'See all features & pricing →', 'woo-product-feed-pro' ) );
        }

        return wp_kses_post( $html );
    }

    /**
     * Enqueue admin styles and scripts.
     *
     * @since 13.4.6
     * @access public
     */
    public function admin_enqueue_scripts() {
        // Enqueue scripts and styles only on the plugin pages.
        if ( ! Helper::is_plugin_page() ) {
            return;
        }

        // Vex Modal.
        wp_enqueue_style( 'adt-vex', ADT_PFP_JS_URL . 'lib/vex/vex.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
        wp_enqueue_style( 'adt-vex-theme-plain', ADT_PFP_JS_URL . 'lib/vex/vex-theme-plain.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
        wp_enqueue_script( 'adt-vex', ADT_PFP_JS_URL . 'lib/vex/vex.combined.min.js', array( 'jquery' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
        wp_add_inline_script( 'adt-vex', 'vex.defaultOptions.className = "vex-theme-plain"', 'after' );

        // Vite app - Upsell.
        $app = new Vite_App(
            'adt-upsell-script',
            'src/vanilla/upsell/index.ts',
            array( 'jquery' ),
            array(),
            'adtObj',
            array()
        );
        $app->enqueue();
    }

    /**
     * Add custom refresh interval upsell fields.
     *
     * @since 13.4.7
     * @access public
     */
    public function add_custom_refresh_interval_upsell_fields() {
        Helper::locate_admin_template(
            'upsell/custom-refresh-interval.php',
            true,
            true
        );
    }

    /**
     * Add custom refresh interval options.
     *
     * @since 13.4.7
     * @access public
     *
     * @param array $refresh_arr The refresh interval options.
     * @return array
     */
    public function add_custom_refresh_interval_upsell_options( $refresh_arr ) {
        $refresh_arr[] = 'custom_upsell';
        return $refresh_arr;
    }

    /**
     * Add custom refresh interval labels.
     *
     * @since 13.4.7
     * @access public
     *
     * @param array $refresh_labels The refresh interval labels.
     * @return array
     */
    public function add_custom_refresh_interval_upsell_labels( $refresh_labels ) {
        $refresh_labels['custom_upsell'] = __( 'Custom (Elite)', 'woo-product-feed-pro' );
        return $refresh_labels;
    }

    /**
     * Show custom refresh interval notice.
     *
     * @since 13.4.7
     * @access public
     *
     * @param array|object|null $feed The feed data.
     * @return void
     */
    public static function show_custom_refresh_interval_notice( $feed ) {
        if ( Product_Feed_Helper::is_a_product_feed( $feed ) && ! Helper::has_paid_plugin_active() ) {
            $refresh_interval = $feed->refresh_interval ?? '';
            if ( 'custom' === $refresh_interval ) {
                $admin_notice = new Admin_Notice(
                    __( 'The refresh interval has been automatically set to ‘No Refresh’ because the Elite plugin is deactivated. Custom refresh intervals are only available with the Elite version.', 'woo-product-feed-pro' ),
                    'warning',
                    false,
                    true
                );
                $admin_notice->run();
            }
        }
    }

    /**
     * Execute Notices class.
     *
     * @since 13.3.9
     * @access public
     */
    public function run() {
        if ( Helper::has_paid_plugin_active() ) {
            return;
        }

        // Enqueue admin styles and scripts.
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        // Add custom refresh interval options and labels.
        add_filter( 'adt_product_feed_refresh_interval_options', array( $this, 'add_custom_refresh_interval_upsell_options' ) );
        add_filter( 'adt_product_feed_refresh_interval_labels', array( $this, 'add_custom_refresh_interval_upsell_labels' ) );

        // Add custom refresh interval upsell fields.
        add_action( 'adt_general_feed_settings_after_refresh_interval', array( $this, 'add_custom_refresh_interval_upsell_fields' ) );
    }
}
