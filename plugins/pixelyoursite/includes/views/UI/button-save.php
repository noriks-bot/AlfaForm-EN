<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$added_classes = 'save-settings';
if (isset($_GET['tab']) && $_GET['tab'] === 'events' && isset($_GET['action']) && $_GET['action'] === 'edit') :
    $added_classes .= ' edit-event';
endif;
?>

<div class="<?php echo esc_attr($added_classes); ?>">
    <div class="bottom-upgrade">
        <a class="bottom-upgrade-link" target="_blank" href="https://www.pixelyoursite.com/?utm_source=pys-free-plugin&utm_medium=pro-badge&utm_campaign=pro-feature"><?php _e('Upgrade to PRO version', 'pys');?></a>
    </div>
    <div class="video-link">
            <a href="https://wordpress.org/support/plugin/pixelyoursite/reviews/?filter=5#new-post" target="_blank" class="link">
                Click here to give us a 5 stars review.
            </a>
            <span class="font-semibold">A huge thanks from the PixelYourSite team! </span>
    </div>

    <div class="save-settings-actions">
		<?php
		if ( isset( $_GET[ 'tab' ] ) && $_GET[ 'tab' ] === 'events' && isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] === 'edit' ) : ?>
            <a href="<?php echo buildAdminUrl( 'pixelyoursite', 'events' ); ?>" class="back-button">Back</a>
		<?php endif; ?>
        <?php
        if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] === 'pixelyoursite_settings') : ?>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field( 'pys_save_settings' );?>
            <input type="hidden" name="pys[reset_settings]" value="1">
            <button
                    type="submit"
                    class="back-button restore-settings"
                    data-title="<?php _e('Reset All Settings To Defaults', 'pys'); ?>"
                    data-content="<?php _e('If you continue, all your custom settings will be lost and the plugin will go back to the default configuration. If you use any add-ons, like the Pinterest add-on or the Super Pack, their settings will be affected too. Custom events and scripts added with the Head & Footer option won\'t be affected.', 'pys'); ?>"
                    data-button-yes="<?php _e('Yes, reset settings', 'pys'); ?>"
                    data-button-no="<?php _e('No, go back', 'pys'); ?>"
            >

                <?php _e('Restore settings', 'pys'); ?>
            </button>
        </form>
        <?php endif; ?>

        <button id="pys-save-settings">Save Changes</button>
    </div>
</div>