<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<style type="text/css">
    .pfp-failed-dependency-notice p {
        max-width: 100%;
    }

    .pfp-failed-dependency-notice p:after {
        content: '';
        display: table;
        clear: both;
    }

    .pfp-failed-dependency-notice .heading {
        display: flex;
        align-items: center;
    }

    .pfp-failed-dependency-notice .heading img {
        float: left;
        margin-right: 15px;
        max-width: 120px;
        width: 100%;
        height: auto;
    }

    .pfp-failed-dependency-notice .heading span {
    display: inline-flex;
        margin-top: 6px;
        font-size: 16px;
        font-weight: bold;
        text-transform: capitalize;
        color: #ce1508;
        letter-spacing: -0.2px;
        font-family: "Lato", -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    }

    .pfp-failed-dependency-notice .heading span:before {
        content: "\f534";
        font-family: dashicons;
        margin-right: 4px;
    }

    .pfp-failed-dependency-notice .action-wrap {
        margin-bottom: 15px;
    }

    .pfp-failed-dependency-notice .action-wrap .action-button {
        display: inline-block;
        padding: 8px 23px;
        margin-right: 10px;
        background: #C6CD2E;
        font-weight: bold;
        font-size: 16px;
        text-decoration: none;
        color: #000000;
    }

    .pfp-failed-dependency-notice .action-wrap .action-button.disabled {
        opacity: 0.7 !important;
        pointer-events: none;
    }

    .pfp-failed-dependency-notice .action-wrap .action-button.gray {
        background: #cccccc;
    }

    .pfp-failed-dependency-notice .action-wrap .action-button:hover {
        opacity: 0.8;
    }

    .pfp-failed-dependency-notice .action-wrap span {
        color: #035E6B;
    }
</style>
<div class="notice notice-error pfp-failed-dependency-notice">
    <p class="heading">
        <img src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'logo.svg' ); ?>" alt="Product Feed Pro for WooCommerce" />
        <span><?php esc_html_e( 'Action required', 'woo-product-feed-pro' ); ?></span>
    </p>
    <?php echo wp_kses_post( $message ); ?>
    <?php echo wp_kses_post( $failed_dependencies ); ?>
</div>
