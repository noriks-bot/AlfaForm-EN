<?php
/**
 * Checkout Form — Vigoshop 1:1 replica within WooCommerce
 * HTML structure matches /test-checkout/ standalone template exactly
 */
if ( ! defined( 'ABSPATH' ) ) exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

// Don't show checkout if cart is empty
if ( WC()->cart->is_empty() ) return;
?>

<div class="container container--xs bg--white wc-checkout-wrap">
<div class="before_form container container--xs">

<form name="checkout" method="post" class="checkout woocommerce-checkout"
      action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="Plačilo">

  <div class="col2-set" id="customer_details">
    <div class="col-1 clearfix">
      <div class="woocommerce-billing-fields">
        <div class="woocommerce-billing-fields__field-wrapper">
          <?php do_action( 'woocommerce_checkout_billing' ); ?>
        </div>
      </div>
    </div>

    <div class="col-2">
      <div class="woocommerce-shipping-fields"></div>
      <div class="woocommerce-additional-fields">

        <!-- SHIPPING -->
        <?php WC()->cart->calculate_totals(); ?>
        <div id="custom_shipping">
          <h3>Dostava</h3>
          <ul class="shipping_method_custom">
            <li class="standard-shipping shipping-tab">
              <input name="shipping_method[0]" data-index="0" id="shipping_method_0_standard_custom"
                     value="standard" class="shipping_method shipping_method_field" type="radio" checked>
              <label for="shipping_method_0_standard_custom" class="checkedlabel">
                <svg viewBox="0 0 19 14" fill="#3DBD00"><path fill-rule="evenodd" clip-rule="evenodd" d="M18.5725 3.40179L8.14482 13.5874C7.5815 14.1375 6.66839 14.1375 6.1056 13.5874L0.422493 8.03956C-0.140831 7.48994-0.140831 6.59748 0.422493 6.04707L1.44121 5.05126C2.00471 4.50094 2.91854 4.50094 3.48132 5.05126L7.12254 8.60835L15.5145 0.412609C16.078-0.137536 16.9909-0.137536 17.5537 0.412609L18.5733 1.40842C19.1424 1.95795 19.1424 2.8505 18.5725 3.40179Z"/></svg>
                <div class="outer-wrapper">
                  <div class="inner-wrapper-dates">
                    <strong class="hs-custom-date" id="js-delivery-dates"></strong>
                  </div>
                  <div class="inner-wrapper-img">
                    <span class="shipping_method_delivery_price tag tag--red"><?php $ship = (float) WC()->cart->get_shipping_total(); echo $ship > 0 ? wc_price($ship) : 'Brezplačno'; ?></span>
                    <span class="delivery_img"><img decoding="async" class="gls standard" src="https://images.vigo-shop.com/general/curriers/gls.png"/></span>
                  </div>
                </div>
              </label>
            </li>
          </ul>
          <div class="delivery-from-eu-warehouse">
            <img decoding="async" class="delivery-from-eu-warehouse__icon" src="https://images.vigo-shop.com/general/flags/eu-warehouse.svg">
            <span class="delivery-from-eu-warehouse__text">Skladišče v EU</span>
          </div>
        </div>

        <!-- COD prompt -->
        <div id="hs-cod-checkout-prompt" style="display:none;">
          <div class="cod-prompt-text">Zaključite naročilo zdaj, <strong>plačajte po povzetju 🙂</strong></div>
          <img decoding="async" class="cod-prompt-image" src="https://images.vigo-shop.com/general/checkout/cod/uni_cash_on_delivery.svg">
        </div>

        <!-- VAT -->
        <div id="hs-vat-tax-checkout-prompt">
          <span class="tax-and-vat-checkout-claims">Ni dodatnih stroškov za carino</span>
          <span class="tax-and-vat-checkout-claims">DDV je vključen v ceno</span>
        </div>

        <!-- PAYMENT + ORDER SUMMARY + BUTTON — via WC hooks -->
        <h3 class="payment-title">Način plačanja</h3>
        <?php woocommerce_checkout_payment(); ?>

        <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>

      </div><!-- .woocommerce-additional-fields -->
    </div><!-- .col-2 -->
  </div><!-- #customer_details -->

</form>
</div><!-- .before_form -->

<!-- WC #place_order is inside woocommerce_checkout_payment() — no extra button needed -->

<!-- Warranty -->
<div class="checkout-warranty flex flex--center flex--middle">
  <div class="flex__item--autosize checkout-warranty__icon">
    <img decoding="async" src="https://images.vigo-shop.com/general/guarantee_money_back/satisfaction_icon_hr.png">
  </div>
  <div class="flex__item--autosize f--m checkout-warranty__text">
    <strong>Nakupujte brez skrbi </strong><br>Vračilo denarja je mogoče v roku 90 dni
  </div>
</div>

<!-- Terms -->
<div class="agreed_terms_txt">
  <span class="policy-agreement-obligation">S klikom na gumb <strong>Naroči</strong> se strinjam z naročilom z obveznostjo plačila.</span><br>
  <div class="terms-checkbox-and-links">
    <label class="checkbox">
      <input type="checkbox" class="input-checkbox" name="agree_to_checkout_terms" id="agree_to_terms_checkbox" value="1">
    </label>
    Prebral sem in sprejemam <a href="#" id="terms_conditions_link">Splošne pogoje prodaje</a> i <a href="#" id="withdrawal_policy_link">pravico do odstopa od nakupa</a>.
  </div>
</div>

</div><!-- .wc-checkout-wrap -->

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script>
jQuery(function($){
  /* Delivery dates — same logic as product page (meta.php) */
  var days=['nedelja','ponedeljek','torek','sreda','četrtek','petek','sobota'];
  function addBiz(d,n){var r=new Date(d);while(n>0){r.setDate(r.getDate()+1);if(r.getDay()!==0&&r.getDay()!==6)n--;}return r;}
  var now=new Date(),from=addBiz(now,2),to=addBiz(now,3);
  $('#js-delivery-dates').text(days[from.getDay()]+', '+from.getDate()+'.'+(from.getMonth()+1)+'. - '+days[to.getDay()]+', '+to.getDate()+'.'+(to.getMonth()+1)+'.');

  /* Shipping price — read from WC after checkout update */
  /* Update order review when clicking payment method label */
  $(document).on('click', '#payment .wc_payment_method', function(){
    $('form.checkout').trigger('update');
  });

});
</script>
