<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP
 */

namespace AdTribes\PFP;

use AdTribes\PFP\Actions\Activation;
use AdTribes\PFP\Actions\Deactivation;
use AdTribes\PFP\Factories\Admin_Notice;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Traits\Singleton_Trait;

defined( 'ABSPATH' ) || exit;

require_once ADT_PFP_PLUGIN_DIR_PATH . 'includes/autoload.php';

/**
 * Class App
 */
class App {

    use Singleton_Trait;

    /**
     * Holds the class object instances.
     *
     * @since 13.3.3
     * @access protected
     *
     * @var array An array of object class instance.
     */
    protected $objects;

    /**
     * Holds the failed plugin dependencies.
     *
     * @since 13.3.7
     * @access private
     *
     * @var array An array of failed plugin dependencies.
     */
    private $_failed_dependencies;

    /**
     * App constructor.
     *
     * @since 13.3.3
     * @access public
     */
    public function __construct() {

        $this->objects = array();
    }

    /**
     * Called at the end of file to initialize autoloader.
     *
     * @since 13.3.3
     * @access public
     */
    public function boot() {
        // Added support for WooCommerce HPOS (High-Performnce Order Storage).
        add_action( 'before_woocommerce_init', array( $this, 'hpos_compatibility' ) );

        register_deactivation_hook( ADT_PFP_PLUGIN_FILE, array( $this, 'deactivation_actions' ) );

        // Check plugin dependencies early (before classes are loaded).
        if ( ! $this->_check_dependencies() ) {
            // Show admin notices on admin_notices hook (after textdomain is loaded).
            add_action( 'admin_notices', array( $this, 'display_dependency_notices' ) );
            return;
        }

        register_activation_hook( ADT_PFP_PLUGIN_FILE, array( $this, 'activation_actions' ) );

        // Execute codes that need to run on 'init' hook.
        add_action( 'init', array( $this, 'initialize' ) );

        /***************************************************************************
         * Run the plugin
         ***************************************************************************
         *
         * Run the plugin classes on `setup_theme` hook with priority 100 as
         * it depends on WooCommerce plugin to be loaded first and we need to make
         * sure that WP_Rewrite global object is already available.
         */
        add_action( 'setup_theme', array( $this, 'run' ), 100 );
    }

    /**
     * Register classes to run.
     *
     * @since 13.3.3
     * @access public
     *
     * @param array $objects Array of class instances.
     */
    public function register_objects( $objects ) {

        $this->objects = array_merge( $this->objects, $objects );
    }

    /**
     * Plugin activation actions
     *
     * @since 13.3.3
     * @access public
     *
     * @param bool $sitewide Whether the plugin is being activated network-wide.
     */
    public function activation_actions( $sitewide ) {

        // Run the plugin actions here when it's activated.
        ( new Activation( $sitewide ) )->run();

        flush_rewrite_rules();
    }

    /**
     * Display dependency failure notices with translations.
     *
     * @since 13.3.7
     * @access public
     */
    public function display_dependency_notices() {
        if ( ! empty( $this->_failed_dependencies['missing_plugins'] ) ) {
            $admin_notice = new Admin_Notice(
                sprintf(
                    /* translators: %1$s = opening <strong> tag; %2$s = closing </strong> tag; %3$s = opening <p> tag; %4$s = closing </p> tag */
                    esc_html__(
                        '%3$s%1$sProduct Feed Pro for WooCommerce %2$splugin missing dependency.%4$s',
                        'woo-product-feed-pro'
                    ),
                    '<strong>',
                    '</strong>',
                    '<p>',
                    '</p>'
                ),
                'failed_dependency',
                'html',
                true,
                $this->_failed_dependencies
            );
            $admin_notice->run();
        }
    }

