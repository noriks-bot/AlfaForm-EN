<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" style="padding-top: 0 !important;" class="site-main" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked storefront_homepage_content      - 10
			 * @hooked storefront_product_categories    - 20
			 * @hooked storefront_recent_products       - 30
			 * @hooked storefront_featured_products     - 40
			 * @hooked storefront_popular_products      - 50
			 * @hooked storefront_on_sale_products      - 60
			 * @hooked storefront_best_selling_products - 70
			 */
			//do_action( 'homepage' );
			?>
			
			
			
			<section class="hero">
  <div class="hero__media" aria-hidden="true">
    <!-- Replace with your image -->
    <img
      src="<?php echo get_template_directory_uri(); ?>/img/noriks-hero.jpeg"
      alt=""
    />
  </div>

  <div class="hero__overlay" aria-hidden="true"></div>

  <div class="hero__content">
    <!--<p class="hero__eyebrow">NOVO: NORIKS </p>-->
    <h1 class="hero__title">Majica, ki reši vse težave.</h1>

    <a class="hero__btn" href="/si/shop">KUPITE ZDAJ</a>
  </div>
</section>


<style>
    .hero {
  position: relative;
  width: 100%;
  min-height: clamp(360px, 42vw, 560px);
  overflow: hidden;
  background: #111;
    display: flex;
  align-items: center; /* vertical centering */
}

/* Background image */
.hero__media {
  position: absolute;
  inset: 0;
}

.hero__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transform: scale(1.02);
}

/* Subtle dark overlay for readability (stronger on left) */
.hero__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    90deg,
    rgba(0, 0, 0, 0.38) 0%,
    rgba(0, 0, 0, 0.20) 38%,
    rgba(0, 0, 0, 0.06) 70%,
    rgba(0, 0, 0, 0.00) 100%
  );
}

/* Content */
.hero__content {
  position: relative;
  z-index: 1;

  padding: clamp(24px, 4vw, 70px);
  display: flex;
  flex-direction: column;
  justify-content: center;
  max-width: 40%; /* keeps text block like screenshot */
}

.hero__eyebrow {
  margin: 0 0 10px;
  color: rgba(255, 255, 255, 0.9);
  font-size: 14px;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  font-weight: 700;
}

.hero__title {
  margin: 0 0 18px;
  color: #fff;
  font-weight: 900;
  letter-spacing: -0.02em;
  line-height: 1.05;
  font-size: clamp(34px, 4.2vw, 52px);
}

.hero__btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: fit-content;
  padding: 12px 18px;
  border: 2px solid rgba(255, 255, 255, 0.85);
  color: #fff;
  text-decoration: none;
  font-weight: 800;
  letter-spacing: 0.08em;
  font-size: 12px;
  text-transform: uppercase;
  background: transparent;
}

.hero__btn:hover {
  background: rgba(255, 255, 255, 0.12);
}

/* Optional: make it truly edge-to-edge */
.hero--fullbleed {
  border-radius: 0;
}

/* Mobile tweaks */
@media (max-width: 640px) {
  .hero__overlay {
    background: linear-gradient(
      180deg,
      rgba(0, 0, 0, 0.35) 0%,
      rgba(0, 0, 0, 0.15) 55%,
      rgba(0, 0, 0, 0.05) 100%
    );
  }

  .hero__content {
    max-width: 100%;
  }
}

