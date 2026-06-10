<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function buildAdminUrl( $page, $tab = '', $action = '', $extra = array() ) {

    $args = array( 'page' => $page );

    if ( $tab ) {
        $args['tab'] = $tab;
    }

    if ( $action ) {
        $args['action'] = $action;
    }

    $args = array_merge( $args, $extra );

    return add_query_arg( $args, admin_url( 'admin.php' ) );

}

function getCurrentAdminPage() {
    if(!empty($_GET['page'])) {
        return sanitize_text_field($_GET['page']);
    }
    return '';

}

function getCurrentAdminTab() {
    if(!empty( $_GET['tab'] ) ) {
        return sanitize_text_field($_GET['tab']);
    }
    return 'general';
}

function getCurrentAdminAction() {
    if(!empty( $_GET['action'] ) ) {
        return sanitize_text_field($_GET['action']);
    }
    return '';
}

function getAdminPrimaryNavTabs() {

    $tabs = array(
        'general' => array(
            'url'  => buildAdminUrl( 'pixelyoursite' ),
            'name' => 'Dashboard',
        ),
        'events'  => array(
            'url'  => buildAdminUrl( 'pixelyoursite', 'events' ),
            'name' => 'Events',
        ),
    );

    if ( isWooCommerceActive() ) {

        $tabs['woo'] = array(
            'url'  => buildAdminUrl( 'pixelyoursite', 'woo' ),
            'name' => 'WooCommerce',
        );

    }

    if ( isEddActive() ) {

        $tabs['edd'] = array(
            'url'  => buildAdminUrl( 'pixelyoursite', 'edd' ),
            'name' => 'EasyDigitalDownloads',
        );

    }
    if ( isWcfActive() ) {

        $tabs['wcf'] = array(
            'url'  => buildAdminUrl( 'pixelyoursite', 'wcf' ),
            'name' => 'CartFlows',
        );

    }
    $tabs[ 'head_footer' ] = array(
        'url'  => buildAdminUrl( 'pixelyoursite', 'head_footer' ),
        'name' => 'Head & Footer',
    );
    $tabs['gdpr'] = array(
        'url'  => buildAdminUrl( 'pixelyoursite', 'gdpr' ),
        'name' => 'Consent',
    );

    return $tabs;

}

function getAdminSecondaryNavTabs() {

    $tabs = array(
        'facebook_settings' => array(
            'url'  => buildAdminUrl( 'pixelyoursite', 'facebook_settings' ),
            'name' => 'Meta Settings',
            'pos' => 5,
            'icon' => PYS_FREE_URL . '/dist/images/meta-logo.svg'
        ),
        'google_tags_settings'   => array(
            'url'  => buildAdminUrl( 'pixelyoursite', 'google_tags_settings' ),
            'name' => 'Google Tags Settings',
            'pos' => 10,
            'icon' => PYS_FREE_URL . '/dist/images/google-tags-logo.svg'
        ),
        'gtm_tags_settings'   => array(
            'url'  => buildAdminUrl( 'pixelyoursite', 'gtm_tags_settings' ),
            'name' => 'GTM Tag Settings',
            'pos' => 15,
            'icon' => PYS_FREE_URL . '/dist/images/gtm-logo.svg'
        ),
    );

    $tabs = apply_filters( 'pys_admin_secondary_nav_tabs', $tabs );

    $tabs['superpack_settings'] = array(
        'url'  => buildAdminUrl( 'pixelyoursite', 'superpack_settings' ),
        'name' => 'Super Pack Settings',
        'pos' => 30,
        'icon' => PYS_FREE_URL . '/dist/images/superpack-logo.svg'
    );

    $tabs['hooks'] = array(
        'url'  => buildAdminUrl( 'pixelyoursite', 'hooks' ),
        'name' => 'Filter & Hook List',
        'pos' => 50,
        'icon' => PYS_FREE_URL . '/dist/images/filter-icon.svg'
    );
    $tabs['logs'] = array(
        'url'  => buildAdminUrl( 'pixelyoursite', 'logs' ),
        'name' => 'Logs',
        'pos' => 60,
        'icon' => PYS_FREE_URL . '/dist/images/logs-icon.svg'
    );


    uasort($tabs,function ($first,$second){
        $firstIndex = isset($first['pos']) ? $first['pos'] : 30;
        $secondIndex = isset($second['pos']) ? $second['pos'] : 30;
        return $firstIndex - $secondIndex;
    });

    return $tabs;

}

