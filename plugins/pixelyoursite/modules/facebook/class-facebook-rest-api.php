<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Facebook REST API handler
 */
class Facebook_REST_API {

    /**
     * Register REST API routes
     */
    public function register_routes() {
        add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
    }

    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route( 'pys-facebook/v1', '/event', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handle_facebook_event' ),
            'permission_callback' => array( $this, 'check_permission' ),
            'args'                => $this->get_event_args(),
        ) );
    }

    /**
     * Handle Facebook event
     */
    public function handle_facebook_event( $request ) {
        $event = $request->get_param( 'event' );
        $data = $request->get_param( 'data' );
        $ids = $request->get_param( 'ids' );
        $eventID = $request->get_param( 'eventID' );
        $woo_order = $request->get_param( 'woo_order' );
        $edd_order = $request->get_param( 'edd_order' );



        $singleEvent = $this->data_to_single_event( $event, $data, $eventID, $ids, $woo_order, $edd_order );

        // Send event using existing Facebook server logic
        FacebookServer()->sendEventsNow( array( $singleEvent ) );

        return new \WP_REST_Response( array( 'success' => true ), 200 );
    }

    /**
     * Check permission for REST API access
     */
    public function check_permission( $request ) {
        // Allow all requests for event tracking endpoints
        return true;
    }

    /**
     * Get event arguments for REST API
     */
    private function get_event_args() {
        return array(
            'event'      => array(
                'required'          => true,
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ),
            'data'       => array(
                'required'          => false,
                'type'              => 'string',
                'default'           => '{}',
                'sanitize_callback' => array( $this, 'sanitize_data' ),
            ),
            'ids'        => array(
                'required'          => false,
                'type'              => 'string',
                'default'           => '[]',
                'sanitize_callback' => array( $this, 'sanitize_ids' ),
            ),
            'eventID'    => array(
                'required'          => false,
                'type'              => 'string',
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ),
            'woo_order'  => array(
                'required'          => false,
                'type'              => 'string',
                'default'           => '0',
                'sanitize_callback' => array( $this, 'sanitize_order_id' ),
            ),
            'edd_order'  => array(
                'required'          => false,
                'type'              => 'string',
                'default'           => '0',
                'sanitize_callback' => array( $this, 'sanitize_order_id' ),
            ),
        );
    }



    /**
     * Sanitize data parameter
     */
    public function sanitize_data( $data ) {
        if ( is_string( $data ) ) {
            $decoded = json_decode( $data, true );
            return is_array( $decoded ) ? $decoded : array();
        }
        return is_array( $data ) ? $data : array();
    }

    /**
     * Sanitize ids parameter
     */
    public function sanitize_ids( $ids ) {
        if ( is_string( $ids ) ) {
            $decoded = json_decode( $ids, true );
            return is_array( $decoded ) ? $decoded : array();
        }
        return is_array( $ids ) ? $ids : array();
    }

    /**
     * Sanitize order ID
     */
    public function sanitize_order_id( $order_id ) {
        if ( empty( $order_id ) || $order_id === '0' || $order_id === 'null' || $order_id === 'undefined' ) {
            return 0;
        }
        return (int) $order_id;
    }

    /**
     * Convert data to SingleEvent object
     */
    private function data_to_single_event( $event_name, $params, $event_id, $ids, $woo_order, $edd_order ) {
        $singleEvent = new SingleEvent( "", "" );

        $payload = array(
            'name'      => $event_name,
            'eventID'   => $event_id,
            'woo_order' => $woo_order,
            'edd_order' => $edd_order,
            'pixelIds'  => $ids
        );

        $singleEvent->addParams( $params );
        $singleEvent->addPayload( $payload );

        return $singleEvent;
    }

    /**
     * Enqueue scripts for frontend
     */
    public function enqueue_scripts() {
        if ( ! Facebook()->isServerApiEnabled() ) {
            return;
        }

        wp_localize_script( 'jquery', 'pysFacebookRest', array(
            'restApiUrl' => rest_url( 'pys-facebook/v1/event' ),
            'debug'      => PYS()->getOption( 'debug_enabled' )
        ) );
    }

    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts() {
        if ( ! Facebook()->isServerApiEnabled() ) {
            return;
        }

        wp_localize_script( 'jquery', 'pysFacebookRest', array(
            'restApiUrl' => rest_url( 'pys-facebook/v1/event' ),
            'debug'      => PYS()->getOption( 'debug_enabled' )
        ) );
    }

    /**
     * Initialize hooks
     */
    public function init() {
        $this->register_routes();
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
    }
}

/**
 * Accessor function for Facebook REST API
 */
function Facebook_REST_API() {
    static $instance = null;
    if ( $instance === null ) {
        $instance = new Facebook_REST_API();
        $instance->init();
    }
    return $instance;
}
