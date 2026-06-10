<?php
/**
 * Field Mapping Row Template
 *
 * Complete row template for field mapping table.
 *
 * @package AdTribes\PFP\Templates
 * @since   13.4.8
 *
 * Expected variables:
 * @var int    $row_index            Current row index
 * @var bool   $is_own_mapping       Whether this is a custom field mapping
 * @var array  $field_options        HTML options for field dropdown (optional)
 * @var array  $attribute_dropdown   Array of attribute groups and options
 * @var array  $selected_values      Array of selected values (optional)
 */

defined( 'ABSPATH' ) || exit;

use AdTribes\PFP\Helpers\Helper;

$selected_field     = $selected_values['attribute'] ?? '';
$prefix             = $selected_values['prefix'] ?? '';
$selected_attribute = $selected_values['mapfrom'] ?? '';
$suffix             = $selected_values['suffix'] ?? '';
$value              = $selected_values['value'] ?? '';
?>

<tr class="rowCount <?php echo esc_attr( $row_index ); ?>">
    <td>
        <input type="hidden" name="attributes[<?php echo esc_attr( $row_index ); ?>][rowCount]" value="<?php echo esc_attr( $row_index ); ?>">
        <input type="checkbox" name="record" class="checkbox-field">
    </td>
    <td>
        <?php if ( $is_own_mapping ) : ?>
            <input name="attributes[<?php echo esc_attr( $row_index ); ?>][attribute]" id="own-input-field" class="input-field" value="<?php echo esc_attr( $selected_field ); ?>">
        <?php else : ?>
            <select name="attributes[<?php echo esc_attr( $row_index ); ?>][attribute]" class="select-field woo-sea-select2">
                <?php foreach ( $field_options as $group_name => $option ) : ?>
                    <optgroup label='<?php echo esc_attr( $group_name ); ?>'>
                        <?php foreach ( $option as $k => $v ) : ?>
                            <option
                                value="<?php echo esc_attr( $v['feed_name'] ); ?>"
                                <?php selected( $selected_field, $v['feed_name'] ); ?>
                            >
                                <?php echo esc_html( $k ) . ( ! empty( $v['name'] ) ? ' (' . esc_html( $v['name'] ) . ')' : '' ); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
    </td>
    <td>
        <input type="text" name="attributes[<?php echo esc_attr( $row_index ); ?>][prefix]" class="adt-tw-w-full adt-tw-h-11 adt-tw-max-w-[120px] adt-tw-p-[7px]" value="<?php echo esc_attr( $prefix ); ?>">
    </td>
    <td>
        <?php
        // phpcs:ignore
        Helper::locate_admin_template(
            'edit-feed/partials/attribute-select-field.php',
            true,
            false,
            array(
                'attribute_dropdown' => $attribute_dropdown,
                'row_index'          => $row_index,
                'selected_attribute' => $selected_attribute,
                'value'              => $value,
            )
        );
        ?>
    </td>
    <td>
        <input type="text" name="attributes[<?php echo esc_attr( $row_index ); ?>][suffix]" class="adt-tw-w-full adt-tw-h-11 adt-tw-max-w-[120px] adt-tw-p-[7px]" value="<?php echo esc_attr( $suffix ); ?>">
    </td>
</tr>
