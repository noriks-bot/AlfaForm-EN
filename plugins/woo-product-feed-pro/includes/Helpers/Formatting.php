<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Helpers
 */

namespace AdTribes\PFP\Helpers;

/**
 * Helper methods class.
 *
 * @since 13.3.4
 */
class Formatting {

    /**
     * Localize price.
     *
     * @since 13.3.4
     * @access private
     *
     * @param float       $price          The price.
     * @param array       $args           Optional. Arguments to localize the price. Default empty array.
     * @param bool        $strip_currency Optional. Whether to strip currency symbol. Default true.
     * @param object|null $feed         The feed object.
     * @return string
     */
    public static function localize_price( $price, $args = array(), $strip_currency = true, $feed = null ) {
        if ( ! is_numeric( $price ) ) {
            return $price;
        }

        /**
         * Filter the arguments to localize the price.
         *
         * @since 13.4.1
         * @param array $args The arguments to localize the price.
         * @param object $feed The feed object.
         * @return array
         */
        $args          = apply_filters( 'adt_product_feed_localize_price_args', $args, $feed );
        $iso4217_feeds = apply_filters(
            'adt_pfp_localize_price_iso4217_feeds',
            array(
                'bing_shopping',
                'bing_shopping_promotions',
                'facebook_drm',
                'google_shopping',
                'google_drm',
                'google_dsa',
                'google_local',
                'google_local_products',
                'google_product_review',
                'google_shopping_promotions',
                'pinterest',
            )
        );

        // Skip if not in the ISO4217 feeds.
        if ( null !== $feed && in_array( $feed->get_channel( 'fields' ), $iso4217_feeds, true ) ) {
            $price = self::price_iso4217( $price );
        } else {
            if ( $strip_currency ) {
                $args['currency'] = 'ZZZ'; // Dummy currency to strip currency symbol.
            }

            $price = html_entity_decode( wc_clean( wc_price( $price, array_filter( $args ) ) ) );

            // Convert to ASCII, then trim.
            $price = preg_replace( '/[^\x20-\x7E]/', '', $price ); // Remove non-ASCII.
            $price = trim( $price );
        }

        return $price;
    }

    /**
     * Format price to ISO4217.
     *
     * @since 13.4.1
     * @access public
     *
     * @param float $price The price to format.
     * @return string
     */
    public static function price_iso4217( $price ) {
        if ( ! is_numeric( $price ) ) {
            return $price;
        }

        return number_format( $price, 2, '.', '' );
    }

    /**
     * Format date.
     * This method is used to format date based on general settings.
     *
     * @since 13.3.4
     * @access private
     *
     * @param string|WC_DateTime $date The date to format.
     * @param object|null        $feed The feed object. Default null.
     * @return string
     */
    public static function format_date( $date, $feed = null ) {
        if ( is_string( $date ) ) {
            $date = new \WC_DateTime( $date, new \DateTimeZone( 'UTC' ) );
        }

        if ( ! is_a( $date, 'WC_DateTime' ) ) {
            return '';
        }

        // Convert to site timezone for proper formatting.
        $site_timezone = wc_timezone_string();
        if ( $site_timezone ) {
            $date->setTimezone( new \DateTimeZone( $site_timezone ) );
        }

        $formatted_date = $date->date_i18n( wc_date_format() . ' ' . wc_time_format() );

        // Format date to ISO8601 for specific feeds.
        if ( null !== $feed ) {
            $iso8601_feeds = apply_filters(
                'adt_pfp_date_iso8601_format_feeds',
                array(
                    'bing_shopping',
                    'bing_shopping_promotions',
                    'facebook_drm',
                    'google_shopping',
                    'google_drm',
                    'google_dsa',
                    'google_local',
                    'google_local_products',
                    'google_product_review',
                    'google_shopping_promotions',
                    'pinterest',
                )
            );

            $rfc822_feeds = apply_filters(
                'adt_pfp_date_rfc822_format_feeds',
                array(
                    'pinterest_rss_board',
                )
            );

            if ( in_array( $feed->get_channel( 'fields' ), $iso8601_feeds, true ) ) {
                $formatted_date = self::date_iso8601( $date );
            } elseif ( in_array( $feed->get_channel( 'fields' ), $rfc822_feeds, true ) ) {
                $formatted_date = self::date_rfc822( $date );
            }
        }

        return apply_filters( 'adt_pfp_format_date', $formatted_date, $date, $feed );
    }

    /**
     * Format date to ISO8601.
     *
     * @since 13.3.4
     * @access private
     *
     * @param string|WC_DateTime $date The date to format.
     * @return string
     */
    public static function date_iso8601( $date ) {
        if ( is_string( $date ) ) {
            $date = new \WC_DateTime( $date, new \DateTimeZone( 'UTC' ) );
        }

        if ( ! is_a( $date, 'WC_DateTime' ) ) {
            return '';
        }

        // Convert to site timezone for proper formatting.
        $site_timezone = wc_timezone_string();
        if ( $site_timezone ) {
            $date->setTimezone( new \DateTimeZone( $site_timezone ) );
        }

        return $date->__toString();
    }

    /**
     * Format date to RFC822.
     *
     * @since 13.4.1
     * @access private
     *
     * @param string|WC_DateTime $date The date to format.
     * @return string
     */
    public static function date_rfc822( $date ) {
        if ( is_string( $date ) ) {
            $date = new \WC_DateTime( $date, new \DateTimeZone( 'UTC' ) );
        }
        if ( ! is_a( $date, 'WC_DateTime' ) ) {
            return '';
        }
        return $date->date_i18n( 'D, d M Y H:i:s O' );
    }

    /**
     * Format refresh interval.
     *
     * @since 13.4.1
     * @access public
     *
     * @param string      $interval The interval to format.
     * @param object|null $feed The feed object.
     * @return string
     */
    public static function format_refresh_interval( $interval, $feed = null ) {
        $intervals = array(
            'hourly'     => __( 'Hourly', 'woo-product-feed-pro' ),
            'twicedaily' => __( 'Twice Daily', 'woo-product-feed-pro' ),
            'daily'      => __( 'Daily', 'woo-product-feed-pro' ),
        );

        /**
         * Filters the refresh interval labels.
         *
         * @since 13.4.6
         * @param array $intervals The refresh interval options.
         * @return array
         */
        $intervals = apply_filters( 'adt_format_refresh_interval_manage_feeds_table', $intervals, $feed );

        return $intervals[ $interval ] ?? __( 'No Refresh', 'woo-product-feed-pro' );
    }

    /**
     * Get feed status label.
     *
     * @since 13.4.1
     * @access public
     *
     * @param Product_Feed $feed The feed object.
     * @return string
     */
    public static function get_feed_status_label( $feed ) {
        if ( 'publish' !== $feed->post_status ) {
            return __( 'Inactive', 'woo-product-feed-pro' );
        }

        switch ( $feed->status ) {
            case 'ready':
                return __( 'Ready', 'woo-product-feed-pro' );
            case 'processing':
                return __( 'Processing', 'woo-product-feed-pro' );
            case 'error':
                return __( 'Error', 'woo-product-feed-pro' );
            case 'stopped':
                return __( 'Stopped', 'woo-product-feed-pro' );
            default:
                return __( 'Unknown', 'woo-product-feed-pro' );
        }
    }
}
