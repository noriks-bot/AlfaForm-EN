<?php


namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways;


use PaymentPlugins\Blocks\Stripe\Payments\AbstractStripeLocalPayment;

class PayByBankPayment extends AbstractStripeLocalPayment {

	protected $name = 'stripe_paybybank';

}