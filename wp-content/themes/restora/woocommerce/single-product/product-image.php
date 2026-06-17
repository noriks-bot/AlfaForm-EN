<?php
/**
 * Single Product Image with custom Prev/Next buttons + counter
 */

use Automattic\WooCommerce\Enums\ProductType;

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">

	<div class="one-more-wrapper">

	    <style>
	        .my-buttons-wrapper {
	            position: absolute;
	              position: absolute;
                    right: 10px;
                    bottom: 180px;
	            z-index: 9;
	            display: flex;
	            align-items: center;
	            gap: 8px;
	            background: rgba(255,255,255,.8);
	            padding: 4px 8px;
	            border-radius: 6px;
	        }
	        .my-btn {
	            width: 36px;
	            height: 36px;
	            border-radius: 4px;
	            border: 1px solid #ddd;
	            background: #fff;
	            display: flex;
	            justify-content: center;
	            align-items: center;
	            cursor: pointer;
	        }
	        .my-btn::before {
	            content:"";
	            display:block;
	            width:10px;
	            height:10px;
	            border-top:2px solid #111;
	            border-right:2px solid #111;
	        }
	        .my-btn.prev::before {   }
	        .my-btn.next::before {  }

	        .my-counter {
	            font-size: 13px;
	            font-weight: 600;
	            color: #333;
	            margin: 0 6px;
	        }

	        .badge-on-img {
	            position: absolute;
	            left: 15px;
	            top: 15px;
	            z-index: 9;
	            display: inline-block;
	            background-color: #971b1b;
	            color: white;
	            font-family: 'Roboto', sans-serif;
	            font-weight: 700;
	            font-size: 11px;
	            padding: 2px 8px 1px 8px;
	            border-radius: 2px;
	            text-transform: uppercase;
	        }
	        
	        .woocommerce-product-gallery__image   {
	           
	        }
	    </style>

	    <?php
	    // Badge moved OUTSIDE slides so it's always visible
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
	        echo '<span class="badge-on-img">-' . esc_html( $discount ) . '' . get_field("singlepp_discount_text","options") .' </span>';
	    }
	    ?>

        <!--
	    <div class="my-buttons-wrapper">
	          <span class="my-counter">1 / 1</span>
	        <button type="button" class="my-btn prev" aria-label="Prethodna slika"><</button>
	      
	        <button type="button" class="my-btn next" aria-label="Sljedeća slika">></button>
	    </div>
	    -->

		<div class="woocommerce-product-gallery__wrapper">
			<?php
			if ( $post_thumbnail_id ) {
				$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
			} else {
				$wrapper_classname = $product->is_type( ProductType::VARIABLE ) && ! empty( $product->get_available_variations( 'image' ) ) ?
					'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder' :
					'woocommerce-product-gallery__image--placeholder';
				$html              = sprintf( '<div class="%s">', esc_attr( $wrapper_classname ) );
				$html             .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				$html             .= '</div>';
			}
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

			do_action( 'woocommerce_product_thumbnails' );
			?>
		</div>
	</div>
</div>


<script>
/*
jQuery(document).ready(function($){
    var $gallery = $('.woocommerce-product-gallery');
    var $track   = $gallery.find('.woocommerce-product-gallery__wrapper');
    var $slides  = $track.find('.woocommerce-product-gallery__image'); // filter only real slides

    if(!$slides.length) return;

    var index = 0;
    var total = $slides.length;
    var $counter = $gallery.find('.my-counter');

    function showSlide(i){
        index = (i + total) % total;
        $slides.hide().eq(index).show();
        $counter.text((index+1) + ' / ' + total);
    }

    // init first slide
    showSlide(0);

    $gallery.find('.my-btn.prev').on('click', function(){
        showSlide(index - 1);
    });

    $gallery.find('.my-btn.next').on('click', function(){
        showSlide(index + 1);
    });
});
*/
</script>




