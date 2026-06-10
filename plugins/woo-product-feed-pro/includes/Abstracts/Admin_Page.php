<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Abstracts
 */

namespace AdTribes\PFP\Abstracts;

use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Traits\Singleton_Trait;

/**
 * Class AdminPage
 *
 * @since 13.4.4
 */
abstract class Admin_Page extends Abstract_Class {

    use Singleton_Trait;

    /**
     * Holds the class instance object.
     *
     * @since 13.4.4
     * @var Admin_Page $instance
     */
    protected static $instance;

    /**
     * Holds the admin page hook suffix.
     *
     * @since 13.4.4
     * @var string The admin page hook suffix.
     */
    protected $hook_suffix;

    /**
     * Holds the admin page title.
     *
     * @since 13.4.4
     * @var string The admin page title.
     */
    protected $page_title;

    /**
     * Holds the admin menu title.
     *
     * @since 13.4.4
     * @var string The admin menu title.
     */
    protected $menu_title;

    /**
     * Holds the admin menu capability.
     *
     * @since 13.4.4
     * @var string The admin menu capability.
     */
    protected $capability;

    /**
     * Holds the admin menu slug.
     *
     * @since 13.4.4
     * @var string The admin menu slug.
     */
    protected $menu_slug;

    /**
     * Holds the admin menu callback.
     *
     * @since 13.4.4
     * @var string|callable|array|null The admin menu callback.
     */
    protected $callback;

    /**
     * Holds the admin menu icon file path.
     *
     * @since 13.4.4
     * @var string|null The admin menu icon.
     */
    protected $icon;

    /**
     * Holds the admin menu position.
     *
     * @since 13.4.4
     * @var int|float|null The admin menu position.
     */
    protected $position;

    /**
     * Holds the parent admin page slug if we are creating a submenu page.
     *
     * @since 13.4.4
     * @var string The parent admin page if this is a sub menu page.
     */
    protected $parent_slug;

    /**
     * Holds the `admin_menu` hook priority.
     *
     * @since 13.4.4
     * @var int
     */
    protected $priority;

    /**
     * Holds the admin page template file relative to `templates/admin`.
     *
     * @since 13.4.4
     * @var string
     */
    protected $template;

    /**
     * Holds the admin page template arguments.
     *
     * @since 13.4.7
     * @var array
     */
    protected $template_args;

    /**
     * Initialize the admin page.
     *
     * @since 13.4.4
     * @return void
     */
    abstract protected function init();

    /**
     * Get the admin menu priority.
     *
     * @since 13.4.4
     * @return int
     */
    protected function get_priority() {

        return $this->priority ?? 10;
    }

    /**
     * Add the admin page to the admin menu.
     *
     * @since 13.4.4
     * @return void
     */
    public function admin_menu() {
        $this->init();

        // If the admin page is not enabled, do not add it to the admin menu.
        if ( ! $this->is_enabled() ) {
            return;
        }

        /***************************************************************************
         * Set as sub-menu page or menu page
         ***************************************************************************
         *
         * Set as sub-menu page or menu page based on the parent_slug property.
         */
        if ( $this->parent_slug ) {
            $this->hook_suffix = add_submenu_page(
                $this->parent_slug,
                $this->page_title,
                $this->menu_title,
                $this->capability,
                $this->menu_slug,
                array( $this, 'load_admin_page' ),
                $this->position
            );
        } else {
            $this->hook_suffix = add_menu_page(
                $this->page_title,
                $this->menu_title,
                $this->capability,
                $this->menu_slug,
                array( $this, 'load_admin_page' ),
                $this->icon,
                $this->position
            );
        }

        add_action( "load-$this->hook_suffix", array( $this, 'load_admin_page_hooks' ) );
    }

    /**
     * Maybe enqueue app scripts.
     *
     * @param string $hook_suffix The current admin page hook suffix.
     *
     * @since 13.4.4
     * @return void
     */
    public function admin_enqueue_scripts( $hook_suffix ) {
        // If the admin page is not enabled, do not enqueue scripts.
        if ( ! $this->is_enabled() ) {
            return;
        }

        if ( $this->hook_suffix === $hook_suffix && method_exists( $this, 'enqueue_scripts' ) ) {
            $this->enqueue_scripts();
        }
    }

    /**
     * Load admin page hooks.
     *
     * @since 13.4.4
     * @return void
     */
    public function load_admin_page_hooks() {

        if ( method_exists( $this, 'run_admin_page_hooks' ) ) {
            $this->run_admin_page_hooks();
        }
    }

    /**
     * Render the admin page.
     *
     * @since 13.4.4
     * @return void
     */
    public function load_admin_page() {

        Helper::locate_admin_template( $this->template, true, true, $this->template_args );
    }

    /**
     * Check if the admin page is enabled.
     *
     * @since 13.4.4
     * @return bool
     */
    protected function is_enabled() {
        return apply_filters( 'adt_show_pfp_' . $this->menu_slug . '_page', true );
    }

    /**
     * Enqueue scripts for the admin page.
     *
     * Child classes can override this method to enqueue specific scripts and styles.
     *
     * @since 13.4.4
     * @return void
     */
    protected function enqueue_scripts() {}

    /**
     * Run admin page hooks.
     *
     * @since 13.4.4
     * @return void
     */
    protected function run_admin_page_hooks() {}

    /**
     * Add hook handlers for rendering the admin page.
     *
     * @since 13.4.4
     * @return void
     */
    public function run() {

        add_action( 'admin_menu', array( $this, 'admin_menu' ), $this->get_priority() );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
    }
}
