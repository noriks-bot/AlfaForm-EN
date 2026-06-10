<?php
namespace PixelYourSite;
class EventsCustom extends EventsFactory {
    private static $_instance;
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;

    }

    static function getSlug() {
        return "custom";
    }

    private function __construct() {
        add_filter("pys_event_factory",[$this,"register"]);
    }

    function register($list) {
        $list[] = $this;
        return $list;
    }


    function getEvents(){
        return CustomEventFactory::get( 'active' );
    }

    function getCount()
    {
        if(!$this->isEnabled()) {
            return 0;
        }
        return count($this->getEvents());
    }

    function isEnabled()
    {
        return PYS()->getOption( 'custom_events_enabled' );
    }

    function getOptions()
    {
        return array();
    }

    /**
     * @param CustomEvent $event
     * @return bool
     */
    function isReadyForFire($event)
    {
        $event_triggers = $event->getTriggers();
        $isReady = array();
        if ( !empty( $event_triggers ) ) {
            foreach ($event_triggers as $event_trigger) {
                $trigger_type = $event_trigger->getTriggerType();

                switch ($trigger_type) {
                    case 'post_type' :
                    {
                        $isTriggerReady = $event_trigger->getPostTypeValue() == get_post_type();
                        $event_trigger->setTriggerStatus( $isTriggerReady );
                        $isReady[] = $isTriggerReady;
                        break;
                    }
                    case 'page_visit':
                    {
                        $triggers = $event_trigger->getPageVisitTriggers();
                        $isTriggerReady = !empty( $triggers ) && compareURLs( $triggers );
                        $event_trigger->setTriggerStatus( $isTriggerReady );
                        $isReady[] = $isTriggerReady;
                        break;
                    }
                    case 'home_page':
                    {
                        $isTriggerReady = is_front_page();
                        $event_trigger->setTriggerStatus( $isTriggerReady );
                        $isReady[] = $isTriggerReady;
                        break;
                    }
                    case 'scroll_pos':
                    {
                        $triggers = $event_trigger->getScrollPosTriggers();
                        $isTriggerReady = !empty( $triggers );
                        $event_trigger->setTriggerStatus( $isTriggerReady );
                        $isReady[] = $isTriggerReady;
                        break;
                    }

                }
            }
        }
        return in_array( true, $isReady );
    }
    /**
     * @param CustomEvent $event
     * @return PYSEvent
     */
    function getEvent($event)
    {
        $event_triggers = $event->getTriggers();
        $trigger_types = array();
        $eventObject = null;
        $eventId = $event->getPostId();
        $triggerEventTypes = array();

        if ( !empty( $event_triggers ) ) {
            foreach ( $event_triggers as $event_trigger ) {
                if ( $event_trigger->getTriggerStatus() ) {
                    $trigger_type = $event_trigger->getTriggerType();
                    switch ($trigger_type) {
                        case 'page_visit':
                        case 'post_type' :
                        case 'home_page':
                        {
                            $trigger_types[] = EventTypes::$STATIC;
                            break;
                        }
                        case 'scroll_pos':
                            $trigger_types[] = EventTypes::$TRIGGER;
                            break;
                    }
                    $trigger = $event_trigger->getEventTriggers( $event_trigger );

                    if ( isset( $triggerEventTypes[ $trigger[ 'trigger_type' ] ][ $eventId ] ) ) {
                        $triggerEventTypes[ $trigger[ 'trigger_type' ] ][ $eventId ] = array_merge( $triggerEventTypes[ $trigger[ 'trigger_type' ] ][ $eventId ], $trigger[ 'data' ] );
                    } else {
                        $triggerEventTypes[ $trigger[ 'trigger_type' ] ][ $eventId ] = $trigger[ 'data' ];
                    }
                }
            }
        }
        if ( in_array( EventTypes::$STATIC, $trigger_types ) ) {
            $singleEvent = new SingleEvent( 'custom_event', EventTypes::$STATIC, self::getSlug() );
            $singleEvent->args = $event;
            $eventObject = $singleEvent;
        } elseif ( in_array( EventTypes::$TRIGGER, $trigger_types ) ) {
            $singleEvent = new SingleEvent( 'custom_event', EventTypes::$TRIGGER, self::getSlug() );
            $singleEvent->args = $event;
            $singleEvent->args->__set( 'triggerEventTypes', $triggerEventTypes );
            $eventObject = $singleEvent;
        }

        if ( $eventObject ) {
            $eventObject->addPayload( [ "custom_event_post_id" => $event->__get( 'post_id' ) ] );

            $delay = $event->getDelay();
            if ( $delay > 0 ) {
                $eventObject->addPayload( [ "delay" => $delay ] );
            }
        }
        return $eventObject;
    }
}
/**
 * @return EventsCustom
 */
function EventsCustom() {
    return EventsCustom::instance();
}

EventsCustom();
