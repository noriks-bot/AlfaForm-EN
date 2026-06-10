<?php

/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes\Admin_Pages
 */

namespace AdTribes\PFP\Classes\Admin_Pages;

use AdTribes\PFP\Abstracts\Admin_Page;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Helpers\Helper;

/**
 * Settings_Page class.
 *
 * @since 13.4.4
 */
class Settings_Page extends Admin_Page {


    use Singleton_Trait;

    const MENU_SLUG = 'woosea_manage_settings';

    /**
     * Holds the class instance object
     *
     * @since 13.4.4
     * @access protected
     *
     * @var Singleton_Trait $instance object
     */
    protected static $instance;

    /**
     * Holds the tabs.
     *
     * @since 13.4.7
     * @var array
     */
    public $tabs;

    /**
     * Holds the active tab.
     *
     * @since 13.4.7
     * @var string
     */
    public $active_tab;

    /**
     * Initialize the class.
     *
     * @since 13.4.4
     */
    public function init() {
        $this->parent_slug   = 'woo-product-feed';
        $this->page_title    = __( 'Settings', 'woo-product-feed-pro' );
        $this->menu_title    = __( 'Settings', 'woo-product-feed-pro' );
        $this->capability    = apply_filters( 'adt_pfp_admin_capability', 'manage_options' );
        $this->menu_slug     = self::MENU_SLUG;
        $this->template      = 'settings-page.php';
        $this->position      = 30;
        $this->template_args = array();
        $this->tabs          = $this->get_tabs();
        $this->active_tab    = $this->get_active_tab();
    }

    /**
     * Get the instance.
     *
     * @since 13.4.7
     * @param array ...$args The arguments to pass to the constructor.
     * @return Settings_Page
     */
    public static function instance( ...$args ) {
        if ( class_exists( 'AdTribes\PFE\Classes\Admin_Pages\Settings_Page' ) ) {
            return \AdTribes\PFE\Classes\Admin_Pages\Settings_Page::instance( ...$args );
        }
        return parent::instance( ...$args );
    }

    /**
     * Render the tabs.
     *
     * @since 13.4.7
     * @return array
     */
    public function get_tabs() {
        $tabs = array(
            array(
                'slug'        => 'general',
                'label'       => __( 'General', 'woo-product-feed-pro' ),
                'header_text' => __( 'Plugin settings', 'woo-product-feed-pro' ),
            ),
            array(
                'slug'        => 'system_check',
                'label'       => __( 'System check', 'woo-product-feed-pro' ),
                'header_text' => __( 'Plugin systems check', 'woo-product-feed-pro' ),
            ),
            array(
                'slug'        => 'export_import',
                'label'       => __( 'Export / Import', 'woo-product-feed-pro' ),
                'header_text' => __( 'Export / Import Tools', 'woo-product-feed-pro' ),
            ),
        );

        return apply_filters( 'adt_pfp_settings_page_tabs', $tabs );
    }

