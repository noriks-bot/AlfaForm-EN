<?php

/**
 * Template Arguments
 */
class Xoo_Wsc_Template_Args{

	public static $gl;
	public static $sy;
	public static $av;

	public static $isSaveForLaterLoginSlider, $saveForLaterNeedsLogin;

	public static function declare_options(){
		self::$gl = xoo_wsc_helper()->get_general_option();
		self::$sy = xoo_wsc_helper()->get_style_option();
		self::$av = xoo_wsc_helper()->get_advanced_option();

		self::$saveForLaterNeedsLogin 		= !is_user_logged_in() && self::$gl['sl-disable-guest'] === "yes";
		self::$isSaveForLaterLoginSlider 	= self::$saveForLaterNeedsLogin && function_exists('xoo_el');
	}




	public static function cart_container(){

		$args = array(
			'showCount' 			=> self::$sy['sck-show-count'],
			'showBasket' 			=> self::$sy['sck-enable'],
			'basketIcon' 			=> esc_html( self::$sy['sck-basket-icon'] ),
			'customBasketIcon' 		=> esc_html( self::$sy['sck-cust-icon'] ),
			'drawerChevron' 		=> self::$sy['scm-open-from'] === 'left' ? 'right' : 'left',
			'isDrawerEmpty' 		=> xoo_wsc_frontend()->isDrawerEmpty(),
		);


		return apply_filters( 'xoo_wsc_cart_container_args', $args );
		
	}

	public static function cart_body(){

		$show 	= self::$gl['scb-show'];

		$args = array(
			'show' 				=> $show,
			'showPLink' 		=> in_array( 'product_link' , $show ),
			'pnameVariation' 	=> self::$gl['scb-pname-var'],
			'cartOrder'			=> self::$gl['m-cart-order'],
			'cart' 				=> self::$gl['m-cart-order'] === 'desc' ? array_reverse( WC()->cart->get_cart() ) : WC()->cart->get_cart(),
			'emptyCartImg' 		=> self::$sy['scb-empty-img'],
			'shopURL' 			=> self::$gl['m-shop-url'],
			'emptyText' 		=> self::$gl['sct-empty'],
			'shopBtnText' 		=> self::$gl['sct-shop-btn'],
			'buttonClass' 		=> xoo_wsc_frontend()->get_button_classes('text'),
			'priceFormat' 		=> self::$gl['scb-prod-price'],
			'pattern' 			=> self::$sy['scb-playout'] === 'cards' ? 'card' : 'row',
		);

		return apply_filters( 'xoo_wsc_cart_body_args', $args );

	}

	public static function markup_notice(){

		$show 	= self::$gl['sch-show'];

		$args = array(
			'showNotifications' => in_array( 'notifications' , $show ),
		);

		return apply_filters( 'xoo_wsc_markup_notice_args', $args );
	}


	public static function cart_header(){

		$show 	= self::$gl['sch-show'];

		$args = array(
			'heading' 					=> trim( esc_html( self::$gl['sct-cart-heading'] ) ),
			'showNotifications' 		=> in_array( 'notifications' , $show ),
			'showBasket' 				=> in_array( 'basket' , $show ),
			'showCloseIcon' 			=> in_array( 'close', $show ),
			'saveforLaterEnabled' 		=> self::$gl['sl-enable'] === "yes" && in_array( 'save', $show ),
			'savedForLaterHeading' 		=> esc_html( self::$gl['sct-sl-txt'] ),
			'close_icon' 				=> esc_html( self::$sy['sch-close-icon'] ),
			'saveForLaterIcon' 			=> esc_html( self::$sy['sl-icon'] ),
			'basketIcon' 				=> esc_html( self::$sy['sck-basket-icon'] ),
			'customBasketIcon' 			=> esc_html( self::$sy['sck-cust-icon'] ),
			'headerLayout' 				=> self::$sy['sch-layout'],
		);

		return apply_filters( 'xoo_wsc_cart_header_args', $args );
	}


	public static function cart_footer(){

		$show 	= self::$gl['scf-show'];

		$args = array(
			
		);

		return apply_filters( 'xoo_wsc_cart_footer_args', $args );

	}


	public static function slider(){

		$show 	= self::$gl['scf-show'];

		$args = array(
			'showShipping' 				=> in_array( 'shipping' , $show ),
			'showCoupon' 				=> in_array( 'coupon' , $show ),
			'showNotifications' 		=> in_array( 'notifications', self::$gl['sch-show'] ),
			'showSaveLater' 			=> self::$gl['sl-enable'] === 'yes'
		);

		return apply_filters( 'xoo_wsc_slider_args', $args );

	}

