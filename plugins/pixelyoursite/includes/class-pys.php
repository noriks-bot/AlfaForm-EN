<?php

namespace PixelYourSite;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * PixelYourSite Core class.
 */
final class PYS extends Settings implements Plugin {
	
	private static $_instance;

	/** @var $eventsManager EventsManager */
	private $eventsManager;

    /** @var $registeredPixels array Registered pixels */
    private $registeredPixels = array();

    /** @var $registeredPlugins array Registered plugins (addons) */
    private $registeredPlugins = array();

    private $adminPagesSlugs = array();
    private $externalId;
    /**
     * @var PYS_Logger
     */
    private $logger;
    private $containers;
    private $crawlerDetect;

    public $general_domain = '';

    private $pixels_loaded = false;

    public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
		
	}
	
	public function getPluginName() {}

    public function getPluginFile() {}

    public function getPluginVersion() {
        return PYS_FREE_VERSION;
    }
    public function getPluginIcon() {
        return PYS_FREE_PLUGIN_ICON;
    }
    public function adminUpdateLicense() {}
    public function __construct() {
		
	    // initialize settings
	    parent::__construct( 'core' );
    
        add_action( 'admin_init', array( $this, 'updatePlugin' ), 0 );
	    add_action( 'admin_init', 'PixelYourSite\manageAdminPermissions' );

	    // Priority 9 used to keep things same as on PRO version
        add_action( 'wp', array( $this, 'controllSessionStart'), 10);
        add_action( 'init', array( $this, 'set_pbid'), 8);
        add_action( 'init', array( $this, 'init' ), 9 );
        add_action( 'init', array( $this, 'afterInit' ), 11 );

        add_action( 'admin_menu', array( $this, 'adminMenu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
        add_action( 'admin_notices', 'PixelYourSite\adminRenderNotices' );
        add_action( 'admin_init', array( $this, 'adminProcessRequest' ), 11 );
        add_action( 'admin_init', function () {

            // Activate only on PixelYourSite pages
            if (
                isset($_GET['page']) &&
                strpos($_GET['page'], 'pixelyoursite') !== false
            ) {
                ob_start(function ($html) {

                    // Remove all integrity and crossorigin attributes
                    $html = preg_replace('/\s+integrity="[^"]*"/i', '', $html);
                    $html = preg_replace('/\s+crossorigin="[^"]*"/i', '', $html);

                    return $html;
                });
            }
        });

        // run Events Manager
        add_action( 'template_redirect', array( $this, 'managePixels' ), 1);
        // track user login event
        add_action('wp_login', [$this,'userLogin'], 10, 2);
        // track user registrations
        add_action( 'user_register', array( $this, 'userRegisterHandler' ) );
	    // "admin_permission" option custom sanitization function
	    add_filter( 'pys_core_settings_sanitize_admin_permissions_field', function( $value ) {

	    	// "administrator" always should be allowed
	    	if ( ! is_array( $value ) || ! in_array( 'administrator', $value ) ) {
	    		$value[] = 'administrator';
		    }

		    manageAdminPermissions();

	    	return $this->sanitize_multi_select_field( $value );

	    } );

	    add_action( 'wp_ajax_pys_get_gdpr_filters_values', array( $this, 'ajaxGetGdprFiltersValues' ) );
	    add_action( 'wp_ajax_nopriv_pys_get_gdpr_filters_values', array( $this, 'ajaxGetGdprFiltersValues' ) );


        add_action( 'wp_ajax_pys_get_pbid', array( $this, 'get_pbid_ajax' ) );
        add_action( 'wp_ajax_nopriv_pys_get_pbid', array( $this, 'get_pbid_ajax' ) );
        /*
         * Restore settings after COG plugin
         * */
        add_action( 'deactivate_pixel-cost-of-goods/pixel-cost-of-goods.php',array($this,"restoreSettingsAfterCog"));

		/**
		 * For Woo
		 */
		add_action( 'woocommerce_checkout_order_processed', array( $this, 'woo_checkout_process' ), 10, 3 );
	    add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'saveExternalIDInOrder' ), 10, 1 );
	    // Hook for Store API (passes WC_Order object instead of order_id)
	    add_action( 'woocommerce_store_api_checkout_update_order_meta', array( $this, 'saveExternalIDInOrder' ), 10, 1 );

	    /**
		 * For EDD
		 */
        // Hook for EDD payment insertion to save external_id
        add_action( 'edd_insert_payment', array( $this, 'saveExternalIDInEddOrder' ), 10, 2 );

        if(!$this->isCachePreload()){
			add_action( 'edd_recurring_record_payment', array( $this, 'edd_recurring_payment' ), 10, 1 );
		}

        $this->logger = new PYS_Logger();
        $this->containers = new gtmContainers();
        $this->crawlerDetect = new CrawlerDetect();
        $this->general_domain = $this->get_wp_cookie_domain();
    }

    public function init() {
	    $this->logger->init();
        if (current_user_can( 'manage_pys' ) ) {

            $loggers = [
                'meta' => [$this->logger, 'downloadLogFile'],
            ];

            $clearLoggers = [
                'clear_plugin_logs' => [$this->logger, 'remove'],
            ];

            if (isPinterestActive() && class_exists('PixelYourSite\Pinterest')){
                $loggers['pinterest'] = [Pinterest()->getLog(), 'downloadLogFile'];
                $clearLoggers['clear_pinterest_logs'] = [Pinterest()->getLog(), 'remove'];
            }

            if (isset($_GET['download_logs']) && array_key_exists($_GET['download_logs'], $loggers)) {
                if (!isset($_GET['_wpnonce_download_logs']) || !wp_verify_nonce($_GET['_wpnonce_download_logs'], 'download_logs_nonce')) {
                    wp_die(__('Invalid nonce', 'pixelyoursite'));
                }
                $logger = $loggers[$_GET['download_logs']];
                if (is_callable($logger)) {
                    call_user_func($logger);
                } elseif (is_callable([$logger[0], $logger[1]])) {
                    call_user_func([$logger[0], $logger[1]]);
                }
            }

            foreach ($clearLoggers as $key => $logger) {
                if (isset($_GET[$key]) && (is_callable($logger) || (is_callable([$logger[0], $logger[1]]) && method_exists($logger[0], $logger[1])))) {
                    if (!isset($_GET['_wpnonce_clear_logs']) || !wp_verify_nonce($_GET['_wpnonce_clear_logs'], 'clear_logs_nonce')) {
                        wp_die(__('Invalid nonce', 'pixelyoursite'));
                    }
                    if (is_callable($logger)) {
                        call_user_func($logger);
                    } else {
                        call_user_func([$logger[0], $logger[1]]);
                    }
                    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    wp_redirect(remove_query_arg($key, $actual_link));
                    exit;
                }
            }

            if ( isset( $_GET[ 'download_container' ] )) {
                if (!isset($_GET['_wpnonce_template_logs']) || !wp_verify_nonce($_GET['_wpnonce_template_logs'], 'download_template_nonce')) {
                    wp_die(__('Invalid nonce', 'pixelyoursite'));
                }
                $this->containers->downloadContainerFile($_GET[ 'download_container' ]);
            }
        }


        register_post_type( 'pys_event', array(
            'public' => false,
            'supports' => array( 'title' )
        ) );

	    // initialize options
	    $this->locateOptions(
		    PYS_FREE_PATH . '/includes/options_fields.json',
		    PYS_FREE_PATH . '/includes/options_defaults.json'
	    );

	    // register pixels and plugins (add-ons)
	    do_action( 'pys_register_pixels', $this );
	    do_action( 'pys_register_plugins', $this );

        // load dummy Pinterest plugin for admin UI
	    if ( ! array_key_exists( 'pinterest', $this->registeredPlugins ) ) {
		    /** @noinspection PhpIncludeInspection */
		    require_once PYS_FREE_PATH . '/modules/pinterest/pinterest.php';
	    }

        // load dummy Bing plugin for admin UI
        if ( ! array_key_exists( 'bing', $this->registeredPlugins ) ) {
            /** @noinspection PhpIncludeInspection */
            require_once PYS_FREE_PATH . '/modules/bing/bing.php';
        }

	    // load dummy Reddit plugin for admin UI
	    if ( ! array_key_exists( 'reddit', $this->registeredPlugins ) ) {
		    /** @noinspection PhpIncludeInspection */
		    require_once PYS_FREE_PATH . '/modules/reddit/reddit.php';
	    }

        // maybe disable Facebook for WooCommerce pixel output
	    if ( isWooCommerceActive()
	         && array_key_exists( 'facebook', $this->registeredPixels ) && Facebook()->configured() ) {
		    add_filter( 'facebook_for_woocommerce_integration_pixel_enabled', '__return_false' );
	    }


        if(Facebook()->getOption('test_api_event_code_expiration_at'))
        {
            foreach (Facebook()->getOption('test_api_event_code_expiration_at') as $key => $test_code_expiration_at)
            {
                if(time() >= $test_code_expiration_at)
                {
                    Facebook()->updateOptions(array("test_api_event_code" => array()));
                    Facebook()->updateOptions(array("test_api_event_code_expiration_at" => array()));
                }
            }
        }
        $eventsFormFactory = apply_filters("pys_form_event_factory",[]);
        if(!$eventsFormFactory)
        {
            // Check current option value before updating to avoid unnecessary database updates
            $current_value = $this->getOption('enable_success_send_form');
            if($current_value !== false)
            {
                $options = array(
                    'enable_success_send_form'     => false
                );
                PYS()->updateOptions($options);
            }
        }

        if (isRealCookieBannerPluginActivated()) {

            add_action('RCB/Templates/TechnicalHandlingIntegration', function ( $integration ) {

                $this->handle_rcb_integration($integration, Facebook()->configured(), 'facebook-pixel', PYS_FREE_PLUGIN_FILE);
                $this->handle_rcb_integration($integration, GA()->configured(), 'google-analytics-analytics-4', PYS_FREE_PLUGIN_FILE);
                if(isPinterestActive()){
                    $this->handle_rcb_integration($integration, Pinterest()->configured(), 'pinterest-tag', PYS_PINTEREST_PLUGIN_FILE);
                }
                if(isBingActive()){
                    $this->handle_rcb_integration($integration, Bing()->configured(), 'bing-ads', PYS_BING_PLUGIN_FILE);
                }



            });
        }

        EnrichOrder()->init();

        AjaxHookEventManager::instance()->addHooks();
    }

    private function handle_rcb_integration( $integration, $is_active, $type, $plugin_dir) {

        if (
            $is_active
            && $integration->integrate($plugin_dir, $type)
        ) {
            $integration->setCodeOptIn('');
            $integration->setCodeOptOut('');
        }
    }

    function controllSessionStart(){
        if(PYS()->getOption('session_disable')) return;

        // Checking if the directory exists and is writable
        if (!is_admin() && PHP_SAPI !== 'cli' && session_status() != PHP_SESSION_DISABLED) {
            if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
                if (!session_start()) return;
            }

            if (session_status() !== PHP_SESSION_ACTIVE) return;

            if (empty($_SESSION['TrafficSource'])) {
                $_SESSION['TrafficSource'] = getTrafficSource();
            }
            if (empty($_SESSION['LandingPage'])) {
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
                $currentUrl = $protocol . ($_SERVER['HTTP_HOST'] ?? parse_url(get_site_url(), PHP_URL_HOST)) . ($_SERVER['REQUEST_URI'] ?? '');
                $landing = explode('?', $currentUrl)[0];
                $_SESSION['LandingPage'] = $landing;
            }
            if (empty($_SESSION['TrafficUtms'])) {
                $_SESSION['TrafficUtms'] = getUtms();
            }
            if (empty($_SESSION['TrafficUtmsId'])) {
                $_SESSION['TrafficUtmsId'] = getUtmsId();
            }
        }
    }

    function get_pbid(){
        return $this->externalId;
    }
    function set_pbid() {
        $pbidCookieName = 'pbid';
        $isTrackExternalId = EventsManager::isTrackExternalId();
        $user = wp_get_current_user();

        if ($user && $isTrackExternalId) {
            $userExternalId = $user->get('external_id');
            if (!empty($userExternalId)) {
                $this->externalId = $userExternalId;
                return;
            }
        }

        if ($isTrackExternalId) {

            if (!empty($_COOKIE[$pbidCookieName])) {
                $this->externalId = $_COOKIE[$pbidCookieName];
            } elseif ( PYS()->getOption('external_id_use_transient') && get_transient('externalId-' . PYS()->get_user_ip())) {
                $this->externalId = get_transient('externalId-' . PYS()->get_user_ip());
            }
            else {
                $uniqueId = bin2hex(random_bytes(16));
                $encryptedUniqueId = hash('sha256', $uniqueId);
                $this->externalId = $encryptedUniqueId;
                if(PYS()->getOption('external_id_use_transient')){
                    set_transient('externalId-' . PYS()->get_user_ip(), $this->externalId, 60 * 10);
                }
            }
        }
    }

    public function get_pbid_ajax(){
        if(defined('DOING_AJAX') && DOING_AJAX){
            $isTrackExternalId = EventsManager::isTrackExternalId();
            if ($isTrackExternalId && !empty($this->externalId)) {
                $transient = get_transient('externalId-'.PYS()->get_user_ip());
                wp_send_json_success( array('pbid'=> $this->externalId, 'transient' => !empty($transient) ? $transient : false ));
            }
        }
    }
    public function adminSinglePage()
    {
        $this->adminResetSettings();
        include 'views/html-wrapper-single-page.php';
    }
	/**
	 * Extend options after post types are registered
	 */
    public function afterInit() {

	    // add available public custom post types to settings
	    foreach ( get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' ) as $post_type ) {

		    // skip product post type when WC is active
		    if ( isWooCommerceActive() && $post_type->name == 'product' ) {
			    continue;
		    }

		    // skip download post type when EDD is active
		    if ( isEddActive() && $post_type->name == 'download' ) {
			    continue;
		    }

		    $this->addOption( 'general_event_on_' . $post_type->name . '_enabled', 'checkbox', false );

	    }

    }

	/**
	 * @param Pixel|Settings $pixel
	 */
    public function registerPixel( &$pixel ) {
        if(!is_admin() && !PYS()->getOption('enable_all_tracking_ids') && $pixel->getSlug() != 'gtm'){
            return;
        }
        switch ($pixel->getSlug()) {
            case 'pinterest':
                if(!isPinterestVersionIncompatible()){
                    $this->registeredPixels[ $pixel->getSlug() ] = $pixel;
                }
                else{
                    $minVersion = PYS_FREE_PINTEREST_MIN_VERSION;
                    add_action( 'wp_head', function() use ($minVersion) {
                        echo "<script type='application/javascript' id='pys-pinterest-version-incompatible'>console.warn('You are using incompatible version of PixelYourSite Pinterest Add-On. PixelYourSite PRO requires at least PixelYourSite Pinterest Add-On $minVersion. Please, update to latest version.');</script>\r\n";
                    } );
                }
                break;
            case 'bing' :
                if(!isBingVersionIncompatible()){
                    $this->registeredPixels[ $pixel->getSlug() ] = $pixel;
                }
                else{
                    $minVersion = PYS_FREE_BING_MIN_VERSION;
                    add_action( 'wp_head', function() use ($minVersion) {
                        echo "<script type='application/javascript' id='pys-bing-version-incompatible'>console.warn('You are using incompatible version of PixelYourSite Bing Add-On. PixelYourSite PRO requires at least PixelYourSite Bing Add-On $minVersion. Please, update to latest version.');</script>\r\n";
                    } );
                }
                break;
            default :
                $this->registeredPixels[ $pixel->getSlug() ] = $pixel;
                break;
        }
    }

    /**
     * Hook
     * @param String $user_login
     * @param \WP_User $user
     * @throws \JsonException
     */
    function userLogin($user_login, $user) {
        // Delete all existing rows first (clears accumulated duplicates for any role,
        // including excluded roles whose cleanup never fires via the event pipeline).
        // Then insert a single unique row to prevent race-condition duplicates.
        delete_user_meta( $user->ID, 'pys_just_login' );
        add_user_meta( $user->ID, 'pys_just_login', true, true );

		if ( !apply_filters( 'pys_disable_advanced_form_data_cookie', false ) && !apply_filters( 'pys_disable_advance_data_cookie', false ) ) {
			$user_persistence_data = get_persistence_user_data( $user->user_email, $user->first_name, $user->last_name, '' );
			$userData = array(
				'first_name' => $user_persistence_data[ 'fn' ],
				'last_name'  => $user_persistence_data[ 'ln' ],
				'email'      => $user_persistence_data[ 'em' ],
				'phone'      => $user_persistence_data[ 'tel' ]
			);
			setcookie( "pys_advanced_form_data", json_encode($userData, JSON_THROW_ON_ERROR), 2147483647, '/', PYS()->general_domain );
		}
    }

    public function userRegisterHandler( $user_id ) {

        if ( PYS()->getOption( 'woo_complete_registration_enabled' )
            || PYS()->getOption( 'automatic_event_signup_enabled' )
        ) {
            update_user_meta( $user_id, 'pys_complete_registration', true );
        }

    }

	/**
	 * Return array of registered pixels
	 *
	 * @return array
	 */
	public function getRegisteredPixels() {
		return $this->registeredPixels;
	}

	/**
	 * @param Pixel|Settings $plugin
	 */
	public function registerPlugin( &$plugin ) {
		$this->registeredPlugins[ $plugin->getSlug() ] = $plugin;
	}

	/**
	 * Return array of registered plugins
	 *
	 * @return array
	 */
    public function getRegisteredPlugins() {
	    return $this->registeredPlugins;
    }

	/**
	 * Front-end entry point
	 */
    public function managePixels() {

        if ( $this->pixels_loaded ) {
            return;
        }
        $this->pixels_loaded = true;

        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        // disable Events Manager on Customizer and preview mode
        if (is_admin() || is_customize_preview() || is_preview()) {
            return;
        }

        // Note: We intentionally DON'T disable Events Manager for bots
        // Reasons:
        // 1. Bots don't execute JavaScript, so no actual tracking happens for them
        // 2. If we disable Events Manager for bots, cached pages won't have tracking scripts
        // 3. Real users would then get cached pages WITHOUT tracking (critical issue!)
        // 4. It's better to include tracking scripts in HTML (even for bots) to ensure
        //    cached pages always have tracking for real users
        // 5. The minimal overhead of including scripts in HTML for bots is acceptable
        //    compared to the risk of breaking tracking for real users


        // disable Events Manager on Elementor editor
        if (did_action('elementor/preview/init')
            || did_action('elementor/editor/init')
            || (isset( $_GET['action'] ) && $_GET['action'] == 'piotnetforms') // skip preview for piotnet forms plugin
        ) {
            return;
        }

        // disable Events Manager on Divi Builder
        if (function_exists('et_core_is_fb_enabled') && et_core_is_fb_enabled()) {
            return;
        }

        if(PYS()->getOption( 'block_ip_enabled') && in_array($this->get_user_ip(), PYS()->getOption('blocked_ips')))
        {
            return;
        }

        $theme = wp_get_theme(); // gets the current theme
        if ( ('Bricks' == $theme->name || 'Bricks' == $theme->parent_theme) && isset($_GET['bricks']) && $_GET['bricks']=='run') {
            return;
        }

    	// output debug info
        if(!PYS()->getOption( 'hide_version_plugin_in_console')) {
            add_action('wp_head', function () {
                echo "<script type='application/javascript'  id='pys-version-script'>console.log('PixelYourSite Free version " . PYS_FREE_VERSION . "');</script>\r\n";
            }, 1);
        }
	    if ( isDisabledForCurrentRole() ) {
	    	return;
	    }
        // setup events
        $this->eventsManager = new EventsManager();
	    // at least one pixel should be configured
	    if ( ! Facebook()->configured() && ! GA()->configured() && ! Pinterest()->configured() && ! Bing()->configured() ) {
            if(!PYS()->getOption( 'hide_version_plugin_in_console')) {
                add_action('wp_head', function () {
                    echo "<script type='application/javascript' id='pys-config-warning-script'>console.warn('PixelYourSite: no pixel configured.');</script>\r\n";
                });
            }
	    	return;
	    }
    }

    function get_user_ip() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $forwarded_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($forwarded_ips[0]);
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ?: '0.0.0.0';
    }

    function is_user_agent_bot(){
        if (!PYS()->getOption('block_robot_enabled')) {
            return false;
        }
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {

            $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
            $excludedRobots = PYS()->getOption('exclude_blocked_robots');
            $excludedRobots = array_filter($excludedRobots, function($robot) {
                return trim($robot) !== '';
            });
            if (!empty($excludedRobots)) {
                foreach ($excludedRobots as $robot) {
                    if (stripos($userAgent, strtolower($robot)) !== false) {
                        return false;
                    }
                }
            }

            $options = array(
                'YandexBot', 'YandexAccessibilityBot', 'YandexMobileBot', 'YandexDirectDyn', 'YandexScreenshotBot',
                'YandexImages', 'YandexVideo', 'YandexVideoParser', 'YandexMedia', 'YandexBlogs',
                'YandexFavicons', 'YandexWebmaster', 'YandexPagechecker', 'YandexImageResizer', 'YandexAdNet',
                'YandexDirect', 'YaDirectFetcher', 'YandexCalendar', 'YandexSitelinks', 'YandexMetrika',
                'YandexNews', 'YandexNewslinks', 'YandexCatalog', 'YandexAntivirus', 'YandexMarket',
                'YandexVertis', 'YandexForDomain', 'YandexSpravBot', 'YandexSearchShop', 'YandexMedianaBot',
                'YandexOntoDB', 'YandexOntoDBAPI', 'Googlebot', 'Googlebot-Image', 'Googlebot-News',
                'Googlebot-Video', 'Mediapartners-Google', 'AdsBot-Google', 'Chrome-Lighthouse', 'Lighthouse',
                'Mail.RU_Bot', 'bingbot', 'Accoona', 'ia_archiver', 'Ask Jeeves', 'OmniExplorer_Bot',
                'W3C_Validator', 'WebAlta', 'YahooFeedSeeker', 'Yahoo!', 'Ezooms', 'Tourlentabot', 'MJ12bot',
                'AhrefsBot', 'SearchBot', 'SiteStatus', 'Nigma.ru', 'Baiduspider', 'Statsbot', 'SISTRIX',
                'AcoonBot', 'findlinks', 'proximic', 'OpenindexSpider', 'statdom.ru', 'Exabot', 'Spider',
                'SeznamBot', 'oBot', 'C-T bot', 'Updownerbot', 'Snoopy', 'heritrix', 'Yeti', 'DomainVader',
                'DCPbot', 'PaperLiBot', 'APIs-Google', 'AdsBot-Google-Mobile', 'AdsBot-Google-Mobile-Apps',
                'FeedFetcher-Google', 'Google-Read-Aloud', 'DuplexWeb-Google', 'Storebot-Google',
                'ClaudeBot', 'SeekportBot', 'GPTBot', 'Applebot',
                'DuckDuckBot', 'Sogou', 'facebookexternalhit', 'Swiftbot', 'Slurp', 'CCBot', 'Go-http-client',
                'Sogou Spider', 'Facebot', 'Alexa Crawler', 'Cốc Cốc Bot', 'Majestic-12', 'SemrushBot',
                'DotBot', 'Qwantify', 'Pinterest', 'GrapeshotCrawler', 'archive.org_bot', 'LinkpadBot',
                'uptimebot', 'Wget', 'curl', 'Google-Structured-Data-Testing-Tool', 'Google-PageSpeed Insights',
                'Google-Site-Verification', 'BingPreview', 'Slackbot', 'TelegramBot', 'DiscordBot', 'WhatsApp',
                'RedditBot', 'Yahoo! Slurp', 'Tumblr', 'PetalBot', 'FlipboardProxy', 'LinkedInBot',
                'SkypeUriPreview', 'Google-Firebase-Storage', 'BitlyBot', 'FeedlyBot', 'AppleNewsBot',
                'ZyBorg', 'ia_archiver-web.archive.org', 'Mediatoolkitbot', 'DeuSu', 'SMTBot', 'MegaIndex.ru',
                'Seomoz', 'BLEXBot', 'YisouSpider', '360Spider', 'AddThis', 'TweetmemeBot', 'ContextAd Bot',
                'Screaming Frog SEO Spider', 'Nutch', 'Baiduspider-image', 'Panscient.com', 'Twitterbot',
                'YoudaoBot', 'OpenSiteExplorer', 'Linkfluence', 'YaK', 'ContentKing', 'Spinn3r', 'PhantomJS',
                'HeadlessChrome', 'Snapchat', 'Pingdom', 'Googlebot-Mobile', 'Barkrowler'
            );

            foreach($options as $row) {
                if (stripos($userAgent, strtolower($row)) !== false) {
                    return true;
                }
            }
        }

        return $this->crawlerDetect->isCrawler();
    }

    public function ajaxGetGdprFiltersValues() {

            wp_send_json_success( array(
                'all_disabled_by_api'       => apply_filters( 'pys_disable_by_gdpr', false ),
                'facebook_disabled_by_api'  => apply_filters( 'pys_disable_facebook_by_gdpr', false ),
                'analytics_disabled_by_api' => apply_filters( 'pys_disable_analytics_by_gdpr', false ),
                'pinterest_disabled_by_api' => apply_filters( 'pys_disable_pinterest_by_gdpr', false ),
                'bing_disabled_by_api' => apply_filters( 'pys_disable_bing_by_gdpr', false ),
                'reddit_disabled_by_api' => apply_filters( 'pys_disable_reddit_by_gdpr', false ),
                'externalID_disabled_by_api' => apply_filters( 'pys_disable_externalID_by_gdpr', false ),
                'disabled_all_cookie'       => apply_filters( 'pys_disable_all_cookie', false ),
                'disabled_start_session_cookie' => apply_filters( 'pys_disabled_start_session_cookie', false ),
                'disabled_advanced_form_data_cookie' => apply_filters( 'pys_disable_advanced_form_data_cookie', false ) || apply_filters( 'pys_disable_advance_data_cookie', false ),
                'disabled_landing_page_cookie'  => apply_filters( 'pys_disable_landing_page_cookie', false ),
                'disabled_first_visit_cookie'  => apply_filters( 'pys_disable_first_visit_cookie', false ),
                'disabled_trafficsource_cookie' => apply_filters( 'pys_disable_trafficsource_cookie', false ),
                'disabled_utmTerms_cookie' => apply_filters( 'pys_disable_utmTerms_cookie', false ),
                'disabled_utmId_cookie' => apply_filters( 'pys_disable_utmId_cookie', false ),
            ) );

    }

	public function getEventsManager() {
		return $this->eventsManager;
	}

    public function adminMenu() {
        global $submenu;

        add_menu_page( 'PixelYourSite', 'PixelYourSite', 'manage_pys', 'pixelyoursite',
            array( $this, 'adminPageMain' ), PYS_FREE_URL . '/dist/images/favicon.png' );
        add_submenu_page( 'pixelyoursite', 'Global Settings', 'Global Settings',
            'manage_pys', 'pixelyoursite_settings', array( $this, 'adminSinglePage' ) );
        add_submenu_page('pixelyoursite',__('Queue Settings PRO', 'pixelyoursite'),__('Queue Settings PRO', 'pixelyoursite'),
            'manage_options','pixelyoursite_queue_settings',array($this, 'adminSinglePage'),3);
        $addons = $this->registeredPlugins;

        if ( $addons['head_footer'] ) {
            unset( $addons['head_footer'] );
        }

        // display Licenses menu item only when at lest one addon is active
        if ( count( $addons ) ) {
            add_submenu_page( 'pixelyoursite', 'Licenses', 'Licenses',
                'manage_pys', 'pixelyoursite_licenses', array( $this, 'adminSinglePage' ) );
        }

        if(isWooCommerceActive()) {
            add_submenu_page( 'pixelyoursite', 'WooCommerce Reports', 'WooCommerce Reports',
                'manage_pys', 'pixelyoursite_woo_reports', array( $this, 'wooReport' ) );
        }
        if(isEddActive()) {
            add_submenu_page( 'pixelyoursite', 'EDD Reports', 'EDD Reports',
                'manage_pys', 'pixelyoursite_edd_reports', array( $this, 'eddReport' ) ,9);
        }

        add_submenu_page( 'pixelyoursite', 'UTM Builder', 'UTM Builder',
            'manage_pys', 'pixelyoursite_utm', array( $this, 'adminSinglePage' ) );

        add_submenu_page( 'pixelyoursite', 'System Report', 'System Report',
            'manage_pys', 'pixelyoursite_report', array( $this, 'adminSinglePage' ) );

        // core admin pages
        $this->adminPagesSlugs = array(
            'pixelyoursite',
            'pixelyoursite_settings',
            'pixelyoursite_queue_settings',
            'pixelyoursite_licenses',
            'pixelyoursite_report',
            'pixelyoursite_woo_reports',
            'pixelyoursite_edd_reports',
            'pixelyoursite_utm',
        );

        // rename first submenu item
        if ( isset( $submenu['pixelyoursite'] ) ) {
            $submenu['pixelyoursite'][0][0] = 'Dashboard';
        }

	    $this->adminSaveSettings();

    }

    public function adminEnqueueScripts() {
        if ( ! wp_style_is( 'pys_notice') ) {
            wp_enqueue_style( 'pys_notice', PYS_FREE_URL . '/dist/styles/notice.min.css', array(), PYS_FREE_VERSION );
        }
        if ( in_array( getCurrentAdminPage(), $this->adminPagesSlugs ) ) {


            wp_register_style( 'select2_css', PYS_FREE_URL . '/dist/styles/select2.min.css' );
            wp_enqueue_script( 'select2_js', PYS_FREE_URL . '/dist/scripts/select2.min.js',
                array( 'jquery' ) );
            wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0' );

            wp_enqueue_script( 'popper', PYS_FREE_URL . '/dist/scripts/popper.min.js', 'jquery' );
            wp_enqueue_script( 'tippy', PYS_FREE_URL . '/dist/scripts/tippy.min.js', 'jquery' );
	        wp_enqueue_script( 'bootstrap', PYS_FREE_URL . '/dist/scripts/bootstrap.min.js', 'jquery',
		        'popper' );

            wp_enqueue_style( 'pys_css', PYS_FREE_URL . '/dist/styles/admin.min.css', array( 'select2_css' ), PYS_FREE_VERSION );
            wp_enqueue_script( 'pys_js', PYS_FREE_URL . '/dist/scripts/admin.js', array( 'jquery', 'select2_js', 'popper', 'tippy',
                                                                                 'bootstrap' ), PYS_FREE_VERSION );

            if( (isset($_GET['page']) && $_GET['page'] == "pixelyoursite" && isset($_GET['tab']) && ($_GET['tab'] == 'events')) ||
                ( $_GET['page'] && (( $_GET['page'] == "pixelyoursite_woo_reports" ) || $_GET['page'] == "pixelyoursite_edd_reports" ))
            ) {
                wp_enqueue_style( 'pys_confirm_style', PYS_FREE_URL . '/dist/scripts/confirm/jquery-confirm.min.css', array(  ), PYS_FREE_VERSION );
                wp_enqueue_style( 'pys_confirm_style_theme', PYS_FREE_URL . '/dist/scripts/confirm/bs3.css', array(  ), PYS_FREE_VERSION );
                wp_enqueue_script( 'pys_confirm_script', PYS_FREE_URL . '/dist/scripts/confirm/jquery-confirm.min.js', array( 'pys_js' ), PYS_FREE_VERSION );
                wp_enqueue_script( 'pys_custom_confirm_script', PYS_FREE_URL . '/dist/scripts/confirm/custom-confirm.js', array( 'pys_js' ), PYS_FREE_VERSION );
            }

        }

    }

    public function adminPageMain() {
        $this->adminResetSettings();
        include 'views/html-wrapper-main.php';
    }

	public function adminPageReport() {
		include 'views/html-report.php';
	}

    public function wooReport() {
        include 'views/html-report-woo.php';
    }
    public function eddReport() {
        include 'views/html-report-edd.php';
    }

	public function adminPageLicenses() {

        $this->adminUpdateLicense();

        /** @var Plugin|Settings $plugin */
        foreach ( $this->registeredPlugins as $plugin ) {
            if ( $plugin->getSlug() !== 'head_footer' ) {
                $plugin->adminUpdateLicense();
            }
        }

		include 'views/html-licenses.php';
	}
    public function settingsTemplate() {
        include 'views/html-main-settings.php';
    }


    public function updatePlugin() {
    
        foreach ( $this->registeredPlugins as $slug => $plugin ) {
        
            if ( $slug == 'head_footer' ) {
                continue;
            }
        
            updatePlugin( $plugin );
        
        }
        
    }

	public function adminSecurityCheck() {
  
		// verify user access
		if ( ! current_user_can( 'manage_pys' ) ) {
			return false;
		}

		// nonce filed and PYS data are required request
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! isset( $_REQUEST['pys'] ) ) {
			return false;
		}

		return true;

	}
    
    public function adminProcessRequest() {
        $this->adminUpdateCustomEvents();
        $this->adminEnableGdprAjax();
    }
    
	private function adminUpdateCustomEvents() {

		if ( ! $this->adminSecurityCheck() ) {
			return;
		}

		/**
		 * Single Custom Event Actions
		 */
		if ( isset( $_REQUEST['pys']['event'] ) && isset( $_REQUEST['action'] ) ) {

			$nonce   = isset( $_REQUEST['_wpnonce'] ) ? $_REQUEST['_wpnonce'] : null;
			$action  = $_REQUEST['action'];
			if(isset( $_REQUEST['pys']['event']['post_id'] )) {
                $post_id =  sanitize_key($_REQUEST['pys']['event']['post_id']) ;
            } else {
                $post_id = false;
            }


			if ( $action == 'update' && wp_verify_nonce( $nonce, 'pys_update_event' ) ) {
                $pys_event = $_REQUEST['pys']['event'];
				if ( $post_id ) {
					$event = CustomEventFactory::getById( $post_id );
					$event->update( $pys_event );
				} else {
				    if(isset( $pys_event) && is_array($pys_event)) {
                        $event = CustomEventFactory::create( $pys_event );
                    } else {
                        $event = CustomEventFactory::create( [] );
                    }
				}

                purgeCache();

			} elseif ( $action == 'enable' && $post_id && wp_verify_nonce( $nonce, 'pys_enable_event' ) ) {

				$event = CustomEventFactory::getById( $post_id );
				$event->enable();

			} elseif ( $action == 'disable' && $post_id && wp_verify_nonce( $nonce, 'pys_disable_event' ) ) {

				$event = CustomEventFactory::getById( $post_id );
				$event->disable();

			} elseif ( $action == 'remove' && $post_id && wp_verify_nonce( $nonce, 'pys_remove_event' ) ) {

				CustomEventFactory::remove( $post_id );

			}

			purgeCache();

			// redirect to events tab
			wp_safe_redirect( buildAdminUrl( 'pixelyoursite', 'events' ) );
			exit;

		}

		/**
		 * Bulk Custom Events Actions
		 */
		if ( isset( $_REQUEST['pys']['bulk_event_action'], $_REQUEST['pys']['selected_events'] )
		     && isset( $_REQUEST['pys']['bulk_event_action_nonce'] )
		     && wp_verify_nonce( $_REQUEST['pys']['bulk_event_action_nonce'], 'bulk_event_action' )
		     && is_array( $_REQUEST['pys']['selected_events'] ) ) {

			foreach ( $_REQUEST['pys']['selected_events'] as $event_id ) {

				$event_id = (int) $event_id;

				switch ( $_REQUEST['pys']['bulk_event_action'] ) {
					case 'enable':
						$event = CustomEventFactory::getById( $event_id );
						$event->enable();
						break;

					case 'disable':
						$event = CustomEventFactory::getById( $event_id );
						$event->disable();
						break;

					case 'clone':
						CustomEventFactory::makeClone( $event_id );
						break;

					case 'delete':
						CustomEventFactory::remove( $event_id );
						break;
				}

			}

			purgeCache();

			// redirect to events tab
			wp_safe_redirect( buildAdminUrl( 'pixelyoursite', 'events' ) );
			exit;

		}

	}

    private function adminSaveSettings() {

    	if ( ! $this->adminSecurityCheck() ) {
    		return;
	    }

        if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'pys_save_settings' ) ) {

            if(isset( $_POST['pys']['core'] ) && is_array($_POST['pys']['core'])) {
                $core_options = $_POST['pys']['core'];
            } else {
                $core_options =  array();
            }


    
            $gdpr_ajax_enabled = isset( $core_options['gdpr_ajax_enabled'] )
                ? $core_options['gdpr_ajax_enabled']        // value from form data
                : $this->getOption( 'gdpr_ajax_enabled' );    // previous value
    
            // allow 3rd party plugins to by-pass option value
            $core_options['gdpr_ajax_enabled'] = apply_filters( 'pys_gdpr_ajax_enabled', $gdpr_ajax_enabled );

	        if (isPixelCogActive() ) {

		        if (isset($core_options['woo_purchase_value_option'])) {
                    $core_options = $this->updateDefaultNoCogOption($core_options,'woo_purchase_value_option','woo_purchase_value_cog');
                }
                if (isset($core_options['woo_view_content_value_option'])) {
                    $core_options = $this->updateDefaultNoCogOption($core_options,'woo_view_content_value_option','woo_content_value_cog');
                }
                if (isset($core_options['woo_add_to_cart_value_option'])) {
                    $core_options = $this->updateDefaultNoCogOption($core_options,'woo_add_to_cart_value_option','woo_add_to_cart_value_cog');
                }
                if (isset($core_options['woo_initiate_checkout_value_option'])) {
                    $core_options = $this->updateDefaultNoCogOption($core_options,'woo_initiate_checkout_value_option','woo_initiate_checkout_value_cog');
                }
	        }

            // update core options
            $this->updateOptions( $core_options );

        	$objects = array_merge( $this->registeredPixels, $this->registeredPlugins );

        	// update plugins and pixels options
	        foreach ( $objects as $obj ) {
	        	/** @var Plugin|Pixel|Settings $obj */
		        $obj->updateOptions();
	        }
            GATags()->updateOptions();
	        purgeCache();

        }

    }

    private function updateDefaultNoCogOption($core_options,$optionName,$defaultOptionName) {
        $val = $core_options[$optionName];
        $currentVal = $this->getOption($optionName);
        if($val != 'cog') {
            $core_options[$defaultOptionName] = $val;
        } elseif ( $currentVal != 'cog' ) {
            $core_options[$defaultOptionName] = $currentVal;
        }
        return $core_options;
    }

    private function adminResetSettings() {

	    if ( ! $this->adminSecurityCheck() ) {
		    return;
	    }

	    if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'pys_save_settings' ) && isset( $_REQUEST['pys']['reset_settings'] ) ) {
	    	
		    if ( isPinterestActive() ) {

			    $old_options = array(
				    'license_key'     => Pinterest()->getOption( 'license_key' ),
				    'license_status'  => Pinterest()->getOption( 'license_status' ),
				    'license_expires' => Pinterest()->getOption( 'license_expires' ),
				    'pixel_id'        => Pinterest()->getOption( 'pixel_id' ),
			    );

			    Pinterest()->resetToDefaults();
			    Pinterest()->updateOptions( $old_options );

		    }

		    if ( isRedditActive() ) {
			    $old_options = array(
				    'license_key'     => Reddit()->getOption( 'license_key' ),
				    'license_status'  => Reddit()->getOption( 'license_status' ),
				    'license_expires' => Reddit()->getOption( 'license_expires' ),
				    'pixel_id'        => Reddit()->getPixelIDs(),
			    );

			    Reddit()->resetToDefaults();
			    Reddit()->updateOptions( $old_options );
		    }
		    
		    PYS()->resetToDefaults();
		    Facebook()->resetToDefaults();
		    GA()->resetToDefaults();
		    
		    // do redirect
		    wp_safe_redirect( buildAdminUrl( 'pixelyoursite' ) );
		    exit;

	    }

    }
    
    private function adminEnableGdprAjax() {
        
        if ( ! $this->adminSecurityCheck() ) {
            return;
        }
	    // Verify nonce specifically for GDPR AJAX action
	    if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'pys_enable_gdpr_ajax' ) ) {
		    return;
	    }
        if ( isset( $_REQUEST['pys']['enable_gdpr_ajax'] ) ) {
            $this->updateOptions( array(
                'gdpr_ajax_enabled' => true,
                'gdpr_cookie_law_info_integration_enabled' => true,
                'consent_magic_integration_enabled' => true,
            ) );
            
            add_action( 'admin_notices', 'PixelYourSite\adminGdprAjaxEnabledNotice' );
            purgeCache();
        }
        
    }

    function restoreSettingsAfterCog() {

        $params = array();
        $oldPurchase = $this->getOption("woo_purchase_value_cog");
        $oldContent = $this->getOption("woo_content_value_cog");
        $oldAddCart = $this->getOption("woo_add_to_cart_value_cog");
        $oldInitCheckout = $this->getOption("woo_initiate_checkout_value_cog");

        if($this->getOption('woo_purchase_value_option') == 'cog') {
            if(!empty($oldPurchase)) $params['woo_purchase_value_option'] = $oldPurchase;
            else $params['woo_purchase_value_option'] = "price";
        }
        if($this->getOption('woo_view_content_value_option') == 'cog') {
            if(!empty($oldContent)) $params['woo_view_content_value_option'] = $oldContent;
            else $params['woo_view_content_value_option'] = "price";
        }
        if($this->getOption('woo_add_to_cart_value_option') == 'cog') {
            if(!empty($oldAddCart)) $params['woo_add_to_cart_value_option'] = $oldAddCart;
            else $params['woo_add_to_cart_value_option'] = "price";
        }
        if($this->getOption('woo_initiate_checkout_value_option') == 'cog') {
            if(!empty($oldInitCheckout)) $params['woo_initiate_checkout_value_option'] = $oldInitCheckout;
            else $params['woo_initiate_checkout_value_option'] = "price";
        }

        $params['woo_purchase_value_cog'] = '';
        $params['woo_content_value_cog'] = '';
        $params['woo_add_to_cart_value_cog'] = '';
        $params['woo_initiate_checkout_value_cog'] = '';

        $this->updateOptions($params);
    }

    public function getLog() {
        return $this->logger;
    }

    function woo_is_order_received_page() {
        if(is_order_received_page()) return true;
        global $post;
        $ids = PYS()->getOption("woo_checkout_page_ids");
        if(!empty($ids)) {
            if($post && in_array($post->ID,$ids)) {
                return true;
            }
        }
        if (did_action( 'elementor/loaded' )) {
            if ($post) {
                $elementor_page_id = get_option('elementor_woocommerce_purchase_summary_page_id');
                if ($elementor_page_id == $post->ID) return true;
            }
        }

        if(is_wc_endpoint_url( 'order-received')){
            return true;
        }

        return false;
    }
	public function isCachePreload() {
		if(!empty($_SERVER['HTTP_USER_AGENT'])){
			$options = array('WP Rocket/Preload', 'WP-Rocket-Preload', 'WP Rocket/Homepage_Preload', 'lscache_runner', 'LiteSpeed Cache', 'LiteSpeed-Cache');
			foreach($options as $row) {
				if (stripos(strtolower($_SERVER['HTTP_USER_AGENT']), strtolower($row)) !== false) {
					return true;
				}
			}
		}
		return false;
	}

    /**
     * @param $order_id
     * @param $posted_data
     * @param \WC_Order $order
     * @throws \JsonException
     */
	public function woo_checkout_process( $order_id, $posted_data, $order ) {
		if ( !apply_filters( 'pys_disable_advanced_form_data_cookie', false ) && !apply_filters( 'pys_disable_advance_data_cookie', false ) ) {
			$first_name = $order->get_billing_first_name();
			$last_name = $order->get_billing_last_name();
			$email = $order->get_billing_email();
			$phone = $order->get_billing_phone();
			$phone = preg_replace( '/[^0-9.]+/', '', $phone );

			$user_persistence_data = get_persistence_user_data( $email, $first_name, $last_name, $phone );
			$userData = array(
				'first_name' => $user_persistence_data[ 'fn' ],
				'last_name'  => $user_persistence_data[ 'ln' ],
				'email'      => $user_persistence_data[ 'em' ],
				'phone'      => $user_persistence_data[ 'tel' ]
			);

			setcookie( "pys_advanced_form_data", json_encode($userData, JSON_THROW_ON_ERROR), 2147483647, '/', PYS()->general_domain );
		}
	}

	function edd_recurring_payment( $payment_id ) {
		EnrichOrder()->edd_save_subscription_meta( $payment_id );
	}
    public function get_wp_cookie_domain() {
        // Getting the site URL
        $site_url = get_site_url();

        // Parse domain from URL
        $host = parse_url($site_url, PHP_URL_HOST);

        // Remove the subdomain, if there is one, leaving the main domain
        $parts = explode('.', $host);
        if (count($parts) > 2) {
            $domain = '.' . $parts[count($parts) - 2] . '.' . $parts[count($parts) - 1];
        } else {
            $domain = '.' . $host;
        }
        return $domain;
    }
	public function saveExternalIDInOrder($order_param) {
		// Determine whether the WC_Order object or order ID is passed
		if ( $order_param instanceof WC_Order ) {
			// If the order object is transferred
			$order = $order_param;
		} else {
			// If order_id is passed
			$order = wc_get_order( $order_param );
		}
		if (!$order && empty($order_param)) return;

		$external_id = PYS()->get_pbid();

		if (isWooCommerceVersionGte('3.0.0') && !empty($order)) {
			// WooCommerce >= 3.0
			$order->update_meta_data("external_id", $external_id);
			$order->save();
		} elseif ( ! empty( $order_param ) ) {
			// WooCommerce < 3.0
			update_post_meta($order_param, 'external_id', $external_id);
		}

	}

    public function saveExternalIDInEddOrder($payment_id, $payment_data) {
        if ( empty( $payment_id ) ) {
            return;
        }

        $external_id = PYS()->get_pbid();

        if ( ! empty( $external_id ) ) {
            edd_update_payment_meta( $payment_id, 'external_id', $external_id );
        }
    }
}

/**
 * @return PYS
 */
function PYS() {
    return PYS::instance();
}