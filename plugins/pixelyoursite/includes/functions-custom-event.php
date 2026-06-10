<?php

namespace PixelYourSite\Events;

use PixelYourSite;
use PixelYourSite\CustomEvent;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @param CustomEvent $event
 * @param string      $key
 */
function renderHiddenInput( &$event, $key ) {

	$attr_name = "pys[event][$key]";
	$attr_value = $event->$key;

	?>

	<input type="hidden" name="<?php echo esc_attr( $attr_name ); ?>"
	       value="<?php echo esc_attr( $attr_value ); ?>">

	<?php

}

/**
 * @param CustomEvent $event
 * @param string      $key
 * @param string      $placeholder
 */
function renderTextInput( &$event, $key, $placeholder = '' ) {

    $attr_name = "pys[event][$key]";
    $attr_id = 'pys_event_' . $key;
    $attr_value = $event->$key;

    ?>

    <input type="text" name="<?php echo esc_attr( $attr_name ); ?>"
           id="<?php echo esc_attr( $attr_id ); ?>"
           value="<?php echo esc_attr( $attr_value ); ?>"
           placeholder="<?php echo esc_attr( $placeholder ); ?>"
           class="input-standard">
    <?php

}
/**
 * @param CustomEvent $event
 * @param string      $key
 * @param array       $options
 */
function renderGroupSelectInput( &$event, $key, $groups, $full_width = false,$classes = '' ) {

    $attr_name  = "pys[event][$key]";
    $attr_id    = 'pys_event_' . $key;
    $attr_value = $event->$key;
    $group_key = $key . '_group';

    $attr_width = $full_width ? 'width: 100%;' : '';

    ?>

    <input type="hidden" name="pys[event][<?php echo esc_attr( $group_key ); ?>]"
           value="<?php echo esc_attr( $event->$group_key ?? '' ); ?>" id="<?php echo esc_attr( $group_key ); ?>">

    <div class="select-standard-wrap">
        <select class="select-standard <?= $classes ?>" id="<?php echo esc_attr( $attr_id ); ?>"
                name="<?php echo esc_attr( $attr_name ); ?>" autocomplete="off"
                style="<?php echo esc_attr( $attr_width ); ?>">

            <?php foreach ( $groups as $group => $options ) : ?>
                <optgroup label="<?= $group ?>">
                    <?php foreach ( $options as $option_key => $option_value ) :
                        $selected_group = $event->$group_key ?? $group;
                        ?>
                        <option group="<?= $group ?>"
                                value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $selected_group == $group && $option_key == $attr_value ); ?> <?php disabled( $option_key, 'disabled' ); ?>><?php echo esc_attr( $option_key ); ?></option>
                    <?php endforeach; ?>
                </optgroup>
            <?php endforeach; ?>
        </select>
    </div>

    <?php
}
/**
 * @param CustomEvent $event
 * @param string      $key
 */
function renderGoogleAnalyticsMergedActionInput( &$event, $key ) {
    $ga_events = PixelYourSite\PYS_Event_Definitions::get_ga_events();
    renderGroupSelectInput( $event, $key, $ga_events, false,'action_merged_g4' );
}
function renderMergedGAParamInput( $key, $val ) {

    $attr_name = "pys[event][ga_ads_params][$key]";
    $attr_id = 'pys_event_ga_ads_' . $key;
    $attr_value = $val['value'] ?? $val;

    ?>

    <input type="text" name="<?php echo esc_attr( $attr_name ); ?>"
           id="<?php echo esc_attr( $attr_id ); ?>"
           value="<?php echo esc_attr( $attr_value ); ?>"
           class="input-standard">

    <?php

}
/**
 * @param CustomEvent $event
 * @param string      $key
 * @param string      $placeholder
 */
