<?php
/**
 * Installation related functions and actions.
 *
 * @package   WooCommerceKlaviyo/Classes
 * @version     0.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WCK_Install' ) ) :

	/**
	 * WCK_Install Class
	 */
	class WCK_Install {

		/**
		 * Hook in tabs.
		 */
		public function __construct() {
			register_activation_hook( WCK_PLUGIN_FILE, array( $this, 'install' ) );

			add_action( 'admin_init', array( $this, 'admin_init' ), 5 );

			// Review prompt hooks
			add_action('wp_ajax_klaviyo_handle_feedback_response', array( $this, 'handle_feedback_response' ));
			add_action('wp_ajax_klaviyo_dismiss_review_prompt', array( $this, 'dismiss_review_prompt' ));
			add_action('admin_notices', array( $this, 'review_prompt_notice' ));
		}

		/**
		 * Check plugin version and maybe redirect to Klaviyo settings page if recently activated.
		 */
		public function admin_init() {
			$this->check_version();
		}

		/**
		 * Check version of plugin against that saved in the DB to identify update.
		 *
		 * @return void
		 */
		public function check_version() {
			if ( ! defined( 'IFRAME_REQUEST' ) && ( get_option( 'woocommerce_klaviyo_version' ) !== WooCommerceKlaviyo::get_version() ) ) {
				$this->install();
				// Remove transient so we start checking 'set_site_transient_update_plugins' again.
				delete_site_transient( 'is_klaviyo_plugin_outdated' );

				/**
				 * Fires when Klaviyo plugin is updated.
				 *
				 * @since 2.0.0
				 */
				do_action( 'woocommerce_klaviyo_updated' );
			}
		}


		/**
		 * Install WCK
		 */
		public function install() {
			// Purge private API keys that were mistakenly saved as the public key.
			$settings = get_option( 'klaviyo_settings' );
			if ( is_array( $settings )
				&& ! empty( $settings['klaviyo_public_api_key'] )
				&& WCK_Options::is_private_api_key( $settings['klaviyo_public_api_key'] )
			) {
				$settings['klaviyo_public_api_key'] = '';
				update_option( 'klaviyo_settings', $settings );
			}

			// Set activation time for review prompt if not already set i.e. do
			// not update it during a plugin upgrade.
			if (!get_option('klaviyo_activation_time')) {
				update_option('klaviyo_activation_time', time());
			}

			// Update version last so migrations retry on failure.
			update_option( 'woocommerce_klaviyo_version', WooCommerceKlaviyo::get_version() );

			// Flush rules after install.
			flush_rewrite_rules();
		}

		/**
		 * Called from WCK_Api via the `disable` route. Deactivate Klaviyo plugin via builtin function so hooks fire.
		 */
		public function deactivate_klaviyo() {
			deactivate_plugins( KLAVIYO_BASENAME );
		}

		/**
		 * Handle cleanup of the plugin.
		 * Delete options and remove WooCommerce webhooks.
		 */
		public function cleanup_klaviyo() {
			// We can't remove webhooks without WooCommerce. No need to remove the integration app-side.
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				// Remove WooCommerce webhooks.
				self::remove_klaviyo_webhooks();
			}

			// Lastly, delete Klaviyo-related options.
			delete_option( 'klaviyo_settings' );
			delete_option( 'woocommerce_klaviyo_version' );
			delete_site_transient( 'is_klaviyo_plugin_outdated' );

			// Delete review-related options
			delete_option('klaviyo_activation_time');
			delete_option('klaviyo_feedback_response');
			delete_option('klaviyo_review_dismissed');
		}

		/**
		 * Remove Klaviyo related webhooks. The only way to identify these are through the delivery url so check for the
		 * Woocommerce webhook path.
		 */
		private static function remove_klaviyo_webhooks() {
			$webhook_data_store = WC_Data_Store::load( 'webhook' );
			$webhooks_by_status = $webhook_data_store->get_count_webhooks_by_status();
			// $webhooks_by_status returns an associative array with a count of webhooks in each status.
			$count = array_sum( $webhooks_by_status );

			if ( 0 === $count ) {
				return;
			}

			// We can only get IDs and there's not a way to search by delivery url which is the only way to identify
			// a webhook created by Klaviyo. We'll have to iterate no matter what so might as well get them all.
			$webhook_ids = $webhook_data_store->get_webhooks_ids();

			foreach ( $webhook_ids as $webhook_id ) {
				$webhook = wc_get_webhook( $webhook_id );
				if ( ! $webhook ) {
					continue;
				}

				if ( false !== strpos( $webhook->get_delivery_url(), '/api/webhook/integration/woocommerce' ) ) {
					$webhook_data_store->delete( $webhook );
				}
			}
		}

		/**
		 * Handler for feedback/review AJAX request
		 */
		public function handle_feedback_response() {
			if (!current_user_can('manage_options')) {
				wp_die();
			}

			$nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
			if (!wp_verify_nonce($nonce, 'klaviyo_feedback_nonce')) {
				wp_die(esc_html__('Security check failed', 'woocommerce-klaviyo'));
			}

			if (isset($_POST['response']) && in_array($_POST['response'], array( 'great', 'feedback' ))) {
				update_option('klaviyo_feedback_response', sanitize_text_field($_POST['response']));
			}

			wp_die();
		}

		/**
		 * Dismiss review prompt via AJAX
		 */
		public function dismiss_review_prompt() {
			update_option('klaviyo_review_dismissed', true);
			wp_die();
		}

		/**
		 * Display review prompt notice in admin
		 */
		public function review_prompt_notice() {
			// Check if:
			// the plugin has been activated for at least 60 days
			// the user has the capability to manage options
			// the review prompt has not been dismissed
			if (!current_user_can('manage_options')) {
				return;
			}

			if (get_current_screen()->base !== 'plugins') {
				return;
			}

			$activation_time = get_option('klaviyo_activation_time');

			if (!$activation_time || ( time() - $activation_time ) < 60 * DAY_IN_SECONDS) {
				return;
			}

			if (get_option('klaviyo_review_dismissed')) {
				return;
			}

			$response = get_option('klaviyo_feedback_response');

			// Generate the nonce for the JS
			$nonce = wp_create_nonce('klaviyo_feedback_nonce');

			// FOLLOW-UP: Great
			if ('great' === $response) {
				?>
				<div class="notice notice-info is-dismissible klaviyo-review-notice">
					<p>We're happy to hear you're enjoying Klaviyo! If you have a moment, please consider <a href="#" id="klaviyo-leave-review">leaving us a review</a>.</p>
				</div>
				<script type="text/javascript">
					jQuery(document).on('click', '.klaviyo-review-notice .notice-dismiss', function(e) {
						e.preventDefault();
						jQuery.post(ajaxurl, { action: 'klaviyo_dismiss_review_prompt' });
					});
					jQuery(document).on('click', '#klaviyo-leave-review', function(e) {
						e.preventDefault();
						jQuery.post(ajaxurl, { action: 'klaviyo_dismiss_review_prompt' }, function () {
							window.open('https://woocommerce.com/products/klaviyo-for-woocommerce/?review', '_blank');
							location.reload();
						});
					});
				</script>
				<?php
				return;
			}

			// FOLLOW-UP: Feedback
			if ('feedback' === $response) {
				?>
				<div class="notice notice-info is-dismissible klaviyo-review-notice">
					<p>We'd love to hear your feedback. Please <a href="#" id="klaviyo-leave-feedback">get in touch with support</a>.</p>
				</div>
				<script type="text/javascript">
					jQuery(document).on('click', '.klaviyo-review-notice .notice-dismiss', function(e) {
						e.preventDefault();
						jQuery.post(ajaxurl, { action: 'klaviyo_dismiss_review_prompt' });
					});
					jQuery(document).on('click', '#klaviyo-leave-feedback', function(e) {
						e.preventDefault();
						jQuery.post(ajaxurl, { action: 'klaviyo_dismiss_review_prompt' }, function () {
							window.open('https://www.klaviyo.com/support', '_blank');
							location.reload();
						});
					});
				</script>
				<?php
				return;
			}

			// INITIAL PROMPT
			?>
			<div class="notice notice-info is-dismissible klaviyo-review-notice">
				<p><strong>How would you rate your experience with Klaviyo for WooCommerce?</strong></p>
				<p>
					<button class="button-primary klaviyo-feedback-button" data-response="great">Great!</button>
					<button class="button klaviyo-feedback-button" data-response="feedback">I have feedback</button>
				</p>
			</div>
			<script type="text/javascript">
				jQuery(document).on('click', '.klaviyo-review-notice .notice-dismiss', function(e) {
					e.preventDefault();
					jQuery.post(ajaxurl, { action: 'klaviyo_dismiss_review_prompt' });
				});
				jQuery(document).on('click', '.klaviyo-feedback-button', function(e) {
					e.preventDefault();
					const response = jQuery(this).data('response');

					jQuery.post(ajaxurl, {
						action: 'klaviyo_handle_feedback_response',
						response: response,
						nonce: '<?php echo esc_js( $nonce ); ?>'
					}, function () {
						location.reload();
					});
				});
			</script>
			<?php
		}
	}

endif;
