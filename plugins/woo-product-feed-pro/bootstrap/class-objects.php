<?php
/**
 * Class objects instance list.
 *
 * @since   13.3.3
 * @package AdTribes\PFP
 */

use AdTribes\PFP\Classes\WP_Admin;
use AdTribes\PFP\Classes\Notices;
use AdTribes\PFP\Classes\Product_Feed_Admin;
use AdTribes\PFP\Classes\Product_Feed_Attributes;
use AdTribes\PFP\Classes\Product_Data;
use AdTribes\PFP\Classes\Shipping_Data;
use AdTribes\PFP\Classes\Filters;
use AdTribes\PFP\Classes\Rules;
use AdTribes\PFP\Classes\Cron;
use AdTribes\PFP\Classes\Heartbeat;
use AdTribes\PFP\Classes\Marketing;
use AdTribes\PFP\Classes\Usage;
use AdTribes\PFP\Classes\Google_Product_Taxonomy_Fetcher;
use AdTribes\PFP\Classes\Plugin_Installer;
use AdTribes\PFP\Classes\Admin_Pages\Manage_Feeds_Page;
use AdTribes\PFP\Classes\Admin_Pages\Settings_Page;
use AdTribes\PFP\Classes\Admin_Pages\Edit_Feed_Page;
use AdTribes\PFP\Classes\Admin_Pages\License_Page;
use AdTribes\PFP\Classes\Admin_Pages\Help_Page;
use AdTribes\PFP\Classes\Admin_Pages\About_Page;
use AdTribes\PFP\Classes\Admin_Pages\Upgrade_To_Elite_Page;
use AdTribes\PFP\Classes\Feed_Writers\Feed_Writer_JSONL;
use AdTribes\PFP\Post_Types\Product_Feed_Post_Type;
use AdTribes\PFP\Classes\Upsell;
use AdTribes\PFP\Classes\Legacy\Filters_Legacy;
use AdTribes\PFP\Classes\Legacy\Rules_Legacy;
use AdTribes\PFP\Classes\Export_Import_Tools;

defined( 'ABSPATH' ) || exit;

return array(
    Product_Feed_Admin::instance(),
    Notices::instance(),
    Product_Feed_Attributes::instance(),
    Product_Data::instance(),
    Shipping_Data::instance(),
    Filters::instance(),
    Rules::instance(),
    Cron::instance(),
    Heartbeat::instance(),
    WP_Admin::instance(),
    Marketing::instance(),
    Usage::instance(),
    Google_Product_Taxonomy_Fetcher::instance(),
    Plugin_Installer::instance(),
    Manage_Feeds_Page::instance(),
    Settings_Page::instance(),
    Edit_Feed_Page::instance(),
    License_Page::instance(),
    Help_Page::instance(),
    About_Page::instance(),
    Upgrade_To_Elite_Page::instance(),
    Feed_Writer_JSONL::instance(),
    Product_Feed_Post_Type::instance(),
    Upsell::instance(),
    Filters_Legacy::instance(),
    Rules_Legacy::instance(),
    Export_Import_Tools::instance(),
);
