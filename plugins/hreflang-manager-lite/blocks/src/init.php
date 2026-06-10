<?php

//Prevent direct access to this file
if ( ! defined( 'WPINC' ) ) {
	die();
}

/**
 * Enqueue the Gutenberg block assets for the backend.
 *
 * This function should be used for:
 *
 * - Hooks into editor only
 * - For main block JS
 * - For editor only block CSS overrides
 * Register block.json (handles editorScript, editorStyle, style)
 */
function daexthrmal_register_hreflang_manager_sidebar() {

	// Only register for users with the "edit_others_posts" capability.
	if ( ! current_user_can( 'edit_others_posts' ) ) {
		return;
	}

	$shared = daexthrmal_Shared::get_instance();

	/**
	 * Register the block editor script for the hreflang manager sidebar feature.
	 * This script is responsible for rendering the sidebar and managing the connections in the menu, which are features
	 * that are not directly related to a specific block, but rather to the overall editor experience.
	 */
	wp_register_script(
		'daexthrmal-editor-js', // Handle.
		$shared->get('url') . 'blocks/build/hreflang-manager/index.js', //We register the block here.
		array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-i18n' ),
		filemtime( $shared->get('dir') . 'blocks/build/hreflang-manager/index.js'),
		true //Enqueue the script in the footer.
	);
	// Pass editor config data to JS (not used for translations).
	wp_localize_script( 'daexthrmal-editor-js', 'DAEXTHRMAL_OPTIONS', array(
		'connectionsInMenu' => 10
	));

	/**
	 * Register the block editor CSS for the hreflang manager sidebar.
	 */
	wp_register_style(
		'daexthrmal-editor-css',
		$shared->get('url') . 'blocks/build/hreflang-manager/index.css',
		array( 'wp-edit-blocks' ),//Dependency to include the CSS after it.
		filemtime( $shared->get('dir') . 'blocks/build/hreflang-manager/index.css')
	);

	/**
	 * Add translations for this script using the WordPress.org JS i18n system.
	 *
	 * Reference: https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
	 *
	 * Argument 1: Handle
	 * Argument 2: Text domain
	 *
	 * Note that WordPress.org generates and serves the JSON translation files
	 * automatically for plugins hosted in the directory.
	 */
	wp_set_script_translations( 'daexthrmal-editor-js', 'hreflang-manager-lite' );

}
add_action( 'init', 'daexthrmal_register_hreflang_manager_sidebar' );

/**
 * Enqueue editor-only scripts and styles.
 * This function is hooked to 'admin_enqueue_scripts' to ensure scripts are only loaded in the WordPress editor.
 */
function daexthrmal_enqueue_editor_assets() {

	// Only enqueue for users with the "edit_others_posts" capability.
	if ( ! current_user_can( 'edit_others_posts' ) ) {
		return;
	}

	wp_enqueue_script( 'daexthrmal-editor-js' );
	wp_enqueue_style( 'daexthrmal-editor-css' );
}
add_action( 'admin_enqueue_scripts', 'daexthrmal_enqueue_editor_assets' );