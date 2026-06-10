<?php
/**
 * Suggested products Drawer
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/drawer/suggested-products.php.
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

extract( Xoo_Wsc_Template_Args::suggested_products_drawer() );

if( $enable !== 'yes' || wp_is_mobile()  ) return;

?>

<div class="xoo-wsc-dr-content xoo-wsc-dr-sp" data-drawer="suggested-products">

	<?php xoo_wsc_helper()->get_template( 'drawer/header.php', array( 'heading' => $heading ) ); ?>

	<div class="xoo-wsc-dr-body">

		<?php xoo_wsc_helper()->get_template( 'global/footer/suggested-products.php' ); ?>

	</div>

</div>