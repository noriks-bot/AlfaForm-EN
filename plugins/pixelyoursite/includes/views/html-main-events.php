<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$new_event_url = buildAdminUrl( 'pixelyoursite', 'events', 'edit' );

?>

<div class="cards-wrapper cards-wrapper-style1 events-page-wrapper gap-24 mb-24">
    <div class="d-flex justify-content-between align-items-center">
        <span class="font-semibold primary-heading-color fz-18">With the pro version, you can track any actions without coding. Clicks, time on page, number of pages, form submited, video views and more.</span>
        <?php renderEventSetupToolBadge();?>
    </div>
</div>

<div class="cards-wrapper cards-wrapper-style1 events-page-wrapper gap-24">
    <input type="hidden" name="pys[bulk_event_action_nonce]"
           value="<?php echo wp_create_nonce( 'bulk_event_action' ); ?>">

    <h2 class="font-semibold primary-heading-color fz-18 pt-4">User Defined Events</h2>

    <div class="card card-style4 card-static">
        <div class="card-header card-header-style3">
            <p class="secondary_heading_type2">
                General
            </p>
        </div>
        <div class="card-body card-body-general">
            <div class="events-general-content-wrap">
                <div class="d-flex align-items-center mb-24">
                    <?php PYS()->render_switcher_input( 'custom_events_enabled' ); ?>
                    <h4 class="switcher-label secondary_heading">Enable Events</h4>
                </div>

                <?php include PYS_FREE_VIEW_PATH . '/UI/buttons-import-export-events.php'; ?>
            </div>
        </div>
    </div>

    <?php
    $videos = array(
        array(
            'url'   => 'https://www.youtube.com/watch?v=kEp5BDg7dP0',
            'title' => 'How to fire EVENTS with PixelYourSite',
            'time'  => '22:28',
        ),
				array(
						'url'   => 'https://www.youtube.com/watch?v=UOzC8T0WGBw',
						'title' => 'MUST WATCH: The best way to track any action',
						'time'  => '9:41',
				),
				array(
						'url'   => 'https://www.youtube.com/watch?v=wUsqwomsYMo',
						'title' => 'Improved Event Tracking: CONDITIONS',
						'time'  => '5:09',
				),
        array(
            'url'   => 'https://www.youtube.com/watch?v=PcXYYGOvahc',
            'title' => 'Track URL tags as event parameters',
            'time'  => '8:15',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=ehi66agv1zo',
            'title' => 'Track YouTube or Vimeo Embedded Videos With Your Own Events',
            'time'  => '5:25',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=c4Hrb8WK5bw',
            'title' => 'Fire a LEAD event on form submit - WordPress & PixelYourSite',
            'time'  => '5:58',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=0IFHqI6itx8',
            'title' => 'Improve Meta EMQ score with when tracking WordPress forms',
            'time'  => '4:52',
        ),
        array(
            'url'   => 'https://www.youtube.com/watch?v=Iyu-pSbqcFI',
            'title' => 'Mandatory: Verify your Meta CUSTOM Events (Pixel & CAPI)',
            'time'  => '5:10',
        ),
    );

    renderRecommendedVideo( $videos );
    ?>

    <div class="card card-style4 card-static card-custom-events">
        <div class="card-header card-header-style3">
            <p class="font-semibold main-switcher">
                Events List
            </p>
        </div>
        <div class="card-body">
            <div class="events-general-content-wrap">
                <?php include PYS_FREE_VIEW_PATH . '/UI/buttons-action-events.php'; ?>

                <div class="line mb-24"></div>

                <div>
                    <table class="table" id="table-custom-events">
                        <thead>
                        <tr>
                            <th>
                                <div class="small-checkbox">
                                    <input type="checkbox" id="pys_select_all_events" value="1"
                                           class="small-control-input">
                                    <label class="small-control small-checkbox-label" for="pys_select_all_events">
                                        <span class="small-control-indicator"><i class="icon-check"></i></span>
                                    </label>
                                </div>
                            </th>
                            <th class="column-title font-semibold">Name</th>
                            <th class="column-title font-semibold">Triggers</th>
                            <th class="column-title font-semibold">Networks</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ( CustomEventFactory::get() as $event ) : ?>

                            <?php
                            $errorMessage = "";
                            /** @var CustomEvent $event */

                            $event_edit_url = buildAdminUrl( 'pixelyoursite', 'events', 'edit', array(
                                'id' => $event->getPostId()
                            ) );

                            $event_enable_url = buildAdminUrl( 'pixelyoursite', 'events', 'enable', array(
                                'pys'      => array(
                                    'event' => array(
                                        'post_id' => $event->getPostId(),
                                    )
                                ),
                                '_wpnonce' => wp_create_nonce( 'pys_enable_event' ),
                            ) );

                            $event_disable_url = buildAdminUrl( 'pixelyoursite', 'events', 'disable', array(
                                'pys'      => array(
                                    'event' => array(
                                        'post_id' => $event->getPostId(),
                                    )
                                ),
                                '_wpnonce' => wp_create_nonce( 'pys_disable_event' ),
                            ) );

                            $event_remove_url = buildAdminUrl( 'pixelyoursite', 'events', 'remove', array(
                                'pys'      => array(
                                    'event' => array(
                                        'post_id' => $event->getPostId(),
                                    )
                                ),
                                '_wpnonce' => wp_create_nonce( 'pys_remove_event' ),
                            ) );

                            $triggers = $event->getTriggers();
                            $event_types = array();

                            if ( !empty( $triggers ) ) {
                                foreach ( $triggers as $trigger ) {
                                    $trigger_type = $trigger->getTriggerType();
                                    switch ( $trigger_type ) {
                                        case 'number_page_visit':
                                            $event_types[] = 'Number of Page Visits';
                                            break;
                                        case 'post_type':
                                            {
                                                $event_types[] = 'Post Type';
                                                $selectedPostType = $trigger->getPostTypeValue();
                                                $errorMessage = "Post type not found";
                                                $types = get_post_types( null, "objects " );
                                                foreach ( $types as $type ) {
                                                    if ( $type->name == $selectedPostType ) {
                                                        $errorMessage = "";
                                                        break;
                                                    }
                                                }

                                            }
                                            break;

                                        case 'url_click':
                                            $event_types[] = 'Link Click';
                                            break;

                                        case 'css_click':
                                            $event_types[] = 'Element Click';
                                            break;

                                        case 'css_mouseover':
                                            $event_types[] = 'Element Mouseover';
                                            break;

                                        case 'scroll_pos':
                                            $event_types[] = 'Scroll Position';
                                            break;

                                        case 'video_view':
                                            $event_types[] = 'Embedded Video View';
                                            break;

                                        case 'email_link':
                                            $event_types[] = 'Email Link';
                                            break;

                                        case 'page_visit':
                                            $event_types[] = 'Page Visit';
                                            break;
                                    }
                                    if ( $trigger->isFormTriggerType( $trigger_type ) ) {
                                        $eventsFormFactory = apply_filters( "pys_form_event_factory", [] );
                                        foreach ( $eventsFormFactory as $activeFormPlugin ) :
                                            if ( $activeFormPlugin->getSlug() == $trigger_type ) {
                                                $event_types[] = $activeFormPlugin->getName();
                                            }
                                        endforeach;
                                    }
                                }
                            }

                            if ( empty( $event_types ) ) {
                                $event_types[] = 'No triggers';
                            }
                            ?>

                            <tr data-post_id="<?php echo esc_attr( $event->getPostId() ); ?>"
                                class="event-row <?php echo $event->isEnabled() ? '' : 'disabled'; ?>">
                                <td class="event-select">
                                    <div class="small-checkbox">
                                        <input type="checkbox" name="pys[selected_events][]"
                                               value="<?php echo esc_attr( $event->getPostId() ); ?>"
                                               class="small-control-input pys-select-event"
                                               id="pys-event-<?php echo esc_attr( $event->getPostId() ); ?>"
                                        >
                                        <label class="small-control small-checkbox-label"
                                               for="pys-event-<?php echo esc_attr( $event->getPostId() ); ?>">
                                            <span class="small-control-indicator"><i class="icon-check"></i></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="event-title-cell">
                                    <div class="event-title-wrapper">
                                        <div class="event-title">
                                            <a href="<?php echo esc_url( $event_edit_url ); ?>"
                                               class="font-medium"><?php esc_html_e( $event->getTitle() ); ?></a>
                                        </div>
                                        <div class="event-actions">
                                            <?php if ( $event->isEnabled() ) : ?>
                                                <a href="<?php echo esc_url( $event_disable_url ); ?>"
                                                   class="event-toggle">Disable</a>
                                            <?php else : ?>
                                                <a href="<?php echo esc_url( $event_enable_url ); ?>"
                                                   class="event-toggle">Enable</a>
                                            <?php endif; ?>
                                            <div class="row-separator"></div>

                                            <a href="<?php echo esc_url( $event_remove_url ); ?>" class="
                                        remove-custom-event">Remove</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="event-types">
                                    <?php
                                    if ( !empty( $event_types ) ) :
                                        foreach ( $event_types as $event_type ) : ?>
                                            <p class="event-type font-medium">
                                                <?php echo wp_kses_post( $event_type ); ?>
                                            </p>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php

                                    if ( $errorMessage != "" ) : ?>
                                        <div class="event_error font-medium">
                                            <?= $errorMessage ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="event-networks-col">
                                    <div class="event-networks">
                                        <?php
                                        $disabled = Facebook()->enabled() && !empty( Facebook()->getPixelIDs() ) && $event->isFacebookEnabled(); ?>
                                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/meta-logo.svg" alt="meta logo"
                                             class="event-network <?php echo !$disabled ? 'disabled' : ''; ?>">

                                        <?php
                                        $ga_tags = ( GA()->enabled() && !empty( GA()->getPixelIDs() )) && $event->isUnifyAnalyticsEnabled();
                                        $disabled = $ga_tags && $event->isGoogleAnalyticsPresent(); ?>
                                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/google-tags-logo.svg"
                                             alt="google tags logo"
                                             class="event-network <?php echo !$disabled ? 'disabled' : ''; ?>">

                                        <?php
                                        $disabled = GTM()->enabled() && !empty( GTM()->getPixelIDs() ) && $event->isGTMEnabled() && $event->isGTMPresent(); ?>
                                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/gtm-logo.svg" alt="gtm logo"
                                             class="event-network <?php echo !$disabled ? 'disabled' : ''; ?>">

                                        <?php
                                        $disabled = Bing()->enabled() && !empty( Bing()->getPixelIDs() ) && $event->isBingEnabled(); ?>
                                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/bing-logo.svg" alt="bing logo"
                                             class="event-network <?php echo !$disabled ? 'disabled' : ''; ?>">

                                        <?php
                                        $disabled = Pinterest()->enabled() && !empty( Pinterest()->getPixelIDs() ) && $event->isPinterestEnabled(); ?>
                                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/pinterest-logo.svg"
                                             alt="pinterest logo"
                                             class="event-network <?php echo !$disabled ? 'disabled' : ''; ?>">
	                                    <?php
	                                    $disabled = Reddit()->enabled() && !empty( Reddit()->getPixelIDs() ) && $event->isRedditEnabled(); ?>
                                        <img src="<?php echo PYS_FREE_URL; ?>/dist/images/reddit-logo.svg"
                                             alt="reddit logo"
                                             class="event-network <?php echo !$disabled ? 'disabled' : ''; ?>">

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- About params -->
    <div class="card about-params card-style3">
        <div class="card-header card-header-style2">
            <div class="d-flex align-items-center">
                <i class="icon-Info"></i>
                <h4 class="heading-with-icon bold-heading">About Parameters:</h4>
            </div>
        </div>

        <div class="card-body" style="display: block;">
            <p class="mb-20">All the events you configure here will automatically get the following parameters for
                all
                the tags:
                <span class="parameters-list">page_title, post_type, post_id, landing_page, event_URL, user_role, plugin, event_time (pro), event_day (pro), event_month (pro), traffic_source (pro), UTMs (pro).</span>
            </p>
            <p>You can add other parameters when you configure the events.</p>
        </div>
    </div>
</div>
