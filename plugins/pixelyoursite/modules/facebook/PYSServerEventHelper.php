<?php
namespace PixelYourSite;

use PixelYourSite;
use PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\Event;
use PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\UserData;
use PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\CustomData;
use PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\Content;
defined('ABSPATH') or die('Direct access not allowed');


class ServerEventHelper {
    private static $fbp;
    private static $fbc;
    /**
     * @param SingleEvent $event
     * @return Event | null
     */
    public static function mapEventToServerEvent($event) {

        $eventData = $event->getData();
        $eventData = EventsManager::filterEventParams($eventData,$event->getCategory(),[
            'event_id'=>$event->getId(),
            'pixel'=>Facebook()->getSlug()
        ]);

        $eventName = $eventData['name'];
        $eventParams = $eventData['params'];
        $eventId = $event->payload['eventID'];
        $wooOrder = isset($event->payload['woo_order']) ? $event->payload['woo_order'] : null;
        $eddOrder = isset($event->payload['edd_order']) ? $event->payload['edd_order'] : null;

        if(!$eventId) return null;

        $user_data = ServerEventHelper::getUserData($wooOrder,$eddOrder)
            ->setClientIpAddress(self::getIpAddress())
            ->setClientUserAgent(self::getHttpUserAgent());

		if ( Consent()->checkConsent( 'facebook' ) ) {
			if ( !self::getFbp() && ( !isset( $eventParams[ '_fbp' ] ) || !$eventParams[ '_fbp' ] ) && !headers_sent() ) {
				self::setFbp( 'fb.1.' . time() . '.' . rand( 1000000000, 9999999999 ) );
				if ( !headers_sent() ) {
					setcookie( "_fbp", self::getFbp(), 2147483647, '/', PYS()->general_domain );
				}
			}

			if ( !self::getFbc() && self::getUrlParameter( 'fbclid' ) ) {
				$fbclid = self::getUrlParameter( 'fbclid' );
				if ( $fbclid ) {
					self::setFbc( 'fb.1.' . time() . '.' . $fbclid );
					if ( !headers_sent() ) {
						setcookie( "_fbc", self::$fbc, 2147483647, '/', PYS()->general_domain );
					}
				}
			}
		}

        $fbp = '';
        $fbc = '';

        if ($wooOrder) {
            $fbp = ServerEventHelper::getFbStatFromOrder('fbp', $wooOrder);
            $fbc = ServerEventHelper::getFbStatFromOrder('fbc', $wooOrder);
        }

// Checking that the values are not empty and setting alternative values if they are missing
        if(empty($fbp)) {
            $fbp = self::getFbp() ?? $eventParams['_fbp'] ?? '';
        }
        if (empty($fbc)) {
            $fbc = self::getFbc() ?? $eventParams['_fbc'] ?? '';
        }

        if(!empty($fbp)) { $user_data->setFbp($fbp); }
        if(!empty($fbc)) { $user_data->setFbc($fbc); }

        $customData = self::paramsToCustomData($eventParams);
        $uri = self::getRequestUri(PYS()->getOption('enable_remove_source_url_params'));

        // set custom uri use in ajax request
        if(isset($_POST['url'])) {
            if(PYS()->getOption('enable_remove_source_url_params')) {
                $list = explode("?",$_POST['url']);
                if(is_array($list) && count($list) > 0) {
                    $uri = $list[0];
                } else {
                    $uri = $_POST['url'];
                }
            } else {
                $uri = $_POST['url'];
            }
        }

        $event = (new Event())
            ->setEventName($eventName)
            ->setEventTime(time())
            ->setEventId($eventId)
            ->setEventSourceUrl($uri)
            ->setActionSource("website")
            ->setCustomData($customData)
            ->setUserData($user_data);

		if ( Facebook()->getLDUMode() ) {
			$event
			->setDataProcessingOptions( [ 'LDU' ] )
			->setDataProcessingOptionsCountry( 0 )
			->setDataProcessingOptionsState( 0 );
		}

        return $event;
    }

    /**
     * @param $key
     * @param $wooOrder
     * @return string|null
     */
    private static function getFbStatFromOrder($key,$wooOrder) {

        $order = wc_get_order( $wooOrder );
        if($order) {
            $fbCookie = $order->get_meta('pys_fb_cookie',true);
            if($fbCookie){
                if(!empty($fbCookie[$key])) {
                    return $fbCookie[$key];
                }
            }
        }
        return null;
    }