    /**
     * Get the active tab.
     *
     * @since 13.4.7
     * @return string
     */
    public function get_active_tab() {
        $active_tab = '';
        if ( isset( $_GET['tab'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $active_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        }

        // If not found, return the general tab.
        if ( ! in_array( $active_tab, array_column( $this->tabs, 'slug' ), true ) ) {
            $active_tab = 'general';
        }

        return $active_tab;
    }

    /**
     * Get the header text.
     *
     * @since 13.4.7
     * @param string|null $active_tab The active tab.
     * @return string
     */
    public function get_header_text( $active_tab = null ) {
        if ( null === $active_tab ) {
            $active_tab = $this->active_tab;
        }

        $tabs = $this->tabs;

        // Find in the get_tabs() array the header_text key.
        // If not found, return the general header text.
        // Use array find.
        $key = array_search( $active_tab, array_column( $tabs, 'slug' ), true );
        if ( false !== $key ) {
            return $tabs[ $key ]['header_text'];
        }
        return $tabs[0]['header_text'] ?? '';
    }

    /**
     * Render the tab content.
     *
     * @since 13.4.7
     * @return void
     */
    public function render_tab_content() {
        $active_tab = $this->active_tab;

        // If active tab is not in the list of tabs, return the general tab.
        if ( ! in_array( $active_tab, array_column( $this->tabs, 'slug' ), true ) ) {
            Helper::locate_admin_template( 'settings/general-tab.php', true );
        } else {
            switch ( $active_tab ) {
                case 'system_check':
                    Helper::locate_admin_template( 'settings/system-check-tab.php', true );
                    break;
                case 'export_import':
                    Helper::locate_admin_template( 'settings/export-import-tab.php', true );
                    break;
                case 'general':
                    Helper::locate_admin_template( 'settings/general-tab.php', true );
                    break;
            }
        }

        do_action( 'adt_pfp_settings_page_tab_content', $active_tab );
    }

    /**
     * Get the general settings.
     *
     * @since 13.4.7
     * @return array
     */
    public function get_general_settings() {
        $settings = array(
            array(
                'title' => __( 'Use parent variable product image for variations', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'id'    => 'adt_use_parent_variable_product_image',
            ),
            array(
                'title' => __( 'Add shipping costs for all countries to your feed (Google Shopping / Facebook only)', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'id'    => 'adt_add_all_shipping',
            ),
            array(
                'title' => __( 'Remove all other shipping classes when free shipping criteria are met (Google Shopping / Facebook only)', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'id'    => 'adt_remove_other_shipping_classes_on_free_shipping',
            ),
            array(
                'title' => __( 'Remove the free shipping zone from your feed (Google Shopping / Facebook only)', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'id'    => 'adt_remove_free_shipping',
            ),
            array(
                'title' => __( 'Remove the local pickup shipping zone from your feed (Google Shopping / Facebook only)', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'id'    => 'adt_remove_local_pickup_shipping',
            ),
            array(
                'title' => __( 'Show only basis attributes in field mapping and filter/rule drop-downs', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'id'    => 'adt_show_only_basis_attributes',
            ),
            array(
                'title' => __( 'Enable logging', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'id'    => 'adt_enable_logging',
            ),
            array(
                'title'          => __( 'Add Facebook Pixel', 'woo-product-feed-pro' ),
                'read_more_link' => Helper::get_utm_url( 'facebook-pixel-feature', 'pfp', 'manage-settings', 'fbpixelsetting' ),
                'type'           => 'checkbox',
                'id'             => 'adt_add_facebook_pixel',
            ),
            array(
                'title'     => __( 'Insert your Facebook Pixel ID', 'woo-product-feed-pro' ),
                'type'      => 'text',
                'id'        => 'adt_facebook_pixel_id',
                'parent_id' => 'adt_add_facebook_pixel',
            ),
            array(
                'title'   => __( 'Content IDS variable products Facebook Pixel', 'woo-product-feed-pro' ),
                'type'    => 'select',
                'options' => array(
                    array(
                        'value' => 'variation',
                        'label' => __( 'Variation product ID\'s', 'woo-product-feed-pro' ),
                    ),
                    array(
                        'value' => 'variable',
                        'label' => __( 'Variable product ID', 'woo-product-feed-pro' ),
                    ),
                ),
                'id'      => 'adt_facebook_pixel_content_ids',
            ),
            array(
                'title' => __( 'Add Google Dynamic Remarketing Pixel:', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'id'    => 'adt_add_remarketing',
            ),
            array(
                'title'     => __( 'Insert your Dynamic Remarketing Conversion tracking ID:', 'woo-product-feed-pro' ),
                'type'      => 'text',
                'id'        => 'adt_adwords_conversion_id',
                'parent_id' => 'adt_add_remarketing',
            ),
            array(
                'title'          => __( 'Change products per batch number', 'woo-product-feed-pro' ),
                'type'           => 'checkbox',
                'id'             => 'adt_enable_batch',
                'read_more_link' => Helper::get_utm_url( 'batch-size-configuration-product-feed', 'pfp', 'manage-settings', 'batchsizesetting' ),
            ),
            array(
                'title'     => __( 'Insert batch size:', 'woo-product-feed-pro' ),
                'type'      => 'text',
                'id'        => 'adt_batch_size',
                'parent_id' => 'adt_enable_batch',
            ),
            /**
             * Disable HTTP feed generation requests setting.
             *
             * This setting, when enabled, prevents the plugin from initiating product feed generation through HTTP requests.
             * It is typically used to improve security or performance by disallowing direct HTTP triggering of feed generation
             * (e.g., via an external URL or browser-initiated request). Instead, feed generation will only proceed via
             * background tasks or internal processes.
             *
             * @since 13.4.9
             *
             * @see https://www.adtribes.io/knowledge-base/what-does-disable-http-feed-generation-requests-do/
             */
            array(
                'title'          => __( 'Disable HTTP feed generation requests', 'woo-product-feed-pro' ),
                'type'           => 'checkbox',
                'id'             => 'adt_disable_http_feed_generation',
                'read_more_link' => Helper::get_utm_url( 'knowledge-base/what-does-disable-http-feed-generation-requests-do', 'pfp', 'manage-settings', 'httpfeedgenerationsetting' ),
            ),
        );

        /**
         * Filter the general settings arguments.
         *
         * @since 13.4.7
         *
         * @param array $settings Array of settings.
         * @return array
         */
        $settings = apply_filters( 'adt_general_settings_args', $settings );

        return $settings;
    }

    /**
     * Get the other settings.
     *
     * @since 13.4.7
     * @return array
     */
    public function get_other_settings() {
        $settings = array(
            array(
                'title' => __( 'Sync Product Feed', 'woo-product-feed-pro' ),
                'type'  => 'button',
                'desc'  => __( 'Sync Product Feed to custom post type and legacy options (Backwards compatibility)', 'woo-product-feed-pro' ),
                'id'    => 'adt_migrate_to_custom_post_type',
            ),
            array(
                'title' => __( 'Clear custom attributes cache', 'woo-product-feed-pro' ),
                'type'  => 'button',
                'desc'  => __( 'Clear custom attributes product meta keys cache', 'woo-product-feed-pro' ),
                'id'    => 'adt_clear_custom_attributes_product_meta_keys',
            ),
            array(
                'title' => __( 'Convert feed URLs to lowercase', 'woo-product-feed-pro' ),
                'type'  => 'button',
                'desc'  => __( 'Standardize all feed file URLs to lowercase format for better compatibility', 'woo-product-feed-pro' ),
                'id'    => 'adt_update_file_url_to_lower_case',
            ),
            array(
                'title' => __( 'Fix duplicated feed', 'woo-product-feed-pro' ),
                'type'  => 'button',
                'desc'  => __( 'This will fix the issue with duplicated feeds due to data migration abnormalities', 'woo-product-feed-pro' ),
                'id'    => 'adt_fix_duplicate_feed',
            ),
            array(
                'title' => __( 'Use legacy filters and rules', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'desc'  => __( 'Use legacy filters and rules', 'woo-product-feed-pro' ),
                'id'    => 'adt_use_legacy_filters_and_rules',
            ),
            array(
                'title'        => __( 'Clean up plugin data on un-installation', 'woo-product-feed-pro' ),
                'type'         => 'checkbox',
                'desc'         => __( 'If checked, removes all plugin data when this plugin is uninstalled. Warning: This process is irreversible.', 'woo-product-feed-pro' ),
                'id'           => ADT_PFP_CLEAN_UP_PLUGIN_OPTIONS,
                'class'        => 'adt-pfp-general-setting',
                'confirmation' => __( 'Are you sure you want to clean up plugin data on un-installation?', 'woo-product-feed-pro' ),
                'show_title'   => true,
            ),
        );

        /**
         * Filter the other settings arguments.
         *
         * @since 13.3.7
         *
         * @param array $settings Array of settings.
         * @return array
         */
        $settings = apply_filters( 'adt_settings_other_settings_args', $settings );

        return $settings;
    }

    /**
     * Get the admin menu priority.
     *
     * @since 13.4.4
     * @return int
     */
    protected function get_priority() {
        return 30;
    }

    /**
     * Change default footer text, asking to review our plugin.
     *
     * @param string $default_text Default footer text.
     * @return string Footer text asking to review our plugin.
     **/
    public function settings_page_footer_text( $default_text ) {
        $screen = get_current_screen();
        if ( strpos( $screen->id, 'woosea_manage_settings' ) === false ) {
            return $default_text;
        }

        $rating_link = sprintf(
            /* translators: %s: WooCommerce Product Feed PRO plugin rating link */
            esc_html__( 'If you like our %1$s plugin please leave us a %2$s rating. Thanks in advance!', 'woo-product-feed-pro' ),
            '<strong>WooCommerce Product Feed PRO</strong>',
            '<a href="https://wordpress.org/support/plugin/woo-product-feed-pro/reviews?rate=5#new-post" target="_blank" class="woo-product-feed-pro-ratingRequest">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
        );
        return $rating_link;
    }

    /**
     * Run the class.
     *
     * @since 13.4.7
     */
    public function run() {
        parent::run();

        add_filter( 'admin_footer_text', array( $this, 'settings_page_footer_text' ) );
    }
}