function renderGAParamInput( $key, $val ) {

    $attr_name = "pys[event][ga_params][$key]";
    $attr_id = 'pys_event_ga_' . $key;
    $attr_value = $val;

    ?>

    <input type="text" name="<?php echo esc_attr( $attr_name ); ?>"
           id="<?php echo esc_attr( $attr_id ); ?>"
           value="<?php echo esc_attr( $attr_value ); ?>"
           class="form-control">

    <?php

}

/**
 * Output radio input
 *
 * @param      $key
 * @param      $value
 * @param      $label
 * @param bool $disabled
 */
function render_radio_input( &$event, $key, $value, $label, $disabled = false, $with_pro_badge = false ) {

    $id = $key . "_" . rand( 1, 1000000 );
    $attr_name = "pys[event][$key]";
    $attr_value = $event->$key;

    ?>
    <div class="radio-standard">
        <input type="radio"
               name="<?php echo esc_attr( $attr_name ); ?>"
            <?php disabled( $disabled, true ); ?>
               class="custom-control-input"
               id="<?php echo esc_attr( $id ); ?>"
            <?php checked( $attr_value, $value ); ?>
               value="<?php echo esc_attr( $value ); ?>">
        <label class="standard-control radio-checkbox-label" for="<?php echo esc_attr( $id ); ?>">
            <span class="standard-control-indicator"></span>
            <span class="standard-control-description"><?php echo wp_kses_post( $label ); ?></span>
            <?php if ( $with_pro_badge ) {
                renderCogBadge();
            } ?>
        </label>
    </div>

    <?php

}

/**
 * Output checkbox input
 *
 * @param      $key
 * @param      $label
 * @param bool $disabled
 */
function render_checkbox_input( &$event, $key, $label, $disabled = false ) {

    $attr_name  = "pys[event][$key]";
    $attr_value = $event->$key;

    $classes = array( 'custom-control', 'custom-checkbox' );

    if ( $disabled ) {
        $attr_value = false;
        $classes[] = 'disabled';
    }

    $classes = implode( ' ', $classes );

    ?>

    <label class="<?php echo esc_attr( $classes ); ?>">
        <input type="hidden" name="<?php echo esc_attr( $attr_name ); ?>" value="0">
        <input type="checkbox" name="<?php echo esc_attr( $attr_name ); ?>" value="1"
               class="custom-control-input" <?php disabled( $disabled, true ); ?> <?php checked( $attr_value,
            true ); ?> >
        <span class="custom-control-indicator"></span>
        <span class="custom-control-description"><?php echo wp_kses_post( $label ); ?></span>
    </label>

    <?php

}

/**
 * @param CustomEvent $event
 * @param string      $key
 * @param string      $placeholder
 */
function renderNumberInput( &$event, $key, $placeholder = null, $default = null ) {

    $attr_name = "pys[event][$key]";
    $attr_id = 'pys_event_' . $key;
    $attr_value = $event->$key;

    ?>

    <div class="input-number-wrapper">
        <button class="decrease"><i class="icon-minus"></i></button>
        <input type="number" name="<?php echo esc_attr( $attr_name ); ?>"
               id="<?php echo esc_attr( $attr_id ); ?>"
               value="<?php echo !empty( $attr_value ) ? esc_attr( $attr_value ) : esc_attr( $default ); ?>"
               placeholder="<?php echo esc_attr( $placeholder ); ?>"
               min="0"
        >
        <button class="increase"><i class="icon-plus"></i></button>
    </div>

    <?php

}
/**
 * @param CustomEvent $event
 * @param string      $key
 * @param string      $placeholder
 */
