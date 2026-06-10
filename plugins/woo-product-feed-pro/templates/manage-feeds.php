<?php
/**
 * Plugin settings page template.
 *
 * @package AdTribes\PFP
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( 'You are not allowed to call this page directly.' );
}

use AdTribes\PFP\Factories\Product_Feed_Query;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Helpers\Formatting;
use AdTribes\PFP\Classes\Admin_Pages\Manage_Feeds_Page;

// Get pagination parameters from request.
// phpcs:disable WordPress.Security.NonceVerification.Recommended
$items_per_page = isset( $_GET['per_page'] ) ? intval( $_GET['per_page'] ) : 10;
$items_per_page = max( 1, $items_per_page ); // Ensure items_per_page is at least 1 to prevent division by zero.
$current_page   = isset( $_GET['page_num'] ) ? intval( $_GET['page_num'] ) : 1;
$offset         = ( $current_page - 1 ) * $items_per_page;
$subpage        = filter_input( INPUT_GET, 'subpage', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
// phpcs:enable WordPress.Security.NonceVerification.Recommended

// Get the total count of feeds using the simplified helper function with caching.
$total_items = Product_Feed_Helper::get_total_feeds_count();
$total_pages = ceil( $total_items / $items_per_page );

// Now get the paginated results.
$feeds_query = new Product_Feed_Query(
    apply_filters(
        'adt_manage_product_feed_query_args',
        array(
            'post_status'    => array( 'draft', 'publish' ),
            'posts_per_page' => $items_per_page,
            'offset'         => $offset,
            'orderby'        => 'date',
            'order'          => 'DESC',
        )
    ),
    'edit'
);
?>
<div class="wrap adt-tw-wrapper">
    <div class="adt-container lg:adt-tw-px-8 sm:adt-tw-py-4 adt-tw-py-0">
        <?php
            Helper::locate_admin_template( 'header.php', true );
        ?>
        <h1 class="adt-tw-text-2xl adt-tw-font-semibold adt-tw-text-gray-800 adt-tw-mb-6">
            <?php esc_html_e( 'Manage Feeds', 'woo-product-feed-pro' ); ?>
        </h1>
        <?php if ( $feeds_query->have_posts() ) : ?>
            <div class="adt-tw-flex adt-tw-flex-col sm:adt-tw-flex-row adt-tw-justify-between adt-tw-gap-4 adt-tw-mb-6">
                <select 
                    class="adt-manage-feeds-bulk-actions-select"
                    disabled
                >
                    <option value=""><?php esc_html_e( 'Bulk Actions', 'woo-product-feed-pro' ); ?></option>
                    <option value="activate"><?php esc_html_e( 'Activate', 'woo-product-feed-pro' ); ?></option>
                    <option value="deactivate"><?php esc_html_e( 'Deactivate', 'woo-product-feed-pro' ); ?></option>
                    <option value="refresh"><?php esc_html_e( 'Refresh', 'woo-product-feed-pro' ); ?></option>
                    <option value="cancel"><?php esc_html_e( 'Cancel', 'woo-product-feed-pro' ); ?></option>
                    <option value="duplicate"><?php esc_html_e( 'Duplicate', 'woo-product-feed-pro' ); ?></option>
                    <option value="delete"><?php esc_html_e( 'Delete', 'woo-product-feed-pro' ); ?></option>
                </select>
                <a href="admin.php?page=adt-edit-feed" class="adt-button adt-button-primary adt-tw-flex adt-tw-items-center adt-tw-justify-center adt-tw-gap-2">
                    <span class="adt-tw-icon-[fluent--add-square-16-regular] adt-tw-w-5 adt-tw-h-5"></span>
                    <?php esc_html_e( 'Add New Feed', 'woo-product-feed-pro' ); ?>
                </a>
            </div>
            <div class="adt-manage-feeds-table">
                <!-- Header Row -->
                <div class="adt-manage-feeds-table-header adt-manage-feeds-table-row"">
                    <div class="adt-manage-feeds-table-header-item adt-manage-feeds-table-header-checkbox">
                        <div>
                            <input type="checkbox" class="" />
                        </div>
                    </div>
                    <div class="adt-manage-feeds-table-header-item"><div><?php esc_html_e( 'Feed Name', 'woo-product-feed-pro' ); ?></div></div>
                    <div class="adt-manage-feeds-table-header-item"><div><?php esc_html_e( 'Format', 'woo-product-feed-pro' ); ?></div></div>
                    <div class="adt-manage-feeds-table-header-item"><div><?php esc_html_e( 'Status', 'woo-product-feed-pro' ); ?></div></div>
                    <div class="adt-manage-feeds-table-header-item"><div><?php esc_html_e( 'Last Updated', 'woo-product-feed-pro' ); ?></div></div>
                    <div class="adt-manage-feeds-table-header-item"><div><?php esc_html_e( 'Refresh Interval', 'woo-product-feed-pro' ); ?></div></div>
                    <div class="adt-manage-feeds-table-header-item"><div><?php esc_html_e( 'Feed URL', 'woo-product-feed-pro' ); ?></div></div>
                    <div class="adt-manage-feeds-table-header-item"><div><?php esc_html_e( 'Actions', 'woo-product-feed-pro' ); ?></div></div>
                </div>
                
                <!-- Data Row -->
                <?php foreach ( $feeds_query->get_posts() as $feed ) : ?>
                    <div class="adt-manage-feeds-table-row" data-feed-id="<?php echo esc_attr( $feed->id ); ?>" data-post-status="<?php echo esc_attr( $feed->post_status ); ?>">
                        <div class="adt-manage-feeds-table-row-item adt-manage-feeds-table-row-checkbox">
                            <div>
                                <input type="checkbox" class="adt-tw-rounded adt-tw-border-gray-300" />
                            </div>
                        </div>
                        <div class="adt-manage-feeds-table-row-item adt-manage-feeds-table-row-name" data-label="Feed Name">
                            <div>
                                <a href="<?php echo esc_url( Manage_Feeds_Page::get_product_feed_setting_url( $feed->id ) ); ?>" class="adt-manage-feeds-table-row-name-link">
                                    <?php echo esc_html( $feed->title ); ?>
                                </a>
                                <span class="adt-tooltip">
                                    <span class="adt-tw-icon-[lucide--circle-help] adt-tw-w-4 adt-tw-h-4 adt-tw-text-gray-400"></span>
                                    <div class="adt-tooltip-content">
                                        <?php esc_html_e( 'Feed Type:', 'woo-product-feed-pro' ); ?> <?php echo esc_html( $feed->get_channel( 'name' ) ); ?>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="adt-manage-feeds-table-row-item adt-manage-feeds-table-row-format adt-manage-feeds-table-row-labeled" data-label="<?php esc_html_e( 'Format', 'woo-product-feed-pro' ); ?>">
                            <div class="adt-tw-uppercase">
                                <?php echo esc_html( $feed->file_format ); ?>
                            </div>
                        </div>
                        <div class="adt-manage-feeds-table-row-item adt-manage-feeds-table-row-status adt-manage-feeds-table-row-labeled" data-label="<?php esc_html_e( 'Status', 'woo-product-feed-pro' ); ?>">
                            <div>
                                <div class="adt-manage-feeds-table-row-status-dot" data-status="<?php echo esc_html( strtolower( Formatting::get_feed_status_label( $feed ) ) ); ?>"></div>
                                <span class="adt-manage-feeds-table-row-status-text adt-manage-feeds-status-toggle adt-tooltip" data-current-status="<?php echo esc_attr( strtolower( Formatting::get_feed_status_label( $feed ) ) ); ?>">
                                    <?php echo esc_html( Formatting::get_feed_status_label( $feed ) ); ?>
                                    <div class="adt-tooltip-content adt-tw-text-xs adt-tw-text-gray adt-tw-normal-case">
                                        <?php if ( 'publish' === $feed->post_status ) : ?>
                                            <?php esc_html_e( 'Click to deactivate the feed.', 'woo-product-feed-pro' ); ?>
                                        <?php else : ?>
                                            <?php esc_html_e( 'Click to activate the feed.', 'woo-product-feed-pro' ); ?>
                                        <?php endif; ?>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="adt-manage-feeds-table-row-item adt-manage-feeds-table-row-last-updated adt-manage-feeds-table-row-labeled" data-label="<?php esc_html_e( 'Last Updated', 'woo-product-feed-pro' ); ?>">
                            <div>
                                <?php echo esc_html( Formatting::format_date( $feed->last_updated ) ); ?>
                            </div>
                        </div>
                        <div class="adt-manage-feeds-table-row-item adt-manage-feeds-table-row-refresh-interval adt-manage-feeds-table-row-labeled" data-label="<?php esc_html_e( 'Refresh Interval', 'woo-product-feed-pro' ); ?>">
                            <div>
                                <?php echo wp_kses_post( Formatting::format_refresh_interval( $feed->refresh_interval, $feed ) ); ?>
                            </div>
                        </div>
                        <div class="adt-manage-feeds-table-row-item adt-manage-feeds-table-row-url adt-manage-feeds-table-row-labeled" data-label="<?php esc_html_e( 'Feed URL', 'woo-product-feed-pro' ); ?>">
                            <div>
                                <?php echo Product_Feed_Helper::get_feed_url_html( $feed ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                        </div>
                        <div class="adt-manage-feeds-table-row-item adt-manage-feeds-table-row-actions" data-label="<?php esc_html_e( 'Actions', 'woo-product-feed-pro' ); ?>">
                            <div>
                                <?php do_action( 'adt_manage_feeds_table_row_actions', $feed ); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ( $total_pages > 0 ) : ?>
            <!-- Pagination -->
            <div class="adt-manage-feeds-pagination">
                <div class="adt-manage-feeds-pagination-show">
                    <span><?php esc_html_e( 'Show', 'woo-product-feed-pro' ); ?></span>
                    <select
                        class="adt-manage-feeds-pagination-show-select"
                        data-current-page-size="<?php echo esc_attr( $items_per_page ); ?>"
                    >
                        <option value="10" <?php selected( $items_per_page, 10 ); ?>><?php esc_html_e( '10', 'woo-product-feed-pro' ); ?></option>
                        <option value="25" <?php selected( $items_per_page, 25 ); ?>><?php esc_html_e( '25', 'woo-product-feed-pro' ); ?></option>
                        <option value="50" <?php selected( $items_per_page, 50 ); ?>><?php esc_html_e( '50', 'woo-product-feed-pro' ); ?></option>
                        <option value="100" <?php selected( $items_per_page, 100 ); ?>><?php esc_html_e( '100', 'woo-product-feed-pro' ); ?></option>
                    </select>
                    <span><?php esc_html_e( 'feeds per page', 'woo-product-feed-pro' ); ?></span>
                </div>
            
                <div class="adt-manage-feeds-pagination-buttons">
                    <ul>
                        <?php
                        // First page button.
                        $first_page_url      = Helper::get_feed_pagination_url( 1, $items_per_page );
                        $first_page_disabled = ( $current_page <= 1 ) ? 'adt-manage-feeds-pagination-buttons-item--disabled' : '';
                        ?>
                        <li>
                            <a
                                href="<?php echo $current_page > 1 ? esc_url( $first_page_url ) : '#'; ?>"
                                class="adt-manage-feeds-pagination-buttons-item <?php echo esc_attr( $first_page_disabled ); ?>"
                                title="<?php esc_attr_e( 'First page', 'woo-product-feed-pro' ); ?>"
                            >
                                <span class="adt-tw-icon-[lucide--chevrons-left] adt-manage-feeds-pagination-buttons-item-icon"></span>
                            </a>
                        </li>
                        
                        <?php
                        // Previous page button.
                        $prev_page          = max( 1, $current_page - 1 );
                        $prev_page_url      = Helper::get_feed_pagination_url( $prev_page, $items_per_page );
                        $prev_page_disabled = ( $current_page <= 1 ) ? 'adt-manage-feeds-pagination-buttons-item--disabled' : '';
                        ?>
                        <li>
                            <a
                                href="<?php echo $current_page > 1 ? esc_url( $prev_page_url ) : '#'; ?>"
                                class="adt-manage-feeds-pagination-buttons-item <?php echo esc_attr( $prev_page_disabled ); ?>"
                                title="<?php esc_attr_e( 'Previous page', 'woo-product-feed-pro' ); ?>"
                            >
                                <span class="adt-tw-icon-[lucide--chevron-left] adt-manage-feeds-pagination-buttons-item-icon"></span>
                            </a>
                        </li>
                        
                        <?php
                        // Calculate which page numbers to show.
                        $max_visible_pages = 5;
                        $start_page        = max( 1, min( $total_pages - $max_visible_pages + 1, $current_page - floor( $max_visible_pages / 2 ) ) );
                        $end_page          = min( $total_pages, $start_page + $max_visible_pages - 1 );

                        // Adjust start page if we're at the end.
                        if ( $end_page - $start_page + 1 < $max_visible_pages ) {
                            $start_page = max( 1, $end_page - $max_visible_pages + 1 );
                        }

                        // Always show first page with ellipsis if not included in the range.
                        if ( $start_page > 1 ) {
                            $page_url     = Helper::get_feed_pagination_url( 1, $items_per_page );
                            $active_class = ( 1 === $current_page ) ? 'adt-manage-feeds-pagination-buttons-item--active' : '';
                            ?>
                            <li>
                                <a
                                    href="<?php echo esc_url( $page_url ); ?>"
                                    class="adt-manage-feeds-pagination-buttons-item adt-manage-feeds-pagination-buttons-item-number <?php echo esc_attr( $active_class ); ?>"
                                >
                                    <span>1</span>
                                </a>
                            </li>
                            <?php

                            // Add ellipsis if there's a gap.
                            if ( $start_page > 2 ) {
                                ?>
                                <li>
                                    <span class="adt-tw-px-1 adt-tw-text-gray-400">...</span>
                                </li>
                                <?php
                            }
                        }

                        // Page number buttons.
                        for ( $i = $start_page; $i <= $end_page; $i++ ) {
                            $page_url     = Helper::get_feed_pagination_url( $i, $items_per_page );
                            $active_class = ( $current_page === $i ) ? 'adt-manage-feeds-pagination-buttons-item--active' : '';
                            ?>
                            <li>
                                <a
                                    href="<?php echo esc_url( $page_url ); ?>"
                                    class="adt-manage-feeds-pagination-buttons-item adt-manage-feeds-pagination-buttons-item-number <?php echo esc_attr( $active_class ); ?>"
                                >
                                    <span><?php echo esc_html( $i ); ?></span>
                                </a>
                            </li>
                            <?php
                        }

                        // Always show ellipsis and last page if not already included.
                        if ( $end_page < $total_pages ) {
                            // Add ellipsis if there's a gap.
                            if ( $end_page < $total_pages - 1 ) {
                                ?>
                                <li>
                                    <span class="adt-tw-px-1 adt-tw-text-gray-400">...</span>
                                </li>
                                <?php
                            }

                            $page_url     = Helper::get_feed_pagination_url( $total_pages, $items_per_page );
                            $active_class = ( $total_pages === $current_page ) ? 'adt-manage-feeds-pagination-buttons-item--active' : '';
                            ?>
                            <li>
                                <a
                                    href="<?php echo esc_url( $page_url ); ?>"
                                    class="adt-manage-feeds-pagination-buttons-item adt-manage-feeds-pagination-buttons-item-number <?php echo esc_attr( $active_class ); ?>"
                                >
                                    <span><?php echo esc_html( $total_pages ); ?></span>
                                </a>
                            </li>
                            <?php
                        }

                        // Next page button.
                        $next_page          = min( $total_pages, $current_page + 1 );
                        $next_page_url      = Helper::get_feed_pagination_url( $next_page, $items_per_page );
                        $next_page_disabled = ( $current_page >= $total_pages ) ? 'adt-manage-feeds-pagination-buttons-item--disabled' : '';
                        ?>
                        <li>
                            <a
                                href="<?php echo $current_page < $total_pages ? esc_url( $next_page_url ) : '#'; ?>"
                                class="adt-manage-feeds-pagination-buttons-item <?php echo esc_attr( $next_page_disabled ); ?>"
                                title="<?php esc_attr_e( 'Next page', 'woo-product-feed-pro' ); ?>"
                            >
                                <span class="adt-tw-icon-[lucide--chevron-right] adt-manage-feeds-pagination-buttons-item-icon"></span>
                            </a>
                        </li>
                        
                        <?php
                        // Last page button.
                        $last_page_url      = Helper::get_feed_pagination_url( $total_pages, $items_per_page );
                        $last_page_disabled = ( $current_page >= $total_pages ) ? 'adt-manage-feeds-pagination-buttons-item--disabled' : '';
                        ?>
                        <li>
                            <a
                                href="<?php echo $current_page < $total_pages ? esc_url( $last_page_url ) : '#'; ?>"
                                class="adt-manage-feeds-pagination-buttons-item <?php echo esc_attr( $last_page_disabled ); ?>"
                                title="<?php esc_attr_e( 'Last page', 'woo-product-feed-pro' ); ?>"
                            >
                                <span class="adt-tw-icon-[lucide--chevrons-right] adt-manage-feeds-pagination-buttons-item-icon"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="adt-manage-feeds-no-results">
                <div class="adt-tw-flex adt-tw-flex-col adt-tw-items-center adt-tw-justify-center">
                    <img src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'empty-feeds.png' ); ?>" alt="<?php esc_attr_e( 'No feeds', 'woo-product-feed-pro' ); ?>" />
                    <p class="adt-tw-text-center adt-tw-text-gray-500 adt-tw-text-base adt-tw-font-semibold adt-tw-italic">
                        <?php
                        esc_html_e(
                            'Whoops! It looks like you don\'t have any feeds yet.',
                            'woo-product-feed-pro'
                        );
                        ?>
                    </p>
                </div>
                <div class="adt-tw-bg-white adt-tw-shadow-md adt-tw-rounded-lg adt-tw-px-6 adt-tw-py-8 adt-tw-mb-6 adt-tw-max-w-lg adt-tw-mx-auto">
                    <div class="adt-tw-flex adt-tw-flex-col">
                        <h2 class="adt-tw-flex adt-tw-items-center adt-tw-justify-center adt-tw-gap-2 adt-tw-text-2xl adt-tw-text-center adt-tw-font-semibold adt-tw-text-gray-800 adt-tw-mb-2 adt-tw-mt-0">
                            <img src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'icon-fluent-emoji-magic-wand.png' ); ?>" alt="Product Feed Pro Logo" class="adt-tw-w-auto adt-tw-h-auto" />
                            <?php esc_html_e( "Let's Get Started!", 'woo-product-feed-pro' ); ?>
                        </h2>
                        <p class="adt-tw-text-gray-600 adt-tw-text-base adt-tw-font-normal adt-tw-mb-2">
                            <?php echo wp_kses_post( __( 'Click the <strong>Add New Feed</strong> button to begin creating your feed.', 'woo-product-feed-pro' ) ); ?>
                        </p>
                        <p class="adt-tw-text-gray-600 adt-tw-text-base adt-tw-font-normal adt-tw-mb-1 adt-tw-mt-1">
                            <?php
                                echo wp_kses_post(
                                    sprintf(
                                        // translators: %1$s: Opening anchor tag, %2$s: Closing anchor tag.
                                        __(
                                            '<strong>Need help?</strong> Check out our %1$sGetting Started%2$s guide for step-by-step instructions and tips!',
                                            'woo-product-feed-pro'
                                        ),
                                        '<a class="adt-tw-text-primary adt-tw-underline adt-tw-font-semibold" href="' . esc_url( Helper::get_utm_url( 'setting-up-your-first-google-shopping-product-feed', 'pfp', 'manage-feed', 'first shopping feed' ) ) . '" target="_blank">',
                                        '</a>'
                                    )
                                );
                            ?>
                        </p>
                    </div>
                </div>
                <div class="adt-tw-flex adt-tw-flex-col adt-tw-items-center adt-tw-justify-center">
                    <a href="admin.php?page=adt-edit-feed" class="adt-button adt-button-outline adt-button-outline-primary adt-tw-font-semibold adt-tw-flex adt-tw-items-center adt-tw-justify-center adt-tw-gap-2">
                        <span class="adt-tw-icon-[fluent--add-square-16-regular] adt-tw-w-5 adt-tw-h-5"></span>
                        <?php esc_html_e( 'Add New Feed', 'woo-product-feed-pro' ); ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Icon Preloader - Hidden elements to ensure icon fonts are loaded -->
<div class="adt-icon-preloader" style="height: 0; width: 0; position: absolute; visibility: hidden; overflow: hidden;">
    <span class="adt-tw-icon-[lucide--copy]"></span>
    <span class="adt-tw-icon-[lucide--pencil]"></span>
    <span class="adt-tw-icon-[lucide--files]"></span>
    <span class="adt-tw-icon-[lucide--trash-2]"></span>
    <span class="adt-tw-icon-[lucide--chart-area]"></span>
    <span class="adt-tw-icon-[lucide--refresh-cw]"></span>
    <span class="adt-tw-icon-[lucide--x]"></span>
    <span class="adt-tw-icon-[lucide--calendar-clock]"></span>
    <span class="adt-tw-icon-[lucide--download]"></span>
    <span class="adt-tw-icon-[lucide--loader-circle]"></span>
</div>
