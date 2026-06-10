<?php

namespace PixelYourSite;
defined('ABSPATH') || exit;

require_once PYS_FREE_PATH . '/containers_gtm/containerDownloads.php';

class gtmContainers extends containerDownloads {

    public function __construct() {
        parent::__construct(trailingslashit(PYS_FREE_PATH) . 'containers_gtm/');
    }

    protected function getContainers() {
        return [
            [
                'enable' => true,
                'file_name' => 'GTM-PYS-v1-1.json',
                'show_name' => 'GTM Container Version 1.1',
                'description' => 'Once the file is imported, the GTM Container will have triggers for our events, and variables for our parameters. Version 1.1 comes with GA4 tag support. You must edit the GA4 ID variable and add your own GA4 tag ID.'
            ]
        ];
    }

    /**
     * Public method to get containers for display purposes
     *
     * @return array Array of containers with file information
     */
    public function getContainersForDisplay() {
        return $this->getContainers();
    }
}
