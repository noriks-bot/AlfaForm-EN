<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>
<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

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
    <h1 id="pys-title" class="primary_heading"><?php _e( 'WooCommerce Reports', 'pys' ); ?></h1>
    <div class="container pys_stat">
        <div class="general-row d-flex">
            <div class="general-col">
                <div class="cards-wrapper cards-wrapper-style2 gap-24 statistic-wrapper">
                    <!-- WooCommerce Reports -->
                    <div class="card card-style6 card-static">
                        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                            <h4 class="secondary_heading_type2">
                                <?php
                                _e( 'WooCommerce Reports (beta)', 'pys' );
                                ?>
                            </h4>
                            <?php renderProBadge(); ?>
                        </div>
                        <div class="card-body">
                            <div class="gap-24 text-center">
                                <p >Find out what ads generate your WooCommerce orders using UTMs, discover your traffic sources and landing pages.
                                    Visualize your data inside the plugin, or download it as CSV. </p>
                                <div class="d-flex align-items-center justify-content-center gap-16">
                                    <h3 class="text-center">Get detailed info about products sold by each campaign, ad set, or ad</h3>
                                    <a href="https://www.pixelyoursite.com/woocommerce-first-party-reports?utm_source=free-plugin-reports-page-woo&utm_medium=free-plugin-reports-page-woo&utm_campaign=free-plugin-reports-page-woo&utm_content=free-plugin-reports-page-woo&utm_term=free-plugin-reports-page-woo"
                                       target="_blank" class="btn btn-block btn-sm btn-save orange_button">Click to find more</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-16">
                                    <h3 class="text-center">Analyse your WooCommerce data with ChatGPT</h3>
                                    <a href="https://www.pixelyoursite.com/pixelyoursite-and-chatgpt?utm_source=free-plugin-reports-page-woo&utm_medium=free-plugin-reports-page-woo&utm_campaign=free-plugin-reports-page-woo&utm_content=free-plugin-reports-page-woo&utm_term=free-plugin-reports-page-woo"
                                       target="_blank" class="btn btn-block btn-sm btn-save orange_button">Click to find more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>