    private static function getIpAddress() {
        $HEADERS_TO_SCAN = array(
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        );

        foreach ($HEADERS_TO_SCAN as $header) {
            if (array_key_exists($header, $_SERVER)) {
                $ip_list = explode(',', $_SERVER[$header]);
                foreach($ip_list as $ip) {
                    $trimmed_ip = trim($ip);
                    if (self::isValidIpAddress($trimmed_ip)) {
                        return $trimmed_ip;
                    }
                }
            }
        }

        return "127.0.0.1";
    }

    private static function isValidIpAddress($ip_address) {
        return filter_var($ip_address,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4
            | FILTER_FLAG_IPV6
            | FILTER_FLAG_NO_PRIV_RANGE
            | FILTER_FLAG_NO_RES_RANGE);
    }

    private static function getHttpUserAgent() {
        $user_agent = null;

        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        return $user_agent;
    }

    private static function getRequestUri($removeQuery = false) {
        $request_uri = null;

        if (!empty($_SERVER['REQUEST_URI'])) {
            $start = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://";
            $host = $_SERVER['HTTP_HOST'] ?? parse_url(get_site_url(), PHP_URL_HOST);
            $request_uri = $start . $host . $_SERVER['REQUEST_URI'];
        }
        if($removeQuery && isset($_SERVER['QUERY_STRING'])) {
            $request_uri = str_replace("?".$_SERVER['QUERY_STRING'],"",$request_uri);
        }


        return $request_uri;
    }
    static function getUrlParameter($sParam) {
        $sPageURL = $_SERVER['QUERY_STRING'];
        $sURLVariables = explode('&', $sPageURL);

        foreach ($sURLVariables as $sURLVariable) {
            $sParameterName = explode('=', $sURLVariable);

            if ($sParameterName[0] === $sParam) {
                return isset($sParameterName[1]) ? urldecode($sParameterName[1]) : true;
            }
        }

        return false;
    }

    public static function setFbp($fbp) {
        self::$fbp = $fbp;
    }

    public static function setFbc($fbc) {
        self::$fbc = $fbc;
    }
    public static function getFbp() {
        $fbp = null;

        if (!empty($_COOKIE['_fbp'])) {
            $fbp = $_COOKIE['_fbp'];
        }
        elseif (!empty(self::$fbp)){
            $fbp = self::$fbp;
        }
        return $fbp;
    }

    public static function getFbc() {
        $fbc = null;

        if (!empty($_COOKIE['_fbc'])) {
            $fbc = $_COOKIE['_fbc'];
        }
        elseif (!empty(self::$fbc)){
            $fbc = self::$fbc;
        }
        return $fbc;
    }

