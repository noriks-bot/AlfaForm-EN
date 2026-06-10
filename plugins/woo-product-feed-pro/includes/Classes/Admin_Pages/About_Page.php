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
 * About_Page class.
 *
 * @since 13.4.4
 */
class About_Page extends Admin_Page {

    use Singleton_Trait;

    const MENU_SLUG = 'pfp-about-page';

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
        $this->parent_slug = 'woo-product-feed';
        $this->page_title  = __( 'About', 'woo-product-feed-pro' );
        $this->menu_title  = __( 'About', 'woo-product-feed-pro' );
        $this->capability  = apply_filters( 'adt_pfp_admin_capability', 'manage_options' );
        $this->menu_slug   = self::MENU_SLUG;
        $this->template    = 'about-page.php';
        $this->position    = 60;
    }

    /**
     * Get the admin menu priority.
     *
     * @since 13.4.4
     * @return int
     */
    protected function get_priority() {
        return 60;
    }
}
