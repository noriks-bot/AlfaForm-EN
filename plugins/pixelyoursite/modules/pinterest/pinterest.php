<?php

/**
 * Dummy Pinterest addon used for UI demo
 */

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Pinterest extends Settings implements Pixel {

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	public function __construct() {
        add_action( 'pys_admin_pixel_ids', array( $this, 'renderPixelIdField') );
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

	public function render_switcher_input( $key, $collapse = false, $disabled = false, $default = false, $type = 'secondary') {
	    //@todo: review

		$attr_name = "pys[pinterest][$key]";
		$attr_id = 'pys_pinterest_' . $key;

		?>

		<div class="custom-switch disabled">
			<input type="checkbox" name="<?php echo esc_attr( $attr_name ); ?>" value="1" disabled="disabled"
			       id="<?php echo esc_attr( $attr_id ); ?>" class="custom-switch-input">
			<label class="custom-switch-btn" for="<?php echo esc_attr( $attr_id ); ?>"></label>
		</div>

		<?php
	}

	public function renderCustomEventOptions( $event ) {}

    public function renderAddonNotice() {
        echo '&nbsp;<a href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/pinterest-tag-add-on" target="_blank" class="badge badge-pill badge-secondary">The paid add-on is required</a>';
    }

    public function renderPixelIdField() {
	    ?>
        <div class="line"></div>
        <div class="d-flex pixel-wrap align-items-center justify-content-between">
            <div class="pixel-heading d-flex justify-content-start align-items-center">
                <img class="tag-logo" src="<?php echo PYS_FREE_URL; ?>/dist/images/pinterest-square-small.svg">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="secondary_heading">Add the Pinterest tag with our <a class="link" href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/pinterest-tag-add-on?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-ids"
                                                                                    target="_blank">Paid addon</a>.</h3>
                    <?php renderProBadge('https://www.pixelyoursite.com/plugins/pixelyoursite-professional/pinterest-tag-add-on?utm_source=pixelyoursite-free-plugin&utm_medium=plugin&utm_campaign=free-plugin-ids', 'Purchase Addon'); ?>
                </div>
            </div>
        </div>
        
        <?php
    }
    
}

/**
 * @return Pinterest
 */
function Pinterest() {
	return Pinterest::instance();
}

Pinterest();