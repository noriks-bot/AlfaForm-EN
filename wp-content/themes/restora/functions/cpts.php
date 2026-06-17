<?php

function noriks_register_landigs_post_type() {
    $labels = array(
        'name'                  => _x('Landigs', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Landing', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Landigs', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Landing', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Landing', 'textdomain'),
        'new_item'              => __('New Landing', 'textdomain'),
        'edit_item'             => __('Edit Landing', 'textdomain'),
        'view_item'             => __('View Landing', 'textdomain'),
        'all_items'             => __('All Landigs', 'textdomain'),
        'search_items'          => __('Išči Landigs', 'textdomain'),
        'not_found'             => __('No landigs found.', 'textdomain'),
        'not_found_in_trash'    => __('No landigs found in Trash.', 'textdomain'),
        'featured_image'        => _x('Landing Image', 'Overrides the “Featured Image” phrase.', 'textdomain'),
        'set_featured_image'    => _x('Set landing image', 'Overrides the “Set featured image” phrase.', 'textdomain'),
        'remove_featured_image' => _x('Remove landing image', 'Overrides the “Remove featured image” phrase.', 'textdomain'),
        'use_featured_image'    => _x('Use as landing image', 'Overrides the “Use as featured image” phrase.', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_in_menu'       => true,
        'show_ui'            => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'landigs', 'with_front' => false),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 23,
        'menu_icon'          => 'dashicons-welcome-widgets-menus',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('landigs', $args);
}

function noriks_register_landigs_meta() {
    $meta_fields = array(
        '_landigs_target_product_id'  => 'integer',
        '_landigs_target_product_url' => 'string',
        '_landigs_primary_label'      => 'string',
        '_landigs_primary_options'    => 'string',
        '_landigs_secondary_label'    => 'string',
        '_landigs_secondary_options'  => 'string',
        '_landigs_hide_secondary'     => 'string',
        '_landigs_offer_options'      => 'string',
    );

    foreach ($meta_fields as $key => $type) {
        register_post_meta('landigs', $key, array(
            'single'            => true,
            'type'              => $type,
            'show_in_rest'      => true,
            'sanitize_callback' => $type === 'integer' ? 'absint' : 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            },
        ));
    }
}

function noriks_add_landigs_meta_box() {
    add_meta_box(
        'noriks-landigs-settings',
        __('Landing Settings', 'textdomain'),
        'noriks_render_landigs_meta_box',
        'landigs',
        'normal',
        'high'
    );
}

