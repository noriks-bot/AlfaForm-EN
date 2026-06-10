<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;
use PaymentPlugins\Stripe\Utilities\CountryUtils;

class BilliePayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_billie';

	public function get_payment_method_data() {
		return array_merge(
			parent::get_payment_method_data(),

			[
				'accountCountry'    => stripe_wc()->account_settings->get_account_country( wc_stripe_mode() ),
				'eu_countries'      => CountryUtils::get_eu_counties(),
				'account_countries' => [],
				'requiredParams'  => $this->payment_method->get_required_parameters(),
			]
		);
	}
}