<?php

namespace PixelYourSite;
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class ElementorForm extends Settings implements FormEventsFactory {

	private static $_instance;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		parent::__construct( 'ElementorForm' );

		$this->locateOptions( PYS_FREE_PATH . '/includes/formEvents/options_fields.json', PYS_FREE_PATH . '/includes/formEvents/options_defaults.json' );

		if ( $this->isActivePlugin() ) {
			add_filter( "pys_form_event_factory", [
				$this,
				"register"
			] );
		}
	}

	function register( $list ) {
		$list[] = $this;
		return $list;
	}

	public function getSlug() {
		return "elementor_form";
	}

	public function getName() {
		return "Elementor Form";
	}

	function isEnabled() {
		return $this->getOption( 'enabled' );
	}

	function isActivePlugin() {
		if ( !function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		return is_plugin_active( 'elementor/elementor.php' ) || is_plugin_active( 'elementor-pro/elementor-pro.php' );
	}

	function getForms() {
		return array();
	}

	function getOptions() {
		return array(
			"name"          => $this->getName(),
			"enabled"       => $this->getOption( "enabled" ),
			"form_ID_event" => $this->getOption( "form_ID_event" )
		);
	}

	function getDefaultMatchingInput() {
		return array(
			"first_name" => array(),
			"last_name"  => array(),
			"tel"        => array()
		);
	}

}

/**
 * @return ElementorForm
 */
function ElementorForm() {
	return ElementorForm::instance();
}

ElementorForm();
