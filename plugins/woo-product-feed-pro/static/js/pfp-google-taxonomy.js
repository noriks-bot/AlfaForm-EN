jQuery(function ($) {
  var file_url = pfp_google_taxonomy.file_url;
  var google_taxonomy = [];

  // Load the Google Taxonomy file
  $.get(file_url, function (data) {
    var lines = data.split('\n');
    for (var i = 1; i < lines.length; i++) {
      // Start from index 1 to skip the first line
      google_taxonomy.push(lines[i]);
    }

    // Initialize Bloodhound after data is loaded
    var google_taxonomy_dataset = new Bloodhound({
      local: google_taxonomy,
      datumTokenizer: Bloodhound.tokenizers.whitespace,
      queryTokenizer: Bloodhound.tokenizers.whitespace,
    });

    // Initialize Typeahead
    $('.input-google-taxonomy').typeahead(
      {
        hint: true,
        highlight: true,
        minLength: 0,
      },
      {
        name: 'google_taxonomy_dataset',
        source: google_taxonomy_dataset,
      }
    );

    // Set the typeahead value to the selected value on load page.
    $('.input-google-taxonomy').each(function () {
      var $this = $(this);
      var value = $this.val();

      if (value) {
        // Find the selected value in the google_taxonomy array
        var selected = google_taxonomy.find(function (element) {
          element = element.split(' - ')[0];
          element = element.trim();

          return element === value;
        });

        if (selected) {
          $this.typeahead('val', selected);
        }
      }
    });

    $('.input-google-taxonomy').bind('typeahead:change', function (ev, suggestion) {
      var $hint = $(this).siblings('.tt-hint');
      var $input = $(this);
      var $hidden_input = $input.closest('td').find('.input-google-taxonomy-hidden-id');

      // Set the hidden input value.
      var val = $input.typeahead('val');
      val = val.split(' - ')[0].trim();
      $hidden_input.val(val);

      if (this.value === '') {
        $hint.removeClass('active');
        $(this).removeClass('active');
      } else {
        $hint.addClass('active');
        $(this).addClass('active');
      }
    });
  });

  // Copy the selected Google Taxonomy category.
  $('.copy-google-taxonomy-category').on('click', function () {
    var $tr = $(this).closest('tr.catmapping');
    var $input = $tr.find('.input-google-taxonomy.tt-input');

    var value = $input.typeahead('val'); // Get value from typeahead
    var is_parent = $(this).data('is_parent');
    var category_id = $input.data('category_id');

    var starting_row = $tr.index();
    var $rows = $tr.siblings('.catmapping');
    if (is_parent) {
      $rows = $rows.filter(function () {
        return $(this).find('.input-google-taxonomy.tt-input').data('parent') === category_id;
      });
    } else {
      $rows = $rows.filter(function () {
        return $(this).index() > starting_row;
      });
    }

    $rows.each(function () {
      var $input = $(this).find('.input-google-taxonomy.tt-input');
      var $hidden_input = $input.closest('td').find('.input-google-taxonomy-hidden-id');

      // Set the typeahead value.
      $input.typeahead('val', value);

      // Set the hidden input value.
      var val = $input.typeahead('val');
      val = val.split(' - ')[0].trim();
      $hidden_input.val(val);

      if (value) {
        $input.addClass('active');
        $input.siblings('.tt-hint').addClass('active');
      } else {
        $input.removeClass('active');
        $input.siblings('.tt-hint').removeClass('active');
      }
    });
  });
});