function cardCollapseBtn($attr = "", $icon = "icon-shevron-down") {
    echo '<span class="card-collapse" '.$attr.'><i class="' . esc_attr( $icon ) . '" aria-hidden="true"></i></span>';
}

function cardCollapseSettings() {
    ?>
    <span class="card-collapse">
        <?php include PYS_FREE_VIEW_PATH . '/UI/properties-button-off.php'; ?>
    </span>
    <?php
}

/**
 * @param string   $key
 * @param Settings $settings
 */
function renderCollapseTargetAttributes( $key, $settings ) {
    echo 'class="pys_' . $settings->getSlug() . '_' . esc_attr( $key ) . '_panel"';
}

function manageAdminPermissions() {
    global $wp_roles;

    $roles = PYS()->getOption( 'admin_permissions', array( 'administrator' ) );

    foreach ( $wp_roles->roles as $role => $options ) {

        if ( in_array( $role, $roles ) ) {
            $wp_roles->add_cap( $role, 'manage_pys' );
        } else {
            $wp_roles->remove_cap( $role, 'manage_pys' );
        }

    }
}


function renderExternalHelpIcon( $url ) {
    ?>

    <a class="btn btn-link" target="_blank" href="<?php echo esc_url( $url ); ?>">
        <i class="fa fa-info-circle" aria-hidden="true"></i>
    </a>

    <?php
}

function purgeCache() {

    if ( function_exists( 'w3tc_pgcache_flush' ) ) {    // W3 Total Cache

        w3tc_pgcache_flush();

    } elseif ( function_exists( 'wp_cache_clean_cache' ) ) {    // WP Super Cache
        global $file_prefix, $supercachedir;

        if ( empty( $supercachedir ) && function_exists( 'get_supercache_dir' ) ) {
            $supercachedir = get_supercache_dir();
        }

        wp_cache_clean_cache( $file_prefix );

    } elseif ( class_exists( 'WpeCommon' ) ) {

        if ( method_exists( 'WpeCommon', 'purge_memcached' ) ) {
            \WpeCommon::purge_memcached();
        }

        //	    if ( method_exists( 'WpeCommon', 'clear_maxcdn_cache' ) ) {
        //		    \WpeCommon::clear_maxcdn_cache();
        //	    }

        if ( method_exists( 'WpeCommon', 'purge_varnish_cache' ) ) {
            \WpeCommon::purge_varnish_cache();
        }

    } elseif ( method_exists( 'WpFastestCache', 'deleteCache' ) ) {
        global $wp_fastest_cache;

        if ( ! empty( $wp_fastest_cache ) ) {
            $wp_fastest_cache->deleteCache();
        }

    } elseif ( function_exists( 'sg_cachepress_purge_cache' ) ) {

        sg_cachepress_purge_cache();

    }
    if(isRealCookieBannerPluginActivated()){
        wp_rcb_invalidate_templates_cache();
    }
}

function adminIncompatibleVersionNotice( $pluginName, $minVersion ) {
    ?>

    <div class="notice notice-error">
        <p>You are using incompatible version of <?php esc_html_e( $pluginName ); ?>. PixelYourSite requires at
            least <?php esc_html_e( $pluginName ); ?> <?php echo $minVersion; ?>. Please, update to
            latest version.</p>
    </div>

    <?php
}

