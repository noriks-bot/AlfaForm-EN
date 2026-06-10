<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Helpers\Helper;

/**
 * Model that houses the logic of the Plugin_Installer module.
 *
 * @since 13.3.4
 */
class Plugin_Installer extends Abstract_Class {

    use Singleton_Trait;

    /**
     * 3rd party plugins stored in a private to prevent change.
     *
     * @since 13.3.4
     * @var array
     */
    private $allowed_plugins = array(
        'advanced-coupons-for-woocommerce-free' => array(
            'token'       => 'acfw_installed_by',
            'token_value' => 'pfp',
            'basename'    => 'advanced-coupons-for-woocommerce-free/advanced-coupons-for-woocommerce-free.php',
        ),
        'storeagent-ai-for-woocommerce'         => array(
            'token'       => 'saai_installed_by',
            'token_value' => 'pfp',
            'basename'    => 'storeagent-ai-for-woocommerce/storeagent-ai-for-woocommerce.php',
        ),
        'wc-vendors'                            => array(
            'token'       => 'wcv_installed_by',
            'token_value' => 'pfp',
            'basename'    => 'wc-vendors/class-wc-vendors.php',
        ),
        'woocommerce-wholesale-prices'          => array(
            'token'       => 'wwp_installed_by',
            'token_value' => 'pfp',
            'basename'    => 'woocommerce-wholesale-prices/woocommerce-wholesale-prices.bootstrap.php',
        ),
        'invoice-gateway-for-woocommerce'       => array(
            'token'       => 'igfw_installed_by',
            'token_value' => 'pfp',
            'basename'    => 'invoice-gateway-for-woocommerce/invoice-gateway-for-woocommerce.php',
        ),
        'woocommerce-exporter'                  => array(
            'token'       => 'wse_installed_by',
            'token_value' => 'pfp',
            'basename'    => 'woocommerce-exporter/exporter.php',
        ),
        'woocommerce-store-toolkit'             => array(
            'token'       => 'wst_installed_by',
            'token_value' => 'pfp',
            'basename'    => 'woocommerce-store-toolkit/store-toolkit.php',
        ),
        'saveto-wishlist-lite-for-woocommerce'  => array(
            'token'       => 'stwl_installed_by',
            'token_value' => 'pfp',
            'basename'    => 'saveto-wishlist-lite-for-woocommerce/saveto-wishlist-lite-for-woocommerce.php',
        ),
    );

    /**
     * Enqueue the plugin installer scripts.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $hook The current admin page.
     */
    public function enqueue_plugin_installer_scripts( $hook ) {
        if ( 'product-feed_page_pfp-about-page' === $hook ) {
            wp_enqueue_script( 'pfp-about-page-js', ADT_PFP_JS_URL . 'pfp-plugin-installer.js', array( 'jquery' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
        }
    }

    /**
     * Download and activate a given plugin.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $plugin_slug Plugin slug.
     * @param bool   $silently download plugin silently.
     * @return bool|\WP_Error True if successful, WP_Error otherwise.
     */
    public function download_and_activate_plugin( $plugin_slug, $silently = false ) {

        // Check if the current user has the required permissions.
        if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) ) {
            return new \WP_Error( 'permission_denied', __( 'You do not have sufficient permissions to install and activate plugins.', 'woo-product-feed-pro' ) );
        }

        // Check if the plugin is valid.
        if ( ! $this->_is_plugin_allowed_for_install( $plugin_slug ) ) {
            return new \WP_Error( 'adt_plugin_not_allowed', __( 'The plugin is not valid.', 'woo-product-feed-pro' ) );
        }

        // Get required files since we're calling this outside of context.
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        // Get the plugin info from WordPress.org's plugin repository.
        $api = plugins_api( 'plugin_information', array( 'slug' => $plugin_slug ) );
        if ( is_wp_error( $api ) ) {
            return $api;
        }

        $plugin_basename = $this->get_plugin_basename_by_slug( $plugin_slug );

        // Check if the plugin is already active.
        if ( is_plugin_active( $plugin_basename ) ) {
            return new \WP_Error( 'adt_plugin_already_active', __( 'The plugin is already installed.', 'woo-product-feed-pro' ) );
        }

        // Check if the plugin is already installed but inactive, just activate it and return true.
        if ( Helper::is_plugin_installed( $plugin_basename ) ) {
            return $this->_activate_plugin( $plugin_basename, $plugin_slug );
        }

        // Download the plugin.
        $skin     = $silently ? new \WP_Ajax_Upgrader_Skin() : new \Plugin_Installer_Skin(
            array(
                'type'  => 'web',
                'title' => sprintf( 'Installing Plugin: %s', $api->name ),
            )
        );
        $upgrader = new \Plugin_Upgrader( $skin );

        $result = $upgrader->install( $api->download_link );

        // Check if the plugin was installed successfully.
        if ( is_wp_error( $result ) ) {
            return $result;
        }

        $plugin_token_info = $this->get_plugin_token_by_slug( $plugin_slug );

        if ( '' !== $plugin_token_info['token'] ) {
            update_option( $plugin_token_info['token'], $plugin_token_info['token_value'], false );
        }

        // Activate the plugin.
        return $this->_activate_plugin( $plugin_basename, $plugin_slug );
    }

