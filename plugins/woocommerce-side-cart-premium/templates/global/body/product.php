<?php
/**
 * Product
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/body/product.php.
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

$productClasses = apply_filters( 'xoo_wsc_product_class', $productClasses );
$oneLiner  		= $qtyPriceDisplay === 'one_liner' && $showPprice && $showPtotal && $showPqty && !$updateQty;





?>

<?php ob_start(); ?>

<?php if( $showPdel ): ?>

	<?php if( $deleteType === 'icon' ): ?>
		<div class="xoo-wsc-tooltip-cont xoo-wsc-del-cont">
			<span class="xoo-wsc-smr-del <?php echo $delete_icon ?> xoo-wsc-has-tooltip"></span>
			<span class="xoo-wsc-tooltip"><?php echo $deleteText ?></span>
		</div>
	<?php else: ?>
		<span class="xoo-wsc-smr-del xoo-wsc-del-txt"><?php echo $deleteText ?></span>
	<?php endif; ?>

<?php endif; ?>

<?php $deleteHTML = ob_get_clean(); ?>

<div data-key="<?php echo $cart_item_key ?>" class="<?php echo implode( ' ', $productClasses ) ?>">

	<?php do_action( 'xoo_wsc_product_start', $_product, $cart_item_key ); ?>

		<?php if( $showPimage ): ?>

			<div class="xoo-wsc-img-col">
				
				<?php echo $thumbnail; ?>

				<?php if( $deletePosition === 'image' ): ?>

					<?php echo $deleteHTML ?>

				<?php endif; ?>


				<?php do_action( 'xoo_wsc_product_image_col', $_product, $cart_item_key ); ?>

			</div>

		<?php endif; ?>


	<div class="xoo-wsc-sum-col">

		<?php do_action( 'xoo_wsc_product_summary_col_start', $_product, $cart_item_key ); ?>

		<?php if( $showSalesCount && $sales_count > 0 ): ?>
			<div class="xoo-wsc-sm-sales">
				<?php echo $sales_count.'+ ' ?><?php _e('shoppers have bought this','side-cart-woocommerce'); ?>
			</div>
		<?php endif; ?>

		<div class="xoo-wsc-sm-info">

			<div class="xoo-wsc-sm-left">

				<?php if( $showPname ): ?>
					<span class="xoo-wsc-pname"><?php echo $product_name; ?></span>
				<?php endif; ?>
				
				<?php if( $showPmeta ) echo $product_meta ?>

				<!-- Quantity -->

				<?php if( $oneLiner ): ?>

					<div class="xoo-wsc-qty-price">
						<span><?php echo $cart_item['quantity']; ?></span>
						<span>X</span>
						<span><?php echo $product_price; ?></span>
						<span>=</span>
						<span><?php echo $product_subtotal ?></span>
					</div>

				<?php else: ?>

					<?php if( $showPqty && !$updateQty ): ?>
						<span class="xoo-wsc-sml-qty"><?php _e( 'Qty:', 'side-cart-woocommerce' ) ?> <?php echo $cart_item['quantity']; ?></span>
					<?php endif; ?>

					<?php if( $showPprice ): ?>
						<div class="xoo-wsc-pprice">
							<?php echo __( 'Price: ', 'side-cart-woocommerce' ) . $product_price ?>
						</div>
					<?php endif; ?>

				<?php endif; ?>
				


				<?php if( $showPqty && $updateQty ): ?>
				
				
                	<?php if( $product_id  != 423 ): ?>
					<?php
					xoo_wsc_quantity_input(
						array(
							'input_value'  	=> $cart_item['quantity'],
							'quantity'  	=> $cart_item['quantity'],
							'max_value'    	=> $_product->get_max_purchase_quantity(),
							'min_value'    	=> '0',
							'product_name' 	=> $_product->get_name(),
						),
						$_product
					);
					?>
                <?php endif; ?>
				<?php endif; ?>

				<!-- End Quantity -->

			</div>

			

		

			<div class="xoo-wsc-sm-right">

				<?php if( $showPdel && $deletePosition === 'default' ): ?>

					<?php echo $deleteHTML ?>

				<?php endif; ?>

				<?php if( $saveforLaterEnabled ): ?>

					<div class="xoo-wsc-savl-tooltip xoo-wsc-tooltip-cont <?php if( Xoo_Wsc_Template_Args::$isSaveForLaterLoginSlider ) echo 'xoo-el-login-tgr' ?>">

						<?php if( Xoo_Wsc_Template_Args::$saveForLaterNeedsLogin && !Xoo_Wsc_Template_Args::$isSaveForLaterLoginSlider ): ?>
							<a class="<?php echo $save_icon; ?> xoo-wsc-has-tooltip" href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"></a>
						<?php else: ?>
							<span class="xoo-wsc-save <?php echo $save_icon; ?> xoo-wsc-has-tooltip"></span>
						<?php endif; ?>

						<span class="xoo-wsc-tooltip"><?php _e( 'Save for Later', 'side-cart-woocommerce' ) ?></span>
					</div>

				<?php endif; ?>

				<?php if( $showPtotal && !$oneLiner ): ?>
					<span class="xoo-wsc-smr-ptotal"><?php echo $product_subtotal ?></span>
				<?php endif; ?>



			</div>

		</div>

		<?php do_action( 'xoo_wsc_product_summary_col_end', $_product, $cart_item_key ); ?>

	</div>

	<?php do_action( 'xoo_wsc_product_end', $_product, $cart_item_key ); ?>

</div>