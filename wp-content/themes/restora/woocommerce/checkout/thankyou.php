<?php
/**
 * Thankyou page — Post-purchase upsell with two-step flow
 *
 * Step 1: Single product offer (boksarice)
 * Step 2: 6-product grid (after "Ne želim" or after adding 1 item)
 *
 * Style: Red background, no border-radius, red buttons
 *
 * @package WooCommerce\Templates
 * @version 8.1.0
 * @var WC_Order $order
 */
defined( 'ABSPATH' ) || exit;

// ─── Upsell product config — detect what to offer ───
// Check if order has ONLY boksarice (no majice, no komplet)
$has_only_boksarice = true;
$has_boksarice = false;
foreach ( $order->get_items() as $item ) {
    $name = strtolower( $item->get_name() );
    $product = $item->get_product();
    $sku = $product ? strtolower( $product->get_sku() ) : '';
    // Check if item is majica
    // Categories are the source of truth
    $cats = wp_get_post_terms( $item->get_product_id(), 'product_cat', array('fields' => 'slugs') );
    $cat_str = is_array($cats) ? strtolower(implode(' ', $cats)) : '';
    // Majica: category has "majic" OR name has "majic"
    $is_majica = ( strpos($cat_str, 'majic') !== false || strpos($name, 'majic') !== false );
    // Boksarice: category has "boxer/bokser/orto" OR SKU has "box" OR name has "bokser/airflow"
    $is_boks = ( strpos($cat_str, 'boxer') !== false || strpos($cat_str, 'boksaric') !== false || strpos($cat_str, 'orto') !== false || strpos($sku, 'box') !== false || strpos($name, 'boksaric') !== false || strpos($name, 'airflow') !== false );
    // Komplet
    $is_komplet = ( strpos($name, 'paket') !== false || strpos($cat_str, 'paket') !== false );
    if ( $is_boks ) $has_boksarice = true;
    if ( $is_majica || $is_komplet ) $has_only_boksarice = false;
}
if ( !$has_boksarice ) $has_only_boksarice = false;

// ONLY boksarice in order → upsell MAJICE, else → upsell BOKSERICE
$upsell_is_majice = $has_only_boksarice;

if ( $upsell_is_majice ) {
    $upsell_product_id = 250; // Crna majica (variable)
    $upsell_name       = 'Crne Majice';
    $upsell_qty_prices = array( 1 => 12.99, 3 => 29.99, 6 => 39.99 );
    $upsell_qty_names  = array( 1 => '1x Crna Majica', 3 => '3x Crne Majice', 6 => '6x Crnih Majica' );
    $upsell_qty_images = array(
        1 => 'https://noriks.com/si/wp-content/uploads/2025/09/black-1.jpg',
        3 => 'https://noriks.com/si/wp-content/uploads/2025/09/black-3x.jpg',
        6 => 'https://noriks.com/si/wp-content/uploads/2026/01/15xcrnamajica.png',
    );
    $upsell_title_text = 'Dodaj majice zdaj – 50% popusta';
} else {
    $upsell_product_id = 2781; // Crne Boksarice
    $upsell_name       = 'Crne Boksarice';
    $upsell_qty_prices = array( 1 => 4.99, 3 => 14.97, 5 => 24.95 );
    $upsell_qty_names  = array( 1 => '1x Crne Boksarice', 3 => '3x Crne Boksarice', 5 => '5x Crnih Bokseric' );
    $upsell_qty_images = array(
        1 => 'https://noriks.com/si/wp-content/uploads/2025/11/crne-boksarice-produktna.jpg',
        3 => 'https://noriks.com/si/wp-content/uploads/2025/11/boksarice_3x_crne.png',
        5 => 'https://noriks.com/si/wp-content/uploads/2026/01/boksarice_5x_crne.png',
    );
    $upsell_title_text = 'Dodaj boksarice zdaj – 50% popusta';
}
$upsell_product    = wc_get_product( $upsell_product_id );
$upsell_image      = $upsell_qty_images[1];
// Get unit price from first variation (variable products have empty parent price)
$upsell_unit_price = 15.99;
if ( $upsell_product && $upsell_product->is_type('variable') ) {
    $var_prices = $upsell_product->get_variation_prices();
    $upsell_unit_price = !empty($var_prices['regular_price']) ? (float) reset($var_prices['regular_price']) : (float) $upsell_product->get_price();
} elseif ( $upsell_product ) {
    $upsell_unit_price = (float) $upsell_product->get_regular_price() ?: (float) $upsell_product->get_price();
}
$upsell_sale_price = $upsell_qty_prices[1];
// Regular prices per qty (unit price * qty)
$upsell_qty_regular = array();
foreach ($upsell_qty_prices as $q => $p) {
    $upsell_qty_regular[$q] = $upsell_unit_price * $q;
}
$default_qty = array_key_first($upsell_qty_prices); // 1

// Helper: extract a size value (S/M/L/XL/...) from any associative array.
// Works for both variation attribute arrays and line item meta arrays.
// Pass 1: attribute KEY hints (velicina / size / marime / vel / meret).
// Pass 2: scan VALUES — direct match against size patterns, OR token
//         match (so bundle / orto values like "Crna - M" or
//         "Μαύρο - 3XL" still yield the size).
if ( ! function_exists( 'noriks_extract_size_value' ) ) {
    function noriks_extract_size_value( $attrs ) {
        if ( ! is_array( $attrs ) || empty( $attrs ) ) return '';

        $size_key_hints = array( 'velicina', 'size', 'marime', 'vel', 'meret' );
        $size_patterns  = array( 'xs', 's', 'm', 'l', 'xl', 'xxl', 'xxxl', 'xxxxl', '2xl', '3xl', '4xl', '5xl' );

        // Pass 1: KEY hints — when an attribute key clearly names size,
        // accept its value (token-extracted if the value is composite)
        foreach ( $attrs as $k => $v ) {
            $kl = strtolower( (string) $k );
            $key_is_size = false;
            foreach ( $size_key_hints as $hint ) {
                if ( strpos( $kl, $hint ) !== false ) { $key_is_size = true; break; }
            }
            if ( ! $key_is_size ) continue;
            $vs = trim( (string) $v );
            if ( $vs === '' ) continue;
            if ( in_array( strtolower( $vs ), $size_patterns, true ) ) return $vs;
            // Token scan inside the value
            $tokens = preg_split( '/[\s\-,;\/|·_]+/u', $vs );
            if ( is_array( $tokens ) ) {
                foreach ( $tokens as $tok ) {
                    $tok = trim( $tok );
                    if ( $tok !== '' && in_array( strtolower( $tok ), $size_patterns, true ) ) {
                        return $tok;
                    }
                }
            }
            // Size-keyed attribute, no recognised token in value — return
            // the raw value so it still drives the dropdown selection.
            return $vs;
        }

        // Pass 2: scan all VALUES — direct or tokenised match
        foreach ( $attrs as $v ) {
            $vs = trim( (string) $v );
            if ( $vs === '' ) continue;
            if ( in_array( strtolower( $vs ), $size_patterns, true ) ) return $vs;
            $tokens = preg_split( '/[\s\-,;\/|·_]+/u', $vs );
            if ( is_array( $tokens ) ) {
                foreach ( $tokens as $tok ) {
                    $tok = trim( $tok );
                    if ( $tok !== '' && in_array( strtolower( $tok ), $size_patterns, true ) ) {
                        return $tok;
                    }
                }
            }
        }

        return '';
    }
}

