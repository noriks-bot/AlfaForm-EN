<!-- Delete HTML -->
<?php ob_start(); ?>

<# if ( data.product.showPdel ) { #>
	<# if ( "icon" === data.product.deleteType ) { #>
		<div class="xoo-wsc-tooltip-cont xoo-wsc-del-cont">
			<span class="xoo-wsc-smr-del {{data.product.deleteIcon}} xoo-wsc-has-tooltip"></span>
			<span class="xoo-wsc-tooltip">{{data.product.deleteText}}</span>
		</div>
	<# }else{ #>
		<span class="xoo-wsc-smr-del xoo-wsc-del-txt">{{data.product.deleteText}}</span>
	<# } #>

<# } #>

<?php $deleteHTML = ob_get_clean(); ?>

<div class="xoo-wsc-product">

	<div class="xoo-wsc-img-col">

		<# if ( data.product.showPImage ) { #>
			<?php echo $product_thumbnail; ?>
		<# } #>

		<# if ( "image" === data.product.deletePosition ) { #>

			<?php echo $deleteHTML; ?>

		<# } #>

	</div>



	<div class="xoo-wsc-sum-col">

		<# if( data.product.showSalesCount && <?php echo $sales_count > 0  ?>){ #>
			<div class="xoo-wsc-sm-sales">
				<?php echo $sales_count.'+ ' ?><?php _e('shoppers have bought this','side-cart-woocommerce'); ?>
			</div>
		<# } #>

		<div class="xoo-wsc-sm-info">

			<div class="xoo-wsc-sm-left">

				<# if ( data.product.showPname ) { #>
					<span class="xoo-wsc-pname"><?php echo $product_name; ?></span>
				<# } #>
				
				<# if ( data.product.showPmeta ) { #>
					<?php echo $product_meta ?>
				<# } #>


				<# if ( data.product.oneLiner ) { #>

					<div class="xoo-wsc-qty-price">
						<span><?php echo $product_quantity; ?></span>
						<span>X</span>
						<span>
							<# if( data.product.priceType === "actual" ){ #>
								<?php echo $product_price; ?>
							<# }else{ #>
								<?php echo $product_sale_price ?>
							<# } #>
						</span>
						<span>=</span>
						<span><?php echo $product_subtotal ?></span>
					</div>

				<# }else{ #>

					<# if ( data.product.showPqty && !data.product.updateQty ) { #>
						<span class="xoo-wsc-sml-qty"><?php _e( 'Qty:', 'side-cart-woocommerce' ) ?> <?php echo $product_quantity; ?></span>
					<# } #>

					<# if ( data.product.showPprice ) { #>
						<div class="xoo-wsc-pprice">
							<?php echo __( 'Price: ', 'side-cart-woocommerce' ); ?>
								<# if( data.product.priceType === "actual" ){ #>
								<?php echo $product_price; ?>
							<# }else{ #>
								<?php echo $product_sale_price ?>
							<# } #>
						</div>
					<# } #>

				<# } #>



				<!-- Quantity -->
				<# if ( data.product.showPqty && data.product.updateQty ) { #>
					<div class="xoo-wsc-qty-box xoo-wsc-qtb-{{{data.product.qtyDesign}}}">

						<span class="xoo-wsc-minus xoo-wsc-chng">-</span>

						<input type="number" class="xoo-wsc-qty" value="<?php echo esc_attr( $product_quantity ); ?>" />

						<span class="xoo-wsc-plus xoo-wsc-chng">+</span>

					</div>
				<# } #>
				

			</div>

			<!-- End Quantity -->


			<div class="xoo-wsc-sm-right">

				<# if ( "default" === data.product.deletePosition ) { #>

					<?php echo $deleteHTML; ?>

				<# } #>


				<# if ( data.saveForLater.enabled ) { #>

					<div class="xoo-wsc-tooltip-cont">

						<span class="xoo-wsc-save {{data.saveForLater.icon}} xoo-wsc-has-tooltip"></span>
						
						<span class="xoo-wsc-tooltip"><?php _e( 'Save for Later', 'side-cart-woocommerce' ) ?></span>

					</div>

				<# } #>
					

				<# if ( data.product.showPtotal && !data.product.oneLiner ) { #>
					<span class="xoo-wsc-smr-ptotal"><?php echo $product_subtotal ?></span>
				<# } #>


			</div>

		</div>

	</div>

</div>