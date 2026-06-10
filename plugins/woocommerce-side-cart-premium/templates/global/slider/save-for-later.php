<?php
/**
 * Save for Later
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/slider/save-for-later.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 4.6
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::saved_for_later() );

?>

<div class="xoo-wsc-sl-heading">
	<span class="xoo-wsc-toggle-slider xoo-wsc-slider-close xoo-wsc-icon-arrow-thin-right"></span>
	<span class="xoo-wsc-slh-txt"><?php echo $heading ?></span>
</div>

<div class="xoo-wsc-sl-body">

	<?php if( Xoo_Wsc_Template_Args::$saveForLaterNeedsLogin ): ?>

		<div class="xoo-wsc-savl-login">

			<?php if( Xoo_Wsc_Template_Args::$isSaveForLaterLoginSlider ){
				$loginHTMLarg1 = '<span class="xoo-el-login-tgr">';
				$loginHTMLarg2 = '</span>';
			}
			else{
				$loginHTMLarg1 = '<a href="'.get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ).'">';
				$loginHTMLarg2 = '</a>';
			}

			?>

			<?php printf( __( 'Please %1$slogin%2$s to see your saved products.', 'side-cart-woocommerce' ), $loginHTMLarg1, $loginHTMLarg2 ); ?>

		</div>


	<?php else: ?>

		<?php if( empty( $savedItems ) ): ?>

			<span class="xoo-wsc-savl-empty">No items to show</span>

		<?php else: ?>	

			<div class="xoo-wsc-savl-container xoo-wsc-savl-<?php echo $style ?>">

				<?php foreach ( $savedItems  as $cart_key => $item ): ?>

					<?php

					$product 			= $item['data'];

					$product_permalink 	= $product->is_visible() ? $product->get_permalink() : '';

					$thumbnail 			= apply_filters( 'xoo_wsc_saved_for_later_product_thumbnail', $product->get_image(), $product );

					$thumbnail 			= $product_permalink && $showPLink ? sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ) : $thumbnail;

					$product_name 		= $product_permalink && $showPLink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $product->get_name() ) : $product->get_name();

					$product_price 		= apply_filters( 'xoo_wsc_saved_for_later_product_price', wc_price( $product->get_price() ), $product );

					$product_name 		= $product->get_name();

					if( $product->get_type() === 'variation' ){
						if( $pnameVariation === "no" ){
							$product_name = $product->get_title();
							$item['data']->set_name( $product->get_title() );
						}
					}
					
					$product_name 		= $product_permalink && $showPLink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $product_name ) : $product_name;

					$product_meta 		= wc_get_formatted_cart_item_data( $item );

					?>

					<div class="xoo-wsc-savl-prod-cont">

						<div class="xoo-wsc-savl-product" data-ckey="<?php echo $cart_key ?>">

							<?php if( $showImage ): ?>
								<div class="xoo-wsc-savl-left-col">
									<?php echo $thumbnail ?>
								</div>
							<?php endif; ?>

							<div class="xoo-wsc-savl-right-col">

								<?php do_action( 'xoo_wsc_savl_start', $product ); ?>

								<div class="xoo-wsc-savl-rc-top">

									<?php if( $showTitle ): ?>
										<span class="xoo-wsc-savl-title"><?php echo $product_name; ?></span>
									<?php endif; ?>


									<?php if( $deleteType === 'icon' ): ?>
										<div class="xoo-wsc-tooltip-cont xoo-wsc-savl-del-cont">
											<span class="xoo-wsc-savl-del <?php echo $delete_icon ?> xoo-wsc-has-tooltip"></span>
											<span class="xoo-wsc-tooltip"><?php echo $deleteText ?></span>
										</div>
									<?php else: ?>
										<span class="xoo-wsc-savl-del xoo-wsc-savl-deltxt"><?php echo $deleteText ?></span>
									<?php endif; ?>

								</div>

								<?php echo $product_meta ?>

								<div class="xoo-wsc-savl-rc-bottom">

									<?php if( $showPrice ): ?>
										<span class="xoo-wsc-savl-price"><?php echo $product_price; ?></span>
									<?php endif; ?>

									<?php if( $showATC ): ?>
										<div class="xoo-wsc-savl-atc"><span class="xoo-wsc-icon-cart-plus"></span><?php _e( 'Add to Cart', 'side-cart-woocommerce' ); ?></div>
									<?php endif; ?>

								</div>


								<?php do_action( 'xoo_wsc_savl_end', $product ); ?>

							</div>

						</div>

					</div>

				<?php endforeach; ?>

			</div>

		<?php endif; ?>

	<?php endif; ?>

</div>