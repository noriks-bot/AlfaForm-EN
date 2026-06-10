<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>


<script>
    
  (function ($) {
  /* Add +/- buttons around every qty input */
  function addQtyButtons(ctx) {
    $(ctx).find('.quantity').each(function () {
      if (!$(this).find('.qty-btn').length) {
      $(this).prepend('<div class="qty-btn-group"><button type="button" class="qty-btn minus">−</button></div>');
$(this).append('<div class="qty-btn-group"><button type="button" class="qty-btn plus">+</button></div>');
      }
    });
  }

  /* Queue an auto update on the cart page */
  let updateTimer = null;
  function queueCartUpdate() {
    if (!$('body').hasClass('woocommerce-cart')) return;
    const $btn = $('button[name="update_cart"]');
    $btn.prop('disabled', false);   // Woo disables this by default
    clearTimeout(updateTimer);
    updateTimer = setTimeout(function () {
      $btn.trigger('click');
    }, 400); // debounce so multiple clicks don’t spam
  }

  /* Handle +/- clicks */
  $(document).on('click', '.qty-btn', function (e) {
    e.preventDefault();
    const $qty = $(this).closest('.quantity').find('input.qty');
    let val  = parseFloat(($qty.val() + '').replace(',', '.')) || 0;
    const min  = isNaN(parseFloat($qty.attr('min')))  ? 0      : parseFloat($qty.attr('min'));
    const max  = isNaN(parseFloat($qty.attr('max')))  ? Infinity : parseFloat($qty.attr('max'));
    const step = isNaN(parseFloat($qty.attr('step'))) ? 1      : parseFloat($qty.attr('step'));
    const prec = (step.toString().split('.')[1] || '').length;

    if ($(this).hasClass('plus'))  val = Math.min(val + step, max);
    if ($(this).hasClass('minus')) val = Math.max(val - step, min);

    $qty.val(val.toFixed(prec));

    // Fire events that some themes/hooks listen to
    $qty.trigger('input').trigger('change').trigger('keyup');

    // On cart page, auto submit the hidden Update Cart button
    queueCartUpdate();
  });

  /* Init on first load and after Woo AJAX refreshes */
  function init() { addQtyButtons(document); }
  $(document).ready(init);
  $(document.body).on(
    'updated_wc_div updated_cart_totals wc_fragments_refreshed wc_fragments_loaded',
    function () { addQtyButtons(document); }
  );
})(jQuery);
    
</script>


