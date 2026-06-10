<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

abstract class SettingsCustomEvent {

    private $slug = null;

    /**
     * Constructor
     *
     * @param string $slug
     * @param object $event
     */
    public function __construct($slug) {
        $this->slug = $slug;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function render_text_input( $key, $placeholder = '',$conditional_type = null, $disabled = false, $hidden = false, $empty = false, $type = 'standard') {
        $i = $this->getConditionIndex();
        if(!empty($conditional_type)){
            $attr_name = "pys[event][$this->slug][$i][$conditional_type][$key]";
            $attr_id    = 'pys_event_' . $this->slug . '_' . $i . '_'.$conditional_type. '_' . $key;
        } else {
            $attr_name = "pys[event][$this->slug][$i][$key]";
            $attr_id    = 'pys_event_' . $this->slug . '_' . $i . '_' . $key;
        }

        $attr_value = $this->getParam($key);

        $classes = array(
            "input-$type"
        );

        if ( $hidden ) {
            $classes[] = 'form-control-hidden';
        }

        $classes = implode( ' ', $classes );

        ?>

        <input <?php disabled( $disabled ); ?> type="text" name="<?php echo esc_attr( $attr_name ); ?>"
                                               id="<?php echo esc_attr( $attr_id ); ?>"
                                               value="<?php echo esc_attr( $attr_value ); ?>"
                                               placeholder="<?php echo esc_attr( $placeholder ); ?>"
                                               class="<?php echo esc_attr( $classes ); ?>">

        <?php

    }
    /**
     * Output select input
     *
     * @param      $key
     * @param      $options
     * @param bool $disabled
     * @param null $visibility_target
     * @param null $visibility_value
     */
    public function render_select_input( $key, $options, $conditional_type = null, $classes = '', $disabled = false, $visibility_target = null,
                                         $visibility_value = null ) {

        $disabled_array = array(
            'url_parameters',
            'landing_page',
            'source'
        );
        $i = $this->getConditionIndex();
        if(!empty($conditional_type)){
            $attr_name = "pys[event][$this->slug][$i][$conditional_type][$key]";
            $attr_id    = 'pys_event_' . $this->slug . '_' . $i . '_'.$conditional_type. '_' . $key;
        } else {
            $attr_name = "pys[event][$this->slug][$i][$key]";
            $attr_id    = 'pys_event_' . $this->slug . '_' . $i . '_' . $key;
        }
        $attr_value = $this->getParam($key);
        ?>

        <div class="select-standard-wrap">
            <select class="<?php echo esc_attr( $classes ); ?>" id="<?php echo esc_attr( $attr_id ); ?>"
                    name="<?php echo esc_attr( $attr_name ); ?>" <?php disabled( $disabled ); ?>
                    data-target="<?php echo esc_attr( $visibility_target ); ?>"
                    data-value="<?php echo esc_attr( $visibility_value ); ?>" autocomplete="off" style="width: 100%;">

                <option value="" disabled selected>Please, select...</option>

                <?php foreach ( $options as $option_key => $option_value ) : ?>
                    <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key,
                        esc_attr( $attr_value ) ); ?> <?php disabled(in_array($option_key, $disabled_array, true)); ?>><?php echo esc_attr( $option_value ); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php
    }

    /**
     * Output multi select input
     *
     * @param      $key
     * @param      $values
     * @param bool $disabled
     */
    public function render_multi_select_input( $key, $values, $disabled = false ,$placeholder = "" , $classes = '', $pysselect2 = true ) {
        $i = $this->getConditionIndex();
        $attr_name = "pys[event][$this->slug][$i][$key][]";
        $attr_id    = 'pys_event_' . $this->slug . '_' . $i . '_' . $key;
        $selected  = $this->getParam($key) ? $this->getParam($key) : array();
        if ( !empty( $classes ) ) {
            $classes = ' ' . $classes;
        } else {
            $classes = $pysselect2 ? 'pys-pysselect2' : '';
        }
        ?>

        <input type="hidden" name="<?php echo esc_attr( $attr_name ); ?>" value="">
        <select class="form-control <?php echo esc_attr( $classes ); ?>"
                data-placeholder="<?=$placeholder?>"
                name="<?php echo esc_attr( $attr_name ); ?>"
                id="<?php echo esc_attr( $attr_id ); ?>" <?php disabled( $disabled ); ?> style="width: 100%;"
                multiple>
            <?php foreach ( $values as $option_key => $option_value ) : ?>
                <option value="<?php echo esc_attr( $option_key ); ?>"
                    <?php selected(  in_array($option_key,$selected)  ); ?>
                    <?php disabled( $option_key, 'disabled' ); ?>
                >
                    <?php echo esc_attr( $option_value ); ?>
                </option>
            <?php endforeach; ?>

        </select>

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
    public function render_radio_input( $key, $value, $label, $disabled = false ) {
        $i = $this->getConditionIndex();
        $id = "pys_event_" . rand( 1, 1000000 )."_".$key.'_'.$value;
        $attr_name = "pys[event][$this->slug][$i][$key]";
        $attr_value = $this->getParam($key);
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
            </label>
        </div>
        <?php

    }
}