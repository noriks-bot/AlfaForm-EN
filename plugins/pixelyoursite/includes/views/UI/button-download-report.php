<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<div class="save-settings">
    <div class="video-link">
        <?php if ( !empty( PYS_FREE_VIDEO_URL ) && !empty( PYS_FREE_VIDEO_TITLE ) ) : ?>
            <span class="font-semibold">Recommended: </span>
            <a href="<?php echo esc_url( PYS_FREE_VIDEO_URL ); ?>" target="_blank" class="link link-underline">
                <?php echo esc_html( PYS_FREE_VIDEO_TITLE ); ?>
            </a>
        <?php endif; ?>
    </div>
    <div class="save-settings-actions">
        <form method="post">
            <?php wp_nonce_field( 'pys_download_system_report_nonce' ); ?>
            <input type="hidden" name="pys_action" value="download_system_report"/>
            <button type="submit" id="pys-download-report">Download System Report</button>
        </form>
    </div>
</div>