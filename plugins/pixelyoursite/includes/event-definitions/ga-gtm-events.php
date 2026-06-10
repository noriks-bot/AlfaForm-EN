<?php
/**
 * Google Analytics & Google Tag Manager Event Definitions
 * 
 * This file contains event definitions for Google Analytics 4 and Google Tag Manager.
 * Used by both legacy UI and EST (Event Setup Tool).
 * 
 * Events are grouped by category for better organization.
 * 
 * @package PixelYourSite
 */

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

return array(
    'Custom Event' => array( 'CustomEvent' => array() ),
    'All Properties' => array(
        "conversion"             => array(),
        "earn_virtual_currency"  => array(
            ['name' => 'virtual_currency_name', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        "join_group"             => array(
            ['name' => 'group_id', 'input_type' => 'string', 'required' => true]
        ),
        "login"                  => array(
            ['name' => 'method', 'input_type' => 'string', 'required' => false]
        ),
        "purchase"               => array(
            ['name' => 'affiliation', 'input_type' => 'string', 'required' => false],
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'transaction_id', 'input_type' => 'string', 'required' => true],
            ['name' => 'shipping', 'input_type' => 'float', 'required' => false],
            ['name' => 'tax', 'input_type' => 'float', 'required' => false],
            ['name' => 'value', 'input_type' => 'float', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false]
        ),
        "refund"                 => array(
            ['name' => 'affiliation', 'input_type' => 'string', 'required' => false],
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => false],
            ['name' => 'shipping', 'input_type' => 'float', 'required' => false],
            ['name' => 'tax', 'input_type' => 'float', 'required' => false],
            ['name' => 'transaction_id', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => false]
        ),
        "search"                 => array(
            ['name' => 'search_term', 'input_type' => 'string', 'required' => true]
        ),
        "select_content"         => array(
            ['name' => 'content_type', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_id', 'input_type' => 'string', 'required' => false]
        ),
        "share"                  => array(
            ['name' => 'content_type', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_id', 'input_type' => 'string', 'required' => false]
        ),
        "sign_up"                => array(
            ['name' => 'method', 'input_type' => 'string', 'required' => false]
        ),
        "spend_virtual_currency" => array(
            ['name' => 'item_name', 'input_type' => 'string', 'required' => true],
            ['name' => 'virtual_currency_name', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        "tutorial_begin"         => array(),
        "tutorial_complete"      => array(),
    ),

    "Games" => array(
        'earn_virtual_currency'  => array(
            ['name' => 'virtual_currency_name', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'join_group'             => array(
            ['name' => 'group_id', 'input_type' => 'string', 'required' => true]
        ),
        'level_end'              => array(
            ['name' => 'level_name', 'input_type' => 'string', 'required' => true],
            ['name' => 'success', 'input_type' => 'bool', 'required' => false]
        ),
        'level_start'            => array(
            ['name' => 'level_name', 'input_type' => 'string', 'required' => true]
        ),
        'level_up'               => array(
            ['name' => 'character', 'input_type' => 'string', 'required' => false],
            ['name' => 'level', 'input_type' => 'int', 'required' => true]
        ),
        'post_score'             => array(
            ['name' => 'character', 'input_type' => 'string', 'required' => false],
            ['name' => 'level', 'input_type' => 'int', 'required' => false],
            ['name' => 'score', 'input_type' => 'int', 'required' => true]
        ),
        'select_content'         => array(
            ['name' => 'content_type', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_id', 'input_type' => 'int', 'required' => false]
        ),
        'spend_virtual_currency' => array(
            ['name' => 'item_name', 'input_type' => 'string', 'required' => true],
            ['name' => 'virtual_currency_name', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'tutorial_begin'         => array(),
        'tutorial_complete'      => array(),
        'unlock_achievement'     => array(
            ['name' => 'achievement_id', 'input_type' => 'string', 'required' => true]
        ),
    ),
    'Jobs, Education, Local Deals, Real Estate' => array(
        'add_payment_info'    => array(
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'payment_type', 'input_type' => 'string', 'required' => false],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'add_shipping_info'   => array(
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'shipping_tier', 'input_type' => 'string', 'required' => false],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'add_to_cart'         => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'add_to_wishlist'     => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'begin_checkout'      => array(
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'purchase'            => array(
            ['name' => 'affiliation', 'input_type' => 'string', 'required' => false],
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'shipping', 'input_type' => 'float', 'required' => false],
            ['name' => 'tax', 'input_type' => 'float', 'required' => false],
            ['name' => 'transaction_id', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'refund'              => array(
            ['name' => 'affiliation', 'input_type' => 'string', 'required' => false],
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => false],
            ['name' => 'shipping', 'input_type' => 'float', 'required' => false],
            ['name' => 'tax', 'input_type' => 'float', 'required' => false],
            ['name' => 'transaction_id', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => false]
        ),
        'remove_from_cart'    => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'select_item'         => array(
            ['name' => 'item_list_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_list_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true]
        ),
        'select_promotion'    => array(
            ['name' => 'creative_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'creative_slot', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'location_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_name', 'input_type' => 'string', 'required' => false]
        ),
        'view_cart'           => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'view_item'           => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'view_item_list'      => array(
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_list_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_list_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true]
        ),
        'view_promotion'      => array(
            ['name' => 'creative_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'creative_slot', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'location_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_name', 'input_type' => 'string', 'required' => false]
        ),
    ),
    'Retail/Ecommerce' => array(
        'add_payment_info'    => array(
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'payment_type', 'input_type' => 'string', 'required' => false],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'add_shipping_info'   => array(
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'shipping_tier', 'input_type' => 'string', 'required' => false],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'add_to_cart'         => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'add_to_wishlist'     => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'begin_checkout'      => array(
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'generate_lead'       => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => false],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'value', 'input_type' => 'float', 'required' => false]
        ),
        'purchase'            => array(
            ['name' => 'affiliation', 'input_type' => 'string', 'required' => false],
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'shipping', 'input_type' => 'float', 'required' => false],
            ['name' => 'tax', 'input_type' => 'float', 'required' => false],
            ['name' => 'transaction_id', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'refund'              => array(
            ['name' => 'affiliation', 'input_type' => 'string', 'required' => false],
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => false],
            ['name' => 'shipping', 'input_type' => 'float', 'required' => false],
            ['name' => 'tax', 'input_type' => 'float', 'required' => false],
            ['name' => 'transaction_id', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => false]
        ),
        'remove_from_cart'    => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'select_item'         => array(
            ['name' => 'item_list_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_list_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true]
        ),
        'select_promotion'    => array(
            ['name' => 'creative_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'creative_slot', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'location_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_name', 'input_type' => 'string', 'required' => false]
        ),
        'view_cart'           => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'view_item'           => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'view_item_list'      => array(
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_list_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_list_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true]
        ),
        'view_promotion'      => array(
            ['name' => 'creative_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'creative_slot', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'location_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_name', 'input_type' => 'string', 'required' => false]
        ),
    ),
    'Travel (Hotel/Air)' => array(
        'add_payment_info'    => array(
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'payment_type', 'input_type' => 'string', 'required' => false],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'add_shipping_info'   => array(
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'shipping_tier', 'input_type' => 'string', 'required' => false],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'add_to_cart'         => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'add_to_wishlist'     => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'begin_checkout'      => array(
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'generate_lead'       => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => false],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'value', 'input_type' => 'float', 'required' => false]
        ),
        'purchase'            => array(
            ['name' => 'affiliation', 'input_type' => 'string', 'required' => false],
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'shipping', 'input_type' => 'float', 'required' => false],
            ['name' => 'tax', 'input_type' => 'float', 'required' => false],
            ['name' => 'transaction_id', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'refund'              => array(
            ['name' => 'affiliation', 'input_type' => 'string', 'required' => false],
            ['name' => 'coupon', 'input_type' => 'string', 'required' => false],
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => false],
            ['name' => 'shipping', 'input_type' => 'float', 'required' => false],
            ['name' => 'tax', 'input_type' => 'float', 'required' => false],
            ['name' => 'transaction_id', 'input_type' => 'string', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => false]
        ),
        'remove_from_cart'    => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'select_item'         => array(
            ['name' => 'item_list_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_list_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true]
        ),
        'select_promotion'    => array(
            ['name' => 'creative_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'creative_slot', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'location_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_name', 'input_type' => 'string', 'required' => false]
        ),
        'view_cart'           => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'view_item'           => array(
            ['name' => 'currency', 'input_type' => 'string', 'required' => true],
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'value', 'input_type' => 'float', 'required' => true]
        ),
        'view_item_list'      => array(
            ['name' => 'google_business_vertical', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_list_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'item_list_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true]
        ),
        'view_promotion'      => array(
            ['name' => 'creative_name', 'input_type' => 'string', 'required' => false],
            ['name' => 'creative_slot', 'input_type' => 'string', 'required' => false],
            ['name' => 'items', 'input_type' => 'array', 'required' => true],
            ['name' => 'location_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_id', 'input_type' => 'string', 'required' => false],
            ['name' => 'promotion_name', 'input_type' => 'string', 'required' => false]
        ),
    ),
);