// Variations for primary product
$upsell_variations = array();
if ( $upsell_product && $upsell_product->is_type('variable') ) {
    foreach ( $upsell_product->get_available_variations() as $v ) {
        $size = noriks_extract_size_value( isset( $v['attributes'] ) ? $v['attributes'] : array() );
        $upsell_variations[] = array( 'id' => $v['variation_id'], 'size' => $size );
    }
}

// Detect customer size from order — first ordered product that yields a
// recognised size wins. We try FIVE sources per item, in order:
//   (A) variation attributes (variable products: bokserice, tricou)
//   (B) raw line item meta (bundle / orto: "Crna - M", "Μαύρο - 3XL")
//   (C) formatted meta display values (covers private/underscored keys)
//   (D) product name (e.g. "Tricou Negru M")
//   (E) SKU (e.g. "BOX-3XL", "NORIKS-SHIRTS-M")
// If a sized clothing item is in the cart, one of these will hit.
$customer_size = '';
if ( $order ) {
    foreach ( $order->get_items() as $item ) {
        if ( ! is_a( $item, 'WC_Order_Item_Product' ) ) continue;

        $detected = '';

        // (A) Variation attributes
        if ( $item->get_variation_id() ) {
            $var = wc_get_product( $item->get_variation_id() );
            if ( $var ) {
                $detected = noriks_extract_size_value( (array) $var->get_attributes() );
            }
        }

        // (B) Raw line item meta (handles bundle / orto)
        if ( $detected === '' ) {
            $meta_values = array();
            foreach ( $item->get_meta_data() as $meta ) {
                $key = is_object( $meta ) && isset( $meta->key ) ? (string) $meta->key : '';
                $val = ( is_object( $meta ) && isset( $meta->value ) && is_scalar( $meta->value ) ) ? (string) $meta->value : '';
                if ( $key !== '' ) {
                    $meta_values[ $key ] = $val;
                }
            }
            if ( ! empty( $meta_values ) ) {
                $detected = noriks_extract_size_value( $meta_values );
            }
        }

        // (C) Formatted meta display values
        if ( $detected === '' ) {
            $fmt = array();
            $list = $item->get_formatted_meta_data( '', true );
            if ( is_array( $list ) ) {
                $i = 0;
                foreach ( $list as $m ) {
                    if ( ! is_object( $m ) ) continue;
                    $key = isset( $m->key ) ? (string) $m->key : '';
                    $val = isset( $m->display_value ) ? wp_strip_all_tags( (string) $m->display_value ) : '';
                    if ( $val === '' ) continue;
                    $fmt[ $key !== '' ? $key : 'fmt_' . $i ] = $val;
                    $i++;
                }
            }
            if ( ! empty( $fmt ) ) {
                $detected = noriks_extract_size_value( $fmt );
            }
        }

        // (D) Product name
        if ( $detected === '' ) {
            $name = (string) $item->get_name();
            if ( $name !== '' ) {
                $detected = noriks_extract_size_value( array( 'name' => $name ) );
            }
        }

        // (E) SKU
        if ( $detected === '' ) {
            $product = $item->get_product();
            if ( $product ) {
                $sku = (string) $product->get_sku();
                if ( $sku !== '' ) {
                    $detected = noriks_extract_size_value( array( 'sku' => $sku ) );
                }
            }
        }

        if ( $detected !== '' ) {
            $customer_size = $detected;
            break;
        }
    }
}

// ─── Grid products (6 products for step 2) ───
$grid_product_ids = array();
$ordered_ids = array();
if ( $order ) {
    foreach ( $order->get_items() as $item ) {
        $ordered_ids[] = $item->get_product_id();
    }
}

// Get products for grid — exclude already-ordered
$grid_args = array(
    'status'  => 'publish',
    'limit'   => 6,
    'exclude' => array_merge( $ordered_ids, array( $upsell_product_id ) ),
    'orderby' => 'popularity',
    'type'    => array( 'simple', 'variable' ),
);

// Try boksarice/majice categories first
$grid_products = array();
foreach ( array( 'boksarice', 'boxerice', 'majice', 'majica' ) as $cat_slug ) {
    $cat = get_term_by( 'slug', $cat_slug, 'product_cat' );
    if ( $cat ) {
        $grid_args['category'] = array( $cat_slug );
        $grid_products = wc_get_products( $grid_args );
        if ( count( $grid_products ) >= 6 ) break;
    }
}
// Fallback: any products
if ( count( $grid_products ) < 6 ) {
    unset( $grid_args['category'] );
    $grid_products = wc_get_products( $grid_args );
}
$grid_products = array_slice( $grid_products, 0, 6 );
?>

<!-- vendor upsell CSS removed — using inline styles only -->

<style>
/* ═══ RESET: hide WP chrome ═══ */
.top-header, .marquee, header.navbar.header, #languageModal,
.xoo-wsc-markup, .xoo-wsc-overlay, .footer-wrap, footer.footer,
footer.footer-mobile, .hs_loader, .entry-header,
.storefront-breadcrumb, .storefront-sorting,
#secondary, .site-footer, .xoo-wsc-container,
.checkout--my-header,
.woocommerce-order-details,
.woocommerce-customer-details { display: none !important; }

body.woocommerce-order-received {
    background: #F5F5F5 !important;
    font-family: 'Roboto', sans-serif !important;
    color: #333 !important;
    -webkit-font-smoothing: antialiased;
}
body.woocommerce-order-received .site-main,
body.woocommerce-order-received .hentry {
    margin: 0 !important; padding: 0 !important;
}
body.woocommerce-order-received .woocommerce {
    background: transparent !important; padding: 0 !important;
}

/* border-radius handled per element — removed global kill */

/* ═══ Container ═══ */
.ty-container { max-width: 520px; margin: 30px auto; padding: 0 4px; }