</style>
			
  
  
  
  
  <section class="collections">
  <div class="collections__header">
    <h2 class="collections__title">Nakupuj po kolekciji</h2>

    <a class="collections__cta" href="/si/shop">
      Vsi izdelki <span aria-hidden="true">›</span>
    </a>
  </div>

  <div class="collections__grid">
    <!-- Card 1 -->
    <a class="collection-card" href="/si/product-category/majice/">
      <div class="collection-card__media">
        <img
          src="<?php echo get_template_directory_uri(); ?>/img/noriks-majice.jpeg"
          alt="Crew neck t-shirt"
        />
      </div>

      <div class="collection-card__body">
        <div class="collection-card__text">
          <div class="collection-card__topline">
            <h3 class="collection-card__name">Majice</h3>
          </div>
          <p class="collection-card__desc">
           Udobje ves dan. Brez zategovanja.
          </p>
        </div>

        <span class="collection-card__arrow" aria-hidden="true">›</span>
      </div>
    </a>

    <!-- Card 2 -->
    <a class="collection-card" href="/si/product-category/boksarice/">
      <div class="collection-card__media">
        <img
          src="<?php echo get_template_directory_uri(); ?>/img/noriks-boksarice.jpeg"
          alt="V-neck t-shirt"
        />
      </div>

      <div class="collection-card__body">
        <div class="collection-card__text">
          <div class="collection-card__topline">
            <h3 class="collection-card__name">Boksarice</h3>
          </div>
          <p class="collection-card__desc">
          Mehke. Zračne. Zanesljive.

          </p>
        </div>

        <span class="collection-card__arrow" aria-hidden="true">›</span>
      </div>
    </a>

    <!-- Card 3 -->
    <a class="collection-card" href="/si/product-category/kompleti/">
      <div class="collection-card__media">
        <img
          src="<?php echo get_template_directory_uri(); ?>/img/noriks-kompleti.jpeg"
          alt="Long sleeve shirt"
        />
      </div>

      <div class="collection-card__body">
        <div class="collection-card__text">
          <div class="collection-card__topline">
            <h3 class="collection-card__name">Kompleti</h3>
       
          </div>
          <p class="collection-card__desc">
Najboljša vrednost v paketu.
          </p>
        </div>

        <span class="collection-card__arrow" aria-hidden="true">›</span>
      </div>
    </a>
    
    <!-- Card 3 -->
    <a class="collection-card" href="/si/product-category/zacetni-paketi/">
      <div class="collection-card__media">
        <img
          src="<?php echo get_template_directory_uri(); ?>/img/starter-paket_.jpeg"
          alt="Long sleeve shirt"
        />
      </div>

      <div class="collection-card__body">
        <div class="collection-card__text">
          <div class="collection-card__topline">
            <h3 class="collection-card__name">Starter paket</h3>
           
           
          </div>
          <p class="collection-card__desc">
Preizkusi NORIKS po boljši vstopni ceni.

          </p>
        </div>

        <span class="collection-card__arrow" aria-hidden="true">›</span>
      </div>
    </a>

   
  </div>
</section>


<style>/* ---- Section ---- */
.collections {
  background: #fff;
  padding: 20px 15px 0 15px;
  max-width: 1800px;
  display: block;
  margin: 0 auto;
}

.collections__header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 13px;
}

.collections__title {
  margin: 0;
  font-size: clamp(28px, 2.5vw, 40px);
  line-height: 1.1;
  font-weight: 800;
  letter-spacing: -0.02em;
}

.collections__cta {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  border: 1px solid #111;
  border-radius: 0px;
  color: #111;
  text-decoration: none;
  font-weight: 700;
  font-size: 14px;
  white-space: nowrap;
}

.collections__cta:hover {
  background: #111;
  color: #fff;
}

/* ---- Grid ---- */
.collections__grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 10px;
}

/* ---- Card ---- */
.collection-card {
  display: grid;
  grid-template-rows: 1fr auto;
  background: #fff;
  border-radius: 5px;
  text-decoration: none;
  color: inherit;
  overflow: hidden;
  box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
  
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    will-change: transform;
}

.collection-card__media {
  background: #f2f2f2;
  aspect-ratio: 4 / 5;
  overflow: hidden;
}

.collection-card__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.collection-card__body {
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 14px;
  align-items: center;
  padding: 14px 14px 16px;
  background: #fff;
}

.collection-card__topline {
  display: inline-flex;
  align-items: center;
  gap: 10px;
}

.collection-card__name {
  margin: 0;
  font-size: 18px;
  line-height: 1.15;
  font-weight: 800;
  color: black; /* deep navy-ish like screenshot */
}

.collection-card__desc {
  margin: 6px 0 0;
  font-size: 14px;
  line-height: 1.35;
  color: #2b2b2b;
  max-width: 38ch;
}

.badge {


}

.collection-card__arrow {
  width: 34px;
  height: 34px;
  display: grid;
  place-items: center;
  border-radius: 3px;
  background: #f3f5f7;
  border: 1px solid #e6e9ee;
  font-size: 22px;
  line-height: 1;
  color: #111;
}

/* Hover/focus */
.collection-card:hover {
 transform: scale(1.02);
   box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08) !important;

}

.collection-card:focus-visible {
  outline: 3px solid rgba(17, 17, 17, 0.35);
  outline-offset: 4px;
}

