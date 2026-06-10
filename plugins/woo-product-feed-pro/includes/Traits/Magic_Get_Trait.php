<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Traits
 */

namespace AdTribes\PFP\Traits;

trait Magic_Get_Trait {

    /**
     * Magic get method.
     *
     * @param string $key The key to get.
     *
     * @return null|mixed
     * @since 13.4.6
     */
    public function __get( $key ) {

        return $this->$key ?? null;
    }
}
