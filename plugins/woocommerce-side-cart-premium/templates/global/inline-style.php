<?php

/* Main */
$cartWidth 		= (int) $sy['scm-width'];
$cartheight 	= $sy['scm-height'];
$openFrom 		= $sy['scm-open-from'];
$fontFamily 	= $sy['scm-font'];

/* Basket */
$minBasketMob 	= $sy['sck-mob-size'];
$basketSize 	= $sy['sck-bk-size'];
$BasketMobile 	= $sy['sck-show-mobile'];
$showBasket 	= $sy['sck-enable'];
$basketPosition = $sy['sck-position'];
$basketShape 	= $sy['sck-shape'];
$basketIconSize = $sy['sck-size'];
$basketOffset 	= $sy['sck-offset'];
$basketHOffset 	= $sy['sck-hoffset'];
$countPosition 	= $sy['sck-count-pos'];
$basketBG 		= $sy['sck-basket-bg'];
$basketColor 	= $sy['sck-basket-color'];
$basketShadow 	= $sy['sck-basket-sh'];
$countBG 		= $sy['sck-count-bg'];
$countColor 	= $sy['sck-count-color'];


/* Header */
$headerIconSize 	= $sy['sch-close-fsize'];
$headFontSize 	= $sy['sch-head-fsize'];
$headBGColor 	= $sy['sch-bgcolor'];
$headTxtColor 	= $sy['sch-txtcolor'];
$pgBarColor 	= $sy['sch-pbcolor'];
$pgBarFillColor = $sy['sch-pbfillcolor'];
$headBorder		= $sy['sch-border'];

/* Body */
$bodyFontSize 	= $sy['scb-fsize'];
$bodyBGColor 	= $sy['scb-bgcolor'];
$bodyTxtColor 	= $sy['scb-txtcolor'];

/* Product Card */
$bpCardCount 		= (int) $sy['scbp-card-count'];
$bpCardImgColor 	= $sy['scbp-card-img-color'];
$bpCardFrtColor 	= $sy['scbp-card-front-color'];
$bpCardBckColor 	= $sy['scbp-card-back-color'];
$bpCardBckTxtColor 	= $sy['scbp-card-backtxt-color'];
$bpCardTxtColor 	= $sy['scbp-card-txtcolor'];
$bpCardBorder 		= $sy['scbp-card-border'];
$bPCardimgwidth		= (int) $sy['scbp-card-imgw'];
$bPCardimgheight	= (int) $sy['scbp-card-imgh'];
$bPCardpadding 		= $sy['scbp-card-padding'];
$bpCardAnimTim 		= $sy['scbp-card-anim-time'];
$bPCardShadow		= $sy['scbp-card-shadow'];
$bPCardRadTop		= $sy['scbp-card-radius-top'];
$bPCardRadBtm		= $sy['scbp-card-radius-btm'];


/*Product Row */
$bpVarFormat 	= $sy['scbp-var-format'];
$bpDisplay 		= $sy['scbp-display'];
$bPpadding 		= $sy['scbp-padding'];
$bPimgwidth		= (int) $sy['scbp-imgw'];
$bPmargin		= $sy['scbp-margin'];
$bPradius		= (int) $sy['scbp-bradius'];
$bPshadow		= $sy['scbp-shadow'];
$bpBgColor		= $sy['scbp-bgcolor'];

/* Quantity */
$qtyStyle 		= $sy['scbq-style'];
$qtyWidth 		= $sy['scbq-width'];
$qtybtnsize 	= $sy['scbq-btnsize'];
$qtyHeight 		= $sy['scbq-height'];
$qtyBorsize 	= $sy['scbq-bsize'];
$inputBorColor 	= $sy['scbq-input-bcolor'];
$btnBorColor 	= $sy['scbq-box-bcolor'];
$inputBgColor 	= $sy['scbq-input-bgcolor'];
$inputTxtColor 	= $sy['scbq-input-txtcolor'];
$btnBgColor 	= $sy['scbq-box-bgcolor'];
$btnTxtColor 	= $sy['scbq-box-txtcolor'];

