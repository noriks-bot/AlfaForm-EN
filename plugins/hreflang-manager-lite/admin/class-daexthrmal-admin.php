<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package hreflang-manager-lite
 */

/**
 * This class should be used to work with the administrative side of WordPress.
 */
class Daexthrmal_Admin {

	/**
	 * The instance of this class.
	 *
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * The instance of the shared class.
	 *
	 * @var Daexthrmal_Shared|null
	 */
	private $shared = null;

	/**
	 * The screen id of the "Connections" menu.
	 *
	 * @var null
	 */
	private $screen_id_connections = null;

	/**
	 * The screen id of the "Tools" menu.
	 *
	 * @var null
	 */
	private $screen_id_tools = null;

	/**
	 * The screen id of the "Options" menu.
	 *
	 * @var null
	 */
	private $screen_id_options = null;

	/**
	 * Instance of the class used to generate the back-end menus.
	 *
	 * @var null
	 */
	private $menu_elements = null;

	/**
	 * Constructor.
	 */
	private function __construct() {

		// Assign an instance of the plugin info.
		$this->shared = Daexthrmal_Shared::get_instance();

		// Load admin stylesheets and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the admin menu.
		add_action( 'admin_menu', array( $this, 'me_add_admin_menu' ) );

		// Add the meta box.
		add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );

		// Save the meta box.
		add_action( 'save_post', array( $this, 'save_meta_box' ) );

		// This hook is triggered during the creation of a new blog.
		add_action( 'wpmu_new_blog', array( $this, 'new_blog_create_options_and_tables' ), 10, 6 );

		// This hook is triggered during the deletion of a blog.
		add_action( 'delete_blog', array( $this, 'delete_blog_delete_options_and_tables' ), 10, 1 );

		// Fires before a post is sent to the trash.
		add_action( 'wp_trash_post', array( $this, 'delete_post_connection' ) );