function renderTriggerNumberInput( $trigger, $key, $placeholder = null, $default = null ) {

    $i = $trigger->getTriggerIndex();
    $attr_name = "pys[event][triggers][0][$key]";
    $attr_id    = 'pys_event_0_' . $key;
    $attr_value = $trigger->getParam( $key );

    ?>

    <div class="input-number-wrapper">
        <button class="decrease"><i class="icon-minus"></i></button>
        <input type="number" name="<?php echo esc_attr( $attr_name ); ?>"
               id="<?php echo esc_attr( $attr_id ); ?>"
               value="<?php echo !empty( $attr_value ) ? esc_attr( $attr_value ) : esc_attr( $default ); ?>"
               placeholder="<?php echo esc_attr( $placeholder ); ?>"
               min="0">
        <button class="increase"><i class="icon-plus"></i></button>
    </div>

    <?php

}
/**
 * @param $trigger
 * @param $label
 * @param $key
 * @param $value
 * @param null $placeholder
 * @param null $default
 * @return void
 */
function renderTriggerNumberInputPercent( $trigger, $label, $key, $value, $placeholder = null, $default = null ) {

    $i = $trigger->getTriggerIndex();
    $attr_name = "pys[event][triggers][$i][$label][$key][value]";
    $attr_id = 'pys_event_' . $i . '_' . $key;

    ?>

    <div class="input-number-wrapper input-number-wrapper-percent">
        <button class="decrease"><i class="icon-minus"></i></button>
        <input type="number" name="<?php echo esc_attr( $attr_name ); ?>"
               id="<?php echo esc_attr( $attr_id ); ?>"
               value="<?php echo (int) !empty( $value ) ? esc_attr( $value ) : esc_attr( $default ); ?>"
               placeholder="<?php echo esc_attr( $placeholder ); ?>"
               min="0"
               max="100"
               step="1"
        >
        <button class="increase"><i class="icon-plus"></i></button>
    </div>

    <?php
}
/**
 * @param CustomEvent $event
 * @param string $key
 * @param bool $disabled
 */
function renderSwitcherInput( &$event, $key, $disabled = false ) {

    $attr_name = "pys[event][$key]";
    $attr_id = 'pys_event_' . $key;
    $attr_value = $event->$key;

    $classes = array( 'secondary-switch' );

    if ( $disabled ) {
        $attr_value = false;
        $classes[] = 'disabled';
    }

    $classes = implode( ' ', $classes );

    ?>

    <div class="<?php echo esc_attr( $classes ); ?>">

        <?php if ( !$disabled ) : ?>
            <input type="hidden" name="<?php echo esc_attr( $attr_name ); ?>" value="0">
        <?php endif; ?>

        <input type="checkbox" name="<?php echo esc_attr( $attr_name ); ?>"
               value="1" <?php checked( $attr_value, true ); ?> <?php disabled( $disabled, true ); ?>
               id="<?php echo esc_attr( $attr_id ); ?>" class="custom-switch-input">
        <label class="custom-switch-btn" for="<?php echo esc_attr( $attr_id ); ?>"></label>
    </div>

    <?php

}

/**
 * @param CustomEvent $event
 * @param string      $key
 * @param array       $options
 */
function renderSelectInput( &$event, $key, $options, $full_width = false,$classes = '' ) {

	if ( $key == 'currency' ) {
		
		$attr_name  = "pys[event][facebook_params][$key]";
		$attr_id    = 'pys_event_facebook_params_' . $key;
		$attr_value = $event->getFacebookParam( $key );
        
	} else {

		$attr_name  = "pys[event][$key]";
		$attr_id    = 'pys_event_' . $key;
		$attr_value = $event->$key;

    }

    $attr_width = $full_width ? 'width: 100%;' : '';

	?>

    <div class="select-standard-wrap">
        <select class="select-standard <?=$classes?>" id="<?php echo esc_attr( $attr_id ); ?>"
                name="<?php echo esc_attr( $attr_name ); ?>" autocomplete="off" style="<?php echo esc_attr( $attr_width ); ?>">
            <?php foreach ( $options as $option_key => $option_value ) : ?>
                <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key,
                    esc_attr( $attr_value ) ); ?> <?php disabled( $option_key,
                    'disabled' ); ?>><?php echo esc_attr( $option_value ); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

	<?php
}


/**
 * @param CustomEvent $event
 * @param string      $key
 * @param array       $options
 */