/* Footer */
$footerStick 	= $sy['scf-stick'];
$buttonsOrder  	= $sy['scf-button-pos'];
$buttonPadding 	= $sy['scf-btn-padding'];
$buttonRows 	= $sy['scf-btns-row'];
$buttonTheme 	= $sy['scf-btns-theme'];
$buttonbgColor 	= $sy['scf-btn-bgcolor'];
$buttontxtColor = $sy['scf-btn-txtcolor'];
$buttonBorder 	= $sy['scf-btn-border'];

$HVbuttonbgColor 	= $sy['scf-btnhv-bgcolor'];
$HVbuttontxtColor 	= $sy['scf-btnhv-txtcolor'];
$HVbuttonBorder 	= $sy['scf-btnhv-border'];

$ftrPadding 	= $sy['scf-padding'];
$ftrBgColor 	= $sy['scf-bgcolor'];
$ftrTxtColor 	= $sy['scf-txtcolor'];
$ftrFsize 		= $sy['scf-fsize'];
$ftrShadow 		= $sy['scf-shadow'];

/* Suggested Products */
$spImgWidth 	= (int) $sy['scsp-imgw'];
$spFontSize 	= (int) $sy['scsp-fsize'];
$spBGColor 		= $sy['scsp-bgcolor'];
$spPrdBGColor 	= $sy['scsp-prd-bgcolor'];
$drawerWidth 	= $sy['scs-drawer-width'];
$spColCount 	= (int) ( $sy['scsp-col-items'] ? $sy['scsp-col-items'] : 1 );

/* Suggested Products */
$savlImgWidth 	= (int) $sy['sl-imgw'];
$savlFontSize 	= (int) $sy['sl-fsize'];
$savlBGColor 	= $sy['sl-bgcolor'];
$savlTxtColor  	= $sy['sl-prd-txtcolor'];
$savlPrdBGColor = $sy['sl-prd-bgcolor'];
$savlColCount 	= (int) ( $sy['sl-col-items'] ? $sy['sl-col-items'] : 1 );



/* Shortcode */
$SCbasketSize 	= $sy['shbk-size'];
$SCbasketColor 	= $sy['shbk-color'];
$SCcountBG 		= $sy['shbk-count-bg'];
$SCcountColor 	= $sy['shbk-count-color'];
$SCtxtColor 	= $sy['shbk-txt-color'];

if( $buttonRows === 'three' ){
	$gridCols = '1fr 1fr 1fr';
}
elseif ( $buttonRows === 'two_one' ) {
	$gridCols = '2fr 2fr';
	echo 'a.xoo-wsc-ft-btn:nth-child(3){
		grid-column: 1/-1;
	}';
}
elseif ( $buttonRows === 'one_two' ) {
	$gridCols = '2fr 2fr';
	echo 'a.xoo-wsc-ft-btn:nth-child(1){
		grid-column: 1/-1;
	}';
}
else{
	$gridCols = 'auto';
}

?>

.xoo-wsc-sp-left-col img, .xoo-wsc-sp-left-col{
	max-width: <?php echo $spImgWidth ?>px;
}

.xoo-wsc-sp-right-col{
	font-size: <?php echo $spFontSize ?>px;
}

.xoo-wsc-sp-container, .xoo-wsc-dr-sp{
	background-color: <?php echo $spBGColor ?>;
}




<?php if( $buttonTheme === 'custom' ): ?>

.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn, .xoo-wsc-markup .xoo-wsc-btn, .xoo-wsc-markup .woocommerce-shipping-calculator button[type="submit"] {
	background-color: <?php echo $buttonbgColor ?>;
	color: <?php echo $buttontxtColor ?>;
	border: <?php echo $buttonBorder ?>;
	padding: <?php echo $buttonPadding ?>;
}

.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn:hover, .xoo-wsc-markup .xoo-wsc-btn:hover, .xoo-wsc-markup .woocommerce-shipping-calculator button[type="submit"]:hover {
	background-color: <?php echo $HVbuttonbgColor ?>;
	color: <?php echo $HVbuttontxtColor ?>;
	border: <?php echo $HVbuttonBorder ?>;
}


<?php endif; ?> 

.xoo-wsc-footer{
	background-color: <?php echo $ftrBgColor ?>;
	color: <?php echo $ftrTxtColor ?>;
	padding: <?php echo $ftrPadding ?>;
	box-shadow: <?php echo $ftrShadow ?>;
}

