<?php
/**
 * Apply Coupon
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/slider/apply-coupon.php.
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

?>

<div class="xoo-wsc-sl-heading">
	<span class="xoo-wsc-toggle-slider xoo-wsc-slider-close xoo-wsc-icon-arrow-thin-right"></span>
	<?php _e( 'Apply Coupon', 'side-cart-woocommerce' ); ?>
</div>

<div class="xoo-wsc-sl-body">

	<?php

	//Coupon form
	if( xoo_wsc_helper()->get_style_option('scf-coup-display') === 'slider' ){
		xoo_wsc_helper()->get_template( 'global/coupon-form.php' );
	}


	$listHTML = '<div class="xoo-wsc-clist-cont">%s</div>';;

	$sections = '';

	foreach (  xoo_wsc_cart()->get_coupons() as $section => $coupons ){

		if( empty( $coupons ) ) continue;

		$sectionContainer = '<div class="xoo-wsc-clist-section xoo-wsc-clist-section-%1$s">%2$s</div>';
		
		$label 	= sprintf( '<span class="xoo-wsc-clist-label">%s</span>', $section === "valid" ? __( 'Available Coupons', 'side-cart-woocommerce' ) : __( 'Unavailable Coupons', 'side-cart-woocommerce' ) );

		$rows = '';

		ob_start();

		?>

		<?php foreach ( $coupons as $coupon_data ): ?>

			<?php $coupon = $coupon_data['coupon']; ?>

			<div class="xoo-wsc-coupon-row">
				<span class="xoo-wsc-cr-code"><?php echo $coupon->get_code(); ?></span>
				<span class="xoo-wsc-cr-off"><?php printf( __( 'Get %s off', 'side-cart-woocommerce' ), $coupon_data['off_value'] )  ?></span>
				<span class="xoo-wsc-cr-desc"><?php echo $coupon->get_description() ?></span>
				<?php if( $section === 'valid' ): ?>
					<button class="xoo-wsc-coupon-apply-btn <?php echo xoo_wsc_frontend()->get_button_classes('text') ?>" value="<?php echo $coupon->get_code() ?>"><?php _e( 'Apply Coupon', 'side-cart-woocommerce' ); ?></button>
				<?php endif; ?>
			</div>

		<?php endforeach; ?>

		<?php

		$rows .= ob_get_clean();

		$sections .= sprintf( $sectionContainer, $section, $label.$rows );

	}

	printf( $listHTML, $sections );

	?>

</div>