<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Classes\Admin_Pages\Settings_Page;
use AdTribes\PFP\Helpers\Helper;

$settings_page = Settings_Page::instance();
?>
<table class="adt-tw-table adt-tw-table-auto adt-tw-border-collapse adt-tw-w-full">
    <tr>
        <td colspan="2" class="adt-tw-border-0 adt-tw-border-b adt-tw-border-t adt-tw-border-gray-200 adt-tw-border-solid adt-tw-align-top adt-tw-py-2">
            <h3 class="adt-tw-font-semibold adt-tw-mb-1"><?php esc_html_e( 'Export Feeds', 'woo-product-feed-pro' ); ?></h3>
            <p class="adt-tw-m-0 adt-tw-p-0 adt-tw-mb-2">
                <?php esc_html_e( 'Export Feeds to a file.', 'woo-product-feed-pro' ); ?>
            </p>
        </td>
    </tr>
    <tr>
        <td class="adt-tw-w-[260px] adt-tw-border-0 adt-tw-border-b adt-tw-border-gray-200 adt-tw-border-solid adt-tw-align-top adt-tw-py-4">
            <p class="adt-tw-text-base adt-tw-m-0 adt-tw-p-0"><?php esc_html_e( 'Export all feeds to a file', 'woo-product-feed-pro' ); ?></p>
        </td>
        <td class="adt-tw-border-0 adt-tw-border-b adt-tw-border-gray-200 adt-tw-border-solid adt-tw-align-top adt-tw-py-4 adt-tw-flex adt-tw-items-center adt-tw-gap-2">
            <button type="button" class="adt-export-import-button adt-button adt-button-sm adt-button-primary adt-tw-gap-2" data-action="export_all_feeds">
                <span class="adt-tw-icon-[lucide--download]"></span>
                <?php esc_html_e( 'Export Feeds', 'woo-product-feed-pro' ); ?>
            </button>
            <span class="adt-loader adt-loader-sm"></span>
        </td>
    </tr>
    <tr>
        <td class="adt-tw-w-[260px] adt-tw-border-0 adt-tw-border-b adt-tw-border-gray-200 adt-tw-border-solid adt-tw-align-top adt-tw-py-4">
            <p class="adt-tw-text-base adt-tw-m-0 adt-tw-p-0"><?php esc_html_e( 'Export Selected Feeds', 'woo-product-feed-pro' ); ?></p>
        </td>
        <td class="adt-tw-border-0 adt-tw-border-b adt-tw-border-gray-200 adt-tw-border-solid adt-tw-align-top adt-tw-py-4">
            <p class="adt-tw-m-0 adt-tw-p-0 adt-tw-mb-2">
                <?php esc_html_e( 'Please select one or more feeds to export. Use search to find feeds by title.', 'woo-product-feed-pro' ); ?>
            </p>
            <div class="adt-tw-flex adt-tw-items-start adt-tw-gap-2">
                <div class="adt-export-import-select2 adt-tw-w-[320px]">
                    <select name="export_file[]" id="export_file" class="adt-select2-feeds" multiple="multiple" style="width: 100%;" data-placeholder="<?php esc_attr_e( 'Select Feeds', 'woo-product-feed-pro' ); ?>">
                    </select>
                </div>
                <div class="adt-tw-flex adt-tw-items-center adt-tw-gap-2">
                    <button type="button" class="adt-export-import-button adt-button adt-button-sm adt-button-primary adt-tw-gap-2" data-action="export_selected_feeds">
                        <span class="adt-tw-icon-[lucide--download]"></span>
                        <?php esc_html_e( 'Export Feeds', 'woo-product-feed-pro' ); ?>
                    </button>
                    <span class="adt-loader adt-loader-sm"></span>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td colspan="2" class="adt-tw-border-0 adt-tw-border-b adt-tw-border-gray-200 adt-tw-border-solid adt-tw-align-top adt-tw-py-2">
            <h3 class="adt-tw-font-semibold adt-tw-mb-1">
                <?php esc_html_e( 'Import Feeds', 'woo-product-feed-pro' ); ?>
            </h3>
            <p class="adt-tw-m-0 adt-tw-p-0 adt-tw-mb-2">
                <?php esc_html_e( 'Import feeds from a file.', 'woo-product-feed-pro' ); ?>
                <?php if ( ! Helper::has_paid_plugin_active() ) : ?>
                    <br>
                    <span class="adt-tw-italic">
                        <?php esc_html_e( 'Elite plugin required for import functionality.', 'woo-product-feed-pro' ); ?>
                        <a href="<?php echo esc_url( Helper::get_utm_url( 'pricing', 'pfp', 'importfeedsheader', 'importfeeds' ) ); ?>" target="_blank"><?php esc_html_e( 'See all features & pricing.', 'woo-product-feed-pro' ); ?></a>
                        </a>
                    </span>
                <?php endif; ?>
            </p>
        </td>
    </tr>
    <tr>
        <td class="adt-tw-w-[260px] adt-tw-border-0 adt-tw-border-b adt-tw-border-gray-200 adt-tw-border-solid adt-tw-align-top adt-tw-py-4">
            <p class="adt-tw-text-base adt-tw-m-0 adt-tw-p-0"><?php esc_html_e( 'Import Feeds', 'woo-product-feed-pro' ); ?></p>
        </td>
        <td class="adt-tw-border-0 adt-tw-border-b adt-tw-border-gray-200 adt-tw-border-solid adt-tw-align-top adt-tw-py-4">
            <div class="adt-tw-import-feeds-container">
                <p class="adt-tw-m-0 adt-tw-p-0 adt-tw-mb-2">
                    <?php esc_html_e( 'Please upload the exported file here to import feeds.', 'woo-product-feed-pro' ); ?>
                </p>
                <div class="adt-tw-flex adt-tw-items-center adt-tw-gap-2 adt-tw-mb-3">
                    <input type="file" name="import_file" id="import_file" accept=".json" 
                    <?php
                    if ( ! Helper::has_paid_plugin_active() ) {
?>
disabled<?php } ?>>
                    <button type="button" class="adt-export-import-button adt-button adt-button-sm adt-tw-gap-2 <?php echo Helper::has_paid_plugin_active() ? 'adt-button-primary' : 'adt-button-disabled'; ?>" data-action="import_feeds">
                        <span class="adt-tw-icon-[lucide--upload]"></span>
                        <?php esc_html_e( 'Import Feeds', 'woo-product-feed-pro' ); ?>
                    </button>
                    <span class="adt-loader adt-loader-sm"></span>
                </div>
                <div class="adt-tw-flex adt-tw-items-center adt-tw-gap-2">
                    <input type="checkbox" name="overwrite_existing_feeds" id="overwrite_existing_feeds" class="adt-tw-m-0" <?php disabled( ! Helper::has_paid_plugin_active() ); ?>>
                    <label for="overwrite_existing_feeds" class="adt-tw-text-sm adt-tw-text-gray-700 adt-tw-cursor-pointer">
                        <div class="adt-tw-flex adt-tw-items-center adt-tw-gap-2">
                            <?php esc_html_e( 'Overwrite existing feeds', 'woo-product-feed-pro' ); ?>
                            <span class="adt-tooltip">
                                <span class="adt-tw-icon-[lucide--info]"></span>
                                <div class="adt-tooltip-content">
                                    <?php esc_html_e( 'Overwrite existing feeds (import feeds even if they already exist)', 'woo-product-feed-pro' ); ?>
                                    <br>
                                    <?php esc_html_e( 'If you overwrite existing feeds, the existing feeds will be overwritten with the new feeds.', 'woo-product-feed-pro' ); ?>
                                    <br>
                                    <?php esc_html_e( 'If you do not overwrite existing feeds, the existing feeds will be skipped.', 'woo-product-feed-pro' ); ?>
                                </div>
                            </span>
                        </div>
                    </label>
                </div>
            </div>
        </td>
    </tr>
</table>
<?php
do_action( 'adt_pfp_settings_page_export_import_tab_content' );
?>
