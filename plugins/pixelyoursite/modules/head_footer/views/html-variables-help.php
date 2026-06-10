<?php

namespace PixelYourSite\HeadFooter;

use function PixelYourSite\renderProBadge;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="card about-params card-style3">
    <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="icon-Info"></i>
            <h4 class="heading-with-icon bold-heading">Replacements</h4>
        </div>
        <div class="d-flex align-items-center flex-collapse-block">
            <?php renderProBadge(); ?>
        </div>
    </div>

    <div class="card-body" style="display: block;">
        <p class="mb-20">You can use the following variables: </p>

        <ul class="replacements-list mb-20">
            <li><span class="replacement-item">[id]</span> - content ID</li>
            <li><span class="replacement-item">[title]</span> - content title</li>
            <li><span class="replacement-item">[categories]</span> - content categories</li>
            <li><span class="replacement-item">[email]</span> - user's email</li>
            <li><span class="replacement-item">[hashed_email]</span> - hashed user's email</li>
            <li><span class="replacement-item">[first_name]</span> - user's first name</li>
            <li><span class="replacement-item">[last_name]</span> - user's last name</li>
        </ul>

        <p class="mb-20">For the WooCommerce or Easy Digital Downloads Thank You Pages only:</p>

        <ul class="replacements-list">
            <li><span class="replacement-item">[order_number]</span> - order number</li>
            <li><span class="replacement-item">[order_subtotal]</span> - order subtotal</li>
            <li><span class="replacement-item">[order_total]</span> - order total</li>
            <li><span class="replacement-item">[currency]</span> - currency</li>
        </ul>
    </div>
</div>