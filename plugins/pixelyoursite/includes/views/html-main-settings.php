<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/** @var PYS $this */

include "html-popovers.php";

?>

<div class="cards-wrapper cards-wrapper-style2 gap-24 setting-wrapper">
    <!-- External IDs -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('External IDs', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'send_external_id' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Use external_id', 'pys');?></h4>
                    </div>
                    <p class="text-gray mt-4">
                        <?php _e('We will store it in cookie called pbid', 'pys');?>
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'external_id_use_transient' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Use transient WP for storage external_id', 'pys');?></h4>
                    </div>
                    <p class="text-gray mt-4">
                        <?php _e('With this storage method, the data is saved in the WordPress database, for 10 minutes. After the lifetime expires, the data will be deleted or overwritten (the row in the database will be removed).', 'pys');?>
                    </p>
                </div>
                <div class="d-flex align-items-center number-option-block">
                    <label class="primary_heading"><?php _e('external_id expire days for cookie:','pys');?></label>
                    <?php PYS()->render_number_input( 'external_id_expire', '', false, 365, 1); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Ajax options -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Ajax options', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input("server_event_use_ajax" ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Use Ajax when API is enabled, or when external_id\'s are used. Keep this option active if you use a cache.', 'pys');?></h4>
                    </div>
                    <p class="text-gray mt-4">
                        <?php _e('Use Ajax when Meta conversion API, or Pinterest API are enabled, or when external_id\'s are used. This helps serving unique event_id values for each pair of browser/server events, ensuring deduplication works. It also ensures uniques external_id\'s are used for each user. Keep this option active if you use a cache solution that can serve the same event_id or the same external_id multiple times.', 'pys');?>
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input("server_static_event_use_ajax" ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Use Ajax for <b>Static events</b> when API is enabled.', 'pys');?></h4>
                    </div>
                    <p class="text-gray mt-4">
                        <?php _e('Do not use AJAX requests for static events if it interferes with page loading, or if the requests during loading block other site functions (such as updating the cart during loading).', 'pys');?>
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input("use_send_beacon" ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Use <b>navigator.sendBeacon</b> instead of jQuery.ajax for better performance', 'pys');?></h4>
                    </div>
                    <p class="text-gray mt-4">
                        <?php _e('This option improves site performance by using the modern sendBeacon API which allows the browser to reliably deliver events in the background while prioritizing resources for the page itself. Falls back to jQuery.ajax if sendBeacon is not supported.', 'pys');?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Disable PHP session -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Disable PHP session', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input('session_disable'); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Disable PHP sessions', 'pys');?></h4>
                    </div>
                    <p class="text-gray mt-4">
                        <?php _e('If you are having problems with sessions or cache when the plugin is enabled due to the creation of the PHPSESSID cookie, disable this option. This may reduce the effectiveness of some of our session-based parameters, such as landing page, traffic source, or UTM.', 'pys');?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Advanded user-data detections -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Advanded user-data detections', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center pro-badge-block">
                                <?php renderDummySwitcher(false); ?>
                                <h4 class="switcher-label secondary_heading"><?php _e('Forms', 'pys');?> <a class="link" href="https://www.youtube.com/watch?v=snUKcsTbvCk" target="_blank"><?php _e('Watch video', 'pys');?></a></h4>
                            </div>
                        </div>
                        <p class="text-gray mt-4">
                            <?php _e('You can define the form\'s fields we can use by adding their names in these fields.', 'pys');?>
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>

                <hr>

                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center pro-badge-block">
                                <?php renderDummySwitcher(false); ?>
                                <h4 class="switcher-label secondary_heading"><?php _e('URL Parameters', 'pys');?> <a class="link" href="https://www.youtube.com/watch?v=7kigOV2-tAI" target="_blank"><?php _e('Watch video', 'pys');?></a></h4>
                            </div>
                        </div>
                        <p class="text-gray mt-4">
                            <?php _e('You can define URL parameters using this format: [url_parameter-name-here]. Example: [url_utm_term] will take the value from a utm_term parameter if it\'s present.', 'pys');?>
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Data persistency -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Data persistency', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="radio-inputs-wrap">
                        <?php PYS()->render_radio_input( 'data_persistency', 'keep_data', __('Keep the data in the browser for as long as possible', 'pys') ); ?>
                        <?php PYS()->render_radio_input( 'data_persistency', 'recent_data', __('Use the most recent data', 'pys') ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Reports attribution -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Reports attribution', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div>
                        <div class="d-flex align-items-center number-option-block justify-content-between">
                            <div class="d-flex align-items-center pro-badge-block">
                                <label class="primary_heading mr-16"><?php _e('First Visit Options:','pys');?></label>
                                <?php renderDummyNumberInput(7); ?>
                                <label class="ml-20"><?php _e('day(s)','pys');?></label>
                            </div>
                        </div>
                        <p class="text-gray mt-4">
                            <?php _e('Define for how long we will store cookies for the "First Visit" attribution model.
                            Used for events parameters (<i>landing page, traffic source, UTMs</i>) and WooCommerce or EDD Reports.', 'pys');?>
                        </p>
                    </div>
                    <div>
                        <div class="d-flex align-items-center number-option-block justify-content-between">
                            <div class="d-flex align-items-center pro-badge-block">
                                <label class="primary_heading mr-16"><?php _e('Last Visit Options:','pys');?></label>
                                <?php renderDummyNumberInput(60); ?>
                                <label class="ml-20"><?php _e('min','pys');?></label>
                            </div>
                        </div>
                        <p class="text-gray mt-4">
                            <?php _e('Define for how long we will store the cookies for the "Last Visit" attribution model.
                            Used for events parameters (<i>landing page, traffic source, UTMs</i>) and WooCommerce or EDD Reports.', 'pys');?>
                        </p>
                    </div>
                    <div>
                        <h4 class="primary_heading mb-12">
                            <?php _e('Attribution model for events parameters:', 'pys');?>
                        </h4>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="pro-badge-block radio-inputs-wrap">
                                <?php renderDummyRadioInput( __('First Visit'),true ); ?>
                                <?php renderDummyRadioInput( __('Last Visit'),false ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Disable the plugin -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Disable the plugin', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input('block_robot_enabled', false); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Disable the plugin for known web crawlers', 'pys');?></h4>
                    </div>
                </div>
                <div>
                    <h4 class="primary_heading mb-4"><?php _e('Exclude these robots from blocking', 'pys');?></h4>
                    <?php PYS()->render_tags_select_input('exclude_blocked_robots',false); ?>
                    <p class="text-gray mt-4">
                        <?php _e('You can exclude robots by their user-agent. You can use either the full name or part of it.', 'pys');?>
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input('block_ip_enabled'); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Disable the plugin for these IP addresses:', 'pys');?></h4>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_tags_select_input('blocked_ips',false); ?>
                    </div>
                </div>
                <div>
                    <h4 class="primary_heading mb-4"><?php _e('Ignore these user roles from tracking:', 'pys');?></h4>
                    <?php PYS()->render_multi_select_input('do_not_track_user_roles', getAvailableUserRoles()); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- User role permissions -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('User role permissions', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <h4 class="primary_heading mb-4"><?php _e('Permissions:', 'pys');?></h4>
                    <?php PYS()->render_multi_select_input('admin_permissions', getAvailableUserRoles()); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Remove parameters -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Remove parameters', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input('enable_remove_source_url_params'); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Remove URL parameters from <i><code>event_source_url</code></i>. Event_source_url is required
                            for Facebook CAPI events. In order to avoid sending parameters that might contain private
                            information, we recommend to keep this option ON.', 'pys');?></h4>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input('enable_remove_download_url_param'); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Remove download_url parameters.', 'pys');?></h4>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center justify-content-between pro-feature-container">
                        <div class="d-flex align-items-center pro-badge-block">
                            <?php renderDummySwitcher(false); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e('Remove target_url parameters.', 'pys');?></h4>
                        </div>
                        <?php renderProBadge(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Caches -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Caches', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <p class="text-grey">
                        If you use site or server uses caches and you notice issues with the plugin, you can add these exceptions to "Exclude JavaScript Files" in minification or delay options:
                    </p>
                </div>
                <div>
                    <div class="example-block">
                        <label>Example:</label>
                        <pre class="copy_text">
pys-js-extra
pysOptions
wp-content/plugins/pixelyoursite/dist/scripts/public.js
wp-content/plugins/pixelyoursite/dist/scripts/js.cookie-2.1.3.min.js
wp-content/plugins/pixelyoursite/dist/scripts/sha256.js
wp-content/plugins/pixelyoursite/dist/scripts/tld.min.js
wp-content/plugins/pixelyoursite-pro/dist/jquery.bind-first-0.2.3.min.js
                            <div class="copy-icon" data-toggle="pys-popover"
                                 data-tippy-trigger="click" data-tippy-placement="bottom"
                                 data-popover_id="copied-popover"></div></pre>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Other stuff -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Other stuff', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input('debug_enabled'); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Debugging Mode. You will be able to see details about the events inside your browser console (developer tools).', 'pys');?></h4>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input('compress_front_js'); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Compress frontend js', 'pys');?></h4>
                    </div>
                    <p class="text-gray mt-4">
                        <?php _e('Compress JS files (please test all your events if you enable this option because it can create conflicts with various caches).', 'pys');?>
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input('hide_version_plugin_in_console'); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Remove the name of the plugin from the console', 'pys');?></h4>
                    </div>
                    <p class="text-gray mt-4">
                        <?php _e('Once ON, we remove all mentions about the plugin or add-ons from the console.', 'pys');?>
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'track_cookie_for_subdomains' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Track domains and subdomains together', 'pys');?></h4>
                    </div>
                    <p class="text-gray mt-4">
                        <?php _e('Enable this option if you want unified tracking for our native landing pages, traffic sources, and UTMs data. When there are different installations, this option must be enabled on both the domain and the subdomain.', 'pys');?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="panel card card-style6 card-static">
        <div class="card-body text-center gap-24">
            <p class="mb-0">Track more key actions with the PRO version:</p>
            <p><a class="btn btn-sm btn-primary" href="https://www.pixelyoursite.com/facebook-pixel-plugin/buy-pixelyoursite-pro?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-upgrade-blue"
                  target="_blank">UPGRADE</a></p></p>
        </div>
    </div>
</div>

