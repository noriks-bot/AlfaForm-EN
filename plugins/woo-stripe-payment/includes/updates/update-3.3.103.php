<?php
if ( function_exists( 'WC' ) ) {
	$settings = stripe_wc()->advanced_settings;
	if ( $settings ) {
		$statement_descriptor = $settings->get_option( 'statement_descriptor', '' );
		$settings->update_option( 'statement_descriptor_suffix', $statement_descriptor );
	}
}