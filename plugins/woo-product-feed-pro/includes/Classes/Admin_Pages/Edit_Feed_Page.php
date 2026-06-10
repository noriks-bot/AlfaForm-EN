<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes\Admin_Pages
 */

namespace AdTribes\PFP\Classes\Admin_Pages;

use AdTribes\PFP\Abstracts\Admin_Page;
use AdTribes\PFP\Factories\Vite_App;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Sanitization;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Classes\Google_Product_Taxonomy_Fetcher;
use AdTribes\PFP\Classes\Admin_Pages\Manage_Feeds_Page;
use AdTribes\PFP\Classes\Rules;
use AdTribes\PFP\Classes\Filters;
use AdTribes\PFP\Classes\Upsell;
use AdTribes\PFP\Factories\Admin_Notice;

/**
 * Edit_Feed_Page class.
 *
 * @since 13.4.4
 */
class Edit_Feed_Page extends Admin_Page {

    use Singleton_Trait;

    const MENU_SLUG = 'adt-edit-feed';

    /**
     * Holds the class instance object.
     *
     * @since 13.4.4
     * @var Edit_Feed_Page $instance
     */
    protected static $instance;

    /**
     * Holds the tabs.
     *
     * @since 13.4.4
     * @var array
     */
    protected $tabs;

    /**
     * Initialize the class.
     *
     * @since 13.4.4
     */
    public function init() {
        $this->parent_slug = 'woo-product-feed';
        $this->page_title  = __( 'Feed configuration', 'woo-product-feed-pro' );
        $this->menu_title  = __( 'Create feed', 'woo-product-feed-pro' );
        $this->capability  = apply_filters( 'adt_pfp_admin_capability', 'manage_options' );
        $this->menu_slug   = self::MENU_SLUG;
        $this->template    = 'edit-feed/edit-feed.php';
        $this->position    = 20;
        $this->tabs        = $this->get_tabs();
    }

    /**
     * Get the admin menu priority.
     *
     * @since 13.4.4
     * @return int
     */
    protected function get_priority() {
        return 20;
    }

