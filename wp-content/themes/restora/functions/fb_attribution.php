<?php
/**
 * NORIKS — FB / UTM Attribution Capture for Abandoned Carts
 *
 * Pobere FB campaign + UTM parametre iz URL-ja / cookieov in jih shrani
 * v cartflows_ca_cart_abandonment.other_fields (kot noriks_fb_* keys).
 *
 * Vir podatkov:
 *   1) URL query params: fbclid, utm_*, campaignID, adID, adSetID
 *   2) Cookieji: _fbc, _fbp, wc_order_attribution_utm_*
 *
 * Flow:
 *   A) JS na checkout intercepta jQuery AJAX za "cartflows_save_cart_abandonment_data"
 *      in priloži noriks_* polja iz URL/cookies.
 *   B) PHP filter "wcar_cart_default_other_fields" pobere $_POST['noriks_*']
 *      in jih doda v other_fields array (serializan v DB).
 *   C) REST endpoint /noriks/v1/abandoned-carts izlušči fb_campaign struct
 *      na vrhu vsakega cart-a (CallBoss-friendly).
 *
 * @package Noriks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Vse "noriks_*" keys ki jih sprejmemo iz $_POST in vpišemo v other_fields.
 *
 * @return array
 */
function noriks_fb_allowed_keys() {
	return [
		'noriks_fbclid',
		'noriks_fbp',
		'noriks_fbc',
		'noriks_utm_campaign',
		'noriks_utm_id',
		'noriks_utm_source',
		'noriks_utm_medium',
		'noriks_utm_content',
		'noriks_utm_term',
		'noriks_campaign_id',
		'noriks_ad_id',
		'noriks_adset_id',
		'noriks_landing_url',
		'noriks_referrer',
	];
}

/**
 * (A) JS prestrezalec — priloži FB params k CartFlows AJAX-u.
 * Naloži se samo na checkout / cart strani.
 */
