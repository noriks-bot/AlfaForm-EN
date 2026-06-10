<?php
/**
 * Settings for OpenAI Product Feed
 *
 * @package AdTribes/WooCommerce SEA
 * @since   13.4.9
 */

/**
 * Class WooSEA_openai
 *
 * Handles the OpenAI Product Feed Specification channel configuration.
 * Provides attribute definitions for generating OpenAI-compliant product feeds.
 */
class WooSEA_openai { // phpcs:ignore

    /**
     * OpenAI attributes
     *
     * @var array
     */
    public $openai_attributes;

    /**
     * Get the channel attributes
     *
     * Returns a structured array defining all fields for the OpenAI feed,
     * their properties, and default WooCommerce mappings based on the
     * OpenAI Product Feed Specification.
     *
     * @return array Array of channel attributes organized by sections
     */
    public static function get_channel_attributes() {
        $openai_attributes = array(
            'Basic Product Data'     => array(
                'Product ID'          => array(
                    'name'        => 'id',
                    'feed_name'   => 'id',
                    'format'      => 'required',
                    'woo_suggest' => 'id',
                ),
                'Product Title'       => array(
                    'name'        => 'title',
                    'feed_name'   => 'title',
                    'format'      => 'required',
                    'woo_suggest' => 'title',
                ),
                'Product Description' => array(
                    'name'        => 'description',
                    'feed_name'   => 'description',
                    'format'      => 'required',
                    'woo_suggest' => 'description',
                ),
                'Product URL'         => array(
                    'name'        => 'link',
                    'feed_name'   => 'link',
                    'format'      => 'required',
                    'woo_suggest' => 'link',
                ),
                'GTIN'                => array(
                    'name'        => 'gtin',
                    'feed_name'   => 'gtin',
                    'format'      => 'required',
                    'woo_suggest' => 'gtin',
                ),
                'MPN'                 => array(
                    'name'        => 'mpn',
                    'feed_name'   => 'mpn',
                    'format'      => 'required',
                    'woo_suggest' => 'mpn',
                ),
            ),
            'Media'                  => array(
                'Main Image URL'       => array(
                    'name'        => 'image_link',
                    'feed_name'   => 'image_link',
                    'format'      => 'required',
                    'woo_suggest' => 'image',
                ),
                'Additional Image URL' => array(
                    'name'        => 'additional_image_link',
                    'feed_name'   => 'additional_image_link',
                    'format'      => 'recommended',
                    'woo_suggest' => 'image_1',
                ),
                'Video Link'           => array(
                    'name'      => 'video_link',
                    'feed_name' => 'video_link',
                    'format'    => 'optional',
                ),
                '3D Model Link'        => array(
                    'name'      => 'model_3d_link',
                    'feed_name' => 'model_3d_link',
                    'format'    => 'optional',
                ),
            ),
            'Pricing & Availability' => array(
                'Price'                     => array(
                    'name'        => 'price',
                    'feed_name'   => 'price',
                    'format'      => 'required',
                    'woo_suggest' => 'price',
                    'suffix'      => ' {{CURRENCY}}',
                ),
                'Applicable Taxes Fees'     => array(
                    'name'      => 'applicable_taxes_fees',
                    'feed_name' => 'applicable_taxes_fees',
                    'format'    => 'optional',
                ),
                'Sale Price'                => array(
                    'name'        => 'sale_price',
                    'feed_name'   => 'sale_price',
                    'format'      => 'recommended',
                    'woo_suggest' => 'sale_price',
                ),
                'Sale Price Effective Date' => array(
                    'name'      => 'sale_price_effective_date',
                    'feed_name' => 'sale_price_effective_date',
                    'format'    => 'optional',
                ),
                'Stock Status'              => array(
                    'name'        => 'availability',
                    'feed_name'   => 'availability',
                    'format'      => 'required',
                    'woo_suggest' => 'availability',
                ),
                'Availability Date'         => array(
                    'name'      => 'availability_date',
                    'feed_name' => 'availability_date',
                    'format'    => 'optional',
                ),
                'Inventory Quantity'        => array(
                    'name'        => 'inventory_quantity',
                    'feed_name'   => 'inventory_quantity',
                    'format'      => 'required',
                    'woo_suggest' => 'quantity',
                ),
                'Expiration Date'           => array(
                    'name'      => 'expiration_date',
                    'feed_name' => 'expiration_date',
                    'format'    => 'optional',
                ),
                'Pickup Method'             => array(
                    'name'      => 'pickup_method',
                    'feed_name' => 'pickup_method',
                    'format'    => 'optional',
                ),
                'Pickup SLA'                => array(
                    'name'      => 'pickup_sla',
                    'feed_name' => 'pickup_sla',
                    'format'    => 'optional',
                ),
                'Price Effective Date'      => array(
                    'name'      => 'price_effective_date',
                    'feed_name' => 'price_effective_date',
                    'format'    => 'optional',
                ),
                'Cost of Goods Sold'        => array(
                    'name'      => 'cost_of_goods_sold',
                    'feed_name' => 'cost_of_goods_sold',
                    'format'    => 'optional',
                ),
                'Unit Pricing Measure'      => array(
                    'name'      => 'unit_pricing_measure',
                    'feed_name' => 'unit_pricing_measure',
                    'format'    => 'optional',
                ),
                'Pricing Trend'             => array(
                    'name'      => 'pricing_trend',
                    'feed_name' => 'pricing_trend',
                    'format'    => 'optional',
                ),

            ),
            'Item Information'       => array(
                'Product Category' => array(
                    'name'        => 'product_category',
                    'feed_name'   => 'product_category',
                    'format'      => 'required',
                    'woo_suggest' => 'category_path',
                ),
                'Brand'            => array(
                    'name'        => 'brand',
                    'feed_name'   => 'brand',
                    'format'      => 'required',
                    'woo_suggest' => 'product_brand',
                ),
                'Condition'        => array(
                    'name'        => 'condition',
                    'feed_name'   => 'condition',
                    'format'      => 'recommended',
                    'woo_suggest' => 'condition',
                ),
                'Weight'           => array(
                    'name'        => 'weight',
                    'feed_name'   => 'weight',
                    'format'      => 'required',
                    'woo_suggest' => 'weight',
                ),
                'Dimensions'       => array(
                    'name'        => 'dimensions',
                    'feed_name'   => 'dimensions',
                    'format'      => 'optional',
                    'woo_suggest' => 'dimensions',
                ),
                'Length'           => array(
                    'name'        => 'length',
                    'feed_name'   => 'length',
                    'format'      => 'optional',
                    'woo_suggest' => 'length',
                ),
                'Width'            => array(
                    'name'        => 'width',
                    'feed_name'   => 'width',
                    'format'      => 'optional',
                    'woo_suggest' => 'width',
                ),
                'Height'           => array(
                    'name'        => 'height',
                    'feed_name'   => 'height',
                    'format'      => 'optional',
                    'woo_suggest' => 'height',
                ),
                'Material'         => array(
                    'name'        => 'material',
                    'feed_name'   => 'material',
                    'format'      => 'required',
                    'woo_suggest' => 'static_value:Unknown',
                ),
                'Age Group'        => array(
                    'name'      => 'age_group',
                    'feed_name' => 'age_group',
                    'format'    => 'recommended',
                ),
            ),
            'OpenAI Flags'           => array(
                'Enable Search'   => array(
                    'name'        => 'enable_search',
                    'feed_name'   => 'enable_search',
                    'format'      => 'required',
                    'woo_suggest' => 'boolean_true',
                ),
                'Enable Checkout' => array(
                    'name'        => 'enable_checkout',
                    'feed_name'   => 'enable_checkout',
                    'format'      => 'required',
                    'woo_suggest' => 'boolean_false',
                ),
            ),
            'Variants'               => array(
                'Item Group ID'             => array(
                    'name'        => 'item_group_id',
                    'feed_name'   => 'item_group_id',
                    'format'      => 'required',
                    'woo_suggest' => 'item_group_id',
                ),
                'Color'                     => array(
                    'name'        => 'color',
                    'feed_name'   => 'color',
                    'format'      => 'recommended',
                    'woo_suggest' => 'color',
                ),
                'Size'                      => array(
                    'name'        => 'size',
                    'feed_name'   => 'size',
                    'format'      => 'recommended',
                    'woo_suggest' => 'size',
                ),
                'Gender'                    => array(
                    'name'        => 'gender',
                    'feed_name'   => 'gender',
                    'format'      => 'recommended',
                    'woo_suggest' => 'gender',
                ),
                'Size System'               => array(
                    'name'      => 'size_system',
                    'feed_name' => 'size_system',
                    'format'    => 'recommended',
                ),
                'Item Group Title'          => array(
                    'name'      => 'item_group_title',
                    'feed_name' => 'item_group_title',
                    'format'    => 'optional',
                ),
                'Offer ID'                  => array(
                    'name'      => 'offer_id',
                    'feed_name' => 'offer_id',
                    'format'    => 'recommended',
                ),
                'Custom Variant 1 Category' => array(
                    'name'      => 'Custom_variant1_category',
                    'feed_name' => 'Custom_variant1_category',
                    'format'    => 'optional',
                ),
                'Custom Variant 1 Option'   => array(
                    'name'      => 'Custom_variant1_option',
                    'feed_name' => 'Custom_variant1_option',
                    'format'    => 'optional',
                ),
                'Custom Variant 2 Category' => array(
                    'name'      => 'Custom_variant2_category',
                    'feed_name' => 'Custom_variant2_category',
                    'format'    => 'optional',
                ),
                'Custom Variant 2 Option'   => array(
                    'name'      => 'Custom_variant2_option',
                    'feed_name' => 'Custom_variant2_option',
                    'format'    => 'optional',
                ),
                'Custom Variant 3 Category' => array(
                    'name'      => 'Custom_variant3_category',
                    'feed_name' => 'Custom_variant3_category',
                    'format'    => 'optional',
                ),
                'Custom Variant 3 Option'   => array(
                    'name'      => 'Custom_variant3_option',
                    'feed_name' => 'Custom_variant3_option',
                    'format'    => 'optional',
                ),
            ),
            'Fulfillment'            => array(
                'Shipping'          => array(
                    'name'        => 'shipping',
                    'feed_name'   => 'shipping',
                    'format'      => 'required',
                    'woo_suggest' => 'shipping',
                ),
                'Delivery Estimate' => array(
                    'name'      => 'delivery_estimate',
                    'feed_name' => 'delivery_estimate',
                    'format'    => 'optional',
                ),
            ),
            'Merchant Info'          => array(
                'Seller Name'             => array(
                    'name'        => 'seller_name',
                    'feed_name'   => 'seller_name',
                    'format'      => 'required',
                    'woo_suggest' => 'site_title',
                ),
                'Seller URL'              => array(
                    'name'        => 'seller_url',
                    'feed_name'   => 'seller_url',
                    'format'      => 'required',
                    'woo_suggest' => 'shop_url',
                ),
                'Seller Privacy Policy'   => array(
                    'name'        => 'seller_privacy_policy',
                    'feed_name'   => 'seller_privacy_policy',
                    'format'      => 'required',
                    'woo_suggest' => 'privacy_policy_page_url',
                ),
                'Seller Terms of Service' => array(
                    'name'        => 'seller_tos',
                    'feed_name'   => 'seller_tos',
                    'format'      => 'required',
                    'woo_suggest' => 'terms_condtion_page_url',
                ),
            ),
            'Returns'                => array(
                'Return Policy' => array(
                    'name'        => 'return_policy',
                    'feed_name'   => 'return_policy',
                    'format'      => 'required',
                    'woo_suggest' => 'page:',
                ),
                'Return Window' => array(
                    'name'        => 'return_window',
                    'feed_name'   => 'return_window',
                    'format'      => 'required',
                    'woo_suggest' => 'static_value:',
                ),
            ),
            'Reviews and Q&A'        => array(
                'Product Review Count'  => array(
                    'name'      => 'product_review_count',
                    'feed_name' => 'product_review_count',
                    'format'    => 'recommended',
                ),
                'Product Review Rating' => array(
                    'name'      => 'product_review_rating',
                    'feed_name' => 'product_review_rating',
                    'format'    => 'recommended',
                ),
                'Store Review Count'    => array(
                    'name'      => 'store_review_count',
                    'feed_name' => 'store_review_count',
                    'format'    => 'optional',
                ),
                'Store Review Rating'   => array(
                    'name'      => 'store_review_rating',
                    'feed_name' => 'store_review_rating',
                    'format'    => 'optional',
                ),
                'Q and A'               => array(
                    'name'      => 'q_and_a',
                    'feed_name' => 'q_and_a',
                    'format'    => 'recommended',
                ),
                'Raw Review Data'       => array(
                    'name'      => 'raw_review_data',
                    'feed_name' => 'raw_review_data',
                    'format'    => 'recommended',
                ),
            ),
            'Performance Signals'    => array(
                'Popularity Score' => array(
                    'name'      => 'popularity_score',
                    'feed_name' => 'popularity_score',
                    'format'    => 'recommended',
                ),
                'Return Rate'      => array(
                    'name'      => 'return_rate',
                    'feed_name' => 'return_rate',
                    'format'    => 'recommended',
                ),
            ),
            'Related Products'       => array(
                'Related Product ID' => array(
                    'name'      => 'related_product_id',
                    'feed_name' => 'related_product_id',
                    'format'    => 'recommended',
                ),
                'Relationship Type'  => array(
                    'name'      => 'relationship_type',
                    'feed_name' => 'relationship_type',
                    'format'    => 'recommended',
                ),
            ),
            'Geo Tagging'            => array(
                'Geo Price'        => array(
                    'name'      => 'geo_price',
                    'feed_name' => 'geo_price',
                    'format'    => 'recommended',
                ),
                'Geo Availability' => array(
                    'name'      => 'geo_availability',
                    'feed_name' => 'geo_availability',
                    'format'    => 'recommended',
                ),
            ),
            'Compliance'             => array(
                'Warning / Warning URL' => array(
                    'name'      => 'warning',
                    'feed_name' => 'warning',
                    'format'    => 'recommended',
                ),
                'Age Restriction'       => array(
                    'name'      => 'age_restriction',
                    'feed_name' => 'age_restriction',
                    'format'    => 'recommended',
                ),
            ),
        );

        return apply_filters( 'adt_openai_channel_attributes', $openai_attributes );
    }
}
