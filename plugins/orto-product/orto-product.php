
<?php
/*
Plugin Name: Orto Bundle Selector
Description: Custom bundle radio buttons for Orto products (multiple pairs, supports 2 or 4+ custom attributes like 2 colors + 2 sizes).
Version: 3.3
Author: Ante
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================
// EXTRA ACF FIELDS (registered in code, per product)
// ============================================================
// Two per-product toggles. They take effect ONLY on products where
// they are checked; all other products keep the original behavior.
add_action( 'acf/init', 'gck_register_orto_acf_fields' );
function gck_register_orto_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'    => 'group_orto_bundle_options',
        'title'  => 'Orto Bundle – dodatne nastavitve',
        'fields' => array(
            array(
                'key'          => 'field_orto_precheck_second',
                'label'        => 'Privzeto označi 2. ponudbo',
                'name'         => 'orto_precheck_second',
                'type'         => 'true_false',
                'instructions' => 'Če je vključeno, je ob nalaganju strani prechekana DRUGA ponudba namesto prve. Velja samo za ta produkt.',
                'ui'           => 1,
            ),
            array(
                'key'          => 'field_orto_show_gratis_labels',
                'label'        => 'Prikaži "Gratis majica" oznake',
                'name'         => 'orto_show_gratis_labels',
                'type'         => 'true_false',
                'instructions' => 'Doda oznake (Majica 1, Gratis majica 1 ...) nad izbirnike barv/velikosti. Število gratis kosov se prebere iz naslova ponudbe, npr. "2+2".',
                'ui'           => 1,
            ),
            array(
                'key'          => 'field_orto_show_price_highlights',
                'label'        => 'Prikaži poudarke cene (cena/kos + popust)',
                'name'         => 'orto_show_price_highlights',
                'type'         => 'true_false',
                'instructions' => 'Doda okvirček s ceno na kos (prečrtana redna cena/kos) in zeleno značko popusta (−XX%) pri vsaki ponudbi. Velja samo za ta produkt.',
                'ui'           => 1,
            ),
            array(
                'key'          => 'field_orto_show_countdown',
                'label'        => 'Prikaži odštevalnik (pospeševalec prodaje)',
                'name'         => 'orto_show_countdown',
                'type'         => 'true_false',
                'instructions' => 'Doda nad ponudbe pas z nujnostjo in teko­čim odštevalnikom (npr. "Akcija se izteče čez 29:59"). Vsak obiskovalec dobi svoj časovnik. Velja samo za ta produkt.',
                'ui'           => 1,
            ),
            array(
                'key'               => 'field_orto_countdown_minutes',
                'label'             => 'Trajanje odštevalnika (minute)',
                'name'              => 'orto_countdown_minutes',
                'type'              => 'number',
                'instructions'      => 'Koliko minut traja odštevalnik za posameznega obiskovalca. Privzeto 10. Ko poteče, se ob naslednjem obisku diskretno ponastavi.',
                'default_value'     => 10,
                'min'               => 1,
                'max'               => 1440,
                'append'            => 'min',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_orto_show_countdown',
                            'operator' => '==',
                            'value'    => '1',
                        ),
                    ),
                ),
            ),
            array(
                'key'               => 'field_orto_countdown_stock',
                'label'             => 'Preostala zaloga (kosov)',
                'name'              => 'orto_countdown_stock',
                'type'              => 'number',
                'instructions'      => 'Število, ki se prikaže v pasici ("Ostalo le X kosov"). Pusti prazno ali 0, da se ta del skrije.',
                'default_value'     => 27,
                'min'               => 0,
                'max'               => 9999,
                'append'            => 'kosov',
                'conditional_logic' => array(
                    array(
                        array(
                            'field'    => 'field_orto_show_countdown',
                            'operator' => '==',
                            'value'    => '1',
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'product',
                ),
            ),
        ),
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
        'active'     => true,
    ) );
}

// ============================================================
// OFFERS (ACF repeater)
// ============================================================

/**
 * Build bundle offers dynamically from ACF repeater _singlepp_orto_pairs.
 * Uses:
 *  - cena_1 = regular price
 *  - cena_2 = sale price (actual price)
 * Also reads:
 *  - p1, p2 (labels for 4-attribute UI headings + cart meta grouping)
 *  - tip (mixed|majica|bokserica|empty) -> controls which selectors appear in 4-attr products
 */
function gck_get_bundle_offers( $product_id = null ) : array {

    if ( ! $product_id ) {
        $product_id = get_the_ID();
    }
    if ( ! $product_id ) {
        return [];
    }

    $rows = get_field('_singlepp_orto_pairs', $product_id);
    if ( empty($rows) || ! is_array($rows) ) {
        return [];
    }

    $offers = [];
    $idx    = 0;

    foreach ( $rows as $row ) {
        $idx++;

        $qty = isset($row['qty']) ? (int) $row['qty'] : 0;
        if ( $qty <= 0 ) continue;

        $tekst1 = trim((string)($row['tekst_1'] ?? ''));
        $title  = trim($tekst1 . ' ');

        $regular = isset($row['cena_1']) ? (float) $row['cena_1'] : 0;
        $sale    = isset($row['cena_2']) ? (float) $row['cena_2'] : 0;
        if ( $sale <= 0 ) continue;

        $saving_amount = $regular - $sale;
        $saving_text   = "Skupni prihranek " . number_format($saving_amount, 2, '.', '') . "€";

        $p1  = trim((string)($row['p1'] ?? ''));
        $p2  = trim((string)($row['p2'] ?? ''));
        $tip = trim((string)($row['tip'] ?? '')); // NEW

        // unique offer id per row
        $offer_id = $qty . '__' . $idx;

        // qty=1 exact
        if ( $qty === 1 ) {
            $offers[$offer_id] = [
                "id"     => $offer_id,
                "qty"    => $qty,
                "title"  => $title,
                "per"    => number_format($sale, 2, '.', ''),
                "total"  => number_format($sale, 2, '.', ''),
                "regular" => number_format($regular, 2, '.', ''), // cena_1
                "saving" => $saving_text,
                "p1"     => $p1,
                "p2"     => $p2,
                "tip"    => $tip,
            ];
            continue;
        }

        // multi-item: floor down per item to 2 decimals
        $per_item       = $sale / $qty;
        $per_item_fixed = floor($per_item * 100) / 100;

        $offers[$offer_id] = [
            "id"     => $offer_id,
            "qty"    => $qty,
            "title"  => $title,
            "per"    => number_format($per_item_fixed, 2, '.', ''),
            "total"  => number_format($sale, 2, '.', ''),
            "regular" => number_format($regular, 2, '.', ''), // cena_1
            "saving" => $saving_text,
            "p1"     => $p1,
            "p2"     => $p2,
            "tip"    => $tip,
        ];
    }

    return $offers;
}

function gck_is_orto_bundle_enabled( $product_id ) : bool {
    if ( ! $product_id ) return false;
    $flag = get_post_meta( $product_id, '_singlepp_orto_ison', true );
    return ! empty( $flag );
}

// ============================================================
// ATTRIBUTE HELPERS (supports 2 attrs OR 4 attrs)
// ============================================================

function gck_get_custom_attributes_in_order( $product ) : array {
    $attributes   = $product->get_attributes();
    $custom_attrs = [];

    foreach ( $attributes as $key => $attr ) {
        if ( $attr && ! $attr->is_taxonomy() ) {
            $custom_attrs[ $key ] = $attr;
        }
    }
    return $custom_attrs;
}