.xoo-wsc-footer, .xoo-wsc-footer a, .xoo-wsc-footer .amount{
	font-size: <?php echo $ftrFsize ?>px;
}

.xoo-wsc-ft-buttons-cont{
	grid-template-columns: <?php echo $gridCols ?>;
}

.xoo-wsc-basket{
	<?php echo $basketPosition ?>: <?php echo $basketOffset ?>px;
	<?php echo $openFrom ?>: <?php echo $basketHOffset ?>px;
	background-color: <?php echo $basketBG ?>;
	color: <?php echo $basketColor ?>;
	box-shadow: <?php echo $basketShadow ?>;
	border-radius: <?php echo $basketShape === 'round' ? '50%' : '14px' ?>;
	display: <?php echo $showBasket === 'hide_empty' || $showBasket === 'always_hide' ? 'none' : 'flex'; ?>;
	width: <?php echo $basketSize; ?>px;
	height: <?php echo $basketSize; ?>px;
}

<?php if( $BasketMobile !== 'yes' ): ?>

@media only screen and (max-width: 600px) {
	.xoo-wsc-basket, .xoo-wsc-basket[style*='block']  {
		display: none!important;
	}
}

<?php endif; ?>

.xoo-wsc-bki{
	font-size: <?php echo $basketIconSize.'px' ?>
}

.xoo-wsc-items-count{
	<?php echo $countPosition === 'top_right' || $countPosition === 'top_left' ? 'top' : 'bottom' ?>: -10px;
	<?php echo $countPosition === 'top_right' || $countPosition === 'bottom_right' ? 'right' : 'left' ?>: -10px;
}

.xoo-wsc-items-count, .xoo-wsch-items-count, .xoo-wsch-save-count{
	background-color: <?php echo $countBG ?>;
	color: <?php echo $countColor ?>;
}

.xoo-wsc-container, .xoo-wsc-slider, .xoo-wsc-drawer{
	max-width: <?php echo $cartWidth ?>px;
	<?php echo $openFrom ?>: <?php echo -$cartWidth ?>px;
	<?php echo $cartheight === 'full' ? 'top: 0;bottom: 0' : 'max-height: 100vh' ?>;
	<?php echo $basketPosition ?>: 0;
	font-family: <?php echo $fontFamily; ?>
}

.xoo-wsc-drawer{
	max-width: <?php echo $drawerWidth; ?>px;
}

.xoo-wsc-cart-active .xoo-wsc-container, .xoo-wsc-slider-active .xoo-wsc-slider{
	<?php echo $openFrom ?>: 0;
}

.xoo-wsc-drawer-active .xoo-wsc-drawer{
	<?php echo $openFrom ?>: <?php echo $cartWidth ?>px;
}
.xoo-wsc-drawer{
	<?php echo $openFrom ?>: 0;
}

<?php if( $footerStick !== 'yes' ): ?>

.xoo-wsc-container {
    overflow: auto;
}

.xoo-wsc-body{
	overflow: unset;
	flex-grow: 0;
}
.xoo-wsc-footer{
	flex-grow: 1;
}

<?php endif; ?>

.xoo-wsc-cart-active .xoo-wsc-basket{
	<?php echo $openFrom ?>: <?php echo $cartWidth ?>px;
}

span.xoo-wsch-icon{
	font-size: <?php echo $headerIconSize ?>px;
}


.xoo-wsch-text{
	font-size: <?php echo $headFontSize ?>px;
}

.xoo-wsc-header, .xoo-wsc-drawer-header, .xoo-wsc-sl-heading{
	color: <?php echo $headTxtColor ?>;
	background-color: <?php echo $headBGColor ?>;
	border-bottom: <?php echo $headBorder ?>;
}

.xoo-wsc-bar{
	background-color: <?php echo $pgBarColor ?>
}

span.xoo-wsc-bar-filled{
	background-color: <?php echo $pgBarFillColor ?>
}

.xoo-wsc-body{
	background-color: <?php echo $bodyBGColor ?>;
}

.xoo-wsc-body, .xoo-wsc-body span.amount, .xoo-wsc-body a{
	font-size: <?php echo $bodyFontSize ?>px;
	color: <?php echo $bodyTxtColor ?>;
}