add_action( 'wp_footer', function () {
	if ( ! function_exists( 'is_checkout' ) || ! function_exists( 'is_cart' ) ) {
		return;
	}
	if ( ! ( is_checkout() || is_cart() ) ) {
		return;
	}
	?>
<script id="noriks-fb-attribution">
(function() {
	'use strict';
	if (typeof jQuery === 'undefined') return;

	var STORAGE_KEY = 'noriks_fb_attr';
	var COOKIE_DAYS = 30;

	function readCookie(name) {
		var m = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/[-.+*]/g, '\\$&') + '=([^;]*)'));
		return m ? decodeURIComponent(m[1]) : '';
	}

	function writeCookie(name, value, days) {
		try {
			var d = new Date();
			d.setTime(d.getTime() + (days * 86400000));
			document.cookie = name + '=' + encodeURIComponent(value) + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
		} catch (e) {}
	}

	function readStorage() {
		try {
			var raw = localStorage.getItem(STORAGE_KEY);
			return raw ? JSON.parse(raw) : null;
		} catch (e) { return null; }
	}

	function writeStorage(obj) {
		try { localStorage.setItem(STORAGE_KEY, JSON.stringify(obj)); } catch (e) {}
	}

	function collectFromUrl() {
		var p = new URLSearchParams(window.location.search);
		var get = function(k) { return p.get(k) || ''; };
		return {
			fbclid:       get('fbclid'),
			utm_campaign: get('utm_campaign'),
			utm_id:       get('utm_id'),
			utm_source:   get('utm_source'),
			utm_medium:   get('utm_medium'),
			utm_content:  get('utm_content'),
			utm_term:     get('utm_term'),
			campaign_id:  get('campaignID') || get('campaign_id'),
			ad_id:        get('adID')       || get('ad_id'),
			adset_id:     get('adSetID')    || get('adset_id'),
		};
	}

	function collectFromCookies() {
		return {
			fbc:          readCookie('_fbc'),
			fbp:          readCookie('_fbp'),
			utm_campaign: readCookie('wc_order_attribution_utm_campaign'),
			utm_source:   readCookie('wc_order_attribution_utm_source'),
			utm_medium:   readCookie('wc_order_attribution_utm_medium'),
			utm_content:  readCookie('wc_order_attribution_utm_content'),
			utm_term:     readCookie('wc_order_attribution_utm_term'),
		};
	}

	/**
	 * Združi URL + cookie + prej-shranjeno (URL ima prednost).
	 * Shrani v localStorage + lasten cookie da preživi navigacijo.
	 */
	function buildAttribution() {
		var stored = readStorage() || {};
		var fromUrl = collectFromUrl();
		var fromCookie = collectFromCookies();

		var merged = {};
		// Prioriteta: URL > cookie > stored
		[stored, fromCookie, fromUrl].forEach(function(src) {
			Object.keys(src || {}).forEach(function(k) {
				if (src[k]) merged[k] = src[k];
			});
		});

		// Še landing URL + referrer (ob prvem obisku)
		if (!merged.landing_url) {
			merged.landing_url = stored.landing_url || (window.location.origin + window.location.pathname + window.location.search);
		}
		if (!merged.referrer) {
			merged.referrer = stored.referrer || document.referrer || '';
		}

		// Persist
		writeStorage(merged);
		return merged;
	}

	function buildPostFields(attr) {
		var map = {
			noriks_fbclid:       attr.fbclid,
			noriks_fbc:          attr.fbc,
			noriks_fbp:          attr.fbp,
			noriks_utm_campaign: attr.utm_campaign,
			noriks_utm_id:       attr.utm_id,
			noriks_utm_source:   attr.utm_source,
			noriks_utm_medium:   attr.utm_medium,
			noriks_utm_content:  attr.utm_content,
			noriks_utm_term:     attr.utm_term,
			noriks_campaign_id:  attr.campaign_id || attr.utm_campaign || attr.utm_id,
			noriks_ad_id:        attr.ad_id       || attr.utm_content,
			noriks_adset_id:     attr.adset_id    || attr.utm_term,
			noriks_landing_url:  attr.landing_url,
			noriks_referrer:     attr.referrer,
		};
		var pairs = [];
		Object.keys(map).forEach(function(k) {
			if (map[k]) {
				pairs.push(encodeURIComponent(k) + '=' + encodeURIComponent(map[k]));
			}
		});
		return pairs.join('&');
	}

	// Inicializiraj attribution (zajame in shrani podatke že ob loadu strani)
	var attribution = buildAttribution();

	// jQuery AJAX intercept: priloži k CartFlows save klicu
	jQuery(document).ajaxSend(function(_event, _xhr, settings) {
		try {
			var body = settings.data;
			if (!body || typeof body !== 'string') return;
			if (body.indexOf('action=cartflows_save_cart_abandonment_data') === -1) return;

			var extra = buildPostFields(attribution);
			if (!extra) return;

			settings.data = body + '&' + extra;
		} catch (e) {
			// silent
		}
	});

	// fetch() intercept (block-based checkout uporablja fetch namesto jQuery)
	if (window.fetch && !window.__noriks_fetch_patched) {
		window.__noriks_fetch_patched = true;
		var origFetch = window.fetch;
		window.fetch = function(input, init) {
			try {
				var url = (typeof input === 'string') ? input : (input && input.url) || '';
				var body = init && init.body;
				var isCartflows = false;
				if (typeof body === 'string' && body.indexOf('cartflows_save_cart_abandonment_data') !== -1) {
					isCartflows = true;
				} else if (url && url.indexOf('cartflows_save_cart_abandonment_data') !== -1) {
					isCartflows = true;
				}
				if (isCartflows) {
					var extra = buildPostFields(attribution);
					if (extra) {
						if (typeof body === 'string') {
							init.body = body + '&' + extra;
						}
					}
				}
			} catch (e) {}
			return origFetch.apply(this, arguments);
		};
	}
})();
</script>
	<?php
}, 99 );

