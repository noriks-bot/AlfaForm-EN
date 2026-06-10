<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$term_id = $category->term_id;
?>
<tr class="catmapping">
    <td>
        <input type="hidden" name="mappings[<?php echo esc_attr( $term_id ); ?>][rowCount]" value="<?php echo esc_attr( $term_id ); ?>">
        <input type="hidden" name="mappings[<?php echo esc_attr( $term_id ); ?>][categoryId]" value="<?php echo esc_attr( $term_id ); ?>">
        <input type="hidden" name="mappings[<?php echo esc_attr( $term_id ); ?>][criteria]" class="input-field-large" id="<?php echo esc_attr( $term_id ); ?>" value="<?php echo esc_attr( $category->name ); ?>">
        <?php
        if ( $child_number > 0 ) {
            for ( $i = 0; $i < $child_number; $i++ ) {
                echo '-- ';
            }
        }
        ?>
        <?php echo esc_html( $category->name . ' (' . $category->count . ')' ); ?>
    </td>
    <td>
        <div id="the-basics-<?php echo esc_attr( $term_id ); ?>" class="pfp-google-taxonomy-category-mapping-input-container">
            <input
                type="text"
                class="input-field-large <?php echo '' !== $mapped_category ? 'active' : ''; ?> input-google-taxonomy js-typeahead js-autosuggest autocomplete_<?php echo esc_attr( $term_id ); ?>"
                value="<?php echo esc_attr( $mapped_category ); ?>"
                data-category_id="<?php echo esc_attr( $term_id ); ?>"
                data-parent=<?php echo $category->parent > 0 ? esc_attr( $category->parent ) : ''; ?>
            >
            <input
                type="hidden"
                name="mappings[<?php echo esc_attr( $term_id ); ?>][map_to_category]"
                class="input-google-taxonomy-hidden-id"
                value="<?php echo esc_attr( $mapped_category ); ?>"
            >
        </div>
    </td>
    <td>
    <?php if ( 0 === $category->parent ) : ?>
        <?php if ( ! empty( $childrens ) ) : ?>
        <span class="dashicons dashicons-arrow-down copy-google-taxonomy-category" title="Copy this category to subcategories" data-is_parent="1" data-category_id=<?php echo esc_attr( $term_id ); ?>></span>
        <span class="dashicons dashicons-arrow-down-alt copy-google-taxonomy-category ?>" title="Copy this category to all others" data-category_id=<?php echo esc_attr( $term_id ); ?>></span>
        <?php else : ?>
        <span class="dashicons dashicons-arrow-down-alt copy-google-taxonomy-category" title="Copy this category to all others" data-category_id=<?php echo esc_attr( $term_id ); ?>></span>
        <?php endif; ?>
    <?php else : ?>
        <?php if ( ! empty( $childrens ) ) : ?>
        <span class="dashicons dashicons-arrow-down copy-google-taxonomy-category" title="Copy this category to subcategories" data-is_parent="1" data-category_id=<?php echo esc_attr( $term_id ); ?>></span>
        <span class="dashicons dashicons-arrow-down-alt copy-google-taxonomy-category" title="Copy this category to all others" data-category_id=<?php echo esc_attr( $term_id ); ?>></span>
        <?php endif; ?>
    <?php endif; ?>
    </td>
</tr>
