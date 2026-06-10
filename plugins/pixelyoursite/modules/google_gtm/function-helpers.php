<?php

namespace PixelYourSite\GTM\Helpers;

use PixelYourSite;
use function PixelYourSite\GTM;
use function PixelYourSite\isWPMLActive;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function get_all_blacklist_tabs() {


    $tags = array(
        array('tag' => 'AB TASTY Generic Tag', 'id' => 'abtGeneric', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'AdAdvisor Tag', 'id' => 'ta', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Adometry Tag', 'id' => 'adm', 'classes' => 'google'),
        array('tag' => 'AdRoll Smart Pixel Tag', 'id' => 'asp', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Google Ads Conversion Tracking Tag', 'id' => 'awct', 'classes' => 'google'),
        array('tag' => 'Google Ads Remarketing Tag', 'id' => 'sp', 'classes' => 'google'),
        array('tag' => 'Affiliate Window Conversion Tag', 'id' => 'awc', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Affiliate Window Journey Tag', 'id' => 'awj', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Bing Ads Universal Event Tracking', 'id' => 'baut', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Bizrate Insights Buyer Survey Solution', 'id' => 'bb', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Bizrate Insights Site Abandonment Survey Solution', 'id' => 'bsa', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'ClickTale Standard Tracking Tag (OBSOLETE)', 'id' => 'cts', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'comScore Unified Digital Measurement Tag', 'id' => 'csm', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Conversant Mediaplex - IFRAME MCT Tag', 'id' => 'mpm', 'classes' => 'nonGoogleIframes'),
        array('tag' => 'Conversant Mediaplex - Standard IMG ROI Tag', 'id' => 'mpr', 'classes' => 'nonGooglePixels'),
        array('tag' => 'Conversion Linker', 'id' => 'gclidw', 'classes' => 'google'),
        array('tag' => 'Crazy Egg Tag', 'id' => 'cegg', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Criteo OneTag', 'id' => 'crto', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Custom HTML Tag', 'id' => 'html', 'classes' => 'customScripts'),
        array('tag' => 'Custom Image Tag', 'id' => 'img', 'classes' => 'customPixels'),
        array('tag' => 'DistroScale Tag', 'id' => 'dstag', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Floodlight Counter Tag', 'id' => 'flc', 'classes' => ''),
        array('tag' => 'Floodlight Sales Tag', 'id' => 'fls', 'classes' => ''),
        array('tag' => 'Dstillery Universal Pixel Tag', 'id' => 'm6d', 'classes' => 'nonGooglePixels'),
        array('tag' => 'Eulerian Analytics Tag', 'id' => 'ela', 'classes' => 'customScripts'),
        array('tag' => 'Google tag (formerly Google Analytics 4 Configuration)', 'id' => 'gaawc', 'classes' => 'google'),
        array('tag' => 'Google Analytics 4 Event', 'id' => 'gaawe', 'classes' => 'google'),
        array('tag' => 'Google Analytics Tag (legacy)', 'id' => 'ga', 'classes' => 'google'),
        array('tag' => 'Google Consumer Surveys Website Satisfaction', 'id' => 'gcs', 'classes' => 'google'),
        array('tag' => 'Google Trusted Stores Tag', 'id' => 'ts', 'classes' => ''),
        array('tag' => 'Hotjar Tracking Code', 'id' => 'hjtc', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Infinity Call Tracking Tag', 'id' => 'infinity', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Intent Media - Search Compare Ads', 'id' => 'sca', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'K50 tracking tag', 'id' => 'k50Init', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'LeadLab', 'id' => 'll', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'LinkedIn Tag', 'id' => 'bzi', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Lytics JS Tag', 'id' => 'ljs', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Marin Software Tag', 'id' => 'ms', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Mediaplex - IFRAME MCT Tag', 'id' => 'mpm', 'classes' => 'nonGoogleIframes'),
        array('tag' => 'Mediaplex - Standard IMG ROI Tag', 'id' => 'mpr', 'classes' => 'nonGooglePixels'),
        array('tag' => 'Message Mate', 'id' => 'messagemate', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Mouseflow Tag', 'id' => 'mf', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Nielsen DCR Static Lite Tag', 'id' => 'ndcr', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Nudge Content Analytics Tag', 'id' => 'nudge', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Oktopost Tracking Code', 'id' => 'okt', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Optimise Conversion Tag', 'id' => 'omc', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'OwnerListens Message Mate', 'id' => 'messagemate', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Perfect Audience Pixel', 'id' => 'pa', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Personali Canvas', 'id' => 'pc', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Pinterest', 'id' => 'pntr', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Placed', 'id' => 'placedPixel', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Pulse Insights Voice of Customer Platform', 'id' => 'pijs', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Quantcast Audience Measurement', 'id' => 'qcm', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Quora Pixel', 'id' => 'qpx', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Rawsoft FoxMetrics', 'id' => 'fxm', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'SaleCycle JavaScript Tag', 'id' => 'scjs', 'classes' => 'customScripts'),
        array('tag' => 'SaleCycle Pixel Tag', 'id' => 'scp', 'classes' => 'customPixels'),
        array('tag' => 'SearchForce JavaScript Tracking for Conversion Page', 'id' => 'sfc', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'SearchForce JavaScript Tracking for Landing Page', 'id' => 'sfl', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'SearchForce Redirection Tracking Tag', 'id' => 'sfr', 'classes' => 'nonGooglePixels'),
        array('tag' => 'Shareaholic', 'id' => 'shareaholic', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Survicate Widget', 'id' => 'svw', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Tradedoubler Lead Conversion Tag', 'id' => 'tdlc', 'classes' => 'nonGooglePixels'),
        array('tag' => 'Tradedoubler Sale Conversion Tag', 'id' => 'tdsc', 'classes' => 'nonGooglePixels'),
        array('tag' => 'Turn Conversion Tracking Tag', 'id' => 'tc', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Turn Data Collection Tag', 'id' => 'tdc', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Twitter Universal Website Tag', 'id' => 'twitter_website_tag', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Universal Analytics Tag', 'id' => 'ua', 'classes' => 'google'),
        array('tag' => 'Upsellit Global Footer Tag', 'id' => 'uslt', 'classes' => 'customScripts'),
        array('tag' => 'Upsellit Confirmation Tag', 'id' => 'uspt', 'classes' => 'customScripts'),
        array('tag' => 'Ve Interactive JavaScript Tag', 'id' => 'vei', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Ve Interactive Pixel', 'id' => 'veip', 'classes' => 'nonGooglePixels'),
        array('tag' => 'VisualDNA Conversion Tag', 'id' => 'vdc', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Xtremepush', 'id' => 'xpsh', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Yieldify', 'id' => 'yieldify', 'classes' => 'nonGoogleScripts'),
        array('tag' => 'Zones', 'id' => 'zone', 'classes' => ''),
    );

    $triggers = array(
        array('trigger' => 'Element Visibility Listener/Trigger', 'id' => 'evl', 'classes' => 'google'),
        array('trigger' => 'Click Listener/Trigger', 'id' => 'cl', 'classes' => 'google'),
        array('trigger' => 'Form Submit Listener/Trigger', 'id' => 'fsl', 'classes' => ''),
        array('trigger' => 'History Listener/Trigger', 'id' => 'hl', 'classes' => 'google'),
        array('trigger' => 'JavaScript Error Listener/Trigger', 'id' => 'jel', 'classes' => 'google'),
        array('trigger' => 'Link Click Listener/Trigger', 'id' => 'lcl', 'classes' => ''),
        array('trigger' => 'Scroll Depth Listener/Trigger', 'id' => 'sdl', 'classes' => 'google'),
        array('trigger' => 'Timer Listener/Trigger', 'id' => 'tl', 'classes' => 'google'),
        array('trigger' => 'YouTube Video Listener/Trigger', 'id' => 'ytl', 'classes' => 'google'),
    );

    $variables = array(
        array('variable' => 'First Party Cookie', 'id' => 'k', 'classes' => 'google'),
        array('variable' => 'Auto-Event Variable', 'id' => 'v', 'classes' => 'google'),
        array('variable' => 'Constant', 'id' => 'c', 'classes' => 'google'),
        array('variable' => 'Container Version Number', 'id' => 'ctv', 'classes' => 'google'),
        array('variable' => 'Custom Event', 'id' => 'e', 'classes' => 'google'),
        array('variable' => 'Custom JavaScript Variable', 'id' => 'jsm', 'classes' => 'customScripts'),
        array('variable' => 'Data Layer Variable', 'id' => 'v', 'classes' => 'google'),
        array('variable' => 'Debug Mode', 'id' => 'dbg', 'classes' => 'google'),
        array('variable' => 'DOM Element', 'id' => 'd', 'classes' => 'google'),
        array('variable' => 'Element Visibility', 'id' => 'vis', 'classes' => 'google'),
        array('variable' => 'Google Analytics Settings (legacy)', 'id' => 'gas', 'classes' => 'google'),
        array('variable' => 'HTTP Referrer', 'id' => 'f', 'classes' => 'google'),
        array('variable' => 'JavaScript Variable', 'id' => 'j', 'classes' => 'google'),
        array('variable' => 'Lookup Table', 'id' => 'smm', 'classes' => 'google'),
        array('variable' => 'Random Number', 'id' => 'r', 'classes' => 'google'),
        array('variable' => 'RegEx Table', 'id' => 'remm', 'classes' => 'google'),
        array('variable' => 'URL', 'id' => 'u', 'classes' => 'google'),
    );

    $black_list_tag = array(
        'tags' => $tags, 'triggers' => $triggers, 'variables' => $variables
    );

    return $black_list_tag;
}
function custom_wc_get_related_products( $product_id, $limit = 5, $exclude_ids = array() ) {

    $product_id     = absint( $product_id );
    $limit = (int) $limit;
    $limit          = $limit >= -1 ? $limit : 5;
    $exclude_ids    = array_merge( array( 0, $product_id ), $exclude_ids );
    $transient_name = 'wc_related_' . $product_id;
    $query_args     = http_build_query(
        array(
            'limit'       => $limit,
            'exclude_ids' => $exclude_ids,
        )
    );

    $transient     = get_transient( $transient_name );
    $related_posts = $transient && isset( $transient[ $query_args ] ) ? $transient[ $query_args ] : false;

    // We want to query related posts if they are not cached, or we don't have enough.
    if ( false === $related_posts || count( $related_posts ) < $limit ) {

        $cats_array = apply_filters( 'woocommerce_product_related_posts_relate_by_category', true, $product_id ) ? apply_filters( 'woocommerce_get_related_product_cat_terms', wc_get_product_term_ids( $product_id, 'product_cat' ), $product_id ) : array();
        $tags_array = apply_filters( 'woocommerce_product_related_posts_relate_by_tag', true, $product_id ) ? apply_filters( 'woocommerce_get_related_product_tag_terms', wc_get_product_term_ids( $product_id, 'product_tag' ), $product_id ) : array();

        // Don't bother if none are set, unless woocommerce_product_related_posts_force_display is set to true in which case all products are related.
        if ( empty( $cats_array ) && empty( $tags_array ) && ! apply_filters( 'woocommerce_product_related_posts_force_display', false, $product_id ) ) {
            $related_posts = array();
        } else {
            $data_store    = \WC_Data_Store::load( 'product' );
            $related_posts = $data_store->get_related_products( $cats_array, $tags_array, $exclude_ids, $limit + 10, $product_id );
        }

        if ( $transient ) {
            $transient[ $query_args ] = $related_posts;
        } else {
            $transient = array( $query_args => $related_posts );
        }

        set_transient( $transient_name, $transient, DAY_IN_SECONDS );
    }

    $related_posts = apply_filters(
        'woocommerce_related_products',
        $related_posts,
        $product_id,
        array(
            'limit'        => $limit,
            'excluded_ids' => $exclude_ids,
        )
    );

    // if ( apply_filters( 'woocommerce_product_related_posts_shuffle', true ) ) {
    //    shuffle( $related_posts );
    // }

    return $related_posts; //array_slice( $related_posts, 0, $limit );
}

/**
 * @param $product_id
 * @return string
 */

function getWooProductContentId( $product_id ) {

	if(isWPMLActive() && PixelYourSite\GTM()->getOption( 'woo_wpml_unified_id' )) {
		$wpml_product_id = apply_filters('wpml_original_element_id', NULL, $product_id);
		if ($wpml_product_id) {
			$product_id = $wpml_product_id;
		}
	}

    if ( GTM()->getOption( 'woo_content_id' ) == 'product_sku' ) {
        $product = wc_get_product( $product_id );
        if ($product && $product->is_type( 'variation' ) ) {
            $content_id = $product->get_sku();
            if ( empty( $content_id ) ) {
                $parent_id = $product->get_parent_id();
                $parent_product = wc_get_product( $parent_id );
                if($parent_product){
                    $content_id = $parent_product->get_sku();
                }
                if ( empty( $content_id ) ) {
                    $content_id = $product_id;
                }
            }
        } elseif($product) {
            $content_id = $product->get_sku();
            if ( empty( $content_id ) ) {
                $content_id = $product_id;
            }
        } else {
            $content_id = $product_id;
        }
    } else {
        $content_id = $product_id;
    }

    $prefix = GTM()->getOption( 'woo_content_id_prefix' );
    $suffix = GTM()->getOption( 'woo_content_id_suffix' );

    $value = $prefix . $content_id . $suffix;

    return $value;
}

function getWooEventCartItemId( $item ) {

    if ( GTM()->getOption( 'woo_variable_as_simple' )
        && isset( $item['parent_id'] )
        && $item['parent_id'] !== 0 )
    {
        $product_id = $item['parent_id'];
    } else {
        $product_id = $item['product_id'];
    }

    return $product_id;
}
/**
 * @deprecated use getWooEventCartItemId
 * @param $item
 * @return mixed
 */
function getWooCartItemId( $item ) {

    if ( ! GTM()->getOption( 'woo_variable_as_simple' ) && isset( $item['variation_id'] ) && $item['variation_id'] !== 0 ) {
        $product_id = $item['variation_id'];
    } else {
        $product_id = $item['product_id'];
    }

    return $product_id;
}

function getWooProductDataId( $item ) {

    if($item['type'] == 'variation'
        && GTM()->getOption( 'woo_variable_as_simple' )
    ) {
        $product_id = $item['parent_id'];
    }else {
        $product_id = $item['id'];
    }

    return $product_id;

}

function getTriggerType($event_id) {
    $triggerType = false;

    switch ($event_id) {
        case 'init_event':
            // No triggerType for init_event
            break;

        // Automated events
        case 'automatic_event_video':
        case 'automatic_event_signup':
        case 'automatic_event_login':
        case 'automatic_event_404':
        case 'automatic_event_search':
        case 'automatic_event_tel_link':
        case 'automatic_event_email_link':
        case 'automatic_event_form':
        case 'automatic_event_download':
        case 'automatic_event_comment':
        case 'automatic_event_adsense':
        case 'automatic_event_scroll':
        case 'automatic_event_time_on_page':
        case 'automatic_event_outbound_link':
        case 'automatic_event_internal_link':
        case 'woo_paypal':
        case 'woo_select_content_category':
        case 'woo_select_content_single':
        case 'woo_select_content_search':
        case 'woo_select_content_shop':
        case 'woo_select_content_tag':
            $triggerType = 'automated';
            break;

        // Advanced marketing events
        case 'woo_frequent_shopper':
        case 'woo_vip_client':
        case 'woo_big_whale':
        case 'woo_FirstTimeBuyer':
        case 'woo_ReturningCustomer':
        case 'edd_frequent_shopper':
        case 'edd_vip_client':
        case 'edd_big_whale':
            $triggerType = 'advanced_marketing';
            break;

        // E-commerce events
        case 'woo_view_content':
        case 'woo_view_cart':
        case 'woo_view_item_list':
        case 'woo_view_item_list_single':
        case 'woo_view_item_list_search':
        case 'woo_view_item_list_shop':
        case 'woo_view_item_list_tag':
        case 'woo_add_to_cart_on_cart_page':
        case 'woo_add_to_cart_on_checkout_page':
        case 'woo_initiate_checkout':
        case 'woo_purchase':
        case 'woo_initiate_set_checkout_option':
        case 'woo_initiate_checkout_progress_f':
        case 'woo_initiate_checkout_progress_l':
        case 'woo_initiate_checkout_progress_e':
        case 'woo_initiate_checkout_progress_o':
        case 'woo_remove_from_cart':
        case 'edd_view_content':
        case 'edd_add_to_cart_on_checkout_page':
        case 'edd_remove_from_cart':
        case 'edd_view_category':
        case 'edd_initiate_checkout':
        case 'edd_purchase':
        case 'edd_refund':
        case 'woo_add_to_cart_on_button_click':
        case 'woo_affiliate':
        case 'edd_add_to_cart_on_button_click':
        case 'wcf_view_content':
        case 'wcf_add_to_cart_on_bump_click':
        case 'wcf_add_to_cart_on_next_step_click':
        case 'wcf_remove_from_cart_on_bump_click':
        case 'wcf_bump':
        case 'wcf_page':
        case 'wcf_step_page':
        case 'wcf_lead':
            $triggerType = 'ecommerce';
            break;

        // Manual events
        case 'custom_event':
            $triggerType = 'manual';
            break;

    }

    return $triggerType;
}

/*
 * EASY DIGITAL DOWNLOADS
 */

function getEddDownloadContentId( $download_id ) {

    if ( GTM()->getOption( 'edd_content_id' ) == 'download_sku' ) {
        $content_id = get_post_meta( $download_id, 'edd_sku', true );
    } else {
        $content_id = $download_id;
    }

    $prefix = GTM()->getOption( 'edd_content_id_prefix' );
    $suffix = GTM()->getOption( 'edd_content_id_suffix' );

    return $prefix . $content_id . $suffix;

}