function renderTriggerSelectInput( $trigger, $key, $options, $full_width = false , $classes = '', $select_type = 'standard') {
    $i = $trigger->getTriggerIndex();
    $attr_name  = "pys[event][triggers][$i][$key]";
    $attr_id    = 'pys_event_'.$i.'_' . $key;
    $attr_value = $trigger->getParam($key);

    $attr_width = $full_width ? 'width: 100%;' : '';

    ?>

    <div class="select-<?php echo esc_attr( $select_type ); ?>-wrap">
        <select class="select-<?php echo esc_attr( $select_type ); ?> <?= $classes ?>"
                id="<?php echo esc_attr( $attr_id ); ?>"
                name="<?php echo esc_attr( $attr_name ); ?>" autocomplete="off"
                style="<?php echo esc_attr( $attr_width ); ?>">
            <?php foreach ( $options as $option_key => $option_value ) : ?>
                <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, esc_attr( $attr_value ) ); ?> <?php disabled( $option_key, 'disabled' ); ?>><?php echo esc_attr( $option_value ); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php
}
/**
 * @param CustomEvent $event
 * @param string      $key
 */
function renderTriggerTypeInput( $trigger, $key ) {

	$options = array(
		'page_visit'        => 'Page visit',
        'home_page'         => 'Home page',
        'scroll_pos'        => 'Page Scroll',
        'post_type'         => 'Post type',
	);
    $pro_options = array(
        'add_to_cart'       => 'WooCommerce add to cart - PRO',
        'purchase'          => 'WooCommerce purchase - PRO',
        'number_page_visit' => 'Number of Page Visits - PRO',
        'url_click'         => 'Click on HTML link - PRO',
        'css_click'         => 'Click on CSS selector - PRO',
        'css_mouseover'     => 'Mouse over CSS selector - PRO',
        'video_view'        => 'Embedded Video View - PRO',
        'email_link'        => 'Email Link - PRO',
        'form_field'        => 'Filling out a form field - PRO',
    );
    $eventsFormFactory = apply_filters("pys_form_event_factory",[]);
    foreach ($eventsFormFactory as $activeFormPlugin) :
        $options[$activeFormPlugin->getSlug()] = $activeFormPlugin->getName().' - PRO';
    endforeach;

	asort( $pro_options );

    $options = array_merge($options,$pro_options);

    renderTriggerSelectInput( $trigger, $key, $options, false, 'pys_event_trigger_type' );

}
/**
 * @param CustomEvent $event
 * @param string      $key
 */

function renderPostTypeSelect($trigger,  $key) {
    $types = get_post_types(null,"objects ");

    $options = array();
    foreach ($types as $type) {
        $options[$type->name]=$type->label;
    }

    renderTriggerSelectInput( $trigger, $key, $options );
}
/**
 * @param CustomEvent $event
 * @param string      $key
 */
function renderCurrencyParamInput( &$event, $key ) {
	
	$currencies = array(
		'AUD' => 'Australian Dollar',
		'BRL' => 'Brazilian Real',
		'CAD' => 'Canadian Dollar',
		'CZK' => 'Czech Koruna',
		'DKK' => 'Danish Krone',
		'EUR' => 'Euro',
		'HKD' => 'Hong Kong Dollar',
		'HUF' => 'Hungarian Forint',
		'IDR' => 'Indonesian Rupiah',
		'ILS' => 'Israeli New Sheqel',
		'JPY' => 'Japanese Yen',
		'KRW' => 'Korean Won',
		'MYR' => 'Malaysian Ringgit',
		'MXN' => 'Mexican Peso',
		'NOK' => 'Norwegian Krone',
		'NZD' => 'New Zealand Dollar',
		'PHP' => 'Philippine Peso',
		'PLN' => 'Polish Zloty',
		'RON' => 'Romanian Leu',
		'GBP' => 'Pound Sterling',
		'SGD' => 'Singapore Dollar',
		'SEK' => 'Swedish Krona',
		'CHF' => 'Swiss Franc',
		'TWD' => 'Taiwan New Dollar',
		'THB' => 'Thai Baht',
		'TRY' => 'Turkish Lira',
		'USD' => 'U.S. Dollar',
		'ZAR' => 'South African Rands'
	);
    
    $currencies = apply_filters( 'pys_currencies_list', $currencies );

	$options['']         = 'Please, select...';
	$options             = array_merge( $options, $currencies );
	$options['disabled'] = '';
	$options['custom']   = 'Custom currency';
	
	renderSelectInput( $event, $key, $options, true );
	
}

