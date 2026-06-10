<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use PixelYourSite\GA\Helpers;

?>

<div class="cards-wrapper cards-wrapper-style2 gap-24 settings-wrapper">
    <!-- General -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('General', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center mb-24">
                        <?php PYS()->render_switcher_input('google_consent_mode'); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Fire Google tags with consent mode granted', 'pys');?></h4>
                    </div>
                    <p class="text-gray">
                        <?php _e('How to enable Google Consent Mode V2', 'pys');?>
                        <a class="link" href="https://www.pixelyoursite.com/google-consent-mode-v2-wordpress?utm_source=plugin&utm_medium=pro&utm_campaign=google-consent" target="_blank"><?php _e('click here', 'pys');?></a>
                    </p>
                </div>
                <div class="line"></div>
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="mb-16">
                            <label class="primary_heading">Send event to GA4 and Google ads</label>
                        </div>
                        <div class="d-flex align-items-center mb-16">
                            <div class="radio-inputs-wrap">
                                <?php renderDummyRadioInput('Send a single event to GA4 and Google ads'); ?>
                                <?php renderDummyRadioInput('Send separate events to GA4 and Google Ads'); ?>
                            </div>
                        </div>
                        <p class="form-text about-params">
													Google Analytics and Google Ads events with Conversions with Card Data (CwCD) use different parameter names
													(e.g., GA4 uses <span class="parameters-list">item_id</span>, Google Ads uses <span class="parameters-list">id</span>; GA4 supports <span class="parameters-list">item_name</span>, Google Ads doesn’t; Google Ads supports order-level discount, GA4 doesn’t).
													You can fire a single event with all parameters, or separate events with supported parameters.
													This applies to WooCommerce or EDD events like <span class="parameters-list">purchase, add_to_cart</span>, and <span class="parameters-list">view_item</span>. It will also affect manually configured events that track WooCommerce product or cart data.
											</p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
                <div class="line"></div>
                <div>
                    <div class="d-flex align-items-center mb-24">
                        <h4 class="secondary_heading"><?php echo esc_html( __('DataLayer Setting:', 'pys') ); ?></h4>
                    </div>
                    <div class="radio-inputs-wrap mb-16">
                        <?php GATags()->render_radio_input('gtag_datalayer_type', 'default', 'Use PYS recommended name for data layer variable (recommended).'); ?>
                        <?php GATags()->render_radio_input('gtag_datalayer_type', 'disable', 'Disable name transformation for the data layer (use dataLayer).'); ?>
                        <?php GATags()->render_radio_input('gtag_datalayer_type', 'custom', 'Use this custom name for the data layer variable.'); ?>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php GATags()->render_text_input('gtag_datalayer_name', 'custom name for the data layer'); ?>
                    </div>
                </div>
                <div class="line"></div>
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-24">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e('Enable alternative GCLID parameter for Safari compatibility (Beta)', 'pys');?></h4>
                        </div>
                        <p class="text-gray mb-16">
                            <?php _e('Safari removes GCLID from URLs starting September 2025. Enable this option to use a custom parameter that contains the same GCLID value.', 'pys');?>
                        </p>
                        <div class="gap-24 mb-16">
                            <div class="d-flex align-items-center">
                                <?php renderDummyTextInput( 'Custom parameter name (e.g., gclid_custom)' ); ?>
                            </div>
                        </div>
                        <p class="text-gray">
                            <?php _e('Configure this parameter in Google Ads as a custom parameter with the same value as GCLID. The plugin will automatically save this value in a first-party cookie and use it for conversion tracking only when the standard _gcl_aw cookie is not available.', 'pys');?>
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
                <div class="line"></div>
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading"><?php _e('Pass through ad click, client ID, and session ID information in URLs (url_passthrough)', 'pys');?></h4>
                            </div>

                        </div>
                        <p class="text-gray pb-8">
                            <?php _e('Reference:', 'pys');?>
                            <a class="link" href="https://developers.google.com/tag-platform/security/guides/consent?consentmode=advanced#gtag.js_5" target="_blank"><?php _e('click here', 'pys');?></a>
                        </p>
                        <p class="text-gray">
                            <?php _e('This option can improve tracking when cookies are denied:', 'pys');?> <a class="link" href="https://www.youtube.com/watch?v=wsNAbaoD5pM" target="_blank"><?php _e('watch video', 'pys');?></a>
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
                <div class="line"></div>
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-24">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading"><?php _e('Send user provided data when possible', 'pys');?></h4>
                            </div>
                        </div>
                        <div class="gap-24">
                            <div>
                                <?php renderDummyCheckbox("Send multiple values when possible (up to 3 emails and phone numbers, up to 2 address fields)"); ?>
                            </div>
                            <div>
                                <?php renderDummyCheckbox("Use encoding"); ?>
                            </div>
                            <p class="text-gray">
                                <?php _e('Learn how to configure it: ', 'pys');?>
                                <a class="link" href="https://www.youtube.com/watch?v=uQ8t7RJhVvI" target="_blank"><?php _e('watch video', 'pys');?></a>
                            </p>
                        </div>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Google Analytics Settings -->

    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Google Analytics', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <?php GA()->render_switcher_input( 'custom_page_view_event' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Control the page_view event', 'pys');?></h4>
                    </div>
                    <p class="text-gray">
                        <?php _e('Enable it if you use a GTM server container to fire API events. When we control the page_view event we can sent an event_id that is used for deduplication of API events.', 'pys');?>
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php GA()->render_switcher_input( 'disable_noscript' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Disable noscript', 'pys');?></h4>
                    </div>
                </div>

                <div>
                    <div class="d-flex align-items-center">
                        <?php GA()->render_switcher_input( 'disable_advertising_features' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Disable all advertising features', 'pys');?></h4>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center">
                        <?php GA()->render_switcher_input( 'disable_advertising_personalization' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Disable advertising personalization', 'pys');?></h4>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center justify-content-between pro-feature-container">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e('Track User-ID for logged-in users', 'pys');?></h4>
                        </div>
                        <?php renderProBadge(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ads Settings -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Google Ads', 'pys');?></h4>
            <?php renderSpBadge(); ?>
        </div>
        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e('Fire the page_view_event on posts', 'pys');?></h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e('Fire the page_view event on pages', 'pys');?></h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e('Fire the page_view event on pages', 'pys');?></h4>
                        </div>
                    </div>
                    <div>
                        <div class="mb-24">
                            <label class="secondary_heading"><?php _e('Fire the page_view event on custom post type:', 'pys');?></label>
                        </div>
                        <input type="checkbox" class="custom-control-input" name="pys[google_ads][page_view_custom_post_enabled][-1]" value="0" checked />
                        <div class="custom-controls-stacked offset-block gap-24">
                            <?php
                            $args = array(
                                'public' => true
                            );
                            $exclude = array("post","page");
                            if(isWooCommerceActive()){
                                $exclude[] = "product";
                            }
                            if(isEddActive()){
                                $exclude[] = "download";
                            }
                            $post_types = get_post_types( $args, 'objects' );
                            foreach ( $post_types as $type) {
                                if(in_array($type->name,$exclude)) continue;
                                ?>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center flex-with-badge">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading"><?=$type->label?></h4>
                                    </div>
                                </div>
                                <?php

                            }
                            ?>
                        </div>
                    </div>
                    <div>
                        <div class="mb-24">
                            <div class="mb-8">
                                <label class="primary_heading"><?php _e('google_business_vertical:', 'pys');?></label>
                            </div>
                            <?php renderDummyTextInput( 'google_business_vertical', 'short' ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cross-Domain Tracking -->
    <!-- @link: https://developers.google.com/analytics/devguides/collection/gtagjs/cross-domain -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Cross-Domain Tracking', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center">
                        <?php GA()->render_switcher_input( 'cross_domain_enabled' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Enable Cross-Domain Tracking', 'pys');?></h4>
                        <?php renderPopoverButton( 'ga_cross_domain_tracking' ); ?>
                    </div>
                </div>
                <div class="offset-block gap-24">
                    <div class="d-flex align-items-center">
                        <?php GA()->render_switcher_input( 'cross_domain_accept_incoming' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Accept incoming', 'pys');?></h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php Helpers\renderCrossDomainDomain( 0 ); ?>
                    </div>
                    <?php foreach ( GA()->getOption('cross_domain_domains') as $index => $domain ) : ?>

                        <?php

                        if ( $index === 0 ) {
                            continue; // skip default ID
                        }

                        ?>

                        <div class="d-flex align-items-center cross-domain-block">
                            <?php Helpers\renderCrossDomainDomain( $index ); ?>
                            <div>
                                <button type="button" class="button-remove-row remove-row">
                                    <i class="icon-delete" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                    <?php endforeach; ?>

                    <div class="d-flex align-items-center cross-domain-block" id="pys_ga_cross_domain_domain" style="display: none;">
                        <input type="text" class="input-short" name="" id="" value="" placeholder="Enter domain">
                        <div>
                            <button type="button" class="button-remove-row remove-row">
                                <i class="icon-delete" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary btn-primary-type2" type="button"
                                id="pys_ga_add_cross_domain_domain">
                            <?php _e('Add Extra Domain', 'pys');?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel card card-style6 card-static">
        <div class="card-body text-center">
            <p class="mb-0">Track more actions with the PRO version.
                <br><a class="link" href="https://www.pixelyoursite.com/google-analytics?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-analytics-settings"
                       target="_blank">Find more about the Google Analytics pro implementation</a></p>
        </div>
    </div>
</div>




<script type="application/javascript">
    jQuery(document).ready(function ($) {

        $('#pys_ga_add_cross_domain_domain').click(function (e) {

            e.preventDefault();

            var $row = $('#pys_ga_cross_domain_domain').clone()
                .insertBefore('#pys_ga_cross_domain_domain')
                .attr('id', '')
                .css('display', 'flex');

            $('input[type="text"]', $row)
                .attr('name', 'pys[ga][cross_domain_domains][]');

        });

        $(document).on('click', '.remove-row', function () {
            $(this).closest('.cross-domain-block').remove();
        });

    });
</script>
