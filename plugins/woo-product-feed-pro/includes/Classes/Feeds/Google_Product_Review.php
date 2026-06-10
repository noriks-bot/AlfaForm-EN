<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes\Feeds
 */

namespace AdTribes\PFP\Classes\Feeds;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Classes\Filters;
use AdTribes\PFP\Classes\Rules;
use AdTribes\PFP\Classes\Legacy\Filters_Legacy;

/**
 * Google Product Review class.
 *
 * @since 13.4.5
 */
class Google_Product_Review extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Feed type.
     *
     * @since 13.4.5
     *
     * @var string
     */
    protected $feed_type = 'google_product_review';

    /**
     * Attributes.
     *
     * @since 13.4.5
     *
     * @var array
     */
    protected $review_attributes = array(
        'review_id',
        'reviewer_id',
        'review_ratings',
        'review_rating', // Also include singular version for compatibility.
        'reviewer_name',
        'content',
        'review_reviever_image',
        'review_url',
        'title',
        'review_product_url',
    );

    /**
     * Construct.
     *
     * @since 13.4.5
     */
    public function __construct() {
    }

    /**
     * Add google product review attributes to filters and rules.
     *
     * @since 13.4.5
     *
     * @param array  $attributes The attributes.
     * @param string $channel_type The channel type.
     * @return array
     */
    public function get_attributes( $attributes, $channel_type ) {
        if ( $this->feed_type !== $channel_type ) {
            return $attributes;
        }

        // Add reviews attribute.
        $attributes['Google Product Review'] = array(
            'review_id'             => __( 'Review ID', 'woo-product-feed-pro' ),
            'reviewer_id'           => __( 'Reviewer ID', 'woo-product-feed-pro' ),
            'review_ratings'        => __( 'Review rating', 'woo-product-feed-pro' ),
            'reviewer_name'         => __( 'Reviewer name', 'woo-product-feed-pro' ),
            'content'               => __( 'Review content', 'woo-product-feed-pro' ),
            'review_reviever_image' => __( 'Reviewer image', 'woo-product-feed-pro' ),
            'review_url'            => __( 'Review URL', 'woo-product-feed-pro' ),
            'title'                 => __( 'Product title', 'woo-product-feed-pro' ),
            'review_product_url'    => __( 'Product URL', 'woo-product-feed-pro' ),
        );
        return $attributes;
    }


    /**
     * Process filters for Google Product Review feeds
     *
     * @since 13.4.6
     * @access private
     *
     * @param array        $data The data to filter.
     * @param array        $filters The filters structure.
     * @param Product_Feed $feed The feed object.
     * @return array
     */
    public function process_google_review_filters( $data, $filters, $feed ) {
        // Get the filters instance.
        $filters_instance = Filters::instance();

        // Separate review filters from product filters.
        $review_filters  = array(
            'include' => array(),
            'exclude' => array(),
        );
        $product_filters = array(
            'include' => array(),
            'exclude' => array(),
        );

        foreach ( array( 'include', 'exclude' ) as $type ) {
            foreach ( $filters[ $type ] ?? array() as $group ) {
                if ( 'group' !== $group['type'] ) {
                    continue;
                }

                $has_review_fields  = false;
                $has_product_fields = false;

                // Check what type of fields this group contains.
                foreach ( $group['fields'] ?? array() as $field ) {
                    if ( 'field' === $field['type'] && isset( $field['data']['attribute'] ) ) {
                        if ( in_array( $field['data']['attribute'], $this->review_attributes, true ) ) {
                            $has_review_fields = true;
                        } else {
                            $has_product_fields = true;
                        }
                    }
                }

                // Handle different scenarios.
                if ( $has_review_fields && ! $has_product_fields ) {
                    // Pure review filter - apply to individual reviews.
                    $review_filters[ $type ][] = $group;
                } elseif ( ! $has_review_fields && $has_product_fields ) {
                    // Pure product filter - apply to product.
                    $product_filters[ $type ][] = $group;
                } else { // phpcs:ignore
                    // Mixed group - handle based on filter type.
                    if ( 'exclude' === $type ) {
                        // For exclude filters with mixed attributes, we need special handling.
                        // The group should only exclude reviews that match BOTH conditions.
                        $review_filters[ $type ][] = $group; // Keep the whole group for review filtering.
                    } else {
                        // For include filters, split as before.
                        $review_group  = array(
                            'type'   => 'group',
                            'fields' => array(),
                        );
                        $product_group = array(
                            'type'   => 'group',
                            'fields' => array(),
                        );

                        foreach ( $group['fields'] ?? array() as $field ) {
                            if ( 'field' === $field['type'] && isset( $field['data']['attribute'] ) ) {
                                if ( in_array( $field['data']['attribute'], $this->review_attributes, true ) ) {
                                    $review_group['fields'][] = $field;
                                } else {
                                    $product_group['fields'][] = $field;
                                }
                            } else {
                                // Logic operators go to both groups.
                                $review_group['fields'][]  = $field;
                                $product_group['fields'][] = $field;
                            }
                        }

                        if ( ! empty( $review_group['fields'] ) ) {
                            $review_filters[ $type ][] = $review_group;
                        }
                        if ( ! empty( $product_group['fields'] ) ) {
                            $product_filters[ $type ][] = $product_group;
                        }
                    }
                }
            }
        }

        // Apply product-level filters (if any).
        if ( ! empty( $product_filters['include'] ) || ! empty( $product_filters['exclude'] ) ) {
            $include_result = $filters_instance->process_include_groups( $data, $product_filters['include'], $feed );
            $exclude_result = $filters_instance->process_exclude_groups( $data, $product_filters['exclude'], $feed );

            $product_passed = $include_result && ! $exclude_result;
            if ( ! $product_passed ) {
                $data = array(); // Product doesn't pass, return empty.
                return apply_filters( 'adt_pfp_filter_product_feed_data', $data, $filters, $feed );
            }
        }

        // Then apply review-level filters.
        if ( ! empty( $review_filters['include'] ) || ! empty( $review_filters['exclude'] ) ) {
            $reviews          = $data['reviews'] ?? array();
            $filtered_reviews = array();

            foreach ( $reviews as $review ) {
                // Merge review data into product data temporarily for filtering.
                $review_data = array_merge( $data, $review );

                $include_result = $filters_instance->process_include_groups( $review_data, $review_filters['include'], $feed );
                $exclude_result = $filters_instance->process_exclude_groups( $review_data, $review_filters['exclude'], $feed );

                $review_passed = $include_result && ! $exclude_result;
                if ( $review_passed ) {
                    $filtered_reviews[] = $review;
                }
            }

            $data['reviews'] = $filtered_reviews;
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
     * Process rules for Google Product Review feeds.
     *
     * This handles both the IF (conditions) and THEN (actions) parts of rules.
     *
     * @since 13.4.6
     * @access public
     *
     * @param array        $data The data to filter.
     * @param array        $rules The rules to process.
     * @param Product_Feed $feed The feed object.
     * @return array
     */
    public function process_google_review_rules( $data, $rules, $feed ) {
        // Get the rules instance.
        $rules_instance = Rules::instance();

        // Process each rule.
        foreach ( $rules as $rule ) {
            if ( ! isset( $rule['if'] ) || ! isset( $rule['then'] ) ) {
                continue;
            }

            // Separate review conditions from product conditions.
            $review_conditions      = array();
            $product_conditions     = array();
            $has_review_conditions  = false;
            $has_product_conditions = false;

            // Analyze the conditions to see what type they are.
            foreach ( $rule['if'] as $condition ) {
                if ( 'group' === ( $condition['type'] ?? '' ) ) {
                    if ( $this->group_has_review_attributes( $condition ) ) {
                        $has_review_conditions = true;
                        $review_conditions[]   = $condition;
                    } else {
                        $has_product_conditions = true;
                        $product_conditions[]   = $condition;
                    }
                } else {
                    // Logic operators apply to both.
                    $review_conditions[]  = $condition;
                    $product_conditions[] = $condition;
                }
            }

            // Handle different scenarios.
            if ( $has_review_conditions && ! $has_product_conditions ) {
                // Pure review rule - apply to individual reviews.
                $data = $this->apply_review_rule( $data, $rule, $rules_instance );
            } elseif ( ! $has_review_conditions && $has_product_conditions ) {
                // Pure product rule - use normal rule processing.
                if ( $rules_instance->evaluate_rule_conditions( $rule['if'], $data ) ) {
                    $data = $this->process_google_review_rules_actions( $data, $rule['then'], $feed );
                }
            } else { // phpcs:ignore
                // Mixed rule - apply to reviews only if product conditions are met.
                if ( ! empty( $product_conditions ) && $rules_instance->evaluate_rule_conditions( $product_conditions, $data ) ) {
                    $data = $this->apply_review_rule_with_conditions( $data, $review_conditions, $rule['then'], $rules_instance );
                }
            }
        }

        return $data;
    }

    /**
     * Process rules actions for Google Product Review feeds.
     *
     * For review attributes, we need to apply the action to each review.
     * For other attributes, we need to apply the action to the product same as the Rules class implementation.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array        $data The data to filter.
     * @param array        $actions The actions to apply.
     * @param Product_Feed $feed The feed object.
     * @return array
     */
    public function process_google_review_rules_actions( $data, $actions, $feed ) {
        // Get the rules instance.
        $rules_instance = Rules::instance();

        foreach ( $actions as $action ) {
            if ( in_array( $action['attribute'], $this->review_attributes, true ) ) {
                foreach ( $data['reviews'] as $index => $review ) {
                    $data['reviews'][ $index ] = $rules_instance->process_action( $review, $action );
                }
            } else {
                $data = $rules_instance->process_action( $data, $action );
            }
        }

        return $data;
    }

    /**
     * Check if a group has review attributes.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $group The group data.
     * @return bool
     */
    private function group_has_review_attributes( $group ) {
        foreach ( $group['fields'] ?? array() as $field ) {
            if ( 'field' === ( $field['type'] ?? '' ) && isset( $field['data']['attribute'] ) ) {
                if ( in_array( $field['data']['attribute'], $this->review_attributes, true ) ) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Apply a rule to individual reviews.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $data The product data.
     * @param array $rule The rule to apply.
     * @param Rules $rules_instance The rules instance.
     * @return array
     */
    private function apply_review_rule( $data, $rule, $rules_instance ) {
        $reviews          = $data['reviews'] ?? array();
        $filtered_reviews = array();

        foreach ( $reviews as $review ) {
            // Merge review data into product data temporarily.
            $review_data = array_merge( $data, $review );

            // Evaluate conditions against the merged data.
            if ( $rules_instance->evaluate_rule_conditions( $rule['if'], $review_data ) ) {
                // Apply actions to the review.
                foreach ( $rule['then'] as $action ) {
                    if ( in_array( $action['attribute'], $this->review_attributes, true ) ) {
                        $review = $rules_instance->process_action( $review, $action );
                    }
                }
            }

            $filtered_reviews[] = $review;
        }

        $data['reviews'] = $filtered_reviews;
        return $data;
    }

    /**
     * Apply a rule to reviews with specific conditions.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $data The product data.
     * @param array $review_conditions The review conditions.
     * @param array $actions The actions to apply.
     * @param Rules $rules_instance The rules instance.
     * @return array
     */
    private function apply_review_rule_with_conditions( $data, $review_conditions, $actions, $rules_instance ) {
        $reviews          = $data['reviews'] ?? array();
        $filtered_reviews = array();

        foreach ( $reviews as $review ) {
            // Merge review data into product data temporarily.
            $review_data = array_merge( $data, $review );

            // Evaluate review conditions against the merged data.
            if ( $rules_instance->evaluate_rule_conditions( $review_conditions, $review_data ) ) {
                // Apply actions to the review.
                foreach ( $actions as $action ) {
                    if ( in_array( $action['attribute'], $this->review_attributes, true ) ) {
                        $review = $rules_instance->process_action( $review, $action );
                    }
                }
            }

            $filtered_reviews[] = $review;
        }

        $data['reviews'] = $filtered_reviews;
        return $data;
    }

    /**
     * Legacy: Maybe skip filter.
     * For google product review, we only want to filter the reviews.
     * Due to the way the filter is applied, we need to skip the filter for other attributes.
     *
     * @since 13.4.5
     *
     * @param bool   $skipped The skipped value.
     * @param array  $filter The filter criteria.
     * @param array  $data The data to filter.
     * @param object $feed The feed.
     * @return bool
     */
    public function maybe_skip_filter( $skipped, $filter, $data, $feed ) {
        if ( $this->feed_type !== $feed->get_channel( 'fields' ) ) {
            return $skipped;
        }

        if ( in_array( $filter['attribute'], $this->review_attributes, true ) ) {
            return true;
        }

        return $skipped;
    }

    /**
     * Legacy: Filter product feed data value.
     *
     * @since 13.4.5
     *
     * @param array        $data The data.
     * @param array        $filters The filters.
     * @param Product_Feed $feed The feed.
     * @return string
     */
    public function filter_product_feed_data_value( $data, $filters, $feed ) {
        if ( empty( $data ) || empty( $filters ) ) {
            return $data;
        }

        $review_data = $data['reviews'] ?? array();
        if ( empty( $review_data ) ) {
            return $data;
        }

        // Get the filters instance.
        $filters_instance = Filters_Legacy::instance();

        foreach ( $filters as $filter ) {
            $filter_attribute = $filter['attribute'] ?? '';
            if ( ! in_array( $filter_attribute, $this->review_attributes, true ) ) {
                continue;
            }

            foreach ( $review_data as $index => $review ) {
                if ( ! isset( $review[ $filter_attribute ] ) ) {
                    continue;
                }

                // Process the filter based on whether the value is an array or not.
                $filter_passed = $filters_instance->process_filter_value( $review[ $filter_attribute ], $filter, $feed );

                // If this filter didn't pass, mark the review as not passing.
                if ( ! $filter_passed ) {
                    unset( $review_data[ $index ] );
                }
            }
        }

        // Update the reviews data after filtering.
        $data['reviews'] = $review_data;

        return $data;
    }

    /**
     * Run the class.
     *
     * @since 13.4.5
     */
    public function run() {
        add_filter( 'adt_pfp_get_filters_rules_attributes', array( $this, 'get_attributes' ), 10, 2 );
        add_filter( 'adt_pfp_maybe_skip_filter', array( $this, 'maybe_skip_filter' ), 10, 4 );
        add_filter( 'adt_pfp_filter_product_feed_data', array( $this, 'filter_product_feed_data_value' ), 10, 3 );
    }
}
