<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'PYS_FREE_VERSION', '11.2.0.4' );
define( 'PYS_FREE_PINTEREST_MIN_VERSION', '6.2.0' );
define( 'PYS_FREE_BING_MIN_VERSION', '4.2.0' );
define( 'PYS_FREE_REDDIT_MIN_VERSION', '1.1.0' );
define( 'PYS_FREE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'PYS_FREE_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'PYS_FREE_PLUGIN_FILE', __FILE__ );
define( 'PYS_FREE_PLUGIN_BASENAME', plugin_basename( PYS_FREE_PLUGIN_FILE ) );
define( 'PYS_FREE_GTM_CONTAINERS_PATH', untrailingslashit( plugin_dir_url( __FILE__ ) ) .'/containers_gtm/' );

define( 'PYS_FREE_PLUGIN_ICON', PYS_FREE_URL . '/dist/images/pys-logo.svg');
define( 'PYS_FREE_VIEW_PATH', PYS_FREE_PATH . '/includes/views' );

//Video link in the bottom bar
define( 'PYS_FREE_VIDEO_URL', 'https://www.youtube.com/watch?v=fAwsayYLo5s' );
define( 'PYS_FREE_VIDEO_TITLE', 'Meta Pixel and API setup - Boost EMQ'  );

require_once PYS_FREE_PATH.'/vendor/autoload.php';
require_once PYS_FREE_PATH.'/includes/logger/class-pys-logger.php';
require_once PYS_FREE_PATH.'/includes/class-event-id-generator.php';
require_once PYS_FREE_PATH.'/includes/class-event-definitions.php';
require_once PYS_FREE_PATH.'/includes/functions-common.php';
require_once PYS_FREE_PATH.'/includes/functions-buttons.php';
require_once PYS_FREE_PATH.'/includes/functions-admin.php';
require_once PYS_FREE_PATH.'/includes/events/class-event.php';
require_once PYS_FREE_PATH.'/includes/events/interface-events.php';
require_once PYS_FREE_PATH.'/includes/events/class-event-single.php';
require_once PYS_FREE_PATH.'/includes/events/class-event-grouped.php';
require_once PYS_FREE_PATH.'/includes/events/class-events-automatic.php';
require_once PYS_FREE_PATH.'/includes/events/class-events-woo.php';
require_once PYS_FREE_PATH.'/includes/events/class-events-edd.php';
require_once PYS_FREE_PATH.'/includes/events/class-events-fdp.php';
require_once PYS_FREE_PATH.'/includes/events/class-events-custom.php';

require_once PYS_FREE_PATH .'/containers_gtm/container.php';
require_once PYS_FREE_PATH.'/includes/functions-custom-event.php';
require_once PYS_FREE_PATH.'/includes/functions-woo.php';
require_once PYS_FREE_PATH.'/includes/functions-edd.php';
require_once PYS_FREE_PATH.'/includes/functions-system-report.php';
require_once PYS_FREE_PATH.'/includes/functions-license.php';
require_once PYS_FREE_PATH.'/includes/functions-update-plugin.php';
require_once PYS_FREE_PATH.'/includes/functions-gdpr.php';
require_once PYS_FREE_PATH.'/includes/functions-migrate.php';
require_once PYS_FREE_PATH.'/includes/class-fixed-notices.php';
require_once PYS_FREE_PATH.'/includes/class-optin-notices.php';
require_once PYS_FREE_PATH.'/includes/class-pixel.php';
require_once PYS_FREE_PATH.'/includes/class-settings.php';
require_once PYS_FREE_PATH.'/includes/class-plugin.php';
require_once PYS_FREE_PATH.'/includes/class-consent.php';

require_once PYS_FREE_PATH.'/includes/class-events-manager-ajax_hook.php';
require_once PYS_FREE_PATH.'/includes/class-pys.php';
require_once PYS_FREE_PATH.'/includes/class-events-manager.php';
require_once PYS_FREE_PATH.'/includes/class-custom-event.php';
require_once PYS_FREE_PATH.'/includes/class-custom-event-factory.php';
require_once PYS_FREE_PATH.'/includes/events/CustomEventClasses/class-settings-custom-event.php';
require_once PYS_FREE_PATH.'/includes/events/CustomEventClasses/class-trigger-event.php';
require_once PYS_FREE_PATH.'/includes/events/CustomEventClasses/class-conditional-event.php';
require_once PYS_FREE_PATH.'/modules/facebook/facebook.php';
require_once PYS_FREE_PATH.'/modules/facebook/facebook-server.php';
require_once PYS_FREE_PATH.'/modules/facebook/class-facebook-rest-api.php';
require_once PYS_FREE_PATH.'/modules/google_analytics/ga.php';
require_once PYS_FREE_PATH.'/modules/google_tags/gatags.php';
require_once PYS_FREE_PATH.'/modules/google_gtm/gtm.php';
require_once PYS_FREE_PATH.'/modules/head_footer/head_footer.php';
require_once PYS_FREE_PATH.'/includes/enrich/class_enrich_order.php';


require_once PYS_FREE_PATH.'/includes/formEvents/interface-formEvents.php';
require_once PYS_FREE_PATH.'/includes/formEvents/CF7/class-formEvent-CF7.php';
require_once PYS_FREE_PATH.'/includes/formEvents/forminator/class-formEvent-Forminator.php';
require_once PYS_FREE_PATH.'/includes/formEvents/WPForms/class-formEvent-WPForms.php';
require_once PYS_FREE_PATH.'/includes/formEvents/Formidable/class-formEvent-Formidable.php';
require_once PYS_FREE_PATH.'/includes/formEvents/NinjaForm/class-formEvent-NinjaForm.php';
require_once PYS_FREE_PATH.'/includes/formEvents/FluentForm/class-formEvent-FluentForm.php';
require_once PYS_FREE_PATH.'/includes/formEvents/WSForm/class-formEvent-WSForm.php';
require_once PYS_FREE_PATH.'/includes/formEvents/ElementorForm/ElementorForm.php';
// here we go...
PixelYourSite\PYS();

add_action( 'init', function() {
    \PixelYourSite\Facebook_REST_API();
}, 9 );
