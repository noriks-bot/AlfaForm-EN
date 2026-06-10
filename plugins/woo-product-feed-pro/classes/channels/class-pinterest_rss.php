<?php
/**
 * Settings for Pinterest RSS Boards feeds
 */
class WooSEA_Pinterest_Rss {

    /**
     * Channel attributes.
     *
     * @var array
     */
    public $pinterest_rss;

    /**
     * Get channel attributes.
     *
     * @return array
     */
    public static function get_channel_attributes() {
        $sitename = get_option( 'blogname' );

        $pinterest_rss = array(
            'Pinterest RSS fields' => array(
                'Title'       => array(
                    'name'        => 'title',
                    'feed_name'   => 'title',
                    'format'      => 'required',
                    'woo_suggest' => 'title',
                ),
                'Description' => array(
                    'name'        => 'description',
                    'feed_name'   => 'description',
                    'format'      => 'required',
                    'woo_suggest' => 'description',
                ),
                'Link'        => array(
                    'name'        => 'link',
                    'feed_name'   => 'link',
                    'format'      => 'required',
                    'woo_suggest' => 'link',
                ),
                'guid'        => array(
                    'name'        => 'guid',
                    'feed_name'   => 'guid',
                    'format'      => 'required',
                    'woo_suggest' => 'link_no_tracking',
                ),
                'Image'       => array(
                    'name'        => 'image',
                    'feed_name'   => 'image',
                    'format'      => 'required',
                    'woo_suggest' => 'image',
                ),
            ),
        );
        return $pinterest_rss;
    }
}