function adminRenderNotices() {


    if ( ! current_user_can( 'manage_pys' ) ) {
        return;
    }

    if ( ! wp_style_is( 'pys_notice' ) ) {
        wp_enqueue_style( 'pys_notice', PYS_FREE_URL . '/dist/styles/notice.min.css', array(), PYS_FREE_VERSION );
    }

    /**
     * Expiration notices
     */

    $now = time();
    $apiTokens = Facebook()->getOption('server_access_api_token');
    if(Facebook()->enabled() && !$apiTokens)
    {
        $meta_key = 'pys_notice_dont_CAPI_start_delay';
        $user_id = get_current_user_id();
        $start_delay = get_option( $meta_key ) ?? get_user_meta( $user_id, $meta_key );
        $day_ago = time() - DAY_IN_SECONDS;
        if($start_delay && $start_delay > $day_ago) {
            adminRenderNotCAPI(PYS());
        }
        else if(!$start_delay){
            update_option($meta_key, time());
        }

    }
    if ( isPinterestActive( false ) && isPinterestVersionIncompatible() ) {
        adminIncompatibleVersionNotice( 'PixelYourSite Pinterest Add-On', PYS_FREE_PINTEREST_MIN_VERSION );
    } elseif ( isPinterestActive() ) {
        $expire_at = Pinterest()->getOption( 'license_expires' );

        if ( $expire_at && $now > $expire_at ) {
            adminRenderLicenseExpirationNotice( Pinterest() );
        }
    }

    if ( isBingActive( false ) && isBingVersionIncompatible() ) {
        adminIncompatibleVersionNotice( 'PixelYourSite Bing Add-On', PYS_FREE_BING_MIN_VERSION );
    } elseif ( isBingActive() ) {
        $expire_at = Bing()->getOption( 'license_expires' );

        if ( $expire_at && $now > $expire_at ) {
            adminRenderLicenseExpirationNotice( Bing() );
        }
    }

    /**
     * Pixel ID notices
     */

    $facebook_pixel_id = Facebook()->getPixelIDs() ;

    if ( Facebook()->enabled() && empty( $facebook_pixel_id ) ) {
        $no_facebook_pixels = true;
    } else {
        $no_facebook_pixels = false;
    }

    $ga_tracking_id = GA()->getPixelIDs() ;
    $noticeRenderNotSupportUA = false;
    if ( GA()->enabled() && empty( $ga_tracking_id ) ) {
        $no_ga_pixels = true;

    } else {
        $no_ga_pixels = false;
        if (!isGaV4($ga_tracking_id)) {
            $noticeRenderNotSupportUA = true;
        }
    }
    if(GA()->enabled() && $noticeRenderNotSupportUA){
        adminRenderNotSupportUA($noticeRenderNotSupportUA);
    }
    $no_pinterest_pixels = false;
    if ( isPinterestActive() ) {
        $pinterest_pixel_id = Pinterest()->getOption( 'pixel_id' );
        $pinterest_license_status = Pinterest()->getOption( 'license_status' );
        if ( Pinterest()->enabled()
                && ! empty( $pinterest_license_status ) // license active or was active before
                && empty( $pinterest_pixel_id )){
            $no_pinterest_pixels = true;
        }
        if ( $no_facebook_pixels && $no_ga_pixels && $no_pinterest_pixels ) {
            adminRenderNoPixelsNotice();
        } else {

            if ( $no_facebook_pixels ) {
                adminRenderNoPixelNotice( Facebook() );
            }

            if ( $no_ga_pixels ) {
                adminRenderNoPixelNotice( GA() );
            }

            if ( $no_pinterest_pixels ) {
                adminRenderNoPixelNotice( Pinterest() );
            }

        }

        // show notice if licence was never activated
        if (Pinterest()->enabled() && empty($pinterest_license_status)) {
            adminRenderActivatePinterestLicence();
        }

    } else {

        if ( $no_facebook_pixels && $no_ga_pixels ) {
            adminRenderNoPixelsNotice();
        } else {

            if ( $no_facebook_pixels ) {
                adminRenderNoPixelNotice( Facebook() );
            }

            if ( $no_ga_pixels ) {
                adminRenderNoPixelNotice( GA() );
            }

        }

    }

    if ( isBingActive() ) {

        $bing_license_status = Bing()->getOption( 'license_status' );

        // show notice if licence was never activated
        if (Bing()->enabled() && empty($bing_license_status)) {
            adminRenderActivateBingLicence();
        }

    }

    /**
     * GDPR
     */
    if ( isCookieLawInfoPluginActivated() && ! PYS()->getOption( 'gdpr_ajax_enabled' ) ) {
        adminGdprAjaxNotEnabledNotice();
    }
}

/**
 * @param Plugin|Settings $plugin
 */
