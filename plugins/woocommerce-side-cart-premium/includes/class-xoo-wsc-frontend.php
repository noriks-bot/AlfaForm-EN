<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_Wsc_Frontend{

	protected static $_instance = null;
	public $glSettings;
	public $sySettings;
	public $template_args = array();

	public $cartMarkupAdded = false;

	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct(){
		$this->glSettings = xoo_wsc_helper()->get_general_option();
		$this->sySettings = xoo_wsc_helper()->get_style_option();
		$this->hooks();
	}

	public function hooks(){

		add_action( 'wp_enqueue_scripts' ,array( $this,'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts' , array( $this,'enqueue_scripts' ), 15 );

		add_action( 'wp_body_open', array( $this, 'cart_markup' ) );
		add_action( 'wp_footer', array( $this, 'cart_markup' ) );

		add_shortcode( 'xoo_wsc_cart', array( $this, 'basket_shortcode' ) );

		add_action( 'wp', array( $this, 'basket_menu_filter' ) );

		/* Gifts */
		add_action( 'xoo_wsc_product_end', array( $this, 'gift_banner' ), 10, 2 );
		add_action( 'xoo_wsc_product_summary_col_end', array( $this, 'gift_price_html' ), 10, 2 );
		add_filter( 'xoo_wsc_product_args', array( $this, 'gift_product_args' ), 10, 4 );
		add_filter( 'woocommerce_before_calculate_totals', array( $this, 'set_gift_price' ), 1000, 1 );
		add_filter( 'woocommerce_cart_item_quantity', array( $this, 'disable_gift_cart_item_quantity' ), 1000, 3 );


		//Payment button hooks
		if( isset( $this->glSettings['scf-payment-btns'] ) ){

			$paymentBtns 			= $this->glSettings['scf-payment-btns'];
			$paymentBtnsLocation 	= $this->sySettings['scf-paybutton-pos'];

			foreach( $paymentBtnsLocation as $paybtn ) {
				if( !in_array( $paybtn, $paymentBtns ) ) continue;
				add_action( 'xoo_wsc_payment_buttons', array( $this, $paybtn.'_button' ) );
			}
		}

	}


	public function disable_gift_cart_item_quantity( $product_quantity, $cart_item_key, $cart_item ) {

		if ( is_cart() && isset( $cart_item['xoo_wsc_gift'] ) ) {
			$product_quantity = sprintf( '<strong>%s</strong><input type="hidden" name="cart[%s][qty]" value="%s" />', $cart_item['quantity'], $cart_item_key, $cart_item['quantity'] );
		}

		return $product_quantity;
	}

	public function set_gift_price($cart){
	
	    foreach ( $cart->get_cart() as $cart_item ) {
	    	if( isset( $cart_item['xoo_wsc_gift'] ) ){
	    		$cart_item['data']->set_price( 0 );
	    	}
	    }

	}

	public function gift_product_args( $args, $_product, $cart_item, $cart_item_key ){

		if( isset( $cart_item['xoo_wsc_gift'] ) ){

			$args['showPqty'] = false;

			foreach ($args['productClasses'] as $index => $class) {
				if( $class === 'xoo-wsc-is-parent' ){
					unset( $args['productClasses'][$index] );
				}
			}

		}

		return $args;
	}

	public function gift_price_html( $_product, $cart_item_key ){

		$cart_item = WC()->cart->get_cart_item( $cart_item_key );

		if( !isset( $cart_item['xoo_wsc_gift'] ) ) return;

		$product_price 	= wc_format_sale_price( $_product->get_regular_price(), 0 );

		echo '<div class="xoo-wsc-gift-price">'.$product_price.'</div>';

	}


	public function gift_banner( $_product, $cart_item_key ){

		$cart_item = WC()->cart->get_cart_item( $cart_item_key );

		if( !isset( $cart_item['xoo_wsc_gift'] ) ) return;
		?>
		<span class="xoo-wsc-gift-ban"><?php _e( 'Free Gift', 'side-cart-woocommerce' ) ?></span>
		<?php
	}


	public function basket_menu_filter(){
		$menu = $this->glSettings['shbk-menu'];
		if( !$menu || $menu === 'none' ) return;
		add_filter( 'wp_nav_menu_'.$menu.'_items', array( $this, 'basket_menu_html' ), 9999, 2 );
	}

	public function basket_menu_html( $items, $args ){

		$items .=  '<li class="menu-item xoo-wsc-menu-item">'.do_shortcode('[xoo_wsc_cart]').'</li>';

  		return $items;

	}


	//Enqueue stylesheets
	public function enqueue_styles(){

		if( !xoo_wsc()->isSideCartPage() ) return;

		if( !wp_style_is( 'select2' ) ){
			wp_enqueue_style( 'select2', "https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" );
		}

		//Light slider
		if( $this->glSettings['scsp-enable'] === 'yes' && ( !wp_is_mobile() || $this->glSettings['scsp-mob-enable'] === 'yes' ) ){
			wp_enqueue_style( 'lightslider', XOO_WSC_URL.'/assets/library/lightslider/css/lightslider.css', array(), '1.0' );
		}

		if( $this->sySettings['scb-playout'] === "cards" || $this->sySettings['scsp-style'] === 'column' || $this->sySettings['sl-style'] === 'column' ){
			wp_enqueue_style( 'xoo-wsc-magic', XOO_WSC_URL.'/library/magic/dist/magic.min.css', array(), '1.0' );
			wp_enqueue_script( 'xoo-wsc-masonry', XOO_WSC_URL.'/library/masonry/masonry.js', array(), '1.0', array( 'strategy' => 'defer', 'in_footer' => true ) );
		}

		//Fonts
		wp_enqueue_style( 'xoo-wsc-fonts', XOO_WSC_URL.'/assets/css/xoo-wsc-fonts.css', array(), XOO_WSC_VERSION );

		wp_enqueue_style( 'xoo-wsc-style', XOO_WSC_URL.'/assets/css/xoo-wsc-style.css', array(), XOO_WSC_VERSION );


		$inline_style =  xoo_wsc_helper()->get_template(
			'global/inline-style.php',
			array(
				'gl' 			=> xoo_wsc_helper()->get_general_option(),
				'sy' 			=> xoo_wsc_helper()->get_style_option()
			),
			'',
			true
		);

		$customCSS = html_entity_decode( xoo_wsc_helper()->get_advanced_option('m-custom-css') );

		wp_add_inline_style( 'xoo-wsc-style', $inline_style . $customCSS );

	}

	//Enqueue javascript
	public function enqueue_scripts(){

		if( !xoo_wsc()->isSideCartPage() ) return;

		$glSettings = $this->glSettings;
		$sySettings = $this->sySettings;

		//Shipping Calculator
		if( in_array( 'shipping_calc' , $glSettings['scf-show'] ) ){
			wp_enqueue_script( 'wc-country-select' );
			wp_enqueue_script( 'selectWoo' );
		}

		//Fly to cart
		if( $glSettings['m-flycart'] === "yes" ){
			wp_enqueue_script("jquery-effects-core");
			wp_enqueue_script('jquery-ui-core');
		}


		//woocommerce
		wp_enqueue_script( 'wc-add-to-cart' );

		//Paypal express checkout
		if( in_array( 'paypal', $this->glSettings['scf-payment-btns'] ) && !WC()->cart->is_empty() ){
			//wp_enqueue_script( 'wc-gateway-ppec-smart-payment-buttons' );
		}

		$strategy = array( 'strategy' => 'defer', 'in_footer' => true );

		//Light slider for related products
		if( $glSettings['scsp-enable'] === 'yes' && ( !wp_is_mobile() || $glSettings['scsp-mob-enable'] === 'yes' ) ){
			wp_enqueue_script( 'lightslider', XOO_WSC_URL.'/assets/library/lightslider/js/lightslider.js', array('jquery'), '1.0', $strategy ); 
		}


		if( $glSettings['scbar-en'] === 'yes' && ( $glSettings['scbar-one-celebrate'] !== 'none' || $glSettings['scbar-one-celebrate'] !== 'none' ) ){
			wp_enqueue_script( 'xoo-confetti', XOO_WSC_URL.'/assets/library/confetti/confetti.js', array('jquery'), '1.0', $strategy  );
		}


		if( is_product() ){
			$ajaxAtc = xoo_wsc_enable_ajax_atc_for_product( get_the_id() );
		}
		else{
			$ajaxAtc = $glSettings['m-ajax-atc'] !== 'no';
		}



		wp_enqueue_script( 'xoo-wsc-main-js', XOO_WSC_URL.'/assets/js/xoo-wsc-main.js', array('jquery'), XOO_WSC_VERSION, $strategy ); // Main JS

		$skipAjaxForData = array();

		if( function_exists('WCS_ATT') ){
			$skipAjaxForData['add-to-subscription'] = '';
		}

		$noticeMarkup = '<ul class="xoo-wsc-notices">%s</ul>';

		$params = array(
			'adminurl'  			=> admin_url().'admin-ajax.php',
			'wc_ajax_url' 		  	=> WC_AJAX::get_endpoint( "%%endpoint%%" ),
			'qtyUpdateDelay' 		=> (int) $glSettings['scb-update-delay'],
			'notificationTime' 		=> (int) $glSettings['sch-notify-time'],
			'html' 					=> array(
				'successNotice' =>	sprintf( $noticeMarkup, xoo_wsc_notice_html( '%s%', 'success' ) ),
				'errorNotice'	=> 	sprintf( $noticeMarkup, xoo_wsc_notice_html( '%s%', 'error' ) ),
			),
			'strings'				=> array(
				'maxQtyError' 			=> __( 'Only %s% in stock', 'side-cart-woocommerce' ),
				'stepQtyError' 			=> __( 'Quantity can only be purchased in multiple of %s%', 'side-cart-woocommerce' ),
				'calculateCheckout' 	=> __( 'Please use checkout form to calculate shipping', 'side-cart-woocommerce' ),
				'couponEmpty' 			=> __( 'Please enter promo code', 'side-cart-woocommerce' )
			),
			'nonces' => array(
				'update_shipping_method_nonce' => wp_create_nonce( 'update-shipping-method' )
			),
			'isCheckout' 			=> is_checkout(),
			'isCart' 				=> is_cart(),
			'sliderAutoClose' 		=> true,
			'shippingEnabled' 		=> in_array( 'shipping' , $glSettings['scf-show'] ),
			'couponsEnabled' 		=> in_array( 'coupon' , $glSettings['scf-show'] ),
			'autoOpenCart' 			=> $glSettings['m-auto-open'],
			'addedToCart' 			=> xoo_wsc_cart()->addedToCart,
			'ajaxAddToCart' 		=> $ajaxAtc ? 'yes' : 'no',
			'skipAjaxForData' 		=> $skipAjaxForData,
			'showBasket' 			=> $sySettings['sck-enable'],
			'flyToCart' 			=> $glSettings['m-flycart'],
			'flyToCartTime' 		=> apply_filters( 'xoo_wsc_flycart_animation_time', 1500 ),
			'productFlyClass' 		=> apply_filters( 'xoo_wsc_product_fly_class', '' ),
			'refreshCart' 			=> xoo_wsc_helper()->get_advanced_option('m-refresh-cart'),
			'fetchDelay' 			=> apply_filters( 'xoo_wsc_cart_fetch_delay', 200 ),
			'triggerClass' 			=> xoo_wsc_helper()->get_advanced_option('m-trigger-class'),
			'drawerWait' 			=> $sySettings['scs-drawer-wait'],
			'spSlide' 				=> array(
				'enable' 		=> $sySettings['scsp-slide-en'],
				'auto' 			=> $sySettings['scsp-slide-auto'] === 'yes',
				'pause' 		=> $sySettings['scsp-slide-timer'],
				'item' 			=> $sySettings['scsp-style'] === 'column' ? $sySettings['scsp-col-items'] : 1,
				'speed' 		=> 1400,
				'loop' 			=> true,
				'pauseOnHover' 	=> true
			),
			'cardAnimate' 			=> array(
				'enable' 	=> $sySettings['scbp-card-visible'] !== 'all_on_front' && !empty( $sySettings['scbp-card-back'] ) ? 'yes' : 'no',
				'type' 		=> $sySettings['scbp-card-anim-type'],
				'event' 	=> $sySettings['scbp-card-visible'],
				'duration' 	=> $sySettings['scbp-card-anim-time'],
			),
			'bar' => array(
				'singleCelebration' => $glSettings['scbar-one-celebrate'],
				'fullCelebration' 	=> $glSettings['scbar-all-celebrate']
			),
			'productLayout' 		=> $this->sySettings['scb-playout'],
			'saveForLaterNeedsLogin' => Xoo_Wsc_Template_Args::$saveForLaterNeedsLogin,
			'fetchCart' 			=> xoo_wsc_helper()->get_advanced_option('m-fetch-cart')
		);

		$params = apply_filters( 'xoo_wsc_localize_params', $params );

		wp_localize_script( 'xoo-wsc-main-js', 'xoo_wsc_params', $params );
	}


	public function isDrawerEmpty(){
		$suggestedProducts = xoo_wsc_cart()->get_suggested_products();
		return $this->sySettings['scsp-main-location'] !== 'drawer' || $this->glSettings['scsp-enable'] !== 'yes' || !$suggestedProducts || !$suggestedProducts->have_posts();
	}


	//Cart markup
	public function cart_markup(){

		if( !xoo_wsc()->isSideCartPage() || $this->cartMarkupAdded ) return;

		xoo_wsc_helper()->get_template( '/global/markup-notice.php' );
		
		xoo_wsc_helper()->get_template( 'xoo-wsc-markup.php' );

		$this->cartMarkupAdded = true;

	}


	public function get_button_classes( $view = 'array', $custom = array() ){

		$class = array_merge( $custom, array( 'xoo-wsc-btn' ) );

		if( xoo_wsc_helper()->get_style_option('scf-btns-theme') === 'theme' ){
			$class[] = 'button';
			$class[] = 'btn';
		}

		return $view === 'array' ? $class : implode( ' ' , $class);
	}


	public function basket_shortcode($atts){

		if( is_admin() || !xoo_wsc()->isSideCartPage() ) return;

		$atts = shortcode_atts( array(), $atts, 'xoo_wsc_cart');

		return xoo_wsc_helper()->get_template( 'xoo-wsc-shortcode.php', $atts, '', true );
	}


	//Paypal button
	public function paypal_button(){
		if( !in_array( 'paypal', $this->glSettings['scf-payment-btns'] ) || WC()->cart->is_empty() ) return;
		?>
		<div class="woocommerce-mini-cart__buttons xoo-wsc-payment-btns-cont">
			<p id="ppc-button-minicart" class="woocommerce-mini-cart__buttons buttons"></p>
		</div>
		<?php
	}

	//Amazon Pay
	public function amazon_button(){
		if( !in_array( 'amazon', $this->glSettings['scf-payment-btns'] ) || !function_exists( 'wc_apa' ) || WC()->cart->is_empty() ) return;
		wc_apa()->get_gateway()->maybe_separator_and_checkout_button();
	}

	//Google & Apple Pay
	public function gpay_button(){
		if( !in_array( 'gpay', $this->glSettings['scf-payment-btns'] ) || !class_exists('WC_Stripe_Field_Manager') || WC()->cart->is_empty() ) return;
		?>
		<div class="widget_shopping_cart_content"><?php echo WC_Stripe_Field_Manager::mini_cart_buttons(); ?></div>
		<?php
	}

}

function xoo_wsc_frontend(){
	return Xoo_Wsc_Frontend::get_instance();
}
xoo_wsc_frontend();