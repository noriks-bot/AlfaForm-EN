<?php


namespace PaymentPlugins\Stripe\Utilities;


class NumberUtil {

	/**
	 * @param     $val
	 * @param int $precision
	 *
	 * @return string
	 */
	public static function round( $val, $precision = 2 ) {
		static $decimals;
		if ( $decimals === null ) {
			$decimals = wc_get_price_decimals();
		}

		// always use the lower precision number since 2 is the max.
		return wc_format_decimal( $val, $precision > $decimals ? $decimals : $precision );
	}

	/**
	 * @param float $value
	 * @param string $currency
	 * @param int $decimals
	 *
	 * @return string
	 */
	public static function round_incl_currency( $value, $currency, $decimals = 2 ) {
		$decimals = isset( Currency::get_currency_decimals()[ $currency ] )
			? Currency::get_currency_decimals()[ $currency ] : $decimals;

		return NumberUtil::round( $value, $decimals );
	}

	public static function add_precision( $value, $currency ) {
		if ( ! is_numeric( $value ) ) {
			$value = 0;
		}

		// Round to WooCommerce price decimals first
		$decimals = wc_get_price_decimals();
		$value    = floatval( $value );

		// Get currency, default to WooCommerce currency if empty
		$currency = empty( $currency ) ? get_woocommerce_currency() : $currency;

		// Get the currency decimals/exponent from the Currency class
		$currencies = Currency::get_currency_decimals();
		$exp        = isset( $currencies[ $currency ] ) ? $currencies[ $currency ] : 2;

		// Multiply by precision to convert to cents/smallest unit
		$value = $value * pow( 10, $exp );

		// Round to remove any floating point precision issues
		$value = round( $value, 0, PHP_ROUND_HALF_UP );

		return $value;
	}

}