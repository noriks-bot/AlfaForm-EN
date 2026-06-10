<?php
/**
 * Plugin Name: Color Quantity Bundle Builder
 * Description: WooCommerce bundle product where users select quantity and choose colors with images.
 * Version: 1.3
 * Author: Your Name
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Enqueue styles and scripts
add_action( 'wp_enqueue_scripts', function() {
    
    if ( ! is_product() ) return;

    global $post;
    if ( empty( $post ) ) return;

    $product = wc_get_product( $post->ID );
    if ( ! $product || 'yes' !== $product->get_meta( '_enable_bundle_builder' ) ) return;
    
    
     if ($product->get_meta('_enable_bundle_builder') !== 'yes') return;
    
    if ( is_product() ) {
        wp_enqueue_style( 'bundle-style', plugin_dir_url(__FILE__) . 'assets/style.css?343233333v' );
        wp_enqueue_script( 'bundle-script', plugin_dir_url(__FILE__) . 'assets/bundle.js?d5555d3', ['jquery'], null, true );
    }
    
    
});

// Admin checkbox in product edit screen
add_action('woocommerce_product_options_general_product_data', function() {
    woocommerce_wp_checkbox([
        'id' => '_enable_bundle_builder',
        'label' => __('Enable Color Quantity Bundle', 'custom-bundle'),
        'desc_tip' => true,
        'description' => __('Enable bundle color picker with quantity limits.')
    ]);
});
add_action('woocommerce_process_product_meta', function($post_id) {
    $value = isset($_POST['_enable_bundle_builder']) ? 'yes' : 'no';
    update_post_meta($post_id, '_enable_bundle_builder', $value);
});


add_action('woocommerce_checkout_create_order_line_item', function($item, $cart_item_key, $values, $order) {
    if (!empty($values['bundle_colors'])) {
        foreach ($values['bundle_colors'] as $color => $qty) {
            $item->add_meta_data(ucfirst($color), $qty . ' kom', true);
        }
    }
}, 10, 4);






/********** */

add_action('woocommerce_single_variation', 'move_quantity_after_title', 6);

function move_quantity_after_title() {
    if (!is_product()) return;

    // Ensure WooCommerce functions are available
    global $product;

    // Start output buffering
    ob_start();
    woocommerce_quantity_input(array(), $product, true);
    $quantity_html = ob_get_clean();

    echo '<div class="first-qty  custom-quantity-after-title">' . $quantity_html . '</div>';
}

// Remove default quantity field from its original location
add_action('woocommerce_before_single_product', 'remove_default_quantity');

function remove_default_quantity() {
    remove_action('woocommerce_before_add_to_cart_button', 'woocommerce_quantity_input', 10);
}




add_action( 'wp_footer', function () {
    if ( ! is_product() ) return;

    global $post;
    if ( empty( $post ) ) return;

    $product = wc_get_product( $post->ID );
    if ( ! $product || 'yes' !== $product->get_meta( '_enable_bundle_builder' ) ) return;
    
    
     if ($product->get_meta('_enable_bundle_builder') !== 'yes') return;
    ?>
    <script>
    jQuery(function($){
        function disableATC(){
            var $btn = $('form.cart').find('.single_add_to_cart_button, [name="add-to-cart"], [type="submit"][name="add-to-cart"]');
            if ($btn.length){
                $btn.attr('disabled','disabled').prop('disabled', true).addClass('cqbf-disabled');
            }
        }
        disableATC();
        $(document.body).on('found_variation reset_data show_variation wc_fragment_refresh wc_fragments_refreshed', disableATC);
    });
    </script>
    <style>
    .cqbf-disabled { opacity:.6; cursor:not-allowed; pointer-events:none; }
    </style>
    <?php
}, 99 );




/*****    ****/




// Frontend bundle UI
add_action('woocommerce_before_add_to_cart_button', function() {
    global $product;
    if ($product->get_meta('_enable_bundle_builder') !== 'yes') return;

    //  Add your image URLs here
    $colors = [
        'Črna' => '/si/wp-content/uploads/2025/07/black-1.png',
        'Bela' => '/si/wp-content/uploads/2025/07/white-1.png',
        'Siva' =>  '/si/wp-content/uploads/2025/07/gray-1.png',
        'Temno modra' => '/si/wp-content/uploads/2025/07/blue-1.png',
        'Zelena' => '/si/wp-content/uploads/2025/07/green-1.png',
        'Bež' => '/si/wp-content/uploads/2025/05/one-beige-1-1.png',

    ];

    echo '<div id="bundle-builder-qty" data-max="1">
        <h3>Odaberite svoje boje</h3>
        <div class="bundle-grid">';

    foreach ($colors as $color => $image_url) {
        echo '<div class="bundle-item" data-color="'. esc_attr($color) .'">
            <div class="bundle-image">
                <img src="'. esc_url($image_url) .'" alt="'. esc_attr($color) .'" />
            </div>
            <div class="bundle-color-name">'. esc_html($color) .'</div>
            <div class="qty-controls">
                <button type="button" class="minus">-</button>
                <input  class="no-spinner" type="number" name="bundle_colors['. esc_attr($color) .']" value="0" min="0" />
                <button type="button" class="plus">+</button>
            </div>
        </div>';
    }

    echo '</div>
        <p class="remaining">Odabrano 0 of 0 komada</p>
        <input type="hidden" name="bundle_colors_json" id="bundle_colors_json" value="" />
    </div>';
}, 20);

// Save bundle selection to cart
add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id, $variation_id) {
    if (!empty($_POST['bundle_colors'])) {
        $colors = array_map('intval', $_POST['bundle_colors']);
        $filtered = array_filter($colors, function($qty) { return $qty > 0; });
        $cart_item_data['bundle_colors'] = $filtered;
    }
    return $cart_item_data;
}, 10, 3);

// Display in cart/checkout
add_filter('woocommerce_get_item_data', function($item_data, $cart_item) {
    if (!empty($cart_item['bundle_colors'])) {
        foreach ($cart_item['bundle_colors'] as $color => $qty) {
            $item_data[] = [
                'name' => ucfirst($color),
                'value' => $qty . ' kom',
            ];
        }
    }
    return $item_data;
}, 10, 2);
