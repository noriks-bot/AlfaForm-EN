<?php
/**
 * Facebook Event Definitions
 * 
 * This file contains event definitions for Facebook Pixel.
 * Used by both legacy UI and EST (Event Setup Tool).
 * 
 * @package PixelYourSite
 */

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

return array(
    'CustomEvent' => array(),
    '' => array(),
    'AddPaymentInfo' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_category', 'name' => 'pys[event][facebook_params][content_category]', 'input_type' => 'string', 'required' => false ),
    ),
    'AddToCart' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_name', 'name' => 'pys[event][facebook_params][content_name]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_ids', 'name' => 'pys[event][facebook_params][content_ids]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_type', 'name' => 'pys[event][facebook_params][content_type]', 'input_type' => 'string', 'required' => false ),
    ),
    'AddToWishlist' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_name', 'name' => 'pys[event][facebook_params][content_name]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_ids', 'name' => 'pys[event][facebook_params][content_ids]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_category', 'name' => 'pys[event][facebook_params][content_category]', 'input_type' => 'string', 'required' => false ),
    ),
    'CompleteRegistration' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_name', 'name' => 'pys[event][facebook_params][content_name]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'status', 'name' => 'pys[event][facebook_params][status]', 'input_type' => 'string', 'required' => false ),
    ),
    'Contact' => array(),
    'CustomizeProduct' => array(),
    'Donate' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
    ),
    'FindLocation' => array(),
    'InitiateCheckout' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_name', 'name' => 'pys[event][facebook_params][content_name]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_ids', 'name' => 'pys[event][facebook_params][content_ids]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_type', 'name' => 'pys[event][facebook_params][content_type]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_category', 'name' => 'pys[event][facebook_params][content_category]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'num_items', 'name' => 'pys[event][facebook_params][num_items]', 'input_type' => 'int', 'required' => false ),
    ),
    'Lead' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_name', 'name' => 'pys[event][facebook_params][content_name]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_category', 'name' => 'pys[event][facebook_params][content_category]', 'input_type' => 'string', 'required' => false ),
    ),
    'Purchase' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => true ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => true ),
        array( 'type' => 'input', 'label' => 'content_name', 'name' => 'pys[event][facebook_params][content_name]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_ids', 'name' => 'pys[event][facebook_params][content_ids]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_type', 'name' => 'pys[event][facebook_params][content_type]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'num_items', 'name' => 'pys[event][facebook_params][num_items]', 'input_type' => 'int', 'required' => false ),
        array( 'type' => 'input', 'label' => 'order_id', 'name' => 'pys[event][facebook_params][order_id]', 'input_type' => 'string', 'required' => false ),
    ),
    'Schedule' => array(),
    'Search' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_category', 'name' => 'pys[event][facebook_params][content_category]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'search_string', 'name' => 'pys[event][facebook_params][search_string]', 'input_type' => 'string', 'required' => false ),
    ),
    'StartTrial' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'predicted_ltv', 'name' => 'pys[event][facebook_params][predicted_ltv]', 'input_type' => 'float', 'required' => false ),
    ),
    'SubmitApplication' => array(),
    'Subscribe' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'predicted_ltv', 'name' => 'pys[event][facebook_params][predicted_ltv]', 'input_type' => 'float', 'required' => false ),
    ),
    'ViewContent' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][facebook_params][value]', 'input_type' => 'float', 'required' => true ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][facebook_params][currency]', 'input_type' => 'string', 'required' => true ),
        array( 'type' => 'input', 'label' => 'content_name', 'name' => 'pys[event][facebook_params][content_name]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_ids', 'name' => 'pys[event][facebook_params][content_ids]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'content_type', 'name' => 'pys[event][facebook_params][content_type]', 'input_type' => 'string', 'required' => false ),
    ),

);

