<?php
/**
 * Filter row template.
 *
 * @package AdTribes\PFP\Views\Templates
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

use AdTribes\PFP\Classes\Legacy\Filters_Legacy;

$filters = Filters_Legacy::instance();

?>
<tr class="rowCount filter-row">
    <td>
        <input type="hidden" name="rules[<?php echo esc_attr( $row_count ); ?>][rowCount]" value="<?php echo esc_attr( $row_count ); ?>">
        <input type="checkbox" name="record" class="checkbox-field">
    </td>
    <td><i><?php esc_html_e( 'Filter', 'woo-product-feed-pro' ); ?></i></td>
    <td>
        <select name="rules[<?php echo esc_attr( $row_count ); ?>][attribute]" id="rules_<?php echo esc_attr( $row_count ); ?>" class="select-field woo-sea-select2">
            <option></option>
            <?php if ( ! empty( $attributes ) ) : ?>
                <?php foreach ( $attributes as $group_name => $attribute ) : ?>
                    <optgroup label='<?php echo esc_html( $group_name ); ?>'>
                        <?php if ( ! empty( $attribute ) ) : ?>
                            <?php foreach ( $attribute as $attr => $attr_label ) : ?>
                                <option 
                                    value="<?php echo esc_attr( $attr ); ?>"
                                    <?php selected( $selected_attribute, $attr ); ?>
                                >
                                    <?php echo esc_html( $attr_label ); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </optgroup>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </td>
    <td>
        <select name="rules[<?php echo esc_attr( $row_count ); ?>][condition]" class="select-field woo-sea-select2">
            <?php
            echo $filters->get_condition_options( $condition, 'filter' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
        </select>   
    </td>
    <td>
        <input type="text" id="criteria_<?php echo esc_attr( $row_count ); ?>" name="rules[<?php echo esc_attr( $row_count ); ?>][criteria]" class="input-field-large" value="<?php echo esc_attr( $criteria ); ?>">
    </td>
    <td>
        <input type="checkbox" name="rules[<?php echo esc_attr( $row_count ); ?>][cs]" class="checkbox-field" aria-label="<?php esc_attr_e( 'Case sensitive', 'woo-product-feed-pro' ); ?>" <?php checked( $is_case_sensitive, true ); ?>>
    </td>
    <td>
        <select name="rules[<?php echo esc_attr( $row_count ); ?>][than]" class="select-field">
            <?php
            echo $filters->get_action_options( $than ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
        </select>
    </td>
    <td>&nbsp;</td>
</tr>
