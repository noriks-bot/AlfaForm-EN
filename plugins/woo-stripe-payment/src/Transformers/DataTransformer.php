<?php

namespace PaymentPlugins\Stripe\Transformers;

use PaymentPlugins\Stripe\Utilities\NumberUtil;

/**
 * Transforms WooCommerce entities into Stripe-compatible data structures.
 *
 * This class is responsible for converting WooCommerce objects (Cart, Product, Order)
 * into normalized data arrays that the Stripe JavaScript integration expects.
 */
class DataTransformer {

	/**
	 * Transform WooCommerce cart into Stripe data structure
	 *
	 * @param \WC_Cart $cart
	 *
	 * @return array
	 */
	public function transform_cart( $cart ) {
		$currency = get_woocommerce_currency();

		return [
			'total'                   => NumberUtil::round( $cart->get_total( 'float' ), 2 ),
			'totalCents'              => wc_stripe_add_number_precision( $cart->get_total( 'float' ), $currency ),
			'needsShipping'           => $cart->needs_shipping(),
			'isEmpty'                 => $cart->is_empty(),
			'currency'                => $currency,
			'countryCode'             => WC()->countries ? WC()->countries->get_base_country() : wc_get_base_location()['country'],
			'availablePaymentMethods' => array_keys( WC()->payment_gateways()->get_available_payment_gateways() ),
			'lineItems'               => $this->get_line_items_from_cart( $cart ),
			'shippingOptions'         => $this->get_shipping_options_from_cart( $cart ),
			'selectedShippingMethod'  => $this->get_selected_shipping_method()
		];
	}

	/**
	 * Transform WooCommerce product into Stripe data structure
	 *
	 * @param \WC_Product $product
	 *
	 * @return array
	 */
	public function transform_product( $product ) {
		$currency = get_woocommerce_currency();

		return [
			'id'              => $product->get_id(),
			'needsShipping'   => $product->needs_shipping(),
			'total'           => NumberUtil::round( $product->get_price(), 2 ),
			'totalCents'      => wc_stripe_add_number_precision( $product->get_price(), $currency ),
			'price'           => NumberUtil::round( wc_get_price_to_display( $product ), 2 ),
			'currency'        => $currency,
			'lineItems'       => $this->get_line_items_from_product( $product ),
			'shippingOptions' => []
		];
	}

	/**
	 * Transform WooCommerce order into Stripe data structure
	 *
	 * @param \WC_Order $order
	 *
	 * @return array
	 */
	public function transform_order( $order ) {
		return [
			'order_id'        => $order->get_id(),
			'order_key'       => $order->get_order_key(),
			'currency'        => $order->get_currency(),
			'total'           => NumberUtil::round( $order->get_total(), 2 ),
			'totalCents'      => wc_stripe_add_number_precision( $order->get_total(), $order->get_currency() ),
			'lineItems'       => $this->get_line_items_from_order( $order ),
			'shippingOptions' => []
		];
	}

	/**
	 * Get generic line items from cart
	 *
	 * @param \WC_Cart $cart
	 *
	 * @return array
	 */
	private function get_line_items_from_cart( $cart ) {
		$items    = [];
		$incl_tax = wc_tax_enabled() && $cart->display_prices_including_tax();
		$currency = get_woocommerce_currency();

		// Add cart line items
		foreach ( $cart->get_cart() as $cart_item ) {
			$product = $cart_item['data'];
			$qty     = $cart_item['quantity'];
			$label   = $qty > 1 ? sprintf( '%s X %s', $product->get_name(), $qty ) : $product->get_name();
			$price   = $incl_tax
				? wc_get_price_including_tax( $product, [ 'qty' => $qty ] )
				: wc_get_price_excluding_tax( $product, [ 'qty' => $qty ] );
			$items[] = [
				'label'       => $label,
				'amount'      => NumberUtil::round( $price, 2 ),
				'amountCents' => wc_stripe_add_number_precision( $price, $currency ),
				'type'        => 'product',
				'name'        => $product->get_name(),
				'qty'         => $qty
			];
		}

		// Add shipping
		if ( $cart->needs_shipping() ) {
			$price   = $incl_tax
				? $cart->get_shipping_total() + $cart->get_shipping_tax()
				: $cart->get_shipping_total();
			$items[] = [
				'label'       => __( 'Shipping', 'woo-stripe-payment' ),
				'amount'      => NumberUtil::round( $price, 2 ),
				'amountCents' => wc_stripe_add_number_precision( $price, $currency ),
				'type'        => 'shipping'
			];
		}

		// Add fees
		foreach ( $cart->get_fees() as $fee ) {
			$price   = $incl_tax ? $fee->total + $fee->tax : $fee->total;
			$items[] = [
				'label'       => $fee->name,
				'amount'      => NumberUtil::round( $price, 2 ),
				'amountCents' => wc_stripe_add_number_precision( $price, $currency ),
				'type'        => 'fee'
			];
		}

		// Add discount
		if ( 0 < $cart->discount_cart ) {
			$price   = - 1 * abs( $incl_tax
					? $cart->discount_cart + $cart->discount_cart_tax
					: $cart->discount_cart );
			$items[] = [
				'label'       => __( 'Discount', 'woo-stripe-payment' ),
				'amount'      => NumberUtil::round( $price, 2 ),
				'amountCents' => wc_stripe_add_number_precision( $price, $currency ),
				'type'        => 'discount'
			];
		}

		// Add taxes separately if not included in prices
		if ( ! $incl_tax && wc_tax_enabled() ) {
			$items[] = [
				'label'       => __( 'Tax', 'woo-stripe-payment' ),
				'amount'      => NumberUtil::round( $cart->get_taxes_total(), 2 ),
				'amountCents' => wc_stripe_add_number_precision( $cart->get_taxes_total(), $currency ),
				'type'        => 'tax'
			];
		}

		return $items;
	}

