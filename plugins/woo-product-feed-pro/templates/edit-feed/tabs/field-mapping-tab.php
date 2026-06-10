<?php
// phpcs:disable
use AdTribes\PFP\Helpers\Helper;
use AdTribes\PFP\Factories\Product_Feed;
use AdTribes\PFP\Factories\Admin_Notice;
use AdTribes\PFP\Classes\Product_Feed_Attributes;
use AdTribes\PFP\Helpers\Product_Feed_Helper;

/**
 * Create product attribute object
 */
$product_feed_attributes = new Product_Feed_Attributes();
$attribute_dropdown      = $product_feed_attributes->get_attributes();

$feed         = null;
$feed_id      = isset( $_GET['id'] ) ? sanitize_text_field( $_GET['id'] ) : '';
$edit_feed    = false;
if ( $feed_id ) {
    $feed = Product_Feed_Helper::get_product_feed( sanitize_text_field( $feed_id ) );
    if ( $feed ) {
        $feed_attributes = $feed->attributes;
        $channel_data    = $feed->channel;

        $project_hash = $feed->legacy_project_hash;
        $channel_hash = $feed->channel_hash;

        $edit_feed = true;
    }
} else {
    /**
     * The condition below is when the user is creating a new project.
     *
     * The user is redirected to the field mapping page after the general settings page.
     * Those settings are stored in the temporary option.
     * This is a legacy code that needs to be refactored.
     * For now, we will just add the necessary code to make it work.
     */
    $feed            = get_option( ADT_OPTION_TEMP_PRODUCT_FEED, array() );
    $channel_hash    = $feed['channel_hash'] ?? '';
    $project_hash    = $feed['project_hash'] ?? '';
    $channel_data    = '' !== $channel_hash ? Product_Feed_Helper::get_channel_from_legacy_channel_hash( $channel_hash ) : array();

    $feed_attributes = array();
    if ( !empty( $feed['attributes'] ) && is_array( $feed['attributes'] ) ) {
        $feed_attributes = $feed['attributes'];
    }
}

/**
 * Determine next step in configuration flow
 */
$step = isset( $channel_data['taxonomy'] ) && 'none' !== $channel_data['taxonomy'] ? 1 : 4;

/**
 * Action hook to add content before the product feed manage page.
 *
 * @param int                      $step         Step number.
 * @param string                   $project_hash Project hash.
 * @param array|Product_Feed|null  $feed         Product_Feed object or array of project data.
 */
do_action( 'adt_before_product_feed_manage_page', 7, $project_hash, $feed );

/**
 * Get main currency
 */
$currency = apply_filters( 'adt_product_feed_currency', get_woocommerce_currency() );

/**
 * Create channel attribute object
 */
$channel_attributes  = array();
$channel_data_fields = $channel_data['fields'] ?? '';
$channel_class_file  = ADT_PFP_CHANNEL_CLASS_ROOT_PATH . 'class-' . $channel_data_fields . '.php';
if (file_exists($channel_class_file)) {
    require $channel_class_file;
    $obj        = 'WooSEA_' . $channel_data_fields;
    $fields_obj = new $obj();
    $channel_attributes = $fields_obj->get_channel_attributes();
}
?>
<div id="dialog" title="Basic dialog">
    <p>
    <div id="dialogText"></div>
    </p>
</div>

