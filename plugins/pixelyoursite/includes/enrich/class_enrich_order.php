<?php
namespace PixelYourSite;

class EnrichOrder {
    private static $_instance;

    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function init() {
        //woo

        if(PYS()->getOption("woo_enabled_save_data_to_orders")) {
            // Regular orders
            add_action( 'woocommerce_new_order', array( $this, 'woo_save_checkout_fields_safe' ), 10, 1 );

            // Paid subscription renewals
            add_action( 'woocommerce_subscription_renewal_payment_complete', array( $this, 'woo_save_checkout_fields_safe' ), 10, 1 );

            add_action( 'add_meta_boxes', array($this,'woo_add_order_meta_boxes') );
            if(PYS()->getOption("woo_add_enrich_to_admin_email")) {
                add_action( 'woocommerce_email_customer_details', array($this,'woo_add_enrich_to_admin_email'),80,4 );
            }
        }

        // edd
        if(PYS()->getOption("edd_enabled_save_data_to_orders")) {
            add_filter('edd_payment_meta', array($this, 'edd_save_checkout_fields'),10,2);
            add_action('edd_view_order_details_main_after', array($this, 'add_edd_order_details'));
        }
    }

    function add_edd_order_details($payment_id) {
        echo '<div id="edd-payment-notes" class="postbox">
    <h3 class="hndle"><span>PixelYourSite</span></h3>';
        echo "<div style='margin:20px'>
                <p>With the paid plugin, you can see more data on the Easy Digital Downloads Reports page. <a target='_blank' href='https://www.pixelyoursite.com/easy-digital-downloads-first-party-reports/?utm_source=free-plugin-edd-order&utm_medium=free-plugin-edd-order&utm_campaign=free-plugin-edd-order&utm_content=free-plugin-edd-order&utm_term=free-plugin-edd-order'>Click here for details.</a></p>
                <p>You can ". (PYS()->getOption('edd_enabled_display_data_to_orders') ? 'hide' : 'show') ." Report data from the plugin's <a href='".admin_url("admin.php?page=pixelyoursite&tab=edd")."' target='_blank'>Easy Digital Downloads page</a>. </p>
                <p>You can stop storing this data from the plugin's <a href='".admin_url("admin.php?page=pixelyoursite&tab=edd")."' target='_blank'>Easy Digital Downloads page</a></p>
                </div>";
        include 'views/html-edd-order-box.php';
        echo '</div>';
    }

    function woo_add_order_meta_boxes () {
        $screen = isWooUseHPStorage()
            ? wc_get_page_screen_id( 'shop-order' )
            : 'shop_order';
        add_meta_box( 'pys_enrich_fields_woo', __('PixelYourSite','pixelyoursite'),
            array($this,"woo_render_order_fields"), $screen);
    }

    function woo_render_order_fields($post) {
        if ($post instanceof \WP_Post) {
            $orderId = $post->ID;
        } elseif (method_exists($post, 'get_id')) {
            $orderId = $post->get_id();
        } else {
            // Обработка ситуации, когда $post не является ни объектом \WP_Post, ни объектом с методом get_id().
            $orderId = null; // Или другое значение по умолчанию.
        }
        echo "<div style='margin:20px 10px'>
                <p>With the paid plugin, you can see more data on the WooCommerce Reports page. <a href='https://www.pixelyoursite.com/woocommerce-first-party-reports?utm_source=free-plugin&utm_medium=order-page&utm_campaign=reports-order-page&utm_content=woocommerce-reports-client-page&utm_term=order-page-reports' target='_blank'>Click here for details</a></p>
                <p>You can ". (PYS()->getOption('woo_enabled_display_data_to_orders') ? 'hide' : 'show') ." Report data from the plugin's <a href='".admin_url("admin.php?page=pixelyoursite&tab=woo")."' target='_blank'>WooCommerce page</a>. </p>
                <p>You can stop storing this data from the plugin's <a href='".admin_url("admin.php?page=pixelyoursite&tab=woo")."' target='_blank'>WooCommerce page</a>.</p>
                </div>";
        include 'views/html-order-meta-box.php';
    }

    public function woo_save_checkout_fields_safe( $order_id ) {

        $order = wc_get_order( $order_id );
        if (!$order instanceof \WC_Order) {
            error_log( "woo_save_checkout_fields_safe: no valid order found for ID: {$order_id}" );
            return;
        }

        // We determine whether it is a renewal or not
        $renewal_order = false;
        $created_via   = method_exists( $order, 'get_created_via' ) ? $order->get_created_via() : '';

        if ( function_exists( 'wcs_order_contains_subscription' ) && wcs_order_contains_subscription( $order, 'renewal' ) ) {
            $renewal_order = true;
        } elseif ( $created_via === 'subscription_renewal' || $created_via === 'subscription' ) {
            $renewal_order = true;
        }

		$pysData = $this->getPysData( $renewal_order );

		if ( isWooCommerceVersionGte( '3.0.0' ) ) {
			// WooCommerce >= 3.0
			if ( $order ) {
				$order->update_meta_data( "pys_enrich_data", $pysData );
				$order->save();
			}

		} else {
			// WooCommerce < 3.0
			update_post_meta( $order_id, 'pys_enrich_data', $pysData );
		}
    }

