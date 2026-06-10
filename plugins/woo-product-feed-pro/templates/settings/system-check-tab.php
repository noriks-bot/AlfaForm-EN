<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// phpcs:disable
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Helpers\Helper;

$total_projects      = Product_Feed_Helper::get_total_product_feed();
$domain              = sanitize_text_field( $_SERVER['HTTP_HOST'] );
$plugin_settings     = get_option( 'plugin_settings' );
$directory_perm_xml  = '';
$directory_perm_csv  = '';
$directory_perm_txt  = '';
$directory_perm_tsv  = '';
$directory_perm_logs = '';
$elite_disable       = 'disabled';
$count_variation     = wp_count_posts( 'product_variation' );
$count_single        = wp_count_posts( 'product' );
$published_single    = $count_single->publish;
$published_variation = $count_variation->publish;
$published_products  = $published_single + $published_variation;
$product_numbers     = array(
    'Single products'    => $published_single,
    'Variation products' => $published_variation,
    'Total products'     => $published_products,
);

$versions = array(
    'PHP'                          => (float) phpversion(),
    'Wordpress'                    => get_bloginfo( 'version' ),
    'WooCommerce'                  => WC()->version,
    'WooCommerce Product Feed PRO' => WOOCOMMERCESEA_PLUGIN_VERSION,
);

// If Elite plugin is active, get the version of the Elite plugin.
if ( Helper::has_paid_plugin_active() && defined( 'WOOCOMMERCESEA_ELITE_PLUGIN_VERSION' ) ) {
    $versions['WooCommerce Product Feed ELITE'] = WOOCOMMERCESEA_ELITE_PLUGIN_VERSION;
}

$order_rows = '';

// Check if the product feed directory is writeable
$upload_dir         = wp_upload_dir();
$external_base      = $upload_dir['basedir'];
$external_path      = $external_base . '/woo-product-feed-pro/';
$external_path_xml  = $external_base . '/woo-product-feed-pro/';
$external_path_csv  = $external_base . '/woo-product-feed-pro/';
$external_path_txt  = $external_base . '/woo-product-feed-pro/';
$external_path_tsv  = $external_base . '/woo-product-feed-pro/';
$external_path_logs = $external_base . '/woo-product-feed-pro/';
$test_file          = $external_path . '/tesfile.txt';
$test_file_xml      = $external_path . 'xml/tesfile.txt';
$test_file_csv      = $external_path . 'csv/tesfile.txt';
$test_file_txt      = $external_path . 'txt/tesfile.txt';
$test_file_tsv      = $external_path . 'tsv/tesfile.txt';
$test_file_logs     = $external_path . 'logs/tesfile.txt';

if ( is_writable( $external_path ) ) {
    // Normal root category
    if ( file_exists( $test_file ) ) {
        $fp = @fopen( $test_file, 'w' );
        @fwrite( $fp, 'Cats chase mice' );
        @fclose( $fp );
        if ( is_file( $test_file ) ) {
            $directory_perm = 'True';
        }
    } else {
        $directory_perm = 'False';
    }

    // XML subcategory
    if ( file_exists( $test_file_xml ) ) {
        $fp = @fopen( $test_file_xml, 'w' );
        if ( ! is_bool( $fp ) ) {
            @fwrite( $fp, 'Cats chase mice' );
            @fclose( $fp );
            if ( is_file( $test_file_xml ) ) {
                $directory_perm_xml = 'True';
            } else {
                $directory_perm_xml = 'False';
            }
        } else {
            $directory_perm_xml = 'Unknown';
        }
    } else {
        $directory_perm_xml = 'False';
    }

    // CSV subcategory
    if ( file_exists( $test_file_csv ) ) {
        $fp = @fopen( $test_file_csv, 'w' );
        if ( ! is_bool( $fp ) ) {
            @fwrite( $fp, 'Cats chase mice' );
            @fclose( $fp );
            if ( is_file( $test_file_csv ) ) {
                $directory_perm_csv = 'True';
            } else {
                $directory_perm_csv = 'False';
            }
        } else {
            $directory_perm_csv = 'Unknown';
        }
    } else {
        $directory_perm_csv = 'False';
    }

    // TXT subcategory
    if ( file_exists( $test_file_txt ) ) {
        $fp = @fopen( $test_file_txt, 'w' );
        if ( ! is_bool( $fp ) ) {
            @fwrite( $fp, 'Cats chase mice' );
            @fclose( $fp );
            if ( is_file( $test_file_txt ) ) {
                $directory_perm_txt = 'True';
            } else {
                $directory_perm_txt = 'False';
            }
        } else {
            $directory_perm_txt = 'Unknown';
        }
    } else {
        $directory_perm_txt = 'False';
    }

    // TSV subcategory
    if ( file_exists( $test_file_tsv ) ) {
        $fp = @fopen( $test_file_tsv, 'w' );
        if ( ! is_bool( $fp ) ) {
            @fwrite( $fp, 'Cats chase mice' );
            @fclose( $fp );
            if ( is_file( $test_file_tsv ) ) {
                $directory_perm_tsv = 'True';
            } else {
                $directory_perm_tsv = 'False';
            }
        } else {
            $directory_perm_tsv = 'Uknown';
        }
    } else {
        $directory_perm_tsv = 'False';
    }

    // Logs subcategory
    if ( file_exists( $test_file_logs ) ) {
        $fp = @fopen( $test_file_logs, 'w' );
        if ( ! is_bool( $fp ) ) {
            @fwrite( $fp, 'Cats chase mice' );
            @fclose( $fp );
            if ( is_file( $test_file_logs ) ) {
                $directory_perm_logs = 'True';
            } else {
                $directory_perm_logs = 'False';
            }
        } else {
            $directory_perm_logs = 'Unknown';
        }
    } else {
        $directory_perm_logs = 'False';
    }
} else {
    $directory_perm = 'False';
}

