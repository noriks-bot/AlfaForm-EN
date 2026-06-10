<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="buttons-action-events mb-20">
	<a href="<?php echo esc_url( $new_event_url ); ?>" class="btn-small btn-green font-medium">Add</a>
	<button class="btn-small btn-event-action btn-gray font-medium ml-24" name="pys[bulk_event_action]" value="enable" type="submit">Enable</button>
	<button class="btn-small btn-event-action btn-gray font-medium ml-8" name="pys[bulk_event_action]" value="disable" type="submit">Disable</button>
	<button class="btn-small btn-event-action btn-gray font-medium ml-8" name="pys[bulk_event_action]" value="clone" type="submit">Duplicate</button>
	<button class="btn-small btn-event-action btn-red font-medium bulk-events-delete ml-24" name="pys[bulk_event_action]" value="delete" type="submit">Delete</button>
</div>
