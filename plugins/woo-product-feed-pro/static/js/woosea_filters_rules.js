jQuery(document).ready(function ($) {
  const { __ } = wp.i18n;
  
  // Initialize Select2 for all dropdown fields
  $(document.body).on('init_woosea_select2', function () {
    $('.woo-sea-select2').select2({
      placeholder: __('Select an attribute', 'woo-product-feed-pro'),
      allowClear: true,
    });
  });

  // Initial setup for existing selects
  $(document.body).trigger('init_woosea_select2');

  // Add filter row
  $('.add-filter').on('click', function () {
    const nonce = $('#_wpnonce').val();
    const rowCount = Math.round(new Date().getTime() + Math.random() * 100);
    const feedType = $('input[name="feed_type"]').val();

    $.ajax({
      method: 'POST',
      url: ajaxurl,
      data: {
        action: 'woosea_ajax_add_filter',
        security: nonce,
        rowCount: rowCount,
        feed_type: feedType,
      },
      beforeSend: function () {
        // Add loading indicator if needed
      },
    })
      .done(function (response) {
        if (!response.success) {
          console.error('Error:', response.data);
          return;
        }

        // Insert the new row before the buttons row
        $('table.woo-product-feed-pro-table .woo-product-feed-pro-body').append(response.data.html);

        // Initialize select2 for the new row
        $(document.body).trigger('init_woosea_select2');

        // Bind event handlers for the new row
        bindAttributeChangeEvents(rowCount, 'filter');
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error('AJAX Error:', textStatus, errorThrown);
      });
  });

  // Add rule row
  $('.add-rule').on('click', function () {
    const nonce = $('#_wpnonce').val();
    const rowCount = Math.round(new Date().getTime() + Math.random() * 100);
    const feedType = $('input[name="feed_type"]').val();

    $.ajax({
      method: 'POST',
      url: ajaxurl,
      data: {
        action: 'woosea_ajax_add_rule',
        security: nonce,
        rowCount: rowCount,
        feed_type: feedType,
      },
      beforeSend: function () {
        // Add loading indicator if needed
      },
    })
      .done(function (response) {
        if (!response.success) {
          console.error('Error:', response.data);
          return;
        }

        // Insert the new row before the buttons row
        $('table.woo-product-feed-pro-table .woo-product-feed-pro-body').append(response.data.html);

        // Initialize select2 for the new row
        $(document.body).trigger('init_woosea_select2');

        // Bind event handlers for the new row
        bindAttributeChangeEvents(rowCount, 'rule');
        bindConditionChangeEvents(rowCount);
        bindThanAttributeChangeEvents(rowCount);
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error('AJAX Error:', textStatus, errorThrown);
      });
  });

  // Bind change events for existing rows on page load
  $('#woosea-ajax-table tbody tr.filter-row').each(function () {
    const rowCount = $(this).find('input[type="hidden"][name$="[rowCount]"]').val();
    bindAttributeChangeEvents(rowCount, 'filter');

    // Initialize category dropdowns for existing filter rows
    const attributeSelect = $(this).find('select[name^="rules"][name$="[attribute]"]');
    if (attributeSelect.val() === 'categories' || attributeSelect.val() === 'raw_categories') {
      const feedId = $(this).closest('form#filters_rules').find('#feed_id').val();
      const $tr = $(this).closest('tr.filter-row');
      const $value = $tr.find('input[name^="rules"][name$="[criteria]"]');

      $.ajax({
        method: 'POST',
        url: ajaxurl,
        data: {
          action: 'woosea_categories_dropdown',
          type: 'filter',
          feed_id: feedId,
          rowCount: rowCount,
          value: $value.val(),
        },
      })
        .done(function (data) {
          try {
            data = JSON.parse(data);
            $('#criteria_' + rowCount).replaceWith(data.dropdown);
          } catch (e) {
            console.error('Error parsing JSON:', e);
          }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          console.error('AJAX Error:', textStatus, errorThrown);
        });
    }
  });

  $('#woosea-ajax-table tbody tr.rule-row').each(function () {
    const rowCount = $(this).find('input[type="hidden"][name$="[rowCount]"]').val();
    bindAttributeChangeEvents(rowCount, 'rule');
    bindConditionChangeEvents(rowCount);
    bindThanAttributeChangeEvents(rowCount);

    // Initialize category dropdowns for existing rule rows
    const attributeSelect = $(this).find('select[name^="rules2"][name$="[attribute]"]');
    if (attributeSelect.val() === 'categories' || attributeSelect.val() === 'raw_categories') {
      const feedId = $(this).closest('form#filters_rules').find('#feed_id').val();
      const $tr = $(this).closest('tr.rule-row');
      const $value = $tr.find('input[name^="rules2"][name$="[criteria]"]');

      $.ajax({
        method: 'POST',
        url: ajaxurl,
        data: {
          action: 'woosea_categories_dropdown',
          type: 'rule',
          feed_id: feedId,
          rowCount: rowCount,
          value: $value.val(),
        },
      })
        .done(function (data) {
          try {
            data = JSON.parse(data);
            $('#criteria_' + rowCount).replaceWith(data.dropdown);
          } catch (e) {
            console.error('Error parsing JSON:', e);
          }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          console.error('AJAX Error:', textStatus, errorThrown);
        });
    }
  });

  // Find and remove selected table rows
  $('.delete-row').on('click', function () {
    $('.woo-product-feed-pro-body')
      .find('input[name="record"]')
      .each(function () {
        if ($(this).is(':checked')) {
          $(this).closest('tr').remove();
        }
      });
  });

  // Helper function to bind attribute change event handlers
  function bindAttributeChangeEvents(rowCount, type) {
    const prefix = type === 'filter' ? 'rules_' : 'rules2_';
    const selector = type === 'filter' ? '#rules_' + rowCount : 'select[name="rules2[' + rowCount + '][attribute]"]';

    $(selector).on('change', function () {
      if ($(this).val() === 'categories' || $(this).val() === 'raw_categories') {
        const feedId = $(this).closest('form#filters_rules').find('#feed_id').val();

        $.ajax({
          method: 'POST',
          url: ajaxurl,
          data: {
            action: 'woosea_categories_dropdown',
            type: type,
            feed_id: feedId,
            rowCount: rowCount,
          },
        })
          .done(function (data) {
            try {
              data = JSON.parse(data);
              $('#criteria_' + rowCount).replaceWith(data.dropdown);
            } catch (e) {
              console.error('Error parsing JSON:', e);
            }
          })
          .fail(function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
          });
      }
    });
  }

  // Helper function to bind condition change event handlers
  function bindConditionChangeEvents(rowCount) {
    $('#condition_' + rowCount).on('change', function () {
      const condition = $(this).val();
      const nonce = $('#_wpnonce').val();

      $.ajax({
        method: 'POST',
        url: ajaxurl,
        data: {
          action: 'woosea_ajax_update_condition_fields',
          security: nonce,
          condition: condition,
          rowCount: rowCount,
          isRule: true,
        },
      })
        .done(function (response) {
          if (!response.success) {
            console.error('Error:', response.data);
            return;
          }

          // Hide or show fields based on the condition type
          if (response.data.hideFields.includes('than_attribute')) {
            $('#than_attribute_' + rowCount)
              .parent()
              .hide();
          } else {
            $('#than_attribute_' + rowCount)
              .parent()
              .show();
          }

          if (response.data.hideFields.includes('newvalue')) {
            $('#is-field_' + rowCount)
              .parent()
              .hide();
          } else {
            $('#is-field_' + rowCount)
              .parent()
              .show();
          }

          if (response.data.hideFields.includes('cs')) {
            $('#cs_' + rowCount)
              .parent()
              .hide();
          } else {
            $('#cs_' + rowCount)
              .parent()
              .show();
          }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          console.error('AJAX Error:', textStatus, errorThrown);
        });
    });
  }

  // Helper function to bind than_attribute change event handlers
  function bindThanAttributeChangeEvents(rowCount) {
    $('#than_attribute_' + rowCount).on('change', function () {
      if ($(this).val() === 'google_category') {
        const nonce = $('#_wpnonce').val();

        $.ajax({
          method: 'POST',
          url: ajaxurl,
          data: {
            action: 'woosea_ajax_google_category_field',
            security: nonce,
            rowCount: rowCount,
          },
        })
          .done(function (response) {
            if (!response.success) {
              console.error('Error:', response.data);
              return;
            }

            $('#is-field_' + rowCount).replaceWith(response.data.html);

            // Initialize typeahead for Google category
            $('.js-autosuggest').on('click', function () {
              var rowCount = $(this).closest('tr').prevAll('tr').length;

              $('.autocomplete_' + rowCount).typeahead({
                input: '.js-autosuggest',
                source: google_taxonomy,
                hint: true,
                loadingAnimation: true,
                items: 10,
                minLength: 2,
                alignWidth: false,
                debug: true,
              });

              $('.autocomplete_' + rowCount).focus();

              // Handle field styling on input
              $(this).keyup(function () {
                const minimum = 5;
                const len = $(this).val().length;

                if (len >= minimum) {
                  $(this).removeClass('input-field-large').addClass('input-field-large-active');
                } else {
                  $(this).removeClass('input-field-large-active').addClass('input-field-large');
                }
              });

              $(this).click(function () {
                const len = $(this).val().length;
                if (len < 1) {
                  $(this).removeClass('input-field-large-active').addClass('input-field-large');
                }
              });
            });
          })
          .fail(function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
          });
      }
    });
  }
});
