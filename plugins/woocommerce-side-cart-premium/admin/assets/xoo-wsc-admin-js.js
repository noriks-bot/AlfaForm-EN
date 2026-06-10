jQuery(document).ready(function($){

	var isRTL = $('body.rtl').length;

	var AnimateCard = {

		type: function(){
			return SideCart.sy('scbp-card-anim-type');
		},

		duration: function(){
			return SideCart.sy('scbp-card-anim-time');
		},

		init: function(){

			var onEvent = SideCart.sy('scbp-card-visible') === 'back_hover' ? 'mouseenter' : 'click';

			$('.xoo-wsc-has-back').off();
		
			$('.xoo-wsc-has-back').on( onEvent, this.animate );
			$('.xoo-wsc-has-back').on( 'mouseleave', this.reverseAnimate );

			if( SideCart.sy('scb-playout') === 'cards' ){
				this.initMasonryLayout();
			}

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

			$img.addClass( 'xoo-wsc-caniming' + ' ' + AnimateCard.type() );

		},
		reverseAnimate: function(){

			var $img = $(this).find('.xoo-wsc-img-col');

			if( !$img.hasClass( 'xoo-wsc-caniming' ) ) return;

			$img.addClass( AnimateCard.type() + 'Return' );

			AnimateCard.clear = setTimeout(function(){
				$img.removeClass().addClass( $img.attr('data-exclasses') );
			}, AnimateCard.duration() * 1000 );

		},

		initMasonryLayout(){
			$('.xoo-wsc-products.xoo-wsc-pattern-card').masonry({
				// options
				itemSelector: '.xoo-wsc-product-cont',
				columnWidth: '.xoo-wsc-product-cont', /* Each column takes 50% */
				percentPosition: true
			});
		}
	}

	var Customizer = {

		$form: '',
		$styleTag: $('.xoo-as-preview-style'),
		previewTemplate: '',
		formValues: {},
		getPreviewCSS: function() {},
		getPreviewHTMLData: function() {},
		pageLoading: true,

		init: function(){
			this.initColorPicker();
			this.initSortable();
			this.initTemplates();
			this.events();
			this.build();
		},

		events: function(){
			$( Customizer.$form ).on('change', this.onFormChange );
		},

		initTemplates: function(){
			this.previewTemplate = wp.template('xoo-as-preview');
		},

		initColorPicker: function(){
			$('.xoo-as-color-input').wpColorPicker({
				change: function(event, ui){
					$(event.target).val(ui.color.toString()).trigger('change')
				}
			});
		},

		initSortable: function(){
			$('.xoo-as-sortable-list').sortable({
				update: function(){
					Customizer.build();
				}
			});
		},

		onFormChange: function(e){
			Customizer.build();
		},


		setFormValues: function(){
			//var values 		= this.$form.serializeArray();
			//this.formValues = this.objectifyForm(values);
			this.formValues = this.$form.serializeJSON();
		},

		build: function(){

			if( this.pageLoading ) return; // prevent multiple building event on page load due to 'change' event

			this.setFormValues();
			this.buildHTML();
			this.buildCSS();

			AnimateCard.init();

		},


		buildCSS: function(){

			var css = '';

			$.each( Customizer.getPreviewCSS(), function( selector, properties ){
				css += selector+'{';
				$.each( properties, function(property, value){
					css += property+': '+value+';';
				} );
				css += '}';
			} );

			css += SideCart.av('m-custom-css');

			Customizer.$styleTag.html('<style>'+css+'</style>')	
		},

		buildHTML: function(){
			$('.xoo-as-preview').html(Customizer.previewTemplate(Customizer.getPreviewHTMLData()));

		},

		objectifyForm(inp){

			var rObject = {};

			for (var i = 0; i < inp.length; i++){
				if(inp[i]['name'].substr(inp[i]['name'].length - 2) == "[]"){
					var tmp = inp[i]['name'].substr(0, inp[i]['name'].length-2);
					if(Array.isArray(rObject[tmp])){
						rObject[tmp].push(inp[i]['value']);
					} else{
						rObject[tmp] = [];
						rObject[tmp].push(inp[i]['value']);
					}
				} else{
					rObject[inp[i]['name']] = inp[i]['value'];
				}
			}
			return rObject;
		}
	}


	var SideCart = {

		settingsInPreview: ['xoo-wsc-gl-options[scb-show][]', 'xoo-wsc-gl-options[sch-show][]', 'xoo-wsc-gl-options[scf-show][]', 'xoo-wsc-sy-options[scf-button-pos][]'],
		previewSettingsRecorded: false,

		init: function(){
			this.initCustomizer();
			this.events();
			this.toggle('show');
		},


		initCustomizer: function(){
			Customizer.$form 		=  $('form.xoo-as-form');
			Customizer.getPreviewCSS = this.getPreviewCSS;
			Customizer.getPreviewHTMLData = this.getPreviewHTMLData;
			Customizer.init()
		},

		events: function(){
			$(document.body).on( 'click', '.xoo-wsc-basket', this.toggle );
			$(document.body).on( 'click', '.xoo-wsch-close', this.toggle );
		},

		sy: function( key, unit = '' ){
			var value = this.option( 'xoo-wsc-sy-options', key );
			return unit ? value + unit : value;
		},

		gl: function( key ){
			return this.option( 'xoo-wsc-gl-options', key );
		},

		av: function( key ){
			return this.option( 'xoo-wsc-av-options', key );
		},

		option: function( option, key ){
			if( !this.previewSettingsRecorded ){
				this.settingsInPreview.push( option+'['+key+']' )
			}
			return Customizer.formValues[option][key];
		},


		getPreviewCSS: function(){
			return SideCart.setPreviewCSS();
		},

		setPreviewCSS: function(){

			var basketPosition 	= this.sy('sck-count-pos'),
				openFrom 		= isRTL ? 'left' : 'right';

			var basket = {
				[this.sy('sck-position')]: 	this.sy('sck-offset','px'),	
				[openFrom]: 					this.sy('sck-hoffset', 'px'),									
				'background-color': 		this.sy('sck-basket-bg'),
				'color': 					this.sy('sck-basket-color'),
				'box-shadow': 				this.sy('sck-basket-sh'),
				'border-radius': 			this.sy('sck-shape') === 'round' ? '50%' : '14px',
				'width': 					this.sy('sck-bk-size','px'),
				'height':  					this.sy('sck-bk-size','px'),
			};

			var basketActive = {
				[openFrom]: this.sy('scm-width', 'px')
			}

			var basketIcon = {
				'font-size': this.sy('sck-size','px')
			}

			var basketCount = {
				'display': 	 		this.sy('sck-show-count') === 'yes' ? 'block' : 'none',
				'background-color': this.sy('sck-count-bg'),
				'color': 			this.sy('sck-count-color'),
				[basketPosition === 'top_right' || basketPosition === 'top_left' ? 'top' : 'bottom']: '-12px',
				[basketPosition === 'top_right' || basketPosition === 'bottom_right' ? 'right' : 'left']: '-12px'
			}

			var container = {
				'max-width': 				this.sy('scm-width','px'),
				'right': 					'-'+this.sy('scm-width','px'),
				'font-family': 				this.sy('scm-font'),
				[this.sy('sck-position')]: 	'0'
			}

			if( this.sy('scm-height') === 'full' ){
				container['top'] = '0';
				container['bottom'] = '0';
			}
			else{
				container['max-height'] = '100vh';
			}


			var header = {
				'background-color': this.sy('sch-bgcolor'),
				'color': 			this.sy('sch-txtcolor'),
				'border-bottom': 	this.sy('sch-border')
			}

			var headerTxt = {
				'font-size': this.sy('sch-head-fsize','px')
			}

			var body = {
				'background-color': this.sy('scb-bgcolor'),
			}

			var bodyText = {
				'font-size': 	this.sy('scb-fsize','px'),
				'color': 		this.sy('scb-txtcolor')
			}

			var footerBtn = {
				'padding': 				this.sy('scf-btn-padding'),
				'background-color': 	this.sy('scf-btn-bgcolor'),
				'color': 				this.sy('scf-btn-txtcolor'),
				'border': 				this.sy('scf-btn-border'),
			}

			var footerBtnHover = {
				'background-color': 	this.sy('scf-btnhv-bgcolor'),
				'color': 				this.sy('scf-btnhv-txtcolor'),
				'border': 				this.sy('scf-btnhv-border'),
			}

			var footer = {
				'padding': 				this.sy('scf-padding'),
				'background-color': 	this.sy('scf-bgcolor'),
				'color': 				this.sy('scf-txtcolor'),
				'box-shadow': 			this.sy('scf-shadow'),
			}

			var footerFSize = {
				'font-size': 			this.sy('scf-fsize', 'px'),
			}

			var product =  {
				'padding': 				this.sy('scbp-padding'),
				'background-color': 	this.sy('scbp-bgcolor'),
				'margin':  				this.sy('scbp-margin'),
				'border-radius': 		this.sy('scbp-bradius', 'px'),
				'box-shadow': 			this.sy('scbp-shadow'),
			}

			var productImgCol = {
				'width': this.sy('scbp-imgw', '%')
			}


			if( this.sy('scf-stick') !== 'yes' ){
				footer['flex-grow'] 	= 1;
				body['flex-grow'] 		= 0;
				body['overflow'] 		= 'unset';
				container['overflow'] 	= 'auto';
			}


			var cardStyle = {
				container: {
					'padding': 	this.sy('scbp-card-padding'),
				},
				image: {
					'max-width': this.sy('scbp-card-imgw', '%'),
					'height': this.sy('scbp-card-imgh', 'px')
				},
				productCont: {
					'width': 100/parseInt( this.sy('scbp-card-count') ) + '%',
				},
				product: {
					'border': this.sy('scbp-card-border'),
					'box-shadow': this.sy('scbp-card-shadow'),
				},



				front: {
					'background-color': this.sy('scbp-card-front-color')
				},
				cardAndFront: {
					'border-bottom-left-radius': this.sy('scbp-card-radius-btm', 'px'),
					'border-bottom-right-radius': this.sy('scbp-card-radius-btm', 'px')
				},
				imgAndImgCol: {
					'border-top-left-radius': this.sy('scbp-card-radius-top', 'px'),
					'border-top-right-radius': this.sy('scbp-card-radius-top', 'px'),
				},
				cardText: {
					'font-size': 	this.sy('scb-fsize','px'),
				},
				cardFront: {
					'color': 		this.sy('scbp-card-txtcolor'),
				},
				cardBack: {
					'color': 		this.sy('scbp-card-backtxt-color'),
				},
				back: {
					'background-color': this.sy('scbp-card-back-color')
				},
				animation: {
					'animation-duration': this.sy('scbp-card-anim-time', 's')
				}

			}

			if( parseInt(this.sy('scbp-card-imgw')) < 100 ){
				cardStyle.imageCol = {
					'background-color': this.sy('scbp-card-img-color')
				}
			}


			var cardSelectors = {
				'.xoo-wsc-product-cont': cardStyle.container,
				'.xoo-wsc-pattern-card .xoo-wsc-img-col img': cardStyle.image,
				'.xoo-wsc-pattern-card .xoo-wsc-product-cont': cardStyle.productCont,
				'.xoo-wsc-pattern-card .xoo-wsc-product': cardStyle.product,
				'.xoo-wsc-pattern-card .xoo-wsc-img-col': cardStyle.imageCol,
				'.xoo-wsc-sm-front, .xoo-wsc-card-actionbar > *': cardStyle.front,
				'.xoo-wsc-pattern-card, .xoo-wsc-sm-front': cardStyle.cardAndFront,
				'.xoo-wsc-pattern-card, .xoo-wsc-img-col img, .xoo-wsc-img-col, .xoo-wsc-sm-back-cont': cardStyle.imgAndImgCol,
				'.xoo-wsc-sm-back': cardStyle.back,
				'.xoo-wsc-pattern-card, .xoo-wsc-pattern-card a, .xoo-wsc-pattern-card .amount': cardStyle.cardText,
				'.xoo-wsc-body .xoo-wsc-sm-front, .xoo-wsc-body .xoo-wsc-sm-front a, .xoo-wsc-body .xoo-wsc-sm-front .amount, .xoo-wsc-card-actionbar': cardStyle.cardFront,
				'.xoo-wsc-sm-back, .xoo-wsc-sm-back a, .xoo-wsc-sm-back .amount': cardStyle.cardBack,
				'.magictime': cardStyle.animation
			}

			if( xoo_wsc_admin_params.isMobile === 'yes' && this.sy('scb-playout') === 'cards' && this.sy('scbp-card-visible') === 'back_hover' ){
				cardSelectors['.xoo-wsc-img-col a'] = {
					'pointer-events': 'none'
				}
			}


			var selectors = {
				'.xoo-wsc-basket': basket,
				'.xoo-wsc-cart-active .xoo-wsc-basket': basketActive,
				'.xoo-wsc-bki': basketIcon,
				'.xoo-wsc-items-count': basketCount,
				'.xoo-wsc-container,.xoo-wsc-slider': container,
				'.xoo-wsc-header': header,
				'.xoo-wsch-text': headerTxt,
				'.xoo-wsc-body': body,
				'.xoo-wsc-products:not(.xoo-wsc-pattern-card), .xoo-wsc-products:not(.xoo-wsc-pattern-card) span.amount, .xoo-wsc-products:not(.xoo-wsc-pattern-card) a': bodyText,
				'.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn, .xoo-wsc-container .xoo-wsc-btn': footerBtn,
				'.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn:hover, .xoo-wsc-container .xoo-wsc-btn:hover': footerBtnHover,
				'.xoo-wsc-footer': footer,
				'.xoo-wsc-footer, .xoo-wsc-footer a, .xoo-wsc-footer .amount': footerFSize,
				'.xoo-wsc-products:not(.xoo-wsc-pattern-card) .xoo-wsc-product': product,
				'.xoo-wsc-products:not(.xoo-wsc-pattern-card) .xoo-wsc-img-col': productImgCol,
				'.xoo-wsch-items-count, .xoo-wsch-save-count': {
					'background-color': this.sy('sck-count-bg'),
					'color': 			this.sy('sck-count-color')
				},
				'span.xoo-wsch-icon': {
					'font-size': this.sy('sch-close-fsize','px')
				}
			}

			var gridCols = 'auto';

			if( this.sy('scf-btns-row') === 'three' ){
				gridCols = '1fr 1fr 1fr';
			}
			else if( this.sy('scf-btns-row') === 'two_one' ){
				gridCols = '2fr 2fr';
				selectors['a.xoo-wsc-ft-btn:nth-child(3)'] = {
					'grid-column': '1/-1'
				}
			}
			else if( this.sy('scf-btns-row') === 'one_two' ){
				gridCols = '2fr 2fr';
				selectors['a.xoo-wsc-ft-btn:nth-child(1)'] = {
					'grid-column': '1/-1'
				}
			}
			

			selectors['.xoo-wsc-ft-buttons-cont'] = {
				'grid-template-columns': gridCols
			}


			if( this.sy('scbp-display') === 'stretched' ){
				selectors['.xoo-wsc-sm-info'] = {
					'flex-grow': '1',
    				'align-self': 'stretch'
				}
				selectors['.xoo-wsc-sm-left'] = {
					'justify-content': 'space-evenly'
				}
			}
			else{
				selectors['.xoo-wsc-sum-col'] = {
					'justify-content': this.sy('scbp-display')
				}
			}

			if( this.gl('m-tooltip') !== 'yes' ){
				selectors['.xoo-wsc-tooltip'] = {
					'display': 'none!important'
				}
			}


			var sideCartwidth = parseInt(this.sy('scm-width')) + 100;

			selectors['.xoo-wsc-cart-active .xoo-settings-container'] = {
				'width': 'calc( 100% - '+sideCartwidth+'px )'
			}

			/* Quantity */
			selectors['.xoo-wsc-qty-box'] = {
				'max-width': this.sy('scbq-width' ,'px')
			}

			selectors['.xoo-wsc-qty-box.xoo-wsc-qtb-square'] = {
				'border-color': this.sy('scbq-box-bcolor')
			}


			selectors['input[type="number"].xoo-wsc-qty'] = {
				'border-color': 		this.sy( 'scbq-input-bcolor' ),
				'background-color': 	this.sy( 'scbq-input-bgcolor' ),
				'color': 				this.sy( 'scbq-input-txtcolor' ),
				'height': 				this.sy( 'scbq-height','px' ),
				'line-height': 			this.sy( 'scbq-height','px' ),
			}

			selectors['input[type="number"].xoo-wsc-qty, .xoo-wsc-qtb-square'] = {
				'border-width': this.sy( 'scbq-bsize', 'px' ),
				'border-style': 'solid'
			}

			selectors['.xoo-wsc-chng'] = {
				'background-color': this.sy( 'scbq-box-bgcolor' ),
				'color': 			this.sy( 'scbq-box-txtcolor' ),
				'width': 			this.sy('scbq-btnsize' ,'px')
			}

			selectors['.xoo-wsc-qtb-circle .xoo-wsc-chng'] = {
				'height'		: this.sy('scbq-btnsize' ,'px'),
				'line-height'	: this.sy('scbq-btnsize' ,'px')
			}

			selectors['.xoo-wsc-body .xoo-wsc-ft-totals'] = {
				'padding': this.sy( 'scbp-padding' ),
				'margin': this.sy( 'scbp-margin' ),
			}

			selectors['.xoo-wsc-product dl.variation'] = {
				'display': this.sy('scbp-var-format') === 'one_line' ? 'flex' : 'block'
			}

			selectors = $.extend({}, selectors, cardSelectors);


			if( !this.previewSettingsRecorded ){
				$.each( this.settingsInPreview, function( index, name ){
					var $input = $('[name="'+name+'"]').closest('.xoo-as-setting');
					if( !$input.length ) return true;
					$input.addClass( 'xoo-as-has-preview' );
				} );
				this.previewSettingsRecorded = true;
			}
		
			return selectors;

		},

		getPreviewHTMLData: function(){
			return SideCart.setPreviewHTMLData();
		},

		setPreviewHTMLData: function(){

			var data = {
				openFrom: this.sy('scm-open-from'),
				basket: {
					show: 		this.sy('sck-enable') !== 'always_hide',
					icon: 		this.sy('sck-basket-icon'),
					countType: 	this.gl('m-bk-count')
				},
				totalsLocation: 				this.sy('scf-totals-loc'),
				header: {
					showBasketIcon: 			this.gl('sch-show').includes('basket'),
					showCloseIcon: 				this.gl('sch-show').includes('close'),
					showSaveLaterIcon: 			this.gl('sch-show').includes('save'),
					closeIcon: 					this.sy('sch-close-icon'),
					heading: 					this.gl('sct-cart-heading'),
					layout: 					this.sy('sch-layout'),

				},
				product: {
					layout: 				this.sy('scb-playout'),
					updateQty: 				false,
					showPImage: 			this.gl('scb-show').includes('product_image'),
					showPname: 				this.gl('scb-show').includes('product_name'),
					showPdel: 				this.gl('scb-show').includes('product_del'),
					showPtotal: 			this.gl('scb-show').includes('product_total'),
					showPmeta: 				this.gl('scb-show').includes('product_meta'),
					showPprice: 			this.gl('scb-show').includes('product_price'),
					showPqty: 				this.gl('scb-show').includes('product_qty'),
					qtyPriceDisplay: 		this.gl('scbp-qpdisplay'),
					deletePosition: 		this.sy('scbp-delpos'),
					deleteText: 			this.gl('sct-delete'),
					deleteType: 			this.sy('scbp-deltype'),
					deleteIcon:  			this.sy('scb-del-icon'),
					priceType:  			this.gl('scb-prod-price'),
					showSalesCount: 		this.gl('scb-show').includes('total_sales'),
					updateQty: 				this.gl('scb-update-qty') === "yes",
					qtyDesign: 				this.sy('scbq-style'),
				},
				card: {
					backShow: {
						name: 	this.sy('scbp-card-back').includes('name'),
						price: 	this.sy('scbp-card-back').includes('price'),
						qty: 	this.sy('scbp-card-back').includes('qty'),
						total: 	this.sy('scbp-card-back').includes('total'),
						meta: 	this.sy('scbp-card-back').includes('meta'),
						link: 	this.sy('scbp-card-back').includes('link'),
					},
					visibility: this.sy('scbp-card-visible'),
					hasBack: this.sy('scbp-card-visible') !== 'all_on_front' && (this.sy('scbp-card-back').length > 1)
				},
				footer: {
					totals: {
						subtotal: 	this.gl('scf-show').includes('subtotal'),
						shipping: 	this.gl('scf-show').includes('shipping'),
						total: 		this.gl('scf-show').includes('total')
					},
					subtotalLabel: 		this.gl('sct-subtotal'),
					footerTxt: 			this.gl('sct-footer'),
					checkoutTotal: 		this.gl('scf-chkbtntotal-en'),
					buttonsPosition: 	this.sy('scf-button-pos'),
					buttonsText: 		{
						cart: this.gl('sct-ft-cartbtn'),
						checkout: this.gl('sct-ft-chkbtn'),
						continue: this.gl('sct-ft-contbtn')
					}
				},
				saveForLater: {
					enabled: 	this.gl('sl-enable') === "yes",
					icon: 		this.sy('sl-icon'),
					heading: 	this.gl('sct-sl-txt'),
				}
			}

			data.product.oneLiner = data.product.qtyPriceDisplay === 'one_liner' && data.product.showPqty && data.product.showPprice && data.product.showPtotal && !data.product.updateQty;

			return data;
		},

		toggle: function( type ){

			var $activeEls 	= $('body'),
				activeClass = 'xoo-wsc-cart-active';

			if( type === 'show' ){
				$activeEls.addClass(activeClass);
			}
			else if( type === 'hide' ){
				$activeEls.removeClass(activeClass);
			}
			else{
				$activeEls.toggleClass(activeClass);
			}

		}
	}

	SideCart.init();


	function barToggleShipButton(){

		var hasFreeShipping = false,
			$button 		= $('button.xoo-scbchk-add.xoo-scbhk-add-ship');

		$('.xoo-scbhk-chkcont').each(function(index,el){
			if( $(el).find( '.xoo-scb-type select' ).val() === 'freeshipping' ){
				hasFreeShipping = true;
				return true;
			}
		})

		if( hasFreeShipping ){
			$button.hide();
		}
		else{
			$button.show();
		}
	}

	barToggleShipButton();

	$('.xoo-scb-type select, select[name="xoo-wsc-gl-options[scbar-total]"]').on( 'change', function(){

		var $totalType = $('select[name="xoo-wsc-gl-options[scbar-total]"]');

		$('.xoo-scb-type select').each(function(index,el){

			var $type 	= $(el),
				$notice = $type.closest('.xoo-scbhk-chkcont').find('.xoo-scbhk-disc-notice');

			if( $type.val() === 'discount' && $totalType.val() === 'total' ){
				$notice.show();
			}
			else{
				$notice.hide();
			}

		});

	} );


	$('button.xoo-scbchk-add').click( function(){
		var $cont = $('.xoo-bar-points-cont').append( $('.xoo-bar-points-cont .xoo-scbhk-chkcont:last-child').clone() );
		
		var $addedCheckpoint 	= $cont.find( '.xoo-scbhk-chkcont:last-child' ),
			$pointType 			= $addedCheckpoint.find('.xoo-scb-type select');

		$pointType.find('option').removeAttr('selected');	

		if( $(this).hasClass('xoo-scbhk-add-ship') ){
			$addedCheckpoint.addClass('xoo-scbhk-shipcont');
			$pointType.find('option[value="freeshipping"]').attr('selected', 'selected');
		}
		else{
			$addedCheckpoint.removeClass('xoo-scbhk-shipcont');
			$pointType.find('option:first-child').attr('selected', 'selected');
		}
		$pointType.trigger('change');
		barToggleShipButton();
	} );


	$('body').on( 'click', '.xoo-scbh-del', function(){
		$(this).closest('.xoo-scbhk-chkcont').remove();
		barToggleShipButton();
	} );


	var barInputNames = {}


	$('button.xoo-as-form-save').click( function(e){

		var $barSettingsCont 	= $('.xoo-bar-points-cont'),
			barSettingsHTML 	= $barSettingsCont.clone(),
			id 					= $barSettingsCont.data('idholder');

		$barSettingsCont.addClass('xoo-as-processing');

		$('.xoo-scbar-chkpoint').each( function(index, el){
			
			$(el).find('[name^="'+id+'"]').each( function(i, inel){

				var name 	= $(inel).attr('name'),
					newName = name.replace( '%$', index );

				barInputNames[newName] = name;

				$(inel).attr('name' , newName );

				if( name === id+'[id]' ){
					$(inel).val( 'id_'+index );
				}

			} );


		} );

	} );

	$(document).ajaxComplete(function(event,xhr,options){

		if( $(event.target.activeElement).hasClass('xoo-as-form-save') ){

			console.log(barInputNames);

			$.each( barInputNames, function( newName, oldName ){
				$('input[name="'+newName+'"]').attr('name', oldName);
			})

			barInputNames = {};

			$('.xoo-bar-points-cont').removeClass('xoo-as-processing');

		}
	});


	$('body').on( 'change', '.xoo-scb-type select', function(){

		var $giftField 		= $(this).closest('.xoo-scbar-chkpoint').find('.xoo-scbhk-gift'),
			$discountField 	= $(this).closest('.xoo-scbar-chkpoint').find('.xoo-scb-discount')

		if( $(this).val() === 'gift' ){
			$giftField.show();
		}
		else{
			$giftField.hide();
		}


		if( $(this).val() === 'discount' ){
			$discountField.show();
		}
		else{
			$discountField.hide();
		}

	} );

	$('.xoo-scb-type select').trigger('change');

	$('select[name="xoo-wsc-gl-options[m-ajax-atc]"]').on( 'change', function(){

		var $catSetting = $(this).closest('.xoo-as-setting').next();

		if( $(this).val() === 'cat_yes' || $(this).val() === 'cat_no' ){
			$catSetting.show();
		}
		else{
			$catSetting.hide();
		}
	} ).trigger('change');


	//Install login popup plugin
	$('.xoo-wsc-el-install').click(function(e){

		e.preventDefault();
		var $cont = $(this).closest('.xoo-wsc-el-links');
		$cont.html( 'Installing.. Please wait..' );

		$.ajax({
			url: xoo_wsc_admin_params.adminurl,
			type: 'POST',
			data: {
				action: 'xoo_wsc_el_install',
				xoo_wsc_nonce: xoo_wsc_admin_params.nonce
			},
			success: function( response ){

				if( response.firsttime_download ){
					$.post(xoo_wsc_admin_params.adminurl, {
						'action': 'xoo_wsc_el_request_just_to_init_save_settings'
					},function(result){
						if( response.notice ){
							$cont.html(response.notice)
						}
					})
				}
				else{
					if( response.notice ){
						$cont.html(response.notice)
					}
				}
				
			}
		})
	})



	//Hide/show product row and layout settings section
	$('select[name="xoo-wsc-sy-options[scb-playout]"]').on('change', function(){

		var $rowSection 	= $('.xoo-ass-style-scb_product'),
			$cardSection 	= $('.xoo-ass-style-scb_productcard'),
			$cardlink 		= $('a[href="#style_scb_productcard"]'),
			$rowlink 		= $('a[href="#style_scb_product"]');

		if( $(this).val() === 'rows' ){
			$rowSection.show();
			$cardSection.hide();
			$cardlink.hide();
			$rowlink.show();
		}
		else{
			$rowSection.hide();
			$cardSection.show();
			$rowlink.hide();
			$cardlink.show();
		}
	}).trigger('change');


	var $oneLinerSetting = $('select[name="xoo-wsc-gl-options[scbp-qpdisplay]"], select[name="xoo-wsc-sy-options[scbp-qpdisplay]"]').closest('.xoo-as-setting');

	//Hide product elements for card layout depending on the items enabled/disabled
	$('input[name="xoo-wsc-gl-options[scb-show][]"]').on( 'change', function(){

		var val 		= $(this).val(),
			isChecked 	= $(this).prop('checked');

		var $relatedEl = $('input[name="xoo-wsc-sy-options[scbp-card-back][]"][value="'+val.replace("product_", "")+'"]');
		if( $relatedEl ){
			if( isChecked ){
				$relatedEl.closest('label').show();
			}
			else{
				$relatedEl.closest('label').hide();
			}
		}


		var oneLinerEligibile = ['product_price','product_qty','product_total'];

		if( oneLinerEligibile.includes( val ) ){

			if( !isChecked ){
				$oneLinerSetting.hide();
			}
			else{
				var allValues = $("input[name='xoo-wsc-gl-options[scb-show][]']").map(function() {
				    return $(this).val();
				}).get();

				var failed = false;

				$.each( oneLinerEligibile, function( index, eligval ){
					if( !allValues.includes(eligval) ){
						failed = true;
						return false;
					}
				} )

				if( !failed ){
					$oneLinerSetting.show();
				}

			}
		}

		
	} ).trigger('change');


	//Disable one liner setting if quantity update is enabled.
	$('input[name="xoo-wsc-gl-options[scb-update-qty]"]').on('change', function(){
		if( $(this).prop('checked') ){
			$oneLinerSetting.hide();
		}
		else{
			$('input[name="xoo-wsc-gl-options[scb-show][]"]').trigger('change');
		}
	}).trigger('change');


	$('select[name="xoo-wsc-gl-options[scbp-qpdisplay]"]').on( 'change', function(){
		$('select[name="xoo-wsc-sy-options[scbp-qpdisplay]"]').val($(this).val());
	} );

	$('select[name="xoo-wsc-sy-options[scbp-qpdisplay]"]').on( 'change', function(){
		$('select[name="xoo-wsc-gl-options[scbp-qpdisplay]"]').val($(this).val());
	} );


	$('select[name="xoo-wsc-gl-options[scbp-qpdisplay]"], select[name="xoo-wsc-sy-options[scbp-qpdisplay]"]').on('change', function(){

		var $toggle = $('input[name="xoo-wsc-sy-options[scbp-card-back][]"][value="total"], input[name="xoo-wsc-sy-options[scbp-card-back][]"][value="price"]').closest('label');

		if( $(this).val() === 'one_liner' ){
			$toggle.hide();
		}
		else{
			$toggle.show();
		}
	}).trigger('change');


	$('select[name="xoo-wsc-sy-options[scbp-card-visible]"]').on('change', function(){

		var $toggle = $('input[name="xoo-wsc-sy-options[scbp-card-back][]"]').closest('.xoo-as-setting');

		if( $(this).val() === 'all_on_front' ){
			$toggle.hide();
		}
		else{
			$toggle.show();
		}
	})

	$('input[name="xoo-wsc-sy-options[scm-width]"]').on('change', function(){
		if( !$('body').hasClass('folded') && $('.xoo-settings-container').width() < 900 ){
			var $collapse = $('#collapse-button');
			if( $collapse.length ){
				$collapse.trigger('click');
			}
		}
	}).trigger('change');
	

	$('img.xoo-wsc-patimg').on('click', function(){

		$('img.xoo-wsc-patimg').removeClass('xoo-wsc-patactive');

		$(this).addClass('xoo-wsc-patactive')

		$('select[name="xoo-wsc-sy-options[scb-playout]"]').val( $(this).data('pattern') ).trigger('change');
		
	});


	$('img.xoo-wsc-patimg[data-pattern="'+$('select[name="xoo-wsc-sy-options[scb-playout]"]').val()+'"]').addClass('xoo-wsc-patactive');

	Customizer.pageLoading = false;
	Customizer.build();


	$('button.xoo-wsc-adpopup-go').on('click', function(){
		$('body').removeClass('xoo-wsc-adpopup-active');
		$('.xoo-wsc-admin-popup').remove();
		$('img.xoo-wsc-patimg[data-pattern="'+$('select[name="xoo-wsc-sy-options[scb-playout]"]').val()+'"]').addClass('xoo-wsc-patactive');
	});


	$('ul[id^="xooWscH-"]').sortable({
      connectWith: ".xooWscHconnectedSortable",
       axis: "x",
       update: function(event, ui) {

       	if( ui.sender ){

	       	var newName = ui.item.find('input').attr('name').replace(
	       		'['+ui.sender.data('name')+']',
	       		'['+ui.item.closest('ul').data('name')+']'
	       	);

	       	ui.item.find('input').attr('name',newName);
	    }

	    ui.item.find('input').trigger('change');

       }
    }).disableSelection();


})