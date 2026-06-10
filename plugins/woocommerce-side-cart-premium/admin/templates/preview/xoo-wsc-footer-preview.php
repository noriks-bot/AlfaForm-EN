<?php

$subtotal = wc_price(100);

?>

<# if ( data.totalsLocation !== 'body' ) { #>
	<?php xoo_wsc_helper()->get_template( 'xoo-wsc-footer-totals.php', array(), XOO_WSC_PATH.'/admin/templates/preview' ); ?>
<# } #>


<# if ( data.footer.footerTxt ) { #>
<span class="xoo-wsc-footer-txt">{{{data.footer.footerTxt}}}</span>
<# } #>


<div class="xoo-wsc-ft-buttons-cont">

	<# _.each( data.footer.buttonsPosition, function( key ) { #>
		<# if( data.footer.buttonsText[key] ){ #>
			<a href="#" class="xoo-wsc-ft-btn">{{{data.footer.buttonsText[key]}}} <# if( key === 'checkout' && data.footer.checkoutTotal === 'yes' ){ #> - <?php echo $subtotal; ?> <# } #></a>
		<# } #>
	<# }) #>

</div>

