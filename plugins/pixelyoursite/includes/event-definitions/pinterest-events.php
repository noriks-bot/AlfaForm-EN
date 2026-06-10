<?php
/**
 * Pinterest Event Definitions
 * 
 * This file contains event definitions for Pinterest Pixel.
 * Used by both legacy UI and EST (Event Setup Tool).
 * 
 * @package PixelYourSite
 */

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

return array(
    'custom' => array(),
    '' => array(),
    'addtocart' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][pinterest_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][pinterest_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'product_id', 'name' => 'pys[event][pinterest_params][product_id]', 'input_type' => 'int', 'required' => false ),
    ),
    'checkout' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][pinterest_params][value]', 'input_type' => 'float', 'required' => true ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][pinterest_params][currency]', 'input_type' => 'string', 'required' => true ),
        array( 'type' => 'input', 'label' => 'order_quantity', 'name' => 'pys[event][pinterest_params][order_quantity]', 'input_type' => 'int', 'required' => false ),
    ),
    'lead' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][pinterest_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][pinterest_params][currency]', 'input_type' => 'string', 'required' => false ),
    ),
    'pagevisit' => array(),
    'partner_defined' => array(),
    'search' => array(
        array( 'type' => 'input', 'label' => 'search_query', 'name' => 'pys[event][pinterest_params][search_query]', 'input_type' => 'string', 'required' => false ),
    ),
    'signup' => array(),
    'viewcategory' => array(),
    'viewcontent' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][pinterest_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][pinterest_params][currency]', 'input_type' => 'string', 'required' => false ),
        array( 'type' => 'input', 'label' => 'product_id', 'name' => 'pys[event][pinterest_params][product_id]', 'input_type' => 'int', 'required' => false ),
    ),
    'watchvideo' => array(),
);

