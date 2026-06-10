<?php

defined( 'ABSPATH' ) || exit();

if ( ! class_exists( 'WC_Payment_Gateway_Stripe_Local_Payment' ) ) {
	return;
}

/**
 *
 * @package PaymentPlugins\Gateways
 * @author  PaymentPlugins
 *
 */
class WC_Payment_Gateway_Stripe_PayByBank extends WC_Payment_Gateway_Stripe_Local_Payment {

	use WC_Stripe_Local_Payment_Intent_Trait;

	protected $payment_method_type = 'pay_by_bank';

	public $max_amount = 5000;

	public function __construct() {
		$this->local_payment_type = 'pay_by_bank';
		$this->currencies         = array( 'GBP' );
		$this->countries          = array( 'GB' );
		$this->limited_countries  = array( 'GB' );
		$this->id                 = 'stripe_paybybank';
		$this->tab_title          = __( 'Pay By Bank', 'woo-stripe-payment' );
		$this->template_name      = 'local-payment.php';
		$this->token_type         = 'Stripe_Local';
		$this->method_title       = __( 'Pay By Bank (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Pay By Bank gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		parent::__construct();
	}

}
