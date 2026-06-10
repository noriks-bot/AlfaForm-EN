<?php
/**
 * Integration instance objects.
 *
 * @package AdTribes\PFP
 */

use AdTribes\PFP\Integrations\WP_Rocket;
use AdTribes\PFP\Integrations\WWPP;

defined( 'ABSPATH' ) || exit;

return array_filter(
    array(
        new WP_Rocket(),
        new WWPP(),
    ),
);
