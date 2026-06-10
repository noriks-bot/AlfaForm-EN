jQuery(function ($) {
  $('.adt-pfp-allow-tracking-notice-action-button').on('click', function (event) {
    event.preventDefault();

    var $notice = $(this).closest('.pfp-allow-tracking-notice');
    var value = $(this).data('value');

    $notice.fadeTo(100, 0, function () {
      $notice.slideUp(100, function () {
        $notice.remove();
      });
    });

    jQuery.ajax({
      method: 'POST',
      url: ajaxurl,
      data: {
        action: 'adt_pfp_allow_tracking_notice_action',
        security: adt_pfp_allow_tracking_notice.nonce,
        value: value,
      },
    });
  });
});
