jQuery(function($) {
    let page = 0;
    const maxPage = load_more_params.max_page;
    const queryVars = load_more_params.query_vars;
    let loading = false;

    $('#load-more').on('click', function() {
        if (loading || page >= maxPage) return;

        loading = true;
        page++; // starts at 1 on first click

        $('#load-more').text('Loading...');

        $.ajax({
            url: load_more_params.ajaxurl,
            type: 'POST',
            data: {
                action: 'loadmore',
                query: queryVars,
                page: page
            },
            success: function(response) {
                if ($.trim(response)) {
                    $('.products').append(response);
                    if (page >= maxPage) {
                        $('#load-more').hide();
                    } else {
                        $('#load-more').text('Prikaži več');
                    }
                } else {
                    $('#load-more').hide();
                }
                loading = false;
            },
            error: function() {
                $('#load-more').text('Error. Try again');
                loading = false;
            }
        });
    });
});
