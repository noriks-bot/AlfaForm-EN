<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Helpers
 */

namespace AdTribes\PFP\Helpers;

use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Factories\Product_Feed_Query;

/**
 * Helper methods class.
 *
 * @since 13.3.5
 */
class Product_Feed_Helper {

    /**
     * Check if object is a Product_Feed.
     *
     * This method is used to check if the object is a product feed.
     *
     * @since 13.3.5
     * @access public
     *
     * @param mixed $feed The feed object.
     * @return bool
     */
    public static function is_a_product_feed( $feed ) {
        return ( is_a( $feed, 'AdTribes\PFP\Factories\Product_Feed' ) || is_a( $feed, 'AdTribes\PFE\Factories\Product_Feed' ) );
    }

    /**
     * Product feed instance.
     *
     * @since 13.3.6
     * @access public
     *
     * @param int|string|WP_Post $feed    Feed ID, project hash (legacy) or WP_Post object.
     * @param string             $context The context of the product feed.
     * @return Product_Feed|false Returns the product feed object if valid, otherwise false.
     */
    public static function get_product_feed( $feed = 0, $context = 'view' ) {
        if ( class_exists( 'AdTribes\PFE\Factories\Product_Feed' ) ) {
            $feed_object = new \AdTribes\PFE\Factories\Product_Feed( $feed, $context );
        } else {
            $feed_object = new Product_Feed( $feed, $context );
        }

        // If the feed is 0 or null, it means we are creating a new feed object.
        if ( 0 === $feed || null === $feed ) {
            return $feed_object;
        }

        return $feed_object->id > 0 ? $feed_object : false;
    }

    /**
     * Get country code from legacy country name.
     *
     * This method is used to get the country code from the legacy country name.
     * We used to store the country name in the codebase, but now use the country code available in WooCommerce.
     *
     * @since 13.3.5
     * @access public
     *
     * @param string $country_name The name of the country.
     * @return string
     */
    public static function get_code_from_legacy_country_name( $country_name ) {
        $legacy_countries = include ADT_PFP_PLUGIN_DIR_PATH . 'includes/I18n/legacy_countries.php';
        return array_search( $country_name, $legacy_countries ); // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
    }

    /**
     * Get legacy country name from country code.
     *
     * This method is used to get the legacy country name from the country code.
     * We used to store the country name in the codebase, but now use the country code available in WooCommerce.
     *
     * @since 13.3.5
     * @access public
     *
     * @param string $country_code The code of the country.
     * @return string
     */
    public static function get_legacy_country_from_code( $country_code ) {
        $legacy_countries = include ADT_PFP_PLUGIN_DIR_PATH . 'includes/I18n/legacy_countries.php';
        return $legacy_countries[ $country_code ] ?? '';
    }

    /**
     * Get channel data from legacy channel hash.
     *
     * This method is used to get the channel data from the legacy channel hash.
     *
     * @since 13.3.5
     * @access public
     *
     * @param string $channel_hash The hash of the channel.
     * @return array|null
     */
    public static function get_channel_from_legacy_channel_hash( $channel_hash ) {
        $legacy_channel_statics = include ADT_PFP_PLUGIN_DIR_PATH . 'includes/I18n/legacy_channel_statics.php';

        // Search for the channel hash in the legacy channel statics.
        foreach ( $legacy_channel_statics as $country ) {
            foreach ( $country as $channel ) {
                if ( $channel['channel_hash'] === $channel_hash ) {
                    return $channel;
                }
            }
        }
        return null;
    }

