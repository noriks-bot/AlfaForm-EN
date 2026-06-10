<?php

namespace PixelYourSite;

use Behat\Transliterator\Transliterator;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @property int    post_id
 * @property string title
 * @property bool   enabled
 * @property int    delay
 * @property array  triggers
 * @property string trigger_type
 * @property bool   facebook_enabled
 * @property string facebook_event_type
 * @property string facebook_custom_event_type
 * @property bool   facebook_params_enabled
 * @property array  facebook_params
 * @property array  facebook_custom_params
 * @property bool   pinterest_enabled
 * @property string pinterest_event_type
 * @property string pinterest_custom_event_type
 * @property bool   pinterest_params_enabled
 * @property array  pinterest_params
 * @property array  pinterest_custom_params
 * @property array  ga_custom_params
 * @property array  ga_params
 * @property bool   ga_enabled
 * @property string ga_event_action
 * @property string ga_custom_event_action
 * @property string ga_event_category
 * @property string ga_event_label
 * @property string ga_event_value
 * @property bool ga_ads_enabled
 * @property string ga_ads_pixel_id
 * @property string ga_ads_event_action
 * @property string ga_ads_custom_event_action
 * @property array ga_ads_custom_params
 * @property array ga_ads_params
 * @property string ga_ads_version
 * @property string ga_ads_event_category
 * @property string ga_ads_event_label
 * @property bool gtm_enabled
 * @property string gtm_pixel_id
 * @property string gtm_event_action
 * @property string gtm_custom_event_action
 * @property array gtm_custom_params
 * @property array gtm_params
 * @property string gtm_version
 * @property string gtm_conversion_label
 * @property string gtm_event_category
 * @property string gtm_event_label
 * @property bool gtm_automated_param
 * @property bool gtm_remove_customTrigger
 * @property bool gtm_use_custom_object_name
 * @property string gtm_custom_object_name
 *
 * @property bool   bing_enabled
 * @property string bing_pixel_id
 * @property string bing_event_type
 * @property string bing_custom_event_type
 * @property bool   bing_params_enabled
 * @property array  bing_params
 * @property bool reddit_enabled
 * @property string reddit_event_action
 * @property bool reddit_track_single_woo_data
 * @property bool reddit_track_cart_woo_data
 * @property string reddit_pixel_id
 * @property string reddit_event_type
 * @property bool reddit_params_enabled
 */
class CustomEvent {

	private $post_id;

	private $title = 'Untitled';

	private $enabled = true;

    public static $redditEvents = [
        'ViewContent'   => [],
        'Search'        => [],
        'AddToCart'     => [
            [ 'type' => 'input', 'label' => 'itemCount', 'name' => 'pys[event][reddit_params][itemCount]' ],
            [ 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]' ],
            [ 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]' ],
        ],
        'AddToWishlist' => [
            [ 'type' => 'input', 'label' => 'itemCount', 'name' => 'pys[event][reddit_params][itemCount]' ],
            [ 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]' ],
            [ 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]' ],
        ],
        'Purchase'      => [
            [ 'type' => 'input', 'label' => 'itemCount', 'name' => 'pys[event][reddit_params][itemCount]' ],
            [ 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]' ],
            [ 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]' ],
        ],
        'Lead'          => [
            [ 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]' ],
            [ 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]' ],
        ],
        'SignUp'        => [
            [ 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]' ],
            [ 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]' ],
        ],
        'Custom'        => [
            [ 'type' => 'input', 'label' => 'itemCount', 'name' => 'pys[event][reddit_params][itemCount]' ],
            [ 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]' ],
            [ 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]' ],
        ],
    ];
    private $ecommerceParamArray = array(
        'currency',
        'value',
        'items',
        'tax',
        'shipping',
        'coupon',
        'affiliation',
        'transaction_id',
        'total_value',
        'ecomm_prodid',
        'ecomm_pagetype',
        'ecomm_totalvalue'
    );

    private $ecommerceEventNames = array(
        'add_payment_info',
        'add_shipping_info',
        'add_to_cart',
        'add_to_wishlist',
        'begin_checkout',
        'generate_lead',
        'purchase',
        'refund',
        'remove_from_cart',
        'select_item',
        'select_promotion',
        'view_cart',
        'view_item',
        'view_item_list',
        'view_promotion'
    );
    private $triggers = array();
    private $conditions = array();
    private $triggerEventTypes = array();
	private $data = array(
		'delay'        => null,
		'trigger_type' => 'page_visit',
		'triggers'     => array(),
		
		'facebook_enabled'           => false,
		'facebook_event_type'        => 'ViewContent',
		'facebook_custom_event_type' => null,
		'facebook_params_enabled'    => false,
		'facebook_params'            => array(),
		'facebook_custom_params'     => array(),
		
		'pinterest_enabled'           => false,
		'pinterest_event_type'        => 'pagevisit',
		'pinterest_custom_event_type' => null,
		'pinterest_params_enabled'    => false,
        'pinterest_params'            => array(),
		'pinterest_custom_params'     => array(),
		
		'ga_enabled'             => false,
		'ga_event_action'        => 'conversion',
		'ga_custom_event_action' => null,
		'ga_event_category'      => null,
		'ga_event_label'         => null,
		'ga_event_value'         => null,

        //ver 4
        'ga_params'             => array(),
        'ga_custom_params'      => array(),
        'ga_custom_params_enabled'    => false,

        'ga_ads_enabled'             => false,
        'ga_ads_event_action'        => 'conversion',
        'ga_ads_custom_event_action' => null,
        //ver 4
        'ga_ads_params'             => array(),
        'ga_ads_custom_params'      => array(),
        'ga_ads_custom_params_enabled'    => false,

        'gtm_enabled'             => false,
        'gtm_pixel_id'            => array(),
        'gtm_event_action'        => 'conversion',
        'gtm_custom_event_action' => null,
        //ver 4
        'gtm_params'             => array(),
        'gtm_custom_params'      => array(),
        'gtm_custom_params_enabled'    => false,
        'gtm_conversion_label'    => null,
        'gtm_automated_param'   => true,
        'gtm_remove_customTrigger' => false,
        'gtm_use_custom_object_name' => false,
        'gtm_custom_object_name' => null,

        'bing_enabled' => false,
        'bing_pixel_id' => 'all',
        'bing_event_type' => 'PageVisit',
        'bing_custom_event_type' => null,
        'bing_params_enabled' => false,
        'bing_params' => array(),

		'reddit_pixel_id'              => 'all',
		'reddit_event_type'            => 'ViewContent',
		'reddit_enabled'               => false,
		'reddit_track_single_woo_data' => false,
		'reddit_track_cart_woo_data'   => false,

        'conditions_enabled' => false,
        'conditions_logic' => 'AND'
	);

