<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes\Legacy
 */

namespace AdTribes\PFP\Classes\Legacy;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Traits\Filters_Rules_Trait;

/**
 * Filters_Legacy class.
 *
 * @since 13.3.4.1
 */
class Filters_Legacy extends Abstract_Class {

    use Singleton_Trait;
    use Filters_Rules_Trait;

    /**
     * Filter data
     *
     * @since 13.4.1
     * @access public
     *
     * @param array  $data The data to filter.
     * @param object $feed The feed object.
     * @return array
     */
    public function filter( $data, $feed ) {
        $filters = $feed->filters ?? array();

        if ( empty( $data ) || empty( $filters ) ) {
            return $data;
        }

        $passed = true;

        foreach ( $filters as $filter ) {
            // Skip if any required filter parameters are missing.
            if ( ! $this->is_valid_filter( $filter ) ) {
                continue;
            }

            /**
             * Filter to skip a filter.
             *
             * @since 13.4.1
             *
             * @param bool   $skipped The skipped value.
             * @param array  $filter  The filter criteria.
             * @param array  $data    The data to filter.
             * @param object $feed    The feed object.
             * @return bool
             */
            if ( apply_filters( 'adt_pfp_maybe_skip_filter', false, $filter, $data, $feed ) ) {
                continue;
            }

            $attribute = $filter['attribute'];
            $value     = isset( $data[ $attribute ] ) ? $data[ $attribute ] : '';

            $value = $this->maybe_get_category_hierarchy( $value, $attribute, $data );

            // Backward compatibility for category slug, for previous versions we used to use the category name.
            $filter = $this->maybe_get_category_slug( $filter, $attribute );

            // Process the filter based on whether the value is an array or not.
            $filter_passed = $this->process_filter_value( $value, $filter, $feed );

            // If this filter didn't pass, mark the entire product as not passing.
            if ( ! $filter_passed ) {
                $passed = false;
                break; // No need to check other filters.
            }
        }

        /**
         * Filter passed product feed.
         *
         * @since 13.4.1
         *
         * @param bool   $passed The passed value.
         * @param array  $filters The filter criteria.
         * @param object $feed   The feed object.
         * @return bool
         */
        $passed = apply_filters( 'adt_pfp_filter_passed_product_feed', $passed, $filters, $feed );

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
     * Check if a filter has all required parameters.
     *
     * @since 13.4.1
     * @access private
     *
     * @param array $filter The filter to check.
     * @return bool
     */
    private function is_valid_filter( $filter ) {
        // Required parameters are: attribute, condition, criteria, than.
        return isset( $filter['attribute'] ) &&
                isset( $filter['condition'] ) &&
                isset( $filter['criteria'] ) &&
                isset( $filter['than'] );
    }

    /**
     * Process a filter value, handling both array and non-array values.
     *
     * @since 13.4.1
     * @access private
     *
     * @param mixed  $value The value to filter.
     * @param array  $filter The filter criteria.
     * @param object $feed The feed object.
     * @return bool Whether the filter passed.
     */
    public function process_filter_value( $value, $filter, $feed ) {
        if ( ! is_array( $value ) ) {
            return $this->filter_data( $value, $filter, $feed );
        }

        // Handle array values.
        if ( empty( $value ) ) {
            $value[] = ''; // Add empty value to ensure filter is applied.
        }

        $then      = $filter['than'] ?? '';
        $condition = $filter['condition'] ?? '';

        // Determine if we need ANY match or ALL matches.
        $requires_any_match = $this->requires_any_match( $then, $condition );

        return $this->process_array_value( $value, $filter, $feed, $requires_any_match );
    }

    /**
     * Determine if the filter requires any match or all matches.
     *
     * @since 13.4.1
     * @access private
     *
     * @param string $then The filter action (include_only/exclude).
     * @param string $condition The filter condition.
     * @return bool True if any match is required, false if all must match.
     */
    private function requires_any_match( $then, $condition ) {
        $any_match_conditions = array( 'contains', '=', '>=', '>', '<=', '<', 'notempty' );
        $all_match_conditions = array( 'containsnot', '!=', 'empty' );

        return ( 'include_only' === $then && in_array( $condition, $any_match_conditions, true ) ) ||
                ( 'exclude' === $then && in_array( $condition, $all_match_conditions, true ) );
    }

    /**
     * Process an array of values against a filter.
     *
     * @since 13.4.1
     * @access private
     *
     * @param array  $values The array of values to filter.
     * @param array  $filter The filter criteria.
     * @param object $feed The feed object.
     * @param bool   $requires_any_match Whether any match is sufficient.
     * @return bool
     */
    private function process_array_value( $values, $filter, $feed, $requires_any_match ) {
        if ( empty( $values ) ) {
            return false;
        }

        if ( $requires_any_match ) {
            // ANY match should pass.
            foreach ( $values as $v ) {
                // If value is an array, recursively process it.
                if ( is_array( $v ) ) {
                    if ( $this->process_array_value( $v, $filter, $feed, $requires_any_match ) ) {
                        return true;
                    }
                } elseif ( $this->filter_data( $v, $filter, $feed ) ) {
                    return true;
                }
            }
            return false;
        } else {
            // ALL must pass.
            foreach ( $values as $v ) {
                // If value is an array, recursively process it.
                if ( is_array( $v ) ) {
                    if ( ! $this->process_array_value( $v, $filter, $feed, $requires_any_match ) ) {
                        return false;
                    }
                } elseif ( ! $this->filter_data( $v, $filter, $feed ) ) {
                    return false;
                }
            }
            return true;
        }
    }

    /**
     * Filter data
     *
     * @since 13.4.1
     * @access private
     *
     * @param string $value The value to filter.
     * @param array  $filter The filter criteria.
     * @param object $feed The feed object.
     * @return bool
     */
    private function filter_data( $value, $filter, $feed ) {
        $condition    = $filter['condition'] ?? '';
        $filter_value = $filter['criteria'] ?? '';
        $then         = $filter['than'] ?? '';

        // If not case sensitive then convert the value to lower case for comparison.
        if ( ! isset( $filter['cs'] ) || 'on' !== $filter['cs'] ) {
            $value        = strtolower( $value );
            $filter_value = strtolower( $filter_value );
        }

        // Use a strategy pattern to simplify condition handling.
        switch ( $condition ) {
            case 'contains':
                $match = preg_match( '/' . preg_quote( $filter_value, '/' ) . '/', $value );
                return $this->evaluate_condition( $match, $then );

            case 'containsnot':
                $match = ! preg_match( '/' . preg_quote( $filter_value, '/' ) . '/', $value );
                return $this->evaluate_condition( $match, $then );

            case '=':
                $match = strcmp( $value, $filter_value ) === 0;
                return $this->evaluate_condition( $match, $then );

            case '!=':
                $match = strcmp( $value, $filter_value ) !== 0;
                return $this->evaluate_condition( $match, $then );

            case '>':
                $match = $value > $filter_value;
                return $this->evaluate_condition( $match, $then );

            case '>=':
                $match = $value >= $filter_value;
                return $this->evaluate_condition( $match, $then );

            case '<':
                $match = $value < $filter_value;
                return $this->evaluate_condition( $match, $then );

            case '<=':
            case '=<': // Backward compatibility for <=. Old version used =<.
                $match = $value <= $filter_value;
                return $this->evaluate_condition( $match, $then );

            case 'empty':
                $match = empty( $value );
                return $this->evaluate_condition( $match, $then );

            case 'notempty':
                $match = ! empty( $value );
                return $this->evaluate_condition( $match, $then );

            default:
                return true; // Default to passing if condition is unknown.
        }
    }

    /**
     * Evaluate a condition based on the match result and the filter action.
     *
     * @since 13.4.1
     * @access private
     *
     * @param bool   $matched Whether the condition matched.
     * @param string $then The filter action (include_only/exclude).
     * @return bool
     */
    private function evaluate_condition( $matched, $then ) {
        if ( 'exclude' === $then ) {
            return ! (bool) $matched; // For exclude, return false if match is true.
        } else { // include_only.
            return (bool) $matched; // For include_only, return true if match is true.
        }
    }

    /**
     * AJAX handler for adding a filter row
     *
     * @since 13.4.2
     * @return void
     */
    public function ajax_add_filter() {
        check_ajax_referer( 'woosea_ajax_nonce', 'security' );

        if ( ! \AdTribes\PFP\Helpers\Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You are not allowed to perform this action.', 'woo-product-feed-pro' ) );
        }

        // Generate a unique row ID.
        $row_count = isset( $_POST['rowCount'] ) ? absint( $_POST['rowCount'] ) : round( microtime( true ) * 1000 );

        // Generate the HTML template.
        $html = $this->get_filter_template( $row_count );

        wp_send_json_success(
            array(
                'html'     => $html,
                'rowCount' => $row_count,
            )
        );
    }

    /**
     * Run the class
     *
     * @codeCoverageIgnore
     * @since 13.4.1
     */
    public function run() {
        add_action( 'wp_ajax_woosea_ajax_add_filter', array( $this, 'ajax_add_filter' ) );
    }
}
