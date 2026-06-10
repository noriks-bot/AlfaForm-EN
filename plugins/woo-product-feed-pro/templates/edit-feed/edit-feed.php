<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Classes\Admin_Pages\Edit_Feed_Page;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Helpers\Helper;

$edit_feed_page = Edit_Feed_Page::instance();

$feed    = null;
$feed_id = isset( $_GET['id'] ) ? sanitize_text_field( wp_unslash( $_GET['id'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
if ( array_key_exists( 'id', $_GET ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $feed = Product_Feed_Helper::get_product_feed( sanitize_text_field( $feed_id ) );
} else {
    $feed = get_option( ADT_OPTION_TEMP_PRODUCT_FEED, array() );
}

// Get the active tab, default to general.
$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'general'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>
<div id="adt-edit-feed" class="adt-page wrap adt-tw-wrapper nosubsub" data-feed-id="<?php echo esc_attr( $feed_id ); ?>" data-active-tab="<?php echo esc_attr( $active_tab ); ?>" data-status="<?php echo Product_Feed_Helper::is_a_product_feed( $feed ) ? esc_attr( $feed->status ) : ''; ?>">
    <div class="adt-container lg:adt-tw-px-8 sm:adt-tw-py-4 adt-tw-py-0">
        <?php
            Helper::locate_admin_template( 'header.php', true );
        ?>
        <h1 class="adt-tw-text-2xl adt-tw-font-semibold adt-tw-text-gray-800 adt-tw-mb-2">
            <?php if ( ! empty( $feed_id ) && $feed ) : ?>
                <?php esc_html_e( 'Edit Feed', 'woo-product-feed-pro' ); ?>:
                <?php echo esc_html( $feed->title ?? '' ); ?>
            <?php else : ?>
                <?php esc_html_e( 'Create New Feed', 'woo-product-feed-pro' ); ?>
            <?php endif; ?>
        </h1>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=woo-product-feed' ) ); ?>" class="adt-tw-inline-block adt-tw-text-sm adt-tw-mb-6">
            &larr; <?php esc_html_e( 'All Feeds', 'woo-product-feed-pro' ); ?>
        </a>
        <!-- WordPress provides the styling for tabs. -->
        <h2 class="nav-tab-wrapper woo-product-feed-pro-nav-tab-wrapper">
            <?php foreach ( $edit_feed_page->get_tabs( $feed ) as $setting_tabs => $label ) : ?>
                <a href="<?php echo esc_url( Edit_Feed_Page::get_tab_url( $setting_tabs ) ); ?>" class="nav-tab <?php echo $setting_tabs === $active_tab ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html( $label ); ?>
                </a>
            <?php endforeach; ?>
        </h2>
        <div class="tab-content adt-tw-mt-6">
            <?php if ( false === $feed ) : ?>
                <div class="notice notice-error">
                    <p><?php esc_html_e( 'Feed not found.', 'woo-product-feed-pro' ); ?></p>
                </div>
            <?php else : ?>
                <?php
                    // Define tab headings.
                    $edit_feed_tabs = $edit_feed_page->get_tabs( $feed );

                    // Check if tab exists and is valid.
                    if ( ! array_key_exists( $active_tab, $edit_feed_tabs ) ) {
                        $active_tab = 'general'; // Default to general if tab is invalid.
                    }

                    // CSS class for the tab content. Convert underscores to hyphens for CSS classes.
                    $tab_class = str_replace( '_', '-', $active_tab );
                    ?>
                    <div class="<?php echo esc_attr( $tab_class ); ?>-tab-content">
                        <?php echo $edit_feed_page->get_tab_content( $active_tab ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
            <?php endif; ?>
        </div>
    </div>
</div>
