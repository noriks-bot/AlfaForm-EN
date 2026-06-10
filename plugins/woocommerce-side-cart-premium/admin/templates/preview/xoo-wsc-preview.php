<?php

$products = wc_get_products( array(
	'limit' => 3
) );


$productHTML = empty( $products ) ? 'Please create a product' :  '';

$numberOfProducts = count($products);
$totalQty = 0;

	foreach ($products as $product) {

		$variable 	= false;
		$meta 		= '';
		if( $product->is_type('variable') && !empty( $product->get_available_variations() ) ){
			$variation 	= wc_get_product( $product->get_available_variations()[0]['variation_id'] );
			if( $variation ){
				$product 	= $variation;
				$meta 		= wc_get_formatted_variation($product);
			}
			
		}

		$qty = rand(1,10);

		$totalQty += $qty;

		$productData = array(
			'product_thumbnail' => $product->get_image(),
			'product_name' 		=> $product->get_title(),
			'product_price' 	=> wc_price( $product->get_price() ),
			'product_sale_price'=> $product->get_price_html(),
			'product_quantity' 	=> $qty,
			'product_subtotal' 	=>  wc_price( $qty * (int) $product->get_price() ),
			'product_meta' 		=> '',
			'sales_count' 		=> 500,
			'product' 			=> $product,
		);

		$productHTML .= xoo_wsc_helper()->get_template( 'xoo-wsc-product-preview.php', array( 'productData' => $productData ), XOO_WSC_PATH.'/admin/templates/preview', true );

	}


?>

<div class="xoo-as-preview-style"></div>
<div class="xoo-as-preview"></div>

<script type="text/html" id="tmpl-xoo-as-preview">

	<div class="xoo-wsc-markup xoo-wsc-align-{{data.openFrom}}">
		<div class="xoo-wsc-modal">
			<div class="xoo-wsc-container">

				<# if ( data.basket.show ) { #>

					<div class="xoo-wsc-basket">



						<span class="xoo-wsc-items-count">
							<# if ( data.basket.countType === "quantity" ) { #>
								<?php echo $totalQty; ?>
							<# }else{ #>
								<?php echo $numberOfProducts; ?>
							<# } #>
						</span>
						
						<span class="xoo-wsc-bki {{{data.basket.icon}}}"></span>

					</div>

				<# } #>

				<div class="xoo-wsc-header">
					<?php xoo_wsc_helper()->get_template( 'xoo-wsc-header-preview.php', array(), XOO_WSC_PATH.'/admin/templates/preview' ); ?>
				</div>

				<div class="xoo-wsc-body">

					<div class="xoo-wsc-products xoo-wsc-pattern-<# if (data.product.layout === 'cards') { #>card<# } else { #>row<# } #>">
						<?php echo $productHTML; ?>
					</div>

					<# if ( data.totalsLocation === 'body' ) { #>
						<?php xoo_wsc_helper()->get_template( 'xoo-wsc-footer-totals.php', array(), XOO_WSC_PATH.'/admin/templates/preview' ); ?>
					<# } #>


				</div>

				<div class="xoo-wsc-footer">
					<?php xoo_wsc_helper()->get_template( 'xoo-wsc-footer-preview.php', array(), XOO_WSC_PATH.'/admin/templates/preview' ); ?>
				</div>
				
			</div>

</script>