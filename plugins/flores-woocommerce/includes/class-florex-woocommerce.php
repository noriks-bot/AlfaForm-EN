<?php

/**
 * The file that defines the core plugin class
 *
 * @link       https://noriks.com
 * @since      1.0.0
 *
 * @package    Flores_Woocommerce
 * @subpackage Flores_Woocommerce/includes
 */

class Flores_Woocommerce {

	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		if ( defined( 'FLORES_WOOCOMMERCE_VERSION' ) ) {
			$this->version = FLORES_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '5.0.0';
		}
		$this->plugin_name = 'flores-woocommerce';

		add_action( 'plugins_loaded', [$this, 'update_db'] );

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * DB updates on existing tables
	 * 
	 * @since 3.0.7
	 */
	public function update_db() {
		$current_version = get_site_option( 'flores_woo_ver' ) ?? null;

		if(! isset($current_version)) add_site_option('flores_woo_ver', $this->version);

		if ($current_version != $this->version || true == true) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			global $wpdb;

			$tablename = $wpdb->prefix.'digit_tracking_sku_events'; 

			if ( $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $tablename ) ) === $tablename ) {
				$row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$tablename' AND column_name = 'post_id'"  );
	
				if(empty($row)){
					$wpdb->query("ALTER TABLE `$tablename` ADD `post_id` INT NULL AFTER `id`;");
				}
			} else {
				$main_sql_create = "CREATE TABLE `$tablename` 
				( 
					`id` INT NOT NULL AUTO_INCREMENT , 
					`post_id` INT NULL , 
					`sku` VARCHAR(255) NOT NULL , 
					`event` VARCHAR(50) NOT NULL ,
					`date` DATETIME NOT NULL ,
					PRIMARY KEY (`id`)
				)";
	
				maybe_create_table( $tablename, $main_sql_create );
			}
		}
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-florex-woocommerce-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-florex-woocommerce-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-florex-woocommerce-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-florex-woocommerce-public.php';

		$this->loader = new Flores_Woocommerce_Loader();
	}

	private function set_locale() {
		$plugin_i18n = new Flores_Woocommerce_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	private function define_admin_hooks() {
		$plugin_admin = new Flores_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	private function define_public_hooks() {
		$plugin_public = new Flores_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}
}
