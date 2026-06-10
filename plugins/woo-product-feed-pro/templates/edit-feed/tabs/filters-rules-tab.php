<?php
// phpcs:disable
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Factories\Admin_Notice;
use AdTribes\PFP\Classes\Product_Feed_Attributes;
use AdTribes\PFP\Helpers\Product_Feed_Helper;
use AdTribes\PFP\Classes\Legacy\Filters_Legacy;
use AdTribes\PFP\Classes\Legacy\Rules_Legacy;

/**
 * Create product attribute object
 */
$product_feed_attributes = new Product_Feed_Attributes();
$attributes              = $product_feed_attributes->get_attributes();

$feed         = null;
$feed_id      = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
$edit_feed    = false;
if ( $feed_id ) {
    $feed = Product_Feed_Helper::get_product_feed( sanitize_text_field( $feed_id ) );
    if ( $feed ) {
        $feed_rules     = $feed->rules;
        $feed_filters   = $feed->filters;
        $channel_data   = $feed->channel;
        $feed_type   = $channel_data['fields'] ?? '';

        $project_hash = $feed->legacy_project_hash;

        $count_rules = 0;
        if ( ! empty( $feed_filters ) && is_array( $feed_filters ) ) {
            $count_rules = count( $feed_filters );
        }

        $count_rules2 = 0;
        if ( ! empty( $feed_rules ) && is_array( $feed_rules ) ) {
            $count_rules2 = count( $feed_rules );
        }

        $edit_feed = true;
    }
} else {
    $feed         = get_option( ADT_OPTION_TEMP_PRODUCT_FEED, array() );
    $channel_hash = $feed['channel_hash'] ?? '';
    $project_hash = $feed['project_hash'] ?? '';
    $channel_data = '' !== $channel_hash ? Product_Feed_Helper::get_channel_from_legacy_channel_hash( $channel_hash ) : array();
    $feed_type   = $channel_data['fields'] ?? '';

    $feed_filters = $feed['rules'] ?? array();
    $feed_rules   = $feed['rules2'] ?? array();
    $count_rules  = count( $feed_filters );
    $count_rules2 = count( $feed_rules );
}

// Instantiate the classes.
$filters_instance = new Filters_Legacy( $feed_type ?? '' );
$rules_instance   = new Rules_Legacy( $feed_type ?? '');

/**
 * Action hook to add content before the product feed manage page.
 *
 * @param int                      $step         Step number.
 * @param string                   $project_hash Project hash.
 * @param array|Product_Feed|null  $feed         Product_Feed object or array of project data.
 */
