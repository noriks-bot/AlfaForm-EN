<?php
if ( function_exists( 'WC' ) ) {
	$advanced_settings = stripe_wc()->advanced_settings;
	$payment_gateways  = WC()->payment_gateways()->payment_gateways();
	$cc_gateway        = $payment_gateways['stripe_cc'] ?? null;

	if ( $cc_gateway && $advanced_settings ) {
		/**
		 * @var \WC_Payment_Gateway_Stripe_CC $cc_gateway
		 */
		$cc_gateway->update_option( 'link_enabled', $advanced_settings->get_option( 'link_enabled' ) );
	}
}