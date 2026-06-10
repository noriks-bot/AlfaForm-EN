<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Helpers\Helper;
?>
<div class="wrap adt-tw-wrapper nosubsub">
    <div class="adt-container lg:adt-tw-px-8 sm:adt-tw-py-4 adt-tw-py-0">
        <?php
            Helper::locate_admin_template( 'header.php', true );
        ?>
        <h1 class="adt-tw-text-[32px] adt-tw-font-semibold adt-tw-text-gray-800 adt-tw-mb-2">
            <?php esc_html_e( 'About AdTribes', 'woo-product-feed-pro' ); ?>
            <p class="adt-tw-text-base adt-tw-mt-2 adt-tw-font-normal">
                <?php esc_html_e( 'Hello and welcome to AdTribes, the most popular advertising solution for WooCommerce.', 'woo-product-feed-pro' ); ?>
            </p>
        </h1>
        <div id="pfp-about-page" class="pfp-page">
            <?php wp_nonce_field( 'adt_install_plugin', 'adt-install-plugin' ); ?>
            <div class="row mb-2">
                <div class="col">
                    <div class="card card-img">
                        <img class="card-img-right" src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'rymera-team.jpg' ); ?>" alt="<?php esc_attr_e( 'Rymera Team', 'woo-product-feed-pro' ); ?>" />
                        <div class="card-body xs-text-center">
                            <h3><?php esc_html_e( 'About The Makers - Rymera Web Co', 'woo-product-feed-pro' ); ?></h3>
                            <p><?php esc_html_e( 'Over the years, we\'ve worked with thousands of smart store owners who were frustrated by the complexities of managing their online stores and advertising campaigns efficiently.', 'woo-product-feed-pro' ); ?></p>
                            <p><?php esc_html_e( 'That\'s where AdTribes comes in - a state-of-the-art suite of product feed tools designed to streamline your advertising efforts and integrate seamlessly with your existing WooCommerce store.', 'woo-product-feed-pro' ); ?></p>
                            <p><?php esc_html_e( 'AdTribes is brought to you by the same dedicated team that has been at the forefront of WooCommerce solutions for over a decade. We\'re passionate about helping you achieve the best results with our tools. We\'re thrilled you\'re using our tool and invite you to try our other plugins as well!', 'woo-product-feed-pro' ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <ul class="card-list">
                        <li class="card">
                            <div class="card-title">
                                <img src="<?php echo esc_url( 'https://ps.w.org/advanced-coupons-for-woocommerce-free/assets/icon-128x128.png' ); ?>" alt="<?php esc_attr_e( 'Advanced Coupons', 'woo-product-feed-pro' ); ?>" />
                                <h3><?php esc_html_e( 'Advanced Coupons for WooCommerce (Free Plugin)', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'Extends your coupon features so you can market your store better. Adds cart conditions (coupon rules), buy one get one (BOGO) deals, url coupons, coupon categories and loads more.', 'woo-product-feed-pro' ); ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="install-status">
                                    <p class="m-0">
                                        <strong><?php esc_html_e( 'Status:', 'woo-product-feed-pro' ); ?></strong>
                                        <span class="install-status-value"><?php echo Helper::is_plugin_installed( 'advanced-coupons-for-woocommerce-free/advanced-coupons-for-woocommerce-free.php' ) ? esc_html_e( 'Installed', 'woo-product-feed-pro' ) : esc_html_e( 'Not installed', 'woo-product-feed-pro' ); ?></span>
                                    </p>
                                    <?php if ( ! Helper::is_plugin_installed( 'advanced-coupons-for-woocommerce-free/advanced-coupons-for-woocommerce-free.php' ) ) : ?>
                                    <a href="#" data-plugin-slug="advanced-coupons-for-woocommerce-free" class="button button-primary pfp-install-plugin"><?php esc_html_e( 'Install Plugin', 'woo-product-feed-pro' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="card-title">
                                <img src="<?php echo esc_url( 'https://ps.w.org/storeagent-ai-for-woocommerce/assets/icon-128x128.png' ); ?>" alt="<?php esc_attr_e( 'StoreAgent AI for WooCommerce', 'woo-product-feed-pro' ); ?>" />
                                <h3><?php esc_html_e( 'StoreAgent AI for WooCommerce (Free Plugin)', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'Boost your WooCommerce store with AI agents. Generate product descriptions, automatically create review summaries with sentiment analysis, add AI-powered product Q&A, and loads more.', 'woo-product-feed-pro' ); ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="install-status">
                                    <p class="m-0">
                                        <strong><?php esc_html_e( 'Status:', 'woo-product-feed-pro' ); ?></strong>
                                        <span class="install-status-value"><?php echo Helper::is_plugin_installed( 'storeagent-ai-for-woocommerce/storeagent-ai-for-woocommerce.php' ) ? esc_html_e( 'Installed', 'woo-product-feed-pro' ) : esc_html_e( 'Not installed', 'woo-product-feed-pro' ); ?></span>
                                    </p>
                                    <?php if ( ! Helper::is_plugin_installed( 'storeagent-ai-for-woocommerce/storeagent-ai-for-woocommerce.php' ) ) : ?>
                                    <a href="#" data-plugin-slug="storeagent-ai-for-woocommerce" class="button button-primary pfp-install-plugin"><?php esc_html_e( 'Install Plugin', 'woo-product-feed-pro' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="card-title">
                                <img src="<?php echo esc_url( 'https://ps.w.org/wc-vendors/assets/icon.svg' ); ?>" alt="<?php esc_attr_e( 'WC Vendors', 'woo-product-feed-pro' ); ?>" />
                                <h3><?php esc_html_e( 'WC Vendors (Free Plugin)', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'Easiest way to create your multivendor marketplace and earn commission from every sale. Create a WooCommerce marketplace with multi-seller, product vendor & multi vendor commissions.', 'woo-product-feed-pro' ); ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="install-status">
                                    <p class="m-0">
                                        <strong><?php esc_html_e( 'Status:', 'woo-product-feed-pro' ); ?></strong>
                                        <span class="install-status-value"><?php echo Helper::is_plugin_installed( 'wc-vendors\class-wc-vendors.php' ) ? esc_html_e( 'Installed', 'woo-product-feed-pro' ) : esc_html_e( 'Not installed', 'woo-product-feed-pro' ); ?></span>
                                    </p>
                                    <?php if ( ! Helper::is_plugin_installed( 'wc-vendors\class-wc-vendors.php' ) ) : ?>
                                    <a href="#" data-plugin-slug="wc-vendors" class="button button-primary pfp-install-plugin"><?php esc_html_e( 'Install Plugin', 'woo-product-feed-pro' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li> 
                        <li class="card">
                            <div class="card-title">
                                <img src="<?php echo esc_url( 'https://ps.w.org/woocommerce-wholesale-prices/assets/icon-128x128.jpg' ); ?>" alt="<?php esc_attr_e( 'WooCommerce Wholesale Prices', 'woo-product-feed-pro' ); ?>" />
                                <h3><?php esc_html_e( 'WooCommerce Wholesale Prices (Free Plugin)', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'The #1 WooCommerce wholesale plugin for adding wholesale prices & managing B2B customers. Trusted by over 25k store owners for managing wholesale orders, pricing, visibility, user roles, and more.', 'woo-product-feed-pro' ); ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="install-status">
                                    <p class="m-0">
                                        <strong><?php esc_html_e( 'Status:', 'woo-product-feed-pro' ); ?></strong>
                                        <span class="install-status-value"><?php echo Helper::is_plugin_installed( 'woocommerce-wholesale-prices/woocommerce-wholesale-prices.plugin.php' ) ? esc_html_e( 'Installed', 'woo-product-feed-pro' ) : esc_html_e( 'Not installed', 'woo-product-feed-pro' ); ?></span>
                                    </p>
                                    <?php if ( ! Helper::is_plugin_installed( 'woocommerce-wholesale-prices/woocommerce-wholesale-prices.plugin.php' ) ) : ?>
                                    <a href="#" data-plugin-slug="woocommerce-wholesale-prices" class="button button-primary pfp-install-plugin"><?php esc_html_e( 'Install Plugin', 'woo-product-feed-pro' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li> 
                        <li class="card">
                            <div class="card-title">
                                <img src="<?php echo esc_url( 'https://ps.w.org/invoice-gateway-for-woocommerce/assets/icon-128x128.jpg' ); ?>" alt="<?php esc_attr_e( 'Invoice Gateway for WooCommerce', 'woo-product-feed-pro' ); ?>" />
                                <h3><?php esc_html_e( 'Invoice Gateway for WooCommerce (Free Plugin)', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'Accept orders via a special invoice payment gateway method which lets your customer enter their order without upfront payment. Then just issue an invoice from your accounting system and paste in the number.', 'woo-product-feed-pro' ); ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="install-status">
                                    <p class="m-0">
                                        <strong><?php esc_html_e( 'Status:', 'woo-product-feed-pro' ); ?></strong>
                                        <span class="install-status-value"><?php echo Helper::is_plugin_installed( 'invoice-gateway-for-woocommerce/invoice-gateway-for-woocommerce.php' ) ? esc_html_e( 'Installed', 'woo-product-feed-pro' ) : esc_html_e( 'Not installed', 'woo-product-feed-pro' ); ?></span>
                                    </p>
                                    <?php if ( ! Helper::is_plugin_installed( 'invoice-gateway-for-woocommerce/invoice-gateway-for-woocommerce.php' ) ) : ?>
                                    <a href="#" data-plugin-slug="invoice-gateway-for-woocommerce" class="button button-primary pfp-install-plugin"><?php esc_html_e( 'Install Plugin', 'woo-product-feed-pro' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li> 
                        <li class="card">
                            <div class="card-title">
                                <img src="<?php echo esc_url( 'https://ps.w.org/woocommerce-exporter/assets/icon-128x128.png' ); ?>" alt="<?php esc_attr_e( 'Store Exporter for WooCommerce', 'woo-product-feed-pro' ); ?>" />
                                <h3><?php esc_html_e( 'Store Exporter for WooCommerce (Free Plugin)', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'Easily export Orders, Subscriptions, Coupons, Products, Categories, Tags to a variety of formats. The deluxe version also adds scheduled exporting for easy reporting and syncing with other systems.', 'woo-product-feed-pro' ); ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="install-status">
                                    <p class="m-0">
                                        <strong><?php esc_html_e( 'Status:', 'woo-product-feed-pro' ); ?></strong>
                                        <span class="install-status-value"><?php echo Helper::is_plugin_installed( 'woocommerce-exporter/exporter.php' ) ? esc_html_e( 'Installed', 'woo-product-feed-pro' ) : esc_html_e( 'Not installed', 'woo-product-feed-pro' ); ?></span>
                                    </p>
                                    <?php if ( ! Helper::is_plugin_installed( 'woocommerce-exporter/exporter.php' ) ) : ?>
                                    <a href="#" data-plugin-slug="woocommerce-exporter" class="button button-primary pfp-install-plugin"><?php esc_html_e( 'Install Plugin', 'woo-product-feed-pro' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li> 
                        <li class="card">
                            <div class="card-title">
                                <img src="<?php echo esc_url( 'https://ps.w.org/woocommerce-store-toolkit/assets/icon-128x128.png' ); ?>" alt="<?php esc_attr_e( 'Store Toolkit for WooCommerce', 'woo-product-feed-pro' ); ?>" />
                                <h3><?php esc_html_e( 'Store Toolkit for WooCommerce (Free Plugin)', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'A growing set of commonly-used WooCommerce admin tools such as deleting WooCommerce data in bulk, such as products, orders, coupons, and customers. It also adds extra small features, order filtering, and more.', 'woo-product-feed-pro' ); ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="install-status">
                                    <p class="m-0">
                                        <strong><?php esc_html_e( 'Status:', 'woo-product-feed-pro' ); ?></strong>
                                        <span class="install-status-value"><?php echo Helper::is_plugin_installed( 'woocommerce-store-toolkit/store-toolkit.php' ) ? esc_html_e( 'Installed', 'woo-product-feed-pro' ) : esc_html_e( 'Not installed', 'woo-product-feed-pro' ); ?></span>
                                    </p>
                                    <?php if ( ! Helper::is_plugin_installed( 'woocommerce-store-toolkit/store-toolkit.php' ) ) : ?>
                                    <!-- <a href="<?php echo esc_url( wp_nonce_url( 'update.php?action=install-plugin&plugin=woocommerce-store-toolkit', 'install-plugin_woocommerce-store-toolkit' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install Plugin', 'woo-product-feed-pro' ); ?></a> -->
                                    <a href="#" data-plugin-slug="woocommerce-store-toolkit" class="button button-primary pfp-install-plugin"><?php esc_html_e( 'Install Plugin', 'woo-product-feed-pro' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="card-title">
                                <img src="<?php echo esc_url( 'https://ps.w.org/saveto-wishlist-lite-for-woocommerce/assets/icon-128x128.png' ); ?>" alt="<?php esc_attr_e( 'SaveTo Wishlist Lite for WooCommerce', 'woo-product-feed-pro' ); ?>" />
                                <h3><?php esc_html_e( 'SaveTo Wishlist Lite for WooCommerce (Free Plugin)', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'A simple, powerful WooCommerce wishlist plugin to help customers save products they love and buy later.', 'woo-product-feed-pro' ); ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="install-status">
                                    <p class="m-0">
                                        <strong><?php esc_html_e( 'Status:', 'woo-product-feed-pro' ); ?></strong>
                                        <span class="install-status-value"><?php echo Helper::is_plugin_installed( 'saveto-wishlist-lite-for-woocommerce/saveto-wishlist-lite-for-woocommerce.php' ) ? esc_html_e( 'Installed', 'woo-product-feed-pro' ) : esc_html_e( 'Not installed', 'woo-product-feed-pro' ); ?></span>
                                    </p>
                                    <?php if ( ! Helper::is_plugin_installed( 'saveto-wishlist-lite-for-woocommerce/saveto-wishlist-lite-for-woocommerce.php' ) ) : ?>
                                    <a href="#" data-plugin-slug="saveto-wishlist-lite-for-woocommerce" class="button button-primary pfp-install-plugin"><?php esc_html_e( 'Install Plugin', 'woo-product-feed-pro' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
