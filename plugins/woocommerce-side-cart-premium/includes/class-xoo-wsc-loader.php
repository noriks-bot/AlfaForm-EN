<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_Wsc_Loader{

	protected static $_instance = null;
	
	public $isSideCartPage;

	public $updatedFrom;

	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	
	public function __construct(){
		$this->includes();
		$this->hooks();
	}


	public function define( $constant_name, $constant_value ){
		if( !defined( $constant_name ) ){
			define( $constant_name, $constant_value );
		}
	}

	/**
	 * File Includes
	*/
	public function includes(){

		//xootix framework
		require_once XOO_WSC_PATH.'/includes/xoo-framework/xoo-framework.php';
		require_once XOO_WSC_PATH.'/includes/class-xoo-wsc-helper.php';

		if( $this->is_request( 'admin' ) ) {
			require_once XOO_WSC_PATH.'/admin/class-xoo-wsc-admin-settings.php';
		}

		if( xoo_wsc_helper()->license->init_plugin() ){

			require_once XOO_WSC_PATH.'/includes/xoo-wsc-functions.php';
			require_once XOO_WSC_PATH.'/includes/class-xoo-wsc-template-args.php';

			if( $this->is_request( 'frontend' ) ){
				require_once XOO_WSC_PATH.'/includes/class-xoo-wsc-frontend.php';
			}
			
			if( $this->is_request( 'admin' ) ) {
				require_once XOO_WSC_PATH.'/admin/class-xoo-wsc-admin-settings.php';
			}

			require_once XOO_WSC_PATH.'/includes/class-xoo-wsc-cart.php';

		}

	}


	/**
	 * Hooks
	*/
	public function hooks(){
		$this->on_install();
	}


	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}


	/**
	* On install
	*/
	public function on_install(){

		$version_option = 'xoo-wsc-version';
		$db_version 	= get_option( $version_option );

		if( $db_version && version_compare( $db_version, XOO_WSC_VERSION, '<') ){

			$glOptions 		= xoo_wsc_helper()->get_general_option();
			$syOptions 		= xoo_wsc_helper()->get_style_option();
			$avOptions 		= xoo_wsc_helper()->get_advanced_option();

			if( version_compare( $db_version, '4.6', '<') ){

				if( !isset( $syOptions['sch-layout'] ) ){ //new header layout option added
					$syOptions['sch-close-fsize'] 	= 26;
					$syOptions['sch-head-fsize'] 	= 22;
				}

				if( !isset( $avOptions['m-fetch-cart'] ) ){
					$avOptions['m-fetch-cart'] = 'page_load';
				}
			}

			
			if( version_compare( $db_version, '3.0', '<') ){ //version compare check here is to make sure that its not an upgrade from free version.

				if( version_compare( $db_version, '4.1', '<') ){
					$glOptions['scb-show'][] = 'product_qty';
				}
				else if( version_compare( $db_version, '4.4', '<') ){
					$glOptions['scbar-all-celebrate'] = 'none';
					$glOptions['scbar-one-celebrate'] = 'none';
				}
				else if( version_compare( $db_version, '4.4.3', '<') ){

					$paymentBtns = array();

					if( $glOptions['scf-pec-enable'] === 'yes' ){
						$paymentBtns[] = 'paypal';
					}

					if( $glOptions['scf-amaz-enable'] === 'yes' ){
						$paymentBtns[] = 'amazon';
					}

					$glOptions['scf-payment-btns'] = $paymentBtns;

					$syOptions['scf-paybutton-pos'] = array( 'paypal', 'amazon', 'gpay' );


				}
				else if( version_compare( $db_version, '4.4.6', '<') ){

					$layout = isset( $syOptions['scbp-card-en'] ) && $syOptions['scbp-card-en'] === 'yes' ? 'cards' : 'rows';

					$newOptions = array(
						'scbp-card-backtxt-color' 	=> '#000',
						'scbp-card-imgh' 			=> '',
						'scb-playout' 				=> $layout,
					);
					$syOptions = array_merge( $newOptions, $syOptions );
					update_option('xoo-wsc-pattern-init', 'yes' );
				}
				else if( version_compare( $db_version, '4.6', '<') ){	

					$glOptions['sl-enable'] = 'no';
					$glOptions['m-tooltip'] = 'no';
					$glOptions['sch-show'][] = 'save';

					if( !isset( $syOptions['sch-layout'] ) || empty( $syOptions['sch-layout'] ) ){

						$headAlign = $syOptions['sch-head-align'];


						switch ($headAlign) {
							case 'flex-start':
								$newheadAlign = 'left';
								break;

							case 'flex-end':
								$newheadAlign = 'right';
								break;
							
							default:
								$newheadAlign = 'center';
								break;
						}
						
						$closeAlign = $syOptions['sch-close-align'];

						$newCloseAlign = in_array( $closeAlign , array( 'left','right' ) ) ? $closeAlign : 'right';

						$syOptions['sch-layout'][$newheadAlign][] = 'basket';
						$syOptions['sch-layout'][$newheadAlign][] = 'heading';

						$syOptions['sch-layout'][$newCloseAlign][] = 'save';
						$syOptions['sch-layout'][$newCloseAlign][] = 'close';

					}

				}

			}

			update_option('xoo-wsc-sy-options', $syOptions );
			update_option('xoo-wsc-gl-options', $glOptions );
			update_option('xoo-wsc-av-options', $avOptions );
		}


		if( version_compare( $db_version, XOO_WSC_VERSION, '<') ){
			$this->updatedFrom = $db_version;
			//Update to current version
			update_option( $version_option, XOO_WSC_VERSION);
		}



		
	}


	public function isSideCartPage(){

		if( !trim(xoo_wsc_helper()->get_general_option('m-hide-cart')) ){
			$hidePages = array();
		}
		else{
			$hidePages = array_map( 'trim', explode( ',', xoo_wsc_helper()->get_general_option('m-hide-cart') ) );
		}

		if( !isset( $this->isSideCartPage ) ){
			
			$this->isSideCartPage = !( !empty( $hidePages ) && ( ( in_array( 'no-woocommerce', $hidePages )  && !is_woocommerce() && !is_cart() && !is_checkout() ) || is_page( $hidePages ) ) || ( is_product() && in_array( get_the_id() , $hidePages ) ) );

			foreach ( $hidePages as $page_id ) {
				if( is_single( $page_id ) ){
					$this->isSideCartPage = false;
					break;
				}
			}
		
		}


		return apply_filters( 'xoo_wsc_is_sidecart_page', $this->isSideCartPage, $hidePages );
	}

}

?>