function noriks_render_landigs_meta_box($post) {
    wp_nonce_field('noriks_landigs_meta_box', 'noriks_landigs_meta_box_nonce');

    $fields = array(
        '_landigs_target_product_id'  => '',
        '_landigs_target_product_url' => '',
        '_landigs_primary_label'      => 'Barva',
        '_landigs_primary_options'    => "Črna|#000000\nBela|#f5f5f5\nSiva|#9ca3af\nTemno modra|#243647\nRjava|#7c5a3c\nOlivna|#607d33",
        '_landigs_secondary_label'    => 'Velikost',
        '_landigs_secondary_options'  => "S\nM\nL\nXL\nXXL\n3XL\n4XL",
        '_landigs_hide_secondary'     => '0',
        '_landigs_offer_options'      => "1|1 majica|odličen začetni paket 17.96€|PRIHRANITE 49%\n2|2 majici|najboljše razmerje med ceno in količino 44.28€|PRIHRANITE 59%\n3|3 majice|največji prihranek na kos 69.26€|PRIHRANITE 62%\n5|5 majic|največji paket za maksimalni prihranek 135.38€|PRIHRANITE 73%",
    );

    echo '<table class="form-table"><tbody>';

    foreach ($fields as $key => $default) {
        $value = get_post_meta($post->ID, $key, true);
        if ($value === '') {
            $value = $default;
        }

        $label = ucwords(trim(str_replace(array('_landigs_', '_'), array('', ' '), $key)));
        echo '<tr>';
        echo '<th scope="row"><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th>';
        echo '<td>';

        if ($key === '_landigs_hide_secondary') {
            echo '<label><input type="checkbox" name="' . esc_attr($key) . '" value="1" ' . checked($value, '1', false) . '> ' . esc_html__('Hide secondary options', 'textdomain') . '</label>';
        } elseif ($key === '_landigs_target_product_id') {
            echo '<input type="number" class="regular-text" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
        } elseif (strpos($key, '_options') !== false) {
            echo '<textarea class="large-text code" rows="6" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '">' . esc_textarea($value) . '</textarea>';
        } else {
            echo '<input type="text" class="large-text" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
        }

        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
}

function noriks_save_landigs_meta($post_id) {
    if (!isset($_POST['noriks_landigs_meta_box_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['noriks_landigs_meta_box_nonce'])), 'noriks_landigs_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $keys = array(
        '_landigs_target_product_id',
        '_landigs_target_product_url',
        '_landigs_primary_label',
        '_landigs_primary_options',
        '_landigs_secondary_label',
        '_landigs_secondary_options',
        '_landigs_hide_secondary',
        '_landigs_offer_options',
    );

    foreach ($keys as $key) {
        if ($key === '_landigs_hide_secondary') {
            update_post_meta($post_id, $key, isset($_POST[$key]) ? '1' : '0');
            continue;
        }

        if (!isset($_POST[$key])) {
            continue;
        }

        $raw_value = wp_unslash($_POST[$key]);
        $value = $key === '_landigs_target_product_id' ? absint($raw_value) : sanitize_textarea_field($raw_value);
        update_post_meta($post_id, $key, $value);
    }
}

function noriks_ensure_default_step_landing() {
    if (!post_type_exists('landigs')) {
        return;
    }

    $existing = get_page_by_path('step-landing', OBJECT, 'landigs');
    if ($existing) {
        return;
    }

    $post_id = wp_insert_post(array(
        'post_type'   => 'landigs',
        'post_status' => 'publish',
        'post_title'  => 'Step Landing',
        'post_name'   => 'step-landing',
    ));

    if (!$post_id || is_wp_error($post_id)) {
        return;
    }

    update_post_meta($post_id, '_landigs_target_product_id', 3421);
    update_post_meta($post_id, '_landigs_target_product_url', home_url('/si/product/noriks-majica/'));
    update_post_meta($post_id, '_landigs_primary_label', 'Barva');
    update_post_meta($post_id, '_landigs_primary_options', "Črna|#000000\nBela|#f5f5f5\nSiva|#9ca3af\nTemno modra|#243647\nRjava|#7c5a3c\nOlivna|#607d33");
    update_post_meta($post_id, '_landigs_secondary_label', 'Velikost');
    update_post_meta($post_id, '_landigs_secondary_options', "S\nM\nL\nXL\nXXL\n3XL\n4XL");
    update_post_meta($post_id, '_landigs_hide_secondary', '0');
    update_post_meta($post_id, '_landigs_offer_options', "1|1 majica|odličen začetni paket 17.96€|PRIHRANITE 49%\n2|2 majici|najboljše razmerje med ceno in količino 44.28€|PRIHRANITE 59%\n3|3 majice|največji prihranek na kos 69.26€|PRIHRANITE 62%\n5|5 majic|največji paket za maksimalni prihranek 135.38€|PRIHRANITE 73%");
    flush_rewrite_rules(false);
}

function noriks_register_collections_taxonomy() {
    $labels = array(
        'name'              => _x('Collections', 'taxonomy general name', 'textdomain'),
        'singular_name'     => _x('Collection', 'taxonomy singular name', 'textdomain'),
        'search_items'      => __('Išči kolekcije', 'textdomain'),
        'all_items'         => __('All Collections', 'textdomain'),
        'edit_item'         => __('Edit Collection', 'textdomain'),
        'update_item'       => __('Update Collection', 'textdomain'),
        'add_new_item'      => __('Add New Collection', 'textdomain'),
        'new_item_name'     => __('New Collection Name', 'textdomain'),
        'menu_name'         => __('Collections', 'textdomain'),
    );

    register_taxonomy('collections', array('product'), array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => false,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array(
            'slug'       => 'collections',
            'with_front' => false,
        ),
    ));
}

function noriks_flush_rewrite_once() {
    if (get_option('noriks_collections_rewrite_flushed') === '1') {
        return;
    }

    flush_rewrite_rules(false);
    update_option('noriks_collections_rewrite_flushed', '1', false);
}

function noriks_ensure_default_collection_akcija() {
    if (!taxonomy_exists('collections')) {
        return;
    }

    $term = get_term_by('slug', 'akcija', 'collections');
    if ($term && !is_wp_error($term)) {
        return;
    }

    $created = wp_insert_term('Akcija', 'collections', array(
        'slug' => 'akcija',
    ));

    if (is_wp_error($created) || empty($created['term_id'])) {
        return;
    }

    $term_id = (int) $created['term_id'];
    update_term_meta($term_id, 'noriks_collection_show_promo', '0');
    update_term_meta($term_id, 'noriks_collection_show_intro_text', '0');
    update_term_meta($term_id, 'noriks_collection_show_bottom_intro_text', '0');
    update_term_meta($term_id, 'noriks_collection_show_bottom_banner', '0');
    update_term_meta($term_id, 'noriks_collection_show_bottom_banner_button', '0');
    update_term_meta($term_id, 'noriks_collection_show_bottom_products', '0');
    update_term_meta($term_id, 'noriks_collection_promo_title', '');
    update_term_meta($term_id, 'noriks_collection_promo_subtitle', '');
    update_term_meta($term_id, 'noriks_collection_intro_text', '');
    update_term_meta($term_id, 'noriks_collection_bottom_intro_text', '');
    update_term_meta($term_id, 'noriks_collection_bottom_banner_title', '');
    update_term_meta($term_id, 'noriks_collection_bottom_banner_subtitle', '');
    update_term_meta($term_id, 'noriks_collection_bottom_banner_button_text', '');
    update_term_meta($term_id, 'noriks_collection_bottom_banner_button_url', '');
    update_term_meta($term_id, 'noriks_collection_bottom_banner_image_id', 0);
    update_term_meta($term_id, 'noriks_collection_bottom_banner_bg_color', '#f0eaea');
    update_term_meta($term_id, 'noriks_collection_product_order', '');
    update_term_meta($term_id, 'noriks_collection_bottom_product_ids', '');
}

function noriks_collection_order_ids_from_string($value) {
    $parts = preg_split('/[\s,]+/', (string) $value);
    $parts = array_filter(array_map('absint', $parts));
    return array_values(array_unique($parts));
}

function noriks_collection_gallery_image_map_from_string($value) {
    $map = array();
    $lines = preg_split('/[\r\n,]+/', (string) $value);

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, ':') === false) {
            continue;
        }

        list($product_id, $image_id) = array_map('absint', explode(':', $line, 2));
        if ($product_id > 0 && $image_id > 0) {
            $map[$product_id] = $image_id;
        }
    }

    return $map;
}

function noriks_get_collection_product_choices($term_id = 0) {
    $query_args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'fields'         => 'ids',
    );

    if ($term_id > 0) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'collections',
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        );
    }

    $products = get_posts($query_args);

    $choices = array();

    foreach ($products as $product_id) {
        $title = get_the_title($product_id);
        $sku = get_post_meta($product_id, '_sku', true);

        $choices[] = array(
            'id'    => (int) $product_id,
            'title' => $title ? $title : sprintf(__('Product #%d', 'textdomain'), $product_id),
            'sku'   => $sku ? $sku : '',
        );
    }

    return $choices;
}

