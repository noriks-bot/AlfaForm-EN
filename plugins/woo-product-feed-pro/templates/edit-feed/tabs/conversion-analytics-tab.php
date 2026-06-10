<?php
// phpcs:disable
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Factories\Admin_Notice;
use AdTribes\PFP\Helpers\Product_Feed_Helper;

/**
 * Update or get project configuration
 */
$nonce = wp_create_nonce( 'woosea_ajax_nonce' );

$feed      = null;
$feed_id   = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
$edit_feed = false;
if ( $feed_id ) {
    $feed = Product_Feed_Helper::get_product_feed( sanitize_text_field( $feed_id ) );
    if ( $feed ) {
        $channel_data   = $feed->get_channel();
        $manage_project = 'yes';

        $channel_hash = $feed->channel_hash;
        $project_hash = $feed->legacy_project_hash;

        $utm_source                    = $feed->utm_source;
        $utm_campaign                  = $feed->utm_campaign;
        $utm_enabled                   = $feed->utm_enabled;
        $utm_medium                    = $feed->utm_medium;
        $utm_content                   = $feed->utm_content;
        $total_product_orders_lookback = $feed->utm_total_product_orders_lookback;

        $edit_feed = true;
    }
} else {
    $feed         = get_option( ADT_OPTION_TEMP_PRODUCT_FEED, array() );
    $channel_hash = $feed['channel_hash'] ?? '';
    $project_hash = $feed['project_hash'] ?? '';
    $channel_data = '' !== $channel_hash ? Product_Feed_Helper::get_channel_from_legacy_channel_hash( $channel_hash ) : array();

    $utm_source                    = $channel_data['name'] ?? '';
    $utm_medium                    = 'cpc';
    $utm_campaign                  = $feed['projectname'] ?? '';
    $utm_enabled                   = true;
    $utm_content                   = '';
    $total_product_orders_lookback = '';
}

/**
 * Action hook to add content before the product feed manage page.
 *
 * @param int                      $step         Step number.
 * @param string                   $project_hash Project hash.
 * @param array|Product_Feed|null  $feed         Product_Feed object or array of project data.
 */
do_action( 'adt_before_product_feed_manage_page', 5, $project_hash, $feed );
?>
<div class="woo-product-feed-pro-form-style-2">
    <tbody class="woo-product-feed-pro-body">
        <?php
        // Display info message notice.
        $admin_notice = new Admin_Notice(
            '<p>' . __('<strong>Google Analytics UTM codes:</strong><br/>Adding Google Analytics UTM codes is not mandatory, it will however enable you to get detailed insights into how your products are performing in Google Analytics reporting and allow you to tweak and tune your campaign making it more profitable. We strongly advise you to add the Google Analytics tracking. When enabled the plugin will append the Google Analytics UTM parameters to your landingpage URL\'s.', 'woo-product-feed-pro') . '</p>',
            'info',
            false,
            true
        );
        $admin_notice->run();
        ?>

        <form class="adt-edit-feed-form" id="googleanalytics" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
            <?php wp_nonce_field( 'woosea_ajax_nonce' ); ?>
            <input type="hidden" id="feed_id" name="feed_id" value="<?php echo esc_attr( $feed->id ?? 0 ); ?>">
            <input type="hidden" name="action" value="edit_feed_form_process" />
            <input type="hidden" name="active_tab" value="conversion_analytics" />
            
            <table class="woo-product-feed-pro-table">
                <tr>
                    <td style="width: 350px;"><span><?php esc_html_e( 'Enable Google Analytics tracking', 'woo-product-feed-pro' ); ?>: </span></td>
                    <td>
                        <label class="woo-product-feed-pro-switch">
                            <input type="checkbox" name="utm_on" class="checkbox-field" <?php echo $utm_enabled ? 'checked' : ''; ?>>
                            <div class="woo-product-feed-pro-slider round"></div>
                        </label>    
                    </td>
                </tr>           
                <tr>
                    <td><span><?php esc_html_e( 'Google Analytics campaign source (utm_source)', 'woo-product-feed-pro' ); ?>:</span></td>
                    <td><input type="text" class="input-field" name="utm_source" value="<?php echo esc_attr( $utm_source ); ?>" /></td>
                </tr>
                <tr>
                    <td><span><?php esc_html_e( 'Google Analytics campaign medium (utm_medium)', 'woo-product-feed-pro' ); ?>:</span></td>
                    <td><input type="text" class="input-field" name="utm_medium" value="<?php echo esc_attr( $utm_medium ); ?>" /></td>
                </tr>
                <tr>
                    <td><span><?php esc_html_e( 'Google Analytics campaign name (utm_campaign)', 'woo-product-feed-pro' ); ?>:</span></td>
                    <td><input type="text" class="input-field" name="utm_campaign" value="<?php echo esc_attr( $utm_campaign ); ?>" /></td>
                </tr>
                <tr>
                    <td><span><?php esc_html_e( 'Google Analytics campaign content (utm_content)', 'woo-product-feed-pro' ); ?>:</span></td>
                    <td><input type="text" class="input-field" name="utm_content" value="<?php echo esc_attr( $utm_content ); ?>" /></td>
                </tr>
                

                <tr>
                    <td colspan="2">
                        <div class="adt-edit-feed-form-buttons adt-tw-flex adt-tw-gap-2 adt-tw-items-center">
                        <?php if ( $edit_feed ) : ?>
                                <input type="hidden" name="channel_hash" value="<?php echo esc_attr( $channel_hash ); ?>">
                                <input type="hidden" name="project_update" id="project_update" value="yes">
                                <input type="hidden" name="project_hash" value="<?php echo esc_attr( $project_hash ); ?>">
                                <input type="hidden" name="woosea_page" value="analytics">
                                <button type="submit" class="adt-button adt-button-sm adt-button-primary adt-tw-gap-2" id="savebutton">
                                    <?php esc_attr_e( 'Save Changes', 'woo-product-feed-pro' ); ?>
                                </button>
                            <?php else : ?>
                                <input type="hidden" name="channel_hash" value="<?php echo esc_attr( $channel_hash ); ?>">
                                <input type="hidden" name="project_hash" value="<?php echo esc_attr( $project_hash ); ?>">
                                <input type="hidden" name="woosea_page" value="analytics">
                                <button type="submit" class="adt-button adt-button-sm adt-button-primary adt-tw-gap-2" id="savebutton">
                                    <?php esc_attr_e( 'Generate Product Feed', 'woo-product-feed-pro' ); ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </tbody>
</div>
