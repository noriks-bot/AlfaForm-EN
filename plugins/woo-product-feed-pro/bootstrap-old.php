<?php // phpcs:disable

use AdTribes\PFP\Helpers\Helper;

/**
 * Get category path for Facebook pixel.
 *
 * @param int    $id The term ID.
 * @param string $taxonomy The taxonomy.
 * @param string $project_taxonomy The project taxonomy.
 * @param bool   $link Whether to link the category.
 * @param bool   $nicename Whether to use the category nicename.
 * @param array  $visited The visited categories.
 *
 * @return string The category path.
 */
function woosea_get_term_parents( $id, $taxonomy, $project_taxonomy, $link = false, $nicename = false, $visited = array() ) {
    // Only add Home to the beginning of the chain when we start buildin the chain.
        if ( empty( $visited ) ) {
            $chain = 'Home';
        } else {
            $chain = '';
        }

    $parent        = get_term( $id, $taxonomy );
        $separator = ' > ';

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
                    $chain    .= woosea_get_term_parents( $parent->parent, $taxonomy, $separator, $link = false, $nicename, $visited );
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
 * Add Facebook pixel.
 *
 * @param object $product The product object.
 */
function woosea_add_facebook_pixel( $product = null ) {
    // Check if WooCommerce is loaded and available
    if ( ! class_exists( 'WooCommerce' ) ) {  
        return;  
    }  

    if ( ! is_object( $product ) ) {
        $post_id = apply_filters( 'adt_facebook_pixel_post_id', get_the_ID() );
        $product = function_exists( 'wc_get_product' ) ? wc_get_product( $post_id ) : null;  
    }  
    
    if ( ! $product instanceof WC_Product ) {  
        return;  
    }

    $add_facebook_pixel = get_option( 'adt_add_facebook_pixel' );
    $add_facebook_capi  = get_option( 'add_facebook_capi' );

    if ( $add_facebook_pixel == 'yes' ) {
        $fb_pagetype           = WooSEA_Google_Remarketing::woosea_google_remarketing_pagetype();
        $viewContent           = '';
        $event_id              = uniqid( rand(), true );
        $currency              = get_woocommerce_currency();
        $facebook_pixel_id = get_option( 'adt_facebook_pixel_id' );
        $facebook_capi_token   = get_option( 'adt_facebook_capi_token' );

        // Add vulnerability check.
        if ( ! is_numeric( $facebook_pixel_id ) ) {
            unset( $facebook_pixel_id );
        }

        if ( isset( $facebook_pixel_id ) && ( $facebook_pixel_id > 0 ) ) {
            // Set Facebook conversion API data.
            define( 'FACEBOOK_APP_ACCESS_TOKEN', $facebook_capi_token );
            define( 'FACEBOOK_PIXEL_OFFLINE_EVENT_SET_ID', $facebook_pixel_id );
            $fb_capi_data['match_keys']                     = array();
            $fb_capi_data['event_time']                     = time();
            $fb_capi_data['event_id']                       = $event_id;
            $fb_capi_data['user_data']['client_ip_address'] = WC_Geolocation::get_ip_address();
            if ( ! isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
                $_SERVER['HTTP_USER_AGENT'] = 'Unknown';
            }
            $fb_capi_data['user_data']['client_user_agent'] = sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] );
            $fb_capi_data['action_source']                  = 'website';
            $fb_capi_data['event_source_url']               = sanitize_text_field( home_url( $_SERVER['REQUEST_URI'] ) );

            if ( $fb_pagetype == 'product' ) {
                if ( ! empty( $product->get_price() ) ) {
                    $fb_prodid    = get_the_id();
                    $product_name = $product->get_name();
                    $product_name = str_replace( '"', '', $product_name );
                    $product_name = str_replace( "'", '', $product_name );

                    $cats     = '';
                    $all_cats = get_the_terms( $fb_prodid, 'product_cat' );
                    if ( ! empty( $all_cats ) ) {
                            foreach ( $all_cats as $key => $category ) {
                            $cats .= $category->name . ',';
                        }
                    }
                    // strip last comma.
                    $cats = rtrim( $cats, ',' );
                    $cats = str_replace( '&amp;', '&', $cats );
                    $cats = str_replace( '"', '', $cats );
                    $cats = str_replace( "'", '', $cats );

                    if ( ! empty( $fb_prodid ) ) {
                                            if ( ! $product ) {
                                                    return -1;
                                            }

                        if ( $product->is_type( 'variable' ) ) {
                            // We should first check if there are any _GET parameters available.
                            // When there are not we are on a variable product page but not on a specific variable one.
                            // In that case we need to put in the AggregateOffer structured data.
                            $variation_id = woosea_find_matching_product_variation( $product, sanitize_text_field( $_GET ) );

                            $nr_get = count( $_GET );

                            // This is a variant product.
                            if ( ( $nr_get > 0 ) && ( $variation_id > 0 ) ) {
                                $variable_product = wc_get_product( $variation_id );
                                // for variants use the variation_id and not the item_group_id.
                                // otherwise Google will disapprove the items due to itemID mismatches.
                                $fb_prodid = $variation_id;

                                if ( is_object( $variable_product ) ) {
                                    $product_price = $variable_product->get_price();
                                    $fb_price      = $product_price;
                                } else {
                                    // AggregateOffer.
                                            $prices      = $product->get_variation_prices();
                                                $lowest  = reset( $prices['price'] );
                                                $highest = end( $prices['price'] );

                                                if ( $lowest === $highest ) {
                                                        $fb_price = wc_format_localized_price( $lowest );
                                                    } else {
                                                        $fb_lowprice  = wc_format_localized_price( $lowest );
                                                        $fb_highprice = wc_format_localized_price( $highest );
                                        $fb_price                     = $fb_lowprice;
                                    }
                                }
                                $fb_price    = floatval( str_replace( ',', '.', str_replace( ',', '.', $fb_price ) ) );
                                $viewContent = "fbq(\"track\",\"ViewContent\",{content_category:\"$cats\", content_name:\"$product_name\", content_type:\"product\", content_ids:[\"$fb_prodid\"], value:\"$fb_price\", currency:\"$currency\"},{eventID:\"$event_id\"});";

                                // Facebook CAPI data.
                                $fb_capi_data['event_name']                      = 'ViewContent';
                                $fb_capi_data['custom_data']['content_ids']      = $fb_prodid;
                                $fb_capi_data['custom_data']['content_name']     = $product_name;
                                $fb_capi_data['custom_data']['content_category'] = $cats;
                                $fb_capi_data['custom_data']['currency']         = $currency;
                                $fb_capi_data['custom_data']['value']            = $fb_price;
                                $fb_capi_data['custom_data']['content_type']     = 'product';
                            } else {
                                // This is a parent variable product.
                                // Since these are not allowed in the feed, at the variations product ID's.
                                // Get children product variation IDs in an array.
                                $woosea_content_ids = 'variation';
                                $woosea_content_ids = get_option( 'adt_facebook_pixel_content_ids' );

                                if ( $woosea_content_ids == 'variation' ) {
                                    $children_ids = $product->get_children();
                                    $content      = '';
                                    foreach ( $children_ids as $id ) {
                                        $content .= '\'' . $id . '\',';
                                    }
                                } else {
                                    $content = '\'' . $fb_prodid . '\'';
                                }

                                $content = rtrim( $content, ',' );
                                $prices  = $product->get_variation_prices();
                                $lowest  = reset( $prices['price'] );
                                $highest = end( $prices['price'] );

                                if ( $lowest === $highest ) {
                                    $fb_price = wc_format_localized_price( $lowest );
                                } else {
                                    $fb_lowprice  = wc_format_localized_price( $lowest );
                                    $fb_highprice = wc_format_localized_price( $highest );
                                    $fb_price     = $fb_lowprice;
                                }
                                $fb_price    = floatval( str_replace( ',', '.', str_replace( ',', '.', $fb_price ) ) );
                                $viewContent = "fbq(\"track\",\"ViewContent\",{content_category:\"$cats\", content_name:\"$product_name\", content_type:\"product_group\", content_ids:[$content], value:\"$fb_price\", currency:\"$currency\"},{eventID:\"$event_id\"});";

                                // Facebook CAPI data.
                                $fb_capi_data['event_name']                      = 'ViewContent';
                                $fb_capi_data['custom_data']['content_ids']      = $fb_prodid;
                                $fb_capi_data['custom_data']['content_name']     = $product_name;
                                $fb_capi_data['custom_data']['content_category'] = $cats;
                                $fb_capi_data['custom_data']['currency']         = $currency;
                                $fb_capi_data['custom_data']['value']            = $fb_price;
                                $fb_capi_data['custom_data']['content_type']     = 'product_group';
                            }
                        } else {
                            // This is a simple product page.
                            $fb_price    = wc_format_localized_price( $product->get_price() );
                            $fb_price    = floatval( str_replace( ',', '.', str_replace( ',', '.', $fb_price ) ) );
                            $viewContent = "fbq(\"track\",\"ViewContent\",{content_category:\"$cats\", content_name:\"$product_name\", content_type:\"product\", content_ids:[\"$fb_prodid\"], value:\"$fb_price\", currency:\"$currency\"},{eventID:\"$event_id\"});";

                            // Facebook CAPI data.
                            $fb_capi_data['event_name']                      = 'ViewContent';
                            $fb_capi_data['custom_data']['content_ids']      = $fb_prodid;
                            $fb_capi_data['custom_data']['content_name']     = $product_name;
                            $fb_capi_data['custom_data']['content_category'] = $cats;
                            $fb_capi_data['custom_data']['currency']         = $currency;
                            $fb_capi_data['custom_data']['value']            = $fb_price;
                            $fb_capi_data['custom_data']['content_type']     = 'product';
                        }
                    }
                }
            } elseif ( $fb_pagetype == 'cart' ) {
                // This is on the order thank you page.
                if ( isset( $_GET['key'] ) && is_wc_endpoint_url( 'order-received' ) ) {
                            $order_string = sanitize_text_field( $_GET['key'] );
                    if ( ! empty( $order_string ) ) {
                        $order_id    = wc_get_order_id_by_order_key( $order_string );
                        $order       = wc_get_order( $order_id );
                        $order_items = $order->get_items();
                        $currency    = get_woocommerce_currency();
                        $contents    = '';
                        $order_real  = wc_format_localized_price( $order->get_total() );

                        if ( ! is_wp_error( $order_items ) ) {
                            foreach ( $order_items as $item_id => $order_item ) {
                                $prod_id      = $order_item->get_product_id();
                                $variation_id = $order_item->get_variation_id();
                                if ( $variation_id > 0 ) {
                                    $prod_id = $variation_id;
                                }
                                $prod_quantity = $order_item->get_quantity();
                                $contents     .= "{'id': '$prod_id', 'quantity': $prod_quantity},";
                            }
                        }
                        $contents    = rtrim( $contents, ',' );
                        $order_real  = floatval( str_replace( ',', '.', str_replace( ',', '.', $order_real ) ) );
                        $viewContent = "fbq('track','Purchase',{currency:'$currency', value:'$order_real', content_type:'product', contents:[$contents]},{eventID:\"$event_id\"});";

                        // Facebook CAPI data.
                        $fb_capi_data['event_name']                  = 'Purchase';
                        $fb_capi_data['custom_data']['content_ids']  = $prod_id;
                        $fb_capi_data['custom_data']['currency']     = $currency;
                        $fb_capi_data['custom_data']['value']        = $order_real;
                        $fb_capi_data['custom_data']['content_type'] = 'product';
                    }
                } else {
                    // This is on the cart page itself.
                    $currency      = get_woocommerce_currency();
                    $cart_items    = WC()->cart->get_cart();
                    $cart_quantity = count( $cart_items );

                    $cart_real = 0;
                    $contents  = '';

                    $cart_total_amount = wc_format_localized_price( WC()->cart->get_cart_contents_total() );
                    $cart_total_amount = floatval( str_replace( ',', '.', str_replace( ',', '.', $cart_total_amount ) ) );

                    $checkoutpage = wc_get_checkout_url();
                    $current_url  = get_permalink( get_the_ID() );

                    if ( ! empty( $cart_items ) ) {
                        if ( ! is_wp_error( $cart_items ) ) {
                            foreach ( $cart_items as $cart_id => $cart_item ) {
                                $prod_id      = $cart_item['product_id'];
                                $product      = $cart_item['data'];
                                $product_name = $product->get_name();
                                if ( $cart_item['variation_id'] > 0 ) {
                                    $prod_id = $cart_item['variation_id'];
                                }
                                $contents .= '\'' . $prod_id . '\',';

                                $cart_real = wc_format_localized_price( $cart_item['line_total'] );
                            }
                            $contents = rtrim( $contents, ',' );

                            // User is on the billing pages.
                            if ( $checkoutpage == $current_url ) {
                                $viewContent = "fbq(\"track\",\"InitiateCheckout\",{currency:\"$currency\", value:\"$cart_total_amount\", content_type:\"product\", content_ids:[$contents]},{eventID:\"$event_id\"});";

                                // Facebook CAPI data.
                                $fb_capi_data['event_name']                  = 'InitiateCheckout';
                                $fb_capi_data['custom_data']['content_ids']  = $contents;
                                $fb_capi_data['custom_data']['content_name'] = $product_name;
                                $fb_capi_data['custom_data']['currency']     = $currency;
                                $fb_capi_data['custom_data']['value']        = $cart_total_amount;
                                $fb_capi_data['custom_data']['content_type'] = 'product';
                            } else {
                                // User is on the basket page.
                                $viewContent = "fbq(\"track\",\"AddToCart\",{currency:\"$currency\", value:\"$cart_total_amount\", content_type:\"product\", content_ids:[$contents]},{eventID:\"$event_id\"});";

                                // Facebook CAPI data.
                                $fb_capi_data['event_name']                  = 'AddToCart';
                                $fb_capi_data['custom_data']['content_ids']  = $contents;
                                $fb_capi_data['custom_data']['content_name'] = $product_name;
                                $fb_capi_data['custom_data']['currency']     = $currency;
                                $fb_capi_data['custom_data']['value']        = $cart_total_amount;
                                $fb_capi_data['custom_data']['content_type'] = 'product';
                            }
                        }
                    }
                }
            } elseif ( $fb_pagetype == 'category' ) {
                $term = get_queried_object();

                global $wp_query;
                $ids       = wp_list_pluck( $wp_query->posts, 'ID' );
                $fb_prodid = '';

                foreach ( $ids as $id ) {
                    $_product = wc_get_product( $id );
                    if ( ! $_product ) {
                        return -1;
                    }

                    if ( $_product->is_type( 'simple' ) ) {
                        // Add the simple product ID.
                        $fb_prodid .= '\'' . $id . '\',';
                    } else {
                        // This is a variable product, add variation product ID's.
                        $children_ids = $_product->get_children();
                                        foreach ( $children_ids as $id ) {

                        $fb_prodid     .= '\'' . $id . '\',';
                            $fb_prodid .= '\'' . $id . '\',';
                                        }
                    }
                }
                        $fb_prodid             = rtrim( $fb_prodid, ',' );
                $category_name                 = $term->name;
                                $category_path = woosea_get_term_parents( $term->term_id, 'product_cat', $project_taxonomy = false, $link = false, $nicename = false, $visited = array() );
                $viewContent                   = "fbq(\"track\",\"ViewCategory\",{content_category:'$category_path', content_name:'$category_name', content_type:\"product\", content_ids:\"[$fb_prodid]\"},{eventID:\"$event_id\"});";

                // Facebook CAPI data.
                $fb_capi_data['event_name']                  = 'ViewCategory';
                $fb_capi_data['custom_data']['content_ids']  = $ids;
                $fb_capi_data['custom_data']['content_type'] = 'product';

        } elseif ( $fb_pagetype == 'searchresults' ) {
            $term          = get_queried_object();
            $search_string = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

            global $wp_query;
            $ids       = wp_list_pluck( $wp_query->posts, 'ID' );
            $fb_prodid = '';

            foreach ( $ids as $id ) {
                $_product = wc_get_product( $id );
                if ( ! $_product ) {
                    return -1;
                }

                $ptype = $_product->get_type();
                if ( $ptype == 'simple' ) {
                    // Add the simple product ID.
                    $fb_prodid .= '\'' . $id . '\',';
                } else {
                    // This is a variable product, add variation product ID's.
                    $children_ids = $_product->get_children();
                    foreach ( $children_ids as $id ) {
                        $fb_prodid .= '\'' . $id . '\',';
                    }
                }
            }

            $fb_prodid = rtrim( $fb_prodid, ',' );
            $viewContent       = "fbq(\"trackCustom\",\"Search\",{search_string:\"$search_string\", content_type:\"product\", content_ids:\"[$fb_prodid]\"},{eventID:\"$event_id\"});";

            // Facebook CAPI data.
            $fb_capi_data['event_name']                  = 'Search';
            $fb_capi_data['custom_data']['content_ids']  = $ids;
            $fb_capi_data['custom_data']['content_type'] = 'product';
        } else {
            // This is another page than a product page.
            $fb_capi_data['event_name'] = 'ViewContent';
            $viewContent                = '';
        }
        ?>
        <!-- Facebook Pixel Code - Product Feed Pro for WooCommerce by AdTribes.io -->
        <!------------------------------------------------------------------------------
        Make sure the g:id value in your Facebook catalogue feed matched with
        the content of the content_ids parameter in the Facebook Pixel Code
        ------------------------------------------------------------------------------->
        <script type="text/javascript">
            console.log("Facebook Pixel by AdTribes.io");
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');

            fbq("init", "<?php echo htmlentities( $facebook_pixel_id, ENT_QUOTES, 'UTF-8' ); ?>");
            fbq("track", "PageView");
            <?php
                if ( strlen( $viewContent ) > 2 ) {
                    echo "$viewContent";
                }
            ?>
        </script>
        <noscript>
            <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=
            <?php
            echo htmlentities( $facebook_pixel_id, ENT_QUOTES, 'UTF-8' );
?>
&ev=PageView&noscript=1&eid=<?php echo "$event_id"; ?>"/>
        </noscript> 
        <!-- End Facebook Pixel Code -->
        <?php

        // POST data to Facebook Conversion API.
        if ( ( $add_facebook_capi == 'yes' ) && ( ! empty( $facebook_capi_token ) ) ) {
            // Turn Data to JSON.
            $data_json = json_encode( array( $fb_capi_data ) );

            // Fill available fields.
            $fields                 = array();
            $fields['access_token'] = FACEBOOK_APP_ACCESS_TOKEN;
            $fields['upload_tag']   = $fb_capi_data['event_name'] . '-' . time(); // You should set a tag here (feel free to adjust)
            $fields['data']         = $data_json;
            $url                    = 'https://graph.facebook.com/v11.0/' . FACEBOOK_PIXEL_OFFLINE_EVENT_SET_ID . '/events';

            $args     = array(
                'timeout'     => 30,
                'redirection' => 10,
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(
                    'cache-control: no-cache',
                    'Accept: application/json',
                ),
                'body'        => $fields,
                'cookies'     => array(),
            );
            $response = wp_remote_post( $url, $args );
            }
        }
    }
}
add_action( 'wp_footer', 'woosea_add_facebook_pixel' );

