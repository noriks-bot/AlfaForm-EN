<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;

use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripePayment;

/**
 * Class PaymentRequest
 *
 * @package PaymentPlugins\Blocks\Stripe\Payments
 */
class PaymentRequest extends AbstractStripePayment {

	protected $name = 'stripe_payment_request';

	public function get_payment_method_script_handles() {
		$this->assets_api->register_script( 'wc-stripe-blocks-payment-request', 'build/wc-stripe-payment-request.js' );

		return array( 'wc-stripe-blocks-payment-request' );
	}

	public function get_payment_method_data() {
		$data = [
			'editorIcons'  => array(
				'long'  => $this->assets_api->get_asset_url( 'assets/img/gpay_button_buy_black.svg' ),
				'short' => $this->assets_api->get_asset_url( 'assets/img/gpay_button_black.svg' )
			),
			'buttonHeight' => $this->get_setting( 'button_height', 40 ),
			'buttonRadius' => $this->get_setting( 'button_radius', 4 ) . 'px'
		];

		switch ( $this->get_setting( 'button_type', 'buy' ) ) {
			case 'default':
				$data['buttonType'] = 'plain';
				break;
			default:
				$data['buttonType'] = $this->get_setting( 'button_type', 'buy' );
		}

		switch ( $this->get_setting( 'button_theme' ) ) {
			case 'light':
			case 'light-outline':
				$data['buttonTheme'] = 'white';
				break;
			case 'dark':
			default:
				$data['buttonTheme'] = 'black';
				break;
		}

		return wp_parse_args( $data, parent::get_payment_method_data() );
	}

}