<?php
defined( 'ABSPATH' ) || exit;
global $product;
if ( empty( $product ) || ! $product->is_visible() ) { return; }
$link = get_permalink( $product->get_id() );
?>
<li <?php wc_product_class( 'cal-prod-card', $product ); ?>>
  <a href="<?php echo esc_url( $link ); ?>" class="cal-prod-card-link">
    <div class="cal-prod-card-img"><?php echo $product->get_image( 'woocommerce_single' ); ?></div>
    <h3 class="cal-prod-card-title"><?php echo esc_html( $product->get_name() ); ?></h3>
    <div class="cal-prod-card-price"><?php echo $product->get_price_html(); ?></div>
  </a>
</li>