function adminRenderLicenseExpirationNotice( $plugin ) {

    if ( 'pixelyoursite' == getCurrentAdminPage() ) {
        return; // do not show notice on plugin pages
    }

    $slug = $plugin->getSlug();
    $user_id = get_current_user_id();

    // show only if never dismissed or dismissed more than a week ago
    $meta_key = 'pys_' . $slug . '_expiration_notice_dismissed_at';
    $dismissed_at = get_option($meta_key) ?? get_user_meta( $user_id, $meta_key );
    if ( $dismissed_at ) {

        if ( is_array( $dismissed_at ) ) {
            $dismissed_at = reset( $dismissed_at );
        }

        $week_ago = time() - WEEK_IN_SECONDS;

        if ( $week_ago < $dismissed_at ) {
            return;
        }

    }

    $license_key = $plugin->getOption( 'license_key' );

    ?>

    <div class="notice notice-error is-dismissible pys_<?php echo esc_attr( $slug ); ?>_expiration_notice">
        <p><strong>Your <?php echo $plugin->getPluginName(); ?> license key is expired</strong>, so you no longer get any updates. Don't miss our
            latest improvements and make sure that everything works smoothly.</p>
        <p>If you renewed your license but you still see this message, click on the "<a href="<?php echo esc_url( buildAdminUrl( 'pixelyoursite_licenses' ) ); ?>">Reactivate License</a>" button.</p>
        <p class="mb-0"><a href="https://www.pixelyoursite.com/checkout/?edd_license_key=<?php echo esc_attr(
                $license_key ); ?>&utm_campaign=admin&utm_source=licenses&utm_medium=renew" target="_blank"><strong>Click here to renew your license now</strong></a></p>
    </div>

    <script type="application/javascript">
        jQuery(document).on('click', '.pys_<?php echo esc_attr( $slug ); ?>_expiration_notice .notice-dismiss', function () {

            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: 'pys_notice_dismiss',
                    nonce: '<?php echo esc_attr( wp_create_nonce( 'pys_notice_dismiss' ) ); ?>',
                    user_id: '<?php echo esc_attr( $user_id ); ?>',
                    addon_slug: '<?php echo esc_attr( $slug ); ?>',
                    meta_key: 'expiration_notice'
                }
            })

        })
    </script>

    <?php
}

add_action( 'wp_ajax_pys_notice_dismiss', 'PixelYourSite\adminNoticeDismissHandler' );
function adminNoticeDismissHandler() {

    if ( empty( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'pys_notice_dismiss' ) ) {
        return;
    }

    if ( empty( $_REQUEST['user_id'] ) || empty( $_REQUEST['addon_slug'] ) || empty( $_REQUEST['meta_key'] ) ) {
        return;
    }

    // save time when notice was dismissed
    $meta_key = 'pys_' . sanitize_text_field( $_REQUEST['addon_slug'] ) . '_' . sanitize_text_field( $_REQUEST['meta_key'] ) . '_dismissed_at';
    update_option( $meta_key, time() );

}

function adminRenderNotCAPI( $plugin ) {

    $slug = $plugin->getSlug();
    $user_id = get_current_user_id();

    // show only if never dismissed or dismissed more than a week ago
    $meta_key = 'pys_' . $slug . '_CAPI_notice_dismissed_at';
    $dismissed_at = get_option( $meta_key ) ?? get_user_meta( $user_id, $meta_key );
    if ( $dismissed_at ) {

        if ( is_array( $dismissed_at ) ) {
            $dismissed_at = reset( $dismissed_at );
        }

        $week_ago = time() - WEEK_IN_SECONDS;

        if ( $week_ago < $dismissed_at ) {
            return;
        }
        else
        {
            ?>
            <div class="notice notice-error is-dismissible pys_<?php echo esc_attr( $slug ); ?>_CAPI_notice">
                <p><b>PixelYourSite Tip: </b>Don't forget to enable Meta Conversion API events. They can improve your ads performance and conversion tracking. Watch this video to learn how: <a href="https://www.youtube.com/watch?v=1rKd57SS094" target="_blank">watch the video</a>.</p>
            </div>
            <?php
        }

    }
    else
    {
        ?>
        <div class="notice notice-error is-dismissible pys_<?php echo esc_attr( $slug ); ?>_CAPI_notice">
            <p><b>PixelYourSite Tip: </b>Improve your Meta Ads conversion tracking and performance with Conversion API events. Simply add your token to enable CAPI. Watch this video to learn how to do it: <a href="https://www.youtube.com/watch?v=1rKd57SS094" target="_blank">watch the video</a>.</p>
        </div>
        <?php
    }
    ?>

    <script type="application/javascript">
        jQuery(document).on('click', '.pys_<?php echo esc_attr( $slug ); ?>_CAPI_notice .notice-dismiss', function () {

            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: 'pys_notice_CAPI_dismiss',
                    nonce: '<?php echo esc_attr( wp_create_nonce( 'pys_notice_CAPI_dismiss' ) ); ?>',
                    user_id: '<?php echo esc_attr( $user_id ); ?>',
                    addon_slug: '<?php echo esc_attr( $slug ); ?>',
                    meta_key: 'CAPI_notice'
                }
            })

        })
    </script>

    <?php
}

add_action( 'wp_ajax_pys_notice_CAPI_dismiss', 'PixelYourSite\adminNoticeCAPIDismissHandler' );

