<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * Product Feed Admin class.
 *
 * @since 13.3.5
 */
class Product_Feed_Admin extends Abstract_Class {

    use Singleton_Trait;

    /***************************************************************************
     * AJAX Actions
     * **************************************************************************
     */

    /**
     * Update product feed status.
     *
     * This method is used to update the product feed status after generating the products from the legacy code base.
     *
     * @since 13.3.5
     * @access public
     */
    public function ajax_update_product_feed_status() {
        $security = isset( $_REQUEST['security'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ) : '';
        if ( ! wp_verify_nonce( $security, 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to manage product feed.', 'woo-product-feed-pro' ) );
        }

        $project_hash = sanitize_text_field( wp_unslash( $_POST['project_hash'] ?? '' ) );
        $is_publish   = sanitize_text_field( wp_unslash( $_POST['active'] ?? '' ) );

        $feed = Product_Feed_Helper::get_product_feed( $project_hash );
        if ( ! $feed ) {
            wp_send_json_error( __( 'Product feed not found.', 'woo-product-feed-pro' ) );
        }

        // Remove file if set to draft.
        if ( 'true' !== $is_publish ) {
            $feed->remove_file();
            $feed->unregister_action();
        } else {
            // Remove cache.
            Product_Feed_Helper::disable_cache();

            $feed->register_action();

            // Generate the feed.
            $feed->generate( 'manual' );
        }

        $feed->post_status = 'true' === $is_publish ? 'publish' : 'draft';
        $feed->save();

        $response = array(
            'project_hash' => $project_hash,
            'status'       => $feed->post_status,
        );

        wp_send_json_success( apply_filters( 'adt_product_feed_status_response', $response, $feed ) );
    }

    /**
     * Clone product feed.
     *
     * @since 13.3.5
     * @access public
     *
     * @return void
     */
    public function ajax_clone_product_feed() {
        $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
        if ( ! wp_verify_nonce( $nonce, 'adt_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to manage product feed.', 'woo-product-feed-pro' ) );
        }

        $original_feed = Product_Feed_Helper::get_product_feed( sanitize_text_field( wp_unslash( $_POST['id'] ?? '' ) ) );
        if ( ! $original_feed ) {
            wp_send_json_error( __( 'Product feed not found.', 'woo-product-feed-pro' ) );
        }

        // Generate a new project hash for the cloned feed.
        $project_hash = Product_Feed_Helper::generate_legacy_project_hash();

        // Clone the feed.
        $new_feed     = clone $original_feed;
        $new_feed->id = 0; // Reset ID to create a new entry.

        // translators: %s is the feed title.
        $new_feed->title               = sprintf( __( 'Copy of %s', 'woo-product-feed-pro' ), $original_feed->title );
        $new_feed->post_status         = 'draft';
        $new_feed->status              = 'not run yet';
        $new_feed->legacy_project_hash = $project_hash;
        $new_feed->file_name           = $project_hash;
        $new_feed->last_updated        = '';

        /**
         * Filter the cloned product feed.
         *
         * @since 13.4.4
         *
         * @param Product_Feed_Factory $new_feed The cloned product feed.
         * @param Product_Feed_Factory $feed     The original product feed.
         */
        do_action( 'adt_clone_product_feed_before_save', $new_feed, $original_feed );

        // Save the new feed.
        $new_feed->save();

        // Register the new feed action.
        $new_feed->register_action();

        $response = array(
            'project_hash'  => $new_feed->legacy_project_hash,
            'channel'       => $new_feed->channel_hash,
            'projectname'   => $new_feed->title,
            'fileformat'    => $new_feed->file_format,
            'interval'      => $new_feed->refresh_interval,
            'external_file' => $new_feed->get_file_url(),
            'copy_status'   => true,  // Do not start processing, user wants to make changes to the copied project.
        );

        wp_send_json_success( apply_filters( 'adt_clone_product_feed_response', $response, $new_feed ) );
    }

    /**
     * Handle AJAX request to cancel processing a product feed.
     *
     * @since 13.4.5
     * @access public
     *
     * @return void
     */
    public function ajax_cancel_product_feed() {
        check_ajax_referer( 'adt_nonce', 'nonce' );

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error(
                array(
                    'message' => __( 'You do not have permission to cancel feeds.', 'woo-product-feed-pro' ),
                )
            );
            return;
        }

        $feed_id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;

        if ( ! $feed_id ) {
            wp_send_json_error(
                array(
                    'message' => __( 'No feed ID provided.', 'woo-product-feed-pro' ),
                )
            );
            return;
        }

        $feed = Product_Feed_Helper::get_product_feed( $feed_id );

        if ( ! $feed ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Feed not found.', 'woo-product-feed-pro' ),
                )
            );
            return;
        }

        do_action( 'adt_before_cancel_product_feed', $feed );

        // Remove the scheduled event.
        as_unschedule_all_actions( '', array(), 'adt_pfp_as_generate_product_feed_batch_' . $feed->id );

        $feed->total_products_processed = 0;
        $feed->batch_size               = 0;
        $feed->executed_from            = '';
        $feed->status                   = 'stopped';
        $feed->last_updated             = gmdate( 'd M Y H:i:s' );
        $feed->save();

        /**
         * Check the amount of products in the feed and update the history count.
         */
        as_schedule_single_action( time() + 1, 'adt_pfp_as_product_feed_update_stats', array( 'feed_id' => $feed->id ) );

        do_action( 'adt_after_cancel_product_feed', $feed );

        wp_send_json_success(
            array(
                'feed_id' => $feed_id,
                'message' => __( 'Feed processing has been cancelled.', 'woo-product-feed-pro' ),
            )
        );
    }

    /**
     * Refresh product feed.
     *
     * @since 13.3.5
     * @access public
     */
    public function ajax_refresh_product_feed() {
        $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
        if ( ! wp_verify_nonce( $nonce, 'adt_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to manage product feed.', 'woo-product-feed-pro' ) );
        }

        $feed_id = sanitize_text_field( wp_unslash( $_POST['id'] ?? '' ) );

        $feed = Product_Feed_Helper::get_product_feed( $feed_id );
        if ( ! $feed ) {
            wp_send_json_error( __( 'Product feed not found.', 'woo-product-feed-pro' ) );
        }

        // Remove cache.
        Product_Feed_Helper::disable_cache();

        /**
         * Run the product feed batch processing.
         */
        $response = $feed->generate( 'manual' );

        wp_send_json_success( $response );
    }

    /**
     * Delete product feed.
     *
     * @since 13.3.5
     * @access public
     *
     * @return void
     */
    public function ajax_delete_product_feed() {
        $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
        if ( ! wp_verify_nonce( $nonce, 'adt_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to manage product feed.', 'woo-product-feed-pro' ) );
        }

        $feed_id = sanitize_text_field( wp_unslash( $_POST['id'] ?? '' ) );

        $feed = Product_Feed_Helper::get_product_feed( $feed_id );
        if ( ! $feed ) {
            wp_send_json_error( __( 'Product feed not found.', 'woo-product-feed-pro' ) );
        }

        do_action( 'adt_before_delete_product_feed', $feed );

        $feed->delete();

        do_action( 'adt_after_delete_product_feed', $feed );

        wp_send_json_success( __( 'Product feed has been deleted.', 'woo-product-feed-pro' ) );
    }

    /**
     * Print channel options for the channel dropdown.
     *
     * @since 13.4.2
     * @access public
     */
    public function ajax_print_channels() {
        $security = isset( $_REQUEST['security'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ) : '';
        if ( ! wp_verify_nonce( $security, 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Nonce verification failed', 'woo-product-feed-pro' ) );
        }

        $country  = sanitize_text_field( wp_unslash( $_POST['country'] ?? '' ) );
        $channels = Product_Feed_Attributes::get_channels( $country );
        $data     = Product_Feed_Helper::print_channel_options( $channels );
        wp_send_json_success( $data );
    }

    /**
     * Process bulk feed actions.
     *
     * @since  13.4.4
     * @access public
     *
     * @return void
     */
    public function ajax_process_bulk_feed_actions() {
        $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
        if ( ! wp_verify_nonce( $nonce, 'adt_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to manage product feeds.', 'woo-product-feed-pro' ) );
        }

        $feed_ids = isset( $_POST['feed_ids'] ) ? array_map( 'intval', (array) $_POST['feed_ids'] ) : array();
        $action   = isset( $_POST['bulk_action'] ) ? sanitize_text_field( wp_unslash( $_POST['bulk_action'] ) ) : '';

        if ( empty( $feed_ids ) || empty( $action ) ) {
            wp_send_json_error( __( 'Invalid request. Feed IDs or action missing.', 'woo-product-feed-pro' ) );
        }

        $processed_count = 0;
        $errors          = array();

        // Process each feed based on the action.
        foreach ( $feed_ids as $feed_id ) {
            $feed = Product_Feed_Helper::get_product_feed( $feed_id );

            if ( ! $feed ) {
                // translators: %s is the feed ID.
                $errors[] = sprintf( __( 'Feed with ID %d not found.', 'woo-product-feed-pro' ), $feed_id );
                continue;
            }

            switch ( $action ) {
                case 'delete':
                    try {
                        do_action( 'adt_before_delete_product_feed', $feed );
                        $feed->delete();
                        do_action( 'adt_after_delete_product_feed', $feed );
                        ++$processed_count;
                    } catch ( \Exception $e ) {
                        // translators: %s is the error message.
                        $errors[] = sprintf( __( 'Error deleting feed ID %1$d: %2$s', 'woo-product-feed-pro' ), $feed_id, $e->getMessage() );
                    }
                    break;

                case 'duplicate':
                    try {
                        // Generate a new project hash for the cloned feed.
                        $project_hash = Product_Feed_Helper::generate_legacy_project_hash();

                        // Clone the feed.
                        $new_feed     = clone $feed;
                        $new_feed->id = 0; // Reset ID to create a new entry.

                        // translators: %s is the feed title.
                        $new_feed->title               = sprintf( __( 'Copy of %s', 'woo-product-feed-pro' ), $feed->title );
                        $new_feed->post_status         = 'draft';
                        $new_feed->status              = 'not run yet';
                        $new_feed->legacy_project_hash = $project_hash;
                        $new_feed->file_name           = $project_hash;
                        $new_feed->last_updated        = '';

                        /**
                         * Filter the cloned product feed.
                         *
                         * @since 13.4.4
                         *
                         * @param Product_Feed_Factory $new_feed The cloned product feed.
                         * @param Product_Feed_Factory $feed     The original product feed.
                         */
                        do_action( 'adt_clone_product_feed_before_save', $new_feed, $feed );

                        // Save the new feed.
                        $new_feed->save();

                        // Register the new feed action.
                        $new_feed->register_action();

                        do_action( 'adt_after_clone_product_feed', $new_feed, $feed );
                        ++$processed_count;
                    } catch ( \Exception $e ) {
                        // translators: %s is the error message.
                        $errors[] = sprintf( __( 'Error duplicating feed ID %1$d: %2$s', 'woo-product-feed-pro' ), $feed_id, $e->getMessage() );
                    }
                    break;

                case 'activate':
                    try {
                        $feed->post_status = 'publish';
                        $feed->save();
                        $feed->register_action();
                        ++$processed_count;
                    } catch ( \Exception $e ) {
                        // translators: %s is the error message.
                        $errors[] = sprintf( __( 'Error setting feed ID %1$d as ready: %2$s', 'woo-product-feed-pro' ), $feed_id, $e->getMessage() );
                    }
                    break;

                case 'deactivate':
                    try {
                        $feed->post_status = 'draft';
                        $feed->save();
                        $feed->unregister_action();
                        ++$processed_count;
                    } catch ( \Exception $e ) {
                        // translators: %s is the error message.
                        $errors[] = sprintf( __( 'Error deactivating feed ID %1$d: %2$s', 'woo-product-feed-pro' ), $feed_id, $e->getMessage() );
                    }
                    break;

                case 'refresh':
                    try {
                        // Remove cache.
                        Product_Feed_Helper::disable_cache();

                        // Generate the feed.
                        $feed->generate( 'manual' );
                        ++$processed_count;
                    } catch ( \Exception $e ) {
                        // translators: %s is the error message.
                        $errors[] = sprintf( __( 'Error refreshing feed ID %1$d: %2$s', 'woo-product-feed-pro' ), $feed_id, $e->getMessage() );
                    }
                    break;

                case 'cancel':
                    try {
                        do_action( 'adt_before_cancel_product_feed', $feed );

                        // Remove the scheduled event using Action Scheduler.
                        as_unschedule_all_actions( '', array(), 'adt_pfp_as_generate_product_feed_batch_' . $feed->id );

                        // Update feed status.
                        $feed->total_products_processed = 0;
                        $feed->batch_size               = 0;
                        $feed->executed_from            = '';
                        $feed->status                   = 'stopped';
                        $feed->last_updated             = gmdate( 'd M Y H:i:s' );
                        $feed->save();

                        // Schedule stats update.
                        as_schedule_single_action( time() + 1, 'adt_pfp_as_product_feed_update_stats', array( 'feed_id' => $feed->id ) );

                        do_action( 'adt_after_cancel_product_feed', $feed );
                        ++$processed_count;
                    } catch ( \Exception $e ) {
                        // translators: %s is the error message.
                        $errors[] = sprintf( __( 'Error canceling feed ID %1$d: %2$s', 'woo-product-feed-pro' ), $feed_id, $e->getMessage() );
                    }
                    break;

                default:
                    // translators: %s is the action name.
                    $errors[] = sprintf( __( 'Unknown action: %s', 'woo-product-feed-pro' ), $action );
                    break;
            }
        }

        // Return results.
        if ( $processed_count > 0 ) {
            $action_text = '';
            switch ( $action ) {
                case 'delete':
                    $action_text = __( 'deleted', 'woo-product-feed-pro' );
                    break;
                case 'duplicate':
                    $action_text = __( 'duplicated', 'woo-product-feed-pro' );
                    break;
                case 'activate':
                    $action_text = __( 'activated', 'woo-product-feed-pro' );
                    break;
                case 'deactivate':
                    $action_text = __( 'deactivated', 'woo-product-feed-pro' );
                    break;
                case 'refresh':
                    $action_text = __( 'refreshed', 'woo-product-feed-pro' );
                    break;
                case 'cancel':
                    $action_text = __( 'cancelled', 'woo-product-feed-pro' );
                    break;
            }

            $message = sprintf(
                // translators: %1$d is the number of feeds processed, %2$s is the action name.
                _n(
                    '%1$d feed was successfully %2$s.',
                    '%1$d feeds were successfully %2$s.',
                    $processed_count,
                    'woo-product-feed-pro'
                ),
                $processed_count,
                $action_text
            );

            if ( ! empty( $errors ) ) {
                $message .= ' ' . __( 'However, some errors occurred:', 'woo-product-feed-pro' ) . ' ' . implode( ' ', $errors );
            }

            // Get current page and per_page from referer if available.
            $referer      = wp_get_referer();
            $current_page = 1;
            $per_page     = 10;

            if ( $referer ) {
                $parsed_url = wp_parse_url( $referer, PHP_URL_QUERY );
                if ( $parsed_url ) {
                    parse_str( $parsed_url, $query_params );
                    $current_page = isset( $query_params['page_num'] ) ? intval( $query_params['page_num'] ) : 1;
                    $per_page     = isset( $query_params['per_page'] ) ? intval( $query_params['per_page'] ) : 10;

                    // If feeds were deleted, we may need to adjust the current page.
                    if ( 'delete' === $action ) {
                        // Get total feeds count after deletion.
                        $total_items = Product_Feed_Helper::get_total_feeds_count();
                        $total_pages = ceil( $total_items / $per_page );

                        // If current page is now beyond the total pages, adjust it.
                        if ( $current_page > $total_pages && $total_pages > 0 ) {
                            $current_page = $total_pages;
                        } elseif ( 0 === $total_pages ) {
                            $current_page = 1;
                        }
                    }
                }
            }

            wp_send_json_success(
                array(
                    'message'         => $message,
                    'processed_count' => $processed_count,
                    'errors'          => $errors,
                    'pagination'      => array(
                        'current_page' => $current_page,
                        'per_page'     => $per_page,
                    ),
                    // Add feed info for refresh action for client-side handling.
                    'feeds'           => 'refresh' === $action ? array_map(
                        function ( $feed_id ) {
                            return array(
                                'feed_id'       => $feed_id,
                                'executed_from' => defined( 'ADT_PFP_MANUAL_REFRESH_FEED_EXECUTION_METHOD' ) ? ADT_PFP_MANUAL_REFRESH_FEED_EXECUTION_METHOD : 'cron',
                                'offset'        => 0,
                                'batch_size'    => 750,
                            );
                        },
                        $feed_ids
                    ) : array(),
                )
            );
        } else {
            wp_send_json_error(
                array(
                    'message' => __( 'Failed to process any feeds.', 'woo-product-feed-pro' ) . ' ' . implode( ' ', $errors ),
                    'errors'  => $errors,
                )
            );
        }
    }

    /**
     * Handle AJAX request to activate a product feed.
     *
     * @since 13.4.5
     * @access public
     *
     * @return void
     */
    public function ajax_activate_product_feed() {
        check_ajax_referer( 'adt_nonce', 'nonce' );

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error(
                array(
                    'message' => __( 'You do not have permission to activate feeds.', 'woo-product-feed-pro' ),
                )
            );
            return;
        }

        $feed_id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;

        if ( ! $feed_id ) {
            wp_send_json_error(
                array(
                    'message' => __( 'No feed ID provided.', 'woo-product-feed-pro' ),
                )
            );
            return;
        }

        $feed = Product_Feed_Helper::get_product_feed( $feed_id );
        if ( ! $feed ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Feed not found.', 'woo-product-feed-pro' ),
                )
            );
            return;
        }

        try {
            // Set post status to publish (activate feed).
            $feed->post_status = 'publish';
            $feed->save();
            $feed->register_action();

            wp_send_json_success(
                array(
                    'message' => __( 'Feed activated successfully.', 'woo-product-feed-pro' ),
                )
            );
        } catch ( \Exception $e ) {
            wp_send_json_error(
                array(
                    'message' => $e->getMessage(),
                )
            );
        }
    }

    /**
     * Handle AJAX request to deactivate a product feed.
     *
     * @since 13.4.5
     * @access public
     *
     * @return void
     */
    public function ajax_deactivate_product_feed() {
        check_ajax_referer( 'adt_nonce', 'nonce' );

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error(
                array(
                    'message' => __( 'You do not have permission to deactivate feeds.', 'woo-product-feed-pro' ),
                )
            );
            return;
        }

        $feed_id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;

        if ( ! $feed_id ) {
            wp_send_json_error(
                array(
                    'message' => __( 'No feed ID provided.', 'woo-product-feed-pro' ),
                )
            );
            return;
        }

        $feed = Product_Feed_Helper::get_product_feed( $feed_id );
        if ( ! $feed ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Feed not found.', 'woo-product-feed-pro' ),
                )
            );
            return;
        }

        try {
            // Set post status to draft (deactivate feed).
            $feed->post_status = 'draft';
            $feed->save();
            $feed->unregister_action();

            wp_send_json_success(
                array(
                    'message' => __( 'Feed deactivated successfully.', 'woo-product-feed-pro' ),
                )
            );
        } catch ( \Exception $e ) {
            wp_send_json_error(
                array(
                    'message' => $e->getMessage(),
                )
            );
        }
    }

    /**
     * Run the class
     *
     * @codeCoverageIgnore
     * @since 13.3.3
     */
    public function run() {
        // AJAX actions.
        add_action( 'wp_ajax_adt_feed_action_clone', array( $this, 'ajax_clone_product_feed' ) );
        add_action( 'wp_ajax_adt_feed_action_delete', array( $this, 'ajax_delete_product_feed' ) );
        add_action( 'wp_ajax_adt_feed_action_refresh', array( $this, 'ajax_refresh_product_feed' ) );
        add_action( 'wp_ajax_adt_feed_action_cancel', array( $this, 'ajax_cancel_product_feed' ) );
        add_action( 'wp_ajax_adt_feed_action_activate', array( $this, 'ajax_activate_product_feed' ) );
        add_action( 'wp_ajax_adt_feed_action_deactivate', array( $this, 'ajax_deactivate_product_feed' ) );
        add_action( 'wp_ajax_adt_process_bulk_feed_actions', array( $this, 'ajax_process_bulk_feed_actions' ) );

        add_action( 'wp_ajax_woosea_project_status', array( $this, 'ajax_update_product_feed_status' ) );
        add_action( 'wp_ajax_woosea_print_channels', array( $this, 'ajax_print_channels' ) );
    }
}
