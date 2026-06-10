<?php
/**
 * Template Post Type: landigs
 */

$landing_url    = get_permalink();
$cart_url       = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
$home_url       = home_url('/');
$asset_base_url = trailingslashit(get_template_directory_uri()) . 'assets/js/landigs';
$source_path    = get_template_directory() . '/template_parts/landigs/step-landing-source.php';

if (!function_exists('noriks_parse_landigs_visual_options')) {
    function noriks_parse_landigs_visual_options($raw_options, $type = 'primary') {
        $lines = preg_split('/\r\n|\r|\n/', (string) $raw_options);
        $options = array();
        $index = 1;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line));
            $label = $parts[0] ?? '';

            if ($label === '') {
                continue;
            }

            $option = array(
                'id'       => sprintf('landigs-%s-%d', $type, $index),
                'name'     => $label,
                'selected' => $index === 1,
            );

            if ($type === 'primary') {
                $option['value'] = $parts[1] ?? '#111111';
            }

            $options[] = $option;
            $index++;
        }

        return $options;
    }
}

if (!function_exists('noriks_parse_landigs_offer_options')) {
    function noriks_parse_landigs_offer_options($raw_offers) {
        $lines = preg_split('/\r\n|\r|\n/', (string) $raw_offers);
        $offers = array();
        $index = 1;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line));
            $quantity = isset($parts[0]) ? (int) $parts[0] : 0;

            if ($quantity < 1) {
                continue;
            }

            $offers[] = array(
                'quantity' => $quantity,
                'title'    => $parts[1] ?? sprintf('%d x', $quantity),
                'subtitle' => $parts[2] ?? '',
                'badge'    => $parts[3] ?? '',
                'selected' => $index === 2,
            );

            $index++;
        }

        return $offers;
    }
}

if (!function_exists('noriks_ensure_default_landing_offers')) {
    function noriks_ensure_default_landing_offers($offers) {
        $has_five = false;

        foreach ($offers as $offer) {
            if (!empty($offer['quantity']) && (int) $offer['quantity'] === 5) {
                $has_five = true;
                break;
            }
        }

        if (!$has_five) {
            $offers[] = array(
                'quantity' => 5,
                'title'    => '5 majic',
                'subtitle' => 'Največji paket za največji prihranek',
                'badge'    => '',
                'selected' => false,
            );
        }

        return $offers;
    }
}

if (!function_exists('noriks_landigs_use_apparel_sizes')) {
    function noriks_landigs_use_apparel_sizes($raw_options) {
        $lines = preg_split('/\r\n|\r|\n/', (string) $raw_options);
        $lines = array_values(array_filter(array_map('trim', $lines)));

        if (empty($lines)) {
            return true;
        }

        $numeric_like = 0;

        foreach ($lines as $line) {
            if (preg_match('/^\d+(?:\s*\/\s*\d+)?(?:\s*-\s*\d+)?$/', $line)) {
                $numeric_like++;
            }
        }

        return $numeric_like === count($lines);
    }
}

if (!function_exists('noriks_get_sidecart_assets_markup')) {
    function noriks_get_sidecart_assets_markup() {
        if (!function_exists('xoo_wsc') || !function_exists('xoo_wsc_frontend') || !function_exists('xoo_wsc_helper')) {
            return array(
                'head' => '',
                'body' => '',
            );
        }

        $loader = xoo_wsc();
        $previous_is_sidecart_page = isset($loader->isSideCartPage) ? $loader->isSideCartPage : null;
        $loader->isSideCartPage = true;

        xoo_wsc_frontend()->enqueue_styles();
        xoo_wsc_frontend()->enqueue_scripts();

        ob_start();
        wp_print_styles(array('xoo-wsc-fonts', 'xoo-wsc-style'));
        wp_print_scripts(array('xoo-wsc-main-js'));
        $head_assets = ob_get_clean();

        ob_start();
        xoo_wsc_helper()->get_template('/global/markup-notice.php');
        xoo_wsc_helper()->get_template('xoo-wsc-markup.php');
        $body_markup = ob_get_clean();

        $loader->isSideCartPage = $previous_is_sidecart_page;

        return array(
            'head' => $head_assets,
            'body' => $body_markup,
        );
    }
}

