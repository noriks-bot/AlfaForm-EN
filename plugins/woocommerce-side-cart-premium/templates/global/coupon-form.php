<?php
/**
 * Side Cart Footer
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/coupon-form.php.
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

if( WC()->cart->is_empty() ) return;

?>

<form class="xoo-wsc-sl-apply-coupon">
	<input type="text" name="xoo-wsc-slcf-input" placeholder="<?php _e( 'Enter Promo Code', 'side-cart-woocommerce' ); ?>">
	<button class="<?php echo xoo_wsc_frontend()->get_button_classes('text') ?>" type="submit"><?php _e( 'Submit', 'side-cart-woocommerce' ); ?></button>
</form>

<?php if( !empty( WC()->cart->get_coupons() ) ): ?>
	<div class="xoo-wsc-sl-applied">
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ): ?>
			<div>
				<span class="xoo-wsc-slc-saved"><?php  echo __( 'Saved', 'side-cart-woocommerce' ). ' '. wc_price( WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax ) ) ?></span>
				<span class="xoo-wsc-slc-remove">
					<?php echo $code ?>
					<span class="xoo-wsc-remove-coupon" data-code="<?php echo $code ?>"><?php _e( '[Remove]', 'side-cart-woocommerce' ) ?></span>
				</span>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>