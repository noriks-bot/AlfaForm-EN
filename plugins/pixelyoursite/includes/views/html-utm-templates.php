<?php
namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$utms = [
    "utm_source",
    "utm_medium",
    "utm_campaign",
    "utm_content",
    "utm_term",
];
?>
<div class="cards-wrapper cards-wrapper-style2 gap-24 utm-template-wrapper">
    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center logs_enable">
                <h4 class="secondary_heading_type2"><?php _e('UTM Templates', 'pys');?></h4>
            </div>
        </div>

        <div class="card-body">
            <div class="gap-24">
                <div>
                    <h4 class="secondary_heading mb-4">Meta (Facebook) - <a class="link" target="_blank" href="https://www.youtube.com/watch?v=aAJcjurzp-Q"><?php _e( 'watch video:', 'pys' );?></a></h4>
                    <div class="utm_template copy_text">
                        utm_source=facebook&utm_medium=paid&utm_campaign={{campaign.name}}&utm_term={{adset.name}}&utm_content={{ad.name}}&fbadid={{ad.id}}
                        <div class="copy-icon" data-toggle="pys-popover"
                             data-tippy-trigger="click" data-tippy-placement="bottom"
                             data-popover_id="copied-popover"></div>
                    </div>
                </div>

                <div>
                    <h4 class="secondary_heading mb-4">Google Ads - <a class="link" target="_blank" href="https://www.youtube.com/watch?v=j1TlbKYNZk4"><?php _e( 'watch video:', 'pys' );?></a></h4>
                    <div class="utm_template copy_text">
                        {lpurl}?utm_source=google&utm_medium=paid&utm_campaign={campaignid}&utm_content={adgroupid}&utm_term={keyword}&gadid={creative}
                        <div class="copy-icon" data-toggle="pys-popover"
                             data-tippy-trigger="click" data-tippy-placement="bottom"
                             data-popover_id="copied-popover"></div>
                    </div>
                </div>

                <div>
                    <h4 class="secondary_heading mb-4">TikTok - <a class="link" target="_blank" href="https://www.youtube.com/watch?v=bB2OVtlpQ5g"><?php _e( 'watch video:', 'pys' );?></a></h4>
                    <div class="utm_template copy_text">
                        ?utm_source=tiktok&utm_medium=paid&utm_campaign=__CAMPAIGN_NAME__&utm_term=__AID_NAME__&utm_content=__CID_NAME__&ttadid=__CID__
                        <div class="copy-icon" data-toggle="pys-popover"
                             data-tippy-trigger="click" data-tippy-placement="bottom"
                             data-popover_id="copied-popover"></div>
                    </div>
                </div>

                <div>
                    <h4 class="secondary_heading mb-4">Pinterest - <a class="link" target="_blank" href="https://www.youtube.com/watch?v=MKdS0PiND7M"><?php _e( 'watch video:', 'pys' );?></a></h4>
                    <div class="utm_template copy_text">
                        ?utm_source=pinterest&utm_medium=paid&utm_campaign={campaign_name}&utm_term={adgroup_name}&utm_content={creative_id}&padid={adid}
                        <div class="copy-icon" data-toggle="pys-popover"
                             data-tippy-trigger="click" data-tippy-placement="bottom"
                             data-popover_id="copied-popover"></div>
                    </div>
                </div>

                <div>
                    <h4 class="secondary_heading mb-4">Bing - <a class="link" target="_blank" href="https://www.youtube.com/watch?v=lC6c-Pt5fxM"><?php _e( 'watch video:', 'pys' );?></a></h4>
                    <div class="utm_template copy_text">
                        {lpurl}?utm_source=bing&utm_medium=paid&utm_campaign={campaign}&utm_content={AdGroupId}&utm_term={AdGroup}&bingid={CampaignId}
                        <div class="copy-icon" data-toggle="pys-popover"
                             data-tippy-trigger="click" data-tippy-placement="bottom"
                             data-popover_id="copied-popover"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-style6 card-static">
        <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center logs_enable">
                <h4 class="secondary_heading_type2"><?php _e( 'UTM Builder', 'pys' ); ?></h4>
            </div>
        </div>

        <div class="card-body">
            <div class="gap-24 pys_utm_builder">
                <div>
                    <h4 class="secondary_heading mb-4"><?php _e( 'Your URL:', 'pys' );?></h4>
                    <input class="input-standard site_url" type="text" value="<?=get_site_url(); ?>"/>
                </div>
                <?php
                foreach ($utms as $utm) : ?>
                    <div >
                        <h4 class="secondary_heading mb-4"><?=$utm?>:</h4>
                        <input type="text" class="input-standard utm <?=$utm?>" value="" data-type="<?=$utm?>"/>
                    </div>
                <?php endforeach; ?>

                <div class="">
                    <h4 class="secondary_heading mb-4"><?php _e( 'URL with UTMs:', 'pys' );?></h4>
                    <div class="copy_text build_utms_with_url bg-gray" >
                        <span class="insert"></span>
                        <div class="copy-icon" data-toggle="pys-popover"
                             data-tippy-trigger="click" data-tippy-placement="bottom"
                             data-popover_id="copied-popover"></div>
                    </div>
                </div>
                <div class="">
                    <h4 class="secondary_heading mb-4"><?php _e( 'UTMs:', 'pys' );?></h4>
                    <div class="copy_text build_utms bg-gray" >
                        <span class="insert"></span>
                        <div class="copy-icon" data-toggle="pys-popover"
                             data-tippy-trigger="click" data-tippy-placement="bottom"
                             data-popover_id="copied-popover"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>