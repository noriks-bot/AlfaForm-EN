<!-- View Link HTML  -->
<?php ob_start(); ?>
<?php printf( '<a class="xoo-wsc-smr-link" href="#">%1$s</a>', '<i class="xoo-wsc-icon-external-link"></i>'. __( 'View', 'side-cart-woocommerce' ) ); ?>
<?php $viewLinkHTML = ob_get_clean(); ?>

<!-- Price HTML  -->
<?php ob_start(); ?>
<# if ( data.product.showPprice && !data.product.oneLiner) { #>
	<?php printf( '<span class="xoo-wsc-card-price">%1$s</span>', __( 'Price: ', 'side-cart-woocommerce' ) . $product_price ); ?>
<# } #>
<?php $priceHTML = ob_get_clean(); ?>

<!-- Total HTML -->
<?php ob_start(); ?>
<# if ( data.product.showPtotal && !data.product.oneLiner ) { #>
	<span class="xoo-wsc-card-ptotal"><?php echo $product_subtotal ?></span>
<# } #>
<?php $totalHTML = ob_get_clean(); ?>


<!-- Name HTML -->
<?php ob_start(); ?>
<# if ( data.product.showPname ) { #>
	<span class="xoo-wsc-pname"><?php echo $product_name; ?></span>
<# } #>
<?php $nameHTML = ob_get_clean(); ?>


<!-- Meta HTML -->
<?php ob_start(); ?>
<# if ( data.product.showPmeta ) { #>
	<?php echo $product_meta ?>
<# } #>
<?php $metaHTML = ob_get_clean(); ?>


<!-- Quantity HTML -->
<?php ob_start(); ?>

<div class="xoo-wsc-qty-box-cont">

	<# if ( data.product.showPqty && data.product.updateQty ) { #>
		<div class="xoo-wsc-qty-box xoo-wsc-qtb-{{{data.product.qtyDesign}}}">

			<span class="xoo-wsc-minus xoo-wsc-chng">-</span>

			<input type="number" class="xoo-wsc-qty" value="<?php echo esc_attr( $product_quantity ); ?>" />

			<span class="xoo-wsc-plus xoo-wsc-chng">+</span>

		</div>

	<# }else{ #>


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

		<# } #>

	<# } #>

	<?php echo $totalHTML ?>

</div>

<?php $qtyHTML = ob_get_clean(); ?>


<div class="xoo-wsc-product-cont <# if (data.card.hasBack) { #>xoo-wsc-has-back<# } #>">

	<div class="xoo-wsc-product">

		<div class="xoo-wsc-card-cont">

			<div class="xoo-wsc-card-actionbar">

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


				<# if ( data.saveForLater.enabled ) { #>

					<div class="xoo-wsc-tooltip-cont">

						<span class="xoo-wsc-save {{data.saveForLater.icon}} xoo-wsc-has-tooltip"></span>
						
						<span class="xoo-wsc-tooltip"><?php _e( 'Save for Later', 'side-cart-woocommerce' ) ?></span>

					</div>

				<# } #>

				</div>


			<div class="xoo-wsc-img-col magictime">

				<# if ( data.product.showPImage ) { #>
					<?php echo $product_thumbnail; ?>
				<# } #>

			</div>


			<# if ( data.card.hasBack ) { #>

			<div class="xoo-wsc-sm-back-cont">

				<div class="xoo-wsc-sm-back">

					<# if ( data.card.backShow.name ) { #>
						<?php echo $nameHTML; ?>
					<# } #>

					<# if ( data.card.backShow.meta ) { #>
						<?php echo $metaHTML; ?>
					<# } #>

					<# if ( data.card.backShow.link ) { #>
						<?php echo $viewLinkHTML; ?>
					<# } #>


					<# if ( data.card.backShow.price ) { #>
						<?php echo $priceHTML; ?>
					<# } #>

					<# if ( data.card.backShow.qty ) { #>
						<?php echo $qtyHTML; ?>
					<# } #>

				</div>

			</div>

			<# } #>
			
		</div>


		<div class="xoo-wsc-sm-front">

			<span class="xoo-wsc-sm-emp"></span>

			<# if ( !data.card.backShow.name || data.card.visibility === 'all_on_front' ) { #>
				<?php echo $nameHTML; ?>
			<# } #>

			<# if ( !data.card.backShow.price || data.card.visibility === 'all_on_front' ) { #>
				<?php echo $priceHTML; ?>
			<# } #>

			<# if ( !data.card.backShow.meta || data.card.visibility === 'all_on_front' ) { #>
				<?php echo $metaHTML; ?>
			<# } #>

			<# if ( !data.card.backShow.qty || data.card.visibility === 'all_on_front' ) { #>
				<?php echo $qtyHTML; ?>
			<# } #>


		</div>

	</div>

</div>