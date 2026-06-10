<?php
/**
 * TikTok Event Definitions
 * 
 * This file contains event definitions for TikTok Pixel.
 * Used by both legacy UI and EST (Event Setup Tool).
 * 
 * @package PixelYourSite
 */

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

return [
    'CustomEvent'           => [],
    ''  => [],
    'AddPaymentInfo'        => [],
    'AddToCart'             => [
        ['type'=>'input','label'=>'content_type','name'=>'pys[event][tiktok_params][content_type]'],
        ['type'=>'input','label'=>'quantity','name'=>'pys[event][tiktok_params][quantity]'],
        ['type'=>'input','label'=>'content_id','name'=>'pys[event][tiktok_params][content_id]'],
        ['type'=>'input','label'=>'value','name'=>'pys[event][tiktok_params][value]'],
        ['type'=>'input','label'=>'currency','name'=>'pys[event][tiktok_params][currency]'],
    ],
    'AddToWishlist'         => [],
    'ApplicationApproval'   => [],
    'ClickButton'           => [],
    'CompletePayment'       => [
        ['type'=>'input','label'=>'content_type','name'=>'pys[event][tiktok_params][content_type]'],
        ['type'=>'input','label'=>'quantity','name'=>'pys[event][tiktok_params][quantity]'],
        ['type'=>'input','label'=>'content_id','name'=>'pys[event][tiktok_params][content_id]'],
        ['type'=>'input','label'=>'value','name'=>'pys[event][tiktok_params][value]'],
        ['type'=>'input','label'=>'currency','name'=>'pys[event][tiktok_params][currency]'],
    ],
    'CompleteRegistration'  => [],
    'Contact'               => [],
    'CustomizeProduct'      => [],
    'Download'              => [],
    'FindLocation'          => [],
    'InitiateCheckout'      => [],
    'PlaceAnOrder'          => [
        ['type'=>'input','label'=>'content_type','name'=>'pys[event][tiktok_params][content_type]'],
        ['type'=>'input','label'=>'quantity','name'=>'pys[event][tiktok_params][quantity]'],
        ['type'=>'input','label'=>'content_id','name'=>'pys[event][tiktok_params][content_id]'],
        ['type'=>'input','label'=>'value','name'=>'pys[event][tiktok_params][value]'],
        ['type'=>'input','label'=>'currency','name'=>'pys[event][tiktok_params][currency]'],
    ],
    'Purchase'              => [
        ['type'=>'input','label'=>'content_type','name'=>'pys[event][tiktok_params][content_type]'],
        ['type'=>'input','label'=>'quantity','name'=>'pys[event][tiktok_params][quantity]'],
        ['type'=>'input','label'=>'content_id','name'=>'pys[event][tiktok_params][content_id]'],
        ['type'=>'input','label'=>'value','name'=>'pys[event][tiktok_params][value]'],
        ['type'=>'input','label'=>'currency','name'=>'pys[event][tiktok_params][currency]'],
    ],
    'Schedule'              => [],
    'Search'                => [
        ['type'=>'input','label'=>'search_string','name'=>'pys[event][tiktok_params][search_string]']
    ],
    'StartTrial'            => [
        ['type'=>'input','label'=>'content_ids','name'=>'pys[event][tiktok_params][content_ids]'],
        ['type'=>'input','label'=>'value','name'=>'pys[event][tiktok_params][value]'],
        ['type'=>'input','label'=>'currency','name'=>'pys[event][tiktok_params][currency]'],
    ],
    'SubmitApplication'     => [],
    'SubmitForm'            => [],
    'Subscribe'             => [],
    'ViewContent'           => [
        ['type'=>'input','label'=>'content_type','name'=>'pys[event][tiktok_params][content_type]'],
        ['type'=>'input','label'=>'quantity','name'=>'pys[event][tiktok_params][quantity]'],
        ['type'=>'input','label'=>'content_id','name'=>'pys[event][tiktok_params][content_id]'],
        ['type'=>'input','label'=>'value','name'=>'pys[event][tiktok_params][value]'],
        ['type'=>'input','label'=>'currency','name'=>'pys[event][tiktok_params][currency]'],
    ],
];