function noriks_render_collection_product_order_ui($selected_raw = '', $term_id = 0) {
    $selected_ids = noriks_collection_order_ids_from_string($selected_raw);
    if ($term_id <= 0) {
        echo '<p class="description">' . esc_html__('Save the collection first, then you can drag products that already belong to this collection.', 'textdomain') . '</p>';
        echo '<input type="hidden" class="noriks-product-order-value" name="noriks_collection_product_order" value="">';
        return;
    }

    $choices = noriks_get_collection_product_choices($term_id);
    $choice_map = array();

    foreach ($choices as $choice) {
        $choice_map[$choice['id']] = $choice;
    }

    echo '<div class="noriks-product-order-ui">';
    echo '<input type="hidden" class="noriks-product-order-value" name="noriks_collection_product_order" value="' . esc_attr(implode("\n", $selected_ids)) . '">';
    echo '<div class="noriks-product-order-columns">';

    echo '<div class="noriks-product-order-column noriks-product-order-column--available">';
    echo '<h4>' . esc_html__('All Products', 'textdomain') . '</h4>';
    echo '<input type="search" class="regular-text noriks-product-order-search" placeholder="' . esc_attr__('Išči po nazivu ali SKU', 'textdomain') . '">';
    echo '<ul class="noriks-product-order-list noriks-product-order-list--available">';
    foreach ($choices as $choice) {
        $is_selected = in_array($choice['id'], $selected_ids, true);
        echo '<li class="noriks-product-order-item' . ($is_selected ? ' is-selected' : '') . '" data-id="' . esc_attr($choice['id']) . '" data-title="' . esc_attr(strtolower($choice['title'])) . '" data-sku="' . esc_attr(strtolower($choice['sku'])) . '">';
        echo '<div class="noriks-product-order-item__meta">';
        echo '<strong>' . esc_html($choice['title']) . '</strong>';
        echo '<span>' . esc_html($choice['sku'] ? $choice['sku'] : 'No SKU') . '</span>';
        echo '</div>';
        echo '<button type="button" class="button button-small noriks-product-order-add">' . esc_html__('Add', 'textdomain') . '</button>';
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';

    echo '<div class="noriks-product-order-column noriks-product-order-column--selected">';
    echo '<h4>' . esc_html__('Selected Order', 'textdomain') . '</h4>';
    echo '<p class="description">' . esc_html__('Drag to reorder the products shown in this collection.', 'textdomain') . '</p>';
    echo '<ul class="noriks-product-order-list noriks-product-order-list--selected">';
    foreach ($selected_ids as $selected_id) {
        if (empty($choice_map[$selected_id])) {
            continue;
        }
        $choice = $choice_map[$selected_id];
        echo '<li class="noriks-product-order-item is-active" data-id="' . esc_attr($choice['id']) . '">';
        echo '<span class="noriks-product-order-handle">⋮⋮</span>';
        echo '<div class="noriks-product-order-item__meta">';
        echo '<strong>' . esc_html($choice['title']) . '</strong>';
        echo '<span>' . esc_html($choice['sku'] ? $choice['sku'] : 'No SKU') . '</span>';
        echo '</div>';
        echo '<button type="button" class="button button-small noriks-product-order-remove">' . esc_html__('Remove', 'textdomain') . '</button>';
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';

    echo '</div>';
    echo '</div>';
}

function noriks_render_collection_gallery_image_ui($selected_raw = '', $term_id = 0) {
    if ($term_id <= 0) {
        echo '<p class="description">' . esc_html__('Save the collection first, then you can choose exactly which gallery image each collection product should use in the cards.', 'textdomain') . '</p>';
        return;
    }

    $selected_map = noriks_collection_gallery_image_map_from_string($selected_raw);
    $choices = noriks_get_collection_product_choices($term_id);

    echo '<div class="noriks-collection-gallery-image-ui">';
    echo '<ul class="noriks-collection-gallery-image-list">';
    foreach ($choices as $choice) {
        $product = wc_get_product($choice['id']);
        $gallery_ids = $product ? $product->get_gallery_image_ids() : array();
        $selected_image_id = isset($selected_map[$choice['id']]) ? (int) $selected_map[$choice['id']] : 0;
        $preview_image_id = $selected_image_id ? $selected_image_id : get_post_thumbnail_id($choice['id']);
        $preview_url = $preview_image_id ? wp_get_attachment_image_url($preview_image_id, 'thumbnail') : '';

        echo '<li class="noriks-collection-gallery-image-item">';
        echo '<div class="noriks-collection-gallery-image-item__head">';
        echo '<div class="noriks-collection-gallery-image-item__preview">';
        if ($preview_url) {
            echo '<img src="' . esc_url($preview_url) . '" alt="">';
        } else {
            echo '<span class="noriks-collection-gallery-image-item__placeholder">No image</span>';
        }
        echo '</div>';
        echo '<div class="noriks-collection-gallery-image-item__meta">';
        echo '<strong>' . esc_html($choice['title']) . '</strong> <em>' . esc_html($choice['sku'] ? $choice['sku'] : 'No SKU') . '</em>';
        echo '</div>';
        echo '</div>';

        if (!empty($gallery_ids)) {
            echo '<select class="noriks-collection-gallery-image-select" name="noriks_collection_gallery_image_map[' . esc_attr($choice['id']) . ']">';
            echo '<option value="">' . esc_html__('Use featured image', 'textdomain') . '</option>';
            foreach ($gallery_ids as $index => $gallery_id) {
                $thumb_url = wp_get_attachment_image_url($gallery_id, 'thumbnail');
                $label = sprintf(__('Gallery image %d', 'textdomain'), $index + 1);
                echo '<option value="' . esc_attr($gallery_id) . '" data-preview-url="' . esc_url($thumb_url ? $thumb_url : '') . '" ' . selected($selected_image_id, (int) $gallery_id, false) . '>' . esc_html($label) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<p class="description">' . esc_html__('This product has no gallery images.', 'textdomain') . '</p>';
        }
        echo '</li>';
    }
    echo '</ul>';
    echo '<p class="description">' . esc_html__('Choose any gallery image per product. This affects only this collection page.', 'textdomain') . '</p>';
    echo '</div>';
}

function noriks_add_collection_term_fields() {
    ?>
    <div class="form-field term-group">
        <label><input type="checkbox" name="noriks_collection_show_promo" value="1"> <?php esc_html_e('Show Black Banner', 'textdomain'); ?></label>
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-promo-title"><?php esc_html_e('Black Banner Title', 'textdomain'); ?></label>
        <input type="text" id="noriks-collection-promo-title" name="noriks_collection_promo_title" value="">
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-promo-subtitle"><?php esc_html_e('Black Banner Subtitle', 'textdomain'); ?></label>
        <input type="text" id="noriks-collection-promo-subtitle" name="noriks_collection_promo_subtitle" value="">
    </div>
    <div class="form-field term-group">
        <label><input type="checkbox" name="noriks_collection_show_intro_text" value="1"> <?php esc_html_e('Show Intro Text', 'textdomain'); ?></label>
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-intro-text"><?php esc_html_e('Intro Text', 'textdomain'); ?></label>
        <textarea id="noriks-collection-intro-text" name="noriks_collection_intro_text" rows="4"></textarea>
    </div>
    <div class="form-field term-group">
        <label><input type="checkbox" name="noriks_collection_show_bottom_banner" value="1"> <?php esc_html_e('Show Bottom Banner', 'textdomain'); ?></label>
    </div>
    <div class="form-field term-group">
        <label><input type="checkbox" name="noriks_collection_show_bottom_banner_button" value="1"> <?php esc_html_e('Show Bottom Banner Button', 'textdomain'); ?></label>
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-bottom-banner-title"><?php esc_html_e('Bottom Banner Title', 'textdomain'); ?></label>
        <input type="text" id="noriks-collection-bottom-banner-title" name="noriks_collection_bottom_banner_title" value="">
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-bottom-banner-subtitle"><?php esc_html_e('Bottom Banner Subtitle', 'textdomain'); ?></label>
        <input type="text" id="noriks-collection-bottom-banner-subtitle" name="noriks_collection_bottom_banner_subtitle" value="">
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-bottom-banner-button-text"><?php esc_html_e('Bottom Banner Button Text', 'textdomain'); ?></label>
        <input type="text" id="noriks-collection-bottom-banner-button-text" name="noriks_collection_bottom_banner_button_text" value="">
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-bottom-banner-button-url"><?php esc_html_e('Bottom Banner Button URL', 'textdomain'); ?></label>
        <input type="text" id="noriks-collection-bottom-banner-button-url" name="noriks_collection_bottom_banner_button_url" value="">
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-bottom-banner-bg-color"><?php esc_html_e('Barva ozadja spodnjega bannerja', 'textdomain'); ?></label>
        <input type="color" id="noriks-collection-bottom-banner-bg-color" name="noriks_collection_bottom_banner_bg_color" value="#f0eaea">
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-bottom-banner-image-id"><?php esc_html_e('Bottom Banner Image', 'textdomain'); ?></label>
        <input type="hidden" id="noriks-collection-bottom-banner-image-id" name="noriks_collection_bottom_banner_image_id" value="">
        <div class="noriks-collection-banner-preview" style="margin:10px 0;"></div>
        <button type="button" class="button noriks-collection-upload"><?php esc_html_e('Select Image', 'textdomain'); ?></button>
        <button type="button" class="button noriks-collection-remove"><?php esc_html_e('Remove Image', 'textdomain'); ?></button>
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-product-order"><?php esc_html_e('Manual Product Order', 'textdomain'); ?></label>
        <?php noriks_render_collection_product_order_ui('', 0); ?>
    </div>
    <div class="form-field term-group">
        <label><?php esc_html_e('Use Gallery Image In Collection Cards', 'textdomain'); ?></label>
        <?php noriks_render_collection_gallery_image_ui('', 0); ?>
    </div>
    <div class="form-field term-group">
        <label><input type="checkbox" name="noriks_collection_show_bottom_products" value="1"> <?php esc_html_e('Show Bottom Products', 'textdomain'); ?></label>
    </div>
    <div class="form-field term-group">
        <label><input type="checkbox" name="noriks_collection_show_bottom_intro_text" value="1"> <?php esc_html_e('Show Bottom Intro Text', 'textdomain'); ?></label>
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-bottom-intro-text"><?php esc_html_e('Bottom Intro Text', 'textdomain'); ?></label>
        <textarea id="noriks-collection-bottom-intro-text" name="noriks_collection_bottom_intro_text" rows="4"></textarea>
    </div>
    <div class="form-field term-group">
        <label for="noriks-collection-bottom-product-ids"><?php esc_html_e('Bottom Products', 'textdomain'); ?></label>
        <textarea id="noriks-collection-bottom-product-ids" name="noriks_collection_bottom_product_ids" rows="4" placeholder="5001, 5002, 5003, 5004, 5005, 5006, 5007, 5008"></textarea>
        <p class="description"><?php esc_html_e('Optional extra products shown at the very bottom of the collection. Enter up to 8 product IDs, separated by commas or new lines.', 'textdomain'); ?></p>
    </div>
    <?php
}

function noriks_edit_collection_term_fields($term) {
    $show_promo = get_term_meta($term->term_id, 'noriks_collection_show_promo', true);
    $show_intro_text = get_term_meta($term->term_id, 'noriks_collection_show_intro_text', true);
    $show_bottom_banner = get_term_meta($term->term_id, 'noriks_collection_show_bottom_banner', true);
    $show_bottom_banner_button = get_term_meta($term->term_id, 'noriks_collection_show_bottom_banner_button', true);
    $show_bottom_products = get_term_meta($term->term_id, 'noriks_collection_show_bottom_products', true);
    $show_bottom_intro_text = get_term_meta($term->term_id, 'noriks_collection_show_bottom_intro_text', true);
    $promo_title = get_term_meta($term->term_id, 'noriks_collection_promo_title', true);
    $promo_subtitle = get_term_meta($term->term_id, 'noriks_collection_promo_subtitle', true);
    $intro_text = get_term_meta($term->term_id, 'noriks_collection_intro_text', true);
    $bottom_intro_text = get_term_meta($term->term_id, 'noriks_collection_bottom_intro_text', true);
    $bottom_banner_title = get_term_meta($term->term_id, 'noriks_collection_bottom_banner_title', true);
    $bottom_banner_subtitle = get_term_meta($term->term_id, 'noriks_collection_bottom_banner_subtitle', true);
    $bottom_banner_button_text = get_term_meta($term->term_id, 'noriks_collection_bottom_banner_button_text', true);
    $bottom_banner_button_url = get_term_meta($term->term_id, 'noriks_collection_bottom_banner_button_url', true);
    $bottom_banner_image_id = get_term_meta($term->term_id, 'noriks_collection_bottom_banner_image_id', true);
    $bottom_banner_bg_color = get_term_meta($term->term_id, 'noriks_collection_bottom_banner_bg_color', true);
    $product_order   = get_term_meta($term->term_id, 'noriks_collection_product_order', true);
    $gallery_image_products = get_term_meta($term->term_id, 'noriks_collection_gallery_image_map', true);
    $bottom_products = get_term_meta($term->term_id, 'noriks_collection_bottom_product_ids', true);
    $bottom_image_url = $bottom_banner_image_id ? wp_get_attachment_image_url((int) $bottom_banner_image_id, 'medium') : '';
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><?php esc_html_e('Show Black Banner', 'textdomain'); ?></th>
        <td><label><input type="checkbox" name="noriks_collection_show_promo" value="1" <?php checked($show_promo, '1'); ?>> <?php esc_html_e('Enable section', 'textdomain'); ?></label></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-promo-title"><?php esc_html_e('Black Banner Title', 'textdomain'); ?></label></th>
        <td><input type="text" id="noriks-collection-promo-title" name="noriks_collection_promo_title" value="<?php echo esc_attr($promo_title); ?>" class="large-text"></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-promo-subtitle"><?php esc_html_e('Black Banner Subtitle', 'textdomain'); ?></label></th>
        <td><input type="text" id="noriks-collection-promo-subtitle" name="noriks_collection_promo_subtitle" value="<?php echo esc_attr($promo_subtitle); ?>" class="large-text"></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><?php esc_html_e('Show Intro Text', 'textdomain'); ?></th>
        <td><label><input type="checkbox" name="noriks_collection_show_intro_text" value="1" <?php checked($show_intro_text, '1'); ?>> <?php esc_html_e('Enable section', 'textdomain'); ?></label></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-intro-text"><?php esc_html_e('Intro Text', 'textdomain'); ?></label></th>
        <td><textarea id="noriks-collection-intro-text" name="noriks_collection_intro_text" rows="5" class="large-text"><?php echo esc_textarea($intro_text); ?></textarea></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><?php esc_html_e('Show Bottom Banner', 'textdomain'); ?></th>
        <td><label><input type="checkbox" name="noriks_collection_show_bottom_banner" value="1" <?php checked($show_bottom_banner, '1'); ?>> <?php esc_html_e('Enable section', 'textdomain'); ?></label></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><?php esc_html_e('Show Bottom Banner Button', 'textdomain'); ?></th>
        <td><label><input type="checkbox" name="noriks_collection_show_bottom_banner_button" value="1" <?php checked($show_bottom_banner_button, '1'); ?>> <?php esc_html_e('Enable button', 'textdomain'); ?></label></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-bottom-banner-title"><?php esc_html_e('Bottom Banner Title', 'textdomain'); ?></label></th>
        <td><input type="text" id="noriks-collection-bottom-banner-title" name="noriks_collection_bottom_banner_title" value="<?php echo esc_attr($bottom_banner_title); ?>" class="large-text"></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-bottom-banner-subtitle"><?php esc_html_e('Bottom Banner Subtitle', 'textdomain'); ?></label></th>
        <td><input type="text" id="noriks-collection-bottom-banner-subtitle" name="noriks_collection_bottom_banner_subtitle" value="<?php echo esc_attr($bottom_banner_subtitle); ?>" class="large-text"></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-bottom-banner-button-text"><?php esc_html_e('Bottom Banner Button Text', 'textdomain'); ?></label></th>
        <td><input type="text" id="noriks-collection-bottom-banner-button-text" name="noriks_collection_bottom_banner_button_text" value="<?php echo esc_attr($bottom_banner_button_text); ?>" class="large-text"></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-bottom-banner-button-url"><?php esc_html_e('Bottom Banner Button URL', 'textdomain'); ?></label></th>
        <td><input type="text" id="noriks-collection-bottom-banner-button-url" name="noriks_collection_bottom_banner_button_url" value="<?php echo esc_attr($bottom_banner_button_url); ?>" class="large-text"></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-bottom-banner-bg-color"><?php esc_html_e('Barva ozadja spodnjega bannerja', 'textdomain'); ?></label></th>
        <td><input type="color" id="noriks-collection-bottom-banner-bg-color" name="noriks_collection_bottom_banner_bg_color" value="<?php echo esc_attr($bottom_banner_bg_color ? $bottom_banner_bg_color : '#f0eaea'); ?>"></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-bottom-banner-image-id"><?php esc_html_e('Bottom Banner Image', 'textdomain'); ?></label></th>
        <td>
            <input type="hidden" id="noriks-collection-bottom-banner-image-id" name="noriks_collection_bottom_banner_image_id" value="<?php echo esc_attr($bottom_banner_image_id); ?>">
            <div class="noriks-collection-banner-preview" style="margin:10px 0;">
                <?php if ($bottom_image_url) : ?>
                    <img src="<?php echo esc_url($bottom_image_url); ?>" alt="" style="max-width:240px;height:auto;">
                <?php endif; ?>
            </div>
            <button type="button" class="button noriks-collection-upload"><?php esc_html_e('Select Image', 'textdomain'); ?></button>
            <button type="button" class="button noriks-collection-remove"><?php esc_html_e('Remove Image', 'textdomain'); ?></button>
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-product-order"><?php esc_html_e('Manual Product Order', 'textdomain'); ?></label></th>
        <td>
            <?php noriks_render_collection_product_order_ui($product_order, (int) $term->term_id); ?>
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><?php esc_html_e('Use Gallery Image In Collection Cards', 'textdomain'); ?></th>
        <td>
            <?php noriks_render_collection_gallery_image_ui($gallery_image_products, (int) $term->term_id); ?>
        </td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><?php esc_html_e('Show Bottom Products', 'textdomain'); ?></th>
        <td><label><input type="checkbox" name="noriks_collection_show_bottom_products" value="1" <?php checked($show_bottom_products, '1'); ?>> <?php esc_html_e('Enable section', 'textdomain'); ?></label></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><?php esc_html_e('Show Bottom Intro Text', 'textdomain'); ?></th>
        <td><label><input type="checkbox" name="noriks_collection_show_bottom_intro_text" value="1" <?php checked($show_bottom_intro_text, '1'); ?>> <?php esc_html_e('Enable section', 'textdomain'); ?></label></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-bottom-intro-text"><?php esc_html_e('Bottom Intro Text', 'textdomain'); ?></label></th>
        <td><textarea id="noriks-collection-bottom-intro-text" name="noriks_collection_bottom_intro_text" rows="5" class="large-text"><?php echo esc_textarea($bottom_intro_text); ?></textarea></td>
    </tr>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="noriks-collection-bottom-product-ids"><?php esc_html_e('Bottom Products', 'textdomain'); ?></label></th>
        <td>
            <textarea id="noriks-collection-bottom-product-ids" name="noriks_collection_bottom_product_ids" rows="5" class="large-text"><?php echo esc_textarea($bottom_products); ?></textarea>
            <p class="description"><?php esc_html_e('Optional extra products shown at the very bottom of the collection. Enter up to 8 product IDs, separated by commas or new lines.', 'textdomain'); ?></p>
        </td>
    </tr>
    <?php
}

function noriks_save_collection_term_meta($term_id) {
    update_term_meta($term_id, 'noriks_collection_show_promo', isset($_POST['noriks_collection_show_promo']) ? '1' : '0');
    update_term_meta($term_id, 'noriks_collection_show_intro_text', isset($_POST['noriks_collection_show_intro_text']) ? '1' : '0');
    update_term_meta($term_id, 'noriks_collection_show_bottom_banner', isset($_POST['noriks_collection_show_bottom_banner']) ? '1' : '0');
    update_term_meta($term_id, 'noriks_collection_show_bottom_banner_button', isset($_POST['noriks_collection_show_bottom_banner_button']) ? '1' : '0');
    update_term_meta($term_id, 'noriks_collection_show_bottom_products', isset($_POST['noriks_collection_show_bottom_products']) ? '1' : '0');
    update_term_meta($term_id, 'noriks_collection_show_bottom_intro_text', isset($_POST['noriks_collection_show_bottom_intro_text']) ? '1' : '0');
    $promo_title = isset($_POST['noriks_collection_promo_title']) ? sanitize_text_field(wp_unslash($_POST['noriks_collection_promo_title'])) : '';
    $promo_subtitle = isset($_POST['noriks_collection_promo_subtitle']) ? sanitize_text_field(wp_unslash($_POST['noriks_collection_promo_subtitle'])) : '';
    $intro_text = isset($_POST['noriks_collection_intro_text']) ? sanitize_textarea_field(wp_unslash($_POST['noriks_collection_intro_text'])) : '';
    $bottom_intro_text = isset($_POST['noriks_collection_bottom_intro_text']) ? sanitize_textarea_field(wp_unslash($_POST['noriks_collection_bottom_intro_text'])) : '';
    $bottom_banner_title = isset($_POST['noriks_collection_bottom_banner_title']) ? sanitize_text_field(wp_unslash($_POST['noriks_collection_bottom_banner_title'])) : '';
    $bottom_banner_subtitle = isset($_POST['noriks_collection_bottom_banner_subtitle']) ? sanitize_text_field(wp_unslash($_POST['noriks_collection_bottom_banner_subtitle'])) : '';
    $bottom_banner_button_text = isset($_POST['noriks_collection_bottom_banner_button_text']) ? sanitize_text_field(wp_unslash($_POST['noriks_collection_bottom_banner_button_text'])) : '';
    $bottom_banner_button_url = isset($_POST['noriks_collection_bottom_banner_button_url']) ? esc_url_raw(wp_unslash($_POST['noriks_collection_bottom_banner_button_url'])) : '';
    $bottom_banner_image_id = isset($_POST['noriks_collection_bottom_banner_image_id']) ? absint($_POST['noriks_collection_bottom_banner_image_id']) : 0;
    $bottom_banner_bg_color = isset($_POST['noriks_collection_bottom_banner_bg_color']) ? sanitize_hex_color(wp_unslash($_POST['noriks_collection_bottom_banner_bg_color'])) : '#f0eaea';
    $product_order_raw = isset($_POST['noriks_collection_product_order']) ? wp_unslash($_POST['noriks_collection_product_order']) : '';
    $gallery_image_raw = isset($_POST['noriks_collection_gallery_image_map']) ? (array) wp_unslash($_POST['noriks_collection_gallery_image_map']) : array();
    $bottom_product_raw = isset($_POST['noriks_collection_bottom_product_ids']) ? wp_unslash($_POST['noriks_collection_bottom_product_ids']) : '';
    $product_order_ids = noriks_collection_order_ids_from_string($product_order_raw);
    $gallery_image_map = array();
    foreach ($gallery_image_raw as $product_id => $image_id) {
        $product_id = absint($product_id);
        $image_id = absint($image_id);
        if ($product_id <= 0 || $image_id <= 0) {
            continue;
        }

        $product = wc_get_product($product_id);
        if (!$product) {
            continue;
        }

        $gallery_ids = array_map('absint', $product->get_gallery_image_ids());
        if (in_array($image_id, $gallery_ids, true)) {
            $gallery_image_map[$product_id] = $image_id;
        }
    }
    $bottom_product_ids = array_slice(noriks_collection_order_ids_from_string($bottom_product_raw), 0, 8);

    update_term_meta($term_id, 'noriks_collection_promo_title', $promo_title);
    update_term_meta($term_id, 'noriks_collection_promo_subtitle', $promo_subtitle);
    update_term_meta($term_id, 'noriks_collection_intro_text', $intro_text);
    update_term_meta($term_id, 'noriks_collection_bottom_intro_text', $bottom_intro_text);
    update_term_meta($term_id, 'noriks_collection_bottom_banner_title', $bottom_banner_title);
    update_term_meta($term_id, 'noriks_collection_bottom_banner_subtitle', $bottom_banner_subtitle);
    update_term_meta($term_id, 'noriks_collection_bottom_banner_button_text', $bottom_banner_button_text);
    update_term_meta($term_id, 'noriks_collection_bottom_banner_button_url', $bottom_banner_button_url);
    update_term_meta($term_id, 'noriks_collection_bottom_banner_image_id', $bottom_banner_image_id);
    update_term_meta($term_id, 'noriks_collection_bottom_banner_bg_color', $bottom_banner_bg_color ? $bottom_banner_bg_color : '#f0eaea');
    update_term_meta($term_id, 'noriks_collection_product_order', implode("\n", $product_order_ids));
    $gallery_image_lines = array();
    foreach ($gallery_image_map as $product_id => $image_id) {
        $gallery_image_lines[] = $product_id . ':' . $image_id;
    }
    update_term_meta($term_id, 'noriks_collection_gallery_image_map', implode("\n", $gallery_image_lines));
    update_term_meta($term_id, 'noriks_collection_bottom_product_ids', implode("\n", $bottom_product_ids));
}

function noriks_enqueue_collection_term_admin_assets($hook) {
    if (($hook !== 'edit-tags.php' && $hook !== 'term.php') || empty($_GET['taxonomy']) || $_GET['taxonomy'] !== 'collections') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-sortable');

    $script = <<<JS
(function($){
  function updateProductOrderField(ui){
    var selected = [];
    ui.find('.noriks-product-order-list--selected .noriks-product-order-item').each(function(){
      selected.push($(this).data('id'));
    });
    ui.find('.noriks-product-order-value').val(selected.join("\\n"));
  }

  function createSelectedItem(id, title, sku){
    return $('<li class="noriks-product-order-item is-active" data-id="' + id + '">' +
      '<span class="noriks-product-order-handle">⋮⋮</span>' +
      '<div class="noriks-product-order-item__meta"><strong></strong><span></span></div>' +
      '<button type="button" class="button button-small noriks-product-order-remove">Remove</button>' +
    '</li>')
      .find('strong').text(title).end()
      .find('span:last').text(sku || 'No SKU').end();
  }

  function bindProductOrderUi(){
    $('.noriks-product-order-ui').each(function(){
      var ui = $(this);
      var available = ui.find('.noriks-product-order-list--available');
      var selected = ui.find('.noriks-product-order-list--selected');

      selected.sortable({
        handle: '.noriks-product-order-handle',
        update: function(){
          updateProductOrderField(ui);
        }
      });

      available.on('click', '.noriks-product-order-add', function(e){
        e.preventDefault();
        var item = $(this).closest('.noriks-product-order-item');
        var id = item.data('id');
        if (selected.find('[data-id="' + id + '"]').length) {
          return;
        }
        var title = item.find('strong').text();
        var sku = item.find('span').text();
        item.addClass('is-selected');
        selected.append(createSelectedItem(id, title, sku));
        updateProductOrderField(ui);
      });

      selected.on('click', '.noriks-product-order-remove', function(e){
        e.preventDefault();
        var item = $(this).closest('.noriks-product-order-item');
        var id = item.data('id');
        item.remove();
        available.find('[data-id="' + id + '"]').removeClass('is-selected');
        updateProductOrderField(ui);
      });

      ui.find('.noriks-product-order-search').on('input', function(){
        var needle = $(this).val().toLowerCase().trim();
        available.find('.noriks-product-order-item').each(function(){
          var item = $(this);
          var haystack = (item.data('title') + ' ' + item.data('sku')).toLowerCase();
          item.toggle(!needle || haystack.indexOf(needle) !== -1);
        });
      });

      updateProductOrderField(ui);
    });
  }

  function bindCollectionMedia(){
    var frame;
    $('.noriks-collection-upload').off('click').on('click', function(e){
      e.preventDefault();
      var button = $(this);
      var container = button.closest('td, .form-field');
      if(frame){ frame.open(); return; }
      frame = wp.media({ title: 'Select banner image', button: { text: 'Use image' }, multiple: false });
      frame.on('select', function(){
        var attachment = frame.state().get('selection').first().toJSON();
        container.find('input[type="hidden"]').first().val(attachment.id);
        container.find('.noriks-collection-banner-preview').html('<img src="'+attachment.url+'" style="max-width:240px;height:auto;" alt="">');
      });
      frame.open();
    });
    $('.noriks-collection-remove').off('click').on('click', function(e){
      e.preventDefault();
      var container = $(this).closest('td, .form-field');
      container.find('input[type="hidden"]').first().val('');
      container.find('.noriks-collection-banner-preview').empty();
    });
  }

  function bindCollectionGallerySelectors(){
    $('.noriks-collection-gallery-image-select').off('change').on('change', function(){
      var select = $(this);
      var item = select.closest('.noriks-collection-gallery-image-item');
      var preview = item.find('.noriks-collection-gallery-image-item__preview');
      var selected = select.find('option:selected');
      var previewUrl = selected.data('preview-url');

      if (previewUrl) {
        preview.html('<img src="' + previewUrl + '" alt="">');
      } else {
        preview.html('<span class="noriks-collection-gallery-image-item__placeholder">Featured</span>');
      }
    });
  }
  $(function(){
    bindCollectionMedia();
    bindProductOrderUi();
    bindCollectionGallerySelectors();
  });
})(jQuery);
JS;

    wp_add_inline_script('jquery-core', $script);
    wp_add_inline_style('wp-admin', '
      .taxonomy-collections .term-description-wrap,
      .taxonomy-collections .term-parent-wrap {
        display: none !important;
      }
      .noriks-product-order-columns {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 20px;
        max-width: 1100px;
      }
      .noriks-product-order-column {
        border: 1px solid #dcdcde;
        background: #fff;
        padding: 12px;
      }
      .noriks-product-order-column h4 {
        margin: 0 0 12px;
      }
      .noriks-product-order-search {
        width: 100%;
        margin-bottom: 12px;
      }
      .noriks-product-order-list {
        margin: 0;
        max-height: 420px;
        overflow: auto;
      }
      .noriks-product-order-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 0 0 8px;
        padding: 10px 12px;
        border: 1px solid #dcdcde;
        background: #fff;
      }
      .noriks-product-order-item.is-selected {
        opacity: 0.45;
      }
      .noriks-product-order-item__meta {
        display: flex;
        flex-direction: column;
        gap: 2px;
        min-width: 0;
        flex: 1;
      }
      .noriks-product-order-item__meta strong,
      .noriks-product-order-item__meta span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
      .noriks-product-order-item__meta span {
        color: #50575e;
      }
      .noriks-product-order-handle {
        cursor: move;
        color: #50575e;
        font-size: 18px;
        line-height: 1;
      }
      .noriks-collection-gallery-image-list {
        margin: 0;
        max-width: 900px;
      }
      .noriks-collection-gallery-image-item {
        margin: 0 0 8px;
        padding: 10px 12px;
        border: 1px solid #dcdcde;
        background: #fff;
      }
      .noriks-collection-gallery-image-item__head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
      }
      .noriks-collection-gallery-image-item__preview {
        width: 56px;
        height: 56px;
        flex: 0 0 56px;
        background: #f6f7f7;
        border: 1px solid #dcdcde;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .noriks-collection-gallery-image-item__preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
      }
      .noriks-collection-gallery-image-item__placeholder {
        font-size: 11px;
        color: #50575e;
        text-align: center;
        padding: 4px;
      }
      .noriks-collection-gallery-image-item__meta {
        display: flex;
        flex-direction: column;
        gap: 3px;
      }
      .noriks-collection-gallery-image-item__meta strong,
      .noriks-collection-gallery-image-item__meta em {
        display: block;
      }
      .noriks-collection-gallery-image-item em {
        color: #50575e;
        font-style: normal;
      }
      .noriks-collection-gallery-image-select {
        min-width: 280px;
      }
      @media (max-width: 1200px) {
        .noriks-product-order-columns {
          grid-template-columns: 1fr;
        }
      }
    ');
}

function noriks_hide_collections_from_product_list_admin() {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    if (!$screen || $screen->id !== 'edit-product') {
        return;
    }

    echo '<style>
    .column-taxonomy-collections,
    #dropdown_taxonomy_collections {
      display: none !important;
    }
    </style>';
}


function register_custom_post_type_lander() {
    $labels = array(
        'name'                  => _x('Landers', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Lander', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Landers', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Lander', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Lander', 'textdomain'),
        'new_item'              => __('New Lander', 'textdomain'),
        'edit_item'             => __('Edit Lander', 'textdomain'),
        'view_item'             => __('View Lander', 'textdomain'),
        'all_items'             => __('All Landers', 'textdomain'),
        'search_items'          => __('Išči Landerje', 'textdomain'),
        'not_found'             => __('No landers found.', 'textdomain'),
        'not_found_in_trash'    => __('No landers found in Trash.', 'textdomain'),
        'featured_image'        => _x('Lander Cover Image', 'Overrides the “Featured Image” phrase.', 'textdomain'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase.', 'textdomain'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase.', 'textdomain'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase.', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'lander'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-location-alt', // optional icon
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true, // enables Gutenberg and REST API
    );

    register_post_type('lander', $args);
}





// Register Product Reviews CPT
function register_custom_post_type_product_reviews() {
    $labels = array(
        'name'                  => _x('Product Reviews', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Product Review', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Product Reviews', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Product Review', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Product Review', 'textdomain'),
        'new_item'              => __('New Product Review', 'textdomain'),
        'edit_item'             => __('Edit Product Review', 'textdomain'),
        'view_item'             => __('View Product Review', 'textdomain'),
        'all_items'             => __('All Product Reviews', 'textdomain'),
        'search_items'          => __('Išči ocene izdelkov', 'textdomain'),
        'not_found'             => __('No product reviews found.', 'textdomain'),
        'not_found_in_trash'    => __('No product reviews found in Trash.', 'textdomain'),
        'featured_image'        => _x('Product Image', 'Overrides the “Featured Image” phrase.', 'textdomain'),
        'set_featured_image'    => _x('Set product image', 'Overrides the “Set featured image” phrase.', 'textdomain'),
        'remove_featured_image' => _x('Remove product image', 'Overrides the “Remove featured image” phrase.', 'textdomain'),
        'use_featured_image'    => _x('Use as product image', 'Overrides the “Use as featured image” phrase.', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'product-review'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-star-half',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments'),
        'show_in_rest'       => true,
    );

    register_post_type('product_review', $args);
}






/* -----------------------------
   Register Lander2 CPT
------------------------------ */
function register_custom_post_type_lander2() {
    $labels = array(
        'name'                  => _x('Landers 2', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Lander 2', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('Landers 2', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Lander 2', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Lander 2', 'textdomain'),
        'new_item'              => __('New Lander 2', 'textdomain'),
        'edit_item'             => __('Edit Lander 2', 'textdomain'),
        'view_item'             => __('View Lander 2', 'textdomain'),
        'all_items'             => __('All Landers 2', 'textdomain'),
        'search_items'          => __('Išči Landerje 2', 'textdomain'),
        'not_found'             => __('No landers found.', 'textdomain'),
        'not_found_in_trash'    => __('No landers found in Trash.', 'textdomain'),
        'featured_image'        => _x('Lander 2 Image', 'Overrides the Featured Image phrase', 'textdomain'),
        'set_featured_image'    => _x('Set image', 'Overrides the Set featured image phrase', 'textdomain'),
        'remove_featured_image' => _x('Remove image', 'Overrides the Remove featured image phrase', 'textdomain'),
        'use_featured_image'    => _x('Use as image', 'Overrides the Use as featured image phrase', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'lander2'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-admin-site',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('lander2', $args);
}


add_action('init', 'noriks_register_landigs_post_type');
add_action('init', 'noriks_register_collections_taxonomy');
add_action('init', 'register_custom_post_type_lander');
add_action('init', 'register_custom_post_type_product_reviews');
add_action('init', 'register_custom_post_type_lander2');
add_action('init', 'noriks_register_landigs_meta');
add_action('add_meta_boxes', 'noriks_add_landigs_meta_box');
add_action('save_post_landigs', 'noriks_save_landigs_meta');
add_action('init', 'noriks_ensure_default_step_landing', 20);
add_action('init', 'noriks_ensure_default_collection_akcija', 20);
add_action('init', 'noriks_flush_rewrite_once', 30);
add_action('collections_add_form_fields', 'noriks_add_collection_term_fields');
add_action('collections_edit_form_fields', 'noriks_edit_collection_term_fields');
add_action('created_collections', 'noriks_save_collection_term_meta');
add_action('edited_collections', 'noriks_save_collection_term_meta');
add_action('admin_enqueue_scripts', 'noriks_enqueue_collection_term_admin_assets');
add_action('admin_head-edit.php', 'noriks_hide_collections_from_product_list_admin');
