<?php
/**
 * Here the REST API endpoint of the plugin are registered.
 *
 * @package hreflang-manager-lite
 */

/**
 * This class should be used to work with the REST API endpoints of the plugin.
 */
class Daexthrmal_Rest {

	/**
	 * The singleton instance of the class.
	 *
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * An instance of the shared class.
	 *
	 * @var Daexthrmal_Shared|null
	 */
	private $shared = null;

	/**
	 * Constructor.
	 */
	private function __construct() {

		// Assign an instance of the shared class.
		$this->shared = Daexthrmal_Shared::get_instance();

		/**
		 * Add custom routes to the Rest API.
		 */
		add_action( 'rest_api_init', array( $this, 'rest_api_register_route' ) );
	}

	/**
	 * Create a singleton instance of the class.
	 *
	 * @return self|null
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Add custom routes to the Rest API.
	 *
	 * @return void
	 */
	public function rest_api_register_route() {

		// Add the GET 'hreflang-manager-lite/v1/post' endpoint to the Rest API.
		register_rest_route(
			'hreflang-manager-lite/v1',
			'/post/(?P<id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'rest_api_daext_hreflang_manager_read_connections_callback' ),
				'permission_callback' => array( $this, 'rest_api_daext_hreflang_manager_read_connections_callback_permission_check' ),
			)
		);

