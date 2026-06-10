<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * General wp-admin related functionalities and/or overrides.
 *
 * @since 13.3.4
 */
class Marketing extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Marketing submenu list.
     *
     * @since 13.3.4
     * @access private
     *
     * @var array
     */
    private $marketing_submenus = array();

    /**
     * Constructor.
     *
     * @since 13.3.4
     * @access public
     */
    public function __construct() {}

    /**
     * Initialize the marketing submenus.
     * This should be called at 'init' action or later.
     *
     * @since 13.3.4
     * @access public
     */
    public function init_marketing_submenus() {
        $this->marketing_submenus = array(
            'acfw' => array(
                'title'    => __( 'Advanced Coupons', 'woo-product-feed-pro' ),
                'slug'     => 'advanced-coupons-marketing',
                'callback' => 'advanced_coupons_marketing_page',
                'basename' => 'advanced-coupons-for-woocommerce-free/advanced-coupons-for-woocommerce-free.php',
            ),
        );
    }

    /**
     * Register the marketing submenu.
     *
     * @since 13.3.4
     * @access public
     */
    public function register_marketing_submenu() {
        // Initialize the submenus if not already done.
        if ( empty( $this->marketing_submenus ) ) {
            $this->init_marketing_submenus();
        }

        foreach ( $this->marketing_submenus as $plugin_key => $submenu ) {
            if (
                get_option( 'pfp_' . $plugin_key . '_marketing_page_closed', 'no' ) === 'yes'
                || ( Helper::is_plugin_active( $submenu['basename'] ) || Helper::is_submenu_registered( 'woocommerce-marketing', $submenu['slug'] ) )
            ) {
                continue;
            }

            add_submenu_page(
                'woocommerce-marketing',
                $submenu['title'],
                $submenu['title'],
                'manage_options',
                $submenu['slug'],
                array( $this, $submenu['callback'] )
            );
        }
    }

    /**
     * Marketing page.
     *
     * @since 13.3.4
     * @access public
     */
    public function advanced_coupons_marketing_page() {
        $plugin_data = $this->marketing_submenus['acfw'];
        $step        = $this->get_plugin_step( 'acfw' );

        Helper::locate_admin_template(
            'marketing/acfw-marketing-page.php',
            true,
            true,
            array(
                'plugin_data' => $plugin_data,
                'step'        => $step,
            )
        );
    }

    /**
     * Enqueue admin scripts.
     *
     * @since 13.3.4
     * @access public
     *
     * @param string $hook The current admin page.
     */
    public function admin_enqueue_scripts( $hook ) {
        $screen = get_current_screen();

        if ( ! $screen ) {
            return;
        }

        foreach ( $this->marketing_submenus as $submenu ) {
            if ( strpos( $screen->id, $submenu['slug'] ) !== false ) {
                wp_enqueue_style( 'pfp-admin-marketing', ADT_PFP_CSS_URL . 'pfp-admin-marketing.css', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
                wp_enqueue_script( 'pfp-admin-marketing', ADT_PFP_JS_URL . 'pfp-admin-marketing.js', array( 'jquery' ), WOOCOMMERCESEA_PLUGIN_VERSION, true );
                wp_localize_script( 'pfp-admin-marketing', 'pfp_admin_marketing', array( 'nonce' => wp_create_nonce( 'pfp-admin-marketing' ) ) );

                // Load Poppins font from Google Fonts.
                wp_enqueue_style( 'pfp-admin-marketing--font-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap', array(), WOOCOMMERCESEA_PLUGIN_VERSION );
            }
        }
    }

    /**
     * Set the PFP page.
     *
     * @since 13.3.4
     * @access public
     *
     * @param bool $is_pfp_page Whether the current page is a PFP page.
     * @return bool
     */
    public function set_pfp_page( $is_pfp_page ) {
        $screen = get_current_screen();

        if ( ! $screen ) {
            return $is_pfp_page;
        }

        foreach ( $this->marketing_submenus as $submenu ) {
            if ( strpos( $screen->id, $submenu['slug'] ) !== false ) {
                $is_pfp_page = true;
            }
        }

        return $is_pfp_page;
    }

    /**
     * Hide the notice bar lite.
     *
     * @since 13.3.4
     * @access public
     *
     * @param bool $show Whether to show the notice bar lite.
     * @return bool
     */
    public function hide_notice_bar_lite( $show ) {
        $screen = get_current_screen();

        if ( ! $screen ) {
            return $show;
        }

        foreach ( $this->marketing_submenus as $submenu ) {
            if ( strpos( $screen->id, $submenu['slug'] ) !== false ) {
                $show = false;
            }
        }

        return $show;
    }

    /**
     * Get the plugin step.
     *
     * @since 13.3.4
     * @access private
     *
     * @param string $plugin_key The plugin key.
     * @return int
     */
    private function get_plugin_step( $plugin_key ) {
        $step = 1;

        if ( ! isset( $this->marketing_submenus[ $plugin_key ] ) ) {
            return $step;
        }

        $plugin = $this->marketing_submenus[ $plugin_key ];

        if ( Helper::is_plugin_installed( $plugin['basename'] ) ) {
            $step = 2; // Plugin is installed.
        }

        return $step;
    }

    /***************************************************************************
     * AJAX
     * **************************************************************************
     */

    /**
     * Close the marketing page.
     *
     * @since 13.3.9
     * @access public
     */
    public function close_marketing_page() {
        check_ajax_referer( 'pfp-admin-marketing', 'nonce' );

        $plugin_key = isset( $_POST['plugin_key'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin_key'] ) ) : '';

        update_option( 'pfp_' . $plugin_key . '_marketing_page_closed', 'yes', false );

        wp_send_json_success(
            array(
                'redirect_to' => admin_url( 'admin.php?page=woo-product-feed' ),
            )
        );
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

        // Initialize the marketing submenus at init hook.
        add_action( 'init', array( $this, 'init_marketing_submenus' ) );

        // Add a new submenu.
        add_action( 'admin_menu', array( $this, 'register_marketing_submenu' ), 100 );

        // Set the PFP page.
        add_filter( 'pfp_is_pfp_page', array( $this, 'set_pfp_page' ) );

        // Hide the notice bar lite.
        add_filter( 'pfp_show_notice_bar_lite', array( $this, 'hide_notice_bar_lite' ) );

        // Enqueue admin styles and scripts.
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        // Close marketing page.
        add_action( 'wp_ajax_pfp_close_marketing_page', array( $this, 'close_marketing_page' ) );
    }
}
