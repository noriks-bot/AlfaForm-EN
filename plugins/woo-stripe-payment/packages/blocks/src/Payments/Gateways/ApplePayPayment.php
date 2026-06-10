<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;

use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripePayment;

class ApplePayPayment extends AbstractStripePayment {

	protected $name = 'stripe_applepay';

	public function get_payment_method_script_handles() {
		$this->assets_api->register_script( 'wc-stripe-blocks-apple-pay', 'build/wc-stripe-apple-pay.js' );

		return array( 'wc-stripe-blocks-apple-pay' );
	}

	public function get_payment_method_data() {
		return wp_parse_args( array(
			'buttonType'   => $this->payment_method->get_option( 'button_type_checkout' ),
			'buttonTheme'  => $this->get_button_theme(),
			'buttonHeight' => $this->get_setting( 'button_height', 40 ),
			'buttonRadius' => $this->get_setting( 'button_radius', 4 ) . 'px',
			'editorIcon'   => $this->assets_api->get_asset_url( 'assets/img/apple_pay_button_black.svg' ),
			'displayRule'  => \wc_string_to_bool( $this->get_setting( 'all_browsers', 'yes' ) ) ? 'always' : 'auto',
		), parent::get_payment_method_data() );
	}

	private function get_button_theme() {
		$style = $this->get_setting( 'button_style', 'black' );
		switch ( $style ) {
			case 'apple-pay-button-white':
				return 'white';
			case 'apple-pay-button-white-with-line':
				return 'white-outline';
			default:
				return 'black';
		}
	}

}