function gck_split_attrs_color_size( array $custom_attrs ) : array {
    $colors = [];
    $sizes  = [];
    $others = [];

    foreach ( $custom_attrs as $key => $attr ) {
        $label = method_exists($attr, 'get_name') ? (string) $attr->get_name() : (string) $key;

        $hay = strtolower( $key . ' ' . $label );

        $is_color = ( strpos($hay, 'boja') !== false || strpos($hay, 'barva') !== false || strpos($hay, 'culoare') !== false || strpos($hay, 'color') !== false || strpos($hay, 'colour') !== false || strpos($hay, 'farbe') !== false || strpos($hay, 'цвят') !== false );
        $is_size  = ( strpos($hay, 'vel')  !== false || strpos($hay, 'veli') !== false || strpos($hay, 'size') !== false || strpos($hay, 'mărime') !== false || strpos($hay, 'größe') !== false || strpos($hay, 'grosse') !== false || strpos($hay, 'groesse') !== false || strpos($hay, 'marime') !== false || strpos($hay, 'размер') !== false );

        $values = $attr->get_options();
        if ( ! is_array($values) ) $values = [];

        $item = [
            'key'       => $key,
            'label'     => $label,
            'field_key' => 'attribute_' . $key,
            'values'    => $values,
        ];

        if ( $is_color && ! $is_size ) {
            $colors[] = $item;
        } elseif ( $is_size && ! $is_color ) {
            $sizes[] = $item;
        } else {
            $others[] = $item;
        }
    }

    // fallback to old behavior if not detected
    if ( empty($colors) && empty($sizes) && count($custom_attrs) >= 2 ) {
        $keys = array_keys($custom_attrs);

        $first  = $custom_attrs[$keys[0]];
        $second = $custom_attrs[$keys[1]];

        $colors[] = [
            'key'       => $keys[0],
            'label'     => (string) $first->get_name(),
            'field_key' => 'attribute_' . $keys[0],
            'values'    => (array) $first->get_options(),
        ];
        $sizes[] = [
            'key'       => $keys[1],
            'label'     => (string) $second->get_name(),
            'field_key' => 'attribute_' . $keys[1],
            'values'    => (array) $second->get_options(),
        ];

        for ( $i = 2; $i < count($keys); $i++ ) {
            $a = $custom_attrs[$keys[$i]];
            $others[] = [
                'key'       => $keys[$i],
                'label'     => (string) $a->get_name(),
                'field_key' => 'attribute_' . $keys[$i],
                'values'    => (array) $a->get_options(),
            ];
        }
    }

    return [
        'colors' => $colors,
        'sizes'  => $sizes,
        'others' => $others,
    ];
}

function gck_attr_group_token( string $label, string $type ) : string {
    $l = strtolower( trim( $label ) );

    if ( $type === 'color' ) {
        $l = str_replace(['boja', 'color', 'colour', ':'], ' ', $l);
    } else {
        $l = str_replace(['veličina', 'velicina', 'size', ':'], ' ', $l);
    }

    $l = trim( preg_replace('/\s+/', ' ', $l) );
    return sanitize_title( $l );
}

/**
 * Pair color + size into logical rows:
 * Prefer matching tokens, fallback by index.
 */
function gck_pair_color_size_groups( array $colors, array $sizes ) : array {
    $groups = [];

    $sizes_by_token = [];
    $sizes_used     = [];

    foreach ( $sizes as $i => $s ) {
        $tok = gck_attr_group_token( (string)($s['label'] ?? ''), 'size' );
        if ( $tok !== '' ) {
            $sizes_by_token[$tok][] = $i;
        }
    }

    foreach ( $colors as $ci => $c ) {
        $ctok = gck_attr_group_token( (string)($c['label'] ?? ''), 'color' );

        $matched_si = null;

        if ( $ctok !== '' && ! empty($sizes_by_token[$ctok]) ) {
            foreach ( $sizes_by_token[$ctok] as $candidate_si ) {
                if ( empty($sizes_used[$candidate_si]) ) {
                    $matched_si = $candidate_si;
                    break;
                }
            }
        }

        if ( $matched_si === null && isset($sizes[$ci]) && empty($sizes_used[$ci]) ) {
            $matched_si = $ci;
        }

        if ( $matched_si === null ) {
            foreach ( $sizes as $si => $_s ) {
                if ( empty($sizes_used[$si]) ) {
                    $matched_si = $si;
                    break;
                }
            }
        }

        $size_item = null;
        if ( $matched_si !== null && isset($sizes[$matched_si]) ) {
            $size_item = $sizes[$matched_si];
            $sizes_used[$matched_si] = true;
        }

        $groups[] = [
            'token' => $ctok,
            'color' => $c,
            'size'  => $size_item,
        ];
    }

    foreach ( $sizes as $si => $s ) {
        if ( empty($sizes_used[$si]) ) {
            $stok = gck_attr_group_token( (string)($s['label'] ?? ''), 'size' );
            $groups[] = [
                'token' => $stok,
                'color' => null,
                'size'  => $s,
            ];
        }
    }

    return $groups;
}

// ============================================================
// RENDER UI
// ============================================================

// ============================================================
// COLOR MAP (all locales)
// ============================================================

function gck_get_color_hex( $color_name ) {
    static $map = null;
    if ( $map === null ) {
        $map = [
            // HR
            'crna' => '#000', 'bijela' => '#fff', 'bela' => '#fff', 'white' => '#fff',
            'plava' => '#203240', 'modra' => '#203240', 'blue' => '#203240',
            'siva' => '#706d78', 'gray' => '#706d78', 'gri' => '#706d78',
            'zelena' => '#294d3b', 'green' => '#294d3b', 'verde' => '#294d3b',
            'crvena' => '#ba212f', 'red' => '#ba212f',
            'bez' => '#e4e0cf', 'bej' => '#e4e0cf',
            'smeda' => '#9f6f4e', 'brown' => '#9f6f4e',
            'tamnoplava' => '#2a3262',
            'black' => '#000',
            // SI
            'črna' => '#000', 'rdeca' => '#ba212f', 'rdeča' => '#ba212f',
            'temnomodra' => '#2a3262', 'rjava' => '#9f6f4e',
            'bež' => '#e4e0cf',
            // RO
            'negru' => '#000', 'alb' => '#fff',
            'bleumarin' => '#2a3262', 'maro' => '#9f6f4e',
            'rosu' => '#ba212f', 'roșu' => '#ba212f',
            'albastru' => '#203240',
            // DE
            'schwarz' => '#000', 'weiß' => '#fff', 'weiss' => '#fff',
            'grau' => '#706d78', 'grün' => '#294d3b', 'gruen' => '#294d3b',
            'rot' => '#ba212f', 'blau' => '#203240',
            'dunkelblau' => '#2a3262', 'braun' => '#9f6f4e',
            'beige' => '#e4e0cf',
            // BG
            'черна' => '#000', 'бяла' => '#fff',
            'сива' => '#706d78', 'зелена' => '#294d3b',
            'синя' => '#203240', 'червена' => '#ba212f',
            'бежова' => '#e4e0cf', 'кафява' => '#9f6f4e',
            'тъмносиня' => '#2a3262',
        ];
    }
    $key = mb_strtolower( trim( $color_name ) );
    return $map[ $key ] ?? null;
}

/**
 * Slovenian noun phrase "majica" with correct case for a given count.
 * Accusative (izberi X ...): 1 majico, 2 majici, 3-4 majice, 5+ majic.
 * If $free, prepends the matching form of "brezplačen".
 */
function gck_sl_majice_phrase( int $n, bool $free = false, string $type = 'majica' ) : string {
    $m100 = $n % 100;
    $m10  = $n % 10;

    $is1  = ( $m10 === 1 && $m100 !== 11 );
    $is2  = ( $m10 === 2 && $m100 !== 12 );
    $is34 = ( in_array( $m10, array( 3, 4 ), true ) && ! in_array( $m100, array( 13, 14 ), true ) );

    $stem = ( $type === 'bokserica' ) ? 'boksaric' : 'majic';

    if ( $is1 ) {
        $adj = 'brezplačno'; $noun = $stem . 'o';
    } elseif ( $is2 ) {
        $adj = 'brezplačni'; $noun = $stem . 'i';
    } elseif ( $is34 ) {
        $adj = 'brezplačne'; $noun = $stem . 'e';
    } else {
        $adj = 'brezplačnih'; $noun = $stem;
    }

    return $free ? ( $adj . ' ' . $noun ) : $noun;
}

add_action( 'woocommerce_before_add_to_cart_button', 'gck_render_bundle_selector', 5 );

