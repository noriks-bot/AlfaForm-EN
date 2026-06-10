<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/** @var PYS $this */

include_once "html-popovers.php";

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

    switch ( getCurrentAdminPage() ) {
        case 'pixelyoursite_report':
            $title = 'System Report';
            break;
        case 'pixelyoursite_utm':
            $title = 'UTM Builder';
            break;
        case 'pixelyoursite_licenses':
            $title = 'Licenses';
            break;
        case 'pixelyoursite_settings':
            $title = 'Global Settings';
            break;
        case 'pixelyoursite_queue_settings':
            $title = 'Queue System PRO';
            break;
        default:
            $title = 'Welcome to PixelYourSite Pro';
    }
    ?>

    <h1 id="pys-title" class="primary_heading"><?php _e( $title, 'pys' ); ?></h1>
    <div class="container">
        <div class="general-row d-flex">
            <div class="general-col">

                <?php
                switch ( getCurrentAdminPage() ) {
                    case 'pixelyoursite_report':
                        include_once "html-report.php";
                        break;
                    case 'pixelyoursite_utm':
                        include_once "html-utm-templates.php";
                        break;
                    case 'pixelyoursite_licenses':
                        PYS()->adminUpdateLicense();

                        /** @var Plugin|Settings $plugin */
                        foreach ( PYS()->getRegisteredPlugins() as $plugin ) {
                            if ( $plugin->getSlug() !== 'head_footer' ) {
                                $plugin->adminUpdateLicense();
                            }
                        }
                        include_once "html-licenses.php";
                        break;
                    case 'pixelyoursite_settings': ?>
                        <form method="post" enctype="multipart/form-data" id="pys-form">
                            <?php
                                wp_nonce_field( 'pys_save_settings' );
                                include_once "html-main-settings.php";
                            ?>
                        </form>
                        <?php
                        break;
                    case 'pixelyoursite_queue_settings': ?>
                        <form method="post" enctype="multipart/form-data" id="pys-form">
                            <?php
                            wp_nonce_field( 'pys_save_settings' );
                            include_once "html-queue-settings.php";
                            ?>
                        </form>
                        <?php
                        break;
                    default:
                        do_action( 'pys_admin_' . getCurrentAdminPage() );
                }

                ?>

            </div>
        </div>
    </div>

    <?php
        switch ( getCurrentAdminPage() ) {
            case 'pixelyoursite_report':
                include_once PYS_FREE_VIEW_PATH . '/UI/button-download-report.php';
                break;
            case 'pixelyoursite_settings':
                include_once PYS_FREE_VIEW_PATH . '/UI/button-save.php';
                break;
            case 'pixelyoursite_queue_settings':
                include_once PYS_FREE_VIEW_PATH . '/UI/button-save.php';
                break;
        }
    ?>
</div>

