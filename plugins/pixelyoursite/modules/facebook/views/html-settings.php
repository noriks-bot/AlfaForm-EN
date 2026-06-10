<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<div class="cards-wrapper cards-wrapper-style2 gap-24 logs-wrapper">
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('General', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                 <div>
                    <div class="d-flex align-items-center mb-4">
                        <?php Facebook()->render_switcher_input( 'advanced_matching_enabled' ); ?>
                        <h4 class="switcher-label secondary_heading">Enable Advanced Matching</h4>
                    </div>
                </div>

                <div class="facebook-description">
                    <p class="text-gray pb-8">
                        <?php _e('Learn about Conversion API and Advanced Matching privacy and consent:', 'pys');?>
                        <a href="https://www.youtube.com/watch?v=PsKdCkKNeLU" target="_blank"
                           class="link">watch video</a>
                    </p>
                </div>
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <?php Facebook()->render_switcher_input( 'remove_metadata' ); ?>
                        <h4 class="switcher-label secondary_heading">autoConfig: false</h4>
                    </div>
                    <p class="text-gray"><?php _e('Remove Facebook default events', 'pys');?> </p>
                </div>

                <div>
                    <div class="d-flex align-items-center">
                        <?php Facebook()->render_switcher_input( 'disable_noscript' ); ?>
                        <h4 class="switcher-label secondary_heading"> <?php _e('Disable noscript', 'pys');?> </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Medical Content', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center mb-4">
                        <?php Facebook()->render_switcher_input( 'enabled_medical' ); ?>
                        <h4 class="switcher-label"><?php _e('Don\'t track parameters', 'pys');?></h4>
                    </div>
                </div>

                <div>
                    <p class="mb-8">
                        Meta imposes restrictions on tracking data for websites with medical-related content and products. Use this option to disable event parameters that might track such data. These settings apply to Meta Pixel and CAPI events. To disable parameters for all tags, use the default parameter controls.
                    </p>
                    <div class="d-flex align-items-center justify-content-between pro-feature-container">
                        <p>To replace the standard WooCommerce AddToCart or Purchase events with custom events, you’ll need the Pro version, as this functionality is only available on the Events Page in Pro.</p>
                        <?php renderProBadge(); ?>
                    </div>
                </div>

                <div>
                    <h4 class="primary_heading mb-4"><?php _e('Don\'t track these parameters for the Meta pixel and CAPI events:', 'pys');?></h4>
                    <?php Facebook()->render_multi_select_input('do_not_track_medical_param', getAllMetaEventParamName()); ?>
                    <p class="text-gray mt-8"><?php _e('If you want to disable parameters for all tags, use the default options from the plugin\'s main page, or from the WooCommerce and EDD pages.', 'pys');?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="panel card card-style6 card-static">
        <div class="card-body text-center">
                <p class="mb-0">Fire more events and parameters and improve your ads performance.
                    <br><a class="link" href="https://www.pixelyoursite.com/facebook-pixel-plugin?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-facebook-settings"
                           target="_blank">Find more about the PRO Meta Pixel (formerly Facebook Pixel) implementation</a></p>
        </div>
    </div>
</div>