/* ---- Responsive ---- */
@media (max-width: 1100px) {
  .collections__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 640px) {
  .collections {
    padding: 22px 16px;
  }

  .collections__grid {
    grid-template-columns: 1fr;
  }

  .collections__cta {
    padding: 9px 12px;
  }
}


@media (max-width: 991px) {


.collections__grid {
  grid-template-columns: repeat(2, minmax(0, 1fr));
}
.collection-card__arrow {
    display:none;

}

.products-grid {
  grid-template-columns: repeat(2, minmax(0, 1fr));
}
.product-name  {
        LINE-HEIGHT: 1.1;
        font-size: 0.9rem;
}

.product-info {
    padding: 15px 15px 5px 15px;
}



}







</style>
  		







<?php
/************ get products by category homepage  ************/
$products = array();

// Check if the repeater field has rows
if ( have_rows('homepage_section_2_product_list') ) {
  while ( have_rows('homepage_section_2_product_list') ) {
    the_row();

    // Get the product field (post object)
    $product_post = get_sub_field('product');

    if ( $product_post && $product_post instanceof WP_Post ) {
      $product = wc_get_product( $product_post->ID );
      if ( $product instanceof WC_Product ) {
        $products[] = $product;
      }
    }
  }
}
/************ get products by category homepage  ************/
?>

<!-- Slick carousel init and styles removed -->

<style>
/* Ensure each grid item (product card) behaves correctly */
.product-card {
  display: flex;
  flex-direction: column;
  height: 100%;
  background: #fff;
}

.image-wrapper {
  width: 100%;
  overflow: hidden;
  position: relative;
}

/* Primary + hover swap */
.product-image-swap {
  position: relative;
}

.product-image-swap .product-img {
  display: block;
  width: 100%;
  height: auto;
}

/* second image on top, hidden */
.product-image-swap .hover-img {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  transition: opacity 0.25s ease;
}

/* swap on hover (desktop) */
.product-card:hover .product-image-swap .hover-img {
  opacity: 1;
}

.product-card:hover .product-image-swap .primary-img {
  opacity: 0;
  transition: opacity 0.25s ease;
}

/* Keep your existing link-to-pp and focus styles */
.link-to-pp {
  position: absolute;
  right: 10px;
  bottom: 41px;
  z-index: 99;
  background: #f5a622;
  width: 40px;
  height: 40px;
  z-index: 999999999;
}

a:focus,
a:hover {
  outline: none !important;
  box-shadow: none !important;
  color: inherit !important;
}
</style>

