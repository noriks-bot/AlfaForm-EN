<?php
/**
 * Rule row template.
 *
 * @package AdTribes\PFP\Views\Templates
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

use AdTribes\PFP\Classes\Rules;

$rules = Rules::instance();

// Check if the condition is a math operator.
$is_math_operator = in_array( $condition, array( 'multiply', 'divide', 'plus', 'minus' ), true );

// Check if the condition is a find and replace.
$is_find_replace = 'findreplace' === $condition;
?>
<tr class="rowCount rule-row">
    <td>
        <input type="hidden" name="rules2[<?php echo esc_attr( $row_count ); ?>][rowCount]" value="<?php echo esc_attr( $row_count ); ?>">
        <input type="checkbox" name="record" class="checkbox-field">
    </td>
    <td><i><?php esc_html_e( 'Rule', 'woo-product-feed-pro' ); ?></i></td>
    <td>
        <select name="rules2[<?php echo esc_attr( $row_count ); ?>][attribute]" id="rules2_<?php echo esc_attr( $row_count ); ?>" class="select-field woo-sea-select2">
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
        <select name="rules2[<?php echo esc_attr( $row_count ); ?>][condition]" id="condition_<?php echo esc_attr( $row_count ); ?>" class="select-field woo-sea-select2">
            <?php
            echo $rules->get_condition_options( $condition, 'rule' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
        </select>   
    </td>
    <td>
        <input type="text" id="criteria_<?php echo esc_attr( $row_count ); ?>" name="rules2[<?php echo esc_attr( $row_count ); ?>][criteria]" class="input-field-large" value="<?php echo esc_attr( $criteria ); ?>">
    </td>
    <td>
        <input type="checkbox" name="rules2[<?php echo esc_attr( $row_count ); ?>][cs]" id="cs_<?php echo esc_attr( $row_count ); ?>" class="checkbox-field" aria-label="<?php esc_attr_e( 'Case sensitive', 'woo-product-feed-pro' ); ?>" <?php checked( $is_case_sensitive, true ); ?>>
    </td>
    <td>
        <select name="rules2[<?php echo esc_attr( $row_count ); ?>][than_attribute]" id="than_attribute_<?php echo esc_attr( $row_count ); ?>" class="select-field woo-sea-select2">
            <option></option>
            <?php if ( ! empty( $attributes ) ) : ?>
                <?php foreach ( $attributes as $group_name => $attribute ) : ?>
                    <optgroup label='<?php echo esc_html( $group_name ); ?>'>
                        <?php if ( ! empty( $attribute ) ) : ?>
                            <?php foreach ( $attribute as $attr => $attr_label ) : ?>
                                <option 
                                    value="<?php echo esc_attr( $attr ); ?>"
                                    <?php selected( $than_attribute, $attr ); ?>
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
        <input type="text" name="rules2[<?php echo esc_attr( $row_count ); ?>][newvalue]" class="input-field-large" id="is-field_<?php echo esc_attr( $row_count ); ?>" value="<?php echo esc_attr( $new_value ); ?>">
    </td>
</tr>
