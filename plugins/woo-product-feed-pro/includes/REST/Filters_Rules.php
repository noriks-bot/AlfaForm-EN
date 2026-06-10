<?php

namespace AdTribes\PFP\REST;

use AdTribes\PFP\Abstracts\Abstract_REST;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Classes\Product_Feed_Attributes;
use AdTribes\PFP\Classes\Rules;
use AdTribes\PFP\Classes\Filters;
use WP_REST_Response;
use WP_REST_Server;
use WP_REST_Request;

/**
 * Class Filters_Rules
 *
 * This class creates REST API endpoints for the filters and rules builder.
 */
class Filters_Rules extends Abstract_REST {

    use Singleton_Trait;

    /**
     * The rules instance.
     *
     * @var Rules
     */
    protected $rules;

    /**
     * The filters instance.
     *
     * @var Filters
     */
    protected $filters;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->filters = Filters::instance();
        $this->rules   = Rules::instance();
    }

    /**
     * Register the routes.
     */
    public function register_routes() {
        $this->rest_base = 'filters-rules';

        // Get filters and rules for a specific feed.
        register_rest_route(
            $this->namespace,
            "/$this->rest_base/(?P<feed_id>[\w-]+)",
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_filters_rules' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
            )
        );
    }

    /**
     * Get available attributes for filters and rules.
     *
     * @since 13.4.6
     * @access private
     *
     * @param Product_Feed $feed The feed object.
     * @param string       $type The type of data to get.
     *                           'filters' for filters and rules builder.
     *                           'rules' for rules builder.
     *                           'rules_then' for then attributes builder.
     * @return array
     */
    private function get_attributes( $feed = null, $type = 'filters' ) {
        // Get the Product_Feed_Attributes instance.
        $product_feed_attributes = Product_Feed_Attributes::instance();
        $attributes              = $product_feed_attributes->get_attributes();
        $feed_channel            = $feed ? $feed->get_channel( 'fields' ) : null;

        if ( 'filters' === $type || 'rules' === $type ) {
            // Exclude attributes for filter and rules conditions builder.
            $attributes_to_exclude = array(
                'Other fields' => array(
                    'static_value',
                    'page_url',
                    'post_url',
                ),
            );

            foreach ( $attributes_to_exclude as $group_name => $group_attributes ) {
                foreach ( $group_attributes as $attribute ) {
                    unset( $attributes[ $group_name ][ $attribute ] );
                }
            }
        }

        $attributes = apply_filters( 'adt_pfp_get_filters_rules_attributes', $attributes, $feed_channel, $type );

        // Transform the attributes to match the expected format.
        $formatted_attributes = array();

        foreach ( $attributes as $group_name => $group_attributes ) {
            $formatted_group = array();

            foreach ( $group_attributes as $attr_key => $attr_name ) {
                $formatted_group[ $attr_key ] = $attr_name;
            }

            $formatted_attributes[ $group_name ] = $formatted_group;
        }

        return $formatted_attributes;
    }

    /**
     * Get product categories for dropdown (used when attribute is categories/raw_categories).
     *
     * @since 13.4.6
     * @access private
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    private function get_categories( $request ) {
        $feed_id = $request->get_param( 'feed_id' );

        if ( ! $feed_id ) {
            return new WP_REST_Response( array( 'error' => __( 'Feed ID is required', 'woo-product-feed-pro' ) ), 400 );
        }

        $categories_data = $this->get_categories_data( $feed_id );
        return new WP_REST_Response( $categories_data, 200 );
    }

    /**
     * Get categories data for a feed.
     *
     * @since 13.4.6
     * @access private
     *
     * @param string $feed_id The feed ID.
     * @return array The formatted categories data.
     */
    private function get_categories_data( $feed_id ) {
        // For new feeds, use null as feed_id for filters.
        $filter_feed_id = ( 'new' === $feed_id ) ? null : $feed_id;

        /**
         * Filter the arguments for the product categories dropdown.
         * This preserves the same filter hook used in the legacy implementation.
         *
         * @since 13.3.4
         *
         * @param array $cat_args The arguments for the product categories dropdown.
         * @param int   $feed_id  The feed ID.
         * @return array The arguments for the product categories dropdown.
         */
        $cat_args = apply_filters(
            'adt_pfp_get_categories_dropdown_args',
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => 'false',
            ),
            $filter_feed_id
        );

        /**
         * Filter the product categories for the product categories dropdown.
         * This preserves the same filter hook used in the legacy implementation.
         *
         * @since 13.3.4
         *
         * @param array $product_categories The product categories for the product categories dropdown.
         * @param array $cat_args           The arguments for the product categories dropdown.
         * @param int   $feed_id            The feed ID.
         * @return array The product categories for the product categories dropdown.
         */
        $product_categories = apply_filters( 'adt_pfp_get_categories_dropdown', get_terms( $cat_args ), $cat_args, $filter_feed_id );

        // Format categories for the frontend.
        $formatted_categories = array();

        if ( ! is_wp_error( $product_categories ) && ! empty( $product_categories ) ) {
            foreach ( $product_categories as $category ) {
                $formatted_categories[] = array(
                    'value' => $category->slug,
                    'label' => $category->name . ' (' . $category->slug . ')',
                    'name'  => $category->name,
                    'slug'  => $category->slug,
                );
            }
        }

        return $formatted_categories;
    }

    /**
     * Get filters and rules for a specific feed.
     *
     * @since 13.4.6
     * @access public
     *
     * @param WP_REST_Request $request Request object.
     * @return WP_REST_Response
     */
    public function get_filters_rules( $request ) {
        $feed_id = $request->get_param( 'feed_id' );
        $type    = $request->get_param( 'type' );

        if ( ! $feed_id ) {
            return new WP_REST_Response( array( 'error' => __( 'Feed ID is required', 'woo-product-feed-pro' ) ), 400 );
        }

        // Handle new feed case.
        if ( 'new' === $feed_id ) {
            $feed = null;
            // Get temporary product feed data for new feeds.
            $temp_feed_data = get_option( ADT_OPTION_TEMP_PRODUCT_FEED, array() );
        } else {
            $feed = Product_Feed_Helper::get_product_feed( $feed_id );

            if ( ! $feed ) {
                return new WP_REST_Response( array( 'error' => __( 'Feed not found', 'woo-product-feed-pro' ) ), 404 );
            }
            $temp_feed_data = array();
        }

        $response_data = array();

        // Check if the feed needs a migration, skip migration for new feeds.
        if ( 'new' !== $feed_id ) {
            $migration_ran = $this->maybe_run_migration( $feed, $type );
            if ( $migration_ran ) {
                $response_data['migration_ran'] = true;
            }
        }

        // Get attributes, conditions, and categories for the builder.
        $response_data['attributes'] = $this->get_attributes( $feed, $type );
        $response_data['categories'] = $this->get_categories_data( $feed_id );

        // Get conditions and actions for the builder.
        if ( 'filters' === $type ) {
            $response_data['conditions'] = $this->filters->get_conditions();
        } else {
            $response_data['conditions'] = $this->rules->get_conditions();
        }

        // Default empty data for new feeds.
        $default_filters = array(
            'include' => array(),
            'exclude' => array(),
        );
        $default_rules   = array( 'rules' => array() );

        if ( 'rules' === $type ) {
            $response_data['actions']       = $this->rules->get_actions();
            $response_data['field_mapping'] = $feed ? $feed->attributes : array();

            // Get then attributes for rules builder.
            $response_data['thenAttributes'] = $this->get_attributes( $feed, 'rules_then' );

            if ( $feed ) {
                // Existing feed - get from feed data.
                $response_data['rules'] = $feed->feed_rules ?? $default_rules;
            } else {
                // New feed - get from temporary feed data.
                $response_data['rules'] = $temp_feed_data['feed_rules'] ?? $default_rules;
            }
        } elseif ( 'filters' === $type ) {
            if ( $feed ) {
                // Existing feed - get from feed data.
                $response_data['filters'] = $feed->feed_filters ?? $default_filters;
            } else {
                // New feed - get from temporary feed data.
                $response_data['filters'] = $temp_feed_data['feed_filters'] ?? $default_filters;
            }
        }

        return new WP_REST_Response( $response_data, 200 );
    }

    /**
     * Check if the feed needs a migration.
     *
     * @since 13.4.6
     * @access private
     *
     * @param Product_Feed $feed The feed object.
     * @param string       $type The type of data to check.
     * @return bool True if migration is needed, false otherwise.
     */
    private function maybe_run_migration( $feed, $type ) {
        if ( ! $feed ) {
            return false;
        }

        if ( 'filters' === $type ) {
            return $this->migrate_filters( $feed );
        } elseif ( 'rules' === $type ) {
            return $this->migrate_rules( $feed );
        }
    }

    /**
     * Migrate filters from old format to new format.
     *
     * @since 13.4.6
     * @access private
     *
     * @param Product_Feed $feed The feed object.
     * @return bool True if migration is needed, false otherwise.
     */
    private function migrate_filters( $feed ) {
        $migrated     = false;
        $data_version = $feed->data_version;
        if ( ! empty( $data_version['feed_filters'] ) && version_compare( $data_version['feed_filters'], '13.4.6', '>=' ) ) {
            return false;
        }

        $data_version['feed_filters'] = '13.4.6';
        $feed->data_version           = $data_version;

        // Check if old format exists and has data.
        $old_filters = $feed->filters ?? array();
        if ( empty( $old_filters ) || ! is_array( $old_filters ) ) {
            // No old data to migrate.
            $migrated = false;
        } else {
            // Migrate the data.
            $migrated_filters = $this->transform_old_filters_to_new( $old_filters );

            // Update the feed object for current request.
            $feed->feed_filters = $migrated_filters;
            $migrated           = true;
        }

        $feed->save();
        return $migrated;
    }

    /**
     * Migrate rules from old format to new format.
     *
     * @since 13.4.6
     * @access private
     *
     * @param object $feed The feed object.
     * @return bool True if migration is needed, false otherwise.
     */
    private function migrate_rules( $feed ) {
        $migrated     = false;
        $data_version = $feed->data_version;
        if ( ! empty( $data_version['feed_rules'] ) && version_compare( $data_version['feed_rules'], '13.4.6', '>=' ) ) {
            return false;
        }

        $data_version['feed_rules'] = '13.4.6';
        $feed->data_version         = $data_version;

        // Check if old format exists and has data.
        $old_rules = $feed->rules ?? array();
        if ( empty( $old_rules ) || ! is_array( $old_rules ) ) {
            // No old data to migrate.
            $migrated = false;
        } else {
            // Migrate the data.
            $migrated_rules = $this->transform_old_rules_to_new( $old_rules );

            // Update the feed object for current request.
            $feed->feed_rules = $migrated_rules;
            $migrated         = true;
        }

        $feed->save();
        return $migrated;
    }

    /**
     * Transform old filters format to new format.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $old_filters The old filters data.
     * @return array The new filters format.
     */
    private function transform_old_filters_to_new( $old_filters ) {
        $new_filters = array(
            'include' => array(),
            'exclude' => array(),
        );

        // Group old filters by the 'than' field.
        $include_filters = array();
        $exclude_filters = array();

        foreach ( $old_filters as $row_count => $filter ) {
            if ( ! is_array( $filter ) ) {
                continue;
            }

            // Check if this is a valid filter with required fields.
            if ( ! isset( $filter['attribute'], $filter['condition'], $filter['criteria'], $filter['than'] ) ) {
                continue;
            }

            $transformed_filter = array(
                'attribute'      => $filter['attribute'],
                'condition'      => $this->map_old_condition_to_new( $filter['condition'] ),
                'value'          => $filter['criteria'],
                'case_sensitive' => isset( $filter['cs'] ) && 'on' === $filter['cs'] ? true : false,
            );

            // Group by the 'than' field.
            if ( 'include_only' === $filter['than'] ) {
                $include_filters[] = $transformed_filter;
            } elseif ( 'exclude' === $filter['than'] ) {
                $exclude_filters[] = $transformed_filter;
            }
        }

        // Transform include filters to new schema.
        if ( ! empty( $include_filters ) ) {
            $new_filters['include'] = $this->build_group( $include_filters );
        }

        // Transform exclude filters to new schema.
        if ( ! empty( $exclude_filters ) ) {
            $new_filters['exclude'] = $this->build_exclude_groups( $exclude_filters );
        }

        return $new_filters;
    }

    /**
     * Build separate groups for exclude filters with OR logic.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $exclude_filters Array of exclude filter data.
     * @return array The groups structure with OR logic.
     */
    private function build_exclude_groups( $exclude_filters ) {
        if ( empty( $exclude_filters ) ) {
            return array();
        }

        $groups       = array();
        $filter_count = count( $exclude_filters );

        foreach ( $exclude_filters as $index => $filter ) {
            if ( empty( $filter['attribute'] ) || empty( $filter['value'] ) ) {
                continue;
            }

            // Build the data array for the filter.
            $data = array(
                'attribute'      => $filter['attribute'],
                'condition'      => $filter['condition'] ?? 'contains',
                'value'          => $filter['value'],
                'case_sensitive' => $filter['case_sensitive'] ?? false,
            );

            // Create a separate group for each exclude filter.
            $groups[] = array(
                'type'   => 'group',
                'fields' => array(
                    array(
                        'type' => 'field',
                        'data' => $data,
                    ),
                ),
            );

            // Add group logic operator between groups (except after the last group).
            if ( $index < $filter_count - 1 ) {
                $groups[] = array(
                    'type'  => 'group_logic',
                    'value' => 'or',
                );
            }
        }

        return $groups;
    }

    /**
     * Build group with fields and logic operators.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $items Array of item data (filters or rules).
     * @return array The group structure.
     */
    private function build_group( $items ) {
        if ( empty( $items ) ) {
            return array();
        }

        $fields     = array();
        $item_count = count( $items );

        foreach ( $items as $index => $item ) {
            if ( empty( $item['attribute'] ) || empty( $item['value'] ) ) {
                continue;
            }

            // Build the data array based on type.
            $data = array(
                'attribute' => $item['attribute'],
                'value'     => $item['value'],
            );

            // Add type-specific fields.
            $data['condition']      = $item['condition'] ?? 'contains';
            $data['case_sensitive'] = $item['case_sensitive'] ?? false;

            // Add the field.
            $fields[] = array(
                'type' => 'field',
                'data' => $data,
            );

            // Add logic operator between fields (except after the last field).
            if ( $index < $item_count - 1 ) {
                $fields[] = array(
                    'type' => 'logic',
                    'data' => 'and',
                );
            }
        }

        return array(
            array(
                'type'   => 'group',
                'fields' => $fields,
            ),
        );
    }

    /**
     * Map old condition format to new condition format.
     *
     * @since 13.4.6
     * @access private
     *
     * @param string $old_condition The old condition value.
     * @return string The new condition value.
     */
    private function map_old_condition_to_new( $old_condition ) {
        $condition_mapping = array(
            'contains'    => 'contains',
            'containsnot' => 'not_contains',
            '='           => 'equals',
            '!='          => 'not_equals',
            '>'           => 'greater_than',
            '>='          => 'greater_than_or_equal',
            '<'           => 'less_than',
            '<='          => 'less_than_or_equal',
            '=<'          => 'less_than_or_equal', // Backward compatibility.
            'empty'       => 'is_empty',
            'notempty'    => 'is_not_empty',
        );

        return isset( $condition_mapping[ $old_condition ] ) ? $condition_mapping[ $old_condition ] : 'contains';
    }

    /**
     * Transform old rules format to new format.
     *
     * @since 13.4.6
     * @access private
     *
     * @param array $old_rules The old rules data.
     * @return array The new rules format.
     */
    private function transform_old_rules_to_new( $old_rules ) {
        $new_rules = array();

        // Group rules by the same attribute, condition, and criteria.
        $grouped_rules = array();

        $calculation_rules = array(
            'multiply',
            'divide',
            'plus',
            'minus',
            'findreplace',
        );

        foreach ( $old_rules as $row_count => $rule ) {
            if ( ! is_array( $rule ) ) {
                continue;
            }

            // Check if this is a valid rule with required fields.
            if ( ! isset( $rule['attribute'], $rule['condition'], $rule['criteria'], $rule['than_attribute'], $rule['newvalue'] ) ) {
                continue;
            }

            if ( in_array( $rule['condition'], $calculation_rules, true ) ) {
                $group_key = 0;

                if ( ! isset( $grouped_rules[ $group_key ] ) ) {
                    $grouped_rules[ $group_key ] = array(
                        'if'   => array(),
                        'then' => array(),
                    );
                }

                if ( 'findreplace' === $rule['condition'] ) {
                    $grouped_rules[ $group_key ]['then'][] = array(
                        'attribute' => $rule['attribute'],
                        'action'    => $rule['condition'] ?? 'set_value',
                        'value'     => $rule['newvalue'],
                        'find'      => $rule['criteria'],
                    );
                } else {
                    $grouped_rules[ $group_key ]['then'][] = array(
                        'attribute' => $rule['attribute'],
                        'action'    => $rule['condition'] ?? 'set_value',
                        'value'     => $rule['criteria'],
                        'find'      => '',
                    );
                }
            } else {
                $group_key = $rule['attribute'] . '|' . $rule['condition'] . '|' . $rule['criteria'];
                $group_key = md5( $group_key );

                if ( ! isset( $grouped_rules[ $group_key ] ) ) {
                    $grouped_rules[ $group_key ] = array(
                        'if'   => array(
                            'attribute' => $rule['attribute'],
                            'condition' => $this->map_old_condition_to_new( $rule['condition'] ),
                            'value'     => $rule['criteria'],
                        ),
                        'then' => array(),
                    );
                }

                // Add the action to the 'then' array.
                $grouped_rules[ $group_key ]['then'][] = array(
                    'attribute' => $rule['than_attribute'],
                    'action'    => 'set_value',
                    'value'     => $rule['newvalue'],
                    'find'      => '',
                );
            }

            // Create a unique key for grouping based on attribute, condition, and criteria.
        }

        // Transform grouped rules to new schema.
        foreach ( $grouped_rules as $group_key => $grouped_rule ) {
            $new_rule = array(
                'if'   => $this->build_group( array( $grouped_rule['if'] ) ),
                'then' => $grouped_rule['then'],
            );

            $new_rules[] = $new_rule;
        }

        return $new_rules;
    }
}
