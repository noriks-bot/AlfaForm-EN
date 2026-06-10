<?php
/**
 * Reddit Event Definitions
 * 
 * This file contains event definitions for Reddit Pixel.
 * Used by both legacy UI and EST (Event Setup Tool).
 * 
 * @package PixelYourSite
 */

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

return array(
    'Custom' => array(
        array( 'type' => 'input', 'label' => 'itemCount', 'name' => 'pys[event][reddit_params][itemCount]', 'input_type' => 'int', 'required' => false ),
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]', 'input_type' => 'string', 'required' => false ),
    ),
    '' => array(),
    'AddToCart' => array(
        array( 'type' => 'input', 'label' => 'itemCount', 'name' => 'pys[event][reddit_params][itemCount]', 'input_type' => 'int', 'required' => false ),
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]', 'input_type' => 'string', 'required' => false ),
    ),
    'AddToWishlist' => array(
        array( 'type' => 'input', 'label' => 'itemCount', 'name' => 'pys[event][reddit_params][itemCount]', 'input_type' => 'int', 'required' => false ),
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]', 'input_type' => 'string', 'required' => false ),
    ),
    'Lead' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]', 'input_type' => 'string', 'required' => false ),
    ),
    'Purchase' => array(
        array( 'type' => 'input', 'label' => 'itemCount', 'name' => 'pys[event][reddit_params][itemCount]', 'input_type' => 'int', 'required' => false ),
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]', 'input_type' => 'float', 'required' => true ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]', 'input_type' => 'string', 'required' => true ),
    ),
    'Search' => array(),
    'SignUp' => array(
        array( 'type' => 'input', 'label' => 'value', 'name' => 'pys[event][reddit_params][value]', 'input_type' => 'float', 'required' => false ),
        array( 'type' => 'input', 'label' => 'currency', 'name' => 'pys[event][reddit_params][currency]', 'input_type' => 'string', 'required' => false ),
    ),
    'ViewContent' => array(),

);

