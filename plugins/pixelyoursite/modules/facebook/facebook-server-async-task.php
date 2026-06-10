<?php
namespace PixelYourSite;

defined('ABSPATH') or die('Direct access not allowed');

class FacebookAsyncTask extends \WP_Async_Task {
    protected $action = 'pys_send_server_event';

    protected function prepare_data($data) {
        try {
            if (!empty($data)) {
                if (empty($this->_body_data)) {
                    return array('data' => base64_encode(serialize($data)));
                } else {
                    $oldData = unserialize(base64_decode($this->_body_data['data']), ['allowed_classes' => [
                        'PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\Event',
                        'PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\UserData',
                        'PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\CustomData',
                        'PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\Content'
                    ]]);

                    // Check if $oldData[0] and $data[0] are arrays before merging
                    if (is_array($oldData[0]) && is_array($data[0])) {
                        $data = [ array_merge( $oldData[ 0 ], $data[ 0 ] ) ];
                    }
                    return array( 'data' => base64_encode( serialize( $data ) ) );
                }
            }
        } catch (\Exception $ex) {
            error_log($ex);
        }
        return array();
    }

    protected function run_action() {
        try {
            $data = unserialize(base64_decode($_POST['data']), ['allowed_classes' => [
                'PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\Event',
                'PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\UserData',
                'PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\CustomData',
                'PYS_PRO_GLOBAL\FacebookAds\Object\ServerSide\Content'

            ]]);
            $events = is_array($data[0]) ? $data[0] : $data ;
            if (empty($events)) {
                return;
            }
            foreach ($events as $event) {
                FacebookServer()->sendEvent($event["pixelIds"],$event["event"]);
            }
        }
        catch (\Exception $ex) {
            error_log($ex);
        }
    }
}