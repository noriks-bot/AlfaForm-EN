<?php
defined( 'ABSPATH' ) || exit();

if ( ! class_exists( 'WC_Payment_Gateway_Stripe' ) ) {
	return;
}

/**
 * This gateway is provided so merchants can accept Chrome Payments, Microsoft Pay, etc.
 *
 * @author  PaymentPlugins
 * @package PaymentPlugins\Gateways
 *
 */
class WC_Payment_Gateway_Stripe_Payment_Request extends WC_Payment_Gateway_Stripe {

	use WC_Stripe_Payment_Intent_Trait;

	//use WC_Stripe_Express_Payment_Trait;

	protected $payment_method_type = 'card';

	private $supported_locales = [
		'ar',
		'bg',
		'cs',
		'da',
		'de',
		'el',
		'en',
		'en-GB',
		'es',
		'es-419',
		'et',
		'fi',
		'fil',
		'fr',
		'fr-CA',
		'he',
		'hr',
		'hu',
		'id',
		'it',
		'ja',
		'ko',
		'lt',
		'lv',
		'ms',
		'mt',
		'nb',
		'nl',
		'pl',
		'pt-BR',
		'pt',
		'ro',
		'ru',
		'sk',
		'sl',
		'sv',
		'th',
		'tr',
		'vi',
		'zh',
		'zh-HK',
		'zh-TW'
	];

	public function __construct() {
		$this->id                 = 'stripe_payment_request';
		$this->tab_title          = __( 'PaymentRequest Gateway', 'woo-stripe-payment' );
		$this->template_name      = 'payment-request.php';
		$this->token_type         = 'Stripe_CC';
		$this->method_title       = __( 'Payment Request (Stripe) by Payment Plugins', 'woo-stripe-payment' );
		$this->method_description = __( 'Google Pay gateway that integrates with your Stripe account.', 'woo-stripe-payment' );
		$this->has_digital_wallet = true;
		$this->icon               = stripe_wc()->assets_url( 'img/googlepay_round_outline.svg' );
		parent::__construct();
	}

	public function init_supports() {
		parent::init_supports();
		$this->supports[] = 'wc_stripe_cart_checkout';
		$this->supports[] = 'wc_stripe_product_checkout';
		$this->supports[] = 'wc_stripe_banner_checkout';
		$this->supports[] = 'wc_stripe_mini_cart_checkout';
	}

	public function enqueue_product_scripts( $scripts ) {
		wp_enqueue_script( 'wc-stripe-payment-request-product' );
		$scripts->localize_script( 'payment-request-product', $this->get_localized_params() );
	}

	public function enqueue_cart_scripts( $scripts ) {
		wp_enqueue_script( 'wc-stripe-payment-request-cart' );
		$scripts->localize_script( 'payment-request-cart', $this->get_localized_params() );
	}

	public function enqueue_checkout_scripts( $scripts ) {
		wp_enqueue_script( 'wc-stripe-payment-request-checkout' );
		if ( $this->banner_checkout_enabled() ) {
			wp_enqueue_script( 'wc-stripe-payment-request-express-checkout' );
		}
		$scripts->localize_script( 'payment-request-checkout', $this->get_localized_params() );
	}

	public function enqueue_mini_cart_scripts( $scripts ) {
		wp_enqueue_script( 'wc-stripe-payment-request-minicart' );
		$data         = $this->get_localized_params();
		$data['page'] = 'cart';
		if ( WC()->cart ) {
			$data['currency']         = get_woocommerce_currency();
			$data['total_cents']      = (float) wc_stripe_add_number_precision( WC()->cart->get_total( 'float' ) );
			$data['items']            = $this->get_display_items_for_cart( WC()->cart );
			$data['needs_shipping']   = WC()->cart->needs_shipping();
			$data['shipping_options'] = $this->get_formatted_shipping_methods();
		}
		$scripts->localize_script( 'payment-request-minicart', $data, 'wc_stripe_payment_request_mini_cart_params' );
	}

	public function get_localized_params() {
		$data = array_merge_recursive(
			parent::get_localized_params(),
			array(
				'button'         => array(
					'type'   => $this->get_option( 'button_type' ),
					'theme'  => $this->get_option( 'button_theme' ),
					'height' => $this->get_button_height(),
				),
				'button_options' => array(
					'height' => (int) $this->get_option( 'button_height', 40 ),
					'radius' => (int) $this->get_option( 'button_radius', 4 ) . 'px',
					'theme'  => $this->get_button_theme(),
					'type'   => $this->get_button_type()
				),
				'button_radius'  => $this->get_option( 'button_radius', 4 ) . 'px',
				'icons'          => array( 'chrome' => stripe_wc()->assets_url( 'img/chrome.svg' ) ),
				'messages'       => array(
					'invalid_amount' => __( 'Please update you product quantity before paying.', 'woo-stripe-payment' ),
					'add_to_cart'    => __( 'Adding to cart...', 'woo-stripe-payment' ),
					'choose_product' => __( 'Please select a product option before updating quantity.', 'woo-stripe-payment' ),
				),
				'display_rule'   => wc_string_to_bool( $this->get_option( 'all_browsers', 'yes' ) ) ? 'always' : 'auto'
			)
		);
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
		} else {
			if ( WC()->cart ) {
				$data['currency']         = get_woocommerce_currency();
				$data['total_cents']      = (float) wc_stripe_add_number_precision( WC()->cart->get_total( 'float' ) );
				$data['items']            = $this->get_display_items( $data['page'] );
				$data['needs_shipping']   = WC()->cart->needs_shipping();
				$data['shipping_options'] = $this->get_formatted_shipping_methods();
			}
		}

		return $data;
	}

	public function get_button_height() {
		$value = $this->get_option( 'button_height' );
		$value .= strpos( $value, 'px' ) === false ? 'px' : '';

		return $value;
	}

	public function has_enqueued_scripts( $scripts ) {
		return wp_script_is( $scripts->get_handle( 'payment-request-checkout' ) );
	}

	protected function get_element_options_locale() {
		$locale = wc_stripe_get_site_locale();

		if ( $locale === 'auto' ) {
			return $locale;
		}

		if ( in_array( $locale, $this->supported_locales ) ) {
			return $locale;
		}

		$formatted_locale = substr( $locale, 0, 2 );

		if ( in_array( $formatted_locale, $this->supported_locales ) ) {
			$locale = $formatted_locale;
		}

		return $locale;
	}

	private function get_button_theme() {
		$theme = $this->get_option( 'button_theme', 'black' );
		switch ( $theme ) {
			case 'dark':
				$theme = 'black';
				break;
			default:
				$theme = 'white';
				break;
		}

		return $theme;
	}

	private function get_button_type() {
		$type = $this->get_option( 'button_type', 'default' );
		switch ( $type ) {
			case 'default':
				$type = 'plain';
				break;
		}

		return $type;
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

}
