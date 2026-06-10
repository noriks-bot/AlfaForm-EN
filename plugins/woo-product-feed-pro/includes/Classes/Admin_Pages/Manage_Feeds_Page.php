<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes\Admin_Pages
 */

namespace AdTribes\PFP\Classes\Admin_Pages;

use AdTribes\PFP\Abstracts\Admin_Page;
use AdTribes\PFP\Factories\Vite_App;
use AdTribes\PFP\Traits\Singleton_Trait;
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Classes\Notices;

/**
 * Manage_Feeds_Page class.
 *
 * @since 13.4.4
 */
class Manage_Feeds_Page extends Admin_Page {

    use Singleton_Trait;

    const MENU_SLUG = 'woo-product-feed';

    /**
     * Holds the class instance object
     *
     * @since 13.4.4
     * @access protected
     *
     * @var Singleton_Trait $instance object
     */
    protected static $instance;

    /**
     * Initialize the class.
     *
     * @since 13.4.4
     */
    public function init() {
        $this->page_title = apply_filters( 'adt_admin_plugin_page_title', __( 'Product Feed Pro for WooCommerce', 'woo-product-feed-pro' ) );
        $this->menu_title = apply_filters( 'adt_admin_plugin_menu_title', __( 'Product Feed', 'woo-product-feed-pro' ) );
        $this->capability = apply_filters( 'adt_pfp_admin_capability', 'manage_options' );
        $this->menu_slug  = self::MENU_SLUG;
        $this->template   = 'manage-feeds.php';
        $this->icon       = esc_url( ADT_PFP_IMAGES_URL . 'icon-16x16.png' );
        $this->position   = 99;
    }

    /**
     * Get the admin menu priority.
     *
     * @since 13.4.4
     * @return int
     */
    protected function get_priority() {
        return 10;
    }

    /**
     * Enqueue admin scripts.
     *
     * @since 13.4.4
     * @return void
     */
    public function enqueue_scripts() {
        $l10n = Helper::vite_app_common_l10n(
            array(
                'adtNonce'            => wp_create_nonce( 'adt_nonce' ),
                'feedPollingInterval' => apply_filters( 'adt_pfp_feed_polling_interval', 5000 ),
            )
        );

        $app = new Vite_App(
            'adt-manage-feeds-script',
            'src/vanilla/manage-feeds/index.ts',
            array( 'jquery', 'wp-i18n', Helper::get_wc_script_handle( 'select2' ) ),
            $l10n,
            'adtObj',
            array( 'woocommerce_admin_styles' )
        );
        $app->enqueue();
    }

    /**
     * Add a submenu page.
     *
     * @since 13.4.4
     */
    public function admin_menu() {
        parent::admin_menu();

        add_submenu_page(
            $this->menu_slug,
            __( 'Manage feeds', 'woo-product-feed-pro' ),
            __( 'Manage feeds', 'woo-product-feed-pro' ),
            $this->capability,
            $this->menu_slug,
            array( $this, 'load_admin_page' ),
            10
        );

        // Add notification badge to menu.
        $this->add_notification_badge_to_menu();
    }

    /**
     * Add notification badge to menu title.
     *
     * @since 13.4.5
     * @return void
     */
    private function add_notification_badge_to_menu() {
        global $menu;

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $notices      = Notices::instance();
        $unread_count = $notices->get_unread_count();

        if ( $unread_count > 0 ) {
            foreach ( $menu as $key => $item ) {
                if ( isset( $item[2] ) && self::MENU_SLUG === $item[2] ) {
                    // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Intentionally modifying menu item for notification badge.
                    $menu[ $key ][0] .= sprintf(
                        ' <span class="update-plugins count-%1$d"><span class="update-count">%2$d</span></span>',
                        $unread_count,
                        $unread_count
                    );
                    break;
                }
            }
        }
    }

    /**
     * Get product feed setting URL.
     *
     * @since 13.3.5
     * @access public
     *
     * @param int $id The product feed ID.
     * @return string
     */
    public static function get_product_feed_setting_url( $id ) {
        $args = array(
            'page' => 'adt-edit-feed',
            'id'   => $id,
        );

        return esc_url( add_query_arg( $args, admin_url( 'admin.php' ) ) );
    }

    /**
     * Add the edit feed action.
     *
     * @since 13.4.4
     * @param object $feed The product feed object.
     */
    public function add_edit_feed_action( $feed ) {
        $actions = array(
            'edit'      => array(
                'class' => 'adt-manage-feeds-action-edit',
                'url'   => self::get_product_feed_setting_url( $feed->id ),
                'label' => __( 'Edit Feed', 'woo-product-feed-pro' ),
                'icon'  => 'lucide--pencil',
            ),
            'duplicate' => array(
                'class' => 'adt-manage-feeds-action-duplicate',
                'label' => __( 'Duplicate Feed', 'woo-product-feed-pro' ),
                'icon'  => 'lucide--files',
            ),
            'refresh'   => array(
                'class' => 'adt-manage-feeds-action-refresh',
                'label' => __( 'Refresh Feed', 'woo-product-feed-pro' ),
                'icon'  => 'lucide--refresh-cw',
            ),
            'cancel'    => array(
                'class' => 'adt-manage-feeds-action-cancel',
                'label' => __( 'Cancel Feed Processing', 'woo-product-feed-pro' ),
                'icon'  => 'lucide--x',
            ),
            'delete'    => array(
                'class' => 'adt-manage-feeds-action-delete',
                'label' => __( 'Delete Feed', 'woo-product-feed-pro' ),
                'icon'  => 'lucide--trash-2',
            ),
        );

        /**
         * Filter the actions for the manage feeds table row.
         *
         * @since 13.4.4
         * @param array $actions The actions.
         * @param object $feed The product feed object.
         */
        $actions = apply_filters( 'adt_manage_feeds_row_actions', $actions, $feed );

        ob_start();
        Helper::locate_admin_template(
            'components/manage-feeds-table-row-action-item.php',
            true,
            false,
            array(
                'actions' => $actions,
                'feed'    => $feed,
            )
        );
        $html = ob_get_clean();

        echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * Run the class.
     *
     * @since 13.4.4
     * @return void
     */
    public function run() {
        parent::run();

        add_action( 'adt_manage_feeds_table_row_actions', array( $this, 'add_edit_feed_action' ) );
    }
}
