<?php
/**
 * Nordform front-page (alfaform clone) — cal-header baked in clone,
 * dequeue theme assets, wp_head/footer (side cart), ATC -> side cart.
 */
add_action( 'wp_enqueue_scripts', function () {
    global $wp_styles, $wp_scripts;
    if ( $wp_styles ) { foreach ( (array) $wp_styles->queue as $h ) { $src = isset($wp_styles->registered[$h]) ? $wp_styles->registered[$h]->src : ''; if ( strpos($src,'/themes/restora/')!==false && strpos($src,'landing.css')===false ) wp_dequeue_style($h); } }
    if ( $wp_scripts ) { foreach ( (array) $wp_scripts->queue as $h ) { $src = isset($wp_scripts->registered[$h]) ? $wp_scripts->registered[$h]->src : ''; if ( strpos($src,'/themes/restora/')!==false ) wp_dequeue_script($h); } }
}, 99999 ); // alen_clone_dequeue

$html = file_get_contents( get_template_directory() . '/assets/alfaform-clone/site/products/northpower-experience-the-shift-in-shape-posture-pride.html' );
$html = preg_replace('#<script\b[^>]*\bsrc="[^"]*(monorail|trekkie|shopifycloud|shop-js|/cdn/wpm/|judge\.me|shop\.app|web-pixels|wpm@|alfaform\.com)[^"]*"[^>]*>\s*</script>#i','',$html);

$pid = 10;
$h = '<script>(function(){var PID=' . intval($pid) . ';function bind(){var s=["button[name=\"add\"]","button.product-form__submit","button[id*=AddToCart]","button[class*=add-to-cart]","[data-add-to-cart]"];document.querySelectorAll(s.join(",")).forEach(function(b){if(b.dataset.wcBound)return;b.dataset.wcBound="1";b.addEventListener("click",function(e){e.preventDefault();e.stopPropagation();var body=new URLSearchParams();body.append("product_id",PID);body.append("quantity",1);fetch("/?wc-ajax=add_to_cart",{method:"POST",credentials:"include",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:body.toString()}).then(function(r){return r.json();}).then(function(data){if(window.jQuery){jQuery(document.body).trigger("added_to_cart",[data&&data.fragments?data.fragments:{},data&&data.cart_hash?data.cart_hash:"",null]);}}).catch(function(){window.location.href="/?add-to-cart="+PID;});},true);});}if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",bind);}else{bind();}setTimeout(bind,1500);setTimeout(bind,3500);})();</script>';
$h .= '<script>(function(){function bl(){document.querySelectorAll("a[href*=\"/products/\"]").forEach(function(a){if(a.dataset.wl||a.closest(".cal-header,.cal-footer"))return;a.dataset.wl="1";a.addEventListener("click",function(e){e.preventDefault();var body=new URLSearchParams();body.append("product_id",10);body.append("quantity",1);fetch("/?wc-ajax=add_to_cart",{method:"POST",credentials:"include",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:body.toString()}).then(function(r){return r.json();}).then(function(data){if(window.jQuery){jQuery(document.body).trigger("added_to_cart",[data&&data.fragments?data.fragments:{},data&&data.cart_hash?data.cart_hash:"",null]);}});},true);});}if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",bl);}else{bl();}setTimeout(bl,1500);setTimeout(bl,3500);})();</script>';

$h .= '<script id="alen-form-atc">(function(){function add(){var body=new URLSearchParams();body.append("product_id",10);body.append("quantity",1);return fetch("/?wc-ajax=add_to_cart",{method:"POST",credentials:"include",headers:{"Content-Type":"application/x-www-form-urlencoded"},body:body.toString()}).then(function(r){return r.json();}).then(function(data){if(window.jQuery){jQuery(document.body).trigger("added_to_cart",[data&&data.fragments?data.fragments:{},data&&data.cart_hash?data.cart_hash:"",null]);}});}
document.addEventListener("submit",function(e){var f=e.target;if(f&&f.matches&&(f.matches("form[action*=\'/cart/add\']")||f.getAttribute("data-type")==="add-to-cart-form")){e.preventDefault();e.stopPropagation();add();}},true);
document.addEventListener("click",function(e){var b=e.target.closest&&e.target.closest("button.product-form__submit, button[name=\'add\'], [data-add-to-cart]");if(b){e.preventDefault();e.stopPropagation();add();}},true);
})();</script>';

// alen wp inject
ob_start(); wp_head(); $__h = ob_get_clean();
ob_start(); wp_footer(); $__f = ob_get_clean();
$__hp = stripos($html,'</head>'); if($__hp!==false){$html=substr($html,0,$__hp).$__h.substr($html,$__hp);}
$__bp = strripos($html,'</body>'); if($__bp!==false){$html=substr($html,0,$__bp).$h.$__f.substr($html,$__bp);}


header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
echo $html;
exit;
