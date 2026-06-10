<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Updates
 */

namespace AdTribes\PFP\Updates;

use AdTribes\PFP\Abstracts\Abstract_Class;

/**
 * Class Version_13_4_8_Update
 *
 * @since 13.4.8
 */
class Version_13_4_8_Update extends Abstract_Class {

    /**
     * Holds the version number.
     *
     * @since 13.4.8
     * @access protected
     *
     * @var string
     */
    protected $version = '13.4.8';

    /**
     * Whether to force update the options.
     *
     * @since 13.4.8
     * @access protected
     *
     * @var bool
     */
    protected $force_update = false;

    /**
     * Constructor.
     *
     * @since 13.4.8
     * @access public
     *
     * @param bool $force_update Whether to force update the options.
     */
    public function __construct( $force_update = false ) {
        $this->force_update = $force_update;
    }

    /**
     * Migrate unprefixed options to prefixed versions.
     *
     * @since 13.4.8
     */
    public function update() {
        // Define the options that need to be migrated from unprefixed to prefixed versions.
        $options_to_migrate = array(
            'add_mother_image'               => array(
                'value'    => 'adt_use_parent_variable_product_image',
                'autoload' => true,
            ),
            'add_all_shipping'               => array(
                'value'    => 'adt_add_all_shipping',
                'autoload' => true,
            ),
            'free_shipping'                  => array(
                'value'    => 'adt_remove_other_shipping_classes_on_free_shipping',
                'autoload' => true,
            ),
            'remove_free_shipping'           => array(
                'value'    => 'adt_remove_free_shipping',
                'autoload' => true,
            ),
            'remove_local_pickup'            => array(
                'value'    => 'adt_remove_local_pickup_shipping',
                'autoload' => true,
            ),
            'add_woosea_basic'               => array(
                'value'    => 'adt_show_only_basis_attributes',
                'autoload' => true,
            ),
            'add_woosea_logging'             => array(
                'value'    => 'adt_enable_logging',
                'autoload' => true,
            ),
            'add_facebook_pixel'             => array(
                'value'    => 'adt_add_facebook_pixel',
                'autoload' => true,
            ),
            'facebook_pixel_id'              => array(
                'value'    => 'adt_facebook_pixel_id',
                'autoload' => true,
            ),
            'add_facebook_pixel_content_ids' => array(
                'value'    => 'adt_facebook_pixel_content_ids',
                'autoload' => true,
            ),
            'add_remarketing'                => array(
                'value'    => 'adt_add_remarketing',
                'autoload' => true,
            ),
            'adwords_conversion_id'          => array(
                'value'    => 'adt_adwords_conversion_id',
                'autoload' => true,
            ),
            'add_batch'                      => array(
                'value'    => 'adt_enable_batch',
                'autoload' => true,
            ),
            'woosea_batch_size'              => array(
                'value'    => 'adt_batch_size',
                'autoload' => true,
            ),
            'last_order_id'                  => array(
                'value'    => 'adt_last_order_id',
                'autoload' => true,
            ),
            'cron_projects'                  => array(
                'value'    => 'adt_cron_projects',
                'autoload' => false,
            ),
            'product_changes'                => array(
                'value'    => 'adt_product_changes',
                'autoload' => false,
            ),
        );

        foreach ( $options_to_migrate as $old_option => $new_option_config ) {
            $old_value = get_option( $old_option );

            // Handle both array and string formats for backward compatibility.
            $new_option = is_array( $new_option_config ) ? $new_option_config['value'] : $new_option_config;
            $autoload   = is_array( $new_option_config ) ? $new_option_config['autoload'] : true;

            // If the old option exists and the new one doesn't, migrate the value.
            if ( false !== $old_value && false === get_option( $new_option ) ) {
                update_option( $new_option, $old_value, $autoload );
            }
        }
    }

    /**
     * Run the class.
     *
     * @since 13.4.8
     */
    public function run() {
        if (
            (
                version_compare( get_site_option( ADT_PFP_OPTION_INSTALLED_VERSION ), $this->version, '<=' ) ||
                ! get_site_option( ADT_PFP_OPTION_INSTALLED_VERSION )
            ) || $this->force_update
        ) {
            if ( is_multisite() ) {
                global $wpdb;
                $blog_ids = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs}" );
                foreach ( $blog_ids as $blog_id ) {
                    switch_to_blog( $blog_id );
                    $this->update();
                    restore_current_blog();
                }
            } else {
                $this->update();
            }
        }
    }
}
