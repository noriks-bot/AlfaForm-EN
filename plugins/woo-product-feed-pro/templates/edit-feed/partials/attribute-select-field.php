<?php
/**
 * Attribute Select Field Template
 *
 * Template for the attribute selection dropdown in field mapping.
 * Includes both the select dropdown and static value input, using show/hide for toggling.
 *
 * @package AdTribes\PFP\Templates
 * @since   13.4.8
 *
 * Expected variables:
 * @var array  $attribute_dropdown   Array of attribute groups and options
 * @var int    $row_index            Current row index
 * @var string $selected_attribute   Currently selected attribute value
 * @var string $value                Value if attribute is static_value, page_url, or post_url (optional)
 */

defined( 'ABSPATH' ) || exit;

use AdTribes\PFP\Helpers\Helper;

// Determine the type of selection.
$is_static_value = 'static_value' === $selected_attribute;
$is_page_url     = 'page_url' === $selected_attribute;
$is_post_url     = 'post_url' === $selected_attribute;

// Get WordPress pages and posts.
$wordpress_pages = Helper::get_wordpress_pages();
$wordpress_posts = Helper::get_wordpress_posts();
?>

<div class="adt-field-mapping-select-field-wrapper adt-tw-flex adt-tw-flex-col adt-tw-gap-2">
    <select 
        name="attributes[<?php echo esc_attr( $row_index ); ?>][mapfrom]" 
        class="adt-tw-w-full select-field woo-sea-select2"
    >
        <option></option>
        <?php
        if ( ! empty( $attribute_dropdown ) ) :
            foreach ( $attribute_dropdown as $group_name => $attribute ) :
            ?>
                <optgroup label='<?php echo esc_attr( $group_name ); ?>'>
                <?php
                if ( ! empty( $attribute ) ) :
                    foreach ( $attribute as $attr => $attr_label ) :
                    ?>
                        <option
                            value="<?php echo esc_attr( $attr ); ?>"
                            <?php selected( $selected_attribute, $attr ); ?>
                        >
                            <?php echo esc_html( $attr_label ); ?>
                        </option>
                        <?php
                    endforeach;
                endif;
                ?>
                </optgroup>
                <?php
            endforeach;
        endif;
        ?>
        <option value="static_value" <?php selected( $is_static_value, true ); ?>><?php esc_html_e( 'Static Value', 'woo-product-feed-pro' ); ?></option>
    </select>
    <div class="adt-static-value-wrapper adt-tw-flex adt-tw-flex-col adt-tw-gap-2" <?php echo ! $is_static_value ? 'style="display: none;"' : ''; ?>>
        <input 
            type="text" 
            name="attributes[<?php echo esc_attr( $row_index ); ?>][mapfrom]" 
            class="adt-tw-w-full adt-tw-max-w-[400px] adt-tw-p-2" 
            value="<?php echo esc_attr( $value ?? '' ); ?>"
            <?php echo ! $is_static_value ? 'disabled' : ''; ?>
        >
        <input 
            type="hidden" 
            name="attributes[<?php echo esc_attr( $row_index ); ?>][static_value]" 
            value="<?php echo $is_static_value ? 'true' : 'false'; ?>"
            <?php echo ! $is_static_value ? 'disabled' : ''; ?>
        >
    </div>
    <div class="adt-page-url-attribute-wrapper adt-tw-flex adt-tw-flex-col adt-tw-gap-2" <?php echo ! $is_page_url ? 'style="display: none;"' : ''; ?>>
        <select 
            name="attributes[<?php echo esc_attr( $row_index ); ?>][value]" 
            class="adt-tw-w-full adt-page-url-select woo-sea-select2"
            <?php echo ! $is_page_url ? 'disabled' : ''; ?>
        >
            <option value=""><?php esc_html_e( 'Select a page...', 'woo-product-feed-pro' ); ?></option>
            <?php foreach ( $wordpress_pages as $page_id => $page_title ) : ?>
                <option 
                    value="<?php echo esc_attr( $page_id ); ?>"
                    <?php selected( $value, (string) $page_id ); ?>
                >
                    <?php echo esc_html( $page_title ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="adt-post-url-attribute-wrapper adt-tw-flex adt-tw-flex-col adt-tw-gap-2" <?php echo ! $is_post_url ? 'style="display: none;"' : ''; ?>>
        <select 
            name="attributes[<?php echo esc_attr( $row_index ); ?>][value]" 
            class="adt-tw-w-full adt-post-url-select woo-sea-select2"
            <?php echo ! $is_post_url ? 'disabled' : ''; ?>
        >
            <option value=""><?php esc_html_e( 'Select a post...', 'woo-product-feed-pro' ); ?></option>
            <?php foreach ( $wordpress_posts as $wp_post_id => $post_title ) : ?>
                <option 
                    value="<?php echo esc_attr( $wp_post_id ); ?>"
                    <?php selected( $value, (string) $wp_post_id ); ?>
                >
                    <?php echo esc_html( $post_title ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
