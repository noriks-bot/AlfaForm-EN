<?php
/**
 * Bing Event Definitions
 * 
 * This file contains event definitions for Bing Ads UET (Universal Event Tracking).
 * Used by both legacy UI and EST (Event Setup Tool).
 * 
 * @package PixelYourSite
 */

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

return array(
    'Custom' => array(),
    '' => array(),
    'AddToCart' => array(
        array( 'type' => 'input', 'label' => 'event_category', 'name' => 'pys[event][bing_params][event_category]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'event_label', 'name' => 'pys[event][bing_params][event_label]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_prodid', 'name' => 'pys[event][bing_params][ecomm_prodid]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_pagetype', 'name' => 'pys[event][bing_params][ecomm_pagetype]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_totalvalue', 'name' => 'pys[event][bing_params][ecomm_totalvalue]', 'input_type' => 'float', 'required' => false ),
    ),
    'CompleteRegistration' => array(),
    'Contact' => array(),
    'InitiateCheckout' => array(
        array( 'type' => 'input', 'label' => 'event_category', 'name' => 'pys[event][bing_params][event_category]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'event_label', 'name' => 'pys[event][bing_params][event_label]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_prodid', 'name' => 'pys[event][bing_params][ecomm_prodid]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_pagetype', 'name' => 'pys[event][bing_params][ecomm_pagetype]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_totalvalue', 'name' => 'pys[event][bing_params][ecomm_totalvalue]', 'input_type' => 'float', 'required' => false ),
    ),
    'PageVisit' => array(),
    'Purchase' => array(
        array( 'type' => 'input', 'label' => 'event_category', 'name' => 'pys[event][bing_params][event_category]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'event_label', 'name' => 'pys[event][bing_params][event_label]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][bing_params][currency]', 'input_type' => 'string', 'required' => true ),
        array( 'type' => 'input', 'label' => 'ecomm_prodid', 'name' => 'pys[event][bing_params][ecomm_prodid]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_pagetype', 'name' => 'pys[event][bing_params][ecomm_pagetype]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_totalvalue', 'name' => 'pys[event][bing_params][ecomm_totalvalue]', 'input_type' => 'float', 'required' => true ),
        array( 'type' => 'input', 'label' => 'transaction_id', 'name' => 'pys[event][bing_params][transaction_id]', 'input_type' => 'string', 'required' => false ),
    ),
    'ViewContent' => array(
        array( 'type' => 'input', 'label' => 'event_category', 'name' => 'pys[event][bing_params][event_category]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'event_label', 'name' => 'pys[event][bing_params][event_label]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'event_value', 'name' => 'pys[event][bing_params][event_value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_prodid', 'name' => 'pys[event][bing_params][ecomm_prodid]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'ecomm_pagetype', 'name' => 'pys[event][bing_params][ecomm_pagetype]', 'input_type' => 'string', 'required' => false ),
    ),
);

