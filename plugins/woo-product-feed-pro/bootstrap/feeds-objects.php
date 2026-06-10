<?php
/**
 * Class objects instance list.
 *
 * @since   13.4.5
 * @package AdTribes\PFP
 */

use AdTribes\PFP\Classes\Feeds\Google_Product_Review;
use AdTribes\PFP\Classes\Feeds\OpenAI_Product_Feed;

defined( 'ABSPATH' ) || exit;

return array(
    Google_Product_Review::instance(),
    OpenAI_Product_Feed::instance(),
);
