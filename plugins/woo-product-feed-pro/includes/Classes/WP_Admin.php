<?php

/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Updates\Version_13_3_5_Update;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Factories\Vite_App;
use AdTribes\PFP\Factories\Product_Feed_Query;

/**
 * General wp-admin related functionalities and/or overrides.
 *
 * @since 13.3.3
 */
class WP_Admin extends Abstract_Class {


    use Singleton_Trait;

    /**
     * Enqueue admin scripts.
     *
     * @since 13.3.3
     * @access public
     *
     * @param string $hook The current admin page.
     */
    public function admin_enqueue_scripts( $hook ) {

        // Enqueue scripts and styles only on the plugin pages.
        if ( Helper::is_plugin_page() ) {
            $action = sanitize_text_field( wp_unslash( $_REQUEST['action'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification
            $step   = sanitize_text_field( wp_unslash( $_REQUEST['step'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification

            // Enqueue Jquery.
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-dialog' );
            wp_enqueue_script( 'jquery-ui-calender' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
            wp_enqueue_script( Helper::get_wc_script_handle( 'jquery-tiptip' ) );
            wp_enqueue_script( Helper::get_wc_script_handle( 'select2' ) );

            wp_enqueue_script( 'adt-toastr', ADT_PFP_JS_URL . 'lib/toastr/toastr.min.js', array( 'jquery' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
            wp_enqueue_style( 'adt-toastr', ADT_PFP_JS_URL . 'lib/toastr/toastr.min.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );

            wp_enqueue_style( 'woocommerce_admin_styles' );
            wp_enqueue_style( 'pfp-admin-css', ADT_PFP_CSS_URL . 'pfp-admin.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
            wp_enqueue_style( 'woosea_admin-css', ADT_PFP_CSS_URL . 'woosea_admin.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
            wp_enqueue_style( 'woosea_jquery_ui-css', ADT_PFP_CSS_URL . 'jquery-ui.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
            wp_enqueue_style( 'woosea_jquery_typeahead-css', ADT_PFP_CSS_URL . 'jquery.typeahead.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );

            if ( preg_match( '/woosea_manage_license/i', $hook ) ) {
                wp_enqueue_style( 'woosea_license_settings-css', ADT_PFP_CSS_URL . 'license-settings.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
            }

            // JS for adding table rows to the rules page.
            wp_enqueue_script( 'woosea_filters_rules-js', ADT_PFP_JS_URL . 'woosea_filters_rules.js', '', WOOCOMMERCESEA_PLUGIN_VERSION, true );

            // JS for field mapping.
            $field_mapping_js = new Vite_App(
                'adt-field-mapping-js',
                'src/vanilla/field-mapping/index.ts',
                array( 'jquery' ),
                array(),
                'adtObj',
            );
            $field_mapping_js->enqueue();

            // JS for getting channels.
            wp_enqueue_script( 'woosea_channel-js', ADT_PFP_JS_URL . 'woosea_channel.js', '', WOOCOMMERCESEA_PLUGIN_VERSION, true );

            // JS for manage projects page.
            wp_enqueue_script( 'woosea_manage-js', ADT_PFP_JS_URL . 'woosea_manage.js?yo=12', array( 'clipboard' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
            wp_enqueue_script( 'woosea_manage-js', ADT_PFP_JS_URL . 'woosea_manage.js?yo=12', array( 'clipboard' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
            wp_localize_script( 'woosea_manage-js', 'woosea_manage_params', array( 'total_product_feeds' => Product_Feed_Helper::get_total_product_feed() ) );

            // Enqueue the admin plugin JS and CSS.
            $admin_js = new Vite_App(
                'adt-admin-js',
                'src/vanilla/index.ts',
                array( 'jquery' ),
                array(),
                'adtObj',
            );
            $admin_js->enqueue();
        }

        // Admin wide styles and scripts.
        wp_enqueue_style( 'pfp-admin-wide-css', ADT_PFP_CSS_URL . 'pfp-admin-wide.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
        wp_enqueue_script( 'pfp-admin-wide-js', ADT_PFP_JS_URL . 'pfp-admin-wide.js', array( 'jquery' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
        wp_localize_script(
            'pfp-admin-wide-js',
            'pfp_admin_wide',
            array(
                'upgradelink' => Helper::get_utm_url( 'pricing', 'pfp', 'upsell', 'menuprolink' ),
            )
        );
    }

    /**
     * Function for serving different HTML templates while configuring the feed
     * Some cases are left blank for future steps and pages in the configurations process.
     *
     * Legacy code from the original plugin.
     *
     * @since 13.3.6
     * @access public
     */
    public function view_generate_pages() {
        do_action( 'adt_view_generate_pages' );
    }

    /**
     * Add WC navigation bar to page.
     *
     * @since 13.3.4
     * @access public
     */
    public function wc_navigation_bar() {
        if ( function_exists( 'wc_admin_connect_page' ) ) {
            wc_admin_connect_page(
                array(
                    'id'        => 'php-about-page',
                    'screen_id' => 'product-feed-pro_page_pfp-about-page',
                    'title'     => __( 'About Page', 'woo-product-feed-pro' ),
                )
            );

            wc_admin_connect_page(
                array(
                    'id'        => 'php-help-page',
                    'screen_id' => 'product-feed-pro_page_pfp-help-page',
                    'title'     => __( 'Help Page', 'woo-product-feed-pro' ),
                )
            );
        }
    }

    /**
     * Show lite notice bar.
     *
     * This is a notice bar that will be shown on the top of the page.
     *
     * @since 13.3.4
     * @access public
     */
    public function show_notice_bar_lite() {
        if ( Helper::is_show_notice_bar_lite() ) {
            $upgrade_link = apply_filters( 'pfp_notice_bar_lite_upgrade_link', Helper::get_utm_url( 'pricing', 'pfp', 'upsell', 'litebar' ) );
            $message      = apply_filters(
                'adt_pfp_notice_bar_lite_message',
                sprintf(
                    // translators: %1$s and %2$s are placeholders for html tags.
                    __( 'You\'re using Product Feed Pro FREE VERSION. To unlock more features consider %1$supgrading to Elite%2$s.', 'woo-product-feed-pro' ),
                    '<a href="%s" target="_blank">',
                    '</a>'
                )
            );

            Helper::locate_admin_template(
                'notices/notice-bar-lite.php',
                true,
                true,
                array(
                    'message'      => $message,
                    'upgrade_link' => $upgrade_link,
                )
            );
        }
    }

    /**
     * Add links to the plugin page.
     *
     * @since 13.3.3
     * @access public
     *
     * @param array  $links The links to add.
     * @param string $file The plugin file.
     */
    public function plugin_action_links( $links, $file ) {
        // Check to make sure we are on the correct plugin.
        if ( ADT_PFP_BASENAME === $file ) {
            $plugin_links[] = '<a href="' . admin_url( 'admin.php?page=woosea_manage_license' ) . '">License</a>';
            $plugin_links[] = '<a href="' . Helper::get_utm_url( 'support', 'pfp', 'pluginpage', 'support' ) . '" target="_blank" rel="noopener noreferrer">Support</a>';
            $plugin_links[] = '<a href="' . Helper::get_utm_url( 'tutorials', 'pfp', 'pluginpage', 'tutorials' ) . '" target="_blank" rel="noopener noreferrer">Tutorials</a>';
            $plugin_links[] = '<a href="' . admin_url( 'admin.php?page=woosea_manage_settings' ) . '">Settings</a>';
            $plugin_links[] = '<a href="' . Helper::get_utm_url( 'pricing', 'pfp', 'pluginpage', 'goelite' ) . '" target="_blank" style="color:green;" rel="noopener noreferrer"><b>Upgrade To Elite</b></a>';

            // Add the links to the list of links already there.
            foreach ( $plugin_links as $link ) {
                if ( is_array( $links ) ) {
                    array_unshift( $links, $link );
                }
            }
        }

        return $links;
    }

    /**
     * Add other settings on the plugin settings page.
     *
     * @since 13.3.7
     * @access public
     */
    public function add_other_settings() {
        $settings = array(
            array(
                'title' => __( 'Sync Product Feed', 'woo-product-feed-pro' ),
                'type'  => 'button',
                'desc'  => __( 'Sync Product Feed to custom post type and legacy options (Backwards compatibility)', 'woo-product-feed-pro' ),
                'id'    => 'adt_migrate_to_custom_post_type',
            ),
            array(
                'title' => __( 'Clear custom attributes cache', 'woo-product-feed-pro' ),
                'type'  => 'button',
                'desc'  => __( 'Clear custom attributes product meta keys cache', 'woo-product-feed-pro' ),
                'id'    => 'adt_clear_custom_attributes_product_meta_keys',
            ),
            array(
                'title' => __( 'Convert feed URLs to lowercase', 'woo-product-feed-pro' ),
                'type'  => 'button',
                'desc'  => __( 'Standardize all feed file URLs to lowercase format for better compatibility', 'woo-product-feed-pro' ),
                'id'    => 'adt_update_file_url_to_lower_case',
            ),
            array(
                'title' => __( 'Fix duplicated feed', 'woo-product-feed-pro' ),
                'type'  => 'button',
                'desc'  => __( 'This will fix the issue with duplicated feeds due to data migration abnormalities', 'woo-product-feed-pro' ),
                'id'    => 'adt_fix_duplicate_feed',
            ),
            array(
                'title' => __( 'Use legacy filters and rules', 'woo-product-feed-pro' ),
                'type'  => 'checkbox',
                'desc'  => __( 'Use legacy filters and rules', 'woo-product-feed-pro' ),
                'id'    => 'adt_use_legacy_filters_and_rules',
            ),
            array(
                'title'        => __( 'Clean up plugin data on un-installation', 'woo-product-feed-pro' ),
                'type'         => 'checkbox',
                'desc'         => __( 'If checked, removes all plugin data when this plugin is uninstalled. Warning: This process is irreversible.', 'woo-product-feed-pro' ),
                'id'           => ADT_PFP_CLEAN_UP_PLUGIN_OPTIONS,
                'class'        => 'adt-pfp-general-setting',
                'confirmation' => __( 'Are you sure you want to clean up plugin data on un-installation?', 'woo-product-feed-pro' ),
                'show_title'   => true,
            ),
        );

        /**
         * Filter the other settings arguments.
         *
         * @since 13.3.7
         *
         * @param array $settings Array of settings.
         * @return array
         */
        $settings = apply_filters( 'adt_settings_other_settings_args', $settings );

        Helper::locate_admin_template( 'settings/other-settings.php', true, true, array( 'settings' => $settings ) );
    }

    /**
     * Redirect from the old menu slug to the new one.
     *
     * Due to the change in the menu slug in 13.3.4, we need to redirect the user to the correct page.
     * To avoid confusion from the user if they navigate to the old page.
     *
     * @since 13.3.4
     * @access public
     */
    public function redirect_legacy_menu() {
        if ( isset( $_GET['page'] ) && 'woosea_manage_feed' === $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification
            wp_safe_redirect( admin_url( 'admin.php?page=woo-product-feed' ) );
            exit;
        }
    }

    /***************************************************************************
     * AJAX ACTIONS
     * **************************************************************************
     */

    /**
     * Update settings via AJAX.
     *
     * @since 13.3.4
     * @since 13.5.2.1 - Added CSRF protection and allowed settings validation.
     * @access public
     */
    public function ajax_adt_pfp_update_settings() {
        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( array( 'message' => __( 'You do not have permission to perform this action.', 'woo-product-feed-pro' ) ) );
        }

        // CSRF protection is now mandatory - nonce must be present and valid.
        if ( ! isset( $_REQUEST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ), 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        $setting = sanitize_text_field( wp_unslash( $_REQUEST['setting'] ?? '' ) );
        $type    = sanitize_text_field( wp_unslash( $_REQUEST['type'] ?? '' ) );

        // Allow empty values - check if value key exists in request.
        // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized in switch statement based on type.
        $value = isset( $_REQUEST['value'] ) ? wp_unslash( $_REQUEST['value'] ) : '';

        // Only validate required fields (setting and type), allow empty values.
        if ( empty( $setting ) || empty( $type ) ) {
            wp_send_json_error( array( 'message' => __( 'Invalid request.', 'woo-product-feed-pro' ) ) );
        }

        // Allowlist of plugin settings that can be updated via AJAX.
        // This prevents arbitrary WordPress option updates.
        $allowed_settings = $this->get_allowed_ajax_settings();

        if ( ! in_array( $setting, $allowed_settings, true ) ) {
            wp_send_json_error( array( 'message' => __( 'Invalid setting parameter.', 'woo-product-feed-pro' ) ) );
        }

        // Process value based on type.
        switch ( $type ) {
            case 'checkbox':
                // Handle checkbox: convert boolean strings to yes/no.
                $value = in_array( $value, array( 'true', '1', 'yes' ), true ) ? 'yes' : 'no';
                break;
            case 'text':
            case 'number':
                // Allow empty text/number values (for clearing fields).
                $value = sanitize_text_field( $value );
                break;
            case 'textarea':
                // Allow empty textarea values.
                $value = sanitize_textarea_field( $value );
                break;
            default:
                // Default sanitization for unknown types.
                $value = sanitize_text_field( $value );
                break;
        }

        // Update the option (allows empty values).
        update_option( $setting, $value );

        wp_send_json_success( array( 'message' => __( 'Settings updated.', 'woo-product-feed-pro' ) ) );
    }

    /**
     * Get allowed settings that can be updated via AJAX.
     *
     * @since 13.5.2.1
     * @access private
     * @return array List of allowed option names.
     */
    private function get_allowed_ajax_settings() {
        // Define allowlist of plugin-specific settings that can be updated via AJAX.
        // Only plugin-owned settings are allowed to prevent arbitrary WordPress option updates.
        $allowed = array(
            // General settings from Settings_Page::get_general_settings().
            'adt_use_parent_variable_product_image',
            'adt_add_all_shipping',
            'adt_remove_other_shipping_classes_on_free_shipping',
            'adt_remove_free_shipping',
            'adt_remove_local_pickup_shipping',
            'adt_show_only_basis_attributes',
            'adt_enable_logging',
            'adt_add_facebook_pixel',
            'adt_facebook_pixel_id',
            'adt_facebook_pixel_content_ids',
            'adt_add_remarketing',
            'adt_adwords_conversion_id',
            'adt_enable_batch',
            'adt_batch_size',
            'adt_disable_http_feed_generation',
            // Other settings from Settings_Page::get_other_settings().
            'adt_use_legacy_filters_and_rules',
            defined( 'ADT_PFP_CLEAN_UP_PLUGIN_OPTIONS' ) ? (string) ADT_PFP_CLEAN_UP_PLUGIN_OPTIONS : 'adt_clean_up_plugin_data',
            // Elite general settings.
            'adt_structured_data_fix',
            'adt_structured_vat',
            'adt_enable_data_manipulation_support',
            'adt_enable_wpml_support',
            'adt_enable_aelia_support',
            'adt_enable_curcy_support',
            'adt_enable_polylang_support',
            'adt_enable_translatepress_support',
            'adt_enable_facebook_capi',
            'adt_facebook_capi_token',
        );

        /**
         * Filter the list of allowed AJAX settings.
         *
         * This filter allows extending the allowlist for child plugins (like Elite version).
         * All added settings must use the 'adt_' prefix to ensure they are plugin-owned.
         *
         * WARNING: Be extremely careful when adding settings to this list.
         * Never allow core WordPress options like 'default_role', 'users_can_register',
         * 'admin_email', 'siteurl', 'home', etc.
         *
         * Example usage (in Elite plugin):
         * add_filter('adt_pfp_allowed_ajax_settings', function($allowed) {
         *     return array_merge($allowed, array(
         *         'adt_structured_data_fix',
         *         'adt_enable_wpml_support',
         *     ));
         * });
         *
         * @since 13.5.2.1
         * @param array $allowed Array of allowed option names.
         * @return array List of allowed option names.
         */
        $filtered = apply_filters( 'adt_pfp_allowed_ajax_settings', $allowed );

        // Validate filtered result is an array to prevent PHP errors.
        // Falls back to original allowlist if filter returns invalid type.
        if ( ! is_array( $filtered ) ) {
            $filtered = $allowed;
        }

        // Enforce prefix requirement to prevent arbitrary option updates.
        $allowed = array_filter(
            $filtered,
            function ( $value ) {
                return is_string( $value ) && 0 === strpos( $value, 'adt_' );
            }
        );

        return array_values( $allowed );
    }

    /**
     * Migrate to custom post type.
     *
     * @since 13.3.5
     * @access public
     */
    public function ajax_migrate_to_custom_post_type() {
        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( array( 'message' => __( 'You do not have permission to perform this action.', 'woo-product-feed-pro' ) ) );
        }

        if ( ! isset( $_REQUEST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ), 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        // Run the migration.
        ( new Version_13_3_5_Update( true ) )->run();

        /**
         * Action hook to run after migrating to custom post type via settings page.
         *
         * @since 13.3.7
         */
        do_action( 'adt_after_migrate_to_custom_post_type' );

        wp_send_json_success( array( 'message' => __( 'Migration successful.', 'woo-product-feed-pro' ) ) );
    }

    /**
     * Migrate to custom post type.
     *
     * @since 13.3.5
     * @access public
     */
    public function ajax_adt_clear_custom_attributes_product_meta_keys() {
        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( array( 'message' => __( 'You do not have permission to perform this action.', 'woo-product-feed-pro' ) ) );
        }

        if ( ! isset( $_REQUEST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ), 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        // Clear the cache.
        if ( delete_transient( ADT_TRANSIENT_CUSTOM_ATTRIBUTES ) ) {
            wp_send_json_success( array( 'message' => __( 'Custom attributes cache cleared.', 'woo-product-feed-pro' ) ) );
        } else {
            wp_send_json_error( array( 'message' => __( 'Custom attributes cache not found.', 'woo-product-feed-pro' ) ) );
        }
    }

    /**
     * Update file URL to lower case.
     *
     * @since 13.4.4
     * @access public
     */
    public function ajax_update_file_url_to_lower_case() {
        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( array( 'message' => __( 'You do not have permission to perform this action.', 'woo-product-feed-pro' ) ) );
        }

        if ( ! isset( $_REQUEST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ), 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        $feeds_query = new Product_Feed_Query(
            array(
                'post_status' => array( 'draft', 'publish' ),
            ),
            'edit'
        );

        $success_count = 0;
        $error_count   = 0;

        if ( $feeds_query->have_posts() ) {
            foreach ( $feeds_query->get_posts() as $feed ) {
                // Get the old file path.
                $old_file_path = $feed->get_file_path();

                // Skip if file doesn't exist.
                if ( ! file_exists( $old_file_path ) ) {
                    continue;
                }

                // Get the directory path.
                $dir_path = dirname( $old_file_path );

                // Create new lowercase filename with extension.
                $new_file_name = strtolower( $feed->file_name );

                // Only process if the filenames are different (case sensitive comparison).
                if ( $feed->file_name !== $new_file_name ) {
                    // Create the new file path using the same directory structure as the old file.
                    $new_file_path = $dir_path . '/' . $new_file_name . '.' . $feed->file_format;

                    // Update the database entry regardless of file operation success.
                    $feed->file_name           = $new_file_name;
                    $feed->legacy_project_hash = $new_file_name;

                    // Save the feed to update all database entries.
                    $feed->save();

                    /**
                     * Try to rename the file using a safer method than copy+delete.
                     * Using wp_filesystem->move() is not working as expected, due to the same file name (Uppsercase to Lowercase).
                     * So we use rename() instead, which is more reliable.
                     */
                    $renamed = @rename( $old_file_path, $new_file_path ); // phpcs:ignore WordPress.PHP.NoSilencedErrors, WordPress.WP.AlternativeFunctions

                    // Track success or failure for reporting.
                    if ( $renamed ) {
                        ++$success_count;
                    } else {
                        ++$error_count;
                    }
                }
            }
        }

        if ( $error_count > 0 ) {
            wp_send_json_success(
                array(
                    'message'       => __( 'Feed URLs updated to lowercase in database. Some files could not be renamed due to permission issues.', 'woo-product-feed-pro' ),
                    'success_count' => $success_count,
                    'error_count'   => $error_count,
                )
            );
        } else {
            wp_send_json_success( array( 'message' => __( 'Feed URLs and files successfully updated to lowercase.', 'woo-product-feed-pro' ) ) );
        }
    }

    /**
     * Use legacy filters and rules.
     *
     * @since 13.4.6
     * @access public
     */
    public function ajax_use_legacy_filters_and_rules() {
        if ( ! isset( $_REQUEST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ), 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( array( 'message' => __( 'Invalid security token', 'woo-product-feed-pro' ) ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( array( 'message' => __( 'You do not have permission to do this', 'woo-product-feed-pro' ) ) );
        }

        $value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ?? '' ) );
        $value = 'true' === $value ? 'yes' : 'no';

        if ( update_option( 'adt_use_legacy_filters_and_rules', $value, false ) ) {
            if ( 'yes' === $value ) {
                wp_send_json_success( array( 'message' => __( 'Legacy filters and rules enabled', 'woo-product-feed-pro' ) ) );
            } else {
                wp_send_json_success( array( 'message' => __( 'Legacy filters and rules disabled', 'woo-product-feed-pro' ) ) );
            }
        } else {
            wp_send_json_error( array( 'message' => __( 'Error enabling legacy filters and rules', 'woo-product-feed-pro' ) ) );
        }
    }

    /**
     * Fix duplicated feed.
     *
     * @since 13.4.6
     * @access public
     */
    public function ajax_fix_duplicate_feed() {
        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( array( 'message' => __( 'You do not have permission to perform this action.', 'woo-product-feed-pro' ) ) );
        }

        if ( ! isset( $_REQUEST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ), 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        // Reset backward compatibility options.
        delete_option( 'adt_cron_projects' );

        // If the file name or legacy project hash is empty that means the feed is duplicated, delete the post.
        $args  = array(
            'post_type'      => 'adt_product_feed',
            'posts_per_page' => -1,
            'meta_query'     => array(
                'relation' => 'OR',
                array(
                    'key'     => 'adt_file_name',
                    'value'   => '',
                    'compare' => '=',
                ),
                array(
                    'key'     => 'adt_file_name',
                    'compare' => 'NOT EXISTS',
                ),
                array(
                    'key'     => 'adt_legacy_project_hash',
                    'value'   => '',
                    'compare' => '=',
                ),
                array(
                    'key'     => 'adt_legacy_project_hash',
                    'compare' => 'NOT EXISTS',
                ),
            ),
        );
        $posts = get_posts( $args );
        foreach ( $posts as $post ) {
            wp_delete_post( $post->ID, true );
        }
        wp_reset_postdata();

        wp_send_json_success( array( 'message' => __( 'Duplicated feed fixed.', 'woo-product-feed-pro' ) ) );
    }


    /**
     * Dismiss the get Elite notification.
     *
     * @since 13.3.6
     * @access public
     **/
    public function ajax_dismiss_get_elite_notice() {
        if ( ! isset( $_REQUEST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['security'] ) ), 'woosea_ajax_nonce' ) ) {
            wp_send_json_error( __( 'Invalid security token', 'woo-product-feed-pro' ) );
        }

        if ( ! Helper::is_current_user_allowed() ) {
            wp_send_json_error( __( 'You do not have permission to do this', 'woo-product-feed-pro' ) );
        }

        if ( update_option( 'woosea_getelite_notification', 'no', false ) ) {
            wp_send_json_success( __( 'Notification dismissed', 'woo-product-feed-pro' ) );
        } else {
            wp_send_json_error( __( 'Error dismissing notification', 'woo-product-feed-pro' ) );
        }
    }

    /**
     * Run the class
     *
     * @codeCoverageIgnore
     * @since 13.3.3
     */
    public function run() {

        if ( ! is_admin() ) {
            return;
        }

        // Enqueue admin styles and scripts.
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        // Add WC navigation bar to page.
        add_action( 'init', array( $this, 'wc_navigation_bar' ) );

        // Add notice bar.
        add_action( 'in_admin_header', array( $this, 'show_notice_bar_lite' ), 10 );

        // Add plugin action links.
        add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );

        // Add other settings on the plugin settings page.
        add_action( 'adt_after_manage_settings_table', array( $this, 'add_other_settings' ) );

        // Redirect to manage feed page.
        add_action( 'admin_menu', array( $this, 'redirect_legacy_menu' ) );

        // AJAX actions.
        add_action( 'wp_ajax_adt_pfp_update_settings', array( $this, 'ajax_adt_pfp_update_settings' ) );
        add_action( 'wp_ajax_woosea_getelite_notification', array( $this, 'ajax_dismiss_get_elite_notice' ) );
        add_action( 'wp_ajax_adt_migrate_to_custom_post_type', array( $this, 'ajax_migrate_to_custom_post_type' ) );
        add_action( 'wp_ajax_adt_clear_custom_attributes_product_meta_keys', array( $this, 'ajax_adt_clear_custom_attributes_product_meta_keys' ) );
        add_action( 'wp_ajax_adt_update_file_url_to_lower_case', array( $this, 'ajax_update_file_url_to_lower_case' ) );
        add_action( 'wp_ajax_adt_use_legacy_filters_and_rules', array( $this, 'ajax_use_legacy_filters_and_rules' ) );
        add_action( 'wp_ajax_adt_fix_duplicate_feed', array( $this, 'ajax_fix_duplicate_feed' ) );
    }
}
