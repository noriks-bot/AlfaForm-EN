<# if ( "cards" === data.product.layout ) { #>
	<?php xoo_wsc_helper()->get_template( 'xoo-wsc-product-card-preview.php', $productData, XOO_WSC_PATH.'/admin/templates/preview' ); ?>
<# }else{ #>
	<?php xoo_wsc_helper()->get_template( 'xoo-wsc-product-row-preview.php', $productData, XOO_WSC_PATH.'/admin/templates/preview' ); ?>
<# } #>