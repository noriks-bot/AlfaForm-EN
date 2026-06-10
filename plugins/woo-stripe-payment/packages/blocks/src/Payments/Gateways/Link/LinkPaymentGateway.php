<?php

namespace PaymentPlugins\Blocks\Stripe\Payments\Gateways\Link;

class LinkPaymentGateway extends \WC_Payment_Gateway_Stripe {

	public $id = 'stripe_link_checkout';

	public function __construct() {
		$this->supports = [];
	}

	public function is_available() {
		return true;
	}

	public function hooks() {
	}

	public function init_settings() {
	}

	/**
	 * @param float  $price
	 * @param string $label
	 * @param string $type
	 * @param mixed  ...$args
	 *
	 * @since 3.2.1
	 * @return array
	 */
	protected function get_display_item_for_cart( $price, $label, $type, ...$args ) {
		return [
			'name'   => $label,
			'amount' => wc_stripe_add_number_precision( $price )
		];
	}

	/**
	 * @param float    $price
	 * @param string   $label
	 * @param WC_Order $order
	 * @param string   $type
	 * @param mixed    ...$args
	 */
	protected function get_display_item_for_order( $price, $label, $order, $type, ...$args ) {
		return array(
			'name'   => $label,
			'amount' => wc_stripe_add_number_precision( $price, $order->get_currency() )
		);
	}

	/**
	 * @param WC_Product $product
	 *
	 * @since 3.2.1
	 *
	 * @return array
	 */
	protected function get_display_item_for_product( $product ) {
		return array(
			'name'   => esc_attr( $product->get_name() ),
			'amount' => wc_stripe_add_number_precision( $product->get_price() )
		);
	}

	/**
	 * @param $price
	 * @param $rate
	 * @param $i
	 * @param $package
	 * @param $incl_tax
	 *
	 * @return array|void
	 */
	public function get_formatted_shipping_method( $price, $rate, $i, $package, $incl_tax ) {
		$method = array(
			'id'          => $this->get_shipping_method_id( $rate->id, $i ),
			'amount'      => wc_stripe_add_number_precision( $price ),
			'displayName' => $this->get_formatted_shipping_label( $price, $rate, $incl_tax )
		);

		/*if ( $incl_tax ) {
			if ( $rate->get_shipping_tax() > 0 && ! wc_prices_include_tax() ) {
				$method['detail'] = WC()->countries->inc_tax_or_vat();
			}
		} else {
			if ( $rate->get_shipping_tax() > 0 && wc_prices_include_tax() ) {
				$method['detail'] = WC()->countries->ex_tax_or_vat();
			}
		}*/

		return $method;
	}

}