/**
 * (B) PHP filter — vstavi noriks_* polja iz $_POST v other_fields.
 *
 * Hook: wcar_cart_default_other_fields (CartFlows plugin)
 *
 * @param array $other_fields Default other_fields array.
 * @return array
 */
add_filter( 'wcar_cart_default_other_fields', function ( $other_fields ) {
	$allowed = noriks_fb_allowed_keys();
	foreach ( $allowed as $key ) {
		if ( isset( $_POST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$value = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
			// Razumno omeji dolžino (URL-ji so lahko dolgi, fbclid ~200, ostalo krajše)
			if ( is_string( $value ) ) {
				$value = substr( $value, 0, 500 );
				$other_fields[ $key ] = sanitize_text_field( $value );
			}
		}
	}
	return $other_fields;
}, 10, 1 );

/**
 * (C) Helper: iz other_fields zgradi normaliziran fb_campaign struct.
 * Uporablja se v REST endpointu /noriks/v1/abandoned-carts.
 *
 * @param array $other_fields Unserialized other_fields.
 * @return array
 */
function noriks_build_fb_campaign( $other_fields ) {
	if ( ! is_array( $other_fields ) ) {
		$other_fields = [];
	}
	$get = function ( $key ) use ( $other_fields ) {
		return isset( $other_fields[ $key ] ) ? $other_fields[ $key ] : null;
	};

	$campaign_id = $get( 'noriks_campaign_id' ) ?: $get( 'noriks_utm_campaign' ) ?: $get( 'noriks_utm_id' );
	$ad_id       = $get( 'noriks_ad_id' )       ?: $get( 'noriks_utm_content' );
	$adset_id    = $get( 'noriks_adset_id' )    ?: $get( 'noriks_utm_term' );

	$has_any = $campaign_id || $ad_id || $adset_id || $get( 'noriks_fbclid' ) || $get( 'noriks_utm_source' );
	if ( ! $has_any ) {
		return null;
	}

	return [
		'campaign_id' => $campaign_id,
		'ad_id'       => $ad_id,
		'adset_id'    => $adset_id,
		'source'      => $get( 'noriks_utm_source' ),
		'medium'      => $get( 'noriks_utm_medium' ),
		'fbclid'      => $get( 'noriks_fbclid' ),
		'fbc'         => $get( 'noriks_fbc' ),
		'fbp'         => $get( 'noriks_fbp' ),
		'landing_url' => $get( 'noriks_landing_url' ),
		'referrer'    => $get( 'noriks_referrer' ),
	];
}

/**
 * (D) Direct checkout hook — ko stranka sama plača (brez Call Center),
 *     poberemo noriks_* iz $_POST in jih shranimo v Woo order meta.
 *
 *     Hook: woocommerce_checkout_create_order (klican PRED save, dostop do WC_Order)
 *
 * @param WC_Order $order Order instance.
 * @param array    $data  Checkout data.
 * @return void
 */
add_action( 'woocommerce_checkout_create_order', function ( $order, $data ) {
	if ( ! is_object( $order ) ) {
		return;
	}
	$allowed = noriks_fb_allowed_keys();
	$collected = [];
	foreach ( $allowed as $key ) {
		if ( isset( $_POST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$value = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
			if ( is_string( $value ) && $value !== '' ) {
				$value = substr( $value, 0, 500 );
				$collected[ $key ] = sanitize_text_field( $value );
			}
		}
	}
	if ( empty( $collected ) ) {
		return;
	}
	noriks_apply_fb_meta_to_order( $order, $collected );
}, 10, 2 );

/**
 * (E) Fallback hook — če order nima podatkov iz $_POST (npr. ustvarjen
 *     preko CallBoss REST API ali drugje), poskusi povleči iz povezane
 *     CartFlows abandoned cart vrste preko _abandoned_cart_id meta.
 *
 *     Hook: woocommerce_new_order (po insert v DB)
 *
 * @param int      $order_id Order ID.
 * @param WC_Order $order    Order object (may be null in older WC).
 * @return void
 */
add_action( 'woocommerce_new_order', function ( $order_id, $order = null ) {
	if ( ! $order_id ) {
		return;
	}
	if ( ! $order ) {
		$order = wc_get_order( $order_id );
	}
	if ( ! $order || ! is_object( $order ) ) {
		return;
	}
	// Skip if we already have _fb_campaign_id (e.g. via hook D or CC direct meta)
	if ( $order->get_meta( '_fb_campaign_id' ) ) {
		return;
	}
	$cart_id = $order->get_meta( '_abandoned_cart_id' );
	if ( ! $cart_id ) {
		return;
	}

	global $wpdb;
	$table = $wpdb->prefix . 'cartflows_ca_cart_abandonment';
	// Defensive: only run if table exists
	$exists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) );
	if ( ! $exists ) {
		return;
	}
	$row = $wpdb->get_var( $wpdb->prepare( "SELECT other_fields FROM {$table} WHERE id = %d LIMIT 1", intval( $cart_id ) ) );
	if ( ! $row ) {
		return;
	}
	$other_fields = maybe_unserialize( $row );
	if ( ! is_array( $other_fields ) ) {
		return;
	}
	$allowed = noriks_fb_allowed_keys();
	$collected = [];
	foreach ( $allowed as $key ) {
		if ( isset( $other_fields[ $key ] ) && is_string( $other_fields[ $key ] ) && $other_fields[ $key ] !== '' ) {
			$collected[ $key ] = $other_fields[ $key ];
		}
	}
	if ( empty( $collected ) ) {
		return;
	}
	noriks_apply_fb_meta_to_order( $order, $collected );
}, 20, 2 );

