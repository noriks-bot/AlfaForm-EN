<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<div class="cards-wrapper cards-wrapper-style1 gap-24">

    <!-- Advanced Purchase Tracking-->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2"><?php _e( 'Purchase and Refund Tracking Settings', 'pys' ); ?></h4>
            </div>

            <div class="d-flex align-items-center flex-collapse-block">
                <?php renderProBadge(); ?>
                <?php cardCollapseSettings(); ?>
            </div>
        </div>
        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher( false); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e( 'Facebook backup and renewals Purchase tracking via API', 'pys' ); ?></h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher( false); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e( 'Google Analytics backup and renewals Purchase tracking via API', 'pys' ); ?></h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher( false); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e( 'TikTok backup and renewals Purchase tracking via API', 'pys' ); ?></h4>
                        </div>
                    </div>
                    <?php if ( Pinterest()->enabled() ) : ?>
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher( false); ?>
                                <h4 class="switcher-label secondary_heading"><?php _e( 'Pinterest backup and renewals Purchase tracking via API', 'pys' ); ?></h4>
                            </div>
                        </div>
                    <?php endif; ?>
                    <p class="text-gray">
                        <?php _e('The plugin will send a Purchase event to Meta and Google using API when auto-renewals take place or when a new order is placed by an admin on the backend. Meta Conversion API token and GA4 Measurement Protocol secret are required.', 'pys');?>
                    </p>
                    <div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher( false); ?>
                                <h4 class="switcher-label secondary_heading"><?php _e( 'Track refunds on Goolge Analytics', 'pys' ); ?></h4>
                            </div>
                        </div>
                        <p class="text-gray">
                            <?php _e('A "Refund" event will be sent to Google via the API when the order status changes to "Refund". GA4 measurement protocol secret required.', 'pys');?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2"><?php _e( 'General', 'pys' ); ?></h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <p>
                    <?php _e('Fire e-commerce related events. Meta, TikTok, Google Ads, Bing (paid add-on), and Pinterest (paid add-on) events are Dynamic Ads Ready. Monetization data is sent to Google Analytics.', 'pys');?>
                </p>
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <?php PYS()->render_switcher_input( 'edd_enabled_save_data_to_orders' ); ?>
                        <h4 class="switcher-label">Enable Easy Digital Downloads Reports</h4>
                    </div>
                    <p class="text-gray">
                        Save the <i>landing page, UTMs, client's browser's time, day, and month, the number of orders, lifetime value, and average order</i>.
                        You can view this data when you open an order, or on the <a class="link" href="<?=admin_url("admin.php?page=pixelyoursite_edd_reports")?>">Easy Digital Downloads Reports</a> page
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <?php PYS()->render_switcher_input( 'edd_enabled_display_data_to_orders' ); ?>
                        <h4 class="switcher-label"><?php _e('Display the tracking data on the order\'s page', 'pys');?></h4>
                    </div>
                    <p class="text-gray">
                        Show the <i>landing page, traffic source,</i> and <i>UTMs</i> on the order's edit page.
                    </p>
                </div>
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher( false); ?>
                                <h4 class="switcher-label"><?php _e('Display data to the user\'s profile', 'pys');?></h4>
                            </div>
                        </div>
                        <p class="text-gray">
                            Display <i>the number of orders, lifetime value, and average order</i>.
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
                <hr>
                <div class="pro-feature-container  d-flex align-items-center justify-content-between">
                    <div class="gap-24">
                        <h4 class="primary_heading"><?php _e('New customer parameter', 'pys');?></h4>
                        <p>
                            <?php _e('The new_customer parameter is added to the purchase event for our Google native tags and for GTM. It\'s use by Google for new customer acquisition. We always send it with true or false values for logged-in users. We will use these options for guest checkout.', 'pys');?>
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="radio-inputs-wrap">
                                <?php renderDummyRadioInput('Send it for guest checkout', true); ?>
                                <?php renderDummyRadioInput('Don\'t send it for guest checkout'); ?>
                            </div>
                        </div>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style6 card-static">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between gap-24">
                <p style="text-align: center;"><?php _e('Use our dedicated plugin to create auto-updating feeds for Facebook Product Catalogs.', 'pys');?></p>
                <a class="link" href="https://www.pixelyoursite.com/easy-digital-downloads-product-catalog?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-catalog-edd"
                   target="_blank"><?php _e('Click to get Easy Digital Downloads Product Catalog Feed', 'pys');?></a>
            </div>
        </div>
    </div>
    <!-- video -->
    <?php
    $videos = array(
        array(
            'url'   => 'https://www.youtube.com/watch?v=-bN5D_HJyuA',
            'title' => 'Enhanced Conversions for Google Ads with PixelYourSite',
            'time'  => '9:14',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=v3TfmX5H1Ts',
            'title' => 'Track Facebook (META) Ads results with Google Analytics 4 (GA4) using UTMs',
            'time'  => '10:13',
        ),
    );

    renderRecommendedVideo( $videos );
    ?>
    <!--  Transaction ID -->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2"><?php _e( 'Transaction ID', 'pys' ); ?></h4>
            </div>
            <div class="d-flex align-items-center flex-collapse-block">
                <?php renderProBadge(); ?>
                <?php cardCollapseSettings(); ?>
            </div>
        </div>

        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div>
                        <div class="mb-8">
                            <label class="primary_heading">Prefix:</label>
                        </div>
                        <?php renderDummyTextInput("Prefix", 'short'); ?>
                    </div>
                    <p class="text-gray">
                        <?php _e('Consider adding a prefix for transactions IDs if you use the same tags on multiple websites.', 'pys');?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- AddToCart -->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2"><?php _e('When to fire the add to cart event', 'pys');?></h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>

        <div class="card-body">
            <div class="gap-24">
                <div class="woo_add_to_cart_event gap-24">
                    <?php PYS()->render_checkbox_input( 'edd_add_to_cart_on_button_click', __('On Add To Cart button clicks', 'pys')); ?>
                    <?php PYS()->render_checkbox_input( 'edd_add_to_cart_on_checkout_page', __('On Checkout Page', 'pys')); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ID Settings -->
    <div class="card card-style5 woo-id-settings">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">ID Settings</h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>
        <div class="card-body">
            <div class="gap-22">
                <?php if ( Facebook()->enabled() ) : ?>

                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Facebook ID settings</h4>
                            </div>
                            <?php cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body">
                            <div class="gap-24">
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">content_id</label>
                                    </div>
                                    <?php Facebook()->render_select_input( 'edd_content_id', array(
                                        'download_id' => 'Download ID',
                                        'download_sku' => 'Download SKU',
                                    ) ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">content_id prefix</label>
                                    </div>
                                    <?php Facebook()->render_text_input( 'edd_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">content_id suffix</label>
                                    </div>
                                    <?php Facebook()->render_text_input( 'edd_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

                <?php if ( GATags()->enabled() ) : ?>

                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Google Tags ID settings</h4>
                            </div>

                            <?php cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body">
                            <div class="gap-24">
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ecomm_prodid</label>
                                    </div>
                                    <?php GATags()->render_select_input( 'edd_content_id', array(
                                        'download_id' => 'Download ID',
                                        'download_sku'   => 'Download SKU',
                                    ) ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ecomm_prodid prefix</label>
                                    </div>
                                    <?php GATags()->render_text_input( 'edd_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ecomm_prodid suffix</label>
                                    </div>
                                    <?php GATags()->render_text_input( 'edd_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if ( Pinterest()->enabled() ) : ?>

                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Pinterest Tag ID settings</h4>
                            </div>

                            <?php cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body">
                            <div class="gap-24">
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID</label>
                                    </div>
                                    <?php Pinterest()->render_select_input( 'edd_content_id', array(
                                        'download_id' => 'Download ID',
                                        'download_sku'   => 'Download SKU',
                                    ) ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID prefix</label>
                                    </div>
                                    <?php Pinterest()->render_text_input( 'edd_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID suffix</label>
                                    </div>
                                    <?php Pinterest()->render_text_input( 'edd_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Pinterest Tag ID settings</h4>&nbsp;
                                <a class="link"
                                   href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/pinterest-tag-add-on?utm_source=pys-free-plugin&utm_medium=pinterest-badge&utm_campaign=requiere-free-add-on"
                                   target="_blank">The paid add-on is required</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( Bing()->enabled() ) : ?>
                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Bing Tag ID settings</h4>
                            </div>

                            <?php cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body">
                            <div class="gap-24">
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID</label>
                                    </div>
                                    <?php Bing()->render_select_input( 'edd_content_id', array(
                                        'download_id' => 'Download ID',
                                        'download_sku'   => 'Download SKU',
                                    ) ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID prefix</label>
                                    </div>
                                    <?php Bing()->render_text_input( 'edd_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID suffix</label>
                                    </div>
                                    <?php Bing()->render_text_input( 'edd_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Bing Tag ID settings</h4>&nbsp;
                                <a class="link"
                                   href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/bing-tag-add-on?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-bing"
                                   target="_blank">The paid add-on is required</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

	            <?php if ( Reddit()->enabled() ) : ?>
                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Reddit Tag ID settings</h4>
                            </div>

				            <?php cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body">
                            <div class="gap-24">
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID</label>
                                    </div>
						            <?php Reddit()->render_select_input( 'edd_content_id', array(
							            'download_id' => 'Download ID',
							            'download_sku'   => 'Download SKU',
						            ) ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID prefix</label>
                                    </div>
						            <?php Reddit()->render_text_input( 'edd_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID suffix</label>
                                    </div>
						            <?php Reddit()->render_text_input( 'edd_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                            </div>
                        </div>
                    </div>
	            <?php else: ?>
                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Reddit Tag ID settings</h4>&nbsp;
                                <a class="link"
                                   href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/reddit-wordpress-plugin"
                                   target="_blank">The paid add-on is required</a>
                            </div>
                        </div>
                    </div>
	            <?php endif; ?>

                <?php if ( GTM()->enabled() ) : ?>

                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">GTM tag settings</h4>
                            </div>

                            <?php cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body">
                            <div class="gap-24">
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ecomm_prodid</label>
                                    </div>
                                    <?php GTM()->render_select_input( 'edd_content_id', array(
                                        'download_id' => 'Download ID',
                                        'download_sku'   => 'Download SKU',
                                    ) ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ecomm_prodid prefix</label>
                                    </div>
                                    <?php GTM()->render_text_input( 'edd_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>
                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ecomm_prodid suffix</label>
                                    </div>
                                    <?php GTM()->render_text_input( 'edd_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Google Dynamic Remarketing Vertical -->
                <div class="card card-style6">
                    <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h4 class="secondary_heading_type2">Google Dynamic Remarketing Vertical</h4>
                        </div>
                        <div class="d-flex align-items-center flex-collapse-block">
                            <?php renderProBadge(); ?>
                            <?php cardCollapseSettings(); ?>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="pro-feature-container">
                            <div class="radio-inputs-wrap">
                                <?php renderDummyRadioInput( 'Use Retail Vertical  (select this if you have access to Google Merchant)', true ); ?>
                                <?php renderDummyRadioInput( 'Use Custom Vertical (select this if Google Merchant is not available for your country)' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Event Value -->
                <div class="card card-style6">
                    <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h4 class="secondary_heading_type2">Value Settings</h4>
                        </div>
                        <div class="d-flex align-items-center flex-collapse-block">
                            <?php renderProBadge(); ?>
                            <?php cardCollapseSettings(); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pro-feature-container">
                            <div class="radio-inputs-wrap mb-24">
                                <?php renderDummyRadioInput( 'Use EasyDigitalDownloads price settings', true ); ?>
                                <?php renderDummyRadioInput( 'Customize Tax' ); ?>
                            </div>

                            <div class="edd-event-value-option mb-24" style="display: none;">
                                <div class="woo-event-value-option-item">
                                    <?php renderDummySelectInput( 'Include Tax' ); ?>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="primary_heading"><?php _e('Lifetime Customer Value', 'pys');?></label>
                            </div>
                            <?php renderDummyTagsFields( array( 'Complete' ) ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-style5 woo-recommended-events">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2"><?php _e('Recommended events', 'pys');?></h4>
            </div>
        </div>

        <div class="card-body" style="display: block;">
            <!-- Purchases -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="disable-card d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'edd_purchase_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track Purchases</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>
                <div class="card-body">
                    <div class="gap-24">
                        <div>
                            <?php PYS()->renderValueOptionsBlock('edd_purchase', false);?>
                        </div>
                        <div class="d-flex pro-feature-container">
                            <?php renderDummyCheckbox( 'Fire the event only once for each order (disable when testing)', true ); ?>
                            <?php renderPopoverButton( 'edd_purchase_on_transaction', 'top' ); ?>
                        </div>
                        <div class="pro-feature-container">
                            <?php renderDummyCheckbox( "Don't fire the event for 0 value transactions", true ); ?>
                        </div>
                        <div class="pro-feature-container">
                            <?php renderDummyCheckbox( "Don't fire the event when the number of items is 0", true ); ?>
                        </div>

                        <?php if ( Facebook()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'edd_purchase_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the Purchase event on Facebook
                                    (required for DPA)</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GA()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'edd_purchase_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the purchase event on Google
                                    Analytics</h4>
                            </div>
                        <?php endif; ?>
                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the purchase event on Google
                                        Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>
                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                        </div>

                        <?php if ( Pinterest()->enabled() || Bing()->enabled()) : ?>
                            <div class="line"></div>
                        <?php endif; ?>

                        <!-- Pinterest -->
                        <?php
                        if(Pinterest()->enabled()) : ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input('edd_checkout_enabled'); ?>
                                <h4 class="switcher-label secondary_heading">Enable the Checkout event on Pinterest</h4>
                            </div>
                        <?php endif; ?>
                        <!-- Bing -->
                        <?php
                        if(Bing()->enabled()) : ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input('edd_purchase_enabled'); ?>
                                <h4 class="switcher-label secondary_heading">Enable the Purchase event on Bing</h4>
                                <?php renderPopoverButton('woo_bing_enable_purchase'); ?>
                            </div>
                        <?php endif; ?>

	                    <?php if(Reddit()->enabled()) : ?>
                            <div class="d-flex align-items-center">
                                <?php Reddit()->render_switcher_input('edd_purchase_enabled'); ?>
                                <h4 class="switcher-label secondary_heading">Enable the Purchase event on Reddit</h4>
                            </div>
	                    <?php endif; ?>

                        <?php if ( GTM()->enabled() ) : ?>
                            <div class="line"></div>
                            <div class="d-flex align-items-center">
                                <?php GTM()->render_switcher_input( 'edd_purchase_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the purchase event on GTM dataLayer</h4>
                            </div>
                        <?php endif; ?>

                        <div class="line"></div>

                        <?php
                        $message = '*This event will be fired on the order-received, the default Easy Digital Downloads
                                    "thank you page". If you use PayPal, make sure that auto-return is ON. If you want to use "custom
                                    thank you pages", you must configure them with our <a href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/the-super-pack"
                                                                    target="_blank" class="link">Super Pack</a>.';
                        renderWarningMessage( $message ); ?>
                    </div>
                </div>
            </div>
            <!-- InitiateCheckout -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="disable-card d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track the Checkout Page</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>
                <div class="card-body">
                    <div class="gap-24">
                        <div>
                            <?php PYS()->renderValueOptionsBlock( 'edd_initiate_checkout', false ); ?>
                        </div>
                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the InitiateCheckout event on Facebook</h4>
                            </div>
                        <?php endif; ?>
                        <?php if ( GA()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the begin_checkout event on Google Analytics</h4>
                            </div>
                        <?php endif; ?>
                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the begin_checkout event on Google
                                        Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>

                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                        </div>



                        <?php if ( Pinterest()->enabled() || Bing()->enabled() ) : ?>
                            <div class="line"></div>
                        <?php endif; ?>
                        <?php if ( Pinterest()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the InitiateCheckout on Pinterest</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Bing()->enabled() ) : $configured = true;?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the InitiateCheckout on Bing</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GTM()->enabled() ) : ?>
                            <div>
                                <?php if ( $configured ) : ?>
                                    <div class="line mb-24"></div>
                                <?php endif; ?>

                                <div class="d-flex align-items-center">
                                    <?php GTM()->render_switcher_input( 'edd_initiate_checkout_enabled' ); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the begin_checkout event on GTM dataLayer</h4>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- AddToCart -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="disable-card d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track add to cart</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>
                <div class="card-body">
                    <div class="gap-24">
                        <div>
                            <?php PYS()->renderValueOptionsBlock('edd_add_to_cart', false);?>
                        </div>

                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the AddToCart event on Facebook (required for DPA)</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GA()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the add_to_cart event on Google Analytics</h4>
                            </div>
                        <?php endif; ?>

                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the add_to_cart event on Google Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>

                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                        </div>


                        <?php if ( Pinterest()->enabled() || Bing()->enabled() || Reddit()->enabled() ) : ?>
                            <div class="line"></div>
                        <?php endif; ?>
                        <?php if ( Pinterest()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the AddToCart event on Pinterest</h4>
                            </div>
                        <?php endif; ?>
                        <?php if ( Bing()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the AddToCart event on Bing</h4>
                            </div>
                        <?php endif; ?>

	                    <?php if ( Reddit()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
			                    <?php Reddit()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the AddToCart event on Reddit</h4>
                            </div>
	                    <?php endif; ?>

                        <?php if ( GTM()->enabled() ) : ?>
                            <div>
                                <?php if ( $configured ) : ?>
                                    <div class="line mb-24"></div>
                                <?php endif; ?>
                                <div class="d-flex align-items-center">
                                    <?php GTM()->render_switcher_input( 'edd_add_to_cart_enabled' ); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the add_to_cart event on GTM dataLayer</h4>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- ViewContent -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="disable-card d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'edd_view_content_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track product pages</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>
                <div class="card-body">
                    <div class="gap-24">
                        <div>
                            <?php PYS()->renderValueOptionsBlock('edd_view_content', false);?>
                        </div>
                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'edd_view_content_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewContent on Facebook (required for DPA)</h4>
                            </div>
                        <?php endif; ?>
                        <?php if ( GA()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'edd_view_content_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the view_item event on Google Analytics</h4>
                            </div>
                        <?php endif; ?>

                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the view_item event on Google Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>
                        </div>

                        <?php renderDummyGoogleAdsConversionLabelInputs(); ?>

                        <?php if ( Pinterest()->enabled() || Bing()->enabled() || Reddit()->enabled() ) : ?>
                            <div class="line"></div>
                        <?php endif; ?>
                        <?php if ( Pinterest()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'edd_page_visit_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the PageVisit event on
                                    Pinterest</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Bing()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'edd_view_content_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the PageVisit event on Bing</h4>
                            </div>
                        <?php endif; ?>

	                    <?php if ( Reddit()->enabled() ) :
		                    $configured = true; ?>
                            <div class="d-flex align-items-center">
			                    <?php Reddit()->render_switcher_input( 'edd_view_content_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewContent event on Reddit</h4>
                            </div>
	                    <?php endif; ?>

                        <?php if ( GTM()->enabled() ) : ?>
                            <div>
                                <?php if ( $configured ) : ?>
                                    <div class="line mb-24"></div>
                                <?php endif; ?>

                                <div class="d-flex align-items-center">
                                    <?php GTM()->render_switcher_input( 'edd_view_content_enabled' ); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the view_item event on GTM
                                        dataLayer</h4>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- ViewCategory -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="disable-card d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'edd_view_category_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track product category pages</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>

                <div class="card-body">
                    <div class="gap-24">
                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'edd_view_category_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewCategory event on Facebook Analytics (used for DPA)</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GA()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'edd_view_category_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the view_item_list event on Google Analytics</h4>
                            </div>
                        <?php endif; ?>

                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the view_item_list event on Google Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>

                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                        </div>

                        <?php if ( Pinterest()->enabled() || Bing()->enabled() ) : ?>
                            <div class="line"></div>
                        <?php endif; ?>
                        <?php if ( Pinterest()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'edd_view_category_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewCategory event on Pinterest</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Bing()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'edd_view_category_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewCategory event on Bing</h4>
                            </div>
                        <?php endif; ?>
                        <?php if ( GTM()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php GTM()->render_switcher_input( 'edd_view_category_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewCategory event on GTM dataLayer</h4>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Marketing Events -->
    <div class="card card-style5 woo-advanced-events">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2"><?php _e('Advanced Marketing Events', 'pys');?></h4>
            </div>
            <div class="d-flex align-items-center flex-collapse-block">
                <?php renderProBadge(); ?>
                <?php cardCollapseSettings(); ?>
            </div>
        </div>

        <div class="card-body">
            <!-- FrequentShopper -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="secondary_heading_type2 switcher-label">FrequentShopper Event</h4>
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
                                    <h4 class="switcher-label secondary_heading">Send the event to Facebook</h4>
                                </div>
                            <?php endif; ?>

                            <?php if ( GA()->enabled() ) : ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to Google Analytics</h4>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex align-items-center">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">Enable on Google Ads</h4>
                            </div>

                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                            <?php if ( Pinterest()->enabled() || Bing()->enabled() ) : ?>
                                <div class="line"></div>
                            <?php endif; ?>
                            <?php if ( Pinterest()->enabled() ) : ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Pinterest</h4>
                                </div>
                            <?php endif; ?>

                            <?php if ( Bing()->enabled() ) : ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Bing</h4>
                                </div>
                            <?php endif; ?>

	                        <?php if ( Reddit()->enabled() ) : ?>
                                <div class="d-flex align-items-center">
			                        <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Reddit</h4>
                                </div>
	                        <?php endif; ?>

                            <?php if ( GTM()->enabled() ) : ?>
                                <?php if ( $configured ) : ?>
                                    <div class="line"></div>
                                <?php endif;
                                $configured = true; ?>

                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to GTM dataLayer</h4>
                                </div>

                                <div class="line"></div>
                            <?php endif; ?>

                            <div class="d-flex align-items-center">
                                <label class="primary_heading mr-16">Fire this event when the client has at least</label>
                                <?php renderDummyNumberInput( 2 ); ?>
                                <label class="ml-20">transactions</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- VipClient -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="secondary_heading_type2 switcher-label">VIPClient Event</h4>
                    </div>
                    <div class="d-flex align-items-center flex-collapse-block">
                        <?php renderProBadge(); ?>
                        <?php cardCollapseSettings(); ?>
                    </div>
                </div>

                <div class="card-body">
                    <div class="pro-feature-container">
                        <div class="gap-24">
                            <?php $configured = false; ?>
                            <?php if ( Facebook()->enabled() ) :
                                $configured = true; ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to Facebook</h4>
                                </div>
                            <?php endif; ?>

                            <?php if ( GA()->enabled() ) :
                                $configured = true; ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to Google Analytics</h4>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex align-items-center">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">Enable on Google Ads</h4>
                            </div>

                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                            <?php if ( Pinterest()->enabled() || Bing()->enabled() ) : ?>
                                <div class="line"></div>
                            <?php endif; ?>
                            <?php if ( Pinterest()->enabled() ) :
                                $configured = true; ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Pinterest</h4>
                                </div>
                            <?php endif; ?>

                            <?php if ( Bing()->enabled() ) :
                                $configured = true; ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Bing</h4>
                                </div>
                            <?php endif; ?>

	                        <?php if ( Reddit()->enabled() ) :
		                        $configured = true; ?>
                                <div class="d-flex align-items-center">
			                        <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Reddit</h4>
                                </div>
	                        <?php endif; ?>


                            <?php if ( GTM()->enabled() ) : ?>
                                <?php if ( $configured ) : ?>
                                    <div class="line"></div>
                                <?php endif;
                                $configured = true; ?>

                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to GTM dataLayer</h4>
                                </div>

                                <div class="line"></div>
                            <?php endif; ?>

                            <?php if ( $configured ) : ?>
                                <div class="woo-adv-events-condition">
                                    <label class="primary_heading">Fire this event when the client has at least</label>
                                    <?php renderDummyNumberInput( 3 ); ?>
                                    <label class="primary_heading">transactions and average order is at least</label>
                                    <?php renderDummyNumberInput( 200 ); ?>
                                </div>
                            <?php else : ?>
                                <div class="critical_message">Error: No supported pixels are not configured</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BigWhale -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="secondary_heading_type2 switcher-label">BigWhale Event</h4>
                    </div>
                    <div class="d-flex align-items-center flex-collapse-block">
                        <?php renderProBadge(); ?>
                        <?php cardCollapseSettings(); ?>
                    </div>
                </div>

                <div class="card-body">
                    <div class="pro-feature-container">
                        <div class="gap-24">
                            <?php $configured = false; ?>
                            <?php if ( Facebook()->enabled() ) :
                                $configured = true; ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to Facebook</h4>
                                </div>
                            <?php endif; ?>

                            <?php if ( GA()->enabled() ) :
                                $configured = true; ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to Google Analytics</h4>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex align-items-center">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">Enable on Google Ads</h4>
                            </div>

                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                            <?php if ( Pinterest()->enabled() || Bing()->enabled() ) : ?>
                                <div class="line"></div>
                            <?php endif; ?>
                            <?php if ( Pinterest()->enabled() ) :
                                $configured = true; ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Pinterest</h4>
                                </div>
                            <?php endif; ?>

                            <?php if ( Bing()->enabled() ) :
                                $configured = true; ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Bing</h4>
                                </div>
                            <?php endif; ?>

	                        <?php if ( Reddit()->enabled() ) :
		                        $configured = true; ?>
                                <div class="d-flex align-items-center">
			                        <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Reddit</h4>
                                </div>
	                        <?php endif; ?>

                            <?php if ( GTM()->enabled() ) : ?>
                                <?php if ( $configured ) : ?>
                                    <div class="line"></div>
                                <?php endif;
                                $configured = true; ?>

                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to GTM dataLayer</h4>
                                </div>

                                <div class="line"></div>
                            <?php endif; ?>

                            <?php if ( $configured ) : ?>
                                <div class="woo-adv-events-condition">
                                    <label class="primary_heading">Fire this event when the client has LTV at least</label>
                                    <?php renderDummyNumberInput( 500 ); ?>
                                </div>
                            <?php else : ?>
                                <div class="critical_message">Error: No supported pixels are not configured</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Extra events -->
    <div class="card card-style5 woo-extra-events">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">Extra events</h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>
        <div class="card-body">
            <!-- RemoveFromCart -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="disable-card d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'edd_remove_from_cart_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track remove from cart</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>
                <div class="card-body">
                    <div class="gap-24">
                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'edd_remove_from_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the RemoveFromCart event on Facebook</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GA()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'edd_remove_from_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the remove_from_cart event on Google Analytics</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Pinterest()->enabled()) : ?>
                            <div class="line"></div>
                        <?php endif; ?>
                        <?php if ( Pinterest()->enabled() ) : $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'edd_remove_from_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the RemoveFromCart event on Pinterest</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GTM()->enabled() ) :
                            if ( $configured ) : ?>
                                <div class="line"></div>
                            <?php endif; $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php GTM()->render_switcher_input( 'edd_remove_from_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the RemoveFromCart event on GTM dataLayer</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( !$configured ) : ?>
                            <div class="critical_message">Error: No supported pixels are not configured</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EDD Parameters -->
    <div class="card card-style5 woo-params-block">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">EDD Parameters</h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>

        <div class="card-body woo-params-list">

            <!-- Control the EDD Parameters -->
            <div class="card about-params card-style3">
                <div class="card-header card-header-style2">
                    <div class="disable-card d-flex align-items-center">
                        <h4 class="secondary_heading_type2">Control the EDD Parameters</h4>
                    </div>
                </div>

                <div class="card-body" style="display: block">
                    <div class="gap-24">
                        <p>
                            You can use these parameters to create audiences, custom conversions, or goals. We recommend keeping them active. If you get privacy warnings about some of these parameters, you can turn them OFF.
                        </p>

                        <div class="woo-control-parameters">
                            <div class="woo-control-parameter-item">
                                <?php PYS()->render_switcher_input( 'enable_edd_category_name_param' ); ?>
                                <h4 class="switcher-label secondary_heading">category_name</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php PYS()->render_switcher_input( 'enable_edd_num_items_param' ); ?>
                                <h4 class="switcher-label secondary_heading">num_items</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php PYS()->render_switcher_input( 'enable_edd_tags_param' ); ?>
                                <h4 class="switcher-label secondary_heading">tags</h4>
                            </div>


                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">total (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">tax (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">coupon (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher( true ); ?>
                                <h4 class="switcher-label secondary_heading">content_ids (mandatory for DPA)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher( true ); ?>
                                <h4 class="switcher-label secondary_heading">content_type (mandatory for DPA)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher( true ); ?>
                                <h4 class="switcher-label secondary_heading">value (mandatory for purchase, you have
                                    more options on event level)</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About params -->
            <div class="card about-params card-style3">
                <div class="card-header card-header-style2">
                    <div class="d-flex align-items-center">
                        <i class="icon-Info"></i>
                        <h4 class="heading-with-icon bold-heading">About EDD Events Parameters</h4>
                    </div>
                </div>

                <div class="card-body" style="display: block;">
                    <p class="mb-24">All events get the following parameters for all the tags:
                        <span class="parameters-list">page_title, post_type, post_id, landing_page, event_URL, user_role, plugin, event_time (pro),
                            event_day (pro), event_month (pro), traffic_source (pro), UTMs (pro).</span>
                    </p>
                    <p>The Meta Pixel events are Dynamic Ads ready.</p>
                    <p>The Google Analytics events track Monetization data (GA4).</p>
                    <p>The Google Ads events have the required data for Dynamic Remarketing (<a class="link" href = "https://support.google.com/google-ads/answer/7305793" target="_blank">official help</a>). </p>
                    <p class="mb-24">The Pinterest events have the required data for Dynamic Remarketing.</p>

                    <p>The Purchase event will have the following extra-parameters:
                        <span class="parameters-list">category_name, num_items, tags, total (pro), transactions_count (pro), tax (pro),
                            predicted_ltv (pro), average_order (pro), coupon_used (pro), coupon_code (pro), shipping (pro),
                            shipping_cost (pro), fee (pro)</span>.
                </div>
            </div>
        </div>
    </div>
</div>