    /**
     * Generate legacy project hash.
     *
     * Copied from legacy code. This method is used to generate the legacy project hash.
     * We keep this method to maintain backward compatibility.
     *
     * @since 13.3.5
     * @access public
     *
     * @return string
     */
    public static function generate_legacy_project_hash() {
        // New code to create the project hash so dependency on openSSL is removed.
        $keyspace = apply_filters( 'adt_product_feed_legacy_project_hash_keyspace', '0123456789abcdefghijklmnopqrstuvwxyz' );
        $pieces   = array();
        $length   = 32;
        $max      = mb_strlen( $keyspace, '8bit' ) - 1;

        for ( $i = 0; $i < $length; ++$i ) {
            $pieces [] = $keyspace[ random_int( 0, $max ) ];
        }

        return implode( '', $pieces );
    }

    /**
     * Count total product feed projects.
     *
     * @since 13.3.5
     * @access public
     *
     * @return int
     */
    public static function get_total_product_feed() {
        $count_post = wp_count_posts( Product_Feed::POST_TYPE );
        return $count_post->publish + $count_post->draft;
    }

    /**
     * Count total published product including variations.
     *
     * @since 13.3.5
     * @access public
     *
     * @param bool $incl_variation Include variations.
     * @return int
     */
    public static function get_total_published_products( $incl_variation = false ) {
        $count_product = wp_count_posts( 'product' );
        if ( ! $incl_variation ) {
            return $count_product->publish;
        }

        $count_product_variation = wp_count_posts( 'product_variation' );
        return $count_product->publish + $count_product_variation->publish;
    }

    /**
     * Get total published products.
     *
     * @since 13.3.5
     * @access private
     *
     * @param Product_Feed $feed The product feed instance.
     * @return int
     */
    public static function get_feed_total_published_products( $feed ) {
        // Get total of published products to process.
        if ( $feed->create_preview ) {
            // User would like to see a preview of their feed, retrieve only 5 products by default.
            $published_products = apply_filters( 'adt_product_feed_preview_products', 5, $feed );
        } else {
            $published_products = self::get_total_published_products( $feed->include_product_variations );
        }

        /**
         * Filter the total number of products to process.
         *
         * @since 13.3.5
         *
         * @param int $published_products Total number of published products to process.
         * @param \AdTribes\PFP\Factories\Product_Feed $feed The product feed instance.
         */
        return apply_filters( 'adt_product_feed_total_published_products', intval( $published_products ), $feed );
    }

    /**
     * Get batch size.
     *
     * @since 13.4.1
     * @access public
     *
     * @param Product_Feed $feed The product feed instance.
     * @param int          $published_products The total number of published products.
     * @return int
     */
    public static function get_batch_size( $feed, $published_products = null ) {
        $published_products = $published_products ?? self::get_feed_total_published_products( $feed );

        // Tiered batch sizes for better reliability and efficiency.
        // Smaller batches = more reliable, better progress tracking, less memory usage.
        if ( $published_products > 50000 ) {
            // Very large feeds: 1500 products per batch.
            $batch_size = 1500;
        } elseif ( $published_products > 10000 ) {
            // Large feeds: 1000 products per batch.
            $batch_size = 1000;
        } elseif ( $published_products > 5000 ) {
            // Medium-large feeds: 500 products per batch.
            $batch_size = 500;
        } elseif ( $published_products > 1000 ) {
            // Medium feeds: 300 products per batch.
            $batch_size = 300;
        } else {
            // Small feeds: 200 products per batch.
            $batch_size = 200;
        }

        /**
         * User set his own batch size.
         */
        $batch_option      = get_option( 'adt_enable_batch', 'no' );
        $batch_size_option = get_option( 'adt_batch_size', '' );
        if ( 'yes' === $batch_option && ! empty( $batch_size_option ) && is_numeric( $batch_size_option ) ) {
            $batch_size = intval( $batch_size_option );
        }

        return $batch_size;
    }

