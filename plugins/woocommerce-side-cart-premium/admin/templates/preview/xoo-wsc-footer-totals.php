<?php

$totals = array(
	'subtotal' 		=> array(
		'{{data.footer.subtotalLabel}}', wc_price( 100 )
	),
	'shipping' 		=> array(
		__( 'Shipping', 'side-cart-woocommerce' ), wc_price( 50 )
	),
	'total' 		=> array(
		__( 'Total', 'side-cart-woocommerce' ), wc_price( 150 )
	),
);


?>

<div class="xoo-wsc-ft-totals">

	<?php foreach ($totals as $key => $data ): ?>
		<# if( data.footer.totals.<?php echo $key ?> ){ #>
			<div class="xoo-wsc-ft-amt xoo-wsc-ft-amt-<?php echo $key ?>">
				<span class="xoo-wsc-ft-amt-label"><?php echo $data[0] ?></span>
				<span class="xoo-wsc-ft-amt-value"><?php echo $data[1] ?></span>
			</div>
		<# } #>
	<?php endforeach; ?>

</div>
