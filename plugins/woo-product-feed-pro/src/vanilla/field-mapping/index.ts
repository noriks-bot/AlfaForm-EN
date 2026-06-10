declare var jQuery: any;

import './style.scss';

(function (w, d, $) {
  const { __, _x, sprintf } = w.wp.i18n;

  // DOM ready
  $(function () {
    // Dialog opener for information on mapping attributes
    // @ts-ignore - jQuery UI dialog
    $('#dialog').dialog({
      autoOpen: false,
      show: {
        effect: 'blind',
        duration: 1000,
      },
      hide: {
        effect: 'explode',
        duration: 1000,
      },
    });

    /**
     * Clone field mapping row from template and update placeholders
     * @param templateId - The template element ID
     * @param rowIndex - The row index to use
     * @returns DocumentFragment with the cloned row
     */
    const cloneFieldMappingRow = (templateId: string, rowIndex: number): DocumentFragment => {
      const template = document.getElementById(templateId) as HTMLTemplateElement;
      if (!template) {
        console.error(`Template ${templateId} not found`);
        // Return empty fragment if template not found
        return document.createDocumentFragment();
      }

      // Clone the template content
      const clone = template.content.cloneNode(true) as DocumentFragment;

      // Replace all {{ROW_INDEX}} placeholders in the cloned content
      const elements = clone.querySelectorAll('*');
      elements.forEach((element) => {
        // Replace in name attributes
        if (element.hasAttribute('name')) {
          const name = element.getAttribute('name') || '';
          element.setAttribute('name', name.replace(/\{\{ROW_INDEX\}\}/g, String(rowIndex)));
        }

        // Replace in value attributes
        if (element.hasAttribute('value')) {
          const value = element.getAttribute('value') || '';
          element.setAttribute('value', value.replace(/\{\{ROW_INDEX\}\}/g, String(rowIndex)));
        }

        // Replace in class attributes
        if (element.hasAttribute('class')) {
          const className = element.getAttribute('class') || '';
          element.setAttribute('class', className.replace(/\{\{ROW_INDEX\}\}/g, String(rowIndex)));
        }
      });

      return clone;
    };

    /**
     * Initialize select2 on newly added rows
     */
    const initializeSelect2 = (): void => {
      $(document.body).trigger('init_woosea_select2');
    };

    /**
     * Get the row count from the last row or return 0
     * @returns The current row count
     */
    const getCurrentRowCount = (): number => {
      const prevRow = $('tr.rowCount:last input[type=hidden]').val();
      return prevRow !== undefined ? Number(prevRow) : 0;
    };

    /**
     * Show error message
     * @param message - The error message to display
     */
    const showErrorMessage = (message: string): void => {
      console.log(__('Error: ', 'woo-product-feed-pro') + message);
    };

    /**
     * Add a mapping row to the table for field mappings
     */
    $('.add-field-mapping').on('click', function () {
      const prevRowCount = getCurrentRowCount();
      const addRowValue = $('#addrow').val() as number;

      const rowCount = Number(prevRowCount) + Number(addRowValue);
      const newRowValue = Number(addRowValue) + Number(1);
      $('#addrow').val(newRowValue);

      // Clone template and append instantly - no network request!
      const newRow = cloneFieldMappingRow('adt-field-mapping-row-template', rowCount);
      $('#woosea-fieldmapping-table tbody').append(newRow);

      // Initialize Select2 on new row
      initializeSelect2();
    });

    /**
     * Add a mapping row to the table for own mappings
     */
    $('.add-own-mapping').on('click', function () {
      const prevRowCount = getCurrentRowCount();
      const addRowValue = $('#addrow').val() as number;

      const rowCount = Number(prevRowCount) + Number(addRowValue);
      const newRowValue = Number(addRowValue) + Number(1);
      $('#addrow').val(newRowValue);

      // Clone template and append instantly - no network request!
      const newRow = cloneFieldMappingRow('adt-custom-field-mapping-row-template', rowCount);
      $('#woosea-fieldmapping-table tbody').append(newRow);

      // Initialize Select2 on new row
      initializeSelect2();
    });

    /**
     * Validate custom field input on save
     * @param input - The input value to validate
     * @returns boolean indicating if validation passed
     */
    const validateCustomFieldInput = (input: string): { valid: boolean; message?: string } => {
      // For Yandex, Zbozi and Heureka also accept Cyrillic characters
      const re = input.indexOf('PARAM_') >= 0 ? /.*/ : /^[a-zA-Zа-яА-Я_-]*$/;
      const minLength = 2;
      const maxLength = 50;

      // Check for allowed characters
      if (!re.test(input)) {
        return {
          valid: false,
          message: __(
            'Sorry, when creating new custom fields only letters are allowed (so no white spaces, numbers or any other character are allowed).',
            'woo-product-feed-pro'
          ),
        };
      }

      // Check for length of fieldname
      if (input.length < minLength) {
        return {
          valid: false,
          message: sprintf(
            /* translators: %d: minimum length required */
            __('Sorry, your custom field name needs to be at least %d letters long.', 'woo-product-feed-pro'),
            minLength
          ),
        };
      }

      if (input.length > maxLength) {
        return {
          valid: false,
          message: sprintf(
            /* translators: %d: maximum length allowed */
            __('Sorry, your custom field name cannot be over %d letters long.', 'woo-product-feed-pro'),
            maxLength
          ),
        };
      }

      return { valid: true };
    };

    /**
     * Display validation error notice
     * @param message - The error message to display
     */
    const displayValidationError = (message: string): void => {
      $('.notice').replaceWith(`<div class='notice notice-error is-dismissible'><p>${message}</p></div>`);
    };

    /**
     * Handle save button click with validation
     */
    $('#savebutton').on('click', function (this: HTMLElement) {
      let allValid = true;
      let errorMessage = '';

      $('#own-input-field').each(function (this: HTMLElement) {
        const input = $(this).val() as string;
        const validation = validateCustomFieldInput(input);

        if (!validation.valid) {
          allValid = false;
          errorMessage = validation.message || '';
          return false; // Break the loop
        }
      });

      if (!allValid) {
        $('form').submit(function (e: any) {
          e.preventDefault();
          return false;
        });
        displayValidationError(errorMessage);
      } else {
        const formElement = $('#fieldmapping')[0] as HTMLFormElement;
        formElement.submit();
      }
    });

    /**
     * Handle select field changes for static values, page URLs, and post URLs (using event delegation for dynamic rows)
     * Simply show/hide the appropriate field - no AJAX needed!
     */
    $(document).on('change', '.select-field', function (this: HTMLElement) {
      const $this = $(this);
      const $wrapper = $this.closest('.adt-field-mapping-select-field-wrapper');

      // Get all wrapper elements
      const $staticWrapper = $wrapper.find('.adt-static-value-wrapper');
      const $pageUrlWrapper = $wrapper.find('.adt-page-url-attribute-wrapper');
      const $postUrlWrapper = $wrapper.find('.adt-post-url-attribute-wrapper');

      // Get all input elements
      const $staticInput = $staticWrapper.find('input[type="text"]');
      const $staticHiddenInput = $staticWrapper.find('input[type="hidden"]');
      const $pageUrlSelect = $pageUrlWrapper.find('.adt-page-url-select');
      const $pageUrlHiddenInput = $pageUrlWrapper.find('input[type="hidden"]');
      const $postUrlSelect = $postUrlWrapper.find('.adt-post-url-select');
      const $postUrlHiddenInput = $postUrlWrapper.find('input[type="hidden"]');

      // Hide all wrappers and disable all inputs by default
      $staticWrapper.hide();
      $staticInput.prop('disabled', true).val('');
      $staticHiddenInput.prop('disabled', true).val('false');

      $pageUrlWrapper.hide();
      $pageUrlSelect.prop('disabled', true).val('');
      $pageUrlHiddenInput.prop('disabled', true).val('false');

      $postUrlWrapper.hide();
      $postUrlSelect.prop('disabled', true).val('');
      $postUrlHiddenInput.prop('disabled', true).val('false');

      // Show and enable the appropriate wrapper based on selection
      switch ($this.val()) {
        case 'static_value':
          $staticWrapper.show();
          $staticInput.prop('disabled', false);
          $staticHiddenInput.val('true');
          $staticHiddenInput.prop('disabled', false);
          $staticInput.focus();
          break;
        case 'page_url':
          $pageUrlWrapper.show();
          $pageUrlSelect.prop('disabled', false);
          $pageUrlHiddenInput.val('true');
          $pageUrlHiddenInput.prop('disabled', false);
          // Reinitialize Select2 for the page select
          initializeSelect2();
          break;
        case 'post_url':
          $postUrlWrapper.show();
          $postUrlSelect.prop('disabled', false);
          $postUrlHiddenInput.val('true');
          $postUrlHiddenInput.prop('disabled', false);
          // Reinitialize Select2 for the post select
          initializeSelect2();
          break;
        default:
          // All wrappers are already hidden and disabled
          break;
      }
    });

    /**
     * Delete selected field mapping rows
     */
    $('.delete-field-mapping').on('click', function (this: HTMLElement) {
      if (confirm(__('Are you sure you want to delete the selected field mappings?', 'woo-product-feed-pro'))) {
        $('table tbody')
          .find('input[name="record"]')
          .each(function (this: HTMLElement) {
            if ($(this).is(':checked')) {
              $(this).parents('tr').remove();
            }
          });
      }
    });
  });
})(window, document, jQuery);