<div class="woo-product-feed-pro-form-style-2">
    <?php
    // Display info message notice.
    $admin_notice = new Admin_Notice(
        sprintf(
            // translators: %s = link to learn static values.
            __(
                '<p>For the selected channel the attributes shown below are mandatory, please map them to your product attributes. 
                We\'ve already pre-filled a lot of mappings so all you have to do is check those and map the ones that are left blank or add new ones by hitting the \'Add field mapping\' button.</p>
                <p><strong><i><a href="%s" target="_blank">Learn how to use static values</a></i></strong></p>',
                'woo-product-feed-pro'
            ),
            esc_url( Helper::get_utm_url( '/how-to-use-static-values-and-create-fake-content-for-your-product-feed', 'pfp', 'fieldmappingnotice', 'learnstaticvalues' ) )
        ),
        'info',
        false,
        true
    );
    $admin_notice->run();
    ?>

    <form class="adt-edit-feed-form" id="field_mapping" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <?php wp_nonce_field( 'woosea_ajax_nonce' ); ?>
        <input type="hidden" name="action" value="edit_feed_form_process" />
        <input type="hidden" name="active_tab" value="field_mapping" />
        <input type="hidden" name="feed_id" value="<?php echo $feed->id ?? ''; ?>" />
        <table class="woo-product-feed-pro-table" id="woosea-fieldmapping-table" border="1">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo $channel_data['name'] ?? ''; ?> attributes</th>
                    <th><?php esc_html_e( 'Prefix', 'woo-product-feed-pro' ); ?></th>
                    <th><?php esc_html_e( 'Value', 'woo-product-feed-pro' ); ?></th>
                    <th><?php esc_html_e( 'Suffix', 'woo-product-feed-pro' ); ?></th>
                </tr>
            </thead>

            <tbody class="woo-product-feed-pro-body">
                <?php
                if ( ! empty( $channel_attributes ) ) {
                    if ( ! isset( $feed_attributes ) || empty( $feed_attributes ) ) {
                        $c = 0;
                        foreach ( $channel_attributes as $row_key => $row_value ) {
                            foreach ( $row_value as $row_k => $row_v ) {
                                if ( $row_v['format'] == 'required' ) {
                                    // Prepare selected values
                                    $suggested_attribute = array_key_exists( 'woo_suggest', $row_v ) ? $row_v['woo_suggest'] : '';
                                    $value        = '';
                                    
                                    // If static value then extract the value from the static_value key. eg. static_value:price
                                    if ( strpos( $suggested_attribute, 'static_value:' ) !== false ) {
                                        $value        = str_replace( 'static_value:', '', $suggested_attribute );
                                        $suggested_attribute = 'static_value';
                                    } elseif ( strpos( $suggested_attribute, 'page:' ) !== false ) {
                                        $value        = str_replace( 'page:', '', $suggested_attribute );
                                        $suggested_attribute = 'page_url';
                                    } elseif ( strpos( $suggested_attribute, 'post:' ) !== false ) {
                                        $value        = str_replace( 'post:', '', $suggested_attribute );
                                        $suggested_attribute = 'post_url';
                                    }

                                    $prefix = '';
                                    $suffix = '';

                                    // Replcate the placeholders for the prefix.
                                    if ( isset( $row_v['prefix'] ) ) {
                                        $prefix_replace = array(
                                            '{{CURRENCY}}' => $currency,
                                        );

                                        /**
                                         * Replace the placeholders for the prefix.
                                         *
                                         * @since 13.4.9
                                         *
                                         * @param array $prefix_replace The array of placeholders to replace.
                                         * @param string $prefix The prefix to replace the placeholders for.
                                         * @param array|Product_Feed|null $feed The feed data.
                                         * @return array The array of placeholders to replace.
                                         */
                                        $prefix_replace = apply_filters( 'adt_product_feed_field_mapping_prefix_replace', $prefix_replace, $row_v['prefix'], $feed );
                                        $prefix = str_replace( array_keys( $prefix_replace ), array_values( $prefix_replace ), $row_v['prefix'] );
                                    }

                                    // Replcate the placeholders for the suffix.
                                    if ( isset( $row_v['suffix'] ) ) {
                                        $suffix_replace = array(
                                            '{{CURRENCY}}' => $currency,
                                        );

                                        /**
                                         * Replace the placeholders for the suffix.
                                         *
                                         * @since 13.4.9
                                         *
                                         * @param array $suffix_replace The array of placeholders to replace.
                                         * @param string $suffix The suffix to replace the placeholders for.
                                         * @param array|Product_Feed|null $feed The feed data.
                                         * @return array The array of placeholders to replace.
                                         */
                                        $suffix_replace = apply_filters( 'adt_product_feed_field_mapping_suffix_replace', $suffix_replace, $row_v['suffix'], $feed );
                                        $suffix = str_replace( array_keys( $suffix_replace ), array_values( $suffix_replace ), $row_v['suffix'] );
                                    }

                                    // Use field mapping row template
                                    Helper::locate_admin_template(
                                        'edit-feed/partials/field-mapping-row.php',
                                        true,
                                        false,
                                        array(
                                            'row_index'          => $c,
                                            'is_own_mapping'     => false,
                                            'field_options'      => $channel_attributes,
                                            'attribute_dropdown' => $attribute_dropdown,
                                            'selected_values'    => array(
                                                'attribute' => $row_v['feed_name'] ?? '',
                                                'prefix'    => $prefix ?? '',
                                                'mapfrom'   => $suggested_attribute ?? '',
                                                'suffix'    => $suffix ?? '',
                                                'value'     => $value ?? '',
                                            ),
                                        )
                                    );

                                    ++$c;
                                }
                            }
                        }
                    } else {
                        foreach ( $feed_attributes as $attribute_key => $attribute_array ) {
                            $prefix = $attribute_array['prefix'] ?? '';
                            $suffix = $attribute_array['suffix'] ?? '';
                            $selected_attribute = $attribute_array['mapfrom'] ?? '';
                            $value = '';
                            
                            // Handle special attribute types
                            if ( array_key_exists( 'static_value', $attribute_array ) ) {
                                $selected_attribute = 'static_value';
                                $value = $attribute_array['mapfrom'];
                            } elseif ( $attribute_array['mapfrom'] == 'page_url' ) {
                                $value = $attribute_array['value'];
                            } elseif ( $attribute_array['mapfrom'] == 'post_url' ) {
                                $value = $attribute_array['value'];
                            }

                            // Determine if this is a custom field or regular field
                            $is_custom_field = true;
                            foreach ( $channel_attributes as $group ) {
                                foreach ( $group as $attr ) {
                                    if ( isset( $attr['feed_name'] ) && $attr['feed_name'] === $attribute_array['attribute'] ) {
                                        $is_custom_field = false;
                                        break 2;
                                    }
                                }
                            }

                            // Use field mapping row template
                            Helper::locate_admin_template(
                                'edit-feed/partials/field-mapping-row.php',
                                true,
                                false,
                                array(
                                    'row_index'          => $attribute_key,
                                    'is_own_mapping'     => $is_custom_field,
                                    'field_options'      => $channel_attributes,
                                    'attribute_dropdown' => $attribute_dropdown,
                                    'selected_values'    => array(
                                        'attribute'    => $attribute_array['attribute'] ?? '',
                                        'prefix'       => $prefix,
                                        'mapfrom'      => $selected_attribute,
                                        'suffix'       => $suffix,
                                        'value'        => $value ?? '',
                                    ),
                                )
                            );
                        }
                    }
                } else {
                ?>
                    <tr>
                        <td colspan='6' style="text-align: center;">
                            <?php esc_html_e( 'You haven\'t selected a channel for this feed yet.', 'woo-product-feed-pro' ); ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="6">
                        <div class="adt-edit-feed-form-buttons adt-tw-flex adt-tw-gap-2 adt-tw-items-center">
                            <input type="hidden" id="channel_hash" name="channel_hash" value="<?php echo esc_attr( $channel_hash ); ?>">
                            <?php if ( $edit_feed ) : ?>
                                <input type="hidden" name="project_hash" value="<?php echo esc_attr( $project_hash ); ?>">
                                <input type="hidden" name="addrow" id="addrow" value="1">
                                <button type="button" class="adt-button adt-button-sm delete-field-mapping">- <?php esc_attr_e( 'Delete', 'woo-product-feed-pro' ); ?></button>
                                <button type="button" class="adt-button adt-button-sm add-field-mapping">+ <?php esc_attr_e( 'Add field mapping', 'woo-product-feed-pro' ); ?></button>
                                <button type="button" class="adt-button adt-button-sm add-own-mapping">+ <?php esc_attr_e( 'Add custom field', 'woo-product-feed-pro' ); ?></button>
                                <button type="submit" class="adt-button adt-button-sm adt-button-primary" id="savebutton">
                                    <?php esc_attr_e( 'Save Changes', 'woo-product-feed-pro' ); ?>
                                </button>
                            <?php else : ?>
                                <input type="hidden" name="project_hash" value="<?php echo esc_attr( $project_hash ); ?>">
                                <input type="hidden" name="addrow" id="addrow" value="1">
                                <button type="button" class="adt-button adt-button-sm delete-field-mapping">- <?php esc_attr_e( 'Delete', 'woo-product-feed-pro' ); ?></button>
                                <button type="button" class="adt-button adt-button-sm add-field-mapping">+ <?php esc_attr_e( 'Add field mapping', 'woo-product-feed-pro' ); ?></button>
                                <button type="button" class="adt-button adt-button-sm add-own-mapping">+<?php esc_attr_e( 'Add custom field', 'woo-product-feed-pro' ); ?></button>
                                <?php
                                // Check if channel has taxonomy
                                $has_taxonomy = isset($channel_data['taxonomy']) && $channel_data['taxonomy'] !== 'none';
                                $next_step = $has_taxonomy ? __('Category Mapping', 'woo-product-feed-pro') : __('Filters & Rules', 'woo-product-feed-pro');
                                ?>
                                <button type="submit" class="adt-button adt-button-sm adt-button-primary" id="savebutton">
                                    <?php esc_attr_e( 'Save & Continue', 'woo-product-feed-pro' ); ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>


    <!-- Template for regular field mapping rows -->
    <template id="adt-field-mapping-row-template">
        <?php
        Helper::locate_admin_template(
            'edit-feed/partials/field-mapping-row.php',
            true,
            false,
            array(
                'row_index'          => '{{ROW_INDEX}}',
                'is_own_mapping'     => false,
                'field_options'      => $channel_attributes,
                'attribute_dropdown' => $attribute_dropdown,
                'selected_values'    => array(),
            )
        );
        ?>
    </template>

    <!-- Template for custom field mapping rows -->
    <template id="adt-custom-field-mapping-row-template">
        <?php
        Helper::locate_admin_template(
            'edit-feed/partials/field-mapping-row.php',
            true,
            false,
            array(
                'row_index'          => '{{ROW_INDEX}}',
                'is_own_mapping'     => true,
                'field_options'      => array(),
                'attribute_dropdown' => $attribute_dropdown,
                'selected_values'    => array(),
            )
        );
        ?>
    </template>
</div>