    /**
     * Activate a plugin.
     *
     * @since 13.3.4
     * @access private
     *
     * @param string $plugin_basename Plugin basename.
     * @param string $plugin_slug     Plugin slug.
     * @return bool|\WP_Error True if successful, WP_Error otherwise.
     */
    private function _activate_plugin( $plugin_basename, $plugin_slug ) {
        $result = activate_plugin( $plugin_basename );
        return is_wp_error( $result ) ? $result : true;
    }

    /**
     * Get the list of allowed plugins for install.
     *
     * @since 13.3.4
     * @access public
     *
     * @return array List of allowed plugins.
     */
    public function get_allowed_plugins() {
        // Allow other plugins to be installed but not let them overwrite the ones listed above.
        $extra_allowed_plugins = apply_filters( 'adt_allowed_install_plugins', array() );

        return array_merge( $this->allowed_plugins, $extra_allowed_plugins );
    }

    /**
     * Validate if the given plugin is allowed for install.
     *
     * @since 13.3.4
     * @access private
     *
     * @param string $plugin_slug Plugin slug.
     * @return bool True if valid, false otherwise.
     */
    private function _is_plugin_allowed_for_install( $plugin_slug ) {
        return in_array( $plugin_slug, array_keys( $this->get_allowed_plugins() ), true );
    }

    /**
     * Get the plugin basename by slug.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $plugin_slug Plugin slug.
     * @return string Plugin basename.
     */
    public function get_plugin_basename_by_slug( $plugin_slug ) {
        $allowed_plugins = $this->get_allowed_plugins();

        return $allowed_plugins[ $plugin_slug ]['basename'] ?? '';
    }

    /**
     * Get the plugin token info by slug.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $plugin_slug Plugin slug.
     * @return array Plugin token information containing token and token_value.
     */
    public function get_plugin_token_by_slug( $plugin_slug ) {
        $allowed_plugins = $this->get_allowed_plugins();

        return array(
            'token'       => $allowed_plugins[ $plugin_slug ]['token'] ?? '',
            'token_value' => $allowed_plugins[ $plugin_slug ]['token_value'] ?? '',
        );
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX Functions
    |--------------------------------------------------------------------------
     */

    /**
     * AJAX install and activate a plugin.
     *
     * @since 13.3.4
     * @access public
     */
    public function ajax_install_activate_plugin() {

        // Check nonce.
        check_ajax_referer( 'adt_install_plugin', 'nonce' );

        // Retrieve the plugin slug from the front-end.
        $plugin_slug = isset( $_REQUEST['plugin_slug'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['plugin_slug'] ) ) : '';

        $silent = isset( $_REQUEST['silent'] ) ?? false;
        $result = $this->download_and_activate_plugin( $plugin_slug, $silent );

        do_action( 'adt_after_install_activate_plugin', $plugin_slug, $result );

        if ( isset( $_REQUEST['redirect'] ) ) {
            wp_safe_redirect( admin_url( 'plugins.php' ) );
        }

        // Check if the result is a WP_Error.
        if ( is_wp_error( $result ) ) {
            // If it is, return a JSON response indicating failure.
            wp_send_json_error( $result->get_error_message() );
        } else {
            // If not, return a JSON response indicating success.
            wp_send_json_success();
        }
    }

    /**
     * Run the class
     *
     * @codeCoverageIgnore
     * @since 13.3.4
     */
    public function run() {
        if ( ! is_admin() ) {
            return;
        }

        // Enqueue scripts.
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_plugin_installer_scripts' ) );

        // AJAX actions.
        add_action( 'wp_ajax_adt_install_activate_plugin', array( $this, 'ajax_install_activate_plugin' ) );
    }
}
