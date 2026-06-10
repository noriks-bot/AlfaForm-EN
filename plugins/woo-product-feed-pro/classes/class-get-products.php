<?php
//phpcs:disable
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Classes\Shipping_Data;
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Helpers\Formatting;
use AdTribes\PFP\Helpers\Sanitization;

/**
 * Class for generating the actual feeds
 */
class WooSEA_Get_Products {

    /**
     * File format.
     *
     * @var string
     */
    public $file_format;

    /**
     * Constructor
     */
    public function __construct() {
        $this->file_format = '';
    }

    /**
     * Function to sanitize HTML strings.
     * This function will remove all HTML tags from the string.
     *
     * @access public
     * @since 13.3.5.4
     * 
     * @deprecated Use AdTribes\PFP\Helpers\Sanitization::sanitize_html_content() instead.
     *             Keeping this function for backwards compatibility for Elite plugin.
     *
     * @param string $string The string to sanitize.
     * @return string The sanitized string.
     */
    public function woosea_sanitize_html( $string ) {
        if ( ! empty( $string ) ) {
            // Remove script and style tags and their content from the string.
            $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );

            // Strip out Visual Composer raw HTML shortcodes
            $string = preg_replace( '/\[vc_raw_html.*\[\/vc_raw_html\]/', '', $string );

            // Replace tags by space rather than deleting them, first we add a space before the tag, then we strip the tags.
            // This is to prevent words from sticking together.
            $string = str_replace('<', ' <', $string);

            // Remove shortcodes from the string.
            $string = do_shortcode( $string );

            // Remove any remaining shortcodes if any.
            $string = preg_replace( '/\[(.*?)\]/', ' ', $string );
            
            // Remove tags from the string.
            $string = strip_tags( $string );

            // Convert special characters.
            $string = htmlentities( $string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_XML1, 'UTF-8', false );

            // Remove new line breaks and non-breaking spaces
            $string = str_replace( array( "\r", "\n", '&#xa0;' ), '', $string );
        }
        return $string;
    }

    /**
     * Get all approved product review comments for Google's Product Review Feeds
     */
    public function woosea_get_reviews( $product_data, $product, $feed ) {
        // Reviews for the parent variable product itself can be skipped, the review is added for the variation
        if ( $product_data['product_type'] == 'variable' ) {
            return;
        }

        $approved_reviews = array();
        $prod_id          = $product_data['id'];

        if ( $product_data['product_type'] == 'variation' ) {
            $prod_id = $product_data['item_group_id'];
        }

        $reviews = get_comments(
            array(
                'post_id'          => $prod_id,
                'comment_type'     => 'review',
                'comment_approved' => 1,
                'parent'           => 0,
            )
        );

        // Loop through all product reviews for this specific products (ternary operators)
        foreach ( $reviews as $review_raw ) {

            $review                          = array();
            $review['review_reviewer_image'] = empty( $product_data['reviewer_image'] ) ? '' : $product_data['reviewer_image'];
            $review['review_ratings']        = get_comment_meta( $review_raw->comment_ID, 'rating', true );
            $review['review_id']             = $review_raw->comment_ID;

            $user   = ! empty( $review_raw->user_id ) ? get_userdata( $review_raw->user_id ) : false;
            $author = '';

            if ( ! empty( $user ) ) {
                if ( ! empty( $user->first_name ) ) {
                    $author  = $user->first_name ?? '';
                    $author .= ! empty( $user->last_name ) ? ' ' . substr( $user->last_name, 0, 1 ) . '.' : '';
                } else {
                    // If first name is empty, try to use last name then display name.
                    $author = ! empty( $user->last_name ) ? $user->last_name : $user->display_name;
                }
            } elseif ( ! empty( $review_raw->comment_author ) ) {
                $author = $review_raw->comment_author;

                if ( str_contains( $author, ' ' ) ) {
                    $expl_author = explode( ' ', $author );
                    if ( ! empty( $expl_author ) && is_array( $expl_author ) ) {
                        $sliced_author  = array_slice( $expl_author, 0, 2 );
                        $author         = $sliced_author[0] ?? '';
                        $author        .= ! empty( $sliced_author[1] ) ? ' ' . substr( $sliced_author[1], 0, 1 ) . '.' : '';
                    }
                }
            } else {
                $author = 'Anonymous';
            }

            $author = str_replace( '&amp;', '', $author );
            $author = ! empty( $author ) ? ucfirst( $author ) : $author;

            // Remove strange charachters from reviewer name
            $review['reviewer_name'] = Sanitization::sanitize_html_content( $author, $feed );
            $review['reviewer_name'] = preg_replace( '/\[(.*?)\]/', ' ', $review['reviewer_name'] );
            $review['reviewer_name'] = str_replace( '&#xa0;', '', $review['reviewer_name'] );
            $review['reviewer_name'] = str_replace( ':', '', $review['reviewer_name'] );

            $review['reviewer_id']      = $review_raw->user_id;
            $review['review_timestamp'] = $review_raw->comment_date;

            // Remove strange characters from review title
            $review['title'] = empty( $product_data['title'] ) ? '' : $product_data['title'];
            $review['title'] = Sanitization::sanitize_html_content( $review['title'], $feed );
            $review['title'] = preg_replace( '/\[(.*?)\]/', ' ', $review['title'] );
            $review['title'] = str_replace( '&#xa0;', '', $review['title'] );

            // Remove strange charchters from review content
            $review['content'] = $review_raw->comment_content;
            $review['content'] = Sanitization::sanitize_html_content( $review['content'], $feed );
            $review['content'] = preg_replace( '/\[(.*?)\]/', ' ', $review['content'] );
            $review['content'] = str_replace( '&#xa0;', '', $review['content'] );

            $review['review_product_name'] = $product_data['title'];
            $review['review_url']          = $product_data['link'] . '#tab-reviews';
            $review['review_product_url']  = $product_data['link'];
            array_push( $approved_reviews, $review );
        }
        $review_count   = $product->get_review_count();
        $review_average = $product->get_average_rating();
        return $approved_reviews;
    }

    /**
     * Function that will create an append with Google Analytics UTM parameters
     * Removes UTM paramaters that are left blank
     */
    public function woosea_append_utm_code( $feed, $productId, $parentId, $link ) {
        $utm_part = '';

        // GA tracking is disabled, so remove from array
        if ( $feed->utm_enabled ) {
            $channel_field = $feed->get_channel( 'fields' );
            if ( empty( $channel_field ) ) {
                return '';
            }

            // Create Array of Google Analytics UTM codes
            $utm = array(
                // 'adTribesID' => $adtribesConvId,
                'utm_source'   => $feed->utm_source,
                'utm_campaign' => $feed->utm_campaign,
                'utm_medium'   => $feed->utm_medium,
                'utm_term'     => 'adtribes', // Always use hardcoded value, ignore any legacy utm_term values
                'utm_content'  => $feed->utm_content,
            );
            $utm = array_filter( $utm ); // Filter out empty or NULL values from UTM array.

            /**
             * Filter the UTM code to append to the product feed.
             *
             * @since 13.4.7
             *
             * @param array $utm The UTM code to append to the product feed
             * @param object $feed The feed object
             * @param int $productId The product ID
             * @param int $parentId The parent product ID
             * @param string $link The product link
             */
            $utm = apply_filters( 'adt_product_feed_utm_code_array', $utm, $feed, $productId, $parentId, $link );

            foreach ( $utm as $key => $value ) {
                $value = str_replace( ' ', '%20', $value );
                $utm_part .= "&$key=$value";
            }

            if ( preg_match( '/\?/i', $link ) ) {
                $utm_part = '&' . ltrim( $utm_part, '&amp;' );
            } else {
                $utm_part = '?' . ltrim( $utm_part, '&amp;' );
            }

            /**
             * Filter to append UTM code to the product feed.
             *
             * @since 13.3.5
             *
             * @param string $utm_part The UTM code to append to the product feed
             * @param object $feed The feed object
             * @param int $productId The product ID
             * @param int $parentId The parent product ID
             * @param string $link The product link
             */
            return apply_filters( 'adt_product_feed_append_utm_code', $utm_part, $feed, $productId, $parentId, $link );
        }
    }

    /**
     * Converts an ordinary xml string into a CDATA string
     */
    public function woosea_convert_to_cdata( $string ) {
        return "<![CDATA[ $string ]]>";
    }

    /**
     * Get custom attribute names for a product
     */
    private function get_custom_attributes( $productId ) {
        global $wpdb;
        $list = array();

        $sql = $wpdb->prepare(
            "SELECT meta.meta_id, meta.meta_key as name, meta.meta_value as type 
            FROM {$wpdb->prefix}postmeta AS meta, {$wpdb->prefix}posts AS posts 
            WHERE meta.post_id = %d AND meta.post_id = posts.id 
            GROUP BY meta.meta_key 
            ORDER BY meta.meta_key ASC",
            absint( $productId )
        );
        $data = $wpdb->get_results( $sql );

        if ( count( $data ) ) {
            foreach ( $data as $key => $value ) {
                $value_display = str_replace( '_', ' ', $value->name );

                if ( ! preg_match( '/_product_attributes/i', $value->name ) ) {
                    $list[ $value->name ] = ucfirst( $value_display );

                    // Adding support for the Yoast WooCommerce SEO unique identifiers
                    if ( $value->name == 'wpseo_global_identifier_values' ) {
                        $type_expl          = explode( '";', $value->type );
                        $yoast_gtin8_value  = @explode( ':"', $type_expl[1] );
                        $yoast_gtin12_value = @explode( ':"', $type_expl[3] );
                        $yoast_gtin13_value = @explode( ':"', $type_expl[5] );
                        $yoast_gtin14_value = @explode( ':"', $type_expl[7] );
                        $yoast_isbn_value   = @explode( ':"', $type_expl[9] );
                        $yoast_mpn_value    = @explode( ':"', $type_expl[11] );

                        if ( isset( $yoast_gtin8_value[1] ) ) {
                            $list['yoast_gtin8'] = $yoast_gtin8_value[1];
                        }
                        if ( isset( $yoast_gtin12_value[1] ) ) {
                            $list['yoast_gtin12'] = $yoast_gtin12_value[1];
                        }
                        if ( isset( $yoast_gtin13_value[1] ) ) {
                            $list['yoast_gtin13'] = $yoast_gtin13_value[1];
                        }
                        if ( isset( $yoast_gtin14_value[1] ) ) {
                            $list['yoast_gtin14'] = $yoast_gtin14_value[1];
                        }
                        if ( isset( $yoast_isbn_value[1] ) ) {
                            $list['yoast_isbn'] = $yoast_isbn_value[1];
                        }
                        if ( isset( $yoast_mpn_value[1] ) ) {
                            $list['yoast_mpn'] = $yoast_mpn_value[1];
                        }
                    }

                    // Adding support SEOpress unique identifiers
                    if ( $value->name == 'seopress_barcode' ) {
                        $list['seopress_barcode'] = $value->type;
                    }
                } else {
                    $product_attr = unserialize( $value->type );

                    if ( ( ! empty( $product_attr ) ) && ( is_array( $product_attr ) ) ) {
                        foreach ( $product_attr as $key_inner => $arr_value ) {
                            if ( is_array( $arr_value ) ) {
                                if ( ! array_key_exists( 'name', $arr_value ) ) {
                                    $value_display      = @str_replace( '_', ' ', $arr_value['name'] );
                                    $list[ $key_inner ] = ucfirst( $value_display );
                                }
                            }
                        }
                    }
                }
            }
            return $list;
        }
        return false;
    }

    /**
     * Get category path (needed for Prisjakt)
     *
     * @since 13.5.2 Updated for PHP 8.5 compatibility
     * 
     * @param int $id The term ID
     * @param string $taxonomy The taxonomy
     * @param string $link The link
     * @param string $project_taxonomy The project taxonomy
     * @param bool $nicename The nicename
     * @param array $visited The visited terms
     * @return string The term parents
     */
    public function woosea_get_term_parents( $id, $taxonomy, $link = null, $project_taxonomy = null, $nicename = false, $visited = array() ) {
        // Only add Home to the beginning of the chain when we start buildin the chain
        if ( empty( $visited ) ) {
            $chain = 'Home';
        } else {
            $chain = '';
        }

        $parent    = get_term( $id, $taxonomy );
        $separator = '';
        switch ( $project_taxonomy ) {
            case 'openai':
                $separator = ' > ';
                break;
            case 'Prisjakt':
                $separator = ' / ';
                break;
            default:
                $separator = ' &gt; ';
                break;
        }

        if ( is_wp_error( $parent ) ) {
            return $parent;
        }

        if ( $parent ) {
            if ( $nicename ) {
                $name = $parent->slug;
            } else {
                $name = $parent->name;
            }

            if ( $parent->parent && ( $parent->parent != $parent->term_id ) && ! in_array( $parent->parent, $visited, true ) ) {
                $visited[] = $parent->parent;
                $chain    .= $this->woosea_get_term_parents( $parent->parent, $taxonomy, $link, $separator, $nicename, $visited );
            }

            if ( $link ) {
                $chain .= $separator . $name;
            } else {
                $chain .= $separator . $name;
            }
        }
        return $chain;
    }

    /**
     * Create a floatval for prices
     */
    public function woosea_floatvalue( $val ) {
        $val = str_replace( ',', '.', $val );
        $val = preg_replace( '/\.(?=.*\.)/', '', $val );
        return floatval( $val );
    }

    /**
     * Get all configured shipping zones
     */
    public function woosea_get_shipping_zones() {
        if ( class_exists( 'WC_Shipping_Zones' ) ) {
            $all_zones = WC_Shipping_Zones::get_zones();
            return $all_zones;
        }
        return false;
    }

    /**
     * Get installment for product
     */
    public function woosea_get_installment( $feed, $productId ) {
        $installment = '';
        $currency    = apply_filters( 'adt_product_feed_installment_currency', get_woocommerce_currency(), $feed, $productId );

        $installment_months = get_post_meta( $productId, '_woosea_installment_months', true );
        $installment_amount = get_post_meta( $productId, '_woosea_installment_amount', true );

        if ( ! empty( $installment_amount ) ) {
            $installment = $installment_months . ':' . $installment_amount . ' ' . $currency;
        }
        return $installment;
    }

    /**
     * Check if a file contains XML content
     * @param string $file Path to the file to check
     * @return bool True if file appears to be XML, false otherwise
     */
    private function is_xml_file( $file ) {
        if ( ! file_exists( $file ) ) {
            return false;
        }
        
        // Read first few bytes to check for XML declaration or opening tag
        $handle = fopen( $file, 'r' );
        if ( ! $handle ) {
            return false;
        }
        
        $content = fread( $handle, 200 ); // Read first 200 bytes
        fclose( $handle );
        
        // Skip BOM if present
        $content = ltrim( $content, "\xEF\xBB\xBF" );
        
        // Check if content starts with XML declaration or opening XML tag
        return ( strpos( trim( $content ), '<?xml' ) === 0 || strpos( trim( $content ), '<' ) === 0 );
    }

    /**
     * COnvert country name to two letter code
     */
    public function woosea_country_to_code( $country ) {

        $countryList = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas the',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island (Bouvetoya)',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros the',
            'CD' => 'Congo',
            'CG' => 'Congo the',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote d\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FO' => 'Faroe Islands',
            'FK' => 'Falkland Islands',
            'FJ' => 'Fiji the Fiji Islands',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia the',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'VA' => 'Holy See',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KP' => 'Korea',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyz Republic',
            'LA' => 'Lao',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'AN' => 'Netherlands Antilles',
            'NL' => 'Netherlands',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia, Somali Republic',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard & Jan Mayen Islands',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Minor Outlying Islands',
            'VI' => 'United States Virgin Islands',
            'UY' => 'Uruguay, Eastern Republic of',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        );

        return ( array_search( $country, $countryList ) );
    }

    /**
     * Log queries, used for debugging errors
     */
    public function woosea_create_query_log( $query, $filename ) {
        $upload_dir = wp_upload_dir();

        $base = $upload_dir['basedir'];
        $path = $base . '/woo-product-feed-pro/logs';
        $file = $path . '/' . $filename . '.' . 'log';

        // External location for downloading the file
        $external_base = $upload_dir['baseurl'];
        $external_path = $external_base . '/woo-product-feed-pro/logs';
        $external_file = $external_path . '/' . $filename . '.' . 'log';

        // Check if directory in uploads exists, if not create one
        if ( ! file_exists( $path ) ) {
            wp_mkdir_p( $path );
        }

        // Log timestamp
        $today  = "\n";
        $today .= date( 'F j, Y, g:i a' );                 // March 10, 2001, 5:16 pm
        $today .= "\n";

        $fp = fopen( $file, 'a+' );
        fwrite( $fp, $today );
        fwrite( $fp, print_r( $query, true ) );
        fclose( $fp );
    }

    /**
     * Creates XML root and header for productfeed
     *
     * @since 13.5.2 Updated for PHP 8.5 compatibility
     * 
     * @param array $products The products array
     * @param object $feed The feed object
     * @param string $header The header string
     * @throws \Exception If feed configuration not found or invalid channel name detected
     */
    public function woosea_create_xml_feed( $products, $feed, $header ) {
        $upload_dir = wp_upload_dir();
        $base       = $upload_dir['basedir'];
        $path       = $base . '/woo-product-feed-pro/' . $feed->file_format;
        $file       = $path . '/' . sanitize_file_name( $feed->file_name ) . '_tmp.' . $feed->file_format;

        // External location for downloading the file
        $external_base = $upload_dir['baseurl'];
        $external_path = $external_base . '/woo-product-feed-pro/' . $feed->file_format;
        $external_file = $external_path . '/' . sanitize_file_name( $feed->file_name ) . '.' . $feed->file_format;

        // Get the feed configuration
        $feed_config = $feed->get_channel();
        if ( empty( $feed_config ) ) {
            throw new \Exception( 'Feed configuration not found: ' . $feed->id . ' - ' . $feed->title );
        }

        // Check if directory in uploads exists, if not create one
        if ( ! file_exists( $path ) ) {
            wp_mkdir_p( $path );
        }

        // Check if file exists, if it does: delete it first so we can create a new updated one
        if ( file_exists( $file ) && $header == 'true' && $feed->total_products_processed == 0 ) {
            unlink( $file );
        }

        // Check if there is a channel feed class that we need to use
        if ( $feed_config['fields'] != 'standard' ) {
            if ( ! class_exists( 'WooSEA_' . $feed_config['fields'] ) ) {
                // Sanitize channel name to prevent path traversal attacks
                $channel_name = sanitize_file_name( $feed_config['fields'] );
                
                // Additional validation: only allow alphanumeric characters and underscores
                if ( ! preg_match( '/^[a-zA-Z0-9_]+$/', $channel_name ) ) {
                    throw new \Exception( 'Invalid channel name detected: ' . $feed_config['fields'] );
                }
                
                $channel_file_path = plugin_dir_path( __FILE__ ) . '/channels/class-' . $channel_name . '.php';
                
                // Verify the file is within the channels directory (prevent directory traversal)
                $real_path = realpath( $channel_file_path );
                $channels_dir = realpath( plugin_dir_path( __FILE__ ) . '/channels' );
                
                if ( $real_path && $channels_dir && strpos( $real_path, $channels_dir ) === 0 && file_exists( $real_path ) ) {
                    require $real_path;
                    $channel_class      = 'WooSEA_' . $channel_name;
                    $channel_attributes = $channel_class::get_channel_attributes();
                    update_option( 'channel_attributes', $channel_attributes, false );
                }
            } else {
                $channel_attributes = get_option( 'channel_attributes' );
            }
        }

        // Some channels need their own feed config and XML namespace declarations (such as Google shopping)
        if ( $feed_config['taxonomy'] == 'google_shopping' ) {
            $namespace = array( 'g' => 'http://base.google.com/ns/1.0' );
            if ( ( $header == 'true' ) && ( $feed->total_products_processed == 0 ) ) {
                $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="UTF-8"?><rss xmlns:g="http://base.google.com/ns/1.0"></rss>' );
                $xml->addAttribute( 'version', '2.0' );
                $xml->addChild( 'channel' );

                // Start adding the AdTribes.io Facebook app ID and the feed asset ID
                if ( $feed_config['fields'] == 'facebook_drm' ) {
                    $xml->channel->addChild( 'metadata' );
                    $xml->channel->metadata->addChild( 'ref_application_id', '160825592398259' );
                    $xml->channel->metadata->addChild( 'ref_asset_id', $feed->legacy_project_hash );
                }
                // End Facebook ID's

                $xml->channel->addChild( 'title', htmlspecialchars( $feed->title ) );
                $xml->channel->addChild( 'link', apply_filters( 'adt_pfp_google_shopping_feed_channel_link', home_url(), $feed ) );
                $xml->channel->addChild( 'description', 'WooCommerce Product Feed PRO - This product feed is created with the Product Feed PRO for WooCommerce plugin from AdTribes.io. For all your support questions check out our FAQ on https://www.adtribes.io or e-mail to: support@adtribes.io ' );
                $xml->asXML( $file );
            } else {
                // Guard against parsing CSV files as XML - only parse if it's actually an XML file
                if ( $this->is_xml_file( $file ) ) {
                    // Load XML without LIBXML_NOCDATA to preserve CDATA sections during batch processing
                    $xml = simplexml_load_file( $file, 'SimpleXMLElement' );
                } else {
                    // Skip XML processing for CSV files to prevent simplexml_load_file warnings
                    $xml = false;
                }
                $aantal = count( $products );

                if ( ( $xml !== false ) && ( $aantal > 0 ) ) {
                    foreach ( $products as $key => $value ) {

                        if ( is_array( $value ) ) {
                            if ( ! empty( $value ) ) {
                                $product = $xml->channel->addChild( 'item' );
                                foreach ( $value as $k => $v ) {
                                    if ( $k == 'g:shipping' ) {
                                        $ship = explode( '||', $v );
                                        foreach ( $ship as $kk => $vv ) {
                                            $sub_count  = substr_count( $vv, '##' );
                                            $shipping   = $product->addChild( $k, '', htmlspecialchars( $namespace['g'] ) );
                                            $ship_split = explode( ':', $vv );

                                            foreach ( $ship_split as $ship_piece ) {

                                                $piece_value = explode( '##', $ship_piece );
                                                if ( preg_match( '/WOOSEA_COUNTRY/', $ship_piece ) ) {
                                                    $shipping_country = $shipping->addChild( 'g:country', $piece_value[1], $namespace['g'] );
                                                } elseif ( preg_match( '/WOOSEA_REGION/', $ship_piece ) ) {
                                                    $shipping_region = $shipping->addChild( 'g:region', $piece_value[1], $namespace['g'] );
                                                } elseif ( preg_match( '/WOOSEA_POSTAL_CODE/', $ship_piece ) ) {
                                                    $shipping_price = $shipping->addChild( 'g:postal_code', $piece_value[1], $namespace['g'] );
                                                } elseif ( preg_match( '/WOOSEA_SERVICE/', $ship_piece ) ) {
                                                    $shipping_service = $shipping->addChild( 'g:service', $piece_value[1], $namespace['g'] );
                                                } elseif ( preg_match( '/WOOSEA_PRICE/', $ship_piece ) ) {
                                                    $shipping_price = $shipping->addChild( 'g:price', trim( $piece_value[1] ), $namespace['g'] );
                                                } elseif ( preg_match( '/WOOSEA_MIN_TRANSIT_TIME/', $ship_piece ) ) {
                                                    $shipping->addChild( 'g:min_transit_time', trim( $piece_value[1] ), $namespace['g'] );
                                                } elseif ( preg_match( '/WOOSEA_MAX_TRANSIT_TIME/', $ship_piece ) ) {
                                                    $shipping->addChild( 'g:max_transit_time', trim( $piece_value[1] ), $namespace['g'] );
                                                } elseif ( preg_match( '/WOOSEA_MIN_HANDLING_TIME/', $ship_piece ) ) {
                                                    $shipping->addChild( 'g:min_handling_time', trim( $piece_value[1] ), $namespace['g'] );
                                                } elseif ( preg_match( '/WOOSEA_MAX_HANDLING_TIME/', $ship_piece ) ) {
                                                    $shipping->addChild( 'g:max_handling_time', trim( $piece_value[1] ), $namespace['g'] );
                                                } else {
                                                    // DO NOT ADD ANYTHING
                                                }
                                            }
                                        }
                                    } elseif ( $k == 'free_shipping_threshold' || $k == 'g:free_shipping_threshold' ) {
                                        if ( ! empty( $v ) ) {
                                            $thresholds = explode( '||', $v );
                                            foreach ( $thresholds as $threshold_data ) {
                                                $threshold_element = $product->addChild( 'g:free_shipping_threshold', '', $namespace['g'] );
                                                $threshold_split = explode( ':', $threshold_data );

                                                foreach ( $threshold_split as $threshold_piece ) {
                                                    $piece_value = explode( '##', $threshold_piece );

                                                    // Skip if the piece value is not set.
                                                    if ( ! isset( $piece_value[1] ) ) {
                                                        continue;
                                                    }

                                                    if ( preg_match( '/WOOSEA_COUNTRY/', $threshold_piece ) ) {
                                                        $threshold_element->addChild( 'g:country', $piece_value[1], $namespace['g'] );
                                                    } elseif ( preg_match( '/WOOSEA_PRICE_THRESHOLD/', $threshold_piece ) ) {
                                                        $threshold_element->addChild( 'g:price_threshold', trim( $piece_value[1] ), $namespace['g'] );
                                                    }
                                                }
                                            }
                                        }
                                        // Fix issue with additional images for Google Shopping
                                    } elseif ( preg_match( '/g:additional_image_link/i', $k ) ) {
                                        // First replace spaces from additional image URL
                                        $v = str_replace( ' ', '', $v );
                                        // Only add the element if the value is not empty
                                        if ( ! empty( $v ) ) {
                                            $link = $product->addChild( 'g:additional_image_link', $v, $namespace['g'] );
                                        }
                                        // $product->$k = $v;
                                    } elseif ( preg_match( '/g:product_highlight/i', $k ) ) {
                                        $v                 = preg_replace( '/&/', '&#38;', $v );
                                        $product_highlight = $product->addChild( 'g:product_highlight', $v, $namespace['g'] );
                                    } elseif ( preg_match( '/g:included_destination/i', $k ) ) {
                                        $v                            = preg_replace( '/&/', '&#38;', $v );
                                        $product_included_destination = $product->addChild( 'g:included_destination', $v, $namespace['g'] );
                                    } elseif ( preg_match( '/g:shopping_ads_excluded_country/i', $k ) ) {
                                        $exclude_country = $product->addChild( 'g:shopping_ads_excluded_country', $v, $namespace['g'] );
                                    } elseif ( preg_match( '/g:promotion_id/i', $k ) ) {
                                        $promotion_id = $product->addChild( 'g:promotion_id', $v, $namespace['g'] );
                                    } elseif ( preg_match( '/g:product_detail/i', $k ) ) {
                                        if ( ! empty( $v ) ) {
                                            $product_detail_split = explode( '#', $v );
                                            $detail_complete      = count( $product_detail_split );
                                            if ( ( $detail_complete == 2 ) && ( ! empty( $product_detail_split[1] ) ) ) {
                                                $product_detail     = $product->addChild( 'g:product_detail', '', $namespace['g'] );
                                                $name               = str_replace( '_', ' ', $product_detail_split[0] );
                                                $section_name       = explode( ':', $name );
                                                $section_name_start = ucfirst( $section_name[0] );

                                                if ( preg_match( '/||/i', $product_detail_split[0] ) ) {
                                                    $product_detail_value_exp = explode( '||', $product_detail_split[0] );
                                                    $product_detail_name      = $product_detail_value_exp[0];
                                                    $product_detail_value     = $product_detail_split[1];
                                                    $section_name_start       = str_replace( $product_detail_value_exp[0], '', $section_name_start );
                                                    $section_name_start       = trim( str_replace( '||', '', $section_name_start ) );
                                                } else {
                                                    $product_detail_name  = 'General';
                                                    $product_detail_value = $product_detail_split[0];
                                                }

                                                $section_name         = $product_detail->addChild( 'g:section_name', $product_detail_name, $namespace['g'] );
                                                $section_name_start   = str_replace( 'Pa ', '', $section_name_start );
                                                $section_name_start   = str_replace( 'pa ', '', $section_name_start );
                                                $section_name_start   = str_replace( '-', ' ', $section_name_start );
                                                $section_name_start   = str_replace( 'Custom attributes ', '', $section_name_start );
                                                $product_detail_name  = $product_detail->addChild( 'g:attribute_name', ucfirst( $section_name_start ), $namespace['g'] );
                                                $product_detail_value = $product_detail->addChild( 'g:attribute_value', $product_detail_value, $namespace['g'] );
                                            }
                                        }
                                    } elseif ( preg_match( '/g:consumer_notice/i', $k ) ) {
                                        if ( ! empty( $v ) ) {
                                            $notice = $product->addChild( 'consumer_notice', '', $namespace['g'] );
                                            if ( strpos( $v, 'prop 65' ) !== false ) {
                                                $notice_type = $notice->addChild( 'g:notice_type', 'prop 65', $namespace['g'] );
                                                $v           = trim( str_replace( 'prop 65', '', $v ) );
                                            } elseif ( strpos( $v, 'safety warning' ) !== false ) {
                                                $notice_type = $notice->addChild( 'g:notice_type', 'safety warning', $namespace['g'] );
                                                $v           = trim( str_replace( 'safety warning', '', $v ) );
                                            } elseif ( strpos( $v, 'legal disclaimer' ) !== false ) {
                                                $notice_type = $notice->addChild( 'g:notice_type', 'legal disclaimer', $namespace['g'] );
                                                $v           = trim( str_replace( 'legal disclaimer', '', $v ) );
                                            } else {
                                                // No notice type set so we assume it is a safety warning
                                                $notice_type = $notice->addChild( 'g:notice_type', 'safety warning', $namespace['g'] );
                                            }
                                            $notice_type = $notice->addChild( 'g:notice_message', $v, $namespace['g'] );
                                        }
                                    } elseif ( $k == 'g:installment' ) {
                                        if ( ! empty( $v ) ) {
                                            $installment_split  = explode( ':', $v );
                                            $installment        = $product->addChild( $k, '', $namespace['g'] );
                                            $installment_months = $installment->addChild( 'g:months', $installment_split[0], $namespace['g'] );
                                            $installment_amount = $installment->addChild( 'g:amount', $installment_split[1], $namespace['g'] );
                                        }
                                    } elseif ( $k == 'g:color' || $k == 'g:size' || $k == 'g:material' ) {
                                        if ( ! empty( $v ) ) {
                                            $attr_split = explode( ',', $v );
                                            $nr_attr    = count( $attr_split ) - 1;
                                            $attr_value = '';

                                            for ( $x = 0; $x <= $nr_attr; $x++ ) {
                                                $attr_value .= trim( $attr_split[ $x ] ) . '/';
                                            }
                                            $attr_value  = rtrim( $attr_value, '/' );
                                            $product->$k = rawurldecode( $attr_value );
                                        }
                                    } else {
                                        /**
                                         * Filter the product attribute value before adding it to the XML feed.
                                         *
                                         * @since 13.4.6
                                         *
                                         * @param mixed  $v       The attribute value.
                                         * @param string $k       The attribute key/name.
                                         * @param object $product The XML product element.
                                         * @param array  $value   The complete product data array.
                                         * @param object $feed    The product feed object.
                                         * @return mixed
                                         */
                                        $v = apply_filters( 'adt_product_feed_xml_attribute_value', $v, $k, $product, $value, $feed );
                                        $v = $this->woosea_recursive_trim( $v );
                                        $k = trim( $k );

                                        $this->woosea_write_individual_product_to_xml( $product, $k, $v, $feed_config, $channel_attributes, $feed );
                                    }
                                }
                            }
                        }
                    }
                }

                if ( is_object( $xml ) ) {
                    // Use XMLWriter for reliable formatting on large feeds
                    $this->woosea_save_xml_with_xmlwriter( $xml, $file );
                }
                unset( $products );
            }
            unset( $xml );
        } else {
            $date = new \WC_DateTime( 'now', new \DateTimeZone( 'UTC' ) );
            $date = Formatting::date_iso8601( $date );
            if ( ( $header == 'true' ) && ( $feed->total_products_processed == 0 ) || ! file_exists( $file ) ) {
                if ( $feed_config['name'] == 'Yandex' ) {
                    $main_currency = get_woocommerce_currency();

                    do_action( 'adt_before_yandex_create_xml_feed', $xml, $feed );

                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><yml_catalog></yml_catalog>' );
                    $xml->addAttribute( 'date', $date );
                    $shop = $xml->addChild( 'shop' );
                    $shop->addChild( 'name', htmlspecialchars( $feed->title ) );
                    $shop->addChild( 'company', get_bloginfo() );
                    $shop->addChild( 'url', home_url() );
                    // $shop->addChild('platform', 'WooCommerce');
                    $currencies = $shop->addChild( 'currencies' );
                    $currency   = $currencies->addChild( 'currency' );
                    $currency->addAttribute( 'id', $main_currency );
                    $currency->addAttribute( 'rate', '1' );

                    $product_categories = get_terms(
                        array(
                            'taxonomy' => 'product_cat',
                        ) 
                    );

                    $count = count( $product_categories );
                    if ( $count > 0 ) {
                        $categories = $shop->addChild( 'categories' );

                        foreach ( $product_categories as $product_category ) {
                            $category = $categories->addChild( 'category', htmlspecialchars( $product_category->name ) );
                            $category->addAttribute( 'id', $product_category->term_id );
                            if ( $product_category->parent > 0 ) {
                                $category->addAttribute( 'parentId', $product_category->parent );
                            }
                        }
                    }

                    $shop->addChild( 'agency', 'AdTribes.io' );
                    $shop->addChild( 'email', 'support@adtribes.io' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Zbozi.cz' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><SHOP></SHOP>' );
                    $xml->addAttribute( 'xmlns', 'http://www.zbozi.cz/ns/offer/1.0' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Bestprice' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="ISO-8859-7"?><store></store>' );
                    $xml->addChild( 'date', $date );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Shopflix' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><MPITEMS></MPITEMS>' );
                    $xml->addChild( 'created_at', $date );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Glami.gr' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><SHOP></SHOP>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Glami.sk' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><SHOP></SHOP>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Glami.cz' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><SHOP></SHOP>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Vivino' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><vivino-product-list></vivino-product-list>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Pricecheck.co.za' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><Offers></Offers>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Pinterest RSS Board' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" version="2.0"></rss>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Heureka.cz' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><SHOP></SHOP>' );
                    $xml->addAttribute( 'xmlns', 'http://www.heureka.cz/ns/offer/1.0' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Mall.sk' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8" standalone="yes"?><ITEMS></ITEMS>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Mall.sk availability' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8" standalone="yes"?><AVAILABILITIES></AVAILABILITIES>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Heureka.sk' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><SHOP></SHOP>' );
                    $xml->addAttribute( 'xmlns', 'http://www.heureka.sk/ns/offer/1.0' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Zap.co.il' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><STORE></STORE>' );
                    $xml->addChild( 'datetime', $date );
                    $xml->addChild( 'title', htmlspecialchars( $feed->title ) );
                    $xml->addChild( 'link', home_url() );
                    $xml->addChild( 'description', 'WooCommerce Product Feed PRO - This product feed is created with the free Advanced Product Feed PRO for WooCommerce plugin from AdTribes.io. For all your support questions check out our FAQ on https://www.adtribes.io or e-mail to: support@adtribes.io ' );
                    $xml->addChild( 'agency', 'AdTribes.io' );
                    $xml->addChild( 'email', 'support@adtribes.io' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Salidzini.lv' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><root></root>' );
                    $xml->addChild( 'datetime', $date );
                    $xml->addChild( 'title', htmlspecialchars( $feed->title ) );
                    $xml->addChild( 'link', home_url() );
                    $xml->addChild( 'description', 'WooCommerce Product Feed PRO - This product feed is created with the free Advanced Product Feed PRO for WooCommerce plugin from AdTribes.io. For all your support questions check out our FAQ on https://www.adtribes.io or e-mail to: support@adtribes.io ' );
                    $xml->addChild( 'agency', 'AdTribes.io' );
                    $xml->addChild( 'email', 'support@adtribes.io' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Google Product Review' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><feed></feed>' );
                    $xml->addAttribute( 'xmlns:xmlns:vc', 'http://www.w3.org/2007/XMLSchema-versioning' );
                    $xml->addAttribute( 'xmlns:xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance' );
                    $xml->addAttribute( 'xsi:xsi:noNamespaceSchemaLocation', 'http://www.google.com/shopping/reviews/schema/product/2.3/product_reviews.xsd' );
                    $xml->addChild( 'version', '2.3' );
                    $aggregator = $xml->addChild( 'aggregator' );
                    $aggregator->addChild( 'name', htmlspecialchars( $feed->title ) );
                    $publisher = $xml->addChild( 'publisher' );
                    $publisher->addChild( 'name', get_bloginfo( 'name' ) );
                    $publisher->addChild( 'favicon', get_site_icon_url() );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Fruugo.nl' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><Products></Products>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Fruugo.co.uk' ) {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><Products></Products>' );
                    $xml->asXML( $file );
                } elseif ( $feed_config['name'] == 'Skroutz' ) {
                    // Get site domain name (more suitable for XML element names)
                    $site_domain = wp_parse_url( home_url(), PHP_URL_HOST );
                    $site_domain = preg_replace('/[^a-zA-Z0-9_-]/', '_', $site_domain); // Sanitize for XML

                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><' . $site_domain . '></' . $site_domain . '>' );
                    $xml->addChild( 'created_at', date( 'Y-m-d H:i' ) );
                    $xml->asXML( $file );
                } else {
                    $xml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><products></products>' );
                    
                    if ( ! preg_match( '/fruugo|pricerunner/i', $feed_config['fields'] ) ) {
                        $xml->addAttribute( 'version', '1.0' );
                        $xml->addAttribute( 'standalone', 'yes' );
                    }

                    if ( $feed_config['name'] == 'Skroutz' ) {
                        $xml->addChild( 'created_at', $date );
                    }

                    $xml->asXML( $file );
                }
            } else {
                $xml    = simplexml_load_file( $file );
                $aantal = count( $products );

                if ( $aantal > 0 ) {

                    // For Yandex template
                    if ( ( $feed_config['name'] == 'Yandex' ) && ( $feed->total_products_processed == 0 ) ) {
                        $shop = $xml->shop->addChild( 'offers' );
                    }

                    // For Bestprice template
                    if ( ( $feed_config['name'] == 'Bestprice' ) && ( $feed->total_products_processed == 0 ) ) {
                        $productz = $xml->addChild( 'products' );
                    }

                    // For Skroutz template
                    if ( ( $feed_config['name'] == 'Skroutz' ) && ( $feed->total_products_processed == 0 ) ) {
                        $productz = $xml->addChild( 'products' );
                    }

                    // For Shopflix template
                    if ( ( $feed_config['name'] == 'Shopflix' ) && ( $feed->total_products_processed == 0 ) ) {
                        $productz = $xml->addChild( 'products' );
                    }

                    // For ZAP template
                    if ( ( $feed_config['name'] == 'Zap.co.il' ) && ( $feed->total_products_processed == 0 ) ) {
                        $productz = $xml->addChild( 'PRODUCTS' );
                    }

                    // For Pinterest RSS Board template
                    if ( ( $feed_config['name'] == 'Pinterest RSS Board' ) && ( empty( $xml->channel ) ) ) {

                        $date = new \WC_DateTime( 'now', new \DateTimeZone( 'UTC' ) );
                        $date = Formatting::date_rfc822( $date );

                        $productz = $xml->addChild( 'channel' );
                        $productz = $xml->channel->addChild( 'title', get_bloginfo( 'name' ) );
                        $productz = $xml->channel->addChild( 'description', htmlspecialchars( $feed->title ) );
                        $productz = $xml->channel->addChild( 'link', home_url() );
                        $productz = $xml->channel->addChild( 'generator', 'Product Feed Pro for WooCommerce by AdTribes.io' );
                        $productz = $xml->channel->addChild( 'lastBuildDate', $date );
                        $atom_link = $xml->channel->addChild( 'atom:link', '', 'http://www.w3.org/2005/Atom' );
                        $atom_link->addAttribute( 'href', $feed->get_file_url() );
                        $atom_link->addAttribute( 'rel', 'self' );
                        $atom_link->addAttribute( 'type', 'application/rss+xml' );
                    }

                    // For Google Product review template
                    if ( ( $feed_config['name'] == 'Google Product Review' ) && ( empty( $xml->channel ) ) ) {

                        if ( ! is_bool( $xml ) ) {
                            $product = $xml->addChild( 'reviews' );

                            foreach ( $products as $key => $value ) {
                                $expl = '||';

                                if ( array_key_exists( 'reviews', $value ) ) {
                                    $review_data = explode( '||', $value['reviews'] );
                                    foreach ( $review_data as $rk => $rv ) {

                                        $review_comp = explode( ':::', $rv );
                                        $nr_reviews  = count( $review_comp );

                                        if ( $nr_reviews > 1 ) {
                                            $productz = $xml->reviews->addChild( 'review' );

                                            foreach ( $review_comp as $rck => $rcv ) {
                                                $nodes = explode( '##', $rcv );
                                                $nodes = str_replace( '::', '', $nodes );

                                                if ( $nodes[0] == 'REVIEW_RATINGS' ) {
                                                    // Do nothing
                                                } elseif ( $nodes[0] == 'REVIEW_URL' ) {
                                                    $rev_url = $productz->addChild( strtolower( $nodes[0] ), htmlspecialchars( $nodes[1] ) );
                                                    $rev_url->addAttribute( 'type', 'singleton' );
                                                } elseif ( ( $nodes[0] == 'REVIEWER_NAME' ) || ( $nodes[0] == 'REVIEWER_ID' ) ) {
                                                    if ( isset( $productz->reviewer ) ) {
                                                        if ( $nodes[0] == 'REVIEWER_NAME' ) {
                                                            $name = $nodes[1];
                                                            if ( empty( $name ) ) {
                                                                $reviewer->addChild( 'name', 'Anonymous' );
                                                                $reviewer->name->addAttribute( 'is_anonymous', 'true' );
                                                            } else {
                                                                $reviewer->addChild( 'name', $name );
                                                            }
                                                        } elseif ( is_numeric( $nodes[1] ) ) {
                                                            $reviewer->addChild( 'reviewer_id', $nodes[1] );
                                                        }
                                                    } else {
                                                        $reviewer = $productz->addChild( 'reviewer' );
                                                        if ( $nodes[0] == 'REVIEWER_NAME' ) {
                                                            $name = $nodes[1];
                                                            if ( empty( $name ) ) {
                                                                $reviewer->addChild( 'name', 'Anonymous' );
                                                                $reviewer->name->addAttribute( 'is_anonymous', 'true' );
                                                            } else {
                                                                $reviewer->addChild( 'name', htmlspecialchars( $name ) );
                                                                // $reviewer->addChild('name',$name);
                                                            }
                                                        } elseif ( is_numeric( $nodes[1] ) ) {
                                                            $reviewer->addChild( 'reviewer_id', $nodes[1] );
                                                        }
                                                    }
                                                } elseif ( isset( $nodes[1] ) ) {
                                                    $content = html_entity_decode( $nodes[1] );
                                                    $content = htmlspecialchars( $content );
                                                    $rev     = $productz->addChild( strtolower( $nodes[0] ), $content );
                                                }
                                            }

                                            foreach ( $review_comp as $rck => $rcv ) {
                                                $nodes = explode( '##', $rcv );
                                                $nodes = str_replace( '::', '', $nodes );

                                                if ( $nodes[0] == 'REVIEW_RATINGS' ) {
                                                    $rev  = $productz->addChild( 'ratings' );
                                                    $over = $productz->ratings->addChild( 'overall', $nodes[1] );
                                                    $over->addAttribute( 'min', '1' );
                                                    $over->addAttribute( 'max', '5' );
                                                }
                                            }

                                            $yo = $productz->addChild( 'products' );
                                            $po = $yo->addChild( 'product' );

                                            $identifiers = array( 'gtin', 'mpn', 'sku', 'brand' );

                                            // Start determining order of product_ids in the Google review feed
                                            $proper_order = array( 'product_name', 'gtin', 'mpn', 'sku', 'brand', 'product_url', 'review_url', 'reviews' );
                                            $order_sorted = array();
                                            foreach ( $proper_order as &$order_value ) {
                                                if ( isset( $value[ $order_value ] ) ) {
                                                    $order_sorted[ $order_value ] = $value[ $order_value ];
                                                }
                                            }
                                            // End

                                            foreach ( $order_sorted as $k => $v ) {
                                                if ( ( $k != 'product_name' ) && ( $k != 'product_url' ) ) {
                                                    if ( ! in_array( $k, $identifiers ) ) {
                                                        if ( ( $k != 'reviews' ) && ( $k != 'review_url' ) ) {
                                                            if ( $k != 'product_url' ) {
                                                                $v = str_replace( '&', 'and', $v );
                                                            }
                                                            $poa = $po->addChild( $k, htmlspecialchars( $v ) );
                                                        }
                                                    } elseif ( isset( $po->product_ids ) ) {
                                                        if ( $k == 'gtin' ) {
                                                            $poig     = $poi->addChild( 'gtins' );
                                                            $poig->$k = $v;
                                                        } elseif ( $k == 'mpn' ) {
                                                            $poim     = $poi->addChild( 'mpns' );
                                                            $poim->$k = $v;
                                                        } elseif ( $k == 'sku' ) {
                                                            $poix     = $poi->addChild( 'skus' );
                                                            $poix->$k = $v;
                                                        } elseif ( $k == 'brand' ) {
                                                            $poib     = $poi->addChild( 'brands' );
                                                            $poib->$k = $v;
                                                        } else {
                                                            // Do nothing
                                                        }
                                                    } else {
                                                        $poi = $po->addChild( 'product_ids' );
                                                        if ( $k == 'gtin' ) {
                                                            $poig     = $poi->addChild( 'gtins' );
                                                            $poig->$k = $v;
                                                        } elseif ( $k == 'mpn' ) {
                                                            $poim     = $poi->addChild( 'mpns' );
                                                            $poim->$k = $v;
                                                        } elseif ( $k == 'sku' ) {
                                                            $poix     = $poi->addChild( 'skus' );
                                                            $poix->$k = $v;
                                                        } elseif ( $k == 'brand' ) {
                                                            $poib     = $poi->addChild( 'brands' );
                                                            $poib->$k = $v;
                                                        } else {
                                                            // Do nothing
                                                        }
                                                    }
                                                }
                                            }

                                            // foreach for product name and product url as order seems to mather to Google
                                            foreach ( $value as $k => $v ) {
                                                if ( ( $k == 'product_name' ) || ( $k == 'product_url' ) ) {
                                                    if ( ! in_array( $k, $identifiers ) ) {
                                                        if ( ( $k != 'reviews' ) && ( $k != 'review_url' ) ) {
                                                            if ( $k != 'product_url' ) {
                                                                $v = str_replace( '&', 'and', $v );
                                                            }
                                                            $poa = $po->addChild( $k, htmlspecialchars( $v ) );
                                                        }
                                                    } elseif ( isset( $po->product_ids ) ) {
                                                        if ( $k == 'gtin' ) {
                                                            $poig     = $poi->addChild( 'gtins' );
                                                            $poig->$k = $v;
                                                        } elseif ( $k == 'mpn' ) {
                                                            $poim     = $poi->addChild( 'mpns' );
                                                            $poim->$k = $v;
                                                        } elseif ( $k == 'sku' ) {
                                                            $poix     = $poi->addChild( 'skus' );
                                                            $poix->$k = $v;
                                                        } elseif ( $k == 'brand' ) {
                                                            $poib     = $poi->addChild( 'brands' );
                                                            $poib->$k = $v;
                                                        } else {
                                                            // Do nothing
                                                        }
                                                    } else {
                                                        $poi = $po->addChild( 'product_ids' );
                                                        if ( $k == 'gtin' ) {
                                                            $poig     = $poi->addChild( 'gtins' );
                                                            $poig->$k = $v;
                                                        } elseif ( $k == 'mpn' ) {
                                                            $poim     = $poi->addChild( 'mpns' );
                                                            $poim->$k = $v;
                                                        } elseif ( $k == 'sku' ) {
                                                            $poix     = $poi->addChild( 'skus' );
                                                            $poix->$k = $v;
                                                        } elseif ( $k == 'brand' ) {
                                                            $poib     = $poi->addChild( 'brands' );
                                                            $poib->$k = $v;
                                                        } else {
                                                            // Do nothing
                                                        }
                                                    }
                                                }

                                                // Process other attributes that are not in identifiers or proper_order.
                                                // This is additional/optional attributes, these attributes are for review child nodes.
                                                if ( ! in_array( $k, $identifiers ) && ! in_array( $k, $proper_order ) ) {
                                                    $productz->$k = $v;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    foreach ( $products as $key => $value ) {
                        if ( ( is_array( $value ) ) && ( ! empty( $value ) ) ) {
                            if ( $feed_config['name'] == 'Yandex' ) {
                                $product = $xml->shop->offers->addChild( 'offer' );
                            } elseif ( $feed_config['name'] == 'Heureka.cz' || $feed_config['name'] == 'Heureka.sk' || $feed_config['name'] == 'Zbozi.cz' || $feed_config['name'] == 'Glami.gr' || $feed_config['name'] == 'Glami.sk' || $feed_config['name'] == 'Glami.cz' ) {
                                $product = $xml->addChild( 'SHOPITEM' );
                            } elseif ( $feed_config['name'] == 'Zap.co.il' ) {
                                $product = $xml->PRODUCTS->addChild( 'PRODUCT' );
                            } elseif ( $feed_config['name'] == 'Bestprice' ) {
                                $product = $xml->products->addChild( 'product' );
                            } elseif ( $feed_config['name'] == 'Skroutz' ) {
                                $product = $xml->products->addChild( 'product' );
                            } elseif ( $feed_config['name'] == 'Shopflix' ) {
                                $product = $xml->products->addChild( 'product' );
                            } elseif ( $feed_config['name'] == 'Salidzini.lv' ) {
                                $product = $xml->addChild( 'item' );
                            } elseif ( $feed_config['name'] == 'Mall.sk' ) {
                                $product = $xml->addChild( 'ITEM' );
                            } elseif ( $feed_config['name'] == 'Mall.sk availability' ) {
                                $product = $xml->addChild( 'AVAILABILITY' );
                            } elseif ( $feed_config['name'] == 'Trovaprezzi.it' ) {
                                $product = $xml->addChild( 'Offer' );
                            } elseif ( $feed_config['name'] == 'Pricecheck.co.za' ) {
                                $product = $xml->addChild( 'Offer' );
                            } elseif ( $feed_config['name'] == 'Pinterest RSS Board' ) {
                                $product = $xml->channel->addChild( 'item' );
                            } elseif ( $feed_config['name'] == 'Fruugo.nl' ) {
                                $product = $xml->addChild( 'Product' );
                            } elseif ( $feed_config['name'] == 'Fruugo.co.uk' ) {
                                $product = $xml->addChild( 'Product' );
                            } elseif ( $feed_config['name'] == 'Google Product Review' ) {
                            } elseif ( count( $value ) > 0 ) {
                                if ( is_object( $xml ) ) {
                                    $product = $xml->addChild( 'product' );
                                }
                            }

                            // Skip processing if product child node is null.
                            if ( ! isset( $product ) || is_null( $product ) ) {
                                continue;
                            }

                            foreach ( $value as $k => $v ) {
                                $k = trim( $k );
                                $v = $this->woosea_recursive_trim( $v );

                                $this->woosea_write_individual_product_to_xml( $product, $k, $v, $feed_config, $channel_attributes, $feed );
                            }
                        }
                    }

                    if ( is_object( $xml ) ) {
                        // Use XMLWriter for reliable formatting on large feeds
                        $this->woosea_save_xml_with_xmlwriter( $xml, $file );
                    }
                    unset( $product );
                }
                unset( $products );
            }
            unset( $xml );
        }
    }

    /**
     * Save XML during batch processing without formatting
     * Formatting is done at the very end by woosea_format_xml_file()
     * 
     * @since 13.5.3
     * 
     * @param SimpleXMLElement $xml The SimpleXML object to save
     * @param string $file The file path to save to
     * @return void
     */
    private function woosea_save_xml_with_xmlwriter( $xml, $file ) {
        // Save without formatting during batch processing to avoid indent accumulation
        // The file will be formatted once at the very end in move_feed_file_to_final()
        $dom = dom_import_simplexml( $xml )->ownerDocument;
        $dom->save( $file );
        unset( $dom );
    }

    /**
     * Format an XML file using XMLWriter for proper indentation
     * This is called after feed generation completes to format the final XML
     * 
     * Production-ready with error handling, backup/recovery, and validation
     * 
     * @since 13.5.3
     * 
     * @param string $file The file path to format
     * @return bool True on success, false on failure
     */
    public function woosea_format_xml_file( $file ) {
        // Early validation checks
        if ( ! file_exists( $file ) ) {
            $this->log_xml_error( 'File does not exist', $file );
            return false;
        }
        
        if ( ! is_readable( $file ) ) {
            $this->log_xml_error( 'File is not readable', $file );
            return false;
        }
        
        if ( ! is_writable( $file ) ) {
            $this->log_xml_error( 'File is not writable', $file );
            return false;
        }
        
        if ( ! $this->is_xml_file( $file ) ) {
            $this->log_xml_error( 'File does not appear to be XML', $file );
            return false;
        }
        
        // Check file size for memory considerations
        $file_size = filesize( $file );
        if ( false === $file_size ) {
            $this->log_xml_error( 'Cannot determine file size', $file );
            return false;
        }
        
        // Create backup file for safety
        $backup_file = $file . '.backup';
        if ( ! copy( $file, $backup_file ) ) {
            $this->log_xml_error( 'Failed to create backup file', $file );
            return false;
        }
        
        // Use temp file for atomic write operation
        $temp_file = $file . '.formatting';
        
        // Save current libxml error state to restore later
        $previous_libxml_errors = libxml_use_internal_errors( true );
        
        try {
            // Load and validate the XML
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = false;
            
            // Clear any previous errors
            libxml_clear_errors();
            
            $loaded = @$dom->load( $file, LIBXML_PARSEHUGE | LIBXML_COMPACT );
            
            if ( ! $loaded ) {
                $errors = libxml_get_errors();
                $error_msg = 'Failed to load XML';
                if ( ! empty( $errors ) ) {
                    $error_msg .= ': ' . $errors[0]->message;
                }
                libxml_clear_errors();
                throw new Exception( $error_msg );
            }
            
            libxml_clear_errors();
            
            // Validate root element exists
            if ( ! $dom->documentElement ) {
                throw new Exception( 'XML document has no root element' );
            }
            
            // Create XMLWriter instance
            $writer = new XMLWriter();
            if ( ! $writer->openURI( $temp_file ) ) {
                throw new Exception( 'Failed to open temp file for writing' );
            }
            
            $writer->setIndent( true );
            $writer->setIndentString( '  ' ); // 2 spaces for indentation
            $writer->startDocument( '1.0', 'UTF-8' );
            
            // Create XPath once for performance (avoid creating per element)
            $xpath = new DOMXPath( $dom );
            
            // Recursively write the DOM tree using XMLWriter
            // Pass empty array so namespaces ARE written on root element
            $this->woosea_write_dom_node_with_xmlwriter( $dom->documentElement, $writer, array(), $xpath );
            
            // End document and flush
            $writer->endDocument();
            $writer->flush();
            
            // Cleanup writer
            unset( $writer );
            
            // Verify temp file was created and has content
            if ( ! file_exists( $temp_file ) || filesize( $temp_file ) === 0 ) {
                throw new Exception( 'Formatted file is empty or was not created' );
            }
            
            // Validate the formatted XML is well-formed
            $test_dom = new DOMDocument();
            libxml_clear_errors();
            $valid = @$test_dom->load( $temp_file );
            $errors = libxml_get_errors();
            libxml_clear_errors();
            
            if ( ! $valid || ! empty( $errors ) ) {
                throw new Exception( 'Formatted XML is not valid' );
            }
            
            unset( $test_dom );
            
            // Atomic rename: replace original with formatted file
            if ( ! rename( $temp_file, $file ) ) {
                throw new Exception( 'Failed to replace original file with formatted version' );
            }
            
            // Success - remove backup
            if ( file_exists( $backup_file ) ) {
                if ( ! unlink( $backup_file ) ) {
                    $this->log_xml_error( 'Warning: Failed to delete backup file', $backup_file );
                }
            }
            
            // Clear DOM from memory
            unset( $dom );
            
            // Restore previous libxml error state
            libxml_use_internal_errors( $previous_libxml_errors );
            
            return true;
            
        } catch ( Exception $e ) {
            // Log the error
            $this->log_xml_error( 'XML formatting failed: ' . $e->getMessage(), $file, array(
                'file_size' => $file_size,
                'trace' => $e->getTraceAsString(),
            ) );
            
            // Cleanup temp file if it exists
            if ( file_exists( $temp_file ) ) {
                if ( ! unlink( $temp_file ) ) {
                    $this->log_xml_error( 'Warning: Failed to delete temp file', $temp_file );
                }
            }
            
            // Restore from backup
            if ( file_exists( $backup_file ) ) {
                if ( @copy( $backup_file, $file ) ) {
                    // Successfully restored, now delete backup
                    if ( ! unlink( $backup_file ) ) {
                        $this->log_xml_error( 'Warning: Failed to delete backup after restore', $backup_file );
                    }
                } else {
                    $this->log_xml_error( 'CRITICAL: Failed to restore from backup', $file );
                    // Keep backup file since restore failed
                }
            }
            
            // Cleanup
            unset( $dom, $writer );
            
            // Restore previous libxml error state
            libxml_use_internal_errors( $previous_libxml_errors );
            
            return false;
        }
    }
    
    /**
     * Log XML formatting errors
     * 
     * @since 13.5.3
     * 
     * @param string $message Error message
     * @param string $file File path
     * @param array $context Additional context
     * @return void
     */
    private function log_xml_error( $message, $file = '', $context = array() ) {
        if ( function_exists( 'wc_get_logger' ) ) {
            $logger = wc_get_logger();
            $log_context = array_merge(
                array(
                    'source' => 'woo-product-feed-pro',
                    'file' => $file,
                ),
                $context
            );
            $logger->error( 'XML Formatting: ' . $message, $log_context );
        }
        
        // Also log to PHP error log if WP_DEBUG is enabled
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'WooSEA XML Formatting Error: ' . $message . ( $file ? ' [File: ' . $file . ']' : '' ) );
        }
    }

    /**
     * Recursively write a DOM node using XMLWriter
     * 
     * Production-ready with error handling and edge case management
     * 
     * @since 13.5.3
     * 
     * @param DOMNode $node The DOM node to write
     * @param XMLWriter $writer The XMLWriter instance
     * @param array $declared_namespaces Track namespaces already declared in parent elements
     * @param DOMXPath $xpath DOMXPath instance (passed for performance, created once per document)
     * @return void
     * @throws Exception If critical writing error occurs
     */
    private function woosea_write_dom_node_with_xmlwriter( $node, $writer, $declared_namespaces = array(), $xpath = null ) {
        // Validate inputs
        if ( ! $node || ! $writer ) {
            return;
        }
        
        if ( $node->nodeType === XML_ELEMENT_NODE ) {
            // Start element (without namespace declaration - we'll add xmlns manually)
            try {
                if ( ! empty( $node->prefix ) && ! empty( $node->localName ) ) {
                    // Element with prefix (e.g., g:id)
                    $element_name = $node->prefix . ':' . $node->localName;
                    if ( ! $writer->startElement( $element_name ) ) {
                        throw new Exception( 'Failed to start element: ' . $element_name );
                    }
                } elseif ( ! empty( $node->nodeName ) ) {
                    // Element without prefix
                    if ( ! $writer->startElement( $node->nodeName ) ) {
                        throw new Exception( 'Failed to start element: ' . $node->nodeName );
                    }
                } else {
                    // Invalid element name - skip
                    return;
                }
            } catch ( Exception $e ) {
                // Log but don't halt the entire process
                $this->log_xml_error( 'Element write error: ' . $e->getMessage() );
                return;
            }
            
            // First, write namespace declarations if this is the root or a new namespace scope
            try {
                // Use passed XPath instance for performance (avoids creating one per element)
                if ( ! $xpath ) {
                    // Fallback: create XPath if not provided (shouldn't happen but safety check)
                    $xpath = new DOMXPath( $node->ownerDocument );
                }
                
                $xmlns_nodes = $xpath->query( 'namespace::*', $node );
                
                if ( $xmlns_nodes ) {
                    foreach ( $xmlns_nodes as $xmlns_node ) {
                        $prefix = $xmlns_node->localName;
                        $uri = $xmlns_node->nodeValue;
                        
                        // Skip xml namespace (it's built-in)
                        if ( $prefix === 'xml' ) {
                            continue;
                        }
                        
                        // Validate URI
                        if ( empty( $uri ) ) {
                            continue;
                        }
                        
                        // Check if this namespace was declared by parent
                        if ( ! isset( $declared_namespaces[ $prefix ] ) || $declared_namespaces[ $prefix ] !== $uri ) {
                            // Write namespace declaration
                            if ( $prefix === 'xmlns' || empty( $prefix ) ) {
                                $writer->writeAttribute( 'xmlns', $uri );
                            } else {
                                $writer->writeAttribute( 'xmlns:' . $prefix, $uri );
                            }
                            $declared_namespaces[ $prefix ] = $uri;
                        }
                    }
                }
            } catch ( Exception $e ) {
                // Log namespace error but continue
                $this->log_xml_error( 'Namespace processing error: ' . $e->getMessage() );
            }
            
            // Write regular attributes (skip xmlns ones as we handled them above)
            if ( $node->hasAttributes() ) {
                try {
                    foreach ( $node->attributes as $attr ) {
                        // Skip namespace declarations (already written)
                        if ( strpos( $attr->name, 'xmlns' ) === 0 ) {
                            continue;
                        }
                        
                        // Validate attribute name and value
                        if ( empty( $attr->name ) ) {
                            continue;
                        }
                        
                        // Write the attribute with proper encoding
                        $attr_value = $attr->value !== null ? $attr->value : '';
                        $writer->writeAttribute( $attr->name, $attr_value );
                    }
                } catch ( Exception $e ) {
                    // Log attribute error but continue
                    $this->log_xml_error( 'Attribute write error: ' . $e->getMessage() );
                }
            }
            
            // Write child nodes - pass down the declared namespaces and xpath
            if ( $node->hasChildNodes() ) {
                foreach ( $node->childNodes as $child ) {
                    // Recursively process child nodes
                    $this->woosea_write_dom_node_with_xmlwriter( $child, $writer, $declared_namespaces, $xpath );
                }
            }
            
            // End element
            try {
                $writer->endElement();
            } catch ( Exception $e ) {
                $this->log_xml_error( 'Failed to end element: ' . $e->getMessage() );
            }
            
        } elseif ( $node->nodeType === XML_TEXT_NODE ) {
            // Write text content only if not empty or whitespace-only between elements
            if ( $node->nodeValue !== null && $node->nodeValue !== '' ) {
                try {
                    $writer->text( $node->nodeValue );
                } catch ( Exception $e ) {
                    $this->log_xml_error( 'Text node write error: ' . $e->getMessage() );
                }
            }
            
        } elseif ( $node->nodeType === XML_CDATA_SECTION_NODE ) {
            // Write CDATA section with validation
            if ( $node->nodeValue !== null ) {
                try {
                    $writer->writeCdata( $node->nodeValue );
                } catch ( Exception $e ) {
                    // If CDATA fails, try as regular text
                    try {
                        $writer->text( $node->nodeValue );
                    } catch ( Exception $e2 ) {
                        $this->log_xml_error( 'CDATA/text write error: ' . $e->getMessage() );
                    }
                }
            }
            
        } elseif ( $node->nodeType === XML_COMMENT_NODE ) {
            // Preserve comments
            if ( $node->nodeValue !== null ) {
                try {
                    $writer->writeComment( $node->nodeValue );
                } catch ( Exception $e ) {
                    // Comments are not critical, just skip
                }
            }
        }
        // Other node types (processing instructions, etc.) are intentionally skipped
    }

    /**
     * Recursive trim
     * 
     * @param mixed $value
     * @return mixed
     */
    private function woosea_recursive_trim( $value ) {
        if ( is_array( $value ) ) {
            return array_map( array( $this, 'woosea_recursive_trim' ), $value );
        }
        return trim( $value );
    }

    /**
     * Write individual product to XML
     * 
     * @param object $product
     * @param string $k
     * @param string $v
     * @param array $feed_config
     * @param array $channel_attributes
     * @param object $feed
     */
    private function woosea_write_individual_product_to_xml( $product, $k, $v, $feed_config, $channel_attributes, $feed ) {
        /**
         * General filter for any attribute to allow external handling (e.g., for OpenAI or future feeds).
         * 
         * @since 13.4.9
         *
         * @param bool   $handled            If returned true, skip all default processing for this key.
         * @param object $product            The XML element object.
         * @param string $k                  The attribute key/name.
         * @param string $v                  The attribute value.
         * @param array  $feed_config        The feed configuration array.
         * @param array  $channel_attributes The channel attributes array.
         * @param object $feed               The feed object.
         * @return bool If returned true, skip all default processing for this key.
         */
        $handled = apply_filters(
            'adt_product_feed_xml_attribute_handling',
            false,  // Default: not handled
            $product,
            $k,
            $v,
            $feed_config,
            $channel_attributes,
            $feed
        );

        // If handled externally, skip all default processing for this key.
        if ( $handled ) {
            return;  // Exit the method early.
        }

        if ( ( $k == 'id' ) && ( $feed_config['name'] == 'Yandex' ) ) {
            if ( isset( $product ) ) {
                if ( ! empty( $v ) ) {
                    $product->addAttribute( 'id', trim( $v ) );
                }
            }
        }

        if ( ( preg_match( '/picture/i', $k ) ) && ( $feed_config['name'] == 'Yandex' ) ) {
            if ( isset( $product ) ) {
                if ( ! empty( $v ) ) {
                    $additional_picture_link = $product->addChild( 'picture', $v );
                }
            }
        }

        if ( ( $k == 'item_group_id' ) && ( $feed_config['name'] == 'Yandex' ) ) {
            $product->addAttribute( 'group_id', trim( $v ) );
        }

        if ( ( $k == 'color' ) && ( $feed_config['name'] == 'Skroutz' ) ) {
            if ( preg_match( '/,/', $v ) ) {
                $cls = explode( ',', $v );

                if ( is_array( $cls ) ) {
                    foreach ( $cls as $kkx => $vvx ) {
                        if ( ! empty( $vvx ) ) {
                            $additional_color = $product->addChild( 'color', trim( $vvx ) );
                        }
                    }
                }
            } elseif ( preg_match( '/\\s/', $v ) ) {
                $clp = explode( ' ', $v );

                if ( is_array( $clp ) ) {
                    foreach ( $clp as $kkx => $vvx ) {
                        if ( ! empty( $vvx ) ) {
                            if ( ! is_null( $product ) ) {
                                $additional_color = $product->addChild( 'color', trim( $v ) );
                                // $additional_color = $product->addChild('color',trim($vvx));
                            }
                        }
                    }
                }
            }
        }

        if ( ( $k == 'available' ) && ( $feed_config['name'] == 'Yandex' ) ) {
            if ( $v == 'in stock' ) {
                $v = 'true';
            } else {
                $v = 'false';
            }
            $product->addAttribute( 'available', $v );
        }

        /**
         * Check if a product resides in multiple categories
         * id so, create multiple category child nodes
         */
        if ( $k == 'categories' ) {
            if ( ( ! isset( $product->categories ) ) && ( isset( $product ) ) ) {
                $category = $product->addChild( 'categories' );
                $cat      = explode( '||', $v );

                if ( is_array( $cat ) ) {
                    foreach ( $cat as $kk => $vv ) {
                        $child = 'category';
                        $category->addChild( "$child", htmlspecialchars( $vv ) );
                    }
                }
            }
        } elseif ( preg_match( '/^additionalimage/', $k ) ) {
            if ( ! empty( $v ) ) {
                $additional_image_link = $product->addChild( 'additionalimage', $v );
            }
        } elseif ( preg_match( '/^additional_imageurl/', $k ) ) {
            if ( ! empty( $v ) ) {
                $additional_image_link = $product->addChild( 'additional_imageurl', $v );
            }
        } elseif ( $k == 'shipping' ) {
            $expl = '||';
            if ( strpos( $v, $expl ) ) {
                $ship = explode( '||', $v );
                foreach ( $ship as $kk => $vv ) {
                    $ship_zone  = $product->addChild( 'shipping' );
                    $ship_split = explode( ':', $vv );

                    foreach ( $ship_split as $ship_piece ) {
                        $piece_value = explode( '##', $ship_piece );
                        if ( preg_match( '/WOOSEA_COUNTRY/', $ship_piece ) ) {
                            $shipping_country = $ship_zone->addChild( 'country', htmlspecialchars( $piece_value[1] ) );
                        } elseif ( preg_match( '/WOOSEA_REGION/', $ship_piece ) ) {
                            $shipping_region = $ship_zone->addChild( 'region', htmlspecialchars( $piece_value[1] ) );
                        } elseif ( preg_match( '/WOOSEA_POSTAL_CODE/', $ship_piece ) ) {
                            $postal_code = $ship_zone->addChild( 'postal_code', htmlspecialchars( $piece_value[1] ) );
                        } elseif ( preg_match( '/WOOSEA_SERVICE/', $ship_piece ) ) {
                            $shipping_service = $ship_zone->addChild( 'service', htmlspecialchars( $piece_value[1] ) );
                        } elseif ( preg_match( '/WOOSEA_PRICE/', $ship_piece ) ) {
                            $shipping_price = $ship_zone->addChild( 'price', htmlspecialchars( $piece_value[1] ) );
                        } elseif ( preg_match( '/WOOSEA_MIN_TRANSIT_TIME/', $ship_piece ) ) {
                            $ship_zone->addChild( 'min_transit_time', htmlspecialchars( $piece_value[1] ) );
                        } elseif ( preg_match( '/WOOSEA_MAX_TRANSIT_TIME/', $ship_piece ) ) {
                            $ship_zone->addChild( 'max_transit_time', htmlspecialchars( $piece_value[1] ) );
                        } elseif ( preg_match( '/WOOSEA_MIN_HANDLING_TIME/', $ship_piece ) ) {
                            $ship_zone->addChild( 'min_handling_time', htmlspecialchars( $piece_value[1] ) );
                        } elseif ( preg_match( '/WOOSEA_MAX_HANDLING_TIME/', $ship_piece ) ) {
                            $ship_zone->addChild( 'max_handling_time', htmlspecialchars( $piece_value[1] ) );
                        } else {
                            // DO NOT ADD ANYTHING
                        }
                    }
                }
            } else {
                $child       = 'shipping';
                $product->$k = $v;
            }
        } elseif ( $k == 'category_link' ) {
            $category  = $product->addChild( 'category_links' );
            $cat_links = explode( '||', $v );
            if ( is_array( $cat_links ) ) {
                foreach ( $cat_links as $kk => $vv ) {
                    $child = 'category_link';
                    $category->addChild( "$child", htmlspecialchars( $vv ) );
                }
            }
        } elseif ( $k == 'categoryId' ) {

            if ( $feed_config['name'] == 'Yandex' ) {
                // $category = $product->addChild('categories');
                $product_categories = get_terms(
                    array(
                     'taxonomy' => 'product_cat',
                    ) 
                );
                $count              = count( $product_categories );
                $cat                = explode( '||', $v );

                if ( is_array( $cat ) ) {
                    foreach ( $cat as $kk => $vv ) {
                        if ( $count > 0 ) {
                            foreach ( $product_categories as $product_category ) {
                                if ( $vv == $product_category->name ) {
                                    $product->addChild( "$k", htmlspecialchars( $product_category->term_id ) );
                                }
                            }
                        }
                    }
                }
            }
        } elseif ( ( $k == 'id' || $k == 'item_group_id' || $k == 'available' ) && ( $feed_config['name'] == 'Yandex' ) ) {
            // Do not add these nodes to Yandex product feeds
        } elseif ( $k == 'CATEGORYTEXT' ) {
            $v = str_replace( '||', ' | ', $v );
            $product->addChild( "$k" );
            $product->$k = $v;
        } else {
            if ( ! empty( $k ) ) {
                /**
                 * Some Zbozi, Mall and Heureka attributes need some extra XML nodes
                 */
                $zbozi_nodes = 'PARAM_';

                if ( ( ( $feed_config['name'] == 'Zbozi.cz' ) || ( $feed_config['name'] == 'Mall.sk' ) || ( $feed_config['name'] == 'Glami.gr' ) || ( $feed_config['name'] == 'Glami.sk' ) || ( $feed_config['name'] == 'Glami.cz' ) || ( $feed_config['name'] == 'Heureka.cz' ) || ( $feed_config['name'] == 'Heureka.sk' ) ) && ( preg_match( "/$zbozi_nodes/i", $k ) ) ) {
                    $pieces   = explode( '_', $k, 2 );
                    $productp = $product->addChild( 'PARAM' );
                    if ( $feed_config['name'] == 'Mall.sk' ) {
                        $productp->addChild( 'NAME', $pieces[1] );
                        $productp->addChild( 'VALUE', $v );
                    } else {
                        $productp->addChild( 'PARAM_NAME', $pieces[1] );
                        $productp->addChild( 'VAL', $v );
                    }
                } elseif ( ( $feed_config['name'] == 'Mall.sk' ) && ( $k == 'VARIABLE_PARAMS' ) ) {
                    if ( isset( $value['ITEMGROUP_ID'] ) ) {
                        $productvp          = $product->addChild( 'VARIABLE_PARAMS' );
                        $product_variations = new WC_Product_Variation( $value['ID'] );
                        if ( is_object( $product_variations ) ) {
                            $variations = $product_variations->get_variation_attributes( false );
                            foreach ( $variations as $k => $v ) {
                                $k = str_replace( 'pa_', '', $k );
                                $productvp->addChild( 'PARAM', $k );
                            }
                        }
                    }
                } elseif ( ( $feed_config['name'] == 'Mall.sk' ) && ( $k == 'MEDIA' ) ) {
                    $productp = $product->addChild( 'MEDIA' );
                    $productp->addChild( 'URL', $v );
                    $productp->addChild( 'MAIN', 'true' );
                } elseif ( ( $feed_config['name'] == 'Mall.sk' ) && ( $k == 'MEDIA_1' ) ) {
                    $productp = $product->addChild( 'MEDIA' );
                    $productp->addChild( 'URL', $v );
                    $productp->addChild( 'MAIN', 'false' );
                } elseif ( ( $feed_config['name'] == 'Mall.sk' ) && ( $k == 'MEDIA_2' ) ) {
                    $productp = $product->addChild( 'MEDIA' );
                    $productp->addChild( 'URL', $v );
                    $productp->addChild( 'MAIN', 'false' );
                } elseif ( ( $feed_config['name'] == 'Mall.sk' ) && ( $k == 'MEDIA_3' ) ) {
                    $productp = $product->addChild( 'MEDIA' );
                    $productp->addChild( 'URL', $v );
                    $productp->addChild( 'MAIN', 'false' );
                } elseif ( ( $feed_config['name'] == 'Mall.sk' ) && ( $k == 'MEDIA_4' ) ) {
                    $productp = $product->addChild( 'MEDIA' );
                    $productp->addChild( 'URL', $v );
                    $productp->addChild( 'MAIN', 'false' );
                } elseif ( ( $feed_config['name'] == 'Mall.sk' ) && ( $k == 'MEDIA_5' ) ) {
                    $productp = $product->addChild( 'MEDIA' );
                    $productp->addChild( 'URL', $v );
                    $productp->addChild( 'MAIN', 'false' );
                } elseif ( ( ( $feed_config['name'] == 'Zbozi.cz' ) || ( $feed_config['name'] == 'Heureka.cz' ) ) && ( $k == 'DELIVERY' ) ) {
                    $delivery       = $product->addChild( 'DELIVERY' );
                    $delivery_split = explode( '##', $v );
                    $nr_split       = count( $delivery_split );

                    $zbozi_delivery_id = array(
                        0  => 'CESKA_POSTA_BALIKOVNA',
                        1  => 'CESKA_POSTA_NA_POSTU',
                        2  => 'DPD_PICKUP',
                        3  => 'GEIS_POINT',
                        4  => 'GLS_PARCELSHOP',
                        5  => 'PPL_PARCELSHOP',
                        6  => 'TOPTRANS_DEPO',
                        7  => 'WEDO_ULOZENKA',
                        8  => 'ZASILKOVNA',
                        9  => 'VLASTNI_VYDEJNI_MISTA',
                        10 => 'CESKA_POSTA',
                        11 => 'DB_SCHENKER',
                        12 => 'DPD',
                        13 => 'DHL',
                        14 => 'DSV',
                        15 => 'FOFR',
                        16 => 'GEBRUDER_WEISS',
                        17 => 'GEIS',
                        18 => 'GLS',
                        19 => 'HDS',
                        20 => 'WEDO_HOME',
                        21 => 'MESSENGER',
                        22 => 'PPL',
                        23 => 'TNT',
                        24 => 'TOPTRANS',
                        25 => 'UPS',
                        26 => 'FEDEX',
                        27 => 'RABEN_LOGISTICS',
                        28 => 'RHENUS',
                        29 => 'ZASILKOVNA_NA_ADRESU',
                        30 => 'VLASTNI_PREPRAVA',
                    );

                    if ( $nr_split == 7 ) {
                        $delivery_id_split    = explode( ' ', $delivery_split[2] );
                        $delivery_price_split = explode( '||', $delivery_split[3] );
                        $delivery_id          = $delivery->addChild( 'DELIVERY_ID', htmlspecialchars( $delivery_id_split[0] ) );

                        $delivery_price_split[0] = str_replace( 'EUR', '', $delivery_price_split[0] );
                        $delivery_price_split[0] = str_replace( 'CZK', '', $delivery_price_split[0] );

                        $delivery_price     = $delivery->addChild( 'DELIVERY_PRICE', trim( htmlspecialchars( $delivery_price_split[0] ) ) );
                        $delivery_price_cod = $delivery->addChild( 'DELIVERY_PRICE_COD', trim( htmlspecialchars( $delivery_split[6] ) ) );
                    } elseif ( $nr_split > 1 ) {
                        $zbozi_split = explode( ' ', $delivery_split[2] );
                        foreach ( $zbozi_split as $zbozi_id ) {
                            if ( in_array( $zbozi_id, $zbozi_delivery_id ) ) {
                                $delivery_split[2] = $zbozi_id;
                            }
                        }

                        $delivery_split[3] = str_replace( 'EUR', '', $delivery_split[3] );
                        $delivery_split[3] = str_replace( 'CZK', '', $delivery_split[3] );

                        $delivery_id     = $delivery->addChild( 'DELIVERY_ID', htmlspecialchars( $delivery_split[2] ) );
                        $del_price_split = explode( ' ', trim( $delivery_split[3] ) );
                        $delivery_id     = $delivery->addChild( 'DELIVERY_PRICE', trim( htmlspecialchars( $delivery_split[3] ) ) );
                    }
                } elseif ( ( $feed_config['name'] == 'Yandex' ) && ( preg_match( '/picture/i', $k ) ) ) {
                    // do nothing, was added already
                } elseif ( ( $feed_config['name'] == 'Yandex' ) && ( preg_match( "/$zbozi_nodes/i", $k ) ) ) {
                    $pieces   = explode( '_', $k );
                    $p        = 'param';
                    $productp = $product->addChild( $p, $v );
                    $productp->addAttribute( 'name', $pieces[1] );
                } elseif ( $feed_config['name'] == 'Google Product Review' ) {
                } elseif ( $feed_config['name'] == 'Vivino' ) {
                    $extra_arr = array( 'ean', 'jan', 'upc', 'producer', 'wine-name', 'appellation', 'vintage', 'country', 'color', 'image', 'description', 'alcohol', 'producer-address', 'importer-address', 'varietal', 'ageing', 'closure', 'winemaker', 'production-size', 'residual-sugar', 'acidity', 'ph', 'contains-milk-allergens', 'contains-egg-allergens', 'non-alcoholic' );
                    $unit_arr  = array( 'production-size', 'residual-sugar', 'acidity' );

                    if ( in_array( $k, $extra_arr ) ) {
                        if ( ! isset( $product->extras ) ) {
                            $productp = $product->addChild( 'extras' );
                        }

                        // Add units to it
                        if ( in_array( $k, $unit_arr ) ) {
                            $productk = $productp->addChild( $k, $v );
                            if ( $k == 'acidity' ) {
                                $productk->addAttribute( 'unit', 'g/l' );
                            }
                            if ( $k == 'production-size' ) {
                                $productk->addAttribute( 'unit', 'bottles' );
                            }
                            if ( $k == 'residual-sugar' ) {
                                $productk->addAttribute( 'unit', 'g/l' );
                            }
                        } else {
                            $productp->$k = $v;
                        }
                    } else {
                        $product->addChild( "$k" );
                        $product->$k = $v;
                    }
                } elseif ( $feed_config['name'] == 'Fruugo.nl' ) {
                    $desc_arr  = array( 'Language', 'Title', 'Description' );
                    $price_arr = array( 'Currency', 'NormalPriceWithoutVAT', 'NormalPriceWithVAT', 'VATRate' );

                    if ( in_array( $k, $desc_arr ) ) {
                        if ( ! isset( $product->Description ) ) {
                            $productd = $product->addChild( 'Description' );
                        }
                        $productd->$k = $v;
                    } elseif ( in_array( $k, $price_arr ) ) {
                        if ( ! isset( $product->Price ) ) {
                            $productp = $product->addChild( 'Price' );
                        }
                        $productp->$k = $v;
                    } else {
                        $product->addChild( "$k" );
                        $product->$k = $v;
                    }
                } elseif ( $feed_config['name'] == 'Fruugo.co.uk' ) {
                    $desc_arr  = array( 'Language', 'Title', 'Description' );
                    $price_arr = array( 'Currency', 'NormalPriceWithoutVAT', 'NormalPriceWithVAT', 'VATRate' );

                    if ( in_array( $k, $desc_arr ) ) {
                        if ( ! isset( $product->Description ) ) {
                            $productd = $product->addChild( 'Description' );
                        }
                        $productd->$k = $v;
                    } elseif ( in_array( $k, $price_arr ) ) {
                        if ( ! isset( $product->Price ) ) {
                            $productp = $product->addChild( 'Price' );
                        }
                        $productp->$k = $v;
                    } else {
                        $product->addChild( "$k" );
                        $product->$k = $v;
                    }
                } elseif ( $feed_config['name'] == 'Pinterest RSS Board' && $k === 'image' ) {
                    if ( ! empty( $v ) ) {
                        $media_content = $product->addChild( 'media:content', '', 'http://search.yahoo.com/mrss/' );
                        $media_content->addAttribute( 'medium', 'image' );
                        $media_content->addAttribute( 'url', $v );
                    }
                } elseif ( $feed_config['name'] == 'Pinterest RSS Board' && $k === 'guid' ) {
                    if ( ! empty( $v ) ) {
                        $guid = $product->addChild( 'guid', $v );
                        $guid->addAttribute( 'isPermaLink', 'true' );
                    }
                } elseif ( $feed_config['name'] == 'Skroutz' ) {
                    if ( 'skroutz_variations' == $k ) {
                        $this->woosea_create_skroutz_variations( $product, $v );
                    } else {
                        if ( ! isset( $product->$k ) ) {
                            $product->addChild( $k, htmlspecialchars( $v, ENT_XML1, 'UTF-8' ) );
                        }
                    }
                } elseif ( is_object( $product ) && ! isset( $product->$k ) ) {
                    // Check if this field should use CDATA for HTML preservation
                    $use_cdata = $this->should_use_cdata_for_field( $k, $feed_config, $feed );

                    // Handle Google Shopping namespace for g: prefixed elements
                    if ( ( $feed_config['taxonomy'] == 'google_shopping' ) && ( strpos( $k, 'g:' ) === 0 ) ) {
                        $this->add_child_with_cdata( $product, $k, $v, 'http://base.google.com/ns/1.0', $use_cdata );
                    } else {
                        $this->add_child_with_cdata( $product, $k, $v, '', $use_cdata );
                    }
                }
            }
        }
    }

    /**
     * Check if a field should be wrapped in CDATA for the given feed.
     * 
     * @since 13.5.1
     * 
     * @param string $field_name The field name to check.
     * @param array  $feed_config The feed configuration array.
     * @param object $feed The feed object.
     * @return bool True if field should use CDATA, false otherwise.
     */
    private function should_use_cdata_for_field( $field_name, $feed_config, $feed ) {
        // Define fields that may contain HTML content
        $html_content_fields = array(
            // Google Shopping & Facebook DRM (with g: namespace).
            'g:description',
            'g:structured_description',
            
            // Bing Shopping (without namespace prefix).
            'description',
            'short_description',
            
            // Facebook DRM.
            'rich_text_description',
        );

        /**
         * Filter the fields that should use CDATA wrapping.
         *
         * @since 13.5.1
         *
         * @param array  $html_content_fields The fields that should use CDATA.
         * @param array  $feed_config         The feed configuration array.
         * @param object $feed                The feed object.
         */
        $html_content_fields = apply_filters(
            'adt_product_feed_cdata_fields',
            $html_content_fields,
            $feed_config,
            $feed
        );

        if ( ! in_array( $field_name, $html_content_fields, true ) ) {
            return false;
        }

        // Check if the platform/channel allows HTML formatting
        $platforms_allowing_html = array(
            'bing_shopping',
            'bing_shopping_promotions',
            'facebook_drm',
            'google_shopping',
            'google_drm',
            'google_dsa',
            'google_local',
            'google_local_products',
            'google_product_review',
            'google_shopping_promotions',
        );

        /**
         * Filter the platforms that support HTML in descriptions.
         *
         * @since 13.5.1
         *
         * @param array  $platforms_allowing_html The platforms that support HTML.
         * @param array  $feed_config             The feed configuration array.
         * @param object $feed                    The feed object.
         */
        $platforms_allowing_html = apply_filters(
            'adt_product_feed_cdata_platforms',
            $platforms_allowing_html,
            $feed_config,
            $feed
        );

        $channel = isset( $feed_config['taxonomy'] ) ? $feed_config['taxonomy'] : '';
        
        return in_array( $channel, $platforms_allowing_html, true );
    }

    /**
     * Add a child element with CDATA support to the XML.
     * 
     * @since 13.5.1
     * 
     * @param object $parent The parent XML element.
     * @param string $name The name of the child element.
     * @param string $value The value to add (will be wrapped in CDATA if needed).
     * @param string $namespace Optional namespace URI.
     * @param bool   $use_cdata Whether to wrap value in CDATA.
     * @return object|null The created child element or null on failure.
     */
    private function add_child_with_cdata( $parent, $name, $value, $namespace = '', $use_cdata = false ) {
        if ( ! is_object( $parent ) ) {
            return null;
        }

        if ( ! $use_cdata ) {
            // Standard behavior - escape HTML entities
            if ( ! empty( $namespace ) ) {
                return $parent->addChild( $name, htmlspecialchars( $value, ENT_XML1, 'UTF-8' ), $namespace );
            } else {
                return $parent->addChild( $name, htmlspecialchars( $value, ENT_XML1, 'UTF-8' ) );
            }
        }

        // CDATA behavior - preserve HTML within CDATA section
        // SimpleXML doesn't support CDATA natively, so we need to use DOM
        try {
            // Create the child element first (empty)
            if ( ! empty( $namespace ) ) {
                $child = $parent->addChild( $name, '', $namespace );
            } else {
                $child = $parent->addChild( $name );
            }

            // Get the DOM element from SimpleXML
            $dom_element = dom_import_simplexml( $child );
            $dom_document = $dom_element->ownerDocument;

            // Create CDATA section with the value
            $cdata = $dom_document->createCDATASection( $value );
            
            // Append CDATA to the element
            $dom_element->appendChild( $cdata );

            return $child;
        } catch ( \Exception $e ) {
            // Fallback to standard behavior if CDATA fails
            if ( ! empty( $namespace ) ) {
                return $parent->addChild( $name, htmlspecialchars( $value, ENT_XML1, 'UTF-8' ), $namespace );
            } else {
                return $parent->addChild( $name, htmlspecialchars( $value, ENT_XML1, 'UTF-8' ) );
            }
        }
    }

    /**
     * Create Skroutz variations
     * 
     * @param object $product Product object
     * @param array $variation_data Variation data
     */
    private function woosea_create_skroutz_variations( $product, $variation_data ) {
        $change_skroutz_variation_child = apply_filters(
            'woosea_change_skroutz_variation_child',
            array(
                'id' => 'variationid',
            )
        );

        $skroutz_variations_attributes = apply_filters(
            'woosea_skroutz_variations_attributes',
            array(
                'variationid',
                'link',
                'availability',
                'size',
                'quantity',
                'manufacturersku',
                'ean',
                'price_with_vat',
            )
        );
        
        $product->addChild( 'variations' );
        foreach ( $variation_data as $variation ) {
            if ( ! is_array( $variation ) || empty( $variation ) ) {
                continue;
            }

            $child_variation = $product->variations->addChild( 'variation' );
            foreach ( $variation as $variation_key => $variation_value ) {
                $child_variation_key = $variation_key;
                $child_variation_value = $variation_value;
                
                if ( in_array( $variation_key, array_keys( $change_skroutz_variation_child ) ) ) {
                    $child_variation_key = $change_skroutz_variation_child[ $variation_key ];
                }

                if ( in_array( $child_variation_key, $skroutz_variations_attributes ) ) {
                    $child_variation->addChild( $child_variation_key );
                    $child_variation->$child_variation_key = $child_variation_value;
                }
            }
        }
    }

    /**
     * Actual creation of CSV/TXT feed
     * Returns relative and absolute file path
     */
    public function woosea_create_csvtxt_feed( $products, $feed, $header ) {
        $upload_dir  = wp_upload_dir();
        $base        = $upload_dir['basedir'];
        // For csv.gz, write the plain CSV tmp file under the 'csv' directory.
        $base_format = Product_Feed::get_base_file_format( $feed->file_format );
        $path        = $base . '/woo-product-feed-pro/' . $base_format;
        $file        = $path . '/' . sanitize_file_name( $feed->file_name ) . '_tmp.' . $base_format;

        // External location for downloading the file (points to the final compressed file if gz).
        $external_base = $upload_dir['baseurl'];
        $external_path = $external_base . '/woo-product-feed-pro/' . $base_format;
        $external_file = $external_path . '/' . sanitize_file_name( $feed->file_name ) . '.' . $feed->file_format;

        // Check if directory in uploads exists, if not create one
        if ( ! file_exists( $path ) ) {
            wp_mkdir_p( $path );
        }

        // Check if file exists, if it does: delete it first so we can create a new updated one
        if ( ( file_exists( $file ) ) && ( $feed->total_products_processed == 0 ) && ( $header == 'true' ) ) {
            @unlink( $file );
        }

        // Check if there is a channel feed class that we need to use
        $fields = $feed->get_channel( 'fields' );

        if ( empty( $fields ) ) {
            return $external_file;
        }

        // Load channel attributes if needed
        $channel_attributes = $this->load_channel_attributes($fields);

        // Append or write to file
        $fp = fopen( $file, 'a+' );

        // Set proper UTF encoding BOM for CSV files
        if ( $header == 'true' && ! preg_match( '/fruugo/i', $fields ) ) {
            fputs( $fp, $bom = chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
        }

        // Set delimiter
        $csv_delimiter = ($feed->delimiter == 'tab') ? "\t" : $feed->delimiter;

        // Process each product row
        foreach ( $products as $row ) {
            foreach ( $row as $k => $v ) {
                $pieces = explode( "','", $v );
                
                if ( empty( $pieces ) ) {
                    $pieces = array_map( 'trim', $pieces );
                    fputcsv( $fp, $pieces, $csv_delimiter, '"', '\\' );
                    continue;
                }

                // Special handling for Google Local feeds
                if ( $fields == 'google_local' && $header == 'false' ) {
                    $this->process_google_local_feed($fp, $pieces, $feed, $fields, $channel_attributes, $header, $csv_delimiter);
                    continue;
                }
                
                // Process standard feed format
                $csv_line = $this->prepare_csv_line($pieces, $fields, $channel_attributes, $header, $feed);
                fputcsv( $fp, $csv_line, $csv_delimiter, '"', '\\' );
            }
        }
        
        // Close the file
        fclose( $fp );

        // Return external location of feed
        return $external_file;
    }

    /**
     * Load channel attributes for a specific feed type
     * 
     * @param string $fields The feed field type
     * @throws \Exception If invalid channel name detected
     * @return array Channel attributes
     */
    private function load_channel_attributes($fields) {
        $channel_attributes = array();
        
        if ( $fields != 'standard' && $fields != 'customfeed' ) {
            if ( ! class_exists( 'WooSEA_' . $fields ) ) {
                // Sanitize channel name to prevent path traversal attacks
                $channel_name = sanitize_file_name( $fields );
                
                // Additional validation: only allow alphanumeric characters and underscores
                if ( ! preg_match( '/^[a-zA-Z0-9_]+$/', $channel_name ) ) {
                    throw new \Exception( 'Invalid channel name detected: ' . $fields );
                }
                
                $channel_file_path = plugin_dir_path( __FILE__ ) . '/channels/class-' . $channel_name . '.php';
                
                // Verify the file is within the channels directory (prevent directory traversal)
                $real_path = realpath( $channel_file_path );
                $channels_dir = realpath( plugin_dir_path( __FILE__ ) . '/channels' );
                
                if ( $real_path && $channels_dir && strpos( $real_path, $channels_dir ) === 0 && file_exists( $real_path ) ) {
                    require $real_path;
                    $channel_class      = 'WooSEA_' . $channel_name;
                    $channel_attributes = $channel_class::get_channel_attributes();
                }
            }
        }
        
        return $channel_attributes;
    }

    /**
     * Process Google Local feed format
     * 
     * @param resource $fp File pointer
     * @param array $pieces CSV line pieces
     * @param object $feed Feed object
     * @param string $fields Feed field type
     * @param array $channel_attributes Channel attributes
     * @param string $header Whether this is a header row
     * @param string $csv_delimiter CSV delimiter
     */
    private function process_google_local_feed($fp, $pieces, $feed, $fields, $channel_attributes, $header, $csv_delimiter) {
        // Get the store codes
        $stores_local = '';
        foreach ( $feed->attributes as $attr ) {
            if ( isset( $attr['attribute'] ) && $attr['attribute'] == 'g:store_code' ) {
                $stores_local = $attr['mapfrom'];
                break;
            }
        }
        
        // Process each piece
        $pieces = $this->prepare_csv_line($pieces, $fields, $channel_attributes, $header, $feed);
        
        if ( ! empty( $stores_local ) ) {
            $store_ids = explode( '|', $stores_local );
            
            // If we have multiple store IDs, create a line for each store
            if ( count( $store_ids ) > 1 ) {
                foreach ( $store_ids as $store_value ) {
                    if ( ! empty( $store_value ) ) {
                        // Replace the store code in position 1
                        $pieces_copy = $pieces;
                        $pieces_copy[1] = $store_value;
                        
                        fputcsv( $fp, $pieces_copy, $csv_delimiter, '"', '\\' );
                    }
                }
            } else {
                // Single store code case
                $pieces[1] = trim($stores_local);
                fputcsv( $fp, $pieces, $csv_delimiter, '"', '\\' );
            }
        } else {
            // No store code specified
            fputcsv( $fp, $pieces, $csv_delimiter, '"', '\\' );
        }
    }

    /**
     * Prepare CSV line by processing each piece
     * 
     * @param array $pieces CSV line pieces
     * @param string $fields Feed field type
     * @param array $channel_attributes Channel attributes
     * @param string $header Whether this is a header row
     * @param object $feed Feed object
     * @return array Processed CSV line
     */
    private function prepare_csv_line($pieces, $fields, $channel_attributes, $header, $feed) {
        $csv_line = array();
        
        foreach ( $pieces as $k_inner => $v ) {
            // For CSV fileformat the keys need to get stripped of the g:
            if ( $header === 'true' && in_array( $feed->file_format, array( 'csv', 'txt', 'tsv', 'csv.gz' ), true ) ) {
                $v = str_replace( 'g:', '', $v );
            }

            // Clean up the value
            $v = trim( $v, "\"'" );
            
            $csv_line[] = $v;
        }
        
        return $csv_line;
    }

    /**
     * Get products that are eligable for adding to the file.
     *
     * @since 13.3.5 Updated the parameters to feed id.
     * @since 13.4.1 Add offset and batch size parameters.
     *
     * @param Product_Feed $feed The product feed instance.
     * @param int          $offset The offset of the batch.
     * @param int          $batch_size The batch size.
     */
    public function woosea_get_products( $feed, $offset = 0, $batch_size = 0 ) {
        if ( ! Product_Feed_Helper::is_a_product_feed( $feed ) ) {
            return;
        }

        $nr_products_processed = $feed->total_products_processed;
        $file_format           = $feed->file_format;
        $feed_channel          = $feed->channel;
        $feed_mappings         = $feed->mappings;

        /**
         * Filter the feed attributes before processing products.
         * This allows modification of the attributes array to exclude or modify specific attributes.
         *
         * @since 13.5.0
         * @param array $feed_attributes The feed attributes array.
         * @return array
         */
        $feed_attributes = apply_filters( 'adt_feed_get_attributes', $feed->attributes );

        $feed_rules            = $feed->feed_rules;
        $feed_filters          = $feed->feed_filters;

        if ( empty( $feed_channel ) ) {
            return false;
        }

        // Set class properties.
        $this->file_format = $file_format;

        /**
         * Action hook before getting products.
         *
         * @since 13.3.7
         *
         * @param Product_Feed $feed The product feed instance.
         */
        do_action( 'woosea_before_get_products', $feed );

        /**
         * Check if the [attributes] array in the project_config is of expected format.
         * For channels that have mandatory attribute fields (such as Google shopping) we need to rebuild the [attributes] array
         * Only add fields to the file that the user selected
         * Construct header line for CSV ans TXT files, for XML create the XML root and header
         */
        $products = array();
        if ( $file_format == 'jsonl' || $file_format == 'jsonl.gz' ) {
            // Initialize JSONL feed (no header needed for JSONL format).
            $jsonl_writer = \AdTribes\PFP\Classes\Feed_Writers\Feed_Writer_JSONL::instance();
            $file         = $jsonl_writer->write_feed( array(), $feed, true );
        } elseif ( $file_format != 'xml' ) {
            if ( ! empty( $feed_attributes ) && $nr_products_processed == 0 ) {
                $attr = '';
                foreach ( $feed_attributes as $feed_attribute ) {
                    $attr .= "'" . $feed_attribute['attribute'] . "'";

                    // If last element, do not add a comma.
                    if ( end( $feed_attributes ) !== $feed_attribute ) {
                        $attr .= ',';
                    }
                }

                /**
                 * Filter to allow manipulation of CSV header row before it is written to the feed.
                 * This allows channel-specific handling of header attributes in CSV format.
                 *
                 * @since 13.4.9
                 *
                 * @param string $attr             The CSV header row string
                 * @param array  $feed_attributes  The feed attributes configuration
                 * @param object $feed             The feed object
                 * @return string Modified CSV header row
                 */
                $attr = apply_filters( 'adt_product_feed_csv_header', $attr, $feed_attributes, $feed );

                // Somehow it requires an array, we will do this for now until we refactor the file writing process.
                $file = $this->woosea_create_csvtxt_feed( array( array( $attr ) ), $feed, 'true' );
            }
        } else {
            $products[] = array();
            $file       = $this->woosea_create_xml_feed( $products, $feed, 'true' );
        }
        $xml_piece = array();

        // Get taxonomies
        $no_taxonomies   = array( 'element_category', 'template_category', 'portfolio_category', 'portfolio_skills', 'portfolio_tags', 'faq_category', 'slide-page', 'category', 'post_tag', 'nav_menu', 'link_category', 'post_format', 'product_type', 'product_visibility', 'product_cat', 'product_shipping_class', 'product_tag' );
        $taxonomies      = get_taxonomies();
        $diff_taxonomies = array_diff( $taxonomies, $no_taxonomies );

        // Check if we need to get just products or also product variations
        if ( $feed->include_product_variations ) {
            $post_type = array( 'product', 'product_variation' );
        } else {
            $post_type = array( 'product' );
        }

        // Check shipping currency location
        $feed->ship_suffix = false;
        if ( ! empty( $feed_attributes ) ) {
            foreach ( $feed_attributes as $attr_key => $attr_value ) {
                if ( $attr_value['mapfrom'] == 'shipping' ) {
                    if ( ! empty( $attr_value['suffix'] ) ) {
                        $feed->ship_suffix = true;
                    }
                }
            }
        }

        // Pinteres RSS feeds need different sorting
        if ( $feed_channel['fields'] == 'pinterest_rss' ) {
            $orderby = 'ASC';
        } else {
            $orderby = 'DESC';
        }

        // Get Orders
        if ( $feed->utm_total_product_orders_lookback && $feed->utm_total_product_orders_lookback > 0 ) {
            $allowed_product_orders = \AdTribes\PFP\Classes\Orders::get_orders( $feed );
        }

        unset( $prods );

        // Preview mode configuration: Query in batches until we find enough matching products
        $is_preview_mode = false;
        $preview_target_count = 0;
        $preview_found_count = 0;
        $preview_batch_size = 50;
        $preview_query_offset = 0;
        $preview_max_queries = 20; // Prevent infinite loops (50 * 20 = 1000 products max)
        $preview_query_count = 0;

        if ( $feed->create_preview ) {
            $is_preview_mode = true;
            $preview_target_count = apply_filters( 'adt_product_feed_preview_products', 5, $feed );
            $preview_batch_size = apply_filters( 'adt_product_feed_preview_batch_size', 50, $feed );
            $preview_max_queries = apply_filters( 'adt_product_feed_preview_max_queries', 20, $feed );
            $posts_per_page = $preview_batch_size;
            $preview_query_offset = $offset;
        } else {
            $posts_per_page = $batch_size;
        }

        // SHIPPING ZONES IS BIG, TAKES TOO MUCH MEMORY
        $shipping_zones = $this->woosea_get_shipping_zones();

        // Check if total_product_orders is needed in the feed (attributes, filters, or rules)
        $is_total_product_orders_mapped = \AdTribes\PFP\Classes\Orders::is_total_product_orders_mapped( $feed );

        // Tax class options.
        $tax_class_options  = function_exists( 'wc_get_product_tax_class_options' ) ? wc_get_product_tax_class_options() : array();

        // Main product query loop - will iterate multiple times in preview mode if needed
        do {
            // Construct WP query
            $wp_query = array(
                'post_type'              => $post_type,
                'posts_per_page'         => $posts_per_page,
                'offset'                 => $is_preview_mode ? $preview_query_offset : $offset,
                'post_status'            => 'publish',
                'orderby'                => 'date',
                'order'                  => 'desc',
                'fields'                 => 'ids',
                'no_found_rows'          => true,
                'cache_results'          => false,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'suppress_filters'       => false,
                'custom_query'           => 'adt_published_products_and_variations', // Custom flag to trigger the filter
                'post_password'          => '',
            );

            /**
             * Filter the WP_Query arguments for getting products.
             *
             * @since 13.3.7
             *
             * @param array        $wp_query The WP_Query arguments.
             * @param Product_Feed $feed     The product feed instance.
             */
            $wp_query = apply_filters( 'adt_product_feed_get_products_query_args', $wp_query, $feed );

            $prods = new WP_Query( $wp_query );

            // Increment preview query counter
            if ( $is_preview_mode ) {
                $preview_query_count++;
            }

        while ( $prods->have_posts() ) :
            $prods->the_post();

            $attr_line   = '';
            $catname     = array();
            $catlink     = array();
            $xml_product = array();

            /**
             * Filter the product ID that is being processed.
             * 
             * @since 13.3.7.1
             * 
             * @param int          $product_id The product ID.
             * @param Product_Feed $feed       The product feed instance.
             * @return int The product ID.
             */
            $product_id = apply_filters( 'adt_product_feed_get_product_id', get_the_ID(), $feed );
            $product    = wc_get_product( $product_id );

            if ( ! is_a( $product, 'WC_Product' ) ) {
                continue;
            }
            
            $parent_id          = wp_get_post_parent_id( $product_id );
            $parent_product     = $parent_id > 0 ? wc_get_product( $parent_id ) : null;
            $product_data['id'] = $product_id;

            // Set country code.
            $country_code  = $feed->country ?? '';

            // Only products that have been sold are allowed to go through
            if ( $feed->utm_total_product_orders_lookback && $feed->utm_total_product_orders_lookback > 0 ) {
                if ( ! in_array( $product_data['id'], $allowed_product_orders ) ) {
                    continue;
                }
            }

            // Only products that are visible in the catalog are allowed to go through.
            $catalog_visibility = $product->get_catalog_visibility();

            /**
             * Filter the catalog visibility.
             * 
             * @since 13.4.5
             * 
             * @param array        $catalog_visibility The catalog visibility.
             * @param Product_Feed $feed             The product feed instance.
             * @return array The catalog visibility.
             */
            if ( in_array( $catalog_visibility, apply_filters( 'adt_product_feed_filter_catalog_visibility', array(), $feed ) ) ) {
                continue;
            }

            // Only products that are visible in the catalog are allowed to go through.
            $catalog_visibility = $product->get_catalog_visibility();

            /**
             * Filter the catalog visibility.
             * 
             * @since 13.4.5
             * 
             * @param array        $catalog_visibility The catalog visibility.
             * @param Product_Feed $feed             The product feed instance.
             * @return array The catalog visibility.
             */
            if ( in_array( $catalog_visibility, apply_filters( 'adt_product_feed_filter_catalog_visibility', array(), $feed ) ) ) {
                continue;
            }

            $product_data['title']                   = Sanitization::sanitize_html_content( $product->get_title(), $feed );
            $product_data['mother_title']            = $product_data['title'];
            $product_data['title_hyphen']            = $product_data['title'];
            $product_data['title_slug']              = $product->get_slug();
            $product_data['sku']                     = $product->get_sku();
            $product_data['sku_id']                  = $product_data['id'];
            $product_data['wc_post_id_product_id']   = 'wc_post_id_' . $product_data['id'];
            $product_data['publication_date']        = date( 'F j, Y, G:i a' );
            $product_data['add_to_cart_link']        = trailingslashit( wc_get_page_permalink( 'shop' ) ) . '?add-to-cart=' . $product_data['id'];
            $product_data['cart_link']               = trailingslashit( wc_get_cart_url() ) . '?add-to-cart=' . $product_data['id'];
            $product_data['visibility']              = $catalog_visibility;
            $product_data['boolean_true']            = 'true';
            $product_data['boolean_false']           = 'false';

            // Site URL 
            $product_data['site_url'] = get_site_url();

            // Site title
            $product_data['site_title'] = get_bloginfo( 'name' );

            // WooCommerce terms and conditions page URL
            $wc_terms_page_id = wc_get_page_id( 'terms' );
            $product_data['terms_condtion_page_url'] = $wc_terms_page_id > 0 ? get_permalink( $wc_terms_page_id ) : '';

            // WP Privacy Policy page URL
            $wp_privacy_policy_page_id = get_option( 'wp_page_for_privacy_policy' );
            $product_data['privacy_policy_page_url'] = $wp_privacy_policy_page_id > 0 ? get_permalink( $wp_privacy_policy_page_id ) : '';

            // WooCommerce shop page URL
            $wc_shop_page_id = wc_get_page_id( 'shop' );
            $product_data['shop_url'] = $wc_shop_page_id > 0 ? get_permalink( $wc_shop_page_id ) : '';
            
            // Get product creation date
            // For variations, use the parent's creation date to maintain consistency with variable product creation date changes
            $creation_date_source = $product;
            if ( $product->get_type() === 'variation' && $parent_id > 0 && is_object( $parent_product ) ) {
                $creation_date_source = $parent_product;
            }

            if ( ! empty( $creation_date_source->get_date_created() ) ) {
                $datetime_created = $creation_date_source->get_date_created();
                $timestamp_created = $datetime_created->getTimestamp();
                $timestamp_now = ( new WC_DateTime() )->getTimestamp();
                $time_delta = $timestamp_now - $timestamp_created;

                $product_data['days_back_created'] = round( $time_delta / 86400 );
                $product_data['product_creation_date'] = $datetime_created;
            }

            // Start product visibility default value.
            $product_data['exclude_from_catalog'] = 'no';
            $product_data['exclude_from_search']  = 'no';
            $product_data['exclude_from_all']     = 'no';
            
            // For product variations, check the parent product's featured status
            if ( $parent_id > 0 && is_object( $parent_product ) ) {
                $product_data['featured'] = $parent_product->is_featured() ? 'yes' : 'no';
            } else {
                $product_data['featured'] = $product->is_featured() ? 'yes' : 'no';
            }

            switch ( $catalog_visibility ) {
                case 'catalog':
                    $product_data['exclude_from_search'] = 'yes';
                    break;
                case 'search':
                    $product_data['exclude_from_catalog'] = 'yes';
                    break;
                case 'hidden':
                    $product_data['exclude_from_catalog'] = 'yes';
                    $product_data['exclude_from_search'] = 'yes';
                    $product_data['exclude_from_all'] = 'yes';
                    break;
                case 'visible':
                default:
                    break;
            }

            // Get product tax details
            $product_data['tax_status'] = $product->get_tax_status();
            $product_data['tax_class']  = $product->get_tax_class();
            $product_data['tax_class_name']  = isset( $tax_class_options[ $product_data['tax_class'] ] ) ? $tax_class_options[ $product_data['tax_class'] ] : '';

            // End product visibility logic
            $product_data['item_group_id'] = $parent_id ?? '';

            if ( ! empty( $product_data['sku'] ) ) {
                $product_data['sku_id'] = $product_data['sku'] . '_' . $product_data['id'];

                if ( $feed_channel['fields'] == 'facebook_drm' ) {
                    if ( $product_data['item_group_id'] > 0 ) {
                        $product_data['sku_item_group_id'] = $product_data['sku'] . '_' . $product_data['item_group_id'];
                    } else {
                        $product_data['sku_item_group_id'] = $product_data['sku'] . '_' . $product_data['id'];
                    }
                }
            }

            $cat_alt    = array();
            $cat_term   = '';
            $cat_order  = '';
            $categories = array();
            if ( $parent_id && is_object( $parent_product ) && is_a( $parent_product, 'WC_Product_Variable' ) && method_exists( $parent_product, 'get_category_ids' ) ) {
                $categories = $parent_product->get_category_ids();
            } elseif ( is_object( $product ) && method_exists( $product, 'get_category_ids' ) ) {
                $categories = $product->get_category_ids();
            }
            $cat_alt = $categories;

            // Get number of sales for this product
            // Variations require direct order item queries as WooCommerce doesn't track variation sales in post meta.
            if ( $is_total_product_orders_mapped ) {
                if ( $product->is_type( 'variation' ) ) {
                    $product_data['total_product_orders'] = \AdTribes\PFP\Classes\Orders::get_variation_total_sales( $product->get_id() );
                } else {
                    $product_data['total_product_orders'] = $product->get_total_sales();
                }
            }

            // Determine real category hierarchy
            $cat_order = array();
            foreach ( $categories as $key => $value ) {
                $product_cat = get_term( $value, 'product_cat' );

                // Not in array so we can add it
                if ( ! in_array( $value, $cat_order ) ) {

                    $parent_cat = $product_cat->parent;
                    // Check if parent is in array
                    if ( in_array( $parent_cat, $cat_order ) ) {
                        // Parent is in array, now determine position
                        $position = array_search( $parent_cat, $cat_order );

                        // Use array splice to add it in the right position in array
                        $new_position = $position + 1;

                        // Insert on new position in array
                        array_splice( $cat_order, $new_position, 0, $value );
                    } else {
                        // Parent is not in array
                        if ( $parent_cat > 0 ) {
                            if ( in_array( $parent_cat, $categories ) ) {
                                $cat_order[] = $parent_cat;
                            }
                            $cat_order[] = $value;
                        } else {
                            // This is the MAIN cat so should be in front
                            array_unshift( $cat_order, $value );
                        }
                    }
                }
            }
            $categories = $cat_order;

            // This is a category fix for Yandex, probably needed for all channels
            // When Yoast is not installed and a product is linked to multiple categories
            // The ancestor categoryId does not need to be in the feed
            $double_categories = array(
                0 => 'Yandex',
                1 => 'Prisjakt.se',
                2 => 'Pricerunner.se',
                3 => 'Pricerunner.dk',
            );

            if ( in_array( $feed_channel['name'], $double_categories, true ) ) {
                $cat_alt = array();
                if ( $product_data['item_group_id'] > 0 ) {
                    $cat_terms = get_the_terms( $product_data['item_group_id'], 'product_cat' );
                } else {
                    $cat_terms = get_the_terms( $product_data['id'], 'product_cat' );
                }

                if ( $cat_terms ) {
                    foreach ( $cat_terms as $cat_term ) {
                        $cat_alt[] = $cat_term->term_id;
                    }
                }
                $categories = $cat_alt;
            }

            $product_data['category_path'] = '';

            // Sort categories so the category with the highest category ID being used for the category path attributes
            asort( $categories );

            foreach ( $categories as $key => $value ) {
                $product_cat = get_term( (int) $value, 'product_cat' );

                if ( $product_cat && ! is_wp_error( $product_cat ) ) {
                    // Check if there are mother categories
                    $category_path = $this->woosea_get_term_parents( $product_cat->term_id, 'product_cat', $link = false, $project_taxonomy = $feed_channel['taxonomy'], $nicename = false, $visited = array() );

                    if ( ! is_object( $category_path ) ) {
                        $category_path_skroutz                 = preg_replace( '/&gt;/', '>', $category_path );
                        $product_data['category_path']         = $category_path;
                        $product_data['category_path_skroutz'] = $category_path_skroutz;
                        $product_data['category_path_skroutz'] = str_replace( 'Home >', '', $product_data['category_path_skroutz'] );
                        $product_data['category_path_skroutz'] = str_replace( '&amp;', '&', $product_data['category_path_skroutz'] );
                    }

                    $parent_categories = get_ancestors( (int) $product_cat->term_id, 'product_cat' );
                    if ( is_array( $parent_categories ) && ! empty( $parent_categories ) ) {
                        foreach ( $parent_categories as $category_id ) {
                            $parent = get_term_by( 'id', (int) $category_id, 'product_cat' );
                            if ( $parent && ! is_wp_error( $parent ) ) {
                                $parent_name = $parent->name;
                            }
                        }
                    }

                    if ( isset( $product_cat->name ) ) {
                        $catname[] = $product_cat->name;
                        $term_link = get_term_link( (int) $value, 'product_cat' );
                        if ( ! is_wp_error( $term_link ) ) {
                            $catlink[] = $term_link;
                        }
                    }
                }
            }

            // Get the Yoast primary category (if exists)
            if ( class_exists( 'WPSEO_Primary_Term' ) ) {

                // Show the post's 'Primary' category, if this Yoast feature is available, & one is set
                $item_id = $product_data['id'];
                if ( $product_data['item_group_id'] > 0 ) {
                    $item_id = $product_data['item_group_id'];
                }
                $wpseo_primary_term = new WPSEO_Primary_Term( 'product_cat', $item_id );
                $prm_term           = $wpseo_primary_term->get_primary_term();
                $prm_cat            = get_term( $prm_term, 'product_cat' );

                if ( ! is_wp_error( $prm_cat ) ) {
                    if ( ! empty( $prm_cat->name ) ) {
                        $product_data['category_path'] = $this->woosea_get_term_parents( $prm_cat->term_id, 'product_cat', $link = false, $project_taxonomy = $feed_channel['taxonomy'], $nicename = false, $visited = array() );
                        $product_data['one_category']  = $prm_cat->name;
                    }
                }

                unset( $prm_cat );
                unset( $prm_term );
                unset( $wpseo_primary_term );
            }

            // Get the RankMath primary category
            if ( Helper::is_plugin_active( 'seo-by-rank-math/rank-math.php' ) ) {
                $item_id = $product_data['id'];
                if ( $product_data['item_group_id'] > 0 ) {
                    $item_id = $product_data['item_group_id'];
                }
                $primary_cat_id = get_post_meta( $item_id, 'rank_math_primary_product_cat', true );
                if ( $primary_cat_id ) {
                    $product_cat = get_term( $primary_cat_id, 'product_cat' );

                    if ( ! empty( $product_cat->name ) ) {
                        $product_data['category_path'] = $this->woosea_get_term_parents( $product_cat->term_id, 'product_cat', $link = false, $project_taxonomy = $feed_channel['taxonomy'], $nicename = false, $visited = array() );
                        $product_data['one_category']  = $product_cat->name;
                    }
                }
                unset( $primary_cat_id );
            }

            $product_data['category_path_short'] = str_replace( 'Home &gt;', '', $product_data['category_path'] );
            $product_data['category_path_short'] = str_replace( '&gt;', '>', $product_data['category_path_short'] );
            $product_data['category_link']       = implode( '||', $catlink );
            $product_data['raw_categories']      = implode( '||', $catname );
            $product_data['categories']          = implode( '||', $catname );
            $product_data['categories_comma_separated'] = $this->get_comma_separated_categories( $product->get_category_ids() );
            
            // Product Description.
            $product_description = $product->get_description();
            $product_short_description = $product->get_short_description();
            $parent_product_description = is_object( $parent_product ) && method_exists( $parent_product, 'get_description' ) ? $parent_product->get_description() : $product_description;
            $parent_product_short_description = is_object( $parent_product ) && method_exists( $parent_product, 'get_short_description' ) ? $parent_product->get_short_description() : $product_short_description;

            $combined_description = $product_description;
            $combined_short_description = $product_short_description;

            if ( 'variation' === $product->get_type() ) {
                $combined_description = '' !== $parent_product_description ? $parent_product_description . ' ' . $product_description : $product_description;
                $combined_short_description = '' !== $parent_product_short_description ? $parent_product_short_description . ' ' . $product_short_description : $product_short_description;
            }

            // Raw descriptions, unfiltered
            $product_data['raw_description']       = Sanitization::sanitize_raw_html_content( $combined_description );
            $product_data['raw_short_description'] = Sanitization::sanitize_raw_html_content( $combined_short_description );
            $product_data['raw_parent_description'] = Sanitization::sanitize_raw_html_content( $parent_product_description );
            $product_data['raw_parent_short_description'] = Sanitization::sanitize_raw_html_content( $parent_product_short_description );
            $product_data['raw_variation_description'] = Sanitization::sanitize_raw_html_content( $product_description );
            $product_data['raw_variation_short_description'] = Sanitization::sanitize_raw_html_content( $product_short_description );

            // Sanitize descriptions
            $product_data['description']              = Sanitization::sanitize_html_content( $combined_description, $feed );
            $product_data['short_description']        = Sanitization::sanitize_html_content( $combined_short_description, $feed );
            $product_data['mother_description']       = Sanitization::sanitize_html_content( $parent_product_description, $feed );
            $product_data['mother_short_description'] = Sanitization::sanitize_html_content( $parent_product_short_description, $feed );
            $product_data['variation_description']    = Sanitization::sanitize_html_content( $product_description, $feed );
            $product_data['variation_short_description'] = Sanitization::sanitize_html_content( $product_short_description, $feed );

            // Truncate description on 5000 characters for Google Shopping
            if ( $feed_channel['fields'] == 'google_shopping' ) {
                $product_data['description']       = mb_substr( $product_data['description'], 0, 5000 );
                $product_data['short_description'] = mb_substr( $product_data['short_description'], 0, 5000 );
                $product_data['mother_description'] = mb_substr( $product_data['mother_description'], 0, 5000 );
                $product_data['mother_short_description'] = mb_substr( $product_data['mother_short_description'], 0, 5000 );
                $product_data['variation_description'] = mb_substr( $product_data['variation_description'], 0, 5000 );
                $product_data['variation_short_description'] = mb_substr( $product_data['variation_short_description'], 0, 5000 );

                $product_data['raw_description']       = mb_substr( $product_data['raw_description'], 0, 5000 );
                $product_data['raw_short_description'] = mb_substr( $product_data['raw_short_description'], 0, 5000 );
                $product_data['raw_parent_description'] = mb_substr( $product_data['raw_parent_description'], 0, 5000 );
                $product_data['raw_parent_short_description'] = mb_substr( $product_data['raw_parent_short_description'], 0, 5000 );
                $product_data['raw_variation_description'] = mb_substr( $product_data['raw_variation_description'], 0, 5000 );
                $product_data['raw_variation_short_description'] = mb_substr( $product_data['raw_variation_short_description'], 0, 5000 );
            }

            /**
             * Check of we need to add Google Analytics UTM parameters
             */
            if ( $feed->utm_enabled ) {
                $utm_part = $this->woosea_append_utm_code( $feed, get_the_ID(), $parent_id, get_permalink( $product_data['id'] ) );
            } else {
                $utm_part = '';
            }

            $product_data['link']             = get_permalink( $product_data['id'] ) . "$utm_part";
            $product_data['link_no_tracking'] = get_permalink( $product_data['id'] );
            $variable_link                    = htmlspecialchars( get_permalink( $product_data['id'] ) );
            $vlink_piece                      = explode( '?', $variable_link );
            $qutm_part                        = ltrim( $utm_part, '&amp;' );
            $qutm_part                        = ltrim( $qutm_part, 'amp;' );
            $qutm_part                        = ltrim( $qutm_part, '?' );
            if ( $qutm_part ) {
                $product_data['variable_link']    = $vlink_piece[0] . '?' . $qutm_part;
                $product_data['link_no_tracking'] = $vlink_piece[0];
            } else {
                $product_data['variable_link']    = $vlink_piece[0];
                $product_data['link_no_tracking'] = $vlink_piece[0];
            }

             // For product variations, check the parent product's purchase note
             if ( $parent_id > 0 && is_object( $parent_product ) ) {
                $product_data['purchase_note'] = $parent_product->get_purchase_note();
            } else {
                $product_data['purchase_note'] = $product->get_purchase_note();
            }

            // Product condition is default to 'new' if not set.
            if ( empty( $product_data['condition'] ) || $product_data['condition'] == 'Array' ) {
                $product_data['condition'] = 'new';
            }

            // get_stock only works as of WC 5 and higher?
            $product_data['availability'] = $this->get_stock( $product_id );

            /**
             * When 'Enable stock management at product level is active
             * availability will always return out of stock, even when the stock quantity > 0
             * Therefor, we need to check the stock_status and overwrite te availability value
             */
            if ( ! is_bool( $product ) ) {
                $stock_status = $product->get_stock_status();
            } else {
                $stock_status = 'instock';
            }
            $product_data['stock_status'] = $stock_status;

            if ( 'outofstock' === $stock_status ) {
                $product_data['availability'] = 'out of stock';
                if ( ( 'google_shopping' === $feed_channel['taxonomy'] ) && ( 'google_shopping' ===  $feed_channel['fields'] ) ) {
                    $product_data['availability'] = 'out_of_stock';
                    if ( 'Twitter' === $feed_channel['name'] ) {
                        $product_data['availability'] = 'out of stock';
                    }
                } elseif ( ( 'google_shopping' === $feed_channel['taxonomy'] ) && ( 'google_local' === $feed_channel['fields'] ) ) {
                    $product_data['availability'] = 'out_of_stock';
                }
                if ( preg_match( '/fruugo/i', $feed_channel['fields'] ) ) {
                    $product_data['availability'] = 'OUTOFSTOCK';
                }
            } elseif ( $stock_status == 'onbackorder' ) {
                $product_data['availability'] = 'on backorder';
                if ( ( 'google_shopping' === $feed_channel['taxonomy'] ) && ( 'google_shopping' ===  $feed_channel['fields'] ) ) {
                    $product_data['availability'] = 'backorder';
                    if ( 'Twitter' === $feed_channel['name'] ) {
                        $product_data['availability'] = 'available for order';
                    }
                } elseif ( ( 'google_shopping' === $feed_channel['taxonomy'] ) && ( 'google_local' === $feed_channel['fields'] ) ) {
                    $product_data['availability'] = 'on_display_to_order';
                }
                if ( preg_match( '/fruugo/i', $feed_channel['fields'] ) ) {
                    $product_data['availability'] = 'OUTOFSTOCK';
                }
            } else {
                $product_data['availability'] = 'in stock';
                if ( ( 'google_shopping' === $feed_channel['taxonomy'] ) && ( 'google_shopping' ===  $feed_channel['fields'] ) ) {
                    $product_data['availability'] = 'in_stock';
                    if ( 'Twitter' === $feed_channel['name'] ) {
                        $product_data['availability'] = 'in stock';
                    }
                } elseif ( ( 'google_shopping' === $feed_channel['taxonomy'] ) && ( 'google_local' === $feed_channel['fields'] ) ) {
                    $product_data['availability'] = 'in_stock';
                }
                if ( preg_match( '/fruugo/i', $feed_channel['fields'] ) ) {
                    $product_data['availability'] = 'INSTOCK';
                }
            }


            /**
             * Filter the availability format.
             *
             * @since 13.4.9
             *
             * @param string $availability The availability value.
             * @param object $product The product object.
             * @param array $feed_channel The feed channel array.
             * @param object $feed The feed object.
             * @return string The availability value.
             */
            $product_data['availability'] = apply_filters( 'adt_product_data_availability_format', $product_data['availability'], $product, $feed_channel, $feed );

            // Create future availability dates
            if ( $product->is_on_backorder() ) {
                $now = new WC_DateTime( 'now', new DateTimeZone( 'UTC' ) );
                // Set local timezone or offset.
                if ( get_option( 'timezone_string' ) ) {
                    $now->setTimezone( new DateTimeZone( wc_timezone_string() ) );
                } else {
                    $now->set_utc_offset( wc_timezone_offset() );
                }

                $now->setTime(0, 0);

                $plus_week_to = 8;
                $date         = new WC_DateTime( $now );
                for ($i = 1; $i <= $plus_week_to; $i++) {
                    $date_plus_week = clone $date;
                    $date_plus_week->modify("+$i week");
                    $product_data["availability_date_plus{$i}week"] = $date_plus_week->__toString();
                }
            }

            $product_data['author']   = get_the_author();
            $product_data['quantity'] = $product->get_stock_quantity();
            $download = $product->is_downloadable();

            if ( $download == 1 ) {
                $product_data['downloadable'] = 'yes';
            } else {
                $product_data['downloadable'] = 'no';
            }
            unset( $download );

            $virtual = $product->is_virtual();
            if ( $virtual == 1 ) {
                $product_data['virtual'] = 'yes';
            } else {
                $product_data['virtual'] = 'no';
            }
            unset( $virtual );

            $product_data['menu_order'] = get_post_field( 'menu_order', $product_data['id'] );
            $product_data['currency']   = apply_filters( 'adt_product_data_currency', get_woocommerce_currency() );

            if ( $product->is_on_sale() ) {
                $sales_price_date_from                     = Formatting::format_date( $product->get_date_on_sale_from(), $feed );
                $sales_price_date_to                       = Formatting::format_date( $product->get_date_on_sale_to(), $feed );
                $product_data['sale_price_effective_date'] = $sales_price_date_from . '/' . $sales_price_date_to;
            } else {
                $product_data['sale_price_effective_date'] = '';
            }

            $product_data['sale_price_start_date'] = $product->get_date_on_sale_from() ? Formatting::format_date( $product->get_date_on_sale_from(), $feed ) : '';
            $product_data['sale_price_end_date']   = $product->get_date_on_sale_to() ? Formatting::format_date( $product->get_date_on_sale_to(), $feed ) : '';

            $product_image         = wp_get_attachment_url( $product->get_image_id() );
            $product_data['image'] = $product_image ? $product_image : '';
            $non_local_image       = wp_get_attachment_image_src( get_post_thumbnail_id( $product_data['id'] ), 'single-post-thumbnail' );
            if ( is_array( $non_local_image ) ) {
                $product_data['non_local_image'] = $non_local_image[0];
            }
            unset( $non_local_image );

            $product_data['image_all']          = $product_data['image'];
            $product_data['all_images']         = $product_data['image'];
            $product_data['all_gallery_images'] = '';
            $product_data['product_type']       = $product->get_type();

            // Get the number of active variations that are on stock for variable products
            if ( ( $product_data['item_group_id'] > 0 ) && ( $product_data['product_type'] == 'variation' ) ) {
                $parent_product = wc_get_product( $product_data['item_group_id'] );

                if ( is_object( $parent_product ) ) {
                    $current_products              = $parent_product->get_children();
                    $product_data['nr_variations'] = count( $current_products );
                    $vcnt                          = 0;

                    foreach ( $current_products as $ckey => $cvalue ) {
                        $stock_value = get_post_meta( $cvalue, '_stock_status', true );
                        if ( $stock_value == 'instock' ) {
                            ++$vcnt;
                        }
                    }
                    // unset($current_products);
                    $product_data['nr_variations_stock'] = $vcnt;
                } else {
                    $product_data['nr_variations']       = 9999;
                    $product_data['nr_variations_stock'] = 9999;
                }
                // unset($parent_product);
            } else {
                $product_data['nr_variations']       = 9999;
                $product_data['nr_variations_stock'] = 9999;
            }

            // For variable products I need to get the product gallery images of the simple mother product
            if ( $product_data['item_group_id'] > 0 ) {
                $parent_product = wc_get_product( $product_data['item_group_id'] );

                if ( is_object( $parent_product ) ) {
                    $gallery_ids               = $parent_product->get_gallery_image_ids();
                    $product_data['image_all'] = wp_get_attachment_url( $parent_product->get_image_id() );
                    $gal_id                    = 1;
                    foreach ( $gallery_ids as $gallery_key => $gallery_value ) {
                        $product_data[ 'image_' . $gal_id ]  = wp_get_attachment_url( $gallery_value );
                        $product_data['all_images']         .= ',' . wp_get_attachment_url( $gallery_value );
                        $product_data['all_gallery_images'] .= ',' . wp_get_attachment_url( $gallery_value );
                        ++$gal_id;
                    }
                }
                // unset($parent_product);
            } else {
                $gallery_ids = $product->get_gallery_image_ids();
                $gal_id      = 1;
                foreach ( $gallery_ids as $gallery_key => $gallery_value ) {
                    $product_data[ 'image_' . $gal_id ]  = wp_get_attachment_url( $gallery_value );
                    $product_data['all_images']         .= ',' . wp_get_attachment_url( $gallery_value );
                    $product_data['all_gallery_images'] .= ',' . wp_get_attachment_url( $gallery_value );
                    ++$gal_id;
                }
                // unset($gallery_ids);
            }

            $product_data['all_images']         = ltrim( $product_data['all_images'], ',' );
            $product_data['all_images_kogan']   = preg_replace( '/,/', '|', $product_data['all_images'] );
            $product_data['all_gallery_images'] = ltrim( $product_data['all_gallery_images'], ',' );

            $product_data['content_type'] = 'product';
            if ( $product_data['product_type'] == 'variation' ) {
                $product_data['content_type'] = 'product_group';
            }

            $rating_count = $product->get_rating_count();
            if ( $rating_count > 1 ) {
                $product_data['rating_total']   = $rating_count;
                $product_data['rating_average'] = $product->get_average_rating();
            }

            // When a product has no reviews than remove the 0 rating
            if ( isset( $product_data['rating_average'] ) && $product_data['rating_average'] == 0 ) {
                unset( $product_data['rating_average'] );
            }

            $product_data['shipping'] = array();
            $shipping_class_id        = $product->get_shipping_class_id();

            $class_cost_id = 'class_cost_' . $shipping_class_id;
            if ( $class_cost_id == 'class_cost_0' ) {
                $class_cost_id = 'no_class_cost';
            }

            $product_data['shipping_label'] = $product->get_shipping_class();
            $term                           = get_term_by( 'slug', $product->get_shipping_class(), 'product_shipping_class' );
            if ( is_object( $term ) ) {
                $product_data['shipping_label_name'] = $term->name;
            }

            $base_tax_rates = \WC_Tax::get_base_tax_rates( $product->get_tax_class() );
            $tax_rates = Product_Feed_Helper::find_tax_rates( 
                array(
                    'country'   => $feed->country ?? '',
                    'state'     => '',
                    'postcode'  => '',
                    'city'      => '',
                    'tax_class' => $product->get_tax_class(),
                ),
                $feed,
                $product 
            );

            // Get product prices
            $product_data['price']                = Product_Feed_Helper::get_price_including_tax( $product->get_price(), $tax_rates, $feed, $product );
            $product_data['regular_price']        = Product_Feed_Helper::get_price_including_tax( $product->get_regular_price(), $tax_rates, $feed, $product );
            $product_data['system_price']         = Product_Feed_Helper::get_price_including_tax( $product->get_price(), $base_tax_rates, $feed, $product );
            $product_data['system_regular_price'] = Product_Feed_Helper::get_price_including_tax( $product->get_regular_price(), $base_tax_rates, $feed, $product );

            // Determine the gross prices of products.
            // The 'price_forced' is the price including tax.
            $product_data['price_forced']                = Product_Feed_Helper::get_price_including_tax( $product->get_price(), $tax_rates, $feed, $product );
            $product_data['regular_price_forced']        = Product_Feed_Helper::get_price_including_tax( $product->get_regular_price(), $tax_rates, $feed, $product );
            $product_data['system_price_forced']         = Product_Feed_Helper::get_price_including_tax( $product->get_price(), $base_tax_rates, $feed, $product );
            $product_data['system_regular_price_forced'] = Product_Feed_Helper::get_price_including_tax( $product->get_regular_price(), $base_tax_rates, $feed, $product );

            // The 'net_price' is the price excluding tax.
            $product_data['net_price']                = Product_Feed_Helper::get_price_excluding_tax( $product->get_price(), $tax_rates, $feed, $product );
            $product_data['net_regular_price']        = Product_Feed_Helper::get_price_excluding_tax( $product->get_regular_price(), $tax_rates, $feed, $product );
            $product_data['system_net_price']         = Product_Feed_Helper::get_price_excluding_tax( $product->get_price(), $base_tax_rates, $feed, $product );
            $product_data['system_net_regular_price'] = Product_Feed_Helper::get_price_excluding_tax( $product->get_regular_price(), $base_tax_rates, $feed, $product );

            if ( $product->is_on_sale() ) {
                $product_data['sale_price']               = Product_Feed_Helper::get_price_including_tax( $product->get_sale_price(), $tax_rates, $feed, $product );
                $product_data['sale_price_forced']        = Product_Feed_Helper::get_price_including_tax( $product->get_sale_price(), $tax_rates, $feed, $product );
                $product_data['net_sale_price']           = Product_Feed_Helper::get_price_excluding_tax( $product->get_sale_price(), $tax_rates, $feed, $product );
                $product_data['system_sale_price']        = Product_Feed_Helper::get_price_including_tax( $product->get_sale_price(), $base_tax_rates, $feed, $product );
                $product_data['system_sale_price_forced'] = Product_Feed_Helper::get_price_excluding_tax( $product->get_sale_price(), $base_tax_rates, $feed, $product );
                $product_data['system_net_sale_price']    = Product_Feed_Helper::get_price_including_tax( $product->get_sale_price(), $base_tax_rates, $feed, $product );
            }

            // WooCommerce Cost of Goods Sold
            if ( wc_get_container()->get(Automattic\WooCommerce\Internal\Features\FeaturesController::class)->feature_is_enabled('cost_of_goods_sold') ) {
                $cogs_effective_value = $product->get_cogs_effective_value();
                $cogs_value = $product->get_cogs_value();
                $cogs_total_value = $product->get_cogs_total_value();
                
                // For cost_of_goods_sold, use effective value, but for variations that inherit, use total value
                if ( $product->is_type( 'variation' ) && is_null( $cogs_value ) && $cogs_total_value > 0 ) {
                    $product_data['cost_of_goods_sold'] = $cogs_total_value;
                } else {
                    $product_data['cost_of_goods_sold'] = $cogs_effective_value > 0 ? $cogs_effective_value : '';
                }
                
                // For inherited values, use the total value instead of null
                $product_data['cost_of_goods_value'] = ! is_null( $cogs_value ) && $cogs_value > 0 ? $cogs_value : ($cogs_total_value > 0 ? $cogs_total_value : '');
                
                $product_data['cost_of_goods_total_value'] = $cogs_total_value > 0 ? $cogs_total_value : '';
            }

            $args = array(
                'ex_tax_label'       => false,
                'currency'           => '',
                'decimal_separator'  => wc_get_price_decimal_separator(),
                'thousand_separator' => wc_get_price_thousand_separator(),
                'decimals'           => wc_get_price_decimals(),
                'price_format'       => get_woocommerce_price_format(),
            );

            if ( isset( $product_data['price'] ) ) {
                $dec_price = wc_price( $product_data['price'], $args );
                preg_match( '/<bdi>(.*?)&nbsp;/', $dec_price, $matches );
                if ( isset( $matches[1] ) ) {
                    $product_data['separator_price'] = $matches[1];
                }
                // unset($dec_price);
            }

            if ( isset( $product_data['regular_price'] ) ) {
                $dec_regular_price = wc_price( $product_data['regular_price'], $args );
                preg_match( '/<bdi>(.*?)&nbsp;/', $dec_regular_price, $matches_reg );
                if ( isset( $matches_reg[1] ) ) {
                    $product_data['separator_regular_price'] = $matches_reg[1];
                }
            }

            if ( isset( $product_data['sale_price'] ) ) {
                $dec_sale_price = wc_price( $product_data['sale_price'], $args );
                preg_match( '/<bdi>(.*?)&nbsp;/', $dec_sale_price, $matches_sale );
                if ( isset( $matches_sale[1] ) ) {
                    $product_data['separator_sale_price'] = $matches_sale[1];
                }
            }

            $all_standard_taxes = WC_Tax::get_rates_for_tax_class( '' );
            $nr_standard_rates  = count( $all_standard_taxes );
            if ( ! empty( $all_standard_taxes ) && ( $nr_standard_rates > 1 ) ) {
                foreach ( $all_standard_taxes as $rate ) {
                    $rate_arr = get_object_vars( $rate );
                    if ( $rate_arr['tax_rate_country'] == $country_code ) {
                        $tax_rates[1]['rate'] = $rate_arr['tax_rate'];
                    }
                    unset( $rate_arr );
                }
            } elseif ( ! empty( $tax_rates ) ) {
                foreach ( $tax_rates as $tk => $tv ) {
                    if ( $tv['rate'] > 0 ) {
                        $tax_rates[1]['rate'] = $tv['rate'];
                    } else {
                        $tax_rates[1]['rate'] = 0;
                    }
                }
            } else {
                $tax_rates[1]['rate'] = 0;
            }

            if ( empty( $tax_rates[1]['rate'] ) ) {
                if ( ! empty( $all_standard_taxes ) && ( $nr_standard_rates > 1 ) ) {
                    foreach ( $all_standard_taxes as $rate ) {
                        $rate_arr = get_object_vars( $rate );
                        if ( $rate_arr['tax_rate_country'] == '' ) {
                            $tax_rates[1]['rate'] = $rate_arr['tax_rate'];
                        }
                        unset( $rate_arr );
                    }
                }
            }
            // unset($all_standard_taxes);

            $tax_rates_first = reset( $tax_rates );
            $fullrate        = ! empty( $tax_rates_first ) ? 100 + $tax_rates_first['rate'] : 100;

            if ( array_key_exists( 1, $tax_rates ) ) {
                $product_data['vat'] = $tax_rates[1]['rate'];
            }

            // Override price when bundled or composite product
            if ( ( $product->get_type() == 'bundle' ) || ( $product->get_type() == 'composite' ) ) {
                $meta = get_post_meta( $product_data['id'] );

                if ( $product->get_type() == 'bundle' ) {
                    if ( Helper::is_plugin_active( 'woocommerce-product-bundles/woocommerce-product-bundles.php' ) ) {
                        if ( ! empty( $product->get_bundle_price() ) ) {
                            $product_data['price']                = $product->get_bundle_price_including_tax();
                            $product_data['price_forced']         = $product->get_bundle_price_including_tax();
                            $product_data['regular_price']        = $product->get_bundle_regular_price();
                            $product_data['regular_price_forced'] = $product->get_bundle_regular_price_including_tax();

                            if ( $product_data['price'] != $product_data['regular_price'] ) {
                                $product_data['sale_price']        = $product->get_bundle_price();
                                $product_data['sale_price_forced'] = $product->get_bundle_price_including_tax();
                            }

                            // Unset sale price when it is 0.00
                            if ( isset( $product_data['sale_price'] ) && $product_data['sale_price'] == '0.00' ) {
                                unset( $product_data['sale_price'] );
                            }
                        }
                    }
                } else {
                    // Composite product
                    if ( Helper::is_plugin_active( 'woocommerce-composite-products/woocommerce-composite-products.php' ) ) {
                        if ( ! empty( $product->get_composite_price() ) ) {
                            $product_data['price']                = $product->get_composite_price_including_tax();
                            $product_data['price_forced']         = $product->get_composite_price_including_tax();
                            $product_data['regular_price']        = $product->get_composite_regular_price();
                            $product_data['regular_price_forced'] = $product->get_composite_regular_price_including_tax();

                            if ( $product_data['price'] != $product_data['regular_price'] ) {
                                $product_data['sale_price']        = $product->get_composite_price();
                                $product_data['sale_price_forced'] = $product->get_composite_price_including_tax();
                            }

                            // Unset sale price when it is 0.00
                            if ( isset( $product_data['sale_price'] ) && $product_data['sale_price'] == '0.00' ) {
                                unset( $product_data['sale_price'] );
                            }
                        }
                    }
                }
            }

            // Is the Discount Rules for WooCommerce by FlyCart plugin active, check for sale prices
            if ( Helper::is_plugin_active( 'woo-discount-rules/woo-discount-rules.php' ) ) {
                $discount = apply_filters( 'advanced_woo_discount_rules_get_product_discount_price_from_custom_price', false, $product, 1, $product_data['sale_price'] ?? 0, 'discounted_price', true, true );
                if ( $discount !== false ) {
                    // round discounted price on proper decimals
                    $decimals = wc_get_price_decimals();
                    if ( $decimals < 1 ) {
                        $discount                      = round( $discount, 0 );
                        $product_data['sale_price']    = round( $discount, 0 );
                        $product_data['price']         = $discount;
                        $product_data['regular_price'] = round( $product_data['regular_price'], 0 );
                    } else {
                        $discount                   = round( $discount, 2 );
                        $product_data['sale_price'] = @number_format( $discount, 2 );
                        $product_data['price']      = $discount;
                    }

                    $price_incl_tax = get_option( 'woocommerce_prices_include_tax' );
                    if ( $price_incl_tax == 'yes' ) {
                        $product_data['price_forced']              = $product_data['price'] * ( $fullrate / 100 );
                        $product_data['price_forced_rounded']      = round( $product_data['price_forced'], 0 );
                        $product_data['net_price']                 = $product_data['price'] / ( $fullrate / 100 );
                        $product_data['net_price_rounded']         = round( $product_data['net_price'] ); // New Nov. 1st 2023
                        $product_data['net_regular_price']         = $product_data['regular_price'] / ( $fullrate / 100 );
                        $product_data['net_regular_price_rounded'] = round( $product_data['net_regular_price'], 0 ); // New Nov. 1st 2023
                        $product_data['net_sale_price']            = ( $discount / $fullrate ) * 100; // New Nov. 1st 2023
                        $product_data['net_sale_price_rounded']    = round( $product_data['net_sale_price'], 0 ); // New Nov. 1st 2023
                        $product_data['sale_price_forced']         = $discount * ( $fullrate / 100 );
                        $product_data['sale_price_forced_rounded'] = round( $product_data['sale_price_forced'], 0 );
                    } else {
                        $product_data['net_sale_price']            = $discount;
                        $product_data['sale_price_forced']         = round( $discount * ( $fullrate / 100 ), 2 );
                        $product_data['sale_price_forced_rounded'] = round( $product_data['sale_price_forced'], 0 );
                    }

                    $thousand_separator = wc_get_price_thousand_separator();
                    if ( $thousand_separator != ',' ) {
                        $replaceWith                   = '';
                        $product_data['price']         = preg_replace( '/,/', $replaceWith, $product_data['price'], 1 );
                        $product_data['regular_price'] = preg_replace( '/,/', $replaceWith, $product_data['regular_price'], 1 );
                        if ( isset( $product_data['sale_price'] ) && $product_data['sale_price'] > 0 ) {
                            $product_data['sale_price'] = preg_replace( '/,/', $replaceWith, $product_data['sale_price'], 1 );
                        }
                    }
                }
                // unset($discount);
            }

            // Is the Mix and Match plugin active
            if ( Helper::is_plugin_active( 'woocommerce-mix-and-match-products/woocommerce-mix-and-match-products.php' ) ) {
                if ( $product->is_type( 'mix-and-match' ) ) {
                    if ( $product_data['price'] == '0.00' ) {
                        $product_data['price']         = '';
                        $product_data['regular_price'] = '';
                    }

                    // Get minimum prices
                    $product_data['mm_min_price']         = wc_format_localized_price( $product->get_mnm_price() );
                    $product_data['mm_min_regular_price'] = wc_format_localized_price( $product->get_mnm_regular_price() );

                    // Get maximum prices
                    $product_data['mm_max_price']         = wc_format_localized_price( $product->get_mnm_price( 'max' ) );
                    $product_data['mm_max_regular_price'] = wc_format_localized_price( $product->get_mnm_regular_price( 'max' ) );
                }
            }

            // Calculate discount percentage
            if ( isset( $product_data['rounded_sale_price'] ) ) {
                if ( $product_data['rounded_regular_price'] > 0 ) {
                    $disc                                = round( ( $product_data['rounded_sale_price'] * 100 ) / $product_data['rounded_regular_price'], 0 );
                    $product_data['discount_percentage'] = 100 - $disc;
                    // $product_data['discount_percentage'] = round(100-(($product_data['sale_price']/$product_data['regular_price'])*100),2);
                }
            }

            // Rounded prices.
            $decimal_separator   = wc_get_price_decimal_separator();
            $number_of_decimals  = apply_filters( 'adt_product_feed_data_rounded_price_number_of_decimals', 2, $feed );
            $rounded_precisions  = apply_filters( 'adt_product_feed_data_rounded_price_precisions', 0, $feed );
            $rounded_mode        = apply_filters( 'adt_product_feed_data_rounded_price_mode', PHP_ROUND_HALF_UP, $feed );
            $rounded_prices      = array(
                'price'                => 'rounded_price',
                'regular_price'        => 'rounded_regular_price',
                'sale_price'           => 'rounded_sale_price',
                'price_forced'         => 'price_forced_rounded',
                'regular_price_forced' => 'regular_price_forced_rounded',
                'sale_price_forced'    => 'sale_price_forced_rounded',
                'net_price'            => 'net_price_rounded',
                'net_regular_price'    => 'net_regular_price_rounded',
                'net_sale_price'       => 'net_sale_price_rounded',
            );

            foreach ( $rounded_prices as $price_key => $rounded_key ) {
                if ( array_key_exists( $price_key, $product_data ) && is_numeric( $product_data[ $price_key ] ) ) {
                    $product_data[ $rounded_key ] = number_format( round( $product_data[ $price_key ], $rounded_precisions, $rounded_mode ), $number_of_decimals, $decimal_separator, '' );
                }
            }

            // Check if shipping data is required based on feed attributes or channel type
            $shipping_required = ! empty( $feed_attributes ) && (
                // Check for g:shipping attribute (Google Shopping format)
                ! empty( array_filter(
                    $feed_attributes,
                    static function ( $attr ) {
                        return is_array( $attr ) && ( $attr['attribute'] ?? '' ) === 'g:shipping';
                    }
                ) ) && $product_data['price'] > 0 ||

                // Check for other shipping-related attributes
                ! empty( array_filter(
                    $feed_attributes,
                    static function ( $attr ) {
                        return is_array( $attr ) && in_array( $attr['attribute'] ?? '', [ 'shipping', 'lowest_shipping_costs', 'shipping_price' ], true );
                    }
                ) ) ||

                // Check for specific channel types that require shipping
                in_array( $feed_channel['fields'], [ 'trovaprezzi', 'idealo', 'customfeed' ], true )
            );

            // Fetch shipping data only once if required
            if ( $shipping_required ) {
                $shipping_data_instance = Shipping_Data::instance();
                $product_data['shipping'] = $shipping_data_instance->get_shipping_data( $product, $feed );
                $shipping_str = $product_data['shipping']; // Set for backward compatibility
            }

            // Initialize shipping price if shipping data exists
            if ( ! empty( $shipping_str ) ) {
                $product_data['shipping_price'] = 0;
            }
            $lowest_shipping_price = array();
            $shipping_arr          = $product_data['shipping'];

            if ( is_array( $shipping_arr ) ) {
                foreach ( $shipping_arr as $akey => $arr ) {
                    // $product_data['shipping_price'] = $arr['price'];
                    $pieces_ship = explode( ' ', $arr['price'] );
                    if ( isset( $pieces_ship['1'] ) ) {
                        $product_data['shipping_price'] = $pieces_ship['1'];
                        $lowest_shipping_price[]        = $pieces_ship['1'];
                    }
                }

                // Check if we need to add a region
                foreach ( $shipping_arr as $akey => $arr ) {
                    if ( isset( $arr['country'] ) ) {
                        if ( preg_match( '/:/i', $arr['country'] ) ) {
                            $region_split                    = explode( ':', $arr['country'] );
                            $sgipping_arr[ $akey ]['region'] = $region_split[1];
                        }
                    }
                }
            }

            // Get the lowest shipping costs
            if ( ! empty( $lowest_shipping_price ) ) {
                $decimal_separator = wc_get_price_decimal_separator();
                if ( $decimal_separator == ',' ) {
                    $numeric_lowest_shipping_price = array();
                    foreach ( $lowest_shipping_price as &$value ) {
                        $number = str_replace( ',', '.', $value );
                        if ( is_numeric( $number ) ) {
                            $value                           = number_format( $number, 2, '.', '' );
                            $numeric_lowest_shipping_price[] = $value;
                        }
                    }
                    $lowest_shipping_price = $numeric_lowest_shipping_price;
                    // unset($value);
                }

                $nr_in = count( $lowest_shipping_price );
                if ( $nr_in > 0 ) {
                    $product_data['lowest_shipping_costs'] = min( $lowest_shipping_price );

                    if ( $decimal_separator == ',' ) {
                        $product_data['lowest_shipping_costs'] = str_replace( '.', ',', $product_data['lowest_shipping_costs'] );
                    }
                }
            }

            // Google Dynamic Remarketing feeds require the English price notation
            if ( $feed_channel['name'] == 'Google Remarketing - DRM' ) {
                $thousand_separator = wc_get_price_thousand_separator();

                if ( $thousand_separator != ',' ) {
                    $product_data['price']         = floatval( str_replace( ',', '.', str_replace( '.', '', $product_data['price'] ) ) );
                    $product_data['regular_price'] = floatval( str_replace( ',', '.', str_replace( '.', '', $product_data['regular_price'] ) ) );
                    if ( isset( $product_data['sale_price'] ) && $product_data['sale_price'] > 0 ) {
                        $product_data['sale_price'] = floatval( str_replace( ',', '.', str_replace( '.', '', $product_data['sale_price'] ) ) );
                    }
                    if ( isset( $product_data['regular_price_forced'] ) ) {
                        $product_data['regular_price_forced'] = floatval( str_replace( ',', '.', str_replace( '.', '', $product_data['regular_price_forced'] ) ) );
                    }
                    if ( $product->get_sale_price() ) {
                        $product_data['sale_price_forced'] = floatval( str_replace( ',', '.', str_replace( '.', '', $product_data['sale_price_forced'] ) ) );
                    }
                    if ( $product_data['net_price'] > 0 ) {
                        $product_data['net_price'] = floatval( str_replace( ',', '.', str_replace( '.', '', $product_data['net_price'] ) ) );
                    }
                    $product_data['net_regular_price'] = @floatval( str_replace( ',', '.', str_replace( '.', '', $product_data['net_regular_price'] ) ) );
                    $product_data['net_sale_price']    = @floatval( str_replace( ',', '.', str_replace( '.', '', $product_data['net_sale_price'] ) ) );

                    $product_data['vivino_price']             = $product_data['price'];
                    $product_data['vivino_sale_price']        = $product_data['sale_price'];
                    $product_data['vivino_regular_price']     = $product_data['regular_price'];
                    $product_data['vivino_net_price']         = $product_data['net_price'];
                    $product_data['vivino_net_sale_price']    = $product_data['net_sale_price'];
                    $product_data['vivino_net_regular_price'] = $product_data['net_regular_price'];
                }
            }

            // Vivino prices
            $product_data['vivino_price']         = floatval( str_replace( ',', '.', str_replace( ',', '.', $product_data['price'] ) ) );
            $product_data['vivino_regular_price'] = floatval( str_replace( ',', '.', str_replace( ',', '.', $product_data['regular_price'] ) ) );
            if ( isset( $product_data['sale_price'] ) && $product_data['sale_price'] > 0 ) {
                $product_data['vivino_sale_price'] = floatval( str_replace( ',', '.', str_replace( ',', '.', $product_data['sale_price'] ) ) );
                if ( isset( $product_data['net_sale_price'] ) ) {
                    $product_data['vivino_net_sale_price'] = floatval( str_replace( ',', '.', str_replace( ',', '.', $product_data['net_sale_price'] ) ) );
                }
            }
            $product_data['vivino_net_price'] = floatval( str_replace( ',', '.', str_replace( ',', '.', $product_data['net_price'] ) ) );
            if ( isset( $product_data['net_regular_price'] ) ) {
                $product_data['vivino_net_regular_price'] = floatval( str_replace( ',', '.', str_replace( ',', '.', $product_data['net_regular_price'] ) ) );
            }

            $product_data['installment'] = $this->woosea_get_installment( $feed, $product_data['id'] );
            $product_data['weight']      = ( $product->get_weight() ) ? $product->get_weight() : '';
            $product_data['height']      = ( $product->get_height() ) ? $product->get_height() : '';
            $product_data['length']      = ( $product->get_length() ) ? $product->get_length() : '';
            $product_data['width']       = ( $product->get_width() ) ? $product->get_width() : '';

            // Featured Image
            if ( has_post_thumbnail( $product_data['id'] ) ) {
                // Check if user would like to use the mother main image for all variation products
                $use_parent_variable_product_image = get_option( 'adt_use_parent_variable_product_image' );
                $product_image_id = 'yes' == $use_parent_variable_product_image && $product_data['item_group_id'] > 0 ? $product_data['item_group_id'] : $product_data['id'];
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_image_id ), 'single-post-thumbnail' );
                if ( ! empty( $image[0] ) ) {
                    $product_data['feature_image'] = $this->get_image_url( $image[0] );
                    // unset($image);
                }
            } else {
                $product_data['feature_image'] = $this->get_image_url( $product_data['image'] );
            }

            foreach ( $diff_taxonomies as $taxo ) {
                $term_value              = get_the_terms( $product_data['id'], $taxo );
                $product_data[ "$taxo" ] = '';

                if ( is_array( $term_value ) ) {
                    // Do not add variation values to the feed when they are out of stock
                    if ( $feed_channel['fields'] == 'skroutz' ) {
                        if ( ( $product->is_type( 'variable' ) ) && ( $product_data['item_group_id'] == 0 ) ) {
                            $product_skroutz   = wc_get_product( $product_data['id'] );
                            $variations        = $product_skroutz->get_available_variations();
                            $variations_id     = wp_list_pluck( $variations, 'variation_id' );
                            $skroutz_att_array = array();

                            foreach ( $variations_id as $var_id ) {
                                $stock_value = get_post_meta( $var_id, '_stock_status', true );
                                if ( $stock_value == 'instock' ) {
                                    foreach ( $term_value as $term ) {
                                        $attr_value = get_post_meta( $var_id, 'attribute_' . $term->taxonomy, true );
                                        if ( ! in_array( $attr_value, $skroutz_att_array ) ) {
                                            array_push( $skroutz_att_array, $attr_value );
                                        }
                                        // unset($attr_value);
                                    }
                                    $product_data[ $taxo ] = ltrim( $product_data[ $taxo ], ',' );
                                    $product_data[ $taxo ] = rtrim( $product_data[ $taxo ], ',' );
                                }
                            }

                            foreach ( $skroutz_att_array as $skrtz_value ) {
                                $product_data[ $taxo ] .= ',' . $skrtz_value;
                            }
                            $product_data[ $taxo ] = ltrim( $product_data[ $taxo ], ',' );
                            $product_data[ $taxo ] = rtrim( $product_data[ $taxo ], ',' );
                        } else {
                            // Simple Skroutz product
                            foreach ( $term_value as $term ) {
                                $product_data[ $taxo ] .= ',' . $term->name;
                            }
                            $product_data[ $taxo ] = ltrim( $product_data[ $taxo ], ',' );
                            $product_data[ $taxo ] = rtrim( $product_data[ $taxo ], ',' );
                        }
                    } else {
                        foreach ( $term_value as $term ) {
                            $product_data[ $taxo ] .= ',' . $term->name;
                        }
                        $product_data[ $taxo ] = ltrim( $product_data[ $taxo ], ',' );
                        $product_data[ $taxo ] = rtrim( $product_data[ $taxo ], ',' );
                    }
                }

                // unset($term_value);
            }

            /*
             * Add product tags to the product data array
             */
            $product_tags = get_the_terms( $product_data['id'], 'product_tag' );
            if ( is_array( $product_tags ) ) {
                foreach ( $product_tags as $term ) {
                    if ( ! array_key_exists( 'product_tag', $product_data ) ) {
                        $product_data['product_tag']       = array( $term->name );
                        $product_data['product_tag_space'] = array( $term->name );
                    } else {
                        array_push( $product_data['product_tag'], $term->name );
                        array_push( $product_data['product_tag_space'], $term->name );
                    }
                }
            } else {
                $product_data['product_tag']       = array();
                $product_data['product_tag_space'] = array();
            }
            // unset($product_tags);

            /**
             * Get Custom Attributes for Single, Bundled and Composite products
             */
            if ( ( $product->is_type( 'simple' ) ) || ( $product->is_type( 'woosb' ) ) || ( $product->is_type( 'mix-and-match' ) ) || ( $product->is_type( 'external' ) ) || ( $product->is_type( 'bundle' ) ) || ( $product->is_type( 'composite' ) ) || ( $product_data['product_type'] == 'variable' ) || ( $product_data['product_type'] == 'auction' ) || ( $product->is_type( 'subscription' ) || ( $product->is_type( 'grouped' ) ) ) ) {
                $custom_attributes = $this->get_custom_attributes( $product_data['id'] );

                if ( is_array( $custom_attributes ) ) {
                    if ( ! in_array( 'woosea optimized title', $custom_attributes ) ) {
                        $woosea_opt        = array(
                            '_woosea_optimized_title' => 'woosea optimized title',
                        );
                        $custom_attributes = array_merge( $custom_attributes, $woosea_opt );
                    }

                    if ( class_exists( 'All_in_One_SEO_Pack' ) ) {
                        $custom_attributes['_aioseop_title']       = 'All in one seo pack title';
                        $custom_attributes['_aioseop_description'] = 'All in one seo pack description';
                    }

                    if ( class_exists( 'Yoast_WooCommerce_SEO' ) ) {
                        if ( array_key_exists( 'yoast_gtin8', $custom_attributes ) ) {
                            $product_data['yoast_gtin8'] = $custom_attributes['yoast_gtin8'];
                        }
                        if ( array_key_exists( 'yoast_gtin12', $custom_attributes ) ) {
                            $product_data['yoast_gtin12'] = $custom_attributes['yoast_gtin12'];
                        }
                        if ( array_key_exists( 'yoast_gtin13', $custom_attributes ) ) {
                            $product_data['yoast_gtin13'] = $custom_attributes['yoast_gtin13'];
                        }
                        if ( array_key_exists( 'yoast_gtin14', $custom_attributes ) ) {
                            $product_data['yoast_gtin14'] = $custom_attributes['yoast_gtin14'];
                        }
                        if ( array_key_exists( 'yoast_isbn', $custom_attributes ) ) {
                            $product_data['yoast_isbn'] = $custom_attributes['yoast_isbn'];
                        }
                        if ( array_key_exists( 'yoast_mpn', $custom_attributes ) ) {
                            $product_data['yoast_mpn'] = $custom_attributes['yoast_mpn'];
                        }
                    }

                    foreach ( $custom_attributes as $custom_kk => $custom_vv ) {
                        $custom_value = get_post_meta( $product_data['id'], $custom_kk, true );
                        $new_key      = 'custom_attributes_' . $custom_kk;

                        // This is a ACF image field (PLEASE NOTE: the ACF field needs to contain image or bild in the name)
                        if ( preg_match( '/image|bild|immagine/i', $custom_kk ) ) {
                            if ( class_exists( 'ACF' ) && ( $custom_value > 0 ) ) {
                                $image = wp_get_attachment_image_src( $custom_value, 'large' );

                                if ( isset( $image[0] ) ) {
                                    $custom_value = $image[0];
                                }
                            }
                        }

                        // Just to make sure the title is never empty
                        if ( ( $custom_kk == '_aioseop_title' ) && ( $custom_value == '' ) ) {
                            $custom_value = $product_data['title'];
                        }

                        // Just to make sure the description is never empty
                        if ( ( $custom_kk == '_aioseop_description' ) && ( $custom_value == '' ) ) {
                            $custom_value = $product_data['description'];
                        }

                        // Just to make sure product names are never empty
                        if ( ( $custom_kk == '_woosea_optimized_title' ) && ( $custom_value == '' ) ) {
                            $custom_value = $product_data['title'];
                        }

                        // Just to make sure the condition field is never empty
                        if ( ( $custom_kk == '_woosea_condition' ) && ( $custom_value == '' ) ) {
                            $custom_value = $product_data['condition'];
                        }

                        $product_data[ $new_key ] = $custom_value;
                    }
                }
                // unset($custom_attributes);

                /**
                 * We need to check if this product has individual custom product attributes
                 */
                global $wpdb;
                $sql = $wpdb->prepare(
                    "SELECT meta.meta_id, meta.meta_key as name, meta.meta_value as type 
                    FROM {$wpdb->prefix}postmeta AS meta, {$wpdb->prefix}posts AS posts 
                    WHERE meta.post_id = %d AND meta.post_id = posts.id 
                    GROUP BY meta.meta_key 
                    ORDER BY meta.meta_key ASC",
                    absint( $product_data['id'] )
                );
                $data = $wpdb->get_results( $sql );
                if ( count( $data ) ) {
                    foreach ( $data as $key => $value ) {
                        $value_display = str_replace( '_', ' ', $value->name );
                        if ( preg_match( '/_product_attributes/i', $value->name ) ) {
                            $product_attr = unserialize( $value->type );

                            if ( ! empty( $product_attr ) ) {
                                foreach ( $product_attr as $key => $arr_value ) {
                                    $new_key = 'custom_attributes_' . $key;
                                    if ( ! empty( $arr_value['value'] ) ) {
                                        $product_data[ $new_key ] = $arr_value['value'];
                                    }
                                }
                            }
                        }
                    }
                }
                // unset($data);
            }

            /**
             * Get Product Attributes for Single products
             * These are the attributes users create themselves in WooCommerce
             */
            if ( ( $product->is_type( 'simple' ) ) || ( $product->is_type( 'external' ) ) || ( $product->is_type( 'woosb' ) ) || ( $product->is_type( 'mix-and-match' ) ) || ( $product->is_type( 'bundle' ) ) || ( $product->is_type( 'composite' ) ) || ( $product->is_type( 'auction' ) || ( $product->is_type( 'subscription' ) ) || ( $product->is_type( 'variable' ) ) ) ) {
                $single_attributes = $product->get_attributes();
                foreach ( $single_attributes as $attribute ) {
                    $attr_name                  = strtolower( $attribute->get_name() );
                    $attr_value                 = $product->get_attribute( $attr_name );
                    $product_data[ $attr_name ] = $attr_value;
                }
                // unset($single_attributes);
            }

            // Check if user would like to use the mother main image for all variation products
            $use_parent_variable_product_image = get_option( 'adt_use_parent_variable_product_image' );
            if ( ( $use_parent_variable_product_image == 'yes' ) && ( $product_data['item_group_id'] > 0 ) ) {
                $mother_image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_data['item_group_id'] ), 'full' );
                if ( isset( $mother_image[0] ) ) {
                    $product_data['image'] = $mother_image[0];
                }
                // unset($mother_image);
            }

            /**
             * Versioned products need a seperate approach
             * Get data for these products based on the mother products item group id
             */
            $variation_pass = 'true';

            if ( ( $product_data['item_group_id'] > 0 ) && ( is_object( wc_get_product( $product_data['item_group_id'] ) ) ) && ( ( $product_data['product_type'] == 'variation' ) || ( $product_data['product_type'] == 'subscription_variation' ) ) ) {
                $product_variations = new WC_Product_Variation( $product_data['id'] );
                $variations         = $product_variations->get_variation_attributes();

                // For Skroutz and Bestprice apparal products we can only append colours to the product name
                // When a product has both a size and color attribute we assume its an apparal product
                if ( ( $feed_channel['fields'] == 'skroutz' ) || ( $feed_channel['fields'] == 'bestprice' ) ) {
                    $size_found  = 'no';
                    $color_found = 'no';

                    foreach ( $feed_attributes as $ky => $vy ) {
                        if ( isset( $vy['attribute'] ) ) {
                            if ( $vy['attribute'] == 'size' ) {
                                $size_found   = 'yes';
                                $sz_attribute = $vy['mapfrom'];
                            }
                            if ( $vy['attribute'] == 'color' ) {
                                $color_found   = 'yes';
                                $clr_attribute = $vy['mapfrom'];
                            }
                        }
                    }

                    // Remove size from variations array
                    if ( ( $size_found == 'yes' ) && ( $color_found == 'yes' ) ) {
                        update_option( 'skroutz_apparel', false );
                        update_option( 'skroutz_clr', $clr_attribute, false );
                        update_option( 'skroutz_sz', $sz_attribute, false );
                    }

                    $skroutz_apparal = get_option( 'skroutz_apparel' );

                    if ( $skroutz_apparal == 'yes' ) {
                        if ( isset( $clr_attribute ) ) {
                            $skroutz_color = get_post_meta( $product_data['id'], 'attribute_' . $clr_attribute, true );
                        }

                        if ( isset( $sz_attribute ) ) {
                            $skroutz_size = get_post_meta( $product_data['id'], 'attribute_' . $sz_attribute, true );
                        }

                        if ( ( ! empty( $skroutz_color ) ) && ( ! empty( $skroutz_size ) ) ) {
                            foreach ( $variations as $kvar => $vvar ) {
                                // Does this product have a color value
                                $var_key       = get_option( 'skroutz_clr' );
                                $var_key       = 'attribute_' . $var_key;
                                $skroutz_color = get_post_meta( $product_data['id'], $var_key, true );

                                // Does this color have a size value
                                $var_key_sz   = get_option( 'skroutz_sz' );
                                $var_key_sz   = 'attribute_' . $var_key_sz;
                                $skroutz_size = get_post_meta( $product_data['id'], $var_key_sz, true );

                                if ( $kvar == $var_key ) {
                                    if ( ! isset( $skroutz_clr_array ) ) {
                                        if ( ! empty( $skroutz_color ) ) {
                                            $skroutz_clr_array = array( $skroutz_color );
                                        }
                                    } elseif ( ! empty( $skroutz_color ) ) {
                                        if ( ! in_array( $skroutz_color, $skroutz_clr_array ) ) {
                                            array_push( $skroutz_clr_array, $skroutz_color );
                                            $variation_pass = 'true';
                                        } else {
                                            $variation_pass = 'false';
                                        }
                                    }
                                } else {
                                    unset( $variations[ $kvar ] );
                                }
                            }
                        } else {
                            // This is not an apparal product so a color variation is not allowed
                            $variation_pass = 'true';
                        }
                    } else {
                        $variation_pass = 'true';
                    }
                }

                if ( ( $feed->only_include_lowest_product_variation ) || ( $feed->only_include_default_product_variation ) ) {
                    // Determine the default variation product
                    if ( ( $product_data['item_group_id'] > 0 ) && ( is_object( wc_get_product( $product_data['item_group_id'] ) ) ) && ( ( $product_data['product_type'] == 'variation' ) || ( $product_data['product_type'] == 'subscription_variation' ) ) ) {
                        $mother_product = new WC_Product_Variable( $product_data['item_group_id'] );
                        // $mother_product = wc_get_product($product_data['item_group_id']);
                        $def_attributes = $mother_product->get_default_attributes();

                        if ( $feed->only_include_lowest_product_variation ) {

                            // Determine lowest priced variation
                            $variation_min_price    = $mother_product->get_variation_price( 'min' );
                            $variation_min_price    = wc_format_decimal( $variation_min_price, 2 );
                            $variation_min_price    = wc_format_localized_price( $variation_min_price );
                            $var_price              = get_post_meta( $product_data['id'], '_price', true );
                            $var_price              = wc_format_decimal( $var_price, 2 );
                            $var_price              = wc_format_localized_price( $var_price );
                            $variation_prices       = $mother_product->get_variation_prices();
                            $variation_prices_price = array_values( $variation_prices['price'] );
                            if ( ! empty( $variation_prices_price ) ) {
                                $lowest_price = min( $variation_prices_price );
                            } else {
                                $lowest_price = 0;
                            }

                            if ( ( $var_price == $lowest_price ) || ( $var_price == $variation_min_price ) || ( $product_data['system_regular_price'] == $variation_min_price ) || ( $product_data['system_net_price'] == $variation_min_price ) ) {
                                $variation_pass = 'true';
                            } else {
                                $variation_pass = 'false';
                            }
                        }
                    }
                    // Get review rating and count for parent product
                    $product_data['rating_total']   = $mother_product->get_rating_count();
                    $product_data['rating_average'] = $mother_product->get_average_rating();

                    if ( $feed->only_include_default_product_variation ) {
                        $diff_result = array_diff( $variations, $def_attributes );

                        if ( ! empty( $diff_result ) ) {
                            // Only when a variant has no attributes selected we will let it pass
                            if ( count( array_filter( $variations ) ) == 0 ) {
                                $variation_pass = 'true';
                            } else {
                                $variation_pass = 'false';
                            }
                        }
                    }
                }

                $append = '';
                $product_data['parent_sku'] = get_post_meta( $product_data['item_group_id'], '_sku', true );

                /**
                 * Add the product visibility values for variations based on the simple mother product
                 */
                $product_data['exclude_from_catalog'] = 'no';
                $product_data['exclude_from_search']  = 'no';
                $product_data['exclude_from_all']     = 'no';

                $visibility_list = wp_get_post_terms( $product_data['item_group_id'], 'product_visibility', array( 'fields' => 'all' ) );

                if ( ! empty( $visibility_list ) ) {
                    foreach ( $visibility_list as $visibility_single ) {
                        if ( $visibility_single->slug == 'exclude-from-catalog' ) {
                            $product_data['exclude_from_catalog'] = 'yes';
                        }
                        if ( $visibility_single->slug == 'exclude-from-search' ) {
                            $product_data['exclude_from_search'] = 'yes';
                        }
                    }
                }
                // unset($visibility_list);

                if ( ( $product_data['exclude_from_search'] == 'yes' ) && ( $product_data['exclude_from_catalog'] == 'yes' ) ) {
                    $product_data['exclude_from_all'] = 'yes';
                }

                /**
                 * Although this is a product variation we also need to grap the Product attributes belonging to the simple mother product
                 */
                $mother_attributes = get_post_meta( $product_data['item_group_id'], '_product_attributes' );

                if ( ! empty( $mother_attributes ) ) {
                    foreach ( $mother_attributes as $attribute ) {
                        foreach ( $attribute as $key => $attr ) {
                            $attr_name = $attr['name'];

                            if ( ! empty( $attr_name ) ) {
                                $terms = get_the_terms( $product_data['item_group_id'], $attr_name );
                                if ( is_array( $terms ) ) {
                                    foreach ( $terms as $term ) {
                                        $attr_value = $term->name;
                                    }
                                    $product_data[ $attr_name ] = $attr_value;
                                } else {
                                    // Add the variable parent attributes
                                    // When the attribute was not set for variations
                                    if ( $attr['is_variation'] == 0 ) {
                                        $new_key                  = 'custom_attributes_' . $key;
                                        $product_data[ $new_key ] = $attr['value'];
                                    }
                                }
                            }
                        }
                    }
                }
                // unset($mother_attributes);

                /**
                 * Although this is a product variation we also need to grap the Dynamic attributes belonging to the simple mother prodict
                 */
                $stock_value = get_post_meta( $product_data['id'], '_stock_status', true );
                // if($stock_value == "instock"){
                foreach ( $diff_taxonomies as $taxo ) {
                    $term_value = get_the_terms( $product_data['item_group_id'], $taxo );
                    unset( $product_data[ $taxo ] );
                    if ( is_array( $term_value ) ) {
                        foreach ( $term_value as $term ) {
                            if ( empty( $product_data[ $taxo ] ) ) {
                                $product_data[ $taxo ] = $term->name;
                            } else {
                                $product_data[ $taxo ] .= ',' . $term->name;
                                // $product_data[$taxo] .= " ".$term->name; // October 3th 2023
                            }
                        }
                    }
                }

                /**
                 * Add product tags to the product data array
                 */
                $product_tags = get_the_terms( $product_data['item_group_id'], 'product_tag' );
                if ( is_array( $product_tags ) ) {

                    foreach ( $product_tags as $term ) {

                        if ( ! array_key_exists( 'product_tag', $product_data ) ) {
                            $product_data['product_tag'] = array( $term->name );
                        } else {
                            array_push( $product_data['product_tag'], $term->name );
                        }
                    }
                }

                // Add attribute values to the variation product names to make them unique
                $product_data['title_hyphen']        = $product_data['title'] . ' - ';
                $product_data['mother_title_hyphen'] = $product_data['mother_title'] . ' - ';

                foreach ( $variations as $kk => $vv ) {
                    $custom_key = $kk;

                    if ( $feed->include_product_variations ) {
                        $taxonomy = str_replace( 'attribute_', '', $kk );

                        $term = get_term_by( 'slug', $vv, $taxonomy );

                        if ( $term && $term->name ) {
                            $vv = $term->name;
                        }

                        if ( $vv ) {
                            $append = ucfirst( $vv );
                            $append = rawurldecode( $append );

                            // Prevent duplicate attribute values from being added to the product name
                            if ( ! preg_match( '/' . preg_quote( $product_data['title'], '/' ) . '/', $append ) ) {
                                $product_data['title']        = $product_data['title'] . ' ' . $append;
                                $product_data['title_hyphen'] = $product_data['title_hyphen'] . ' ' . $append;
                            }
                        }
                    }

                    $custom_key                  = str_replace( 'attribute_', '', $custom_key );
                    $product_data[ $custom_key ] = $vv;
                    $append                      = '';
                }

                /**
                 * Get Custom Attributes for this variable product
                 */
                $custom_attributes = $this->get_custom_attributes( $product_data['id'] );

                if ( is_array( $custom_attributes ) ) {
                    if ( ! in_array( 'woosea optimized title', $custom_attributes ) ) {
                        $woosea_opt        = array(
                            '_woosea_optimized_title' => 'woosea optimized title',
                        );
                        $custom_attributes = array_merge( $custom_attributes, $woosea_opt );
                    }
                }

                if ( class_exists( 'All_in_One_SEO_Pack' ) ) {
                    $custom_attributes['_aioseop_title']       = 'All in one seo pack title';
                    $custom_attributes['_aioseop_description'] = 'All in one seo pack description';
                }

                if ( class_exists( 'Yoast_WooCommerce_SEO' ) ) {
                    $yoast_identifiers = get_post_meta( $product_data['id'], 'wpseo_variation_global_identifiers_values' );

                    if ( ! empty( $yoast_identifiers[0] ) ) {
                        if ( array_key_exists( 'gtin8', $yoast_identifiers[0] ) ) {
                            $product_data['yoast_gtin8'] = $yoast_identifiers[0]['gtin8'];
                        }
                        if ( array_key_exists( 'gtin12', $yoast_identifiers[0] ) ) {
                            $product_data['yoast_gtin12'] = $yoast_identifiers[0]['gtin12'];
                        }
                        if ( array_key_exists( 'gtin13', $yoast_identifiers[0] ) ) {
                            $product_data['yoast_gtin13'] = $yoast_identifiers[0]['gtin13'];
                        }
                        if ( array_key_exists( 'gtin14', $yoast_identifiers[0] ) ) {
                            $product_data['yoast_gtin14'] = $yoast_identifiers[0]['gtin14'];
                        }
                        if ( array_key_exists( 'isbn', $yoast_identifiers[0] ) ) {
                            $product_data['yoast_isbn'] = $yoast_identifiers[0]['isbn'];
                        }
                        if ( array_key_exists( 'mpn', $yoast_identifiers[0] ) ) {
                            $product_data['yoast_mpn'] = $yoast_identifiers[0]['mpn'];
                        }
                    }
                }

                foreach ( $custom_attributes as $custom_kk => $custom_vv ) {
                    $custom_value = get_post_meta( $product_data['id'], $custom_kk, true );

                    // Product variant brand is empty, grap that of the mother product
                    if ( ( $custom_kk == '_woosea_brand' ) && ( $custom_value == '' ) ) {
                        $custom_value = get_post_meta( $product_data['item_group_id'], $custom_kk, true );
                    }

                    // Just to make sure the title is never empty
                    if ( ( $custom_kk == '_aioseop_title' ) && ( $custom_value == '' ) ) {
                        $custom_value = $product_data['title'];
                    }

                    // Just to make sure the description is never empty
                    if ( ( $custom_kk == '_aioseop_description' ) && ( $custom_value == '' ) ) {
                        $custom_value = $product_data['description'];
                    }

                    // Product variant optimized title is empty, grap the mother product title
                    if ( ( $custom_kk == '_woosea_optimized_title' ) && ( $custom_value == '' ) ) {
                        $custom_value = $product_data['title'];
                    }

                    if ( ! is_array( $custom_value ) ) {
                        $custom_kk = str_replace( 'attribute_', '', $custom_kk );
                        $new_key   = 'custom_attributes_' . $custom_kk;

                        // In order to make the mapping work again, replace var by product
                        $new_key = str_replace( 'var', 'product', $new_key );
                        if ( ! empty( $custom_value ) ) {
                            $product_data[ $new_key ] = $custom_value;
                        }
                    }
                }

                /**
                 * We need to check if this product has individual custom product attributes
                 */
                global $wpdb;
                $sql = $wpdb->prepare(
                    "SELECT meta.meta_id, meta.meta_key as name, meta.meta_value as type 
                    FROM {$wpdb->prefix}postmeta AS meta, {$wpdb->prefix}posts AS posts 
                    WHERE meta.post_id = %d AND meta.post_id = posts.id 
                    GROUP BY meta.meta_key 
                    ORDER BY meta.meta_key ASC",
                    absint( $product_data['id'] )
                );
                $data = $wpdb->get_results( $sql );
                if ( count( $data ) ) {
                    foreach ( $data as $key => $value ) {
                        $value_display = str_replace( '_', ' ', $value->name );
                        if ( preg_match( '/_product_attributes/i', $value->name ) ) {
                            $product_attr = unserialize( $value->type );
                            if ( ( ! empty( $product_attr ) ) && ( is_array( $product_attr ) ) ) {
                                foreach ( $product_attr as $key => $arr_value ) {
                                    $new_key                  = 'custom_attributes_' . $key;
                                    $product_data[ $new_key ] = $arr_value['value'];
                                }
                            }
                        }
                    }
                }

                /**
                 * We also need to make sure that we get the custom attributes belonging to the simple mother product
                 */
                $custom_attributes_mother = $this->get_custom_attributes( $product_data['item_group_id'] );

                foreach ( $custom_attributes_mother as $custom_kk_m => $custom_value_m ) {

                    if ( ! array_key_exists( $custom_kk_m, $product_data ) ) {
                        $custom_value_m = get_post_meta( $product_data['item_group_id'], $custom_kk_m, true );
                        $new_key_m      = 'custom_attributes_' . $custom_kk_m;

                        if ( ! is_array( $custom_value_m ) ) {
                            // In order to make the mapping work again, replace var by product
                            // $new_key_m = str_replace("var","product",$new_key_m);
                            if ( ! key_exists( $new_key_m, $product_data ) && ( ! empty( $custom_value_m ) ) ) {
                                if ( is_array( $custom_value_m ) ) {
                                    // determine what to do with this later
                                } else {
                                    // This is most likely a ACF field
                                    if ( class_exists( 'ACF' ) && ( $custom_value_m > 0 ) ) {
                                        $image = wp_get_attachment_image_src( $custom_value_m, 'large' );
                                        if ( isset( $image[0] ) ) {
                                            $custom_value               = $image[0];
                                            $product_data[ $new_key_m ] = $custom_value;
                                        } else {
                                            $product_data[ $new_key_m ] = $custom_value_m;
                                        }
                                    } else {
                                        $product_data[ $new_key_m ] = $custom_value_m;
                                    }
                                }
                            }
                        } else {
                            $arr_value = '';
                            foreach ( $custom_value_m as $key => $value ) {
                                // not for multidimensional arrays
                                if ( is_string( $value ) ) {
                                    if ( is_string( $value ) ) {
                                        $arr_value .= $value . ',';
                                    }
                                }
                            }
                            $arr_value                  = rtrim( $arr_value, ',' );
                            $product_data[ $new_key_m ] = $arr_value;
                        }
                    }
                }

                // unset($custom_attributes_mother);
                // unset($product_variations);
                // unset($variations);
            }
            // END VARIABLE PRODUCT CODE

            /**
             * In order to prevent XML formatting errors in Google's Merchant center
             * we will add CDATA brackets to the title and description attributes
             */
            $product_data['title_lc']  = ucfirst( strtolower( $product_data['title'] ) );
            $product_data['title_lcw'] = ucwords( strtolower( $product_data['title'] ) );

            /**
             * Get product reviews for Google Product Review Feeds
             */
            $product_data['reviews'] = $this->woosea_get_reviews( $product_data, $product, $feed );

            /**
             * Filter out reviews that do not have text
             */
            if ( ! empty( $product_data['reviews'] ) ) {
                foreach ( $product_data['reviews'] as $review_id => $review_details ) {
                    if ( empty( $review_details['content'] ) ) {
                        unset( $product_data['reviews'][ $review_id ] );
                    }
                }
            }

            /**
             * Filter out reviews that do not have a rating
             */
            if ( ! empty( $product_data['reviews'] ) ) {
                foreach ( $product_data['reviews'] as $review_id => $review_details ) {
                    if ( empty( $review_details['review_ratings'] ) ) {
                        unset( $product_data['reviews'][ $review_id ] );
                    }
                }
            }

            /**
             * Filter out reviews that have a link in the review text / content as that is now allowed by Google
             */
            if ( ! empty( $product_data['reviews'] ) ) {
                foreach ( $product_data['reviews'] as $review_id => $review_details ) {
                    $pos = strpos( $review_details['content'], 'www' );
                    if ( $pos !== false ) {
                        unset( $product_data['reviews'][ $review_id ] );
                    }

                    $pos = strpos( $review_details['content'], 'http' );
                    if ( $pos !== false ) {
                        unset( $product_data['reviews'][ $review_id ] );
                    }
                }
            }

            /**
             * Filter out revieuws with a low rating
             */
            if ( ! empty( $product_data['reviews'] ) ) {

                // Check if we need to filter uit reviews with a low rating
                if ( ! empty( $feed_filters ) ) {
                    foreach ( $feed_filters as $filter_id => $filter_details ) {
                        if ( array_key_exists( 'attribute', $filter_details ) ) {
                            if ( $filter_details['attribute'] == 'review_rating' ) {

                                // Loop through reviews
                                foreach ( $product_data['reviews'] as $review_id => $review_details ) {
                                    if ( ! empty( $review_details['review_ratings'] ) ) {

                                        if ( ( $filter_details['condition'] == '<' ) && ( $review_details['review_ratings'] < $filter_details['criteria'] ) && ( $filter_details['than'] == 'exclude' ) ) {
                                            unset( $product_data['reviews'][ $review_id ] );
                                        } elseif ( ( $filter_details['condition'] == '>' ) && ( $review_details['review_ratings'] > $filter_details['criteria'] ) && ( $filter_details['than'] == 'exclude' ) ) {
                                            unset( $product_data['reviews'][ $review_id ] );
                                        } elseif ( ( $filter_details['condition'] == '>=' ) && ( $review_details['review_ratings'] >= $filter_details['criteria'] ) && ( $filter_details['than'] == 'exclude' ) ) {
                                            unset( $product_data['reviews'][ $review_id ] );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            /**
             * Check if individual products need to be excluded
             */
            $product_data = $this->woosea_exclude_individual( $product_data );

            /**
             * Do final check on Skroutz out of stock sizes
             * When a size is not on stock remove it
             */
            if ( $feed_channel['fields'] == 'skroutz' ) {
                if ( isset( $product_data['id'] ) ) {
                    foreach ( $feed_attributes as $ky => $vy ) {
                        if ( isset( $vy['attribute'] ) ) {
                            if ( $vy['attribute'] == 'size' ) {
                                $size_found   = 'yes';
                                $sz_attribute = $vy['mapfrom'];
                            }
                            if ( $vy['attribute'] == 'color' ) {
                                $color_found   = 'yes';
                                $clr_attribute = $vy['mapfrom'];
                            }
                        }
                    }
                    $stock_value = get_post_meta( $product_data['id'], '_stock_status', true );
                    if ( ! empty( $clr_attribute ) ) {
                        $clr_attr_value = get_post_meta( $product_data['id'], 'attribute_' . $clr_attribute, true );
                    } else {
                        $clr_attr_value = '';
                    }

                    if ( isset( $product_data['item_group_id'] ) && ( $product_data['product_type'] == 'variation' ) ) {
                        if ( $product_data['item_group_id'] > 0 ) {
                            $product_skroutz = wc_get_product( $product_data['item_group_id'] );
                            if ( is_object( $product_skroutz ) ) {
                                $skroutz_product_type = $product_skroutz->get_type();
                            }

                            if ( ( $product_skroutz ) && ( $skroutz_product_type == 'variable' ) ) {
                                $variations         = $product_skroutz->get_available_variations();
                                $variations_id      = wp_list_pluck( $variations, 'variation_id' );
                                $total_quantity     = 0;
                                $quantity_variation = 0;

                                $sizez = array();
                                foreach ( $variations_id as $var_id_s ) {
                                    $taxonomy        = 'pa_size';
                                    $sizez_variation = get_post_meta( $var_id_s, 'attribute_' . $taxonomy, true );
                                    if ( $sizez_variation ) {
                                        $sizez_term = get_term_by( 'slug', $sizez_variation, $taxonomy );
                                        if ( ! in_array( $sizez_term->name, $sizez ) ) {
                                            array_push( $sizez, $sizez_term->name );
                                        }
                                    }
                                }

                                foreach ( $variations_id as $var_id ) {
                                    if ( isset( $clr_attribute ) ) {
                                        // $clr_variation = get_post_meta( $product_data['id'], "attribute_".$clr_attribute, true );
                                        $clr_variation = get_post_meta( $var_id, 'attribute_' . $clr_attribute, true );
                                    } else {
                                        $clr_variation = '';
                                    }

                                    // Sum quantity of variations for apparel products
                                    if ( array_key_exists( 'pa_size', $product_data ) && array_key_exists( 'pa_color', $product_data ) ) {
                                        $quantity_variation = $this->get_attribute_value( $var_id, '_stock' );
                                        if ( ! empty( $quantity_variation ) ) {
                                            $total_quantity += $quantity_variation;
                                        }
                                        $product_data['quantity'] = $total_quantity;
                                    }

                                    if ( isset( $sz_attribute ) ) {
                                        $size_variation = ucfirst( get_post_meta( $var_id, 'attribute_' . $sz_attribute, true ) );
                                    }
                                    $stock_variation = get_post_meta( $var_id, '_stock_status', true );

                                    if ( $clr_variation == $clr_attr_value ) {
                                        if ( $stock_variation == 'outofstock' ) {
                                            // Remove this size as it is not on stock
                                            $size_variation_new = $size_variation . ',';
                                            $size_variation_new = str_replace( '-', ' ', $size_variation_new );
                                            $size_variation     = str_replace( '-', ' ', $size_variation );

                                            if ( isset( $sz_attribute ) ) {
                                                if ( array_key_exists( $sz_attribute, $product_data ) ) {
                                                    $product_data[ $sz_attribute ] = str_replace( ucfirst( $size_variation ), '', $product_data[ $sz_attribute ] );
                                                    $product_data[ $sz_attribute ] = rtrim( $product_data[ $sz_attribute ], ' ' );
                                                    $product_data[ $sz_attribute ] = trim( $product_data[ $sz_attribute ], ',' );
                                                }
                                            }
                                        } else {
                                            // Add comma's in the size field and put availability on stock as at least one variation is on stock
                                            if ( isset( $size_variation ) ) {

                                                if ( isset( $sz_attribute ) ) {
                                                    $product_data[ $sz_attribute ] = implode( ',', $sizez );
                                                    $product_data['availability']  = 'in stock';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            // This is a parent variable product
                            if ( $product_data['product_type'] == 'variable' ) {
                                $product_skroutz = wc_get_product( $product_data['id'] );
                                $variations      = $product_skroutz->get_available_variations();
                                $variations_id   = wp_list_pluck( $variations, 'variation_id' );

                                foreach ( $variations_id as $var_id ) {
                                    // $clr_variation = get_post_meta( $var_id, "attribute_".$clr_attribute, true );
                                    $size_variation  = get_post_meta( $var_id, 'attribute_' . $sz_attribute, true );
                                    $stock_variation = get_post_meta( $var_id, '_stock_status', true );

                                    if ( $stock_variation == 'outofstock' ) {
                                        // Remove this size as it is not on stock
                                        if ( array_key_exists( $sz_attribute, $product_data ) ) {
                                            $product_data[ $sz_attribute ] = str_replace( ucfirst( $size_variation ), '', $product_data[ $sz_attribute ] );
                                            $product_data[ $sz_attribute ] = str_replace( ', , ', ',', $product_data[ $sz_attribute ] );
                                            $product_data[ $sz_attribute ] = rtrim( $product_data[ $sz_attribute ], ' ' );
                                            $product_data[ $sz_attribute ] = rtrim( $product_data[ $sz_attribute ], ',' );
                                        }
                                    }
                                }
                            }
                        }
                    } elseif ( $product_data['product_type'] == 'variable' ) {
                        $product_skroutz = wc_get_product( $product_data['id'] );
                        $variations      = $product_skroutz->get_available_variations();
                        $variations_id   = wp_list_pluck( $variations, 'variation_id' );

                        $enabled_sizes  = array();
                        foreach ( $variations_id as $var_id ) {
                            if ( isset( $sz_attribute ) ) {
                                $size_variation  = strtoupper( get_post_meta( $var_id, 'attribute_' . $sz_attribute, true ) );
                                $enabled_sizes[] = $size_variation;
                            }
                        }

                        $new_size = '';
                        foreach ( $enabled_sizes as $siz ) {
                            $siz            = trim( $siz, ' ' );
                            $size_variation = trim( $size_variation, ' ' );
                            $new_size      .= ' ' . $siz . ',';
                        }

                        if ( isset( $sz_attribute ) ) {
                            $product_data[ $sz_attribute ] = $new_size;
                            $product_data[ $sz_attribute ] = str_replace( ', , ', ',', $product_data[ $sz_attribute ] );
                            $product_data[ $sz_attribute ] = rtrim( $product_data[ $sz_attribute ], ' ' );
                            $product_data[ $sz_attribute ] = rtrim( $product_data[ $sz_attribute ], ',' );
                            $product_data[ $sz_attribute ] = ltrim( $product_data[ $sz_attribute ], ',' );
                        }

                        foreach ( $variations_id as $var_id ) {
                            if ( isset( $sz_attribute ) ) {
                                $size_variation   = get_post_meta( $var_id, 'attribute_' . $sz_attribute, true );
                                $product_excluded = ucfirst( get_post_meta( $var_id, '_woosea_exclude_product', true ) );

                                if ( $product_excluded == 'Yes' ) {
                                    // Remove this size as it is has been set to be excluded from feeds
                                    if ( array_key_exists( $sz_attribute, $product_data ) ) {
                                        $new_size = '';
                                        foreach ( $enabled_sizes as $siz ) {
                                            $siz            = trim( $siz, ' ' );
                                            $size_variation = trim( $size_variation, ' ' );
                                            if ( $siz != strtoupper( $size_variation ) ) {
                                                $new_size .= ' ' . $siz . ',';
                                            }
                                        }
                                        $product_data[ $sz_attribute ] = $new_size;
                                        $product_data[ $sz_attribute ] = str_replace( ', , ', ',', $product_data[ $sz_attribute ] );
                                        $product_data[ $sz_attribute ] = rtrim( $product_data[ $sz_attribute ], ' ' );
                                        $product_data[ $sz_attribute ] = rtrim( $product_data[ $sz_attribute ], ',' );
                                        $product_data[ $sz_attribute ] = ltrim( $product_data[ $sz_attribute ], ',' );
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if ( isset( $product_data['title_lcw'] ) ) {
                $product_data['title_lcw'] = ucwords( $product_data['title_lcw'] );
            }

            /**
             * When a product is a variable product we need to delete the original product from the feed, only the originals are allowed
             */
            // For these channels parent products are allowed
            $allowed_channel_parents = array(
                'skroutz',
                // "bestprice",
                'google_dsa',
                'google_product_review',
            );

            if ( ! in_array( $feed_channel['fields'], $allowed_channel_parents ) ) {
                if ( ( $product->is_type( 'variable' ) ) && ( isset( $product_data['item_group_id'] ) ) ) {
                    $product_data = array();
                    $product_data = null;
                }
            }

            /**
             * Remove variation products that are not THE default variation product
             */
            if ( ( isset( $variation_pass ) ) && ( $variation_pass == 'false' ) ) {
                $product_data = array();
                $product_data = null;
            }

            /**
             * And item_group_id is not allowed for simple products, prevent users from adding this to the feedd
             */
            if ( ( $product->is_type( 'simple' ) ) || ( $product->is_type( 'external' ) ) || ( $product->is_type( 'woosb' ) ) || ( $product->is_type( 'mix-and-match' ) ) || ( $product->is_type( 'bundle' ) ) || ( $product->is_type( 'composite' ) ) || ( $product->is_type( 'auction' ) || ( $product->is_type( 'subscription' ) ) || ( $product->is_type( 'variable' ) ) ) ) {
                unset( $product_data['item_group_id'] );
            }

            /**
             * Truncate length of product title when it is over 150 characters (requirement for Google Shopping, Pinterest and Facebook
             */
            if ( isset( $product_data['title'] ) ) {
                $length_title = strlen( $product_data['title'] );
                if ( $length_title > 149 ) {
                    $product_data['title'] = mb_substr( $product_data['title'], 0, 150 );
                }
            }

            /**
             * Filter to allow manipulation of product data before it is added to the feed.
             *
             * @since 13.3.6
             *
             * @param array  $product_data The product data array
             * @param object $feed The feed object
             * @param object $product The product object
             */
            $product_data = apply_filters( 'adt_get_product_data', $product_data, $feed, $product );

            // Filter and rules execution.
            if ( is_array( $product_data ) && ! empty( $product_data ) ) {
                // Filter execution.
                $filters_instance = AdTribes\PFP\Classes\Filters::instance();
                $product_data     = $filters_instance->filter( $product_data, $feed );

                // Rules execution.
                $rules_instance = AdTribes\PFP\Classes\Rules::instance();
                $product_data   = $rules_instance->rules( $product_data, $feed );
            }

            /**
             * Localize the price attributes.
             */
            if ( ! empty( $product_data ) ) {
                $product_data_instance = AdTribes\PFP\Classes\Product_Data::instance();
                $product_data          = $product_data_instance->localize_prices( $product_data, $feed );
            }

            /**
             * Check if we need to add category taxonomy mappings (Google Shopping)
             */
            if ( ! empty( $product_data ) && ! empty( $product_data['id'] ) && $feed_channel['taxonomy'] == 'google_shopping' ) {
                if ( ! empty( $feed_mappings ) ) {
                    $product_data = $this->woocommerce_sea_mappings( $feed_mappings, $product_data );
                } else {
                    $product_data['categories'] = '';
                }
            }

            /**
             * When product has passed the filter rules it can continue with the rest
             */
            if ( ! empty( $product_data ) ) {
                /**
                 * Determine what fields are allowed to make it to the csv and txt productfeed
                 */
                if ( ( $feed_channel['fields'] != 'standard' ) && ( ! isset( $tmp_attributes ) ) && is_array( $feed_attributes ) && ! empty( $feed_attributes ) ) {
                    $old_attributes_config = $feed_attributes;
                    $tmp_attributes        = array();
                    foreach ( $feed_attributes as $key => $value ) {
                        if ( strlen( $value['mapfrom'] ) > 0 ) {
                            $tmp_attributes[ $value['mapfrom'] ] = 'true';
                        }
                    }
                }

                if ( isset( $old_attributes_config ) && is_array( $old_attributes_config ) ) {
                    $loop_count           = 0;
                    foreach ( $old_attributes_config as $attr_key => $attr_value ) {
                        if ( ! $attr_line ) {
                            if ( array_key_exists( 'static_value', $attr_value ) ) {
                                if ( strlen( $attr_value['mapfrom'] ) ) {
                                    $attr_line = "'" . $attr_value['prefix'] . $attr_value['mapfrom'] . $attr_value['suffix'] . "'";
                                } else {
                                    $attr_line = "''";
                                }
                            } elseif ( ( strlen( $attr_value['mapfrom'] ) ) && ( array_key_exists( $attr_value['mapfrom'], $product_data ) ) ) {
                                if ( ( $attr_value['attribute'] == 'URL' ) || ( $attr_value['attribute'] == 'g:link' ) || ( $attr_value['attribute'] == 'g:link_template' ) || ( $attr_value['attribute'] == 'g:image_link' ) || ( $attr_value['attribute'] == 'link' ) || ( $attr_value['attribute'] == 'Final URL' ) || ( $attr_value['attribute'] == 'SKU' ) || ( $attr_value['attribute'] == 'g:itemid' ) ) {
                                    $attr_line = "'" . $attr_value['prefix'] . $product_data[ $attr_value['mapfrom'] ] . $attr_value['suffix'] . "'";
                                } else {
                                    $attr_line = "'" . $attr_value['prefix'] . $product_data[ $attr_value['mapfrom'] ] . $attr_value['suffix'] . "'";
                                }
                            } else {
                                $attr_line = "''";
                            }
                        } elseif ( array_key_exists( 'static_value', $attr_value ) ) {
                            $attr_line .= ",'" . $attr_value['prefix'] . $attr_value['mapfrom'] . $attr_value['suffix'] . "'";
                        } elseif( $attr_value['mapfrom'] === 'page_url' || $attr_value['mapfrom'] === 'post_url' ) {
                            $post_or_page_id = $attr_value['value'] ?? '';
                            if ( $post_or_page_id ) {
                                $attr_line .= ",'" . $attr_value['prefix'] . get_permalink( $post_or_page_id ) . $attr_value['suffix'] . "'";
                            }
                        } else {
                            if ( array_key_exists( $attr_value['mapfrom'], $product_data ) ) {
                                if ( is_array( $product_data[ $attr_value['mapfrom'] ] ) ) {
                                    if ( $attr_value['mapfrom'] == 'product_tag' ) {
                                        $product_tag_str = '';
                                        foreach ( $product_data['product_tag'] as $key => $value ) {
                                            $product_tag_str .= ',';
                                            $product_tag_str .= "$value";
                                        }
                                        $product_tag_str = rtrim( $product_tag_str, ',' );
                                        $product_tag_str = ltrim( $product_tag_str, ',' );

                                        $attr_line .= ",'" . $product_tag_str . "'";
                                    } elseif ( $attr_value['mapfrom'] == 'reviews' ) {
                                        $review_str = '';
                                        foreach ( $product_data[ $attr_value['mapfrom'] ] as $key => $value ) {
                                            $review_str .= '||';
                                            foreach ( $value as $k => $v ) {
                                                $review_str .= ":$v";
                                            }
                                        }
                                        $review_str  = ltrim( $review_str, '||' );
                                        $review_str  = rtrim( $review_str, ':' );
                                        $review_str  = ltrim( $review_str, ':' );
                                        $review_str  = str_replace( '||:', '||', $review_str );
                                        $review_str .= '||';
                                        $attr_line  .= ",'" . $review_str . "'";
                                    } else {
                                        $shipping_str = '';
                                        foreach ( $product_data[ $attr_value['mapfrom'] ] as $key => $value ) {
                                            $shipping_str .= '||';
                                            if ( is_array( $value ) ) {
                                                foreach ( $value as $k => $v ) {
                                                    if ( preg_match( '/[0-9]/', $v ) ) {
                                                        $shipping_str .= ":$attr_value[prefix]" . $v . "$attr_value[suffix]";
                                                        // $shipping_str .= ":$attr_value[prefix]".$v."$attr_value[suffix]";
                                                    } else {
                                                        $shipping_str .= ":$v";
                                                    }
                                                }
                                            }
                                        }
                                        $shipping_str = ltrim( $shipping_str, '||' );
                                        $shipping_str = rtrim( $shipping_str, ':' );
                                        $shipping_str = ltrim( $shipping_str, ':' );
                                        $shipping_str = str_replace( '||:', '||', $shipping_str );

                                        $attr_line .= ",'" . $shipping_str . "'";
                                    }
                                } elseif ( isset( $product_data[ $attr_value['mapfrom'] ] ) ) {

                                    if ( ( $attr_value['attribute'] == 'URL' ) || ( $attr_value['attribute'] == 'g:link' ) || ( $attr_value['attribute'] == 'g:link_template' ) || ( $attr_value['attribute'] == 'g:image_link' ) || ( $attr_value['attribute'] == 'link' ) || ( $attr_value['attribute'] == 'Final URL' ) || ( $attr_value['attribute'] == 'SKU' ) || ( $attr_value['attribute'] == 'g:itemid' ) ) {
                                        if ( ( $product_data['product_type'] == 'variation' ) && ( preg_match( '/aelia_cs_currency/', $attr_value['suffix'] ) ) ) {
                                            $attr_value['suffix'] = str_replace( '?', '&', $attr_value['suffix'] );
                                            $attr_line           .= ",'" . $attr_value['prefix'] . $product_data[ $attr_value['mapfrom'] ] . $attr_value['suffix'] . "'";
                                        } elseif ( ( $product_data['product_type'] == 'variation' ) && ( preg_match( '/currency/', $attr_value['suffix'] ) ) ) {
                                            $attr_value['suffix'] = str_replace( '?', '&', $attr_value['suffix'] );
                                            $attr_line           .= ",'" . $attr_value['prefix'] . $product_data[ $attr_value['mapfrom'] ] . $attr_value['suffix'] . "'";
                                        } else {
                                            $attr_line .= ",'" . $attr_value['prefix'] . $product_data[ $attr_value['mapfrom'] ] . $attr_value['suffix'] . "'";
                                        }
                                    } elseif ( $product_data[ $attr_value['mapfrom'] ] !== '' ) {
                                        $attr_line .= ",'" . $attr_value['prefix'] . $product_data[ $attr_value['mapfrom'] ] . $attr_value['suffix'] . "'";
                                    } else {
                                        $attr_line .= ",''";
                                    }
                                } else {
                                    $attr_line .= ",''";
                                }
                            } else {
                                $attr_line .= ",''";
                            }
                        }
                        ++$loop_count;
                    }

                    $pieces_row = explode( "','", $attr_line );
                    $pieces_row = array_map( 'trim', $pieces_row );

                    // Fix the first and last elements to remove the extra quotes
                    if (!empty($pieces_row)) {
                        // Remove leading quote from first element
                        $pieces_row[0] = ltrim($pieces_row[0], "'");
                        
                        // Remove trailing quote from last element
                        $last_index = count($pieces_row) - 1;
                        $pieces_row[$last_index] = rtrim($pieces_row[$last_index], "'");
                    }

                    /**
                     * Filter to allow manipulation of CSV row data before it is written to the feed.
                     * This allows channel-specific handling of attributes in CSV format.
                     *
                     * @since 13.4.9
                     *
                     * @param array  $pieces_row            The CSV row data array
                     * @param array  $old_attributes_config The feed attributes configuration
                     * @param array  $product_data          The product data array
                     * @param object $feed                  The feed object
                     * @return array Modified CSV row data
                     */
                    $pieces_row = apply_filters( 'adt_product_feed_csv_row_data', $pieces_row, $old_attributes_config, $product_data, $feed );

                    // Identifier exists attribute for Google Shopping with Plugin Calculation Value Attribute
                    if ( $feed_channel['fields'] == 'google_shopping' ) {
                        // Identifier Attributes
                        $identifier_attributes = array( 'g:brand', 'g:gtin', 'g:mpn' );

                        $has_plugin_calculation_mapfrom = false;
                        $identifier_exists_position = -1;
                        $identifier_attributes_positions = array();
                        $loop_count = 0;
                        foreach ($old_attributes_config as $attr) {
                            if (isset($attr['attribute'])) {
                                if ( $attr['attribute'] == 'g:identifier_exists' ) {
                                    $identifier_exists_position = $loop_count;
                                }

                                if (in_array($attr['attribute'], $identifier_attributes)) {
                                    $identifier_attributes_positions[] = $loop_count;
                                }
                            }

                            if ( isset( $attr['mapfrom'] ) && $attr['mapfrom'] == 'calculated' ) {
                                $has_plugin_calculation_mapfrom = true;
                            }
                            $loop_count++;
                        }

                        // If the plugin calculation mapfrom is found,
                        // and the identifier attributes are present in the feed,
                        // and the identifier position is set, set the identifier exists to yes.
                        if ( $has_plugin_calculation_mapfrom && $identifier_exists_position != -1 ) {
                            $pieces_row[ $identifier_exists_position ] = 'no';

                            if ( ! empty( $identifier_attributes_positions ) ) {
                                foreach ( $identifier_attributes_positions as $identifier_attribute_position ) {
                                    if ( isset( $pieces_row[ $identifier_attribute_position ] ) && '' !== $pieces_row[ $identifier_attribute_position ] ) {
                                        $pieces_row[ $identifier_exists_position ] = 'yes';
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    $attr_line  = implode( "','", $pieces_row );
                    $products[] = array( $attr_line );

                    // Track preview mode product count (CSV/TXT feeds only)
                    if ( $is_preview_mode && $file_format != 'xml' && $file_format != 'jsonl' && $file_format != 'jsonl.gz' ) {
                        $preview_found_count++;
                        // Exit the inner while loop if we have enough CSV products
                        if ( $preview_found_count >= $preview_target_count ) {
                            break;
                        }
                    }
                } else {
                    $attr_line = '';
                    if ( ! empty( $tmp_attributes ) ) {
                        foreach ( array_keys( $tmp_attributes ) as $attribute_key ) {
                            if ( array_key_exists( $attribute_key, $product_data ) ) {
                                if ( ! $attr_line ) {
                                    $attr_line = "'" . $product_data[ $attribute_key ] . "'";
                                } else {
                                    $attr_line .= ",'" . $product_data[ $attribute_key ] . "'";
                                }
                            }
                        }
                    }
                    $attr_line  = trim( $attr_line, "'" );
                    $products[] = array( $attr_line );

                    // Track preview mode product count (CSV/TXT feeds only)
                    if ( $is_preview_mode && $file_format != 'xml' && $file_format != 'jsonl' && $file_format != 'jsonl.gz' ) {
                        $preview_found_count++;
                        // Exit the inner while loop if we have enough CSV products
                        if ( $preview_found_count >= $preview_target_count ) {
                            break;
                        }
                    }
                }

                /**
                 * Build an array needed for the adding Childs in the XML productfeed
                 */
                $ga = 0;
                $ca = 0;

                if ( ! empty( $tmp_attributes ) ) {
                    foreach ( array_keys( $tmp_attributes ) as $attribute_key ) {
                        /**
                         * This loop used to be used to skip the numeric keys.
                         * Which can be problematic if the attributes is a static value and it has numeric value.
                         * Because the static_value is using the $attribute_key as the key for the attribute for some fucking reason.
                         * Instead of removing the numeric keys, we now convert them to strings.
                         **/
                        if ( is_numeric( $attribute_key ) ) {
                            $attribute_key = strval( $attribute_key );
                        }

                        if ( ! isset( $old_attributes_config ) ) {
                            if ( ! $xml_product ) {
                                $xml_product = array(
                                    $attribute_key => $product_data[ $attribute_key ],
                                );
                            } elseif ( isset( $product_data[ $attribute_key ] ) ) {
                                $xml_product = array_merge( $xml_product, array( $attribute_key => $product_data[ $attribute_key ] ) );
                            }
                        } else {
                            foreach ( $old_attributes_config as $attr_key => $attr_value ) {
                                $is_attr_static = array_key_exists( 'static_value', $attr_value );
                                $attr_map_from  = $attr_value['mapfrom'] ?? '';
                                $attr_attribute = $attr_value['attribute'] ?? '';

                                // The static value is the value set by the user in the feed settings.
                                // It's stored in the mapfrom field.
                                // If the mapfrom field is empty, it means the value is not set by the user.
                                // In this case, we use the value from the product data.
                                $attr_data_value = $is_attr_static ? $attr_map_from : $product_data[ $attr_map_from ] ?? '';

                                /**
                                 * Special handling for page_url and post_url attributes.
                                 *
                                 * If the attribute is a page_url or post_url, we need to get the permalink of the page or post.
                                 * And then set the value to the xml product.
                                 */
                                if ( $attr_map_from === 'page_url' || $attr_map_from === 'post_url' ) {
                                    $post_or_page_id = $attr_value['value'] ?? '';
                                    if ( $post_or_page_id ) {
                                        $attr_data_value = get_permalink( $post_or_page_id );
                                    }
                                }

                                if ( $attr_map_from != $attribute_key ) {
                                    continue;
                                }

                                if ( ! isset( $xml_product ) ) {
                                    $xml_product = array(
                                        $attr_attribute => "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]",
                                    );
                                } else {
                                    if ( is_array( $attr_data_value ) ) {
                                        if ( $attr_map_from == 'product_tag' ) {
                                            $product_tag_str = '';

                                            foreach ( $product_data['product_tag'] as $key => $value ) {
                                                $product_tag_str .= ',';
                                                $product_tag_str .= "$value";
                                            }
                                            $product_tag_str = ltrim( $product_tag_str, ',' );
                                            $product_tag_str = rtrim( $product_tag_str, ',' );

                                            $xml_product[ $attr_attribute ] = "$product_tag_str";
                                        } elseif ( $attr_map_from == 'product_tag_space' ) {
                                            $product_tag_str_space = '';

                                            foreach ( $product_data['product_tag'] as $key => $value ) {
                                                $product_tag_str_space .= ', ';
                                                $product_tag_str_space .= "$value";
                                            }
                                            $product_tag_str_space                   = ltrim( $product_tag_str_space, ' ,' );
                                            $product_tag_str_space                   = rtrim( $product_tag_str_space, ', ' );
                                            $xml_product[ $attr_attribute ] = "$product_tag_str_space";
                                        } elseif ( $attr_map_from == 'reviews' ) {
                                            $review_str = '';

                                            foreach ( $attr_data_value as $key => $value ) {
                                                $review_str .= '||';

                                                foreach ( $value as $k => $v ) {
                                                    if ( $k == 'review_product_id' ) {
                                                        $review_str .= ":::REVIEW_PRODUCT_ID##$v";
                                                    } elseif ( $k == 'reviewer_image' ) {
                                                        $review_str .= ":::REVIEWER_IMAGE##$v";
                                                    } elseif ( $k == 'review_ratings' ) {
                                                        $review_str .= ":::REVIEW_RATINGS##$v";
                                                    } elseif ( $k == 'review_id' ) {
                                                        $review_str .= ":::REVIEW_ID##$v";
                                                    } elseif ( $k == 'reviewer_name' ) {
                                                        $review_str .= ":::REVIEWER_NAME##$v";
                                                    } elseif ( $k == 'reviewer_id' ) {
                                                        $review_str .= ":::REVIEWER_ID##$v";
                                                    } elseif ( $k == 'review_timestamp' ) {
                                                        $v           = str_replace( ' ', 'T', $v );
                                                        $v          .= 'Z';
                                                        $review_str .= ":::REVIEW_TIMESTAMP##$v";
                                                    } elseif ( $k == 'review_url' ) {
                                                        $review_str .= ":::REVIEW_URL##$v";
                                                    } elseif ( $k == 'title' ) {
                                                        $review_str .= ":::TITLE##$v";
                                                    } elseif ( $k == 'content' ) {
                                                        $review_str .= ":::CONTENT##$v";
                                                    } elseif ( $k == 'pros' ) {
                                                        $review_str .= ":::PROS##$v";
                                                    } elseif ( $k == 'cons' ) {
                                                        $review_str .= ":::CONS##$v";
                                                    } else {
                                                        // UNKNOWN, DO NOT ADD
                                                    }
                                                }
                                            }
                                            $review_str = ltrim( $review_str, '||' );
                                            $review_str = rtrim( $review_str, ':' );
                                            $review_str = ltrim( $review_str, ':' );
                                            $review_str = str_replace( '||:', '||', $review_str );

                                            $review_str .= '||';

                                            $xml_product[ $attr_attribute ] = "$review_str";
                                        } elseif ( $attr_map_from == 'shipping' ) {
                                            $shipping_str = '';
                                            foreach ( $attr_data_value as $key => $value ) {
                                                $shipping_str .= '||';

                                                foreach ( $value as $k => $v ) {
                                                    if ( $k == 'country' ) {
                                                        $shipping_str .= ':WOOSEA_COUNTRY##' . sanitize_text_field( $v );
                                                    } elseif ( $k == 'region' ) {
                                                        $shipping_str .= ':WOOSEA_REGION##' . sanitize_text_field( $v );
                                                    } elseif ( $k == 'service' ) {
                                                        $shipping_str .= ':WOOSEA_SERVICE##' . sanitize_text_field( $v );
                                                    } elseif ( $k == 'postal_code' ) {
                                                        $shipping_str .= ':WOOSEA_POSTAL_CODE##' . sanitize_text_field( $v );
                                                    } elseif ( $k == 'price' ) {
                                                        $shipping_str .= ':WOOSEA_PRICE##' . sanitize_text_field( $attr_value['prefix'] ) . sanitize_text_field( $v ) . sanitize_text_field( $attr_value['suffix'] );
                                                    } elseif ( $k == 'min_transit_time' ) {
                                                        $shipping_str .= ':WOOSEA_MIN_TRANSIT_TIME##' . sanitize_text_field( $v );
                                                    } elseif ( $k == 'max_transit_time' ) {
                                                        $shipping_str .= ':WOOSEA_MAX_TRANSIT_TIME##' . sanitize_text_field( $v );
                                                    } elseif ( $k == 'min_handling_time' ) {
                                                        $shipping_str .= ':WOOSEA_MIN_HANDLING_TIME##' . sanitize_text_field( $v );
                                                    } elseif ( $k == 'max_handling_time' ) {
                                                        $shipping_str .= ':WOOSEA_MAX_HANDLING_TIME##' . sanitize_text_field( $v );
                                                    } else {
                                                        // UNKNOWN, DO NOT ADD
                                                    }
                                                }
                                            }
                                            $shipping_str = ltrim( $shipping_str, '||' );
                                            $shipping_str = rtrim( $shipping_str, ':' );
                                            $shipping_str = ltrim( $shipping_str, ':' );
                                            $shipping_str = str_replace( '||:', '||', $shipping_str );

                                            $xml_product[ $attr_attribute ] = "$shipping_str";
                                        } elseif ( $attr_map_from == 'free_shipping_threshold' ) {
                                            if ( ! is_array( $attr_data_value ) ) {
                                                continue; // Skip malformed data
                                            }

                                            $threshold_parts = [];
                                            foreach ( $attr_data_value as $key => $value ) {
                                                $threshold_part = '';
                                                foreach ( $value as $k => $v ) {
                                                    if ( $k == 'country' ) {
                                                        $threshold_part .= ":WOOSEA_COUNTRY##$v";
                                                    } elseif ( $k == 'price_threshold' ) {
                                                        $prefix = $attr_value['prefix'] ?? '';
                                                        $suffix = $attr_value['suffix'] ?? '';
                                                        $threshold_part .= ":WOOSEA_PRICE_THRESHOLD##$prefix$v$suffix";
                                                    }
                                                }
                                                if ( !empty( $threshold_part ) ) {
                                                    $threshold_parts[] = ltrim( $threshold_part, ':' );
                                                }
                                            }
                                            $xml_product[ $attr_attribute ] = implode( '||', $threshold_parts );
                                        } else {
                                            // Array is returned and add to feed
                                            $arr_return = '';
                                            if ( isset( $attr_data_value ) && is_array( $attr_data_value ) ) {
                                                foreach ( $attr_data_value as $key => $value ) {
                                                    $arr_return .= $value . ',';
                                                }
                                            }
                                            $arr_return                              = rtrim( $arr_return, ',' );
                                            $xml_product[ $attr_attribute ] = $arr_return;
                                        }
                                    } else {
                                        ++$ga;
                                        if ( array_key_exists( $attr_attribute, $xml_product ) ) {
                                            $ca       = explode( '_', $attr_map_from );
                                            $ca_extra = end( $ca );

                                            // Google Shopping Actions, allow multiple product highlights in feed
                                            if ( ( $attr_attribute == 'g:product_highlight' ) || ( $attr_attribute == 'g:included_destination' ) ) {
                                                $xml_product[ $attr_attribute . "_$ga" ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                            } elseif ( $attr_attribute == 'g:consumer_notice' ) {
                                                $xml_product[ $attr_attribute . "_$ga" ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                            } elseif ( $attr_attribute == 'g:product_detail' ) {
                                                $xml_product[ $attr_attribute . "_$ga" ] = "$attr_value[prefix]||" . $attr_map_from . '#' . $attr_data_value . "$attr_value[suffix]";
                                            } else {
                                                $xml_product[ $attr_attribute . "_$ca_extra" ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                            }
                                        } elseif ( isset( $attr_data_value ) ) {
                                            if ( $attr_attribute == 'URL' || $attr_attribute == 'g:link' || $attr_attribute == 'link' || $attr_attribute == 'g:link_template' ) {
                                                if ( $product_data['product_type'] == 'variation' && preg_match( '/aelia_cs_currency/', $attr_value['suffix'] ) ) {
                                                    $attr_value['suffix']                    = str_replace( '?', '&', $attr_value['suffix'] );
                                                    $xml_product[ $attr_attribute ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                                } elseif ( $product_data['product_type'] == 'variation' && preg_match( '/currency/', $attr_value['suffix'] ) ) {
                                                    $attr_value['suffix']                    = str_replace( '?', '&', $attr_value['suffix'] );
                                                    $xml_product[ $attr_attribute ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                                } else {
                                                    $xml_product[ $attr_attribute ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                                }
                                            } elseif ( ( $attr_attribute == 'g:image_link' || str_contains( $attr_attribute, 'g:additional_image_link' ) || $attr_attribute == 'image_link' ) && $attr_data_value !== '' ) {
                                                $xml_product[ $attr_attribute ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                            } elseif ( ( $attr_attribute == 'g:id' || $attr_attribute == 'id' || $attr_attribute == 'g:itemid' ) && $attr_data_value !== '' ) {
                                                $xml_product[ $attr_attribute ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                            } elseif ( $attr_attribute == 'g:item_group_id' && $attr_data_value !== '' ) {
                                                $xml_product[ $attr_attribute ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                            } elseif ( $attr_attribute == 'g:consumer_notice' && $attr_data_value !== '' ) {
                                                $xml_product[ $attr_attribute ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                            } elseif ( $attr_attribute == 'g:product_detail' && $attr_data_value !== '' ) {
                                                $xml_product[ $attr_attribute ] = "$attr_value[prefix]||" . $attr_map_from . '#' . $attr_data_value . "$attr_value[suffix]";
                                            } elseif ( ( $attr_attribute == 'g:product_highlight' || $attr_attribute == 'g:included_destination' ) && $attr_data_value !== '' ) {
                                                $xml_product[ $attr_attribute . "_$ga" ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                            } elseif ( $attr_data_value !== '' ) {
                                                $xml_product[ $attr_attribute ] = "$attr_value[prefix]" . $attr_data_value . "$attr_value[suffix]";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // Do we need to do some calculation on attributes for Google Shopping
                $xml_product = $this->woosea_calculate_value( $feed, $xml_product );

                foreach ( $xml_product as $key_product => $value_product ) {
                    if ( preg_match( '/custom_attributes_attribute_/', $key_product ) ) {
                        $pieces = explode( 'custom_attributes_attribute_', $key_product );
                        unset( $xml_product[ $key_product ] );
                        $xml_product[ $pieces[1] ] = $value_product;
                    } elseif ( preg_match( '/product_attributes_/', $key_product ) ) {
                        $pieces = explode( 'product_attributes_', $key_product );
                        unset( $xml_product[ $key_product ] );
                        $xml_product[ $pieces[1] ] = $value_product;
                    }
                }

                // For Skroutz template
                if ( $feed_channel['fields'] == 'skroutz' ) {
                    if ( $product->get_type() == 'variation' ) {
                        $product_id = $product->get_parent_id();
                        $xml_piece[ $product_id ]['skroutz_variations'][] = $xml_product;
                    } else {
                        $xml_piece[ $product->get_id() ] = $xml_product;
                    }
                } else {
                    // For JSONL formats, allow channel-specific product-level transformations
                    // (e.g. shipping parsing and HTML entity decoding for OpenAI).
                    if ( $file_format === 'jsonl' || $file_format === 'jsonl.gz' ) {
                        /**
                         * Filter a single JSONL product array before it is added to the batch.
                         *
                         * @since 13.5.2
                         *
                         * @param array  $xml_product  The product data key/value array.
                         * @param array  $feed_channel The active channel configuration.
                         * @param object $feed         The feed object.
                         */
                        $xml_product = apply_filters( 'adt_product_feed_jsonl_product', $xml_product, $feed_channel, $feed );
                    }
                    $xml_piece[] = $xml_product;
                }

                // Track preview mode product count (XML/JSONL feeds only)
                if ( $is_preview_mode && ( $file_format == 'xml' || $file_format == 'jsonl' || $file_format == 'jsonl.gz' ) ) {
                    $preview_found_count++;
                    // Exit the inner while loop if we have enough products
                    if ( $preview_found_count >= $preview_target_count ) {
                        break;
                    }
                }

                unset( $xml_product );
                unset( $product_data );
            }
        endwhile;

        // Store post count before resetting query
        $last_query_post_count = $prods->post_count;

        wp_reset_query();
        wp_reset_postdata();

            // Preview mode: Check if we need to query more products
            if ( $is_preview_mode ) {
                // Update offset for next query
                $preview_query_offset += $preview_batch_size;

                // Continue querying if:
                // 1. We haven't found enough products yet
                // 2. We haven't exceeded max queries
                // 3. The last query returned results (not exhausted all products)
                $should_continue = (
                    $preview_found_count < $preview_target_count &&
                    $preview_query_count < $preview_max_queries &&
                    $last_query_post_count > 0
                );
            } else {
                $should_continue = false;
            }
        } while ( $should_continue );

        // Add processed products to array
        // if(get_option('woosea_duplicates')){
        // update_option($channel_duplicates, $prevent_duplicates, 'no');
        // }

        /**
         * Write row to CSV/TXT or XML or JSONL file
         */
        if ( ( $file_format == 'jsonl' || $file_format == 'jsonl.gz' ) && is_array( $xml_piece ) && ! empty( $xml_piece ) ) {
            $jsonl_writer = \AdTribes\PFP\Classes\Feed_Writers\Feed_Writer_JSONL::instance();
            $file         = $jsonl_writer->write_feed( array_filter( $xml_piece ), $feed, false );
            unset( $xml_piece );
        } elseif ( $file_format != 'xml' && is_array( $products ) && ! empty( $products ) ) {
            $file = $this->woosea_create_csvtxt_feed( array_filter( $products ), $feed, 'false' );
        } else {
            if ( is_array( $xml_piece ) ) {
                $file = $this->woosea_create_xml_feed( array_filter( $xml_piece ), $feed, 'false' );
                unset( $xml_piece );
            }
            unset( $products );
        }

        $feed->save();

        /**
         * Ready creating file, clean up our feed configuration mess now
         */
        delete_option( 'attributes_dropdown' );
        delete_option( 'channel_attributes' );
    }

    /**
     * Calculate the value of an attribute
     */
    public function woosea_calculate_value( $feed, $xml_product ) {
        $feed_channel    = $feed->channel;
        $feed_attributes = $feed->attributes;

        /**
         * Filter the feed attributes before processing.
         *
         * @since 13.5.0
         * @param array $feed_attributes The feed attributes array.
         * @return array
         */
        $feed_attributes = apply_filters( 'adt_feed_get_attributes', $feed_attributes );

        if ( empty( $feed_channel ) || empty( $feed_attributes ) ) {
            return $xml_product;
        }

        // trim whitespaces from attribute values
        $xml_product = array_map( 'trim', $xml_product );

        // Check for new products in the Google Shopping feed if we need to 'calculate' the identifier_exists attribute value
        if ( ( $feed_channel['taxonomy'] == 'google_shopping' ) && ( isset( $xml_product['g:condition'] ) ) && ( ! isset( $xml_product['g:identifier_exists'] ) ) ) {
            $identifier_exists = 'no'; // default value is no

            // Per Google's requirements, we only need identifier_exists if the product is new
            if ( strtolower($xml_product['g:condition']) == 'new' ) {
                if ( array_key_exists( 'g:brand', $xml_product ) && ( $xml_product['g:brand'] != '' ) ) {
                    // g:gtin exists and has a value
                    if ( ( array_key_exists( 'g:gtin', $xml_product ) ) && ( $xml_product['g:gtin'] != '' ) ) {
                        $identifier_exists = 'yes';
                    // g:mpn exists and has a value
                    } elseif ( ( array_key_exists( 'g:mpn', $xml_product ) ) && ( $xml_product['g:mpn'] != '' ) ) {
                        $identifier_exists = 'yes';
                    // g:brand exists but no gtin or mpn
                    } else {
                        $identifier_exists = 'no';
                    }
                } else {
                    // No brand, so identifier_exists should be 'no'
                    $identifier_exists = 'no';
                }
            }

            // Check if the feed attributes include the calculated attribute for identifier_exists
            $has_calculated_attribute = false;
            foreach ($feed_attributes as $attr) {
                if (isset($attr['mapfrom']) && $attr['mapfrom'] === 'calculated' && 
                    isset($attr['attribute']) && $attr['attribute'] === 'g:identifier_exists') {
                    $has_calculated_attribute = true;
                    break;
                }
            }
            
            // Only add identifier_exists to the feed if it's configured in the feed attributes
            if ($has_calculated_attribute) {
                $xml_product['g:identifier_exists'] = $identifier_exists;
            }
        }

        if ( $feed_channel['name'] == 'Mall.sk' ) {
            $has_calculated_attribute = false;
            foreach ($feed_attributes as $attr) {
                if (isset($attr['mapfrom']) && $attr['mapfrom'] === 'calculated') {
                    $has_calculated_attribute = true;
                    break;
                }
            }
            
            if ($has_calculated_attribute) {
                $xml_product['VARIABLE_PARAMS'] = 'calculated';
            }
        }
        return $xml_product;
    }

    /**
     * Make start and end sale date readable
     */
    public function get_sale_date( $id, $name ) {
        $date = $this->get_attribute_value( $id, $name );
        if ( $date ) {
            if ( is_int( $date ) ) {
                return date( 'Y-m-d', $date );
            }
        }
        return false;
    }

    /**
     * Get product stock
     */
    public function get_stock( $id ) {
        $status = $this->get_attribute_value( $id, '_stock_status' );
        if ( $status ) {
            if ( $status == 'instock' ) {
                return 'in stock';
            } elseif ( $status == 'outofstock' ) {
                return 'out of stock';
            }
        }
        return 'out of stock';
    }

    /**
     * Create proper format image URL's
     */
    public function get_image_url( $image_url = '' ) {
        if ( ! empty( $image_url ) ) {
            if ( substr( trim( $image_url ), 0, 4 ) === 'http' || substr( trim( $image_url ), 0, 5 ) === 'https' || substr( trim( $image_url ), 0, 3 ) === 'ftp' || substr( trim( $image_url ), 0, 4 ) === 'sftp' ) {
                return rtrim( $image_url, '/' );
            } else {
                $base      = get_site_url();
                $image_url = $base . $image_url;
                return rtrim( $image_url, '/' );
            }
        }
        return $image_url;
    }

    /**
     * Get attribute value
     */
    public function get_attribute_value( $id, $name ) {
        if ( strpos( $name, 'attribute_pa' ) !== false ) {
            $taxonomy = str_replace( 'attribute_', '', $name );
            $meta     = get_post_meta( $id, $name, true );
            $term     = get_term_by( 'slug', $meta, $taxonomy );
            return $term->name;
        } else {
            return get_post_meta( $id, $name, true );
        }
    }

    /**
     * Execute category taxonomy mappings
     */
    private function woocommerce_sea_mappings( $project_mappings, $product_data ) {
        $original_cat = $product_data['categories'];
        $original_cat = preg_replace( '/&amp;/', '&', $original_cat );
        $original_cat = preg_replace( '/&gt;/', '>', $original_cat );
        $original_cat = ltrim( $original_cat, '||' );

        $tmp_cat = '';
        $match   = 'false';

        foreach ( $project_mappings as $pm_key => $pm_array ) {
            // Strip slashes
            $pm_array['criteria'] = str_replace( '\\', '', $pm_array['criteria'] );
            $pm_array['criteria'] = str_replace( '/', '', $pm_array['criteria'] );
            $pm_array['criteria'] = trim( $pm_array['criteria'] );
            $original_cat         = str_replace( '\\', '', $original_cat );
            $original_cat         = str_replace( '/', '', $original_cat );
            $original_cat         = trim( $original_cat );

            // First check if there is a category mapping for this specific product
            if ( ( preg_match( '/' . $pm_array['criteria'] . '/', $original_cat ) ) ) {
                if ( ! empty( $pm_array['map_to_category'] ) ) {
                    $prod_id_cat = $product_data['id'];
                    if ( $product_data['product_type'] == 'variation' ) {
                        $prod_id_cat = $product_data['item_group_id'];
                    }

                    $product_cats_ids = wc_get_product_term_ids( $prod_id_cat, 'product_cat' );
                    if ( in_array( $pm_array['categoryId'], $product_cats_ids ) ) {
                        $category_pieces = explode( '-', $pm_array['map_to_category'] );
                        $tmp_cat         = $category_pieces[0];
                        $match           = 'true';
                    }
                }
            } elseif ( $pm_array['criteria'] == $original_cat ) {
                $category_pieces = explode( '-', $pm_array['map_to_category'] );
                $tmp_cat         = $category_pieces[0];
                $match           = 'true';
            } else {
                // Do nothing
            }
        }

        if ( $match == 'true' ) {
            if ( array_key_exists( 'id', $product_data ) ) {
                $product_data['categories'] = $tmp_cat;
            }
        } else {
            // No mapping found so make google_product_category empty
            $product_data['categories'] = '';
        }

        return $product_data;
    }

    /**
     * Function to exclude products based on individual product exclusions
     */
    private function woosea_exclude_individual( $product_data ) {
        $allowed = 1;

        // Check if product was already excluded from the feed
        $product_excluded = ucfirst( get_post_meta( $product_data['id'], '_woosea_exclude_product', true ) );

        if ( $product_excluded == 'Yes' ) {
            $allowed = 0;
        }

        if ( $allowed < 1 ) {
            $product_data = array();
            $product_data = null;
        } else {
            return $product_data;
        }
    }

    /**
     * Do analysis of product data for Google Shopping
     */
    private function woosea_gs_analysis( $project, $product_data ) {
        $gs_analysis_check                              = array();
        $gs_analysis_check['project_hash']              = $project['project_hash'];
        $gs_analysis_check['project_hash']['timestamp'] = 'llqlql';

        // Check title criteria
        $length_title = strlen( $product_data['title'] );
        $gs_analysis_check['project_hash'][ $product_data['id'] ]['title']['length']           = $length_title;
        $gs_analysis_check['project_hash'][ $product_data['id'] ]['title']['more_information'] = 'https://support.google.com/merchants/answer/6324415';

        if ( $length_title > 150 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['title']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['title']['notification'] = "Your title / product name is too long ($length_title characters), it has been truncated to 150 characters in order to meet Google's criteria.";
        } elseif ( $length_title < 64 and $length_title > 0 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['title']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['title']['notification'] = "Your title / product name is too short ($length_title characters), make sure it is over 64 characters long. Best practice is to use all 150 characters. Include the important details that define your product.";
        } elseif ( $length_title < 1 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['title']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['title']['notification'] = 'Your title / product name is empty, make sure it is over 64 characters long. Best practice is to use all 150 characters. Include the important details that define your product.';
        } else {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['title']['passed_check'] = 'yes';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['title']['notification'] = 'The length of your title / product name is perfect, well done!';
        }

        // Check description criteria
        $length_description = strlen( $product_data['description'] );
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['length']           = $length_description;
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['more_information'] = 'https://support.google.com/merchants/answer/6324468';

        if ( $length_description > 5000 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['notification'] = "Your product description is too long ($length_description characters), make sure your product description is no longer than 5000 characters.";
        } elseif ( $length_description < 160 and $length_description > 0 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['notification'] = "Your product description is too short ($length_description characters), make sure to list the most important details in the first 160 - 500 characters.";
        } elseif ( $length_description < 1 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['notification'] = 'Your product description is empty, make sure to list the most important details in the first 160 - 500 characters.';
        } else {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['passed_check'] = 'yes';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['description']['notification'] = 'The length of your title / product name is perfect, well done!';
        }

        // Check availability
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['availability']['more_information'] = 'https://support.google.com/merchants/answer/6324448';
        $availability_allowed = array( 'in_stock', 'out_of_stock', 'preorder', 'backorder' );
        $availability         = $product_data['availability'];

        if ( ! in_array( $product_data['availability'], $availability_allowed ) ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['availability']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['availability']['notification'] = "Your availability value ($availability) does not meet Google's requirements (make sure the value is in_stock, out_of_stock, preorder or backorder).";
        } else {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['availability']['passed_check'] = 'yes';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['availability']['notification'] = "Your availability value ($availability) meets Google's requirements, well done!";
        }

        // Check link
        $length_link = strlen( $product_data['link'] );
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['length']           = $length_link;
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['more_information'] = 'https://support.google.com/merchants/answer/6324416';
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['passed_check']     = 'yes';
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['notification']     = "Your product link (URL) meets Google's requirements.";

        if ( $length_link > 2000 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['notification'] = "Your product link (URL) is too long ($length_link characters), make sure the product link (URL) is no longer than 2000 characters.";
        } elseif ( $length_link < 1 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['notification'] = 'Your product link (URL) is empty.';
        } else {
        }

        if ( ! filter_var( $product_data['link'], FILTER_VALIDATE_URL ) !== false ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['notification'] = "Your product link (URL) doesn't appear to be a valid URL.";
        }

        $url            = parse_url( $product_data['link'] );
        $allowed_schema = array( 'http', 'https' );
        if ( ! in_array( $url['scheme'], $allowed_schema ) ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['link']['notification'] = "Your product link (URL) doesn't http or https, which is required by Google.";
        }

        // Check price
        $length_price  = strlen( $product_data['price'] );
        $product_price = $product_data['price'];
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['length']           = $length_price;
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['more_information'] = 'https://support.google.com/merchants/answer/6324371';
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['passed_check']     = 'yes';
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['notification']     = "Your product price ($product_price) meets Google's requirements.";

        if ( $length_price < 1 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['notification'] = 'Your product price is empty, make sure to add a price to all your products.';
        }

        $separator = wc_get_price_decimal_separator();
        if ( $separator == '.' ) {
            if ( ! is_numeric( $product_data['price'] ) ) {

                $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['passed_check'] = 'no';
                $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['notification'] = "Your product price ($product_price) doesn't appear to be a valid price.";
            }
        }

        if ( empty( $product_data['price'] ) ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['notification'] = "Your product price ($product_price) doesn't appear to be a valid price, it cannot be empty of 0 (zero)";
        }

        if ( $product_data['price'] == '0,00' ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['price']['notification'] = "Your product price ($product_price) doesn't appear to be a valid price, it cannot be empty of 0 (zero)";
        }

        // Product type
        $length_product_type = strlen( $product_data['product_type'] );
        $product_type        = $product_data['product_type'];
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['product_type']['length']           = $length_price;
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['product_type']['more_information'] = 'https://support.google.com/merchants/answer/6324406';
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['product_type']['passed_check']     = 'yes';
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['product_type']['notification']     = "Your product type meets Google's requirements.";

        if ( $length_product_type > 750 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['product_type']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['product_type']['notification'] = 'Your product type value is too long, make sure it is no longer than 750 characters.';
        } elseif ( $length_product_type < 1 ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['product_type']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['product_type']['notification'] = 'Your product type field is empty.';
        } else {
        }

        // Condition
        $gs_analysis_check[ $product_data['project_hash']['id'] ]['condition']['more_information'] = 'https://support.google.com/merchants/answer/6324469';
        $condition_allowed = array( 'new', 'refurbished', 'used', 'New', 'Refurbished', 'Used' );
        $condition         = $product_data['condition'];

        if ( ! in_array( $product_data['condition'], $condition_allowed ) ) {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['condition']['passed_check'] = 'no';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['condition']['notification'] = "Your condition value ($condition) does not meet Google's requirements (make sure the value is new, refurbished or used).";
        } else {
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['condition']['passed_check'] = 'yes';
            $gs_analysis_check[ $product_data['project_hash']['id'] ]['condition']['notification'] = "Your condition value ($condition) meets Google's requirements, well done!";
        }

        // Save Google Shopping analysis results
        update_option( 'woosea_gs_analysis_results', $gs_analysis_check, false );
    }


    /**
     * Get comma separated categories
     *
     * @param array $category_ids The category IDs.
     * @return string The comma separated categories.
     */
    private function get_comma_separated_categories( $category_ids ) {
        $categories_comma_separated = array();
        
        // Build category hierarchy map
        $categories_by_parent = array();
        $all_categories = array();
        
        foreach ( $category_ids as $category_id ) {
            $category = get_term( $category_id, 'product_cat' );
            
            if ( ! is_wp_error( $category ) ) {
                $all_categories[ $category_id ] = $category;
                $parent_id = $category->parent;
                
                if ( ! isset( $categories_by_parent[ $parent_id ] ) ) {
                    $categories_by_parent[ $parent_id ] = array();
                }
                $categories_by_parent[ $parent_id ][] = $category_id;
            }
        }
        
        // Recursive function to add categories in hierarchical order
        $add_categories_hierarchically = function( $parent_id, $categories_by_parent, $all_categories, &$result ) use ( &$add_categories_hierarchically ) {
            if ( ! isset( $categories_by_parent[ $parent_id ] ) ) {
                return;
            }
            
            foreach ( $categories_by_parent[ $parent_id ] as $category_id ) {
                if ( isset( $all_categories[ $category_id ] ) ) {
                    $result[] = $all_categories[ $category_id ]->name;
                    // Recursively add children of this category
                    $add_categories_hierarchically( $category_id, $categories_by_parent, $all_categories, $result );
                }
            }
        };
        
        // Start with root categories (parent = 0) and build hierarchically
        $add_categories_hierarchically( 0, $categories_by_parent, $all_categories, $categories_comma_separated );

        return implode( ',', $categories_comma_separated );
    }

}