	public function __construct( $post_id = null ) {
		$this->initialize( $post_id );
	}

	public function __get( $key ) {

        if ( isset( $this->$key) ) {
            return $this->$key;
        }

        if ( isset( $this->data[ $key ] ) ) {
            return $this->data[ $key ];
        } else {
            return null;
        }

	}
    public function __set( $key, $value ) {
        if ( $key == 'triggerEventTypes' ) {
            $this->triggerEventTypes = $value;
        }
    }

	private function initialize( $post_id ) {

		if ( $post_id ) {

			$this->post_id = $post_id;
			$this->title   = get_the_title( $post_id );

            $data = get_post_meta( $post_id, '_pys_event_data', true );
            $triggers = get_post_meta( $post_id, '_pys_event_triggers', true );
            $conditions = get_post_meta( $post_id, '_pys_event_conditions', true );

            if ( $conditions !== '' ) {
                $this->conditions = !empty( $conditions ) ? unserialize( $conditions ) : array();
            }
            if ( $triggers !== '' && is_string( $triggers ) ) {
                $this->triggers = !empty( $triggers ) ? unserialize( $triggers ) : array();
            } elseif ( !empty( $data ) && isset( $data[ 'trigger_type' ] )) {
                $trigger_type = $data[ 'trigger_type' ];
                $trigger_event = new TriggerEvent( $trigger_type, 0 );
                if ( in_array( $trigger_type, TriggerEvent::$allowedTriggers ) ) {
                    $trigger_event->migrateTriggerData( $trigger_type, $data );
                    $this->triggers = array( $trigger_event );
                } else {
                    $this->triggers = array();
                }
            }elseif ( !empty( $triggers ) ) {
                foreach ( $triggers as $trigger ) {
                    if ($trigger instanceof TriggerEvent) {
                        $this->triggers[] = $trigger;
                    }
                }
            }

            $this->data = is_array( $data ) ? $data+$this->data : $this->data;


            $state = get_post_meta( $post_id, '_pys_event_state', true );
			$this->enabled = $state == 'active' ? true : false;

		}
        else{
            if(empty($this->data['gtm_pixel_id'])) {
                $all = GTM()->getPixelIDs();
                if(count($all) > 0) {
                    $this->data['gtm_pixel_id'] = $all[0];
                }
            }
        }

	}

