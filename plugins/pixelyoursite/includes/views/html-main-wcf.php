<?php
namespace PixelYourSite;

use Cartflows_Helper;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>


    <div class="cards-wrapper cards-wrapper-style1 gap-24">
    <?php if(!isWooCommerceActive()) : ?>
        <div class="panel card card-style6 card-static">
            <div class="card-body text-center d-flex align-items-center justify-content-between gap-24">
                <div class="secondary_heading" style="width: 500px; margin:auto; text-align: center;" >
                    PixelYourSite's current integration works when you have both the CartFlows and the WooCommerce plugins.
                </div>
            </div>
        </div>

<?php else: ?>
        <!-- General-->
        <div class="card card-style5">
            <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <h4 class="secondary_heading_type2"><?php _e( 'General', 'pys' ); ?></h4>
                </div>

                <?php cardCollapseSettings(); ?>
            </div>

            <div class="card-body">
                <div class="gap-24">
                    <p>From here you can control the events and parameters fired by PixelYourSite Professional on CartFlows pages and actions.</p>
                    <p class="text-gray">To learn more <a class="link" href="https://www.pixelyoursite.com/cartflows-and-pixelyoursite" target="_blank">go to this dedicated page and watch the video</a></p>

                    <div class="d-flex align-items-center pro-feature-container">
                        <div class="d-flex align-items-center flex-with-badge">
                            <?php renderDummySwitcher( false); ?>
                            <h4 class="switcher-label secondary_heading"><?php _e( 'Enable CartFlows set-up', 'pys' ); ?></h4>
                        </div>
                        <?php renderProBadge(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $videos = array(
            array(
                'url'   => 'https://www.youtube.com/watch?v=uXTpgFu2V-E',
                'title' => 'How to configure Facebook Conversion API',
                'time'  => '2:51',
            ),
            array(
                'url'   => 'https://www.youtube.com/watch?v=DZzFP4pSitU',
                'title' => 'Meta Pixel, CAPI, and PixelYourSite MUST WATCH',
                'time'  => '8:19',
            ),
            array(
                'url'   => 'https://www.youtube.com/watch?v=QqAIO1ONc0I',
                'title' => 'How to test Facebook Conversion API',
                'time'  => '10:16',
            ),
            array(
                'url'   => 'https://www.youtube.com/watch?v=sM9yNkBK6Eg',
                'title' => 'Potentially Violating Personal Data Sent to Facebook',
                'time'  => '7:30',
            ),
            array(
                'url'   => 'https://www.youtube.com/watch?v=PsKdCkKNeLU',
                'title' => 'Facebook Conversion API and the Consent Problem',
                'time'  => '9:25',
            ),
            array(
                'url'   => 'https://www.youtube.com/watch?v=kEp5BDg7dP0',
                'title' => 'How to fire EVENTS with PixelYourSite',
                'time'  => '22:28',
            ),
            array(
                'url'   => 'https://www.youtube.com/watch?v=WH7-vHgehIs',
                'title' => 'FIX IT: PixelYourSite high number of admin-ajax requests',
                'time'  => '9:04',
            ),
            array(
                'url'   => 'https://www.youtube.com/watch?v=EvzGMAvBnbs',
                'title' => 'How to create Meta (Facebook) Custom Audiences & Lookalikes based on Events & Parameters',
                'time'  => '21:53',
            ),
        );

        renderRecommendedVideo( $videos );
        ?>
        <!-- Dedicated Tracking -->
        <div class="card card-style5">
            <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <h4 class="secondary_heading_type2"><?php _e( 'Dedicated Tracking IDs (optional)', 'pys' ); ?></h4>
                </div>
                <div class="d-flex align-items-center flex-collapse-block">
                    <?php renderProBadge(); ?>
                    <?php cardCollapseSettings(); ?>
                </div>
            </div>

            <div class="card-body">
                <div class="gap-24">
                    <?php if ( Facebook()->enabled() ) : ?>
                        <div class="plate gap-24">
                            <div>
                                <h4 class="secondary_heading_type2 mb-24">Meta Pixel</h4>
                                <h4 class="primary_heading mb-8">Meta Pixel ID:</h4>
                                <?php renderDummyTextInput('Add your pixel ID there'); ?>
                                <div class="form-text mt-4">
                                    <a href="https://www.pixelyoursite.com/docs/meta-facebook-settings-setup"
                                       target="_blank" class="link link-small">How to get it?</a>
                                </div>
                            </div>

                            <div>
                                <h4 class="primary_heading mb-8">Conversion API:</h4>
                                <?php renderDummyTextAreaInput('Add your token there'); ?>
                            </div>

                            <div>
                                <h4 class="primary_heading mb-8">test_event_code:</h4>
                                <?php renderDummyTextInput('Add your test_event_code there'); ?>
                            </div>

                            <div>
                                <h4 class="primary_heading mb-8">Verify your domain:</h4>
                                <?php renderDummyTextInput('Add the verification meta-tag there'); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( GA()->enabled() ) : ?>
                        <div class="plate gap-24">
                            <div>
                                <h4 class="secondary_heading_type2 mb-24">Google Analytics</h4>
                                <h4 class="primary_heading mb-8">Google Analytics ID:</h4>
                                <?php renderDummyTextInput('Add your ID there'); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( Bing()->enabled() ) : ?>
                        <div class="plate gap-24">
                            <div>
                                <h4 class="secondary_heading_type2 mb-24">Bing Tag</h4>
                                <h4 class="primary_heading mb-8">Bing Tag ID:</h4>
                                <?php renderDummyTextInput('Add your ID there'); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( Pinterest()->enabled() ) : ?>
                        <div class="plate gap-24">
                            <div>
                                <h4 class="secondary_heading_type2 mb-24">Pinterest Pixel</h4>
                                <h4 class="primary_heading mb-8">Pinterest Pixel ID:</h4>
                                <?php renderDummyTextInput('Add your ID there'); ?>
                            </div>
                            <div>
                                <h4 class="primary_heading mb-8">Verify your domain:</h4>
                                <?php renderDummyTextInput('Add the verification meta-tag there'); ?>
                            </div>
                        </div>
                    <?php endif; ?>

	                <?php if ( Reddit()->enabled() ) : ?>
                        <div class="plate gap-24">
                            <div>
                                <h4 class="secondary_heading_type2 mb-24">Reddit Tag</h4>
                                <h4 class="primary_heading mb-8">Reddit Tag ID:</h4>
				                <?php renderDummyTextInput('Add your ID there'); ?>
                            </div>
                        </div>
	                <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Standard Events Settings -->
        <div class="card card-style5">
            <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <h4 class="secondary_heading_type2"><?php _e( 'Standard Events Settings', 'pys' ); ?></h4>
                </div>
                <div class="d-flex align-items-center flex-collapse-block">
                    <?php renderProBadge(); ?>
                    <?php cardCollapseSettings(); ?>
                </div>
            </div>

            <div class="card-body">
                <div class="pro-feature-container">
                    <div class="gap-22">
                        <!-- Purchase -->
                        <div class="card card-style6">
                            <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <h4 class="secondary_heading_type2">Purchase settings</h4>
                                </div>
                                <div class="d-flex align-items-center flex-collapse-block">
                                    <?php renderProBadge(); ?>
                                    <?php cardCollapseSettings(); ?>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="gap-24">
                                    <p>You have additional options for this event on the plugins WooCommerce page</p>

                                    <div class="radio-inputs-wrap">
                                        <?php renderDummyRadioInput('Fire a Purchase event for each Upsale and Downsale step', true); ?>
                                        <?php renderDummyRadioInput('Fire a single Purchase event for all Upsale or Downsale steps. <strong>Caution</strong>: if the client abandons a step, we wont\'t track the transaction'); ?>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Fire the event Optin offers</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- AddToCart -->
                        <div class="card card-style6">
                            <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <h4 class="secondary_heading_type2">AddToCart settings</h4>
                                </div>
                                <div class="d-flex align-items-center flex-collapse-block">
                                    <?php renderProBadge(); ?>
                                    <?php cardCollapseSettings(); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="gap-24">
                                    <p>You have additional options for this event on the plugins WooCommerce page</p>
                                    <div class="d-flex align-items-center">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Fire the event for order bumps</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Lead -->
                        <div class="card card-style6">
                            <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <h4 class="secondary_heading_type2">Lead</h4>
                                </div>
                                <div class="d-flex align-items-center flex-collapse-block">
                                    <?php renderProBadge(); ?>
                                    <?php cardCollapseSettings(); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="gap-24">
                                    <div class="d-flex align-items-center">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Fire a Lead event when a Optin offer is accepted</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ViewContent -->
                        <div class="card card-style6">
                            <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <h4 class="secondary_heading_type2">ViewContent settings</h4>
                                </div>
                                <div class="d-flex align-items-center flex-collapse-block">
                                    <?php renderProBadge(); ?>
                                    <?php cardCollapseSettings(); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="gap-24">
                                    <p>You have additional options for this event on the plugins WooCommerce page</p>
                                    <p>The event is always fired on landing pages</p>
                                    <div class="d-flex align-items-center">
                                        <?php renderDummySwitcher(); ?>
                                        <h4 class="switcher-label secondary_heading">Fire the event on Upsale and Downsale steps</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Events -->
        <div class="card card-style5">
            <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <h4 class="secondary_heading_type2"><?php _e( 'Custom Events', 'pys' ); ?></h4>
                </div>
                <div class="d-flex align-items-center flex-collapse-block">
                    <?php renderProBadge(); ?>
                    <?php cardCollapseSettings(); ?>
                </div>
            </div>

            <div class="card-body">
                <div class="pro-feature-container">
                    <div class="gap-22">
                        <!-- CartFlows -->
                        <div class="card card-style6">
                            <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher();?>
                                    <h4 class="secondary_heading_type2 switcher-label">CartFlows Event</h4>
                                </div>
                                <div class="d-flex align-items-center flex-collapse-block">
                                    <?php renderProBadge(); ?>
                                    <?php cardCollapseSettings(); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="gap-24">
                                    <p><?php _e('Fire this event for all CartFlows pages.', 'pys');?></p>
                                    <?php if ( Facebook()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Facebook</h4>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( GA()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Google Analytics</h4>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( Pinterest()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Pinterest</h4>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( Bing()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Bing</h4>
                                        </div>
                                    <?php endif; ?>

	                                <?php if ( Reddit()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
			                                <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Reddit</h4>
                                        </div>
	                                <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- step event -->
                        <div class="card card-style6">
                            <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher();?>
                                    <h4 class="secondary_heading_type2 switcher-label">Track Steps</h4>
                                </div>
                                <div class="d-flex align-items-center flex-collapse-block">
                                    <?php renderProBadge(); ?>
                                    <?php cardCollapseSettings(); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="gap-24">
                                    <p><?php _e('Fire CartFlows_Landing, CartFlows_Upsale, CartFlows_Downsale, CartFlows_Checkout, CartFlows_ThankYou, CartFlows_Optin', 'pys');?></p>
                                    <?php if ( Facebook()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Facebook</h4>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( GA()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Google Analytics</h4>
                                        </div>

                                    <?php endif; ?>

                                    <?php if ( Pinterest()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Pinterest</h4>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( Bing()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Bing</h4>
                                        </div>
                                    <?php endif; ?>

	                                <?php if ( Reddit()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
			                                <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Reddit</h4>
                                        </div>
	                                <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- step event -->
                        <div class="card card-style6">
                            <div class="card-header card-header-style2 disable-card-wrap d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <?php renderDummySwitcher();?>
                                    <h4 class="secondary_heading_type2 switcher-label">Track Order Bumps</h4>
                                </div>
                                <div class="d-flex align-items-center flex-collapse-block">
                                    <?php renderProBadge(); ?>
                                    <?php cardCollapseSettings(); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="gap-24">
                                    <p><?php _e('Fire CartFlows_order_bump, when an order bump is accepted', 'pys');?></p>
                                    <?php if ( Facebook()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Facebook</h4>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( GA()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Google Analytics</h4>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( Pinterest()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Pinterest</h4>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( Bing()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
                                            <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Bing</h4>
                                        </div>
                                    <?php endif; ?>

	                                <?php if ( Reddit()->enabled() ) : ?>
                                        <div class="d-flex align-items-center">
			                                <?php renderDummySwitcher(); ?>
                                            <h4 class="switcher-label secondary_heading">Reddit</h4>
                                        </div>
	                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CartFlows Events Parameters -->
        <div class="card card-style5">
            <div class="card-header card-header-style3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <h4 class="secondary_heading_type2"><?php _e( 'CartFlows Events Parameters', 'pys' ); ?></h4>
                </div>
                <div class="d-flex align-items-center flex-collapse-block">
                    <?php renderProBadge(); ?>
                    <?php cardCollapseSettings(); ?>
                </div>
            </div>

            <div class="card-body">
                <div class="pro-feature-container">
                    <div class="gap-24">
                        <h4 class="secondary_heading_type"><?php _e( 'Control the CartFlows Parameters', 'pys' ); ?></h4>
                        <div class="d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="switcher-label secondary_heading">CartFlows</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="switcher-label secondary_heading">CartFlows_flow</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <?php renderDummySwitcher(); ?>
                            <h4 class="switcher-label secondary_heading">CartFlows_step</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif;?>
</div>
