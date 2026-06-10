<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP
 */

namespace AdTribes\PFP\Abstracts;

defined( 'ABSPATH' ) || exit;

/**
 * Abstract Class
 */
abstract class Abstract_Class {

    /**
     * Magic get method.
     *
     * @since 13.3.3
     * @access public
     *
     * @param string $key The key to get.
     * @return null|mixed
     */
    public function __get( $key ) {

        return $this->$key ?? null;
    }

    /**
     * Run the class
     *
     * @since 13.3.3
     * @access public
     */
    abstract public function run();
}