/**
 * Add Google Adwords Remarketing code to footer.
 *
 * @param object $product The product object.
 */
function woosea_add_remarketing_tags( $product = null ) {
    // Check if WooCommerce is loaded and available
    if ( ! class_exists( 'WooCommerce' ) ) {  
        return;  
    }  

    if ( ! is_object( $product ) ) {  
        $product = function_exists( 'wc_get_product' ) ? wc_get_product( get_the_ID() ) : null;  
    }  
    
    if ( ! $product instanceof WC_Product ) {  
        return;  
    }  

    $ecomm_pagetype  = WooSEA_Google_Remarketing::woosea_google_remarketing_pagetype();
    $add_remarketing = get_option( 'adt_add_remarketing' );

    if ( $add_remarketing == 'yes' ) {
        $adwords_conversion_id = get_option( 'adt_adwords_conversion_id' );

        // Add vulnerability check, unset when no proper comversion ID was inserted.
        if ( ! is_numeric( $adwords_conversion_id ) ) {
            unset( $adwords_conversion_id );
        }

        if ( ! empty( $adwords_conversion_id ) ) {
        ?>
                <!-- Global site tag (gtag.js) - Google Ads: <?php echo htmlentities( $adwords_conversion_id, ENT_QUOTES, 'UTF-8' ); ?> - Added by the Product Feed Pro plugin from AdTribes.io  -->
                    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-<?php echo htmlentities( $adwords_conversion_id, ENT_QUOTES, 'UTF-8' ); ?>"></script>
                    <script>
                            window.dataLayer = window.dataLayer || [];
                            function gtag(){dataLayer.push(arguments);}
                            gtag('js', new Date());

                            gtag('config', '<?php echo 'AW-' . htmlentities( $adwords_conversion_id, ENT_QUOTES, 'UTF-8' ); ?>');
                    </script>
        <?php
            if ( $ecomm_pagetype == 'product' ) {
                        if ( '' !== $product->get_price() ) {
                        $ecomm_prodid = get_the_id();

                if ( ! empty( $ecomm_prodid ) ) {

                                        if ( ! $product ) {
                                                return -1;
                                        }

                    if ( $product->is_type( 'variable' ) ) {
                        // We should first check if there are any _GET parameters available.
                        // When there are not we are on a variable product page but not on a specific variable one.
                        // In that case we need to put in the AggregateOffer structured data.
                        $variation_id = woosea_find_matching_product_variation( $product, sanitize_text_field( $_GET ) );
                        $nr_get       = count( $_GET );

                        if ( $nr_get > 0 ) {
                            $variable_product = wc_get_product( $variation_id );

                            // for variants use the variation_id and not the item_group_id
                            // otherwise Google will disapprove the items due to itemID mismatches
                            $ecomm_prodid = $variation_id;

                            if ( is_object( $variable_product ) ) {
                                $product_price = $variable_product->get_price();

                                        // ----- remove HTML TAGs -----
                                $ecomm_price = $product_price;
                            } else {
                                // AggregateOffer
                                        $prices      = $product->get_variation_prices();
                                            $lowest  = reset( $prices['price'] );
                                            $highest = end( $prices['price'] );

                                            if ( $lowest === $highest ) {
                                                    $ecomm_price = wc_format_decimal( $lowest, wc_get_price_decimals() );
                                                } else {
                                                    $ecomm_lowprice  = wc_format_decimal( $lowest, wc_get_price_decimals() );
                                                    $ecomm_highprice = wc_format_decimal( $highest, wc_get_price_decimals() );
                                }
                            }
                        } else {
                            // When there are no parameters in the URL (so for normal users, not coming via Google Shopping URL's) show the old WooCommwerce JSON.
                            $prices  = $product->get_variation_prices();
                            $lowest  = reset( $prices['price'] );
                            $highest = end( $prices['price'] );

                            if ( $lowest === $highest ) {
                                $ecomm_price = wc_format_decimal( $lowest, wc_get_price_decimals() );
                            } else {
                                $ecomm_lowprice  = wc_format_decimal( $lowest, wc_get_price_decimals() );
                                $ecomm_highprice = wc_format_decimal( $highest, wc_get_price_decimals() );
                                $ecomm_price     = $ecomm_lowprice;
                            }
                        }
                    } else {
                            $ecomm_price = wc_format_decimal( $product->get_price(), wc_get_price_decimals() );
                        }
                }
                if ( isset( $ecomm_price ) ) {
                    ?>
                    <script>
                        gtag('event', 'view_item', {
                                'send_to'   : '<?php echo 'AW-' . htmlentities( $adwords_conversion_id, ENT_QUOTES, 'UTF-8' ); ?>',
                                'value'     : <?php echo "$ecomm_price"; ?>,
                                'items'     : [{
                                            'id': <?php echo "$ecomm_prodid"; ?>,
                                            'google_business_vertical': 'retail'
                                        }]
                        });
                    </script>
                <?php
                }
            }
        } elseif ( $ecomm_pagetype == 'cart' ) {
                                // This is on the order thank you page.
                                if ( isset( $_GET['key'] ) && is_wc_endpoint_url( 'order-received' ) ) {
                                        $order_string = sanitize_text_field( $_GET['key'] );
                                        if ( ! empty( $order_string ) ) {
                                                $order_id    = wc_get_order_id_by_order_key( $order_string );
                                                $order       = wc_get_order( $order_id );
                                                $order_items = $order->get_items();
                                                $currency    = get_woocommerce_currency();
                                                $contents    = '';
                                                $order_real  = wc_format_localized_price( $order->get_total() );

                                                if ( ! is_wp_error( $order_items ) ) {
                                                        foreach ( $order_items as $item_id => $order_item ) {
                                                                $prod_id      = $order_item->get_product_id();
                                                                $variation_id = $order_item->get_variation_id();
                                                                if ( $variation_id > 0 ) {
                                                                        $prod_id = $variation_id;
                                                                }
                                                                $prod_quantity = $order_item->get_quantity();
                                                        }
                                                }
                                                $order_real = floatval( str_replace( ',', '.', str_replace( ',', '.', $order_real ) ) );
                                            ?>
                                            <script>
                                                    gtag('event', 'purchase', {
                                                            'send_to'       : '<?php echo 'AW-' . htmlentities( $adwords_conversion_id, ENT_QUOTES, 'UTF-8' ); ?>',
                                                            'value'         : <?php echo "$order_real"; ?>,
                                                            'items'         : [{
                                                                            'id': <?php echo "$prod_id"; ?>,
                                                                            'google_business_vertical': 'retail'
                                                                    }]
                                                    });
                                            </script>
                                            <?php
                    }
                } else {
                    // This is on the cart page, no purchase yet.
                    // Get the first product from cart and use that product ID.
                    foreach ( WC()->cart->get_cart() as $cart_item ) {
                            $ecomm_prodid = $cart_item['product_id'];
                            break;
                    }

                    if ( isset( $ecomm_prodid ) ) {
                                            $currency          = get_woocommerce_currency();
                                            $cart_items        = WC()->cart->get_cart();
                                            $cart_quantity     = count( $cart_items );
                                            $cart_total_amount = wc_format_localized_price( WC()->cart->get_cart_contents_total() + WC()->cart->tax_total );
                                            $cart_total_amount = floatval( str_replace( ',', '.', str_replace( ',', '.', $cart_total_amount ) ) );
                        ?>
                        <script>
                            gtag('event', 'add_to_cart', {
                                    'send_to'   : '<?php echo 'AW-' . htmlentities( $adwords_conversion_id, ENT_QUOTES, 'UTF-8' ); ?>',
                                    'value'     : <?php echo "$cart_total_amount"; ?>,
                                    'items'     : [{
                                            'id': <?php echo "$ecomm_prodid"; ?>,
                                            'google_business_vertical': 'retail'
                                        }]
                            });
                        </script>
                    <?php
                    }
                }
            }
        }
    }
}
add_action( 'wp_footer', 'woosea_add_remarketing_tags' );

