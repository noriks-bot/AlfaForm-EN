<?php
/**
 * Plugin Name: Inline Bundle Builder
 * Description: Build a bundle in a responsive modal. Saves each slot as numbered meta (e.g., "1: Crna Majica - S") in orders. Cart/checkout shows the same lines without a label.
 * Version:     3.2.0
 * Author:      You
 */

if (!defined('ABSPATH')) exit;

class IBB_Plugin_SimpleMeta {

    public function __construct() {
        add_shortcode('inline_bundle_builder', [$this, 'shortcode']);

        // AJAX: resolve variation from attributes
        add_action('wp_ajax_ibb_find_variation',        [$this, 'ajax_find_variation']);
        add_action('wp_ajax_nopriv_ibb_find_variation', [$this, 'ajax_find_variation']);

        // Save/display meta
        add_filter('woocommerce_add_cart_item_data',              [$this, 'hook_add_cart_item_data'], 10, 3);
        add_filter('woocommerce_get_item_data',                   [$this, 'hook_display_item_data'],  10, 2);
        add_action('woocommerce_checkout_create_order_line_item', [$this, 'hook_order_item_meta'],    10, 4);
    }

    /* -------------------------------------------------
     * Shortcode (enqueues assets ONLY when rendered)
     * ------------------------------------------------*/
    /**
     * Usage: echo do_shortcode('[inline_bundle_builder products="504,505,506" slots="3" gratis_slots="1,3,5"]');
     * - `gratis_slots` is optional. If provided, the specified 1-based slot numbers will render the GRATIS badge.
     */
    public function shortcode($atts) {
        if (!class_exists('WooCommerce')) return '';

        $a = shortcode_atts([
            'products'     => '',
            'slots'        => 3,
            'gratis_slots' => '', // NEW: control GRATIS badge purely via data attribute (e.g., "3" or "1,3,5" or "1-3" or "all")
        ], $atts);

        $ids         = array_filter(array_map('absint', explode(',', $a['products'])));
        $slots       = max(1, absint($a['slots']));
        $gratis_attr = trim((string) $a['gratis_slots']);

        if (!$ids) return '<em>No products configured.</em>';

        // Enqueue assets *only* when shortcode renders
        wp_enqueue_style ('ibb-style', plugins_url('ibb.css?dd', __FILE__), [], '3.2.0');
        wp_enqueue_script('ibb-script', plugins_url('ibb.js?ds34343ddsds',  __FILE__), ['jquery'], '3.2.0', true);

        // Hide the stray ":" dt in variation blocks (mini cart / cart / checkout / XOO side cart)
        $ibb_inline_css = '
          .widget_shopping_cart .variation dt.variation-,
          .woocommerce-mini-cart .variation dt.variation-,
          .woocommerce-cart .variation dt.variation-,
          .woocommerce-checkout .variation dt.variation-,
          .xoo-wsc-container .variation dt.variation- { display:none!important; }
          .widget_shopping_cart .variation dd.variation-,
          .woocommerce-mini-cart .variation dd.variation-,
          .woocommerce-cart .variation dd.variation-,
          .woocommerce-checkout .variation dd.variation-,
          .xoo-wsc-container .variation dd.variation- { margin:0; padding:0; }
        ';
        wp_add_inline_style('ibb-style', $ibb_inline_css);

        wp_localize_script('ibb-script', 'IBB', [
            'ajax'  => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ibb'),
        ]);

        // Add an inline script that:
        // - Disables ATC only when a .ibb-wrapper exists
        // - Ensures the hidden ibb_cart_data field exists in the Woo form
        // - Keeps it synced with window.IBB.carts
        $inline_js = <<<JS
jQuery(function($){
  var \$wrap = $('.ibb-wrapper').first();
  if (!\$wrap.length) return; // only act on pages where shortcode rendered

  // Prefer the form wrapping the shortcode; fallback to first product form
  var \$form = \$wrap.closest('form.cart');
  if (!\$form.length) \$form = $('form.cart').first();

  // Disable ATC on load (only here) — NEVER touch buttons inside the YITH Quick View container
  var \$btn = \$form.find('.single_add_to_cart_button');
  if (\$btn.length && !\$form.closest('#yith-quick-view-content').length) {
    \$btn.prop('disabled', true).addClass('ibb-disabled');
  }

  function ensureHidden(){
    var \$field = \$form.find('input.ibb-cart-data[name="ibb_cart_data"]');
    if(!\$field.length){
      \$field = $('<input type="hidden" name="ibb_cart_data" class="ibb-cart-data" value="[]">');
      \$form.append(\$field);
    }
    return \$field;
  }

  function getSlotsJSON(){
    try{
      if (window.IBB && window.IBB.carts){
        var wid = \$wrap.attr('data-ibb-id');
        if (wid && window.IBB.carts[wid]) return JSON.stringify(window.IBB.carts[wid]);
      }
    }catch(e){}
    return '[]';
  }

  function syncHidden(){
    var \$field = ensureHidden();
    \$field.val(getSlotsJSON());
  }

  // initial + on events
  syncHidden();

  $(document).on('ibb:slotsFilled ibb:slotsNotFilled', '.ibb-wrapper', function(e){
    // keep field synced
    syncHidden();

    // toggle ATC based on fill-state
    if (!\$btn.length) return;
    if (e.type === 'ibb:slotsFilled'){
      \$btn.prop('disabled', false).removeClass('ibb-disabled');
    } else {
      // again, don't touch modal buttons
      if (!\$form.closest('#yith-quick-view-content').length) {
        \$btn.prop('disabled', true).addClass('ibb-disabled');
      }
    }
  });

  // resync after add/remove clicks
  $(document).on('click', '.ibb-add, .ibb-slot-remove', function(){ setTimeout(syncHidden, 0); });

  // resync just before submit
  \$form.on('submit', syncHidden);
});
JS;
        wp_add_inline_script('ibb-script', $inline_js, 'after');

        /* === ADDED: block CSS/JS inside YITH Quick View modal (no button changes) === */
        $qv_block_js = <<<JS
jQuery(function($){
  function cleanQuickView(){
    var c = document.getElementById('yith-quick-view-content');
    if(!c) return;

    // Remove style/script/link rel=stylesheet/noscript inside modal
    c.querySelectorAll('style, script, link[rel="stylesheet"], noscript').forEach(function(n){ n.remove(); });

    // Remove inline event handlers like onclick/onload to prevent JS execution
    c.querySelectorAll('*').forEach(function(el){
      if(!el.attributes) return;
      for (var i = el.attributes.length - 1; i >= 0; i--) {
        var a = el.attributes[i];
        if (/^on/i.test(a.name)) el.removeAttribute(a.name);
      }
    });

    // IMPORTANT: do not modify any buttons inside the modal.
  }

  // Run once (in case content is already present)
  cleanQuickView();

  // YITH commonly triggers this when content has loaded into the modal
  $(document).on('qv_loader_stop', function(){ 
    setTimeout(cleanQuickView, 0);
    setTimeout(cleanQuickView, 50);
    setTimeout(cleanQuickView, 300);
  });

  // Fallback: watch DOM for injected content
  var obs = new MutationObserver(function(muts){
    for (var m of muts){
      for (var node of m.addedNodes){
        if (!(node instanceof HTMLElement)) continue;
        if (node.id === 'yith-quick-view-content' || (node.querySelector && node.querySelector('#yith-quick-view-content'))){
          setTimeout(cleanQuickView, 0);
          setTimeout(cleanQuickView, 50);
          setTimeout(cleanQuickView, 300);
        }
      }
    }
  });
  obs.observe(document.documentElement, { childList:true, subtree:true });

  // Also re-clean around open/close interactions (still no button changes)
  $(document).on('click', '.yith-wcqv-button, .yith-quick-view, .yith-quick-view-close', function(){
    setTimeout(cleanQuickView, 150);
  });
});
JS;
        wp_add_inline_script('ibb-script', $qv_block_js, 'after');
        /* === /ADDED ============================================================ */

        // Build product cards for modal
        $cards = [];
        foreach ($ids as $pid) {
            $p = wc_get_product($pid);
            if (!$p || !$p->is_purchasable()) continue;

            $c = [
                'id'    => $pid,
                'type'  => $p->get_type(),
                'title' => $p->get_name(),
                'price' => $p->get_price_html(),
                'img'   => wp_get_attachment_image_url($p->get_image_id() ?: get_post_thumbnail_id($pid), 'woocommerce_single'),
                'attrs' => [],
            ];

            if ($p->is_type('variable')) {
                $vattrs = $p->get_variation_attributes();
                foreach ($vattrs as $tax_raw => $options) {
                    $tax_norm = str_replace('attribute_', '', $tax_raw);
                    if (strpos($tax_norm, 'pa_') === 0) $tax_norm = substr($tax_norm, 3);

                    $label = wc_attribute_label($tax_norm) ?: wc_attribute_label($tax_raw) ?: 'Option';
                    $opts  = [];
                    foreach ((array)$options as $opt) {
                        $term = taxonomy_exists($tax_norm) ? get_term_by('slug', $opt, $tax_norm) : null;
                        $opts[] = [
                            'value' => $term ? $term->slug : (string)$opt,
                            'label' => $term ? $term->name : (string)$opt,
                        ];
                    }
                    $c['attrs'][] = [
                        'raw'   => $tax_raw,
                        'norm'  => $tax_norm,
                        'label' => $label,
                        'opts'  => $opts,
                    ];
                }
            }

            $cards[] = $c;
        }

        // subtitle text: slots + current product price
        global $product;
        $bundle_price = '';
        if ($product instanceof WC_Product) {
            $price = $product->get_sale_price() ?: $product->get_regular_price();
            if ($price) $bundle_price = wc_price($price);
        }

        ob_start(); ?>
        <div class="ibb-wrapper"
             data-slots="<?php echo esc_attr($slots); ?>"
             <?php if ($gratis_attr !== ''): ?>
             data-ibb-gratis-slots="<?php echo esc_attr($gratis_attr); ?>"
             <?php endif; ?>>
          <div class="ibb-slots">
            <?php for ($i=0; $i<$slots; $i++): ?>
              <div class="ibb-slot-wrap">
                  
                  
                  <?php
                  
                  // make here boxerice if else
                  $is_boxers = has_term( array( 'bokserice', 'bokserice-sastavi-paket' ), 'product_cat', $current_product_id );

                  
                  ?>
                  
                  
                <div class="ibb-slot-header">
                    
                    <?php if( $is_boxers ): ?>
                    Odaberite proizvod
                    <?php else: ?>
                     Odaberite majicu
                    <?php endif; ?>
                
                
                
                <?php echo esc_html($i+1); ?> od <?php echo esc_html($slots); ?></div>
                <div class="ibb-slot is-empty" data-index="<?php echo (int) $i; ?>" tabindex="0">
                  <div class="ibb-slot-thumb"><span class="ibb-slot-plus" aria-hidden="true">+</span></div>
                  <div class="ibb-slot-info">
                    <span class="ibb-slot-attr">
                        
                          <?php if( $is_boxers ): ?>
                           <?php esc_html_e('Dodaj proizvod','ibb'); ?>
                          <?php else: ?>
                          
                           <?php esc_html_e('Dodaj majicu','ibb'); ?>
                          <?php endif; ?>
                     
                    </span>
                    <span class="ibb-slot-price" hidden></span>
                  </div>
                </div>
              </div>
            <?php endfor; ?>
          </div>

          <!-- Modal scaffold (your ibb.js handles its behavior) -->
          <div class="ibb-modal" aria-hidden="true">
            <div class="ibb-modal__box" role="dialog" aria-modal="true" aria-label="Bundle builder">
              <div class="ibb-modal__head">
                <div class="ibb-steps-nav">
                  <button type="button" class="ibb-nav ibb-prev">‹</button>
                  <div class="ibb-steps"></div>
                  <button type="button" class="ibb-nav ibb-next">›</button>
                </div>
                <button type="button" class="ibb-modal__close">×</button>
                <div class="ibb-titlebar">
                  <h2 class="ibb-heading">Izberi <span class="ibb-step-num">1</span> 
                  
                   <?php if( $is_boxers ): ?>
                  izdelek
                  <?php else: ?>
                  majico
                  <?php endif; ?>          
                  
                  </h2>
                  <p class="ibb-sub">
                      
                       <?php if( $is_boxers ): ?>
                    <?php printf(__('Dodajte %1$d izdelek in prejeli boste paket za %2$s', 'ibb'), $slots, $bundle_price); ?>
                     <?php else: ?>
                      <?php printf(__('Dodajte %1$d majic in prejeli boste paket za %2$s', 'ibb'), $slots, $bundle_price); ?>
                     <?php endif; ?>     
                    
                  </p>
                </div>
              </div>
              <div class="ibb-modal__body">
                <div class="ibb-grid">
                  <?php foreach ($cards as $c): ?>
                    <div class="ibb-card" data-id="<?php echo esc_attr($c['id']); ?>" data-type="<?php echo esc_attr($c['type']); ?>">
                      <img src="<?php echo esc_url($c['img']); ?>" alt="<?php echo esc_attr($c['title']); ?>">
                      <div class="ibb-card-body">
                        <div class="ibb-card-title"><?php echo esc_html($c['title']); ?></div>
                        <?php if ($c['type'] === 'variable' && !empty($c['attrs'])): ?>
                          <?php foreach ($c['attrs'] as $a): ?>
                            <label class="ibb-label"><?php echo esc_html($a['label']); ?></label>
                            <select class="ibb-attr"
                              data-taxonomy="<?php echo esc_attr($a['norm']); ?>"
                              data-taxonomy-raw="<?php echo esc_attr('attribute_' . $a['norm']); ?>">
                              <option value=""><?php echo esc_html__('Vyberte variantu', 'ibb'); ?></option>
                              <?php foreach ($a['opts'] as $o): ?>
                                <option value="<?php echo esc_attr($o['value']); ?>"><?php echo esc_html($o['label']); ?></option>
                              <?php endforeach; ?>
                            </select>
                          <?php endforeach; ?>
                        <?php endif; ?>
                        <button type="button" class="ibb-add"><?php esc_html_e('Dodaj u paket','ibb'); ?></button>
                        <div class="ibb-msg" aria-live="polite"></div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
          <!-- /modal -->
        </div>
        <?php
        return ob_get_clean();
    }

