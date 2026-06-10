<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Integrations
 */

namespace AdTribes\PFP\Integrations;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Product_Feed_Helper;

/**
 * WWPP class.
 *
 * @since 13.3.4
 */
class WWPP extends Abstract_Class {

    /**
     * Check if WWP plugin is active.
     *
     * @since 13.3.4
     * @return bool
     */
    public function is_active() {
        return Helper::is_plugin_active( 'woocommerce-wholesale-prices-premium/woocommerce-wholesale-prices-premium.bootstrap.php' );
    }

    /**
     * Exclude restricted wholesale products from product feeds.
     *
     * @since 13.3.4
     * @access public
     *
     * @param array  $product_data The product data.
     * @param object $feed         The product feed.
     * @param object $product      The product data.
     * @return array
     */
    public function exclude_restricted_wholesale_products( $product_data, $feed, $product ) {
        // Check if product is restricted to wholesale customers.
        if ( ! empty( $product_data ) ) {
            if ( $product->get_type() === 'variation' ) {
                $parent_product = wc_get_product( $product->get_parent_id() );
                if ( $parent_product ) {
                    $wwpp_parent_product_wholesale_visibility_filter = $parent_product->get_meta( 'wwpp_product_wholesale_visibility_filter', false );
                    if ( is_array( $wwpp_parent_product_wholesale_visibility_filter ) && ! empty( $wwpp_parent_product_wholesale_visibility_filter ) ) {
                        $wwpp_parent_product_wholesale_visibility_filter = wp_list_pluck( $wwpp_parent_product_wholesale_visibility_filter, 'value' );
                        if ( ! in_array( 'all', $wwpp_parent_product_wholesale_visibility_filter, true ) ) {
                            $product_data = array();
                        }
                    }
                }
            }

            $wwpp_product_wholesale_visibility_filter = $product->get_meta( 'wwpp_product_wholesale_visibility_filter', false );
            if ( is_array( $wwpp_product_wholesale_visibility_filter ) && ! empty( $wwpp_product_wholesale_visibility_filter ) ) {
                $wwpp_product_wholesale_visibility_filter = wp_list_pluck( $wwpp_product_wholesale_visibility_filter, 'value' );
                if ( ! in_array( 'all', $wwpp_product_wholesale_visibility_filter, true ) ) {
                    $product_data = array();
                }
            }
        }

        // Check if product is restricted in category.
        if ( ! empty( $product_data ) && class_exists( 'WWPP_Helper_Functions' ) ) {
            $product_is_restricted_in_category = \WWPP_Helper_Functions::is_product_restricted_in_category( $product->get_id(), array() );
            if ( $product_is_restricted_in_category ) {
                $product_data = array();
            }
        }

        return $product_data;
    }

    /**
     * Run WWP integration hooks.
     *
     * @since 13.3.4
     */
    public function run() {
        if ( ! $this->is_active() ) {
            return;
        }

        add_filter( 'adt_get_product_data', array( $this, 'exclude_restricted_wholesale_products' ), 10, 3 );
    }
}