    /**
     * Remove cache.
     *
     * The method is used to remove the cache for the feed processing.
     * This is to ensure that the feed is not cached by the caching plugins.
     * This is the legacy code base logic.
     *
     * @since 13.3.5
     * @access public
     */
    public static function disable_cache() {
        // Force garbage collection dump.
        gc_enable();
        gc_collect_cycles();

        // Make sure feeds are not being cached.
        $no_caching = new \WooSEA_Caching();

        // LiteSpeed Caching.
        if ( class_exists( 'LiteSpeed\Core' ) || defined( 'LSCWP_DIR' ) ) {
            $no_caching->litespeed_cache();
        }

        // WP Fastest Caching.
        if ( class_exists( 'WpFastestCache' ) ) {
            $no_caching->wp_fastest_cache();
        }

        // WP Super Caching.
        if ( function_exists( 'wpsc_init' ) ) {
            $no_caching->wp_super_cache();
        }

        // Breeze Caching.
        if ( class_exists( 'Breeze_Admin' ) ) {
            $no_caching->breeze_cache();
        }

        // WP Optimize Caching.
        if ( class_exists( 'WP_Optimize' ) ) {
            $no_caching->wp_optimize_cache();
        }

        // Cache Enabler.
        if ( class_exists( 'Cache_Enabler' ) ) {
            $no_caching->cache_enabler_cache();
        }

        // Swift Performance Lite.
        if ( class_exists( 'Swift_Performance_Lite' ) ) {
            $no_caching->swift_performance_cache();
        }

        // Comet Cache.
        if ( is_plugin_active( 'comet-cache/comet-cache.php' ) ) {
            $no_caching->comet_cache();
        }

        // HyperCache.
        if ( class_exists( 'HyperCache' ) ) {
            $no_caching->hyper_cache();
        }
    }

    /**
     * Get refresh interval label.
     *
     * This method is used to get the refresh interval label.
     *
     * @since 13.3.5
     * @access public
     *
     * @param string $key The key of the refresh interval.
     * @return string
     */
    public static function get_refresh_interval_label( $key ) {
        $refresh_intervals = array(
            'hourly'     => __( 'Hourly', 'woo-product-feed-pro' ),
            'twicedaily' => __( 'Twice Daily', 'woo-product-feed-pro' ),
            'daily'      => __( 'Daily', 'woo-product-feed-pro' ),
        );

        /**
         * Filters the refresh interval labels.
         *
         * @since 13.4.6
         * @param array $refresh_intervals The refresh interval options.
         * @return array
         */
        $refresh_intervals = apply_filters( 'adt_product_feed_refresh_interval_labels', $refresh_intervals );

        return $refresh_intervals[ $key ] ?? __( 'No Refresh', 'woo-product-feed-pro' );
    }

    /**
     * Get hierarchical categories mapping.
     *
     * @since 13.4.0
     * @access public
     *
     * @param object $feed The feed object.
     * @return array
     */
    public static function get_hierarchical_categories_mapping( $feed = null ) {
        $feed_mappings       = array();
        $mapped_category_ids = array();

        /**
         * Filters the arguments for hierarchical categories mapping.
         *
         * @since 13.4.0
         * @param array $args The arguments for hierarchical categories mapping.
         * @return array
         */
        $parent_terms_args = apply_filters(
            'adt_product_feed_hierarchical_categories_mapping_args',
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'parent'     => 0, // Get only parent terms.
                'orderby'    => 'name',
                'order'      => 'ASC',
            )
        );

        /**
         * Filters the categories for hierarchical categories mapping.
         *
         * @since 13.4.0
         * @param array $parent_terms The parent terms.
         * @param array $args         The arguments for hierarchical categories mapping.
         * @param int   $feed_ud      The feed id.
         * @return array
         */
        $parent_terms = apply_filters(
            'adt_product_feed_hierarchical_categories_mapping',
            get_terms( $parent_terms_args ),
            $parent_terms_args,
            $feed->id ?? 0
        );

        // Get already mapped categories.
        if ( null !== $feed ) {
            // Get the mappings from the feed.
            if ( $feed instanceof Product_Feed ) {
                $feed_mappings = $feed->mappings ?? array();
            } else { // Get the mappings from the feed array if a new feed is created.
                $feed_mappings = $feed['mappings'] ?? array();
            }

            // Get category IDs that are already mapped.
            if ( ! empty( $feed_mappings ) ) {
                $mapped_category_ids = array_map(
                    function ( $mapping ) {
                        return $mapping['map_to_category'] ?? '';
                    },
                    $feed_mappings
                );
            }
        }