/* ═══ Success ═══ */
.ty-success {
    background: #e8f5e9;
    padding: 6px 8px; margin-bottom: 0; text-align: center;
    border-radius: 4px !important;
}
@media (max-width:576px) { .ty-success { margin-left:0; margin-right:0; padding-left:0; padding-right:0; border-radius:0 !important; } }
.ty-success-icon {
    width: 20px; height: 20px; background: #4CAF50;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 12px; color: #fff; border-radius: 4px;
    vertical-align: middle; margin-right: 6px;
}
.ty-success h1 {
    font-size: 16px !important; font-weight: 700 !important;
    color: #232f3e !important; margin: 0 0 4px !important; display: inline; vertical-align: middle;
}
.ty-success p { font-size: 12px; color: #5f6061; margin: 4px 0 0; }
.ty-success .ty-order-num {
    display: inline-block; margin-top: 6px;
    background: #fff; padding: 4px 12px;
    font-size: 11px; color: #333; font-weight: 600;
}

    /* ═══ UPSELL STEP 1 — inline, no modal ═══ */
    .ty_upsell_one_wrapper { background:#fff; border-radius:4px; margin:0; }
    .ty_upsell_one_wrapper.show { display:block; }
    .ty_upsell_one_wrapper.hide { display:none; }
    .ty_upsell_one_wrapper__popup-content { background:#fff; }
    .tyuo_timer { background-color:#f39c1217; border:2px solid #f39c12; border-radius:4px; color:#000; padding:10px; margin-bottom:15px; text-align:center; }
    .tyuo_timer .timer_wrapper { display:flex; align-items:baseline; justify-content:center; }
    .tyuo_timer .special_offer_txt { font-size:16px; margin-right:5px; color:#000; }
    .tyuo_timer .time { background-color:#e22b26; border-radius:4px; color:#fff; padding:2px 8px; }
    .tyuo_timer .title { font-size:22px; font-weight:700; line-height:26px; margin-bottom:5px; padding-top:10px; text-align:center; color:#000; }
    .tyuo_middle_section { padding:0 5px; text-align:center; }
    .tyuo_middle_section svg { margin-right:5px; max-width:15px; }
    .tyuo_middle_section .sub_title { color:#000; font-size:16px; font-weight:500; }
    .tyuo_middle_section .clue_text { color:#000; font-size:16px; font-weight:500; margin:6px 0; }
    .tyuo_product_section { margin:15px 0; padding:0 15px; }
    .tyuo_product_section .product_data { display:flex; margin-bottom:10px; }
    .tyuo_product_section .product_data .img { margin-right:15px; max-width:150px; width:50%; }
    .tyuo_product_section .product_data .img img { border-radius:4px; aspect-ratio:1/1; object-fit:cover; object-position:center; width:100%; }
    .tyuo_product_section .right_section_wrapper { display:flex; flex-direction:column; line-height:29px; width:50%; }
    .tyuo_product_section .quantity { display:flex; flex-direction:column; font-size:2em; }
    .tyuo_product_section .product_name { font-size:18px; font-weight:700; color:#1A1A1A; line-height:20px; margin:4px 0 10px; }
    .tyuo_product_section .product_regular_price { color:#8f8f8f; font-size:17px; text-decoration:line-through; }
    .tyuo_product_section .product_new_sale_price { color:#c00; font-size:25px; font-weight:700; }
    .wrapper_selectbox { color:#5f6060; font-size:1.1em; font-weight:500; padding:0 0 10px; }
    .wrapper_selectbox { text-align:right; padding:0 0 10px; }
    .wrapper_selectbox select { -webkit-appearance:none; -moz-appearance:none; background:#fff url("data:image/svg+xml;utf8,<svg fill='black' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>") no-repeat right 12px center; background-size:20px; border:1px solid #ccc; border-radius:4px; cursor:pointer; font-size:14px; font-weight:500; width:50%; outline:0; padding:10px; box-sizing:border-box; }
    @media (max-width:576px) { .wrapper_selectbox select { width:100%; } }
    .buttons-section { display:flex !important; flex-direction:row !important; gap:10px; padding:0 0 15px; box-sizing:border-box; flex-wrap:nowrap !important; }
    .pass-btn { flex:1 !important; min-width:0 !important; }
    .buy-btn { flex:2.8 !important; min-width:0 !important; }
    /* removed — buttons always side by side */
    .pass-btn { background:#fff; border:1px solid #04ac00; border-radius:4px; color:#04ac00; padding:12px 0; text-align:center; text-decoration:none; cursor:pointer; font-size:14px; line-height:1.2; box-sizing:border-box; }
    .buy-btn { background:#04ac00; border:1px solid #04ac00; border-radius:4px; color:#fff; cursor:pointer; flex:2.8; font-size:14px; font-weight:700; padding:14px 0; text-align:center; line-height:1.2; box-sizing:border-box; }
    .buy-btn.added { background:#2E7D32; }
    .buy-btn:disabled { background:#999; cursor:not-allowed; }
    .ty-upsell-status:empty { display:none; }
    .g-select-btn.selected { background:#2E7D32 !important; color:#fff !important; }
    .g-select-btn { height:40px; display:flex !important; align-items:center; justify-content:center; gap:4px; }
    /* Blur everything except upsell when visible */
    .ty-container.upsell-active .ty-success,
    .ty-container.grid-active .ty-success { margin-bottom:0 !important; }
    .ty-container.upsell-active > *:not(.ty_upsell_one_wrapper):not(#ty-grid-section),
    .ty-container.grid-active > *:not(#ty-grid-section):not(.ty_upsell_one_wrapper) {
        filter: blur(3px);
        opacity: 0.5;
        pointer-events: none;
        user-select: none;
    }
/* ═══════════════════════════════════════════════
   STEP 2: 6-PRODUCT GRID (inline, not overlay)
   ═══════════════════════════════════════════════ */
.ty-grid-section {
    margin-bottom: 15px; overflow: hidden;
    max-height: 0;
    transition: max-height 0.4s ease;
}
.ty-grid-section.show { max-height: 2000px; }

.ty-grid-popup {
    background: #fff;
    width: 100%;
    overflow: visible;
    border-radius: 4px !important;
    box-sizing: border-box;
}

.ty-grid-header {
    padding: 10px;
    text-align: center;
    background: #f39c1217;
    border: 2px solid #f39c12;
    border-radius: 4px;
    margin-bottom: 15px;
}
.ty-grid-header h3 {
    color: #000 !important; font-size: 15px;
    font-weight: 400; margin: 0 0 6px 0; padding: 0;
}
.ty-grid-header h2 {
    color: #000 !important; font-size: 20px;
    font-weight: 700; margin: 0; padding-top: 10px; line-height: 1.3;
}
.ty-grid-trust {
    text-align: center; padding: 6px 20px 12px;
    font-size: 13px; color: #47b426;
    background: #fff;
}

.ty-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    padding: 10px 15px 15px;
    background: #fff;
}
.ty-grid-item {
    background: #f5f5f5; text-align: center;
    padding: 0; border: none;
    border-radius: 4px !important;
    color: #333;
    transition: background 0.2s;
    overflow: hidden;
}
.ty-grid-item:hover { background: #efefef; }
.ty-grid-item img {
    width: 100%;
    height: auto;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    object-position: center;
    display: block;
    border-radius: 0;
    min-height: 80px;
    background: #eee;
}
.ty-grid-item .g-name,
.ty-grid-item .g-price-old,
.ty-grid-item .g-price-new,
.ty-grid-item select,
.ty-grid-item .g-add-btn {
    padding-left: 8px; padding-right: 8px;
}
.ty-grid-item .g-category {
    font-size: 10px; font-weight: 700; color: #999;
    text-transform: uppercase; letter-spacing: 0.5px;
    margin-top: 8px; padding-left: 8px; padding-right: 8px;
}
.ty-grid-item .g-name { margin-top: 2px; }
.ty-grid-item .g-name {
    font-family: 'Roboto', sans-serif;
    font-size: 12px; color: #222; margin-bottom: 5px;
    line-height: 1.3; min-height: 32px; font-weight: 500;
}
.ty-grid-item .g-price-old {
    text-decoration: line-through; color: #999; font-size: 12px;
}
.ty-grid-item .g-price-new {
    font-family: 'Roboto', sans-serif;
    color: #c00; font-size: 16px; font-weight: 700;
}
.ty-grid-item select {
    width: 100%; padding: 6px; font-size: 12px;
    border: 1px solid #ccc; border-radius: 1px !important;
    margin-top: 6px;
    background: #fff; color: #333; outline: none;
    font-weight: 600; transition: all 0.3s ease;
}
.ty-grid-item select:focus,
.ty-grid-item select:hover { border-color: #000; }
.ty-grid-item .g-add-btn {
    display: block; width: 100%; margin-top: 8px;
    padding: 10px; background: #04ac00; color: #fff;
    border: none; border-radius: 4px !important;
    font-family: 'Roboto', sans-serif;
    font-size: 13px; font-weight: 600;
    cursor: pointer; transition: background 0.2s;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.ty-grid-item .g-add-btn:hover { background: #039a00; }
.ty-grid-item .g-add-btn.added {
    background: #2E7D32; pointer-events: none;
}
.ty-grid-item .g-add-btn:disabled { opacity: 0.5; cursor: not-allowed; }

.ty-grid-close {
    display: block;
    width: calc(100% - 30px); margin: 0 15px 15px;
    padding: 14px;
    background: #fff; color: #47b426;
    border: 1px solid #47b426; border-radius: 4px !important;
    font-family: 'Roboto', sans-serif;
    font-size: 16px; font-weight: 600;
    cursor: pointer; text-align: center;
    transition: background 0.2s;
}
.ty-grid-close:hover { background: #f5f5f5; }

/* ═══ Collapsible sections ═══ */
.ty-section {
    background: #fff;
    margin-bottom: 15px; overflow: hidden;
    border-radius: 4px !important;
}
/* Section headers — matches product page collapsibles (Detalji o proizvodu, etc.) */
.ty-section-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 20px; cursor: pointer; user-select: none;
    font-family: 'Roboto', sans-serif;
    font-size: 15px; font-weight: 700; color: #222;
    font-style: italic;
    border-bottom: 1px solid #eee;
    transition: border-color 0.2s;
}
.ty-section-header.open { border-bottom-color: #eee; }
.ty-section-header .ty-chevron {
    font-size: 18px; color: #222; font-weight: 300; font-style: normal;
    transition: transform 0.25s; display: inline-block;
}
.ty-section-header.open .ty-chevron { transform: rotate(45deg); }
.ty-section-body {
    max-height: 0; overflow: hidden; transition: max-height 0.3s ease;
}
.ty-section-body.open { max-height: 2000px; }
.ty-section-body-inner { padding: 14px 20px; }
.ty-row {
    display: flex; justify-content: space-between; align-items: baseline;
    padding: 8px 0; font-family: 'Roboto', sans-serif;
    font-size: 14px; border-bottom: 1px solid #f0f0f0;
}
.ty-row:last-child { border-bottom: none; }
.ty-row-label { color: #888; font-weight: 400; }
.ty-row-value { font-weight: 600; color: #222; text-align: right; max-width: 60%; }
.ty-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0; border-bottom: 1px solid #f0f0f0;
}
.ty-item:last-child { border-bottom: none; }
.ty-item-name { font-family: 'Roboto', sans-serif; font-size: 14px; color: #222; flex: 1; }
.ty-item-meta { font-size: 12px; color: #999; margin-top: 2px; border: none; }
.ty-item-price { font-family: 'Roboto', sans-serif; font-weight: 600; font-size: 14px; color: #222; margin-left: 12px; white-space: nowrap; }
.ty-totals { margin-top: 0; border-top: none; padding-top: 0; }
.ty-totals .ty-row { padding: 5px 0; }
.ty-totals .ty-total-final { font-size: 16px; font-weight: 700; }

/* ═══ Mobile ═══ */
@media (max-width: 560px) {
    .ty-container { margin: 0 auto; padding: 0 10px; }
    .ty-success { padding: 22px 16px; }
    .ty-success h1 { font-size: 19px !important; }
    .tyuo_timer .title { font-size: 17px; }
    .tyuo_product_section .product_data { gap: 12px; }
    .tyuo_product_section .product_data .img { width: 90px; min-width: 90px; height: 90px; }
    .tyuo_product_section .qty { font-size: 20px; }
    .tyuo_product_section .product_new_sale_price { font-size: 20px; }
    /* removed — buttons always side by side */
    .tyuo_product_section .variation-select-wrap { padding: 0 0 8px; justify-content: center; }
    .tyuo_product_section .variation-select { width: 100%; }
    .ty-section-header { padding: 14px 16px; font-size: 14px; }
    .ty-section-body-inner { padding: 12px 16px; }
    .ty-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<?php if ( $order ) : ?>

<!-- Order confirmed fullscreen splash -->
<div id="order-splash" style="position:fixed;top:0;left:0;width:100%;height:100%;background:#04ac00;z-index:999999;display:flex;flex-direction:column;align-items:center;justify-content:center;transition:opacity 0.6s ease;">
    <div style="width:80px;height:80px;border:4px solid #fff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </div>
    <h1 style="color:#fff;font-family:'Roboto',sans-serif;font-size:28px;font-weight:700;margin:0;">Naročilo prejeto!</h1>
    <p style="color:rgba(255,255,255,0.85);font-family:'Roboto',sans-serif;font-size:15px;margin:10px 0 0;">Številka naročila: #<?php echo $order->get_order_number(); ?></p>
</div>
<script>(function(){var k='splash_<?php echo $order->get_id(); ?>';if(sessionStorage.getItem(k)){document.getElementById('order-splash').style.display='none';return;}sessionStorage.setItem(k,'1');setTimeout(function(){var s=document.getElementById('order-splash');s.style.opacity='0';setTimeout(function(){s.style.display='none';},600);},2000);})();</script>

<div class="ty-container">

    <?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

    <?php if ( $order->has_status( 'failed' ) ) : ?>
        <div class="ty-success" style="background:#fde8e8;">
            <div class="ty-success-icon" style="background:#dc3545;">✕</div>
            <h1>Naročilo ni uspelo</h1>
            <p>Banka je zavrnila transakcijo. Poskusite znova.</p>
            <p style="margin-top:16px;">
                <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" style="display:inline-block;background:#E8450E;color:#fff;padding:12px 32px;text-decoration:none;font-weight:700;">Poskusi znova</a>
            </p>
        </div>
    <?php else : ?>

        <!-- ✅ Success -->
        <div class="ty-success">
            <div class="ty-success-icon">✓</div>
            <h1>Vaše naročilo je bilo prejeto!</h1>
            <p>Potrditev ste prejeli na <?php echo esc_html( $order->get_billing_email() ); ?></p>
            <span class="ty-order-num">Naročilo #<?php echo $order->get_order_number(); ?></span>
        </div>

        <!-- ═══ STEP 1: VIGOSHOP UPSELL (COD only) ═══ -->
        <?php if ( $order->get_payment_method() === 'cod' && (float)$order->get_total() <= 120 ) : ?>
        <div class="ty_upsell_one_wrapper show" id="ty-upsell"
             style="position:static !important;display:block !important;width:100% !important;max-width:520px !important;height:auto !important;top:auto !important;left:auto !important;transform:none !important;opacity:1 !important;visibility:visible !important;z-index:auto !important;backdrop-filter:none !important;margin:0 !important;padding:0 !important;"
             data-order-id="<?php echo $order->get_id(); ?>"
             data-nonce="<?php echo wp_create_nonce('noriks_upsell_' . $order->get_id()); ?>">
            <div class="ty_upsell_one_wrapper__popup-content">

                <div class="tyuo_timer" style="position:relative;">
                    <div class="timer_wrapper">
                        <div class="special_offer_txt">Zadnja priložnost – ponudba poteče čez</div>
                        <div class="time" id="ty-timer">04:40</div>
                    </div>
                    <div class="title"><?php echo esc_html($upsell_title_text); ?></div>
                </div>

                <div class="tyuo_middle_section">
                    <div class="sub_title">
                        <span class="sub_title__icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="11.293" viewBox="0 0 15 11.293"><path d="M50.915,62.211,46.07,57.366a.44.44,0,0,1,0-.623L47.208,55.6a.44.44,0,0,1,.623,0l3.084,3.084a.441.441,0,0,0,.623,0l7.512-7.513a.44.44,0,0,1,.623,0l1.138,1.138a.44.44,0,0,1,0,.623l-9.273,9.274a.441.441,0,0,1-.623,0" transform="translate(-12.941 319.806)" fill="#47b426"></path></svg></span>
                        Brez dodatne dostave – vse v enem paketu
                    </div>
                    <div class="clue_text">
                        <span class="clue_text__icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="14.333" viewBox="0 0 15 14.333"><path d="M6.885.383,5.1,4a.686.686,0,0,1-.517.375l-3.994.58a.686.686,0,0,0-.38,1.17L3.1,8.945a.686.686,0,0,1,.2.607L2.614,13.53a.686.686,0,0,0,1,.723l3.572-1.878a.686.686,0,0,1,.639,0l3.572,1.878a.686.686,0,0,0,1-.723l-.682-3.978a.686.686,0,0,1,.2-.607l2.89-2.817a.686.686,0,0,0-.38-1.17l-3.994-.58A.686.686,0,0,1,9.9,4L8.116.383a.686.686,0,0,0-1.23,0" fill="#47b426"></path></svg></span>
                        Dopolni kombinacijo in prihrani
                    </div>
                </div>

                <div class="tyuo_product_section">
                    <!-- Qty picker FIRST — above product image -->
                    <div class="ty-qty-picker" style="display:flex;gap:8px;padding:0 0 10px;justify-content:center;">
                        <?php $qty_keys = array_keys($upsell_qty_prices); foreach ($qty_keys as $i => $q) :
                            $is_first = ($i === 0);
                            $border = $is_first ? '#f39c12' : '#ddd';
                            $bg = $is_first ? '#f39c1217' : '#fff';
                            $cls = $is_first ? ' active' : '';
                            $chk = $is_first ? ' checked' : '';
                        ?>
                        <label class="ty-qty-btn<?php echo $cls; ?>" style="flex:1;text-align:center;padding:10px 0;border:2px solid <?php echo $border; ?>;border-radius:4px;font-weight:700;font-size:14px;cursor:pointer;background:<?php echo $bg; ?>;color:#000;">
                            <input type="radio" name="ty_qty" value="<?php echo $q; ?>"<?php echo $chk; ?> style="display:none;"> <?php echo $q; ?>x kom
                        </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="product_data">
                        <div class="img">
                            <img id="ty-upsell-img" alt="<?php echo esc_attr($upsell_name); ?>" src="<?php echo esc_url($upsell_qty_images[$default_qty]); ?>">
                        </div>
                        <div class="right_section_wrapper">
                            <div class="product_name" id="ty-upsell-name"><?php echo esc_html($upsell_qty_names[$default_qty]); ?></div>
                            <div class="product_regular_price" id="ty-upsell-regular"><?php echo number_format($upsell_qty_regular[$default_qty], 2, ',', '.'); ?>€</div>
                            <div class="product_new_sale_price" id="ty-upsell-price"><?php echo number_format($upsell_qty_prices[$default_qty], 2, ',', '.'); ?>€</div>
                        </div>
                    </div>

                    <script>
                    (function(){
                        var prices = <?php echo json_encode(array_map(function($p){ return number_format($p,2,',','.') . '€'; }, $upsell_qty_prices)); ?>;
                        var names = <?php echo json_encode($upsell_qty_names); ?>;
                        var images = <?php echo json_encode($upsell_qty_images); ?>;
                        var regulars = <?php echo json_encode(array_map(function($p){ return number_format($p,2,',','.') . '€'; }, $upsell_qty_regular)); ?>;
                        document.querySelectorAll('.ty-qty-btn').forEach(function(btn){
                            btn.addEventListener('click', function(){
                                document.querySelectorAll('.ty-qty-btn').forEach(function(b){
                                    b.style.borderColor='#ddd'; b.style.background='#fff'; b.classList.remove('active');
                                });
                                btn.style.borderColor='#f39c12'; btn.style.background='#f39c1217'; btn.classList.add('active');
                                var q = btn.querySelector('input').value;
                                document.getElementById('ty-upsell-price').textContent = prices[q] || prices['3'] || '';
                                document.getElementById('ty-upsell-name').textContent = names[q] || names['3'] || '';
                                document.getElementById('ty-upsell-img').src = images[q] || images['3'] || '';
                                document.getElementById('ty-upsell-regular').textContent = regulars[q] || regulars['3'] || '';
                            });
                        });
                    })();
                    </script>

                    <div class="wrapper_selectbox">
                        <select class="variation-select" id="ty-variation-select">
                            <?php if ( $upsell_variations ) : ?>
                                <?php foreach ( $upsell_variations as $v ) : ?>
                                <option value="<?php echo $v['id']; ?>" <?php selected( strtolower($v['size']), strtolower($customer_size) ); ?>>
                                    Črna, <?php echo esc_html( $v['size'] ); ?>
                                </option>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <option value="">Črna, S</option>
                                <option value="">Črna, M</option>
                                <option value="">Črna, L</option>
                                <option value="">Črna, XL</option>
                                <option value="">Črna, XXL</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="ty-upsell-status" id="ty-upsell-status"></div>

                    <div class="buttons-section">
                        <a class="pass-btn" id="ty-btn-skip">Ne želim</a>
                        <div class="buy-btn" id="ty-btn-add" data-product-id="<?php echo esc_attr( $upsell_product_id ); ?>">DODAJ V NAROČILO</div>
                    </div>
                </div>

            </div>
        </div>

        <!-- ═══ STEP 2: 6-PRODUCT GRID OVERLAY ═══ -->
        <?php if ( ! empty( $grid_products ) ) : ?>
        <div class="ty-grid-section" id="ty-grid-section" style="display:none !important;">
            <div class="ty-grid-popup">
                <div class="ty-grid-header" style="cursor:pointer;flex-direction:column;position:relative;">
                    <span class="ty-upsell-close" id="ty-step2-close" style="position:absolute;top:10px;right:12px;font-size:20px;color:#000;cursor:pointer;width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-weight:300;">✕</span>
                    <div style="display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:8px;">
                        <div style="font-size:15px;font-weight:400;color:#000;">Posebna ponudba poteče čez</div>
                        <div class="time" id="ty-timer-2" style="display:inline-block;background:#e22b26;color:#fff;padding:2px 10px;border-radius:4px;font-size:14px;font-weight:700;font-variant-numeric:tabular-nums;">05:00</div>
                    </div>
                    <div style="font-size:20px;font-weight:700;color:#000;line-height:1.3;text-align:center;padding-top:10px;">Dodajte katerikoli izdelek s 50% popustom</div>
                </div>
                <div class="ty-section-body open" id="ty-grid-body">
                <div class="ty-section-body-inner" style="padding:0;">
                <div class="ty-grid-trust">
                    ✔ Vse pošljemo v istem paketu
                </div>
                <div class="ty-grid">
                    <?php foreach ( $grid_products as $gp ) :
                        // Use active/sale price (get_price returns sale price if on sale)
                        $gp_price = (float) $gp->get_price();
                        if ( ! $gp_price && $gp->is_type('variable') ) {
                            $gp_price = (float) $gp->get_variation_price('min', true);
                        }
                        if ( ! $gp_price ) {
                            $gp_price = (float) $gp->get_regular_price();
                        }
                        $gp_sale = round( $gp_price * 0.5, 2 );
                        $gp_img_id    = $gp->get_image_id();
                        $gp_img_url   = $gp_img_id ? wp_get_attachment_url( $gp_img_id ) : wc_placeholder_img_src();
                        $gp_is_var    = $gp->is_type('variable');
                        $gp_vars      = array();
                        if ( $gp_is_var ) {
                            foreach ( $gp->get_available_variations() as $gv ) {
                                $gv_label = '';
                                foreach ( $gv['attributes'] as $gk => $gval ) { $gv_label = $gval; }
                                $gp_vars[] = array( 'id' => $gv['variation_id'], 'label' => $gv_label );
                            }
                        }
                    ?>
                    <div class="ty-grid-item">
                        <img src="<?php echo esc_url( $gp_img_url ); ?>" alt="<?php echo esc_attr( $gp->get_name() ); ?>">
                        <div class="g-category">BOKSARICE</div>
                        <div class="g-name"><?php echo esc_html( $gp->get_name() ); ?></div>
                        <div class="g-price-old"><?php echo number_format( $gp_price, 2, ',', '.' ); ?>€</div>
                        <div class="g-price-new"><?php echo number_format( $gp_sale, 2, ',', '.' ); ?>€</div>
                        <?php if ( $gp_vars ) : ?>
                        <select class="g-variation" data-product-id="<?php echo $gp->get_id(); ?>">
                            <?php foreach ( $gp_vars as $gv ) : ?>
                            <option value="<?php echo $gv['id']; ?>"><?php echo esc_html( $gv['label'] ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php endif; ?>
                        <button class="g-add-btn g-select-btn"
                                data-product-id="<?php echo $gp->get_id(); ?>"
                                data-sale-price="<?php echo $gp_sale; ?>">
                            IZBERI
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="buttons-section">
                    <a class="pass-btn" id="ty-grid-close">Ne želim</a>
                    <div class="buy-btn" id="ty-grid-add-all">DODAJ V NAROČILO</div>
                </div>
                </div><!-- /ty-section-body-inner -->
                </div><!-- /ty-section-body -->
            </div>
        </div>
        <?php endif; ?>
        <?php endif; /* COD only */ ?>

        <!-- 📋 Order items -->
        <div class="ty-section" id="ty-order-items-section">
            <div class="ty-section-header open" onclick="tyToggle(this)">
                <span id="ty-order-items-header">Postavke naročila (<?php echo $order->get_item_count(); ?>)</span>
                <span class="ty-chevron">+</span>
            </div>
            <div class="ty-section-body open">
                <div class="ty-section-body-inner" id="ty-order-items-body">
                    <?php foreach ( $order->get_items() as $item ) :
                        $qty = $item->get_quantity();
                        $meta_parts = array();
                        foreach ( $item->get_formatted_meta_data('_', true) as $m ) {
                            $meta_parts[] = wp_strip_all_tags( $m->display_key . ': ' . $m->display_value );
                        }
                    ?>
                    <?php $is_upsell_item = $item->get_meta( '_noriks_upsell' ) === 'thank you upsell'; ?>
                    <div class="ty-item">
                        <div>
                            <div class="ty-item-name"><?php echo $qty; ?>× <?php echo esc_html( $item->get_name() ); ?></div>
                            <?php if ( $meta_parts ) : ?>
                            <div class="ty-item-meta"><?php echo esc_html( implode( ', ', $meta_parts ) ); ?></div>
                            <?php endif; ?>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div class="ty-item-price"><?php echo $order->get_formatted_line_subtotal( $item ); ?></div>
                            <!-- remove button disabled -->
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="ty-totals">
                        <?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
                        <div class="ty-row <?php echo $key === 'order_total' ? 'ty-total-final' : ''; ?>">
                            <span class="ty-row-label"><?php echo $total['label']; ?></span>
                            <span class="ty-row-value"><?php echo $total['value']; ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- 📍 Address -->
        <div class="ty-section">
            <div class="ty-section-header open" onclick="tyToggle(this)">
                <span>Naslov za dostavo</span>
                <span class="ty-chevron">+</span>
            </div>
            <div class="ty-section-body open">
                <div class="ty-section-body-inner">
                    <div class="ty-row"><span class="ty-row-label">Ime</span><span class="ty-row-value"><?php echo esc_html( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() ); ?></span></div>
                    <div class="ty-row"><span class="ty-row-label">Adresa</span><span class="ty-row-value"><?php echo esc_html( $order->get_billing_address_1() . ' ' . $order->get_billing_address_2() ); ?></span></div>
                    <div class="ty-row"><span class="ty-row-label">Mesto</span><span class="ty-row-value"><?php echo esc_html( $order->get_billing_postcode() . ' ' . $order->get_billing_city() ); ?></span></div>
                    <?php if ( $order->get_billing_phone() ) : ?>
                    <div class="ty-row"><span class="ty-row-label">Telefon</span><span class="ty-row-value"><?php echo esc_html( $order->get_billing_phone() ); ?></span></div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
    <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

</div>

<?php else : ?>
    <div class="ty-container">
        <div class="ty-success"><h1>Naročilo</h1>
        <?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>
        </div>
    </div>
<?php endif; ?>

<script>
(function(){
    var wrap     = document.getElementById('ty-upsell');
    var overlay  = document.getElementById('ty-grid-section');
    if (!wrap) return;

    // Blur background when upsell is visible
    var tyContainer = document.querySelector('.ty-container');
    if (tyContainer) tyContainer.classList.add('upsell-active');

    var orderId  = wrap.dataset.orderId;
    var nonce    = wrap.dataset.nonce;
    var ajaxUrl  = '<?php echo admin_url("admin-ajax.php"); ?>';

    // ─── Countdown ───
    var timerEl   = document.getElementById('ty-timer');
    var barEl     = null; // no bottom bar in vigoshop layout
    var key       = 'ty_' + orderId;
    var rem       = 300;
    var saved     = localStorage.getItem(key);
    if (saved) { rem = Math.max(0, 300 - Math.floor((Date.now() - parseInt(saved)) / 1000)); }
    else { localStorage.setItem(key, Date.now().toString()); }

    function tick() {
        if (rem <= 0) {
            // Hide everything — upsell over
            wrap.style.display = 'none';
            if (overlay) overlay.style.display = 'none';
            if (tyContainer) { tyContainer.classList.remove('upsell-active'); tyContainer.classList.remove('grid-active'); }
            // Clear all upsell localStorage
            localStorage.removeItem('ty_added_' + orderId);
            localStorage.removeItem(stepKey);
            localStorage.removeItem(key);
            // Auto-open "Postavke naročila" and "Naslov za dostavo" sections
            document.querySelectorAll('.ty-section .ty-section-header').forEach(function(h) {
                if (!h.classList.contains('open')) {
                    h.classList.add('open');
                    h.nextElementSibling.classList.add('open');
                }
            });
            // Release primary-hold → processing via AJAX
            var releaseFd = new FormData();
            releaseFd.append('action', 'noriks_release_primary_hold');
            releaseFd.append('order_id', orderId);
            fetch(ajaxUrl, { method: 'POST', body: releaseFd }).catch(function(){});
            return;
        }
        var m = Math.floor(rem/60), s = rem%60;
        var display = (m<10?'0':'')+m+':'+(s<10?'0':'')+s;
        if (timerEl) timerEl.textContent = display;
        if (barEl) barEl.textContent = display;
        var timer2 = document.getElementById('ty-timer-2');
        if (timer2) timer2.textContent = display;
        rem--; setTimeout(tick, 1000);
    }
    tick();

    // ─── Step transitions ───
    var stepKey = 'ty_step_' + orderId;

    // If user already passed step 1, skip to step 2
    // If user dismissed step 2 ('done'), hide everything
    var stepState = localStorage.getItem(stepKey);
    if (stepState === 'done' || stepState === '2') {
        wrap.style.display = 'none';
        if (overlay) overlay.style.display = 'none';
        if (tyContainer) { tyContainer.classList.remove('upsell-active'); tyContainer.classList.remove('grid-active'); }
    }

    function showGrid() {
        wrap.style.display = 'none';
        localStorage.setItem(stepKey, '2');
        if (overlay) overlay.classList.add('show');
        if (overlay) overlay.scrollIntoView({ behavior: 'smooth', block: 'start' });
        if (tyContainer) { tyContainer.classList.remove('upsell-active'); tyContainer.classList.add('grid-active'); }
    }
    function closeAll() {
        if (overlay) overlay.classList.remove('show');
        if (wrap) wrap.style.display = 'none';
        if (tyContainer) { tyContainer.classList.remove('upsell-active'); tyContainer.classList.remove('grid-active'); }
        localStorage.setItem(stepKey, 'done');
        // Release order — process it
        var relFd = new FormData();
        relFd.append('action', 'noriks_release_primary_hold');
        relFd.append('order_id', orderId);
        fetch(ajaxUrl, { method: 'POST', body: relFd }).catch(function(){});
    }

    // ─── Refresh order items after upsell add ───
    function refreshOrderItems() {
        var rfd = new FormData();
        rfd.append('action', 'noriks_refresh_order_items');
        rfd.append('order_id', orderId);
        fetch(ajaxUrl, { method: 'POST', body: rfd })
            .then(function(r) { return r.json(); })
            .then(function(d) {
                if (d.success) {
                    // Update items section content by ID
                    var itemsBody = document.getElementById('ty-order-items-body');
                    if (itemsBody) itemsBody.innerHTML = d.data.items_html;
                    // Update item count in header by ID
                    var headerSpan = document.getElementById('ty-order-items-header');
                    if (headerSpan) {
                        headerSpan.textContent = 'Postavke naročila (' + d.data.item_count + ')';
                    }
                    // Make sure section stays open
                    var section = document.getElementById('ty-order-items-section');
                    if (section) {
                        var h = section.querySelector('.ty-section-header');
                        var b = section.querySelector('.ty-section-body');
                        if (h && !h.classList.contains('open')) h.classList.add('open');
                        if (b && !b.classList.contains('open')) b.classList.add('open');
                    }
                }
            })
            .catch(function(){});
    }

    // ─── Step 1: X close → skip to step 2 ───
    var step1Close = document.getElementById('ty-step1-close');
    if (step1Close) {
        step1Close.addEventListener('click', function(e) {
            e.stopPropagation();
            closeAll();
        });
    }
    // ─── Step 2: X close → dismiss all ───
    var step2Close = document.getElementById('ty-step2-close');
    if (step2Close) {
        step2Close.addEventListener('click', function(e) {
            e.stopPropagation();
            closeAll();
        });
    }

    // ─── Step 1: "Ne želim" → show grid ───
    var skipBtn = document.getElementById('ty-btn-skip');
    if (skipBtn) {
        skipBtn.addEventListener('click', function() {
            closeAll();
        });
    }

    // ─── Step 1: "DODAJ" → add to order, then show grid ───
    var addBtn = document.getElementById('ty-btn-add');
    if (addBtn) {
        addBtn.addEventListener('click', function() {
            if (addBtn.disabled) return;
            addBtn.disabled = true;
            addBtn.textContent = 'Dodajam...';

            var select = document.getElementById('ty-variation-select');
            var qtyRadio = document.querySelector('input[name="ty_qty"]:checked');
            var qty = qtyRadio ? parseInt(qtyRadio.value) : 1; // default 1 kos
            var fd = new FormData();
            fd.append('action', 'noriks_add_upsell');
            fd.append('order_id', orderId);
            fd.append('product_id', <?php echo $upsell_product_id; ?>);
            fd.append('variation_id', select ? select.value : '');
            fd.append('sale_price', '<?php echo $upsell_sale_price; ?>');
            fd.append('quantity', qty);
            fd.append('upsell_type', '<?php echo $upsell_is_majice ? "post_purchase_step1_majica" : "post_purchase_step1_bokserica"; ?>');
            fd.append('nonce', nonce);

            fetch(ajaxUrl, { method: 'POST', body: fd })
                .then(function(r) { return r.json(); })
                .then(function(d) {
                    addBtn.textContent = '✓ DODANO';
                    addBtn.classList.add('added');
                    // Remember in localStorage
                    var ak = 'ty_added_' + orderId;
                    var al = JSON.parse(localStorage.getItem(ak) || '{}');
                    if (typeof al !== 'object' || Array.isArray(al)) al = {};
                    var pid1 = String(<?php echo $upsell_product_id; ?>);
                    var selVal = document.getElementById('ty-variation-select');
                    al[pid1] = selVal ? selVal.value : '';
                    localStorage.setItem(ak, JSON.stringify(al));
                    // Disable dropdown
                    if (selVal) selVal.disabled = true;
                    refreshOrderItems();
                    // Show grid after short delay
                    setTimeout(function() {
                        closeAll();
                    }, 800);
                })
                .catch(function() {
                    addBtn.disabled = false;
                    addBtn.textContent = 'DODAJ V NAROČILO';
                });
        });
    }

    // ─── Step 2: Grid select/deselect + batch add ───
    if (overlay) {
        // Toggle select on grid items
        overlay.querySelectorAll('.g-select-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var el = this;
                if (el.classList.contains('selected')) {
                    el.classList.remove('selected');
                    el.textContent = 'IZBERI';
                    el.style.background = '#000';
                } else {
                    el.classList.add('selected');
                    el.innerHTML = '✔ IZBRANO <span style="font-size:10px;opacity:0.7;margin-left:4px;">odstrani</span>';
                    el.style.background = '#2E7D32';
                }
            });
        });

        // "Ne želim" — close all, show summary without upsells
        document.getElementById('ty-grid-close').addEventListener('click', closeAll);

        // "DODAJ K NARUDŽBI" — add all selected items, then close
        var gridAddAll = document.getElementById('ty-grid-add-all');
        if (gridAddAll) {
            gridAddAll.addEventListener('click', function() {
                var selected = overlay.querySelectorAll('.g-select-btn.selected');
                if (selected.length === 0) {
                    closeAll();
                    return;
                }
                gridAddAll.textContent = 'Dodajam...';
                gridAddAll.style.pointerEvents = 'none';

                var promises = [];
                selected.forEach(function(btn) {
                    var productId = btn.getAttribute('data-product-id');
                    var salePrice = btn.getAttribute('data-sale-price');
                    var varSelect = btn.parentElement.querySelector('.g-variation');

                    var fd = new FormData();
                    fd.append('action', 'noriks_add_upsell');
                    fd.append('order_id', orderId);
                    fd.append('product_id', productId);
                    fd.append('variation_id', varSelect ? varSelect.value : '');
                    fd.append('sale_price', salePrice);
                    fd.append('upsell_type', 'post_purchase_step2');
                    fd.append('nonce', nonce);

                    promises.push(
                        fetch(ajaxUrl, { method: 'POST', body: fd })
                            .then(function(r) { return r.json(); })
                    );
                });

                Promise.all(promises).then(function(results) {
                    console.log('Upsell results:', results);
                    refreshOrderItems();
                    closeAll();
                }).catch(function(err) {
                    console.error('Upsell error:', err);
                    closeAll();
                });
            });
        }
    }

    // Restore step 1 button from localStorage
    setTimeout(function() {
        var addedKey2 = 'ty_added_' + orderId;
        var addedMap = JSON.parse(localStorage.getItem(addedKey2) || '{}');
        if (typeof addedMap !== 'object' || Array.isArray(addedMap)) addedMap = {};
        var mainBtn = document.getElementById('ty-btn-add');
        if (mainBtn) {
            var mainPid = mainBtn.getAttribute('data-product-id');
            if (addedMap.hasOwnProperty(mainPid) || addedMap.hasOwnProperty(String(mainPid))) {
                mainBtn.textContent = '✓ DODANO';
                mainBtn.classList.add('added');
                mainBtn.disabled = true;
                var mainDd = document.getElementById('ty-variation-select');
                var savedVal = addedMap[mainPid] || addedMap[String(mainPid)];
                if (mainDd && savedVal) { mainDd.value = savedVal; mainDd.disabled = true; }
            }
        }
    }, 100);
    // Backup: if user leaves page while timer still running, use sendBeacon to release
    window.addEventListener('pagehide', function() {
        if (rem <= 0) {
            var data = new URLSearchParams();
            data.append('action', 'noriks_release_primary_hold');
            data.append('order_id', orderId);
            navigator.sendBeacon(ajaxUrl, data);
        }
    });
})();

function removeUpsellItem(btn) {
    if (btn.disabled) return;
    btn.disabled = true;
    btn.textContent = '…';
    var itemId = btn.getAttribute('data-item-id');
    var orderId = btn.getAttribute('data-order-id');
    var fd = new FormData();
    fd.append('action', 'noriks_remove_upsell');
    fd.append('order_id', orderId);
    fd.append('item_id', itemId);
    fetch('<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            if (d.success) {
                // Stay on step 2 — never go back to step 1
                // Just reset the grid add buttons so user can re-add
                document.querySelectorAll('.g-add-btn.added').forEach(function(gb) {
                    gb.disabled = false;
                    gb.classList.remove('added');
                    gb.textContent = 'DODAJ';
                });
                // Refresh order items
                var rfd = new FormData();
                rfd.append('action', 'noriks_refresh_order_items');
                rfd.append('order_id', orderId);
                fetch('<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: rfd })
                    .then(function(r2) { return r2.json(); })
                    .then(function(d2) {
                        if (d2.success) {
                            var itemsBody = document.getElementById('ty-order-items-body');
                            if (itemsBody) itemsBody.innerHTML = d2.data.items_html;
                            var headerSpan = document.getElementById('ty-order-items-header');
                            if (headerSpan) {
                                headerSpan.textContent = 'Postavke naročila (' + d2.data.item_count + ')';
                            }
                        }
                    });
            } else {
                btn.disabled = false;
                btn.textContent = '✕';
                alert(d.data || 'Napaka');
            }
        })
        .catch(function() {
            btn.disabled = false;
            btn.textContent = '✕';
        });
}

function tyToggle(h) {
    h.classList.toggle('open');
    h.nextElementSibling.classList.toggle('open');
}
</script>
<!-- variation dropdown now visible -->
