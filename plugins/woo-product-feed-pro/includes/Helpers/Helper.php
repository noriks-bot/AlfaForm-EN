<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Helpers
 */

namespace AdTribes\PFP\Helpers;

/**
 * Helper methods class.
 *
 * @since 13.3.3
 */
class Helper {

    /**
     * Get plugin data.
     *
     * @since 13.3.3
     * @access public
     *
     * @param string|null $key       The plugin data key.
     * @param bool        $markup    If the returned data should have HTML markup applied. Default false.
     * @param bool        $translate If the returned data should be translated. Default false.
     * @return string[]|string
     */
    public static function get_plugin_data( $key = null, $markup = false, $translate = false ) {

        $plugin_data = get_plugin_data( ADT_PFP_PLUGIN_FILE, $markup, $translate );

        if ( null !== $key ) {
            return $plugin_data[ $key ] ?? '';
        }

        return $plugin_data;
    }

    /**
     * Get the current plugin version.
     *
     * @since 13.3.3
     * @access public
     *
     * @param bool $markup        Optional. If the returned data should have HTML markup applied.
     *                            Default true.
     * @param bool $translate     Optional. If the returned data should be translated. Default true.
     * @return string
     */
    public static function get_plugin_version( $markup = true, $translate = true ) {

        return self::get_plugin_data( 'Version', $markup, $translate );
    }

    /**
     * Utility function that determines if a plugin is active or not.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $plugin_basename Plugin base name. Ex. woocommerce/woocommerce.php.
     * @return boolean True if active, false otherwise.
     */
    public static function is_plugin_active( $plugin_basename ) {
        // Makes sure the plugin is defined before trying to use it.
        if ( ! function_exists( 'is_plugin_active' ) ) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        return is_plugin_active( $plugin_basename );
    }

    /**
     * Utility function that determines if the paid plugin is active or not.
     *
     * @since 13.3.4
     * @access public
     *
     * @return boolean True if active, false otherwise.
     */
    public static function has_paid_plugin_active() {
        return self::is_plugin_active( 'woo-product-feed-elite/woocommerce-sea.php' );
    }

    /**
     * Utility function that determines if a plugin is installed or not.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $plugin_basename Plugin base name. Ex. woocommerce/woocommerce.php.
     * @return boolean True if active, false otherwise.
     */
    public static function is_plugin_installed( $plugin_basename ) {
        $plugin_file_path = trailingslashit( WP_PLUGIN_DIR ) . plugin_basename( $plugin_basename );
        return file_exists( $plugin_file_path );
    }

    /**
     * Utility function that determines if the current page is a Product Feed Pro or Elite page or not.
     *
     * @since 13.3.4
     * @access public
     *
     * @return boolean True if Product Feed Pro or Elite, false otherwise.
     */
    public static function is_plugin_page() {
        $screen = get_current_screen();
        if ( ! $screen ) {
            return false;
        }

        $is_plugin_page = strpos( $screen->id, 'product-feed_page_' ) !== false || strpos( $screen->id, 'woo-product-feed' ) !== false;
        return apply_filters( 'adt_is_plugin_page', $is_plugin_page );
    }