    /* -------------------------------------------------
     * Variation AJAX
     * ------------------------------------------------*/
    public function ajax_find_variation() {
        check_ajax_referer('ibb', 'nonce');

        $product_id = absint($_POST['product_id'] ?? 0);
        $attrs_in   = isset($_POST['attributes']) ? (array) $_POST['attributes'] : [];

        $product = wc_get_product($product_id);
        if (!$product || !$product->is_type('variable')) {
            wp_send_json_error(['message' => 'Invalid product']);
        }

        $attrs = [];
        foreach ($attrs_in as $k => $v) {
            $k = sanitize_title($k);
            $attrs['attribute_' . $k] = wc_clean($v);
        }

        $ds = new WC_Product_Data_Store_CPT();
        $variation_id = $ds->find_matching_product_variation($product, $attrs);

        if (!$variation_id) {
            wp_send_json_error(['message' => 'This option is unavailable.']);
        }

        $vp = wc_get_product($variation_id);
        wp_send_json_success([
            'variation_id' => $variation_id,
            'price'        => $vp ? $vp->get_price_html() : '',
        ]);
    }

    /* -------------------------------------------------
     * Helpers
     * ------------------------------------------------*/
    private function parse_slots_from_post() : array {
        if (empty($_POST['ibb_cart_data'])) return [];
        $raw   = wp_unslash($_POST['ibb_cart_data']);
        $slots = json_decode($raw, true);
        return is_array($slots) ? $slots : [];
    }

