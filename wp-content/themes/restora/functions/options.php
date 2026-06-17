<?php


if (function_exists('acf_add_options_page')) {

    // Main menu: Content Manager
    acf_add_options_page(array(
        'page_title'    => 'Content Manager',
        'menu_title'    => 'Content Manager',
        'menu_slug'     => 'content-manager',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'position'      => 2, // Optional: adjust position in admin menu
        'icon_url'      => 'dashicons-admin-generic' // Optional
    ));

    // Sub page: Header
    acf_add_options_sub_page(array(
        'page_title'    => 'Header Settings',
        'menu_title'    => 'Header',
        'parent_slug'   => 'content-manager',
    ));
    
    acf_add_options_sub_page(array(
        'page_title'    => 'Shop page',
        'menu_title'    => 'Shop',
        'parent_slug'   => 'content-manager',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Table setting',
        'menu_title'    => 'Table',
        'parent_slug'   => 'content-manager',
    ));

    // Sub page: Footer
    acf_add_options_sub_page(array(
        'page_title'    => 'Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'content-manager',
    ));

    // Sub page: FAQ
    acf_add_options_sub_page(array(
        'page_title'    => 'FAQ Settings',
        'menu_title'    => 'FAQ',
        'parent_slug'   => 'content-manager',
    ));
    
    // Sub page: Big reviews
    acf_add_options_sub_page(array(
        'page_title'    => 'Big reviews',
        'menu_title'    => 'Big reviews',
        'parent_slug'   => 'content-manager',
    ));
    
    // Sub page: Single product page
    acf_add_options_sub_page(array(
        'page_title'    => 'Single product',
        'menu_title'    => 'Single product',
        'parent_slug'   => 'content-manager',
    ));

    // Sub page: Social
    acf_add_options_sub_page(array(
        'page_title'    => 'Social Links',
        'menu_title'    => 'Social',
        'parent_slug'   => 'content-manager',
    ));
    
    // Sub page: Language
    acf_add_options_sub_page(array(
        'page_title'    => 'Language settings',
        'menu_title'    => 'Language settings',
        'parent_slug'   => 'content-manager',
    ));
    
    // Sub page: QTY discounts
    acf_add_options_sub_page(array(
        'page_title'    => 'QTY discounts',
        'menu_title'    => 'QTY discounts',
        'parent_slug'   => 'content-manager',
    ));
    
    // Sub page: Checkout
    acf_add_options_sub_page(array(
        'page_title'    => 'Checkout settings',
        'menu_title'    => 'Checkout settings',
        'parent_slug'   => 'content-manager',
    ));
    
    // Sub page: Size chart modal
    acf_add_options_sub_page(array(
        'page_title'    => 'Size chart modal',
        'menu_title'    => 'Size chart modal',
        'parent_slug'   => 'content-manager',
    ));
    
    
}