function adminNoticeCAPIDismissHandler() {

    if ( empty( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'pys_notice_CAPI_dismiss' ) ) {
        return;
    }

    if ( empty( $_REQUEST['user_id'] ) || empty( $_REQUEST['addon_slug'] ) || empty( $_REQUEST['meta_key'] ) ) {
        return;
    }

    // save time when notice was dismissed
    $meta_key = 'pys_' . sanitize_text_field( $_REQUEST['addon_slug'] ) . '_' . sanitize_text_field( $_REQUEST['meta_key'] ) . '_dismissed_at';
    update_option( $meta_key, time() );
    die();
}


function adminRenderActivatePinterestLicence() {

    if ( 'pixelyoursite_licenses' == getCurrentAdminPage() ) {
        return; // do not show notice licenses page
    }

    ?>

    <div class="notice notice-error">
        <p>Activate your Pinterest add-on license: <a href="<?php echo esc_url( buildAdminUrl( 'pixelyoursite_licenses' ) ); ?>">click here</a>.</p>
    </div>

    <?php
}

function adminRenderActivateBingLicence() {

    if ( 'pixelyoursite_licenses' == getCurrentAdminPage() ) {
        return; // do not show notice licenses page
    }

    ?>

    <div class="notice notice-error">
        <p>Activate your PixelYourSite Microsoft UET (Bing) add-on license: <a href="<?php echo esc_url( buildAdminUrl( 'pixelyoursite_licenses' ) ); ?>">click here</a>.</p>
    </div>

    <?php
}

function adminRenderNoPixelsNotice() {

    if ( 'pixelyoursite' == getCurrentAdminPage() ) {
        return; // do not show notice on plugin pages
    }

    $user_id = get_current_user_id();

    // do not show dismissed notice
    $meta_key = 'pys_core_no_pixels_dismissed_at';
    $dismissed_at = get_option( $meta_key ) ?? get_user_meta( $user_id, $meta_key );
    if ( $dismissed_at ) {
        return;
    }

    ?>

    <div class="notice notice-warning is-dismissible pys_core_no_pixels_notice">
        <p>You have no pixel configured with PixelYourSite. You can add the Meta Pixel (formerly Facebook Pixel), Google Analytics or the
            Pinterest Tag. <a href="<?php echo esc_url( buildAdminUrl( 'pixelyoursite' ) ); ?>">Start tracking
                everything now</a></p>
    </div>

    <script type="application/javascript">
        jQuery(document).on('click', '.pys_core_no_pixels_notice .notice-dismiss', function () {

            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: 'pys_notice_dismiss',
                    nonce: '<?php echo esc_attr( wp_create_nonce( 'pys_notice_dismiss' ) ); ?>',
                    user_id: '<?php echo esc_attr( $user_id ); ?>',
                    addon_slug: 'core',
                    meta_key: 'no_pixels'
                }
            })

        })
    </script>

    <?php
}


function adminRenderNotSupportUA( $show = false) {


    $user_id = get_current_user_id();

    // show only if never dismissed or dismissed more than a week ago
    $meta_key = 'pys_ga_UA_notice_dismissed_at';
    $dismissed_at = get_option( $meta_key ) ?? get_user_meta( $user_id, $meta_key );
    $week_ago = time() - WEEK_IN_SECONDS;
    if ( $dismissed_at && is_array( $dismissed_at ) ) {
        $dismissed_at = reset( $dismissed_at );
    }
    if ( !$dismissed_at || ($dismissed_at && $dismissed_at < $week_ago) && $show) {
            ?>
            <div class="notice notice-error is-dismissible pys_ga_UA_notice">
                <p><b>PixelYourSite Tip: </b>The old Universal Analytics properties are not supported by Google Analytics anymore. You must use the new GA4 properties instead. <a href="https://www.youtube.com/watch?v=KkiGbfl1q48" target="_blank">Watch this video to find how to get your GA4 tag</a>.</p>
            </div>
            <?php
    }
    ?>

    <script type="application/javascript">
        jQuery(document).on('click', '.pys_ga_UA_notice .notice-dismiss', function () {

            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: 'pys_notice_UA_dismiss',
                    nonce: '<?php echo esc_attr( wp_create_nonce( 'pys_notice_UA_dismiss' ) ); ?>',
                    user_id: '<?php echo esc_attr( $user_id ); ?>',
                    addon_slug: 'ga',
                    meta_key: 'UA_notice'
                }
            })

        })
    </script>

    <?php
}
add_action( 'wp_ajax_pys_notice_UA_dismiss', 'PixelYourSite\adminNoticeUADismissHandler' );

