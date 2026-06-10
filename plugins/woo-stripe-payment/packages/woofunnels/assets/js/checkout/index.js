import $ from 'jquery';

$(document.body).on('wc_stripe_get_billing_prefix', (e, prefix) => {
    if ($('[name="billing_same_as_shipping"]').length) {
        if (!$('[name="billing_same_as_shipping"]').is(':checked')) {
            prefix = 'shipping';
        }
    }
    return prefix;
});

// hack to make the buttons render when Funnelkit express checkout is being used. Funnelkit uses a MutationObserver
// to know when the buttons have been rendered. Adding the <span> element triggers the MutationObserver callback.
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
        $('.wc-stripe-checkout-banner-gateway.StripeElement').each((i, e) => {
            $(e).append('<span style="display:none"></span>');
        })
    }, 500);
});