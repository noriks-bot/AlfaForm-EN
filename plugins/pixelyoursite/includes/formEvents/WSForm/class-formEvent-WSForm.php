<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class FormWSForm extends Settings implements FormEventsFactory {
	private static $_instance;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		parent::__construct( 'WSForm' );

		$this->locateOptions( PYS_FREE_PATH . '/includes/formEvents/options_fields.json', PYS_FREE_PATH . '/includes/formEvents/options_defaults.json' );

		if ( $this->isActivePlugin() ) {
			add_filter("pys_form_event_factory",[$this,"register"]);
		}
	}

	function register( $list ) {
		$list[] = $this;
		return $list;
	}

	public function getSlug() {
		return "wsform";
	}

	public function getName() {
		return "WS Form";
	}

	function isEnabled() {
		return $this->getOption( 'enabled' );
	}

	function isActivePlugin() {
		if ( !function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		return is_plugin_active( 'ws-form-pro/ws-form.php' ) || is_plugin_active( 'ws-form/ws-form.php' );
	}

	function getForms() {
		global $wpdb, $table_prefix;

		// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery
		$forms = $wpdb->get_results( $wpdb->prepare( 'SELECT id, label FROM ' . $table_prefix . 'wsf_form ORDER BY %s DESC', "date_added" ) );
		// phpcs:enable WordPress.DB.DirectDatabaseQuery.DirectQuery
		$forms = wp_list_pluck( $forms, 'label', 'id' );

		return $forms;
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
 * @return FormWSForm
 */
function FormWSForm() {
	return FormWSForm::instance();
}

FormWSForm();