function adminNoticeUADismissHandler() {

    if ( empty( $_REQUEST['nonce'] ) || ! wp_verify_nonce( $_REQUEST['nonce'], 'pys_notice_UA_dismiss' ) ) {
        return;
    }

    if ( empty( $_REQUEST['user_id'] ) || empty( $_REQUEST['addon_slug'] ) || empty( $_REQUEST['meta_key'] ) ) {
        return;
    }

    // save time when notice was dismissed
    $meta_key = 'pys_' . sanitize_text_field( $_REQUEST['addon_slug'] ) . '_' . sanitize_text_field( $_REQUEST['meta_key'] ) . '_dismissed_at';
    update_option( $meta_key, time() );
    die();
}


/**
 * @param Plugin|Settings $plugin
 */
function adminRenderNoPixelNotice( $plugin ) {

    if ( 'pixelyoursite' == getCurrentAdminPage() ) {
        return; // do not show notice on plugin pages
    }

    $slug = $plugin->getSlug();
    $user_id = get_current_user_id();

    // do not show dismissed notice
    $meta_key = 'pys_' . $slug . '_no_pixel_dismissed_at';
    $dismissed_at = get_option( $meta_key ) ?? get_user_meta( $user_id, $meta_key );
    if ( $dismissed_at ) {
        return;
    }

    ?>

    <div class="notice notice-warning is-dismissible pys_<?php echo esc_attr( $slug ); ?>_no_pixel_notice">
        <?php if ( $slug == 'facebook' ) : ?>

            <p>Add your Meta Pixel (formerly Facebook Pixel) ID and start tracking everything with PixelYourSite. <a
                        href="<?php echo esc_url( buildAdminUrl( 'pixelyoursite' ) ); ?>">Click Here</a></p>

        <?php elseif ( $slug == 'ga' && ( isWooCommerceActive() || isEddActive() ) ) : ?>

            <p>Add your Google Analytics tracking ID inside PixelYourSite and start tracking everything. Enhanced
                Ecommerce is fully supported for WooCommerce or Easy Digital Downloads. <a
                        href="<?php echo esc_url( buildAdminUrl( 'pixelyoursite' ) ); ?>">Click Here</a></p>

            <p>(If you use another Google Analytics plugin, disable it in order to avoid conflicts)</p>

        <?php elseif ( $slug == 'ga' && ! isWooCommerceActive() && ! isEddActive() ) : ?>

            <p>Add your Google Analytics ID inside PixelYourSite and start tracking everything. <a
                        href="<?php echo esc_url( buildAdminUrl( 'pixelyoursite' ) ); ?>">Click Here</a></p>

            <p>(If you use another Google Analytics plugin, disable it in order to avoid conflicts)</p>

        <?php elseif ( $slug == 'pinterest' ) : ?>

            <p>Add your Pinterest pixel ID and start tracking everything with PixelYourSite. <a
                        href="<?php echo esc_url( buildAdminUrl( 'pixelyoursite' ) ); ?>">Click Here</a></p>

        <?php endif; ?>
    </div>

    <script type="application/javascript">
        jQuery(document).on('click', '.pys_<?php echo esc_attr( $slug ); ?>_no_pixel_notice .notice-dismiss', function () {

            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: 'pys_notice_dismiss',
                    nonce: '<?php echo esc_attr( wp_create_nonce( 'pys_notice_dismiss' ) ); ?>',
                    user_id: '<?php echo esc_attr( $user_id ); ?>',
                    addon_slug: '<?php echo esc_attr( $slug ); ?>',
                    meta_key: 'no_pixel'
                }
            })

        })
    </script>

    <?php
}

function renderDummyTextInput( $placeholder = '' , $type = 'standard' ) {
    $classes = array(
        "input-$type",
        "disabled"
    );
    $classes = implode( ' ', $classes );
    ?>

    <input type="text" disabled placeholder="<?php esc_html_e( $placeholder ); ?>" class="<?php echo esc_attr( $classes ); ?>">

    <?php
}
function renderDummyTextAreaInput( $placeholder = '' ) {
    ?>

    <textarea type="text" disabled placeholder="<?php esc_html_e( $placeholder ); ?>" class="textarea-standard disabled">
    </textarea>

    <?php
}
function renderDummyNumberInput($default = 0) {
    ?>
    <div class="input-number-wrapper dummy-number-input">
        <button class="decrease"><i class="icon-minus"></i></button>
        <input type="number" disabled="disabled" min="0" max="100" value="<?=$default?>">
        <button class="increase"><i class="icon-plus"></i></button>
    </div>
    <?php
}

