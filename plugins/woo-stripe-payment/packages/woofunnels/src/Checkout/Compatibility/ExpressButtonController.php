<?php

namespace PaymentPlugins\WooFunnels\Stripe\Checkout\Compatibility;

use PaymentPlugins\WooFunnels\Stripe\AssetsApi;

class ExpressButtonController {

	private $settings;

	/**
	 * @var \PaymentPlugins\WooFunnels\Stripe\Checkout\Compatibility\AbstractCompatibility[]
	 */
	protected $payment_gateways = [];

	private $id = 'paymentplugins_wc_stripe';

	private $assets;

	public function __construct( AssetsApi $assets ) {
		$this->assets = $assets;
		$this->initialize();
	}

	protected function initialize() {
		add_action( 'wfacp_after_checkout_page_found', [ $this, 'handle_checkout_page_found' ] );
		add_filter( 'wfacp_smart_buttons', [ $this, 'add_buttons' ], 20 );
		//add_action( 'wfacp_smart_button_container_' . $this->id, [ $this, 'render_express_buttons' ] );
		add_filter( 'wfacp_template_localize_data', function ( $data ) {
			if ( $this->has_express_buttons() ) {
				$data['smart_button_wrappers']['dynamic_buttons'] = array_merge(
					$data['smart_button_wrappers']['dynamic_buttons'],
					array_reduce( $this->get_payment_gateways(), function ( $carry, $gateway ) {
						$key           = sprintf( '#wfacp_smart_button_%1$s div.banner_payment_method_%1$s', $gateway->get_id() );
						$carry[ $key ] = sprintf( '#wfacp_smart_button_%1$s', $gateway->get_id() );

						return $carry;
					}, [] )
				);
			}

			return $data;
		} );
	}

	public function handle_checkout_page_found() {
		$this->settings = \WFACP_Common::get_page_settings( \WFACP_Common::get_id() );
		if ( $this->has_express_buttons() ) {
			$this->assets->enqueue_style( 'wc-stripe-woofunnels-checkout', 'build/wc-stripe-woofunnels-checkout-styles.css' );
			$this->assets->enqueue_script( 'wc-stripe-woofunnels-checkout', 'build/wc-stripe-woofunnels-checkout.js' );

			foreach ( $this->get_payment_gateways() as $gateway ) {
				if ( $gateway->get_id() === 'stripe_link_checkout' ) {
					$link = WC()->payment_gateways()->payment_gateways()['stripe_link_checkout'] ?? null;
					if ( $link ) {
						$link->enqueue_express_checkout_scripts();
					}
				}
				add_action( 'wfacp_smart_button_container_' . $gateway->get_id(), function () use ( $gateway ) {
					$this->render_express_buttons( $gateway );
				} );
			}
		}
	}

	private function has_express_buttons() {
		foreach ( $this->get_payment_gateways() as $gateway ) {
			if ( $gateway->is_enabled() && $gateway->is_express_enabled() ) {
				return true;
			}
		}

		return false;
	}

	private function get_payment_gateways() {
		$this->initialize_gateways();

		return $this->payment_gateways;
	}

	private function get_payment_gateway_classes() {
		return [
			'stripe_googlepay'       => GooglePay::class,
			'stripe_applepay'        => ApplePay::class,
			'stripe_payment_request' => PaymentRequest::class,
			'stripe_link_checkout'   => LinkCheckout::class
		];
	}

	private function initialize_gateways() {
		if ( empty( $this->payment_gateways ) ) {
			$payment_methods = WC()->payment_gateways()->payment_gateways();
			foreach ( $this->get_payment_gateway_classes() as $id => $clazz ) {
				if ( isset( $payment_methods[ $id ] ) ) {
					$this->payment_gateways[ $id ] = new $clazz( $payment_methods[ $id ] );
				}
			}
		}
	}

	public function add_buttons( $buttons ) {
		if ( $this->has_express_buttons() ) {
			remove_action( 'woocommerce_checkout_before_customer_details', [
				\WC_Stripe_Field_Manager::class,
				'output_banner_checkout_fields'
			] );
			foreach ( $this->get_payment_gateways() as $gateway ) {
				$buttons[ $gateway->get_id() ] = [
					'iframe' => true
				];
			}
		}

		return $buttons;
	}

	public function render_express_buttons( $gateway ) {
		?>
        <div class="wc-stripe-checkout-banner-gateway banner_payment_method_<?php echo esc_attr( $gateway->get_id() ) ?>">

        </div>
		<?php
	}

}