	public function update( $args = null ) {

		if ( ! is_array( $args ) ) {
			$args = $this->data;
		}
		/**
		 * GENERAL
		 */

		// title
		wp_update_post( array(
			'ID'         => $this->post_id,
			'post_title' => empty( $args['title'] ) ? $this->title : sanitize_text_field( $args['title'] )
		) );

		// state
		$state = isset( $args['enabled'] ) && $args['enabled'] ? 'active' : 'paused';
		$this->enabled = $state == 'active' ? true : false;
		update_post_meta( $this->post_id, '_pys_event_state', $state );

        $this->data[ 'conditions_enabled' ] = isset( $args[ 'conditions_enabled' ] ) ? (bool) $args[ 'conditions_enabled' ] : false;
        $this->data[ 'conditions_logic' ] = isset( $args[ 'conditions_logic' ] ) ? $args[ 'conditions_logic' ] : 'AND';


        $trigger_types = array(
            'page_visit',
            'home_page',
            'scroll_pos',
            'post_type',
        );

        $this->triggers = array();
        $index = 0;

        $this->conditions = array();
        $condition_index = 0;
		// trigger type
        $old_data = array(
            'conditional_number_visit',
            'number_visit',
            'triggers',
            'post_type_value',
            'video_view_data',
            'video_view_urls',
            'video_view_triggers',
            'video_view_play_trigger',
            'video_view_disable_watch_video',
            'disabled_form_action',
            'forms',
            'delay',
            'url_filters'
        );
        foreach ( $old_data as $datum ) {
            if ( isset( $this->data[ $datum ] ) ) {
                unset( $this->data[ $datum ] );
            }
        }


        if ( !empty( $args[ 'triggers' ] ) ) {

            foreach ( $args[ 'triggers' ] as $data_trigger ) {

                if ( isset( $data_trigger[ 'cloned_event' ] ) ) {
                    continue;
                }

                $saving_trigger = false;
                // trigger type
                $trigger_type = isset( $data_trigger[ 'trigger_type' ] ) && in_array( $data_trigger[ 'trigger_type' ], $trigger_types ) ? sanitize_text_field( $data_trigger[ 'trigger_type' ] ) : 'page_visit';

                $trigger = new TriggerEvent( $trigger_type );
                // delay
                $delay = ( $trigger_type == 'page_visit' || $trigger_type == 'post_type' || $trigger_type == 'home_page' ) && isset( $data_trigger[ 'delay' ] ) && $data_trigger[ 'delay' ] ? (int) sanitize_text_field( $data_trigger[ 'delay' ] ) : null;
                $trigger->updateParam( 'delay', $delay );

                $post_type_value = $trigger_type == 'post_type' && isset( $data_trigger[ 'post_type_value' ] ) && $data_trigger[ 'post_type_value' ] ? sanitize_text_field( $data_trigger[ 'post_type_value' ] ) : null;
                $trigger->updateParam( 'post_type_value', $post_type_value );

                if ( $trigger_type === 'home_page' || $trigger_type === 'post_type' ) {
                    $saving_trigger = true;
                }

                /**
                 * TRIGGERS
                 */
                $event_triggers = array();

                // page visit triggers
                if ( $trigger_type == 'page_visit' && isset( $data_trigger[ 'page_visit_triggers' ] ) && is_array( $data_trigger[ 'page_visit_triggers' ] ) ) {

                    foreach ( $data_trigger[ 'page_visit_triggers' ] as $page_visit_trigger ) {
                        if ( !empty( $page_visit_trigger[ 'value' ] ) ) {
                            $event_triggers[] = array(
                                'rule'  => sanitize_text_field( $page_visit_trigger[ 'rule' ] ),
                                'value' => sanitize_text_field( $page_visit_trigger[ 'value' ] ),
                            );
                        }
                    }
                }
                // scroll pos triggers
                if ( $trigger_type == 'scroll_pos' && isset( $data_trigger[ 'scroll_pos_triggers' ] ) && is_array( $data_trigger[ 'scroll_pos_triggers' ] ) ) {

                    foreach ( $data_trigger[ 'scroll_pos_triggers' ] as $scroll_pos_trigger ) {


                        if ( !empty( $scroll_pos_trigger[ 'value' ] ) ) {
                            $event_triggers[] = array(
                                'rule'  => null,
                                'value' => (int) sanitize_text_field( $scroll_pos_trigger[ 'value' ] ),
                            );
                        }
                    }
                }
                if ( !empty( $event_triggers ) || $saving_trigger ) {
                    $trigger->updateParam( 'triggers', $event_triggers );
                    $trigger->updateParam( 'index', $index );

                    $this->triggers[] = $trigger;
                    $index++;
                }
            }
        }

        if ( !empty( $args[ 'conditions' ] ) ) {
            foreach ($args['conditions'] as $data_condition) {
                if (isset($data_condition['cloned_event'])) {
                    continue;
                }

                $condition_type = isset( $data_condition[ 'condition_type' ] ) ? sanitize_text_field( $data_condition[ 'condition_type' ] ) : 'url_filters';
                $condition = new ConditionalEvent( $condition_type );
                switch ($condition_type){
                    case 'url_filters' :
                        $condition->updateParam('condition_rule', $data_condition[$condition_type][ 'condition_rule' ]);
                        $condition->updateParam('condition_value', $data_condition[$condition_type][ 'condition_value' ]);
                        break;
                    case 'device' :
                        $condition->updateParam('device', $data_condition[ 'device' ]);
                        break;
                    case 'user_role':
                        $condition->updateParam('user_role', $data_condition[ 'user_role' ]);
                        break;
                }

                $condition->updateParam( 'index', $condition_index );
                $this->conditions[] = $condition;
                $condition_index++;

                break; // Stop after processing the first condition
            }
        }

		/**
		 * REDDIT
		 */
		$this->updateRedditParams( $args );

		/**
		 * FACEBOOK
		 */

		$facebook_event_types = array(
			'ViewContent',
			'AddToCart',
			'AddToWishlist',
			'InitiateCheckout',
			'AddPaymentInfo',
			'Purchase',
			'Lead',
			'CompleteRegistration',
			
			'Subscribe',
			'CustomizeProduct',
			'FindLocation',
			'StartTrial',
			'SubmitApplication',
			'Schedule',
			'Contact',
			'Donate',
			
			'CustomEvent'
		);

		// enabled
		$this->data['facebook_enabled'] = isset( $args['facebook_enabled'] ) && $args['facebook_enabled'] ? true : false;

		// event type
		$this->data['facebook_event_type'] = isset( $args['facebook_event_type'] ) && in_array( $args['facebook_event_type'], $facebook_event_types )
			? sanitize_text_field( $args['facebook_event_type'] )
			: 'ViewContent';

		// custom event type
		$this->data['facebook_custom_event_type'] = $this->facebook_event_type == 'CustomEvent' && ! empty( $args['facebook_custom_event_type'] )
			? sanitizeKey( $args['facebook_custom_event_type'] )
			: null;

		// params enabled
		$this->data['facebook_params_enabled'] = isset( $args['facebook_params_enabled'] ) && $args['facebook_params_enabled'] ? true : false;

		// params
		if ( $this->facebook_params_enabled && isset( $args['facebook_params'] ) && $this->facebook_event_type !== 'CustomEvent' ) {

			$this->data['facebook_params'] = array(
				'value'            => ! empty( $args['facebook_params']['value'] ) ? sanitize_text_field( $args['facebook_params']['value'] ) : null,
				'currency'         => ! empty( $args['facebook_params']['currency'] ) ? sanitize_text_field( $args['facebook_params']['currency'] ) : null,
				'content_name'     => ! empty( $args['facebook_params']['content_name'] ) ? sanitize_text_field( $args['facebook_params']['content_name'] ) : null,
				'content_ids'      => ! empty( $args['facebook_params']['content_ids'] ) ? sanitize_text_field( $args['facebook_params']['content_ids'] ) : null,
				'content_type'     => ! empty( $args['facebook_params']['content_type'] ) ? sanitize_text_field( $args['facebook_params']['content_type'] ) : null,
				'content_category' => ! empty( $args['facebook_params']['content_category'] ) ? sanitize_text_field( $args['facebook_params']['content_category'] ) : null,
				'num_items'        => ! empty( $args['facebook_params']['num_items'] ) ? (int) $args['facebook_params']['num_items'] : null,
				'order_id'         => ! empty( $args['facebook_params']['order_id'] ) ? sanitize_text_field( $args['facebook_params']['order_id'] ) : null,
				'search_string'    => ! empty( $args['facebook_params']['search_string'] ) ? sanitize_text_field( $args['facebook_params']['search_string'] ) : null,
				'status'           => ! empty( $args['facebook_params']['status'] ) ? sanitize_text_field( $args['facebook_params']['status'] ) : null,
				'predicted_ltv'    => ! empty( $args['facebook_params']['predicted_ltv'] ) ? sanitize_text_field( $args['facebook_params']['predicted_ltv'] ) : null,
			);

			// custom currency
			if ( $this->data['facebook_params']['currency'] == 'custom' && ! empty( $args['facebook_params']['custom_currency'] )) {
				$this->data['facebook_params']['custom_currency'] = sanitize_text_field( $args['facebook_params']['custom_currency'] );
			} else {
				$this->data['facebook_params']['custom_currency'] = null;
			}

		} else {
			
			$this->data['facebook_params'] = array(
				'value'            => null,
				'currency'         => null,
				'custom_currency'  => null,
				'content_name'     => null,
				'content_ids'      => null,
				'content_type'     => null,
				'content_category' => null,
				'num_items'        => null,
				'order_id'         => null,
				'search_string'    => null,
				'status'           => null,
				'predicted_ltv'    => null,
			);

		}

		// reset old custom params
		$this->data['facebook_custom_params'] = array();

		// custom params
		if ( $this->facebook_params_enabled && isset( $args['facebook_custom_params'] ) ) {

			foreach ( $args['facebook_custom_params'] as $custom_param ) {

				if ( ! empty( $custom_param['name'] ) && ! empty( $custom_param['value'] ) ) {

					$this->data['facebook_custom_params'][] = array(
						'name'  => sanitize_text_field( $custom_param['name'] ),
						'value' => sanitize_text_field( $custom_param['value'] ),
					);

				}

			}

		}

        /**
         * PINTEREST
         */

        $pinterest_events = PYS_Event_Definitions::get_pinterest_events();
        $pinterest_event_types = array_keys( $pinterest_events );

        // enabled
        $this->data[ 'pinterest_enabled' ] = isset( $args[ 'pinterest_enabled' ] ) && $args[ 'pinterest_enabled' ] ? true : false;

        // event type
        $this->data[ 'pinterest_event_type' ] = isset( $args[ 'pinterest_event_type' ] ) && in_array( $args[ 'pinterest_event_type' ], $pinterest_event_types ) ? sanitize_text_field( $args[ 'pinterest_event_type' ] ) : 'pagevisit';

        // custom event type
        $this->data[ 'pinterest_custom_event_type' ] = $this->pinterest_event_type == 'partner_defined' && !empty( $args[ 'pinterest_custom_event_type' ] ) ? sanitizeKey( $args[ 'pinterest_custom_event_type' ] ) : null;

        // params enabled
        $this->data[ 'pinterest_params_enabled' ] = isset( $args[ 'pinterest_params_enabled' ] ) && $args[ 'pinterest_params_enabled' ] ? true : false;

        // pinterest_params - structured params like Facebook/TikTok
        $this->data[ 'pinterest_params' ] = array();
        if ( isset( $args[ 'pinterest_params' ] ) && is_array( $args[ 'pinterest_params' ] ) ) {
            foreach ( $args[ 'pinterest_params' ] as $param_key => $param_value ) {
                $this->data[ 'pinterest_params' ][ sanitize_text_field( $param_key ) ] = sanitize_text_field( $param_value );
            }
        }

        $this->data['pinterest_track_single_woo_data'] = isset( $args[ 'pinterest_track_single_woo_data' ] ) && $args[ 'pinterest_track_single_woo_data' ] ? true : false;
        $this->data['pinterest_track_cart_woo_data'] = isset( $args[ 'pinterest_track_cart_woo_data' ] ) && $args[ 'pinterest_track_cart_woo_data' ] ? true : false;

        // reset old custom params
        $this->data[ 'pinterest_custom_params' ] = array();

        // custom params (legacy support)
        if ( $this->pinterest_params_enabled && isset( $args[ 'pinterest_custom_params' ] ) ) {

            foreach ( $args[ 'pinterest_custom_params' ] as $custom_param ) {

                if ( !empty( $custom_param[ 'name' ] ) && !empty( $custom_param[ 'value' ] ) ) {

                    $this->data[ 'pinterest_custom_params' ][] = array(
                        'name'  => sanitize_text_field( $custom_param[ 'name' ] ),
                        'value' => sanitize_text_field( $custom_param[ 'value' ] ),
                    );

                }

            }

        }

		/**
		 * GOOGLE ANALYTICS
		 */
        $this->updateGA($args);

        $this->updateGTM($args);
        /**
         * BING
         */

        $bing_events = PYS_Event_Definitions::get_bing_events();
        $bing_event_types = array_keys( $bing_events );

        // enabled
        $this->data[ 'bing_enabled' ] = isset( $args[ 'bing_enabled' ] ) && $args[ 'bing_enabled' ] ? true : false;

        // pixel id
        $this->data[ 'bing_pixel_id' ] = !empty( $args[ 'bing_pixel_id' ] ) && in_array( $args[ 'bing_pixel_id' ], Bing()->getAllPixels() ) ? $args[ 'bing_pixel_id' ] : 'all';

        // event type
        $this->data[ 'bing_event_type' ] = isset( $args[ 'bing_event_type' ] ) && in_array( $args[ 'bing_event_type' ], $bing_event_types ) ? sanitize_text_field( $args[ 'bing_event_type' ] ) : 'PageVisit';

        // custom event type
        $this->data[ 'bing_custom_event_type' ] = $this->bing_event_type == 'custom' && !empty( $args[ 'bing_custom_event_type' ] ) ? sanitizeKey( $args[ 'bing_custom_event_type' ] ) : null;

        // params enabled
        $this->data[ 'bing_params_enabled' ] = isset( $args[ 'bing_params_enabled' ] ) && $args[ 'bing_params_enabled' ] ? true : false;

        // bing_params - structured params like Facebook/TikTok
        $this->data[ 'bing_params' ] = array();
        if ( isset( $args[ 'bing_params' ] ) && is_array( $args[ 'bing_params' ] ) ) {
            foreach ( $args[ 'bing_params' ] as $param_key => $param_value ) {
                $this->data[ 'bing_params' ][ sanitize_text_field( $param_key ) ] = sanitize_text_field( $param_value );
            }
        }

        update_post_meta( $this->post_id, '_pys_event_data', $this->data );
        update_post_meta( $this->post_id, '_pys_event_conditions', addslashes( serialize( $this->conditions ) ) );
        update_post_meta( $this->post_id, '_pys_event_triggers', addslashes( serialize( $this->triggers ) ) );
	}

