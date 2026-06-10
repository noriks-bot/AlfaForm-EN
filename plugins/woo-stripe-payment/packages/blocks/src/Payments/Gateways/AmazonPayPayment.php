<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class AmazonPayPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_amazonpay';

	public function get_payment_method_data() {
		return wp_parse_args( [
			'accountCountry'     => stripe_wc()->account_settings->get_account_country( wc_stripe_mode() ),
			'accountCountries'   => $this->payment_method->get_account_countries(),
			'acceptedCurrencies' => $this->payment_method->get_accepted_currencies()
		], parent::get_payment_method_data() );
	}

}