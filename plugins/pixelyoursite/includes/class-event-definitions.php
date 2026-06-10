<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Event Definitions Provider
 * 
 * Centralized class for accessing event definitions across all platforms.
 * This class provides static methods to get event definitions from external files.
 * 
 * Benefits:
 * - Single source of truth for event definitions
 * - Easy to use anywhere in the codebase
 * - Lazy loading - definitions loaded only when needed
 * - Cached after first load for performance
 * 
 * @since 2.0.0
 */
class PYS_Event_Definitions {

    /**
     * Cache for loaded event definitions
     * @var array
     */
    private static $cache = array();

    /**
     * Get Facebook Pixel event definitions
     * 
     * @return array Event definitions in format:
     *               [
     *                 'EventName' => [
     *                   ['type' => 'input', 'label' => 'field_name', 'name' => '...', 'input_type' => 'string', 'required' => false],
     *                   ...
     *                 ]
     *               ]
     */
    public static function get_facebook_events() {
        if ( ! isset( self::$cache['facebook'] ) ) {
            self::$cache['facebook'] = require PYS_FREE_PATH . '/includes/event-definitions/facebook-events.php';
        }
        return self::$cache['facebook'];
    }

    /**
     * Get TikTok Pixel event definitions
     * 
     * @return array Event definitions
     */
    public static function get_tiktok_events() {
        if ( ! isset( self::$cache['tiktok'] ) ) {
            self::$cache['tiktok'] = require PYS_FREE_PATH . '/includes/event-definitions/tiktok-events.php';
        }
        return self::$cache['tiktok'];
    }

    /**
     * Get Reddit Pixel event definitions
     * 
     * @return array Event definitions
     */
    public static function get_reddit_events() {
        if ( ! isset( self::$cache['reddit'] ) ) {
            self::$cache['reddit'] = require PYS_FREE_PATH . '/includes/event-definitions/reddit-events.php';
        }
        return self::$cache['reddit'];
    }

    /**
     * Get Bing Ads event definitions
     * 
     * @return array Event definitions
     */
    public static function get_bing_events() {
        if ( ! isset( self::$cache['bing'] ) ) {
            self::$cache['bing'] = require PYS_FREE_PATH . '/includes/event-definitions/bing-events.php';
        }
        return self::$cache['bing'];
    }

    /**
     * Get Pinterest Pixel event definitions
     * 
     * @return array Event definitions
     */
    public static function get_pinterest_events() {
        if ( ! isset( self::$cache['pinterest'] ) ) {
            self::$cache['pinterest'] = require PYS_FREE_PATH . '/includes/event-definitions/pinterest-events.php';
        }
        return self::$cache['pinterest'];
    }

    /**
     * Get Google Analytics 4 event definitions
     * 
     * Note: GA4 and GTM use the same event definitions
     * 
     * @return array Event definitions grouped by category:
     *               [
     *                 'Category Name' => [
     *                   'event_name' => [
     *                     ['name' => 'field_name', 'input_type' => 'string', 'required' => false],
     *                     ...
     *                   ]
     *                 ]
     *               ]
     */
    public static function get_ga_events() {
        if ( ! isset( self::$cache['ga_gtm'] ) ) {
            self::$cache['ga_gtm'] = require PYS_FREE_PATH . '/includes/event-definitions/ga-gtm-events.php';
        }
        return self::$cache['ga_gtm'];
    }

    /**
     * Get Google Tag Manager event definitions
     * 
     * Note: GTM uses the same event definitions as GA4
     * 
     * @return array Event definitions (same as GA4)
     */
    public static function get_gtm_events() {
        return self::get_ga_events();
    }

    /**
     * Get event definitions for a specific platform
     * 
     * @param string $platform Platform slug (facebook, tiktok, reddit, bing, pinterest, google_analytics, gtm)
     * @return array|false Event definitions or false if platform not found
     */
    public static function get_events_for_platform( $platform ) {
        switch ( $platform ) {
            case 'facebook':
                return self::get_facebook_events();
            case 'tiktok':
                return self::get_tiktok_events();
            case 'reddit':
                return self::get_reddit_events();
            case 'bing':
                return self::get_bing_events();
            case 'pinterest':
                return self::get_pinterest_events();
            case 'google_analytics':
            case 'ga':
            case 'ga4':
                return self::get_ga_events();
            case 'gtm':
            case 'google_tag_manager':
                return self::get_gtm_events();
            default:
                return false;
        }
    }

    /**
     * Get currency list
     * 
     * @return array Currency codes and names
     */
    public static function get_currencies() {
        // This is used across multiple platforms, so we keep it here
        return array(
            'AED' => 'United Arab Emirates Dirham',
            'ARS' => 'Argentine Peso',
            'AUD' => 'Australian Dollars',
            'BDT' => 'Bangladeshi Taka',
            'BRL' => 'Brazilian Real',
            'CAD' => 'Canadian Dollars',
            'CHF' => 'Swiss Franc',
            'CLP' => 'Chilean Peso',
            'CNY' => 'Chinese Yuan',
            'COP' => 'Colombian Peso',
            'CZK' => 'Czech Koruna',
            'DKK' => 'Danish Krone',
            'EGP' => 'Egyptian Pound',
            'EUR' => 'Euros',
            'GBP' => 'Pounds Sterling',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Hungarian Forint',
            'IDR' => 'Indonesia Rupiah',
            'ILS' => 'Israeli Shekel',
            'INR' => 'Indian Rupee',
            'ISK' => 'Icelandic Krona',
            'JPY' => 'Japanese Yen',
            'KRW' => 'South Korean Won',
            'MXN' => 'Mexican Peso',
            'MYR' => 'Malaysian Ringgits',
            'NOK' => 'Norwegian Krone',
            'NZD' => 'New Zealand Dollar',
            'PHP' => 'Philippine Pesos',
            'PKR' => 'Pakistani Rupee',
            'PLN' => 'Polish Zloty',
            'RON' => 'Romanian Leu',
            'RUB' => 'Russian Ruble',
            'SAR' => 'Saudi Riyal',
            'SEK' => 'Swedish Krona',
            'SGD' => 'Singapore Dollar',
            'THB' => 'Thai Baht',
            'TRY' => 'Turkish Lira',
            'TWD' => 'Taiwan New Dollars',
            'UAH' => 'Ukrainian Hryvnia',
            'USD' => 'U.S. Dollar',
            'VND' => 'Vietnamese Dong',
            'ZAR' => 'South African Rands'
        );
    }

    /**
     * Clear cache (useful for testing or when definitions are updated)
     */
    public static function clear_cache() {
        self::$cache = array();
    }
}

