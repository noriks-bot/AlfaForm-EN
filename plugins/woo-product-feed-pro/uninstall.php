<?php
/**
 * Uninstall script for AdTribes Product Feed Plugin Pro.
 *
 * @package AdTribes\PFP
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

/**
 * Function that houses the code that cleans up the plugin on un-installation.
 *
 * @since 13.3.4
 */
function adt_pfp_plugin_cleanup() {
    aft_pfp_unregister_custom_capabilities();

    // skip if the clean up setting is not enabled.
    if ( get_option( 'adt_clean_up_plugin_data' ) !== 'yes' ) {
        return;
    }

    adt_pfp_delete_all_plugin_options();
    adt_pfp_delete_all_plugin_transients();

    // Delete the Product Feed Custom Post Type.
    adt_pfp_delete_product_feed_custom_post_type();
}

/**
 * Unregister custom capabilities.
 *
 * @since 13.3.4
 *
 * @param bool $sitewide Whether to unregister custom capabilities for super admin.
 */
function aft_pfp_unregister_custom_capabilities( $sitewide = false ) {
    if ( $sitewide ) {
        // Remove custom capabilities for super admin.
        $super_admins = get_super_admins();
        foreach ( $super_admins as $super_admin ) {
            $user = new \WP_User( $super_admin );
            $user->remove_cap( 'manage_adtribes_product_feeds' );
        }
    } else {
        // Get all roles.
        $roles = wp_roles()->roles;

        // Loop through each role and remove the custom capability.
        foreach ( $roles as $role_name => $role_info ) {
            $role = get_role( $role_name );
            if ( $role ) {
                $role->remove_cap( 'manage_adtribes_product_feeds' );
            }
        }
    }
}

/**
 * Delete all plugin options.
 *
 * @since 13.4.7
 */
function adt_pfp_delete_all_plugin_options() {
    // Legacy options (unprefixed).
    delete_option( 'last_order_id' );
    delete_option( 'product_changes' );
    delete_option( 'channel_attributes' );
    delete_option( 'skroutz_apparel' );
    delete_option( 'skroutz_clr' );
    delete_option( 'skroutz_sz' );
    delete_option( 'cron_projects' );
    delete_option( 'add_mother_image' );
    delete_option( 'add_all_shipping' );
    delete_option( 'free_shipping' );
    delete_option( 'remove_free_shipping' );
    delete_option( 'remove_local_pickup' );
    delete_option( 'local_pickup_shipping' );
    delete_option( 'show_only_basis_attributes' );
    delete_option( 'enable_logging' );
    delete_option( 'add_facebook_pixel' );
    delete_option( 'facebook_pixel_id' );
    delete_option( 'add_facebook_pixel_content_ids' );
    delete_option( 'add_remarketing' );
    delete_option( 'adwords_conversion_id' );
    delete_option( 'add_batch' );
    delete_option( 'batch_size' );

    // New prefixed options (explicit deletion for clarity, also caught by wildcard below).
    delete_option( 'adt_use_parent_variable_product_image' );
    delete_option( 'adt_add_all_shipping' );
    delete_option( 'adt_remove_other_shipping_classes_on_free_shipping' );
    delete_option( 'adt_remove_free_shipping' );
    delete_option( 'adt_remove_local_pickup_shipping' );
    delete_option( 'adt_show_only_basis_attributes' );
    delete_option( 'adt_enable_logging' );
    delete_option( 'adt_add_facebook_pixel' );
    delete_option( 'adt_facebook_pixel_id' );
    delete_option( 'adt_facebook_pixel_content_ids' );
    delete_option( 'adt_add_remarketing' );
    delete_option( 'adt_adwords_conversion_id' );
    delete_option( 'adt_enable_batch' );
    delete_option( 'adt_batch_size' );
    delete_option( 'adt_last_order_id' );
    delete_option( 'adt_cron_projects' );
    delete_option( 'adt_product_changes' );

    global $wpdb;

    // Delete options.
    $wpdb->query(
        "DELETE FROM {$wpdb->options} 
        WHERE option_name LIKE 'woosea\_%' 
            OR option_name LIKE '%\_woosea\_%' 
            OR option_name LIKE 'pfp\_%' 
            OR option_name LIKE 'adt\_pfp\_%' 
            OR option_name LIKE 'batch_project\_%' 
            OR option_name LIKE 'adt\_%';"
    );
}

/**
 * Delete the Product Feed Custom Post Type.
 *
 * @since 13.4.7
 */
function adt_pfp_delete_product_feed_custom_post_type() {
    global $wpdb;

    // Delete the Product Feed Custom Post Type.
    $wpdb->query( "DELETE FROM {$wpdb->posts} WHERE post_type='adt_product_feed';" );
    $wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE post_id NOT IN (SELECT ID FROM {$wpdb->posts});" );
}

/**
 * Delete all plugin transients.
 *
 * @since 13.4.7
 */
function adt_pfp_delete_all_plugin_transients() {
    delete_transient( 'adt_transient_custom_attributes' );
}

if ( function_exists( 'is_multisite' ) && is_multisite() ) {
    // Get all blog ids.
    global $wpdb;
    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

    foreach ( $blog_ids as $blogid ) {
        switch_to_blog( $blogid );
        adt_pfp_plugin_cleanup();
    }
    restore_current_blog();

    aft_pfp_unregister_custom_capabilities( true );
} else {
    adt_pfp_plugin_cleanup();
}
