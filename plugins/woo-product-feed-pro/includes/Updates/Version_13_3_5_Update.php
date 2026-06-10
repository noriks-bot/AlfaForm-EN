<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Updates
 */

namespace AdTribes\PFP\Updates;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Factories\Product_Feed;

/**
 * Class Version_13_3_5_Update
 *
 * @since 13.3.5
 */
class Version_13_3_5_Update extends Abstract_Class {

    /**
     * Holds the version number.
     *
     * @since 13.3.5
     * @access protected
     *
     * @var string
     */
    protected $version = '13.3.5';

    /**
     * Whether to force update the options.
     *
     * @since 13.3.5
     * @access protected
     *
     * @var bool
     */
    protected $force_update = false;

    /**
     * Constructor.
     *
     * @since 13.3.5
     * @access public
     *
     * @param bool $force_update Whether to force update the options.
     */
    public function __construct( $force_update = false ) {
        $this->force_update = $force_update;
    }

    /**
     * Migrate the options to new CPT.
     *
     * @since 13.3.5
     */
    public function update() {
        $cron_projects = maybe_unserialize( get_option( 'adt_cron_projects' ), array() );
        if ( $cron_projects ) {
            foreach ( $cron_projects as $key => $project_data ) {

                // Skip if the project hash is empty.
                if ( empty( $project_data['project_hash'] ) ) {
                    unset( $cron_projects[ $key ] );
                    continue;
                }

                $feed = new Product_Feed( $project_data['project_hash'] ?? 0 );

                $country_code = isset( $project_data['countries'] ) ? Product_Feed_Helper::get_code_from_legacy_country_name( $project_data['countries'] ) : '';

                $feed->set_props(
                    array(
                        'title'                      => $project_data['projectname'] ?? '',
                        'post_status'                => isset( $project_data['active'] ) && 'true' === $project_data['active'] ? 'publish' : 'draft',
                        'status'                     => $project_data['running'] ?? '',
                        'country'                    => $country_code,
                        'channel_hash'               => $project_data['channel_hash'] ?? '',
                        'file_name'                  => $project_data['filename'] ?? '',
                        'file_format'                => $project_data['fileformat'] ?? '',
                        'delimiter'                  => $project_data['delimiter'] ?? '',
                        'refresh_interval'           => $project_data['cron'] ?? '',
                        'include_product_variations' => isset( $project_data['product_variations'] ) && 'on' === $project_data['product_variations'] ? 'yes' : 'no',
                        'only_include_default_product_variation' => isset( $project_data['default_variations'] ) && 'on' === $project_data['default_variations'] ? 'yes' : 'no',
                        'only_include_lowest_product_variation' => isset( $project_data['lowest_price_variations'] ) && 'on' === $project_data['lowest_price_variations'] ? 'yes' : 'no',
                        'create_preview'             => isset( $project_data['preview_feed'] ) && 'on' === $project_data['preview_feed'] ? 'yes' : 'no',
                        'refresh_only_when_product_changed' => isset( $project_data['products_changed'] ) && 'on' === $project_data['products_changed'] ? 'yes' : 'no',
                        'attributes'                 => $project_data['attributes'] ?? array(),
                        'mappings'                   => $project_data['mappings'] ?? array(),
                        'filters'                    => $project_data['rules'] ?? array(),
                        'rules'                      => $project_data['rules2'] ?? array(),
                        'products_count'             => $project_data['nr_products'] ?? 0,
                        'total_products_processed'   => $project_data['nr_products_processed'] ?? 0,
                        'utm_enabled'                => isset( $project_data['utm_on'] ) && 'on' === $project_data['utm_on'] ? 'yes' : 'no',
                        'utm_source'                 => $project_data['utm_source'] ?? '',
                        'utm_medium'                 => $project_data['utm_medium'] ?? '',
                        'utm_campaign'               => $project_data['utm_campaign'] ?? '',
                        'utm_content'                => $project_data['utm_content'] ?? '',
                        'utm_total_product_orders_lookback' => $project_data['total_product_orders_lookback'] ?? '',
                        'legacy_project_hash'        => $project_data['project_hash'] ?? '',
                        'history_products'           => $project_data['history_products'] ?? array(),
                    )
                );

                $feed = apply_filters( 'adt_update_version_13_3_5_before_save_feed', $feed, $project_data );

                $feed->save();
            }

            // Update the cron_projects option.
            update_option( 'adt_cron_projects', $cron_projects, false );
        } else {
            // Revert deleted old options, for backward compatibility.
            $this->_revert_legacy_options();
        }
    }

    /**
     * Revert deleted old options, for backward compatibility.
     * If the 'adt_product_feed' is present and the 'cron_projects' option is empty, then revert the deleted options.
     * This is a fallback mechanism to ensure that the old options are not lost in case of any issues.
     * For example, if the user moving back to the previous version or switching between pro and elite.
     *
     * @since 13.3.5.1
     * @access private
     */
    private function _revert_legacy_options() {
        global $wpdb;
        $post_ids = $wpdb->get_col( "SELECT {$wpdb->prefix}posts.ID FROM {$wpdb->prefix}posts WHERE post_type = 'adt_product_feed' GROUP BY {$wpdb->prefix}posts.ID" );
        if ( $post_ids ) {
            foreach ( $post_ids as $post_id ) {
                $product_feed = new Product_Feed( $post_id );
                $product_feed->save_legacy_options();
            }
        }
    }

    /**
     * Run the class.
     *
     * @since 13.3.5
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
