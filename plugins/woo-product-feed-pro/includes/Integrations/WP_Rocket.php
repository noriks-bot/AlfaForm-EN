<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Integrations
 */

namespace AdTribes\PFP\Integrations;

use AdTribes\PFP\Abstracts\Abstract_Class;

/**
 * WP_Rocket class.
 *
 * @since 13.3.5.2
 */
class WP_Rocket extends Abstract_Class {

    /**
     * Check if WP Rocket plugin is active.
     *
     * @since 13.3.5.2
     * @return bool
     */
    public function is_active() {
        return defined( 'WP_ROCKET_FILE' ) || class_exists( 'WP_Rocket' );
    }

    /**
     * Exclude Product Feed urls from WP Rocket preload.
     *
     * @since 13.3.5.2
     * @acceess public
     *
     * @param array $regexes Array of regexes to exclude from WP Rocket preload.
     * @return array
     */
    public function preload_exclude_urls( $regexes ) {
        $regexes[] = '/wp-content/uploads/woo-product-feed-pro/(.*)';
        return $regexes;
    }

    /**
     * Run WP Rocket integration hooks.
     *
     * @since 13.3.5.2
     */
    public function run() {
        if ( ! $this->is_active() ) {
            return;
        }

        add_filter( 'rocket_preload_exclude_urls', array( $this, 'preload_exclude_urls' ) );
    }
}
