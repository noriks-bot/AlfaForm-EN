<?php
use AdTribes\PFP\Factories\Product_Feed_Query;

/**
 * Class holding the notification messages and type of notices
 * Returns the message and type of message (info, error, success)
 */
class WooSEA_Get_Admin_Notifications {

    /**
     * Holds the message and type of message
     *
     * @var array $notification_details
     */
    public $notification_details = array();

    /**
     * Constructor
     */
    public function __construct() {}

    /**
     * Debug information for the product feed.
     *
     * @param array $versions       The versions of the plugin and WooCommerce.
     * @param array $product_numbers The product numbers.
     * @param array $order_rows      The order rows.
     * @return string The debug information.
     */
    public function woosea_debug_informations( $versions, $product_numbers, $order_rows ) {
        // Log timestamp.
        $debug_info  = "\n";
        $debug_info .= gmdate( 'F j, Y, g:i a' ); // e.g. March 10, 2001, 5:16 pm.
        $debug_info .= "\n";

        $debug_info .= print_r( $versions, true ); // phpcs:ignore
        $debug_info .= print_r( $product_numbers, true ); // phpcs:ignore
        $debug_info .= print_r( $order_rows, true ); // phpcs:ignore

        $product_feeds_query = new Product_Feed_Query(
            array(
                'post_status'    => array( 'draft', 'publish' ),
                'posts_per_page' => -1,
            ),
            'edit'
        );

        $debug_product_feeds = array();
        if ( $product_feeds_query->have_posts() ) {
            foreach ( $product_feeds_query->get_posts() as $product_feed ) {
                $debug_product_feeds[ $product_feed->id ] = $product_feed;
            }
        }

        $debug_info .= print_r( $debug_product_feeds, true ); // phpcs:ignore

        return $debug_info;
    }
}
