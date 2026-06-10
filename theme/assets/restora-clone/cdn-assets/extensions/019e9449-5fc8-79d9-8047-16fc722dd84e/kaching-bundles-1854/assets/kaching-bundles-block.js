(function() {
  try {
    if (typeof document != "undefined") {
      var Gt = document.createElement("style");
      Gt.id = "kaching-bundles-styles", Gt.appendChild(document.createTextNode(`.kaching-bundles__multiple-gifts-selector{position:relative}.kaching-bundles__multiple-gifts-selector__clickable-overlay{position:absolute;inset:0;cursor:pointer}.kaching-bundles .kaching-bundles__bundle-products{display:flex;justify-content:space-evenly;margin-top:12px;margin-bottom:4px;border:1px solid var(--bar-border-color, rgba(0, 0, 0, .3));border-radius:calc(var(--bar-border-radius, 0) * 3 / 4)}.kaching-bundles .kaching-bundles__bundle-products .kaching-bundles__bar-variant-selects{justify-content:center}.kaching-bundles .kaching-bundles__bundle-products__divider{display:flex;flex-direction:column;align-items:center;width:0;overflow:visible}.kaching-bundles .kaching-bundles__bundle-products__divider *{max-width:initial}.kaching-bundles .kaching-bundles__bundle-products__divider-line{display:flex;flex:1;width:1px;background-color:var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__bundle-products__divider-icon{display:flex}.kaching-bundles .kaching-bundles__bundle-products__divider-icon svg{color:var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__bundle-products__product{display:flex;flex:1;flex-direction:column;align-items:center;min-width:0;gap:5px;padding:12px}.kaching-bundles .kaching-bundles__bundle-products__product.kaching-bundles__bundle-products__product--placeholder{justify-content:center;text-align:center;font-size:13px;font-weight:700;color:#555}.kaching-bundles .kaching-bundles__bundle-products__wrapper{display:flex;align-items:center;gap:10px;min-width:0}.kaching-bundles .kaching-bundles__bundle-products__content{display:flex;flex-direction:column;align-items:flex-start;min-width:0}.kaching-bundles .kaching-bundles__bundle-products__link{display:flex;flex-shrink:0;text-decoration:none}.kaching-bundles .kaching-bundles__bundle-products__image{flex-shrink:0;height:50px;width:auto;max-width:100%;border-radius:var(--kaching-bundle-products-image-border-radius, 0)}.kaching-bundles .kaching-bundles__bundle-products__image-placeholder{flex-shrink:0;height:50px;width:50px}.kaching-bundles .kaching-bundles__bundle-products__title{overflow-wrap:break-word;text-align:center;font-size:13px;color:var(--bar-title-color);font-weight:var(--bar-title-font-weight, 700);font-style:var(--bar-title-font-style)}.kaching-bundles .kaching-bundles__bundle-products__pricing{display:flex;flex-shrink:0;flex-wrap:wrap;justify-content:center;align-items:baseline;gap:5px}.kaching-bundles .kaching-bundles__bundle-products__price{font-size:13px;font-weight:700;color:var(--bar-price-color, #000)}.kaching-bundles .kaching-bundles__bundle-products__full-price{text-decoration:line-through;font-size:12px;color:var(--bar-full-price-color, #555)}.kaching-bundles .kaching-bundles__bundle-products__unit-price{width:100%;text-align:center;font-size:12px;color:var(--bar-full-price-color, #555);text-transform:uppercase}.kaching-bundles .kaching-bundles__bundle-products--hidden{display:none}.kaching-bundles .kaching-bundles__bundle-products--vertical{flex-direction:column}.kaching-bundles .kaching-bundles__bundle-products--vertical .kaching-bundles__bundle-products__divider{flex-direction:row;width:100%;height:0}.kaching-bundles .kaching-bundles__bundle-products--vertical .kaching-bundles__bundle-products__divider-line{width:auto;height:1px}.kaching-bundles .kaching-bundles__bundle-products--vertical .kaching-bundles__bundle-products__product{flex-direction:row;justify-content:space-between;padding:14px 12px}.kaching-bundles .kaching-bundles__bundle-products--vertical .kaching-bundles__bundle-products__pricing{flex-direction:column;align-items:flex-end}.kaching-bundles .kaching-bundles__bundle-products--vertical .kaching-bundles__bundle-products__pricing--with-unit-price{flex-flow:row wrap;justify-content:flex-end}.kaching-bundles .kaching-bundles__bundle-products--vertical .kaching-bundles__bundle-products__unit-price{text-align:end}.kaching-bundles .kaching-bundles__bundle-products--vertical .kaching-bundles__bundle-products__title{text-align:start}.kaching-bundles .kaching-bundles__bundle-products--vertical .kaching-bundles__bundle-products__image{width:50px;height:auto;-o-object-fit:contain;object-fit:contain}.kaching-bundles .kaching-bundles__bundle-products--vertical .kaching-bundles__bar-variant-selects{justify-content:flex-start}.kaching-bundles .kaching-bundles__mix-and-match-products{display:flex;flex-direction:column;margin-top:12px;margin-bottom:4px;border:1px solid var(--bar-border-color, rgba(0, 0, 0, .3));border-radius:calc(var(--bar-border-radius, 0) * 3 / 4);overflow:hidden}.kaching-bundles .kaching-bundles__mix-and-match-products__divider{display:flex;flex-direction:row;align-items:center;gap:4px;width:100%;height:0;overflow:visible}.kaching-bundles .kaching-bundles__mix-and-match-products__divider-line{display:flex;flex:1;width:auto;height:1px;background-color:var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__mix-and-match-products__divider-icon{display:flex}.kaching-bundles .kaching-bundles__mix-and-match-products__divider-icon svg{color:var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__mix-and-match-product{display:grid;grid-template-columns:auto minmax(0,1fr) auto;gap:12px;align-items:center;padding:12px}.kaching-bundles .kaching-bundles__mix-and-match-product__content{display:flex;flex-direction:column;gap:6px;min-width:0}.kaching-bundles .kaching-bundles__mix-and-match-product__image-link{display:flex;flex-shrink:0;text-decoration:none}.kaching-bundles .kaching-bundles__mix-and-match-product__image{flex-shrink:0;height:50px;width:auto;max-width:100%;border-radius:var(--kaching-bundle-products-image-border-radius, 0)}.kaching-bundles .kaching-bundles__mix-and-match-product__image-placeholder{height:50px;width:50px}.kaching-bundles .kaching-bundles__mix-and-match-product__title-link{align-self:flex-start;text-decoration:none}.kaching-bundles .kaching-bundles__mix-and-match-product__title{overflow-wrap:break-word;text-align:start;font-size:13px;color:var(--bar-title-color);font-weight:var(--bar-title-font-weight, 700);font-style:var(--bar-title-font-style)}.kaching-bundles .kaching-bundles__mix-and-match-product__swap-button{display:inline-flex;align-items:center;justify-content:center;padding:8px 12px;border-radius:var(--bar-border-radius, 8px);background-color:var(--collection-product-button-color, #2b2b2b);color:var(--collection-product-button-text-color, #ffffff);font-size:13px;line-height:1.2;text-align:center;cursor:pointer;white-space:nowrap}.kaching-bundles .kaching-bundles__mix-and-match-products__placeholder{display:flex;align-items:center;justify-content:center;padding:14px 12px;color:#0006;font-style:italic}.kaching-bundles .kaching-bundles__checkbox-upsells__upsell .kaching-bundles__bar-main{gap:10px}.kaching-bundles .kaching-bundles__checkbox-upsells__upsell .kaching-bundles__selling-plan-select{margin-top:5px}.kaching-bundles .kaching-bundles__checkbox-upsells__checkbox{all:unset;display:flex;flex-shrink:0;width:20px;height:20px;align-items:center;justify-content:center;cursor:pointer;background-color:#fff;color:var(--bar-selected-border-color);border-width:2px;border-style:solid;border-color:var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__checkbox-upsells__checkbox.kaching-bundles__checkbox-upsells__checkbox--selected{border-color:var(--bar-selected-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__checkbox-upsells__image{width:initial;max-width:50px;max-height:50px;border-radius:calc(var(--bar-border-radius, 0) / 2)}.kaching-bundles .kaching-bundles__choose-multiple-gifts-modal{position:fixed;z-index:9999;inset:0;display:flex;align-items:center;justify-content:center;padding:10px;text-align:start;line-height:1.4;background-color:var(--kaching-choose-multiple-gifts-overlay-color, rgba(0, 0, 0, .5))}.kaching-bundles .kaching-bundles__choose-multiple-gifts-modal__content{position:relative;z-index:10000;min-width:min(470px,95%);max-width:700px;max-height:calc(100dvh - 20px);width:100%;display:flex;flex-direction:column}.kaching-bundles .kaching-bundles__choose-multiple-gifts{display:flex;flex-direction:column;border-radius:10px;background-color:#fff;max-height:100%;overflow:hidden}.kaching-bundles .kaching-bundles__choose-multiple-gifts__header{display:flex;align-items:center;justify-content:space-between;padding:16px 16px 0;margin-block:2px 18px;color:var(--kaching-choose-multiple-gifts-text-color, #000);flex-shrink:0}.kaching-bundles .kaching-bundles__choose-multiple-gifts__heading{margin:0;font-weight:650;font-size:16px}.kaching-bundles .kaching-bundles__choose-multiple-gifts__close{all:unset;display:flex;align-items:center;justify-content:center;margin-inline-end:-6px;width:24px;height:24px;cursor:pointer}.kaching-bundles .kaching-bundles__choose-multiple-gifts__products{display:flex;flex-direction:column;gap:16px;padding:0 16px;flex:1;overflow-y:auto;min-height:0}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product{display:flex;align-items:center;justify-content:space-between;gap:20px}@media (width <= 600px){.kaching-bundles .kaching-bundles__choose-multiple-gifts__product{gap:12px}}@media (width <= 500px){.kaching-bundles .kaching-bundles__choose-multiple-gifts__product{flex-direction:column;align-items:stretch;gap:12px}}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-container{display:flex;align-items:center;gap:12px;min-width:0;flex:1}@media (width <= 600px){.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-container{gap:8px}}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-image-link{display:flex;flex-shrink:0}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-image{display:flex;border-radius:8px;border:1px solid #e5e5e3;-o-object-fit:contain;object-fit:contain;height:auto;width:var(--kaching-choose-multiple-gifts-photo-size, 100px);max-height:calc(var(--kaching-choose-multiple-gifts-photo-size, 100px) * 2)}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-content{display:flex;flex-direction:column;gap:4px;min-width:0}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-link{text-decoration:none}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-title{overflow-wrap:break-word;font-weight:650;font-size:var(--kaching-choose-multiple-gifts-text-size, 14px);color:var(--kaching-choose-multiple-gifts-text-color, #000)}.kaching-bundles .kaching-bundles__choose-multiple-gifts__variant-selectors{display:flex;flex-direction:column;gap:8px;margin-top:8px;min-width:0;max-width:100%}.kaching-bundles .kaching-bundles__choose-multiple-gifts__variant-selector-row{display:flex;align-items:flex-start;gap:8px}.kaching-bundles .kaching-bundles__choose-multiple-gifts__variant-counter{display:flex;align-items:center;justify-content:center;flex-shrink:0;min-width:24px;height:24px;font-size:12px;color:#000}.kaching-bundles .kaching-bundles__choose-multiple-gifts__variant-selector-content{flex:1;min-width:0}.kaching-bundles .kaching-bundles__choose-multiple-gifts__variant-selector-with-counter{display:flex;align-items:center;gap:8px;min-width:0}.kaching-bundles .kaching-bundles__choose-multiple-gifts__variant-selector-wrapper{flex:1;min-width:0}.kaching-bundles .kaching-bundles__choose-multiple-gifts__subtitle{font-size:14px;font-weight:400;color:var(--kaching-choose-multiple-gifts-text-color, #000)}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-price-container{display:flex;gap:10px}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-price{font-size:14px;font-weight:650;color:var(--kaching-choose-multiple-gifts-price-color, #f04438)}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-compare-at-price{font-size:14px;font-weight:650;text-decoration:line-through;color:var(--kaching-choose-multiple-gifts-compare-at-price-color, #667085)}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-button{-webkit-appearance:none;-moz-appearance:none;appearance:none;flex-shrink:0;display:flex;justify-content:center;align-items:center;border:none;font-weight:600;padding:10px 12px;line-height:1.4;border-radius:8px;cursor:pointer;font-size:var(--kaching-choose-multiple-gifts-button-size, 16px);background-color:var(--kaching-choose-multiple-gifts-button-color, #7f56d9);color:var(--kaching-choose-multiple-gifts-button-text-color, #fff)}@media (width <= 500px){.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-button{flex:1}}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-button--disabled{background-color:#eaecf0;color:#98a2b3;cursor:not-allowed}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-button--selected{display:flex;align-items:center;gap:8px;background-color:#fff;color:#414651;border:1px solid #d5d7da}.kaching-bundles .kaching-bundles__choose-multiple-gifts__footer{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:24px;margin-top:16px;padding:16px;border-top:1px solid #e5e5e3;flex-shrink:0}.kaching-bundles .kaching-bundles__choose-multiple-gifts__footer-text{font-size:14px;font-weight:400;color:#535862;white-space:nowrap}.kaching-bundles .kaching-bundles__choose-multiple-gifts__footer-buttons{display:flex;gap:8px;flex:1;min-width:0}.kaching-bundles .kaching-bundles__choose-multiple-gifts__footer-button{-webkit-appearance:none;-moz-appearance:none;appearance:none;border:none;height:40px;min-width:80px;font-size:14px;font-weight:600;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex:1;box-shadow:0 1px 2px #0a0d120d}.kaching-bundles .kaching-bundles__choose-multiple-gifts__footer-button--cancel{background-color:#fff;border:1px solid #d5d7da;color:#414651}.kaching-bundles .kaching-bundles__choose-multiple-gifts__footer-button--confirm{background-color:#000;color:#fff}.kaching-bundles .kaching-bundles__choose-multiple-gifts__footer-button--confirm:disabled{background-color:#eaecf0;border:1px solid #e9eaeb;color:#98a2b3;cursor:not-allowed}.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-actions{display:flex;align-items:center;gap:12px;flex-shrink:0}@media (width <= 600px){.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-actions{gap:8px}}@media (width <= 500px){.kaching-bundles .kaching-bundles__choose-multiple-gifts__product-actions{flex-direction:row-reverse;justify-content:space-between;flex-shrink:1}}.kaching-bundles .kaching-bundles__choose-multiple-gifts__gift-quantity{display:flex;align-items:center;justify-content:space-between;width:72px;height:42px;border:1px solid #d6d6d6;border-radius:8px;overflow:hidden}.kaching-bundles .kaching-bundles__choose-multiple-gifts__gift-quantity-button{all:unset;display:flex;align-items:center;justify-content:center;width:28px;height:100%;cursor:pointer;color:#424242}.kaching-bundles .kaching-bundles__choose-multiple-gifts__gift-quantity-button[aria-disabled=true]{opacity:.4;cursor:not-allowed}.kaching-bundles .kaching-bundles__choose-multiple-gifts__gift-quantity-button img{filter:brightness(0) saturate(100%) invert(24%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(96%) contrast(89%)}.kaching-bundles .kaching-bundles__choose-multiple-gifts__gift-quantity-value{font-size:14px;font-weight:600;color:#414651}body:has(.kaching-bundles__choose-multiple-gifts-modal){overflow:hidden}.kaching-bundles .kaching-bundles__mix-and-match-choose-product-modal{position:fixed;z-index:9999;inset:0;display:flex;align-items:center;overflow-y:auto;padding:10px;text-align:start;line-height:1.4;background-color:var(--kaching-mix-and-match-choose-product-overlay-color, rgba(0, 0, 0, .5))}.kaching-bundles .kaching-bundles__mix-and-match-choose-product-modal__content{position:relative;z-index:10000;margin:auto;min-width:min(470px,95%);max-width:700px;width:100%}.kaching-bundles .kaching-bundles__mix-and-match-choose-product{display:flex;flex-direction:column;padding:16px;border-radius:10px;background-color:#fff}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__header{display:flex;align-items:center;justify-content:space-between;margin-block:2px 18px;color:var(--kaching-mix-and-match-choose-product-text-color, #000)}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__heading{margin:0;font-weight:650;font-size:16px}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__close{all:unset;display:flex;align-items:center;justify-content:center;margin-inline-end:-6px;width:24px;height:24px;cursor:pointer}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__products{display:flex;flex-direction:column;gap:16px}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__empty-state{display:flex;flex-direction:column;align-items:center;text-align:center;color:#4b5565}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product{display:flex;align-items:center;justify-content:space-between;gap:20px}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-container{display:flex;align-items:center;gap:12px;min-width:0}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-image-link{display:flex;flex-shrink:0}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-image{display:flex;border-radius:8px;border:1px solid #e5e5e3;-o-object-fit:contain;object-fit:contain;height:auto;width:var(--kaching-mix-and-match-choose-product-photo-size, 100px);max-height:calc(var(--kaching-mix-and-match-choose-product-photo-size, 100px) * 2)}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-content{display:flex;flex-direction:column;gap:4px;min-width:0}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-link{text-decoration:none}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-title{overflow-wrap:break-word;font-weight:650;font-size:var(--kaching-mix-and-match-choose-product-text-size, 14px);color:var(--kaching-mix-and-match-choose-product-text-color, #000)}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__subtitle{font-size:14px;font-weight:400;color:var(--kaching-mix-and-match-choose-product-text-color, #000)}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-price-container{display:flex;gap:10px}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-price{font-size:14px;font-weight:650;color:var(--kaching-mix-and-match-choose-product-price-color, #f04438)}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-compare-at-price{font-size:14px;font-weight:650;text-decoration:line-through;color:var(--kaching-mix-and-match-choose-product-compare-at-price-color, #667085)}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-option-names.kaching-bundles__bar-variant-names{color:inherit;margin-block:0}.kaching-bundles .kaching-bundles__mix-and-match-choose-product__product-button{-webkit-appearance:none;-moz-appearance:none;appearance:none;flex-shrink:0;border:none;font-weight:600;padding:12px;line-height:1.2;border-radius:8px;cursor:pointer;font-size:var(--kaching-mix-and-match-choose-product-button-size, 16px);background-color:var(--kaching-mix-and-match-choose-product-button-color, #7f56d9);color:var(--kaching-mix-and-match-choose-product-button-text-color, #fff)}body:has(.kaching-bundles__mix-and-match-choose-product-modal){overflow:hidden}.kaching-bundles .kaching-bundles__bar-collection-products{display:flex;flex-direction:column;gap:5px;margin-top:5px}.kaching-bundles .kaching-bundles__collection-product{display:flex;gap:16px;align-items:center;justify-content:space-between}.kaching-bundles .kaching-bundles__collection-product .kaching-bundles__bar-variant-names{display:none;margin-block:0}.kaching-bundles .kaching-bundles__collection-product__image--default{background-color:#fff;border:1px solid #e9e9e9;color:#000}.kaching-bundles .kaching-bundles__collection-product--require-selection{padding:8px;border-radius:12px;background-color:var(--kaching-collection-breaks-require-selection-background-color)}.kaching-bundles .kaching-bundles__collection-product--require-selection .kaching-bundles__collection-product__image--default{border-color:var(--kaching-collection-breaks-require-selection-text-color);color:var(--kaching-collection-breaks-require-selection-text-color)}.kaching-bundles .kaching-bundles__collection-breaks-alert{display:flex;align-items:center;gap:8px;margin-top:10px;padding:8px 12px;border-radius:12px;font-size:12px;background-color:var(--kaching-collection-breaks-require-selection-background-color);color:var(--kaching-collection-breaks-require-selection-text-color)}.kaching-bundles .kaching-bundles__collection-breaks-alert__icon{flex-shrink:0;width:16px;height:16px}.kaching-bundles .kaching-bundles__collection-product__main{display:flex;gap:16px;align-items:center;min-width:0}.kaching-bundles .kaching-bundles__collection-product__content{display:flex;flex-direction:column;gap:3px;min-width:0}.kaching-bundles .kaching-bundles__collection-product__link{display:flex;flex-shrink:0;text-decoration:none}.kaching-bundles .kaching-bundles__collection-product__image{flex-shrink:0;-o-object-fit:contain;object-fit:contain;height:auto;width:var(--kaching-collection-breaks-product-photo-size, 40px);border-radius:var(--kaching-collection-breaks-image-border-radius, 0)}.kaching-bundles .kaching-bundles__collection-product__title{font-size:16px;color:var(--kaching-collection-breaks-product-title-color, #000)}.kaching-bundles .kaching-bundles__collection-product__choose-product-image{cursor:pointer;line-height:0}.kaching-bundles .kaching-bundles__collection-product__choose-product-button{cursor:pointer;color:#fff;font-size:12px;line-height:1.4;padding:6px 14px;border-radius:8px;background-color:var(--kaching-collection-breaks-button-color, #333)}.kaching-bundles .kaching-bundles__collection-product__remove-button{display:flex;align-items:center;justify-content:center;height:24px;width:24px;cursor:pointer}.kaching-bundles .kaching-bundles__choose-product-modal{position:fixed;z-index:9999;inset:0;display:flex;align-items:center;overflow-y:auto;padding:10px;text-align:start;line-height:1.4;background-color:var(--kaching-choose-product-overlay-color, rgba(0, 0, 0, .5))}.kaching-bundles .kaching-bundles__choose-product-modal__content{position:relative;z-index:10000;margin:auto;min-width:min(470px,95%);max-width:700px;width:100%}.kaching-bundles .kaching-bundles__choose-product{display:flex;flex-direction:column;padding:16px;border-radius:10px;background-color:#fff}.kaching-bundles .kaching-bundles__choose-product__header{display:flex;align-items:center;justify-content:space-between;margin-block:2px 18px;color:var(--kaching-choose-product-text-color, #000)}.kaching-bundles .kaching-bundles__choose-product__heading{margin:0;font-weight:650;font-size:16px}.kaching-bundles .kaching-bundles__choose-product__close{all:unset;display:flex;align-items:center;justify-content:center;margin-inline-end:-6px;width:24px;height:24px;cursor:pointer}.kaching-bundles .kaching-bundles__choose-product__products{display:flex;flex-direction:column;gap:16px}.kaching-bundles .kaching-bundles__choose-product__controls{display:flex;align-items:center;gap:10px;margin-bottom:14px}.kaching-bundles .kaching-bundles__choose-product__search-field{position:relative;flex:1 1 auto;min-width:0}.kaching-bundles .kaching-bundles__choose-product__search-icon{position:absolute;top:50%;left:12px;transform:translateY(-50%);width:16px;height:16px;pointer-events:none}.kaching-bundles .kaching-bundles__choose-product__search-input{box-sizing:border-box;width:100%;padding:10px 12px 10px 36px;border:1px solid #d5d7da;border-radius:8px;font-size:14px;color:var(--kaching-choose-product-text-color, #000);background-color:#fff}.kaching-bundles .kaching-bundles__choose-product__sort{position:relative;flex-shrink:0}.kaching-bundles .kaching-bundles__choose-product__sort-button{display:inline-flex;align-items:center;gap:8px;padding:10px 12px;border:1px solid #d5d7da;border-radius:8px;background:#fff;color:var(--kaching-choose-product-text-color, #000);font-size:14px;line-height:1;cursor:pointer}.kaching-bundles .kaching-bundles__choose-product__sort-icon{width:16px;height:16px;display:block}.kaching-bundles .kaching-bundles__choose-product__sort-menu{position:absolute;top:calc(100% + 6px);right:0;z-index:2;min-width:210px;display:flex;flex-direction:column;border:1px solid #d5d7da;border-radius:10px;background:#fff;box-shadow:0 8px 24px #10182824;overflow:hidden}.kaching-bundles .kaching-bundles__choose-product__sort-option{display:flex;align-items:center;justify-content:space-between;gap:12px;border:none;background:#fff;text-align:start;padding:10px 12px;font-size:14px;color:var(--kaching-choose-product-text-color, #000);cursor:pointer}.kaching-bundles .kaching-bundles__choose-product__sort-option-check{flex-shrink:0;width:16px;height:16px;display:block}.kaching-bundles .kaching-bundles__choose-product__sort-option:hover{background:#f8fafc}.kaching-bundles .kaching-bundles__choose-product__empty-state{display:flex;flex-direction:column;align-items:center;text-align:center;color:#4b5565}.kaching-bundles .kaching-bundles__choose-product__empty-state-icon-wrapper{display:flex;align-items:center;justify-content:center;width:48px;height:48px;margin-bottom:16px}.kaching-bundles .kaching-bundles__choose-product__empty-state-icon{width:48px;height:48px}.kaching-bundles .kaching-bundles__choose-product__empty-state-title{font-size:18px;font-weight:500;color:#181d27}.kaching-bundles .kaching-bundles__choose-product__empty-state-description{margin-top:8px;font-size:14px;color:#535862}.kaching-bundles .kaching-bundles__choose-product__empty-state-clear-button{margin-top:16px;padding:10px 16px;border:1px solid #d5d7da;border-radius:8px;background:#fff;color:#414651;font-size:14px;font-weight:600}.kaching-bundles .kaching-bundles__choose-product__product{display:flex;align-items:center;justify-content:space-between;gap:20px}.kaching-bundles .kaching-bundles__choose-product__product-container{display:flex;align-items:center;gap:12px;min-width:0}.kaching-bundles .kaching-bundles__choose-product__product-image-link{display:flex;flex-shrink:0}.kaching-bundles .kaching-bundles__choose-product__product-image{display:flex;border-radius:8px;border:1px solid #e5e5e3;-o-object-fit:contain;object-fit:contain;height:auto;width:var(--kaching-choose-product-photo-size, 100px);max-height:calc(var(--kaching-choose-product-photo-size, 100px) * 2)}.kaching-bundles .kaching-bundles__choose-product__product-content{display:flex;flex-direction:column;gap:4px;min-width:0}.kaching-bundles .kaching-bundles__choose-product__product-link{text-decoration:none}.kaching-bundles .kaching-bundles__choose-product__product-title{overflow-wrap:break-word;font-weight:650;font-size:var(--kaching-choose-product-text-size, 14px);color:var(--kaching-choose-product-text-color, #000)}.kaching-bundles .kaching-bundles__choose-product__subtitle{font-size:14px;font-weight:400;color:var(--kaching-choose-product-text-color, #000)}.kaching-bundles .kaching-bundles__choose-product__product-price-container{display:flex;gap:10px}.kaching-bundles .kaching-bundles__choose-product__product-price{font-size:14px;font-weight:650;color:var(--kaching-choose-product-price-color, #f04438)}.kaching-bundles .kaching-bundles__choose-product__product-compare-at-price{font-size:14px;font-weight:650;text-decoration:line-through;color:var(--kaching-choose-product-compare-at-price-color, #667085)}.kaching-bundles .kaching-bundles__choose-product__product-option-names.kaching-bundles__bar-variant-names{color:inherit;margin-block:0}.kaching-bundles .kaching-bundles__choose-product__product-button{-webkit-appearance:none;-moz-appearance:none;appearance:none;flex-shrink:0;border:none;font-weight:600;padding:12px;line-height:1.2;border-radius:8px;cursor:pointer;font-size:var(--kaching-choose-product-button-size, 16px);background-color:var(--kaching-choose-product-button-color, #7f56d9);color:var(--kaching-choose-product-button-text-color, #fff)}body:has(.kaching-bundles__choose-product-modal){overflow:hidden}.kaching-bundles .kaching-bundles__free-gift{display:flex;align-items:center;justify-content:space-between;margin-inline:1px;padding-block:7px;padding-inline:8px calc(15px * var(--block-spacing, 1) + 5px);gap:5px 10px;background-color:var(--kaching-free-gift-background-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__free-gift:last-child{margin-block-end:1px;border-end-start-radius:calc(var(--bar-border-radius) - 1px);border-end-end-radius:calc(var(--bar-border-radius) - 1px)}.kaching-bundles .kaching-bundles__free-gift.kaching-bundles__free-gift--out-of-stock{opacity:.3}.kaching-bundles .kaching-bundles__free-gift__link{pointer-events:none}.kaching-bundles .kaching-bundles__free-gift__main{display:flex;align-items:center;gap:calc(5px + 5px * var(--block-spacing, 1));min-width:0;flex:1}.kaching-bundles .kaching-bundles__free-gift__main:has(.kaching-bundles__swatch-buttons){overflow-x:auto}.kaching-bundles .kaching-bundles__free-gift__content{display:flex;align-items:center;gap:5px 15px;flex-wrap:wrap;min-width:0;flex:1}.kaching-bundles .kaching-bundles__free-gift__content--clickable{cursor:pointer}.kaching-bundles .kaching-bundles__free-gift__add-button{all:unset;display:flex;cursor:pointer;line-height:0;padding:4px;margin:-4px -4px -4px -6px;color:var(--kaching-free-gift-text-color, #000)}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__free-gift__add-button{color:var(--kaching-free-gift-selected-text-color, #fff)}.kaching-bundles .kaching-bundles__free-gift__text{color:var(--kaching-free-gift-text-color, #000);font-size:var(--kaching-free-gift-font-size, 13px);font-weight:var(--kaching-free-gift-font-weight, bold);font-style:var(--kaching-free-gift-font-style, normal)}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__free-gift__text{color:var(--kaching-free-gift-selected-text-color, #fff)}.kaching-bundles .kaching-bundles__free-gift__image{display:flex;flex-shrink:0;width:auto;height:var(--kaching-free-gift-image-height, 30px);border-radius:var(--kaching-free-gift-image-border-radius, 0)}.kaching-bundles .kaching-bundles__free-gift__full-price{flex-shrink:0;text-decoration:line-through;font-size:calc(var(--kaching-free-gift-font-size, 13px) - 1px);font-weight:var(--bar-subtitle-font-weight);font-style:var(--bar-subtitle-font-style);color:var(--kaching-free-gift-text-color, #000)}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__free-gift__full-price{color:var(--kaching-free-gift-selected-text-color, #fff)}.kaching-bundles .kaching-bundles__free-gift__divider{height:1px;display:flex}.kaching-bundles .kaching-bundles__upsell{display:flex;align-items:center;justify-content:space-between;padding-block:7px;padding-inline:8px calc(15px * var(--block-spacing, 1) + 5px);margin-inline:1px;gap:5px 10px;background-color:var(--kaching-upsell-background-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__upsell:last-child{margin-block-end:1px;border-end-start-radius:calc(var(--bar-border-radius) - 1px);border-end-end-radius:calc(var(--bar-border-radius) - 1px)}.kaching-bundles .kaching-bundles__upsell.kaching-bundles__upsell--out-of-stock{opacity:.3}.kaching-bundles .kaching-bundles__upsell__main{display:flex;align-items:center;gap:calc(5px + 5px * var(--block-spacing, 1));min-width:0;flex:1}.kaching-bundles .kaching-bundles__upsell__content{display:flex;align-items:center;gap:5px 15px;flex-wrap:wrap;min-width:0;flex:1}.kaching-bundles .kaching-bundles__upsell__link{display:flex;flex-shrink:0}.kaching-bundles .kaching-bundles__upsell__image{width:auto;height:var(--kaching-upsell-image-height, 30px);border-radius:var(--kaching-upsell-image-border-radius, 0)}.kaching-bundles .kaching-bundles__upsell__checkbox{all:unset;display:flex;flex-shrink:0;width:16px;height:16px;align-items:center;justify-content:center;cursor:pointer;background-color:#fff;margin-inline-end:4px;color:var(--bar-selected-border-color);border-width:2px;border-style:solid;border-color:var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__upsell__checkbox.kaching-bundles__upsell__checkbox--selected{border-color:var(--bar-selected-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__upsell__text{display:flex;min-height:30px;align-items:center;cursor:pointer;overflow-wrap:break-word;color:var(--kaching-upsell-text-color, #000);font-size:var(--kaching-upsell-font-size, 13px);font-weight:var(--kaching-upsell-font-weight, bold);font-style:var(--kaching-upsell-font-style, normal)}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__upsell__text{color:var(--kaching-upsell-selected-text-color, #000)}.kaching-bundles .kaching-bundles__upsell__pricing{align-items:flex-end;display:flex;flex-direction:column;flex-shrink:0}.kaching-bundles .kaching-bundles__upsell__pricing-row{display:flex;align-items:baseline;gap:6px}.kaching-bundles .kaching-bundles__upsell__price{font-size:var(--kaching-upsell-font-size, 13px);font-weight:var(--bar-title-font-weight);font-style:var(--bar-title-font-style);color:var(--bar-price-color, #000)}.kaching-bundles .kaching-bundles__upsell__pricing-row--secondary .kaching-bundles__upsell__price{font-size:calc(var(--kaching-upsell-font-size, 13px) - 1px)}.kaching-bundles .kaching-bundles__upsell__full-price,.kaching-bundles .kaching-bundles__upsell__unit-price{font-size:calc(var(--kaching-upsell-font-size, 13px) - 1px);font-weight:var(--bar-subtitle-font-weight);font-style:var(--bar-subtitle-font-style);color:var(--bar-full-price-color, #555)}.kaching-bundles .kaching-bundles__upsell__full-price{text-decoration:line-through}.kaching-bundles .kaching-bundles__upsell__unit-price{text-transform:uppercase}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__free-gift{flex-direction:column;padding-inline-end:8px}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__upsell{flex-direction:column}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__upsell__pricing{flex-direction:row;gap:5px;align-items:center}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__free-gift{margin-inline:2px;padding-block:7px 6px;padding-inline:7px calc(15px * var(--block-spacing, 1) + 4px);background-color:var(--kaching-free-gift-selected-background-color, #000)}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__free-gift:last-child{margin-block-end:2px;border-end-start-radius:calc(var(--bar-border-radius) - 2px);border-end-end-radius:calc(var(--bar-border-radius) - 2px)}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__upsell{margin-inline:2px;padding-block:7px 6px;padding-inline:7px calc(15px * var(--block-spacing, 1) + 4px);background-color:var(--kaching-upsell-selected-background-color, rgba(0, 0, 0, .2))}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__upsell:last-child{margin-block-end:2px;border-end-start-radius:calc(var(--bar-border-radius) - 2px);border-end-end-radius:calc(var(--bar-border-radius) - 2px)}.kaching-bundles .kaching-bundles__deal-bar-progressive-gifts{border-end-start-radius:var(--bar-border-radius);border-end-end-radius:var(--bar-border-radius)}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift{display:flex;align-items:center;justify-content:space-between;margin-inline:1px;padding-block:7px;padding-inline:8px calc(15px * var(--block-spacing, 1) + 5px);gap:5px 10px;background-color:var(--bar-border-color, #fff)}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift:last-child{margin-block-end:1px;border-end-start-radius:calc(var(--bar-border-radius) - 1px);border-end-end-radius:calc(var(--bar-border-radius) - 1px)}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__link{pointer-events:none}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__main{display:flex;align-items:center;gap:calc(5px + 5px * var(--block-spacing, 1));min-width:0;flex:1}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__main:has(.kaching-bundles__swatch-buttons){overflow-x:auto}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__content{display:flex;align-items:center;gap:5px 15px;flex-wrap:wrap;min-width:0;flex:1}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__image{display:flex;flex-shrink:0;width:auto;height:var(--kaching-deal-bar-progressive-gift-image-size, 40px);border-radius:var(--kaching-deal-bar-progressive-gift-corner-radius, 0)}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__text{color:var(--kaching-deal-bar-progressive-gift-text-color, #000);font-size:var(--kaching-deal-bar-progressive-gift-text-size, 14px)}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__deal-bar-progressive-gift__text{color:var(--kaching-deal-bar-progressive-gift-selected-text-color, #fff);font-weight:500}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__labels{display:flex;align-items:center;gap:5px}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__label{background-color:var(--kaching-deal-bar-progressive-gift-label-background-color);color:var(--kaching-deal-bar-progressive-gift-label-text-color);font-size:var(--kaching-deal-bar-progressive-gift-label-text-size, 12px);padding:2px 8px;border-radius:16px;white-space:nowrap;font-weight:500}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__label-crossed-out{text-decoration:line-through}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__lock-icon{display:flex;align-items:center;justify-content:center;color:var(--kaching-deal-bar-progressive-gift-locked-icon-color, #667085)}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__lock-icon svg{width:auto;height:100%}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift--locked .kaching-bundles__deal-bar-progressive-gift__text{color:var(--kaching-deal-bar-progressive-gift-locked-text-color, #555);font-size:var(--kaching-deal-bar-progressive-gift-locked-text-size, 14px)}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift--out-of-stock{opacity:.3}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift--locked .kaching-bundles__deal-bar-progressive-gift__label{background-color:var(--kaching-deal-bar-progressive-gift-locked-label-background-color);color:var(--kaching-deal-bar-progressive-gift-locked-label-text-color);font-size:var(--kaching-deal-bar-progressive-gift-locked-label-text-size, 12px)}.kaching-bundles .kaching-bundles__deal-bar-progressive-gift__divider{height:1px;display:flex}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__deal-bar-progressive-gift{margin-inline:2px;padding-block:7px 6px;padding-inline:7px calc(15px * var(--block-spacing, 1) + 4px);background-color:var(--bar-selected-border-color)}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__deal-bar-progressive-gift:last-child{margin-block-end:2px;border-end-start-radius:calc(var(--bar-border-radius) - 2px);border-end-end-radius:calc(var(--bar-border-radius) - 2px)}.kaching-bundles .kaching-bundles__product-personalisation{display:flex;align-items:center;justify-content:space-between;padding:10px 12px;gap:10px;background-color:#fafafa;border-radius:calc(var(--bar-border-radius, 10px) - 4px);border:1px dashed #d6d6d6;margin-top:12px;cursor:pointer}.kaching-bundles .kaching-bundles__product-personalisation--filled{border-style:solid}.kaching-bundles .kaching-bundles__product-personalisation__main{display:flex;align-items:center;gap:10px;min-width:0;flex:1}.kaching-bundles .kaching-bundles__product-personalisation__image-wrapper{display:flex;align-items:center;justify-content:center;flex-shrink:0;width:var(--kaching-product-personalisation-image-height, 40px);height:var(--kaching-product-personalisation-image-height, 40px);background-color:#fff;border-radius:calc(var(--bar-border-radius, 10px) - 6px);border:1px solid #d6d6d6}.kaching-bundles .kaching-bundles__product-personalisation__image{display:flex;width:70%;height:70%;-o-object-fit:contain;object-fit:contain}.kaching-bundles .kaching-bundles__product-personalisation__image--default{opacity:.7;color:#000}.kaching-bundles .kaching-bundles__product-personalisation__content{display:flex;flex-direction:column;gap:2px;min-width:0;flex:1}.kaching-bundles .kaching-bundles__product-personalisation__title{color:#000;font-size:14px;font-weight:600;font-style:normal}.kaching-bundles .kaching-bundles__product-personalisation__subtitle{color:#555;font-size:13px;font-weight:400;font-style:normal}.kaching-bundles .kaching-bundles__product-personalisation__pricing{display:flex;flex-direction:column;align-items:flex-end;flex-shrink:0;gap:2px}.kaching-bundles .kaching-bundles__product-personalisation__price{font-size:14px;font-weight:500;font-style:normal;color:#000}.kaching-bundles .kaching-bundles__product-personalisation__compare-at-price{font-size:12px;font-weight:400;font-style:normal;color:#888;line-height:1.2;text-decoration:line-through}.kaching-bundles .kaching-bundles__product-personalisation__price .kaching-bundles__product-personalisation__unit-label{font-size:calc(var(--kaching-bundles-unit-label-font-size, 14px) - 4px);font-weight:var(--kaching-bundles-unit-label-font-weight, normal);font-style:var(--kaching-bundles-unit-label-font-style, normal)}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__product-personalisation{flex-direction:column;align-items:stretch;text-align:center}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__product-personalisation__main{flex-direction:column}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__product-personalisation__pricing{flex-direction:row;justify-content:center;gap:8px;align-items:baseline}.kaching-bundles .kaching-bundles__personalisation-modal-overlay{position:fixed;z-index:9999;inset:0;display:flex;align-items:center;overflow-y:auto;padding:10px;text-align:start;line-height:1.4;background-color:var(--kaching-product-personalisation-overlay-color, rgba(0, 0, 0, .5))}.kaching-bundles .kaching-bundles__personalisation-modal-overlay--inline{position:relative;z-index:auto;inset:auto;padding:20px;border-radius:var(--kaching-product-personalisation-radius, 16px)}.kaching-bundles .kaching-bundles__personalisation-modal-overlay__content{position:relative;z-index:10000;margin:auto;min-width:min(470px,95%);max-width:700px;width:100%}.kaching-bundles .kaching-bundles__personalisation-modal{display:flex;flex-direction:column;padding:var(--kaching-product-personalisation-gap-0, 20px);border-radius:var(--kaching-product-personalisation-radius, 16px);background-color:#fff}.kaching-bundles .kaching-bundles__personalisation-modal__header{display:flex;align-items:center;justify-content:space-between;margin-bottom:var(--kaching-product-personalisation-gap-0, 20px);color:var(--kaching-product-personalisation-primary-text-color, rgb(0, 0, 0))}.kaching-bundles .kaching-bundles__personalisation-modal__heading{margin:0;font-weight:650;font-size:var(--kaching-product-personalisation-font-0, 24px)}.kaching-bundles .kaching-bundles__personalisation-modal__close{all:unset;display:flex;align-items:center;justify-content:center;margin-inline-end:-6px;width:24px;height:24px;cursor:pointer}.kaching-bundles .kaching-bundles__personalisation-modal__items{display:flex;flex-direction:column;gap:var(--kaching-product-personalisation-gap-1, 16px);padding:var(--kaching-product-personalisation-gap-1, 16px);border:1px solid #e9e9e9;border-radius:calc(var(--kaching-product-personalisation-radius, 16px) - 4px)}.kaching-bundles .kaching-bundles__personalisation-modal__item{display:flex;flex-direction:column;gap:var(--kaching-product-personalisation-gap-2, 12px)}.kaching-bundles .kaching-bundles__personalisation-modal__item-info{display:flex;align-items:center;gap:var(--kaching-product-personalisation-gap-2, 12px)}.kaching-bundles .kaching-bundles__personalisation-modal__item-image-wrapper{flex-shrink:0;width:var(--kaching-product-personalisation-image-size, 48px);height:var(--kaching-product-personalisation-image-size, 48px);border-radius:calc(var(--kaching-product-personalisation-radius, 16px) - 4px - 4px);border:1px solid #e9e9e9;overflow:hidden}.kaching-bundles .kaching-bundles__personalisation-modal__item-image{width:100%;height:100%;-o-object-fit:contain;object-fit:contain}.kaching-bundles .kaching-bundles__personalisation-modal__item-details{display:flex;flex-direction:column;gap:2px;min-width:0}.kaching-bundles .kaching-bundles__personalisation-modal__item-title{font-size:var(--kaching-product-personalisation-text-size, 16px);font-weight:600;color:var(--kaching-product-personalisation-primary-text-color, rgb(0, 0, 0))}.kaching-bundles .kaching-bundles__personalisation-modal__item-variant{font-size:var(--kaching-product-personalisation-font-3, 12px);color:var(--kaching-product-personalisation-secondary-text-color, rgb(115, 115, 115))}.kaching-bundles .kaching-bundles__personalisation-modal__input-wrapper{display:flex;flex-direction:column;gap:4px}.kaching-bundles .kaching-bundles__personalisation-modal__input-container{position:relative;display:flex;align-items:center}.kaching-bundles .kaching-bundles__personalisation-modal__input-clear{all:unset;position:absolute;right:12px;display:flex;align-items:center;justify-content:center;width:16px;height:16px;cursor:pointer}.kaching-bundles .kaching-bundles__personalisation-modal__input{width:100%;padding:10px 12px;border:1px solid #e9e9e9;border-radius:calc(var(--kaching-product-personalisation-radius, 16px) - 4px - 4px);font-size:var(--kaching-product-personalisation-font-2, 16px);outline:none!important;box-shadow:none!important;box-sizing:border-box}.kaching-bundles .kaching-bundles__personalisation-modal__input:focus{border-color:#333;outline:none!important;box-shadow:none!important}.kaching-bundles .kaching-bundles__personalisation-modal__input:focus-visible{outline:2px solid #333!important;outline-offset:-1px}.kaching-bundles .kaching-bundles__personalisation-modal__input::-moz-placeholder{color:#999}.kaching-bundles .kaching-bundles__personalisation-modal__input::placeholder{color:#999}.kaching-bundles .kaching-bundles__personalisation-modal__input--with-clear{padding-right:40px}.kaching-bundles .kaching-bundles__personalisation-modal__input--error{border-color:var(--kaching-product-personalisation-error-color, rgb(240, 68, 56))}.kaching-bundles .kaching-bundles__personalisation-modal__input--error:focus{border-color:var(--kaching-product-personalisation-error-color, rgb(240, 68, 56))}.kaching-bundles .kaching-bundles__personalisation-modal__input-counter{font-size:var(--kaching-product-personalisation-font-3, 12px);color:#999}.kaching-bundles .kaching-bundles__personalisation-modal__input-counter--error{color:var(--kaching-product-personalisation-error-color, rgb(240, 68, 56))}.kaching-bundles .kaching-bundles__personalisation-modal__actions{display:flex;gap:var(--kaching-product-personalisation-gap-1, 16px);margin-top:var(--kaching-product-personalisation-gap-0, 20px)}.kaching-bundles .kaching-bundles__personalisation-modal__button{flex:1;padding:12px 16px;border-radius:calc(var(--kaching-product-personalisation-radius, 16px) - 4px - 4px);font-size:var(--kaching-product-personalisation-font-2, 16px);font-weight:500;cursor:pointer;border:none;box-shadow:0 1px 2px #0a0d120d}.kaching-bundles .kaching-bundles__personalisation-modal__button--cancel{background:#fff;color:#333;border:1px solid #d5d7da}.kaching-bundles .kaching-bundles__personalisation-modal__button--confirm{color:var(--kaching-product-personalisation-button-text-color, rgb(255, 255, 255));border:1px solid var(--kaching-product-personalisation-button-color, rgb(0, 0, 0));background:var(--kaching-product-personalisation-button-color, rgb(0, 0, 0))}.kaching-bundles .kaching-bundles__personalisation-modal__button--disabled{cursor:not-allowed;border:1px solid #e9eaeb;background:#eaecf0;color:#98a2b3}.kaching-bundles .kaching-bundles__progressive-gifts{display:flex;flex-direction:column;gap:calc(10px * var(--block-spacing, 1) + 4px);margin-top:calc(10px * var(--block-spacing, 1))}.kaching-bundles .kaching-bundles__progressive-gifts__header{display:flex;flex-direction:column}.kaching-bundles .kaching-bundles__progressive-gifts__title{color:var(--kaching-bundles-progressive-gifts-title-color, #000);text-align:var(--kaching-bundles-progressive-gifts-title-alignment, center);font-weight:var(--kaching-bundles-progressive-gifts-title-weight, bold);font-style:var(--kaching-bundles-progressive-gifts-title-style, normal);font-size:var(--kaching-bundles-progressive-gifts-title-size, 20px)}.kaching-bundles .kaching-bundles__progressive-gifts__subtitle{color:var(--kaching-bundles-progressive-gifts-subtitle-color, #000);text-align:var(--kaching-bundles-progressive-gifts-subtitle-alignment, center);font-weight:var(--kaching-bundles-progressive-gifts-subtitle-weight, 450);font-style:var(--kaching-bundles-progressive-gifts-subtitle-style, normal);font-size:var(--kaching-bundles-progressive-gifts-subtitle-size, 16px)}.kaching-bundles .kaching-bundles__progressive-gifts__gifts{display:grid;grid-template-columns:repeat(auto-fit,minmax(0,1fr));justify-content:center;gap:calc(10px * var(--block-spacing, 1))}.kaching-bundles .kaching-bundles__progressive-gifts__gift{position:relative;display:flex;flex-direction:column;align-items:center;padding:calc(10px * var(--block-spacing, 1));gap:calc(6px * var(--block-spacing, 1));border-radius:var(--kaching-bundles-progressive-gifts-border-radius);background-color:var(--kaching-bundles-progressive-gifts-background-color);box-shadow:inset 0 0 0 2px var(--kaching-bundles-progressive-gifts-border-color, #000)}.kaching-bundles .kaching-bundles__progressive-gifts__gift.kaching-bundles__progressive-gifts__gift--locked{background-color:var(--kaching-bundles-progressive-gifts-locked-background-color);box-shadow:inset 0 0 0 1px var(--kaching-bundles-progressive-gifts-locked-border-color, rgba(0, 0, 0, .3));cursor:pointer}.kaching-bundles .kaching-bundles__progressive-gifts__gift.kaching-bundles__progressive-gifts__gift--locked:hover,.kaching-bundles .kaching-bundles__progressive-gifts__gift.kaching-bundles__progressive-gifts__gift--locked:focus{box-shadow:inset 0 0 0 2px var(--kaching-bundles-progressive-gifts-locked-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__progressive-gifts__gift.kaching-bundles__progressive-gifts__gift--locked:focus{outline:none}.kaching-bundles .kaching-bundles__progressive-gifts__gift.kaching-bundles__progressive-gifts__gift--out-of-stock{opacity:.3}.kaching-bundles .kaching-bundles__progressive-gifts__gift__content{display:flex;flex-direction:column;max-width:100%;gap:calc(6px * var(--block-spacing, 1))}.kaching-bundles .kaching-bundles__progressive-gifts__gift__image-wrapper{display:flex;flex-shrink:0;align-items:center;justify-content:center;height:var(--kaching-bundles-progressive-gifts-image-size, 100px);width:initial;max-width:100%;margin-top:max(0px,(100px - var(--kaching-bundles-progressive-gifts-image-size, 100px)) / 5);color:var(--kaching-bundles-progressive-gifts-locked-icon-color, #667085);border-radius:calc(var(--kaching-bundles-progressive-gifts-border-radius) / 2);background-color:transparent}.kaching-bundles .kaching-bundles__progressive-gifts__gift__image-wrapper svg{width:auto;height:100%}.kaching-bundles .kaching-bundles__progressive-gifts__gift__image{-o-object-fit:contain;object-fit:contain;max-height:100%;max-width:100%;border-radius:calc(var(--kaching-bundles-progressive-gifts-border-radius) / 2);width:initial}.kaching-bundles .kaching-bundles__progressive-gifts__gift__details{display:flex;flex-direction:column;gap:4px;align-items:center;min-width:0}.kaching-bundles .kaching-bundles__progressive-gifts__gift__details__content{display:flex;align-items:center;gap:8px}.kaching-bundles .kaching-bundles__progressive-gifts__gift__title{font-weight:500;text-align:center;color:var(--kaching-bundles-progressive-gifts-text-color, #000);font-size:var(--kaching-bundles-progressive-gifts-text-size, 14px)}.kaching-bundles .kaching-bundles__progressive-gifts__gift__title.kaching-bundles__progressive-gifts__gift__title--locked{color:var(--kaching-bundles-progressive-gifts-locked-text-color, #555);font-size:var(--kaching-bundles-progressive-gifts-locked-text-size, 14px)}.kaching-bundles .kaching-bundles__progressive-gifts__gift:not(.kaching-bundles__progressive-gifts__gift--locked) .kaching-bundles__progressive-gifts__gift__image,.kaching-bundles .kaching-bundles__progressive-gifts__gift:not(.kaching-bundles__progressive-gifts__gift--locked) .kaching-bundles__progressive-gifts__gift__title{animation:kaching-progressive-gift-unlock .6s ease-out}@keyframes kaching-progressive-gift-unlock{0%{opacity:0;transform:translateY(32px)}to{opacity:1;transform:translateY(0)}}.kaching-bundles .kaching-bundles__progressive-gifts__gift__label{display:flex;flex-direction:row;align-items:center;position:absolute;top:-8px;left:50%;transform:translate(-50%);line-height:1;gap:calc(5px * var(--block-spacing, 1));padding:calc(8px * var(--block-spacing, 1));background-color:var(--kaching-bundles-progressive-gifts-label-background-color, #eee);border-radius:var(--kaching-bundles-progressive-gifts-border-radius)}.kaching-bundles .kaching-bundles__progressive-gifts__gift__label__text{font-weight:450;color:var(--kaching-bundles-progressive-gifts-label-text-color, #777);font-size:var(--kaching-bundles-progressive-gifts-label-text-size, 12px);white-space:nowrap}.kaching-bundles .kaching-bundles__progressive-gifts__gift__label__text.kaching-bundles__progressive-gifts__gift__label__text--crossed-out{text-decoration:line-through}.kaching-bundles .kaching-bundles__progressive-gifts__gifts.kaching-bundles__progressive-gifts__gifts--vertical{display:flex;flex-direction:column}.kaching-bundles .kaching-bundles__progressive-gifts__gifts.kaching-bundles__progressive-gifts__gifts--vertical .kaching-bundles__progressive-gifts__gift{flex-direction:row;justify-content:space-between;gap:calc(10px * var(--block-spacing, 1))}.kaching-bundles .kaching-bundles__progressive-gifts__gifts.kaching-bundles__progressive-gifts__gifts--vertical .kaching-bundles__progressive-gifts__gift__content{flex-direction:row;align-items:center;gap:calc(10px * var(--block-spacing, 1))}.kaching-bundles .kaching-bundles__progressive-gifts__gifts.kaching-bundles__progressive-gifts__gifts--vertical .kaching-bundles__progressive-gifts__gift__details{align-items:flex-start}.kaching-bundles .kaching-bundles__progressive-gifts__gifts.kaching-bundles__progressive-gifts__gifts--vertical .kaching-bundles__progressive-gifts__gift__image-wrapper{margin-top:0;height:var(--kaching-bundles-progressive-gifts-image-size, 50px);width:var(--kaching-bundles-progressive-gifts-image-size, 50px)}.kaching-bundles .kaching-bundles__progressive-gifts__gifts.kaching-bundles__progressive-gifts__gifts--vertical .kaching-bundles__progressive-gifts__gift__title{text-align:start}.kaching-bundles .kaching-bundles__progressive-gifts__gifts.kaching-bundles__progressive-gifts__gifts--vertical .kaching-bundles__progressive-gifts__gift__label{position:initial;transform:none}.kaching-bundles .kaching-bundles__scratch-off{position:relative;display:flex;flex-direction:column;gap:calc(10px * var(--block-spacing, 1));margin:calc(5px * var(--block-spacing, 1)) 0}.kaching-bundles .kaching-bundles__scratch-off>.kaching-bundles__bar{margin:0}.kaching-bundles .kaching-bundles__scratch-off--unscratched{-webkit-user-select:none;-moz-user-select:none;user-select:none}.kaching-bundles .kaching-bundles__scratch-off--unscratched .kaching-bundles__bar{pointer-events:none}.kaching-bundles .kaching-bundles__scratch-off--revealing .kaching-bundles__bar-most-popular{animation:kaching-scratch-off-badge-pop .3s cubic-bezier(.34,1.56,.64,1) both}@keyframes kaching-scratch-off-badge-pop{0%{transform:scale(.9);opacity:0}to{transform:scale(1);opacity:1}}.kaching-bundles .kaching-bundles__scratch-off--unscratched:not(.kaching-bundles__scratch-off--revealing) .kaching-bundles__bar-most-popular{visibility:hidden}.kaching-bundles .kaching-bundles__scratch-off--loading{visibility:hidden}.kaching-bundles .kaching-bundles__scratch-off-canvas{position:absolute;inset:0;width:100%;height:100%;border-radius:var(--bar-border-radius, 8px);cursor:pointer;touch-action:none;transition:opacity .3s ease-out;z-index:11}.kaching-bundles .kaching-bundles__scratch-off-canvas--revealing{opacity:0;pointer-events:none}.kaching-bundles .kaching-bundles__scratch-off-hint{position:absolute;inset:0;margin:auto;width:calc(100% - 10px);height:calc(100% - 10px);max-width:317px;max-height:143px;pointer-events:none;opacity:.4;transition:opacity .3s ease-out;z-index:12}.kaching-bundles .kaching-bundles__scratch-off-hint--hidden{opacity:0}.kaching-bundles .kaching-bundles__scratch-off-hint-path{stroke-dasharray:1200;stroke-dashoffset:1200;animation:kaching-scratch-off-hint-draw 2.8s cubic-bezier(.4,0,.2,1) infinite}@keyframes kaching-scratch-off-hint-draw{0%{stroke-dashoffset:1200;opacity:1}60%{stroke-dashoffset:0;opacity:1}80%{stroke-dashoffset:0;opacity:1}to{stroke-dashoffset:0;opacity:0}}.kaching-bundles .kaching-bundles__scratch-off-title{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;padding:24px;color:var(--scratch-off-title-color);font-weight:700;font-size:var(--scratch-off-title-size);line-height:1.25;text-align:center;pointer-events:none;transition:opacity .3s ease-out;z-index:12}.kaching-bundles .kaching-bundles__scratch-off-title--hidden{opacity:0}.kaching-bundles .kaching-bundles-sticky-atc{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:16px;box-shadow:0 0 10px #00000040;background-color:var(--kaching-bundles-sticky-atc-background-color, #fff)}.kaching-bundles .kaching-bundles-sticky-atc .kaching-bundles-sticky-atc__content{display:flex;align-items:center;gap:16px}.kaching-bundles .kaching-bundles-sticky-atc .kaching-bundles-sticky-atc__image{width:auto;height:var(--kaching-bundles-sticky-atc-product-photo-size, 40px);border-radius:var(--kaching-bundles-sticky-atc-product-photo-corner-radius, 0)}.kaching-bundles .kaching-bundles-sticky-atc .kaching-bundles-sticky-atc__title{color:var(--kaching-bundles-sticky-atc-title-color, #000);font-size:var(--kaching-bundles-sticky-atc-title-font-size, 16px);font-style:var(--kaching-bundles-sticky-atc-title-font-style, normal);font-weight:var(--kaching-bundles-sticky-atc-title-font-weight, 400)}.kaching-bundles .kaching-bundles-sticky-atc .kaching-bundles-sticky-atc__button{all:unset;white-space:nowrap;cursor:pointer;background-color:var(--kaching-bundles-sticky-atc-button-color, #303030);color:var(--kaching-bundles-sticky-atc-button-text-color, #fff);font-size:var(--kaching-bundles-sticky-atc-button-font-size, 16px);font-style:var(--kaching-bundles-sticky-atc-button-font-style, normal);font-weight:var(--kaching-bundles-sticky-atc-button-font-weight, 400);padding:var(--kaching-bundles-sticky-atc-button-padding, 15px);border-radius:var(--kaching-bundles-sticky-atc-button-corner-radius, 8px)}.kaching-bundles .kaching-bundles__subscriptions.kaching-bundles__bars--horizontal.kaching-bundles__bars{grid-template-columns:repeat(2,1fr)}.kaching-bundles .kaching-bundles__subscriptions.kaching-bundles__bars--horizontal .kaching-bundles__bar-wrapper{padding:10px 7px}.kaching-bundles .kaching-bundles__subscriptions.kaching-bundles__bars--horizontal .kaching-bundles__bar-main{min-height:initial}.kaching-bundles .kaching-bundles__subscriptions.kaching-bundles__subscriptions--checkbox .kaching-bundles__bar-container{border:2px dashed var(--bar-selected-border-color, #000);box-shadow:none}.kaching-bundles .kaching-bundles__subscriptions.kaching-bundles__subscriptions--checkbox .kaching-bundles__bar-wrapper{margin:-2px}.kaching-bundles .kaching-bundles__subscriptions.kaching-bundles__subscriptions--checkbox .kaching-bundles__bar-variants{display:flex}.kaching-bundles .kaching-bundles__subscriptions .kaching-bundles__subscriptions__title{display:inline-block;overflow-wrap:break-word;font-weight:700;font-size:var(--kaching-subscriptions-title-font-size, 15px);color:var(--kaching-subscriptions-title-color, #000)}.kaching-bundles .kaching-bundles__subscriptions .kaching-bundles__subscriptions__subtitle{display:inline-block;overflow-wrap:break-word;font-size:var(--kaching-subscriptions-subtitle-font-size, 13px);color:var(--kaching-subscriptions-subtitle-color, #555)}.kaching-bundles .kaching-bundles__subscriptions .kaching-bundles__bar-price{font-size:var(--kaching-subscriptions-title-font-size, 15px);color:var(--kaching-subscriptions-title-color, #000)}.kaching-bundles .kaching-bundles__subscriptions .kaching-bundles__bar-full-price{font-size:var(--kaching-subscriptions-subtitle-font-size, 13px);color:var(--kaching-subscriptions-subtitle-color, #555)}.kaching-bundles .kaching-bundles__subscriptions .kaching-bundles__subscriptions__checkbox{all:unset;display:flex;flex-shrink:0;width:20px;height:20px;align-items:center;justify-content:center;cursor:pointer;background-color:#fff;color:var(--bar-selected-border-color);border-width:2px;border-style:solid;border-color:var(--bar-selected-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__subscriptions.kaching-bundles__subscriptions--link{display:flex;justify-content:center;align-items:center;padding:8px 0}.kaching-bundles .kaching-bundles__subscriptions .kaching-bundles__subscriptions__link{all:unset;cursor:pointer;display:inline;text-decoration:underline;text-underline-offset:3px;font-size:var(--kaching-subscriptions-title-font-size, 15px);color:var(--kaching-subscriptions-title-color, #000)}.kaching-bundles .kaching-bundles__timer{display:flex;align-items:center;background-color:var(--kaching-bundles-timer-background-color, #000);color:var(--kaching-bundles-timer-text-color, #fff);padding:10px 20px;border-radius:var(--bar-border-radius, 8px);margin-bottom:calc(8px * var(--block-spacing, 1))}.kaching-bundles .kaching-bundles__timer-title{flex:1;text-align:var(--kaching-bundles-timer-title-alignment, center);font-size:var(--kaching-bundles-timer-title-size, 13px);font-weight:var(--kaching-bundles-timer-title-font-weight, bold);font-style:var(--kaching-bundles-timer-title-font-style, normal)}.kaching-bundles .kaching-bundles__swatch-dropdown{display:flex;position:relative;min-width:0;margin:0}.kaching-bundles .kaching-bundles__swatch{display:flex;flex-shrink:0;background-size:cover;background-position:center;overflow:hidden;position:relative;width:var(--kaching-swatch-size, 20px);height:var(--kaching-swatch-size, 20px);border:1px solid var(--kaching-swatch-border-color, #c2cdd6);background-color:var(--kaching-swatch-color, #fff);background-image:var(--kaching-swatch-image-url, none);border-radius:var(--kaching-swatch-border-radius, 0)}.kaching-bundles .kaching-bundles__swatch.kaching-bundles__swatch--unavailable{border-color:#121212;opacity:.4}.kaching-bundles .kaching-bundles__swatch.kaching-bundles__swatch--unavailable:after{content:"";position:absolute;bottom:0;left:0;width:140%;height:1px;background-color:#121212;transform:rotate(-45deg);transform-origin:left}.kaching-bundles .kaching-bundles__swatches-dropdown__color{display:flex;width:20px;height:20px;border:1px solid #c2cdd6;background-size:cover;background-position:center}.kaching-bundles .kaching-bundles__swatch-dropdown__options{display:flex;flex-direction:column;max-width:400px;max-height:500px;overflow:auto;position:fixed;top:0;left:0;border:1px solid #ccc;background-color:#fff;z-index:1000;box-shadow:0 20px 20px #1a1a1a47}.kaching-bundles .kaching-bundles__swatch-dropdown__option{font-size:14px;font-weight:400;font-style:normal;display:flex;align-items:center;gap:10px;white-space:nowrap;padding-block:10px;padding-inline:10px 60px;border:none;border-bottom:1px solid #dfe3e8;cursor:pointer;color:#000;background:none}.kaching-bundles .kaching-bundles__swatch-dropdown__option:last-child{border-bottom:none}.kaching-bundles .kaching-bundles__swatch-dropdown__option:hover,.kaching-bundles .kaching-bundles__swatch-dropdown__option--focused{background-color:#f0f0f0}.kaching-bundles .kaching-bundles__swatch-buttons{display:flex;overflow:auto}.kaching-bundles .kaching-bundles__swatch-buttons__button{display:flex;align-items:center;box-sizing:border-box;border:none;padding:9px;background:#fff;cursor:pointer;border-top:1px solid var(--bar-border-color, rgba(0, 0, 0, .3));border-bottom:1px solid var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__swatch-buttons__button:first-of-type{border-start-start-radius:var(--bar-variant-select-border-radius, 0);border-end-start-radius:var(--bar-variant-select-border-radius, 0);border-inline-start:1px solid var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__swatch-buttons__button:last-of-type{border-start-end-radius:var(--bar-variant-select-border-radius, 0);border-end-end-radius:var(--bar-variant-select-border-radius, 0);border-inline-end:1px solid var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__swatch-buttons__button.kaching-bundles__swatch-buttons__button--selected{padding:8px 7px;border:2px solid var(--bar-selected-border-color, #50b83c)}.kaching-bundles .kaching-bundles__swatch-buttons__button.kaching-bundles__swatch-buttons__button--selected:first-of-type{padding-inline-start:8px}.kaching-bundles .kaching-bundles__swatch-buttons__button.kaching-bundles__swatch-buttons__button--selected:last-of-type{padding-inline-end:8px}.kaching-bundles .kaching-bundles__quantity-selector{display:flex;width:-moz-fit-content;width:fit-content;border:1px solid #cccccc;box-sizing:border-box;overflow:hidden;margin-top:5px;border-radius:calc(var(--bar-border-radius, 0) / 2)}.kaching-bundles .kaching-bundles__quantity-selector .kaching-bundles__quantity-selector__button{display:flex;align-items:center;justify-content:center;width:30px;height:30px;-webkit-user-select:none;-moz-user-select:none;user-select:none;cursor:pointer;background-color:#fff;color:#000;border-radius:0}.kaching-bundles .kaching-bundles__quantity-selector .kaching-bundles__quantity-selector__button:hover{background-color:#eee}.kaching-bundles .kaching-bundles__quantity-selector .kaching-bundles__quantity-selector__button.kaching-bundles__quantity-selector__button--disabled{cursor:not-allowed;pointer-events:none}.kaching-bundles .kaching-bundles__quantity-selector .kaching-bundles__quantity-selector__button.kaching-bundles__quantity-selector__button--disabled img{opacity:.5}.kaching-bundles .kaching-bundles__quantity-selector .kaching-bundles__quantity-selector__input{all:unset;-webkit-appearance:textfield;-moz-appearance:textfield;appearance:textfield;height:30px;width:30px;padding:0;border:1px solid #cccccc;border-top:none;border-bottom:none;background-color:#fff;color:#000;text-align:center;font-size:16px;font-weight:400;box-sizing:border-box}.kaching-bundles .kaching-bundles__quantity-selector .kaching-bundles__quantity-selector__input::-webkit-outer-spin-button,.kaching-bundles .kaching-bundles__quantity-selector .kaching-bundles__quantity-selector__input::-webkit-inner-spin-button{-webkit-appearance:none;appearance:none;margin:0}.kaching-bundles .kaching-bundles__highlights{display:flex;flex-direction:column;gap:8px;padding:10px 0}.kaching-bundles .kaching-bundles__highlights__item{display:flex;gap:8px}.kaching-bundles .kaching-bundles__highlights__icon{display:flex;align-items:center;flex-shrink:0;color:var(--kaching-highlights-icon-color, #000);width:var(--kaching-highlights-icon-size, 16px);height:var(--kaching-highlights-icon-size, 16px)}.kaching-bundles .kaching-bundles__highlights__icon svg{width:100%;height:100%}.kaching-bundles .kaching-bundles__highlights__icon img{width:100%;height:100%;-o-object-fit:contain;object-fit:contain}.kaching-bundles .kaching-bundles__highlights__text{color:var(--kaching-highlights-text-color, #808080);font-size:var(--kaching-highlights-text-size, 16px);line-height:1.3}.kaching-bundles .kaching-bundles__low-stock-alert{color:var(--kaching-bundles-low-stock-alert-text-color, #ff0909);font-size:14px}.kaching-bundles img{width:initial}.kaching-bundles svg{width:initial;height:initial}.kaching-bundles .kaching-bundles__block{display:flex;flex-direction:column;width:100%;margin-top:15px;margin-bottom:10px;text-align:start;line-height:1.4;font-family:var(--block-font-family, inherit)}.kaching-bundles .kaching-bundles__block--hidden{display:none!important}.kaching-bundles .kaching-bundles__block.kaching-bundles__block--loaded{display:flex}.kaching-bundles .kaching-bundles__block-title{display:flex;align-items:center;text-align:center;gap:8px;margin-top:10px;margin-bottom:10px;color:var(--block-block-title-color, #000);font-size:var(--block-title-font-size, 14px);font-weight:var(--block-title-font-weight, bold);font-style:var(--block-title-font-style)}.kaching-bundles .kaching-bundles__block>.kaching-bundles__block-title:first-child{margin-top:0}.kaching-bundles .kaching-bundles__block-title:before,.kaching-bundles .kaching-bundles__block-title:after{content:"";flex-grow:1;height:2px;background-color:var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__bars{display:flex;flex-direction:column}.kaching-bundles .kaching-bundles__bar{display:flex;flex:1;margin:calc(5px * var(--block-spacing, 1)) 0;position:relative}.kaching-bundles .kaching-bundles__bar--disabled{opacity:.3}.kaching-bundles .kaching-bundles__bar-container--sold-out{pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none;opacity:var(--kaching-bundles-show-as-sold-out-opacity, .3)}.kaching-bundles .kaching-bundles__bar-sold-out-badge{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);padding:6px 12px;border-radius:8px;font-weight:600;background-color:var(--kaching-bundles-show-as-sold-out-background-color, #000);color:var(--kaching-bundles-show-as-sold-out-text-color, #fff);font-size:var(--kaching-bundles-show-as-sold-out-text-size, 13px);z-index:10;text-align:center}.kaching-bundles .kaching-bundles__bar>input[type=radio]{display:none}.kaching-bundles .kaching-bundles__bar-image{-o-object-fit:contain;object-fit:contain;height:var(--bar-image-size, 48px);width:var(--bar-image-size, 48px);border-radius:var(--bar-image-border-radius, 0)}.kaching-bundles .kaching-bundles__bar-radio{display:flex;flex-shrink:0;width:20px;height:20px;border-radius:50%;background:#fff;border:3px solid #fff;box-sizing:border-box;box-shadow:0 0 0 2px var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__bar-radio{background:var(--bar-selected-border-color, #000);box-shadow:0 0 0 2px var(--bar-selected-border-color, #000)}.kaching-bundles .kaching-bundles__bar-container{display:flex!important;flex-direction:column;justify-content:center;align-items:initial;position:relative;box-sizing:border-box;cursor:pointer;width:100%;margin:0;padding:0;border:none;background-color:var(--bar-background-color, #fff);border-radius:var(--bar-border-radius);box-shadow:inset 0 0 0 1px var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__bar-wrapper{padding:calc(10px * var(--block-spacing, 1)) calc(15px * var(--block-spacing, 1) + 5px)}.kaching-bundles .kaching-bundles__bar-container:hover{opacity:1;box-shadow:inset 0 0 0 2px var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__bar-container:has(:focus-visible){opacity:1;box-shadow:inset 0 0 0 2px var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__bar-container *{letter-spacing:normal;text-transform:initial}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__bar-container{cursor:default;background-color:var(--bar-selected-background-color);box-shadow:inset 0 0 0 2px var(--bar-selected-border-color, #000)}.kaching-bundles .kaching-bundles__bar-most-popular{position:absolute;z-index:1}.kaching-bundles .kaching-bundles__bar-most-popular.kaching-bundles__bar-most-popular--simple{top:-8px;right:var(--bar-border-radius)}.kaching-bundles .kaching-bundles__bar-most-popular.kaching-bundles__bar-most-popular--fancy{top:-27px;right:-15px}.kaching-bundles .kaching-bundles__bar-most-popular.kaching-bundles__bar-most-popular--custom{top:-25px;right:-15px}.kaching-bundles .kaching-bundles__bar-most-popular--custom .kaching-bundles__bar-most-popular__custom-image{max-height:56px;width:auto;display:block}.kaching-bundles .kaching-bundles__bar-most-popular svg{color:var(--bar-most-popular-background-color)}.kaching-bundles .kaching-bundles__bar-most-popular svg .most-popular-text{fill:var(--bar-most-popular-color)}.kaching-bundles .kaching-bundles__bar-most-popular__content{margin:0 8px;padding:6px 8px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;font-family:sans-serif;font-size:12px;font-weight:700;line-height:1;color:var(--bar-most-popular-color, #fff);background-color:var(--bar-most-popular-background-color)}.kaching-bundles .kaching-bundles__bar-most-popular__content:before,.kaching-bundles .kaching-bundles__bar-most-popular__content:after{display:block;position:absolute;top:0;width:0;height:0;content:"";border-bottom:8px solid var(--bar-most-popular-background-color, transparent);filter:brightness(.7)}.kaching-bundles .kaching-bundles__bar-most-popular__content:before{left:0;border-left:8px solid transparent}.kaching-bundles .kaching-bundles__bar-most-popular__content:after{right:0;border-right:8px solid transparent}@media (width >= 750px){.kaching-bundles .kaching-bundles__bar-most-popular.kaching-bundles__bar-most-popular--fancy,.kaching-bundles .kaching-bundles__bar-most-popular.kaching-bundles__bar-most-popular--custom{right:-20px}}.kaching-bundles .kaching-bundles__bar-main{display:flex;align-items:center;gap:18px;min-height:55px}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__bar-main{cursor:pointer}.kaching-bundles .kaching-bundles__bar-content{align-items:center;justify-content:space-between;display:flex;gap:8px;flex:1}.kaching-bundles .kaching-bundles__bar-content-left{display:flex;flex-direction:column;flex:1;align-items:flex-start}.kaching-bundles .kaching-bundles__bar-first-line{display:flex;flex-wrap:wrap;-moz-column-gap:8px;column-gap:8px;align-items:center}.kaching-bundles .kaching-bundles__bar-second-line{display:flex;flex-wrap:wrap;align-items:center;-moz-column-gap:10px;column-gap:10px}.kaching-bundles .kaching-bundles__bar-title{display:inline-block;overflow-wrap:break-word;font-size:var(--bar-title-font-size, 20px);font-weight:var(--bar-title-font-weight, 500);font-style:var(--bar-title-font-style);color:var(--bar-title-color, #000)}.kaching-bundles .kaching-bundles__bar-label{display:inline-flex;align-items:center;justify-content:center;gap:4px;vertical-align:top;padding:4px 8px;overflow-wrap:break-word;background-color:var(--bar-label-background-color, #eee);color:var(--bar-label-color, #777);font-size:var(--bar-label-font-size, 12px);font-weight:var(--bar-label-font-weight);font-style:var(--bar-label-font-style);border-radius:var(--bar-border-radius)}.kaching-bundles .kaching-bundles__bar-subtitle{overflow-wrap:break-word;font-size:var(--bar-subtitle-font-size, 14px);font-weight:var(--bar-subtitle-font-weight);font-style:var(--bar-subtitle-font-style);color:var(--bar-subtitle-color, #555)}.kaching-bundles .kaching-bundles__bar-pricing{align-items:flex-end;display:flex;flex-direction:column}.kaching-bundles .kaching-bundles__bars--hide-prices .kaching-bundles__bar-pricing{display:none}.kaching-bundles .kaching-bundles__bar-pricing-row{display:flex;align-items:baseline;gap:6px}.kaching-bundles .kaching-bundles__bar-price{font-size:var(--bar-title-font-size, 20px);font-weight:var(--bar-title-font-weight, 500);font-style:var(--bar-title-font-style);color:var(--bar-price-color, #000)}.kaching-bundles .kaching-bundles__bar-price .kaching-bundles__bar-price__unit-label{font-size:var(--kaching-bundles-unit-label-font-size, 14px);font-weight:var(--kaching-bundles-unit-label-font-weight, normal);font-style:var(--kaching-bundles-unit-label-font-style)}.kaching-bundles .kaching-bundles__bar-pricing-row--secondary .kaching-bundles__bar-price{font-size:var(--bar-subtitle-font-size)}.kaching-bundles .kaching-bundles__bar-full-price,.kaching-bundles .kaching-bundles__bar-unit-price{font-size:var(--bar-subtitle-font-size, 14px);font-weight:var(--bar-subtitle-font-weight);font-style:var(--bar-subtitle-font-style);color:var(--bar-full-price-color, #555)}.kaching-bundles .kaching-bundles__bar-full-price{text-decoration:line-through}.kaching-bundles .kaching-bundles__bar-unit-price{text-transform:uppercase}.kaching-bundles .kaching-bundles__bar-variants{display:none;flex-direction:column;align-items:flex-start}.kaching-bundles .kaching-bundles__bar-variant{flex:1;max-width:100%}.kaching-bundles .kaching-bundles__bar-variants .kaching-bundles__bar-variant{margin-top:5px}.kaching-bundles .kaching-bundles__bar-variant__content{display:flex;align-items:center}.kaching-bundles .kaching-bundles__invalid-variant-error{color:red;font-size:12px;padding-bottom:2px}.kaching-bundles .kaching-bundles__bar-variant-names{font-size:12px;color:var(--bar-subtitle-color, #555);margin-block:3px}.kaching-bundles .kaching-bundles__bar-variant-names>span:not(:last-child):after{content:", "}.kaching-bundles .kaching-bundles__bar-variant-number{font-size:12px;margin-right:2px;min-width:20px;display:inline-flex;color:var(--bar-title-color, #000)}.kaching-bundles .kaching-bundles__bar-variant-image{width:initial;max-width:40px;max-height:40px;border-radius:calc(var(--bar-border-radius, 0) / 2);margin-right:7px}.kaching-bundles .kaching-bundles__bar-variant-selects{display:flex;min-width:0;margin-right:2px;margin-bottom:2px;flex-wrap:wrap;gap:7px}.kaching-bundles .kaching-bundles__bar-variant-select{font-size:14px;font-weight:400;font-style:normal;font-family:var(--block-font-family, inherit);-webkit-appearance:none;-moz-appearance:none;appearance:none;border:none;padding:7px 25px 7px 7px;margin:0;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;background-image:url("data:image/svg+xml;utf8,<svg width='10' height='4' viewBox='0 0 10 4' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M5 4L0.669872 0.25L9.33013 0.249999L5 4Z' fill='black'/></svg>")!important;background-repeat:no-repeat!important;background-position:right 8px center!important;background-color:#fff;background-size:initial;color:#000;outline:none;max-width:100%;width:auto;height:auto;min-height:auto;display:flex;align-items:center;gap:10px;cursor:pointer;box-shadow:inset 0 0 0 1px var(--bar-border-color, rgba(0, 0, 0, .3));border-radius:var(--bar-variant-select-border-radius, 0)}.kaching-bundles .kaching-bundles__bar-variant-select span{overflow:hidden;text-overflow:ellipsis}.kaching-bundles .kaching-bundles__bar-variant-selector-wrapper{display:flex;flex-wrap:wrap;align-items:center;-moz-column-gap:10px;column-gap:10px;max-width:100%}.kaching-bundles .kaching-bundles__selling-plan-select{width:100%}.kaching-bundles .kaching-bundles__bar-selling-plan{margin-top:5px;margin-bottom:5px}.kaching-bundles .kaching-bundles__bar-variant--invalid .kaching-bundles__bar-variant-select{box-shadow:0 0 0 1px red}.kaching-bundles .kaching-bundles__bar-variant-select:hover{border:none;box-shadow:inset 0 0 0 2px var(--bar-border-color, rgba(0, 0, 0, .3))}.kaching-bundles .kaching-bundles__bar-variant-select:focus{border:none;box-shadow:inset 0 0 0 2px var(--bar-selected-border-color, #000)}.kaching-bundles .kaching-bundles__bar-variant--invalid .kaching-bundles__bar-variant-select:is(:hover,:focus){box-shadow:0 0 0 2px red}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__bar-variants{display:flex}.kaching-bundles .kaching-bundles__out-of-stock{background-color:#ff2d2d4d;border:1px solid #ff2c2c;color:#df2121;padding:8px 12px;margin:5px 0;font-size:14px}.kaching-bundles .kaching-bundles__bars--horizontal.kaching-bundles__bars{display:grid;grid-template-columns:repeat(var(--bundle-bars-per-row, 3),1fr);gap:calc(10px * var(--block-spacing, 1));overflow-x:auto}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar{position:relative}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar-wrapper{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:40px 7px 10px;height:100%}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar-main{flex-direction:column;gap:10px;text-align:center}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar-content{flex-direction:column}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar-content-left{align-items:center}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar-second-line{justify-content:center}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar-label{position:absolute;top:0;left:0;right:0;margin-right:0;border-top-left-radius:var(--bar-label-border-top-radius);border-top-right-radius:var(--bar-label-border-top-radius)}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar-pricing{align-items:center}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar-variants{align-items:center;margin-top:10px;margin-bottom:5px}.kaching-bundles .kaching-bundles__bars--horizontal .kaching-bundles__bar-variant-selector-wrapper{justify-content:center}.kaching-bundles .kaching-bundles__bars--grid.kaching-bundles__bars{display:grid;grid-template-columns:repeat(2,1fr);gap:calc(10px * var(--block-spacing, 1))}.kaching-bundles .kaching-bundles__bars--grid .kaching-bundles__bar-main{min-height:initial}.kaching-bundles .kaching-bundles__bars--grid .kaching-bundles__bar{margin:0}.kaching-bundles .kaching-bundles__bars--grid .kaching-bundles__bar-radio{display:none}.kaching-bundles .kaching-bundles__bars--plain .kaching-bundles__bar-container,.kaching-bundles .kaching-bundles__bars--plain .kaching-bundles__bar-container:hover,.kaching-bundles .kaching-bundles__bars--plain .kaching-bundles__bar--selected .kaching-bundles__bar-container{box-shadow:none}.kaching-bundles .kaching-bundles__bars--plain .kaching-bundles__bar-main{min-height:initial}.kaching-bundles .kaching-bundles__bars--plain .kaching-bundles__bar-pricing{flex-direction:row;gap:10px}.kaching-bundles .kaching-bundles__bar-container:has(.kaching-bundles__bar-most-popular--simple) .kaching-bundles__bar-main{margin-top:7px;margin-bottom:7px}.kaching-bundles .kaching-bundles__bar-container:has(.kaching-bundles__bar-most-popular--fancy) .kaching-bundles__bar-pricing{margin-top:18px}.kaching-bundles .kaching-bundles__bar-container:has(.kaching-bundles__bar-most-popular--custom) .kaching-bundles__bar-pricing{margin-top:18px}.kaching-bundles .kaching-bundles__bar--selected .kaching-bundles__bar-container:has(.kaching-bundles__bar-most-popular--simple) .kaching-bundles__bar-variants{margin-top:-7px}.kaching-bundles .kaching-bundles__bar-full-price:before,.kaching-bundles .kaching-bundles__bar-price:before{content:attr(data-a11y-label);position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip-path:inset(50%);white-space:nowrap;border:0}@media (prefers-reduced-motion: reduce){.kaching-bundles *,.kaching-bundles *:before,.kaching-bundles *:after{transition-duration:.01ms!important;animation-duration:.01ms!important}}`)), document.head.appendChild(Gt);
    }
  } catch (Kt) {
    console.error("vite-plugin-css-injected-by-js", Kt);
  }
})();
var f0 = Object.defineProperty, b0 = Object.getPrototypeOf, v0 = Reflect.get, id = (Gt) => {
  throw TypeError(Gt);
}, _0 = (Gt, Kt, bn) => Kt in Gt ? f0(Gt, Kt, { enumerable: !0, configurable: !0, writable: !0, value: bn }) : Gt[Kt] = bn, fn = (Gt, Kt, bn) => _0(Gt, typeof Kt != "symbol" ? Kt + "" : Kt, bn), Ws = (Gt, Kt, bn) => Kt.has(Gt) || id("Cannot " + bn), me = (Gt, Kt, bn) => (Ws(Gt, Kt, "read from private field"), bn ? bn.call(Gt) : Kt.get(Gt)), It = (Gt, Kt, bn) => Kt.has(Gt) ? id("Cannot add the same private member more than once") : Kt instanceof WeakSet ? Kt.add(Gt) : Kt.set(Gt, bn), xt = (Gt, Kt, bn, Il) => (Ws(Gt, Kt, "write to private field"), Kt.set(Gt, bn), bn), nn = (Gt, Kt, bn) => (Ws(Gt, Kt, "access private method"), bn), k0 = (Gt, Kt, bn) => v0(b0(Gt), bn, Kt);
(function(Gt) {
  var Kt, bn, Il, Ti, ni, xr, ri, Gi, Sa, ai, Ca, na, ii, Oi, Fi, Or, Us, Li, Ml, hr, Wn, Ei, wr, Ba, Pr, tr, En, Sr, ra, aa, Fr, Ia, ia, Dl, zl, Un, Hs, Zs, ji, Ri, Al, Lr, nr, li, Qi, $l, ql, Js, si, pr, la, Vl, Ni, Ys, Ks, Cr, Br, Er, Tl, Ir, oi, Wi;
  String.prototype.replaceAll || (String.prototype.replaceAll = function(n, t) {
    if (typeof n == "string") {
      const r = n.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
      return this.replace(new RegExp(r, "g"), t);
    }
    if (n instanceof RegExp) {
      if (!n.global) throw new TypeError("replaceAll must be called with a global RegExp");
      return this.replace(n, t);
    }
    return this.replace(n, t);
  }), typeof window != "undefined" && ((Il = (bn = (Kt = window.__svelte) != null ? Kt : window.__svelte = {}).v) != null ? Il : bn.v = /* @__PURE__ */ new Set()).add("5");
  const Ui = "[!", sa = {}, kn = Symbol(), ld = !1;
  var ci = Array.isArray, sd = Array.prototype.indexOf, Gl = Array.from, Hi = Object.keys, oa = Object.defineProperty, ca = Object.getOwnPropertyDescriptor, Xs = Object.getOwnPropertyDescriptors, eo = Object.prototype, od = Array.prototype, Zi = Object.getPrototypeOf, to = Object.isExtensible;
  const jr = () => {
  };
  function cd(n) {
    return n();
  }
  function Ji(n) {
    for (var t = 0; t < n.length; t++) n[t]();
  }
  const ui = 16, Yi = 32, no = 64, rr = 256, Ol = 512, Cn = 1024, Mr = 2048, ua = 4096, fr = 8192, Ma = 16384, Fl = 32768, Da = 65536, ud = 1 << 17, ro = 1 << 19, Ll = 1 << 21, dd = 1 << 22, da = 1 << 23, Dr = Symbol("$state"), ao = Symbol("legacy props"), gd = Symbol(""), El = new class extends Error {
    constructor() {
      super(...arguments), fn(this, "name", "StaleReactionError"), fn(this, "message", "The reaction that called `getAbortSignal()` was re-run or destroyed");
    }
  }();
  function io(n) {
    throw new Error("https://svelte.dev/e/lifecycle_outside_component");
  }
  function di(n) {
    console.warn("https://svelte.dev/e/hydration_mismatch");
  }
  let Mt, dt = !1;
  function zn(n) {
    dt = n;
  }
  function mn(n) {
    if (n === null) throw di(), sa;
    return Mt = n;
  }
  function ar() {
    return mn(lr(Mt));
  }
  function w(n) {
    if (dt) {
      if (lr(Mt) !== null) throw di(), sa;
      Mt = n;
    }
  }
  function Rr(n = 1) {
    if (dt) {
      for (var t = n, r = Mt; t--; ) r = lr(r);
      Mt = r;
    }
  }
  function Ki(n = !0) {
    for (var t = 0, r = Mt; ; ) {
      if (r.nodeType === 8) {
        var a = r.data;
        if (a === "]") {
          if (t === 0) return r;
          t -= 1;
        } else a !== "[" && a !== Ui || (t += 1);
      }
      var l = lr(r);
      n && r.remove(), r = l;
    }
  }
  function lo(n) {
    if (!n || n.nodeType !== 8) throw di(), sa;
    return n.data;
  }
  function so(n) {
    return n === this.v;
  }
  function Xi(n, t) {
    return n != n ? t == t : n !== t || n !== null && typeof n == "object" || typeof n == "function";
  }
  function hd(n, t) {
    return n !== t;
  }
  function oo(n) {
    return !Xi(n, this.v);
  }
  let za = !1;
  const pd = [];
  function Qr(n, t = !1, r = !1) {
    return el(n, /* @__PURE__ */ new Map(), "", pd, null, r);
  }
  function el(n, t, r, a, l = null, c = !1) {
    if (typeof n == "object" && n !== null) {
      var u = t.get(n);
      if (u !== void 0) return u;
      if (n instanceof Map) return new Map(n);
      if (n instanceof Set) return new Set(n);
      if (ci(n)) {
        var s = Array(n.length);
        t.set(n, s), l !== null && t.set(l, s);
        for (var i = 0; i < n.length; i += 1) {
          var o = n[i];
          i in n && (s[i] = el(o, t, r, a, null, c));
        }
        return s;
      }
      if (Zi(n) === eo) {
        for (var d in s = {}, t.set(n, s), l !== null && t.set(l, s), n) s[d] = el(n[d], t, r, a, null, c);
        return s;
      }
      if (n instanceof Date) return structuredClone(n);
      if (typeof n.toJSON == "function" && !c) return el(n.toJSON(), t, r, a, n);
    }
    if (n instanceof EventTarget) return n;
    try {
      return structuredClone(n);
    } catch {
      return n;
    }
  }
  let rn = null;
  function Aa(n) {
    rn = n;
  }
  function gi(n) {
    return co().get(n);
  }
  function hi(n, t) {
    return co().set(n, t), t;
  }
  function Je(n, t = !1, r) {
    rn = { p: rn, c: null, e: null, s: n, x: null, l: za && !t ? { s: null, u: null, $: [] } : null };
  }
  function Ye(n) {
    var t = rn, r = t.e;
    if (r !== null) for (var a of (t.e = null, r)) zo(a);
    return n !== void 0 && (t.x = n), rn = t.p, n != null ? n : {};
  }
  function $a() {
    return !za || rn !== null && rn.l === null;
  }
  function co(n) {
    var t;
    return rn === null && io(), (t = rn.c) != null ? t : rn.c = new Map((function(r) {
      let a = r.p;
      for (; a !== null; ) {
        const l = a.c;
        if (l !== null) return l;
        a = a.p;
      }
      return null;
    })(rn) || void 0);
  }
  const fd = typeof requestIdleCallback == "undefined" ? (n) => setTimeout(n, 1) : requestIdleCallback;
  let Nr = [], qa = [];
  function uo() {
    var n = Nr;
    Nr = [], Ji(n);
  }
  function go() {
    var n = qa;
    qa = [], Ji(n);
  }
  function bd() {
    return Nr.length > 0 || qa.length > 0;
  }
  function ga(n) {
    if (Nr.length === 0 && !fi) {
      var t = Nr;
      queueMicrotask(() => {
        t === Nr && uo();
      });
    }
    Nr.push(n);
  }
  function vd() {
    Nr.length > 0 && uo(), qa.length > 0 && go();
  }
  const _d = /* @__PURE__ */ new WeakMap();
  function ho(n) {
    var t = $t;
    if (t === null) return Tt.f |= da, n;
    if ((t.f & Fl) === 0) {
      if (!(128 & t.f)) throw !t.parent && n instanceof Error && po(n), n;
      t.b.error(n);
    } else Va(n, t);
  }
  function Va(n, t) {
    for (; t !== null; ) {
      if (128 & t.f) try {
        return void t.b.error(n);
      } catch (r) {
        n = r;
      }
      t = t.parent;
    }
    throw n instanceof Error && po(n), n;
  }
  function po(n) {
    const t = _d.get(n);
    t && (oa(n, "message", { value: t.message }), oa(n, "stack", { value: t.stack }));
  }
  const jl = /* @__PURE__ */ new Set();
  let sn = null, pi = null, Rl = /* @__PURE__ */ new Set(), ha = [], tl = null, Ql = !1, fi = !1;
  Ti = /* @__PURE__ */ new WeakMap(), ni = /* @__PURE__ */ new WeakMap(), xr = /* @__PURE__ */ new WeakMap(), ri = /* @__PURE__ */ new WeakMap(), Gi = /* @__PURE__ */ new WeakMap(), Sa = /* @__PURE__ */ new WeakMap(), ai = /* @__PURE__ */ new WeakMap(), Ca = /* @__PURE__ */ new WeakMap(), na = /* @__PURE__ */ new WeakMap(), ii = /* @__PURE__ */ new WeakMap(), Oi = /* @__PURE__ */ new WeakMap(), Fi = /* @__PURE__ */ new WeakMap(), Or = /* @__PURE__ */ new WeakSet(), Us = function(n) {
    var t;
    n.f ^= Cn;
    for (var r = n.first; r !== null; ) {
      var a = r.f, l = !!(96 & a);
      if (!(l && (a & Cn) !== 0 || (a & fr) !== 0 || this.skipped_effects.has(r)) && r.fn !== null) {
        l ? r.f ^= Cn : 4 & a ? me(this, na).push(r) : (a & Cn) === 0 && ((a & dd) !== 0 ? ((t = r.b) != null && t.is_pending() ? me(this, ai) : me(this, Sa)).push(r) : il(r) && ((r.f & ui) !== 0 && me(this, ii).push(r), Fa(r)));
        var c = r.first;
        if (c !== null) {
          r = c;
          continue;
        }
      }
      var u = r.parent;
      for (r = r.next; r === null && u !== null; ) r = u.next, u = u.parent;
    }
  }, Li = function(n) {
    for (const t of n)
      ((t.f & Mr) !== 0 ? me(this, Oi) : me(this, Fi)).push(t), On(t, Cn);
    n.length = 0;
  }, Ml = function() {
    if (!me(this, Gi)) for (const n of me(this, ni)) n();
    me(this, ni).clear();
  };
  let pa = class Ns {
    constructor() {
      It(this, Or), fn(this, "current", /* @__PURE__ */ new Map()), It(this, Ti, /* @__PURE__ */ new Map()), It(this, ni, /* @__PURE__ */ new Set()), It(this, xr, 0), It(this, ri, null), It(this, Gi, !1), It(this, Sa, []), It(this, ai, []), It(this, Ca, []), It(this, na, []), It(this, ii, []), It(this, Oi, []), It(this, Fi, []), fn(this, "skipped_effects", /* @__PURE__ */ new Set());
    }
    process(t) {
      var r;
      ha = [], pi = null;
      for (const c of t) nn(this, Or, Us).call(this, c);
      if (me(this, Sa).length === 0 && me(this, xr) === 0) {
        nn(this, Or, Ml).call(this);
        var a = me(this, Ca), l = me(this, na);
        xt(this, Ca, []), xt(this, na, []), xt(this, ii, []), pi = sn, sn = null, bo(a), bo(l), sn === null ? sn = this : jl.delete(this), (r = me(this, ri)) == null || r.resolve();
      } else nn(this, Or, Li).call(this, me(this, Ca)), nn(this, Or, Li).call(this, me(this, na)), nn(this, Or, Li).call(this, me(this, ii));
      for (const c of me(this, Sa)) Fa(c);
      for (const c of me(this, ai)) Fa(c);
      xt(this, Sa, []), xt(this, ai, []);
    }
    capture(t, r) {
      me(this, Ti).has(t) || me(this, Ti).set(t, r), this.current.set(t, t.v);
    }
    activate() {
      sn = this;
    }
    deactivate() {
      sn = null, pi = null;
      for (const t of Rl) if (Rl.delete(t), t(), sn !== null) break;
    }
    neuter() {
      xt(this, Gi, !0);
    }
    flush() {
      ha.length > 0 ? fo() : nn(this, Or, Ml).call(this), sn === this && (me(this, xr) === 0 && jl.delete(this), this.deactivate());
    }
    increment() {
      xt(this, xr, me(this, xr) + 1);
    }
    decrement() {
      if (xt(this, xr, me(this, xr) - 1), me(this, xr) === 0) {
        for (const t of me(this, Oi)) On(t, Mr), Ta(t);
        for (const t of me(this, Fi)) On(t, ua), Ta(t);
        xt(this, Ca, []), xt(this, na, []), this.flush();
      } else this.deactivate();
    }
    add_callback(t) {
      me(this, ni).add(t);
    }
    settled() {
      var t, r, a;
      return ((t = me(this, ri)) != null ? t : xt(this, ri, { promise: new Promise((l, c) => {
        r = l, a = c;
      }), resolve: r, reject: a })).promise;
    }
    static ensure() {
      if (sn === null) {
        const t = sn = new Ns();
        jl.add(sn), fi || Ns.enqueue(() => {
          sn === t && t.flush();
        });
      }
      return sn;
    }
    static enqueue(t) {
      ga(t);
    }
  };
  function k(n) {
    var t = fi;
    fi = !0;
    try {
      for (; ; ) {
        if (vd(), ha.length === 0 && !bd() && (sn == null || sn.flush(), ha.length === 0)) return void (tl = null);
        fo();
      }
    } finally {
      fi = t;
    }
  }
  function fo() {
    var n = Oa;
    Ql = !0;
    try {
      var t = 0;
      for (Oo(!0); ha.length > 0; ) {
        var r = pa.ensure();
        t++ > 1e3 && kd(), r.process(ha), Ur.clear();
      }
    } finally {
      Ql = !1, Oo(n), tl = null;
    }
  }
  function kd() {
    try {
      (function() {
        throw new Error("https://svelte.dev/e/effect_update_depth_exceeded");
      })();
    } catch (n) {
      Va(n, tl);
    }
  }
  let Wr = null;
  function bo(n) {
    var t = n.length;
    if (t !== 0) {
      for (var r = 0; r < t; ) {
        var a = n[r++];
        if (!(24576 & a.f) && il(a) && (Wr = [], Fa(a), a.deps === null && a.first === null && a.nodes_start === null && (a.teardown === null && a.ac === null ? Vo(a) : a.fn = null), (Wr == null ? void 0 : Wr.length) > 0)) {
          Ur.clear();
          for (const l of Wr) Fa(l);
          Wr = [];
        }
      }
      Wr = null;
    }
  }
  function Ta(n) {
    for (var t = tl = n; t.parent !== null; ) {
      var r = (t = t.parent).f;
      if (Ql && t === $t && (r & ui) !== 0) return;
      if (96 & r) {
        if ((r & Cn) === 0) return;
        t.f ^= Cn;
      }
    }
    ha.push(t);
  }
  function md(n) {
    let t, r = 0, a = zr(0);
    return () => {
      Tt === null || or || (e(a), vi(() => (r === 0 && (t = Xt(() => n(() => jn(a)))), r += 1, () => {
        ga(() => {
          r -= 1, r === 0 && (t == null || t(), t = void 0, jn(a));
        });
      })));
    };
  }
  class yd {
    constructor(t, r, a) {
      It(this, Un), fn(this, "parent"), It(this, hr, !1), It(this, Wn), It(this, Ei, dt ? Mt : null), It(this, wr), It(this, Ba), It(this, Pr), It(this, tr, null), It(this, En, null), It(this, Sr, null), It(this, ra, null), It(this, aa, 0), It(this, Fr, 0), It(this, Ia, !1), It(this, ia, null), It(this, Dl, () => {
        me(this, ia) && Ga(me(this, ia), me(this, aa));
      }), It(this, zl, md(() => (xt(this, ia, zr(me(this, aa))), () => {
        xt(this, ia, null);
      }))), xt(this, Wn, t), xt(this, wr, r), xt(this, Ba, a), this.parent = $t.b, xt(this, hr, !!me(this, wr).pending), xt(this, Pr, Ar(() => {
        if ($t.b = this, dt) {
          const l = me(this, Ei);
          ar(), l.nodeType === 8 && l.data === Ui ? nn(this, Un, Zs).call(this) : nn(this, Un, Hs).call(this);
        } else {
          try {
            xt(this, tr, xn(() => a(me(this, Wn))));
          } catch (l) {
            this.error(l);
          }
          me(this, Fr) > 0 ? nn(this, Un, Ri).call(this) : xt(this, hr, !1);
        }
      }, 589952)), dt && xt(this, Wn, Mt);
    }
    is_pending() {
      return me(this, hr) || !!this.parent && this.parent.is_pending();
    }
    has_pending_snippet() {
      return !!me(this, wr).pending;
    }
    update_pending_count(t) {
      nn(this, Un, Al).call(this, t), xt(this, aa, me(this, aa) + t), Rl.add(me(this, Dl));
    }
    get_effect_pending() {
      return me(this, zl).call(this), e(me(this, ia));
    }
    error(t) {
      var r = me(this, wr).onerror;
      let a = me(this, wr).failed;
      if (me(this, Ia) || !r && !a) throw t;
      me(this, tr) && (wn(me(this, tr)), xt(this, tr, null)), me(this, En) && (wn(me(this, En)), xt(this, En, null)), me(this, Sr) && (wn(me(this, Sr)), xt(this, Sr, null)), dt && (mn(me(this, Ei)), Rr(), mn(Ki()));
      var l = !1, c = !1;
      const u = () => {
        l ? console.warn("https://svelte.dev/e/svelte_boundary_reset_noop") : (l = !0, c && (function() {
          throw new Error("https://svelte.dev/e/svelte_boundary_reset_onerror");
        })(), pa.ensure(), xt(this, aa, 0), me(this, Sr) !== null && $r(me(this, Sr), () => {
          xt(this, Sr, null);
        }), xt(this, hr, this.has_pending_snippet()), xt(this, tr, nn(this, Un, ji).call(this, () => (xt(this, Ia, !1), xn(() => me(this, Ba).call(this, me(this, Wn)))))), me(this, Fr) > 0 ? nn(this, Un, Ri).call(this) : xt(this, hr, !1));
      };
      var s = Tt;
      try {
        Bn(null), c = !0, r == null || r(t, u), c = !1;
      } catch (i) {
        Va(i, me(this, Pr) && me(this, Pr).parent);
      } finally {
        Bn(s);
      }
      a && ga(() => {
        xt(this, Sr, nn(this, Un, ji).call(this, () => {
          xt(this, Ia, !0);
          try {
            return xn(() => {
              a(me(this, Wn), () => t, () => u);
            });
          } catch (i) {
            return Va(i, me(this, Pr).parent), null;
          } finally {
            xt(this, Ia, !1);
          }
        }));
      });
    }
  }
  function vo(n, t, r) {
    const a = $a() ? bi : Nl;
    if (t.length !== 0) {
      var l = sn, c = $t, u = (function() {
        var i = $t, o = Tt, d = rn, h = sn, f = dt;
        if (f) var p = Mt;
        return function() {
          br(i), Bn(o), Aa(d), h == null || h.activate(), f && (zn(!0), mn(p));
        };
      })(), s = dt;
      Promise.all(t.map((i) => xd(i))).then((i) => {
        l == null || l.activate(), u();
        try {
          r([...n.map(a), ...i]);
        } catch (o) {
          (c.f & Ma) === 0 && Va(o, c);
        }
        s && zn(!1), l == null || l.deactivate(), _o();
      }).catch((i) => {
        Va(i, c);
      });
    } else r(n.map(a));
  }
  function _o() {
    br(null), Bn(null), Aa(null);
  }
  function bi(n) {
    var t = 2050, r = Tt !== null && 2 & Tt.f ? Tt : null;
    return $t === null || r !== null && (r.f & rr) !== 0 ? t |= rr : $t.f |= ro, { ctx: rn, deps: null, effects: null, equals: so, f: t, fn: n, reactions: null, rv: 0, v: kn, wv: 0, parent: r != null ? r : $t, ac: null };
  }
  function xd(n, t) {
    let r = $t;
    r === null && (function() {
      throw new Error("https://svelte.dev/e/async_derived_orphan");
    })();
    var a = r.b, l = void 0, c = zr(kn), u = null, s = !Tt;
    return (function(i) {
      sr(4718592, i, !0);
    })(() => {
      var i;
      try {
        var o = n();
        u && Promise.resolve(o).catch(() => {
        });
      } catch (_) {
        o = Promise.reject(_);
      }
      var d = () => o;
      l = (i = u == null ? void 0 : u.then(d, d)) != null ? i : Promise.resolve(o), u = l;
      var h = sn, f = a.is_pending();
      s && (a.update_pending_count(1), f || h.increment());
      const p = (_, I = void 0) => {
        u = null, f || h.activate(), I ? I !== El && (c.f |= da, Ga(c, I)) : ((c.f & da) !== 0 && (c.f ^= da), Ga(c, _)), s && (a.update_pending_count(-1), f || h.decrement()), _o();
      };
      if (l.then(p, (_) => p(null, _ || "unknown")), h) return () => {
        queueMicrotask(() => h.neuter());
      };
    }), new Promise((i) => {
      (function o(d) {
        function h() {
          d === l ? i(c) : o(l);
        }
        d.then(h, h);
      })(l);
    });
  }
  function g(n) {
    const t = bi(n);
    return Lo(t), t;
  }
  function Nl(n) {
    const t = bi(n);
    return t.equals = oo, t;
  }
  function ko(n) {
    var t = n.effects;
    if (t !== null) {
      n.effects = null;
      for (var r = 0; r < t.length; r += 1) wn(t[r]);
    }
  }
  function Wl(n) {
    var t, r = $t;
    br((function(a) {
      for (var l = a.parent; l !== null; ) {
        if (!(2 & l.f)) return l;
        l = l.parent;
      }
      return null;
    })(n));
    try {
      ko(n), t = No(n);
    } finally {
      br(r);
    }
    return t;
  }
  function mo(n) {
    var t = Wl(n);
    n.equals(t) || (n.v = t, n.wv = Ro()), fa || On(n, !Hr && (n.f & rr) === 0 || n.deps === null ? Cn : ua);
  }
  hr = /* @__PURE__ */ new WeakMap(), Wn = /* @__PURE__ */ new WeakMap(), Ei = /* @__PURE__ */ new WeakMap(), wr = /* @__PURE__ */ new WeakMap(), Ba = /* @__PURE__ */ new WeakMap(), Pr = /* @__PURE__ */ new WeakMap(), tr = /* @__PURE__ */ new WeakMap(), En = /* @__PURE__ */ new WeakMap(), Sr = /* @__PURE__ */ new WeakMap(), ra = /* @__PURE__ */ new WeakMap(), aa = /* @__PURE__ */ new WeakMap(), Fr = /* @__PURE__ */ new WeakMap(), Ia = /* @__PURE__ */ new WeakMap(), ia = /* @__PURE__ */ new WeakMap(), Dl = /* @__PURE__ */ new WeakMap(), zl = /* @__PURE__ */ new WeakMap(), Un = /* @__PURE__ */ new WeakSet(), Hs = function() {
    try {
      xt(this, tr, xn(() => me(this, Ba).call(this, me(this, Wn))));
    } catch (n) {
      this.error(n);
    }
    xt(this, hr, !1);
  }, Zs = function() {
    const n = me(this, wr).pending;
    n && (xt(this, En, xn(() => n(me(this, Wn)))), pa.enqueue(() => {
      xt(this, tr, nn(this, Un, ji).call(this, () => (pa.ensure(), xn(() => me(this, Ba).call(this, me(this, Wn)))))), me(this, Fr) > 0 ? nn(this, Un, Ri).call(this) : ($r(me(this, En), () => {
        xt(this, En, null);
      }), xt(this, hr, !1));
    }));
  }, ji = function(n) {
    var t = $t, r = Tt, a = rn;
    br(me(this, Pr)), Bn(me(this, Pr)), Aa(me(this, Pr).ctx);
    try {
      return n();
    } catch (l) {
      return ho(l), null;
    } finally {
      br(t), Bn(r), Aa(a);
    }
  }, Ri = function() {
    const n = me(this, wr).pending;
    me(this, tr) !== null && (xt(this, ra, document.createDocumentFragment()), (function(t, r) {
      for (var a = t.nodes_start, l = t.nodes_end; a !== null; ) {
        var c = a === l ? null : lr(a);
        r.append(a), a = c;
      }
    })(me(this, tr), me(this, ra))), me(this, En) === null && xt(this, En, xn(() => n(me(this, Wn))));
  }, Al = function(n) {
    var t;
    this.has_pending_snippet() ? (xt(this, Fr, me(this, Fr) + n), me(this, Fr) === 0 && (xt(this, hr, !1), me(this, En) && $r(me(this, En), () => {
      xt(this, En, null);
    }), me(this, ra) && (me(this, Wn).before(me(this, ra)), xt(this, ra, null)))) : this.parent && nn(t = this.parent, Un, Al).call(t, n);
  };
  const Ur = /* @__PURE__ */ new Map();
  function zr(n, t) {
    return { f: 0, v: n, reactions: null, equals: so, rv: 0, wv: 0 };
  }
  function Ae(n, t) {
    const r = zr(n);
    return Lo(r), r;
  }
  function Ul(n, t = !1, r = !0) {
    var a, l;
    const c = zr(n);
    return t || (c.equals = oo), za && r && rn !== null && rn.l !== null && ((l = (a = rn.l).s) != null ? l : a.s = []).push(c), c;
  }
  function te(n, t, r = !1) {
    return Tt !== null && (!or || (Tt.f & ud) !== 0) && $a() && 4325394 & Tt.f && !(Zn != null && Zn.includes(n)) && (function() {
      throw new Error("https://svelte.dev/e/state_unsafe_mutation");
    })(), Ga(n, r ? rt(t) : t);
  }
  function Ga(n, t) {
    if (!n.equals(t)) {
      var r = n.v;
      fa ? Ur.set(n, t) : Ur.set(n, r), n.v = t, pa.ensure().capture(n, r), 2 & n.f && ((n.f & Mr) !== 0 && Wl(n), On(n, (n.f & rr) === 0 ? Cn : ua)), n.wv = Ro(), yo(n, Mr), !$a() || $t === null || ($t.f & Cn) === 0 || 96 & $t.f || (Jn === null ? (function(a) {
        Jn = a;
      })([n]) : Jn.push(n));
    }
    return t;
  }
  function jn(n) {
    te(n, n.v + 1);
  }
  function yo(n, t) {
    var r = n.reactions;
    if (r !== null) for (var a = $a(), l = r.length, c = 0; c < l; c++) {
      var u = r[c], s = u.f;
      if (a || u !== $t) {
        var i = (s & Mr) === 0;
        i && On(u, t), 2 & s ? yo(u, ua) : i && ((s & ui) !== 0 && Wr !== null && Wr.push(u), Ta(u));
      }
    }
  }
  function rt(n) {
    if (typeof n != "object" || n === null || Dr in n) return n;
    const t = Zi(n);
    if (t !== eo && t !== od) return n;
    var r = /* @__PURE__ */ new Map(), a = ci(n), l = Ae(0), c = cr, u = (s) => {
      if (cr === c) return s();
      var i = Tt, o = cr;
      Bn(null), jo(c);
      var d = s();
      return Bn(i), jo(o), d;
    };
    return a && r.set("length", Ae(n.length)), new Proxy(n, { defineProperty(s, i, o) {
      "value" in o && o.configurable !== !1 && o.enumerable !== !1 && o.writable !== !1 || (function() {
        throw new Error("https://svelte.dev/e/state_descriptors_fixed");
      })();
      var d = r.get(i);
      return d === void 0 ? d = u(() => {
        var h = Ae(o.value);
        return r.set(i, h), h;
      }) : te(d, o.value, !0), !0;
    }, deleteProperty(s, i) {
      var o = r.get(i);
      if (o === void 0) {
        if (i in s) {
          const d = u(() => Ae(kn));
          r.set(i, d), jn(l);
        }
      } else te(o, kn), jn(l);
      return !0;
    }, get(s, i, o) {
      var d;
      if (i === Dr) return n;
      var h = r.get(i), f = i in s;
      if (h !== void 0 || f && !((d = ca(s, i)) != null && d.writable) || (h = u(() => Ae(rt(f ? s[i] : kn))), r.set(i, h)), h !== void 0) {
        var p = e(h);
        return p === kn ? void 0 : p;
      }
      return Reflect.get(s, i, o);
    }, getOwnPropertyDescriptor(s, i) {
      var o = Reflect.getOwnPropertyDescriptor(s, i);
      if (o && "value" in o) {
        var d = r.get(i);
        d && (o.value = e(d));
      } else if (o === void 0) {
        var h = r.get(i), f = h == null ? void 0 : h.v;
        if (h !== void 0 && f !== kn) return { enumerable: !0, configurable: !0, value: f, writable: !0 };
      }
      return o;
    }, has(s, i) {
      var o;
      if (i === Dr) return !0;
      var d = r.get(i), h = d !== void 0 && d.v !== kn || Reflect.has(s, i);
      return (d !== void 0 || $t !== null && (!h || (o = ca(s, i)) != null && o.writable)) && (d === void 0 && (d = u(() => Ae(h ? rt(s[i]) : kn)), r.set(i, d)), e(d) === kn) ? !1 : h;
    }, set(s, i, o, d) {
      var h, f = r.get(i), p = i in s;
      if (a && i === "length") for (var _ = o; _ < f.v; _ += 1) {
        var I = r.get(_ + "");
        I !== void 0 ? te(I, kn) : _ in s && (I = u(() => Ae(kn)), r.set(_ + "", I));
      }
      f === void 0 ? p && !((h = ca(s, i)) != null && h.writable) || (te(f = u(() => Ae(void 0)), rt(o)), r.set(i, f)) : (p = f.v !== kn, te(f, u(() => rt(o))));
      var y = Reflect.getOwnPropertyDescriptor(s, i);
      if (y != null && y.set && y.set.call(d, o), !p) {
        if (a && typeof i == "string") {
          var x = r.get("length"), M = Number(i);
          Number.isInteger(M) && M >= x.v && te(x, M + 1);
        }
        jn(l);
      }
      return !0;
    }, ownKeys(s) {
      e(l);
      var i = Reflect.ownKeys(s).filter((h) => {
        var f = r.get(h);
        return f === void 0 || f.v !== kn;
      });
      for (var [o, d] of r) d.v === kn || o in s || i.push(o);
      return i;
    }, setPrototypeOf() {
      (function() {
        throw new Error("https://svelte.dev/e/state_prototype_fixed");
      })();
    } });
  }
  function xo(n) {
    try {
      if (n !== null && typeof n == "object" && Dr in n) return n[Dr];
    } catch {
    }
    return n;
  }
  function wd(n, t) {
    return Object.is(xo(n), xo(t));
  }
  var wo, Po, So, Co;
  function Hl() {
    if (wo === void 0) {
      wo = window, Po = /Firefox/.test(navigator.userAgent);
      var n = Element.prototype, t = Node.prototype, r = Text.prototype;
      So = ca(t, "firstChild").get, Co = ca(t, "nextSibling").get, to(n) && (n.__click = void 0, n.__className = void 0, n.__attributes = null, n.__style = void 0, n.__e = void 0), to(r) && (r.__t = void 0);
    }
  }
  function ir(n = "") {
    return document.createTextNode(n);
  }
  function Gn(n) {
    return So.call(n);
  }
  function lr(n) {
    return Co.call(n);
  }
  function P(n, t) {
    if (!dt) return Gn(n);
    var r = Gn(Mt);
    if (r === null) r = Mt.appendChild(ir());
    else if (t && r.nodeType !== 3) {
      var a = ir();
      return r == null || r.before(a), mn(a), a;
    }
    return mn(r), r;
  }
  function ve(n, t = !1) {
    if (!dt) {
      var r = Gn(n);
      return r instanceof Comment && r.data === "" ? lr(r) : r;
    }
    if (t && (Mt == null ? void 0 : Mt.nodeType) !== 3) {
      var a = ir();
      return Mt == null || Mt.before(a), mn(a), a;
    }
    return Mt;
  }
  function E(n, t = 1, r = !1) {
    let a = dt ? Mt : n;
    for (var l; t--; ) l = a, a = lr(a);
    if (!dt) return a;
    if (r && (a == null ? void 0 : a.nodeType) !== 3) {
      var c = ir();
      return a === null ? l == null || l.after(c) : a.before(c), mn(c), c;
    }
    return mn(a), a;
  }
  function Bo(n) {
    n.textContent = "";
  }
  function Pd(n, t) {
    if (t) {
      const r = document.body;
      n.autofocus = !0, ga(() => {
        document.activeElement === r && n.focus();
      });
    }
  }
  let Io = !1;
  function Mo() {
    Io || (Io = !0, document.addEventListener("reset", (n) => {
      Promise.resolve().then(() => {
        var t;
        if (!n.defaultPrevented) for (const r of n.target.elements) (t = r.__on_r) == null || t.call(r);
      });
    }, { capture: !0 }));
  }
  function nl(n) {
    var t = Tt, r = $t;
    Bn(null), br(null);
    try {
      return n();
    } finally {
      Bn(t), br(r);
    }
  }
  function Do(n) {
    $t === null && Tt === null && (function() {
      throw new Error("https://svelte.dev/e/effect_orphan");
    })(), Tt !== null && (Tt.f & rr) !== 0 && $t === null && (function() {
      throw new Error("https://svelte.dev/e/effect_in_unowned_derived");
    })(), fa && (function() {
      throw new Error("https://svelte.dev/e/effect_in_teardown");
    })();
  }
  function sr(n, t, r, a = !0) {
    var l, c = $t;
    c !== null && (c.f & fr) !== 0 && (n |= fr);
    var u = { ctx: rn, deps: null, nodes_start: null, nodes_end: null, f: n | Mr, first: null, fn: t, last: null, next: null, parent: c, b: c && c.b, prev: null, teardown: null, transitions: null, wv: 0, ac: null };
    if (r) try {
      Fa(u), u.f |= Fl;
    } catch (o) {
      throw wn(u), o;
    }
    else t !== null && Ta(u);
    if (a) {
      var s = u;
      if (r && s.deps === null && s.teardown === null && s.nodes_start === null && s.first === s.last && (s.f & ro) === 0 && (s = s.first), s !== null && (s.parent = c, c !== null && (function(o, d) {
        var h = d.last;
        h === null ? d.last = d.first = o : (h.next = o, o.prev = h, d.last = o);
      })(s, c), Tt !== null && 2 & Tt.f && (n & no) === 0)) {
        var i = Tt;
        ((l = i.effects) != null ? l : i.effects = []).push(s);
      }
    }
    return u;
  }
  function Zl(n) {
    const t = sr(8, null, !1);
    return On(t, Cn), t.teardown = n, t;
  }
  function He(n) {
    var t;
    Do();
    var r = $t.f;
    if (!(!Tt && (r & Yi) !== 0 && (r & Fl) === 0)) return zo(n);
    var a = rn;
    ((t = a.e) != null ? t : a.e = []).push(n);
  }
  function zo(n) {
    return sr(1048580, n, !1);
  }
  function Hn(n) {
    return Do(), sr(1048584, n, !0);
  }
  function rl(n) {
    return sr(4, n, !1);
  }
  function vi(n, t = 0) {
    return sr(8 | t, n, !0);
  }
  function be(n, t = [], r = []) {
    vo(t, r, (a) => {
      sr(8, () => n(...a.map(e)), !0);
    });
  }
  function Ar(n, t = 0) {
    return sr(ui | t, n, !0);
  }
  function xn(n, t = !0) {
    return sr(524320, n, !0, t);
  }
  function Ao(n) {
    var t = n.teardown;
    if (t !== null) {
      const r = fa, a = Tt;
      Fo(!0), Bn(null);
      try {
        t.call(null);
      } finally {
        Fo(r), Bn(a);
      }
    }
  }
  function $o(n, t = !1) {
    var r = n.first;
    for (n.first = n.last = null; r !== null; ) {
      const l = r.ac;
      l !== null && nl(() => {
        l.abort(El);
      });
      var a = r.next;
      (r.f & no) !== 0 ? r.parent = null : wn(r, t), r = a;
    }
  }
  function wn(n, t = !0) {
    var r = !1;
    (t || 262144 & n.f) && n.nodes_start !== null && n.nodes_end !== null && (qo(n.nodes_start, n.nodes_end), r = !0), $o(n, t && !r), ll(n, 0), On(n, Ma);
    var a = n.transitions;
    if (a !== null) for (const c of a) c.stop();
    Ao(n);
    var l = n.parent;
    l !== null && l.first !== null && Vo(n), n.next = n.prev = n.teardown = n.ctx = n.deps = n.fn = n.nodes_start = n.nodes_end = n.ac = null;
  }
  function qo(n, t) {
    for (; n !== null; ) {
      var r = n === t ? null : lr(n);
      n.remove(), n = r;
    }
  }
  function Vo(n) {
    var t = n.parent, r = n.prev, a = n.next;
    r !== null && (r.next = a), a !== null && (a.prev = r), t !== null && (t.first === n && (t.first = a), t.last === n && (t.last = r));
  }
  function $r(n, t) {
    var r = [];
    Jl(n, r, !0), To(r, () => {
      wn(n), t && t();
    });
  }
  function To(n, t) {
    var r = n.length;
    if (r > 0) {
      var a = () => --r || t();
      for (var l of n) l.out(a);
    } else t();
  }
  function Jl(n, t, r) {
    if ((n.f & fr) === 0) {
      if (n.f ^= fr, n.transitions !== null) for (const c of n.transitions) (c.is_global || r) && t.push(c);
      for (var a = n.first; a !== null; ) {
        var l = a.next;
        Jl(a, t, ((a.f & Da) !== 0 || (a.f & Yi) !== 0) && r), a = l;
      }
    }
  }
  function al(n) {
    Go(n, !0);
  }
  function Go(n, t) {
    if ((n.f & fr) !== 0) {
      n.f ^= fr, (n.f & Cn) === 0 && (On(n, Mr), Ta(n));
      for (var r = n.first; r !== null; ) {
        var a = r.next;
        Go(r, ((r.f & Da) !== 0 || (r.f & Yi) !== 0) && t), r = a;
      }
      if (n.transitions !== null) for (const l of n.transitions) (l.is_global || t) && l.in();
    }
  }
  let Oa = !1;
  function Oo(n) {
    Oa = n;
  }
  let fa = !1;
  function Fo(n) {
    fa = n;
  }
  let Tt = null, or = !1;
  function Bn(n) {
    Tt = n;
  }
  let $t = null;
  function br(n) {
    $t = n;
  }
  let Zn = null;
  function Lo(n) {
    Tt !== null && (Zn === null ? Zn = [n] : Zn.push(n));
  }
  let An = null, Rn = 0, Jn = null, Eo = 1, _i = 0, cr = _i;
  function jo(n) {
    cr = n;
  }
  let Hr = !1;
  function Ro() {
    return ++Eo;
  }
  function il(n) {
    var t, r, a = n.f;
    if ((a & Mr) !== 0) return !0;
    if ((a & ua) !== 0) {
      var l = n.deps, c = (a & rr) !== 0;
      if (l !== null) {
        var u, s, i = (a & Ol) !== 0, o = c && $t !== null && !Hr, d = l.length;
        if ((i || o) && ($t === null || ($t.f & Ma) === 0)) {
          var h = n, f = h.parent;
          for (u = 0; u < d; u++) s = l[u], !i && ((t = s == null ? void 0 : s.reactions) != null && t.includes(h)) || ((r = s.reactions) != null ? r : s.reactions = []).push(h);
          i && (h.f ^= Ol), o && f !== null && (f.f & rr) === 0 && (h.f ^= rr);
        }
        for (u = 0; u < d; u++) if (il(s = l[u]) && mo(s), s.wv > n.wv) return !0;
      }
      c && ($t === null || Hr) || On(n, Cn);
    }
    return !1;
  }
  function Qo(n, t, r = !0) {
    var a = n.reactions;
    if (a !== null && !(Zn != null && Zn.includes(n))) for (var l = 0; l < a.length; l++) {
      var c = a[l];
      2 & c.f ? Qo(c, t, !1) : t === c && (r ? On(c, Mr) : (c.f & Cn) !== 0 && On(c, ua), Ta(c));
    }
  }
  function No(n) {
    var t, r, a = An, l = Rn, c = Jn, u = Tt, s = Hr, i = Zn, o = rn, d = or, h = cr, f = n.f;
    An = null, Rn = 0, Jn = null, Hr = (f & rr) !== 0 && (or || !Oa || Tt === null), Tt = 96 & f ? null : n, Zn = null, Aa(n.ctx), or = !1, cr = ++_i, n.ac !== null && (nl(() => {
      n.ac.abort(El);
    }), n.ac = null);
    try {
      n.f |= Ll;
      var p = (0, n.fn)(), _ = n.deps;
      if (An !== null) {
        var I;
        if (ll(n, Rn), _ !== null && Rn > 0) for (_.length = Rn + An.length, I = 0; I < An.length; I++) _[Rn + I] = An[I];
        else n.deps = _ = An;
        if (!Hr || 2 & f && n.reactions !== null) for (I = Rn; I < _.length; I++) ((r = (t = _[I]).reactions) != null ? r : t.reactions = []).push(n);
      } else _ !== null && Rn < _.length && (ll(n, Rn), _.length = Rn);
      if ($a() && Jn !== null && !or && _ !== null && !(6146 & n.f)) for (I = 0; I < Jn.length; I++) Qo(Jn[I], n);
      return u !== null && u !== n && (_i++, Jn !== null && (c === null ? c = Jn : c.push(...Jn))), (n.f & da) !== 0 && (n.f ^= da), p;
    } catch (y) {
      return ho(y);
    } finally {
      n.f ^= Ll, An = a, Rn = l, Jn = c, Tt = u, Hr = s, Zn = i, Aa(o), or = d, cr = h;
    }
  }
  function Sd(n, t) {
    let r = t.reactions;
    if (r !== null) {
      var a = sd.call(r, n);
      if (a !== -1) {
        var l = r.length - 1;
        l === 0 ? r = t.reactions = null : (r[a] = r[l], r.pop());
      }
    }
    r === null && 2 & t.f && (An === null || !An.includes(t)) && (On(t, ua), 768 & t.f || (t.f ^= Ol), ko(t), ll(t, 0));
  }
  function ll(n, t) {
    var r = n.deps;
    if (r !== null) for (var a = t; a < r.length; a++) Sd(n, r[a]);
  }
  function Fa(n) {
    var t = n.f;
    if ((t & Ma) === 0) {
      On(n, Cn);
      var r = $t, a = Oa;
      $t = n, Oa = !0;
      try {
        (t & ui) !== 0 ? (function(c) {
          for (var u = c.first; u !== null; ) {
            var s = u.next;
            (u.f & Yi) === 0 && wn(u), u = s;
          }
        })(n) : $o(n), Ao(n);
        var l = No(n);
        n.teardown = typeof l == "function" ? l : null, n.wv = Eo;
      } finally {
        Oa = a, $t = r;
      }
    }
  }
  async function Yl() {
    await Promise.resolve(), k();
  }
  function e(n) {
    var t, r = !!(2 & n.f);
    if (Tt === null || or) {
      if (r && n.deps === null && n.effects === null) {
        var a = n, l = a.parent;
        l !== null && (l.f & rr) === 0 && (a.f ^= rr);
      }
    } else if (!($t !== null && ($t.f & Ma) !== 0) && !(Zn != null && Zn.includes(n))) {
      var c = Tt.deps;
      if ((Tt.f & Ll) !== 0) n.rv < _i && (n.rv = _i, An === null && c !== null && c[Rn] === n ? Rn++ : An === null ? An = [n] : Hr && An.includes(n) || An.push(n));
      else {
        ((t = Tt.deps) != null ? t : Tt.deps = []).push(n);
        var u = n.reactions;
        u === null ? n.reactions = [Tt] : u.includes(Tt) || u.push(Tt);
      }
    }
    if (fa) {
      if (Ur.has(n)) return Ur.get(n);
      if (r) {
        var s = (a = n).v;
        return ((a.f & Cn) === 0 && a.reactions !== null || Wo(a)) && (s = Wl(a)), Ur.set(a, s), s;
      }
    } else r && il(a = n) && mo(a);
    if ((n.f & da) !== 0) throw n.v;
    return n.v;
  }
  function Wo(n) {
    if (n.v === kn) return !0;
    if (n.deps === null) return !1;
    for (const t of n.deps)
      if (Ur.has(t) || 2 & t.f && Wo(t)) return !0;
    return !1;
  }
  function Xt(n) {
    var t = or;
    try {
      return or = !0, n();
    } finally {
      or = t;
    }
  }
  const Cd = -7169;
  function On(n, t) {
    n.f = n.f & Cd | t;
  }
  function Uo(n) {
    if (typeof n == "object" && n && !(n instanceof EventTarget)) {
      if (Dr in n) Kl(n);
      else if (!Array.isArray(n)) for (let t in n) {
        const r = n[t];
        typeof r == "object" && r && Dr in r && Kl(r);
      }
    }
  }
  function Kl(n, t = /* @__PURE__ */ new Set()) {
    if (!(typeof n != "object" || n === null || n instanceof EventTarget || t.has(n))) {
      t.add(n), n instanceof Date && n.getTime();
      for (let a in n) try {
        Kl(n[a], t);
      } catch {
      }
      const r = Zi(n);
      if (r !== Object.prototype && r !== Array.prototype && r !== Map.prototype && r !== Set.prototype && r !== Date.prototype) {
        const a = Xs(r);
        for (let l in a) {
          const c = a[l].get;
          if (c) try {
            c.call(n);
          } catch {
          }
        }
      }
    }
  }
  const Ho = /* @__PURE__ */ new Set(), Xl = /* @__PURE__ */ new Set();
  function Zo(n, t, r, a = {}) {
    function l(c) {
      if (a.capture || ki.call(t, c), !c.cancelBubble) return nl(() => r == null ? void 0 : r.call(this, c));
    }
    return n.startsWith("pointer") || n.startsWith("touch") || n === "wheel" ? ga(() => {
      t.addEventListener(n, l, a);
    }) : t.addEventListener(n, l, a), l;
  }
  function Jo(n, t, r, a, l) {
    var c = { capture: a, passive: l }, u = Zo(n, t, r, c);
    (t === document.body || t === window || t === document || t instanceof HTMLMediaElement) && Zl(() => {
      t.removeEventListener(n, u, c);
    });
  }
  function Pn(n) {
    for (var t = 0; t < n.length; t++) Ho.add(n[t]);
    for (var r of Xl) r(n);
  }
  let Yo = null;
  function ki(n) {
    var t, r = this, a = r.ownerDocument, l = n.type, c = ((t = n.composedPath) == null ? void 0 : t.call(n)) || [], u = c[0] || n.target;
    Yo = n;
    var s = 0, i = Yo === n && n.__root;
    if (i) {
      var o = c.indexOf(i);
      if (o !== -1 && (r === document || r === window)) return void (n.__root = r);
      var d = c.indexOf(r);
      if (d === -1) return;
      o <= d && (s = o);
    }
    if ((u = c[s] || n.target) !== r) {
      oa(n, "currentTarget", { configurable: !0, get: () => u || a });
      var h = Tt, f = $t;
      Bn(null), br(null);
      try {
        for (var p, _ = []; u !== null; ) {
          var I = u.assignedSlot || u.parentNode || u.host || null;
          try {
            var y = u["__" + l];
            if (y != null && (!u.disabled || n.target === u)) if (ci(y)) {
              var [x, ...M] = y;
              x.apply(u, [n, ...M]);
            } else y.call(u, n);
          } catch (A) {
            p ? _.push(A) : p = A;
          }
          if (n.cancelBubble || I === r || I === null) break;
          u = I;
        }
        if (p) {
          for (let A of _) queueMicrotask(() => {
            throw A;
          });
          throw p;
        }
      } finally {
        n.__root = r, delete n.currentTarget, Bn(h), br(f);
      }
    }
  }
  function es(n) {
    var t = document.createElement("template");
    return t.innerHTML = n.replaceAll("<!>", "<!---->"), t.content;
  }
  function Qn(n, t) {
    var r = $t;
    r.nodes_start === null && (r.nodes_start = n, r.nodes_end = t);
  }
  function D(n, t) {
    var r, a = !!(1 & t), l = !!(2 & t), c = !n.startsWith("<!>");
    return () => {
      if (dt) return Qn(Mt, null), Mt;
      r === void 0 && (r = es(c ? n : "<!>" + n), a || (r = Gn(r)));
      var u = l || Po ? document.importNode(r, !0) : r.cloneNode(!0);
      return a ? Qn(Gn(u), u.lastChild) : Qn(u, u), u;
    };
  }
  function Bd(n, t, r = "svg") {
    var a, l = `<${r}>${n.startsWith("<!>") ? "<!>" + n : n}</${r}>`;
    return () => {
      if (dt) return Qn(Mt, null), Mt;
      if (!a) {
        var c = es(l);
        a = Gn(Gn(c));
      }
      var u = a.cloneNode(!0);
      return Qn(u, u), u;
    };
  }
  function $n(n, t) {
    return Bd(n, 0, "svg");
  }
  function In(n = "") {
    if (!dt) {
      var t = ir(n + "");
      return Qn(t, t), t;
    }
    var r = Mt;
    return r.nodeType !== 3 && (r.before(r = ir()), mn(r)), Qn(r, r), r;
  }
  function De() {
    if (dt) return Qn(Mt, null), Mt;
    var n = document.createDocumentFragment(), t = document.createComment(""), r = ir();
    return n.append(t, r), Qn(t, r), n;
  }
  function v(n, t) {
    if (dt) return $t.nodes_end = Mt, void ar();
    n !== null && n.before(t);
  }
  function Id(n) {
    return n.endsWith("capture") && n !== "gotpointercapture" && n !== "lostpointercapture";
  }
  const Md = ["beforeinput", "click", "change", "dblclick", "contextmenu", "focusin", "focusout", "input", "keydown", "keyup", "mousedown", "mousemove", "mouseout", "mouseover", "mouseup", "pointerdown", "pointermove", "pointerout", "pointerover", "pointerup", "touchend", "touchmove", "touchstart"];
  function Dd(n) {
    return Md.includes(n);
  }
  const zd = { formnovalidate: "formNoValidate", ismap: "isMap", nomodule: "noModule", playsinline: "playsInline", readonly: "readOnly", defaultvalue: "defaultValue", defaultchecked: "defaultChecked", srcobject: "srcObject", novalidate: "noValidate", allowfullscreen: "allowFullscreen", disablepictureinpicture: "disablePictureInPicture", disableremoteplayback: "disableRemotePlayback" };
  function Ad(n) {
    var t;
    return n = n.toLowerCase(), (t = zd[n]) != null ? t : n;
  }
  const $d = ["touchstart", "touchmove"];
  function qd(n) {
    return $d.includes(n);
  }
  const Vd = ["textarea", "script", "style", "title"];
  function mt(n, t) {
    var r, a = t == null ? "" : typeof t == "object" ? t + "" : t;
    a !== ((r = n.__t) != null ? r : n.__t = n.nodeValue) && (n.__t = a, n.nodeValue = a + "");
  }
  function Ko(n, t) {
    return Xo(n, t);
  }
  function Td(n, t) {
    var r;
    Hl(), t.intro = (r = t.intro) != null && r;
    const a = t.target, l = dt, c = Mt;
    try {
      for (var u = Gn(a); u && (u.nodeType !== 8 || u.data !== "["); ) u = lr(u);
      if (!u) throw sa;
      zn(!0), mn(u);
      const s = Xo(n, { ...t, anchor: u });
      return zn(!1), s;
    } catch (s) {
      if (s instanceof Error && s.message.split(`
`).some((i) => i.startsWith("https://svelte.dev/e/"))) throw s;
      return s !== sa && console.warn("Failed to hydrate: ", s), t.recover === !1 && (function() {
        throw new Error("https://svelte.dev/e/hydration_failed");
      })(), Hl(), Bo(a), zn(!1), Ko(n, t);
    } finally {
      zn(l), mn(c);
    }
  }
  const La = /* @__PURE__ */ new Map();
  function Xo(n, { target: t, anchor: r, props: a = {}, events: l, context: c, intro: u = !0 }) {
    Hl();
    var s = /* @__PURE__ */ new Set(), i = (h) => {
      for (var f = 0; f < h.length; f++) {
        var p = h[f];
        if (!s.has(p)) {
          s.add(p);
          var _ = qd(p);
          t.addEventListener(p, ki, { passive: _ });
          var I = La.get(p);
          I === void 0 ? (document.addEventListener(p, ki, { passive: _ }), La.set(p, 1)) : La.set(p, I + 1);
        }
      }
    };
    i(Gl(Ho)), Xl.add(i);
    var o = void 0, d = (function(h) {
      pa.ensure();
      const f = sr(524352, h, !0);
      return (p = {}) => new Promise((_) => {
        p.outro ? $r(f, () => {
          wn(f), _(void 0);
        }) : (wn(f), _(void 0));
      });
    })(() => {
      var h = r != null ? r : t.appendChild(ir());
      return (function(f, p, _) {
        new yd(f, p, _);
      })(h, { pending: () => {
      } }, (f) => {
        if (c && (Je({}), rn.c = c), l && (a.$$events = l), dt && Qn(f, null), o = n(f, a) || {}, dt && ($t.nodes_end = Mt, Mt === null || Mt.nodeType !== 8 || Mt.data !== "]")) throw di(), sa;
        c && Ye();
      }), () => {
        var f;
        for (var p of s) {
          t.removeEventListener(p, ki);
          var _ = La.get(p);
          --_ === 0 ? (document.removeEventListener(p, ki), La.delete(p)) : La.set(p, _);
        }
        Xl.delete(i), h !== r && ((f = h.parentNode) == null || f.removeChild(h));
      };
    });
    return ts.set(o, d), o;
  }
  let ts = /* @__PURE__ */ new WeakMap();
  function ns(n, t, ...r) {
    var a, l = n, c = jr;
    Ar(() => {
      c !== (c = t()) && (a && (wn(a), a = null), a = xn(() => c(l, ...r)));
    }, Da), dt && (l = Mt);
  }
  function ba(n) {
    var t, r, a;
    rn === null && io(), za && rn.l !== null ? (t = rn, a = t.l, (r = a.u) != null ? r : a.u = { a: [], b: [], m: [] }).m.push(n) : He(() => {
      const l = Xt(n);
      if (typeof l == "function") return l;
    });
  }
  function j(n, t, r = !1) {
    dt && ar();
    var a = n, l = null, c = null, u = kn, s = !1;
    const i = (h, f = !0) => {
      s = !0, d(f, h);
    };
    function o() {
      var h = u ? l : c, f = u ? c : l;
      h && al(h), f && $r(f, () => {
        u ? c = null : l = null;
      });
    }
    const d = (h, f) => {
      if (u === (u = h)) return;
      let p = !1;
      if (dt) {
        const I = lo(a) === Ui;
        !!u === I && (mn(a = Ki()), zn(!1), p = !0);
      }
      var _ = a;
      u ? l != null || (l = f && xn(() => f(_))) : c != null || (c = f && xn(() => f(_))), o(), p && zn(!0);
    };
    Ar(() => {
      s = !1, t(i), s || d(null, null);
    }, r ? Da : 0), dt && (a = Mt);
  }
  function Ke(n, t, r) {
    dt && ar();
    var a, l, c = n, u = kn, s = $a() ? hd : Xi;
    function i() {
      a && $r(a), a = l;
    }
    Ar(() => {
      if (s(u, u = t())) {
        var o = c;
        l = xn(() => r(o)), i();
      }
    }), dt && (c = Mt);
  }
  function Zr(n, t) {
    return t;
  }
  function Jt(n, t, r, a, l, c = null) {
    var u = n, s = { flags: t, items: /* @__PURE__ */ new Map(), first: null };
    if (4 & t) {
      var i = n;
      u = dt ? mn(Gn(i)) : i.appendChild(ir());
    }
    dt && ar();
    var o, d, h = null, f = !1, p = /* @__PURE__ */ new Map(), _ = Nl(() => {
      var y = r();
      return ci(y) ? y : y == null ? [] : Gl(y);
    });
    function I() {
      (function(y, x, M, A, V, C, R, U, F) {
        var se, X, K, J, N, Z, $, S, T, q, W = !!(8 & R), ue = !!(3 & R), Q = x.length, b = M.items, B = M.first, G = B, z = null, H = [], Y = [];
        if (W) for (q = 0; q < Q; q += 1) S = U($ = x[q], q), (T = b.get(S)) !== void 0 && ((se = T.a) == null || se.measure(), (Z != null ? Z : Z = /* @__PURE__ */ new Set()).add(T));
        for (q = 0; q < Q; q += 1) if (S = U($ = x[q], q), (T = b.get(S)) !== void 0) {
          if (ue && Gd(T, $, q, R), (T.e.f & fr) !== 0 && (al(T.e), W && ((X = T.a) == null || X.unfix(), (Z != null ? Z : Z = /* @__PURE__ */ new Set()).delete(T))), T !== G) {
            if (N !== void 0 && N.has(T)) {
              if (H.length < Y.length) {
                var L, O = Y[0];
                z = O.prev;
                var ae = H[0], ee = H[H.length - 1];
                for (L = 0; L < H.length; L += 1) rs(H[L], O, V);
                for (L = 0; L < Y.length; L += 1) N.delete(Y[L]);
                vr(M, ae.prev, ee.next), vr(M, z, ae), vr(M, ee, O), G = O, z = ee, q -= 1, H = [], Y = [];
              } else N.delete(T), rs(T, G, V), vr(M, T.prev, T.next), vr(M, T, z === null ? M.first : z.next), vr(M, z, T), z = T;
              continue;
            }
            for (H = [], Y = []; G !== null && G.k !== S; ) (G.e.f & fr) === 0 && (N != null ? N : N = /* @__PURE__ */ new Set()).add(G), Y.push(G), G = G.next;
            if (G === null) continue;
            T = G;
          }
          H.push(T), z = T, G = T.next;
        } else {
          var le = A.get(S);
          if (le !== void 0) {
            A.delete(S), b.set(S, le);
            var re = z ? z.next : G;
            vr(M, z, le), vr(M, le, re), rs(le, re, V), z = le;
          } else
            z = ec(G ? G.e.nodes_start : V, M, z, z === null ? M.first : z.next, $, S, q, C, R, F);
          b.set(S, z), H = [], Y = [], G = z.next;
        }
        if (G !== null || N !== void 0) {
          for (var fe = N === void 0 ? [] : Gl(N); G !== null; ) (G.e.f & fr) === 0 && fe.push(G), G = G.next;
          var ze = fe.length;
          if (ze > 0) {
            var ce = 4 & R && Q === 0 ? V : null;
            if (W) {
              for (q = 0; q < ze; q += 1) (K = fe[q].a) == null || K.measure();
              for (q = 0; q < ze; q += 1) (J = fe[q].a) == null || J.fix();
            }
            (function(ke, we, _e) {
              for (var ye = ke.items, Se = [], Ve = we.length, Ee = 0; Ee < Ve; Ee++) Jl(we[Ee].e, Se, !0);
              var ne = Ve > 0 && Se.length === 0 && _e !== null;
              if (ne) {
                var ge = _e.parentNode;
                Bo(ge), ge.append(_e), ye.clear(), vr(ke, we[0].prev, we[Ve - 1].next);
              }
              To(Se, () => {
                for (var Te = 0; Te < Ve; Te++) {
                  var pe = we[Te];
                  ne || (ye.delete(pe.k), vr(ke, pe.prev, pe.next)), wn(pe.e, !ne);
                }
              });
            })(M, fe, ce);
          }
        }
        W && ga(() => {
          var ke;
          if (Z !== void 0) for (T of Z) (ke = T.a) == null || ke.apply();
        });
        for (var ie of (y.first = M.first && M.first.e, y.last = z && z.e, A.values())) wn(ie.e);
        A.clear();
      })(d, o, s, p, u, l, t, a, r), c !== null && (o.length === 0 ? h ? al(h) : h = xn(() => c(u)) : h !== null && $r(h, () => {
        h = null;
      }));
    }
    Ar(() => {
      d != null || (d = $t);
      var y = (o = e(_)).length;
      if (f && y === 0) return;
      f = y === 0;
      let x = !1;
      if (dt && lo(u) === Ui != (y === 0) && (mn(u = Ki()), zn(!1), x = !0), dt) {
        for (var M, A = null, V = 0; V < y; V++) {
          if (Mt.nodeType === 8 && Mt.data === "]") {
            u = Mt, x = !0, zn(!1);
            break;
          }
          var C = o[V], R = a(C, V);
          M = ec(Mt, s, A, null, C, R, V, l, t, r), s.items.set(R, M), A = M;
        }
        y > 0 && mn(Ki());
      }
      dt ? y === 0 && c && (h = xn(() => c(u))) : I(), x && zn(!0), e(_);
    }), dt && (u = Mt);
  }
  function Gd(n, t, r, a) {
    1 & a && Ga(n.v, t), 2 & a ? Ga(n.i, r) : n.i = r;
  }
  function ec(n, t, r, a, l, c, u, s, i, o, d) {
    var h = 1 & i ? 16 & i ? zr(l) : Ul(l, !1, !1) : l, f = 2 & i ? zr(u) : u, p = { i: f, v: h, k: c, a: null, e: null, prev: r, next: a };
    try {
      return n === null && document.createDocumentFragment().append(n = ir()), p.e = xn(() => s(n, h, f, o), dt), p.e.prev = r && r.e, p.e.next = a && a.e, r === null ? d || (t.first = p) : (r.next = p, r.e.next = p.e), a !== null && (a.prev = p, a.e.prev = p.e), p;
    } finally {
    }
  }
  function rs(n, t, r) {
    for (var a = n.next ? n.next.e.nodes_start : r, l = t ? t.e.nodes_start : r, c = n.e.nodes_start; c !== null && c !== a; ) {
      var u = lr(c);
      l.before(c), c = u;
    }
  }
  function vr(n, t, r) {
    t === null ? n.first = r : (t.next = r, t.e.next = r && r.e), r !== null && (r.prev = t, r.e.prev = t && t.e);
  }
  function qe(n, t, r = !1, a = !1, l = !1) {
    var c = n, u = "";
    be(() => {
      var s, i = $t;
      if (u !== (u = (s = t()) != null ? s : "")) {
        if (i.nodes_start !== null && (qo(i.nodes_start, i.nodes_end), i.nodes_start = i.nodes_end = null), u !== "") {
          if (dt) {
            Mt.data;
            for (var o = ar(), d = o; o !== null && (o.nodeType !== 8 || o.data !== ""); ) d = o, o = lr(o);
            if (o === null) throw di(), sa;
            return Qn(Mt, d), void (c = mn(o));
          }
          var h = u + "";
          r ? h = `<svg>${h}</svg>` : a && (h = `<math>${h}</math>`);
          var f = es(h);
          if ((r || a) && (f = Gn(f)), Qn(Gn(f), f.lastChild), r || a) for (; Gn(f); ) c.before(Gn(f));
          else c.before(f);
        }
      } else dt && ar();
    });
  }
  function tc(n, t, r, a, l) {
    var c;
    dt && ar();
    var u = (c = t.$$slots) == null ? void 0 : c[r], s = !1;
    u === !0 && (u = t.children, s = !0), u === void 0 || u(n, s ? () => a : a);
  }
  function Od(n, t, r, a, l, c) {
    let u = dt;
    var s, i;
    dt && ar();
    var o = null;
    dt && Mt.nodeType === 1 && (o = Mt, ar());
    var d, h = dt ? Mt : n;
    Ar(() => {
      const f = t() || null;
      var p = f === "svg" ? "http://www.w3.org/2000/svg" : null;
      f !== s && (d && (f === null ? $r(d, () => {
        d = null, i = null;
      }) : f === i ? al(d) : wn(d)), f && f !== i && (d = xn(() => {
        if (Qn(o = dt ? o : p ? document.createElementNS(p, f) : document.createElement(f), o), a) {
          dt && (I = f, Vd.includes(I)) && o.append(document.createComment(""));
          var _ = dt ? Gn(o) : o.appendChild(ir());
          dt && (_ === null ? zn(!1) : mn(_)), a(o, _);
        }
        var I;
        $t.nodes_end = o, h.before(o);
      })), (s = f) && (i = s));
    }, Da), u && (zn(!0), mn(h));
  }
  function as(n, t, r) {
    rl(() => {
      var a = Xt(() => t(n, r == null ? void 0 : r()) || {});
      if (r && (a != null && a.update)) {
        var l = !1, c = {};
        vi(() => {
          var u = r();
          Uo(u), l && Xi(c, u) && (c = u, a.update(u));
        }), l = !0;
      }
      if (a != null && a.destroy) return () => a.destroy();
    });
  }
  function Fd(n, t) {
    var r, a = void 0;
    Ar(() => {
      a !== (a = t()) && (r && (wn(r), r = null), a && (r = xn(() => {
        rl(() => a(n));
      })));
    });
  }
  function nc(n) {
    var t, r, a = "";
    if (typeof n == "string" || typeof n == "number") a += n;
    else if (typeof n == "object") if (Array.isArray(n)) {
      var l = n.length;
      for (t = 0; t < l; t++) n[t] && (r = nc(n[t])) && (a && (a += " "), a += r);
    } else for (r in n) n[r] && (a && (a += " "), a += r);
    return a;
  }
  function mi(n) {
    return typeof n == "object" ? (function() {
      for (var t, r, a = 0, l = "", c = arguments.length; a < c; a++) (t = arguments[a]) && (r = nc(t)) && (l && (l += " "), l += r);
      return l;
    })(n) : n != null ? n : "";
  }
  const rc = [...` 	
\r\f \v\uFEFF`];
  function ac(n, t = !1) {
    var r = t ? " !important;" : ";", a = "";
    for (var l in n) {
      var c = n[l];
      c != null && c !== "" && (a += " " + l + ": " + c + r);
    }
    return a;
  }
  function is(n) {
    return n[0] !== "-" || n[1] !== "-" ? n.toLowerCase() : n;
  }
  function Ot(n, t, r, a, l, c) {
    var u = n.__className;
    if (dt || u !== r || u === void 0) {
      var s = (function(d, h, f) {
        var p = d == null ? "" : "" + d;
        if (h && (p = p ? p + " " + h : h), f) {
          for (var _ in f) if (f[_]) p = p ? p + " " + _ : _;
          else if (p.length) for (var I = _.length, y = 0; (y = p.indexOf(_, y)) >= 0; ) {
            var x = y + I;
            y !== 0 && !rc.includes(p[y - 1]) || x !== p.length && !rc.includes(p[x]) ? y = x : p = (y === 0 ? "" : p.substring(0, y)) + p.substring(x + 1);
          }
        }
        return p === "" ? null : p;
      })(r, a, c);
      dt && s === n.getAttribute("class") || (s == null ? n.removeAttribute("class") : t ? n.className = s : n.setAttribute("class", s)), n.__className = r;
    } else if (c && l !== c) for (var i in c) {
      var o = !!c[i];
      l != null && o === !!l[i] || n.classList.toggle(i, o);
    }
    return c;
  }
  function ls(n, t = {}, r, a) {
    for (var l in r) {
      var c = r[l];
      t[l] !== c && (r[l] == null ? n.style.removeProperty(l) : n.style.setProperty(l, c, a));
    }
  }
  function Wt(n, t, r, a) {
    var l = n.__style;
    if (dt || l !== t) {
      var c = (function(u, s) {
        if (s) {
          var i, o, d = "";
          if (Array.isArray(s) ? (i = s[0], o = s[1]) : i = s, u) {
            u = String(u).replaceAll(/\s*\/\*.*?\*\/\s*/g, "").trim();
            var h = !1, f = 0, p = !1, _ = [];
            i && _.push(...Object.keys(i).map(is)), o && _.push(...Object.keys(o).map(is));
            var I = 0, y = -1;
            const V = u.length;
            for (var x = 0; x < V; x++) {
              var M = u[x];
              if (p ? M === "/" && u[x - 1] === "*" && (p = !1) : h ? h === M && (h = !1) : M === "/" && u[x + 1] === "*" ? p = !0 : M === '"' || M === "'" ? h = M : M === "(" ? f++ : M === ")" && f--, !p && h === !1 && f === 0) {
                if (M === ":" && y === -1) y = x;
                else if (M === ";" || x === V - 1) {
                  if (y !== -1) {
                    var A = is(u.substring(I, y).trim());
                    _.includes(A) || (M !== ";" && x++, d += " " + u.substring(I, x).trim() + ";");
                  }
                  I = x + 1, y = -1;
                }
              }
            }
          }
          return i && (d += ac(i)), o && (d += ac(o, !0)), (d = d.trim()) === "" ? null : d;
        }
        return u == null ? null : String(u);
      })(t, a);
      dt && c === n.getAttribute("style") || (c == null ? n.removeAttribute("style") : n.style.cssText = c), n.__style = t;
    } else a && (Array.isArray(a) ? (ls(n, r == null ? void 0 : r[0], a[0]), ls(n, r == null ? void 0 : r[1], a[1], "important")) : ls(n, r, a));
    return a;
  }
  function yi(n, t, r = !1) {
    if (n.multiple) {
      if (t == null) return;
      if (!ci(t)) return void console.warn("https://svelte.dev/e/select_multiple_invalid_value");
      for (var a of n.options) a.selected = t.includes(ic(a));
    } else {
      for (a of n.options)
        if (wd(ic(a), t)) return void (a.selected = !0);
      r && t === void 0 || (n.selectedIndex = -1);
    }
  }
  function ss(n) {
    var t = new MutationObserver(() => {
      yi(n, n.__value);
    });
    t.observe(n, { childList: !0, subtree: !0, attributes: !0, attributeFilter: ["value"] }), Zl(() => {
      t.disconnect();
    });
  }
  function ic(n) {
    return "__value" in n ? n.__value : n.value;
  }
  const xi = Symbol("class"), wi = Symbol("style"), lc = Symbol("is custom element"), sc = Symbol("is html");
  function qr(n) {
    if (dt) {
      var t, r = !1, a = () => {
        if (!r) {
          if (r = !0, n.hasAttribute("value")) {
            var l = n.value;
            Pe(n, "value", null), n.value = l;
          }
          if (n.hasAttribute("checked")) {
            var c = n.checked;
            Pe(n, "checked", null), n.checked = c;
          }
        }
      };
      n.__on_r = a, t = a, qa.length === 0 && fd(go), qa.push(t), Mo();
    }
  }
  function va(n, t) {
    var r = sl(n);
    r.value !== (r.value = t != null ? t : void 0) && (n.value !== t || t === 0 && n.nodeName === "PROGRESS") && (n.value = t != null ? t : "");
  }
  function Pi(n, t) {
    var r = sl(n);
    r.checked !== (r.checked = t != null ? t : void 0) && (n.checked = t);
  }
  function Ld(n, t) {
    t ? n.hasAttribute("selected") || n.setAttribute("selected", "") : n.removeAttribute("selected");
  }
  function Pe(n, t, r, a) {
    var l = sl(n);
    dt && (l[t] = n.getAttribute(t), t === "src" || t === "srcset" || t === "href" && n.nodeName === "LINK") || l[t] !== (l[t] = r) && (t === "loading" && (n[gd] = r), r == null ? n.removeAttribute(t) : typeof r != "string" && cc(n).includes(t) ? n[t] = r : n.setAttribute(t, r));
  }
  function Ed(n, t, r = [], a = [], l, c = !1, u = !1) {
    vo(r, a, (s) => {
      var i = void 0, o = {}, d = n.nodeName === "SELECT", h = !1;
      if (Ar(() => {
        var p = t(...s.map(e)), _ = (function(y, x, M, A, V = !1) {
          if (dt && V && y.tagName === "INPUT") {
            var C = y;
            (C.type === "checkbox" ? "defaultChecked" : "defaultValue") in M || qr(C);
          }
          var R = sl(y), U = R[lc], F = !R[sc];
          let se = dt && U;
          se && zn(!1);
          var X = x || {}, K = y.tagName === "OPTION";
          for (var J in x) J in M || (M[J] = null);
          M.class ? M.class = mi(M.class) : M[xi] && (M.class = null), M[wi] && (M.style != null || (M.style = null));
          var N = cc(y);
          for (const W in M) {
            let ue = M[W];
            if (K && W === "value" && ue == null) y.value = y.__value = "", X[W] = ue;
            else if (W !== "class") if (W !== "style") {
              var Z = X[W];
              if (ue !== Z || ue === void 0 && y.hasAttribute(W)) {
                X[W] = ue;
                var $ = W[0] + W[1];
                if ($ !== "$$") if ($ === "on") {
                  const Q = {}, b = "$$" + W;
                  let B = W.slice(2);
                  var S = Dd(B);
                  if (Id(B) && (B = B.slice(0, -7), Q.capture = !0), !S && Z) {
                    if (ue != null) continue;
                    y.removeEventListener(B, X[b], Q), X[b] = null;
                  }
                  if (ue != null) if (S) y[`__${B}`] = ue, Pn([B]);
                  else {
                    let G = function(z) {
                      X[W].call(this, z);
                    };
                    X[b] = Zo(B, y, G, Q);
                  }
                  else S && (y[`__${B}`] = void 0);
                } else if (W === "style") Pe(y, W, ue);
                else if (W === "autofocus") Pd(y, !!ue);
                else if (U || W !== "__value" && (W !== "value" || ue == null)) if (W === "selected" && K) Ld(y, ue);
                else {
                  var T = W;
                  F || (T = Ad(T));
                  var q = T === "defaultValue" || T === "defaultChecked";
                  if (ue != null || U || q) q || N.includes(T) && (U || typeof ue != "string") ? (y[T] = ue, T in R && (R[T] = kn)) : typeof ue != "function" && Pe(y, T, ue);
                  else if (R[W] = null, T === "value" || T === "checked") {
                    let Q = y;
                    const b = x === void 0;
                    if (T === "value") {
                      let B = Q.defaultValue;
                      Q.removeAttribute(T), Q.defaultValue = B, Q.value = Q.__value = b ? B : null;
                    } else {
                      let B = Q.defaultChecked;
                      Q.removeAttribute(T), Q.defaultChecked = B, Q.checked = !!b && B;
                    }
                  } else y.removeAttribute(W);
                }
                else y.value = y.__value = ue;
              }
            } else Wt(y, ue, x == null ? void 0 : x[wi], M[wi]), X[W] = ue, X[wi] = M[wi];
            else Ot(y, y.namespaceURI === "http://www.w3.org/1999/xhtml", ue, A, x == null ? void 0 : x[xi], M[xi]), X[W] = ue, X[xi] = M[xi];
          }
          return se && zn(!0), X;
        })(n, i, p, l, c, u);
        h && d && "value" in p && yi(n, p.value);
        for (let y of Object.getOwnPropertySymbols(o)) p[y] || wn(o[y]);
        for (let y of Object.getOwnPropertySymbols(p)) {
          var I = p[y];
          y.description !== "@attach" || i && I === i[y] || (o[y] && wn(o[y]), o[y] = xn(() => Fd(n, () => I))), _[y] = I;
        }
        i = _;
      }), d) {
        var f = n;
        rl(() => {
          yi(f, i.value, !0), ss(f);
        });
      }
      h = !0;
    });
  }
  function sl(n) {
    var t;
    return (t = n.__attributes) != null ? t : n.__attributes = { [lc]: n.nodeName.includes("-"), [sc]: n.namespaceURI === "http://www.w3.org/1999/xhtml" };
  }
  var oc = /* @__PURE__ */ new Map();
  function cc(n) {
    var t, r = n.getAttribute("is") || n.nodeName, a = oc.get(r);
    if (a) return a;
    oc.set(r, a = []);
    for (var l = n, c = Element.prototype; c !== l; ) {
      for (var u in t = Xs(l)) t[u].set && a.push(u);
      l = Zi(l);
    }
    return a;
  }
  function jd(n, t, r = t) {
    var a = /* @__PURE__ */ new WeakSet();
    (function(l, c, u, s = u) {
      l.addEventListener(c, () => nl(u));
      const i = l.__on_r;
      l.__on_r = i ? () => {
        i(), s(!0);
      } : () => s(!0), Mo();
    })(n, "input", async (l) => {
      var c = l ? n.defaultValue : n.value;
      if (c = os(n) ? cs(c) : c, r(c), sn !== null && a.add(sn), await Yl(), c !== (c = t())) {
        var u = n.selectionStart, s = n.selectionEnd;
        n.value = c != null ? c : "", s !== null && (n.selectionStart = u, n.selectionEnd = Math.min(s, n.value.length));
      }
    }), (dt && n.defaultValue !== n.value || Xt(t) == null && n.value) && (r(os(n) ? cs(n.value) : n.value), sn !== null && a.add(sn)), vi(() => {
      var l = t();
      if (n === document.activeElement) {
        var c = pi != null ? pi : sn;
        if (a.has(c)) return;
      }
      os(n) && l === cs(n.value) || (n.type !== "date" || l || n.value) && l !== n.value && (n.value = l != null ? l : "");
    });
  }
  function os(n) {
    var t = n.type;
    return t === "number" || t === "range";
  }
  function cs(n) {
    return n === "" ? null : +n;
  }
  function uc(n, t) {
    return n === t || (n == null ? void 0 : n[Dr]) === t;
  }
  function ol(n = {}, t, r, a) {
    return rl(() => {
      var l, c;
      return vi(() => {
        l = c, c = [], Xt(() => {
          n !== r(...c) && (t(n, ...c), l && uc(r(...l), n) && t(null, ...l));
        });
      }), () => {
        ga(() => {
          c && uc(r(...c), n) && t(null, ...c);
        });
      };
    }), n;
  }
  function dc(n, t) {
    if (n.l.s) for (const r of n.l.s) e(r);
    t();
  }
  function gc(n, t, r) {
    if (n == null) return t(void 0), jr;
    const a = Xt(() => n.subscribe(t, r));
    return a.unsubscribe ? () => a.unsubscribe() : a;
  }
  const Ea = [];
  function Jr(n, t = jr) {
    let r = null;
    const a = /* @__PURE__ */ new Set();
    function l(u) {
      if (Xi(n, u) && (n = u, r)) {
        const s = !Ea.length;
        for (const i of a) i[1](), Ea.push(i, n);
        if (s) {
          for (let i = 0; i < Ea.length; i += 2) Ea[i][0](Ea[i + 1]);
          Ea.length = 0;
        }
      }
    }
    function c(u) {
      l(u(n));
    }
    return { set: l, update: c, subscribe: function(u, s = jr) {
      const i = [u, s];
      return a.add(i), a.size === 1 && (r = t(l, c) || jr), u(n), () => {
        a.delete(i), a.size === 0 && r && (r(), r = null);
      };
    } };
  }
  let hc, cl = !1, us = Symbol();
  function Me(n, t, r) {
    var a;
    const l = (a = r[t]) != null ? a : r[t] = { store: null, source: Ul(void 0), unsubscribe: jr };
    if (l.store !== n && !(us in r)) if (l.unsubscribe(), l.store = n != null ? n : null, n == null) l.source.v = void 0, l.unsubscribe = jr;
    else {
      var c = !0;
      l.unsubscribe = gc(n, (u) => {
        c ? l.source.v = u : te(l.source, u);
      }), c = !1;
    }
    return n && us in r ? (function(u) {
      let s;
      return gc(u, (i) => s = i)(), s;
    })(n) : e(l.source);
  }
  function wt() {
    const n = {};
    return [n, function() {
      Zl(() => {
        for (var t in n)
          n[t].unsubscribe();
        oa(n, us, { enumerable: !1, value: !0 });
      });
    }];
  }
  function m(n, t, r, a) {
    var l, c, u, s, i = !za || !!(2 & r), o = !!(8 & r), d = !!(16 & r), h = a, f = !0, p = () => (f && (f = !1, h = d ? Xt(a) : a), h);
    if (o) {
      var _ = Dr in n || ao in n;
      u = (c = (l = ca(n, t)) == null ? void 0 : l.set) != null ? c : _ && t in n ? (C) => n[t] = C : void 0;
    }
    var I, y = !1;
    if (o ? [s, y] = (function(C) {
      var R = cl;
      try {
        return cl = !1, [C(), cl];
      } finally {
        cl = R;
      }
    })(() => n[t]) : s = n[t], s === void 0 && a !== void 0 && (s = p(), u && (i && (function() {
      throw new Error("https://svelte.dev/e/props_invalid_value");
    })(), u(s))), I = i ? () => {
      var C = n[t];
      return C === void 0 ? p() : (f = !0, C);
    } : () => {
      var C = n[t];
      return C !== void 0 && (h = void 0), C === void 0 ? h : C;
    }, i && !(4 & r)) return I;
    if (u) {
      var x = n.$$legacy;
      return function(C, R) {
        return arguments.length > 0 ? (i && R && !x && !y || u(R ? I() : C), C) : I();
      };
    }
    var M = !1, A = (1 & r ? bi : Nl)(() => (M = !1, I()));
    o && e(A);
    var V = $t;
    return function(C, R) {
      if (arguments.length > 0) {
        const U = R ? e(A) : i && o ? rt(C) : C;
        return te(A, U), M = !0, h !== void 0 && (h = U), C;
      }
      return fa && M || (V.f & Ma) !== 0 ? A.v : e(A);
    };
  }
  class Rd {
    constructor(t) {
      var r, a;
      It(this, Lr), It(this, nr);
      var l = /* @__PURE__ */ new Map(), c = (s, i) => {
        var o = Ul(i, !1, !1);
        return l.set(s, o), o;
      };
      const u = new Proxy({ ...t.props || {}, $$events: {} }, { get(s, i) {
        var o;
        return e((o = l.get(i)) != null ? o : c(i, Reflect.get(s, i)));
      }, has(s, i) {
        var o;
        return i === ao || (e((o = l.get(i)) != null ? o : c(i, Reflect.get(s, i))), Reflect.has(s, i));
      }, set(s, i, o) {
        var d;
        return te((d = l.get(i)) != null ? d : c(i, o), o), Reflect.set(s, i, o);
      } });
      xt(this, nr, (t.hydrate ? Td : Ko)(t.component, { target: t.target, anchor: t.anchor, props: u, context: t.context, intro: (r = t.intro) != null && r, recover: t.recover })), (a = t == null ? void 0 : t.props) != null && a.$$host && t.sync !== !1 || k(), xt(this, Lr, u.$$events);
      for (const s of Object.keys(me(this, nr))) s !== "$set" && s !== "$destroy" && s !== "$on" && oa(this, s, { get() {
        return me(this, nr)[s];
      }, set(i) {
        me(this, nr)[s] = i;
      }, enumerable: !0 });
      me(this, nr).$set = (s) => {
        Object.assign(u, s);
      }, me(this, nr).$destroy = () => {
        (function(s, i) {
          const o = ts.get(s);
          o ? (ts.delete(s), o(i)) : Promise.resolve();
        })(me(this, nr));
      };
    }
    $set(t) {
      me(this, nr).$set(t);
    }
    $on(t, r) {
      me(this, Lr)[t] = me(this, Lr)[t] || [];
      const a = (...l) => r.call(this, ...l);
      return me(this, Lr)[t].push(a), () => {
        me(this, Lr)[t] = me(this, Lr)[t].filter((l) => l !== a);
      };
    }
    $destroy() {
      me(this, nr).$destroy();
    }
  }
  function ul(n, t, r, a) {
    var l;
    const c = (l = r[n]) == null ? void 0 : l.type;
    if (t = c === "Boolean" && typeof t != "boolean" ? t != null : t, !a || !r[n]) return t;
    if (a === "toAttribute") switch (c) {
      case "Object":
      case "Array":
        return t == null ? null : JSON.stringify(t);
      case "Boolean":
        return t ? "" : null;
      case "Number":
        return t == null ? null : t;
      default:
        return t;
    }
    else switch (c) {
      case "Object":
      case "Array":
        return t && JSON.parse(t);
      case "Boolean":
      default:
        return t;
      case "Number":
        return t != null ? +t : t;
    }
  }
  function We(n, t, r, a, l, c) {
    let u = class extends hc {
      constructor() {
        super(n, r, l), this.$$p_d = t;
      }
      static get observedAttributes() {
        return Hi(t).map((s) => (t[s].attribute || s).toLowerCase());
      }
    };
    return Hi(t).forEach((s) => {
      oa(u.prototype, s, { get() {
        return this.$$c && s in this.$$c ? this.$$c[s] : this.$$d[s];
      }, set(i) {
        var o;
        i = ul(s, i, t), this.$$d[s] = i;
        var d = this.$$c;
        d && ((o = ca(d, s)) != null && o.get ? d[s] = i : d.$set({ [s]: i }));
      } });
    }), a.forEach((s) => {
      oa(u.prototype, s, { get() {
        var i;
        return (i = this.$$c) == null ? void 0 : i[s];
      } });
    }), c && (u = c(u)), n.element = u, u;
  }
  Lr = /* @__PURE__ */ new WeakMap(), nr = /* @__PURE__ */ new WeakMap(), typeof HTMLElement == "function" && (hc = class extends HTMLElement {
    constructor(n, t, r) {
      super(), fn(this, "$$ctor"), fn(this, "$$s"), fn(this, "$$c"), fn(this, "$$cn", !1), fn(this, "$$d", {}), fn(this, "$$r", !1), fn(this, "$$p_d", {}), fn(this, "$$l", {}), fn(this, "$$l_u", /* @__PURE__ */ new Map()), fn(this, "$$me"), this.$$ctor = n, this.$$s = t, r && this.attachShadow({ mode: "open" });
    }
    addEventListener(n, t, r) {
      if (this.$$l[n] = this.$$l[n] || [], this.$$l[n].push(t), this.$$c) {
        const a = this.$$c.$on(n, t);
        this.$$l_u.set(t, a);
      }
      super.addEventListener(n, t, r);
    }
    removeEventListener(n, t, r) {
      if (super.removeEventListener(n, t, r), this.$$c) {
        const a = this.$$l_u.get(t);
        a && (a(), this.$$l_u.delete(t));
      }
    }
    async connectedCallback() {
      if (this.$$cn = !0, !this.$$c) {
        let t = function(l) {
          return (c) => {
            const u = document.createElement("slot");
            l !== "default" && (u.name = l), v(c, u);
          };
        };
        if (await Promise.resolve(), !this.$$cn || this.$$c) return;
        const r = {}, a = (function(l) {
          const c = {};
          return l.childNodes.forEach((u) => {
            c[u.slot || "default"] = !0;
          }), c;
        })(this);
        for (const l of this.$$s) l in a && (l !== "default" || this.$$d.children ? r[l] = t(l) : (this.$$d.children = t(l), r.default = !0));
        for (const l of this.attributes) {
          const c = this.$$g_p(l.name);
          c in this.$$d || (this.$$d[c] = ul(c, l.value, this.$$p_d, "toProp"));
        }
        for (const l in this.$$p_d) l in this.$$d || this[l] === void 0 || (this.$$d[l] = this[l], delete this[l]);
        this.$$c = (n = { component: this.$$ctor, target: this.shadowRoot || this, props: { ...this.$$d, $$slots: r, $$host: this } }, new Rd(n)), this.$$me = (function(l) {
          pa.ensure();
          const c = sr(524352, l, !0);
          return () => {
            wn(c);
          };
        })(() => {
          vi(() => {
            var l;
            this.$$r = !0;
            for (const c of Hi(this.$$c)) {
              if (!((l = this.$$p_d[c]) != null && l.reflect)) continue;
              this.$$d[c] = this.$$c[c];
              const u = ul(c, this.$$d[c], this.$$p_d, "toAttribute");
              u == null ? this.removeAttribute(this.$$p_d[c].attribute || c) : this.setAttribute(this.$$p_d[c].attribute || c, u);
            }
            this.$$r = !1;
          });
        });
        for (const l in this.$$l) for (const c of this.$$l[l]) {
          const u = this.$$c.$on(l, c);
          this.$$l_u.set(c, u);
        }
        this.$$l = {};
      }
      var n;
    }
    attributeChangedCallback(n, t, r) {
      var a;
      this.$$r || (n = this.$$g_p(n), this.$$d[n] = ul(n, r, this.$$p_d, "toProp"), (a = this.$$c) == null || a.$set({ [n]: this.$$d[n] }));
    }
    disconnectedCallback() {
      this.$$cn = !1, Promise.resolve().then(() => {
        !this.$$cn && this.$$c && (this.$$c.$destroy(), this.$$me(), this.$$c = void 0);
      });
    }
    $$g_p(n) {
      return Hi(this.$$p_d).find((t) => this.$$p_d[t].attribute === n || !this.$$p_d[t].attribute && t.toLowerCase() === n) || n;
    }
  });
  var Qd = D("<span> </span>"), Nd = D("<div></div>");
  function Vr(n, t) {
    Je(t, !0);
    const r = m(t, "product", 7), a = m(t, "class", 7, ""), l = g(() => r().options.map((s) => s.name));
    var c = { get product() {
      return r();
    }, set product(s) {
      r(s), k();
    }, get class() {
      return a();
    }, set class(s = "") {
      a(s), k();
    } }, u = Nd();
    return Jt(u, 21, () => e(l), Zr, (s, i) => {
      var o = Qd(), d = P(o, !0);
      w(o), be(() => mt(d, e(i))), v(s, o);
    }), w(u), be(() => Ot(u, 1, mi(["kaching-bundles__bar-variant-names", a()]))), v(n, u), Ye(c);
  }
  We(Vr, { product: {}, class: {} }, [], [], !0);
  const dl = Math.min, _a = Math.max, gl = Math.round, hl = Math.floor, _r = (n) => ({ x: n, y: n }), Wd = { left: "right", right: "left", bottom: "top", top: "bottom" }, Ud = { start: "end", end: "start" };
  function pc(n, t, r) {
    return _a(n, dl(t, r));
  }
  function pl(n, t) {
    return typeof n == "function" ? n(t) : n;
  }
  function ka(n) {
    return n.split("-")[0];
  }
  function fl(n) {
    return n.split("-")[1];
  }
  function fc(n) {
    return n === "x" ? "y" : "x";
  }
  function bc(n) {
    return n === "y" ? "height" : "width";
  }
  const Hd = /* @__PURE__ */ new Set(["top", "bottom"]);
  function Yr(n) {
    return Hd.has(ka(n)) ? "y" : "x";
  }
  function vc(n) {
    return fc(Yr(n));
  }
  function ds(n) {
    return n.replace(/start|end/g, (t) => Ud[t]);
  }
  const _c = ["left", "right"], kc = ["right", "left"], Zd = ["top", "bottom"], Jd = ["bottom", "top"];
  function Yd(n, t, r, a) {
    const l = fl(n);
    let c = (function(u, s, i) {
      switch (u) {
        case "top":
        case "bottom":
          return i ? s ? kc : _c : s ? _c : kc;
        case "left":
        case "right":
          return s ? Zd : Jd;
        default:
          return [];
      }
    })(ka(n), r === "start", a);
    return l && (c = c.map((u) => u + "-" + l), t && (c = c.concat(c.map(ds)))), c;
  }
  function bl(n) {
    return n.replace(/left|right|bottom|top/g, (t) => Wd[t]);
  }
  function vl(n) {
    const { x: t, y: r, width: a, height: l } = n;
    return { width: a, height: l, top: r, left: t, right: t + a, bottom: r + l, x: t, y: r };
  }
  function mc(n, t, r) {
    let { reference: a, floating: l } = n;
    const c = Yr(t), u = vc(t), s = bc(u), i = ka(t), o = c === "y", d = a.x + a.width / 2 - l.width / 2, h = a.y + a.height / 2 - l.height / 2, f = a[s] / 2 - l[s] / 2;
    let p;
    switch (i) {
      case "top":
        p = { x: d, y: a.y - l.height };
        break;
      case "bottom":
        p = { x: d, y: a.y + a.height };
        break;
      case "right":
        p = { x: a.x + a.width, y: h };
        break;
      case "left":
        p = { x: a.x - l.width, y: h };
        break;
      default:
        p = { x: a.x, y: a.y };
    }
    switch (fl(t)) {
      case "start":
        p[u] -= f * (r && o ? -1 : 1);
        break;
      case "end":
        p[u] += f * (r && o ? -1 : 1);
    }
    return p;
  }
  async function yc(n, t) {
    var r;
    t === void 0 && (t = {});
    const { x: a, y: l, platform: c, rects: u, elements: s, strategy: i } = n, { boundary: o = "clippingAncestors", rootBoundary: d = "viewport", elementContext: h = "floating", altBoundary: f = !1, padding: p = 0 } = pl(t, n), _ = (function(C) {
      return typeof C != "number" ? (function(R) {
        return { top: 0, right: 0, bottom: 0, left: 0, ...R };
      })(C) : { top: C, right: C, bottom: C, left: C };
    })(p), I = s[f ? h === "floating" ? "reference" : "floating" : h], y = vl(await c.getClippingRect({ element: (r = await (c.isElement == null ? void 0 : c.isElement(I))) == null || r ? I : I.contextElement || await (c.getDocumentElement == null ? void 0 : c.getDocumentElement(s.floating)), boundary: o, rootBoundary: d, strategy: i })), x = h === "floating" ? { x: a, y: l, width: u.floating.width, height: u.floating.height } : u.reference, M = await (c.getOffsetParent == null ? void 0 : c.getOffsetParent(s.floating)), A = await (c.isElement == null ? void 0 : c.isElement(M)) && await (c.getScale == null ? void 0 : c.getScale(M)) || { x: 1, y: 1 }, V = vl(c.convertOffsetParentRelativeRectToViewportRelativeRect ? await c.convertOffsetParentRelativeRectToViewportRelativeRect({ elements: s, rect: x, offsetParent: M, strategy: i }) : x);
    return { top: (y.top - V.top + _.top) / A.y, bottom: (V.bottom - y.bottom + _.bottom) / A.y, left: (y.left - V.left + _.left) / A.x, right: (V.right - y.right + _.right) / A.x };
  }
  const Kd = /* @__PURE__ */ new Set(["left", "top"]);
  function _l() {
    return typeof window != "undefined";
  }
  function ja(n) {
    return xc(n) ? (n.nodeName || "").toLowerCase() : "#document";
  }
  function Nn(n) {
    var t;
    return (n == null || (t = n.ownerDocument) == null ? void 0 : t.defaultView) || window;
  }
  function kr(n) {
    var t;
    return (t = (xc(n) ? n.ownerDocument : n.document) || window.document) == null ? void 0 : t.documentElement;
  }
  function xc(n) {
    return !!_l() && (n instanceof Node || n instanceof Nn(n).Node);
  }
  function ur(n) {
    return !!_l() && (n instanceof Element || n instanceof Nn(n).Element);
  }
  function mr(n) {
    return !!_l() && (n instanceof HTMLElement || n instanceof Nn(n).HTMLElement);
  }
  function wc(n) {
    return !(!_l() || typeof ShadowRoot == "undefined") && (n instanceof ShadowRoot || n instanceof Nn(n).ShadowRoot);
  }
  const Xd = /* @__PURE__ */ new Set(["inline", "contents"]);
  function Si(n) {
    const { overflow: t, overflowX: r, overflowY: a, display: l } = dr(n);
    return /auto|scroll|overlay|hidden|clip/.test(t + a + r) && !Xd.has(l);
  }
  const eg = /* @__PURE__ */ new Set(["table", "td", "th"]);
  function tg(n) {
    return eg.has(ja(n));
  }
  const ng = [":popover-open", ":modal"];
  function kl(n) {
    return ng.some((t) => {
      try {
        return n.matches(t);
      } catch {
        return !1;
      }
    });
  }
  const rg = ["transform", "translate", "scale", "rotate", "perspective"], ag = ["transform", "translate", "scale", "rotate", "perspective", "filter"], ig = ["paint", "layout", "strict", "content"];
  function gs(n) {
    const t = hs(), r = ur(n) ? dr(n) : n;
    return rg.some((a) => !!r[a] && r[a] !== "none") || !!r.containerType && r.containerType !== "normal" || !t && !!r.backdropFilter && r.backdropFilter !== "none" || !t && !!r.filter && r.filter !== "none" || ag.some((a) => (r.willChange || "").includes(a)) || ig.some((a) => (r.contain || "").includes(a));
  }
  function hs() {
    return !(typeof CSS == "undefined" || !CSS.supports) && CSS.supports("-webkit-backdrop-filter", "none");
  }
  const lg = /* @__PURE__ */ new Set(["html", "body", "#document"]);
  function Ra(n) {
    return lg.has(ja(n));
  }
  function dr(n) {
    return Nn(n).getComputedStyle(n);
  }
  function ml(n) {
    return ur(n) ? { scrollLeft: n.scrollLeft, scrollTop: n.scrollTop } : { scrollLeft: n.scrollX, scrollTop: n.scrollY };
  }
  function Kr(n) {
    if (ja(n) === "html") return n;
    const t = n.assignedSlot || n.parentNode || wc(n) && n.host || kr(n);
    return wc(t) ? t.host : t;
  }
  function Pc(n) {
    const t = Kr(n);
    return Ra(t) ? n.ownerDocument ? n.ownerDocument.body : n.body : mr(t) && Si(t) ? t : Pc(t);
  }
  function Ci(n, t, r) {
    var a;
    t === void 0 && (t = []), r === void 0 && (r = !0);
    const l = Pc(n), c = l === ((a = n.ownerDocument) == null ? void 0 : a.body), u = Nn(l);
    if (c) {
      const s = ps(u);
      return t.concat(u, u.visualViewport || [], Si(l) ? l : [], s && r ? Ci(s) : []);
    }
    return t.concat(l, Ci(l, [], r));
  }
  function ps(n) {
    return n.parent && Object.getPrototypeOf(n.parent) ? n.frameElement : null;
  }
  function Sc(n) {
    const t = dr(n);
    let r = parseFloat(t.width) || 0, a = parseFloat(t.height) || 0;
    const l = mr(n), c = l ? n.offsetWidth : r, u = l ? n.offsetHeight : a, s = gl(r) !== c || gl(a) !== u;
    return s && (r = c, a = u), { width: r, height: a, $: s };
  }
  function fs(n) {
    return ur(n) ? n : n.contextElement;
  }
  function Qa(n) {
    const t = fs(n);
    if (!mr(t)) return _r(1);
    const r = t.getBoundingClientRect(), { width: a, height: l, $: c } = Sc(t);
    let u = (c ? gl(r.width) : r.width) / a, s = (c ? gl(r.height) : r.height) / l;
    return u && Number.isFinite(u) || (u = 1), s && Number.isFinite(s) || (s = 1), { x: u, y: s };
  }
  const sg = _r(0);
  function Cc(n) {
    const t = Nn(n);
    return hs() && t.visualViewport ? { x: t.visualViewport.offsetLeft, y: t.visualViewport.offsetTop } : sg;
  }
  function ma(n, t, r, a) {
    t === void 0 && (t = !1), r === void 0 && (r = !1);
    const l = n.getBoundingClientRect(), c = fs(n);
    let u = _r(1);
    t && (a ? ur(a) && (u = Qa(a)) : u = Qa(n));
    const s = (function(f, p, _) {
      return p === void 0 && (p = !1), !(!_ || p && _ !== Nn(f)) && p;
    })(c, r, a) ? Cc(c) : _r(0);
    let i = (l.left + s.x) / u.x, o = (l.top + s.y) / u.y, d = l.width / u.x, h = l.height / u.y;
    if (c) {
      const f = Nn(c), p = a && ur(a) ? Nn(a) : a;
      let _ = f, I = ps(_);
      for (; I && a && p !== _; ) {
        const y = Qa(I), x = I.getBoundingClientRect(), M = dr(I), A = x.left + (I.clientLeft + parseFloat(M.paddingLeft)) * y.x, V = x.top + (I.clientTop + parseFloat(M.paddingTop)) * y.y;
        i *= y.x, o *= y.y, d *= y.x, h *= y.y, i += A, o += V, _ = Nn(I), I = ps(_);
      }
    }
    return vl({ width: d, height: h, x: i, y: o });
  }
  function yl(n, t) {
    const r = ml(n).scrollLeft;
    return t ? t.left + r : ma(kr(n)).left + r;
  }
  function Bc(n, t) {
    const r = n.getBoundingClientRect();
    return { x: r.left + t.scrollLeft - yl(n, r), y: r.top + t.scrollTop };
  }
  const og = /* @__PURE__ */ new Set(["absolute", "fixed"]);
  function Ic(n, t, r) {
    let a;
    if (t === "viewport") a = (function(l, c) {
      const u = Nn(l), s = kr(l), i = u.visualViewport;
      let o = s.clientWidth, d = s.clientHeight, h = 0, f = 0;
      if (i) {
        o = i.width, d = i.height;
        const _ = hs();
        (!_ || _ && c === "fixed") && (h = i.offsetLeft, f = i.offsetTop);
      }
      const p = yl(s);
      if (p <= 0) {
        const _ = s.ownerDocument, I = _.body, y = getComputedStyle(I), x = _.compatMode === "CSS1Compat" && parseFloat(y.marginLeft) + parseFloat(y.marginRight) || 0, M = Math.abs(s.clientWidth - I.clientWidth - x);
        M <= 25 && (o -= M);
      } else p <= 25 && (o += p);
      return { width: o, height: d, x: h, y: f };
    })(n, r);
    else if (t === "document") a = (function(l) {
      const c = kr(l), u = ml(l), s = l.ownerDocument.body, i = _a(c.scrollWidth, c.clientWidth, s.scrollWidth, s.clientWidth), o = _a(c.scrollHeight, c.clientHeight, s.scrollHeight, s.clientHeight);
      let d = -u.scrollLeft + yl(l);
      const h = -u.scrollTop;
      return dr(s).direction === "rtl" && (d += _a(c.clientWidth, s.clientWidth) - i), { width: i, height: o, x: d, y: h };
    })(kr(n));
    else if (ur(t)) a = (function(l, c) {
      const u = ma(l, !0, c === "fixed"), s = u.top + l.clientTop, i = u.left + l.clientLeft, o = mr(l) ? Qa(l) : _r(1);
      return { width: l.clientWidth * o.x, height: l.clientHeight * o.y, x: i * o.x, y: s * o.y };
    })(t, r);
    else {
      const l = Cc(n);
      a = { x: t.x - l.x, y: t.y - l.y, width: t.width, height: t.height };
    }
    return vl(a);
  }
  function Mc(n, t) {
    const r = Kr(n);
    return !(r === t || !ur(r) || Ra(r)) && (dr(r).position === "fixed" || Mc(r, t));
  }
  function cg(n, t, r) {
    const a = mr(t), l = kr(t), c = r === "fixed", u = ma(n, !0, c, t);
    let s = { scrollLeft: 0, scrollTop: 0 };
    const i = _r(0);
    function o() {
      i.x = yl(l);
    }
    if (a || !a && !c) if ((ja(t) !== "body" || Si(l)) && (s = ml(t)), a) {
      const h = ma(t, !0, c, t);
      i.x = h.x + t.clientLeft, i.y = h.y + t.clientTop;
    } else l && o();
    c && !a && l && o();
    const d = !l || a || c ? _r(0) : Bc(l, s);
    return { x: u.left + s.scrollLeft - i.x - d.x, y: u.top + s.scrollTop - i.y - d.y, width: u.width, height: u.height };
  }
  function bs(n) {
    return dr(n).position === "static";
  }
  function Dc(n, t) {
    if (!mr(n) || dr(n).position === "fixed") return null;
    if (t) return t(n);
    let r = n.offsetParent;
    return kr(n) === r && (r = r.ownerDocument.body), r;
  }
  function zc(n, t) {
    const r = Nn(n);
    if (kl(n)) return r;
    if (!mr(n)) {
      let l = Kr(n);
      for (; l && !Ra(l); ) {
        if (ur(l) && !bs(l)) return l;
        l = Kr(l);
      }
      return r;
    }
    let a = Dc(n, t);
    for (; a && tg(a) && bs(a); ) a = Dc(a, t);
    return a && Ra(a) && bs(a) && !gs(a) ? r : a || (function(l) {
      let c = Kr(l);
      for (; mr(c) && !Ra(c); ) {
        if (gs(c)) return c;
        if (kl(c)) return null;
        c = Kr(c);
      }
      return null;
    })(n) || r;
  }
  const ug = { convertOffsetParentRelativeRectToViewportRelativeRect: function(n) {
    let { elements: t, rect: r, offsetParent: a, strategy: l } = n;
    const c = l === "fixed", u = kr(a), s = !!t && kl(t.floating);
    if (a === u || s && c) return r;
    let i = { scrollLeft: 0, scrollTop: 0 }, o = _r(1);
    const d = _r(0), h = mr(a);
    if ((h || !h && !c) && ((ja(a) !== "body" || Si(u)) && (i = ml(a)), mr(a))) {
      const p = ma(a);
      o = Qa(a), d.x = p.x + a.clientLeft, d.y = p.y + a.clientTop;
    }
    const f = !u || h || c ? _r(0) : Bc(u, i);
    return { width: r.width * o.x, height: r.height * o.y, x: r.x * o.x - i.scrollLeft * o.x + d.x + f.x, y: r.y * o.y - i.scrollTop * o.y + d.y + f.y };
  }, getDocumentElement: kr, getClippingRect: function(n) {
    let { element: t, boundary: r, rootBoundary: a, strategy: l } = n;
    const c = [...r === "clippingAncestors" ? kl(t) ? [] : (function(i, o) {
      const d = o.get(i);
      if (d) return d;
      let h = Ci(i, [], !1).filter((I) => ur(I) && ja(I) !== "body"), f = null;
      const p = dr(i).position === "fixed";
      let _ = p ? Kr(i) : i;
      for (; ur(_) && !Ra(_); ) {
        const I = dr(_), y = gs(_);
        y || I.position !== "fixed" || (f = null), (p ? !y && !f : !y && I.position === "static" && f && og.has(f.position) || Si(_) && !y && Mc(i, _)) ? h = h.filter((x) => x !== _) : f = I, _ = Kr(_);
      }
      return o.set(i, h), h;
    })(t, this._c) : [].concat(r), a], u = c[0], s = c.reduce((i, o) => {
      const d = Ic(t, o, l);
      return i.top = _a(d.top, i.top), i.right = dl(d.right, i.right), i.bottom = dl(d.bottom, i.bottom), i.left = _a(d.left, i.left), i;
    }, Ic(t, u, l));
    return { width: s.right - s.left, height: s.bottom - s.top, x: s.left, y: s.top };
  }, getOffsetParent: zc, getElementRects: async function(n) {
    const t = this.getOffsetParent || zc, r = this.getDimensions, a = await r(n.floating);
    return { reference: cg(n.reference, await t(n.floating), n.strategy), floating: { x: 0, y: 0, width: a.width, height: a.height } };
  }, getClientRects: function(n) {
    return Array.from(n.getClientRects());
  }, getDimensions: function(n) {
    const { width: t, height: r } = Sc(n);
    return { width: t, height: r };
  }, getScale: Qa, isElement: ur, isRTL: function(n) {
    return dr(n).direction === "rtl";
  } };
  function Ac(n, t) {
    return n.x === t.x && n.y === t.y && n.width === t.width && n.height === t.height;
  }
  function dg(n, t, r, a) {
    a === void 0 && (a = {});
    const { ancestorScroll: l = !0, ancestorResize: c = !0, elementResize: u = typeof ResizeObserver == "function", layoutShift: s = typeof IntersectionObserver == "function", animationFrame: i = !1 } = a, o = fs(n), d = l || c ? [...o ? Ci(o) : [], ...Ci(t)] : [];
    d.forEach((y) => {
      l && y.addEventListener("scroll", r, { passive: !0 }), c && y.addEventListener("resize", r);
    });
    const h = o && s ? (function(y, x) {
      let M, A = null;
      const V = kr(y);
      function C() {
        var R;
        clearTimeout(M), (R = A) == null || R.disconnect(), A = null;
      }
      return (function R(U, F) {
        U === void 0 && (U = !1), F === void 0 && (F = 1), C();
        const se = y.getBoundingClientRect(), { left: X, top: K, width: J, height: N } = se;
        if (U || x(), !J || !N) return;
        const Z = { rootMargin: -hl(K) + "px " + -hl(V.clientWidth - (X + J)) + "px " + -hl(V.clientHeight - (K + N)) + "px " + -hl(X) + "px", threshold: _a(0, dl(1, F)) || 1 };
        let $ = !0;
        function S(T) {
          const q = T[0].intersectionRatio;
          if (q !== F) {
            if (!$) return R();
            q ? R(!1, q) : M = setTimeout(() => {
              R(!1, 1e-7);
            }, 1e3);
          }
          q !== 1 || Ac(se, y.getBoundingClientRect()) || R(), $ = !1;
        }
        try {
          A = new IntersectionObserver(S, { ...Z, root: V.ownerDocument });
        } catch {
          A = new IntersectionObserver(S, Z);
        }
        A.observe(y);
      })(!0), C;
    })(o, r) : null;
    let f, p = -1, _ = null;
    u && (_ = new ResizeObserver((y) => {
      let [x] = y;
      x && x.target === o && _ && (_.unobserve(t), cancelAnimationFrame(p), p = requestAnimationFrame(() => {
        var M;
        (M = _) == null || M.observe(t);
      })), r();
    }), o && !i && _.observe(o), _.observe(t));
    let I = i ? ma(n) : null;
    return i && (function y() {
      const x = ma(n);
      I && !Ac(I, x) && r(), I = x, f = requestAnimationFrame(y);
    })(), r(), () => {
      var y;
      d.forEach((x) => {
        l && x.removeEventListener("scroll", r), c && x.removeEventListener("resize", r);
      }), h == null || h(), (y = _) == null || y.disconnect(), _ = null, i && cancelAnimationFrame(f);
    };
  }
  const gg = function(n) {
    return { name: "offset", options: n, async fn(t) {
      var r, a;
      const { x: l, y: c, placement: u, middlewareData: s } = t, i = await (async function(o, d) {
        const { placement: h, platform: f, elements: p } = o, _ = await (f.isRTL == null ? void 0 : f.isRTL(p.floating)), I = ka(h), y = fl(h), x = Yr(h) === "y", M = Kd.has(I) ? -1 : 1, A = _ && x ? -1 : 1, V = pl(d, o);
        let { mainAxis: C, crossAxis: R, alignmentAxis: U } = typeof V == "number" ? { mainAxis: V, crossAxis: 0, alignmentAxis: null } : { mainAxis: V.mainAxis || 0, crossAxis: V.crossAxis || 0, alignmentAxis: V.alignmentAxis };
        return y && typeof U == "number" && (R = y === "end" ? -1 * U : U), x ? { x: R * A, y: C * M } : { x: C * M, y: R * A };
      })(t, n);
      return u === ((r = s.offset) == null ? void 0 : r.placement) && (a = s.arrow) != null && a.alignmentOffset ? {} : { x: l + i.x, y: c + i.y, data: { ...i, placement: u } };
    } };
  }, hg = function(n) {
    return n === void 0 && (n = {}), { name: "shift", options: n, async fn(t) {
      const { x: r, y: a, placement: l } = t, { mainAxis: c = !0, crossAxis: u = !1, limiter: s = { fn: (y) => {
        let { x, y: M } = y;
        return { x, y: M };
      } }, ...i } = pl(n, t), o = { x: r, y: a }, d = await yc(t, i), h = Yr(ka(l)), f = fc(h);
      let p = o[f], _ = o[h];
      if (c) {
        const y = f === "y" ? "bottom" : "right";
        p = pc(p + d[f === "y" ? "top" : "left"], p, p - d[y]);
      }
      if (u) {
        const y = h === "y" ? "bottom" : "right";
        _ = pc(_ + d[h === "y" ? "top" : "left"], _, _ - d[y]);
      }
      const I = s.fn({ ...t, [f]: p, [h]: _ });
      return { ...I, data: { x: I.x - r, y: I.y - a, enabled: { [f]: c, [h]: u } } };
    } };
  }, pg = function(n) {
    return n === void 0 && (n = {}), { name: "flip", options: n, async fn(t) {
      var r, a;
      const { placement: l, middlewareData: c, rects: u, initialPlacement: s, platform: i, elements: o } = t, { mainAxis: d = !0, crossAxis: h = !0, fallbackPlacements: f, fallbackStrategy: p = "bestFit", fallbackAxisSideDirection: _ = "none", flipAlignment: I = !0, ...y } = pl(n, t);
      if ((r = c.arrow) != null && r.alignmentOffset) return {};
      const x = ka(l), M = Yr(s), A = ka(s) === s, V = await (i.isRTL == null ? void 0 : i.isRTL(o.floating)), C = f || (A || !I ? [bl(s)] : (function(Z) {
        const $ = bl(Z);
        return [ds(Z), $, ds($)];
      })(s)), R = _ !== "none";
      !f && R && C.push(...Yd(s, I, _, V));
      const U = [s, ...C], F = await yc(t, y), se = [];
      let X = ((a = c.flip) == null ? void 0 : a.overflows) || [];
      if (d && se.push(F[x]), h) {
        const Z = (function($, S, T) {
          T === void 0 && (T = !1);
          const q = fl($), W = vc($), ue = bc(W);
          let Q = W === "x" ? q === (T ? "end" : "start") ? "right" : "left" : q === "start" ? "bottom" : "top";
          return S.reference[ue] > S.floating[ue] && (Q = bl(Q)), [Q, bl(Q)];
        })(l, u, V);
        se.push(F[Z[0]], F[Z[1]]);
      }
      if (X = [...X, { placement: l, overflows: se }], !se.every((Z) => Z <= 0)) {
        var K, J;
        const Z = (((K = c.flip) == null ? void 0 : K.index) || 0) + 1, $ = U[Z];
        if ($ && (!(h === "alignment" && M !== Yr($)) || X.every((T) => Yr(T.placement) !== M || T.overflows[0] > 0)))
          return { data: { index: Z, overflows: X }, reset: { placement: $ } };
        let S = (J = X.filter((T) => T.overflows[0] <= 0).sort((T, q) => T.overflows[1] - q.overflows[1])[0]) == null ? void 0 : J.placement;
        if (!S) switch (p) {
          case "bestFit": {
            var N;
            const T = (N = X.filter((q) => {
              if (R) {
                const W = Yr(q.placement);
                return W === M || W === "y";
              }
              return !0;
            }).map((q) => [q.placement, q.overflows.filter((W) => W > 0).reduce((W, ue) => W + ue, 0)]).sort((q, W) => q[1] - W[1])[0]) == null ? void 0 : N[0];
            T && (S = T);
            break;
          }
          case "initialPlacement":
            S = s;
        }
        if (l !== S) return { reset: { placement: S } };
      }
      return {};
    } };
  }, fg = (n, t, r) => {
    const a = /* @__PURE__ */ new Map(), l = { platform: ug, ...r }, c = { ...l.platform, _c: a };
    return (async (u, s, i) => {
      const { placement: o = "bottom", strategy: d = "absolute", middleware: h = [], platform: f } = i, p = h.filter(Boolean), _ = await (f.isRTL == null ? void 0 : f.isRTL(s));
      let I = await f.getElementRects({ reference: u, floating: s, strategy: d }), { x: y, y: x } = mc(I, o, _), M = o, A = {}, V = 0;
      for (let C = 0; C < p.length; C++) {
        const { name: R, fn: U } = p[C], { x: F, y: se, data: X, reset: K } = await U({ x: y, y: x, initialPlacement: o, placement: M, strategy: d, middlewareData: A, rects: I, platform: f, elements: { reference: u, floating: s } });
        y = F != null ? F : y, x = se != null ? se : x, A = { ...A, [R]: { ...A[R], ...X } }, K && V <= 50 && (V++, typeof K == "object" && (K.placement && (M = K.placement), K.rects && (I = K.rects === !0 ? await f.getElementRects({ reference: u, floating: s, strategy: d }) : K.rects), { x: y, y: x } = mc(I, M, _)), C = -1);
      }
      return { x: y, y: x, placement: M, strategy: d, middlewareData: A };
    })(n, t, { ...l, platform: c });
  };
  function Yn(n) {
    const t = { bold: "bold", light: "300", medium: "500", regular: "normal" };
    for (const r in t) if (n.includes(r)) return t[r];
    return "normal";
  }
  function Kn(n) {
    return n.includes("italic") ? "italic" : "normal";
  }
  function Re(n) {
    return `rgba(${n.red}, ${n.green}, ${n.blue}, ${n.alpha})`;
  }
  const bg = { "SF Mono": '"SF Mono", ui-monospace, Menlo, monospace', Helvetica: '"Helvetica Neue", Helvetica, -apple-system, sans-serif', "New York": '"New York", ui-serif, Georgia, serif', "System UI": "system-ui, -apple-system, BlinkMacSystemFont, sans-serif" };
  function vg(n) {
    var t;
    return (t = bg[n]) != null ? t : `"${n}"`;
  }
  function hn(n) {
    return Object.entries(n).reduce((t, [r, a]) => (a && t.push(`--${r}:${a}`), t), []).join(";");
  }
  function $c(n) {
    var t, r;
    const { colors: a, fonts: l, cornerRadius: c, spacing: u, imageSize: s, imageCornerRadius: i, bundleBarsPerRow: o, dealBars: d } = n, h = a.border || a.primary, f = Math.min(d.length, o ? parseInt(o) : 3).toString();
    return hn({ "block-font-family": l.fontFamily ? vg(l.fontFamily) : null, "block-title-color": Re(a.title), "block-title-font-size": l.blockTitle.size + "px", "block-title-font-weight": Yn(l.blockTitle.style), "block-title-font-style": Kn(l.blockTitle.style), "block-spacing": u == null ? void 0 : u.toString(), "bar-border-radius": (c || 0) + "px", "bar-background-color": Re(a.background), "bar-selected-background-color": Re(a.selectedBackground || a.background), "bar-border-color": Re({ ...h, alpha: 0.3 * h.alpha }), "bar-selected-border-color": Re(h), "block-block-title-color": Re(a.blockTitle || a.title), "bar-title-color": Re(a.title), "bar-title-font-size": l.title.size + "px", "bar-title-font-weight": Yn(l.title.style), "bar-title-font-style": Kn(l.title.style), "bar-subtitle-color": Re(a.subtitle), "bar-subtitle-font-size": l.subtitle.size + "px", "bar-subtitle-font-weight": Yn(l.subtitle.style), "bar-subtitle-font-style": Kn(l.subtitle.style), "bar-price-color": Re(a.price || a.title), "bar-full-price-color": Re(a.fullPrice || a.subtitle), "bar-label-border-top-radius": (c ? c - 1 : 0) + "px", "bar-label-background-color": Re(a.labelBackground), "bar-label-color": Re(a.label), "bar-label-font-size": l.label.size + "px", "bar-label-font-weight": Yn(l.label.style), "bar-label-font-style": Kn(l.label.style), "bar-most-popular-background-color": Re(a.badgeBackground), "bar-most-popular-color": Re(a.badgeText), "bar-variant-select-border-radius": (c || 0) / 2 + "px", "bar-image-size": (s || 48) + "px", "bar-image-border-radius": (i || 0) + "px", "kaching-bundle-products-image-border-radius": (c || 0) / 2 + "px", "kaching-bundles-unit-label-font-size": l.unitLabel ? l.unitLabel.size + "px" : null, "kaching-bundles-unit-label-font-weight": l.unitLabel ? Yn(l.unitLabel.style) : null, "kaching-bundles-unit-label-font-style": l.unitLabel ? Kn(l.unitLabel.style) : null, "bundle-bars-per-row": f, "kaching-collection-breaks-require-selection-background-color": ((t = n.collectionBreaks) == null ? void 0 : t.requireItemSelectionAlert) && Re(n.collectionBreaks.requireItemSelectionAlert.backgroundColor), "kaching-collection-breaks-require-selection-text-color": ((r = n.collectionBreaks) == null ? void 0 : r.requireItemSelectionAlert) && Re(n.collectionBreaks.requireItemSelectionAlert.textColor) });
  }
  const qc = { aliceblue: [240, 248, 255], antiquewhite: [250, 235, 215], aqua: [0, 255, 255], aquamarine: [127, 255, 212], azure: [240, 255, 255], beige: [245, 245, 220], bisque: [255, 228, 196], black: [0, 0, 0], blanchedalmond: [255, 235, 205], blue: [0, 0, 255], blueviolet: [138, 43, 226], brown: [165, 42, 42], burlywood: [222, 184, 135], cadetblue: [95, 158, 160], chartreuse: [127, 255, 0], chocolate: [210, 105, 30], coral: [255, 127, 80], cornflowerblue: [100, 149, 237], cornsilk: [255, 248, 220], crimson: [220, 20, 60], cyan: [0, 255, 255], darkblue: [0, 0, 139], darkcyan: [0, 139, 139], darkgoldenrod: [184, 134, 11], darkgray: [169, 169, 169], darkgreen: [0, 100, 0], darkgrey: [169, 169, 169], darkkhaki: [189, 183, 107], darkmagenta: [139, 0, 139], darkolivegreen: [85, 107, 47], darkorange: [255, 140, 0], darkorchid: [153, 50, 204], darkred: [139, 0, 0], darksalmon: [233, 150, 122], darkseagreen: [143, 188, 143], darkslateblue: [72, 61, 139], darkslategray: [47, 79, 79], darkslategrey: [47, 79, 79], darkturquoise: [0, 206, 209], darkviolet: [148, 0, 211], deeppink: [255, 20, 147], deepskyblue: [0, 191, 255], dimgray: [105, 105, 105], dimgrey: [105, 105, 105], dodgerblue: [30, 144, 255], firebrick: [178, 34, 34], floralwhite: [255, 250, 240], forestgreen: [34, 139, 34], fuchsia: [255, 0, 255], gainsboro: [220, 220, 220], ghostwhite: [248, 248, 255], gold: [255, 215, 0], goldenrod: [218, 165, 32], gray: [128, 128, 128], green: [0, 128, 0], greenyellow: [173, 255, 47], grey: [128, 128, 128], honeydew: [240, 255, 240], hotpink: [255, 105, 180], indianred: [205, 92, 92], indigo: [75, 0, 130], ivory: [255, 255, 240], khaki: [240, 230, 140], lavender: [230, 230, 250], lavenderblush: [255, 240, 245], lawngreen: [124, 252, 0], lemonchiffon: [255, 250, 205], lightblue: [173, 216, 230], lightcoral: [240, 128, 128], lightcyan: [224, 255, 255], lightgoldenrodyellow: [250, 250, 210], lightgray: [211, 211, 211], lightgreen: [144, 238, 144], lightgrey: [211, 211, 211], lightpink: [255, 182, 193], lightsalmon: [255, 160, 122], lightseagreen: [32, 178, 170], lightskyblue: [135, 206, 250], lightslategray: [119, 136, 153], lightslategrey: [119, 136, 153], lightsteelblue: [176, 196, 222], lightyellow: [255, 255, 224], lime: [0, 255, 0], limegreen: [50, 205, 50], linen: [250, 240, 230], magenta: [255, 0, 255], maroon: [128, 0, 0], mediumaquamarine: [102, 205, 170], mediumblue: [0, 0, 205], mediumorchid: [186, 85, 211], mediumpurple: [147, 112, 219], mediumseagreen: [60, 179, 113], mediumslateblue: [123, 104, 238], mediumspringgreen: [0, 250, 154], mediumturquoise: [72, 209, 204], mediumvioletred: [199, 21, 133], midnightblue: [25, 25, 112], mintcream: [245, 255, 250], mistyrose: [255, 228, 225], moccasin: [255, 228, 181], navajowhite: [255, 222, 173], navy: [0, 0, 128], oldlace: [253, 245, 230], olive: [128, 128, 0], olivedrab: [107, 142, 35], orange: [255, 165, 0], orangered: [255, 69, 0], orchid: [218, 112, 214], palegoldenrod: [238, 232, 170], palegreen: [152, 251, 152], paleturquoise: [175, 238, 238], palevioletred: [219, 112, 147], papayawhip: [255, 239, 213], peachpuff: [255, 218, 185], peru: [205, 133, 63], pink: [255, 192, 203], plum: [221, 160, 221], powderblue: [176, 224, 230], purple: [128, 0, 128], rebeccapurple: [102, 51, 153], red: [255, 0, 0], rosybrown: [188, 143, 143], royalblue: [65, 105, 225], saddlebrown: [139, 69, 19], salmon: [250, 128, 114], sandybrown: [244, 164, 96], seagreen: [46, 139, 87], seashell: [255, 245, 238], sienna: [160, 82, 45], silver: [192, 192, 192], skyblue: [135, 206, 235], slateblue: [106, 90, 205], slategray: [112, 128, 144], slategrey: [112, 128, 144], snow: [255, 250, 250], springgreen: [0, 255, 127], steelblue: [70, 130, 180], tan: [210, 180, 140], teal: [0, 128, 128], thistle: [216, 191, 216], tomato: [255, 99, 71], turquoise: [64, 224, 208], violet: [238, 130, 238], wheat: [245, 222, 179], white: [255, 255, 255], whitesmoke: [245, 245, 245], yellow: [255, 255, 0], yellowgreen: [154, 205, 50] }, _g = (n) => {
    const t = n.replace(/[^a-zA-Z]+/g, "").toLowerCase();
    if (!(t in qc)) return;
    const r = qc[t];
    return { red: r[0], green: r[1], blue: r[2], alpha: 1 };
  }, kg = (n, t) => ({ red: Math.max(0, n.red - Math.round(n.red * t)), green: Math.max(0, n.green - Math.round(n.green * t)), blue: Math.max(0, n.blue - Math.round(n.blue * t)), alpha: n.alpha });
  var mg = D("<div></div>");
  function xl(n, t) {
    Je(t, !0);
    let r = m(t, "color", 7), a = m(t, "image", 7), l = m(t, "size", 7), c = m(t, "shape", 7), u = m(t, "unavailable", 7, !1);
    const s = g(() => r() ? (function(f) {
      f = f.replace(/^#/, "");
      let p = parseInt(f, 16);
      return { red: p >> 16 & 255, green: p >> 8 & 255, blue: 255 & p, alpha: 1 };
    })(r()) : null), i = g(() => {
      let f = { "kaching-swatch-size": `${l() - 2}px` };
      const p = { rounded: 20, circle: 50 }[c()];
      return p && (f = { ...f, "kaching-swatch-border-radius": `${p}%` }), a() ? f = { ...f, "kaching-swatch-image-url": `url(${a()})` } : e(s) && (f = { ...f, "kaching-swatch-color": Re(e(s)), "kaching-swatch-border-color": Re(kg(e(s), 0.1)) }), hn(f);
    });
    var o = { get color() {
      return r();
    }, set color(f) {
      r(f), k();
    }, get image() {
      return a();
    }, set image(f) {
      a(f), k();
    }, get size() {
      return l();
    }, set size(f) {
      l(f), k();
    }, get shape() {
      return c();
    }, set shape(f) {
      c(f), k();
    }, get unavailable() {
      return u();
    }, set unavailable(f = !1) {
      u(f), k();
    } }, d = mg();
    let h;
    return be((f) => {
      h = Ot(d, 1, "kaching-bundles__swatch", null, h, f), Wt(d, e(i));
    }, [() => ({ "kaching-bundles__swatch--unavailable": u() })]), v(n, d), Ye(o);
  }
  function Qt(n, t) {
    Je(t, !0);
    let r = m(t, "element", 7, "button"), a = m(t, "class", 7), l = m(t, "onclick", 7), c = m(t, "onkeydown", 7), u = m(t, "data-value", 7), s = m(t, "title", 7), i = m(t, "id", 7), o = m(t, "role", 7), d = m(t, "aria-label", 7), h = m(t, "aria-expanded", 7), f = m(t, "aria-haspopup", 7), p = m(t, "aria-selected", 7), _ = m(t, "aria-checked", 7), I = m(t, "aria-activedescendant", 7), y = m(t, "aria-controls", 7), x = m(t, "tabindex", 7), M = m(t, "disabled", 7, !1), A = m(t, "ref", 15);
    function V(F) {
      c() && (c()(F), F.defaultPrevented) || M() || F.key !== "Enter" && F.key !== " " || (F.preventDefault(), F.currentTarget.click());
    }
    function C(F) {
      var se;
      if (M()) return F.preventDefault(), void F.stopPropagation();
      (se = l()) == null || se(F);
    }
    var R = { get element() {
      return r();
    }, set element(F = "button") {
      r(F), k();
    }, get class() {
      return a();
    }, set class(F) {
      a(F), k();
    }, get onclick() {
      return l();
    }, set onclick(F) {
      l(F), k();
    }, get onkeydown() {
      return c();
    }, set onkeydown(F) {
      c(F), k();
    }, get "data-value"() {
      return u();
    }, set "data-value"(F) {
      u(F), k();
    }, get title() {
      return s();
    }, set title(F) {
      s(F), k();
    }, get id() {
      return i();
    }, set id(F) {
      i(F), k();
    }, get role() {
      return o();
    }, set role(F) {
      o(F), k();
    }, get "aria-label"() {
      return d();
    }, set "aria-label"(F) {
      d(F), k();
    }, get "aria-expanded"() {
      return h();
    }, set "aria-expanded"(F) {
      h(F), k();
    }, get "aria-haspopup"() {
      return f();
    }, set "aria-haspopup"(F) {
      f(F), k();
    }, get "aria-selected"() {
      return p();
    }, set "aria-selected"(F) {
      p(F), k();
    }, get "aria-checked"() {
      return _();
    }, set "aria-checked"(F) {
      _(F), k();
    }, get "aria-activedescendant"() {
      return I();
    }, set "aria-activedescendant"(F) {
      I(F), k();
    }, get "aria-controls"() {
      return y();
    }, set "aria-controls"(F) {
      y(F), k();
    }, get tabindex() {
      return x();
    }, set tabindex(F) {
      x(F), k();
    }, get disabled() {
      return M();
    }, set disabled(F = !1) {
      M(F), k();
    }, get ref() {
      return A();
    }, set ref(F) {
      A(F), k();
    } }, U = De();
    return Od(ve(U), r, 0, (F, se) => {
      ol(F, (K) => A(K), () => A()), Ed(F, () => {
        var K, J;
        return { role: (K = o()) != null ? K : "button", tabindex: (J = x()) != null ? J : M() ? -1 : 0, class: a(), onclick: C, "data-value": u(), title: s(), id: i(), "aria-label": d(), "aria-expanded": h(), "aria-haspopup": f(), "aria-selected": p(), "aria-checked": _(), "aria-activedescendant": I(), "aria-controls": y(), "aria-disabled": M() ? "true" : void 0, onkeydown: V };
      });
      var X = De();
      tc(ve(X), t, "default", {}), v(se, X);
    }), v(n, U), Ye(R);
  }
  We(xl, { color: {}, image: {}, size: {}, shape: {}, unavailable: {} }, [], [], !0), We(Qt, { element: {}, class: {}, onclick: {}, onkeydown: {}, "data-value": {}, title: {}, id: {}, role: {}, "aria-label": {}, "aria-expanded": {}, "aria-haspopup": {}, "aria-selected": {}, "aria-checked": {}, "aria-activedescendant": {}, "aria-controls": {}, tabindex: {}, disabled: {}, ref: {} }, ["default"], [], !0);
  const Vc = "translations", ya = (n = {}) => {
    const t = Jr(Tc(n));
    return hi(Vc, t), { translate: t, setTranslations: (r) => {
      t.set(Tc(r));
    } };
  }, qt = () => {
    const n = gi(Vc);
    if (!n) throw new Error("getTranslations must be called within a component tree that has setupTranslations initialized");
    return n;
  }, Tc = (n) => (t) => n[t] || t;
  function vs(n) {
    return String.fromCharCode(64 + n);
  }
  async function gr(n, t, r = {}, a = !0) {
    a && await Yl();
    const l = new CustomEvent(t, { detail: r, bubbles: !0, cancelable: !0, composed: !0 });
    n.dispatchEvent(l);
  }
  function Nt(n) {
    return typeof n == "number" ? n : Number(n.split("/").pop());
  }
  function Xn(n) {
    const t = n.variants.filter((r) => r.availableForSale);
    return t.length > 0 ? { ...n, variants: t } : n;
  }
  var yg = D("<span> <!></span>"), xg = D("<span> </span>"), wg = D("<!> <!>", 1), Pg = D("<span> <!></span>"), Sg = D("<span> </span>"), Cg = D("<!> <!>", 1), Bg = D('<div class="kaching-bundles__swatch-dropdown__options" role="listbox"></div>'), Ig = D('<div class="kaching-bundles__swatch-dropdown kaching-bundles-option"><!> <!></div>');
  function Gc(n, t) {
    Je(t, !0);
    const r = () => Me(x, "$translate", a), [a, l] = wt();
    let c = m(t, "option", 7), u = m(t, "swatchSize", 7), s = m(t, "swatchShape", 7), i = m(t, "value", 7), o = m(t, "onChange", 7), d = Ae(!1), h = Ae(-1), f = Ae(void 0), p = Ae(void 0), _ = g(() => c().optionValues.find((N) => N.name === i()) || c().optionValues[0]);
    const I = `swatch-dropdown-${Math.random().toString(16).slice(2)}`;
    function y(N) {
      return `${I}-option-${N}`;
    }
    const x = qt();
    function M() {
      te(d, !0), te(h, c().optionValues.findIndex((N) => N.name === i()), !0), e(h) === -1 && te(h, 0);
    }
    function A() {
      te(d, !1), te(h, -1);
    }
    function V() {
      var N;
      A(), (N = e(f)) == null || N.focus();
    }
    function C(N) {
      i(N), V();
      try {
        const Z = c().optionValues.find(($) => $.name === N);
        Z != null && Z.unavailable && gr(document.body, "kaching-unavailable-option-value-selected", { swatch: "dropdown" });
      } catch (Z) {
        console.error(Z);
      }
      o()(i());
    }
    function R(N, Z) {
      const $ = (S) => {
        N.contains(S.target) || Z();
      };
      return document.addEventListener("click", $, !0), { destroy() {
        document.removeEventListener("click", $, !0);
      } };
    }
    He(() => {
      if (e(d) && e(f) && e(p)) return dg(e(f), e(p), async () => {
        if (!e(f) || !e(p)) return;
        const N = e(p), { x: Z, y: $ } = await fg(e(f), N, { placement: "bottom-start", strategy: "fixed", middleware: [gg(2), pg(), hg({ padding: 8 })] });
        N.style.left = `${Z}px`, N.style.top = `${$}px`;
      });
    });
    var U = { get option() {
      return c();
    }, set option(N) {
      c(N), k();
    }, get swatchSize() {
      return u();
    }, set swatchSize(N) {
      u(N), k();
    }, get swatchShape() {
      return s();
    }, set swatchShape(N) {
      s(N), k();
    }, get value() {
      return i();
    }, set value(N) {
      i(N), k();
    }, get onChange() {
      return o();
    }, set onChange(N) {
      o(N), k();
    } }, F = Ig(), se = P(F);
    {
      let N = g(() => e(d) && e(h) >= 0 ? y(e(h)) : void 0);
      Qt(se, { element: "span", class: "kaching-bundles__bar-variant-select", role: "combobox", get "aria-label"() {
        return c().name;
      }, onclick: function(Z) {
        e(d) ? (te(d, !1), te(h, -1)) : M(), Z.preventDefault();
      }, onkeydown: function(Z) {
        if (!e(d)) return void (Z.key !== "ArrowDown" && Z.key !== "ArrowUp" && Z.key !== "Enter" && Z.key !== " " || (Z.preventDefault(), M()));
        const $ = c().optionValues.length;
        switch (Z.key) {
          case "Escape":
            Z.preventDefault(), V();
            break;
          case "ArrowDown":
            Z.preventDefault(), te(h, e(h) < $ - 1 ? e(h) + 1 : 0, !0);
            break;
          case "ArrowUp":
            Z.preventDefault(), te(h, e(h) > 0 ? e(h) - 1 : $ - 1, !0);
            break;
          case "Home":
            Z.preventDefault(), te(h, 0);
            break;
          case "End":
            Z.preventDefault(), te(h, $ - 1);
            break;
          case "Enter":
          case " ":
            Z.preventDefault(), e(h) >= 0 && C(c().optionValues[e(h)].name);
        }
      }, get "aria-expanded"() {
        return e(d);
      }, "aria-haspopup": "listbox", get "aria-controls"() {
        return I;
      }, get "aria-activedescendant"() {
        return e(N);
      }, get ref() {
        return e(f);
      }, set ref(Z) {
        te(f, Z, !0);
      }, children: (Z, $) => {
        var S = wg(), T = ve(S);
        xl(T, { get color() {
          return e(_).swatch.color;
        }, get image() {
          return e(_).swatch.image;
        }, get size() {
          return u();
        }, get shape() {
          return s();
        }, get unavailable() {
          return e(_).unavailable;
        } }), Ke(E(T, 2), () => e(_).name, (q) => {
          var W = De(), ue = ve(W), Q = (B) => {
            var G = yg(), z = P(G);
            qe(E(z), () => r()("system.unavailable_option_value")), w(G), be(() => {
              var H;
              return mt(z, `${(H = e(_).name) != null ? H : ""} - `);
            }), v(B, G);
          }, b = (B) => {
            var G = xg(), z = P(G, !0);
            w(G), be(() => mt(z, e(_).name)), v(B, G);
          };
          j(ue, (B) => {
            e(_).unavailable ? B(Q) : B(b, !1);
          }), v(q, W);
        }), v(Z, S);
      }, $$slots: { default: !0 } });
    }
    var X = E(se, 2), K = (N) => {
      var Z = Bg();
      Jt(Z, 23, () => c().optionValues, ($) => $.name, ($, S, T) => {
        {
          let q = g(() => ["kaching-bundles__swatch-dropdown__option", "kaching-bundles-option-value", e(T) === e(h) && "kaching-bundles__swatch-dropdown__option--focused"]), W = g(() => y(e(T))), ue = g(() => e(S).name === i());
          Qt($, { element: "span", get class() {
            return e(q);
          }, get id() {
            return e(W);
          }, role: "option", tabindex: -1, get "aria-selected"() {
            return e(ue);
          }, get "data-value"() {
            return e(S).name;
          }, onclick: () => C(e(S).name), children: (Q, b) => {
            var B = Cg(), G = ve(B);
            {
              let L = g(() => 1.333 * u());
              xl(G, { get color() {
                return e(S).swatch.color;
              }, get image() {
                return e(S).swatch.image;
              }, get size() {
                return e(L);
              }, get shape() {
                return s();
              }, get unavailable() {
                return e(S).unavailable;
              } });
            }
            var z = E(G, 2), H = (L) => {
              var O = Pg(), ae = P(O);
              qe(E(ae), () => r()("system.unavailable_option_value")), w(O), be(() => {
                var ee;
                return mt(ae, `${(ee = e(S).name) != null ? ee : ""} - `);
              }), v(L, O);
            }, Y = (L) => {
              var O = Sg(), ae = P(O, !0);
              w(O), be(() => mt(ae, e(S).name)), v(L, O);
            };
            j(z, (L) => {
              e(S).unavailable ? L(H) : L(Y, !1);
            }), v(Q, B);
          }, $$slots: { default: !0 } });
        }
      }), w(Z), ol(Z, ($) => te(p, $), () => e(p)), be(() => Pe(Z, "id", I)), v(N, Z);
    };
    j(X, (N) => {
      e(d) && N(K);
    }), w(F), as(F, (N, Z) => R == null ? void 0 : R(N, Z), () => A), be(() => {
      Pe(F, "data-name", c().name), Pe(F, "data-value", i());
    }), v(n, F);
    var J = Ye(U);
    return l(), J;
  }
  function Mg(n, t, r) {
    try {
      const a = t().optionValues.find((l) => l.name === n.target.value);
      a != null && a.unavailable && gr(document.body, "kaching-unavailable-option-value-selected", { swatch: "default" });
    } catch (a) {
      console.error(a);
    }
    r()(n.target.value);
  }
  We(Gc, { option: {}, swatchSize: {}, swatchShape: {}, value: {}, onChange: {} }, [], [], !0);
  var Dg = D(" <!>", 1), zg = D('<option class="kaching-bundles-option-value"><!></option>'), Ag = D('<select class="kaching-bundles__bar-variant-select kaching-bundles-option"></select>');
  function Oc(n, t) {
    Je(t, !0);
    const [r, a] = wt();
    let l = m(t, "option", 7), c = m(t, "value", 7), u = m(t, "onChange", 7);
    const s = qt();
    var i, o = { get option() {
      return l();
    }, set option(f) {
      l(f), k();
    }, get value() {
      return c();
    }, set value(f) {
      c(f), k();
    }, get onChange() {
      return u();
    }, set onChange(f) {
      u(f), k();
    } }, d = Ag();
    d.__change = [Mg, l, u], Jt(d, 21, () => l().optionValues, (f) => f.name, (f, p) => {
      var _ = zg(), I = P(_), y = (A) => {
        var V = Dg(), C = ve(V);
        qe(E(C), () => Me(s, "$translate", r)("system.unavailable_option_value")), be(() => {
          var R;
          return mt(C, `${(R = e(p).name) != null ? R : ""} - `);
        }), v(A, V);
      }, x = (A) => {
        var V = In();
        be(() => mt(V, e(p).name)), v(A, V);
      };
      j(I, (A) => {
        e(p).unavailable ? A(y) : A(x, !1);
      }), w(_);
      var M = {};
      be(() => {
        var A;
        Pe(_, "data-value", e(p).name), M !== (M = e(p).name) && (_.value = (A = _.__value = e(p).name) != null ? A : "");
      }), v(f, _);
    }), w(d), ss(d), be(() => {
      var f;
      Pe(d, "aria-label", l().name), Pe(d, "data-name", l().name), Pe(d, "data-value", c()), i !== (i = c()) && (d.value = (f = d.__value = c()) != null ? f : "", yi(d, c()));
    }), v(n, d);
    var h = Ye(o);
    return a(), h;
  }
  Pn(["change"]), We(Oc, { option: {}, value: {}, onChange: {} }, [], [], !0);
  var $g = D('<div class="kaching-bundles__swatch-buttons kaching-bundles-option"></div>');
  function Fc(n, t) {
    Je(t, !0);
    const [r, a] = wt();
    let l = m(t, "option", 7), c = m(t, "swatchSize", 7), u = m(t, "swatchShape", 7), s = m(t, "value", 7), i = m(t, "onChange", 7);
    const o = qt();
    var d = { get option() {
      return l();
    }, set option(p) {
      l(p), k();
    }, get swatchSize() {
      return c();
    }, set swatchSize(p) {
      c(p), k();
    }, get swatchShape() {
      return u();
    }, set swatchShape(p) {
      u(p), k();
    }, get value() {
      return s();
    }, set value(p) {
      s(p), k();
    }, get onChange() {
      return i();
    }, set onChange(p) {
      i(p), k();
    } }, h = $g();
    Jt(h, 21, () => l().optionValues, (p) => p.name, (p, _) => {
      {
        let I = g(() => ["kaching-bundles__swatch-buttons__button", "kaching-bundles-option-value", e(_).name === s() && "kaching-bundles__swatch-buttons__button--selected"]), y = g(() => e(_).unavailable ? `${e(_).name} - ${Me(o, "$translate", r)("system.unavailable_option_value")}` : e(_).name);
        Qt(p, { element: "span", get class() {
          return e(I);
        }, get title() {
          return e(_).name;
        }, get "aria-label"() {
          return e(y);
        }, get "data-value"() {
          return e(_).name;
        }, onclick: () => (function(x) {
          s(x);
          try {
            const M = l().optionValues.find((A) => A.name === x);
            M != null && M.unavailable && gr(document.body, "kaching-unavailable-option-value-selected", { swatch: "buttons" });
          } catch (M) {
            console.error(M);
          }
          i()(s());
        })(e(_).name), children: (x, M) => {
          xl(x, { get color() {
            return e(_).swatch.color;
          }, get image() {
            return e(_).swatch.image;
          }, get size() {
            return c();
          }, get shape() {
            return u();
          }, get unavailable() {
            return e(_).unavailable;
          } });
        }, $$slots: { default: !0 } });
      }
    }), w(h), be(() => {
      Pe(h, "data-name", l().name), Pe(h, "data-value", s());
    }), v(n, h);
    var f = Ye(d);
    return a(), f;
  }
  function Lc(n, t) {
    Je(t, !0);
    let r = m(t, "value", 7), a = m(t, "option", 7), l = m(t, "swatchSize", 7, 18), c = m(t, "swatchShape", 7, "circle"), u = m(t, "swatchType", 7), s = m(t, "onChange", 7);
    function i(_) {
      s()({ position: a().position, value: _ });
    }
    var o = { get value() {
      return r();
    }, set value(_) {
      r(_), k();
    }, get option() {
      return a();
    }, set option(_) {
      a(_), k();
    }, get swatchSize() {
      return l();
    }, set swatchSize(_ = 18) {
      l(_), k();
    }, get swatchShape() {
      return c();
    }, set swatchShape(_ = "circle") {
      c(_), k();
    }, get swatchType() {
      return u();
    }, set swatchType(_) {
      u(_), k();
    }, get onChange() {
      return s();
    }, set onChange(_) {
      s(_), k();
    } }, d = De(), h = ve(d), f = (_) => {
      Gc(_, { get option() {
        return a();
      }, get swatchSize() {
        return l();
      }, get swatchShape() {
        return c();
      }, get value() {
        return r();
      }, onChange: i });
    }, p = (_) => {
      var I = De(), y = ve(I), x = (A) => {
        Fc(A, { get option() {
          return a();
        }, get swatchSize() {
          return l();
        }, get swatchShape() {
          return c();
        }, get value() {
          return r();
        }, onChange: i });
      }, M = (A) => {
        Oc(A, { get option() {
          return a();
        }, get value() {
          return r();
        }, onChange: i });
      };
      j(y, (A) => {
        u() === "colorButtons" || u() === "imageButtons" || u() === "productImageButtons" ? A(x) : A(M, !1);
      }, !0), v(_, I);
    };
    return j(h, (_) => {
      u() === "colorDropdown" || u() === "imageDropdown" || u() === "productImageDropdown" || u() === "mixedDropdown" ? _(f) : _(p, !1);
    }), v(n, d), Ye(o);
  }
  We(Fc, { option: {}, swatchSize: {}, swatchShape: {}, value: {}, onChange: {} }, [], [], !0), We(Lc, { value: {}, option: {}, swatchSize: {}, swatchShape: {}, swatchType: {}, onChange: {} }, [], [], !0);
  const Ec = "mediaImages", Bi = (n = []) => {
    const t = Jr(jc(n));
    return hi(Ec, t), { getMediaImageUrl: t, setMediaImages: (r) => {
      t.set(jc(r));
    } };
  }, qn = () => {
    const n = gi(Ec);
    if (!n) throw new Error("getMediaImages must be called within a component tree that has setupMediaImages initialized");
    return n;
  }, jc = (n) => (t) => {
    if (!t) return;
    const r = n.find((a) => a.gid === t);
    return r == null ? void 0 : r.url;
  }, Rc = "config", xa = (n) => {
    const t = Jr(n);
    return hi(Rc, t), { config: t, setConfig: (r) => {
      t.set(r);
    } };
  }, on = () => {
    const n = gi(Rc);
    if (!n) throw new Error("getConfig must be called within a component tree that has setupConfig initialized");
    return n;
  }, Qc = "swatchSettings", Ii = (n) => {
    const t = Jr(n);
    return hi(Qc, t), { swatchSettings: t, setSwatchSettings: (r) => {
      t.set(r);
    } };
  };
  var qg = D('<img alt="" class="kaching-bundles__bar-variant-image"/>'), Vg = D('<div class="kaching-bundles__bar-variant-number"><span>#</span> <span> </span></div>'), Tg = D('<div class="kaching-bundles__invalid-variant-error"><!></div>'), Gg = D('<div><div class="kaching-bundles__bar-variant__content"><!> <div class="kaching-bundles__bar-variant-selects"></div></div> <!></div>');
  function Mn(n, t) {
    Je(t, !0);
    const r = () => Me(I, "$config", l), a = () => Me(y, "$swatchSettings", l), [l, c] = wt();
    let u = m(t, "product", 7), s = m(t, "selectedVariantId", 7), i = m(t, "number", 7, void 0), o = m(t, "showImage", 7, !1), d = m(t, "forceDropdown", 7, !1), h = m(t, "onChange", 7), f = m(t, "onOptionChange", 7);
    const p = qt(), _ = qn(), I = on(), y = (() => {
      const b = gi(Qc);
      if (!b) throw new Error("getSwatchSettings must be called within a component tree that has setupSwatchSettings initialized");
      return b;
    })();
    let x = g(() => u().variants.find((b) => b.id === s())), M = Ae(rt([]));
    He(() => {
      if (e(x)) te(M, [...e(x).options], !0);
      else {
        if (s() && r().featureFlags.hide_missing_variants && u().variants.length > 0) {
          const b = X(u().variants, 0, e(M));
          if (b) return te(M, [...b.options], !0), void Xt(() => h()(b.id));
        }
        te(M, [], !0);
      }
    });
    let A = g(() => {
      return b = u(), B = e(M), G = a().swatchOptions, z = Me(_, "$getMediaImageUrl", l), H = d(), b.options.map((Y) => ({ name: Y.name, position: Y.position, swatchType: R(Y, G, H), optionValues: Y.optionValues.map((L) => {
        const O = se(Y.position, L.name, B, b);
        if (r().featureFlags.hide_missing_variants && O.length === 0) return null;
        const ae = !O.some((ee) => ee.availableForSale);
        return { name: L.name, unavailable: ae, swatch: U(Y, L, G, z, B, b) };
      }).filter((L) => L !== null) }));
      var b, B, G, z, H;
    }), V = g(() => {
      var b;
      return o() ? ((b = e(x)) == null ? void 0 : b.image) || u().image : null;
    });
    function C({ position: b, value: B }) {
      const G = e(M)[b - 1];
      e(M)[b - 1] = B;
      let z = u().variants.find((H) => e(M).every((Y, L) => H.options[L] === Y));
      if (!z && r().featureFlags.hide_missing_variants) {
        const H = X(se(b, B, e(M), u()), b, e(M));
        H && (z = H, te(M, [...z.options], !0));
      }
      z && (h()(z.id), f() && f()(b, B, G));
    }
    function R(b, B, G) {
      var z;
      const H = (z = B.find((Y) => Y.name === b.defaultName)) == null ? void 0 : z.swatchType;
      if (H && H !== "default") return G ? (function(Y) {
        switch (Y) {
          case "colorButtons":
            return "colorDropdown";
          case "imageButtons":
            return "imageDropdown";
          case "productImageButtons":
            return "productImageDropdown";
          default:
            return Y;
        }
      })(H) : H;
      if (!r().featureFlags.native_swatches_disabled) {
        for (const Y of b.optionValues) if (Y.swatch.image || Y.swatch.color) return "mixedDropdown";
      }
      return "default";
    }
    function U(b, B, G, z, H, Y) {
      var L, O;
      const ae = r().featureFlags.native_swatches_disabled ? null : B.swatch, ee = G.find((le) => le.name === b.defaultName);
      if (!ee || ee.swatchType === "default") return ae || { color: null, image: null };
      if (ee.swatchType === "colorButtons" || ee.swatchType === "colorDropdown")
        return { color: F((L = ee.colors.find((le) => le.name === B.defaultName)) == null ? void 0 : L.color) || (ae == null ? void 0 : ae.color) || F(_g(B.defaultName)) || null, image: null };
      if (ee.swatchType === "imageButtons" || ee.swatchType === "imageDropdown") {
        const le = z(((O = ee.images.find((re) => re.name === B.defaultName)) == null ? void 0 : O.mediaImageGID) || null);
        return { color: (ae == null ? void 0 : ae.color) || null, image: le || (ae == null ? void 0 : ae.image) || null };
      }
      if (ee.swatchType === "productImageDropdown" || ee.swatchType === "productImageButtons") {
        const le = b.position - 1, re = Y.variants.filter((ce) => ce.image && ce.options[le] === B.name);
        let fe = re[0], ze = 0;
        for (const ce of re) {
          let ie = 0;
          for (let ke = 0; ke < le; ke++) ce.options[ke] === H[ke] && ie++;
          ie > ze && (ze = ie, fe = ce);
        }
        return { color: null, image: (fe == null ? void 0 : fe.image) || null };
      }
      return { color: null, image: null };
    }
    function F(b) {
      if (!b) return;
      const { red: B, green: G, blue: z } = b;
      return `#${B.toString(16).padStart(2, "0")}${G.toString(16).padStart(2, "0")}${z.toString(16).padStart(2, "0")}`;
    }
    function se(b, B, G, z) {
      const H = b - 1, Y = G.slice(0, H);
      return z.variants.filter((L) => L.options[H] === B && Y.every((O, ae) => L.options[ae] === O));
    }
    function X(b, B, G) {
      if (b.length === 0) return null;
      let z = b[0], H = -1;
      const Y = G.slice(B);
      for (const L of b) {
        let O = 0;
        for (let ae = 0; ae < Y.length; ae++) L.options[B + ae] === Y[ae] && (O += Y.length - ae);
        O > H && (H = O, z = L);
      }
      return z;
    }
    var K = { get product() {
      return u();
    }, set product(b) {
      u(b), k();
    }, get selectedVariantId() {
      return s();
    }, set selectedVariantId(b) {
      s(b), k();
    }, get number() {
      return i();
    }, set number(b = void 0) {
      i(b), k();
    }, get showImage() {
      return o();
    }, set showImage(b = !1) {
      o(b), k();
    }, get forceDropdown() {
      return d();
    }, set forceDropdown(b = !1) {
      d(b), k();
    }, get onChange() {
      return h();
    }, set onChange(b) {
      h(b), k();
    }, get onOptionChange() {
      return f();
    }, set onOptionChange(b) {
      f(b), k();
    } }, J = Gg();
    let N;
    var Z = P(J), $ = P(Z), S = (b) => {
      var B = qg();
      be(() => Pe(B, "src", e(V))), v(b, B);
    }, T = (b) => {
      var B = De(), G = ve(B), z = (H) => {
        var Y = Vg(), L = E(P(Y), 2), O = P(L, !0);
        w(L), w(Y), be(() => mt(O, i())), v(H, Y);
      };
      j(G, (H) => {
        i() && H(z);
      }, !0), v(b, B);
    };
    j($, (b) => {
      e(V) ? b(S) : b(T, !1);
    });
    var q = E($, 2);
    Jt(q, 21, () => e(A), (b) => b.name, (b, B) => {
      Lc(b, { get option() {
        return e(B);
      }, get swatchSize() {
        return a().swatchSize;
      }, get swatchShape() {
        return a().swatchShape;
      }, get swatchType() {
        return e(B).swatchType;
      }, get value() {
        return e(M)[e(B).position - 1];
      }, onChange: C });
    }), w(q), w(Z);
    var W = E(Z, 2), ue = (b) => {
      var B = Tg();
      qe(P(B), () => Me(p, "$translate", l)("system.invalid_variant")), w(B), v(b, B);
    };
    j(W, (b) => {
      e(x) && e(x).availableForSale || b(ue);
    }), w(J), be((b) => N = Ot(J, 1, "kaching-bundles__bar-variant", null, N, b), [() => ({ "kaching-bundles__bar-variant--invalid": !e(x) || !e(x).availableForSale })]), v(n, J);
    var Q = Ye(K);
    return c(), Q;
  }
  We(Mn, { product: {}, selectedVariantId: {}, number: {}, showImage: {}, forceDropdown: {}, onChange: {}, onOptionChange: {} }, [], [], !0);
  var Og = D('<a target="_blank"><!></a>'), Fg = D("<div><!></div>");
  function Vn(n, t) {
    Je(t, !0);
    const r = m(t, "url", 7), a = m(t, "children", 7), l = m(t, "class", 7);
    var c = { get url() {
      return r();
    }, set url(d) {
      r(d), k();
    }, get children() {
      return a();
    }, set children(d) {
      a(d), k();
    }, get class() {
      return l();
    }, set class(d) {
      l(d), k();
    } }, u = De(), s = ve(u), i = (d) => {
      var h = Og();
      ns(P(h), a), w(h), be(() => {
        Pe(h, "href", r()), Ot(h, 1, mi(l()));
      }), v(d, h);
    }, o = (d) => {
      var h = Fg();
      ns(P(h), a), w(h), be(() => Ot(h, 1, mi(l()))), v(d, h);
    };
    return j(s, (d) => {
      r() ? d(i) : d(o, !1);
    }), v(n, u), Ye(c);
  }
  We(Vn, { url: {}, children: {}, class: {} }, [], [], !0);
  const Nc = "priceFormatter", Na = (n = "{{amount}}", t) => {
    const r = Jr(Wc(n, t));
    return hi(Nc, r), { formatPrice: r, setMoneyFormat: (a, l) => {
      r.set(Wc(a, l));
    } };
  }, cn = () => {
    const n = gi(Nc);
    if (!n) throw new Error("getPriceFormatter must be called within a component tree that has setupPriceFormatter initialized");
    return n;
  }, Wc = (n, t) => (r, a) => Lg(r, n, (!(a != null && a.preserveDecimals) || Math.round(r) % 100 == 0) && t), Lg = (n, t, r) => {
    const a = ((i, o) => o ? i.includes("amount_no_decimals") ? i : i.replace(/\{\{.+\}\}/g, "{{ amount_no_decimals }}") : i)(t, r), l = { amount: (i) => i.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }), amount_no_decimal: (i) => i.toLocaleString("en-US", { maximumFractionDigits: 0 }), amount_no_decimals: (i) => i.toLocaleString("en-US", { maximumFractionDigits: 0 }), amount_with_comma_separator: (i) => i.toLocaleString("de-DE", { minimumFractionDigits: 2, maximumFractionDigits: 2 }), amount_no_decimals_with_comma_separator: (i) => i.toLocaleString("de-DE", { maximumFractionDigits: 0 }), amount_with_apostrophe_separator: (i) => i.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }).replace(/,/g, "'"), amount_no_decimals_with_space_separator: (i) => i.toLocaleString("fr-FR", { maximumFractionDigits: 0 }).replace(/\s/g, " "), amount_with_space_separator: (i) => i.toLocaleString("fr-FR", { minimumFractionDigits: 2, maximumFractionDigits: 2 }).replace(/\s/g, " "), amount_with_period_and_space_separator: (i) => i.toLocaleString("fr-FR", { minimumFractionDigits: 2, maximumFractionDigits: 2 }).replace(/\s/g, " ").replace(",", ".") }, c = /{{\s*(\w+)\s*}}/, u = a.match(c), s = (l[u ? u[1] : "amount"] || l.amount)(n / 100);
    return a.replace(c, s);
  }, Uc = "data:image/svg+xml,%3csvg%20width='10'%20height='10'%20viewBox='0%200%2010%2010'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M2.08398%205H7.91732'%20stroke='%23344054'%20stroke-width='2'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e", Hc = "data:image/svg+xml,%3csvg%20width='10'%20height='10'%20viewBox='0%200%2010%2010'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M5.00065%202.08337V7.91671M2.08398%205.00004H7.91732'%20stroke='%23344054'%20stroke-width='2'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e", Eg = { new_price: ({ totalDiscountedPrice: n, quantity: t }) => ({ value: n / t, type: "price" }), new_total: ({ totalDiscountedPrice: n }) => ({ value: n, type: "price" }), original_price: ({ totalFullPrice: n, quantity: t }) => ({ value: n / t, type: "price" }), original_total: ({ totalFullPrice: n }) => ({ value: n, type: "price" }), saved_total: ({ totalFullPrice: n, totalDiscountedPrice: t }) => ({ value: n - t, type: "price" }), saved_amount: ({ totalFullPrice: n, totalDiscountedPrice: t, quantity: r }) => ({ value: (n - t) / r, type: "price" }), quantity: ({ quantity: n }) => ({ value: n, type: "number" }), buy_quantity: ({ dealBar: n, quantity: t }) => {
    if ((n == null ? void 0 : n.dealBarType) !== "bxgy") return;
    const r = n.buyQuantity + n.getQuantity;
    return { value: t - Math.floor(t / r) * n.getQuantity, type: "number" };
  }, get_quantity: ({ dealBar: n, quantity: t }) => {
    if ((n == null ? void 0 : n.dealBarType) !== "bxgy") return;
    const r = n.buyQuantity + n.getQuantity;
    return { value: Math.floor(t / r) * n.getQuantity, type: "number" };
  }, saved_percentage: ({ totalFullPrice: n, totalDiscountedPrice: t, dealBar: r, legacySavedPercentage: a }) => {
    if (a && r && (r.dealBarType === "quantity-break" || !r.dealBarType) && r.discountType === "percentage") return { value: Math.round(Number(r.discountValue)), type: "percentage" };
    let l = (n - t) / n * 100;
    return l = Math.round(100 * l) / 100, { value: Math.round(l), type: "percentage" };
  }, new_unit_price: ({ totalDiscountedPrice: n, unitQuantity: t }) => {
    if (t) return { value: n / t, type: "price", preserveDecimals: !0 };
  }, saved_per_unit: ({ totalFullPrice: n, totalDiscountedPrice: t, unitQuantity: r }) => {
    if (r) return { value: (n - t) / r, type: "price", preserveDecimals: !0 };
  }, original_unit_price: ({ totalFullPrice: n, unitQuantity: t }) => {
    if (t) return { value: n / t, type: "price", preserveDecimals: !0 };
  }, unit_quantity: ({ unitQuantity: n }) => {
    if (n) return { value: n, type: "number" };
  } }, jg = /{{\s*([a-zA-Z0-9_.]+)\s*(?:([+\-*/])\s*(\d+(?:\.\d+)?)?)?\s*}}/g, Rg = /\{\{[^}]*\}\}/g, Qg = ({ priceFormatter: n, product: t, totalFullPrice: r, totalDiscountedPrice: a, quantity: l, dealBar: c, legacySavedPercentage: u, unitQuantity: s, sellingPlan: i }) => (o, d, h) => {
    const f = Eg[o];
    if (f) {
      const p = f({ totalFullPrice: r, totalDiscountedPrice: a, quantity: l, dealBar: c, legacySavedPercentage: u, unitQuantity: s });
      if (!p) return;
      let _ = p.value;
      if (d !== void 0 && h !== void 0) {
        const y = ((x, M, A) => {
          switch (M) {
            case "+":
              return x + A;
            case "-":
              return x - A;
            case "*":
              return x * A;
            case "/":
              return A === 0 ? void 0 : x / A;
          }
        })(_, d, p.type !== "price" || d !== "+" && d !== "-" ? h : 100 * h);
        if (y === void 0) return;
        _ = y;
      }
      const I = d === "/" || p.preserveDecimals === !0;
      return ((y, x, M, A) => {
        switch (x) {
          case "price":
            return M(y, { preserveDecimals: A });
          case "number":
            return String(Math.round(100 * y) / 100);
          case "percentage":
            return `${Math.round(y)}%`;
        }
      })(_, p.type, n, I);
    }
    if (d === void 0) return (({ variable: p, product: _, sellingPlan: I }) => {
      switch (p) {
        case "product":
          return _ == null ? void 0 : _.title;
        case "metafield":
          return (_ == null ? void 0 : _.metafields.text) || void 0;
        case "metafield2":
          return (_ == null ? void 0 : _.metafields.text2) || void 0;
        case "metafield3":
          return (_ == null ? void 0 : _.metafields.text3) || void 0;
        case "metafield4":
          return (_ == null ? void 0 : _.metafields.text4) || void 0;
        case "selling_plan":
          return (I == null ? void 0 : I.name) || void 0;
      }
    })({ variable: o, product: t, sellingPlan: i });
  }, pn = ({ priceFormatter: n, product: t, totalFullPrice: r, totalDiscountedPrice: a, quantity: l, dealBar: c, legacySavedPercentage: u = !1, unitQuantity: s, sellingPlan: i }) => (o) => {
    if (!o) return o;
    const d = Qg({ priceFormatter: n, product: t, totalFullPrice: r, totalDiscountedPrice: a, quantity: l, dealBar: c, legacySavedPercentage: u, unitQuantity: s, sellingPlan: i });
    return o.replace(jg, (h, f, p, _) => {
      var I;
      if (p && _) {
        const y = parseFloat(_);
        return (I = d(f, p, y)) != null ? I : "";
      }
      return d(f) || "";
    }).replace(Rg, "");
  };
  function _s(n) {
    const { unitPriceMeasurement: t } = n;
    return t ? t.referenceValue == 1 ? t.referenceUnit : `${t.referenceValue}${t.referenceUnit}` : null;
  }
  function er(n) {
    return n.reduce((t, { variant: r, quantity: a }) => {
      const { unitPriceMeasurement: l } = r;
      if (!l) return t;
      const c = (function(u, s, i) {
        if (s === i) return u;
        if (s === "g" && i === "kg" || s === "ml" && i === "l") return u / 1e3;
      })(l.quantityValue, l.quantityUnit, l.referenceUnit);
      return c ? t + c / l.referenceValue * a : t;
    }, 0) || null;
  }
  var Ng = D('<img class="kaching-bundles__choose-multiple-gifts__product-image" alt=""/>'), Wg = D('<span class="kaching-bundles__choose-multiple-gifts__product-title"> </span>'), Ug = D('<span class="kaching-bundles__choose-multiple-gifts__subtitle"><!></span>'), Hg = D('<div class="kaching-bundles__choose-multiple-gifts__product-compare-at-price"><!></div>'), Zg = D('<span class="kaching-bundles__choose-multiple-gifts__variant-counter"></span>'), Jg = D('<div class="kaching-bundles__choose-multiple-gifts__variant-selector-row"><div class="kaching-bundles__choose-multiple-gifts__variant-selector-content"><!> <div class="kaching-bundles__choose-multiple-gifts__variant-selector-with-counter"><!> <div class="kaching-bundles__choose-multiple-gifts__variant-selector-wrapper"><!></div></div></div></div>'), Yg = D('<div class="kaching-bundles__choose-multiple-gifts__variant-selectors"></div>'), Kg = D('<img alt="Decrease"/>'), Xg = D('<img alt="Increase"/>'), eh = D('<div class="kaching-bundles__choose-multiple-gifts__gift-quantity"><!> <span class="kaching-bundles__choose-multiple-gifts__gift-quantity-value"> </span> <!></div>'), th = D("<img/>"), nh = D("<!> <!>", 1), rh = D('<div class="kaching-bundles__choose-multiple-gifts__product"><div class="kaching-bundles__choose-multiple-gifts__product-container"><!> <div class="kaching-bundles__choose-multiple-gifts__product-content"><!> <!> <div class="kaching-bundles__choose-multiple-gifts__product-price-container"><div class="kaching-bundles__choose-multiple-gifts__product-price"><!></div> <!></div> <!></div></div> <div class="kaching-bundles__choose-multiple-gifts__product-actions"><!> <!></div></div>');
  function Zc(n, t) {
    Je(t, !0);
    const r = () => Me(y, "$formatPrice", l), a = () => Me(I, "$translate", l), [l, c] = wt(), u = m(t, "product", 7), s = m(t, "dealBlock", 7), i = m(t, "multipleGiftsSelector", 7), o = m(t, "selectedVariantIds", 7), d = m(t, "availableQuantity", 7), h = m(t, "onSelect", 7), f = m(t, "onRemove", 7), p = m(t, "onVariantChange", 7), _ = m(t, "onQuantityChange", 7), I = qt(), y = cn();
    let x = Ae(!1);
    const M = g(() => o().length > 0), A = g(() => o().length || 1), V = g(() => !e(M) && d() === 0), C = g(() => u().variants.find((ie) => ie.id === o()[0]) || u().variants[0]), R = g(() => e(x) && e(C).image || u().image), U = g(() => o().map((ie) => u().variants.find((ke) => ke.id === ie) || u().variants[0])), F = g(() => e(U).length > 0 ? e(U).reduce((ie, ke) => ie + Z(s(), ke), 0) : Z(s(), e(C))), se = g(() => u().url ? `${u().url}?variant=${o()[0] || u().variants[0].id}` : void 0), X = g(() => s().chooseMultipleGiftsModal), K = g(() => pn({ priceFormatter: r(), product: u(), totalFullPrice: e(F), totalDiscountedPrice: 0, quantity: e(A), unitQuantity: er(e(U).map((ie) => ({ variant: ie, quantity: 1 }))) })), J = g(() => {
      var ie;
      return e(K)(a()(((ie = e(X)) == null ? void 0 : ie.subtitle) || ""));
    }), N = g(() => {
      var ie, ke;
      return e(M) ? (ie = e(X)) == null ? void 0 : ie.buttonTextAfterSelection : (ke = e(X)) == null ? void 0 : ke.buttonTextBeforeSelection;
    });
    function Z(ie, ke) {
      return ie.useProductCompareAtPrice && ke.compareAtPrice ? Math.max(ke.price, ke.compareAtPrice) : ke.price;
    }
    function $() {
      e(A) <= 1 || _()(e(A) - 1);
    }
    function S() {
      e(A) >= d() || _()(e(A) + 1);
    }
    var T = { get product() {
      return u();
    }, set product(ie) {
      u(ie), k();
    }, get dealBlock() {
      return s();
    }, set dealBlock(ie) {
      s(ie), k();
    }, get multipleGiftsSelector() {
      return i();
    }, set multipleGiftsSelector(ie) {
      i(ie), k();
    }, get selectedVariantIds() {
      return o();
    }, set selectedVariantIds(ie) {
      o(ie), k();
    }, get availableQuantity() {
      return d();
    }, set availableQuantity(ie) {
      d(ie), k();
    }, get onSelect() {
      return h();
    }, set onSelect(ie) {
      h(ie), k();
    }, get onRemove() {
      return f();
    }, set onRemove(ie) {
      f(ie), k();
    }, get onVariantChange() {
      return p();
    }, set onVariantChange(ie) {
      p(ie), k();
    }, get onQuantityChange() {
      return _();
    }, set onQuantityChange(ie) {
      _(ie), k();
    } }, q = rh(), W = P(q), ue = P(W), Q = (ie) => {
      Vn(ie, { get url() {
        return e(se);
      }, class: "kaching-bundles__choose-multiple-gifts__product-image-link", children: (ke, we) => {
        var _e = Ng();
        Pe(_e, "width", 100), Pe(_e, "height", 100), be(() => Pe(_e, "src", e(R))), v(ke, _e);
      }, $$slots: { default: !0 } });
    };
    j(ue, (ie) => {
      e(R) && ie(Q);
    });
    var b = E(ue, 2), B = P(b);
    Vn(B, { get url() {
      return e(se);
    }, class: "kaching-bundles__choose-multiple-gifts__product-link", children: (ie, ke) => {
      var we = Wg(), _e = P(we, !0);
      w(we), be(() => mt(_e, u().title)), v(ie, we);
    }, $$slots: { default: !0 } });
    var G = E(B, 2), z = (ie) => {
      var ke = Ug();
      qe(P(ke), () => e(J)), w(ke), v(ie, ke);
    };
    j(G, (ie) => {
      e(J) && ie(z);
    });
    var H = E(G, 2), Y = P(H);
    qe(P(Y), () => a()("system.free")), w(Y);
    var L = E(Y, 2), O = (ie) => {
      var ke = De();
      Ke(ve(ke), () => e(F), (we) => {
        var _e = Hg();
        qe(P(_e), () => r()(e(F))), w(_e), v(we, _e);
      }), v(ie, ke);
    };
    j(L, (ie) => {
      i().showPrice && e(F) > 0 && ie(O);
    }), w(H);
    var ae = E(H, 2), ee = (ie) => {
      var ke = Yg();
      Jt(ke, 21, o, Zr, (we, _e, ye) => {
        var Se = Jg(), Ve = P(Se), Ee = P(Ve), ne = ($e) => {
          Vr($e, { get product() {
            return u();
          }, class: "kaching-bundles__choose-multiple-gifts__product-option-names" });
        };
        j(Ee, ($e) => {
          ye === 0 && $e(ne);
        });
        var ge = E(Ee, 2), Te = P(ge), pe = ($e) => {
          var je = Zg();
          je.textContent = `#${ye + 1}`, v($e, je);
        };
        j(Te, ($e) => {
          o().length > 1 && $e(pe);
        });
        var de = E(Te, 2);
        Mn(P(de), { get product() {
          return u();
        }, get selectedVariantId() {
          return e(_e);
        }, onChange: ($e) => {
          te(x, !0), p()(ye, $e);
        } }), w(de), w(ge), w(Ve), w(Se), v(we, Se);
      }), w(ke), v(ie, ke);
    };
    j(ae, (ie) => {
      u().variants.length > 1 && ie(ee);
    }), w(b), w(W);
    var le = E(W, 2), re = P(le), fe = (ie) => {
      var ke = eh(), we = P(ke);
      {
        let Ve = g(() => e(A) <= 1);
        Qt(we, { element: "span", class: "kaching-bundles__choose-multiple-gifts__gift-quantity-button", onclick: $, get disabled() {
          return e(Ve);
        }, children: (Ee, ne) => {
          var ge = Kg();
          be(() => Pe(ge, "src", Uc)), v(Ee, ge);
        }, $$slots: { default: !0 } });
      }
      var _e = E(we, 2), ye = P(_e, !0);
      w(_e);
      var Se = E(_e, 2);
      {
        let Ve = g(() => e(A) >= d());
        Qt(Se, { element: "span", class: "kaching-bundles__choose-multiple-gifts__gift-quantity-button", onclick: S, get disabled() {
          return e(Ve);
        }, children: (Ee, ne) => {
          var ge = Xg();
          be(() => Pe(ge, "src", Hc)), v(Ee, ge);
        }, $$slots: { default: !0 } });
      }
      w(ke), be(() => mt(ye, e(A))), v(ie, ke);
    };
    j(re, (ie) => {
      e(M) && i().maxQuantity > 1 && ie(fe);
    });
    var ze = E(re, 2);
    {
      let ie = g(() => ["kaching-bundles__choose-multiple-gifts__product-button", e(V) && "kaching-bundles__choose-multiple-gifts__product-button--disabled", e(M) && "kaching-bundles__choose-multiple-gifts__product-button--selected"]);
      Qt(ze, { element: "span", get class() {
        return e(ie);
      }, onclick: function() {
        e(M) ? (te(x, !1), f()()) : h()();
      }, get disabled() {
        return e(V);
      }, children: (ke, we) => {
        var _e = nh(), ye = ve(_e), Se = (ge) => {
          var Te = th();
          be((pe) => {
            Pe(Te, "src", "data:image/svg+xml,%3csvg%20width='20'%20height='20'%20viewBox='0%200%2020%2020'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M13.3333%205.00008V4.33341C13.3333%203.39999%2013.3333%202.93328%2013.1517%202.57676C12.9919%202.26316%2012.7369%202.00819%2012.4233%201.8484C12.0668%201.66675%2011.6001%201.66675%2010.6667%201.66675H9.33333C8.39991%201.66675%207.9332%201.66675%207.57668%201.8484C7.26308%202.00819%207.00811%202.26316%206.84832%202.57676C6.66667%202.93328%206.66667%203.39999%206.66667%204.33341V5.00008M2.5%205.00008H17.5M15.8333%205.00008V14.3334C15.8333%2015.7335%2015.8333%2016.4336%2015.5608%2016.9684C15.3212%2017.4388%2014.9387%2017.8212%2014.4683%2018.0609C13.9335%2018.3334%2013.2335%2018.3334%2011.8333%2018.3334H8.16667C6.76654%2018.3334%206.06647%2018.3334%205.53169%2018.0609C5.06129%2017.8212%204.67883%2017.4388%204.43915%2016.9684C4.16667%2016.4336%204.16667%2015.7335%204.16667%2014.3334V5.00008'%20stroke='%23F04438'%20stroke-width='1.5'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e"), Pe(Te, "alt", pe);
          }, [() => a()("system.remove")]), v(ge, Te);
        };
        j(ye, (ge) => {
          e(M) && ge(Se);
        });
        var Ve = E(ye, 2), Ee = (ge) => {
          var Te = In();
          be((pe) => mt(Te, pe), [() => a()(e(N))]), v(ge, Te);
        }, ne = (ge) => {
          v(ge, In("Choose"));
        };
        j(Ve, (ge) => {
          e(N) ? ge(Ee) : ge(ne, !1);
        }), v(ke, _e);
      }, $$slots: { default: !0 } });
    }
    w(le), w(q), v(n, q);
    var ce = Ye(T);
    return c(), ce;
  }
  We(Zc, { product: {}, dealBlock: {}, multipleGiftsSelector: {}, selectedVariantIds: {}, availableQuantity: {}, onSelect: {}, onRemove: {}, onVariantChange: {}, onQuantityChange: {} }, [], [], !0);
  const ah = { red: 0, green: 0, blue: 0, alpha: 0.5 };
  function ih(n, t) {
    var r;
    (r = t()) == null || r();
  }
  function lh(n, t, r, a, l) {
    var c;
    const u = t();
    r()(a().id, u), (c = l()) == null || c();
  }
  var sh = D('<img alt="Close"/>'), oh = D('<div class="kaching-bundles__choose-multiple-gifts"><div class="kaching-bundles__choose-multiple-gifts__header"><h2 class="kaching-bundles__choose-multiple-gifts__heading"><!></h2> <!></div> <div class="kaching-bundles__choose-multiple-gifts__products"></div> <div class="kaching-bundles__choose-multiple-gifts__footer"><span class="kaching-bundles__choose-multiple-gifts__footer-text"> </span> <div class="kaching-bundles__choose-multiple-gifts__footer-buttons"><button class="kaching-bundles__choose-multiple-gifts__footer-button kaching-bundles__choose-multiple-gifts__footer-button--cancel"> </button> <button class="kaching-bundles__choose-multiple-gifts__footer-button kaching-bundles__choose-multiple-gifts__footer-button--confirm"> </button></div></div></div>');
  function ks(n, t) {
    Je(t, !0);
    const r = () => Me(h, "$translate", a), [a, l] = wt(), c = m(t, "dealBlock", 7), u = m(t, "multipleGiftsSelector", 7), s = m(t, "products", 23, () => []), i = m(t, "initialSelectedGifts", 23, () => []), o = m(t, "onConfirm", 7, () => {
    }), d = m(t, "onClose", 7), h = qt();
    let f = Ae(rt((function(b) {
      const B = {};
      for (const G of b) {
        const z = G.product.id;
        B[z] || (B[z] = []), B[z].push(G.variant.id);
      }
      return B;
    })(i())));
    const p = g(() => c().chooseMultipleGiftsModal), _ = g(() => ((b) => b ? hn({ "kaching-choose-multiple-gifts-button-size": b.buttonSize + "px", "kaching-choose-multiple-gifts-text-size": b.textSize + "px", "kaching-choose-multiple-gifts-price-color": Re(b.priceColor), "kaching-choose-multiple-gifts-compare-at-price-color": Re(b.compareAtPriceColor), "kaching-choose-multiple-gifts-text-color": Re(b.textColor), "kaching-choose-multiple-gifts-button-color": Re(b.buttonColor), "kaching-choose-multiple-gifts-button-text-color": Re(b.buttonTextColor), "kaching-choose-multiple-gifts-photo-size": b.productPhotoSize + "px" }) : "")(e(p) || null)), I = g(() => u().maxQuantity), y = g(() => Object.values(e(f)).reduce((b, B) => b + B.length, 0));
    function x(b) {
      return e(f)[b] || [];
    }
    function M(b) {
      const B = b.variants.find((G) => G.availableForSale);
      return (B == null ? void 0 : B.id) || b.variants[0].id;
    }
    const A = g(() => {
      var b;
      return ((b = e(p)) == null ? void 0 : b.footerText) || "FREE gifts selected";
    });
    var V = { get dealBlock() {
      return c();
    }, set dealBlock(b) {
      c(b), k();
    }, get multipleGiftsSelector() {
      return u();
    }, set multipleGiftsSelector(b) {
      u(b), k();
    }, get products() {
      return s();
    }, set products(b = []) {
      s(b), k();
    }, get initialSelectedGifts() {
      return i();
    }, set initialSelectedGifts(b = []) {
      i(b), k();
    }, get onConfirm() {
      return o();
    }, set onConfirm(b = () => {
    }) {
      o(b), k();
    }, get onClose() {
      return d();
    }, set onClose(b) {
      d(b), k();
    } }, C = oh(), R = P(C), U = P(R), F = P(U), se = (b) => {
      var B = In();
      be((G) => mt(B, G), [() => r()(e(p).heading)]), v(b, B);
    };
    j(F, (b) => {
      var B;
      (B = e(p)) != null && B.heading && b(se);
    }), w(U);
    var X = E(U, 2), K = (b) => {
      Qt(b, { element: "span", class: "kaching-bundles__choose-multiple-gifts__close", get onclick() {
        return d();
      }, children: (B, G) => {
        var z = sh();
        be(() => Pe(z, "src", "data:image/svg+xml,%3csvg%20width='12'%20height='12'%20viewBox='0%200%2012%2012'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M11%201L1%2011M1%201L11%2011'%20stroke='%23344054'%20stroke-width='2'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e")), v(B, z);
      }, $$slots: { default: !0 } });
    };
    j(X, (b) => {
      d() && b(K);
    }), w(R);
    var J = E(R, 2);
    Jt(J, 21, s, (b) => b.id, (b, B) => {
      {
        let G = g(() => x(e(B).id)), z = g(() => (function(H) {
          const Y = x(H).length;
          return e(I) - e(y) + Y;
        })(e(B).id));
        Zc(b, { get dealBlock() {
          return c();
        }, get multipleGiftsSelector() {
          return u();
        }, get product() {
          return e(B);
        }, get selectedVariantIds() {
          return e(G);
        }, get availableQuantity() {
          return e(z);
        }, onSelect: () => (function(H) {
          if (e(y) >= e(I)) return;
          const Y = M(H), L = s().length === 1 ? e(I) : 1;
          te(f, { ...e(f), [H.id]: Array(L).fill(Y) }, !0);
        })(e(B)), onRemove: () => (function(H) {
          const { [H]: Y, ...L } = e(f);
          te(f, L, !0);
        })(e(B).id), onVariantChange: (H, Y) => (function(L, O, ae) {
          const ee = x(L);
          if (O >= ee.length) return;
          const le = [...ee];
          le[O] = ae, te(f, { ...e(f), [L]: le }, !0);
        })(e(B).id, H, Y), onQuantityChange: (H) => (function(Y, L) {
          const O = x(Y.id), ae = O.length;
          if (L === ae) return;
          let ee;
          if (L > ae) {
            const le = M(Y), re = L - ae;
            ee = [...O, ...Array(re).fill(le)];
          } else ee = O.slice(0, L);
          te(f, { ...e(f), [Y.id]: ee }, !0);
        })(e(B), H) });
      }
    }), w(J);
    var N = E(J, 2), Z = P(N), $ = P(Z);
    w(Z);
    var S = E(Z, 2), T = P(S);
    T.__click = [ih, d];
    var q = P(T, !0);
    w(T);
    var W = E(T, 2);
    W.__click = [lh, function() {
      const b = [];
      for (const B of s()) {
        const G = x(B.id);
        for (const z of G) {
          const H = B.variants.find((Y) => Y.id === z);
          H && b.push({ id: `${z}`, variant: H, product: B, quantity: 1, fullPrice: H.price });
        }
      }
      return b;
    }, o, u, d];
    var ue = P(W, !0);
    w(W), w(S), w(N), w(C), be((b, B, G) => {
      var z, H;
      Wt(C, e(_)), mt($, `${(z = e(y)) != null ? z : ""}/${(H = e(I)) != null ? H : ""}
      ${b != null ? b : ""}`), mt(q, B), mt(ue, G);
    }, [() => r()(e(A)), () => r()("system.cancel"), () => r()("system.confirm")]), v(n, C);
    var Q = Ye(V);
    return l(), Q;
  }
  Pn(["click"]), We(ks, { dealBlock: {}, multipleGiftsSelector: {}, products: {}, initialSelectedGifts: {}, onConfirm: {}, onClose: {} }, [], [], !0);
  var ch = D('<div class="kaching-bundles"><!></div>');
  function Jc(n, t) {
    Je(t, !0);
    const r = m(t, "config", 7), a = m(t, "dealBlock", 7), l = m(t, "products", 23, () => []), c = m(t, "mediaImages", 7), u = m(t, "translations", 7), s = m(t, "multipleGiftsSelector", 7), { setConfig: i } = xa(r()), { setMoneyFormat: o } = Na(r().moneyFormat), { setTranslations: d } = ya(u()), { setMediaImages: h } = Bi(c()), { setSwatchSettings: f } = Ii({ swatchOptions: a().swatchOptions || [], swatchSize: a().swatchSize, swatchShape: a().swatchShape });
    He(() => {
      i(r());
    }), He(() => {
      o(r().moneyFormat, !!a().showPricesWithoutDecimals);
    }), He(() => {
      d(u());
    }), He(() => {
      h(c());
    }), He(() => {
      f({ swatchOptions: a().swatchOptions || [], swatchSize: a().swatchSize, swatchShape: a().swatchShape });
    });
    var p = { get config() {
      return r();
    }, set config(x) {
      r(x), k();
    }, get dealBlock() {
      return a();
    }, set dealBlock(x) {
      a(x), k();
    }, get products() {
      return l();
    }, set products(x = []) {
      l(x), k();
    }, get mediaImages() {
      return c();
    }, set mediaImages(x) {
      c(x), k();
    }, get translations() {
      return u();
    }, set translations(x) {
      u(x), k();
    }, get multipleGiftsSelector() {
      return s();
    }, set multipleGiftsSelector(x) {
      s(x), k();
    } }, _ = De(), I = ve(_), y = (x) => {
      var M = ch();
      ks(P(M), { get dealBlock() {
        return a();
      }, get products() {
        return l();
      }, get multipleGiftsSelector() {
        return s();
      } }), w(M), v(x, M);
    };
    return j(I, (x) => {
      s() && x(y);
    }), v(n, _), Ye(p);
  }
  function Mi(n, t) {
    var r;
    if (!t) return n.price;
    const a = n.sellingPlans.find((l) => l.id === t.id);
    return (r = a == null ? void 0 : a.price) != null ? r : n.price;
  }
  function Yc(n, t) {
    const r = t.priceAdjustment;
    if (!r) return n;
    switch (r.type) {
      case "percentage":
        return n * (1 - r.value / 100);
      case "fixed_amount":
        return n - r.value;
      case "price":
        return r.value;
    }
  }
  function Di(n, t) {
    return n.sellingPlans.filter((r) => t.some((a) => a.sellingPlans.some((l) => l.id === r.id)));
  }
  function ms(n, t, r) {
    let a;
    if (n.sellingPlanGid) {
      const l = Nt(n.sellingPlanGid);
      a = t.find((c) => c.id === l);
    } else a = r || t[0];
    return a && t.some((l) => l.id === a.id) ? a : t[0];
  }
  function ys(n, t, r, a) {
    return n || (t ? r.some((l) => l.id === t.id) ? t : r[0] : a && r.length > 0 ? r[0] : void 0);
  }
  customElements.define("kaching-bundles-choose-multiple-gifts", We(Jc, { config: { attribute: "config", type: "Object" }, dealBlock: { attribute: "deal-block", type: "Object" }, multipleGiftsSelector: { attribute: "multiple-gifts-selector", type: "Object" }, translations: { attribute: "translations", type: "Object" }, products: { attribute: "products", type: "Array" }, mediaImages: { attribute: "media-images", type: "Array" } }, [], [], !1, (n) => class extends n {
    constructor() {
      super(), fn(this, "component"), this.component = this;
    }
  }));
  const Fn = (n, t, r) => uh(n, t, r) || dh(n, t), uh = (n, t, r) => {
    if (!r || t.sellingPlans.length === 0) return;
    const a = new Set(t.sellingPlans.map((c) => c.id));
    return a.has(r.id) ? n.sellingPlans.find((c) => c.id === r.id) : n.sellingPlans.find((c) => a.has(c.id) && c.name === r.name) || n.sellingPlans.find((c) => c.id === t.sellingPlans[0].id);
  }, dh = (n, t) => {
    if (!n.requiresSellingPlan || t.sellingPlans.length === 0) return;
    const r = t.sellingPlans[0].id;
    return n.sellingPlans.find((a) => a.id === r);
  };
  function Tr({ discountType: n, discountValue: t, discountQuantity: r, variantQuantities: a, currencyRate: l, priceRounding: c, sellingPlan: u, percentageCentsRoundingWorkaround: s }) {
    const i = (function({ discountType: h, discountValue: f, discountQuantity: p, variantQuantities: _, currencyRate: I, sellingPlan: y, percentageCentsRoundingWorkaround: x }) {
      const M = _.map(({ variant: C, quantity: R }) => Mi(C, y) * R), A = M.reduce((C, R) => C + R, 0), V = _.map(({ quantity: C }) => C).reduce((C, R) => C + R, 0);
      if (h === "specific") {
        let C = 100 * Number(f) * I;
        if (V > Number(p)) {
          const F = C / Number(p);
          C = Math.ceil(F * V);
        }
        const R = C / V;
        let U = 0;
        for (const { variant: F, quantity: se } of _) {
          if (y && F.sellingPlans.some((X) => X.id === y.id) && y.priceAdjustment) {
            U += Yc(R, y) * se;
            continue;
          }
          U += R * se;
        }
        return Math.max(0, Math.min(U, A));
      }
      if (h === "percentage") {
        if (x) {
          const R = A * (100 - Number(f)) / 100;
          return Math.max(0, Math.min(Math.ceil(R), A));
        }
        let C = 0;
        for (const { variant: R, quantity: U } of _) {
          const F = Mi(R, y);
          C += Math.ceil(F * (100 - Number(f)) / 100) * U;
        }
        return Math.max(0, Math.min(C, A));
      }
      if (h === "amount") {
        const C = Math.round(100 * Number(f)) * I, R = C * V;
        return typeof document != "undefined" && A > 0 && R > A && document.dispatchEvent(new CustomEvent("kaching-bundles-amount-discount-exceeds-price", { detail: { totalDiscount: R, fullOrderPrice: A } })), Math.max(0, Math.min(A - C * V, A));
      }
      return A;
    })({ discountType: n, discountValue: t, discountQuantity: r, variantQuantities: a, currencyRate: l, sellingPlan: u, percentageCentsRoundingWorkaround: s }), o = a.map(({ variant: h, quantity: f }) => c != null && c.v2 ? Mi(h, u) * f : h.price * f).reduce((h, f) => h + f, 0), d = a.map(({ quantity: h }) => h).reduce((h, f) => h + f, 0);
    if (c && (n !== "default" || c.v2)) {
      if (c.perItem) {
        const h = Wa(i / d, c.precision) * d;
        return c.v2 && Math.round(h) > Math.round(o) && i / d > 100 ? Wa(i / d - 100, c.precision) * d : h <= o ? h : i;
      }
      {
        const h = Wa(i, c.precision);
        return c.v2 && Math.round(h) > Math.round(o) && i > 100 ? Wa(i - 100, c.precision) : h <= o ? h : i;
      }
    }
    return i;
  }
  function Kc(n, t, r, a, l, c) {
    return Tr({ discountType: n.discountType, discountValue: n.discountValue, discountQuantity: n.quantity, variantQuantities: t, currencyRate: r, priceRounding: a, sellingPlan: l, percentageCentsRoundingWorkaround: c });
  }
  function Xc(n, t, r, a, l) {
    var c, u, s, i;
    const o = [...t].sort((y, x) => y.variant.price - x.variant.price), d = o.reduce((y, x) => y + x.quantity, 0) >= n.buyQuantity + n.getQuantity ? n.getQuantity : 0, h = [], f = [];
    let p = d;
    for (const { variant: y, quantity: x } of o) {
      const M = Math.min(x, p), A = x - M;
      p -= M, M > 0 && h.push({ variant: y, quantity: M }), A > 0 && f.push({ variant: y, quantity: A });
    }
    const _ = h.length > 0 ? Tr({ discountType: (c = n.getDiscountType) != null ? c : "percentage", discountValue: (u = n.getDiscountValue) != null ? u : 100, discountQuantity: d, variantQuantities: h, currencyRate: r, priceRounding: a, sellingPlan: l }) : 0, I = f.reduce((y, x) => y + x.quantity, 0);
    return _ + Tr({ discountType: (s = n.buyDiscountType) != null ? s : "default", discountValue: (i = n.buyDiscountValue) != null ? i : 0, discountQuantity: I, variantQuantities: f, currencyRate: r, priceRounding: a, sellingPlan: l });
  }
  function xs(n, t, r, a, l) {
    return n.bundleProducts.filter(({ productGID: c }) => c).map((c) => {
      const u = t[c.id];
      if (!u) return 0;
      const s = Fn(u.product, u.variant, l);
      return Tr({ discountType: c.discountType, discountValue: c.discountValue, discountQuantity: c.quantity, variantQuantities: [u], currencyRate: r, priceRounding: a, sellingPlan: s });
    }).reduce((c, u) => c + u, 0);
  }
  function ws(n, t, r, a, l) {
    const c = n.bundleProducts.filter(({ productGID: i }) => i).reduce((i, o) => {
      const d = t[o.id];
      if (!d) return i;
      const h = Fn(d.product, d.variant, l);
      return i + (h ? Yc(d.variant.price, h) : d.variant.price);
    }, 0), u = Number(n.discountValue) || 0;
    let s;
    switch (n.discountType) {
      case "percentage":
        s = c * (1 - Math.min(Math.max(u, 0), 100) / 100);
        break;
      case "amount":
        s = c - Math.round(100 * u) * r;
        break;
      case "specific":
        s = Math.round(100 * u) * r;
        break;
      default:
        s = c;
    }
    if (s = Math.max(0, Math.min(s, c)), a && (n.discountType !== "default" || a.v2)) {
      const i = s;
      let o = Wa(i, a.precision);
      a.v2 && Math.round(o) > Math.round(c) && i > 100 && (o = Wa(i - 100, a.precision)), s = o <= c ? o : i;
    }
    return Math.max(0, Math.round(s));
  }
  function Wa(n, t = ".00") {
    switch (t) {
      case ".99":
        return n > 99 ? 100 * Math.ceil(n / 100) - 1 : n;
      case ".95":
        return n > 95 ? 100 * Math.ceil(n / 100) - 5 : n;
      case ".90":
        return n > 90 ? 100 * Math.ceil(n / 100) - 10 : n;
      case ".x9":
        return n > 9 ? 10 * Math.ceil(n / 10) - 1 : n;
      case ".x0":
        return 10 * Math.ceil(n / 10);
      default:
        return 100 * Math.ceil(n / 100);
    }
  }
  var gh = D('<img class="kaching-bundles__choose-product__product-image" alt=""/>'), hh = D('<span class="kaching-bundles__choose-product__product-title"> </span>'), ph = D('<span class="kaching-bundles__choose-product__subtitle"><!></span>'), fh = D('<div class="kaching-bundles__choose-product__product-price"><!></div>'), bh = D('<div class="kaching-bundles__choose-product__product-compare-at-price"><!></div>'), vh = D("<div><!> <!></div>"), _h = D('<div class="kaching-bundles__choose-product__product"><div class="kaching-bundles__choose-product__product-container"><!> <div class="kaching-bundles__choose-product__product-content"><!> <!> <div class="kaching-bundles__choose-product__product-price-container"><!> <!></div> <!></div></div> <!></div>');
  function eu(n, t) {
    var r;
    Je(t, !0);
    const a = () => Me(_, "$config", u), l = () => Me(p, "$formatPrice", u), c = () => Me(f, "$translate", u), [u, s] = wt(), i = m(t, "product", 7), o = m(t, "dealBlock", 7), d = m(t, "dealBar", 7), h = m(t, "onChoose", 7), f = qt(), p = cn(), _ = on();
    let I = Ae(!1), y = Ae(rt(((r = i().variants.find((L) => L.availableForSale)) == null ? void 0 : r.id) || i().variants[0].id));
    const x = g(() => i().variants.find((L) => L.id === e(y)) || i().variants[0]), M = g(() => {
      var L;
      return e(I) || ((L = o().chooseProductModal) == null ? void 0 : L.showVariantImageByDefault);
    }), A = g(() => e(M) && e(x).image || i().image), V = g(() => o().priceRounding ? { perItem: !0, precision: o().priceRoundingPrecision, v2: a().featureFlags.price_rounding_v2 || !1 } : void 0), C = g(() => d().dealBarType === "bxgy" ? e(x).price : Tr({ discountType: d().discountType, discountValue: d().discountValue, discountQuantity: 1, variantQuantities: [{ variant: e(x), quantity: 1 }], currencyRate: a().currencyRate, priceRounding: e(V) })), R = g(() => (function(L, O) {
      return L.useProductCompareAtPrice && O.compareAtPrice ? Math.max(O.price, O.compareAtPrice) : O.price;
    })(o(), e(x))), U = g(() => i().url ? `${i().url}?variant=${e(y)}` : void 0), F = g(() => pn({ priceFormatter: l(), product: i(), totalFullPrice: e(R), totalDiscountedPrice: e(C), quantity: 1, unitQuantity: er([{ variant: e(x), quantity: 1 }]) })), se = g(() => e(F)(c()(o().chooseProductModal.subtitle || ""))), X = g(() => o().chooseProductModal.buttonText);
    function K(L) {
      te(I, !0), te(y, L, !0);
    }
    var J = { get product() {
      return i();
    }, set product(L) {
      i(L), k();
    }, get dealBlock() {
      return o();
    }, set dealBlock(L) {
      o(L), k();
    }, get dealBar() {
      return d();
    }, set dealBar(L) {
      d(L), k();
    }, get onChoose() {
      return h();
    }, set onChoose(L) {
      h(L), k();
    } }, N = _h(), Z = P(N), $ = P(Z), S = (L) => {
      Vn(L, { get url() {
        return e(U);
      }, class: "kaching-bundles__choose-product__product-image-link", children: (O, ae) => {
        var ee = gh();
        Pe(ee, "width", 100), Pe(ee, "height", 100), be(() => Pe(ee, "src", e(A))), v(O, ee);
      }, $$slots: { default: !0 } });
    };
    j($, (L) => {
      e(A) && L(S);
    });
    var T = E($, 2), q = P(T);
    Vn(q, { get url() {
      return e(U);
    }, class: "kaching-bundles__choose-product__product-link", children: (L, O) => {
      var ae = hh(), ee = P(ae, !0);
      w(ae), be(() => mt(ee, i().title)), v(L, ae);
    }, $$slots: { default: !0 } });
    var W = E(q, 2), ue = (L) => {
      var O = ph();
      qe(P(O), () => e(se)), w(O), v(L, O);
    };
    j(W, (L) => {
      e(se) && L(ue);
    });
    var Q = E(W, 2), b = P(Q);
    Ke(b, () => e(C), (L) => {
      var O = fh();
      qe(P(O), () => l()(e(C))), w(O), v(L, O);
    });
    var B = E(b, 2), G = (L) => {
      var O = De();
      Ke(ve(O), () => e(R), (ae) => {
        var ee = bh();
        qe(P(ee), () => l()(e(R))), w(ee), v(ae, ee);
      }), v(L, O);
    };
    j(B, (L) => {
      e(R) && e(R) > e(C) && L(G);
    }), w(Q);
    var z = E(Q, 2), H = (L) => {
      var O = vh(), ae = P(O);
      Vr(ae, { get product() {
        return i();
      }, class: "kaching-bundles__choose-product__product-option-names" }), Mn(E(ae, 2), { get product() {
        return i();
      }, get selectedVariantId() {
        return e(y);
      }, onChange: K }), w(O), v(L, O);
    };
    j(z, (L) => {
      i().variants.length > 1 && L(H);
    }), w(T), w(Z), Qt(E(Z, 2), { element: "span", class: "kaching-bundles__choose-product__product-button", onclick: function() {
      h()({ product: i(), variant: e(x) });
    }, children: (L, O) => {
      var ae = De(), ee = ve(ae), le = (fe) => {
        var ze = In();
        be((ce) => mt(ze, ce), [() => c()(e(X))]), v(fe, ze);
      }, re = (fe) => {
        v(fe, In("Choose"));
      };
      j(ee, (fe) => {
        e(X) ? fe(le) : fe(re, !1);
      }), v(L, ae);
    }, $$slots: { default: !0 } }), w(N), v(n, N);
    var Y = Ye(J);
    return s(), Y;
  }
  We(eu, { product: {}, dealBlock: {}, dealBar: {}, onChoose: {} }, [], [], !0);
  const Ps = "data:image/svg+xml,%3csvg%20width='12'%20height='12'%20viewBox='0%200%2012%2012'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M11%201L1%2011M1%201L11%2011'%20stroke='%23344054'%20stroke-width='2'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e";
  var kh = D('<img alt="Close"/>'), mh = (n, t) => {
    te(t, !e(t));
  }, yh = (n, t, r, a) => {
    te(t, e(r).value, !0), te(a, !1);
  }, xh = D('<img alt="" aria-hidden="true" class="kaching-bundles__choose-product__sort-option-check"/>'), wh = D('<button type="button" class="kaching-bundles__choose-product__sort-option"><span> </span> <!></button>'), Ph = D('<div class="kaching-bundles__choose-product__sort-menu"></div>'), Sh = D('<div class="kaching-bundles__choose-product__controls"><div class="kaching-bundles__choose-product__search-field"><img alt="" aria-hidden="true" class="kaching-bundles__choose-product__search-icon"/> <input type="search" class="kaching-bundles__choose-product__search-input"/></div> <div class="kaching-bundles__choose-product__sort"><button type="button" class="kaching-bundles__choose-product__sort-button"><img alt="" aria-hidden="true" class="kaching-bundles__choose-product__sort-icon"/> </button> <!></div></div>'), Ch = (n, t) => {
    te(t, "");
  }, Bh = D('<div class="kaching-bundles__choose-product__empty-state-icon-wrapper"><img alt="" aria-hidden="true" class="kaching-bundles__choose-product__empty-state-icon"/></div> <h3 class="kaching-bundles__choose-product__empty-state-title"> </h3> <p class="kaching-bundles__choose-product__empty-state-description"> </p> <button type="button" class="kaching-bundles__choose-product__empty-state-clear-button"> </button>', 1), Ih = D('<div class="kaching-bundles__choose-product__empty-state"><!></div>'), Mh = D('<div class="kaching-bundles__choose-product"><div class="kaching-bundles__choose-product__header"><h2 class="kaching-bundles__choose-product__heading"><!></h2> <!></div> <!> <div class="kaching-bundles__choose-product__products"><!></div></div>');
  function Ss(n, t) {
    var r;
    Je(t, !0);
    const a = () => Me(h, "$translate", l), [l, c] = wt(), u = m(t, "dealBlock", 7), s = m(t, "dealBar", 7), i = m(t, "products", 23, () => []), o = m(t, "onChoose", 7), d = m(t, "onClose", 7), h = qt(), f = g(() => u().chooseProductModal), p = g(() => ((Q) => hn({ "kaching-choose-product-button-size": Q.buttonSize + "px", "kaching-choose-product-text-size": Q.textSize + "px", "kaching-choose-product-price-color": Re(Q.priceColor), "kaching-choose-product-compare-at-price-color": Re(Q.compareAtPriceColor), "kaching-choose-product-text-color": Re(Q.textColor), "kaching-choose-product-button-color": Re(Q.buttonColor), "kaching-choose-product-button-text-color": Re(Q.buttonTextColor), "kaching-choose-product-photo-size": Q.productPhotoSize + "px" }))(e(f)));
    let _ = Ae(""), I = Ae(!1);
    const y = { Relevance: "relevance", NewestFirst: "newest-first", PriceLowToHigh: "price-low-to-high", PriceHighToLow: "price-high-to-low" }, x = g(() => [{ value: y.Relevance, label: a()("system.sort_relevance") }, { value: y.NewestFirst, label: a()("system.sort_newest_first") }, { value: y.PriceLowToHigh, label: a()("system.sort_price_low_to_high") }, { value: y.PriceHighToLow, label: a()("system.sort_price_high_to_low") }]);
    let M = Ae(rt(Object.values(y).includes((r = e(f).defaultSortOption) != null ? r : "") ? e(f).defaultSortOption : y.Relevance));
    const A = g(() => e(f).showSearchField ? i().filter((Q) => Q.title.toLowerCase().includes(e(_).toLowerCase().trim())) : i()), V = g(() => {
      const Q = [...e(A)], b = (G) => {
        const z = G.variants.find((H) => H.availableForSale) || G.variants[0];
        return (z == null ? void 0 : z.price) || 0;
      }, B = (G) => {
        if (!G.createdAt) return 0;
        const z = Date.parse(G.createdAt);
        return Number.isNaN(z) ? 0 : z;
      };
      switch (e(M)) {
        case y.Relevance:
          return Q;
        case y.NewestFirst:
          return Q.sort((G, z) => {
            const H = B(z) - B(G);
            return H !== 0 ? H : z.id - G.id;
          });
        case y.PriceLowToHigh:
          return Q.sort((G, z) => b(G) - b(z));
        case y.PriceHighToLow:
          return Q.sort((G, z) => b(z) - b(G));
        default:
          return Q;
      }
    }), C = g(() => e(f).showSearchField && e(_).trim().length > 0 && e(V).length === 0);
    function R() {
      te(I, !1);
    }
    function U(Q, b) {
      const B = (G) => {
        Q.contains(G.target) || b();
      };
      return document.addEventListener("click", B, !0), { destroy() {
        document.removeEventListener("click", B, !0);
      } };
    }
    var F = { get dealBlock() {
      return u();
    }, set dealBlock(Q) {
      u(Q), k();
    }, get dealBar() {
      return s();
    }, set dealBar(Q) {
      s(Q), k();
    }, get products() {
      return i();
    }, set products(Q = []) {
      i(Q), k();
    }, get onChoose() {
      return o();
    }, set onChoose(Q) {
      o(Q), k();
    }, get onClose() {
      return d();
    }, set onClose(Q) {
      d(Q), k();
    } }, se = Mh(), X = P(se), K = P(X), J = P(K), N = (Q) => {
      var b = In();
      be((B) => mt(b, B), [() => a()(e(f).heading)]), v(Q, b);
    };
    j(J, (Q) => {
      e(f).heading && Q(N);
    }), w(K), Qt(E(K, 2), { element: "span", class: "kaching-bundles__choose-product__close", get onclick() {
      return d();
    }, children: (Q, b) => {
      var B = kh();
      be(() => Pe(B, "src", Ps)), v(Q, B);
    }, $$slots: { default: !0 } }), w(X);
    var Z = E(X, 2), $ = (Q) => {
      var b = Sh(), B = P(b), G = P(B), z = E(G, 2);
      qr(z), w(B);
      var H = E(B, 2), Y = P(H);
      Y.__click = [mh, I];
      var L = P(Y), O = E(L);
      w(Y);
      var ae = E(Y, 2), ee = (le) => {
        var re = Ph();
        Jt(re, 21, () => e(x), (fe) => fe.value, (fe, ze) => {
          var ce = wh();
          ce.__click = [yh, M, ze, I];
          var ie = P(ce), ke = P(ie, !0);
          w(ie);
          var we = E(ie, 2), _e = (ye) => {
            var Se = xh();
            be(() => Pe(Se, "src", "data:image/svg+xml,%3csvg%20width='20'%20height='20'%20viewBox='0%200%2020%2020'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M16.6663%205L7.49967%2014.1667L3.33301%2010'%20stroke='%23344054'%20stroke-width='1.66667'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e")), v(ye, Se);
          };
          j(we, (ye) => {
            e(M) === e(ze).value && ye(_e);
          }), w(ce), be(() => mt(ke, e(ze).label)), v(fe, ce);
        }), w(re), v(le, re);
      };
      j(ae, (le) => {
        e(I) && le(ee);
      }), w(H), as(H, (le, re) => U == null ? void 0 : U(le, re), () => R), w(b), be((le, re, fe) => {
        Pe(G, "src", "data:image/svg+xml,%3csvg%20width='20'%20height='20'%20viewBox='0%200%2020%2020'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M17.5%2017.5L13.875%2013.875M15.8333%209.16667C15.8333%2012.8486%2012.8486%2015.8333%209.16667%2015.8333C5.48477%2015.8333%202.5%2012.8486%202.5%209.16667C2.5%205.48477%205.48477%202.5%209.16667%202.5C12.8486%202.5%2015.8333%205.48477%2015.8333%209.16667Z'%20stroke='%23717680'%20stroke-width='1.66667'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e"), Pe(z, "aria-label", le), Pe(z, "placeholder", re), Pe(L, "src", "data:image/svg+xml,%3csvg%20width='20'%20height='20'%20viewBox='0%200%2020%2020'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M14.1667%203.33337V16.6667M14.1667%2016.6667L10.8333%2013.3334M14.1667%2016.6667L17.5%2013.3334M5.83333%2016.6667V3.33337M5.83333%203.33337L2.5%206.66671M5.83333%203.33337L9.16667%206.66671'%20stroke='%23414651'%20stroke-width='1.67'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e"), mt(O, ` ${fe != null ? fe : ""}`);
      }, [() => a()("system.search"), () => a()("system.search"), () => a()("system.sort_by")]), jd(z, () => e(_), (le) => te(_, le)), v(Q, b);
    };
    j(Z, (Q) => {
      e(f).showSearchField && Q($);
    });
    var S = E(Z, 2), T = P(S), q = (Q) => {
      var b = Ih(), B = P(b), G = (H) => {
        var Y = Bh(), L = ve(Y), O = P(L);
        w(L);
        var ae = E(L, 2), ee = P(ae, !0);
        w(ae);
        var le = E(ae, 2), re = P(le, !0);
        w(le);
        var fe = E(le, 2);
        fe.__click = [Ch, _];
        var ze = P(fe, !0);
        w(fe), be((ce, ie, ke) => {
          Pe(O, "src", "data:image/svg+xml,%3csvg%20width='56'%20height='56'%20viewBox='0%200%2056%2056'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3crect%20x='4'%20y='4'%20width='48'%20height='48'%20rx='24'%20fill='%23F2F4F7'/%3e%3crect%20x='4'%20y='4'%20width='48'%20height='48'%20rx='24'%20stroke='%23F9FAFB'%20stroke-width='8'/%3e%3cpath%20d='M37%2037L32.65%2032.65M35%2027C35%2031.4183%2031.4183%2035%2027%2035C22.5817%2035%2019%2031.4183%2019%2027C19%2022.5817%2022.5817%2019%2027%2019C31.4183%2019%2035%2022.5817%2035%2027Z'%20stroke='%23475467'%20stroke-width='1.66667'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e"), mt(ee, ce), mt(re, ie), mt(ze, ke);
        }, [() => a()("system.no_results_found"), () => a()("system.no_results_description"), () => a()("system.clear_search")]), v(H, Y);
      }, z = (H) => {
        var Y = In();
        be((L) => mt(Y, L), [() => a()("system.no_products_available")]), v(H, Y);
      };
      j(B, (H) => {
        e(C) ? H(G) : H(z, !1);
      }), w(b), v(Q, b);
    }, W = (Q) => {
      var b = De();
      Jt(ve(b), 17, () => e(V), (B) => B.id, (B, G) => {
        eu(B, { get dealBlock() {
          return u();
        }, get dealBar() {
          return s();
        }, get product() {
          return e(G);
        }, get onChoose() {
          return o();
        } });
      }), v(Q, b);
    };
    j(T, (Q) => {
      e(V).length === 0 ? Q(q) : Q(W, !1);
    }), w(S), w(se), be(() => Wt(se, e(p))), v(n, se);
    var ue = Ye(F);
    return c(), ue;
  }
  Pn(["click"]), We(Ss, { dealBlock: {}, dealBar: {}, products: {}, onChoose: {}, onClose: {} }, [], [], !0);
  var Dh = D('<div class="kaching-bundles"><!></div>');
  function tu(n, t) {
    Je(t, !0);
    const r = m(t, "config", 7), a = m(t, "dealBlock", 7), l = m(t, "dealBar", 7), c = m(t, "products", 23, () => []), u = m(t, "mediaImages", 7), s = m(t, "translations", 7), { setConfig: i } = xa(r()), { setMoneyFormat: o } = Na(r().moneyFormat), { setTranslations: d } = ya(s()), { setMediaImages: h } = Bi(u()), { setSwatchSettings: f } = Ii({ swatchOptions: a().swatchOptions || [], swatchSize: a().swatchSize, swatchShape: a().swatchShape });
    He(() => {
      i(r());
    }), He(() => {
      o(r().moneyFormat, !!a().showPricesWithoutDecimals);
    }), He(() => {
      d(s());
    }), He(() => {
      h(u());
    }), He(() => {
      f({ swatchOptions: a().swatchOptions || [], swatchSize: a().swatchSize, swatchShape: a().swatchShape });
    });
    var p = { get config() {
      return r();
    }, set config(I) {
      r(I), k();
    }, get dealBlock() {
      return a();
    }, set dealBlock(I) {
      a(I), k();
    }, get dealBar() {
      return l();
    }, set dealBar(I) {
      l(I), k();
    }, get products() {
      return c();
    }, set products(I = []) {
      c(I), k();
    }, get mediaImages() {
      return u();
    }, set mediaImages(I) {
      u(I), k();
    }, get translations() {
      return s();
    }, set translations(I) {
      s(I), k();
    } }, _ = Dh();
    return Ss(P(_), { get dealBlock() {
      return a();
    }, get dealBar() {
      return l();
    }, get products() {
      return c();
    }, onChoose: () => {
    }, onClose: () => {
    } }), w(_), v(n, _), Ye(p);
  }
  customElements.define("kaching-bundles-choose-product", We(tu, { config: { attribute: "config", type: "Object" }, dealBlock: { attribute: "deal-block", type: "Object" }, dealBar: { attribute: "deal-bar", type: "Object" }, translations: { attribute: "translations", type: "Object" }, products: { attribute: "products", type: "Array" }, mediaImages: { attribute: "media-images", type: "Array" } }, [], [], !1, (n) => class extends n {
    constructor() {
      super(), fn(this, "component"), this.component = this;
    }
  })), za = !0;
  var zh = $n('<svg width="102" height="60" viewBox="0 0 102 60" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="47.9" cy="23.5" rx="47.9" ry="23.5" transform="matrix(.9929 .11897 -.14278 .98975 6.7 2)" fill="currentColor"></ellipse><ellipse cx="47.9" cy="23.5" rx="47.9" ry="23.5" transform="matrix(.9929 .11897 -.14278 .98975 6.7 2)" fill="#000" fill-opacity=".3"></ellipse><mask id="a" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="3" y="5" width="96" height="48"><ellipse cx="47.9" cy="23.5" rx="47.9" ry="23.5" transform="matrix(.9929 .11897 -.14278 .98975 6.7 0)" fill="currentColor"></ellipse></mask><g mask="url(#a)"><ellipse cx="47.9" cy="23.5" rx="47.9" ry="23.5" transform="matrix(.9929 .11897 -.14278 .98975 6.7 0)" fill="currentColor"></ellipse></g><path class="most-popular-text" d="M28 15.4 25.4 24a.3.3 0 0 1 0 .1.2.2 0 0 1-.2.1c-.4.1-.7 0-.8-.4a1007.3 1007.3 0 0 1-3.9-9.2l-.8 7.6a.5.5 0 0 0 0 .2l.6.8a.7.7 0 0 1 0 .1.2.2 0 0 1 0 .1c0 .5-1.7.1-2 0-1 0 .1-1 .2-1.4l1.1-9c0-.4-.1-.7-.5-1a.4.4 0 0 1-.1-.2v-.2a.2.2 0 0 1 .1 0 15.2 15.2 0 0 1 3.1.2h.1c.1 0 0 0 0 .1.3.5-.5.7-.3 1.2a1361.6 1361.6 0 0 1 3.2 8.1l2.3-7.3a.7.7 0 0 0-.1-.6c-.3-.4-1-1 .1-1l2.7.4c.2 0 .3.2.2.4a.4.4 0 0 1-.1.2c-.3.3-.5.5-.4 1a771.7 771.7 0 0 0 2.5 10c.5.5.7 1-.3.8l-2.2-.3c-.5 0-.5-.4-.1-1a.7.7 0 0 0 .1-.6l-1.6-7.6c0-.2-.1-.2-.1 0zm24 4.7.1 4.5c0 1 .6 1.5 1.6 1.5.3 0 .5-.2.6-.5.1-.4.3-.5.5-.3h.1v.1c.1 1.1-.4 2-1.5 2-2.3.4-3.2-1.2-3.3-3.3l-.2-4.1c0-.4-.2-.5-.6-.5-.5 0-.8-.1-.7-.7a.2.2 0 0 1 .2-.1c1.3.2 2-.3 2-1.6a.2.2 0 0 1 .2-.1c1.1-.5.9 1.3.9 1.9a.1.1 0 0 0 .1.1l2.2.3.2.1c.1.3.1.5-.1.7a.2.2 0 0 1-.1 0 .4.4 0 0 1-.1 0l-2-.1a.1.1 0 0 0-.1 0zm-11.6 4.6c-.7.8-1.8 1.2-3 1.1-1.1 0-2.3-.5-3.3-1.4A5.7 5.7 0 0 1 33 23a5 5 0 0 1-.6-1.7 4 4 0 0 1 .1-1.7c.1-.5.4-1 .8-1.4.7-.7 1.7-1.2 2.9-1.1 1.2 0 2.4.6 3.3 1.4.5.4.9 1 1.2 1.5.3.5.5 1.1.5 1.7a4 4 0 0 1 0 1.6c-.2.6-.5 1-.8 1.4zm-2.4.4c.3 0 .5-.3.7-.5l.5-1v-1.4a6.4 6.4 0 0 0-.3-1.4 6.4 6.4 0 0 0-.6-1.4 4.7 4.7 0 0 0-.8-1 2.6 2.6 0 0 0-1-.6 1.5 1.5 0 0 0-.9 0c-.3 0-.5.3-.7.5l-.4 1a4.7 4.7 0 0 0 0 1.4 6.4 6.4 0 0 0 1.7 3.8c.3.3.6.5 1 .6.2 0 .5.1.8 0zm8-6c-1-.8-2.4-.4-2.3 1 0 .4.3.8.7 1l3 1.2c1.1.5 2.2 2.5 1.1 3.6-1.6 1.8-5.6.6-6.8-1.3-.2-.4-.1-.8.4-1 1.2-.5 1.5 1.5 2.3 2 1 .8 3 .6 2.4-1.1-.3-1-3.2-1.8-3.8-2.2-1.9-1.2-1.8-4 .8-4.3 1.6-.1 4.5.6 4.7 2.6a.3.3 0 0 1 0 .3c-1.1 1.3-1.9-1.3-2.5-1.8zM28.3 34.9c0 1.4 0 2 .8 3 .2.2.2.4 0 .6a.3.3 0 0 1-.2 0l-3.8-.3a.4.4 0 0 1-.3 0c-.3-.4-.3-.7 0-1a1 1 0 0 0 .4-.8L25 28c0-.4-.3-.9-.8-1.4a.3.3 0 0 1 0-.1.2.2 0 0 1 0-.1c0-.3.2-.4.6-.3 3.4.2 9.4.1 9.7 4.8.3 3.8-3 4.1-6 3.9zm-.2-6.7c0 1.4 0 3 .2 4.6 0 .3.2.5.5.6 3.4 1 2.5-3.2 1.6-4.6-.3-.5-.8-.9-1.5-1.1-.5-.2-.8 0-.8.5zM59.5 41c-1.7 1.3-4.3.4-5.2-1.4-1-1.8 0-4.1-1.3-5.8a.4.4 0 0 1 0-.2c0-.6.4-.5.8-.5a19.9 19.9 0 0 1 2.5 0 .4.4 0 0 1 .4.3l.2 5.3c0 .8.3 1.8 1.1 1.8 1.7.2 1-4.2 1-5.3a.5.5 0 0 0-.2-.2l-.5-.8c-.3-.3-.2-.5.3-.6h2.9c.3 0 .4 0 .4.4l.3 6c0 1.6 1.4 1.6 1.3-.2l-.3-7c0-.8-.3-1.2-.8-1.8a.3.3 0 0 1 0-.2.3.3 0 0 1 0-.2.3.3 0 0 1 .2 0l2.8-1.2c.5-.2.8 0 .8.6l.5 10.4c0 .5.2.8.6 1.2.3.4.4 1-.4.8-.9 0-3.1 0-3.9-.4a.4.4 0 0 0-.2 0c-.9 0-2.7.1-3.1-1a.1.1 0 0 0-.2 0zm-16.4-3c-.5 1-1.5 1.6-2.7 1.8-1.2.2-2.5 0-3.6-.7a5.7 5.7 0 0 1-1.5-1.2 5 5 0 0 1-.9-1.6 4.2 4.2 0 0 1-.2-1.7 3.5 3.5 0 0 1 .5-1.6c.5-.9 1.5-1.5 2.7-1.7 1.2-.2 2.5 0 3.6.7a5.7 5.7 0 0 1 1.4 1.2c.5.5.8 1 1 1.6.2.5.2 1.1.2 1.7a3.5 3.5 0 0 1-.5 1.5zm-3.3 1c.2 0 .3-.1.4-.4l.3-.8v-1.3a8.8 8.8 0 0 0-.3-1.3 8.8 8.8 0 0 0-.5-1.3 5.9 5.9 0 0 0-.6-1.1l-.6-.6c-.2-.2-.4-.2-.6-.2-.2 0-.3.2-.4.4l-.3 1v1.1a8.8 8.8 0 0 0 1.4 3.8l.6.6c.2.1.4.2.6.1z" fill="#FEFDFD"></path><path class="most-popular-text" d="M46.9 32.7a3 3 0 0 1 2.8-.3c2.5.8 3.6 2.5 3.5 5-.2 2.9-3.2 4.2-5.5 2.9-.2-.1-.2 0-.2 0 .1 1-.2 2.2.7 3 .3.2.4.5.1.7a.3.3 0 0 1-.2.1 401 401 0 0 0-3.5-.3c-.4 0-.6-.3-.7-.6a.3.3 0 0 1 0-.1.5.5 0 0 1 .1-.1l.5-.7a.4.4 0 0 0 0-.2l-.2-7.3c0-.6-1.1-.9-.9-1.6a.3.3 0 0 1 .2-.2l2.6-1a.2.2 0 0 1 .2 0c.2.1.4.4.4.7zM49 40c2.2 0 .5-5.5-.1-6.4-.7-.8-1.5-.7-1.7.4v3.4c.2.9.6 2.6 1.8 2.6zm24.5 2.7c-2.7 1.4-5.7-1-6.1-3.7-.7-3.5 2.8-5.8 5.8-3.8a.1.1 0 0 0 .1 0c.3-.7 2.3 0 2.9.2.4 0 .6.3.5.7a.3.3 0 0 1 0 .1.3.3 0 0 1-.1 0c-.4.4-.6.8-.6 1.2 0 2.3.2 3.7.2 4.2s1 1.2.7 1.7a.2.2 0 0 1-.1 0 .3.3 0 0 1-.2.1l-2.6-.3a.3.3 0 0 1-.2 0l-.2-.4a.1.1 0 0 0-.1 0zm-.4-5.2c-.2-1.8-2.7-3.4-2.8-.7-.1 1.5.3 4.6 1.9 5.5a.4.4 0 0 0 .2 0c1.4-.3.8-3.5.7-4.8zM80.5 36.5c.3-.3.5-.7 1-.9 3.8-1.6 3.6 4.9.9 2.9-.5-.4-.5-1.7-1.2-1.5a.3.3 0 0 0-.1 0 .3.3 0 0 0 0 .2c-.4.7-.4 4.6.1 5.2.2.3 1.5 1.2.2 1.2a52 52 0 0 1-3.5-.3c-.3 0-.5-.2-.5-.5a.4.4 0 0 1 0-.2c.4-.4.6-.7.6-1.2l-.2-3.5a.4.4 0 0 0 0-.2l-.9-1c-.2-.2 0-.4.3-.6l2.6-1c.3 0 .5 0 .5.4v1h.2z" fill="#FEFDFD"></path><path class="most-popular-text" fill-rule="evenodd" clip-rule="evenodd" d="m82.2 24.2-.7-6.2-.7 6.2-2.7-2.1 2 2.7-6.1.7 6.2.7L78 29l2.8-2.1.7 6.1.7-6.1L85 29l-2.2-2.8 6.2-.7-6.1-.7 2-2.7-2.7 2.1z" fill="#fff"></path><path class="most-popular-text" d="M45 4v1a2 2 0 0 0 2 2h1-1a2 2 0 0 0-2 2v1-1a2 2 0 0 0-2-2h-1 1a2 2 0 0 0 2-2V4zm12 41v1a2 2 0 0 0 2 2h1-1a2 2 0 0 0-2 2v1-1a2 2 0 0 0-2-2h-1 1a2 2 0 0 0 2-2v-1zM13 22v3a4 4 0 0 0 4 4h3-3a4 4 0 0 0-4 4v3-3a4 4 0 0 0-4-4H6h3a4 4 0 0 0 4-4v-3zM67 4v3a4 4 0 0 0 4 4h3-3a4 4 0 0 0-4 4v3-3a4 4 0 0 0-4-4h-3 3a4 4 0 0 0 4-4V4z" fill="#fff"></path></svg>');
  function nu(n) {
    v(n, zh());
  }
  We(nu, {}, [], [], !0);
  var Ah = D('<div class="kaching-bundles__bar-most-popular kaching-bundles__bar-most-popular--custom"><img class="kaching-bundles__bar-most-popular__custom-image"/></div>'), $h = D('<div class="kaching-bundles__bar-most-popular kaching-bundles__bar-most-popular--fancy"><!></div>'), qh = D('<div class="kaching-bundles__bar-most-popular__content"><!></div>'), Vh = D('<div class="kaching-bundles__bar-most-popular kaching-bundles__bar-most-popular--simple"><!></div>');
  function wa(n, t) {
    Je(t, !0);
    const r = m(t, "style", 7, "simple"), a = m(t, "text", 7, ""), l = m(t, "imageUrl", 7), c = m(t, "blockLayout", 7), u = g(() => c() === "vertical" && (r() === "most-popular" || r() === "simple" && !!a() || r() === "custom" && !!l()));
    var s = { get style() {
      return r();
    }, set style(h = "simple") {
      r(h), k();
    }, get text() {
      return a();
    }, set text(h = "") {
      a(h), k();
    }, get imageUrl() {
      return l();
    }, set imageUrl(h) {
      l(h), k();
    }, get blockLayout() {
      return c();
    }, set blockLayout(h) {
      c(h), k();
    } }, i = De(), o = ve(i), d = (h) => {
      var f = De(), p = ve(f), _ = (y) => {
        var x = Ah(), M = P(x);
        w(x), be(() => {
          Pe(M, "alt", a() || "Badge"), Pe(M, "src", l());
        }), v(y, x);
      }, I = (y) => {
        var x = De(), M = ve(x), A = (C) => {
          var R = $h();
          nu(P(R)), w(R), v(C, R);
        }, V = (C) => {
          var R = Vh();
          Ke(P(R), a, (U) => {
            var F = qh();
            qe(P(F), a), w(F), v(U, F);
          }), w(R), v(C, R);
        };
        j(M, (C) => {
          r() === "most-popular" ? C(A) : C(V, !1);
        }, !0), v(y, x);
      };
      j(p, (y) => {
        r() === "custom" && l() ? y(_) : y(I, !1);
      }), v(h, f);
    };
    return j(o, (h) => {
      e(u) && h(d);
    }), v(n, i), Ye(s);
  }
  We(wa, { style: {}, text: {}, imageUrl: {}, blockLayout: {} }, [], [], !0);
  const zi = "data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20100%20100'%3e%3crect%20width='100'%20height='100'%20fill='transparent'%20/%3e%3c/svg%3e", ru = ({ dealBlock: n, imageSize: t }) => {
    const { fonts: r, colors: a, cornerRadius: l } = n;
    return hn({ "kaching-free-gift-background-color": a.freeGiftBackground && Re(a.freeGiftBackground), "kaching-free-gift-text-color": a.freeGiftText && Re(a.freeGiftText), "kaching-free-gift-selected-background-color": a.freeGiftSelectedBackground && Re(a.freeGiftSelectedBackground), "kaching-free-gift-selected-text-color": a.freeGiftSelectedText && Re(a.freeGiftSelectedText), "kaching-free-gift-font-size": r.freeGift && r.freeGift.size + "px", "kaching-free-gift-font-weight": r.freeGift && Yn(r.freeGift.style), "kaching-free-gift-font-style": r.freeGift && Kn(r.freeGift.style), "kaching-free-gift-image-border-radius": (l || 0) / 2 + "px", "kaching-free-gift-image-height": t + "px" });
  };
  var Th = D('<img alt="" class="kaching-bundles__free-gift__image"/>'), Gh = D('<div class="kaching-bundles__free-gift__image"></div>'), Oh = D('<span class="kaching-bundles__free-gift__text"><!></span>'), Fh = D('<div class="kaching-bundles__free-gift__full-price"><!></div>'), Lh = D('<div><div class="kaching-bundles__free-gift__main"><!> <div class="kaching-bundles__free-gift__content"><!> <!></div></div> <!></div>');
  function au(n, t) {
    Je(t, !0);
    const r = () => Me(p, "$config", l), a = () => Me(I, "$formatPrice", l), [l, c] = wt();
    let u = m(t, "dealBlock", 7), s = m(t, "freeGift", 7), i = m(t, "product", 7), o = m(t, "dealBarSelected", 7, !1), d = m(t, "sets", 7), h = m(t, "mainProductVariantId", 7), f = m(t, "onChange", 7);
    const p = on(), _ = qt(), I = cn(), y = qn(), x = g(() => {
      var Q;
      return i() ? s().variantGIDs ? s().variantGIDs.map(Nt) : (Q = i()) == null ? void 0 : Q.variants.map((b) => b.id) : null;
    }), M = g(() => {
      if (i()) return { ...i(), variants: i().variants.filter((Q) => (r().preview || Q.availableForSale) && (!e(x) || e(x).includes(Q.id))) };
    });
    let A = Ae(void 0);
    const V = g(() => (function(Q, b) {
      if (Q !== void 0) return Q;
      if (b != null && b.availableForSale && b.variants.length > 0) return b.variants[0].id;
    })(e(A), e(M))), C = g(() => e(M) && e(V) ? e(M).variants.find((Q) => Q.id === e(V)) : void 0), R = g(() => {
      var Q, b;
      return s().mediaImageGID ? Me(y, "$getMediaImageUrl", l)(s().mediaImageGID) : ((Q = e(C)) == null ? void 0 : Q.image) || ((b = i()) == null ? void 0 : b.image);
    }), U = g(() => s().quantity * d()), F = g(() => (function(Q, b) {
      if (!b) return 0;
      let B = b.price;
      return b.compareAtPrice && Q.useProductCompareAtPrice && (B = Math.max(B, b.compareAtPrice)), B * e(U);
    })(u(), e(C))), se = g(() => ru({ dealBlock: u(), imageSize: s().imageSize })), X = g(() => pn({ priceFormatter: a(), product: i(), totalFullPrice: e(F), totalDiscountedPrice: 0, quantity: e(U), unitQuantity: e(C) ? er([{ variant: e(C), quantity: e(U) }]) : null })), K = g(() => s() ? e(X)(Me(_, "$translate", l)(s().text)) : ""), J = g(() => {
      var Q;
      if ((Q = i()) != null && Q.url) return e(V) ? `${i().url}?variant=${e(V)}` : i().url;
    });
    function N(Q) {
      te(A, Q, !0);
    }
    let Z;
    Hn(() => {
      s().productGID, te(A, void 0), Z = void 0;
    }), Hn(() => {
      if (u().disableVariantOptionSync || !h() || !e(M) || h() === Z) return;
      const Q = Z;
      Z = h(), e(M).variants.some((b) => b.id === h()) && (e(A) !== void 0 && e(A) !== Q || te(A, h(), !0));
    }), He(() => {
      var Q;
      e(C) && ((Q = i()) != null && Q.availableForSale) && e(U) && Xt(() => {
        f()({ variant: e(C), product: i(), fullPrice: s().showPrice ? e(F) : 0 });
      });
    });
    const $ = g(() => !(!i() || i().availableForSale && i().variants.filter((Q) => Q.availableForSale && (!e(x) || e(x).includes(Q.id))).length !== 0));
    var S = { get dealBlock() {
      return u();
    }, set dealBlock(Q) {
      u(Q), k();
    }, get freeGift() {
      return s();
    }, set freeGift(Q) {
      s(Q), k();
    }, get product() {
      return i();
    }, set product(Q) {
      i(Q), k();
    }, get dealBarSelected() {
      return o();
    }, set dealBarSelected(Q = !1) {
      o(Q), k();
    }, get sets() {
      return d();
    }, set sets(Q) {
      d(Q), k();
    }, get mainProductVariantId() {
      return h();
    }, set mainProductVariantId(Q) {
      h(Q), k();
    }, get onChange() {
      return f();
    }, set onChange(Q) {
      f(Q), k();
    } }, T = De(), q = ve(T), W = (Q) => {
      var b = Lh();
      let B;
      var G = P(b), z = P(G);
      {
        let re = g(() => o() ? e(J) : void 0);
        Vn(z, { get url() {
          return e(re);
        }, class: "kaching-bundles__free-gift__link", children: (fe, ze) => {
          var ce = De(), ie = ve(ce), ke = (_e) => {
            var ye = Th();
            be(() => {
              Pe(ye, "src", e(R)), Pe(ye, "height", s().imageSize || 0);
            }), v(_e, ye);
          }, we = (_e) => {
            var ye = Gh();
            let Se;
            be((Ve) => Se = Wt(ye, "", Se, Ve), [() => {
              var Ve, Ee;
              return { height: `${(Ve = s().imageSize || 0) != null ? Ve : ""}px`, width: `${(Ee = (i() || s().mediaImageGID) && s().imageSize || 0) != null ? Ee : ""}px` };
            }]), v(_e, ye);
          };
          j(ie, (_e) => {
            e(R) ? _e(ke) : _e(we, !1);
          }), v(fe, ce);
        }, $$slots: { default: !0 } });
      }
      var H = E(z, 2), Y = P(H), L = (re) => {
        var fe = De();
        Ke(ve(fe), () => e(K), (ze) => {
          var ce = Oh();
          qe(P(ce), () => e(K)), w(ce), v(ze, ce);
        }), v(re, fe);
      };
      j(Y, (re) => {
        e(K) && re(L);
      });
      var O = E(Y, 2), ae = (re) => {
        Mn(re, { get product() {
          return e(M);
        }, get selectedVariantId() {
          return e(V);
        }, onChange: N });
      };
      j(O, (re) => {
        o() && e(M) && e(M).variants.length > 1 && e(V) && re(ae);
      }), w(H), w(G);
      var ee = E(G, 2), le = (re) => {
        var fe = De();
        Ke(ve(fe), () => e(F), (ze) => {
          var ce = Fh();
          qe(P(ce), () => a()(e(F))), w(ce), v(ze, ce);
        }), v(re, fe);
      };
      j(ee, (re) => {
        s().showPrice && e(F) > 0 && re(le);
      }), w(b), be((re) => {
        B = Ot(b, 1, "kaching-bundles__free-gift", null, B, re), Pe(b, "data-free-gift-id", s().id), Wt(b, e(se));
      }, [() => ({ "kaching-bundles__free-gift--out-of-stock": r().preview && e($) })]), v(Q, b);
    };
    j(q, (Q) => {
      (!s().productGID || e(C) || r().preview && e($)) && Q(W);
    }), v(n, T);
    var ue = Ye(S);
    return c(), ue;
  }
  We(au, { dealBlock: {}, freeGift: {}, product: {}, dealBarSelected: {}, sets: {}, mainProductVariantId: {}, onChange: {} }, [], [], !0);
  var Eh = D('<div class="kaching-bundles__free-gift__divider"></div>'), jh = D("<!> <!>", 1);
  function Ua(n, t) {
    Je(t, !0);
    const r = () => Me(p, "$config", a), [a, l] = wt();
    let c = m(t, "dealBlock", 7), u = m(t, "freeGifts", 7), s = m(t, "otherProducts", 7), i = m(t, "dealBarSelected", 7), o = m(t, "sellingPlan", 7), d = m(t, "sets", 7, 1), h = m(t, "mainProductVariantId", 7), f = m(t, "onChange", 7);
    const p = on();
    let _ = Ae(rt({})), I = g(() => u().filter((V) => !V.applyOnlyForSubscriptions || o()));
    const y = g(() => e(I).flatMap((V) => {
      const C = V.productGID ? s().find((U) => U.id === Nt(V.productGID)) : void 0;
      if (!r().preview && V.productGID && !(C != null && C.availableForSale)) return [];
      const R = C && !r().preview ? Xn(C) : C;
      return { freeGift: V, product: R };
    }));
    He(() => {
      (function(V, C) {
        if (!u().length) return;
        const R = V.filter((U) => U.id in C).map((U) => ({ id: U.id, variant: C[U.id].variant, product: C[U.id].product, quantity: U.quantity * d(), fullPrice: C[U.id].fullPrice }));
        f()(R);
      })(e(I), e(_));
    });
    var x = { get dealBlock() {
      return c();
    }, set dealBlock(V) {
      c(V), k();
    }, get freeGifts() {
      return u();
    }, set freeGifts(V) {
      u(V), k();
    }, get otherProducts() {
      return s();
    }, set otherProducts(V) {
      s(V), k();
    }, get dealBarSelected() {
      return i();
    }, set dealBarSelected(V) {
      i(V), k();
    }, get sellingPlan() {
      return o();
    }, set sellingPlan(V) {
      o(V), k();
    }, get sets() {
      return d();
    }, set sets(V = 1) {
      d(V), k();
    }, get mainProductVariantId() {
      return h();
    }, set mainProductVariantId(V) {
      h(V), k();
    }, get onChange() {
      return f();
    }, set onChange(V) {
      f(V), k();
    } }, M = De();
    Jt(ve(M), 19, () => e(y), ({ freeGift: V, product: C }) => V.id, (V, C, R) => {
      let U = () => e(C).freeGift;
      var F = jh(), se = ve(F);
      au(se, { get dealBlock() {
        return c();
      }, get freeGift() {
        return U();
      }, get product() {
        return e(C).product;
      }, get dealBarSelected() {
        return i();
      }, get sets() {
        return d();
      }, get mainProductVariantId() {
        return h();
      }, onChange: (J) => (function(N, Z) {
        Z.variant ? e(_)[N] = Z : delete e(_)[N];
      })(U().id, J) });
      var X = E(se, 2), K = (J) => {
        v(J, Eh());
      };
      j(X, (J) => {
        e(R) < e(y).length - 1 && J(K);
      }), v(V, F);
    }), v(n, M);
    var A = Ye(x);
    return l(), A;
  }
  function iu(n, t = "body") {
    let r;
    async function a(l) {
      if (typeof (t = l) == "string") {
        if (r = document.querySelector(t), r === null && (await Yl(), r = document.querySelector(t)), r === null) throw new Error(`No element found matching css selector: "${t}"`);
      } else {
        if (!(t instanceof HTMLElement)) throw new TypeError(`Unknown portal target type: ${t === null ? "null" : typeof t}. Allowed types: string (CSS selector) or HTMLElement.`);
        r = t;
      }
      r.appendChild(n), n.hidden = !1;
    }
    return a(t), { update: a, destroy: function() {
      n.parentNode && n.parentNode.removeChild(n);
    } };
  }
  We(Ua, { dealBlock: {}, freeGifts: {}, otherProducts: {}, dealBarSelected: {}, sellingPlan: {}, sets: {}, mainProductVariantId: {}, onChange: {} }, [], [], !0);
  var Rh = D('<div hidden=""><!></div>');
  function Ai(n, t) {
    Je(t, !1);
    let r = m(t, "target", 12, "body");
    var a = { get target() {
      return r();
    }, set target(c) {
      r(c), k();
    } };
    (function(c = !1) {
      const u = rn, s = u.l.u;
      if (!s) return;
      let i = () => Uo(u.s);
      if (c) {
        let o = 0, d = {};
        const h = bi(() => {
          let f = !1;
          const p = u.s;
          for (const _ in p) p[_] !== d[_] && (d[_] = p[_], f = !0);
          return f && o++, o;
        });
        i = () => e(h);
      }
      s.b.length && Hn(() => {
        dc(u, i), Ji(s.b);
      }), He(() => {
        const o = Xt(() => s.m.map(cd));
        return () => {
          for (const d of o) typeof d == "function" && d();
        };
      }), s.a.length && He(() => {
        dc(u, i), Ji(s.a);
      });
    })();
    var l = Rh();
    return tc(P(l), t, "default", {}), w(l), as(l, (c, u) => iu == null ? void 0 : iu(c, u), r), v(n, l), Ye(a);
  }
  We(Ai, { target: {} }, ["default"], [], !0);
  const lu = [{ fonts: [20, 16, 12, 10], gaps: [16, 12, 8], image: 36 }, { fonts: [24, 20, 16, 12], gaps: [20, 16, 12], image: 48 }, { fonts: [28, 24, 20, 16], gaps: [24, 20, 16], image: 60 }, { fonts: [32, 28, 24, 20], gaps: [28, 24, 20], image: 80 }], su = [0, 12, 16, 20, 24, 28];
  var Qh = (n, t) => {
    n.target === n.currentTarget && t()();
  }, Nh = D('<img alt="Close"/>'), Wh = D('<span class="kaching-bundles__personalisation-modal__item-variant"> </span>'), Uh = (n, t, r) => t(r(), n.currentTarget.value), Hh = D('<img alt="Clear"/>'), Zh = D("<span> </span>"), Jh = D('<div class="kaching-bundles__personalisation-modal__item"><div class="kaching-bundles__personalisation-modal__item-info"><div class="kaching-bundles__personalisation-modal__item-image-wrapper"><img class="kaching-bundles__personalisation-modal__item-image" alt=""/></div> <div class="kaching-bundles__personalisation-modal__item-details"><span class="kaching-bundles__personalisation-modal__item-title"> </span> <!></div></div> <div class="kaching-bundles__personalisation-modal__input-wrapper"><div class="kaching-bundles__personalisation-modal__input-container"><input type="text"/> <!></div> <!></div></div>'), Yh = D('<div role="none"><div class="kaching-bundles__personalisation-modal-overlay__content"><div class="kaching-bundles__personalisation-modal"><div class="kaching-bundles__personalisation-modal__header"><h2 class="kaching-bundles__personalisation-modal__heading"> </h2> <!></div> <div class="kaching-bundles__personalisation-modal__items"></div> <div class="kaching-bundles__personalisation-modal__actions"><!> <!></div></div></div></div>');
  function Cs(n, t) {
    Je(t, !0);
    const r = m(t, "product", 7), a = m(t, "selectedVariants", 7), l = m(t, "personalisationValues", 7), c = m(t, "addPersonalisationModal", 7), u = m(t, "inline", 7, !1), s = m(t, "onConfirm", 7), i = m(t, "onClose", 7), o = g(() => {
      var S, T;
      return (T = (S = c()) == null ? void 0 : S.characterLimitEnabled) != null && T;
    }), d = g(() => {
      var S, T;
      return e(o) ? (T = (S = c()) == null ? void 0 : S.characterLimit) != null ? T : 30 : void 0;
    }), h = Math.max(...a().map(({ index: S }) => S), -1);
    let f = Ae(rt(Array.from({ length: h + 1 }, (S, T) => l()[T] || "")));
    const p = new Set(l().map((S, T) => S && S.trim() !== "" ? T : -1).filter((S) => S !== -1)), _ = g(() => c() ? (({ size: S, roundness: T, imageSize: q, textSize: W, overlayColor: ue, primaryTextColor: Q, secondaryTextColor: b, buttonColor: B, buttonTextColor: G, errorColor: z }) => {
      const H = Math.min(Math.max(0, S), lu.length - 1), Y = Math.min(Math.max(0, T), su.length - 1), L = lu[H], O = su[Y];
      return hn({ "kaching-product-personalisation-font-0": L.fonts[0] + "px", "kaching-product-personalisation-font-1": L.fonts[1] + "px", "kaching-product-personalisation-font-2": L.fonts[2] + "px", "kaching-product-personalisation-font-3": L.fonts[3] + "px", "kaching-product-personalisation-gap-0": L.gaps[0] + "px", "kaching-product-personalisation-gap-1": L.gaps[1] + "px", "kaching-product-personalisation-gap-2": L.gaps[2] + "px", "kaching-product-personalisation-image-size": (q != null ? q : L.image) + "px", "kaching-product-personalisation-radius": O + "px", "kaching-product-personalisation-text-size": W + "px", "kaching-product-personalisation-overlay-color": Re(ue), "kaching-product-personalisation-primary-text-color": Re(Q), "kaching-product-personalisation-secondary-text-color": Re(b), "kaching-product-personalisation-button-color": Re(B), "kaching-product-personalisation-button-text-color": Re(G), "kaching-product-personalisation-error-color": Re(z) });
    })(c()) : "");
    function I(S, T) {
      if (e(d) === void 0 || T.length <= e(d)) {
        const q = [...e(f)];
        q[S] = T, te(f, q, !0);
      }
    }
    function y(S) {
      return p.has(S) && !!e(f)[S] && e(f)[S].trim() !== "";
    }
    const x = g(() => e(f).some((S) => S && S.trim() !== "")), M = g(() => p.size > 0), A = g(() => !e(x) && !e(M));
    var V = { get product() {
      return r();
    }, set product(S) {
      r(S), k();
    }, get selectedVariants() {
      return a();
    }, set selectedVariants(S) {
      a(S), k();
    }, get personalisationValues() {
      return l();
    }, set personalisationValues(S) {
      l(S), k();
    }, get addPersonalisationModal() {
      return c();
    }, set addPersonalisationModal(S) {
      c(S), k();
    }, get inline() {
      return u();
    }, set inline(S = !1) {
      u(S), k();
    }, get onConfirm() {
      return s();
    }, set onConfirm(S) {
      s(S), k();
    }, get onClose() {
      return i();
    }, set onClose(S) {
      i(S), k();
    } }, C = Yh();
    let R;
    C.__click = [Qh, i];
    var U = P(C), F = P(U), se = P(F), X = P(se), K = P(X, !0);
    w(X), Qt(E(X, 2), { element: "span", class: "kaching-bundles__personalisation-modal__close", get onclick() {
      return i();
    }, children: (S, T) => {
      var q = Nh();
      be(() => Pe(q, "src", Ps)), v(S, q);
    }, $$slots: { default: !0 } }), w(se);
    var J = E(se, 2);
    Jt(J, 21, a, ({ variant: S, index: T }) => T, (S, T) => {
      let q = () => e(T).variant, W = () => e(T).index;
      var ue = Jh(), Q = P(ue), b = P(Q), B = P(b);
      w(b);
      var G = E(b, 2), z = P(G), H = P(z);
      w(z);
      var Y = E(z, 2), L = (ie) => {
        var ke = Wh(), we = P(ke, !0);
        w(ke), be((_e) => mt(we, _e), [() => q().options.join(", ")]), v(ie, ke);
      };
      j(Y, (ie) => {
        r().variants.length > 1 && ie(L);
      }), w(G), w(Q);
      var O = E(Q, 2), ae = P(O), ee = P(ae);
      let le;
      qr(ee), ee.__input = [Uh, I, W];
      var re = E(ee, 2), fe = (ie) => {
        Qt(ie, { element: "span", class: "kaching-bundles__personalisation-modal__input-clear", onclick: () => (function(ke) {
          const we = [...e(f)];
          we[ke] = "", te(f, we, !0);
        })(W()), children: (ke, we) => {
          var _e = Hh();
          be(() => Pe(_e, "src", "data:image/svg+xml,%3csvg%20width='16'%20height='16'%20viewBox='0%200%2016%2016'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M10.6667%203.99992V3.46659C10.6667%202.71985%2010.6667%202.34648%2010.5213%202.06126C10.3935%201.81038%2010.1895%201.60641%209.93865%201.47858C9.65344%201.33325%209.28007%201.33325%208.53333%201.33325H7.46667C6.71993%201.33325%206.34656%201.33325%206.06135%201.47858C5.81046%201.60641%205.60649%201.81038%205.47866%202.06126C5.33333%202.34648%205.33333%202.71985%205.33333%203.46659V3.99992M2%203.99992H14M12.6667%203.99992V11.4666C12.6667%2012.5867%2012.6667%2013.1467%2012.4487%2013.5746C12.2569%2013.9509%2011.951%2014.2569%2011.5746%2014.4486C11.1468%2014.6666%2010.5868%2014.6666%209.46667%2014.6666H6.53333C5.41323%2014.6666%204.85318%2014.6666%204.42535%2014.4486C4.04903%2014.2569%203.74307%2013.9509%203.55132%2013.5746C3.33333%2013.1467%203.33333%2012.5867%203.33333%2011.4666V3.99992'%20stroke='%23F04438'%20stroke-width='1.5'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e")), v(ke, _e);
        }, $$slots: { default: !0 } });
      };
      j(re, (ie) => {
        y(W()) && ie(fe);
      }), w(ae);
      var ze = E(ae, 2), ce = (ie) => {
        var ke = Zh();
        let we;
        var _e = P(ke);
        w(ke), be((ye) => {
          var Se, Ve;
          we = Ot(ke, 1, "kaching-bundles__personalisation-modal__input-counter", null, we, ye), mt(_e, `${(Se = (e(f)[W()] || "").length) != null ? Se : ""}/${(Ve = e(d)) != null ? Ve : ""}`);
        }, [() => ({ "kaching-bundles__personalisation-modal__input-counter--error": e(d) !== void 0 && (e(f)[W()] || "").length >= e(d) })]), v(ie, ke);
      };
      j(ze, (ie) => {
        e(o) && ie(ce);
      }), w(O), w(ue), be((ie) => {
        var ke, we;
        Pe(B, "src", q().image || r().image), mt(H, `${(ke = r().title) != null ? ke : ""} #${W() + 1}`), le = Ot(ee, 1, "kaching-bundles__personalisation-modal__input", null, le, ie), Pe(ee, "placeholder", (we = c()) == null ? void 0 : we.placeholderText), va(ee, e(f)[W()] || ""), Pe(ee, "maxlength", e(d));
      }, [() => ({ "kaching-bundles__personalisation-modal__input--with-clear": y(W()), "kaching-bundles__personalisation-modal__input--error": e(d) !== void 0 && (e(f)[W()] || "").length >= e(d) })]), v(S, ue);
    }), w(J);
    var N = E(J, 2), Z = P(N);
    Qt(Z, { element: "button", class: "kaching-bundles__personalisation-modal__button kaching-bundles__personalisation-modal__button--cancel", get onclick() {
      return i();
    }, children: (S, T) => {
      Rr(), v(S, In("Cancel"));
    }, $$slots: { default: !0 } });
    var $ = E(Z, 2);
    {
      let S = g(() => ["kaching-bundles__personalisation-modal__button", "kaching-bundles__personalisation-modal__button--confirm", e(A) && "kaching-bundles__personalisation-modal__button--disabled"]);
      Qt($, { element: "button", get class() {
        return e(S);
      }, get disabled() {
        return e(A);
      }, onclick: () => s()(e(f)), children: (T, q) => {
        Rr(), v(T, In("Confirm"));
      }, $$slots: { default: !0 } });
    }
    return w(N), w(F), w(U), w(C), be((S) => {
      var T;
      R = Ot(C, 1, "kaching-bundles__personalisation-modal-overlay", null, R, S), Wt(C, e(_)), mt(K, (T = c()) == null ? void 0 : T.heading);
    }, [() => ({ "kaching-bundles__personalisation-modal-overlay--inline": u() })]), v(n, C), Ye(V);
  }
  Pn(["click", "input"]), We(Cs, { product: {}, selectedVariants: {}, personalisationValues: {}, addPersonalisationModal: {}, inline: {}, onConfirm: {}, onClose: {} }, [], [], !0);
  var Kh = (n, t) => {
    te(t, !0);
  }, Xh = (n, t) => {
    n.key !== "Enter" && n.key !== " " || (n.preventDefault(), te(t, !0));
  }, ep = D('<div class="kaching-bundles__product-personalisation__image-wrapper"><img alt="" class="kaching-bundles__product-personalisation__image"/></div>'), tp = D('<div class="kaching-bundles__product-personalisation__image-wrapper"><img alt="" class="kaching-bundles__product-personalisation__image kaching-bundles__product-personalisation__image--default"/></div>'), np = D('<span class="kaching-bundles__product-personalisation__title"><!> <span class="kaching-bundles__product-personalisation__subtitle"> </span></span>'), rp = D('<span class="kaching-bundles__product-personalisation__title"><!></span>'), ap = D('<span class="kaching-bundles__product-personalisation__subtitle"><!></span>'), ip = D("<!> <!>", 1), lp = D('<span class="kaching-bundles__product-personalisation__unit-label"> </span>'), sp = D('<span class="kaching-bundles__product-personalisation__price"><!> <!></span>'), op = D('<span class="kaching-bundles__product-personalisation__compare-at-price"><!></span>'), cp = D('<div class="kaching-bundles"><!></div>'), up = D('<div role="button" tabindex="0"><div class="kaching-bundles__product-personalisation__main"><!> <div class="kaching-bundles__product-personalisation__content"><!></div></div> <div class="kaching-bundles__product-personalisation__pricing"><!> <!></div></div> <!>', 1);
  function Pa(n, t) {
    Je(t, !0);
    const r = () => Me(_, "$config", c), a = () => Me(y, "$formatPrice", c), l = () => Me(I, "$translate", c), [c, u] = wt();
    let s = m(t, "productPersonalisation", 7), i = m(t, "product", 7), o = m(t, "selectedVariantIds", 7), d = m(t, "quantity", 7), h = m(t, "addPersonalisationModal", 7), f = m(t, "onPersonalisationsChange", 7), p = m(t, "initialValues", 23, () => []);
    const _ = on(), I = qt(), y = cn(), x = qn();
    let M = Ae(!1), A = Ae(rt([]));
    He(() => {
      s().id, p(), te(A, p().map((_e) => _e || ""), !0);
    });
    const V = g(() => {
      if (s().mediaImageGID) return Me(x, "$getMediaImageUrl", c)(s().mediaImageGID);
    }), C = g(() => !e(V) && s().imageSize > 0), R = g(() => Math.round(100 * parseFloat(s().pricePerItem || "0") * r().currencyRate)), U = g(() => Math.round(100 * parseFloat(s().compareAtPrice || "0") * r().currencyRate)), F = g(() => e(R)), se = g(() => e(U)), X = g(() => e(se) > 0 && e(se) > e(F)), K = g(() => ((_e) => hn({ "kaching-product-personalisation-image-height": _e.imageSize + "px" }))(s())), J = g(() => pn({ priceFormatter: a(), product: void 0, totalFullPrice: e(se) || e(F), totalDiscountedPrice: e(F), quantity: d(), unitQuantity: null })), N = g(() => e(J)(l()(s().title))), Z = g(() => s().subtitle ? e(J)(l()(s().subtitle)) : ""), $ = g(() => o().map((_e, ye) => ({ variant: i().variants.find((Se) => Se.id === _e) || i().variants[0], index: ye }))), S = g(() => e(A).some((_e) => (_e || "").trim() !== "")), T = g(() => e(A).map((_e, ye) => ({ value: _e, index: ye })).filter(({ value: _e }) => (_e || "").trim() !== "")), q = g(() => d() === 1);
    function W(_e) {
      var ye;
      const Se = _e.map((ge) => ge || "");
      if (te(A, Se, !0), te(M, !1), !s().variantGID) return;
      const Ve = Nt(s().variantGID);
      if (!Ve) return;
      const Ee = l()(s().valueLabel || "Value"), ne = Se.map((ge, Te) => ({ id: s().id, variantId: Ve, text: ge, valueLabel: Ee, productIndex: Te })).filter((ge) => ge.text.trim() !== "");
      (ye = f()) == null || ye(ne);
    }
    var ue = { get productPersonalisation() {
      return s();
    }, set productPersonalisation(_e) {
      s(_e), k();
    }, get product() {
      return i();
    }, set product(_e) {
      i(_e), k();
    }, get selectedVariantIds() {
      return o();
    }, set selectedVariantIds(_e) {
      o(_e), k();
    }, get quantity() {
      return d();
    }, set quantity(_e) {
      d(_e), k();
    }, get addPersonalisationModal() {
      return h();
    }, set addPersonalisationModal(_e) {
      h(_e), k();
    }, get onPersonalisationsChange() {
      return f();
    }, set onPersonalisationsChange(_e) {
      f(_e), k();
    }, get initialValues() {
      return p();
    }, set initialValues(_e = []) {
      p(_e), k();
    } }, Q = up(), b = ve(Q);
    let B;
    b.__click = [Kh, M], b.__keydown = [Xh, M];
    var G = P(b), z = P(G), H = (_e) => {
      var ye = ep(), Se = P(ye);
      w(ye), be(() => {
        Pe(Se, "src", e(V)), Pe(Se, "height", s().imageSize || 0);
      }), v(_e, ye);
    }, Y = (_e) => {
      var ye = De(), Se = ve(ye), Ve = (Ee) => {
        var ne = tp(), ge = P(ne);
        w(ne), be(() => {
          Pe(ge, "src", "data:image/svg+xml,%3csvg%20width='32'%20height='32'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20fill-rule='evenodd'%20clip-rule='evenodd'%20d='M25.0476%206.95032C24.6473%206.55003%2024.1722%206.23251%2023.6492%206.01588C23.1262%205.79924%2022.5657%205.68774%2021.9996%205.68774C21.4335%205.68774%2020.873%205.79924%2020.35%206.01588C19.8271%206.23251%2019.3519%206.55003%2018.9516%206.95032L17.9932%207.90872L17.9788%207.89432L16.2828%209.59032L16.2972%209.60632L6.88921%2019.0143C6.06394%2019.8391%205.60007%2020.9579%205.59961%2022.1247V25.1999C5.59961%2025.5182%205.72604%2025.8234%205.95108%2026.0484C6.17612%2026.2735%206.48135%2026.3999%206.79961%2026.3999H9.87481C11.0416%2026.3995%2012.1604%2025.9356%2012.9852%2025.1103L25.0492%2013.0463C25.4495%2012.6461%2025.767%2012.1709%2025.9837%2011.6479C26.2003%2011.1249%2026.3118%2010.5644%2026.3118%209.99832C26.3118%209.43225%2026.2003%208.87172%2025.9837%208.34874C25.767%207.82576%2025.4495%207.35058%2025.0492%206.95032H25.0476ZM17.9932%2011.3023L8.58521%2020.7103C8.3995%2020.8961%208.25221%2021.1166%208.15173%2021.3593C8.05125%2021.602%207.99956%2021.8621%207.99961%2022.1247V23.9999H9.87481C10.4044%2023.9999%2010.9148%2023.7887%2011.2876%2023.4143L20.6956%2014.0063L17.9932%2011.3023ZM22.3932%2012.3087L23.3516%2011.3503C23.6865%2010.9871%2023.8678%2010.5084%2023.8578%2010.0144C23.8477%209.52049%2023.647%209.04957%2023.2977%208.70023C22.9484%208.35089%2022.4774%208.15019%2021.9835%208.14015C21.4896%208.1301%2021.0109%208.31147%2020.6476%208.64632L19.6908%209.60632L22.3932%2012.3087Z'%20fill='black'/%3e%3c/svg%3e"), Pe(ge, "height", s().imageSize || 0);
        }), v(Ee, ne);
      };
      j(Se, (Ee) => {
        e(C) && Ee(Ve);
      }, !0), v(_e, ye);
    };
    j(z, (_e) => {
      e(V) ? _e(H) : _e(Y, !1);
    });
    var L = E(z, 2), O = P(L), ae = (_e) => {
      var ye = De();
      Jt(ve(ye), 17, () => e(T), ({ value: Se, index: Ve }) => Ve, (Se, Ve) => {
        var Ee = np(), ne = P(Ee), ge = (de) => {
          var $e = In();
          be(() => mt($e, `#${e(Ve).index + 1}`)), v(de, $e);
        };
        j(ne, (de) => {
          e(q) || de(ge);
        });
        var Te = E(ne, 2), pe = P(Te, !0);
        w(Te), w(Ee), be(() => mt(pe, e(Ve).value)), v(Se, Ee);
      }), v(_e, ye);
    }, ee = (_e) => {
      var ye = ip(), Se = ve(ye), Ve = (ge) => {
        var Te = rp();
        qe(P(Te), () => e(N)), w(Te), v(ge, Te);
      };
      j(Se, (ge) => {
        e(N) && ge(Ve);
      });
      var Ee = E(Se, 2), ne = (ge) => {
        var Te = ap();
        qe(P(Te), () => e(Z)), w(Te), v(ge, Te);
      };
      j(Ee, (ge) => {
        e(Z) && ge(ne);
      }), v(_e, ye);
    };
    j(O, (_e) => {
      e(S) ? _e(ae) : _e(ee, !1);
    }), w(L), w(G);
    var le = E(G, 2), re = P(le), fe = (_e) => {
      var ye = sp(), Se = P(ye);
      qe(Se, () => a()(e(F)));
      var Ve = E(Se, 2), Ee = (ne) => {
        var ge = lp(), Te = P(ge, !0);
        w(ge), be(() => mt(Te, s().pricePerItemUnitLabel)), v(ne, ge);
      };
      j(Ve, (ne) => {
        s().pricePerItemUnitLabel && ne(Ee);
      }), w(ye), v(_e, ye);
    };
    j(re, (_e) => {
      e(F) > 0 && _e(fe);
    });
    var ze = E(re, 2), ce = (_e) => {
      var ye = op();
      qe(P(ye), () => a()(e(se))), w(ye), v(_e, ye);
    };
    j(ze, (_e) => {
      e(X) && _e(ce);
    }), w(le), w(b);
    var ie = E(b, 2), ke = (_e) => {
      Ai(_e, { target: "body", children: (ye, Se) => {
        var Ve = cp();
        Cs(P(Ve), { get product() {
          return i();
        }, get selectedVariants() {
          return e($);
        }, get personalisationValues() {
          return e(A);
        }, get addPersonalisationModal() {
          return h();
        }, onConfirm: W, onClose: () => {
          te(M, !1);
        } }), w(Ve), v(ye, Ve);
      }, $$slots: { default: !0 } });
    };
    j(ie, (_e) => {
      e(M) && _e(ke);
    }), be((_e) => {
      B = Ot(b, 1, "kaching-bundles__product-personalisation", null, B, _e), Pe(b, "data-product-personalisation-id", s().id), Wt(b, e(K));
    }, [() => ({ "kaching-bundles__product-personalisation--filled": e(S) })]), v(n, Q);
    var we = Ye(ue);
    return u(), we;
  }
  function dp(n, t, r) {
    const a = Number(n.target.value), l = t().find((c) => c.id === a);
    r()(l);
  }
  Pn(["click", "keydown"]), We(Pa, { productPersonalisation: {}, product: {}, selectedVariantIds: {}, quantity: {}, addPersonalisationModal: {}, onPersonalisationsChange: {}, initialValues: {} }, [], [], !0);
  var gp = (n) => n.stopPropagation(), hp = D("<option> </option>"), pp = D('<select class="kaching-bundles__bar-variant-select kaching-bundles__selling-plan-select"></select>');
  function Xr(n, t) {
    Je(t, !0);
    const [r, a] = wt(), l = m(t, "sellingPlans", 7), c = m(t, "selectedSellingPlan", 7), u = m(t, "onChange", 7), s = qt();
    var i, o = { get sellingPlans() {
      return l();
    }, set sellingPlans(f) {
      l(f), k();
    }, get selectedSellingPlan() {
      return c();
    }, set selectedSellingPlan(f) {
      c(f), k();
    }, get onChange() {
      return u();
    }, set onChange(f) {
      u(f), k();
    } }, d = pp();
    d.__change = [dp, l, u], d.__click = [gp], Jt(d, 21, l, (f) => f.id, (f, p) => {
      var _ = hp(), I = P(_, !0);
      w(_);
      var y = {};
      be(() => {
        var x;
        mt(I, e(p).name), y !== (y = e(p).id) && (_.value = (x = _.__value = e(p).id) != null ? x : "");
      }), v(f, _);
    }), w(d), ss(d), be((f) => {
      var p;
      Pe(d, "aria-label", f), i !== (i = c().id) && (d.value = (p = d.__value = c().id) != null ? p : "", yi(d, c().id));
    }, [() => Me(s, "$translate", r)("system.subscription_plan")]), v(n, d);
    var h = Ye(o);
    return a(), h;
  }
  Pn(["change", "click"]), We(Xr, { sellingPlans: {}, selectedSellingPlan: {}, onChange: {} }, [], [], !0);
  var fp = $n('<svg width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.334 1 5 8.333 1.667 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>');
  function wl(n) {
    v(n, fp());
  }
  We(wl, {}, [], [], !0);
  var bp = D('<img alt="" class="kaching-bundles__upsell__image"/>'), vp = D('<div class="kaching-bundles__upsell__price"><!></div>'), _p = D('<div class="kaching-bundles__upsell__full-price"><!></div>'), kp = D('<div class="kaching-bundles__upsell__price"><!></div>'), mp = D('<div class="kaching-bundles__upsell__full-price"><!></div>'), yp = D('<div class="kaching-bundles__upsell__pricing-row kaching-bundles__upsell__pricing-row--secondary"><!> <!></div>'), xp = D('<div class="kaching-bundles__upsell__pricing-row kaching-bundles__upsell__pricing-row--main"><!> <!></div> <!>', 1), wp = D('<div class="kaching-bundles__upsell__price"><!></div>'), Pp = D('<div class="kaching-bundles__upsell__full-price"><!></div>'), Sp = D('<div class="kaching-bundles__upsell__unit-price"><!> </div>'), Cp = D('<div class="kaching-bundles__upsell__pricing-row kaching-bundles__upsell__pricing-row--main"><!> <!></div> <div class="kaching-bundles__upsell__pricing-row kaching-bundles__upsell__pricing-row--secondary"><!></div>', 1), Bp = D('<div class="kaching-bundles__upsell__price"><!></div>'), Ip = D('<div class="kaching-bundles__upsell__full-price"><!></div>'), Mp = D("<!> <!>", 1), Dp = D('<div><div class="kaching-bundles__upsell__main"><!> <!> <div class="kaching-bundles__upsell__content"><!> <!> <!></div></div> <div class="kaching-bundles__upsell__pricing"><!></div></div>');
  function ou(n, t) {
    Je(t, !0);
    const r = () => Me(y, "$config", l), a = () => Me(_, "$formatPrice", l), [l, c] = wt();
    let u = m(t, "dealBlock", 7), s = m(t, "upsell", 7), i = m(t, "product", 7), o = m(t, "dealBarSelected", 7, !1), d = m(t, "dealSellingPlan", 7), h = m(t, "sets", 7), f = m(t, "onChange", 7);
    const p = qt(), _ = cn(), I = qn(), y = on();
    let x = Ae(rt(s().preselected)), M = Ae(void 0), A = Ae(void 0);
    const V = g(() => s().variantGIDs ? s().variantGIDs.map(Nt) : i().variants.map((ce) => ce.id)), C = g(() => ({ ...i(), variants: i().variants.filter((ce) => (r().preview || ce.availableForSale) && e(V).includes(ce.id)) })), R = g(() => (function(ce, ie) {
      if (ce !== void 0) return ce;
      if (ie != null && ie.availableForSale && ie.variants.length > 0) return ie.variants[0].id;
    })(e(M), e(C))), U = g(() => e(C).variants.find((ce) => ce.id === e(R))), F = g(() => Me(I, "$getMediaImageUrl", l)(s().mediaImageGID)), se = g(() => ((ce, ie) => {
      const { fonts: ke, colors: we, cornerRadius: _e } = ce;
      return hn({ "kaching-upsell-background-color": we.upsellBackground && Re(we.upsellBackground), "kaching-upsell-text-color": we.upsellText && Re(we.upsellText), "kaching-upsell-selected-background-color": we.upsellSelectedBackground && Re(we.upsellSelectedBackground), "kaching-upsell-selected-text-color": we.upsellSelectedText && Re(we.upsellSelectedText), "kaching-upsell-font-size": ke.upsell && ke.upsell.size + "px", "kaching-upsell-font-weight": ke.upsell && Yn(ke.upsell.style), "kaching-upsell-font-style": ke.upsell && Kn(ke.upsell.style), "kaching-upsell-image-border-radius": (_e || 0) / 2 + "px", "kaching-upsell-image-height": ie.imageSize + "px" });
    })(u(), s())), X = g(() => i().url ? `${i().url}?variant=${e(R)}` : void 0), K = g(() => u().priceRounding ? { perItem: u().showPricesPerItem, precision: u().priceRoundingPrecision, v2: r().featureFlags.price_rounding_v2 || !1 } : void 0), J = g(() => s().quantity * h()), N = g(() => (function(ce) {
      if (!ce) return 0;
      let ie = ce.price;
      return u().useProductCompareAtPrice && ce.compareAtPrice && (ie = Math.max(ie, ce.compareAtPrice)), ie * e(J);
    })(e(U))), Z = g(() => Math.ceil(e(N) / e(J))), $ = g(() => {
      var ce;
      return (ce = s().subscriptionEnabled) == null || ce;
    }), S = g(() => {
      var ce;
      return (ce = s().subscriptionType) != null ? ce : "deal";
    }), T = g(() => {
      if (!e($) || e(S) !== "always" || !e(U)) return [];
      const ce = new Set(e(U).sellingPlans.map((ie) => ie.id));
      return i().sellingPlans.filter((ie) => ce.has(ie.id));
    }), q = g(() => e(T).find((ce) => ce.id === e(A)) || e(T)[0]);
    He(() => {
      var ce;
      e(T).some((ie) => {
        var ke;
        return ie.id === ((ke = d()) == null ? void 0 : ke.id);
      }) && te(A, (ce = d()) == null ? void 0 : ce.id, !0);
    });
    const W = g(() => {
      if (e(U) && e($))
        return e(S) === "deal" ? d() ? Fn(i(), e(U), d()) : void 0 : e(q);
    }), ue = g(() => Tr({ discountType: s().discountType, discountValue: s().discountValue, discountQuantity: s().quantity, variantQuantities: e(U) ? [{ variant: e(U), quantity: e(J) }] : [], currencyRate: r().currencyRate, priceRounding: e(K), sellingPlan: e(W) })), Q = g(() => Math.ceil(e(ue) / e(J))), b = g(() => e(N) > e(ue)), B = g(() => e(U) && _s(e(U))), G = g(() => e(U) ? er([{ variant: e(U), quantity: e(J) }]) : null), z = g(() => e(G) ? e(ue) / e(G) : null), H = g(() => pn({ priceFormatter: a(), product: i(), totalFullPrice: e(N), totalDiscountedPrice: e(ue), quantity: e(J), unitQuantity: e(G), sellingPlan: e(W) })), Y = g(() => e(H)(Me(p, "$translate", l)(s().text)));
    function L(ce) {
      te(M, ce, !0);
    }
    function O() {
      o() && te(x, !e(x));
    }
    Hn(() => {
      s().productGID, te(M, void 0);
    }), He(() => {
      if (e(U) && i().availableForSale && e(J)) {
        const ce = e(x), ie = e(W);
        Xt(() => {
          f()({ variant: ce ? e(U) : null, product: ce ? i() : null, discountedPrice: ce ? e(ue) : 0, fullPrice: ce ? e(N) : 0, sellingPlan: ce ? ie : void 0 });
        });
      }
    });
    const ae = g(() => !i().availableForSale || i().variants.filter((ce) => ce.availableForSale && e(V).includes(ce.id)).length === 0);
    var ee = { get dealBlock() {
      return u();
    }, set dealBlock(ce) {
      u(ce), k();
    }, get upsell() {
      return s();
    }, set upsell(ce) {
      s(ce), k();
    }, get product() {
      return i();
    }, set product(ce) {
      i(ce), k();
    }, get dealBarSelected() {
      return o();
    }, set dealBarSelected(ce = !1) {
      o(ce), k();
    }, get dealSellingPlan() {
      return d();
    }, set dealSellingPlan(ce) {
      d(ce), k();
    }, get sets() {
      return h();
    }, set sets(ce) {
      h(ce), k();
    }, get onChange() {
      return f();
    }, set onChange(ce) {
      f(ce), k();
    } }, le = De(), re = ve(le), fe = (ce) => {
      var ie = Dp();
      let ke;
      var we = P(ie), _e = P(we), ye = (Ne) => {
        {
          let it = g(() => ["kaching-bundles__upsell__checkbox", e(x) && "kaching-bundles__upsell__checkbox--selected"]);
          Qt(Ne, { element: "span", get class() {
            return e(it);
          }, onclick: O, children: (Et, Pt) => {
            var Ft = De(), Dt = ve(Ft), Lt = (Ce) => {
              wl(Ce);
            };
            j(Dt, (Ce) => {
              e(x) && Ce(Lt);
            }), v(Et, Ft);
          }, $$slots: { default: !0 } });
        }
      };
      j(_e, (Ne) => {
        o() && Ne(ye);
      });
      var Se = E(_e, 2), Ve = (Ne) => {
        {
          let it = g(() => o() ? e(X) : void 0);
          Vn(Ne, { get url() {
            return e(it);
          }, class: "kaching-bundles__upsell__link", children: (Et, Pt) => {
            var Ft = bp();
            be(() => {
              var Dt;
              Pe(Ft, "src", e(F) || ((Dt = e(U)) == null ? void 0 : Dt.image) || i().image), Pe(Ft, "height", s().imageSize);
            }), v(Et, Ft);
          }, $$slots: { default: !0 } });
        }
      };
      j(Se, (Ne) => {
        s().imageSize > 0 && Ne(Ve);
      });
      var Ee = E(Se, 2), ne = P(Ee), ge = (Ne) => {
        Qt(Ne, { element: "span", class: "kaching-bundles__upsell__text", onclick: O, children: (it, Et) => {
          var Pt = De();
          qe(ve(Pt), () => e(Y)), v(it, Pt);
        }, $$slots: { default: !0 } });
      };
      j(ne, (Ne) => {
        e(Y) && Ne(ge);
      });
      var Te = E(ne, 2), pe = (Ne) => {
        Mn(Ne, { get product() {
          return e(C);
        }, get selectedVariantId() {
          return e(R);
        }, onChange: L });
      };
      j(Te, (Ne) => {
        o() && e(C) && e(C).variants.length > 1 && e(R) && Ne(pe);
      });
      var de = E(Te, 2), $e = (Ne) => {
        Xr(Ne, { get sellingPlans() {
          return e(T);
        }, get selectedSellingPlan() {
          return e(q);
        }, onChange: (it) => te(A, it.id, !0) });
      };
      j(de, (Ne) => {
        o() && e(x) && e(T).length > 1 && e(q) && Ne($e);
      }), w(Ee), w(we);
      var je = E(we, 2), st = P(je), pt = (Ne) => {
        var it = xp(), Et = ve(it), Pt = P(Et);
        Ke(Pt, () => e(Q), (tt) => {
          var ft = vp();
          qe(P(ft), () => a()(e(Q))), w(ft), v(tt, ft);
        });
        var Ft = E(Pt, 2), Dt = (tt) => {
          var ft = De();
          Ke(ve(ft), () => e(Z), (gt) => {
            var Qe = _p();
            qe(P(Qe), () => a()(e(Z))), w(Qe), v(gt, Qe);
          }), v(tt, ft);
        };
        j(Ft, (tt) => {
          e(b) && tt(Dt);
        }), w(Et);
        var Lt = E(Et, 2), Ce = (tt) => {
          var ft = yp(), gt = P(ft);
          Ke(gt, () => e(ue), (Ze) => {
            var zt = kp();
            qe(P(zt), () => a()(e(ue))), w(zt), v(Ze, zt);
          });
          var Qe = E(gt, 2), at = (Ze) => {
            var zt = De();
            Ke(ve(zt), () => e(N), (en) => {
              var tn = mp();
              qe(P(tn), () => a()(e(N))), w(tn), v(en, tn);
            }), v(Ze, zt);
          };
          j(Qe, (Ze) => {
            e(b) && Ze(at);
          }), w(ft), v(tt, ft);
        };
        j(Lt, (tt) => {
          e(J) > 1 && tt(Ce);
        }), v(Ne, it);
      }, ot = (Ne) => {
        var it = De(), Et = ve(it), Pt = (Dt) => {
          var Lt = Cp(), Ce = ve(Lt), tt = P(Ce);
          Ke(tt, () => e(ue), (at) => {
            var Ze = wp();
            qe(P(Ze), () => a()(u().showPricesPerItem ? e(Q) : e(ue))), w(Ze), v(at, Ze);
          });
          var ft = E(tt, 2), gt = (at) => {
            var Ze = De();
            Ke(ve(Ze), () => e(N), (zt) => {
              var en = Pp();
              qe(P(en), () => a()(u().showPricesPerItem ? e(Z) : e(N))), w(en), v(zt, en);
            }), v(at, Ze);
          };
          j(ft, (at) => {
            e(b) && at(gt);
          }), w(Ce);
          var Qe = E(Ce, 2);
          Ke(P(Qe), () => e(z), (at) => {
            var Ze = Sp(), zt = P(Ze);
            qe(zt, () => a()(e(z), { preserveDecimals: !0 }));
            var en = E(zt);
            w(Ze), be(() => {
              var tn;
              return mt(en, ` / ${(tn = e(B)) != null ? tn : ""}`);
            }), v(at, Ze);
          }), w(Qe), v(Dt, Lt);
        }, Ft = (Dt) => {
          var Lt = Mp(), Ce = ve(Lt);
          Ke(Ce, () => e(ue), (gt) => {
            var Qe = Bp();
            qe(P(Qe), () => a()(u().showPricesPerItem ? e(Q) : e(ue))), w(Qe), v(gt, Qe);
          });
          var tt = E(Ce, 2), ft = (gt) => {
            var Qe = De();
            Ke(ve(Qe), () => e(N), (at) => {
              var Ze = Ip();
              qe(P(Ze), () => a()(u().showPricesPerItem ? e(Z) : e(N))), w(Ze), v(at, Ze);
            }), v(gt, Qe);
          };
          j(tt, (gt) => {
            e(b) && gt(ft);
          }), v(Dt, Lt);
        };
        j(Et, (Dt) => {
          e(z) && e(B) && !r().ignoreUnitPrice ? Dt(Pt) : Dt(Ft, !1);
        }, !0), v(Ne, it);
      };
      j(st, (Ne) => {
        u().showBothPrices ? Ne(pt) : Ne(ot, !1);
      }), w(je), w(ie), be((Ne) => {
        ke = Ot(ie, 1, "kaching-bundles__upsell", null, ke, Ne), Pe(ie, "data-upsell-id", s().id), Wt(ie, e(se));
      }, [() => ({ "kaching-bundles__upsell--out-of-stock": r().preview && e(ae) })]), v(ce, ie);
    };
    j(re, (ce) => {
      !(e(U) || r().preview && e(ae)) || s().visibleOnlyWhenDealBarSelected && !o() || ce(fe);
    }), v(n, le);
    var ze = Ye(ee);
    return c(), ze;
  }
  We(ou, { dealBlock: {}, upsell: {}, product: {}, dealBarSelected: {}, dealSellingPlan: {}, sets: {}, onChange: {} }, [], [], !0);
  var zp = D('<div class="kaching-bundles__free-gift__divider"></div>'), Ap = D("<!> <!>", 1);
  function Ha(n, t) {
    Je(t, !0);
    const r = () => Me(p, "$config", a), [a, l] = wt();
    let c = m(t, "dealBlock", 7), u = m(t, "upsells", 7), s = m(t, "otherProducts", 7), i = m(t, "complementaryProducts", 7), o = m(t, "dealBarSelected", 7), d = m(t, "dealSellingPlan", 7), h = m(t, "sets", 7, 1), f = m(t, "onChange", 7);
    const p = on();
    let _ = Ae(rt({}));
    const I = g(() => r().preview ? s() : s().map(Xn)), y = g(() => r().preview ? i() : i().map(Xn)), x = Math.floor(1e3 * Math.random()), M = g(() => u().flatMap((R, U) => {
      if (R.productSource === "complementary") {
        const se = e(y)[(U + x) % (e(y).length || 1)];
        return se && (r().preview || se.availableForSale) ? { upsell: R, product: se } : [];
      }
      if (!R.productGID) return [];
      const F = e(I).find((se) => se.id === Nt(R.productGID));
      if (!F) return [];
      if (!r().preview) {
        if (!F.availableForSale) return [];
        const se = R.variantGIDs ? R.variantGIDs.map(Nt) : F.variants.map((X) => X.id);
        if (!F.variants.some((X) => X.availableForSale && se.includes(X.id))) return [];
      }
      return { upsell: R, product: F };
    }));
    var A = { get dealBlock() {
      return c();
    }, set dealBlock(R) {
      c(R), k();
    }, get upsells() {
      return u();
    }, set upsells(R) {
      u(R), k();
    }, get otherProducts() {
      return s();
    }, set otherProducts(R) {
      s(R), k();
    }, get complementaryProducts() {
      return i();
    }, set complementaryProducts(R) {
      i(R), k();
    }, get dealBarSelected() {
      return o();
    }, set dealBarSelected(R) {
      o(R), k();
    }, get dealSellingPlan() {
      return d();
    }, set dealSellingPlan(R) {
      d(R), k();
    }, get sets() {
      return h();
    }, set sets(R = 1) {
      h(R), k();
    }, get onChange() {
      return f();
    }, set onChange(R) {
      f(R), k();
    } }, V = De();
    Jt(ve(V), 19, () => e(M), ({ upsell: R, product: U }) => R.id, (R, U, F) => {
      let se = () => e(U).upsell;
      var X = Ap(), K = ve(X);
      ou(K, { get dealBlock() {
        return c();
      }, get upsell() {
        return se();
      }, get product() {
        return e(U).product;
      }, get dealBarSelected() {
        return o();
      }, get dealSellingPlan() {
        return d();
      }, get sets() {
        return h();
      }, onChange: (Z) => (function($, S) {
        const { variant: T, product: q, discountedPrice: W, fullPrice: ue, sellingPlan: Q } = S;
        T && q ? e(_)[$] = { variant: T, product: q, discountedPrice: W, fullPrice: ue, sellingPlan: Q } : delete e(_)[$];
        const b = u().filter((B) => B.id in e(_)).map((B) => ({ id: B.id, variant: e(_)[B.id].variant, product: e(_)[B.id].product, quantity: B.quantity * h(), discountedPrice: e(_)[B.id].discountedPrice, fullPrice: e(_)[B.id].fullPrice, sellingPlan: e(_)[B.id].sellingPlan }));
        f()(b);
      })(se().id, Z) });
      var J = E(K, 2), N = (Z) => {
        v(Z, zp());
      };
      j(J, (Z) => {
        e(F) < e(M).length - 1 && Z(N);
      }), v(R, X);
    }), v(n, V);
    var C = Ye(A);
    return l(), C;
  }
  We(Ha, { dealBlock: {}, upsells: {}, otherProducts: {}, complementaryProducts: {}, dealBarSelected: {}, dealSellingPlan: {}, sets: {}, onChange: {} }, [], [], !0);
  var $p = D('<span class="kaching-bundles__bar-price__unit-label"><!></span>'), qp = D('<div class="kaching-bundles__bar-price"><!> <!></div>');
  function yr(n, t) {
    Je(t, !0);
    const r = () => Me(i, "$translate", a), [a, l] = wt(), c = m(t, "amount", 7), u = m(t, "showPricesPerItem", 7), s = m(t, "unitLabel", 7, ""), i = qt(), o = cn();
    var d = { get amount() {
      return c();
    }, set amount(y) {
      c(y), k();
    }, get showPricesPerItem() {
      return u();
    }, set showPricesPerItem(y) {
      u(y), k();
    }, get unitLabel() {
      return s();
    }, set unitLabel(y = "") {
      s(y), k();
    } }, h = qp(), f = P(h);
    qe(f, () => Me(o, "$formatPrice", a)(c()));
    var p = E(f, 2), _ = (y) => {
      var x = $p();
      qe(P(x), () => r()(s())), w(x), v(y, x);
    };
    j(p, (y) => {
      u() && s() && y(_);
    }), w(h), be((y) => Pe(h, "data-a11y-label", y), [() => r()("system.price")]), v(n, h);
    var I = Ye(d);
    return l(), I;
  }
  We(yr, { amount: {}, showPricesPerItem: {}, unitLabel: {} }, [], [], !0);
  var Vp = D('<div class="kaching-bundles__low-stock-alert"><!></div>');
  function Gr(n, t) {
    Je(t, !0);
    const [r, a] = wt(), l = m(t, "lowStockAlert", 7), c = m(t, "inventoryQuantity", 7), u = qt(), s = g(() => {
      return _ = Me(u, "$translate", r)(l().message), I = { stock: c() ? c().toString() : null }, _.replace(/\{\{\s*(\w+)\s*\}\}/g, (y, x) => {
        var M;
        return (M = I[x]) != null ? M : "";
      });
      var _, I;
    }), i = g(() => ((_) => {
      const { textColor: I } = _;
      return hn({ "kaching-bundles-low-stock-alert-text-color": Re(I) });
    })(l()));
    var o = { get lowStockAlert() {
      return l();
    }, set lowStockAlert(_) {
      l(_), k();
    }, get inventoryQuantity() {
      return c();
    }, set inventoryQuantity(_) {
      c(_), k();
    } }, d = De(), h = ve(d), f = (_) => {
      var I = Vp();
      qe(P(I), () => e(s)), w(I), be(() => Wt(I, e(i))), v(_, I);
    };
    j(h, (_) => {
      c() && c() > 0 && c() < l().threshold && _(f);
    }), v(n, d);
    var p = Ye(o);
    return a(), p;
  }
  We(Gr, { lowStockAlert: {}, inventoryQuantity: {} }, [], [], !0);
  var Tp = D('<div class="kaching-bundles__bar-sold-out-badge"><!></div>');
  function Za(n, t) {
    Je(t, !0);
    const [r, a] = wt(), l = m(t, "showAsSoldOut", 7), c = m(t, "replaceLiquid", 7), u = qt(), s = g(() => c()(Me(u, "$translate", r)(l().label)));
    var i = { get showAsSoldOut() {
      return l();
    }, set showAsSoldOut(h) {
      l(h), k();
    }, get replaceLiquid() {
      return c();
    }, set replaceLiquid(h) {
      c(h), k();
    } }, o = Tp();
    qe(P(o), () => e(s)), w(o), v(n, o);
    var d = Ye(i);
    return a(), d;
  }
  We(Za, { showAsSoldOut: {}, replaceLiquid: {} }, [], [], !0);
  const $i = (n) => {
    const { opacity: t, backgroundColor: r, textColor: a, textSize: l } = n;
    return hn({ "kaching-bundles-show-as-sold-out-opacity": t.toString(), "kaching-bundles-show-as-sold-out-background-color": Re(r), "kaching-bundles-show-as-sold-out-text-color": Re(a), "kaching-bundles-show-as-sold-out-text-size": l + "px" });
  };
  var Gp = D('<img alt="Decrease"/>'), Op = D('<img alt="Increase"/>'), Fp = D('<div class="kaching-bundles__quantity-selector"><!> <input type="number" class="kaching-bundles__quantity-selector__input" step="1"/> <!></div>');
  function qi(n, t) {
    Je(t, !0);
    const [r, a] = wt();
    let l = m(t, "value", 7), c = m(t, "onChange", 7), u = m(t, "min", 7, 1);
    const s = qt(), i = g(() => l() <= u());
    var o = { get value() {
      return l();
    }, set value(_) {
      l(_), k();
    }, get onChange() {
      return c();
    }, set onChange(_) {
      c(_), k();
    }, get min() {
      return u();
    }, set min(_ = 1) {
      u(_), k();
    } }, d = Fp(), h = P(d);
    {
      let _ = g(() => ["kaching-bundles__quantity-selector__button", e(i) && "kaching-bundles__quantity-selector__button--disabled"]);
      Qt(h, { element: "div", get class() {
        return e(_);
      }, onclick: function(I) {
        I.stopPropagation(), c()(Math.max(l() - 1, u()));
      }, get disabled() {
        return e(i);
      }, children: (I, y) => {
        var x = Gp();
        be(() => Pe(x, "src", Uc)), v(I, x);
      }, $$slots: { default: !0 } });
    }
    var f = E(h, 2);
    qr(f), Qt(E(f, 2), { element: "div", class: "kaching-bundles__quantity-selector__button", onclick: function(_) {
      _.stopPropagation(), c()(l() + 1);
    }, children: (_, I) => {
      var y = Op();
      be(() => Pe(y, "src", Hc)), v(_, y);
    }, $$slots: { default: !0 } }), w(d), be((_) => {
      Pe(f, "aria-label", _), va(f, l()), Pe(f, "min", u());
    }, [() => Me(s, "$translate", r)("system.quantity")]), Jo("blur", f, function(_) {
      const I = _.target, y = parseInt(I.value);
      c()(isNaN(y) ? u() : Math.max(y, u()));
    }), v(n, d);
    var p = Ye(o);
    return a(), p;
  }
  function Lp(n, t) {
    n.target === n.currentTarget && t()();
  }
  We(qi, { value: {}, onChange: {}, min: {} }, [], [], !0);
  var Ep = D('<div class="kaching-bundles"><div class="kaching-bundles__choose-multiple-gifts-modal" role="none"><div class="kaching-bundles__choose-multiple-gifts-modal__content"><!></div></div></div>');
  function cu(n, t) {
    Je(t, !0);
    const r = m(t, "dealBlock", 7), a = m(t, "multipleGiftsSelector", 7), l = m(t, "products", 23, () => []), c = m(t, "initialSelectedGifts", 7), u = m(t, "isOpen", 7), s = m(t, "onConfirm", 7), i = m(t, "onClose", 7);
    var o = { get dealBlock() {
      return r();
    }, set dealBlock(p) {
      r(p), k();
    }, get multipleGiftsSelector() {
      return a();
    }, set multipleGiftsSelector(p) {
      a(p), k();
    }, get products() {
      return l();
    }, set products(p = []) {
      l(p), k();
    }, get initialSelectedGifts() {
      return c();
    }, set initialSelectedGifts(p) {
      c(p), k();
    }, get isOpen() {
      return u();
    }, set isOpen(p) {
      u(p), k();
    }, get onConfirm() {
      return s();
    }, set onConfirm(p) {
      s(p), k();
    }, get onClose() {
      return i();
    }, set onClose(p) {
      i(p), k();
    } }, d = De(), h = ve(d), f = (p) => {
      Ai(p, { target: "body", children: (_, I) => {
        var y = Ep(), x = P(y);
        x.__click = [Lp, i];
        var M = P(x);
        ks(P(M), { get dealBlock() {
          return r();
        }, get multipleGiftsSelector() {
          return a();
        }, get products() {
          return l();
        }, get initialSelectedGifts() {
          return c();
        }, get onConfirm() {
          return s();
        }, get onClose() {
          return i();
        } }), w(M), w(x), w(y), be((A) => Wt(x, A), [() => (function(A) {
          var V;
          return hn({ "kaching-choose-multiple-gifts-overlay-color": Re(((V = A.chooseMultipleGiftsModal) == null ? void 0 : V.overlayColor) || ah) });
        })(r())]), v(_, y);
      }, $$slots: { default: !0 } });
    };
    return j(h, (p) => {
      u() && p(f);
    }), v(n, d), Ye(o);
  }
  Pn(["click"]), We(cu, { dealBlock: {}, multipleGiftsSelector: {}, products: {}, initialSelectedGifts: {}, isOpen: {}, onConfirm: {}, onClose: {} }, [], [], !0);
  var jp = $n('<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.00065 5.33337V10.6667M5.33398 8.00004H10.6673M14.6673 8.00004C14.6673 11.6819 11.6825 14.6667 8.00065 14.6667C4.31875 14.6667 1.33398 11.6819 1.33398 8.00004C1.33398 4.31814 4.31875 1.33337 8.00065 1.33337C11.6825 1.33337 14.6673 4.31814 14.6673 8.00004Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>');
  function uu(n) {
    v(n, jp());
  }
  We(uu, {}, [], [], !0);
  var Rp = D('<img alt="" class="kaching-bundles__free-gift__image"/>'), Qp = D('<div class="kaching-bundles__free-gift__image"></div>'), Np = D('<span class="kaching-bundles__free-gift__text"><!></span>'), Wp = D('<span class="kaching-bundles__free-gift__add-button"><!></span>'), Up = D('<div class="kaching-bundles__free-gift__full-price"><!></div>'), Hp = D('<div class="kaching-bundles__multiple-gifts-selector kaching-bundles__free-gift"><!> <div class="kaching-bundles__free-gift__main"><!> <span class="kaching-bundles__free-gift__content"><!> <!></span></div> <!> <!></div>');
  function du(n, t) {
    Je(t, !0);
    const r = () => Me(p, "$formatPrice", l), a = () => Me(_, "$translate", l), [l, c] = wt();
    let u = m(t, "dealBlock", 7), s = m(t, "multipleGiftsSelector", 7), i = m(t, "selectedVariants", 7), o = m(t, "otherProducts", 7), d = m(t, "onConfirm", 7), h = Ae(!1);
    const f = g(() => (s().products || []).flatMap((b) => {
      const B = Nt(b.id), G = o().find((H) => H.id === B);
      if (!G || !G.availableForSale) return [];
      const z = Xn(G);
      if (b.variantGIDs && b.variantGIDs.length > 0) {
        const H = b.variantGIDs.map(Nt);
        return { ...z, variants: z.variants.filter((Y) => H.includes(Y.id)) };
      }
      return z;
    })), p = cn(), _ = qt(), I = qn(), y = g(() => ru({ dealBlock: u(), imageSize: s().imageSize })), x = g(() => {
      if (s().mediaImageGID) return Me(I, "$getMediaImageUrl", l)(s().mediaImageGID);
    }), M = g(() => i().reduce((b, B) => b + B.quantity, 0)), A = g(() => e(M) >= s().maxQuantity), V = g(() => (function(b, B) {
      if (!B.length) return 0;
      let G = B.reduce((z, H) => z + H.fullPrice * H.quantity, 0);
      return B.some((z) => z.variant.compareAtPrice) && b.useProductCompareAtPrice && (G = Math.max(G, B.reduce((z, H) => z + (H.variant.compareAtPrice || 0), 0))), G;
    })(u(), i())), C = g(() => pn({ priceFormatter: r(), product: void 0, totalFullPrice: e(V), totalDiscountedPrice: 0, quantity: e(M), unitQuantity: null })), R = g(() => e(A) ? e(C)(a()(s().textAfterSelection)) : e(C)(a()(s().textBeforeSelection)));
    var U = { get dealBlock() {
      return u();
    }, set dealBlock(b) {
      u(b), k();
    }, get multipleGiftsSelector() {
      return s();
    }, set multipleGiftsSelector(b) {
      s(b), k();
    }, get selectedVariants() {
      return i();
    }, set selectedVariants(b) {
      i(b), k();
    }, get otherProducts() {
      return o();
    }, set otherProducts(b) {
      o(b), k();
    }, get onConfirm() {
      return d();
    }, set onConfirm(b) {
      d(b), k();
    } }, F = Hp(), se = P(F);
    {
      let b = g(() => {
        var B;
        return (B = e(R)) == null ? void 0 : B.replace(/<[^>]*>/g, "");
      });
      Qt(se, { element: "span", class: "kaching-bundles__multiple-gifts-selector__clickable-overlay", get "aria-label"() {
        return e(b);
      }, onclick: () => te(h, !0) });
    }
    var X = E(se, 2), K = P(X), J = (b) => {
      var B = Rp();
      be(() => {
        Pe(B, "src", e(x)), Pe(B, "height", s().imageSize || 0);
      }), v(b, B);
    }, N = (b) => {
      var B = De(), G = ve(B), z = (H) => {
        var Y = Qp();
        let L;
        be((O) => L = Wt(Y, "", L, O), [() => {
          var O;
          return { height: `${(O = s().imageSize) != null ? O : ""}px` };
        }]), v(H, Y);
      };
      j(G, (H) => {
        s().imageSize && H(z);
      }, !0), v(b, B);
    };
    j(K, (b) => {
      e(x) ? b(J) : b(N, !1);
    });
    var Z = E(K, 2), $ = P(Z), S = (b) => {
      var B = De();
      Ke(ve(B), () => e(R), (G) => {
        var z = Np();
        qe(P(z), () => e(R)), w(z), v(G, z);
      }), v(b, B);
    };
    j($, (b) => {
      e(R) && b(S);
    });
    var T = E($, 2), q = (b) => {
      var B = Wp();
      uu(P(B)), w(B), v(b, B);
    };
    j(T, (b) => {
      e(A) || b(q);
    }), w(Z), w(X);
    var W = E(X, 2), ue = (b) => {
      var B = De();
      Ke(ve(B), () => e(V), (G) => {
        var z = Up();
        qe(P(z), () => r()(e(V))), w(z), v(G, z);
      }), v(b, B);
    };
    j(W, (b) => {
      s().showPrice && e(V) > 0 && b(ue);
    }), cu(E(W, 2), { get dealBlock() {
      return u();
    }, get multipleGiftsSelector() {
      return s();
    }, get isOpen() {
      return e(h);
    }, get products() {
      return e(f);
    }, get initialSelectedGifts() {
      return i();
    }, get onConfirm() {
      return d();
    }, onClose: () => te(h, !1) }), w(F), be(() => {
      Pe(F, "data-multiple-gifts-selector-id", s().id), Wt(F, e(y));
    }), v(n, F);
    var Q = Ye(U);
    return c(), Q;
  }
  We(du, { dealBlock: {}, multipleGiftsSelector: {}, selectedVariants: {}, otherProducts: {}, onConfirm: {} }, [], [], !0);
  var Zp = D('<div class="kaching-bundles__free-gift__divider"></div>'), Jp = D("<!> <!>", 1);
  function Ja(n, t) {
    Je(t, !0);
    let r = m(t, "dealBlock", 7), a = m(t, "multipleGiftsSelectors", 7), l = m(t, "sellingPlan", 7), c = m(t, "otherProducts", 7), u = m(t, "onChange", 7), s = Ae(rt({})), i = g(() => a().filter((f) => !f.applyOnlyForSubscriptions || l()));
    function o(f, p) {
      const _ = a().find((I) => I.id === f);
      _ && (p.reduce((I, y) => I + y.quantity, 0) > _.maxQuantity || (e(s)[f] = p));
    }
    He(() => {
      const f = new Set(e(i).map((_) => _.id)), p = Object.entries(e(s)).filter(([_]) => f.has(_)).flatMap(([, _]) => _.map((I) => ({ id: I.id, quantity: I.quantity, variant: I.variant, product: I.product, fullPrice: I.fullPrice })));
      u()(p);
    });
    var d = { get dealBlock() {
      return r();
    }, set dealBlock(f) {
      r(f), k();
    }, get multipleGiftsSelectors() {
      return a();
    }, set multipleGiftsSelectors(f) {
      a(f), k();
    }, get sellingPlan() {
      return l();
    }, set sellingPlan(f) {
      l(f), k();
    }, get otherProducts() {
      return c();
    }, set otherProducts(f) {
      c(f), k();
    }, get onChange() {
      return u();
    }, set onChange(f) {
      u(f), k();
    } }, h = De();
    return Jt(ve(h), 19, () => e(i), (f) => f.id, (f, p, _) => {
      var I = Jp(), y = ve(I);
      {
        let A = g(() => e(s)[e(p).id] || []);
        du(y, { get dealBlock() {
          return r();
        }, get multipleGiftsSelector() {
          return e(p);
        }, get selectedVariants() {
          return e(A);
        }, onConfirm: o, get otherProducts() {
          return c();
        } });
      }
      var x = E(y, 2), M = (A) => {
        v(A, Zp());
      };
      j(x, (A) => {
        e(_) < e(i).length - 1 && A(M);
      }), v(f, I);
    }), v(n, h), Ye(d);
  }
  We(Ja, { dealBlock: {}, multipleGiftsSelectors: {}, sellingPlan: {}, otherProducts: {}, onChange: {} }, [], [], !0);
  var Yp = $n('<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M44.584 21H42.834V14C42.834 6.279 36.555 0 28.834 0C21.113 0 14.834 6.279 14.834 14V21H13.084C10.1907 21 7.83398 23.3543 7.83398 26.25V50.75C7.83398 53.6457 10.1907 56 13.084 56H44.584C47.4773 56 49.834 53.6457 49.834 50.75V26.25C49.834 23.3543 47.4773 21 44.584 21ZM19.5007 14C19.5007 8.85267 23.6867 4.66667 28.834 4.66667C33.9813 4.66667 38.1673 8.85267 38.1673 14V21H19.5007V14ZM31.1673 39.018V44.3333C31.1673 45.6213 30.1243 46.6667 28.834 46.6667C27.5436 46.6667 26.5007 45.6213 26.5007 44.3333V39.018C25.1123 38.2083 24.1673 36.7197 24.1673 35C24.1673 32.4263 26.2603 30.3333 28.834 30.3333C31.4076 30.3333 33.5007 32.4263 33.5007 35C33.5007 36.7197 32.5557 38.2083 31.1673 39.018Z" fill="currentColor" transform="translate(21.5, 22)"></path></svg>');
  function gu(n) {
    v(n, Yp());
  }
  We(gu, {}, [], [], !0);
  const hu = "data:image/webp;base64,UklGRoQYAABXRUJQVlA4WAoAAAAQAAAAVwEANAEAQUxQSPkFAAABBj/OtslttP9f5fcCagm1hVpF7YEJox4UKGYkeAMMGPfwDLTDZ1D2vIMIqAcB7VRSYECAAaEnwXBEmSwGHlrieL+jrjsiJgAn/5/8f/L/yf8n/w9iMzrDs9DBioEmgInM6NV1BfjS38jnJRbyl/z0anTfwYrRQgD4xYxeVQf15f0b+QwssfjtlYg8ExEHawBoId4gM3pV1dOX8AAqAJ+xRAb89pOcARg5wIrRQmAEM3p1XTXeAzefsVzIX/KTvBoBcIA10ELAMDOj366r1vXl/RuRz1gust9eicgzEXGwBtBCGD7m2avrqv19CcADFT4DS2T4TeQMeCbiYMVAC2FQkHn203XVyb563H8Glgv5S34SORsBcLBioAlAXyMz+q3qm+X9G5HPy4X89dsrkdEziIMVo0WE0IfIPHt1XfXc8mGP6jOwzH4TkTMAz0ScFTG9hORZdl31bo/Ko3rwM4DlT7Z30Cj7XA1D1zPot2o42l5BZ9WA/KlX2JshsdB9YlQOieW/woitwFY0TAjGOgRPdPd1x2BQlEurHcIoeSdS3S8gkMc/uW6hYVG9+wJUB/dr3SkYGEfeB1zlI7Y5undMVVwotvFHuk3cfSsGWoTuMxF2hQgArO5nAFIksUho+KOJvvLAZkz89KDfXxBPAfsJV2FvuAoXbLU2XIULzVW4NFyFc7bKHVdBiKvygKtwSVyVB1wF0W3iWCEft8mIFXCpW8TxQj5ukREvAKY9HDPk5y1ywwvILVfhnK1yx1bnxFTIHVfhnLgqD7gKl5qr8oCrcKm5Kp9wFXLDVZiwVW7ZatI8yxTIXeMcW6SNs1yB3HEVzomr8glX4ZK4Kh9zFS51sz4zRj7mKuSGqzBhK5gGGd7IJw2yvIFcmmOYA+dslVuuwuT/DpgRVyFgK6GmLNnDB1yFOTVDM4gPmmEYBHNqhOYQBGw1I67yAVdhRlzlHVdhTlyFoAELJpkRV3nHVmOuwpy4aq3rRnxi/mfOX/+rBa8YShsrIvxkL+ayB1Bxk5N9te+Ocgggc/UwUlade7fveX7vahFUHS37XuNxHPiUaiEddX/fXwC/PwrmfQeQ/gL4fgdIf4FHv+vp7OMPt+Ye+IPN2efwa80+nq0O/t8VHFsFPEN1cBzjJ4qB/EE+GX7araeJjLXioAeL3WqWxlHgrBZSdeWPTRqFzhqCqjt7+Ilq6r/vjP/tyjZGhtaVZClqtTaNodndsCnkkassTaLQWUNKv6vThWquWVflQClkt1pMkyiIEDhrNKlHKa7Rftwg6OSuHBjFbiVZEofOGk1QhwzrZJsEuFlV9r/i3ipDmkShs5rUUeVdbfwFNQsUbe76WyGyw9UUSRQ4azSpWka12Qeq8Ta962HFDqssjSV01mhStZZ3dZnr5oHGm7JH3V5lSKPQWaNJNTOsiR+rVjRJiV5TiOBWFtNEIgerSTWb4nrMqR0AN7vrJ4XsbldZLFHgjBZS7Sjv6rB3qjV1dFf2i1tZZWkSwllNUC0r747nJ6pN7awqu68Abq8W0yQKnDWaFEi1ssTH8hfUKqBgXXbdpyh01mhS7e/eHWemVdvai7su2i7eASh2K0mM6k7t4sWBygozo1o4WHdN7GC1IJHQGa06lmwYv/uhsgJSrVpZkrJTNkZ1vLZh/G57+wRgFajWdvNyQN0nG8bZpqgAwSzSqsUpKrvjk/SB+2TD8QShJdXyJu2MGfWF7qRgXXbDRA1vnZZd4MMBBrh1F9hBBh0dbSu3QCGyQ2M+6WEG2OmBtrKYJnHorAkTiQEri4b4RA12CrZPk8U0iQIHo0n9YNQQuOEGmHh7K1cyjSV01mhSB7bbZmQ05EDWQTRBHTlpxlgxqN02YaM5BHETJopF9aJ+K80jsNu6+UBxaVi3lNgE43ptjGLUoFZOsapd1GesmFXH25pEil9tXItIsaybHq0YK6YltzhKsQkU3+rw6nBFahTr6ujqMMVqTIp7TXT1Y8Uq0oqDTZTtnrLbTENRXCw2SJHdTyfOKGYmLUZInfx/8v/J/yf/n/xfUwBWUDggZBIAABBuAJ0BKlgBNQE+kUSdS6WjoyKjsKo4sBIJY27PfD3SSyKUjHn6I/9g+wnp1XR9XeHo4f/o+c8+z/svWv5h/PG/dj1H/tl6znpI/wG+5eif50XrR/4/0x7lbtfWHf5TxH7Mfb7NRhu8olZENf8uT5T92PZPIW8X7T682rzd4lnfXm1ebvEs7682rzd4lnfXm1ebvEs7682cCffkKj/0t06JEArP+RShHR4v2n15tXgarCFNF1ibE7/5+j/5Eo0NQ71kF8hWki+N0nFn4jermljPNs27mUeI5uTXaZCzZcqM9AZ31VHNeqhmXSx23Z8dlZD8ZLgOnx2CihtqzmhwsRfw/eimox4+fV6eEJSdr6tkyKOTLOnvmStQTaPNLcVmD06I09Zy8EdqnfHY/1ThdMVchaQQV9Czk/i57RyGMsSMid4Y5ZOoPpStMmO8jZqSCSIW4/wUhOsJe0AZ6WDNd9x5zXViysoni6q6+atjpl5A4ZI62UyqCiLbYjoKnTB7xff5zuxt3G0QiDSsrujnM51e8UgSobndmKsG7c87GZH5co4+UWdNOodvlgpKvlr7hqlF1cRHNor9k7pt9pIiAEYeVwoSNvwFplyxFu65+r+nXIwUbLR8xF9LPeZ2oTVkeqIkflO/9CzgZ7RhB6LLduY5ORVBLovgTZu3/QSKkDFShUs2FVKnB9lmICdwUzmUNmRSe0Ga6FsxyfdT/gQrVJY2mpe+QnRjhSbGOZcUpMsoVwsFkw3byx7SAunIxFL1TxePhC6fUfxCcdqHww8KiOjXdEXZJcLI7GUTe0nviV7Z/qFPWXNlIDS/JIszeV7nM8HpdPmdLEDK+MYaGUEL/wZsFblu2q1mU0SC8gaf+iYsqqUR2ld74gez3le4VQSRtOB9B/YLTsZfqcOjzW3/m6EHXNHKBFFsVFTpZmn4qMgVjJwf9P8cnItR6Fq7fOAslEO4e30AHZzsht3FP8GTJU1rAoYDv8k41Bg3f/c3i4TQIPpSjW5RcJV8JNBN1eawaXo9ZbN31YZSVQw8Ops/2bVbq9/s1Q1s9PunHUU+2ut0DDvCY/6iQ+2YthZQQ1GyDGUCpfQ3eJaANqy/p8rAbnON/3LplJEi/afXm1ebqaKUavN3iWd9ebV5u8SzvrzavN3iWd9ebV5u8SzvrzavN3iWd9ebV5u8LgAA/vvbO+3sHnP/IdkpDnbh3TvfXYAB5WzWlLuMAAKgIwAABAsU14K4XnDjt+rrb+D2R0m2FHkZuG6rmV+6YFzI/Ls2EEst1oHCIDkSkVmJwdSN9EIhanLXNhfekK1Iqx1IvcdGU5Q6TPJ89BkFWsH4P6w+AEaw8K0furvg3C+MmCPSi39Pk9u+gxEye7RHQx3e7sJBZSlSVpmGjma6gAJaYWfuB78fJroBwKlaJ0mMNd4azeh/Wa3EotpAl4KB176JCBofnI39MAuoo85WpbZ9xjxDQYsob4zBW0Iz7pbo/HiIkhee6DRpkJIr6wM5Ky5hmYHwSSvj+7kH1iIOCj6tAbabEAQCNQeVRTORaxyDAr7/GtCLaDWcs/7oXWIweUfirzVQ7ThYMPR9h8IVWCJYs5dn/dfu56GMoeSVL3vuDT8eOkQLrvbk7h5UKTxL57kgt6N+KFtV/n39fyoZGVhshZgWcPcsGXFGajPTSTOUlsZ/vewlCzkR+ALaPvm4/+MGM7HT0B28wt+z1iFe68rT2C3wDvd2pkd4kwT1ZXXhgCaP8IHGlcRLWtK0/KEVZ1ugqmbOqoEiTwSRYuEmJ28JT53qpD9rvw4bWSCRVmp6vS1i+OAvuw7ChW+RkrYvU/D24QzjPCHYio+CkhfgXvVO46aZf7HZ/APLJHJJzVT1j4OLgCKZ/+Ak1e0EKDPh4rTJsaT3s8WtTy5XH+4Ar6xg6I3WtxR+uRF26LUw4qh9rDq9Tp7vxD5TzVPNkmLExWNGgR6eVQ2GooMqhjhD639FbbGvPBA3ybzgr7n5Ci9s6Wz++LCWHCwK1Z6DT19WpGRfIsCWCkYCRTKxUtMZSIT8ucXjOXLVCOftRCEKFT4b6uZ65Ag8l6ZwGA9vBgVH4yjz3rhaTMXAVN8ZtMN+Peal4ByXEaarmBZHcjINdGAHfq/Oon/WJPDl1La0sZ/z7NnwnicGzYjOu/+E9PY1uiQDBcmka2MieoJp36IbjfvQLURbGUMf1OX6zyYoVSC8wZfYlktDUkqM9WhYE1c4nOaHYtnrCuOiEPng8J2pRFr5NeR4lIsiH6Z4wQDzOZbpOftV8uUhurbz6TTohG7rdsM3Jkpsl7NlcnTwTwO/wnsAVgCAexRRUegE8kK7ZBn9DYsKHGisummSWwi9LxZqPCQbjrkXNuWFu1L7NvVwRU/SFadxboS/0qrszn85S44QntIQB/YirAkqb9zp8cndyKm1JSLqd+B0ytCADHpsJ5tIRIRlqWiK5Z3mRpnoZ41mgopa3mx70p3vl/4dB9U/HbNxwGMVZwzqOJ1gtobOcYv4N4GE/9/PioYppduKcYUonHSe4/3qQSrq/d8AMj5fRlAEPwNdWGsNJAtAr1IMC662V61JfHP8ENdFsTmbbcZ6QaXRBgGH3IZfWJHt4aQK/pLXOPF01GqrLm+KfuiYRg9SdihgVqnSnWiOz5QJcoQdFYrwvdJTA3IDamLNiUdka/z2iBOCQPtqrUEsiyPhVyMRGkBWUEXUS8aojpuiFrHqEeODgQNvYmA4SrXVoiOOIDOC57cNsP1/N9GN0jE8bIPAwth4nEv26clftxesbpcO5CbbOPhk+4teaVMLwqEMkQ9YcYDhAn1UQm/P3PukbCh6OquvhSA8q9YvD80J2p4qMfqHujubJy+pt0+o+mrxgsrcdHWv4sSkPBRdjMUrDPZLvblU1bnNHivzRvFcaJLGb6GIGfB6O/ZKp1jWBT6xmKAeZWVJ8oOesDrGaYK0ecPFQz1Kuy5kORX5BCtS2qmcP0EA33Ytva164kYbJLPQqbkznx1MLByN1pC1Ik6afVhXF4Md0RY17gT2UjnSVYPmF/zPGsMRWvrtiSQRKgwUoxqgtEcfS49Laz2JMIExQJFfV3WrYgNICYlRLAYmV9ubjRL8xrrPJOxg49X/PpZMbndQYIsESJm+IzeXnBMrbIsdeaxHjknEDGyHgeDWKezmv60AaqcaQzwPQfmnJvj9esFQK1oEZOAhVQaNG82I3acJJ+sM/lNmSPy/iKzYyMHrpWAtqMiD/VbxffYGWdktLKJ6DnzcchVzvgkPeJ/AEYySCs/AJwxoZMCEcYNAyPbSOeIhrSZ7oiwkixKsfLQ+uMIecj3dpwHtZBxKdw3H1agydVHgrcDu2Q1YIvCW0l+YCBgLgVvKCQiJZrmECgugPITyU+7JPijpmGi92sUJDZaFi8AXbjw0XOTvpGBzk6SOQWbZRs0FTUb1nAizq0zZPFxm8JaADC02BSHVQUCf4x6YZrJ5DIRFyxt9Jv0pVBaCRRKAOO3/X/UVpzCGUfhHdRWh93s5eWczTMyYN1GHakkA3lEvMckdz9VSeaYVHWgbgR/SsKqHaFBCMqYnbGNHYulIdrf/P7sy9/cTd8B+MlqRCwfCgJvjATta1MfBNGzKLERRjPb2v9em/Re5JPZCtt6Yyn8Vql2CdRL+7z8oYczxwxTA3/QfjLD78pZ6RpVkzBIHLkMQf93Il10CGh5IawlF+d1dkgebUndWPL12ydwc0PVR3b0c0e8OlgN2vakaDpQEKqKPiIukcoIpAlgclG5W5zjdiPbIbF0uWeULQsvMvI9c5T6P9sRjv+FZz51d19aWCdbLU/fCFJ53MbT0+42wMhRj23n/iD+LlPYOSgdtfo9WiiRfl2Mt//MJzOsz8sFwteelxQEjbCqNE0JmRx+KBefHBDl8C78WHTaIIzN5gmbehbTat1ShJBF5hxBrYRIh2z4mEop3uaCco1qsvq44TnxUsBnbY1n8ApxtHL+I927cLgdz4OLFqdmFjrJQrQi6drim9ZhKNKblZRY6Nm6Xxw8AG31CjKw5Usm7EwX3dSh1ZsqmnI5qEjffuCX44g/SOzQqJVR7Fdb8JeHLF12m738y3FF8Mzs16Oc/2LwNUHONGYkVtr+DKAaGl5Hj/eNrGgDwmZkDKFiMx6NDt1/fJ5DJujHYvfqnc306fF1hqAKGhRaX6mkQAFTvdvjKAE6D2qcOgzuA8OW9wA45u64gX+kFxY0AS6eqgGGChj5Z/p1Hbf5M9a/gKoaZ7B+Tcnn9Qe9zU00N7zH8lyWGJ2TkauTtQK1NiJyMXrdamQmMdapyOTWCQuByf81ArLtC/bleHgTwNM7WM3WcgxuY0K+tM/GlMB3o4c6KXobq+gT4beks4Z0bY30MI8bvJO+Oxwdaw3i25dbrmfZF24MJSjUBqBgpoCPEKbOE1B0kKa0DivLYosxKI+LGXKRTQfmdgrSTks4ug6urIa/bOM7wPLDJGRj0VqBthQyVN68yQX1AJQMB25WapBsPo/4lBu682ATODwomExed5azFmo1uS1oR8yjjVguvGk0aXC8rbqCnjsujXvMr17GDqUjHgKsOJdqUSlNjxu2YRrqyCQqeDKyGUDulKhhtJLO/4E34Re0lA8JnM1OWPAEB4UWa3wXhCn7tYRx/NdlCvHEXRgHuU1x9vbx8wJIw9x9YMaMqgUz6XhCa9CHfb8w6Zw2YtPEVQ9evaBn1Z9D6FOmIHGya7+VzN5NHL4+s6mM/hIagdT2DfDbr34+S/pRYO0OTY2kNLBk7H0A60bCCr+dUfc3D4aiAWmcyJy06sV91x0NyHNPAl1cPP9yMhUpsXuSRb8G+rZqQPmfsDeGv8OazizGLy6WH/kvfkOHUSaX/OhgunoJ9VeEOXibNKy82aKQbeO0Ha7UVsW4XgQgLdDlwVIalDeTNcwE6nmQ9txE1hmG+EiJvFI4qtHDI9DsVu9oD7B+cGL3mjjXVHfSwugESEFWLTK5H6wNsIpftM4OHEYWyaeUeZ7JJE1eDJQ9Zf+5vZtZh3myMRpA2qFbL0Z1XGffNF+rkMit+fjRpAjeYiJtbPXt1caN1R1abhCgztNuwREE8wupCjEm+NE+bKPiOqlykwKJ3P/3sgKhNseT14hUvrpWzccNtRuPDNOunCTAmbmLE7WagpIdGYD1/+3+5jJokGgYMTKPDtGcyL2UcCJbWhsr29Eb7GipPp2p1cQ+vehDwOEv3Zy1JrpGaND/5dRLHQTBHj6cgEpGQusdOTAdDDuz3bIG0bjvrZlGPLGuLFq+K3yADMtsjQQcuZzrWixor2wnfJtn15LHqkqakk4OIH4/MIXBGBWj9Ew3Y10HyG9ozFVfGMMh335PDmgh/DSu4AxehAoAqANVIJksDFYdub1wWo8yYh9Bj1+NUJynOVXk1qJZ8+B0QUVbJwcTOnM/fCsUt191Vky7IpF3Ar+L7eVM3PjlEJmI9gteoSeJw1gQCSMn/vaR0rn0ffVV6ozTkXntDBDGW52GLCy/g/BPvfHCJ+mj59BncgboXK3Fld7/4HRTyIAexwL2dRVvPHlg99XnjymrE4zUzJo+KycEBb83WPH/fOR5kEC3NqBEAmTeVYw8LJ+ocQMM2lE8kDjcyA12K+DfSgIhetLBZ/x7e4hD9A4gQgdFg8Ooa3bg/sPXFSwRjyiDQM/CZXMUaKtADyJ4CAx3/pYYzgOk2cLMZz5FMWFjbA/Q1LtDuQH7DkigDvOhb4Fmu7+H2b5J+4EKM8Yq+n06V/1tcpC4eeFk9xnMQluO1WqGwpuaoJCMP6qbU+yD7yNgJf9w5qrzxpGutPV9IhfsC4fqgGPBE3L7RVEgzeANeYJVlr36U8sZvtXG4PB4Hja+RPLUAO+eRxzRZy42p9LU83OprZBeO7230dieMH5Zoi0kR9fsCoTSMaa2nRhSiCb2tdJ4Z1lzYagv4odW8u2KOdSTmmMx6fuTxSqnpbix/IM1tyQ87iEvmLgKbKxxoq7jMWMGVKnT3/sYDe1Gh7sGkfO8X+SU8A6uPjQ5O60Qodizt/a/N+H663+1H+KNqX9JG3V8a4DIr7ksqFOrG4vcwrmMfGNKzZEqY3YdfhK186TnkB4qAAAAAAAAUL6grl/NBh0xCf2j3r4dOzXRh7I2aCCSe5vWpAob7xObCtSNwZb2vrH2mGahZz5v19m0OpjZMD/eZuwAQT9lzRvhNLg3peoff6JaWOXAZuxTigRvsWkffJzmaqRu1XRn2I5Q8LDKQ102v7qO1JV8AAAAAAAAAAAAAAAAAAAA=";
  var Kp = D('<img alt="" class="kaching-bundles__deal-bar-progressive-gift__image"/>'), Xp = D('<span class="kaching-bundles__deal-bar-progressive-gift__lock-icon kaching-bundles__deal-bar-progressive-gift__image"><!></span>'), ef = D('<img class="kaching-bundles__deal-bar-progressive-gift__image"/>'), tf = D('<span class="kaching-bundles__deal-bar-progressive-gift__text"><!></span>'), nf = D('<span class="kaching-bundles__deal-bar-progressive-gift__text"><!></span>'), rf = D('<span class="kaching-bundles__deal-bar-progressive-gift__label-crossed-out"><!></span>'), af = D('<span class="kaching-bundles__deal-bar-progressive-gift__label"><!> <!></span>'), lf = D('<div><div class="kaching-bundles__deal-bar-progressive-gift__main"><!> <div class="kaching-bundles__deal-bar-progressive-gift__content"><!> <!></div></div> <!></div>');
  function pu(n, t) {
    Je(t, !0);
    const r = () => Me(y, "$config", c), a = () => Me(p, "$translate", c), l = () => Me(I, "$getMediaImageUrl", c), [c, u] = wt(), s = m(t, "progressiveGifts", 7), i = m(t, "gift", 7), o = m(t, "product", 7), d = m(t, "selectedDealBarIndex", 7), h = m(t, "selected", 7), f = m(t, "onChange", 7), p = qt(), _ = cn(), I = qn(), y = on(), x = g(() => i().differentVariantsEnabled), M = g(() => {
      var b;
      return o() ? i().variantGIDs ? i().variantGIDs.map(Nt) : (b = o()) == null ? void 0 : b.variants.map((B) => B.id) : null;
    }), A = g(() => {
      if (o()) return { ...o(), variants: o().variants.filter((b) => (r().preview || b.availableForSale) && (!e(M) || e(M).includes(b.id))) };
    });
    let V = Ae(rt([]));
    const C = g(() => (function(b, B, G) {
      return b.length > 0 ? b : B != null && B.availableForSale && B.variants.length > 0 ? Array.from({ length: G }, () => B.variants[0].id) : [];
    })(e(V), e(A), i().quantity)), R = g(() => o() && e(C).length > 0 ? e(C).map((b) => o().variants.find((B) => B.id === b)).filter((b) => b !== void 0) : []), U = g(() => {
      var b;
      return pn({ priceFormatter: Me(_, "$formatPrice", c), product: o(), totalFullPrice: ((b = e(R)) == null ? void 0 : b.reduce((B, G) => {
        var z;
        return B + ((z = G == null ? void 0 : G.price) != null ? z : 0);
      }, 0)) || 0, totalDiscountedPrice: 0, quantity: i().quantity, unitQuantity: er(e(R).map((B) => ({ variant: B, quantity: 1 }))) });
    }), F = g(() => e(U)(a()(i().title))), se = g(() => e(U)(a()(i().lockedTitle))), X = g(() => e(U)(a()(i().label))), K = g(() => e(U)(a()(i().labelCrossedOut))), J = g(() => d() === null || i().unlockAtBar > d() + 1), N = g(() => {
      var b, B, G;
      return i().giftType === "shipping" ? hu : ((B = (b = e(R)) == null ? void 0 : b[0]) == null ? void 0 : B.image) || ((G = o()) == null ? void 0 : G.image);
    }), Z = g(() => i().mediaImageGID ? l()(i().mediaImageGID) : e(N)), $ = g(() => s().dealBarStyle && l()(s().dealBarStyle.lockedMediaImageGID));
    He(() => {
      if (h()) if (o() && e(R) && !e(J)) {
        const b = Object.values(e(R).reduce((B, G) => (B[G.id] ? B[G.id].quantity += 1 : B[G.id] = { variant: G, quantity: 1 }, B), {}));
        Xt(() => f()({ product: o(), variants: b }));
      } else Xt(() => f()(void 0));
      else Xt(() => f()(void 0));
    }), Hn(() => {
      i().productGID, te(V, [], !0);
    }), He(() => {
      e(J) && e(Z) && (new Image().src = e(Z));
    });
    const S = g(() => {
      var b;
      return i().giftType === "product" && !((b = o()) != null && b.availableForSale);
    });
    var T = { get progressiveGifts() {
      return s();
    }, set progressiveGifts(b) {
      s(b), k();
    }, get gift() {
      return i();
    }, set gift(b) {
      i(b), k();
    }, get product() {
      return o();
    }, set product(b) {
      o(b), k();
    }, get selectedDealBarIndex() {
      return d();
    }, set selectedDealBarIndex(b) {
      d(b), k();
    }, get selected() {
      return h();
    }, set selected(b) {
      h(b), k();
    }, get onChange() {
      return f();
    }, set onChange(b) {
      f(b), k();
    } }, q = De(), W = ve(q), ue = (b) => {
      var B = De(), G = ve(B), z = (H) => {
        var Y = lf();
        let L;
        var O = P(Y), ae = P(O), ee = (ye) => {
          var Se = De(), Ve = ve(Se), Ee = (ge) => {
            var Te = Kp();
            be(() => Pe(Te, "src", e($))), v(ge, Te);
          }, ne = (ge) => {
            var Te = Xp();
            gu(P(Te)), w(Te), v(ge, Te);
          };
          j(Ve, (ge) => {
            e($) ? ge(Ee) : ge(ne, !1);
          }), v(ye, Se);
        }, le = (ye) => {
          var Se = De(), Ve = ve(Se), Ee = (ne) => {
            var ge = ef();
            be(() => {
              var Te, pe;
              Pe(ge, "src", e(Z)), Pe(ge, "alt", (pe = (Te = o()) == null ? void 0 : Te.title) != null ? pe : "");
            }), v(ne, ge);
          };
          j(Ve, (ne) => {
            e(Z) && ne(Ee);
          }, !0), v(ye, Se);
        };
        j(ae, (ye) => {
          e(J) ? ye(ee) : ye(le, !1);
        });
        var re = E(ae, 2), fe = P(re), ze = (ye) => {
          var Se = tf();
          qe(P(Se), () => e(se)), w(Se), v(ye, Se);
        }, ce = (ye) => {
          var Se = De(), Ve = ve(Se), Ee = (ne) => {
            var ge = nf();
            qe(P(ge), () => e(F)), w(ge), v(ne, ge);
          };
          j(Ve, (ne) => {
            e(F) && ne(Ee);
          }, !0), v(ye, Se);
        };
        j(fe, (ye) => {
          e(J) ? ye(ze) : ye(ce, !1);
        });
        var ie = E(fe, 2), ke = (ye) => {
          var Se = De();
          Jt(ve(Se), 17, () => ({ length: e(x) ? i().quantity : 1 }), Zr, (Ve, Ee, ne) => {
            var ge = De(), Te = ve(ge), pe = (de) => {
              {
                let $e = g(() => e(x) ? ne + 1 : void 0);
                Mn(de, { get product() {
                  return e(A);
                }, get selectedVariantId() {
                  return e(C)[ne];
                }, get number() {
                  return e($e);
                }, forceDropdown: !0, onChange: (je) => (function(st, pt) {
                  e(x) ? te(V, [...e(C).slice(0, pt), st, ...e(C).slice(pt + 1)], !0) : te(V, Array.from({ length: i().quantity }, () => st), !0);
                })(je, ne) });
              }
            };
            j(Te, (de) => {
              e(C)[ne] !== void 0 && de(pe);
            }), v(Ve, ge);
          }), v(ye, Se);
        };
        j(ie, (ye) => {
          h() && !e(J) && e(A) && e(A).variants.length > 1 && e(C).length > 0 && ye(ke);
        }), w(re), w(O);
        var we = E(O, 2), _e = (ye) => {
          var Se = De(), Ve = ve(Se), Ee = (ne) => {
            var ge = af(), Te = P(ge), pe = (je) => {
              var st = De();
              qe(ve(st), () => e(X)), v(je, st);
            };
            j(Te, (je) => {
              e(X) && je(pe);
            });
            var de = E(Te, 2), $e = (je) => {
              var st = rf();
              qe(P(st), () => e(K)), w(st), v(je, st);
            };
            j(de, (je) => {
              e(K) && je($e);
            }), w(ge), v(ne, ge);
          };
          j(Ve, (ne) => {
            e(J) && !s().showLockedGiftLabels || ne(Ee);
          }), v(ye, Se);
        };
        j(we, (ye) => {
          (e(X) || e(K)) && ye(_e);
        }), w(Y), be((ye) => L = Ot(Y, 1, "kaching-bundles__deal-bar-progressive-gift", null, L, ye), [() => ({ "kaching-bundles__deal-bar-progressive-gift--locked": e(J), "kaching-bundles__deal-bar-progressive-gift--out-of-stock": r().preview && e(S) })]), v(H, Y);
      };
      j(G, (H) => {
        var Y;
        (o() && ((Y = e(R)) != null && Y.length) || i().giftType === "shipping") && H(z);
      }), v(b, B);
    };
    j(W, (b) => {
      e(J) && s().hideLockedGifts || b(ue);
    }), v(n, q);
    var Q = Ye(T);
    return u(), Q;
  }
  We(pu, { progressiveGifts: {}, gift: {}, product: {}, selectedDealBarIndex: {}, selected: {}, onChange: {} }, [], [], !0);
  var sf = D('<div class="kaching-bundles__deal-bar-progressive-gifts"></div>');
  function Ya(n, t) {
    Je(t, !0);
    const [r, a] = wt(), l = m(t, "progressiveGifts", 7), c = m(t, "dealBlock", 7), u = m(t, "dealBar", 7), s = m(t, "otherProducts", 7), i = m(t, "selectedDealBarIndex", 7), o = m(t, "selected", 7), d = m(t, "onChange", 7), h = g(() => c().dealBars.findIndex((C) => C.id === u().id)), f = on();
    let p = Ae(rt({}));
    const _ = g(() => {
      var C, R;
      return ((U) => U ? hn({ "kaching-deal-bar-progressive-gift-image-size": U.imageSize + "px", "kaching-deal-bar-progressive-gift-corner-radius": U.cornerRadius + "px", "kaching-deal-bar-progressive-gift-label-background-color": Re(U.labelBackgroundColor), "kaching-deal-bar-progressive-gift-label-text-color": Re(U.labelTextColor), "kaching-deal-bar-progressive-gift-label-text-size": U.labelTextSize + "px", "kaching-deal-bar-progressive-gift-text-color": Re(U.textColor), "kaching-deal-bar-progressive-gift-selected-text-color": Re(U.selectedTextColor), "kaching-deal-bar-progressive-gift-text-size": U.textSize + "px", "kaching-deal-bar-progressive-gift-locked-label-background-color": Re(U.lockedLabelBackgroundColor), "kaching-deal-bar-progressive-gift-locked-label-text-color": Re(U.lockedLabelTextColor), "kaching-deal-bar-progressive-gift-locked-label-text-size": U.lockedLabelTextSize + "px", "kaching-deal-bar-progressive-gift-locked-text-color": Re(U.lockedTextColor), "kaching-deal-bar-progressive-gift-locked-text-size": U.lockedTextSize + "px", "kaching-deal-bar-progressive-gift-locked-icon-color": Re(U.lockedIconColor) }) : "")((R = (C = c().progressiveGifts) == null ? void 0 : C.dealBarStyle) != null ? R : null);
    }), I = g(() => {
      var C, R, U;
      return (U = (R = (C = l()) == null ? void 0 : C.gifts) == null ? void 0 : R.filter((F) => F.unlockAtBar <= e(h) + 1).flatMap((F) => {
        const se = F.giftType === "product" && F.productGID ? s().find((K) => K.id === Nt(F.productGID)) : void 0;
        if (!Me(f, "$config", r).preview && F.giftType === "product" && !(se != null && se.availableForSale)) return [];
        const X = se && Xn(se);
        return { gift: F, product: X };
      })) != null ? U : [];
    });
    var y = { get progressiveGifts() {
      return l();
    }, set progressiveGifts(C) {
      l(C), k();
    }, get dealBlock() {
      return c();
    }, set dealBlock(C) {
      c(C), k();
    }, get dealBar() {
      return u();
    }, set dealBar(C) {
      u(C), k();
    }, get otherProducts() {
      return s();
    }, set otherProducts(C) {
      s(C), k();
    }, get selectedDealBarIndex() {
      return i();
    }, set selectedDealBarIndex(C) {
      i(C), k();
    }, get selected() {
      return o();
    }, set selected(C) {
      o(C), k();
    }, get onChange() {
      return d();
    }, set onChange(C) {
      d(C), k();
    } }, x = De(), M = ve(x), A = (C) => {
      var R = sf();
      Jt(R, 21, () => e(I), ({ gift: U, product: F }) => U.id, (U, F) => {
        let se = () => e(F).gift;
        pu(U, { get selectedDealBarIndex() {
          return i();
        }, get selected() {
          return o();
        }, get gift() {
          return se();
        }, get product() {
          return e(F).product;
        }, get progressiveGifts() {
          return l();
        }, onChange: (X) => (function(K, J) {
          if (J ? e(p)[K] = J : delete e(p)[K], !o()) return;
          const N = Object.entries(e(p)).map(([Z, $]) => ({ id: Z, variants: $.variants, product: $.product }));
          d()(N);
        })(se().id, X) });
      }), w(R), be(() => Wt(R, e(_))), v(C, R);
    };
    j(M, (C) => {
      var R;
      c().progressiveGiftsEnabled && ((R = l()) == null ? void 0 : R.layout) === "deal-bar" && e(I).length > 0 && C(A);
    }), v(n, x);
    var V = Ye(y);
    return a(), V;
  }
  We(Ya, { progressiveGifts: {}, dealBlock: {}, dealBar: {}, otherProducts: {}, selectedDealBarIndex: {}, selected: {}, onChange: {} }, [], [], !0);
  var of = $n('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>');
  function fu(n) {
    v(n, of());
  }
  We(fu, {}, [], [], !0);
  var cf = $n('<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3307 4L5.9974 11.3333L2.66406 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>');
  function bu(n) {
    v(n, cf());
  }
  We(bu, {}, [], [], !0);
  var uf = $n('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="3" fill="currentColor"></circle></svg>');
  function vu(n) {
    v(n, uf());
  }
  We(vu, {}, [], [], !0);
  var df = $n('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>');
  function _u(n) {
    v(n, df());
  }
  We(_u, {}, [], [], !0);
  var gf = $n('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2787 3.45332C11.5092 2.98638 11.6245 2.75291 11.7809 2.67831C11.917 2.61341 12.0752 2.61341 12.2113 2.67831C12.3677 2.75291 12.483 2.98638 12.7135 3.45332L14.9002 7.88328C14.9682 8.02113 15.0022 8.09006 15.0519 8.14358C15.096 8.19096 15.1488 8.22935 15.2074 8.25662C15.2736 8.28742 15.3497 8.29854 15.5018 8.32077L20.3931 9.03571C20.9082 9.11099 21.1657 9.14863 21.2849 9.27444C21.3886 9.38389 21.4373 9.5343 21.4176 9.68377C21.3949 9.85558 21.2085 10.0372 20.8356 10.4004L17.2975 13.8464C17.1873 13.9538 17.1321 14.0076 17.0965 14.0715C17.065 14.128 17.0448 14.1902 17.037 14.2545C17.0282 14.3271 17.0412 14.403 17.0672 14.5547L17.9021 19.4221C17.9901 19.9355 18.0341 20.1922 17.9514 20.3445C17.8794 20.477 17.7514 20.57 17.6032 20.5975C17.4327 20.6291 17.2022 20.5078 16.7412 20.2654L12.3685 17.9658C12.2322 17.8942 12.1641 17.8584 12.0923 17.8443C12.0288 17.8318 11.9634 17.8318 11.8999 17.8443C11.8281 17.8584 11.76 17.8942 11.6237 17.9658L7.25102 20.2654C6.79001 20.5078 6.55951 20.6291 6.38907 20.5975C6.24078 20.57 6.11282 20.477 6.04083 20.3445C5.95809 20.1922 6.00212 19.9355 6.09017 19.4221L6.92498 14.5547C6.95101 14.403 6.96402 14.3271 6.95521 14.2545C6.94742 14.1902 6.92721 14.128 6.8957 14.0715C6.86012 14.0076 6.80497 13.9538 6.69468 13.8464L3.15665 10.4004C2.78376 10.0372 2.59731 9.85558 2.57462 9.68377C2.55488 9.5343 2.60365 9.38389 2.70734 9.27444C2.82653 9.14863 3.08407 9.11099 3.59914 9.03571L8.4904 8.32077C8.64252 8.29854 8.71857 8.28742 8.78481 8.25662C8.84346 8.22935 8.89626 8.19096 8.94028 8.14358C8.99 8.09006 9.02402 8.02113 9.09207 7.88328L11.2787 3.45332Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>');
  function ku(n) {
    v(n, gf());
  }
  We(ku, {}, [], [], !0);
  var hf = $n('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 22V11M2 13V20C2 21.1046 2.89543 22 4 22H17.4262C18.907 22 20.1662 20.9197 20.3914 19.4562L21.4683 12.4562C21.7479 10.6389 20.3418 9 18.5032 9H15C14.4477 9 14 8.55228 14 8V4.46584C14 3.10399 12.896 2 11.5342 2C11.2093 2 10.915 2.1913 10.7831 2.48812L7.26394 10.4061C7.10344 10.7673 6.74532 11 6.35013 11H4C2.89543 11 2 11.8954 2 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>');
  function mu(n) {
    v(n, hf());
  }
  We(mu, {}, [], [], !0);
  var pf = D('<span class="kaching-bundles__highlights__icon"><img alt=""/></span>'), ff = D('<span class="kaching-bundles__highlights__icon"><!></span>'), bf = D('<div class="kaching-bundles__highlights__item"><!> <span class="kaching-bundles__highlights__text"><!></span></div>'), vf = D('<div class="kaching-bundles__highlights"></div>');
  function ea(n, t) {
    Je(t, !0);
    const [r, a] = wt(), l = m(t, "highlights", 7), c = m(t, "isSelected", 7), u = m(t, "replaceLiquid", 7), s = qn(), i = { checkmark: bu, dot: vu, arrow: fu, star: ku, heart: _u, "thumbs-up": mu }, o = qt(), d = g(() => l().items.map((V) => Me(o, "$translate", r)(V)).map((V) => u() ? u()(V) : V).filter((V) => V !== "")), h = g(() => ((V) => hn({ "kaching-highlights-icon-color": Re(V.iconColor), "kaching-highlights-text-color": Re(V.textColor), "kaching-highlights-icon-size": V.size + 2 + "px", "kaching-highlights-text-size": V.size + "px" }))(l())), f = g(() => {
      var V;
      return (V = l().iconType) != null ? V : "checkmark";
    }), p = g(() => i[e(f)]), _ = g(() => {
      var V;
      return e(f) === "custom" ? Me(s, "$getMediaImageUrl", r)((V = l().customIconGID) != null ? V : null) : void 0;
    });
    var I = { get highlights() {
      return l();
    }, set highlights(V) {
      l(V), k();
    }, get isSelected() {
      return c();
    }, set isSelected(V) {
      c(V), k();
    }, get replaceLiquid() {
      return u();
    }, set replaceLiquid(V) {
      u(V), k();
    } }, y = De(), x = ve(y), M = (V) => {
      var C = vf();
      Jt(C, 21, () => e(d), Zr, (R, U) => {
        var F = bf(), se = P(F), X = (N) => {
          var Z = pf(), $ = P(Z);
          w(Z), be(() => Pe($, "src", e(_))), v(N, Z);
        }, K = (N) => {
          var Z = De(), $ = ve(Z), S = (T) => {
            var q = ff();
            (function(W, ue, Q) {
              dt && ar();
              var b, B, G = W, z = null;
              function H() {
                B && ($r(B), B = null), B = z, z = null;
              }
              Ar(() => {
                if (b !== (b = ue())) {
                  if (b) {
                    var Y = G;
                    z = xn(() => Q(Y, b));
                  }
                  H();
                }
              }, Da), dt && (G = Mt);
            })(P(q), () => e(p), (W, ue) => {
              ue(W, {});
            }), w(q), v(T, q);
          };
          j($, (T) => {
            e(p) && T(S);
          }, !0), v(N, Z);
        };
        j(se, (N) => {
          e(f) === "custom" && e(_) ? N(X) : N(K, !1);
        });
        var J = E(se, 2);
        qe(P(J), () => e(U)), w(J), w(F), v(R, F);
      }), w(C), be(() => Wt(C, e(h))), v(V, C);
    };
    j(x, (V) => {
      e(d).length > 0 && (!l().showOnlyWhenSelected || c()) && V(M);
    }), v(n, y);
    var A = Ye(I);
    return a(), A;
  }
  function _f(n, t, r, a) {
    t()({ dealBarId: r().id, dealBarQuantity: a(r()), preselected: !1 });
  }
  We(ea, { highlights: {}, isSelected: {}, replaceLiquid: {} }, [], [], !0);
  var kf = D('<img class="kaching-bundles__bar-image" alt=""/>'), mf = D('<div class="kaching-bundles__bar-radio"></div>'), yf = D('<span class="kaching-bundles__bar-title"><!></span>'), xf = D('<span class="kaching-bundles__bar-label"><!></span>'), wf = D('<div class="kaching-bundles__bar-subtitle"><!></div>'), Pf = D('<div class="kaching-bundles__bar-full-price"><!></div>'), Sf = D('<div class="kaching-bundles__bar-price"><!></div>'), Cf = D('<div class="kaching-bundles__bar-full-price"><!></div>'), Bf = D('<div class="kaching-bundles__bar-pricing-row kaching-bundles__bar-pricing-row--secondary"><!> <!></div>'), If = D('<div class="kaching-bundles__bar-pricing-row kaching-bundles__bar-pricing-row--main"><!> <!></div> <!>', 1), Mf = D('<div class="kaching-bundles__bar-full-price"><!></div>'), Df = D('<div class="kaching-bundles__bar-unit-price"><!> </div>'), zf = D('<div class="kaching-bundles__bar-pricing-row kaching-bundles__bar-pricing-row--primary"><!> <!></div> <div class="kaching-bundles__bar-pricing-row kaching-bundles__bar-pricing-row--secondary"><!></div>', 1), Af = D('<div class="kaching-bundles__bar-full-price"><!></div>'), $f = D("<!> <!>", 1), qf = D('<!> <div class="kaching-bundles__bar-content"><div class="kaching-bundles__bar-content-left"><div class="kaching-bundles__bar-first-line"><!> <!></div> <div class="kaching-bundles__bar-second-line"><!> <!></div></div> <div class="kaching-bundles__bar-pricing"><!></div></div>', 1), Vf = D('<div class="kaching-bundles__bar-selling-plan"><!></div>'), Tf = D('<div class="kaching-bundles__bar-variant-selector-wrapper"><!> <!></div>'), Gf = D('<div class="kaching-bundles__bar-variants"><!> <!></div>'), Of = D('<div><input type="radio"/> <label><!> <div class="kaching-bundles__bar-wrapper"><!> <!> <!> <!> <!> <!></div> <!> <!> <!> <!></label> <!></div>');
  function Bs(n, t) {
    Je(t, !0);
    const r = () => Me(N, "$config", u), a = () => Me(K, "$formatPrice", u), l = () => Me(X, "$translate", u), c = () => Me(J, "$getMediaImageUrl", u), [u, s] = wt();
    let i = m(t, "dealBlock", 7), o = m(t, "dealBar", 7), d = m(t, "product", 7), h = m(t, "otherProducts", 23, () => []), f = m(t, "complementaryProducts", 23, () => []), p = m(t, "customQuantity", 7, void 0), _ = m(t, "currentVariantId", 7, void 0), I = m(t, "componentId", 7), y = m(t, "selected", 7, !1), x = m(t, "globalSellingPlan", 7, void 0), M = m(t, "selectedDealBarIndex", 7), A = m(t, "onProgressiveGiftsChange", 7), V = m(t, "onDealBarSelect", 7), C = m(t, "onDealBarDeselect", 7), R = m(t, "onVariantSelect", 7), U = m(t, "onVariantsChange", 7), F = m(t, "onPersonalisationsChange", 7), se = m(t, "personalisationInitialValues", 23, () => []);
    const X = qt(), K = cn(), J = qn(), N = on();
    let Z = Ae(rt([])), $ = Ae(rt([])), S = Ae(rt([]));
    const T = g(() => i().priceRounding ? { perItem: i().showPricesPerItem, precision: i().priceRoundingPrecision, v2: r().featureFlags.price_rounding_v2 || !1 } : void 0), q = g(() => {
      var xe, Xe;
      return i() && ((Xe = (xe = i().defaultVariantsV2) == null ? void 0 : xe.find((ut) => Nt(ut.productGID) === d().id && ut.dealBarId === o().id)) == null ? void 0 : Xe.variantGIDs) || [];
    });
    let W = g(() => b(o())), ue = Ae(rt(b(o())));
    Hn(() => {
      te(ue, e(W), !0);
    });
    const Q = g(() => p() || e(ue));
    function b(xe) {
      return xe.dealBarType === "bxgy" ? xe.buyQuantity + xe.getQuantity : Number(xe.quantity);
    }
    let B = Ae(rt([])), G = Ae(rt([]));
    He(() => {
      const xe = (function(Xe, ut, he) {
        let Oe = [];
        for (let Ie = 0; Ie < Xe; Ie++) {
          let Fe = ut[Ie];
          if (!Fe && Xe > b(o()) && ut.filter((Ue) => Ue).length === b(o()) && (Fe = ut[ut.length - 1]), Fe) {
            const Ue = Nt(Fe);
            if (d().variants.find((ct) => ct.id == Ue)) {
              Oe.push(Ue);
              continue;
            }
          }
          he && Oe.push(he);
        }
        return Oe;
      })(e(Q), e(q), _());
      if (JSON.stringify(e(B)) !== JSON.stringify(xe)) {
        const Xe = e(B).length === xe.length;
        te(B, xe, !0), e(G).length === 0 || Xe ? te(G, xe, !0) : te(G, (function(ut, he) {
          const Oe = ut[ut.length - 1];
          if (ut.length < he) {
            const Ie = he - ut.length;
            return [...ut, ...Array(Ie).fill(Oe)];
          }
          return ut.slice(0, he);
        })(e(G), e(Q)), !0);
      }
    });
    const z = g(() => de(e(G))), H = g(() => (function(xe, Xe, ut) {
      return ut.map(({ variant: Oe, quantity: Ie }) => {
        let Fe = Oe.price;
        const Ue = xe.useProductCompareAtPrice || (Xe.dealBarType === void 0 || Xe.dealBarType === "quantity-break") && Xe.discountType === "default";
        return Oe.compareAtPrice && Ue && (Fe = Math.max(Fe, Oe.compareAtPrice)), Fe * Ie;
      }).reduce((Oe, Ie) => Oe + Ie, 0);
    })(i(), o(), e(z))), Y = g(() => Math.ceil(e(H) / e(Q)));
    let L = Ae(void 0);
    const O = g(() => Di(d(), e(z).map((xe) => xe.variant))), ae = g(() => {
      var xe, Xe;
      return (o().sellingPlanEnabled || i().subscriptionsEnabled && ((xe = i().subscriptions) == null ? void 0 : xe.layout) === "link" && ((Xe = i().subscriptions) == null ? void 0 : Xe.subscribeByDefault)) && (!i().subscriptionsEnabled || !!x());
    }), ee = g(() => e(ae) ? ms(o(), e(O), e(L)) : void 0), le = g(() => ys(e(ee), x(), e(O), d().requiresSellingPlan)), re = g(() => i() && Ve(e(z), e(le))), fe = g(() => e(z)[0] && _s(e(z)[0].variant)), ze = g(() => er(e(z))), ce = g(() => e(ze) ? e(re) / e(ze) : null), ie = g(() => pn({ priceFormatter: a(), product: d(), totalFullPrice: e(H), totalDiscountedPrice: e(re), quantity: e(Q), dealBar: o(), legacySavedPercentage: r().featureFlags.legacy_saved_percentage || !1, unitQuantity: e(ze), sellingPlan: e(le) })), ke = g(() => e(ie)(l()(o().title))), we = g(() => e(ie)(l()(o().subtitle))), _e = g(() => e(ie)(l()(o().label))), ye = g(() => e(ie)(l()(o().badgeText))), Se = g(() => c()(o().badgeImageGID));
    function Ve(xe, Xe) {
      switch (o().dealBarType) {
        case void 0:
        case "quantity-break":
          return Kc(o(), xe, r().currencyRate, e(T), Xe, r().featureFlags.percentage_cents_rounding_workaround);
        case "bxgy":
          return Xc(o(), xe, r().currencyRate, e(T), Xe);
      }
    }
    const Ee = g(() => Math.ceil(e(re) / e(Q))), ne = g(() => e(H) > e(re)), ge = g(() => e(Q) && (function(xe) {
      return !xe.differentVariantsEnabled || d().variants.length === 1 ? !1 : xe.hideVariantPicker ? !0 : !(e(Q) == 1 && !xe.showVariantsForSingleQuantity);
    })(i())), Te = g(() => r().featureFlags.variant_images && new Set(d().variants.map((xe) => xe.image).filter((xe) => xe)).size > 1), pe = g(() => `${o().id}_${I()}`);
    function de(xe) {
      return xe.reduce((Xe, ut) => {
        const he = Xe.find(({ variant: Oe }) => Oe.id === ut);
        if (he) he.quantity += 1;
        else {
          const Oe = d().variants.find((Ie) => Ie.id === ut);
          if (!Oe) return Xe;
          Xe.push({ variant: Oe, quantity: 1 });
        }
        return Xe;
      }, []);
    }
    ba(() => {
      y() && V()({ dealBarId: o().id, dealBarQuantity: b(o()), preselected: !0 });
    });
    const $e = g(() => c()(o().mediaImageGID) || zi);
    He(() => {
      y() && (e(G), e(S), e(Z), e($), e(le), Xt(() => {
        (function() {
          if (!e(G).length) return;
          const xe = de(e(G)), Xe = e(re) + e(S).reduce((Fe, Ue) => Fe + Ue.discountedPrice, 0), ut = e(H) + e(S).reduce((Fe, Ue) => Fe + Ue.fullPrice, 0) + e(Z).reduce((Fe, Ue) => Fe + Ue.fullPrice, 0) + e($).reduce((Fe, Ue) => Fe + Ue.fullPrice * Ue.quantity, 0), he = Ve(e(z), void 0), Oe = d().sellingPlans.map((Fe) => ({ sellingPlanId: Fe.id, discountedPrice: Ve(e(z), Fe) })), Ie = { discountedPrice: Xe, fullPrice: ut, discountedPricePerItem: e(Ee), fullPricePerItem: e(Y), discountedPriceWithoutSellingPlan: he, discountedPricesForSellingPlans: Oe };
          U()({ variants: xe, freeGifts: [...e(Z), ...e($)], upsells: e(S), dealBarSellingPlan: e(ee), pricing: Ie });
        })();
      }));
    });
    const je = g(() => o().showAsSoldOutEnabled && o().showAsSoldOut ? $i(o().showAsSoldOut) : "");
    var st = { get dealBlock() {
      return i();
    }, set dealBlock(xe) {
      i(xe), k();
    }, get dealBar() {
      return o();
    }, set dealBar(xe) {
      o(xe), k();
    }, get product() {
      return d();
    }, set product(xe) {
      d(xe), k();
    }, get otherProducts() {
      return h();
    }, set otherProducts(xe = []) {
      h(xe), k();
    }, get complementaryProducts() {
      return f();
    }, set complementaryProducts(xe = []) {
      f(xe), k();
    }, get customQuantity() {
      return p();
    }, set customQuantity(xe = void 0) {
      p(xe), k();
    }, get currentVariantId() {
      return _();
    }, set currentVariantId(xe = void 0) {
      _(xe), k();
    }, get componentId() {
      return I();
    }, set componentId(xe) {
      I(xe), k();
    }, get selected() {
      return y();
    }, set selected(xe = !1) {
      y(xe), k();
    }, get globalSellingPlan() {
      return x();
    }, set globalSellingPlan(xe = void 0) {
      x(xe), k();
    }, get selectedDealBarIndex() {
      return M();
    }, set selectedDealBarIndex(xe) {
      M(xe), k();
    }, get onProgressiveGiftsChange() {
      return A();
    }, set onProgressiveGiftsChange(xe) {
      A(xe), k();
    }, get onDealBarSelect() {
      return V();
    }, set onDealBarSelect(xe) {
      V(xe), k();
    }, get onDealBarDeselect() {
      return C();
    }, set onDealBarDeselect(xe) {
      C(xe), k();
    }, get onVariantSelect() {
      return R();
    }, set onVariantSelect(xe) {
      R(xe), k();
    }, get onVariantsChange() {
      return U();
    }, set onVariantsChange(xe) {
      U(xe), k();
    }, get onPersonalisationsChange() {
      return F();
    }, set onPersonalisationsChange(xe) {
      F(xe), k();
    }, get personalisationInitialValues() {
      return se();
    }, set personalisationInitialValues(xe = []) {
      se(xe), k();
    } }, pt = Of();
    let ot;
    var Ne = P(pt);
    qr(Ne), Ne.__change = [_f, V, o, b];
    var it = E(Ne, 2);
    let Et;
    var Pt = P(it);
    {
      let xe = g(() => e(ye) || void 0);
      wa(Pt, { get style() {
        return o().badgeStyle;
      }, get text() {
        return e(xe);
      }, get imageUrl() {
        return e(Se);
      }, get blockLayout() {
        return i().blockLayout;
      } });
    }
    var Ft = E(Pt, 2), Dt = P(Ft);
    Qt(Dt, { element: "div", class: "kaching-bundles__bar-main", onclick: function(xe) {
      y() && (xe.preventDefault(), xe.stopPropagation(), C()());
    }, children: (xe, Xe) => {
      var ut = qf(), he = ve(ut), Oe = (et) => {
        var bt = kf();
        be(() => Pe(bt, "src", e($e))), v(et, bt);
      }, Ie = (et) => {
        v(et, mf());
      };
      j(he, (et) => {
        o().mediaImageGID ? et(Oe) : et(Ie, !1);
      });
      var Fe = E(he, 2), Ue = P(Fe), ct = P(Ue), jt = P(ct);
      Ke(jt, () => e(ke), (et) => {
        var bt = yf();
        qe(P(bt), () => e(ke)), w(bt), v(et, bt);
      });
      var Vt = E(jt, 2), vt = (et) => {
        var bt = De();
        Ke(ve(bt), () => e(_e), (Ut) => {
          var kt = xf();
          qe(P(kt), () => e(_e)), w(kt), v(Ut, kt);
        }), v(et, bt);
      };
      j(Vt, (et) => {
        e(_e) && et(vt);
      }), w(ct);
      var St = E(ct, 2), Rt = P(St), At = (et) => {
        var bt = De();
        Ke(ve(bt), () => e(we), (Ut) => {
          var kt = wf();
          qe(P(kt), () => e(we)), w(kt), v(Ut, kt);
        }), v(et, bt);
      };
      j(Rt, (et) => {
        e(we) && et(At);
      });
      var Zt = E(Rt, 2), dn = (et) => {
        {
          let bt = g(() => {
            var Ut, kt;
            return (kt = (Ut = e(z)) == null ? void 0 : Ut[0]) == null ? void 0 : kt.variant.inventoryQuantity;
          });
          Gr(et, { get lowStockAlert() {
            return i().lowStockAlert;
          }, get inventoryQuantity() {
            return e(bt);
          } });
        }
      };
      j(Zt, (et) => {
        !e(ge) && i().lowStockAlertEnabled && i().lowStockAlert && et(dn);
      }), w(St), w(Ue);
      var Sn = E(Ue, 2), Dn = P(Sn), Ln = (et) => {
        var bt = If(), Ut = ve(bt), kt = P(Ut);
        Ke(kt, () => e(Ee), (Be) => {
          yr(Be, { get amount() {
            return e(Ee);
          }, get showPricesPerItem() {
            return i().showPricesPerItem;
          }, get unitLabel() {
            return i().unitLabel;
          } });
        });
        var _n = E(kt, 2), oe = (Be) => {
          var nt = De();
          Ke(ve(nt), () => e(Y), (yt) => {
            var Ct = Pf();
            qe(P(Ct), () => a()(e(Y))), w(Ct), be((Ht) => Pe(Ct, "data-a11y-label", Ht), [() => l()("system.original_price")]), v(yt, Ct);
          }), v(Be, nt);
        };
        j(_n, (Be) => {
          e(ne) && Be(oe);
        }), w(Ut);
        var Ge = E(Ut, 2), Le = (Be) => {
          var nt = Bf(), yt = P(nt);
          Ke(yt, () => e(re), (lt) => {
            var ht = Sf();
            qe(P(ht), () => a()(e(re))), w(ht), be((Yt) => Pe(ht, "data-a11y-label", Yt), [() => l()("system.price")]), v(lt, ht);
          });
          var Ct = E(yt, 2), Ht = (lt) => {
            var ht = De();
            Ke(ve(ht), () => e(H), (Yt) => {
              var gn = Cf();
              qe(P(gn), () => a()(e(H))), w(gn), be((Tn) => Pe(gn, "data-a11y-label", Tn), [() => l()("system.original_price")]), v(Yt, gn);
            }), v(lt, ht);
          };
          j(Ct, (lt) => {
            e(ne) && lt(Ht);
          }), w(nt), v(Be, nt);
        };
        j(Ge, (Be) => {
          e(Q) > 1 && Be(Le);
        }), v(et, bt);
      }, vn = (et) => {
        var bt = De(), Ut = ve(bt), kt = (oe) => {
          var Ge = zf(), Le = ve(Ge), Be = P(Le);
          Ke(Be, () => e(re), (Ht) => {
            {
              let lt = g(() => i().showPricesPerItem ? e(Ee) : e(re));
              yr(Ht, { get amount() {
                return e(lt);
              }, get showPricesPerItem() {
                return i().showPricesPerItem;
              }, get unitLabel() {
                return i().unitLabel;
              } });
            }
          });
          var nt = E(Be, 2), yt = (Ht) => {
            var lt = De();
            Ke(ve(lt), () => e(H), (ht) => {
              var Yt = Mf();
              qe(P(Yt), () => a()(i().showPricesPerItem ? e(Y) : e(H))), w(Yt), be((gn) => Pe(Yt, "data-a11y-label", gn), [() => l()("system.original_price")]), v(ht, Yt);
            }), v(Ht, lt);
          };
          j(nt, (Ht) => {
            e(ne) && Ht(yt);
          }), w(Le);
          var Ct = E(Le, 2);
          Ke(P(Ct), () => e(ce), (Ht) => {
            var lt = Df(), ht = P(lt);
            qe(ht, () => a()(e(ce), { preserveDecimals: !0 }));
            var Yt = E(ht);
            w(lt), be(() => {
              var gn;
              return mt(Yt, ` /
                    ${(gn = e(fe)) != null ? gn : ""}`);
            }), v(Ht, lt);
          }), w(Ct), v(oe, Ge);
        }, _n = (oe) => {
          var Ge = $f(), Le = ve(Ge);
          Ke(Le, () => e(re), (yt) => {
            {
              let Ct = g(() => i().showPricesPerItem ? e(Ee) : e(re));
              yr(yt, { get amount() {
                return e(Ct);
              }, get showPricesPerItem() {
                return i().showPricesPerItem;
              }, get unitLabel() {
                return i().unitLabel;
              } });
            }
          });
          var Be = E(Le, 2), nt = (yt) => {
            var Ct = De();
            Ke(ve(Ct), () => e(H), (Ht) => {
              var lt = Af();
              qe(P(lt), () => a()(i().showPricesPerItem ? e(Y) : e(H))), w(lt), be((ht) => Pe(lt, "data-a11y-label", ht), [() => l()("system.original_price")]), v(Ht, lt);
            }), v(yt, Ct);
          };
          j(Be, (yt) => {
            e(ne) && yt(nt);
          }), v(oe, Ge);
        };
        j(Ut, (oe) => {
          e(ce) && !r().ignoreUnitPrice ? oe(kt) : oe(_n, !1);
        }, !0), v(et, bt);
      };
      j(Dn, (et) => {
        i().showBothPrices ? et(Ln) : et(vn, !1);
      }), w(Sn), w(Fe), v(xe, ut);
    }, $$slots: { default: !0 } });
    var Lt = E(Dt, 2), Ce = (xe) => {
      ea(xe, { get highlights() {
        return o().highlights;
      }, get isSelected() {
        return y();
      }, get replaceLiquid() {
        return e(ie);
      } });
    };
    j(Lt, (xe) => {
      o().highlights && xe(Ce);
    });
    var tt = E(Lt, 2), ft = (xe) => {
      var Xe = Vf(), ut = P(Xe);
      {
        let he = g(() => e(ee) || e(O)[0]);
        Xr(ut, { get sellingPlans() {
          return e(O);
        }, get selectedSellingPlan() {
          return e(he);
        }, onChange: (Oe) => {
          te(L, Oe, !0);
        } });
      }
      w(Xe), v(xe, Xe);
    };
    j(tt, (xe) => {
      y() && e(ae) && !o().sellingPlanGid && e(O).length > 1 && xe(ft);
    });
    var gt = E(tt, 2), Qe = (xe) => {
      var Xe = Gf(), ut = P(Xe);
      Vr(ut, { get product() {
        return d();
      } }), Jt(E(ut, 2), 17, () => ({ length: e(Q) }), Zr, (he, Oe, Ie) => {
        var Fe = Tf(), Ue = P(Fe);
        {
          let Vt = g(() => e(Q) > 1 ? Ie + 1 : void 0);
          Mn(Ue, { get product() {
            return d();
          }, get selectedVariantId() {
            return e(G)[Ie];
          }, get showImage() {
            return e(Te);
          }, get number() {
            return e(Vt);
          }, onChange: (vt) => (function(St, Rt) {
            const At = [...e(G)];
            At[St] = Rt, te(G, At, !0), y() && R()({ variantId: Rt });
          })(Ie, vt), onOptionChange: (vt, St, Rt) => (function(At, Zt, dn, Sn) {
            if (i().disableVariantOptionSync || At !== 0) return;
            const Dn = Zt - 1, Ln = e(G).map((vn) => d().variants.find((et) => et.id === vn)).filter((vn) => vn != null).slice(1);
            Ln.length !== 0 && Ln.every((vn) => vn.options[Dn] === Sn) && te(G, e(G).map((vn) => {
              const et = d().variants.find((kt) => kt.id === vn);
              if (!et || et.options[Dn] !== Sn) return vn;
              const bt = [...et.options];
              bt[Dn] = dn;
              const Ut = d().variants.find((kt) => kt.options.every((_n, oe) => _n === bt[oe]));
              return Ut ? Ut.id : vn;
            }), !0);
          })(Ie, vt, St, Rt) });
        }
        var ct = E(Ue, 2), jt = (Vt) => {
          {
            let vt = g(() => {
              var St, Rt;
              return (Rt = (St = d().variants.find((At) => At.id === e(G)[Ie])) == null ? void 0 : St.inventoryQuantity) != null ? Rt : null;
            });
            Gr(Vt, { get lowStockAlert() {
              return i().lowStockAlert;
            }, get inventoryQuantity() {
              return e(vt);
            } });
          }
        };
        j(ct, (Vt) => {
          i().lowStockAlertEnabled && i().lowStockAlert && Vt(jt);
        }), w(Fe), v(he, Fe);
      }), w(Xe), v(xe, Xe);
    };
    j(gt, (xe) => {
      e(ge) && xe(Qe);
    });
    var at = E(gt, 2), Ze = (xe) => {
      {
        let Xe = g(() => b(o()));
        qi(xe, { get value() {
          return e(ue);
        }, get min() {
          return e(Xe);
        }, onChange: (ut) => te(ue, ut, !0) });
      }
    };
    j(at, (xe) => {
      y() && o().dealBarType === "quantity-break" && o().quantitySelector && xe(Ze);
    });
    var zt = E(at, 2), en = (xe) => {
      Pa(xe, { get product() {
        return d();
      }, get selectedVariantIds() {
        return e(G);
      }, get productPersonalisation() {
        return o().productPersonalisation;
      }, get quantity() {
        return e(W);
      }, get addPersonalisationModal() {
        return i().addPersonalisationModal;
      }, get onPersonalisationsChange() {
        return F();
      }, get initialValues() {
        return se();
      } });
    };
    j(zt, (xe) => {
      y() && o().productPersonalisation && (i().blockLayout === "vertical" || i().blockLayout === "plain") && xe(en);
    }), w(Ft);
    var tn = E(Ft, 2);
    {
      let xe = g(() => o().upsells || []);
      Ha(tn, { get dealBlock() {
        return i();
      }, get upsells() {
        return e(xe);
      }, get otherProducts() {
        return h();
      }, get complementaryProducts() {
        return f();
      }, get dealBarSelected() {
        return y();
      }, get dealSellingPlan() {
        return e(le);
      }, onChange: (Xe) => {
        te(S, Xe, !0);
      } });
    }
    var _t = E(tn, 2);
    Ya(_t, { get selectedDealBarIndex() {
      return M();
    }, get onChange() {
      return A();
    }, get dealBlock() {
      return i();
    }, get dealBar() {
      return o();
    }, get selected() {
      return y();
    }, get otherProducts() {
      return h();
    }, get progressiveGifts() {
      return i().progressiveGifts;
    } });
    var Bt = E(_t, 2);
    {
      let xe = g(() => o().freeGifts || []);
      Ua(Bt, { get dealBlock() {
        return i();
      }, get freeGifts() {
        return e(xe);
      }, get otherProducts() {
        return h();
      }, get dealBarSelected() {
        return y();
      }, get sellingPlan() {
        return e(le);
      }, get mainProductVariantId() {
        return e(G)[0];
      }, onChange: (Xe) => {
        te(Z, Xe, !0);
      } });
    }
    var an = E(Bt, 2);
    {
      let xe = g(() => o().multipleGiftsSelectors || []);
      Ja(an, { get dealBlock() {
        return i();
      }, get multipleGiftsSelectors() {
        return e(xe);
      }, get sellingPlan() {
        return e(le);
      }, get otherProducts() {
        return h();
      }, onChange: (Xe) => {
        te($, Xe, !0);
      } });
    }
    w(it);
    var un = E(it, 2), yn = (xe) => {
      Za(xe, { get showAsSoldOut() {
        return o().showAsSoldOut;
      }, get replaceLiquid() {
        return e(ie);
      } });
    };
    j(un, (xe) => {
      o().showAsSoldOutEnabled && o().showAsSoldOut && xe(yn);
    }), w(pt), be((xe, Xe) => {
      var ut;
      ot = Ot(pt, 1, "kaching-bundles__bar", null, ot, xe), Pe(pt, "data-deal-bar-id", o().id), Wt(pt, e(je)), Pe(Ne, "name", `kaching-bundles-deal-${(ut = I()) != null ? ut : ""}`), va(Ne, o().id), Pe(Ne, "id", e(pe)), Pi(Ne, y()), Ne.disabled = o().showAsSoldOutEnabled, Pe(it, "for", e(pe)), Et = Ot(it, 1, "kaching-bundles__bar-container", null, Et, Xe);
    }, [() => ({ "kaching-bundles__bar--selected": y() }), () => ({ "kaching-bundles__bar-container--sold-out": o().showAsSoldOutEnabled })]), v(n, pt);
    var ln = Ye(st);
    return s(), ln;
  }
  Pn(["change"]), We(Bs, { dealBlock: {}, dealBar: {}, product: {}, otherProducts: {}, complementaryProducts: {}, customQuantity: {}, currentVariantId: {}, componentId: {}, selected: {}, globalSellingPlan: {}, selectedDealBarIndex: {}, onProgressiveGiftsChange: {}, onDealBarSelect: {}, onDealBarDeselect: {}, onVariantSelect: {}, onVariantsChange: {}, onPersonalisationsChange: {}, personalisationInitialValues: {} }, [], [], !0);
  var Ff = D('<div class="kaching-bundles"><!></div>');
  function yu(n, t) {
    Je(t, !0);
    const r = m(t, "config", 7), a = m(t, "dealBlock", 7), l = m(t, "dealBar", 7), c = m(t, "translations", 7), u = m(t, "product", 7), s = m(t, "mediaImages", 23, () => []), i = m(t, "currentVariantId", 7), o = Math.random().toString(16).slice(2), { setConfig: d } = xa(r()), { setMoneyFormat: h } = Na(r().moneyFormat), { setTranslations: f } = ya(c()), { setMediaImages: p } = Bi(s()), { setSwatchSettings: _ } = Ii({ swatchOptions: a().swatchOptions || [], swatchSize: a().swatchSize, swatchShape: a().swatchShape });
    He(() => {
      d(r());
    }), He(() => {
      h(r().moneyFormat, !!a().showPricesWithoutDecimals);
    }), He(() => {
      f(c());
    }), He(() => {
      p(s());
    }), He(() => {
      _({ swatchOptions: a().swatchOptions || [], swatchSize: a().swatchSize, swatchShape: a().swatchShape });
    });
    const I = g(() => a() && $c(a()));
    var y = { get config() {
      return r();
    }, set config(V) {
      r(V), k();
    }, get dealBlock() {
      return a();
    }, set dealBlock(V) {
      a(V), k();
    }, get dealBar() {
      return l();
    }, set dealBar(V) {
      l(V), k();
    }, get translations() {
      return c();
    }, set translations(V) {
      c(V), k();
    }, get product() {
      return u();
    }, set product(V) {
      u(V), k();
    }, get mediaImages() {
      return s();
    }, set mediaImages(V = []) {
      s(V), k();
    }, get currentVariantId() {
      return i();
    }, set currentVariantId(V) {
      i(V), k();
    } }, x = Ff(), M = P(x), A = (V) => {
      Bs(V, { selectedDealBarIndex: null, get dealBlock() {
        return a();
      }, get dealBar() {
        return l();
      }, get product() {
        return u();
      }, get currentVariantId() {
        return i();
      }, get componentId() {
        return o;
      }, selected: !0, onProgressiveGiftsChange: () => {
      }, onDealBarSelect: () => {
      }, onDealBarDeselect: () => {
      }, onVariantSelect: () => {
      }, onVariantsChange: () => {
      } });
    };
    return j(M, (V) => {
      l().dealBarType && l().dealBarType !== "quantity-break" && l().dealBarType !== "bxgy" || V(A);
    }), w(x), be(() => Wt(x, e(I))), v(n, x), Ye(y);
  }
  customElements.define("kaching-bundles-bar", We(yu, { config: { attribute: "config", type: "Object" }, dealBlock: { attribute: "deal-block", type: "Object" }, dealBar: { attribute: "deal-bar", type: "Object" }, translations: { attribute: "translations", type: "Object" }, product: { attribute: "product", type: "Object" }, mediaImages: { attribute: "media-images", type: "Array" }, currentVariantId: { attribute: "current-variant-id", type: "Number" } }, [], [], !1, (n) => class extends n {
    constructor() {
      super(), fn(this, "component"), this.component = this;
    }
  }));
  var xu = !1;
  const wu = class extends Date {
    constructor(...n) {
      super(...n), It(this, ql), It(this, li, Ae(super.getTime())), It(this, Qi, /* @__PURE__ */ new Map()), It(this, $l, Tt), xu || nn(this, ql, Js).call(this);
    }
  };
  li = /* @__PURE__ */ new WeakMap(), Qi = /* @__PURE__ */ new WeakMap(), $l = /* @__PURE__ */ new WeakMap(), ql = /* @__PURE__ */ new WeakSet(), Js = function() {
    xu = !0;
    var n = wu.prototype, t = Date.prototype, r = Object.getOwnPropertyNames(t);
    for (const a of r) (a.startsWith("get") || a.startsWith("to") || a === "valueOf") && (n[a] = function(...l) {
      if (l.length > 0) return e(me(this, li)), t[a].apply(this, l);
      var c = me(this, Qi).get(a);
      if (c === void 0) {
        const u = Tt;
        Bn(me(this, $l)), c = g(() => (e(me(this, li)), t[a].apply(this, l))), me(this, Qi).set(a, c), Bn(u);
      }
      return e(c);
    }), a.startsWith("set") && (n[a] = function(...l) {
      var c = t[a].apply(this, l);
      return te(me(this, li), t.getTime.call(this)), c;
    });
  };
  let Is = wu;
  var Lf = ["forEach", "isDisjointFrom", "isSubsetOf", "isSupersetOf"], Ef = ["difference", "intersection", "symmetricDifference", "union"], Pu = !1;
  const Ms = class extends Set {
    constructor(n) {
      if (super(), It(this, Ni), It(this, si, /* @__PURE__ */ new Map()), It(this, pr, Ae(0)), It(this, la, Ae(0)), It(this, Vl, cr || -1), n) {
        for (var t of n) super.add(t);
        me(this, la).v = super.size;
      }
      Pu || nn(this, Ni, Ks).call(this);
    }
    has(n) {
      var t = super.has(n), r = me(this, si), a = r.get(n);
      if (a === void 0) {
        if (!t) return e(me(this, pr)), !1;
        a = nn(this, Ni, Ys).call(this, !0), r.set(n, a);
      }
      return e(a), t;
    }
    add(n) {
      return super.has(n) || (super.add(n), te(me(this, la), super.size), jn(me(this, pr))), this;
    }
    delete(n) {
      var t = super.delete(n), r = me(this, si), a = r.get(n);
      return a !== void 0 && (r.delete(n), te(a, !1)), t && (te(me(this, la), super.size), jn(me(this, pr))), t;
    }
    clear() {
      if (super.size !== 0) {
        super.clear();
        var n = me(this, si);
        for (var t of n.values()) te(t, !1);
        n.clear(), te(me(this, la), 0), jn(me(this, pr));
      }
    }
    keys() {
      return this.values();
    }
    values() {
      return e(me(this, pr)), super.values();
    }
    entries() {
      return e(me(this, pr)), super.entries();
    }
    [Symbol.iterator]() {
      return this.keys();
    }
    get size() {
      return e(me(this, la));
    }
  };
  si = /* @__PURE__ */ new WeakMap(), pr = /* @__PURE__ */ new WeakMap(), la = /* @__PURE__ */ new WeakMap(), Vl = /* @__PURE__ */ new WeakMap(), Ni = /* @__PURE__ */ new WeakSet(), Ys = function(n) {
    return cr === me(this, Vl) ? Ae(n) : zr(n);
  }, Ks = function() {
    Pu = !0;
    var n = Ms.prototype, t = Set.prototype;
    for (const r of Lf) n[r] = function(...a) {
      return e(me(this, pr)), t[r].apply(this, a);
    };
    for (const r of Ef) n[r] = function(...a) {
      e(me(this, pr));
      var l = t[r].apply(this, a);
      return new Ms(l);
    };
  };
  let jf = Ms;
  const Su = class extends Map {
    constructor(n) {
      if (super(), It(this, Ir), It(this, Cr, /* @__PURE__ */ new Map()), It(this, Br, Ae(0)), It(this, Er, Ae(0)), It(this, Tl, cr || -1), n) {
        for (var [t, r] of n) super.set(t, r);
        me(this, Er).v = super.size;
      }
    }
    has(n) {
      var t = me(this, Cr), r = t.get(n);
      if (r === void 0) {
        if (super.get(n) === void 0) return e(me(this, Br)), !1;
        r = nn(this, Ir, oi).call(this, 0), t.set(n, r);
      }
      return e(r), !0;
    }
    forEach(n, t) {
      nn(this, Ir, Wi).call(this), super.forEach(n, t);
    }
    get(n) {
      var t = me(this, Cr), r = t.get(n);
      if (r === void 0) {
        if (super.get(n) === void 0) return void e(me(this, Br));
        r = nn(this, Ir, oi).call(this, 0), t.set(n, r);
      }
      return e(r), super.get(n);
    }
    set(n, t) {
      var r, a = me(this, Cr), l = a.get(n), c = super.get(n), u = super.set(n, t), s = me(this, Br);
      if (l === void 0) l = nn(this, Ir, oi).call(this, 0), a.set(n, l), te(me(this, Er), super.size), jn(s);
      else if (c !== t) {
        jn(l);
        var i = s.reactions === null ? null : new Set(s.reactions);
        (i === null || !((r = l.reactions) != null && r.every((o) => i.has(o)))) && jn(s);
      }
      return u;
    }
    delete(n) {
      var t = me(this, Cr), r = t.get(n), a = super.delete(n);
      return r !== void 0 && (t.delete(n), te(me(this, Er), super.size), te(r, -1), jn(me(this, Br))), a;
    }
    clear() {
      if (super.size !== 0) {
        super.clear();
        var n = me(this, Cr);
        for (var t of (te(me(this, Er), 0), n.values())) te(t, -1);
        jn(me(this, Br)), n.clear();
      }
    }
    keys() {
      return e(me(this, Br)), super.keys();
    }
    values() {
      return nn(this, Ir, Wi).call(this), super.values();
    }
    entries() {
      return nn(this, Ir, Wi).call(this), super.entries();
    }
    [Symbol.iterator]() {
      return this.entries();
    }
    get size() {
      return e(me(this, Er)), super.size;
    }
  };
  Cr = /* @__PURE__ */ new WeakMap(), Br = /* @__PURE__ */ new WeakMap(), Er = /* @__PURE__ */ new WeakMap(), Tl = /* @__PURE__ */ new WeakMap(), Ir = /* @__PURE__ */ new WeakSet(), oi = function(n) {
    return cr === me(this, Tl) ? Ae(n) : zr(n);
  }, Wi = function() {
    e(me(this, Br));
    var n = me(this, Cr);
    if (me(this, Er).v !== n.size) {
      for (var t of k0(Su.prototype, this, "keys").call(this)) if (!n.has(t)) {
        var r = nn(this, Ir, oi).call(this, 0);
        n.set(t, r);
      }
    }
    for ([, r] of me(this, Cr)) e(r);
  };
  let Rf = Su;
  var Qf = D('<img alt="" class="kaching-bundles__bundle-products__image"/>'), Nf = D('<div class="kaching-bundles__bundle-products__image-placeholder"></div>');
  function Ds(n, t) {
    Je(t, !0);
    const r = m(t, "image", 7), a = m(t, "linkUrl", 7);
    var l = { get image() {
      return r();
    }, set image(o) {
      r(o), k();
    }, get linkUrl() {
      return a();
    }, set linkUrl(o) {
      a(o), k();
    } }, c = De(), u = ve(c), s = (o) => {
      Vn(o, { get url() {
        return a();
      }, class: "kaching-bundles__bundle-products__link", children: (d, h) => {
        var f = Qf();
        Pe(f, "height", 50), Pe(f, "width", 50), be(() => Pe(f, "src", r())), v(d, f);
      }, $$slots: { default: !0 } });
    }, i = (o) => {
      v(o, Nf());
    };
    return j(u, (o) => {
      r() ? o(s) : o(i, !1);
    }), v(n, c), Ye(l);
  }
  We(Ds, { image: {}, linkUrl: {} }, [], [], !0);
  var Wf = D('<span class="kaching-bundles__bundle-products__quantity"> </span>'), Uf = D('<div class="kaching-bundles__bundle-products__title"><!> <span> </span></div>');
  function zs(n, t) {
    Je(t, !0);
    const r = m(t, "title", 7), a = m(t, "quantity", 7), l = m(t, "linkUrl", 7);
    var c = { get title() {
      return r();
    }, set title(u) {
      r(u), k();
    }, get quantity() {
      return a();
    }, set quantity(u) {
      a(u), k();
    }, get linkUrl() {
      return l();
    }, set linkUrl(u) {
      l(u), k();
    } };
    return Vn(n, { get url() {
      return l();
    }, class: "kaching-bundles__bundle-products__link", children: (u, s) => {
      var i = Uf(), o = P(i), d = (p) => {
        var _ = Wf(), I = P(_);
        w(_), be(() => {
          var y;
          return mt(I, `${(y = a()) != null ? y : ""}x`);
        }), v(p, _);
      };
      j(o, (p) => {
        a() > 1 && p(d);
      });
      var h = E(o, 2), f = P(h, !0);
      w(h), w(i), be(() => mt(f, r())), v(u, i);
    }, $$slots: { default: !0 } }), Ye(c);
  }
  We(zs, { title: {}, quantity: {}, linkUrl: {} }, [], [], !0);
  var Hf = D('<span class="kaching-bundles__bundle-products__price"><!></span>'), Zf = D('<span class="kaching-bundles__bundle-products__full-price"><!></span>'), Jf = D('<span class="kaching-bundles__bundle-products__unit-price"><!> </span>'), Yf = D("<div><!> <!> <!></div>");
  function As(n, t) {
    Je(t, !0);
    const r = () => Me(d, "$formatPrice", a), [a, l] = wt();
    let c = m(t, "discountedPrice", 7), u = m(t, "fullPrice", 7), s = m(t, "unitPrice", 7), i = m(t, "unitPriceReference", 7), o = m(t, "ignoreUnitPrice", 7);
    const d = cn(), h = g(() => !!s() && !!i() && !o());
    var f = { get discountedPrice() {
      return c();
    }, set discountedPrice(C) {
      c(C), k();
    }, get fullPrice() {
      return u();
    }, set fullPrice(C) {
      u(C), k();
    }, get unitPrice() {
      return s();
    }, set unitPrice(C) {
      s(C), k();
    }, get unitPriceReference() {
      return i();
    }, set unitPriceReference(C) {
      i(C), k();
    }, get ignoreUnitPrice() {
      return o();
    }, set ignoreUnitPrice(C) {
      o(C), k();
    } }, p = Yf();
    let _;
    var I = P(p);
    Ke(I, c, (C) => {
      var R = Hf();
      qe(P(R), () => r()(c())), w(R), v(C, R);
    });
    var y = E(I, 2), x = (C) => {
      var R = De();
      Ke(ve(R), u, (U) => {
        var F = Zf();
        qe(P(F), () => r()(u())), w(F), v(U, F);
      }), v(C, R);
    };
    j(y, (C) => {
      c() < u() && C(x);
    });
    var M = E(y, 2), A = (C) => {
      var R = De();
      Ke(ve(R), s, (U) => {
        var F = Jf(), se = P(F);
        qe(se, () => r()(s(), { preserveDecimals: !0 }));
        var X = E(se);
        w(F), be(() => {
          var K;
          return mt(X, ` / ${(K = i()) != null ? K : ""}`);
        }), v(U, F);
      }), v(C, R);
    };
    j(M, (C) => {
      s() && i() && !o() && C(A);
    }), w(p), be((C) => _ = Ot(p, 1, "kaching-bundles__bundle-products__pricing", null, _, C), [() => ({ "kaching-bundles__bundle-products__pricing--with-unit-price": e(h) })]), v(n, p);
    var V = Ye(f);
    return l(), V;
  }
  We(As, { discountedPrice: {}, fullPrice: {}, unitPrice: {}, unitPriceReference: {}, ignoreUnitPrice: {} }, [], [], !0);
  var Kf = D("<!> <!> <!> <!> <!>", 1), Xf = D("<!> <!>", 1), eb = D('<div class="kaching-bundles__bundle-products__wrapper"><!> <div class="kaching-bundles__bundle-products__content"><!> <!> <!></div></div> <!>', 1), tb = D('<div class="kaching-bundles__bundle-products__product"><!></div>');
  function Cu(n, t) {
    Je(t, !0);
    const r = () => Me(x, "$config", a), [a, l] = wt();
    let c = m(t, "dealBlock", 7), u = m(t, "layout", 7), s = m(t, "bundleProduct", 7), i = m(t, "product", 7), o = m(t, "dealBarSelected", 7), d = m(t, "currentVariantId", 7), h = m(t, "mainVariantId", 7), f = m(t, "priceRounding", 7), p = m(t, "sellingPlan", 7), _ = m(t, "dealBar", 7), I = m(t, "sets", 7), y = m(t, "onChange", 7);
    const x = on(), M = cn();
    let A = Ae(void 0);
    const V = g(() => !!s().variantGIDs), C = g(() => {
      var L, O;
      return e(V) && i() ? i().variants.filter((ae) => s().variantGIDs.some((ee) => Nt(ee) === ae.id)) : (O = (L = i()) == null ? void 0 : L.variants) != null ? O : [];
    }), R = g(() => {
      var L, O, ae, ee;
      const le = s().productGID === "default", re = !!((L = c().defaultVariantsV2) != null && L.length);
      if (le && re && i()) {
        const fe = i().id, ze = (ee = (ae = (O = c().defaultVariantsV2) == null ? void 0 : O.find((ce) => Nt(ce.productGID) === fe && ce.dealBarId === _().id)) == null ? void 0 : ae.variantGIDs) == null ? void 0 : ee[0];
        if (ze) return Nt(ze);
      }
      if (s().defaultVariantGID) return Nt(s().defaultVariantGID);
    }), U = g(() => {
      const L = e(A) || e(R);
      return L !== void 0 && e(C).some(({ id: O }) => O === L) ? L : s().productGID === "default" && d() ? d() : s().variantGIDs ? s().variantGIDs.length === 0 ? void 0 : Nt(s().variantGIDs[0]) : e(C).length > 0 ? e(C)[0].id : void 0;
    }), F = g(() => {
      var L;
      return e(U) ? (L = i()) == null ? void 0 : L.variants.find((O) => O.id === e(U)) : void 0;
    }), se = g(() => i() && e(F) && Fn(i(), e(F), p())), X = g(() => s().quantity * I()), K = g(() => Tr({ discountType: s().discountType, discountValue: s().discountValue, discountQuantity: s().quantity, variantQuantities: e(F) ? [{ variant: e(F), quantity: e(X) }] : [], currencyRate: r().currencyRate, priceRounding: f(), sellingPlan: e(se) })), J = g(() => (function(L) {
      if (!L) return 0;
      let O = L.price;
      return c().useProductCompareAtPrice && L.compareAtPrice && (O = Math.max(O, L.compareAtPrice)), O * e(X);
    })(e(F))), N = g(() => e(F) ? _s(e(F)) : null), Z = g(() => e(F) ? er([{ variant: e(F), quantity: e(X) }]) : null), $ = g(() => e(Z) ? e(K) / e(Z) : null), S = g(() => {
      var L;
      return (L = i()) != null && L.url && e(F) ? `${i().url}?variant=${e(F).id}` : void 0;
    }), T = g(() => {
      var L, O;
      return ((L = e(F)) == null ? void 0 : L.image) || ((O = i()) == null ? void 0 : O.image);
    }), q = g(() => o() && i() && e(C).length > 1 && e(U)), W = g(() => o() && s().productGID !== "default" ? e(S) : void 0), ue = g(() => i() ? s().title ? pn({ priceFormatter: Me(M, "$formatPrice", a), product: i(), totalFullPrice: e(J), totalDiscountedPrice: e(K), quantity: e(X), unitQuantity: e(Z) })(s().title) : i().title : "");
    function Q(L) {
      te(A, L, !0);
    }
    let b;
    He(() => {
      e(F) && e(X) && Xt(() => {
        y()({ variant: e(F), product: i(), quantity: e(X) });
      });
    }), Hn(() => {
      s().productGID, te(A, void 0), b = void 0;
    }), Hn(() => {
      const L = s().productGID === "default";
      if (!(L || !c().disableVariantOptionSync)) return;
      const O = L ? d() : h();
      if (!O || !i() || O === b) return;
      const ae = b;
      if (b = O, !e(C).some((re) => re.id === O)) return;
      const ee = e(A) === void 0 && e(R) === void 0, le = e(A) === ae && ae !== void 0;
      (ee || le) && te(A, O, !0);
    });
    var B = { get dealBlock() {
      return c();
    }, set dealBlock(L) {
      c(L), k();
    }, get layout() {
      return u();
    }, set layout(L) {
      u(L), k();
    }, get bundleProduct() {
      return s();
    }, set bundleProduct(L) {
      s(L), k();
    }, get product() {
      return i();
    }, set product(L) {
      i(L), k();
    }, get dealBarSelected() {
      return o();
    }, set dealBarSelected(L) {
      o(L), k();
    }, get currentVariantId() {
      return d();
    }, set currentVariantId(L) {
      d(L), k();
    }, get mainVariantId() {
      return h();
    }, set mainVariantId(L) {
      h(L), k();
    }, get priceRounding() {
      return f();
    }, set priceRounding(L) {
      f(L), k();
    }, get sellingPlan() {
      return p();
    }, set sellingPlan(L) {
      p(L), k();
    }, get dealBar() {
      return _();
    }, set dealBar(L) {
      _(L), k();
    }, get sets() {
      return I();
    }, set sets(L) {
      I(L), k();
    }, get onChange() {
      return y();
    }, set onChange(L) {
      y(L), k();
    } }, G = De(), z = ve(G), H = (L) => {
      var O = tb(), ae = P(O), ee = (re) => {
        var fe = Kf(), ze = ve(fe);
        Ds(ze, { get image() {
          return e(T);
        }, get linkUrl() {
          return e(W);
        } });
        var ce = E(ze, 2);
        zs(ce, { get title() {
          return e(ue);
        }, get quantity() {
          return e(X);
        }, get linkUrl() {
          return e(W);
        } });
        var ie = E(ce, 2);
        As(ie, { get discountedPrice() {
          return e(K);
        }, get fullPrice() {
          return e(J);
        }, get unitPrice() {
          return e($);
        }, get unitPriceReference() {
          return e(N);
        }, get ignoreUnitPrice() {
          return r().ignoreUnitPrice;
        } });
        var ke = E(ie, 2), we = (Se) => {
          {
            let Ve = g(() => {
              var Ee, ne;
              return (ne = (Ee = e(F)) == null ? void 0 : Ee.inventoryQuantity) != null ? ne : null;
            });
            Gr(Se, { get lowStockAlert() {
              return c().lowStockAlert;
            }, get inventoryQuantity() {
              return e(Ve);
            } });
          }
        };
        j(ke, (Se) => {
          c().lowStockAlertEnabled && c().lowStockAlert && Se(we);
        });
        var _e = E(ke, 2), ye = (Se) => {
          {
            let Ve = g(() => ({ ...i(), variants: e(C) })), Ee = g(() => e(U) || 0);
            Mn(Se, { get product() {
              return e(Ve);
            }, get selectedVariantId() {
              return e(Ee);
            }, onChange: Q });
          }
        };
        j(_e, (Se) => {
          e(q) && Se(ye);
        }), v(re, fe);
      }, le = (re) => {
        var fe = eb(), ze = ve(fe), ce = P(ze);
        Ds(ce, { get image() {
          return e(T);
        }, get linkUrl() {
          return e(W);
        } });
        var ie = E(ce, 2), ke = P(ie);
        zs(ke, { get title() {
          return e(ue);
        }, get quantity() {
          return e(X);
        }, get linkUrl() {
          return e(W);
        } });
        var we = E(ke, 2), _e = (Ve) => {
          {
            let Ee = g(() => {
              var ne, ge;
              return (ge = (ne = e(F)) == null ? void 0 : ne.inventoryQuantity) != null ? ge : null;
            });
            Gr(Ve, { get lowStockAlert() {
              return c().lowStockAlert;
            }, get inventoryQuantity() {
              return e(Ee);
            } });
          }
        };
        j(we, (Ve) => {
          c().lowStockAlertEnabled && c().lowStockAlert && Ve(_e);
        });
        var ye = E(we, 2), Se = (Ve) => {
          var Ee = Xf(), ne = ve(Ee);
          {
            let Te = g(() => ({ ...i(), variants: e(C) }));
            Vr(ne, { get product() {
              return e(Te);
            } });
          }
          var ge = E(ne, 2);
          {
            let Te = g(() => ({ ...i(), variants: e(C) })), pe = g(() => e(U) || 0);
            Mn(ge, { get product() {
              return e(Te);
            }, get selectedVariantId() {
              return e(pe);
            }, onChange: Q });
          }
          v(Ve, Ee);
        };
        j(ye, (Ve) => {
          e(q) && Ve(Se);
        }), w(ie), w(ze), As(E(ze, 2), { get discountedPrice() {
          return e(K);
        }, get fullPrice() {
          return e(J);
        }, get unitPrice() {
          return e($);
        }, get unitPriceReference() {
          return e(N);
        }, get ignoreUnitPrice() {
          return r().ignoreUnitPrice;
        } }), v(re, fe);
      };
      j(ae, (re) => {
        u() === "horizontal" ? re(ee) : re(le, !1);
      }), w(O), v(L, O);
    };
    j(z, (L) => {
      i() && L(H);
    }), v(n, G);
    var Y = Ye(B);
    return l(), Y;
  }
  We(Cu, { dealBlock: {}, layout: {}, bundleProduct: {}, product: {}, dealBarSelected: {}, currentVariantId: {}, mainVariantId: {}, priceRounding: {}, sellingPlan: {}, dealBar: {}, sets: {}, onChange: {} }, [], [], !0);
  var nb = $n('<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="10" fill="currentColor"></circle><path fill="#fff" d="M5 9h10v2H5z"></path><path fill="#fff" d="M11 5v10H9V5z"></path></svg>');
  function Bu(n) {
    v(n, nb());
  }
  function rb(n, t, r) {
    t()({ dealBarId: r().id, preselected: !1 });
  }
  We(Bu, {}, [], [], !0);
  var ab = D('<img class="kaching-bundles__bar-image" alt=""/>'), ib = D('<div class="kaching-bundles__bar-radio"></div>'), lb = D('<span class="kaching-bundles__bar-title"><!></span>'), sb = D('<span class="kaching-bundles__bar-label"><!></span>'), ob = D('<div class="kaching-bundles__bar-subtitle"><!></div>'), cb = D('<div class="kaching-bundles__bar-full-price"><!></div>'), ub = D('<div class="kaching-bundles__bar-price"><!></div>'), db = D('<div class="kaching-bundles__bar-full-price"><!></div>'), gb = D('<div class="kaching-bundles__bar-pricing-row kaching-bundles__bar-pricing-row--secondary"><!> <!></div>'), hb = D('<div class="kaching-bundles__bar-pricing-row kaching-bundles__bar-pricing-row--main"><!> <!></div> <!>', 1), pb = D('<div class="kaching-bundles__bar-full-price"><!></div>'), fb = D("<!> <!>", 1), bb = D('<!> <div class="kaching-bundles__bar-content"><div class="kaching-bundles__bar-content-left"><div class="kaching-bundles__bar-first-line"><!> <!></div> <!></div> <div class="kaching-bundles__bar-pricing"><!></div></div>', 1), vb = D('<div class="kaching-bundles__bundle-products__product kaching-bundles__bundle-products__product--placeholder"><span>Select product</span></div>'), _b = D('<div class="kaching-bundles__bundle-products__divider"><div class="kaching-bundles__bundle-products__divider-line">&ZeroWidthSpace;</div> <div class="kaching-bundles__bundle-products__divider-icon"><!></div> <div class="kaching-bundles__bundle-products__divider-line">&ZeroWidthSpace;</div></div>'), kb = D("<!> <!>", 1), mb = D("<div></div>"), yb = D('<div><input type="radio"/> <label><!> <div class="kaching-bundles__bar-wrapper"><!> <!> <!> <!> <!></div> <!> <!> <!> <!></label> <!></div>');
  function Iu(n, t) {
    Je(t, !0);
    const r = () => Me(J, "$config", u), a = () => Me(X, "$formatPrice", u), l = () => Me(se, "$translate", u), c = () => Me(K, "$getMediaImageUrl", u), [u, s] = wt(), i = m(t, "dealBlock", 7), o = m(t, "dealBar", 7), d = m(t, "product", 7), h = m(t, "otherProducts", 23, () => []), f = m(t, "complementaryProducts", 23, () => []), p = m(t, "currentVariantId", 7), _ = m(t, "componentId", 7), I = m(t, "selectedDealBarIndex", 7), y = m(t, "selected", 7, !1), x = m(t, "sellingPlan", 7), M = m(t, "onProgressiveGiftsChange", 7), A = m(t, "onDealBarSelect", 7), V = m(t, "onDealBarDeselect", 7), C = m(t, "onVariantSelect", 7), R = m(t, "onVariantsChange", 7), U = m(t, "onPersonalisationsChange", 7), F = m(t, "personalisationInitialValues", 23, () => []), se = qt(), X = cn(), K = qn(), J = on();
    let N = Ae(rt({})), Z = Ae(rt([])), $ = Ae(rt([])), S = Ae(rt([])), T = Ae(1);
    const q = g(() => `${o().id}_${_()}`), W = g(() => o().bundleProducts.filter(({ productGID: de }) => de)), ue = g(() => e(W).every((de) => Se(de, d(), h()))), Q = g(() => o().showProductsOnlyWhenSelected && !y()), b = g(() => e(W).every((de) => {
      var $e;
      const je = Se(de, d(), h());
      return ($e = je == null ? void 0 : je.availableForSale) != null && $e;
    })), B = g(() => i() ? (function(de, $e) {
      return o().bundleProducts.map((st) => {
        const pt = $e[st.id];
        if (!pt) return 0;
        const { variant: ot, quantity: Ne } = pt;
        let it = ot.price;
        return ot.compareAtPrice && de.useProductCompareAtPrice && (it = Math.max(it, ot.compareAtPrice)), it * Ne;
      }).reduce((st, pt) => st + pt, 0);
    })(i(), e(N)) : 0), G = g(() => i().priceRounding ? { perItem: i().showPricesPerItem, precision: i().priceRoundingPrecision, v2: r().featureFlags.price_rounding_v2 || !1 } : void 0), z = g(() => i() ? xs(o(), e(N), r().currencyRate, e(G), x()) : 0), H = g(() => e(W).reduce((de, $e) => de + $e.quantity, 0) * e(T)), Y = g(() => Math.ceil(e(z) / (e(H) || 1))), L = g(() => Math.ceil(e(B) / (e(H) || 1))), O = g(() => e(B) > e(z)), ae = g(() => er(Object.values(e(N)))), ee = g(() => e(W).every((de) => de.productGID === "default" || Nt(de.productGID) === d().id)), le = g(() => {
      var de;
      const $e = e(W)[0];
      if ($e) return (de = e(N)[$e.id]) == null ? void 0 : de.variant.id;
    }), re = g(() => i().showPricesPerItem && e(ee)), fe = g(() => pn({ priceFormatter: a(), product: d(), dealBar: o(), totalFullPrice: e(B), totalDiscountedPrice: e(z), quantity: 1, unitQuantity: e(ae), sellingPlan: x() })), ze = g(() => e(fe)(l()(o().title))), ce = g(() => e(fe)(l()(o().subtitle))), ie = g(() => e(fe)(l()(o().label))), ke = g(() => e(fe)(l()(o().badgeText))), we = g(() => c()(o().badgeImageGID)), _e = g(() => c()(o().mediaImageGID) || zi);
    function ye(de) {
      y() && (de.preventDefault(), de.stopPropagation(), V()());
    }
    function Se(de, $e, je) {
      if (de.productGID) return de.productGID === "default" ? $e : je.find((st) => st.id === Nt(de.productGID));
    }
    ba(() => {
      y() && A()({ dealBarId: o().id, preselected: !0 });
    }), He(() => {
      y() && (Qr(e(N)), Qr(e(S)), Qr(e(Z)), Qr(e($)), x(), Xt(() => {
        (function() {
          if (!o().bundleProducts.map(({ id: ot }) => ot).every((ot) => e(N)[ot])) return;
          const de = [];
          for (const ot of o().bundleProducts) {
            const Ne = e(N)[ot.id];
            Ne && de.push({ id: ot.id, variant: Ne.variant, product: Ne.product, quantity: Ne.quantity });
          }
          if (de.length === 0) return;
          const $e = e(z) + e(S).reduce((ot, Ne) => ot + Ne.discountedPrice, 0), je = e(B) + e(S).reduce((ot, Ne) => ot + Ne.fullPrice, 0) + e(Z).reduce((ot, Ne) => ot + Ne.fullPrice, 0) + e($).reduce((ot, Ne) => ot + Ne.fullPrice * Ne.quantity, 0), st = xs(o(), e(N), r().currencyRate, e(G), void 0), pt = d().sellingPlans.map((ot) => ({ sellingPlanId: ot.id, discountedPrice: xs(o(), e(N), r().currencyRate, e(G), ot) }));
          R()({ bundleProducts: de, freeGifts: [...e(Z), ...e($)], upsells: e(S), pricing: { discountedPrice: $e, fullPrice: je, discountedPricePerItem: e(z), fullPricePerItem: e(B), discountedPriceWithoutSellingPlan: st, discountedPricesForSellingPlans: pt } });
        })();
      }));
    });
    const Ve = g(() => o().showAsSoldOutEnabled && o().showAsSoldOut ? $i(o().showAsSoldOut) : "");
    var Ee = { get dealBlock() {
      return i();
    }, set dealBlock(de) {
      i(de), k();
    }, get dealBar() {
      return o();
    }, set dealBar(de) {
      o(de), k();
    }, get product() {
      return d();
    }, set product(de) {
      d(de), k();
    }, get otherProducts() {
      return h();
    }, set otherProducts(de = []) {
      h(de), k();
    }, get complementaryProducts() {
      return f();
    }, set complementaryProducts(de = []) {
      f(de), k();
    }, get currentVariantId() {
      return p();
    }, set currentVariantId(de) {
      p(de), k();
    }, get componentId() {
      return _();
    }, set componentId(de) {
      _(de), k();
    }, get selectedDealBarIndex() {
      return I();
    }, set selectedDealBarIndex(de) {
      I(de), k();
    }, get selected() {
      return y();
    }, set selected(de = !1) {
      y(de), k();
    }, get sellingPlan() {
      return x();
    }, set sellingPlan(de) {
      x(de), k();
    }, get onProgressiveGiftsChange() {
      return M();
    }, set onProgressiveGiftsChange(de) {
      M(de), k();
    }, get onDealBarSelect() {
      return A();
    }, set onDealBarSelect(de) {
      A(de), k();
    }, get onDealBarDeselect() {
      return V();
    }, set onDealBarDeselect(de) {
      V(de), k();
    }, get onVariantSelect() {
      return C();
    }, set onVariantSelect(de) {
      C(de), k();
    }, get onVariantsChange() {
      return R();
    }, set onVariantsChange(de) {
      R(de), k();
    }, get onPersonalisationsChange() {
      return U();
    }, set onPersonalisationsChange(de) {
      U(de), k();
    }, get personalisationInitialValues() {
      return F();
    }, set personalisationInitialValues(de = []) {
      F(de), k();
    } }, ne = De(), ge = ve(ne), Te = (de) => {
      var $e = yb();
      let je;
      var st = P($e);
      qr(st), st.__change = [rb, A, o];
      var pt = E(st, 2);
      let ot;
      var Ne = P(pt);
      {
        let _t = g(() => e(ke) || void 0);
        wa(Ne, { get style() {
          return o().badgeStyle;
        }, get text() {
          return e(_t);
        }, get imageUrl() {
          return e(we);
        }, get blockLayout() {
          return i().blockLayout;
        } });
      }
      var it = E(Ne, 2), Et = P(it);
      Qt(Et, { element: "div", class: "kaching-bundles__bar-main", onclick: ye, children: (_t, Bt) => {
        var an = bb(), un = ve(an), yn = (vt) => {
          var St = ab();
          be(() => Pe(St, "src", e(_e))), v(vt, St);
        }, ln = (vt) => {
          v(vt, ib());
        };
        j(un, (vt) => {
          o().mediaImageGID ? vt(yn) : vt(ln, !1);
        });
        var xe = E(un, 2), Xe = P(xe), ut = P(Xe), he = P(ut);
        Ke(he, () => e(ze), (vt) => {
          var St = lb();
          qe(P(St), () => e(ze)), w(St), v(vt, St);
        });
        var Oe = E(he, 2), Ie = (vt) => {
          var St = De();
          Ke(ve(St), () => e(ie), (Rt) => {
            var At = sb();
            qe(P(At), () => e(ie)), w(At), v(Rt, At);
          }), v(vt, St);
        };
        j(Oe, (vt) => {
          e(ie) && vt(Ie);
        }), w(ut);
        var Fe = E(ut, 2), Ue = (vt) => {
          var St = De();
          Ke(ve(St), () => e(ce), (Rt) => {
            var At = ob();
            qe(P(At), () => e(ce)), w(At), v(Rt, At);
          }), v(vt, St);
        };
        j(Fe, (vt) => {
          e(ce) && vt(Ue);
        }), w(Xe);
        var ct = E(Xe, 2), jt = P(ct), Vt = (vt) => {
          var St = De(), Rt = ve(St), At = (dn) => {
            var Sn = hb(), Dn = ve(Sn), Ln = P(Dn);
            Ke(Ln, () => e(Y), (kt) => {
              yr(kt, { get amount() {
                return e(Y);
              }, get showPricesPerItem() {
                return e(re);
              }, get unitLabel() {
                return i().unitLabel;
              } });
            });
            var vn = E(Ln, 2), et = (kt) => {
              var _n = De();
              Ke(ve(_n), () => e(L), (oe) => {
                var Ge = cb();
                qe(P(Ge), () => a()(e(L))), w(Ge), be((Le) => Pe(Ge, "data-a11y-label", Le), [() => l()("system.original_price")]), v(oe, Ge);
              }), v(kt, _n);
            };
            j(vn, (kt) => {
              e(O) && kt(et);
            }), w(Dn);
            var bt = E(Dn, 2), Ut = (kt) => {
              var _n = gb(), oe = P(_n);
              Ke(oe, () => e(z), (Be) => {
                var nt = ub();
                qe(P(nt), () => a()(e(z))), w(nt), be((yt) => Pe(nt, "data-a11y-label", yt), [() => l()("system.price")]), v(Be, nt);
              });
              var Ge = E(oe, 2), Le = (Be) => {
                var nt = De();
                Ke(ve(nt), () => e(B), (yt) => {
                  var Ct = db();
                  qe(P(Ct), () => a()(e(B))), w(Ct), be((Ht) => Pe(Ct, "data-a11y-label", Ht), [() => l()("system.original_price")]), v(yt, Ct);
                }), v(Be, nt);
              };
              j(Ge, (Be) => {
                e(O) && Be(Le);
              }), w(_n), v(kt, _n);
            };
            j(bt, (kt) => {
              e(H) > 1 && kt(Ut);
            }), v(dn, Sn);
          }, Zt = (dn) => {
            var Sn = fb(), Dn = ve(Sn);
            Ke(Dn, () => e(z), (et) => {
              {
                let bt = g(() => e(re) ? e(Y) : e(z));
                yr(et, { get amount() {
                  return e(bt);
                }, get showPricesPerItem() {
                  return e(re);
                }, get unitLabel() {
                  return i().unitLabel;
                } });
              }
            });
            var Ln = E(Dn, 2), vn = (et) => {
              var bt = De();
              Ke(ve(bt), () => e(B), (Ut) => {
                var kt = pb();
                qe(P(kt), () => a()(e(re) ? e(L) : e(B))), w(kt), be((_n) => Pe(kt, "data-a11y-label", _n), [() => l()("system.original_price")]), v(Ut, kt);
              }), v(et, bt);
            };
            j(Ln, (et) => {
              e(O) && et(vn);
            }), v(dn, Sn);
          };
          j(Rt, (dn) => {
            i().showBothPrices && e(ee) ? dn(At) : dn(Zt, !1);
          }), v(vt, St);
        };
        j(jt, (vt) => {
          e(ue) && vt(Vt);
        }), w(ct), w(xe), v(_t, an);
      }, $$slots: { default: !0 } });
      var Pt = E(Et, 2), Ft = (_t) => {
        ea(_t, { get highlights() {
          return o().highlights;
        }, get isSelected() {
          return y();
        }, get replaceLiquid() {
          return e(fe);
        } });
      };
      j(Pt, (_t) => {
        o().highlights && _t(Ft);
      });
      var Dt = E(Pt, 2), Lt = (_t) => {
        qi(_t, { get value() {
          return e(T);
        }, onChange: (Bt) => {
          te(T, Bt, !0);
        } });
      };
      j(Dt, (_t) => {
        y() && o().quantitySelector && _t(Lt);
      });
      var Ce = E(Dt, 2), tt = (_t) => {
        var Bt = mb();
        let an;
        Jt(Bt, 23, () => o().bundleProducts, (un) => un.id, (un, yn, ln) => {
          var xe = kb(), Xe = ve(xe), ut = (Fe) => {
            {
              let Ue = g(() => Se(e(yn), d(), h())), ct = g(() => o().layout || "horizontal");
              Cu(Fe, { get dealBar() {
                return o();
              }, get bundleProduct() {
                return e(yn);
              }, get product() {
                return e(Ue);
              }, get dealBlock() {
                return i();
              }, get layout() {
                return e(ct);
              }, get dealBarSelected() {
                return y();
              }, get priceRounding() {
                return e(G);
              }, get currentVariantId() {
                return p();
              }, get mainVariantId() {
                return e(le);
              }, get sellingPlan() {
                return x();
              }, get sets() {
                return e(T);
              }, onChange: (jt) => (function(Vt, vt) {
                const { variant: St, product: Rt, quantity: At } = vt;
                e(N)[Vt] = { variant: St, product: Rt, quantity: At }, y() && o().bundleProducts.map(({ id: Zt }) => Zt).every((Zt) => e(N)[Zt]) && Vt === o().bundleProducts[0].id && C()({ variantId: St.id });
              })(e(yn).id, jt) });
            }
          }, he = (Fe) => {
            var Ue = De(), ct = ve(Ue), jt = (Vt) => {
              v(Vt, vb());
            };
            j(ct, (Vt) => {
              r().preview && Vt(jt);
            }, !0), v(Fe, Ue);
          };
          j(Xe, (Fe) => {
            e(yn).productGID ? Fe(ut) : Fe(he, !1);
          });
          var Oe = E(Xe, 2), Ie = (Fe) => {
            var Ue = _b(), ct = E(P(Ue), 2);
            Bu(P(ct)), w(ct), Rr(2), w(Ue), v(Fe, Ue);
          };
          j(Oe, (Fe) => {
            e(ln) < o().bundleProducts.length - 1 && Fe(Ie);
          }), v(un, xe);
        }), w(Bt), be((un) => an = Ot(Bt, 1, "kaching-bundles__bundle-products", null, an, un), [() => ({ "kaching-bundles__bundle-products--vertical": o().layout === "vertical", "kaching-bundles__bundle-products--hidden": e(Q) })]), v(_t, Bt);
      };
      j(Ce, (_t) => {
        e(ue) && _t(tt);
      });
      var ft = E(Ce, 2), gt = (_t) => {
        {
          let Bt = g(() => e(le) ? [e(le)] : []);
          Pa(_t, { get product() {
            return d();
          }, get productPersonalisation() {
            return o().productPersonalisation;
          }, get selectedVariantIds() {
            return e(Bt);
          }, get quantity() {
            return e(T);
          }, get addPersonalisationModal() {
            return i().addPersonalisationModal;
          }, get onPersonalisationsChange() {
            return U();
          }, get initialValues() {
            return F();
          } });
        }
      };
      j(ft, (_t) => {
        y() && o().productPersonalisation && (i().blockLayout === "vertical" || i().blockLayout === "plain") && _t(gt);
      }), w(it);
      var Qe = E(it, 2);
      {
        let _t = g(() => o().upsells || []);
        Ha(Qe, { get dealBlock() {
          return i();
        }, get upsells() {
          return e(_t);
        }, get otherProducts() {
          return h();
        }, get complementaryProducts() {
          return f();
        }, get dealBarSelected() {
          return y();
        }, get dealSellingPlan() {
          return x();
        }, get sets() {
          return e(T);
        }, onChange: (Bt) => {
          te(S, Bt, !0);
        } });
      }
      var at = E(Qe, 2);
      Ya(at, { get selectedDealBarIndex() {
        return I();
      }, get onChange() {
        return M();
      }, get dealBlock() {
        return i();
      }, get dealBar() {
        return o();
      }, get otherProducts() {
        return h();
      }, get selected() {
        return y();
      }, get progressiveGifts() {
        return i().progressiveGifts;
      } });
      var Ze = E(at, 2);
      {
        let _t = g(() => o().freeGifts || []);
        Ua(Ze, { get dealBlock() {
          return i();
        }, get freeGifts() {
          return e(_t);
        }, get otherProducts() {
          return h();
        }, get dealBarSelected() {
          return y();
        }, get sellingPlan() {
          return x();
        }, get sets() {
          return e(T);
        }, onChange: (Bt) => {
          te(Z, Bt, !0);
        } });
      }
      var zt = E(Ze, 2);
      {
        let _t = g(() => o().multipleGiftsSelectors || []);
        Ja(zt, { get dealBlock() {
          return i();
        }, get multipleGiftsSelectors() {
          return e(_t);
        }, get sellingPlan() {
          return x();
        }, get otherProducts() {
          return h();
        }, onChange: (Bt) => {
          te($, Bt, !0);
        } });
      }
      w(pt);
      var en = E(pt, 2), tn = (_t) => {
        Za(_t, { get showAsSoldOut() {
          return o().showAsSoldOut;
        }, get replaceLiquid() {
          return e(fe);
        } });
      };
      j(en, (_t) => {
        o().showAsSoldOutEnabled && o().showAsSoldOut && _t(tn);
      }), w($e), be((_t, Bt) => {
        var an;
        je = Ot($e, 1, "kaching-bundles__bar", null, je, _t), Pe($e, "data-deal-bar-id", o().id), Wt($e, e(Ve)), Pe(st, "name", `kaching-bundles-deal-${(an = _()) != null ? an : ""}`), va(st, o().id), Pe(st, "id", e(q)), Pi(st, y()), st.disabled = o().showAsSoldOutEnabled, Pe(pt, "for", e(q)), ot = Ot(pt, 1, "kaching-bundles__bar-container", null, ot, Bt);
      }, [() => ({ "kaching-bundles__bar--selected": y(), "kaching-bundles__bar--disabled": !e(b) && r().preview }), () => ({ "kaching-bundles__bar-container--sold-out": o().showAsSoldOutEnabled })]), v(de, $e);
    };
    j(ge, (de) => {
      (e(b) || r().preview) && de(Te);
    }), v(n, ne);
    var pe = Ye(Ee);
    return s(), pe;
  }
  Pn(["change"]), We(Iu, { dealBlock: {}, dealBar: {}, product: {}, otherProducts: {}, complementaryProducts: {}, currentVariantId: {}, componentId: {}, selectedDealBarIndex: {}, selected: {}, sellingPlan: {}, onProgressiveGiftsChange: {}, onDealBarSelect: {}, onDealBarDeselect: {}, onVariantSelect: {}, onVariantsChange: {}, onPersonalisationsChange: {}, personalisationInitialValues: {} }, [], [], !0);
  var xb = D('<img class="kaching-bundles__mix-and-match-choose-product__product-image" alt=""/>'), wb = D('<span class="kaching-bundles__mix-and-match-choose-product__product-title"> </span>'), Pb = D('<span class="kaching-bundles__mix-and-match-choose-product__subtitle"><!></span>'), Sb = D('<div class="kaching-bundles__mix-and-match-choose-product__product-price"><!></div>'), Cb = D('<div class="kaching-bundles__mix-and-match-choose-product__product-compare-at-price"><!></div>'), Bb = D('<div class="kaching-bundles__mix-and-match-choose-product__product-price-container"><!> <!></div>'), Ib = D("<div><!> <!></div>"), Mb = D('<div class="kaching-bundles__mix-and-match-choose-product__product"><div class="kaching-bundles__mix-and-match-choose-product__product-container"><!> <div class="kaching-bundles__mix-and-match-choose-product__product-content"><!> <!> <!> <!></div></div> <!></div>');
  function Mu(n, t) {
    var r;
    Je(t, !0);
    const a = () => Me(I, "$config", u), l = () => Me(_, "$formatPrice", u), c = () => Me(p, "$translate", u), [u, s] = wt(), i = m(t, "product", 7), o = m(t, "dealBlock", 7), d = m(t, "dealBar", 7), h = m(t, "modal", 7), f = m(t, "onChoose", 7), p = qt(), _ = cn(), I = on();
    let y = Ae(rt(((r = i().variants.find((G) => G.availableForSale)) == null ? void 0 : r.id) || i().variants[0].id));
    const x = g(() => i().variants.find((G) => G.id === e(y)) || i().variants[0]), M = g(() => o().priceRounding ? { perItem: !1, precision: o().priceRoundingPrecision, v2: a().featureFlags.price_rounding_v2 || !1 } : void 0), A = g(() => d().discountType === "percentage" ? Tr({ discountType: d().discountType, discountValue: d().discountValue, discountQuantity: 1, variantQuantities: [{ variant: e(x), quantity: 1 }], currencyRate: a().currencyRate, priceRounding: e(M) }) : e(x).price), V = g(() => o().useProductCompareAtPrice && e(x).compareAtPrice ? Math.max(e(x).price, e(x).compareAtPrice) : e(x).price), C = g(() => i().url ? `${i().url}?variant=${e(y)}` : void 0), R = g(() => pn({ priceFormatter: l(), product: i(), totalFullPrice: e(V), totalDiscountedPrice: e(A), quantity: 1, unitQuantity: null })), U = g(() => e(R)(c()(h().subtitle || ""))), F = g(() => h().buttonText);
    function se(G) {
      te(y, G, !0);
    }
    var X = { get product() {
      return i();
    }, set product(G) {
      i(G), k();
    }, get dealBlock() {
      return o();
    }, set dealBlock(G) {
      o(G), k();
    }, get dealBar() {
      return d();
    }, set dealBar(G) {
      d(G), k();
    }, get modal() {
      return h();
    }, set modal(G) {
      h(G), k();
    }, get onChoose() {
      return f();
    }, set onChoose(G) {
      f(G), k();
    } }, K = Mb(), J = P(K), N = P(J), Z = (G) => {
      Vn(G, { get url() {
        return e(C);
      }, class: "kaching-bundles__mix-and-match-choose-product__product-image-link", children: (z, H) => {
        var Y = xb();
        Pe(Y, "width", 100), Pe(Y, "height", 100), be(() => Pe(Y, "src", i().image)), v(z, Y);
      }, $$slots: { default: !0 } });
    };
    j(N, (G) => {
      i().image && G(Z);
    });
    var $ = E(N, 2), S = P($);
    Vn(S, { get url() {
      return e(C);
    }, class: "kaching-bundles__mix-and-match-choose-product__product-link", children: (G, z) => {
      var H = wb(), Y = P(H, !0);
      w(H), be(() => mt(Y, i().title)), v(G, H);
    }, $$slots: { default: !0 } });
    var T = E(S, 2), q = (G) => {
      var z = Pb();
      qe(P(z), () => e(U)), w(z), v(G, z);
    };
    j(T, (G) => {
      e(U) && G(q);
    });
    var W = E(T, 2), ue = (G) => {
      var z = Bb(), H = P(z);
      Ke(H, () => e(A), (O) => {
        var ae = Sb();
        qe(P(ae), () => l()(e(A))), w(ae), v(O, ae);
      });
      var Y = E(H, 2), L = (O) => {
        var ae = De();
        Ke(ve(ae), () => e(V), (ee) => {
          var le = Cb();
          qe(P(le), () => l()(e(V))), w(le), v(ee, le);
        }), v(O, ae);
      };
      j(Y, (O) => {
        e(V) && e(V) > e(A) && O(L);
      }), w(z), v(G, z);
    };
    j(W, (G) => {
      d().discountType !== "specific" && G(ue);
    });
    var Q = E(W, 2), b = (G) => {
      var z = Ib(), H = P(z);
      Vr(H, { get product() {
        return i();
      }, class: "kaching-bundles__mix-and-match-choose-product__product-option-names" }), Mn(E(H, 2), { get product() {
        return i();
      }, get selectedVariantId() {
        return e(y);
      }, onChange: se }), w(z), v(G, z);
    };
    j(Q, (G) => {
      i().variants.length > 1 && G(b);
    }), w($), w(J), Qt(E(J, 2), { element: "span", class: "kaching-bundles__mix-and-match-choose-product__product-button", onclick: function() {
      f()({ product: i(), variant: e(x) });
    }, children: (G, z) => {
      Rr();
      var H = In();
      be((Y) => mt(H, Y), [() => c()(e(F))]), v(G, H);
    }, $$slots: { default: !0 } }), w(K), v(n, K);
    var B = Ye(X);
    return s(), B;
  }
  We(Mu, { product: {}, dealBlock: {}, dealBar: {}, modal: {}, onChoose: {} }, [], [], !0);
  const Db = { red: 0, green: 0, blue: 0, alpha: 0.5 }, zb = { buttonSize: 16, textSize: 14, overlayColor: { red: 0, green: 0, blue: 0, alpha: 0.5 }, priceColor: { red: 0, green: 0, blue: 0, alpha: 1 }, compareAtPriceColor: { red: 128, green: 128, blue: 128, alpha: 1 }, textColor: { red: 0, green: 0, blue: 0, alpha: 1 }, buttonColor: { red: 0, green: 0, blue: 0, alpha: 1 }, buttonTextColor: { red: 255, green: 255, blue: 255, alpha: 1 }, productPhotoSize: 100, heading: "Select product", buttonText: "Choose" };
  var Ab = D('<img alt="Close"/>'), $b = D('<div class="kaching-bundles__mix-and-match-choose-product__empty-state"> </div>'), qb = D('<div class="kaching-bundles__mix-and-match-choose-product"><div class="kaching-bundles__mix-and-match-choose-product__header"><h2 class="kaching-bundles__mix-and-match-choose-product__heading"><!></h2> <!></div> <div class="kaching-bundles__mix-and-match-choose-product__products"><!></div></div>');
  function $s(n, t) {
    Je(t, !0);
    const r = () => Me(d, "$translate", a), [a, l] = wt(), c = m(t, "dealBlock", 7), u = m(t, "dealBar", 7), s = m(t, "products", 23, () => []), i = m(t, "onChoose", 7), o = m(t, "onClose", 7), d = qt(), h = g(() => {
      var X;
      return (X = c().mixAndMatchChooseProductModal) != null ? X : zb;
    }), f = g(() => ((X) => hn({ "kaching-mix-and-match-choose-product-button-size": X.buttonSize + "px", "kaching-mix-and-match-choose-product-text-size": X.textSize + "px", "kaching-mix-and-match-choose-product-price-color": Re(X.priceColor), "kaching-mix-and-match-choose-product-compare-at-price-color": Re(X.compareAtPriceColor), "kaching-mix-and-match-choose-product-text-color": Re(X.textColor), "kaching-mix-and-match-choose-product-button-color": Re(X.buttonColor), "kaching-mix-and-match-choose-product-button-text-color": Re(X.buttonTextColor), "kaching-mix-and-match-choose-product-photo-size": X.productPhotoSize + "px" }))(e(h)));
    var p = { get dealBlock() {
      return c();
    }, set dealBlock(X) {
      c(X), k();
    }, get dealBar() {
      return u();
    }, set dealBar(X) {
      u(X), k();
    }, get products() {
      return s();
    }, set products(X = []) {
      s(X), k();
    }, get onChoose() {
      return i();
    }, set onChoose(X) {
      i(X), k();
    }, get onClose() {
      return o();
    }, set onClose(X) {
      o(X), k();
    } }, _ = qb(), I = P(_), y = P(I), x = P(y), M = (X) => {
      var K = In();
      be((J) => mt(K, J), [() => r()(e(h).heading)]), v(X, K);
    };
    j(x, (X) => {
      e(h).heading && X(M);
    }), w(y);
    var A = E(y, 2), V = (X) => {
      Qt(X, { element: "span", class: "kaching-bundles__mix-and-match-choose-product__close", get onclick() {
        return o();
      }, children: (K, J) => {
        var N = Ab();
        be(() => Pe(N, "src", Ps)), v(K, N);
      }, $$slots: { default: !0 } });
    };
    j(A, (X) => {
      o() && X(V);
    }), w(I);
    var C = E(I, 2), R = P(C), U = (X) => {
      var K = $b(), J = P(K, !0);
      w(K), be((N) => mt(J, N), [() => r()("system.no_products_available")]), v(X, K);
    }, F = (X) => {
      var K = De();
      Jt(ve(K), 17, s, (J) => J.id, (J, N) => {
        Mu(J, { get dealBlock() {
          return c();
        }, get dealBar() {
          return u();
        }, get modal() {
          return e(h);
        }, get product() {
          return e(N);
        }, get onChoose() {
          return i();
        } });
      }), v(X, K);
    };
    j(R, (X) => {
      s().length === 0 ? X(U) : X(F, !1);
    }), w(C), w(_), be(() => Wt(_, e(f))), v(n, _);
    var se = Ye(p);
    return l(), se;
  }
  function Vb(n, t) {
    n.target === n.currentTarget && t()();
  }
  We($s, { dealBlock: {}, dealBar: {}, products: {}, onChoose: {}, onClose: {} }, [], [], !0);
  var Tb = D('<div class="kaching-bundles"><div class="kaching-bundles__mix-and-match-choose-product-modal" role="none"><div class="kaching-bundles__mix-and-match-choose-product-modal__content"><!></div></div></div>');
  function Du(n, t) {
    Je(t, !0);
    const r = m(t, "dealBlock", 7), a = m(t, "dealBar", 7), l = m(t, "products", 23, () => []), c = m(t, "isOpen", 7), u = m(t, "onChoose", 7), s = m(t, "onClose", 7);
    var i = { get dealBlock() {
      return r();
    }, set dealBlock(f) {
      r(f), k();
    }, get dealBar() {
      return a();
    }, set dealBar(f) {
      a(f), k();
    }, get products() {
      return l();
    }, set products(f = []) {
      l(f), k();
    }, get isOpen() {
      return c();
    }, set isOpen(f) {
      c(f), k();
    }, get onChoose() {
      return u();
    }, set onChoose(f) {
      u(f), k();
    }, get onClose() {
      return s();
    }, set onClose(f) {
      s(f), k();
    } }, o = De(), d = ve(o), h = (f) => {
      Ai(f, { target: "body", children: (p, _) => {
        var I = Tb(), y = P(I);
        y.__click = [Vb, s];
        var x = P(y);
        $s(P(x), { get dealBlock() {
          return r();
        }, get dealBar() {
          return a();
        }, get products() {
          return l();
        }, get onChoose() {
          return u();
        }, get onClose() {
          return s();
        } }), w(x), w(y), w(I), be((M) => Wt(y, M), [() => (function(M) {
          var A;
          return hn({ "kaching-mix-and-match-choose-product-overlay-color": Re(((A = M.mixAndMatchChooseProductModal) == null ? void 0 : A.overlayColor) || Db) });
        })(r())]), v(p, I);
      }, $$slots: { default: !0 } });
    };
    return j(d, (f) => {
      c() && f(h);
    }), v(n, o), Ye(i);
  }
  Pn(["click"]), We(Du, { dealBlock: {}, dealBar: {}, products: {}, isOpen: {}, onChoose: {}, onClose: {} }, [], [], !0);
  var Gb = D('<img alt="" class="kaching-bundles__mix-and-match-product__image"/>'), Ob = D('<div class="kaching-bundles__mix-and-match-product__image-placeholder"></div>'), Fb = D('<div class="kaching-bundles__mix-and-match-product__title"> </div>'), Lb = D('<div class="kaching-bundles__mix-and-match-product"><!> <div class="kaching-bundles__mix-and-match-product__content"><!> <!> <!></div> <!></div> <!>', 1);
  function zu(n, t) {
    Je(t, !0);
    const [r, a] = wt();
    let l = m(t, "dealBlock", 7), c = m(t, "dealBar", 7), u = m(t, "bundleProduct", 7), s = m(t, "product", 7), i = m(t, "swapProducts", 7), o = m(t, "dealBarSelected", 7), d = m(t, "currentVariantId", 7), h = m(t, "mainVariantId", 7), f = m(t, "onSwap", 7), p = m(t, "onChange", 7);
    const _ = cn(), I = qt();
    let y = Ae(void 0), x = Ae(!1);
    const M = g(() => o() && i().length > 0), A = g(() => Me(I, "$translate", r)(c().buttonText || "Change"));
    function V() {
      te(x, !0);
    }
    function C(b) {
      te(x, !1), te(y, b.variant.id, !0), f()(b.product);
    }
    function R() {
      te(x, !1);
    }
    const U = g(() => {
      var b, B;
      return (B = (b = s()) == null ? void 0 : b.variants) != null ? B : [];
    }), F = g(() => e(y) !== void 0 && e(U).some(({ id: b }) => b === e(y)) ? e(y) : u().productGID === "default" && d() ? d() : e(U).length > 0 ? e(U)[0].id : void 0), se = g(() => {
      var b;
      return e(F) ? (b = s()) == null ? void 0 : b.variants.find((B) => B.id === e(F)) : void 0;
    }), X = g(() => {
      var b;
      return (b = s()) != null && b.url && e(se) ? `${s().url}?variant=${e(se).id}` : void 0;
    }), K = g(() => {
      var b, B;
      return ((b = e(se)) == null ? void 0 : b.image) || ((B = s()) == null ? void 0 : B.image);
    }), J = g(() => o() && s() && e(U).length > 1 && e(F)), N = g(() => o() && u().productGID !== "default" ? e(X) : void 0), Z = g(() => s() ? u().title ? pn({ priceFormatter: Me(_, "$formatPrice", r), product: s(), totalFullPrice: 0, totalDiscountedPrice: 0, quantity: 1, unitQuantity: null })(u().title) : s().title : "");
    function $(b) {
      te(y, b, !0);
    }
    let S;
    He(() => {
      e(se) && Xt(() => {
        p()({ variant: e(se), product: s() });
      });
    }), Hn(() => {
      u().productGID, te(y, void 0), S = void 0;
    }), Hn(() => {
      const b = u().productGID === "default";
      if (!(b || !l().disableVariantOptionSync)) return;
      const B = b ? d() : h();
      if (!B || !s() || B === S) return;
      const G = S;
      if (S = B, !e(U).some((Y) => Y.id === B)) return;
      const z = e(y) === void 0, H = e(y) === G && G !== void 0;
      (z || H) && te(y, B, !0);
    });
    var T = { get dealBlock() {
      return l();
    }, set dealBlock(b) {
      l(b), k();
    }, get dealBar() {
      return c();
    }, set dealBar(b) {
      c(b), k();
    }, get bundleProduct() {
      return u();
    }, set bundleProduct(b) {
      u(b), k();
    }, get product() {
      return s();
    }, set product(b) {
      s(b), k();
    }, get swapProducts() {
      return i();
    }, set swapProducts(b) {
      i(b), k();
    }, get dealBarSelected() {
      return o();
    }, set dealBarSelected(b) {
      o(b), k();
    }, get currentVariantId() {
      return d();
    }, set currentVariantId(b) {
      d(b), k();
    }, get mainVariantId() {
      return h();
    }, set mainVariantId(b) {
      h(b), k();
    }, get onSwap() {
      return f();
    }, set onSwap(b) {
      f(b), k();
    }, get onChange() {
      return p();
    }, set onChange(b) {
      p(b), k();
    } }, q = De(), W = ve(q), ue = (b) => {
      var B = Lb(), G = ve(B), z = P(G), H = (ce) => {
        Vn(ce, { get url() {
          return e(N);
        }, class: "kaching-bundles__mix-and-match-product__image-link", children: (ie, ke) => {
          var we = Gb();
          Pe(we, "height", 50), Pe(we, "width", 50), be(() => Pe(we, "src", e(K))), v(ie, we);
        }, $$slots: { default: !0 } });
      }, Y = (ce) => {
        v(ce, Ob());
      };
      j(z, (ce) => {
        e(K) ? ce(H) : ce(Y, !1);
      });
      var L = E(z, 2), O = P(L);
      Vn(O, { get url() {
        return e(N);
      }, class: "kaching-bundles__mix-and-match-product__title-link", children: (ce, ie) => {
        var ke = Fb(), we = P(ke, !0);
        w(ke), be(() => mt(we, e(Z))), v(ce, ke);
      }, $$slots: { default: !0 } });
      var ae = E(O, 2), ee = (ce) => {
        {
          let ie = g(() => {
            var ke, we;
            return (we = (ke = e(se)) == null ? void 0 : ke.inventoryQuantity) != null ? we : null;
          });
          Gr(ce, { get lowStockAlert() {
            return l().lowStockAlert;
          }, get inventoryQuantity() {
            return e(ie);
          } });
        }
      };
      j(ae, (ce) => {
        l().lowStockAlertEnabled && l().lowStockAlert && ce(ee);
      });
      var le = E(ae, 2), re = (ce) => {
        {
          let ie = g(() => e(F) || 0);
          Mn(ce, { get product() {
            return s();
          }, get selectedVariantId() {
            return e(ie);
          }, onChange: $ });
        }
      };
      j(le, (ce) => {
        e(J) && ce(re);
      }), w(L);
      var fe = E(L, 2), ze = (ce) => {
        Qt(ce, { element: "div", class: "kaching-bundles__mix-and-match-product__swap-button", onclick: V, children: (ie, ke) => {
          Rr();
          var we = In();
          be(() => mt(we, e(A))), v(ie, we);
        }, $$slots: { default: !0 } });
      };
      j(fe, (ce) => {
        e(M) && ce(ze);
      }), w(G), Du(E(G, 2), { get dealBlock() {
        return l();
      }, get dealBar() {
        return c();
      }, get products() {
        return i();
      }, get isOpen() {
        return e(x);
      }, onChoose: C, onClose: R }), v(b, B);
    };
    j(W, (b) => {
      s() && b(ue);
    }), v(n, q);
    var Q = Ye(T);
    return a(), Q;
  }
  We(zu, { dealBlock: {}, dealBar: {}, bundleProduct: {}, product: {}, swapProducts: {}, dealBarSelected: {}, currentVariantId: {}, mainVariantId: {}, onSwap: {}, onChange: {} }, [], [], !0);
  var Eb = $n('<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 6.5V14.5M6.5 10.5H14.5M20.5 10.5C20.5 16.0228 16.0228 20.5 10.5 20.5C4.97715 20.5 0.5 16.0228 0.5 10.5C0.5 4.97715 4.97715 0.5 10.5 0.5C16.0228 0.5 20.5 4.97715 20.5 10.5Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path></svg>');
  function Au(n) {
    v(n, Eb());
  }
  function jb(n, t, r) {
    t()({ dealBarId: r().id, preselected: !1 });
  }
  We(Au, {}, [], [], !0);
  var Rb = D('<img class="kaching-bundles__bar-image" alt=""/>'), Qb = D('<div class="kaching-bundles__bar-radio"></div>'), Nb = D('<span class="kaching-bundles__bar-title"><!></span>'), Wb = D('<span class="kaching-bundles__bar-label"><!></span>'), Ub = D('<div class="kaching-bundles__bar-subtitle"><!></div>'), Hb = D('<div class="kaching-bundles__bar-full-price"><!></div>'), Zb = D("<!> <!>", 1), Jb = D('<!> <div class="kaching-bundles__bar-content"><div class="kaching-bundles__bar-content-left"><div class="kaching-bundles__bar-first-line"><!> <!></div> <!></div> <div class="kaching-bundles__bar-pricing"><!></div></div>', 1), Yb = D('<div class="kaching-bundles__mix-and-match-products__placeholder"><span>Select product</span></div>'), Kb = D('<div class="kaching-bundles__mix-and-match-products__divider"><div class="kaching-bundles__mix-and-match-products__divider-line">&ZeroWidthSpace;</div> <div class="kaching-bundles__mix-and-match-products__divider-icon"><!></div> <div class="kaching-bundles__mix-and-match-products__divider-line">&ZeroWidthSpace;</div></div>'), Xb = D("<!> <!>", 1), ev = D('<div class="kaching-bundles__mix-and-match-products"></div>'), tv = D('<div><input type="radio"/> <label><!> <div class="kaching-bundles__bar-wrapper"><!> <!> <!> <!></div> <!> <!> <!> <!></label> <!></div>');
  function $u(n, t) {
    Je(t, !0);
    const r = () => Me(J, "$config", u), a = () => Me(X, "$formatPrice", u), l = () => Me(se, "$translate", u), c = () => Me(K, "$getMediaImageUrl", u), [u, s] = wt(), i = m(t, "dealBlock", 7), o = m(t, "dealBar", 7), d = m(t, "product", 7), h = m(t, "otherProducts", 23, () => []), f = m(t, "complementaryProducts", 23, () => []), p = m(t, "currentVariantId", 7), _ = m(t, "componentId", 7), I = m(t, "selectedDealBarIndex", 7), y = m(t, "selected", 7, !1), x = m(t, "sellingPlan", 7), M = m(t, "onProgressiveGiftsChange", 7), A = m(t, "onDealBarSelect", 7), V = m(t, "onDealBarDeselect", 7), C = m(t, "onVariantSelect", 7), R = m(t, "onVariantsChange", 7), U = m(t, "onPersonalisationsChange", 7), F = m(t, "personalisationInitialValues", 23, () => []), se = qt(), X = cn(), K = qn(), J = on();
    let N = Ae(rt({})), Z = Ae(rt({}));
    const $ = g(() => Object.fromEntries(o().bundleProducts.map((ne) => [ne.id, S(ne)])));
    function S(ne) {
      const ge = ne.selectedProducts;
      if (!ge || ge.length === 0) return [];
      const Te = new Set(ge.map(($e) => Nt($e.id))), pe = h().filter(($e) => Te.has($e.id)), de = T(ne.productGID);
      return de ? [de, ...pe.filter(($e) => $e.id !== de.id)] : pe;
    }
    function T(ne) {
      if (!ne) return;
      if (ne === "default") return d();
      const ge = Nt(ne);
      return h().find((Te) => Te.id === ge);
    }
    let q = Ae(rt([])), W = Ae(rt([])), ue = Ae(rt([]));
    const Q = g(() => `${o().id}_${_()}`), b = g(() => o().bundleProducts.filter(({ productGID: ne }) => ne)), B = g(() => e(b).every((ne) => ke(ne))), G = g(() => e(b).every((ne) => {
      var ge, Te;
      return (Te = (ge = ke(ne)) == null ? void 0 : ge.availableForSale) != null && Te;
    })), z = g(() => {
      return i() ? (ne = i(), ge = e(N), o().bundleProducts.map((Te) => {
        const pe = ge[Te.id];
        if (!pe) return 0;
        const { variant: de } = pe;
        let $e = de.price;
        return de.compareAtPrice && ne.useProductCompareAtPrice && ($e = Math.max($e, de.compareAtPrice)), $e;
      }).reduce((Te, pe) => Te + pe, 0)) : 0;
      var ne, ge;
    }), H = g(() => i().priceRounding ? { perItem: !1, precision: i().priceRoundingPrecision, v2: r().featureFlags.price_rounding_v2 || !1 } : void 0), Y = g(() => i() ? ws(o(), e(N), r().currencyRate, e(H), x()) : 0), L = g(() => e(z) > e(Y)), O = g(() => {
      var ne;
      const ge = e(b)[0];
      if (ge) return (ne = e(N)[ge.id]) == null ? void 0 : ne.variant.id;
    }), ae = g(() => pn({ priceFormatter: a(), product: d(), dealBar: o(), totalFullPrice: e(z), totalDiscountedPrice: e(Y), quantity: 1, unitQuantity: null, sellingPlan: x() })), ee = g(() => e(ae)(l()(o().title))), le = g(() => e(ae)(l()(o().subtitle))), re = g(() => e(ae)(l()(o().label))), fe = g(() => e(ae)(l()(o().badgeText))), ze = g(() => c()(o().badgeImageGID)), ce = g(() => c()(o().mediaImageGID) || zi);
    function ie(ne) {
      y() && (ne.preventDefault(), ne.stopPropagation(), V()());
    }
    function ke(ne) {
      var ge;
      return (ge = e(Z)[ne.id]) != null ? ge : T(ne.productGID);
    }
    ba(() => {
      y() && A()({ dealBarId: o().id, preselected: !0 });
    }), He(() => {
      y() && (Qr(e(N)), Qr(e(ue)), Qr(e(q)), Qr(e(W)), x(), Xt(() => {
        (function() {
          if (!o().bundleProducts.map(({ id: $e }) => $e).every(($e) => e(N)[$e])) return;
          const ne = [];
          for (const $e of o().bundleProducts) {
            const je = e(N)[$e.id];
            je && ne.push({ id: $e.id, variant: je.variant, product: je.product, quantity: 1 });
          }
          if (ne.length === 0) return;
          const ge = e(Y) + e(ue).reduce(($e, je) => $e + je.discountedPrice, 0), Te = e(z) + e(ue).reduce(($e, je) => $e + je.fullPrice, 0) + e(q).reduce(($e, je) => $e + je.fullPrice, 0) + e(W).reduce(($e, je) => $e + je.fullPrice * je.quantity, 0), pe = ws(o(), e(N), r().currencyRate, e(H), void 0), de = d().sellingPlans.map(($e) => ({ sellingPlanId: $e.id, discountedPrice: ws(o(), e(N), r().currencyRate, e(H), $e) }));
          R()({ bundleProducts: ne, freeGifts: [...e(q), ...e(W)], upsells: e(ue), pricing: { discountedPrice: ge, fullPrice: Te, discountedPricePerItem: e(Y), fullPricePerItem: e(z), discountedPriceWithoutSellingPlan: pe, discountedPricesForSellingPlans: de } });
        })();
      }));
    });
    const we = g(() => o().showAsSoldOutEnabled && o().showAsSoldOut ? $i(o().showAsSoldOut) : "");
    var _e = { get dealBlock() {
      return i();
    }, set dealBlock(ne) {
      i(ne), k();
    }, get dealBar() {
      return o();
    }, set dealBar(ne) {
      o(ne), k();
    }, get product() {
      return d();
    }, set product(ne) {
      d(ne), k();
    }, get otherProducts() {
      return h();
    }, set otherProducts(ne = []) {
      h(ne), k();
    }, get complementaryProducts() {
      return f();
    }, set complementaryProducts(ne = []) {
      f(ne), k();
    }, get currentVariantId() {
      return p();
    }, set currentVariantId(ne) {
      p(ne), k();
    }, get componentId() {
      return _();
    }, set componentId(ne) {
      _(ne), k();
    }, get selectedDealBarIndex() {
      return I();
    }, set selectedDealBarIndex(ne) {
      I(ne), k();
    }, get selected() {
      return y();
    }, set selected(ne = !1) {
      y(ne), k();
    }, get sellingPlan() {
      return x();
    }, set sellingPlan(ne) {
      x(ne), k();
    }, get onProgressiveGiftsChange() {
      return M();
    }, set onProgressiveGiftsChange(ne) {
      M(ne), k();
    }, get onDealBarSelect() {
      return A();
    }, set onDealBarSelect(ne) {
      A(ne), k();
    }, get onDealBarDeselect() {
      return V();
    }, set onDealBarDeselect(ne) {
      V(ne), k();
    }, get onVariantSelect() {
      return C();
    }, set onVariantSelect(ne) {
      C(ne), k();
    }, get onVariantsChange() {
      return R();
    }, set onVariantsChange(ne) {
      R(ne), k();
    }, get onPersonalisationsChange() {
      return U();
    }, set onPersonalisationsChange(ne) {
      U(ne), k();
    }, get personalisationInitialValues() {
      return F();
    }, set personalisationInitialValues(ne = []) {
      F(ne), k();
    } }, ye = De(), Se = ve(ye), Ve = (ne) => {
      var ge = tv();
      let Te;
      var pe = P(ge);
      qr(pe), pe.__change = [jb, A, o];
      var de = E(pe, 2);
      let $e;
      var je = P(de);
      {
        let Qe = g(() => e(fe) || void 0);
        wa(je, { get style() {
          return o().badgeStyle;
        }, get text() {
          return e(Qe);
        }, get imageUrl() {
          return e(ze);
        }, get blockLayout() {
          return i().blockLayout;
        } });
      }
      var st = E(je, 2), pt = P(st);
      Qt(pt, { element: "div", class: "kaching-bundles__bar-main", onclick: ie, children: (Qe, at) => {
        var Ze = Jb(), zt = ve(Ze), en = (Ie) => {
          var Fe = Rb();
          be(() => Pe(Fe, "src", e(ce))), v(Ie, Fe);
        }, tn = (Ie) => {
          v(Ie, Qb());
        };
        j(zt, (Ie) => {
          o().mediaImageGID ? Ie(en) : Ie(tn, !1);
        });
        var _t = E(zt, 2), Bt = P(_t), an = P(Bt), un = P(an);
        Ke(un, () => e(ee), (Ie) => {
          var Fe = Nb();
          qe(P(Fe), () => e(ee)), w(Fe), v(Ie, Fe);
        });
        var yn = E(un, 2), ln = (Ie) => {
          var Fe = De();
          Ke(ve(Fe), () => e(re), (Ue) => {
            var ct = Wb();
            qe(P(ct), () => e(re)), w(ct), v(Ue, ct);
          }), v(Ie, Fe);
        };
        j(yn, (Ie) => {
          e(re) && Ie(ln);
        }), w(an);
        var xe = E(an, 2), Xe = (Ie) => {
          var Fe = De();
          Ke(ve(Fe), () => e(le), (Ue) => {
            var ct = Ub();
            qe(P(ct), () => e(le)), w(ct), v(Ue, ct);
          }), v(Ie, Fe);
        };
        j(xe, (Ie) => {
          e(le) && Ie(Xe);
        }), w(Bt);
        var ut = E(Bt, 2), he = P(ut), Oe = (Ie) => {
          var Fe = Zb(), Ue = ve(Fe);
          Ke(Ue, () => e(Y), (Vt) => {
            yr(Vt, { get amount() {
              return e(Y);
            }, showPricesPerItem: !1, get unitLabel() {
              return i().unitLabel;
            } });
          });
          var ct = E(Ue, 2), jt = (Vt) => {
            var vt = De();
            Ke(ve(vt), () => e(z), (St) => {
              var Rt = Hb();
              qe(P(Rt), () => a()(e(z))), w(Rt), be((At) => Pe(Rt, "data-a11y-label", At), [() => l()("system.original_price")]), v(St, Rt);
            }), v(Vt, vt);
          };
          j(ct, (Vt) => {
            e(L) && Vt(jt);
          }), v(Ie, Fe);
        };
        j(he, (Ie) => {
          e(B) && Ie(Oe);
        }), w(ut), w(_t), v(Qe, Ze);
      }, $$slots: { default: !0 } });
      var ot = E(pt, 2), Ne = (Qe) => {
        ea(Qe, { get highlights() {
          return o().highlights;
        }, get isSelected() {
          return y();
        }, get replaceLiquid() {
          return e(ae);
        } });
      };
      j(ot, (Qe) => {
        o().highlights && Qe(Ne);
      });
      var it = E(ot, 2), Et = (Qe) => {
        var at = ev();
        Jt(at, 23, () => o().bundleProducts, (Ze) => Ze.id, (Ze, zt, en) => {
          var tn = Xb(), _t = ve(tn), Bt = (ln) => {
            {
              let xe = g(() => ke(e(zt)));
              zu(ln, { get bundleProduct() {
                return e(zt);
              }, get product() {
                return e(xe);
              }, get swapProducts() {
                return e($)[e(zt).id];
              }, get dealBlock() {
                return i();
              }, get dealBar() {
                return o();
              }, get dealBarSelected() {
                return y();
              }, get currentVariantId() {
                return p();
              }, get mainVariantId() {
                return e(O);
              }, onSwap: (Xe) => (function(ut, he) {
                e(Z)[ut] = he;
              })(e(zt).id, Xe), onChange: (Xe) => (function(ut, he) {
                const { variant: Oe, product: Ie } = he;
                e(N)[ut] = { variant: Oe, product: Ie }, y() && o().bundleProducts.map(({ id: Fe }) => Fe).every((Fe) => e(N)[Fe]) && ut === o().bundleProducts[0].id && C()({ variantId: Oe.id });
              })(e(zt).id, Xe) });
            }
          }, an = (ln) => {
            var xe = De(), Xe = ve(xe), ut = (he) => {
              v(he, Yb());
            };
            j(Xe, (he) => {
              r().preview && he(ut);
            }, !0), v(ln, xe);
          };
          j(_t, (ln) => {
            e(zt).productGID ? ln(Bt) : ln(an, !1);
          });
          var un = E(_t, 2), yn = (ln) => {
            var xe = Kb(), Xe = E(P(xe), 2);
            Au(P(Xe)), w(Xe), Rr(2), w(xe), v(ln, xe);
          };
          j(un, (ln) => {
            e(en) < o().bundleProducts.length - 1 && ln(yn);
          }), v(Ze, tn);
        }), w(at), v(Qe, at);
      };
      j(it, (Qe) => {
        e(B) && Qe(Et);
      });
      var Pt = E(it, 2), Ft = (Qe) => {
        {
          let at = g(() => e(O) ? [e(O)] : []);
          Pa(Qe, { get product() {
            return d();
          }, get productPersonalisation() {
            return o().productPersonalisation;
          }, get selectedVariantIds() {
            return e(at);
          }, quantity: 1, get addPersonalisationModal() {
            return i().addPersonalisationModal;
          }, get onPersonalisationsChange() {
            return U();
          }, get initialValues() {
            return F();
          } });
        }
      };
      j(Pt, (Qe) => {
        y() && o().productPersonalisation && (i().blockLayout === "vertical" || i().blockLayout === "plain") && Qe(Ft);
      }), w(st);
      var Dt = E(st, 2);
      {
        let Qe = g(() => o().upsells || []);
        Ha(Dt, { get dealBlock() {
          return i();
        }, get upsells() {
          return e(Qe);
        }, get otherProducts() {
          return h();
        }, get complementaryProducts() {
          return f();
        }, get dealBarSelected() {
          return y();
        }, get dealSellingPlan() {
          return x();
        }, sets: 1, onChange: (at) => {
          te(ue, at, !0);
        } });
      }
      var Lt = E(Dt, 2);
      {
        let Qe = g(() => ({ ...o(), dealBarType: "bundle", quantitySelector: !1, bundleProducts: o().bundleProducts.map((at) => ({ ...at, quantity: 1, variantGIDs: null, defaultVariantGID: null, mediaImageGID: null, discountType: "default", discountValue: 0 })) }));
        Ya(Lt, { get selectedDealBarIndex() {
          return I();
        }, get onChange() {
          return M();
        }, get dealBlock() {
          return i();
        }, get dealBar() {
          return e(Qe);
        }, get otherProducts() {
          return h();
        }, get selected() {
          return y();
        }, get progressiveGifts() {
          return i().progressiveGifts;
        } });
      }
      var Ce = E(Lt, 2);
      {
        let Qe = g(() => o().freeGifts || []);
        Ua(Ce, { get dealBlock() {
          return i();
        }, get freeGifts() {
          return e(Qe);
        }, get otherProducts() {
          return h();
        }, get dealBarSelected() {
          return y();
        }, get sellingPlan() {
          return x();
        }, sets: 1, onChange: (at) => {
          te(q, at, !0);
        } });
      }
      var tt = E(Ce, 2);
      {
        let Qe = g(() => o().multipleGiftsSelectors || []);
        Ja(tt, { get dealBlock() {
          return i();
        }, get multipleGiftsSelectors() {
          return e(Qe);
        }, get sellingPlan() {
          return x();
        }, get otherProducts() {
          return h();
        }, onChange: (at) => {
          te(W, at, !0);
        } });
      }
      w(de);
      var ft = E(de, 2), gt = (Qe) => {
        Za(Qe, { get showAsSoldOut() {
          return o().showAsSoldOut;
        }, get replaceLiquid() {
          return e(ae);
        } });
      };
      j(ft, (Qe) => {
        o().showAsSoldOutEnabled && o().showAsSoldOut && Qe(gt);
      }), w(ge), be((Qe, at) => {
        var Ze;
        Te = Ot(ge, 1, "kaching-bundles__bar", null, Te, Qe), Pe(ge, "data-deal-bar-id", o().id), Wt(ge, e(we)), Pe(pe, "name", `kaching-bundles-deal-${(Ze = _()) != null ? Ze : ""}`), va(pe, o().id), Pe(pe, "id", e(Q)), Pi(pe, y()), pe.disabled = o().showAsSoldOutEnabled, Pe(de, "for", e(Q)), $e = Ot(de, 1, "kaching-bundles__bar-container", null, $e, at);
      }, [() => ({ "kaching-bundles__bar--selected": y(), "kaching-bundles__bar--disabled": !e(G) && r().preview }), () => ({ "kaching-bundles__bar-container--sold-out": o().showAsSoldOutEnabled })]), v(ne, ge);
    };
    j(Se, (ne) => {
      (e(G) || r().preview) && ne(Ve);
    }), v(n, ye);
    var Ee = Ye(_e);
    return s(), Ee;
  }
  Pn(["change"]), We($u, { dealBlock: {}, dealBar: {}, product: {}, otherProducts: {}, complementaryProducts: {}, currentVariantId: {}, componentId: {}, selectedDealBarIndex: {}, selected: {}, sellingPlan: {}, onProgressiveGiftsChange: {}, onDealBarSelect: {}, onDealBarDeselect: {}, onVariantSelect: {}, onVariantsChange: {}, onPersonalisationsChange: {}, personalisationInitialValues: {} }, [], [], !0);
  var nv = $n('<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M27.2008 16C27.2008 18.9705 26.0208 21.8192 23.9204 23.9196C21.82 26.0201 18.9712 27.2 16.0008 27.2C13.0304 27.2 10.1816 26.0201 8.08119 23.9196C5.98078 21.8192 4.80078 18.9705 4.80078 16C4.80078 13.0296 5.98078 10.1809 8.08119 8.08045C10.1816 5.98005 13.0304 4.80005 16.0008 4.80005C18.9712 4.80005 21.82 5.98005 23.9204 8.08045C26.0208 10.1809 27.2008 13.0296 27.2008 16ZM10.0008 16C10.0008 15.6818 10.1272 15.3766 10.3523 15.1515C10.5773 14.9265 10.8825 14.8 11.2008 14.8H14.8008V11.2C14.8008 10.8818 14.9272 10.5766 15.1523 10.3515C15.3773 10.1265 15.6825 10 16.0008 10C16.319 10 16.6243 10.1265 16.8493 10.3515C17.0744 10.5766 17.2008 10.8818 17.2008 11.2V14.8H20.8008C21.119 14.8 21.4243 14.9265 21.6493 15.1515C21.8744 15.3766 22.0008 15.6818 22.0008 16C22.0008 16.3183 21.8744 16.6235 21.6493 16.8486C21.4243 17.0736 21.119 17.2 20.8008 17.2H17.2008V20.8C17.2008 21.1183 17.0744 21.4235 16.8493 21.6486C16.6243 21.8736 16.319 22 16.0008 22C15.6825 22 15.3773 21.8736 15.1523 21.6486C14.9272 21.4235 14.8008 21.1183 14.8008 20.8V17.2H11.2008C10.8825 17.2 10.5773 17.0736 10.3523 16.8486C10.1272 16.6235 10.0008 16.3183 10.0008 16Z" fill="currentColor"></path></svg>');
  function qu(n, t) {
    Je(t, !0);
    let r = m(t, "class", 7);
    var a = { get class() {
      return r();
    }, set class(c) {
      r(c), k();
    } }, l = nv();
    return be(() => Ot(l, 0, mi(r()))), v(n, l), Ye(a);
  }
  We(qu, { class: {} }, [], [], !0);
  const qs = Jr({}), Vs = Jr(!1);
  function Vi(n) {
    Vs.set(n);
  }
  function Pl(n, t) {
    qs.update((r) => ({ ...r, [n]: t }));
  }
  const rv = (n) => {
    const { collectionBreaks: t, colors: r, cornerRadius: a } = n;
    return t ? hn({ "kaching-collection-breaks-product-photo-size": t.productPhotoSize + "px", "kaching-collection-breaks-button-color": t.buttonColor && Re(t.buttonColor), "kaching-collection-breaks-product-title-color": Re(r.title), "kaching-collection-breaks-image-border-radius": (a || 0) / 2 + "px" }) : "";
  };
  function av(n, t) {
    n.target === n.currentTarget && te(t, !1);
  }
  var iv = D('<img class="kaching-bundles__collection-product__image" alt=""/>'), lv = D('<span class="kaching-bundles__collection-product__title"> </span>'), sv = D("<!> <!>", 1), ov = D('<img alt=""/>'), cv = D('<div class="kaching-bundles__collection-product"><div class="kaching-bundles__collection-product__main"><!> <div class="kaching-bundles__collection-product__content"><!> <!> <!></div></div> <!></div>'), uv = D('<img class="kaching-bundles__collection-product__image" alt="" height="40" width="40"/>'), dv = D('<div class="kaching-bundles"><div class="kaching-bundles__choose-product-modal" role="none"><div class="kaching-bundles__choose-product-modal__content"><!></div></div></div>'), gv = D('<div><div class="kaching-bundles__collection-product__main"><!> <!></div> <!></div>');
  function Ts(n, t) {
    Je(t, !0);
    const r = () => Me(_, "$config", a), [a, l] = wt(), c = m(t, "dealBlock", 7), u = m(t, "dealBar", 7), s = m(t, "mainProduct", 7, null), i = m(t, "products", 7), o = m(t, "selectedProductVariant", 7, null), d = m(t, "onChange", 7), h = m(t, "onRemove", 7), f = qt(), p = qn(), _ = on();
    let I = Ae(!1);
    const y = g(() => c().collectionBreaks), x = g(() => {
      var q;
      return ((q = o()) == null ? void 0 : q.product) || s();
    }), M = g(() => {
      var q, W;
      return ((q = o()) == null ? void 0 : q.variant) || ((W = e(x)) == null ? void 0 : W.variants[0]) || null;
    }), A = g(() => Me(p, "$getMediaImageUrl", a)(e(y).mediaImageGID)), V = g(() => Me(f, "$translate", a)(e(y).buttonText)), C = g(() => e(y).requireItemSelectionAlert), R = g(() => e(y).requireItemSelectionEnabled), U = g(() => r().preview && r().previewAlerts || Me(Vs, "$requireSelectionError", a)), F = g(() => {
      var q, W;
      return (q = e(x)) != null && q.url ? `${e(x).url}?variant=${(W = e(M)) == null ? void 0 : W.id}` : void 0;
    });
    function se(q) {
      te(I, !1), d()(q);
    }
    function X() {
      var q;
      (q = h()) == null || q();
    }
    function K(q) {
      const W = e(x).variants.find((ue) => ue.id === q);
      W && d()({ product: e(x), variant: W });
    }
    var J = { get dealBlock() {
      return c();
    }, set dealBlock(q) {
      c(q), k();
    }, get dealBar() {
      return u();
    }, set dealBar(q) {
      u(q), k();
    }, get mainProduct() {
      return s();
    }, set mainProduct(q = null) {
      s(q), k();
    }, get products() {
      return i();
    }, set products(q) {
      i(q), k();
    }, get selectedProductVariant() {
      return o();
    }, set selectedProductVariant(q = null) {
      o(q), k();
    }, get onChange() {
      return d();
    }, set onChange(q) {
      d(q), k();
    }, get onRemove() {
      return h();
    }, set onRemove(q) {
      h(q), k();
    } }, N = De(), Z = ve(N), $ = (q) => {
      var W = cv(), ue = P(W), Q = P(ue);
      {
        let ee = g(() => s() ? void 0 : e(F));
        Vn(Q, { get url() {
          return e(ee);
        }, class: "kaching-bundles__collection-product__link", children: (le, re) => {
          var fe = iv();
          be(() => Pe(fe, "src", e(M).image || e(x).image)), v(le, fe);
        }, $$slots: { default: !0 } });
      }
      var b = E(Q, 2), B = P(b), G = (ee) => {
        {
          let le = g(() => s() ? void 0 : e(F));
          Vn(ee, { get url() {
            return e(le);
          }, class: "kaching-bundles__collection-product__link", children: (re, fe) => {
            var ze = lv(), ce = P(ze, !0);
            w(ze), be(() => mt(ce, e(x).title)), v(re, ze);
          }, $$slots: { default: !0 } });
        }
      };
      j(B, (ee) => {
        e(y).showProductName && ee(G);
      });
      var z = E(B, 2), H = (ee) => {
        var le = sv(), re = ve(le);
        Vr(re, { get product() {
          return e(x);
        } });
        var fe = E(re, 2);
        {
          let ze = g(() => {
            var ce;
            return (ce = e(M)) == null ? void 0 : ce.id;
          });
          Mn(fe, { get product() {
            return e(x);
          }, get selectedVariantId() {
            return e(ze);
          }, onChange: K });
        }
        v(ee, le);
      };
      j(z, (ee) => {
        e(x).variants.length > 1 && ee(H);
      });
      var Y = E(z, 2), L = (ee) => {
        Gr(ee, { get lowStockAlert() {
          return c().lowStockAlert;
        }, get inventoryQuantity() {
          return e(M).inventoryQuantity;
        } });
      };
      j(Y, (ee) => {
        c().lowStockAlertEnabled && c().lowStockAlert && ee(L);
      }), w(b), w(ue);
      var O = E(ue, 2), ae = (ee) => {
        Qt(ee, { element: "div", class: "kaching-bundles__collection-product__remove-button", "aria-label": "Remove product", onclick: X, children: (le, re) => {
          var fe = ov();
          be(() => Pe(fe, "src", "data:image/svg+xml,%3csvg%20width='12'%20height='12'%20viewBox='0%200%2012%2012'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M11%201L1%2011M1%201L11%2011'%20stroke='%23344054'%20stroke-width='2'%20stroke-linecap='round'%20stroke-linejoin='round'/%3e%3c/svg%3e")), v(le, fe);
        }, $$slots: { default: !0 } });
      };
      j(O, (ee) => {
        s() || ee(ae);
      }), w(W), v(q, W);
    }, S = (q) => {
      var W = gv();
      let ue;
      var Q = P(W), b = P(Q);
      Qt(b, { element: "div", class: "kaching-bundles__collection-product__choose-product-image", onclick: () => {
        te(I, !0);
      }, children: (Y, L) => {
        var O = De(), ae = ve(O), ee = (re) => {
          var fe = De(), ze = ve(fe), ce = (ie) => {
            var ke = uv();
            be(() => Pe(ke, "src", e(A))), v(ie, ke);
          };
          j(ze, (ie) => {
            e(A) && ie(ce);
          }), v(re, fe);
        }, le = (re) => {
          qu(re, { class: "kaching-bundles__collection-product__image kaching-bundles__collection-product__image--default" });
        };
        j(ae, (re) => {
          e(y).mediaImageGID ? re(ee) : re(le, !1);
        }), v(Y, O);
      }, $$slots: { default: !0 } });
      var B = E(b, 2), G = (Y) => {
        Qt(Y, { element: "div", class: "kaching-bundles__collection-product__choose-product-button", onclick: () => {
          te(I, !0);
        }, children: (L, O) => {
          Rr();
          var ae = In();
          be(() => mt(ae, e(V))), v(L, ae);
        }, $$slots: { default: !0 } });
      };
      j(B, (Y) => {
        e(V) && Y(G);
      }), w(Q);
      var z = E(Q, 2), H = (Y) => {
        Ai(Y, { target: "body", children: (L, O) => {
          var ae = dv(), ee = P(ae);
          ee.__click = [av, I];
          var le = P(ee);
          Ss(P(le), { get dealBlock() {
            return c();
          }, get dealBar() {
            return u();
          }, get products() {
            return i();
          }, onChoose: se, onClose: () => {
            te(I, !1);
          } }), w(le), w(ee), w(ae), be((re) => Wt(ee, re), [() => (function(re) {
            return hn({ "kaching-choose-product-overlay-color": Re(re.chooseProductModal.overlayColor) });
          })(c())]), v(L, ae);
        }, $$slots: { default: !0 } });
      };
      j(z, (Y) => {
        e(I) && Y(H);
      }), w(W), be((Y) => ue = Ot(W, 1, "kaching-bundles__collection-product", null, ue, Y), [() => ({ "kaching-bundles__collection-product--require-selection": e(U) && e(R) && e(C) })]), v(q, W);
    };
    j(Z, (q) => {
      e(x) && e(M) ? q($) : q(S, !1);
    }), v(n, N);
    var T = Ye(J);
    return l(), T;
  }
  function hv(n, t, r, a) {
    t()({ dealBarId: r().id, dealBarQuantity: a(r()), preselected: !1 });
  }
  Pn(["click"]), We(Ts, { dealBlock: {}, dealBar: {}, mainProduct: {}, products: {}, selectedProductVariant: {}, onChange: {}, onRemove: {} }, [], [], !0);
  var pv = D('<img class="kaching-bundles__bar-image" alt=""/>'), fv = D('<div class="kaching-bundles__bar-radio"></div>'), bv = D('<span class="kaching-bundles__bar-title"><!></span>'), vv = D('<span class="kaching-bundles__bar-label"><!></span>'), _v = D('<div class="kaching-bundles__bar-subtitle"><!></div>'), kv = D('<div class="kaching-bundles__bar-full-price"><!></div>'), mv = D('<div class="kaching-bundles__bar-price"><!></div>'), yv = D('<div class="kaching-bundles__bar-full-price"><!></div>'), xv = D('<div class="kaching-bundles__bar-pricing-row kaching-bundles__bar-pricing-row--secondary"><!> <!></div>'), wv = D('<div class="kaching-bundles__bar-pricing-row kaching-bundles__bar-pricing-row--main"><!> <!></div> <!>', 1), Pv = D('<div class="kaching-bundles__bar-full-price"><!></div>'), Sv = D("<!> <!>", 1), Cv = D('<!> <div class="kaching-bundles__bar-content"><div class="kaching-bundles__bar-content-left"><div class="kaching-bundles__bar-first-line"><!> <!></div> <!></div> <div class="kaching-bundles__bar-pricing"><!></div></div>', 1), Bv = D('<div class="kaching-bundles__bar-selling-plan"><!></div>'), Iv = D('<div class="kaching-bundles__bar-collection-products"></div>'), Mv = D('<div><input type="radio"/> <label><!> <div class="kaching-bundles__bar-wrapper"><!> <!> <!> <!> <!> <!></div> <!> <!> <!> <!></label> <!></div>');
  function Vu(n, t) {
    Je(t, !0);
    const r = () => Me($, "$config", s), a = () => Me(qs, "$chosenCollectionBreaksProducts", s), l = () => Me(N, "$formatPrice", s), c = () => Me(J, "$translate", s), u = () => Me(Z, "$getMediaImageUrl", s), [s, i] = wt();
    let o = m(t, "dealBlock", 7), d = m(t, "dealBar", 7), h = m(t, "product", 7), f = m(t, "collectionBreaksProducts", 23, () => []), p = m(t, "otherProducts", 23, () => []), _ = m(t, "selectedDealBarIndex", 7, null), I = m(t, "complementaryProducts", 23, () => []), y = m(t, "customQuantity", 7, void 0), x = m(t, "currentVariantId", 7, void 0), M = m(t, "componentId", 7), A = m(t, "selected", 7, !1), V = m(t, "globalSellingPlan", 7, void 0), C = m(t, "onDealBarSelect", 7), R = m(t, "onDealBarDeselect", 7), U = m(t, "onVariantSelect", 7), F = m(t, "onVariantsChange", 7), se = m(t, "onPersonalisationsChange", 7), X = m(t, "personalisationInitialValues", 23, () => []), K = m(t, "onProgressiveGiftsChange", 7);
    const J = qt(), N = cn(), Z = qn(), $ = on();
    let S = Ae(rt([])), T = Ae(rt([])), q = Ae(rt([]));
    const W = new jf(), ue = g(() => {
      var he, Oe;
      return (Oe = (he = o().collectionBreaks) == null ? void 0 : he.autoFillNotChosenItems) != null && Oe;
    }), Q = g(() => o().priceRounding ? { perItem: o().showPricesPerItem, precision: o().priceRoundingPrecision, v2: r().featureFlags.price_rounding_v2 || !1 } : void 0), b = g(() => {
      var he, Oe;
      return o() && ((Oe = (he = o().defaultVariantsV2) == null ? void 0 : he.find((Ie) => Nt(Ie.productGID) === h().id && Ie.dealBarId === d().id)) == null ? void 0 : Oe.variantGIDs) || [];
    });
    let B = g(() => H(d())), G = Ae(rt(H(d())));
    Hn(() => {
      te(G, e(B), !0);
    });
    const z = g(() => y() || e(G));
    function H(he) {
      return he.dealBarType === "bxgy" ? he.buyQuantity + he.getQuantity : Number(he.quantity);
    }
    He(() => {
      x() && Xt(() => {
        (function(he, Oe) {
          if (Object.keys(a()).length === 0 && he[0]) {
            const Fe = Nt(he[0]), Ue = h().variants.find((ct) => ct.id == Fe);
            if (Ue) return void Pl(0, { product: h(), variant: Ue });
          }
          const Ie = h().variants.find((Fe) => Fe.id == Oe);
          if (Ie) return void Pl(0, { product: h(), variant: Ie });
          Object.keys(a()).length === 0 && h().variants[0] && Pl(0, { product: h(), variant: h().variants[0] });
        })(e(b), x());
      });
    }), He(() => {
      A() || W.clear();
    });
    const Y = g(() => f().length === 0 || f().some((he) => he.id === h().id)), L = g(() => {
      const he = Object.fromEntries(Object.entries(a()).filter(([Ie]) => Number(Ie) < e(z)));
      if (!A() || !e(ue)) return he;
      const Oe = { ...he };
      for (let Ie = 1; Ie < e(z); Ie++) Oe[Ie] || W.has(Ie) || (e(Y) && he[0] ? Oe[Ie] = { product: h(), variant: he[0].variant } : he[1] && (Oe[Ie] = { product: he[1].product, variant: he[1].variant }));
      return Oe;
    }), O = g(() => (function({ selectedProductVariants: he, mainProductIsInCollection: Oe, collectionBreaksProducts: Ie, dealBlock: Fe, quantity: Ue }) {
      var ct;
      const jt = he.map((At) => ({ quantity: 1, variant: At.variant }));
      if (jt.length === 0 || jt.length >= Ue || (ct = Fe.collectionBreaks) != null && ct.showChosenProductsPriceOnly) return jt;
      const Vt = Ue - jt.length;
      if (Oe) {
        const At = Array.from({ length: Vt }, () => jt[0]);
        return [...jt, ...At];
      }
      const vt = Ie.flatMap((At) => At.variants).filter((At) => At.availableForSale);
      if (vt.length === 0) return jt;
      const St = vt.reduce((At, Zt) => Zt.price < At.price ? Zt : At, vt[0]), Rt = Array.from({ length: Vt }, () => ({ quantity: 1, variant: St }));
      return [...jt, ...Rt];
    })({ selectedProductVariants: Object.values(e(L)), mainProductIsInCollection: e(Y), collectionBreaksProducts: f(), dealBlock: o(), quantity: e(z) }));
    let ae = Ae(void 0);
    const ee = g(() => Di(h(), e(O).map((he) => he.variant))), le = g(() => {
      var he, Oe;
      return (d().sellingPlanEnabled || o().subscriptionsEnabled && ((he = o().subscriptions) == null ? void 0 : he.layout) === "link" && ((Oe = o().subscriptions) == null ? void 0 : Oe.subscribeByDefault)) && (!o().subscriptionsEnabled || !!V());
    }), re = g(() => e(le) ? ms(d(), e(ee), e(ae)) : void 0), fe = g(() => ys(e(re), V(), e(ee), h().requiresSellingPlan)), ze = g(() => new Set(h().variants.map((he) => he.id))), ce = g(() => Object.values(e(L)).filter((he) => e(ze).has(he.variant.id))), ie = g(() => (function(he, Oe, Ie) {
      return Ie.map(({ variant: Ue, quantity: ct }) => {
        let jt = Ue.price;
        const Vt = he.useProductCompareAtPrice || (Oe.dealBarType === void 0 || Oe.dealBarType === "quantity-break") && Oe.discountType === "default";
        return Ue.compareAtPrice && Vt && (jt = Math.max(jt, Ue.compareAtPrice)), jt * ct;
      }).reduce((Ue, ct) => Ue + ct, 0);
    })(o(), d(), e(O))), ke = g(() => Math.ceil(e(ie) / e(O).length)), we = g(() => o() && ge(e(O), e(fe))), _e = g(() => pn({ priceFormatter: l(), product: h(), dealBar: d(), totalFullPrice: e(ie), totalDiscountedPrice: e(we), quantity: e(z), legacySavedPercentage: r().featureFlags.legacy_saved_percentage || !1, unitQuantity: er(e(O)), sellingPlan: e(fe) })), ye = g(() => e(_e)(c()(d().title))), Se = g(() => e(_e)(c()(d().subtitle))), Ve = g(() => e(_e)(c()(d().label))), Ee = g(() => e(_e)(c()(d().badgeText))), ne = g(() => u()(d().badgeImageGID));
    function ge(he, Oe) {
      switch (d().dealBarType) {
        case void 0:
        case "quantity-break":
          return Kc(d(), he, r().currencyRate, e(Q), Oe, r().featureFlags.percentage_cents_rounding_workaround);
        case "bxgy":
          return Xc(d(), he, r().currencyRate, e(Q), Oe);
      }
    }
    const Te = g(() => Math.ceil(e(we) / e(O).length)), pe = g(() => e(ie) > e(we)), de = g(() => `${d().id}_${M()}`);
    ba(() => {
      A() && C()({ dealBarId: d().id, dealBarQuantity: H(d()), preselected: !0 });
    });
    const $e = g(() => u()(d().mediaImageGID) || zi);
    He(() => {
      var he;
      A() && Object.keys(e(L)).length > 0 && (e(q), e(S), e(T), e(fe), (he = o().collectionBreaks) == null || he.requireItemSelectionEnabled, Xt(() => {
        (function() {
          var Oe, Ie;
          const Fe = Object.values(e(L)).map((Zt) => ({ variant: Zt.variant, product: Zt.product, quantity: 1 })), Ue = e(we) + e(q).reduce((Zt, dn) => Zt + dn.discountedPrice, 0), ct = e(ie) + e(q).reduce((Zt, dn) => Zt + dn.fullPrice, 0) + e(S).reduce((Zt, dn) => Zt + dn.fullPrice, 0) + e(T).reduce((Zt, dn) => Zt + dn.fullPrice * dn.quantity, 0), jt = ge(e(O), void 0), Vt = h().sellingPlans.map((Zt) => ({ sellingPlanId: Zt.id, discountedPrice: ge(e(O), Zt) })), vt = (Ie = (Oe = o().collectionBreaks) == null ? void 0 : Oe.requireItemSelectionEnabled) != null && Ie, St = Fe.length, Rt = !vt || St >= e(z), At = vt ? Math.max(0, e(z) - St) : 0;
          F()({ variants: Fe, freeGifts: [...e(S), ...e(T)], upsells: e(q), dealBarSellingPlan: e(re), pricing: { discountedPrice: Ue, fullPrice: ct, discountedPricePerItem: e(Te), fullPricePerItem: e(ke), discountedPriceWithoutSellingPlan: jt, discountedPricesForSellingPlans: Vt }, validation: { requiresItemSelection: vt, allItemsSelected: Rt, missingItemsCount: At } });
        })();
      }));
    });
    const je = g(() => d().showAsSoldOutEnabled && d().showAsSoldOut ? $i(d().showAsSoldOut) : ""), st = g(() => [rv(o()), e(je)].filter(Boolean).join(";"));
    function pt(he, Oe) {
      he === 0 && U()({ variantId: Oe.variant.id }), Pl(he, Oe), Vi(!1), e(ue) && W.delete(he);
    }
    function ot(he) {
      (function(Oe) {
        qs.update((Ie) => {
          const { [Oe]: Fe, ...Ue } = Ie;
          return Ue;
        });
      })(he), e(ue) && W.add(he);
    }
    var Ne = { get dealBlock() {
      return o();
    }, set dealBlock(he) {
      o(he), k();
    }, get dealBar() {
      return d();
    }, set dealBar(he) {
      d(he), k();
    }, get product() {
      return h();
    }, set product(he) {
      h(he), k();
    }, get collectionBreaksProducts() {
      return f();
    }, set collectionBreaksProducts(he = []) {
      f(he), k();
    }, get otherProducts() {
      return p();
    }, set otherProducts(he = []) {
      p(he), k();
    }, get selectedDealBarIndex() {
      return _();
    }, set selectedDealBarIndex(he = null) {
      _(he), k();
    }, get complementaryProducts() {
      return I();
    }, set complementaryProducts(he = []) {
      I(he), k();
    }, get customQuantity() {
      return y();
    }, set customQuantity(he = void 0) {
      y(he), k();
    }, get currentVariantId() {
      return x();
    }, set currentVariantId(he = void 0) {
      x(he), k();
    }, get componentId() {
      return M();
    }, set componentId(he) {
      M(he), k();
    }, get selected() {
      return A();
    }, set selected(he = !1) {
      A(he), k();
    }, get globalSellingPlan() {
      return V();
    }, set globalSellingPlan(he = void 0) {
      V(he), k();
    }, get onDealBarSelect() {
      return C();
    }, set onDealBarSelect(he) {
      C(he), k();
    }, get onDealBarDeselect() {
      return R();
    }, set onDealBarDeselect(he) {
      R(he), k();
    }, get onVariantSelect() {
      return U();
    }, set onVariantSelect(he) {
      U(he), k();
    }, get onVariantsChange() {
      return F();
    }, set onVariantsChange(he) {
      F(he), k();
    }, get onPersonalisationsChange() {
      return se();
    }, set onPersonalisationsChange(he) {
      se(he), k();
    }, get personalisationInitialValues() {
      return X();
    }, set personalisationInitialValues(he = []) {
      X(he), k();
    }, get onProgressiveGiftsChange() {
      return K();
    }, set onProgressiveGiftsChange(he) {
      K(he), k();
    } }, it = Mv();
    let Et;
    var Pt = P(it);
    qr(Pt), Pt.__change = [hv, C, d, H];
    var Ft = E(Pt, 2);
    let Dt;
    var Lt = P(Ft);
    {
      let he = g(() => e(Ee) || void 0);
      wa(Lt, { get style() {
        return d().badgeStyle;
      }, get text() {
        return e(he);
      }, get imageUrl() {
        return e(ne);
      }, get blockLayout() {
        return o().blockLayout;
      } });
    }
    var Ce = E(Lt, 2), tt = P(Ce);
    Qt(tt, { element: "div", class: "kaching-bundles__bar-main", onclick: function(he) {
      A() && (he.preventDefault(), he.stopPropagation(), R()());
    }, children: (he, Oe) => {
      var Ie = Cv(), Fe = ve(Ie), Ue = (et) => {
        var bt = pv();
        be(() => Pe(bt, "src", e($e))), v(et, bt);
      }, ct = (et) => {
        v(et, fv());
      };
      j(Fe, (et) => {
        d().mediaImageGID ? et(Ue) : et(ct, !1);
      });
      var jt = E(Fe, 2), Vt = P(jt), vt = P(Vt), St = P(vt);
      Ke(St, () => e(ye), (et) => {
        var bt = bv();
        qe(P(bt), () => e(ye)), w(bt), v(et, bt);
      });
      var Rt = E(St, 2), At = (et) => {
        var bt = De();
        Ke(ve(bt), () => e(Ve), (Ut) => {
          var kt = vv();
          qe(P(kt), () => e(Ve)), w(kt), v(Ut, kt);
        }), v(et, bt);
      };
      j(Rt, (et) => {
        e(Ve) && et(At);
      }), w(vt);
      var Zt = E(vt, 2), dn = (et) => {
        var bt = De();
        Ke(ve(bt), () => e(Se), (Ut) => {
          var kt = _v();
          qe(P(kt), () => e(Se)), w(kt), v(Ut, kt);
        }), v(et, bt);
      };
      j(Zt, (et) => {
        e(Se) && et(dn);
      }), w(Vt);
      var Sn = E(Vt, 2), Dn = P(Sn), Ln = (et) => {
        var bt = wv(), Ut = ve(bt), kt = P(Ut);
        Ke(kt, () => e(Te), (Be) => {
          yr(Be, { get amount() {
            return e(Te);
          }, get showPricesPerItem() {
            return o().showPricesPerItem;
          }, get unitLabel() {
            return o().unitLabel;
          } });
        });
        var _n = E(kt, 2), oe = (Be) => {
          var nt = De();
          Ke(ve(nt), () => e(ke), (yt) => {
            var Ct = kv();
            qe(P(Ct), () => l()(e(ke))), w(Ct), be((Ht) => Pe(Ct, "data-a11y-label", Ht), [() => c()("system.original_price")]), v(yt, Ct);
          }), v(Be, nt);
        };
        j(_n, (Be) => {
          e(pe) && Be(oe);
        }), w(Ut);
        var Ge = E(Ut, 2), Le = (Be) => {
          var nt = xv(), yt = P(nt);
          Ke(yt, () => e(we), (lt) => {
            var ht = mv();
            qe(P(ht), () => l()(e(we))), w(ht), be((Yt) => Pe(ht, "data-a11y-label", Yt), [() => c()("system.price")]), v(lt, ht);
          });
          var Ct = E(yt, 2), Ht = (lt) => {
            var ht = De();
            Ke(ve(ht), () => e(ie), (Yt) => {
              var gn = yv();
              qe(P(gn), () => l()(e(ie))), w(gn), be((Tn) => Pe(gn, "data-a11y-label", Tn), [() => c()("system.original_price")]), v(Yt, gn);
            }), v(lt, ht);
          };
          j(Ct, (lt) => {
            e(pe) && lt(Ht);
          }), w(nt), v(Be, nt);
        };
        j(Ge, (Be) => {
          e(z) > 1 && Be(Le);
        }), v(et, bt);
      }, vn = (et) => {
        var bt = Sv(), Ut = ve(bt);
        Ke(Ut, () => e(we), (oe) => {
          {
            let Ge = g(() => o().showPricesPerItem ? e(Te) : e(we));
            yr(oe, { get amount() {
              return e(Ge);
            }, get showPricesPerItem() {
              return o().showPricesPerItem;
            }, get unitLabel() {
              return o().unitLabel;
            } });
          }
        });
        var kt = E(Ut, 2), _n = (oe) => {
          var Ge = De();
          Ke(ve(Ge), () => e(ie), (Le) => {
            var Be = Pv();
            qe(P(Be), () => l()(o().showPricesPerItem ? e(ke) : e(ie))), w(Be), be((nt) => Pe(Be, "data-a11y-label", nt), [() => c()("system.original_price")]), v(Le, Be);
          }), v(oe, Ge);
        };
        j(kt, (oe) => {
          e(pe) && oe(_n);
        }), v(et, bt);
      };
      j(Dn, (et) => {
        o().showBothPrices ? et(Ln) : et(vn, !1);
      }), w(Sn), w(jt), v(he, Ie);
    }, $$slots: { default: !0 } });
    var ft = E(tt, 2), gt = (he) => {
      ea(he, { get highlights() {
        return d().highlights;
      }, get isSelected() {
        return A();
      }, get replaceLiquid() {
        return e(_e);
      } });
    };
    j(ft, (he) => {
      d().highlights && he(gt);
    });
    var Qe = E(ft, 2), at = (he) => {
      var Oe = Bv(), Ie = P(Oe);
      {
        let Fe = g(() => e(re) || e(ee)[0]);
        Xr(Ie, { get sellingPlans() {
          return e(ee);
        }, get selectedSellingPlan() {
          return e(Fe);
        }, onChange: (Ue) => {
          te(ae, Ue, !0);
        } });
      }
      w(Oe), v(he, Oe);
    };
    j(Qe, (he) => {
      A() && e(le) && !d().sellingPlanGid && e(ee).length > 1 && he(at);
    });
    var Ze = E(Qe, 2), zt = (he) => {
      var Oe = Iv();
      Jt(Oe, 21, () => ({ length: e(z) }), Zr, (Ie, Fe, Ue) => {
        var ct = De(), jt = ve(ct), Vt = (St) => {
          {
            let Rt = g(() => e(L)[Ue] || null);
            Ts(St, { get dealBlock() {
              return o();
            }, get dealBar() {
              return d();
            }, get mainProduct() {
              return h();
            }, products: [], get selectedProductVariant() {
              return e(Rt);
            }, onChange: (At) => pt(Ue, At) });
          }
        }, vt = (St) => {
          {
            let Rt = g(() => e(L)[Ue] || null);
            Ts(St, { get dealBlock() {
              return o();
            }, get dealBar() {
              return d();
            }, get products() {
              return f();
            }, get selectedProductVariant() {
              return e(Rt);
            }, onChange: (At) => pt(Ue, At), onRemove: () => ot(Ue) });
          }
        };
        j(jt, (St) => {
          Ue === 0 ? St(Vt) : St(vt, !1);
        }), v(Ie, ct);
      }), w(Oe), v(he, Oe);
    };
    j(Ze, (he) => {
      A() && he(zt);
    });
    var en = E(Ze, 2), tn = (he) => {
      {
        let Oe = g(() => H(d()));
        qi(he, { get value() {
          return e(G);
        }, get min() {
          return e(Oe);
        }, onChange: (Ie) => te(G, Ie, !0) });
      }
    };
    j(en, (he) => {
      A() && d().dealBarType === "quantity-break" && d().quantitySelector && he(tn);
    });
    var _t = E(en, 2), Bt = (he) => {
      {
        let Oe = g(() => e(ce).map((Ie) => Ie.variant.id));
        Pa(he, { get product() {
          return h();
        }, get productPersonalisation() {
          return d().productPersonalisation;
        }, get selectedVariantIds() {
          return e(Oe);
        }, get quantity() {
          return e(ce).length;
        }, get addPersonalisationModal() {
          return o().addPersonalisationModal;
        }, get onPersonalisationsChange() {
          return se();
        }, get initialValues() {
          return X();
        } });
      }
    };
    j(_t, (he) => {
      A() && d().productPersonalisation && (o().blockLayout === "vertical" || o().blockLayout === "plain") && he(Bt);
    }), w(Ce);
    var an = E(Ce, 2);
    {
      let he = g(() => d().upsells || []);
      Ha(an, { get dealBlock() {
        return o();
      }, get upsells() {
        return e(he);
      }, get otherProducts() {
        return p();
      }, get complementaryProducts() {
        return I();
      }, get dealBarSelected() {
        return A();
      }, get dealSellingPlan() {
        return e(fe);
      }, onChange: (Oe) => {
        te(q, Oe, !0);
      } });
    }
    var un = E(an, 2);
    Ya(un, { get selectedDealBarIndex() {
      return _();
    }, get onChange() {
      return K();
    }, get dealBlock() {
      return o();
    }, get dealBar() {
      return d();
    }, get otherProducts() {
      return p();
    }, get selected() {
      return A();
    }, get progressiveGifts() {
      return o().progressiveGifts;
    } });
    var yn = E(un, 2);
    {
      let he = g(() => d().freeGifts || []);
      Ua(yn, { get dealBlock() {
        return o();
      }, get freeGifts() {
        return e(he);
      }, get otherProducts() {
        return p();
      }, get dealBarSelected() {
        return A();
      }, get sellingPlan() {
        return e(fe);
      }, onChange: (Oe) => {
        te(S, Oe, !0);
      } });
    }
    var ln = E(yn, 2);
    {
      let he = g(() => d().multipleGiftsSelectors || []);
      Ja(ln, { get dealBlock() {
        return o();
      }, get multipleGiftsSelectors() {
        return e(he);
      }, get sellingPlan() {
        return e(fe);
      }, get otherProducts() {
        return p();
      }, onChange: (Oe) => {
        te(T, Oe, !0);
      } });
    }
    w(Ft);
    var xe = E(Ft, 2), Xe = (he) => {
      Za(he, { get showAsSoldOut() {
        return d().showAsSoldOut;
      }, get replaceLiquid() {
        return e(_e);
      } });
    };
    j(xe, (he) => {
      d().showAsSoldOutEnabled && d().showAsSoldOut && he(Xe);
    }), w(it), be((he, Oe) => {
      var Ie;
      Et = Ot(it, 1, "kaching-bundles__bar", null, Et, he), Pe(it, "data-deal-bar-id", d().id), Wt(it, e(st)), Pe(Pt, "name", `kaching-bundles-deal-${(Ie = M()) != null ? Ie : ""}`), va(Pt, d().id), Pe(Pt, "id", e(de)), Pi(Pt, A()), Pt.disabled = d().showAsSoldOutEnabled, Pe(Ft, "for", e(de)), Dt = Ot(Ft, 1, "kaching-bundles__bar-container", null, Dt, Oe);
    }, [() => ({ "kaching-bundles__bar--selected": A() }), () => ({ "kaching-bundles__bar-container--sold-out": d().showAsSoldOutEnabled })]), v(n, it);
    var ut = Ye(Ne);
    return i(), ut;
  }
  Pn(["change"]), We(Vu, { dealBlock: {}, dealBar: {}, product: {}, collectionBreaksProducts: {}, otherProducts: {}, selectedDealBarIndex: {}, complementaryProducts: {}, customQuantity: {}, currentVariantId: {}, componentId: {}, selected: {}, globalSellingPlan: {}, onDealBarSelect: {}, onDealBarDeselect: {}, onVariantSelect: {}, onVariantsChange: {}, onPersonalisationsChange: {}, personalisationInitialValues: {}, onProgressiveGiftsChange: {} }, [], [], !0);
  var Gs = {};
  (function n(t, r, a, l) {
    var c = !!(t.Worker && t.Blob && t.Promise && t.OffscreenCanvas && t.OffscreenCanvasRenderingContext2D && t.HTMLCanvasElement && t.HTMLCanvasElement.prototype.transferControlToOffscreen && t.URL && t.URL.createObjectURL), u = typeof Path2D == "function" && typeof DOMMatrix == "function";
    function s() {
    }
    function i($) {
      var S = r.exports.Promise, T = S !== void 0 ? S : t.Promise;
      return typeof T == "function" ? new T($) : ($(s, s), null);
    }
    var o, d, h, f, p, _, I = /* @__PURE__ */ (function($, S) {
      return { transform: function(T) {
        if ($) return T;
        if (S.has(T)) return S.get(T);
        var q = new OffscreenCanvas(T.width, T.height);
        return q.getContext("2d").drawImage(T, 0, 0), S.set(T, q), q;
      }, clear: function() {
        S.clear();
      } };
    })((function() {
      if (!t.OffscreenCanvas) return !1;
      try {
        var $ = new OffscreenCanvas(1, 1), S = $.getContext("2d");
        S.fillRect(0, 0, 1, 1);
        var T = $.transferToImageBitmap();
        S.createPattern(T, "no-repeat");
      } catch {
        return !1;
      }
      return !0;
    })(), /* @__PURE__ */ new Map()), y = (h = Math.floor(1e3 / 60), f = {}, p = 0, typeof requestAnimationFrame == "function" && typeof cancelAnimationFrame == "function" ? (o = function($) {
      var S = Math.random();
      return f[S] = requestAnimationFrame(function T(q) {
        p === q || p + h - 1 < q ? (p = q, delete f[S], $()) : f[S] = requestAnimationFrame(T);
      }), S;
    }, d = function($) {
      f[$] && cancelAnimationFrame(f[$]);
    }) : (o = function($) {
      return setTimeout($, h);
    }, d = function($) {
      return clearTimeout($);
    }), { frame: o, cancel: d }), x = /* @__PURE__ */ (function() {
      var $, S, T = {};
      return function() {
        if ($) return $;
        if (!a && c) {
          var q = ["var CONFETTI, SIZE = {}, module = {};", "(" + n.toString() + ")(this, module, true, SIZE);", "onmessage = function(msg) {", "  if (msg.data.options) {", "    CONFETTI(msg.data.options).then(function () {", "      if (msg.data.callback) {", "        postMessage({ callback: msg.data.callback });", "      }", "    });", "  } else if (msg.data.reset) {", "    CONFETTI && CONFETTI.reset();", "  } else if (msg.data.resize) {", "    SIZE.width = msg.data.resize.width;", "    SIZE.height = msg.data.resize.height;", "  } else if (msg.data.canvas) {", "    SIZE.width = msg.data.canvas.width;", "    SIZE.height = msg.data.canvas.height;", "    CONFETTI = module.exports.create(msg.data.canvas);", "  }", "}"].join(`
`);
          try {
            $ = new Worker(URL.createObjectURL(new Blob([q])));
          } catch (W) {
            return typeof console != "undefined" && typeof console.warn == "function" && console.warn("🎊 Could not load worker", W), null;
          }
          (function(W) {
            function ue(Q, b) {
              W.postMessage({ options: Q || {}, callback: b });
            }
            W.init = function(Q) {
              var b = Q.transferControlToOffscreen();
              W.postMessage({ canvas: b }, [b]);
            }, W.fire = function(Q, b, B) {
              if (S) return ue(Q, null), S;
              var G = Math.random().toString(36).slice(2);
              return S = i(function(z) {
                function H(Y) {
                  Y.data.callback === G && (delete T[G], W.removeEventListener("message", H), S = null, I.clear(), B(), z());
                }
                W.addEventListener("message", H), ue(Q, G), T[G] = H.bind(null, { data: { callback: G } });
              });
            }, W.reset = function() {
              for (var Q in W.postMessage({ reset: !0 }), T) T[Q](), delete T[Q];
            };
          })($);
        }
        return $;
      };
    })(), M = { particleCount: 50, angle: 90, spread: 45, startVelocity: 45, decay: 0.9, gravity: 1, drift: 0, ticks: 200, x: 0.5, y: 0.5, shapes: ["square", "circle"], zIndex: 100, colors: ["#26ccff", "#a25afd", "#ff5e7e", "#88ff5a", "#fcff42", "#ffa62d", "#ff36ff"], disableForReducedMotion: !1, scalar: 1 };
    function A($, S, T) {
      return (function(q, W) {
        return W ? W(q) : q;
      })($ && $[S] != null ? $[S] : M[S], T);
    }
    function V($) {
      return $ < 0 ? 0 : Math.floor($);
    }
    function C($, S) {
      return Math.floor(Math.random() * (S - $)) + $;
    }
    function R($) {
      return parseInt($, 16);
    }
    function U($) {
      return $.map(F);
    }
    function F($) {
      var S = String($).replace(/[^0-9a-f]/gi, "");
      return S.length < 6 && (S = S[0] + S[0] + S[1] + S[1] + S[2] + S[2]), { r: R(S.substring(0, 2)), g: R(S.substring(2, 4)), b: R(S.substring(4, 6)) };
    }
    function se($) {
      $.width = document.documentElement.clientWidth, $.height = document.documentElement.clientHeight;
    }
    function X($) {
      var S = $.getBoundingClientRect();
      $.width = S.width, $.height = S.height;
    }
    function K($) {
      var S = $.angle * (Math.PI / 180), T = $.spread * (Math.PI / 180);
      return { x: $.x, y: $.y, wobble: 10 * Math.random(), wobbleSpeed: Math.min(0.11, 0.1 * Math.random() + 0.05), velocity: 0.5 * $.startVelocity + Math.random() * $.startVelocity, angle2D: -S + (0.5 * T - Math.random() * T), tiltAngle: (0.5 * Math.random() + 0.25) * Math.PI, color: $.color, shape: $.shape, tick: 0, totalTicks: $.ticks, decay: $.decay, drift: $.drift, random: Math.random() + 2, tiltSin: 0, tiltCos: 0, wobbleX: 0, wobbleY: 0, gravity: 3 * $.gravity, ovalScalar: 0.6, scalar: $.scalar, flat: $.flat };
    }
    function J($, S) {
      S.x += Math.cos(S.angle2D) * S.velocity + S.drift, S.y += Math.sin(S.angle2D) * S.velocity + S.gravity, S.velocity *= S.decay, S.flat ? (S.wobble = 0, S.wobbleX = S.x + 10 * S.scalar, S.wobbleY = S.y + 10 * S.scalar, S.tiltSin = 0, S.tiltCos = 0, S.random = 1) : (S.wobble += S.wobbleSpeed, S.wobbleX = S.x + 10 * S.scalar * Math.cos(S.wobble), S.wobbleY = S.y + 10 * S.scalar * Math.sin(S.wobble), S.tiltAngle += 0.1, S.tiltSin = Math.sin(S.tiltAngle), S.tiltCos = Math.cos(S.tiltAngle), S.random = Math.random() + 2);
      var T = S.tick++ / S.totalTicks, q = S.x + S.random * S.tiltCos, W = S.y + S.random * S.tiltSin, ue = S.wobbleX + S.random * S.tiltCos, Q = S.wobbleY + S.random * S.tiltSin;
      if ($.fillStyle = "rgba(" + S.color.r + ", " + S.color.g + ", " + S.color.b + ", " + (1 - T) + ")", $.beginPath(), u && S.shape.type === "path" && typeof S.shape.path == "string" && Array.isArray(S.shape.matrix)) $.fill((function(ce, ie, ke, we, _e, ye, Se) {
        var Ve = new Path2D(ce), Ee = new Path2D();
        Ee.addPath(Ve, new DOMMatrix(ie));
        var ne = new Path2D();
        return ne.addPath(Ee, new DOMMatrix([Math.cos(Se) * _e, Math.sin(Se) * _e, -Math.sin(Se) * ye, Math.cos(Se) * ye, ke, we])), ne;
      })(S.shape.path, S.shape.matrix, S.x, S.y, 0.1 * Math.abs(ue - q), 0.1 * Math.abs(Q - W), Math.PI / 10 * S.wobble));
      else if (S.shape.type === "bitmap") {
        var b = Math.PI / 10 * S.wobble, B = 0.1 * Math.abs(ue - q), G = 0.1 * Math.abs(Q - W), z = S.shape.bitmap.width * S.scalar, H = S.shape.bitmap.height * S.scalar, Y = new DOMMatrix([Math.cos(b) * B, Math.sin(b) * B, -Math.sin(b) * G, Math.cos(b) * G, S.x, S.y]);
        Y.multiplySelf(new DOMMatrix(S.shape.matrix));
        var L = $.createPattern(I.transform(S.shape.bitmap), "no-repeat");
        L.setTransform(Y), $.globalAlpha = 1 - T, $.fillStyle = L, $.fillRect(S.x - z / 2, S.y - H / 2, z, H), $.globalAlpha = 1;
      } else if (S.shape === "circle") $.ellipse ? $.ellipse(S.x, S.y, Math.abs(ue - q) * S.ovalScalar, Math.abs(Q - W) * S.ovalScalar, Math.PI / 10 * S.wobble, 0, 2 * Math.PI) : (function(ce, ie, ke, we, _e, ye, Se, Ve, Ee) {
        ce.save(), ce.translate(ie, ke), ce.rotate(ye), ce.scale(we, _e), ce.arc(0, 0, 1, Se, Ve, Ee), ce.restore();
      })($, S.x, S.y, Math.abs(ue - q) * S.ovalScalar, Math.abs(Q - W) * S.ovalScalar, Math.PI / 10 * S.wobble, 0, 2 * Math.PI);
      else if (S.shape === "star") for (var O = Math.PI / 2 * 3, ae = 4 * S.scalar, ee = 8 * S.scalar, le = S.x, re = S.y, fe = 5, ze = Math.PI / fe; fe--; ) le = S.x + Math.cos(O) * ee, re = S.y + Math.sin(O) * ee, $.lineTo(le, re), O += ze, le = S.x + Math.cos(O) * ae, re = S.y + Math.sin(O) * ae, $.lineTo(le, re), O += ze;
      else $.moveTo(Math.floor(S.x), Math.floor(S.y)), $.lineTo(Math.floor(S.wobbleX), Math.floor(W)), $.lineTo(Math.floor(ue), Math.floor(Q)), $.lineTo(Math.floor(q), Math.floor(S.wobbleY));
      return $.closePath(), $.fill(), S.tick < S.totalTicks;
    }
    function N($, S) {
      var T, q = !$, W = !!A(S || {}, "resize"), ue = !1, Q = A(S, "disableForReducedMotion", Boolean), b = c && A(S || {}, "useWorker") ? x() : null, B = q ? se : X, G = !(!$ || !b) && !!$.__confetti_initialized, z = typeof matchMedia == "function" && matchMedia("(prefers-reduced-motion)").matches;
      function H(L, O, ae) {
        for (var ee = A(L, "particleCount", V), le = A(L, "angle", Number), re = A(L, "spread", Number), fe = A(L, "startVelocity", Number), ze = A(L, "decay", Number), ce = A(L, "gravity", Number), ie = A(L, "drift", Number), ke = A(L, "colors", U), we = A(L, "ticks", Number), _e = A(L, "shapes"), ye = A(L, "scalar"), Se = !!A(L, "flat"), Ve = (function(pe) {
          var de = A(pe, "origin", Object);
          return de.x = A(de, "x", Number), de.y = A(de, "y", Number), de;
        })(L), Ee = ee, ne = [], ge = $.width * Ve.x, Te = $.height * Ve.y; Ee--; ) ne.push(K({ x: ge, y: Te, angle: le, spread: re, startVelocity: fe, color: ke[Ee % ke.length], shape: _e[C(0, _e.length)], ticks: we, decay: ze, gravity: ce, drift: ie, scalar: ye, flat: Se }));
        return T ? T.addFettis(ne) : (T = (function(pe, de, $e, je, st) {
          var pt, ot, Ne = de.slice(), it = pe.getContext("2d"), Et = i(function(Pt) {
            function Ft() {
              pt = ot = null, it.clearRect(0, 0, je.width, je.height), I.clear(), st(), Pt();
            }
            pt = y.frame(function Dt() {
              !a || je.width === l.width && je.height === l.height || (je.width = pe.width = l.width, je.height = pe.height = l.height), je.width || je.height || ($e(pe), je.width = pe.width, je.height = pe.height), it.clearRect(0, 0, je.width, je.height), (Ne = Ne.filter(function(Lt) {
                return J(it, Lt);
              })).length ? pt = y.frame(Dt) : Ft();
            }), ot = Ft;
          });
          return { addFettis: function(Pt) {
            return Ne = Ne.concat(Pt), Et;
          }, canvas: pe, promise: Et, reset: function() {
            pt && y.cancel(pt), ot && ot();
          } };
        })($, ne, B, O, ae), T.promise);
      }
      function Y(L) {
        var O = Q || A(L, "disableForReducedMotion", Boolean), ae = A(L, "zIndex", Number);
        if (O && z) return i(function(fe) {
          fe();
        });
        q && T ? $ = T.canvas : q && !$ && ($ = (function(fe) {
          var ze = document.createElement("canvas");
          return ze.style.position = "fixed", ze.style.top = "0px", ze.style.left = "0px", ze.style.pointerEvents = "none", ze.style.zIndex = fe, ze;
        })(ae), document.body.appendChild($)), W && !G && B($);
        var ee = { width: $.width, height: $.height };
        function le() {
          if (b) {
            var fe = { getBoundingClientRect: function() {
              if (!q) return $.getBoundingClientRect();
            } };
            return B(fe), void b.postMessage({ resize: { width: fe.width, height: fe.height } });
          }
          ee.width = ee.height = null;
        }
        function re() {
          T = null, W && (ue = !1, t.removeEventListener("resize", le)), q && $ && (document.body.contains($) && document.body.removeChild($), $ = null, G = !1);
        }
        return b && !G && b.init($), G = !0, b && ($.__confetti_initialized = !0), W && !ue && (ue = !0, t.addEventListener("resize", le, !1)), b ? b.fire(L, ee, re) : H(L, ee, re);
      }
      return Y.reset = function() {
        b && b.reset(), T && T.reset();
      }, Y;
    }
    function Z() {
      return _ || (_ = N(null, { useWorker: !0, resize: !0 })), _;
    }
    r.exports = function() {
      return Z().apply(this, arguments);
    }, r.exports.reset = function() {
      Z().reset();
    }, r.exports.create = N, r.exports.shapeFromPath = function($) {
      if (!u) throw new Error("path confetti are not supported in this browser");
      var S, T;
      typeof $ == "string" ? S = $ : (S = $.path, T = $.matrix);
      var q = new Path2D(S), W = document.createElement("canvas").getContext("2d");
      if (!T) {
        for (var ue, Q, b = 1e3, B = b, G = b, z = 0, H = 0, Y = 0; Y < b; Y += 2) for (var L = 0; L < b; L += 2) W.isPointInPath(q, Y, L, "nonzero") && (B = Math.min(B, Y), G = Math.min(G, L), z = Math.max(z, Y), H = Math.max(H, L));
        ue = z - B, Q = H - G;
        var O = Math.min(10 / ue, 10 / Q);
        T = [O, 0, 0, O, -Math.round(ue / 2 + B) * O, -Math.round(Q / 2 + G) * O];
      }
      return { type: "path", path: S, matrix: T };
    }, r.exports.shapeFromText = function($) {
      var S, T = 1, q = "#000000", W = '"Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji", "EmojiOne Color", "Android Emoji", "Twemoji Mozilla", "system emoji", sans-serif';
      typeof $ == "string" ? S = $ : (S = $.text, T = "scalar" in $ ? $.scalar : T, W = "fontFamily" in $ ? $.fontFamily : W, q = "color" in $ ? $.color : q);
      var ue = 10 * T, Q = ue + "px " + W, b = new OffscreenCanvas(ue, ue), B = b.getContext("2d");
      B.font = Q;
      var G = B.measureText(S), z = Math.ceil(G.actualBoundingBoxRight + G.actualBoundingBoxLeft), H = Math.ceil(G.actualBoundingBoxAscent + G.actualBoundingBoxDescent), Y = G.actualBoundingBoxLeft + 2, L = G.actualBoundingBoxAscent + 2;
      z += 4, H += 4, (B = (b = new OffscreenCanvas(z, H)).getContext("2d")).font = Q, B.fillStyle = q, B.fillText(S, Y, L);
      var O = 1 / T;
      return { type: "bitmap", bitmap: b.transferToImageBitmap(), matrix: [O, 0, 0, O, -z * O / 2, -H * O / 2] };
    };
  })(/* @__PURE__ */ (function() {
    return typeof window != "undefined" ? window : typeof self != "undefined" ? self : this || {};
  })(), Gs, !1);
  const Dv = Gs.exports;
  Gs.exports.create;
  var zv = $n('<svg viewBox="0 0 361 163" fill="none" aria-hidden="true"><path class="kaching-bundles__scratch-off-hint-path" d="M22 113.859C23.9107 84.035 22.7293 20.8901 54.8299 45.9835C94.9555 77.3502 81.1193 164.847 101.209 103.575C108.48 64.2518 127.202 -4.91471 143.923 33.0046C164.824 80.4037 155.535 144.223 184.564 113.859C213.593 83.495 160.179 15.685 201.982 45.9835C243.784 76.2821 263.524 183.445 278.619 122.651C293.714 61.8562 268.168 7.24414 303.004 33.0046C337.839 58.765 330.872 64.2534 339 92.7687" stroke="white" stroke-opacity="0.7" stroke-width="44" stroke-linecap="round"></path></svg>');
  function Tu(n, t) {
    Je(t, !0);
    let r = m(t, "hidden", 7);
    var a = { get hidden() {
      return r();
    }, set hidden(u) {
      r(u), k();
    } }, l = zv();
    let c;
    return be((u) => c = Ot(l, 0, "kaching-bundles__scratch-off-hint", null, c, u), [() => ({ "kaching-bundles__scratch-off-hint--hidden": r() })]), v(n, l), Ye(a);
  }
  function Av(n, t) {
    n.key !== "Enter" && n.key !== " " || (n.preventDefault(), t());
  }
  We(Tu, { hidden: {} }, [], [], !0);
  var $v = D('<canvas role="button" tabindex="0"></canvas> <!> <div aria-hidden="true"> </div>', 1), qv = D("<div><!> <!></div>");
  function Gu(n, t) {
    Je(t, !0);
    const r = () => Me(o, "$config", a), [a, l] = wt(), c = 317 / 361;
    let u = m(t, "settings", 7), s = m(t, "onReveal", 7), i = m(t, "children", 7);
    const o = on(), d = qt();
    let h = g(() => Me(d, "$translate", a)(u().title)), f = Ae(rt(r().preview && !r().previewScratchOff)), p = Ae(!1), _ = Ae(void 0), I = Ae(!1), y = g(() => hn({ "scratch-off-title-color": Re(u().titleColor), "scratch-off-title-size": `${u().titleSize}px` })), x = !1, M = null, A = null, V = 22, C = null, R = Ae(!1), U = Ae(!1);
    const F = new Image();
    F.src = "https://bundles-assets.kachingappz.app/widget/scratch-off-background-v2.webp", C = F, F.complete ? te(R, !0) : (F.addEventListener("load", () => {
      te(R, !0);
    }, { once: !0 }), F.addEventListener("error", () => {
      te(U, !0);
    }, { once: !0 }));
    let se = g(() => e(R) || e(U));
    function X() {
      if (!e(_)) return;
      const z = e(_).getBoundingClientRect();
      if (z.width === 0 || z.height === 0) return;
      const H = window.devicePixelRatio || 1;
      e(_).width = Math.floor(z.width * H), e(_).height = Math.floor(z.height * H);
      const Y = e(_).getContext("2d");
      if (!Y) return;
      Y.scale(H, H), V = 44 * Math.min((z.width - 10) / 361, (z.height - 10) / 163, c) / 2, Y.fillStyle = Re(u().backgroundColor), Y.fillRect(0, 0, z.width, z.height), e(R) && C && (Y.globalAlpha = 0.6, Y.drawImage(C, 0, 0, z.width, z.height), Y.globalAlpha = 1), Y.globalCompositeOperation = "destination-out";
    }
    function K(z) {
      if (!e(_)) return null;
      const H = e(_).getBoundingClientRect();
      return { x: z.clientX - H.left, y: z.clientY - H.top };
    }
    function J(z) {
      var H;
      e(f) || e(p) || (x = !0, te(I, !0), A === null && (A = setTimeout(S, 1500)), (H = e(_)) == null || H.setPointerCapture(z.pointerId), M = K(z), (function(Y) {
        if (!e(_) || !Y) return;
        const L = e(_).getContext("2d");
        L && (L.beginPath(), L.arc(Y.x, Y.y, V, 0, 2 * Math.PI), L.fill());
      })(M));
    }
    function N(z) {
      if (!x || e(f) || e(p)) return;
      const H = K(z);
      H && M && ((function(Y, L) {
        if (!e(_)) return;
        const O = e(_).getContext("2d");
        if (!O) return;
        const ae = L.x - Y.x, ee = L.y - Y.y, le = Math.hypot(ae, ee), re = Math.max(1, Math.ceil(le / 4));
        for (let fe = 0; fe <= re; fe++) {
          const ze = fe / re;
          O.beginPath(), O.arc(Y.x + ae * ze, Y.y + ee * ze, V, 0, 2 * Math.PI), O.fill();
        }
      })(M, H), M = H);
    }
    function Z(z) {
      var H;
      x = !1, (H = e(_)) == null || H.releasePointerCapture(z.pointerId), M = null, S();
    }
    function $() {
      A !== null && (clearTimeout(A), A = null);
    }
    function S() {
      var z;
      e(f) || e(p) || ($(), te(p, !0), (function() {
        if (!e(_)) return;
        const H = e(_).getBoundingClientRect();
        Dv({ particleCount: 120, spread: 70, startVelocity: 45, origin: { x: (H.left + H.width / 2) / window.innerWidth, y: (H.top + H.height / 2) / window.innerHeight } });
      })(), (z = s()) == null || z(), setTimeout(() => {
        te(f, !0), te(p, !1);
      }, 300));
    }
    He(() => {
      if (e(se)) return;
      const z = setTimeout(() => {
        te(U, !0);
      }, 5e3);
      return () => clearTimeout(z);
    }), He(() => () => $()), He(() => {
      if (e(f) || e(p) || !e(_)) return;
      X();
      const z = new ResizeObserver(() => {
        e(f) || e(p) || X();
      });
      return z.observe(e(_)), () => z.disconnect();
    });
    let T = JSON.stringify(u());
    He(() => {
      const z = JSON.stringify(u());
      z !== T && (T = z, r().preview && r().previewScratchOff && (te(f, !1), te(p, !1), te(I, !1), $()));
    });
    var q = { get settings() {
      return u();
    }, set settings(z) {
      u(z), k();
    }, get onReveal() {
      return s();
    }, set onReveal(z) {
      s(z), k();
    }, get children() {
      return i();
    }, set children(z) {
      i(z), k();
    } }, W = qv();
    let ue;
    var Q = P(W);
    ns(Q, i);
    var b = E(Q, 2), B = (z) => {
      var H = $v(), Y = ve(H);
      let L;
      Y.__pointerdown = J, Y.__pointermove = N, Y.__pointerup = Z, Y.__keydown = [Av, S], ol(Y, (re) => te(_, re), () => e(_));
      var O = E(Y, 2);
      {
        let re = g(() => e(I) || e(p));
        Tu(O, { get hidden() {
          return e(re);
        } });
      }
      var ae = E(O, 2);
      let ee;
      var le = P(ae, !0);
      w(ae), be((re, fe) => {
        L = Ot(Y, 1, "kaching-bundles__scratch-off-canvas", null, L, re), Pe(Y, "aria-label", e(h)), ee = Ot(ae, 1, "kaching-bundles__scratch-off-title", null, ee, fe), mt(le, e(h));
      }, [() => ({ "kaching-bundles__scratch-off-canvas--revealing": e(p) }), () => ({ "kaching-bundles__scratch-off-title--hidden": e(I) || e(p) })]), Jo("pointercancel", Y, Z), v(z, H);
    };
    j(b, (z) => {
      e(f) || z(B);
    }), w(W), be((z) => {
      ue = Ot(W, 1, "kaching-bundles__scratch-off", null, ue, z), Wt(W, e(y));
    }, [() => ({ "kaching-bundles__scratch-off--unscratched": !e(f), "kaching-bundles__scratch-off--revealing": e(p), "kaching-bundles__scratch-off--loading": !e(f) && !e(se) })]), v(n, W);
    var G = Ye(q);
    return l(), G;
  }
  Pn(["pointerdown", "pointermove", "pointerup", "keydown"]), We(Gu, { settings: {}, onReveal: {}, children: {} }, [], [], !0);
  var Vv = D('<div class="kaching-bundles__bar-price"><!></div>'), Tv = D('<div class="kaching-bundles__bar-full-price"><!></div>'), Gv = D('<div class="kaching-bundles__bar-pricing"><!> <!></div>');
  function Sl(n, t) {
    Je(t, !0);
    const r = () => Me(i, "$translate", l), a = () => Me(o, "$formatPrice", l), [l, c] = wt(), u = m(t, "discountedPrice", 7), s = m(t, "fullPrice", 7), i = qt(), o = cn();
    var d = { get discountedPrice() {
      return u();
    }, set discountedPrice(y) {
      u(y), k();
    }, get fullPrice() {
      return s();
    }, set fullPrice(y) {
      s(y), k();
    } }, h = Gv(), f = P(h);
    Ke(f, u, (y) => {
      var x = Vv();
      qe(P(x), () => a()(u())), w(x), be((M) => Pe(x, "data-a11y-label", M), [() => r()("system.price")]), v(y, x);
    });
    var p = E(f, 2), _ = (y) => {
      var x = De();
      Ke(ve(x), s, (M) => {
        var A = Tv();
        qe(P(A), () => a()(s())), w(A), be((V) => Pe(A, "data-a11y-label", V), [() => r()("system.original_price")]), v(M, A);
      }), v(y, x);
    };
    j(p, (y) => {
      s() > u() && y(_);
    }), w(h), v(n, h);
    var I = Ye(d);
    return c(), I;
  }
  We(Sl, { discountedPrice: {}, fullPrice: {} }, [], [], !0);
  const Ka = Jr(null), Os = (n) => hn({ "kaching-subscriptions-title-color": Re(n.titleColor), "kaching-subscriptions-subtitle-color": Re(n.subtitleColor), "kaching-subscriptions-title-font-size": n.titleSize + "px", "kaching-subscriptions-subtitle-font-size": n.subtitleSize + "px" });
  var Ov = D('<div class="kaching-bundles__bar-radio"></div>'), Fv = D('<div class="kaching-bundles__subscriptions__title"><!></div>'), Lv = D('<div class="kaching-bundles__subscriptions__subtitle"><!></div>'), Ev = D('<div class="kaching-bundles__bar-variants"><!></div>'), jv = D('<div class="kaching-bundles__subscriptions__card kaching-bundles__bar-container"><div class="kaching-bundles__bar-wrapper"><div class="kaching-bundles__bar-main"><!> <div class="kaching-bundles__bar-content"><div class="kaching-bundles__bar-content-left"><div class="kaching-bundles__bar-first-line"><!></div> <!></div> <!></div></div> <!> <!></div></div>'), Rv = D('<div class="kaching-bundles__bar-radio"></div>'), Qv = D('<div class="kaching-bundles__subscriptions__title"><!></div>'), Nv = D('<div class="kaching-bundles__subscriptions__subtitle"><!></div>'), Wv = D('<div class="kaching-bundles__subscriptions__card kaching-bundles__bar-container"><div class="kaching-bundles__bar-wrapper"><div class="kaching-bundles__bar-main"><!> <div class="kaching-bundles__bar-content"><div class="kaching-bundles__bar-content-left"><div class="kaching-bundles__bar-first-line"><!></div> <!></div> <!></div></div></div></div>'), Uv = D("<div></div>");
  function Ou(n, t) {
    Je(t, !0);
    const r = () => Me(Ka, "$selectedDealBarStore", c), a = () => Me(p, "$formatPrice", c), l = () => Me(f, "$translate", c), [c, u] = wt(), s = m(t, "subscriptions", 7), i = m(t, "sellingPlans", 7), o = m(t, "selectedSellingPlan", 7), d = m(t, "hideSellingPlanSelector", 7, !1), h = m(t, "onChange", 7), f = qt(), p = cn();
    let _ = Ae(rt(s().subscribeByDefault || o() ? "subscribe" : "one-time")), I = Ae(rt(o() || i()[0])), y = Ae(!1), x = g(() => s().subscribeByDefault), M = g(() => e(x) ? ["subscribe", "one-time"] : ["one-time", "subscribe"]);
    const A = g(() => Os(s())), V = g(() => {
      var T, q;
      const W = (q = (T = r()) == null ? void 0 : T.dealBar) == null ? void 0 : q.sellingPlanGid;
      if (W) return i().find((ue) => ue.id === Nt(W));
    }), C = g(() => {
      var T;
      return (T = e(V)) != null ? T : e(I);
    }), R = g(() => {
      var T, q, W, ue, Q;
      return (Q = (ue = (q = (T = r()) == null ? void 0 : T.pricing.discountedPricesForSellingPlans.find((b) => {
        var B;
        return b.sellingPlanId === ((B = e(C)) == null ? void 0 : B.id);
      })) == null ? void 0 : q.discountedPrice) != null ? ue : (W = r()) == null ? void 0 : W.pricing.discountedPrice) != null ? Q : 0;
    }), U = g(() => {
      var T, q;
      return (q = (T = r()) == null ? void 0 : T.pricing.discountedPriceWithoutSellingPlan) != null ? q : 0;
    }), F = g(() => {
      var T, q;
      return (q = (T = r()) == null ? void 0 : T.pricing.fullPrice) != null ? q : 0;
    }), se = g(() => {
      var T, q, W;
      return pn({ priceFormatter: a(), product: (T = r()) == null ? void 0 : T.product, totalFullPrice: e(F), totalDiscountedPrice: e(R), quantity: (W = (q = r()) == null ? void 0 : q.quantity) != null ? W : 1, sellingPlan: e(C), unitQuantity: null });
    }), X = g(() => {
      var T, q, W;
      return pn({ priceFormatter: a(), product: (T = r()) == null ? void 0 : T.product, totalFullPrice: e(F), totalDiscountedPrice: e(U), quantity: (W = (q = r()) == null ? void 0 : q.quantity) != null ? W : 1, unitQuantity: null });
    });
    function K(T) {
      te(y, !0), te(_, T, !0), h()(T === "subscribe" ? e(I) : void 0);
    }
    function J(T) {
      te(I, T, !0), e(_) === "subscribe" && h()(T);
    }
    ba(() => {
      e(_) === "subscribe" && h()(e(I));
    }), He(() => {
      if (o()) return te(I, o(), !0), void te(_, "subscribe");
      if (i().length === 0) return void te(_, "one-time");
      i().some((T) => {
        var q;
        return T.id === ((q = e(I)) == null ? void 0 : q.id);
      }) || te(I, i()[0], !0), e(y) || te(_, e(x) ? "subscribe" : "one-time", !0), h()(e(_) === "subscribe" ? e(I) : void 0);
    });
    var N = { get subscriptions() {
      return s();
    }, set subscriptions(T) {
      s(T), k();
    }, get sellingPlans() {
      return i();
    }, set sellingPlans(T) {
      i(T), k();
    }, get selectedSellingPlan() {
      return o();
    }, set selectedSellingPlan(T) {
      o(T), k();
    }, get hideSellingPlanSelector() {
      return d();
    }, set hideSellingPlanSelector(T = !1) {
      d(T), k();
    }, get onChange() {
      return h();
    }, set onChange(T) {
      h(T), k();
    } }, Z = Uv();
    let $;
    Jt(Z, 20, () => e(M), (T) => T, (T, q) => {
      var W = De(), ue = ve(W), Q = (B) => {
        {
          let G = g(() => ["kaching-bundles__bar", i().length === 0 && "kaching-bundles__bar--disabled", e(_) === "subscribe" && "kaching-bundles__bar--selected"]);
          Qt(B, { element: "div", get class() {
            return e(G);
          }, onclick: () => K("subscribe"), children: (z, H) => {
            var Y = jv(), L = P(Y), O = P(L), ae = P(O), ee = (ne) => {
              v(ne, Ov());
            };
            j(ae, (ne) => {
              s().layout === "vertical" && ne(ee);
            });
            var le = E(ae, 2), re = P(le), fe = P(re), ze = P(fe), ce = (ne) => {
              var ge = Fv();
              qe(P(ge), () => e(se)(l()(s().subscribeTitle))), w(ge), v(ne, ge);
            };
            j(ze, (ne) => {
              s().subscribeTitle && ne(ce);
            }), w(fe);
            var ie = E(fe, 2), ke = (ne) => {
              var ge = Lv();
              qe(P(ge), () => e(se)(l()(s().subscribeSubtitle))), w(ge), v(ne, ge);
            };
            j(ie, (ne) => {
              s().subscribeSubtitle && ne(ke);
            }), w(re);
            var we = E(re, 2), _e = (ne) => {
              Sl(ne, { get discountedPrice() {
                return e(R);
              }, get fullPrice() {
                return e(F);
              } });
            };
            j(we, (ne) => {
              s().showPrices && r() && ne(_e);
            }), w(le), w(O);
            var ye = E(O, 2), Se = (ne) => {
              {
                let ge = g(() => e(_) === "subscribe");
                ea(ne, { get highlights() {
                  return s().highlights;
                }, get isSelected() {
                  return e(ge);
                }, get replaceLiquid() {
                  return e(se);
                } });
              }
            };
            j(ye, (ne) => {
              s().highlights && ne(Se);
            });
            var Ve = E(ye, 2), Ee = (ne) => {
              var ge = Ev();
              Xr(P(ge), { get sellingPlans() {
                return i();
              }, get selectedSellingPlan() {
                return e(I);
              }, onChange: J }), w(ge), v(ne, ge);
            };
            j(Ve, (ne) => {
              e(_) === "subscribe" && i().length > 1 && e(I) && !d() && ne(Ee);
            }), w(L), w(Y), v(z, Y);
          }, $$slots: { default: !0 } });
        }
      }, b = (B) => {
        {
          let G = g(() => ["kaching-bundles__bar", i().length === 0 && "kaching-bundles__bar--disabled", e(_) === "one-time" && "kaching-bundles__bar--selected"]);
          Qt(B, { element: "div", get class() {
            return e(G);
          }, onclick: () => K("one-time"), children: (z, H) => {
            var Y = Wv(), L = P(Y), O = P(L), ae = P(O), ee = (ye) => {
              v(ye, Rv());
            };
            j(ae, (ye) => {
              s().layout === "vertical" && ye(ee);
            });
            var le = E(ae, 2), re = P(le), fe = P(re), ze = P(fe), ce = (ye) => {
              var Se = Qv();
              qe(P(Se), () => e(X)(l()(s().oneTimeTitle))), w(Se), v(ye, Se);
            };
            j(ze, (ye) => {
              s().oneTimeTitle && ye(ce);
            }), w(fe);
            var ie = E(fe, 2), ke = (ye) => {
              var Se = Nv();
              qe(P(Se), () => e(X)(l()(s().oneTimeSubtitle))), w(Se), v(ye, Se);
            };
            j(ie, (ye) => {
              s().oneTimeSubtitle && ye(ke);
            }), w(re);
            var we = E(re, 2), _e = (ye) => {
              Sl(ye, { get discountedPrice() {
                return e(U);
              }, get fullPrice() {
                return e(F);
              } });
            };
            j(we, (ye) => {
              s().showPrices && r() && ye(_e);
            }), w(le), w(O), w(L), w(Y), v(z, Y);
          }, $$slots: { default: !0 } });
        }
      };
      j(ue, (B) => {
        q === "subscribe" ? B(Q) : B(b, !1);
      }), v(T, W);
    }), w(Z), be((T) => {
      $ = Ot(Z, 1, "kaching-bundles__subscriptions kaching-bundles__bars", null, $, T), Wt(Z, e(A));
    }, [() => ({ "kaching-bundles__bars--horizontal": s().layout === "horizontal" })]), v(n, Z);
    var S = Ye(N);
    return u(), S;
  }
  We(Ou, { subscriptions: {}, sellingPlans: {}, selectedSellingPlan: {}, hideSellingPlanSelector: {}, onChange: {} }, [], [], !0);
  var Hv = D('<div class="kaching-bundles__subscriptions__title"><!></div>'), Zv = D('<div class="kaching-bundles__subscriptions__subtitle"><!></div>'), Jv = D('<div class="kaching-bundles__bar-variants"><!></div>'), Yv = D('<div class="kaching-bundles__subscriptions__card kaching-bundles__bar-container"><div class="kaching-bundles__bar-wrapper"><div class="kaching-bundles__bar-main"><span class="kaching-bundles__subscriptions__checkbox"><!></span> <div class="kaching-bundles__bar-content"><div class="kaching-bundles__bar-content-left"><div class="kaching-bundles__bar-first-line"><!></div> <!></div> <!></div></div> <!> <!></div></div>'), Kv = D('<div class="kaching-bundles__subscriptions kaching-bundles__bars kaching-bundles__subscriptions--checkbox"><!></div>');
  function Fu(n, t) {
    Je(t, !0);
    const r = () => Me(Ka, "$selectedDealBarStore", l), a = () => Me(h, "$translate", l), [l, c] = wt(), u = m(t, "subscriptions", 7), s = m(t, "sellingPlans", 7), i = m(t, "selectedSellingPlan", 7), o = m(t, "hideSellingPlanSelector", 7, !1), d = m(t, "onChange", 7), h = qt(), f = cn();
    let p = Ae(rt(u().subscribeByDefault || !!i())), _ = Ae(rt(i() || s()[0])), I = Ae(!1);
    const y = g(() => Os(u())), x = g(() => {
      var K, J;
      const N = (J = (K = r()) == null ? void 0 : K.dealBar) == null ? void 0 : J.sellingPlanGid;
      if (N) return s().find((Z) => Z.id === Nt(N));
    }), M = g(() => {
      var K;
      return (K = e(x)) != null ? K : e(_);
    }), A = g(() => {
      var K, J, N, Z, $;
      return ($ = (Z = (J = (K = r()) == null ? void 0 : K.pricing.discountedPricesForSellingPlans.find((S) => {
        var T;
        return S.sellingPlanId === ((T = e(M)) == null ? void 0 : T.id);
      })) == null ? void 0 : J.discountedPrice) != null ? Z : (N = r()) == null ? void 0 : N.pricing.discountedPrice) != null ? $ : 0;
    }), V = g(() => {
      var K, J;
      return (J = (K = r()) == null ? void 0 : K.pricing.fullPrice) != null ? J : 0;
    }), C = g(() => {
      var K, J, N;
      return pn({ priceFormatter: Me(f, "$formatPrice", l), product: (K = r()) == null ? void 0 : K.product, totalFullPrice: e(V), totalDiscountedPrice: e(A), quantity: (N = (J = r()) == null ? void 0 : J.quantity) != null ? N : 1, sellingPlan: e(M), unitQuantity: null });
    });
    function R(K) {
      te(_, K, !0), d()(K);
    }
    He(() => {
      if (i()) return te(_, i(), !0), void te(p, !0);
      if (s().length === 0) return void te(p, !1);
      e(_) && s().some((K) => K.id === e(_).id) || te(_, s()[0], !0), e(I) || te(p, u().subscribeByDefault, !0), d()(e(p) ? e(_) : void 0);
    }), ba(() => {
      e(p) && d()(e(_));
    });
    var U = { get subscriptions() {
      return u();
    }, set subscriptions(K) {
      u(K), k();
    }, get sellingPlans() {
      return s();
    }, set sellingPlans(K) {
      s(K), k();
    }, get selectedSellingPlan() {
      return i();
    }, set selectedSellingPlan(K) {
      i(K), k();
    }, get hideSellingPlanSelector() {
      return o();
    }, set hideSellingPlanSelector(K = !1) {
      o(K), k();
    }, get onChange() {
      return d();
    }, set onChange(K) {
      d(K), k();
    } }, F = Kv(), se = P(F);
    {
      let K = g(() => ["kaching-bundles__bar", s().length === 0 && "kaching-bundles__bar--disabled"]);
      Qt(se, { element: "div", get class() {
        return e(K);
      }, role: "checkbox", get "aria-checked"() {
        return e(p);
      }, onclick: function() {
        te(I, !0), te(p, !e(p)), d()(e(p) ? e(_) : void 0);
      }, children: (J, N) => {
        var Z = Yv(), $ = P(Z), S = P($), T = P(S), q = P(T), W = (re) => {
          wl(re);
        };
        j(q, (re) => {
          e(p) && re(W);
        }), w(T);
        var ue = E(T, 2), Q = P(ue), b = P(Q), B = P(b), G = (re) => {
          var fe = Hv();
          qe(P(fe), () => e(C)(a()(u().subscribeTitle))), w(fe), v(re, fe);
        };
        j(B, (re) => {
          u().subscribeTitle && re(G);
        }), w(b);
        var z = E(b, 2), H = (re) => {
          var fe = Zv();
          qe(P(fe), () => e(C)(a()(u().subscribeSubtitle))), w(fe), v(re, fe);
        };
        j(z, (re) => {
          u().subscribeSubtitle && re(H);
        }), w(Q);
        var Y = E(Q, 2), L = (re) => {
          Sl(re, { get discountedPrice() {
            return e(A);
          }, get fullPrice() {
            return e(V);
          } });
        };
        j(Y, (re) => {
          u().showPrices && r() && re(L);
        }), w(ue), w(S);
        var O = E(S, 2), ae = (re) => {
          ea(re, { get highlights() {
            return u().highlights;
          }, get isSelected() {
            return e(p);
          }, get replaceLiquid() {
            return e(C);
          } });
        };
        j(O, (re) => {
          u().highlights && re(ae);
        });
        var ee = E(O, 2), le = (re) => {
          var fe = Jv();
          Xr(P(fe), { get sellingPlans() {
            return s();
          }, get selectedSellingPlan() {
            return e(_);
          }, onChange: R }), w(fe), v(re, fe);
        };
        j(ee, (re) => {
          e(p) && s().length > 1 && e(_) && !o() && re(le);
        }), w($), w(Z), v(J, Z);
      }, $$slots: { default: !0 } });
    }
    w(F), be(() => Wt(F, e(y))), v(n, F);
    var X = Ye(U);
    return c(), X;
  }
  function Xv(n, t, r, a) {
    t()(r().subscribeByDefault ? void 0 : e(a));
  }
  We(Fu, { subscriptions: {}, sellingPlans: {}, selectedSellingPlan: {}, hideSellingPlanSelector: {}, onChange: {} }, [], [], !0);
  var e_ = D('<div class="kaching-bundles__subscriptions kaching-bundles__subscriptions--link"><button type="button" class="kaching-bundles__subscriptions__link"><!><!></button></div>');
  function Lu(n, t) {
    Je(t, !0);
    const r = () => Me(Ka, "$selectedDealBarStore", l), a = () => Me(f, "$formatPrice", l), [l, c] = wt(), u = m(t, "subscriptions", 7), s = m(t, "sellingPlans", 7), i = m(t, "selectedSellingPlan", 7), o = m(t, "onChange", 7), d = m(t, "onRequestAddToCart", 7), h = qt(), f = cn(), p = g(() => Os(u())), _ = g(() => {
      var N, Z;
      const $ = (Z = (N = r()) == null ? void 0 : N.dealBar) == null ? void 0 : Z.sellingPlanGid;
      if ($) return s().find((S) => S.id === Nt($));
    }), I = g(() => {
      var N, Z;
      return (Z = (N = e(_)) != null ? N : i()) != null ? Z : s()[0];
    }), y = g(() => {
      var N, Z, $, S, T;
      return (T = (S = (Z = (N = r()) == null ? void 0 : N.pricing.discountedPricesForSellingPlans.find((q) => {
        var W;
        return q.sellingPlanId === ((W = e(I)) == null ? void 0 : W.id);
      })) == null ? void 0 : Z.discountedPrice) != null ? S : ($ = r()) == null ? void 0 : $.pricing.discountedPrice) != null ? T : 0;
    }), x = g(() => {
      var N, Z;
      return (Z = (N = r()) == null ? void 0 : N.pricing.discountedPriceWithoutSellingPlan) != null ? Z : 0;
    }), M = g(() => {
      var N, Z;
      return (Z = (N = r()) == null ? void 0 : N.pricing.fullPrice) != null ? Z : 0;
    }), A = g(() => {
      var N, Z, $;
      return pn({ priceFormatter: a(), product: (N = r()) == null ? void 0 : N.product, totalFullPrice: e(M), totalDiscountedPrice: u().subscribeByDefault ? e(x) : e(y), quantity: ($ = (Z = r()) == null ? void 0 : Z.quantity) != null ? $ : 1, sellingPlan: u().subscribeByDefault ? void 0 : e(I), unitQuantity: null });
    }), V = g(() => u().subscribeByDefault ? e(x) : e(y)), C = g(() => {
      const N = u().subscribeByDefault ? u().oneTimeTitle : u().subscribeTitle;
      return N ? e(A)(Me(h, "$translate", l)(N)) : "";
    });
    let R, U = !1;
    He(() => {
      const N = s().length !== 0 && u().subscribeByDefault ? e(I) : void 0;
      U && (N == null ? void 0 : N.id) === R || (R = N == null ? void 0 : N.id, U = !0, o()(N));
    });
    var F = { get subscriptions() {
      return u();
    }, set subscriptions(N) {
      u(N), k();
    }, get sellingPlans() {
      return s();
    }, set sellingPlans(N) {
      s(N), k();
    }, get selectedSellingPlan() {
      return i();
    }, set selectedSellingPlan(N) {
      i(N), k();
    }, get onChange() {
      return o();
    }, set onChange(N) {
      o(N), k();
    }, get onRequestAddToCart() {
      return d();
    }, set onRequestAddToCart(N) {
      d(N), k();
    } }, se = De(), X = ve(se), K = (N) => {
      var Z = e_(), $ = P(Z);
      $.__click = [Xv, d, u, I];
      var S = P($);
      qe(S, () => e(C));
      var T = E(S), q = (W) => {
        var ue = In();
        be((Q) => mt(ue, Q), [() => " • " + a()(e(V))]), v(W, ue);
      };
      j(T, (W) => {
        u().showPrices && r() && W(q);
      }), w($), w(Z), be(() => Wt(Z, e(p))), v(N, Z);
    };
    j(X, (N) => {
      s().length > 0 && e(C) && N(K);
    }), v(n, se);
    var J = Ye(F);
    return c(), J;
  }
  Pn(["click"]), We(Lu, { subscriptions: {}, sellingPlans: {}, selectedSellingPlan: {}, onChange: {}, onRequestAddToCart: {} }, [], [], !0);
  var t_ = D('<div class="kaching-bundles__block-title"><!></div>'), n_ = D("<!> <!>", 1);
  function Fs(n, t) {
    Je(t, !0);
    const [r, a] = wt(), l = m(t, "subscriptions", 7), c = m(t, "sellingPlans", 7), u = m(t, "selectedSellingPlan", 7), s = m(t, "hideSellingPlanSelector", 7, !1), i = m(t, "onChange", 7), o = m(t, "onRequestAddToCart", 7), d = qt(), h = g(() => l().title ? Me(d, "$translate", r)(l().title) : "");
    var f = { get subscriptions() {
      return l();
    }, set subscriptions(V) {
      l(V), k();
    }, get sellingPlans() {
      return c();
    }, set sellingPlans(V) {
      c(V), k();
    }, get selectedSellingPlan() {
      return u();
    }, set selectedSellingPlan(V) {
      u(V), k();
    }, get hideSellingPlanSelector() {
      return s();
    }, set hideSellingPlanSelector(V = !1) {
      s(V), k();
    }, get onChange() {
      return i();
    }, set onChange(V) {
      i(V), k();
    }, get onRequestAddToCart() {
      return o();
    }, set onRequestAddToCart(V) {
      o(V), k();
    } }, p = n_(), _ = ve(p), I = (V) => {
      var C = t_();
      qe(P(C), () => e(h)), w(C), v(V, C);
    };
    j(_, (V) => {
      e(h) && V(I);
    });
    var y = E(_, 2), x = (V) => {
      Fu(V, { get subscriptions() {
        return l();
      }, get sellingPlans() {
        return c();
      }, get selectedSellingPlan() {
        return u();
      }, get hideSellingPlanSelector() {
        return s();
      }, get onChange() {
        return i();
      } });
    }, M = (V) => {
      var C = De(), R = ve(C), U = (se) => {
        Lu(se, { get subscriptions() {
          return l();
        }, get sellingPlans() {
          return c();
        }, get selectedSellingPlan() {
          return u();
        }, get onChange() {
          return i();
        }, get onRequestAddToCart() {
          return o();
        } });
      }, F = (se) => {
        Ou(se, { get subscriptions() {
          return l();
        }, get sellingPlans() {
          return c();
        }, get selectedSellingPlan() {
          return u();
        }, get hideSellingPlanSelector() {
          return s();
        }, get onChange() {
          return i();
        } });
      };
      j(R, (se) => {
        l().layout === "link" ? se(U) : se(F, !1);
      }, !0), v(V, C);
    };
    j(y, (V) => {
      l().layout === "checkbox" ? V(x) : V(M, !1);
    }), v(n, p);
    var A = Ye(f);
    return a(), A;
  }
  We(Fs, { subscriptions: {}, sellingPlans: {}, selectedSellingPlan: {}, hideSellingPlanSelector: {}, onChange: {}, onRequestAddToCart: {} }, [], [], !0);
  var r_ = $n('<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M44.584 21H42.834V14C42.834 6.279 36.555 0 28.834 0C21.113 0 14.834 6.279 14.834 14V21H13.084C10.1907 21 7.83398 23.3543 7.83398 26.25V50.75C7.83398 53.6457 10.1907 56 13.084 56H44.584C47.4773 56 49.834 53.6457 49.834 50.75V26.25C49.834 23.3543 47.4773 21 44.584 21ZM19.5007 14C19.5007 8.85267 23.6867 4.66667 28.834 4.66667C33.9813 4.66667 38.1673 8.85267 38.1673 14V21H19.5007V14ZM31.1673 39.018V44.3333C31.1673 45.6213 30.1243 46.6667 28.834 46.6667C27.5436 46.6667 26.5007 45.6213 26.5007 44.3333V39.018C25.1123 38.2083 24.1673 36.7197 24.1673 35C24.1673 32.4263 26.2603 30.3333 28.834 30.3333C31.4076 30.3333 33.5007 32.4263 33.5007 35C33.5007 36.7197 32.5557 38.2083 31.1673 39.018Z" fill="currentColor" transform="translate(21.5, 22)"></path></svg>');
  function Eu(n) {
    v(n, r_());
  }
  We(Eu, {}, [], [], !0);
  var a_ = D('<img alt="Locked" class="kaching-bundles__progressive-gifts__gift__image"/>'), i_ = D('<span class="kaching-bundles__progressive-gifts__gift__label__text"><!></span>'), l_ = D('<span class="kaching-bundles__progressive-gifts__gift__label__text kaching-bundles__progressive-gifts__gift__label__text--crossed-out"><!></span>'), s_ = D('<div class="kaching-bundles__progressive-gifts__gift__label"><!> <!></div>'), o_ = D('<div class="kaching-bundles__progressive-gifts__gift__content"><div class="kaching-bundles__progressive-gifts__gift__image-wrapper"><!></div> <div class="kaching-bundles__progressive-gifts__gift__title kaching-bundles__progressive-gifts__gift__title--locked"><!></div> <!></div>'), c_ = D('<div class="kaching-bundles__progressive-gifts__gift__image-wrapper"><img class="kaching-bundles__progressive-gifts__gift__image"/></div>'), u_ = D('<span class="kaching-bundles__progressive-gifts__gift__title"><!></span>'), d_ = D('<span class="kaching-bundles__progressive-gifts__gift__label__text"><!></span>'), g_ = D('<span class="kaching-bundles__progressive-gifts__gift__label__text kaching-bundles__progressive-gifts__gift__label__text--crossed-out"><!></span>'), h_ = D('<div class="kaching-bundles__progressive-gifts__gift__label"><!> <!></div>'), p_ = D('<div><div class="kaching-bundles__progressive-gifts__gift__content"><!> <div class="kaching-bundles__progressive-gifts__gift__details"><div class="kaching-bundles__progressive-gifts__gift__details__content"><!> <!></div> <!></div></div></div>');
  function ju(n, t) {
    Je(t, !0);
    const r = () => Me(y, "$config", c), a = () => Me(p, "$translate", c), l = () => Me(I, "$getMediaImageUrl", c), [c, u] = wt(), s = m(t, "progressiveGifts", 7), i = m(t, "gift", 7), o = m(t, "product", 7), d = m(t, "selectedDealBarIndex", 7), h = m(t, "onChange", 7), f = m(t, "onUnlock", 7), p = qt(), _ = cn(), I = qn(), y = on(), x = g(() => i().differentVariantsEnabled), M = g(() => {
      var b;
      return o() ? i().variantGIDs ? i().variantGIDs.map(Nt) : (b = o()) == null ? void 0 : b.variants.map((B) => B.id) : null;
    }), A = g(() => {
      if (o()) return { ...o(), variants: o().variants.filter((b) => (r().preview || b.availableForSale) && (!e(M) || e(M).includes(b.id))) };
    });
    let V = Ae(rt([]));
    const C = g(() => (function(b, B, G) {
      return b.length > 0 ? b : B != null && B.availableForSale && B.variants.length > 0 ? Array.from({ length: G }, () => B.variants[0].id) : [];
    })(e(V), e(A), i().quantity)), R = g(() => o() && e(C).length > 0 ? e(C).map((b) => o().variants.find((B) => B.id === b)).filter((b) => b !== void 0) : []), U = g(() => {
      var b;
      return pn({ priceFormatter: Me(_, "$formatPrice", c), product: o(), totalFullPrice: ((b = e(R)) == null ? void 0 : b.reduce((B, G) => {
        var z;
        return B + ((z = G == null ? void 0 : G.price) != null ? z : 0);
      }, 0)) || 0, totalDiscountedPrice: 0, quantity: i().quantity, unitQuantity: er(e(R).map((B) => ({ variant: B, quantity: 1 }))) });
    }), F = g(() => e(U)(a()(i().title))), se = g(() => e(U)(a()(i().lockedTitle))), X = g(() => e(U)(a()(i().label))), K = g(() => e(U)(a()(i().labelCrossedOut))), J = g(() => d() === null || i().unlockAtBar > d() + 1), N = g(() => {
      var b, B, G;
      return i().giftType === "shipping" ? hu : ((B = (b = e(R)) == null ? void 0 : b[0]) == null ? void 0 : B.image) || ((G = o()) == null ? void 0 : G.image);
    }), Z = g(() => i().mediaImageGID ? l()(i().mediaImageGID) : e(N)), $ = g(() => !s().inheritStyle && s().style && l()(s().style.lockedMediaImageGID));
    He(() => {
      if (o() && e(R) && !e(J)) {
        const b = Object.values(e(R).reduce((B, G) => (B[G.id] ? B[G.id].quantity += 1 : B[G.id] = { variant: G, quantity: 1 }, B), {}));
        Xt(() => h()({ product: o(), variants: b }));
      } else Xt(() => h()(void 0));
    }), Hn(() => {
      i().productGID;
    }), He(() => {
      e(J) && e(Z) && (new Image().src = e(Z));
    });
    const S = g(() => !(i().giftType !== "product" || !o() || o().availableForSale && o().variants.filter((b) => b.availableForSale && (!e(M) || e(M).includes(b.id))).length !== 0));
    var T = { get progressiveGifts() {
      return s();
    }, set progressiveGifts(b) {
      s(b), k();
    }, get gift() {
      return i();
    }, set gift(b) {
      i(b), k();
    }, get product() {
      return o();
    }, set product(b) {
      o(b), k();
    }, get selectedDealBarIndex() {
      return d();
    }, set selectedDealBarIndex(b) {
      d(b), k();
    }, get onChange() {
      return h();
    }, set onChange(b) {
      h(b), k();
    }, get onUnlock() {
      return f();
    }, set onUnlock(b) {
      f(b), k();
    } }, q = De(), W = ve(q), ue = (b) => {
      var B = De(), G = ve(B), z = (H) => {
        var Y = De(), L = ve(Y), O = (ee) => {
          Qt(ee, { element: "div", class: "kaching-bundles__progressive-gifts__gift kaching-bundles__progressive-gifts__gift--locked", get onclick() {
            return f();
          }, children: (le, re) => {
            var fe = o_(), ze = P(fe), ce = P(ze), ie = (Se) => {
              var Ve = a_();
              be(() => Pe(Ve, "src", e($))), v(Se, Ve);
            }, ke = (Se) => {
              Eu(Se);
            };
            j(ce, (Se) => {
              e($) ? Se(ie) : Se(ke, !1);
            }), w(ze);
            var we = E(ze, 2);
            qe(P(we), () => e(se)), w(we);
            var _e = E(we, 2), ye = (Se) => {
              var Ve = s_(), Ee = P(Ve), ne = (pe) => {
                var de = i_();
                qe(P(de), () => e(X)), w(de), v(pe, de);
              };
              j(Ee, (pe) => {
                e(X) && pe(ne);
              });
              var ge = E(Ee, 2), Te = (pe) => {
                var de = l_();
                qe(P(de), () => e(K)), w(de), v(pe, de);
              };
              j(ge, (pe) => {
                e(K) && pe(Te);
              }), w(Ve), v(Se, Ve);
            };
            j(_e, (Se) => {
              (e(X) || e(K)) && s().showLockedGiftLabels && Se(ye);
            }), w(fe), v(le, fe);
          }, $$slots: { default: !0 } });
        }, ae = (ee) => {
          var le = p_();
          let re;
          var fe = P(le), ze = P(fe), ce = (ne) => {
            var ge = c_(), Te = P(ge);
            w(ge), be(() => {
              var pe, de;
              Pe(Te, "src", e(Z)), Pe(Te, "alt", (de = (pe = o()) == null ? void 0 : pe.title) != null ? de : "");
            }), v(ne, ge);
          };
          j(ze, (ne) => {
            e(Z) && ne(ce);
          });
          var ie = E(ze, 2), ke = P(ie), we = P(ke), _e = (ne) => {
            var ge = u_();
            qe(P(ge), () => e(F)), w(ge), v(ne, ge);
          };
          j(we, (ne) => {
            e(F) && ne(_e);
          });
          var ye = E(we, 2), Se = (ne) => {
            var ge = h_(), Te = P(ge), pe = (je) => {
              var st = d_();
              qe(P(st), () => e(X)), w(st), v(je, st);
            };
            j(Te, (je) => {
              e(X) && je(pe);
            });
            var de = E(Te, 2), $e = (je) => {
              var st = g_();
              qe(P(st), () => e(K)), w(st), v(je, st);
            };
            j(de, (je) => {
              e(K) && je($e);
            }), w(ge), v(ne, ge);
          };
          j(ye, (ne) => {
            (e(X) || e(K)) && ne(Se);
          }), w(ke);
          var Ve = E(ke, 2), Ee = (ne) => {
            var ge = De();
            Jt(ve(ge), 17, () => ({ length: e(x) ? i().quantity : 1 }), Zr, (Te, pe, de) => {
              var $e = De(), je = ve($e), st = (pt) => {
                {
                  let ot = g(() => e(x) ? de + 1 : void 0);
                  Mn(pt, { get product() {
                    return e(A);
                  }, get selectedVariantId() {
                    return e(C)[de];
                  }, get number() {
                    return e(ot);
                  }, forceDropdown: !0, onChange: (Ne) => (function(it, Et) {
                    e(x) ? te(V, [...e(C).slice(0, Et), it, ...e(C).slice(Et + 1)], !0) : te(V, Array.from({ length: i().quantity }, () => it), !0);
                  })(Ne, de) });
                }
              };
              j(je, (pt) => {
                e(C)[de] !== void 0 && pt(st);
              }), v(Te, $e);
            }), v(ne, ge);
          };
          j(Ve, (ne) => {
            e(A) && e(A).variants.length > 1 && e(C).length > 0 && ne(Ee);
          }), w(ie), w(fe), w(le), be((ne) => re = Ot(le, 1, "kaching-bundles__progressive-gifts__gift", null, re, ne), [() => ({ "kaching-bundles__progressive-gifts__gift--out-of-stock": r().preview && e(S) })]), v(ee, le);
        };
        j(L, (ee) => {
          e(J) ? ee(O) : ee(ae, !1);
        }), v(H, Y);
      };
      j(G, (H) => {
        var Y;
        (o() && ((Y = e(R)) != null && Y.length || r().preview && e(S)) || i().giftType === "shipping") && H(z);
      }), v(b, B);
    };
    j(W, (b) => {
      e(J) && s().hideLockedGifts || b(ue);
    }), v(n, q);
    var Q = Ye(T);
    return u(), Q;
  }
  We(ju, { progressiveGifts: {}, gift: {}, product: {}, selectedDealBarIndex: {}, onChange: {}, onUnlock: {} }, [], [], !0);
  var f_ = D('<span class="kaching-bundles__progressive-gifts__title"><!></span>'), b_ = D('<span class="kaching-bundles__progressive-gifts__subtitle"><!></span>'), v_ = D('<div class="kaching-bundles__progressive-gifts"><div class="kaching-bundles__progressive-gifts__header"><!> <!></div> <div></div></div>');
  function Ru(n, t) {
    Je(t, !0);
    const r = () => Me(p, "$config", l), a = () => Me(f, "$translate", l), [l, c] = wt(), u = m(t, "progressiveGifts", 7), s = m(t, "dealBlock", 7), i = m(t, "otherProducts", 7), o = m(t, "selectedDealBarIndex", 7), d = m(t, "onChange", 7), h = m(t, "onUnlock", 7), f = qt(), p = on();
    let _ = Ae(rt({}));
    const I = g(() => ((K) => {
      const { progressiveGifts: J, colors: N, fonts: Z } = K, $ = (J == null ? void 0 : J.inheritStyle) || !(J != null && J.style);
      return hn({ "kaching-bundles-progressive-gifts-title-color": Re(J.titleColor), "kaching-bundles-progressive-gifts-title-alignment": J.titleAlignment, "kaching-bundles-progressive-gifts-title-size": J.titleSize + "px", "kaching-bundles-progressive-gifts-title-weight": Yn(J.titleStyle), "kaching-bundles-progressive-gifts-title-style": Kn(J.titleStyle), "kaching-bundles-progressive-gifts-subtitle-color": Re(J.subtitleColor), "kaching-bundles-progressive-gifts-subtitle-alignment": J.subtitleAlignment, "kaching-bundles-progressive-gifts-subtitle-size": J.subtitleSize + "px", "kaching-bundles-progressive-gifts-subtitle-weight": Yn(J.subtitleStyle), "kaching-bundles-progressive-gifts-subtitle-style": Kn(J.subtitleStyle), "kaching-bundles-progressive-gifts-image-size": $ ? void 0 : J.style.imageSize + "px", "kaching-bundles-progressive-gifts-border-radius": ($ ? K.cornerRadius : J.style.cornerRadius) + "px", "kaching-bundles-progressive-gifts-label-background-color": Re($ ? N.progressiveGiftsLabelBackground || N.labelBackground : J.style.labelBackgroundColor), "kaching-bundles-progressive-gifts-label-text-color": Re($ ? N.label : J.style.labelTextColor), "kaching-bundles-progressive-gifts-label-text-size": ($ ? Z.label.size : J.style.labelTextSize) + "px", "kaching-bundles-progressive-gifts-background-color": Re($ ? N.selectedBackground : J.style.backgroundColor), "kaching-bundles-progressive-gifts-border-color": Re($ ? N.border : J.style.borderColor), "kaching-bundles-progressive-gifts-text-color": Re($ ? N.title : J.style.textColor), "kaching-bundles-progressive-gifts-text-size": $ ? void 0 : J.style.textSize + "px", "kaching-bundles-progressive-gifts-locked-background-color": Re($ ? N.background : J.style.lockedBackgroundColor), "kaching-bundles-progressive-gifts-locked-border-color": Re($ ? { ...N.border, alpha: 0.3 * N.border.alpha } : J.style.lockedBorderColor), "kaching-bundles-progressive-gifts-locked-text-color": $ ? void 0 : Re(J.style.lockedTextColor), "kaching-bundles-progressive-gifts-locked-text-size": $ ? void 0 : J.style.lockedTextSize + "px", "kaching-bundles-progressive-gifts-locked-icon-color": $ ? void 0 : Re(J.style.lockedIconColor) });
    })(s())), y = g(() => u().gifts.flatMap((K) => {
      const J = K.giftType === "product" && K.productGID ? i().find((Z) => Z.id === Nt(K.productGID)) : void 0;
      if (!r().preview && K.giftType === "product" && !(J != null && J.availableForSale)) return [];
      const N = J && !r().preview ? Xn(J) : J;
      return { gift: K, product: N };
    }));
    var x = { get progressiveGifts() {
      return u();
    }, set progressiveGifts(K) {
      u(K), k();
    }, get dealBlock() {
      return s();
    }, set dealBlock(K) {
      s(K), k();
    }, get otherProducts() {
      return i();
    }, set otherProducts(K) {
      i(K), k();
    }, get selectedDealBarIndex() {
      return o();
    }, set selectedDealBarIndex(K) {
      o(K), k();
    }, get onChange() {
      return d();
    }, set onChange(K) {
      d(K), k();
    }, get onUnlock() {
      return h();
    }, set onUnlock(K) {
      h(K), k();
    } }, M = v_(), A = P(M), V = P(A), C = (K) => {
      var J = f_();
      qe(P(J), () => a()(u().title)), w(J), v(K, J);
    };
    j(V, (K) => {
      u().title && K(C);
    });
    var R = E(V, 2), U = (K) => {
      var J = b_();
      qe(P(J), () => a()(u().subtitle)), w(J), v(K, J);
    };
    j(R, (K) => {
      u().subtitle && K(U);
    }), w(A);
    var F = E(A, 2);
    let se;
    Jt(F, 21, () => e(y), ({ gift: K, product: J }) => K.id, (K, J) => {
      let N = () => e(J).gift;
      ju(K, { get progressiveGifts() {
        return u();
      }, get gift() {
        return N();
      }, get product() {
        return e(J).product;
      }, get selectedDealBarIndex() {
        return o();
      }, onChange: (Z) => (function($, S) {
        S ? e(_)[$] = S : delete e(_)[$];
        const T = Object.entries(e(_)).map(([q, W]) => ({ id: q, variants: W.variants, product: W.product }));
        d()(T);
      })(N().id, Z), onUnlock: () => h()(N().unlockAtBar - 1) });
    }), w(F), w(M), be((K) => {
      Wt(M, e(I)), se = Ot(F, 1, "kaching-bundles__progressive-gifts__gifts", null, se, K);
    }, [() => ({ "kaching-bundles__progressive-gifts__gifts--vertical": u().layout === "vertical" })]), v(n, M);
    var X = Ye(x);
    return c(), X;
  }
  We(Ru, { progressiveGifts: {}, dealBlock: {}, otherProducts: {}, selectedDealBarIndex: {}, onChange: {}, onUnlock: {} }, [], [], !0);
  var __ = D('<span class="kaching-bundles__bar-title"><!></span>'), k_ = D('<div class="kaching-bundles__bar-subtitle"><!></div>'), m_ = D('<div class="kaching-bundles__bar-price"><!></div>'), y_ = D('<div class="kaching-bundles__bar-full-price"><!></div>'), x_ = D('<span><!></span> <img class="kaching-bundles__checkbox-upsells__image"/> <div class="kaching-bundles__bar-content"><div class="kaching-bundles__bar-content-left"><div class="kaching-bundles__bar-first-line"><!></div> <!></div></div> <div class="kaching-bundles__bar-pricing"><!> <!></div>', 1), w_ = D('<div class="kaching-bundles__bar-variants"><!> <!></div>'), P_ = D('<div class="kaching-bundles__bar-variants"><!></div>'), S_ = D('<div><div class="kaching-bundles__bar-container"><!> <div class="kaching-bundles__bar-wrapper"><!> <!> <!> <!></div></div></div>');
  function Qu(n, t) {
    Je(t, !0);
    const r = () => Me(y, "$config", u), a = () => Me(_, "$formatPrice", u), l = () => Me(H, "$translate", u), c = () => Me(I, "$getMediaImageUrl", u), [u, s] = wt(), i = m(t, "checkboxUpsell", 7), o = m(t, "product", 7), d = m(t, "dealBlock", 7), h = m(t, "dealSellingPlan", 7), f = m(t, "dealBarQuantity", 7), p = m(t, "onChange", 7), _ = cn(), I = qn(), y = on();
    let x = Ae(!1), M = Ae(1), A = Ae(rt({})), V = Ae(void 0);
    const C = g(() => {
      var pe;
      return (pe = i().preselected) != null && pe;
    });
    He(() => {
      te(x, e(C), !0);
    }), He(() => {
      i().matchQuantityWithDealBar && te(M, f(), !0);
    });
    const R = g(() => !!i().variantGIDs), U = g(() => {
      var pe, de;
      return e(R) && o() ? o().variants.filter(($e) => i().variantGIDs.some((je) => Nt(je) === $e.id)) : (de = (pe = o()) == null ? void 0 : pe.variants) != null ? de : [];
    }), F = g(() => e(M) > 1 && e(U).length > 1), se = g(() => (function(pe, de) {
      if (pe.variantGIDs)
        return pe.variantGIDs.length === 0 ? void 0 : Nt(pe.variantGIDs[0]);
      if (de != null && de.availableForSale && de.variants.length > 0) return de.variants[0].id;
    })(i(), o())), X = g(() => {
      if (e(se) === void 0) return [];
      const pe = [];
      for (let de = 0; de < e(M); de++) {
        const $e = e(A)[de];
        $e !== void 0 ? pe.push($e) : pe.push(e(se));
      }
      return pe;
    }), K = g(() => (function(pe, de) {
      if (!de) return [];
      const $e = {};
      for (const je of pe) {
        const st = $e[je];
        if (st) {
          st.quantity += 1;
          continue;
        }
        const pt = de.variants.find((ot) => ot.id === je);
        pt && ($e[je] = { variant: pt, quantity: 1 });
      }
      return Object.values($e);
    })(e(X), o())), J = g(() => {
      var pe;
      return (pe = e(K)[0]) == null ? void 0 : pe.variant;
    }), N = g(() => {
      var pe;
      return (pe = i().subscriptionEnabled) == null || pe;
    }), Z = g(() => {
      var pe;
      return (pe = i().subscriptionType) != null ? pe : "deal";
    }), $ = g(() => e(N) && e(Z) === "always" && o() && e(J) ? Di(o(), [e(J)]) : []), S = g(() => e($).find((pe) => pe.id === e(V)) || e($)[0]);
    He(() => {
      var pe;
      e($).some((de) => {
        var $e;
        return de.id === (($e = h()) == null ? void 0 : $e.id);
      }) && te(V, (pe = h()) == null ? void 0 : pe.id, !0);
    });
    const T = g(() => {
      if (o() && e(J) && e(N))
        return e(Z) === "deal" ? h() ? Fn(o(), e(J), h()) : void 0 : e(S);
    }), q = g(() => d().priceRounding ? { perItem: d().showPricesPerItem, precision: d().priceRoundingPrecision, v2: r().featureFlags.price_rounding_v2 || !1 } : void 0);
    function W(pe) {
      return Tr({ discountType: i().discountType, discountValue: i().discountValue, discountQuantity: 1, variantQuantities: e(K), currencyRate: r().currencyRate, priceRounding: e(q), sellingPlan: pe });
    }
    let ue = g(() => W(e(T))), Q = g(() => e(K).reduce((pe, { variant: de, quantity: $e }) => pe + Math.max(de.price, de.compareAtPrice || 0) * $e, 0));
    const b = g(() => o() && e(J) ? Fn(o(), e(J), void 0) : void 0), B = g(() => e(N) && e(Z) === "always" ? e(ue) : W(e(b))), G = g(() => !o() || !e(J) ? [] : Di(o(), [e(J)]).map((pe) => {
      let de;
      return de = e(N) ? e(Z) === "always" ? e(S) : pe : e(b), { sellingPlanId: pe.id, discountedPrice: W(de) };
    })), z = g(() => pn({ priceFormatter: a(), product: o(), totalFullPrice: e(Q), totalDiscountedPrice: e(ue), quantity: e(M), legacySavedPercentage: r().featureFlags.legacy_saved_percentage || !1, unitQuantity: er(e(K)), sellingPlan: e(T) })), H = qt();
    let Y = g(() => e(z)(l()(i().title))), L = g(() => e(z)(l()(i().subtitle))), O = g(() => e(Q) && e(Q) > e(ue));
    const ae = g(() => c()(i().mediaImageGID)), ee = g(() => e(z)(l()(i().badgeText || ""))), le = g(() => {
      var pe;
      return c()((pe = i().badgeImageGID) != null ? pe : null);
    });
    function re(pe, de) {
      te(A, { ...e(A), [pe]: de }, !0);
    }
    He(() => {
      if (o() && e(K).length > 0 && e(x)) {
        const pe = e(T);
        Xt(() => p()({ product: o(), variants: e(K), sellingPlan: pe, pricing: { discountedPrice: e(ue), fullPrice: e(Q), discountedPriceWithoutSellingPlan: e(B), discountedPricesForSellingPlans: e(G) } }));
      } else Xt(() => p()(void 0));
    });
    var fe = { get checkboxUpsell() {
      return i();
    }, set checkboxUpsell(pe) {
      i(pe), k();
    }, get product() {
      return o();
    }, set product(pe) {
      o(pe), k();
    }, get dealBlock() {
      return d();
    }, set dealBlock(pe) {
      d(pe), k();
    }, get dealSellingPlan() {
      return h();
    }, set dealSellingPlan(pe) {
      h(pe), k();
    }, get dealBarQuantity() {
      return f();
    }, set dealBarQuantity(pe) {
      f(pe), k();
    }, get onChange() {
      return p();
    }, set onChange(pe) {
      p(pe), k();
    } }, ze = S_();
    let ce;
    var ie = P(ze), ke = P(ie);
    {
      let pe = g(() => e(ee) || void 0);
      wa(ke, { get style() {
        return i().badgeStyle;
      }, get text() {
        return e(pe);
      }, get imageUrl() {
        return e(le);
      }, blockLayout: "vertical" });
    }
    var we = E(ke, 2), _e = P(we);
    Qt(_e, { element: "div", class: "kaching-bundles__bar-main", role: "checkbox", get "aria-checked"() {
      return e(x);
    }, onclick: function() {
      te(x, !e(x));
    }, children: (pe, de) => {
      var $e = x_(), je = ve($e);
      let st;
      var pt = P(je), ot = (gt) => {
        wl(gt);
      };
      j(pt, (gt) => {
        e(x) && gt(ot);
      }), w(je);
      var Ne = E(je, 2), it = E(Ne, 2), Et = P(it), Pt = P(Et);
      Ke(P(Pt), () => e(Y), (gt) => {
        var Qe = __();
        qe(P(Qe), () => e(Y)), w(Qe), v(gt, Qe);
      }), w(Pt);
      var Ft = E(Pt, 2), Dt = (gt) => {
        var Qe = De();
        Ke(ve(Qe), () => e(L), (at) => {
          var Ze = k_();
          qe(P(Ze), () => e(L)), w(Ze), v(at, Ze);
        }), v(gt, Qe);
      };
      j(Ft, (gt) => {
        e(L) && gt(Dt);
      }), w(Et), w(it);
      var Lt = E(it, 2), Ce = P(Lt);
      Ke(Ce, () => e(ue), (gt) => {
        var Qe = m_();
        qe(P(Qe), () => a()(e(ue))), w(Qe), be((at) => Pe(Qe, "data-a11y-label", at), [() => l()("system.price")]), v(gt, Qe);
      });
      var tt = E(Ce, 2), ft = (gt) => {
        var Qe = De();
        Ke(ve(Qe), () => e(Q), (at) => {
          var Ze = y_();
          qe(P(Ze), () => a()(e(Q))), w(Ze), be((zt) => Pe(Ze, "data-a11y-label", zt), [() => l()("system.original_price")]), v(at, Ze);
        }), v(gt, Qe);
      };
      j(tt, (gt) => {
        e(O) && gt(ft);
      }), w(Lt), be((gt) => {
        var Qe, at, Ze;
        st = Ot(je, 1, "kaching-bundles__checkbox-upsells__checkbox", null, st, gt), Pe(Ne, "src", e(ae) || ((Qe = e(J)) == null ? void 0 : Qe.image) || ((at = o()) == null ? void 0 : at.image)), Pe(Ne, "alt", (Ze = o()) == null ? void 0 : Ze.title);
      }, [() => ({ "kaching-bundles__checkbox-upsells__checkbox--selected": e(x) })]), v(pe, $e);
    }, $$slots: { default: !0 } });
    var ye = E(_e, 2), Se = (pe) => {
      var de = w_(), $e = P(de);
      {
        let ot = g(() => ({ ...o(), variants: e(U) }));
        Vr($e, { get product() {
          return e(ot);
        } });
      }
      var je = E($e, 2), st = (ot) => {
        var Ne = De();
        Jt(ve(Ne), 17, () => ({ length: e(M) }), Zr, (it, Et, Pt) => {
          {
            let Ft = g(() => ({ ...o(), variants: e(U) })), Dt = g(() => e(M) > 1 ? Pt + 1 : void 0);
            Mn(it, { get product() {
              return e(Ft);
            }, get selectedVariantId() {
              return e(X)[Pt];
            }, get number() {
              return e(Dt);
            }, onChange: (Lt) => re(Pt, Lt) });
          }
        }), v(ot, Ne);
      }, pt = (ot) => {
        {
          let Ne = g(() => ({ ...o(), variants: e(U) }));
          Mn(ot, { get product() {
            return e(Ne);
          }, get selectedVariantId() {
            return e(X)[0];
          }, onChange: (it) => re(0, it) });
        }
      };
      j(je, (ot) => {
        e(F) ? ot(st) : ot(pt, !1);
      }), w(de), v(pe, de);
    };
    j(ye, (pe) => {
      e(x) && e(U).length > 1 && e(X).length > 0 && pe(Se);
    });
    var Ve = E(ye, 2), Ee = (pe) => {
      var de = P_();
      Xr(P(de), { get sellingPlans() {
        return e($);
      }, get selectedSellingPlan() {
        return e(S);
      }, onChange: ($e) => te(V, $e.id, !0) }), w(de), v(pe, de);
    };
    j(Ve, (pe) => {
      e(x) && e($).length > 1 && e(S) && pe(Ee);
    });
    var ne = E(Ve, 2), ge = (pe) => {
      qi(pe, { get value() {
        return e(M);
      }, min: 1, onChange: (de) => te(M, de, !0) });
    };
    j(ne, (pe) => {
      e(x) && i().quantitySelector && pe(ge);
    }), w(we), w(ie), w(ze), be((pe) => ce = Ot(ze, 1, "kaching-bundles__checkbox-upsells__upsell kaching-bundles__bar", null, ce, pe), [() => {
      var pe;
      return { "kaching-bundles__bar--selected": e(x), "kaching-bundles__bar--disabled": r().preview && !((pe = o()) != null && pe.availableForSale) };
    }]), v(n, ze);
    var Te = Ye(fe);
    return s(), Te;
  }
  We(Qu, { checkboxUpsell: {}, product: {}, dealBlock: {}, dealSellingPlan: {}, dealBarQuantity: {}, onChange: {} }, [], [], !0);
  var C_ = D('<div class="kaching-bundles__block-title"><!></div>'), B_ = D('<div class="kaching-bundles__checkbox-upsells"><!> <div class="kaching-bundles__checkbox-upsells__upsells"></div></div>');
  function Nu(n, t) {
    Je(t, !0);
    const [r, a] = wt(), l = m(t, "checkboxUpsells", 7), c = m(t, "dealBlock", 7), u = m(t, "otherProducts", 7), s = m(t, "complementaryProducts", 7), i = m(t, "dealSellingPlan", 7), o = m(t, "dealBarQuantity", 7), d = m(t, "onChange", 7), h = on(), f = qt(), p = g(() => l().title ? Me(f, "$translate", r)(l().title) : "");
    let _ = Ae(rt({}));
    const I = g(() => s().map(Xn)), y = Math.floor(1e3 * Math.random()), x = g(() => l().upsells.flatMap((F, se) => {
      if (F.productSource === "complementary") {
        const J = e(I)[(se + y) % (e(I).length || 1)];
        return J ? { upsell: F, product: J } : [];
      }
      const X = F.productGID ? u().find((J) => J.id === Nt(F.productGID)) : void 0;
      if (!Me(h, "$config", r).preview && !(X != null && X.availableForSale)) return [];
      const K = X && Xn(X);
      return { upsell: F, product: K };
    }));
    var M = { get checkboxUpsells() {
      return l();
    }, set checkboxUpsells(F) {
      l(F), k();
    }, get dealBlock() {
      return c();
    }, set dealBlock(F) {
      c(F), k();
    }, get otherProducts() {
      return u();
    }, set otherProducts(F) {
      u(F), k();
    }, get complementaryProducts() {
      return s();
    }, set complementaryProducts(F) {
      s(F), k();
    }, get dealSellingPlan() {
      return i();
    }, set dealSellingPlan(F) {
      i(F), k();
    }, get dealBarQuantity() {
      return o();
    }, set dealBarQuantity(F) {
      o(F), k();
    }, get onChange() {
      return d();
    }, set onChange(F) {
      d(F), k();
    } }, A = B_(), V = P(A), C = (F) => {
      var se = C_();
      qe(P(se), () => e(p)), w(se), v(F, se);
    };
    j(V, (F) => {
      e(p) && F(C);
    });
    var R = E(V, 2);
    Jt(R, 21, () => e(x), ({ upsell: F, product: se }) => F.id, (F, se) => {
      let X = () => e(se).upsell;
      Qu(F, { get checkboxUpsell() {
        return X();
      }, get product() {
        return e(se).product;
      }, get dealBlock() {
        return c();
      }, get dealSellingPlan() {
        return i();
      }, get dealBarQuantity() {
        return o();
      }, onChange: (K) => (function(J, N) {
        var Z;
        N ? e(_)[J] = N : delete e(_)[J];
        const $ = Object.entries(e(_)).flatMap(([Q, b]) => b.variants.map(({ variant: B, quantity: G }) => ({ id: Q, variant: B, product: b.product, quantity: G, sellingPlan: b.sellingPlan })));
        let S = 0, T = 0, q = 0;
        const W = /* @__PURE__ */ new Map();
        for (const Q of Object.values(e(_))) {
          S += Q.pricing.discountedPrice, T += Q.pricing.fullPrice, q += Q.pricing.discountedPriceWithoutSellingPlan;
          for (const b of Q.pricing.discountedPricesForSellingPlans) W.set(b.sellingPlanId, ((Z = W.get(b.sellingPlanId)) != null ? Z : 0) + b.discountedPrice);
        }
        const ue = Array.from(W, ([Q, b]) => ({ sellingPlanId: Q, discountedPrice: b }));
        d()($, { discountedPrice: S, fullPrice: T, discountedPriceWithoutSellingPlan: q, discountedPricesForSellingPlans: ue });
      })(X().id, K) });
    }), w(R), w(A), v(n, A);
    var U = Ye(M);
    return a(), U;
  }
  We(Nu, { checkboxUpsells: {}, dealBlock: {}, otherProducts: {}, complementaryProducts: {}, dealSellingPlan: {}, dealBarQuantity: {}, onChange: {} }, [], [], !0);
  var I_ = D('<div class="kaching-bundles__timer" role="timer"><div class="kaching-bundles__timer-title"><!></div></div>');
  function Wu(n, t) {
    Je(t, !0);
    const [r, a] = wt(), l = m(t, "timer", 7), c = qt(), u = g(() => ((C) => {
      const { textColor: R, backgroundColor: U, titleAlignment: F, titleStyle: se, titleSize: X } = C;
      return hn({ "kaching-bundles-timer-background-color": Re(U), "kaching-bundles-timer-text-color": Re(R), "kaching-bundles-timer-title-alignment": F, "kaching-bundles-timer-title-font-weight": se ? Yn(se) : null, "kaching-bundles-timer-title-font-style": se ? Kn(se) : null, "kaching-bundles-timer-title-size": X ? X + "px" : null });
    })(l()));
    function s() {
      const C = new Is(), R = new Is(C);
      return R.setHours(24, 0, 0, 0), Math.floor((R.getTime() - C.getTime()) / 1e3);
    }
    function i() {
      if (!l().endTimestamp) return 0;
      const C = new Is();
      return Math.max(0, Math.floor((l().endTimestamp - C.getTime()) / 1e3));
    }
    function o() {
      return l().type === "midnight" ? s() : l().type === "custom" ? i() : 60 * l().minutes;
    }
    let d = Ae(rt(o())), h = g(() => l().type !== "custom" || e(d) > 0);
    He(() => {
      te(d, o(), !0);
    }), He(() => {
      const C = window.setInterval(() => {
        l().type === "midnight" ? te(d, s(), !0) : l().type === "custom" ? te(d, i(), !0) : te(d, e(d) <= 1 ? o() : e(d) - 1, !0);
      }, 1e3);
      return () => window.clearInterval(C);
    });
    const f = g(() => Me(c, "$translate", r)(l().title)), p = g(() => (function(C) {
      const R = Math.floor(C / 86400), U = Math.floor(C % 86400 / 3600), F = Math.floor(C % 3600 / 60), se = C % 60, X = (K) => K.toString().padStart(2, "0");
      return l().type === "custom" && R > 0 ? `${Intl.NumberFormat(navigator.language, { style: "unit", unit: "day", unitDisplay: "narrow" }).format(R)} ${X(U)}:${X(F)}:${X(se)}` : U > 0 ? `${X(U)}:${X(F)}:${X(se)}` : `${X(F)}:${X(se)}`;
    })(e(d))), _ = g(() => e(f).replace(/\{\{\s*\w+\s*\}\}/g, '<span class="kaching-bundles__timer-value" translate="no"></span>'));
    let I = Ae(void 0);
    He(() => {
      !e(I) || !e(_) || e(I).querySelectorAll(".kaching-bundles__timer-value").forEach((C) => {
        C.textContent = ` ${e(p)} `;
      });
    });
    var y = { get timer() {
      return l();
    }, set timer(C) {
      l(C), k();
    } }, x = De(), M = ve(x), A = (C) => {
      var R = I_(), U = P(R);
      qe(P(U), () => e(_)), w(U), ol(U, (F) => te(I, F), () => e(I)), w(R), be(() => Wt(R, e(u))), v(C, R);
    };
    j(M, (C) => {
      e(h) && C(A);
    }), v(n, x);
    var V = Ye(y);
    return a(), V;
  }
  function Uu(n, t) {
    Je(t, !0);
    const r = m(t, "dealBlockId", 7), a = m(t, "shopCustomStyles", 7), l = m(t, "customStyles", 7), c = g(() => {
      const d = [a(), l()].filter((h) => h == null ? void 0 : h.trim()).join(`
`);
      return d ? `
      <style id="kaching-bundles-custom-styles-${r()}">
        kaching-bundles-block[deal-block-id="${r()}"] {
          ${d}
        }
      </style>
    ` : "";
    });
    var u = { get dealBlockId() {
      return r();
    }, set dealBlockId(d) {
      r(d), k();
    }, get shopCustomStyles() {
      return a();
    }, set shopCustomStyles(d) {
      a(d), k();
    }, get customStyles() {
      return l();
    }, set customStyles(d) {
      l(d), k();
    } }, s = De(), i = ve(s), o = (d) => {
      var h = De();
      qe(ve(h), () => e(c)), v(d, h);
    };
    return j(i, (d) => {
      e(c) && d(o);
    }), v(n, s), Ye(u);
  }
  We(Wu, { timer: {} }, [], [], !0), We(Uu, { dealBlockId: {}, shopCustomStyles: {}, customStyles: {} }, [], [], !0);
  function M_(n, t = 4) {
    const r = (function(a) {
      let l = 2166136261;
      for (let c = 0; c < a.length; c++) l ^= a.charCodeAt(c), l = Math.imul(l, 16777619) >>> 0;
      return l >>> 0;
    })(n);
    return (function(a, l) {
      let c = "";
      for (let u = 0; u < l; u++) c = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"[a % 62] + c, a = Math.floor(a / 62);
      return c;
    })(r, t);
  }
  function Hu(n) {
    var t, r, a, l, c;
    const { dealBlock: u, product: s, selectedDealBarId: i, selectedVariantQuantities: o, selectedBundleProducts: d, selectedCollectionBreaksProducts: h, selectedFreeGifts: f, selectedProgressiveGifts: p, selectedCheckboxUpsells: _, selectedUpsells: I, selectedPersonalisations: y, selectedSellingPlan: x, dealBarSellingPlan: M, nativeBundleProductIds: A } = n, V = (function(O) {
      const { product: ae, selectedVariantQuantities: ee, selectedBundleProducts: le, selectedCollectionBreaksProducts: re, selectedFreeGifts: fe, selectedProgressiveGifts: ze, selectedCheckboxUpsells: ce, selectedUpsells: ie, selectedSellingPlan: ke, dealBarSellingPlan: we, selectedDealBarId: _e, bundleNonce: ye } = O, Se = le.length > 0 || re.length > 0 || fe.length > 0 || ze.length > 0 || ie.length > 0, Ve = fe.length > 0 || ze.length > 0 || ie.length > 0, Ee = JSON.stringify([Se ? ee.map(({ variant: ne, quantity: ge }) => ({ variantId: ne.id, quantity: ge })) : ae.id, le.map(({ id: ne, variant: ge, quantity: Te }) => ({ id: ne, variantId: ge.id, quantity: Te })), re.map(({ variant: ne, quantity: ge }) => ({ variantId: ne.id, quantity: ge })), fe.map(({ id: ne, variant: ge, quantity: Te }) => ({ id: ne, variantId: ge.id, quantity: Te })), ze.map(({ id: ne, variants: ge }) => ge.map((Te) => ({ id: ne, variantId: Te.variant.id, quantity: Te.quantity })).flat()).flat(), ce.map(({ id: ne, variant: ge }) => ({ id: ne, variantId: ge.id })), ie.map(({ id: ne, variant: ge, quantity: Te }) => ({ id: ne, variantId: ge.id, quantity: Te })), ke == null ? void 0 : ke.id, we == null ? void 0 : we.id, _e, ...Ve ? [ye] : []]);
      return M_(Ee);
    })(n), C = u.dealBars.find((O) => O.id === i);
    let R = !1;
    C && (!C.dealBarType || C.dealBarType === "quantity-break" || C.dealBarType === "bxgy") && u.dealBars.filter((O) => !O.dealBarType || O.dealBarType === "quantity-break" || O.dealBarType === "bxgy").filter((O) => Ju(O) === Ju(C) && O.id !== i).length > 0 && (R = !0);
    const U = M != null ? M : x, F = (C == null ? void 0 : C.dealBarType) === "bxgy", se = o.some(({ variant: O }) => O.sellingPlans.length > 0), X = F && (se || n.splitBxgy), K = u.dealBars.some((O) => (O.freeGifts || []).filter((ae) => ae.productGID).length > 0), J = !(!u.progressiveGiftsEnabled || !u.progressiveGifts) && u.progressiveGifts.gifts.some((O) => O.giftType === "product"), N = u.dealBars.some((O) => (O.upsells || []).length > 0), Z = u.nanoId || u.id, $ = u.abTestVariantNumber ? vs(u.abTestVariantNumber) : void 0, S = (C == null ? void 0 : C.dealBarType) === "sku" || (C == null ? void 0 : C.dealBarType) === "bundle" || (C == null ? void 0 : C.dealBarType) === "mix-and-match" || R || X, T = { deal: Z, main: !0 };
    u.marketId && (T.market = u.marketId), S ? (T.id = V, T.bar = i) : (F || f.length > 0 || p.length > 0 || _.length > 0 || I.length > 0 || h.length > 0 || y.length > 0 || K || J || N) && (T.id = V), !T.bar && i && (T.bid = i), $ && (T.ab = $);
    const q = { id: V, deal: Z, bar: i };
    $ && (q.ab = $);
    const W = [];
    let ue = o, Q = [];
    if (X && h.length === 0) {
      const { buy: O, get: ae } = Ku(o, C.getQuantity);
      ue = O, Q = ae;
    }
    for (const { variant: O, quantity: ae } of ue) {
      const ee = { ...T }, le = Fn(s, O, U);
      le != null && le.priceAdjustment && C && Yu(C) && (ee.sellingPlan = { id: le.id, priceAdjustment: le.priceAdjustment });
      const re = { id: O.id, quantity: ae, properties: { __kaching_bundles: JSON.stringify(ee) } };
      le && (re.selling_plan = le.id), W.push(re);
    }
    const b = ue.length > 0 && !Zu(s, A) && (C == null ? void 0 : C.dealBarType) !== "mix-and-match" ? ue[0].variant.id : void 0;
    for (const { variant: O, quantity: ae } of Q) {
      const ee = { ...q, main: !0, bxgy: !0 }, le = Fn(s, O, U);
      le != null && le.priceAdjustment && (C == null ? void 0 : C.dealBarType) === "bxgy" && C.getDiscountType === "specific" && (ee.sellingPlan = { id: le.id, priceAdjustment: le.priceAdjustment });
      const re = { id: O.id, quantity: ae, properties: { __kaching_bundles: JSON.stringify(ee) } };
      Xa(re, b, s, A), le && (re.selling_plan = le.id), W.push(re);
    }
    for (const O of d) {
      const ae = { ...q, bundleProduct: O.id }, ee = Fn(O.product, O.variant, U);
      ee != null && ee.priceAdjustment && (C == null ? void 0 : C.dealBarType) === "bundle" && ((t = C == null ? void 0 : C.bundleProducts.find((re) => re.id === O.id)) == null ? void 0 : t.discountType) === "specific" && (ae.sellingPlan = { id: ee.id, priceAdjustment: ee.priceAdjustment });
      const le = { id: O.variant.id, quantity: O.quantity, properties: { __kaching_bundles: JSON.stringify(ae) } };
      Xa(le, b, O.product, A), ee && (le.selling_plan = ee.id), W.push(le);
    }
    let B = h, G = [];
    if (X && h.length > 0) {
      const { buy: O, get: ae } = Ku(h, C.getQuantity);
      B = O, G = ae;
    }
    const z = ((r = u.collectionBreaks) == null ? void 0 : r.visibility) === "deal-products";
    for (const O of B) {
      if (z) {
        const re = W.find((fe) => fe.id === O.variant.id);
        if (re) {
          re.quantity += O.quantity;
          continue;
        }
      }
      const ae = { ...q, collectionBreaksProduct: !0 };
      S || delete ae.bar;
      const ee = Fn(O.product, O.variant, U);
      ee != null && ee.priceAdjustment && C && Yu(C) && (ae.sellingPlan = { id: ee.id, priceAdjustment: ee.priceAdjustment });
      const le = { id: O.variant.id, quantity: O.quantity, properties: { __kaching_bundles: JSON.stringify(ae) } };
      ee && (le.selling_plan = ee.id), W.push(le);
    }
    for (const O of G) {
      const ae = { ...q, collectionBreaksProduct: !0 };
      S || delete ae.bar, ae.bxgy = !0;
      const ee = Fn(O.product, O.variant, U);
      ee != null && ee.priceAdjustment && (C == null ? void 0 : C.dealBarType) === "bxgy" && C.getDiscountType === "specific" && (ae.sellingPlan = { id: ee.id, priceAdjustment: ee.priceAdjustment });
      const le = { id: O.variant.id, quantity: O.quantity, properties: { __kaching_bundles: JSON.stringify(ae) } };
      ee && (le.selling_plan = ee.id), W.push(le);
    }
    for (const O of f) {
      const ae = { ...q, gift: O.id };
      delete ae.bar;
      const ee = { id: O.variant.id, quantity: O.quantity, properties: { __kaching_bundles: JSON.stringify(ae) } };
      Xa(ee, b, O.product, A);
      const le = Fn(O.product, O.variant, U);
      le && (ee.selling_plan = le.id), W.push(ee);
    }
    for (const O of p) {
      const ae = { ...q, gift: O.id };
      delete ae.bar;
      for (const ee of O.variants) {
        const le = { id: ee.variant.id, quantity: ee.quantity, properties: { __kaching_bundles: JSON.stringify(ae) } };
        Xa(le, b, O.product, A);
        const re = Fn(O.product, ee.variant, U);
        re && (le.selling_plan = re.id), W.push(le);
      }
    }
    for (const O of _) {
      const ae = { ...q, checkboxUpsell: O.id };
      delete ae.bar;
      const ee = O.sellingPlan, le = (a = u.checkboxUpsells) == null ? void 0 : a.upsells.find((fe) => fe.id === O.id);
      ee != null && ee.priceAdjustment && (le == null ? void 0 : le.discountType) === "specific" && (ae.sellingPlan = { id: ee.id, priceAdjustment: ee.priceAdjustment });
      const re = { id: O.variant.id, quantity: O.quantity, properties: { __kaching_bundles: JSON.stringify(ae) } };
      Xa(re, b, O.product, A), ee && (re.selling_plan = ee.id), W.push(re);
    }
    for (const O of I) {
      const ae = { ...q, upsell: O.id };
      delete ae.bar;
      const ee = O.sellingPlan;
      ee != null && ee.priceAdjustment && ((c = (l = C == null ? void 0 : C.upsells) == null ? void 0 : l.find((re) => re.id === O.id)) == null ? void 0 : c.discountType) === "specific" && (ae.sellingPlan = { id: ee.id, priceAdjustment: ee.priceAdjustment });
      const le = { id: O.variant.id, quantity: O.quantity, properties: { __kaching_bundles: JSON.stringify(ae) } };
      Xa(le, b, O.product, A), ee && (le.selling_plan = ee.id), W.push(le);
    }
    const H = [];
    for (const { variant: O, quantity: ae } of ue) for (let ee = 0; ee < ae; ee++) H.push(O.id);
    for (const O of y) {
      const ae = { ...q, personalisation: O.id };
      delete ae.bar;
      const ee = { id: O.variantId, quantity: 1, properties: { __kaching_bundles: JSON.stringify(ae), [O.valueLabel]: O.text } }, le = H[O.productIndex];
      le && (ee.parent_id = le), W.push(ee);
    }
    const Y = W.filter((O) => !O.parent_id), L = W.filter((O) => O.parent_id);
    return [...Y.reverse(), ...L];
  }
  function Zu(n, t) {
    return t.includes(n.id) || n.isNativeBundle === !0;
  }
  function Xa(n, t, r, a) {
    t && t !== n.id && (Zu(r, a) || (n.parent_id = t));
  }
  function Ju(n) {
    switch (n.dealBarType) {
      case void 0:
      case "quantity-break":
        return Number(n.quantity);
      case "bxgy":
        return Number(n.buyQuantity) + Number(n.getQuantity);
      case "bundle":
        return n.bundleProducts[0].quantity;
      case "mix-and-match":
      case "sku":
        return 1;
    }
  }
  function Yu(n) {
    switch (n.dealBarType) {
      case void 0:
      case "quantity-break":
        return n.discountType === "specific";
      case "bundle":
        return n.bundleProducts[0].discountType === "specific";
      case "bxgy":
        return n.buyDiscountType === "specific";
      case "mix-and-match":
        return n.discountType === "specific";
      case "sku":
        return !1;
    }
  }
  function Ku(n, t) {
    const r = [...n].sort((u, s) => u.variant.price - s.variant.price), a = [], l = [];
    let c = t;
    for (const u of r) {
      const s = Math.min(c, u.quantity), i = u.quantity - s;
      s > 0 && l.push({ ...u, quantity: s }), i > 0 && a.push({ ...u, quantity: i }), c -= s;
    }
    return { buy: a, get: l };
  }
  function D_(n, t, r) {
    t()({ dealBarId: r().id, preselected: !1 });
  }
  var z_ = D('<img class="kaching-bundles__bar-image" alt=""/>'), A_ = D('<div class="kaching-bundles__bar-radio"></div>'), $_ = D('<span class="kaching-bundles__bar-title"><!></span>'), q_ = D('<span class="kaching-bundles__bar-label"><!></span>'), V_ = D('<div class="kaching-bundles__bar-subtitle"><!></div>'), T_ = D('<div class="kaching-bundles__bar-full-price"><!></div>'), G_ = D('<!> <div class="kaching-bundles__bar-content"><div class="kaching-bundles__bar-content-left"><div class="kaching-bundles__bar-first-line"><!> <!></div> <div class="kaching-bundles__bar-second-line"><!> <!></div></div> <div class="kaching-bundles__bar-pricing"><!> <!></div></div>', 1), O_ = D('<div class="kaching-bundles__bar-selling-plan"><!></div>'), F_ = D('<div class="kaching-bundles__bar-variants"><!> <div class="kaching-bundles__bar-variant-selector-wrapper"><!> <!></div></div>'), L_ = D('<div><input type="radio"/> <label><!> <div class="kaching-bundles__bar-wrapper"><!> <!> <!> <!> <!></div> <!> <!> <!> <!></label> <!></div>');
  function Xu(n, t) {
    Je(t, !0);
    const r = () => Me(R, "$formatPrice", c), a = () => Me(C, "$translate", c), l = () => Me(U, "$getMediaImageUrl", c), [c, u] = wt();
    let s = m(t, "dealBlock", 7), i = m(t, "dealBar", 7), o = m(t, "otherProducts", 23, () => []), d = m(t, "complementaryProducts", 23, () => []), h = m(t, "selectedDealBarIndex", 7, null), f = m(t, "componentId", 7), p = m(t, "selected", 7, !1), _ = m(t, "globalSellingPlan", 7, void 0), I = m(t, "onProgressiveGiftsChange", 7), y = m(t, "onDealBarSelect", 7), x = m(t, "onDealBarDeselect", 7), M = m(t, "onVariantsChange", 7), A = m(t, "onPersonalisationsChange", 7), V = m(t, "personalisationInitialValues", 23, () => []);
    const C = qt(), R = cn(), U = qn();
    let F = Ae(rt([])), se = Ae(rt([])), X = Ae(rt([])), K = !1;
    const J = g(() => i().productGID ? o().find((Ce) => Ce.id === Nt(i().productGID)) : void 0);
    let N = Ae(void 0);
    const Z = g(() => (function(Ce, tt, ft) {
      if (Ce !== void 0 && ft && ft.variants.some((gt) => gt.id === Ce))
        return Ce;
      if (tt.variantGID) return Nt(tt.variantGID);
      if (ft && ft.variants.length > 0) return ft.variants[0].id;
    })(e(N), i(), e(J))), $ = g(() => e(Z) && e(J) ? e(J).variants.find((Ce) => Ce.id === e(Z)) : void 0), S = g(() => e($) ? [{ variant: e($), quantity: 1 }] : []);
    let T = Ae(void 0);
    const q = g(() => e(J) && e($) ? Di(e(J), [e($)]) : []), W = g(() => {
      var Ce, tt;
      return (i().sellingPlanEnabled || s().subscriptionsEnabled && ((Ce = s().subscriptions) == null ? void 0 : Ce.layout) === "link" && ((tt = s().subscriptions) == null ? void 0 : tt.subscribeByDefault)) && (!s().subscriptionsEnabled || !!_());
    }), ue = g(() => e(W) ? ms(i(), e(q), e(T)) : void 0), Q = g(() => {
      var Ce;
      return (Ce = e(ue)) != null ? Ce : e(J) && e($) ? Fn(e(J), e($), _()) : void 0;
    }), b = g(() => e($) ? Mi(e($), e(Q)) : 0), B = g(() => e($) ? (function(Ce, tt) {
      return Ce.useProductCompareAtPrice && tt.compareAtPrice ? Math.max(tt.price, tt.compareAtPrice) : tt.price;
    })(s(), e($)) : 0), G = g(() => e(B) > e(b)), z = g(() => pn({ priceFormatter: r(), product: e(J), dealBar: i(), totalFullPrice: e(B), totalDiscountedPrice: e(b), quantity: 1, unitQuantity: er(e(S)), sellingPlan: e(Q) })), H = g(() => e(z)(a()(i().title))), Y = g(() => e(z)(a()(i().subtitle))), L = g(() => e(z)(a()(i().label))), O = g(() => e(z)(a()(i().badgeText))), ae = g(() => l()(i().badgeImageGID)), ee = g(() => `${i().id}_${f()}`), le = g(() => l()(i().mediaImageGID) || zi), re = on(), fe = g(() => e(J) && e(J).variants.length > 1 && !i().variantGID && p()), ze = g(() => e(J) && Me(re, "$config", c).featureFlags.variant_images && new Set(e(J).variants.map((Ce) => Ce.image).filter((Ce) => Ce)).size > 1), ce = g(() => i().showAsSoldOutEnabled && i().showAsSoldOut ? $i(i().showAsSoldOut) : "");
    function ie(Ce) {
      te(N, Ce, !0);
    }
    He(() => {
      !p() || !e($) && e(J) || (e(F), e(X), e(se), e(Z), e(Q), Xt(() => {
        K || (K = !0, y()({ dealBarId: i().id, preselected: !0 })), (function() {
          const Ce = e(b) + e(X).reduce((at, Ze) => at + Ze.discountedPrice, 0), tt = e(B) + e(X).reduce((at, Ze) => at + Ze.fullPrice, 0) + e(F).reduce((at, Ze) => at + Ze.fullPrice, 0) + e(se).reduce((at, Ze) => at + Ze.fullPrice * Ze.quantity, 0), ft = e($) ? e($).price : 0, gt = e($) ? e($).sellingPlans.map((at) => ({ sellingPlanId: at.id, discountedPrice: at.price })) : [], Qe = { discountedPrice: Ce, fullPrice: tt, discountedPricePerItem: e(b), fullPricePerItem: e(B), discountedPriceWithoutSellingPlan: ft, discountedPricesForSellingPlans: gt };
          M()({ variants: e(S), freeGifts: [...e(F), ...e(se)], upsells: e(X), dealBarSellingPlan: e(ue), pricing: Qe, product: e(J) });
        })();
      }));
    });
    var ke = { get dealBlock() {
      return s();
    }, set dealBlock(Ce) {
      s(Ce), k();
    }, get dealBar() {
      return i();
    }, set dealBar(Ce) {
      i(Ce), k();
    }, get otherProducts() {
      return o();
    }, set otherProducts(Ce = []) {
      o(Ce), k();
    }, get complementaryProducts() {
      return d();
    }, set complementaryProducts(Ce = []) {
      d(Ce), k();
    }, get selectedDealBarIndex() {
      return h();
    }, set selectedDealBarIndex(Ce = null) {
      h(Ce), k();
    }, get componentId() {
      return f();
    }, set componentId(Ce) {
      f(Ce), k();
    }, get selected() {
      return p();
    }, set selected(Ce = !1) {
      p(Ce), k();
    }, get globalSellingPlan() {
      return _();
    }, set globalSellingPlan(Ce = void 0) {
      _(Ce), k();
    }, get onProgressiveGiftsChange() {
      return I();
    }, set onProgressiveGiftsChange(Ce) {
      I(Ce), k();
    }, get onDealBarSelect() {
      return y();
    }, set onDealBarSelect(Ce) {
      y(Ce), k();
    }, get onDealBarDeselect() {
      return x();
    }, set onDealBarDeselect(Ce) {
      x(Ce), k();
    }, get onVariantsChange() {
      return M();
    }, set onVariantsChange(Ce) {
      M(Ce), k();
    }, get onPersonalisationsChange() {
      return A();
    }, set onPersonalisationsChange(Ce) {
      A(Ce), k();
    }, get personalisationInitialValues() {
      return V();
    }, set personalisationInitialValues(Ce = []) {
      V(Ce), k();
    } }, we = L_();
    let _e;
    var ye = P(we);
    qr(ye), ye.__change = [D_, y, i];
    var Se = E(ye, 2);
    let Ve;
    var Ee = P(Se);
    {
      let Ce = g(() => e(O) || void 0);
      wa(Ee, { get style() {
        return i().badgeStyle;
      }, get text() {
        return e(Ce);
      }, get imageUrl() {
        return e(ae);
      }, get blockLayout() {
        return s().blockLayout;
      } });
    }
    var ne = E(Ee, 2), ge = P(ne);
    Qt(ge, { element: "div", class: "kaching-bundles__bar-main", onclick: function(Ce) {
      p() && (Ce.preventDefault(), Ce.stopPropagation(), x()());
    }, children: (Ce, tt) => {
      var ft = G_(), gt = ve(ft), Qe = (Ie) => {
        var Fe = z_();
        be(() => Pe(Fe, "src", e(le))), v(Ie, Fe);
      }, at = (Ie) => {
        v(Ie, A_());
      };
      j(gt, (Ie) => {
        i().mediaImageGID ? Ie(Qe) : Ie(at, !1);
      });
      var Ze = E(gt, 2), zt = P(Ze), en = P(zt), tn = P(en);
      Ke(tn, () => e(H), (Ie) => {
        var Fe = $_();
        qe(P(Fe), () => e(H)), w(Fe), v(Ie, Fe);
      });
      var _t = E(tn, 2), Bt = (Ie) => {
        var Fe = De();
        Ke(ve(Fe), () => e(L), (Ue) => {
          var ct = q_();
          qe(P(ct), () => e(L)), w(ct), v(Ue, ct);
        }), v(Ie, Fe);
      };
      j(_t, (Ie) => {
        e(L) && Ie(Bt);
      }), w(en);
      var an = E(en, 2), un = P(an), yn = (Ie) => {
        var Fe = De();
        Ke(ve(Fe), () => e(Y), (Ue) => {
          var ct = V_();
          qe(P(ct), () => e(Y)), w(ct), v(Ue, ct);
        }), v(Ie, Fe);
      };
      j(un, (Ie) => {
        e(Y) && Ie(yn);
      });
      var ln = E(un, 2), xe = (Ie) => {
        Gr(Ie, { get lowStockAlert() {
          return s().lowStockAlert;
        }, get inventoryQuantity() {
          return e($).inventoryQuantity;
        } });
      };
      j(ln, (Ie) => {
        !e(fe) && s().lowStockAlertEnabled && s().lowStockAlert && e($) && Ie(xe);
      }), w(an), w(zt);
      var Xe = E(zt, 2), ut = P(Xe);
      Ke(ut, () => e(b), (Ie) => {
        yr(Ie, { get amount() {
          return e(b);
        }, get showPricesPerItem() {
          return s().showPricesPerItem;
        }, get unitLabel() {
          return s().unitLabel;
        } });
      });
      var he = E(ut, 2), Oe = (Ie) => {
        var Fe = De();
        Ke(ve(Fe), () => e(B), (Ue) => {
          var ct = T_();
          qe(P(ct), () => r()(e(B))), w(ct), be((jt) => Pe(ct, "data-a11y-label", jt), [() => a()("system.original_price")]), v(Ue, ct);
        }), v(Ie, Fe);
      };
      j(he, (Ie) => {
        e(G) && Ie(Oe);
      }), w(Xe), w(Ze), v(Ce, ft);
    }, $$slots: { default: !0 } });
    var Te = E(ge, 2), pe = (Ce) => {
      ea(Ce, { get highlights() {
        return i().highlights;
      }, get isSelected() {
        return p();
      }, get replaceLiquid() {
        return e(z);
      } });
    };
    j(Te, (Ce) => {
      i().highlights && Ce(pe);
    });
    var de = E(Te, 2), $e = (Ce) => {
      var tt = O_(), ft = P(tt);
      {
        let gt = g(() => e(ue) || e(q)[0]);
        Xr(ft, { get sellingPlans() {
          return e(q);
        }, get selectedSellingPlan() {
          return e(gt);
        }, onChange: (Qe) => {
          te(T, Qe, !0);
        } });
      }
      w(tt), v(Ce, tt);
    };
    j(de, (Ce) => {
      p() && e(W) && !i().sellingPlanGid && e(q).length > 1 && Ce($e);
    });
    var je = E(de, 2), st = (Ce) => {
      var tt = F_(), ft = P(tt);
      Vr(ft, { get product() {
        return e(J);
      } });
      var gt = E(ft, 2), Qe = P(gt);
      {
        let zt = g(() => e(Z) || 0);
        Mn(Qe, { get product() {
          return e(J);
        }, get selectedVariantId() {
          return e(zt);
        }, get showImage() {
          return e(ze);
        }, onChange: ie });
      }
      var at = E(Qe, 2), Ze = (zt) => {
        {
          let en = g(() => {
            var tn, _t;
            return (_t = (tn = e($)) == null ? void 0 : tn.inventoryQuantity) != null ? _t : null;
          });
          Gr(zt, { get lowStockAlert() {
            return s().lowStockAlert;
          }, get inventoryQuantity() {
            return e(en);
          } });
        }
      };
      j(at, (zt) => {
        s().lowStockAlertEnabled && s().lowStockAlert && zt(Ze);
      }), w(gt), w(tt), v(Ce, tt);
    };
    j(je, (Ce) => {
      e(fe) && e(J) && Ce(st);
    });
    var pt = E(je, 2), ot = (Ce) => {
      {
        let tt = g(() => [e(Z)]);
        Pa(Ce, { get productPersonalisation() {
          return i().productPersonalisation;
        }, get product() {
          return e(J);
        }, get selectedVariantIds() {
          return e(tt);
        }, quantity: 1, get addPersonalisationModal() {
          return s().addPersonalisationModal;
        }, get onPersonalisationsChange() {
          return A();
        }, get initialValues() {
          return V();
        } });
      }
    };
    j(pt, (Ce) => {
      p() && i().productPersonalisation && e(J) && e(Z) && (s().blockLayout === "vertical" || s().blockLayout === "plain") && Ce(ot);
    }), w(ne);
    var Ne = E(ne, 2);
    {
      let Ce = g(() => i().upsells || []);
      Ha(Ne, { get dealBlock() {
        return s();
      }, get upsells() {
        return e(Ce);
      }, get otherProducts() {
        return o();
      }, get complementaryProducts() {
        return d();
      }, get dealBarSelected() {
        return p();
      }, get dealSellingPlan() {
        return e(Q);
      }, onChange: (tt) => {
        te(X, tt, !0);
      } });
    }
    var it = E(Ne, 2);
    Ya(it, { get selectedDealBarIndex() {
      return h();
    }, get onChange() {
      return I();
    }, get dealBlock() {
      return s();
    }, get dealBar() {
      return i();
    }, get selected() {
      return p();
    }, get otherProducts() {
      return o();
    }, get progressiveGifts() {
      return s().progressiveGifts;
    } });
    var Et = E(it, 2);
    {
      let Ce = g(() => i().freeGifts || []);
      Ua(Et, { get dealBlock() {
        return s();
      }, get freeGifts() {
        return e(Ce);
      }, get otherProducts() {
        return o();
      }, get dealBarSelected() {
        return p();
      }, get sellingPlan() {
        return e(Q);
      }, onChange: (tt) => {
        te(F, tt, !0);
      } });
    }
    var Pt = E(Et, 2);
    {
      let Ce = g(() => i().multipleGiftsSelectors || []);
      Ja(Pt, { get dealBlock() {
        return s();
      }, get multipleGiftsSelectors() {
        return e(Ce);
      }, get sellingPlan() {
        return e(Q);
      }, get otherProducts() {
        return o();
      }, onChange: (tt) => {
        te(se, tt, !0);
      } });
    }
    w(Se);
    var Ft = E(Se, 2), Dt = (Ce) => {
      Za(Ce, { get showAsSoldOut() {
        return i().showAsSoldOut;
      }, get replaceLiquid() {
        return e(z);
      } });
    };
    j(Ft, (Ce) => {
      i().showAsSoldOutEnabled && i().showAsSoldOut && Ce(Dt);
    }), w(we), be((Ce, tt) => {
      var ft;
      _e = Ot(we, 1, "kaching-bundles__bar", null, _e, Ce), Pe(we, "data-deal-bar-id", i().id), Wt(we, e(ce)), Pe(ye, "name", `kaching-bundles-deal-${(ft = f()) != null ? ft : ""}`), va(ye, i().id), Pe(ye, "id", e(ee)), Pi(ye, p()), ye.disabled = i().showAsSoldOutEnabled, Pe(Se, "for", e(ee)), Ve = Ot(Se, 1, "kaching-bundles__bar-container", null, Ve, tt);
    }, [() => ({ "kaching-bundles__bar--selected": p() }), () => ({ "kaching-bundles__bar-container--sold-out": i().showAsSoldOutEnabled })]), v(n, we);
    var Lt = Ye(ke);
    return u(), Lt;
  }
  Pn(["change"]), We(Xu, { dealBlock: {}, dealBar: {}, otherProducts: {}, complementaryProducts: {}, selectedDealBarIndex: {}, componentId: {}, selected: {}, globalSellingPlan: {}, onProgressiveGiftsChange: {}, onDealBarSelect: {}, onDealBarDeselect: {}, onVariantsChange: {}, onPersonalisationsChange: {}, personalisationInitialValues: {} }, [], [], !0);
  var E_ = D('<div class="kaching-bundles__collection-breaks-alert"><svg class="kaching-bundles__collection-breaks-alert__icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.00065 5.33325V7.99992M8.00065 10.6666H8.00732M14.6673 7.99992C14.6673 11.6818 11.6825 14.6666 8.00065 14.6666C4.31875 14.6666 1.33398 11.6818 1.33398 7.99992C1.33398 4.31802 4.31875 1.33325 8.00065 1.33325C11.6825 1.33325 14.6673 4.31802 14.6673 7.99992Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg> </div>');
  function ed(n, t) {
    Je(t, !0);
    const r = () => Me(i, "$config", a), [a, l] = wt();
    let c = m(t, "collectionBreaks", 7), u = m(t, "hasItemsToSelect", 7);
    const s = qt(), i = on(), o = g(() => {
      var x;
      return (x = c()) == null ? void 0 : x.requireItemSelectionAlert;
    }), d = g(() => r().preview && r().previewAlerts || Me(Vs, "$requireSelectionError", a)), h = g(() => {
      var x;
      return e(d) && ((x = c()) == null ? void 0 : x.requireItemSelectionEnabled) && e(o) && u();
    });
    var f = { get collectionBreaks() {
      return c();
    }, set collectionBreaks(x) {
      c(x), k();
    }, get hasItemsToSelect() {
      return u();
    }, set hasItemsToSelect(x) {
      u(x), k();
    } }, p = De(), _ = ve(p), I = (x) => {
      var M = E_(), A = E(P(M));
      w(M), be((V) => mt(A, ` ${V != null ? V : ""}`), [() => Me(s, "$translate", a)(e(o).text)]), v(x, M);
    };
    j(_, (x) => {
      e(h) && e(o) && x(I);
    }), v(n, p);
    var y = Ye(f);
    return l(), y;
  }
  We(ed, { collectionBreaks: {}, hasItemsToSelect: {} }, [], [], !0);
  var j_ = D('<div class="kaching-bundles__block-title"><!></div>'), R_ = D("<!> <!>", 1), Q_ = D('<div class="kaching-bundles__out-of-stock"><!></div>'), N_ = D('<div class="kaching-bundles"><div><!> <!> <div></div> <!> <!> <!> <!> <!> <!></div></div> <!>', 1);
  function td(n, t) {
    var r, a, l, c;
    Je(t, !0);
    const u = () => Me(Z, "$formatPrice", i), s = () => Me(S, "$translate", i), [i, o] = wt();
    let d = m(t, "component", 7), h = m(t, "config", 7), f = m(t, "translations", 23, () => ({})), p = m(t, "dealBlock", 7), _ = m(t, "product", 7), I = m(t, "currentVariantId", 7), y = m(t, "sellingPlanId", 15), x = m(t, "selectedDealBarId", 15), M = m(t, "quantity", 15), A = m(t, "mediaImages", 23, () => []), V = m(t, "otherProducts", 23, () => []), C = m(t, "collectionBreaksProducts", 23, () => []), R = m(t, "complementaryProducts", 23, () => []), U = m(t, "nativeBundleProductIds", 23, () => []), F = m(t, "compact", 7, !1);
    const se = g(() => p().hideUnavailableOptions ? Xn(_()) : _()), X = g(() => p().hideUnavailableOptions ? V().map(Xn) : V()), K = g(() => p().hideUnavailableOptions ? R().map(Xn) : R()), J = g(() => p().hideUnavailableOptions ? C().map(Xn) : C()), { setConfig: N } = xa(h()), { formatPrice: Z, setMoneyFormat: $ } = Na(h().moneyFormat, (r = p()) == null ? void 0 : r.showPricesWithoutDecimals), { translate: S, setTranslations: T } = ya(f()), { setMediaImages: q } = Bi(A()), { setSwatchSettings: W } = Ii({ swatchOptions: ((a = p()) == null ? void 0 : a.swatchOptions) || [], swatchSize: (l = p()) == null ? void 0 : l.swatchSize, swatchShape: (c = p()) == null ? void 0 : c.swatchShape });
    let ue = Ae(rt(Math.random()));
    function Q() {
      return { dealBlock: p(), product: e(Lt), selectedDealBarId: x(), selectedVariantQuantities: e(z), selectedBundleProducts: e(H), selectedCollectionBreaksProducts: e(Y), selectedFreeGifts: e(L), selectedProgressiveGifts: e(O), selectedCheckboxUpsells: e(ae), selectedUpsells: e(ee), selectedPersonalisations: e(le), selectedSellingPlan: e(tt), dealBarSellingPlan: e(fe), nativeBundleProductIds: U(), bundleNonce: e(ue), splitBxgy: h().featureFlags.split_bxgy_items };
    }
    function b() {
      return Hu(Q());
    }
    ba(() => {
      gr(d(), "kaching-bundles-block-loaded", { component: d() }, !1);
    }), He(() => {
      N(h());
    }), He(() => {
      $(h().moneyFormat, !!p().showPricesWithoutDecimals);
    }), He(() => {
      T(f());
    }), He(() => {
      q(A());
    }), He(() => {
      W({ swatchOptions: p().swatchOptions || [], swatchSize: p().swatchSize, swatchShape: p().swatchShape });
    });
    let B = 0;
    He(() => {
      B === 0 && U().length > 0 && Dt({ pricing: e(we) }), B = U().length;
    });
    let G = Math.random().toString(16).slice(2), z = Ae(rt([])), H = Ae(rt([])), Y = Ae(rt([])), L = Ae(rt([])), O = Ae(rt([])), ae = Ae(rt([])), ee = Ae(rt([])), le = Ae(rt([])), re = new Rf(), fe = Ae(void 0), ze = Ae(rt({ discountedPrice: 0, fullPrice: 0, discountedPriceWithoutSellingPlan: 0, discountedPricesForSellingPlans: [] })), ce = Ae(void 0), ie = Ae(!1), ke = Ae(rt({ requiresItemSelection: !1, allItemsSelected: !0, missingItemsCount: 0 })), we = Ae(rt({ discountedPrice: 0, fullPrice: 0, discountedPricePerItem: 0, fullPricePerItem: 0, discountedPriceWithoutSellingPlan: 0, discountedPricesForSellingPlans: [] }));
    He(() => {
      I() && !x() && (e(tt), Xt(() => {
        (function() {
          const oe = _().variants.find((nt) => nt.id === I());
          if (!oe) return;
          te(z, [{ variant: oe, quantity: 1 }], !0);
          let Ge = oe.price;
          if (e(tt)) {
            const nt = oe.sellingPlans.find((yt) => yt.id === e(tt).id);
            nt && (Ge = nt.price);
          }
          const Le = oe.compareAtPrice && oe.compareAtPrice > oe.price ? oe.compareAtPrice : oe.price, Be = _().sellingPlans.map((nt) => ({ sellingPlanId: nt.id, discountedPrice: Mi(oe, nt) }));
          te(we, { discountedPrice: Ge, fullPrice: Le, discountedPricePerItem: Ge, fullPricePerItem: Le, discountedPriceWithoutSellingPlan: oe.price, discountedPricesForSellingPlans: Be }, !0), Dt({ pricing: e(we) });
        })();
      }));
    });
    let _e = g(() => $c(p())), ye = g(() => s()(p().blockTitle));
    const Se = p().preselectedDealBarId ? p().dealBars.find((oe) => oe.id === p().preselectedDealBarId) : void 0;
    function Ve(oe) {
      return !oe.dealBarType || oe.dealBarType === "quantity-break" || oe.dealBarType === "bxgy";
    }
    function Ee(oe) {
      switch (oe.dealBarType) {
        case void 0:
        case "quantity-break":
          return Number(oe.quantity);
        case "bxgy":
          return Number(oe.buyQuantity) + Number(oe.getQuantity);
        case "bundle":
          return oe.bundleProducts[0].quantity;
        case "mix-and-match":
        case "sku":
          return 1;
      }
    }
    function ne(oe) {
      var Ge, Le;
      x() !== oe && (x() && re.set(x(), e(le)), te(le, (Ge = re.get(oe)) != null ? Ge : [], !0), ((Le = p().progressiveGifts) == null ? void 0 : Le.layout) === "deal-bar" && te(O, [], !0)), x(oe);
    }
    function ge(oe) {
      const { dealBarId: Ge, dealBarQuantity: Le, preselected: Be } = oe;
      ne(Ge), Vi(!1), h().keepQuantityInput && Le && M(Le), gr(d(), "deal-bar-selected", { dealBarId: Ge, preselected: Be });
    }
    function Te(oe) {
      const Ge = p().dealBars[oe];
      Ge && ne(Ge.id);
    }
    function pe() {
      h().ignoreDeselect || (x(void 0), te(L, [], !0), te(O, [], !0), te(ee, [], !0), te(H, [], !0), te(Y, [], !0), te(le, [], !0), re.clear(), te(fe, void 0), Vi(!1), gr(d(), "deal-bar-selected", { dealBarId: null, preselected: !1 }));
    }
    function de(oe) {
      const { variantId: Ge } = oe;
      gr(d(), "variant-selected", { variantId: Ge });
    }
    function $e(oe) {
      const { bundleProducts: Ge, freeGifts: Le, upsells: Be, pricing: nt } = oe, yt = [{ variant: Ge[0].variant, quantity: Ge[0].quantity }];
      te(z, yt, !0), te(H, Ge.slice(1), !0), te(L, Le, !0), te(ee, Be, !0), te(Y, [], !0), te(fe, void 0), te(ce, void 0), te(we, nt, !0), te(ie, Ft(e(z)), !0), Dt({ pricing: nt });
    }
    function je(oe) {
      const { variants: Ge, freeGifts: Le, upsells: Be, pricing: nt, validation: yt } = oe;
      te(ke, yt, !0);
      const Ct = [{ variant: Ge[0].variant, quantity: Ge[0].quantity }], Ht = Ge.slice(1);
      te(z, Ct, !0), te(L, Le, !0), te(ee, Be, !0), te(H, [], !0), te(Y, Ht, !0), te(fe, oe.dealBarSellingPlan, !0), te(ce, void 0), te(we, nt, !0), te(ie, Ft(e(z)), !0), Dt({ pricing: nt });
    }
    function st(oe) {
      const { variants: Ge, freeGifts: Le, upsells: Be, pricing: nt } = oe;
      te(z, Ge, !0), te(L, Le, !0), te(ee, Be, !0), te(H, [], !0), te(Y, [], !0), te(fe, oe.dealBarSellingPlan, !0), te(ce, void 0), te(we, nt, !0), te(ie, Ft(e(z)), !0), Dt({ pricing: nt });
    }
    function pt(oe) {
      var Ge;
      const { variants: Le, freeGifts: Be, upsells: nt, pricing: yt, product: Ct } = oe;
      te(z, Le, !0), te(L, Be, !0), te(ee, nt, !0), te(H, [], !0), te(Y, [], !0), te(fe, oe.dealBarSellingPlan, !0), ((Ge = e(ce)) == null ? void 0 : Ge.id) !== (Ct == null ? void 0 : Ct.id) && te(ce, Ct, !0), te(we, yt, !0), te(ie, Ft(e(z)), !0), Dt({ pricing: yt });
    }
    function ot(oe) {
      y(oe == null ? void 0 : oe.id);
    }
    function Ne(oe) {
      gr(d(), "add-to-cart-requested", { items: Hu({ ...Q(), selectedSellingPlan: oe, dealBarSellingPlan: void 0 }) });
    }
    function it(oe) {
      te(O, oe, !0), Dt({ pricing: e(we) });
    }
    function Et(oe, Ge) {
      te(ae, oe, !0), te(ze, Ge, !0), Dt({ pricing: e(we) });
    }
    function Pt(oe) {
      te(le, oe, !0), Dt({ pricing: e(we) });
    }
    function Ft(oe) {
      return oe.some(({ variant: Ge, quantity: Le }) => !!Ge && !!Ge.inventoryManagement && Ge.inventoryPolicy === "deny" && Ge.inventoryQuantity !== null && Le > Ge.inventoryQuantity);
    }
    function Dt({ pricing: oe }) {
      const Ge = e(z).map(({ variant: lt, quantity: ht }) => ({ variantId: lt.id, quantity: ht })), Le = e(L).map(({ id: lt, variant: ht, quantity: Yt }) => ({ id: lt, variantId: ht.id, quantity: Yt })), Be = e(ee).map(({ id: lt, variant: ht, quantity: Yt }) => ({ id: lt, variantId: ht.id, quantity: Yt })), nt = e(H).map(({ id: lt, variant: ht, quantity: Yt }) => ({ id: lt, variantId: ht.id, quantity: Yt })), yt = oe.discountedPrice + e(ze).discountedPrice, Ct = oe.fullPrice + e(ze).fullPrice, Ht = { discountedPrice: yt, fullPrice: Ct, discountedPriceWithoutSellingPlan: oe.discountedPriceWithoutSellingPlan + e(ze).discountedPriceWithoutSellingPlan, discountedPricesForSellingPlans: oe.discountedPricesForSellingPlans.map((lt) => {
        var ht, Yt;
        const gn = (Yt = (ht = e(ze).discountedPricesForSellingPlans.find((Tn) => Tn.sellingPlanId === lt.sellingPlanId)) == null ? void 0 : ht.discountedPrice) != null ? Yt : e(ze).discountedPriceWithoutSellingPlan;
        return { sellingPlanId: lt.sellingPlanId, discountedPrice: lt.discountedPrice + gn };
      }) };
      x() && e(Bt) ? Ka.set({ id: x(), dealBar: e(Bt), product: e(Lt), quantity: e(z).reduce((lt, { quantity: ht }) => lt + ht, 0), pricing: Ht }) : Ka.set({ id: null, dealBar: null, product: e(Lt), quantity: 1, pricing: Ht }), gr(d(), "variants-changed", { variantIdQuantities: Ge, freeGifts: Le, upsells: Be, bundleProducts: nt, pricing: { discountedPrice: { amount: yt, formatted: u()(yt) }, fullPrice: { amount: Ct, formatted: u()(Ct) }, discountedPricePerItem: { amount: oe.discountedPricePerItem, formatted: u()(oe.discountedPricePerItem) }, fullPricePerItem: { amount: oe.fullPricePerItem, formatted: u()(oe.fullPricePerItem) } }, formattedPrice: u()(oe.discountedPrice), validation: e(ke) }), gr(d(), "items-changed", {});
    }
    Se != null && Se.hideBehindScratchOff && p().scratchOffEnabled && (h().preview ? h().previewScratchOff : _().availableForSale) || x(x() || p().preselectedDealBarId || void 0), He(() => {
      M() && p() && Xt(() => {
        if (!x()) return;
        const oe = p().dealBars.find((Ge) => Ge.id === x());
        oe && Ve(oe) && Ee(oe) !== M() && (function(Ge, Le) {
          if (!x()) return;
          const Be = Ge.dealBars.slice().sort((yt, Ct) => Ee(yt) - Ee(Ct));
          let nt = Be[0];
          for (const yt of Be) if (Ve(yt)) {
            if (Ee(yt) > Le) break;
            nt = yt;
          }
          ne(nt.id);
        })(p(), M());
      });
    });
    const Lt = g(() => e(ce) || _()), Ce = g(() => {
      const oe = e(z).map(({ variant: Ge }) => Ge);
      return e(Lt).sellingPlans.filter((Ge) => oe.some((Le) => Le.sellingPlans.some((Be) => Be.id === Ge.id)));
    }), tt = g(() => e(Ce).find((oe) => oe.id === y())), ft = g(() => y() ? e(Lt).sellingPlans.find((oe) => oe.id === y()) : void 0), gt = g(() => ys(e(fe), e(ft), e(Ce), e(Lt).requiresSellingPlan));
    let Qe = g(() => p().subscriptionsEnabled && p().subscriptions && (e(Ce).length > 0 || h().preview)), at = g(() => {
      var oe, Ge;
      return e(Qe) && ((oe = p().subscriptions) == null ? void 0 : oe.showPrices) && ((Ge = p().subscriptions) == null ? void 0 : Ge.hideDealBarPrices);
    }), Ze = g(() => x() ? p().dealBars.findIndex((oe) => oe.id === x()) : null);
    const zt = g(() => p().scratchOffEnabled ? p().scratchOff : null), en = g(() => (p().blockLayout === "vertical" || p().blockLayout === "plain") && (h().preview || _().availableForSale)), tn = g(() => p().dealBars.reduce((oe, Ge) => {
      const Le = e(zt) && e(en) && Ge.hideBehindScratchOff, Be = oe[oe.length - 1];
      return Le && (Be == null ? void 0 : Be.type) === "scratch" ? Be.bars.push(Ge) : Le ? oe.push({ type: "scratch", key: Ge.id, bars: [Ge] }) : oe.push({ type: "visible", key: Ge.id, bar: Ge }), oe;
    }, [])), _t = g(() => e(z).reduce((oe, { quantity: Ge }) => oe + Ge, 0) || 1), Bt = g(() => x() ? p().dealBars.find((oe) => oe.id === x()) : void 0), an = g(() => {
      var oe, Ge;
      return !!((oe = e(Bt)) != null && oe.sellingPlanEnabled) && !!((Ge = e(Bt)) != null && Ge.sellingPlanGid);
    }), un = g(() => {
      var oe;
      return ((oe = e(Bt)) == null ? void 0 : oe.productPersonalisation) && (p().blockLayout === "horizontal" || p().blockLayout === "grid");
    }), yn = g(() => e(Bt) ? e(Bt).dealBarType === void 0 || e(Bt).dealBarType === "quantity-break" ? M() || Number(e(Bt).quantity) || 1 : e(Bt).dealBarType === "bxgy" ? M() || e(Bt).buyQuantity + e(Bt).getQuantity : e(Bt).dealBarType === "bundle" ? 1 : M() || 1 : M() || 1), ln = g(() => e(z).flatMap(({ variant: oe, quantity: Ge }) => Array(Ge).fill(oe.id))), xe = g(() => {
      if (e(le).length === 0) return [];
      const oe = e(le).reduce((Le, Be) => Math.max(Le, Be.productIndex), -1), Ge = Array.from({ length: oe + 1 }, () => "");
      for (const Le of e(le)) Ge[Le.productIndex] = Le.text;
      return Ge;
    });
    var Xe = { rotateBundleNonce: function() {
      te(ue, Math.random(), !0);
    }, selectedVariants: function() {
      return b().map((oe) => ({ variantId: oe.id, quantity: oe.quantity, properties: oe.properties }));
    }, items: b, pricing: function() {
      const oe = e(we).discountedPrice + e(ze).discountedPrice, Ge = e(we).fullPrice + e(ze).fullPrice;
      return { discountedPrice: { amount: oe / 100, formatted: u()(oe) }, fullPrice: { amount: Ge / 100, formatted: u()(Ge) }, discountedPricePerItem: { amount: e(we).discountedPricePerItem / 100, formatted: u()(e(we).discountedPricePerItem) }, fullPricePerItem: { amount: e(we).fullPricePerItem / 100, formatted: u()(e(we).fullPricePerItem) }, discountedPriceWithoutSellingPlan: { amount: (e(we).discountedPriceWithoutSellingPlan + e(ze).discountedPriceWithoutSellingPlan) / 100, formatted: u()(e(we).discountedPriceWithoutSellingPlan + e(ze).discountedPriceWithoutSellingPlan) }, discountedPricesForSellingPlans: e(we).discountedPricesForSellingPlans.map((Le) => {
        var Be, nt;
        const yt = (nt = (Be = e(ze).discountedPricesForSellingPlans.find((Ht) => Ht.sellingPlanId === Le.sellingPlanId)) == null ? void 0 : Be.discountedPrice) != null ? nt : e(ze).discountedPriceWithoutSellingPlan, Ct = Le.discountedPrice + yt;
        return { sellingPlanId: Le.sellingPlanId, amount: Ct / 100, formatted: u()(Ct) };
      }) };
    }, deal: function() {
      return { subscriptionsEnabled: p().subscriptionsEnabled || p().dealBars.some((oe) => oe.sellingPlanEnabled) };
    }, isItemSelectionValid: function() {
      const { requiresItemSelection: oe, allItemsSelected: Ge } = e(ke);
      return !oe || Ge;
    }, validateItemSelection: function() {
      var oe, Ge;
      const { requiresItemSelection: Le, allItemsSelected: Be } = e(ke);
      return Le && !Be ? (Vi(!0), { valid: !1, message: ((Ge = (oe = p().collectionBreaks) == null ? void 0 : oe.requireItemSelectionAlert) == null ? void 0 : Ge.text) || null }) : (Vi(!1), { valid: !0, message: null });
    }, get component() {
      return d();
    }, set component(oe) {
      d(oe), k();
    }, get config() {
      return h();
    }, set config(oe) {
      h(oe), k();
    }, get translations() {
      return f();
    }, set translations(oe = {}) {
      f(oe), k();
    }, get dealBlock() {
      return p();
    }, set dealBlock(oe) {
      p(oe), k();
    }, get product() {
      return _();
    }, set product(oe) {
      _(oe), k();
    }, get currentVariantId() {
      return I();
    }, set currentVariantId(oe) {
      I(oe), k();
    }, get sellingPlanId() {
      return y();
    }, set sellingPlanId(oe) {
      y(oe), k();
    }, get selectedDealBarId() {
      return x();
    }, set selectedDealBarId(oe) {
      x(oe), k();
    }, get quantity() {
      return M();
    }, set quantity(oe) {
      M(oe), k();
    }, get mediaImages() {
      return A();
    }, set mediaImages(oe = []) {
      A(oe), k();
    }, get otherProducts() {
      return V();
    }, set otherProducts(oe = []) {
      V(oe), k();
    }, get collectionBreaksProducts() {
      return C();
    }, set collectionBreaksProducts(oe = []) {
      C(oe), k();
    }, get complementaryProducts() {
      return R();
    }, set complementaryProducts(oe = []) {
      R(oe), k();
    }, get nativeBundleProductIds() {
      return U();
    }, set nativeBundleProductIds(oe = []) {
      U(oe), k();
    }, get compact() {
      return F();
    }, set compact(oe = !1) {
      F(oe), k();
    } }, ut = N_(), he = ve(ut), Oe = P(he);
    let Ie;
    {
      const oe = (Le, Be = jr) => {
        var nt = De(), yt = ve(nt), Ct = (lt) => {
          {
            let ht = g(() => Be().id === x()), Yt = g(() => Be().id === x() ? e(xe) : []);
            $u(lt, { get selectedDealBarIndex() {
              return e(Ze);
            }, get dealBlock() {
              return p();
            }, get dealBar() {
              return Be();
            }, get product() {
              return e(se);
            }, get otherProducts() {
              return e(X);
            }, get complementaryProducts() {
              return e(K);
            }, get selected() {
              return e(ht);
            }, get currentVariantId() {
              return I();
            }, get componentId() {
              return G;
            }, get sellingPlan() {
              return e(ft);
            }, onProgressiveGiftsChange: it, onDealBarSelect: ge, onDealBarDeselect: pe, onVariantSelect: de, onVariantsChange: $e, onPersonalisationsChange: Pt, get personalisationInitialValues() {
              return e(Yt);
            } });
          }
        }, Ht = (lt) => {
          var ht = De(), Yt = ve(ht), gn = (ta) => {
            {
              let Cl = g(() => Be().id === x()), Ls = g(() => Be().id === x() ? e(xe) : []);
              Iu(ta, { get selectedDealBarIndex() {
                return e(Ze);
              }, get dealBlock() {
                return p();
              }, get dealBar() {
                return Be();
              }, get product() {
                return e(se);
              }, get otherProducts() {
                return e(X);
              }, get complementaryProducts() {
                return e(K);
              }, get selected() {
                return e(Cl);
              }, get currentVariantId() {
                return I();
              }, get componentId() {
                return G;
              }, get sellingPlan() {
                return e(ft);
              }, onProgressiveGiftsChange: it, onDealBarSelect: ge, onDealBarDeselect: pe, onVariantSelect: de, onVariantsChange: $e, onPersonalisationsChange: Pt, get personalisationInitialValues() {
                return e(Ls);
              } });
            }
          }, Tn = (ta) => {
            var Cl = De(), Ls = ve(Cl), d0 = (ei) => {
              {
                let Bl = g(() => Be().id === x()), Es = g(() => Be().id === x() ? e(xe) : []);
                Xu(ei, { get dealBlock() {
                  return p();
                }, get dealBar() {
                  return Be();
                }, get selectedDealBarIndex() {
                  return e(Ze);
                }, get otherProducts() {
                  return e(X);
                }, get complementaryProducts() {
                  return e(K);
                }, get componentId() {
                  return G;
                }, get selected() {
                  return e(Bl);
                }, get globalSellingPlan() {
                  return e(ft);
                }, onProgressiveGiftsChange: it, onDealBarSelect: ge, onDealBarDeselect: pe, onVariantsChange: pt, onPersonalisationsChange: Pt, get personalisationInitialValues() {
                  return e(Es);
                } });
              }
            }, g0 = (ei) => {
              var Bl = De(), Es = ve(Bl), h0 = (ti) => {
                {
                  let js = g(() => Be().id === x() ? M() && Number(M()) : void 0), Rs = g(() => Be().id === x()), Qs = g(() => Be().id === x() ? e(xe) : []);
                  Vu(ti, { get dealBlock() {
                    return p();
                  }, get dealBar() {
                    return Be();
                  }, get selectedDealBarIndex() {
                    return e(Ze);
                  }, get product() {
                    return e(se);
                  }, get collectionBreaksProducts() {
                    return e(J);
                  }, get otherProducts() {
                    return e(X);
                  }, get complementaryProducts() {
                    return e(K);
                  }, get customQuantity() {
                    return e(js);
                  }, get selected() {
                    return e(Rs);
                  }, onProgressiveGiftsChange: it, get currentVariantId() {
                    return I();
                  }, get componentId() {
                    return G;
                  }, get globalSellingPlan() {
                    return e(ft);
                  }, onDealBarSelect: ge, onDealBarDeselect: pe, onVariantSelect: de, onVariantsChange: je, onPersonalisationsChange: Pt, get personalisationInitialValues() {
                    return e(Qs);
                  } });
                }
              }, p0 = (ti) => {
                {
                  let js = g(() => Be().id === x() ? M() && Number(M()) : void 0), Rs = g(() => Be().id === x()), Qs = g(() => Be().id === x() ? e(xe) : []);
                  Bs(ti, { get selectedDealBarIndex() {
                    return e(Ze);
                  }, get dealBlock() {
                    return p();
                  }, get dealBar() {
                    return Be();
                  }, get product() {
                    return e(se);
                  }, get otherProducts() {
                    return e(X);
                  }, get complementaryProducts() {
                    return e(K);
                  }, get customQuantity() {
                    return e(js);
                  }, get selected() {
                    return e(Rs);
                  }, get currentVariantId() {
                    return I();
                  }, get componentId() {
                    return G;
                  }, get globalSellingPlan() {
                    return e(ft);
                  }, onProgressiveGiftsChange: it, onDealBarSelect: ge, onDealBarDeselect: pe, onVariantSelect: de, onVariantsChange: st, onPersonalisationsChange: Pt, get personalisationInitialValues() {
                    return e(Qs);
                  } });
                }
              };
              j(Es, (ti) => {
                !p().collectionBreaksEnabled || !p().collectionBreaks || Be().dealBarType && Be().dealBarType !== "quantity-break" && Be().dealBarType !== "bxgy" ? ti(p0, !1) : ti(h0);
              }, !0), v(ei, Bl);
            };
            j(Ls, (ei) => {
              Be().dealBarType === "sku" ? ei(d0) : ei(g0, !1);
            }, !0), v(ta, Cl);
          };
          j(Yt, (ta) => {
            Be().dealBarType === "bundle" ? ta(gn) : ta(Tn, !1);
          }, !0), v(lt, ht);
        };
        j(yt, (lt) => {
          Be().dealBarType === "mix-and-match" ? lt(Ct) : lt(Ht, !1);
        }), v(Le, nt);
      };
      var Fe = P(Oe), Ue = (Le) => {
        var Be = R_(), nt = ve(Be), yt = (lt) => {
          var ht = j_();
          qe(P(ht), () => e(ye)), w(ht), v(lt, ht);
        };
        j(nt, (lt) => {
          e(ye) && lt(yt);
        });
        var Ct = E(nt, 2), Ht = (lt) => {
          Wu(lt, { get timer() {
            return p().timer;
          } });
        };
        j(Ct, (lt) => {
          p().timerEnabled && p().timer && lt(Ht);
        }), v(Le, Be);
      };
      j(Fe, (Le) => {
        F() || Le(Ue);
      });
      var ct = E(Fe, 2), jt = (Le) => {
        Fs(Le, { get subscriptions() {
          return p().subscriptions;
        }, get sellingPlans() {
          return e(Ce);
        }, get selectedSellingPlan() {
          return e(tt);
        }, get hideSellingPlanSelector() {
          return e(an);
        }, onChange: ot, onRequestAddToCart: Ne });
      };
      j(ct, (Le) => {
        var Be;
        e(Qe) && ((Be = p().subscriptions) == null ? void 0 : Be.position) === "above" && Le(jt);
      });
      var Vt = E(ct, 2);
      let Ge;
      Jt(Vt, 21, () => e(tn), (Le) => Le.key, (Le, Be) => {
        var nt = De(), yt = ve(nt), Ct = (lt) => {
          Gu(lt, { get settings() {
            return e(zt);
          }, onReveal: () => {
            return ht = e(Be).bars, void (!x() && Se && ht.includes(Se) && ge({ dealBarId: Se.id, dealBarQuantity: Ee(Se), preselected: !0 }));
            var ht;
          }, children: (ht, Yt) => {
            var gn = De();
            Jt(ve(gn), 17, () => e(Be).bars, (Tn) => Tn.id, (Tn, ta) => {
              oe(Tn, () => e(ta));
            }), v(ht, gn);
          }, $$slots: { default: !0 } });
        }, Ht = (lt) => {
          var ht = De(), Yt = ve(ht), gn = (Tn) => {
            oe(Tn, () => e(Be).bar);
          };
          j(Yt, (Tn) => {
            e(Be).type === "visible" && Tn(gn);
          }, !0), v(lt, ht);
        };
        j(yt, (lt) => {
          e(Be).type === "scratch" && e(zt) ? lt(Ct) : lt(Ht, !1);
        }), v(Le, nt);
      }), w(Vt);
      var vt = E(Vt, 2), St = (Le) => {
        Pa(Le, { get product() {
          return e(Lt);
        }, get productPersonalisation() {
          return e(Bt).productPersonalisation;
        }, get selectedVariantIds() {
          return e(ln);
        }, get quantity() {
          return e(yn);
        }, get addPersonalisationModal() {
          return p().addPersonalisationModal;
        }, onPersonalisationsChange: Pt, get initialValues() {
          return e(xe);
        } });
      };
      j(vt, (Le) => {
        var Be;
        e(un) && ((Be = e(Bt)) != null && Be.productPersonalisation) && Le(St);
      });
      var Rt = E(vt, 2), At = (Le) => {
        Fs(Le, { get subscriptions() {
          return p().subscriptions;
        }, get sellingPlans() {
          return e(Ce);
        }, get selectedSellingPlan() {
          return e(tt);
        }, get hideSellingPlanSelector() {
          return e(an);
        }, onChange: ot, onRequestAddToCart: Ne });
      };
      j(Rt, (Le) => {
        var Be;
        e(Qe) && ((Be = p().subscriptions) == null ? void 0 : Be.position) === "below" && Le(At);
      });
      var Zt = E(Rt, 2), dn = (Le) => {
        var Be = Q_();
        qe(P(Be), () => s()("system.out_of_stock")), w(Be), v(Le, Be);
      };
      j(Zt, (Le) => {
        e(ie) && (e(z).length > 1 || e(z)[0].quantity > 1) && Le(dn);
      });
      var Sn = E(Zt, 2), Dn = (Le) => {
        Nu(Le, { get checkboxUpsells() {
          return p().checkboxUpsells;
        }, get dealBlock() {
          return p();
        }, get otherProducts() {
          return e(X);
        }, get complementaryProducts() {
          return e(K);
        }, get dealSellingPlan() {
          return e(gt);
        }, get dealBarQuantity() {
          return e(_t);
        }, onChange: Et });
      };
      j(Sn, (Le) => {
        !F() && p().checkboxUpsellsEnabled && p().checkboxUpsells && Le(Dn);
      });
      var Ln = E(Sn, 2), vn = (Le) => {
        Ru(Le, { get progressiveGifts() {
          return p().progressiveGifts;
        }, get dealBlock() {
          return p();
        }, get otherProducts() {
          return e(X);
        }, get selectedDealBarIndex() {
          return e(Ze);
        }, onChange: it, onUnlock: Te });
      };
      j(Ln, (Le) => {
        p().progressiveGiftsEnabled && p().progressiveGifts && p().progressiveGifts.layout !== "deal-bar" && Le(vn);
      });
      var et = E(Ln, 2), bt = (Le) => {
        {
          let Be = g(() => e(ke).missingItemsCount > 0);
          ed(Le, { get collectionBreaks() {
            return p().collectionBreaks;
          }, get hasItemsToSelect() {
            return e(Be);
          } });
        }
      };
      j(et, (Le) => {
        p().collectionBreaksEnabled && Le(bt);
      }), w(Oe), be((Le, Be, nt) => Ge = Ot(Vt, 1, "kaching-bundles__bars", null, Ge, nt), [() => ({ "kaching-bundles__block--horizontal": p().blockLayout === "horizontal", "kaching-bundles__block--grid": p().blockLayout === "grid", "kaching-bundles__block--plain": p().blockLayout === "plain" }), () => p().abTestVariantNumber ? vs(p().abTestVariantNumber) : void 0, () => ({ "kaching-bundles__bars--horizontal": p().blockLayout === "horizontal", "kaching-bundles__bars--grid": p().blockLayout === "grid", "kaching-bundles__bars--plain": p().blockLayout === "plain", "kaching-bundles__bars--hide-prices": e(at) })]);
    }
    w(he);
    var Ut = E(he, 2), kt = (oe) => {
      Uu(oe, { get shopCustomStyles() {
        return h().shopCustomStyles;
      }, get customStyles() {
        return p().customStyles;
      }, get dealBlockId() {
        return p().id;
      } });
    };
    j(Ut, (oe) => {
      p().customStylesEnabled && oe(kt);
    }), be((oe, Ge, Le) => {
      var Be;
      Ie = Ot(Oe, 1, "kaching-bundles__block kaching-bundles__block--loaded", null, Ie, oe), Pe(Oe, "data-deal-block-id", p().id), Pe(Oe, "data-ab-test-variant-id", p().abTestVariantId), Pe(Oe, "data-ab-test-variant", Ge), Pe(Oe, "data-selling-plan-id", (Be = e(gt)) == null ? void 0 : Be.id), Wt(Oe, e(_e));
    }, [() => ({ "kaching-bundles__block--horizontal": p().blockLayout === "horizontal", "kaching-bundles__block--grid": p().blockLayout === "grid", "kaching-bundles__block--plain": p().blockLayout === "plain" }), () => p().abTestVariantNumber ? vs(p().abTestVariantNumber) : void 0, () => ({ "kaching-bundles__bars--horizontal": p().blockLayout === "horizontal", "kaching-bundles__bars--grid": p().blockLayout === "grid", "kaching-bundles__bars--plain": p().blockLayout === "plain", "kaching-bundles__bars--hide-prices": e(at) })]), v(n, ut);
    var _n = Ye(Xe);
    return o(), _n;
  }
  customElements.define("kaching-bundles-block", We(td, { config: { attribute: "config", type: "Object" }, translations: { attribute: "translations", type: "Object" }, dealBlock: { attribute: "deal-block", type: "Object" }, product: { attribute: "product", type: "Object" }, otherProducts: { attribute: "other-products", type: "Array" }, collectionBreaksProducts: { attribute: "collection-breaks-products", type: "Array" }, complementaryProducts: { attribute: "complementary-products", type: "Array" }, mediaImages: { attribute: "media-images", type: "Array" }, currentVariantId: { attribute: "current-variant-id", type: "Number" }, sellingPlanId: { attribute: "selling-plan-id", type: "Number" }, selectedDealBarId: { attribute: "selected-deal-bar-id", type: "String" }, quantity: { attribute: "quantity", type: "Number" }, nativeBundleProductIds: { attribute: "native-bundle-product-ids", type: "Array" }, compact: { attribute: "compact", type: "Boolean" }, component: {} }, [], ["rotateBundleNonce", "selectedVariants", "items", "pricing", "deal", "isItemSelectionValid", "validateItemSelection"], !1, (n) => class extends n {
    constructor() {
      super(), fn(this, "component"), this.component = this, this.innerHTML && (gr(this, "kaching-bundles-block-hydrated"), this.innerHTML = "");
    }
  }));
  var W_ = D('<div class="kaching-bundles"><!></div>');
  function nd(n, t) {
    Je(t, !0);
    const r = m(t, "config", 7), a = m(t, "dealBlock", 7), l = m(t, "products", 23, () => []), c = m(t, "mediaImages", 7), u = m(t, "translations", 7), { setConfig: s } = xa(r()), { setMoneyFormat: i } = Na(r().moneyFormat), { setTranslations: o } = ya(u()), { setMediaImages: d } = Bi(c()), { setSwatchSettings: h } = Ii({ swatchOptions: a().swatchOptions || [], swatchSize: a().swatchSize, swatchShape: a().swatchShape });
    He(() => {
      s(r());
    }), He(() => {
      i(r().moneyFormat, !!a().showPricesWithoutDecimals);
    }), He(() => {
      o(u());
    }), He(() => {
      d(c());
    }), He(() => {
      h({ swatchOptions: a().swatchOptions || [], swatchSize: a().swatchSize, swatchShape: a().swatchShape });
    });
    const f = g(() => a().dealBars.find((x) => x.dealBarType === "mix-and-match"));
    var p = { get config() {
      return r();
    }, set config(x) {
      r(x), k();
    }, get dealBlock() {
      return a();
    }, set dealBlock(x) {
      a(x), k();
    }, get products() {
      return l();
    }, set products(x = []) {
      l(x), k();
    }, get mediaImages() {
      return c();
    }, set mediaImages(x) {
      c(x), k();
    }, get translations() {
      return u();
    }, set translations(x) {
      u(x), k();
    } }, _ = W_(), I = P(_), y = (x) => {
      $s(x, { get dealBlock() {
        return a();
      }, get dealBar() {
        return e(f);
      }, get products() {
        return l();
      }, onChoose: () => {
      } });
    };
    return j(I, (x) => {
      e(f) && x(y);
    }), w(_), v(n, _), Ye(p);
  }
  customElements.define("kaching-bundles-mix-and-match-choose-product", We(nd, { config: { attribute: "config", type: "Object" }, dealBlock: { attribute: "deal-block", type: "Object" }, translations: { attribute: "translations", type: "Object" }, products: { attribute: "products", type: "Array" }, mediaImages: { attribute: "media-images", type: "Array" } }, [], [], !1, (n) => class extends n {
    constructor() {
      super(), fn(this, "component"), this.component = this;
    }
  }));
  var U_ = D('<div class="kaching-bundles"><!></div>');
  function rd(n, t) {
    Je(t, !0);
    const r = m(t, "config", 7), a = m(t, "product", 7), l = m(t, "translations", 7), c = m(t, "addPersonalisationModal", 7), { setConfig: u } = xa(r()), { setTranslations: s } = ya(l());
    He(() => {
      u(r()), s(l());
    });
    const i = g(() => {
      var h, f;
      return (f = (h = a()) == null ? void 0 : h.variants) != null && f[0] ? [{ variant: a().variants[0], index: 0 }, { variant: a().variants[0], index: 1 }] : [];
    });
    var o = { get config() {
      return r();
    }, set config(h) {
      r(h), k();
    }, get product() {
      return a();
    }, set product(h) {
      a(h), k();
    }, get translations() {
      return l();
    }, set translations(h) {
      l(h), k();
    }, get addPersonalisationModal() {
      return c();
    }, set addPersonalisationModal(h) {
      c(h), k();
    } }, d = U_();
    return Cs(P(d), { get product() {
      return a();
    }, get selectedVariants() {
      return e(i);
    }, get addPersonalisationModal() {
      return c();
    }, inline: !0, personalisationValues: [], onConfirm: () => {
    }, onClose: () => {
    } }), w(d), v(n, d), Ye(o);
  }
  customElements.define("kaching-bundles-personalisation-modal", We(rd, { config: { attribute: "config", type: "Object" }, product: { attribute: "product", type: "Object" }, translations: { attribute: "translations", type: "Object" }, addPersonalisationModal: { attribute: "add-personalisation-modal", type: "Object" } }, [], [], !1, (n) => class extends n {
    constructor() {
      super(), fn(this, "component"), this.component = this;
    }
  }));
  function H_(n, t) {
    t().dispatchEvent(new CustomEvent("kaching-bundles-sticky-atc-clicked", { bubbles: !0, composed: !0 }));
  }
  var Z_ = D('<img class="kaching-bundles-sticky-atc__image"/>'), J_ = D('<button class="kaching-bundles-sticky-atc__button"><!></button>'), Y_ = D('<div class="kaching-bundles"><div class="kaching-bundles-sticky-atc"><div class="kaching-bundles-sticky-atc__content"><!> <div class="kaching-bundles-sticky-atc__title"><!></div></div> <!></div></div>');
  function ad(n, t) {
    var r;
    Je(t, !0);
    const a = () => Me(Ka, "$selectedDealBarStore", c), l = () => Me(_, "$translate", c), [c, u] = wt(), s = m(t, "component", 7), i = m(t, "config", 7), o = m(t, "stickyAtc", 7), d = m(t, "translations", 7), h = m(t, "product", 7), f = m(t, "dealBlock", 7), { setConfig: p } = xa(i()), { translate: _, setTranslations: I } = ya(d()), { formatPrice: y, setMoneyFormat: x } = Na(i().moneyFormat, (r = f()) == null ? void 0 : r.showPricesWithoutDecimals);
    He(() => {
      p(i());
    }), He(() => {
      var q;
      x(i().moneyFormat, !!((q = f()) != null && q.showPricesWithoutDecimals));
    }), He(() => {
      I(d());
    });
    const M = g(() => ((q) => hn({ "kaching-bundles-sticky-atc-background-color": Re(q.backgroundColor), "kaching-bundles-sticky-atc-title-color": Re(q.titleColor), "kaching-bundles-sticky-atc-button-color": Re(q.buttonColor), "kaching-bundles-sticky-atc-button-text-color": Re(q.buttonTextColor), "kaching-bundles-sticky-atc-title-font-size": q.titleFont.size + "px", "kaching-bundles-sticky-atc-button-font-size": q.buttonFont.size + "px", "kaching-bundles-sticky-atc-title-font-style": Kn(q.titleFont.style), "kaching-bundles-sticky-atc-title-font-weight": Yn(q.titleFont.style), "kaching-bundles-sticky-atc-button-font-style": Kn(q.buttonFont.style), "kaching-bundles-sticky-atc-button-font-weight": Yn(q.buttonFont.style), "kaching-bundles-sticky-atc-product-photo-size": q.productPhotoSize + "px", "kaching-bundles-sticky-atc-button-padding": q.buttonPadding + "px", "kaching-bundles-sticky-atc-product-photo-corner-radius": q.productPhotoCornerRadius + "px", "kaching-bundles-sticky-atc-button-corner-radius": q.buttonCornerRadius + "px" }))(o())), A = g(() => {
      var q;
      return ((q = a()) == null ? void 0 : q.pricing.fullPrice) || h().variants[0].compareAtPrice || h().variants[0].price;
    }), V = g(() => {
      var q;
      return ((q = a()) == null ? void 0 : q.pricing.discountedPrice) || h().variants[0].price;
    }), C = g(() => {
      var q;
      return ((q = a()) == null ? void 0 : q.quantity) || 1;
    }), R = g(() => pn({ priceFormatter: Me(y, "$formatPrice", c), product: h(), totalFullPrice: e(A), totalDiscountedPrice: e(V), quantity: e(C), unitQuantity: null })), U = g(() => e(R)(l()(o().title)));
    var F = { get component() {
      return s();
    }, set component(q) {
      s(q), k();
    }, get config() {
      return i();
    }, set config(q) {
      i(q), k();
    }, get stickyAtc() {
      return o();
    }, set stickyAtc(q) {
      o(q), k();
    }, get translations() {
      return d();
    }, set translations(q) {
      d(q), k();
    }, get product() {
      return h();
    }, set product(q) {
      h(q), k();
    }, get dealBlock() {
      return f();
    }, set dealBlock(q) {
      f(q), k();
    } }, se = Y_(), X = P(se), K = P(X), J = P(K), N = (q) => {
      var W = Z_();
      be(() => {
        Pe(W, "src", h().image), Pe(W, "alt", h().title);
      }), v(q, W);
    };
    j(J, (q) => {
      o().productPhotoSize > 0 && q(N);
    });
    var Z = E(J, 2);
    qe(P(Z), () => e(U)), w(Z), w(K);
    var $ = E(K, 2), S = (q) => {
      var W = J_();
      W.__click = [H_, s], qe(P(W), () => l()(o().buttonText)), w(W), v(q, W);
    };
    j($, (q) => {
      o().buttonText && q(S);
    }), w(X), w(se), be(() => Wt(X, e(M))), v(n, se);
    var T = Ye(F);
    return u(), T;
  }
  Pn(["click"]), customElements.define("kaching-bundles-sticky-atc", We(ad, { config: { attribute: "config", type: "Object" }, stickyAtc: { attribute: "sticky-atc", type: "Object" }, translations: { attribute: "translations", type: "Object" }, product: { attribute: "product", type: "Object" }, dealBlock: { attribute: "deal-block", type: "Object" }, component: {} }, [], [], !1, (n) => class extends n {
    constructor() {
      super(), fn(this, "component"), this.component = this;
    }
  }));
  const K_ = tu, X_ = Jc, e0 = td, t0 = nd, n0 = rd, r0 = ad, a0 = yu.element, i0 = K_.element, l0 = X_.element, s0 = e0.element, o0 = t0.element, c0 = n0.element, u0 = r0.element;
  return Gt.ChooseMultipleGifts = l0, Gt.ChooseProduct = i0, Gt.DealBar = a0, Gt.DealBlock = s0, Gt.MixAndMatchChooseProduct = o0, Gt.PersonalisationModal = c0, Gt.StickyAtc = u0, Object.defineProperty(Gt, Symbol.toStringTag, { value: "Module" }), Gt;
})({});