    private function slot_line(array $slot) : string {
        $title = !empty($slot['title']) ? trim((string)$slot['title']) : '';
        $size  = '';
        if (!empty($slot['attr']) && is_array($slot['attr'])) {
            foreach ($slot['attr'] as $k => $v) {
                $val = is_scalar($v) ? (string)$v : '';
                if ($val !== '' && preg_match('~size|veli[čc]ina~iu', $k)) {
                    $size = function_exists('mb_strtoupper') ? mb_strtoupper($val, 'UTF-8') : strtoupper($val);
                }
            }
        }
        return trim($title . ($size ? " - $size" : ''));
    }

    private function build_slot_lines(array $slots) : array {
        $filled = array_values(array_filter($slots, function($s){ return !empty($s['product_id']); }));
        $lines = [];
        foreach ($filled as $slot) {
            $lines[] = $this->slot_line($slot);
        }
        return $lines;
    }

    /* -------------------------------------------------
     * Cart & Order Meta
     * ------------------------------------------------*/
    public function hook_add_cart_item_data($cart_item_data, $product_id, $variation_id) {
        $slots = $this->parse_slots_from_post();
        if (!$slots) return $cart_item_data;

        // Keep raw slots JSON for later display/order meta
        $cart_item_data['_ibb_slots_json'] = wp_json_encode($slots);

        // Ensure uniqueness so cart items don't merge
        $lines = $this->build_slot_lines($slots);
        $cart_item_data['ibb_unique_key'] = md5(wp_json_encode([$lines]) . '|' . microtime(true) . '|' . wp_rand());

        return $cart_item_data;
    }

