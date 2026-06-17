<?php
/**
 * Custom review order — styled identically to our noriks-order-summary
 * WC manages this template via AJAX update_checkout
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="noriks-order-summary woocommerce-checkout-review-order-table">
  <div class="review-all-products-container">
    <div class="vigo-checkout-total__content">
      <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
        $_product = $cart_item['data'];
        $qty = $cart_item['quantity'];

        // Orto bundle products are added to cart with quantity = 1 but the
        // selected offer (e.g. "3 paira") stores the real item count in
        // _orto_bundle_pairs (see orto-product plugin gck_add_cart_item_data).
        // Show the real number of pieces in the "Nx" prefix.
        $display_qty = $qty;
        if ( ! empty( $cart_item['_orto_bundle_pairs'] ) ) {
          $display_qty = $qty * (int) $cart_item['_orto_bundle_pairs'];
        }

        $attrs = '';
        if ( !empty($cart_item['variation']) ) {
          $parts = array();
          foreach ($cart_item['variation'] as $k=>$v) $parts[] = wc_attribute_label(str_replace('attribute_','',$k)).': '.$v;
          $attrs = implode(', ',$parts);
        }
      ?>
      <div class="c--darkgray review-section-container">
        <div class="review-product-info">
          <div><?php echo esc_html($display_qty.'x '.$_product->get_name()); ?></div>
          <?php if ($attrs): ?><div class="review-product-info__attributes"><?php echo esc_html($attrs); ?></div><?php endif; ?>
        </div>
        <div class="info-price">
          <span class="review-sale-price"><?php echo WC()->cart->get_product_subtotal($_product,$qty); ?></span>
        </div>
      </div>
      <?php endforeach; ?>

      <!-- Shipping -->
      <div class="c--darkgray review-section-container review-addons shipping_order_review">
        <div class="review-addons-title"><div>Dostava</div></div>
        <div class="review-addons-price review-sale-price" id="noriks-shipping-price">
          <?php
            $ship = (float) WC()->cart->get_shipping_total();
            if ( $ship > 0 ) {
              echo wc_price( $ship );
            } else {
              echo '<span class="shipping-free-badge">Brezplačno</span>';
            }
          ?>
        </div>
      </div>

      <!-- Coupon discounts -->
      <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : 
        $discount_amount = WC()->cart->get_coupon_discount_amount( $code, WC()->cart->display_cart_ex_tax );
        $currency = get_woocommerce_currency_symbol();
      ?>
      <div class="c--darkgray review-section-container review-addons">
        <div class="review-addons-title"><div>Kupon: <?php echo esc_html( strtoupper($code) ); ?></div></div>
        <div class="review-addons-price review-sale-price" style="display:flex;align-items:center;gap:6px;">
          <span>-<?php echo esc_html( number_format($discount_amount, 2, ',', '.') . ' ' . $currency ); ?></span>
          <a href="#" class="woocommerce-remove-coupon" data-coupon="<?php echo esc_attr( $code ); ?>" style="color:#999;text-decoration:none;font-size:13px;padding-left:4px;" onclick="event.preventDefault();jQuery.post('<?php echo esc_url(wc_get_checkout_url()); ?>?wc-ajax=remove_coupon',{coupon:this.dataset.coupon,security:'<?php echo wp_create_nonce("remove-coupon"); ?>'},function(){jQuery('body').trigger('update_checkout');});">✕</a>
        </div>
      </div>
      <?php endforeach; ?>

      <!-- COD fee — WC renders this automatically via get_fees() -->
      <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
      <div class="c--darkgray review-section-container review-addons">
        <div class="review-addons-title"><div><?php echo esc_html($fee->name); ?></div></div>
        <div class="review-addons-price review-sale-price"><?php wc_cart_totals_fee_html($fee); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="vigo-checkout-total__sum flex flex--middle border_price">
    <div class="flex__item f--l">
      Skupni znesek: <span class="f--bold price_total_wrapper"><?php wc_cart_totals_order_total_html(); ?></span>
    </div>
  </div>
</div>
