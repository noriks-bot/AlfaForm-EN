<?php
/**
 * Side Cart Slider
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/xoo-wsc-drawer.php.
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

extract( Xoo_Wsc_Template_Args::drawer() );

?>
<div class="xoo-wsc-drawer">

	<?php if( $showNotifications ): ?>
		<?php xoo_wsc_cart()->print_notices_html('drawer'); ?>
	<?php endif; ?>


	<?php xoo_wsc_helper()->get_template( 'drawer/suggested-products.php' ); ?>

	<span class="xoo-wsc-icon-chevron-<?php echo $drawerChevron; ?> xoo-wsc-toggle-drawer xoo-wsc-dtg-icon"></span>
	
	<span class="xoo-wsc-loader"></span>
	
</div>