    public function hook_display_item_data($item_data, $cart_item) {
        $slots_json = !empty($cart_item['_ibb_slots_json']) ? $cart_item['_ibb_slots_json'] : '';
        $slots = $slots_json ? json_decode($slots_json, true) : [];
        if (!is_array($slots)) $slots = [];

        $lines = $this->build_slot_lines($slots);
        if ($lines) {
            $numbered = [];
            foreach ($lines as $i => $line) {
                $numbered[] = ($i+1) . ': ' . $line;
            }
            $value = implode('<br>', array_map('esc_html', $numbered));

            // name=false -> Woo prints only the value (no dt) — CSS above also hides stray labels
            $item_data[] = ['name' => false, 'display' => $value];
        }
        return $item_data;
    }

    public function hook_order_item_meta($item, $cart_item_key, $values, $order) {
        $slots_json = !empty($values['_ibb_slots_json']) ? $values['_ibb_slots_json'] : '';
        $slots = $slots_json ? json_decode($slots_json, true) : [];
        if (!is_array($slots)) $slots = [];

        $lines = $this->build_slot_lines($slots);
        if ($lines) {
            foreach ($lines as $i => $line) {
                $item->add_meta_data((string)($i+1), sanitize_text_field($line), true);
            }
        }
    }
}

new IBB_Plugin_SimpleMeta();