<section class="cart-section">
<div style="    display: block;
    max-width: 1440px;
    width: 100%;
    margin: 0 auto;" class="cart-container container">
    
    
    
    <!-- !!!!!!     COUNTDOWN    TIMER   !!! --!>
                <!-- KOŠARICA – OBAVIJEST O REZERVACIJI -->
                <div class="wc-reserve-note" id="wc-reserve-note" role="status" aria-live="polite">
                  <span class="wc-reserve-note__icon" aria-hidden="true">
                    <!-- ikona "i" -->
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                      <circle cx="12" cy="12" r="10" stroke-width="1.6"></circle>
                      <line x1="12" y1="10" x2="12" y2="16" stroke-width="1.6"></line>
                      <circle cx="12" cy="7" r="1" stroke="none" fill="currentColor"></circle>
                    </svg>
                  </span>
                  <span class="wc-reserve-note__text">
                    Molimo, požuri! Netko je upravo naručio jedan od proizvoda u tvojoj košarici. 
                    Rezervacija velja samo še <strong id="wc-reserve-timer">10:00</strong> minut.
                  </span>
                </div>
                
                <style>
                /* ====== Traka s rezervacijom ====== */
                .wc-reserve-note{
                  display:flex;
                  align-items:center;
                  justify-content:center;  /* centrirano vodoravno */
                  gap:.75rem;
                  background:#FFF2DC;
                  color:#222;
                  padding:14px 18px;
                  border-radius:2px;
                  border:1px solid rgba(0,0,0,.06);
                  box-shadow: inset 0 0 0 1px rgba(255,255,255,.3);
                  font-size:15px;
                  line-height:1.5;
                  text-align:center;       /* centrirani tekst */
                  margin-bottom: 20px;
                }
                .wc-reserve-note__icon{
                  display:inline-flex; width:22px; height:22px;
                  align-items:center; justify-content:center;
                  color:#333;
                }
                .wc-reserve-note strong#wc-reserve-timer{
                  font-weight:800;
                }
                @media (max-width:480px){
                  .wc-reserve-note{ font-size:14px; padding:12px 14px; }
                  .wc-reserve-note__icon{ width:20px; height:20px; }
                }
                </style>
                
                <script>
                /* Countdown 10 minuta */
                (function () {
                  var DISPLAY_ID = 'wc-reserve-timer';
                  var STORAGE_KEY = 'wcReserveStart';
                  var LIMIT_MS = 10 * 60 * 1000; // 10 minuta
                  var display = document.getElementById(DISPLAY_ID);
                  if (!display) return;
                
                  var now = Date.now();
                  var start = sessionStorage.getItem(STORAGE_KEY);
                  if (!start) {
                    start = now;
                    sessionStorage.setItem(STORAGE_KEY, String(start));
                  } else {
                    start = parseInt(start, 10);
                  }
                
                  function format(ms) {
                    if (ms < 0) ms = 0;
                    var totalSec = Math.floor(ms / 1000);
                    var m = Math.floor(totalSec / 60);
                    var s = totalSec % 60;
                    return (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
                  }
                
                  function tick() {
                    var elapsed = Date.now() - start;
                    var left = LIMIT_MS - elapsed;
                    display.textContent = format(left);
                
                    if (left <= 0) {
                      clearInterval(timer);
                      var bar = document.getElementById('wc-reserve-note');
                      if (bar) bar.style.display = 'none';
                      sessionStorage.removeItem(STORAGE_KEY);
                    }
                  }
                
                  tick();
                  var timer = setInterval(tick, 1000);
                })();
                </script>




<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead style="background:#fafafa !important;">
			<tr style="background:#fafafa !important;" >
		
				<th style="background:#fafafa !important;" class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e( 'Thumbnail image', 'woocommerce' ); ?></span></th>
				<th style="background:#fafafa !important;"  scope="col" class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th style="background:#fafafa !important;" scope="col" class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th style="background:#fafafa !important;"  scope="col" class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th style="background:#fafafa !important;" scope="col" class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
						<th style="background:#fafafa !important;" class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'Remove item', 'woocommerce' ); ?></span></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				/**
				 * Filter the product name.
				 *
				 * @since 2.1.0
				 * @param string $product_name Name of the product in the cart.
				 * @param array $cart_item The product in the cart.
				 * @param string $cart_item_key Key for the product in the cart.
				 */
				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr style="border: 1px solid #e6e6e6 !important;" class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-thumbnail">
						<?php
						/**
						 * Filter the product thumbnail displayed in the WooCommerce cart.
						 *
						 * This filter allows developers to customize the HTML output of the product
						 * thumbnail. It passes the product image along with cart item data
						 * for potential modifications before being displayed in the cart.
						 *
						 * @param string $thumbnail     The HTML for the product image.
						 * @param array  $cart_item     The cart item data.
						 * @param string $cart_item_key Unique key for the cart item.
						 *
						 * @since 2.1.0
						 */
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo $thumbnail; // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
						}
						?>
						</td>

						<td scope="row" role="rowheader" class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( $product_name . '&nbsp;' );
						} else {
						
						
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}
						?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$min_quantity = 1;
							$max_quantity = 1;
						} else {
							$min_quantity = 0;
							$max_quantity = $_product->get_max_purchase_quantity();
						}

						$product_quantity = woocommerce_quantity_input(
							array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $max_quantity,
								'min_value'    => $min_quantity,
								'product_name' => $product_name,
							),
							$_product,
							false
						);

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>
						
						
						
						<td class="product-remove">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a role="button" href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										/* translators: %s is the product name */
										esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
						</td>

					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>





<?php
/**
 * CART UPSELL — Simple + Variable (multi-attribute safe + no reload + remove button + instant bg + loader)
 * FIX: don't trust add_to_cart response; after add, refresh cart and check if upsell is in cart.
 *
 * ✅ NEW:
 * - If upsell is in cart: hide Add button, show Remove button
 * - If upsell is in cart: disable size buttons (not clickable)
 * - Select first size by default (when not added)
 * - Move size buttons + add/remove BELOW description (inside right column)
 */


$TRIGGER_CATEGORY_SLUGS = array( 'boksarice', 'boksarice-sestavi-paket', '1-kos-boksarice', 'orto-bokserice', 'majice-in-boksarice-paketi', 'black-friday' );

$UPSELL_ID_CAT  = 4154;  // ID1 (when category match)
$UPSELL_ID_ELSE = 4162;  // ID2 (when NO category match) <-- change 999 to your real product id



$cart = WC()->cart;
if ( ! $cart ) { return; }

// Decide which upsell to show
$has_category_match = false;

foreach ( $cart->get_cart() as $item ) {
  $product_id   = ! empty($item['product_id']) ? (int) $item['product_id'] : 0;
  $variation_id = ! empty($item['variation_id']) ? (int) $item['variation_id'] : 0;

  // If variation, check parent product categories
  $check_id = $variation_id ? (int) wp_get_post_parent_id( $variation_id ) : $product_id;
  if ( ! $check_id ) continue;

  if ( has_term( $TRIGGER_CATEGORY_SLUGS, 'product_cat', $check_id ) ) {
    $has_category_match = true;
    break;
  }
}

