<?php
/**
 * Author: AdTribes
 *
 * @package AdTribes\PFP\Abstracts
 */

namespace AdTribes\PFP\Abstracts;

use AdTribes\PFP\Traits\Magic_Get_Trait;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Abstract_REST class. Override register_plugin_routes() method to customize class properties and call the parent
 * method to initialize the class REST routes with your customizations.
 *
 * @since 13.4.3
 */
abstract class Abstract_REST extends \WP_REST_Controller {

    use Magic_Get_Trait;

    /**
     * Holds the full REST API URL.
     *
     * @since 13.4.3
     * @var string REST api URL
     */
    protected $api_url;

    /**
     * Called on plugins_loaded hook when <code>$GLOBALS['wp_rewrite']</code> is still null hence, we register the
     * plugin's REST routes in <code>setup_theme</code> hook which runs after <code>$GLOBALS['wp_rewrite']</code> is
     * instantiated.
     *
     * @since 13.4.3
     * @return void
     */
    public function run() {

        $this->register_plugin_routes();
    }

    /**
     * Works as constructor for this class. You might want to override the `namespace` and `rest_base` properties of
     * this class in your child class. Override this method to change the default `namespace`, `rest_base`, `api_url`
     * and `nonce` properties then call this parent method: <code>parent::register_plugin_routes();</code>
     *
     * @since 13.4.3
     * @return void
     */
    public function register_plugin_routes() {

        /***************************************************************************
         * Set plugin REST API namespace
         ***************************************************************************
         *
         * We set the default namespace to `woocommerce-product-feed-elite/v1`.
         */
        $this->namespace = ! empty( $this->namespace )
            ? $this->namespace
            : 'adtribes/v1';

        /***************************************************************************
         * Set plugin REST API base
         ***************************************************************************
         *
         * We set the REST base by default to "classname" in lowercase.
         */
        $this->rest_base = ! empty( $this->rest_base )
            ? $this->rest_base
            : strtolower( str_replace( '_', '-', wp_basename( get_class( $this ) ) ) );

        /***************************************************************************
         * Set full plugin REST API URL
         ***************************************************************************
         *
         * The full REST API URL is: {site_url}/wp-json/{namespace}/{rest_base}
         */
        $this->api_url = esc_url_raw( trailingslashit( rest_url( "$this->namespace/$this->rest_base" ) ) );

        /***************************************************************************
         * Hook into REST API init action to register plugin routes
         ***************************************************************************
         *
         * We hook into the REST API init action to register plugin routes.
         */
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * REST response.
     *
     * @param mixed|WP_Error  $data    Response data.
     * @param WP_REST_Request $request Request object.
     * @param int             $status  Response Status code.
     * @param array           $headers Additional headers.
     *
     * @since 13.4.3
     * @return WP_REST_Response REST response header.
     */
    public function rest_response( $data, $request, $status = 200, $headers = array() ) {

        return new WP_REST_Response(
            $this->prepare_item_for_response( $data, $request ),
            $status,
            $headers
        );
    }

    /**
     * Return prepared item.
     *
     * @param mixed           $item    Item to be sent as response.
     * @param WP_REST_Request $request Request object.
     *
     * @return mixed|WP_REST_Response
     */
    public function prepare_item_for_response( $item, $request ) {

        return $item;
    }

    /**
     * Checks if a given request has access to get items.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @since 13.4.3
     * @return WP_Error|bool True if the request has read access, WP_Error object otherwise.
     */
    public function get_items_permissions_check( $request ) {

        return true;
    }

    /**
     * Checks if a given request has access to get a specific item.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @since 13.4.3
     * @return WP_Error|bool True if the request has read access for the item, WP_Error object otherwise.
     */
    public function get_item_permissions_check( $request ) {

        return true;
    }

    /**
     * Checks if a given request has access to create items.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @since 13.4.3
     * @return WP_Error|bool True if the request has access to create items, WP_Error object otherwise.
     */
    public function create_item_permissions_check( $request ) {

        return current_user_can( 'manage_woocommerce' );
    }

    /**
     * Checks if a given request has access to update a specific item.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @since 13.4.3
     * @return WP_Error|bool True if the request has access to update the item, WP_Error object otherwise.
     */
    public function update_item_permissions_check( $request ) {

        return current_user_can( 'manage_woocommerce' );
    }

    /**
     * Checks if a given request has access to delete a specific item.
     *
     * @param WP_REST_Request $request Full data about the request.
     *
     * @since 13.4.3
     * @return WP_Error|bool True if the request has access to delete the item, WP_Error object otherwise.
     */
    public function delete_item_permissions_check( $request ) {

        return current_user_can( 'manage_woocommerce' );
    }
}