// Check if the cron is enabled
$action_scheduler_version = null;
$action_scheduler_path    = '';
// Check if Action Scheduler is installed
if ( class_exists( 'ActionScheduler_Versions' ) && class_exists( 'ActionScheduler' ) ) {
    $action_scheduler_version = ActionScheduler_Versions::instance()->latest_version();
    $action_scheduler_path    = ActionScheduler::plugin_path( '' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
}

print '<table class="woo-product-feed-pro-table">';
print '<tr><td><strong>System check</strong></td><td><strong>Status</strong></td></tr>';
echo '<tr><td>Action Scheduler</td><td>';
if ( ! is_null( $action_scheduler_version ) ) {
    echo '<span class="dashicons dashicons-yes" style="line-height: 16px;"></span> ' . esc_html( $action_scheduler_version ) . '<br/><code class="private">' . esc_html( $action_scheduler_path ) . '</code>';
} else {
    echo '<span class="dashicons dashicons-warning" style="line-height: 16px;"></span> ' . esc_html__( 'Unable to detect the Action Scheduler package.', 'woo-product-feed-pro' );
}
echo '</td></tr>';
echo "<tr><td>PHP-version</td><td>($versions[PHP])</td></tr>";
echo "<tr><td>Product feed directory writable</td><td>$directory_perm</td></tr>";
echo "<tr><td>Product feed XML directory writable</td><td>$directory_perm_xml</td></tr>";
echo "<tr><td>Product feed CSV directory writable</td><td>$directory_perm_csv</td></tr>";
echo "<tr><td>Product feed TXT directory writable</td><td>$directory_perm_txt</td></tr>";
echo "<tr><td>Product feed TSV directory writable</td><td>$directory_perm_tsv</td></tr>";
echo "<tr><td>Product feed LOGS directory writable</td><td>$directory_perm_logs</td></tr>";
print '</table>';

// Display the debugging information.
$notifications_obj  = new \WooSEA_Get_Admin_Notifications();
$debug_info_content = $notifications_obj->woosea_debug_informations( $versions, $product_numbers, $order_rows );
$debug_info_title   = __( 'System Report', 'woo-product-feed-pro' );

print '<div class="woo-product-feed-pro-debug-info">';
print '<button class="button copy-product-feed-pro-debug-info" type="button" data-clipboard-target="#woo-product-feed-pro-debug-info">Copy to clipboard</button>';
echo "<h3>{$debug_info_title}</h3>";
print '<p>' . __( 'Copy the below text and paste to the support team when requested to help us debug any systems issues with your feeds.', 'woo-product-feed-pro' ) . '</p>';
echo "<pre id=\"woo-product-feed-pro-debug-info\">{$debug_info_content}</pre>";
print '</div>';