	public function enable() {

		$this->enabled = true;
		update_post_meta( $this->post_id, '_pys_event_state', 'active' );

	}

	public function disable() {

		$this->enabled = false;
		update_post_meta( $this->post_id, '_pys_event_state', 'paused' );

	}

	/**
	 * @return int
	 */
	public function getPostId() {
	    return $this->post_id;
    }

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

    public function transformTitle($title = null) {

        if(!is_null($title)){
            $title_pre_transform = $title;
        }
        else{
            $title_pre_transform = $this->title;
        }
        $textLat = Transliterator::transliterate($title_pre_transform);
        $cleaned = preg_replace('/[^A-Za-z0-9]+/', ' ', $textLat);
        $result = ucwords(trim($cleaned));
        return str_replace(' ', '', $result);
    }

    public function getManualCustomObjectName()
    {
        return $this->gtm_use_custom_object_name && $this->gtm_custom_object_name ? $this->gtm_custom_object_name : 'manual_'.$this->transformTitle();
    }
	public function isEnabled() {
		return $this->enabled;
	}

	public function getTriggerType() {
		return $this->trigger_type;
	}
    public function getTriggers() {
        return $this->triggers;
    }
    public function getConditions(){
        return $this->conditions;
    }
	/**
	 * @return array
	 */
	public function getPageVisitTriggers() {
		return $this->trigger_type == 'page_visit' ? $this->triggers : array();
	}
	
