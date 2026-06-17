<?php
defined('ABSPATH') || exit;

get_header('shop');

do_action('woocommerce_before_main_content');

$term = get_queried_object();
$term_id = $term instanceof WP_Term ? (int) $term->term_id : 0;

$show_promo = $term_id ? get_term_meta($term_id, 'noriks_collection_show_promo', true) : '0';
$show_intro_text = $term_id ? get_term_meta($term_id, 'noriks_collection_show_intro_text', true) : '0';
$show_bottom_banner = $term_id ? get_term_meta($term_id, 'noriks_collection_show_bottom_banner', true) : '0';
$show_bottom_banner_button = $term_id ? get_term_meta($term_id, 'noriks_collection_show_bottom_banner_button', true) : '0';
$show_bottom_products = $term_id ? get_term_meta($term_id, 'noriks_collection_show_bottom_products', true) : '0';
$show_bottom_intro_text = $term_id ? get_term_meta($term_id, 'noriks_collection_show_bottom_intro_text', true) : '0';
$promo_title = $term_id ? get_term_meta($term_id, 'noriks_collection_promo_title', true) : '';
$promo_subtitle = $term_id ? get_term_meta($term_id, 'noriks_collection_promo_subtitle', true) : '';
$intro_text = $term_id ? get_term_meta($term_id, 'noriks_collection_intro_text', true) : '';
$bottom_intro_text = $term_id ? get_term_meta($term_id, 'noriks_collection_bottom_intro_text', true) : '';
$bottom_banner_title = $term_id ? get_term_meta($term_id, 'noriks_collection_bottom_banner_title', true) : '';
$bottom_banner_subtitle = $term_id ? get_term_meta($term_id, 'noriks_collection_bottom_banner_subtitle', true) : '';
$bottom_banner_button_text = $term_id ? get_term_meta($term_id, 'noriks_collection_bottom_banner_button_text', true) : '';
$bottom_banner_button_url = $term_id ? get_term_meta($term_id, 'noriks_collection_bottom_banner_button_url', true) : '';
$bottom_banner_image_id = $term_id ? (int) get_term_meta($term_id, 'noriks_collection_bottom_banner_image_id', true) : 0;
$bottom_banner_bg_color = $term_id ? get_term_meta($term_id, 'noriks_collection_bottom_banner_bg_color', true) : '';
$bottom_banner_image_url = $bottom_banner_image_id ? wp_get_attachment_image_url($bottom_banner_image_id, 'full') : '';
$product_order_raw = $term_id ? get_term_meta($term_id, 'noriks_collection_product_order', true) : '';
$bottom_product_ids_raw = $term_id ? get_term_meta($term_id, 'noriks_collection_bottom_product_ids', true) : '';
$ordered_product_ids = function_exists('noriks_collection_order_ids_from_string') ? noriks_collection_order_ids_from_string($product_order_raw) : array();
$bottom_product_ids = function_exists('noriks_collection_order_ids_from_string') ? array_slice(noriks_collection_order_ids_from_string($bottom_product_ids_raw), 0, 8) : array();

$query_args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'tax_query'      => array(
        array(
            'taxonomy' => 'collections',
            'field'    => 'term_id',
            'terms'    => $term_id,
        ),
    ),
);

if (!empty($ordered_product_ids)) {
    $query_args['post__in'] = $ordered_product_ids;
    $query_args['orderby'] = 'post__in';
}

$products = new WP_Query($query_args);
$bottom_products = null;
if ($show_bottom_products === '1' && !empty($bottom_product_ids)) {
    $bottom_products = new WP_Query(array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => count($bottom_product_ids),
        'post__in'       => $bottom_product_ids,
        'orderby'        => 'post__in',
    ));
}
?>

<?php if ($show_promo === '1' && ($promo_title || $promo_subtitle)) : ?>
<section class="noriks-collection-hero">
  <div class="noriks-collection-hero__inner">
    <div class="noriks-collection-hero__content">
      <?php if ($promo_title) : ?>
      <h2 class="noriks-collection-hero__title"><?php echo esc_html($promo_title); ?></h2>
      <?php endif; ?>
      <?php if ($promo_subtitle) : ?>
        <p class="noriks-collection-hero__subtitle"><?php echo esc_html($promo_subtitle); ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($show_intro_text === '1' && $intro_text) : ?>
<section class="noriks-collection-intro">
  <div class="noriks-collection-intro__inner">
    <p><?php echo nl2br(esc_html($intro_text)); ?></p>
  </div>
</section>
<?php endif; ?>

