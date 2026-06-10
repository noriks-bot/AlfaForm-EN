jQuery(function ($) {
  /**
   * Upgrade to Elite link.
   *
   * Add class to the menu item and the link.
   * Modify the link and target of the link to open in a new tab.
   */
  const upgradeMenuLink = $('#toplevel_page_woo-product-feed .wp-submenu li a[href="admin.php?page=upgrade-to-elite"]');
  const upgradeMenu = upgradeMenuLink.closest('li');

  if (upgradeMenuLink.length && upgradeMenu.length) {
    // Add class to the menu item and the link.s
    upgradeMenu.addClass('pfp-upgrade-to-elite-menu');
    upgradeMenuLink.addClass('pfp-upgrade-to-elite-link');

    // Modify the link.
    upgradeMenuLink.attr('href', pfp_admin_wide.upgradelink);
    upgradeMenuLink.attr('target', '_blank');
  }
});