	public function isFacebookEnabled() {
		return (bool) $this->facebook_enabled;
	}
	
	public function getFacebookEventType() {
		return $this->facebook_event_type == 'CustomEvent' ? $this->facebook_custom_event_type : $this->facebook_event_type;
	}
	
	public function isFacebookParamsEnabled() {
		return (bool) $this->facebook_params_enabled;
	}
	
	public function getFacebookParam( $key ) {
		return isset( $this->facebook_params[ $key ] ) ? $this->facebook_params[ $key ] : null;
	}
	
	public function getFacebookParams() {
		return $this->facebook_params_enabled ? $this->facebook_params : array();
	}
	
	public function getFacebookCustomParams() {
		return $this->facebook_params_enabled ? $this->facebook_custom_params : array();
	}
	
	public function isPinterestEnabled() {
		return (bool) $this->pinterest_enabled;
	}

    public function isRedditEnabled() {
        return (bool) $this->reddit_enabled;
    }

    public function getPinterestEventType() {
        return $this->pinterest_event_type == 'partner_defined'
            ? $this->pinterest_custom_event_type
            : $this->pinterest_event_type;
    }

    public function isPinterestParamsEnabled() {
        return (bool) $this->pinterest_params_enabled;
    }

    public function getPinterestParams() {
        return $this->pinterest_params_enabled ? $this->pinterest_params : array();
    }

    public function getPinterestCustomParams() {
        return $this->pinterest_params_enabled ? $this->pinterest_custom_params : array();
    }

	public function isGoogleAnalyticsEnabled() {
		return (bool) $this->ga_enabled;
	}

