jQuery(function($) {
    const builder        = $('#bundle-builder-qty');
    const qtyInput       = $('form.cart input[name=quantity]');
    const colorInputs    = builder.find('input[type=number]');
    const remainingDisplay = builder.find('.remaining');
    const $atcBtn        = $('form.cart').find('.single_add_to_cart_button, [name="add-to-cart"], [type="submit"][name="add-to-cart"]');

    // keep ATC disabled initially
    $atcBtn.attr('disabled','disabled').prop('disabled', true).addClass('cqbf-disabled');

    const maxPerUnit = 1; // same as your original logic

    function getBundleQtyLimit() {
        const qty = parseInt(qtyInput.val(), 10) || 1;
        return qty * maxPerUnit;
    }

    function totalItems() {
        let total = 0;
        colorInputs.each(function() {
            total += parseInt($(this).val(), 10) || 0;
        });
        return total;
    }

    function updateButtonState() {
        const total   = totalItems();
        const allowed = getBundleQtyLimit();

        // EXACT reach (since enforceTotalLimit caps to <= allowed)
        const ok = allowed > 0 && total === allowed;

        $atcBtn.prop('disabled', !ok)
               .toggleClass('cqbf-disabled', !ok);

        if (ok) {
            $atcBtn.removeAttr('disabled');
        } else {
            $atcBtn.attr('disabled','disabled');
        }
    }

    function updateDisplay() {
        const total = totalItems();
        const allowed = getBundleQtyLimit();
        remainingDisplay.text(`Odabrano ${total} of ${allowed} komada`);
        updateButtonState();
    }

    function enforceTotalLimit() {
        const allowed = getBundleQtyLimit();
        let total = totalItems();

        if (total <= allowed) return;

        // Reduce overage starting from highest qty
        const sorted = colorInputs.toArray().sort((a, b) => {
            return (parseInt($(b).val(), 10) || 0) - (parseInt($(a).val(), 10) || 0);
        });

        for (let i = 0; i < sorted.length && total > allowed; i++) {
            const $input = $(sorted[i]);
            const current = parseInt($input.val(), 10) || 0;
            if (current > 0) {
                const reduction = Math.min(current, total - allowed);
                $input.val(current - reduction);
                total -= reduction;
            }
        }
    }

    builder.on('click', '.plus', function() {
        
        
 const input   = $(this).siblings('input');
    const total   = totalItems();
    const allowed = getBundleQtyLimit();

    // If we're at limit and this color has 0, block adding
    if (total >= allowed && parseInt(input.val(), 10) === 0) {
        return; // do nothing
    }

    input.val((parseInt(input.val(), 10) || 0) + 1).trigger('change');
    });





    builder.on('click', '.minus', function() {
        const input = $(this).siblings('input');
        const val = parseInt(input.val(), 10) || 0;
        if (val > 0) input.val(val - 1).trigger('change');
    });

    builder.on('change keyup', 'input[type=number]', function() {
        enforceTotalLimit();
        updateDisplay();
    });

    qtyInput.on('change keyup', function() {
        enforceTotalLimit();
        updateDisplay();
    });

    // If theme/variation JS re-renders the form, keep ATC state in sync
    $(document.body).on('found_variation reset_data show_variation', function() {
        enforceTotalLimit();
        updateDisplay();
    });

    // 🔁 Auto-click the first custom qty button on load (kept from your code)
    const customQtyButtons = $('.custom-qty-buttons .qty-btn');
    if (customQtyButtons.length > 0) {
        customQtyButtons.removeClass('active');
        customQtyButtons.first().addClass('active').trigger('click');
    }

    // Initial paint
    enforceTotalLimit();
    updateDisplay();
});