	public static function drawer(){

		$args = array(
			'showNotifications' => in_array( 'notifications', self::$gl['sch-show'] ),
			'drawerChevron' 	=> self::$sy['scm-open-from']
		);

		return apply_filters( 'xoo_wsc_drawer_args', $args );

	}

	public static function drawer_header(){

		$args = array(
			'openDirection' => self::$sy['scm-open-from']
		);

		return apply_filters( 'xoo_wsc_drawer_header_args', $args );

	}


	public static function cart_shortcode(){

		$args = array(
			'icon' 				=> in_array( 'icon', self::$gl['shbk-show'] ) ? 'yes' : 'no',
			'count' 			=> in_array( 'count', self::$gl['shbk-show'] ) ? 'yes' : 'no',
			'subtotal' 			=> in_array( 'subtotal', self::$gl['shbk-show'] ) ? 'yes' : 'no',
			'basketIcon' 		=> esc_html( self::$sy['sck-basket-icon'] ),
			'customBasketIcon' 	=> esc_html( self::$sy['sck-cust-icon'] )
		);


		return apply_filters( 'xoo_wsc_slider_args', $args );

	}

	public static function product( $_product, $cart_item, $cart_item_key, $cart_item_args = array() ){

		$bundleData = isset( $cart_item_args['bundleData'] ) ? $cart_item_args['bundleData'] : array();

		$productClasses = array(
			'xoo-wsc-product'
		);

		
		$show 						= self::$gl['scb-show'];
		$showPimage 				= in_array( 'product_image' , $show );
		$showPdel 					= in_array( 'product_del', $show );
		$showPprice 				= in_array( 'product_price' , $show );
		$showPtotal 				= in_array( 'product_total' , $show );
		$showPqty 					= in_array( 'product_qty', $show );
		$showSalesCount 			= in_array( 'total_sales', $show );
		$updateQty 					= !$_product->is_sold_individually() && self::$gl['scb-update-qty'] === "yes";
		$saveforLaterEnabled 		= self::$gl['sl-enable'] === "yes";
 

		if( !empty( $bundleData ) ){
			
			$productClasses[] 		= 'xoo-wsc-is-'.$bundleData['type'];
			$productClasses[] 		= 'xoo-wsc-'.$bundleData['key'];
			$showPimage 			= !$bundleData['image'] ? false : $showPimage;
			$updateQty 				= $bundleData['qtyUpdate'];
			$showPprice 			= $showSalesCount = false;
			$showPdel 				= !$bundleData['delete'] ? false : $showPdel;
			$saveforLaterEnabled 	= isset( $bundleData['save'] ) ? $bundleData['save'] : $saveforLaterEnabled; 
		}


		$args = array(
			'showPimage' 				=> $showPimage,
			'updateQty' 				=> $updateQty,
			'showSalesCount' 			=> $showSalesCount,
			'showPprice' 				=> $showPprice,
			'showPdel' 					=> $showPdel,
			'productClasses' 			=> $productClasses,
			'showPname' 				=> in_array( 'product_name' , $show ),
			'showPtotal' 				=> in_array( 'product_total' , $show ),
			'showPmeta' 				=> in_array( 'product_meta' , $show ),
			'showPqty' 					=> in_array( 'product_qty', $show ),
			'close_icon' 				=> esc_html( self::$sy['sch-close-icon'] ),
			'save_icon' 				=> esc_html( self::$sy['sl-icon'] ),
			'qtyPriceDisplay' 			=> self::$gl['scbp-qpdisplay'],
			'deletePosition' 			=> self::$sy['scbp-delpos'],
			'delete_icon' 				=> esc_html( self::$sy['scb-del-icon'] ),
			'deleteType' 				=> self::$sy['scbp-deltype'],
			'deleteText' 				=> self::$gl['sct-delete'],
			'oneLiner'  				=> self::$gl['scbp-qpdisplay'] === 'one_liner' && $showPprice && $showPtotal && $showPqty && !$updateQty,
			'saveforLaterEnabled' 		=> $saveforLaterEnabled
		);

		$args = wp_parse_args( $args, $cart_item_args );

		return apply_filters( 'xoo_wsc_product_args', $args, $_product, $cart_item, $cart_item_key );

	}


	public static function shipping_bar(){

		$show 			= self::$gl['sch-show'];
		$data 			= xoo_wsc_cart()->get_shipping_bar_data();

		$args = array(
			'showBar' 	=> in_array( 'shipping_bar', $show ),
			'data' 		=> $data
		);


		if( !empty( $data ) ){
			$args['text']  	= $data['free'] ? self::$gl['sct-sb-free'] : str_replace( '%s', wc_price( $data['amount_left'] ), self::$gl['sct-sb-remaining']);
		}
	
		return apply_filters( 'xoo_wsc_shipping_bar_args', $args );

	}


