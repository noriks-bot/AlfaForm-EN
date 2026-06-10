<?php
/**
 * Class used to implement the back-end functionalities of the "Connections" menu.
 *
 * @package hreflang-manager-lite
 */

/**
 * Class used to implement the back-end functionalities of the "Term Groups" menu.
 */
class Daexthrmal_Connections_Menu_Elements extends Daexthrmal_Menu_Elements {

	/**
	 * Constructor.
	 *
	 * @param object $shared The shared class.
	 * @param string $page_query_param The page query parameter.
	 * @param string $config The config parameter.
	 */
	public function __construct( $shared, $page_query_param, $config ) {

		parent::__construct( $shared, $page_query_param, $config );

		$this->menu_slug          = 'connection';
		$this->slug_plural        = 'connections';
		$this->label_singular     = __( 'Connection', 'hreflang-manager-lite' );
		$this->label_plural       = __( 'Connections', 'hreflang-manager-lite' );
		$this->primary_key        = 'connection_id';
		$this->db_table           = 'connection';
		$this->list_table_columns = array(
			array(
				'db_field' => 'url_to_connect',
				'label'    => __( 'URL to Connect', 'hreflang-manager-lite' ),
			),
			array(
				'db_field'               => 'id',
				'label'                  => __( 'Alternate Pages', 'hreflang-manager-lite' ),
				'custom_output_function' => 'display_connection_codes',
			),
		);
		$this->searchable_fields  = array(
			'connection_id',
			'url_to_connect',
		);

		// Prepare the default values ---------------------------------------------------------------------------------.

		$this->default_values = array(
			'url_to_connect' => '',
		);

		// For 1 to 10, add language, script, and locale to the default values.
		for ( $i = 1; $i <= 10; $i++ ) {
			$this->default_values[ 'url' . $i ]      = get_option( $this->shared->get( 'slug' ) . '_default_url_' . $i );
			$this->default_values[ 'language' . $i ] = get_option( $this->shared->get( 'slug' ) . '_default_language_' . $i );
			$this->default_values[ 'script' . $i ]   = get_option( $this->shared->get( 'slug' ) . '_default_script_' . $i );
			$this->default_values[ 'locale' . $i ]   = get_option( $this->shared->get( 'slug' ) . '_default_locale_' . $i );
		}
	}