<section class="noriks-collection-products">
  <?php if ($products->have_posts()) : ?>
    <?php wc_set_loop_prop('columns', 4); ?>
    <?php woocommerce_product_loop_start(); ?>
    <?php while ($products->have_posts()) : $products->the_post(); ?>
      <?php wc_get_template_part('content', 'product'); ?>
    <?php endwhile; ?>
    <?php woocommerce_product_loop_end(); ?>
    <?php wp_reset_postdata(); ?>
  <?php else : ?>
    <p class="woocommerce-info"><?php esc_html_e('No products found in this collection.', 'textdomain'); ?></p>
  <?php endif; ?>
</section>

<?php if ($show_bottom_banner === '1' && ($bottom_banner_title || $bottom_banner_subtitle || $bottom_banner_image_url)) : ?>
<section class="noriks-collection-bottom-banner">
  <div class="noriks-collection-bottom-banner__inner">
    <div class="noriks-collection-bottom-banner__image">
      <?php if ($bottom_banner_image_url) : ?>
      <img src="<?php echo esc_url($bottom_banner_image_url); ?>" alt="<?php echo esc_attr($bottom_banner_title); ?>">
      <?php endif; ?>
    </div>
    <div class="noriks-collection-bottom-banner__content">
      <?php if ($bottom_banner_title) : ?>
      <h2><?php echo esc_html($bottom_banner_title); ?></h2>
      <?php endif; ?>
      <?php if ($bottom_banner_subtitle) : ?>
      <p><?php echo esc_html($bottom_banner_subtitle); ?></p>
      <?php endif; ?>
      <?php if ($show_bottom_banner_button === '1' && $bottom_banner_button_text && $bottom_banner_button_url) : ?>
      <a class="noriks-collection-bottom-banner__button" href="<?php echo esc_url($bottom_banner_button_url); ?>"><?php echo esc_html($bottom_banner_button_text); ?></a>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($show_bottom_intro_text === '1' && $bottom_intro_text) : ?>
<section class="noriks-collection-intro noriks-collection-intro--bottom">
  <div class="noriks-collection-intro__inner">
    <p><?php echo nl2br(esc_html($bottom_intro_text)); ?></p>
  </div>
</section>
<?php endif; ?>

<?php if ($bottom_products && $bottom_products->have_posts()) : ?>
<section class="noriks-collection-bottom-products">
  <div class="noriks-collection-bottom-products__inner">
    <?php wc_set_loop_prop('columns', 4); ?>
    <?php woocommerce_product_loop_start(); ?>
    <?php while ($bottom_products->have_posts()) : $bottom_products->the_post(); ?>
      <?php wc_get_template_part('content', 'product'); ?>
    <?php endwhile; ?>
    <?php woocommerce_product_loop_end(); ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>
<?php endif; ?>

<style>
.tax-collections .site-main {
  margin-bottom: 0;
}

.tax-collections {
  --noriks-collection-max-width: 1790px;
  --noriks-collection-gutter: 20px;
  --noriks-collection-mobile-gutter: 15px;
}

.tax-collections .noriks-collection-hero {
  padding: 14px var(--noriks-collection-gutter);
}

.tax-collections .noriks-collection-hero__inner {
  width: 100%;
  max-width: var(--noriks-collection-max-width);
  margin: 0 auto;
  position: relative;
  background: #111;
  background-image: url("https://devhr.noriks.com/wp-content/uploads/2025/07/blue5.png");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  border-radius: 5px;
  overflow: hidden;
  display: block;
  min-height: 220px;
}

.tax-collections .noriks-collection-hero__inner::before {
  content: none;
}

.tax-collections .noriks-collection-hero__content {
  max-width: 70%;
  padding: 42px var(--noriks-collection-gutter) 42px 40px;
  color: #fff;
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 14px;
  min-height: 220px;
  box-sizing: border-box;
}

.tax-collections .noriks-collection-hero__title {
  margin: 0;
  color: #fff;
  font-size: clamp(28px, 4vw, 56px);
  font-weight: 700;
  line-height: 1.05;
  text-transform: uppercase;
  white-space: normal;
  overflow-wrap: anywhere;
}

.tax-collections .noriks-collection-hero__subtitle {
  max-width: 60%;
  margin: 0;
  font-size: 17px;
  line-height: 1.45;
  color: rgba(255, 255, 255, 0.88);
}

.tax-collections .noriks-collection-hero__media {
  display: none;
}

.tax-collections .noriks-collection-products {
  max-width: calc(var(--noriks-collection-max-width) + (var(--noriks-collection-gutter) * 2));
  margin: 0 auto;
  padding: 0 var(--noriks-collection-gutter);
  box-sizing: border-box;
}