<section class="most-popular">
  <div style="max-width: 1800px;" class="container">

 
    
    
      <div class="collections__header">
   
    <h2 style="text-align: left; margin-bottom:0px;" class="collections__title">
      <?php echo get_field("homepage_section_2_t1"); ?>
    </h2>

    <a class="collections__cta" href="/si/shop">
      Vsi izdelki  <span aria-hidden="true">›</span>
    </a>
  </div>

    <div class="products-grid slider-mobile2">
      <?php foreach ( $products as $index => $product ): ?>

        <?php
          $product_id   = $product->get_id();
          $product_link = get_permalink($product_id);
          $product_name = $product->get_name();

          // Prices
          if ( $product->is_type('variable') ) {
            $regular_price = $product->get_variation_regular_price('min', true);
            $sale_price    = $product->get_variation_sale_price('min', true);
          } else {
            $regular_price = $product->get_regular_price();
            $sale_price    = $product->get_sale_price();
          }

          $is_on_sale = $product->is_on_sale();

          // Images: primary + first gallery for hover
          $primary_url = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' );

          $hover_url = '';
          $gallery_image_ids = $product->get_gallery_image_ids();
          if ( !empty($gallery_image_ids) ) {
            $hover_url = wp_get_attachment_image_url( $gallery_image_ids[0], 'woocommerce_thumbnail' );
          }
          if ( !$hover_url ) {
            $hover_url = $primary_url;
          }
        ?>

        <div class="product-card" style="position: relative;">
          <a href="<?php echo esc_url($product_link); ?>"
             style="position: absolute; top:0; left:0; width:100%; height:100%; z-index:99;">

            <div class="image-wrapper product-image-swap">

              <?php
                $shirt_count     = get_field('number_of_shirts_in_this_product', $product->get_id());
                $alt_output      = false;
                $alt_output_text = get_field("singlepp_priceper_alternative_1piece","options");

                if ( empty($shirt_count) || $shirt_count == 0 ) {
                  $shirt_count = 1;
                }

                $tmp_price = 0;
                if ( $product->is_type('variable') ) {
                  $tmp_price = $product->get_variation_sale_price('min', true);
                } else {
                  $tmp_price = $product->get_sale_price();
                }

                if ( $tmp_price ) {
                  $tmp_price = $tmp_price / $shirt_count;
                  $tmp_price = ceil($tmp_price * 100) / 100;
                }

                if ( $shirt_count == 1 ) {
                  $alt_output = true;
                  $alt_output_text = get_field("singlepp_priceper_alternative_1piece","options");
                }

                // extra check if is multipack
                // NOTE: your original code used get_the_ID() (page id). Keeping it as-is.
                if ( get_field('multipack_option_1', get_the_ID()) == true ) {
                  $alt_output = true;
                  $alt_output_text = get_field("singlepp_priceper_alternative_multipack","options");
                }

                $topseler_text = get_field("singlepp_bestseller_text", "options");

                if ( $shirt_count != 1 ):
                  if ( $alt_output == false ):

                    $current_product_id = $product->get_id();
                    $is_boxers = has_term( array('bokserice','bokserice-sastavi-paket'), 'product_cat', $current_product_id );

                    if ( $is_boxers ):
                      if ( has_term('black-friday', 'product_cat', $current_product_id ) ):
                        $topseler_text = "Black Friday ";
                      else:
                        $topseler_text = get_field("singlepp_priceper_before","options") . " " . $tmp_price . " " . "€ na boksarico";
                      endif;
                    else:
                      $topseler_text = get_field("singlepp_priceper_before","options") . " " . $tmp_price . " " . get_field("singlepp_priceper_after","options");
                    endif;

                  endif;
                endif;
              ?>

              <?php if ( $shirt_count != 1 ): ?>
                <!--<div class="top-liked"><?php echo $topseler_text; ?></div>-->
              <?php endif; ?>

              <?php
                // Badge discount
                $discount = 0;

                if ( $product->is_type('variable') ) {
                  $regular_price_badge = (float) $product->get_variation_regular_price('min', true);
                  $sale_price_badge    = (float) $product->get_variation_sale_price('min', true);
                } else {
                  $regular_price_badge = (float) $product->get_regular_price();
                  $sale_price_badge    = (float) $product->get_sale_price();
                }

                if ( $sale_price_badge && $regular_price_badge && $regular_price_badge > $sale_price_badge ) {
                  $discount = round( ( ( $regular_price_badge - $sale_price_badge ) / $regular_price_badge ) * 100 );
                  echo '<span class="badge">-' . esc_html($discount) . '' . get_field("singlepp_discount_text","options") . ' </span>';
                }
              ?>

              <a style="display:none;" href="<?php echo esc_url($product_link); ?>" class="link-to-pp">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="40" height="40" rx="2" fill="#F5A623"></rect>
                  <g clip-path="url(#clip0_24310_7887)">
                    <path d="M24 16C24 14.9391 23.5786 13.9217 22.8284 13.1716C22.0783 12.4214 21.0609 12 20 12C18.9391 12 17.9217 12.4214 17.1716 13.1716C16.4214 13.9217 16 14.9391 16 16H12V26C12 26.5304 12.2107 27.0391 12.5858 27.4142C12.9609 27.7893 13.4696 28 14 28H26C26.5304 28 27.0391 27.7893 27.4142 27.4142C27.7893 27.0391 28 26.5304 28 26V16H24ZM20 13.3333C20.7072 13.3333 21.3855 13.6143 21.8856 14.1144C22.3857 14.6145 22.6667 15.2928 22.6667 16H17.3333C17.3333 15.2928 17.6143 14.6145 18.1144 14.1144C18.6145 13.6143 19.2928 13.3333 20 13.3333Z" fill="white"></path>
                  </g>
                  <defs>
                    <clipPath id="clip0_24310_7887">
                      <rect width="16" height="16" fill="white" transform="translate(12 12)"></rect>
                    </clipPath>
                  </defs>
                </svg>
              </a>

              <?php if ( $primary_url ): ?>
                <img class="product-img primary-img"
                     src="<?php echo esc_url($primary_url); ?>"
                     alt="<?php echo esc_attr($product_name); ?>">
              <?php endif; ?>

              <?php if ( $hover_url ): ?>
                <img class="product-img hover-img"
                     src="<?php echo esc_url($hover_url); ?>"
                     alt="<?php echo esc_attr($product_name); ?>">
              <?php endif; ?>

            </div><!-- /.image-wrapper -->

            <div class="product-info">
            <!--  <h3 style="font-size: 15px; margin-bottom: 0px; font-weight: 500;">NORIKS</h3>-->
              <h3 class="product-name"><?php echo esc_html($product_name); ?></h3>

              <div class="price">
                <?php if ( $is_on_sale ): ?>
                  <span class="old-price"><?php echo wc_price($regular_price); ?></span>
                  <span class="current-price"><?php echo wc_price($sale_price); ?></span>
                <?php else: ?>
                  <span class="current-price"><?php echo wc_price($regular_price); ?></span>
                <?php endif; ?>
              </div>
            </div>

          </a>
        </div>

      <?php endforeach; ?>
    </div>

