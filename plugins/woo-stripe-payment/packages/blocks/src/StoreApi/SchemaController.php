<?php

namespace PaymentPlugins\Blocks\Stripe\StoreApi;

use Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema;
use Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema;
use PaymentPlugins\Blocks\Stripe\Payments\PaymentsApi;
use PaymentPlugins\Stripe\Transformers\DataTransformer;

class SchemaController {

	private $extend_schema;

	private $payments_api;

	public function __construct( ExtendSchema $extend_schema, PaymentsApi $payments_api ) {
		$this->extend_schema = $extend_schema;
		$this->payments_api  = $payments_api;
		add_action( 'init', [ $this, 'initialize' ], 20 );
	}

	public function initialize() {
		$this->register_cart_data();
		$this->register_payment_gateway_data();
	}

	private function register_payment_gateway_data() {
		foreach ( $this->payments_api->get_payment_methods() as $payment_method ) {
			if ( $payment_method->is_active() ) {
				$data = $payment_method->get_endpoint_data();
				if ( ! empty( $data ) ) {
					if ( $data instanceof EndpointData ) {
						$data = $data->to_array();
					}
					$this->extend_schema->register_endpoint_data( $data );
				}
			}
		}

	}

	private function register_cart_data() {
		$data = new EndpointData();
		$data->set_namespace( 'wc_stripe' );
		$data->set_endpoint( CartSchema::IDENTIFIER );
		$data->set_schema_type( ARRAY_A );
		$data->set_data_callback( function () {
			return [
				'cart' => ( new DataTransformer() )->transform_cart( WC()->cart )
			];
		} );
		$this->extend_schema->register_endpoint_data( $data->to_array() );
	}

}