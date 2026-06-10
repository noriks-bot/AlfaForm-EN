<?php
/**
 * Progress bar
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/bar.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 4.4
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::progress_bar() );

if( !isset( $enable ) ) return;


$priceHTML = $endHTML = $titleHTML = '';

$base = '<span %1$s %2$s>%3$s</span>';

foreach ( $points as $index => $point ){

	$style 		 = $divide === 'prop' ? 'style="width: '.$point['width'].'%"' : '';
	$class 		 = $point['reached'] ? 'class="xoo-wsc-pt-reached"' : '';

	$priceHTML  .= sprintf( $base, $style, $class, wc_price( $point['amount'], array( 'decimals' => 0 ) ) );
	$endHTML  	.= sprintf( $base, $style, $class, '' );
	$titleHTML 	.= sprintf( $base, $style, $class, $point['title'] );
}

$barData = array(
	'points' 	=> $points,
	'filled' 	=> $filled
);

?>

<div class="xoo-wsc-bar-cont xoo-wsc-bar-div-<?php echo $divide; ?>" data-bardata="<?php echo htmlspecialchars( json_encode($barData) ); ?>">

	
	<?php if( in_array( 'remaining', $show ) ): ?>
		<div class="xoo-wsc-bar-remtext"><?php echo $remainingText ?></div>
	<?php endif; ?>


	<?php if( in_array( 'amount', $show ) ): ?>
		<div class="xoo-wsc-bar-poamt xoo-wsc-bar-lev">
			<?php echo $priceHTML; ?>
		</div>
	<?php endif; ?>


	<div class="xoo-wsc-bar-in">

		<div class="xoo-wsc-bar">
			<span class="xoo-wsc-bar-filled" style="width: <?php echo $filled ?>%"></span>
		</div>

		<div class="xoo-wsc-bar-poends xoo-wsc-bar-lev">
			<?php echo $endHTML ?>
		</div>

	</div>


	<?php if( in_array( 'title', $show ) ): ?>
		<div class="xoo-wsc-bar-potitle xoo-wsc-bar-lev">
			<?php echo $titleHTML ?>
		</div>
	<?php endif; ?>


</div>