<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li <?php wc_product_cat_class( '', $category ); ?>>
    
    
      
      <div class="top-liked"><?php echo get_field("singlepp_bestseller_text", "options"); ?></div>
           <div class="badge"><?php echo get_field("singlepp_discount_text", "options"); ?></div>
           
	<?php
	/**
	 * The woocommerce_before_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_open - 10
	 */
	do_action( 'woocommerce_before_subcategory', $category );

	/**
	 * The woocommerce_before_subcategory_title hook.
	 *
	 * @hooked woocommerce_subcategory_thumbnail - 10
	 */
	do_action( 'woocommerce_before_subcategory_title', $category );
	
	
		 
	  ?>
	 
	 <style>
    .rating {
      display: flex;
      align-items: center;
      font-family: 'Roboto', sans-serif;
          margin-bottom: 10px;
    }

    .stars {
      color: #fbbc04;
      font-size: 17px;
      margin-right: 12px;
    }

    .reviews {
     font-size: 15px;
    color: #202124;
    font-weight: 500;
    }
    
    
    
.badge {
  position: absolute;
  top: 10px;
  right: 10px;
 background-color: #971b1b;
    color: white;
    font-family: 'Roboto', sans-serif;
    font-weight: 700;
    font-size: 11px;
    padding: 2px 8px 1px 8px;
    border-radius: 2px;
    text-transform: uppercase;
}

.top-liked {
  position: absolute;
  top: 10px;
  left: 10px;
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


<!--
<div class="rating">
    <div class="stars">
      ★★★★★
    </div>
    <div class="reviews">
      <?php echo get_field("singlepp_reviews_text_1", "options"); ?>  <?php echo get_field("singlepp_reviews_text_2", "options"); ?> 
    </div>
  </div>
-->
	 
	 <?php

	/**
	 * The woocommerce_shop_loop_subcategory_title hook.
	 *
	 * @hooked woocommerce_template_loop_category_title - 10
	 */
	do_action( 'woocommerce_shop_loop_subcategory_title', $category );

	/**
	 * The woocommerce_after_subcategory_title hook.
	 */
	do_action( 'woocommerce_after_subcategory_title', $category );

	/**
	 * The woocommerce_after_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_close - 10
	 */
	do_action( 'woocommerce_after_subcategory', $category );
	?>
</li>