	/**
	 * Process the add/edit form submission of the menu. Specifically the following tasks are performed:
	 *
	 * 1. Sanitization
	 * 2. Validation
	 * 3. Database update
	 *
	 * @return void
	 */
	public function process_form() {

		if ( isset( $_POST['update_id'] ) ||
			isset( $_POST['form_submitted'] ) ) {

			// Nonce verification.
			check_admin_referer( 'daexthrmal_create_update_' . $this->menu_slug, 'daexthrmal_create_update_' . $this->menu_slug . '_nonce' );

		}

		?>

		<!-- process data -->

		<?php

		// Initialize variables ---------------------------------------------------------------------------------------.

		// Save the connection into the database.
		if ( isset( $_POST['form_submitted'] ) ) {

			// Sanitization -------------------------------------------------------------------------------------------.
			$update_id      = isset( $_POST['update_id'] ) ? intval( $_POST['update_id'], 10 ) : '';
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Trim is properly used before esc_url_raw to avoid entities at the beginning or end of the string.
			$url_to_connect = isset( $_POST['url_to_connect'] ) ? esc_url_raw( trim( wp_unslash( $_POST['url_to_connect'] ) ) ) : null;
			$url            = array();
			$language       = array();
			$script         = array();
			$locale         = array();

			for ( $i = 1; $i <= 10; $i++ ) {

				if ( isset( $_POST[ 'url' . $i ] ) ) {
					// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Trim is properly used before esc_url_raw to avoid entities at the beginning or end of the string.
					$sanitized_url = esc_url_raw( trim( wp_unslash( $_POST[ 'url' . $i ] ) ) );
					if ( strlen( trim( $sanitized_url ) ) > 0 ) {
						$url[ $i ] = $sanitized_url;
					} else {
						$url[ $i ] = '';
					}
				} else {
					$url[ $i ] = '';
				}

				if ( isset( $_POST[ 'language' . $i ] ) ) {
					$language[ $i ] = sanitize_text_field( wp_unslash( $_POST[ 'language' . $i ] ) );
				} else {
					$language[ $i ] = get_option( $this->shared->get( 'slug' ) . '_default_language_' . $i );
				}

				if ( isset( $_POST[ 'script' . $i ] ) ) {
					$script[ $i ] = sanitize_text_field( wp_unslash( $_POST[ 'script' . $i ] ) );
				} else {
					$script[ $i ] = get_option( $this->shared->get( 'slug' ) . '_default_script_' . $i );
				}

				if ( isset( $_POST[ 'locale' . $i ] ) ) {
					$locale[ $i ] = sanitize_text_field( wp_unslash( $_POST[ 'locale' . $i ] ) );
				} else {
					$locale[ $i ] = get_option( $this->shared->get( 'slug' ) . '_default_locale_' . $i );
				}
			}

			// Validation ---------------------------------------------------------------------------------------------.

			// Verify if the "URL to Connect" is empty.
			if ( 0 === strlen( trim( $url_to_connect ) ) ) {
				$this->shared->save_dismissible_notice(
					__( 'The "URL to Connect" field is empty.', 'hreflang-manager-lite' ),
					'error'
				);
				$invalid_data = true;
			}
		}

		// Update or add the record in the database.
		if ( isset( $_POST['form_submitted'] ) && ! isset( $invalid_data ) ) {

			if ( isset( $update_id ) && ! empty( $update_id ) ) {

				// Update.

				global $wpdb;

				// phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$query_result = $wpdb->query(
					$wpdb->prepare(
						"UPDATE {$wpdb->prefix}daexthrmal_connection SET url_to_connect = %s ,"
						. 'url1 = %s, language1 = %s, script1 = %s, locale1 = %s,'
						. 'url2 = %s, language2 = %s, script2 = %s, locale2 = %s ,'
						. 'url3 = %s, language3 = %s, script3 = %s, locale3 = %s ,'
						. 'url4 = %s, language4 = %s, script4 = %s, locale4 = %s ,'
						. 'url5 = %s, language5 = %s, script5 = %s, locale5 = %s ,'
						. 'url6 = %s, language6 = %s, script6 = %s, locale6 = %s ,'
						. 'url7 = %s, language7 = %s, script7 = %s, locale7 = %s ,'
						. 'url8 = %s, language8 = %s, script8 = %s, locale8 = %s ,'
						. 'url9 = %s, language9 = %s, script9 = %s, locale9 = %s ,'
						. 'url10 = %s, language10 = %s, script10 = %s, locale10 = %s WHERE connection_id = %d ',
						$url_to_connect,
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
						$update_id
					)
				);

				if ( false !== $query_result ) {
					$this->shared->save_dismissible_notice(
						__( 'The connection has been successfully updated.', 'hreflang-manager-lite' ),
						'updated'
					);
				}
			} else {

				// Add a new connection into the database.
				global $wpdb;

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
						$url_to_connect,
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

				if ( isset( $query_result ) && false !== $query_result ) {
					$this->shared->save_dismissible_notice(
						__( 'The connection has been successfully added.', 'hreflang-manager-lite' ),
						'updated'
					);
				}

				$auto_alternate_pages = intval( get_option( 'daexthrmal_auto_alternate_pages' ), 10 );
				$query_result         = false;
				if ( 1 === $auto_alternate_pages ) {

					for ( $i = 1;$i <= 10;$i++ ) {

						if ( strlen( trim( $url[ $i ] ) ) > 0 && $url[ $i ] !== $url_to_connect ) {

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
									$url[ $i ],
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
					}

					if ( isset( $query_result ) && false !== $query_result ) {

						$this->shared->save_dismissible_notice(
							__( 'The connections of the alternate pages have been successfully added.', 'hreflang-manager-lite' ),
							'updated'
						);

					}
				}
			}
		}
	}

