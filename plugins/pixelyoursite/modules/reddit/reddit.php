<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Reddit extends Settings implements Pixel {

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	public function __construct() {
        add_action( 'pys_admin_pixel_ids', array( $this, 'renderPixelIdField' ), 25 );
	}

    /**
     *
     * @return bool
     */
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
    public function addParamsToEvent(&$event) {
	    return false;
    }
	
	public function outputNoScriptEvents() {}

    public function render_switcher_input( $key, $collapse = false, $disabled = false, $default = false, $type = 'secondary' ) {

		$attr_id = 'pys_reddit_' . $key;

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
	    echo '&nbsp;<a href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/reddit-wordpress-plugin" target="_blank" class="badge badge-pill badge-secondary link">The paid add-on is required</a>';
    }

	public function renderPixelIdField(): void {
		?>
        <div class="line"></div>
        <div class="d-flex pixel-wrap align-items-center justify-content-between">
            <div class="pixel-heading d-flex justify-content-start align-items-center">
                <img class="tag-logo" src="<?php echo PYS_FREE_URL; ?>/dist/images/reddit-logo.svg" alt="reddit-logo">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="secondary_heading">Add the Reddit tag with our <a class="link" href="https://www.pixelyoursite.com/plugins/pixelyoursite-professional/reddit-wordpress-plugin"
                                                                                    target="_blank">Paid addon</a>.</h3>
					<?php renderProBadge('https://www.pixelyoursite.com/plugins/pixelyoursite-professional/reddit-wordpress-plugin', 'Purchase Addon'); ?>
                </div>
            </div>
        </div>

		<?php
	}
}

/**
 * @return ?Reddit
 */
function Reddit(): ?Reddit {
	return Reddit::instance();
}

Reddit();