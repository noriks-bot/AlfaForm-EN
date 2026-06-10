<?php

namespace PixelYourSite;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="pro-feature-container">
    <div class="d-flex align-items-center justify-content-between">
        <div class="export-import-buttons">
            <a  class="btn-small btn-gray btn-small-icon secondary_heading disabled"><i class="icon-import"></i>Import Events</a>
            <a   class="btn-small btn-gray btn-small-icon secondary_heading disabled"><i class="icon-export"></i>Export Events</a>
        </div>
        <?php renderProBadge(); ?>
    </div>
</div>