declare var jQuery: any;
declare var toastr: any;

import './style.scss';

(function (w, d, $) {
  const { __ } = w.wp.i18n;

  // DOM ready
  $(function () {
    let isProcessing = false;

    // Load feeds for dropdown
    loadFeedsForDropdown();

    // Export/Import button click handler
    $('.adt-export-import-button').on('click', function (this: HTMLElement, e: any) {
      const button = $(this);
      const action = $(this).data('action');

      // Check if upsell should block this action (import when elite not active)
      if (action === 'import_feeds' && !w.adtObj.isEliteActive) {
        e.preventDefault();
        return;
      }

      if (isProcessing) {
        alert(__('Please wait for the current operation to complete.', 'woo-product-feed-pro'));
        return;
      }

      // Validation for selected feeds export
      if (action === 'export_selected_feeds') {
        const selectedFeedIds = $('#export_file').val() as string[];
        if (!selectedFeedIds || selectedFeedIds.length === 0) {
          alert(__('Please select at least one feed to export.', 'woo-product-feed-pro'));
          return;
        }
      }

      // Validation for imports
      if (action === 'import_feeds') {
        const fileInput = button.closest('td').find('input[type="file"]')[0] as HTMLInputElement;
        const file = fileInput?.files?.[0];

        if (!file) {
          alert(__('Please select a file to import.', 'woo-product-feed-pro'));
          return;
        }

        // Validate file type
        if (!file.name.toLowerCase().endsWith('.json')) {
          alert(__('Please select a valid JSON file.', 'woo-product-feed-pro'));
          return;
        }

        // Validate file size (10MB limit)
        const maxSize = 10 * 1024 * 1024; // 10MB
        if (file.size > maxSize) {
          alert(__('File too large. Maximum file size is 10MB.', 'woo-product-feed-pro'));
          return;
        }
      }

      isProcessing = true;

      // Find loader on the next of the button.
      const loader = $(this).next('.adt-loader');
      button.prop('disabled', true);
      loader.show();

      // Prepare data
      let requestData: any;
      let ajaxOptions: any = {
        url: w.ajaxurl,
        type: 'POST',
      };

      // Handle file uploads for imports
      if (action === 'import_feeds') {
        const fileInput = button.closest('td').find('input[type="file"]')[0] as HTMLInputElement;
        const overwriteCheckbox = button
          .closest('td')
          .find('input[name="overwrite_existing_feeds"]')[0] as HTMLInputElement;
        const formData = new FormData();

        formData.append('action', 'adt_export_import_tools');
        formData.append('action_type', action);
        formData.append('nonce', w.adtObj.exportImportNonce);
        formData.append('import_file', fileInput.files![0]);
        formData.append('overwrite_existing_feeds', overwriteCheckbox.checked ? '1' : '0');

        ajaxOptions.data = formData;
        ajaxOptions.processData = false;
        ajaxOptions.contentType = false;
      } else {
        // Regular form data for exports
        requestData = {
          action: 'adt_export_import_tools',
          action_type: action,
          nonce: w.adtObj.exportImportNonce,
        };

        // Add feed IDs for selected export
        if (action === 'export_selected_feeds') {
          const selectedFeedIds = $('#export_file').val() as string[];
          requestData.feed_ids = selectedFeedIds;
        }

        ajaxOptions.data = requestData;
      }

      // Send AJAX request
      $.ajax({
        ...ajaxOptions,
        success: function (response: any) {
          if (response.success && response.data?.action === 'download') {
            // Handle export download
            const blob = new Blob([response.data.data], { type: 'application/json' });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = response.data.filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);

            // Show success message
            toastr.success(response.data.message || __('Feeds exported successfully.', 'woo-product-feed-pro'));
          } else if (response.success) {
            // Handle import success or other operations
            const message = response.data?.message || __('Operation completed successfully.', 'woo-product-feed-pro');
            toastr.success(message);

            // Clear file input for imports
            if (action === 'import_feeds') {
              const fileInput = button.closest('td').find('input[type="file"]');
              fileInput.val('');
            }
          } else {
            // Handle errors from server
            const errorMessage = response.data?.message || __('Operation failed.', 'woo-product-feed-pro');
            toastr.error(errorMessage);
          }
        },
        error: function (xhr: any, status: string, error: any) {
          let errorMessage = __('Operation failed.', 'woo-product-feed-pro');

          // Try to get error message from response
          if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
            errorMessage = xhr.responseJSON.data.message;
          } else if (xhr.responseJSON && xhr.responseJSON.data && typeof xhr.responseJSON.data === 'string') {
            errorMessage = xhr.responseJSON.data;
          } else if (error) {
            errorMessage = error;
          }

          toastr.error(errorMessage);
        },
        complete: function () {
          isProcessing = false;
          button.prop('disabled', false);
          loader.hide();
        },
      });
    });

    /**
     * Initialize Select2 for feeds dropdown
     */
    function initializeSelect2() {
      const $select = $('#export_file');
      if ($select.length && typeof $select.select2 === 'function') {
        $select.select2({
          placeholder: __('Select Feeds', 'woo-product-feed-pro'),
          allowClear: true,
          width: '100%',
        });
      }
    }

    /**
     * Load feeds for dropdown
     */
    function loadFeedsForDropdown() {
      $.ajax({
        url: w.ajaxurl,
        type: 'POST',
        data: {
          action: 'adt_export_import_tools',
          action_type: 'get_feeds_for_dropdown',
          nonce: w.adtObj.exportImportNonce,
        },
        success: function (response: any) {
          if (response.success && response.data?.feeds) {
            const dropdown = $('#export_file');
            dropdown.empty();

            response.data.feeds.forEach(function (feed: any) {
              dropdown.append('<option value="' + feed.id + '">' + feed.title + ' (#' + feed.id + ')</option>');
            });

            // Initialize Select2 after loading data
            initializeSelect2();
          }
        },
        error: function (xhr: any, status: string, error: any) {
          console.warn('Failed to load feeds for dropdown:', error);
        },
      });
    }
  });
})(window, document, jQuery);