if (!function_exists('noriks_get_landing_override_styles')) {
    function noriks_get_landing_override_styles() {
        return '<style id="noriks-landigs-overrides">
html.noriks-landings-pending .sct-hero__dyn-properties,
html.noriks-landings-pending .choose-qty,
html.noriks-landings-pending #dynamic-cart-variations-container,
html.noriks-landings-pending .add-to-cart-button-container,
html.noriks-landings-pending .related-product-wrapper {
  opacity: 0 !important;
  visibility: hidden !important;
}
[data-tpl="stps"] .button-variation,
[data-tpl="stps"] .button-variation:hover,
[data-tpl="stps"] .button-variation:focus,
[data-tpl="stps"] .button-variation:active,
[data-tpl="stps"] .button-variation:disabled {
  opacity: 1 !important;
  pointer-events: auto !important;
  cursor: pointer !important;
  filter: none !important;
  text-decoration: none !important;
  color: #000 !important;
  background: #fff !important;
  border: 2px solid #000 !important;
  box-shadow: none !important;
}
[data-tpl="stps"] .button-variation {
  min-width: 3.85rem !important;
  width: 3.85rem !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  padding-inline: 0 !important;
}
[data-tpl="stps"] .button-variation.selected,
[data-tpl="stps"] .button-variation[selected-option="true"] {
  color: #fff !important;
  background: #ff5b00 !important;
  border-color: #000 !important;
}
[data-tpl="stps"] .button-variation.greyOut,
[data-tpl="stps"] .button-variation.hiddenvariation {
  opacity: 1 !important;
}
[data-tpl="stps"] .button-variation.greyOut::before,
[data-tpl="stps"] .button-variation.hiddenvariation::before,
[data-tpl="stps"] .button-variation.greyOut::after,
[data-tpl="stps"] .button-variation.hiddenvariation::after {
  content: none !important;
  display: none !important;
}
.xoo-wsc-footer {
  padding: 5px 20px 25px 20px !important;
}
.xoo-wsc-container,
.xoo-wsc-container *,
.xoo-wsc-markup,
.xoo-wsc-markup * {
  font-family: "Roboto", sans-serif !important;
}
span.xoo-wsc-footer-txt {
  font-size: 70% !important;
}
.xoo-wsc-ft-buttons-cont {
  display: flex !important;
  flex-direction: column !important;
  gap: 8px !important;
  margin-top: 0 !important;
  padding-top: 0 !important;
  grid-template-columns: 1fr !important;
}
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn {
  width: 100% !important;
  box-sizing: border-box !important;
  font-family: "Roboto", sans-serif !important;
}
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-checkout {
  order: -1 !important;
  background: #c00 !important;
  background-color: #c00 !important;
  color: #fff !important;
  border-radius: 4px !important;
  font-weight: 700 !important;
  font-size: 20px !important;
  font-family: "Roboto", sans-serif !important;
  letter-spacing: 0.2px !important;
  text-transform: none !important;
  border: none !important;
  height: auto !important;
  padding: 22px 20px !important;
  width: 100% !important;
  box-sizing: border-box !important;
  margin: 0 !important;
  box-shadow: none !important;
  transform: none !important;
  filter: none !important;
  transition: none !important;
}
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-checkout:hover,
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-checkout:focus,
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-checkout:active,
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-checkout:visited {
  background: #c00 !important;
  background-color: #c00 !important;
  color: #fff !important;
}
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-checkout span {
  color: #fff !important;
}
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-continue {
  background: #fff !important;
  color: #000 !important;
  border: 1px solid #000 !important;
  border-radius: 4px !important;
  padding-top: 8px !important;
  padding-bottom: 8px !important;
  font-size: 75% !important;
  font-weight: 500 !important;
}
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-continue:hover,
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-continue:focus,
.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn-continue:active {
  background: #f5f5f5 !important;
  color: #000 !important;
}
.xoo-wsc-sp-container,
.xoo-wsc-sp-product,
.xoo-wsc-sp-right-col,
.xoo-wsc-sp-title,
.xoo-wsc-sp-price,
.xoo-wsc-sp-heading {
  font-family: "Roboto", sans-serif !important;
}
.xoo-wsc-sp-title {
  font-size: 15px !important;
  font-weight: 500 !important;
  line-height: 1.35 !important;
  color: #111 !important;
}
.xoo-wsc-sp-price {
  font-size: 16px !important;
  font-weight: 500 !important;
  color: #111 !important;
}
span.xoo-wsc-sp-atc a.button,
span.xoo-wsc-sp-atc a.button:hover,
span.xoo-wsc-sp-atc a.button:focus,
span.xoo-wsc-sp-atc a.button:active,
span.xoo-wsc-sp-atc a.add_to_cart_button,
span.xoo-wsc-sp-atc a.add_to_cart_button:hover,
span.xoo-wsc-sp-atc a.add_to_cart_button:focus,
span.xoo-wsc-sp-atc a.add_to_cart_button:active,
span.xoo-wsc-sp-atc a.noriks-upsell-btn,
span.xoo-wsc-sp-atc a.noriks-upsell-btn:hover,
span.xoo-wsc-sp-atc a.noriks-upsell-btn:focus,
span.xoo-wsc-sp-atc a.noriks-upsell-btn:active {
  background: #c00 !important;
  background-color: #c00 !important;
  color: #fff !important;
  border: 1px solid #c00 !important;
  border-radius: 4px !important;
  font-family: "Roboto", sans-serif !important;
  font-size: 13px !important;
  font-weight: 700 !important;
  line-height: 1 !important;
  text-transform: uppercase !important;
  padding: 9px 12px !important;
  box-shadow: none !important;
  text-decoration: none !important;
}
.xoo-wsc-sm-sales {
  display: none !important;
}
[data-tpl="stps"] .sct-experts .loockat-card__photo {
  display: flex !important;
  justify-content: center !important;
}
[data-tpl="stps"] .sct-experts .loockat-card__photo-img {
  width: 50% !important;
  max-width: 50% !important;
  height: auto !important;
  object-fit: contain !important;
}
[data-tpl="stps"] .gallery-thumbs__item {
  aspect-ratio: 1 / 1 !important;
  width: 100% !important;
  overflow: hidden !important;
}
[data-tpl="stps"] .gallery-thumbs__item img {
  width: 100% !important;
  height: 100% !important;
  aspect-ratio: 1 / 1 !important;
  object-fit: cover !important;
  display: block !important;
}
</style>';
    }
}

