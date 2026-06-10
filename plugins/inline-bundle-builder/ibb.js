jQuery(function($){

  /* ---------- disable ATC on page load (as requested) ---------- */
  (function(){
    var $btn = $('.single_add_to_cart_button');
    if ($btn.length) {
      $btn.prop('disabled', true).addClass('ibb-disabled');
    }
  })();

  /* ---------- state & utils ---------- */
  function emptySlot(){ return {product_id:0,variation_id:0,attr:{},title:'',price_html:'',img:''}; }
  var carts = {}; // wrapper-id -> array of slots

  // EXPOSE carts so we can log slot/cart content from global listeners
  window.IBB = window.IBB || {};
  window.IBB.carts = carts;

  function uid(){ return 'ibb-' + Math.random().toString(36).slice(2,8); }

  function $btn($wrap){
    return $wrap.closest('form.cart').find('.single_add_to_cart_button, [name="add-to-cart"], [type="submit"][name="add-to-cart"]');
  }
  function disableBtn($wrap){
    $btn($wrap)
      .attr('disabled','disabled')
      .prop('disabled',true)
      .addClass('cqbf-disabled ibb-disabled');
  }
  function enableBtn($wrap){
    $btn($wrap)
      .prop('disabled',false)
      .removeClass('cqbf-disabled ibb-disabled')
      .removeAttr('disabled');
  }

  function allFilled($wrap){
    var wid = $wrap.attr('data-ibb-id');
    var cart = carts[wid] || [];
    return cart.length && cart.every(function(s){ return !!s.product_id; });
  }

  function pushHidden($wrap){
    var wid  = $wrap.attr('data-ibb-id');
    var cart = carts[wid] || [];
    var $field = $wrap.closest('form.cart').find('input[name="ibb_cart_data"]');
    if ($field.length) $field.val(JSON.stringify(cart));
  }

  /* ---------- modal open/close (two-phase) ---------- */
  function openModal($modal){
    if($modal.hasClass('open')) return; // already open
    $modal.removeClass('closing').addClass('show').attr('aria-hidden','false');
    $('body').addClass('ibb-lock');
    // force reflow to apply starting transform
    // eslint-disable-next-line no-unused-expressions
    $modal[0].offsetHeight;
    $modal.addClass('open');
  }

  function closeModal($modal){
    if(!$modal.hasClass('show')) return;
    $modal.removeClass('open').addClass('closing').attr('aria-hidden','true');

    var box = $modal.find('.ibb-modal__box')[0];
    var finished = false;
    function finish(){
      if(finished) return;
      finished = true;
      $modal.removeClass('show closing');
      $('body').removeClass('ibb-lock');
    }
    if(box){
      var onEnd = function(e){
        if(e.propertyName === 'transform'){ box.removeEventListener('transitionend', onEnd); finish(); }
      };
      box.addEventListener('transitionend', onEnd);
      // Fallback
      setTimeout(finish, 550);
    } else {
      finish();
    }
  }

  /* ---------- messages: compute per product -> slots list ---------- */
  function updateCardMessages($wrap, $modal){
    var wid = $wrap.attr('data-ibb-id');
    var cart = carts[wid] || [];

    var byPid = {};
    for(var i=0;i<cart.length;i++){
      var s = cart[i];
      if(!s || !s.product_id) continue;
      var pid = s.product_id;
      (byPid[pid] = byPid[pid] || []).push(i+1);
    }

    var $cards = $modal.find('.ibb-card');
    $cards.each(function(){
      var $card = $(this);
      var pid = Number($card.data('id')) || 0;
      var slots = byPid[pid] || [];
      var $msg = $card.find('.ibb-msg');

      if(slots.length){
        var label = (slots.length === 1) ? 'Dodano u slot: ' : 'Dodano u slotove: ';
        $msg.text(label + slots.join(', '));
      } else {
        $msg.empty();
      }
    });
  }

  /* ---------- GRATIS slots parsing (1-based) ---------- */
  function parseGratisSet($wrap, totalSlots){
    var attr = String($wrap.attr('data-ibb-gratis-slots') || '').trim().toLowerCase();
    var set = {};
    if (!attr) return set;

    if (attr === 'all'){
      for (var i=1; i<=totalSlots; i++) set[i] = true;
      return set;
    }

    attr.split(',').forEach(function(tok){
      tok = tok.trim();
      if(!tok) return;
      if(tok.indexOf('-') > -1){
        var parts = tok.split('-');
        var a = parseInt(parts[0], 10);
        var b = parseInt(parts[1], 10);
        if(!isNaN(a) && !isNaN(b)){
          var start = Math.min(a,b), end = Math.max(a,b);
          for (var j = start; j <= end; j++) set[j] = true;
        }
      } else {
        var n = parseInt(tok, 10);
        if(!isNaN(n)) set[n] = true;
      }
    });
    return set;
  }

  /* ---------- render slots (now renders GRATIS when applicable) ---------- */
  function refreshSlots($wrap){
    var wid   = $wrap.attr('data-ibb-id');
    var cart  = carts[wid] || [];
    var total = $wrap.find('.ibb-slot').length;

    // Cache parsed gratis set per wrapper
    var gratisSet = $wrap.data('ibbGratisSet');
    if (!gratisSet) {
      gratisSet = parseGratisSet($wrap, total);
      $wrap.data('ibbGratisSet', gratisSet);
    }

    $wrap.find('.ibb-slot').each(function(i){
      var s = cart[i] || emptySlot();
      var $slot = $(this);
      var filled = !!s.product_id;

      $slot.toggleClass('is-filled', filled).toggleClass('is-empty', !filled);

      var $thumb = $slot.find('.ibb-slot-thumb');
      $thumb.empty();
      if(filled && s.img){
        $('<img>', { src: s.img, alt: '' }).appendTo($thumb);
      } else {
        $('<span>', { class: 'ibb-slot-plus', text: '+', 'aria-hidden': 'true' }).appendTo($thumb);
      }

      // Build slot attr content with optional GRATIS prefix
      var $attr = $slot.find('.ibb-slot-attr');
      $attr.empty();

      var idx1 = i + 1; // 1-based
      if (gratisSet[idx1]) {
        $('<span>', { class: 'ibb-slot-attr-gratis', text: 'GRATIS' }).appendTo($attr);
      }

      if(filled){
        var size = '';
        var attr = s.attr || {};
        for(var k in attr){
          if(!Object.prototype.hasOwnProperty.call(attr, k)) continue;
          var key = (k+'').toLowerCase();
          if(key.indexOf('size')!==-1 || key.indexOf('velicina')!==-1 || key.indexOf('veličina')!==-1){
            size = (attr[k]+'').toUpperCase();
          }
        }
        // append size (or fallback label) as plain text
        $attr.append(document.createTextNode(size || ''));
        if (!size) {
          // if no size available (filled but no size attribute), show title as fallback
          var title = s.title || '';
          if (title) $attr.append(document.createTextNode(title));
        }
      } else {
          
         //
       // Try to find the closest product container that has data-is-boxers
        var productEl =
          $wrap.closest('[id^="product-"][data-is-boxers]').get(0) ||
          document.querySelector('[id^="product-"][data-is-boxers]');

        // Default fallback (in case element not found or attribute missing)
        var isBoxers = false;

        if (productEl && typeof productEl.dataset.isBoxers !== 'undefined') {
          var flag = productEl.dataset.isBoxers;
          // Accept "1" or "true" as truthy
          isBoxers = (flag === '1' || flag === 'true');
        }

        console.log('isBoxers:', isBoxers);

        // Write correct text based on value
        $attr.append(
          document.createTextNode(isBoxers ? 'Dodaj proizvod' : 'Dodaj majicu')
        );
        //

        
      }

      $slot.find('.ibb-slot-price').html(filled ? (s.price_html || '') : '');

      var $remove = $slot.find('.ibb-slot-remove');
      if(filled){
        if(!$remove.length){
          $('<button>', {
            type: 'button',
            class: 'ibb-slot-remove',
            'aria-label': 'Remove',
            text: '×'
          }).appendTo($slot);
        }
      } else {
        $remove.remove();
      }
    });

    pushHidden($wrap);
    updateCardMessages($wrap, $('.ibb-modal').first());
  }

  /* ---------- authoritative ATC toggle (+ events) ---------- */
  function enforceATC($wrap){
    var wid = $wrap.attr('data-ibb-id');
    var slots = carts[wid] || [];
    var filled = slots.length && slots.every(function(s){ return !!s.product_id; });

    if(filled){
      enableBtn($wrap);
      // include slot data in event payload
      $wrap.trigger('ibb:slotsFilled', [{ filledCount: slots.length, slots: slots }]);
    } else {
      disableBtn($wrap);
      $wrap.trigger('ibb:slotsNotFilled', [{
        filledCount: slots.filter(function(s){ return !!s.product_id; }).length,
        slots: slots
      }]);
    }
  }



function renderSteps($wrap, $modal, total, active) {

    // Detect isBoxers EXACTLY the same way as in refreshSlots()
    var productEl =
        $wrap.closest('[id^="product-"][data-is-boxers]').get(0) ||
        document.querySelector('[id^="product-"][data-is-boxers]');

    var isBoxers = false;
    if (productEl && typeof productEl.dataset.isBoxers !== 'undefined') {
        var flag = productEl.dataset.isBoxers;
        isBoxers = (flag === '1' || flag === 'true');
    }

    // Choose label
    var labelBase = isBoxers ? 'Proizvod ' : 'Majica ';

    // Render steps
    var $steps = $modal.find('.ibb-steps').empty();
    for (var i = 0; i < total; i++) {
        var $p = $('<button type="button" class="ibb-step" role="tab"></button>')
            .text(labelBase + (i + 1) + ' od ' + total)
            .attr('data-index', i);

        if (i === active) {
            $p.addClass('is-active').attr('aria-selected', 'true');
        }

        $steps.append($p);
    }

    $modal.find('.ibb-step-num').text(active + 1);
}

  
  

  function preselectDefaultSizeS($scope){
    var sizeKeys={'size':1,'velicina':1,'veličina':1,'pa_size':1,'pa_velicina':1};
    $scope.find('.ibb-attr').each(function(){
      var $sel=$(this);
      var key=String($sel.data('taxonomy')||'').toLowerCase();
      if(!sizeKeys[key]) return;
      $sel.find('option').each(function(){
        var txt=($(this).text()||'').trim().toLowerCase();
        var val=($(this).val()||'').trim().toLowerCase();
        if(txt==='s'||val==='s'){ $sel.val($(this).val()); return false; }
      });
    });
  }

  /* ---------- nav button disable ---------- */
  function updateNavButtons($modal, activeIndex){
    var $steps = $modal.find('.ibb-step');
    var total = $steps.length;
    var $prev = $modal.find('.ibb-prev');
    var $next = $modal.find('.ibb-next');

    $prev.prop('disabled', activeIndex <= 0).attr('aria-disabled', activeIndex <= 0 ? 'true' : null);
    $next.prop('disabled', activeIndex >= total-1).attr('aria-disabled', activeIndex >= total-1 ? 'true' : null);
  }

  /* ---------- helper: center active step in horizontal scroller (mobile) ---------- */
  function scrollActiveStepIntoView($modal){
    var $active = $modal.find('.ibb-step.is-active');
    var $scroller = $modal.find('.ibb-steps-nav');
    if($active.length && $scroller.length){
      $active[0].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }
  }

  /* ---------- mobile close chevron injector ---------- */
  function ensureMobileClose($modal){
    if($modal.find('.ibb-modal__close-mobile').length) return;
    var $head = $modal.find('.ibb-modal__head');
    if(!$head.length) return;

    var $btn = $('<button>', {
      type: 'button',
      class: 'ibb-modal__close-mobile',
      'aria-label': 'Zatvori'
    }).html(`
      <svg width="70" height="70" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.0188 29.6438C21.044 28.6187 22.706 28.6187 23.7312 29.6438L35.875 41.7877L48.0188 29.6438C49.044 28.6187 50.706 28.6187 51.7312 29.6438C52.7563 30.669 52.7563 32.331 51.7312 33.3562L37.7312 47.3562C36.706 48.3813 35.044 48.3813 34.0188 47.3562L20.0188 33.3562C18.9937 32.331 18.9937 30.669 20.0188 29.6438Z" fill="#4A4A4A"></path>
      </svg>
    `);

    // insert at the very top of header
    $head.prepend($btn);

    // hook click -> close
    $modal.on('click', '.ibb-modal__close-mobile', function(){
      closeModal($modal);
    });
  }

  /* ---------- hydrate JS state from server-rendered DOM ---------- */
  function hydrateFromDOM($wrap){
    var wid = $wrap.attr('data-ibb-id');
    var slots = [];
    $wrap.find('.ibb-slot').each(function(){
      var $slot = $(this);
      var pid = Number($slot.data('product-id')) || 0;
      if(pid){
        var img = $slot.find('img').attr('src') || '';
        slots.push({ product_id: pid, variation_id: 0, attr: {}, title: '', price_html: '', img: img });
      } else {
        slots.push(emptySlot());
      }
    });
    carts[wid] = slots;
  }

  /* ---------- init per builder ---------- */
  $('.ibb-wrapper').each(function(){
    var $wrap=$(this);
    if($wrap.data('ibbInit')) return;
    $wrap.data('ibbInit',true);

    var wid=uid();
    $wrap.attr('data-ibb-id',wid);

    var slots=parseInt($wrap.attr('data-slots'),10)||1;

    // Attach modal to body once
    var $modal=$('.ibb-modal').first();
    if(!$modal.data('ibbAttached')){ $modal.appendTo('body').data('ibbAttached',true); }

    // Inject mobile-only chevron close once
    ensureMobileClose($modal);

    // One-time: normalize titles (remove "Jedna " prefix)
    $modal.find('.ibb-card-title').each(function(){
      var $t = $(this);
      var txt = $t.text().trim();
      $t.text(txt.replace(/^Jedna\s+/i, ''));
    });

    // hydrate cart state from DOM (prefilled slots supported)
    hydrateFromDOM($wrap);

    // Initial render & ATC gate
    refreshSlots($wrap);
    enforceATC($wrap);

    // Keep ATC synced with Woo events
    $(document.body).on('found_variation reset_data show_variation wc_fragment_refresh wc_fragments_refreshed', function(){
      enforceATC($wrap);
    });

    // Guard against Woo toggling native button states
    var $native = $btn($wrap);
    if($native.length){
      var mo=new MutationObserver(function(){ enforceATC($wrap); });
      mo.observe($native[0], { attributes:true, attributeFilter:['disabled','class'] });
    }

    var activeIndex=null;

    // Combined renderer to minimize reflows
    function renderStepUI(){
      renderSteps($wrap,$modal,slots,activeIndex);
      preselectDefaultSizeS($modal);
      updateNavButtons($modal, activeIndex);
      scrollActiveStepIntoView($modal);
    }

    function gotoStep(idx){
      var $grid = $modal.find('.ibb-grid');
      var nextIndex = Math.max(0,Math.min(slots-1,Number(idx)||0));

      // If modal is not open yet, just render and open
      if(!$modal.hasClass('open')){
        activeIndex = nextIndex;
        renderStepUI();
        openModal($modal);
        return;
      }

      // If already open, animate content only (no re-open)
      var duration = 200; // matches your CSS fade
      activeIndex = nextIndex;

      $grid.addClass('is-fading');
      setTimeout(function(){
        window.requestAnimationFrame(function(){
          renderStepUI();
          requestAnimationFrame(function(){
            $grid.removeClass('is-fading');
          });
        });
      }, duration);
    }

    // open modal on slot click
    $wrap.on('click','.ibb-slot',function(){ gotoStep($(this).data('index')); });
    $modal.on('click','.ibb-step',function(){ gotoStep($(this).data('index')); });
    $modal.on('click','.ibb-prev',function(){ if(activeIndex===null)return; gotoStep(activeIndex-1); });
    $modal.on('click','.ibb-next',function(){ if(activeIndex===null)return; gotoStep(activeIndex+1); });
    $modal.on('click','.ibb-modal__close',function(){ closeModal($modal); });

    // remove from slot
    $wrap.on('click','.ibb-slot-remove',function(e){
      e.stopPropagation();
      var idx=Number($(this).closest('.ibb-slot').data('index'))||0;
      carts[wid][idx]=emptySlot();
      refreshSlots($wrap);
      enforceATC($wrap);
      if(activeIndex !== null){
        updateNavButtons($modal, activeIndex);
        scrollActiveStepIntoView($modal);
      }
    });

    // add to slot
    $modal.on('click','.ibb-add',function(){
      if(activeIndex===null)return;
      var $card=$(this).closest('.ibb-card');
      var pid=Number($card.data('id'));
      var type=String($card.data('type')||'');
      var title=$card.find('.ibb-card-title').text().trim();
      var img=$card.find('img').attr('src')||'';
      var price=$card.find('.ibb-card-price').html()||'';

      function finishSave(obj){
        carts[wid][activeIndex]=obj;
        refreshSlots($wrap);
        enforceATC($wrap);

        var next=-1;
        for(var i=activeIndex+1;i<carts[wid].length;i++){
          if(!carts[wid][i].product_id){ next=i; break; }
        }
        if(next>-1){
          gotoStep(next);
        } else {
          closeModal($modal);
        }
      }

      if(type==='variable'){
        var attrs={}; var ok=true;
        $card.find('.ibb-attr').each(function(){
          var val=$(this).val(); var key=$(this).data('taxonomy');
          if(!val) ok=false; attrs[key]=val;
        });
        if(!ok){ $card.find('.ibb-msg').text('Vyberte variantu.'); return; }

        $.post(IBB.ajax,{action:'ibb_find_variation',nonce:IBB.nonce,product_id:pid,attributes:attrs},function(r){
          if(!r||!r.success||!r.data||!r.data.variation_id){
            $card.find('.ibb-msg').text(r&&r.data&&r.data.message?r.data.message:'Tata varijanta nije dostupna.');
            return;
          }
          finishSave({product_id:pid,variation_id:r.data.variation_id,attr:attrs,title:title,price_html:r.data.price||price,img:img});
        },'json').fail(function(){ $card.find('.ibb-msg').text('Server error.'); });

      } else {
        finishSave({product_id:pid,variation_id:0,attr:{},title:title,price_html:price,img:img});
      }
    });

  });

  /* ---------- SLOT/CART CONTENT LOGGING + ATC mirror toggle ---------- */
  $(document).on('ibb:slotsFilled ibb:slotsNotFilled', '.ibb-wrapper', function(e, data){
    var wid   = $(this).attr('data-ibb-id');
    var slots = (window.IBB && window.IBB.carts && window.IBB.carts[wid]) || [];

    // Console logging of slot/cart content
    console.log('Event:', e.type);
    console.log('Wrapper ID:', wid);
    console.log('Slots:', slots);
    if (data) console.log('Extra data:', data);

    // Also mirror the ATC state change using your exact snippet style
    var $btn = $('.single_add_to_cart_button');
    if ($btn.length) {
      if (e.type === 'ibb:slotsFilled') {
        $btn.prop('disabled', false).removeClass('ibb-disabled');
      } else {
        $btn.prop('disabled', true).addClass('ibb-disabled');
      }
    }
  });

});