    /**
     * Check if current screen is related to WC.
     *
     * @since 13.3.9
     * @access public
     *
     * @return boolean True if WC screen, false otherwise.
     */
    public static function is_wc_screen() {
        $screen = get_current_screen();
        if ( ! $screen ) {
            return false;
        }

        $wc_screens = array(
            'woocommerce_page_wc-settings',
            'woocommerce_page_wc-reports',
            'woocommerce_page_wc-status',
            'woocommerce_page_wc-addons',
            'plugins',
            'woocommerce_page_wc-orders',
        );

        // Get the post type parameter from the URL.
        $post_type = sanitize_text_field( wp_unslash( $_GET['post_type'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

        $post_types = array(
            'shop_coupon',
            'shop_order',
            'product',
        );

        return in_array( $post_type, $post_types, true ) || in_array( $screen->id, $wc_screens, true );
    }

    /**
     * Utility function that determines if the get elite notice should be shown or not.
     *
     * @since 13.3.6
     * @access public
     *
     * @return boolean True if get elite notice should be shown, false otherwise.
     */
    public static function is_show_get_elite_notice() {
        $show = 'yes' === get_option( 'woosea_getelite_notification', 'yes' );
        return apply_filters( 'adt_pfp_show_get_elite_notice', $show );
    }

    /**
     * Utility function that determines if the lite notice bar should be shown or not.
     *
     * @since 13.3.4
     * @access public
     *
     * @return boolean True if lite notice bar should be shown, false otherwise.
     */
    public static function is_show_notice_bar_lite() {
        $show = false;
        if ( self::is_plugin_page() ) {
            $show = true;
        }
        return apply_filters( 'adt_pfp_show_notice_bar_lite', $show );
    }

    /**
     * Utility function that determines if the logo upgrade button should be shown or not.
     *
     * @since 13.3.6
     * @access public
     *
     * @return boolean True if logo upgrade button should be shown, false otherwise.
     */
    public static function is_show_logo_upgrade_button() {
        return apply_filters( 'adt_pfp_show_logo_upgrade_button', true );
    }

    /**
     * Check if a submenu is registered.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $menu_slug    The menu slug.
     * @param string $submenu_slug The submenu slug.
     * @return boolean
     */
    public static function is_submenu_registered( $menu_slug, $submenu_slug ) {
        global $submenu;

        if ( ! isset( $submenu[ $menu_slug ] ) ) {
            return false;
        }

        foreach ( $submenu[ $menu_slug ] as $submenu_item ) {
            if ( $submenu_slug === $submenu_item[2] ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Strip slashes from POST requests.
     *
     * @since 13.3.7
     * @access public
     *
     * @param mixed $data The object to strip slashes from.
     * @return mixed
     */
    public static function stripslashes_recursive( $data ) {
        return is_array( $data ) ? stripslashes_deep( $data ) : stripslashes( $data );
    }

    /**
     * Check to see if the given URL looks like a dev site
     *
     * @param string $url URL to check.
     *
     * @since  13.3.9
     * @access public
     *
     * @return bool If it appears to be a dev site
     */
    public static function is_dev_url( $url = '' ) {

        $is_local_url = false;

        // Check if testing constant is set.
        if ( defined( 'ADT_PFP_TESTING_SITE' ) && ADT_PFP_TESTING_SITE ) {
            return false;
        }

        // Use site's URL if nothing provided.
        if ( empty( $url ) ) {
            $url = get_bloginfo( 'url' );
        }

        // Trim it up.
        $url = strtolower( trim( $url ) );

        // Need to get the host...so let's add the scheme so we can use parse_url.
        if ( false === strpos( $url, 'http://' ) && false === strpos( $url, 'https://' ) ) {
            $url = 'http://' . $url;
        }

        $url_parts = wp_parse_url( $url );
        $host      = ! empty( $url_parts['host'] ) ? $url_parts['host'] : false;

        if ( ! empty( $url ) && ! empty( $host ) ) {
            if ( false !== ip2long( $host ) ) {
                if ( ! filter_var( $host, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
                    $is_local_url = true;
                }
            } elseif ( 'localhost' === $host ) {
                $is_local_url = true;
            }

            $tlds_to_check = array( '.local', ':8888', ':8080', ':8081', '.invalid', '.example', '.test' );
            foreach ( $tlds_to_check as $tld ) {
                if ( false !== strpos( $host, $tld ) ) {
                    $is_local_url = true;
                    break;
                }
            }
            if ( substr_count( $host, '.' ) > 1 ) {
                $subdomains_to_check = array( 'dev.', '*.staging.', 'beta.', 'test.' );
                foreach ( $subdomains_to_check as $subdomain ) {
                    $subdomain = str_replace( '.', '(.)', $subdomain );
                    $subdomain = str_replace( array( '*', '(.)' ), '(.*)', $subdomain );
                    if ( preg_match( '/^(' . $subdomain . ')/', $host ) ) {
                        $is_local_url = true;
                        break;
                    }
                }
            }
        }

        return $is_local_url;
    }

    /**
     * Check if current database version supports json.
     *
     * @since 13.3.9
     * @access public
     *
     * @return bool True if database supports json, false otherwise.
     */
    public static function is_db_supports_json() {
        global $wpdb;

        $supports_json  = false;
        $db_server_info = is_callable( array( $wpdb, 'db_server_info' ) ) ? $wpdb->db_server_info() : $wpdb->db_version();
        if ( false !== strpos( $db_server_info, 'MariaDB' ) ) {
            $supports_json = version_compare(
                PHP_VERSION_ID >= 80016 ? $wpdb->db_version() : preg_replace( '/[^0-9.].*/', '', str_replace( '5.5.5-', '', $db_server_info ) ),
                '10.2',
                '>='
            );
        } else {
            $supports_json = version_compare( $wpdb->db_version(), '5.7', '>=' );
        }

        return $supports_json;
    }

    /**
     * Custom recursive function using array_walk_recursive to access keys and sanitize values.
     *
     * @since 13.3.9
     * @access public
     *
     * @param array    $input_array The array to walk through.
     * @param callable $callback    The callback function.
     * @param mixed    ...$args     Additional arguments to pass to the callback.
     *
     * @return array
     */
    public static function array_walk_recursive_with_callback( $input_array, $callback, ...$args ) {
        $func = function ( &$item, $key ) use ( $callback, $args ) {
            $item = call_user_func( $callback, $item, $key, ...$args );
        };
        array_walk_recursive( $input_array, $func );
        return $input_array;
    }

    /**
     * Check if the user is allowed to manage product feed.
     *
     * @since 13.3.4
     * @access private
     *
     * @return bool
     */
    public static function is_current_user_allowed() {
        $user          = wp_get_current_user();
        $allowed_roles = apply_filters( 'adt_manage_product_feed_allowed_roles', array() );
        if ( current_user_can( 'manage_adtribes_product_feeds' ) || array_intersect( $allowed_roles, $user->roles ) ) {
            return true;
        }
        return false;
    }

    /**
     * Get the URL with UTM parameters.
     *
     * @param string $url_path     URL path from main.
     * @param string $utm_source   UTM source.
     * @param string $utm_medium   UTM medium.
     * @param string $utm_campaign UTM campaign.
     * @param string $site_url     URL - defaults to `https://adtribes.io/`.
     *
     * @since 13.3.4
     * @return string
     */
    public static function get_utm_url( $url_path = '', $utm_source = 'pfp', $utm_medium = 'action', $utm_campaign = 'default', $site_url = 'https://adtribes.io/' ) {

        $utm_content = get_option( 'pfp_installed_by', false );
        $url         = trailingslashit( $site_url ) . $url_path;

        return add_query_arg(
            array(
                'utm_source'   => $utm_source,
                'utm_medium'   => $utm_medium,
                'utm_campaign' => $utm_campaign,
                'utm_content'  => $utm_content,
            ),
            trailingslashit( $url )
        );
    }

    /**
     * Loads admin template.
     *
     * @since 13.4.3
     *
     * @param string $name Template name relative to `templates/admin` directory.
     * @param bool   $load Whether to load the template or not.
     * @param bool   $once Whether to use require_once or require.
     * @param array  $vars Variables to pass to the template.
     * @return string
     */
    public static function locate_admin_template( $name, $load = false, $once = true, $vars = array() ) {

        //phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
        $template = ADT_PFP_PLUGIN_DIR_PATH . 'templates/' . $name;
        if ( ! file_exists( $template ) ) {
            return '';
        }

        if ( ! empty( $vars ) ) {
            extract( $vars ); // phpcs:ignore WordPress.PHP.DontExtract
        }

        if ( $load ) {
            if ( $once ) {
                require_once $template;
            } else {
                require $template;
            }
        }

        //phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
        return $template;
    }

    /**
     * Generate pagination URL for the feed management page.
     *
     * @since 13.4.4
     * @access public
     *
     * @param int $page The page number to generate the URL for.
     * @param int $per_page The number of items per page.
     * @return string The URL with pagination parameters.
     */
    public static function get_feed_pagination_url( $page, $per_page ) {
        $base_url   = admin_url( 'admin.php' );
        $query_args = array(
            'page'     => 'woo-product-feed',
            'page_num' => $page,
            'per_page' => $per_page,
        );

        // Add any other query parameters from the current URL.
        // phpcs:disable WordPress.Security.NonceVerification.Recommended
        if ( isset( $_GET['subpage'] ) ) {
            $query_args['subpage'] = esc_attr( sanitize_text_field( wp_unslash( $_GET['subpage'] ) ) );
        }
        // phpcs:enable WordPress.Security.NonceVerification.Recommended

        return add_query_arg( $query_args, $base_url );
    }

    /**
     * App frontend and backend common JS app localization properties.
     *
     * @param array $merge Additional data to merge.
     *
     * @since 13.4.4
     * @return array
     */
    public static function vite_app_common_l10n( $merge = array() ) {

        global $allowedposttags;

        $allowed_tags  = array_keys( $allowedposttags );
        $allowed_attrs = array_keys( array_merge( ...array_values( $allowedposttags ) ) );

        $allowed_tags  = apply_filters( 'adt_kses_allowed_tags', $allowed_tags );
        $allowed_attrs = apply_filters( 'adt_kses_allowed_attrs', $allowed_attrs );

        $defaults = array(
            'allowedTags'  => $allowed_tags,
            'allowedAttrs' => $allowed_attrs,
        );

        return wp_parse_args( $merge, $defaults );
    }

    /**
     * Get all WordPress pages for dropdown selection.
     *
     * @since 13.4.8
     * @access public
     *
     * @return array Array of pages with ID as key and title as value.
     */
    public static function get_wordpress_pages() {
        $pages = get_pages(
            array(
                'sort_column' => 'post_title',
                'sort_order'  => 'ASC',
                'post_status' => 'publish',
            )
        );

        $page_options = array();
        foreach ( $pages as $page ) {
            $page_options[ $page->ID ] = $page->post_title;
        }

        return $page_options;
    }

    /**
     * Get all WordPress posts for dropdown selection.
     *
     * @since 13.4.8
     * @access public
     *
     * @return array Array of posts with ID as key and title as value.
     */
    public static function get_wordpress_posts() {
        $posts = get_posts(
            array(
                'numberposts' => -1,
                'post_status' => 'publish',
                'orderby'     => 'title',
                'order'       => 'ASC',
            )
        );

        $post_options = array();
        foreach ( $posts as $post ) {
            $post_options[ $post->ID ] = $post->post_title;
        }

        return $post_options;
    }

    /**
     * Get the correct WooCommerce script handle based on WooCommerce version.
     *
     * WooCommerce 10.3.0+ deprecated several script handles and prefixed them with 'wc-'.
     * This function provides backward compatibility with older WooCommerce versions.
     *
     * Based on WooCommerce core's WC_Admin_Assets::get_scripts() implementation.
     *
     * Supported handle mappings (legacy → new):
     * - select2 → wc-select2
     * - jquery-blockui → wc-jquery-blockui
     * - jquery-tiptip → wc-jquery-tiptip
     * - round → wc-round
     * - qrcode → wc-qrcode
     * - stupidtable → wc-stupidtable
     * - serializejson → wc-serializejson
     * - flot → wc-flot
     * - flot-resize → wc-flot-resize
     * - flot-time → wc-flot-time
     * - flot-pie → wc-flot-pie
     * - flot-stack → wc-flot-stack
     * - js-cookie → wc-js-cookie
     * - dompurify → wc-dompurify
     * - accounting → wc-accounting
     *
     * Unchanged handles: selectWoo, jquery, jquery-ui-core
     *
     * @since 13.3.10
     * @access public
     *
     * @param string $handle The script handle to get (e.g., 'select2', 'jquery-tiptip').
     * @return string The appropriate script handle to use based on WooCommerce version.
     */
    public static function get_wc_script_handle( $handle ) {
        // Handles that don't need prefixing in any version.
        $unchanged_handles = array( 'selectWoo', 'jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-datepicker', 'jquery-ui-autocomplete' );

        // If the handle is in the unchanged list, return as-is.
        if ( in_array( $handle, $unchanged_handles, true ) ) {
            return $handle;
        }

        // Check if WooCommerce 10.3.0+ is active.
        if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '10.3.0', '>=' ) ) {
            // If handle already has 'wc-' prefix, return as-is.
            if ( strpos( $handle, 'wc-' ) === 0 ) {
                return $handle;
            }

            /**
             * Map of known legacy handles to their new WC 10.3.0+ equivalents.
             * Based on WooCommerce core WC_Admin_Assets class implementation.
             *
             * @see class-wc-admin-assets.php::get_scripts()
             */
            $handle_map = array(
                'select2'        => 'wc-select2',
                'jquery-blockui' => 'wc-jquery-blockui',
                'jquery-tiptip'  => 'wc-jquery-tiptip',
                'round'          => 'wc-round',
                'qrcode'         => 'wc-qrcode',
                'stupidtable'    => 'wc-stupidtable',
                'serializejson'  => 'wc-serializejson',
                'flot'           => 'wc-flot',
                'flot-resize'    => 'wc-flot-resize',
                'flot-time'      => 'wc-flot-time',
                'flot-pie'       => 'wc-flot-pie',
                'flot-stack'     => 'wc-flot-stack',
                'js-cookie'      => 'wc-js-cookie',
                'dompurify'      => 'wc-dompurify',
                'accounting'     => 'wc-accounting',
            );

            // Return the mapped handle if it exists, otherwise prefix with 'wc-'.
            return isset( $handle_map[ $handle ] ) ? $handle_map[ $handle ] : 'wc-' . $handle;
        }

        // For older WooCommerce versions, return the original handle.
        return $handle;
    }

    /**
     * Get the correct Select2 script handle based on WooCommerce version.
     *
     * WooCommerce 10.3.0+ deprecated the 'select2' handle in favor of 'wc-select2'.
     * This function provides backward compatibility with older WooCommerce versions.
     *
     * @since 13.3.10
     * @access public
     *
     * @return string The Select2 script handle to use.
     */
    public static function get_select2_script_handle() {
        return self::get_wc_script_handle( 'select2' );
    }
}
