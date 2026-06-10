<?php
// phpcs:disable
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Classes\Product_Feed_Attributes;
use AdTribes\PFP\Classes\Upsell;

$country = '';

/**
 * Get shipping zones
 */
$shipping_zones    = WC_Shipping_Zones::get_zones();
$nr_shipping_zones = count( $shipping_zones );

$feed         = null;
$project_hash = isset( $_GET['project_hash'] ) ? sanitize_text_field( $_GET['project_hash'] ) : '';
$feed_id      = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
$edit_feed    = false;
if ( $feed_id ) {
    $feed           = Product_Feed_Helper::get_product_feed( sanitize_text_field( $feed_id ) );
    if ( $feed ) {
        $feed_country = $feed->get_legacy_country();
        $edit_feed    = true;
    }
} else {
    $feed         = get_option( ADT_OPTION_TEMP_PRODUCT_FEED, array() );
    $feed_country = isset( $feed['countries'] ) ? $feed['countries'] : '';
}

/**
 * Get countries and channels
 */
$countries = Product_Feed_Attributes::get_channel_countries();
$channels  = Product_Feed_Attributes::get_channels( $feed_country );

/**
 * Action hook to add content before the product feed manage page.
 *
 * @param int                      $step         Step number.
 * @param string                   $project_hash Project hash.
 * @param array|Product_Feed|null  $feed         Product_Feed object or array of project data.
 */
do_action( 'adt_before_product_feed_manage_page', 0, $project_hash, $feed );
?>

