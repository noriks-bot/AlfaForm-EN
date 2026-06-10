<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * Shipping_Data class.
 *
 * @since 13.3.4
 */
class Google_Product_Taxonomy_Fetcher extends Abstract_Class {

    use Singleton_Trait;

    const GOOGLE_PRODUCT_TAXONOMY_FILE_NAME = 'taxonomy-with-ids.en-US.txt';

    const GOOGLE_PRODUCT_TAXONOMY_SERVER_URL = 'https://adtribes.io/' . self::GOOGLE_PRODUCT_TAXONOMY_FILE_NAME;

    const GOOGLE_PRODUCT_TAXONOMY_FILE_PATH = WP_CONTENT_DIR . '/uploads/woo-product-feed-pro/' . self::GOOGLE_PRODUCT_TAXONOMY_FILE_NAME;

    const GOOGLE_PRODUCT_TAXONOMY_FILE_URL = WP_CONTENT_URL . '/uploads/woo-product-feed-pro/' . self::GOOGLE_PRODUCT_TAXONOMY_FILE_NAME;

    /**
     * Register the action.
     *
     * @since 13.3.4
     */
    public function register_action() {
        // Start at random time today at midnight in range of 1-3 hours.
        $timestamp = strtotime( gmdate( 'Y-m-d 00:00:00', strtotime( '+1 day' ) ) ) + wp_rand( 1 * HOUR_IN_SECONDS, 3 * HOUR_IN_SECONDS );

        // Schedule the Action Scheduler event.
        as_schedule_recurring_action(
            $timestamp,
            WEEK_IN_SECONDS,
            ADT_PFP_AS_FETCH_GOOGLE_PRODUCT_TAXONOMY
        );
    }

    /**
     * Unregister the action.
     *
     * @since 13.3.4
     */
    public function unregister_action() {
        as_unschedule_all_actions( ADT_PFP_AS_FETCH_GOOGLE_PRODUCT_TAXONOMY );
    }

    /**
     * Fetch Google Product Taxonomy.
     *
     * @since 13.3.4
     */
    public function as_fetch_google_product_taxonomy() {
        $response = wp_remote_get(
            self::GOOGLE_PRODUCT_TAXONOMY_SERVER_URL,
            array(
                'timeout' => 30,
            )
        );

        if ( is_wp_error( $response ) ) {
            return;
        }

        $body = wp_remote_retrieve_body( $response );
        if ( empty( $body ) ) {
            return;
        }

        global $wp_filesystem;

        // Initialize the WordPress filesystem.
        if ( ! function_exists( 'WP_Filesystem' ) ) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        // Initialize the WordPress filesystem, return if failed.
        if ( ! WP_Filesystem() ) {
            return;
        }

        // Define the file path and ensure directory exists.
        $upload_dir = WP_CONTENT_DIR . '/uploads/woo-product-feed-pro/';
        $file_path  = $upload_dir . self::GOOGLE_PRODUCT_TAXONOMY_FILE_NAME;

        // Create directory if it doesn't exist.
        if ( ! $wp_filesystem->is_dir( $upload_dir ) ) {
            $wp_filesystem->mkdir( $upload_dir, FS_CHMOD_DIR );
        }

        // Create and write to the file using WP_Filesystem.
        $wp_filesystem->put_contents( $file_path, $body, FS_CHMOD_FILE );
    }

    /**
     * Check if the file exists.
     *
     * @since 13.3.4
     *
     * @return bool
     */
    public function is_file_exists() {
        return file_exists( self::GOOGLE_PRODUCT_TAXONOMY_FILE_PATH );
    }

    /**
     * Check if the action is in progress.
     *
     * In case the fetch action is in progress or pending, and the user already in the category mapping page,
     * we should show a message to the user that the action is in progress.
     *
     * @since 13.3.4
     *
     * @return bool
     */
    public function is_fetching() {
        // Check if the file exists.
        if ( $this->is_file_exists() ) {
            return false;
        }

        // Check if the action is in progress.
        $action = as_get_scheduled_actions(
            array(
                'hook'   => ADT_PFP_AS_FETCH_GOOGLE_PRODUCT_TAXONOMY,
                'status' => array( \ActionScheduler_Store::STATUS_RUNNING ),
            )
        );
        if ( ! empty( $action ) ) {
            return true;
        }

        return false;
    }

    /**
     * Run the class
     *
     * @codeCoverageIgnore
     * @since 13.3.4
     */
    public function run() {
        // Action Scheduler.
        add_action( ADT_PFP_AS_FETCH_GOOGLE_PRODUCT_TAXONOMY, array( $this, 'as_fetch_google_product_taxonomy' ) );
    }
}