// IF category match -> use ID1, ELSE -> use ID2
$UPSELL_ID = $has_category_match ? (int) $UPSELL_ID_CAT : (int) $UPSELL_ID_ELSE;







// Load upsell
$upsell_obj = wc_get_product( $UPSELL_ID );
if ( ! $upsell_obj ) { return; }

$is_variation       = $upsell_obj->is_type('variation');
$is_variable_parent = $upsell_obj->is_type('variable');
$is_simple          = ! $is_variation && ! $is_variable_parent;

$upsell_parent_id    = $is_variation ? (int) $upsell_obj->get_parent_id() : (int) $UPSELL_ID;
$upsell_variation_id = $is_variation ? (int) $UPSELL_ID : 0;

// If variation, capture its attributes for adding
$forced_variation_attrs = array();
if ( $is_variation ) {
  $forced_variation_attrs = (array) $upsell_obj->get_variation_attributes(); // attribute_pa_size => 's'
}

// Variable parent: build variations + attribute options
$variation_data = array();
$attr_options   = array(); // [attribute_pa_size => [slug1, slug2]]
$attr_labels    = array(); // [attribute_pa_size => 'Size']

if ( $is_variable_parent ) {
  $variable       = $upsell_obj;
  $variation_data = (array) $variable->get_available_variations();

  $va = (array) $variable->get_variation_attributes();
  foreach ( $va as $attr_key => $values ) {
    $field = wc_variation_attribute_name( $attr_key ); // attribute_pa_size
    $attr_options[$field] = array_values(array_filter(array_map('strval', (array)$values)));

    if ( taxonomy_exists( $attr_key ) ) {
      $tax = wc_attribute_taxonomy_name( wc_sanitize_taxonomy_name( $attr_key ) );
      $attr_labels[$field] = wc_attribute_label( $tax );
    } else {
      $attr_labels[$field] = wc_attribute_label( $attr_key );
    }
  }
}

// Required attribute keys for variable parent
$required_attrs = $is_variable_parent ? array_keys($attr_options) : array();

// Detect upsell in cart
$upsell_in_cart  = false;
$upsell_cart_key = '';

foreach ( $cart->get_cart() as $k => $item ) {
  $pid = isset($item['product_id']) ? (int)$item['product_id'] : 0;
  $vid = isset($item['variation_id']) ? (int)$item['variation_id'] : 0;

  if ( $is_variation ) {
    if ( $vid === (int)$upsell_variation_id ) { $upsell_in_cart = true; $upsell_cart_key = $k; break; }
  } elseif ( $is_variable_parent ) {
    if ( $pid === (int)$upsell_parent_id ) { $upsell_in_cart = true; $upsell_cart_key = $k; break; }
  } else {
    if ( $pid === (int)$upsell_parent_id ) { $upsell_in_cart = true; $upsell_cart_key = $k; break; }
  }
}

$remove_url = $upsell_in_cart ? wc_get_cart_remove_url( $upsell_cart_key ) : '';

// Display fields
$display_obj  = $upsell_obj;
$upsell_title = $display_obj->get_name();

$img_id     = $display_obj->get_image_id();
$upsell_img = $img_id ? wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' ) : wc_placeholder_img_src('woocommerce_thumbnail');

$desc = wp_strip_all_tags( $display_obj->get_short_description() );
if ( ! $desc ) $desc = 'Odličen dodatek k tvojemu naročilu.';

$price_pill = wp_strip_all_tags( wc_price( $display_obj->get_price() ) );

// AJAX add url
$ajax_add_url = add_query_arg( 'wc-ajax', 'add_to_cart', home_url( '/' ) );
?>

<style>
/* =========================
   CART UPSELL — FINAL CLEAN CSS
   ========================= */

#cart-upsell.upsell-wrap{ margin:16px 0 0; }

#cart-upsell .upsell-card{
  width:100%;
  max-width:40% !important;
  background:white;
  border:2px solid #f39c12;
  border-radius:6px;
  padding: 20px 10px 10px 10px;
  box-shadow:0 10px 24px rgba(0,0,0,.06);
  position:relative;


  display:grid;
  grid-template-columns:22px 1fr auto;
  grid-template-rows:auto auto auto;
  column-gap:12px;
  row-gap:12px;
  align-items:start;
}

#cart-upsell.is-added .upsell-card{
  background:#FFEFE3;
  border-color:#FF7A00;
}

/* Header */
#cart-upsell .upsell-head{
  grid-column:1 / 4 !important;
  display:flex;
  align-items:center;
  gap:10px;
  min-height:18px;
}

