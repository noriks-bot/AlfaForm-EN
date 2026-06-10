import { NotificationDrawer } from './drawer';

/**
 * Notification Header Icon Module
 *
 * Handles the notification bell icon in the page header
 * and clicking to open the drawer
 */
export class NotificationHeaderIcon {
  private drawer: NotificationDrawer;
  private icon: any = null;

  constructor(drawer: NotificationDrawer) {
    this.drawer = drawer;
    this.init();
  }

  /**
   * Get jQuery from global scope
   */
  private get $(): any {
    return (window as any).jQuery;
  }

  /**
   * Initialize the header icon
   */
  private init(): void {
    this.icon = this.$('.adt-notification-icon');

    if (this.icon && this.icon.length) {
      this.bindEvents();
    }
  }

  /**
   * Bind event listeners
   */
  private bindEvents(): void {
    this.icon?.on('click', (e: Event) => {
      e.preventDefault();
      this.drawer.toggle();
    });
  }

  /**
   * Update the badge count
   */
  public updateBadgeCount(count: number): void {
    const badge = this.icon?.find('.adt-notification-icon__badge');

    if (count > 0) {
      if (badge.length) {
        badge.text(count).show();
      } else {
        this.icon?.append(
          `<span class="adt-notification-icon__badge adt-tw-absolute adt-tw-top-0 adt-tw-right-0 adt-tw-flex adt-tw-items-center adt-tw-justify-center adt-tw-min-w-[18px] adt-tw-h-[18px] adt-tw-px-1 adt-tw-bg-red-600 adt-tw-text-white adt-tw-rounded-full adt-tw-text-[10px] adt-tw-font-semibold adt-tw-leading-none">${count}</span>`
        );
      }
    } else {
      badge?.remove();
    }
  }
}

