<?php

/**
 * Settings for Google Local Product Inventory feeds
 */
class WooSEA_google_local { // phpcs:ignore

    /**
     * Google Local Product Inventory fields.
     *
     * @var array
     */
    public $google_local;

    /**
     * Get the channel attributes.
     *
     * @return array
     */
    public static function get_channel_attributes() {

        $google_local = array(
            'Local product inventory fields' => array(
                'Itemid'                    => array(
                    'name'        => 'id',
                    'feed_name'   => 'g:id',
                    'format'      => 'required',
                    'woo_suggest' => 'id',
                ),
                'Store code'                => array(
                    'name'      => 'Store code',
                    'feed_name' => 'g:store_code',
                    'format'    => 'required',
                ),
                'Availability'              => array(
                    'name'        => 'Availability',
                    'feed_name'   => 'g:availability',
                    'format'      => 'required',
                    'woo_suggest' => 'availability',
                ),
                'Price'                     => array(
                    'name'        => 'Price',
                    'feed_name'   => 'g:price',
                    'format'      => 'required',
                    'woo_suggest' => 'price',
                    'suffix'      => ' {{CURRENCY}}',
                ),
                'Sale price'                => array(
                    'name'        => 'Sale price',
                    'feed_name'   => 'g:sale_price',
                    'format'      => 'optional',
                    'woo_suggest' => 'sale_price',
                ),
                'Sale price effective date' => array(
                    'name'        => 'Sale price effective date',
                    'feed_name'   => 'g:sale_price_effective_date',
                    'format'      => 'optional',
                    'woo_suggest' => 'sale_price_effective_date',
                ),
                'Quantity'                  => array(
                    'name'        => 'Quantity',
                    'feed_name'   => 'g:quantity',
                    'format'      => 'optional',
                    'woo_suggest' => 'quantity',
                ),
                'Weeks of supply'           => array(
                    'name'      => 'Weeks of supply',
                    'feed_name' => 'g:weeks_of_supply',
                    'format'    => 'optional',
                ),
                'Pickup method'             => array(
                    'name'      => 'Pickup method',
                    'feed_name' => 'g:pickup_method',
                    'format'    => 'optional',
                ),
                'Pickup sla'                => array(
                    'name'      => 'Pickup sla',
                    'feed_name' => 'g:pickup_sla',
                    'format'    => 'optional',
                ),
                'Webitemid'                 => array(
                    'name'      => 'Webitemid',
                    'feed_name' => 'g:webitemid',
                    'format'    => 'optional',
                ),
            ),
        );
        return $google_local;
    }
}