/**
 * Render Facebook event type input
 * Uses Events Registry for event definitions
 *
 * @param CustomEvent $event
 * @param string      $key
 */
function renderFacebookEventTypeInput( &$event, $key ) {
    // Get Facebook events from centralized Event Definitions class
    $facebook_events = PixelYourSite\PYS_Event_Definitions::get_facebook_events();

    // Ensure CustomEvent is included for backward compatibility
    if ( !isset( $facebook_events['CustomEvent'] ) ) {
        $facebook_events['CustomEvent'] = [];
    }

    $attr_name = "pys[event][$key]";
    $attr_id = 'pys_event_' . $key;
    $attr_value = esc_attr( $event->$key );

    ?>
    <div class="select-standard-wrap">
        <select id="<?php echo esc_attr( $attr_id ); ?>" name="<?php echo esc_attr( $attr_name ); ?>" autocomplete="off"
                class="select-standard">
            <?php foreach ( $facebook_events as $option_key => $option_value ) :
                $value = esc_attr( $option_key ); ?>

                <option data-fields='<?= json_encode( $option_value ) ?>'
                        value="<?= $value ?>" <?php selected( $value, $attr_value ); ?> >
                    <?= $value ?>
                </option>

            <?php endforeach; ?>
        </select>
    </div>
    <?php
}

/**
 * @param CustomEvent $event
 * @param string      $key
 */
function renderFacebookParamInput( &$event, $key ) {
	
	$attr_name  = "pys[event][facebook_params][$key]";
	$attr_id    = 'pys_event_facebook_' . $key;
	$attr_value = $event->getFacebookParam( $key );
	
	?>

    <input type="text" name="<?php echo esc_attr( $attr_name ); ?>"
           id="<?php echo esc_attr( $attr_id ); ?>"
           value="<?php echo esc_attr( $attr_value ); ?>"
           placeholder="Enter value"
           class="input-standard">
	
	<?php
	
}

/**
 * @param CustomEvent $event
 * @param string      $key
 */
function renderGoogleAnalyticsActionInput( &$event, $key ) {
 
	$options = array(
		'_custom'             => 'Custom Action',
		'disabled'            => '',
		'add_payment_info'    => 'add_payment_info',
		'add_to_cart'         => 'add_to_cart',
		'add_to_wishlist'     => 'add_to_wishlist',
		'begin_checkout'      => 'begin_checkout',
		'checkout_progress'   => 'checkout_progress',
		'generate_lead'       => 'generate_lead',
		'login'               => 'login',
		'purchase'            => 'purchase',
		'refund'              => 'refund',
		'remove_from_cart'    => 'remove_from_cart',
		'search'              => 'search',
		'select_content'      => 'select_content',
		'set_checkout_option' => 'set_checkout_option',
		'share'               => 'share',
		'sign_up'             => 'sign_up',
		'view_item'           => 'view_item',
		'view_item_list'      => 'view_item_list',
		'view_promotion'      => 'view_promotion',
		'view_search_results' => 'view_search_results',
	);

	renderSelectInput( $event, $key, $options, true );

}
/**
 * @param CustomEvent $event
 * @param string      $key
 */
