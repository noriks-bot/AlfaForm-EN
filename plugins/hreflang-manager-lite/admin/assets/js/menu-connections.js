/**
 * This file is used to initialize Select2 in the Categories menu.
 *
 * @package hreflang-manager-lite
 */

(function ($) {

	'use strict';

	$( document ).ready(
		function () {

			'use strict';

			initSelect2();

		}
	);

	/**
	 * Initialize the select2 fields.
	 */
	function initSelect2() {

		'use strict';

		let options = {
			placeholder: window.objectL10n.chooseAnOptionText,
		};

		for (let i = 1; i <= 100; i++) {
			$( '#language' + i ).select2();
			$( '#script' + i ).select2();
			$( '#locale' + i ).select2();
		}

	}

}(window.jQuery));
