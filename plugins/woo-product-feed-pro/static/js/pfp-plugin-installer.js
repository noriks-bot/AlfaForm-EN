jQuery(function ($) {
  const { __ } = wp.i18n;
  
  // Click event listener for the install button
  $('#pfp-about-page .pfp-install-plugin').on('click', function (e) {
    e.preventDefault(); // Prevent the default button behavior

    // Check if the button is disabled. If it is, return early.
    if ($(this).data('disabled')) {
      return;
    }

    var $button = $(this); // Cache the button jQuery object
    var pluginSlug = $button.data('plugin-slug'); // Get the plugin slug from the data attribute
    var nonce = $('#pfp-about-page #adt-install-plugin').val(); // Get the nonce value

    // Disable the button and change its text
    $button.text(__('Installing...', 'woo-product-feed-pro')).data('disabled', true);
    $button.addClass('disabled');

    // Make the AJAX call to the backend
    $.ajax({
      url: ajaxurl, // Replace with the actual backend URL
      type: 'POST',
      data: {
        action: 'adt_install_activate_plugin',
        plugin_slug: pluginSlug,
        silent: true,
        nonce: nonce,
      },
      success: function (response) {
        // Check the response to determine if the action was successful.
        if (response.success) {
          // If successful, update the UI accordingly
          $button.closest('.install-status').find('.install-status-value').text(__('Installed', 'woo-product-feed-pro')); // Update the install status text
          $button.remove(); // Remove the install button
        } else {
          // If the action fails, revert the button text
          $button.text(__('Install Plugin', 'woo-product-feed-pro')).data('disabled', false);
          $button.removeClass('disabled');
          // Fail silently, so no further action is taken
        }
      },
      error: function () {
        // In case of an AJAX error, revert the button text
        $button.text(__('Install Plugin', 'woo-product-feed-pro')).data('disabled', false);
        $button.removeClass('disabled');
        // Fail silently
      },
    });
  });
});
