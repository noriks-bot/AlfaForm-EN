<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div id="pfp-acfw-marketing-page" class="pfp-page pfp-marketing-page wrap nosubsub">
    <!-- Close Button -->
    <a href="#" class="pfp-marketing-page-close" data-plugin_key="acfw">
        <span class="dashicons dashicons-no-alt"></span>
    </a>
    <div class="container">
        <div class="row">
            <div class="col text-center section-hero">
                <img class="logo img-responsive" src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'acfw-logo.png' ); ?>" alt="Advanced Coupons for WooCommerce" class="pfp-acfw-logo">
                <h1 class="hero-title">
                    <?php
                    echo wp_kses_post(
                        sprintf(
                            /* translators: %1$s: br and span tag, %2$s: span tag */
                            __( 'Get Better Results With %1$s Better WooCommerce Coupons %2$s', 'woo-product-feed-pro' ),
                            '<br/><span class="text-color-primary">',
                            '</span>'
                        )
                    );
                    ?>
                </h1>
                <div class="hero-image">
                    <img class="img-responsive" src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'acfw-marketing-hero.png' ); ?>" alt="Advanced Coupons for WooCommerce">
                </div>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col text-center section-features">
                <ul class="features">
                    <li>
                        <div class="feature-icon">
                            <img src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'acfw-feature-brain.png' ); ?>" alt="Advanced Coupons for WooCommerce">
                        </div>
                        <div class="feature-text">
                            <?php
                            echo wp_kses_post(
                                sprintf(
                                    // translators: %s: line break.
                                    __( 'Advanced Coupon%sCapabilities', 'woo-product-feed-pro' ),
                                    '<br/>'
                                )
                            );
                            ?>
                            
                        </div>
                    </li>
                    <li>
                        <div class="feature-icon">
                            <img src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'acfw-feature-credit-card.png' ); ?>" alt="Advanced Coupons for WooCommerce">
                        </div>
                        <div class="feature-text">
                            <?php
                            echo wp_kses_post(
                                sprintf(
                                    // translators: %s: line break.
                                    __( 'Store Credit%sSystem', 'woo-product-feed-pro' ),
                                    '<br/>'
                                )
                            );
                            ?>
                            
                        </div>
                    </li>
                    <li>
                        <div class="feature-icon">
                            <img src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'acfw-feature-gem-stone.png' ); ?>" alt="Advanced Coupons for WooCommerce">
                        </div>
                        <div class="feature-text">
                            <?php
                            echo wp_kses_post(
                                sprintf(
                                    // translators: %s: line break.
                                    __( 'Loyalty%sProgram', 'woo-product-feed-pro' ),
                                    '<br/>'
                                )
                            );
                            ?>
                            
                        </div>
                    </li>
                    <li>
                        <div class="feature-icon">
                            <img src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'acfw-feature-shopping-bags.png' ); ?>" alt="Advanced Coupons for WooCommerce">
                        </div>
                        <div class="feature-text">
                            <?php
                            echo wp_kses_post(
                                sprintf(
                                    // translators: %s: line break.
                                    __( 'BOGO%sPromotions', 'woo-product-feed-pro' ),
                                    '<br/>'
                                )
                            );
                            ?>
                            
                        </div>
                    </li>
                    <li>
                        <div class="feature-icon">
                            <img src="<?php echo esc_url( ADT_PFP_IMAGES_URL . 'acfw-feature-wrapped-gift.png' ); ?>" alt="Advanced Coupons for WooCommerce">
                        </div>
                        <div class="feature-text">
                            <?php
                            echo wp_kses_post(
                                sprintf(
                                    // translators: %s: line break.
                                    __( 'Versatile Gift%sCard Solutions', 'woo-product-feed-pro' ),
                                    '<br/>'
                                ),
                            );
                            ?>
                           
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col text-center section-description">
                <p>
                    <?php esc_html_e( 'Advanced Coupons is the best WooCommerce coupon plugin because it adds more coupon discount types, store credit, and all the advanced options you wish WooCommerce coupons could already do.', 'woo-product-feed-pro' ); ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col section-plugin-action">
                <ul class="card-plugin-action">
                    <li class="card <?php echo 1 !== $step ? 'disabled' : ''; ?>">
                        <div class="card-title">
                            <span class="card-title--step text-color-primary"><?php esc_html_e( 'Step 1', 'woo-product-feed-pro' ); ?></span>
                            <h2><?php esc_html_e( 'Enhance your Coupon Capabilities', 'woo-product-feed-pro' ); ?></h2>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li><?php esc_html_e( 'Implement BOGO deals and smart cart conditions to create offers that adjust to customer behaviors and cart contents, ensuring timely and relevant discounts.', 'woo-product-feed-pro' ); ?></li>
                                <li><?php esc_html_e( 'Boost customer retention with a loyalty program and store credits to encourage frequent visits and enhance long-term profitability.', 'woo-product-feed-pro' ); ?></li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo esc_url( wp_nonce_url( 'update.php?action=install-plugin&plugin=advanced-coupons-for-woocommerce-free', 'install-plugin_advanced-coupons-for-woocommerce-free' ) ); ?>" class="button button-primary button-install">
                                <?php esc_html_e( 'Get Advanced Coupons', 'woo-product-feed-pro' ); ?>
                            </a>
                        </div>
                    </li>
                    <li class="card <?php echo 2 !== $step ? 'disabled' : ''; ?>">
                        <div class="card-title">
                            <span class="card-title--step text-color-primary"><?php esc_html_e( 'Step 2', 'woo-product-feed-pro' ); ?></span>
                            <h2><?php esc_html_e( 'Configure your Coupon Features', 'woo-product-feed-pro' ); ?></h2>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li><?php esc_html_e( 'Create targeted promotions using coupon templates to help you streamline your promotions and grow your profits.', 'woo-product-feed-pro' ); ?></li>
                                <li><?php esc_html_e( 'Optimize coupon management by categorizing, restricting roles, and enabling URL activation to boost engagement and loyalty.', 'woo-product-feed-pro' ); ?></li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo esc_url( wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin_data['basename'] . '&amp;plugin_status=all&amp;s', 'activate-plugin_' . $plugin_data['basename'] ) ); ?>" class="button button-primary button-activate">
                                <?php esc_html_e( 'Activate Plugin', 'woo-product-feed-pro' ); ?>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
