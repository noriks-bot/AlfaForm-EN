<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Filters_Rules;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Traits\Filters_Rules_Trait;
use AdTribes\PFP\Classes\Legacy\Rules_Legacy;

/**
 * Rules class.
 *
 * @since 13.4.6
 */
class Rules extends Abstract_Filters_Rules {

    use Singleton_Trait;
    use Filters_Rules_Trait;

    /**
     * Get available actions for filters and rules.
     *
     * @since 13.4.6
     * @access public
     *
     * @param bool $value_only Whether to return only the value of the actions.
     * @return array
     */
    public function get_actions( $value_only = false ) {
        $actions = array(
            array(
                'value' => 'set_value',
                'label' => __( 'Set Value', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'set_attribute',
                'label' => __( 'Set Attribute (Elite)', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'findreplace',
                'label' => __( 'Find and Replace', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'multiply',
                'label' => __( 'Multiply', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'divide',
                'label' => __( 'Divide', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'plus',
                'label' => __( 'Plus', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'minus',
                'label' => __( 'Minus', 'woo-product-feed-pro' ),
            ),
            array(
                'value' => 'exclude',
                'label' => __( 'Exclude Attribute (Elite)', 'woo-product-feed-pro' ),
            ),
        );

        /**
         * Filter the actions for filters and rules.
         *
         * @since 13.4.6
         *
         * @param array $actions The actions for filters and rules.
         */
        $actions = apply_filters( 'adt_pfp_get_rules_actions', $actions );

        if ( $value_only ) {
            $actions = array_column( $actions, 'value' );
        }

        return $actions;
    }

    /**
     * Main rules processing method.
     *
     * @since 13.4.6
     * @access public
     *
     * @param array  $data The data to filter.
     * @param object $feed The feed object.
     * @return array
     */
    public function rules( $data, $feed ) {
        if ( empty( $data ) ) {
            return $data;
        }

        // Determine which rules system to use.
        $use_legacy = $this->should_use_legacy_rules( $feed );

        if ( $use_legacy ) {
            return $this->process_legacy_rules( $data, $feed );
        }

        return $this->process_rules( $data, $feed );
    }

    /**
     * Determine if we should use legacy rules.
     * We're using the data version to determine if we should use the legacy rules.
     * If the data version is 13.4.6 or higher, we're using the new rules.
     * If the data version is lower than 13.4.6, we're using the legacy rules.
     *
     * The reason why we're not just checking if the feed_rules is empty and the rules legacy is present,
     * is because both the new and legacy rules can be present at the same time.
     *
     * @since 13.4.6
     * @access private
     *
     * @param object $feed The feed object.
     * @return bool
     */
    private function should_use_legacy_rules( $feed ) {
        if ( 'yes' === get_option( 'adt_use_legacy_filters_and_rules', 'no' ) ) {
            return true;
        }

        // Validate feed object.
        if ( ! $feed ) {
            return false;
        }

        $data_version = $feed->data_version;
        if ( ! empty( $data_version['feed_rules'] ) && version_compare( $data_version['feed_rules'], '13.4.6', '>=' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Process legacy rules using Rules_Legacy class.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $data The data to filter.
     * @param object $feed The feed object.
     * @return array
     */
    private function process_legacy_rules( $data, $feed ) {
        $legacy_rules = Rules_Legacy::instance();
        return $legacy_rules->rules( $data, $feed );
    }

    /**
     * Process grouped rules.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $data The data to filter.
     * @param object $feed The feed object.
     * @return array
     */
    private function process_rules( $data, $feed ) {
        $rules = $feed->feed_rules ?? array();

        if ( empty( $rules ) ) {
            return $data;
        }

        // Special handling for Google Product Review feeds.
        if ( 'google_product_review' === $feed->get_channel( 'fields' ) ) {
            $google_product_review = \AdTribes\PFP\Classes\Feeds\Google_Product_Review::instance();
            return $google_product_review->process_google_review_rules( $data, $rules, $feed );
        }

        // Process each rule in the new format.
        foreach ( $rules as $rule ) {
            if ( ! isset( $rule['if'] ) || ! isset( $rule['then'] ) ) {
                continue;
            }

            // Evaluate the rule conditions.
            if ( $this->evaluate_rule_conditions( $rule['if'], $data ) ) {
                // Apply the rule actions.
                $data = $this->apply_rule_actions( $rule['then'], $data, $feed );
            }
        }

        return $data;
    }

    /**
     * Evaluate rule conditions (IF part).
     *
     * @since 13.4.6
     * @access public
     *
     * @param array $conditions The rule conditions.
     * @param array $data The product data.
     * @return bool
     */
    public function evaluate_rule_conditions( $conditions, &$data ) {
        // If there are no conditions, means that the rule will apply to all products.
        if ( empty( $conditions ) ) {
            return true;
        }

        $group_results         = array();
        $group_logic_operators = array();

        // Process each condition item.
        foreach ( $conditions as $condition ) {
            $type = $condition['type'] ?? '';

            switch ( $type ) {
                case 'group':
                    $group_results[] = $this->process_group( $condition, $data );
                    break;
                case 'group_logic':
                    $group_logic_operators[] = $condition['value'] ?? 'and';
                    break;
            }
        }

        // Combine group results with group logic operators.
        return $this->combine_group_results( $group_results, $group_logic_operators );
    }

    /**
     * Process a condition group.
     *
     * @since 13.4.6
     * @access public
     *
     * @param array $group The group data.
     * @param array $data The product data.
     * @return bool
     */
    public function process_group( $group, &$data ) {
        if ( 'group' !== $group['type'] || ! isset( $group['fields'] ) ) {
            return false;
        }

        $fields          = $group['fields'];
        $field_results   = array();
        $logic_operators = array();

        // Separate fields and logic operators.
        foreach ( $fields as $field ) {
            $field_type = $field['type'] ?? '';

            switch ( $field_type ) {
                case 'field':
                    $field_results[] = $this->evaluate_field_condition( $field, $data );
                    break;
                case 'logic':
                    $logic_operators[] = $field['data'] ?? 'and';
                    break;
            }
        }

        // Combine field results with logic operators.
        return $this->combine_field_results( $field_results, $logic_operators );
    }

    /**
     * Evaluate individual field condition.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $field The field data.
     * @param array $data The product data.
     * @return bool
     */
    private function evaluate_field_condition( $field, &$data ) {
        if ( ! isset( $field['data'] ) ) {
            return false;
        }

        $field_data     = $field['data'];
        $attribute      = $field_data['attribute'] ?? '';
        $condition      = $field_data['condition'] ?? '';
        $value          = $field_data['value'] ?? '';
        $case_sensitive = $field_data['case_sensitive'] ?? false;

        if ( empty( $attribute ) || empty( $condition ) ) {
            return false;
        }

        $data_value = $data[ $attribute ] ?? '';

        // Handle category hierarchy if needed.
        $data_value = $this->maybe_get_category_hierarchy( $data_value, $attribute, $data );

        // Use the condition checking logic (reuse from legacy).
        return $this->check_condition( $data_value, $condition, $value, $case_sensitive );
    }

    /**
     * Check condition using the same logic as legacy rules.
     *
     * @since 13.4.6
     * @access private
     *
     * @param mixed  $data_value The data value.
     * @param string $condition The condition.
     * @param mixed  $rule_value The rule value.
     * @param bool   $case_sensitive Whether to check case sensitively.
     * @return bool
     */
    private function check_condition( $data_value, $condition, $rule_value, $case_sensitive = false ) {
        // Handle array values recursively.
        if ( is_array( $data_value ) ) {
            foreach ( $data_value as $v ) {
                if ( $this->check_condition( $v, $condition, $rule_value, $case_sensitive ) ) {
                    return true;
                }
            }
            return false;
        }

        // Convert to string for comparison.
        $data_value = (string) $data_value;
        $rule_value = (string) $rule_value;

        // Handle case sensitivity.
        if ( ! $case_sensitive ) {
            $data_value = strtolower( $data_value );
            $rule_value = strtolower( $rule_value );
        }

        // Use descriptive condition names directly.
        switch ( $condition ) {
            case 'contains':
                return false !== strpos( $data_value, $rule_value );
            case 'not_contains':
                return false === strpos( $data_value, $rule_value );
            case 'equals':
                return $data_value === $rule_value;
            case 'not_equals':
                return $data_value !== $rule_value;
            case 'greater_than':
                return is_numeric( $data_value ) && is_numeric( $rule_value ) && $data_value > $rule_value;
            case 'greater_than_or_equal':
                return is_numeric( $data_value ) && is_numeric( $rule_value ) && $data_value >= $rule_value;
            case 'less_than':
                return is_numeric( $data_value ) && is_numeric( $rule_value ) && $data_value < $rule_value;
            case 'less_than_or_equal':
                return is_numeric( $data_value ) && is_numeric( $rule_value ) && $data_value <= $rule_value;
            case 'is_empty':
                return empty( $data_value );
            case 'is_not_empty':
                return ! empty( $data_value );
        }

        return false;
    }

    /**
     * Combine field results with logic operators.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $results The field results.
     * @param array $operators The logic operators.
     * @return bool
     */
    private function combine_field_results( $results, $operators ) {
        // If the field results are empty, return true.
        // That means that the condition will apply to all products.
        if ( empty( $results ) ) {
            return true;
        }

        if ( 1 === count( $results ) ) {
            return $results[0];
        }

        $combined_result = $results[0];
        $results_count   = count( $results );

        for ( $i = 1; $i < $results_count; $i++ ) {
            $operator = $operators[ $i - 1 ] ?? 'and';

            if ( 'or' === $operator ) {
                $combined_result = $combined_result || $results[ $i ];
            } else {
                $combined_result = $combined_result && $results[ $i ];
            }
        }

        return $combined_result;
    }

    /**
     * Combine group results with group logic operators.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $results The group results.
     * @param array $operators The group logic operators.
     * @return bool
     */
    private function combine_group_results( $results, $operators ) {
        if ( empty( $results ) ) {
            return false;
        }

        if ( 1 === count( $results ) ) {
            return $results[0];
        }

        $combined_result = $results[0];
        $results_count   = count( $results );

        for ( $i = 1; $i < $results_count; $i++ ) {
            $operator = $operators[ $i - 1 ] ?? 'and';

            if ( 'or' === $operator ) {
                $combined_result = $combined_result || $results[ $i ];
            } else {
                $combined_result = $combined_result && $results[ $i ];
            }
        }

        return $combined_result;
    }

    /**
     * Apply rule actions (THEN part).
     *
     * @since 13.4.6
     * @access private
     *
     * @param array        $actions The rule actions.
     * @param array        $data The product data.
     * @param Product_Feed $feed The feed object.
     * @return array
     */
    private function apply_rule_actions( $actions, $data, $feed ) {
        if ( empty( $actions ) ) {
            return $data;
        }

        // Handle Google Product Review feed.
        if ( 'google_product_review' === $feed->get_channel( 'fields' ) ) {
            $google_product_review = \AdTribes\PFP\Classes\Feeds\Google_Product_Review::instance();
            $data                  = $google_product_review->process_google_review_rules_actions( $data, $actions, $feed );
        } else {
            foreach ( $actions as $action ) {
                $data = $this->process_action( $data, $action, $feed );
            }
        }

        /**
         * Filter the data after applying the rule actions.
         *
         * @since 13.4.6
         *
         * @param array        $data The data to filter.
         * @param array        $actions The actions to apply.
         * @param Product_Feed $feed The feed object.
         */
        return apply_filters( 'adt_pfp_apply_rule_actions', $data, $actions, $feed );
    }

    /**
     * Process an action.
     *
     * @since 13.4.6
     * @since 13.5.1 Added $feed parameter.
     * @access private
     *
     * @param array  $data The data to filter.
     * @param array  $action The action to apply.
     * @param object $feed The feed object.
     * @return array The filtered data array.
     */
    public function process_action( $data, $action, $feed ) {
        $attribute   = $action['attribute'] ?? '';
        $value       = $action['value'] ?? '';
        $action_type = $action['action'] ?? 'set_value';

        if ( empty( $attribute ) ) {
            return $data;
        }

        // Handle calculation operations.
        if ( in_array( $action_type, array( 'multiply', 'divide', 'plus', 'minus' ), true ) ) {
            $current_value      = $data[ $attribute ] ?? 0;
            $data[ $attribute ] = $this->calculate( $current_value, $value, $action_type );
        } elseif ( 'findreplace' === $action_type ) { // Handle findreplace.
            $current_value      = $data[ $attribute ] ?? '';
            $data[ $attribute ] = $this->find_replace( $current_value, $action );
        } elseif ( 'set_value' === $action_type ) { // Handle set_value.
            $current_value      = $data[ $attribute ] ?? '';
            $data[ $attribute ] = $this->set_value( $current_value, $value );
        }

        /**
         * Filter the data after applying the rule action.
         *
         * @since 13.4.6
         *
         * @param array $data The data to filter.
         * @param array $action The action to apply.
         * @param object $feed The feed object.
         * @return array
         */
        return apply_filters( 'adt_pfp_process_rules_action', $data, $action, $feed );
    }

    /**
     * Calculate the value.
     *
     * @since 13.4.6
     * @access public
     *
     * @param float  $value The value to calculate.
     * @param float  $rule_value The rule value to calculate.
     * @param string $operator The operator to use.
     * @return float
     */
    public function calculate( $value, $rule_value, $operator ) {
        // Check if both values are numeric.
        if ( ! is_numeric( $value ) || ! is_numeric( $rule_value ) ) {
            return $value;
        }

        switch ( $operator ) {
            case 'multiply':
                return $value * $rule_value;
            case 'divide':
                return 0 !== $rule_value ? $value / $rule_value : $value; // Prevent division by zero.
            case 'plus':
                return $value + $rule_value;
            case 'minus':
                return $value - $rule_value;
        }

        return $value;
    }

    /**
     * String to replace.
     *
     * @since 13.4.6
     * @access public
     *
     * @param mixed $original_value The original value.
     * @param array $action The action data.
     * @return mixed
     */
    public function find_replace( $original_value, $action ) {
        $replaced_value = $original_value;

        if ( is_array( $original_value ) ) {
            foreach ( $original_value as $key => $v ) {
                $replaced_value[ $key ] = $this->find_replace( $v, $action );
            }
        } elseif ( is_string( $original_value ) ) {
            $find_text      = $action['find'] ?? '';
            $new_value      = $action['value'] ?? '';
            $replaced_value = str_replace( $find_text, $new_value, $original_value );
        }
        return $replaced_value;
    }

    /**
     * Recursively set value for arrays.
     *
     * @since 13.4.6
     * @access public
     *
     * @param mixed $original_value The original value.
     * @param mixed $new_value The new value to set.
     * @return mixed
     */
    public function set_value( $original_value, $new_value ) {
        if ( is_array( $original_value ) ) {
            $result = array();
            foreach ( $original_value as $key => $v ) {
                $result[ $key ] = $this->set_value( $v, $new_value );
            }
            return $result;
        } else {
            return $new_value;
        }
    }

    /**
     * Run the class.
     *
     * @codeCoverageIgnore
     * @since 13.4.6
     */
    public function run() {}
}
