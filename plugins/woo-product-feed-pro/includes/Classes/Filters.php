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
use AdTribes\PFP\Classes\Legacy\Filters_Legacy;

/**
 * Filters class with backwards compatibility.
 *
 * @since 13.3.4.1
 */
class Filters extends Abstract_Filters_Rules {

    use Singleton_Trait;
    use Filters_Rules_Trait;

    /**
     * Filter data - main entry point
     *
     * @since 13.4.6
     * @access public
     *
     * @param array  $data The data to filter.
     * @param object $feed The feed object.
     * @return array
     */
    public function filter( $data, $feed ) {
        // Determine which filtering logic to use.
        if ( $this->should_use_legacy_filters( $feed ) ) {
            return $this->legacy_filter( $data, $feed );
        }

        return $this->validate_filters( $data, $feed );
    }

    /**
     * Determine if we should use legacy filters.
     * We're using the data version to determine if we should use the legacy filters.
     * If the data version is 13.4.6 or higher, we're using the new filters.
     * If the data version is lower than 13.4.6, we're using the legacy filters.
     *
     * The reason why we're not just checking if the feed_filters is empty and the filters legacy is present,
     * is because both the new and legacy filters can be present at the same time.
     *
     * @since 13.4.6
     * @access private
     *
     * @param object $feed The feed object.
     * @return bool
     */
    private function should_use_legacy_filters( $feed ) {
        if ( 'yes' === get_option( 'adt_use_legacy_filters_and_rules', 'no' ) ) {
            return true;
        }

        // Validate feed object.
        if ( ! $feed ) {
            return false;
        }

        $data_version = $feed->data_version;
        if ( ! empty( $data_version['feed_filters'] ) && version_compare( $data_version['feed_filters'], '13.4.6', '>=' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Process using legacy filters
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $data The data to filter.
     * @param object $feed The feed object.
     * @return array
     */
    private function legacy_filter( $data, $feed ) {
        $legacy_filters = new Filters_Legacy( $this->feed_type );
        return $legacy_filters->filter( $data, $feed );
    }

    /**
     * Validate filters structure before processing
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $data The data to filter.
     * @param object $feed The feed object.
     * @return array
     */
    private function validate_filters( $data, $feed ) {
        $filters = $feed->feed_filters ?? array();

        if ( empty( $filters ) ) {
            return $data; // No filters applied.
        }

        try {
            // Decode JSON if it's a string.
            if ( is_string( $filters ) ) {
                $filters = json_decode( $filters, true );
            }

            // Validate structure - check for include/exclude keys.
            if ( ! is_array( $filters ) || ( ! isset( $filters['include'] ) && ! isset( $filters['exclude'] ) ) ) {
                return $data; // Invalid structure, pass through.
            }

            return $this->process_filters( $data, $filters, $feed );
        } catch ( \Exception $e ) {
            // Log error and fall back to legacy if possible.
            error_log( 'PFP Filters Error: ' . $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log

            if ( $this->should_use_legacy_filters( $feed ) ) {
                return $this->legacy_filter( $data, $feed );
            }

            return $data;
        }
    }

    /**
     * Process filters structure
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $data The data to filter.
     * @param array  $filters The filters structure.
     * @param object $feed The feed object.
     * @return array
     */
    private function process_filters( $data, $filters, $feed ) {
        // Special handling for Google Product Review feeds.
        if ( 'google_product_review' === $feed->get_channel( 'fields' ) ) {
            $google_product_review = \AdTribes\PFP\Classes\Feeds\Google_Product_Review::instance();
            return $google_product_review->process_google_review_filters( $data, $filters, $feed );
        }

        $include_result = $this->process_include_groups( $data, $filters['include'] ?? array(), $feed );
        $exclude_result = $this->process_exclude_groups( $data, $filters['exclude'] ?? array(), $feed );

        // Product passes if it passes include filters AND doesn't match exclude filters.
        $passed = $include_result && ! $exclude_result;

        if ( ! $passed ) {
            $data = array();
        }

        /**
         * Filter the product feed data after filtering.
         *
         * @since 13.4.5
         *
         * @param array  $data The product feed data.
         * @param array  $filters The filters.
         * @param object $feed The feed.
         */
        return apply_filters( 'adt_pfp_filter_product_feed_data', $data, $filters, $feed );
    }

    /**
     * Process include groups - OR logic between groups
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $data The data to filter.
     * @param array  $groups The include groups.
     * @param object $feed The feed object.
     * @return bool
     */
    public function process_include_groups( $data, $groups, $feed ) {
        if ( empty( $groups ) ) {
            return true; // No include filters = include all.
        }

        // OR logic between groups - any group passing means include.
        foreach ( $groups as $group ) {
            if ( 'group' === $group['type'] && $this->process_group( $data, $group, $feed ) ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Process exclude groups - supports both AND and OR logic between groups
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $data The data to filter.
     * @param array  $groups The exclude groups.
     * @param object $feed The feed object.
     * @return bool
     */
    public function process_exclude_groups( $data, $groups, $feed ) {
        if ( empty( $groups ) ) {
            return false; // No exclude filters = exclude none.
        }

        $group_results = array();
        $current_logic = 'and'; // Default logic between groups.

        foreach ( $groups as $group ) {
            if ( 'group' === $group['type'] ) {
                $group_results[] = array(
                    'result' => $this->process_group( $data, $group, $feed ),
                    'logic'  => $current_logic,
                );
            } elseif ( 'group_logic' === $group['type'] ) {
                $logic_value = $group['value'] ?? '';
                if ( in_array( $logic_value, array( 'and', 'or' ), true ) ) {
                    $current_logic = $logic_value;
                }
            }
        }

        return $this->evaluate_exclude_group_results( $group_results );
    }

    /**
     * Evaluate exclude group results with logic operators
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $results The results array.
     * @return bool
     */
    private function evaluate_exclude_group_results( $results ) {
        if ( empty( $results ) ) {
            return false;
        }

        $final_result = $results[0]['result'];
        $result_count = count( $results );

        for ( $i = 1; $i < $result_count; $i++ ) {
            $current = $results[ $i ];
            if ( 'and' === $current['logic'] ) {
                $final_result = $final_result && $current['result'];
            } else { // 'or'
                $final_result = $final_result || $current['result'];
            }
        }

        return $final_result;
    }

    /**
     * Process a single group with its fields and logic
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $data The data to filter.
     * @param array  $group The group to process.
     * @param object $feed The feed object.
     * @return bool
     */
    private function process_group( $data, $group, $feed ) {
        $fields        = $group['fields'] ?? array();
        $results       = array();
        $current_logic = 'and'; // Default.

        // Validate group structure.
        if ( empty( $fields ) || ! is_array( $fields ) ) {
            return true; // Empty group passes.
        }

        foreach ( $fields as $field ) {
            // Validate field structure.
            if ( ! is_array( $field ) || ! isset( $field['type'] ) ) {
                continue; // Skip invalid fields.
            }

            if ( 'field' === $field['type'] ) {
                // Validate field data.
                if ( ! isset( $field['data'] ) || ! is_array( $field['data'] ) ) {
                    continue; // Skip invalid field data.
                }

                $results[] = array(
                    'result' => $this->process_field( $data, $field['data'], $feed ),
                    'logic'  => $current_logic,
                );
            } elseif ( 'logic' === $field['type'] ) {
                $logic_value = $field['data'] ?? '';
                if ( in_array( $logic_value, array( 'and', 'or' ), true ) ) {
                    $current_logic = $logic_value;
                }
            }
        }

        return $this->evaluate_group_results( $results );
    }

    /**
     * Evaluate group results with logic operators
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $results The results array.
     * @return bool
     */
    private function evaluate_group_results( $results ) {
        if ( empty( $results ) ) {
            return true;
        }

        $final_result = $results[0]['result'];
        $result_count = count( $results );

        for ( $i = 1; $i < $result_count; $i++ ) {
            $current = $results[ $i ];
            if ( 'and' === $current['logic'] ) {
                $final_result = $final_result && $current['result'];
            } else { // 'or'
                $final_result = $final_result || $current['result'];
            }
        }

        return $final_result;
    }

    /**
     * Process a single field
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $data The data to filter.
     * @param array  $field_data The field data.
     * @param object $feed The feed object.
     * @return bool
     */
    private function process_field( $data, $field_data, $feed ) {
        $attribute      = $field_data['attribute'] ?? '';
        $condition      = $field_data['condition'] ?? '';
        $value          = $field_data['value'] ?? '';
        $case_sensitive = $field_data['case_sensitive'] ?? false;

        $product_value = $data[ $attribute ] ?? '';

        // Apply category hierarchy logic if needed.
        $product_value = $this->maybe_get_category_hierarchy( $product_value, $attribute, $data );

        // Handle array values similar to legacy system.
        if ( ! is_array( $product_value ) ) {
            return $this->evaluate_field_condition( $product_value, $condition, $value, $case_sensitive );
        }

        // Handle array values.
        if ( empty( $product_value ) ) {
            $product_value[] = ''; // Add empty value to ensure filter is applied.
        }

        // Determine if we need ANY match or ALL matches for arrays.
        $requires_any_match = $this->requires_any_match_for_condition( $condition );

        return $this->process_array_field_value( $product_value, $condition, $value, $case_sensitive, $requires_any_match );
    }

    /**
     * Determine if condition requires any match for arrays
     *
     * @since 13.4.6
     * @access private
     *
     * @param string $condition The condition.
     * @return bool
     */
    private function requires_any_match_for_condition( $condition ) {
        $any_match_conditions = array(
            'contains',
            'equals',
            'greater_than_or_equal',
            'greater_than',
            'less_than_or_equal',
            'less_than',
            'is_not_empty',
        );
        return in_array( $condition, $any_match_conditions, true );
    }

    /**
     * Process array field values
     *
     * @since 13.4.6
     * @access private
     *
     * @param array  $values The array of values.
     * @param string $condition The condition.
     * @param mixed  $filter_value The filter value.
     * @param bool   $case_sensitive Whether to be case sensitive.
     * @param bool   $requires_any_match Whether any match is sufficient.
     * @return bool
     */
    private function process_array_field_value( $values, $condition, $filter_value, $case_sensitive, $requires_any_match ) {
        if ( empty( $values ) ) {
            return false;
        }

        if ( $requires_any_match ) {
            // ANY match should pass.
            foreach ( $values as $value ) {
                if ( is_array( $value ) ) {
                    if ( $this->process_array_field_value( $value, $condition, $filter_value, $case_sensitive, $requires_any_match ) ) {
                        return true;
                    }
                } elseif ( $this->evaluate_field_condition( $value, $condition, $filter_value, $case_sensitive ) ) {
                    return true;
                }
            }
            return false;
        } else {
            // ALL must pass.
            foreach ( $values as $value ) {
                if ( is_array( $value ) ) {
                    if ( ! $this->process_array_field_value( $value, $condition, $filter_value, $case_sensitive, $requires_any_match ) ) {
                        return false;
                    }
                } elseif ( ! $this->evaluate_field_condition( $value, $condition, $filter_value, $case_sensitive ) ) {
                    return false;
                }
            }
            return true;
        }
    }

    /**
     * Evaluate field condition using legacy logic
     *
     * @since 13.4.6
     * @access private
     *
     * @param mixed  $product_value The product value.
     * @param string $condition The condition.
     * @param mixed  $filter_value The filter value.
     * @param bool   $case_sensitive Whether to be case sensitive.
     * @return bool
     */
    private function evaluate_field_condition( $product_value, $condition, $filter_value, $case_sensitive ) {
        // Handle case sensitivity.
        if ( ! $case_sensitive ) {
            $product_value = strtolower( $product_value );
            $filter_value  = strtolower( $filter_value );
        }

        switch ( $condition ) {
            case 'contains':
                return (bool) preg_match( '/' . preg_quote( $filter_value, '/' ) . '/', $product_value );

            case 'not_contains':
                return ! (bool) preg_match( '/' . preg_quote( $filter_value, '/' ) . '/', $product_value );

            case 'equals':
                return strcmp( $product_value, $filter_value ) === 0;

            case 'not_equals':
                return strcmp( $product_value, $filter_value ) !== 0;

            case 'greater_than':
                return $product_value > $filter_value;

            case 'greater_than_or_equal':
                return $product_value >= $filter_value;

            case 'less_than':
                return $product_value < $filter_value;

            case 'less_than_or_equal':
                return $product_value <= $filter_value;

            case 'is_empty':
                return empty( $product_value );

            case 'is_not_empty':
                return ! empty( $product_value );

            default:
                return true; // Default to passing if condition is unknown.
        }
    }

    /**
     * Run the class
     *
     * @codeCoverageIgnore
     * @since 13.4.6
     */
    public function run() {}
}