	public static function progress_bar(){

		$enable 		= self::$gl['scbar-en'];
		$points 		= xoo_wsc_cart()->get_bar_checkpoints();
		$args 			= array();

		if( $enable !== 'yes' || empty($points) ) return $args;

		$freeShippingpoint = $freeshippingdata = '';

		foreach ( $points as $index => $point) {
			if( $point['type'] === 'freeshipping' ){
				$freeshippingdata 	= xoo_wsc_cart()->get_free_shipping_method_bar_data();
				if( empty( $freeshippingdata ) ){
					unset( $points[$index] );
				}
				else{
					$freeShippingpoint = $point;
					$points[$index]['amount'] = $freeshippingdata['amount'];
				}
				break;
			}
		}

		if( empty( $points ) ) return $args;

		$cartval 		= xoo_wsc_cart()->bar_cart_value();
		$divide 		= self::$gl['scbar-divide'];

		usort( $points , function( $a, $b ){
			if( $a['amount'] === $b['amount'] ) return 0;
			return $a['amount'] < $b['amount'] ? -1 : 1;
		} );


		$barTotal 		= (end($points))['amount'];
		$currentPoint 	= $currentPointIndex = null;

		$lastPointweight = 0;

		foreach ( $points as $index => $point ) {

			if( !$currentPoint && $cartval < $point['amount'] ){
				$currentPoint = $point;
				$currentPointIndex = $index;
			}

			$weight =  ( $point['amount']/$barTotal ) * 100;
			$width  = $weight - $lastPointweight;

			$points[$index]['width'] 	= $width;
			$points[$index]['weight'] 	= $lastPointweight = $weight;
			$points[$index]['reached'] 	= $cartval >= $point['amount'];

		}

		$remainingText = $currentPoint ? str_replace( '[amount]' , wc_price( $currentPoint['amount'] - $cartval  ), $currentPoint['remaining'] ) : self::$gl['scbar-comptext']; 

		if( $divide === 'prop' ){
			$filled = ($cartval/$barTotal) * 100;
		}
		else{

			if( !$currentPoint ){
				$filled = 100;
			}
			else{

				$eachPointWidth 	= 100/count($points);

				$beforePointIndex 	= $currentPointIndex - 1;

				$beforePointAmt 	= isset( $points[ $beforePointIndex ] ) ? $points[ $beforePointIndex ]['amount'] : 0;

				$currentPointFilled = ( ( ( $cartval - $beforePointAmt )/( $currentPoint['amount'] - $beforePointAmt ) ) * 100 ); // % Achieved of current point

				$filled = ( ($currentPointFilled * $eachPointWidth)/100 )  + ( $currentPointIndex * $eachPointWidth ); // % achieved of total bar.

			}
			
		}

		$args = array(
			'enable' 		=> $enable,
			'points' 		=> $points,
			'cartval' 		=> $cartval,
			'barTotal' 		=> $barTotal,
			'filled' 		=> $filled > 100 ? 100 : $filled,
			'remainingText' => $remainingText,
			'divide' 		=> self::$gl['scbar-divide'],
			'show' 			=> self::$gl['scbar-show'],
		);


		return apply_filters( 'xoo_wsc_progress_bar_args', $args );

	}

	public static function footer_buttons(){

		$show 			= self::$gl['scf-show'];
		$buttonOrder 	= self::$sy['scf-button-pos'];
		$checkoutTxt	= esc_html( self::$gl['sct-ft-chkbtn'] );
		$buttonDesign 	= self::$sy['scf-btns-theme'];
		$buttonClass 	=  xoo_wsc_frontend()->get_button_classes( 'array', array( 'xoo-wsc-ft-btn' ) );

		$isChkoutLogin 	= !is_user_logged_in() && self::$gl['scf-chklogin-en'] === "yes" && function_exists('xoo_el');

		$chkoutBtnClass = $isChkoutLogin ? array_merge( $buttonClass, array( 'xoo-el-login-tgr' ) ) : $buttonClass;	


		$checkoutTotal = self::$gl['scf-chkbtntotal-en'] === 'yes' ? WC()->cart->get_total() : '';
		


		$buttons = array(
			'continue' 		=> array(
				'label' => self::$gl['sct-ft-contbtn'],
				'url' 	=> self::$gl['scu-continue'],
				'class' => $buttonClass,
			), 
			'cart' 			=>  array(
				'label' => self::$gl['sct-ft-cartbtn'],
				'url' 	=> self::$gl['scu-cart'],
				'class' => $buttonClass,
			),
			'checkout' 		=> array(
				'label' => self::$gl['sct-ft-chkbtn'] . $checkoutTotal ,
				'url' 	=> self::$gl['scu-checkout'],
				'class' => $chkoutBtnClass,
			)
		);

		if( $buttons['continue']['url'] === "#" ){
			$buttons['continue']['class'][] = 'xoo-wsc-cart-close';
		}


		$buttons = array_merge( array_flip( $buttonOrder ), $buttons );

		if( $isChkoutLogin ){
			$buttons['checkout']['data'] = 'data-redirect="'.$buttons['checkout']['url'].'"'; 
		}

		//Remove cart & checkout button if cart is empty
		if( WC()->cart->is_empty() ){
			unset( $buttons['cart'] );
			unset( $buttons['checkout'] );
		}
		
		$args = array(
			'buttons' => $buttons
		);

		return apply_filters( 'xoo_wsc_footer_buttons_args', $args );
	}

