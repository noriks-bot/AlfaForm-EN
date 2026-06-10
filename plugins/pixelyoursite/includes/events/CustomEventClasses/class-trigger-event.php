<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class TriggerEvent {

    private $trigger_type                   = 'page_visit';
	private $index                          = 0;
	private $ready                          = false;
	private $delay                          = null;
	private $triggers                       = array();
	private $number_visit                   = null;
	private $conditional_number_visit       = null;
	private $forms                          = array();
	private $video_view_data                = array();
	private $video_view_urls                = array();
	private $video_view_triggers            = array();
	private $video_view_play_trigger        = '0%';
	private $video_view_disable_watch_video = false;
	private $disabled_form_action           = false;
	private $url_filters                    = array();
	private $post_type_value                = null;
	private $elementor_form_urls            = array();
	private $elementor_form_data            = array();

    private $form_field_data                = array();

    private $form_field_urls                = array();

    private $form_field_forms = '';

    private $form_field_fields = '';
	private $email_link_disable_email_event = false;
    private $purchase_transaction_only = false;
    private $track_value_and_currency = false;
    private $track_transaction_ID = false;
    private $form_submit_mode = 'both';
    private $form_field_type = '';
    private $created_via_est = false;

    public static $allowedTriggers = array(
        'page_visit',
        'home_page',
        'add_to_cart',
        'purchase',
        'number_page_visit',
        'url_click',
        'css_click',
        'css_mouseover',
        'scroll_pos',
        'post_type',
        'video_view',
        'email_link'
    );


    public function __construct( $trigger_type = 'page_visit', $index = null ) {
        $this->trigger_type = $trigger_type;
        if ( $index === null ) {
            $this->index = rand( 100, 200 );
        } else {
            $this->index = $index;
        }
        $eventsFormFactory = apply_filters( "pys_form_event_factory", array() );
        foreach ( $eventsFormFactory as $activeFormPlugin ) {
            self::$allowedTriggers[] = $activeFormPlugin->getSlug();
        }
    }

    public function getEventTriggers() {
        $payload = array(
            'trigger_type' => $this->getTriggerType(),
            'data'         => array()
        );
        switch ( $this->getTriggerType() ) {
            case 'url_click':
                {
                    foreach ( $this->getURLClickTriggers() as $trigger ) {
                        $payload[ 'data' ][] = $trigger;
                    }
                }
                break;
            case 'css_click':
                {
                    foreach ( $this->getCSSClickTriggers() as $trigger ) {
                        $payload[ 'data' ][] = $trigger[ 'value' ];
                    }
                }
                break;
            case 'css_mouseover':
                {
                    foreach ( $this->getCSSMouseOverTriggers() as $trigger ) {
                        $payload[ 'data' ][] = $trigger[ 'value' ];
                    }
                }
                break;
            case 'scroll_pos':
                {
                    foreach ( $this->getScrollPosTriggers() as $trigger ) {
                        $payload[ 'data' ][] = $trigger[ 'value' ];
                    }
                }
                break;
            case 'video_view':
                {
                    foreach ( $this->getVideoViewPlayTrigger() as $trigger ) {
                        $triggerData = $trigger;
                        $triggerData['disable_watch_video'] = $this->getVideoViewDisableWatchVideo();
                        $payload['data'][] = $triggerData;
                    }
                }
                break;
            case 'email_link':
                {
                    $payload[ 'data' ][] = array(
                        'disabled_email_link' => $this->getEmailLinkDisableEmailEvent(),
                        'rules'                => $this->getEmailLinkTriggers(),
                    );
                }
                break;
            default:
                break;
        }

        if ( $this->isFormTriggerType( $this->getTriggerType() ) ) {
            $payload[ 'data' ][] = array(
                'disabled_form_action' => $this->getParam( 'disabled_form_action' ),
                'forms'                => $this->getForms(),
            );
        }

        return $payload;
    }

    public function updateParam( $params, $value = '' ) {
        if ( !is_array( $params ) ) {
            $params = array( $params => $value );
        }
        foreach ( $params as $key => $param ) {
            if ( $param !== null && property_exists( $this, $key ) ) {
                $this->{$key} = $param;
            }
        }
    }

    public function getParam( $param ) {
        return $this->{$param} ?? null;
    }

    public function getTriggerStatus() {
        return $this->ready;
    }

    public function setTriggerStatus( $status ) {
        $this->ready = $status;
    }

    public function getTriggers() {
        return $this->triggers;
    }

    public function getTriggerType() {
        return $this->trigger_type;
    }

    public function getForms() {
        return $this->forms;
    }

    public function getDelay() {
        return $this->delay;
    }

    public function isFormTriggerType( $trigger_type ) {
        $form_trigger_type = array();
        $eventsFormFactory = apply_filters( "pys_form_event_factory", [] );
        foreach ( $eventsFormFactory as $activeFormPlugin ) :
            $form_trigger_type[] = $activeFormPlugin->getSlug();
        endforeach;

        if ( in_array( $trigger_type, $form_trigger_type ) ) {
            return true;
        }
        return false;
    }

    public function getTriggerIndex() {
        return $this->index;
    }

    /**
     * @return array
     */
    public function getPageVisitTriggers() {
        return $this->trigger_type == 'page_visit' ? $this->triggers : array();
    }

    /**
     * @return array
     */
    public function getNumberPageVisitTriggers() {
        return $this->trigger_type == 'number_page_visit' ? $this->triggers : array();
    }

    /**
     * @return array
     */
    public function getURLClickTriggers() {
        return $this->trigger_type == 'url_click' ? $this->triggers : array();
    }

    /**
     * @return array
     */
    public function getCSSClickTriggers() {
        return $this->trigger_type == 'css_click' ? $this->triggers : array();
    }

    /**
     * @return array
     */
    public function getCSSMouseOverTriggers() {
        return $this->trigger_type == 'css_mouseover' ? $this->triggers : array();
    }

    /**
     * @return array
     */
    public function getScrollPosTriggers() {
        return $this->trigger_type == 'scroll_pos' ? $this->triggers : array();
    }

    /**
     * @return array
     */
    public function getURLFilters() {
        return in_array( $this->trigger_type, array(
            'url_click',
            'css_click',
            'css_mouseover',
            'scroll_pos'
        ) ) ? $this->url_filters : array();
    }

    public function getVideoViewTriggers() {
        return $this->trigger_type == 'video_view' ? $this->video_view_triggers : array();
    }

    public function getVideoViewData() {
        return $this->trigger_type == 'video_view' ? $this->video_view_data : array();
    }

    public function getVideoViewUrls() {
        return $this->trigger_type == 'video_view' ? $this->video_view_urls : array();
    }

    public function getVideoViewPlayTrigger() {
        return $this->trigger_type == 'video_view' ? $this->triggers : array();
    }

    public function getVideoViewDisableWatchVideo() {
        return $this->trigger_type == 'video_view' ? $this->video_view_disable_watch_video : true;
    }

    public function getNumberVisit() {
        return $this->number_visit;
    }

    public function getConditionalNumberVisit() {
        return $this->conditional_number_visit;
    }

    public function getPostTypeValue() {
        return $this->post_type_value;
    }

    public function getElementorFormData() {
        return $this->trigger_type == 'elementor_form' ? $this->elementor_form_data : array();
    }

    public function getElementorFormUrls() {
        return $this->trigger_type == 'elementor_form' ? $this->elementor_form_urls : array();
    }

    public function getEmailLinkTriggers() {
        return $this->trigger_type == 'email_link' ? $this->triggers : array();
    }

    public function getEmailLinkDisableEmailEvent() {
        return $this->trigger_type == 'email_link' ? $this->email_link_disable_email_event : true;
    }

    public function migrateTriggerData( $trigger_type, $data ) {
        switch ( $trigger_type ) {
            case 'number_page_visit':
                $this->updateParam( array(
                    'conditional_number_visit' => $data[ 'conditional_number_visit' ] ?? '',
                    'number_visit'             => $data[ 'number_visit' ] ?? '',
                    'triggers'                 => $data[ 'triggers' ] ?? '',
                ) );
                break;

            case 'page_visit':
            case 'home_page':
            case 'url_click':
            case 'css_click':
            case 'css_mouseover':
            case 'scroll_pos':
                $this->updateParam( array(
                    'triggers' => $data[ 'triggers' ] ?? '',
                ) );
                break;

            case 'post_type':
                $this->updateParam( array(
                    'post_type_value' => $data[ 'post_type_value' ] ?? '',
                ) );
                break;

            case 'video_view':
                $this->updateParam( array(
                    'video_view_data'                => $data[ 'video_view_data' ] ?? '',
                    'video_view_urls'                => $data[ 'video_view_urls' ] ?? '',
                    'video_view_triggers'            => $data[ 'video_view_triggers' ] ?? '',
                    'video_view_play_trigger'        => $data[ 'video_view_play_trigger' ] ?? '',
                    'video_view_disable_watch_video' => $data[ 'video_view_disable_watch_video' ] ?? '',
                    'triggers'                       => $data[ 'triggers' ] ?? '',
                ) );
                break;
            case 'elementor_form':
                $this->updateParam( array(
                    'elementor_form_urls' => $data[ 'elementor_form_urls' ] ?? '',
                    'elementor_form_data' => $data[ 'elementor_form_data' ] ?? '',
                ) );
                break;
            case 'email_link':
                $this->updateParam( array(
                    'email_link_disable_email_event' => $data[ 'email_link_disable_email_event' ] ?? '',
                    'triggers'                       => $data[ 'triggers' ] ?? '',
                ) );
                break;

            default:
                break;
        }

        if ( $this->isFormTriggerType( $this->getTriggerType() ) ) {
            $this->updateParam( array(
                'disabled_form_action' => $data[ 'disabled_form_action' ] ?? '',
                'forms'                => $data[ 'forms' ] ?? '',
            ) );
        }

        $this->updateParam( array(
            'delay'       => $data[ 'delay' ] ?? '',
            'url_filters' => $data[ 'url_filters' ] ?? '',
        ) );
    }

}