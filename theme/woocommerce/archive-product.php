<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

do_action( 'woocommerce_before_main_content' );











?>

<?php
function is_active_menu_item( $path ) {
    $current_url = home_url( add_query_arg( [], $GLOBALS['wp']->request ) );

    return strpos( trailingslashit( $current_url ), trailingslashit( home_url( $path ) ) ) !== false;
}
?>

<!-- SECOND LEVEL MENU -->
<section>
<nav class="category-menu">
  <ul>
    <li class="<?php echo is_shop() ? 'active' : ''; ?>">
      <a href="/si/shop">Vsi izdelki</a>
    </li>

    <li class="<?php echo is_active_menu_item('/product-category/majice') ? 'active' : ''; ?>">
      <a href="/si/product-category/majice/">Majice</a>
    </li>

    <li class="<?php echo is_active_menu_item('/product-category/boksarice') ? 'active' : ''; ?>">
      <a href="/si/product-category/boksarice/">Bokserice</a>
    </li>

    <li class="<?php echo is_active_menu_item('/product-category/kompleti') ? 'active' : ''; ?>">
      <a href="/si/product-category/kompleti/">Kompleti</a>
    </li>

    <li class="<?php echo is_active_menu_item('/product-category/nogavice') ? 'active' : ''; ?>">
      <a href="/si/product-category/nogavice/">Nogavice</a>
    </li>
  </ul>
</nav>
</section>

<style>

/* make sure nothing clips it */


.category-menu {
  overflow-x: auto;
  z-index: 9999;
}

/* the fixed state */
.category-menu.is-fixed{
  display: block;

  position: fixed;
  top: 0;          /* change if you have a fixed header */
  left: 0;
  right: 0;
  width: 100%;
  z-index: 99999;
}

/* spacer prevents layout jump */
.category-menu-spacer{
  height: 0;
}


    .category-menu {
  background-color: #f3f3f3;
  overflow-x: auto;
}

.category-menu ul {
  display: flex;
  gap: 18px;
  padding: 8px 16px 5px 16px;
  margin: 0;
  list-style: none;
  white-space: nowrap;
}

.category-menu li {
  position: relative;
}

.category-menu a {
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
  letter-spacing: 0.01em;
  color: #333;
  text-transform: uppercase;
  padding-bottom: 8px;
  display: inline-block;
}

.category-menu li.active a {
  color: #000;
}

.category-menu li.active::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 8px;
  width: 100%;
  height: 2px;
  background-color: #000;
}


/* DESKTOP ONLY */

@media (min-width: 1024px) {


 }


@media (min-width: 1024px) {
    
    
    
  .category-menu {
    overflow-x: hidden; /* no scroll */
     display: none;

  }

  .category-menu ul {
    justify-content: center; /* center items */
  }
}

</style>

<script>
(function () {
  function setupCategoryMenu() {
    const menu = document.querySelector(".category-menu");
    if (!menu) return;

    // avoid re-binding listeners repeatedly
    if (menu.__catMenuBound) {
      // if already bound, just recompute the trigger point
      if (typeof menu.__catMenuRecalc === "function") menu.__catMenuRecalc();
      return;
    }

    let spacer = document.querySelector(".category-menu-spacer");
    if (!spacer) {
      spacer = document.createElement("div");
      spacer.className = "category-menu-spacer";
      menu.parentNode.insertBefore(spacer, menu);
    }

    const getMenuHeight = () => menu.offsetHeight;
    let startTop = 0;

    function recalc() {
      // temporarily show for correct measurement
      const prevDisplay = menu.style.display;
      menu.style.display = "block";

      menu.classList.remove("is-fixed");
      spacer.style.height = "0px";

      startTop = menu.getBoundingClientRect().top + window.scrollY;

      // restore
      menu.style.display = prevDisplay || "";
      onScroll();
    }

    function onScroll() {
      if (window.scrollY >= startTop) {
        menu.classList.add("is-fixed");
        spacer.style.height = getMenuHeight() + "px";
      } else {
        menu.classList.remove("is-fixed");
        spacer.style.height = "0px";
      }
    }

    // bind once
    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", recalc, { passive: true });

    // mark + expose recalc for ajax refresh
    menu.__catMenuBound = true;
    menu.__catMenuRecalc = recalc;

    recalc();
  }

  // initial
  window.addEventListener("load", setupCategoryMenu);

  // re-run after ANY jQuery ajax (most Woo filters use this)
  if (window.jQuery) {
    jQuery(document).ajaxComplete(function () {
      setupCategoryMenu();
    });
  }

  // optional: support FacetWP (harmless if not installed)
  document.addEventListener("facetwp-loaded", setupCategoryMenu);

})();
</script>

