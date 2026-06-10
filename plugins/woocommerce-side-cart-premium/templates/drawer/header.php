<?php
/**
 * Side Cart Drawer
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/drawer/header.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 4.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::drawer_header() );

?>

<div class="xoo-wsc-drawer-header">
	<span class="xoo-wsc-drh-txt"><?php esc_html_e( $heading ) ?></span>
	<span class="xoo-wsc-toggle-drawer xoo-wscdh-close xoo-wsc-icon-arrow-thin-<?php echo $openDirection; ?>"></span>
</div>