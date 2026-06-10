<?php
if ( function_exists( 'WC' ) ) {
	// update the button_radius option for Apple Pay. If the button design is "rounded" then make
	// the button radius 40.
	$applepay = WC()->payment_gateways()->payment_gateways()['stripe_applepay'] ?? null;
	if ( $applepay ) {
		$button_design = $applepay->get_option( 'button_design', 'standard' );
		if ( $button_design === 'rounded' ) {
			$button_radius = 40;
		} else {
			$button_radius = 4;
		}
		$applepay->update_option( 'button_radius', $button_radius );
		$applepay->update_option( 'button_design', 'standard' );
	}

	// Register the payment method domains so that the new Apple Pay integration on cart and checkout block works.
	$modes       = array( 'test', 'live' );
	$domain_name = $_SERVER['SERVER_NAME'] ?? null;

	if ( ! $domain_name ) {
		return;
	}

	$gateway = WC_Stripe_Gateway::load();

	foreach ( $modes as $mode ) {
		$api_key = wc_stripe_get_secret_key( $mode );
		if ( ! $api_key ) {
			continue;
		}
		try {
			$payment_method_domains = $gateway->mode( $mode )->paymentMethodDomains->all( array( 'limit' => 50 ) );
			if ( is_wp_error( $payment_method_domains ) ) {
				wc_stripe_log_error( sprintf( 'Error fetching domains for %s mode: %s', $mode, $payment_method_domains->get_error_message() ) );
			} else {
				$result = null;
				foreach ( $payment_method_domains->data as $domain ) {
					if ( $domain->domain_name === $domain_name ) {
						$result = $domain;
						break;
					}
				}
				if ( ! $result ) {
					$response = $gateway->mode( $mode )->paymentMethodDomains->create( array(
						'domain_name' => $domain_name,
						'enabled'     => true
					) );
					if ( is_wp_error( $response ) ) {
						wc_stripe_log_error( sprintf( 'Error creating domain %s during update 3.3.97. Error: %s', $domain_name, $response->get_error_message() ) );
					} else {
						wc_stripe_log_info( sprintf( 'Created domain %s during update 3.3.97. Mode: %s', $domain_name, $mode ) );
					}
				} else {
					$response = $gateway->mode( $mode )->paymentMethodDomains->update( $result->id, array( 'enabled' => true ) );
					if ( is_wp_error( $response ) ) {
						wc_stripe_log_error( sprintf( 'Error updating domain %s during update 3.3.97. Error: %s', $domain_name, $response->get_error_message() ) );
					} else {
						wc_stripe_log_info( sprintf( 'Updated domain %s during update 3.3.97. Mode: %s', $domain_name, $mode ) );
					}
				}

			}
		} catch ( \Exception $e ) {
			wc_stripe_log_error( sprintf( 'Error processing payment method domain code. Error: %s', $e->getMessage() ) );
		}

		// update the default payment method configuration
		try {
			$configurations = $gateway->mode( $mode )->paymentMethodConfigurations->all( array(
				'limit' => 50
			) );
			if ( is_wp_error( $configurations ) ) {
				wc_stripe_log_error( sprintf( 'Error fetching payment method configurations for %s mode', $mode ) );
			} else {
				foreach ( $configurations->data as $configuration ) {
					if ( $configuration->is_default ) {
						$result = $gateway->mode( $mode )->paymentMethodConfigurations->update( $configuration->id, array(
							'apple_pay'  => array(
								'display_preference' => array(
									'preference' => 'on'
								)
							),
							'google_pay' => array(
								'display_preference' => array(
									'preference' => 'on'
								)
							)
						) );
						if ( is_wp_error( $result ) ) {
							wc_stripe_log_error( sprintf( 'Error updating configuration for %s mode. %s', $mode, $result->get_error_message() ) );
						} else {
							wc_stripe_log_info( sprintf( 'Updated configuration for %s mode. Payment configuration ID: %s', $mode, $result->id ) );
						}
						break;
					}
				}
			}
		} catch ( \Exception $e ) {
			wc_stripe_log_error( sprintf( 'Error fetching payment method configurations for %s mode. %s', $mode, $e->getMessage() ) );
		}
	}
}