.tax-collections .noriks-collection-intro {
  max-width: calc(var(--noriks-collection-max-width) + (var(--noriks-collection-gutter) * 2));
  margin: 0 auto;
  padding: 0 var(--noriks-collection-gutter) 14px;
  box-sizing: border-box;
}

.tax-collections .noriks-collection-hero + .noriks-collection-intro {
  padding-top: 8px;
}

.tax-collections .noriks-collection-bottom-banner + .noriks-collection-intro--bottom {
  margin-top: -42px;
}

.tax-collections .noriks-collection-intro__inner {
  color: #202124;
  margin: 0;
}

.tax-collections .noriks-collection-intro__inner p {
  margin: 0;
  font-family: 'Roboto', sans-serif;
  font-size: clamp(18px, 2.1vw, 28px);
  font-weight: 700;
  line-height: 1;
  color: #202124;
}

.tax-collections .noriks-collection-bottom-banner {
  padding: 10px var(--noriks-collection-gutter) 56px;
}

.tax-collections .noriks-collection-bottom-products {
  max-width: calc(var(--noriks-collection-max-width) + (var(--noriks-collection-gutter) * 2));
  margin: 0 auto;
  padding: 0 var(--noriks-collection-gutter) 56px;
  box-sizing: border-box;
}

.tax-collections .noriks-collection-bottom-products__inner {
  margin: 0 auto;
}

.tax-collections .noriks-collection-bottom-banner__inner {
  max-width: var(--noriks-collection-max-width);
  margin: 0 auto;
  width: 100%;
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  align-items: stretch;
  gap: 0;
  overflow: hidden;
}

.tax-collections .noriks-collection-bottom-banner__image {
  width: 100%;
  overflow: hidden;
}

.tax-collections .noriks-collection-bottom-banner__image img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 0;
}

.tax-collections .noriks-collection-bottom-banner__content {
  background: <?php echo esc_html($bottom_banner_bg_color ? $bottom_banner_bg_color : '#f0eaea'); ?>;
  text-align: center;
  padding: 40px 32px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.tax-collections .noriks-collection-bottom-banner__content h2 {
  margin: 0 0 24px;
  font-family: 'Roboto', sans-serif;
  font-size: clamp(42px, 4vw, 60px);
  font-weight: 700;
  line-height: 1.05;
  color: #202124;
}

.tax-collections .noriks-collection-bottom-banner__content p {
  margin: 0 0 30px;
  font-family: 'Roboto', sans-serif;
  font-size: 21px;
  line-height: 1.45;
  color: #3c4043;
}

.tax-collections .noriks-collection-bottom-banner__button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 340px;
  min-height: 64px;
  padding: 16px 28px;
  background: #2b2b2b;
  color: #fff;
  font-family: 'Roboto', sans-serif;
  font-size: 18px;
  font-weight: 700;
  text-decoration: none;
  box-shadow: none;
}

.tax-collections ul.products {
  display: grid !important;
  grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
  gap: 16px !important;
  align-items: start !important;
  margin: 0 auto;
  padding: 0;
}

.tax-collections ul.products li.product,
.tax-collections ul.products .wc-block-grid__product,
.tax-collections .wc-block-grid__products li.product,
.tax-collections .wc-block-grid__products .wc-block-grid__product {
  clear: none !important;
  float: none !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
  margin-bottom: 0 !important;
}

.tax-collections .site-main ul.products.columns-4 li.product,
.tax-collections .site-main ul.products.columns-3 li.product,
.tax-collections .site-main ul.products.columns-2 li.product,
.tax-collections .site-main ul.products.columns-1 li.product {
  width: 100% !important;
  float: none !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
}

.tax-collections ul.products li.product {
  width: 100% !important;
  position: relative;
  overflow: hidden;
}

.tax-collections ul.products li.product img,
.tax-collections ul.products .wc-block-grid__product img,
.tax-collections .wc-block-grid__products li.product img,
.tax-collections .wc-block-grid__products .wc-block-grid__product img {
  display: block;
  margin: 0 auto 10px;
}

.tax-collections .woocommerce ul.products li.product img {
  display: block;
  width: 100%;
  transition: opacity 0.3s ease;
  backface-visibility: hidden;
}

.tax-collections .secondary-image {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  width: 100%;
  transition: opacity 0.3s ease;
  z-index: 1;
}

.tax-collections .woocommerce ul.products li.product:hover .secondary-image {
  opacity: 1;
}

.tax-collections .woocommerce ul.products li.product:hover .woocommerce-loop-product__link img:first-child {
  opacity: 0;
}

