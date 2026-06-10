<?php


namespace PaymentPlugins\CheckoutWC\Stripe\OrderBumps;

use Objectiv\Plugins\Checkout\Factories\BumpFactory;
use WC_Order;
use WC_Payment_Gateway_Stripe;

class OrderBumpsController {

	private $path;

	public function __construct( $path ) {
		$this->path = $path;
	}

	public function initialize() {
		add_filter( 'cfw_one_click_supported_gateways', array( $this, 'add_payment_gateways' ) );
		add_filter( 'wc_stripe_force_save_payment_method', array( $this, 'maybe_force_save_payment_method' ), 10, 3 );
	}

	public function add_payment_gateways( $supported_gateways ) {
		foreach ( $this->get_payment_method_ids() as $id ) {
			$supported_gateways[ $id ] = array(
				'path'  => $this->path . '/PaymentGateways/BasePaymentGateway.php',
				'class' => '\PaymentPlugins\CheckoutWC\Stripe\PaymentGateways\BasePaymentGateway',
			);
		}

		return $supported_gateways;
	}

	/**
	 * @param bool $force_save Whether to force save.
	 * @param WC_Order|null $order The WooCommerce order.
	 * @param WC_Payment_Gateway_Stripe $payment_method The payment method.
	 *
	 * @return bool
	 */
	public function maybe_force_save_payment_method( $force_save, $order, $payment_method = null ): bool {
		if ( ! $payment_method ) {
			return $force_save;
		}

		// Check if CheckoutWC is active and has after checkout bumps
		if ( ! defined( 'CFW_NAME' ) ) {
			return $force_save;
		}

		if ( $payment_method->use_saved_source() ) {
			return $force_save;
		}

		$has_bumps = $this->has_post_purchase_bumps( $payment_method );

		if ( $has_bumps ) {
			$force_save = true;
		}

		return $force_save;
	}

	/**
	 * Check if there are displayable after checkout bumps that support one-click
	 *
	 * @param WC_Payment_Gateway_Stripe $payment_method The payment method.
	 *
	 * @return bool
	 */
	private function has_post_purchase_bumps( WC_Payment_Gateway_Stripe $payment_method ): bool {
		$supported_ids = $this->get_payment_method_ids();

		// Check if the current payment method supports one-click
		if ( ! in_array( $payment_method->id, $supported_ids, true ) ) {
			return false;
		}

		// Check if CheckoutWC OrderBumps feature is available
		if ( ! class_exists( '\Objectiv\Plugins\Checkout\Features\OrderBumps' ) ) {
			return false;
		}

		// Check if there are any bumps with post_purchase_one_click location
		if ( ! class_exists( '\Objectiv\Plugins\Checkout\Factories\BumpFactory' ) ) {
			return false;
		}

		$all_bumps = BumpFactory::get_all();

		foreach ( $all_bumps as $bump ) {
			$location    = $bump->get_display_location();
			$displayable = $bump->is_displayable();
			$published   = $bump->is_published();

			if ( 'post_purchase_one_click' === $location && $displayable && $published ) {
				return true;
			}
		}

		return false;
	}

	private function get_payment_method_ids() {
		/**
		 * Filter the payment method IDs that support CheckoutWC one-click upsells.
		 *
		 * @since 3.3.97
		 */
		return apply_filters(
			'wc_stripe_checkoutwc_get_payment_method_ids',
			array(
				'stripe_cc',
				'stripe_applepay',
				'stripe_googlepay',
				'stripe_payment_request',
			)
		);
	}
}