    public function isGoogleAnalyticsPresent() {
        $allValues = GA()->getPixelIDs();
        $selectedValues = (array) $this->ga_ads_pixel_id;

        $hasAWElement = !empty($selectedValues) && (
                (
                    in_array('all', $selectedValues) &&
                    (bool) array_filter($allValues, function($value) {
                        return is_string($value) && strpos($value, 'G') === 0;
                    })
                ) ||
                (bool) array_filter($selectedValues, function($value) {
                    return is_string($value) && strpos($value, 'G') === 0;
                })
            );

        return $hasAWElement;
    }
    public function isUnifyAnalyticsEnabled(){
        return (bool) $this->ga_ads_enabled;
    }
    public function getMergedGaParams() {
        if(is_array($this->ga_ads_params)) {
            return $this->ga_ads_params;
        } else {
            return [];
        }
    }
	public function getGoogleAnalyticsAction() {
        return $this->ga_event_action == '_custom' ||
               $this->ga_event_action ==  'CustomEvent' ? $this->ga_custom_event_action : $this->ga_event_action;
	}
    public function getMergedAction(){
        return $this->ga_ads_event_action == '_custom' || $this->ga_ads_event_action ==  'CustomEvent' ? $this->ga_ads_custom_event_action : $this->ga_ads_event_action;
    }
    public function isBingEnabled() {
        return (bool) $this->bing_enabled;
    }

    public function getBingEventType() {
        return $this->bing_event_type == 'custom'
            ? $this->bing_custom_event_type
            : $this->bing_event_type;
    }

    public function isBingParamsEnabled() {
        return (bool) $this->bing_params_enabled;
    }

    public function getBingParams() {
        return $this->bing_params_enabled ? $this->bing_params : array();
    }

    public function getBingCustomParams() {
        return $this->bing_params_enabled ? $this->bing_custom_params : array();
    }
    public function isGaV4() {
        $all = GA()->getPixelIDs();
        if(count($all) == 0) {
            return false;
        }
        return strpos($all[0], 'G') === 0;
    }
    private function clearGa() {
        $this->data['ga_params'] = array();
        $this->data['ga_custom_params'] = array();
        $this->data['ga_event_action'] = 'CustomEvent';
        $this->data['ga_custom_event_action']=null;
        // old
        $this->data['ga_event_category'] = null;
        $this->data['ga_event_label'] = null;
        $this->data['ga_event_value'] = null;
    }
    function migrateUnifyGA() {
        $all = GA()->getPixelIDs();
        $this->data['ga_ads_enabled'] = $this->isGoogleAnalyticsEnabled();
        $pixel_ids = GA()->getPixelIDs();

        if(!empty($this->data['ga_ads_pixel_id'])){ return; }
        $this->data['ga_ads_pixel_id']  = array_map(function($pixelId) use ($all) {
            if (in_array($pixelId, $all) || $pixelId == 'all') {
                return $pixelId;
            } else {
                return '';
            }
        }, $pixel_ids);

        $this->data['ga_ads_pixel_id'] = array_filter($this->data['ga_ads_pixel_id']);

        $this->data['ga_ads_event_action'] = $this->ga_event_action;
        $this->data['ga_ads_custom_event_action'] = $this->ga_event_action == '_custom' || $this->ga_event_action ==  'CustomEvent' ? $this->ga_custom_event_action : '';
        $this->data['ga_ads_params'] = $this->getGaParams();
        $this->data['ga_ads_custom_params'] = $this->getGACustomParams();

        $outputArray = [];

        foreach ($this->data['ga_ads_custom_params'] as $item) {
            $key = $item["name"];
            if (!isset($outputArray[$key])) {
                $outputArray[$key] = $item;
            }
        }
        $this->data['ga_ads_custom_params'] = array_values($outputArray);
        update_post_meta( $this->post_id, '_pys_event_data', $this->data );
    }
    private function updateGA( $args) {

        $all = GA()->getPixelIDs();

        $this->data['ga_ads_enabled'] = count($all) > 0
            && isset( $args['ga_ads_enabled']  )
            && $args['ga_ads_enabled'];

        if(!$this->data['ga_ads_enabled']) {
            $this->clearGa();
        } else {
            if($this->isGaV4()) {

                $this->data['ga_ads_event_action'] = isset( $args['ga_ads_event_action'] )
                    ? sanitize_text_field( $args['ga_ads_event_action'] )
                    : 'view_item';

                $this->data['ga_ads_custom_event_action'] = ($this->ga_ads_event_action == '_custom' || $this->ga_ads_event_action == 'CustomEvent') && !empty( $args['ga_ads_custom_event_action'] )
                    ? sanitizeKey( $args['ga_ads_custom_event_action'] )
                    : null;

                $this->data['ga_ads_params'] = array();


                foreach ($this->getGAEvents() as $group) {
                    foreach ($group as $name => $fields) {
                        if($name == $this->data['ga_ads_event_action']) {
                            foreach ($fields as $field) {
                                $fieldName = is_array($field) && isset($field['name']) ? $field['name'] : $field;
                                $this->data['ga_ads_params'][$fieldName] = isset($args['ga_ads_params'][$fieldName]) ? $args['ga_ads_params'][$fieldName] : "";
                            }
                            break;
                        }
                    }
                }

                if ( isset( $args['ga_ads_params'] ) ) {
                    foreach ($args['ga_ads_params'] as $key => $val) {
                        $this->data['ga_ads_params'][$key] = sanitize_text_field( $val );
                    }
                }

                // reset old custom params
                $this->data['ga_ads_custom_params'] = array();

                // custom params
                if ( isset( $args['ga_ads_custom_params'] ) ) {

                    foreach ( $args['ga_ads_custom_params'] as $custom_param ) {

                        if ( ! empty( $custom_param['name'] ) && ! empty( $custom_param['value'] ) ) {

                            $this->data['ga_ads_custom_params'][] = array(
                                'name'  => sanitize_text_field( $custom_param['name'] ),
                                'value' => sanitize_text_field( $custom_param['value'] ),
                            );

                        }

                    }

                }
            }
        }
    }
    public function getGAMergedCustomParams() {
        if(is_array($this->ga_ads_custom_params)) {
            return $this->ga_ads_custom_params;
        }
        return [];
    }
    public function getGACustomParams() {
        if($this->isGaV4()) {
            if(is_array($this->ga_custom_params)) {
                return $this->ga_custom_params;
            }
            return [];
        }
        $custom = array();
        if($this->ga_event_category) {
            $custom[] = array('name'=>"event_category",'value' => $this->ga_event_category);
        }
        if($this->ga_event_value){
            $custom[] = array('name'=>"value",'value' => $this->ga_event_value);
        }
        if($this->ga_event_label){
            $custom[] = array('name'=>"event_label",'value' => $this->ga_event_label);
        }

        return $custom;
    }

