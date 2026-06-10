<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class EventsManager {
    private static $_instance;
    public $facebookServerEvents = array();
    private $pinterestServerEvents = array();
	public $doingAMP = false;
    private $standardParams = array();
    private $staticEvents = array();
    private $dynamicEvents = array();
    private $triggerEvents = array();
    private $triggerEventTypes = array();
    private $uniqueId = array();

    public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ),10 );
        add_action( 'wp_enqueue_scripts', array( $this, 'setupEventsParams' ),14 );
        add_action( 'wp_enqueue_scripts', array( $this, 'outputData' ),15 );
		add_action( 'wp_footer', array( $this, 'outputNoScriptData' ), 10 );

        // Classic hook for checkout page
        add_filter( 'script_loader_tag', array( $this, 'add_data_attribute_to_script' ), 10, 3 );
	}

    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;


    }
    function add_data_attribute_to_script( $tag, $handle, $src ) {
        $array_scripts = array('js-cookie-pys', 'jquery-bind-first', 'js-tld', 'pys');

        // Add defer attribute to all plugin scripts for better performance
        $defer_scripts = array(
                'jquery-bind-first',
                'js-cookie-pys',
                'js-sha256',
                'js-tld',
                'pys',
                'vimeo',
                'pys-pinterest',
                'pys-bing',
                'pys_sp_public_js',
                'pys-reddit'
        );

        if ( in_array( $handle, $defer_scripts, true ) ) {
            // Add defer attribute if not already present
            if ( strpos( $tag, 'defer' ) === false && strpos( $tag, 'async' ) === false ) {
                $tag = str_replace( ' src=', ' defer src=', $tag );
            }
        }

        if ( 'js-cookie-pys' === $handle && isCookiebotPluginActivated()) {
            $tag = str_replace( 'src=', 'data-cookieconsent="true" src=', $tag );
        }
        return $tag;
    }
	public function enqueueScripts() {

        // Register core scripts (all in footer for better performance)
        wp_register_script( 'jquery-bind-first', PYS_FREE_URL . '/dist/scripts/jquery.bind-first-0.2.3.min.js', array( 'jquery' ), '0.2.3', true);

        wp_register_script( 'js-cookie-pys', PYS_FREE_URL . '/dist/scripts/js.cookie-2.1.3.min.js', array(), '2.1.3', true );
        wp_register_script( 'js-tld', PYS_FREE_URL . '/dist/scripts/tld.min.js', array( 'jquery' ), '2.3.1', true );

        // Enqueue core scripts
        wp_enqueue_script( 'jquery-bind-first' );
        wp_enqueue_script( 'js-cookie-pys' );
        wp_enqueue_script( 'js-tld' );

        // Load main plugin script (compressed or uncompressed)
        if ( PYS()->getOption( 'compress_front_js' )){
            wp_enqueue_script( 'pys', PYS_FREE_URL . '/dist/scripts/public.min.js',
                array( 'jquery','js-cookie-pys', 'jquery-bind-first','js-tld' ), PYS_FREE_VERSION, true );
        }
        else
        {
            wp_enqueue_script( 'pys', PYS_FREE_URL . '/dist/scripts/public.js',
                array( 'jquery','js-cookie-pys', 'jquery-bind-first','js-tld' ), PYS_FREE_VERSION, true );
        }


	}

	public function outputData() {

		$data = array(
            'staticEvents'          => $this->staticEvents,
            'dynamicEvents'         => $this->dynamicEvents,
            'triggerEvents'         => $this->triggerEvents,
            'triggerEventTypes'     => $this->triggerEventTypes,
        );
		// collect options for configured pixel
		foreach ( PYS()->getRegisteredPixels() as $pixel ) {
			/** @var Pixel|Settings $pixel */

		    if ( $pixel->configured() ) {
			    $data[ $pixel->getSlug() ] = $pixel->getPixelOptions();
		    }

		}

		$pys_analytics_storage_mode = has_filter( 'pys_analytics_storage_mode' );
		$pys_ad_storage_mode = has_filter( 'pys_ad_storage_mode' );
		$pys_ad_user_data_mode = has_filter( 'pys_ad_user_data_mode' );
		$pys_ad_personalization_mode = has_filter( 'pys_ad_personalization_mode' );
		$google_consent_mode = ( has_filter( 'cm_google_consent_mode' ) || $pys_analytics_storage_mode || $pys_ad_storage_mode || $pys_ad_user_data_mode || $pys_ad_personalization_mode ) ? true : PYS()->getOption( 'google_consent_mode' );

		$options = array(
			'debug'                            => PYS()->getOption( 'debug_enabled' ),
			'siteUrl'                          => site_url(),
			'ajaxUrl'                          => admin_url( 'admin-ajax.php' ),
			'ajax_event'                       => wp_create_nonce( 'ajax-event-nonce' ),
			'enable_remove_download_url_param' => PYS()->getOption( 'enable_remove_download_url_param' ),
			'cookie_duration'                  => PYS()->getOption( 'cookie_duration' ),
			'last_visit_duration'              => PYS()->getOption( 'last_visit_duration' ),
			'enable_success_send_form'         => PYS()->getOption( 'enable_success_send_form' ),
			'ajaxForServerEvent'               => PYS()->getOption( 'server_event_use_ajax' ),
            "ajaxForServerStaticEvent"         => PYS()->getOption( 'server_static_event_use_ajax' ),
            "useSendBeacon"                     => PYS()->getOption( 'use_send_beacon' ),
			"send_external_id"                 => PYS()->getOption( 'send_external_id' ),
			"external_id_expire"               => PYS()->getOption( 'external_id_expire' ),
            "track_cookie_for_subdomains"      => PYS()->getOption( 'track_cookie_for_subdomains' ),
			"google_consent_mode"              => $google_consent_mode
		);

		$options[ 'gdpr' ] = array(
			'ajax_enabled'               => PYS()->getOption( 'gdpr_ajax_enabled' ),
			'all_disabled_by_api'        => apply_filters( 'pys_disable_by_gdpr', false ),
			'facebook_disabled_by_api'   => apply_filters( 'pys_disable_facebook_by_gdpr', false ),
			'analytics_disabled_by_api'  => apply_filters( 'pys_disable_analytics_by_gdpr', false ),
			'google_ads_disabled_by_api' => apply_filters( 'pys_disable_google_ads_by_gdpr', false ),
			'pinterest_disabled_by_api'  => apply_filters( 'pys_disable_pinterest_by_gdpr', false ),
			'bing_disabled_by_api'       => apply_filters( 'pys_disable_bing_by_gdpr', false ),
			'reddit_disabled_by_api'     => apply_filters( 'pys_disable_reddit_by_gdpr', false ),

			'externalID_disabled_by_api' => apply_filters( 'pys_disable_externalID_by_gdpr', false ),

			'facebook_prior_consent_enabled'   => PYS()->getOption( 'gdpr_facebook_prior_consent_enabled' ),
			'analytics_prior_consent_enabled'  => PYS()->getOption( 'gdpr_analytics_prior_consent_enabled' ),
			'google_ads_prior_consent_enabled' => PYS()->getOption( 'gdpr_google_ads_prior_consent_enabled' ),
			'pinterest_prior_consent_enabled'  => PYS()->getOption( 'gdpr_pinterest_prior_consent_enabled' ),
			'bing_prior_consent_enabled'       => PYS()->getOption( 'gdpr_bing_prior_consent_enabled' ),


			'cookiebot_integration_enabled'          => isCookiebotPluginActivated() && PYS()->getOption( 'gdpr_cookiebot_integration_enabled' ),
			'cookiebot_facebook_consent_category'    => PYS()->getOption( 'gdpr_cookiebot_facebook_consent_category' ),
			'cookiebot_analytics_consent_category'   => PYS()->getOption( 'gdpr_cookiebot_analytics_consent_category' ),
			'cookiebot_tiktok_consent_category'      => PYS()->getOption( 'gdpr_cookiebot_tiktok_consent_category' ),
			'cookiebot_google_ads_consent_category'  => PYS()->getOption( 'gdpr_cookiebot_google_ads_consent_category' ),
			'cookiebot_pinterest_consent_category'   => PYS()->getOption( 'gdpr_cookiebot_pinterest_consent_category' ),
			'cookiebot_bing_consent_category'        => PYS()->getOption( 'gdpr_cookiebot_bing_consent_category' ),
			'consent_magic_integration_enabled'      => isConsentMagicPluginActivated() && PYS()->getOption( 'consent_magic_integration_enabled' ),
			'real_cookie_banner_integration_enabled' => isRealCookieBannerPluginActivated() && PYS()->getOption( 'gdpr_real_cookie_banner_integration_enabled' ),
			'cookie_notice_integration_enabled'      => isCookieNoticePluginActivated() && PYS()->getOption( 'gdpr_cookie_notice_integration_enabled' ),
			'cookie_law_info_integration_enabled'    => isCookieLawInfoPluginActivated() && PYS()->getOption( 'gdpr_cookie_law_info_integration_enabled' ),
		);

		$options[ 'gdpr' ] = array_merge( $options[ 'gdpr' ], apply_filters( 'cm_google_consent_mode', array(
			'analytics_storage'  => array(
				'enabled' => $google_consent_mode,
				'value'   => 'granted',
			),
			'ad_storage'         => array(
				'enabled' => $google_consent_mode,
				'value'   => 'granted',
			),
			'ad_user_data'       => array(
				'enabled' => $google_consent_mode,
				'value'   => 'granted',
			),
			'ad_personalization' => array(
				'enabled' => $google_consent_mode,
				'value'   => 'granted',
			),
		) ) );

		$options[ 'gdpr' ][ 'analytics_storage' ][ 'filter' ] = $pys_analytics_storage_mode;
		$options[ 'gdpr' ][ 'ad_storage' ][ 'filter' ] = $pys_ad_storage_mode;
		$options[ 'gdpr' ][ 'ad_user_data' ][ 'filter' ] = $pys_ad_user_data_mode;
		$options[ 'gdpr' ][ 'ad_personalization' ][ 'filter' ] = $pys_ad_personalization_mode;
		$options[ 'gdpr' ][ 'analytics_storage' ][ 'value' ] = $pys_analytics_storage_mode ? ( apply_filters( 'pys_analytics_storage_mode', true ) ? 'granted' : 'denied' ) : $options[ 'gdpr' ][ 'analytics_storage' ][ 'value' ];
		$options[ 'gdpr' ][ 'ad_storage' ][ 'value' ] = $pys_ad_storage_mode ? ( apply_filters( 'pys_ad_storage_mode', true ) ? 'granted' : 'denied' ) : $options[ 'gdpr' ][ 'ad_storage' ][ 'value' ];
		$options[ 'gdpr' ][ 'ad_user_data' ][ 'value' ] = $pys_ad_user_data_mode ? ( apply_filters( 'pys_ad_user_data_mode', true ) ? 'granted' : 'denied' ) : $options[ 'gdpr' ][ 'ad_user_data' ][ 'value' ];
		$options[ 'gdpr' ][ 'ad_personalization' ][ 'value' ] = $pys_ad_personalization_mode ? ( apply_filters( 'pys_ad_personalization_mode', true ) ? 'granted' : 'denied' ) : $options[ 'gdpr' ][ 'ad_personalization' ][ 'value' ];

		$options[ 'cookie' ] = array(
			'disabled_all_cookie'                => apply_filters( 'pys_disable_all_cookie', false ),
			'disabled_start_session_cookie'      => apply_filters( 'pys_disabled_start_session_cookie', false ),
			'disabled_advanced_form_data_cookie' => apply_filters( 'pys_disable_advanced_form_data_cookie', false ) || apply_filters( 'pys_disable_advance_data_cookie', false ),
			'disabled_landing_page_cookie'       => apply_filters( 'pys_disable_landing_page_cookie', false ),
			'disabled_first_visit_cookie'        => apply_filters( 'pys_disable_first_visit_cookie', false ),
			'disabled_trafficsource_cookie'      => apply_filters( 'pys_disable_trafficsource_cookie', false ),
			'disabled_utmTerms_cookie'           => apply_filters( 'pys_disable_utmTerms_cookie', false ),
			'disabled_utmId_cookie'              => apply_filters( 'pys_disable_utmId_cookie', false ),
		);

		$options[ 'tracking_analytics' ] = array(
			"TrafficLanding" => sanitize_url($_COOKIE[ 'pys_landing_page' ] ?? $_SESSION[ 'LandingPage' ] ?? 'undefined'),
			"TrafficUtms"    => getUtms(),
			"TrafficUtmsId"  => getUtmsId(),
		);

        $options['GATags']["ga_datalayer_type"] = GATags()->getOption('gtag_datalayer_type');
        $options['GATags']["ga_datalayer_name"] = GATags()->getOption('gtag_datalayer_name');
        /**
         * @var EventsFactory[] $eventsFactory
         */
        $eventsFactory = apply_filters("pys_event_factory",[]);
        foreach ($eventsFactory as $factory) {
            $opt =  $factory->getOptions();
            if(!empty($opt)) {
                $options[$factory::getSlug()] = $factory->getOptions();
            }
        }
        $options['cache_bypass'] = time();

        $data = array_merge( $data, $options );

		wp_localize_script( 'pys', 'pysOptions', $data );

	}
	
	public function outputNoScriptData() {
        if(!apply_filters( 'pys_disable_by_gdpr', false)) {
            foreach (PYS()->getRegisteredPixels() as $pixel) {
                /** @var Pixel|Settings $pixel */
                if (!apply_filters('pys_disable_' . $pixel->getSlug() . '_by_gdpr', false)) {
                    $pixel->outputNoScriptEvents();
                }
            }
        }
    }






    public function setupEventsParams() {

        $this->standardParams = getStandardParams();
        $this->facebookServerEvents = array();


        /**
         * @var EventsFactory[] $eventsFactory
         **/
        $eventsFactory = apply_filters("pys_event_factory",[]);

        foreach ($eventsFactory as $factory) {
            if(!$factory->isEnabled())  continue;
            $events = $factory->generateEvents();
            $this->addEvents($events,$factory->getSlug());
        }

		// initial event
		$initEvent = new SingleEvent('init_event',EventTypes::$STATIC,'');

		foreach ( PYS()->getRegisteredPixels() as $pixel ) {

			$events = $pixel->generateEvents( $initEvent );
			foreach ($events as $event) {
				$params = array();
				if( get_post_type() == "post" && !is_archive() ) {
					global $post;
					$catIds = wp_get_object_terms( $post->ID, 'category', array( 'fields' => 'names' ) );
					$params[ 'post_category' ] = implode(", ",$catIds) ;
				}

				$slug = $pixel->getSlug();
				if( $slug !== "reddit" ) {
					$event->addParams( $params );
					$event->addParams( $this->standardParams );
				}
				$this->addStaticEvent( $event,$pixel,"" );
			}
		}

        if(EventsEdd()->isEnabled()) {
            // AddToCart on button
            if ( isEventEnabled( 'edd_add_to_cart_enabled') && PYS()->getOption( 'edd_add_to_cart_on_button_click' ) ) {
                add_action( 'edd_purchase_link_end', array( $this, 'setupEddSingleDownloadData' ) );
            }
        }

        if(EventsWoo()->isEnabled()){
            // AddToCart on button and Affiliate
            if ( PYS()->getOption('woo_add_to_cart_catch_method') == "add_cart_js"
                    && isEventEnabled( 'woo_add_to_cart_enabled')
                    && PYS()->getOption( 'woo_add_to_cart_on_button_click' )
            ) {
                add_action( 'woocommerce_after_shop_loop_item', array( $this, 'setupWooLoopProductData' ) );
                add_action( 'woocommerce_after_add_to_cart_button', 'PixelYourSite\EventsManager::setupWooSingleProductData' );
                add_filter( 'woocommerce_blocks_product_grid_item_html', array( $this, 'setupWooBlocksProductData' ), 10, 3 );
                add_filter('jet-woo-builder/elementor-views/frontend/archive-item-content', array( $this, 'setupWooBlocksProductData' ),10, 3);
            }
        }

        if(!PYS()->is_user_agent_bot()){
            if( count($this->facebookServerEvents ) > 0
                && Facebook()->enabled()
                && Facebook()->isServerApiEnabled()
                && !PYS()->isCachePreload()
                && Consent()->checkConsent( 'facebook' )
            ) {
                FacebookServer()->sendEventsAsync( $this->facebookServerEvents );
                $this->facebookServerEvents = array();
            }

            if ( isPinterestActive()
                && count($this->pinterestServerEvents) > 0
                &&  Pinterest()->enabled()
                && Pinterest()->isServerApiEnabled()
                && !PYS()->isCachePreload()
                && Consent()->checkConsent( 'pinterest' )
            ) {
                PinterestServer()->sendEventsAsync( $this->pinterestServerEvents );
                $this->pinterestServerEvents = array();
            }
        }


        // remove new user mark
        if($user_id = get_current_user_id()) {
            if ( get_user_meta( $user_id, 'pys_complete_registration', true ) ) {
                delete_user_meta( $user_id, 'pys_complete_registration' );
            }
        }
	}

	public function getStaticEvents( $context ) {
	    return isset( $this->staticEvents[ $context ] ) ? $this->staticEvents[ $context ] : array();
    }


    function addEvents($pixelEvents,$slug) {

        foreach ($pixelEvents as $pixelSlug => $events) {
            $pixel = PYS()->getRegisteredPixels()[$pixelSlug];
            foreach ($events as $event) {
                // add standard params
                if(!isset($this->uniqueId[$event->getId()])) {
                    $this->uniqueId[$event->getId()] = EventIdGenerator::guidv4();
                }
                $event->addPayload(['eventID'=>$this->uniqueId[$event->getId()]]);

	            if( $pixelSlug !== "reddit" ) {
		            $event->addParams( $this->standardParams );
	            }
                //save different types of events
                if($event->getType() == EventTypes::$STATIC) {
                    $this->addStaticEvent( $event,$pixel,$slug );
                } elseif($event->getType() == EventTypes::$TRIGGER) {
                    $this->addTriggerEvent($event,$pixel,$slug);
                } else {
                    $this->addDynamicEvent($event,$pixel,$slug);
                }
            }

        }
    }



    function addDynamicEvent($event,$pixel,$slug) {

        $eventData = $event->getData();
        $eventData = $this::filterEventParams($eventData,$slug,['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);

        if($event->getId() == 'edd_remove_from_cart' || $event->getId() == 'woo_remove_from_cart')  {
            $this->dynamicEvents[ $event->getId() ][ $event->args['key'] ][ $pixel->getSlug() ] = $eventData;
        } else  {
            $this->dynamicEvents[ $event->getId() ][ $pixel->getSlug() ] = $eventData;
        }
    }

    function addTriggerEvent($event,$pixel,$slug) {

        $eventData = $event->getData();
        $eventData = $this->filterEventParams($eventData,$slug,['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);
        //save static event data
        if($event->getId() == "custom_event") {
            $eventId = $event->args->getPostId();
        } else {
            $eventId = $event->getId();
        }
        $this->triggerEvents[ $eventId ][ $pixel->getSlug() ] = $eventData;
        if ( !empty( $event->args ) &&  $event->getCategory() === 'custom') {
            $this->triggerEventTypes = array_replace_recursive( $this->triggerEventTypes, $event->args->__get( 'triggerEventTypes' ) );
        }

        if($event->getCategory() === 'fdp'){
            $this->triggerEventTypes[ $eventData['trigger_type'] ][ $eventId ][] = $eventData['trigger_value'];
        }

    }

    /**
     * Create stack event, they fire when page loaded
     * @param Event $event
     */
    function addStaticEvent($event,$pixel,$slug) {
        $event_getId = $event->getId() == 'custom_event' ? $event->getPayloadValue('custom_event_post_id') : $event->getId();

        if(!isset($this->uniqueId[$event_getId])) {
            $this->uniqueId[$event_getId] = EventIdGenerator::guidv4();
        }

        $event->addPayload(['eventID'=>$this->uniqueId[$event_getId]]);

        $eventData = $event->getData();
        $eventData = $this::filterEventParams($eventData,$slug,['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);
        // send only for FB Server events
        if(Facebook()->enabled() && $pixel->getSlug() == "facebook" &&
            ($event->getId() == "woo_complete_registration") &&
            Facebook()->isServerApiEnabled() &&
            Facebook()->getOption("woo_complete_registration_send_from_server") &&
            !$this->isGdprPluginEnabled() )
        {
            if($eventData['delay'] == 0 && !PYS()->getOption( "server_static_event_use_ajax" )) {
                $this->facebookServerEvents[] = $event;
            }
            return;
        }

        //save static event data
        $this->staticEvents[ $pixel->getSlug() ][ $event->getId() ][] = $eventData;
        // fire fb server api event
        if( $eventData['delay'] == 0 && (!PYS()->getOption( "server_static_event_use_ajax" ) || !PYS()->getOption('server_event_use_ajax'))) {
            if($pixel->getSlug() === "facebook" && Facebook()->enabled()) {
                $this->facebookServerEvents[] = $event;
            }
            if(isPinterestActive() && $pixel->getSlug() === "pinterest" && Pinterest()->enabled()) {
                $this->pinterestServerEvents[] = $event;
            }
        }

    }

    static function filterEventParams($data,$slug,$context = null)
    {

        if(!PYS()->getOption('enable_content_name_param')) {
            unset($data['params']['content_name']);
        }

        if(!PYS()->getOption('enable_page_title_param')) {
            unset($data['params']['page_title']);
        }
        if(!PYS()->getOption('enable_post_category_param')) {
            unset($data['params']['post_category']);
        }

        if($slug == EventsWoo::getSlug()) {
            if(!PYS()->getOption("enable_woo_category_name_param")) {
                unset($data['params']['category_name']);
            }
            if(!PYS()->getOption("enable_woo_num_items_param")) {
                unset($data['params']['num_items']);
            }

            if(!PYS()->getOption("enable_woo_tags_param")) {
                unset($data['params']['tags']);
            }

            if(!PYS()->getOption("enable_woo_fees_param")) {
                unset($data['params']['fees']);
            }
        }

        if($slug == EventsEdd::getSlug()) {
            if(!PYS()->getOption("enable_edd_category_name_param")) {
                unset($data['params']['category_name']);
            }
            if(!PYS()->getOption("enable_edd_num_items_param")) {
                unset($data['params']['num_items']);
            }

            if(!PYS()->getOption("enable_edd_tags_param")) {
                unset($data['params']['tags']);
            }
        }

        if(isset($context) && isset($context['pixel']) && $context['pixel'] === 'facebook' && Facebook()->getOption('enabled_medical')) {
            foreach (Facebook()->getOption('do_not_track_medical_param') as $param) {
                unset($data['params'][$param]);
            }
        }

        return $data;
    }



    function isGdprPluginEnabled() {
        return apply_filters( 'pys_disable_by_gdpr', false ) ||
            apply_filters( 'pys_disable_facebook_by_gdpr', false ) ||
            (isCookiebotPluginActivated() && PYS()->getOption('gdpr_cookiebot_integration_enabled')) ||
            (isConsentMagicPluginActivated() && PYS()->getOption('consent_magic_integration_enabled')) ||
            (isRealCookieBannerPluginActivated() && PYS()->getOption('gdpr_real_cookie_banner_integration_enabled')) ||
            (isCookieNoticePluginActivated() && PYS()->getOption('gdpr_cookie_notice_integration_enabled')) ||
            (isCookieLawInfoPluginActivated() && PYS()->getOption('gdpr_cookie_law_info_integration_enabled'));
    }


    public function setupWooLoopProductData()
    {
        global $product;

        $this->setupWooProductData($product);
    }

    public function setupWooBlocksProductData($html, $data, $product)
    {

        $this->setupWooProductData($product);
        return $html;
    }

    public function setupWooProductData($product) {

		if (  !is_a($product,"WC_Product")
            || wooProductIsType( $product, 'variable' )
            || wooProductIsType( $product, 'grouped' )
        ) {
			return; // skip variable products
		}

        $product_id = $product->get_id();

		$params = array();
        $event = new SingleEvent('woo_add_to_cart_on_button_click',EventTypes::$STATIC,'woo');
        $event->args = ['productId' => $product_id,'quantity' => 1];

		foreach ( PYS()->getRegisteredPixels() as $pixel ) {
			/** @var Pixel|Settings $pixel */

            $events = $pixel->generateEvents( $event );
            foreach ($events as $event) {
                // prepare event data
                $eventData = $event->getData();
                $eventData = EventsManager::filterEventParams($eventData,"woo",['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);

                $params[$pixel->getSlug()] = $eventData; // replace data!!(now use only one event)
            }
        }

		if ( empty( $params ) ) {
			return;
		}

		$params = json_encode( $params );

		?>

		<script type="application/javascript" style="display:none">
            /* <![CDATA[ */
            window.pysWooProductData = window.pysWooProductData || [];
            window.pysWooProductData[ <?php echo $product_id; ?> ] = <?php echo $params; ?>;
            /* ]]> */
		</script>

		<?php

	}

	public static function setupWooSingleProductData() {
        global $product;

        if ( ! is_object( $product)) $product = wc_get_product( get_the_ID() );

        if(!$product || !is_a($product,"WC_Product") ) return;

        if ( wooProductIsType( $product, 'external' ) ) {
            $eventType = 'woo_affiliate';
        } else {
            $eventType = 'woo_add_to_cart_on_button_click';
        }
        $product_id = $product->get_id();

        // main product id
        $product_ids[] = $product_id;

        // variations ids
        if ( wooProductIsType( $product, 'variable' ) ) {
            $product_ids = array_merge($product_ids, $product->get_children());
        }

        $params = array();

        foreach ( $product_ids as $product_id ) {

            foreach ( PYS()->getRegisteredPixels() as $pixel ) {
                /** @var Pixel|Settings $pixel */
                $initEvent = new SingleEvent($eventType,EventTypes::$STATIC,"woo");
                $initEvent->args = ['productId' => $product_id,'quantity' => 1];
                $events = [];
                if(method_exists($pixel,'generateEvents')) {
                    add_filter('pys_conditional_post_id', function($id) use ($product_id) { return $product_id; });
                    $events =  $pixel->generateEvents( $initEvent );
                    remove_all_filters('pys_conditional_post_id',10);
                } else {
                    if( $pixel->addParamsToEvent( $initEvent )) {
                        $events[] = $initEvent;
                    }
                }

                if(count($events) == 0) continue;
                foreach ($events as $event) {
                    // prepare event data
                    $eventData = $event->getData();
                    $eventData = EventsManager::filterEventParams($eventData,"woo",['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);

                    $params[ $product_id ][ $pixel->getSlug() ] = $eventData; // replace (use only one event for product)
                }

            }

        }

        if ( empty( $params ) ) {
            return;
        }

        ?>

        <script type="application/javascript" style="display:none">
            /* <![CDATA[ */
            window.pysWooProductData = window.pysWooProductData || [];
            <?php foreach ( $params as $product_id => $product_data ) : ?>
            window.pysWooProductData[<?php echo $product_id; ?>] = <?php echo json_encode( $product_data ); ?>;
            <?php endforeach; ?>
            /* ]]> */
        </script>

        <?php

	}

    public function setupEddSingleDownloadData($purchase_link) {
        $download = $purchase_link;
        $download_ids = array();

        if ( edd_has_variable_prices( $download ) ) {

            $prices = edd_get_variable_prices( $download );

            foreach ( $prices as $price_index => $price_data ) {
                $download_ids[] = $download . '_' . $price_index;
            }

        } else {

            $download_ids[] = $download;

        }

        $params = array();
        foreach ( $download_ids as $download_id ) {
            $event = EventsEdd()->getEvent('edd_add_to_cart_on_button_click');
            $event->args = $download_id;
            foreach ( PYS()->getRegisteredPixels() as $pixel ) {
                /** @var Pixel|Settings $pixel */
                $events = $pixel->generateEvents( $event );
                foreach ($events as $singleEvent) {
                    $eventData = $singleEvent->getData();
                    $eventData = EventsManager::filterEventParams($eventData,"edd",['event_id'=>$event->getId(),'pixel'=>$pixel->getSlug()]);
                    /**
                     * Format is pysEddProductData[ id ][ id ] or pysEddProductData[ id ] [ id_1, id_2, ... ]
                     */
                    $params[ $download_id ][ $pixel->getSlug() ] = [ // replace data there use only one event
                            'params' => $eventData['params']
                    ];
                }
            }
        }

        ?>

        <script type="application/javascript" style="display:none">
            /* <![CDATA[ */
            window.pysEddProductData = window.pysEddProductData || [];
            window.pysEddProductData[<?php echo $download; ?>] = <?php echo json_encode( $params ); ?>;
            /* ]]> */
        </script>

        <?php

    }
    static function isTrackExternalId(){
        return PYS()->getOption("send_external_id") && !apply_filters( 'pys_disable_externalID_by_gdpr', false ) && !apply_filters( 'pys_disable_all_cookie', false );
    }
}