function renderGoogleAnalyticsV4ActionInput( &$event, $key ) {
    $ga_events = PixelYourSite\PYS_Event_Definitions::get_ga_events();
    renderGroupSelectInput( $event, $key, $ga_events, false );
}
/**
 * Render Pinterest event type input
 * Uses Events Registry for event definitions
 *
 * @param CustomEvent $event
 * @param string      $key
 */
function renderPinterestEventTypeInput( &$event, $key ) {
    $pinterest_events = PixelYourSite\PYS_Event_Definitions::get_pinterest_events();

    // Ensure CustomEvent is included for backward compatibility
    if ( !isset( $pinterest_events['custom'] ) ) {
        $pinterest_events['Custom'] = [];
    }

    $attr_name = "pys[event][$key]";
    $attr_id = 'pys_event_' . $key;
    $attr_value = esc_attr( $event->$key );

    ?>
    <div class="select-standard-wrap">
        <select id="<?php echo esc_attr( $attr_id ); ?>" name="<?php echo esc_attr( $attr_name ); ?>" autocomplete="off"
                class="select-standard">
            <?php foreach ( $pinterest_events as $option_key => $option_value ) :
                $value = esc_attr( $option_key ); ?>

                <option data-fields='<?= json_encode( $option_value ) ?>'
                        value="<?= $value ?>" <?php selected( $value, $attr_value ); ?> >
                    <?= $value ?>
                </option>

            <?php endforeach; ?>
        </select>
    </div>
    <?php
}

/**
 * Render Bing event type input
 * Uses Events Registry for event definitions
 *
 * @param CustomEvent $event
 * @param string $key
 */
function renderBingEventTypeInput( &$event, $key ) {
    // Get Bing events from centralized Event Definitions class
    $bing_events = PixelYourSite\PYS_Event_Definitions::get_bing_events();

    $attr_name = "pys[event][$key]";
    $attr_id = 'pys_event_' . $key;
    $attr_value = esc_attr( $event->$key );

    ?>
    <select class="input-standard" id="<?php echo esc_attr( $attr_id ); ?>" name="<?php echo esc_attr( $attr_name ); ?>" autocomplete="off">
        <?php foreach ( $bing_events as $option_key => $option_value ) :
            $value = esc_attr( $option_key ); ?>

            <option data-fields='<?= json_encode( $option_value ) ?>'
                    value="<?= $value ?>" <?php selected( $value, $attr_value ); ?> >
                <?= $value ?>
            </option>

        <?php endforeach; ?>
    </select>
    <?php
}

/**
 * @param CustomEvent $event
 * @param string      $key
 */
function renderGTMEventId( &$event, $key) {
    $options = array();
    $mainPixels = PixelYourSite\GTM()->getPixelIDs();
    foreach ($mainPixels as $mainPixel) {
        if (strpos($mainPixel, 'GTM-') === 0 && strpos($mainPixel, 'GTM-') !== false) {
            $options[$mainPixel] = $mainPixel.' (global)';
        }
        else{
            $options[$mainPixel] = $mainPixel.' (not supported)';
        }

    }

    render_multi_select_input( $event, $key, $options );

}

/**
 * @param CustomEvent $event
 * @param string      $key
 * @param string      $placeholder
 */
function renderGTMParamInput( $key, $val ) {

    $attr_name = "pys[event][gtm_params][$key]";
    $attr_id = 'pys_event_gtm_' . $key;
    $attr_value = $val['value'] ?? $val;

    ?>

    <input type="text" name="<?php echo esc_attr( $attr_name ); ?>"
           id="<?php echo esc_attr( $attr_id ); ?>"
           value="<?php echo esc_attr( $attr_value ); ?>"
           class="form-control">

    <?php

}

/**
 * @param CustomEvent $event
 * @param string      $key
 */
function renderGTMActionInput( &$event, $key ) {
    $ga_events = PixelYourSite\PYS_Event_Definitions::get_ga_events();
    renderGroupSelectInput( $event, $key, $ga_events, false,'action_gtm' );
}
