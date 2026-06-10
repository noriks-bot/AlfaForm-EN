<?php

/**
 * Status page - database check
 *
 * @link       https://noriks.com
 * @since      3.1.0
 *
 * @package    Flores_Woocommerce
 * @subpackage Flores_Woocommerce/admin/partials
 */

class Flores_Woocommerce_Status_Manager {

    protected $tables = [
        'digit_tracking_user_meta',
        'digit_tracking_user_attribution',
        'digit_tracking_user_pixel_events',
        'digit_tracking_sku_events'
    ];

    public function test_databases() {
        global $wpdb;

        ?>
        <h4><?php _e("Plugin-dependant databases status", "flores-woocommerce") ?></h4>
        <?php

        foreach($this->tables as $table_name) {
            $full_table_name = $wpdb->prefix.$table_name;
            $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $full_table_name ) );

            if ( ! $wpdb->get_var( $query ) == $full_table_name ) {
                ?>
                <p class="flx-error"><?php echo str_replace("digit_", "", $table_name).' '.__("is missing", "flores-woocommerce") ?>!</p>
                <?php
            } else {
                ?>
                <p class="flx-success"><?php echo str_replace("digit_", "", $table_name).' '.__("is OK", "flores-woocommerce") ?>!</p>
                <?php
            }
        }
    }
}
?>
