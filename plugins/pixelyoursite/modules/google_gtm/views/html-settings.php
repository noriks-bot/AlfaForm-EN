<?php

namespace PixelYourSite;
use PixelYourSite\GTM\Helpers;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<div class="cards-wrapper cards-wrapper-style2 gap-24 settings-wrapper">
    <!-- Event Settings -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Event Settings', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <div class="d-flex align-items-center">
                        <?php GTM()->render_switcher_input( 'track_page_view' ); ?>
                        <h4 class="switcher-label secondary_heading"><?php _e('Track page_view in the Data Layer', 'pys');?></h4>
                    </div>
                </div>
                <div class="line"></div>
                <div class="pro-feature-container d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="d-flex align-items-center flex-with-badge">
                                <?php renderDummySwitcher(); ?>
                                <h4 class="switcher-label secondary_heading"><?php _e('Enable Remarketing Param', 'pys');?></h4>
                            </div>
                        </div>
                        <p class="text-gray">
                            Adds <b>ecomm</b> or <b>dynx</b> parameters depending on the selected <b>Google Dynamic Remarketing Vertical</b> option in the Woo or Edd tab
                        </p>
                    </div>
                    <?php renderProBadge(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Advanced', 'pys');?></h4>
        </div>
        <div class="card-body">
            <div class="gap-24">
                <div>
                    <h4 class="primary_heading mb-4"><?php _e( 'dataLayer variable name:', 'pys' );?></h4>
                    <?php GTM()->render_text_input('gtm_dataLayer_name'); ?>
                </div>
                <div class="gap-24">
                    <h4 class="primary_heading"><?php _e( 'Server-side Tagging (sGTM):', 'pys' );?></h4>
                    <div class="">
                        <h4 class="secondary_heading mb-8"><?php _e( 'sGTM Container Domain:', 'pys' );?></h4>
                        <?php GTM()->render_text_input( 'gtm_container_domain'); ?>
                        <p class="text-gray">
                            <? _e( 'Enter your custom domain name if you are using a custom server side GTM container for tracking.', 'pys' );?>
                        </p>
                    </div>
                    <div>
                        <h4 class="secondary_heading mb-8"><?php _e( 'sGTM container identifier:', 'pys' );?></h4>
                        <?php GTM()->render_text_input( 'gtm_container_identifier'); ?>
                        <p class="text-gray">
                            <? _e( 'Only use if you are using a custom loader.', 'pys' );?>
                        </p>
                    </div>
                </div>
                <div class="gap-24">
                    <h4 class="primary_heading"><?php _e( 'Google Tag Manager Environment', 'pys' );?></h4>
                    <div class="">
                        <h4 class="secondary_heading mb-8"><?php _e( 'gtm_auth:', 'pys' );?></h4>
                        <?php GTM()->render_text_input( 'gtm_auth', 'Enter gtm_auth code'); ?>
                        <p class="text-gray">
                            <?php _e( 'Enter your gtm_auth code your GTM environment.', 'pys' );?>
                        </p>
                    </div>
                    <div>
                        <h4 class="secondary_heading mb-8"><?php _e( 'gtm_preview:', 'pys' );?></h4>
                        <?php GTM()->render_text_input( 'gtm_preview', 'Enter gtm_preview code'); ?>
                        <p class="text-gray">
                            <?php _e( 'Enter your gtm_preview code your GTM environment.', 'pys' );?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Security -->
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <h4 class="secondary_heading_type2"><?php _e('Security', 'pys');?></h4>
            <?php cardCollapseSettings(); ?>
        </div>
        <div class="card-body" style="display: none">
            <div class="check-list gap-16 mb-24">
                <?php GTM()->render_radio_input( 'check_list', 'disabled', __('Disable feature: control everything on Google Tag Manager interface', 'pys') ); ?>
                <?php GTM()->render_radio_input( 'check_list', 'blacklist', __('Allow all, except the checked items on all list tabs (blacklist)', 'pys') ); ?>
                <?php GTM()->render_radio_input( 'check_list', 'whitelist', __('Block all, except the checked items on all list tabs (whitelist)', 'pys') ); ?>
            </div>
            <div class="tabs">
                <div class="tab-buttons">
                    <button class="tab-btn active" data-tab="tab1"><?php _e('List tags', 'pys');?></button>
                    <button class="tab-btn" data-tab="tab2"><?php _e('List triggers', 'pys');?></button>
                    <button class="tab-btn" data-tab="tab3"><?php _e('List variables', 'pys');?></button>
                </div>

                <div class="tab-contents">
                    <?php
                    $blacklist_tabs = Helpers\get_all_blacklist_tabs();
                    ?>
                    <div id="tab1" class="tab-content active" style="display: block">
                        <div class="row">
                            <div class="col">
                                <div class="custom-controls-stacked custom-controls-blacklist">
                                    <div class="mb-24">
                                        <div class="small-checkbox">
                                            <input type="checkbox" id="select-all-tags" name="pys[gtm][select_all_blacklist][]"
                                                   value="select_all_tags"
                                                   class="small-control-input select-all"
                                                <?php echo in_array('select_all_tags', GTM()->getOption('select_all_blacklist')) ? "checked" : ""?>>
                                            <label class="small-control small-checkbox-label" for="select-all-tags">
                                                <span class="small-control-indicator"><i class="icon-check"></i></span>
                                                <span class="small-control-description"><?php _e('Select all', 'pys'); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="tab-column-container">
                                        <div class="tab-column">
                                            <?php
                                            $half = ceil(count($blacklist_tabs['tags']) / 2);
                                            $tags = array_chunk($blacklist_tabs['tags'], $half);
                                            foreach ($tags[0] as $blacklist_checkbox) {
                                                GTM()->render_checkbox_blacklist_input_array('check_list_contain', esc_html($blacklist_checkbox['tag']), esc_attr($blacklist_checkbox['id']));
                                            }
                                            ?>
                                        </div>
                                        <div class="tab-column">
                                            <?php
                                            foreach ($tags[1] as $blacklist_checkbox) {
                                                GTM()->render_checkbox_blacklist_input_array('check_list_contain', esc_html($blacklist_checkbox['tag']), esc_attr($blacklist_checkbox['id']));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab2" class="tab-content">
                        <div class="row">
                            <div class="col">
                                <div class="custom-controls-stacked custom-controls-blacklist">
                                    <div class="mb-24">
                                        <div class="small-checkbox">
                                            <input type="checkbox" id="select-all-triggers" name="pys[gtm][select_all_blacklist][]"
                                                   value="select_all_triggers"
                                                   class="small-control-input select-all"
                                                <?php echo in_array('select_all_triggers', GTM()->getOption('select_all_blacklist')) ? "checked" : ""?>>
                                            <label class="small-control small-checkbox-label" for="select-all-triggers">
                                                <span class="small-control-indicator"><i class="icon-check"></i></span>
                                                <span class="small-control-description"><?php _e('Select all', 'pys'); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="tab-column-container">
                                        <div class="tab-column">
                                            <?php
                                            $half = ceil(count($blacklist_tabs['triggers']) / 2);
                                            $triggers = array_chunk($blacklist_tabs['triggers'], $half);
                                            foreach ($triggers[0] as $blacklist_checkbox) {
                                                GTM()->render_checkbox_blacklist_input_array('check_list_contain', esc_html($blacklist_checkbox['trigger']), esc_attr($blacklist_checkbox['id']));
                                            }
                                            ?>
                                        </div>
                                        <div class="tab-column">
                                            <?php
                                            foreach ($triggers[1] as $blacklist_checkbox) {
                                                GTM()->render_checkbox_blacklist_input_array('check_list_contain', esc_html($blacklist_checkbox['trigger']), esc_attr($blacklist_checkbox['id']));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab3" class="tab-content">
                        <div class="row">
                            <div class="col">
                                <div class="custom-controls-stacked custom-controls-blacklist">
                                    <div class="mb-24">
                                        <div class="small-checkbox">
                                            <input type="checkbox" id="select-all-variables" name="pys[gtm][select_all_blacklist][]"
                                                   value="select_all_variables"
                                                   class="small-control-input select-all"
                                                <?php echo in_array('select_all_variables', GTM()->getOption('select_all_blacklist')) ? "checked" : ""?>>
                                            <label class="small-control small-checkbox-label" for="select-all-variables">
                                                <span class="small-control-indicator"><i class="icon-check"></i></span>
                                                <span class="small-control-description"><?php _e('Select all', 'pys'); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="tab-column-container">
                                        <div class="tab-column">
                                            <?php
                                            $half = ceil(count($blacklist_tabs['variables']) / 2);
                                            $variables = array_chunk($blacklist_tabs['variables'], $half);
                                            foreach ($variables[0] as $blacklist_checkbox) {
                                                GTM()->render_checkbox_blacklist_input_array('check_list_contain', esc_html($blacklist_checkbox['variable']), esc_attr($blacklist_checkbox['id']));
                                            }
                                            ?>
                                        </div>
                                        <div class="tab-column">
                                            <?php
                                            foreach ($variables[1] as $blacklist_checkbox) {
                                                GTM()->render_checkbox_blacklist_input_array('check_list_contain', esc_html($blacklist_checkbox['variable']), esc_attr($blacklist_checkbox['id']));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    jQuery(document).ready(function($) {
        $(".tab-btn").click(function(e) {
            e.preventDefault();

            var targetId = $(this).data("tab");
            var target = $("#" + targetId);

            // Remove the "active" class from all buttons and add it only to the current one
            $(".tab-btn").removeClass("active");
            $(this).addClass("active");

            // Close all tabs except the selected one
            $(".tab-content").not(target).slideUp(400).removeClass("active");

            // Toggle the selected tab
            if (target.hasClass("active")) {
                target.slideUp(400).removeClass("active");
            } else {
                target.slideDown(400).addClass("active");
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.select-all').forEach(selectAllCheckbox => {
            // Check the state of select-all on page load
            if (selectAllCheckbox.checked) {
                const checkboxes = selectAllCheckbox.closest('.custom-controls-blacklist').querySelectorAll('input[type="checkbox"]:not(.select-all)');
                checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
            }

            // Event handler for change event of select-all
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = this.closest('.custom-controls-blacklist').querySelectorAll('input[type="checkbox"]:not(.select-all)');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });
        });
    });
</script>