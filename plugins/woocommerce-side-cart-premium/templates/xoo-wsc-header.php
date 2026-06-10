<?php
/**
 * Side Cart Header
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/xoo-wsc-header.php.
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

extract( Xoo_Wsc_Template_Args::cart_header() );

$headingHTML = $basketHTML = $saveHTML = $closeHTML = '';

?>


<?php ob_start(); ?>

<?php if( $showBasket ): ?>

<div class="xoo-wsch-basket">

	<?php if( $customBasketIcon ): ?>
		<span class="xoo-wsch-bki"><img src="<?php echo esc_url($customBasketIcon) ?>"></span>
	<?php else: ?>
		<span class="xoo-wsch-bki <?php echo esc_html($basketIcon) ?> xoo-wsch-icon"></span>
	<?php endif; ?>

	<span class="xoo-wsch-items-count"><?php echo xoo_wsc_cart()->get_cart_count() ?></span>
</div>
<?php endif; ?>

<?php $basketHTML = ob_get_clean(); ?>



<?php ob_start(); ?>

<?php if( $heading ): ?>
	<span class="xoo-wsch-text"><?php echo $heading ?></span>
<?php endif; ?>

<?php $headingHTML = ob_get_clean(); ?>




<?php ob_start(); ?>

<?php if( $saveforLaterEnabled ): ?>
	<div class="xoo-wsc-tooltip-cont">
		<div class="xoo-wsch-savelater xoo-wsc-has-tooltip xoo-wsc-toggle-slider" data-slider="savelater">
			<?php if( !Xoo_Wsc_Template_Args::$saveForLaterNeedsLogin ): ?>
				<span class="xoo-wsch-save-count"><?php echo xoo_wsc_cart()->get_saved_items_count() ?></span>
			<?php endif; ?>
			<span class="xoo-wsch-save-icon <?php echo $saveForLaterIcon ?> xoo-wsch-icon"></span>
		</div>
		<span class="xoo-wsc-tooltip"><?php echo $savedForLaterHeading; ?></span>
	</div>
<?php endif; ?>

<?php $saveHTML = ob_get_clean(); ?>



<?php ob_start(); ?>

<?php if( $showCloseIcon ): ?>
	<span class="xoo-wsch-close <?php echo  $close_icon ?> xoo-wsch-icon"></span>
<?php endif; ?>
<?php $closeHTML = ob_get_clean(); ?>


<div class="xoo-wsch-top">

	<?php if( $showNotifications ): ?>
		<?php xoo_wsc_cart()->print_notices_html( 'cart' ); ?>
	<?php endif; ?>	

	<?php foreach ( $headerLayout as $section => $elements ): ?>
		
		<div class="xoo-wsch-section xoo-wsch-sec-<?php echo $section ?>">
			<?php foreach ( $elements as $element ){
				echo ${$element.'HTML'};
			}
			?>
		</div>

	<?php endforeach; ?>
	

</div>