<!-- SECOND LEVEL MENU -->

<!-- BANNER DESKTOP + MOBILE -->
<section class="one-banner-shop" style="position: relative; margin: 0 auto; padding: 0;">

  <img
    src="<?php echo get_template_directory_uri(); ?>/img/noriks-shop.png"
    style="display:block; width:100%; min-height:105px; border-radius:0;"
    alt=""
  >

  <?php
  // Default title for shop
  $banner_title = 'NORIKS';

  // Product category archive
  if ( is_product_category() ) {
      $term = get_queried_object();

      if ( $term && ! is_wp_error( $term ) ) {

          // Walk up to the top parent
          while ( $term->parent !== 0 ) {
              $term = get_term( $term->parent, 'product_cat' );
          }

          $banner_title = $term->name;
      }
  }
  ?>

  <h1
    class="h1"
    style="
      position:absolute;
      top:50%;
      left:50%;
      transform:translate(-50%, -50%);
      font-size:2.5rem;
      font-weight:800;
      width:100%;
      font-family:'Barlow', sans-serif;
      letter-spacing:0.5px;
      color:white;
      text-align:center;
      text-transform: uppercase;
    "
  >
    <?php echo esc_html( $banner_title ); ?>
  </h1>

</section>





   <style>
@media (max-width: 991px) {
.h1   {
    font-size: 1.5rem !important;
    
}
}

</style>
    
    
    

<!-- BANER DESKTOP + MOBILE -->

<?php
function is_product_category_or_child( $parent_slug ) {
    if ( ! is_product_category() ) {
        return false;
    }

    $current_term = get_queried_object();

    if ( ! $current_term || empty( $current_term->term_id ) ) {
        return false;
    }

    // If it's the parent itself
    if ( $current_term->slug === $parent_slug ) {
        return true;
    }

    // Get parent term by slug
    $parent_term = get_term_by( 'slug', $parent_slug, 'product_cat' );

    if ( ! $parent_term ) {
        return false;
    }

    // Get all ancestors of current category
    $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );

    return in_array( $parent_term->term_id, $ancestors );
}
?>


<!-- FILTRI --><?php
$shop_filter_fields = get_field("shop_filter_fields", "option");
?>

<section class="shop-filter-buttons">
    <div>
        <div>

          <?php
// SHOP PAGE (/shop)
if ( is_shop() ) {

    echo do_shortcode('[yith_wcan_filters slug="default-preset-2-2"]');

// CATEGORY: /bokserice + ALL CHILD CATEGORIES
} elseif ( is_product_category_or_child('boksarice') ) {

    echo do_shortcode('[yith_wcan_filters slug="default-preset-2-2-2-2"]');

// CATEGORY GROUP
} elseif (
    is_product_category_or_child('bestsellers') ||
    is_product_category_or_child('veliki-paketi') ||
    is_product_category_or_child('zacetni-paketi')
) {

    echo do_shortcode('[yith_wcan_filters slug="default-preset-2-2"]');

// CATEGORY: /majice + children
} elseif ( is_product_category_or_child('majice') ) {

    echo do_shortcode('[yith_wcan_filters slug="default-preset-2-2-2"]');

// CATEGORY: /kompleti + children
} elseif ( is_product_category_or_child('kompleti') ) {

    echo do_shortcode('[yith_wcan_filters slug="default-preset"]');

// CATEGORY: /carape + children
} elseif ( is_product_category_or_child('nogavice') ) {

    echo do_shortcode('[yith_wcan_filters slug="default-preset-2"]');

// FALLBACK for any other product category
} elseif ( is_product_category() ) {

    echo do_shortcode('[yith_wcan_filters slug="default-preset-2-2"]');
}
?>
        </div>
    </div>