	/**
	 * Get generic line items from order
	 *
	 * @param \WC_Order $order
	 *
	 * @return array
	 */
	private function get_line_items_from_order( $order ) {
		$items    = [];
		$currency = $order->get_currency();

		// Add order line items
		foreach ( $order->get_items() as $item ) {
			$qty     = $item->get_quantity();
			$label   = $qty > 1 ? sprintf( '%s X %s', $item->get_name(), $qty ) : $item->get_name();
			$items[] = [
				'label'       => $label,
				'amount'      => NumberUtil::round( $item->get_subtotal(), 2 ),
				'amountCents' => wc_stripe_add_number_precision( $item->get_subtotal(), $currency ),
				'type'        => 'item'
			];
		}

		// Add shipping
		if ( 0 < $order->get_shipping_total() ) {
			$items[] = [
				'label'       => __( 'Shipping', 'woo-stripe-payment' ),
				'amount'      => NumberUtil::round( $order->get_shipping_total(), 2 ),
				'amountCents' => wc_stripe_add_number_precision( $order->get_shipping_total(), $currency ),
				'type'        => 'shipping'
			];
		}

		// Add discount
		if ( 0 < $order->get_total_discount() ) {
			$discount = - 1 * $order->get_total_discount();
			$items[]  = [
				'label'       => __( 'Discount', 'woo-stripe-payment' ),
				'amount'      => NumberUtil::round( $discount, 2 ),
				'amountCents' => wc_stripe_add_number_precision( $discount, $currency ),
				'type'        => 'discount'
			];
		}

		// Add fees (combined)
		if ( 0 < count( $order->get_fees() ) ) {
			$fee_total = 0;
			foreach ( $order->get_fees() as $fee ) {
				$fee_total += $fee->get_total();
			}
			$items[] = [
				'label'       => __( 'Fees', 'woo-stripe-payment' ),
				'amount'      => NumberUtil::round( $fee_total, 2 ),
				'amountCents' => wc_stripe_add_number_precision( $fee_total, $currency ),
				'type'        => 'fee'
			];
		}

		// Add taxes
		if ( 0 < $order->get_total_tax() ) {
			$items[] = [
				'label'       => __( 'Tax', 'woo-stripe-payment' ),
				'amount'      => NumberUtil::round( $order->get_total_tax(), 2 ),
				'amountCents' => wc_stripe_add_number_precision( $order->get_total_tax(), $currency ),
				'type'        => 'tax'
			];
		}

		return $items;
	}

	/**
	 * Get generic line items from product
	 *
	 * @param \WC_Product $product
	 *
	 * @return array
	 */
	private function get_line_items_from_product( $product ) {
		$currency = get_woocommerce_currency();
		$price    = wc_get_price_to_display( $product );

		return [
			[
				'label'       => $product->get_name(),
				'amount'      => NumberUtil::round( $price, 2 ),
				'amountCents' => wc_stripe_add_number_precision( $price, $currency ),
				'type'        => 'product'
			]
		];
	}

	/**
	 * Get generic shipping options from cart
	 *
	 * @param \WC_Cart|null $cart
	 *
	 * @return array
	 */
	private function get_shipping_options_from_cart( $cart ) {
		if ( ! $cart || ! $cart->needs_shipping() ) {
			return [];
		}

		$options  = [];
		$packages = WC()->shipping()->get_packages();
		$incl_tax = wc_tax_enabled() && $cart->display_prices_including_tax();
		$currency = get_woocommerce_currency();

		foreach ( $packages as $i => $package ) {
			foreach ( $package['rates'] as $rate ) {
				$cost        = (float) $rate->get_cost();
				$price       = $incl_tax ? $cost + (float) $rate->get_shipping_tax() : $cost;
				$description = '';
				if ( method_exists( $rate, 'get_description' ) ) {
					$description = $rate->get_description();
				}
				if ( ! $description && method_exists( $rate, 'get_delivery_time' ) ) {
					$description = $rate->get_delivery_time();
				}

				$options[] = [
					'id'          => sprintf( '%s:%s', $i, $rate->get_id() ),
					'label'       => $rate->get_label(),
					'amount'      => NumberUtil::round( $price, 2 ),
					'amountCents' => wc_stripe_add_number_precision( $price, $currency ),
					'description' => $description
				];
			}
		}

		return $options;
	}

	/**
	 * Get selected shipping method ID
	 *
	 * @return string
	 */
	private function get_selected_shipping_method() {
		if ( ! WC()->session ) {
			return '';
		}

		$chosen_methods = WC()->session->get( 'chosen_shipping_methods', [] );

		foreach ( $chosen_methods as $idx => $method ) {
			return sprintf( '%s:%s', $idx, $method );
		}

		return '';
	}

}