/* Checkbox */
#cart-upsell .upsell-check{
  -webkit-appearance:none;
  appearance:none;
  width:18px;
  height:18px;
  margin:0 !important;
  border-radius:999px;
  border:2px solid #FF7A00;
  background:#FFF6EF;
  cursor:pointer;
  flex:0 0 auto;
}
#cart-upsell .upsell-check:checked{
  background:#FF7A00;
  box-shadow:inset 0 0 0 4px #FFF6EF;
}

/* Title */
#cart-upsell .upsell-title{
        font-family: 'Barlow', sans-serif;
  margin:0 !important;
  font-weight:900;
  color:#111;
  line-height:1.25;
  font-size:16px;
}

/* Price */
#cart-upsell .upsell-price-pill{
     margin-left: auto;
    white-space: nowrap;
    border-radius: 4px;
    color: white;
    background: #971b1b;
    color: white;
    padding: 2px 10px 1px 10px !important;
    font-size: 14px;px !important;
    font-size: 14px;
}

/* Media */
#cart-upsell .upsell-media{
  grid-column:1 / 4 !important;
  display:grid;
  grid-template-columns:130px 1fr;
  gap:12px;
  align-items:start;
  padding-top:0px;
  margin-top:0px;
}
#cart-upsell .upsell-img{
  width:133px;
  height:133px;
  border-radius:0px;
  border:1px solid rgba(0,0,0,.08);
  object-fit:cover;
  background:#fff;
}
#cart-upsell .upsell-desc{
  color:#222;
  font-size:14px;
  line-height:1.35;
}

/* ✅ NEW: right column wrapper so opts+actions sit under desc */
#cart-upsell .upsell-body{
  display:flex;
  flex-direction:column;
  gap:10px;
}

/* Options */
#cart-upsell .upsell-opts{
  display:flex;
  flex-direction:column;
  gap:10px;
  border-radius:0px;
  margin-top: 8px;
  padding:0; /* inside right column, so no extra left padding */
}
#cart-upsell .upsell-opt-row{
  display:flex;
  flex-wrap:wrap;
  align-items:flex-start;
  gap:6px;
}
#cart-upsell .upsell-opt-label{
  flex:0 0 100%;
  display:block;
  margin:0;
  font-weight:900;
  color:#111;
  margin-bottom: -5px;
}
#cart-upsell .upsell-opt-btn{
 min-width: 44px;
    height: 32px;
    padding: 0 14px;
    border: 2px solid #111 !important;
    background: #fff !important;
    color: #111 !important;
    border-radius: 6px;
    font-size: 16px;
    line-height: 28px;
    text-align: center;
    cursor: pointer;
    box-shadow: none !important;
    outline: none !important;
    transition: background .12s ease, color .12s ease, transform .06s ease;
}
#cart-upsell .upsell-opt-btn:hover{ background:#f7f7f7 !important; }
#cart-upsell .upsell-opt-btn.is-active{
  border-color:#f39c12 !important;
  background:#f39c12 !important;
  color:#fff !important;
}
#cart-upsell .upsell-opt-btn:active{ transform:translateY(1px); }

/* when added -> disable option buttons */
#cart-upsell.is-added .upsell-opt-btn{
  pointer-events:none !important;
  opacity:.65;
}

/* Actions (now inside right column) */
#cart-upsell .upsell-actions{
  display:flex;
  gap:14px;
  align-items:center;
  justify-content:flex-start;
  margin-top:2px;
}

/* Add button */
#cart-upsell .upsell-add-btn{
  -webkit-appearance:none;
  appearance:none;
  display:inline-flex !important;
  align-items:center;
  gap:8px;

  background:#f39c12 !important;
  color:#fff !important;
  border:0 !important;
  cursor:pointer !important;

  border-radius:4px !important;
  padding:10px 14px !important;

  line-height:1 !important;
  text-decoration:none !important;

  text-transform:uppercase;
  letter-spacing:.2px;
  font-family: "Source Sans Pro", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  
    border-radius: 4px;
  
  
}
#cart-upsell .upsell-add-btn:hover{ filter:brightness(.98); }
#cart-upsell .upsell-add-btn:active{ transform:translateY(1px); }

/* Remove button */
#cart-upsell .upsell-remove-btn{
    
 -webkit-appearance:none;
  appearance:none;
  display:none;                 /* stays hidden until is-added */
  align-items:center;
  gap:8px;

  background:#eeeeee !important; /* ✅ gray */
  color:#fff !important;
  border:0 !important;
  cursor:pointer !important;
  color: #333333!important;
  border-radius:4px !important;
  padding:10px 14px !important;

  line-height:1 !important;
  text-decoration:none !important;

  text-transform:uppercase;
  letter-spacing:.2px;
  font-family:"Source Sans Pro","HelveticaNeue-Light","Helvetica Neue Light","Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;
  
  
}
#cart-upsell .upsell-remove-btn:hover{ text-decoration:underline; }
#cart-upsell.is-added .upsell-remove-btn{ display:inline-flex; }

