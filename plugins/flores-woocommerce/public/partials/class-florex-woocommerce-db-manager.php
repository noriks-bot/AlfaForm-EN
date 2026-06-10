<?php

/**
 * Database manipulating helper functions
 *
 * @link       https://noriks.com/
 * @since      1.0.0
 *
 * @package    Flores_Woocommerce
 * @subpackage Flores_Woocommerce/public/partials
 */

/**
 *
 * @package    Flores_Woocommerce
 * @subpackage Flores_Woocommerce/public/partials
 * @author     Noriks <dev@noriks.com>
 */
class Flores_Woocommerce_Db_Manager {

    /**
     * Remove user from db
     *
     * @return true|false → removes user from db
     */
    public function removeUser($id) {
        global $wpdb;

        return $wpdb->delete(
            $wpdb->prefix.'digit_tracking_user',
            ['id' => $id], // which id to remove
            ['%d'], // make sure the id is number
        );
    }

    /**
     * Insert user meta to db
     *
     * @return mixed|false → inserts user meta to db
     */
    public function insertUserMeta($hash, $id_order, $url = null, $utm_source = null, $utm_medium = null, $campaign_name = null, $adset_name = null, $ad_name = null, $campaign_id = null, $adset_id = null, $ad_id = null, $placement = null) {
        global $wpdb;

        $date = gmdate('Y-m-d H:i:s');

        return $wpdb->insert($wpdb->prefix.'digit_tracking_user_meta', array(
            'id_user' => sanitize_key($hash),
            'id_order' => sanitize_key($id_order),
            'landing' => sanitize_text_field($url),
            'utm_source' => sanitize_text_field($utm_source),
            'utm_medium' => sanitize_text_field($utm_medium),
            'campaign_name' => sanitize_text_field($campaign_name),
            'adset_name' => sanitize_text_field($adset_name),
            'ad_name' => sanitize_text_field($ad_name),
            'campaign_id' => sanitize_text_field($campaign_id),
            'adset_id' => sanitize_text_field($adset_id),
            'ad_id' => sanitize_text_field($ad_id),
            'placement' => sanitize_text_field($placement),
            'date' => $date
        ));
    }