function renderDummyConditionalNumberPage($default = '=')
{
    ?>
    <div class="select-short-wrap">
        <select class="select-short"
                disabled="disabled"
                autocomplete="off">
                <option disabled="disabled" selected value="<?php echo esc_attr( $default ); ?>" ><?php echo esc_attr( $default ); ?></option>
        </select>
    </div>

    <?php
}

function renderDummyNumberInputPercent( $default = 0 ) {

    ?>
    <div class="input-number-wrapper input-number-wrapper-percent">
        <button class="decrease"><i class="icon-minus"></i></button>
        <input disabled="disabled" type="number" value="<?= $default ?>" min="0" max="100">
        <button class="increase"><i class="icon-plus"></i></button>
    </div>

    <?php

}

function renderDummySwitcher($isEnable = false, $type = 'secondary') {
    $attr = $isEnable ? " checked='checked'" : "";
    $classes = array( "$type-switch");
    if ( $type === 'secondary' ) {
        $input_class = 'custom-switch-input';
        $label_class = 'custom-switch-btn';
    }
    $classes = implode( ' ', $classes );
    ?>

    <div class="<?php echo esc_attr( $classes ); ?>">
        <input type="checkbox" value="1" <?=$attr?> disabled="disabled" class="custom-switch-input custom-switch-input">
        <label class="<?php echo esc_attr( $label_class ); ?>"></label>
    </div>

    <?php
}

function renderDummyCheckbox( $label) {

    $id = 'dummy-'.random_int( 1, 1000000 );
    ?>
    <div class="small-checkbox d-flex align-items-center justify-content-between custom-checkbox-badge">
        <input type="checkbox" id="<?php echo $id;?>" value="1"
               class="small-control-input" disabled="disabled">
        <label class="small-control small-checkbox-label" for="<?php echo esc_attr( $id ); ?>">
            <span class="small-control-indicator"><i class="icon-check"></i></span>
            <span class="small-control-description"><?php echo wp_kses_post( $label ); ?></span>
        </label>
    </div>

    <?php
}

function renderDummyRadioInput( $label, $checked = false ) {
    $id = 'dummy-radio-'.random_int( 1, 1000000 );
    ?>
        <div class="radio-standard">
            <input type="radio"
                disabled="disabled"
                class="custom-control-input"
                id="<?php echo esc_attr( $id ); ?>"
				<?php checked( $checked ); ?> />
            <label class="standard-control radio-checkbox-label" for="<?php echo esc_attr( $id ); ?>">
                <span class="standard-control-indicator"></span>
                <span class="standard-control-description"><?php echo wp_kses_post( $label ); ?></span>
            </label>
        </div>
    <?php
}

function renderDummyTagsFields( $tags = array() ) {
    ?>

    <select class="form-control pys-tags-pysselect2" disabled="disabled" style="width: 100%;" multiple>

        <?php foreach ( $tags as $tag ) : ?>
            <option value="<?php echo esc_attr( $tag ); ?>" selected>
                <?php echo esc_attr( $tag ); ?>
            </option>
        <?php endforeach; ?>

    </select>

    <?php
}

function renderDummySelectInput( $value, $full_width = false ) {

    $attr_width = $full_width ? 'width: 100%;max-width: 100%;' : '';

    ?>
    <div class="select-standard-wrap">
        <select class="select-standard pys_number_page_visit_triggers" name="" disabled="disabled" autocomplete="off" style="width: 100%;">
            <option value="" disabled selected><?php esc_html_e( $value ); ?></option>
        </select>
    </div>

    <?php
}

function renderDummyGoogleAdsConversionLabelInputs() {

?>
        <div class="conversion-labels">
            <p class="primary_heading mb-8">Add conversion label</p>

                <div class="conversion-label">
                    <?php renderDummyTextInput( 'Enter conversion label', 'short' ); ?>
                </div>
        </div>

    <?php
}

function renderProBadge( $url = null,$label = "PRO Feature" ) {

    if ( ! $url ) {
        $url = 'https://www.pixelyoursite.com/';
    }

    $url = untrailingslashit( $url ) . '/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature';

    echo '&nbsp;<a href="' . esc_url( $url ) . '" target="_blank" class="badge badge-pill badge-pro">'.$label.' <i class="fa fa-external-link" aria-hidden="true"></i></a>';
}

function renderEventSetupToolBadge( $label = 'Event Setup Tool' ) {

    $url = 'https://www.pixelyoursite.com/strategy/pixelyoursite-est/?utm_source=pys-free-plugin&utm_medium=EST-badge&utm_campaign=EST-badge';

    echo '&nbsp;<a href="' . esc_url( $url ) . '" target="_blank" class="badge badge-pill badge-pro">'
        . esc_html( $label ) . ' <i class="fa fa-external-link" aria-hidden="true"></i></a>';
}