/* when added -> hide add button */
#cart-upsell.is-added .upsell-add-btn{ display:none !important; }

/* Loader overlay */
#cart-upsell.is-loading .upsell-card::after{
  content:"";
  position:absolute;
  inset:0;
  background:rgba(255,255,255,.72);
  backdrop-filter:blur(2px);
  z-index:4;
}
#cart-upsell .upsell-loader{
  position:absolute;
  inset:0;
  display:none;
  align-items:center;
  justify-content:center;
  flex-direction:column;
  gap:10px;
  z-index:5;
  pointer-events:none;
}
#cart-upsell.is-loading .upsell-loader{ display:flex; }
#cart-upsell .upsell-loader__dots{ display:flex; gap:8px; }
#cart-upsell .upsell-loader__dots span{
  width:10px; height:10px; border-radius:50%;
  background:#ff5a1f;
  animation: upsellDot .9s infinite ease-in-out;
}
#cart-upsell .upsell-loader__dots span:nth-child(2){ animation-delay:.12s; }
#cart-upsell .upsell-loader__dots span:nth-child(3){ animation-delay:.24s; }
@keyframes upsellDot{
  0%,100%{ transform:translateY(0); opacity:.55; }
  50%{ transform:translateY(-6px); opacity:1; }
}
#cart-upsell .upsell-loader__text{
  font-weight:900;
  color:#111;
  letter-spacing:.2px;
  font-size:14px;
}
.gck-popular-badge {
    /* transform: rotate(3deg); */
    position: absolute;
    top: -18px;
    left: 10px;
    background: #000;
    color: #fff;
    font-size: 15px;
    padding: 3px 17px;
    border-radius: 5px;
    font-weight: 600;
    z-index: 10;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    white-space: nowrap;
}


img.emoji {
    display: inline !important;
    border: none !important;
    box-shadow: none !important;
    height: 1em !important;
    width: 1em !important;
    margin: 0 0.07em !important;
    vertical-align: -0.1em !important;
    background: none !important;
    padding: 0 !important;
    font-size: 16px;
}

/* Responsive */
@media (max-width:769px){
 
 .upsell-wrap { 
  padding-left: 10px; 
      padding-right: 10px;
      margin-bottom: 30px !important;
      
  }
    

  #cart-upsell .upsell-card { max-width: 100% !important; 
 
      
  }
    
    
  #cart-upsell .upsell-media{ grid-template-columns:72px 1fr; }
  #cart-upsell .upsell-img{ width:72px; height:72px; }
}
</style>

<div class="upsell-wrap <?php echo $upsell_in_cart ? 'is-added' : ''; ?>"
     id="cart-upsell"
     data-add-url="<?php echo esc_attr( $ajax_add_url ); ?>"
     data-remove-url="<?php echo esc_attr( $remove_url ); ?>"
     data-upsell-cart-key="<?php echo esc_attr( $upsell_cart_key ); ?>"
     
     
     
     data-upsell-type="<?php echo esc_attr( $is_simple ? 'simple' : ($is_variable_parent ? 'variable' : 'variation') ); ?>"
     data-upsell-parent-id="<?php echo esc_attr( $upsell_parent_id ); ?>"
     data-upsell-variation-id="<?php echo esc_attr( $upsell_variation_id ); ?>"
     data-variations="<?php echo esc_attr( wp_json_encode( $variation_data ) ); ?>"
     data-forced-attrs="<?php echo esc_attr( wp_json_encode( $forced_variation_attrs ) ); ?>"
     data-required-attrs="<?php echo esc_attr( wp_json_encode( $required_attrs ) ); ?>">

  <div class="upsell-card">
      
      
      <div class="gck-popular-badge">Posebna ponuda <img draggable="false" role="img" class="emoji" alt="🔥" src="https://s.w.org/images/core/emoji/17.0.2/svg/1f525.svg"></div>

    <div class="upsell-head">
      <input class="upsell-check" id="upsell-check" type="checkbox" <?php checked( $upsell_in_cart ); ?> />
      <div class="upsell-title"><?php echo esc_html( $upsell_title ); ?></div>
      <div class="upsell-price-pill" id="upsell-price-pill"><?php echo esc_html( $price_pill ); ?></div>
    </div>

    <div class="upsell-media">
      <img class="upsell-img" src="<?php echo esc_url( $upsell_img ); ?>" alt="<?php echo esc_attr( $upsell_title ); ?>">

      <div class="upsell-body">
        <!--<div class="upsell-desc"><?php echo esc_html( $desc ); ?></div>-->

        <?php if ( $is_variable_parent && ! empty( $attr_options ) ) : ?>
          <div class="upsell-opts" id="upsell-opts">
            <?php foreach ( $attr_options as $field => $values ) : ?>
              <div class="upsell-opt-row" data-attr="<?php echo esc_attr($field); ?>">
                <span class="upsell-opt-label"><?php echo esc_html( $attr_labels[$field] ?? $field ); ?>:</span>
                <?php foreach ( $values as $val ) :
                  $label = $val;
                  if ( strpos($field, 'attribute_pa_') === 0 ) {
                    $tax = substr($field, strlen('attribute_')); // pa_size
                    if ( taxonomy_exists( $tax ) ) {
                      $term = get_term_by( 'slug', $val, $tax );
                      if ( $term && ! is_wp_error($term) ) $label = $term->name;
                    }
                  }
                ?>
                  <button type="button"
                          class="upsell-opt-btn"
                          data-attr="<?php echo esc_attr($field); ?>"
                          data-value="<?php echo esc_attr($val); ?>">
                    <?php echo esc_html($label); ?>
                  </button>
                <?php endforeach; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="upsell-actions">
          <button type="button" class="upsell-add-btn" id="upsell-add-btn">
            <span id="upsell-btn-text"><?php echo $upsell_in_cart ? 'DODANO' : 'Dodaj u košaricu'; ?></span>
          </button>

          <button type="button" class="upsell-remove-btn" id="upsell-remove-btn" <?php echo $upsell_in_cart ? '' : 'style="display:none"'; ?>>
        ️ <span>Odstrani</span>
          </button>
        </div>

      </div>
    </div>

    <div class="upsell-loader" aria-hidden="true">
      <div class="upsell-loader__dots"><span></span><span></span><span></span></div>
      <div class="upsell-loader__text">Obrađujem…</div>
    </div>
  </div>

  <form id="upsell-add-form" style="display:none;">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="product_id" value="<?php echo esc_attr($upsell_parent_id); ?>">
    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($upsell_parent_id); ?>">
    <input type="hidden" name="variation_id" value="" id="upsell-variation-id-hidden">
  </form>
