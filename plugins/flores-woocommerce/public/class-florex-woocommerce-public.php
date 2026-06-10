<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://noriks.com
 * @since      1.0.0
 *
 * @package    Flores_Woocommerce
 * @subpackage Flores_Woocommerce/public
 */

class Flores_Woocommerce_Public {

	private $plugin_name;
	private $version;
	private $db_manager;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_dependencies();

		add_action('wp', [$this, 'flores_init']);

		add_action( 'woocommerce_checkout_order_processed', [$this, 'flores_order_processed'], 10, 3 );
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/florex-woocommerce-public.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		// Scripts enqueued here if needed
	}

	public function load_dependencies() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/class-florex-woocommerce-db-manager.php';
		$this->db_manager = new Flores_Woocommerce_Db_Manager();
	}

	public function flores_init() {

		if(! $this->_bot_detected() && ! current_user_can('administrator')) {
			
			$params = array();
	
			if(isset($_GET['utm_source'])) {
				$params['utm_source'] = sanitize_url($_GET['utm_source']);
			} elseif(isset($_SERVER["HTTP_REFERER"])) {
				$referer = parse_url(htmlspecialchars($_SERVER["HTTP_REFERER"]));
				$site = parse_url(site_url());

				if(isset($referer['host']) && isset($referer['path']) && isset($site['host']) && $referer['host'] != $site['host'] && ! strpos($referer['path'], ".") !== false)
					$params['utm_source'] = sanitize_url($referer['host'].$referer['path']);
			}

			if(! isset($params['utm_source']))
				$params['utm_source'] = "direct";

			$standalone_options = get_option( 'standalone_option_config' );

			if(! isset($standalone_options) || ! isset($standalone_options['cookie_lifetime'])) {
				$days = 7;
			} else {
				$days = (is_numeric($standalone_options['cookie_lifetime'])) ? $standalone_options['cookie_lifetime'] : 7;
			}
		
			if(count($_GET)) {
				$available_parameters = $this->flores_get_option_indexes();
				
				foreach($_GET as $key => $value) {
					if(! in_array("h_ad_id", $available_parameters) && $key == "h_ad_id") $key = "flores_id";
					
					if(in_array($key, $available_parameters)) {
						$params[$key] = $value;
					}
				}
			}

			if ((is_singular()) && ($post_id = get_the_ID()) && (($sku = get_post_meta($post_id, '_sku', true)) || ($sku = get_post_meta($post_id, "_associated_sku", true)))) {
				if(isset($sku) && ! empty($sku)) {
					if(! isset($_COOKIE['stdln_vsts'])) {
						$visits = [get_the_ID()];
						$this->flores_insert_sku_event($post_id, $sku, "visit");
						setcookie("stdln_vsts", json_encode($visits), time() + ($days * 86400), '/');
					} else {
						$visits = sanitize_key($_COOKIE['stdln_vsts']);
						try {
							$visits = json_decode($visits);
							if(is_array($visits) && ! in_array($post_id, $visits)) {
								array_push($visits, $post_id);
								$this->flores_insert_sku_event($post_id, $sku, "visit");
								setcookie("stdln_vsts", json_encode($visits), time() + ($days * 86400), '/');
							}
						} catch(Exception $e) {
							error_log("Flores Tracking plugin - cookie manipulation detected");
						}
					}
				}
			}

			if (! isset($_COOKIE['stdln_hash'])) {
				$hash = hexdec(uniqid());
				$this->flores_init_wc_cookie($hash);
				setcookie("stdln_hash", $hash, time() + ($days * 86400), '/');
			} else {
				$hash = sanitize_key($_COOKIE['stdln_hash']);
			}

			$this->flores_filter_and_insert_metadata($hash, $params);
		}
	}

	protected function flores_init_wc_cookie($hash) {
		if(isset(WC()->session)) {
			if (! WC()->session->has_session() ) {
				WC()->session->set_customer_session_cookie( true );
			}
			WC()->session->set( 'custom_data', array( 'stdln_hash' => $hash ) );
		}
	}

	function flores_get_option_indexes() {
		$standalone_options = get_option( 'standalone_option_config' );

		if(! isset($standalone_options)) return array();

		$indexes = [
			'site_source_name',
			'utm_medium',
			'utm_medium_value',
			'campaign_name',
			'adset_name',
			'ad_name',
			'campaign_id',
			'adset_id',
			'ad_id',
			'placement'
		];

		$result = array();
		foreach($indexes as $index) {
			if(isset($standalone_options[$index]))
				array_push($result, $standalone_options[$index]);
		}

		array_push($result, 'flores_id');
		array_push($result, 'campaign_id');
		array_push($result, 'adset_id');
		array_push($result, 'ad_id');

		return $result;
	}

	function flores_get_index_by_value($options, $option_value) {
		if(is_array($options) && count($options) > 0) {
			foreach($options as $key => $value) {
				if($value == $option_value || ($option_value == "ad_id" && $value == "ad_id"))
					return $key;
			}
		}
		return false;
	}

	protected function flores_insert_sku_event($post_id, $sku, $event) {
		$id_product = wc_get_product_id_by_sku($sku);
		if(isset($id_product) && is_numeric($id_product)) {
			$this->db_manager->insertSKUEvent($post_id, $sku, $event);
		}
	}

	protected function flores_group_landing_url($url) {
		$url = rtrim(str_replace(array('http://','https://'), '', $url), "/");

		$cartboss = ["abandoned_cart"];
		$facebook = ["facebook", "fb", "an"];
		$instagram = ["instagram", "ig"];
		$google = ["google"];
		$tiktok = ["tiktok"];

		if( preg_match("(".implode("|",array_map("preg_quote",$cartboss)).")i",$url,$m)) {
			return "abandoned_cart";
		} elseif( preg_match("(".implode("|",array_map("preg_quote",$facebook)).")i",$url,$m)) {
			return "facebook";
		} elseif( preg_match("(".implode("|",array_map("preg_quote",$instagram)).")i",$url,$m)) {
			return "instagram";
		} elseif( preg_match("(".implode("|",array_map("preg_quote",$google)).")i",$url,$m)) {
			return "google";
		} elseif( preg_match("(".implode("|",array_map("preg_quote",$tiktok)).")i",$url,$m)) {
			return "tiktok";
		} else {
			return $url;
		}
	}

	function flores_filter_and_insert_metadata($hash, $params) {

		if(! isset($hash)) return array();

		$standalone_options = get_option( 'standalone_option_config' );
		if(! isset($standalone_options)) return array();

		$data = array();
		foreach($params as $key => $value) {
			if($column = $this->flores_get_index_by_value($standalone_options, $key)) {
				$data[$column] = $value;
			}

			if($key == 'campaign_id' && empty($data['campaign_id'])) {
				$data['campaign_id'] = $value;
			} elseif($key == 'adset_id' && empty($data['adset_id'])) {
				$data['adset_id'] = $value;
			} elseif($key == 'ad_id' && empty($data['ad_id'])) {
				$data['ad_id'] = $value;
			}
		}

		if(isset($params['flores_id']) && ! empty($params['flores_id'])) $data['ad_id'] = $params['flores_id'];

		$url = "/";
		if(filter_input(INPUT_SERVER, 'REQUEST_URI') && ! current_user_can('administrator')) {
			$url = (strtok(filter_input(INPUT_SERVER, 'REQUEST_URI'), "?"));
			if(strpos($url, ".") !== false) $url = "/";
		}

		if(isset($data['site_source_name'])) {
			$utm_source = $this->flores_group_landing_url($data['site_source_name']);
		} elseif(isset($url)) {
			$utm_source = $this->flores_group_landing_url($url);
		} else {
			$utm_source = "undefined";
		}

		if(isset($url) && ! $this->db_manager->getUserMeta($hash, 
			$url,
			$utm_source ?? null,
			$data['utm_medium'] ?? "undefined", 
			$data['campaign_name'] ?? null, 
			$data['adset_name'] ?? null, 
			$data['ad_name'] ?? null, 
			$data['campaign_id'] ?? null, 
			$data['adset_id'] ?? null, 
			$data['ad_id'] ?? null,  
			$data['placement'] ?? null)) {

			$this->db_manager->insertUserMeta(
				$hash, 
				null,
				$url,
				$utm_source ?? null,
				$data['utm_medium'] ?? "undefined",  
				$data['campaign_name'] ?? null, 
				$data['adset_name'] ?? null, 
				$data['ad_name'] ?? null, 
				$data['campaign_id'] ?? null, 
				$data['adset_id'] ?? null, 
				$data['ad_id'] ?? null,  
				$data['placement'] ?? null
			);
		}

		if(isset($data['campaign_name']) || isset($data['adset_name']) || isset($data['ad_name']) || isset($data['campaign_id']) || isset($data['adset_id']) || isset($data['ad_id'])) {
			if(! $this->db_manager->getUserAttribution(
				$hash, 
				$data['campaign_name'] ?? null, 
				$data['adset_name'] ?? null, 
				$data['ad_name'] ?? null, 
				$data['campaign_id'] ?? null, 
				$data['adset_id'] ?? null, 
				$data['ad_id'] ?? null)) {
	
				$this->db_manager->insertUserAttribution(
					$hash, 
					$data['campaign_name'] ?? null, 
					$data['adset_name'] ?? null, 
					$data['ad_name'] ?? null, 
					$data['campaign_id'] ?? null, 
					$data['adset_id'] ?? null, 
					$data['ad_id'] ?? null
				);
			}
		}	
	}

	public function flores_order_processed($order_id, $posted_data, $order) {

		if ( ! $order_id ) return;

		$order = wc_get_order( $order_id );

		// Allow code execution only once 
		if( ! get_post_meta( $order_id, '_flores_tracking_done', true ) ) {

			$hash = (isset($_COOKIE['stdln_hash'])) ? sanitize_key($_COOKIE['stdln_hash']) : null;

			if(! isset($hash) && $possible_hash = WC()->session->get('custom_data')) {
				if(isset($possible_hash['stdln_hash']))
					$hash = $possible_hash['stdln_hash'];
			}

			if($hash) {
				$this->db_manager->updateJourneyOrderID($hash, $order_id);
				unset($_COOKIE['stdln_hash']);
				setcookie('stdln_hash', "", time()-3600, '/'); 

				$journey = $this->db_manager->getOrderJourney($order_id);
				if(! empty($journey)) {
					$order->update_meta_data( '_flores_journey', json_encode($journey) );

					// Save individual meta fields for easy search/filter
					$attribution_entry = $this->get_best_attribution_entry($journey);
					if ($attribution_entry) {
						$meta_map = [
							'_flores_utm_source'    => 'utm_source',
							'_flores_utm_medium'    => 'utm_medium',
							'_flores_campaign_name' => 'campaign_name',
							'_flores_campaign_id'   => 'campaign_id',
							'_flores_adset_name'    => 'adset_name',
							'_flores_adset_id'      => 'adset_id',
							'_flores_ad_name'       => 'ad_name',
							'_flores_ad_id'         => 'ad_id',
							'_flores_landing_page'  => 'landing',
							'_flores_placement'     => 'placement',
						];

						foreach ($meta_map as $meta_key => $field) {
							if (isset($attribution_entry->$field) && !empty($attribution_entry->$field)) {
								$order->update_meta_data($meta_key, $attribution_entry->$field);
							}
						}
					}
				}
			}

			$order->update_meta_data( '_flores_tracking_done', true );
			$order->save();
		}
	}

	/**
	 * Get the best attribution entry from journey (first non-direct, or first if all direct)
	 */
	private function get_best_attribution_entry($journey) {
		if (!is_array($journey) || empty($journey)) return null;

		// Try to find first non-direct entry
		foreach ($journey as $entry) {
			if (isset($entry->utm_source) && $entry->utm_source !== 'direct' && !empty($entry->utm_source)) {
				return $entry;
			}
		}

		// All direct — return first entry
		return $journey[0];
	}

	function _bot_detected() {
		return (
		  isset($_SERVER['HTTP_USER_AGENT'])
		  && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
		);
	}

}
