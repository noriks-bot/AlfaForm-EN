<?php
/**
 * Suggested Products
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/footer/suggested-products.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 4.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::suggested_products() );

if( $disable ) return;


$container = '<div class="xoo-wsc-sp-container xoo-wsc-sp-'.$style.'"><span class="xoo-wsc-sp-heading">'.$heading.'</span><ul class="xoo-wsc-sp-slider">%s</ul></div>';

ob_start();

while ( $products->have_posts() ) : $products->the_post();

	global $product;
	
	$product_permalink 	= $product->is_visible() ? $product->get_permalink() : '';

    $_product_id = $product->get_id();

	
	$thumbnail 			= apply_filters( 'xoo_wsc_suggested_product_thumbnail', $product->get_image(), $product );
	$thumbnail 			= $product_permalink && $showPLink ? sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ) : $thumbnail;
	$product_name 		= $product_permalink && $showPLink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $product->get_name() ) : $product->get_name();
	$product_price 		= apply_filters( 'xoo_wsc_suggested_product_price', wc_price( $product->get_price() ), $product );
?>

<li class="xoo-wsc-sp-prod-cont">

	<div class="xoo-wsc-sp-product">

		<div class="xoo-wsc-sp-left-col">
			<?php if( $showImage ) echo $thumbnail ?>
		</div>

		<div class="xoo-wsc-sp-right-col">

			<?php do_action( 'xoo_wsc_sp_start', $product ); ?>

			<div class="xoo-wsc-sp-rc-top">

				<?php if( $showTitle ): ?>
					<span class="xoo-wsc-sp-title"> <?php echo $product_name; ?></span>
				<?php endif; ?>

			</div>

			<div class="xoo-wsc-sp-rc-bottom">

				

				<?php if( $showPrice ): ?>
					<span class="xoo-wsc-sp-price"><?php echo $product_price; ?></span>
				<?php endif; ?>

				<?php if( $showATC ): ?>
		<?php
		            $product_id = $_product_id;

                                if ( $product->is_type('variable') ) {
                                    // Embed variation data directly on button for instant modal
                                    $vdata = noriks_get_product_variation_data($product_id);
                                    echo '<a style="font-size:13px; padding: 5px 9px 5px 9px;" href="#" class="button noriks-upsell-btn" data-product_id="' . esc_attr($product_id) . '" data-vdata="' . esc_attr(json_encode($vdata)) . '">+ DODAJ</a>';
                                } else {
                                    echo '<a style="font-size:13px; padding: 5px 9px 5px 9px;" href="' . esc_url($product->add_to_cart_url()) . '" class="button add_to_cart_button ajax_add_to_cart" data-product_id="' . esc_attr($product_id) . '" data-quantity="1">+ DODAJ</a>';
                                }
    			        ?>
					
				<?php endif; ?>

			</div>


			<?php do_action( 'xoo_wsc_sp_end', $product ); ?>

		</div>

	</div>

	
</li>

<?php endwhile; ?>

<?php wp_reset_postdata(); ?>

<?php printf( $container, ob_get_clean() ); ?>