/**
 * Helper: pridobi noriks_* polja in jih shrani v Woo order kot _fb_* meta.
 *
 * @param WC_Order $order     Order object.
 * @param array    $collected Map noriks_key => sanitized value.
 * @return void
 */
function noriks_apply_fb_meta_to_order( $order, $collected ) {
	if ( ! $order || ! is_object( $order ) ) {
		return;
	}

	$campaign_id = $collected['noriks_campaign_id']
		?? $collected['noriks_utm_campaign']
		?? $collected['noriks_utm_id']
		?? null;
	$ad_id    = $collected['noriks_ad_id']    ?? $collected['noriks_utm_content'] ?? null;
	$adset_id = $collected['noriks_adset_id'] ?? $collected['noriks_utm_term']    ?? null;

	$pairs = [
		'_fb_campaign_id' => $campaign_id,
		'_fb_ad_id'       => $ad_id,
		'_fb_adset_id'    => $adset_id,
		'_fb_fbclid'      => $collected['noriks_fbclid']      ?? null,
		'_fb_fbc'         => $collected['noriks_fbc']         ?? null,
		'_fb_fbp'         => $collected['noriks_fbp']         ?? null,
		'_fb_utm_source'  => $collected['noriks_utm_source']  ?? null,
		'_fb_utm_medium'  => $collected['noriks_utm_medium']  ?? null,
		'_fb_landing_url' => $collected['noriks_landing_url'] ?? null,
		'_fb_referrer'    => $collected['noriks_referrer']    ?? null,
	];

	$wrote_any = false;
	foreach ( $pairs as $meta_key => $value ) {
		if ( $value === null || $value === '' ) {
			continue;
		}
		$order->update_meta_data( $meta_key, $value );
		$wrote_any = true;
	}

	if ( $wrote_any ) {
		// Force save in case caller does not save itself (e.g. woocommerce_new_order at insert time)
		try {
			$order->save();
		} catch ( Exception $e ) {
			// ignore - hook D path will save via checkout flow anyway
		}
	}
}
