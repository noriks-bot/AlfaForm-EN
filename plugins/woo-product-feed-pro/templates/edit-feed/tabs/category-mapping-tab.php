<?php
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Factories\Admin_Notice;
use AdTribes\PFP\Classes\Google_Product_Taxonomy_Fetcher;
use AdTribes\PFP\Helpers\Product_Feed_Helper;

delete_option( 'woosea_cat_mapping' );

$google_product_taxonomy_fetcher = Google_Product_Taxonomy_Fetcher::instance();
$is_fetching                     = $google_product_taxonomy_fetcher->is_fetching();
$is_file_exists                  = $google_product_taxonomy_fetcher->is_file_exists();

$feed    = null;
$feed_id = isset( $_GET['id'] ) ? sanitize_text_field( wp_unslash( $_GET['id'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

$edit_feed = false;
if ( $feed_id ) {
    $feed = Product_Feed_Helper::get_product_feed( sanitize_text_field( $feed_id ) );
    if ( $feed->id ) {
        $feed_mappings = $feed->mappings;
        $channel_data  = $feed->channel;

        $channel_hash = $feed->channel_hash;
        $project_hash = $feed->legacy_project_hash;

        $edit_feed = true;
    }
} else {
    $feed         = get_option( ADT_OPTION_TEMP_PRODUCT_FEED, array() );
    $channel_hash = $feed['channel_hash'] ?? '';
    $project_hash = $feed['project_hash'] ?? '';
    $channel_data = '' !== $channel_hash ? Product_Feed_Helper::get_channel_from_legacy_channel_hash( $channel_hash ) : array();

    $feed_mappings = array();

    if ( ! empty( $feed['mappings'] ) && is_array( $feed['mappings'] ) ) {
        $feed_mappings = $feed['mappings'];
    }
}

/**
 * Action hook to add content before the product feed manage page.
 *
 * @param int                      $step         Step number.
 * @param string                   $project_hash Project hash.
 * @param array|Product_Feed|null  $feed         Product_Feed object or array of project data.
 */
do_action( 'adt_before_product_feed_manage_page', 1, $project_hash, $feed );
?>
<div class="woo-product-feed-pro-form-style-2">

    <?php
    // Display info message notice.
    $admin_notice = new Admin_Notice(
        sprintf(
            esc_html__( 'Map your products or categories to the categories of your selected channel. For some channels adding their categorisation in the product feed is mandatory. Even when category mappings are not mandatory it is likely your products will get better visibility and higher conversions when mappings have been added.', 'woo-product-feed-pro' )
        ),
        'info',
        false,
        false
    );
    $admin_notice->run();

    // Display info google product taxonomy fetching message.
    if ( $is_fetching ) {
        // Display fetching message.
        $admin_notice = new Admin_Notice(
            sprintf(
                esc_html__(
                    'Fetching Google Product Taxonomy: Please wait until the process is finished. Refresh this page to check the status.',
                    'woo-product-feed-pro'
                )
            )
        );
        $admin_notice->run();
    } elseif ( ! $is_file_exists ) {
        // Display fetching message.
        $admin_notice = new Admin_Notice(
            sprintf(
                esc_html__(
                    'Google Product Taxonomy is failed to fetch. Reattempt to fetch Google Product Taxonomy by deactivating and reactivating the plugin.',
                    'woo-product-feed-pro'
                )
            )
        );
        $admin_notice->run();
    }
    ?>

    <div class="woo-product-feed-pro-table-wrapper">
        <div class="woo-product-feed-pro-table-left">
            <form class="adt-edit-feed-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="category_mapping">
                <?php wp_nonce_field( 'woosea_ajax_nonce' ); ?>
                <input type="hidden" name="action" value="edit_feed_form_process" />
                <input type="hidden" name="active_tab" value="category_mapping" />
                <input type="hidden" name="feed_id" value="<?php echo esc_attr( $feed->id ?? '' ); ?>" />
                <table id="woosea-ajax-mapping-table" class="woo-product-feed-pro-table" border="1">
                    <thead>
                        <tr>
                            <th><?php esc_html_e( 'Your category', 'woo-product-feed-pro' ); ?> <i>(<?php esc_html_e( 'Number of products', 'woo-product-feed-pro' ); ?>)</i></th>
                            <th><?php echo esc_html( $channel_data['name'] ?? '' ); ?> <?php esc_html_e( 'category', 'woo-product-feed-pro' ); ?></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="woo-product-feed-pro-body">
                        
                        <!-- Display mapping form. -->
                        <?php echo Product_Feed_Helper::get_hierarchical_categories_mapping( $feed ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <tr>
                            <td colspan="3">
                                <div class="adt-edit-feed-form-buttons adt-tw-flex adt-tw-gap-2 adt-tw-items-center">
                                    <input type="hidden" id="channel_hash" name="channel_hash" value="<?php echo esc_attr( $channel_hash ); ?>">
                                    <?php if ( $edit_feed ) : ?> 
                                        <input type="hidden" name="project_update" id="project_update" value="yes" />
                                        <input type="hidden" id="project_hash" name="project_hash" value="<?php echo esc_attr( $project_hash ); ?>">
                                        <button type="submit" class="adt-button adt-button-sm adt-button-primary" id="savebutton">
                                            <?php esc_attr_e( 'Save Mappings', 'woo-product-feed-pro' ); ?>
                                        </button>
                                    <?php else : ?>
                                        <input type="hidden" id="project_hash" name="project_hash" value="<?php echo esc_attr( $project_hash ); ?>">
                                        <button type="submit" class="adt-button adt-button-sm adt-button-primary adt-tw-gap-2" id="savebutton">
                                            <?php esc_attr_e( 'Save & Continue', 'woo-product-feed-pro' ); ?>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <?php // require_once ADT_PFP_VIEWS_ROOT_PATH . 'view-sidebar.php';. ?>
    </div>
</div>
