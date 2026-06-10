jQuery(document).ready(function($){

	var LicenseHandler = {

		init: function(){
			$('form.xoo-license-form').on( 'submit', LicenseHandler.registerLicenseFormSubmit );
			$('.xoo-el-lic-popup-toggle').on( 'click', LicenseHandler.openPopup );
			$('.xoo-lic-popup-close').on( 'click', LicenseHandler.closePopup );
			$('.xoo-toggle-license-form').on( 'click', LicenseHandler.toggleLicenseform )
			$('.xoo-lic-refresh-info').on( 'click', LicenseHandler.refreshLicenseInfo );
		},

		openPopup: function(e){
			e.preventDefault();
			var slug = $(this).attr('data-slug'),
				$popup = $('.xoo-license-popup[data-slug="'+slug+'"]');

			if( $popup.length ){
				$popup.toggleClass('xoo-license-popup-active');
			}
		},

		closePopup: function(){
			$('.xoo-license-popup').removeClass('xoo-license-popup-active');
		},

		registerLicenseFormSubmit: function(e){
			e.preventDefault();

			var $button 	= $(this).find('button[type="submit"]'),
				buttonText 	= $button.text(),
				$noticeCont = $(this).closest('.xoo-lic-cont').find('.xoo-lic-notices');

			$button.addClass('xoo-as-processing');

			$button.text('Please Wait....');

			$noticeCont.hide();

			var formData = $(this).serialize();
				formData += '&action=xoo_ff_license_register';

			$.ajax({
				url: xoo_license_params.adminurl,
				type: 'POST',
				data: formData,
				success: function(response){
					if( response.message ){
						$noticeCont.text(response.message);
						$noticeCont.show();
					}
					if( response.success ){
						$button.hide();
						setTimeout(function(){
							location.reload();
						}, 4000);
					}
				},
				complete: function(){
					$button.text(buttonText);
					$button.removeClass('xoo-as-processing');
				}
			});
		},

		refreshLicenseInfo: function(e){

			var $button = $(this);

			$button.addClass('xoo-as-processing');

			var data = {
				action: 'xoo_ff_license_refresh',
				slug: $button.closest('.xoo-lic-txt-cont').data('plugin_slug'),
				nonce: xoo_license_params.nonce
			}

			$.ajax({
				url: xoo_license_params.adminurl,
				type: 'POST',
				data: data,
				success: function(response){

					if( response.license_text ){
						$button.siblings('.xoo-lic-txt').replaceWith(response.license_text);
					}

					if( response.notice ){
						alert(response.notice);
					}

					if( response.reload ){
						location.reload();
					}
				},
				complete: function(){
					$button.removeClass('xoo-as-processing');
				}
			});
		},

		toggleLicenseform: function(e){
			var $licenseForm = $(this).closest('.xoo-lic-cont').find('.xoo-license-form-container');
			if( $licenseForm.is(':hidden') ){
				$licenseForm.show();
			}
			else{
				$licenseForm.hide();
			}
		}

	}

	LicenseHandler.init();
})