function renderCogBadge( $label = "You need this plugin" ) {

	$url = 'https://www.pixelyoursite.com/plugins/woocommerce-cost-of-goods';

	echo '&nbsp;<a href="' . esc_url( $url ) . '" target="_blank" class="badge badge-pill badge-pro">'.$label.' <i class="fa fa-external-link" aria-hidden="true"></i></a>';
}

function renderSpBadge() {
    echo '&nbsp;<a href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/the-super-pack?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-super-pack" target="_blank" class="badge badge-pill badge-pro">PRO Feature</a>';
}

function renderHfBadge() {
    echo '&nbsp;<a href="https://www.pixelyoursite.com/head-footer-scripts?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-head-footer" target="_blank" class="badge badge-pill badge-pro">PRO Feature</i></a>';
}

function addMetaTagFields($pixel,$url) { ?>
    <div class="mb-16 pt-20">
        <h4 class="primary_heading mb-4">Verify your domain:</h4>
        <?php
        $pixel->render_text_input_array_item( 'verify_meta_tag', 'Add the verification meta-tag there' );
        ?>
        <?php if ( !empty( $url ) ) : ?>
            <div class="mt-4"><a href="<?= $url ?>" target="_blank" class="link link-small">Learn how to verify your
                    domain</a></div>
        <?php endif; ?>
    </div>

    <div class="mb-20">
        <?php
        $metaTags = (array) $pixel->getOption( 'verify_meta_tag' );
        foreach ( $metaTags as $index => $val ) :
            if ( $index == 0 ) continue; ?>

            <div class="meta-block d-flex align-items-center mb-20">
                <div class="flex-1">
                    <?php
                    $pixel->render_text_input_array_item( 'verify_meta_tag', 'Add the verification meta-tag there', $index );
                    ?>
                </div>

                <div class="ml-8 d-flex align-items-center">
                    <?php include PYS_FREE_VIEW_PATH . '/UI/button-remove-meta-row.php'; ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>

        <div class="line mb-24"></div>

        <div class="row" id="pys_add_<?= $pixel->getSlug() ?>_meta_tag_button_row">
            <button class="btn btn-primary btn-primary-type2" type="button"
                    id="pys_add_<?= $pixel->getSlug() ?>_meta_tag">
                Add another verification meta-tag
            </button>
            <script>
                jQuery( document ).ready( function ( $ ) {
                    $( '#pys_add_<?=$pixel->getSlug()?>_meta_tag' ).click( function ( e ) {
                        e.preventDefault();
                        let newField = '<div class="meta-block d-flex align-items-center mb-20"><div class="flex-1">' +
                            '<input type="text" placeholder="Add the verification meta-tag there" name="pys[<?=$pixel->getSlug()?>][verify_meta_tag][]" value="" placeholder="" class="input-standard">' +
                            '</div>' +
                            '<div class="ml-8 d-flex align-items-center">' +
                            '<button type="button" class="btn button-remove-row remove-meta-row"><i class="icon-delete" aria-hidden="true"></i></button>' +
                            '</div></div>';
                        let $row = $( newField )
                            .insertBefore( '#pys_add_<?=$pixel->getSlug()?>_meta_tag_button_row' )
                    } );
                } );
            </script>
        </div>
    </div>
<?php }


function isGaV4($tag) {
    if (is_array($tag)) {
        foreach ($tag as $t) {
            if (!is_string($t)) {
                return false;
            }
            if (strpos($t, 'G') === 0) {
                return true;
            }
        }
        return false;
    } else {
        return strpos($tag, 'G') === 0;
    }
}

add_action( 'wp_ajax_get_transform_title', 'PixelYourSite\getAjaxTransformTitle' );
add_action( 'wp_ajax_nopriv_get_transform_title', 'PixelYourSite\getAjaxTransformTitle'  );

function getAjaxTransformTitle()
{
    $event = new CustomEvent();
    if(!empty($_POST['title'])) {
        wp_send_json_success( array(
            'title' => 'manual_'.$event->transformTitle($_POST['title'])
        ) );
    }else {
        wp_send_json_error("Title not found");
    }
}
function renderWarningMessage( $message ) {
    ?>

    <div class="warning-message">
        <div class="warning-icon"><i class="icon-alert-triangle"></i></div>
        <p class="message-content"> <?php echo wp_kses_post( $message ); ?></p>
    </div>

    <?php
}
