<?php

function xoo_wsc_quantity_input( $args = array(), $product = null, $echo = true ) {

	if ( is_null( $product ) ) {
		return;
	}

	$defaults = array(
		'input_value'  	=> '1',
		'max_value'    	=> apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
		'min_value'    	=> apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
		'step'         	=> apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
		'pattern'      	=> apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' ),
		'inputmode'    	=> apply_filters( 'woocommerce_quantity_input_inputmode', has_filter( 'woocommerce_stock_amount', 'intval' ) ? 'numeric' : '' ),
		'placeholder'  	=> apply_filters( 'woocommerce_quantity_input_placeholder', '', $product ),
		'wsc_classes'  	=> apply_filters( 'xoo_wsc_quantity_input_classes', array( 'xoo-wsc-qty' ), $product ),
		'qtyDesign' 	=> xoo_wsc_helper()->get_style_option('scbq-style')
	);

	$args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );

	// Apply sanity to min/max args - min cannot be lower than 0.
	$args['min_value'] = max( $args['min_value'], 0 );
	$args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : '';

	// Max cannot be lower than min if defined.
	if ( '' !== $args['max_value'] && $args['max_value'] < $args['min_value'] ) {
		$args['max_value'] = $args['min_value'];
	}

	ob_start();

	xoo_wsc_helper()->get_template( 'global/body/qty-input.php', $args );

	if ( $echo ) {
		echo ob_get_clean(); // WPCS: XSS ok.
	} else {
		return ob_get_clean();
	}
}

function xoo_wsc_notice_html( $message, $notice_type = 'success' ){
	
	$classes = $notice_type === 'error' ? 'xoo-wsc-notice-error' : 'xoo-wsc-notice-success';

	$icon = $notice_type === 'error' ? 'xoo-wsc-icon-cross' : 'xoo-wsc-icon-check_circle';
	
	$html = '<li class="'.$classes.'"><span class="'.$icon.'"></span>'.$message.'</li>';
	
	return apply_filters( 'xoo_wsc_notice_html', $html, $message, $notice_type );
}



function xoo_wsc_suggested_product_addtocart_link( $link, $product, $args ){

	if( !isset( $args['is_xoo_wsc_sp'] ) ) return $link;

	return sprintf(
		'<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		'<span>+</span>'. __( 'Add', 'side-cart-woocommerce' )
	);
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'xoo_wsc_suggested_product_addtocart_link', 999, 3 );