<div class="woo-product-feed-pro-form-style-2">
    <?php Helper::locate_admin_template( 'notices/upgrade-to-elite-notice.php', true ); ?>
    <?php Upsell::show_custom_refresh_interval_notice( $feed ); ?>
    <form class="adt-edit-feed-form" id="general" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <?php wp_nonce_field( 'woosea_ajax_nonce' ); ?>
        <input type="hidden" name="action" value="edit_feed_form_process" />
        <input type="hidden" name="active_tab" value="general" />
        <input type="hidden" name="feed_id" value="<?php echo $feed_id; ?>" />

        <div class="woo-product-feed-pro-table-wrapper">
            <div class="woo-product-feed-pro-table-left">

                <table class="woo-product-feed-pro-table">
                    <tbody class="woo-product-feed-pro-body">
                        <div id="projecterror"></div>
                        <tr>
                            <td width="30%"><span><?php esc_html_e( 'Project name', 'woo-product-feed-pro' ); ?>:<span class="required">*</span></span></td>
                            <td>
                                <div style="display: block;">
                                    <?php if ( $edit_feed ) : ?> 
                                        <input type="text" class="input-field" id="projectname" name="projectname" value="<?php echo esc_attr( $feed->title ); ?>" required/>
                                        <div id="projecterror"></div>
                                    <?php else : ?>
                                        <input type="text" class="input-field" id="projectname" name="projectname" value="<?php echo isset( $feed['projectname'] ) ? esc_attr( $feed['projectname'] ) : ''; ?>" required/>
                                        <div id="projecterror"></div>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php

                        /**
                         * Action hook to add content before the country field.
                         *
                         * @since 13.3.6
                         * @param array|Product_Feed|null $feed Product_Feed object or array of project data.
                         */
                        do_action( 'adt_general_feed_settings_before_country_field', $feed );
                        ?>
                        <tr>
                            <td><span><?php esc_html_e( 'Country', 'woo-product-feed-pro' ); ?>:</span></td>
                            <td>
                                <?php if ( ! $edit_feed || ( $edit_feed && $feed && Product_Feed_Helper::is_all_feeds_channel( $feed->get_channel('fields') ) ) ) : ?> 
                                <select name="countries" id="countries" class="select-field woo-sea-select2" data-is_new_feed="<?php echo $edit_feed ? false : true; ?>">
                                    <option value=""><?php esc_html_e( 'Select a country', 'woo-product-feed-pro' ); ?></option>
                                    <?php foreach ( $countries as $value ) : ?>
                                    <option value="<?php echo esc_attr( $value ); ?>" <?php echo isset( $feed_country ) && $feed_country === $value ? 'selected' : ''; ?>>
                                        <?php echo esc_html( $value ); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php else : ?>
                                <select name="countries" id="countries" class="select-field woo-sea-select2" disabled>
                                    <option value="<?php echo esc_attr( $feed_country ); ?>" selected>
                                        <?php if ( ! empty( $feed_country ) ) : ?>
                                            <?php echo esc_html( $feed_country ); ?>
                                        <?php else : ?>
                                            <?php esc_html_e( 'Select a country', 'woo-product-feed-pro' ); ?>
                                        <?php endif; ?>
                                    </option>
                                </select>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span><?php esc_html_e( 'Channel', 'woo-product-feed-pro' ); ?>:</span></td>
                            <td>
                                <?php if ( $edit_feed ) : ?> 
                                <select name="channel_hash" id="channel_hash" class="select-field woo-sea-select2" disabled>
                                    <option value="<?php echo esc_html( $feed->channel_hash ); ?>" selected><?php echo esc_html( $feed->get_channel( 'name' ) ); ?></option>
                                </select>
                                <?php else : ?>
                                <select name="channel_hash" id="channel_hash" class="select-field woo-sea-select2">
                                    <?php
                                    $selected_channel = isset( $feed['channel_hash'] ) ? Product_Feed_Helper::get_channel_from_legacy_channel_hash( $feed['channel_hash'] ) : '';
                                    $selected_channel_name = isset( $selected_channel['name'] ) ? $selected_channel['name'] : 'Google Shopping';
                                    echo Product_Feed_Helper::print_channel_options( $channels, $selected_channel_name );
                                    ?>
                                </select>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr id="product_variations">
                            <td><span><?php esc_html_e( 'Include product variations', 'woo-product-feed-pro' ); ?>:</span></td>
                            <td>
                                <label class="woo-product-feed-pro-switch">
                                    <?php if ( $edit_feed ) : ?> 
                                        <input type="checkbox" id="variations" name="product_variations" class="checkbox-field" <?php echo $feed->include_product_variations ? 'checked' : ''; ?>>
                                    <?php else : ?>
                                        <input type="checkbox" id="variations" name="product_variations" class="checkbox-field" <?php echo isset( $feed['product_variations'] ) && 'on' === $feed['product_variations'] ? 'checked' : ''; ?>>
                                    <?php endif; ?>
                                    <div class="woo-product-feed-pro-slider round"></div>
                                </label>
                            </td>
                        </tr>
                        <tr id="default_variation">
                            <td><span><?php esc_html_e( 'And only include default product variation', 'woo-product-feed-pro' ); ?>:</span></td>
                            <td>
                                <label class="woo-product-feed-pro-switch">
                                    <?php if ( $edit_feed ) : ?> 
                                        <input type="checkbox" id="default_variations" name="default_variations" class="checkbox-field" <?php echo $feed->only_include_default_product_variation ? 'checked' : ''; ?>>
                                    <?php else : ?>
                                        <input type="checkbox" id="default_variations" name="default_variations" class="checkbox-field" <?php echo isset( $feed['default_variations'] ) && 'on' === $feed['default_variations'] ? 'checked' : ''; ?>>
                                    <?php endif; ?>
                                    <div class="woo-product-feed-pro-slider round"></div>
                                </label>
                            </td>
                        </tr>
                        <tr id="lowest_price_variation">
                            <td><span><?php esc_html_e( 'And only include lowest priced product variation(s)', 'woo-product-feed-pro' ); ?>:</span></td>
                            <td>
                                <label class="woo-product-feed-pro-switch">
                                    <?php if ( $edit_feed ) : ?> 
                                        <input type="checkbox" id="lowest_price_variations" name="lowest_price_variations" class="checkbox-field" <?php echo $feed->only_include_lowest_product_variation ? 'checked' : ''; ?>>
                                    <?php else : ?>
                                        <input type="checkbox" id="lowest_price_variations" name="lowest_price_variations" class="checkbox-field" <?php echo isset( $feed['lowest_price_variations'] ) && 'on' === $feed['lowest_price_variations'] ? 'checked' : ''; ?>>
                                    <?php endif; ?>
                                    <div class="woo-product-feed-pro-slider round"></div>
                                </label>
                            </td>
                        </tr>
                        <tr id="include_all_shipping_countries" class="">
                            <td class="adt-tw-align-top">
                                <span class="adt-tw-mt-1 adt-tw-block">
                                    <?php esc_html_e( 'Include all shipping countries', 'woo-product-feed-pro' ); ?>
                                    <?php echo wc_help_tip( __( 'WARNING: This will create massive feed files and may cause server timeouts.', 'woo-product-feed-pro' ) ); ?>
                                </span>
                            </td>
                            <td>
                                <div>
                                    <label class="adt-tw-peer woo-product-feed-pro-switch adt-include-all-shipping-countries-switch">
                                        <?php if ( $edit_feed ) : ?> 
                                            <input type="checkbox" id="include_all_shipping_countries" name="include_all_shipping_countries" class="checkbox-field" <?php echo $feed->include_all_shipping_countries ? 'checked' : ''; ?>>
                                        <?php else : ?>
                                            <input type="checkbox" id="include_all_shipping_countries" name="include_all_shipping_countries" class="checkbox-field" <?php echo isset( $feed['include_all_shipping_countries'] ) && 'on' === $feed['include_all_shipping_countries'] ? 'checked' : ''; ?>>
                                        <?php endif; ?>
                                        <div class="woo-product-feed-pro-slider round"></div>
                                    </label>
                                    <div class="peer-has-[:checked]:adt-tw-block adt-tw-hidden adt-tw-mt-2 ">
                                        <div class="notice notice-warning inline">
                                            <p><strong><?php esc_html_e( 'CAUTION:', 'woo-product-feed-pro' ); ?></strong> <?php esc_html_e( 'Enabling this option is for advanced use cases and can cause extreme performance issues. It will generate shipping data for every country you ship to, potentially creating massive feed files. This may lead to server timeouts, high memory usage, and slow feed generation. It only affects shipping zones set to "Everywhere". For most stores, creating separate feeds per country is a safer alternative.', 'woo-product-feed-pro' ); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="file">
                            <td><span><?php esc_html_e( 'File format', 'woo-product-feed-pro' ); ?>:</span></td>
                            <td>
                                <select name="fileformat" id="fileformat" class="select-field">
                                    <?php
                                    $format_arr = array( 'xml', 'csv', 'txt', 'tsv', 'jsonl', 'jsonl.gz', 'csv.gz' );
                                    foreach ( $format_arr as $format ) :
                                        $selected = '';
                                        if ( $edit_feed ) {
                                            $selected = ( $format == $feed->file_format ) ? 'selected' : '';
                                        } else {
                                            $selected = isset( $feed['fileformat'] ) && $format == $feed['fileformat'] ? 'selected' : '';
                                        }
                                    ?>
                                        <option value="<?php echo esc_attr( $format ); ?>" <?php echo $selected; ?>><?php echo esc_html( strtoupper( $format ) ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr id="delimiter">
                            <td><span><?php esc_html_e( 'Delimiter', 'woo-product-feed-pro' ); ?>:</span></td>
                            <td>
                                <select name="delimiter" class="select-field">
                                    <?php
                                    $delimiter_arr = array( ',', '|', ';', 'tab', '#' );
                                    foreach ( $delimiter_arr as $delimiter ) :
                                        $selected = '';
                                        if ( $edit_feed ) {
                                            $selected = ( $delimiter == $feed->delimiter ) ? 'selected' : '';
                                        } else {
                                            $selected = isset( $feed['delimiter'] ) && $delimiter == $feed['delimiter'] ? 'selected' : '';
                                        }
                                    ?>
                                        <option value="<?php echo esc_attr( $delimiter ); ?>" <?php echo $selected; ?>><?php echo esc_html( $delimiter ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr id="refresh_interval">
                            <td><span><?php esc_html_e( 'Refresh interval', 'woo-product-feed-pro' ); ?>:</span></td>
                            <td>
                                <select name="cron" class="select-field">
                                    <?php
                                    /**
                                     * Filters the refresh interval options.
                                     *
                                     * @since 13.4.6
                                     * @param array $refresh_arr The refresh interval options.
                                     * @return array
                                     */
                                    $refresh_arr = apply_filters( 'adt_product_feed_refresh_interval_options', array(  
                                            '',
                                            'daily',
                                            'twicedaily',
                                            'hourly',
                                        )
                                    );
                                    foreach ( $refresh_arr as $refresh_key ) :
                                        $selected = '';
                                        if ( $edit_feed ) {
                                            $selected = ( $refresh_key == $feed->refresh_interval ) ? 'selected' : '';
                                        } else {
                                            $selected = isset( $feed['cron'] ) && $refresh_key == $feed['cron'] ? 'selected' : '';
                                        }
                                    ?>
                                        <option value="<?php echo esc_attr( $refresh_key ); ?>" <?php echo $selected; ?>>
                                            <?php echo esc_html( Product_Feed_Helper::get_refresh_interval_label( $refresh_key ) ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                        /**
                         * Action hook to add content after the refresh interval field.
                         *
                         * @since 13.4.6
                         * @param array|Product_Feed|null $feed Product_Feed object or array of project data.
                         */
                        do_action( 'adt_general_feed_settings_after_refresh_interval', $feed );
                        ?>
                        <tr>
                            <td><span><?php esc_html_e( 'Create a preview of the feed', 'woo-product-feed-pro' ); ?>:</span></td>
                            <td>
                                <?php if ( $edit_feed ) : ?> 
                                    <input name="preview_feed" type="checkbox" class="checkbox-field" <?php echo $feed->create_preview ? 'checked' : ''; ?>>
                                <?php else : ?>
                                    <input name="preview_feed" type="checkbox" class="checkbox-field" <?php echo isset( $feed['preview_feed'] ) && 'on' === $feed['preview_feed'] ? 'checked' : ''; ?>>
                                <?php endif; ?>
                                <a href="<?php echo esc_url( Helper::get_utm_url( 'create-product-feed-preview', 'pfp', 'general-settings', 'create a preview of the feed' ) ); ?>" target="_blank">
                                    Read our tutorial about this feature
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span>
                                    <?php esc_html_e( 'Remove products that did not have sales in the last days', 'woo-product-feed-pro' ); ?>: 
                                    <a href="<?php echo esc_url( Helper::get_utm_url( 'create-feed-performing-products', 'pfp', 'googleanalytics-settings', 'total product orders lookback' ) ); ?>" target="_blank">
                                        <?php esc_html_e( 'What does this do?', 'woo-product-feed-pro' ); ?>
                                    </a>
                                </span>
                            </td>
                            <td>
                                <?php if ( $edit_feed ) : ?> 
                                   <input type="number" class="input-field input-field-small" name="total_product_orders_lookback" min="0" value="<?php echo ( $feed->utm_total_product_orders_lookback && $feed->utm_total_product_orders_lookback > 0 ) ? esc_attr( $feed->utm_total_product_orders_lookback ) : ''; ?>" />
                                <?php else : ?>
                                   <input type="number" class="input-field input-field-small" name="total_product_orders_lookback" min="0" value="<?php echo isset( $feed['total_product_orders_lookback'] ) && '' !== $feed['total_product_orders_lookback'] && $feed['total_product_orders_lookback'] > 0 ? esc_attr( intval( $feed['total_product_orders_lookback'] ) ) : ''; ?>" />
                                <?php endif; ?>
                                <?php esc_html_e( 'days', 'woo-product-feed-pro' ); ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="adt-edit-feed-form-buttons adt-tw-flex adt-tw-gap-2 adt-tw-items-center">
                                    <button class="adt-button adt-button-sm adt-button-primary" type="submit">
                                        <?php if ( $edit_feed ) : ?> 
                                                <?php esc_attr_e( 'Save Changes', 'woo-product-feed-pro' ); ?>
                                        <?php else : ?>
                                            <?php esc_attr_e( 'Save & Continue', 'woo-product-feed-pro' ); ?>
                                        <?php endif; ?>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php //require_once ADT_PFP_VIEWS_ROOT_PATH . 'view-sidebar.php'; ?>
        </div>
    </form>
</div>
