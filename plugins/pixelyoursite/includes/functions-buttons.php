<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function renderBlackButton( $text, $url ) {
	?>
    <a href="<?php echo esc_url( $url ); ?>" target="_blank" class="black-button"><?php echo esc_html( $text ); ?></a>
	<?php
}

function renderPopoverButton( $id, $position = 'right' ) {
	?>
    <button type="button" class="btn btn-popover" role="button" data-toggle="pys-popover"
            data-tippy-trigger="click" data-tippy-placement="<?php echo esc_attr( $position ); ?>"
            data-popover_id="<?php echo esc_attr( $id ); ?>" data-original-title="" title="">
        <img src="<?php echo PYS_FREE_URL . '/dist/images/info.svg'; ?>">
    </button>
	<?php
}

function renderAddCustomParameterButton( $pixel ) {
	?>
    <button class="btn btn-primary btn-primary-type2 add-<?php echo esc_attr( $pixel ); ?>-parameter"
            type="button">Add Custom Parameter
    </button>
	<?php
}