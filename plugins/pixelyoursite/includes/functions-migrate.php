<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class FunctionsMigrate {

    private $pys_free_version;
    private static $_instance;

    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;

    }

    public function __construct()
    {
        $this->pys_free_version = get_option( 'pys_core_free_version', false );

        add_action('plugins_loaded', array($this,'maybeMigrate'), 1);
    }
    public function maybeMigrate() {

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            return;
        }

        if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $pys_free_version = get_option( 'pys_core_free_version', false );

        $migrations = [
            '11.1.0' => [ $this, 'migrate_11_1_0' ],
            '10.1.1.1' => [ $this, 'migrate_10_1_1_1' ],
            '10.0.1' => [ $this, 'migrate_10_0_0' ],
            '9.6.1'  => [ $this, 'migrate_9_6_1' ],
            '9.5.6'  => [ $this, 'migrate_9_5_6' ],
            '9.5.1.1' => [$this, 'migrate_unify_custom_events' ],
            '9.0.0'  => [ $this, 'migrate_9_0_0' ],
            '7.1.0'  => [ $this, 'migrate_7_1_0_bing_defaults' ]
        ];

        foreach ($migrations as $version => $migration_function) {
            if (!$pys_free_version || version_compare($pys_free_version, $version, '<')) {
                if ($version === '9.5.1.1' && get_option('pys_custom_event_migrate_free', false)) {
                    continue;
                }
                if (is_callable($migration_function)) {
                    try {
                        $migration_function();
                        update_option('pys_core_free_version', PYS_FREE_VERSION);
                        update_option('pys_updated_at', time());
                    } catch (\Throwable $e) {
                        error_log(print_r($e, true));
                    }
                }
            }
        }
    }
    protected function migrate_unify_custom_events(){
        foreach (CustomEventFactory::get() as $event) {
            $event->migrateUnifyGA();
        }
        update_option( 'pys_custom_event_migrate_free', true );
    }
    protected function migrate_11_1_0() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'pys_options';

        $this->create_pys_options_table($table_name);

        $names = [
            'pys_core','pys_facebook','pys_ga','pys_google_ads','pys_gtm','pys_gatags',
            'pys_tiktok','pys_head_footer','pys_pinterest','pys_bing','pys_superpack',
            'pys_CF7','pys_ElementorForm','pys_Fluentform','pys_Formidable','pys_forminator',
            'pys_Gravity','pys_NinjaForm','pys_WPForms','pys_WSForm',
        ];

        $rows = $this->get_options_for_migration($names);

        if (empty($rows)) {
            return; // нечего переносить
        }

        $wpdb->query('START TRANSACTION');
        try {
            $inserted_names = $this->migrate_options($wpdb, $table_name, $rows);

            if (empty($inserted_names)) {
                throw new \RuntimeException('No valid options migrated.');
            }

            $count_new = (int) $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM $table_name WHERE option_name IN (" .
                    implode(',', array_fill(0, count($inserted_names), '%s')) . ")",
                    $inserted_names
                )
            );

            if ($count_new !== count($inserted_names)) {
                throw new \RuntimeException('Mismatch after migration.');
            }

            $this->cleanup_old_options($wpdb);

            $wpdb->query('COMMIT');
        } catch (\Throwable $e) {
            $wpdb->query('ROLLBACK');
            error_log('Migration 12.1.4 failed: ' . $e->getMessage());
        }
    }

    private function create_pys_options_table($table_name) {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        option_name VARCHAR(191) NOT NULL,
        option_value LONGTEXT NOT NULL,
        migrated TINYINT(1) NOT NULL DEFAULT 1,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        UNIQUE KEY option_name (option_name)
    ) $charset_collate;";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    private function get_options_for_migration(array $names) {
        global $wpdb;
        $placeholders = implode(',', array_fill(0, count($names), '%s'));
        $like = '%' . $wpdb->esc_like('"slug":"pixelyoursite') . '%';

        $sql = "SELECT option_id, option_name, option_value,
                CASE WHEN option_name IN ($placeholders) THEN 'safe' ELSE 'like' END as source_type
            FROM {$wpdb->options}
            WHERE option_value LIKE %s
               OR option_name IN ($placeholders)";

        $params = array_merge($names, [$like], $names);

        return $wpdb->get_results($wpdb->prepare($sql, $params), ARRAY_A);
    }

    private function migrate_options($wpdb, $table_name, array $rows): array {
        $inserted_names = [];
        foreach ($rows as $row) {
            if ($row['source_type'] === 'like' && strpos($row['option_name'], 'pys_api_request_') !== 0) {
                continue;
            }
            $result = $wpdb->replace(
                $table_name,
                [
                    'option_name' => $row['option_name'],
                    'option_value' => $row['option_value'],
                ],
                ['%s','%s']
            );
            if ($result === false) {
                throw new \RuntimeException('Failed to insert ' . $row['option_name']);
            }
            $inserted_names[] = $row['option_name'];
        }
        return $inserted_names;
    }

    private function cleanup_old_options($wpdb) {
        $options = $wpdb->get_results("
        SELECT option_id, option_value FROM {$wpdb->options}
        WHERE (option_value LIKE '%www.pixelyoursite.com%' 
            OR option_value LIKE '%License key is not valid%')
          AND option_name NOT LIKE '%_site_transient%'
    ");

        $delete_ids = [];
        foreach ($options as $opt) {
            $value = maybe_unserialize($opt->option_value);
            $value = isset($value['value']) ? json_decode($value['value']) : '';

            if (isset($value->msg) && strpos((string)$value->msg, 'License key is not valid')) {
                $delete_ids[] = $opt->option_id;
            } elseif ($value && isset($value->last_updated)
                && strtotime($value->last_updated) < strtotime('-1 month')) {
                $delete_ids[] = $opt->option_id;
            } elseif ($value && isset($value->slug) && strpos($value->slug, 'pixelyoursite')) {
                $delete_ids[] = $opt->option_id;
            }
        }

        if ($delete_ids) {
            $wpdb->query(
                "DELETE FROM {$wpdb->options} WHERE option_id IN (" . implode(',', array_map('intval', $delete_ids)) . ")"
            );
        }
    }
    protected function migrate_10_1_1_1()
    {
        if (!in_array('category_name', Facebook()->getOption('do_not_track_medical_param'))) {
            Facebook()->updateOptions([
                'do_not_track_medical_param' => array_merge(Facebook()->getOption('do_not_track_medical_param'), ['category_name']),
            ]);
        }
    }
    protected function migrate_10_0_0()
    {
        if(GTM()->getOption('gtm_dataLayer_name') === 'dataLayerPYS'){
            GTM()->updateOptions([
                "gtm_dataLayer_name" => 'dataLayer',
            ]);
        }
    }
    protected function migrate_9_6_1() {
        $globalOptions = [
            "block_robot_enabled" => true,
        ];
        PYS()->updateOptions($globalOptions);
    }
    protected function migrate_9_5_6() {
        $ga_tags_woo_options = [];
        $ga_tags_edd_options = [];
        if(GA()->enabled()){
            $ga_tags_woo_options = [
                'woo_variable_as_simple' => GATags()->getOption('woo_variable_as_simple') ?? GA()->getOption('woo_variable_as_simple'),
                'woo_variations_use_parent_name' => GATags()->getOption('woo_variations_use_parent_name') ?? GA()->getOption('woo_variations_use_parent_name'),
                'woo_content_id' => GATags()->getOption('woo_content_id') ?? GA()->getOption('woo_content_id'),
                'woo_content_id_prefix' => GATags()->getOption('woo_content_id_prefix') ?? GA()->getOption('woo_content_id_prefix'),
                'woo_content_id_suffix' => GATags()->getOption('woo_content_id_suffix') ?? GA()->getOption('woo_content_id_suffix'),
            ];

            $ga_tags_edd_options = [
                'edd_content_id' => GATags()->getOption('edd_content_id') ?? GA()->getOption('edd_content_id'),
                'edd_content_id_prefix' => GATags()->getOption('edd_content_id_prefix') ?? GA()->getOption('edd_content_id_prefix'),
                'edd_content_id_suffix' => GATags()->getOption('edd_content_id_suffix') ?? GA()->getOption('edd_content_id_suffix'),
            ];
        }
        else{
            return false;
        }
        GATags()->updateOptions($ga_tags_woo_options);
        GATags()->updateOptions($ga_tags_edd_options);
    }
    protected function migrate_9_0_0() {
        $globalOptions = [
            "automatic_events_enabled" => PYS()->getOption("signal_events_enabled") || PYS()->getOption("automatic_events_enabled"),
            "automatic_event_form_enabled" => PYS()->getOption("signal_form_enabled"),
            "automatic_event_download_enabled" => PYS()->getOption("signal_download_enabled"),
            "automatic_event_comment_enabled" => PYS()->getOption("signal_comment_enabled"),
            "automatic_event_scroll_enabled" => PYS()->getOption("signal_page_scroll_enabled"),
            "automatic_event_time_on_page_enabled" => PYS()->getOption("signal_time_on_page_enabled"),
            "automatic_event_scroll_value" => PYS()->getOption("signal_page_scroll_value"),
            "automatic_event_time_on_page_value" => PYS()->getOption("signal_time_on_page_value"),
            "automatic_event_download_extensions" => PYS()->getOption("download_event_extensions"),
        ];
        PYS()->updateOptions($globalOptions);
    }

    protected function migrate_7_1_0_bing_defaults() {

        $bing_defaults = array(
            'gdpr_bing_prior_consent_enabled' => true,
            'gdpr_cookiebot_bing_consent_category' => 'marketing',
        );

        // update settings
        PYS()->updateOptions( $bing_defaults );
        PYS()->reloadOptions();

    }
}

function FunctionMigrate() {
    return FunctionsMigrate::instance();
}

FunctionMigrate();