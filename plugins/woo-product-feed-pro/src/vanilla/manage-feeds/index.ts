declare var jQuery: any;
declare var $: any;

import './style.scss';

(function (w, d, $) {
  const { __ } = w.wp.i18n;

  // DOM ready
  $(function () {
    // Initial check to make sure buttons are shown/hidden correctly (fixes any template issues)
    $('.adt-manage-feeds-table-row').each(function () {
      // @ts-ignore
      const $row = $(this);
      const isProcessing = $row.hasClass('processing');
      const $refreshButton = $row.find('.adt-manage-feeds-action-refresh');
      const $cancelButton = $row.find('.adt-manage-feeds-action-cancel');

      if (isProcessing) {
        // If processing, hide refresh and show cancel
        $refreshButton.addClass('hidden');
        $cancelButton.removeClass('hidden');
      } else {
        // Otherwise, show refresh and hide cancel
        $refreshButton.removeClass('hidden');
        $cancelButton.addClass('hidden');
      }
    });

    // Set bulk actions select as disabled by default
    $('.adt-manage-feeds-bulk-actions-select').prop('disabled', true);

    // Track refresh status
    let isRefreshRunning = false;
    let refreshXHR: JQuery.jqXHR | null = null;
    let refreshIntervalId: number | null = null;

    // Handle status text click to toggle active/inactive state
    $('.adt-manage-feeds-status-toggle').on('click', function () {
      // @ts-ignore
      const $statusText = $(this);
      const $row = $statusText.closest('.adt-manage-feeds-table-row');
      const feedId = $row.data('feed-id');
      const currentStatus = $statusText.data('current-status').toLowerCase();
      const $statusDot = $row.find('.adt-manage-feeds-table-row-status-dot');

      // Only process if it's ready or inactive (not processing)
      if (currentStatus === 'ready' || currentStatus === 'inactive') {
        // Determine the new state (toggle between active/inactive)
        const shouldActivate = currentStatus === 'inactive';

        // Show confirmation dialog
        const confirmMessage = shouldActivate
          ? __('Are you sure you want to activate this feed?', 'woo-product-feed-pro')
          : __('Are you sure you want to deactivate this feed?', 'woo-product-feed-pro');

        if (confirm(confirmMessage)) {
          // Call AJAX to update the feed status
          $.ajax({
            url: w.ajaxurl,
            type: 'POST',
            data: {
              action: shouldActivate ? 'adt_feed_action_activate' : 'adt_feed_action_deactivate',
              id: feedId,
              nonce: w.adtObj.adtNonce,
            },
            success: function (response: any) {
              if (response.success) {
                // Update UI
                const newStatus = shouldActivate ? 'ready' : 'inactive';
                const newStatusLabel = shouldActivate
                  ? __('Ready', 'woo-product-feed-pro')
                  : __('Inactive', 'woo-product-feed-pro');

                // Update status text and data attribute
                $statusText.text(newStatusLabel);
                $statusText.data('current-status', newStatus);
                $statusText.attr('data-current-status', newStatus);

                // Update row's post status data attribute
                $row.attr('data-post-status', shouldActivate ? 'publish' : 'draft');

                // Update status dot
                $statusDot.attr('data-status', newStatus);

                // If deactivating, need to hide refresh/cancel buttons
                if (!shouldActivate) {
                  $row.find('.adt-manage-feeds-table-row-actions-refresh-cancel').hide();
                } else {
                  $row.find('.adt-manage-feeds-table-row-actions-refresh-cancel').show();
                }
              } else {
                // Show error message
                alert(
                  __('Error: ', 'woo-product-feed-pro') +
                    (response.data?.message || __('An unknown error occurred.', 'woo-product-feed-pro'))
                );
              }
            },
            error: function () {
              // Show network error message
              alert(__('A network error occurred. Please try again.', 'woo-product-feed-pro'));
            },
          });
        }
      }
    });

    // Handle header checkbox (select all)
    $('.adt-manage-feeds-table-header-checkbox input').on('change', function () {
      // @ts-ignore
      const isChecked = $(this).prop('checked');

      // Check/uncheck all row checkboxes
      $('.adt-manage-feeds-table-row-checkbox input').prop('checked', isChecked);

      // Enable/disable bulk actions select based on the header checkbox
      $('.adt-manage-feeds-bulk-actions-select').prop('disabled', !isChecked);
    });

    // Handle individual row checkboxes
    $('.adt-manage-feeds-table-row-checkbox input').on('change', function () {
      // Check if any checkbox is selected
      const anyChecked = $('.adt-manage-feeds-table-row-checkbox input:checked').length > 0;

      // Enable/disable bulk actions select based on checkbox selection
      $('.adt-manage-feeds-bulk-actions-select').prop('disabled', !anyChecked);

      // Update header checkbox state
      updateHeaderCheckbox();
    });

    // Handle pagination dropdown change
    $('.adt-manage-feeds-pagination-show-select').on('change', function () {
      // @ts-ignore
      const selectedPerPage = $(this).val();
      // @ts-ignore
      const currentPageSize = $(this).data('current-page-size');

      // Only navigate if the selected value is different from current
      if (selectedPerPage !== currentPageSize) {
        // Construct base URL
        const baseUrl = new URL(window.location.href);

        // Update URL parameters
        baseUrl.searchParams.set('page_num', '1'); // Always go to page 1 when changing page size
        baseUrl.searchParams.set('per_page', selectedPerPage as string);

        // Navigate to the new URL
        window.location.href = baseUrl.toString();
      }
    });

    // Handle copy URL button clicks
    $('.adt-manage-feeds-table-row-url-copy-button').on('click', function () {
      // @ts-ignore
      // Get the input element in the parent container
      const urlInput = $(this).closest('.adt-manage-feeds-table-row-url').find('input');

      if (urlInput.length) {
        // Get the URL value
        const feedUrl = urlInput.val() as string;

        // Copy to clipboard
        // @ts-ignore
        copyToClipboard(feedUrl, $(this));
      }
    });

    // Handle feed duplicate button
    $('.adt-manage-feeds-action-duplicate').on('click', function (e: JQuery.ClickEvent) {
      e.preventDefault();

      // @ts-ignore
      // Get the feed ID from the closest table row
      const feedId = $(this).closest('.adt-manage-feeds-table-row').data('feed-id');

      if (feedId) {
        // Confirm before duplicating
        if (confirm(__('Are you sure you want to duplicate this feed?', 'woo-product-feed-pro'))) {
          // Call AJAX to duplicate the feed
          $.ajax({
            url: w.ajaxurl,
            type: 'POST',
            data: {
              action: 'adt_feed_action_clone',
              id: feedId,
              nonce: w.adtObj.adtNonce,
            },
            success: function (response: any) {
              if (response.success) {
                window.location.reload();
              } else {
                // Show error message
                alert(
                  __('Error: ', 'woo-product-feed-pro') +
                    (response.data.message || __('An unknown error occurred.', 'woo-product-feed-pro'))
                );
              }
            },
            error: function () {
              // Show network error message
              alert(__('A network error occurred. Please try again.', 'woo-product-feed-pro'));
            },
          });
        }
      }
    });

    // Handle feed refresh/cancel buttons
    $('.adt-manage-feeds-action-refresh, .adt-manage-feeds-action-cancel').on('click', function (e: JQuery.ClickEvent) {
      e.preventDefault();

      // @ts-ignore
      // Get the feed ID from the closest table row
      const $row = $(this).closest('.adt-manage-feeds-table-row');
      const feedId = $row.data('feed-id');
      const $statusElement = $row.find('.adt-manage-feeds-table-row-status-text');
      const $statusDot = $row.find('.adt-manage-feeds-table-row-status-dot');
      const $refreshButton = $row.find('.adt-manage-feeds-action-refresh');
      const $cancelButton = $row.find('.adt-manage-feeds-action-cancel');
      // @ts-ignore
      const isCancel = $(this).hasClass('adt-manage-feeds-action-cancel');

      if (feedId) {
        if (isCancel) {
          // Handle cancel action
          if (confirm(__('Are you sure you want to cancel processing the feed?', 'woo-product-feed-pro'))) {
            // Call AJAX to cancel the feed processing
            $.ajax({
              url: w.ajaxurl,
              type: 'POST',
              data: {
                action: 'adt_feed_action_cancel',
                id: feedId,
                nonce: w.adtObj.adtNonce,
              },
              success: function (response: any) {
                if (response.success) {
                  // Reset UI
                  $row.removeClass('processing');
                  $statusElement.text(__('Stopped', 'woo-product-feed-pro'));
                  $statusDot.attr('data-status', 'ready');

                  // Show refresh button, hide cancel
                  $refreshButton.removeClass('hidden');
                  $cancelButton.addClass('hidden');
                } else {
                  // Show error message
                  alert(
                    __('Error: ', 'woo-product-feed-pro') +
                      (response.data?.message || __('An unknown error occurred.', 'woo-product-feed-pro'))
                  );
                }
              },
              error: function () {
                // Show network error message
                alert(__('A network error occurred. Please try again.', 'woo-product-feed-pro'));
              },
            });
          }
        } else {
          // Handle refresh action
          if (confirm(__('Are you sure you want to refresh this feed now?', 'woo-product-feed-pro'))) {
            // Visual feedback - update status
            $row.addClass('processing');
            $statusElement.text(__('Processing', 'woo-product-feed-pro') + ' (0%)');
            $statusDot.attr('data-status', 'processing');

            // Force hide refresh button, show cancel button
            $refreshButton.addClass('hidden');
            $cancelButton.removeClass('hidden');

            // Call AJAX to refresh the feed
            $.ajax({
              url: w.ajaxurl,
              type: 'POST',
              data: {
                action: 'adt_feed_action_refresh',
                id: feedId,
                nonce: w.adtObj.adtNonce,
              },
              success: function (response: any) {
                if (response.success) {
                  console.log('Starting feed status polling for single feed refresh');
                  // Start polling for feed status updates - do this only after getting successful response
                  startFeedStatusPolling([feedId]);

                  // If the response contains data for direct feed generation via AJAX
                  if (response.data && response.data.executed_from === 'ajax') {
                    // Call the generate function with the returned parameters
                    generateProductFeedBatch(
                      response.data.feed_id,
                      response.data.offset || 0,
                      response.data.batch_size || 0
                    );
                  }
                } else {
                  // Show error message and reset status
                  alert(
                    __('Error: ', 'woo-product-feed-pro') +
                      (response.data?.message || __('An unknown error occurred.', 'woo-product-feed-pro'))
                  );
                  $row.removeClass('processing');
                  $statusElement.text(__('Ready', 'woo-product-feed-pro'));
                  $statusDot.attr('data-status', 'ready');

                  // Force show refresh button, hide cancel button
                  $refreshButton.removeClass('hidden');
                  $cancelButton.addClass('hidden');
                }
              },
              error: function () {
                // Show network error message and reset status
                alert(__('A network error occurred. Please try again.', 'woo-product-feed-pro'));
                $row.removeClass('processing');
                $statusElement.text(__('Ready', 'woo-product-feed-pro'));
                $statusDot.attr('data-status', 'ready');

                // Force show refresh button, hide cancel button
                $refreshButton.removeClass('hidden');
                $cancelButton.addClass('hidden');
              },
            });
          }
        }
      }
    });

    // Function to generate a product feed batch
    function generateProductFeedBatch(feedId: number, offset: number, batchSize: number) {
      console.log(`Generating batch for feed ${feedId}, offset: ${offset}, batch size: ${batchSize}`);

      // Make sure the row shows processing status before continuing
      const $row = $(`.adt-manage-feeds-table-row[data-feed-id="${feedId}"]`);
      if ($row.length) {
        const $statusElement = $row.find('.adt-manage-feeds-table-row-status-text');
        const $statusDot = $row.find('.adt-manage-feeds-table-row-status-dot');

        // Ensure processing state is visible
        $row.addClass('processing');
        if (!$statusElement.text().includes(__('Processing', 'woo-product-feed-pro'))) {
          $statusElement.text(__('Processing', 'woo-product-feed-pro') + ' (0%)');
        }
        $statusDot.attr('data-status', 'processing');
      }

      $.ajax({
        url: w.ajaxurl,
        type: 'POST',
        data: {
          action: 'adt_pfp_generate_product_feed',
          nonce: w.adtObj.adtNonce,
          feed_id: feedId,
          offset: offset,
          batch_size: batchSize,
        },
        success: function (response: any) {
          // If the feed is still processing, continue with the next batch
          if (response.success && response.data.status === 'processing') {
            // Make sure we're tracking the processing status without restarting polling
            if (!isRefreshRunning) {
              console.log('Starting feed status polling for batch processing');
              startFeedStatusPolling([feedId]);
            } else {
              console.log('Feed status polling already active, continuing with batch processing');
            }

            // Continue processing the next batch
            generateProductFeedBatch(response.data.feed_id, response.data.offset, response.data.batch_size);
          } else if (response.success) {
            console.log(`Feed ${feedId} batch processing completed`);
          }
        },
        error: function (xhr: any, status: any, error: any) {
          console.error(`Error generating feed batch: ${error}`);
        },
      });
    }

    // Function to start polling for feed status updates
    function startFeedStatusPolling(feedIds: number[]) {
      // Clear any existing poll
      stopFeedStatusPolling();

      // Set flag to indicate polling is active
      isRefreshRunning = true;

      // Start the polling interval - check immediately first
      checkFeedStatus(feedIds);

      const feedPollingInterval = w.adtObj.feedPollingInterval ?? 5000;

      // Then set up interval for continuous polling
      refreshIntervalId = window.setInterval(() => {
        if (isRefreshRunning) {
          // Instead of passing just the initial feed IDs, get all processing feeds on each check
          const allProcessingFeedIds = getProcessingFeedIds();
          if (allProcessingFeedIds.length > 0) {
            checkFeedStatus(allProcessingFeedIds);
          } else {
            // Only stop polling if we can't find any processing feeds
            console.log('No more processing feeds found, stopping poll');
            stopFeedStatusPolling();
          }
        } else {
          stopFeedStatusPolling();
        }
      }, feedPollingInterval);
    }

    // Function to get all currently processing feed IDs
    function getProcessingFeedIds(): number[] {
      const processingFeedIds: number[] = [];

      $('.adt-manage-feeds-table-row').each(function () {
        // @ts-ignore
        const $row = $(this);
        const feedId = $row.data('feed-id');

        // Check multiple indicators that a feed is in processing state:
        // 1. The row has the 'processing' class
        // 2. The status dot has 'processing' data-status
        // 3. The status text contains 'Processing'
        const hasProcessingClass = $row.hasClass('processing');
        const $statusDot = $row.find('.adt-manage-feeds-table-row-status-dot');
        const hasProcessingStatus = $statusDot.attr('data-status') === 'processing';
        const $statusText = $row.find('.adt-manage-feeds-table-row-status-text');
        const textIndicatesProcessing = $statusText.text().toLowerCase().includes('processing');

        // Use only reliable indicators of processing status
        if ((hasProcessingClass || hasProcessingStatus || textIndicatesProcessing) && feedId) {
          processingFeedIds.push(feedId);

          // Ensure the row has consistent visual state
          if (!hasProcessingClass) {
            $row.addClass('processing');
          }
          if (!hasProcessingStatus) {
            $statusDot.attr('data-status', 'processing');
          }

          // Make sure the UI buttons match the processing state
          const $refreshButton = $row.find('.adt-manage-feeds-action-refresh');
          const $cancelButton = $row.find('.adt-manage-feeds-action-cancel');

          if (!$refreshButton.hasClass('hidden')) {
            $refreshButton.addClass('hidden');
          }
          if ($cancelButton.hasClass('hidden')) {
            $cancelButton.removeClass('hidden');
          }
        }
      });

      console.log('Found processing feed IDs:', processingFeedIds);
      return processingFeedIds;
    }

    // Function to stop polling
    function stopFeedStatusPolling() {
      console.log('Stopping feed status polling');

      if (refreshIntervalId !== null) {
        console.log('Clearing interval ID:', refreshIntervalId);
        window.clearInterval(refreshIntervalId);
        refreshIntervalId = null;
      }

      if (refreshXHR !== null) {
        console.log('Aborting active XHR request');
        refreshXHR.abort();
        refreshXHR = null;
      }

      isRefreshRunning = false;
      console.log('Poll stopped, isRefreshRunning =', isRefreshRunning);
    }

    // Check feed processing status
    function checkFeedStatus(feedIds: number[]) {
      // Don't send a new request if one is already in progress
      if (refreshXHR !== null) {
        return;
      }

      // If no feed IDs to check, stop polling
      if (feedIds.length === 0) {
        stopFeedStatusPolling();
        return;
      }

      console.log('Checking status for feed IDs:', feedIds);

      refreshXHR = $.ajax({
        url: w.ajaxurl,
        type: 'POST',
        data: {
          action: 'adt_get_feed_processing_status',
          nonce: w.adtObj.adtNonce,
          feed_ids: feedIds,
        },
        success: function (response: any) {
          refreshXHR = null;

          if (response.success && response.data && response.data.length > 0) {
            let allComplete = true;

            response.data.forEach((feed: any) => {
              // Find the row for this feed
              const $row = $(`.adt-manage-feeds-table-row[data-feed-id="${feed.feed_id}"]`);
              if ($row.length) {
                const $statusElement = $row.find('.adt-manage-feeds-table-row-status-text');
                const $statusDot = $row.find('.adt-manage-feeds-table-row-status-dot');
                const $refreshButton = $row.find('.adt-manage-feeds-action-refresh');
                const $cancelButton = $row.find('.adt-manage-feeds-action-cancel');

                // Update Last Updated column
                const $lastUpdatedElement = $row.find('.adt-manage-feeds-table-row-last-updated div');
                if ($lastUpdatedElement.length) {
                  $lastUpdatedElement.text(feed.last_updated);
                }

                // Update Feed URL column
                const $feedUrlElement = $row.find('.adt-manage-feeds-table-row-url div');
                if ($feedUrlElement.length && feed.feed_url_html) {
                  $feedUrlElement.html(feed.feed_url_html);

                  // Reattach the copy URL event handler since we replaced the HTML
                  $feedUrlElement.find('.adt-manage-feeds-table-row-url-copy-button').on('click', function () {
                    // @ts-ignore
                    const urlInput = $(this).closest('.adt-manage-feeds-table-row-url').find('input');
                    if (urlInput.length) {
                      const feedUrl = urlInput.val() as string;
                      // @ts-ignore
                      copyToClipboard(feedUrl, $(this));
                    }
                  });
                }

                if (feed.status === 'processing' && feed.proc_perc < 100) {
                  // Feed is still processing
                  $row.addClass('processing');
                  $statusElement.text(__('Processing', 'woo-product-feed-pro') + ` (${feed.proc_perc}%)`);
                  $statusDot.attr('data-status', 'processing');

                  // Ensure refresh is hidden and cancel is shown
                  if (!$refreshButton.hasClass('hidden')) {
                    $refreshButton.addClass('hidden');
                  }
                  if ($cancelButton.hasClass('hidden')) {
                    $cancelButton.removeClass('hidden');
                  }

                  allComplete = false;
                  console.log(`Feed ${feed.feed_id} still processing at ${feed.proc_perc}%`);
                } else {
                  // Feed is complete or has another status
                  $row.removeClass('processing');
                  $statusElement.text(feed.status);
                  $statusDot.attr('data-status', feed.status.toLowerCase());

                  // Ensure refresh is shown and cancel is hidden
                  if ($refreshButton.hasClass('hidden')) {
                    $refreshButton.removeClass('hidden');
                  }
                  if (!$cancelButton.hasClass('hidden')) {
                    $cancelButton.addClass('hidden');
                  }

                  console.log(`Feed ${feed.feed_id} completed with status: ${feed.status}`);
                }
              }
            });

            // If all are complete, we still don't stop polling here
            // We'll let the interval check if any feeds are still in processing state
          } else {
            console.log('No valid data in response or empty response');
            // No valid data, but don't stop polling - let the interval handle that
          }
        },
        error: function (xhr: any, status: any, error: any) {
          refreshXHR = null;
          console.error('Error checking feed status:', error);
          // Don't stop polling on error, the interval will try again
        },
      });
    }

    // Check for any in-progress feeds on page load
    function checkForProcessingFeedsOnLoad() {
      // Get all rows with 'processing' status
      const processingFeedIds = getProcessingFeedIds();

      // If there are any processing feeds, start polling
      if (processingFeedIds.length > 0) {
        console.log('Found in-progress feeds on page load:', processingFeedIds);

        // Update the UI for processing feeds
        $('.adt-manage-feeds-table-row.processing').each(function (this: HTMLElement) {
          const $refreshButton = $(this).find('.adt-manage-feeds-action-refresh');
          const $cancelButton = $(this).find('.adt-manage-feeds-action-cancel');

          // Ensure refresh is hidden and cancel is shown
          if (!$refreshButton.hasClass('hidden')) {
            $refreshButton.addClass('hidden');
          }
          if ($cancelButton.hasClass('hidden')) {
            $cancelButton.removeClass('hidden');
          }
        });

        // Start polling first to ensure UI updates
        console.log('Starting initial feed status polling');
        startFeedStatusPolling(processingFeedIds);

        // Get detailed feed information for potential batch processing
        console.log('Checking for feeds that need batch processing');
        $.ajax({
          url: w.ajaxurl,
          type: 'POST',
          data: {
            action: 'adt_get_feed_processing_status',
            nonce: w.adtObj.adtNonce,
            feed_ids: processingFeedIds,
          },
          success: function (response: any) {
            if (response.success && response.data && response.data.length > 0) {
              response.data.forEach((feed: any) => {
                // If this feed was being generated via AJAX when the page was reloaded,
                // we need to restart the batch generation process
                if (feed.status === 'processing' && feed.executed_from === 'ajax') {
                  console.log(`Resuming batch generation for feed ID ${feed.feed_id}`);
                  generateProductFeedBatch(feed.feed_id, feed.offset, feed.batch_size);
                }
              });
            } else {
              console.log('No feeds need batch processing or no valid response data');
            }
          },
          error: function (xhr: any, status: any, error: any) {
            console.error('Error checking feed details:', error);
            // Continue polling even if this request fails
          },
        });
      } else {
        console.log('No in-progress feeds found on page load');
      }
    }

    // Run on page load to check for any in-progress feeds
    checkForProcessingFeedsOnLoad();

    // Handle feed delete button
    $('.adt-manage-feeds-action-delete').on('click', function (e: JQuery.ClickEvent) {
      e.preventDefault();

      // @ts-ignore
      // Get the feed ID from the closest table row
      const feedId = $(this).closest('.adt-manage-feeds-table-row').data('feed-id');

      if (feedId) {
        // Confirm before deleting
        if (
          confirm(
            __('Are you sure you want to delete this feed? This action cannot be undone.', 'woo-product-feed-pro')
          )
        ) {
          // Call AJAX to delete the feed
          $.ajax({
            url: w.ajaxurl,
            type: 'POST',
            data: {
              action: 'adt_feed_action_delete',
              id: feedId,
              nonce: w.adtObj.adtNonce,
            },
            success: function (response: any) {
              if (response.success) {
                window.location.reload();
              } else {
                // Show error message
                alert(
                  __('Error: ', 'woo-product-feed-pro') +
                    (response.data.message || __('An unknown error occurred.', 'woo-product-feed-pro'))
                );
              }
            },
            error: function () {
              // Show network error message
              alert(__('A network error occurred. Please try again.', 'woo-product-feed-pro'));
            },
          });
        }
      }
    });

    // Function to copy text to clipboard and show feedback
    function copyToClipboard(text: string, buttonElement: JQuery) {
      // Use modern Clipboard API with fallback to older method
      if (navigator.clipboard && window.isSecureContext) {
        // Modern approach with Clipboard API (works in secure contexts)
        navigator.clipboard
          .writeText(text)
          .then(() => {
            // Show success feedback
            showCopyFeedback(buttonElement);
          })
          .catch((err) => {
            console.error('Failed to copy text: ', err);
            // Fallback to the older method if clipboard API fails
            legacyCopyToClipboard(text, buttonElement);
          });
      } else {
        // Fallback for older browsers or non-secure contexts
        legacyCopyToClipboard(text, buttonElement);
      }
    }

    // Legacy copy method using execCommand (for older browsers)
    function legacyCopyToClipboard(text: string, buttonElement: JQuery) {
      try {
        // Create a temporary input element
        const tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);

        // Select the text
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text (deprecated but still works as fallback)
        const success = document.execCommand('copy');

        // Remove the temporary element
        document.body.removeChild(tempInput);

        if (success) {
          // Show success feedback
          showCopyFeedback(buttonElement);
        } else {
          console.error('Failed to copy text with execCommand');
        }
      } catch (err) {
        console.error('Failed to copy text with fallback method: ', err);
      }
    }

    // Show feedback to user that copying was successful
    function showCopyFeedback(buttonElement: JQuery) {
      // Provide visual feedback (change tooltip text temporarily)
      const tooltipContent = buttonElement.find('.adt-tooltip-content');
      const originalText = tooltipContent.text();

      // Change the tooltip text
      tooltipContent.text(__('Copied!', 'woo-product-feed-pro'));

      // Reset tooltip text after 2 seconds
      setTimeout(() => {
        tooltipContent.text(originalText);
      }, 2000);
    }

    // Handle bulk actions select change
    $('.adt-manage-feeds-bulk-actions-select').on('change', function () {
      // @ts-ignore
      const selectedAction = $(this).val();

      if (selectedAction) {
        // Count selected items
        const selectedCount = $('.adt-manage-feeds-table-row-checkbox input:checked').length;

        // Get confirmation based on selected action
        confirmBulkAction(selectedAction as string, selectedCount);

        // Reset the select after showing the confirmation dialog
        // @ts-ignore
        $(this).val('');
      }
    });

    // Function to display confirmation dialog for bulk actions using native JavaScript
    function confirmBulkAction(action: string, count: number) {
      // Configure message based on action type
      let message;

      // For cancel action, we need to count only processing feeds
      if (action === 'cancel') {
        // Get all selected feed IDs that are processing
        const processingFeedIds: number[] = [];
        $('.adt-manage-feeds-table-row-checkbox input:checked').each(function () {
          // @ts-ignore
          const $row = $(this).closest('.adt-manage-feeds-table-row');
          const feedId = $row.data('feed-id');
          const isProcessing =
            $row.hasClass('processing') ||
            $row.find('.adt-manage-feeds-table-row-status-dot').attr('data-status') === 'processing';

          if (feedId && isProcessing) {
            processingFeedIds.push(feedId);
          }
        });

        // Update count to only include processing feeds
        count = processingFeedIds.length;

        // If no processing feeds are selected, show a message and return
        if (count === 0) {
          alert(
            __(
              'No processing feeds selected. The cancel action only applies to feeds that are currently processing.',
              'woo-product-feed-pro'
            )
          );
          return;
        }

        message = __(`Are you sure you want to cancel processing ${count} feed(s)?`, 'woo-product-feed-pro');
      }
      // For refresh action, we need to count only active feeds
      else if (action === 'refresh') {
        // Get all selected feed IDs that are active
        const activeFeedIds: number[] = [];
        $('.adt-manage-feeds-table-row-checkbox input:checked').each(function () {
          // @ts-ignore
          const $row = $(this).closest('.adt-manage-feeds-table-row');
          const feedId = $row.data('feed-id');
          const isActive = $row.data('post-status') === 'publish';

          if (feedId && isActive) {
            activeFeedIds.push(feedId);
          }
        });

        // Update count to only include active feeds
        count = activeFeedIds.length;

        // If no active feeds are selected, show a message and return
        if (count === 0) {
          alert(
            __(
              'No active feeds selected. The refresh action only applies to feeds that are currently active.',
              'woo-product-feed-pro'
            )
          );
          return;
        }

        message = __(`Are you sure you want to refresh ${count} feed(s)?`, 'woo-product-feed-pro');
      } else {
        switch (action) {
          case 'activate':
            message = __(`Are you sure you want to activate ${count} feed(s)?`, 'woo-product-feed-pro');
            break;
          case 'deactivate':
            message = __(`Are you sure you want to deactivate ${count} feed(s)?`, 'woo-product-feed-pro');
            break;
          case 'duplicate':
            message = __(`Are you sure you want to duplicate ${count} feed(s)?`, 'woo-product-feed-pro');
            break;
          case 'delete':
            message = __(
              `Are you sure you want to delete ${count} feed(s)? This action cannot be undone.`,
              'woo-product-feed-pro'
            );
            break;
          default:
            return;
        }
      }

      // Use native JavaScript confirm dialog
      if (confirm(message)) {
        // Process the bulk action
        processBulkAction(action);
      }
    }

    // Function to process the bulk action after confirmation
    function processBulkAction(action: string) {
      // Get all selected feed IDs
      let selectedFeedIds: number[] = [];
      $('.adt-manage-feeds-table-row-checkbox input:checked').each(function () {
        // @ts-ignore
        // Get the feed ID from the data-feed-id attribute on the row
        const feedId = $(this).closest('.adt-manage-feeds-table-row').data('feed-id');
        if (feedId) {
          selectedFeedIds.push(feedId);
        }
      });

      // For cancel action, filter to only include processing feeds
      if (action === 'cancel') {
        selectedFeedIds = selectedFeedIds.filter((feedId) => {
          const $row = $(`.adt-manage-feeds-table-row[data-feed-id="${feedId}"]`);
          return (
            $row.hasClass('processing') ||
            $row.find('.adt-manage-feeds-table-row-status-dot').attr('data-status') === 'processing'
          );
        });

        // If no processing feeds are selected, show a message and return
        if (selectedFeedIds.length === 0) {
          alert(
            __(
              'No processing feeds selected. The cancel action only applies to feeds that are currently processing.',
              'woo-product-feed-pro'
            )
          );
          return;
        }
      }

      // For refresh action, filter to only include active feeds
      if (action === 'refresh') {
        selectedFeedIds = selectedFeedIds.filter((feedId) => {
          const $row = $(`.adt-manage-feeds-table-row[data-feed-id="${feedId}"]`);
          return $row.data('post-status') === 'publish';
        });

        // If no active feeds are selected, show a message and return
        if (selectedFeedIds.length === 0) {
          alert(
            __(
              'No active feeds selected. The refresh action only applies to feeds that are currently active.',
              'woo-product-feed-pro'
            )
          );
          return;
        }
      }

      // Process action via AJAX
      if (selectedFeedIds.length > 0) {
        console.log(`Processing ${action} for feed IDs:`, selectedFeedIds);

        // If refresh action, update UI before AJAX call
        if (action === 'refresh') {
          // Update UI for selected feeds to show processing state
          selectedFeedIds.forEach((feedId) => {
            const $row = $(`.adt-manage-feeds-table-row[data-feed-id="${feedId}"]`);
            const $statusElement = $row.find('.adt-manage-feeds-table-row-status-text');
            const $statusDot = $row.find('.adt-manage-feeds-table-row-status-dot');
            const $refreshButton = $row.find('.adt-manage-feeds-action-refresh');
            const $cancelButton = $row.find('.adt-manage-feeds-action-cancel');

            // Set processing state
            $row.addClass('processing');
            $statusElement.text(__('Processing', 'woo-product-feed-pro') + ' (0%)');
            $statusDot.attr('data-status', 'processing');

            // Hide refresh, show cancel
            $refreshButton.addClass('hidden');
            $cancelButton.removeClass('hidden');
          });

          // Don't start polling here - we'll start it after the AJAX response
          // This avoids the double polling issue
        }

        // If cancel action, update UI before AJAX call
        if (action === 'cancel') {
          // Pre-update UI to show cancellation is in progress
          selectedFeedIds.forEach((feedId) => {
            const $row = $(`.adt-manage-feeds-table-row[data-feed-id="${feedId}"]`);
            const $statusElement = $row.find('.adt-manage-feeds-table-row-status-text');

            // Show cancellation is in progress
            $statusElement.text(__('Cancelling...', 'woo-product-feed-pro'));
          });
        }

        // AJAX implementation
        $.ajax({
          url: w.ajaxurl, // WordPress global
          type: 'POST',
          data: {
            action: 'adt_process_bulk_feed_actions',
            feed_ids: selectedFeedIds,
            bulk_action: action,
            nonce: w.adtObj.adtNonce,
          },
          success: function (response: any) {
            if (response.success) {
              if (action === 'refresh') {
                // For refresh, we don't need to reload the page, status updates will be handled by polling
                // Always start polling regardless of response data structure
                console.log('Starting feed status polling for refresh action');
                startFeedStatusPolling(selectedFeedIds);

                // If the response contains data for direct feed generation via AJAX, start batch processing
                if (response.data && response.data.feeds && response.data.feeds.length > 0) {
                  console.log('Received feeds for processing:', response.data.feeds);

                  // Process each feed separately for batch generation
                  response.data.feeds.forEach((feed: any) => {
                    // The feed might be executed from ajax or cron
                    if (feed.executed_from === 'ajax') {
                      console.log(`Starting batch generation for feed ID ${feed.feed_id}`);
                      // Call the generate function with the returned parameters
                      generateProductFeedBatch(feed.feed_id, feed.offset || 0, feed.batch_size || 0);
                    } else {
                      console.log(`Feed ID ${feed.feed_id} will be processed via cron`);
                      // For cron feeds, we still want to poll for status updates
                      // but don't need to initiate batch processing
                    }
                  });
                } else {
                  console.warn('No feeds data returned in the response, continuing with status polling only');
                }
              } else if (action === 'cancel') {
                // For cancel, update the UI without page reload
                selectedFeedIds.forEach((feedId) => {
                  const $row = $(`.adt-manage-feeds-table-row[data-feed-id="${feedId}"]`);
                  const $statusElement = $row.find('.adt-manage-feeds-table-row-status-text');
                  const $statusDot = $row.find('.adt-manage-feeds-table-row-status-dot');
                  const $refreshButton = $row.find('.adt-manage-feeds-action-refresh');
                  const $cancelButton = $row.find('.adt-manage-feeds-action-cancel');

                  // Reset UI
                  $row.removeClass('processing');
                  $statusElement.text(__('Stopped', 'woo-product-feed-pro'));
                  $statusDot.attr('data-status', 'stopped');

                  // Show refresh, hide cancel
                  $refreshButton.removeClass('hidden');
                  $cancelButton.addClass('hidden');
                });

                // If polling is active, check if we need to stop it
                if (isRefreshRunning) {
                  // Get any feeds that might still be processing
                  const stillProcessingFeedIds = getProcessingFeedIds();

                  // If there are no more processing feeds, stop polling
                  if (stillProcessingFeedIds.length === 0) {
                    console.log('No more feeds are processing after cancel action, stopping poll');
                    stopFeedStatusPolling();
                  } else {
                    console.log(
                      `${stillProcessingFeedIds.length} feeds still processing after cancel action, continuing poll`
                    );
                  }
                }
              } else {
                // Use pagination data from response if available
                if (response.data && response.data.pagination) {
                  const baseUrl = new URL(window.location.href);
                  const pagination = response.data.pagination;

                  // Don't modify the 'page' parameter which is the WordPress admin page
                  // Only update the custom pagination parameters
                  baseUrl.searchParams.set('page_num', pagination.current_page.toString());
                  baseUrl.searchParams.set('per_page', pagination.per_page.toString());

                  // Navigate to the URL with correct pagination
                  window.location.href = baseUrl.toString();
                } else {
                  // Fallback to current URL if pagination info is missing
                  window.location.href = window.location.href;
                }
              }
            } else {
              // Show error message
              alert(
                __('Error: ', 'woo-product-feed-pro') +
                  (response.data?.message || __('An unknown error occurred.', 'woo-product-feed-pro'))
              );

              // Reset UI for refresh/cancel actions if they failed
              if (action === 'refresh' || action === 'cancel') {
                selectedFeedIds.forEach((feedId) => {
                  const $row = $(`.adt-manage-feeds-table-row[data-feed-id="${feedId}"]`);
                  const $statusElement = $row.find('.adt-manage-feeds-table-row-status-text');
                  const $statusDot = $row.find('.adt-manage-feeds-table-row-status-dot');
                  const $refreshButton = $row.find('.adt-manage-feeds-action-refresh');
                  const $cancelButton = $row.find('.adt-manage-feeds-action-cancel');

                  if (action === 'refresh') {
                    // Reset UI for refresh
                    $row.removeClass('processing');
                    $statusElement.text(__('Ready', 'woo-product-feed-pro'));
                    $statusDot.attr('data-status', 'ready');
                    $refreshButton.removeClass('hidden');
                    $cancelButton.addClass('hidden');
                  }
                });
              }
            }
          },
          error: function () {
            // Show network error message
            alert(__('A network error occurred. Please try again.', 'woo-product-feed-pro'));

            // Reset UI for refresh/cancel actions if they failed
            if (action === 'refresh' || action === 'cancel') {
              selectedFeedIds.forEach((feedId) => {
                const $row = $(`.adt-manage-feeds-table-row[data-feed-id="${feedId}"]`);
                const $statusElement = $row.find('.adt-manage-feeds-table-row-status-text');
                const $statusDot = $row.find('.adt-manage-feeds-table-row-status-dot');
                const $refreshButton = $row.find('.adt-manage-feeds-action-refresh');
                const $cancelButton = $row.find('.adt-manage-feeds-action-cancel');

                if (action === 'refresh') {
                  // Reset UI for refresh
                  $row.removeClass('processing');
                  $statusElement.text(__('Ready', 'woo-product-feed-pro'));
                  $statusDot.attr('data-status', 'ready');
                  $refreshButton.removeClass('hidden');
                  $cancelButton.addClass('hidden');
                }
              });
            }
          },
        });
      }
    }

    // Function to update header checkbox state
    function updateHeaderCheckbox() {
      const totalCheckboxes = $('.adt-manage-feeds-table-row-checkbox input').length;
      const checkedCheckboxes = $('.adt-manage-feeds-table-row-checkbox input:checked').length;

      // If all checkboxes are checked, check the header checkbox
      // If some but not all are checked, set indeterminate state
      // If none are checked, uncheck the header checkbox
      const headerCheckbox = $('.adt-manage-feeds-table-header-checkbox input');

      if (checkedCheckboxes === 0) {
        headerCheckbox.prop('checked', false);
        headerCheckbox.prop('indeterminate', false);
      } else if (checkedCheckboxes === totalCheckboxes) {
        headerCheckbox.prop('checked', true);
        headerCheckbox.prop('indeterminate', false);
      } else {
        headerCheckbox.prop('checked', false);
        headerCheckbox.prop('indeterminate', true);
      }
    }
  });
})(window, document, jQuery);
