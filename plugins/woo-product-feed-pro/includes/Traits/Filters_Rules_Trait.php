<?php
/**
 * Trait to handle templates for filters and rules
 *
 * @package AdTribes\PFP\Traits
 * @since 1.0.0
 */

namespace AdTribes\PFP\Traits;

use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Classes\Product_Feed_Attributes;

defined( 'ABSPATH' ) || exit;

/**
 * Filters_Rules_Trait trait.
 */
trait Filters_Rules_Trait {

    /**
     * Legacy: GGet attributes.
     *
     * @deprecated 13.4.6 Use new attributes methods in REST/Filters_Rules.php
     *
     * @since 13.4.6
     * @access public
     *
     * @return array
     */
    protected function get_attributes() {
        $product_feed_attributes = new Product_Feed_Attributes();
        $attributes              = $product_feed_attributes->get_attributes();
        return apply_filters( 'adt_pfp_get_filters_rules_attributes', $attributes, $this );
    }

    /**
     * Legacy: Get template for filter row.
     *
     * @deprecated 13.4.6 Use new filter row rendering methods.
     *
     * @param int   $row_count     Row count for the filter.
     * @param array $filter_data   Optional. Filter data for existing filter.
     * @return string HTML markup for filter row.
     */
    public function get_filter_template( $row_count, $filter_data = array() ) {
        // Legacy implementation.
        $criteria           = isset( $filter_data['criteria'] ) ? $filter_data['criteria'] : '';
        $condition          = isset( $filter_data['condition'] ) ? $filter_data['condition'] : '';
        $than               = isset( $filter_data['than'] ) ? $filter_data['than'] : '';
        $is_case_sensitive  = isset( $filter_data['cs'] ) && 'on' === $filter_data['cs'] ? true : false;
        $selected_attribute = isset( $filter_data['attribute'] ) ? $filter_data['attribute'] : '';

        ob_start();
        Helper::locate_admin_template(
            'filters-rules/filter-row.php',
            true,
            false,
            array(
                'row_count'          => $row_count,
                'attributes'         => $this->get_attributes(),
                'filter_data'        => $filter_data,
                'criteria'           => $criteria,
                'condition'          => $condition,
                'than'               => $than,
                'is_case_sensitive'  => $is_case_sensitive,
                'selected_attribute' => $selected_attribute,
            )
        );
        return ob_get_clean();
    }

    /**
     * Legacy: Get template for rule row.
     *
     * @deprecated 13.4.6 Use new rule row rendering methods.
     *
     * @param int   $row_count     Row count for the rule.
     * @param array $rule_data     Optional. Rule data for existing rule.
     * @return string HTML markup for rule row.
     */
    public function get_rule_template( $row_count, $rule_data = array() ) {
        // Legacy implementation.
        $criteria           = isset( $rule_data['criteria'] ) ? $rule_data['criteria'] : '';
        $condition          = isset( $rule_data['condition'] ) ? $rule_data['condition'] : '';
        $new_value          = isset( $rule_data['newvalue'] ) ? $rule_data['newvalue'] : '';
        $is_case_sensitive  = isset( $rule_data['cs'] ) && 'on' === $rule_data['cs'] ? true : false;
        $selected_attribute = isset( $rule_data['attribute'] ) ? $rule_data['attribute'] : '';
        $than_attribute     = isset( $rule_data['than_attribute'] ) ? $rule_data['than_attribute'] : '';

        ob_start();
        Helper::locate_admin_template(
            'filters-rules/rule-row.php',
            true,
            false,
            array(
                'row_count'          => $row_count,
                'attributes'         => $this->get_attributes(),
                'rule_data'          => $rule_data,
                'criteria'           => $criteria,
                'condition'          => $condition,
                'new_value'          => $new_value,
                'is_case_sensitive'  => $is_case_sensitive,
                'selected_attribute' => $selected_attribute,
                'than_attribute'     => $than_attribute,
            )
        );
        return ob_get_clean();
    }

    /**
     * Legacy: Get condition options HTML.
     *
     * @deprecated 13.4.6 Use new condition options rendering methods.
     *
     * @param string $selected Selected condition.
     * @param string $type     Filter or rule type.
     * @return string HTML for condition options.
     */
    public static function get_condition_options( $selected = '', $type = 'filter' ) {
        $conditions = self::get_condition_list( $type );
        $html       = '';

        // Backward compatibility for <=. Old version used =<.
        if ( '=<' === $selected ) {
            $selected = '<=';
        }

        foreach ( $conditions as $value => $label ) {
            $html .= '<option value="' . esc_attr( $value ) . '"' . selected( $selected, $value, false ) . '>' . esc_html( $label ) . '</option>';
        }

        return $html;
    }

