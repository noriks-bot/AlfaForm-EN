<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>
<div class="cards-wrapper cards-wrapper-style1 general-page-wrapper gap-24">
    <!-- Pixel IDs -->
    <div class="card card-static card-style1">
        <div class="card-header card-header-style1 d-flex align-items-center">
            <div class="d-flex align-items-center">
                <?php PYS()->render_switcher_input("enable_all_tracking_ids", false, false, false, 'secondary'); ?>
                <h4 class="font-semibold main-switcher ml-22">Pixel IDs</h4>
            </div>
        </div>
        <div class="card-body">

            <input type="checkbox" class="general-settings-checkbox" id="fb_settings_switch" style="display: none">
            <div class="d-flex pixel-wrap align-items-center justify-content-between">
                <div class="pixel-heading d-flex justify-content-start align-items-center">
                    <img class="tag-logo" alt="meta-logo" src="<?php echo PYS_FREE_URL; ?>/dist/images/meta-logo.svg">
                    <h3 class="secondary_heading">Your Meta Pixel</h3>
                </div>
                <div>
                    <label for="fb_settings_switch">
                        <?php include PYS_FREE_VIEW_PATH . '/UI/properties-button-off.php'; ?>
                    </label>
                </div>
            </div>
           <div class="settings_content_wrap">
                <div class="settings_content">
                    <div class="plate pixel_info mb-24">
                        <div class="d-flex align-items-center pixel-switcher-enabled mb-24">
							<?php
							Facebook()->render_switcher_input( "enabled" );
							?>
                            <h4 class="switcher-label secondary_heading">Enable Pixel</h4>
                        </div>
                        <div class="pixel-data-wrap">
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_checkbox_input( "use_server_api", 'Enable Conversion API (add the token below)' ); ?>
                            </div>
                            <div class="facebook-description">
                                <p class="text-gray pb-8">
                                    <?php _e('Install multiple Meta Pixels with CAPI support:', 'pys');?>
                                    <a href="https://www.youtube.com/watch?v=HM98mGZshvc" target="_blank"
                                       class="link">watch video</a>
                                </p>
                                <p class="text-gray">
                                    <?php _e('What is Events Matching and EMQ and how you can improve it:', 'pys');?>
                                    <a href=" https://www.youtube.com/watch?v=3soI_Fl0JQw" target="_blank"
                                       class="link">watch video</a>
                                </p>
                            </div>
                            <div>
                                <h4 class="primary_heading mb-4">Meta Pixel ID:</h4>
                                <?php Facebook()->render_pixel_id( 'pixel_id', 'Meta Pixel ID' ); ?>
                                <div class="form-text mt-4">
                                    <a href="https://www.pixelyoursite.com/docs/meta-facebook-settings-setup"
                                       target="_blank" class="link link-small">How to get it?</a>
                                </div>
                            </div>

                            <div>
                                <h4 class="primary_heading mb-4">Conversion API:</h4>
                                <?php Facebook()->render_text_area_array_item( "server_access_api_token", "Api token" ) ?>
                            </div>

                            <div>
                                <p class="text-gray">
                                    Send events directly from your web server to Facebook through the Conversion
                                    API. This
                                    can help you capture more events. An access token is required to use the
                                    server-side
                                    API.
                                    <a href='https://www.pixelyoursite.com/strategy/facebook-conversion-api'
                                       target='_blank' class="link">Learn
                                        how to generate the token and how to test Conversion API</a>
                                </p>
                            </div>

                            <div>
                                <h4 class="primary_heading mb-4">Test Event Code:</h4>
                                <?php Facebook()->render_text_input_array_item( "test_api_event_code", "Code" ); ?>
                                <?php Facebook()->render_text_input_array_item( "test_api_event_code_expiration_at", "", 0, true ); ?>
                                <div class="mt-6">
                                    <p class="form-text text-small">
                                        Use this if you need to test the server-side event. <strong>Remove it after
                                            testing.</strong> The code will auto-delete itself after 24 hours.
                                    </p>
                                </div>
                            </div>

                            <div>
                                <?php if(isWPMLActive()) : ?>
                                    <p>
                                        <strong>WPML Detected. </strong> With the <a class="link" target="_blank" href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional?utm_medium=plugin&utm_campaign=multilingual">Advanced and Agency</a> licenses, you can fire a different pixel for each language.
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="line"></div>
                    <?php addMetaTagFields( Facebook(), "https://www.pixelyoursite.com/verify-domain-facebook" ); ?>
                    <div class="line"></div>
                </div>
           </div>
            <div class="line"></div>

            <input type="checkbox" class="general-settings-checkbox" id="ga_settings_switch" style="display: none">
            <div class="d-flex pixel-wrap align-items-center justify-content-between">
                <div class="pixel-heading d-flex justify-content-start align-items-center">
                    <img class="tag-logo" alt="meta-logo"
                         src="<?php echo PYS_FREE_URL; ?>/dist/images/google-analytics-logo.svg">
                    <div>
                        <h3 class="secondary_heading">Your Google Analytics</h3>
                        <?php
                        $noticeRenderNotSupportUA = false;
                        $noticeOnlyUA = true;
                        if ( GA()->enabled() && !empty( GA()->getOption( 'tracking_id' ) ) ) {
                            $trackingId = GA()->getOption( 'tracking_id' );
                            if ( !isGaV4( $trackingId ) ) {
                                $noticeRenderNotSupportUA = true;
                            } else {
                                $noticeOnlyUA = false;
                            }
                        }
                        if ( $noticeRenderNotSupportUA ) {
                            ?>
                            <div class="align-items-center not-supported mr-20 mt-4">
                                <?php
                                if ( $noticeOnlyUA ) {
                                    ?>
                                    <p class="lh-140">The old Universal Analytics properties are not supported by Google
                                        Analytics anymore. You must use the new GA4 properties instead.</p>
                                    <a class="lh-140 link link-underline"
                                       href="https://www.youtube.com/watch?v=KkiGbfl1q48"
                                       target="_blank">Watch this video to find how to get your GA4 tag</a>.
                                    <?php
                                } else {
                                    ?>
                                    <p class="lh-140">Your old Universal Analytics property doesn't send data anymore,
                                        consider removing it.
                                        Google Analytics supports only GA4 properties.
                                    </p>
                                    <a class="lh-140 link link-underline"
                                       href="https://www.youtube.com/watch?v=KkiGbfl1q48"
                                       target="_blank">Watch this video to find how to get your GA4 tag</a>.
                                    <?php
                                } ?>
                            </div>
                            <?php
                        } ?>
                    </div>
                </div>
                <div>
                    <label for="ga_settings_switch">
                        <?php include PYS_FREE_VIEW_PATH . '/UI/properties-button-off.php'; ?>
                    </label>
                </div>
            </div>
            <div class="settings_content_wrap">
                <div class="settings_content">
                    <div class="plate pixel_info mb-24">
                        <div class="d-flex align-items-center pixel-switcher-enabled mb-24">
                            <?php
                            GA()->render_switcher_input( "enabled" );
                            ?>
                            <h4 class="switcher-label secondary_heading">Enable Pixel</h4>
                        </div>

                        <div class="pixel-data-wrap">
                            <div class="d-flex align-items-center justify-content-between mb-24">
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(false); ?>
                                    <h4 class="switcher-label">Enable Measurement Protocol (add the api_secret)</h4>
                                </div>
                                <?php renderProBadge(); ?>
                            </div>
                            <div class="align-items-center">
                                <h4 class="primary_heading mb-4">Google Analytics tracking ID:</h4>
                                <?php GA()->render_pixel_id( 'tracking_id', 'Google Analytics tracking ID' ); ?>

                                <?php
                                $pixels = GA()->getPixelIDs();
                                if ( count( $pixels ) ) {
                                    ?>
                                    <div class="mt-6 text-small">
                                        <?php
                                        if ( strpos( $pixels[ 0 ], 'G' ) === 0 ) {
                                            echo '<span class="form-text text-small">We identified this tag as a GA4 property.</span>';
                                        } else {
                                            echo '<span class="not-support-tag form-text text-small">We identified this tag as a Google Analytics Universal property.</span>';
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="form-text mt-4">
                                    <a href="https://www.pixelyoursite.com/docs/google-analytics-ga4"
                                       target="_blank" class="link link-small">How to get it?</a>
                                </div>
                            </div>
                            <div>
                                <h4 class="primary_heading mb-8 d-flex align-items-center justify-content-between">Measurement Protocol API secret: <?php renderProBadge(); ?></h4>
                                <?php renderDummyTextInput("API secret") ?>
                            </div>
                            <div>
                                <p class="text-gray">
                                    Generate the API secret inside your Google Analytics account: navigate to <b>Admin
                                        > Data Streams > choose your stream > Measurement Protocol API secrets</b>.
                                    The Measurement Protocol is used for WooCommerce and Easy Digital Downloads
                                    "Google Analytics Advanced Purchase Tracking" and refund tracking. Required for
                                    GA4 properties only.
                                </p>
                            </div>

                            <div class="d-flex align-items-center">
                                <input type="text" class="custom-control-input"
                                       name="pys[ga][first_party_collection][-1]" value="0" checked/>
                                <?php GA()->render_checkbox_input( "first_party_collection", "First party cookies selector first_party_collection (recommended)" ); ?>
                            </div>
                            <div class="d-flex align-items-center">
                                <input type="checkbox" class="custom-control-input"
                                       name="pys[ga][is_enable_debug_mode][-1]" value="0" checked/>
                                <?php GA()->render_checkbox_input_array( "is_enable_debug_mode", "Enable Analytics Debug mode for this property" ); ?>
                            </div>
                            <div class="line-dark"></div>
                            <div class="d-flex flex-column">
                                <div class="d-flex">
                                    <input type="text" class="custom-control-input"
                                           name="pys[ga][enable_server_container][-1]" value="0" checked/>
                                    <?php GA()->render_switcher_input( "enable_server_container" ); ?>
                                    <h4 class="switcher-label secondary_heading">Enable Server container url
                                        (Beta)</h4>
                                </div>

                                <div class="form-text mt-12">
                                    Learn how to use it:
                                    <a href="https://www.youtube.com/watch?v=WZnmSoSJyBc"
                                       target="_blank"
                                       class="link"
                                    >watch video</a>
                                </div>
                            </div>

                            <div>
                                <h4 class="primary_heading mb-4">Server container url (optional):</h4>
                                <input type="text" class="custom-control-input"
                                       name="pys[ga][server_container_url][-1]" value="0" checked/>
                                <?php GA()->render_text_input_array_item( "server_container_url", "https://analytics.example.com", 0 ); ?>
                            </div>

                            <div>
                                <h4 class="primary_heading mb-4">Transport url (optional):</h4>
                                <input type="text" class="custom-control-input"
                                       name="pys[ga][transport_url][-1]" value="0" checked/>
                                <?php GA()->render_text_input_array_item( "transport_url", "https://tagging.mywebsite.com", 0 ); ?>
                            </div>

                            <div class="line-dark"></div>
                            <div>
                                <p class="text-gray pb-8">
                                    How to enable Google Consent Mode V2:
                                    <a href=https://www.pixelyoursite.com/google-consent-mode-v2-wordpress?utm_source=plugin&utm_medium=pro&utm_campaign=google-consent"
                                       target="_blank" class="link">click here</a>
                                </p>
                                <p class="text-gray pb-8">
                                    Learn how to get the Google Analytics 4 tag ID and how to test it:
                                    <a href="https://www.youtube.com/watch?v=KkiGbfl1q48" target="_blank"
                                       class="link">watch video</a>
                                </p>
                                <p class="text-gray pb-8">
                                    Install the old Google Analytics UA property and the new GA4 at the same time:
                                    <a href="https://www.youtube.com/watch?v=JUuss5sewxg" target="_blank"
                                       class="link">watch video</a>
                                </p>
                                <p class="text-gray">
                                    Learn how to get your Measurement Protocol API secret:
                                    <a href="https://www.youtube.com/watch?v=cURMzxY3JSg" target="_blank"
                                       class="link">watch video</a>
                                </p>
                            </div>
                            <div>
                                <?php if(isWPMLActive()) : ?>
                                    <p>
                                        <strong>WPML Detected. </strong> With the <a class="link" target="_blank" href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional?utm_medium=plugin&utm_campaign=multilingual">Advanced and Agency</a> licenses, you can fire a different pixel for each language.
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="line"></div>
            <div class="d-flex pixel-wrap align-items-center justify-content-between">
                <div class="pixel-heading d-flex justify-content-start align-items-center">
                    <img class="tag-logo" src="<?php echo PYS_FREE_URL; ?>/dist/images/google-ads-square-small.svg">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="link-feature-block">
                            <h3 class="secondary_heading">Add the Google Ads tag with the <a class="link"
                                                                                             href="https://www.pixelyoursite.com/google-ads-tag?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-ids"
                                                                                             target="_blank">pro version</a>.</h3>
                            <div class="text-gray">
                                How to enable Google Consent Mode V2:
                                <a class="link" href="https://www.pixelyoursite.com/google-consent-mode-v2-wordpress?utm_source=plugin&utm_medium=free&utm_campaign=google-consent" target="_blank">click here</a>
                            </div>
                            <div class="text-gray">
                                Learn how to install the Google Ads Tag:
                                <a class="link" href="https://www.youtube.com/watch?v=dft-TRigkj0" target="_blank">watch video</a>
                            </div>
                            <div class="text-gray">
                                How to configure Google Ads Conversions:
                                <a class="link" href="https://www.youtube.com/watch?v=5kb-jQe-Psg" target="_blank">watch video</a>
                            </div>
                            <div class="text-gray">
                                Lear how to use Enhanced Conversions:
                                <a class="link" href="https://www.youtube.com/watch?v=-bN5D_HJyuA" target="_blank">watch video</a>
                            </div>
                        </div>
                        <?php renderProBadge(); ?>
                    </div>
                </div>
            </div>

            <div class="line"></div>

            <div class="d-flex pixel-wrap align-items-center justify-content-between">
                <div class="pixel-heading d-flex justify-content-start align-items-center">
                    <img class="tag-logo" src="<?php echo PYS_FREE_URL; ?>/dist/images/tiktok-logo.svg">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="link-feature-block">
                            <h3 class="secondary_heading">Add the TikTok tag with the <a class="link"
                                                                                         href="https://www.pixelyoursite.com/google-ads-tag?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-ids"
                                                                                         target="_blank">pro version</a>.</h3>
                            <div class="text-gray">
                                How to install the TikTok tag and how to enable TikTok API: <a class="link" href="https://www.youtube.com/watch?v=OCSR6zacnFM" target="_blank">watch video</a>
                            </div>
                        </div>
                        <?php renderProBadge(); ?>

                    </div>
                </div>
            </div>

            <?php do_action( 'pys_admin_pixel_ids' ); ?>

        </div>
    </div>

    <div class="card card-style1 card-static">
        <div class="card-header card-header-style1 d-flex align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="font-semibold main-switcher">GTM Tag</h4>
            </div>
        </div>
        <div class="card-body">
            <input type="checkbox" class="general-settings-checkbox" id="gtm_settings_switch" style="display: none">
            <div class="d-flex pixel-wrap align-items-center justify-content-between">
                <div class="pixel-heading d-flex justify-content-start align-items-center">
                    <img class="tag-logo" src="<?php echo PYS_FREE_URL; ?>/dist/images/gtm-logo.svg" alt="gtm-logo">
                    <h3 class="secondary_heading">Your GTM Tag</h3>
                </div>
                <div>
                    <label for="gtm_settings_switch">
                        <?php include PYS_FREE_VIEW_PATH . '/UI/properties-button-off.php'; ?>
                    </label>
                </div>
            </div>

            <div class="settings_content_wrap">
                <div class="settings_content">
                    <div class="plate pixel_info mb-24">
                        <div class="d-flex align-items-center pixel-switcher-enabled mb-24">
                            <?php GTM()->render_switcher_input( 'enabled' ); ?>
                            <h4 class="switcher-label secondary_heading">Enable GTM</h4>
                        </div>
                        <div class="pixel-data-wrap">
                            <div>
                                <h4 class="primary_heading mb-4">GTM Tag:</h4>
								<?php GTM()->render_pixel_id( 'gtm_id', '' ); ?>
                            </div>
                            <div>
                                <div class="d-flex align-items-center">
                                    <?php GTM()->render_switcher_input( 'gtm_just_data_layer' ); ?>
                                    <h4 class="switcher-label secondary_heading"><?php _e( 'Send just the data layer', 'pys' ); ?></h4>
                                </div>
                            </div>

                            <div>
                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Beta version:</span>
                                    This feature is now in Beta and can change in the future.
                                </p>
                            </div>
                            <div>
                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Important:</span>
                                    <?php _e( 'Don\'t use GTM and our native integrations for the same tag/pixel ID. A pixel installed with the native integration must not be installed with GTM.', 'pys' ); ?>
                                </p>
                            </div>

                            <div class="line-dark"></div>
                            <?php $containers = new gtmContainers();
                            $download_template_nonce = wp_create_nonce('download_template_nonce');
                            if(!empty($containers)):
                                ?>
                                <div>
                                    <p class="primary-text-color primary_heading pb-8">
                                        <?php _e( 'GTM Container Import:', 'pys' ); ?>
                                    </p>
                                    <?php
                                    foreach ( $containers->getContainersForDisplay() as $container ) {
                                        if ( !$container[ 'enable' ] || empty( $container[ 'file_name' ] ) ) continue;
                                        ?>
                                        <p class="primary-heading-color mb-8">
                                            <a href="<?php echo esc_url( add_query_arg(['download_container' => $container['file_name'], '_wpnonce_template_logs' => $download_template_nonce],buildAdminUrl( 'pixelyoursite' ))); ?>"
                                               target="_blank"
                                               class="link"
                                               download><?php echo $container[ 'show_name' ]; ?></a><?php echo !empty( $container[ 'description' ] ) ? ' - ' . $container[ 'description' ] : ''; ?>
                                        </p>
                                        <?php
                                    } ?>
                                </div>
                                <p class="text-gray">
                                    <?php _e( 'Learn how to use the file: ', 'pys' ); ?>
                                    <a href="https://www.youtube.com/watch?v=qKJ3mmCgT3M" target="_blank"
                                       class="link">watch video</a>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <input type="checkbox" id="gtm_settings_switch" style="display: none">
        </div>
    </div>
    <div class="link_youtube">
        <div class="youtube_description">
            <img src="<?php echo PYS_FREE_URL; ?>/dist/images/youtube-logo.svg" alt="youtube-logo"/>
            <div>
                <p class="primary_heading">Subscribe to our YouTube Channel to learn how to use the plugin and improve
                    tracking</p>
            </div>
        </div>
        <div class="youtube_button">
            <?php renderBlackButton( 'Go to YouTube', 'https://www.youtube.com/channel/UCnie2zvwAjTLz9B4rqvAlFQ' ); ?>
        </div>
    </div>

    <!-- video -->
    <?php
    $videos = array(

      array(
          'url'   => 'https://www.youtube.com/watch?v=rmkZZcLxP2I',
          'title' => 'How to install the Reddit Pixel',
          'time'  => '4:19',
      ),

      array(
          'url'   => 'https://www.youtube.com/watch?v=Jm8dFTOLjJE',
          'title' => 'WooCommerce Google Ads Conversion Import',
          'time'  => '9:19',
      ),

      array(
          'url'   => 'https://www.youtube.com/watch?v=WUrl-2fgTxg',
          'title' => 'Fix SAFARI Google Ads Tracking - GCLID missing solution',
          'time'  => '4:59',
      ),
      array(
          'url'   => 'https://www.youtube.com/watch?v=eoJT1fSIar0',
          'title' => 'Google AUTOMATED Discounts + WooCommerce',
          'time'  => '14:26',
      ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=Wv6KhJQqFL4',
            'title' => 'HOT: Secret Trick to Boost Your Meta EMQ Score: Facebook Login Integration',
            'time'  => '6:20',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=wUsqwomsYMo',
            'title' => 'Conditions: Improved Event Tracking - Meta, Google, TikTok, GTM',
            'time'  => '5:09',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=kWozitdarSA',
            'title' => 'How to use Custom Events for Meta Ads',
            'time'  => '7:49',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=7BNHWbLbbdg',
            'title' => 'Meta Limited Data Use - Privacy Options for USA States - WordPress',
            'time'  => '6:17',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=bEK3qaaRvNg',
            'title' => 'Google Tag Manager and PixelYourSite',
            'time'  => '7:48',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=DZzFP4pSitU',
            'title' => 'Meta Pixel, CAPI, and PixelYourSite MUST WATCH',
            'time'  => '8:19',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=QqAIO1ONc0I',
            'title' => 'How to test Facebook Conversion API',
            'time'  => '10:16',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=kEp5BDg7dP0',
            'title' => 'How to fire EVENTS with PixelYourSite',
            'time'  => '22:28',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=EvzGMAvBnbs',
            'title' => 'How to create Meta (Facebook) Custom Audiences & Lookalikes based on Events & Parameters',
            'time'  => '21:53',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=w97FATUy7ok',
            'title' => 'How to configure Custom Conversions on Meta (Facebook) based on Events & Parameters',
            'time'  => '11:03',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=snUKcsTbvCk',
            'title' => 'Improve META (Facebook) EMQ score with form automatic data detection',
            'time'  => '11:48',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=c4Hrb8WK5bw',
            'title' => 'Fire a LEAD event on form submit - WordPress & PixelYourSite',
            'time'  => '5:58',
        ),
    );

    renderRecommendedVideo( $videos );
    ?>

    <!-- Global Events -->
    <div class="card card-style2">
        <div class="card-header card-header-style4 d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <?php PYS()->render_switcher_input( "automatic_events_enabled", false, false, false, 'primary' ); ?>
                <h4 class="font-semibold main-switcher ml-22">Track key actions with the automatic events</h4>
            </div>
            <div>
                <?php
                if ( !PYS()->getOption( 'automatic_events_enabled' ) ) {
                    cardCollapseBtn( 'style="display:none"', 'icon-settings' );
                } else {
                    cardCollapseBtn( '', 'icon-settings' );
                } ?>
            </div>
        </div>

        <div class="card-body global-events-body">
            <div class="global-events-list">
                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="d-flex align-items-center">
							<?php PYS()->render_switcher_input( 'automatic_event_form_enabled' ); ?>
                            <h4 class="card-heading secondary_heading">Track Forms</h4>
                        </div>
						<?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="gap-24">
                            <?php
                            enableEventForEachPixel( 'automatic_event_form', true, true, true, true, true, true, true );
                            ?>

                            <p>The Form event will fire when a form is successfully submitted for the following
                                plugins: Contact Form 7, Forminator, WP Forms, WS Forms, Formidable Pro, Ninja Forms,
                                and Fluent Forms. For forms added by different means, we will fire the event when the
                                submit button is clicked. Watch <a href="https://www.youtube.com/watch?v=c4Hrb8WK5bw"
                                                                   target="_blank" class="link">this video</a> to learn
                                more.
                            </p>

                            <p>Fires when the website visitor clicks form submit buttons.</p>

                            <?php
                            $eventsFormFactory = apply_filters( "pys_form_event_factory", [] );
                            if ( !empty( $eventsFormFactory ) ) : ?>
                                <div>
                                    <?php
                                    foreach ( $eventsFormFactory as $activeFormPlugin ) : ?>
                                        <p class="primary-heading-color detecting-form-description">
                                            <span class="primary-text-color primary_heading"><?php echo $activeFormPlugin->getName(); ?> detected</span>
                                            - we will fire the Form event for each successfully submitted form.
                                        </p>

                                    <?php endforeach; ?>
                                </div>
                            <?php endif;

                            if ( $eventsFormFactory ) :
                                ?>
                                <div>
                                    <?php PYS()->render_checkbox_input( 'enable_success_send_form', 'Fire the event only for the supported plugins, when the form is successfully submitted.' ); ?>
                                </div>
                                <p>Configure Lead or other events using our <a
                                            href="<?php echo buildAdminUrl( 'pixelyoursite', 'events' ); ?>"
                                            class="link">events
                                        triggers</a>. Learn how from <a
                                            href="https://www.youtube.com/watch?v=c4Hrb8WK5bw"
                                            target="_blank" class="link">this video</a></p>
                            <?php endif; ?>

                            <p class="primary-heading-color">
                                <span class="primary-text-color primary_heading">Event name:</span>
                                Form
                            </p>

	                        <?php if ( isRedditActive() ) : ?>
                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name on Reddit:</span>
                                    FormSubmit (custom event)
                                </p>
	                        <?php endif; ?>

                            <p class="primary-heading-color">
                                <span class="primary-text-color primary_heading">Specific parameters:</span>
                                <span class="purple-label">text</span>
                                <span class="purple-label">from_class</span>
                                <span class="purple-label">form_id</span>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'automatic_event_signup_enabled' ); ?>
                            <h4 class="card-heading secondary_heading">Track user signup</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>

                    <div class="card-body">
                        <div class="gap-24">
                            <?php if ( Facebook()->enabled() ) : ?>
                                <?php if ( isWooCommerceActive() && Facebook()->getOption( "woo_complete_registration_fire_every_time" ) ) : ?>
                                    <div class="d-flex align-items-center">
                                        <?php Facebook()->render_switcher_input( 'automatic_event_signup_enabled_disable', false, true );
                                        ?>

                                        <h4 class="switcher-label secondary_heading">Enable on Facebook</h4>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <p>
                                            Facebook CompleteReservation is fired every time a WooCommerce takes
                                            place.<br/>
                                            You can change this from the WooCommerce events
                                            <a href="<?= buildAdminUrl( 'pixelyoursite', 'woo' ) ?>" target="_blank"
                                               class="link">
                                                settings
                                            </a>
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex align-items-center">
                                        <?php Facebook()->render_switcher_input( 'automatic_event_signup_enabled' ); ?>
                                        <h4 class="switcher-label secondary_heading">Enable on Facebook</h4>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                        <?php if ( GA()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'automatic_event_signup_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable on Google Analytics</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Bing()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'automatic_event_signup_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable on Bing</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Pinterest()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'automatic_event_signup_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable on Pinterest</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Reddit()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php Reddit()->render_switcher_input( 'automatic_event_signup_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable on Reddit</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GTM()->enabled() ) : ?>
                            <div class="line"></div>
                                <div class="d-flex align-items-center">
                                    <?php GTM()->render_switcher_input('automatic_event_signup_enabled'); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on GTM dataLayer</h4>
                                </div>
                            <div class="line"></div>
                        <?php endif; ?>


                            <p>Fires when the website visitor signup for a WordPress account.</p>

                            <div>
                                <p class="primary-text-color primary_heading mb-8">Event name:</p>
                                <p class="primary-heading-color mb-8">On Google Analytics the event is called sign_up
                                    (standard
                                    event).</p>
                                <p class="primary-heading-color mb-8">On Facebook the event is called
                                    CompleteRegistration
                                    (standard event).</p>
                                <p class="primary-heading-color mb-8">On Pinterest the event is called Signup (standard
                                    event).</p>
                                <p class="primary-heading-color mb-8">On Bing the event is called sign_up (custom
                                    event).</p>
	                            <?php if ( isRedditActive() ) : ?>
                                    <p class="primary-heading-color mt-8">On Reddit the event is called SignUp (standard
                                        event).</p>
	                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'automatic_event_login_enabled' ); ?>
                            <h4 class="card-heading secondary_heading">Track user login</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="gap-24">
                            <?php
                            enableEventForEachPixel('automatic_event_login', true, true, true, true, true, false, true);
                            ?>
                            <p>Fires when the website visitor logins a WordPress account.</p>

                            <div>
                                <p class="primary-text-color primary_heading mb-8">Event name:</p>
                                <p class="primary-heading-color mb-8">On Google Analytics the event is called login
                                    (standard event).</p>
                                <p class="primary-heading-color mb-8">On Google Ads the event is called login (custom
                                    event).</p>
                                <p class="primary-heading-color mb-8">On Facebook, Pinterest, Bing<?php if ( isRedditActive() ) : ?>, Reddit<?php endif; ?> the event is
                                    called
                                    Login (custom event).</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'automatic_event_download_enabled' ); ?>
                            <h4 class="card-heading secondary_heading">Track Downloads</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="gap-24">
                            <?php
                            enableEventForEachPixel('automatic_event_download', true, true, true, true, true, true, true);
                            ?>
                            <div>
                                <div class="primary_heading">Extension of files to track as downloads:</div>
                                <?php PYS()->render_tags_select_input( 'automatic_event_download_extensions' ); ?>

                                <p class="form-text text-small mt-8">Fires when the website visitor open files with the
                                    designated format.</p>
                            </div>

                            <p class="primary-heading-color">
                                <span class="primary-text-color primary_heading">Event name:</span>
                                Download
                            </p>

	                        <?php if ( isRedditActive() ) : ?>
                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name on Reddit:</span>
                                    Download (custom event)
                                </p>
	                        <?php endif; ?>

                            <p class="primary-heading-color">
                                <span class="primary-text-color primary_heading">Specific parameters:</span>
                                <span class="purple-label">download_type</span>
                                <span class="purple-label">download_name</span>
                                <span class="purple-label">download_url</span>
                            </p>

                            <p class="form-text text-small">*Google Analytics 4 automatically tracks this action with an
                                event called "file_download". If you want, you can disable this event for Google
                                Analytics</p>
                        </div>
                    </div>
                </div>

                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'automatic_event_comment_enabled' ); ?>
                            <h4 class="card-heading secondary_heading">Track comments</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="gap-24">
                            <?php
                            enableEventForEachPixel('automatic_event_comment', true, true, true, true, true, false, true);
                            ?>
                            <p>Fires when the website visitor ads a comment.</p>

                            <p class="primary-heading-color">
                                <span class="primary-text-color primary_heading">Event name:</span>
                                Comment
                            </p>

	                        <?php if ( isRedditActive() ) : ?>
                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name on Reddit:</span>
                                    Comment (custom event)
                                </p>
	                        <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'automatic_event_scroll_enabled' ); ?>
                            <h4 class="card-heading secondary_heading">Track page scroll</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="gap-24">
                            <?php
                            enableEventForEachPixel('automatic_event_scroll', true, true, true, true, true, false, true);
                            ?>
                            <div class="d-flex align-items-center">
                                <label class="primary_heading mr-16">Trigger for scroll value</label>
                                <?php PYS()->render_number_input_percent( 'automatic_event_scroll_value', '', false, 100 ); ?>
                            </div>

                            <p>Fires when the website visitor scrolls the page.</p>

                            <p class="primary-heading-color">
                                <span class="primary-text-color primary_heading">Event name:</span>
                                PageScroll
                            </p>

	                        <?php if ( isRedditActive() ) : ?>
                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name on Reddit:</span>
                                    PageScroll (custom event)
                                </p>
	                        <?php endif; ?>

                            <p class="form-text text-small">*Google Analytics 4 automatically tracks 90% page scroll
                                with an event called "scroll". If you want, you can disable this event for Google
                                Analytics</p>
                        </div>
                    </div>
                </div>

                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'automatic_event_time_on_page_enabled' ); ?>
                            <h4 class="card-heading secondary_heading">Track time on page</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="gap-24">
                            <?php
                            enableEventForEachPixel('automatic_event_time_on_page', true, true, true, true, true, false, true);
                            ?>
                            <div class="d-flex align-items-center">
                                <label class="primary_heading mr-16">Trigger for time</label>
                                <?php PYS()->render_number_input( 'automatic_event_time_on_page_value', '', false, 100 ); ?>
                                <label class="ml-20">seconds</label>
                            </div>

                            <p class="primary-heading-color">
                                <span class="primary-text-color primary_heading">Event name:</span>
                                TimeOnPage
                            </p>

	                        <?php if ( isRedditActive() ) : ?>
                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name on Reddit:</span>
                                    TimeOnPage (custom event)
                                </p>
	                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'automatic_event_404_enabled' ); ?>
                            <h4 class="card-heading secondary_heading">Track 404 pages</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>

                    <div class="card-body">
                        <div class="gap-24">
                            <?php
                            enableEventForEachPixel('automatic_event_404', false, true, false, true, false, false, false);
                            ?>
                            <p class="primary-heading-color">
                                <span class="primary-text-color primary_heading">Event name:</span>
                                404
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'automatic_event_search_enabled' ); ?>
                            <h4 class="card-heading secondary_heading">Track searches</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="gap-24">
                            <?php
                            enableEventForEachPixel('automatic_event_search', true, true, true, true, true, true, true);
                            ?>
                            <div>
                                <p class="primary-text-color primary_heading mb-8">Event name:</p>
                                <p class="primary-heading-color mb-8">On Google Analytics the event is called search
                                    (standard
                                    event).</p>
                                <p class="primary-heading-color mb-8">On Google Ads the event is called search (custom
                                    event).</p>
                                <p class="primary-heading-color mb-8">On Facebook, Pinterest called Search (standard
                                    event).</p>
                                <p class="primary-heading-color mb-8">On Bing the event is called search (custom
                                    event).</p>
	                            <?php if ( isRedditActive() ) : ?>
                                    <p class="primary-heading-color mt-8">On Reddit the event is called Search (standard
                                        event).</p>
	                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="disable-card d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="card-heading secondary_heading">Track AdSense</h4>
                        </div>
                        <div class="d-flex align-items-center flex-collapse-block">
                            <?php renderProBadge(); ?>
                            <?php cardCollapseSettings(); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pro-feature-container">
                            <div class="gap-24">
                                <?php
                                DummyEventForEachPixel();
                                ?>

                                    <p>Fires when the website visitor clicks on an AdSense ad.</p>

                                    <p class="primary-heading-color">
                                        <span class="primary-text-color primary_heading">Event name:</span>
                                        AdSense
                                    </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="disable-card d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="card-heading secondary_heading">Track internal</h4>
                        </div>
                        <div class="d-flex align-items-center flex-collapse-block">
                            <?php renderProBadge(); ?>
                            <?php cardCollapseSettings(); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pro-feature-container">
                            <div class="gap-24">
                                <?php
                                    DummyEventForEachPixel();
                                ?>

                                <p>Fires when the website visitor clicks on internal links.</p>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name:</span>
                                    InternalClick
                                </p>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name on TikTok:</span>
                                    ClickButton
                                </p>

	                            <?php if ( isRedditActive() ) : ?>
                                    <p class="primary-heading-color">
                                        <span class="primary-text-color primary_heading">Event name on Reddit:</span>
                                        ClickButton (custom event)
                                    </p>
	                            <?php endif; ?>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Specific parameters:</span>
                                    <span class="purple-label">text</span>
                                    <span class="purple-label">target_url</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="disable-card d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="card-heading secondary_heading">Track outbound</h4>
                        </div>
                        <div class="d-flex align-items-center flex-collapse-block">
                            <?php renderProBadge(); ?>
                            <?php cardCollapseSettings(); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pro-feature-container">
                            <div class="gap-24">
                                <?php
                                DummyEventForEachPixel();
                                ?>

                                <p>Fire this event when the visitor clicks on links to other domains.</p>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name:</span>
                                    OutboundClick
                                </p>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name on TikTok:</span>
                                    ClickButton
                                </p>

	                            <?php if ( isRedditActive() ) : ?>
                                    <p class="primary-heading-color">
                                        <span class="primary-text-color primary_heading">Event name on Reddit:</span>
                                        ClickButton (custom event)
                                    </p>
	                            <?php endif; ?>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Specific parameters:</span>
                                    <span class="purple-label">text</span>
                                    <span class="purple-label">target_url</span>
                                </p>

                                <p class="form-text text-small">*Google Analytics 4 automatically tracks clicks on links to
                                    external
                                    domains with an event called "click". If you want, you can disable this event for Google
                                    Analytics</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="disable-card d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="card-heading secondary_heading">Track embedded YouTube or
                                Vimeo video views</h4>
                        </div>
                        <div class="d-flex align-items-center flex-collapse-block">
                            <?php renderProBadge(); ?>
                            <?php cardCollapseSettings(); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pro-feature-container">
                            <div class="gap-24">
                                <?php if ( Facebook()->enabled() ) : ?>
                                    <div class="d-flex align-items-center">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Enable on Facebook</h4>
                                    </div>
                                <?php endif; ?>

                                <?php if ( GA()->enabled() ) : ?>
                                    <div class="d-flex align-items-center">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Enable on Google Analytics</h4>
                                    </div>

                                    <div>
                                        <?php renderDummyCheckbox( "Disable YouTube videos for Google Analytics" ); ?>
                                    </div>
                                <?php endif; ?>


                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Google Ads</h4>
                                </div>

                                <?php if ( Bing()->enabled() ) : ?>
                                    <div class="d-flex align-items-center">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Enable on Bing</h4>
                                    </div>
                                <?php endif; ?>

                                <?php if ( Pinterest()->enabled() ) : ?>
                                    <div class="d-flex align-items-center">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Enable on Pinterest</h4>
                                    </div>
                                <?php endif; ?>


                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on TikTok</h4>
                                </div>

                                <div class="d-flex align-items-center">
                                    <label class="primary_heading mr-8">Trigger for scroll value</label><?php
                                    renderDummySelectInput( 'Play' ); ?>
                                </div>

                                <div>
                                    <?php renderDummyCheckbox('Track YouTube embedded video');?>
                                </div>

                                <div>
                                    <?php renderDummyCheckbox('Track Vimeo embedded video');?>
                                </div>

	                            <?php if ( Reddit()->enabled() ) : ?>
                                    <div class="d-flex align-items-center">
			                            <?php Reddit()->render_switcher_input( 'automatic_event_video_enabled' ); ?>
                                        <h4 class="switcher-label secondary_heading">Enable on Reddit</h4>
                                    </div>
	                            <?php endif; ?>

                                <?php if ( GTM()->enabled() ) : ?>
                                    <div class="d-flex align-items-center">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Enable on GTM dataLayer</h4>
                                    </div>
                                <?php endif; ?>

                                <p>Fires when the website visitor watches embedded YouTube or Vimeo
                                    videos.</p>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name:</span>
                                    WatchVideo
                                </p>

	                            <?php if ( isRedditActive() ) : ?>
                                    <p class="primary-heading-color">
                                        <span class="primary-text-color primary_heading">Event name on Reddit:</span>
                                        WatchVideo (custom event)
                                    </p>
	                            <?php endif; ?>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Specific parameters:</span>
                                    <span class="purple-label">progress</span>
                                    <span class="purple-label">video_type</span>
                                    <span class="purple-label">video_title</span>
                                    <span class="purple-label">video_id</span>
                                </p>

                                <p class="form-text text-small">*Google Analytics 4 automatically tracks YouTube embedded
                                    videos with two events called "video" and "video_progress". You can disable this event for
                                    Google Analytics YouTube videos.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="disable-card d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="card-heading secondary_heading">Track tel links</h4>
                        </div>
                        <div class="d-flex align-items-center flex-collapse-block">
                            <?php renderProBadge(); ?>
                            <?php cardCollapseSettings(); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pro-feature-container">
                            <div class="gap-24">
                                <?php
                                DummyEventForEachPixel();
                                ?>

                                <p>Fires when the website visitor clicks on HTML links marked with "tel".</p>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name:</span>
                                    TelClick
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-style6">
                    <div class="card-header card-header-style2 has_switch">
                        <div class="disable-card d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="card-heading secondary_heading">Track email links</h4>
                        </div>
                        <div class="d-flex align-items-center flex-collapse-block">
                            <?php renderProBadge(); ?>
                            <?php cardCollapseSettings(); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pro-feature-container">
                            <div class="gap-24">
                                <?php
                                DummyEventForEachPixel();
                                ?>

                                <p>Fires when the website visitor clicks on HTML links marked with "email".</p>

                                <p class="primary-heading-color">
                                    <span class="primary-text-color primary_heading">Event name:</span>
                                    EmailClick
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Ads for Blog Setup -->
    <div class="card card-style2">
        <div class="card-header card-header-style4 d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <?php PYS()->render_switcher_input( "fdp_enabled", false, false, false, 'primary' ); ?>
                <h4 class="font-semibold main-switcher ml-22">Dynamic Ads for Blog Setup</h4>
            </div>
            <div>
                <?php
                if ( !PYS()->getOption( 'fdp_enabled' ) ) {
                    cardCollapseBtn( 'style="display:none"', 'icon-settings' );
                } else {
                    cardCollapseBtn( '', 'icon-settings' );
                } ?>
            </div>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <p>Legacy Strategy: This approach is no longer recommended. Meta requires catalog items to be real
                        products, making dynamic promotion of blogs less effective. We plan to remove this feature in
                        future updates.</p>
                </div>
                <div class="line-dark"></div>
                <div>
                    <div class="mb-8 d-flex align-items-center">
                        <p>This setup will help you to run Facebook Dynamic Product Ads for your blog content.</p>
                    </div>

                    <div class="d-flex align-items-center">
                        <a href="https://www.pixelyoursite.com/facebook-dynamic-product-ads-for-wordpress"
                           target="_blank"
                           class="link">Click here to learn how to do it</a>
                    </div>
                </div>
                <?php if ( Facebook()->enabled() ) : ?>
                    <div class="line-dark"></div>
                        <div class="pro-feature-container d-flex align-items-center justify-content-between">
                            <div class="gap-24">
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">
                                        Fire this events just for this Pixel ID with the
                                        <a class="link" href="https://www.pixelyoursite.com/?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-ids" target="_blank">pro version</a>
                                    </h4>
                                </div>
                                <div>
                                    <h4 class="primary_heading mb-4">Meta Pixel ID:</h4>
                                    <?php renderDummyTextInput(  ); ?>
                                </div>
                            </div>
                            <?php renderProBadge();?>
                        </div>
                    <div class="line-dark"></div>

                    <div class="d-flex align-items-center">
                        <label class="primary_heading mr-8">Content type:</label><?php
                        $options = array(
                            'product' => 'Product',
                            ''        => 'Empty'
                        );
                        Facebook()->render_select_input( 'fdp_content_type', $options ); ?>
                    </div>

                    <div class="d-flex align-items-center">
                        <label class="primary_heading mr-8">Currency:</label><?php
                        $options = array();
                        $cur = getPysCurrencySymbols();
                        foreach ( $cur as $key => $val ) {
                            $options[ $key ] = $key;
                        }
                        Facebook()->render_select_input( 'fdp_currency', $options ); ?>
                    </div>

                    <div class="d-flex align-items-center">
                        <?php Facebook()->render_switcher_input( 'fdp_view_content_enabled' ); ?>

                        <h4 class="switcher-label secondary_heading">Enable the ViewContent on every blog page</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php Facebook()->render_switcher_input( 'fdp_view_category_enabled' ); ?>

                        <h4 class="switcher-label secondary_heading">Enable the ViewCategory on every blog
                            categories page</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php Facebook()->render_switcher_input( 'fdp_add_to_cart_enabled' ); ?>

                        <h4 class="switcher-label secondary_heading">Enable the AddToCart event on every blog
                            page</h4>
                    </div>

                    <div class="switcher-subinput gap-24">
                        <div class="d-flex align-items-center">
                            <label class="primary_heading mr-8">Value:</label>

                            <?php Facebook()->render_number_input( 'fdp_add_to_cart_value', "Value" ); ?>
                        </div>

                        <div class="d-flex align-items-center">
                            <label class="primary_heading mr-16">Fire the AddToCart event:</label>

                            <?php Facebook()->render_select_input( 'fdp_add_to_cart_event_fire', $options ); ?>
                            <span id="fdp_add_to_cart_event_fire_scroll_block" class="ml-16">
                                <?php Facebook()->render_number_input_percent( 'fdp_add_to_cart_event_fire_scroll', 50 ); ?>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <?php Facebook()->render_switcher_input( 'fdp_purchase_enabled' ); ?>

                        <h4 class="switcher-label secondary_heading">Enable the Purchase event on every blog
                            page</h4>
                    </div>

                    <div class="switcher-subinput gap-24">
                        <div class="d-flex align-items-center">
                            <label class="primary_heading mr-8">Value:</label>

                            <?php Facebook()->render_number_input( 'fdp_purchase_value', "Value" ); ?>
                        </div>

                        <div class="d-flex align-items-center">
                            <label class="primary_heading mr-16">Fire the Purchase event:</label>

                            <?php
                            $options = array(
                                'scroll_pos'    => 'Page Scroll',
                                'comment'     => 'User commented',
                                'css_click'     => 'Click on CSS selector',
                                //Default event fires
                            );
                            Facebook()->render_select_input( 'fdp_purchase_event_fire',$options ); ?>
                            <span id="fdp_purchase_event_fire_scroll_block" class="ml-16">
                                    <?php Facebook()->render_number_input_percent( 'fdp_purchase_event_fire_scroll', 50 ); ?>
                                </span>

                            <span class="ml-24">
                                    <?php Facebook()->render_text_input( 'fdp_purchase_event_fire_css', "CSS selector" ); ?>
                                </span>
                        </div>
                    </div>
                    <p class="primary-heading-color">
                        <span class="primary-text-color primary_heading">You need to upload your blog posts into a Facebook Product Catalog.</span>
                        You can do this with our dedicated plugin: <a
                                href="https://www.pixelyoursite.com/wordpress-feed-facebook-dpa" target="_blank"
                                class="link">Click
                            Here</a>
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>


    <!-- Control global param -->
    <div class="card card-style2">
        <div class="card-header card-header-style4 d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <h4 class="font-semibold main-switcher">Control the Global Parameters</h4>
            </div>
            <?php cardCollapseBtn( '', 'icon-settings' ); ?>
        </div>
        <div class="card-body" >
            <div class="mb-24 d-flex align-items-center">
                <p>You will have these parameters for all events, and for all installed tags. We recommend to
                    keep these parameters active, but if you start to get privacy warnings about some of them,
                    you can turn those parameters OFF.</p>
            </div>
            <div class="global-parameters mb-18">
                <div class="global-parameter-item">
                    <div class="global-parameter-inputs">
                        <?php PYS()->render_switcher_input( "enable_page_title_param" ); ?>
                        <h4 class="font-semibold ml-16">page_title</h4>
                    </div>
                </div>
                <div class="global-parameter-item">
                    <div class="global-parameter-inputs">
                        <?php PYS()->render_switcher_input( "enable_post_type_param" ); ?>
                        <h4 class="font-semibold ml-16">post_type</h4>
                    </div>
                </div>
                <div class="global-parameter-item">
                    <div class="global-parameter-inputs">
                        <?php PYS()->render_switcher_input( 'enable_post_category_param' ); ?>
                        <h4 class="font-semibold ml-16">post_category</h4>
                    </div>
                </div>
                <div class="global-parameter-item">
                    <div class="global-parameter-inputs">
                        <?php PYS()->render_switcher_input( "enable_post_id_param" ); ?>
                        <h4 class="font-semibold switcher-label ml-16">post_id</h4>
                    </div>
                </div>
                <div class="global-parameter-item">
                    <div class="global-parameter-inputs">
                        <?php PYS()->render_switcher_input( 'enable_content_name_param' ); ?>
                        <h4 class="font-semibold switcher-label ml-16">content_name</h4>
                    </div>
                </div>
                <div class="global-parameter-item">
                    <div class="global-parameter-inputs">
                        <?php PYS()->render_switcher_input( 'enable_event_url_param' ); ?>
                        <h4 class="font-semibold switcher-label ml-16">event_url</h4>
                    </div>
                </div>

                <div class="global-parameter-item">
                    <div class="global-parameter-inputs">
                        <?php PYS()->render_switcher_input( 'enable_user_role_param' ); ?>
                        <h4 class="font-semibold switcher-label ml-16">user_role</h4>
                    </div>
                </div>

                <div class="global-parameter-item global-parameter-item-pro">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="font-semibold switcher-label ml-16">landing_page (PRO)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/crown.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>

                <div class="global-parameter-item global-parameter-item-pro">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="font-semibold switcher-label ml-16">event_time (PRO)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/crown.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>
                <div class="global-parameter-item global-parameter-item-pro">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="font-semibold switcher-label ml-16">event_day (PRO)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/crown.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>
                <div class="global-parameter-item global-parameter-item-pro">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="font-semibold switcher-label ml-16">event_month (PRO)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/crown.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>
                <div class="global-parameter-item global-parameter-item-pro">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="font-semibold switcher-label ml-16">traffic_source (PRO)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/crown.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>
                <div class="global-parameter-item global-parameter-item-pro">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="font-semibold switcher-label ml-16">UTMs (PRO)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/crown.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>
                <div class="global-parameter-item global-parameter-item-pro">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="font-semibold switcher-label ml-16">tags (PRO)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/crown.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>
                <div class="global-parameter-item global-parameter-item-pro">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="font-semibold switcher-label ml-16">categories (PRO)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/crown.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>
                <div class="global-parameter-item">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher( true ); ?>
                        <h4 class="font-semibold switcher-label ml-16">search (mandatory)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/alert.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>

                <div class="global-parameter-item">
                    <div class="global-parameter-inputs">
                        <?php renderDummySwitcher( true ); ?>
                        <h4 class="font-semibold switcher-label ml-16">plugin (mandatory)</h4>
                    </div>

                    <div class="global-parameter-property">
                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/alert.svg" alt="crown"
                             class="global-parameter-property-icon">
                    </div>
                </div>
            </div>
            <!-- About params -->
            <div class=" card card-style3 about-params">
                <div class="card-header card-header-style2">
                    <div class="d-flex align-items-center">
                        <i class="icon-Info"></i>
                        <h4 class="heading-with-icon bold-heading">About Parameters:</h4>
                    </div>
                </div>

                <div class="card-body" style="display: block;">
                    <div class="gap-24">
                        <p>Parameters add extra information to events.

                        <p>They help you create Custom Audiences or Custom Conversions on Facebook, Goals, and
                            Audiences on Google,
                            Audiences on Pinterest, Conversions on Bing.</p>

                        <p>The plugin tracks the following parameters by default for all the events and for
                            all installed
                            tags: <span class="parameters-list">page_title, post_type, post_id, landing_page, event_url, user_role, plugin, event_time (pro),
                            event_day (pro), event_month (pro), traffic_source (pro), UTMs (pro).</span></p>

                        <p>Facebook, Pinterest, and Google Ads Page View event also tracks the following
                            parameters: <span class="parameters-list">tags,
                            category</span>.</p>

                        <p>You can add extra parameters to events configured on the Events tab. WooCommerce or
                            Easy Digital
                            Downloads events will have the e-commerce parameters specific to each tag.</p>

                        <p>The Search event has the specific search parameter.</p>

                        <p>The automatic events have various specific parameters, depending on the action that fires the
                            event.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