/**
 * Add some JS and mark-up code on every front-end page in order to get the conversion tracking to work.
 */
function woosea_hook_header() {
    $marker       = sprintf( '<!-- This website runs the Product Feed PRO for WooCommerce by AdTribes.io plugin - version ' . ADT_PFP_OPTION_INSTALLED_VERSION . ' -->' );
    $allowed_tags = array(
        '<!--' => array(),
        '-->'  => array(),
    );
    echo wp_kses( "\n{$marker}\n", $allowed_tags );
}
add_action( 'wp_head', 'woosea_hook_header' );

/**
 * We need to be able to make an AJAX call on the thank you page.
 */
function woosea_inject_ajax( $order_id ) {
    // Last order details.
    $order       = new WC_Order( $order_id );
    $order_id    = $order->get_id();
    $customer_id = $order->get_user_id();
    $total       = $order->get_total();

    update_option( 'adt_last_order_id', $order_id, false );
}
add_action( 'woocommerce_thankyou', 'woosea_inject_ajax' );


/**
 * Get a list of categories for the drop-down.
 */
function woosea_categories_dropdown() {
    $rowCount = absint( esc_attr( sanitize_text_field( $_POST['rowCount'] ) ) );

    if ( Helper::is_current_user_allowed() ) {
        $feed_id = absint( esc_attr( sanitize_text_field( $_POST['feed_id'] ) ) );
        $value = sanitize_text_field( $_POST['value'] ?? '' );

        // Filters is called rules in the old version.
        // Rules is called rules2 in the old version. It is what it is.
        $type = sanitize_text_field( $_POST['type'] ?? '' );
        $type = $type === 'filter' ? 'rules' : 'rules2';

        /**
         * Filter the arguments for the product categories dropdown.
         *
         * @since 13.3.4
         *
         * @param array $cat_args The arguments for the product categories dropdown.
         * @return array The arguments for the product categories dropdown.
         */
        $cat_args = apply_filters( 'adt_pfp_get_categories_dropdown_args',
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => 'false',
            ),
            $feed_id
        );

        /**
         * Filter the product categories for the product categories dropdown.
         * 
         * @since 13.3.4
         * 
         * @param array $product_categories The product categories for the product categories dropdown.
         * @param array $cat_args           The arguments for the product categories dropdown.
         * @param int   $feed_id            The feed ID.
         * @return array The product categories for the product categories dropdown.
         */
        $product_categories = apply_filters( 'adt_pfp_get_categories_dropdown', get_terms( $cat_args ), $cat_args, $feed_id );
        
        $categories_dropdown = "<select name=\"" . esc_attr($type) . "[" . esc_attr($rowCount) . "][criteria]\">";
        foreach ( $product_categories as $key => $category ) {
            /**
             * Before 13.4.4 the value was the category name. Now it is the category slug.
             * For backwards compatibility we also need to check for the category name.
             */
            $selected = ($value === $category->slug || $value === $category->name) ? 'selected' : '';
            $categories_dropdown .= "<option value=\"" . esc_attr($category->slug) . "\" $selected>" . esc_html($category->name) . " (" . esc_html($category->slug) . ")</option>";
        }
        $categories_dropdown .= '</select>';

        $data = array(
            'rowCount' => $rowCount,
            'dropdown' => $categories_dropdown,
        );
        echo json_encode( $data );
        wp_die();
    }
}
add_action( 'wp_ajax_woosea_categories_dropdown', 'woosea_categories_dropdown' );

