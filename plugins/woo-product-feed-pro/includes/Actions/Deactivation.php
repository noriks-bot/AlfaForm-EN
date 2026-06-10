<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Actions
 */

namespace AdTribes\PFP\Actions;

use AdTribes\PFP\Abstracts\Abstract_Class;

/**
 * Deactivation class.
 *
 * @since 13.3.3
 */
class Deactivation extends Abstract_Class {

    /**
     * Holds boolean value whether the plugin is being activated network wide.
     *
     * @since 13.3.3
     * @access protected
     *
     * @var bool
     */
    protected $network_wide;

    /**
     * Constructor.
     *
     * @since 13.3.3
     * @access public
     *
     * @param bool $network_wide Whether the plugin is being activated network wide.
     */
    public function __construct( $network_wide ) {

        $this->network_wide = $network_wide;
    }

    /**
     * Plugin deactivation.
     *
     * @since 13.3.5
     * @access public
     *
     * @param int $blog_id Blog ID.
     */
    private function _deactivate_plugin( $blog_id ) {
        delete_option( 'adt_pfp_activation_code_triggered' );
        delete_site_option( ADT_PFP_OPTION_INSTALLED_VERSION );

        $this->cleanup_action_scheduler();
        $this->cleanup_options();
        $this->cleanup_transients();
    }

    /**
     * Cleanup action scheduler.
     *
     * @since 13.3.3
     * @access public
     */
    protected function cleanup_action_scheduler() {
        // Clear Action Scheduler hooks.
        if ( function_exists( 'as_unschedule_all_actions' ) ) {
            as_unschedule_all_actions( '', array(), ADT_PFP_AS_GENERATE_PRODUCT_FEED_GROUP );
            as_unschedule_all_actions( ADT_PFP_AS_FETCH_GOOGLE_PRODUCT_TAXONOMY );
        }
    }

    /**
     * Cleanup options.
     *
     * @since 13.3.3
     * @access public
     */
    protected function cleanup_options() {
        delete_option( 'woosea_getelite_notification' );
        delete_option( 'woosea_license_notification_closed' );
    }

    /**
     * Cleanup transients.
     *
     * @since 13.4.7
     * @access public
     */
    protected function cleanup_transients() {
        delete_transient( ADT_TRANSIENT_CUSTOM_ATTRIBUTES );
    }

    /**
     * Run plugin deactivation actions.
     *
     * @since 13.3.3
     * @access public
     */
    public function run() {
        // Delete the flag that determines if plugin activation code is triggered.
        global $wpdb;

        // check if it is a multisite network.
        if ( is_multisite() ) {
            // check if the plugin has been deactivated on the network or on a single site.
            if ( $this->network_wide ) {
                // get ids of all sites.
                $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

                foreach ( $blog_ids as $blog_id ) {
                    switch_to_blog( $blog_id );
                    $this->_deactivate_plugin( $blog_id );
                }

                restore_current_blog();
            } else { // activated on a single site, in a multi-site.
                $this->_deactivate_plugin( $wpdb->blogid );
            }
        } else {
            // activated on a single site.
            $this->_deactivate_plugin( $wpdb->blogid );
        }
    }
}