	public static function footer_extras(){

		$show 				= self::$gl['scf-show'];

		$args = array(
			'showCoupon'	=> in_array( 'coupon' , $show ),
			'couponLoc' 	=> self::$sy['scf-coup-display'],
			'couponIcon' 	=> esc_html( self::$sy['scf-coup-icon'] ),
			'delete_icon' 	=> esc_html( self::$sy['scb-del-icon'] ),
			'emptyCartLink' => in_array( 'empty_cart', self::$gl['scf-show'] ),
		);

		return apply_filters( 'xoo_wsc_footer_extras_args', $args );
	}


	public static function saved_for_later(){
		
		$savedItems = xoo_wsc_cart()->get_saved_for_later_items(true);

		$show 		= self::$gl['sl-show'];

		$args = array(
			'savedItems' 	=> $savedItems,
			'showPLink' 	=> in_array( 'product_link' , self::$gl['scb-show'] ),
			'showTitle' 	=> in_array( 'title', $show ),
			'showImage' 	=> in_array( 'image', $show ),
			'showPrice' 	=> in_array( 'price', $show ),
			'showATC' 		=> in_array( 'addtocart', $show ),
			'style' 		=> esc_html( self::$sy['sl-style'] ),
			'heading' 		=> esc_html( self::$gl['sct-sl-txt'] ),
			'delete_icon' 		=> esc_html( self::$sy['scb-del-icon'] ),
			'deleteType' 		=> self::$sy['scbp-deltype'],
			'deleteText' 		=> self::$gl['sct-delete'],
			'pnameVariation' 	=> self::$gl['scb-pname-var'],
			'basketIcon' 		=> esc_html( self::$sy['sck-basket-icon'] ),
		);

		return apply_filters( 'xoo_wsc_saved_for_later_items_args', $args );
	}


	public static function suggested_products(){

		if( !(self::$gl['scsp-enable'] !== 'yes' || ( wp_is_mobile() && self::$gl['scsp-mob-enable'] !== 'yes' ) ) ){
			$products 	= xoo_wsc_cart()->get_suggested_products();
		}

		$show 			= self::$gl['scsp-show'];

		$args = array(
			'disable' 		=> !isset($products) || !$products || !$products->have_posts(),
			'products' 		=> $products,
			'showPLink' 	=> in_array( 'product_link' , self::$gl['scb-show'] ),
			'showTitle' 	=> in_array( 'title', $show ),
			'showImage' 	=> in_array( 'image', $show ),
			'showDesc' 		=> in_array( 'desc', $show ),
			'showPrice' 	=> in_array( 'price', $show ),
			'showATC' 		=> in_array( 'addtocart', $show ),
			'style' 		=> esc_html( self::$sy['scsp-style'] ),
			'heading' 		=> esc_html( self::$gl['sct-sp-txt'] )
		);

		return apply_filters( 'xoo_wsc_suggested_product_args', $args );
	}


	public static function suggested_products_drawer(){

		$products 		= xoo_wsc_cart()->get_suggested_products();

		$args = array(
			'enable' 	=> xoo_wsc_frontend()->isDrawerEmpty()  ? 'no' : 'yes',
			'heading' 	=> esc_html( self::$gl['sct-sp-txt'] ),

		);

		return apply_filters( 'xoo_wsc_suggested_product_drawer_args', $args );

	}

	public static function footer_totals(){

		$args = array(
			'totals' => xoo_wsc_cart()->get_totals()
		);

		return apply_filters( 'xoo_wsc_footer_totals_args', $args );
	}

}

Xoo_Wsc_Template_Args::declare_options();