/**
 * Sanitize XSS.
 *
 * @param string $value The value to sanitize.
 * @return string The sanitized value.
 */
function woosea_sanitize_xss( $value ) {
    return htmlspecialchars( strip_tags( $value ) );
}

/**
 * Recursive sanitation for an array.
 *
 * @param array $array The array to sanitize.
 * @return array The sanitized array.
 */
function woosea_recursive_sanitize_text_field( $array ) {
    foreach ( $array as $key => &$value ) {
        if ( is_array( $value ) ) {
            $value = woosea_recursive_sanitize_text_field( $value );
        } else {
            $value = sanitize_text_field( $value );
        }
    }
    return $array;
}

/**
 * Retrieve variation product id based on it attributes.
 **/
function woosea_find_matching_product_variation( $product, $attributes ) {

    if ( is_array( $attributes ) ) {
            foreach ( $attributes as $key => $value ) {
                if ( strpos( $key, 'attribute_' ) === 0 ) {
                        continue;
                }
                unset( $attributes[ $key ] );
                $attributes[ sprintf( 'attribute_%s', $key ) ] = $value;
            }

            if ( class_exists( 'WC_Data_Store' ) ) {
                $data_store = WC_Data_Store::load( 'product' );
                return $data_store->find_matching_product_variation( $product, $attributes );
            } else {
                return $product->get_matching_variation( $attributes );
            }
    }
}

