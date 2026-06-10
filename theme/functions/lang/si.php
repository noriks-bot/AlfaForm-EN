<?php

add_filter( 'gettext', 'translate_attribute_labels_si', 20, 3 );

function translate_attribute_labels_si( $translated_text, $text, $domain ) {
    if ( $text === 'Choose your size' ) {
        $translated_text = 'Velikost';
    }
    return $translated_text;
}

add_filter( 'woocommerce_checkout_fields', 'custom_billing_phone_placeholder_si' );
function custom_billing_phone_placeholder_si( $fields ) {
    $fields['billing']['billing_phone']['placeholder'] = 'Telefonska številka';
    return $fields;
}

add_filter( 'woocommerce_order_number', 'change_woocommerce_order_number_si' );
function change_woocommerce_order_number_si( $order_id ) {
    return 'NORIKS-SI-' . $order_id;
}

add_filter( 'default_checkout_billing_country', '__return_si_country' );
add_filter( 'default_checkout_shipping_country', '__return_si_country' );
function __return_si_country() {
    return 'SI';
}

add_filter( 'woocommerce_checkout_fields', 'fix_country_to_slovenia_and_hide' );
function fix_country_to_slovenia_and_hide( $fields ) {
    WC()->customer->set_billing_country( 'SI' );
    WC()->customer->set_shipping_country( 'SI' );

    unset( $fields['billing']['billing_country'] );
    unset( $fields['shipping']['shipping_country'] );

    return $fields;
}

add_filter( 'woocommerce_checkout_fields', 'hide_checkout_fields_si' );
function hide_checkout_fields_si( $fields ) {
    unset( $fields['billing']['billing_state'] );
    unset( $fields['shipping']['shipping_state'] );
    return $fields;
}
