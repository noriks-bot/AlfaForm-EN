<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * PFP Notice bar template
 *
 * @since 13.3.4
 */
?>
<style>#screen-meta, #contextual-help-link-wrap, #screen-options-link-wrap { top: 5px !important; }</style>
<div id="pfp-notice-bar" class="pfp-dismiss-container top-lite">
    <span class="pfp-notice-bar-message">
        <?php printf( wp_kses_post( $message ), esc_url( $upgrade_link ) ); ?>
    </span>
</div>