    public function getGaParams() {
        if($this->isGaV4())
            if(is_array($this->ga_params)) {
                return $this->ga_params;
            } else {
                return [];
            }
        $list = array();
        foreach ($this->getGAEvents() as $group) {
            foreach ($group as $name => $fields) {
                if($name == $this->data['ga_event_action']) {
                    foreach ($fields as $field) {
                        $fieldName = is_array($field) && isset($field['name']) ? $field['name'] : $field;
                        $list[$fieldName] = "";
                    }
                }
            }
        }

        return $list;
    }

    public function isGTMEnabled(){
        return (bool) $this->gtm_enabled;
    }

    public function hasAutomatedParam(){
        return (bool) $this->gtm_automated_param;
    }

    public function removeGTMCustomTrigger(){
        return $this->gtm_remove_customTrigger;
    }

    public function useCustomNameObject(){
        return (bool) $this->gtm_use_custom_object_name;
    }
    public function isGTMPresent(){
        $allValues = GTM()->getAllPixels();
        $selectedValues = (array) $this->gtm_pixel_id;
        $hasAWElement = !empty($selectedValues) && (
                ( in_array( 'all', $selectedValues ) &&
                    (bool) array_filter( $allValues, function ( $value ) {
                        return strpos( $value, 'GTM' ) === 0;
                    } ) ) ||
                (bool) array_filter($selectedValues, function($value) {
                    return strpos($value, 'GTM') === 0;
                })
            );

        return $hasAWElement;
    }

    public function getGTMParams() {
        if(is_array($this->gtm_params)) {
            return $this->gtm_params;
        } else {
            return [];
        }
    }

    public function getAllGTMParams(){
        $params = [];
        if(is_array($this->getGTMParams())){
            if(in_array($this->getGTMAction(), $this->ecommerceEventNames)){
                foreach ($this->getGTMParams() as $key => $param){
                    if ( in_array( $key, $this->ecommerceParamArray ) ) {
                        $params['ecommerce'][ $key ] = $param;
                    } else {
                        $params[ $this->getManualCustomObjectName() ][ $key ] = $param;
                    }
                }
            }
            else{
                foreach ($this->getGTMParams() as $key => $param){
                    $params[ $this->getManualCustomObjectName() ][ $key ] = $param;
                }
            }
        }

        if(is_array($this->getGTMCustomParams())){
            foreach ($this->getGTMCustomParams() as $param){
                $params[ $this->getManualCustomObjectName() ][ $param['name'] ] = $param['value'];
            }
        }

        return $params;
    }
    public function getGTMAction(){
        return $this->gtm_event_action == '_custom' || $this->gtm_event_action ==  'CustomEvent' ? $this->gtm_custom_event_action : $this->gtm_event_action;
    }

    public function getGTMCustomParamsAdmin() {
        return  $this->gtm_custom_params;
    }
    public function getGTMCustomParams() {
        $params = [];
        foreach ($this->gtm_custom_params as $param){
            $params[] = apply_filters( 'pys_superpack_dynamic_params', $param, 'gtm' );
        }
        return  $params;
    }

    private function clearGTM() {
        $this->data['gtm_params'] = array();
        $this->data['gtm_custom_params'] = array();
        $this->data['gtm_event_action'] = 'CustomEvent';
        $this->data['gtm_custom_event_action']=null;
    }