if (!function_exists('noriks_customize_step_landing_markup')) {
    function noriks_customize_step_landing_markup($markup, $landing_url, $cart_url, $home_url, $boxers_image_url, $hero_image_url, $landing_image_urls, $review_image_urls, $purpose_image_urls) {
        $markup = preg_replace(
            '#<div class="loockat-slider__wrapper video">.*?</div>\s*</div>\s*<!-- SLIDER TWO -->#s',
            '<!-- SLIDER TWO -->',
            $markup,
            1
        );

        $markup = preg_replace(
            '#<section class="section sct-ebook">.*?</section>#s',
            '',
            $markup,
            1
        );

        $markup = str_replace(
            array(
                'https://ortowp.noriks.com/product/stepease/',
                'https://ortowp.noriks.com/cart/',
                'https://ortowp.noriks.com/kosarica/?add-more=',
                'https://ortowp.noriks.com/wp-content/uploads/2026/02/84d4e066ce333_stepease_PP-EN_-_si-2.jpg',
                'https://images.hs-plus.com/assets/shared-images/84d4e066ce333_stepease_PP-EN_-_si-2.jpg',
                'https://ortowp.noriks.com/splosni-pogoji-poslovanja/',
                'https://ortowp.noriks.com/varnostna-politika/',
                'https://ortowp.noriks.com/politika-uporabe-piskotkov/',
                'https://ortowp.noriks.com/pravica-do-odstopa-od-nakupa/',
                'https://ortowp.noriks.com/reklamacije-in-pritozbe/',
                'https://ortowp.noriks.com/menjava-v-garanciji/',
                'https://ortowp.noriks.com/o-podjetju/',
                'https://ortowp.noriks.com/',
            ),
            array(
                esc_url($landing_url),
                esc_url($cart_url),
                esc_url($cart_url),
                esc_url($hero_image_url),
                esc_url($hero_image_url),
                esc_url(home_url('/splosni-pogoji-poslovanja/')),
                esc_url(home_url('/varnostna-politika/')),
                esc_url(home_url('/politika-uporabe-piskotkov/')),
                esc_url(home_url('/pravica-do-odstopa-od-nakupa/')),
                esc_url(home_url('/reklamacije-in-pritozbe/')),
                esc_url(home_url('/menjava-v-garanciji/')),
                esc_url(home_url('/o-podjetju/')),
                esc_url($home_url),
            ),
            $markup
        );

        $image_replacements = array(
            'https://images.hs-plus.com/assets/shared-images/84d4e066ce333_stepease_PP-EN_-_si-2.jpg' => $hero_image_url,
            'https://images.hs-plus.com/assets/shared-images/1b704871b6d6_stepease_PP-EN_-_si-5.jpg' => $landing_image_urls[1] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/shared-images/0db2e820e6db5_stepease_PP-EN_-_si.jpg' => $landing_image_urls[2] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/shared-images/04260de1979ae_stepease_PP-EN_-_si-1.jpg' => $landing_image_urls[3] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/shared-images/cc8b1fcd4471_stepease_PP-EN_-_si-7.jpg' => $landing_image_urls[4] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/shared-images/d82503b0fef5a_stepease_PP-EN_-_si-6.jpg' => $landing_image_urls[5] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/shared-images/f3f10485dce06_stepease_PP-EN_-_si-3.jpg' => $landing_image_urls[6] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/shared-images/2f514ac962b58_stepease_PP-EN_-_si-4.jpg' => $landing_image_urls[7] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/STEPPER%20test-0/e07e5f3fd5613_stepease-animation.gif' => $landing_image_urls[1] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/STEPPER%20test-0/a624d13e6cb5_comparison-before.jpg' => $landing_image_urls[2] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/STEPPER%20test-0/11ec4acb45091_comparison-after.jpg' => $landing_image_urls[3] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/STEPPER%20test-0/e54dd205a5d4e_purposes-1.jpg' => $purpose_image_urls[0] ?? ($landing_image_urls[0] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/3f3a362b9ef86_purposes-2.jpg' => $purpose_image_urls[1] ?? ($landing_image_urls[1] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/94d87998d13fd_purposes-3.jpg' => $purpose_image_urls[2] ?? ($landing_image_urls[2] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/b507d66504f75_purposes-4.jpg' => $purpose_image_urls[3] ?? ($landing_image_urls[3] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/8263da3f16fba_purposes-5.jpg' => $purpose_image_urls[4] ?? ($landing_image_urls[4] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/02df5692c8645_purposes-6.jpg' => $purpose_image_urls[5] ?? ($landing_image_urls[5] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/c565f489a2adc_purposes-7.jpg' => $purpose_image_urls[6] ?? ($landing_image_urls[6] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/97eea74cbf81_purposes-8.jpg' => $purpose_image_urls[7] ?? ($landing_image_urls[7] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/dc84ff1836158_review-autor-1.jpg' => $review_image_urls[0] ?? ($landing_image_urls[0] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/f5d8588d1923_review-autor-2.jpg' => $review_image_urls[1] ?? ($landing_image_urls[1] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/e48acee6b1eb3_review-autor-3.jpg' => $review_image_urls[2] ?? ($landing_image_urls[2] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/0585ca918b355_Stepease_worker.jpg' => $review_image_urls[3] ?? ($landing_image_urls[3] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/3e6a94a56376b_Stepease_nurse.jpg' => $review_image_urls[4] ?? ($landing_image_urls[4] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/cc70e89aec408_Stepease_service.jpg' => $review_image_urls[5] ?? ($landing_image_urls[5] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/94b5200db8b78_Stepease_runner.jpg' => $review_image_urls[6] ?? ($landing_image_urls[6] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/3896d617c56ae_Stepease_dog_walker.jpg' => $review_image_urls[0] ?? ($landing_image_urls[7] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/STEPPER%20test-0/d9f0fad94b90a_doctor.jpg' => $review_image_urls[2] ?? ($landing_image_urls[2] ?? $hero_image_url),
            'https://images.hs-plus.com/assets/shared-images/42c652c613426_batch_stepease_cover_SI.jpg' => $landing_image_urls[4] ?? $hero_image_url,
            'https://images.hs-plus.com/assets/STEPPER%20test-0/f5c4995943c42_hero-2.jpg' => $landing_image_urls[5] ?? $hero_image_url,
        );

        $markup = str_replace(array_keys($image_replacements), array_map('esc_url', array_values($image_replacements)), $markup);

        $markup = preg_replace(
            '#<a class="header__logo"[^>]*>.*?</a>#s',
            '<a class="header__logo noriks-landing-logo-link" href="' . esc_url($home_url) . '"><span class="noriks-landing-logo-text">NORIKS</span></a>',
            $markup,
            1
        );

        $markup = preg_replace(
            '#<a class="footer__brand-link"[^>]*>.*?</a>#s',
            '<a class="footer__brand-link noriks-landing-logo-link noriks-landing-logo-link--footer" href="' . esc_url($home_url) . '"><span class="noriks-landing-logo-text noriks-landing-logo-text--footer">NORIKS</span></a>',
            $markup,
            1
        );

        $markup = preg_replace(
            '#</head>#i',
            '<style>.noriks-landing-logo-link{display:inline-flex !important;align-items:center;justify-content:flex-start;text-decoration:none;opacity:1 !important;visibility:visible !important;}.noriks-landing-logo-link--footer{justify-content:flex-start;}.noriks-landing-logo-text{display:inline-block !important;color:#111 !important;font-family:Roboto,sans-serif !important;font-size:33px !important;font-weight:700 !important;letter-spacing:1.75px !important;line-height:1 !important;white-space:nowrap;opacity:1 !important;visibility:visible !important;}.noriks-landing-logo-text--footer{font-size:32px !important;color:#fff !important;}.header__logo-img,.footer__brand-link img,.footer__brand-logo{display:none !important;}</style></head>',
            $markup,
            1
        );

        $markup = preg_replace(
            '#<a class="footer__contacts-link h-dp" href="viber://chat\?number=%2B38651762806">.*?</a>#s',
            '',
            $markup,
            1
        );

        $markup = str_replace(
            array(
                '/cdn-cgi/l/email-protection#c8a1a6aea788bba1e6bbbcadb8ada9bbade6adbd',
                '<span>Po&#x161;ljite e-po&#x161;to na naslov: <strong><span class="__cf_email__" data-cfemail="6f060109002f1c06411c1b0a1f0a0e1c0a410a1a">[email&#160;protected]</span></strong></span>',
                'Copyright &#xA9; 2017 - 2026 Spletna trgovina Stepease',
            ),
            array(
                'mailto:info@noriks.com',
                '<span>Po&#x161;ljite e-po&#x161;to na naslov: <strong>info@noriks.com</strong></span>',
                'Copyright &#xA9; 2017 - 2026 Spletna trgovina NORIKS',
            ),
            $markup
        );

        $related_size_markup = '
                    <div class="related-product-size-options" id="related-product-sizes-rp-0">
                      <span class="related-product-size-label">Velikost:</span>
                      <div class="related-product-size-list">
                        <button type="button" class="related-product-size-button is-selected" data-size="S">S</button>
                        <button type="button" class="related-product-size-button" data-size="M">M</button>
                        <button type="button" class="related-product-size-button" data-size="L">L</button>
                        <button type="button" class="related-product-size-button" data-size="XL">XL</button>
                        <button type="button" class="related-product-size-button" data-size="2XL">2XL</button>
                        <button type="button" class="related-product-size-button" data-size="3XL">3XL</button>
                        <button type="button" class="related-product-size-button" data-size="4XL">4XL</button>
                      </div>
                      <input type="hidden" id="related-product-size-value-rp-0" value="S">
                    </div>
                    <style>
                      [data-tpl="stps"] .related-product-size-options { margin-top: .75rem; }
                      [data-tpl="stps"] .related-product-size-label { display:block; font-weight:700; margin-bottom:.4rem; }
                      [data-tpl="stps"] .related-product-size-list { display:flex; flex-wrap:wrap; gap:.35rem; }
                      [data-tpl="stps"] .related-product-size-button {
                        border: 2px solid #d1d5db;
                        background: #fff;
                        color: #111827;
                        border-radius: .55rem;
                        min-width: 3rem;
                        height: 2.4rem;
                        padding: 0 .65rem;
                        font-weight: 700;
                        font-size: .95rem;
                        line-height: 1;
                        cursor: pointer;
                      }
                      [data-tpl="stps"] .related-product-size-button.is-selected {
                        border-color: #ff5b01;
                        background: #fff3ec;
                        color: #ff5b01;
                      }
                    </style>';

        $markup = str_replace(
            array(
                '<img class="related-product-image" src="https://images.hs-plus.com/product/product-image/67fb0394c5d0a_STEPHEEL-3831127625931-N-1.jpg">',
                '2x blazinica za peto za zmanjšanje bolečin v peti',
                'Zapolni prevelik čevelj, ne da bi drgnila ali povzročala žulje.',
                '3.99&#x20AC;',
                '11.95&#x20AC;',
                'var relatedProductsData = [{"id":"rp-0","name":"2x blazinica za peto za zmanjšanje bolečin v peti","description":"Zapolni prevelik čevelj, ne da bi drgnila ali povzročala žulje.\n","price":3.99,"originalPrice":11.95,"discountPercentage":67,"wcId":981495,"imageUrl":"https://images.hs-plus.com/product/product-image/67fb0394c5d0a_STEPHEEL-3831127625931-N-1.jpg"}];',
            ),
            array(
                '<img class="related-product-image" src="' . esc_url($boxers_image_url) . '" alt="NORIKS bokserice">',
                'NORIKS črne boksarice',
                'Mehke, elastične in udobne boksarice za nošenje ves dan.',
                '7.99&#x20AC;',
                '15.99&#x20AC;',
                'var relatedProductsData = [{"id":"rp-0","name":"NORIKS črne boksarice","description":"Mehke, elastične in udobne boksarice za nošenje ves dan.","price":7.99,"originalPrice":15.99,"discountPercentage":50,"wcId":981495,"imageUrl":"' . esc_js($boxers_image_url) . '"}];',
            ),
            $markup
        );

        $markup = str_replace(
            '<div class="related-product-checkbox-wrapper" id="related-product-checkbox-wrapper-rp-0">',
            $related_size_markup . "\n" . '<div class="related-product-checkbox-wrapper" id="related-product-checkbox-wrapper-rp-0">',
            $markup
        );

        $text_replacements = array(
            'STEPEASE - OrthoStep' => 'NORIKS - NORIKS',
            'Ortopedski vlo&#x17E;ki z masa&#x17E;nimi to&#x10D;kami | STEPEASE' => 'NORIKS MAJICA | NORIKS',
            'Ortopedski vložki z masažnimi točkami | STEPEASE' => 'NORIKS MAJICA | NORIKS',
            'Ortopedski vlo&#x17E;ki z masa&#x17E;nimi to&#x10D;kami' => 'NORIKS majice',
            'Ortopedski vložki z masažnimi točkami' => 'NORIKS majice',
            'STEPEASE&#xA0;|&#xA0;Masa&#x17E;ni vlo&#x17E;ki' => 'NORIKS&#xA0;|&#xA0;Majica',
            'STEPEASE | Masažni vložki' => 'NORIKS | Majica',
            '93% strank je ocenilo Stepease z odličnostjo' => '93% strank je ocenilo NORIKS z odličnostjo',
            '93% strank je ocenilo NORIKS z odličnostjo' => '93% kupaca ocijenilo je NORIKS odličnim',
            'Odli&#x10D;no 4,8&#xA0;|&#xA0;1169&#xA0;ocen' => 'Odlično 4,8 | 1169 ocjena',
            'ocen kupcev' => 'ocjena kupaca',
            'Ali se STEPEASE prilegajo mojim &#x10D;evljem?' => 'Ali mi NORIKS majica odgovara?',
            'Ali se STEPEASE prilegajo mojim čevljem?' => 'Ali mi NORIKS majica odgovara?',
            'Kako dolgo zdr&#x17E;ijo vlo&#x17E;ki STEPEASE?' => 'Kako dolgo traju NORIKS majice?',
            'Kako dolgo zdržijo vložki STEPEASE?' => 'Kako dolgo traju NORIKS majice?',
            'Domov' => 'Početna',
            'Vsi izdelki' => 'Svi proizvodi',
            'Koristne informacije' => 'Koristne informacije',
            'Splo&#x161;ni pogoji poslovanja' => 'Splošni pogoji poslovanja',
            'Splošni pogoji poslovanja' => 'Splošni pogoji poslovanja',
            'Varnostna politika' => 'Varnostna politika',
            'Politika uporabe pi&#x161;kotkov' => 'Politika piškotkov',
            'Politika uporabe piškotkov' => 'Politika piškotkov',
            'Pravica do odstopa od nakupa' => 'Pravica do odstopa od nakupa',
            'Reklamacije in prito&#x17E;be' => 'Reklamacije in pritožbe',
            'Reklamacije in pritožbe' => 'Reklamacije in pritožbe',
            'Menjava v garanciji' => 'Menjava v garanciji',
            'O podjetju' => 'O podjetju',
            'Po&#x161;ljite e-po&#x161;to na naslov:' => 'Pošljite e-pošto na naslov:',
            'Prihranite' => 'Uštedite',
            'Ponudba kmalu pote&#x10D;e' => 'Ponudba kmalu poteče',
            'Ponudba kmalu poteče' => 'Ponudba kmalu poteče',
            'Spoznaj vlo&#x17E;ke STEPEASE &#x2013; popolno udobje za tvoja stopala.' => 'Spoznaj NORIKS majico za vsakodnevno udobje.',
            'Spoznaj vložke STEPEASE – popolno udobje za tvoja stopala.' => 'Spoznaj NORIKS majico za vsakodnevno udobje.',
            '✔ Takojšnje olajšanje ✔ Klinično preizkušeno ✔ Priporočajo podiatri' => '✔ Udoben kroj ✔ Kakovostna izdelava ✔ NORIKS stil',
            '✔ Takoj&#x161;nje olaj&#x161;anje ✔ Klini&#x10D;no preizku&#x161;eno ✔ Priporo&#x10D;ajo podiatri' => '✔ Udoben kroj ✔ Kakovostna izdelava ✔ NORIKS stil',
            'Poglejte, kako drugi' => 'Poglejte, kako drugi',
            'Resni&#x10D;ne ocene resni&#x10D;nih uporabnikov' => 'Resnične ocene resničnih kupcev',
            'Resnične ocene resničnih uporabnikov' => 'Resnične ocene resničnih kupcev',
            'Razlika, ki jo prina&#x161;a <span class="accent">STEPEASE</span>' => 'Razlika, ki jo prinaša <span class="accent">NORIKS</span>',
            'Razlika, ki jo prinaša <span class="accent">STEPEASE</span>' => 'Razlika, ki jo prinaša <span class="accent">NORIKS</span>',
            'Razlika, ki jo prinaša' => 'Razlika, ki jo prinaša',
            'Poglejte, kako drugi <span class="accent">obu&#x17E;ujejo svoje vlo&#x17E;ke STEPEASE</span>' => 'Poglejte, kako drugi <span class="accent">nose svoju NORIKS majicu</span>',
            'Poglejte, kako drugi <span class="accent">obužujejo svoje vložke STEPEASE</span>' => 'Poglejte, kako drugi <span class="accent">nose svoju NORIKS majicu</span>',
            'Kaj dela STEPEASE tako <span class="accent">posebne</span>?' => 'Kaj dela NORIKS tako <span class="accent">posebno</span>?',
            'Kaj dela NORIKS tako <span class="accent">posebnim</span>?' => 'Kaj dela NORIKS tako <span class="accent">posebno</span>?',
            'Odkrijte, zakaj <span class="accent">strokovnjaki priporo&#x10D;ajo</span> STEPEASE' => 'Odkrijte, zakaj <span class="accent">kupci priporočajo</span> NORIKS',
            'Odkrijte, zakaj <span class="accent">strokovnjaki priporočajo</span> STEPEASE' => 'Odkrijte, zakaj <span class="accent">kupci priporočajo</span> NORIKS',
            'Odkrijte, zakaj <span class="accent">kupci priporočajo</span> NORIKS' => 'Odkrijte, zakaj <span class="accent">kupci priporočajo</span> NORIKS',
            'Spletna trgovina Stepease' => 'Spletna trgovina NORIKS',
            'var brand = \'Stepease\';' => 'var brand = \'NORIKS\';',
            'var brandSettings = {"name":"Stepease"};' => 'var brandSettings = {"name":"NORIKS"};',
            'OrthoStep &raquo; STEPEASE Vir komentarjev' => 'NORIKS &raquo; NORIKS Vir ocen',
            'name":"STEPEASE"' => 'name":"NORIKS"',
            'name":"STEPEASE - OrthoStep"' => 'name":"NORIKS - NORIKS"',
            'Ve&#x10D; kot 200&#xA0;000 zadovoljnih strank' => 'Več kot 200 000 zadovoljnih kupcev',
            'Več kot 200 000 zadovoljnih strank' => 'Več kot 200 000 zadovoljnih kupcev',
            'Sledenje po&#x161;iljki z zavarovano dostavo' => 'Sledenje pošiljki z zavarovano dostavo',
            'Sledenje pošiljki z zavarovano dostavo' => 'Sledenje pošiljki z zavarovano dostavo',
            '90-dnevno jamstvo za vra&#x10D;ilo denarja' => '90-dnevno jamstvo za vračilo denarja',
            'Pravilna opora loka spodbuja bolj&#x161;o poravnavo hrbtenice.' => 'Dobro krojena majica poskrbi za čistejši videz in boljšo silhueto.',
            'Pove&#x10D;ajte zmogljivost' => 'Povečajte vtis',
            'Povečajte zmogljivost' => 'Povečajte vtis',
            'Enostavno pranje' => 'Enostavno vzdrževanje',
            'Ro&#x10D;no operite z milom in vodo.' => 'Perite po navodilih za dolgotrajno kakovost.',
            'Izstopajte iz mno&#x17E;ice' => 'Izstopajte iz množice',
            'Izstopajte iz množice' => 'Izstopajte iz množice',
            'Ogled znamenitosti' => 'Razgledavanje',
            'Dolge izmene' => 'Duge smjene',
            'Dostava in po&#x161;iljanje' => 'Dostava in pošiljanje',
            'Dostava in pošiljanje' => 'Dostava in pošiljanje',
            'Politika vra&#x10D;il in povra&#x10D;il' => 'Politika vračil in povračil',
            'Politika vračil in povračil' => 'Politika vračil in povračil',
            'Popust za razli&#x10D;ne velikosti' => 'Popust za različne velikosti',
            'Popust za različne velikosti' => 'Popust za različne velikosti',
            'Na&#x161; popust lahko uporabite tudi za razli&#x10D;ne barve in velikosti!' => 'Naš popust lahko uporabite tudi za različne barve in velikosti!',
            'Postopek:' => 'Postupak:',
            'Dodajte eno velikost v ko&#x161;arico.' => 'Dodajte jednu veličinu u košaricu.',
            'Dodajte &#x161;e drugo velikost v ko&#x161;arico.' => 'Dodajte še eno velikost v košarico.',
            'Popust za 2,&#xA0;3&#xA0;ali&#xA0;5&#xA0;parov se bo samodejno obra&#x10D;unal pri skupni ceni.' => 'Popust za 2, 3 ali 5 kosov se bo samodejno obračunal pri skupni ceni.',
            'U&#x17E;ivajte v sledenju po&#x161;iljke z zavarovano dostavo v <strong>2&#x2013;3&#xA0;delovnih dneh.</strong> Za va&#x161;e udobje bo prilo&#x17E;ena &#x161;tevilka za sledenje.' => 'Uživajte u praćenju pošiljke s osiguranom dostavom u <strong>2–3 radna dana.</strong> Radi vaše sigurnosti bit će priložen broj za praćenje.',
            'Prepri&#x10D;ani smo, da vam bo udobje vlo&#x17E;kov STEPEASE v&#x161;e&#x10D;. Zato ponujamo 90&#x2011;dnevno garancijo vra&#x10D;ila denarja brez tveganja. &#x10C;e ne boste popolnoma zadovoljni, nam preprosto pi&#x161;ite in uredili bomo vra&#x10D;ilo.' => 'Prepričani smo, da vam bo udobje NORIKS majic všeč. Zato ponujamo 90-dnevno garancijo vračila denarja brez tveganja. Če ne boste popolnoma zadovoljni, nam preprosto pišite in uredili bomo vračilo.',
            'Olaj&#x161;aj</span> bole&#x10D;ine v stopalih' => 'Istakni</span> svoj stil',
            'Olajšaj</span> bolečine v stopalih' => 'Istakni</span> svoj stil',
            'Prihodnost je </span>brez bole&#x10D;in v stopalih' => 'Prihodnost je </span>v NORIKS majicah',
            'Prihodnost je </span>brez bolečin v stopalih' => 'Prihodnost je </span>v NORIKS majicah',
            'Poskrbite za svoja stopala <span class="accent">&#x161;e danes</span>!' => 'Izberi svojo NORIKS majico <span class="accent">še danes</span>!',
            'Poskrbite za svoja stopala <span class="accent">še danes</span>!' => 'Izberi svojo NORIKS majico <span class="accent">še danes</span>!',
            'Ne glede na to, ali ste zaposlen strokovnjak ali &#x161;portnik, ki premika svoje meje &#x2013; ortopedski vlo&#x17E;ki z masa&#x17E;nimi to&#x10D;kami STEPEASE vam zagotavljajo vrhunsko oporo in olaj&#x161;anje. Vzemite si trenutek zase, vlo&#x17E;ite v udobje in ob&#x10D;utite razliko na lastnih stopalih.' => 'Bez obzira trebaš li majicu za svaki dan ili za poseban outfit, NORIKS majice donose udobnost, bolji fit i sigurniji izgled. Uzmi trenutak za sebe i odaberi model koji ti najbolje pristaje.',
            'Ne glede na to, ali ste zaposlen strokovnjak ali športnik, ki premika svoje meje – ortopedski vložki z masažnimi točkami STEPEASE vam zagotavljajo vrhunsko oporo in olajšanje. Vzemite si trenutek zase, vložite v udobje in občutite razliko na lastnih stopalih.' => 'Bez obzira trebaš li majicu za svaki dan ili za poseban outfit, NORIKS majice donose udobnost, bolji fit i sigurniji izgled. Uzmi trenutak za sebe i odaberi model koji ti najbolje pristaje.',
            'Preizkusite spremembo na lastnih stopalih in zakorakajte v svetlej&#x161;o, nebole&#x10D;o prihodnost &#x17E;e danes.' => 'Preizkusite razliko na sebi in odkrijte, kako dobra majica lahko spremeni celoten videz.',
            'Preizkusite spremembo na lastnih stopalih in zakorakajte v svetlejšo, nebolečo prihodnost že danes.' => 'Preizkusite razliko na sebi in odkrijte, kako dobra majica lahko spremeni celoten videz.',
            'Obvladovanje zdravja stopal: Va&#x161; vodnik do sre&#x10D;nih stopal' => 'NORIKS vodič: kako izbrati pravo majico za svoj stil',
            'Obvladovanje zdravja stopal: Vaš vodnik do srečnih stopal' => 'NORIKS vodič: kako izbrati pravo majico za svoj stil',
            'Celovito znanje o stopalih' => 'Savjeti za bolji fit majice',
            'Uporaba tehnik zdravljenja stopal' => 'Kako kombinirati NORIKS majice',
            'Celotno dobro po&#x10D;utje stopal' => 'Udobnost i stil kroz cijeli dan',
            'Celotno dobro počutje stopal' => 'Udobnost i stil kroz cijeli dan',
            'Podpora loka stopala' => 'Moderan kroj',
            'Kako dolgo zdr&#x17E;ijo vlo&#x17E;ki?' => 'Kako dugo traju NORIKS majice?',
            'Kako dolgo zdržijo vložki?' => 'Kako dugo traju NORIKS majice?',
            'Priporo&#x10D;ajo podiatri' => 'Omiljen izbor kupaca',
            'Priporočajo podiatri' => 'Omiljen izbor kupaca',
            'strokovnjaki priporo&#x10D;ajo' => 'kupci preporučuju',
            'strokovnjaki priporočajo' => 'kupci preporučuju',
            'Dolga leta sem se spopadal s plantarno fascio, a STEPEASE so vse spremenili. Podpora loku je neverjetna in bole&#x10D;ina je kon&#x10D;no izginila!' => 'Dugo sam tražio majicu koja mi stvarno dobro stoji, a NORIKS je konačno pogodio pravi kroj. Odmah se vidi razlika u izgledu i udobnosti.',
            'V slu&#x17E;bi ves dan stojim in ti vlo&#x17E;ki so mi re&#x161;ili noge. Ob koncu dneva me stopala ne bolijo ve&#x10D;.' => 'Majicu nosim cijeli dan na poslu i stvarno ostaje udobna od jutra do večeri. Kroj stoji odlično i nakon dugog dana izgleda uredno.',
            'Preizkusil sem ne&#x161;teto vlo&#x17E;kov, a nobeni se ne morejo primerjati s&#xA0;STEPEASE. Razlika v udobju in po&#x10D;utju je res opazna.' => 'Preizkusil sem veliko navadnih majic, a NORIKS je daleč nad vsem, kar sem nosil prej. Material, kroj in občutek na telesu so takoj opazni.',
            'Svoje dni pre&#x17E;ivim na betonskih tleh v delovnih &#x10D;evljih s kovinsko kapico. Ortopedski vlo&#x17E;ki z masa&#x17E;nimi to&#x10D;kami | STEPEASE odli&#x10D;no bla&#x17E;ijo udarce in nudijo podporo, kar zmanj&#x161;uje obremenitev stopal in sklepov. Presene&#x10D;en sem, koliko so mi pomagali &#x2013; o njih sem povedal vsem sodelavcem.' => 'Opravljam zahtevno delo in potrebujem oblačila, ki izgledajo dobro tudi po dolgem dnevu. NORIKS majica drži formo, je udobna za nošenje in izgleda dovolj dobro, da sem jo priporočil tudi sodelavcem.',
            'Kot medicinska sestra sem ves dan na nogah. Ko sem jih prvi&#x10D; vstavila, sem takoj za&#x10D;utila razliko. Podpora loka je odli&#x10D;na in prina&#x161;a prepotrebno olaj&#x161;anje. Mehka blazina popolno ubla&#x17E;i stalne pritiske na stopala.' => 'Kot medicinska sestra potrebujem oblačila, ki so udobna in zanesljiva cel dan. NORIKS majica je mehka, dobro sede in resnično izgleda odlično tudi po dolgi izmeni.',
            'Vau, ti vlo&#x17E;ki so presegli vsa moja pri&#x10D;akovanja! Po dveh dneh no&#x161;enja med 12-urnimi izmenami sem ugotovil, da so resni&#x10D;no izjemni. So izredno udobni, nudijo oporo ves dan &#x2013; naro&#x10D;il sem &#x161;e dva para!' => 'Ta majica je presegla moja pričakovanja. Po nekaj dolgih dneh nošenja mi je bilo jasno, da želim še več kosov, zato sem takoj naročil dodatne barve.',
            'Sem predan teka&#x10D; in preizkusil sem &#x17E;e veliko vlo&#x17E;kov. Odkar uporabljam ortopedske vlo&#x17E;ke z masa&#x17E;nimi to&#x10D;kami STEPEASE, opa&#x17E;am bolj&#x161;o zmogljivost in hitrej&#x161;e okrevanje. Toplo priporo&#x10D;am vsem teka&#x10D;em, ki &#x17E;elijo izbolj&#x161;ati rezultate in za&#x161;&#x10D;ititi svoja stopala.' => 'Aktiven sem in rad nosim oblačila, ki izgledajo čisto in športno, a hkrati dovolj resno za vsak dan. NORIKS majica mi je postala prva izbira, ker odlično izgleda in se zlahka kombinira.',
            'Moji vsakodnevni sprehodi s psom so zdaj povsem druga&#x10D;ni. Prej sem imela bole&#x10D;a stopala in utrujene noge, zdaj pa brez te&#x17E;av sledim svojemu kosmatincu. Ortopedski vlo&#x17E;ki z masa&#x17E;nimi to&#x10D;kami STEPEASE nudijo odli&#x10D;no oporo, udobje in izbolj&#x161;ajo dr&#x17E;o.' => 'NORIKS majico nosim za šetnje, obaveze i kavu u gradu. Udobna je, lijepo pada i uvijek izgleda dovoljno sređeno bez puno razmišljanja.',
            'Ortopedski vlo&#x17E;ki' => 'Majica',
            'Ortopedski vložki' => 'Majica',
            'vlo&#x17E;ki' => 'majice',
            'Vlo&#x17E;ki' => 'Majice',
            'vložki' => 'majice',
            'Vložki' => 'Majice',
            'stopal' => 'majic',
            'stopala' => 'majice',
            'Stopala' => 'Majice',
            'čevljem' => 'stilu',
            'čevljih' => 'kombinacijama',
            'čevlje' => 'outfite',
            'Čevlje' => 'Outfite',
            'čevlji' => 'outfiti',
            'podiatri' => 'kupci',
            'podologi' => 'kupci',
            'podolog' => 'kupac',
            'peto' => 'majicu',
            'peti' => 'majici',
            'blazinica' => 'majica',
            'blazinice' => 'majice',
            'Skladi&#x161;&#x10D;e v Sloveniji' => 'Skladište u Hrvatskoj',
            'Skladišče v Sloveniji' => 'Skladište u Hrvatskoj',
            'Slovensko skladi&#x161;&#x10D;e' => 'Hrvatsko skladište',
            'Slovensko skladišče' => 'Hrvatsko skladište',
            'Spletna trgovina NORIKS' => 'Spletna trgovina NORIKS',
            'Vir komentarjev' => 'Vir ocen',
            '<span> StepEase </span>' => '<span> NORIKS </span>',
            'StepEase' => 'NORIKS',
        );

        $markup = str_replace(array_keys($text_replacements), array_values($text_replacements), $markup);

        return $markup;
    }
}

$target_product_url = get_post_meta(get_the_ID(), '_landigs_target_product_url', true);
$target_product_id  = (int) get_post_meta(get_the_ID(), '_landigs_target_product_id', true);
$boxers_image_url   = 'https://noriks.com/si/wp-content/uploads/2025/11/boksarice_3x_crne-600x600.png';
$hero_image_url     = trailingslashit(get_template_directory_uri()) . 'assets/images/landigs/noriks-majice-garancija.jpg';
$landing_image_urls = array(
    trailingslashit(get_template_directory_uri()) . 'assets/images/landigs/noriks-shirt-1.jpg',
    trailingslashit(get_template_directory_uri()) . 'assets/images/landigs/noriks-shirt-2.jpg',
    trailingslashit(get_template_directory_uri()) . 'assets/images/landigs/noriks-shirt-3.jpg',
    trailingslashit(get_template_directory_uri()) . 'assets/images/landigs/noriks-shirt-4.jpg',
    trailingslashit(get_template_directory_uri()) . 'assets/images/landigs/noriks-shirt-5.jpg',
    trailingslashit(get_template_directory_uri()) . 'assets/images/landigs/noriks-shirt-6.jpg',
    trailingslashit(get_template_directory_uri()) . 'assets/images/landigs/noriks-shirt-7.jpg',
    trailingslashit(get_template_directory_uri()) . 'assets/images/landigs/noriks-shirt-8.png',
);
$review_image_urls = array(
    'https://noriks.com/si/wp-content/themes/noriks/auto_reviews/majice-slike/Generated%20Image%20January%2019%2C%202026%20-%2010_41AM.jpeg',
    'https://noriks.com/si/wp-content/themes/noriks/auto_reviews/majice-slike/Generated%20Image%20January%2019%2C%202026%20-%2010_39AM.jpeg',
    'https://noriks.com/si/wp-content/themes/noriks/auto_reviews/majice-slike/Generated%20Image%20January%2019%2C%202026%20-%2010_29AM.jpeg',
    'https://noriks.com/si/wp-content/themes/noriks/auto_reviews/majice-slike/Generated%20Image%20January%2019%2C%202026%20-%2010_30AM%20%281%29.jpeg',
    'https://noriks.com/si/wp-content/themes/noriks/auto_reviews/majice-slike/Generated%20Image%20January%2019%2C%202026%20-%2010_45AM.jpeg',
    'https://noriks.com/si/wp-content/themes/noriks/auto_reviews/majice-slike/Generated%20Image%20January%2019%2C%202026%20-%2010_52AM.jpeg',
    'https://noriks.com/si/wp-content/themes/noriks/auto_reviews/majice-slike/Generated%20Image%20January%2019%2C%202026%20-%2010_50AM.jpeg',
);
$purpose_image_urls = array(
    'https://noriks.com/si/wp-content/uploads/2025/11/crna-in-siva-majica-vse-barve-gat-bundle-600x600.png',
    'https://noriks.com/si/wp-content/uploads/2025/11/crna-in-modra-majica-vse-barve-gat-bundle-600x600.png',
    'https://noriks.com/si/wp-content/uploads/2025/11/crna-in-bela-majica-vse-barve-gat-bundle-600x600.png',
    'https://noriks.com/si/wp-content/uploads/2025/11/bela-in-siva-majica-vse-barve-gat-bundle-600x600.png',
    'https://noriks.com/si/wp-content/uploads/2025/09/monochrome-3x-600x600.jpg',
    'https://noriks.com/si/wp-content/uploads/2025/09/city-6x-600x600.jpg',
    'https://noriks.com/si/wp-content/uploads/2025/09/everyday-6X-600x600.jpg',
    'https://noriks.com/si/wp-content/uploads/2025/09/urban-earth-6x-600x600.jpg',
);

if (!$target_product_url) {
    $target_product_url = home_url('/si/product/noriks-majica/');
}

if (!$target_product_id) {
    $target_product_id = 3421;
}

$primary_label     = get_post_meta(get_the_ID(), '_landigs_primary_label', true);
$primary_options   = get_post_meta(get_the_ID(), '_landigs_primary_options', true);
$secondary_label   = get_post_meta(get_the_ID(), '_landigs_secondary_label', true);
$secondary_options = get_post_meta(get_the_ID(), '_landigs_secondary_options', true);
$hide_secondary    = get_post_meta(get_the_ID(), '_landigs_hide_secondary', true);
$offer_options     = get_post_meta(get_the_ID(), '_landigs_offer_options', true);

if ($primary_label === '') {
    $primary_label = 'Barva';
}

if ($secondary_label === '') {
    $secondary_label = 'Velikost';
}

if ($secondary_options === '') {
    $secondary_options = implode("\n", array(
        'S',
        'M',
        'L',
        'XL',
        'XXL',
        '3XL',
        '4XL',
    ));
}

if (noriks_landigs_use_apparel_sizes($secondary_options)) {
    $secondary_options = implode("\n", array(
        'S',
        'M',
        'L',
        'XL',
        'XXL',
        '3XL',
        '4XL',
    ));
}

if ($primary_options === '') {
    $primary_options = implode("\n", array(
        'Crna|#000000',
        'Bijela|#f3f4f6',
        'Siva|#9ca3af',
        'Tamnoplava|#203240',
        'Smeđa|#6b4f3a',
        'Zelena|#556b2f',
    ));
}

if ($offer_options === '') {
    $offer_options = implode("\n", array(
        '1|1 majica|Odličen začetni paket|',
        '2|2 majice|Najbolji omjer cijene i količine|NAJPOPULARNIJE',
        '3|3 majice|Največji prihranek na kos|',
        '5|5 majic|Največji paket za največji prihranek|',
    ));
}

if (!file_exists($source_path)) {
    status_header(500);
    wp_die(esc_html__('Step landing source template is missing.', 'textdomain'));
}

$source_markup = file_get_contents($source_path);
$sku_matches   = array();
preg_match_all('/"sku":"([^"]+)"/', $source_markup, $sku_matches);
$skus          = array_values(array_unique($sku_matches[1] ?? array()));

$sku_map           = array();
$variation_map     = array();
$current_product   = 0;

if (function_exists('wc_get_product_id_by_sku')) {
    foreach ($skus as $sku) {
        $product_id = wc_get_product_id_by_sku($sku);
        if (!$product_id) {
            continue;
        }

        $product = wc_get_product($product_id);
        if (!$product || !$product->is_type('variation')) {
            continue;
        }

        if (!$current_product) {
            $current_product = (int) $product->get_parent_id();
        }

        $sku_map[$sku] = array(
            'id' => (int) $product->get_id(),
            'b'  => (string) $product->get_attribute('pa_barva'),
            'v'  => (string) $product->get_attribute('pa_velikost'),
        );
    }
}

$configured_product = $target_product_id ? wc_get_product($target_product_id) : null;

if ($configured_product && $configured_product->is_type('variable')) {
    $current_product = (int) $configured_product->get_id();

    foreach ($configured_product->get_children() as $variation_id) {
        $variation = wc_get_product($variation_id);
        if (!$variation || !$variation->is_type('variation')) {
            continue;
        }

        $color_slug = (string) $variation->get_attribute('pa_barva');
        $size_slug  = (string) $variation->get_attribute('pa_velikost');
        $color_name = $color_slug;
        $size_name  = $size_slug;

        if ($color_slug) {
            $color_term = get_term_by('slug', $color_slug, 'pa_barva');
            if ($color_term && !is_wp_error($color_term)) {
                $color_name = $color_term->name;
            }
        }

        if ($size_slug) {
            $size_term = get_term_by('slug', $size_slug, 'pa_velikost');
            if ($size_term && !is_wp_error($size_term)) {
                $size_name = $size_term->name;
            }
        }

        $variation_map[] = array(
            'id'         => (int) $variation->get_id(),
            'product_id' => (int) $current_product,
            'barva'      => $color_slug,
            'velikost'   => $size_slug,
            'barvaLabel' => $color_name,
            'sizeLabel'  => $size_name,
            'attributes' => array_map('strval', $variation->get_variation_attributes()),
        );
    }
}

$is_simple_product = !($configured_product && $configured_product->is_type('variable'));

$runtime_config = array(
    'landingUrl'       => $landing_url,
    'cartUrl'          => $cart_url,
    'homeUrl'          => $home_url,
    'productId'        => $target_product_id ?: $current_product,
    'targetProductUrl' => $target_product_url,
    'simpleProduct'    => $is_simple_product,
    'skuMap'           => $sku_map,
    'variationMap'     => $variation_map,
    'reviewFeedImages' => $review_image_urls,
    'optionGroups'     => array(
        'primary' => array(
            'label'   => $primary_label,
            'options' => noriks_parse_landigs_visual_options($primary_options, 'primary'),
        ),
        'secondary' => array(
            'label'   => $secondary_label,
            'options' => noriks_parse_landigs_visual_options($secondary_options, 'secondary'),
            'hidden'  => $hide_secondary === '1' ? true : false,
        ),
    ),
    'offers'           => noriks_ensure_default_landing_offers(noriks_parse_landigs_offer_options($offer_options)),
);

$sidecart_assets = noriks_get_sidecart_assets_markup();

$runtime_script = sprintf(
    '<script>window.dataLayer = window.dataLayer || []; window.noriksStepLandingConfig = %s; document.documentElement.classList.add("noriks-landings-pending");</script>' . "\n" .
    '<script src="%s?v=1.0"></script>',
    wp_json_encode($runtime_config),
    esc_url($asset_base_url . '/step-landing.js')
);

$legacy_wc_fix_tag       = sprintf('<script src="%s/wc-atc-fix.js?v=1.0"></script>', get_template_directory_uri());
$legacy_homepage_fix_tag = '<script src="/wp-content/themes/ortostep/homepage-atc-fix.js?v=1.0"></script>';
$legacy_orto_wc_fix_tag  = '<script type="text/javascript" src="https://ortowp.noriks.com/wp-content/themes/ortostep/wc-atc-fix.js?ver=1.0" id="wc-atc-fix-js"></script>';

ob_start();
include $source_path;
$markup = ob_get_clean();

$markup = preg_replace('#<script>\s*\(function\(w,d,s,l,i\)\{w\[l\]=w\[l\]\|\|\[\];w\[l\]\.push\(\{\'gtm\.start\':.*?</script>#s', '', $markup);
$markup = preg_replace('#<script>\s*!function\(t,e\)\{var o,n,p,r;.*?posthog\.init\(.*?</script>#s', '', $markup);
$markup = preg_replace('#<noscript><iframe src="https://www\.googletagmanager\.com/ns\.html\?id=GTM-KXS52LF".*?</iframe></noscript>#s', '', $markup);
$markup = preg_replace('#<script type="text/javascript" src="https://ortowp\.noriks\.com/wp-content/plugins/woocommerce/assets/js/sourcebuster/sourcebuster\.min\.js\?ver=[^"]*" id="sourcebuster-js-js"></script>#', '', $markup);
$markup = preg_replace('#<script type="text/javascript" id="wc-order-attribution-js-extra">.*?</script>#s', '', $markup);
$markup = preg_replace('#<script type="text/javascript" src="https://ortowp\.noriks\.com/wp-content/plugins/woocommerce/assets/js/frontend/order-attribution\.min\.js\?ver=[^"]*" id="wc-order-attribution-js"></script>#', '', $markup);

$markup = noriks_customize_step_landing_markup($markup, $landing_url, $cart_url, $home_url, $boxers_image_url, $hero_image_url, $landing_image_urls, $review_image_urls, $purpose_image_urls);

$markup = preg_replace('/<html\b([^>]*)>/', '<html$1 class="noriks-landings-pending">', $markup, 1);

$landing_override_styles = noriks_get_landing_override_styles();

if (strpos($markup, '</head>') !== false) {
    $markup = str_replace('</head>', $landing_override_styles . "\n" . $sidecart_assets['head'] . "\n</head>", $markup);
} else {
    $markup = $landing_override_styles . $sidecart_assets['head'] . $markup;
}

$markup = str_replace(
    array(
        $legacy_wc_fix_tag . "\n" . $legacy_homepage_fix_tag,
        $legacy_wc_fix_tag,
        $legacy_homepage_fix_tag,
        $legacy_orto_wc_fix_tag,
    ),
    array(
        '',
        '',
        '',
        '',
    ),
    $markup
);

if (strpos($markup, '</body>') !== false) {
    $markup = str_replace('</body>', $sidecart_assets['body'] . "\n" . $runtime_script . "\n</body>", $markup);
} else {
    $markup .= $sidecart_assets['body'] . $runtime_script;
}

echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