    /**
     * @param \WC_Order$order
     * @param $sent_to_admin
     * @param $plain_text
     * @param $email
     */

    function woo_add_enrich_to_admin_email($order, $sent_to_admin) {
        if($sent_to_admin) {
            $orderId = $order->get_id();
            echo "<h2 style='text-align: center'>". __('PixelYourSite','pixelyoursite')."</h2>";
            echo "Your clients don't see this information! We send it to you in this \"New Order\" email. If you want to remove this data from the \"New Order\" email, open <a href='".admin_url("admin.php?page=pixelyoursite&tab=woo")."' target='_blank'>PixelYourSite's WooCommerce page</a>, disable \"Send reports data to the New Order email\" and save.
            <br/>With PixelYourSite Professional, you can view and download this data from the plugin's own reports page. Find out how WooCommerce Reports work and how to visualize and download your data: <a href='https://www.pixelyoursite.com/woocommerce-first-party-reports?utm_source=free-plugin&utm_medium=order-email&utm_campaign=order-email-link&utm_content=woocommerce-reports&utm_term=woocommerce-reports-email-link' target='_blank'>Click here for details</a>.<br/>";
            include 'views/html-order-meta-box.php';
        }
    }


    function edd_save_checkout_fields( $payment_meta ,$init_payment_data) {

        $edd_subscription = $init_payment_data['status'] == 'edd_subscription';

        if ( 0 !== did_action( 'edd_pre_process_purchase' ) || $edd_subscription ) {
            $pysData = $this->getPysData( $edd_subscription );
            $payment_meta['pys_enrich_data'] = $pysData;
        }

        return $payment_meta;
    }



	/**
	 * Save subscription meta for recurring payments
	 * @param $payment_id
	 * @return void
	 */
	function edd_save_subscription_meta( $payment_id ) {

		$payment_meta = edd_get_payment_meta( $payment_id );

		$pysData = $this->getPysData( true );

		$payment_meta[ 'pys_enrich_data' ] = $pysData;
		edd_update_payment_meta( $payment_id, '_edd_payment_meta', $payment_meta );
	}

    function getPysData( $renewal_order = false ) {
        $utms = getUtms( true );
        $utms_id = getUtmsId( true );

        if ( $renewal_order ) {
            $pysData = $this->buildRenewalPysData( $utms, $utms_id );
        } else {
            $pysData = $this->buildRegularPysData( $utms, $utms_id );
        }

        $pysData['pys_browser_time'] = $this->getRequestValue( 'pys_browser_time', getBrowserTime() );
        return $pysData;
    }

    /**
     * Build PYS data for renewal/subscription orders
     *
     * @param array $utms UTM parameters
     * @param array $utms_id UTM ID parameters
     * @return array
     */
    private function buildRenewalPysData( $utms, $utms_id ) {
        $utms_recurring = $this->formatUtmsAsRecurring( $utms );
        $utms_id_recurring = $this->formatUtmsAsRecurring( $utms_id );

        return [
            'pys_landing'      => '',
            'pys_source'       => 'recurring payment',
            'pys_utm'          => $utms_recurring,
            'pys_utm_id'       => $utms_id_recurring,
            'last_pys_landing' => '',
            'last_pys_source'  => 'recurring payment',
            'last_pys_utm'     => $utms_recurring,
            'last_pys_utm_id'  => $utms_id_recurring,
        ];
    }

