<?php

class Xoo_Wsc_Helper extends Xoo_Helper{

	protected static $_instance = null;

	public $license;

	public static function get_instance( $slug, $path, $helperArgs = array() ){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $slug, $path, $helperArgs );
		}
		return self::$_instance;
	}

	public function __construct(...$args){
		parent::__construct(...$args);
		$this->include_license();
	}


	public function get_general_option( $subkey = '' ){
		return $this->get_option( 'xoo-wsc-gl-options', $subkey );
	}

	public function get_style_option( $subkey = '' ){
		return $this->get_option( 'xoo-wsc-sy-options', $subkey );
	}

	public function get_advanced_option( $subkey = '' ){
		return $this->get_option( 'xoo-wsc-av-options', $subkey );
	}

	public function box_shadow_desc($value){
		$html = '<a href="https://box-shadow.dev/" target="__blank">Preview & click on "Show code" -> copy value</a>';
		if( $value ){
			$html .= 'Default: '.$value;
		}
		return $html;
	}

	public function register_string_for_translation( $string, $string_name ){

		//WPML
		if( class_exists( 'SitePress' ) ){
			do_action(
				'wpml_register_single_string',
				$this->slug,
				$this->slug.'-'.$string_name,
				$string
			);
		}

		//Polylang
		if( function_exists('pll_register_string') ){
			pll_register_string( $string_name, $string, $this->slug );
		}
	}

	public function translate_registered_string( $string, $string_name ){

		//WPML
		if( class_exists( 'SitePress' ) ){
			return apply_filters(
				'wpml_translate_single_string',
				$string,
				$this->slug,
				$this->slug.'-'.$string_name
			);
		}

		//Polylang
		if( function_exists( 'pll__' ) ){
			return pll__( $string );
		}
		

		return $string;
	}

	public function include_license(){
		require_once XOO_WSC_PATH.'/license/class-xoo-license-helper.php';
		$this->license = new Xoo_License_Helper( 'side-cart-woocommerce', XOO_WSC_PLUGIN_FILE );
	}


}

function xoo_wsc_helper(){
	return Xoo_Wsc_Helper::get_instance( 'side-cart-woocommerce', XOO_WSC_PATH, array(
		'disable_usage' => true
	) );
}
xoo_wsc_helper();

?>