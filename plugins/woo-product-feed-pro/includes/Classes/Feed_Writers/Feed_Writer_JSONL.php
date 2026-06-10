<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes\Feed_Writers
 */

declare(strict_types=1);

namespace AdTribes\PFP\Classes\Feed_Writers;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * JSONL Feed Writer class.
 *
 * Handles the creation and writing of product feeds in JSONL (JSON Lines) format.
 * Each line in the output file is a valid JSON object representing a single product.
 *
 * @since 13.4.9
 */
class Feed_Writer_JSONL extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Write JSONL feed to file.
     *
     * @since 13.4.9
     *
     * @param array  $products Array of product data arrays.
     * @param object $feed Feed configuration object.
     * @param bool   $is_header Whether this is the header/initialization call.
     * @return string External file URL.
     */
    public function write_feed( array $products, object $feed, bool $is_header ): string {
        try {
            $file_paths = $this->initialize_file( $feed, $is_header );

            if ( empty( $file_paths ) ) {
                return '';
            }

            $local_file    = $file_paths['local'];
            $external_file = $file_paths['external'];

            // If header call or empty products, just return the external file path.
            if ( $is_header || empty( $products ) ) {
                return $external_file;
            }

            // Open file in append mode.
            $file_handle = fopen( $local_file, 'a' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen

            if ( false === $file_handle ) {
                $this->log_error( 'Failed to open JSONL file for writing', array( 'file' => $local_file ) );
                return $external_file;
            }

            // Write products to file.
            $this->write_products( $file_handle, $products );

            // Close the file.
            fclose( $file_handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose

            return $external_file;

        } catch ( \Exception $e ) {
            $this->log_error( 'Exception during JSONL feed writing', array( 'message' => $e->getMessage() ) );
            return '';
        }
    }

    /**
     * Initialize file paths and prepare file for writing.
     *
     * @since 13.4.9
     *
     * @param object $feed Feed configuration object.
     * @param bool   $is_header Whether this is the header/initialization call.
     * @return array Array containing local and external file paths.
     */
    private function initialize_file( object $feed, bool $is_header ): array {
        $upload_dir = wp_upload_dir();
        $base       = $upload_dir['basedir'];
        $path       = $base . '/woo-product-feed-pro/jsonl';

        // Sanitize the file name.
        $sanitized_name = sanitize_file_name( $feed->file_name );
        $local_file     = $path . '/' . $sanitized_name . '_tmp.jsonl';

        // External location for downloading the file.
        $external_base = $upload_dir['baseurl'];
        $external_path = $external_base . '/woo-product-feed-pro/jsonl';
        $external_file = $external_path . '/' . $sanitized_name . '.jsonl';

        // Check if directory exists, if not create one.
        if ( ! file_exists( $path ) ) {
            wp_mkdir_p( $path );
        }

        // Check if file exists and should be deleted for a fresh start.
        if ( file_exists( $local_file ) && $is_header && 0 === $feed->total_products_processed ) {
            wp_delete_file( $local_file );
        }

        return array(
            'local'    => $local_file,
            'external' => $external_file,
        );
    }

    /**
     * Write products to JSONL file.
     *
     * Each product is written as a single line of valid JSON.
     *
     * @since 13.4.9
     *
     * @param resource $file_handle File handle resource.
     * @param array    $products Array of product data arrays.
     * @return void
     */
    private function write_products( $file_handle, array $products ): void {
        foreach ( $products as $product ) {
            if ( empty( $product ) || ! is_array( $product ) ) {
                continue;
            }

            // Convert product array to JSON line.
            $json_line = $this->product_to_json_line( $product );

            if ( false !== $json_line ) {
                fwrite( $file_handle, $json_line . "\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite
            }
        }
    }

    /**
     * Convert product array to JSON string.
     *
     * @since 13.4.9
     *
     * @param array $product Product data array.
     * @return string|false JSON string or false on failure.
     */
    private function product_to_json_line( array $product ) {
        // Encode with options for Unicode and special characters.
        $json = wp_json_encode(
            $product,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS
        );

        if ( false === $json ) {
            $this->log_error(
                'Failed to encode product to JSON',
                array(
                    'error' => json_last_error_msg(),
                    'code'  => json_last_error(),
                )
            );
            return false;
        }

        return $json;
    }

    /**
     * Log error message using WordPress logging.
     *
     * @since 13.4.9
     *
     * @param string $message Error message.
     * @param array  $context Additional context data.
     * @return void
     */
    private function log_error( string $message, array $context = array() ): void {
        if ( function_exists( 'wc_get_logger' ) ) {
            $logger = wc_get_logger();
            $logger->error(
                $message,
                array_merge(
                    array( 'source' => 'woo-product-feed-pro-jsonl' ),
                    $context
                )
            );
        }

        // Also log to debug.log if WP_DEBUG_LOG is enabled.
        if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( 'JSONL Feed Writer: ' . $message . ' ' . wp_json_encode( $context ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
        }
    }

    /**
     * Run the class.
     *
     * @since 13.4.9
     */
    public function run() {
        // No hooks needed for this writer class.
        // It's called directly from the legacy feed generation code.
    }
}