    /**
     * Build PYS data for regular orders
     *
     * @param array $utms UTM parameters (first visit)
     * @param array $utms_id UTM ID parameters (first visit)
     * @return array
     */
    private function buildRegularPysData( $utms, $utms_id ) {
        // First visit defaults
        $default_landing = $this->getDefaultLanding();
        $default_source = $this->getDefaultSource();
        $default_utm = $this->formatUtms( $utms );
        $default_utm_id = $this->formatUtms( $utms_id );

        // Last visit defaults
        $default_last_landing = $this->getDefaultLastLanding();
        $default_last_source = $this->getDefaultLastSource();
        $default_last_utm = $this->formatUtms( getUtms( true, true ) );
        $default_last_utm_id = $this->formatUtms( getUtmsId( true, true ) );

        return [
            'pys_landing'      => $this->getRequestValue( 'pys_landing', $default_landing, 'undefined' ),
            'pys_source'       => $this->getRequestValue( 'pys_source', $default_source, 'undefined' ),
            'pys_utm'          => $this->getRequestValue( 'pys_utm', $default_utm ),
            'pys_utm_id'       => $this->getRequestValue( 'pys_utm_id', $default_utm_id ),
            'last_pys_landing' => $this->getRequestValue( 'last_pys_landing', $default_last_landing, 'undefined' ),
            'last_pys_source'  => $this->getRequestValue( 'last_pys_source', $default_last_source, 'undefined' ),
            'last_pys_utm'     => $this->getRequestValue( 'last_pys_utm', $default_last_utm ),
            'last_pys_utm_id'  => $this->getRequestValue( 'last_pys_utm_id', $default_last_utm_id ),
        ];
    }

    /**
     * Get sanitized value from REQUEST or use fallback
     *
     * @param string $key Request key
     * @param mixed $fallback Fallback value
     * @param mixed $empty_fallback Value to use if fallback is empty
     * @return string
     */
    private function getRequestValue( $key, $fallback = '', $empty_fallback = null ) {
        if ( isset( $_REQUEST[ $key ] ) ) {
            return sanitize_text_field( $_REQUEST[ $key ] );
        }

        if ( $empty_fallback !== null && empty( $fallback ) ) {
            return $empty_fallback;
        }

        return $fallback ?? '';
    }

    /**
     * Get default landing page from session/cookie (first visit)
     *
     * @return string
     */
    private function getDefaultLanding() {
        $landingPage = $_SESSION['LandingPage'] ?? $_COOKIE['pys_landing_page'] ?? '';

        if ((empty($landingPage) || strpos($landingPage, 'undefined') === 0 || strpos($landingPage, 'http://undefined') === 0) && (defined( 'REST_REQUEST' ) && REST_REQUEST) ) {
            $landingPage = 'REST API';
        }

        return sanitize_text_field($landingPage);
    }

    /**
     * Get default traffic source from session/cookie (first visit)
     *
     * @return string
     */
    private function getDefaultSource() {
        $trafficSource = $_SESSION['TrafficSource'] ?? $_COOKIE['pysTrafficSource'] ?? '';
        if ((empty($trafficSource) || strpos($trafficSource, 'undefined') === 0) && (defined( 'REST_REQUEST' ) && REST_REQUEST) ) {
            $trafficSource = 'REST API';
        }

        return  sanitize_text_field($trafficSource);
    }

    /**
     * Get default last landing page from cookie (last visit)
     *
     * @return string
     */
    private function getDefaultLastLanding() {
        $lastLanding = $_COOKIE['last_pys_landing_page'] ?? $_SESSION['LandingPage'] ?? $_COOKIE['pys_landing_page'] ?? '';
        if ((empty($lastLanding) || strpos($lastLanding, 'undefined') === 0 || strpos($lastLanding, 'http://undefined') === 0) && (defined( 'REST_REQUEST' ) && REST_REQUEST) ) {
            $lastLanding = 'REST API';
        }

        return  sanitize_text_field($lastLanding);
    }

    /**
     * Get default last traffic source from cookie (last visit)
     *
     * @return string
     */
    private function getDefaultLastSource() {
        $lastSource = $_COOKIE['last_pysTrafficSource'] ?? $_SESSION['TrafficSource'] ?? $_COOKIE['pysTrafficSource'] ?? '';
        if ((empty($lastSource) || strpos($lastSource, 'undefined') === 0) && (defined( 'REST_REQUEST' ) && REST_REQUEST) ) {
            return 'REST API';
        }

        return sanitize_text_field($lastSource);
    }

    /**
     * Format UTMs array as pipe-separated string (key:value|key:value)
     *
     * @param array $utms UTM parameters
     * @return string
     */
    private function formatUtms( $utms ) {
        if ( empty( $utms ) ) {
            return '';
        }

        return implode( '|', array_map(
            function ( $key, $value ) { return "$key:$value"; },
            array_keys( $utms ),
            $utms
        ) );
    }

    /**
     * Format UTMs array as recurring payment string (key:recurring payment|...)
     *
     * @param array $utms UTM parameters
     * @return string
     */
    private function formatUtmsAsRecurring( $utms ) {
        if ( empty( $utms ) ) {
            return '';
        }

        return implode( '|', array_map(
            function ( $key ) { return "$key:recurring payment"; },
            array_keys( $utms )
        ) );
    }
}

/**
 * @return EnrichOrder
 */
function EnrichOrder() {
    return EnrichOrder::instance();
}

EnrichOrder();