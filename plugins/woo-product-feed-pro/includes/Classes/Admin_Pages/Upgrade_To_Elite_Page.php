<?php
/**
 * Author: Rymera Web Co.
 *
 * @package AdTribes\PFP\Classes\Admin_Pages
 */

namespace AdTribes\PFP\Classes\Admin_Pages;

use AdTribes\PFP\Abstracts\Admin_Page;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * Upgrade_To_Elite_Page class.
 *
 * @since 13.4.4
 */
class Upgrade_To_Elite_Page extends Admin_Page {

    use Singleton_Trait;

    const MENU_SLUG = 'upgrade-to-elite';

    /**
     * Holds the class instance object.
     *
     * @since 13.4.4
     * @var Upgrade_To_Elite_Page $instance
     */
    protected static $instance;

    /**
     * Initialize the class.
     *
     * @since 13.4.4
     */
    public function init() {
        $this->parent_slug = 'woo-product-feed';
        $this->page_title  = __( 'Upgrade To Elite', 'woo-product-feed-pro' );
        $this->menu_title  = __( 'Upgrade To Elite', 'woo-product-feed-pro' );
        $this->capability  = apply_filters( 'adt_pfp_admin_capability', 'manage_options' );
        $this->menu_slug   = self::MENU_SLUG;
        $this->template    = 'upgrade-to-elite.php';
        $this->position    = 70;
    }

    /**
     * Get the admin menu priority.
     *
     * @since 13.4.4
     * @return int
     */
    protected function get_priority() {
        return 70;
    }
}
