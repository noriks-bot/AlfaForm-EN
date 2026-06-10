<?php

/**
 * @package PaymentPlugins\Gateways
 */
class WC_Payment_Gateway_Stripe_Link extends \WC_Payment_Gateway_Stripe {

	use WC_Stripe_Payment_Intent_Trait;

	//use WC_Stripe_Express_Payment_Trait;

	public $id = 'stripe_link_checkout';

	public $payment_method_type = 'link';

	protected $has_digital_wallet = true;

	public function __construct() {
		$this->id                 = 'stripe_link_checkout';
		$this->tab_title          = __( 'Link Checkout', 'woo-stripe-payment' );
		$this->template_name      = '';
		$this->token_type         = 'Stripe_CC';
		$this->method_title       = __( 'Link Checkout (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Link Checkout gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		parent::__construct();
		$this->title = __( 'Link Checkout', 'woo-stripe-payment' );
	}

	public function init_supports() {
		parent::init_supports();
		$this->supports[] = 'wc_stripe_cart_checkout';
		$this->supports[] = 'wc_stripe_product_checkout';
		$this->supports[] = 'wc_stripe_banner_checkout';
		//$this->supports[] = 'wc_stripe_mini_cart_checkout';
	}

	public function init_form_fields() {
		$this->form_fields = array(
			'link_title'       => array(
				'title' => __( 'Link Checkout', 'woo-stripe-payment' ),
				'type'  => 'title'
			),
			'enabled'          => array(
				'title'       => __( 'Enabled', 'woo-stripe-payment' ),
				'type'        => 'checkbox',
				'default'     => 'no',
				'value'       => 'yes',
				'desc_tip'    => true,
				'description' => __( 'If enabled, Link Checkout will be available in the locations configured.', 'woo-stripe-payment' ),
			),
			'payment_sections' => array(
				'title'             => __( 'Link Checkout Locations', 'woo-stripe-payment' ),
				'type'              => 'multiselect',
				'class'             => 'wc-enhanced-select',
				'options'           => array(
					'product'         => __( 'Product Page', 'woo-stripe-payment' ),
					'cart'            => __( 'Cart Page', 'woo-stripe-payment' ),
					//'mini_cart'       => __( 'Mini Cart', 'woo-stripe-payment' ),
					'checkout_banner' => __( 'Express Checkout', 'woo-stripe-payment' ),
				),
				'sanitize_callback' => function ( $value ) {
					if ( empty( $value ) ) {
						$value = array();
					}

					return $value;
				},
				'default'           => array( 'cart', 'checkout_banner' ),
				'description'       => __( 'Select where Link Express Checkout buttons will appear. Express Checkout allows customers to pay instantly using their saved payment and shipping information from Link, similar to Apple Pay or Google Pay.', 'woo-stripe-payment' )
			),
			'charge_type'      => array(
				'type'        => 'select',
				'title'       => __( 'Charge Type', 'woo-stripe-payment' ),
				'default'     => 'capture',
				'class'       => 'wc-enhanced-select',
				'options'     => array(
					'capture'   => __( 'Capture', 'woo-stripe-payment' ),
					'authorize' => __( 'Authorize', 'woo-stripe-payment' ),
				),
				'desc_tip'    => true,
				'description' => __( 'This option determines whether the customer\'s funds are captured immediately or authorized and can be captured at a later date.', 'woo-stripe-payment' ),
			),
			'order_status'     => array(
				'type'        => 'select',
				'title'       => __( 'Order Status', 'woo-stripe-payment' ),
				'default'     => 'default',
				'class'       => 'wc-enhanced-select',
				'options'     => array_merge( array( 'default' => __( 'Default', 'woo-stripe-payment' ) ), wc_get_order_statuses() ),
				'description' => __( 'This is the status of the order once payment is complete. If <b>Default</b> is selected, then WooCommerce will set the order status automatically based on internal logic which states if a product is virtual and downloadable then status is set to complete. Products that require shipping are set to Processing. Default is the recommended setting as it allows standard WooCommerce code to process the order status.',
					'woo-stripe-payment' ),
			),
			'button_height'    => array(
				'title'             => __( 'Button Height', 'woo-stripe-payment' ),
				'type'              => 'number',
				'default'           => 40,
				'desc_tip'          => true,
				'description'       => __( 'Button height for the Link Checkout button. The button height must be between 40px and 55px.', 'woo-stripe-gateway' ),
				'sanitize_callback' => function ( $value ) {
					if ( ! is_numeric( $value ) ) {
						$value = 40;
					}

					return max( 40, min( 55, $value ) );
				}
			),
			'button_radius'    => array(
				'title'             => __( 'Button Radius', 'woo-stripe-payment' ),
				'type'              => 'number',
				'class'             => 'button-radius',
				'default'           => '4',
				'description'       => __( 'The border radius of the button.', 'woo-stripe-payment' ),
				'sanitize_callback' => function ( $value ) {
					if ( ! preg_match( '/^[\d]+$/', $value ) ) {
						$value = 0;
					}

					return absint( $value );
				}
			),
		);
	}

	public function payment_fields() {
	}

	public function product_fields() {
		$this->enqueue_frontend_scripts( 'product' );
		$data = $this->get_localized_params();

		wp_localize_script( 'wc-stripe-link-express-product', 'wc_stripe_link_product_params', $this->get_localized_params() );

		$json = wc_esc_json( wp_json_encode( $data ) );
		printf( '<input type="hidden" class="%1$s" data-gateway="%2$s"/>', "woocommerce_{$this->id}_gateway_data {$data['page']}-page", $json );
		?>
        <div id="wc-stripe-link-element"></div>
		<?php
	}

	public function cart_fields() {
		$data       = $this->get_localized_params();
		$valid_keys = [
			'currency',
			'total_cents',
			'items',
			'needs_shipping',
			'shipping_options',
			'elementOptions'
		];
		$params     = array_intersect_key( $data, array_flip( $valid_keys ) );
		$json       = wc_esc_json( wp_json_encode( $params ) );
		printf( '<input type="hidden" class="%1$s" data-gateway="%2$s"/>', "woocommerce_{$this->id}_gateway_data {$data['page']}-page", $json );
		$this->enqueue_frontend_scripts( 'cart' );
		wp_localize_script( 'wc-stripe-link-express-cart', 'wc_stripe_link_cart_params', $data );
		?>
        <div id="wc-stripe-link-checkout-container"></div>
		<?php
	}

	public function enqueue_cart_scripts( $scripts ) {
		wp_enqueue_script( 'wc-stripe-link-express-cart' );
	}

	public function enqueue_product_scripts( $scripts ) {
		wp_enqueue_script( 'wc-stripe-link-express-product' );
	}

	public function enqueue_express_checkout_scripts() {
		wp_localize_script( 'wc-stripe-link-express-checkout', 'wc_stripe_link_checkout_params', $this->get_localized_params() );
		wp_enqueue_script( 'wc-stripe-link-express-checkout' );
	}

	/**
	 * @param float  $price
	 * @param string $label
	 * @param string $type
	 * @param mixed  ...$args
	 *
	 * @return array
	 * @since 3.2.1
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
	 * @return array
	 * @since 3.2.1
	 *
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
		return array(
			'id'          => $this->get_shipping_method_id( $rate->id, $i ),
			'amount'      => wc_stripe_add_number_precision( $price ),
			'displayName' => $this->get_formatted_shipping_label( $price, $rate, $incl_tax )
		);
	}

	public function get_localized_params() {
		$data = parent::get_localized_params();
		if ( in_array( $data['page'], array( 'cart', 'checkout', 'shop' ) ) ) {
			$data['currency']         = get_woocommerce_currency();
			$data['total_cents']      = (float) wc_stripe_add_number_precision( WC()->cart->get_total( 'float' ) );
			$data['items']            = $this->get_display_items( $data['page'] );
			$data['needs_shipping']   = WC()->cart->needs_shipping();
			$data['shipping_options'] = $this->get_formatted_shipping_methods();
		} elseif ( $data['page'] === 'order_pay' ) {
			global $wp;
			$order                    = wc_get_order( absint( $wp->query_vars['order-pay'] ) );
			$data['currency']         = get_woocommerce_currency();
			$data['total_cents']      = (float) wc_stripe_add_number_precision( $order->get_total() );
			$data['items']            = $this->get_display_items( $data['page'], $order );
			$data['needs_shipping']   = false;
			$data['shipping_options'] = array();
		} elseif ( $data['page'] === 'product' ) {
			global $product;
			if ( $product instanceof WC_Product ) {
				$price = wc_get_price_to_display( $product );
				if ( $product->get_type() === 'variable' ) {
					$data['needs_shipping'] = false;
					$variations             = \PaymentPlugins\Stripe\Utilities\ProductUtils::get_product_variations( $product );
					if ( ! empty( $variations ) ) {
						foreach ( $variations as $variation ) {
							if ( $variation && $variation->needs_shipping() ) {
								$data['needs_shipping'] = true;
								break;
							}
						}
					}
				} else {
					$data['needs_shipping'] = $product->needs_shipping();
				}
				$data['currency']         = get_woocommerce_currency();
				$data['total_cents']      = (float) wc_stripe_add_number_precision( $price, get_woocommerce_currency() );
				$data['items']            = array( $this->get_display_item_for_product( $product ) );
				$data['shipping_options'] = array();
				$data['product']          = array(
					'id'          => $product->get_id(),
					'price'       => (float) $price,
					'price_cents' => (float) wc_stripe_add_number_precision( $price, get_woocommerce_currency() ),
					'variation'   => false,
					'is_in_stock' => $product->is_in_stock()
				);
			}
		}

		$data['button'] = array(
			'height' => (int) $this->get_option( 'button_height', 40 ),
			'radius' => $this->get_option( 'button_radius', 4 ) . 'px',
		);

		return $data;
	}

}