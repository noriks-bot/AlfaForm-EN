(function( $ ) {
	'use strict';

	$(document).ready(function() {

		if($('.standalone_admin_grid').length) {

			$('.standalone_admin_grid .form-table input').each(function() {

				$(this).on("input", function() {
					var id = $(this).attr('id');
					var text = $(this).val();
					
					if($('.standalone-utm-preview span[data-param="'+id+'"]').length) {
						$('.standalone-utm-preview span[data-param="'+id+'"]').text(text);
					}

				});

			});

		}

		if($('body #_associated_sku').length) {
			$('body #_associated_sku').select2();
		}

	});

})( jQuery );