.tax-collections .woocommerce-loop-product__title {
  font-family: 'Roboto', sans-serif;
  font-weight: normal !important;
  margin-top: 0 !important;
  margin-bottom: 0 !important;
  text-align: center;
}

.tax-collections .price {
  margin-bottom: 22px !important;
  text-align: center;
}

.tax-collections .onsale {
  display: none;
}

.tax-collections .top-liked,
.tax-collections .badge {
  z-index: 999;
  opacity: 1;
  font-size: 10px;
}

@media (max-width: 1280px) {
  .tax-collections .noriks-collection-hero {
    padding: 12px var(--noriks-collection-gutter);
  }

  .tax-collections .noriks-collection-hero__content {
    padding: 36px var(--noriks-collection-gutter);
    max-width: 70%;
    min-height: 220px;
  }

  .tax-collections .noriks-collection-hero__inner::before {
    content: none;
  }

  .tax-collections .noriks-collection-hero__title {
    font-size: clamp(24px, 3.8vw, 46px);
  }
}

@media (max-width: 991px) {
  .tax-collections .noriks-collection-products {
    padding: 0 var(--noriks-collection-mobile-gutter) 9px;
  }

  .tax-collections .noriks-collection-intro {
    padding: 0 var(--noriks-collection-mobile-gutter) 14px;
  }

  .tax-collections .noriks-collection-hero + .noriks-collection-intro {
    padding-top: 0;
  }

  .tax-collections .noriks-collection-bottom-banner + .noriks-collection-intro--bottom {
    margin-top: -26px;
  }

  .tax-collections .noriks-collection-intro__inner p {
    font-size: 17px;
    text-align: center;
  }

  .tax-collections .noriks-collection-bottom-banner {
    padding: 0 var(--noriks-collection-mobile-gutter) 40px;
  }

  .tax-collections .noriks-collection-bottom-products {
    padding: 0 var(--noriks-collection-mobile-gutter) 20px;
  }

  .tax-collections ul.products {
    grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
  }

  .tax-collections .noriks-collection-hero {
    padding: 10px var(--noriks-collection-mobile-gutter);
  }

  .tax-collections .noriks-collection-hero__inner {
    grid-template-columns: 1fr;
    min-height: 0;
  }

  .tax-collections .noriks-collection-hero__content {
    padding: 24px var(--noriks-collection-mobile-gutter);
    max-width: 100%;
    min-height: 0;
    gap: 10px;
  }

  .tax-collections .noriks-collection-hero__subtitle {
    max-width: 100%;
  }

  .tax-collections .noriks-collection-hero__inner::before {
    content: none;
  }

  .tax-collections .noriks-collection-bottom-banner__inner {
    grid-template-columns: 1fr;
    gap: 0;
  }

  .tax-collections .noriks-collection-bottom-banner__image {
    margin: 0;
  }

  .tax-collections .noriks-collection-bottom-banner__content {
    padding: 24px 20px 24px;
    background: <?php echo esc_html($bottom_banner_bg_color ? $bottom_banner_bg_color : '#f0eaea'); ?>;
  }

  .tax-collections .noriks-collection-bottom-banner__content h2 {
    font-size: 34px;
    margin-bottom: 16px;
  }

  .tax-collections .noriks-collection-bottom-banner__content p {
    font-size: 18px;
    margin-bottom: 22px;
  }

  .tax-collections .noriks-collection-bottom-banner__button {
    min-width: 280px;
    min-height: 56px;
    font-size: 16px;
  }
}

@media (max-width: 768px) {
  .tax-collections ul.products {
    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    column-gap: 10px !important;
    row-gap: 5px !important;
  }

  .tax-collections ul.products li.product,
  .tax-collections ul.products .wc-block-grid__product,
  .tax-collections .wc-block-grid__products li.product,
  .tax-collections .wc-block-grid__products .wc-block-grid__product {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
  }

  .tax-collections ul.products li.product img,
  .tax-collections ul.products .wc-block-grid__product img,
  .tax-collections .wc-block-grid__products li.product img,
  .tax-collections .wc-block-grid__products .wc-block-grid__product img {
    margin: 0 auto 2px;
  }

  .tax-collections .woocommerce-loop-product__title {
    margin-bottom: 0 !important;
    line-height: 1.15;
  }

  .tax-collections .price {
    margin-bottom: 7px !important;
  }

  .tax-collections .top-liked,
  .tax-collections .badge {
    font-size: 8px !important;
  }
}
</style>

<?php
do_action('woocommerce_after_main_content');
get_footer('shop');
