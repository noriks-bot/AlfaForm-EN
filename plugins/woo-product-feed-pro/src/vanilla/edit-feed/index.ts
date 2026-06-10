// Declare jQuery variables
declare var jQuery: any;
declare var $: any;

import './style.scss';

(function (w, d, $) {
  const { __, _x, sprintf } = w.wp.i18n;

  // DOM ready
  $(function () {
    const feedId = w.adtObj.feed_id;
    let feedData = w.adtObj.feed_data;
    let feedStatus = feedData?.status || '';
    let heartbeatInterval: NodeJS.Timeout;

    // Function to get the current tab from URL or form
    const getCurrentTab = (): string => {
      const currentParams = new URLSearchParams(window.location.search);
      return currentParams.get('tab') || 'general';
    };

    // Function to show WordPress style admin notices
    const showAdminNotice = (
      message: string,
      type: 'error' | 'info' | 'warning' | 'success',
      id: string = '',
      loading: boolean = false
    ): void => {
      // Remove any existing notice with our specific class
      $('.woosea-admin-notice').remove();

      const loadingHtml = loading
        ? '<span class="adt-loader adt-loader-secondary adt-loader-sm adt-tw-inline-block"></span>'
        : '';

      // Create a new notice with WordPress standard classes
      const noticeClass = `notice notice-${type} is-dismissible woosea-admin-notice`;
      const noticeHtml = `
        <div class="${noticeClass}" id="${id}">
          <p style="display: flex; align-items: center; gap: 8px;">${loadingHtml}${message}</p>
          <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">${__('Dismiss this notice.', 'woo-product-feed-pro')}</span>
          </button>
        </div>
      `;

      // Insert the notice at the top of the form
      $('#adt-edit-feed .tab-content').prepend(noticeHtml);

      // Make the dismiss button work
      $('.woosea-admin-notice .notice-dismiss').on('click', function () {
        // @ts-ignore
        $(this)
          .closest('.woosea-admin-notice')
          .fadeOut(300, function () {
            // @ts-ignore
            $(this).remove();
          });
      });
    };

    // Function to check if we're on the create new feed page (no feed ID in URL)
    const isCreateNewFeedPage = (): boolean => {
      return !new URLSearchParams(window.location.search).has('id');
    };

    // Function to validate project name without showing notices
    const validateProjectName = (showNotices: boolean = false): boolean => {
      // Only validate if project name field exists (only on General tab)
      if (!$('#projectname').length) {
        return true; // Skip validation if field doesn't exist
      }

      const input = $('#projectname');
      const inputValue = input.val();
      // Handle potential undefined value
      const value = typeof inputValue === 'string' ? inputValue : '';
      const re = /^[a-zA-Z0-9-_.àèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ ]*$/;
      const minLength = 3;
      const maxLength = 30;
      const is_projectname = re.test(value);

      // Check for allowed characters
      if (!is_projectname) {
        if (showNotices) {
          showAdminNotice(
            __(
              'Sorry, only letters, numbers, whitespaces, -, . and _ are allowed for the projectname',
              'woo-product-feed-pro'
            ),
            'error'
          );
        }
        return false;
      } else {
        // Check for length of projectname
        if (value.length < minLength) {
          if (showNotices) {
            showAdminNotice(
              sprintf(
                /* translators: %d: minimum length of project name */
                __('Sorry, your project name needs to be at least %d characters long.', 'woo-product-feed-pro'),
                minLength
              ),
              'error'
            );
          }
          return false;
        } else if (value.length > maxLength) {
          if (showNotices) {
            showAdminNotice(
              sprintf(
                /* translators: %d: maximum length of project name */
                __('Sorry, your project name cannot be over %d characters long.', 'woo-product-feed-pro'),
                maxLength
              ),
              'error'
            );
          }
          return false;
        } else {
          // Valid project name
          return true;
        }
      }
    };

    // Function to check if required fields are filled in for new feed creation
    const validateRequiredFields = (): boolean => {
      const currentTab = getCurrentTab();

      // Only perform this validation on the final tab for new feeds
      if (isCreateNewFeedPage() && currentTab === 'conversion_analytics') {
        // Get temporary feed data via AJAX
        let allFieldsValid = true;
        let errorMessages: string[] = [];

        // Make an AJAX call to check other required fields that might be stored in the temp data
        $.ajax({
          url: w.ajaxurl,
          type: 'POST',
          async: false, // Make this synchronous so we get the result immediately
          data: {
            action: 'check_temp_feed_required_fields',
            nonce: w.adtObj.adtNonce,
          },
          success: function (response: any) {
            if (response.success === false) {
              allFieldsValid = false;

              // Add server-side validation errors to our list
              if (response.data && response.data.errors && Array.isArray(response.data.errors)) {
                response.data.errors.forEach((error: string) => {
                  errorMessages.push(error);
                });
              }
            }
          },
          error: function () {
            allFieldsValid = false;
            errorMessages.push(__('Could not validate feed configuration. Please try again.', 'woo-product-feed-pro'));
          },
        });

        // Show error messages if validation failed
        if (!allFieldsValid) {
          showAdminNotice(errorMessages.join('<br>'), 'error');
        }

        return allFieldsValid;
      }

      // For other tabs or existing feeds, return true
      return true;
    };

    /**
     * Run heartbeat to check if the feed is processing.
     * @returns void
     */
    const heartbeat = () => {
      if (!heartbeatInterval) {
        // Start heartbeat.
        heartbeatInterval = setInterval(() => {
          checkFeedStatus(feedId);
        }, 10000);
      }
    };

    /**
     * Check the status of the feed.
     * @returns void
     */
    const checkFeedStatus = (feedId: number) => {
      const feedIds = [feedId];

      $.ajax({
        url: w.ajaxurl,
        type: 'POST',
        data: {
          action: 'adt_get_feed_processing_status',
          nonce: w.adtObj.adtNonce,
          feed_ids: feedIds,
        },
      }).done((response: any) => {
        if (response.success) {
          // Find the data array in the response that has the same feed ID.
          const feedDataObj = Array.isArray(response.data)
            ? response.data.find((data: any) => String(data.feed_id) === String(feedId))
            : null;
          feedStatus = feedDataObj?.status || '';

          updateFeedProcessingNotice();
          updateContainerStatus();
          updateFormSubmitButton();
        }
      });
    };

    /**
     * Disable the form submit button.
     * @returns void
     */
    const updateFormSubmitButton = (): void => {
      const status = feedStatus === 'processing' ? 'disabled' : 'enabled';

      // Check if there is an input or button with type="submit".
      const $form = $('.adt-edit-feed-form');
      $form.find('button[type="submit"]').prop('disabled', status === 'disabled');
    };

    /**
     * Update the container status.
     * @returns void
     */
    const updateContainerStatus = (): void => {
      const $container = $('#adt-edit-feed');
      $container.attr('data-status', feedStatus);
    };

    /**
     * Show or hide a notice if the feed is processing.
     * @returns void
     */
    const updateFeedProcessingNotice = (): void => {
      if (feedStatus === 'processing') {
        showAdminNotice(
          __(
            'Feed is currently processing. Please wait for the feed generation to complete before making changes.',
            'woo-product-feed-pro'
          ),
          'error',
          'feed-processing-notice',
          true
        );
      } else {
        $('.woosea-admin-notice#feed-processing-notice').remove();
      }
    };

    /**
     * Check the status of the feed on load.
     * @returns void
     */
    const checkFeedStatusOnLoad = () => {
      if (!isCreateNewFeedPage()) {
        heartbeat();
        updateFeedProcessingNotice();
        updateFormSubmitButton();
      }
    };

    // Check the status of the feed on load.
    checkFeedStatusOnLoad();

    // Handle form submission
    // @ts-ignore
    $('.adt-edit-feed-form').on('submit', function (e) {
      const currentTab = getCurrentTab();

      // Validate based on current tab
      if (currentTab === 'general') {
        // On General tab, validate project name
        const isValid = validateProjectName(true);
        if (!isValid) {
          e.preventDefault();
          return false;
        }
      } else if (currentTab === 'conversion_analytics' && isCreateNewFeedPage()) {
        // On final tab for new feeds, validate all required fields
        if (!validateRequiredFields()) {
          e.preventDefault();
          // Scroll to the top to show the error message
          window.scrollTo(0, 0);
          return false;
        }
      }

      // Check rule value if it exists (for filters & rules tab)
      if ($('#rulevalue').length) {
        const ruleValue = $('#rulevalue').val();
        const value = typeof ruleValue === 'string' ? ruleValue : '';
        const minLength = 1;
        const maxLength = 200;

        if (value.length < minLength) {
          showAdminNotice(__('Sorry, rule value minimum length is 1 character', 'woo-product-feed-pro'), 'error');
          e.preventDefault();
          return false;
        } else if (value.length > maxLength) {
          showAdminNotice(
            sprintf(
              /* translators: %d: maximum length of rule value */
              __('Sorry, rule value cannot be over %d characters long.', 'woo-product-feed-pro'),
              maxLength
            ),
            'error'
          );
          e.preventDefault();
          return false;
        }
      }

      // Let form submit normally if validation passes
      return true;
    });

    // Function to check if the target URL is navigating to another tab within the same edit feed page
    const isNavigatingToSameEditPage = (targetUrl: string): boolean => {
      // If there's no URL, we can't determine, so return false
      if (!targetUrl) return false;

      // If it's not an HTTP URL (e.g., javascript:void(0)), it's not navigating away
      if (!targetUrl.startsWith('http')) return false;

      try {
        const currentUrl = new URL(window.location.href);
        const destination = new URL(targetUrl);

        // Check if we're staying on the edit feed page
        const currentPageParam = currentUrl.searchParams.get('page');
        const destPageParam = destination.searchParams.get('page');

        // If we're navigating to the same edit feed page, don't show warning
        return destPageParam === 'adt-edit-feed';
      } catch (e) {
        // If parsing fails, assume we're navigating away
        return false;
      }
    };

    // Variable to track if we're submitting the form
    let isSubmittingForm = false;

    // Only add the beforeunload handler if we're on the create new feed page
    if (isCreateNewFeedPage()) {
      // Track when the form is being submitted to avoid showing the warning
      $('.adt-edit-feed-form').on('submit', function () {
        isSubmittingForm = true;
      });

      // Track clicks on tab navigation links to avoid showing warnings
      $('.woo-product-feed-pro-nav-tab-wrapper .nav-tab').on('click', function () {
        // @ts-ignore
        // The link is within the edit feed page tabs, so temporarily disable the warning
        const linkHref = $(this).attr('href');
        if (linkHref && isNavigatingToSameEditPage(linkHref)) {
          // Create a flag to bypass the warning
          isSubmittingForm = true;
          // Reset the flag after the page load happens
          setTimeout(() => {
            isSubmittingForm = false;
          }, 100);
        }
      });

      // Add the beforeunload event handler
      // @ts-ignore
      $(window).on('beforeunload', function (e) {
        // Don't show warning if the form is being submitted or navigating to same page
        if (!isSubmittingForm) {
          // The returned string is ignored in modern browsers
          // They show a standard message instead
          const confirmationMessage = __(
            'Leaving this page will result in losing your feed configuration. Are you sure you want to leave?',
            'woo-product-feed-pro'
          );

          // For older browsers that support returnValue
          // Use type assertion to avoid TypeScript errors
          (e as any).returnValue = confirmationMessage;
          return confirmationMessage;
        }
      });
    }
  });
})(window, document, jQuery);
