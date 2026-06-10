<?php

namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;

use Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema;
use PaymentPlugins\Blocks\Stripe\Assets\Api;
use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripePayment;
use PaymentPlugins\Blocks\Stripe\Payments\Gateways\Link\LinkPaymentGateway;
use PaymentPlugins\Blocks\Stripe\StoreApi\EndpointData;
use PaymentPlugins\Stripe\Controllers\PaymentIntent;
use PaymentPlugins\Stripe\Link\LinkIntegration;

class LinkPayment extends AbstractStripePayment {

	protected $name = 'stripe_link_checkout';

	private $link;

	/**
	 * @var \PaymentPlugins\Stripe\Controllers\PaymentIntent
	 */
	private $payment_intent_ctrl;

	/**
	 * @var Api
	 */
	private $assets;

	public function __construct( LinkIntegration $link, Api $assets ) {
		$this->link       = $link;
		$this->assets_api = $assets;
	}

	public function is_active() {
		return \wc_string_to_bool( $this->get_setting( 'enabled', 'no' ) );
	}

	public function add_stripe_params( $data ) {
		if ( $this->link->is_active() && $this->link->is_popup_enabled() ) {
			$data['stripeParams']['betas'][] = 'link_autofill_modal_beta_1';
		}

		return $data;
	}

	public function get_payment_method_data() {
		return [
			'name'                   => $this->get_name(),
			'gatewayId'              => $this->get_name(),
			'features'               => $this->get_supported_features(),
			'button'                 => [
				'radius' => $this->get_setting( 'button_radius', 4 ) . 'px',
				'height' => (int) $this->get_setting( 'button_height', 40 )
			],
			/*'launchLink'             => $this->link->is_autoload_enabled(),
			'popupEnabled'           => $this->link->is_popup_enabled(),
			'linkIconEnabled'        => $this->link->is_icon_enabled(),
			'linkIcon'               => $this->link->is_icon_enabled()
				? \wc_stripe_get_template_html( "link/link-icon-{$this->link->get_settings()->get_option('link_icon')}.php" )
				: null,*/
			'expressCheckoutEnabled' => $this->is_express_checkout_enabled(),
			'cartCheckoutEnabled'    => $this->is_cart_checkout_enabled()
		];
	}

	public function get_payment_method_script_handles() {
		$this->assets_api->register_script( 'wc-stripe-blocks-link', 'build/wc-stripe-link-checkout.js' );
		//$this->assets_api->register_script( 'wc-stripe-blocks-link-checkout-modal', 'build/wc-stripe-link-checkout-modal.js' );

		$handles = [ 'wc-stripe-blocks-link' ];

		/*if ( $this->link->is_popup_enabled() ) {
			$handles = array_merge( $handles, [ 'wc-stripe-blocks-link-checkout-modal' ] );
		}*/

		return $handles;
	}

	protected function is_express_checkout_enabled() {
		return \in_array( 'checkout_banner', $this->get_setting( 'payment_sections', [] ), true );
	}

	protected function is_cart_checkout_enabled() {
		return \in_array( 'cart', $this->get_setting( 'payment_sections', [] ), true );
	}

	public function set_payment_intent_controller( PaymentIntent $controller ) {
		$this->payment_intent_ctrl = $controller;
	}

}