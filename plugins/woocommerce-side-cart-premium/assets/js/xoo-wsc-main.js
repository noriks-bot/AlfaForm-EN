jQuery(document).ready(function($){

	var isCartPage 		= xoo_wsc_params.isCart == '1',
		isCheckoutPage 	= xoo_wsc_params.isCheckout == '1';

	var get_wcurl = function( endpoint ) {
		return xoo_wsc_params.wc_ajax_url.toString().replace(
			'%%endpoint%%',
			endpoint
		);
	};

	var markupTimeout = null;

	class Notice{

		constructor( $modal ){
			this.$modal = $modal;
			this.timeout = null;
		}

		add( notice, type = 'success', clearPrevious = true ){

			var $noticeCont = this.$modal.find('.xoo-wsc-notice-container');

			if( clearPrevious ){
				$noticeCont.html('');
			}

			var noticeHTML = type === 'success' ? xoo_wsc_params.html.successNotice.toString().replace( '%s%', notice ) : xoo_wsc_params.html.errorNotice.toString().replace( '%s%', notice );

			$noticeCont.html( noticeHTML );

		}

		showNotification(){

			Notice.showMarkupNotice();

			var $noticeCont = this.$modal.find('.xoo-wsc-notice-container');

			if( !$noticeCont.length || $noticeCont.children().length === 0 ) return;

			$noticeCont.slideDown();
			
			clearTimeout(this.timeout);

			this.timeout = setTimeout(function(){
				$noticeCont.slideUp('slow',function(){
					//$noticeCont.html('');
				});
			},xoo_wsc_params.notificationTime )

		}



		hideNotification(){
			this.$modal.find('.xoo-wsc-notice-container').hide();
		}

		static hideMarkupNotice(){
			Notice.$noticeContainer().removeClass('xoo-wsc-active');
		}

		static $noticeContainer(){
			return $('.xoo-wsc-markup-notices')
		}

		static showMarkupNotice(){

			if( cart.isOpen() ) return;

			var $markupNotice = Notice.$noticeContainer();

			var $noticeCont = $markupNotice.find('.xoo-wsc-notice-container .xoo-wsc-notices');

			if( !$noticeCont.length || $noticeCont.children().length === 0 ) return;

			setTimeout(function(){$markupNotice.addClass('xoo-wsc-active')},10);
			
			clearTimeout(markupTimeout);

			markupTimeout = setTimeout(function(){
				$markupNotice.removeClass('xoo-wsc-active');
			},xoo_wsc_params.notificationTime )
		}
	}

	var masonryInitialised = {};

	function initMasonryLayout( type = '' ){

		var layouts = {
			saveLater: {'.xoo-wsc-savl-column': '.xoo-wsc-savl-prod-cont'},
			cart: {'.xoo-wsc-pattern-card': '.xoo-wsc-product-cont'},
			suggested: {'.xoo-wsc-sp-column ul.xoo-wsc-sp-slider': '.xoo-wsc-sp-prod-cont'}
		};

		var initLayouts = {};

		if( type ){
			if( Array.isArray( type ) ){
				$.each( type, function(index, type_val ){
					initLayouts[ type_val ] = layouts[ type_val ];
				} )
			}
			else{
				initLayouts[type] = layouts[type];
			}
			
		}else{
			initLayouts = layouts;
		}


		$.each( initLayouts, function(type, layout){

			if( masonryInitialised[type] &&  document.body.contains( masonryInitialised[type][0] ) ) return true;

			$.each( layout, function(cont, childClass){
				if( $(cont).length && $(cont).is(':visible') ){
					$(cont).masonry({
						// options
						itemSelector: childClass,
						columnWidth: childClass, /* Each column takes 50% */
						percentPosition: true
					});
					masonryInitialised[type] = $(cont);
				}
			})
		})

		
	}

	class Container{

		static eventHandlerCalled = false;

		constructor( $modal, container ){
			this.$modal 			= $modal;
			this.container 			= container || 'cart';
			this.notice 			= new Notice( this.$modal );
		}


		isOpen(){
			return this.$modal.hasClass('xoo-wsc-'+this.container+'-active');
		}

		eventHandlers(){
			$(document.body).on( 'wc_fragments_loaded updated_checkout', this.onCartUpdate.bind(this) );	
		}

		onCartUpdate(){
			this.unblock();
			this.notice.showNotification();
		}

		setAjaxData( data, noticeSection ){

			var ajaxData = {
				container: this.container,
				noticeSection: noticeSection || this.noticeSection || this.container,
				isCheckout: isCheckoutPage,
				isCart: isCartPage
			}


			if( typeof data === 'object' ){

				$.extend( ajaxData, data );

			}
			else{

				var serializedData = data;

				$.each( ajaxData, function( key, value ){
					serializedData += ( '&'+key+'='+value );
				} )
		
				ajaxData = serializedData;

			}

			return ajaxData;
		}


		toggle( type ){

			var $activeEls 	= this.$modal.add( 'body' ).add('html'),
				activeClass = 'xoo-wsc-'+ this.container +'-active';

			if( type === 'show' ){
				$activeEls.addClass(activeClass);
			}
			else if( type === 'hide' ){
				$activeEls.removeClass(activeClass);
				this.notice.hideNotification();
			}
			else{
				$activeEls.toggleClass(activeClass);
			}


			$(document.body).trigger( 'xoo_wsc_' + this.container + '_toggled', [ type ] );

		}


		block(){
			this.$modal.addClass('xoo-wsc-loading');
		}

		unblock(){
			this.$modal.removeClass('xoo-wsc-loading');
		}


		refreshMyFragments(){

			if( xoo_wsc_params.refreshCart === "yes" && typeof wc_cart_fragments_params !== 'undefined' ){
				$( document.body ).trigger( 'wc_fragment_refresh' );
				return;
			}

			this.block();

			$.ajax({
				url: get_wcurl( 'xoo_wsc_refresh_fragments' ),
				type: 'POST',
				context: this,
				data: {},
				success: function( response ){
					this.updateFragments(response);
					$( document.body ).trigger( 'wc_fragments_refreshed' );
				},
				complete: function(){
					this.unblock();
				}
			})

		}


		updateCartCheckoutPage(){

			//Refresh checkout page
			if( isCheckoutPage ){
				if( $( 'form.checkout' ).length === 0 ){
					location.reload();
					return;
				}
				$(document.body).trigger("update_checkout");
			}

			//Refresh Cart page
			if( isCartPage ){
				$(document.body).trigger("wc_update_cart");
			}

		}

		updateFragments( response ){

			if( response.fragments ){

				$( document.body ).trigger( 'xoo_wsc_before_loading_fragments', [ response ] );

				this.block();

				//Set fragments
		   		$.each( response.fragments, function( key, value ) {
					$( key ).replaceWith( value );
				});

		   		if( typeof wc_cart_fragments_params !== 'undefined' && ( 'sessionStorage' in window && window.sessionStorage !== null ) ){

		   			sessionStorage.setItem( wc_cart_fragments_params.fragment_name, JSON.stringify( response.fragments ) );
					localStorage.setItem( wc_cart_fragments_params.cart_hash_key, response.cart_hash );
					sessionStorage.setItem( wc_cart_fragments_params.cart_hash_key, response.cart_hash );

					if ( response.cart_hash ) {
						sessionStorage.setItem( 'wc_cart_created', ( new Date() ).getTime() );
					}

				}

				$( document.body ).trigger( 'wc_fragments_loaded' );

				this.unblock();

			}

			if( xoo_wsc_params.refreshCart === "yes" && typeof wc_cart_fragments_params !== 'undefined' ){
				this.block();
				$( document.body ).trigger( 'wc_fragment_refresh' );
				return;
			}

		}

	}


	class Cart extends Container{

		static isWCAjaxAddToCart = false;

		constructor( $modal ){

			super( $modal, 'cart' );

			this.baseQty 				= 1;
			this.qtyUpdateDelay 		= null;
			this.bodyPosition 			= false;
			this.cartLoaded 			= false;
			this.blockAddedToCartCalled = false;

			this.refreshFragmentsOnPageLoad();
			this.eventHandlers();
			this.initSlider();

		}


		refreshFragmentsOnPageLoad(){
			if( xoo_wsc_params.fetchCart === 'page_load' ){
				setTimeout(function(){
					this.refreshMyFragments();
				}.bind(this), xoo_wsc_params.fetchDelay )
			}
		}

		eventHandlers(){

			super.eventHandlers();

			this.$modal.on( 'click', '.xoo-wsc-chng', this.toggleQty.bind(this) );
			this.$modal.on( 'change', '.xoo-wsc-qty', this.changeInputQty.bind(this) );
			this.$modal.on( 'click', '.xoo-wsc-undo-item', this.undoItem.bind(this) );
			this.$modal.on( 'focusin', '.xoo-wsc-qty', this.saveQtyFocus.bind(this) );
			this.$modal.on( 'click', '.xoo-wsc-smr-del', this.deleteIconClick.bind(this) );
			this.$modal.on( 'click', '.xoo-wsch-close, .xoo-wsc-opac, .xoo-wsc-cart-close', this.closeCartOnClick.bind(this) );
			this.$modal.on( 'click', '.xoo-wsc-basket', this.toggleCart.bind(this) );

			$( document.body ).on( 'click', '.xoo-wsc-ecl', this.emptyCart.bind(this) );

			$(document.body).on( 'xoo_wsc_cart_updated', this.updateCartCheckoutPage.bind(this) );
			$(document.body).on( 'click', 'a.added_to_cart, .xoo-wsc-cart-trigger', this.openCart.bind(this) );
			$(document.body).on( 'added_to_cart ', this.addedToCart.bind(this) );

			if( xoo_wsc_params.ajaxAddToCart === 'yes' ){
				$(document.body).on( 'submit', 'form.cart', this.addToCartFormSubmit.bind(this) );
			}

			if( typeof wc_cart_fragments_params === 'undefined' ){
				$( window ).on( 'pageshow' , this.onPageShow.bind(this) );
			}

			if( xoo_wsc_params.triggerClass ){
				$(document.body).on( 'click', '.'+xoo_wsc_params.triggerClass, this.openCart.bind(this) );
			}



			if( isCheckoutPage || isCartPage ){
				$(document.body).on( 'updated_shipping_method', this.refreshMyFragments.bind(this) );
			}

			$(document.body).on( 'wc-blocks_added_to_cart', this.blockAddedToCart.bind(this) );

			$(document.body).on( 'adding_to_cart', this.checkIfWCAjaxAddToCart.bind(this) );

			//Animate shipping bar
			$(document.body).on( 'xoo_wsc_before_loading_fragments adding_to_cart wc_fragment_refresh', this.storeProgressBarWidth.bind(this) );

			//$(document.body).on( 'wc_fragments_loaded', this.checkIfWCAjaxAddToCartUnset.bind(this) );

			initMasonryLayout( ['cart', 'suggested' ] );

			if( xoo_wsc_params.autoOpenCart === 'yes' && xoo_wsc_params.addedToCart === 'yes'){
				this.openCart();
			}


			this.$modal.on( 'click', '.xoo-wsc-save', this.saveForLater.bind(this) );

		}


		saveForLater(e){

			if( xoo_wsc_params.saveForLaterNeedsLogin ) return;

			var $product 		= $(e.currentTarget).closest('.xoo-wsc-product'),
				cartKey 		= $product.data('key'),
				formData 		= {
					cart_key: cartKey,
				}

				this.block();
				this.saveScrollPosition();
			
			
			$.ajax({
				url: get_wcurl( 'xoo_wsc_save_for_later' ),
				type: 'POST',
				context: this,
				data: this.setAjaxData(formData),
				success: function(response){

					this.updateFragments( response );

					$(document.body).trigger( 'xoo_wsc_added_to_save_list', [response, cartKey] );
					$(document.body).trigger( 'xoo_wsc_cart_updated', [response] );

					this.setScrollPosition();
					this.unblock();

					var $saveLaterIcon = this.$modal.find('.xoo-wsch-savelater');

					if( $saveLaterIcon.length ){
						$saveLaterIcon.addClass('xoo-wsc-shake-animate');
						setTimeout(function(){
							$saveLaterIcon.removeClass('xoo-wsc-shake-animate');
						},1200);
					}

				}

			})

		}

		checkIfWCAjaxAddToCartUnset(){
			this.isWCAjaxAddToCart = false;
		}

		checkIfWCAjaxAddToCart(e, $button, data){

			Cart.isWCAjaxAddToCart = true;

			if( ( !(data instanceof FormData) || !data.has('action') || !data.get('action') === 'xoo_wsc_add_to_cart' ) && $button.hasClass('ajax_add_to_cart') ){
				this.isWCAjaxAddToCart = true;
			}
		}


		toggleCart(e){
			if( this.isOpen() ){
				this.closeCartOnClick(e);
			}
			else{
				this.openCart(e);
			}
			
		}


		openCart(e){
			if( e ){
				e.preventDefault();
				e.stopImmediatePropagation();
			}

			if( !this.cartLoaded && xoo_wsc_params.fetchCart === 'cart_open' ){
				this.refreshMyFragments();
				this.cartLoaded = true;
			}

			this.toggle('show');
			this.animateProgressBar();
			Notice.hideMarkupNotice();

		}

		addToCartFormSubmit(e){

			var $form = $(e.currentTarget);

			if( $form.closest('.product').hasClass('product-type-external') || $form.siblings('.xoo-wsc-disable-atc').length ) return;

			var $button  		= e.originalEvent && e.originalEvent.submitter ? $(e.originalEvent.submitter) : $form.find( 'button[type="submit"]'),
				formData 		= new FormData($form.get(0)),
				productData  	= $form.serializeArray(),
				hasProductId 	= false;

			//Check for woocommerce custom quantity code 
			//https://docs.woocommerce.com/document/override-loop-template-and-show-quantities-next-to-add-to-cart-buttons/
			$.each( productData, function( key, form_item ){
				if( form_item.name === 'productID' || form_item.name === 'add-to-cart' ){
					if( form_item.value ){
						hasProductId = true;
						return false;
					}
				}
			})

			//If no product id found , look for the form action URL
			if( !hasProductId && $form.attr('action') ){
				var is_url = $form.attr('action').match(/add-to-cart=([0-9]+)/),
					productID = is_url ? is_url[1] : false; 
			}

			// Add submitted button value
	        if( $button.attr('name') && $button.attr('value') ){
	            formData.append( $button.attr('name'), $button.attr('value') );
	        }

	        if( productID ){
	        	formData.append( 'add-to-cart', productID );
	        }

	        formData.append( 'action', 'xoo_wsc_add_to_cart' );

	        var doAjaxAddToCart = true;

	        
        	$.each( xoo_wsc_params.skipAjaxForData, function( key, value ){
        		if( formData.has(key) && ( !value || formData.get(key) == value ) ){
        			doAjaxAddToCart = false;
        			return false;
        		}
        	} )
	        

	        if( doAjaxAddToCart ){
	        	e.preventDefault();
	        	this.addToCartAjax( $button, formData );//Ajax add to cart
	        }
			
		}


		addToCartAjax( $button, formData ){

			this.block();

			$button.addClass('loading');

			// Trigger event.
			$( document.body ).trigger( 'adding_to_cart', [ $button, formData ] );

			$.ajax({
				url: get_wcurl( 'xoo_wsc_add_to_cart' ),
				type: 'POST',
				context: this,
				cache: false,
			    contentType: false,
			    processData: false,
				data: formData,
			    success: function(response){

					if(response.fragments){
						// Trigger event so themes can refresh other areas.
						$( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $button ] );
					}else if(response.error){
						Notice.$noticeContainer().html(response.notice);
						Notice.showMarkupNotice();
					}
					else{
						window.location.reload();
					}

			    },
			    complete: function(){
			    	this.unblock();
			    	$button
			    		.removeClass('loading')
			    		.addClass('added');
			    }
			})
		}

		addedToCart( e, response, hash, $button ){

			$(document.body).trigger( 'xoo_wsc_cart_updated', [response] );
	
			var _this = this;

			this.flyToCart( $button, function(){
				if( xoo_wsc_params.autoOpenCart === "yes" ){
					setTimeout(function(){
						_this.openCart();	
					},20 )
				}
			} );
		}


		blockAddedToCart(){

			if( !Cart.isWCAjaxAddToCart && !this.blockAddedToCartCalled ){

				this.refreshMyFragments();
				
				var _this = this;

				if( xoo_wsc_params.autoOpenCart === "yes" ){
					setTimeout(function(){
						_this.openCart();	
					},20 )
				}

				this.blockAddedToCartCalled = true;

				setTimeout( function(){
					_this.blockAddedToCartCalled = false;
				}, 200 );

				Cart.isWCAjaxAddToCart = false;

			}


						
		}


		flyToCart( $atcEL, callback ){

			var $basket = this.$modal.find('.xoo-wsc-basket').length ? this.$modal.find('.xoo-wsc-basket') : $(document.body).find('.xoo-wsc-sc-cont');

			if( !$basket.length || xoo_wsc_params.flyToCart !== 'yes' || !$atcEL || !$atcEL.length ){
				callback();
				return;
			}

			var customDragImgClass 	= xoo_wsc_params.productFlyClass,
				$dragIMG 			= null,
				$product 			= $atcEL.closest('.product');


			//If has product container
			if( $product.length ){

				$product = $($product[0]);

				var $productGallery = $product.find('.woocommerce-product-gallery');

				if( customDragImgClass && $product.find( customDragImgClass ).length ){
					$dragIMG = $product.find( customDragImgClass );
				}
				else if( $product.find( 'img[data-xooWscFly="fly"]' ).length ){
					if( $productGallery.length ){
						$dragIMG = $productGallery.find( '.flex-active-slide img[data-xooWscFly="fly"]' ).length ? $productGallery.find( '.flex-active-slide img[data-xooWscFly="fly"]' ) : $productGallery.find( 'img[data-xooWscFly="fly"]' )
					}
					else{
						$dragIMG = $product.find( 'img[data-xooWscFly="fly"]' );
					}
				}
				else if( $productGallery.length ){
					$dragIMG = $productGallery;
				}
				else{
					$dragIMG = $product;
				}

			}
			else if( customDragImgClass ){
				var moveUp = 4;
				for ( var i = moveUp; i >= 0; i-- ) {
					var $foundImg = $atcEL.parent().find( customDragImgClass );
					if( $foundImg.length ){
						$dragIMG = $foundImg;
						return false;
					}
				}
			}


			if( !$dragIMG || !$dragIMG.length ){
				callback();
				return;
			}

			$dragIMG = $dragIMG.eq(0);

			var $imgclone = $dragIMG
				.clone()
	    		.offset({
		            top: $dragIMG.offset().top,
		            left: $dragIMG.offset().left
		        })
	        	.addClass( 'xoo-wsc-fly-animating' )
	            .appendTo( $('body') )
	            .animate({
	            	'top': $basket.offset().top - 20,
		            'left': $basket.offset().left - 20,
		            'width': 75,
		            'height': 75
		        }, parseInt( xoo_wsc_params.flyToCartTime ), 'easeInOutExpo' );
	        
	        setTimeout(function () {
	        	callback()
	        }, parseInt( xoo_wsc_params.flyToCartTime ) );

	        $imgclone.animate({
	        	'width': 0,
	        	'height': 0
	        }, function () {
	        	$(this).detach();
	        });

		}


		toggleQty(e){

			var $toggler 	= $(e.currentTarget),
				$input 		= $toggler.siblings('.xoo-wsc-qty');

			if( !$input.length ) return;

			var baseQty = this.baseQty = parseFloat( $input.val() ),
				step 	= parseFloat( $input.attr('step') ),
				action 	= $toggler.hasClass( 'xoo-wsc-plus' ) ? 'add' : 'less',
				newQty 	= action === 'add' ? baseQty + step : baseQty - step;

			
			$input.val(newQty).trigger('change');

		}

		changeInputQty(e){

			this.notice.hideNotification();

			var $_this	= this,
 				$input 	= $(e.currentTarget),
				newQty 	= parseFloat( $input.val() ),
				step 	= parseFloat( $input.attr('step') ),
				min 	= parseFloat( $input.attr('min') ),
				max 	= parseFloat( $input.attr('max') ),
				invalid = false,
				message = false;

			//Validation
			
			if( isNaN( newQty )  || newQty < 0 || newQty < min  ){
				invalid = true;
			}
			else if( newQty > max ){
				invalid = true;
				message = xoo_wsc_params.strings.maxQtyError.replace( '%s%', max );
			}
			else if( !Number.isInteger(newQty/step ) ){
				invalid = true;
				message = xoo_wsc_params.strings.stepQtyError.replace( '%s%', step );
			}
			
			//Set back to default quantity
			if( invalid ){
				$input.val( this.baseQty );
				if( message ){
					this.notice.add( message, 'error' );
					this.notice.showNotification();
				}
				return;
			}

			//Update
			$input.val( newQty );

			clearTimeout( this.qtyUpdateDelay );

			this.qtyUpdateDelay = setTimeout(function(){
				$_this.updateItemQty( $input.parents('.xoo-wsc-product').data('key'), newQty )
			}, xoo_wsc_params.qtyUpdateDelay );
			
			
		}


		saveScrollPosition(){
			this.bodyPosition = this.$modal.find('.xoo-wsc-body').length ? this.$modal.find('.xoo-wsc-body').scrollTop() : false;
		}

		setScrollPosition(){
			if( this.bodyPosition !== false ){
				this.$modal.find( '.xoo-wsc-body' ).scrollTop( this.bodyPosition );
				this.bodyPosition = false; //reset
			}
		}

		updateItemQty( cart_key, qty ){

			if( !cart_key || qty === undefined ) return;

			this.block();
			
			this.saveScrollPosition();

			var formData = {
				cart_key: cart_key,
				qty: qty
			}

			$.ajax({
				url: get_wcurl( 'xoo_wsc_update_item_quantity' ),
				type: 'POST',
				context: this,
				data: this.setAjaxData(formData),
				success: function(response){
					this.updateFragments( response );
					$(document.body).trigger( 'xoo_wsc_quantity_updated', [response] );
					$(document.body).trigger( 'xoo_wsc_cart_updated', [response] );
					this.setScrollPosition();
					this.unblock();
				}

			})
		}


		closeCartOnClick(e){
			e.preventDefault();
			if( drawer.isOpen() ){
				drawer.toggle('hide');
				setTimeout( function(){
					cart.toggle( 'hide' )
				}, 500 );
			}
			else{
				cart.toggle('hide');
			}

		}


		saveQtyFocus(e){
			this.baseQty = $(e.currentTarget).val();
		}


		onPageShow(e){
			if ( e.originalEvent.persisted ) {
				this.refreshMyFragments();
				$( document.body ).trigger( 'wc_fragment_refresh' );
			}
		}

		deleteIconClick(e){
			this.updateItemQty( $( e.currentTarget ).parents('.xoo-wsc-product').data('key'), 0 );
		}

		undoItem(e){

			var $undo 		= $(e.currentTarget),
				formData 	= {
					cart_key: $undo.data('key')
				}

			this.block();

			$.ajax({
				url: get_wcurl('xoo_wsc_undo_item'),
				type: 'POST',
				context: this,
				data: this.setAjaxData(formData),
				success: function(response){
					this.updateFragments( response );
					$(document.body).trigger( 'xoo_wsc_item_restored', [response] );
					$(document.body).trigger( 'xoo_wsc_cart_updated', [response] );
					this.unblock();
				}

			})
		}

		storeProgressBarWidth( e ){

			var $bar = $(document.body).find( '.xoo-wsc-bar-filled' );

			if( !$bar.length ) return;

			this.progressBarWidth = $bar.prop('style').width;

			var $barCont 	= $bar.closest('.xoo-wsc-bar-cont'),
				barData 	= $barCont.data('bardata');

			if( !barData ) return;

			this.progressBarData = barData;
		}

		onCartUpdate(){
			super.onCartUpdate();
			this.cartLoaded = true;
			this.initAnimateProgressBar = true;
			if( this.isOpen() ){
				this.animateProgressBar();
			}
			this.initSlider();
			this.showBasket();
			initMasonryLayout( ['cart','suggested'] );
		}


		
		showBasket(){

			var $basket = $('.xoo-wsc-basket'),
				show 	= xoo_wsc_params.showBasket;

			if( show === "always_show" ){
				$basket.show();	
			}
			else if( show === "hide_empty" ){
				if( this.$modal.find('.xoo-wsc-product').length ){
					$basket.show();
				}
				else{
					$basket.hide();
				}
			}
			else{
				$basket.hide();
			}
		}

		animateProgressBar(){

			if( isCartPage || isCheckoutPage || !this.initAnimateProgressBar ) return;

			var $bar = $(document.body).find( '.xoo-wsc-bar-filled' );

			if( !$bar.length || !this.progressBarWidth ) return;
			var newWidth = $bar.prop('style').width;

			$bar
				.width( this.progressBarWidth )
				.animate({ width: newWidth }, 400, 'linear');

			this.checkPointAchievedAnimate();

			this.initAnimateProgressBar = false;
		}

		checkPointAchievedAnimate(){

			var pastBarData = this.progressBarData;

			var $bar 		= $(document.body).find( '.xoo-wsc-bar-filled' ),
				$barCont 	= $bar.closest('.xoo-wsc-bar-cont'),
				barData 	= $barCont.data('bardata');

			var pastPointsReached 	= [],
				newPointsReached 	= [],
				allPointsReached 	= false;

			$.each( pastBarData.points, function( index, point ){
				if( point.reached == true ){
					pastPointsReached.push(point.id);
				}
			} )

			$.each( barData.points, function( index, point ){
				if( point.reached == true && !pastPointsReached.includes(point.id)  ){
					newPointsReached.push(point.id);
				}

				if( point.reached == true && (index + 1) === barData.points.length  ){
					allPointsReached = true;
				}
			} )



			if( newPointsReached.length ){
				setTimeout( function(){
					Celebrate.Celebrate( allPointsReached && xoo_wsc_params.bar.fullCelebration !== 'none' ? xoo_wsc_params.bar.fullCelebration : xoo_wsc_params.bar.singleCelebration );
				}, 200 );
			}

			this.progressBarData = barData;
		}


		emptyCart(){

			this.block();

			$.ajax({
				url: get_wcurl( 'xoo_wsc_empty_cart' ),
				type: 'POST',
				context: this,
				data: {},
			    success: function(response){
			    	
					this.updateFragments( response );
					// Trigger event.
					$( document.body ).trigger( 'xoo_wsc_cart_emptied' );
					$(document.body).trigger( 'xoo_wsc_cart_updated', [response] );
			    },
			    complete: function(){
			    	this.unblock();
			    }
			})
		}


		initSlider(){

			if( typeof $.fn.lightSlider !== 'function' || xoo_wsc_params.spSlide.enable !== 'yes' ) return;

			$('ul.xoo-wsc-sp-slider').each( function( index, el ){
				var $el = $(el);

				if( $(this).parents('.xoo-wsc-drawer').length ) return;

				$el.lightSlider(xoo_wsc_params.spSlide);

			} );
			
		}

	}


	class Drawer extends Container{

		constructor( $modal ){

			super( $modal, 'drawer' );

			this.setHeaderHeight();

			this.eventHandlers();

		}

		eventHandlers(){

			super.eventHandlers();

			$(document.body).on( 'xoo_wsc_cart_toggled', this.drawOutOnCartOpen.bind(this) );
			$(document.body).on( 'click', '.xoo-wsc-toggle-drawer', this.toggleDrawer.bind(this) );
			$(document.body).on( 'click', '.xoo-wscdh-close', this.close.bind(this) );
			//$(document.body).on( 'wc_fragments_loaded', this.onCartUpdate.bind(this) );
		}

		onCartUpdate(){
			super.onCartUpdate();
			this.setHeaderHeight();
			setTimeout(function(){
				drawer.toggleOnContentBasis();
			}, 0);
			
		}


		toggleOnContentBasis(){

			var hasContent = !this.isDrawerEmpty();

			if( this.isOpen() ){
				if( !hasContent ){
					this.toggle('hide');
					this.$modal.find('.xoo-wsc-dtg-icon').addClass('xoo-wsc-disabled');
					this.emptyClosed = true;
				}
			}
			else{
				if( hasContent && cart.isOpen() && this.emptyClosed ){
					this.toggle('show');
					this.$modal.find('.xoo-wsc-dtg-icon').removeClass('xoo-wsc-disabled');
					this.emptyClosed = false;
				}
			}
		}

		setHeaderHeight(){
			var $cartHeader = $('.xoo-wsc-header');
			if( !$cartHeader.length ) return;
	
			this.$modal.closest('.xoo-wsc-markup').find('.xoo-wsc-drawer-header, .xoo-wsc-sl-heading').height($cartHeader.height());
		}

		isDrawerEmpty(){
			return !this.$modal.find('.xoo-wsc-dr-content').length;
		}


		toggleDrawer(){
			this.toggle();
		}


		drawOutOnCartOpen(e,type){
			
			if( !cart.isOpen() || this.isDrawerEmpty() ) return;

			setTimeout( function(){
				drawer.toggle('show');
				initMasonryLayout('suggested');
			}, xoo_wsc_params.drawerWait );

		}


		close(e){
			this.toggle('hide');
		}

		getDataType(){
			return this.$modal.find('.xoo-wsc-dr-content').data('drawer');
		}


	}

	

	class Slider extends Container{

		constructor( $modal ){

			super( $modal, 'slider' );

			if( xoo_wsc_params.sliderAutoClose ) this.noticeSection = 'cart';

			this.eventHandlers();

			this.shipping = xoo_wsc_params.shippingEnabled ? Shipping.init( this ) : null;

		}

		eventHandlers(){

			super.eventHandlers();


			$( document.body ).on( 'click', '.xoo-wsc-toggle-slider', this.triggerSlider.bind(this) );
			$( document.body ).on( 'xoo_wsc_cart_toggled', this.closeSliderOnCartClose.bind(this) );

			if( xoo_wsc_params.sliderAutoClose ){
				$( document.body ).on( 'xoo_wsc_coupon_applied xoo_wsc_shipping_calculated updated_shipping_method xoo_wsc_coupon_removed xoo_wsc_moved_from_save_list', this.closeSlider.bind(this) );
			}

			$(document.body).on( 'submit', 'form.xoo-wsc-sl-apply-coupon', this.submitCouponForm.bind(this) );
			$(document.body).on( 'click', '.xoo-wsc-coupon-apply-btn', this.applyCouponFromBtn.bind(this) );
			$(document.body).on( 'click', '.xoo-wsc-remove-coupon', this.removeCoupon.bind(this) );
			$(document.body).on( 'click', '.xoo-wsc-savl-del', this.deleteSavedForLaterItem.bind(this) );
			$(document.body).on( 'click', '.xoo-wsc-savl-atc', this.moveSavedForLaterItemToCart.bind(this) );

		}


		moveSavedForLaterItemToCart(e){

			var $item 			= $(e.currentTarget).closest('.xoo-wsc-savl-product'),
				cartKey 		= $item.data('ckey'),
				formData 		= {
				cart_key: cartKey,
			}

			this.block();
			
			$.ajax({
				url: get_wcurl( 'xoo_wsc_move_save_for_later_item' ),
				type: 'POST',
				context: this,
				data: this.setAjaxData(formData),
				success: function(response){

					this.updateFragments( response );

					$(document.body).trigger( 'xoo_wsc_moved_from_save_list', [response, cartKey] );

					this.unblock();

				}

			})
		}

		deleteSavedForLaterItem(e){

			var $item 			= $(e.currentTarget).closest('.xoo-wsc-savl-product'),
				cartKey 		= $item.data('ckey'),
				formData 		= {
				cart_key: cartKey,
			}

			this.block();
			
			$.ajax({
				url: get_wcurl( 'xoo_wsc_delete_save_for_later_item' ),
				type: 'POST',
				context: this,
				data: this.setAjaxData(formData, 'slider' ),
				success: function(response){

					this.updateFragments( response );

					$(document.body).trigger( 'xoo_wsc_delete_from_save_list', [response, cartKey] );

					this.unblock();

				}

			})
		}


		removeCoupon(e){

			e.preventDefault();

			var $removeEl 	= $(e.currentTarget),
				coupon 		= $removeEl.data('code'),
				formData 	= {
					coupon: coupon
				};

			this.block();	

			$.ajax( {
				url: get_wcurl( 'xoo_wsc_remove_coupon' ),
				type: 'POST',
				context: this,
				data: this.setAjaxData( formData, cart.$modal.find( $removeEl ).length ? 'cart' : 'slider' ),
				success: function( response ) {
					this.updateFragments(response);
				},
				complete: function() {
					this.unblock();
					this.updateCartCheckoutPage();
					$( document.body ).trigger( 'xoo_wsc_coupon_removed' );
				}
			} );
		}

		onCartUpdate(){
			super.onCartUpdate();
			this.toggleContent();
		}

		closeSlider(){
			this.toggle('hide');
		}


		applyCouponFromBtn(e){
			this.applyCoupon( $(e.currentTarget).val() );
		}

		submitCouponForm(e){

			e.preventDefault();

			var $form = $(e.currentTarget);

			this.applyCoupon( $form.find('input[name="xoo-wsc-slcf-input"]').val() );

		}


		closeSliderOnCartClose(e){

			var $this = $(e.currentTarget); 

			if( !cart.$modal.hasClass('xoo-wsc-cart-active') ){
				this.toggle('hide');
			}

		}


		triggerSlider(e){

			var $toggler 	= $(e.currentTarget),
 				slider 		= $toggler.data('slider');

			if( slider === 'shipping' && isCheckoutPage ){
				this.notice.add( xoo_wsc_params.strings.calculateCheckout, 'error' );
				this.notice.showNotification();
				return;
			}


			this.$modal.attr( 'data-slider', slider );
			
			this.toggle();

			this.toggleContent();
		}


		toggleContent(){

			var activeSlider = '';

			$('.xoo-wsc-sl-content').hide();
			
			var activeSlider 	= this.$modal.attr('data-slider'),
				$toggleEl 		= $('.xoo-wsc-sl-content[data-slider="'+activeSlider+'"]');
	
			if( $toggleEl.length ) $toggleEl.show();

			if( activeSlider === 'savelater' && this.isOpen() ){
				initMasonryLayout('saveLater');
			}

			$( document.body ).trigger( 'xoo_wsc_slider_data_toggled', [activeSlider] );
		}


		applyCoupon( coupon ){

			if( !coupon ){
				this.notice.add( xoo_wsc_params.strings.couponEmpty, 'error' );
				this.notice.showNotification();
				return;
			}

			this.block();

			var formData = {
				'coupon': coupon,
			}

			$.ajax( {
				url: get_wcurl('xoo_wsc_apply_coupon'),
				type: 'POST',
				context: this,
				data: this.setAjaxData( formData ),
				success: function( response ) {
					this.updateFragments(response);
				},
				complete: function() {
					this.unblock();
					this.updateCartCheckoutPage();
					$( document.body ).trigger( 'xoo_wsc_coupon_applied' );
				}
			} );

		}

	}

	

	var Shipping = {

		init: function( slider ){
			slider.$modal.on( 'change', 'input.xoo-wsc-shipping-method', this.shippingMethodChange );
			slider.$modal.on( 'submit', 'form.woocommerce-shipping-calculator', this.shippingCalculatorSubmit );
			slider.$modal.on( 'click', '.shipping-calculator-button', this.toggleCalculator );
			$(document.body).on( 'wc_fragments_loaded xoo_wsc_slider_data_toggled', this.initSelect2 );
		},

		toggleCalculator: function(e){

			e.preventDefault();
			e.stopImmediatePropagation();

			$(this).siblings('.shipping-calculator-form').slideToggle();
			$( document.body ).trigger( 'country_to_state_changed' );
		},

		shippingCalculatorSubmit: function(e){

			e.preventDefault();
			e.stopImmediatePropagation();

			var $form = $(this);

			slider.block();

			// Provide the submit button value because wc-form-handler expects it.
			$( '<input />' )
				.attr( 'type', 'hidden' )
				.attr( 'name', 'calc_shipping' )
				.attr( 'value', 'x' )
				.appendTo( $form );

			var formData = $form.serialize();

			// Make call to actual form post URL.
			$.ajax( {
				url: get_wcurl( 'xoo_wsc_calculate_shipping' ),
				type: 'POST',
				context: this,
				data: slider.setAjaxData(formData),
				success: function( response ) {
					slider.updateFragments(response);
				},
				complete: function() {
					slider.unblock();
					slider.updateCartCheckoutPage();
					$( document.body ).trigger( 'xoo_wsc_shipping_calculated' );
				}
			} );

		},

		shippingMethodChange: function(e){

			e.preventDefault();
			e.stopImmediatePropagation();

			var shipping_methods = {};

			slider.block();

			$( 'select.shipping_method, :input[name^=xoo-wsc-shipping_method][type=radio]:checked, :input[name^=shipping_method][type=hidden]' ).each( function() {
				shipping_methods[ $( this ).data( 'index' ) ] = $( this ).val();
			} );

			var formData = {
				shipping_method: shipping_methods,
			}

			$.ajax( {
				type:     'POST',
				url:      get_wcurl( 'xoo_wsc_update_shipping_method' ),
				data:     slider.setAjaxData( formData ),
				success:  function( response ) {
					slider.updateFragments(response);
				},
				complete: function() {
					slider.unblock();
					slider.updateCartCheckoutPage();
					$( document.body ).trigger( 'updated_shipping_method' );
				}
			} );

		},

		initSelect2: function(e){
			$( document.body ).trigger( 'country_to_state_changed' );
		},
	}


	var cart 	= new Cart( $('.xoo-wsc-modal') ),
		slider 	= new Slider( $('.xoo-wsc-slider-modal') );
		drawer 	= new Drawer( $('.xoo-wsc-drawer-modal') );


	var AnimateCard = {

		type: xoo_wsc_params.cardAnimate.type,
		duration: xoo_wsc_params.cardAnimate.duration,

		init: function(){

			var onEvent = xoo_wsc_params.cardAnimate.event === 'back_hover' ? 'mouseenter' : 'click';
		
			$('body').on( onEvent, '.xoo-wsc-has-back', this.animate );
			$('body').on( 'mouseleave', '.xoo-wsc-has-back', this.reverseAnimate );

		},
		animate: function(e){

			if( e.target.classList.contains('xoo-wsc-smr-del') ) return;

			var $img = $(this).find('.xoo-wsc-img-col');

			if( !$img.hasClass('xoo-wsc-caniming') ){
				e.preventDefault();
			}
			else{
				return;
			}

			$img.attr('data-exclasses', $img.attr('class') );

			$img.removeClass()
			$img.addClass($img.attr('data-exclasses'));

			$img.addClass( 'xoo-wsc-caniming' + ' ' + AnimateCard.type );

		},
		reverseAnimate: function(){

			var $img = $(this).find('.xoo-wsc-img-col');

			if( !$img.hasClass( 'xoo-wsc-caniming' ) ) return;

			$img.addClass(AnimateCard.type+'Return');

			AnimateCard.clear = setTimeout(function(){
				$img.removeClass().addClass( $img.attr('data-exclasses') );
			}, AnimateCard.duration * 1000);

		}
	}

	if( xoo_wsc_params.cardAnimate.enable === "yes" ){
		AnimateCard.init();
	}



	var Celebrate = {

		canvasIndex: 0,

		barPosition: false,

		myconfetti: '',

		Celebrate: async function( celebrationName ){
			if( Celebrate[ celebrationName ] ){
				await Celebrate.CreateCanvas();
				Celebrate[ celebrationName ]();
			}
		},

		CreateCanvas: async function(){

			if( $('.xoo-wsc-container').find('canvas').length ){
				$('.xoo-wsc-container').find('canvas').remove();
			}

			$('.xoo-wsc-container').append('<canvas id="xoo_canvas_'+Celebrate.canvasIndex+'"></canvas>').show();

			Celebrate.canvasIndex++;

			var canvas = $('.xoo-wsc-container canvas').get(0);

			Celebrate.myconfetti = await (confetti.create(canvas, { resize: true }) );
			
		},

		BarPosition: function(){
			if( !Celebrate.barPosition ){
				var windowHeight 	= $(window).height(),
				$bar 				= $('.xoo-wsc-bar'),
				barPosition 		= $bar.offset().top - $(window).scrollTop();

				Celebrate.barPosition = barPosition/windowHeight;
			}
			return Celebrate.barPosition;
			
		},

		Fireworks: function(){

			const duration = 3 * 1000,
			animationEnd = Date.now() + duration,
			defaults = { startVelocity: 30, spread: 100, ticks: 60, zIndex: 0 };

			function randomInRange(min, max) {
				return Math.random() * (max - min) + min;
			}

			const interval = setInterval(function() {
			const timeLeft = animationEnd - Date.now();

			if (timeLeft <= 0) {
				return clearInterval(interval);
			}

			const particleCount = 50 * (timeLeft / duration);

			// since particles fall down, start a bit higher than random
			Celebrate.myconfetti(
				Object.assign({}, defaults, {
					particleCount,
					origin: { x: randomInRange(0.1, 0.3), y: Celebrate.BarPosition() },
				})
			);
			Celebrate.myconfetti(
				Object.assign({}, defaults, {
					particleCount,
						origin: { x: randomInRange(0.7, 0.9), y: Celebrate.BarPosition() },
					})
				);
			}, 250);

		},

		Stars: function(){

			const defaults = {
				origin: { x: 0.5, y: Celebrate.BarPosition() },
				spread: 360,
				ticks: 50,
				gravity: 0,
				decay: 0.94,
				startVelocity: 30,
				shapes: ["star"],
				colors: ["FFE400", "FFBD00", "E89400", "FFCA6C", "FDFFB8"],
			};

			function shoot() {
				Celebrate.myconfetti({
					...defaults,
					particleCount: 40,
					scalar: 1,
					shapes: ["star"],
				});

				Celebrate.myconfetti({
					...defaults,
					particleCount: 10,
					scalar: 0.75,
					shapes: ["circle"],
				});
			}

			setTimeout(shoot, 0);
			setTimeout(shoot, 100);
			setTimeout(shoot, 200);
		},

		SchoolPride: function(){

			const end = Date.now() + 1.5 * 1000;

			// go Buckeyes!
			const colors = ["#bb0000", "#ffffff"];

			(function frame() {
				Celebrate.myconfetti({
					particleCount: 2,
					angle: 60,
					spread: 55,
					origin: { x: 0, y: Celebrate.BarPosition() },
					colors: colors,
				});

				Celebrate.myconfetti({
					particleCount: 2,
					angle: 120,
					spread: 55,
					origin: { x: 1, y: Celebrate.BarPosition() },
					colors: colors,
				});

				if (Date.now() < end) {
					requestAnimationFrame(frame);
				}
			})();
		},

		RealisticLook: function(){

			const count = 1000,

			defaults = {
				origin: { y: Celebrate.BarPosition() },
			};

			function fire(particleRatio, opts) {
				Celebrate.myconfetti(
					Object.assign({}, defaults, opts, {
						particleCount: Math.floor(count * particleRatio),
					})
				);
			}

			fire(0.25, {
				spread: 26,
				startVelocity: 55,
			});

			fire(0.2, {
				spread: 60,
			});

			fire(0.35, {
				spread: 100,
				decay: 0.91,
				scalar: 0.8,
			});

			fire(0.1, {
				spread: 120,
				startVelocity: 25,
				decay: 0.92,
				scalar: 1.2,
			});

			fire(0.1, {
				spread: 120,
				startVelocity: 45,
			});
		},

		BasicCannon: function(){
			Celebrate.myconfetti({
			  particleCount: 400,
			  spread: 70,
			  origin: { y: Celebrate.BarPosition() },
			});
		}

	}

})

