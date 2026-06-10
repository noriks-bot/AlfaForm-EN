<?php
/**
 * Template for notification drawer.
 *
 * @package AdTribes\PFP\Templates\Notices
 * @since 13.4.5
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Classes\Notices;

$notices_instance = Notices::instance();
$notifications    = $notices_instance->get_all_admin_notices();
$notifications    = $notices_instance->sort_notices_by_timestamp( $notifications );
$unread_count     = $notices_instance->get_unread_count();
?>

<div id="adt-notification-drawer" class="adt-notification-drawer adt-tw-wrapper adt-tw-pointer-events-none" style="opacity: 0;">
    <!-- Overlay -->
    <div class="adt-notification-drawer__overlay adt-tw-fixed adt-tw-inset-0 adt-tw-bg-black adt-tw-bg-opacity-30 adt-tw-z-40 adt-tw-transition-opacity adt-tw-opacity-0 adt-tw-pointer-events-none"></div>

    <!-- Panel -->
    <div class="adt-notification-drawer__panel adt-tw-fixed adt-tw-top-0 adt-tw-right-0 adt-tw-h-full adt-tw-w-full sm:adt-tw-w-96 adt-tw-bg-white adt-tw-shadow-2xl adt-tw-z-50 adt-tw-transform adt-tw-transition-transform adt-tw-duration-300 adt-tw-ease-in-out adt-tw-translate-x-full" style="transform: translateX(100%);">
        <div class="adt-tw-flex adt-tw-flex-col adt-tw-h-full">
            <!-- Header -->
            <div class="adt-notification-drawer__header adt-tw-flex adt-tw-items-center adt-tw-justify-between adt-tw-p-6 adt-tw-bg-white adt-tw-sticky adt-tw-top-0 adt-tw-z-10">
                <h2 class="adt-tw-text-xl adt-tw-font-bold adt-tw-text-gray-900">
                    <?php esc_html_e( 'Notifications', 'woo-product-feed-pro' ); ?>
                </h2>
                <?php if ( $unread_count > 0 ) : ?>
                    <button type="button" class="adt-notification-drawer__mark-all-read adt-tw-text-base adt-tw-font-semibold adt-tw-transition-colors hover:adt-tw-opacity-80 adt-tw-bg-transparent adt-tw-border-0 adt-tw-cursor-pointer" style="color: #e63d78;">
                        <?php esc_html_e( 'Mark all as read', 'woo-product-feed-pro' ); ?>
                    </button>
                <?php endif; ?>
            </div>

            <!-- Content -->
            <div class="adt-notification-drawer__content adt-tw-flex-1 adt-tw-overflow-y-auto adt-tw-bg-gray-50">
                <!-- Empty State (always present, hidden when there are notifications) -->
                <div class="adt-notification-drawer__empty adt-tw-flex adt-tw-flex-col adt-tw-items-center adt-tw-justify-center adt-tw-h-full adt-tw-px-6 adt-tw-text-center" <?php echo ! empty( $notifications ) ? 'style="display: none;"' : ''; ?>>
                    <div class="adt-tw-relative adt-tw-mb-6">
                        <div class="adt-tw-w-20 adt-tw-h-20 adt-tw-rounded-full adt-tw-flex adt-tw-items-center adt-tw-justify-center" style="background-color: rgba(230, 61, 120, 0.1);">
                            <span class="adt-tw-icon-[lucide--circle-check-big]" style="color: #e63d78; font-size: 40px; width: 40px; height: 40px;"></span>
                        </div>
                    </div>
                    <h3 class="adt-tw-text-xl adt-tw-font-semibold adt-tw-text-gray-800 adt-tw-mb-2">
                        <?php esc_html_e( "You're all caught up!", 'woo-product-feed-pro' ); ?>
                    </h3>
                    <p class="adt-tw-text-gray-500 adt-tw-text-sm">
                        <?php esc_html_e( 'No new notifications at the moment', 'woo-product-feed-pro' ); ?>
                    </p>
                </div>

                <!-- Notifications List -->
                <div class="adt-notification-drawer__list" <?php echo empty( $notifications ) ? 'style="display: none;"' : ''; ?>>
                    <?php foreach ( $notifications as $notice_key => $notice_data ) : ?>
                        <?php
                        // Extract title and message from notice data.
                        $notice_title    = '';
                        $message_content = '';

                        if ( isset( $notice_data['message'] ) ) {
                            $full_message = $notice_data['message'];

                            // If message is an array, join it.
                            if ( is_array( $full_message ) ) {
                                $full_message = implode( '', $full_message );
                            }

                            // Extract h1, h2, or h3 as title.
                            if ( preg_match( '/<h[123][^>]*>(.*?)<\/h[123]>/is', $full_message, $matches ) ) {
                                $notice_title    = wp_strip_all_tags( $matches[1] );
                                $message_content = preg_replace( '/<h[123][^>]*>.*?<\/h[123]>/is', '', $full_message );
                            } else {
                                $message_content = $full_message;
                            }
                        }
                        ?>
                        <!-- Notification Item -->
                        <div class="adt-notification-drawer__item adt-tw-px-6 adt-tw-py-5 adt-tw-bg-white adt-tw-border-b adt-tw-border-gray-100 hover:adt-tw-bg-gray-50 adt-tw-transition-colors" data-notice-id="<?php echo esc_attr( $notice_key ); ?>" data-nonce="<?php echo esc_attr( $notice_data['nonce'] ?? '' ); ?>">
                            <div class="adt-tw-flex adt-tw-gap-4">
                                <!-- Icon -->
                                <div class="adt-tw-w-12 adt-tw-h-12 adt-tw-rounded-full adt-tw-flex adt-tw-items-center adt-tw-justify-center adt-tw-flex-shrink-0" style="background-color: rgba(230, 61, 120, 0.15); color: #e63d78;">
                                    <?php if ( isset( $notice_data['image_url'] ) && ! empty( $notice_data['image_url'] ) ) : ?>
                                        <img src="<?php echo esc_url( $notice_data['image_url'] ); ?>" alt="" class="adt-tw-w-full adt-tw-h-full adt-tw-object-cover adt-tw-rounded-full">
                                    <?php else : ?>
                                        <span class="adt-tw-icon-[lucide--<?php echo esc_attr( $notice_data['icon'] ?? 'bell' ); ?>] adt-tw-w-6 adt-tw-h-6"></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Content -->
                                <div class="adt-tw-flex-1 adt-tw-min-w-0">
                                    <!-- Title and Timestamp -->
                                    <div class="adt-tw-flex adt-tw-items-center adt-tw-justify-between adt-tw-gap-3 adt-tw-mb-2">
                                        <h3 class="adt-tw-font-semibold adt-tw-text-gray-900 adt-tw-text-base adt-tw-m-0">
                                            <?php echo esc_html( $notice_title ); ?>
                                        </h3>
                                        <span class="adt-tw-text-sm adt-tw-text-gray-400 adt-tw-whitespace-nowrap adt-tw-self-start adt-tw-leading-[25px]">
                                            <?php echo esc_html( $notice_data['timestamp'] ?? __( 'Just now', 'woo-product-feed-pro' ) ); ?>
                                        </span>
                                    </div>

                                    <!-- Message -->
                                    <?php if ( ! empty( $message_content ) ) : ?>
                                        <p class="adt-tw-text-sm adt-tw-text-gray-600 adt-tw-mb-4 adt-tw-leading-relaxed adt-tw-mt-0">
                                            <?php echo wp_kses_post( $message_content ); ?>
                                        </p>
                                    <?php endif; ?>

                                    <!-- Actions -->
                                    <div class="adt-tw-flex adt-tw-flex-wrap adt-tw-gap-3">
                                        <?php $dismiss_text = __( 'Dismiss', 'woo-product-feed-pro' ); ?>
                                        <?php if ( isset( $notice_data['actions'] ) && ! empty( $notice_data['actions'] ) ) : ?>
                                            <?php foreach ( $notice_data['actions'] as $notice_action ) : ?>
                                                <?php
                                                if ( isset( $notice_action['data']['response'] ) && 'dismissed' === $notice_action['data']['response'] ) {
                                                    $dismiss_text = $notice_action['text'] ?? __( 'Dismiss', 'woo-product-feed-pro' );
                                                    continue;
                                                }

                                                $action_link  = isset( $notice_action['link'] ) ? $notice_action['link'] : '#';
                                                $is_primary   = isset( $notice_action['type'] ) && 'primary' === $notice_action['type'];
                                                $btn_classes  = 'adt-tw-px-5 adt-tw-py-2 adt-tw-text-sm adt-tw-font-semibold adt-tw-rounded-lg adt-tw-transition';
                                                $btn_classes .= $is_primary ? ' adt-tw-text-white hover:adt-tw-opacity-90' : ' adt-tw-text-gray-700 adt-tw-transition-colors';
                                                $btn_classes .= isset( $notice_action['class'] ) ? ' ' . $notice_action['class'] : '';
                                                $btn_style    = $is_primary ? 'background-color: #e63d78;' : 'background-color: rgba(230, 61, 120, 0.1);';
                                                ?>
                                                <a
                                                    href="<?php echo esc_url( $action_link ); ?>"
                                                    class="<?php echo esc_attr( $btn_classes ); ?>"
                                                    style="<?php echo esc_attr( $btn_style ); ?>"
                                                    <?php echo isset( $notice_action['is_external'] ) && $notice_action['is_external'] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
                                                    <?php if ( isset( $notice_action['data'] ) && ! empty( $notice_action['data'] ) ) : ?>
                                                        <?php foreach ( $notice_action['data'] as $data_key => $data_value ) : ?>
                                                            data-<?php echo esc_attr( $data_key ); ?>="<?php echo esc_attr( $data_value ); ?>"
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    <?php if ( isset( $notice_action['nonce'] ) ) : ?>
                                                        data-nonce="<?php echo esc_attr( $notice_action['nonce'] ); ?>"
                                                    <?php endif; ?>
                                                >
                                                    <?php echo esc_html( $notice_action['text'] ); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                        <button
                                            type="button"
                                            class="adt-notification-drawer__dismiss adt-tw-px-5 adt-tw-py-2 adt-tw-text-gray-700 adt-tw-text-sm adt-tw-font-semibold adt-tw-rounded-lg adt-tw-transition-colors"
                                            data-response="dismissed"
                                            data-notice-id="<?php echo esc_attr( $notice_key ); ?>"
                                            data-nonce="<?php echo esc_attr( $notice_data['nonce'] ?? '' ); ?>"
                                            aria-label="<?php esc_attr_e( 'Dismiss notification', 'woo-product-feed-pro' ); ?>"
                                        >
                                            <?php echo esc_html( $dismiss_text ); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