<!--
    <div class="container container--my-button">
      <div style="background: transparent; padding: 0; justify-content: left;" class="cta-button">
        <a class="cta-button2 button button--xl"
           style="margin: 0 auto; text-align: left; background: black; font-family: 'Roboto', sans-serif; color: white; text-transform: none; font-size: 15px; padding: 10px 25px 10px 25px;"
           href="<?php echo esc_url( get_field("homepage_section_2_b1_link") ); ?>">
          <?php echo esc_html( get_field("homepage_section_2_b1_text") ); ?>
        </a>
      </div>
    </div>
    -->

  </div>
</section>






	
  <section class="reviews-section">
      
      
      
    
     <div class="container" style="width: 100%;
    max-width: 1800px;
    margin: 0 auto;">
         
         <!--
    <div class="reviews-rating">

      <span style="color: #333;"><?php echo get_field("homepage_section_3_t1"); ?></span>
    </div>
-->

    <h2 class="collections__title" style="text-align: left;font-size: clamp(28px, 2.5vw, 40px);
    margin-bottom: 13px;"><?php echo get_field("homepage_section_3_t2"); ?></h2>

    <div class="reviews-grid">

    <?php 
    $bigreviews_reviews_fields = get_field("bigreviews_reviews_fields", "option");
      $bigreviews_reviews_fields2 = get_field("bigreviews_reviews_fields_2", "option");
    

    //var_dump($header_nav);
    ?>
    

      <?php if ($bigreviews_reviews_fields): ?>
    <?php foreach ($bigreviews_reviews_fields as $item): ?>
      <!-- Review 1 -->
      <div class="review-card">
        <img src="<?php echo $item['img']; ?>" alt="" class="review-image">
        <div class="review-content">
          <div class="review-meta">
            <div class="review-name"><?php echo $item['name']; ?></div>
            <div class="verified"><?php echo $item['t1']; ?></div>
          </div>
          <div class="review-text"><?php echo $item['t2']; ?></div>
          <div class="review-product">
            <img src="<?php echo $item['img2']; ?>" alt="Shirt Pack">
            <a href="<?php echo $item['link']; ?>"><?php echo $item['t3']; ?></a>
          </div>
        </div>
      </div>
     <?php endforeach; ?>
  <?php endif; ?>
          <?php if ($bigreviews_reviews_fields2): ?>
    <?php foreach ($bigreviews_reviews_fields2 as $item): ?>
      <!-- Review 1 -->
      <div class="review-card">
        <img src="<?php echo $item['img']; ?>" alt="" class="review-image">
        <div class="review-content">
          <div class="review-meta">
            <div class="review-name"><?php echo $item['name']; ?></div>
            <div class="verified"><?php echo $item['t1']; ?></div>
          </div>
          <div class="review-text"><?php echo $item['t2']; ?></div>
          <div class="review-product">
            <img src="<?php echo $item['img2']; ?>" alt="Shirt Pack">
            <a href="<?php echo $item['link']; ?>"><?php echo $item['t3']; ?></a>
          </div>
        </div>
      </div>
     <?php endforeach; ?>
  <?php endif; ?>
    
    

    </div>

 </div>
  </section>
  
  <style>
  .review-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    will-change: transform;
  }

  .review-card:hover {
    transform: scale(1.1);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    z-index: 2;
  }
</style>





		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();