    /**
     * Insert user meta to db
     *
     * @return mixed|false → inserts user meta to db
     */
    public function getUserMeta($hash, $url = null, $utm_source = null, $utm_medium = null, $campaign_name = null, $adset_name = null, $ad_name = null, $campaign_id = null, $adset_id = null, $ad_id = null, $placement = null) {
        global $wpdb;

        $standalone_options = get_option( 'standalone_option_config' );
        if(isset($standalone_options) && isset($standalone_options['cookie_lifetime']) && is_numeric($standalone_options['cookie_lifetime']))
            $days = $standalone_options['cookie_lifetime'];
        else
            $days = 7;

        $expired = strtotime("-$days days");

        $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_user LIKE %s AND landing LIKE %s AND utm_source LIKE %s AND utm_medium LIKE %s AND campaign_name LIKE %s AND adset_name LIKE %s AND ad_name LIKE %s AND campaign_id LIKE %s AND adset_id LIKE %s AND ad_id LIKE %s AND placement LIKE %s", $hash, $url, $utm_source, $utm_medium, $campaign_name, $adset_name, $ad_name, $campaign_id, $adset_id, $ad_id, $placement ) );
        
        if($row && strtotime($row->date) > $expired ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Assign order id for user journey
     *
     * @return mixed|false → inserts user meta to db
     */
    public function updateJourneyOrderID($hash, $order_id) {
        global $wpdb;

        $table_name = $wpdb->prefix.'digit_tracking_user_meta';
        $data_update = array('id_order' => $order_id);
        $data_where = array('id_user' => $hash, 'id_order' => 0);
        $wpdb->update($table_name, $data_update, $data_where);
    }

    protected function getJourneyDefault($order_id) {
        $default = new stdClass();
        $default->id_order = $order_id;
        $default->landing = "/";
        $default->utm_source = "direct";
        $default->utm_medium = "undefined";
        $default->date = gmdate('Y-m-d H:i:s');
        return [0 => $default];
    }

    /**
     * Assign order id for user journey
     *
     * @return mixed|false → inserts user meta to db
     */
    public function getOrderJourney($order_id) {
        global $wpdb;

        $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_order LIKE %s ORDER BY date ASC", $order_id ) );

        if(count($result) > 0) {
            return $result;
        }

        $default = $this->getJourneyDefault($order_id);
        return $default;
    }

    /**
     * Assign order id for user journey
     *
     * @return mixed|false → inserts user meta to db
     */
    public function getOrdersJourneys($order_ids) {
        global $wpdb;

        $result = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT id_order, utm_source, utm_medium, campaign_id, adset_id, ad_id, date FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_order IN (%1s) ORDER BY date ASC", $order_ids ) );

        if(count($result) > 0) {
            return $result;
        }

        return [];
    }

    /**
     * Assign order id for user journey
     *
     * @return mixed|false → inserts user meta to db
     */
    public function getOrderJourneyByAttribution($order_id, $attribution) {
        global $wpdb;

        if(! isset($attribution['attribution'])) $attribution['attribution'] = "first";

        switch($attribution['attribution']) {
            case 'last':
                $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_order LIKE %s AND utm_source != %s AND utm_source != '' ORDER BY date DESC LIMIT 1", $order_id, "direct" ) );
                if (is_null($result) || !empty($wpdb->last_error)) {
                    // Query was empty or a database error occurred
                    $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_order LIKE %s ORDER BY date DESC LIMIT 1", $order_id) );
                }
                break;
            case 'last_after':
                $hours = (isset($attribution['after_hours']) && is_numeric($attribution['after_hours'])) ? $attribution['after_hours'] : 72;
                $cutoff = gmdate("Y-m-d H:i:s", strtotime("-$hours hours"));

                // Check for source not equal direct && cutoff is not passed yet
                $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_order LIKE %s AND utm_source != %s AND utm_source != '' AND date >= %s ORDER BY date ASC LIMIT 1", $order_id, "direct", $cutoff ) );
                if($result) {
                    //error_log("order $order_id ima znotraj cutoffa, vzemamo first attribution ".$wpdb->last_query);
                }

                // Check for source not equal direct && cutoff is passed
                if (is_null($result) || ! empty($wpdb->last_error) || ! $result) {
                    //error_log("order $order_id nima nobenega znotraj cutoffa, vzemamo last attribution");
                    $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_order LIKE %s AND utm_source != %s AND utm_source != '' ORDER BY date DESC LIMIT 1", $order_id, "direct" ) );
                }

                // If not found, just select the first one, probably direct
                if (is_null($result) || ! empty($wpdb->last_error) || ! $result) {
                    //error_log("order $order_id nima nobenega s sourcom ki ni direct");
                    $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_order LIKE %s ORDER BY date ASC LIMIT 1", $order_id) );
                }
                break;
            default:
                $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_order LIKE %s AND utm_source != %s AND utm_source != '' ORDER BY date ASC LIMIT 1", $order_id, "direct" ) );
                if (is_null($result) || !empty($wpdb->last_error)) {
                    // Query was empty or a database error occurred
                    $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_meta WHERE id_order LIKE %s ORDER BY date ASC LIMIT 1", $order_id ) );
                }
                break;
        }

        if(count($result) > 0) {
            return $result;
        }

        $default = $this->getJourneyDefault($order_id);
        return $default;
    }

    /**
     * Insert user attribution to db
     *
     * @return mixed|false → inserts user meta to db
     */
    public function insertUserAttribution($hash, $campaign_name = null, $adset_name = null, $ad_name = null, $campaign_id = null, $adset_id = null, $ad_id = null) {
        global $wpdb;

        $date = gmdate('Y-m-d H:i:s');

        return $wpdb->insert($wpdb->prefix.'digit_tracking_user_attribution', array(
            'id_user' => sanitize_key($hash),
            'campaign_name' => sanitize_text_field($campaign_name),
            'adset_name' => sanitize_text_field($adset_name),
            'ad_name' => sanitize_text_field($ad_name),
            'campaign_id' => sanitize_text_field($campaign_id),
            'adset_id' => sanitize_text_field($adset_id),
            'ad_id' => sanitize_text_field($ad_id),
            'date' => $date
        ));
    }

    /**
     * Insert user attribution to db
     *
     * @return mixed|false → inserts user meta to db
     */
    public function insertUserPixelEvent($hash, $event, $id_attribution) {
        global $wpdb;

        $date = gmdate('Y-m-d H:i:s');

        return $wpdb->insert($wpdb->prefix.'digit_tracking_user_pixel_events', array(
            'id_user' => sanitize_key($hash),
            'event' => sanitize_text_field($event),
            'id_attribution' => sanitize_key($id_attribution),
            'date' => $date
        ));
    }

    /**
     * Get user attribution
     *
     * @return mixed|false → inserts user meta to db
     */
    public function getUserPixelEvent($hash, $event, $id_attribution) {
        global $wpdb;

        $standalone_options = get_option( 'standalone_option_config' );
        if(isset($standalone_options) && isset($standalone_options['cookie_lifetime']) && is_numeric($standalone_options['cookie_lifetime']))
            $days = $standalone_options['cookie_lifetime'];
        else
            $days = 7;

        $expired = strtotime("-$days days");

        $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_pixel_events WHERE id_user LIKE %s AND event LIKE %s AND id_attribution = %d", $hash, $event, $id_attribution ) );
        
        if($row && strtotime($row->date) > $expired ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get user attribution
     *
     * @return mixed|false → inserts user meta to db
     */
    public function getUserAttribution($hash, $campaign_name = null, $adset_name = null, $ad_name = null, $campaign_id = null, $adset_id = null, $ad_id = null) {
        global $wpdb;

        $standalone_options = get_option( 'standalone_option_config' );
        if(isset($standalone_options) && isset($standalone_options['cookie_lifetime']) && is_numeric($standalone_options['cookie_lifetime']))
            $days = $standalone_options['cookie_lifetime'];
        else
            $days = 7;

        $expired = strtotime("-$days days");

        $row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_user_attribution WHERE id_user LIKE %s AND campaign_name LIKE %s AND adset_name LIKE %s AND ad_name LIKE %s AND campaign_id LIKE %s AND adset_id LIKE %s AND ad_id LIKE %s", $hash, $campaign_name, $adset_name, $ad_name, $campaign_id, $adset_id, $ad_id ) );
        
        if($row && strtotime($row->date) > $expired ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get user attributions ids
     *
     * @return array|false → returns user attribution ids
     */
    public function getUserAttributions($hash) {
        global $wpdb;

        $standalone_options = get_option( 'standalone_option_config' );
        if(isset($standalone_options) && isset($standalone_options['cookie_lifetime']) && is_numeric($standalone_options['cookie_lifetime']))
            $days = $standalone_options['cookie_lifetime'];
        else
            $days = 7;

        $expired = strtotime("-$days days");

        $results = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}digit_tracking_user_attribution WHERE id_user LIKE %s AND DATE(date) >= %s", $hash, gmdate('Y-m-d', $expired) ) );
        
        if($results) {
            return $results;
        } else {
            return false;
        }
    }

    /**
     * Get SKU event
     * 
     * @return array|false
     */
    public function getSKUEvent($sku, $event) {
        global $wpdb;

        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}digit_tracking_sku_events WHERE sku LIKE %s AND event LIKE %s", $sku, $event ) );
        
        if($results) {
            return $results;
        } else {
            return false;
        }
    }

    /**
     * Insert SKU event
     * 
     * @return true|false
     */
    public function insertSKUEvent($post_id, $sku, $event) {
        global $wpdb;

        $date = gmdate('Y-m-d H:i:s');

        return $wpdb->insert($wpdb->prefix.'digit_tracking_sku_events', array(
            'post_id' => $post_id,
            'sku' => $sku,
            'event' => sanitize_text_field($event),
            'date' => $date
        ));
    }

    /**
     * Get products for Flores
     * 
     * @param int $page     The page number.
     * @param int $per_page The number of products per page.
     * @return array|false  An array of product data or false on failure.
     */
    public function getProductsOptimized($page, $per_page) {
        global $wpdb;

        // Calculate the limit and offset for pagination
        $limit = intval($per_page);
        $offset = ($page > 1) ? ($page - 1) * $limit : 0;

        // Prepare the SQL query
        $sql = $wpdb->prepare(
            "
            SELECT 
                p.ID AS post_id, 
                p.post_status, 
                m.meta_value AS associated_post_id,
                GROUP_CONCAT(o.meta_value SEPARATOR ',') AS old_slugs
            FROM 
                {$wpdb->prefix}posts p 
            LEFT JOIN 
                {$wpdb->prefix}postmeta m 
            ON 
                m.post_id = p.ID AND m.meta_key = '_associated_sku' 
            LEFT JOIN 
                {$wpdb->prefix}postmeta o
            ON 
                o.post_id = p.ID AND o.meta_key = '_wp_old_slug'
            WHERE 
                (p.post_type = %s OR p.post_type = %s) 
                OR (m.meta_value IS NOT NULL AND p.post_type != %s) 
            GROUP BY 
                p.ID, p.post_status, m.meta_value
            LIMIT 
                %d 
            OFFSET 
                %d
            ",
            'product', 
            'product_variation', 
            'shop_order', 
            $limit, 
            $offset
        );

        // Execute the query and get the results
        $results = $wpdb->get_results($sql);

        // Return the results or false if no results
        return $results ?: false;
    }

    /**
     * Get sku metrics for Flores
     * 
     * @return array|false
     */
    public function getSkuMetrics($key, $date) {
        global $wpdb;

        $results = $wpdb->get_results( $wpdb->prepare( "SELECT sku, count(id) AS num FROM {$wpdb->prefix}digit_tracking_sku_events WHERE DATE(date) = %s AND event = %s GROUP BY sku", $date, $key ) );

        if($results) {
            return $results;
        } else {
            return false;
        }
    }
}