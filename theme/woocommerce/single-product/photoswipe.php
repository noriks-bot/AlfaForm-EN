<?php
/**
 * Photoswipe markup
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/photoswipe.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<style>


    .pswp  {
          z-index: 99999999 !important;
    }
    
    
    .pswp__ui--hidden .pswp__top-bar {
        opacity: 1 !important;
    } 

    .pswp__top-bar {
	   opacity: 1;
    }
    
    .pswp__preloader  {
	   display: none;
    }
    
    .pswp__button--arrow--right {

            top: 50%; 
            margin-top: -50px !important;
            width: 50px !important;
            height: 50px !important;
            background: black !important;
    }
    
    
    .pswp__button--arrow--right:before  {
                right: 8px !important;
                top: 11px !important;

     }     
     
     
      .pswp__button--arrow--left {

            top: 50%; 
            margin-top: -50px !important;
            width: 50px !important;
            height: 50px !important;
            background: black !important;
    }
    
    
    .pswp__button--arrow--left:before  {
                left: 8px !important;
                top: 11px !important;

     }     
     
     
    .pswp--touch  .pswp__button--arrow--left {
    visibility: visible !important;
    }
   
   
    .pswp--touch   .pswp__button--arrow--right {
    visibility: visible !important;
    }
    
    .pswp--touch   {
    visibility: visible !important;
    }
    
    .pswp__button--arrow--left:before, .pswp__button--arrow--right:before {
    filter: none !important;
    }
       
   
   
   /* Show PhotoSwipe arrows on touch devices */
@media (hover: none), (pointer: coarse) {
  .pswp__button--arrow--left,
  .pswp__button--arrow--right {
    display: block !important;
    opacity: 1 !important;
    pointer-events: auto !important;
    z-index: 11000;
  }

  /* If UI is idled, keep them visible */
  .pswp__ui--idle .pswp__button--arrow--left,
  .pswp__ui--idle .pswp__button--arrow--right {
    opacity: 1 !important;
  }
}

/* If WooCommerce flags "one slide", still show arrows (optional) */
.pswp__ui--one-slide .pswp__button--arrow--left,
.pswp__ui--one-slide .pswp__button--arrow--right {
  display: block !important;
}

/* Make background black and icons readable */
.pswp__bg { background: #000 !important; }
.pswp__button--arrow--left:before,
.pswp__button--arrow--right:before {
  filter: invert(1) brightness(2);
}
   
   
   
   .pswp__bg {
   background: #000000d9 !important;
}



.pswp__button2.pswp__button--close {
    display: flex;
    align-items: center;
    gap: 6px;
    border: none;
    color: #fff;
    font-size: 15px;
        text-transform: uppercase;
    letter-spacing: 1.3px;
    color: black;
}

.pswp__button2.pswp__button--close .close-x  {
    margin-top: 7px;
}

.pswp__button2.pswp__button--close .close-x svg {
    width: 23px;
    height: 23px;
    stroke: currentColor;
}


.pswp__button2.pswp__button--close svg,
.pswp__button2.pswp__button--close .close-x {
    pointer-events: none !important;
}


.close-x {
    pointer-events: none !important;
}

.pswp__button2.pswp__button--close {
    pointer-events: auto !important;
    cursor: pointer;
}
    
</style>

<div class="pswp" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
	<div class="pswp__bg"></div>
	<div class="pswp__scroll-wrap">
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>
		<div class="pswp__ui pswp__ui--hidden">
			<div class="pswp__top-bar">
				<div class="pswp__counter"></div>
				<button class="pswp__button pswp__button--zoom" aria-label="<?php esc_attr_e( 'Zoom in/out', 'woocommerce' ); ?>"></button>
				<button class="pswp__button pswp__button--fs" aria-label="<?php esc_attr_e( 'Toggle fullscreen', 'woocommerce' ); ?>"></button>
				<button class="pswp__button pswp__button--share" aria-label="<?php esc_attr_e( 'Share', 'woocommerce' ); ?>"></button>
				<button class="pswp__button2 pswp__button--close" aria-label="<?php esc_attr_e( 'Close (Esc)', 'woocommerce' ); ?>">Zatvori  <span class="close-x">
    <svg viewBox="0 0 24 24" width="26" height="26" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none">
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
    </svg>
</span></button>
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
				<div class="pswp__share-tooltip"></div>
			</div>
			<button  style="background-color: black !important;" class="pswp__button pswp__button--arrow--left" aria-label="<?php esc_attr_e( 'Previous (arrow left)', 'woocommerce' ); ?>"></button>
			<button  style="background-color: black !important;" class="pswp__button pswp__button--arrow--right" aria-label="<?php esc_attr_e( 'Next (arrow right)', 'woocommerce' ); ?>"></button>
			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>
		</div>
	</div>
</div>
