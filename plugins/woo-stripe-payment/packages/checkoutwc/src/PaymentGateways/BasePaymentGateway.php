<?php


namespace PaymentPlugins\CheckoutWC\Stripe\PaymentGateways;

use PaymentPlugins\CheckoutWC\Stripe\Constants;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use WC_Order;
use WC_Payment_Token_Stripe;
use WC_Stripe_Constants;
use WP_Error;

/**
 * Class BasePaymentGateway
 *
 * @package PaymentPlugins\CheckoutWC\Stripe\PaymentGateways
 */
class BasePaymentGateway {

	protected $name;

	protected $supports_api_refund = true;

	/**
	 * @var \WC_Stripe_Gateway
	 */
	protected $payment_client;

	/**
	 * @var \WC_Payment_Gateway_Stripe
	 */
	protected $payment_method;

	public static function get_instance() {
		static $instance;
		if ( ! $instance ) {
			$instance = new static();
		}

		return $instance;
	}

	public function is_api_refund() {
		return $this->supports_api_refund;
	}

	public function init_payment_client( $payment_method ) {
		$this->payment_method = WC()->payment_gateways()->payment_gateways()[ $payment_method ];
		$this->payment_client = $this->payment_method->gateway;
	}

	/**
	 * @param WC_Order $order The order.
	 * @param array $product The product.
	 *
	 * @throws ApiErrorException The exception.
	 */
	public function process_offer_payment( WC_Order $order, array $product ): bool {
		$this->init_payment_client( $order->get_payment_method() );
		$this->payment_method->set_payment_method_token( $order->get_meta( WC_Stripe_Constants::PAYMENT_METHOD_TOKEN ) );
		$this->payment_client->mode( $order );

		$payment_intent = $order->get_meta( Constants::CFW_PAYMENT_INTENT_ID . $product['bump_id'] );

		if ( $payment_intent ) {
			$intent = $this->payment_client->paymentIntents->retrieve( $payment_intent );
		} else {
			// If customer doesn't exist on order, create a customer ID and attach payment method.
			$customer_id = $order->get_meta( WC_Stripe_Constants::CUSTOMER_ID );
			if ( ! $customer_id && ! is_user_logged_in() ) {
				$result = $this->create_customer( $order );
				if ( is_wp_error( $result ) ) {
					return false;
				}
			}

			$intent = $this->create_payment_intent( $order, $product );
		}

		if ( is_wp_error( $intent ) ) {
			return false;
		}

		$order->update_meta_data( Constants::CFW_PAYMENT_INTENT_ID . $product['bump_id'], $intent->id );
		$order->save();

		// check if intent needs confirmation
		if ( WC_Stripe_Constants::REQUIRES_CONFIRMATION === $intent->status ) {
			$intent = $this->payment_method->gateway->paymentIntents->confirm( $intent->id );
			if ( is_wp_error( $intent ) ) {
				return false;
			}
		}

		if ( WC_Stripe_Constants::REQUIRES_ACTION === $intent->status ) {
			// send JSON response so Stripe can handle 3DS
			wp_send_json(
				array(
					'status'   => 'success',
					'redirect' => $this->payment_method->get_payment_intent_checkout_url( $intent, $order ),
				)
			);
		}

		if ( in_array( $intent->status, array(
			WC_Stripe_Constants::SUCCEEDED,
			WC_Stripe_Constants::REQUIRES_CAPTURE
		), true ) ) {
			$order->update_meta_data( 'cfw_offer_txn_resp_' . $product['bump_id'], $intent->charges->data[0]->id );
			$order->save();

			return true;
		}

		return false;
	}

	/**
	 * @param WC_Order $order The order.
	 * @param array $product_data The product data.
	 *
	 * @throws ApiErrorException The exception.
	 */
	private function create_payment_intent( WC_Order $order, array $product_data ): PaymentIntent {
		$customer_id = $order->get_customer_id();
		$args        = array(
			'amount'               => wc_stripe_add_number_precision( $product_data['price'], $order->get_currency() ),
			'currency'             => $order->get_currency(),
			// translators: %1$s the site name, %2$s the order number
			'description'          => sprintf( __( '%1$s - Order %2$s - Order Bump', 'woo-stripe-payment' ), wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $order->get_order_number() ),
			'payment_method'       => $order->get_meta( WC_Stripe_Constants::PAYMENT_METHOD_TOKEN ),
			'confirmation_method'  => $this->payment_method->get_confirmation_method( $order ),
			'capture_method'       => $this->payment_method->get_payment_method_charge_type(),
			'confirm'              => false,
			'payment_method_types' => [ $this->payment_method->get_payment_method_type() ],
			'customer'             => $customer_id ? wc_stripe_get_customer_id( $customer_id ) : $order->get_meta( WC_Stripe_Constants::CUSTOMER_ID ),
		);
		$this->payment_method->payment_object->add_order_shipping_address( $args, $order );
		$this->payment_method->payment_object->add_order_metadata( $args, $order );

		/**
		 * @param array $args
		 * @param \WC_Order $order
		 */
		$args = apply_filters( 'wc_stripe_checkoutwc_payment_intent_args', $args, $order, $this->payment_client ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment

		return $this->payment_client->paymentIntents->create( $args );
	}

	/**
	 * @param WC_Order $order The order.
	 * @param array $offer_data The offer data.
	 *
	 * @return string|false
	 */
	public function process_offer_refund( WC_Order $order, array $offer_data ) {
		$this->init_payment_client( $order->get_payment_method() );
		$refund = $this->payment_client->mode( $order )->refunds->create(
			array(
				'charge'   => $offer_data['transaction_id'],
				'amount'   => wc_stripe_add_number_precision( $offer_data['refund_amount'], $order->get_currency() ),
				'metadata' => array(
					'order_id'    => $order->get_id(),
					'created_via' => 'woocommerce',
				),
			)
		);
		if ( is_wp_error( $refund ) ) {
			$order->add_order_note(
				sprintf(
					__( 'Error processing refund. Reason: %s', 'woo-stripe-payment' ),
					$refund->get_error_message()
				)
			);

			return false;
		}

		return $refund->id;
	}

	/**
	 * @param WC_Order $order The order.
	 *
	 * @return Customer|WC_Payment_Token_Stripe|WP_Error|null
	 */
	private function create_customer( WC_Order $order ) {
		$result = \WC_Stripe_Customer_Manager::instance()->create_customer( WC()->customer );

		if ( ! is_wp_error( $result ) ) {
			$order->update_meta_data( WC_Stripe_Constants::CUSTOMER_ID, $result->id );
			$order->save();

			// save the payment method.
			$result = $this->payment_method->create_payment_method( $order->get_meta( WC_Stripe_Constants::PAYMENT_METHOD_TOKEN ), $result->id );
		}

		return $result;
	}
}
