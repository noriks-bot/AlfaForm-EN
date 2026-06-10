<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bing extends Settings implements Pixel {

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	public function __construct() {
        add_action( 'pys_admin_pixel_ids', array( $this, 'renderPixelIdField' ) );
	}
	
	public function enabled() {
		return false;
	}
	
	public function configured() {
		return false;
	}
	
	public function getPixelIDs() {
		return array();
	}
	
	public function getPixelOptions() {
	    return array();
    }
    
    public function getEventData( $eventType, $args = null ) {
	    return false;
    }
	
	public function outputNoScriptEvents() {}

	public function render_switcher_input( $key, $collapse = false, $disabled = false, $default = false, $type = 'secondary' ) {

		$attr_id = 'pys_bing_' . $key;

		?>

		<div class="custom-switch disabled">
			<input type="checkbox" value="1" disabled="disabled"
			       id="<?php echo esc_attr( $attr_id ); ?>" class="custom-switch-input">
			<label class="custom-switch-btn" for="<?php echo esc_attr( $attr_id ); ?>"></label>
		</div>

		<?php
	}

	public function renderCustomEventOptions( $event ) {}

    public function renderAddonNotice() {
        echo '&nbsp;<a href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/bing-tag-add-on" target="_blank" class="badge badge-pill badge-secondary link">The paid add-on is required</a>';
    }

    public function renderPixelIdField() {
        ?>
        <div class="line"></div>
        <div class="d-flex pixel-wrap align-items-center justify-content-between">
            <div class="pixel-heading d-flex justify-content-start align-items-center">
                <img class="tag-logo" src="<?php echo PYS_FREE_URL; ?>/dist/images/microsoft-small-square.svg">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="secondary_heading">Microsoft the UET Tag (Bing) with <a class="link" href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/bing-tag-add-on?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-bing" target="_blank">this pro add-on.</a></h3>
                    <?php $this->renderProBadge('https://www.pixelyoursite.com/plugins/pixelyoursite-professional/bing-tag-add-on?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-bing', 'Purchase Addon');?>
                </div>
            </div>
        </div>

        <?php
    }
}

/**
 * @return Bing
 */
function Bing() {
	return Bing::instance();
}

Bing();