<?php

namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways\Link;

use Automattic\WooCommerce\StoreApi\Payments\PaymentContext;

class Controller {

	public function __construct() {
	}

	public function initialize() {
	}

	private function is_rest_request() {
		$request_uri = $_SERVER['REQUEST_URI'] ?? '';
		$request_uri = urldecode( $request_uri );
		if ( $request_uri && false !== strpos( $request_uri, stripe_wc()->rest_uri() ) ) {
			return true;
		} elseif ( method_exists( WC(), 'is_rest_api_request' ) ) {
			return WC()->is_rest_api_request();
		}

		return false;
	}

}