<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
 <style>
    .rating {
   
      font-family: 'Roboto', sans-serif;
          margin-bottom: 5px;
    }

    .stars {
      color: #fbbc04;
      font-size: 17px;
      margin-right: 12px;
      display:inline-block !important;
    }

    .reviews {
     font-size: 15px;
    color: #202124;
    font-weight: 500;
     display:inline;
    }
    .reviews a:hover {
        text-decoration: underline;
    }
  </style>



<div class="rating">
    <div class="stars">
      ★★★★★
    </div>
    <div class="reviews">
      <a style="color:black;" href="#reviews-section">Odlično 4.8 | <?php echo get_field('singlepp_reviews_text_1', 'option'); ?> <?php echo get_field('singlepp_reviews_text_2', 'option'); ?></a>
    </div>
  </div>
 




<?php

the_title( '<h1 id="title-buy-now" class="product_title entry-title">', '</h1>' );



global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}

?>

<div class="woocommerce-product-details__short-description">
	<?php echo $short_description; // WPCS: XSS ok. ?>
</div>

<style>
    .woocommerce-product-details__short-description p {
            margin-bottom: 0;
    }
    
</style>

<!--
<style>
    .badge {
    display: inline-block;
    background-color: #0068bb;
    color: white;
    font-family: 'Roboto', sans-serif;
    font-weight: 700;
    font-size: 11px;
    padding: 2px 8px 1px 8px;
    border-radius: 2px;
    text-transform: uppercase;
    }
  </style>

 <span class="badge"><?php echo get_field('singlepp_bestseller_text', 'option'); ?></span>
-->

<?php