.xoo-wsc-product, .xoo-wsc-sp-product, .xoo-wsc-savl-product{
	padding: <?php echo $bPpadding ?>;
	margin: <?php echo $bPmargin ?>;
	border-radius: <?php echo $bPradius ?>px;
	box-shadow: <?php echo $bPshadow ?>;
	background-color: <?php echo $bpBgColor ?>;
}

.xoo-wsc-body .xoo-wsc-ft-totals{
	padding: <?php echo $bPpadding ?>;
	margin: <?php echo $bPmargin ?>;
}

.xoo-wsc-product-cont{
	padding: <?php echo $bPCardpadding ?>;
}

.xoo-wsc-products:not(.xoo-wsc-pattern-card) .xoo-wsc-img-col{
	width: <?php echo $bPimgwidth ?>%;
}

.xoo-wsc-pattern-card .xoo-wsc-img-col img{
	max-width: <?php echo $bPCardimgwidth ?>%;
	height: <?php echo ($bPCardimgheight > 0 ? $bPCardimgheight.'px' : 'auto') ?>;
}

.xoo-wsc-products:not(.xoo-wsc-pattern-card) .xoo-wsc-sum-col{
	width: <?php echo 100-$bPimgwidth ?>%;
}

.xoo-wsc-pattern-card .xoo-wsc-product-cont{
	width: <?php echo 100/$bpCardCount ?>% 
}

<?php if( $bpCardCount > 1 ): ?>
@media only screen and (max-width: 600px) {
	.xoo-wsc-pattern-card .xoo-wsc-product-cont  {
		width: 50%;
	}
}

<?php endif; ?>

.xoo-wsc-pattern-card .xoo-wsc-product{
	border: <?php echo $bpCardBorder ?>;
	box-shadow: <?php echo $bPCardShadow ?>;
}

<?php if( $bPCardimgwidth < 100 ): ?>
.xoo-wsc-pattern-card .xoo-wsc-img-col{
	background-color: <?php echo $bpCardImgColor ?>;
}
<?php endif; ?>

.xoo-wsc-sm-front, .xoo-wsc-card-actionbar > *{
	background-color: <?php echo $bpCardFrtColor ?>;
}
.xoo-wsc-pattern-card, .xoo-wsc-sm-front{
	border-bottom-left-radius: <?php echo $bPCardRadBtm; ?>px;
	border-bottom-right-radius: <?php echo $bPCardRadBtm; ?>px;
}
.xoo-wsc-pattern-card, .xoo-wsc-img-col img, .xoo-wsc-img-col, .xoo-wsc-sm-back-cont{
	border-top-left-radius: <?php echo $bPCardRadTop; ?>px;
	border-top-right-radius: <?php echo $bPCardRadTop; ?>px;
}
.xoo-wsc-sm-back{
	background-color: <?php echo $bpCardBckColor ?>;
}
.xoo-wsc-pattern-card, .xoo-wsc-pattern-card a, .xoo-wsc-pattern-card .amount{
	font-size: <?php echo $bodyFontSize ?>px;
}

.xoo-wsc-body .xoo-wsc-sm-front, .xoo-wsc-body .xoo-wsc-sm-front a, .xoo-wsc-body .xoo-wsc-sm-front .amount, .xoo-wsc-card-actionbar{
	color: <?php echo $bpCardTxtColor ?>;
}

.xoo-wsc-sm-back, .xoo-wsc-sm-back a, .xoo-wsc-sm-back .amount{
	color: <?php echo $bpCardBckTxtColor ?>;
}


.magictime {
    animation-duration: <?php echo $bpCardAnimTim ?>s;
}

<?php if( wp_is_mobile() && $sy['scb-playout'] === 'cards' && $sy['scbp-card-visible'] === 'back_hover' ) :?>
.xoo-wsc-img-col a{
	pointer-events: none;
}
<?php endif; ?>


<?php if( $bpDisplay === 'stretched' ): ?>
.xoo-wsc-sm-info{
	flex-grow: 1;
    align-self: stretch;
}

.xoo-wsc-sm-left{
	justify-content: space-evenly;
}

<?php else: ?>
.xoo-wsc-sum-col{
	justify-content: <?php echo $bpDisplay ?>;
}
<?php endif; ?>

