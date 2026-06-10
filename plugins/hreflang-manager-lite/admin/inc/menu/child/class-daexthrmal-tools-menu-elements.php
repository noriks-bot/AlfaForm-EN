<?php
/**
 * Class used to implement the back-end functionalities of the "Tools" menu.
 *
 * @package hreflang-manager-lite
 */

/**
 * Class used to implement the back-end functionalities of the "Tools" menu.
 */
class Daexthrmal_Tools_Menu_Elements extends Daexthrmal_Menu_Elements {

	/**
	 * Constructor.
	 *
	 * @param object $shared The shared class.
	 * @param string $page_query_param The page query parameter.
	 * @param string $config The config parameter.
	 */
	public function __construct( $shared, $page_query_param, $config ) {

		parent::__construct( $shared, $page_query_param, $config );

		$this->menu_slug      = 'tool';
		$this->slug_plural    = 'tools';
		$this->label_singular = __( 'Tool', 'hreflang-manager-lite' );
		$this->label_plural   = __( 'Tools', 'hreflang-manager-lite' );
	}

	/**
	 * Process the add/edit form submission of the menu. Specifically the following tasks are performed:
	 *
	 *  1. Sanitization
	 *  2. Validation
	 *  3. Database update
	 *
	 * @return false|void
	 */
	public function process_form() {

		// process the export button click. (export) ------------------------------------------------------------------.

		/**
		 * Intercept requests that come from the "Export" button of the "Tools -> Export" menu and generate the
		 * downloadable XML file
		 */
		if ( isset( $_POST['daexthrmal_export'] ) ) {

			// Nonce verification.
			check_admin_referer( 'daexthrmal_tools_export', 'daexthrmal_tools_export' );

			// Verify capability.
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'hreflang-manager-lite' ) );
			}

			// Get the data from the 'connect' db.
			global $wpdb;

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$connect_a = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}daexthrmal_connection ORDER BY connection_id ASC", ARRAY_A );

			// If there are data generate the csv header and the content.
			if ( count( $connect_a ) > 0 ) {

				// Generate the header of the XML file.
				header( 'Content-Encoding: UTF-8' );
				header( 'Content-type: text/xml; charset=UTF-8' );
				header( 'Content-Disposition: attachment; filename=hreflang-manager-' . time() . '.xml' );
				header( 'Pragma: no-cache' );
				header( 'Expires: 0' );

				// Generate initial part of the XML file.
				echo '<?xml version="1.0" encoding="UTF-8" ?>';
				echo '<root>';

				// Set column content.
				foreach ( $connect_a as $connect ) {

					echo '<connect>';

					$url      = array();
					$language = array();
					$script   = array();
					$locale   = array();

					// Add the values for the fields that exists in the standard version.
					for ( $i = 1; $i <= 10; $i++ ) {

						$url[ $i ]      = $connect[ 'url' . $i ];
						$language[ $i ] = $connect[ 'language' . $i ];
						$script[ $i ]   = $connect[ 'script' . $i ];
						$locale[ $i ]   = $connect[ 'locale' . $i ];

					}

					// Add the values for the fields that exists only in the pro version.
					for ( $i = 11; $i <= 100; $i++ ) {

						$url[ $i ]      = '';
						$language[ $i ] = 'en';
						$script[ $i ]   = '';
						$locale[ $i ]   = '';

					}

					echo '<url_to_connect>' . esc_attr( $connect['url_to_connect'] ) . '</url_to_connect>';
					echo '<url>' . wp_json_encode( $url ) . '</url>';
					echo '<language>' . wp_json_encode( $language ) . '</language>';
					echo '<script>' . wp_json_encode( $script ) . '</script>';
					echo '<locale>' . wp_json_encode( $locale ) . '</locale>';

					echo '</connect>';

				}

				// Generate the final part of the XML file.
				echo '</root>';

			} else {
				return false;
			}

			die();

		}
	}

	/**
	 * Display the form.
	 *
	 * @return void
	 */
	public function display_custom_content() {

		?>

		<div class="daexthrmal-admin-body">

			<?php

			// Display the dismissible notices.
			$this->shared->display_dismissible_notices();

			?>

			<div class="daexthrmal-tools-menu">

				<div class="daexthrmal-main-form">

				<div class="daexthrmal-main-form__wrapper-half">

					<div class="daexthrmal-main-form__daext-form-section">

						<div class="daexthrmal-main-form__section-header">
							<div class="daexthrmal-main-form__section-header-title">
								<?php $this->shared->echo_icon_svg( 'log-out-04' ); ?>
								<div class="daexthrmal-main-form__section-header-title-text"><?php esc_html_e( 'Export', 'hreflang-manager-lite' ); ?></div>
							</div>
						</div>

						<div class="daexthrmal-main-form__daext-form-section-body">

							<!-- Export form -->

							<p>
								<?php
								esc_html_e(
									'Click the Export button to generate an XML file that includes all the connections.',
									'hreflang-manager-lite'
								);
								?>
							</p>
							<p>
								<?php esc_html_e( 'Note that you can import the resulting file in the Tools menu of the ', 'hreflang-manager-lite' ); ?>
								<a href="https://daext.com/hreflang-manager/" target="_blank"><?php esc_html_e( 'Pro Version', 'hreflang-manager-lite' ); ?></a> <?php esc_html_e( 'to quickly transition between the two plugin editions.', 'hreflang-manager-lite' ); ?>
							</p>

							<!-- the data sent through this form are handled by the export_xml_controller() method called with the WordPress init action -->
							<form method="POST" action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>_<?php echo esc_attr( $this->slug_plural ); ?>">

								<div class="daext-widget-submit">
									<?php wp_nonce_field( 'daexthrmal_tools_export', 'daexthrmal_tools_export' ); ?>
									<input name="daexthrmal_export" class="daexthrmal-btn daexthrmal-btn-primary" type="submit"
											value="<?php esc_attr_e( 'Export', 'hreflang-manager-lite' ); ?>"
										<?php
										if ( ! $this->shared->exportable_data_exists() ) {
											echo 'disabled="disabled"';
										}
										?>
									>
								</div>

							</form>

						</div>

					</div>

				</div>

			</div>

			</div>

		</div>

		<?php
	}
}