/**
 * Get the shipping zone countries and ID's.
 */
function woosea_shipping_zones() {
    $shipping_options = '';
    $shipping_zones   = WC_Shipping_Zones::get_zones();

    $shipping_options = '<option value="all_zones">All zones</option>';

    foreach ( $shipping_zones as $zone ) {
        $shipping_options .= "<option value=\"$zone[zone_id]\">$zone[zone_name]</option>";
    }

    $data = array(
        'dropdown' => $shipping_options,
    );

    echo json_encode( $data );
    wp_die();
}
add_action( 'wp_ajax_woosea_shipping_zones', 'woosea_shipping_zones' );

/**
 * Get the attribute mapping helptexts.
 */
function woosea_fieldmapping_dialog_helptext() {
    $field = sanitize_text_field( $_POST['field'] );

    switch ( $field ) {
        case 'g:id':
            $helptext = "(Required field) The g:id field is used to uniquely identify each product. The g:id needs to be unique and remain the same forever. Google advises to map the g:id field to a SKU value, however since this field is not always present nor always filled we suggest you map the 'Product Id' field to g:id.";
            break;
        case 'g:title':
            $helptext = "(Required field) The g:title field should clearly identify the product you are selling. We suggest you map this field to your 'Product name'.";
            break;
        case 'g:description':
            $helptext = "(Required field) The g:description field should tell users about your product. We suggest you map this field to your 'Product description' or 'Product short description'";
            break;
        case 'g:link':
            $helptext = "(Required field) The g:link field should be filled with the landing page on your website. We suggest you map this field to your 'Link' attribute.";
            break;
        case 'g:image_link':
            $helptext = "(Required field) Include the URL for your main product image with the g:image_link attribute. We suggest you map this field to your 'Main image' attribute.";
            break;
        case 'g:definition':
            $helptext = "(Required field) Use the g:availability attribute to tell users and Google whether you have a product in stock. We suggest you map this field to your 'Availability' attribute.";
            break;
        case 'g:price':
            $helptext = "(Required field) Use the g:price attribute to tell users how much you are charging for your product. We suggest you map this field to your 'Price' attribute. When a product is on sale the plugin will automatically get the sale price instead of the normal base price. Also, make sure you use a currency pre- or suffix as this is required by Google when you have not configured a currency in your Google Merchant center. The plugin automatically determines your relevant currency and puts this in the price prefix field.";
            break;
        case 'g:google_product_category':
            $helptext = "(Required for some product categories) Use the g:google_product_category attribute to indicate the category of your item based on the Google product taxonomy. Map this field to your 'Category' attribute. In the next configuration step you will be able to map your categories to Google's category taxonomy. Categorizing your product helps ensure that your ad is shown with the right search results.";
            break;
        case 'g:brand':
            $helptext = "Use the g:brand attribute to indicate the product's brand name. The brand is used to help identify your product and will be shown to users who view your ad. g:brand is required for each product with a clearly associated brand or manufacturer. If the product doesn't have a clearly associated brand (e.g. movies, books, music) or is a custom-made product (e.g. art, custom t-shirts, novelty products and handmade products), the attribute is optional. As WooCommerce does not have a brand attribute out of the box you will probably have to map the g:brand field to a custom/dynamic field or product attribute.";
            break;
        case 'g:gtin':
            $helptext = '(Required for all products with a GTIN assigned by the manufacturer). This specific number helps Google to make your ad richer and easier for users to find. Products submitted without any unique product identifiers are difficult to classify and may not be able to take advantage of all Google Shopping features. Several different types of ID numbers are considered a GTIN, for example: EAN, UPC, JAN, ISBN, IFT-14. Most likely you have configured custom/dynamic or product attribute that you need to map to the g:gtin field.';
            break;
        case 'g:mpn':
            $helptext = "(Required for all products without a manufacturer-assigned GTIN.) USe the mpn attribute to submit your product's Manufacturer Part Number (MPN). MPNs are used to uniquely identify a specific product among all products from the same manufacturer. Users might search Google Shopping specifically for an MPN, so providing the MPN can help ensure that your product is shown in relevant situations. When a product doesn't have a clearly associated mpn or is a custom-made product (e.g. art, custom t-shirts, novelty products and handmade products), the attribute is optional.";
            break;
        case 'g:identifier_exists':
            $helptext = "(Required only for new products that don’t have <b>gtin and brand</b> or <b>mpn and brand</b>.) Use the g:identifier_exists attribute to indicate that unique product identifiers aren’t available for your product. Unique product identifiers include gtin, mpn, and brand. The plugin automatically determines if the value for a product is 'no' or 'yes' when you set the g:identifier_exists to 'Plugin calculation'.";
            break;
        case 'g:condition':
            $helptext = "(Required) Tell users about the condition of the product you are selling. Supported values are: 'new', 'refurbished' and 'used'. We suggest you map this field to the 'Condition' attribute.";
            break;
        case 'g:item_group_id':
            $helptext = "(Required for the following countries: Brazil, France, Germany, Japan, United Kingdom and the United States). The g:item_group_id is used to group product variants in your product data. We suggest you map the g:item_group_id to the 'Item group ID' attribute. The plugin automatically ads the correct value to this field and makes sure the 'mother' products is not in your product feed (as required by Google).";
            break;
        case 'g:shipping':
            $helptext = "(Required when you need to override the shipping settings that you set up in Merchant Center) Google recommends that you set up shipping costs through your Merchant center. However, when you need to override these settings you can map the g:shipping field to the 'Shipping price' attribute.";
            break;
        case 'Structured data fix':
            $helptext = "Because of a bug in WooCommerce variable products will get disapproved in Google's Merchant Center. WooCommerce adds the price of the cheapest variable product in the structured data for all variations of a product. Because of this there will be a mismatch between the product price you provide to Google in your Google Shopping product feed and the structured data price on the product landingpage. Google will therefor disapprove the product in its merchant center. You won't be able to advertise on that product in your Google Shopping campaign. Enable this option will fix the structured data on variable product pages by adding the correct variable product price in the JSON-LD structured data so Google will approve the variable products you submitted.";
            break;
        case 'Unique identifiers':
            $helptext = "In order to optimise your product feed for Google Shopping and meet all Google's Merchant Center requirements you need to add extra fields / attributes to your products that are not part of WooCommerce by default. Enable this option to get Brand, GTIN, MPN, UPC, EAN, Product condition and optimised title fields";
            break;
        default:
            $helptext = 'need information about this field? reach out to support@adtribes.io';
    }

    $data = array(
        'helptext' => $helptext,
    );

    echo json_encode( $data );
    wp_die();
}
add_action( 'wp_ajax_woosea_fieldmapping_dialog_helptext', 'woosea_fieldmapping_dialog_helptext' );