    /**
     * Legacy: Get list of available conditions.
     *
     * @deprecated 13.4.6 Use new condition list methods.
     *
     * @param string $type Filter or rule type.
     * @return array Array of conditions.
     */
    public static function get_condition_list( $type = 'filter' ) {
        $conditions = array(
            'contains'    => __( 'contains', 'woo-product-feed-pro' ),
            'containsnot' => __( 'doesn\'t contain', 'woo-product-feed-pro' ),
            '='           => __( 'is equal to', 'woo-product-feed-pro' ),
            '!='          => __( 'is not equal to', 'woo-product-feed-pro' ),
            '>'           => __( 'is greater than', 'woo-product-feed-pro' ),
            '>='          => __( 'is greater or equal to', 'woo-product-feed-pro' ),
            '<'           => __( 'is less than', 'woo-product-feed-pro' ),
            '<='          => __( 'is less or equal to', 'woo-product-feed-pro' ),
            'empty'       => __( 'is empty', 'woo-product-feed-pro' ),
            'notempty'    => __( 'is not empty', 'woo-product-feed-pro' ),
        );

        // Add additional conditions for rules.
        if ( 'rule' === $type ) {
            $rule_conditions = array(
                'multiply'    => __( 'multiply', 'woo-product-feed-pro' ),
                'divide'      => __( 'divide', 'woo-product-feed-pro' ),
                'plus'        => __( 'plus', 'woo-product-feed-pro' ),
                'minus'       => __( 'minus', 'woo-product-feed-pro' ),
                'findreplace' => __( 'find and replace', 'woo-product-feed-pro' ),
            );

            $conditions = array_merge( $conditions, $rule_conditions );
        }

        return $conditions;
    }

    /**
     * Legacy: Get action options HTML.
     *
     * @deprecated 13.4.6 Use new action options rendering methods.
     *
     * @param string $selected Selected action.
     * @return string HTML for action options.
     */
    public static function get_action_options( $selected = '' ) {
        $actions = array(
            'exclude'      => __( 'Exclude', 'woo-product-feed-pro' ),
            'include_only' => __( 'Include only', 'woo-product-feed-pro' ),
        );

        $html = '<optgroup label="' . esc_attr__( 'Action', 'woo-product-feed-pro' ) . '">';

        foreach ( $actions as $value => $label ) {
            $html .= '<option value="' . esc_attr( $value ) . '"' . selected( $selected, $value, false ) . '>' . esc_html( $label ) . '</option>';
        }

        $html .= '</optgroup>';

        return $html;
    }

    /**
     * Get the category hierarchy.
     *
     * @since 13.4.4.1
     * @access private
     *
     * @param string $value The value to get the category hierarchy for.
     * @param string $attribute The attribute to get the category hierarchy for.
     * @param array  $data The data to get the category hierarchy for.
     * @return string The category hierarchy.
     */
    public function maybe_get_category_hierarchy( $value, $attribute, $data ) {
        $categories_attributes = array( 'categories', 'raw_categories' );
        if ( in_array( $attribute, $categories_attributes, true ) ) {
            $value = $this->get_category_hierarchy( $value, $data );
        }

        return $value;
    }

    /**
     * Get the category hierarchy.
     *
     * @since 13.4.4.1
     * @access private
     *
     * @param string $value The value to get the category hierarchy for.
     * @param array  $data The data to get the category hierarchy for.
     * @return string The category hierarchy.
     */
    public function get_category_hierarchy( $value, $data ) {
        $product_id = $data['id'] ?? 0;
        if ( ! $product_id ) {
            return $value;
        }

        $product = wc_get_product( $product_id );
        if ( ! $product ) {
            return $value;
        }

        if ( $product->is_type( 'variation' ) ) {
            $parent_product = wc_get_product( $product->get_parent_id() );
            if ( $parent_product ) {
                $categories = $parent_product->get_category_ids();
            }
        } else {
            $categories = $product->get_category_ids();
        }

        if ( empty( $categories ) ) {
            return $value;
        }

        $category_hierarchy = array();
        foreach ( $categories as $category ) {
            $category_hierarchy[] = get_term( $category, 'product_cat' )->slug;
        }
        return $category_hierarchy;
    }

    /**
     * Get the category slug.
     * Backward compatibility for category slug, for previous versions we used to use the category name.
     *
     * @since 13.4.4.1
     * @access private
     *
     * @param array  $filter_or_rule The filter or rule to get the category slug for.
     * @param string $attribute The attribute to get the category slug for.
     * @return array The filter with the category slug.
     */
    public function maybe_get_category_slug( $filter_or_rule, $attribute ) {
        $categories_attributes = array( 'categories', 'raw_categories' );
        if ( in_array( $attribute, $categories_attributes, true ) ) {
            $criteria = $filter_or_rule['criteria'] ?? '';

            // If the value is a category name, convert it to a slug.
            if ( is_string( $criteria ) && ! empty( $criteria ) ) {
                $term = get_term_by( 'name', $criteria, 'product_cat' );
                if ( $term && ! is_wp_error( $term ) ) {
                    $filter_or_rule['criteria'] = $term->slug;
                }
            }
        }
        return $filter_or_rule;
    }
}
