<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/** @noinspection PhpIncludeInspection */
require_once PYS_FREE_PATH . '/modules/google_gtm/function-helpers.php';

use PixelYourSite\GTM\Helpers;
use WC_Product;

class GTM extends Settings implements Pixel {

    private static $_instance;
    private $isEnabled;
    private $configured;


    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;

    }

    public function __construct() {

        parent::__construct( 'gtm' );

        $this->locateOptions(
            PYS_FREE_PATH . '/modules/google_gtm/options_fields.json',
            PYS_FREE_PATH . '/modules/google_gtm/options_defaults.json'
        );
        add_action( 'pys_register_pixels', function( $core ) {
            /** @var PYS $core */
            $core->registerPixel( $this );
        } );

        add_action('init', array($this, 'init'));

    }

    public function init()
    {
        $this->isEnabled = $this->enabled();
        if($this->isEnabled) {
            add_action('wp_head', array($this, 'pys_wp_header_top'), 1, 0);
        }
    }

    public function enabled() {
        $enabled = $this->getOption( 'enabled' ) && ($this->getOption( 'gtm_id' ) || $this->getOption( 'gtm_just_data_layer' ));
        return $enabled;
    }

    public function configured() {

        if ( $this->configured === null ) {

            $this->configured = $this->enabled()
                && ! apply_filters( 'pys_pixel_disabled', array(), $this->getSlug() );

        }

        return $this->configured;

    }
    public function pys_wp_header_top( $echo = true ) {

        $has_html5_support    = current_theme_supports( 'html5' );
        $gtm_dataLayer_name = $this->getOption( 'gtm_dataLayer_name' ) ?? 'dataLayer';
        // the data layer initialization has to use 'var' instead of 'let' since 'let' can break related browser extension and 3rd party script.
        $_gtm_top_content = '
<!-- Google Tag Manager by PYS -->
<script data-cfasync="false" data-pagespeed-no-defer' . ( $has_html5_support ? ' type="text/javascript"' : '' ) . '>
	var pys_datalayer_name = "' . esc_js( $gtm_dataLayer_name ) . '";
	window.' . esc_js( $gtm_dataLayer_name ) . ' = window.' . esc_js( $gtm_dataLayer_name ) . ' || [];';

        if($this->getOption( 'check_list') != 'disabled' && !empty($this->getOption( 'check_list_contain'))){
            $elementName = 'gtm.'.$this->getOption( 'check_list');
            $element = [];
            $element[$elementName] = array_values($this->getOption( 'check_list_contain'));
            $_gtm_top_content .= esc_js( $gtm_dataLayer_name ).'.push('.json_encode($element).');';
        }
        $_gtm_top_content .= '</script> 
<!-- End Google Tag Manager by PYS -->';

        if ( $echo ) {
            echo wp_kses(
                $_gtm_top_content,
                array(
                    'script' => array(
                        'data-cfasync'            => array(),
                        'data-pagespeed-no-defer' => array(),
                        'data-cookieconsent'      => array(),
                    ),
                )
            );
        } else {
            return $_gtm_top_content;
        }
    }
    public function getPixelIDs() {

        $ids = (array) $this->getOption( 'gtm_id' );

        if(count($ids) == 0|| empty($ids[0])) {
            return apply_filters("pys_gtm_ids",[]);
        } else {
			$id = array_shift($ids);
			return apply_filters("pys_gtm_ids", array($id)); // return first id only
        }
    }


    public function getPixelOptions() {
        $options = array(
            'trackingIds'                   => $this->getAllPixels(),
            'gtm_dataLayer_name'            => $this->getOption( 'gtm_dataLayer_name' ),
            'gtm_container_domain'          => $this->getOption( 'gtm_container_domain' ),
            'gtm_container_identifier'      => $this->getOption( 'gtm_container_identifier' ),
            'gtm_auth'                      => $this->getOption( 'gtm_auth' ),
            'gtm_preview'                   => $this->getOption( 'gtm_preview' ),
            'gtm_just_data_layer'           => $this->getOption( 'gtm_just_data_layer' ),
            'check_list'                    => $this->getOption( 'check_list' ),
            'check_list_contain'            => $this->getOption( 'check_list_contain' ),
            'wooVariableAsSimple'           => GTM()->getOption( 'woo_variable_as_simple' ),
        );

        return $options;
    }

    public function updateOptions( $values = null ) {
        if(!isset($_POST['pys'][ $this->getSlug() ]['select_all_blacklist'])) {
            $_POST['pys'][ $this->getSlug() ]['select_all_blacklist'] = array();
        }
        parent::updateOptions($values);
    }
    /**
     * Create pixel event and fill it
     * @param SingleEvent $event
     */
    public function generateEvents($event) {
        $pixelEvents = [];
        if ( ! $this->configured() ) {
            return [];
        }

        $pixelIds = $this->getAllPixels(false);


        $pixelEvent = clone $event;
        if($this->addParamsToEvent($pixelEvent)) {
            $pixelEvent->addPayload([ 'trackingIds' => $pixelIds ]);
            $pixelEvents[] = $pixelEvent;
        }

        return $pixelEvents;
    }

    //refactor it
    private function addDataToEvent($eventData,&$event) {

        $params = $eventData["data"];
        unset($eventData["data"]);
        //unset($eventData["name"]);
        $event->addPayload($eventData);
        $event->addParams($params);

    }
    public function addParamsToEvent(&$event)
    {
        if (!$this->configured()) {
            return false;
        }
        $isActive = false;
        $triggerType = Helpers\getTriggerType($event->getId());
        if ($triggerType) {
            $event->addParams(['triggerType' => ['type' => $triggerType]]);
        }
        switch ($event->getId()) {
            //Automatic events

            case 'automatic_event_signup' : {
                $event->addPayload(["name" => "sign_up"]);
                $isActive = $this->getOption($event->getId().'_enabled');
            } break;
            case 'automatic_event_login' :{
                $event->addPayload(["name" => "login"]);
                $isActive = $this->getOption($event->getId().'_enabled');
            } break;
            case 'automatic_event_404' :{
                $event->addPayload(["name" => "404"]);
                $isActive = $this->getOption($event->getId().'_enabled');
            } break;
            case 'automatic_event_search' :{
                $event->addPayload(["name" => "search"]);
                $event->addParams([
                    "search_term"       =>  empty( $_GET['s'] ) ? null : $_GET['s'],
                ]);
                $isActive = $this->getOption($event->getId().'_enabled');
            } break;

            case 'automatic_event_form' :
            case 'automatic_event_download' :
            case 'automatic_event_comment' :
            case 'automatic_event_scroll' :
            case 'automatic_event_time_on_page' : {
                $isActive = $this->getOption($event->getId().'_enabled');
            }break;


            case 'init_event': {
                $eventData = $this->getOption('track_page_view') ? $this->getPageViewEventParams() : false;

                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            } break;


            case 'custom_event': {
                $eventData = $this->getCustomEventData($event);
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;
            case 'woo_view_content': {
                $eventData =  $this->getWooViewContentEventParams();
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;
            case 'woo_view_cart': {
                $isActive =  $this->getWooViewCartEventParams($event);
            }break;
            case 'woo_add_to_cart_on_cart_page':
            case 'woo_add_to_cart_on_checkout_page':{
                $eventData =  $this->getWooAddToCartOnCartEventParams();
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;
            case 'woo_remove_from_cart':{
                $isActive =  $this->getWooRemoveFromCartParams( $event );

            }break;
            case 'woo_initiate_checkout':{
                $eventData =  $this->getWooInitiateCheckoutEventParams();
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;
            case 'woo_purchase':{
                $eventData =  $this->getWooPurchaseEventParams();
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;
            case 'edd_view_content': {
                $eventData = $this->getEddViewContentEventParams();
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;
            case 'edd_add_to_cart_on_checkout_page':  {
                $eventData = $this->getEddCartEventParams('add_to_cart');
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;
            case 'edd_remove_from_cart': {
                $eventData =  $this->getEddRemoveFromCartParams( $event->args['item'] );
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;


            case 'edd_initiate_checkout': {
                $eventData = $this->getEddCartEventParams('begin_checkout');
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;

            case 'edd_purchase': {
                $eventData = $this->getEddCartEventParams('purchase');
                if ($eventData) {
                    $isActive = true;
                    $this->addDataToEvent($eventData, $event);
                }
            }break;

            case 'woo_add_to_cart_on_button_click': {
                if (  $this->getOption( 'woo_add_to_cart_enabled' ) && PYS()->getOption( 'woo_add_to_cart_on_button_click' ) ) {
                    $isActive = true;
                    if(isset($event->args['productId'])) {
                        $eventData =  $this->getWooAddToCartOnButtonClickEventParams( $event );

                        if($eventData) {
                            $event->addParams($eventData["params"]);
                            unset($eventData["params"]);
                            $event->addPayload($eventData);
                        }
                    }
                    $event->addPayload(array(
                        'name'=>"add_to_cart"
                    ));
                }
            }break;

            case 'edd_add_to_cart_on_button_click': {
                if (  $this->getOption( 'edd_add_to_cart_enabled' ) && PYS()->getOption( 'edd_add_to_cart_on_button_click' ) ) {
                    $isActive = true;
                    if($event->args != null) {
                        $eventData =  $this->getEddAddToCartOnButtonClickEventParams( $event->args );
                        $event->addParams($eventData);
                    }
                    $event->addPayload(array(
                        'name'=>"add_to_cart"
                    ));
                }
            }break;
        }
        return $isActive;
    }


    public function getEventData( $eventType, $args = null ) {

        return false;
    }

    public function outputNoScriptEvents() {

        if ( ! $this->configured() || $this->getOption('disable_noscript') || $this->getOption('gtm_just_data_layer') || empty($this->getPixelIDs())) {
            return;
        }

        $eventsManager = PYS()->getEventsManager();

        foreach ( $eventsManager->getStaticEvents( 'gtm' ) as $eventName => $events ) {
            foreach ( $events as $event ) {
                foreach ( $this->getPixelIDs() as $pixelID ) {
                    $args = array(
                        'v'    => 2,
                        'tid'  => $pixelID,
                        'cid'  => isset($_COOKIE['_ga']) ? preg_replace('/GA\d+\.\d+\.(\d+\.\d+)/', '$1', $_COOKIE['_ga']) : time() . '.' . rand(100000, 999999), // Generate a random Client ID
                        'en'   => $event['name'], // The name of the event (eg view_item)
                        'ep.eventID'  => $event['eventID'],
                    );

                    $args['dt'] = isset($event['params']['page_title']) ? urlencode($event['params']['page_title']) : '';
                    $args['dl'] = isset($event['params']['event_url']) ? urlencode($event['params']['event_url']) : '';
                    // DYNAMICALLY LOOPING THROUGH ALL PARAMETERS EXCEPT "items"
                    foreach ($event['params'] as $key => $value) {
                        if ($key === 'items' || $key === 'page_title' || $key === 'event_url') {
                            continue;
                        }
                        $args["ep.$key"] = is_array($value) ? json_encode($value) : $value;
                    }

                    // Adding products
                    if (!empty($event['params']['items'])) {
                        foreach ($event['params']['items'] as $key => $item) {
                            $args["pr" . ($key + 1) . "id"] = urlencode($item['item_id']);
                            $args["pr" . ($key + 1) . "nm"] = urlencode($item['item_name']);
                            $args["pr" . ($key + 1) . "pr"] = (float)$item['price'];
                            $args["pr" . ($key + 1) . "qt"] = (int)$item['quantity'];
                            $args["pr" . ($key + 1) . "ca"] = urlencode($item['item_category']);
                        }
                    }

                    $src = add_query_arg( $args, 'https://www.google-analytics.com/collect' );
                    $src = str_replace("[","%5B",$src);
                    $src = str_replace("]","%5D",$src);

                    // ALT tag used to pass ADA compliance
                    printf( '<noscript><img height="1" width="1" style="display: none;" src="%s" alt="google_gtm"></noscript>',
                        $src );

                    echo "\r\n";

                }
            }
        }

    }

    private function getPageViewEventParams() {

        return array(
            'name' => 'page_view',
            'data' => array(),
        );

    }


    /**
     * @param CustomEvent $event
     *
     * @return array|bool
     */
    private function getCustomEventData( $event ) {
        /**
         * @var CustomEvent $customEvent
         */
        $customEvent = $event->args;
        $gtm_action = $customEvent->getGTMAction();


        if ( ! $customEvent->isGTMEnabled() || empty( $gtm_action ) ) {
            return false;
        }


        $params = $customEvent->getAllGTMParams();
        $params['manualName'] = $customEvent->getManualCustomObjectName();

        if($customEvent->removeGTMCustomTrigger()){
            $event->removeParam('triggerType');
        }

        $event->addPayload(array(
            'hasAutoParam' => $customEvent->hasAutomatedParam(),
        ));
        return array(
            'name'  => $customEvent->getGTMAction(),
            'data'  => $params,
            'delay' => $customEvent->getDelay(),

        );

    }

    private function getWooViewItemListTag() {
        global $posts, $wp_query;

        if ( ! $this->getOption( 'woo_view_item_list_enabled' ) ) {
            return false;
        }
        $product_tag = '';
        $product_tag_slug = '';
        $tag_obj = $wp_query->get_queried_object();
        if ( $tag_obj ) {
            $product_tag = single_tag_title( '', false );
            $product_tag_slug = $tag_obj->slug;
        }

        $items = array();

        for ( $i = 0; $i < count( $posts )&& $i < 10; $i ++ ) {

            if ( $posts[ $i ]->post_type !== 'product' ) {
                continue;
            }

            $item = array(
                'item_id'            => Helpers\getWooProductContentId($posts[ $i ]->ID),
                'item_name'          => $posts[ $i ]->post_title,
                'quantity'      => 1,
                'price'         => getWooProductPriceToDisplay( $posts[ $i ]->ID ),
            );
            $category = $this->getCategoryArrayWoo($posts[ $i ]->ID);
            if(!empty($category))
            {
                $item = array_merge($item, $category);
            }

            $items[] = $item;

        }

        $params = array(
            'event_category'  => 'ecommerce',
            'event_label'     => 'tag',
            'currency'        => get_woocommerce_currency(),
            'items'           => $items,
        );

        return array(
            'name'  => 'view_item_list',
            'data'  => $params,
        );
    }

    private function getWooViewItemListShop() {
        /**
         * @var \WC_Product $product
         * @var $related_products \WC_Product[]
         */

        global $posts;

        if ( ! $this->getOption( 'woo_view_item_list_enabled' ) ) {
            return false;
        }


        $list_name = 'Shop page';
        $list_id = 'shop_page';
        $items = array();

        foreach ( $posts as $i=>$post) {
            if( $post->post_type != 'product') continue;
            $item = array(
                'item_id'            => Helpers\getWooProductContentId($post->ID),
                'item_name'          => $post->post_title ,
                'quantity'      => 1,
                'price'         => getWooProductPriceToDisplay( $post->ID ),
            );
            $category = $this->getCategoryArrayWoo($post->ID);
            if(!empty($category))
            {
                $item = array_merge($item, $category);
            }
            $items[] = $item;
        }


        $params = array(
            'event_category'  => 'ecommerce',
            'currency'        => get_woocommerce_currency(),
            'event_label'     => $list_name,
            'items'           => $items,
        );


        return array(
            'name'  => 'view_item_list',
            'data'  => $params,
        );
    }

    private function getWooViewItemListSearch() {
        /**
         * @var \WC_Product $product
         * @var $related_products \WC_Product[]
         */

        global $posts;

        if ( ! $this->getOption( 'woo_view_item_list_enabled' ) ) {
            return false;
        }



        $list_name = "Search Results";
        $list_id = 'search_results';
        $items = array();
        $i = 0;

        foreach ( $posts as $post) {
            if( $post->post_type != 'product') continue;
            $item = array(
                'item_id'            => Helpers\getWooProductContentId($post->ID),
                'item_name'          => $post->post_title ,
                'quantity'      => 1,
                'price'         => getWooProductPriceToDisplay( $post->ID ),
            );
            $category = $this->getCategoryArrayWoo($post->ID);
            if(!empty($category))
            {
                $item = array_merge($item, $category);
            }

            $items[] = $item;
        }

        $params = array(
            'event_category'  => 'ecommerce',
            'currency'        => get_woocommerce_currency(),
            'event_label'     => $list_name,
            'items'           => $items,
        );


        return array(
            'name'  => 'view_item_list',
            'data'  => $params,
        );
    }

    /**
     * @param string $type
     * @param SingleEvent $event
     * @return bool
     */
    private function getWooSelectContent($type,&$event) {

        if(!$this->getOption('woo_select_content_enabled')) {
            return false;
        }


        $event->addParams( array(
            'event_category'  => 'ecommerce',
            'content_type'     => "product",
        ));
        $event->addPayload( array(
            'name'=>"select_item"
        ));

        return true;
    }




    private function getWooViewCategoryEventParams() {
        global $posts;

        if ( ! $this->getOption( 'woo_view_category_enabled' ) ) {
            return false;
        }

        $product_categories = array();
        $term = get_term_by( 'slug', get_query_var( 'term' ), 'product_cat' );

        if ( $term ) {
            $parent_ids = get_ancestors( $term->term_id, 'product_cat', 'taxonomy' );
            $product_categories[] = $term->name;

            foreach ( $parent_ids as $term_id ) {
                $parent_term = get_term_by( 'id', $term_id, 'product_cat' );
                $product_categories[] = $parent_term->name;
            }
        }


        $items = array();
        $product_ids = array();
        $total_value = 0;

        for ( $i = 0; $i < count( $posts ); $i ++ ) {

            if ( $posts[ $i ]->post_type !== 'product' ) {
                continue;
            }

            $item = array(
                'item_id'            => Helpers\getWooProductContentId($posts[ $i ]->ID),
                'item_name'          => $posts[ $i ]->post_title,
                'quantity'      => 1,
                'price'         => getWooProductPriceToDisplay( $posts[ $i ]->ID ),
            );
            $category = $this->getCategoryArrayWoo($posts[ $i ]->ID);
            if(!empty($category))
            {
                $item = array_merge($item, $category);
            }
            $items[] = $item;
            $product_ids[] = $item['item_id'];
            $total_value += $item['price'];

        }

        $params = array(
            'event_category'  => 'ecommerce',
            'event_label'     => 'category',
            'currency'        => get_woocommerce_currency(),
            'items'           => $items,
        );

        return array(
            'name'  => 'view_item_list',
            'data'  => $params,
        );

    }

    private function getWooViewContentEventParams() {

        if ( ! $this->getOption( 'woo_view_content_enabled' ) ) {
            return false;
        }
        $quantity = 1;
        $customProductPrice = -1;

        global $post;
        $product = wc_get_product( $post->ID );
        if(!$product)  return false;

        $productId = Helpers\getWooProductContentId($product->get_id());

        $items = array();
        $general_item = array(
            'item_id'       => $productId,
            'item_name'     => $product->get_name(),
            'quantity' => $quantity,
            'price'    => getWooProductPriceToDisplay($product->get_id(), $quantity, $customProductPrice),
        );

        $category = $this->getCategoryArrayWoo($productId);
        if(!empty($category))
        {
            $general_item = array_merge($general_item, $category);
        }

        $items[] = $general_item;
// Check if the product has variations
        if ($product->is_type('variable') && !GTM()->getOption( 'woo_variable_as_simple' )) {

            $variations = $product->get_available_variations();

            foreach ($variations as $variation) {
                $variationProduct = wc_get_product($variation['variation_id']);
                if($variationProduct) continue;
                $variationProductId = Helpers\getWooProductContentId($variation['variation_id']);
                $category = $this->getCategoryArrayWoo($variationProductId, true);

                $item = array(
                    'item_id'       => $variationProductId,
                    'item_name'     => GTM()->getOption('woo_variations_use_parent_name') ? $variationProduct->get_title() : $variationProduct->get_name(),
                    'quantity' => $quantity,
                    'price'    => getWooProductPriceToDisplay($variationProduct->get_id(), $quantity, $customProductPrice)
                );
                $items[] = array_merge($item, $category);
            }
        }

        $params = array(
            'event_category'  => 'ecommerce',
            'currency'        => get_woocommerce_currency(),
        );
        $params['items'] = $items;

        if ( PYS()->getOption( 'woo_view_content_value_enabled' ) ) {
            $value_option = PYS()->getOption( 'woo_view_content_value_option' );
            $global_value = PYS()->getOption( 'woo_view_content_value_global', 0 );
            $params['value']    = getWooEventValue( $value_option, $global_value,100, $product->get_id() ,$quantity);
        }


        return array(
            'name'  => 'view_item',
            'data'  => $params,
            'delay' => (int) PYS()->getOption( 'woo_view_content_delay' ),
        );

    }
    private function getWooViewCartEventParams(&$event){
        if ( ! $this->getOption( 'woo_view_cart_enabled' ) ) {
            return false;
        }
        $data = ['name'  => 'view_cart'];
        $payload = $event->payload;
        $params = $this->getWooEventViewCartParams( $event );
        $event->addParams($params);
        $event->addPayload($data);
        return true;
    }
    private function getWooEventViewCartParams($event){
        $params = [
            'event_category' => 'ecommerce',
        ];
        $params['currency'] = get_woocommerce_currency();
        $items = array();
        $product_ids = array();
        $withTax = 'incl' === get_option( 'woocommerce_tax_display_cart' );
        if(WC()->cart->get_cart())
        {
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

                $product = wc_get_product(!empty($cart_item['variation_id'] && !GTM()->getOption('woo_variable_as_simple')) ? $cart_item['variation_id'] : $cart_item['product_id']);

                if ($product) {

                    $product_data = $product->get_data();
                    $product_id = Helpers\getWooCartItemId( $cart_item );
                    $content_id = Helpers\getWooProductContentId($product_id);
                    $price = $cart_item['line_subtotal'];


                    if ($withTax) {
                        $price += $cart_item['line_subtotal_tax'];
                    }
                    $item = array(
                        'item_id'       => $content_id,
                        'item_name'     => GTM()->getOption('woo_variations_use_parent_name') && $product->is_type('variation') ? $product->get_title() : $product->get_name(),
                        'quantity' => $cart_item['quantity'],
                        'price'    => $cart_item['quantity'] > 0 ? pys_round($price / $cart_item['quantity']) : $price,
                    );
                    $category = $this->getCategoryArrayWoo($product_id, $product->is_type('variation'));
                    if (!empty($category)) {
                        $item = array_merge($item, $category);
                    }
                    if ($product && $product->is_type('variation')) {
                        foreach ($event->args['products'] as $event_product){
                            if($event_product['product_id'] == $product_id && !empty($event_product['variation_name']))
                            {
                                $item['variant'] = $event_product['variation_name'];
                            }

                        }
                    }

                    $items[] = $item;
                    $product_ids[] = $item['item_id'];
                }
            }
        }
        $params['items'] = $items;
        $params['currency'] =  get_woocommerce_currency();
        $params['value'] = getWooEventCartTotal($event);

        return $params;
    }
    private function getWooAddToCartOnButtonClickEventParams( $args ) {

        if ( ! $this->getOption( 'woo_add_to_cart_enabled' )  || ! PYS()->getOption( 'woo_add_to_cart_on_button_click' ) ) {
            return false;
        }
        $customProductPrice = -1;
        $product_id = $args->args['productId'];
        $quantity = $args->args['quantity'];

        $product = wc_get_product( $product_id );
        if(!$product) return false;

        $product_ids = array();
        $items = array();

        $isGrouped = $product->get_type() == "grouped";
        if($isGrouped) {
            $product_ids = $product->get_children();
        } else {
            $product_ids[] = $product_id;
        }

        foreach ($product_ids as $child_id) {
            $childProduct = wc_get_product($child_id);
            if($childProduct || ($childProduct->get_type() == "variable" && $isGrouped)) {
                continue;
            }
            $content_id = Helpers\getWooProductContentId($child_id);
            $price = getWooProductPriceToDisplay( $child_id, $quantity );
            $name = GTM()->getOption('woo_variations_use_parent_name') && $childProduct->is_type('variation') ? $childProduct->get_title() : $childProduct->get_name();


            if ( $childProduct->get_type() == 'variation' ) {
                $variation_name = !GTM()->getOption('woo_variations_use_parent_name') ? implode("/", $childProduct->get_variation_attributes()) : $product->get_title();
                $categories = $this->getCategoryArrayWoo($child_id, true);
            } else {
                $categories = $this->getCategoryArrayWoo($child_id);
                $variation_name = null;
            }
            $item = array(
                'item_id'       => $content_id,
                'item_name'     => $name,
                'quantity' => $quantity,
                'price'    => $price,
                'variant'  => $variation_name,
            );
            if (!empty($categories)) {
                $item = array_merge($item, $categories);
            }

            $items[] = $item;
        }



        $params = array(
            'event_category'  => 'ecommerce',
            'currency'        => get_woocommerce_currency(),
            'items'           => $items,
        );

        if ( PYS()->getOption( 'woo_add_to_cart_value_enabled' ) ) {
            $value_option = PYS()->getOption( 'woo_add_to_cart_value_option' );
            $global_value = PYS()->getOption( 'woo_add_to_cart_value_global', 0 );

            $params['value']    = getWooEventValue( $value_option, $global_value,100, $product_id,$quantity );
        }

        $data = array(
            'params'  => $params,
        );

        if($product->get_type() == 'grouped') {
            $grouped = array();
            foreach ($product->get_children() as $childId) {
                $grouped[$childId] = array(
                    'content_id' => Helpers\getWooProductContentId( $childId ),
                    'price' => getWooProductPriceToDisplay( $childId )
                );
            }
            $data['grouped'] = $grouped;
        }

        return $data;

    }

    private function getWooAddToCartOnCartEventParams() {

        if ( ! $this->getOption( 'woo_add_to_cart_enabled' ) ) {
            return false;
        }

        $params = $this->getWooCartParams();

        return array(
            'name' => 'add_to_cart',
            'data' => $params
        );

    }

    /**
     * @param SingleEvent $event
     * @return bool
     */
    private function getWooRemoveFromCartParams( $event ) {

        if ( ! $this->getOption( 'woo_remove_from_cart_enabled' ) ) {
            return false;
        }
        $cart_item = $event->args['item'];
        $product_id = $cart_item['product_id'];

        $product = wc_get_product( $product_id );
        if(!$product) return false;

        $name = $product->get_title();


        if ( ! empty( $cart_item['variation_id'] ) ) {
            $variation = wc_get_product( $cart_item['variation_id'] );
            if($variation && $variation->get_type() == 'variation'  && !GTM()->getOption( 'woo_variable_as_simple' )) {
                $variation_name = !GTM()->getOption('woo_variations_use_parent_name') ? implode("/", $variation->get_variation_attributes()) : $product->get_title();
                $categories = $this->getCategoryArrayWoo($product_id, true);
            } else {
                $variation_name = null;
                $categories = $this->getCategoryArrayWoo($product_id);
            }
        } else {
            $variation_name = null;
            $categories = $this->getCategoryArrayWoo($product_id);
        }

        $data = [
            'name' => "remove_from_cart"
        ];
        $params = [
            'event_category'  => 'ecommerce',
            'currency'        => get_woocommerce_currency(),
            'items'           => array(
                array(
                    'item_id'       => $product_id,
                    'item_name'     => $name,
                    'quantity' => $cart_item['quantity'],
                    'price'    => getWooProductPriceToDisplay( $product_id, $cart_item['quantity'] ),
                    'variant'  => $variation_name,
                ),
            )];

        if(!empty($categories))
        {
            $params['items'][0] = array_merge($params['items'][0], $categories);
        }

        $event->addParams($params);
        $event->addPayload($data);

        return true;
    }

    private function getWooInitiateCheckoutEventParams() {

        if ( ! $this->getOption( 'woo_initiate_checkout_enabled' ) ) {
            return false;
        }

        $params = $this->getWooCartParams('InitiateCheckout');

        return array(
            'name'  => 'begin_checkout',
            'data'  => $params
        );

    }

    private function getWooPurchaseEventParams() {
        global $wp;
        if ( ! $this->getOption( 'woo_purchase_enabled' ) ) {
            return false;
        }
        $key = sanitize_key($_REQUEST['key']);
        $cache_key = 'order_id_' . $key;
        $order_id = get_transient( $cache_key );
        if (PYS()->woo_is_order_received_page() && empty($order_id) && $wp->query_vars['order-received']) {

            $order_id = absint( $wp->query_vars['order-received'] );
            if ($order_id) {
                set_transient( $cache_key, $order_id, HOUR_IN_SECONDS );
            }
        }
        if ( empty($order_id) ) {
            $order_id = (int) wc_get_order_id_by_order_key( $key );
            set_transient( $cache_key, $order_id, HOUR_IN_SECONDS );
        }

        $order    = wc_get_order( $order_id );
        if(!$order) return false;
        $items = array();
        $product_ids = array();
        $total_value = 0;

        foreach ( $order->get_items( 'line_item' ) as $line_item ) {

            $product_id = Helpers\getWooCartItemId( $line_item );
            $content_id = Helpers\getWooProductContentId( $product_id );

            $product = wc_get_product( $product_id );
            if ($product && GTM()->getOption('woo_variable_as_simple') && $product->is_type('variation')) {
                $product = wc_get_product($product->get_parent_id());
            }
            if(!$product) continue;
            $name = GTM()->getOption('woo_variations_use_parent_name') && $product->is_type('variation') ? $product->get_title() : $product->get_name();



            if ( $line_item['variation_id'] ) {
                $variation = wc_get_product( $line_item['variation_id'] );
                if($variation && $variation->get_type() == 'variation' && !GTM()->getOption( 'woo_variable_as_simple' )) {

                    $variation_name = !GTM()->getOption('woo_variations_use_parent_name') ? implode("/", $variation->get_variation_attributes()) : $product->get_title();
                    $categories = $this->getCategoryArrayWoo($product_id, true);
                } else {
                    $variation_name = null;
                    $categories = $this->getCategoryArrayWoo($product_id);
                }
            } else {
                $variation_name = null;
                $categories = $this->getCategoryArrayWoo($product_id);
            }

            /**
             * Discounted price used instead of price as is on Purchase event only to avoid wrong numbers in
             * Analytic's Product Performance report.
             */
            if ( isWooCommerceVersionGte( '3.0' ) ) {
                $price = pys_round($line_item['total'] + $line_item['total_tax']);
            } else {
                $price = pys_round($line_item['line_total'] + $line_item['line_tax']);
            }

            $qty = $line_item['qty'];
            $price = $price / $qty;

            if ( isWooCommerceVersionGte( '3.0' ) ) {

                if ( 'yes' === get_option( 'woocommerce_prices_include_tax' ) ) {
                    $price = wc_get_price_including_tax( $product, array( 'qty' => 1, 'price' => $price ) );
                } else {
                    $price = wc_get_price_excluding_tax( $product, array( 'qty' => 1, 'price' => $price ) );
                }

            } else {

                if ( 'yes' === get_option( 'woocommerce_prices_include_tax' ) ) {
                    $price = $product->get_price_including_tax( 1, $price );
                } else {
                    $price = $product->get_price_excluding_tax( 1, $price );
                }

            }

            $item = array(
                'item_id'       => $content_id,
                'item_name'     => $name,
                'quantity' => $qty,
                'price'    => $price,
                'variant'  => $variation_name,
            );
            if (!empty($categories)) {
                $item = array_merge($item, $categories);
            }
            $items[] = $item;
            $product_ids[] = $item['item_id'];
            $total_value   += $item['price' ];

        }

        $params = array(
            'event_category'  => 'ecommerce',
            'transaction_id'  => $order_id,
            'currency'        => get_woocommerce_currency(),
            'items'           => $items,
        );

        $value_option = PYS()->getOption( 'woo_purchase_value_option' );
        $global_value = PYS()->getOption( 'woo_purchase_value_global', 0 );

        $params['value'] = getWooEventValueOrder( $value_option, $order, $global_value );

        $params['fees'] = get_fees($order);
        if(PYS()->getOption('enable_CwCD')) {
            if(!empty(PYS()->getOption('aw_merchant_id'))){
                $params['aw_merchant_id'] = PYS()->getOption('aw_merchant_id');
            }
            if(!empty(PYS()->getOption('aw_feed_label'))){
                $params['aw_feed_label'] = PYS()->getOption('aw_feed_label');
            }
            if(!empty(PYS()->getOption('aw_feed_country'))){
                $params['aw_feed_country'] = PYS()->getOption('aw_feed_country');
            }
            if(!empty(PYS()->getOption('aw_feed_language'))){
                $params['aw_feed_language'] = PYS()->getOption('aw_feed_language');
            }
        }
        return array(
            'name' => 'purchase',
            'data' => $params
        );

    }

    private function getWooCartParams($context = 'cart') {

        $items = array();
        $product_ids = array();
        $total_value = 0;

        foreach ( WC()->cart->cart_contents as $cart_item_key => $cart_item ) {

            $product_id = Helpers\getWooCartItemId( $cart_item );
            $content_id = Helpers\getWooProductContentId( $product_id );

            $product = wc_get_product( $product_id );
            if(!$product) continue;

            $name = GTM()->getOption('woo_variations_use_parent_name') && $product->is_type('variation') ? $product->get_title() : $product->get_name();


            if ( $cart_item['variation_id'] ) {
                $variation = wc_get_product( $cart_item['variation_id'] );
                if($variation && $variation->get_type() == 'variation' && !GTM()->getOption( 'woo_variable_as_simple' )) {
                    $variation_name = !GTM()->getOption('woo_variations_use_parent_name') ? implode("/", $variation->get_variation_attributes()) : $product->get_title();
                    $categories = $this->getCategoryArrayWoo($product_id, true);
                } else {

                    $variation_name = null;
                    $categories = $this->getCategoryArrayWoo($product_id);
                }
            } else {

                $variation_name = null;
                $categories = $this->getCategoryArrayWoo($product_id);
            }

            $item = array(
                'item_id'       => $content_id,
                'item_name'     => $name,
                'quantity' => $cart_item['quantity'],
                'price'    => getWooProductPriceToDisplay( $product_id ),
                'variant'  => $variation_name,
            );

            if (!empty($categories)) {
                $item = array_merge($item, $categories);
            }
            $items[] = $item;
            $product_ids[] = $item['item_id'];
            $total_value += $item['price'] * $cart_item['quantity'];

        }

        $params = array(
            'event_category' => 'ecommerce',
            'currency'        => get_woocommerce_currency(),
            'items' => $items,
        );
        if ( $context == 'InitiateCheckout' ) {

            $value_enabled_option = 'woo_initiate_checkout_value_enabled';
            $value_option_option  = 'woo_initiate_checkout_value_option';
            $value_global_option  = 'woo_initiate_checkout_value_global';

        } else { // AddToCart

            $value_enabled_option = 'woo_add_to_cart_value_enabled';
            $value_option_option  = 'woo_add_to_cart_value_option';
            $value_global_option  = 'woo_add_to_cart_value_global';

        }
        if ( PYS()->getOption( $value_enabled_option ) ) {

            $value_option = PYS()->getOption( $value_option_option );
            $global_value = PYS()->getOption( $value_global_option, 0 );

            $params['value']    = getWooEventValueCart( $value_option, $global_value );

        }

        return $params;

    }

    private function getEddViewContentEventParams() {
        global $post;

        if ( ! $this->getOption( 'edd_view_content_enabled' ) ) {
            return false;
        }

        $params = array(
            'event_category'  => 'ecommerce',
            'currency' => edd_get_currency(),
            'items'           => array(
                array(
                    'item_id'       => $post->ID,
                    'item_name'     => $post->post_title,
                    'category' => implode( '/', getObjectTerms( 'download_category', $post->ID ) ),
                    'quantity' => 1,
                    'price'    => getEddDownloadPriceToDisplay( $post->ID ),
                ),
            ),
        );
        if ( PYS()->getOption( 'edd_view_content_value_enabled' ) ) {

            $amount = getEddDownloadPriceToDisplay( $post->ID );
            $value_option   = PYS()->getOption( 'edd_view_content_value_option' );
            $global_value   = PYS()->getOption( 'edd_view_content_value_global', 0 );

            $params['value'] = getEddEventValue( $value_option, $amount, $global_value );

        }
        return array(
            'name'  => 'view_item',
            'data'  => $params,
            'delay' => (int) PYS()->getOption( 'edd_view_content_delay' ),
        );

    }

    private function getEddAddToCartOnButtonClickEventParams( $download_id ) {
        // maybe extract download price id
        if ( strpos( $download_id, '_') !== false ) {
            list( $download_id, $price_index ) = explode( '_', $download_id );
        } else {
            $price_index = null;
        }

        $download_post = get_post( $download_id );

        $params = array(
            'event_category'  => 'ecommerce',
            'currency' => edd_get_currency(),
            'items'           => array(
                array(
                    'item_id'       => Helpers\getEddDownloadContentId($download_id),
                    'item_name'     => $download_post->post_title,
                    'category' => implode( '/', getObjectTerms( 'download_category', $download_id ) ),
                    'quantity' => 1,
                    'price'    => getEddDownloadPriceToDisplay( $download_id, $price_index ),
                ),
            ),
        );

        if ( PYS()->getOption( 'edd_add_to_cart_value_enabled' ) ) {

            $amount = getEddDownloadPriceToDisplay( $download_id, $price_index );
            $value_option = PYS()->getOption( 'edd_add_to_cart_value_option' );
            $global_value = PYS()->getOption( 'edd_add_to_cart_value_global', 0 );

            $params['value'] = getEddEventValue( $value_option, $amount, $global_value );

        }

        return $params;

    }

    private function getEddCartEventParams( $context = 'add_to_cart' ) {

        if ( $context == 'add_to_cart' && ! $this->getOption( 'edd_add_to_cart_enabled' ) ) {
            return false;
        } elseif ( $context == 'begin_checkout' && ! $this->getOption( 'edd_initiate_checkout_enabled' ) ) {
            return false;
        } elseif ( $context == 'purchase' && ! $this->getOption( 'edd_purchase_enabled' ) ) {
            return false;
        }

        if ( $context == 'add_to_cart' ) {
            $value_enabled  = PYS()->getOption( 'edd_add_to_cart_value_enabled' );
            $value_option   = PYS()->getOption( 'edd_add_to_cart_value_option' );
            $global_value   = PYS()->getOption( 'edd_add_to_cart_value_global', 0 );
        } elseif ( $context == 'begin_checkout' ) {
            $value_enabled  = PYS()->getOption( 'edd_initiate_checkout_value_enabled' );
            $value_option   = PYS()->getOption( 'edd_initiate_checkout_value_option' );
            $global_value   = PYS()->getOption( 'edd_initiate_checkout_global', 0 );
        } else {
            $value_enabled  = PYS()->getOption( 'edd_purchase_value_enabled' );
            $value_option   = PYS()->getOption( 'edd_purchase_value_option' );
            $global_value   = PYS()->getOption( 'edd_purchase_value_global', 0 );
        }

        if ( $context == 'add_to_cart' || $context == 'begin_checkout' ) {
            $cart = edd_get_cart_contents();
        } else {
            $cart = edd_get_payment_meta_cart_details( edd_get_purchase_id_by_key( getEddPaymentKey() ), true );
        }

        $items = array();
        $product_ids = array();
        $total_value = 0;

        foreach ( $cart as $cart_item_key => $cart_item ) {

            $download_id   = (int) $cart_item['id'];
            $download_post = get_post( $download_id );

            if ( in_array( $context, array( 'purchase', 'FrequentShopper', 'VipClient', 'BigWhale' ) ) ) {
                $item_options = $cart_item['item_number']['options'];
            } else {
                $item_options = $cart_item['options'];
            }

            if ( ! empty( $item_options ) && !empty($item_options['price_id'])) {
                $price_index = $item_options['price_id'];
            } else {
                $price_index = null;
            }

            /**
             * Price as is used for all events except Purchase to avoid wrong values in Product Performance report.
             */
            if ( $context == 'purchase' ) {
                if(!isset($cart_item['item_price']) || !isset($cart_item['discount']) || !isset($cart_item['tax'])) {
                    $price = getEddDownloadPriceToDisplay( $download_id, $price_index );
                } else {
                    $price = $cart_item['item_price'] - $cart_item['discount'];

                    if ( edd_prices_include_tax() ) {
                        $price -= $cart_item['tax'];
                    } else {
                        $price += $cart_item['tax'];
                    }
                }
            } else {
                $price = getEddDownloadPriceToDisplay( $download_id, $price_index );
            }

            $item = array(
                'item_id'       => Helpers\getEddDownloadContentId($download_id),
                'item_name'     => $download_post->post_title,
                'category' => implode( '/', getObjectTerms( 'download_category', $download_id ) ),
                'quantity' => $cart_item['quantity'],
                'price'    => $price
//				'variant'  => $variation_name,
            );

            $items[] = $item;
            $product_ids[] = (int) $cart_item['id'];
            $total_value += $price;

        }

        $params = array(
            'event_category' => 'ecommerce',
            'currency' => edd_get_currency(),
            'items' => $items,
        );


        if ( $context == 'purchase' ) {

            $payment_key = getEddPaymentKey();
            $payment_id = (int) edd_get_purchase_id_by_key( $payment_key );

            $params['transaction_id'] = $payment_id;
            $params['currency'] = edd_get_currency();

        }

        if ( $value_enabled ) {
            $amount = edd_get_payment_amount( $payment_id );
            $params['value']    = getEddEventValue( $value_option, $amount, $global_value );
        }

        return array(
            'name' => $context,
            'data' => $params,
        );

    }

    private function getEddRemoveFromCartParams( $cart_item ) {

        if ( ! $this->getOption( 'edd_remove_from_cart_enabled' ) ) {
            return false;
        }

        $download_id = $cart_item['id'];
        $download_post = get_post( $download_id );

        $price_index = ! empty( $cart_item['options'] ) ? $cart_item['options']['price_id'] : null;

        return array(
            'name' => 'remove_from_cart',
            'data' => array(
                'event_category'  => 'ecommerce',
                'currency'        => edd_get_currency(),
                'items'           => array(
                    array(
                        'item_id'       => Helpers\getEddDownloadContentId($download_id),
                        'item_name'     => $download_post->post_title,
                        'category' => implode( '/', getObjectTerms( 'download_category', $download_id ) ),
                        'quantity' => $cart_item['quantity'],
                        'price'    => getEddDownloadPriceToDisplay( $download_id, $price_index ),
//						'variant'  => $variation_name,
                    ),
                ),
            ),
        );

    }

    private function getEddViewCategoryEventParams() {
        global $posts;

        if ( ! $this->getOption( 'edd_view_category_enabled' ) ) {
            return false;
        }

        $term = get_term_by( 'slug', get_query_var( 'term' ), 'download_category' );
        if ( !$term ) return false;
        $parent_ids = get_ancestors( $term->term_id, 'download_category', 'taxonomy' );

        $download_categories = array();
        $download_categories[] = $term->name;

        foreach ( $parent_ids as $term_id ) {
            $parent_term = get_term_by( 'id', $term_id, 'download_category' );
            $download_categories[] = $parent_term->name;
        }

        $list_name = implode( '/', array_reverse( $download_categories ) );

        $items = array();
        $product_ids = array();
        $total_value = 0;

        for ( $i = 0; $i < count( $posts ); $i ++ ) {

            $item = array(
                'item_id'            => Helpers\getEddDownloadContentId($posts[ $i ]->ID),
                'item_name'          => $posts[ $i ]->post_title,
                'category'      => implode( '/', getObjectTerms( 'download_category', $posts[ $i ]->ID ) ),
                'quantity'      => 1,
                'price'         => getEddDownloadPriceToDisplay( $posts[ $i ]->ID ),
                'list_position' => $i + 1,
                'list'          => $list_name,
            );

            $items[] = $item;
            $product_ids[] = $item['item_id'];
            $total_value += $item['price'];

        }

        $params = array(
            'event_category'  => 'ecommerce',
            'event_label'     => $list_name,
            'currency' => edd_get_currency(),
            'items'           => $items,
        );
        $params['value'] = $total_value;
        return array(
            'name'  => 'view_item_list',
            'data'  => $params,
        );

    }



    private function getCategoryArrayWoo($contentID, $isVariant = false)
    {
        $category_array = array();

        if ($isVariant) {
            $parent_product_id = wp_get_post_parent_id($contentID);
            $category = getObjectTerms('product_cat', $parent_product_id);
        } else {
            $category = getObjectTerms('product_cat', $contentID);
        }

        $category_index = 1;

        foreach ($category as $cat) {
            if ($category_index >= 6) {
                break; // Stop the loop if the maximum limit of 5 categories is exceeded
            }
            $category_array['item_category' . ($category_index > 1 ? $category_index : '')] = $cat;
            $category_index++;
        }
        return $category_array;
    }

    public function getAllPixels($checkLang = true) {
        $pixels = $this->getPixelIDs();


        $pixels = array_filter($pixels, static function ($tag) {
            return preg_match( '/^GTM-[A-Z0-9]+$/', $tag );
        });

        $pixels = array_values($pixels);
        return $pixels;
    }

    private function isGTM($tag) {
        return preg_match( '/^GTM-[A-Z0-9]+$/', $tag );
    }
    /**
     * @param PYSEvent $event
     * @return array|mixed|void
     */
    public function getAllPixelsForEvent($event) {
        $pixels = array();

        if ( $this->getOption( 'main_pixel_enabled' ) ) {
            $main_pixel = $this->getPixelIDs();
            $main_pixel = array_filter( $main_pixel, static function ( $tag ) {
                return preg_match( '/^GTM-[A-Z0-9]+$/', $tag );
            } );
            $pixels = array_merge( $pixels, $main_pixel );
        }
        return $pixels;
    }
}

/**
 * @return GA
 */
function GTM() {
    return GTM::instance();
}

GTM();