</div>


<script>
(function(){
  function initUpsellAjax(){
    const root = document.getElementById('cart-upsell');
    if(!root) return;

    if (root.dataset.bound === '1') return;
    root.dataset.bound = '1';

    const checkbox  = document.getElementById('upsell-check');
    const addBtn    = document.getElementById('upsell-add-btn');
    const btnText   = document.getElementById('upsell-btn-text');
    const removeBtn = document.getElementById('upsell-remove-btn');

    const form        = document.getElementById('upsell-add-form');
    const varIdHidden = document.getElementById('upsell-variation-id-hidden');

    if (!checkbox || !form) return;

    const addUrl   = root.getAttribute('data-add-url'); // ?wc-ajax=add_to_cart
    const type     = root.getAttribute('data-upsell-type');
    const parentId = String(root.getAttribute('data-upsell-parent-id') || '');
    const fixedVarId = String(root.getAttribute('data-upsell-variation-id') || '');

    const variations = (() => { try { return JSON.parse(root.getAttribute('data-variations') || '[]'); } catch(e){ return []; } })();
    const forcedAttrs = (() => { try { return JSON.parse(root.getAttribute('data-forced-attrs') || '{}'); } catch(e){ return {}; } })();
    const requiredAttrs = (() => { try { return JSON.parse(root.getAttribute('data-required-attrs') || '[]'); } catch(e){ return []; } })();

    const selected = {};
    let refreshTimer = null;

    function setBusy(b){
      root.classList.toggle('is-loading', b);
      checkbox.disabled = b;
      if (addBtn) addBtn.disabled = b;
      if (removeBtn) removeBtn.disabled = b;

      if (addBtn) addBtn.style.opacity = b ? '0.6' : '1';
      checkbox.style.opacity = b ? '0.6' : '1';
      if (removeBtn) removeBtn.style.opacity = b ? '0.6' : '1';
    }

    function setOptionsDisabled(disabled){
      root.querySelectorAll('.upsell-opt-btn').forEach(b => {
        b.style.pointerEvents = disabled ? 'none' : '';
        b.style.opacity = disabled ? '.65' : '';
      });
    }

    function syncAddedUI(force){
      const isAdded = (typeof force === 'boolean') ? force : checkbox.checked;

      root.classList.toggle('is-added', isAdded);
      if (addBtn) addBtn.style.display = isAdded ? 'none' : 'inline-flex';
      if (removeBtn) removeBtn.style.display = isAdded ? 'inline-flex' : 'none';

      setOptionsDisabled(isAdded);
      if (btnText) btnText.textContent = isAdded ? 'DODANO' : 'Dodaj u košaricu';
    }

    function clearAttrHiddenInputs(){
      [...form.querySelectorAll('input[name^="attribute_"]')].forEach(el => el.remove());
    }
    function injectAttrHiddenInputs(attrs){
      clearAttrHiddenInputs();
      Object.entries(attrs).forEach(([k,v]) => {
        const inp = document.createElement('input');
        inp.type = 'hidden';
        inp.name = k;
        inp.value = v;
        form.appendChild(inp);
      });
    }

    function hasAllRequiredSelections(){
      if (!requiredAttrs || !requiredAttrs.length) return true;
      return requiredAttrs.every(k => typeof selected[k] !== 'undefined' && selected[k] !== '');
    }

    function findMatchingVariation(){
      return variations.find(v => {
        if (!v) return false;
        if (v.is_in_stock === false) return false;
        if (typeof v.is_purchasable !== 'undefined' && !v.is_purchasable) return false;

        const attrs = v.attributes || {};
        for (const req of (requiredAttrs || [])) {
          const vVal = (typeof attrs[req] !== 'undefined') ? String(attrs[req] || '') : '';
          const sVal = (typeof selected[req] !== 'undefined') ? String(selected[req] || '') : '';
          if (vVal !== '' && sVal === '') return false;
        }

        return Object.entries(selected).every(([k,val]) => {
          const vVal = (typeof attrs[k] !== 'undefined') ? String(attrs[k] || '') : '';
          if (vVal === '') return true;
          return vVal === String(val);
        });
      });
    }

    function syncSelectedFromUI(){
      Object.keys(selected).forEach(k => delete selected[k]);

      root.querySelectorAll('.upsell-opt-row[data-attr]').forEach(row => {
        const attr = row.getAttribute('data-attr') || row.dataset.attr;
        const active = row.querySelector('.upsell-opt-btn.is-active');
        if (attr && active) selected[attr] = active.getAttribute('data-value') || '';
      });

      if (type === 'variable') {
        const match = findMatchingVariation();
        varIdHidden.value = (match && match.variation_id) ? String(match.variation_id) : '';
      }

      injectAttrHiddenInputs(selected);
    }

    function findUpsellRemoveUrlInDom(){
      const cartForm = document.querySelector('form.woocommerce-cart-form');
      if (!cartForm) return '';

      const link = cartForm.querySelector(`a.remove[data-product_id="${CSS.escape(parentId)}"]`);
      if (link && link.getAttribute('href')) return link.getAttribute('href');

      const any = cartForm.querySelector('a.remove[href*="remove_item="]');
      return any ? (any.getAttribute('href') || '') : '';
    }

    // ✅ FAST: apply fragments without reloading whole cart HTML
    function applyFragments(data){
      if (!data || !data.fragments || typeof data.fragments !== 'object') return;

      Object.entries(data.fragments).forEach(([selector, html]) => {
        const el = document.querySelector(selector);
        if (el) el.outerHTML = html;
      });

      if (window.jQuery) {
        window.jQuery(document.body).trigger('wc_fragments_refreshed');
        window.jQuery(document.body).trigger('updated_wc_div');
        window.jQuery(document.body).trigger('updated_cart_totals');
      } else {
        document.body.dispatchEvent(new Event('updated_wc_div'));
      }
    }

    // ✅ SLOW (full cart refresh) — do it only after a short delay
    async function refreshCartSections(){
      const url = window.location.href + (window.location.href.includes('?') ? '&' : '?') + 't=' + Date.now();
      const res = await fetch(url, { credentials:'same-origin', cache:'no-store' });
      const html = await res.text();

      const doc = new DOMParser().parseFromString(html, 'text/html');

      const newForm = doc.querySelector('form.woocommerce-cart-form');
      const curForm = document.querySelector('form.woocommerce-cart-form');
      if (newForm && curForm) curForm.replaceWith(newForm);

      const newCols = doc.querySelector('.cart-collaterals');
      const curCols = document.querySelector('.cart-collaterals');
      if (newCols && curCols) curCols.replaceWith(newCols);

      if (window.jQuery) {
        window.jQuery(document.body).trigger('updated_wc_div');
        window.jQuery(document.body).trigger('updated_cart_totals');
      } else {
        document.body.dispatchEvent(new Event('updated_wc_div'));
      }

      setTimeout(() => {
        const r = document.getElementById('cart-upsell');
        if (r) r.dataset.bound = '0';
        initUpsellAjax();
      }, 0);
    }

    function scheduleCartRefresh(){
      clearTimeout(refreshTimer);
      refreshTimer = setTimeout(() => {
        refreshCartSections().catch(()=>{});
      }, 250); // ✅ tune: 200–400ms
    }

    // Prefill (variation type)
    if (type === 'variation') {
      if (fixedVarId) varIdHidden.value = String(fixedVarId);
      if (forcedAttrs && typeof forcedAttrs === 'object') {
        Object.assign(selected, forcedAttrs);
        injectAttrHiddenInputs(selected);
      }
    }

    // Default select first option
    (function defaultSelectFirstOption(){
      if (root.classList.contains('is-added')) return;

      const firstBtn = root.querySelector('.upsell-opt-btn');
      if (!firstBtn) return;

      if (root.querySelector('.upsell-opt-btn.is-active')) {
        syncSelectedFromUI();
        return;
      }

      const attr = firstBtn.getAttribute('data-attr');
      root.querySelectorAll(`.upsell-opt-btn[data-attr="${CSS.escape(attr)}"]`)
        .forEach(b => b.classList.remove('is-active'));
      firstBtn.classList.add('is-active');

      syncSelectedFromUI();
    })();

    // Option buttons
    root.querySelectorAll('.upsell-opt-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        if (root.classList.contains('is-added')) return;

        const attr = btn.getAttribute('data-attr');
        root.querySelectorAll(`.upsell-opt-btn[data-attr="${CSS.escape(attr)}"]`)
          .forEach(b => b.classList.remove('is-active'));
        btn.classList.add('is-active');

        syncSelectedFromUI();
      });
    });

    if (addBtn) {
      addBtn.addEventListener('click', () => {
        if (!checkbox.checked) {
          checkbox.checked = true;
          checkbox.dispatchEvent(new Event('change'));
        }
      });
    }

    if (removeBtn) {
      removeBtn.addEventListener('click', () => {
        if (checkbox.checked) {
          checkbox.checked = false;
          checkbox.dispatchEvent(new Event('change'));
        }
      });
    }

    checkbox.addEventListener('change', async () => {
      setBusy(true);

      try{
        // ADD
        if (checkbox.checked) {
          syncSelectedFromUI();

          if (type === 'variable') {
            if (!hasAllRequiredSelections()) {
              alert('Odaberi sve opcije (npr. veličinu) prije dodavanja.');
              checkbox.checked = false;
              syncAddedUI(false);
              setBusy(false);
              return;
            }
            if (!varIdHidden.value) {
              alert('Odabrana kombinacija nije dostupna. Probaj drugu opciju.');
              checkbox.checked = false;
              syncAddedUI(false);
              setBusy(false);
              return;
            }
          }

          // ✅ instant UI
          syncAddedUI(true);

          const pidInput = form.querySelector('input[name="product_id"]');
          const atcInput = form.querySelector('input[name="add-to-cart"]');
          if (pidInput) pidInput.value = parentId;
          if (atcInput) atcInput.value = parentId;

          const fd = new FormData(form);

          const res = await fetch(addUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: fd
          });

          const data = await res.json().catch(() => ({}));

          if (!res.ok || data?.error) {
            checkbox.checked = false;
            syncAddedUI(false);
            alert('Ne mogu dodati proizvod. Provjeri odabrane opcije (varijacije) i dostupnost.');
            setBusy(false);
            return;
          }

          // ✅ fast DOM updates (no full HTML fetch yet)
          applyFragments(data);

          // ✅ do heavy refresh shortly after (keeps totals/table correct)
          scheduleCartRefresh();

          checkbox.checked = true;
          syncAddedUI(true);

          setBusy(false);
          return;
        }

        // REMOVE
        let removeUrl = findUpsellRemoveUrlInDom();

        if (!removeUrl) {
          // fallback heavy refresh to locate remove link
          await refreshCartSections();
          removeUrl = findUpsellRemoveUrlInDom();
        }

        if (!removeUrl) {
          alert('Ne mogu ukloniti proizvod (ne mogu pronaći remove link u košarici).');
          checkbox.checked = true;
          syncAddedUI(true);
          setBusy(false);
          return;
        }

        syncAddedUI(false);

        const remRes  = await fetch(removeUrl, {
          credentials:'same-origin',
          headers:{'X-Requested-With':'XMLHttpRequest'},
          cache:'no-store'
        });

        // Some setups return HTML; still schedule refresh either way
        const remText = await remRes.text().catch(()=>'');

        // ✅ update quickly if any fragments were returned (rare on GET)
        try {
          const maybeJson = JSON.parse(remText);
          applyFragments(maybeJson);
        } catch(e) {}

        scheduleCartRefresh();

        const freshCheckbox = document.getElementById('upsell-check');
        if (freshCheckbox) freshCheckbox.checked = false;

        syncSelectedFromUI();
        syncAddedUI(false);

        setBusy(false);

      } catch(e){
        console.error(e);
        alert('Nešto je pošlo po zlu. Pogledaj DevTools → Network.');
        checkbox.checked = !checkbox.checked;
        syncAddedUI();
        setBusy(false);
      }
    });

    syncSelectedFromUI();
    syncAddedUI();
  }

  document.addEventListener('DOMContentLoaded', initUpsellAjax);
})();
</script>




<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>



<style>


</style>




</div>
</section>


<?php do_action( 'woocommerce_after_cart' ); ?>

