=== Payment Plugins for Stripe WooCommerce ===
Contributors: paymentplugins, mrclayton
Tags: stripe, klarna, credit card, apple pay, google pay
Requires at least: 3.0.1
Tested up to: 7.0
Requires PHP: 5.6
Stable tag: 3.3.106
Copyright: Payment Plugins
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Accept Credit Cards, Google Pay, ApplePay, Afterpay, Affirm, ACH, Klarna, iDEAL and more all in one plugin for free!

= Official Stripe Partner =
Payment Plugins is an official partner of Stripe.

= Boost conversion by offering product and cart page checkout =
Stripe for WooCommerce is made to supercharge your conversion rate by decreasing payment friction for your customer.
Offer Google Pay, Apple Pay, and Stripe's Browser payment methods on product pages, cart pages, and at the top of your checkout page.

= Visit our demo site to see all the payment methods in action =
[Demo Site](https://demos.paymentplugins.com/wc-stripe/product/pullover/)

To see Apple Pay, visit the site using an iOS device. Google Pay will display for supported browsers like Chrome.

= Features =
- Credit Cards
- Google Pay
- Apple Pay
- Afterpay, Affirm, Klarna
- ACH Payments
- 3DS 2.0
- Local payment methods like Konbini, PayNow, BLIK, P24, IDEAL and many more
- WooCommerce Subscriptions
- WooCommerce Pre-Orders
- WooCommerce Blocks
- Installments for supported countries
- Integrates with [CheckoutWC](https://www.checkoutwc.com/payment-plugins-stripe-woocommerce/)

== Frequently Asked Questions ==
= How do I test this plugin? =
 You can enable the plugin's test mode, which allows you to simulate transactions.

= Does your plugin support WooCommerce Subscriptions? =
Yes, the plugin supports all functionality related to WooCommerce Subscriptions.

= Where is your documentation? =
https://paymentplugins.com/documentation/stripe/

= Why isn't the Payment Request button showing on my local machine? =
If your site is not loading over https, then Stripe won't render the Payment Request button. Make sure you are using https.

== Screenshots ==
1. Let customers pay directly from product pages
2. Apple Pay on the cart page
3. Custom credit card forms
4. Klarna on checkout page
5. Local payment methods like iDEAL and P24
6. Configuration pages
7. Payment options at top of checkout page for easy one click checkout
8. Edit payment gateways on the product page
9. Stripe Link for high conversion

== Changelog ==
= 3.3.106 - 04/08/26 =
* Fixed - [MBWay Javascript error when payment cancelled](https://wordpress.org/support/topic/mb-way-via-upm-throws-javascript-error-when-customer-cancels-payment/)
* Fixed - PHP notice triggered when iDEAL used for a free trial subscription
= 3.3.105 - 03/24/26 =
* Fixed - Issue on variation pages where variations were reset for "Any" attribute. [https://wordpress.org/support/topic/bug-variation-dropdowns-for-any-attributes-are-being-reset/](https://wordpress.org/support/topic/bug-variation-dropdowns-for-any-attributes-are-being-reset/)
= 3.3.104 - 03/13/26 =
* Added - WC Tested to 10.6
* Fixed - On the Edit Product page > Stripe Settings panel, if payment method is disabled globally, ensure settings reflect that
* Updated - Improved express checkout integration with Funnelkit checkout page
= 3.3.103 - 03/03/26 =
* Fixed - Improved handling of Apple Pay redacted postal code for "GB" and "CA" country codes. [https://wordpress.org/support/topic/uk-postcode-wildcard-shipping-zones-to-fail-with-apple-pay/](https://wordpress.org/support/topic/uk-postcode-wildcard-shipping-zones-to-fail-with-apple-pay/)
* Added - The statement descriptor option in the Advanced Settings page now supports dynamic variables like order_id, order_number. [Documentation](https://paymentplugins.com/documentation/stripe/advanced-settings/#statement-descriptor)
* Added - For card payments, a new "statement descriptor suffix" option has been added to the Advanced Settings page. This option also supports dynamic variables. [Documentation](https://paymentplugins.com/documentation/stripe/advanced-settings/#statement-descriptor-suffix)
* Updated - If a local payment method return url is revisited, ensure the order notes are not duplicated
= 3.3.102 - 02/18/26 =
* Fixed - Syntax errors in the Admin option setting descriptions
* Fixed - JS error for Apple Pay and GPay via Payment Request Gateway when side cart button clicked on product page
= 3.3.101 - 02/02/26 =
* Fixed - Apple Pay was showing on some unsupported devices combined with plugins like Funnelkit
* Fixed - Checkout block express section appeared disabled due to a bug in WooCommerce. We have added a resolution in this plugin so merchants don't have to wait.
[https://wordpress.org/support/topic/js-error-for-logged-in-customers-with-a-saved-payment-method/](https://wordpress.org/support/topic/js-error-for-logged-in-customers-with-a-saved-payment-method/)
= 3.3.100 - 01/28/26 =
* Added - Option for Payment Request Gateway where you can specify Google Pay availability on all browsers or just Chrome.
* Fixed - When Germanized for WooCommerce installed, Apple Pay and Google Pay were not re-displaying on the checkout shortcode after the order_update_review request was triggered. This made it
appear as if they were not available.
= 3.3.99 - 01/17/26 =
* Added - Terms Enabled option on Advanced Settings page. This option allows merchants to enable/disable mandate and legal agreement text rendered by Stripe in the payment element. [Terms Enabled](https://paymentplugins.com/documentation/stripe/advanced-settings/#terms-enabled)
* Updated - Some themes add the "float" property to the place order button on the checkout page. To prevent the Apple Pay button from conflicting with the float property, additional CSS was added to the button.
* Updated - The Payment Request Gateway now uses the Express Checkout Element. It will render Google Pay on more browsers like Safari, Firefox, and Edge. Be sure and clear any cache plugins
so the new scripts load.
* Updated - Increased Afterpay limits for Australia and New Zealand to 4000 AUD and 4000 NZD
= 3.3.98 - 01/15/26 =
* Added - Apple Pay is now available on all supported browsers when using product page, cart shortcode, and checkout shortcode.
* Added - Option where you can specify if you want Apple Pay available only on Safari or all supported browsers.
= 3.3.97 - 12/29/25 =
* Added - Checkout page upsell support for new CheckoutWC feature coming out in January
* Added - Apple Pay button height option. The minimum height is 40px and the maximum height is 55px.
* Added - The cart block and checkout block Apple Pay integration now uses the new Stripe Express Checkout element. This allows Apple Pay to be available on browsers other than Safari. Support for the checkout shortcode, cart shortcode, and product pages will be added in upcoming releases.
* Added - Button radius option for the Payment Request Gateway
* Added - Button radius option for Link Checkout
* Added - Button radius option for Apple Pay. This option replaces the now deprecated "Button Design" option
* Added - Automatic registration of payment method domains during plugin update for improved Apple Pay compatibility
* Updated - Default payment method configurations now automatically enable Apple Pay and Google Pay display preferences
* Updated - For cart block and checkout block, updated logic for determining if the phone field is required
* Updated - Improved compatibility with cart and checkout blocks
= 3.3.96 - 11/30/25 =
* Added - tested up to WordPress 6.9
* Updated - Load wc-stripe-functions.php earlier than "init" action. Some 3rd party plugins were causing a conflict which is resolved by earlier loading of Stripe plugin functions.
* Updated - Modified payment button logic on product variation pages to use the DOM value instead of Javascript variable values. [https://wordpress.org/support/topic/more-than-one-variation-on-a-product-causes-googlepay-error/](https://wordpress.org/support/topic/more-than-one-variation-on-a-product-causes-googlepay-error/)
= 3.3.95 - 10/29/25 =
* Added - WC Tested to 10.3
* Added - Support for Billie payment method
* Added - Puerto Rico to Klarna supported countries
* Updated - Changed script handles for WooCommerce to include the "wc-" prefix for WooCommerce 10.3.0.
* Updated - When express payment is made on product and cart page, ensure attribution data is included in the request.
* Updated - Removed Giropay and Sofort from payment method options since they have been deprecated by Stripe.
= 3.3.94 - 10/15/25 =
* Updated - Merchants using Bluehost reported that payment methods were not showing in settings or checkout page. This was caused by an update to the Bluehost plugin where it triggered the "woocommerce_payment_gateways" too early in the WordPress load sequence.
 We have added additional code to ensure Stripe payment methods are loaded even if the filter "woocommerce_payment_gateways" is called before the WordPress "init" action.
* Added - Filter "wc_stripe_order_cancelled_enabled". [https://wordpress.org/support/topic/limit-refund-on-cancel-option/](https://wordpress.org/support/topic/limit-refund-on-cancel-option/)
= 3.3.93 - 10/03/25 =
* Fixed - When Stripe inline form was enabled, Link was always active
* Fixed - Apple Pay rounded button option on checkout block
* Added - Klarna support for recurring payments and pre-orders
* Added - WC Tested to 10.2
* Updated - New documentation website. [Documentation](https://paymentplugins.com/documentation/stripe/)
* Updated  - Stripe PHP library to version 13.18.0
* Updated - Afterpay parameters updated for USD and GBP. Max cart total for USD is $4,000 and 1,200 for GBP.
* Updated - Limit ACH payment option to US customers based on billing country. [https://wordpress.org/support/topic/no-option-to-limit-countries-for-ach-bank-transfer/](https://wordpress.org/support/topic/no-option-to-limit-countries-for-ach-bank-transfer/)
= 3.3.92 - 08/21/25 =
* Fixed - Incompatibility notice that was showing on block editor under certain conditions. The Stripe plugin has supported the cart and checkout block for several years.
* Fixed - Issue where Link Checkout was not showing on product page if other express options were not enabled.
* Updated - Improved integration with FunnelKit upsells when 3DS is required.
* Added - WC Tested to 10.1
* Fixed - [https://wordpress.org/support/topic/missing-label-association-for-saving-sepa-payment-method/](https://wordpress.org/support/topic/missing-label-association-for-saving-sepa-payment-method/)
= 3.3.91 - 07/23/25 =
* Fixed - Check that billing phone field exists on checkout page before requiring it in the Link Checkout wallet
* Update - For level3 data, include logic for cases where discounts are added as a negative fee. [https://wordpress.org/support/topic/error-trying-to-capture-payment-in-woocommerce/](https://wordpress.org/support/topic/error-trying-to-capture-payment-in-woocommerce/)
* Added - WC Tested to 10.0
= 3.3.90 - 06/26/25 =
* Fixed - If iDEAL was used to pay for a failed renewal order, it was not being converted to SEPA which caused the next renewal payment to fail.
* Fixed - Javascript error in Firefox when Link Checkout enabled
* Updated - If on variable product page and variation not in stock, disable express payment buttons
= 3.3.89 -06/23/25 =
* Added - Link Express Checkout gateway for the product, cart and checkout page. This feature has replaced the Link popup functionality. It can be enabled on the new "Link Checkout" settings page.
* Fixed - Javascript error on Admin Order Details page when customer associated with order was changed.  [https://wordpress.org/support/topic/errors-in-admin-order-page-when-selecting-a-customer/](https://wordpress.org/support/topic/errors-in-admin-order-page-when-selecting-a-customer/)
* Updated - Moved the Link enabled/disabled option for cards from the Advanced Settings page to the Credit Card Settings page now that there is a new Link Express Checkout gateway.
* Removed - The Link popup feature has been replaced with our new Link Express Checkout feature, which offers a faster, more reliable one-click checkout experience similar to Apple Pay and Google Pay. This enhancement provides better conversion rates and a smoother path for your customers to complete their purchases.
= 3.3.88 - 06/10/35 =
* Fixed - WooCommerce 9.9.3 unexpectedly changed the operand type of the WC_Shipping_Rate $cost property, resulting in a possible PHP error. This change resolves that. [https://wordpress.org/support/topic/fatal-error-with-woocommerce-9-9-3/](https://wordpress.org/support/topic/fatal-error-with-woocommerce-9-9-3/)
= 3.3.87 - 06/01/25 =
* Added - Option to save customer's payment method when using the pay for order modal in the Edit Order admin page
* Added - Missing text domain on two strings. [https://wordpress.org/support/topic/empty-text-domain-in-strings-translation-error/](https://wordpress.org/support/topic/empty-text-domain-in-strings-translation-error/)
* Added - Pay By Bank payment method stand alone gateway. [https://wordpress.org/support/topic/pay-by-bank/](https://wordpress.org/support/topic/pay-by-bank/)
* Added - Handle WooCommerce core notices for express payment methods. [https://wordpress.org/support/topic/subscription-using-apple-pay-crashes-block-checkout/](https://wordpress.org/support/topic/subscription-using-apple-pay-crashes-block-checkout/)
* Updated - Payment Request Button locale format. [https://wordpress.org/support/topic/show-google-pay-button-in-users-language/](https://wordpress.org/support/topic/show-google-pay-button-in-users-language/)
* Updated - Improved block editor preview for express payment methods
= 3.3.86 - 04/29/25 =
* Fixed - Error related to WC 9.8+ and the checkout block when express payment button like Apple Pay used. [https://wordpress.org/support/topic/applepay-on-checkout-block-broken-in-production-and-virgin-sandbox-test-mode/](https://wordpress.org/support/topic/applepay-on-checkout-block-broken-in-production-and-virgin-sandbox-test-mode/)
= 3.3.85 - 04/24/25 =
* Added - Amazon Pay support for currencies USD, AUD, GBP, DKK, EUR, HKD, JPY, NZD, NOK, ZAR, SEK, CHF.
* Added - WC Tested to 9.8
= 3.3.84 - 03/18/25 =
* Fixed - Pay for order error when order created manually by admin. [https://wordpress.org/support/topic/500-error-when-trying-to-pay-for-order-from-admin/](https://wordpress.org/support/topic/500-error-when-trying-to-pay-for-order-from-admin/)
= 3.3.83 - 03/15/25 =
* Fixed - Error on checkout block "The type of the provided source is link. This does not match the expected type card."
* Fixed - Horizontal scroll on checkout page when Apple Pay selected.
* Fixed - On checkout block, don't show "use another payment method" if there are no saved payment methods
* Fixed - Card option for UPM would not deactivate when unchecked. [https://wordpress.org/support/topic/universal-payment-method-card-issue/](https://wordpress.org/support/topic/universal-payment-method-card-issue/)
= 3.3.82 - 02/17/25 =
* Fixed - Klarna not showing for certain EEA countries.
* Added - Improved description on Klarna Settings page showing the plugin rules for when Klarna is available.
= 3.3.81 - 02/11/25 =
* Fixed - Incompatibility with WooCommerce Smart Coupons. Issue resolved where items were appearing in cart/removed from cart when payment buttons enabled on product pages.
* Updated - Klarna rules so merchants can offer Klarna in more currencies and countries
= 3.3.80 - 12/20/2024 =
* Fixed - missing file introduced in 3.3.79
= 3.3.79 - 12/20/2024 =
* Added - Test mode validation so live keys can't be entered in test mode fields
* Added - Bulk action on Products page so product level Stripe settings can be removed
* Added - Alt tags to the credit card icons displayed next to the payment method title
= 3.3.78 - 11/19/2024 =
* Added - Buy Now Pay Later payment method support for manual subscription renewal
* Added - Klarna support for Romania (RON currency)
* Added - Klarna Order status option on Klarna Settings page
* Fixed - SEPA error on Add Payment Method page if Stripe inline form enabled
= 3.3.77 - 11/03/2024 =
* Fixed - WeChat pay error on checkout block when place order button clicked
* Added - Klarna support for Czech Republic (CZK currency)
= 3.3.76 - 10/07/2024 =
* Added - WC Tested to 9.3
* Added - TWINT payments
* Fixed - [https://wordpress.org/support/topic/bug-card-error-causes-inoperable-checkout-button/](https://wordpress.org/support/topic/bug-card-error-causes-inoperable-checkout-button/)
= 3.3.75 - 08/20/2024 =
* Fixed - If currency changes on checkout page, update universal payment element so available methods is current.
* Fixed - Only re-render the card form if the updated_checkout event results in the HTML being replaced. [Support thread](https://wordpress.org/support/topic/changing-field-contents-reloads-stripe-dialog-and-empties-it/)
* Fixed - Error related to micro-deposits when using ACH
* Added - WC Tested to 9.2
* Added - Scheduled action to ensure dropped card orders get processed if they're successful within Stripe but interrupted by a 3rd party plugin issue.
* Updated - Webhook API version to 2022-08-01
= 3.3.74 - 07/16/2024 =
* Added - WordPress 6.6 compatibility
= 3.3.73 - 06/27/2024 =
* Fixed - Mandate error for ACH payments when using checkout block. [https://wordpress.org/support/topic/error-code-pops-up-when-customer-try-to-pay-with-ach/](https://wordpress.org/support/topic/error-code-pops-up-when-customer-try-to-pay-with-ach/)
* Fixed - If there are duplicate payment methods saved in the WooCommerce payment_tokens table, ensure the row created by this plugin is used.
* Added - Users can now switch seamlessly from the FunnelKit Stripe plugin to this plugin.
= 3.3.72 - 06/20/2024 =
* Fixed - handleCardAction action error triggered when GPay requires 3DS
* Fixed - Apple Pay showing pending total for cart and checkout block when only digital goods in cart (this did not affect payment functionality)
* Updated - Improved integration with German Market plugin by MarketPress
= 3.3.71 - 05/30/2024 =
* Added - MobilePay payments can be authorized or captured
* Added - Extended authorizations for card payments. [Stripe Docs](https://docs.stripe.com/payments/extended-authorization). Make sure your account is eligible before enabling this feature.
* Added - EUR support for Revolut. EUR support is in beta so make sure it's enabled on your Stripe account.
= 3.3.70 - 05/21/2024 =
* Added - Amazon Pay, Cash App, Revolut, Zip Pay, MobilePay can now be used as stand alone gateways. They can also be used in the Universal Payment Method.
* Added - Support for recurring payments for iDEAL
* Added - SEPA, ACH, and other payment methods added to the My Account > Add Payment Method page
* Added - New payment notice for Apple Pay and GPay which provides improved instructions on checkout page. This must be enabled for all merchants that have used previous versions of the plugin. [Screenshot](https://imgur.com/aFD1Eq9d)
* Added - Option to create Stripe customers for guest checkout. [https://wordpress.org/support/topic/create-a-stripe-customer-account-on-purchase/](https://wordpress.org/support/topic/create-a-stripe-customer-account-on-purchase/)
* Updated - Consolidated code for smaller Javascript files
* Updated - Improved ACH integration which now supports micro-deposit verification
* Updated - If Afterpay/Clearpay is disabled, don't show messaging either. The messaging relied on the Messaging Section settings but Afterpay should also be enabled before messaging shows.
= 3.3.62 - 05/9/2024 =
* Added - Universal Payment Method integration
* Added - Amazon Pay, Zip Pay, Cashapp, Revolut
* Updated - Multibanco integration now uses Payment Intent API
= 3.3.61 - 04/25/2024 =
* Added - Klarna support for CZK
* Added - WC Tested to 8.8
* Added - GPay button radius option
* Fixed - Only load the WooCommerce Product Add-On script if payment buttons are enabled on product pages
* Fixed - [https://wordpress.org/support/topic/fatal-error-after-updated-to-latest-version/](https://wordpress.org/support/topic/fatal-error-after-updated-to-latest-version/)
= 3.3.60 - 03/18/2024 =
* Added - Order button text translations added to the wpml-config.xml file.
* Added - Refund reason in the refund metadata. https://wordpress.org/support/topic/metadata-in-refunds/
* Added - Stripe refund ID in order notes when a refund is processed
* Fixed - Fullname is required error message encountered with Link using checkout shortcode.
* Fixed - Ensure ACH payments use the order_status option if it's not set to default. https://wordpress.org/support/topic/the-order-status-feature-in-general-settings-doesnt-work/
= 3.3.59 - 02/23/2024 =
* Added - Support for the Swish payment method popular in Sweden
* Updated - Translations used by the checkout blog integration. Translations used in the checkout shortcode will now work on the cart block and checkout block
= 3.3.58 - 02/16/2024 =
* Added - Filter wc_stripe_capture_charge_failed so merchants can perform custom actions after a failed capture of an authorized payment
* Fixed - On pay for order page, resolved error if card triggered insufficient funds error and then customer used a saved card instead
= 3.3.57 - 02/07/2024 =
* Updated - Improved compatibility with FunnelKit order bump when cart total is $0
* Updated - For card payments, replaced "statement_descriptor" property with "statement_descriptor_suffix". [Stripe announcement](https://support.stripe.com/questions/use-of-the-statement-descriptor-parameter-on-paymentintents-for-card-charges)
* Updated - Improved Link Checkout integration with Checkout Block
= 3.3.56 - 01/26/2024 =
* Fixed - Stripe payment form not submitting if 100% off coupon used on subscription.
* Fixed - Compatibility with CheckoutWC side-cart and GPay
* Added - Add Link to payment_method_types array if needed on recurring payment
* Added - Option on Advanced Settings page where the Link popup can be enabled/disabled
* Added - Disable pay for order by phone if order is not created yet.
[https://wordpress.org/support/topic/conflict-with-sequential-order-numbers-and-admin-phone-order-feature/](https://wordpress.org/support/topic/conflict-with-sequential-order-numbers-and-admin-phone-order-feature/)
* Added - Option to save ACH payment method on checkout page
* Updated - Removed the "created" key from payment intent metadata since it's redundant. The Payment Intent object already has the creation time as a property.
= 3.3.55 - 01/01/2024 =
* Added - Support for Afterpay, Affirm, and Klarna messaging on the Cart Block
* Added - Clearpay icon so merchants can choose which icon appears on checkout page if they're not relying on the messaging element
* Fixed - Afterpay message settings being ignored after version 3.3.53 release
* Updated - Replaced deprecated Checkout Block names now that Checkout block is part of WooCommerce core
= 3.3.54 - 12/20/23 =
* Fixed - WooCommerce defaults gateway options to an empty string which can trigger a PHP exception in PHP 8.0+ if in_array is called with a string rather than an array.
= 3.3.53 - 12/19/23 =
* Added - Apple Pay and GPay now use the "Cart Page" and Express Checkout" payment section option when rendering on the cart and checkout block. In order to
show Apple Pay or GPay on the cart and checkout block, make sure "Cart Page" and "Express Checkout" are enabled in the Payment Sections setting of the gateway.
* Added - Klarna messaging which is supported on product pages, cart page, and checkout page
* Added - Klarna redirect notice like Affirm and Afterpay on new Block Checkout
* Added - Option where Affirm and Afterpay messaging can be turned on/off on checkout page. If turned off, the payment method's icon will show.
* Added - WC Tested to 8.4
* Added - Translation for error code "payment_intent_authentication_failure"
* Updated - Removed "Hide if ineligible" option for Afterpay. If the cart is ineligible, Afterpay displays a notice.
* Updated - WeChat now uses the PaymentIntent API.
= 3.3.52 - 11/21/23 =
* Added - Filter wc_stripe_get_new_method_label
* Added - Filter wc_stripe_get_saved_methods_label
* Added - Show loader on checkout page when 3DS screen launching for free trial subscription. [Support ticket](https://wordpress.org/support/topic/issue-with-authentication-workflow/)
* Added - jQuery event wc_stripe_error_message_enabled triggered when submitting an error message. This will allow 3rd parties to control the scroll behavior.
* Added - Improved product page payment button logic for variations
* Added - Always request payerName and payerEmail for Apple Pay to improve risk insights
= 3.3.51 - 10/13/23 =
* Added - Support for [WooCommerce Product Add-ons](https://woocommerce.com/products/product-add-ons/) plugin. Product addons are now accounted for on the product page when using express payment options like Apple Pay and GPay.
* Added - Filter wc_stripe_is_link_active
* Fixed - SEPA error message on Change Payment Method page of WooCommerce Subscription
= 3.3.50 - 9/22/23 =
* Fixed - Don't include level3 property in requests where the payment intent is authorized and Link is used. Stripe doesn't currently support
capturing authorized amounts when using Link with level3.
* Fixed - Don't allow quantity property of level3 data to contain decimals. Some plugins modify the quantity so it has decimals.
* Added - Rounded corner option for Apple Pay button
= 3.3.49 - 9/9/23 =
* Fixed - Capture error when amount is less than authorized amount and level3 data is passed.
= 3.3.48 - 9/3/23 =
* Fixed - For local payment methods like P24 etc, unset address properties that are empty. Some merchants remove address fields like billing_country so remove those in requests to Stripe to prevent API validation errors.
* Fixed - If Link is used to pay for a renewal, update the subscriptions payment method ID.
* Updated - If a subscription is set to manual because it was created using another plugin, update the payment method when the renewal order is paid for.
= 3.3.47 - 8/31/23 =
* Added - Support for Level3 data which can decrease processing fees. This is a beta feature offered by Stripe and only US merchants are eligible at this time.
* Added - Link support for the Stripe inline form
* Updated - Improve product page express button logic
* Updated - Link icon that renders in email input field was changed to use a background-image which will result in less 3rd party plugin
conflicts
* Fixed - Don't rely on order status event to trigger a void on order details page
* Fixed - If Konbini times out before customer completes verification in banking app, display a notice on the checkout page notifying the customer
= 3.3.46 - 8/16/23 =
* Added - Support for PromptPay
* Fixed - BLIK code returning validation error when code contained a zero
* Updated - Make the Stripe fee order metadata enabled by default
= 3.3.45 - 8/5/23 =
* Fixed - Mini-cart issue with shipping options when using Apple Pay or GPay
* Fixed - Affirm and Afterpay messaging location option not working
= 3.3.44 - 7/24/23 =
* Added - Apple Pay and GPay support for  Extra Product Options & Add-Ons for WooCommerce on product pages.
* Updated - [Afterpay is exiting France and Spain](https://offboarding.clearpay.com/docs/api/announcement-en) so removed those options from Afterpay gateway
* Fixed - Email address not populating for Apple Pay on Checkout Block due to changes made in the WooCommerce Blocks plugin
= 3.3.43 - 6/23/23 =
* Fixed - Don't include Link icon template if icon is disabled
* Fixed - Add extra validation so Link is not enabled if the Stripe payment form isn't active. Link should only be used with the Stripe payment form.
= 3.3.42 - 5/30/23 =
* Fixed - Add payment method ID and customer ID to WooCommerce Subscription created via FunnelKit upsell
* Fixed - Stripe changed the charge.refunded webhook so updated the code to ensure refunds created in stripe.com appear in WooCommerce.
* Updated - Link does not change the email field priority by default. You can modify that option on the Advanced Settings page of the Stripe plugin
* Added - FunnelKit Cart plugin integration
* Added - Save payment method option for SEPA on checkout page
* Added - e-mandates support for Stripe accounts in India when processing a subscription
= 3.3.41 - 5/18/23 =
* Added - Affirm support for Canada.
* Added - Installment option on the Pay for Order page
* Added - Theme option for the Stripe payment form
* Added - Link now supports the following countries: AE, AT, AU, BE, BG, CA, CH, CY, CZ, DE, DK, EE, ES, FI, FR, GB,
GI, GR, HK, HR, HU, IE, IT, JP, LI, LT, LU, LV, MT, MX, MY, NL, NO, NZ, PL, PT, RO, SE, SG, SI, SK, US
* Updated - WC tested up to 7.7
* Updated - GPay brought back support for the white button so added that option back. They no longer support the pill shaped button.
* Fixed - FPX error when using WooCommerce Blocks
* Fixed - Link integration with WooCommerce Blocks
* Fixed - GPay integration with WooCommerce Blocks
= 3.3.40 - 4/17/23 =
* Added - Klarna now supports countries Australia, Austria, Belgium, Canada, Czechia, Denmark, Finland, France, Greece, Germany, Ireland, Italy, Netherlands, New Zealand, Norway, Poland, Portugal, Spain, Sweden, Switzerland, United Kingdom, and the United States
* Added - Removed beta headers for the card payment form
* Added - Protect against 3rd party plugins and code incorrectly using the "setup_future_usage" property.
* Added - If the merchant switches the Stripe account the plugin is connected to, handle the customer does not exist error and
create a new customer object during checkout.
* Added - If the merchant switches the Stripe account the plugin is connected to, handle the payment method does not exist error
and remove the payment method from future use.
= 3.3.39 =
* Fixed - Firefox event click issue with GPay. Event is now synchronous so that Firefox browser is fully supported
* Fixed - WooCommerce Blocks change to how billing and shipping address data populates
* Updated - Improved payment button performance on product pages
* Updated - Updated Alipay logic so it shows if CNY is store currency, regardless of billing country
* Updated - ACH payment icon for Blocks integration
* Updated - WC tested up to 7.5
* Added - New option where merchants can control when a Stripe customer ID is created. This is for merchants that only want to create a customer ID during payment
if they have GDPR concerns.
= 3.3.38 - 2/17/23 =
* Added - Support for BLIK payment method
* Added - Support for Konbini payment method
* Added - Support for PayNow payment method
* Fixed - Afterpay messaging not updating for variable products
* Fixed - ACH checkout page button not showing under certain conditions
= 3.3.37 - 2/8/23 =
* Added - Ability to configure the Affirm and Afterpay messaging location on product pages
* Added - Ability to configure the Affirm and Afterpay messaging location on the cart page
* Added - Ability to configure the Affirm and Afterpay messaging location on the shop/category page
* Added - For Payment Element, include list of payment_method_types to prevent Stripe from rendering multiple payment options
* Added - When displaying saved payment methods on checkout page, sort by the default payment method
* Added - Greece support for Klarna
* Fixed - If the charge ID is not in the review.opened webhook payload, use the payment intent to fetch the order ID
= 3.3.36 - 1/13/23 =
* Updated - WC tested up to 7.3
* Updated - Stripe PHP library to version 10.3.0
* Updated - Removed GPay color option since GPay now only supports the black button
* Added - Affirm and Afterpay messaging option for displaying on shop/category page
* Added - Webhook ID to payment intent metadata. This will reduce webhook log clutter for merchants that use multiple webhooks for one Stripe account.
* Added - Optimized classmap which improves plugin performance
* Added - Link support for accounts in Canada, Japan, Liechtenstein, Mexico
* Added - Link icon option for the billing email field. When enabled, a Link icon shows in the email field which indicates to customers that Link is supported.
= 3.3.36 =
* Fixed - ACH mandate text incorrectly displaying business name
= 3.3.35 - 12/17/22 =
* Fixed - Ensure Affirm and Afterpay messaging updates on product page when variation is selected
* Added - GPay option for rounded button corners. Google recently changed their API so the default button has rounded corners. We prefer
to give merchants the option on what button style they use.
* Added - Stripe fee for FunnelKit Upsell order
= 3.3.34 - 12/02/22 =
* Added - Support for Affirm payments. Affirm messaging can be added on product pages, cart page, and checkout page
* Added - Afterpay title to the checkout page. There was feedback that this title was needed in addition to the Afterpay messaging
* Updated - afterpay.php template file was modified to use the offsite-notice.php template
* Fixed - Installment plans not loading when Payment Form active
= 3.3.33 - 11/23/22 =
* Fixed - Afterpay payment method title not showing in order received emails and on order details page
* Updated - Removed "beta" from Payment form label in settings
* Added - Link support for FunnelKit/WooFunnels Upsells
= 3.3.32  - 11/11/22 =
* Updated - Improved Payment form (beta) performance
* Updated - Improved Link integration
* Updated - WC tested up to 7.1
= 3.3.31 - 10/19/22 =
* Fixed - Potential PHP error caused by PHP 8.1+ in Blocks class GooglePayPayment
* Fixed - Incorrect text domain for installment text
= 3.3.30 - 10/18/22 =
* Updated - WC tested up to 7.0
* Updated - Improved integration with FunnelKit (WooFunnels One Click Upsell)
* Added - Support for WooCommerce custom order tables (HPOS)
* Added - Filter "wc_stripe_show_admin_metaboxes" and "wc_stripe_show_pay_order_section" if custom logic is needed to show the charge view or Pay for Order view
* Fixed - Brazil installments minimum amount should be 1 BRL.
= 3.3.28 - 9/26/22 =
* Fixed - ACH javascript files not included in version 3.3.27 build
* Updated - Removed admin feedback code
= 3.3.27  - 9/25/22 =
* Fixed - Cast float to payment balance fee and net values
* Fixed - If refund is created in stripe.com dashboard, always take the latest refund from the list of refunds.
* Updated - WC tested up to 6.9
* Updated - WeChat Pay logo
* Updated - Alipay logo
* Updated - GPay WooCommerce Blocks integration performance improvements
* Added - Installments for Brazil Stripe accounts
* Added - Stripe Link support for EU countries
* Added - Stripe ACH Connections integration which replaces Plaid. Plaid can still be used but has been deprecated in favor of the new ACH integration.
= 3.3.26 - 8/24/22 =
* Updated - WC Tested up to 6.8
* Updated - Afterpay can now be used to purchase digital goods
* Added  - Afterpay support for France and Spain.
* Fixed - WC_Stripe_Utils::get_order_from_payment_intent()
* Fixed - Boleto WooCommerce Blocks checkout error
* Removed - Feedback modal on plugin deactivation
= 3.3.25 - 8/3/22 =
* Added - Advanced Settings option so merchants can control if the processing or completed status triggers the capture for an authorized order
* Fixed - Customer pay for order page error caused by Stripe payment form (beta)
* Added - Improved Subscription retry logic
= 3.3.24 - 7/5/22 =
* Fixed - Remove payment intent from session when intent's status is processing
* Updated - If payment intent's status transitions to requires_payment_method, update order status to pending
* Added - Filter wc_stripe_asynchronous_payment_method_order_status which can be used to change the order's status before redirect to payment page like Sofort, etc
* Added - Filter wc_stripe_get_api_error_messages which can be used to customize error messages
= 3.3.23 - 6/27/22 =
* Fixed - Conflict with the WooCommerce Pay Trace plugin
* Updated - Billing phone required if Stripe payment form card design used.
* Updated - Improved WooCommerce Blocks Link integration
* Updated - Check terms and conditions on when Plaid ACH button clicked on checkout page
= 3.3.22 - 6/16/22 =
* Updated - WC Tested up to 6.6
* Fixed - Error that could be triggered on plugins page if WooCommerce deactivated
* Fixed - WooCommerce Blocks Link integration autofill of shipping address
= 3.3.21 - 6/4/22 =
* Fixed - Error on checkout page when Payment Element is active and saved card used for payment
* Fixed - Don't hide "save card" checkbox when Link is active on checkout page
* Updated - Improved Payment Element integration with WooCommerce Blocks
= 3.3.20 - 6/3/22 =
* Added - PaymentElement for card payments
* Added - Link with Stripe which uses the PaymentElement to increase conversion rates
* Added - Additional messaging for the installments option located on the Advanced Settings page
* Added - Loader on Blocks ACH when initializing Plaid
* Added - Ability to delete connection to Stripe account on API Settings page
* Added - payment_intent.requires_action event for OXXO and Boleto
* Fixed - ACH fee option not being included in order on checkout page
* Fixed - Correctly display AfterPay messaging on product pages if prices are shown including tax
= 3.3.19 - 4/7/22 =
* Added - Support for installments for Mexico based accounts
* Added - Afterpay messaging in order summary of Checkout Block
* Fixed - GPay gateway 3DS error where authentication screen wasn't appearing.
= 3.3.18 =
* Fixed - Elementor template editor error when Woofunnels Checkout design is being edited in Admin.
* Updated - Mini cart code so it's more fault tolerant when using 3rd party mini-cart plugins.
* Updated - SEPA, GiroPay, Bancontact, EPS, Sofort, Alipay migrated to PaymentIntent API from Sources API
* Added - SEPA support for Pre Orders
* Added - Support for WooFunnels One Click Upsell Subscriptions
* Added - BECS support for WooCommerce Subscriptions and Pre-Orders
* Added - BECS company name option so merchant can customize the company name that appears in the mandate.
= 3.3.17 =
* Added - Stripe Customer ID field in the WooCommerce Subscription edit subscription page so it can be easily updated if necessary.
* Added - Plugin main page that contains link to support and documentation
* Added - WooFunnels AeroCheckout Express button compatibility.
* Updated - WC Tested up to 5.6
* Updated - Moved the Admin menu link for Stripe plugin to the WooCommerce menu section.
* Updated - Clearpay transaction limit set to 1000 GBP
* Updated - VISA and Maestro icons.
* Updated - Express checkout on checkout page now includes "OR" text separator. HTML was updated and new css class names used.
= 3.3.16 =
* Added - Option to specify where card form validation errors are shown. Previously they were shown at the top of the checkout page. The default is now above the credit card form.
* Added - Boleto voucher expiration days option
* Added - Option to include Boleto voucher link in order on-hold email sent to customer.
* Fixed - Don't remove coupon notice on checkout page if there is an error message that should be displayed.
* Fixed - Rare error that can occur when processing a subscription with a free trial on checkout page using Credit Card.
* Fixed - If local payment method is unsupported due to currency or billing country on checkout page, select next available payment method so place order button text updates.