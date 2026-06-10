<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes
 */

namespace AdTribes\PFP\Classes;

use AdTribes\PFP\Abstracts\Abstract_Class;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Factories\Vite_App;
use AdTribes\PFP\Factories\Admin_Notice;

/**
 * Notices class.
 *
 * @since 13.4.5
 */
class Notices extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Property that houses all admin notices data.
     *
     * @since 13.4.5
     * @access private
     * @var array
     */
    private $_notices = array();

    /**
     * Schedule all notice crons.
     *
     * @since 13.4.5
     * @access public
     */
    public function schedule_cron_notices() {
        $notices = $this->_get_cron_notices();

        foreach ( $notices as $key => $notice ) {
            if ( ! isset( $notice['option'] ) || get_option( $notice['option'] ) === 'dismissed' ) {
                continue;
            }
            $this->_schedule_single_notice_cron( $key, $notice['option'], $notice['days'] );
        }
    }

    /**
     * Get notices that needs to be scheduled via cron.
     *
     * For the notification drawer, you can use image urls or icons.
     * icon name from https://icon-sets.iconify.design/lucide/?keyword=lucide
     * example:
     * 'icon' => 'message-square-more',
     *
     * IMPORTANT: When adding a new icon to a notice configuration, you MUST also add it to the
     * safelist in tailwind.config.js. This is because:
     * 1. Tailwind/Iconify cannot parse PHP variables during build time
     * 2. Dynamic icon classes like 'adt-tw-icon-[lucide--{$icon}]' won't be detected automatically
     * 3. Without safelist, the icon CSS won't be generated and icons will not display
     *
     * To add a new icon:
     * 1. Add your notice configuration here with 'icon' => 'your-icon-name'
     * 2. Open tailwind.config.js
     * 3. Add 'adt-tw-icon-[lucide--your-icon-name]' to the safelist array
     * 4. Run npm run dev to rebuild assets
     *
     * @since 13.4.5
     * @access private
     */
    private function _get_cron_notices() {
        $notices = array(
            'review_request'                  => array(
                'option'         => 'adt_pfp_show_review_request_notice',
                'days'           => 10,
                'type'           => 'info',
                'is_dismissible' => true,
                'is_html'        => true,
                'message'        => '<p>' . __( "Hey, I noticed you have been using <strong>Product Feed PRO for WooCommerce</strong> for some time - that's awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress to help us spread the word and boost our motivation?", 'woo-product-feed-pro' ) . '</p>',
                'icon'           => 'message-square-more',
                'actions'        => array(
                    array(
                        'type'        => 'primary',
                        'link'        => 'https://wordpress.org/support/plugin/woo-product-feed-pro/reviews/?filter=5#new-post',
                        'is_external' => true,
                        'text'        => __( 'Ok, you deserve it', 'woo-product-feed-pro' ),
                        'class'       => 'adt-pfp-review-action',
                        'data'        => array( 'response' => 'primary' ),
                    ),
                    array(
                        'type'  => 'secondary',
                        'link'  => '#',
                        'text'  => __( 'Nope, maybe later', 'woo-product-feed-pro' ),
                        'class' => 'adt-pfp-review-action',
                        'data'  => array( 'response' => 'snooze' ),
                    ),
                    array(
                        'type'  => 'secondary',
                        'link'  => '#',
                        'text'  => __( 'I already did', 'woo-product-feed-pro' ),
                        'class' => 'adt-pfp-review-action',
                        'data'  => array( 'response' => 'dismissed' ),
                    ),
                ),
            ),
            'store_agent_recommendation'      => array(
                'notice_type'     => 'plugin_recommendation',
                'plugin_slug'     => 'storeagent-ai-for-woocommerce',
                'plugin_basename' => 'storeagent-ai-for-woocommerce/storeagent-ai-for-woocommerce.php',
                'option'          => 'adt_show_store_agent_recommendation_notice',
                'days'            => 14,
                'is_dismissible'  => true,
                'type'            => 'info',
                'message'         => array(
                    '<h3>' . __( 'Turn More Clicks Into Sales With AI Chat', 'woo-product-feed-pro' ) . '</h3>',
                    '<p>' . __( 'You\'re already driving high-quality traffic with Product Feed PRO. Now make sure those visitors convert. Our sister plugin, StoreAgent, adds an AI-powered chat assistant to your store that answers customer questions instantly, removes purchase doubts, and helps turn browsers into buyers.', 'woo-product-feed-pro' ) . '</p>',
                ),
                'image_url'       => 'https://ps.w.org/storeagent-ai-for-woocommerce/assets/icon-128x128.png',
                'is_html'         => true,
                'actions'         => array(
                    array(
                        'type'  => 'primary',
                        'class' => 'adt-pfp-install-plugin',
                        'data'  => array( 'plugin_slug' => 'storeagent-ai-for-woocommerce' ),
                        'text'  => __( 'Install Now', 'woo-product-feed-pro' ),
                    ),
                    array(
                        'type'        => 'secondary',
                        'link'        => Helper::get_utm_url( '', 'pfp', 'pluginrecommendation', 'learnmore', 'https://storeagent.ai/' ),
                        'is_external' => true,
                        'text'        => __( 'Learn More', 'woo-product-feed-pro' ),
                    ),
                ),
            ),
            'saveto_whishlist_recommendation' => array(
                'notice_type'     => 'plugin_recommendation',
                'plugin_slug'     => 'saveto-wishlist-lite-for-woocommerce',
                'plugin_basename' => 'saveto-wishlist-lite-for-woocommerce/saveto-wishlist-lite-for-woocommerce.php',
                'option'          => 'adt_show_saveto_wishlist_recommendation_notice',
                'days'            => 14,
                'is_dismissible'  => true,
                'type'            => 'info',
                'message'         => array(
                    '<h3>' . __( 'Install SaveTo Wishlist for WooCommerce (Free Plugin)', 'woo-product-feed-pro' ) . '</h3>',
                    '<p>' . __( 'We recommend installing our sister plugin <strong>SaveTo Wishlist for WooCommerce Lite</strong>. It\'s a free and easy to use wishlist plugin for WooCommerce! Instantly add wishlist functionality to your store, letting your customers save lists of products for later purchase.', 'woo-product-feed-pro' ) . '</p>',
                ),
                'image_url'       => 'https://ps.w.org/saveto-wishlist-lite-for-woocommerce/assets/icon-128x128.png',
                'is_html'         => true,
                'actions'         => array(
                    array(
                        'type'  => 'primary',
                        'class' => 'adt-pfp-install-plugin',
                        'data'  => array( 'plugin_slug' => 'saveto-wishlist-lite-for-woocommerce' ),
                        'text'  => __( 'Install Now', 'woo-product-feed-pro' ),
                    ),
                    array(
                        'type'        => 'secondary',
                        'link'        => Helper::get_utm_url( '', 'pfp', 'pluginrecommendation', 'learnmore', 'https://savetowishlist.com/' ),
                        'is_external' => true,
                        'text'        => __( 'Learn More', 'woo-product-feed-pro' ),
                    ),
                ),
            ),
        );

        /**
         * Filter to allow Elite (or other plugins) to register their own notifications.
         *
         * @since 13.4.5
         * @param array $notices Array of notice configurations.
         */
        return apply_filters( 'adt_pfp_cron_notices_data', $notices );
    }

    /**
     * Schedule a single notice cron.
     *
     * @since 1.2
     * @access private
     *
     * @param string $key    Notice key.
     * @param string $option Notice option.
     * @param int    $days   Number of days delay.
     */
    private function _schedule_single_notice_cron( $key, $option, $days ) {
        // Backwards compatibility for old cron notices.
        // If the user has already interacted with the notice, we don't need to show it again.
        // Legacy option: "woosea_review_interaction".
        if ( 'review_request' === $key && 'yes' === get_option( 'woosea_review_interaction' ) ) {
            $this->update_notice_option( $key, 'dismissed' );
            return;
        }

        // Use Action Scheduler if available, otherwise fallback to wp_cron.
        if ( function_exists( 'as_schedule_single_action' ) ) {
            // Check if already scheduled with Action Scheduler.
            if ( function_exists( 'as_next_scheduled_action' ) && as_next_scheduled_action( 'adt_pfp_cron_notices', array( $key ), 'adt-pfp-notices' ) ) {
                return;
            }

            if ( get_option( $option, 'snooze' ) !== 'snooze' ) {
                return;
            }

            as_schedule_single_action( time() + ( DAY_IN_SECONDS * $days ), 'adt_pfp_cron_notices', array( $key ), 'adt-pfp-notices' );
        } else {
            // Fallback to wp_cron.
            if ( wp_next_scheduled( 'adt_pfp_cron_notices', array( $key ) ) || get_option( $option, 'snooze' ) !== 'snooze' ) {
                return;
            }

            wp_schedule_single_event( time() + ( DAY_IN_SECONDS * $days ), 'adt_pfp_cron_notices', array( $key ) );
        }
    }

    /**
     * Trigger cron notices.
     *
     * @since 13.4.5
     * @access public
     *
     * @param string $key Notice key.
     */
    public function trigger_cron_notices( $key ) {
        $notices = $this->_get_cron_notices();
        $notice  = isset( $notices[ $key ] ) ? $notices[ $key ] : array();

        if ( ! isset( $notice['option'] ) || get_option( $notice['option'] ) === 'dismissed' ) {
            return;
        }

        update_option( $notice['option'], 'yes' );
    }

    /**
     * Enqueue admin notice styles and scripts.
     *
     * @since 13.4.5
     * @access public
     */
    public function enqueue_admin_notice_scripts() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $is_pfp_screen  = Helper::is_plugin_page();
        $notices        = $this->get_all_admin_notices();
        $should_enqueue = false;

        // Check if we have any notices to display or if we're on a plugin page (for drawer).
        if ( $is_pfp_screen ) {
            $should_enqueue = true;
        } else {
            // Check if there are notices that should show admin-wide.
            foreach ( $notices as $notice_key => $notice_data ) {
                $notice_data = $this->_notices[ $notice_key ] ?? array();

                if ( isset( $notice_data['show_admin_wide'] ) && $notice_data['show_admin_wide'] && get_option( $notice_data['option'] ) === 'yes' ) {
                    $should_enqueue = true;
                    break;
                }
            }
        }

        // Enqueue unified notices script (includes drawer functionality).
        if ( $should_enqueue ) {
            $vite = new Vite_App(
                'adt-pfp-notices',
                'src/vanilla/notices/index.ts',
                array( 'jquery', 'wp-i18n' ),
            );
            $vite->enqueue();

            // Localize script with nonce for mark all as read (used by drawer).
            wp_localize_script(
                'adt-pfp-notices',
                'adtNotificationsData',
                array(
                    'markAllReadNonce' => wp_create_nonce( 'adt_pfp_mark_all_read' ),
                )
            );
        }
    }

    /**
     * Display notices.
     *
     * @since 13.4.5
     * @access public
     */
    public function display_notices() {
        // only run when current user is atleast an administrator.
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $is_pfp_screen = Helper::is_plugin_page();
        $context       = $is_pfp_screen ? 'plugin_page' : 'admin_wide';

        // initialize notices.
        $notices = $this->get_all_admin_notices();

        // Count visible notices first to determine if navigation is needed.
        $visible_notices = array();
        foreach ( $notices as $notice_key => $notice_data ) {
            $notice_data = $this->_notices[ $notice_key ] ?? array();

            // display only on eligible screens.
            if ( ! $is_pfp_screen && ! ( isset( $notice_data['show_admin_wide'] ) && $notice_data['show_admin_wide'] ) ) {
                continue;
            }

            if ( ! $notice_data || ( isset( $notice_data['option'] ) && get_option( $notice_data['option'] ) !== 'yes' ) ) {
                continue;
            }

            /**
             * Filter to control visibility of a specific notice based on context.
             *
             * @since 13.4.5
             * @param bool   $show_notice Whether to show the notice. Default true.
             * @param string $notice_key  The notice key.
             * @param string $context     The context (plugin_page or admin_wide).
             * @param array  $notice_data The notice data.
             */
            $show_notice = apply_filters( 'adt_pfp_show_notice', true, $notice_key, $context, $notice_data );

            if ( $show_notice ) {
                $visible_notices[ $notice_key ] = $notice_data;
            }
        }

        // Sort by first_shown_at timestamp (most recent first) and limit to 2.
        $visible_notices = $this->sort_notices_by_timestamp( $visible_notices );
        $visible_notices = array_slice( $visible_notices, 0, 2, true );

        $show_navigation = count( $visible_notices ) > 1;

        // Render visible notices.
        foreach ( $visible_notices as $notice_key => $notice_data ) {
            $this->print_admin_notice_content( $notice_key, $notice_data['option'], false, $show_navigation );
        }
    }

    /**
     * Render notification drawer in admin footer.
     *
     * @since 13.4.5
     * @access public
     */
    public function render_notification_drawer() {
        // Only render on plugin pages.
        if ( ! Helper::is_plugin_page() || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        Helper::locate_admin_template( 'notices/notification-drawer.php', true, true );
    }

    /**
     * Get all admin notices.
     *
     * @since 13.4.5
     * @access public
     *
     * @return array List of all admin notices data.
     */
    public function get_all_admin_notices() {
        // skip if notices are already loaded.
        if ( ! empty( $this->_notices ) ) {
            return apply_filters( 'adt_pfp_get_all_admin_notices', $this->_notices );
        }

        foreach ( $this->_get_cron_notices() as $notice_key => $notice_data ) {

            // skip if notice is already dismissed.
            if ( empty( $notice_data ) || get_option( $notice_data['option'] ) !== 'yes' ) {
                continue;
            }

            // Skip plugin recommendation if plugin is already installed.
            if ( isset( $notice_data['notice_type'] ) && 'plugin_recommendation' === $notice_data['notice_type'] && Helper::is_plugin_installed( $notice_data['plugin_basename'] ) ) {
                continue;
            }

            // Store notice data.
            $this->_notices[ $notice_key ] = $notice_data;

            // add notice security nonce value.
            if ( isset( $this->_notices[ $notice_key ] ) ) {
                $this->_notices[ $notice_key ]['nonce'] = wp_create_nonce( 'adt_pfp_dismiss_notice_' . $notice_key );
            }

            // Add notification metadata (read/unread status).
            $meta = $this->get_notification_meta( $notice_key );

            // Set first_shown_at timestamp if not set.
            if ( empty( $meta['first_shown_at'] ) ) {
                $meta['first_shown_at'] = time();
                $this->update_notification_meta( $notice_key, $meta );
            }

            $this->_notices[ $notice_key ]['meta']    = $meta;
            $this->_notices[ $notice_key ]['is_read'] = $meta['read'];

            // Add relative timestamp for display.
            $this->_notices[ $notice_key ]['timestamp'] = $this->get_relative_time( $meta['first_shown_at'] );

            // Add install action nonce for plugin recommendation notices.
            if ( isset( $notice_data['notice_type'] ) && 'plugin_recommendation' === $notice_data['notice_type'] ) {
                // Find the key of the actions with class adt-pfp-install-plugin.
                $actions            = $this->_notices[ $notice_key ]['actions'];
                $install_action_key = array_search( 'adt-pfp-install-plugin', array_column( $actions, 'class' ), true );

                // Only add nonce if the install action was found.
                if ( false !== $install_action_key ) {
                    $this->_notices[ $notice_key ]['actions'][ $install_action_key ]['nonce'] = wp_create_nonce( 'adt_install_plugin' );
                }
            }
        }

        return apply_filters( 'adt_pfp_get_all_admin_notices', array_filter( $this->_notices ) );
    }

    /**
     * Sort notices by first_shown_at timestamp (newest first).
     *
     * @since 13.4.5
     * @access public
     *
     * @param array $notices Array of notices to sort.
     * @return array Sorted notices array.
     */
    public function sort_notices_by_timestamp( $notices ) {
        uasort(
            $notices,
            function ( $a, $b ) {
                $time_a = $a['meta']['first_shown_at'] ?? 0;
                $time_b = $b['meta']['first_shown_at'] ?? 0;
                return $time_b - $time_a; // Descending order (newest first).
            }
        );
        return $notices;
    }

    /**
     * Display upgrade notice.
     *
     * @since 13.4.5
     * @access public
     *
     * @param string $notice_key       Notice key.
     * @param string $notice_option    Notice show option name.
     * @param bool   $on_settings      Toggle if showing on settings page or not.
     * @param bool   $show_navigation  Whether to show navigation for multiple notices.
     */
    public function print_admin_notice_content( $notice_key, $notice_option, $on_settings = false, $show_navigation = false ) {
        $notice_class  = $on_settings ? 'adt-pfp-settings-notice' : 'notice';
        $notice_class .= sprintf( ' adt-pfp-%s-notice', str_replace( '_', '-', $notice_key ) );

        $notices = $this->get_all_admin_notices();

        if ( isset( $notices[ $notice_key ] ) ) {

            $notice = $notices[ $notice_key ] ?? null;

            // don't display notice when data is not set.
            if ( ! $notice ) {
                return;
            }

            // Use Admin_Notice factory for all notices.
            $admin_notice = new Admin_Notice(
                $notice['message'] ?? '',
                $notice['type'] ?? 'info',
                $notice['is_dismissible'] ?? true,
                $notice['is_html'] ?? false,
                array(
                    'notice_id'       => $notice_key ?? '',
                    'class'           => $notice_class,
                    'image_url'       => $notice['image_url'] ?? '',
                    'actions'         => $notice['actions'] ?? array(),
                    'data'            => $notice['data'] ?? array(),
                    'nonce'           => $notice['nonce'] ?? '',
                    'show_navigation' => $show_navigation,
                ),
            );
            $admin_notice->run();
        }
    }

    /**
     * Update notice option.
     *
     * @since 13.4.5
     * @access private
     *
     * @param string $notice_key Notice key.
     * @param string $value      Option value.
     */
    public function update_notice_option( $notice_key, $value ) {
        $notice_data = $this->_get_cron_notices();
        $option      = isset( $notice_data[ $notice_key ] ) ? $notice_data[ $notice_key ]['option'] : null;

        if ( ! $option ) {
            return;
        }

        update_option( $option, $value );

        // Update metadata when dismissed.
        if ( 'dismissed' === $value ) {
            $meta                 = $this->get_notification_meta( $notice_key );
            $meta['dismissed_at'] = time();
            $meta['read']         = true;
            $this->update_notification_meta( $notice_key, $meta );
        }

        do_action( 'adt_pfp_notice_updated', $notice_key, $value, $option );
    }

    /**
     * Get notification metadata.
     *
     * @since 13.4.5
     * @access public
     *
     * @param string|null $notice_key Notice key. If null, returns all metadata.
     * @return array Notification metadata.
     */
    public function get_notification_meta( $notice_key = null ) {
        $all_meta = get_option( 'adt_notification_meta', array() );

        if ( null === $notice_key ) {
            return $all_meta;
        }

        return isset( $all_meta[ $notice_key ] ) ? $all_meta[ $notice_key ] : array(
            'read'              => false,
            'last_seen'         => null,
            'interaction_count' => 0,
            'dismissed_at'      => null,
            'first_shown_at'    => null,
        );
    }

    /**
     * Update notification metadata.
     *
     * @since 13.4.5
     * @access public
     *
     * @param string $notice_key Notice key.
     * @param array  $meta_data  Metadata to update.
     * @return bool True on success, false on failure.
     */
    public function update_notification_meta( $notice_key, $meta_data ) {
        $all_meta = get_option( 'adt_notification_meta', array() );

        $all_meta[ $notice_key ] = array_merge(
            isset( $all_meta[ $notice_key ] ) ? $all_meta[ $notice_key ] : array(),
            $meta_data
        );

        return update_option( 'adt_notification_meta', $all_meta );
    }

    /**
     * Mark notification as read.
     *
     * @since 13.4.5
     * @access public
     *
     * @param string $notice_key Notice key.
     * @return bool True on success, false on failure.
     */
    public function mark_notification_read( $notice_key ) {
        $meta = $this->get_notification_meta( $notice_key );

        $meta['read']              = true;
        $meta['last_seen']         = time();
        $meta['interaction_count'] = isset( $meta['interaction_count'] ) ? $meta['interaction_count'] + 1 : 1;

        return $this->update_notification_meta( $notice_key, $meta );
    }

    /**
     * Get unread notification count.
     *
     * @since 13.4.5
     * @access public
     *
     * @return int Number of unread notifications.
     */
    public function get_unread_count() {
        $active_notices = $this->get_all_admin_notices();
        $unread         = 0;

        foreach ( $active_notices as $key => $notice ) {
            if ( ! isset( $notice['is_read'] ) || ! $notice['is_read'] ) {
                ++$unread;
            }
        }

        return $unread;
    }

    /**
     * Cleanup old notification metadata.
     *
     * @since 13.4.5
     * @access public
     *
     * @param int $days Number of days to keep dismissed notifications. Default 90.
     * @return bool True on success, false on failure.
     */
    public function cleanup_old_notification_meta( $days = 90 ) {
        $all_meta = $this->get_notification_meta();
        $cutoff   = time() - ( DAY_IN_SECONDS * $days );

        foreach ( $all_meta as $key => $meta ) {
            if ( isset( $meta['dismissed_at'] ) && $meta['dismissed_at'] && $meta['dismissed_at'] < $cutoff ) {
                unset( $all_meta[ $key ] );
            }
        }

        return update_option( 'adt_notification_meta', $all_meta );
    }

    /**
     * Reschedule a single notice cron based when snoozed.
     *
     * @since 1.2
     * @access public
     *
     * @param string $key   Notice key.
     * @param string $value Option value.
     */
    public function reschedule_notice_cron( $key, $value ) {
        if ( 'snooze' !== $value ) {
            return;
        }

        $notices = $this->_get_cron_notices();
        $notice  = isset( $notices[ $key ] ) ? $notices[ $key ] : array();

        // Use Action Scheduler if available, otherwise fallback to wp_cron.
        if ( function_exists( 'as_unschedule_all_actions' ) ) {
            // Unschedule any existing actions for this notice.
            as_unschedule_all_actions( 'adt_pfp_cron_notices', array( $key ), 'adt-pfp-notices' );
        } else {
            // Fallback to wp_cron.
            $timestamp = wp_next_scheduled( 'adt_pfp_cron_notices', array( $key ) );
            if ( $timestamp ) {
                wp_unschedule_event( $timestamp, 'adt_pfp_cron_notices', array( $key ) );
            }
        }

        $this->_schedule_single_notice_cron( $key, $notice['option'], $notice['days'] );
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX methods
    |--------------------------------------------------------------------------
     */

    /**
     * AJAX dismiss admin notice.
     *
     * @since 13.4.5
     * @access public
     */
    public function ajax_dismiss_admin_notice() {
        $notice_key = isset( $_REQUEST['notice_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['notice_id'] ) ) : '';

        if ( defined( 'DOING_AJAX' )
            && DOING_AJAX
            && current_user_can( 'manage_options' )
            && $notice_key
            && isset( $_REQUEST['nonce'] )
            && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'adt_pfp_dismiss_notice_' . $notice_key )
        ) {
            $response = isset( $_REQUEST['response'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['response'] ) ) : '';

            do_action( 'adt_pfp_before_dismiss_admin_notice', $notice_key, $response );

            $response = 'snooze' === $response ? 'snooze' : 'dismissed';
            $this->update_notice_option( $notice_key, $response );
        }

        wp_die();
    }

    /**
     * AJAX mark notification as read.
     *
     * @since 13.4.5
     * @access public
     */
    public function ajax_mark_notice_read() {
        $notice_key = isset( $_REQUEST['notice_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['notice_id'] ) ) : '';

        if ( defined( 'DOING_AJAX' )
            && DOING_AJAX
            && current_user_can( 'manage_options' )
            && $notice_key
            && isset( $_REQUEST['nonce'] )
            && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'adt_pfp_mark_notice_read' )
        ) {
            $this->mark_notification_read( $notice_key );

            wp_send_json_success(
                array(
                    'message' => __( 'Notification marked as read.', 'woo-product-feed-pro' ),
                )
            );
        }

        wp_send_json_error(
            array(
                'message' => __( 'Failed to mark notification as read.', 'woo-product-feed-pro' ),
            )
        );
    }

    /**
     * AJAX mark all notifications as read.
     *
     * @since 13.4.5
     * @access public
     */
    public function ajax_mark_all_read() {
        if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX || ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Permission denied.', 'woo-product-feed-pro' ),
                )
            );
        }

        $nonce = isset( $_REQUEST['nonce'] ) ? sanitize_key( $_REQUEST['nonce'] ) : '';
        if ( ! wp_verify_nonce( $nonce, 'adt_pfp_mark_all_read' ) ) {
            wp_send_json_error(
                array(
                    'message' => __( 'Invalid security token.', 'woo-product-feed-pro' ),
                )
            );
        }

        $notice_ids = isset( $_REQUEST['notice_ids'] ) ? array_map( 'sanitize_text_field', wp_unslash( (array) $_REQUEST['notice_ids'] ) ) : array();
        if ( empty( $notice_ids ) ) {
            wp_send_json_error(
                array(
                    'message' => __( 'No notifications to mark as read.', 'woo-product-feed-pro' ),
                )
            );
        }

        $marked_count = 0;
        foreach ( $notice_ids as $notice_id ) {
            if ( $notice_id ) {
                $this->mark_notification_read( $notice_id );
                ++$marked_count;
            }
        }

        wp_send_json_success(
            array(
                'message' => sprintf(
                    /* translators: %d: number of notifications */
                    _n( '%d notification marked as read.', '%d notifications marked as read.', $marked_count, 'woo-product-feed-pro' ),
                    $marked_count
                ),
                'count'   => $marked_count,
            )
        );
    }

    /**
     * Temporary fix for Elite users.
     * Remove the action that shows the old review request notice. We will remove on the Elite side.
     * But, meantime, we need to remove it from the Free version.
     *
     * @since 13.4.5
     * @access public
     */
    public function remove_review_request_notice() {
        remove_action( 'admin_notices', 'woosea_elite_request_review', 10 );
    }

    /**
     * Get relative time string from timestamp.
     *
     * @since 13.4.5
     * @access private
     *
     * @param int $timestamp Unix timestamp.
     * @return string Relative time string (e.g., "5m ago", "2h ago", "3d ago").
     */
    private function get_relative_time( $timestamp ) {
        if ( empty( $timestamp ) ) {
            return __( 'Just now', 'woo-product-feed-pro' );
        }

        $diff = time() - $timestamp;

        if ( $diff < 60 ) {
            return __( 'Just now', 'woo-product-feed-pro' );
        } elseif ( $diff < 3600 ) {
            $minutes = floor( $diff / 60 );
            /* translators: %d: number of minutes */
            return sprintf( _n( '%dm ago', '%dm ago', $minutes, 'woo-product-feed-pro' ), $minutes );
        } elseif ( $diff < 86400 ) {
            $hours = floor( $diff / 3600 );
            /* translators: %d: number of hours */
            return sprintf( _n( '%dh ago', '%dh ago', $hours, 'woo-product-feed-pro' ), $hours );
        } elseif ( $diff < 604800 ) {
            $days = floor( $diff / 86400 );
            /* translators: %d: number of days */
            return sprintf( _n( '%dd ago', '%dd ago', $days, 'woo-product-feed-pro' ), $days );
        } else {
            $weeks = floor( $diff / 604800 );
            /* translators: %d: number of weeks */
            return sprintf( _n( '%dw ago', '%dw ago', $weeks, 'woo-product-feed-pro' ), $weeks );
        }
    }

    /**
     * Run the class
     *
     * @since 13.4.5
     */
    public function run() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_notice_scripts' ) );

        // Trigger cron notices.
        add_action( 'adt_pfp_cron_notices', array( $this, 'trigger_cron_notices' ) );

        add_action( 'admin_notices', array( $this, 'display_notices' ) );
        add_action( 'admin_footer', array( $this, 'render_notification_drawer' ) );

        add_action( 'wp_ajax_adt_pfp_dismiss_admin_notice', array( $this, 'ajax_dismiss_admin_notice' ) );
        add_action( 'wp_ajax_adt_pfp_mark_notice_read', array( $this, 'ajax_mark_notice_read' ) );
        add_action( 'wp_ajax_adt_pfp_mark_all_read', array( $this, 'ajax_mark_all_read' ) );
        add_action( 'adt_pfp_notice_updated', array( $this, 'reschedule_notice_cron' ), 10, 2 );

        if ( Helper::has_paid_plugin_active() ) {
            add_action( 'admin_init', array( $this, 'remove_review_request_notice' ), 10 );
        }
    }
}
