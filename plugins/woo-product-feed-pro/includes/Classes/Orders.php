<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Helpers\Product_Feed_Helper;

/**
 * Orders class.
 *
 * @since 13.4.5
 */
class Orders extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Get orders for given time period used in filters.
     *
     * @since 13.4.5
     * @access public
     *
     * @param Product_Feed $feed The product feed object.
     * @return array
     */
    public static function get_orders( $feed ) {
        global $wpdb;

        $allowed_products              = array();
        $total_product_orders_lookback = $feed->utm_total_product_orders_lookback && $feed->utm_total_product_orders_lookback > 0 ? intval( $feed->utm_total_product_orders_lookback ) : 0;
        if ( $total_product_orders_lookback > 0 ) {
            /**
             * Filter the today date.
             *
             * @since 13.4.5
             * @access public
             *
             * @param string $today The today date.
             * @param Product_Feed $feed The product feed object.
             */
            $today = apply_filters( 'adt_total_product_orders_lookback_today', gmdate( 'Y-m-d' ), $feed );

            /**
             * Filter the today limit date.
             *
             * @since 13.4.5
             * @access public
             *
             * @param string $today_limit The today limit date.
             * @param Product_Feed $feed The product feed object.
             */
            $today_limit = apply_filters( 'adt_total_product_orders_lookback_today_limit', gmdate( 'Y-m-d', strtotime( '-' . $total_product_orders_lookback . ' days', strtotime( $today ) ) ), $feed );

            // Check if HPOS is enabled.
            $is_hpos_enabled = false;
            if ( class_exists( 'Automattic\WooCommerce\Utilities\OrderUtil' ) ) {
                $is_hpos_enabled = \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled();
            }

            if ( $is_hpos_enabled ) {
                // HPOS (High-Performance Order Storage) - use orders table.
                $query = $wpdb->prepare(
                    "SELECT DISTINCT oim.meta_value as product_id
                    FROM {$wpdb->prefix}woocommerce_order_items oi
                    INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON oi.order_item_id = oim.order_item_id
                    INNER JOIN {$wpdb->prefix}wc_orders o ON oi.order_id = o.id
                    WHERE o.status NOT IN ('wc-trash', 'wc-draft')
                    AND o.date_created_gmt >= %s
                    AND oim.meta_key IN ('_product_id', '_variation_id')
                    AND oim.meta_value > 0",
                    $today_limit
                );
            } else {
                // Traditional storage - use posts table.
                $query = $wpdb->prepare(
                    "SELECT DISTINCT oim.meta_value as product_id
                    FROM {$wpdb->prefix}woocommerce_order_items oi
                    INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON oi.order_item_id = oim.order_item_id
                    INNER JOIN {$wpdb->prefix}posts p ON oi.order_id = p.ID
                    WHERE p.post_type = 'shop_order'
                    AND p.post_status NOT IN ('trash', 'draft', 'auto-draft')
                    AND p.post_date >= %s
                    AND oim.meta_key IN ('_product_id', '_variation_id')
                    AND oim.meta_value > 0",
                    $today_limit
                );
            }

            // Execute query with error handling.
            $results = $wpdb->get_col( $query ); // phpcs:ignore WordPress.DB

            if ( $wpdb->last_error ) {
                // Log the error for debugging.
                $logging = get_option( 'adt_enable_logging', 'no' );
                if ( 'yes' === $logging ) {
                    // Fallback to WooCommerce API if database query fails.
                    $logger = new \WC_Logger();
                    $logger->add( 'Product Feed Pro by AdTribes.io', 'Database query failed, falling back to API method. Error: ' . $wpdb->last_error, 'error' );
                }
            }

            if ( ! empty( $results ) ) {
                $allowed_products = array_map( 'intval', $results );
            }
        }

        /**
         * Filter the allowed products from orders.
         *
         * @since 13.4.5
         * @access public
         *
         * @param array $allowed_products The allowed products.
         * @param Product_Feed $feed The product feed object.
         */
        return apply_filters( 'adt_total_product_orders_lookback_allowed_products', $allowed_products, $feed );
    }

    /**
     * Get total sales for a specific product variation.
     *
     * Queries directly from order items tables (source of truth) instead of relying
     * on the WooCommerce Analytics lookup table which requires background syncing.
     *
     * Implements transient caching to improve performance on high-volume stores.
     * Cache is automatically invalidated when order statuses change.
     *
     * @since 13.4.9
     * @access public
     *
     * @param int $variation_id The variation product ID.
     * @return int The total quantity sold for this variation. Returns 0 on error or if no sales found.
     */
    public static function get_variation_total_sales( $variation_id ) {
        global $wpdb;

        // Validate the variation ID.
        $variation_id = absint( $variation_id );
        if ( empty( $variation_id ) ) {
            return 0;
        }

        /**
         * Filter to enable/disable caching for variation total sales.
         *
         * @since 13.5.1
         *
         * @param bool $enable_cache Whether to enable caching. Default true.
         * @param int  $variation_id The variation product ID.
         */
        $enable_cache = apply_filters( 'adt_variation_total_sales_enable_cache', true, $variation_id );

        // Try to get from cache first if caching is enabled.
        if ( $enable_cache ) {
            $cache_key    = 'adt_variation_sales_' . $variation_id;
            $cached_sales = get_transient( $cache_key );

            if ( false !== $cached_sales ) {
                return absint( $cached_sales );
            }
        }

        // Check if HPOS is enabled.
        $is_hpos_enabled = false;
        if ( class_exists( 'Automattic\WooCommerce\Utilities\OrderUtil' ) ) {
            $is_hpos_enabled = \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled();
        }

        if ( $is_hpos_enabled ) {
            // HPOS (High-Performance Order Storage) - use orders table.
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
            $total_sales = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT SUM(oim_qty.meta_value)
                    FROM {$wpdb->prefix}woocommerce_order_items oi
                    INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim_product ON oi.order_item_id = oim_product.order_item_id
                    INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim_qty ON oi.order_item_id = oim_qty.order_item_id
                    INNER JOIN {$wpdb->prefix}wc_orders o ON oi.order_id = o.id
                    WHERE oi.order_item_type = 'line_item'
                    AND oim_product.meta_key = '_variation_id'
                    AND oim_product.meta_value = %d
                    AND oim_qty.meta_key = '_qty'
                    AND o.status IN ('wc-completed', 'wc-processing', 'wc-on-hold')",
                    $variation_id
                )
            );
        } else {
            // Traditional storage - use posts table.
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
            $total_sales = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT SUM(oim_qty.meta_value)
                    FROM {$wpdb->prefix}woocommerce_order_items oi
                    INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim_product ON oi.order_item_id = oim_product.order_item_id
                    INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim_qty ON oi.order_item_id = oim_qty.order_item_id
                    INNER JOIN {$wpdb->prefix}posts p ON oi.order_id = p.ID
                    WHERE oi.order_item_type = 'line_item'
                    AND oim_product.meta_key = '_variation_id'
                    AND oim_product.meta_value = %d
                    AND oim_qty.meta_key = '_qty'
                    AND p.post_type = 'shop_order'
                    AND p.post_status IN ('wc-completed', 'wc-processing', 'wc-on-hold')",
                    $variation_id
                )
            );
        }

        // Handle potential database errors.
        if ( false === $total_sales ) {
            return 0;
        }

        // Sanitize the total sales count (NULL from SUM means 0 sales).
        $total_sales = absint( $total_sales );

        // Store in cache if caching is enabled.
        if ( $enable_cache ) {
            /**
             * Filter the cache expiration time for variation total sales.
             *
             * @since 13.5.1
             *
             * @param int $expiration Cache expiration time in seconds. Default 1800 (30 minutes).
             * @param int $variation_id The variation product ID.
             * @param int $total_sales The total sales value being cached.
             */
            $cache_expiration = apply_filters( 'adt_variation_total_sales_cache_expiration', 30 * MINUTE_IN_SECONDS, $variation_id, $total_sales );
            set_transient( $cache_key, $total_sales, $cache_expiration );
        }

        return $total_sales;
    }

    /**
     * Invalidate variation sales cache when an order status changes.
     *
     * This ensures the cached sales data stays accurate when orders are
     * created, completed, refunded, or otherwise modified.
     *
     * @since 13.5.1
     * @access public
     *
     * @param int    $order_id   The order ID.
     * @param string $old_status The old order status.
     * @param string $new_status The new order status.
     */
    public static function invalidate_variation_sales_cache_on_status_change( $order_id, $old_status, $new_status ) {
        // Only invalidate cache if the status change affects sales counting.
        $counted_statuses = array( 'completed', 'processing', 'on-hold' );

        // Remove 'wc-' prefix for comparison.
        $old_status_clean = str_replace( 'wc-', '', $old_status );
        $new_status_clean = str_replace( 'wc-', '', $new_status );

        // Check if the status change affects sales data.
        $affects_sales = ( in_array( $old_status_clean, $counted_statuses, true ) || in_array( $new_status_clean, $counted_statuses, true ) );

        if ( ! $affects_sales ) {
            return;
        }

        self::invalidate_order_variation_caches( $order_id );
    }

    /**
     * Invalidate variation sales cache when an order is deleted.
     *
     * @since 13.5.1
     * @access public
     *
     * @param int $order_id The order ID being deleted.
     */
    public static function invalidate_variation_sales_cache_on_delete( $order_id ) {
        self::invalidate_order_variation_caches( $order_id );
    }

    /**
     * Invalidate caches for all variations in an order.
     *
     * @since 13.5.1
     * @access private
     *
     * @param int $order_id The order ID.
     */
    private static function invalidate_order_variation_caches( $order_id ) {
        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            return;
        }

        $variation_ids = array();

        foreach ( $order->get_items() as $item ) {
            // Check if item is a product and has a variation ID.
            if ( ! is_a( $item, 'WC_Order_Item_Product' ) ) {
                continue;
            }

            $variation_id = $item->get_variation_id();

            if ( $variation_id ) {
                $variation_ids[] = $variation_id;
            }
        }

        /**
         * Filter the variation IDs to invalidate cache for.
         *
         * @since 13.5.1
         *
         * @param array $variation_ids Array of variation IDs.
         * @param int   $order_id      The order ID.
         */
        $variation_ids = apply_filters( 'adt_invalidate_variation_sales_cache_ids', $variation_ids, $order_id );

        // Delete transients for all variations in this order.
        foreach ( $variation_ids as $variation_id ) {
            delete_transient( 'adt_variation_sales_' . $variation_id );
        }
    }

    /**
     * Check if total_product_orders attribute is needed in the feed.
     *
     * Checks if total_product_orders is mapped in feed attributes, filters, or rules.
     * This helps optimize performance by only querying order data when necessary.
     *
     * @since 13.5.0
     * @access public
     *
     * @param Product_Feed $feed The product feed object.
     * @return bool True if total_product_orders is needed, false otherwise.
     */
    public static function is_total_product_orders_mapped( $feed ) {
        if ( ! Product_Feed_Helper::is_a_product_feed( $feed ) ) {
            return false;
        }

        $feed_attributes = $feed->attributes ?? array();
        $feed_filters    = $feed->feed_filters ?? array();
        $feed_rules      = $feed->feed_rules ?? array();

        // 1. Check attributes (Output mapping).
        if ( ! empty( $feed_attributes ) ) {
            foreach ( $feed_attributes as $attr_value ) {
                if ( isset( $attr_value['mapfrom'] ) && 'total_product_orders' === $attr_value['mapfrom'] ) {
                    return true;
                }
            }
        }

        // 2. Check Filters.
        if ( ! empty( $feed_filters ) ) {
            $filters_data = is_string( $feed_filters ) ? json_decode( $feed_filters, true ) : $feed_filters;

            if ( is_array( $filters_data ) ) {
                // Check Include filters.
                if ( ! empty( $filters_data['include'] ) && self::check_conditions_for_attribute( $filters_data['include'], 'total_product_orders' ) ) {
                    return true;
                }

                // Check Exclude filters.
                if ( ! empty( $filters_data['exclude'] ) && self::check_conditions_for_attribute( $filters_data['exclude'], 'total_product_orders' ) ) {
                    return true;
                }
            }
        }

        // 3. Check Rules.
        if ( ! empty( $feed_rules ) ) {
            foreach ( $feed_rules as $rule ) {
                // Check IF conditions.
                if ( ! empty( $rule['if'] ) && self::check_conditions_for_attribute( $rule['if'], 'total_product_orders' ) ) {
                    return true;
                }

                // Check THEN actions (target attribute).
                if ( ! empty( $rule['then'] ) ) {
                    foreach ( $rule['then'] as $action ) {
                        if ( isset( $action['attribute'] ) && 'total_product_orders' === $action['attribute'] ) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Recursively check if an attribute is used in conditions structure.
     *
     * Traverses the nested structure of filters/rules (groups -> fields -> data -> attribute)
     * to find if the target attribute is referenced anywhere.
     *
     * @since 13.5.0
     * @access private
     *
     * @param array  $conditions The conditions array to check (can contain groups, fields, etc.).
     * @param string $target_attr The target attribute name to search for.
     * @return bool True if the attribute is found, false otherwise.
     */
    private static function check_conditions_for_attribute( $conditions, $target_attr ) {
        if ( empty( $conditions ) || ! is_array( $conditions ) ) {
            return false;
        }

        foreach ( $conditions as $item ) {
            // Handle Groups.
            if ( isset( $item['type'] ) && 'group' === $item['type'] ) {
                if ( ! empty( $item['fields'] ) && self::check_conditions_for_attribute( $item['fields'], $target_attr ) ) {
                    return true;
                }
            } elseif ( isset( $item['type'] ) && 'field' === $item['type'] ) {
                // Handle Fields within Groups.
                if ( isset( $item['data']['attribute'] ) && $target_attr === $item['data']['attribute'] ) {
                    return true;
                }
            } elseif ( isset( $item['attribute'] ) && $target_attr === $item['attribute'] ) {
                // Handle Legacy/Simple Structure.
                return true;
            }
        }
        return false;
    }

    /**
     * Run the class.
     *
     * @since 13.3.4
     */
    public function run() {
        // Register cache invalidation hooks for variation sales.
        add_action( 'woocommerce_order_status_changed', array( self::class, 'invalidate_variation_sales_cache_on_status_change' ), 10, 3 );
        add_action( 'woocommerce_delete_order', array( self::class, 'invalidate_variation_sales_cache_on_delete' ), 10, 1 );
        add_action( 'wp_trash_post', array( self::class, 'invalidate_variation_sales_cache_on_delete' ), 10, 1 );
    }
}
