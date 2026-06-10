<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! empty( $attributes ) ) : ?>    
    <option></option>
    <?php foreach ( $attributes as $group_name => $attribute ) : ?>
    <optgroup label='<?php echo esc_html( $group_name ); ?>'>
        <?php
        if ( ! empty( $attribute ) ) :
            foreach ( $attribute as $attr_label => $attr ) :
                if ( is_array( $attr ) ) :
                ?>
                <option value="<?php echo esc_attr( $attr['feed_name'] ); ?>">
                    <?php echo esc_html( $attr_label . ' (' . $attr['name'] . ')' ); ?>
                </option>
                <?php else : ?>
                <option value="<?php echo esc_attr( $attr_label ); ?>">
                    <?php echo esc_html( $attr ); ?>
                </option>
                <?php
                endif;
            endforeach;
        endif;
        ?>
    </optgroup>
    <?php
    endforeach;
endif;
?>
