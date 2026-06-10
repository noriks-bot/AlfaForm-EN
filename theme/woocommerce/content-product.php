<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
    
    
    
<?php

$shirt_count = get_field('number_of_shirts_in_this_product', $product->get_id());
$alt_output = false;
$alt_output_text = get_field("singlepp_priceper_alternative_1piece","options");


if (empty($shirt_count) || $shirt_count == 0) {
    $shirt_count = 1;
}


$tmp_price = 0;




if ($product->is_type('variable')) {
    $tmp_price = $product->get_variation_sale_price('min', true);
} else {
    $tmp_price = $product->get_sale_price();
}

$tmp_price = $tmp_price / $shirt_count;
//$tmp_price = round($tmp_price * 100) / 100; // result: 9.99
$tmp_price = floor(($tmp_price + 0.00001) * 100) / 100;





if($shirt_count == 1 ) {
    $alt_output = true;
    $alt_output_text = get_field("singlepp_priceper_alternative_1piece","options");
}


// extra check if is multipack


if( get_field('multipack_option_1', get_the_ID())  == true  ) {
    $alt_output = true;
    $alt_output_text = get_field("singlepp_priceper_alternative_multipack","options");
}


$topseler_text =  get_field("singlepp_bestseller_text", "options");

 if( $shirt_count != 1): 

     if($alt_output == false): 
         
         
         $is_boxers = has_term( array( 'bokserice', 'bokserice-sastavi-paket' ), 'product_cat', $current_product_id );

         
         if( $is_boxers ): 
         
            
          
         
            if( has_term('black-friday', 'product_cat', $current_product_id ) ): 
             $topseler_text =  "Zimska ponuda"; 
             
            else:
                 $topseler_text =  get_field("singlepp_priceper_before","options") . " " . $tmp_price . " ".  "€ po boksericama"; 
            endif;
         
         
         else: 
             
              $topseler_text =  get_field("singlepp_priceper_before","options") . " " . $tmp_price . " ".  get_field("singlepp_priceper_after","options"); 
             
         endif;
      
      
      // here check bokserice
      
    else:
    
     endif;

 endif; 
 

 


?>
    
     <?php if( $shirt_count != 1   ):  ?>
     <!-- <div class="top-liked">  <?php echo $topseler_text; ?></div>-->
      <?php endif; ?>
      
      
               <?php
            $discount = 0;
            
            if ( $product->is_type( 'variable' ) ) {
                $regular_price = (float) $product->get_variation_regular_price( 'min', true );
                $sale_price    = (float) $product->get_variation_sale_price( 'min', true );
            } else {
                $regular_price = (float) $product->get_regular_price();
                $sale_price    = (float) $product->get_sale_price();
            }
            
            if ( $sale_price && $regular_price && $regular_price > $sale_price ) {
                $discount = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                echo '<span class="badge">-' . esc_html( $discount ) .'' . get_field("singlepp_discount_text","options") .' </span>';
            }
            ?>
    
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	 
	
	 
	 
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 * 
	 */
	 
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
    font-size: 10px;
    padding: 2px 8px 1px 8px;
    border-radius: 2px;
    text-transform: uppercase;
}

.top-liked {
  position: absolute;
  top: 10px;
  left: 10px;
 background-color: #496d8f;
    color: white;
    font-family: 'Roboto', sans-serif;
    font-weight: 700;
    font-size: 10px;
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
  
    <!--
    <h3 style="font-size: 15px;
    margin-bottom: 7px;
    font-weight: 500;">NORIKS</h3>-->

	 
	 <?php
	 
	do_action( 'woocommerce_shop_loop_item_title' );
	
		?>

	
<?php

$shirt_count = get_field('number_of_shirts_in_this_product', $product->get_id());
$alt_output = false;
$alt_output_text = get_field("singlepp_priceper_alternative_1piece","options");


if (empty($shirt_count) || $shirt_count == 0) {
    $shirt_count = 1;
}


$tmp_price = 0;




if ($product->is_type('variable')) {
    $tmp_price = $product->get_variation_sale_price('min', true);
} else {
    $tmp_price = $product->get_sale_price();
}

$tmp_price = $tmp_price / $shirt_count;
//$tmp_price = round($tmp_price * 100) / 100; // result: 9.99
$tmp_price = floor(($tmp_price + 0.00001) * 100) / 100;




if($shirt_count == 1 ) {
    $alt_output = true;
    $alt_output_text = get_field("singlepp_priceper_alternative_1piece","options");
}


// extra check if is multipack


if( get_field('multipack_option_1', get_the_ID())  == true  ) {
    $alt_output = true;
    $alt_output_text = get_field("singlepp_priceper_alternative_multipack","options");
}



?>

<!--
<?php if( $shirt_count != 1): ?>
 <div style="color: #34a56f;
    font-size: 14px;" class="price-badge">

    <?php if($alt_output == false): ?>
    
    
       <?php echo get_field("singlepp_priceper_before","options"); ?> <?php echo ($tmp_price); ?><?php echo get_field("singlepp_priceper_after","options"); ?> 
       
       
       
    <?php else: ?>
     <?php echo $alt_output_text; ?>
    <?php endif; ?>
  </div>
 <?php endif; ?>  
 --> 

	
	<?php

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );
	
	


	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
