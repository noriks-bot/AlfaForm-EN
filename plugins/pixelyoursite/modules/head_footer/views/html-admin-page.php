<?php

namespace PixelYourSite\HeadFooter;

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use PixelYourSite;

?>

<!-- Head and Footer Page -->
<div class="cards-wrapper cards-wrapper-style2 gap-22">
    <!-- Head and Footer Settings-->
    <div class="card card-style3">
		<?php $enabled = PixelYourSite\HeadFooter()->getOption( 'enabled' ); ?>
        <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center <?php echo $enabled ? 'header-opened' : ''; ?>">
            <div class="disable-card d-flex align-items-center">
				<?php PixelYourSite\HeadFooter()->render_switcher_input( 'enabled' ); ?>
                <h4 class="secondary_heading_type2 switcher-label">Head and Footer Settings</h4>
            </div>

			<?php PixelYourSite\cardCollapseSettings(); ?>
        </div>

        <div class="card-body" <?php echo $enabled ? 'style="display:block"' : ''; ?>>
            <div class="gap-22">

                <!-- Head Scripts -->
                <div class="card card-style4">
					<?php $enabled = PixelYourSite\HeadFooter()->getOption( 'head_enabled' ); ?>
                    <div class="card-header card-header-style3 disable-card-wrap d-flex justify-content-between align-items-center <?php echo $enabled ? 'header-opened' : ''; ?>">
                        <div class="disable-card d-flex align-items-center">
							<?php PixelYourSite\HeadFooter()->render_switcher_input( 'head_enabled' ); ?>
                            <h4 class="secondary_heading_type2 switcher-label">Head Scripts</h4>
                        </div>

						<?php PixelYourSite\cardCollapseSettings(); ?>
                    </div>

                    <div class="card-body" <?php echo $enabled ? 'style="display:block"' : ''; ?>>
                        <div class="gap-22">
                            <div class="head-footer-script">
                                <h4 class="primary_heading">Any device type:</h4>
								<?php PixelYourSite\HeadFooter()->render_text_area_input( 'head_any' ); ?>
                            </div>

                            <div class="head-footer-script">
                                <h4 class="primary_heading">Desktop Only:</h4>
								<?php PixelYourSite\HeadFooter()->render_text_area_input( 'head_desktop' ); ?>
                            </div>

                            <div class="head-footer-script">
                                <h4 class="primary_heading">Mobile Only:</h4>
								<?php PixelYourSite\HeadFooter()->render_text_area_input( 'head_mobile' ); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Scripts -->
                <div class="card card-style4">
					<?php $enabled = PixelYourSite\HeadFooter()->getOption( 'footer_enabled' ); ?>
                    <div class="card-header card-header-style3 disable-card-wrap d-flex justify-content-between align-items-center <?php echo $enabled ? 'header-opened' : ''; ?>">
                        <div class="disable-card d-flex align-items-center">
							<?php PixelYourSite\HeadFooter()->render_switcher_input( 'footer_enabled' ); ?>
                            <h4 class="secondary_heading_type2 switcher-label">Footer Scripts</h4>
                        </div>

						<?php PixelYourSite\cardCollapseSettings(); ?>
                    </div>

                    <div class="card-body" <?php echo $enabled ? 'style="display:block"' : ''; ?>>
                        <div class="gap-22">
                            <div class="head-footer-script">
                                <h4 class="primary_heading">Any device type:</h4>
								<?php PixelYourSite\HeadFooter()->render_text_area_input( 'footer_any' ); ?>
                            </div>

                            <div class="head-footer-script">
                                <h4 class="primary_heading">Desktop Only:</h4>
								<?php PixelYourSite\HeadFooter()->render_text_area_input( 'footer_desktop' ); ?>
                            </div>

                            <div class="head-footer-script">
                                <h4 class="primary_heading">Mobile Only:</h4>
								<?php PixelYourSite\HeadFooter()->render_text_area_input( 'footer_mobile' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<?php if ( PixelYourSite\isWooCommerceActive() ) : ?>
        <div class="card card-style3">
			<?php $enabled = PixelYourSite\HeadFooter()->getOption( 'woo_order_received_enabled' ); ?>
            <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center <?php echo $enabled ? 'header-opened' : ''; ?>">
                <div class="disable-card d-flex align-items-center">
					<?php PixelYourSite\HeadFooter()->render_switcher_input( 'woo_order_received_enabled' ); ?>
                    <h4 class="secondary_heading_type2 switcher-label">WooCommerce Order Received Page Scripts</h4>
                </div>

				<?php PixelYourSite\cardCollapseSettings(); ?>
            </div>

            <div class="card-body" style="display:block">
                <div class="gap-22">

                    <!-- Head Scripts -->
                    <div class="card card-style4">
						<?php $enabled = PixelYourSite\HeadFooter()->getOption( 'woo_order_received_head_enabled' ); ?>
                        <div class="card-header card-header-style3 disable-card-wrap d-flex justify-content-between align-items-center header-opened">
                            <div class="disable-card d-flex align-items-center">
								<?php PixelYourSite\HeadFooter()->render_switcher_input( 'woo_order_received_head_enabled' ); ?>
                                <h4 class="secondary_heading_type2 switcher-label">WooCommerce Order Received Head
                                    Scripts</h4>
                            </div>

							<?php PixelYourSite\cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body" <?php echo $enabled ? 'style="display:block"' : ''; ?>>
                            <div class="gap-22">
                                <div class="head-footer-script">
                                    <h4 class="primary_heading">Any device type:</h4>
									<?php PixelYourSite\HeadFooter()->render_text_area_input( 'woo_order_received_head_any' ); ?>
                                </div>

                                <div class="head-footer-script">
                                    <h4 class="primary_heading">Desktop Only:</h4>
									<?php PixelYourSite\HeadFooter()->render_text_area_input( 'woo_order_received_head_desktop' ); ?>
                                </div>

                                <div class="head-footer-script">
                                    <h4 class="primary_heading">Mobile Only:</h4>
									<?php PixelYourSite\HeadFooter()->render_text_area_input( 'woo_order_received_head_mobile' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Scripts -->
                    <div class="card card-style4">
						<?php $enabled = PixelYourSite\HeadFooter()->getOption( 'woo_order_received_footer_enabled' ); ?>
                        <div class="card-header card-header-style3 disable-card-wrap d-flex justify-content-between align-items-center header-opened">
                            <div class="disable-card d-flex align-items-center">
								<?php PixelYourSite\HeadFooter()->render_switcher_input( 'woo_order_received_footer_enabled' ); ?>
                                <h4 class="secondary_heading_type2 switcher-label">WooCommerce Order Received Footer
                                    Scripts</h4>
                            </div>

							<?php PixelYourSite\cardCollapseSettings(); ?>
                        </div>

                        <div class="card-body" <?php echo $enabled ? 'style="display:block"' : ''; ?>>
                            <div class="gap-22">
                                <div class="head-footer-script">
                                    <h4 class="primary_heading">Any device type:</h4>
									<?php PixelYourSite\HeadFooter()->render_text_area_input( 'woo_order_received_footer_any' ); ?>
                                </div>

                                <div class="head-footer-script">
                                    <h4 class="primary_heading">Desktop Only:</h4>
									<?php PixelYourSite\HeadFooter()->render_text_area_input( 'woo_order_received_footer_desktop' ); ?>
                                </div>

                                <div class="head-footer-script">
                                    <h4 class="primary_heading">Mobile Only:</h4>
									<?php PixelYourSite\HeadFooter()->render_text_area_input( 'woo_order_received_footer_mobile' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php endif; ?>

    <!-- Replacements -->
	<?php include 'html-variables-help.php'; ?>

</div>