        ob_start();
        foreach ( $parent_terms as $category ) {
            self::print_hierarchical_categories_mapping_view( $category, $mapped_category_ids, 0, $feed );
        }
        $html = ob_get_clean();

        return $html;
    }

    /**
     * Hierarchical categories mapping view.
     *
     * @since 13.4.0
     * @access private
     *
     * @param object $category            The category object.
     * @param array  $mapped_category_ids The mapped category IDs.
     * @param int    $child_number        The child number, to print the dash character.
     * @param object $feed                The feed object.
     * @return void
     */
    public static function print_hierarchical_categories_mapping_view( $category, $mapped_category_ids = array(), $child_number = 0, $feed = null ) {
        // Check if this category is already mapped.
        $mapped_category = $mapped_category_ids[ $category->term_id ] ?? '';

        /**
         * Get the children of the current category.
         * Filters the arguments for fetching children categories in hierarchical categories mapping.
         *
         * @since 13.4.4
         * @param array  $children_args The arguments for fetching children categories.
         * @param object $category      The parent category object.
         * @param int    $child_number  The child number, indicating the depth level.
         * @return array
         */
        $children_args = apply_filters(
            'adt_product_feed_hierarchical_categories_children_args',
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'parent'     => $category->term_id,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ),
            $category,
            $child_number
        );

        /**
         * Filters the children categories in hierarchical categories mapping.
         *
         * @since 13.4.4
         * @param array  $childrens    The children categories.
         * @param array  $children_args The arguments used for fetching children categories.
         * @param int    $feed_id       The feed id.
         * @param object $category      The parent category object.
         * @param int    $child_number  The child number, indicating the depth level.
         * @return array
         */
        $childrens = apply_filters(
            'adt_product_feed_hierarchical_categories_children_mapping',
            get_terms( $children_args ),
            $children_args,
            $feed->id ?? 0,
            $category,
            $child_number
        );

        // Include the view for the current category.
        Helper::locate_admin_template(
            'components/google-shopping-category-mapping.php',
            true,
            false,
            array(
                'category'        => $category,
                'mapped_category' => $mapped_category,
                'childrens'       => $childrens,
                'child_number'    => $child_number,
            )
        );

        // Process each child category recursively.
        if ( ! empty( $childrens ) ) {
            foreach ( $childrens as $children ) {
                self::print_hierarchical_categories_mapping_view( $children, $mapped_category_ids, $child_number + 1, $feed );
            }
        }
    }

    /**
     * Get the price including tax.
     * This method is used to get the price including tax by feed settings.
     *
     * @since 13.4.0
     * @access public
     *
     * @param float  $price     The price of the product.
     * @param array  $tax_rates The tax rates.
     * @param object $feed      The feed object.
     * @param object $product   The product object.
     * @return float
     */
    public static function get_price_including_tax( $price, $tax_rates = array(), $feed = null, $product = null ) {
        $tax_class    = $product ? $product->get_tax_class() : '';
        $country      = $feed ? $feed->country : '';
        $price        = (float) $price;
        $return_price = $price;

        // Get the tax rates for the given country.
        $tax_rates = empty( $tax_rates ) ? self::find_tax_rates(
            array(
                'country'   => $country,
                'state'     => '',
                'postcode'  => '',
                'city'      => '',
                'tax_class' => $tax_class,
            ),
            $feed,
            $product
        ) : $tax_rates;

        if ( $product->is_taxable() ) {
            if ( ! wc_prices_include_tax() ) {
                // Calculate the tax with WC_Tax::calc_tax.
                $taxes = \WC_Tax::calc_tax( $price, $tax_rates, wc_prices_include_tax() );

                // Get the tax amount.
                $tax_amount = array_sum( $taxes );

                // Add the tax amount to the price.
                $return_price = $price + $tax_amount;
            } else {
                $unfiltered_tax_rates = $product ? $product->get_tax_class( 'unfiltered' ) : '';
                $base_tax_rates       = \WC_Tax::get_base_tax_rates( $unfiltered_tax_rates );

                if ( $tax_rates !== $base_tax_rates && apply_filters( 'woocommerce_adjust_non_base_location_prices', true ) ) {
                    $base_taxes   = \WC_Tax::calc_tax( $price, $base_tax_rates, true );
                    $modded_taxes = \WC_Tax::calc_tax( $price - array_sum( $base_taxes ), $tax_rates, false );

                    if ( 'yes' === get_option( 'woocommerce_tax_round_at_subtotal' ) ) {
                        $base_taxes_total   = array_sum( $base_taxes );
                        $modded_taxes_total = array_sum( $modded_taxes );
                    } else {
                        $base_taxes_total   = array_sum( array_map( 'wc_round_tax_total', $base_taxes ) );
                        $modded_taxes_total = array_sum( array_map( 'wc_round_tax_total', $modded_taxes ) );
                    }

                    $return_price = $price - $base_taxes_total + $modded_taxes_total;
                }
            }
        }

        return $return_price;
    }

    /**
     * Get the price excluding tax.
     * This method is used to get the price excluding tax by feed settings.
     *
     * @since 13.4.0
     * @access public
     *
     * @param float  $price     The price of the product.
     * @param array  $tax_rates The tax rates.
     * @param object $feed      The feed object.
     * @param object $product   The product object.
     * @return float
     */
    public static function get_price_excluding_tax( $price, $tax_rates = array(), $feed = null, $product = null ) {
        $tax_class    = $product ? $product->get_tax_class() : '';
        $country      = $feed ? $feed->country : '';
        $price        = (float) $price;
        $return_price = $price;

        // Get the tax rates for the given country.
        $tax_rates = empty( $tax_rates ) ? self::find_tax_rates(
            array(
                'country'   => $country,
                'state'     => '',
                'postcode'  => '',
                'city'      => '',
                'tax_class' => $tax_class,
            ),
            $feed,
            $product
        ) : $tax_rates;

        if ( $product->is_taxable() && wc_prices_include_tax() ) {
            if ( apply_filters( 'woocommerce_adjust_non_base_location_prices', true ) ) {
                $unfiltered_tax_rates = $product ? $product->get_tax_class( 'unfiltered' ) : '';
                $tax_rates            = \WC_Tax::get_base_tax_rates( $unfiltered_tax_rates );
            }
            $remove_taxes = \WC_Tax::calc_tax( $price, $tax_rates, true );
            $return_price = $price - array_sum( $remove_taxes ); // Unrounded since we're dealing with tax inclusive prices. Matches logic in cart-totals class. @see adjust_non_base_location_price.
        }

        return $return_price;
    }

    /**
     * Find tax rates.
     *
     * This method is used to find the tax rates for the given arguments.
     *
     * @since 13.4.0
     * @since 13.4.5 Added support for base tax rates based on the WooCommerce "Calculate tax based on" settings.
     * @access public
     *
     * @param array  $args    The arguments for finding tax rates.
     * @param object $feed    The feed object.
     * @param object $product The product object.
     * @return array
     */
    public static function find_tax_rates( $args, $feed = null, $product = null ) {
        if ( 'base' === get_option( 'woocommerce_tax_based_on' ) ) {
            $args = array(
                'country'   => WC()->countries->get_base_country(),
                'state'     => WC()->countries->get_base_state(),
                'postcode'  => WC()->countries->get_base_postcode(),
                'city'      => WC()->countries->get_base_city(),
                'tax_class' => $args['tax_class'] ?? '',
            );
        }

        return \WC_Tax::find_rates(
            /**
             * Filters the arguments for finding tax rates.
             *
             * @since 13.4.0
             *
             * @param array  $args    The arguments for finding tax rates.
             * @param object $feed    The feed object.
             * @param object $product The product object.
             * @return array
             */
            apply_filters(
                'adt_product_feed_find_tax_rates_args',
                wp_parse_args(
                    $args,
                    array(
                        'country'   => '',
                        'state'     => '',
                        'postcode'  => '',
                        'city'      => '',
                        'tax_class' => '',
                    )
                ),
                $feed,
                $product
            )
        );
    }

    /**
     * Group channels by their type and print channel options.
     *
     * This method is used to organize channels into groups based on their type
     * and generate HTML for select options.
     *
     * @since 13.4.2
     * @access public
     * @param array  $channels        Array of channels to be grouped.
     * @param string $default_channel Default channel to be selected.
     * @return string HTML content for select options.
     */
    public static function print_channel_options( $channels, $default_channel = 'Google Shopping' ) {
        // Start output buffering.
        ob_start();

        // Group channels by their type.
        $grouped_channels = array();

        foreach ( $channels as $key => $val ) {
            if ( ! isset( $val['type'] ) ) {
                continue;
            }

            $type = $val['type'];

            if ( ! isset( $grouped_channels[ $type ] ) ) {
                $grouped_channels[ $type ] = array();
            }

            $grouped_channels[ $type ][ $key ] = $val;
        }

        // Generate the select options grouped by type.
        foreach ( $grouped_channels as $type => $type_channels ) {
            echo '<optgroup label="' . esc_attr( $type ) . '">';

            foreach ( $type_channels as $key => $val ) {
                $selected = $default_channel === $val['name'] ? ' selected' : '';
                echo '<option value="' . esc_attr( $val['channel_hash'] ) . '"' . esc_attr( $selected ) . '>' . esc_html( $val['name'] ) . '</option>';
            }

            echo '</optgroup>';
        }

        // Get the buffered content and return it.
        return ob_get_clean();
    }

    /**
     * Get total count of product feeds.
     *
     * @since 13.4.4
     * @access public
     *
     * @return int Total number of feeds.
     */
    public static function get_total_feeds_count() {
        global $wpdb;

        // Direct SQL count query for better performance.
        $total_count = (int) $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->posts} 
                WHERE post_type = %s 
                AND post_status IN ('publish', 'draft')",
                'adt_product_feed'
            )
        );

        return $total_count;
    }

    /**
     * Generate HTML for the feed URL column.
     *
     * This method generates the appropriate HTML for the feed URL column based on
     * the feed's status and whether the feed file exists.
     *
     * @since 13.4.5
     * @access public
     *
     * @param object $feed The feed object.
     * @return string HTML for the feed URL column.
     */
    public static function get_feed_url_html( $feed ) {
        ob_start();

        // Load the template with the feed variable.
        Helper::locate_admin_template(
            'components/feed-url.php',
            true,
            false,
            array(
                'feed' => $feed,
            )
        );

        return ob_get_clean();
    }

    /**
     * Check if the channel is all feeds channel.
     *
     * @since 13.4.6
     * @access public
     *
     * @param string $feed_channel The Feed channel.
     * @return bool
     */
    public static function is_all_feeds_channel( $feed_channel ) {
        $legacy_channel_statics = include ADT_PFP_PLUGIN_DIR_PATH . 'includes/I18n/legacy_channel_statics.php';

        $all_countries_feeds_channel = $legacy_channel_statics['All countries'];
        $custom_feeds_channel        = $legacy_channel_statics['Custom Feed'];

        $all_feeds_channel = array_merge( $all_countries_feeds_channel, $custom_feeds_channel );

        foreach ( $all_feeds_channel as $channel ) {
            if ( $channel['fields'] === $feed_channel ) {
                return true;
            }
        }

        return false;
    }
}
