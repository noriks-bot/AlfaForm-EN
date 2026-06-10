<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Helpers\Helper;
?>
<div class="wrap adt-tw-wrapper adt-license-settings">
    <div class="adt-container adt-license-settings-container lg:adt-tw-px-8 sm:adt-tw-py-4 adt-tw-py-0">
        <?php Helper::locate_admin_template( 'header.php', true ); ?>
        <h1 class="adt-tw-text-[32px] adt-tw-font-semibold adt-tw-text-gray-800 adt-tw-mb-2">
            <?php esc_html_e( 'Licenses', 'woo-product-feed-pro' ); ?>
            <p class="adt-tw-text-base adt-tw-mt-2 adt-tw-font-normal">
                <?php esc_html_e( 'Enter your license keys below to enjoy full access, plugin updates, and support.', 'woo-product-feed-pro' ); ?>
            </p>
        </h1>
        <div class="postbox license-box">
            <ul class="license-nav-tabs">
                <li class="active">
                    <a href="#" class="tab-link"><?php esc_html_e( 'Product Feed', 'woo-product-feed-pro' ); ?></a>
                </li>
            </ul>

            <div class="tab">
                <div class="row">
                    <p class="text-large col-left mt-0 mb-2">
                        <span class="text-bold"><?php esc_html_e( 'Version: ', 'woo-product-feed-pro' ); ?></span>
                        <span><?php echo esc_html( WOOCOMMERCESEA_PLUGIN_VERSION ); ?></span>
                    </p>
                    <p class="text-large col-right mt-0">
                        <span class="text-bold"><?php esc_html_e( 'License Status: ', 'woo-product-feed-pro' ); ?></span>
                        <span class="text-color-green"><?php esc_html_e( 'Free Version', 'woo-product-feed-pro' ); ?></span>
                    </p>
                </div>
                <div class="row">
                    <div class="col-left">
                        <h2><?php esc_html_e( 'Upgrade to Product Feed Elite', 'woo-product-feed-pro' ); ?></h2>
                        <p><?php esc_html_e( 'The Product Feed Elite version has multi-lingual/multi-currency integrations via WPML, Aelia, Curcy + more. Additional product fields such as brand, GTIN, MPN, EAN, as well as conditions & filters. Google Dynamic remarketing tags, Facebook pixel support & more.', 'woo-product-feed-pro' ); ?></p>
                        <ul class="features-list mb-2">
                            <li><?php esc_html_e( 'New additional product fields like Brand, GTIN, MPN, EAN, and more.', 'woo-product-feed-pro' ); ?></li>
                            <li><?php esc_html_e( 'Remarketing and advanced pixel support.', 'woo-product-feed-pro' ); ?></li>
                            <li><?php esc_html_e( 'Advanced data manipulation with extra conditions & filters.', 'woo-product-feed-pro' ); ?></li>
                        </ul>
                        <a href="<?php echo esc_url( Helper::get_utm_url( 'pricing', 'pfp', 'license', 'upgradelicensebutton' ) ); ?>" target="_blank" rel="noopener noreferrer" class="button button-pink button-hero mb-1">
                            <?php esc_html_e( 'Get Product Feed Elite & Unlock All Features', 'woo-product-feed-pro' ); ?>
                        </a>
                        <div class="learn-more">
                            <a href="<?php echo esc_url( Helper::get_utm_url( 'plugin-features', 'pfp', 'license', 'learnmorelicenselink' ) ); ?>" target="_blank" rel="noopener noreferrer">
                                <?php esc_html_e( 'Learn more about Elite features', 'woo-product-feed-pro' ); ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-right pfe-image">
                        <img class="img-responsive" src="<?php echo esc_attr( ADT_PFP_IMAGES_URL . 'pfe-image.png' ); ?>" alt="<?php esc_attr_e( 'Product Feed Elite', 'woo-product-feed-pro' ); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
