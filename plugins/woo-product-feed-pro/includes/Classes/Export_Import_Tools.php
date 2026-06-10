<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Factories\Vite_App;
use AdTribes\PFP\Factories\Product_Feed_Query;
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Classes\Upsell;

/**
 * Filters class with backwards compatibility.
 *
 * @since 13.4.7
 */
class Export_Import_Tools extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Enqueue scripts
     *
     * @since 13.4.7
     * @access public
     */
    public function enqueue_scripts() {
        $page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $tab  = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

        // Enqueue scripts only on the settings page.
        if ( 'woosea_manage_settings' !== $page || 'export_import' !== $tab ) {
            return;
        }

        $vite_app = new Vite_App(
            'adt-export-import-tools-script',
            'src/vanilla/export-import-tools/index.ts',
            array( 'jquery', 'wp-i18n' ),
            array(
                'exportImportNonce' => wp_create_nonce( 'adt_export_import_tools' ),
                'upsellL10n'        => Upsell::instance()->upsell_l10n(),
                'isEliteActive'     => Helper::has_paid_plugin_active(),
            ),
            'adtObj',
            array()
        );
        $vite_app->enqueue();
    }

    /**
     * AJAX export import tools.
     *
     * @since 13.4.7
     * @access public
     */
    public function ajax_export_import_tools() {
        $action = isset( $_POST['action_type'] ) ? sanitize_text_field( wp_unslash( $_POST['action_type'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $nonce  = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing

        if ( ! wp_verify_nonce( $nonce, 'adt_export_import_tools' ) ) {
            wp_send_json_error( __( 'Invalid nonce', 'woo-product-feed-pro' ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to perform this action.', 'woo-product-feed-pro' ) );
        }

        switch ( $action ) {
            case 'export_all_feeds':
                $this->export_feeds();
                break;
            case 'export_selected_feeds':
                $feed_ids = isset( $_POST['feed_ids'] ) ? array_map( 'absint', wp_unslash( $_POST['feed_ids'] ) ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Missing
                $this->export_feeds( $feed_ids );
                break;
            case 'get_feeds_for_dropdown':
                $this->get_feeds_for_dropdown();
                break;
            case 'import_feeds':
                if ( ! Helper::has_paid_plugin_active() ) {
                    wp_send_json_error( __( 'Elite plugin required for import functionality.', 'woo-product-feed-pro' ) );
                }
                /**
                 * Action to import feeds.
                 *
                 * @since 13.4.7
                 */
                do_action( 'adt_tools_action_import_feeds' );
                break;
            default:
                wp_send_json_error( __( 'Invalid action', 'woo-product-feed-pro' ) );
        }
    }

    /**
     * Export feeds.
     *
     * @since 13.4.7
     * @access private
     *
     * @param array $feed_ids Optional. Array of feed IDs to export. If empty, exports all feeds.
     */
    private function export_feeds( $feed_ids = array() ) {
        // Validate feed IDs if provided.
        if ( ! empty( $feed_ids ) && empty( array_filter( $feed_ids ) ) ) {
            wp_send_json_error( __( 'No feeds selected for export.', 'woo-product-feed-pro' ) );
        }

        try {
            $export_data = array();

            if ( empty( $feed_ids ) ) {
                // Export all feeds.
                $query = new Product_Feed_Query(
                    array(
                        'post_status'    => array( 'publish', 'draft' ),
                        'posts_per_page' => -1,
                    )
                );

                $feeds = $query->get_posts();

                foreach ( $feeds as $feed ) {
                    if ( $feed instanceof Product_Feed ) {
                        $export_data[] = $this->format_feed_for_export( $feed );
                    }
                }
            } else {
                // Export selected feeds.
                foreach ( $feed_ids as $feed_id ) {
                    $feed = new Product_Feed( $feed_id );
                    if ( $feed->id > 0 ) {
                        $export_data[] = $this->format_feed_for_export( $feed );
                    }
                }
            }

            // Prepare export data with metadata.
            $export_package = array(
                'version'        => '1.0.0',
                'export_date'    => current_time( 'Y-m-d H:i:s' ),
                'site_url'       => get_site_url(),
                'plugin_version' => defined( 'WOOCOMMERCESEA_PLUGIN_VERSION' ) ? WOOCOMMERCESEA_PLUGIN_VERSION : '13.4.7',
                'total_feeds'    => count( $export_data ),
                'feeds'          => $export_data,
            );

            // Generate filename.
            $filename_suffix = empty( $feed_ids ) ? '' : '-selected';
            $filename        = 'product-feeds-export' . $filename_suffix . '-' . gmdate( 'Y-m-d-H-i-s' ) . '.json';

            // Prepare success message.
            $message_template = empty( $feed_ids )
                /* translators: %d: number of feeds exported */
                ? __( 'Successfully exported %d feeds.', 'woo-product-feed-pro' )
                /* translators: %d: number of feeds exported */
                : __( 'Successfully exported %d selected feeds.', 'woo-product-feed-pro' );

            wp_send_json_success(
                array(
                    'action'   => 'download',
                    'filename' => $filename,
                    'data'     => wp_json_encode( $export_package, JSON_PRETTY_PRINT ),
                    'message'  => sprintf(
                        /* translators: %d: number of feeds exported */
                        $message_template,
                        count( $export_data )
                    ),
                )
            );
        } catch ( \Exception $e ) {
            wp_send_json_error(
                array(
                    'message' => sprintf(
                        /* translators: %s: error message */
                        __( 'Export failed: %s', 'woo-product-feed-pro' ),
                        $e->getMessage()
                    ),
                )
            );
        }
    }

    /**
     * Get feeds for dropdown.
     *
     * @since 13.4.7
     * @access private
     */
    private function get_feeds_for_dropdown() {
        try {
            // Query all product feeds.
            $query = new Product_Feed_Query(
                array(
                    'post_status'    => array( 'publish', 'draft' ),
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                )
            );

            $feeds      = $query->get_posts();
            $feeds_data = array();

            foreach ( $feeds as $feed ) {
                if ( $feed instanceof Product_Feed ) {
                    $feeds_data[] = array(
                        'id'     => $feed->id,
                        'title'  => $feed->title,
                        'status' => $feed->post_status,
                    );
                }
            }

            wp_send_json_success(
                array(
                    'feeds' => $feeds_data,
                    'total' => count( $feeds_data ),
                )
            );
        } catch ( \Exception $e ) {
            wp_send_json_error(
                array(
                    'message' => sprintf(
                        /* translators: %s: error message */
                        __( 'Failed to load feeds: %s', 'woo-product-feed-pro' ),
                        $e->getMessage()
                    ),
                )
            );
        }
    }

    /**
     * Format feed for export.
     *
     * @since 13.4.7
     * @access private
     *
     * @param Product_Feed $feed The feed object.
     * @return array
     */
    private function format_feed_for_export( $feed ) {
        // Get all feed data.
        $feed_data = array(
            'id'          => $feed->id,
            'title'       => $feed->title,
            'post_status' => $feed->post_status,
        );

        // Add all data properties.
        $data_properties = array(
            'status',
            'products_count',
            'total_products_processed',
            'batch_size',
            'executed_from',
            'country',
            'channel_hash',
            'channel',
            'file_name',
            'file_format',
            'file_url',
            'delimiter',
            'refresh_interval',
            'refresh_only_when_product_changed',
            'create_preview',
            'include_product_variations',
            'only_include_default_product_variation',
            'only_include_lowest_product_variation',
            'include_all_shipping_countries',
            'utm_enabled',
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_content',
            'utm_total_product_orders_lookback',
            'attributes',
            'mappings',
            'rules',
            'filters',
            'feed_filters',
            'feed_rules',
            'history_products',
            'ship_suffix',
            'last_updated',
            'legacy_project_hash',
            'data_version',
            'field_manipulation',
            'custom_refresh_interval',
            'wpml',
            'wcml',
            'aelia',
            'curcy',
            'translatepress',
            'polylang',
        );

        foreach ( $data_properties as $property ) {
            try {
                $feed_data[ $property ] = $feed->$property;
            } catch ( \Exception $e ) {
                // Skip properties that don't exist or cause errors.
                continue;
            }
        }

        return $feed_data;
    }

    /**
     * Run the class
     *
     * @since 13.4.7
     * @access public
     */
    public function run() {
        // Enqueue scripts.
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        // Add AJAX actions.
        add_action( 'wp_ajax_adt_export_import_tools', array( $this, 'ajax_export_import_tools' ) );
    }
}