function gck_render_bundle_selector() {

    global $product;

    if ( ! is_product() || ! $product || ! gck_is_orto_bundle_enabled( $product->get_id() ) ) return;





    $product_id = $product->get_id();

    $offers = gck_get_bundle_offers( $product_id );
    if ( empty( $offers ) ) return;

    // Per-product toggles (registered in code above).
    $precheck_second       = (bool) get_field( 'orto_precheck_second', $product_id );
    $show_gratis           = (bool) get_field( 'orto_show_gratis_labels', $product_id );
    $show_price_highlights = (bool) get_field( 'orto_show_price_highlights', $product_id );

    // Garment type for gratis labels: "bokserica" (boxers) vs default "majica".
    // Detect via product category or slug/name so each product gets the correct noun.
    $gck_garment = 'majica';
    if (
        has_term( array( 'orto-bokserice', 'orto-bokserice2' ), 'product_cat', $product_id )
        || ( stripos( (string) $product->get_slug(), 'bokseric' ) !== false )
        || ( stripos( (string) $product->get_name(), 'bokseric' ) !== false )
    ) {
        $gck_garment = 'bokserica';
    }
    $show_countdown        = (bool) get_field( 'orto_show_countdown', $product_id );
    $countdown_minutes     = (int) get_field( 'orto_countdown_minutes', $product_id );
    if ( $countdown_minutes < 1 || $countdown_minutes > 1440 ) {
        $countdown_minutes = 10;
    }
    $countdown_stock = (int) get_field( 'orto_countdown_stock', $product_id );
    if ( $countdown_stock < 0 ) {
        $countdown_stock = 0;
    }

    $custom_attrs = gck_get_custom_attributes_in_order( $product );
    if ( count( $custom_attrs ) < 2 ) return;

    $split  = gck_split_attrs_color_size( $custom_attrs );
    $colors = $split['colors'];
    $sizes  = $split['sizes'];

    if ( empty($colors) || empty($sizes) ) return;

    $attr_groups = gck_pair_color_size_groups( $colors, $sizes );

    // "4-attribute case" in your implementation means we have 2 selector groups (majica + bokserica)
    $show_group_titles = ( count($attr_groups) > 1 );

    // Special product (SKU NORIKS-ORTO-SHBOX): show the two garment groups as separate
    // gratis-style sections instead of interleaved pairs. Saved data stays identical.
    $gck_split_garments = ( strtoupper( (string) $product->get_sku() ) === 'NORIKS-ORTO-SHBOX' && count( $attr_groups ) >= 2 );

    ?>
    <style>
      .single_add_to_cart_button {
          font-family: 'Roboto', sans-serif;
          height: 60px;
          width: 100%;
          background: #c00 !important;
          letter-spacing: -0.5px !important;
          border-radius: 8px;
          font-size: 17px !important;
          letter-spacing: 0.2px !important;
          color: white;
          text-transform: uppercase  !important;
      }
      body.single-product .quantity { display: none; }

      .bundle-box { margin: 0 0 15px 0 }
      .bundle-option {
         display: block;
         border: 2px solid #939393;
         background: #f4f4f4b0;
         border-radius: 8px;
         padding: 10px 5px 10px 15px;
         margin-bottom: 12px;
         cursor: pointer;
         position: relative;
         box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
      }
      .bundle-option-title {
          font-weight: 600;
          color: black;
          letter-spacing: 0.3px;
          vertical-align: middle;
      }
      .bundle-option.active { border-color: #f39c12; background: #f39c1217; }
      .bundle-pairs { margin-top: 10px; padding-top: 10px; border-top: 1px solid #969696; }

      .bundle-pair { display: flex; flex-direction: column; gap: 3px; margin-bottom: 4px; }
      .bundle-attr-row{ display: flex; align-items: center; flex-wrap: wrap; gap: 8px; }

      .gck-group-title{
          width: 100%;
          font-weight: 800;
          font-size: 14px;
          color: #111;
          margin: 2px 0 0 0;
          letter-spacing: .2px;
      }

      .gck-pair-label{
          width: 100%;
          font-weight: 800;
          font-size: 15px;
          color: #111;
          margin: 2px 0 5px 0;
          letter-spacing: .2px;
          line-height: 1.2;
      }
      .gck-pair-label.is-gratis{ color: #c00; margin-top: 12px; }

      .gck-per-chip{
          display: inline-flex;
          align-items: center;
          gap: 6px;
          background: #c00;
          border-radius: 4px;
          padding: 6px 9px;
          margin-left: 4px;
          font-size: 14px;
          font-weight: 600;
          line-height: 1;
          vertical-align: middle;
      }
      .gck-per-old{ color: rgba(255,255,255,0.85); text-decoration: line-through; font-weight: 600; }
      .gck-per-new{ color: #fff; font-weight: 800; }
      .gck-discount-badge{
          display: inline-flex;
          align-items: center;
          margin-left: 6px;
          background: #2e7d32;
          color: #fff;
          font-size: 13px;
          font-weight: 800;
          padding: 6px 9px;
          border-radius: 4px;
          line-height: 1;
          vertical-align: middle;
      }
      .gck-hl-break{ display: none; }

      .bundle-total-line { margin-top: 0px; text-align: right; font-weight: 600; color: black; }
      small { color: black; }

      .hidden { visibility: hidden !important; height: 0 !important; overflow: hidden !important; opacity: 0 !important; pointer-events: none !important; display: none; }

      .color-swatches { display: flex; gap: 2px; align-items: center; }
      .color-swatches .swatch {
          width: 33px; height: 34px;
          border-radius: 4px;
          border: 2px solid #ddd;
          cursor: pointer;
          display: flex;
          justify-content: center;
          align-items: center;
          transition: all .15s;
      }
      .color-swatches .swatch.active { border-color: #ff6d2e; transform: scale(1.08); }
      .swatch-circle { width: 27px; height: 27px; border-radius: 50%; }

      .color-black { background: #000; } .color-crna { background: #000; }
      .color-blue  { background: #203240; } .color-modra { background: #203240; } .color-plava { background: #203240; }
      .color-green  { background: #294d3b; } .color-zelena { background: #294d3b; }
      .color-gray { background: #706d78; } .color-siva { background: #706d78; }
      .color-crvena { background: #ba212f; }
      .color-white { background: #fff; border: 1px solid #ccc; }
      .color-bela  { background: #fff; border: 1px solid #ccc; }
      .color-bijela{ background: #fff; border: 1px solid #ccc; }
      .color-bez { background: #e4e0cf; }
      .color-smeda { background: #9f6f4e; }
      .color-zelena { background: #65633c; }
      .color-tamnoplava { background: #2a3262; }

      .bundle-option input[type="radio"] {
          -webkit-appearance: none;
          appearance: none;
          margin: -2px 2px 0 2px;
          width: 16px; height: 16px;
          border-radius: 50%;
          border: 2px solid #ff6d2e;
          background: #fff;
          position: relative;
          cursor: pointer;
          vertical-align: middle;
          outline: none;
          box-shadow: none;
          accent-color: initial;
      }
      .bundle-option input[type="radio"]::before {
          content: '';
          position: absolute;
          inset: 3px;
          border-radius: 50%;
          background: #ff6d2e;
          transform: scale(0);
          transition: transform 0.15s ease;
      }
      .bundle-option input[type="radio"]:checked::before { transform: scale(1); }

      .bundle-box select {
          flex: 0 0 auto;
          max-width: 150px;
          min-width: 69px;
          padding: 1px 10px;
          border-radius: 4px;
          border: 2px solid #ff6d2e;
          background: #ffffff;
          font-size: 18px;
          font-weight: 600;
          color: #333;
          appearance: none;
          background-image: linear-gradient(45deg, transparent 50%, #444 50%),
                            linear-gradient(135deg, #444 50%, transparent 50%);
          background-position: calc(100% - 13px) 50%, calc(100% - 8px) 50%;
          background-size: 6px 6px, 6px 6px;
          background-repeat: no-repeat;
          margin-left: -2px;
      }

      .gck-popular-badge,
      .gck-popular-badge-2 {
          transform: rotate(3deg);
          position: absolute;
          top: -18px;
          right: -15px;
          background: #000;
          color: #fff;
          font-size: 13px;
          padding: 3px 17px;
          border-radius: 8px;
          font-weight: 600;
          z-index: 30;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
          white-space: nowrap;
          transform-origin: center;
          animation: gckPopularPulse 1.3s ease-in-out infinite;
      }
      @keyframes gckPopularPulse {
          0%, 100% { transform: rotate(3deg) scale(1); }
          50%      { transform: rotate(3deg) scale(1.05); }
      }
      /* Theme sets ".summary{overflow:hidden}" which clips the popular badge.
         Only this plugin's products render this style, so the override is scoped. */
      .summary { overflow: visible !important; }
      @media (prefers-reduced-motion: reduce) {
          .gck-popular-badge, .gck-popular-badge-2 { animation: none; }
      }

      .gck-top-banner-wrap { margin-bottom: 0px; }
      .gck-divider { display:flex; align-items:center; justify-content:center; margin: 8px 0 4px; }
      .gck-divider span { font-size: 15px; font-weight: 600; color: black; padding: 0 12px; text-transform: uppercase; }
      .gck-divider:before, .gck-divider:after { content:""; flex:1; height:2px; background:#f39c12; max-width:400px; }

      .gck-timer-bar { background: #f39c12; color: #fff; padding: 4px 14px; border-radius: 4px; text-align: center; font-weight: 600; font-size: 15px; }
      .gck-benefits-box { margin-top:-15px; color: #000; }
      .gck-benefits-list { list-style:none; margin:0 0 8px; padding:0; margin-top:-25px !important; }
      .gck-benefits-list li { font-size:15px; line-height:1.6; margin:0 0 4px; display:flex; align-items:flex-start; }
      .gck-check { margin-right:6px; font-size:14px; }

      .gck-size-link {
          display: inline-flex;
          align-items: center;
          font-size: 14px;
          text-decoration: underline;
          color: #000;
          margin-left: -5px;
          font-weight: bold;
          text-transform: uppercase;
          margin-top: 10px;
      }
      .features { display: none !important; }
      
      
      
      @media (max-width: 490px) {
         .gck-divider span { 
             }
         
      }
      
      
      .gck-regular-price{
  color:#c00;
  text-decoration: line-through;
  font-weight:700;
  margin-right:6px;
}

      @media (max-width: 767px) {
          .bundle-option { padding: 10px 8px 10px 12px; }

          /* tighter vertical rhythm between rows + sections */
          .bundle-pair { margin-bottom: 5px; gap: 3px; }
          .bundle-pairs { padding-top: 6px; }
          .gck-pair-label { font-size: 14px; margin: 1px 0 4px 0; }
          .gck-pair-label.is-gratis { margin-top: 8px; }

          /* a touch more space between color swatches (less cramped) */
          .bundle-attr-row { gap: 7px; }
          .color-swatches { gap: 3px; }
          .color-swatches .swatch { width: 30px; height: 31px; }
          .swatch-circle { width: 24px; height: 24px; }
          .bundle-box select { min-width: 60px; }

          /* price pills on their own line under the title, tight spacing */
          .gck-hl-break { display: block; }
          .gck-per-chip { margin-left: 0; margin-top: 4px; }
          .gck-discount-badge { margin-top: 4px; margin-left: 6px; }
          .bundle-total-line { margin-top: 3px; }
      }
    </style>
    
    
    
    

    <?php
    // Your extra conditional style block (kept)
    if (  !has_term( array( 'orto-starter', 'orto-majice', 'orto-bokserice' ), 'product_cat', $product_id )  )   :
    ?>
        <style>
          .bundle-option { border: 2px solid #ededed; background: #f4f4f4b0  !important; border-radius: 4px; }
          .bundle-option.active { border-color: #969696 !important;  background: #62626217  !important; border: none !important; }
          .color-swatches .swatch.active { border-color: black  !important; }
          .bundle-box select { border: 2px solid black !important; }
        </style>
    <?php endif; ?>
    
    
    
        <?php
    // Your extra conditional style block (kept)
    if (  has_term( array( 'orto-starter'), 'product_cat', $product_id )  )   :
    ?>
        <style>
          
          
            .price ins {
                   
                   font-size: 25px !important;
                   font-weight: bold;
               
               }
               
                 .price del {
                   
                   font-size: 25px !important;
               
               }
               
               .price-badge {
                   
                   font-size: 17px !important;
                   margin-top: -7px !important;
               }
               
               
                  .gck-divider span {
        font-size: 17px;
        font-weight: 600;
        color: black;
        padding: 0 12px;
        text-transform: uppercase;
        letter-spacing: -0.2px;
        text-align: center !important;
        line-height: 1.3;
    }
          
           @media (max-width: 991px) {
               
               
                   .gck-divider span {
        font-size: 17px;
        font-weight: 600;
        color: black;
        padding: 0 12px;
        text-transform: uppercase;
        letter-spacing: -0.2px;
        text-align: center !important;
        line-height: 1.3;
    }
               
               #title-buy-now  {
                       font-size: 35px !important;
                       letter-spacing: 0.1px !important;
               
               }
               
               
               
             
               
           }
          
           @media (min-width: 992px) {
               .why-section img {
               
               float: right;
               max-width: 70%;
               }
               
               .why-content{
               
               padding-right: 30px;
               
               }
           }
          
        </style>
    <?php endif; ?>
    
    

    <div class="gck-benefits-box">
        <ul class="gck-benefits-list">
            <?php if ( !has_term( array( 'orto-bokserice', 'orto-bokserice2', 'starter-paketi' ), 'product_cat', $product_id ) ) : ?>
                <li><span class="gck-check">✔</span> <strong>Popolno prileganje</strong></li>
            <?php endif; ?>

            <li><strong>✔ Vrhunski materiali in natančen kroj</strong></li>
            <li><strong>✔ Udobje brez kompromisov</strong></li>

            <?php if ( has_term( array( 'orto-starter' ), 'product_cat', $product_id ) ) : ?>
                <li style="color: #c00;"><strong>✔ Začetni paket na voljo samo enkrat na osebo</strong></li>
                <li style="color: #c00;"><strong>✔ Omejeno na 1.000 paketov</strong></li>
            <?php endif; ?>
        </ul>

        <?php if ( ! $show_countdown ) : ?>
        <a id="open-size-chartCustom" href="#size-chart" class="gck-size-link">
            <svg style="margin-right: 5px; width: 23px; height: 23px; display: inline-block; vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                <path d="M11.4124 2.58464L2.08525 11.9118C1.86558 12.1315 1.86558 12.4876 2.08525 12.7073L5.78977 16.4118C6.00944 16.6315 6.3656 16.6315 6.58527 16.4118L15.9124 7.08466C16.1321 6.86499 16.1321 6.50883 15.9124 6.28916L12.2079 2.58464C11.9883 2.36497 11.6321 2.36497 11.4124 2.58464Z" stroke="#111213" stroke-width="0.84375"></path>
                <path d="M9.28125 4.71875L11.5312 6.96875M6.75 7.25L9 9.5M4.21875 9.78125L6.46875 12.0312" stroke="#111213" stroke-width="0.84375"></path>
            </svg>
            Tabela velikosti
        </a>
        <?php endif; ?>
    </div>

    <div class="gck-top-banner-wrap">
        <?php if ( has_term( array( 'orto-starter' ), 'product_cat', $product_id ) ) : ?>
            <!-- divider/timer removed in your current code -->
            
            <div class="gck-divider">
           <!-- <span>Više komada, veća ušteda!</span>-->
           <span>Izberite svoj ekskluzivni<br/> začetni paket</span>
        </div>
        
        
        <?php endif; ?>
    </div>

    <?php if ( has_term( array( 'orto-starter' ), 'product_cat', $product_id ) ) : ?>
        <div class="dev-banner" data-total="1000" data-sold="354">
            <div class="dev-banner__text">
                <span class="dev-banner__icon">📦</span>
                <span>Omejena količina <b class="sold">0</b> / <b class="total">0</b> (Še <b class="remain">0</b> kosov)</span>
            </div>
            <div class="dev-banner__bar" aria-label="Sales progress">
                <div class="dev-banner__fill"></div>
            </div>
        </div>
    <?php elseif ( ! $show_countdown ) : ?>
        <div style="height: 10px;"></div>
    <?php endif; ?>

    <style>
      .dev-banner{   font-size: 14px; color: black; max-width: 100%; margin-bottom: 12px; margin-top: 7px; }
      .dev-banner__text{ display: flex; align-items: center; gap: 8px; margin-bottom: 0px; padding-top: 10px; background: #e9f7f0; padding-bottom: 10px; justify-content: center; border-radius: 3px 0 0 3px; }
      .dev-banner__text b{ color:#333; font-weight:700; }
      .dev-banner__icon{ font-size: 14px; }
      .dev-banner__bar{ height: 12px; border-radius: 3px; overflow: hidden; background: repeating-linear-gradient(135deg,#efefef 0px,#efefef 10px,#e6e6e6 10px,#e6e6e6 20px); }
      .dev-banner__fill{ height: 100%; width: 0%; background: #2e7d32; border-radius: 3px 0 0 3px; }
    </style>

    <script>
      (function () {
        const el = document.querySelector(".dev-banner");
        if (!el) return;
        const total = Number(el.dataset.total) || 1;
        const sold = Math.min(Math.max(Number(el.dataset.sold) || 0, 0), total);
        const remaining = total - sold;
        const pct = (sold / total) * 100;

        el.querySelector(".sold").textContent = sold;
        el.querySelector(".total").textContent = total;
        el.querySelector(".remain").textContent = remaining;
        el.querySelector(".dev-banner__fill").style.width = pct + "%";
      })();
    </script>

    <?php if ( $show_countdown ) : ?>
        <style>
          .gck-countdown{
              background:#fdeeee;
              border:1px solid #f3c9c9;
              border-left:5px solid #c00;
              border-radius:4px; padding:14px 16px; margin:14px 0;
              font-family:'Roboto', sans-serif; color:#333; text-align:left;
          }
          .gck-countdown__head{
              display:flex; align-items:center; gap:8px;
              color:#c00; font-weight:800; font-size:16px;
              margin-bottom:6px; line-height:1.2;
          }
          .gck-countdown__icon{ font-size:18px; line-height:1; animation:gckCdPulse 1.3s ease-in-out infinite; }
          .gck-countdown__body{ font-size:14px; line-height:1.45; color:#333; }
          .gck-countdown__body strong{ color:#c00; font-weight:800; }
          .gck-countdown__timer{ font-weight:800; color:#c00; font-variant-numeric:tabular-nums; white-space:nowrap; }
          @keyframes gckCdPulse{ 0%,100%{ transform:scale(1); } 50%{ transform:scale(1.18); } }
          @media (prefers-reduced-motion: reduce){ .gck-countdown__icon{ animation:none; } }
          @media (max-width: 767px){
              .gck-countdown{ padding:12px 13px; margin:11px 0; }
              .gck-countdown__head{ font-size:15px; }
              .gck-countdown__icon{ font-size:16px; }
              .gck-countdown__body{ font-size:13px; }
          }
        </style>
        <div class="gck-countdown" id="gck-countdown"
             data-minutes="<?php echo esc_attr( $countdown_minutes ); ?>"
             data-key="gck_cd_<?php echo esc_attr( $product_id ); ?>">
            <div class="gck-countdown__head">
                <span class="gck-countdown__icon">🔥</span>
                Omejena zaloga
            </div>
            <div class="gck-countdown__body">
                Akcija velja samo danes — še <span class="gck-countdown__timer" aria-live="polite">--:--</span>.<?php
                if ( $countdown_stock > 0 ) :
                    ?> Ostalo le <strong><?php echo esc_html( $countdown_stock ); ?> kosov</strong>.<?php
                endif; ?> <strong>Pohiti, preden jih zmanjka!</strong>
            </div>
        </div>
        <script>
          (function(){
              var el = document.getElementById('gck-countdown');
              if (!el) return;
              var minutes = parseInt(el.getAttribute('data-minutes'), 10) || 30;
              var key = el.getAttribute('data-key') || 'gck_cd_default';
              var timerEl = el.querySelector('.gck-countdown__timer');
              var durationMs = minutes * 60 * 1000;
              var now = Date.now();
              var end;
              try {
                  var stored = window.localStorage.getItem(key);
                  end = stored ? parseInt(stored, 10) : 0;
                  if (!end || isNaN(end) || end <= now) {
                      end = now + durationMs;
                      window.localStorage.setItem(key, String(end));
                  }
              } catch (e) {
                  end = now + durationMs;
              }
              function pad(n){ return (n < 10 ? '0' : '') + n; }
              function tick(){
                  var diff = end - Date.now();
                  if (diff <= 0){
                      // Restart the timer so it stays "evergreen".
                      end = Date.now() + durationMs;
                      try { window.localStorage.setItem(key, String(end)); } catch (e) {}
                      diff = durationMs;
                  }
                  var totalSec = Math.floor(diff / 1000);
                  var h = Math.floor(totalSec / 3600);
                  var m = Math.floor((totalSec % 3600) / 60);
                  var s = totalSec % 60;
                  timerEl.textContent = h > 0
                      ? (pad(h) + ':' + pad(m) + ':' + pad(s))
                      : (pad(m) + ':' + pad(s));
              }
              tick();
              setInterval(tick, 1000);
          })();
        </script>
    <?php endif; ?>

    <?php if ( $show_countdown ) : ?>
    <div class="gck-size-link-wrap" style="text-align:right; margin:0 0 8px 0;">
        <a id="open-size-chartCustom" href="#size-chart" class="gck-size-link">
            <svg style="margin-right: 5px; width: 23px; height: 23px; display: inline-block; vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                <path d="M11.4124 2.58464L2.08525 11.9118C1.86558 12.1315 1.86558 12.4876 2.08525 12.7073L5.78977 16.4118C6.00944 16.6315 6.3656 16.6315 6.58527 16.4118L15.9124 7.08466C16.1321 6.86499 16.1321 6.50883 15.9124 6.28916L12.2079 2.58464C11.9883 2.36497 11.6321 2.36497 11.4124 2.58464Z" stroke="#111213" stroke-width="0.84375"></path>
                <path d="M9.28125 4.71875L11.5312 6.96875M6.75 7.25L9 9.5M4.21875 9.78125L6.46875 12.0312" stroke="#111213" stroke-width="0.84375"></path>
            </svg>
            Tabela velikosti
        </a>
    </div>
    <?php endif; ?>

    <div id="bundle-selector" class="bundle-box" data-split-garments="<?php echo $gck_split_garments ? '1' : '0'; ?>">
        <?php
        $default_index = ( $precheck_second && count( $offers ) > 1 ) ? 1 : 0;
        $loop_index    = 0;

        foreach ( $offers as $offer_id => $data ) :
            $pairs = (int) ( $data['qty'] ?? 0 );
            if ( $pairs <= 0 ) continue;

            $is_default = ( $loop_index === $default_index );

            $offer_p1 = trim((string)($data['p1'] ?? ''));
            $offer_p2 = trim((string)($data['p2'] ?? ''));
            $offer_tip = strtolower(trim((string)($data['tip'] ?? ''))); // NEW

            // Decide which selector OPTIONS to show for each group in 4-attr case.
            // IMPORTANT: we keep group field keys as-is so values do NOT overwrite.
            // - mixed (or empty) => group0 uses group0 options, group1 uses group1 options
            // - majica => BOTH groups show majica options (source group 0), but group1 keeps its own field keys
            // - bokserica => BOTH groups show bokserica options (source group 1), but group0 keeps its own field keys
            $force_source_group = null; // null = normal
            if ( $show_group_titles ) {
                if ( $offer_tip === 'majica' ) {
                    $force_source_group = 0;
                } elseif ( $offer_tip === 'bokserica' || $offer_tip === 'bokserice' ) {
                    $force_source_group = 1;
                } // mixed or empty => null
            }

            // Price highlights: per-piece regular price + discount %.
            // SHBOX split: real piece count is pairs * 2 (majice + bokserice).
            $gck_pieces   = $gck_split_garments ? ( $pairs * 2 ) : $pairs;
            $per_regular  = ( $gck_pieces > 0 ) ? ( (float) $data['regular'] / $gck_pieces ) : 0;
            $gck_per_new  = $gck_split_garments
                ? ( ( $gck_pieces > 0 ) ? ( floor( ( (float) $data['total'] / $gck_pieces ) * 100 ) / 100 ) : 0 )
                : (float) $data['per'];
            $discount_pct = ( (float) $data['regular'] > 0 )
                ? (int) round( ( ( (float) $data['regular'] - (float) $data['total'] ) / (float) $data['regular'] ) * 100 )
                : 0;
        ?>
            <label style="position: relative; <?php if ( ($loop_index == 1 ||  $loop_index == 3) && ! $show_group_titles) : ?> margin-top: 25px;  <?php endif; ?>"
                   class="bundle-option<?php echo $is_default ? ' active' : ''; ?>">

                <?php if ( ! $show_group_titles ) : ?>
                    <?php if ( $loop_index == 1 ) : ?>
                        <div class="gck-popular-badge">Najbolj priljubljeno 🔥</div>
                    <?php endif; ?>

                    <?php if ( $loop_index == 3 ) : ?>
                        <div class="gck-popular-badge-2">Najboljša cena 🔥</div>
                    <?php endif; ?>
                <?php endif; ?>

                <input type="radio"
                    required
                    name="bundle_option"
                    value="<?php echo esc_attr( $offer_id ); ?>"
                    data-total="<?php echo esc_attr( $data['total'] ); ?>"
                    data-qty="<?php echo esc_attr( $pairs ); ?>"
                    <?php checked( $is_default ); ?>>
                    
                    
                    
  

                <span class="bundle-option-title"><?php echo esc_html( $data['title'] ); ?></span>
                
                  <?php

    if (  !has_term( array( 'orto-starter' ), 'product_cat', $product_id )

    && !has_term( array( 'starter-paketi' ), 'product_cat', $product_id )

    )  :  ?>
                <?php if ( $show_price_highlights ) : ?>
                    <br class="gck-hl-break">
                    <span class="gck-per-chip">
                        <?php if ( $per_regular > $gck_per_new ) : ?>
                            <span class="gck-per-old"><?php echo number_format( $per_regular, 2 ); ?>€</span>
                        <?php endif; ?>
                        <span class="gck-per-new"><?php echo number_format( $gck_per_new, 2 ); ?>€ / kos</span>
                    </span>
                    <?php if ( $discount_pct > 0 ) : ?>
                        <span class="gck-discount-badge">−<?php echo (int) $discount_pct; ?>%</span>
                    <?php endif; ?>
                <?php else : ?>
                    — <span class="bundle-option-title"><?php echo number_format( $gck_per_new, 2 ); ?>€ / kos</span>
                <?php endif; ?>
                <?php endif; ?>
                

                <br/>

                <!--
                <div class="bundle-total-line">
                    <span style="font-weight:normal;">Skupaj:</span>
                    <span class="line-total"><?php echo number_format( (float) $data['total'], 2 ); ?>€</span>
                </div>

-->

<div class="bundle-total-line">
    <span style="font-weight:normal;">Skupaj:</span>

    <?php if ( ! empty($data['regular']) && (float)$data['regular'] > (float)$data['total'] ) : ?>
        <span class="gck-regular-price">
            <?php echo number_format( (float) $data['regular'], 2 ); ?>€
        </span>
    <?php endif; ?>

    <span class="line-total"><?php echo number_format( (float) $data['total'], 2 ); ?>€</span>
</div>



                <div class="bundle-pairs <?php echo $is_default ? '' : 'hidden'; ?>"
                     data-offer-id="<?php echo esc_attr( $offer_id ); ?>"
                     data-qty="<?php echo esc_attr( $pairs ); ?>">

                    <?php
                    // Gratis labels: parse "X+Y" from offer title (X = paid, Y = gratis).
                    $gck_paid = 0;
                    $gck_free = 0;
                    if ( $show_gratis && preg_match( '/(\d+)\s*\+\s*(\d+)/u', (string) ( $data['title'] ?? '' ), $gck_m ) ) {
                        $gck_paid = (int) $gck_m[1];
                        $gck_free = (int) $gck_m[2];
                    }
                    ?>
                    <?php
                    $gck_show_sections = ( $show_gratis && ! $show_group_titles && ( $gck_paid + $gck_free ) > 0 );
                    ?>
                    <?php
                    // Render passes. Normal: single pass, all groups interleaved per pair.
                    // SHBOX split (SKU NORIKS-ORTO-SHBOX): two sections — paid majice, then gratis bokserice.
                    if ( $gck_split_garments ) {
                        $gck_passes = array(
                            array( 'group' => 0, 'label' => 'Izberi ' . (int) $pairs . ' ' . gck_sl_majice_phrase( $pairs, false, 'majica' ), 'gratis' => false ),
                            array( 'group' => 1, 'label' => 'Izberi še ' . (int) $pairs . ' ' . gck_sl_majice_phrase( $pairs, true, 'bokserica' ), 'gratis' => true ),
                        );
                    } else {
                        $gck_passes = array( array( 'group' => null, 'label' => null, 'gratis' => false ) );
                    }
                    ?>
                    <?php foreach ( $gck_passes as $gck_pass ) : ?>
                        <?php if ( $gck_pass['label'] !== null ) : ?>
                            <div class="gck-pair-label<?php echo $gck_pass['gratis'] ? ' is-gratis' : ''; ?>"><?php echo esc_html( $gck_pass['label'] ); ?></div>
                        <?php endif; ?>
                    <?php for ( $i = 1; $i <= $pairs; $i++ ) : ?>
                        <?php if ( $gck_pass['group'] === null && $gck_show_sections && $gck_paid > 0 && $i === 1 ) : ?>
                            <div class="gck-pair-label">Izberi <?php echo (int) $gck_paid; ?> <?php echo esc_html( gck_sl_majice_phrase( $gck_paid, false, $gck_garment ) ); ?></div>
                        <?php endif; ?>
                        <?php if ( $gck_pass['group'] === null && $gck_show_sections && $gck_free > 0 && $i === ( $gck_paid + 1 ) ) : ?>
                            <div class="gck-pair-label is-gratis">Izberi še <?php echo (int) $gck_free; ?> <?php echo esc_html( gck_sl_majice_phrase( $gck_free, true, $gck_garment ) ); ?></div>
                        <?php endif; ?>
                        <div class="bundle-pair">
                            <?php foreach ( $attr_groups as $g_index => $group ) :
                                if ( $gck_pass['group'] !== null && $g_index !== $gck_pass['group'] ) continue;

                                // Target group (field keys used for saving)
                                $target_c = $group['color'] ?? null;
                                $target_s = $group['size'] ?? null;

                                $target_color_field_key = $target_c ? (string)($target_c['field_key'] ?? '') : '';
                                $target_color_attr_key  = $target_c ? (string)($target_c['key'] ?? '') : '';
                                $target_size_field_key  = $target_s ? (string)($target_s['field_key'] ?? '') : '';
                                $target_size_attr_key   = $target_s ? (string)($target_s['key'] ?? '') : '';

                                // Source group (options shown to user)
                                $source_index = $g_index;
                                if ( $force_source_group !== null && isset($attr_groups[$force_source_group]) ) {
                                    $source_index = (int)$force_source_group;
                                }

                                $source_group = $attr_groups[$source_index] ?? $group;
                                $source_c = $source_group['color'] ?? null;
                                $source_s = $source_group['size'] ?? null;

                                $color_values = $source_c ? (array)($source_c['values'] ?? []) : [];
                                $size_values  = $source_s ? (array)($source_s['values'] ?? []) : [];

                                if ( empty($color_values) && empty($size_values) ) continue;

                                // Headings (p1/p2) in 4-attr case:
                                $group_title = '';
                                if ( $show_group_titles ) {
                                    if ( $g_index === 0 && $offer_p1 !== '' ) $group_title = $offer_p1;
                                    if ( $g_index === 1 && $offer_p2 !== '' ) $group_title = $offer_p2;
                                }
                            ?>
                                <?php if ( $show_group_titles && ! $gck_split_garments && $group_title !== '' ) : ?>
                                    <div class="gck-group-title"><?php echo esc_html($group_title); ?></div>
                                <?php endif; ?>

                                <div class="bundle-attr-row">

                                    <?php if ( ! empty($color_values) && $target_color_field_key !== '' ) : ?>
                                        <div class="color-swatches"
                                             data-attr-key="<?php echo esc_attr($target_color_attr_key); ?>"
                                             data-name="pairs[<?php echo esc_attr( $offer_id ); ?>][<?php echo $i; ?>][<?php echo esc_attr( $target_color_field_key ); ?>]">

                                            <?php foreach ( $color_values as $val ) :
                                                $slug = sanitize_title( $val );
                                                $hex = gck_get_color_hex( $val );
                                                $inline = '';
                                                if ( $hex ) {
                                                    $inline = 'background:' . esc_attr($hex) . ';';
                                                    if ( strtolower(trim($hex)) === '#fff' || strtolower(trim($hex)) === '#ffffff' ) {
                                                        $inline .= 'border:1px solid #ccc;';
                                                    }
                                                }
                                            ?>
                                                <div class="swatch" data-value="<?php echo esc_attr( $val ); ?>" title="<?php echo esc_attr( $val ); ?>">
                                                    <span class="swatch-circle color-<?php echo esc_attr( $slug ); ?>"<?php if ($inline) echo ' style="' . $inline . '"'; ?>></span>
                                                </div>
                                            <?php endforeach; ?>

                                            <input type="hidden"
                                                   class="swatch-input"
                                                   data-attr-key="<?php echo esc_attr($target_color_attr_key); ?>"
                                                   name="pairs[<?php echo esc_attr( $offer_id ); ?>][<?php echo $i; ?>][<?php echo esc_attr( $target_color_field_key ); ?>]"
                                                   value="">
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( ! empty($size_values) && $target_size_field_key !== '' ) : ?>
                                        <select
                                            class="gck-size-select"
                                            data-size-key="<?php echo esc_attr($target_size_attr_key); ?>"
                                            data-garment-group="<?php echo (int) $g_index; ?>"
                                            name="pairs[<?php echo esc_attr( $offer_id ); ?>][<?php echo $i; ?>][<?php echo esc_attr( $target_size_field_key ); ?>]">
                                            <?php foreach ( $size_values as $val ) : ?>
                                                <option value="<?php echo esc_attr( $val ); ?>">
                                                    <?php echo esc_html( $val ); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endfor; ?>
                    <?php endforeach; ?>

                    <small style="display: block; line-height: 1.3; margin-top: 14px;"><?php esc_html_e( 'Ponujamo 30 dni za vračilo denarja ali brezplačno zamenjavo izdelka – brezskrbno nakupovanje!
', 'gift-card-kompetentnost' ); ?></small>
                </div>
            </label>
        <?php
        $loop_index++;
        endforeach;
        ?>

        <input type="hidden" id="bundle_quantity" name="quantity" value="1">
    </div>

    <?php
    get_template_part( 'template_parts/size-chart-modal' );
}

// ============================================================
// FRONTEND JS
// ============================================================

add_action( 'wp_footer', 'gck_bundle_js' );
function gck_bundle_js() {
    if ( ! is_product() ) return;

    global $post;
    if ( ! $post || $post->post_type !== 'product' ) return;
    if ( ! gck_is_orto_bundle_enabled( $post->ID ) ) return;
    ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal   = document.getElementById("custom-size-chart-modal");
    const openBtn = document.getElementById("open-size-chartCustom");
    const closeX  = document.getElementById("close-size-chart-x");
    if (!modal) return;

    openBtn?.addEventListener("click", function (e) { e.preventDefault(); modal.classList.add("show"); });
    closeX?.addEventListener("click", function () { modal.classList.remove("show"); });

    modal.addEventListener("click", function (e) {
        if (e.target === modal) modal.classList.remove("show");
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") modal.classList.remove("show");
    });
});

document.addEventListener('DOMContentLoaded', function () {

    // default color + size
    document.querySelectorAll('.bundle-pairs').forEach(wrap => {
        wrap.querySelectorAll('.bundle-pair').forEach(pair => {
            pair.querySelectorAll('.color-swatches').forEach(swGroup => {
                const firstSwatch = swGroup.querySelector('.swatch');
                const hidden      = swGroup.querySelector('.swatch-input');
                if (firstSwatch && hidden) {
                    swGroup.querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
                    firstSwatch.classList.add('active');
                    hidden.value = firstSwatch.dataset.value || '';
                }
            });
            pair.querySelectorAll('select').forEach(sel => {
                const firstOpt = sel.querySelector('option:nth-child(1)');
                if (firstOpt) sel.value = firstOpt.value;
            });
        });
    });

    const selector = document.getElementById('bundle-selector');
    if (!selector) return;

    const radios   = selector.querySelectorAll('input[name="bundle_option"]');
    const qtyField = document.getElementById('bundle_quantity');

    function updateBundleUI(selectedRadio) {
        const selectedOfferId = selectedRadio.value;

        selector.querySelectorAll('.bundle-option').forEach(card => card.classList.remove('active'));
        selectedRadio.closest('.bundle-option')?.classList.add('active');

        selector.querySelectorAll('.bundle-pairs').forEach(wrap => {
            const oid = wrap.getAttribute('data-offer-id');
            wrap.classList.toggle('hidden', oid !== selectedOfferId);
        });

        if (qtyField) qtyField.value = 1;

        const total = selectedRadio.dataset.total;
        const priceElem = document.querySelector('.cart .summary .price .woocommerce-Price-amount');
        if (priceElem && total) {
            priceElem.innerHTML = total.replace('.', ',') + ' €';
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', function () { updateBundleUI(this); });
        if (radio.checked) updateBundleUI(radio);
    });

    // validation
    const form = document.querySelector('form.cart');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        const selectedRadio = selector.querySelector('input[name="bundle_option"]:checked');
        if (!selectedRadio) return;

        const offerId = selectedRadio.value;
        const wrap  = selector.querySelector('.bundle-pairs[data-offer-id="' + offerId + '"]');
        if (!wrap) return;

        let valid = true;

        wrap.querySelectorAll('.bundle-pair').forEach(pair => {
            pair.querySelectorAll('select').forEach(sel => {
                if (!sel.value) { valid = false; sel.classList.add('woocommerce-invalid'); }
                else sel.classList.remove('woocommerce-invalid');
            });

            pair.querySelectorAll('.swatch-input').forEach(hidden => {
                if (!hidden.value) { valid = false; hidden.classList.add('woocommerce-invalid'); }
                else hidden.classList.remove('woocommerce-invalid');
            });
        });

        if (!valid) {
            e.preventDefault();
            alert('Prosimo, izberite barvo in velikost za vsak komplet.');
        }
    });

    // swatches
    document.querySelectorAll('.color-swatches').forEach(swWrap => {
        const hidden = swWrap.querySelector('.swatch-input');
        if (!hidden) return;

        swWrap.querySelectorAll('.swatch').forEach(swatch => {
            swatch.addEventListener('click', () => {
                swWrap.querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
                swatch.classList.add('active');
                hidden.value = swatch.dataset.value || '';
                hidden.classList.remove('woocommerce-invalid');
            });
        });
    });

});

/* Size sync per size attribute */
document.addEventListener("DOMContentLoaded", function () {
    function activateSizeSync() {
        const selectorEl = document.getElementById('bundle-selector');
        const splitMode  = !!(selectorEl && selectorEl.dataset.splitGarments === '1');

        document.querySelectorAll('.bundle-pairs').forEach(pairBlock => {
            // Which selects act as "drivers" (their change syncs the others):
            // Normal: the first pair's size selects (one per size attribute).
            // Split (SHBOX): only the FIRST size select of each garment group
            // (first majica, first bokserica). The 2nd/3rd stay independent.
            let drivers;
            if (splitMode) {
                const seenGroup = {};
                drivers = [];
                pairBlock.querySelectorAll('select.gck-size-select').forEach(s => {
                    const grp = s.dataset.garmentGroup || '';
                    if (seenGroup[grp]) return;
                    seenGroup[grp] = true;
                    drivers.push(s);
                });
            } else {
                const firstPair = pairBlock.querySelector('.bundle-pair');
                drivers = firstPair ? Array.from(firstPair.querySelectorAll('select.gck-size-select')) : [];
            }

            drivers.forEach(firstSelect => {
                const sizeKey = firstSelect.dataset.sizeKey || '';
                if (!sizeKey) return;

                if (firstSelect.dataset.gckBound === '1') return;
                firstSelect.dataset.gckBound = '1';

                firstSelect.addEventListener('change', function () {
                    const newSize  = this.value;
                    const selector = document.getElementById('bundle-selector');
                    if (!selector) return;

                    // Normal: sync this size across same-attribute selects in ALL pairs/offers.
                    // Split (SHBOX): sync only within the same garment group, so majice and
                    // bokserice are independent and the customer can pick different sizes.
                    let sel;
                    if (splitMode) {
                        const grp = this.dataset.garmentGroup || '';
                        sel = 'select.gck-size-select[data-garment-group="' + CSS.escape(grp) + '"]';
                    } else {
                        sel = 'select.gck-size-select[data-size-key="' + CSS.escape(sizeKey) + '"]';
                    }

                    selector
                        .querySelectorAll(sel)
                        .forEach(s => { if (s !== this) s.value = newSize; });
                });
            });
        });
    }

    activateSizeSync();

    document.querySelectorAll('#bundle-selector input[name="bundle_option"]').forEach(radio => {
        radio.addEventListener('change', function () {
            setTimeout(activateSizeSync, 50);
        });
    });
});
</script>
<?php
}

// ============================================================
// CART / ORDER LOGIC
// ============================================================

/**
 * Build cart/order lines.
 *
 * ✅ 2-attribute case: returns "Crna - L"
 * ✅ 4-attribute case: uses offer p1/p2 and returns TWO lines per pair:
 *   "P1: X - Y"
 *   "P2: X - Y"
 *
 * NOTE: It assumes post order is:
 *   color1, size1, color2, size2
 * (this remains TRUE even when tip=majica/bokserica because we kept distinct field keys)
 */
function gck_build_pair_lines( array $pairs_data, string $p1 = '', string $p2 = '' ) : array {
    $lines = [];

    foreach ( $pairs_data as $index => $attrs ) {
        if ( ! is_array( $attrs ) ) continue;

        $values = array_values( $attrs );
        $clean  = [];

        foreach ( $values as $v ) {
            $v = trim((string)$v);
            if ( $v !== '' ) $clean[] = $v;
        }

        if ( empty($clean) ) continue;

        if ( $p1 !== '' && $p2 !== '' && count($clean) >= 4 ) {
            $g1 = array_slice($clean, 0, 2);
            $g2 = array_slice($clean, 2, 2);

            $lines[] = $p1 . ': ' . implode(' - ', $g1);
            $lines[] = $p2 . ': ' . implode(' - ', $g2);
            continue;
        }

        $lines[] = implode(' - ', $clean);
    }

    return $lines;
}

add_filter( 'woocommerce_add_cart_item_data', 'gck_add_cart_item_data', 10, 3 );
function gck_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {

    $offer_id = isset( $_POST['bundle_option'] ) ? sanitize_text_field( wp_unslash( $_POST['bundle_option'] ) ) : '';

    if ( ! gck_is_orto_bundle_enabled( $product_id ) || $offer_id === '' ) {
        return $cart_item_data;
    }

    $offers = gck_get_bundle_offers( $product_id );
    if ( empty( $offers ) || ! isset( $offers[ $offer_id ] ) ) {
        return $cart_item_data;
    }

    $offer          = $offers[ $offer_id ];
    $pairs_selected = (int) ( $offer['qty'] ?? 0 );
    if ( $pairs_selected <= 0 ) {
        return $cart_item_data;
    }

    $p1 = trim((string)($offer['p1'] ?? ''));
    $p2 = trim((string)($offer['p2'] ?? ''));

    $pairs_all  = isset( $_POST['pairs'] ) ? (array) $_POST['pairs'] : [];
    $pairs_data = isset( $pairs_all[ $offer_id ] ) ? (array) $pairs_all[ $offer_id ] : [];

    $lines = gck_build_pair_lines( $pairs_data, $p1, $p2 );

    $total      = (float) $offer['total'];
    $unit_price = $total;

    $cart_item_data['_orto_offer_id']          = $offer_id;
    $cart_item_data['_orto_bundle_pairs']      = $pairs_selected;
    $cart_item_data['_orto_bundle_total']      = $total;
    $cart_item_data['_orto_bundle_unit_price'] = $unit_price;
    $cart_item_data['_orto_pairs_json']        = wp_json_encode( $pairs_data );
    $cart_item_data['_orto_lines']             = $lines;

    $cart_item_data['_orto_p1'] = $p1;
    $cart_item_data['_orto_p2'] = $p2;

    $cart_item_data['orto_unique_key'] = md5( microtime( true ) . wp_rand() . serialize( $cart_item_data ) );

    return $cart_item_data;
}

function gck_apply_price_to_cart_item( $cart_item ) {
    if ( isset( $cart_item['_orto_bundle_unit_price'] ) && $cart_item['data'] instanceof WC_Product ) {
        $price = (float) $cart_item['_orto_bundle_unit_price'];
        if ( $price > 0 ) {
            $cart_item['data']->set_price( $price );
        }
    }
    return $cart_item;
}

add_filter( 'woocommerce_add_cart_item', 'gck_add_cart_item_apply_price', 20, 2 );
function gck_add_cart_item_apply_price( $cart_item, $cart_item_key ) {
    return gck_apply_price_to_cart_item( $cart_item );
}

add_filter( 'woocommerce_get_cart_item_from_session', 'gck_session_cart_item_apply_price', 20, 2 );
function gck_session_cart_item_apply_price( $cart_item, $values ) {
    if ( isset( $values['_orto_bundle_unit_price'] ) ) $cart_item['_orto_bundle_unit_price'] = $values['_orto_bundle_unit_price'];
    if ( isset( $values['_orto_lines'] ) ) $cart_item['_orto_lines'] = $values['_orto_lines'];
    if ( isset( $values['_orto_offer_id'] ) ) $cart_item['_orto_offer_id'] = $values['_orto_offer_id'];
    if ( isset( $values['_orto_p1'] ) ) $cart_item['_orto_p1'] = $values['_orto_p1'];
    if ( isset( $values['_orto_p2'] ) ) $cart_item['_orto_p2'] = $values['_orto_p2'];
    return gck_apply_price_to_cart_item( $cart_item );
}

add_action( 'woocommerce_before_calculate_totals', 'gck_adjust_bundle_price', 9999 );
function gck_adjust_bundle_price( $cart ) {
    if ( ! $cart instanceof WC_Cart ) return;
    foreach ( $cart->get_cart() as $key => &$item ) {
        $item = gck_apply_price_to_cart_item( $item );
    }
}

add_filter( 'woocommerce_get_item_data', 'gck_display_item_data', 10, 2 );
function gck_display_item_data( $item_data, $cart_item ) {

    if ( empty( $cart_item['_orto_lines'] ) || ! is_array( $cart_item['_orto_lines'] ) ) {
        return $item_data;
    }

    $lines     = array_values( $cart_item['_orto_lines'] );
    $numbered  = [];
    foreach ( $lines as $i => $line ) {
        $numbered[] = ( $i + 1 ) . ': ' . $line;
    }

    $value = implode( '<br>', array_map( 'esc_html', $numbered ) );

    $item_data[] = array(
        'name'    => false,
        'display' => $value,
    );

    return $item_data;
}

add_action( 'woocommerce_checkout_create_order_line_item', 'gck_order_item_meta', 10, 4 );
function gck_order_item_meta( $item, $cart_item_key, $values, $order ) {

    if ( empty( $values['_orto_lines'] ) || ! is_array( $values['_orto_lines'] ) ) {
        return;
    }

    $lines = array_values( $values['_orto_lines'] );
    foreach ( $lines as $i => $line ) {
        $item->add_meta_data( (string) ( $i + 1 ), sanitize_text_field( $line ), true );
    }

    if ( ! empty( $values['_orto_bundle_pairs'] ) ) {
        $item->add_meta_data( '_bundle_pairs', (int) $values['_orto_bundle_pairs'], true );
    }

    if ( ! empty( $values['_orto_offer_id'] ) ) {
        $item->add_meta_data( '_offer_id', sanitize_text_field( $values['_orto_offer_id'] ), true );
    }
}
