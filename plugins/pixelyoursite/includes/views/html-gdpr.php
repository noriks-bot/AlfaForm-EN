<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>


<!-- Consent Magic -->
<div class="cards-wrapper cards-wrapper-style1 gap-24 gdrp-wrapper">
    <div class="card about-params card-style3">
        <div class="card-header card-header-style2">
            <div class="d-flex align-items-center">
                <i class="icon-Info"></i>
                <h4 class="heading-with-icon bold-heading">Consent Magic - Recommended</h4>
            </div>
        </div>
        <div class="card-body" style="display: block;">
            <?php if ( isConsentMagicPluginInstalled() ) : ?>
                <?php if ( isConsentMagicPluginActivated() ) : ?>
                    <div class="row">
                        <div class="col">
                            Manage your consent settings with
                            <?php if ( isConsentMagicPluginLicenceActivated() ) { ?>
                                <a href="<?= admin_url( "admin.php?page=consent-magic" ) ?>" class="link">Consent Magic.</a>
                            <?php } else { ?>
                                <a href="<?= admin_url( "admin.php?page=cs-license" ) ?>" class="link">Consent Magic.</a>
                            <?php } ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col">
                            You have Consent Magic installed, but it’s not activated yet. Go to the Plugins page and
                            activate
                            <a href="<?= admin_url( "plugins.php" ) ?>" class="link">Consent Magic.</a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="row">
                    <div class="col flex-column-24gap">
                        <p>Ask for consent the right way, block scripts and cookies when required.</p>
                        <p><strong>Manage different type of consent:</strong></p>
                        <ul class="pys_list">
                            <li><strong>Ask before tracking:</strong> show a consent message and block the tracking scripts
                                before the
                                visitor expresses consent - ideal for GDPR.
                            </li>
                            <li><strong>Inform and opt out:</strong> show a consent message, and block the tracking scripts
                                if the visitor
                                doesn’t agree to tracking - ideal for CCPA.
                            </li>
                            <li><strong>Just inform:</strong> show a non-intrusive message informing your visitors about
                                tracking.
                            </li>
                        </ul>
                        <p><strong>Use geo-targeted rules:</strong></p>
                        <p>Target your visitors with the right rule based on their location. Rules can have different
                            consent types
                            and different content. The plugin comes with the ready-made rules:</p>
                        <ul class="pys_list">
                            <li><strong>GDPR rule:</strong> targets visitors from GDPR countries, and uses Ask before
                                tracking consent
                                type.
                            </li>
                            <li>
                                <strong>LDU rule:</strong> uses Meta Limited Data Use Flag and targets visitors from US supported states.
                            </li>
                            <li><strong>Rest of the world rule:</strong> targets visitors from other locations and uses Just
                                inform consent
                                type
                            </li>
                            <li><strong>Your own rule:</strong> create any rules you need, target any countries, and use
                                custom text for them.
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="mt-24">
                    <a href="https://www.pixelyoursite.com/plugins/consentmagic/?utm_source=pixelyoursite-pro&utm_medium=pixelyoursite-pro&utm_campaign=pixelyoursite-pro&utm_content=pixelyoursite-pro&utm_term=pixelyoursite-pro"
                       target="_blank" class="btn btn-sm btn-primary btn-primary-type2 learn-more-btn">
                        Lean more about Consent Magic
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- video -->
    <?php
    $video_block_title = 'Recommended Consent Videos:';
    $videos = array(
        array(
            'url'   => 'https://www.youtube.com/watch?v=uXTpgFu2V-E',
            'title' => 'The biggest problem with consent messages',
            'time'  => '7:02'
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=L_YYjrmxykU',
            'title' => 'Improve tracking under GDPR consent with this smart option',
            'time'  => '5:31'
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=ZOlNbIPS_Uc',
            'title' => 'Target your visitors with the right consent rule',
            'time'  => '12:29'
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=P8CLxslSPDk',
            'title' => 'The right to change your mind',
            'time'  => '2:46'
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=PsKdCkKNeLU',
            'title' => 'Facebook Conversion API and the Consent Problem',
            'time'  => '9:25'
        ),
        array(  // NEW
            'url'   => 'https://www.youtube.com/watch?v=7BNHWbLbbdg',
            'title' => 'Meta Limited Data Use - Privacy Options for USA States - WordPress',
            'time'  => '6:17'
        ),
    );


    renderRecommendedVideo( $videos, $video_block_title );
    ?>

    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">Other consent plugins:</h4>
            </div>
            <div class="d-flex align-items-center flex-collapse-block">
                <?php cardCollapseSettings(); ?>
            </div>
        </div>

        <div class="card-body">
            <div class="gap-24">
                <div class="card about-params card-style3">
                    <div class="card-header card-header-style2">
                        <div class="d-flex align-items-center">
                            <i class="icon-Info"></i>
                            <h4 class="heading-with-icon bold-heading">Note</h4>
                        </div>
                    </div>
                    <div class="card-body" style="display: block">
                        <div class="row">
                            <div class="col flex-column-24gap">
                                <p>You can use third-party consent plugins.
                                    Below is a list of WordPress consent plugins known to be compatible.
                                    However, we cannot guarantee they’ll handle consent correctly in all cases,
                                    and we’re unable to provide support for them.
                                    <b>For any issues, please contact the plugin’s support team directly.</b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cookiebot -->
                <div class="card card-style6 consent-plugin-card">
                    <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                        <div class="disable-card align-items-center">
                            <?php if ( !isCookiebotPluginActivated() ) : ?>
                                <h4 class="secondary_heading_type2">Cookiebot <span class="text-danger">[not detected]</span></h4>
                            <?php else: ?>
                                <h4 class="secondary_heading_type2">Cookiebot <span class="text-success">[detected]</span></h4>
                            <?php endif; ?>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="mb-24 flex-column-24gap">
                            <p>This is a complete premium solution that also offers a free plan for websites with under 100 pages.
                                For implementation, we suggest you follow their documentation.</p>
                            <p>
                                <span class="mb-8">Website: <a href="https://cookiebot.com" class="link" target="_blank">https://cookiebot.com</a></span>
                                <span>Plugin: <a href="https://wordpress.org/plugins/cookiebot/" class="link" target="_blank">https://wordpress.org/plugins/cookiebot/</a></span>
                            </p>
                        </div>
                        <div class="d-flex align-items-center mb-24">
                            <?php PYS()->render_switcher_input( 'gdpr_cookiebot_integration_enabled', false, !isCookiebotPluginActivated() ); ?>
                            <h4 class="switcher-label secondary_heading">Enable Cookiebot integration</h4>
                        </div>
                        <div class="mb-24">
                            <div class="mb-8">
                                <label class="primary_heading">Meta Pixel (formerly Facebook Pixel) consent category:</label>
                            </div>
                            <?php PYS()->render_text_input(  'gdpr_cookiebot_facebook_consent_category', 'Enter consent category', !isCookiebotPluginActivated(), false, false, 'medium' ); ?>
                        </div>

                        <div class="mb-24">
                            <div class="mb-8">
                                <label class="primary_heading">Google Analytics consent category:</label>
                            </div>
                            <?php PYS()->render_text_input(  'gdpr_cookiebot_analytics_consent_category', 'Enter consent category', !isCookiebotPluginActivated(), false, false, 'medium' ); ?>
                            <p class="text-gray mt-8">
                                * If you have advertising features enabled, enter "marketing"
                            </p>
                        </div>
                        <div class="mb-24">
                            <div class="mb-8">
                                <label class="primary_heading">Google Ads consent category:</label>
                            </div>
                            <?php PYS()->render_text_input(  'gdpr_cookiebot_google_ads_consent_category', 'Enter consent category', !isCookiebotPluginActivated(), false, false, 'medium' ); ?>
                        </div>
                        <div class="mb-24">
                            <div class="mb-8">
                                <label class="primary_heading">Pinterest Tag consent category:</label>
                            </div>
                            <?php PYS()->render_text_input(  'gdpr_cookiebot_pinterest_consent_category', 'Enter consent category', !isCookiebotPluginActivated(), false, false, 'medium' ); ?>
                        </div>
                        <div class="mb-24">
                            <div class="mb-8">
                                <label class="primary_heading">Bing consent category:</label>
                            </div>
                            <?php PYS()->render_text_input(  'gdpr_cookiebot_bing_consent_category', 'Enter consent category', !isCookiebotPluginActivated(), false, false, 'medium' ); ?>
                        </div>
                        <div>
                            <div class="mb-8">
                                <label class="primary_heading">Tiktok consent category:</label>
                            </div>
                            <?php PYS()->render_text_input(  'gdpr_cookiebot_tiktok_consent_category', 'Enter consent category', !isCookiebotPluginActivated(), false, false, 'medium' ); ?>
                        </div>
                    </div>
                </div>

                <!-- Cookie Notice -->
                <div class="card card-style6 consent-plugin-card">
                    <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                        <div class="disable-card align-items-center">
                            <?php if ( !isCookieNoticePluginActivated() ) : ?>
                                <h4 class="secondary_heading_type2">Cookie Notice <span class="text-danger">[not detected]</span></h4>
                            <?php else: ?>
                                <h4 class="secondary_heading_type2">Cookie Notice <span class="text-success">[detected]</span></h4>
                            <?php endif; ?>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="mb-24 flex-column-24gap">
                            <p>Free plugin with various features, including the option to store negative consent.</p>
                            <p>Plugin: <a href="https://wordpress.org/plugins/cookie-notice/" class="link" target="_blank">https://wordpress.org/plugins/cookie-notice/</a></p>
                        </div>
                        <div class="d-flex align-items-center mb-24">
                            <?php PYS()->render_switcher_input( 'gdpr_cookie_notice_integration_enabled', false, !isCookieNoticePluginActivated() ); ?>
                            <h4 class="switcher-label secondary_heading">Cookie Notice integration</h4>
                        </div>
                    </div>
                </div>

                <!-- Cookie Law Info -->
                <div class="card card-style6 consent-plugin-card">
                    <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                        <div class="disable-card align-items-center">
                            <?php if ( !isCookieLawInfoPluginActivated() ) : ?>
                                <h4 class="secondary_heading_type2">CookieYes <span class="text-danger">[not detected]</span></h4>
                            <?php else: ?>
                                <h4 class="secondary_heading_type2">CookieYes <span class="text-success">[detected]</span></h4>
                            <?php endif; ?>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="mb-24 flex-column-24gap">
                            <p>Free plugin useful features, including the option to store negative consent.</p>
                            <p>Plugin: <a href="https://wordpress.org/plugins/cookie-law-info/" class="link" target="_blank">https://wordpress.org/plugins/cookie-law-info/</a></p>
                            <p>The options to track pixels before consent is captured won't work with this plugin because it has its own integration with PixelYourSite.</p>
                        </div>
                        <div class="d-flex align-items-center mb-24">
                            <?php PYS()->render_switcher_input( 'gdpr_cookie_law_info_integration_enabled', false, !isCookieLawInfoPluginActivated() ); ?>
                            <h4 class="switcher-label secondary_heading">CookieYes integration</h4>
                        </div>
                    </div>
                </div>

                <!-- Real Cookie Banner -->
                <div class="card card-style6 consent-plugin-card">
                    <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                        <div class="disable-card align-items-center">
                            <?php if ( !isRealCookieBannerPluginActivated() ) : ?>
                                <h4 class="secondary_heading_type2">Real Cookie Banner <span class="text-danger">[not detected]</span></h4>
                            <?php else: ?>
                                <h4 class="secondary_heading_type2">Real Cookie Banner <span class="text-success">[detected]</span></h4>
                            <?php endif; ?>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>
                    <div class="card-body">
                        <div class="mb-24 flex-column-24gap">
                            <p>Real Cookie Banner is an opt-in cookie and consent management plugin</p>
                            <p>Plugin: <a href="https://wordpress.org/plugins/real-cookie-banner/" class="link" target="_blank">https://wordpress.org/plugins/real-cookie-banner/</a></p>
                        </div>
                        <div class="d-flex align-items-center mb-24">
                            <?php PYS()->render_switcher_input( 'gdpr_real_cookie_banner_integration_enabled', false, !isRealCookieBannerPluginActivated() ); ?>
                            <h4 class="switcher-label secondary_heading">Real Cookie Banner Consent integration</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- API -->
    <div class="card card-style5 consent-plugins">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">For Developers</h4>
            </div>
            <div>
                <?php cardCollapseSettings(); ?>
            </div>
        </div>
        <div class="card-body" style="display: none;">
            <div class="gap-24">
                <div class="d-flex align-items-center">
                    <?php PYS()->render_switcher_input( 'gdpr_ajax_enabled'); ?>
                    <h4 class="switcher-label secondary_heading">Enable AJAX filter values update</h4>
                </div>
                <p>
                    Use <span class="event-parameter-list">pys_gdpr_ajax_enabled</span> filter to by-pass option above.
                </p>
                <p>
                    Use following filters to control each pixel:
                    <span class="event-parameter-list">pys_disable_by_gdpr</span>, <span class="event-parameter-list">pys_disable_facebook_by_gdpr</span>,
                    <span class="event-parameter-list">pys_disable_analytics_by_gdpr</span>, <span class="event-parameter-list">pys_disable_tiktok_by_gdpr</span>, <span class="event-parameter-list">pys_disable_google_ads_by_gdpr</span>,
                    <span class="event-parameter-list">pys_disable_pinterest_by_gdpr</span>, <span class="event-parameter-list">pys_disable_bing_by_gdpr</span> or <span class="event-parameter-list">pys_disable_reddit_by_gdpr</span>.
                </p>
                <p>First filter will disable all pixels, other can be used to disable particular pixel.
                    Simply pass <span class="event-parameter-list">TRUE</span> value to disable a pixel.
                </p>
                <hr>
                <p class="primary-text-color bold-heading">
                    Use the following filters to control each cookie:
                </p>
                <ul>
                    <li>
                        <span class="event-parameter-list">pys_disable_all_cookie</span> - disable all PYS cookies
                    </li>
                    <li>
                        <span class="event-parameter-list">pys_disabled_start_session_cookie</span> - disable start_session & session_limit cookie
                    </li>
                    <li>
                        <span class="event-parameter-list">pys_disable_first_visit_cookie</span> - disable pys_first_visit cookie
                    </li>
                    <li>
                        <span class="event-parameter-list">pys_disable_landing_page_cookie</span> - disable pys_landing_page & last_pys_landing_page cookies
                    </li>
                    <li>
                        <span class="event-parameter-list">pys_disable_trafficsource_cookie</span> - disable pysTrafficSource & last_pysTrafficSource cookies
                    </li>
                    <li>
                        <span class="event-parameter-list">pys_disable_utmTerms_cookie</span> - disable ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'] with prefix <span class="event-parameter-list">pys_</span> and <span class="event-parameter-list">last_pys_</span> cookies
                    </li>
                    <li>
                        <span class="event-parameter-list">pys_disable_utmId_cookie</span> - disable ['fbadid', 'gadid', 'padid', 'bingid'] with prefix <span class="event-parameter-list">pys_</span> and <span class="event-parameter-list">last_pys_</span> cookies
                    </li>
                    <li>
                        <span class="event-parameter-list">pys_disable_advance_data_cookie</span> - disable pys_advanced_data cookies
                    </li>
                    <li>
                        <span class="event-parameter-list">pys_disable_externalID_by_gdpr</span> - disable pbid(external_id) cookie
                    </li>
                </ul>
                <div>
                    <p class="mb-8">
                        To disable cookies, use filters where necessary.<br>
                        First filter will disable all cookies, other can be used to disable particular cookie.
                        Simply pass <span class="event-parameter-list">__return_true</span> value to disable a cookie.
                    </p>
                    <p>
                        Example:<br>
                        <span class="event-parameter-list">add_filter( 'pys_disable_advance_data_cookie', '__return_true', 10, 2 );</span>
                    </p>
                </div>
                <div>
                    <p class="mb-8">Use these filters to add Google Consent Mode V2 support:</p>

                    <p>
                        <span class="event-parameter-list">pys_{mode name}_mode</span> - Fire pixel with Google consent mode<br>
                        {mode name} - analytics_storage, ad_storage, ad_user_data, ad_personalization
                    </p>
                    <p class="mb-8">
                        Example:<br>
                        <span class="event-parameter-list">add_filter( 'pys_analytics_storage_mode', '__return_true' );</span>
                    </p>
                    <p>Fire the pixel with consent mode "analytics_storage": "granted"</p>
                </div>
                <div>
                    <p class="mb-8">The filter turn ON/OFF Meta Limited Data Use option:</p>
                    <p>
                        Example:<br>
                        <span class="event-parameter-list">add_filter('pys_meta_ldu_mode','__return_true');</span>
                    </p>
                </div>

                <div>
                    <p class="mb-8">The filter turn ON/OFF Reddit Limited Data Use option:</p>
                    <p>
                        Example:<br>
                        <span class="event-parameter-list">add_filter('pys_reddit_ldu_mode','__return_true');</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>