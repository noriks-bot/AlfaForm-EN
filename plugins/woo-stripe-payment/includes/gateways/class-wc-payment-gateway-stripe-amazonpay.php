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
class WC_Payment_Gateway_Stripe_AmazonPay extends WC_Payment_Gateway_Stripe_Local_Payment {

	use WC_Stripe_Local_Payment_Intent_Trait;

	protected $payment_method_type = 'amazon_pay';

	private $account_countries = array( 'AT', 'BE', 'CY', 'DK', 'FR', 'DE', 'HU', 'IE', 'IT', 'LU', 'NL', 'PT', 'ES', 'SE', 'CH', 'GB', 'US' );

	private $accepted_currencies = array(
		'US' => array( 'USD' )
	);

	public function __construct() {
		$this->local_payment_type = 'amazon_pay';
		$this->currencies         = array( 'AUD', 'CHF', 'DKK', 'EUR', 'GBP', 'HKD', 'JPY', 'NOK', 'NZD', 'SEK', 'USD', 'ZAR' );
		//$this->countries          = array( 'US' );
		$this->id                 = 'stripe_amazonpay';
		$this->tab_title          = __( 'Amazon Pay', 'woo-stripe-payment' );
		$this->method_title       = __( 'Amazon Pay (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Amazon Pay gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->icon               = stripe_wc()->assets_url( 'img/amazon_pay.svg' );
		parent::__construct();
	}

	public function init_supports() {
		$this->supports = array(
			'tokenization',
			'products',
			'subscriptions',
			'add_payment_method',
			'subscription_cancellation',
			'multiple_subscriptions',
			'subscription_amount_changes',
			'subscription_date_changes',
			'default_credit_card_form',
			'refunds',
			'pre-orders',
			'subscription_payment_method_change_admin',
			'subscription_reactivation',
			'subscription_suspension',
			'subscription_payment_method_change_customer',
		);
	}

	/**
	 * @param string $currency
	 * @param string $billing_country
	 * @param float  $total
	 *
	 * @return bool
	 */
	public function validate_local_payment_available( $currency, $billing_country, $total ) {
		$result = false;

		$account_country = stripe_wc()->account_settings->get_account_country( wc_stripe_mode() );

		// Check if account_country exists in the account_countries array
		if ( in_array( $account_country, $this->account_countries ) ) {
			// if there is an accepted_currencies list, verify.
			if ( isset( $this->accepted_currencies[ $account_country ] ) ) {
				$result = in_array( $currency, $this->accepted_currencies[ $account_country ], true );
			} else {
				$result = true;
			}
		}

		return $result;
	}

	/**
	 * @since 3.3.85
	 * @return string[]
	 */
	public function get_account_countries() {
		return $this->account_countries;
	}

	/**
	 * @since 3.3.85
	 * @return mixed
	 */
	public function get_accepted_currencies() {
		return $this->accepted_currencies;
	}

}
