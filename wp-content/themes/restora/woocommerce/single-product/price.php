<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>


<style>
    .price {
      display: inline-block;
    }

    .price-badge {
      margin-left: 15px;
      display: inline-flex;
      align-items: center;
      background-color: #e9f7f0;
      color: #34a56f;
      font-family: 'Roboto', sans-serif;
      font-weight: 700;
      font-size: 13px;
      padding: 4px 8px;
      border-radius: 4px;
          vertical-align: middle;
    }

    .price-badge .icon {
    background-color: #34a56f;
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 2px 6px 2px 6px;
    border-radius: 4px;
    margin-right: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
        margin-left: 0;
    }
    
    .tile.active {
        box-shadow: none !important;
        border-color: black  !important;
        border: 1px solid black !important;
    
    }
  </style>



<div class="whole-price-block" style="display:block; margin-bottom: -10px;">
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?>


<?php

$current_product_id = get_the_id();

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





//$tmp_price = floor($tmp_price) - 0.01;
//$tmp_price = round($tmp_price, 2); // ensure 2 decimals


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


<?php if(  get_field("single_pp_offer_name" ) != "" && get_field("single_pp_offer_name" ) != null  ): ?>
 <div class="price-badge">
   
   
       <?php  echo get_field("single_pp_offer_name" ); ?> 
     
  </div>
<?php endif; ?>
 
 

  
</p>
</div>


<!--druge barve -->



<?php if ($shirt_count == 1 && mb_stripos($product->get_name(), 'Čarape') === false): ?>

        
    <section class="color-selections">
        
        
        <section class="option-group">
 <!-- <h2 class="option-title">Barva</h2>-->

  <?php
  
// Check if current product is in category "singles-boxers"
$is_singles_boxers = has_term( '1-kos-boksarice', 'product_cat', $current_product_id );

$is_singles_majice = has_term( '1-kos-majice', 'product_cat', $current_product_id );



if ( $is_singles_boxers ) {
    
    
?>

<h2 class="option-title">Barva</h2>


<?php
    // Query products from category "singles-boxers"
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => '1-kos-boksarice',
            ),
        ),
        'orderby' => 'date',
        'order'   => 'ASC',
    );

} elseif ( $is_singles_majice ) {
    
    
    ?>

<h2 class="option-title">Barva</h2>


<?php

    // Default → Query products from category "singles"
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => '1-kos-majice',
            ),
        ),
        'orderby' => 'date',
        'order'   => 'ASC',
    );
}

$loop = new WP_Query( $args );



if ($loop->have_posts()) : ?>
  <div class="swatch-grid">
    <?php while ($loop->have_posts()) : $loop->the_post(); ?>
      <?php 
        $classes = 'tile';
        if (get_the_ID() == $current_product_id) {
            $classes .= ' active'; // add active class
        }
      ?>
      <a href="<?php the_permalink(); ?>" class="<?php echo esc_attr($classes); ?>">
        <?php
          if (has_post_thumbnail(get_the_ID())) {
            echo get_the_post_thumbnail(
              get_the_ID(),
              'woocommerce_thumbnail',
              array('alt' => esc_attr(get_the_title()))
            );
          } else {
            echo '<img src="' . esc_url(wc_placeholder_img_src()) . '" alt="' . esc_attr(get_the_title()) . '">';
          }
        ?>
      </a>
    <?php endwhile; ?>
  </div>
<?php endif;

wp_reset_postdata();
?>
  
  
</section>

<style>
  
  .option-group { 
  max-width: 980px; 
  margin: 0 auto;  
  margin-top: 10px;
}

.option-title {
  font-family: 'Roboto', sans-serif;
  font-size: 16.5px !important;
  font-weight: 700 !important;
  line-height: 1.4 !important;
  color: #222 !important;
}

.swatch-grid {
  --gap: 4px; /* reduced gap for smaller tiles */
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(65px, 1fr));
  gap: var(--gap);
}

.tile {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 65px;
  height: 65px;
  border-radius: 0px;
  background: #fff;
  border: 2px solid rgba(0,0,0,0.08);
  box-shadow: 0 4px 14px rgba(0,0,0,0.08);
  overflow: hidden;
  transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  text-decoration: none;
}

.tile img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  border-radius: 0;
}

/* Hover effect */
.tile:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.12);
  border-color: black;
}

.tile.active {


  pointer-events: none; /* optional: prevent clicking current item */
}

/* Responsive (keep small size on mobile too) */
@media (max-width: 480px){
  .tile { width: 65px; height: 65px; }
}

</style>
        
        
    </section>
        


 <?php endif; ?>  
 
