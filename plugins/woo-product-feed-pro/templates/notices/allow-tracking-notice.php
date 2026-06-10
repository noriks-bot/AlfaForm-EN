<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<style type="text/css">
    .pfp-allow-tracking-notice p {
        max-width: 100%;
    }

    .pfp-allow-tracking-notice p:after {
        content: '';
        display: table;
        clear: both;
    }

    .pfp-allow-tracking-notice .heading {
        display: flex;
        align-items: center;
    }

    .pfp-allow-tracking-notice .heading img {
        float: left;
        margin-right: 15px;
        max-width: 120px;
        width: 100%;
        height: auto;
    }

    .pfp-allow-tracking-notice .heading span {
        display: inline-flex;
        margin-top: 6px;
        font-size: 16px;
        font-weight: bold;
        text-transform: capitalize;
        color: #e63e77;
        letter-spacing: -0.2px;
        font-family: "Lato", -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    }

    .pfp-allow-tracking-notice .heading span:before {
        content: "\f534";
        font-family: dashicons;
        margin-right: 4px;
    }

    .pfp-allow-tracking-notice .action-wrap {
        margin-bottom: 15px;
    }

    .pfp-allow-tracking-notice .action-wrap .action-button {
        display: inline-block;
        padding: 8px 23px;
        margin-right: 10px;
        background: #C6CD2E;
        font-weight: bold;
        font-size: 16px;
        text-decoration: none;
        color: #000000;
    }

    .pfp-allow-tracking-notice .action-wrap .action-button.disabled {
        opacity: 0.7 !important;
        pointer-events: none;
    }

    .pfp-allow-tracking-notice .action-wrap .action-button.gray {
        background: #cccccc;
    }

    .pfp-allow-tracking-notice .action-wrap .action-button:hover {
        opacity: 0.8;
    }

    .pfp-allow-tracking-notice .action-wrap span {
        color: #035E6B;
    }
</style>
<div class="notice notice-info pfp-allow-tracking-notice">
    <p class="heading">
        <img src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'logo.svg' ); ?>" alt="Product Feed Pro for WooCommerce" />
        <span><?php esc_html_e( 'Usage Tracking Persmission', 'woo-product-feed-pro' ); ?></span>
    </p>
    <?php echo wp_kses_post( $message ); ?>
    <p class="action-wrap">
        <button class="button button-primary adt-pfp-allow-tracking-notice-action-button" data-value="1">
            <?php esc_attr_e( 'Allow Tracking', 'woo-product-feed-pro' ); ?>
        </button>
        <button class="button button-default adt-pfp-allow-tracking-notice-action-button" data-value="0">
            <?php esc_attr_e( 'Do Not Allow', 'woo-product-feed-pro' ); ?>
        </button>
    </p>
    <?php
        wp_nonce_field( 'adt_pfp_allow_tracking_nonce', 'adt_pfp_allow_tracking_nonce' );
    ?>
</div>
