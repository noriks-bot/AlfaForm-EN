<?php

if( class_exists( 'Xoo_License_Helper' ) ) return;

class Xoo_License_Helper{

	public $slug;
	public $mainFile;
	public $registerLicenseUrl 	= 'https://xootix.com/wp-json/license/v1/register';
	public $licenseInfoURL 		= 'https://xootix.com/wp-json/license/v1/info';
	public $updateURL 			= 'https://xootix.com/wp-json/plugins/v1/update';
	public $cachedPluginInfo 	= false;


	public function __construct( $slug, $mainFile ){

		$this->slug 	= $slug;
		$this->mainFile = $mainFile;
		
		$this->hooks();

	}

	public function hooks(){
		add_action( 'wp_ajax_xoo_ff_license_register', array( $this, 'license_register_form_handle' ) );
		add_filter('site_transient_update_plugins', array( $this, 'check_for_plugin_update' ) );
		add_filter( 'plugins_api', array( $this, 'show_plugin_info' ), 20, 3 );
	}

	public function license_info_http_request(){

		$httpData = $this->get_license_info();

		$httprequest = wp_remote_post(
			$this->licenseInfoURL,
			array(
				'body' => $httpData
			)
		);

		$response = json_decode(wp_remote_retrieve_body($httprequest), true);

		update_option( 'xoo-license-info-'.$this->slug, isset( $response['license_key'] ) ? $response : '' );

		return $response;
	}

	public function license_register_form_handle(){

		if( $_POST['xoo-plugin-slug'] !== $this->slug || !isset( $_POST['xoo_license_nonce_value'] ) || !wp_verify_nonce( $_POST['xoo_license_nonce_value'], 'xoo_license_nonce' ) ) return;

		try {

			$licenseKey = $_POST['xoo-license-key'];

			if( !$licenseKey ){
				throw new Xoo_Exception( 'License key required' );
			}

			$httpData = array(
				'license_key' 	=> $licenseKey,
				'plugin_slug' 	=> $_POST['xoo-plugin-slug'],
				'site_url' 		=> $_POST['xoo-license-website']
			);

			$httprequest = wp_remote_post(
				$this->registerLicenseUrl,
				array(
					'body' => $httpData
				)
			);

			$response = json_decode(wp_remote_retrieve_body($httprequest), true);

			if( $response ){

				if( isset( $response['error'] ) ){
					throw new Xoo_Exception( $response['message'] );
				}

				if( isset( $response['license_key'] ) ){ //license gets registered sucesfully.

					update_option( 'xoo-license-info-'.$this->slug, $response );

					$jsResponse = array(
						'message' => 'License registered successfully',
						'success' => 1
					);
					wp_send_json( $jsResponse );
				}
			}
			else{
				throw new Xoo_Exception( 'Something went wrong. Please contact support' );
			}

			

		} catch ( Xoo_Exception $e) {
			wp_send_json(array(
				'error' 	=> 1,
				'message' 	=> $e->getMessage()
			));
		}

		exit;
		
	}


	public function get_license_info( $key = '' ){

		$info = get_option( 'xoo-license-info-'.$this->slug );

		if( $key ){
			return isset( $info[ $key ] ) ? $info[ $key ] : '';
		}

		return $info;
	}

	public function is_license_active(){
		return $this->get_license_info('is_active');
	}

	public function has_license_expired(){

		$expires_at = $this->get_license_info('expires_at');

		return $expires_at && new DateTime() > new DateTime($expires_at);

	}

	public function get_license_expiry_date(){
		$expiryDate = $this->get_license_info('expires_at');
		return $expiryDate ? (new DateTime( $expiryDate ) )->format('d-m-Y') : '';
	}


	public function plugin_update_info_http_request(){

		$httpData = $this->get_db_license_data();

		if( !$httpData ) return;

		$httprequest = wp_remote_post(
			$this->updateURL,
			array(
				'body' => $httpData
			)
		);

		$response = json_decode( wp_remote_retrieve_body($httprequest), true);

		if( !$response ){ //no update info received, what's wrong? Check license info, maybe expired or disabled
			$this->license_info_http_request($httpData); //refresh the license info
		}

		return $response;
		
	}


	public function get_plugin_update_info(){

		$pluginInfo = get_transient( 'xoo-plugin-info-'.$this->slug );

		if( $this->is_license_active() ){
			if( $pluginInfo === false ){ //transient expired, fetch again
				$pluginInfo = $this->plugin_update_info_http_request();
			}
		}
		else{
			$pluginInfo = false;
		}
		
		set_transient( 'xoo-plugin-info-'.$this->slug, $pluginInfo, DAY_IN_SECONDS );

		return $pluginInfo;

	}

	public function get_db_license_data(){

		$licenseInfo = $this->get_license_info();

		if( !$licenseInfo ){
			$licenseInfo = array();
		}

		$licenseInfo['plugin_slug'] = $this->slug;
		$licenseInfo['site_url'] 	= wp_parse_url(get_site_url())['host'];

		return $licenseInfo;
	}

	public function check_for_plugin_update( $transient ){

		
		if ( empty($transient->checked ) ) return $transient;

		$info 			= $this->get_plugin_update_info();

		$pluginVersion 	= get_plugin_data( $this->mainFile )['Version'];
	

		if( $info && version_compare( $pluginVersion, $info['version'], '<' ) && version_compare( $info['requires'], get_bloginfo( 'version' ), '<=' ) && version_compare( $info['requires_php'], PHP_VERSION, '<' ) ) {
			$result 				= new stdClass();
			$result->slug 			= $this->slug;
			$result->plugin 		= plugin_basename( $this->mainFile ) ;
			$result->new_version 	= $info['version'];
			$result->tested 		= $info['tested'];
			$result->package 		= $info['download_url'];

			$transient->response[ $result->plugin ] = $result;

		}

		return $transient;
	}


	public function show_plugin_info( $result, $action, $args  ){

		if ( $action !== 'plugin_information' || $args->slug !== $this->slug  )  {
			return $result;
		}
	
		// get updates
		$info = $this->get_plugin_update_info();

		if( !$info ) {
			return $result;
		}

		$result = new stdClass();

		$result->name 				= $info['name'];
		$result->slug 				= $info['slug'];
		$result->version 			= $info['version'];
		$result->tested 			= $info['tested'];
		$result->requires 			= $info['requires'];
		$result->author 			= $info['author'];
		$result->author_profile 	= $info['author_profile'];
		$result->download_link 		= $info['download_url'];
		$result->trunk 				= $info['download_url'];
		$result->requires_php 		= $info['requires_php'];
		$result->last_updated 		= $info['last_updated'];
		$result->sections 			= array(
			'description' => $info['sections']['description'],
			'installation' => $info['sections']['installation'],
			'changelog' => $info['sections']['changelog']
		);

		if( ! empty( $info['banners'] ) ) {
			$result->banners = array(
				'low' => $info['banners']['low'],
				'high' => $info['banners']['high']
			);
		}

		return $result;
	}


	public function license_form(){

		$args = array(
			'plugin_slug' 		=> $this->slug,
			'site_url' 			=> wp_parse_url(get_site_url())['host'],
			'license_info' 		=> $this->get_license_info(),
			'license_active' 	=> $this->is_license_active(),
			'license_expired' 	=> $this->has_license_expired(),
			'license_expiry' 	=> $this->get_license_expiry_date()
		);

		extract($args);
		
		include __DIR__.'/xoo-license-form.php';

	}

}