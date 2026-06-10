<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div
    class="adt-pfp-admin-notice notice notice-<?php echo esc_attr( "$type $type" ); ?> <?php echo $is_dismissible ? 'is-dismissible' : ''; ?> <?php echo esc_attr( $args['class'] ?? '' ); ?>"
    id="<?php echo esc_attr( $notice_id ); ?>"
    data-nonce="<?php echo isset( $args['nonce'] ) ? esc_attr( $args['nonce'] ) : ''; ?>"
    <?php
    if ( ! empty( $args['data'] ) ) :
        foreach ( $args['data'] as $key => $value ) :
            ?>
            data-<?php echo esc_attr( $key ); ?>="<?php echo esc_attr( $value ); ?>"
            <?php
        endforeach;
    endif;
    ?>
>
    <?php if ( ! empty( $args['show_navigation'] ) ) : ?>
        <div class="adt-notice-navigation">
            <button type="button" class="adt-notice-nav-prev" aria-label="<?php esc_attr_e( 'Previous notification', 'woo-product-feed-pro' ); ?>">
                <span class="dashicons dashicons-arrow-left-alt2"></span>
            </button>
            <button type="button" class="adt-notice-nav-next" aria-label="<?php esc_attr_e( 'Next notification', 'woo-product-feed-pro' ); ?>">
                <span class="dashicons dashicons-arrow-right-alt2"></span>
            </button>
        </div>
    <?php endif; ?>
    <?php if ( ! empty( $args['image_url'] ) ) : ?>
        <div class="notice-image">
            <img src="<?php echo esc_url( $args['image_url'] ); ?>" />
        </div>
    <?php endif; ?>
    <div class="notice-content">
    <?php if ( $is_html ) : ?>
        <?php if ( is_array( $message ) ) : ?>
            <?php foreach ( $message as $item ) : ?>
                <?php echo wp_kses( $item, 'post' ); ?>
            <?php endforeach; ?>
        <?php else : ?>
            <?php echo wp_kses( $message, 'post' ); ?>
        <?php endif; ?>
    <?php else : ?>
        <?php if ( is_array( $message ) ) : ?>
            <?php foreach ( $message as $item ) : ?>
            <p><?php echo esc_html( $item ); ?></p>
            <?php endforeach; ?>
        <?php else : ?>
        <p><?php echo esc_html( $message ); ?></p>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ( ! empty( $args['actions'] ) ) : ?>
        <div class="notice-actions">
            <?php foreach ( $args['actions'] as $notice_action ) : ?>
                <a
                    href="<?php echo esc_url( $notice_action['link'] ?? '#' ); ?>"
                    class="button button-<?php echo esc_attr( $notice_action['type'] ); ?> <?php echo esc_attr( $notice_action['class'] ?? '' ); ?>"
                    <?php echo isset( $notice_action['is_external'] ) && $notice_action['is_external'] ? 'target="_blank"' : ''; ?>
                    <?php if ( ! empty( $notice_action['data'] ) ) : ?>
                        <?php foreach ( $notice_action['data'] as $key => $value ) : ?>
                            data-<?php echo esc_attr( $key ); ?>="<?php echo esc_attr( $value ); ?>"
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ( ! empty( $notice_action['nonce'] ) ) : ?>
                        data-nonce="<?php echo esc_attr( $notice_action['nonce'] ); ?>"
                    <?php endif; ?>
                    >
                    <?php echo esc_html( $notice_action['text'] ); ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </div>
</div>