    private static function getUserData($wooOrder = null,$eddOrder = null) {
        $userData = new UserData();

        /**
         * Add purchase WooCommerce Advanced Matching params
         */
        if ( PixelYourSite\isWooCommerceActive() && isEventEnabled( 'woo_purchase_enabled' ) &&
            ($wooOrder || ( PYS()->woo_is_order_received_page() && wooIsRequestContainOrderId() ))
        ) {
            if(wooIsRequestContainOrderId()) {
                $order_id = wooGetOrderIdFromRequest();
            } else {
                $order_id = $wooOrder;
            }

            $order = wc_get_order( $order_id );

            if ( $order ) {

                if ( PixelYourSite\isWooCommerceVersionGte( '3.0.0' ) ) {

					$user_firstname = $order->get_billing_first_name();
					$user_lastname = $order->get_billing_last_name();
					$user_phone = $order->get_billing_phone();
					$user_email = $order->get_billing_email();

                    if($order->get_billing_postcode()) {
                        $userData->setZipCode($order->get_billing_postcode());
                    }
                    if($order->get_billing_country()) {
                        $userData->setCountryCode(strtolower($order->get_billing_country()));
                    }
                    if($order->get_billing_city()) {
                        $userData->setCity($order->get_billing_city());
                    }
                    if($order->get_billing_state()) {
                        $userData->setState($order->get_billing_state());
                    }
                    if($order->get_meta( 'external_id' )){
                        $external_id = $order->get_meta( 'external_id' );
                        if (!empty($external_id)) {
                            $userData->setExternalId($external_id);
                        }
                    }
                } else {
					$user_firstname = $order->billing_first_name;
					$user_lastname = $order->billing_last_name;
					$user_phone = $order->billing_phone;
					$user_email = $order->billing_email;

                    if($order->billing_postcode) {
                        $userData->setZipCode($order->billing_postcode);
                    }
                    $userData->setCountryCode(strtolower($order->billing_country));
                    $userData->setCity($order->billing_city);
                    $userData->setState($order->billing_state);
                    if(get_post_meta( $order_id, 'external_id', true )){
                        $external_id = get_post_meta( $order_id, 'external_id', true );
                        if (!empty($external_id)) {
                            $userData->setExternalId($external_id);
                        }
                    }
                }

				$user_persistence_data = get_persistence_user_data( $user_email, $user_firstname, $user_lastname, $user_phone );
				if ( !empty( $user_persistence_data[ 'fn' ] ) ) $userData->setFirstName( $user_persistence_data[ 'fn' ] );
				if ( !empty( $user_persistence_data[ 'ln' ] ) ) $userData->setLastName( $user_persistence_data[ 'ln' ] );
				if ( !empty( $user_persistence_data[ 'em' ] ) ) $userData->setEmail( $user_persistence_data[ 'em' ] );
				if ( !empty( $user_persistence_data[ 'tel' ] ) ) $userData->setPhone( $user_persistence_data[ 'tel' ] );

				$user_id = $order->get_user_id();
				if ( $user_id && apply_filters( 'pys_send_meta_id', true ) ) {
					$login_id = get_user_meta( $user_id, '_socplug_social_id_Facebook', true );
					if ( !empty( $login_id ) ) {
						$userData->setFbLoginId( $login_id );
					}
				}

            } else {
                return ServerEventHelper::getRegularUserData();
            }

        } else {

            if(PixelYourSite\isEddActive() && isEventEnabled( 'edd_purchase_enabled' ) &&
                ($eddOrder ||  edd_is_success_page()) ) {

                if($eddOrder)
                    $payment_id = $eddOrder;
                else {
                    $payment_key = getEddPaymentKey();
                    $payment_id = (int) edd_get_purchase_id_by_key( $payment_key );
                }
                $user_info = edd_get_payment_meta_user_info($payment_id);
                $email = edd_get_payment_user_email($payment_id);
				$user_firstname = $user_lastname = $user_email = '';

				if ( isset($user_info[ 'first_name' ]) && $user_info[ 'first_name' ] ) {
					$user_firstname = $user_info[ 'first_name' ];
				}
				if (isset($user_info[ 'last_name' ]) &&  $user_info[ 'last_name' ] ) {
					$user_lastname = $user_info[ 'last_name' ];
				}
				if ( $email ) {
					$user_email = $email;
				}

				$user_persistence_data = get_persistence_user_data( $user_email, $user_firstname, $user_lastname, '' );
				if ( !empty( $user_persistence_data[ 'fn' ] ) ) $userData->setFirstName( $user_persistence_data[ 'fn' ] );
				if ( !empty( $user_persistence_data[ 'ln' ] ) ) $userData->setLastName( $user_persistence_data[ 'ln' ] );
				if ( !empty( $user_persistence_data[ 'em' ] ) ) $userData->setEmail( $user_persistence_data[ 'em' ] );
				if ( !empty( $user_persistence_data[ 'tel' ] ) ) $userData->setPhone( $user_persistence_data[ 'tel' ] );

                // Get external_id from EDD payment meta
                $external_id = edd_get_payment_meta( $payment_id, 'external_id', true );
                if ( !empty( $external_id ) ) {
                    $userData->setExternalId( $external_id );
                }

				if ( $user_info[ 'id' ] && apply_filters( 'pys_send_meta_id', true ) ) {
					$login_id = get_user_meta( $user_info[ 'id' ], '_socplug_social_id_Facebook', true );
					if ( !empty( $login_id ) ) {
						$userData->setFbLoginId( $login_id );
					}
				}

			} else {
                return ServerEventHelper::getRegularUserData();
            }
        }

        return $userData;
    }