<!--druge barve -->






<!-- inline builder -->



 
 
 <?php 
 
 $prod_id = get_the_ID();
 $inline_pack = false;
 
 
 //
 
 // 2 = 1841
 // 3 = 1852
 // 6 = 1659
 // 9 = 1866
 
 
 // PRODUCTION
 
  // 2 = 2230
 // 3 = 2238
 // 6 = 2239
 // 9 = 2240
 
 
 
 if($prod_id == 2230)  {   // 2
    echo do_shortcode('[inline_bundle_builder products="250,471,483,504,497,1395, 490" slots="2"]');
     $inline_pack = true;
  }
  if($prod_id == 2238)  {   // 3
    echo do_shortcode('[inline_bundle_builder products="250,471,483,504,497,1395, 490" slots="3"]');
    $inline_pack = true;
  }
  if($prod_id == 2239)  {   // 6
    echo do_shortcode('[inline_bundle_builder products="250,471,483,504,497,1395, 490" slots="6"]');
    $inline_pack = true;
  }
  if($prod_id == 2240)  {   // 9
    echo do_shortcode('[inline_bundle_builder products="250,471,483,504,497,1395, 490" slots="9"]');
    $inline_pack = true;
  }
  
  
  if($prod_id == 2440)  {   // 2+1 ( 3 slots )
    echo do_shortcode('[inline_bundle_builder products="250,471,483,504,497,1395, 490" slots="3" gratis_slots="3"]');
    $inline_pack = true;
  }
  
  if($prod_id == 2456)  {   // 2+2 ( 3 slots )
    echo do_shortcode('[inline_bundle_builder products="250,471,483,504,497,1395, 490" slots="4" gratis_slots="3,4"]');
    $inline_pack = true;
  }
  
   if($prod_id == 2466)  {   // 1+1 ( 2 slots )
    echo do_shortcode('[inline_bundle_builder products="250,471,483,504,497,1395, 490" slots="2" gratis_slots="2"]');
    $inline_pack = true;
  }
  
  // bokserice
  
  
  
   if($prod_id == 2921)  {   // 3 +1
    echo do_shortcode('[inline_bundle_builder products="2781,2793,2801,2809,2829" slots="4"]');
    $inline_pack = true;
  }
  
   if($prod_id == 2929)  {   // 5+3
    echo do_shortcode('[inline_bundle_builder products="2781,2793,2801,2809,2829" slots="8"]');
    $inline_pack = true;
  }
  
   if($prod_id == 2937)  {   // 7+5 
    echo do_shortcode('[inline_bundle_builder products="2781,2793,2801,2809,2829" slots="12"]');
    $inline_pack = true;
  }
  
   if($prod_id == 2944)  {   // 8+7
    echo do_shortcode('[inline_bundle_builder products="2781,2793,2801,2809,2829" slots="15"]');
    $inline_pack = true;
  }
  
  

 ?>
 
 
 <?php if($inline_pack == true): ?>
 
 
 
 
  
 <?php
 
				 get_template_part( 'template_parts/size-chart-modal' );	
				//	var_dump($attribute_name);
						
						
						    
						    
						    
                            echo ' <a href="#" id="open-size-chart" style="margin-left: 10px;
    color: black;
    float: right;
    text-decoration: underline;
    font-size: 16.5px !important;
    font-weight: 700 !important;
    line-height: 1.4 !important;
    color: #222 !important;"><svg style="    margin-right: 10px;
    width: 23px;
    height: 23px;
    display: inline-block;
        margin-top: 10px;
    margin-bottom: 10px;
    vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
        <path d="M11.4124 2.58464L2.08525 11.9118C1.86558 12.1315 1.86558 12.4876 2.08525 12.7073L5.78977 16.4118C6.00944 16.6315 6.3656 16.6315 6.58527 16.4118L15.9124 7.08466C16.1321 6.86499 16.1321 6.50883 15.9124 6.28916L12.2079 2.58464C11.9883 2.36497 11.6321 2.36497 11.4124 2.58464Z" stroke="#111213" stroke-width="0.84375"></path>
        <path d="M9.28125 4.71875L11.5312 6.96875M6.75 7.25L9 9.5M4.21875 9.78125L6.46875 12.0312" stroke="#111213" stroke-width="0.84375"></path>
      </svg>Tablica veličina</a>';
                    
	
						
 
 
 ?>
 
 
 
 
 <style>
     .variations {   
       display: none;
  }
     
 </style>
 
 <?php endif; ?>
 
 
 
 
 
 
 
 
 <!-- inline builder -->
 
 
 
 
 
 
 
 