</section>



<!-- yith filter styling --> 
<style>


.storefront-sorting  {
    display: none !important;
}

    /* 991 */



.filter-title {
    display: none;
    
}

    
    .yith-wcan-reset-filters  {
 background: #971c1a;
        border: 1px solid #971c1a;
        padding: 3px 10px 3px 10px;
        margin-left: 5px;
        color: white;
        text-transform: uppercase;
        font-size: 14px;
    }
    
    
    
.yith-wcan-filters .yith-wcan-filter .yith-wcan-dropdown {
    border: 1px solid #D7D7D7;
    border-radius: 0px;
    padding: 3px 10px 3px 10px;
    cursor: pointer;
    position: relative;
    font-size: 14px;
}


    .filter-item  {
        
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
         border-radius: 0px !important;
         padding: 2px 12px 2px 11px !important;
         border-color: black;
        
    }
    
    .yith-wcan-filters  {
        
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
        
    }

    .shop-filter-buttons {
                position: relative;
                margin: 0 auto;
                padding: 32px 15px 30px 15px !important;
                max-width: 1800px;
              
     
    }
    
       .yith-wcan-filter   {
        margin-bottom: 0 !important;
        
    }
    
    .yith-wcan-filters {
        margin-bottom: 0 !important;
        
    }
    
    .filters-container form {
        margin-bottom: 0 !important;
        
    }
    
  
    
    .filters-container .filter-tax {
            width: auto%;
            display: inline-block;
    
    }
    .filters-container .filter-orderby {
            width: 240px;
            display: inline-block;
            float: right;
    
    }





@media (max-width: 992px) {
    
    .shop-filter-buttons {
         padding: 15px 15px 43px 15px !important;
    }
    
    .filters-container .filter-tax {
            width: 100% !important;
            display: block !important;
    
    }
    .filters-container .filter-orderby {
            width: 49% !important;
            display: block !important;
            float: right;
    
    }
    
    .filter-item  {
        
   
         padding: 2px 2px 2px 2px !important;
 
    }
    
    .yith-wcan-filters .yith-wcan-filter .filter-items .filter-item.label {
    
        margin-bottom: 8px !important;
        margin-top:3px !important;
        
    }
    

 .filter-tax   .filter-items {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0px;
}


.term-kompleti  .filter-tax .filter-items {
   display: grid;
  grid-template-columns: repeat(3, 1fr);
 gap: 0px;
}

.post-type-archive  .filter-tax .filter-items {
   display: grid;
  grid-template-columns: repeat(3, 1fr);
 gap: 0px;
}

.yith-wcan-reset-filters  {
        margin-left: -1px !important;
}

.filters-container .filter-tax {
        margin-bottom: 5px !important;
}


}



@media (max-width: 410px) {
 .filters-container .filter-orderby {
            width: 60% !important;
            display: block !important;
            float: right;
    
    }
    
}


.dropdown-wrapper {
    padding: 5px !important;
}


.dropdown-wrapper  ul {
    padding-left: 0;
    margin-left: 0;
}

.shop-filter-buttons .filter-orderby  .active {
        background: transparent !important;
        font-weight: bold !important;
        color: black !important;

}

.shop-filter-buttons .active  a {
   
   
        color: black !important;

}


.yith-wcan-filters .yith-wcan-filter .filter-items .filter-item > a:hover, .yith-wcan-filters .yith-wcan-filter .filter-items .filter-item > label > a:hover{
   
   
        color: black !important;

}

</style>
<!-- yith filter styling --> 


<!-- FILTRI -->










<style>
@media (min-width: 992px) {
.filter-title   {
    display:none;
    
}
}


@media (max-width: 991px) {
.yith-wcan-filters-opener  {
        
        margin: 12px auto;
    display: block;
        border-radius: 0 !important;
  width: calc(100% - 30px);
        margin-left: 15px;
        margin-right: 15px;
}





}

