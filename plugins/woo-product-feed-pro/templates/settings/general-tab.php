<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use AdTribes\PFP\Classes\Admin_Pages\Settings_Page;

$settings_page = Settings_Page::instance();
?>
<table class="woo-product-feed-pro-table woo-product-feed-pro-table--manage-settings" data-pagename="manage_settings">
    <tr>
        <td><strong><?php esc_html_e( 'Plugin setting', 'woo-product-feed-pro' ); ?></strong></td>
        <td><strong><?php esc_html_e( 'Off / On', 'woo-product-feed-pro' ); ?></strong></td>
    </tr>

    <?php
    wp_nonce_field( 'woosea_ajax_nonce' );
    $settings = $settings_page->get_general_settings();
    foreach ( $settings as $setting ) :
    ?>
        <?php if ( isset( $setting['parent_id'] ) ) : ?>
        <tr id="<?php echo esc_attr( $setting['parent_id'] ); ?>" class="group-child <?php echo get_option( $setting['parent_id'] ) !== 'yes' ? 'hidden' : ''; ?>" data-group="<?php echo esc_attr( $setting['parent_id'] ); ?>">
        <?php else : ?>
        <tr id="<?php echo esc_attr( $setting['id'] ); ?>" class="group" data-group="<?php echo esc_attr( $setting['id'] ); ?>">
        <?php endif; ?>
            <?php if ( 'checkbox' === $setting['type'] ) : ?>
                <td>
                    <span><?php echo wp_kses_post( $setting['title'] ); ?></span>
                    <?php if ( isset( $setting['read_more_link'] ) ) : ?>
                        <a href="<?php echo esc_url( $setting['read_more_link'] ); ?>" target="_blank">
                            (<?php esc_html_e( 'Read more about this', 'woo-product-feed-pro' ); ?>)
                        </a>
                    <?php endif; ?>
                </td>
                <td>
                    <label class="woo-product-feed-pro-switch">
                        <input type="checkbox" id="<?php echo esc_attr( $setting['id'] ); ?>" name="<?php echo esc_attr( $setting['id'] ); ?>" class="checkbox-field adt-pfp-general-setting" <?php echo get_option( $setting['id'] ) === 'yes' ? 'checked' : ''; ?>>
                        <div class="woo-product-feed-pro-slider round"></div>
                    </label>
                </td>
            <?php elseif ( 'text' === $setting['type'] ) : ?>
                <td colspan="2">
                    <span><?php echo wp_kses_post( $setting['title'] ); ?></span>&nbsp;
                    <input type="text" class="adt-tw-border-gray-300 adt-tw-rounded-md adt-tw-h-10 adt-tw-p-2 adt-tw-m-0" id="<?php echo esc_attr( $setting['id'] ); ?>" name="<?php echo esc_attr( $setting['id'] ); ?>" value="<?php echo esc_attr( get_option( $setting['id'], '' ) ); ?>">&nbsp;
                    <button type="button" class="adt-pfp-save-setting-button adt-button adt-button-primary adt-button-sm adt-tw-rounded-md adt-tw-h-10">
                        <?php esc_html_e( 'Save', 'woo-product-feed-pro' ); ?>
                    </button>
                    <p class="error-message hidden"></p>
                </td>
            <?php elseif ( 'select' === $setting['type'] ) : ?>
                <td colspan="2">
                    <span><?php echo wp_kses_post( $setting['title'] ); ?></span>&nbsp;&nbsp;
                    <select id="<?php echo esc_attr( $setting['id'] ); ?>" name="<?php echo esc_attr( $setting['id'] ); ?>" class="select-field adt-pfp-general-setting select-field adt-pfp-general-setting adt-tw-h-10 adt-tw-m-0 adt-tw-rounded-md adt-tw-border-gray-300">
                        <?php foreach ( $setting['options'] as $option ) : ?>
                            <option value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo get_option( $setting['id'] ) === $option['value'] ? 'selected' : ''; ?>><?php echo esc_html( $option['label'] ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            <?php elseif ( 'textarea' === $setting['type'] ) : ?>
                <td colspan="2">
                    <span><?php echo wp_kses_post( $setting['title'] ); ?></span>
                    <textarea id="<?php echo esc_attr( $setting['id'] ); ?>" name="<?php echo esc_attr( $setting['id'] ); ?>" class="textarea-field adt-pfp-general-setting adt-tw-h-20 adt-tw-block adt-tw-m-0 adt-tw-my-2 adt-tw-rounded-md adt-tw-border-gray-300"><?php echo esc_attr( get_option( $setting['id'], '' ) ); ?></textarea>
                    <button type="button" class="adt-pfp-save-setting-button adt-button adt-button-primary adt-button-sm adt-tw-rounded-md adt-tw-h-10" id="save_facebook_pixel_id">
                        <?php esc_html_e( 'Save', 'woo-product-feed-pro' ); ?>
                    </button>
                    <p class="error-message hidden"></p>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>

<?php
$other_settings = $settings_page->get_other_settings();
if ( ! empty( $other_settings ) ) :
?>
<table class="woo-product-feed-pro-table woo-product-feed-pro-table--other-settings">
    <thead>
        <tr>
            <td colspan="2"><strong><?php esc_html_e( 'Other settings', 'woo-product-feed-pro' ); ?></strong></td>
        </tr>
    </thead>
    <tbody>
    <?php foreach ( $other_settings as $other_setting ) : ?>
        <tr>
            <td>
                <?php if ( ! empty( $other_setting['title'] ) && ! empty( $other_setting['show_title'] ) && true === $other_setting['show_title'] ) : ?>
                    <h4 style="margin: 4px 0 8px 0;"><?php echo wp_kses_post( $other_setting['title'] ); ?></h4>
                <?php endif; ?>
                <span><?php echo wp_kses_post( $other_setting['desc'] ?? '' ); ?></span>
            </td>
            <td>
                <?php if ( ! empty( $other_setting['type'] ) ) : ?>
                    <?php if ( 'checkbox' === $other_setting['type'] ) : ?>
                        <label class="woo-product-feed-pro-switch">
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr( $other_setting['id'] ?? '' ); ?>"
                                name="<?php echo esc_attr( $other_setting['id'] ?? '' ); ?>"
                                class="checkbox-field <?php echo esc_attr( $other_setting['class'] ?? '' ); ?>"
                                title="<?php echo esc_attr( $other_setting['title'] ?? '' ); ?>"
                                <?php echo ( 'yes' === get_option( $other_setting['id'] ) ) ? 'checked' : ''; ?>
                                data-confirmation="<?php echo esc_attr( $other_setting['confirmation'] ?? '' ); ?>"
                            />
                            <div class="woo-product-feed-pro-slider round"></div>
                        </label>
                    <?php elseif ( 'button' === $other_setting['type'] ) : ?>
                        <button
                            class="button button-secondary"
                            id="<?php echo esc_attr( $other_setting['id'] ?? '' ); ?>"
                            class="<?php echo esc_attr( $other_setting['class'] ?? '' ); ?>"
                            data-confirmation="<?php echo esc_attr( $other_setting['confirmation'] ?? '' ); ?>"
                        >
                            <?php echo esc_html( $other_setting['title'] ?? '' ); ?>
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
