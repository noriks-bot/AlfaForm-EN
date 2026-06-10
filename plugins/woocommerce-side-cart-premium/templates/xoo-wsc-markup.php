<?php
/**
 * Side Cart Markup
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/xoo-wsc-markup.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 4.2.1
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$isAjax = defined('DOING_AJAX') && DOING_AJAX;

?>

<div class="xoo-wsc-markup xoo-wsc-align-<?php echo xoo_wsc_helper()->get_style_option('scm-open-from'); ?>">

    <div class="xoo-wsc-modal">

        <div class="xoo-wsc-container">
    	   <?php if( $isAjax ) xoo_wsc_helper()->get_template( 'xoo-wsc-container.php' ); ?>
        </div>

    	<span class="xoo-wsc-opac"></span>

    </div>

    <div class="xoo-wsc-slider-modal">

        <div class="xoo-wsc-slider">
    	   <?php if( $isAjax ) xoo_wsc_helper()->get_template( 'xoo-wsc-slider.php' ); ?>
        </div>

    </div>

    <div class="xoo-wsc-drawer-modal">

        <div class="xoo-wsc-drawer">
            <?php if( $isAjax ) xoo_wsc_helper()->get_template( 'xoo-wsc-drawer.php' ); ?>
        </div>

    </div>
    
</div>