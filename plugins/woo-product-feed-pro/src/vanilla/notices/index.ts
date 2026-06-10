declare var $: any;

import './style.scss';
import { NotificationDrawer } from './drawer';
import { NotificationHeaderIcon } from './header-icon';

/**
 * Unified Notice System
 * Handles both traditional admin notices and notification drawer
 * All actions are data-driven from PHP - no hardcoded classes needed
 */
(function (w, d, $) {
  const { __ } = w.wp.i18n;

  // Traditional admin notices
  const $adminNotices = $('.adt-pfp-admin-notice');
  let currentNoticeIndex = 0;

  /**
   * Generic action handler - works for ANY button with data attributes
   * Supports both traditional notices and drawer items
   */
  const handleAction = function (this: HTMLElement, e: any) {
    const $button = $(this);
    const $container = $button.closest('.adt-pfp-admin-notice, .adt-notification-drawer__item');

    if ($container.length === 0) return;

    const isDrawerItem = $container.hasClass('adt-notification-drawer__item');

    // Check if button has a link
    const href = $button.attr('href');
    const hasLink = href && href !== '#';
    const isExternal = $button.attr('target') === '_blank';

    // Check if it's a plugin installation action
    if ($button.data('plugin_slug')) {
      e.preventDefault();
      handlePluginInstall($button, $container, isDrawerItem);
      return;
    }

    // Check if it's a dismiss/response action
    if ($button.data('response') || $button.hasClass('notice-dismiss')) {
      // If it's an external link, let the browser handle it naturally (don't preventDefault)
      // This avoids popup blockers and ensures the link opens
      if (hasLink && isExternal) {
        // Let the link open naturally, dismiss in background
        handleDismiss($button, $container, isDrawerItem);
        return;
      }

      // For non-external links or links without href, prevent default and handle dismiss
      e.preventDefault();
      handleDismiss($button, $container, isDrawerItem);
      return;
    }

    // Default: if it's just a link with no special data, let it work naturally
    if (!hasLink || href === '#') {
      e.preventDefault();
    }
  };

  /**
   * Handle plugin installation
   */
  const handlePluginInstall = ($button: any, $container: any, isDrawerItem: boolean) => {
    const pluginSlug = $button.data('plugin_slug');
    const nonce = $button.data('nonce');
    const noticeId = $container.attr('id') || $container.data('notice-id');
    const containerNonce = $container.data('nonce');

    if (!pluginSlug || !nonce) return;

    const originalText = $button.text();

    // Show loading state
    $button.text(__('Installing...', 'woo-product-feed-pro')).prop('disabled', true).addClass('disabled');

    // Install plugin via AJAX
    $.ajax({
      url: w.ajaxurl,
      type: 'POST',
      data: {
        action: 'adt_install_activate_plugin',
        plugin_slug: pluginSlug,
        silent: true,
        nonce: nonce,
      },
      success: (response: any) => {
        if (response.success) {
          $button.text(__('Installed', 'woo-product-feed-pro'));

          // Dismiss the notice
          if (noticeId && containerNonce) {
            $.post(w.ajaxurl, {
              action: 'adt_pfp_dismiss_admin_notice',
              notice_id: noticeId,
              nonce: containerNonce,
              response: 'installed',
            });
          }

          // Remove from UI
          removeNotification($container, isDrawerItem);
        } else {
          $button.text(originalText).prop('disabled', false).removeClass('disabled');
        }
      },
      error: () => {
        $button.text(originalText).prop('disabled', false).removeClass('disabled');
      },
    });
  };

  /**
   * Handle dismiss/snooze/response actions
   */
  const handleDismiss = ($button: any, $container: any, isDrawerItem: boolean) => {
    const response = $button.data('response') || 'dismissed';
    const noticeId = $container.attr('id') || $container.data('notice-id');
    const nonce = $container.data('nonce');

    if (!noticeId || !nonce) return;

    // Handle loading state if specified
    const withLoading = $button.hasClass('with-loading');
    const loadingText = $button.data('loading-text');
    if (withLoading && loadingText) {
      $container.empty().append($('<p>').text(loadingText));
    } else {
      $container.fadeOut('fast');
    }

    // Send AJAX request
    $.post(
      w.ajaxurl,
      {
        action: 'adt_pfp_dismiss_admin_notice',
        notice_id: noticeId,
        response: response,
        nonce: nonce,
      },
      (ajaxResponse: any) => {
        if (ajaxResponse.success && ajaxResponse.redirect) {
          window.location.href = ajaxResponse.redirect;
        } else {
          removeNotification($container, isDrawerItem);
        }
      }
    );
  };

  /**
   * Remove notification from UI
   */
  const removeNotification = ($container: any, isDrawerItem: boolean) => {
    $container.fadeOut(200, () => {
      $container.remove();

      if (isDrawerItem) {
        updateDrawerState();
      }
    });
  };

  /**
   * Update drawer badge count and check if empty
   */
  const updateDrawerState = () => {
    const drawer = (window as any).adtNotificationDrawer;
    if (drawer && typeof drawer.updateBadgeCount === 'function') {
      drawer.updateBadgeCount();
      drawer.checkIfEmpty();
    }
  };

  /**
   * Bind generic event handlers
   * Works for ANY button/link inside notice-actions or drawer actions
   */
  const bindEvents = () => {
    // Traditional notices - bind to any button/link in actions
    $(document).on(
      'click',
      '.adt-pfp-admin-notice button, .adt-pfp-admin-notice a, .adt-pfp-admin-notice .notice-dismiss',
      handleAction
    );

    // Drawer items - bind to any button/link in actions
    $(document).on('click', '.adt-notification-drawer__item a, .adt-notification-drawer__item button', handleAction);
  };

  /**
   * Navigation arrows for multiple notices
   */
  const addNavigationArrows = () => {
    const noticesCount = $adminNotices.length;

    if (noticesCount > 1) {
      $adminNotices.hide();
      $adminNotices.eq(currentNoticeIndex).show();

      $('.adt-notice-nav-prev').on('click', (e: Event) => {
        e.preventDefault();
        $adminNotices.eq(currentNoticeIndex).fadeOut(200, () => {
          currentNoticeIndex = (currentNoticeIndex - 1 + $adminNotices.length) % $adminNotices.length;
          $adminNotices.eq(currentNoticeIndex).fadeIn(200);
        });
      });

      $('.adt-notice-nav-next').on('click', (e: Event) => {
        e.preventDefault();
        $adminNotices.eq(currentNoticeIndex).fadeOut(200, () => {
          currentNoticeIndex = (currentNoticeIndex + 1) % $adminNotices.length;
          $adminNotices.eq(currentNoticeIndex).fadeIn(200);
        });
      });
    }
  };

  // Initialize
  $(document).ready(() => {
    // Initialize the notification drawer if element exists
    if ($('#adt-notification-drawer').length > 0) {
      const drawer = new NotificationDrawer();
      const headerIcon = new NotificationHeaderIcon(drawer);

      // Expose to window for external access if needed
      (window as any).adtNotificationDrawer = drawer;
      (window as any).adtNotificationHeaderIcon = headerIcon;
    }

    bindEvents();
    addNavigationArrows();
  });
})(window, document, jQuery);
