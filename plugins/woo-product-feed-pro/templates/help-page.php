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
            <?php esc_html_e( 'Getting Help', 'woo-product-feed-pro' ); ?>
            <p class="adt-tw-text-base adt-tw-mt-2 adt-tw-font-normal">
                <?php esc_html_e( 'We\'re here to help you get the most out of Product Feed Pro for WooCommerce.', 'woo-product-feed-pro' ); ?>
            </p>
        </h1>
        <div id="pfp-about-page" class="pfp-page">
            <div class="row">
                <div class="col">
                    <ul class="card-list">
                        <li class="card">
                            <div class="card-title">
                                <h3><?php esc_html_e( 'Knowledge Base', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'Access our self-service help documentation via the Knowledge Base. You\'ll find answers and solutions for a wide range of well know situations . You\'ll also find a Getting Started guide here for the plugin.', 'woo-product-feed-pro' ); ?></p>
                                <a target="_blank" href="<?php echo esc_url( Helper::get_utm_url( 'support', 'pfp', 'helppage', 'helppageopenkbbutton' ) ); ?>" class="button button-primary button-large"><?php esc_html_e( 'Open Knowledge Base', 'woo-product-feed-pro' ); ?></a>
                            </div>
                        </li> 
                        <li class="card">
                            <div class="card-title">
                                <h3><?php esc_html_e( 'Free Version WordPress.org Help Forums', 'woo-product-feed-pro' ); ?></h3>
                            </div>
                            <div class="card-body xs-text-center">
                                <p class="mt-0"><?php esc_html_e( 'Our support staff regularly check and help our free users at the official plugin WordPress.org help forums. Submit a post there with your question and we\'ll get back to you as soon as possible.', 'woo-product-feed-pro' ); ?></p>
                                <a target="_blank" href="<?php echo esc_url( 'https://wordpress.org/support/plugin/woo-product-feed-pro/' ); ?>" class="button button-primary button-large"><?php esc_html_e( 'Visit WordPress.org Forums', 'woo-product-feed-pro' ); ?></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col xs-text-center">
                    <iframe src="<?php echo esc_url( Helper::get_utm_url( 'in-app-optin', 'pfp', 'helppage', 'helppageinappoptin' ) ); ?>" width="100%" height="500" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
