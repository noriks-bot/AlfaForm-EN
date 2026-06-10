jQuery(function ($) {
  /**
   * Close the marketing page.
   */
  $('.pfp-marketing-page-close').on('click', function () {
    // Send an AJAX request to the server.
    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'pfp_close_marketing_page',
        nonce: pfp_admin_marketing.nonce,
        plugin_key: $(this).data('plugin_key'),
      },
    }).done(function (response) {
      if (response.success) {
        window.location.href = response.data.redirect_to;
      }
    });
  });
});
