<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * Heartbeat class.
 *
 * @since 13.3.5
 */
class Heartbeat extends Abstract_Class {

    /**
     * Whether the feed batch has been run.
     *
     * @since 13.4.3
     * @access private
     *
     * @var boolean
     */
    private $has_run_feed_batch = false;

    use Singleton_Trait;

    /**
     * Get product feed processing status.
     *
     * @since 13.3.5
     * @access public
     *
     * @return void
     */
    public function ajax_get_product_feed_processing_status() {
        $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
        if ( ! wp_verify_nonce( $nonce, 'adt_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to manage product feed.', 'woo-product-feed-pro' ) );
        }

        if ( ! isset( $_POST['feed_ids'] ) || ! is_array( $_POST['feed_ids'] ) ) {
            wp_send_json_error( __( 'Invalid request.', 'woo-product-feed-pro' ) );
        }

        $feed_ids = array_map( 'sanitize_text_field', wp_unslash( $_POST['feed_ids'] ) );
        $response = array();

        foreach ( $feed_ids as $feed_id ) {
            $feed = Product_Feed_Helper::get_product_feed( $feed_id );
            if ( ! $feed ) {
                continue;
            }

            // Force run a single scheduled batch for the feed (only for the first feed in the queue).
            $this->maybe_run_feed_batch_action_schedules( $feed->id );

            $proc_perc = $feed->get_processing_percentage();

            $response[] = array(
                'feed_id'       => $feed->id,
                'status'        => $feed->status,
                'executed_from' => $feed->executed_from,
                'offset'        => $feed->total_products_processed,
                'batch_size'    => $feed->batch_size,
                'proc_perc'     => $proc_perc,
                'last_updated'  => \AdTribes\PFP\Helpers\Formatting::format_date( $feed->last_updated ),
                'feed_url_html' => Product_Feed_Helper::get_feed_url_html( $feed ),
            );
        }

        if ( empty( $response ) ) {
            wp_send_json_error( __( 'Product feed(s) not found.', 'woo-product-feed-pro' ) );
        }

        wp_send_json_success( apply_filters( 'adt_product_feed_processing_status_response', $response, $feed ) );
    }

    /**
     * Maybe run the feed batch action schedules.
     *
     * @since 13.4.3
     * @access private
     *
     * @param string $feed_id Feed ID.
     */
    private function maybe_run_feed_batch_action_schedules( $feed_id ) {
        // Only run once per heartbeat check.
        if ( $this->has_run_feed_batch ) {
            return;
        }

        /**
         * Check if HTTP-based feed generation should be disabled.
         *
         * When batch processing is enabled, we should not run Action Scheduler via HTTP requests
         * as this can overload the server (especially on NGINX/PHP-FPM setups).
         * Instead, rely on WordPress cron or OS-level cron to process the feed.
         *
         * @see https://wordpress.org/support/topic/bug-stuck-feed-generation-on-manage-feeds-page/
         * @since 13.4.10
         */
        $disable_http_processing = get_option( 'adt_disable_http_feed_generation', 'no' );

        // If explicitly disabled via setting, return early.
        if ( 'yes' === $disable_http_processing ) {
            return;
        }

        // Also check if batch processing is enabled - if yes, disable HTTP processing by default.
        $batch_enabled = get_option( 'adt_enable_batch', 'no' );
        if ( 'yes' === $batch_enabled ) {
            return;
        }

        $schedules = $this->query_feed_batch_action_schedules( $feed_id );

        if ( empty( $schedules ) ) {
            return;
        }

        // Force Action Scheduler to run the next scheduled batch event of the feed.
        if ( ! empty( $schedules ) && class_exists( '\ActionScheduler_QueueRunner' ) ) {
            $as_runner = \ActionScheduler_QueueRunner::instance();

            foreach ( $schedules as $schedule ) {
                if ( 'pending' === $schedule['status'] ) {
                    $as_runner->process_action( $schedule['action_id'], __( 'Product Feed: heartbeat', 'woo-product-feed-pro' ) );
                    $this->has_run_feed_batch = true;
                    break;
                }
            }
        }
    }

    /**
     * Query the import action schedules for a given plugin.
     *
     * @since 13.4.3
     * @access private
     *
     * @param string $feed_id Feed ID.
     */
    private function query_feed_batch_action_schedules( $feed_id ) {
        global $wpdb;

        $schedules = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT action_id, status, args, extended_args FROM {$wpdb->prefix}actionscheduler_actions WHERE hook=%s 
                AND (args LIKE %s OR extended_args LIKE %s)
                AND status='pending'
                ORDER BY scheduled_date_gmt ASC",
                ADT_PFP_AS_GENERATE_PRODUCT_FEED_BATCH,
                '%' . $feed_id . '%',
                '%' . $feed_id . '%',
            ),
            ARRAY_A
        );

        return $schedules;
    }

    /**
     * Generate product feed via AJAX.
     *
     * @since 13.4.1
     * @access public
     */
    public function ajax_generate_product_feed() {
        $security = isset( $_REQUEST['security'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ) : '';
        if ( ! wp_verify_nonce( $security, 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        $feed_id    = sanitize_text_field( wp_unslash( $_POST['feed_id'] ?? '' ) );
        $offset     = sanitize_text_field( wp_unslash( $_POST['offset'] ?? '' ) );
        $batch_size = sanitize_text_field( wp_unslash( $_POST['batch_size'] ?? '' ) );

        $feed = Product_Feed_Helper::get_product_feed( $feed_id );
        if ( ! $feed ) {
            wp_send_json_error( __( 'Product feed not found.', 'woo-product-feed-pro' ) );
        }

        /**
         * Check if the feed is stopped.
         *
         * If in the middle of processing a feed and the feed is stopped by the user.
         * This is to avoid the feed from continuing to process when the user has stopped it.
         */
        if ( 'stopped' === $feed->status ) {
            wp_send_json_success(
                array(
                    'feed_id'    => $feed->id,
                    'offset'     => $offset,
                    'batch_size' => $batch_size,
                    'status'     => $feed->status,
                )
            );
        }

        $feed->run_batch_event( $offset, $batch_size, 'ajax' );
    }

    /**
     * Run the class
     *
     * @codeCoverageIgnore
     * @since 13.3.5
     */
    public function run() {
        add_action( 'wp_ajax_adt_get_feed_processing_status', array( $this, 'ajax_get_product_feed_processing_status' ) );

        add_action( 'wp_ajax_adt_pfp_generate_product_feed', array( $this, 'ajax_generate_product_feed' ) );
    }
}
