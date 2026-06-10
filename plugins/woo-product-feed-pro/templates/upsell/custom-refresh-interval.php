<?php
// phpcs:disable WordPress.Security.NonceVerification
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Helpers\Helper;
?>
<tr id="custom_refresh_interval_upsell" style="display: none;">
    <td></td>
    <td>
        <div class="adt-upsell-notice">
            <div class="adt-upsell-notice-content">
                <span class="title"><?php esc_html_e( 'Did you know?', 'woo-product-feed-pro' ); ?></span>
                <span class="text"><?php esc_html_e( 'You can set custom refresh intervals and specific times for your feeds.', 'woo-product-feed-pro' ); ?></span>
            </div>
            <a class="adt-upsell-notice-button button" href="<?php echo esc_url( Helper::get_utm_url( 'pricing', 'pfp', 'upsell', 'customrefreshlearnmore' ) ); ?>" rel="norefer noopener" target="_blank">
                <?php esc_html_e( 'Learn More', 'woo-product-feed-pro' ); ?> ⟶
            </a>
        </div>
        <div class="adt-custom-refresh-interval-container">
            <div class="adt-custom-refresh-interval-options-group adt-custom-refresh-interval-options-group-frequency">
                <label for="custom_refresh_interval_schedule"><?php esc_html_e( 'Frequency', 'woo-product-feed-pro' ); ?></label>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="radio"
                        class="custom_refresh_interval_schedule"
                        name="custom_refresh_interval_schedule"
                        value="hourly"
                        checked
                        disabled
                    ><?php esc_html_e( 'Hourly', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="radio"
                        class="custom_refresh_interval_schedule"
                        name="custom_refresh_interval_schedule"
                        value="daily"
                        disabled
                    ><?php esc_html_e( 'Daily', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="radio"
                        class="custom_refresh_interval_schedule"
                        name="custom_refresh_interval_schedule"
                        value="twicedaily"
                        disabled
                    ><?php esc_html_e( 'Twice Daily', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="radio"
                        class="custom_refresh_interval_schedule"
                        name="custom_refresh_interval_schedule"
                        value="weekly"
                        disabled
                    ><?php esc_html_e( 'Weekly', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="radio"
                        class="custom_refresh_interval_schedule"
                        name="custom_refresh_interval_schedule"
                        value="monthly"
                        disabled
                    ><?php esc_html_e( 'Monthly', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="radio"
                        class="custom_refresh_interval_schedule"
                        name="custom_refresh_interval_schedule"
                        value="yearly"
                        disabled
                    ><?php esc_html_e( 'Yearly', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <span>
                        <input
                            type="radio"
                            class="custom_refresh_interval_schedule"
                            name="custom_refresh_interval_schedule"
                            value="hours"
                            disabled
                        ><?php esc_html_e( 'Every', 'woo-product-feed-pro' ); ?>
                    </span>
                    <input
                        type="number"
                        id="custom_refresh_interval_schedule_hours"
                        class="text sized custom_refresh_interval_schedule_hours"
                        name="custom_refresh_interval_schedule_hours"
                        size="2"
                        maxlength="2"
                        min="1"
                        max="24"
                        disabled
                    >
                    <span><?php esc_html_e( 'hours', 'woo-product-feed-pro' ); ?></span>
                </div>
            </div>
            <div class="adt-custom-refresh-interval-options-group adt-custom-refresh-interval-options-group-days">
                <label for="custom_refresh_interval_days"><?php esc_html_e( 'Days', 'woo-product-feed-pro' ); ?></label>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="checkbox"
                        class="custom_refresh_interval_days"
                        name="custom_refresh_interval_days[]"
                        value="1"
                        checked
                        disabled
                    >
                    <?php esc_html_e( 'Monday', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="checkbox"
                        class="custom_refresh_interval_days"
                        name="custom_refresh_interval_days[]"
                        value="2"
                        checked
                        disabled
                    >
                    <?php esc_html_e( 'Tuesday', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="checkbox"
                        class="custom_refresh_interval_days"
                        name="custom_refresh_interval_days[]"
                        value="3"
                        checked
                        disabled
                    >
                    <?php esc_html_e( 'Wednesday', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="checkbox"
                        class="custom_refresh_interval_days"
                        name="custom_refresh_interval_days[]"
                        value="4"
                        checked
                        disabled
                    >
                    <?php esc_html_e( 'Thursday', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="checkbox"
                        class="custom_refresh_interval_days"
                        name="custom_refresh_interval_days[]"
                        value="5"
                        checked
                        disabled
                    >
                    <?php esc_html_e( 'Friday', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="checkbox"
                        class="custom_refresh_interval_days"
                        name="custom_refresh_interval_days[]"
                        value="6"
                        checked
                        disabled
                    >
                    <?php esc_html_e( 'Saturday', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="checkbox"
                        class="custom_refresh_interval_days"
                        name="custom_refresh_interval_days[]"
                        value="7"
                        checked
                        disabled
                    >
                    <?php esc_html_e( 'Sunday', 'woo-product-feed-pro' ); ?>
                </div>
            </div>
            <div class="adt-custom-refresh-interval-options-group">
                <label for="custom_refresh_interval_commence"><?php esc_html_e( 'Commence', 'woo-product-feed-pro' ); ?></label>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <input
                        type="radio"
                        class="custom_refresh_interval_commence"
                        name="custom_refresh_interval_commence"
                        value="now"
                        checked
                        disabled
                    >
                    <?php esc_html_e( 'From now', 'woo-product-feed-pro' ); ?>
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <span>
                        <input
                            type="radio"
                            class="custom_refresh_interval_commence"
                            name="custom_refresh_interval_commence"
                            value="date"
                            disabled
                        >
                    </span>
                    <input
                        type="text"
                        id="custom_refresh_interval_commence_date"
                        class="sized custom_refresh_interval_commence_date"
                        name="custom_refresh_interval_commence_date"
                        size="20"
                        maxlength="20"
                        autocomplete="off"
                        disabled
                    >
                </div>
                <div class="adt-custom-refresh-interval-options-group-item">
                    <span>
                        <?php esc_html_e( 'Local time is:', 'woo-product-feed-pro' ); ?>
                        <code><?php echo esc_html( wp_date( 'Y-m-d H:i:s' ) ); ?></code>
                    </span>
                </div>
            </div>
        </div>
    </td>
</tr>
