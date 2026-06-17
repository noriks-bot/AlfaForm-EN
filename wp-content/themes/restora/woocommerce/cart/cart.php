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

