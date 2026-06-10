<?php

if( !class_exists( 'Xoo_License_Helper' ) ){

	class Xoo_License_Helper{

		public $slug;
		public $mainFile;
		public $registerLicenseUrl 	= 'https://xootix.com/wp-json/license/v2/register';
		public $licenseInfoURL 		= 'https://xootix.com/wp-json/license/v2/info';
		public $updateURL 			= 'https://xootix.com/wp-json/plugins/v2/update';
		public $cachedPluginInfo 	= false;
		public $version 			= '1.0.4';
		public $folderURL;
		public $adminff;
		public $popupFormArgs 		= array();

		public function __construct( $slug, $mainFile ){

			$this->slug 	= $slug;
			$this->mainFile = $mainFile;

			$this->folderURL = plugins_url('', __FILE__);
			
			$this->hooks();

		}

		public function hooks(){
			add_action( 'wp_ajax_xoo_ff_license_register', array( $this, 'license_register_form_handle' ) );
			add_action( 'wp_ajax_xoo_ff_license_refresh', array( $this, 'license_refresh' ) );
			add_filter('site_transient_update_plugins', array( $this, 'check_for_plugin_update' ) );
			add_filter( 'plugins_api', array( $this, 'show_plugin_info' ), 20, 3 );
			add_action( 'admin_footer', array( $this, 'embed_popup_forms' ) );
			add_action( 'after_plugin_row_'. plugin_basename($this->mainFile) , array( $this, 'show_expiry_notice' ), 10 );
			
		}

		public function show_expiry_notice(){

			if( !$this->has_license_expired() ) return;

			$colspan = is_multisite() ? 4 : 3;

			?>

		    <tr class="plugin-update-tr">
		        <td colspan="<?php echo $colspan ?>" style="background: #fef7f1; border-left: 4px solid #d63638;">
		            <div style="padding: 10px 15px; color: #8a1f11;">
		                Your license has expired. You're missing important security updates and other features. <a href="https://xootix.com/my-account" target="__blank">Renew now</a>
		            </div>
		        </td>
		    </tr>
		    <?php
		}

		public function enqueue_scripts(){
			wp_enqueue_script( 'xoo-license-js', $this->folderURL.'/assets/xoo-license-js.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_style( 'xoo-license-style', $this->folderURL.'/assets/xoo-license-style.css', array(), $this->version );
			wp_localize_script( 'xoo-license-js', 'xoo_license_params', array(
				'adminurl'  => admin_url().'admin-ajax.php',
				'nonce' 	=> wp_create_nonce('xoo-license-nonce'),
				'slug' 		=> $this->slug 
			) );
		}

		public function call_enqueue_scripts(){
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
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
			
			return $response;

		}


		public function license_refresh(){

			if( $_POST['slug'] !== $this->slug || !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'xoo-license-nonce' ) ) return;

			$response = $this->license_info_http_request();

			if( $response ){

				if( isset( $response['error'] ) ){
					$notice = $response['message'];
					delete_option( 'xoo-license-info-'. $this->slug ); //license not valid, delete info
					$reload = 1;
				}
				else if( isset( $response['license_key'] ) ){
					$notice = 'License details refreshed';
					update_option( 'xoo-license-info-'.$this->slug, $response );
					$this->get_plugin_update_info( false ); // fetch plugin info again
				}

			}
			else{
				$notice = 'Something went wrong, please try again later or contact support';
			}


			$data = array(
				'license_text' 	=> $this->get_active_license_text_part(true),
				'notice' 		=> $notice
			);

			if( isset( $reload ) ){
				$data['reload'] = $reload;
			}

			wp_send_json( $data );

			exit;
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
							'message' => 'License registered successfully. Your license is active till '.$this->get_license_expiry_date(),
							'success' => 1
						);

						$this->get_plugin_update_info( false ); // fetch plugin info again

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
			return (bool) $this->get_license_info('is_active');
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

			return $response;
			
		}


		public function get_plugin_update_info( $cached = true ){

			$pluginInfo 			= get_option( 'xoo-plugin-info-'.$this->slug );
			
			if( $this->is_license_active() ){

				$fetchPluginInfo = get_transient( 'xoo-plugin-info-fetched-'.$this->slug );

				if( $fetchPluginInfo === false || !$cached ){ //transient expired, fetch again

					$updatedPluginInfo 	= $this->plugin_update_info_http_request();

					if( $updatedPluginInfo ){

						if( isset( $response['error'] ) ){
							delete_option( 'xoo-license-info-'. $this->slug ); //license not valid, delete info
							delete_transient( 'xoo-plugin-info-fetched-'.$this->slug );
							return $pluginInfo;
						}
						else{
							$fetchAgainin 	= (DAY_IN_SECONDS*2);
							$pluginInfo 	= $updatedPluginInfo;
							update_option( 'xoo-plugin-info-'.$this->slug, $pluginInfo );
							if( $this->has_license_expired() ){
								$fetchAgainin = (DAY_IN_SECONDS*15);
							}
						}

					}
					else{
						//Could not fetch data
						$fetchAgainin 	= DAY_IN_SECONDS; // fetch again next day
					}

					set_transient( 'xoo-plugin-info-fetched-'.$this->slug, 'fetched', $fetchAgainin  );

				}
			}
			else{
				$pluginInfo = false;
			}
			
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


		public function license_form( $popup = false, $passed_args = array() ){

			$args = array(
				'popup' 			=> $popup,
				'plugin_slug' 		=> $this->slug,
				'site_url' 			=> wp_parse_url(get_site_url())['host'],
				'license_info' 		=> $this->get_license_info(),
				'license_active' 	=> $this->is_license_active(),
				'license_expired' 	=> $this->has_license_expired(),
				'license_expiry' 	=> $this->get_license_expiry_date(),
				'show_info' 		=> true
			);

			$args = wp_parse_args( $passed_args, $args );

			extract($args);
			
			if( $popup ){
				include __DIR__.'/xoo-license-popup.php';
			}
			else{
				include __DIR__.'/xoo-license-inline.php';
			}

		}

		public function license_popup_toggle( $args = array() ){
			?>
			<div class="xoo-lic-pop-toggle-liner" data-licactive="<?php echo $this->is_license_active() ? 'yes' : 'no' ?>">
				<span class="xoo-el-lic-popup-toggle" data-slug="<?php echo $this->slug ?>">

					<?php

					if( $this->is_license_active() ){
						if( $this->has_license_expired() ){
							echo 'Enter new License Key';
						}
						else{
							echo 'License Details';
						}
					}
					else{
						echo 'Activate License';
					}

					?>
				</span>
			</div>

			<?php

			$this->popupFormArgs[ $this->slug ] = $args;
			
		}


		public function embed_popup_forms(){
			foreach ( $this->popupFormArgs as $slug => $args) {
				$this->license_form(true, $args);
			}
		}


		public function get_active_license_text_part( $return = false ){
			$data = array(
				'license_active' 	=> $this->is_license_active(),
				'license_expired' 	=> $this->has_license_expired(),
				'license_expiry' 	=> $this->get_license_expiry_date()
			);

			extract($data);

			ob_start();

			?>
			<div class="xoo-lic-txt xoo-lic-active <?php if( $license_expired ) echo 'xoo-lic-expired'; ?>">
				<?php if( $license_expired ): ?>
					<b>Your license has expired.</b><br><br>
					Your license was active till <?php echo $license_expiry; ?><br><br>
					Please renew your license to get the latest updates
				<?php else: ?>
					Your license is active till <?php echo $license_expiry; ?>
				<?php endif; ?>
			</div>

			<?php

			$html = ob_get_clean();

			if( $return ){
				return $html;
			}
			echo $html;
		}

		public function get_active_license_text(){
			?>
			<div data-plugin_slug="<?php echo $this->slug ?>" class="xoo-lic-txt-cont">
				<?php $this->get_active_license_text_part(); ?>
				<div class="xoo-lic-refresh-info"><span class="dashicons dashicons-update"></span></div>
			</div>
			<?php
		}

		public function add_license_tab(){
			$this->call_enqueue_scripts();
			add_action( 'wp_loaded', array( $this, 'register_license_tab' ) );
			add_action( 'xoo_tab_page_start', array( $this, 'info_tab_license_html' ), 5, 2 );
		}

		public function register_license_tab(){
			$this->adminff->register_tab( 'License', 'license', '' );
		}

		public function info_tab_license_html($tab_id, $tab_data){
			
			if( $tab_id !== 'license' ) return;
			$this->get_active_license_text();
			if( $this->has_license_expired() ){
				$this->license_popup_toggle(array(
					'show_info' => false
				));
			}
		
		}


		public function init_plugin(){
			return $this->is_license_active();
		}


	}

}