    /**
     * Method that houses codes to be executed on init hook.
     *
     * @since 13.3.5.1
     * @access public
     */
    public function initialize() {
        // Execute activation codebase if not yet executed on plugin activation ( Mostly due to plugin dependencies ).
        $installed_version = get_site_option( ADT_PFP_OPTION_INSTALLED_VERSION, false );

        if ( version_compare( $installed_version, Helper::get_plugin_version(), '!=' ) || get_option( 'adt_pfp_activation_code_triggered', false ) !== 'yes' ) {
            if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
                require_once ABSPATH . '/wp-admin/includes/plugin.php';
            }

            $sitewide = is_plugin_active_for_network( 'woo-product-feed-pro/woocommerce-sea.php' );
            $this->activation_actions( $sitewide );
        }
    }


    /**
     * Run the plugin classes.
     *
     * @since 13.3.3
     * @access public
     */
    public function run() {

        /***************************************************************************
         * Run the plugin classes
         ***************************************************************************
         *
         * Make sure that the classes to be run extends the abstract class or has
         * implemented a `run` method.
         */
        foreach ( $this->objects as $object ) {
            if ( ! method_exists( $object, 'run' ) ) {
                _doing_it_wrong(
                    __METHOD__,
                    esc_html__(
                        'The class does not have a run method. Please make sure to extend the Abstract_Class class.',
                        'woo-product-feed-pro'
                    ),
                    esc_html( Helper::get_plugin_data( 'Version' ) )
                );
                continue;
            }
            $class_object = strtolower( wp_basename( get_class( $object ) ) );

            $this->objects[ $class_object ] = apply_filters(
                'woo_sea_class_object',
                $object,
                $class_object,
                $this
            );
            $this->objects[ $class_object ]->run();
        }
    }

    /**
     * Plugin deactivation actions
     *
     * @since 13.3.3
     * @access public
     *
     * @param bool $sitewide Whether the plugin is being deactivated network-wide.
     */
    public function deactivation_actions( $sitewide ) {

        // Run the plugin deactivation actions.
        ( new Deactivation( $sitewide ) )->run();

        flush_rewrite_rules();
    }

    /**
     * Check plugin dependencies.
     *
     * @since 13.3.7
     * @access private
     *
     * @return bool True if all dependencies are met, false otherwise.
     */
    private function _check_dependencies() {
        $this->_failed_dependencies['missing_plugins'] = $this->_check_missing_required_plugins();

        // Return false if there are any failed dependencies.
        if ( ! empty( $this->_failed_dependencies['missing_plugins'] ) ) {
            return false;
        }

        return true;
    }

    /**
     * Checks required plugins if they are active.
     *
     * @since 13.3.7
     * @access public
     *
     * @return array List of plugins that are not active.
     */
    private static function _check_missing_required_plugins() {

        if ( ! function_exists( 'is_plugin_active' ) ) {
            include_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        $i       = 0;
        $plugins = array();

        $required_plugins = array(
            'woocommerce/woocommerce.php',
        );

        foreach ( $required_plugins as $plugin ) {
            if ( ! is_plugin_active( $plugin ) ) {
                $plugin_name                  = explode( '/', $plugin );
                $plugins[ $i ]['plugin-key']  = $plugin_name[0];
                $plugins[ $i ]['plugin-base'] = $plugin;
                $plugins[ $i ]['plugin-name'] = str_replace(
                    'Woocommerce',
                    'WooCommerce',
                    ucwords( str_replace( '-', ' ', $plugin_name[0] ) )
                );
            }

            ++$i;
        }

        return $plugins;
    }

    /**
     * HPOS compatibility
     *
     * @since 13.3.3
     * @access public
     */
    public function hpos_compatibility() {
        if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', ADT_PFP_PLUGIN_FILE, true );
        }
    }
}

/***************************************************************************
 * Instantiate classes
 ***************************************************************************
 *
 * Instantiate classes to be registered and run.
 */
App::instance()->register_objects(
    array_merge(
        require_once ADT_PFP_PLUGIN_DIR_PATH . 'bootstrap/class-objects.php',
        require_once ADT_PFP_PLUGIN_DIR_PATH . 'bootstrap/integration-objects.php',
        require_once ADT_PFP_PLUGIN_DIR_PATH . 'bootstrap/rest-objects.php',
        require_once ADT_PFP_PLUGIN_DIR_PATH . 'bootstrap/feeds-objects.php',
    )
);

return App::instance();