/**
 * This function saves the status of a product before changes are made to it
 * We need this to determine if a product is updated and thus feeds need to refresh.
 *
 * @param int $post_id The product id.
 */
function woosea_before_product_save( $post_id ) {
    $post_type = get_post_type( $post_id );
    if ( $post_type == 'product' ) {
        $product = wc_get_product( $post_id );

        if ( is_object( $product ) ) {
            $product_data = $product->get_data();

            $before = array(
                'product_id'        => $post_id,
                'type'              => $product->get_type(),
                'name'              => $product->get_name(),
                'slug'              => $product->get_slug(),
                'status'            => $product->get_status(),
                'featured'          => $product->get_featured(),
                'visibility'        => $product->get_catalog_visibility(),
                'description'       => $product->get_description(),
                'short_description' => $product->get_short_description(),
                'sku'               => $product->get_sku(),
                'price'             => $product->get_price(),
                'regular_price'     => $product->get_regular_price(),
                'sale_price'        => $product->get_sale_price(),
                'total_sales'       => $product->get_total_sales(),
                'tax_status'        => $product->get_tax_status(),
                'tax_class'         => $product->get_tax_class(),
                'manage_stock'      => $product->get_manage_stock(),
                'stock_quantity'    => $product->get_stock_quantity(),
                'stock_status'      => $product->get_stock_status(),
                'backorders'        => $product->get_backorders(),
                'weight'            => $product->get_weight(),
                'length'            => $product->get_length(),
                'width'             => $product->get_width(),
                'height'            => $product->get_height(),
                'parent_id'         => $product->get_parent_id(),
            );

            if ( ! get_option( 'adt_product_changes' ) ) {
                update_option( 'adt_product_changes', $before, false );
            }
        }
    }
}
add_action( 'pre_post_update', 'woosea_before_product_save' );