    private function updateGTM($args)
    {
        $all = GTM()->getAllPixels();

        if(!empty( $args['gtm_pixel_id'] )) {
            $this->data['gtm_pixel_id'] = array_map(function($pixelId) use ($all) {
                if (in_array( $pixelId,$all)) {
                    return $pixelId;
                }
            }, $args['gtm_pixel_id']);
        } elseif (count($all) > 0) {
            $this->data['gtm_pixel_id'] = (array) $all[0];
        } else {
            $this->data['gtm_pixel_id'] = [];
        }

        $this->data['gtm_enabled'] = isset( $args['gtm_enabled']  )
            && $args['gtm_enabled'];

        $this->data['gtm_automated_param'] = isset( $args['gtm_automated_param']  )
            && $args['gtm_automated_param'];

        $this->data['gtm_remove_customTrigger'] = isset( $args['gtm_remove_customTrigger']  )
            && $args['gtm_remove_customTrigger'];

        $this->data['gtm_use_custom_object_name'] = isset( $args['gtm_use_custom_object_name']  )
            && $args['gtm_use_custom_object_name'];

        $this->data['gtm_custom_object_name'] = !empty($args['gtm_custom_object_name']) ? sanitize_text_field( $args['gtm_custom_object_name'] ) : 'manual_'.$this->transformTitle();

        $this->data['gtm_event_action'] = isset( $args['gtm_event_action'] )
            ? sanitize_text_field( $args['gtm_event_action'] )
            : 'view_item';
        $this->data['gtm_custom_event_action'] = (isset( $args['gtm_event_action'] ) && ($args['gtm_event_action'] == '_custom' || $args['gtm_event_action'] == 'CustomEvent')) && !empty($args['gtm_custom_event_action'])
            ? sanitizeKey( $args['gtm_custom_event_action'] )
            : null;
        $this->data['gtm_params'] = array();

        foreach ($this->getGAEvents() as $group) {
            foreach ($group as $name => $fields) {
                if($name == $this->data['gtm_event_action']) {
                    foreach ($fields as $field) {
                        $fieldName = is_array($field) && isset($field['name']) ? $field['name'] : $field;
                        $this->data['gtm_params'][$fieldName] = isset($args['gtm_params'][$fieldName]) ? $args['gtm_params'][$fieldName] : "";
                    }
                    break;
                }
            }
        }

        if ( isset( $args['gtm_params'] ) ) {
            foreach ($args['gtm_params'] as $key => $val) {
                $this->data['gtm_params'][$key] = sanitize_text_field( $val );
            }
        }

        // reset old custom params
        $this->data['gtm_custom_params'] = array();

        // custom params
        if ( isset( $args['gtm_custom_params'] ) ) {

            foreach ( $args['gtm_custom_params'] as $custom_param ) {

                if ( ! empty( $custom_param['name'] ) && ! empty( $custom_param['value'] ) ) {

                    $this->data['gtm_custom_params'][] = array(
                        'name'  => sanitize_text_field( $custom_param['name'] ),
                        'value' => sanitize_text_field( $custom_param['value'] ),
                    );

                }

            }

        }
    }

    public function getDelay () {
        $delay = null;
        if (!empty($this->triggers)) {
            $delays = array();
            foreach ( $this->triggers as $trigger ) {
                $delays[] = $trigger->getParam('delay');
            }
            $delay = max($delays);
        }

        return $delay;
    }
    public function checkConditions()
    {
        $conditions_enabled = $this->__get('conditions_enabled');
        $conditions_logic = $this->__get('conditions_logic');
        $conditions = $this->getConditions();

        $check = true;

        if($conditions_enabled && !empty($conditions)){
            $conditions_results = [];
            foreach ($conditions as $condition) {
                $condition_result = $condition->check();
                $conditions_results[] = $condition_result;
            }
            if($conditions_logic === 'AND'){
                $check = !in_array(false, $conditions_results);
            }
            else{
                $check =  in_array(true, $conditions_results);
            }
        }
        return $check;
    }

	private function updateRedditParams( $args ) {
		$reddit_event_types = array_keys( self::$redditEvents );

		$standard_params = [
			'itemCount',
			'currency',
			'value',
		];
		// enabled
		$this->data[ 'reddit_enabled' ] = isset( $args[ 'reddit_enabled' ] ) && $args[ 'reddit_enabled' ];

		//pixel id
		$this->data[ 'reddit_pixel_id' ] = !empty( $args[ 'reddit_pixel_id' ] )
		                                   && in_array( $args[ 'reddit_pixel_id' ], Reddit()->getAllPixels() ) ? $args[ 'reddit_pixel_id' ] : 'all';

		// event type
		$this->data[ 'reddit_event_type' ] = isset( $args[ 'reddit_event_type' ] )
		                                     && in_array( $args[ 'reddit_event_type' ], $reddit_event_types ) ? sanitize_text_field( $args[ 'reddit_event_type' ] ) : 'ViewContent';

		// custom event type
		$this->data[ 'reddit_custom_event_type' ] = $this->reddit_event_type == 'Custom'
		                                            && !empty( $args[ 'reddit_custom_event_type' ] ) ? sanitizeKey( $args[ 'reddit_custom_event_type' ] ) : null;

		// params enabled
		$this->data[ 'reddit_params_enabled' ] = isset( $args[ 'reddit_params_enabled' ] )
		                                         && $args[ 'reddit_params_enabled' ];

		$this->data[ 'reddit_track_single_woo_data' ] = isset( $args[ 'reddit_track_single_woo_data' ] )
		                                                && $args[ 'reddit_track_single_woo_data' ];
		$this->data[ 'reddit_track_cart_woo_data' ]   = isset( $args[ 'reddit_track_cart_woo_data' ] )
		                                                && $args[ 'reddit_track_cart_woo_data' ];

		// params
		$params = [];
		if ( $this->reddit_params_enabled && isset( $args[ 'reddit_params' ] ) ) {

			foreach ( $standard_params as $standard ) {
				$params[ $standard ] = !empty( $args[ 'reddit_params' ][ $standard ] ) ? sanitize_text_field( $args[ 'reddit_params' ][ $standard ] ) : null;
			}
		} else {
			// clear all
			foreach ( $standard_params as $standard ) {
				$params[ $standard ] = null;
			}
		}
		$this->data[ 'reddit_params' ] = $params;
	}

    /**
     * Get Google Analytics events from centralized Event Definitions class
     * @deprecated Use PYS_Event_Definitions::get_ga_events() instead
     * @return array
     */
    private function getGAEvents() {
        return PYS_Event_Definitions::get_ga_events();
    }
}