/**
 * This file enables JavaScript related features shared by multiple menus. Specifically:
 *
 * - Sync between input elements of type range and number.
 * - Show and hide the various sections of forms.
 * - Show and hide the sub menu when the user hovers over the "admin-toolbar-menu-item-more" class.
 * - Allow to close the dismissible notice using the close button.
 * - Keep in sync the values of the item selectors with the hidden input field that is used to store the selected
 * items as a comma-separated list.
 *
 * @package hreflang-manager-lite
 */

jQuery( document ).ready(
	function ($) {

		'use strict';

		/**
		 * Handle the sync between input elements of type range and number.
		 *
		 * Steps:
		 * 1. Iterate over all the input elements of type range using jQuery.each()
		 *
		 * 2. Add a change event listener to each iterated elements used to update the
		 * input element of type number that has the same data-range-sync-id attribute value.
		 *
		 * 3. Get the element of type number that has the same data-range-sync-id attribute value.
		 *
		 * 4. Add a change event listener to the element of type number that updates the
		 * input element of type range that has the same data-range-sync-id attribute value.
		 */
		$( document ).ready(
			function () {
				$( "input[type='range']" ).each(
					function () {
						var range  = $( this );
						var number = $( "input[type='number'][data-range-sync-id='" + range.attr( "data-range-sync-id" ) + "']" );
						range.change(
							function () {
								number.val( range.val() );
							}
						);
						number.change(
							function () {
								range.val( number.val() );
							}
						);
					}
				);
			}
		);

		$( document.body ).on(
			'click',
			'.group-trigger' ,
			function () {

				'use strict';

				// Open and close the various sections of the tables area.
				const target = $( this ).attr( 'data-trigger-target' );
				$( '.daexthrmal-main-form__daext-form-section-body[data-section-id="' + target + '"]' ).toggleClass( 'daexthrmal-main-form__daext-form-section-body-opened' );

				$( this ).find( '.expand-icon' ).toggleClass( 'arrow-down' );
				$( this ).find( '.expand-icon' ).toggleClass( 'arrow-up' );

			}
		);

		/**
		 * When the "admin-toolbar-menu-item-more" class is hovered, then show the "pop-sub-menu" sub menu.
		 *
		 * When the user does not hover over the "admin-toolbar-menu-item-more" or "pop-sub-menu" class, then hide the
		 * "pop-sub-menu" sub menu.
		 */
		$( document.body ).on(
			'mouseenter',
			'.daexthrmal-admin-toolbar__menu-item-more',
			function () {
				$( '.daexthrmal-admin-toolbar__pop-sub-menu' ).show();
			}
		);

		$( document.body ).on(
			'mouseleave',
			'.daexthrmal-admin-toolbar__menu-item-more, .daexthrmal-admin-toolbar__pop-sub-menu',
			function () {
				$( '.daexthrmal-admin-toolbar__pop-sub-menu' ).hide();
			}
		);

		$( '.notice-dismiss-button' ).on(
			'click',
			function () {
				$( this ).parent().hide();
			}
		);

		/**
		 * Show the file name when the user selects a file using a custom file upload input.
		 *
		 * Ref:
		 *
		 * - https://stackoverflow.com/questions/572768/styling-an-input-type-file-button
		 * - https://stackoverflow.com/questions/2189615/how-to-get-file-name-when-user-select-a-file-via-input-type-file
		 */
		$( document ).on(
			'change',
			'.custom-file-upload-input',
			function () {
				var file     = $( this )[0].files[0];
				var fileName = file.name;
				$( this ).prev().text( fileName );

			}
		);

		/**
		 * Keep in sync the values of the item selectors with the hidden input field that is used to store the selected
		 * items as a comma-separated list.
		 */
		$( document ).on(
			'change',
			'.daexthrmal-bulk-action-checkbox',
			function () {
				let selectedItems = [];
				$( '.daexthrmal-bulk-action-checkbox:checked' ).each(
					function () {
						selectedItems.push( $( this ).val() );
					}
				);
				$( '#bulk-action-selected-items' ).val( selectedItems.join( ',' ) );
			}
		);

		$( document ).on(
			'change',
			'.daexthrmal-cb-select-all',
			function () {
				let selectedItems = [];

				// Update all the standard checkboxes according to the value of the changed select all checkbox.
				const cbSelectAllValue = $( this ).prop( 'checked' );

				// Update all the select all checkboxes according to the value of the changed select all checkbox.
				$( '.daexthrmal-cb-select-all' ).prop( 'checked', cbSelectAllValue );

				// Update the hidden input field that is used to store the selected items as a comma-separated list.
				$( '.daexthrmal-bulk-action-checkbox' ).each(
					function () {
						$( this ).prop( 'checked', cbSelectAllValue );
						if ( cbSelectAllValue ) {
							selectedItems.push( $( this ).val() );
						}
					}
				);
				$( '#bulk-action-selected-items' ).val( selectedItems.join( ',' ) );

			}
		);

	}
);
