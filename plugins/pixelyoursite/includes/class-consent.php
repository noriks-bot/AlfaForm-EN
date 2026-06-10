<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Consent {

	private static $_instance;
	private string $consentKey    = "pys_consent";
	private bool   $consentLoaded = false;
	private bool   $consentPlugin = false;

	private array $consentData = array(
		'facebook'   => true,
		'ga'         => true,
		'bing'       => true,
		'pinterest'  => true,
		'gtm'        => true,
		'reddit'     => true,
	);

	public static function instance(): Consent {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		$this->checkConsentPlugin();

		if ( $this->consentPlugin ) {
			$this->loadConsent();
		}
	}

	private function loadConsent() {

		if ( $this->consentLoaded ) {
			return;
		}

		if ( isset( $_COOKIE[ $this->consentKey ] ) && !empty( $_COOKIE[ $this->consentKey ] ) ) {

			$consent = json_decode( base64_decode( sanitize_text_field( $_COOKIE[ $this->consentKey ] ) ), true );

			if ( !empty( $consent ) ) {
				$this->consentData = $consent;
			} else {
				$this->disableAllPixels();
			}

		} else {
			$this->disableAllPixels();
		}

		$this->consentLoaded = true;

		if ( apply_filters( 'pys_disable_by_gdpr', false ) ) {
			$this->disableAllPixels();

			return;
		}

		$this->consentData[ 'facebook' ] = !apply_filters( 'pys_disable_facebook_by_gdpr', false );
		$this->consentData[ 'ga' ] = $this->consentData[ 'gtm' ] = !apply_filters( 'pys_disable_analytics_by_gdpr', false );
		$this->consentData[ 'pinterest' ] = !apply_filters( 'pys_disable_pinterest_by_gdpr', false );
		$this->consentData[ 'bing' ] = !apply_filters( 'pys_disable_bing_by_gdpr', false );
		$this->consentData[ 'reddit' ] = !apply_filters( 'pys_disable_reddit_by_gdpr', false );
	}

	private function checkConsentPlugin(): void {
		$this->consentPlugin = isCookiebotPluginActivated() || isCookieNoticePluginActivated() || isRealCookieBannerPluginActivated() || isConsentMagicPluginActivated() || isCookieLawInfoPluginActivated();
	}

	private function disableAllPixels(): void {
		foreach ( $this->consentData as &$pixel ) {
			$pixel = false;
		}

		unset( $pixel );
	}

	public function checkConsent( $pixel ): bool {
        return (bool) apply_filters( 'pys_check_consent_by_gdpr', $this->consentData[ $pixel ], $pixel );
	}
}

/**
 * @return Consent
 */
function Consent(): Consent {
	return Consent::instance();
}

Consent();