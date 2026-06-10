<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP
 */

namespace AdTribes\PFP\Abstracts;

use AdTribes\PFP\Classes\Product_Feed_Attributes;

defined( 'ABSPATH' ) || exit;

/**
 * Abstract Class
 */
abstract class Abstract_Filters_Rules extends Abstract_Class {

    /**
     * The feed type.
     *
     * @since 13.4.5
     * @access public
     *
     * @var string
     */
    public $feed_type = '';

    /**
     * Product feed attributes instance.
     *
     * @since 13.4.5
     * @access public
     *
     * @var Product_Feed_Attributes
     */
    protected $product_feed_attributes;

    /**
     * Product feed attributes.
     *
     * @since 13.4.5
     * @access public
     *
     * @var array
     */
    public $attributes = array();

    /**
     * Construct.
     *
     * @param string $feed_type The feed type.
     */
    public function __construct( $feed_type = '' ) {
        $this->feed_type = $feed_type;
    }

    /**
     * Get available conditions for filters and rules.
     *
     * @since 13.4.6
     * @access public
     *
     * @param bool $value_only Whether to return only the value of the conditions.
     * @return array
     */
    public function get_conditions( $value_only = false ) {
        $conditions = array(
            array(
                'value' => 'contains',
                'label' => __( 'Contains', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'not_contains',
                'label' => __( 'Not Contains', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'equals',
                'label' => __( 'Equals', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'not_equals',
                'label' => __( 'Not Equals', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'greater_than',
                'label' => __( 'Greater Than', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'less_than',
                'label' => __( 'Less Than', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'greater_than_or_equal',
                'label' => __( 'Greater Than or Equal', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'less_than_or_equal',
                'label' => __( 'Less Than or Equal', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'is_empty',
                'label' => __( 'Is Empty', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'is_not_empty',
                'label' => __( 'Is Not Empty', 'woo-product-feed-pro' ),
            ),
        );

        /**
         * Filter the conditions for filters and rules.
         *
         * @since 13.4.6
         *
         * @param array $conditions The conditions for filters and rules.
         */
        $conditions = apply_filters( 'adt_pfp_get_filters_rules_conditions', $conditions );

        if ( $value_only ) {
            $conditions = array_column( $conditions, 'value' );
        }

        return $conditions;
    }

    /**
     * Run the class
     *
     * @since 13.4.5
     * @access public
     */
    abstract public function run();
}