.shop-filter-buttons {
   
}



/* DESKTOP ONLY */
@media (min-width: 1024px) {

.shop-filter-buttons .shop-filter-container  {
   margin-top: 20px  !important;
   margin-bottom: 20px !important;
}
}
    
</style>


<style>




.product_type_simple {
   display:none;
    }


.woocommerce-ordering {
   display:none;
    }


 .shop-filter-container {
      max-width: 60%;
    margin: 0 auto;
    padding: 7px 5px 8px 5px;
    float: left;
   
    }

     .button-link {
     display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    text-decoration: none;
    border: 1px solid black;
    border-radius: 0px;
    padding: 4px 9px;
    color: black;
    background: white;
    margin: 0.25em;
    transition: background 0.3s, color 0.3s;   
    font-family: 'Inter', sans-serif;
    }

    .button-link:hover {
      background-color: #f5a623;
    }


    .post-type-archive-product .woocommerce-products-header {
        display: none;
    }
    
    .storefront-sorting  .woocommerce-ordering select{
        
        padding: 20px;
        font-size: 1rem;
        color: black;
        font-family: 'Inter', sans-serif;
        
    }
    
    
    .woocommerce-ordering {
        margin-right: 0;
      
    }
    
    .woocommerce-result-count  {
        display: none;
    }
    
    .post-type-archive-product .storefront-sorting {
          max-width: 50%;
      margin: 0 auto;
      float: right;
      padding: 20px 20px 10px 20px;
    }
    
    .post-type-archive-product  .products {
      max-width: 1800px;
      margin: 0 auto;
      padding: 0px 20px;
    }
    
    .post-type-archive-product .product_type_variable {
        display: none;
    }
    
    ul.products li.product, ul.products .wc-block-grid__product, .wc-block-grid__products li.product, .wc-block-grid__products .wc-block-grid__product{
       margin-bottom: 0 !important;
    }
    
    
    ul.products li.product img, ul.products .wc-block-grid__product img, .wc-block-grid__products li.product img, .wc-block-grid__products .wc-block-grid__product img {
    display: block;
    margin: 0 auto 10px;
    }
    
    .woocommerce-loop-product__title {
        font-family: 'Roboto', sans-serif;
        text-align: left;

        font-weight: normal !important;
    margin-bottom: 0px !important;
    margin-top: 0px !important;
    
    text-align: center;
    }
    .onsale  {
        display: none;
    }
    .price {
      
        text-align: center;
         margin-bottom: 22px !important;
    }


    
    
    .woocommerce ul.products li.product {
  position: relative;
  overflow: hidden;
}

.woocommerce ul.products li.product img {
  display: block;
  width: 100%;
  transition: opacity 0.3s ease;
  backface-visibility: hidden; /* avoid blur on transition */
}

.secondary-image {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  width: 100%;
  transition: opacity 0.3s ease;
  z-index: 1;
}

.woocommerce ul.products li.product:hover .secondary-image {
  opacity: 1;
}

.woocommerce ul.products li.product:hover .woocommerce-loop-product__link img:first-child {
  opacity: 0;
}

.top-liked, .badge   {
   z-index: 999;
   opacity: 1;
   font-size: 10px;
}


.shop-filter-buttons .active {
        background:  #f5a623;
        color: black;

      }
      

.filter-tax .active    a  {
        
        color: black !important;
        font-weight: bold !important;

      }
      


@media (min-width: 767px) {
    
    .one-banner-shop {
      
      
    }
   
   
}


@media (max-width: 768px) {
    
    .reviews  {
        text-align: left;
        font-size: 12px !important;
        line-height: 1!important;
    }
    
    .one-banner-shop {
       
    }

    .storefront-sorting {
       
    }

    .shop-filter-container {
        max-width: 100%;
    }
    
    
    .button-link {
      padding: 6px 1.3em;
    }
    
    
    .top-liked, .badge {
        font-size: 8px !important;
    }
    
    
}
    
</style>




<!-- Slick carousel init removed -->




<?php




/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action( 'woocommerce_shop_loop_header' );




if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );
	
	
	?>



<?php


	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
