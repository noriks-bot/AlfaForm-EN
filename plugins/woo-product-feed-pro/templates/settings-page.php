<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Classes\Admin_Pages\Settings_Page;

$settings_page = Settings_Page::instance();
$active_tab    = $settings_page->get_active_tab();
$settings_tabs = $settings_page->get_tabs();
?>

<div class="wrap adt-tw-wrapper nosubsub">
    <div class="adt-container lg:adt-tw-px-8 sm:adt-tw-py-4 adt-tw-py-0">
        <?php Helper::locate_admin_template( 'header.php', true ); ?>
        <h1 class="adt-tw-text-2xl adt-tw-font-semibold adt-tw-text-gray-800 adt-tw-mb-2">
            <?php echo esc_html( $settings_page->get_header_text( $active_tab ) ); ?>
        </h1>
        <div class="woo-product-feed-pro-form-style-2">
            <tbody class="woo-product-feed-pro-body">
                <h2 class="nav-tab-wrapper woo-product-feed-pro-nav-tab-wrapper">
                    <?php foreach ( $settings_tabs as $settings_tab ) : ?>
                    <a href="?page=woosea_manage_settings&tab=<?php echo esc_attr( $settings_tab['slug'] ); ?>" data-tab="<?php echo esc_attr( $settings_tab['slug'] ); ?>" class="nav-tab <?php echo $active_tab === $settings_tab['slug'] ? esc_attr( 'nav-tab-active' ) : ''; ?>">
                        <?php echo esc_html( $settings_tab['label'] ); ?>
                    </a>
                    <?php endforeach; ?>
                </h2>

                <div class="woo-product-feed-pro-table-wrapper adt-tw-mt-4">
                    <div class="woo-product-feed-pro-table-left">
                        <?php $settings_page->render_tab_content(); ?>
                    </div>
                </div>
            </tbody>
        </div>
    </div>
</div>
