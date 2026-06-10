<?php
namespace PixelYourSite\Enrich;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * @param array $utms
 */
function printUtm($utms) {
    $utmList = [];
    $utmKeys = [
        "utm_source",
        "utm_medium",
        "utm_campaign",
        "utm_content",
        "utm_term",
    ];

    foreach($utms as $utm) {
        $item = explode(":",$utm);
        if (count($item) < 2) continue;
        $name = $item[0];
        $value = $item[1] == "undefined" ? "No ".$name." detected for this order" : $item[1];
        $utmList[$name] = $value;

    }
    foreach ($utmKeys as $key) {
        if(key_exists($key,$utmList)) {
            ?>
            <tr>
                <th><?=esc_html($key)?>:</th>
                <td><?=esc_html($utmList[$key]); ?></td>
            </tr>
            <?php
        }
    }
}
