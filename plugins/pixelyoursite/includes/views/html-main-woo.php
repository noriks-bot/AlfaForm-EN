<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use PixelYourSite\Facebook\Helpers;

?>

<div class="cards-wrapper cards-wrapper-style1 gap-24">
    <!-- Advanced Purchase Tracking-->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">Advanced Purchase Tracking</h4>
            </div>
            <div class="d-flex align-items-center flex-collapse-block">
                <?php renderProBadge(); ?>
                <?php cardCollapseSettings(); ?>
            </div>
        </div>
        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher( false); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e( 'Facebook Purchase tracking via API', 'pys' ); ?></h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher( false); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e( 'Google Analytics backup and renewals Purchase tracking via API', 'pys' ); ?></h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher( false); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e( 'TikTok backup and renewals Purchase tracking via API', 'pys' ); ?></h4>
                        </div>
                    </div>

                    <?php if ( Pinterest()->enabled() ) : ?>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher( false); ?>
                                <h4 class="switcher-label secondary_heading"><?php _e( 'Pinterest backup and renewals Purchase tracking via API', 'pys' ); ?></h4>
                            </div>
                        </div>
                    <?php endif; ?>

                    <p class="text-gray">
                        If the default Purchase event doesn't fire when an order is placed by the client, a Purchase event
                        will
                        be sent to Meta and Google using API when the order status is changed to "Completed". Meta
                        Conversion
                        API token and GA4 Measurement Protocol secret are required.
                    </p>

                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher( false); ?>
                                <h4 class="switcher-label secondary_heading">Track refunds on Google Analytics</h4>
                            </div>
                        </div>

                        <p class="text-gray">
                            A "Refund" event will be sent to Google via the API when the order status changes to "Refund".
                            GA4
                            measurement protocol secret required.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Native Data Tracking and Reporting settings-->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">Native Data Tracking and Reporting</h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <?php PYS()->render_switcher_input( 'woo_enabled_save_data_to_orders' ); ?>
                        <h4 class="switcher-label secondary_heading">Enable WooCommerce Reports</h4>
                    </div>

                    <p class="text-gray">
                        Save the <i>landing page, UTMs, client's browser's time, day, and month, the number of orders,
                            lifetime value, and average order</i>. You can view this data when you open an order, or on
                        the WooCommerce <a
                                href="<?php echo esc_url( admin_url( 'admin.php?page=pixelyoursite_woo_reports' ) ); ?>"
                                class="link">Reports page</a>
                    </p>
                </div>

                <div>
                    <div class="d-flex align-items-center mb-4">
                        <?php PYS()->render_switcher_input( 'woo_add_enrich_to_admin_email' ); ?>
                        <h4 class="switcher-label secondary_heading">Send reports data to the New Order email</h4>
                    </div>

                    <p class="text-gray">
                        You will see the landing page, UTMs, client's browser's time, day, and month, the number of
                        orders,
                        lifetime value, and average order in your WooCommerce's default "New Order" email.
                        Your clients will NOT get this info.
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <?php PYS()->render_switcher_input( 'woo_enabled_display_data_to_orders' ); ?>
                        <h4 class="switcher-label secondary_heading">Display the tracking data on the order's page</h4>
                    </div>

                    <p class="text-gray">
                        Show the <i>landing page, traffic source,</i> and <i>UTMs</i> on the order's edit page.
                    </p>
                </div>
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher( false); ?>
                                <h4 class="switcher-label secondary_heading">Display orders data on the user's profile page</h4>
                            </div>
                        </div>

                        <p class="text-gray">
                            Display <i>the number of orders, lifetime value, and average order</i>.
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- General settings-->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">General</h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>

        <div class="card-body">
            <div class="gap-24">
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher( false); ?>
                                <h4 class="switcher-label secondary_heading">Show tracking type</h4>
                            </div>
                        </div>

                        <p class="text-gray">
                            Show the tracking type in the orders table and on the order's page.
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
                <hr>
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div class="gap-24">
                        <h4 class="primary_heading"><?php _e('New customer parameter', 'pys');?></h4>
                        <div class="d-flex align-items-center mb-4">
                            <div class="radio-inputs-wrap">
                                <?php renderDummyRadioInput( 'Send it for guest checkout' ); ?>
                                <?php renderDummyRadioInput( 'Don\'t send it for guest checkout', true ); ?>
                            </div>
                        </div>
                        <p class="text-gray">
                            The new_customer parameter is added to the purchase event for our Google native tags and for GTM. It's use by Google for new customer acquisition. We always send it with true or false values for logged-in users. We will use these options for guest checkout.
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
                <hr>
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center flex-with-badge">
                                <div class="primary_heading mb-4">If the Purchase event doesn't work correctly, add your Checkout
                                    page(s)
                                    ID(s) here:
                                </div>
                            </div>
                        </div>

                        <?php PYS()->render_tags_select_input( "woo_checkout_page_ids", true ); ?>

                        <p class="form-text text-small mt-4">
                            Don't add the Checkout page IDs if you use Stripe or Klarna because conflicts are possible.
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style6 card-static">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between gap-24">
                <p style="text-align: center;"><?php _e('Use our dedicated plugin to upload and update your products to Meta Product Catalogs, Google Merchant, Google Ads Custom Vertical, Pinterest Catalogs, or TikTok Catalogs.', 'pys');?></p>
                <a class="link" href="https://www.pixelyoursite.com/product-catalog-facebook?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-catalogs-woo-tab"
                   target="_blank"><?php _e('Click to get Product Catalog Feed Pro', 'pys');?></a>
            </div>
        </div>
    </div>

    <!-- video -->
    <?php
    $videos = array(
        array(
            'url'   => 'https://www.youtube.com/watch?v=oZoAu8a0PNg',
            'title' => 'WooCommerce AddToCart Event FIX',
            'time'  => '4:46',
        ),
				array(
            'url'   => 'https://www.youtube.com/watch?v=eoJT1fSIar0',
            'title' => 'Google Automated Discounts. Step-by-Step Google Merchant Setup Guide',
            'time'  => '14:26',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=FjGJYAdZEKc',
            'title' => 'Analyse your WooCommerce data with ChatGPT',
            'time'  => '12:06',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=-bN5D_HJyuA',
            'title' => 'Enhanced Conversions for Google Ads with PixelYourSite',
            'time'  => '9:14',
        ),

        array(
            'url'   => 'https://www.youtube.com/watch?v=3Ugwlq1EVO4',
            'title' => 'Same Facebook (Meta) pixel or Google tag on multiple WooCommerce websites?',
            'time'  => '4:43',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=4VpVf9llfkU',
            'title' => 'WooCommerce First-Party Reports: Track UTMs, Traffic Source, Landing Page',
            'time'  => '13:15',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=ydqyp-iW9Ko',
            'title' => 'Find out your ads PROFIT - Meta, Google, TikTok, Pinterest, etc',
            'time'  => '5:48',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=7B8uU3p_mjw',
            'title' => 'How to track WooCommerce BRANDS on Google Analytics 4 (GA4)',
            'time'  => '4:05',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=LZtw6HxbFRg',
            'title' => 'How to track WooCommerce VARIABLE products on Google Analytics 4 (GA4)',
            'time'  => '4:21',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=8CKu2krVpyA',
            'title' => 'WooCommerce LISTS tracking on GA4',
            'time'  => '6:49',
        ),
    );

    renderRecommendedVideo( $videos );
    ?>

    <!--  Brand tracking-->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">Brand tracking for Google Analytics</h4>
            </div>
            <div class="d-flex align-items-center flex-collapse-block">
                <?php renderProBadge(); ?>
                <?php cardCollapseSettings(); ?>
            </div>
        </div>

        <div class="card-body">
            <div class="pro-feature-container">
                <div class="gap-24">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher( false); ?>
                            <h4 class="switcher-label secondary_heading">Enable Brand tracking</h4>
                        </div>
                    </div>
                    <div>
                        <div class="mb-8 d-flex align-items-center justify-content-between">
                            <label class="primary_heading">Brand taxonomy</label>
                        </div>

                        <?php renderDummySelectInput( 'Select taxonomy'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Transaction ID -->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">Transaction ID</h4>
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

                    <p class="form-text">
                        Consider adding a prefix for transactions IDs if you use the same tags on multiple websites.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- When to fire the add to cart event -->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">When to fire the add to cart event</h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>

        <div class="card-body">
            <div class="gap-24">
                <div class="woo_add_to_cart_event gap-24">
                    <?php PYS()->render_checkbox_input( 'woo_add_to_cart_on_button_click', 'On Add To Cart button clicks' ); ?>
                    <?php PYS()->render_checkbox_input( 'woo_add_to_cart_on_cart_page', 'On the Cart Page' ); ?>
                    <?php PYS()->render_checkbox_input( 'woo_add_to_cart_on_checkout_page', 'On Checkout Page' ); ?>
                </div>

                <div class="d-flex align-items-center">
                    <label class="primary_heading mr-8">Change this if the AddToCart event doesn't fire</label>
                    <?php PYS()->render_select_input( 'woo_add_to_cart_catch_method', array(
                        'add_cart_hook' => "WooCommerce hooks",
                        'add_cart_js'   => "Button's classes",
                    ) ); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Value settings -->
    <div class="card card-style5">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">Event Value Settings</h4>
            </div>
            <div class="d-flex align-items-center flex-collapse-block">
                <?php renderProBadge(); ?>
                <?php cardCollapseSettings(); ?>
            </div>
        </div>
        <div class="card-body">
            <div class="pro-feature-container">
                <div class="radio-inputs-wrap mb-24">
                    <?php renderDummyRadioInput( 'Use WooCommerce price settings', true ); ?>
                    <?php renderDummyRadioInput( 'Customize Tax and Shipping' ); ?>
                </div>

                <div class="woo-event-value-option mb-24" style="display: none;">
                    <div class="woo-event-value-option-item">
                        <?php renderDummySelectInput( 'Include Tax' ); ?>
                        <span>and</span>
                    </div>
                    <div class="woo-event-value-option-item">
                        <?php renderDummySelectInput( 'Include Shipping' ); ?>
                        <span>and</span>
                    </div>
                    <div class="woo-event-value-option-item">
                        <?php renderDummySelectInput( 'Include Fees' ); ?>
                        <span style="width: 30px"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="primary_heading">Lifetime Customer Value</label>
                </div>

                <?php renderDummyTagsFields( array( 'Pending Payment', 'Processing', 'On Hold', 'Completed' ) ); ?>
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

                <!-- Facebook for WooCommerce -->
                <?php if ( Facebook()->enabled() && Helpers\isFacebookForWooCommerceActive() ) : ?>
                    <div class="card card-style6">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Facebook for WooCommerce Integration</h4>
                            </div>

                            <?php cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body">
                            <div class="gap-24">
                                <div>
                                    <p class="primary-heading-color mb-8">
                                    <span class="primary-text-color primary_heading">It looks like you're using both PixelYourSite and Facebook for WooCommerce Extension. Good, because
                                they can do a great job together!</span>
                                    </p>
                                    <p class="primary-heading-color mb-8">Facebook for WooCommerce Extension is a useful
                                        free tool that lets you import your products to a Facebook shop and adds a very
                                        basic Meta Pixel on your site. PixelYourSite is a
                                        dedicated plugin that supercharges your Meta Pixel
                                        with extremely useful features.</p>

                                </div>

                                <p class="primary-heading-color">We made it possible to use both plugins together.
                                    You just have to decide what ID to use for your events.</p>

                                <div class="radio-inputs-wrap">
                                    <?php Facebook()->render_radio_input( 'woo_content_id_logic', 'facebook_for_woocommerce', 'Use Facebook for WooCommerce extension content_id logic' ); ?>
                                    <?php Facebook()->render_radio_input( 'woo_content_id_logic', 'default', 'Use PixelYourSite content_id logic' ); ?>
                                </div>

                                <p class="form-text text-small">
                                    * If you plan to use the product catalog created by Facebook for WooCommerce
                                    Extension, use the Facebook for WooCommerce Extension ID. If you plan to use older
                                    product catalogs, or new ones created
                                    with other plugins, it's better to keep the default PixelYourSite settings.
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( Facebook()->enabled() ) : ?>
                    <?php
                    $facebook_id_visibility = Helpers\isDefaultWooContentIdLogic() ? 'block' : 'none';
                    $isExpand = Helpers\isFacebookForWooCommerceActive();
                    ?>
                    <div class="card card-style6" style="display: <?php echo esc_attr( $facebook_id_visibility ); ?>;">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center <?php echo esc_attr( $isExpand ? 'header-opened' : '' ); ?>">
                            <div class="d-flex align-items-center">
                                <h4 class="secondary_heading_type2">Facebook ID settings</h4>
                            </div>

                            <?php cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body <?php echo esc_attr( $isExpand ? 'show' : '' ); ?>"
                             style="display: <?php echo esc_attr( $isExpand ? 'block' : 'none' ); ?>">
                            <div class="gap-24">
                                <div>
                                    <div class="d-flex align-items-center mb-4">
                                        <?php Facebook()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                                        <h4 class="switcher-label secondary_heading">Treat variable products like simple
                                            products</h4>
                                    </div>

                                    <p class="form-text">If you enable this option, the main ID will be used
                                        instead of the variation ID. Turn this option ON when your Product Catalog
                                        doesn't include the variants for variable products.</p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4 pro-feature-container">
                                    <div class="d-flex align-items-center flex-with-badge">
                                        <?php renderDummySwitcher( false); ?>
                                        <h4 class="switcher-label secondary_heading">For product pages, track the variation
                                            data when a variation is selected</h4>
                                    </div>
                                    <?php renderProBadge(); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID</label>
                                    </div>

                                    <?php Facebook()->render_select_input( 'woo_content_id', array(
                                        'product_id'  => 'Product ID',
                                        'product_sku' => 'Product SKU',
                                    ) ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID prefix</label>
                                    </div>

                                    <?php Facebook()->render_text_input( 'woo_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID suffix</label>
                                    </div>

                                    <?php Facebook()->render_text_input( 'woo_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <?php if ( isWPMLActive() ) : ?>
                                    <div>
                                        <div class="gap-24">
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>WPML Detected.</strong> Select your ID
                                                    logic.
                                                </h4>

                                                <div class="d-flex align-items-center mb-4">
                                                    <?php Facebook()->render_switcher_input( 'woo_wpml_unified_id' ); ?>
                                                    <h4 class="switcher-label secondary_heading">WPML Unified ID logic</h4>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>Default language IDs</strong> logic.
                                                </h4>
                                                <div class="d-flex align-items-center justify-content-between mb-4 pro-feature-container">
                                                    <div class="d-flex align-items-center flex-with-badge">
                                                        <?php renderDummySelectInput( 'Select language');?>
                                                    </div>
                                                    <?php renderProBadge(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="form-text">
                                            If you use localized feeds, enable the unified ID logic for the tag and we will use the native product ID for each translated item.
                                        </p>
                                    </div>
                                <?php endif; ?>
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
                                    <div class="d-flex align-items-center mb-4">
                                        <?php GATags()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                                        <h4 class="switcher-label secondary_heading">Treat variable products like simple
                                            products</h4>
                                    </div>

                                    <p class="form-text">
                                        If you enable this option, the main ID will be used instead of the variation ID.
                                        Turn this option ON when your Merchant Catalog doesn't include the variants for
                                        variable
                                        products.
                                    </p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4 pro-feature-container">
                                    <div class="d-flex align-items-center flex-with-badge">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">For product pages, track the variation data when a variation is selected</h4>
                                    </div>
                                    <?php renderProBadge(); ?>
                                </div>

                                <div>
                                    <?php GATags()->render_checkbox_input( 'woo_variations_use_parent_name', "When tracking variations, use the parent name" ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID</label>
                                    </div>

                                    <?php GATags()->render_select_input( 'woo_content_id', array(
                                        'product_id'  => 'Product ID',
                                        'product_sku' => 'Product SKU',
                                    ) ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID prefix</label>
                                    </div>

                                    <?php GATags()->render_text_input( 'woo_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID suffix</label>
                                    </div>

                                    <?php GATags()->render_text_input( 'woo_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <?php if ( isWPMLActive() ) : ?>
                                    <div>
                                        <div class="gap-24">
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>WPML Detected.</strong> Select your ID
                                                    logic.
                                                </h4>

                                                <div class="d-flex align-items-center mb-4">
                                                    <?php GATags()->render_switcher_input( 'woo_wpml_unified_id' ); ?>
                                                    <h4 class="switcher-label secondary_heading">WPML Unified ID logic</h4>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>Default language IDs</strong> logic.
                                                </h4>
                                                <div class="d-flex align-items-center justify-content-between pro-feature-container mb-4">
                                                    <div class="d-flex align-items-center flex-with-badge">
                                                        <?php renderDummySelectInput( 'Select language');?>
                                                    </div>
                                                    <?php renderProBadge(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="form-text">
                                            If you use localized feeds, enable the unified ID logic for the tag and we will use the native product ID for each translated item.
                                        </p>
                                    </div>
                                <?php endif; ?>
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
                                    <div class="d-flex align-items-center mb-4">
                                        <?php Pinterest()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                                        <h4 class="switcher-label secondary_heading">Treat variable products like simple
                                            products</h4>
                                    </div>

                                    <p class="form-text">
                                        If you enable this option, the main ID will be used instead of the variation ID.
                                        Turn this option ON when your Product Catalog doesn't include the variants for
                                        variable products.
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between pro-feature-container mb-4">
                                    <div class="d-flex align-items-center flex-with-badge">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">For product pages, track the variation data when a variation is selected</h4>
                                    </div>
                                    <?php renderProBadge(); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID</label>
                                    </div>

                                    <?php Pinterest()->render_select_input( 'woo_content_id', array(
                                        'product_id'  => 'Product ID',
                                        'product_sku' => 'Product SKU',
                                    ) ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID prefix</label>
                                    </div>

                                    <?php Pinterest()->render_text_input( 'woo_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID suffix</label>
                                    </div>

                                    <?php Pinterest()->render_text_input( 'woo_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <?php if ( isWPMLActive() ) : ?>
                                    <div>
                                        <div class="gap-24">
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>WPML Detected.</strong> Select your ID
                                                    logic.
                                                </h4>

                                                <div class="d-flex align-items-center mb-4">
                                                    <?php Pinterest()->render_switcher_input( 'woo_wpml_unified_id' ); ?>
                                                    <h4 class="switcher-label secondary_heading">WPML Unified ID logic</h4>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>Default language IDs</strong> logic.
                                                </h4>
                                                <div class="d-flex align-items-center justify-content-between pro-feature-container mb-4">
                                                    <div class="d-flex align-items-center flex-with-badge">
                                                        <?php renderDummySelectInput( 'Select language');?>
                                                    </div>
                                                    <?php renderProBadge(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="form-text">
                                            If you use localized feeds, enable the unified ID logic for the tag and we will use the native product ID for each translated item.
                                        </p>
                                    </div>
                                <?php endif; ?>
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
                                    <div class="d-flex align-items-center mb-4">
                                        <?php Bing()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                                        <h4 class="switcher-label secondary_heading">Treat variable products like simple
                                            products</h4>
                                    </div>

                                    <p class="form-text">
                                        If you enable this option, the main ID will be used instead of the variation ID.
                                        Turn this option ON when your Product Catalog doesn't include the variants for
                                        variable products.
                                    </p>
                                </div>


                                <div class="d-flex align-items-center justify-content-between pro-feature-container mb-4">
                                    <div class="d-flex align-items-center flex-with-badge">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">For product pages, track the variation data when a variation is selected</h4>
                                    </div>
                                    <?php renderProBadge(); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID</label>
                                    </div>

                                    <?php Bing()->render_select_input( 'woo_content_id', array(
                                        'product_id'  => 'Product ID',
                                        'product_sku' => 'Product SKU',
                                    ) ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID prefix</label>
                                    </div>
                                    <?php Bing()->render_text_input( 'woo_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID suffix</label>
                                    </div>

                                    <?php Bing()->render_text_input( 'woo_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <?php if ( isWPMLActive() && Bing()->getOption( 'woo_wpml_unified_id' ) !== NULL ) : ?>
                                    <div>
                                        <div class="gap-24">
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>WPML Detected.</strong> Select your ID
                                                    logic.
                                                </h4>

                                                <div class="d-flex align-items-center mb-4">
                                                    <?php Bing()->render_switcher_input( 'woo_wpml_unified_id' ); ?>
                                                    <h4 class="switcher-label secondary_heading">WPML Unified ID logic</h4>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>Default language IDs</strong> logic.
                                                </h4>
                                                <div class="d-flex align-items-center justify-content-between pro-feature-container mb-4">
                                                    <div class="d-flex align-items-center flex-with-badge">
                                                        <?php renderDummySelectInput( 'Select language');?>
                                                    </div>
                                                    <?php renderProBadge(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="form-text">
                                            If you use localized feeds, enable the unified ID logic for the tag and we will use the native product ID for each translated item.
                                        </p>
                                    </div>
                                <?php endif; ?>
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
                                    <div class="d-flex align-items-center mb-4">
							            <?php Reddit()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                                        <h4 class="switcher-label secondary_heading">Treat variable products like simple
                                            products</h4>
                                    </div>

                                    <p class="form-text">
                                        If you enable this option, the main ID will be used instead of the variation ID.
                                        Turn this option ON when your Product Catalog doesn't include the variants for
                                        variable products.
                                    </p>
                                </div>


                                <div class="d-flex align-items-center">
						            <?php Reddit()->render_switcher_input( 'woo_variable_data_select_product' ); ?>
                                    <h4 class="switcher-label secondary_heading">For product pages, track the variation
                                        data when a variation is selected</h4>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID</label>
                                    </div>

						            <?php Reddit()->render_select_input( 'woo_content_id', array(
							            'product_id'  => 'Product ID',
							            'product_sku' => 'Product SKU',
						            ) ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID prefix</label>
                                    </div>
						            <?php Reddit()->render_text_input( 'woo_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID suffix</label>
                                    </div>

						            <?php Reddit()->render_text_input( 'woo_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

					            <?php if ( isWPMLActive() && Reddit()->getOption( 'woo_wpml_unified_id' ) !== NULL ) : ?>
                                    <div>
                                        <div class="gap-24">
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>WPML Detected.</strong> Select your ID
                                                    logic.
                                                </h4>

                                                <div class="d-flex align-items-center mb-4">
										            <?php Reddit()->render_switcher_input( 'woo_wpml_unified_id' ); ?>
                                                    <h4 class="switcher-label secondary_heading">WPML Unified ID logic</h4>
                                                </div>
                                            </div>
								            <?php if ( ! empty( $languages ) ) { ?>
                                                <div>
                                                    <h4 class="primary_heading mb-16"><strong>Default language IDs</strong>
                                                        logic.
                                                    </h4>
                                                    <div class="d-flex align-items-center mb-4">
											            <?php  Reddit()->render_select_input( 'woo_wpml_language', $languages ); ?>
                                                    </div>
                                                </div>
								            <?php } ?>
                                        </div>
                                        <p class="form-text">
                                            If you use localized feeds, enable the unified ID logic for the tag and we
                                            will
                                            use
                                            the native product ID for each translated item.
                                        </p>
                                    </div>
					            <?php endif; ?>
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
                                    <div class="d-flex align-items-center mb-4">
                                        <?php GTM()->render_switcher_input( 'woo_variable_as_simple' ); ?>
                                        <h4 class="switcher-label secondary_heading">Treat variable products like simple
                                            products</h4>
                                    </div>

                                    <p class="form-text">
                                        If you enable this option, the main ID will be used instead of the variation ID.
                                        Turn this option ON when your Merchant Catalog doesn't include the variants for
                                        variable products.
                                    </p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between pro-feature-container mb-4">
                                    <div class="d-flex align-items-center flex-with-badge">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">For product pages, track the variation data when a variation is selected</h4>
                                    </div>
                                    <?php renderProBadge(); ?>
                                </div>

                                <div>
                                    <?php GTM()->render_checkbox_input( 'woo_variations_use_parent_name', "When tracking variations, use the parent name" ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID</label>
                                    </div>

                                    <?php GTM()->render_select_input( 'woo_content_id', array(
                                        'product_id'  => 'Product ID',
                                        'product_sku' => 'Product SKU',
                                    ) ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID prefix</label>
                                    </div>
                                    <?php GTM()->render_text_input( 'woo_content_id_prefix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <div>
                                    <div class="mb-8">
                                        <label class="primary_heading">ID suffix</label>
                                    </div>

                                    <?php GTM()->render_text_input( 'woo_content_id_suffix', '(optional)', false, false, false, 'short' ); ?>
                                </div>

                                <?php if ( isWPMLActive() ) : ?>
                                    <div>
                                        <div class="gap-24">
                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>WPML Detected.</strong> Select your ID
                                                    logic.
                                                </h4>

                                                <div class="d-flex align-items-center mb-4">
                                                    <?php GTM()->render_switcher_input( 'woo_wpml_unified_id' ); ?>
                                                    <h4 class="switcher-label secondary_heading">WPML Unified ID logic</h4>
                                                </div>
                                            </div>

                                            <div>
                                                <h4 class="primary_heading mb-16"><strong>Default language IDs</strong> logic.
                                                </h4>
                                                <div class="d-flex align-items-center justify-content-between pro-feature-container mb-4">
                                                    <div class="d-flex align-items-center flex-with-badge">
                                                        <?php renderDummySelectInput( 'Select language');?>
                                                    </div>
                                                    <?php renderProBadge(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="form-text">
                                            If you use localized feeds, enable the unified ID logic for the tag and we will use the native product ID for each translated item.
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Google Dynamic Remarketing Vertical -->
                <?php if ( GA()->enabled() ) : ?>
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
                                    <?php renderDummyRadioInput( 'Use Retail Vertical  (select this if you have access to Google Merchant)' , true ); ?>
                                    <?php renderDummyRadioInput( 'Use Custom Vertical (select this if Google Merchant is not available for your country)' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recommended events -->
    <div class="card card-style5 woo-recommended-events">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">Recommended events</h4>
            </div>
        </div>

        <div class="card-body" style="display: block;">

            <!-- Purchases -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="disable-card d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'woo_purchase_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track Purchases</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>

                <div class="card-body">
                    <div class="gap-24">
                        <div>
                            <?php PYS()->renderValueOptionsBlock( 'woo_purchase', false ); ?>
                        </div>

                        <div class="d-flex pro-feature-container">
                            <?php renderDummyCheckbox( 'Fire the event only once for each order (disable when testing)', true ); ?>
                            <?php renderPopoverButton( 'woo_purchase_on_transaction', 'top' ); ?>
                        </div>

                        <div class="pro-feature-container">
                            <?php renderDummyCheckbox( "Don't fire the event for 0 value transactions", true ); ?>
                        </div>

                        <div class="pro-feature-container">
                            <?php renderDummyCheckbox( "Don't fire the event when the number of items is 0", true ); ?>
                        </div>

                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <label class="primary_heading">Fire the Purchase Event for the following order status:</label>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>
                            <div class="wc-order-statuses mb-12">
                                <?php
                                $statuses = wc_get_order_statuses();
                                foreach ( $statuses as $status => $status_name ) {
                                    renderDummyCheckbox( esc_html( $status_name ));
                                }
                                ?>
                            </div>

                            <div>
                                <?php renderWarningMessage( 'The Purchase event fires when the client makes a transaction on your website. It won\'t fire on when the order status is modified afterward.' ); ?>
                            </div>
                        </div>

                        <?php if ( Facebook()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'woo_purchase_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the Purchase event on Facebook
                                    (required for DPA)</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GA()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'woo_purchase_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the purchase event on Google
                                    Analytics</h4>
                            </div>
                        <?php endif; ?>
                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the purchase event on Google
                                        Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>

                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                        </div>

                        <?php if ( Pinterest()->enabled() || Bing()->enabled() ) : ?>
                            <div class="line"></div>
                        <?php endif; ?>

                        <?php if ( Pinterest()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'woo_purchase_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the Checkout event on Pinterest</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Bing()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'woo_purchase_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the Purchase event on Bing</h4>
                                <?php renderPopoverButton( 'woo_bing_enable_purchase' ); ?>
                            </div>
                        <?php endif; ?>

	                    <?php if ( Reddit()->enabled() ) : ?>
                            <div class="d-flex align-items-center">
			                    <?php Reddit()->render_switcher_input( 'woo_purchase_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the Purchase event on Reddit</h4>
                            </div>
	                    <?php endif; ?>

                        <?php if ( GTM()->enabled() ) : ?>
                            <div class="line"></div>

                            <div class="d-flex align-items-center">
                                <?php GTM()->render_switcher_input( 'woo_purchase_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the purchase event on GTM
                                    dataLayer</h4>
                            </div>
                        <?php endif; ?>

                        <div class="line"></div>
                        <!-- Conversion with Card Data (CwCD) -->
                        <!-- @link: https://support.google.com/google-ads/answer/14944137?hl=en&ref_topic=14944136&sjid=17986014926685062911-EU#zippy=%2Cset-up-with-google-ads%2Cset-up-with-google-analytics -->

                        <div class="gap-24">
                            <div>
                                <div class="d-flex align-items-center mb-8">
                                    <?php PYS()->render_switcher_input( "enable_CwCD" ); ?>
                                    <h4 class="switcher-label secondary_heading">Enable Conversion with Card Data (CwCD) optional fileds</h4>
                                </div>
                                <p class="text-gray">
                                    <div class="mt-8">Optional, useful when using <a href="https://www.pixelyoursite.com/google-automated-discounts-for-woocommerce" target="_blank">Google Automated Discounts</a> </div>
                                </p>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-8">
                                    <label class="primary_heading"><?php _e('aw_merchant_id:', 'pys');?></label>
                                    <?php renderPopoverButton( 'aw_merchant_id' ); ?>
                                </div>
                                <?php PYS()->render_text_input( 'aw_merchant_id','', false, false, false, 'short' ); ?>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-8">
                                    <label class="primary_heading"><?php _e('aw_feed_label:', 'pys');?></label>
                                    <?php renderPopoverButton( 'aw_feed_label' ); ?>
                                </div>
                                <?php PYS()->render_text_input( 'aw_feed_label','', false, false, false, 'short' ); ?>
                                <p class="small-text text-gray">
                                    Supported only when using Google Analytics as conversion source
                                </p>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-8">
                                    <label class="primary_heading"><?php _e('aw_feed_country:', 'pys');?></label>
                                    <?php renderPopoverButton( 'aw_feed_country' ); ?>
                                </div>
                                <?php PYS()->render_select_input( 'aw_feed_country',get_aw_feed_country_codes(), false, false, false, true ); ?>
                                <p class="small-text text-gray">
                                    <b>Note:</b> When using Google Analytics as a conversion source, please use the parameter aw_feed_label instead.
                                </p>
                            </div>

                            <div>
                                <div class="d-flex align-items-center mb-8">
                                    <label class="primary_heading"><?php _e('aw_feed_language:', 'pys');?></label>
                                    <?php renderPopoverButton( 'aw_feed_language' ); ?>
                                </div>
                                <?php PYS()->render_select_input( 'aw_feed_language',get_aw_feed_language_codes(), false, false, false, true ); ?>
                            </div>
                        </div>

                        <div class="line"></div>

                        <?php
                        $message = 'This event will be fired on the order-received, the default WooCommerce "thank you
                        page". If you use PayPal, make sure that auto-return is ON. If you want to use "custom thank you
                        pages", you must configure them with our <a href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/the-super-pack"
                                                                    target="_blank" class="link">Super Pack</a>.';
                        renderWarningMessage( $message ); ?>
                    </div>
                </div>
            </div>

            <!-- InitiateCheckout -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="disable-card d-flex align-items-center">
                        <?php PYS()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track the Checkout Page</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>

                <div class="card-body">
                    <div class="gap-24">
                        <div>
                            <?php PYS()->renderValueOptionsBlock( 'woo_initiate_checkout' ); ?>
                        </div>

                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the InitiateCheckout event on
                                    Facebook</h4>
                            </div>
                        <?php endif; ?>
                        <?php if ( GA()->enabled() ) : $configured = true;?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the begin_checkout event on Google Analytics</h4>
                            </div>
                        <?php endif; ?>
                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the begin_checkout event on
                                        Google Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>

                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                        </div>

                        <?php if ( Pinterest()->enabled() || Bing()->enabled()) : ?>
                            <div class="line"></div>
                        <?php endif; ?>

                        <?php if ( Pinterest()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the InitiateCheckout on
                                    Pinterest</h4>
                                <?php Pinterest()->renderAddonNotice(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( Bing()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the InitiateCheckout on Bing</h4>
                                <?php Bing()->renderAddonNotice(); ?>
                            </div>
                        <?php endif; ?>


                        <?php if ( GTM()->enabled() ) : ?>
                            <div>
                                <?php if ( $configured ) : ?>
                                    <div class="line mb-24"></div>
                                <?php endif; ?>

                                <div class="d-flex align-items-center">
                                    <?php GTM()->render_switcher_input( 'woo_initiate_checkout_enabled' ); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the begin_checkout event on GTM
                                        dataLayer</h4>
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
                        <?php PYS()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track add to cart</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>

                <div class="card-body">
                    <div class="gap-24">
                        <div>
                            <?php PYS()->renderValueOptionsBlock( 'woo_add_to_cart' ); ?>
                        </div>

                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the AddToCart event on Facebook
                                    (required for DPA)</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GA()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the add_to_cart event on Google
                                    Analytics</h4>
                            </div>
                        <?php endif; ?>
                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center justify-content-between  mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the add_to_cart event on Google
                                        Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>

                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                        </div>

                        <?php if ( Pinterest()->enabled() || Bing()->enabled() ) : ?>
                            <div class="line"></div>
                        <?php endif; ?>

                        <?php if ( Pinterest()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the AddToCart event on
                                    Pinterest</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Bing()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the AddToCart event on Bing</h4>
                            </div>
                        <?php endif; ?>

	                    <?php if ( Reddit()->enabled() ) :
		                    $configured = true; ?>
                            <div class="d-flex align-items-center">
			                    <?php Reddit()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the AddToCart event on Reddit</h4>
                            </div>
	                    <?php endif; ?>

                        <?php if ( GTM()->enabled() ) : ?>
                            <div>
                                <?php if ( $configured ) : ?>
                                    <div class="line mb-24"></div>
                                <?php endif; ?>

                                <div class="d-flex align-items-center">
                                    <?php GTM()->render_switcher_input( 'woo_add_to_cart_enabled' ); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the add_to_cart event on GTM
                                        dataLayer</h4>
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
                        <?php PYS()->render_switcher_input( 'woo_view_content_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track product pages</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>

                <div class="card-body">
                    <div class="gap-24">
                        <div>
                            <?php PYS()->renderValueOptionsBlock( 'woo_view_content' ); ?>
                        </div>
                        <div>
                            <div class="d-flex align-items-center mb-4">
                                <?php PYS()->render_switcher_input( 'woo_view_content_variation_is_selected' ); ?>
                                <h4 class="switcher-label secondary_heading">Trigger an event when a variation is selected</h4>
                            </div>
                            <p class="text-gray">
                                It works when the tag is configured to <i>track the variation data when a variation is selected</i> - tags ID settings.</i>.
                            </p>
                        </div>
                        <div class="line"></div>
                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'woo_view_content_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewContent on Facebook
                                    (required
                                    for DPA)</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GA()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'woo_view_content_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the view_item event on Google
                                    Analytics</h4>
                            </div>
                        <?php endif; ?>
                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the view_item event on Google
                                        Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>
                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                        </div>

                        <?php if ( Pinterest()->enabled() || Bing()->enabled() || Reddit()->enabled() ) : ?>
                            <div class="line"></div>
                        <?php endif; ?>

                        <?php if ( Pinterest()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'woo_view_content_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the PageVisit event on
                                    Pinterest</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Bing()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'woo_view_content_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the PageVisit event on Bing</h4>
                            </div>
                        <?php endif; ?>

	                    <?php if ( Reddit()->enabled() ) :
		                    $configured = true; ?>
                            <div class="d-flex align-items-center">
			                    <?php Reddit()->render_switcher_input( 'woo_view_content_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewContent event on Reddit</h4>
                            </div>
	                    <?php endif; ?>

                        <?php if ( GTM()->enabled() ) : ?>
                            <div>
                                <?php if ( $configured ) : ?>
                                    <div class="line mb-24"></div>
                                <?php endif; ?>

                                <div class="d-flex align-items-center">
                                    <?php GTM()->render_switcher_input( 'woo_view_content_enabled' ); ?>
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
                        <?php PYS()->render_switcher_input( 'woo_view_category_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track product category pages</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>

                <div class="card-body">
                    <div class="gap-24">
                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'woo_view_category_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewCategory event on Facebook
                                    Analytics (used for DPA)</h4>
                            </div>
                        <?php endif; ?>
                        <div class="pro-feature-container">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the view_item_list event on Google
                                        Ads</h4>
                                </div>
                                <?php renderProBadge('https://www.pixelyoursite.com/google-ads-tag/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature'); ?>
                            </div>
                            <?php renderDummyGoogleAdsConversionLabelInputs(); ?>
                        </div>

                        <?php if ( Pinterest()->enabled() || Bing()->enabled() ) : ?>
                            <div class="line"></div>
                        <?php endif; ?>

                        <?php if ( Pinterest()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'woo_view_category_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewCategory event on
                                    Pinterest</h4>
                                <?php Pinterest()->renderAddonNotice(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( Bing()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Bing()->render_switcher_input( 'woo_view_category_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the ViewCategory event on Bing</h4>
                                <?php Bing()->renderAddonNotice(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( !$configured ) : ?>
                            <div class="critical_message">Error: No supported pixels are not configured</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- ViewCart -->
            <?php if ( GA()->enabled() ) : ?>
                <div class="card card-style6">
                    <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                        <div class="disable-card d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'woo_view_cart_enabled' ); ?>
                            <h4 class="secondary_heading_type2 switcher-label">Track cart pages</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>

                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <?php GA()->render_switcher_input( 'woo_view_cart_enabled' ); ?>
                            <h4 class="switcher-label secondary_heading">Enable the view_cart event on Google
                                Analytics</h4>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Track product list performance GA-->
            <div class="card card-style6">
                <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h4 class="secondary_heading_type2 switcher-label">Track product list performance on Google
                            Analytics</h4>
                    </div>
                    <div class="d-flex align-items-center flex-collapse-block">
                        <?php renderProBadge(); ?>
                        <?php cardCollapseSettings(); ?>
                    </div>
                </div>

                <div class="card-body">
                    <div class="pro-feature-container">
                        <div class="gap-24">
                            <div class="woo-track-products-list">
                                <div class="mb-12">
                                    <label class="primary_heading">Lists:</label>
                                </div>

                                <?php renderDummyCheckbox( 'Shop page'); ?>
                                <?php renderDummyCheckbox( 'Related product'); ?>
                                <?php renderDummyCheckbox( 'Category'); ?>
                                <?php renderDummyCheckbox( 'Tags'); ?>
                                <?php renderDummyCheckbox( 'Shortcodes'); ?>
                            </div>

                            <div class="line"></div>

                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center flex-with-badge">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Track names for lists</h4>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-gray">When checked, we send the data like we do now. Example:</p>
                                    <p class="text-gray">Category - iPhones</p>
                                </div>
                            </div>

                            <div class="line"></div>

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the view_item_list event on Google
                                        Analytics(categories, related products, search, shortcodes)</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the select_item event on Google
                                        Analytics(when a product is clicked on categories, related products, search,
                                        shortcodes)</h4>
                                </div>
                            </div>

                            <div class="line"></div>

                            <div>
                                <?php
                                renderWarningMessage( 'What parameters we add to the items table in for e-commerce events (item_list_id, item_list_name)' );
                                ?>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable item_list_name</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center flex-with-badge">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable item_list_id</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-style5 woo-advanced-events">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2"><?php _e('PRO Events', 'pys');?></h4>
            </div>
        </div>
    </div>
    <!-- Advanced Marketing Events -->
    <div class="card card-style5 woo-advanced-events">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2"><?php _e('Advanced Marketing Events', 'pys');?></h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>

        <div class="card-body">

            <!-- FrequentShopper -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
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
                                <div class="line"></div>

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

            <!-- FirstTimeBuyer Event -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="secondary_heading_type2 switcher-label">FirstTimeBuyer Event</h4>
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

                            <?php if ( GTM()->enabled() ) :
                                if ( $configured ) : ?>
                                    <div class="line"></div>
                                <?php endif;
                                $configured = true; ?>

                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to GTM dataLayer</h4>
                                </div>
                            <?php endif; ?>

                            <?php if ( !$configured ) : ?>
                                <div class="critical_message">Error: No supported pixels are not configured</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ReturningCustomer Event-->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="secondary_heading_type2 switcher-label">ReturningCustomer Event</h4>
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

                            <?php if ( GTM()->enabled() ) :
                                if ( $configured ) : ?>
                                    <div class="line"></div>
                                <?php endif;
                                $configured = true; ?>

                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Send the event to GTM dataLayer</h4>
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
    </div>


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
                        <?php PYS()->render_switcher_input( 'woo_remove_from_cart_enabled' ); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track remove from cart</h4>
                    </div>
                    <?php cardCollapseSettings(); ?>
                </div>

                <div class="card-body">
                    <div class="gap-24">
                        <?php $configured = false; ?>
                        <?php if ( Facebook()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'woo_remove_from_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the RemoveFromCart event on
                                    Facebook</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( GA()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php GA()->render_switcher_input( 'woo_remove_from_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the remove_from_cart event on Google
                                    Analytics</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( Pinterest()->enabled() ) :
                            $configured = true; ?>
                            <div class="d-flex align-items-center">
                                <?php Pinterest()->render_switcher_input( 'woo_remove_from_cart_enabled' ); ?>
                                <h4 class="switcher-label secondary_heading">Enable the RemoveFromCart event on
                                    Pinterest</h4>
                            </div>
                        <?php endif; ?>

                        <?php if ( !$configured ) : ?>
                            <div class="critical_message">Error: No supported pixels are not configured</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Track CompleteRegistration -->
            <?php if ( Facebook()->enabled() ) : ?>
                <div class="card card-style6 woo-extra-complete-registration">
                    <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                        <div class="disable-card d-flex align-items-center">
                            <?php PYS()->render_switcher_input( 'woo_complete_registration_enabled' ); ?>
                            <h4 class="secondary_heading_type2 switcher-label">Track CompleteRegistration for the Meta
                                Pixel</h4>
                        </div>
                        <?php cardCollapseSettings(); ?>
                    </div>

                    <div class="card-body">
                        <div class="gap-24">
                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_checkbox_input( 'woo_complete_registration_fire_every_time', "Fire this event every time a transaction takes place" ); ?>
                            </div>

                            <div class="woo-extra-complete-registration-block">
                                <?php Facebook()->renderValueOptionsBlock( 'woo_complete_registration', false, false, false, 'Event value on Facebook' ); ?>
                            </div>

                            <div class="d-flex align-items-center">
                                <?php Facebook()->render_switcher_input( 'woo_complete_registration_send_from_server' ); ?>
                                <h4 class="switcher-label secondary_heading">Send this from your server only. It won't
                                    be
                                    visible on your browser</h4>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ( GA()->enabled() ) : ?>
                <!-- Track Checkout Behavior on Google Analytics -->
                <div class="card card-style6">
                    <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="secondary_heading_type2 switcher-label">Track Checkout Behavior on Google
                                Analytics</h4>
                        </div>
                        <div class="d-flex align-items-center flex-collapse-block">
                            <?php renderProBadge(); ?>
                            <?php cardCollapseSettings(); ?>
                        </div>
                    </div>

                    <div class="card-body woo-extra-steps">
                        <div class="pro-feature-container">
                            <div class="woo-extra-step woo_initiate_checkout_enabled">
                                <div>
                                    <div class="step">STEP 1:</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the begin_checkout</h4>
                                    <?php renderPopoverButton( 'woo_initiate_checkout_event_value_1' ); ?>
                                </div>

                            </div>

                            <div class="woo-extra-step" style="display: none">
                                <div>
                                    <div class="empty-step"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable the set_checkout_option</h4>
                                </div>
                            </div>

                            <div class="woo-extra-step woo_initiate_checkout_progress_f_enabled checkout_progress">
                                <div>
                                    <div class="step"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable checkout_progress when the First
                                        Name is added </h4>
                                </div>
                            </div>

                            <div class="woo-extra-step woo_initiate_checkout_progress_l_enabled checkout_progress">
                                <div>
                                    <div class="step"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable checkout_progress when the Last Name
                                        is added </h4>
                                </div>
                            </div>

                            <div class="woo-extra-step woo_initiate_checkout_progress_e_enabled checkout_progress">
                                <div>
                                    <div class="step"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable checkout_progress when the Email is
                                        added </h4>
                                </div>
                            </div>

                            <div class="woo-extra-step woo_initiate_checkout_progress_o_enabled checkout_progress">
                                <div>
                                    <div class="step"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable checkout_progress when is Place
                                        Order is clicked </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <!-- Affiliate -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track WooCommerce affiliate button
                            clicks</h4>
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
                                <?php PYS()->renderValueOptionsBlock( 'woo_affiliate', false, true, false, '', true ); ?>
                            </div>

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

                            <?php if ( Pinterest()->enabled() ) : ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Pinterest</h4>
                                </div>
                            <?php endif; ?>

                            <div>
                                <div class="mb-8">
                                    <label class="primary_heading">Event Type:</label>
                                </div>

                                <?php renderDummySelectInput( 'Custom' ); ?>


                                <div class="mt-24 control-hidden-wrap">
                                    <?php renderDummyTextInput( 'Enter name', 'short' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PayPal -->
            <div class="card card-style6">
                <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <?php renderDummySwitcher(); ?>
                        <h4 class="secondary_heading_type2 switcher-label">Track WooCommerce PayPal Standard clicks</h4>
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
                                <?php PYS()->renderValueOptionsBlock( 'woo_paypal', false, true, false, '', true ); ?>
                            </div>

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

                            <?php if ( Pinterest()->enabled() ) : ?>
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher(); ?>
                                    <h4 class="switcher-label secondary_heading">Enable on Pinterest</h4>
                                </div>
                            <?php endif; ?>

                            <div>
                                <div class="mb-8">
                                    <label class="primary_heading">Event Type:</label>
                                </div>

                                <?php renderDummySelectInput( 'Custom' ); ?>

                                <div class="mt-24 control-hidden-wrap">
                                    <?php renderDummyTextInput( 'Enter name', 'short' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-style5 woo-export">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">Export transactions as offline conversions - Facebook (Meta)</h4>
            </div>
            <div class="d-flex align-items-center flex-collapse-block">
                <?php renderProBadge(); ?>
                <?php cardCollapseSettings(); ?>
            </div>
        </div>

        <div class="card-body">
            <div class="pro-feature-container">
                <p class="primary_heading mb-24">Learn how to use it: <a href="https://www.youtube.com/watch?v=vNsiWh0cakA"
                                                                         target="_blank" class="link">watch video</a></p>

                <div class="woo-export-statuses mb-24">
                    <div class="mb-12">
                        <label class="primary_heading">Order status:</label>
                    </div>
                    <?php
                    $allStatus = wc_get_order_statuses();
                    foreach ( $allStatus as $key => $label ) :
                        $checked = "";
                        if ( $key == "wc-completed" ) {
                            $checked = "checked";
                        }
                        $id = "pys_order_status_" . $key;

                        ?>
                        <div class="small-checkbox">
                            <input type="checkbox" disabled="disabled" id="<?php echo esc_attr( $id ); ?>" name="order_status[]"
                                   value="<?php echo esc_attr( $key ); ?>"
                                   class="small-control-input order_status"
                                <?php echo esc_attr( $checked ); ?>>
                            <label class="small-control small-checkbox-label" for="<?php echo esc_attr( $id ); ?>">
                                <span class="small-control-indicator"><i class="icon-check"></i></span>
                                <span class="small-control-description"><?php echo wp_kses_post( $label ); ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="line mb-24"></div>

                <div class="mb-24">
                    <div class="mb-8">
                        <label class="primary_heading">Select</label>
                    </div>

                    <div class="select-standard-wrap">
                        <select class="select-standard"
                                id="woo_export_purchase" disabled="disabled">
                            <option value="export_last_time" selected="selected">Export from last time</option>
                            <option value="export_by_date">Export by dates</option>
                            <option value="export_all">Export all orders</option>
                        </select>
                    </div>
                </div>

                <div class="woo-export-actions">
                    <div class="woo-export-actions-buttons">
                        <span class="btn btn-primary btn-primary-type2 disabled"><?php _e( 'Export all the data', 'pys' ); ?></span>
                    </div>

                    <div id="woo_generate_export_loading" style="display:none">
                        <div class="export-loading">
                            <img src="<?php echo esc_url( PYS_FREE_URL . '/dist/images/loader.svg' ); ?>" class="pys-loader waiting"
                                 alt="pys-loader"/>
                            <div>
                                <span class="current">0</span>/<span class="max">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WooCommerce Parameters -->
    <div class="card card-style5 woo-params-block">
        <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="secondary_heading_type2">WooCommerce Parameters</h4>
            </div>

            <?php cardCollapseSettings(); ?>
        </div>
        <div class="card-body woo-params-list">
            <!-- Control the WooCommerce Parameters -->
            <div class="card about-params card-style3">
                <div class="card-header card-header-style2">
                    <div class="disable-card d-flex align-items-center">
                        <h4 class="secondary_heading_type2">Control the WooCommerce Parameters</h4>
                    </div>
                </div>

                <div class="card-body" style="display: block">
                    <div class="gap-24">
                        <p>
                            You can use these parameters to create audiences, custom conversions, or goals. We recommend
                            keeping them active. If you get privacy warnings about some of these parameters, you can
                            turn
                            them OFF.
                        </p>

                        <div class="woo-control-parameters">
                            <div class="woo-control-parameter-item">
                                <?php PYS()->render_switcher_input( 'enable_woo_category_name_param' ); ?>
                                <h4 class="switcher-label secondary_heading">category_name</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php PYS()->render_switcher_input( 'enable_woo_num_items_param' ); ?>
                                <h4 class="switcher-label secondary_heading">num_items</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php PYS()->render_switcher_input( 'enable_woo_tags_param' ); ?>
                                <h4 class="switcher-label secondary_heading">tags</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php PYS()->render_switcher_input( 'enable_woo_fees_param' ); ?>
                                <h4 class="switcher-label secondary_heading">fees</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">total (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">transactions_count (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">tax (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">predicted_ltv (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">average_order (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">coupon_used (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">coupon_name (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">shipping (PRO)</h4>
                            </div>

                            <div class="woo-control-parameter-item">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading">shipping_cost (PRO)</h4>
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
                        <h4 class="heading-with-icon bold-heading">About WooCommerce Events Parameters</h4>
                    </div>
                </div>

                <div class="card-body" style="display: block;">
                    <p class="mb-24">All events get the following Global Parameters for all the tags: <span
                                class="parameters-list">page_title, post_type, post_id,
                            landing_page, event_URL, user_role, plugin, event_time (pro),
                            event_day (pro), event_month (pro), traffic_source (pro), UTMs (pro)</span>.
                    </p>

                    <p>The Meta Pixel events are Dynamic Ads ready.</p>
                    <p>The Google Analytics events track Monetization data (GA4).</p>
                    <p>The Google Ads events have the required data for Dynamic Remarketing
                        (<a href="https://support.google.com/google-ads/answer/7305793" target="_blank" class="link">official
                            help</a>).
                    </p>
                    <p class="mb-24">The Pinterest events have the required data for Dynamic Remarketing.</p>

                    <p>The Purchase event will have the following extra-parameters:
                        <span class="parameters-list">category_name, num_items, tags, total (pro), transactions_count (pro), tax (pro),
                            predicted_ltv (pro), average_order (pro), coupon_used (pro), coupon_code (pro), shipping (pro),
                            shipping_cost (pro), fee (pro)</span>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
