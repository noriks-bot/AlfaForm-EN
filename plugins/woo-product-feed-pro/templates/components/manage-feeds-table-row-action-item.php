<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

foreach ( $actions as $item ) : ?>
<div class="adt-manage-feeds-table-row-actions-item <?php echo esc_attr( $item['class'] ); ?> ">
    <a
        href="<?php echo isset( $item['url'] ) ? esc_url( $item['url'] ) : '#'; ?>"
        class="adt-manage-feeds-table-row-actions-item-link adt-tooltip"
    >
        <span class="adt-manage-feeds-table-row-actions-item-link-icon adt-tw-icon-[<?php echo esc_attr( $item['icon'] ); ?>]"></span>
        <div class="adt-tooltip-content">
            <?php echo esc_html( $item['label'] ); ?>
        </div>
    </a>
</div>
<?php endforeach; ?>