		// Add the POST 'hreflang-manager-lite/v1/post' endpoint to the Rest API.
		register_rest_route(
			'hreflang-manager-lite/v1',
			'/post/',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'rest_api_daext_hreflang_manager_post_connection_callback' ),
				'permission_callback' => array( $this, 'rest_api_daext_hreflang_manager_post_connection_callback_permission_check' ),
			)
		);

		// Add the GET 'hreflang-manager-lite/v1/options' endpoint to the Rest API.
		register_rest_route(
			'hreflang-manager-lite/v1',
			'/read-options/',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'rest_api_daext_hreflang_manager_read_options_callback' ),
				'permission_callback' => array( $this, 'rest_api_daext_hreflang_manager_read_options_callback_permission_check' ),
			)
		);

		// Add the POST 'hreflang-manager-lite/v1/options' endpoint to the Rest API.
		register_rest_route(
			'hreflang-manager-lite/v1',
			'/options',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'rest_api_daext_hreflang_manager_update_options_callback' ),
				'permission_callback' => array( $this, 'rest_api_daext_hreflang_manager_update_options_callback_permission_check' ),

			)
		);
	}

	/**
	 * Callback for the GET 'hreflang-manager-lite/v1/options' endpoint of the Rest API.
	 *
	 * @param array $data Data received from the request.
	 *
	 * @return false|WP_REST_Response
	 */
	public function rest_api_daext_hreflang_manager_read_connections_callback( $data ) {

		// Generate the response.

		$url_to_connect = $this->shared->get_permalink( $data['id'], true );

		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}daexthrmal_connection WHERE url_to_connect = %s", $url_to_connect ),
			ARRAY_A
		);

		if ( $wpdb->num_rows > 0 ) {

			// Prepare the response.
			$response = new WP_REST_Response( $row );

		} else {

			return false;
		}

		return $response;
	}

	/**
	 * Check the user capability.
	 *
	 * @return true|WP_Error
	 */
	public function rest_api_daext_hreflang_manager_read_connections_callback_permission_check() {

		// Check the capability.
		if ( ! current_user_can( 'edit_others_posts' ) ) {
			return new WP_Error(
				'rest_read_error',
				'Sorry, you are not allowed to view the Hreflang Manager connections.',
				array( 'status' => 403 )
			);
		}

		return true;
	}

	/**
	 * Callback for the POST 'hreflang-manager-lite/v1/post/' endpoint of the Rest API.
	 *
	 *  This method is in the following contexts:
	 *  - To save the connection when the "Update" button of the Gutenberg editor is clicked.
	 *
	 * @param array $data Data received from the request.
	 *
	 * @return void|WP_REST_Response
	 */
	public function rest_api_daext_hreflang_manager_post_connection_callback( $data ) {

		$data    = json_decode( $data->get_body() );
		$post_id = $data->post_id;
		$old_permalink = isset( $data->old_permalink ) ? esc_url_raw( $data->old_permalink ) : '';
		$new_permalink = isset( $data->new_permalink ) ? esc_url_raw( $data->new_permalink ) : '';
		$data    = $data->connection_data;

		// Init vars.
		$url      = array();
		$language = array();
		$script   = array();
		$locale   = array();

		// Initialize the variables that include the URLs, the languages, the script and the locale.
		for ( $i = 1;$i <= 10;$i++ ) {

			if ( isset( $data->{'url' . $i} ) && strlen( trim( $data->{'url' . $i} ) ) > 0 ) {
				$url[ $i ]        = esc_url_raw( $data->{'url' . $i} );
				$at_least_one_url = true;
			} else {
				$url[ $i ] = '';
			}

			if ( isset( $data->{'language' . $i} ) && strlen( trim( $data->{'language' . $i} ) ) > 0 ) {
				$language[ $i ] = sanitize_text_field( $data->{'language' . $i} );
			} else {
				$language[ $i ] = get_option( $this->shared->get( 'slug' ) . '_default_language_' . $i );
			}

			if ( isset( $data->{'script' . $i} ) ) {
				$script[ $i ] = sanitize_text_field( $data->{'script' . $i} );
			} else {
				$script[ $i ] = get_option( $this->shared->get( 'slug' ) . '_default_script_' . $i );
			}

			if ( isset( $data->{'locale' . $i} ) ) {
				$locale[ $i ] = sanitize_text_field( $data->{'locale' . $i} );
			} else {
				$locale[ $i ] = get_option( $this->shared->get( 'slug' ) . '_default_locale_' . $i );
			}
		}

		/*
		 * Save the fields in the daexthrmal_connection database table:
		 *
		 * - if a row with the url_to_connect equal to the current permalink already exists update the row
		 * - if a row with the url_to_connect equal to the current permalink doesn't exist create a new row
		 */
		$permalink = $this->shared->get_permalink( $post_id, true );

		if ( ! empty( $new_permalink ) ) {
			$permalink = $new_permalink;
		}

		// Update url_to_connect when a permalink change is detected.
		global $wpdb;
		if ( ! empty( $old_permalink ) && ! empty( $new_permalink ) && $old_permalink !== $new_permalink ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$query_result = $wpdb->query(
				$wpdb->prepare(
					"UPDATE {$wpdb->prefix}daexthrmal_connection SET "
					. 'url_to_connect = %s WHERE url_to_connect = %s ',
					$new_permalink,
					$old_permalink
				)
			);
		}

		// Look for $permalink in the url_to_connect field of the daexthrmal_connection database table.
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$permalink_connections = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}daexthrmal_connection WHERE url_to_connect = %s", $permalink )
		);

		if ( null !== $permalink_connections ) {

			// Update an existing connection.

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$query_result = $wpdb->query(
				$wpdb->prepare(
					"UPDATE {$wpdb->prefix}daexthrmal_connection SET "
					. 'url1 = %s, language1 = %s, script1 = %s, locale1 = %s,'
					. 'url2 = %s, language2 = %s, script2 = %s, locale2 = %s ,'
					. 'url3 = %s, language3 = %s, script3 = %s, locale3 = %s ,'
					. 'url4 = %s, language4 = %s, script4 = %s, locale4 = %s ,'
					. 'url5 = %s, language5 = %s, script5 = %s, locale5 = %s ,'
					. 'url6 = %s, language6 = %s, script6 = %s, locale6 = %s ,'
					. 'url7 = %s, language7 = %s, script7 = %s, locale7 = %s ,'
					. 'url8 = %s, language8 = %s, script8 = %s, locale8 = %s ,'
					. 'url9 = %s, language9 = %s, script9 = %s, locale9 = %s ,'
					. 'url10 = %s, language10 = %s, script10 = %s, locale10 = %s WHERE url_to_connect = %s ',
					$url[1],
					$language[1],
					$script[1],
					$locale[1],
					$url[2],
					$language[2],
					$script[2],
					$locale[2],
					$url[3],
					$language[3],
					$script[3],
					$locale[3],
					$url[4],
					$language[4],
					$script[4],
					$locale[4],
					$url[5],
					$language[5],
					$script[5],
					$locale[5],
					$url[6],
					$language[6],
					$script[6],
					$locale[6],
					$url[7],
					$language[7],
					$script[7],
					$locale[7],
					$url[8],
					$language[8],
					$script[8],
					$locale[8],
					$url[9],
					$language[9],
					$script[9],
					$locale[9],
					$url[10],
					$language[10],
					$script[10],
					$locale[10],
					$permalink
				)
			);

		} else {

			// Return ( do not create a new connection ) if there are not a single url defined.
			if ( ! isset( $at_least_one_url ) ) {
				return new WP_REST_Response( array( 'message' => 'No URLs provided' ), 200 );
			}

			// Add a new connection into the database.

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$query_result = $wpdb->query(
				$wpdb->prepare(
					"INSERT INTO {$wpdb->prefix}daexthrmal_connection SET url_to_connect = %s ,"
					. 'url1 = %s, language1 = %s, script1 = %s, locale1 = %s,'
					. 'url2 = %s, language2 = %s, script2 = %s, locale2 = %s ,'
					. 'url3 = %s, language3 = %s, script3 = %s, locale3 = %s ,'
					. 'url4 = %s, language4 = %s, script4 = %s, locale4 = %s ,'
					. 'url5 = %s, language5 = %s, script5 = %s, locale5 = %s ,'
					. 'url6 = %s, language6 = %s, script6 = %s, locale6 = %s ,'
					. 'url7 = %s, language7 = %s, script7 = %s, locale7 = %s ,'
					. 'url8 = %s, language8 = %s, script8 = %s, locale8 = %s ,'
					. 'url9 = %s, language9 = %s, script9 = %s, locale9 = %s ,'
					. 'url10 = %s, language10 = %s, script10 = %s, locale10 = %s',
					$permalink,
					$url[1],
					$language[1],
					$script[1],
					$locale[1],
					$url[2],
					$language[2],
					$script[2],
					$locale[2],
					$url[3],
					$language[3],
					$script[3],
					$locale[3],
					$url[4],
					$language[4],
					$script[4],
					$locale[4],
					$url[5],
					$language[5],
					$script[5],
					$locale[5],
					$url[6],
					$language[6],
					$script[6],
					$locale[6],
					$url[7],
					$language[7],
					$script[7],
					$locale[7],
					$url[8],
					$language[8],
					$script[8],
					$locale[8],
					$url[9],
					$language[9],
					$script[9],
					$locale[9],
					$url[10],
					$language[10],
					$script[10],
					$locale[10]
				)
			);

		}

		// Generate the response.
		$response = new WP_REST_Response( $data );

		return $response;
	}

	/**
	 * Check the user capability.
	 *
	 * @return true|WP_Error
	 */
	public function rest_api_daext_hreflang_manager_post_connection_callback_permission_check() {

		// Check the capability.
		if ( ! current_user_can( 'edit_others_posts' ) ) {
			return new WP_Error(
				'rest_read_error',
				'Sorry, you are not allowed to add a connection.',
				array( 'status' => 403 )
			);
		}

		return true;
	}


	/**
	 * Callback for the GET 'hreflang-manager-lite/v1/options' endpoint of the Rest API.
	 *
	 * @return WP_REST_Response
	 */
	public function rest_api_daext_hreflang_manager_read_options_callback() {

		// Generate the response.
		$response = array();
		foreach ( $this->shared->get( 'options' ) as $key => $value ) {
			$response[ $key ] = get_option( $key );
		}

		// Prepare the response.
		$response = new WP_REST_Response( $response );

		return $response;
	}

	/**
	 * Check the user capability.
	 *
	 * @return true|WP_Error
	 */
	public function rest_api_daext_hreflang_manager_read_options_callback_permission_check() {

		if ( ! current_user_can( 'edit_others_posts' ) ) {
			return new WP_Error(
				'rest_read_error',
				'Sorry, you are not allowed to read the Hreflang Manager options.',
				array( 'status' => 403 )
			);
		}

		return true;
	}

	/**
	 * Callback for the POST 'hreflang-manager-lite/v1/options' endpoint of the Rest API.
	 *
	 * This method is in the following contexts:
	 *
	 *  - To update the plugin options in the "Options" menu.
	 *
	 * @param object $request The request data.
	 *
	 * @return WP_REST_Response
	 */
	public function rest_api_daext_hreflang_manager_update_options_callback( $request ) {

		// Get and sanitize data --------------------------------------------------------------------------------------.

		$options = array();

		// Get and sanitize data --------------------------------------------------------------------------------------.

		// General ----------------------------------------------------------------------------------------------------.
		$options['daexthrmal_detect_url_mode']     = $request->get_param( 'daexthrmal_detect_url_mode' ) !== null ? sanitize_key( $request->get_param( 'daexthrmal_detect_url_mode' ) ) : null;
		$options['daexthrmal_https']               = $request->get_param( 'daexthrmal_https' ) !== null ? intval( $request->get_param( 'daexthrmal_https' ), 10 ) : null;
		$options['daexthrmal_auto_trailing_slash'] = $request->get_param( 'daexthrmal_auto_trailing_slash' ) !== null ? intval( $request->get_param( 'daexthrmal_auto_trailing_slash' ), 10 ) : null;

		$options['daexthrmal_auto_alternate_pages'] = $request->get_param( 'daexthrmal_auto_alternate_pages' ) !== null ? intval( $request->get_param( 'daexthrmal_auto_alternate_pages' ), 10 ) : null;

		$options['daexthrmal_auto_delete'] = $request->get_param( 'daexthrmal_auto_delete' ) !== null ? intval( $request->get_param( 'daexthrmal_auto_delete' ), 10 ) : null;
		$options['daexthrmal_show_log']    = $request->get_param( 'daexthrmal_show_log' ) !== null ? intval( $request->get_param( 'daexthrmal_show_log' ), 10 ) : null;

		// Defaults ---------------------------------------------------------------------------------------------------.
		for ( $i = 1; $i <= 10; $i++ ) {
			$options[ 'daexthrmal_default_language_' . $i ] = $request->get_param( 'daexthrmal_default_language_' . $i ) !== null ? sanitize_key( $request->get_param( 'daexthrmal_default_language_' . $i ) ) : null;
			$options[ 'daexthrmal_default_script_' . $i ]   = $request->get_param( 'daexthrmal_default_script_' . $i ) !== null ? sanitize_text_field( $request->get_param( 'daexthrmal_default_script_' . $i ) ) : null;
			$options[ 'daexthrmal_default_locale_' . $i ]   = $request->get_param( 'daexthrmal_default_locale_' . $i ) !== null ? sanitize_key( $request->get_param( 'daexthrmal_default_locale_' . $i ) ) : null;
		}

		// Update the options -----------------------------------------------------------------------------------------.
		foreach ( $options as $key => $option ) {
			if ( null !== $option ) {
				update_option( $key, $option );
			}
		}

		$response = new WP_REST_Response( 'Data successfully added.', '200' );

		return $response;
	}

	/**
	 * Check the user capability.
	 *
	 * @return true|WP_Error
	 */
	public function rest_api_daext_hreflang_manager_update_options_callback_permission_check() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return new WP_Error(
				'rest_update_error',
				'Sorry, you are not allowed to update the Hreflang Manager options.',
				array( 'status' => 403 )
			);
		}

		return true;
	}
}