		// Require and instantiate the related classes used to handle the menus.
		add_action( 'init', array( $this, 'handle_menus' ) );
	}

	/**
	 * Return an instance of this class.
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
	 * If we are in one of the plugin back-end menus require and instantiate the related class used to handle the menu.
	 *
	 * @return void
	 */
	public function handle_menus() {

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce non-necessary for menu selection.
		$page_query_param = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : null;

		// Require and instantiate the class used to handle the current menu.
		if ( null !== $page_query_param ) {

			$config = array(
				'admin_toolbar' => array(
					'items'      => array(
						array(
							'link_text' => __( 'Connections', 'hreflang-manager-lite' ),
							'link_url'  => admin_url( 'admin.php?page=daexthrmal_connections' ),
							'icon'      => 'list',
							'menu_slug' => 'daexthrmal-connection',
						),
						array(
							'link_text' => __( 'Tools', 'hreflang-manager-lite' ),
							'link_url'  => admin_url( 'admin.php?page=daexthrmal_tools' ),
							'icon'      => 'tool-02',
							'menu_slug' => 'daexthrmal-tool',
						),
						array(
							'link_text' => __( 'Options', 'hreflang-manager-lite' ),
							'link_url'  => admin_url( 'admin.php?page=daexthrmal_options' ),
							'icon'      => 'settings-01',
							'menu_slug' => 'daexthrmal-options',
						),
					),
					'more_items' => array(
						array(
							'link_text' => __( 'Bulk Import', 'hreflang-manager-lite' ),
							'link_url'  => 'https://daext.com/hreflang-manager/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Network Sync', 'hreflang-manager-lite' ),
							'link_url'  => 'https://daext.com/hreflang-manager/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'XML Sitemap', 'hreflang-manager-lite' ),
							'link_url'  => 'https://daext.com/hreflang-manager/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Import & Export', 'hreflang-manager-lite' ),
							'link_url'  => 'https://daext.com/hreflang-manager/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Locale Selector', 'hreflang-manager-lite' ),
							'link_url'  => 'https://daext.com/hreflang-manager/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Hreflang Checker', 'hreflang-manager-lite' ),
							'link_url'  => 'https://daext.com/hreflang-manager/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Maintenance Tasks', 'hreflang-manager-lite' ),
							'link_url'  => 'https://daext.com/hreflang-manager/#features',
							'pro_badge' => true,
						),
						array(
							'link_text' => __( 'Configure Capabilities', 'hreflang-manager-lite' ),
							'link_url'  => 'https://daext.com/hreflang-manager/#features',
							'pro_badge' => true,
						),
					),
				),
			);

			// The parent class.
			require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/class-daexthrmal-menu-elements.php';

			// Use the correct child class based on the page query parameter.
			if ( 'daexthrmal_connections' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daexthrmal-connections-menu-elements.php';
				$this->menu_elements = new Daexthrmal_Connections_Menu_Elements( $this->shared, $page_query_param, $config );
			}
			if ( 'daexthrmal_tools' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daexthrmal-tools-menu-elements.php';
				$this->menu_elements = new Daexthrmal_Tools_Menu_Elements( $this->shared, $page_query_param, $config );
			}
			if ( 'daexthrmal_options' === $page_query_param ) {
				require_once $this->shared->get( 'dir' ) . 'admin/inc/menu/child/class-daexthrmal-options-menu-elements.php';
				$this->menu_elements = new Daexthrmal_Options_Menu_Elements( $this->shared, $page_query_param, $config );
			}
		}

	}

	/**
	 * Enqueue admin-specific styles.
	 *
	 * @return void
	 */
	public function enqueue_admin_styles() {

		$screen = get_current_screen();

		// Menu connections.
		if ( $screen->id === $this->screen_id_connections ) {

			// Select2.
			wp_enqueue_style(
				$this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/css/select2.min.css',
				array(),
				$this->shared->get( 'ver' )
			);

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array(), $this->shared->get( 'ver' ) );

		}

		// Menu Tools.
		if ( $screen->id === $this->screen_id_tools ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array(), $this->shared->get( 'ver' ) );

		}

		// Menu Options.
		if ( $screen->id === $this->screen_id_options ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu', $this->shared->get( 'url' ) . 'admin/assets/css/framework-menu/main.css', array( 'wp-components' ), $this->shared->get( 'ver' ) );

		}

		$meta_box_post_types_a = $this->shared->get_post_types_with_ui();

		if ( in_array( $screen->id, $meta_box_post_types_a, true ) ) {
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-meta-box', $this->shared->get( 'url' ) . 'admin/assets/css/meta-box.css', array(), $this->shared->get( 'ver' ) );
		}
	}

	/**
	 * Enqueue admin-specific JavaScript.
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {

		$screen = get_current_screen();

		// General.
		wp_enqueue_script( $this->shared->get( 'slug' ) . '-general', $this->shared->get( 'url' ) . 'admin/assets/js/general.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

		// Menu connections.
		if ( $screen->id === $this->screen_id_connections ) {

			$wp_localize_script_data = array(
				'chooseAnOptionText' => esc_html__( 'Choose an Option ...', 'hreflang-manager-lite' ),
			);

			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/js/select2.min.js',
				array( 'jquery' ),
				$this->shared->get( 'ver' ),
				true
			);

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-connections', $this->shared->get( 'url' ) . 'admin/assets/js/menu-connections.js', array( 'jquery', $this->shared->get( 'slug' ) . '-select2' ), $this->shared->get( 'ver' ), true );
			wp_localize_script( $this->shared->get( 'slug' ) . '-menu-connections', 'objectL10n', $wp_localize_script_data );

		}

		// Menu tools.
		if ( $screen->id === $this->screen_id_tools ) {

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

		}

		// Menu Options.
		if ( $screen->id === $this->screen_id_options ) {

			// Store the JavaScript parameters in the window.DAEXTDAEXTHRMAL_PARAMETERS object.
			$initialization_script  = 'window.DAEXTDAEXTHRMAL_PARAMETERS = {';
			$initialization_script .= 'options_configuration_pages: ' . wp_json_encode( $this->shared->menu_options_configuration() );
			$initialization_script .= '};';

			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-menu-options',
				$this->shared->get( 'url' ) . 'admin/react/options-menu/build/index.js',
				array( 'wp-element', 'wp-api-fetch', 'wp-i18n', 'wp-components' ),
				$this->shared->get( 'ver' ),
				true
			);

			wp_add_inline_script( $this->shared->get( 'slug' ) . '-menu-options', $initialization_script, 'before' );

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu', $this->shared->get( 'url' ) . 'admin/assets/js/framework-menu/menu.js', array( 'jquery' ), $this->shared->get( 'ver' ), true );

		}

	}

	/**
	 * Plugin activation.
	 *
	 * @param bool $networkwide True if the plugin is being activated network-wide.
	 *
	 * @return void
	 */
	public static function ac_activate( $networkwide ) {

		// Delete options and tables for all the sites in the network.
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			// If this is a "Network Activation" create the options and tables for each blog.
			if ( $networkwide ) {

				// Get the current blog id.
				global $wpdb;
				$current_blog = $wpdb->blogid;

				// Create an array with all the blog ids.

				// phpcs:ignore WordPress.DB.DirectDatabaseQuery
				$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

				// Iterate through all the blogs.
				foreach ( $blogids as $blog_id ) {

					// Switch to the iterated blog.
					switch_to_blog( $blog_id );

					// Create options and tables for the iterated blog.
					self::ac_initialize_options();
					self::ac_create_database_tables();

				}

				// Switch to the current blog.
				switch_to_blog( $current_blog );

			} else {

				// If this is not a "Network Activation" create options and tables only for the current blog.
				self::ac_initialize_options();
				self::ac_create_database_tables();

			}
		} else {

			// If this is not a multisite installation create options and tables only for the current blog.
			self::ac_initialize_options();
			self::ac_create_database_tables();

		}
	}

	/**
	 * Create the options and tables for the newly created blog.
	 *
	 * @param int $blog_id The id of the blog.
	 *
	 * @return void
	 */
	public function new_blog_create_options_and_tables( $blog_id ) {

		global $wpdb;

		// If the plugin is "Network Active" create the options and tables for this new blog.
		if ( is_plugin_active_for_network( 'hreflang-manager/init.php' ) ) {

			// Get the id of the current blog.
			$current_blog = $wpdb->blogid;

			// Switch to the blog that is being activated.
			switch_to_blog( $blog_id );

			// Create options and database tables for the new blog.
			$this->ac_initialize_options();
			$this->ac_create_database_tables();

			// Switch to the current blog.
			switch_to_blog( $current_blog );

		}
	}

	/**
	 * Delete options and tables for the deleted blog.
	 *
	 * @param int $blog_id The id of the blog.
	 *
	 * @return void
	 */
	public function delete_blog_delete_options_and_tables( $blog_id ) {

		global $wpdb;

		// Get the id of the current blog.
		$current_blog = $wpdb->blogid;

		// Switch to the blog that is being activated.
		switch_to_blog( $blog_id );

		// Create options and database tables for the new blog.
		$this->un_delete_options();
		$this->un_delete_database_tables();

		// Switch to the current blog.
		switch_to_blog( $current_blog );
	}

	/**
	 * Initialize plugin options.
	 *
	 * @return void
	 */
	public static function ac_initialize_options() {

		if ( intval( get_option( 'daexthrmal_options_version' ), 10 ) < 1 ) {

			// Assign an instance of Daexthrmal_Shared.
			$shared = Daexthrmal_Shared::get_instance();

			foreach ( $shared->get( 'options' ) as $key => $value ) {
				add_option( $key, $value );
			}

			// Update options version.
			update_option( 'daexthrmal_options_version', '1' );

		}
	}

	/**
	 * Create the plugin database tables.
	 *
	 * @return void
	 */
	public static function ac_create_database_tables() {

		global $wpdb;

		// Get the database character collate that will be appended at the end of each query.
		$charset_collate = $wpdb->get_charset_collate();

		// check database version and create the database.
		if ( intval( get_option( 'daexthrmal_database_version' ), 10 ) < 1 ) {

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			// create *prefix*_statistic.
			$table_name = $wpdb->prefix . 'daexthrmal_connection';
			$sql        = "CREATE TABLE $table_name (
                connection_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                url_to_connect TEXT DEFAULT '' NOT NULL,
                url1 TEXT DEFAULT '' NOT NULL,
                language1 VARCHAR(9) DEFAULT '' NOT NULL,
                script1 VARCHAR(4) DEFAULT '' NOT NULL,
                locale1 VARCHAR(2) DEFAULT '' NOT NULL,
                url2 TEXT DEFAULT '' NOT NULL,
                language2 VARCHAR(9) DEFAULT '' NOT NULL,
                script2 VARCHAR(4) DEFAULT '' NOT NULL,
                locale2 VARCHAR(2) DEFAULT '' NOT NULL,
                url3 TEXT DEFAULT '' NOT NULL,
                language3 VARCHAR(9) DEFAULT '' NOT NULL,
                script3 VARCHAR(4) DEFAULT '' NOT NULL,
                locale3 VARCHAR(2) DEFAULT '' NOT NULL,
                url4 TEXT DEFAULT '' NOT NULL,
                language4 VARCHAR(9) DEFAULT '' NOT NULL,
                script4 VARCHAR(4) DEFAULT '' NOT NULL,
                locale4 VARCHAR(2) DEFAULT '' NOT NULL,
                url5 TEXT DEFAULT '' NOT NULL,
                language5 VARCHAR(9) DEFAULT '' NOT NULL,
                script5 VARCHAR(4) DEFAULT '' NOT NULL,
                locale5 VARCHAR(2) DEFAULT '' NOT NULL,
                url6 TEXT DEFAULT '' NOT NULL,
                language6 VARCHAR(9) DEFAULT '' NOT NULL,
                script6 VARCHAR(4) DEFAULT '' NOT NULL,
                locale6 VARCHAR(2) DEFAULT '' NOT NULL,
                url7 TEXT DEFAULT '' NOT NULL,
                language7 VARCHAR(9) DEFAULT '' NOT NULL,
                script7 VARCHAR(4) DEFAULT '' NOT NULL,
                locale7 VARCHAR(2) DEFAULT '' NOT NULL,
                url8 TEXT DEFAULT '' NOT NULL,
                language8 VARCHAR(9) DEFAULT '' NOT NULL,
                script8 VARCHAR(4) DEFAULT '' NOT NULL,
                locale8 VARCHAR(2) DEFAULT '' NOT NULL,
                url9 TEXT DEFAULT '' NOT NULL,
                language9 VARCHAR(9) DEFAULT '' NOT NULL,
                script9 VARCHAR(4) DEFAULT '' NOT NULL,
                locale9 VARCHAR(2) DEFAULT '' NOT NULL,
                url10 TEXT DEFAULT '' NOT NULL,
                language10 VARCHAR(9) DEFAULT '' NOT NULL,
                script10 VARCHAR(4) DEFAULT '' NOT NULL,
                locale10 VARCHAR(2) DEFAULT '' NOT NULL
            ) $charset_collate";
			dbDelta( $sql );

			// Update database version.
			update_option( 'daexthrmal_database_version', '1' );

		}
	}

	/**
	 * Plugin delete.
	 *
	 * @return void
	 */
	public static function un_delete() {

		// Delete options and tables for all the sites in the network.
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			// Get the current blog id.
			global $wpdb;
			$current_blog = $wpdb->blogid;

			// Create an array with all the blog ids.

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

			// Iterate through all the blogs.
			foreach ( $blogids as $blog_id ) {

				// Switch to the iterated blog.
				switch_to_blog( $blog_id );

				// Create options and tables for the iterated blog.
				self::un_delete_options();
				self::un_delete_database_tables();

			}

			// Switch to the current blog.
			switch_to_blog( $current_blog );

		} else {

			// If this is not a multisite installation delete options and tables only for the current blog.
			self::un_delete_options();
			self::un_delete_database_tables();

		}
	}

	/**
	 * Delete plugin options.
	 *
	 * @return void
	 */
	public static function un_delete_options() {

		// Assign an instance of Daexthrmal_Shared.
		$shared = Daexthrmal_Shared::get_instance();

		foreach ( $shared->get( 'options' ) as $key => $value ) {
			delete_option( $key );
		}

		// Delete the option used by the DAEXT_Notices_Manager class to persist the notices state.
		delete_option( $shared->get( 'slug' ) . '_notices_state' );

	}

	/**
	 * Delete plugin database tables.
	 *
	 * @return void
	 */
	public static function un_delete_database_tables() {

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->query( "DROP TABLE {$wpdb->prefix}daexthrmal_connection" );
	}

	// meta box -----------------------------------------------------------------.

	/**
	 * The add_meta_boxes hook callback.
	 *
	 * @return void
	 */
	public function create_meta_box() {

		// Verify the capability.
		if ( current_user_can( 'edit_others_posts' ) ) {

			$post_types_a = $this->shared->get_post_types_with_ui();

			foreach ( $post_types_a as $key => $post_type ) {
				$post_type = trim( $post_type );
				add_meta_box(
					'daexthrmal-meta',
					'Hreflang Manager',
					array( $this, 'meta_box_callback' ),
					$post_type,
					'normal',
					'high',
					// Ref: https://make.wordpress.org/core/2018/11/07/meta-box-compatibility-flags/ .
					array(

						/*
						 * It's not confirmed that this meta box works in the block editor.
						 */
						'__block_editor_compatible_meta_box' => false,

						/*
						 * This meta box should only be loaded in the classic editor interface, and the block editor
						 * should not display it.
						 */
						'__back_compat_meta_box' => true,

					)
				);
			}
		}
	}

	/**
	 * Display the Hreflang Manager meta box content.
	 *
	 * @return void
	 */
	public function meta_box_callback() {

		?>

			<?php

			/**
			 * Look for a connection that has as a url_to_connect value the permalink value of this post
			 *
			 *  If there is already a connection:
			 *  - show the form with the field already filled with the value from the database
			 *  If there is no connection:
			 *  - show the form with empty fields
			 */

			// Get the number of connections that should be displayed in the menu.
			$connections_in_menu = 10;

			$permalink = $this->shared->get_permalink( get_the_ID(), true );

			// Look for $permalink in the url_to_connect field of the daexthrmal_connection database table.
			global $wpdb;

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$permalink_connections = $wpdb->get_row(
				$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}daexthrmal_connection WHERE url_to_connect = %s", $permalink )
			);

			if ( null === $permalink_connections ) {

				// Default empty form.
				for ( $i = 1; $i <= $connections_in_menu; $i++ ) {

					?>

					<div class="daexthrmal-metabox-single-connection">

					<!-- url -->
					<div class="daexthrmal-field">
						<div class="daexthrmal-label">
							<label for="url<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'URL', 'hreflang-manager-lite' ); ?> <?php echo esc_html( $i ); ?></label>
						</div>
						<div class="daexthrmal-input">
							<input autocomplete="off" type="text" id="url<?php echo esc_attr( $i ); ?>" maxlength="2083" name="url<?php echo esc_attr( $i ); ?>" class="regular-text daexthrmal-url"/>
						</div>
					</div>

					<!-- Language -->
					<div class="daexthrmal-field">
						<div class="daexthrmal-label">
							<label for="language<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Language', 'hreflang-manager-lite' ); ?> <?php echo esc_html( $i ); ?></label>
						</div>
						<div class="daexthrmal-input">
							<select id="language<?php echo esc_attr( $i ); ?>" class="daexthrmal-language" name="language<?php echo esc_attr( $i ); ?>">
								<?php

								$array_language = get_option( 'daexthrmal_language' );
								foreach ( $array_language as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" ' . selected( get_option( 'daexthrmal_default_language_' . $i ), $value, false ) . '>' . esc_html( $value ) . ' - ' . esc_html( $key ) . '</option>';
								}

								?>
							</select>
						</div>
					</div>

					<!-- Script -->
					<div class="daexthrmal-field">
						<div class="daexthrmal-label">
							<label for="script<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Script', 'hreflang-manager-lite' ); ?> <?php echo esc_html( $i ); ?></label>
						</div>
						<div class="daexthrmal-input">
							<select id="script<?php echo esc_attr( $i ); ?>" class="daexthrmal-script" name="script<?php echo esc_attr( $i ); ?>">
								<option value=""><?php esc_html_e( 'Not Assigned', 'hreflang-manager-lite' ); ?></option>
								<?php

								$array_language = get_option( 'daexthrmal_script' );
								foreach ( $array_language as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" ' . selected( get_option( 'daexthrmal_default_script_' . $i ), $value, false ) . '>' . esc_html( $value ) . ' - ' . esc_html( $key ) . '</option>';
								}

								?>
							</select>
						</div>
					</div>

					<!-- Locale -->
					<div class="daexthrmal-field">
						<div class="daexthrmal-label">
							<label for="locale<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Locale', 'hreflang-manager-lite' ); ?> <?php echo esc_html( $i ); ?></label>
						</div>
						<div class="daexthrmal-input">
							<select id="locale<?php echo esc_attr( $i ); ?>" class="daexthrmal-locale" name="locale<?php echo esc_attr( $i ); ?>">
								<option value=""><?php esc_html_e( 'Not Assigned', 'hreflang-manager-lite' ); ?></option>
								<?php

								$array_locale = get_option( 'daexthrmal_locale' );
								foreach ( $array_locale as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" ' . selected( get_option( 'daexthrmal_default_locale_' . $i ), $value, false ) . '>' . esc_html( $value ) . ' - ' . esc_html( $key ) . '</option>';
								}

								?>
							</select>
						</div>
					</div>

					</div>

					<?php

				}
			} else {
				
				// Form with data retrieved form the database.
				for ( $i = 1; $i <= $connections_in_menu; $i++ ) {

					?>

					<div class="daexthrmal-metabox-single-connection">

					<!-- url -->
					<div class="daexthrmal-field">
						<div class="daexthrmal-label">
							<label for="url<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'URL', 'hreflang-manager-lite' ); ?> <?php echo esc_html( $i ); ?></label>
						</div>
						<div class="daexthrmal-input">
							<input autocomplete="off" type="text" value="<?php echo esc_attr( stripslashes( $permalink_connections->{'url' .$i} ) ); ?>" id="url<?php echo esc_attr( $i ); ?>" maxlength="2083" name="url<?php echo esc_attr( $i ); ?>" class="regular-text daexthrmal-url"/>
						</div>
					</div>

					<!-- Language <?php echo intval( $i, 10 ); ?> -->
					<div class="daexthrmal-field">
						<div class="daexthrmal-label">
							<label for="language<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Language', 'hreflang-manager-lite' ); ?> <?php echo esc_html( $i ); ?></label>
						</div>
						<div class="daexthrmal-input">
							<select id="language<?php echo esc_attr( $i ); ?>" class="daexthrmal-language" name="language<?php echo esc_attr( $i ); ?>">
								<?php

								$array_language = get_option( 'daexthrmal_language' );
								foreach ( $array_language as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" ' . selected( $permalink_connections->{'language' . $i}, $value, false ) . '>' . esc_html( $value ) . ' - ' . esc_html( $key ) . '</option>';
								}

								?>
							</select>
						</div>
					</div>

					<!-- Script <?php echo intval( $i, 10 ); ?> -->
					<div class="daexthrmal-field">
						<div class="daexthrmal-label">
							<label for="script<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Script', 'hreflang-manager-lite' ); ?> <?php echo esc_html( $i ); ?></label>
						</div>
						<div class="daexthrmal-input">
							<select id="script<?php echo esc_attr( $i ); ?>" class="daexthrmal-script" name="script<?php echo esc_attr( $i ); ?>">
								<option value=""><?php esc_html_e( 'Not Assigned', 'hreflang-manager-lite' ); ?></option>
								<?php

								$array_script = get_option( 'daexthrmal_script' );
								foreach ( $array_script as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" ' . selected( $permalink_connections->{'script' . $i}, $value, false ) . '>' . esc_html( $value ) . ' - ' . esc_html( $key ) . '</option>';
								}

								?>
							</select>
						</div>
					</div>

					<!-- Locale <?php echo intval( $i, 10 ); ?> -->
					<div class="daexthrmal-field">
						<div class="daexthrmal-label">
							<label for="locale<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Locale', 'hreflang-manager-lite' ); ?> <?php echo esc_html( $i ); ?></label>
						</div>
						<div class="daexthrmal-input">
							<select id="locale<?php echo esc_attr( $i ); ?>" class="daexthrmal-locale" name="locale<?php echo esc_attr( $i ); ?>">
								<option value=""><?php esc_html_e( 'Not Assigned', 'hreflang-manager-lite' ); ?></option>
								<?php

								$array_locale = get_option( 'daexthrmal_locale' );
								foreach ( $array_locale as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" ' . selected( $permalink_connections->{'locale' . $i}, $value, false ) . '>' . esc_html( $value ) . ' - ' . esc_html( $key ) . '</option>';
								}

								?>
							</select>
						</div>
					</div>

					</div>

					<?php

				}
			}

		?>

		<?php

		// Store the original permalink to detect changes when the form is saved.
		echo '<input type="hidden" name="daexthrmal_original_permalink" value="' . esc_attr( $permalink ) . '" />';

		// Use nonce for verification.
		wp_nonce_field( plugin_basename( __FILE__ ), 'daexthrmal_nonce' );
	}

	/**
	 * Save the meta box data.
	 *
	 * @return void
	 */
	public function save_meta_box() {

		// Verify the capability.
		if ( ! current_user_can( 'edit_others_posts' ) ) {
			return;
		}

		// Security verification.

		// Verify if this is an auto save routine. If our form has not been submitted, we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		/**
		 * Verify this came from our screen and with proper authorization, because save_post can be triggered at other
		 * times.
		 */
		if ( isset( $_POST['daexthrmal_nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['daexthrmal_nonce'] ) );
			if ( ! wp_verify_nonce( $nonce, plugin_basename( __FILE__ ) ) ) {
				return;
			}
		} else {
			return;
		}

		/* - end security verification - */

		// Init vars.
		$url      = array();
		$language = array();
		$script   = array();
		$locale   = array();

		// Initialize the variables that include the URLs, the languages and the locale.
		for ( $i = 1;$i <= 10;$i++ ) {

			if ( isset( $_POST[ 'url' . $i ] ) && strlen( trim( esc_url_raw( wp_unslash( $_POST[ 'url' . $i ] ) ) ) ) > 0 ) {
				$url[ $i ]        = esc_url_raw( wp_unslash( $_POST[ 'url' . $i ] ) );
				$at_least_one_url = true;
			} else {
				$url[ $i ] = '';
			}

			if ( isset( $_POST[ 'language' . $i ] ) && strlen( trim( sanitize_text_field( wp_unslash( $_POST[ 'language' . $i ] ) ) ) ) > 0 ) {
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

		/*
		 * save the fields in the daexthrmal_connection database table:
		 *
		 * - if a row with the daexthrmal_connection equal to the current permalink already exists update the row
		 *
		 * - if a row with the daexthrmal_connection equal to the current permalink doesn't exists create a new row
		 */
		$permalink = $this->shared->get_permalink( get_the_ID(), true );

		// Retrieve the original permalink from the hidden form field.
		$original_permalink = isset( $_POST['daexthrmal_original_permalink'] ) ? esc_url_raw( wp_unslash( $_POST['daexthrmal_original_permalink'] ) ) : '';

		// Update url_to_connect when a permalink change is detected.
		global $wpdb;
		if ( ! empty( $original_permalink ) && ! empty( $permalink ) && $original_permalink !== $permalink ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->query(
				$wpdb->prepare(
					"UPDATE {$wpdb->prefix}daexthrmal_connection SET "
					. 'url_to_connect = %s WHERE url_to_connect = %s ',
					$permalink,
					$original_permalink
				)
			);
		}

		// Look for $permalink in the url_to_connect field of the daexthrmal_connection database table.
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
				return;}

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
	}

	/**
	 * Register the admin menu.
	 *
	 * @return void
	 */
	public function me_add_admin_menu() {

		$icon_svg = '
		<svg id="globe" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 40 40">
		  <defs>
		    <style>
		      .cls-1 {
		        fill: #fff;
		        stroke-width: 0;
		      }
		    </style>
		  </defs>
		  <path class="cls-1" d="M38,20c0-9.4-7.3-17.2-16.5-17.9-.5,0-1,0-1.5,0s-1,0-1.5,0C9.3,2.8,2,10.6,2,20s7.3,17.2,16.5,17.9c.5,0,1,0,1.5,0s1,0,1.5,0c9.2-.8,16.5-8.5,16.5-17.9ZM30,19c-.1-2.7-.7-5.2-1.6-7.6,1.3-.5,2.6-1.1,3.8-1.9,2.2,2.6,3.6,5.8,3.9,9.4h-6ZM21,4.4c1.8,1.7,3.4,3.6,4.6,5.8-1.5.4-3,.7-4.6.7v-6.6ZM19,11c-1.6,0-3.1-.3-4.6-.7,1.2-2.2,2.7-4.2,4.6-5.8v6.6ZM19,13v6h-7c.1-2.4.6-4.8,1.5-6.9,1.7.5,3.6.8,5.4.9ZM19,21v6c-1.9,0-3.7.4-5.4.9-.9-2.2-1.4-4.5-1.5-6.9h7ZM19,29v6.6c-1.8-1.7-3.4-3.6-4.6-5.8,1.5-.4,3-.7,4.6-.7ZM21,29c1.6,0,3.1.3,4.6.7-1.2,2.2-2.7,4.2-4.6,5.8v-6.6ZM21,27v-6h7c-.1,2.4-.6,4.8-1.5,6.9-1.7-.5-3.6-.8-5.4-.9ZM21,19v-6c1.9,0,3.7-.4,5.4-.9.9,2.2,1.4,4.5,1.5,6.9h-7ZM27.5,9.6c-.9-1.8-2.1-3.5-3.5-5.1,2.5.6,4.8,1.9,6.6,3.5-1,.6-2,1.1-3.1,1.5ZM12.5,9.6c-1.1-.4-2.1-.9-3.1-1.5,1.9-1.7,4.1-2.9,6.6-3.5-1.4,1.5-2.6,3.2-3.5,5.1ZM11.7,11.4c-.9,2.4-1.5,4.9-1.6,7.6h-6c.2-3.6,1.6-6.9,3.9-9.4,1.2.7,2.4,1.4,3.8,1.9ZM10,21c.1,2.7.7,5.2,1.6,7.6-1.3.5-2.6,1.1-3.8,1.9-2.2-2.6-3.6-5.8-3.9-9.4h6ZM12.5,30.4c.9,1.8,2.1,3.5,3.5,5.1-2.5-.6-4.8-1.9-6.6-3.5,1-.6,2-1.1,3.1-1.5ZM27.5,30.4c1.1.4,2.1.9,3.1,1.5-1.9,1.7-4.1,2.9-6.6,3.5,1.4-1.5,2.6-3.2,3.5-5.1ZM28.3,28.6c.9-2.4,1.5-4.9,1.6-7.6h6c-.2,3.6-1.6,6.9-3.9,9.4-1.2-.7-2.4-1.4-3.8-1.9Z"/>
		</svg>';

		$icon_svg = 'data:image/svg+xml;base64,' . base64_encode( $icon_svg );

		add_menu_page(
			'HM',
			'Hreflang',
			'manage_options',
			$this->shared->get( 'slug' ) . '_connections',
			array( $this, 'me_display_menu_connections' ),
			$icon_svg
		);

		$this->screen_id_connections = add_submenu_page(
			$this->shared->get( 'slug' ) . '_connections',
			esc_html__( 'HM - Connections', 'hreflang-manager-lite' ),
			esc_html__( 'Connections', 'hreflang-manager-lite' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '_connections',
			array( $this, 'me_display_menu_connections' )
		);

		$this->screen_id_tools = add_submenu_page(
			$this->shared->get( 'slug' ) . '_connections',
			esc_html__( 'HM - Tools', 'hreflang-manager-lite' ),
			esc_html__( 'Tools', 'hreflang-manager-lite' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '_tools',
			array( $this, 'me_display_menu_tools' )
		);

		$this->screen_id_options = add_submenu_page(
			$this->shared->get( 'slug' ) . '_connections',
			esc_html__( 'HM - Options', 'hreflang-manager-lite' ),
			esc_html__( 'Options', 'hreflang-manager-lite' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '_options',
			array( $this, 'me_display_menu_options' )
		);

		add_submenu_page(
			$this->shared->get( 'slug' ) . '_connections',
			esc_html__( 'Documentation', 'hreflang-manager-lite' ),
			esc_html__( 'Documentation', 'hreflang-manager-lite' ) . '<i class="dashicons dashicons-external" style="font-size:12px;vertical-align:-2px;height:10px;"></i>',
			'manage_options',
			'https://daext.com/kb/hreflang-manager/',
		);
	}

	/**
	 * Includes the connections view.
	 *
	 * @return void
	 */
	public function me_display_menu_connections() {
		include_once 'view/connections.php';
	}

	/**
	 * Includes the Tools view.
	 *
	 * @return void
	 */
	public function me_display_menu_tools() {
		include_once 'view/tools.php';
	}

	/**
	 * Includes the Options view.
	 *
	 * @return void
	 */
	public function me_display_menu_options() {
		include_once 'view/options.php';
	}

	/**
	 * Deletes a connection by using the permalink of the trashed post. Note that this operation is performed only if
	 *  the 'Auto Delete' option is enabled.
	 *
	 * @param int $post_id The id of the trashed post.
	 *
	 * @return void
	 */
	public function delete_post_connection( $post_id ) {

		if ( 1 === intval( get_option( $this->shared->get( 'slug' ) . '_auto_delete' ), 10 ) ) {

			$permalink = get_the_permalink( $post_id, false );

			global $wpdb;

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->query(
				$wpdb->prepare( "DELETE FROM {$wpdb->prefix}daexthrmal_connection WHERE url_to_connect = %s", $permalink )
			);

		}
	}

	/**
	 * Plugin deactivation.
	 *
	 * @return void
	 */
	public static function dc_deactivate() {
		// Do nothing.
	}
}
