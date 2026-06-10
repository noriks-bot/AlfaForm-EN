// Declare jQuery variables
declare var jQuery: any;
declare var vex: any;

import './style.scss';

(function (w, d, $) {
  const { __ } = w.wp.i18n;

  // DOM ready
  $(function () {
    // Global function for the upsell modal
    w.adtObj.showEliteUpsellModal = function (id: string) {
      const upsellL10n = w.adtObj.upsellL10n[id] || w.adtObj.upsellL10n.default;
      const content = upsellL10n.content;

      vex.dialog.alert({
        className: 'vex-theme-plain adt-pfp-upsell-modal',
        unsafeMessage: content,
      });
    };

    // Custom refresh interval upsell fields
    $('form.adt-edit-feed-form#general tr#refresh_interval select').on('change', function (this: any, e: any) {
      e.preventDefault();

      const $select = $(this);
      const $tr = $select.closest('tr#refresh_interval');
      const $customSelect = $tr.next('#custom_refresh_interval_upsell');
      const value = $select.val();

      if (value === 'custom_upsell') {
        $customSelect.show();

        // Show the modal.
        if (w.adtObj?.showEliteUpsellModal) {
          w.adtObj.showEliteUpsellModal('custom_refresh_interval');
        }
      } else {
        $customSelect.hide();
      }
    });
  });

  // Form Submit.
  $('form.adt-edit-feed-form').on('submit', function (this: HTMLElement, e: any) {
    const $this = $(this);
    const $refreshInterval = $this.find('#refresh_interval');
    const $customRefreshInterval = $this.find('#custom_refresh_interval_upsell');

    const $refreshIntervalSelect = $refreshInterval.find('select');
    const value = $refreshIntervalSelect.val();

    if (value === 'custom_upsell') {
      // show the modal.
      if (w.adtObj?.showEliteUpsellModal) {
        w.adtObj.showEliteUpsellModal('custom_refresh_interval');
      }

      // Prevent form submission.
      e.preventDefault();
      return false;
    }
  });

  // Import feeds container click handler
  $('.adt-tw-import-feeds-container').on('click', function (this: HTMLElement, e: any) {
    if (!w.adtObj.isEliteActive) {
      if (w.adtObj?.showEliteUpsellModal) {
        w.adtObj.showEliteUpsellModal('import_feeds');
      } else {
        // Fallback alert
        alert(
          w.adtObj.upsellL10n?.import_feeds?.message ||
            __('Elite plugin required for import functionality.', 'woo-product-feed-pro')
        );
      }
      e.preventDefault();
      return false;
    }
  });
})(window, document, jQuery);
