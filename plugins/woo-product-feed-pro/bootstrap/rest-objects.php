<?php
/**
 * REST objects.
 *
 * @since   13.4.3
 * @package AdTribes\PFP
 */

use AdTribes\PFP\REST\API;
use AdTribes\PFP\REST\Filters_Rules;

defined( 'ABSPATH' ) || exit;

return array(
    API::instance(),
    Filters_Rules::instance(),
);