do_action( 'adt_before_product_feed_manage_page', 4, $project_hash, $feed );
?>
<div class="woo-product-feed-pro-form-style-2">
    <?php
    // Display info message notice.
    ob_start();
    Helper::locate_admin_template( 'notices/feed-filter-rule-notice.php', true );
    $message = ob_get_clean();

    $admin_notice = new Admin_Notice(
        $message,
        'info',
        false,
        true
    );
    $admin_notice->run();
    ?>

    <form class="adt-edit-feed-form" id="filters_rules" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <?php wp_nonce_field( 'woosea_ajax_nonce' ); ?>
        <input type="hidden" id="feed_id" name="feed_id" value="<?php echo esc_attr( $feed->id ?? 0 ); ?>">
        <input type="hidden" name="action" value="edit_feed_form_process" />
        <input type="hidden" name="active_tab" value="filters_rules" />
        <input type="hidden" name="feed_type" value="<?php echo esc_attr( $feed_type ?? '' ); ?>">
        <table class="woo-product-feed-pro-table" id="woosea-ajax-table" border="1">
            <thead>
                <tr>
                    <th></th>
                    <th><?php esc_html_e( 'Type', 'woo-product-feed-pro' ); ?></th>
                    <th>
                        <?php
                        esc_html_e( 'IF', 'woo-product-feed-pro' );
                        echo wc_help_tip( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            esc_html__(
                                'Specify the condition under which this filter or rule will be applied. Choose an attribute or condition that will trigger this rule.',
                                'woo-product-feed-pro'
                            )
                        );
                        ?>
                    </th>
                    <th>
                        <?php
                        esc_html_e( 'Condition', 'woo-product-feed-pro' );
                        echo wc_help_tip( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            esc_html__(
                                'Define the specific condition to be met. Options include equals, not equals, greater than, less than, etc., depending on the selected attribute.',
                                'woo-product-feed-pro'
                            )
                        );
                        ?>
                    </th>
                    <th>
                        <?php
                        esc_html_e( 'Value', 'woo-product-feed-pro' );
                        echo wc_help_tip( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            esc_html__(
                                'Enter the value that the condition should match. This value will be compared against the attribute chosen in the IF field.',
                                'woo-product-feed-pro'
                            )
                        );
                        ?>
                    </th>
                    <th>
                        <?php
                        esc_html_e( 'CS', 'woo-product-feed-pro' );
                        echo wc_help_tip( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            esc_html__(
                                'Enable this option if the condition should be case-sensitive. This means that \'Product\' and \'product\' will be treated as different values.',
                                'woo-product-feed-pro'
                            )
                        );
                        ?>
                    </th>
                    <th>
                        <?php
                        esc_html_e( 'Then', 'woo-product-feed-pro' );
                        echo wc_help_tip( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            esc_html__(
                                'Specify the action to be taken if the condition is met. This could be including, excluding, or modifying a product attribute.',
                                'woo-product-feed-pro'
                            )
                        );
                        ?>
                    </th>
                    <th>
                        <?php
                        esc_html_e( 'IS', 'woo-product-feed-pro' );
                        echo wc_help_tip( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            esc_html__(
                                'Define the result or value to be applied when the condition is met. This complements the action specified in the THEN field.',
                                'woo-product-feed-pro'
                            )
                        );
                        ?>
                    </th>
                </tr>
            </thead>
    
            <tbody class="woo-product-feed-pro-body">
            <?php
            // FILTERS SECTION
            if ( isset( $feed_filters ) && is_array( $feed_filters ) ) {
                foreach ( $feed_filters as $rule_key => $filter_data ) {
                    // Use the template method to generate the filter row HTML
                    echo $filters_instance->get_filter_template( $rule_key, $filter_data ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
            }

            // RULES SECTION
            if ( isset( $feed_rules ) && is_array( $feed_rules ) ) {
                foreach ( $feed_rules as $rule2_key => $rule_data ) {
                    // Use the template method to generate the rule row HTML
                    echo $rules_instance->get_rule_template( $rule2_key, $rule_data ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
            }
            ?>
            </tbody>
            <tbody>
            <tr class="rules-buttons">
                <td colspan="8">
                    <div class="adt-edit-feed-form-buttons adt-tw-flex adt-tw-gap-2 adt-tw-items-center">
                        <input type="hidden" id="channel_hash" name="channel_hash" value="<?php echo esc_attr( $channel_hash ?? '' ); ?>">
                        <?php if ( $edit_feed ) : ?>
                            <input type="hidden" name="project_hash" value="<?php echo esc_attr( $project_hash ); ?>">
                            <input type="hidden" name="woosea_page" value="filters_rules">
                            <button type="button" class="adt-button adt-button-sm delete-row" >- <?php esc_attr_e( 'Delete', 'woo-product-feed-pro' ); ?></button>
                            <button type="button" class="adt-button adt-button-sm add-filter">+ <?php esc_attr_e( 'Add filter', 'woo-product-feed-pro' ); ?></button>
                            <button type="button" class="adt-button adt-button-sm add-rule">+ <?php esc_attr_e( 'Add rule', 'woo-product-feed-pro' ); ?></button>
                            <button type="submit" id="savebutton" class="adt-button adt-button-sm adt-button-primary">
                                <?php esc_attr_e( 'Save Changes', 'woo-product-feed-pro' ); ?>
                            </button>
                        <?php else : ?>
                            <input type="hidden" name="project_hash" value="<?php echo esc_attr( $project_hash ); ?>">
                            <button type="button" class="adt-button adt-button-sm delete-row" >- <?php esc_attr_e( 'Delete', 'woo-product-feed-pro' ); ?></button>
                            <button type="button" class="adt-button adt-button-sm add-filter">+ <?php esc_attr_e( 'Add filter', 'woo-product-feed-pro' ); ?></button>
                            <button type="button" class="adt-button adt-button-sm add-rule">+ <?php esc_attr_e( 'Add rule', 'woo-product-feed-pro' ); ?></button>
                            <button type="submit" id="savebutton" class="adt-button adt-button-sm adt-button-primary">
                                <?php esc_attr_e( 'Save & Continue', 'woo-product-feed-pro' ); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
