<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/** @var PYS $this */

include "html-popovers.php";

//components
include_once 'components/recommended-video.php';

?>

<div class="wrap" id="pys">
    <div class=" pys-general-menu">
        <div class="pys-logo">
            <img src="<?php echo PYS_FREE_URL; ?>/dist/images/pys-logo.svg" alt="pys-logo">
        </div>

        <nav class="nav nav-tabs">

            <?php foreach ( getAdminPrimaryNavTabs() as $tab_key => $tab_data ) : ?>

                <?php

                $classes = array(
                    'nav-item',
                    'nav-link',
                );

                if ( $tab_key == getCurrentAdminTab() ) {
                    $classes[] = 'active';
                }

                $classes = implode( ' ', $classes );

                if ( isset( $tab_data[ 'class' ] ) ) {
                    $classes .= ' ' . $tab_data[ 'class' ];
                }

                ?>

                <a class="<?php echo esc_attr( $classes ); ?>"
                   href="<?php echo esc_url( $tab_data[ 'url' ] ); ?>">
                    <?php esc_html_e( $tab_data[ 'name' ] ); ?>
                </a>

            <?php endforeach; ?>

        </nav>
    </div>

    <?php

    switch ( getCurrentAdminTab() ) {
        case 'general':
            $title = 'Welcome to PixelYourSite Free';
            break;

        case 'events':
            $title = 'PixelYourSite Free Events';
            break;

        case 'woo':
            $title = 'WooCommerce Settings';
            break;

        case 'edd':
            $title = 'EasyDigitalDownloads Settings';
            break;

        case 'wcf':
            $title = 'CartFlows Settings';
            break;

        case 'head_footer':
            $title = 'Head & Footer';
            break;

        case 'facebook_settings':
            $title = 'Facebook Settings';
            break;

        case 'google_tags_settings':
            $title = 'Google Tags Settings';
            break;

        case 'gtm_tags_settings':
            $title = 'GTM Settings';
            break;

        case 'pinterest_settings':
            $title = 'Pinterest Settings';
            break;

        case 'gdpr':
            $title = 'Consent';
            break;

        case 'reset_settings':
            $title = '';
            break;

        case 'logs':
            $title = 'Logs';
            break;

        case 'hooks':
            $title = 'Filter & Hook List';
            break;

        case 'superpack_settings':
            $title = 'Super Pack Settings';
            break;

        default:
            $title = 'Welcome to PixelYourSite Free';
    }
    ?>

    <h1 id="pys-title" class="primary_heading"><?php _e( $title, 'pys' ); ?></h1>
    <div class="container">
        <form method="post" enctype="multipart/form-data" id="pys-form">

            <?php wp_nonce_field( 'pys_save_settings' ); ?>

            <div class="general-row d-flex">
                <div class="general-col">

                    <?php
                    switch ( getCurrentAdminTab() ) {
                        case 'general':
                            include "html-main-general.php";
                            break;
                        case 'events':
                            if ( getCurrentAdminAction() == 'edit' ) {
                                include "html-main-events-edit.php";
                            } else {
                                include "html-main-events.php";
                            }
                            break;

                        case 'woo':
                            include "html-main-woo.php";
                            break;

                        case 'edd':
                            include "html-main-edd.php";
                            break;
                        case 'wcf':
                            include "html-main-wcf.php";
                            break;

                        case 'head_footer':
                            /** @noinspection PhpIncludeInspection */
                            if ( current_user_can( 'manage_pys' ) && current_user_can('unfiltered_html') )
                            {
                                include PYS_FREE_PATH . '/modules/head_footer/views/html-admin-page.php';
                            }
                            else
                            {
                                include PYS_FREE_PATH . '/modules/head_footer/views/html-admin-not-permission-page.php';
                            }

                            break;

                        case 'facebook_settings':
                            /** @noinspection PhpIncludeInspection */
                            include PYS_FREE_PATH . '/modules/facebook/views/html-settings.php';
                            break;

                        case 'google_tags_settings':
                            /** @noinspection PhpIncludeInspection */
                            include PYS_FREE_PATH . '/modules/google_analytics/views/html-settings.php';
                            break;
                        case 'gtm_tags_settings':
                            /** @noinspection PhpIncludeInspection */
                            include PYS_FREE_PATH . '/modules/google_gtm/views/html-settings.php';
                            break;

                        case 'superpack_settings':
                            /** @noinspection PhpIncludeInspection */
                            include PYS_FREE_PATH . '/modules/superpack/views/html-settings.php';
                            break;

                        case 'gdpr':
                            include "html-gdpr.php";
                            break;

                        case 'reset_settings':
                            include "html-reset.php";
                            break;
                        case 'logs':
                            include "html-logs.php";
                            break;
                        case 'hooks':
                            include "html-hooks.php";
                            break;

                        default:
                            do_action( 'pys_admin_' . getCurrentAdminTab() );
                    }

                    ?>

                </div>
                <div class="sidebar-col">
                    <div class="item-wrap card-blue upgrade-card">
                        <p class="mb-20">Track every key action and improve your ads return with the PRO version:</p>

                        <div>
                            <a href="https://www.pixelyoursite.com/facebook-pixel-plugin/buy-pixelyoursite-pro?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-upgrade-blue"
                               target="_blank"
                               class="link-extra-small upgrade-item-button">Upgrade</a>
                        </div>
                    </div>
                    <div class="item-wrap">
                        <nav class="nav nav-pills flex-column">
                            <?php foreach ( getAdminSecondaryNavTabs() as $tab_key => $tab_data ) : ?>

                                <?php

                                $classes = array(
                                    'nav-item',
                                    'nav-link',
                                );

                                if ( $tab_key == getCurrentAdminTab() ) {
                                    $classes[] = 'active';
                                }

                                $classes = implode( ' ', $classes );

                                ?>

                                <a class="<?php echo esc_attr( $classes ); ?>"
                                   href="<?php echo esc_url( $tab_data[ 'url' ] ); ?>">
                                    <div class="sidebar-menu-item">
                                        <img src="<?php echo esc_url( $tab_data[ 'icon' ] ); ?>"
                                             alt="<?php echo esc_attr( $tab_key ); ?>">

                                        <div class="sidebar-menu-title secondary_heading">
                                            <?php esc_html_e( $tab_data[ 'name' ] ); ?>
                                        </div>
                                    </div>
                                </a>

                            <?php endforeach; ?>

                            <a class="<?php echo esc_attr( $classes ); ?>"
                               href="https://www.pixelyoursite.com/documentation?utm_source=pro&utm_medium=plugin&utm_campaign=right-column-pro"
                               target="_blank"">
                            <div class="sidebar-menu-item">

                                <img src="<?php echo PYS_FREE_URL . '/dist/images/help-icon.svg'; ?>"
                                     alt="help">

                                <div class="sidebar-menu-title secondary_heading">
                                    HELP
                                </div>
                            </div>
                            </a>
                        </nav>
                    </div>

                    <?php if ( !isConsentMagicPluginActivated() ) : ?>
                        <div class="item-wrap card-orange">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                     fill="#E16B43">
                                    <path d="M14.0001 27.3334C21.3639 27.3334 27.3334 21.3638 27.3334 14C27.3334 6.63622 21.3639 0.666687 14.0001 0.666687C6.63628 0.666687 0.666748 6.63622 0.666748 14C0.666748 21.3638 6.63628 27.3334 14.0001 27.3334Z"
                                          fill="white"></path>
                                    <path d="M14.0002 9.50667C14.9206 9.50667 15.6668 8.76048 15.6668 7.84001C15.6668 6.91953 14.9206 6.17334 14.0002 6.17334C13.0797 6.17334 12.3335 6.91953 12.3335 7.84001C12.3335 8.76048 13.0797 9.50667 14.0002 9.50667Z"
                                          fill="#E16B43"></path>
                                    <path d="M14.0002 21.84C13.6465 21.84 13.3074 21.6995 13.0574 21.4495C12.8073 21.1994 12.6668 20.8603 12.6668 20.5067V13.84C12.3132 13.84 11.9741 13.6995 11.724 13.4495C11.474 13.1994 11.3335 12.8603 11.3335 12.5067C11.3335 12.1531 11.474 11.8139 11.724 11.5639C11.9741 11.3138 12.3132 11.1733 12.6668 11.1733H14.0002C14.3538 11.1733 14.6929 11.3138 14.943 11.5639C15.193 11.8139 15.3335 12.1531 15.3335 12.5067V20.5067C15.3335 20.8603 15.193 21.1994 14.943 21.4495C14.6929 21.6995 14.3538 21.84 14.0002 21.84Z"
                                          fill="#E16B43"></path>
                                    <path d="M15.3335 21.84H12.6668C12.3132 21.84 11.9741 21.6995 11.724 21.4495C11.474 21.1994 11.3335 20.8603 11.3335 20.5067C11.3335 20.153 11.474 19.8139 11.724 19.5639C11.9741 19.3138 12.3132 19.1733 12.6668 19.1733H15.3335C15.6871 19.1733 16.0263 19.3138 16.2763 19.5639C16.5264 19.8139 16.6668 20.153 16.6668 20.5067C16.6668 20.8603 16.5264 21.1994 16.2763 21.4495C16.0263 21.6995 15.6871 21.84 15.3335 21.84Z"
                                          fill="#E16B43"></path>
                                </svg>
                            </div>

                            <h4 class="card-title primary_heading">ConsentMagic</h4>

                            <p class="card-text">Persuade your visitors to agree to tracking, while respecting the
                                legal requirements. Inform, opt-out, or block tracking when needed.</p>

                            <div>
                                <a href="https://www.pixelyoursite.com/plugins/consentmagic?utm_source=pro&utm_medium=plugin&utm_campaign=right-column-pro"
                                   target="_blank"
                                   class="link link-white link-extra-small">Click for details</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( 'woo' == getCurrentAdminTab() ) : ?>
                        <div class="item-wrap">
                            <div class="icon">
                                <img src="<?php echo PYS_FREE_URL . '/dist/images/info.svg'; ?>" alt="info">
                            </div>

                            <h4 class="card-title primary_heading">Custom Audience File Export</h4>

                            <p class="card-text">Export a customer file with lifetime value. Use it to create a
                                Custom Audience and a Value-Based Lookalike Audience. More details
                            </p>

                            <div>
                                <a href="https://www.pixelyoursite.com/value-based-facebook-lookalike-audiences?utm_source=pro&utm_medium=plugin&utm_campaign=right-column-pro"
                                   target="_blank"
                                   class="link link-extra-small">Export clients LTV file</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( 'edd' == getCurrentAdminTab() ) : ?>
                        <div class="item-wrap">
                            <div class="icon">
                                <img src="<?php echo PYS_FREE_URL . '/dist/images/info.svg'; ?>" alt="info">
                            </div>

                            <h4 class="card-title primary_heading">Custom Audience File Export</h4>

                            <p class="card-text">Export a customer file with lifetime value. Use it to create a
                                Custom Audience and a Value-Based Lookalike Audience. More details
                            </p>

                            <div>
                                <a href="https://www.pixelyoursite.com/value-based-facebook-lookalike-audiences?utm_source=pro&utm_medium=plugin&utm_campaign=right-column-pro"
                                   target="_blank"
                                   class="link link-extra-small">Export clients LTV file</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( !isProductCatalogFeedProActive() ) : ?>
                        <div class="item-wrap">
                            <div class="icon">
                                <img src="<?php echo PYS_FREE_URL . '/dist/images/info.svg'; ?>" alt="info">
                            </div>

                            <h4 class="card-title primary_heading">WooCommerce Product Catalog Feeds</h4>

                            <p class="card-text">Generate auto-updating WooCommerce XML feeds for Meta Product
                                Catalogs, Google Merchant, Google Ads (custom type), Pinterest Catalogs, and TikTok
                                Catalogs.
                            </p>

                            <div>
                                <a href="https://www.pixelyoursite.com/product-catalog-facebook?utm_source=pro&utm_medium=plugin&utm_campaign=right-column-pro"
                                   target="_blank"
                                   class="link link-extra-small">Click for details</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( !isEddProductsFeedProActive() ) : ?>
                        <div class="item-wrap">
                            <div class="icon">
                                <img src="<?php echo PYS_FREE_URL . '/dist/images/info.svg'; ?>" alt="info">
                            </div>

                            <h4 class="card-title primary_heading">Easy Digital Downloads Product Catalog Feeds</h4>

                            <p class="card-text">Generate auto-updating EDD XML feeds for Facebook Product Catalog.
                            </p>

                            <div>
                                <a href="https://www.pixelyoursite.com/easy-digital-downloads-product-catalog?utm_source=pro&utm_medium=plugin&utm_campaign=right-column-pro"
                                   target="_blank"
                                   class="link link-extra-small">Click for details</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( !isSuperPackActive() ) : ?>
                        <div class="item-wrap">
                            <div class="icon">
                                <img src="<?php echo PYS_FREE_URL . '/dist/images/info.svg'; ?>" alt="info">
                            </div>

                            <h4 class="card-title primary_heading">PixelYourSite Super Pack</h4>

                            <p class="card-text">Add extra features with this special add-on: multi-pixel support,
                                remove pixels from pages, dynamic values for parameters, WooCommerce custom Thank
                                You pages.
                            </p>

                            <div>
                                <a href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/the-super-pack?utm_source=pro&utm_medium=plugin&utm_campaign=right-column-pro"
                                   target="_blank"
                                   class="link link-extra-small">Click for details</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( !isPixelCogActive() ) : ?>
                        <div class="item-wrap">
                            <div class="icon">
                                <img src="<?php echo PYS_FREE_URL . '/dist/images/info.svg'; ?>" alt="info">
                            </div>

                            <h4 class="card-title primary_heading">WooCommerce Cost of Goods</h4>

                            <p class="card-text">Add the cost of your products, calculate profit for each order,
                                track the profit with PixelYourSite WooCommerce first-party reports. Export cost and
                                profit for ChatGPT.
                            </p>

                            <div>
                                <a href="https://www.pixelyoursite.com/plugins/woocommerce-cost-of-goods?utm_source=free&utm_medium=plugin&utm_campaign=right-column-free"
                                   target="_blank"
                                   class="link link-extra-small">Click for details</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- @todo: +7.1.0+ add export settings button and feature -->

                </div>
            </div>

        </form>
    </div>

    <?php include_once PYS_FREE_VIEW_PATH . '/UI/button-save.php'; ?>

</div>
