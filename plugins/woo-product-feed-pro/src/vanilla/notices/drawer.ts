/**
 * Notification Drawer Module
 *
 * Handles the notification drawer functionality:
 * - Opening/closing the drawer
 * - Mark all as read
 * - Updating badge counts
 * - Empty state management
 */
export class NotificationDrawer {
  private drawer: any = null;
  private panel: any = null;
  private overlay: any = null;
  private markAllReadButton: any = null;
  private isOpen = false;

  constructor() {
    this.init();
  }

  /**
   * Access jQuery from window
   */
  private get $(): any {
    return (window as any).jQuery;
  }

  /**
   * Initialize the drawer
   */
  private init(): void {
    this.drawer = this.$('#adt-notification-drawer');

    if (!this.drawer || this.drawer.length === 0) {
      return;
    }

    this.overlay = this.drawer.find('.adt-notification-drawer__overlay');
    this.panel = this.drawer.find('.adt-notification-drawer__panel');
    this.markAllReadButton = this.drawer.find('.adt-notification-drawer__mark-all-read');

    this.bindEvents();
  }

  /**
   * Bind drawer-specific events (open/close, mark all as read)
   * Action buttons are handled by unified notices system
   */
  private bindEvents(): void {
    // Close drawer when clicking overlay
    this.overlay?.on('click', () => this.close());

    // Handle mark all as read
    this.markAllReadButton?.on('click', (e: Event) => {
      e.preventDefault();
      this.markAllAsRead();
    });

    // Close on escape key
    this.$(document).on('keydown', (e: KeyboardEvent) => {
      if (e.key === 'Escape' && this.isOpen) {
        this.close();
      }
    });
  }

  /**
   * Open the drawer
   */
  public open(): void {
    if (this.isOpen) return;

    // Remove inline styles and add open classes
    this.drawer?.css('opacity', '');
    this.panel?.css('transform', '');
    this.drawer?.removeClass('adt-tw-pointer-events-none').addClass('adt-tw-pointer-events-auto');
    this.overlay
      ?.removeClass('adt-tw-opacity-0 adt-tw-pointer-events-none')
      .addClass('adt-tw-opacity-100 adt-tw-pointer-events-auto');
    this.panel?.removeClass('adt-tw-translate-x-full').addClass('adt-tw-translate-x-0');

    this.isOpen = true;
    this.$('body').css('overflow', 'hidden');
  }

  /**
   * Close the drawer
   */
  public close(): void {
    if (!this.isOpen) return;

    // Remove open classes
    this.overlay
      ?.removeClass('adt-tw-opacity-100 adt-tw-pointer-events-auto')
      .addClass('adt-tw-opacity-0 adt-tw-pointer-events-none');
    this.panel?.removeClass('adt-tw-translate-x-0').addClass('adt-tw-translate-x-full');

    // Restore inline styles after transition
    setTimeout(() => {
      this.drawer?.css('opacity', '0');
      this.panel?.css('transform', 'translateX(100%)');
      this.drawer?.removeClass('adt-tw-pointer-events-auto').addClass('adt-tw-pointer-events-none');
    }, 300);

    this.isOpen = false;
    this.$('body').css('overflow', 'unset');
  }

  /**
   * Toggle the drawer
   */
  public toggle(): void {
    if (this.isOpen) {
      this.close();
    } else {
      this.open();
    }
  }

  /**
   * Mark all notifications as read
   */
  private markAllAsRead(): void {
    const $unreadItems = this.drawer?.find('.adt-notification-drawer__item');
    const noticeIds: string[] = [];

    $unreadItems?.each((_index: number, element: HTMLElement) => {
      const noticeId = this.$(element).data('notice-id');
      if (noticeId) {
        noticeIds.push(noticeId);
      }
    });

    if (noticeIds.length === 0) return;

    const originalButtonText = this.markAllReadButton?.text();
    this.markAllReadButton
      ?.text((window as any).wp.i18n.__('Marking...', 'woo-product-feed-pro'))
      .prop('disabled', true);

    this.$.ajax({
      url: (window as any).ajaxurl,
      type: 'POST',
      data: {
        action: 'adt_pfp_mark_all_read',
        notice_ids: noticeIds,
        nonce: (window as any).adtNotificationsData.markAllReadNonce,
      },
      success: (response: any) => {
        if (response.success) {
          $unreadItems?.fadeOut(200, () => {
            $unreadItems.remove();
            this.updateBadgeCount();
            this.checkIfEmpty();
          });
          this.markAllReadButton?.hide();
        } else {
          this.markAllReadButton?.text(originalButtonText).prop('disabled', false);
        }
      },
      error: () => {
        this.markAllReadButton?.text(originalButtonText).prop('disabled', false);
      },
    });
  }

  /**
   * Update badge count (called by unified notices system after actions)
   */
  public updateBadgeCount(): void {
    const unreadCount = this.drawer?.find('.adt-notification-drawer__item').length || 0;
    const $headerIconBadge = this.$('.adt-notification-icon__badge');
    const $menuBadge = this.$('.toplevel_page_woo-product-feed .update-plugins .update-count');

    if (unreadCount > 0) {
      $headerIconBadge?.text(unreadCount).show();
      $menuBadge?.text(unreadCount);
      this.markAllReadButton
        ?.show()
        .prop('disabled', false)
        .text((window as any).wp.i18n.__('Mark all as read', 'woo-product-feed-pro'));
    } else {
      $headerIconBadge?.remove();
      $menuBadge?.parent().remove();
      this.markAllReadButton?.hide();
    }
  }

  /**
   * Check if drawer is empty and show empty state (called by unified notices system)
   */
  public checkIfEmpty(): void {
    const itemCount = this.drawer?.find('.adt-notification-drawer__item').length || 0;
    const $emptyState = this.drawer?.find('.adt-notification-drawer__empty');
    const $list = this.drawer?.find('.adt-notification-drawer__list');

    if (itemCount === 0) {
      $list?.hide();
      $emptyState?.show();
    } else {
      $emptyState?.hide();
      $list?.show();
    }
  }
}
