<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="<?php echo esc_attr( $notice_class ); ?> adt-pfp-admin-notice notice-<?php echo esc_attr( $notice['type'] ); ?> is-dismissable" data-notice="<?php echo esc_attr( $notice['slug'] ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'adt_pfp_dismiss_notice_' . $notice['slug'] ) ); ?>">

    <div class="heading-container">
        <div class="image-container">
            <img src="<?php echo esc_attr( $notice['logo_img'] ); ?>">
        </div>
        
        <div class="heading">
            <?php if ( $notice['heading'] ) : ?>
                <span><?php echo esc_html( $notice['heading'] ); ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="description-content">
        <?php foreach ( $notice['content'] as $paragraph ) : ?>
            <p><?php echo wp_kses_post( $paragraph ); ?></p>
        <?php endforeach; ?>
    </div>

    <p class="action-wrap">
        <?php foreach ( $notice['actions'] as $notice_action ) : ?>
            <a 
                class="action-button <?php echo esc_attr( $notice_action['key'] ); ?>" 
                href="<?php echo esc_attr( $notice_action['link'] ); ?>" 
                <?php echo isset( $notice_action['is_external'] ) && $notice_action['is_external'] ? 'target="_blank"' : ''; ?>
                <?php echo isset( $notice_action['response'] ) ? sprintf( 'data-response="%s"', esc_attr( $notice_action['response'] ) ) : ''; ?>
                <?php echo isset( $notice_action['loading_text'] ) ? sprintf( 'data-loading-text="%s"', esc_attr( $notice_action['loading_text'] ) ) : ''; ?>
            >
                <?php echo esc_html( $notice_action['text'] ); ?>
            </a>
            <?php if ( isset( $notice_action['extra_html'] ) ) : ?>
                <?php echo wp_kses_post( $notice_action['extra_html'] ); ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if ( $notice['is_dismissable'] && ! ( isset( $notice['hide_action_dismiss'] ) && $notice['hide_action_dismiss'] ) ) : ?>
            <a class="adt-pfp-notice-dismiss" href="javascript:void(0);"><?php esc_html_e( 'Dismiss', 'woo-product-feed-pro' ); ?></a>
        <?php endif; ?>
    </p>

    <?php if ( $notice['is_dismissable'] ) : ?>
        <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice...', 'woo-product-feed-pro' ); ?></span></button>
    <?php endif; ?>
</div>

<?php do_action( 'adt_pfp_after_display_admin_notice_generic', $notice ); ?>
