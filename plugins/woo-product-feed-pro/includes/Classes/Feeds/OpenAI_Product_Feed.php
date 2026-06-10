<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes\Feeds
 */

namespace AdTribes\PFP\Classes\Feeds;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * Google Product Review class.
 *
 * @since 13.4.9
 */
class OpenAI_Product_Feed extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Feed type.
     *
     * @since 13.4.9
     *
     * @var string
     */
    protected $feed_type = 'openai_product_feed';

    /**
     * Required OpenAI feed fields and their safe empty defaults.
     *
     * These fields must be present in every product object even when the mapped
     * WooCommerce value is empty or the user has not yet configured a static value.
     * The defaults ensure the field key exists in the JSONL output so OpenAI does
     * not reject the feed for a missing required attribute.
     *
     * @since 13.5.2.2
     *
     * @var array<string,mixed>
     */
    protected $required_field_defaults = array(
        'weight'             => '',
        'inventory_quantity' => 0,
        'seller_tos'         => '',
        'return_policy'      => '',
        'return_window'      => '',
    );


    /**
     * Handle the XML attribute.
     *
     * @since 13.4.9
     *
     * @param bool   $handled If returned true, skip all default processing for this key.
     * @param object $xml_product The XML product element object.
     * @param string $attribute The attribute key/name.
     * @param string $value The attribute value.
     * @param array  $feed_config The feed configuration array.
     * @param array  $channel_attributes The channel attributes array.
     * @param object $feed               The feed object.
     * @return bool If returned true, skip all default processing for this key.
     */
    public function handle_xml_attribute( $handled, $xml_product, $attribute, $value, $feed_config, $channel_attributes, $feed ) {
        if ( ! isset( $feed_config['fields'] ) || 'openai' !== $feed_config['fields'] ) {
            return $handled;
        }

        if ( 'shipping' === $attribute ) {
            $this->write_shipping_attribute( $xml_product, $value );
            $handled = true;
        }

        return $handled;
    }

    /**
     * Write the shipping attribute.
     * Format: country:region:service_class:price
     * Multiple entries separated by semicolons (;).
     *
     * @since 13.4.9
     *
     * @param object $xml_product The XML element object.
     * @param string $value The attribute value.
     */
    private function write_shipping_attribute( $xml_product, $value ) {
        if ( empty( $value ) ) {
            return;
        }

        /**
         * Example input value:
         * "WOOSEA_COUNTRY##VN:WOOSEA_SERVICE##Vietnam Shipping Test:WOOSEA_PRICE##AUD 12.60||WOOSEA_COUNTRY##US:WOOSEA_REGION##CA:WOOSEA_SERVICE##Overnight:WOOSEA_PRICE##USD 16.00"
         *
         * Expected output format per OpenAI spec:
         * "VN::Vietnam Shipping Test:AUD 12.60;US:CA:Overnight:USD 16.00"
         */

        $shipping_entries = array();
        $shipping_array   = explode( '||', $value );

        foreach ( $shipping_array as $shipping ) {
            $country = '';
            $region  = '';
            $service = '';
            $price   = '';

            // Parse each component from the internal format.
            $shipping_pieces = explode( ':', $shipping );

            foreach ( $shipping_pieces as $piece ) {
                if ( strpos( $piece, 'WOOSEA_COUNTRY##' ) !== false ) {
                    $country = str_replace( 'WOOSEA_COUNTRY##', '', $piece );
                } elseif ( strpos( $piece, 'WOOSEA_REGION##' ) !== false ) {
                    $region = str_replace( 'WOOSEA_REGION##', '', $piece );
                } elseif ( strpos( $piece, 'WOOSEA_SERVICE##' ) !== false ) {
                    $service = str_replace( 'WOOSEA_SERVICE##', '', $piece );
                } elseif ( strpos( $piece, 'WOOSEA_PRICE##' ) !== false ) {
                    $price = str_replace( 'WOOSEA_PRICE##', '', $piece );
                }
            }

            // Build the OpenAI format: country:region:service_class:price.
            // Note: region is optional, so we include it even if empty.
            $formatted_entry = sprintf(
                '%s:%s:%s:%s',
                $country,
                $region,
                $service,
                $price
            );

            $shipping_entries[] = $formatted_entry;
        }

        // Join multiple entries with semicolons as per OpenAI spec.
        $shipping_value = implode( ';', $shipping_entries );

        // Add as a simple text child element, not nested XML.
        $xml_product->addChild( 'shipping', htmlspecialchars( $shipping_value, ENT_XML1, 'UTF-8' ) );
    }

    /**
     * Format the availability.
     *
     * @since 13.4.9
     *
     * @param string $availability The availability value.
     * @param object $product The product object.
     * @param array  $feed_channel The feed channel array.
     * @return string The availability value.
     */
    public function format_availability( $availability, $product, $feed_channel ) {
        if ( 'openai' !== $feed_channel['fields'] ) {
            return $availability;
        }

        $wc_to_openai_availability_format = array(
            \Automattic\WooCommerce\Enums\ProductStockStatus::IN_STOCK     => 'in_stock',
            \Automattic\WooCommerce\Enums\ProductStockStatus::OUT_OF_STOCK => 'out_of_stock',
            \Automattic\WooCommerce\Enums\ProductStockStatus::ON_BACKORDER => 'preorder',
        );

        return $wc_to_openai_availability_format[ $product->get_stock_status() ] ?? $availability;
    }

    /**
     * Register OpenAI as a platform that requires pure plain text.
     *
     * This makes Sanitization::sanitize_html_content() route title, description,
     * and similar fields through convert_to_pure_plain_text() — which strips HTML
     * tags and decodes HTML entities — instead of convert_to_plain_text() which
     * re-encodes entities with htmlentities() for XML compatibility.
     *
     * @since 13.5.2.2
     *
     * @param array $platforms Platform slugs requiring pure plain text.
     * @return array
     */
    public function register_pure_plain_text_platform( $platforms ) {
        $platforms[] = 'openai';
        return $platforms;
    }

    /**
     * Transform an OpenAI JSONL product array before it is written to the feed file.
     *
     * Handles three concerns specific to the JSONL path:
     * 1. Shipping — converts internal WOOSEA_COUNTRY##/… marker strings into
     *    an array of structured shipping objects.
     * 2. HTML entities — decodes any remaining entities (e.g. &gt; in
     *    product_category which is built outside sanitize_html_content()).
     *    Fields like title and description are already clean plain text at this
     *    point because OpenAI is registered as a pure-plain-text platform.
     * 3. Required field defaults — ensures every required field is present in the
     *    output even when the product has no mapped value.
     *
     * @since 13.5.2.2
     *
     * @param array  $product_data The product key/value array being built for JSONL.
     * @param array  $feed_channel The active channel configuration array.
     * @param object $feed         The feed object.
     * @return array
     */
    public function transform_jsonl_product( $product_data, $feed_channel, $feed ) {
        if ( ! isset( $feed_channel['fields'] ) || 'openai' !== $feed_channel['fields'] ) {
            return $product_data;
        }

        // 1. Transform shipping field from internal marker format to array of objects.
        if ( ! empty( $product_data['shipping'] ) ) {
            $product_data['shipping'] = $this->parse_shipping_for_jsonl( $product_data['shipping'] );
        }

        // 2. Decode any remaining HTML entities in string values.
        // (title/description are already plain text via convert_to_pure_plain_text();
        // this covers fields like product_category that are built outside sanitize_html_content().)
        foreach ( $product_data as $key => $value ) {
            if ( is_string( $value ) ) {
                $product_data[ $key ] = html_entity_decode( $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
            }
        }

        // 3. Ensure every required field is present; use the registered default when absent.
        foreach ( $this->required_field_defaults as $field => $default ) {
            if ( ! array_key_exists( $field, $product_data ) ) {
                $product_data[ $field ] = $default;
            }
        }

        return $product_data;
    }

    /**
     * Decode HTML entities in OpenAI CSV row data.
     *
     * For CSV.GZ format, fields like product_category carry HTML entities
     * (e.g. &gt; as the category separator) that are not decoded by the
     * sanitize_html_content() pipeline. This filter decodes all entity-encoded
     * values in the row so the CSV output is clean plain text.
     *
     * @since 13.5.2.2
     *
     * @param array  $pieces_row            The indexed array of CSV cell values for this row.
     * @param array  $old_attributes_config The feed attribute mapping configuration.
     * @param array  $product_data          The full product data array.
     * @param object $feed                  The feed object.
     * @return array
     */
    public function handle_csv_row_data( $pieces_row, $old_attributes_config, $product_data, $feed ) {
        if ( 'openai' !== $feed->get_channel( 'fields' ) ) {
            return $pieces_row;
        }

        return array_map(
            function ( $value ) {
                return is_string( $value ) ? html_entity_decode( $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) : $value;
            },
            $pieces_row
        );
    }

    /**
     * Parse a raw internal shipping string into an array of structured shipping objects.
     *
     * Reuses the same token parsing as write_shipping_attribute() but returns an
     * array of associative arrays rather than a semicolon-delimited string, which
     * is correct for JSON serialisation.
     *
     * @since 13.5.2
     *
     * @param string $value Raw shipping value in WOOSEA_COUNTRY##…:WOOSEA_SERVICE##…:… format,
     *                      with multiple entries separated by '||'.
     * @return array Array of shipping entry objects, each with 'country', 'service', 'price'
     *               and optionally 'region' keys.
     */
    private function parse_shipping_for_jsonl( $value ) {
        $shipping_entries = array();
        $shipping_array   = explode( '||', $value );

        foreach ( $shipping_array as $shipping ) {
            $country = '';
            $region  = '';
            $service = '';
            $price   = '';

            $shipping_pieces = explode( ':', $shipping );

            foreach ( $shipping_pieces as $piece ) {
                if ( strpos( $piece, 'WOOSEA_COUNTRY##' ) !== false ) {
                    $country = str_replace( 'WOOSEA_COUNTRY##', '', $piece );
                } elseif ( strpos( $piece, 'WOOSEA_REGION##' ) !== false ) {
                    $region = str_replace( 'WOOSEA_REGION##', '', $piece );
                } elseif ( strpos( $piece, 'WOOSEA_SERVICE##' ) !== false ) {
                    $service = str_replace( 'WOOSEA_SERVICE##', '', $piece );
                } elseif ( strpos( $piece, 'WOOSEA_PRICE##' ) !== false ) {
                    $price = str_replace( 'WOOSEA_PRICE##', '', $piece );
                }
            }

            $entry = array( 'country' => $country );
            if ( ! empty( $region ) ) {
                $entry['region'] = $region;
            }
            $entry['service'] = $service;
            $entry['price']   = $price;

            $shipping_entries[] = $entry;
        }

        return $shipping_entries;
    }

    /**
     * Run the class.
     *
     * @since 13.4.9
     */
    public function run() {
        add_filter( 'adt_product_feed_xml_attribute_handling', array( $this, 'handle_xml_attribute' ), 10, 7 );
        add_filter( 'adt_product_data_availability_format', array( $this, 'format_availability' ), 10, 3 );
        add_filter( 'adt_product_feed_jsonl_product', array( $this, 'transform_jsonl_product' ), 10, 3 );
        add_filter( 'adt_product_feed_platform_requires_pure_plain_text_fields', array( $this, 'register_pure_plain_text_platform' ), 10, 1 );
        add_filter( 'adt_product_feed_csv_row_data', array( $this, 'handle_csv_row_data' ), 10, 4 );
    }
}
