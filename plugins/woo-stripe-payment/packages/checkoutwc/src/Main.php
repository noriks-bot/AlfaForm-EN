<?php

namespace PaymentPlugins\CheckoutWC\Stripe;

use PaymentPlugins\CheckoutWC\Stripe\OrderBumps\OrderBumpsController;

class Main {

	public static function init() {
		if ( self::is_active() ) {
			new AssetsController( stripe_wc()->version(), plugin_dir_url( __DIR__ ) );
			( new OrderBumpsController( __DIR__ ) )->initialize();
		}
	}

	private static function is_active() {
		return defined( 'CFW_NAME' );
	}

}