    /**
     * Enqueue scripts.
     *
     * @since 13.4.4
     */
    public function enqueue_scripts() {
        $tab     = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'general'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $feed_id = isset( $_GET['id'] ) ? sanitize_text_field( wp_unslash( $_GET['id'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

        // Load Google Taxonomy JS.
        switch ( $tab ) {
            case 'category_mapping':
                $google_taxonomy_fetcher = Google_Product_Taxonomy_Fetcher::instance();

                // Typeahead JS.
                wp_enqueue_script( 'pfp-typeahead-js', ADT_PFP_JS_URL . 'lib/typeahead.bundle.js', '', WOOCOMMERCESEA_PLUGIN_VERSION, true );

                wp_enqueue_script( 'pfp-google-taxonomy-js', ADT_PFP_JS_URL . 'pfp-google-taxonomy.js', array( 'jquery' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
                wp_localize_script(
                    'pfp-google-taxonomy-js',
                    'pfp_google_taxonomy',
                    array(
                        'file_name' => $google_taxonomy_fetcher::GOOGLE_PRODUCT_TAXONOMY_FILE_NAME,
                        'file_path' => $google_taxonomy_fetcher::GOOGLE_PRODUCT_TAXONOMY_FILE_PATH,
                        'file_url'  => $google_taxonomy_fetcher::GOOGLE_PRODUCT_TAXONOMY_FILE_URL,
                    )
                );
                break;
            case 'filters':
            case 'rules':
                if ( 'yes' === get_option( 'adt_use_legacy_filters_and_rules', 'no' ) ) {
                    break;
                }

                $l10n = array(
                    'restUrl'       => get_rest_url(),
                    'wpNonce'       => wp_create_nonce( 'wp_rest' ),
                    'isEliteActive' => Helper::has_paid_plugin_active(),
                );

                $vite_app = new Vite_App(
                    'adt-filters-rules-builder-script',
                    'src/apps/filters-rules-builder/index.ts',
                    array( 'jquery', 'wp-i18n' ),
                    $l10n,
                    'adtObj',
                    array()
                );
                $vite_app->enqueue();
                break;
        }

        $l10n = Helper::vite_app_common_l10n(
            array(
                'adtNonce'   => wp_create_nonce( 'adt_nonce' ),
                'upsellL10n' => Upsell::instance()->upsell_l10n(),
                'feed_id'    => $feed_id,
                'feed_data'  => array(),
            )
        );

        // Get the feed data if it's editing an existing feed.
        if ( $feed_id > 0 ) {
            $feed = Product_Feed_Helper::get_product_feed( $feed_id );

            // Product_Feed extended from WP_Post object to usable array for JS.
            $l10n['feed_data'] = $feed->data;
        }

        $app = new Vite_App(
            'adt-edit-feed-script',
            'src/vanilla/edit-feed/index.ts',
            array( 'jquery', 'wp-i18n', Helper::get_wc_script_handle( 'select2' ) ),
            $l10n,
            'adtObj',
            array()
        );
        $app->enqueue();
    }

    /**
     * Get the tabs.
     *
     * @since 13.4.4
     * @param object|array|null $feed The feed object.
     * @return array
     */
    public function get_tabs( $feed = null ) {
        $tabs = apply_filters(
            'adt_edit_feed_tabs',
            array(
                'general'              => __( 'General', 'woo-product-feed-pro' ),
                'field_mapping'        => __( 'Field Mapping', 'woo-product-feed-pro' ),
                'category_mapping'     => __( 'Category Mapping', 'woo-product-feed-pro' ),
                'filters_rules'        => __( 'Filters & Rules', 'woo-product-feed-pro' ),
                'filters'              => __( 'Filters', 'woo-product-feed-pro' ),
                'rules'                => __( 'Rules', 'woo-product-feed-pro' ),
                'conversion_analytics' => __( 'Conversion & Google Analytics', 'woo-product-feed-pro' ),
            )
        );

        // Remove filters and rules tabs if legacy filters and rules are enabled.
        if ( 'yes' === get_option( 'adt_use_legacy_filters_and_rules', 'no' ) ) {
            unset( $tabs['filters'] );
            unset( $tabs['rules'] );
        } else {
            unset( $tabs['filters_rules'] );
        }

        // By default, include the category mapping tab.
        $show_category_mapping = false;

        $feed_id = $feed->id ?? 0;
        if ( $feed_id > 0 ) {
            $channel               = $feed->get_channel();
            $show_category_mapping = isset( $channel['taxonomy'] ) && 'none' !== $channel['taxonomy'];
        } elseif ( is_array( $feed ) && isset( $feed['channel_hash'] ) ) { // Check if channel has taxonomy.
            $channel               = Product_Feed_Helper::get_channel_from_legacy_channel_hash( $feed['channel_hash'] );
            $show_category_mapping = isset( $channel['taxonomy'] ) && 'none' !== $channel['taxonomy'];
        }

        // Remove category mapping if not applicable.
        if ( ! $show_category_mapping ) {
            unset( $tabs['category_mapping'] );
        }

        /**
         * Filter the tabs.
         *
         * @since 13.4.4
         * @param array $tabs The tabs.
         * @param object $feed The feed object.
         * @return array
         */
        return apply_filters( 'adt_edit_feed_get_tabs', $tabs, $feed );
    }

    /**
     * Get the tab URL.
     *
     * @since 13.4.4
     * @param string $tab The tab.
     * @return string
     */
    public static function get_tab_url( $tab ) {
        $args = array(
            'page' => self::MENU_SLUG,
            'tab'  => $tab,
        );

        // Preserve id if it exists in the URL.
        if ( isset( $_GET['id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $args['id'] = intval( $_GET['id'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        }

        return esc_url( add_query_arg( $args, admin_url( 'admin.php' ) ) );
    }

    /**
     * Get the tab content.
     *
     * @since 13.4.4
     * @param string $tab The tab.
     * @return string
     */
    public function get_tab_content( $tab ) {
        ob_start();

        $tab = '' === $tab ? 'general' : $tab;

        switch ( $tab ) {
            case 'general':
                Helper::locate_admin_template( 'edit-feed/tabs/general-tab.php', true );
                break;
            case 'field_mapping':
                Helper::locate_admin_template( 'edit-feed/tabs/field-mapping-tab.php', true );
                break;
            case 'category_mapping':
                Helper::locate_admin_template( 'edit-feed/tabs/category-mapping-tab.php', true );
                break;
            case 'filters_rules':
                Helper::locate_admin_template( 'edit-feed/tabs/filters-rules-tab.php', true );
                break;
            case 'filters':
                Helper::locate_admin_template( 'edit-feed/tabs/filters-tab.php', true );
                break;
            case 'rules':
                Helper::locate_admin_template( 'edit-feed/tabs/rules-tab.php', true );
                break;
            case 'conversion_analytics':
                Helper::locate_admin_template( 'edit-feed/tabs/conversion-analytics-tab.php', true );
                break;
        }

        do_action( 'adt_edit_feed_tab_content', $tab );

        return ob_get_clean();
    }

    /**
     * Update project configuration.
     *
     * @since 13.3.6
     * @access private
     *
     * @param array $form_data The form data.
     * @param bool  $clear     Clear the temp product feed.
     *
     * @return array
     */
    public function update_temp_product_feed( $form_data, $clear = false ) {
        // Sanitize the form data.
        $form_data = Helper::array_walk_recursive_with_callback( $form_data, array( Sanitization::class, 'sanitize_text_field' ) );

        /**
         * If the the legacy filters and rules are not enabled, clean the filters and rules data.
         * This is to ensure that the data version is set to 13.4.6.
         *
         * The funny thing is in the legacy filters and rules, filters is called 'rules' and rules is called 'rules2'.
         * But don't get confused, the new filters and rules builder is submitting the data as 'filters' and 'rules'.
         */
        if ( 'no' === get_option( 'adt_use_legacy_filters_and_rules', 'no' ) ) {
            // Clean filters data if it exists.
            if ( isset( $form_data['filters'] ) ) {
                $decoded_filters           = $this->decode_json_data( $form_data['filters'] );
                $form_data['feed_filters'] = $this->clean_filters_data( $decoded_filters );
            }

            // Clean rules data if it exists.
            if ( isset( $form_data['rules'] ) ) {
                $decoded_rules           = $this->decode_json_data( $form_data['rules'] );
                $form_data['feed_rules'] = $this->clean_rules_data( $decoded_rules );
            }
        }

        $project_temp     = get_option( ADT_OPTION_TEMP_PRODUCT_FEED, array() );
        $new_project_hash = empty( $form_data['project_hash'] ) ? Product_Feed_Helper::generate_legacy_project_hash() : '';

        // If the project hash is empty, then we need to generate a new one.
        if ( empty( $form_data['project_hash'] ) ) {
            $form_data['project_hash'] = $new_project_hash;
        }

        if ( isset( $project_temp['channel_hash'] ) && isset( $form_data['channel_hash'] ) && $project_temp['channel_hash'] !== $form_data['channel_hash'] ) {
            $form_data['attributes'] = array();
        }

        // Merge the form data with the project temp values.
        $project_temp = array_merge( $project_temp, $form_data );

        // Clear the temp product feed.
        if ( $clear ) {
            delete_option( ADT_OPTION_TEMP_PRODUCT_FEED );
        } else {
            update_option( ADT_OPTION_TEMP_PRODUCT_FEED, $project_temp, false );
        }

        // Update the project temp.

        return apply_filters( 'adt_update_temp_product_feed', $project_temp, $form_data, $new_project_hash );
    }

    /**
     * Decode JSON data and sanitize it.
     *
     * @since 13.4.4
     * @param string|array $json_data The JSON data to decode.
     * @return array The decoded data.
     */
    private function decode_json_data( $json_data ) {
        // Handle JSON string input.
        if ( is_string( $json_data ) ) {
            $json_data = wp_unslash( $json_data );

            if ( empty( $json_data ) ) {
                return array();
            }

            $decoded_data = json_decode( $json_data, true );
            if ( json_last_error() === JSON_ERROR_NONE && is_array( $decoded_data ) ) {
                return $decoded_data;
            } else {
                return array();
            }
        }

        return array();
    }

    /**
     * Clean filters data to remove invalid keys and sanitize all input.
     *
     * @since 13.4.4
     * @param array $filters_data The filters data to clean.
     * @return array The cleaned filters data.
     */
    private function clean_filters_data( $filters_data ) {
        if ( ! is_array( $filters_data ) ) {
            return array();
        }

        // First, sanitize the entire array structure using Helper method.
        $filters_data = Sanitization::sanitize_array(
            $filters_data,
            array( 'allow_html' => true )
        );

        $cleaned_data     = array();
        $valid_conditions = Filters::instance()->get_conditions( true );

        foreach ( $filters_data as $section_type => $section_data ) {
            // Validate section type - only allow 'include' or 'exclude'.
            if ( ! in_array( $section_type, array( 'include', 'exclude' ), true ) ) {
                continue;
            }

            if ( ! is_array( $section_data ) ) {
                continue;
            }

            $cleaned_section = array();

            // More aggressive cleaning - only keep numeric keys and filter out everything else.
            foreach ( $section_data as $key => $value ) {
                // ONLY allow numeric keys (group indexes) - completely skip any string keys.
                if ( ! is_numeric( $key ) ) {
                    continue;
                }

                if ( ! is_array( $value ) ) {
                    continue;
                }

                // Process group data.
                $cleaned_group = $this->process_filter_group( $value, $valid_conditions );
                if ( ! empty( $cleaned_group ) ) {
                    $cleaned_section[] = $cleaned_group;
                }
            }

            // The cleaned section is already re-indexed since we used [] to append.
            $cleaned_data[ $section_type ] = $this->remove_orphaned_group_logic( $cleaned_section );
        }

        return $cleaned_data;
    }

    /**
     * Process filter group data with validation and normalization.
     *
     * @since 13.4.4
     * @param array $group_data The group data to process.
     * @param array $valid_conditions Array of valid condition values.
     * @return array The processed group data.
     */
    private function process_filter_group( $group_data, $valid_conditions ) {
        if ( ! isset( $group_data['type'] ) ) {
            return array();
        }

        // Handle group_logic type.
        if ( 'group_logic' === $group_data['type'] ) {
            $value = $group_data['value'] ?? 'and';
            // Only allow 'and' or 'or'.
            if ( ! in_array( $value, array( 'and', 'or' ), true ) ) {
                $value = 'and';
            }
            return array(
                'type'  => 'group_logic',
                'value' => $value,
            );
        }

        // Handle regular group type.
        if ( 'group' === $group_data['type'] && isset( $group_data['fields'] ) && is_array( $group_data['fields'] ) ) {
            $cleaned_fields = array();

            foreach ( $group_data['fields'] as $field ) {
                if ( ! is_array( $field ) || ! isset( $field['type'] ) ) {
                    continue;
                }

                // Handle logic operator.
                if ( 'logic' === $field['type'] ) {
                    $logic_value = $field['data'] ?? 'and';
                    if ( ! in_array( $logic_value, array( 'and', 'or' ), true ) ) {
                        $logic_value = 'and';
                    }
                    $cleaned_fields[] = array(
                        'type' => 'logic',
                        'data' => $logic_value,
                    );
                    continue;
                }

                // Handle filter field.
                if ( isset( $field['data'] ) && is_array( $field['data'] ) ) {
                    $field_data = $field['data'];

                    // Validate condition.
                    $condition = $field_data['condition'] ?? 'contains';
                    if ( ! in_array( $condition, $valid_conditions, true ) ) {
                        $condition = 'contains';
                    }

                    // Handle value based on condition.
                    $value = '';
                    if ( ! in_array( $condition, array( 'empty', 'notempty' ), true ) ) {
                        $value = $field_data['value'] ?? '';
                    }

                    // Normalize case_sensitive to boolean.
                    $case_sensitive = $field_data['case_sensitive'] ?? false;
                    $case_sensitive = in_array( $case_sensitive, array( 'on', '1', 1, true, 'true' ), true );

                    $cleaned_fields[] = array(
                        'type' => $field['type'],
                        'data' => array(
                            'attribute'      => $field['data']['attribute'], // Attribute name (already sanitized by Helper::sanitize_array).
                            'condition'      => $condition,
                            'value'          => $value,
                            'case_sensitive' => $case_sensitive,
                        ),
                    );
                }
            }

            if ( ! empty( $cleaned_fields ) ) {
                return array(
                    'type'   => 'group',
                    'fields' => $cleaned_fields,
                );
            }

            // Return empty array instead of empty group.
            return array();
        }

        // Return empty array instead of empty group.
        return array();
    }

    /**
     * Remove orphaned group_logic entries that don't have a valid group following them.
     *
     * @since 13.4.4
     * @param array $section_data The section data to clean.
     * @return array The cleaned section data.
     */
    private function remove_orphaned_group_logic( $section_data ) {
        if ( empty( $section_data ) ) {
            return $section_data;
        }

        $cleaned_section = array();
        $last_item_type  = '';

        foreach ( $section_data as $item ) {
            $current_type = $item['type'] ?? '';

            // Skip group_logic if:
            // 1. It's the first item (no group before it).
            // 2. The previous item was also group_logic (consecutive logic operators).
            // 3. It's the last item (no group after it) - we'll handle this after the loop.
            if ( 'group_logic' === $current_type && ( empty( $cleaned_section ) || 'group_logic' === $last_item_type ) ) {
                continue;
            }

            $cleaned_section[] = $item;
            $last_item_type    = $current_type;
        }

        // Remove trailing group_logic (group_logic at the end with no group following).
        if ( ! empty( $cleaned_section ) ) {
            $last_item = end( $cleaned_section );
            if ( isset( $last_item['type'] ) && 'group_logic' === $last_item['type'] ) {
                array_pop( $cleaned_section );
            }
        }

        return $cleaned_section;
    }

    /**
     * Clean rules data to remove invalid keys and sanitize all input.
     *
     * @since 13.4.4
     * @param array $rules_data The rules data to clean.
     * @return array The cleaned rules data.
     */
    private function clean_rules_data( $rules_data ) {
        if ( ! is_array( $rules_data ) ) {
            return array();
        }

        // First, sanitize the entire array structure.
        $rules_data = Sanitization::sanitize_array(
            $rules_data,
            array( 'allow_html' => true )
        );

        $cleaned_rules    = array();
        $valid_conditions = Rules::instance()->get_conditions( true );

        $valid_actions = Rules::instance()->get_actions( true );

        // Process each rule.
        foreach ( $rules_data as $rule ) {
            if ( ! is_array( $rule ) || ! isset( $rule['if'] ) || ! isset( $rule['then'] ) ) {
                continue;
            }

            $cleaned_rule = array();

            $cleaned_rule['name'] = $rule['name'] ?? '';

            // Process IF conditions.
            $cleaned_rule['if'] = $this->clean_rule_conditions( $rule['if'], $valid_conditions );

            // Process THEN actions.
            $cleaned_rule['then'] = $this->clean_rule_actions( $rule['then'], $valid_actions );

            $cleaned_rules[] = $cleaned_rule;
        }

        return $cleaned_rules;
    }

    /**
     * Clean rule conditions (IF part).
     *
     * @since 13.4.4
     * @param array $conditions The conditions to clean.
     * @param array $valid_conditions Array of valid condition values.
     * @return array The cleaned conditions.
     */
    private function clean_rule_conditions( $conditions, $valid_conditions ) {
        if ( ! is_array( $conditions ) ) {
            return array();
        }

        $cleaned_conditions = array();

        foreach ( $conditions as $condition ) {
            if ( ! is_array( $condition ) || ! isset( $condition['type'] ) ) {
                continue;
            }

            $type = $condition['type'];

            switch ( $type ) {
                case 'group':
                    $cleaned_group = $this->process_filter_group( $condition, $valid_conditions );
                    if ( ! empty( $cleaned_group ) ) {
                        $cleaned_conditions[] = $cleaned_group;
                    }
                    break;
                case 'group_logic':
                    $value = $condition['value'] ?? 'and';
                    if ( in_array( $value, array( 'and', 'or' ), true ) ) {
                        $cleaned_conditions[] = array(
                            'type'  => 'group_logic',
                            'value' => $value,
                        );
                    }
                    break;
            }
        }

        // Remove orphaned group logic entries.
        return $this->remove_orphaned_group_logic( $cleaned_conditions );
    }

    /**
     * Clean rule actions (THEN part).
     *
     * @since 13.4.4
     * @param array $actions The actions to clean.
     * @param array $valid_actions Array of valid action values.
     * @return array The cleaned actions.
     */
    private function clean_rule_actions( $actions, $valid_actions ) {
        if ( ! is_array( $actions ) ) {
            return array();
        }

        $cleaned_actions = array();

        foreach ( $actions as $action ) {
            if ( ! is_array( $action ) || ! isset( $action['attribute'] ) ) {
                continue;
            }

            $attribute   = $action['attribute'];
            $value       = $action['value'] ?? '';
            $action_type = $action['action'] ?? 'set_value';
            $find        = $action['find'] ?? '';
            if ( ! in_array( $action_type, $valid_actions, true ) ) {
                $action_type = 'set_value';
            }

            // Only add actions with valid attributes.
            if ( ! empty( $attribute ) ) {
                $cleaned_actions[] = array(
                    'attribute' => $attribute,
                    'action'    => $action_type,
                    'value'     => $value,
                    'find'      => $find,
                );
            }
        }

        return $cleaned_actions;
    }

    /**
     * Change default footer text, asking to review our plugin.
     *
     * @param string $default_text Default footer text.
     * @return string Footer text asking to review our plugin.
     **/
    public function edit_feed_footer_text( $default_text ) {
        $screen = get_current_screen();

        // Only show on edit feed page.
        if ( 'product-feed-pro_page_adt-edit-feed' !== $screen->id ) {
            return $default_text;
        }

        return sprintf(
            /* translators: %s: WooCommerce Product Feed PRO plugin rating link */
            esc_html__(
                'If you like our %1$s plugin please leave us a %2$s rating. Thanks in advance!',
                'woo-product-feed-pro'
            ),
            '<strong>WooCommerce Product Feed PRO</strong>',
            '<a href="https://wordpress.org/support/plugin/woo-product-feed-pro/reviews?rate=5#new-post" target="_blank" class="woo-product-feed-pro-ratingRequest">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
        );
    }

    /**
     * Process form submissions from the edit feed page.
     *
     * @since 13.4.4
     * @return void
     */
    public function process_form_submission() {
        // Verify nonce for security.
        check_ajax_referer( 'woosea_ajax_nonce', 'security' );

        // Check user capabilities.
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to edit feeds', 'woo-product-feed-pro' ) );
        }

        // Get the active tab to determine which form we're processing.
        $active_tab = isset( $_POST['active_tab'] ) ? sanitize_text_field( wp_unslash( $_POST['active_tab'] ) ) : 'general';
        $feed_id    = isset( $_POST['feed_id'] ) ? intval( $_POST['feed_id'] ) : 0;

        if ( 0 !== $feed_id ) {
            // Existing feed - process normally.
            $feed = Product_Feed_Helper::get_product_feed( $feed_id );
            if ( ! $feed ) {
                wp_die( esc_html__( 'Feed not found', 'woo-product-feed-pro' ) );
            }

            // Prevent updating feed settings while feed is processing.
            if ( 'processing' === $feed->status ) {
                // Redirect back to the same tab with processing message.
                wp_safe_redirect(
                    add_query_arg(
                        array(
                            'page'    => self::MENU_SLUG,
                            'id'      => $feed_id,
                            'tab'     => $active_tab,
                            'message' => 2,
                        ),
                        admin_url( 'admin.php' )
                    )
                );
            } else {
                // Process the form based on the active tab.
                $this->process_tab_form( $active_tab, $feed );

                // Redirect back to the same tab to prevent form resubmission.
                wp_safe_redirect(
                    add_query_arg(
                        array(
                            'page'    => self::MENU_SLUG,
                            'id'      => $feed_id,
                            'tab'     => $active_tab,
                            'message' => 1,
                        ),
                        admin_url( 'admin.php' )
                    )
                );
            }
        } else {
            // New feed - process temp data.
            $feed = $this->update_temp_product_feed( $_POST ?? array() ); // phpcs:ignore WordPress.Security.NonceVerification
            $tabs = array_keys( $this->get_tabs( $feed ) );

            // Find the current tab's position and determine the next tab.
            $current_tab_position = array_search( $active_tab, $tabs, true );
            $next_tab             = ( false !== $current_tab_position && isset( $tabs[ $current_tab_position + 1 ] ) )
                ? $tabs[ $current_tab_position + 1 ]
                : ''; // Empty indicates we're at the last tab.

            // Check if channel has taxonomy (only for field_mapping tab).
            if ( 'field_mapping' === $active_tab && isset( $feed['channel_hash'] ) ) {
                $channel = Product_Feed_Helper::get_channel_from_legacy_channel_hash( $feed['channel_hash'] );
                if ( isset( $channel['taxonomy'] ) && 'none' === $channel['taxonomy'] ) {
                    // Skip to filters_rules if no taxonomy by finding its position.
                    $filters_position = array_search( 'filters_rules', $tabs, true );
                    $next_tab         = false !== $filters_position ? 'filters_rules' : $next_tab;
                }
            }

            if ( '' !== $next_tab ) {
                wp_safe_redirect(
                    add_query_arg(
                        array(
                            'page'    => self::MENU_SLUG,
                            'tab'     => $next_tab,
                            'updated' => '1',
                        ),
                        admin_url( 'admin.php' )
                    )
                );
            } else {
                // Create the product feed.
                $this->create_product_feed( $feed );

                wp_safe_redirect(
                    add_query_arg(
                        array(
                            'page' => Manage_Feeds_Page::MENU_SLUG,
                        ),
                        admin_url( 'admin.php' )
                    )
                );
            }
        }
        exit;
    }

    /**
     * Process form submission based on the active tab.
     *
     * @since 13.4.4
     * @param string $active_tab The active tab.
     * @param object $feed The feed object.
     * @return void
     */
    private function process_tab_form( $active_tab, $feed ) {
        switch ( $active_tab ) {
            case 'general':
                $this->process_general_tab_form( $feed );
                break;
            case 'field_mapping':
                $this->process_field_mapping_tab_form( $feed );
                break;
            case 'category_mapping':
                $this->process_category_mapping_tab_form( $feed );
                break;
            case 'filters_rules':
                $this->process_filters_rules_tab_form( $feed );
                break;
            case 'filters':
                $this->process_filters_tab_form( $feed );
                break;
            case 'rules':
                $this->process_rules_tab_form( $feed );
                break;
            case 'conversion_analytics':
                $this->process_conversion_analytics_tab_form( $feed );
                break;
            default:
                do_action( 'adt_process_tab_form', $active_tab, $feed );
                break;
        }
    }

    /**
     * Process general tab form submission.
     *
     * @since 13.4.4
     * @param object $feed The feed object.
     * @return void
     */
    private function process_general_tab_form( $feed ) {
        // phpcs:disable WordPress.Security.NonceVerification

        // Get the current feed.
        $feed_before = clone $feed;

        // Process total_product_orders_lookback field - preserve empty strings.
        $total_product_orders_lookback = isset( $_POST['total_product_orders_lookback'] ) ? sanitize_text_field( wp_unslash( $_POST['total_product_orders_lookback'] ) ) : '';
        $total_product_orders_lookback = '' !== trim( $total_product_orders_lookback ) ? absint( $total_product_orders_lookback ) : '';
        // Process form data.
        $props_to_update = array(
            'title'                                  => isset( $_POST['projectname'] ) ? sanitize_text_field( wp_unslash( $_POST['projectname'] ) ) : '',
            'file_format'                            => isset( $_POST['fileformat'] ) ? sanitize_text_field( wp_unslash( $_POST['fileformat'] ) ) : '',
            'delimiter'                              => isset( $_POST['delimiter'] ) ? sanitize_text_field( wp_unslash( $_POST['delimiter'] ) ) : '',
            'refresh_interval'                       => isset( $_POST['cron'] ) ? sanitize_text_field( wp_unslash( $_POST['cron'] ) ) : '',
            'include_product_variations'             => isset( $_POST['product_variations'] ) ? 'yes' : 'no',
            'only_include_default_product_variation' => isset( $_POST['default_variations'] ) ? 'yes' : 'no',
            'only_include_lowest_product_variation'  => isset( $_POST['lowest_price_variations'] ) ? 'yes' : 'no',
            'include_all_shipping_countries'         => isset( $_POST['include_all_shipping_countries'] ) ? 'yes' : 'no',
            'create_preview'                         => isset( $_POST['preview_feed'] ) ? 'yes' : 'no',
            'refresh_only_when_product_changed'      => isset( $_POST['products_changed'] ) ? 'yes' : 'no',
            'utm_total_product_orders_lookback'      => $total_product_orders_lookback,
        );

        // Allow updating the countries for all feeds channel.
        if ( Product_Feed_Helper::is_all_feeds_channel( $feed->get_channel( 'fields' ) ) ) {
            if ( isset( $_POST['countries'] ) && '' !== $_POST['countries'] ) {
                $props_to_update['country'] = Product_Feed_Helper::get_code_from_legacy_country_name( sanitize_text_field( wp_unslash( $_POST['countries'] ) ) );
            } else {
                $props_to_update['country'] = '';
            }
        }

        /**
         * Filter the product feed properties to update for the general tab.
         *
         * @since 13.4.4
         * @param array  $props_to_update The product feed properties to update.
         * @param object $feed The product feed object.
         */
        $props_to_update = apply_filters( 'adt_edit_feed_general_tab_props', $props_to_update, $feed );

        // Update feed properties.
        $feed->set_props( $props_to_update );
        $feed->save();

        // Re-register the product feed action scheduler if the refresh interval has changed.
        if ( '' !== $feed->refresh_interval && $feed_before->refresh_interval !== $feed->refresh_interval ) {
            $feed->register_action();
        } elseif ( '' === $feed->refresh_interval ) {
            $feed->unregister_action();
        }

        /**
         * Action after processing the general tab form.
         *
         * @since 13.4.4
         * @param object $feed The product feed object.
         * @param array  $props_to_update The updated properties.
         * @param object $feed_before The feed object before the update.
         */
        do_action( 'adt_after_process_general_tab_form', $feed, $props_to_update, $feed_before );
        // phpcs:enable WordPress.Security.NonceVerification
    }

    /**
     * Process field mapping tab form submission.
     *
     * @since 13.4.4
     * @param object $feed The feed object.
     * @return void
     */
    private function process_field_mapping_tab_form( $feed ) {
        // phpcs:disable WordPress.Security.NonceVerification

        // Process field mapping data.
        $attributes = isset( $_POST['attributes'] ) ? Sanitization::sanitize_array( $_POST['attributes'] ) : array(); // phpcs:ignore

        // Clean up attributes: remove static_value flag if it's not actually a static value.
        foreach ( $attributes as $key => $attribute ) {
            // If static_value flag is not 'true', remove it from the attribute.
            if ( isset( $attribute['static_value'] ) && 'true' !== $attribute['static_value'] ) {
                unset( $attributes[ $key ]['static_value'] );
            }
        }

        $props_to_update = array(
            'attributes' => $attributes,
        );

        /**
         * Filter the product feed properties to update for the field mapping tab.
         *
         * @since 13.4.4
         * @param array  $props_to_update The product feed properties to update.
         * @param object $feed The product feed object.
         */
        $props_to_update = apply_filters( 'adt_edit_feed_field_mapping_tab_props', $props_to_update, $feed );

        // Update feed properties.
        $feed->set_props( $props_to_update );
        $feed->save();

        /**
         * Action after processing the field mapping tab form.
         *
         * @since 13.4.4
         * @param object $feed The product feed object.
         * @param array  $props_to_update The updated properties.
         */
        do_action( 'adt_after_process_field_mapping_tab_form', $feed, $props_to_update );
        // phpcs:enable WordPress.Security.NonceVerification
    }

    /**
     * Process category mapping tab form submission.
     *
     * @since 13.4.4
     * @param object $feed The feed object.
     * @return void
     */
    private function process_category_mapping_tab_form( $feed ) {
        // phpcs:disable WordPress.Security.NonceVerification

        // Process category mapping data.
        $mappings = isset( $_POST['mappings'] ) ? Sanitization::sanitize_array( $_POST['mappings'] ) : array(); // phpcs:ignore

        $props_to_update = array(
            'mappings' => $mappings,
        );

        /**
         * Filter the product feed properties to update for the category mapping tab.
         *
         * @since 13.4.4
         * @param array  $props_to_update The product feed properties to update.
         * @param object $feed The product feed object.
         */
        $props_to_update = apply_filters( 'adt_edit_feed_category_mapping_tab_props', $props_to_update, $feed );

        // Update feed properties.
        $feed->set_props( $props_to_update );
        $feed->save();

        /**
         * Action after processing the category mapping tab form.
         *
         * @since 13.4.4
         * @param object $feed The product feed object.
         * @param array  $props_to_update The updated properties.
         */
        do_action( 'adt_after_process_category_mapping_tab_form', $feed, $props_to_update );
        // phpcs:enable WordPress.Security.NonceVerification
    }

    /**
     * Process filters and rules tab form submission.
     *
     * @since 13.4.4
     * @param object $feed The feed object.
     * @return void
     */
    private function process_filters_rules_tab_form( $feed ) {
        // phpcs:disable WordPress.Security.NonceVerification

        // Process filters and rules data.
        $filters = isset( $_POST['rules'] ) ? Sanitization::sanitize_array( $_POST['rules'] ) : array(); // phpcs:ignore
        $rules   = isset( $_POST['rules2'] ) ? Sanitization::sanitize_array( $_POST['rules2'] ) : array(); // phpcs:ignore

        $props_to_update = array(
            'filters' => $filters,
            'rules'   => $rules,
        );

        /**
         * Filter the product feed properties to update for the filters and rules tab.
         *
         * @since 13.4.4
         * @param array  $props_to_update The product feed properties to update.
         * @param object $feed The product feed object.
         */
        $props_to_update = apply_filters( 'adt_edit_feed_filters_rules_tab_props', $props_to_update, $feed );

        // Update feed properties.
        $feed->set_props( $props_to_update );
        $feed->save();

        /**
         * Action after processing the filters and rules tab form.
         *
         * @since 13.4.4
         * @param object $feed The product feed object.
         * @param array  $props_to_update The updated properties.
         */
        do_action( 'adt_after_process_filters_rules_tab_form', $feed, $props_to_update );
        // phpcs:enable WordPress.Security.NonceVerification
    }

    /**
     * Process filters tab form submission.
     *
     * @since 13.4.4
     * @param object $feed The feed object.
     * @return void
     */
    private function process_filters_tab_form( $feed ) {
        // phpcs:disable WordPress.Security.NonceVerification

        // Process new filters data.
        $filters_json = isset( $_POST['filters'] ) ? $_POST['filters'] : ''; // phpcs:ignore

        // Decode JSON and clean the filters data.
        $decoded_filters = $this->decode_json_data( $filters_json );
        $feed_filters    = $this->clean_filters_data( $decoded_filters );

        $props_to_update = array(
            'feed_filters' => $feed_filters,
        );

        /**
         * Filter the product feed properties to update for the filters tab.
         *
         * @since 13.4.4
         * @param array  $props_to_update The product feed properties to update.
         * @param object $feed The product feed object.
         */
        $props_to_update = apply_filters( 'adt_edit_feed_filters_tab_props', $props_to_update, $feed );

        // Update feed properties.
        $feed->set_props( $props_to_update );
        $feed->set_data_version( 'feed_filters', '13.4.6' );
        $feed->save();

        /**
         * Action after processing the filters tab form.
         *
         * @since 13.4.4
         * @param object $feed The product feed object.
         * @param array  $props_to_update The updated properties.
         */
        do_action( 'adt_after_process_filters_tab_form', $feed, $props_to_update );
        // phpcs:enable WordPress.Security.NonceVerification
    }

    /**
     * Process rules tab form submission.
     *
     * @since 13.4.4
     * @param object $feed The feed object.
     * @return void
     */
    private function process_rules_tab_form( $feed ) {
        // phpcs:disable WordPress.Security.NonceVerification

        // Process new rules data (from Vue.js UI).
        $rules_json = isset( $_POST['rules'] ) ? $_POST['rules'] : ''; // phpcs:ignore

        // Decode JSON and clean the rules data.
        $decoded_rules = $this->decode_json_data( $rules_json );
        $feed_rules    = $this->clean_rules_data( $decoded_rules );

        $props_to_update = array(
            'feed_rules' => $feed_rules,
        );

        /**
         * Filter the product feed properties to update for the rules tab.
         *
         * @since 13.4.4
         * @param array  $props_to_update The product feed properties to update.
         * @param object $feed The product feed object.
         */
        $props_to_update = apply_filters( 'adt_edit_feed_rules_tab_props', $props_to_update, $feed );

        // Update feed properties.
        $feed->set_props( $props_to_update );
        $feed->set_data_version( 'feed_rules', '13.4.6' );
        $feed->save();

        /**
         * Action after processing the rules tab form.
         *
         * @since 13.4.4
         * @param object $feed The product feed object.
         * @param array  $props_to_update The updated properties.
         */
        do_action( 'adt_after_process_rules_tab_form', $feed, $props_to_update );
        // phpcs:enable WordPress.Security.NonceVerification
    }

    /**
     * Process conversion and analytics tab form submission.
     *
     * @since 13.4.4
     * @param object $feed The feed object.
     * @return void
     */
    private function process_conversion_analytics_tab_form( $feed ) {
        // phpcs:disable WordPress.Security.NonceVerification

        // Process conversion and analytics data.
        $props_to_update = array(
            'utm_enabled'  => isset( $_POST['utm_on'] ) ? true : false,
            'utm_source'   => isset( $_POST['utm_source'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_source'] ) ) : '',
            'utm_medium'   => isset( $_POST['utm_medium'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_medium'] ) ) : '',
            'utm_campaign' => isset( $_POST['utm_campaign'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_campaign'] ) ) : '',
            'utm_content'  => isset( $_POST['utm_content'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_content'] ) ) : '',
        );

        /**
         * Filter the product feed properties to update for the conversion and analytics tab.
         *
         * @since 13.4.4
         * @param array  $props_to_update The product feed properties to update.
         * @param object $feed The product feed object.
         */
        $props_to_update = apply_filters( 'adt_edit_feed_conversion_analytics_tab_props', $props_to_update, $feed );

        // Update feed properties.
        $feed->set_props( $props_to_update );
        $feed->save();

        /**
         * Action after processing the conversion and analytics tab form.
         *
         * @since 13.4.4
         * @param object $feed The product feed object.
         * @param array  $props_to_update The updated properties.
         */
        do_action( 'adt_after_process_conversion_analytics_tab_form', $feed, $props_to_update );
        // phpcs:enable WordPress.Security.NonceVerification
    }

    /**
     * Create product feed.
     *
     * This method is used to create the product feed after generating the products from the legacy code base.
     *
     * @since 13.3.5
     * @access private
     *
     * @param array $feed_data Project data from the legacy code base.
     */
    private function create_product_feed( $feed_data ) {
        $nonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) : '';
        if ( ! wp_verify_nonce( $nonce, 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to manage product feed.', 'woo-product-feed-pro' ) );
        }

        // Get the total amount of products in the feed.
        if ( isset( $feed_data['product_variations'] ) && 'on' === $feed_data['product_variations'] ) {
            $feed_data['nr_products'] = Product_Feed_Helper::get_total_published_products( true );
        } else {
            $feed_data['nr_products'] = Product_Feed_Helper::get_total_published_products();
        }

        $product_feed = Product_Feed_Helper::get_product_feed();
        $country_code = isset( $feed_data['countries'] ) ? Product_Feed_Helper::get_code_from_legacy_country_name( $feed_data['countries'] ) : '';

        /**
         * Filter the product feed properties.
         *
         * @since 13.3.7
         * @param array        $props        The product feed properties.
         * @param Product_Feed $product_feed The product feed instance.
         * @param array        $feed_data The project data from form submission.
         * @return array
         */
        $product_feed->set_props(
            apply_filters(
                'adt_create_product_feed_props',
                array(
                    'title'                             => $feed_data['projectname'] ?? '',
                    'status'                            => 'processing',
                    'country'                           => $country_code,
                    'channel_hash'                      => $feed_data['channel_hash'] ?? '',
                    'file_name'                         => $feed_data['project_hash'] ?? '',
                    'file_format'                       => $feed_data['fileformat'] ?? '',
                    'delimiter'                         => $feed_data['delimiter'] ?? '',
                    'refresh_interval'                  => $feed_data['cron'] ?? '',
                    'include_product_variations'        => isset( $feed_data['product_variations'] ) && 'on' === $feed_data['product_variations'] ? 'yes' : 'no',
                    'only_include_default_product_variation' => isset( $feed_data['default_variations'] ) && 'on' === $feed_data['default_variations'] ? 'yes' : 'no',
                    'only_include_lowest_product_variation' => isset( $feed_data['lowest_price_variations'] ) && 'on' === $feed_data['lowest_price_variations'] ? 'yes' : 'no',
                    'include_all_shipping_countries'    => isset( $feed_data['include_all_shipping_countries'] ) && 'on' === $feed_data['include_all_shipping_countries'] ? 'yes' : 'no',
                    'create_preview'                    => isset( $feed_data['preview_feed'] ) && 'on' === $feed_data['preview_feed'] ? 'yes' : 'no',
                    'refresh_only_when_product_changed' => isset( $feed_data['products_changed'] ) && 'on' === $feed_data['products_changed'] ? 'yes' : 'no',
                    'attributes'                        => $feed_data['attributes'] ?? array(),
                    'mappings'                          => $feed_data['mappings'] ?? array(),
                    'filters'                           => $feed_data['rules'] ?? array(),
                    'feed_filters'                      => $feed_data['feed_filters'] ?? array(),
                    'rules'                             => $feed_data['rules2'] ?? array(),
                    'feed_rules'                        => $feed_data['feed_rules'] ?? array(),
                    'products_count'                    => $feed_data['nr_products'] ?? 0,
                    'total_products_processed'          => $feed_data['nr_products_processed'] ?? 0,
                    'utm_enabled'                       => isset( $feed_data['utm_on'] ) && 'on' === $feed_data['utm_on'] ? 'yes' : 'no',
                    'utm_source'                        => $feed_data['utm_source'] ?? '',
                    'utm_medium'                        => $feed_data['utm_medium'] ?? '',
                    'utm_campaign'                      => $feed_data['utm_campaign'] ?? '',
                    'utm_content'                       => $feed_data['utm_content'] ?? '',
                    'utm_total_product_orders_lookback' => $feed_data['total_product_orders_lookback'] ?? '',
                    'legacy_project_hash'               => $feed_data['project_hash'] ?? '',
                ),
                $product_feed,
                $feed_data
            )
        );

        /**
         * Set the data version for the product feed.
         * If the user is not using the legacy filters and rules, this means that the data version is 13.4.6.
         * This is crucial to determine which filters and rules logic to use for the feed generation.
         */
        if ( ! get_option( 'adt_use_legacy_filters_and_rules', 'no' ) || 'no' === get_option( 'adt_use_legacy_filters_and_rules', 'no' ) ) {
            $product_feed->set_data_version( 'feed_filters', '13.4.6' );
            $product_feed->set_data_version( 'feed_rules', '13.4.6' );
        }

        /**
         * Action before saving the product feed.
         *
         * @since 13.3.7
         *
         * @param Product_Feed_Factory $product_feed The new product feed.
         * @param array                $feed_data The project data from form submission.
         */
        do_action( 'adt_create_product_feed_before_save', $product_feed, $feed_data );

        $product_feed->save();

        // Register the product feed action scheduler.
        $product_feed->register_action();

        /**
         * Run the product feed batch processing.
         * This is the legacy code base processing logic.
         */
        $product_feed->generate( 'schedule' );
    }

    /**
     * Clear the temporary product feed data when a user first loads the page for creating a new feed.
     *
     * @since 13.4.4
     * @return void
     */
    public function maybe_clear_temp_product_feed() {
        // Get current screen to ensure we're on the edit feed page.
        $screen = get_current_screen();

        // Only proceed if we're on the edit feed page and it's the first visit to create a new feed.
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( ( 'product-feed-pro_page_adt-edit-feed' === $screen->id || 'product-feed-elite_page_adt-edit-feed' === $screen->id ) && ! isset( $_GET['id'] ) && ! isset( $_GET['tab'] ) ) {
            // Clear the temporary product feed data.
            delete_option( ADT_OPTION_TEMP_PRODUCT_FEED );
        }
    }

    /**
     * AJAX handler to check if required fields are filled in the temporary feed data.
     *
     * @since 13.4.4
     * @return void
     */
    public function ajax_check_temp_feed_required_fields() {
        // Verify the nonce.
        check_ajax_referer( 'adt_nonce', 'nonce' );

        // Check user capabilities.
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error(
                array(
                    'message' => __( 'You do not have permission to perform this action.', 'woo-product-feed-pro' ),
                    'errors'  => array( __( 'Permission denied.', 'woo-product-feed-pro' ) ),
                )
            );
        }

        // Get the temporary feed data.
        $temp_feed_data = get_option( ADT_OPTION_TEMP_PRODUCT_FEED, array() );
        $errors         = array();

        // Check project name (should be already checked client-side, but double-check).
        if ( empty( $temp_feed_data['projectname'] ) ) {
            $errors[] = __( 'Feed title is required.', 'woo-product-feed-pro' );
        }

        // Check channel selection.
        if ( empty( $temp_feed_data['channel_hash'] ) ) {
            $errors[] = __( 'Channel field is required.', 'woo-product-feed-pro' );
        }

        // Check if there are any attributes set in the field mapping tab.
        if ( empty( $temp_feed_data['attributes'] ) || ! is_array( $temp_feed_data['attributes'] ) ) {
            $errors[] = __( 'Field mapping is empty or you haven\'t saved the field mapping. Go to the Field Mapping tab and save the field mapping.', 'woo-product-feed-pro' );
        }

        // If we have errors, send them back.
        if ( ! empty( $errors ) ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Required feed configuration fields are missing.', 'woo-product-feed-pro' ),
                    'errors'  => $errors,
                )
            );
        }

        // Everything looks good.
        wp_send_json_success(
            array(
                'message' => __( 'All required fields are filled.', 'woo-product-feed-pro' ),
            )
        );
    }

    /**
     * Display admin messages using WordPress standard approach.
     *
     * @since 13.4.7
     * @return void
     */
    public function display_admin_messages() {
        // Only show on edit feed page.
        $screen = get_current_screen();
        if ( 'product-feed-pro_page_adt-edit-feed' !== $screen->id && 'product-feed-elite_page_adt-edit-feed' !== $screen->id ) {
            return;
        }

        // Get message from URL parameter.
        $message = isset( $_GET['message'] ) ? sanitize_text_field( wp_unslash( $_GET['message'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

        // Define messages similar to WordPress post_updated_messages.
        $messages = array(
            1 => array(
                'message' => __( 'Feed settings updated successfully.', 'woo-product-feed-pro' ),
                'type'    => 'success',
            ),
            2 => array(
                'message' => __( 'Failed to update feed settings.', 'woo-product-feed-pro' ),
                'type'    => 'error',
            ),
        );

        // Display the appropriate message.
        if ( ! empty( $message ) && isset( $messages[ $message ] ) ) {
            $admin_notice = new Admin_Notice( $messages[ $message ]['message'], $messages[ $message ]['type'] );
            $admin_notice->run();
        }
    }

    /**
     * Run the admin page.
     *
     * @since 13.4.4
     */
    public function run() {
        parent::run();

        // Add hook to clear temporary product feed data when on the edit feed page.
        add_action( 'current_screen', array( $this, 'maybe_clear_temp_product_feed' ) );

        add_filter( 'admin_footer_text', array( $this, 'edit_feed_footer_text' ) );

        // Register admin-post.php hooks for form processing.
        add_action( 'admin_post_edit_feed_form_process', array( $this, 'process_form_submission' ) );

        // Register AJAX endpoint to check required fields in temporary feed data.
        add_action( 'wp_ajax_check_temp_feed_required_fields', array( $this, 'ajax_check_temp_feed_required_fields' ) );

        // Admin notices for our custom page (following WordPress conventions).
        add_action( 'admin_notices', array( $this, 'display_admin_messages' ) );
    }
}