	/**
	 * Defines the form fields present in the add/edit form and call the method to print them.
	 *
	 * @param object $item_obj The object containing the data of the item.
	 * @return void
	 */
	public function print_form_fields( $item_obj = null ) {

		// Get the languages.
		$languages = get_option( 'daexthrmal_language' );

		// Invert array indexes with array values.
		$languages = array_flip( $languages );

		// Add the language code at the start of the language name.
		foreach ( $languages as $key => $value ) {
			$languages[ $key ] = $key . ' - ' . $value;
		}

		// Get the scripts.
		$scripts = get_option( 'daexthrmal_script' );

		// Invert array indexes with array values.
		$scripts = array_flip( $scripts );

		// Add the script code at the start of the script name.
		foreach ( $scripts as $key => $value ) {
			$scripts[ $key ] = $key . ' - ' . $value;
		}

		// Add the "Not Assigned" option at the beginning of the array.
		$scripts = array( '' => __( 'Not Assigned', 'hreflang-manager-lite' ) ) + $scripts;

		// Get the locale.
		$locales = get_option( 'daexthrmal_locale' );

		// Invert array indexes with array values.
		$locales = array_flip( $locales );

		// Add the locale code at the start of the locale name.
		foreach ( $locales as $key => $value ) {
			$locales[ $key ] = $key . ' - ' . $value;
		}

		// Add the "Not Assigned" option at the beginning of the array.
		$locales = array( '' => __( 'Not Assigned', 'hreflang-manager-lite' ) ) + $locales;

		// Add the form data in the $sections array.
		$sections = array(
			array(
				'label'          => 'Main',
				'section_id'     => 'main',
				'display_header' => false,
				'fields'         => array(
					array(
						'type'        => 'text',
						'name'        => 'url_to_connect',
						'label'       => __( 'URL to Connect', 'hreflang-manager-lite' ),
						'description' => __( 'The URL where the hreflang link elements should be applied.', 'hreflang-manager-lite' ),
						'value'       => isset( $item_obj ) ? $item_obj['url_to_connect'] : null,
						'maxlength'   => 2083,
						'required'    => true,
					),
				),
			),
		);

		for ( $i = 1;$i <= 10;$i++ ) {

			$sections[0]['fields'][] = array(
				'type'        => 'text',
				'name'        => 'url' . $i,
				'label'       => __( 'URL', 'hreflang-manager-lite' ) . ' ' . $i,
				'description' => __( 'The URL of the alternate page', 'hreflang-manager-lite' ) . ' ' . $i . '.',
				'value'       => isset( $item_obj ) ? $item_obj[ 'url' . $i ] : null,
				'maxlength'   => 2083,
				'required'    => false,
			);

			$sections[0]['fields'][] = array(
				'type'        => 'select',
				'name'        => 'language' . $i,
				'label'       => __( 'Language', 'hreflang-manager-lite' ) . ' ' . $i,
				'description' => __( 'The language of the alternate page', 'hreflang-manager-lite' ) . ' ' . $i . '.',
				'options'     => $languages,
				'value'       => isset( $item_obj ) ? $item_obj[ 'language' . $i ] : null,
				'required'    => false,
			);

			$sections[0]['fields'][] = array(
				'type'        => 'select',
				'name'        => 'script' . $i,
				'label'       => __( 'Script', 'hreflang-manager-lite' ) . ' ' . $i,
				'description' => __( 'The script of the alternate page', 'hreflang-manager-lite' ) . ' ' . $i . '.',
				'options'     => $scripts,
				'value'       => isset( $item_obj ) ? $item_obj[ 'script' . $i ] : null,
				'required'    => false,
			);

			$sections[0]['fields'][] = array(
				'type'        => 'select',
				'name'        => 'locale' . $i,
				'label'       => __( 'Locale', 'hreflang-manager-lite' ) . ' ' . $i,
				'description' => __( 'The locale of the alternate page', 'hreflang-manager-lite' ) . ' ' . $i . '.',
				'options'     => $locales,
				'value'       => isset( $item_obj ) ? $item_obj[ 'locale' . $i ] : null,
				'required'    => false,
			);

		}

		$this->print_form_fields_from_array( $sections );
	}

	/**
	 * Check if the item is deletable. If not, return the message to be displayed.
	 *
	 * @param int $item_id The ID of the item.
	 *
	 * @return array
	 */
	public function item_is_deletable( $item_id ) {

		$is_deletable               = true;
		$dismissible_notice_message = null;

		return array(
			'is_deletable'               => $is_deletable,
			'dismissible_notice_message' => $dismissible_notice_message,
		);
	}
}
