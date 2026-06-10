<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://noriks.com
 * @since      1.0.0
 *
 * @package    Flores_Woocommerce
 * @subpackage Flores_Woocommerce/admin
 */

use Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController;

class Flores_Woocommerce_Admin {

	protected $standalone_options;

	private $plugin_name;
	private $version;
	private $db_manager;
	private $status_manager;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_dependencies();

		add_action( 'admin_init', array( $this, 'options_page_init' ) );
		add_action( 'admin_menu', array( $this, 'options_add_plugin_page' ) );

		add_action( 'add_meta_boxes', array( $this, 'flores_render_journey_metabox' ) );
		add_action( 'save_post', array($this, 'flores_custom_save_post') );

		/**
		 * Cron tasks
		 */
		add_action( 'init', [$this, 'schedule_my_cron_events'] );
		add_action( 'cron_flores_once_a_day', [$this, 'flores_clean_expired_hashes'] );

		/**
		 * Rest API
		 */
		add_action('rest_api_init', [$this, 'flores_register_custom_rest_api_endpoint']);

		// Source + Campaign columns in order list
		add_filter( 'manage_edit-shop_order_columns', [$this, 'flores_add_custom_orders_columns'], 10 );
		add_action( 'manage_shop_order_posts_custom_column' , [$this, 'flores_custom_orders_column_content'], 10, 2 );
	}

	public function load_dependencies() {
		require_once plugin_dir_path( __DIR__ ) . 'public/partials/class-florex-woocommerce-db-manager.php';
		require_once plugin_dir_path( __DIR__ ) . 'admin/partials/florex-woocommerce-status.php';

		$this->db_manager = new Flores_Woocommerce_Db_Manager();
		$this->status_manager = new Flores_Woocommerce_Status_Manager();
	}

	public function schedule_my_cron_events() {
		if ( ! wp_next_scheduled( 'cron_flores_once_a_day') ) {
			wp_schedule_event( strtotime('03:00:00'), 'daily', 'cron_flores_once_a_day' );
		}
	}

	public function flores_clean_expired_hashes() {
		try {
			global $wpdb;

			$standalone_options = get_option( 'standalone_option_config' );
			$cookie_lifetime = (isset($standalone_options['cookie_lifetime']) && is_numeric($standalone_options['cookie_lifetime'])) ? $standalone_options['cookie_lifetime'] : 7;
			$visitor_lifetime = (isset($standalone_options['visitor_lifetime']) && is_numeric($standalone_options['visitor_lifetime'])) ? $standalone_options['visitor_lifetime'] : 3;

			$expired = gmdate('Y-m-d', strtotime("-$cookie_lifetime days"));
			$wpdb->query(
				"DELETE FROM " . $wpdb->prefix . "digit_tracking_user_meta 
				 WHERE DATE(date) < '$expired'");

			$expired = gmdate('Y-m-d', strtotime("-$cookie_lifetime days"));
			$wpdb->query(
				"DELETE FROM " . $wpdb->prefix . "digit_tracking_user_attribution 
				 WHERE DATE(date) < '$expired'");

			$expired = gmdate('Y-m-d', strtotime("-$visitor_lifetime days"));
			$wpdb->query(
				"DELETE FROM " . $wpdb->prefix . "digit_tracking_sku_events 
				 WHERE DATE(date) < '$expired'");
		} catch(\Exception $e) {
			error_log("failed removing expired tracking rows. ".$e->getMessage());
		}
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name."-select2", plugin_dir_url( __FILE__ ) . 'css/select2.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/florex-woocommerce-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name."-select2", plugin_dir_url( __FILE__ ) . 'js/select2.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/florex-woocommerce-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function options_add_plugin_page() {
		add_menu_page(
			'Flores', // page_title
			'Flores', // menu_title
			'manage_options', // capability
			'flores', // menu_slug
			array( $this, 'options_create_admin_page' ), // function
			'dashicons-chart-area', // icon
			3 // position
		);
	}

	public function options_create_admin_page() {
		$this->standalone_options = get_option( 'standalone_option_config' ); 
		
		$this->set_defaults($this->standalone_options);

		$this->standalone_options = get_option( 'standalone_option_config' );

		$preview = $this->get_preview($this->standalone_options);

		$default_tab = null;
		$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
		?>

		<style>.update-nag, .updated, .error, .is-dismissible:not(#setting-error-settings_updated) { display: none !important; }</style>

		<div class="wrap florex-wrapper">
			<h1 style="margin-bottom: 15px;">
				<span class="dashicons dashicons-chart-area" style="font-size: 28px; margin-right: 8px;"></span>
				Flores WooCommerce Tracking
			</h1>

			<nav class="nav-tab-wrapper">
				<a href="?page=flores" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>"><?php echo __("Dashboard", "flores-woocommerce") ?></a>
				<a href="?page=flores&tab=status" class="nav-tab <?php if($tab==='status'):?>nav-tab-active<?php endif; ?>"><?php echo __("Status", "flores-woocommerce") ?></a>
				<a href="?page=flores&tab=advanced" class="nav-tab <?php if($tab==='advanced'):?>nav-tab-active<?php endif; ?>"><?php echo __("Advanced", "flores-woocommerce") ?></a>
			</nav>

			<div class="tab-content">
				<?php switch($tab) :
				case 'status':
					?>
					<?php $this->status_manager->test_databases(); ?>
					<?php
					break;
				case 'advanced':
					?>
					<div class="standalone_admin_grid">
						<div>
							<?php settings_errors(); ?>
					
							<form method="post" action="options.php">
								<?php
									settings_fields( 'standalone_option_group' );
									do_settings_sections( 'options-admin' );
									submit_button();
								?>
							</form>
						</div>
					
						<div>
							<h3><?php echo __('URL Builder preview', 'flores-woocommerce'); ?></h3>
							<div class='standalone-utm-preview' style="width: 100%" rows="10"><?php echo $preview ?></div>
						</div>
					</div>
					<?php
					break;
				default:
					?>
					<div style="padding: 20px; background: #fff; border: 1px solid #ccd0d4; margin-top: 15px;">
						<h2><?php echo __('Flores WooCommerce Tracking is active', 'flores-woocommerce'); ?> ✅</h2>
						<p><?php echo __('Your orders are being tracked with UTM parameters, campaign IDs, adset IDs, ad IDs, and landing pages.', 'flores-woocommerce'); ?></p>
						<p><?php echo __('Configure your UTM parameter mapping in the', 'flores-woocommerce'); ?> <a href="?page=flores&tab=advanced"><?php echo __('Advanced', 'flores-woocommerce'); ?></a> <?php echo __('tab.', 'flores-woocommerce'); ?></p>
						<p><?php echo __('Check the tracking data on each order detail page under "Flores - Customer Journey".', 'flores-woocommerce'); ?></p>
						<hr>
						<p><strong>API Base URL:</strong> <code>https://flores.noriks.com/wp-json/wc/v3/</code></p>
					</div>
					<?php
					break;
				endswitch; ?>
			</div>

			<h3><?php echo __("Flores WooCommerce Tracking", "flores-woocommerce") ?> <?php echo sanitize_text_field($this->version) ?></h3>
			
		</div>
	<?php }

	public function get_preview($options) {
		return sprintf("%s={{site_source_name}}&%s=%s&%s={{campaign.name}}&%s={{adset.name}}&%s={{ad.name}}&%s={{campaign.id}}&%s={{adset.id}}&%s={{ad.id}}&%s={{placement}}",
			"<span data-param='site_source_name'>".$options['site_source_name']."</span>",
			"<span data-param='utm_medium'>".$options['utm_medium']."</span>",
			"<span data-param='utm_medium_value'>".$options['utm_medium_value']."</span>",
			"<span data-param='campaign_name'>".$options['campaign_name']."</span>",
			"<span data-param='adset_name'>".$options['adset_name']."</span>",
			"<span data-param='ad_name'>".$options['ad_name']."</span>",
			"<span data-param='campaign_id'>".$options['campaign_id']."</span>",
			"<span data-param='adset_id'>".$options['adset_id']."</span>",
			"<span data-param='ad_id'>".$options['ad_id']."</span>",
			"<span data-param='placement'>".$options['placement']."</span>"
		);
	}

	public function set_defaults($options) {
		$indexes = [
			'site_source_name' => 'utm_source',
			'utm_medium' => 'utm_medium',
			'utm_medium_value' => 'social',
			'campaign_name' => 'utm_campaign',
			'adset_name' => 'utm_content',
			'ad_name' => 'utm_term',
			'campaign_id' => 'utm_id',
			'adset_id' => 'fbc_id',
			'ad_id' => 'flores_id',
			'placement' => 'utm_placement',
			'cookie_lifetime' => 7,
			'visitor_lifetime' => 3
		];

		foreach($indexes as $index => $value) {
			if(! isset($options[$index]) || empty($options[$index]))
				$options[$index] = $value;
		}

		update_option('standalone_option_config', $options);
	}

	public function options_page_init() {
		register_setting(
			'standalone_option_group',
			'standalone_option_config',
			array( $this, 'options_sanitize' )
		);

		add_settings_section(
			'options_setting_section',
			'Parameters',
			array( $this, 'options_section_info' ),
			'options-admin'
		);

		add_settings_field( 'site_source_name', '{{site_source_name}}', array( $this, 'site_source_name_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'utm_medium', 'UTM Medium', array( $this, 'utm_medium_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'utm_medium_value', 'UTM Medium default value', array( $this, 'utm_medium_value_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'campaign_name', '{{campaign.name}}', array( $this, 'campaign_name_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'adset_name', '{{adset.name}}', array( $this, 'adset_name_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'ad_name', '{{ad.name}}', array( $this, 'ad_name_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'campaign_id', '{{campaign.id}}', array( $this, 'campaign_id_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'adset_id', '{{adset.id}}', array( $this, 'adset_id_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'ad_id', '{{ad.id}}', array( $this, 'ad_id_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'placement', '{{placement}}', array( $this, 'placement_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'cookie_lifetime', 'Cookie lifetime', array( $this, 'cookie_lifetime_callback' ), 'options-admin', 'options_setting_section' );
		add_settings_field( 'visitor_lifetime', 'Unique visitor lifetime', array( $this, 'visitor_lifetime_callback' ), 'options-admin', 'options_setting_section' );
	}

	public function options_sanitize($input) {
		$sanitary_values = array();
		$text_fields = ['site_source_name', 'utm_medium', 'utm_medium_value', 'campaign_name', 'adset_name', 'ad_name', 'campaign_id', 'adset_id', 'ad_id', 'placement', 'cookie_lifetime', 'visitor_lifetime'];
		
		foreach($text_fields as $field) {
			if ( isset( $input[$field] ) ) {
				$sanitary_values[$field] = sanitize_text_field( $input[$field] );
			}
		}

		return $sanitary_values;
	}

	public function options_section_info() {}

	public function site_source_name_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[site_source_name]" id="site_source_name" value="%s">', isset( $this->standalone_options['site_source_name'] ) ? esc_attr( $this->standalone_options['site_source_name']) : '' );
	}

	public function utm_medium_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[utm_medium]" id="utm_medium" value="%s">', isset( $this->standalone_options['utm_medium'] ) ? esc_attr( $this->standalone_options['utm_medium']) : '' );
	}

	public function utm_medium_value_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[utm_medium_value]" id="utm_medium_value" value="%s">', isset( $this->standalone_options['utm_medium_value'] ) ? esc_attr( $this->standalone_options['utm_medium_value']) : '' );
	}

	public function campaign_name_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[campaign_name]" id="campaign_name" value="%s">', isset( $this->standalone_options['campaign_name'] ) ? esc_attr( $this->standalone_options['campaign_name']) : '' );
	}

	public function adset_name_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[adset_name]" id="adset_name" value="%s">', isset( $this->standalone_options['adset_name'] ) ? esc_attr( $this->standalone_options['adset_name']) : '' );
	}

	public function ad_name_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[ad_name]" id="ad_name" value="%s">', isset( $this->standalone_options['ad_name'] ) ? esc_attr( $this->standalone_options['ad_name']) : '' );
	}

	public function campaign_id_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[campaign_id]" id="campaign_id" value="%s">', isset( $this->standalone_options['campaign_id'] ) ? esc_attr( $this->standalone_options['campaign_id']) : '' );
	}

	public function adset_id_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[adset_id]" id="adset_id" value="%s">', isset( $this->standalone_options['adset_id'] ) ? esc_attr( $this->standalone_options['adset_id']) : '' );
	}

	public function ad_id_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[ad_id]" id="ad_id" value="%s">', isset( $this->standalone_options['ad_id'] ) ? esc_attr( $this->standalone_options['ad_id']) : '' );
	}

	public function placement_callback() {
		printf( '<input class="regular-text" type="text" name="standalone_option_config[placement]" id="placement" value="%s">', isset( $this->standalone_options['placement'] ) ? esc_attr( $this->standalone_options['placement']) : '' );
	}

	public function cookie_lifetime_callback() {
		printf( '<input class="regular-text" type="number" name="standalone_option_config[cookie_lifetime]" id="cookie_lifetime" value="%s">', isset( $this->standalone_options['cookie_lifetime'] ) ? esc_attr( $this->standalone_options['cookie_lifetime']) : '' );
	}

	public function visitor_lifetime_callback() {
		printf( '<input class="regular-text" type="number" name="standalone_option_config[visitor_lifetime]" id="visitor_lifetime" value="%s">', isset( $this->standalone_options['visitor_lifetime'] ) ? esc_attr( $this->standalone_options['visitor_lifetime']) : '' );
	}

	function flores_render_journey_metabox() {
		$screen = class_exists( '\Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController' ) && wc_get_container()->get( CustomOrdersTableController::class )->custom_orders_table_usage_is_enabled()
			? wc_get_page_screen_id( 'shop-order' )
			: 'shop_order';

		add_meta_box( 'flores_tracking', __('Flores - Customer Journey','flores-woocommerce'), [$this, 'flores_render_journey_display_cb'], $screen, 'normal', 'core' );

		add_meta_box( 'flores_tracking_sku', __('Connect with SKU','flores-woocommerce'), [$this, 'flores_connect_with_sku_cb'], null, 'side', 'high' );
		remove_meta_box('flores_tracking_sku', $screen, 'side');
	}

	function flores_render_journey_display_cb() {
		global $post;

		if($this->db_manager) {
			$journey = $this->db_manager->getOrderJourney($post->ID);
			
			if($journey) {
				$this->flores_render_journey($post->ID, $journey);
			} else {
				_e('No UTM records found for this order.', 'flores-woocommerce');
			}
		}
	}

	function flores_render_journey($id_order, $journey) {
		$st = 0;

		if($st == count($journey)) {
			$last = 0;
		} else {
			$last = count($journey)-1;
		}

		$first_attribution = $this->db_manager->getOrderJourneyByAttribution($id_order, ['attribution' => 'first']);
		$last_attribution = $this->db_manager->getOrderJourneyByAttribution($id_order, ['attribution' => 'last']);

		if(isset($first_attribution) && isset($first_attribution[0])) $first_attribution = $first_attribution[0];
		if(isset($last_attribution) && isset($last_attribution[0])) $last_attribution = $last_attribution[0];

		echo "<table class='digit-journey'>";
		foreach($journey as $row) {
			
			if($st == 0 && $last != 0) echo "<tr><th colspan='2'><h3>".__('First click', 'flores-woocommerce')."</h3></th></tr>";
			elseif($st == 0 && $last == 0) echo "<tr><th colspan='2'><h3>".__('First & only click', 'flores-woocommerce')."</h3></th></tr>"; 
			elseif($st > 0 && $st == $last) echo "<tr><th colspan='2'><h3>".__('Last click', 'flores-woocommerce')."</h3></th></tr>";
			else echo "<tr><th colspan='2'><h3>".__('Click number: ', 'flores-woocommerce').($st+1)."</h3></th></tr>";

			$this->flores_render_journey_row_details($row, $first_attribution, $last_attribution);

			$st++;
		}
		echo '</table>';
	}

	function flores_connect_with_sku_cb() {
		global $pagenow;

		if ( 'post.php' === $pagenow && isset($_GET['post']) && 'product' === get_post_type( $_GET['post'] ) ) {
        	echo __("SKU is automatically connected on products.", "flores-woocommerce");
    	} else {
			$args = array(
				'post_type' => 'product', 
				'posts_per_page' => -1,
				'post_status'    => array( 'publish', 'private' )
			);
			
			$products = get_posts($args);
			
			if (count($products) && isset($_GET['post'])) {
				?>
				<select name="_associated_sku" id="_associated_sku">
					<option value="">Select SKU</option>
				<?php
				foreach ($products as $productPost) {
					$productSKU = get_post_meta($productPost->ID, '_sku', true);
					$selectedSKU = get_post_meta($_GET['post'], '_associated_sku', true);
			
					if(isset($productSKU) && ! empty($productSKU)) {
						$selected = (isset($selectedSKU) && $selectedSKU == $productSKU) ? "selected" : "";
						echo '<option value="'.$productSKU.'" '.$selected.'>' . $productSKU . '</option>';
					}
				}
				?>
				</select>
				<?php wp_nonce_field( 'flores_associate_sku', 'flores_associate_sku_nonce' ); ?>
				<?php
			}
		}
	}

	function flores_custom_save_post( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;

		if ( ! isset( $_POST['flores_associate_sku_nonce'] ) || ! wp_verify_nonce( $_POST['flores_associate_sku_nonce'], 'flores_associate_sku' ) ) {
		   return;
		}

		if(isset($_POST['_associated_sku']) && ! empty($_POST['_associated_sku'])) {
			$associated_sku = sanitize_text_field($_POST['_associated_sku']);
			update_post_meta($post_id, '_associated_sku', $associated_sku);
		} else {
			delete_post_meta($post_id, '_associated_sku');
		}
	}

	function flores_render_journey_row_details($row, $first_attribution = null, $last_attribution = null) {
		$product_id = (isset($row->landing)) ? $this->get_product_id_by_slug($row->landing) : null;
		if($product_id && $product = wc_get_product($product_id)) {
			$permalink = $product->get_permalink();
			$url = sprintf("<a href=%s>%s</a>", $permalink, $permalink);
		} else {
			$url = $row->landing;
		}

		$badges = $this->attribution_badge_display($row, $first_attribution, $last_attribution);
		if(isset($badges) && is_array($badges) && count($badges) > 0): ?>
			<tr class='journey-row utm-badges'>
				<th><?php foreach($badges as $badge): echo '<div class="journey-badge">'.$badge.'</div>'; endforeach; ?></th>
			</tr>
		<?php endif; ?>

		<?php if(isset($row->date)): ?>
		<tr class='journey-row utm-date'>
			<th><?php echo __('Time of visit'); ?></th>
			<td><?php echo $row->date ?></td>
		</tr>
		<?php endif; ?>

		<?php if(isset($row->landing) && $row->landing): ?>
		<tr class='journey-row utm-source'>
			<th>Landing slug</th>
			<td><?php echo $url ?></td>
		</tr>
		<?php endif; ?>

		<?php if(isset($row->utm_source) && $row->utm_source): ?>
		<tr class='journey-row utm-source'>
			<th>UTM Source</th>
			<td><?php echo $row->utm_source ?></td>
		</tr>
		<?php endif; ?>

		<?php if(isset($row->utm_medium) && $row->utm_medium): ?>
		<tr class='journey-row utm-medium'>
			<th>UTM Medium</th>
			<td><?php echo $row->utm_medium ?></td>
		</tr>
		<?php endif; ?>

		<?php if(isset($row->placement) && $row->placement): ?>
		<tr class='journey-row utm-placement'>
			<th>UTM Placement</th>
			<td><?php echo $row->placement ?></td>
		</tr>
		<?php endif; ?>

		<?php if((isset($row->campaign_name) && $row->campaign_name != "") || (isset($row->campaign_id) && $row->campaign_id != "")): ?>
		<tr class='journey-row campaign'>
			<th>UTM Campaign</th>
			<td><?php echo isset($row->campaign_name) ? $row->campaign_name : "/" ?> <?php echo isset($row->campaign_id) ? "(ID: ".$row->campaign_id.")" : "/" ?></td>
		</tr>
		<?php endif; ?>

		<?php if((isset($row->adset_name) && $row->adset_name != "") || (isset($row->adset_id) && $row->adset_id != "")): ?>
		<tr class='journey-row adset'>
			<th>UTM Adset</th>
			<td><?php echo isset($row->adset_name) ? $row->adset_name : "/" ?> <?php echo isset($row->adset_id) ? "(ID: ".$row->adset_id.")" : "/" ?></td>
		</tr>
		<?php endif; ?>

		<?php if((isset($row->ad_name) && ! empty($row->ad_name)) || (isset($row->ad_id) && ! empty($row->ad_id))): ?>
		<tr class='journey-row ad'>
			<th>UTM Ad</th>
			<td><?php echo isset($row->ad_name) ? $row->ad_name : "/" ?> <?php echo isset($row->ad_id) ? "(ID: ".$row->ad_id.")" : "/" ?></td>
		</tr>
		<?php endif; ?>
		<?php
	}

	function attribution_badge_display($row, $first_attribution = null, $last_attribution = null) {
		$labels = [];
		if(isset($row->id)) {
			if(isset($first_attribution) && isset($first_attribution->id) && $first_attribution->id == $row->id) {
				array_push($labels, __("First attribution", "flores-woocommerce"));
			}
			if(isset($last_attribution) && isset($last_attribution->id) && $last_attribution->id == $row->id) {
				array_push($labels, __("Last attribution", "flores-woocommerce"));
			}
		}
		return $labels;
	}

	function get_product_id_by_slug( $slug, $post_type = "product" ) {
		$query = new WP_Query(
			array(
				'name'   => $slug,
				'post_type'   => $post_type,
				'numberposts' => 1,
				'fields'      => 'ids',
			) );
		$posts = $query->get_posts();
		return array_shift( $posts );
	}

	/**
	 * Order list columns: Source + Campaign
	 */
	function flores_add_custom_orders_columns( $columns ) {
		$columns['flores_source'] = __( 'Source', 'flores-woocommerce' );
		$columns['flores_campaign'] = __( 'Campaign', 'flores-woocommerce' );
		return $columns;
	}

	function flores_custom_orders_column_content( $column, $post_id ) {
		if ( 'flores_source' === $column ) {
			$value = get_post_meta( $post_id, '_flores_utm_source', true );
			echo $value ? '<span style="font-size: 12px;">' . esc_html( $value ) . '</span>' : '<span style="color: #999; font-size: 12px;">—</span>';
		}
		if ( 'flores_campaign' === $column ) {
			$value = get_post_meta( $post_id, '_flores_campaign_name', true );
			if ( $value ) {
				$display = strlen($value) > 30 ? substr($value, 0, 30) . '…' : $value;
				echo '<span style="font-size: 12px;" title="' . esc_attr($value) . '">' . esc_html( $display ) . '</span>';
			} else {
				echo '<span style="color: #999; font-size: 12px;">—</span>';
			}
		}
	}

	/**
	 * Custom REST API endpoints
	 */
	function flores_register_custom_rest_api_endpoint() {
		register_rest_route( 'wc/v3', '/orders-utm-data/', array(
			'methods'  => 'GET',
			'callback' => [$this, 'flores_get_orders_utm_data_api'],
			'permission_callback' => function() {
				return current_user_can( 'edit_posts' );
			}
		));

		register_rest_route( 'wc/v3', '/flores-products/', array(
			'methods'  => 'GET',
			'callback' => [$this, 'flores_api_get_products'],
			'permission_callback' => function() {
				return current_user_can( 'edit_posts' );
			}
		));

		register_rest_route( 'wc/v3', '/flores-sku-metrics/', array(
			'methods'  => 'GET',
			'callback' => [$this, 'flores_api_get_sku_metrics'],
			'permission_callback' => function() {
				return current_user_can( 'edit_posts' );
			}
		));

		register_rest_route( 'wc/v3', '/orders-journeys/', array(
			'methods'  => 'GET',
			'callback' => [$this, 'flores_get_orders_journeys'],
			'permission_callback' => function() {
				return current_user_can( 'edit_posts' );
			}
		));
	}

	function flores_get_orders_utm_data_api($request) {
		$args = array( 'ids' => $request['include'] );
		$attribution = (isset($request['attribution'])) ? $request['attribution'] : ['attribution' => "first"];
		$result = [];

		if(isset($args['ids'])) {
			foreach($args['ids'] as $id_order) {
				$journey = $this->db_manager->getOrderJourneyByAttribution($id_order, $attribution);
				$result[$id_order] = $journey;
			}
		}
	
		$response = new WP_REST_Response($result);
		$response->set_status(200);
		return $response;
	}

	function flores_get_orders_journeys($request) {
		$args = array( 'ids' => $request['include'] );
		$result = [];
		$data = [];

		if(isset($args['ids']) && is_array($args['ids']) && count($args['ids']) > 0) {
			$result = $this->db_manager->getOrdersJourneys(implode(",", $args['ids']));
			if(is_array($result) && count($result) > 0) {
				foreach($result as $row) {
					$id_order = $row->id_order;
					$data[$id_order][] = $row;
				}
			}
		}
	
		$response = new WP_REST_Response($data);
		$response->set_status(200);
		return $response;
	}

	private function get_product_base(): string {
		static $base = null;
		if ( $base === null ) {
			$permalinks = (array) get_option( 'woocommerce_permalinks' );
			$base       = $permalinks['product_base'] ?? '';
			if ( $base === '' ) { $base = '/product/'; }
			$base = trailingslashit( '/' . ltrim( $base, '/' ) );
		}
		return $base;
	}

	private function add_product_prefix( string $slug ): string {
		$slug        = ltrim( $slug, '/' );
		$productBase = $this->get_product_base();
		$baseNoLead  = ltrim( $productBase, '/' );
		return $baseNoLead . $slug;
	}

	function flores_api_get_products($request) {
		$data = [];

		$args = array(
			'page' => (isset($request['page'])) ? $request['page'] : 1,
			'per_page' => (isset($request['per_page'])) ? $request['per_page'] : 250,
		);

		$products = $this->db_manager->getProductsOptimized($args['page'], $args['per_page']);

		if(is_array($products) && ! empty($products)) {
			foreach($products as $key => $product) {
				if(isset($product->post_id) && ! empty($product->post_id)) {
					$_product = (! isset($product->associated_post_id)) ? wc_get_product($product->post_id) : wc_get_product(wc_get_product_id_by_sku($product->associated_post_id));

					if($_product) {
						if(isset($product->associated_post_id)) {
							$url = get_permalink($product->post_id) ?? null;
							$slug = get_post_field('post_name', $product->post_id) ?? null;
						} else {
							$url = $_product->get_permalink() ?? null;
							$slug = $_product->get_slug() ?? null;
							$slug = $this->add_product_prefix( $slug );
						}

						$sku = $_product->get_sku();

						if ($_product->is_type('variation')) {
							$parent_product_id = $_product->get_parent_id();
							$parent_product = wc_get_product($parent_product_id);
							if($parent_product) {
								$parent_sku = $parent_product->get_sku();
								$slug = $this->add_product_prefix( $parent_product->get_slug() );
							} else {
								continue;
							}
						} else {
							$parent_sku = $sku;
						}

						if(empty($parent_sku)) $parent_sku = $sku;

						$old_slugs = $product->old_slugs ?? null;
						if ( ! empty( $old_slugs ) ) {
							$old_slugs_arr = array_filter( array_map( 'trim', explode( ',', $old_slugs ) ) );
							$old_slugs_arr = array_map( [ $this, 'add_product_prefix' ], $old_slugs_arr );
							$old_slugs     = implode( ',', $old_slugs_arr );
						}

						$data[$key] = [
							"id_product" => $product->post_id,
							"parent_sku" => $parent_sku ?? null,
							"sku" => $sku ?? null,
							"type" => $_product->get_type(),
							"status" => $product->post_status ?? null,
							"catalog_visibility" => $_product->get_catalog_visibility() ?? null,
							"url" => $url,
							"slug" => $slug,
							"old_slugs" => $old_slugs,
							"date_updated" => date("Y-m-d H:i:s")
						];
					}
				}
			}
		}

		$response = new WP_REST_Response($data);
		$response->set_status(200);
		return $response;
	}

	function flores_api_get_sku_metrics($request) {
		$data = [];

		if(! isset($request['date'])) {
			$response = new WP_REST_Response(['error' => "No date specified."]);
			$response->set_status(404);
			return $response;
		}

		$args = array(
			'key' => (isset($request['key'])) ? $request['key'] : "visit",
			'date' => $request['date']
		);

		$sku_metrics = $this->db_manager->getSkuMetrics($args['key'], $args['date']);

		if(isset($sku_metrics) && ! empty($sku_metrics)) {
			$response = new WP_REST_Response($sku_metrics);
			$response->set_status(200);
		} else {
			$response = new WP_REST_Response(['error' => "No data retrieved."]);
			$response->set_status(404);
		}

		return $response;
	}
}
