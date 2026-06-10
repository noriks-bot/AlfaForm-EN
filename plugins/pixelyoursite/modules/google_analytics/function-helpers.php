<?php

namespace PixelYourSite\GA\Helpers;

use PixelYourSite;
use function PixelYourSite\GATags;
use function PixelYourSite\isWPMLActive;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Render Cross Domain Domain text field
 *
 * @param int    $index
 */
function renderCrossDomainDomain( $index = 0 ) {
    
    $slug = PixelYourSite\GA()->getSlug();
    
    $attr_name = "pys[$slug][cross_domain_domains][]";
    $attr_id = 'pys_' . $slug . '_cross_domain_domains_' . $index;
    
    $values = (array) PixelYourSite\GA()->getOption( 'cross_domain_domains' );
    $attr_value = isset( $values[ $index ] ) ? $values[ $index ] : null;
    
    ?>

    <input type="text" class="input-short" name="<?php echo esc_attr( $attr_name ); ?>"
           id="<?php echo esc_attr( $attr_id ); ?>"
           value="<?php echo esc_attr( $attr_value ); ?>"
           placeholder="Enter domain"
    >
    
    <?php
    
}

function getWooProductContentId( $product_id ) {

	if(isWPMLActive() && PixelYourSite\GATags()->getOption( 'woo_wpml_unified_id' )) {
		$wpml_product_id = apply_filters('wpml_original_element_id', NULL, $product_id);
		if ($wpml_product_id) {
			$product_id = $wpml_product_id;
		}
	}

    if ( PixelYourSite\GATags()->getOption( 'woo_content_id' ) == 'product_sku' ) {
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

    $prefix = PixelYourSite\GATags()->getOption( 'woo_content_id_prefix' );
    $suffix = PixelYourSite\GATags()->getOption( 'woo_content_id_suffix' );

    $value = $prefix . $content_id . $suffix;

    return $value;
}

function getWooCartItemId( $item ) {

    if ( ! PixelYourSite\GATags()->getOption( 'woo_variable_as_simple' ) && isset( $item['variation_id'] ) && $item['variation_id'] !== 0 ) {
        $product_id = $item['variation_id'];
    } else {
        $product_id = $item['product_id'];
    }

    return $product_id;
}

/*
 * EASY DIGITAL DOWNLOADS
 */

function getEddDownloadContentId( $download_id )
{

    if (PixelYourSite\GATags()->getOption('edd_content_id') == 'download_sku') {
        $content_id = get_post_meta($download_id, 'edd_sku', true);
    } else {
        $content_id = $download_id;
    }

    $prefix = PixelYourSite\GATags()->getOption('edd_content_id_prefix');
    $suffix = PixelYourSite\GATags()->getOption('edd_content_id_suffix');

    return $prefix . $content_id . $suffix;
}