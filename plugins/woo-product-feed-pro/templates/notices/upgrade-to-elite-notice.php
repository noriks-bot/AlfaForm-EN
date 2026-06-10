<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Helpers\Helper;

if ( Helper::is_show_get_elite_notice() ) {
?>
    <div class="notice notice-info get_elite is-dismissible">
        <p>
            <strong><?php esc_html_e( 'Would you like to get more out of your product feeds? Upgrade to the Elite version of the plugin and you will get:', 'woo-product-feed-pro' ); ?></strong><br /></br />
            <span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Priority support - we will help you to get your product feed(s) up-and-running;', 'woo-product-feed-pro' ); ?><br />
            <span class="dashicons dashicons-yes"></span><?php esc_html_e( 'GTIN, Brand, MPN, EAN, Condition and more fields for your product feeds', 'woo-product-feed-pro' ); ?> [<a href="<?php echo esc_url( Helper::get_utm_url( 'add-gtin-mpn-upc-ean-product-condition-optimised-title-and-brand-attributes', 'pfp', 'upgradenotice', 'addingfields' ) ); ?>" target="_blank"><?php esc_html_e( 'Read more', 'woo-product-feed-pro' ); ?></a>];<br />
            <span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Solve Googe Shopping price mismatch product disapprovals', 'woo-product-feed-pro' ); ?> [<a href="<?php echo esc_url( Helper::get_utm_url( 'woocommerce-structured-data-bug', 'pfp', 'upgradenotice', 'structureddatabug' ) ); ?>" target="_blank"><?php esc_html_e( 'Read more', 'woo-product-feed-pro' ); ?></a>];<br />
            <span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Advanced product data manipulation', 'woo-product-feed-pro' ); ?> [<a href="<?php echo esc_url( Helper::get_utm_url( 'feature-product-data-manipulation', 'pfp', 'upgradenotice', 'productdatamanipulation' ) ); ?>" target="_blank"><?php esc_html_e( 'Read more', 'woo-product-feed-pro' ); ?></a>];<br />
            <span class="dashicons dashicons-yes"></span><?php esc_html_e( 'WPML support - including their currency switcher', 'woo-product-feed-pro' ); ?> [<a href="<?php echo esc_url( Helper::get_utm_url( 'wpml-support', 'pfp', 'upgradenotice', 'wpmlsupport' ) ); ?>" target="_blank"><?php esc_html_e( 'Read more', 'woo-product-feed-pro' ); ?></a>];<br />
            <span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Aelia  & Curcy currency switcher support', 'woo-product-feed-pro' ); ?> [<a href="<?php echo esc_url( Helper::get_utm_url( 'aelia-currency-switcher-feature', 'pfp', 'upgradenotice', 'aeliasupport' ) ); ?>" target="_blank"><?php esc_html_e( 'Read more', 'woo-product-feed-pro' ); ?></a>];<br />
            <span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Polylang support', 'woo-product-feed-pro' ); ?> [<a href="<?php echo esc_url( Helper::get_utm_url( 'polylang-support-product-feeds', 'pfp', 'upgradenotice', 'polylangsupport' ) ); ?>" target="_blank"><?php esc_html_e( 'Read more', 'woo-product-feed-pro' ); ?></a>];<br />
            <span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Facebook pixel feature', 'woo-product-feed-pro' ); ?> [<a href="<?php echo esc_url( Helper::get_utm_url( 'facebook-pixel-feature', 'pfp', 'upgradenotice', 'facebookpixelfeature' ) ); ?>" target="_blank"><?php esc_html_e( 'Read more', 'woo-product-feed-pro' ); ?></a>];<br /><br />
            <a class="button button-pink" href="<?php echo esc_url( Helper::get_utm_url( 'pro-vs-elite', 'pfp', 'upgradenotice', 'upgradebutton' ) ); ?>" target="_blank"><?php esc_html_e( 'Upgrade To Elite', 'woo-product-feed-pro' ); ?></a>
        </p>
    </div>
<?php
}
?>