<script>
    jQuery( document ).ready( function ( $ ) {
        $( document ).on( 'click', '.remove-meta-row', function () {
            $( this ).closest( '.meta-block' ).remove();
        } );
    } );
    document.addEventListener( "DOMContentLoaded", function () {
        //global disable
        const mainCheckbox = document.getElementById( "pys_core_enable_all_tracking_ids" );
        const mainParentCard = mainCheckbox.closest( ".card" );
        const cardBody = mainParentCard.querySelector( ".card-body" );

        function setCardBodyState( isEnabled, cardBody ) {
            if ( isEnabled ) {
                cardBody.classList.remove( "disabled" );
                cardBody.style.pointerEvents = "auto";
                cardBody.style.opacity = "1";
                cardBody.querySelectorAll( "input:not(.disabled), select:not(.disabled), textarea:not(.disabled), button:not(.disabled)" ).forEach( function ( element ) {
                    element.removeAttribute( "disabled" );
                } );
            } else {
                cardBody.classList.add( "disabled" );
                cardBody.style.pointerEvents = "none";
                cardBody.style.opacity = "0.2";
                cardBody.querySelectorAll( "input:not(.disabled), select:not(.disabled), textarea:not(.disabled), button:not(.disabled)" ).forEach( function ( element ) {
                    element.setAttribute( "disabled", "disabled" );
                } );
            }
        }

        // Set the initial state
        setCardBodyState( mainCheckbox.checked, cardBody );

        // Checkbox state change handler
        mainCheckbox.addEventListener( "change", function () {
            setCardBodyState( this.checked, cardBody );
        } );

        //pixel disable
        const checkboxesPixel = document.querySelectorAll( "#pys .pixel-switcher-enabled .custom-switch-input" );

        checkboxesPixel.forEach( checkbox => {
            const parentCardPixel = checkbox.closest( ".pixel_info" );
            const cardBodyPixel = parentCardPixel.querySelector( ".pixel-data-wrap" );
            // Set the initial state
            setCardBodyState( checkbox.checked, cardBodyPixel );
        } );

        document.addEventListener( "change", function ( event ) {
            if ( event.target && event.target.matches( "#pys .pixel-switcher-enabled .custom-switch-input" ) ) {
                const parentCardPixel = event.target.closest( ".pixel_info" );
                const cardBodyPixel = parentCardPixel.querySelector( ".pixel-data-wrap" );

                setCardBodyState( event.target.checked, cardBodyPixel );
            }
        } );
    } );
