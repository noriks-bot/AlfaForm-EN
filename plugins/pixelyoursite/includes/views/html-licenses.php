<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<form method="post" enctype="multipart/form-data">
    <div class="cards-wrapper cards-wrapper-style2 gap-24 licenses-wrapper">
        <?php wp_nonce_field( 'pys_save_settings' ); ?>
        <?php foreach ( PYS()->getRegisteredPlugins() as $plugin ) : /** @var Plugin|Settings $plugin */ ?>

            <?php
            if ( $plugin->getSlug() == 'head_footer' ) { continue; }
            $license_status = $plugin->getOption( 'license_status' );
            $input_name = "pys[{$plugin->getSlug()}][license_action]";
            ?>

            <div class="card card-style3 card-static">
                <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <?php if (method_exists($plugin, 'getPluginIcon')) : ?>
                            <img class="logo-plugin" alt="<?php echo $plugin->getSlug();?>" src="<?php echo $plugin->getPluginIcon();?>"/>
                        <?php endif; ?>
                        <h4 class="secondary_heading_type2"><?php esc_html_e( $plugin->getPluginName() ); ?></h4>
                    </div>
                    <div class="head-button-block">
                        <?php if( $license_status == 'valid' ||  $license_status == 'expired') : ?>
                            <button class="btn btn-block btn-sm btn-danger" name="<?php echo esc_attr( $input_name ); ?>"
                                    value="deactivate">Deactivate License</button>
                        <?php endif; ?>
                        <img alt="loading" class="icon-button icon-load" src="<?php echo PYS_FREE_URL; ?>/dist/images/icon-load.svg"/>
                    </div>
                </div>
                <div class="card-body">
                    <?php renderLicenseControls( $plugin, $license_status ); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</form>