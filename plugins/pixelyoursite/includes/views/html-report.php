<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>

<div class="cards-wrapper cards-wrapper-style2 gap-24 report-system-wrapper">
    <?php foreach ( get_system_report_data() as $section_name => $section_report ) : ?>
        <div class="card card-style6 card-static">
            <div class="card-header card-header-style2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center logs_enable">
                    <h4 class="secondary_heading_type2 switcher-label"><?php esc_html_e( $section_name ); ?></h4>
                </div>
            </div>

            <div class="card-body">
                <table class="table system-report">
                    <tbody>

                    <?php foreach ( $section_report as $name => $value ) : ?>

                        <tr>
                            <td style="width: 40%;"><?php echo $name; ?></td>
                            <td style="width: 60%;"><?php echo $value; ?></td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>