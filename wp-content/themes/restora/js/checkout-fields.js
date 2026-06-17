/**
 * Vigoshop-style floating labels for checkout
 * Adds/removes 'field--not-empty' class on form-row when input has value
 */
(function($) {
  'use strict';
  
  function updateFieldState() {
    var $input = $(this);
    var $row = $input.closest('.form-row');
    if ($input.val() && $input.val().length > 0) {
      $row.addClass('field--not-empty');
    } else {
      $row.removeClass('field--not-empty');
    }
  }
  
  function initFields() {
    var selectors = [
      '.woocommerce-billing-fields__field-wrapper',
      '.woocommerce-shipping-fields__field-wrapper',
      '.woocommerce-additional-fields__field-wrapper'
    ].join(', ');
    
    $(selectors).find('input.input-text, textarea, select').each(updateFieldState);
  }
  
  $(document).on('input change keyup', '.woocommerce-billing-fields__field-wrapper input.input-text, .woocommerce-billing-fields__field-wrapper textarea, .woocommerce-shipping-fields__field-wrapper input.input-text, .woocommerce-additional-fields__field-wrapper input.input-text, .woocommerce-additional-fields__field-wrapper textarea', updateFieldState);
  
  // Also handle select2 changes
  $(document).on('change', '.woocommerce-billing-fields__field-wrapper select', function() {
    var $row = $(this).closest('.form-row');
    if ($(this).val()) {
      $row.addClass('field--not-empty');
    } else {
      $row.removeClass('field--not-empty');
    }
  });
  
  // Init on load and after WC updates
  $(document).ready(initFields);
  $(document.body).on('updated_checkout', initFields);
  
  // Handle autofill (browsers fill fields without triggering input events)
  setTimeout(initFields, 500);
  setTimeout(initFields, 1500);
  
})(jQuery);