/**
 * Detect changes made to products.
 * When no changes are made feed(s) do not need to get updated.
 *
 * @param int $product_id The product id.
 */
function woosea_on_product_save( $product_id ) {
    $product = wc_get_product( $product_id );

    if ( is_object( $product ) ) {
        $product_data = $product->get_data();

        $after = array(
            'product_id'        => $product_id,
            'type'              => $product->get_type(),
            'name'              => $product->get_name(),
            'slug'              => $product->get_slug(),
            'status'            => $product->get_status(),
            'featured'          => $product->get_featured(),
            'visibility'        => $product->get_catalog_visibility(),
            'description'       => $product->get_description(),
            'short_description' => $product->get_short_description(),
            'sku'               => $product->get_sku(),
            'price'             => $product->get_price(),
            'regular_price'     => $product->get_regular_price(),
            'sale_price'        => $product->get_sale_price(),
            'total_sales'       => $product->get_total_sales(),
            'tax_status'        => $product->get_tax_status(),
            'tax_class'         => $product->get_tax_class(),
            'manage_stock'      => $product->get_manage_stock(),
            'stock_quantity'    => $product->get_stock_quantity(),
            'stock_status'      => $product->get_stock_status(),
            'backorders'        => $product->get_backorders(),
            'sold_individually' => $product->get_sold_individually(),
            'weight'            => $product->get_weight(),
            'length'            => $product->get_length(),
            'width'             => $product->get_width(),
            'height'            => $product->get_height(),
            'parent_id'         => $product->get_parent_id(),
        );

        if ( is_array( $product_data ) ) {
            if ( get_option( 'adt_product_changes' ) ) {
                $before = get_option( 'adt_product_changes' );
                $diff   = array_diff( $after, $before );

                if ( ! $diff ) {
                    $diff['product_id'] = $product_id;
                } else {
                    // Enable the product changed flag.
                    update_option( 'woosea_allow_update', false );
                }

                delete_option( 'adt_product_changes' );
            } else {
                // Enable the product changed flag.
                update_option( 'woosea_allow_update', false );
            }
        }
    }
}
add_action( 'woocommerce_update_product', 'woosea_on_product_save', 10, 1 );