/***** Quantity *****/

.xoo-wsc-qty-box{
	max-width: <?php echo $qtyWidth ?>px;
}

.xoo-wsc-qty-box.xoo-wsc-qtb-square{
	border-color: <?php echo $btnBorColor ?>;
}

input[type="number"].xoo-wsc-qty{
	border-color: <?php echo $inputBorColor ?>;
	background-color: <?php echo $inputBgColor ?>;
	color: <?php echo $inputTxtColor ?>;
	height: <?php echo $qtyHeight ?>px;
	line-height: <?php echo $qtyHeight ?>px;
}

input[type="number"].xoo-wsc-qty, .xoo-wsc-qtb-square{
	border-width: <?php echo $qtyBorsize ?>px;
	border-style: solid;
}
.xoo-wsc-chng{
	background-color: <?php echo $btnBgColor ?>;
	color: <?php echo $btnTxtColor ?>;
	width: <?php echo $qtybtnsize ?>px;
}

.xoo-wsc-qtb-circle .xoo-wsc-chng{
	height: <?php echo $qtybtnsize ?>px;
	line-height: <?php echo $qtybtnsize ?>px;
}

/** Shortcode **/
.xoo-wsc-sc-count{
	background-color: <?php echo $SCcountBG ?>;
	color: <?php echo $SCcountColor ?>;
}

.xoo-wsc-sc-bki{
	font-size: <?php echo $SCbasketSize ?>px;
	color: <?php echo $SCbasketColor ?>;
}
.xoo-wsc-sc-cont{
	color: <?php echo $SCtxtColor ?>;
}

.xoo-wsc-sp-column li.xoo-wsc-sp-prod-cont{
	width: <?php echo (100/$spColCount) ?>%;
}





<?php if( $gl['m-viewcart-del'] === 'yes' ): ?>
.added_to_cart{
	display: none!important;
}
<?php endif; ?>


span.xoo-wsc-dtg-icon{
	<?php echo $openFrom ?>: calc(100% - 11px );
}


.xoo-wsc-sp-product{
	background-color: <?php echo $spPrdBGColor ?>;
}



<?php if( $minBasketMob === 'yes' ): ?>

@media only screen and (max-width: 600px) {
	.xoo-wsc-basket {
	    width: 40px;
	    height: 40px;
	}

	.xoo-wsc-bki {
	    font-size: 20px;
	}

	span.xoo-wsc-items-count {
	    width: 17px;
	    height: 17px;
	    line-height: 17px;
	    top: -7px;
	    left: -7px;
	}
}


<?php endif; ?>

.xoo-wsc-markup dl.variation {
	display: <?php echo $bpVarFormat === 'one_line' ? 'flex' : 'block' ?>;
}

span.xoo-wsc-gift-ban{
	background-color: <?php echo $buttonbgColor; ?>;
	color: <?php echo $buttontxtColor ?>;
}

.xoo-wsc-sl-savelater .xoo-wsc-sl-body {
	background-color: <?php echo $savlBGColor ?>;
}

.xoo-wsc-savl-left-col img, .xoo-wsc-savl-left-col{
	max-width: <?php echo $savlImgWidth ?>px;
}

.xoo-wsc-savl-column li.xoo-wsc-savl-prod-cont{
	width: <?php echo (100/$savlColCount) ?>%;
}

.xoo-wsc-savl-product{
	background-color: <?php echo $savlPrdBGColor ?>;
}

.xoo-wsc-savl-column .xoo-wsc-savl-prod-cont{
	width: <?php echo (100/$savlColCount) ?>%;
}


.xoo-wsc-savl-right-col, .xoo-wsc-savl-right-col .amount, .xoo-wsc-savl-right-col a {
	font-size: <?php echo $savlFontSize ?>px;
	color: <?php echo $savlTxtColor ?>;
}

<?php if( $gl['m-tooltip'] !== 'yes' ): ?>
.xoo-wsc-tooltip{
	display: none!important;
}
<?php endif; ?>


.xoo-wsc-tooltip{
	background-color: <?php echo $buttonbgColor ?>;
	color: <?php echo $buttontxtColor ?>;
	border: <?php echo $buttonBorder ?>;
	border-width: 1px;
}