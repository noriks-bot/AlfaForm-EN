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
 * Rules_Legacy class.
 *
 * @since 13.3.4.1
 */
class Rules_Legacy extends Abstract_Class {

    use Singleton_Trait;
    use Filters_Rules_Trait;

    /**
     * Rules data.
     *
     * @since 13.4.1
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

        $rules = $feed->rules;

        if ( empty( $rules ) ) {
            return $data;
        }

        foreach ( $rules as $rule ) {
            // Skip if any required rule parameters are missing.
            // Required parameters are: attribute, condition, criteria.
            if ( ! isset( $rule['attribute'] ) || ! isset( $rule['condition'] ) || ! isset( $rule['criteria'] ) ) {
                continue;
            }

            $value = $data[ $rule['attribute'] ] ?? '';

            $value = $this->maybe_get_category_hierarchy( $value, $rule['attribute'], $data );

            // Backward compatibility for category slug, for previous versions we used to use the category name.
            $rule = $this->maybe_get_category_slug( $rule, $rule['attribute'] );

            // For some reason, the calculation rules conditions doesn't show the than_attribute in the frontend.
            // So instead of altering the then_attribute, it will alter the attribute.
            $calculation_rules = array(
                'multiply',
                'divide',
                'plus',
                'minus',
            );

            if ( in_array( $rule['condition'], $calculation_rules, true ) ) {
                $data[ $rule['attribute'] ] = $this->calculate( $value, $rule['criteria'], $rule['condition'] );
            } elseif ( 'findreplace' === $rule['condition'] ) {
                // Find and replace only work on same attribute field, otherwise create a contains rule.
                $data[ $rule['attribute'] ] = $this->find_replace( $value, $rule );
            } else {
                $is_rule_met    = $this->is_rule_met( $value, $rule );
                $than_attribute = $rule['than_attribute'] ?? '';
                if ( $is_rule_met && ! empty( $than_attribute ) ) {
                    $data[ $rule['than_attribute'] ] = $rule['newvalue'];
                }
            }
        }

        return $data;
    }

    /**
     * Recursively check if the rule is met. For array compatibility.
     *
     * @since 13.4.1
     * @access private
     *
     * @param string $value The value to filter.
     * @param array  $rule The rule criteria.
     * @return bool
     */
    private function is_rule_met( $value, $rule ) {
        $rule_met = false;
        if ( ! is_array( $value ) ) {
            $rule_met = $this->check_rule( $value, $rule );
        } else {
            foreach ( $value as $key => $v ) {
                $rule_met = $this->is_rule_met( $v, $rule );
                if ( $rule_met ) {
                    break;
                }
            }
        }

        return $rule_met;
    }

    /**
     * Check if the rule is met.
     *
     * @since 13.4.1
     * @access private
     *
     * @param string $value The value to filter.
     * @param array  $rule  The rule criteria.
     * @return bool
     */
    private function check_rule( $value, $rule ) {
        $rule_met = false;

        $condition  = $rule['condition'] ?? '';
        $rule_value = $rule['criteria'] ?? '';

        // If not case sensitive then convert the value to lower case for comparison.
        if ( ! isset( $rule['cs'] ) || 'on' !== $rule['cs'] ) {
            $value      = strtolower( $value );
            $rule_value = strtolower( $rule_value );
        }

        switch ( $condition ) {
            case 'contains':
                if ( preg_match( '/' . preg_quote( $rule_value, '/' ) . '/', $value ) ) {
                    $rule_met = true;
                }
                break;
            case 'containsnot':
                if ( ! preg_match( '/' . preg_quote( $rule_value, '/' ) . '/', $value ) ) {
                    $rule_met = true;
                }
                break;
            case '=':
                if ( strcmp( $value, $rule_value ) === 0 ) {
                    $rule_met = true;
                }
                break;
            case '!=':
                if ( strcmp( $value, $rule_value ) !== 0 ) {
                    $rule_met = true;
                }
                break;
            case '>':
                if ( $value > $rule_value ) {
                    $rule_met = true;
                }
                break;
            case '>=':
                if ( $value >= $rule_value ) {
                    $rule_met = true;
                }
                break;
            case '<':
                if ( $value < $rule_value ) {
                    $rule_met = true;
                }
                break;
            case '<=':
            case '=<': // Backward compatibility for <=. Old version used =<.
                if ( $value <= $rule_value ) {
                    $rule_met = true;
                }
                break;
            case 'empty':
                if ( empty( $value ) ) {
                    $rule_met = true;
                }
                break;
            case 'notempty':
                if ( ! empty( $value ) ) {
                    $rule_met = true;
                }
                break;
        }

        return $rule_met;
    }

    /**
     * String to replace.
     *
     * @since 13.4.1
     * @access private
     *
     * @param string $original_value The original value.
     * @param array  $rule The rule criteria.
     * @return mixed
     */
    private function find_replace( $original_value, $rule ) {
        $replaced_value = $original_value;

        if ( is_array( $original_value ) ) {
            foreach ( $original_value as $key => $v ) {
                $replaced_value[ $key ] = $this->find_replace( $v, $rule );
            }
        } elseif ( is_string( $original_value ) ) {
            $replaced_value = str_replace( $rule['criteria'], $rule['newvalue'], $original_value );
        }
        return $replaced_value;
    }


    /**
     * Calculate the value.
     *
     * @since 13.4.1
     * @access private
     *
     * @param float  $value The value to calculate.
     * @param float  $rule_value The rule value to calculate.
     * @param string $operator The operator to use.
     * @return float
     */
    private function calculate( $value, $rule_value, $operator ) {
        // Check if both values are numeric.
        if ( ! is_numeric( $value ) || ! is_numeric( $rule_value ) ) {
            return $value;
        }

        switch ( $operator ) {
            case 'multiply':
                return $value * $rule_value;
            case 'divide':
                return $value / $rule_value;
            case 'plus':
                return $value + $rule_value;
            case 'minus':
                return $value - $rule_value;
        }

        return $value;
    }

    /**
     * AJAX handler for adding a rule row
     *
     * @since 13.4.2
     * @return void
     */
    public function ajax_add_rule() {
        check_ajax_referer( 'woosea_ajax_nonce', 'security' );

        if ( ! \AdTribes\PFP\Helpers\Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You are not allowed to perform this action.', 'woo-product-feed-pro' ) );
        }

        // Generate a unique row ID.
        $row_count = isset( $_POST['rowCount'] ) ? absint( $_POST['rowCount'] ) : round( microtime( true ) * 1000 );

        // Generate the HTML template.
        $html = $this->get_rule_template( $row_count );

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
        add_action( 'wp_ajax_woosea_ajax_add_rule', array( $this, 'ajax_add_rule' ) );
    }
}