    private static function getRegularUserData() {
        $user = wp_get_current_user();
        $userData = new UserData();
        if ( $user->ID ) {
            // get user regular data
			$user_firstname = $user->get( 'user_firstname' );
			$user_lastname = $user->get( 'user_lastname' );
			$user_phone = $user->get( 'billing_phone' );

            /**
             * Add common WooCommerce Advanced Matching params
             */
            if ( PixelYourSite\isWooCommerceActive() ) {
                // if first name is not set in regular wp user meta
				if ( empty( $user_firstname ) ) {
					$user_firstname = $user->get( 'billing_first_name' );
				}

                // if last name is not set in regular wp user meta
				if ( empty( $user_lastname ) ) {
					$user_lastname = $user->get( 'billing_last_name' );
				}

                if($user->get('billing_phone'))
                    $userData->setPhone($user->get('billing_phone'));
                if($user->get('billing_city'))
                    $userData->setCity($user->get('billing_city'));
                if($user->get('billing_state'))
                    $userData->setState($user->get('billing_state'));
                if($user->get('shipping_country'))
                    $userData->setCountryCode(strtolower($user->get('shipping_country')));
                if($user->get('billing_postcode')) {
                    $userData->setZipCode($user->get('billing_postcode'));
                }
            }
			$user_persistence_data = get_persistence_user_data( $user->get( 'user_email' ), $user_firstname, $user_lastname, $user_phone );
            if(PixelYourSite\EventsManager::isTrackExternalId()){
                if (!empty(PixelYourSite\PYS()->get_pbid())) {
                    $userData->setExternalId(PixelYourSite\PYS()->get_pbid());
                }
            }

			$login_id = get_user_meta( $user->ID, '_socplug_social_id_Facebook', true );
			if ( !empty( $login_id ) && apply_filters( 'pys_send_meta_id', true ) ) {
				$userData->setFbLoginId( $login_id );
			}
        } else {
			$user_persistence_data = get_persistence_user_data( '', '', '', '' );
            if (PixelYourSite\EventsManager::isTrackExternalId() && isset($_COOKIE['pbid'])) {
                $userData->setExternalId($_COOKIE['pbid']);
            }
        }

		if ( !empty( $user_persistence_data[ 'fn' ] ) ) $userData->setFirstName( $user_persistence_data[ 'fn' ] );
		if ( !empty( $user_persistence_data[ 'ln' ] ) ) $userData->setLastName( $user_persistence_data[ 'ln' ] );
		if ( !empty( $user_persistence_data[ 'em' ] ) ) $userData->setEmail( $user_persistence_data[ 'em' ] );
		if ( !empty( $user_persistence_data[ 'tel' ] ) ) $userData->setPhone( $user_persistence_data[ 'tel' ] );

        return $userData;
    }

    static function paramsToCustomData($data) {

        if(isset($data['contents']) && is_array($data['contents'])) {
            $contents = array();
            foreach ($data['contents'] as $c) {
                $contents[] = new Content([
                    'product_id' => $c['id'],
                    'quantity'  => $c['quantity']
                ]);
            }
            $data['contents'] = $contents;
        } else {
            $data['contents'] = array();
        }

        $customData = new CustomData($data);
        $customProperties = array();


        if(isset($data['category_name'])) {
            $customData->setContentCategory($data['category_name']);
        }

        $custom_values = ['event_action','download_type','download_name','download_url','target_url','text','trigger','traffic_source','plugin','user_role','event_url','page_title',"post_type",'post_id','categories','tags','video_type',
            'video_id','video_title','event_trigger','link_type','tag_text',"URL",
            'form_id','form_class','form_submit_label','transactions_count','average_order',
            'shipping_cost','tax','total','shipping','coupon_used','post_category','landing_page'];


        $adding_custom_field = array();

        $eventsCustom = EventsCustom()->getEvents();
        foreach ($eventsCustom as $event)
        {
            $fbCustomEvents = $event->getFacebookCustomParams();

            foreach ($fbCustomEvents as $paramKey => $params)
            {
                if(!in_array($params['name'], $custom_values))
                {
                    $adding_custom_field[] = $params['name'];
                }
            }
        }
        $result_custom_values = array_merge($custom_values, $adding_custom_field);
        foreach ($result_custom_values as $val) {
            if(isset($data[$val])){
                $customProperties[$val] = $data[$val];
            }
        }

        $customData->setCustomProperties($customProperties);
        return $customData;
    }

}