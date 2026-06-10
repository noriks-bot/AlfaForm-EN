<?php

namespace PaymentPlugins\Stripe\Utilities;

class CountryUtils {

	public static function get_eu_counties() {
		return [
			'AT', // Austria
			'BE', // Belgium
			'BG', // Bulgaria
			'HR', // Croatia
			'CY', // Cyprus
			'CZ', // Czech Republic
			'DK', // Denmark
			'EE', // Estonia
			'FI', // Finland
			'FR', // France
			'DE', // Germany
			'GR', // Greece
			'HU', // Hungary
			'IE', // Ireland
			'IT', // Italy
			'LV', // Latvia
			'LT', // Lithuania
			'LU', // Luxembourg
			'MT', // Malta
			'NL', // Netherlands
			'PL', // Poland
			'PT', // Portugal
			'RO', // Romania
			'SK', // Slovakia
			'SI', // Slovenia
			'ES', // Spain
			'SE', // Sweden
		];
	}

	public static function get_eea_countries() {
		return [
			'AT', // Austria
			'BE', // Belgium
			'HR', // Croatia
			'CY', // Cyprus
			'CZ', // Czech Republic
			'DK', // Denmark
			'EE', // Estonia
			'FI', // Finland
			'FR', // France
			'DE', // Germany
			'GR', // Greece
			'IE', // Ireland
			'IT', // Italy
			'LV', // Latvia
			'LT', // Lithuania
			'LU', // Luxembourg
			'MT', // Malta
			'NL', // Netherlands
			'NO', // Norway
			'PL', // Poland
			'PT', // Portugal
			'RO', // Romania
			'SK', // Slovakia
			'SI', // Slovenia
			'ES', // Spain
			'SE'  // Sweden
		];
	}
}