function xoo_wsc_add_flytocart_img_attr( $attr, $attachment, $size ){
	global $product;
	if( $product ){
		$attr['data-xooWscFly'] = 'fly';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'xoo_wsc_add_flytocart_img_attr', 999, 3 );


function xoo_wsc_display_suggested_products(){
	xoo_wsc_helper()->get_template( 'global/footer/suggested-products.php' );
}


function xoo_wsc_add_sp(){

	$location 	= xoo_wsc_helper()->get_style_option('scsp-main-location');

	if( $location === 'before' || wp_is_mobile() ){
		$hook = 'xoo_wsc_body_end';
	}
	elseif( $location === 'after' ){
		$hook = 'xoo_wsc_footer_end';
	}
	else{
		return;
	}

	add_action( $hook, 'xoo_wsc_display_suggested_products' );

}
add_action( 'xoo_wsc_header_start', 'xoo_wsc_add_sp' );



function xoo_wsc_totals_set_location(){
	$locationHook = xoo_wsc_helper()->get_style_option('scf-totals-loc') === 'body' || ( wp_is_mobile() && xoo_wsc_helper()->get_style_option('scf-totals-loc') === 'mobile_body' ) ? 'xoo_wsc_body_end' : 'xoo_wsc_footer_content';
	add_action( $locationHook, 'xoo_wsc_footer_totals_html', 20 );
}

add_action( 'xoo_wsc_header_start', 'xoo_wsc_totals_set_location' );

function xoo_wsc_footer_extras_html(){
	xoo_wsc_helper()->get_template( 'global/footer/extras.php' );
}

function xoo_wsc_footer_totals_html(){
	xoo_wsc_helper()->get_template( 'global/footer/totals.php' );
}


function xoo_wsc_footer_text_html(){
	$footerTxt = xoo_wsc_helper()->get_general_option('sct-footer');
	if( !$footerTxt || ( xoo_wsc_helper()->get_general_option('scf-ftext-hide') === "yes" && WC()->cart->is_empty() ) ) return;
	?>
	<span class="xoo-wsc-footer-txt"><?php echo $footerTxt; ?></span>
	<?php
}


function xoo_wsc_footer_buttons_html(){
	xoo_wsc_helper()->get_template( 'global/footer/buttons.php' );
}

add_action( 'xoo_wsc_footer_content', 'xoo_wsc_footer_extras_html', 10 );
add_action( 'xoo_wsc_footer_content', 'xoo_wsc_footer_text_html', 30 );
add_action( 'xoo_wsc_footer_content', 'xoo_wsc_footer_buttons_html', 40 );


//Divi builder fix
function xoo_wsc_fix_for_divi_builder(){

	if( !function_exists('xoo_wsc_frontend') ) return;

	if( defined('ET_CORE_VERSION') && !isset( $_GET['et_fb'] ) ){ // for front end
		remove_action( 'wp_body_open', array( xoo_wsc_frontend(), 'cart_markup' ) );
	}

	if ( isset( $_GET['et_fb'] ) ){ // for back end customizer
		remove_action( 'wp_footer', array( xoo_wsc_frontend(), 'cart_markup' ) );
		add_action( 'wp_body_open', array( xoo_wsc_frontend(), 'cart_markup' ) );
	}

}
add_action( 'wp', 'xoo_wsc_fix_for_divi_builder'  );


function xoo_wsc_add_ajax_atc_disable_form(){
	global $product;

	if( !xoo_wsc_enable_ajax_atc_for_product( $product ) ){
		echo '<span class="xoo-wsc-disable-atc" style="display: none!important"></span>';
	}
}

add_action( 'woocommerce_before_add_to_cart_form', 'xoo_wsc_add_ajax_atc_disable_form' );


function xoo_wsc_enable_ajax_atc_for_product( $product ){

	if( is_int( $product ) ){
		$product = wc_get_product( $product );
	}

	$ajaxAtc = xoo_wsc_helper()->get_general_option('m-ajax-atc');

	$enable = true;

	if( $ajaxAtc === 'yes' ){
		$enable = true;
	}
	else if ( $ajaxAtc === 'no' ) {
		$enable = false;
	}
	else{

		$catIds = xoo_wsc_helper()->get_general_option('m-ajax-atc-catid');

		$catIds = $catIds ? explode(',', $catIds ) : array();
		
		//Enable on all except
		if( $ajaxAtc === 'cat_no' ){
			$enable = !( !empty( $catIds ) && array_intersect( $catIds , $product->get_category_ids() ) );	
		}

		//Enable for these category
		if( $ajaxAtc === 'cat_yes' ){
			$enable = array_intersect( $catIds , $product->get_category_ids() );
		}

	}

	return apply_filters( 'xoo_wsc_enable_ajax_atc', $enable, $product );

}

function xoo_wsc_progress_bar(){
	xoo_wsc_helper()->get_template('global/header/bar.php');
}



/* Progress bar */
add_action( 'xoo_wsc_header_start', function(){
	add_action( xoo_wsc_helper()->get_general_option('scbar-pos'), 'xoo_wsc_progress_bar' );
} );


/* Enqueue Cart Fragments */
add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_script( 'wc-cart-fragments' );
}, 999 );


function xoo_wsc_elementor_disable_cart( $ispage ){
	if(  defined( 'ELEMENTOR_VERSION' ) && ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()  ) ){
		$ispage = false;
	}
	return $ispage;
}

add_filter( 'xoo_wsc_is_sidecart_page', 'xoo_wsc_elementor_disable_cart' );


?>