</script>
<?php
	function enableEventForEachPixel( $event, $fb = true, $ga = true, $ads = true, $gtm = true, $bi = true, $tic = true, $pin = true, $red = true ) { ?>
        <div class="gap-24">
			<?php if ( $fb && Facebook()->enabled() ) : ?>
                <div class="d-flex align-items-center">
					<?php Facebook()->render_switcher_input( $event . '_enabled' ); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Facebook</h4>
                </div>
			<?php endif; ?>

			<?php if ( $ga && GA()->enabled() ) : ?>
                <div class="d-flex align-items-center">
					<?php GA()->render_switcher_input( $event . '_enabled' ); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Google Analytics</h4>
                </div>
			<?php endif; ?>

			<?php if ( $bi && Bing()->enabled() ) : ?>
                <div class="d-flex align-items-center">
					<?php Bing()->render_switcher_input( $event . '_enabled' ); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Bing</h4>
                </div>
			<?php endif; ?>

			<?php if ( $pin && Pinterest()->enabled() ) : ?>
                <div class="d-flex align-items-center">
					<?php Pinterest()->render_switcher_input( $event . '_enabled' ); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Pinterest</h4>
                </div>
			<?php endif; ?>

	        <?php if ( $red && Reddit()->enabled() ) : ?>
                <div class="d-flex align-items-center">
			        <?php Reddit()->render_switcher_input( $event . '_enabled' ); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Reddit</h4>
                </div>
	        <?php endif; ?>

			<?php if ( $gtm && GTM()->enabled() ) : ?>
                <div class="d-flex align-items-center">
					<?php GTM()->render_switcher_input( $event . '_enabled' ); ?>
                    <h4 class="switcher-label secondary_heading">Enable on GTM dataLayer</h4>
                </div>
			<?php endif; ?>
        </div>
		<?php
	}
    function DummyEventForEachPixel()
    { ?>
        <div class="gap-24">
			<?php if ( Facebook()->enabled() ) : ?>
                <div class="d-flex align-items-center">
					<?php renderDummySwitcher(); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Facebook</h4>
                </div>
			<?php endif; ?>

			<?php if ( GA()->enabled() ) : ?>
                <div class="d-flex align-items-center">
                    <?php renderDummySwitcher(); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Google Analytics</h4>
                </div>
			<?php endif; ?>

			<?php if ( Bing()->enabled() ) : ?>
                <div class="d-flex align-items-center">
                    <?php renderDummySwitcher(); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Bing</h4>
                </div>
			<?php endif; ?>

			<?php if ( Pinterest()->enabled() ) : ?>
                <div class="d-flex align-items-center">
                    <?php renderDummySwitcher(); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Pinterest</h4>
                </div>
			<?php endif; ?>

	        <?php if ( Reddit()->enabled() ) : ?>
                <div class="d-flex align-items-center">
			        <?php renderDummySwitcher(); ?>
                    <h4 class="switcher-label secondary_heading">Enable on Reddit</h4>
                </div>
	        <?php endif; ?>

			<?php if ( GTM()->enabled() ) : ?>
                <div class="d-flex align-items-center">
                    <?php renderDummySwitcher(); ?>
                    <h4 class="switcher-label secondary_heading">Enable on GTM dataLayer</h4>
                </div>
			<?php endif; ?>
        </div>
		<?php
    }
	?>

</div>
