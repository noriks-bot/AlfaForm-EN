<?php
namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class ConditionalEvent extends SettingsCustomEvent {

    private $conditional_type_array = array(
        'url_filters' => 'URL filters',
        'device' => 'Device',
        'user_role' => 'User role',
        'url_parameters' => 'URL parameters PRO',
        'landing_page' => 'Landing page PRO',
        'source' => 'Source PRO'
    );

    private $condition_type = 'url_filters';
    private $condition_rule = 'contains';
    private $condition_value = '';
    private $device = 'Desktop';

    private $user_role = array();

    private $index = 0;

    public function __construct($conditional_type, $index = null) {
        parent::__construct( 'conditions' );
        if ( $index === null ) {
            $this->index = rand( 100, 200 );
        } else {
            $this->index = $index;
        }
        $this->condition_type = $conditional_type ?? $this->condition_type;

        $this->user_role = array('guest');
    }

    public function getConditionIndex() {
        return $this->index;
    }
    public function getConditionType() {
        return $this->condition_type;
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

    public function getConditionTypeArray()
    {
        return $this->conditional_type_array;
    }
    public function get_roles() {
        $role_array = array_merge(array('guest'=> __('Guest', 'pys')), getAvailableUserRoles());
        return $role_array;
    }
    public function renderConditionalBlock($load = false)
    {
        ?>

        <div class="card-body condition_group"  data-condition_id="<?php echo esc_attr( $this->index ); ?>"
             data-new_condition_index="<?php echo esc_attr( $this->index ); ?>">
            <div class="condition_group_head">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="font-semibold"><?php _e('Select the condition type', 'pys'); ?></p>
                    </div>

                    <div class="ml-8">
                        <?php $this->render_select_input('condition_type' , $this->conditional_type_array, null,'select-standard pys_event_condition_type' ); ?>
                    </div>
                </div>
            </div>
            <?php
            if ($load){ ?>
                <div class="event_conditions_panel <?= $this->condition_type ?>_panel" data-condition_type="<?= $this->condition_type ?>">
                    <?php $this->renderConditionUrlOptions($this->condition_type);?>
                </div>
            <?php } ?>

        </div>
        <?php
    }

    public function renderConditionalsPanel()
    {
        foreach ($this->conditional_type_array as $key => $conditional) {
            ?>
            <div class="event_conditions_panel <?= $key ?>_panel" data-condition_type="<?= $key ?>" style="display: none;">
                <?php $this->renderConditionUrlOptions($key); ?>
            </div>
            <?php
        }
        ?>

        <?php
    }

    public function renderConditionUrlOptions($conditional_type) {
        $condition_name = $this->conditional_type_array[$conditional_type];
        $condition_rule = array();?>
        <div class="event_condition_wrapper">

        <?php
            switch ($conditional_type) {
                case 'url_filters' :
                case 'url_parameters':
                case 'landing_page' :
                case 'source' :
                    if(!empty($condition_name) && $condition_name !== 'URL filters') {
                        $condition_rule['contains'] = $condition_name.' contains';
                        $condition_rule['match'] = $condition_name.' match';
                    } else {
                        $condition_rule['contains'] = 'URL contains';
                        $condition_rule['match'] = 'URL match';
                    }
                    ?>
                        <?php $this->render_select_input('condition_rule', $condition_rule, $conditional_type, 'select-standard'); ?>
                        <div class="ml-8">
                            <?php $this->render_text_input('condition_value' , __('Enter URL', 'pys'), $conditional_type ); ?>
                        </div>
                    <?php
                    break;
                case 'device' :
                    ?>
                    <div class="radio-inputs-wrap">
                        <?php $this->render_radio_input('device', 'Desktop', 'Desktop'); ?>
                        <?php $this->render_radio_input('device' , 'Mobile', 'Mobile' ); ?>
                    </div>
                    <?php
                    break;
                case 'user_role':
                    ?>
                    <?php $this->render_multi_select_input('user_role', $this->get_roles(), false, '', 'pys-role-pysselect2'); ?>
                    <?php
                    break;
        }
        ?>
        </div>
        <?php
    }

    public function check()
    {
        $condition_type = $this->condition_type;
        $condition_rule = $this->condition_rule;
        $condition_value = $this->condition_value;
        $device = $this->device;
        $user_role = $this->user_role;

        $condition = false;
        switch ($condition_type) {
            case 'url_filters' :
                $condition = compareURLs($condition_value, '', $condition_rule);
                break;
            case 'url_parameters':
                $condition = compareURLs($condition_value, '', 'param_'.$condition_rule);
                break;
            case 'landing_page' :
                $condition = compareURLs($condition_value, $_COOKIE['pys_landing_page'] ?? $_SESSION['LandingPage'] ?? 'false', $condition_rule);
                break;
            case 'source' :
                $condition = compareURLs($condition_value, $_COOKIE['pysTrafficSource'] ?? $_SESSION['pysTrafficSource'] ?? '', $condition_rule);
                break;
            case 'device' :
                $condition = $this->checkDevice($device);
                break;
            case 'user_role':
                $condition = $this->checkUserRole($user_role);
                break;
        }
        return $condition;
    }
    public function checkDevice($device)
    {
        return ($device === 'Desktop' && !wp_is_mobile()) || ($device === 'Mobile' && wp_is_mobile());
    }
    public function checkUserRole($user_role)
    {
        $user = wp_get_current_user();
        return (in_array('guest', $user_role, true) && !$user->exists()) || (array_intersect($user_role, $user->roles));
    }
}