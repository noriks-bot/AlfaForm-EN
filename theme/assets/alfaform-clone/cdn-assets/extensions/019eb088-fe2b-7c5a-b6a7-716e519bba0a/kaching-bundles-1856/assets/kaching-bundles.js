import { s as y, d, i as I, c as q, a as S, g as It, b as D, e as J, f as wt, q as A, w as ft, h as C, j as vt, k as W, o as X, l as Q, m as N, n as V, p as Pt, r as R, t as O, u as St, v as Bt, x as Tt, y as At, z as Et, A as qt, B as Ft, C as Dt, D as Nt, E as Ot } from "./kaching-bundles-api.js";
const Vt = () => {
  const r = /\b__kaching_/, t = ["script", "style"], e = (n) => {
    const a = document.createTreeWalker(n, NodeFilter.SHOW_TEXT, {
      acceptNode: (s) => {
        const l = s.parentElement;
        return !l || t.includes(l.tagName.toLowerCase()) ? NodeFilter.FILTER_REJECT : NodeFilter.FILTER_ACCEPT;
      }
    });
    let o;
    for (; o = a.nextNode(); ) {
      const s = o.textContent || "";
      if (r.test(s)) {
        const l = o.parentElement;
        if (l.classList.contains("properties-key-value-key"))
          continue;
        if (l.tagName.toLowerCase() === "dt") {
          const c = l.nextElementSibling;
          (c == null ? void 0 : c.tagName.toLowerCase()) === "dd" && (c.style.display = "none");
        }
        l.style.display = "none", y(
          "kaching_property_hidden",
          {
            text: s,
            element: l.tagName
          },
          0.01
        );
      }
    }
  };
  new MutationObserver((n) => {
    for (const a of n)
      for (const o of a.addedNodes)
        o.nodeType === Node.ELEMENT_NODE && e(o);
  }).observe(document.body, {
    childList: !0,
    subtree: !0
  }), e(document.body);
}, Mt = () => {
  const r = document.querySelector('link[href*="kaching-bundles.css"]');
  if (!r) return;
  const t = r.closest(
    'div[data-block-type="liquid"]'
  );
  t && (t.dataset.blockType = "liquid-kaching-fix");
}, $ = ({
  country: r,
  language: t
}) => {
  const e = [];
  return r && e.push(`country: ${r}`), t && e.push(`language: ${t}`), e.length > 0 ? `@inContext(${e.join(", ")})` : "";
}, Lt = async (r, {
  productId: t,
  country: e,
  language: i
}) => {
  var a;
  const n = $({ country: e, language: i });
  return ((a = (await r.query(
    `
      query FetchComplementaryProductGIDs($productGID: ID!) ${n} {
        productRecommendations(productId: $productGID, intent: COMPLEMENTARY) {
          id
        }
      }
    `,
    {
      variables: {
        productGID: `gid://shopify/Product/${t}`
      }
    }
  )).productRecommendations) == null ? void 0 : a.map((o) => o.id)) || [];
}, $t = async (r, t, e = 200) => (t = t.filter(Boolean).filter((i) => !i.startsWith("placeholder")), t.length === 0 ? [] : (await r.query(
  `
      query FetchMediaImages($mediaImageIds: [ID!]!, $size: Int!) {
        nodes(ids: $mediaImageIds) {
          ... on MediaImage {
            id
            image {
              url(transform: { maxWidth: $size, maxHeight: $size })
            }
          }
        }
      }
    `,
  {
    variables: {
      mediaImageIds: t,
      size: e
    }
  }
)).nodes.filter(Boolean).map((i) => ({
  gid: i.id,
  url: i.image.url
}))), xt = async (r, t) => {
  if (!t.length) return [];
  const e = t.map((i) => `gid://shopify/Product/${i}`);
  return (await r.query(
    `
      query FetchNativeBundleProductIds($productGIDs: [ID!]!) {
        nodes(ids: $productGIDs) {
          ... on Product {
            id
            variants(first: 1) {
              nodes {
                requiresComponents
              }
            }
          }
        }
      }
    `,
    { variables: { productGIDs: e } }
  )).nodes.filter((i) => i !== null).filter(
    (i) => i.variants.nodes.some((n) => n.requiresComponents)
  ).map((i) => Number(i.id.split("/").pop()));
}, nt = async (r, {
  country: t,
  language: e,
  blockVisibility: i,
  excludedProductGIDs: n,
  selectedProductGIDs: a,
  selectedCollectionGIDs: o,
  limit: s = 1e3
}) => {
  switch (i) {
    case "selected-products":
      return a.slice(0, s);
    case "all-products":
    case "excluded-products": {
      const l = $({ country: t, language: e });
      let c = [], u = null;
      for (; c.length < s; ) {
        const f = Math.min(s - c.length, 250), h = await r.query(
          `
            query FetchProductGIDs($limit: Int!, $cursor: String) ${l} {
              products(first: $limit, after: $cursor) {
                nodes {
                  id
                }
                pageInfo {
                  hasNextPage
                  endCursor
                }
              }
            }
          `,
          {
            variables: {
              limit: f,
              cursor: u
            }
          }
        );
        if (c.push(...h.products.nodes.map((p) => p.id)), !h.products.pageInfo.hasNextPage) break;
        u = h.products.pageInfo.endCursor;
      }
      if (i === "excluded-products") {
        const f = new Set(n);
        c = c.filter((h) => !f.has(h));
      }
      return c;
    }
    case "selected-collections": {
      const l = $({ country: t, language: e }), c = (await r.query(
        `
          query FetchCollectionProductGIDs($collectionGIDs: [ID!]!, $limit: Int!) ${l} {
            nodes(ids: $collectionGIDs) {
              ... on Collection {
                products(first: $limit) {
                  nodes {
                    id
                  }
                }
              }
            }
          }
        `,
        {
          variables: {
            collectionGIDs: o,
            limit: Math.min(s, 250)
          }
        }
      )).nodes.filter((u) => u !== null).flatMap(
        (u) => u.products.nodes.map((f) => f.id)
      );
      return Array.from(new Set(c)).slice(0, s);
    }
  }
}, mt = `
  id
  availableForSale
  price {
    amount
  }
  compareAtPrice {
    amount
  }
  selectedOptions {
    name
    value
  }
  image {
    id
    url(transform: { maxWidth: 200, maxHeight: 200 })
  }
  unitPriceMeasurement {
    quantityUnit
    quantityValue
    referenceUnit
    referenceValue
  }
  requiresComponents
  sellingPlanAllocations(first: 100) @include(if: $includeSellingPlans) {
    nodes {
      sellingPlan {
        id
      }
      priceAdjustments {
        price {
          amount
        }
      }
    }
  }
  quantityAvailable @include(if: $includeAvailableQuantity)
`, G = async (r, {
  country: t,
  language: e,
  productIds: i,
  includeSellingPlans: n = !0,
  includeAvailableQuantity: a = !0,
  useExternalMetafieldNamespace: o = !1,
  batchSize: s = 250,
  onBatchError: l
}) => {
  if (!i.length)
    return [];
  const c = i.map((g) => typeof g == "string" && g.startsWith("gid://") ? g : `gid://shopify/Product/${g}`), u = `
    query FetchProducts($productGIDs: [ID!]!, $includeSellingPlans: Boolean!, $includeAvailableQuantity: Boolean!, $metafieldNamespace: String!) ${$({ country: t, language: e })} {
      nodes(ids: $productGIDs) {
        ... on Product {
          id
          handle
          onlineStoreUrl
          availableForSale
          createdAt
          title
          featuredImage {
            url
          }
          options {
            name
            optionValues {
              id
              name
              swatch {
                color
                image {
                  previewImage {
                    url(transform: { maxWidth: 200, maxHeight: 200 })
                  }
                }
              }
            }
          }
          variants(first: 250) {
            nodes {
              ${mt}
            }
          }
          collections(first: 50) {
            nodes {
              id
            }
          }
          metafield: metafield(namespace: $metafieldNamespace, key: "text") {
            value
          }
          metafield2: metafield(namespace: $metafieldNamespace, key: "text2") {
            value
          }
          metafield3: metafield(namespace: $metafieldNamespace, key: "text3") {
            value
          }
          metafield4: metafield(namespace: $metafieldNamespace, key: "text4") {
            value
          }
          requiresSellingPlan
          sellingPlanGroups(first: 100) @include(if: $includeSellingPlans) {
            nodes {
              sellingPlans(first: 100) {
                nodes {
                  id
                  name
                  priceAdjustments {
                    adjustmentValue {
                      __typename
                      ... on SellingPlanPercentagePriceAdjustment {
                        adjustmentPercentage
                      }
                      ... on SellingPlanFixedAmountPriceAdjustment {
                        adjustmentAmount {
                          amount
                        }
                      }
                      ... on SellingPlanFixedPriceAdjustment {
                        price {
                          amount
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  `, f = o ? "app--2935586817--kaching_bundles" : "$app:kaching_bundles", h = [], p = Math.min(s, 250);
  for (let g = 0; g < c.length; g += p)
    h.push(c.slice(g, g + p));
  const m = (g) => r.query(u, {
    variables: {
      productGIDs: g,
      includeSellingPlans: n,
      includeAvailableQuantity: a,
      metafieldNamespace: f
    }
  });
  let b;
  if (l) {
    const g = await Promise.allSettled(h.map(m));
    for (const k of g)
      k.status === "rejected" && l(
        k.reason instanceof Error ? k.reason : new Error(String(k.reason))
      );
    b = g.filter(
      (k) => k.status === "fulfilled"
    ).flatMap((k) => k.value.nodes);
  } else
    b = (await Promise.all(h.map(m))).flatMap((g) => g.nodes);
  const w = b.filter((g) => g != null);
  if (l) {
    const g = await Promise.allSettled(
      w.map(async (_) => {
        const B = await rt(
          r,
          _,
          { includeSellingPlans: n, includeAvailableQuantity: a }
        );
        return at(B, r.shopifyDomain);
      })
    ), k = [];
    for (const _ of g)
      _.status === "fulfilled" ? k.push(_.value) : l(
        _.reason instanceof Error ? _.reason : new Error(String(_.reason))
      );
    return k;
  }
  return (await Promise.all(
    w.map(
      (g) => rt(r, g, {
        includeSellingPlans: n,
        includeAvailableQuantity: a
      })
    )
  )).map(
    (g) => at(g, r.shopifyDomain)
  );
}, rt = async (r, t, e) => {
  if (t.variants.nodes.length < 250)
    return t;
  const i = /* @__PURE__ */ new Set(), n = [], a = [], o = async (s) => {
    let l = !0, c = null;
    for (; l; ) {
      const u = await r.query(
        `
          query($productGID: ID!, $cursor: String, $reverse: Boolean, $includeSellingPlans: Boolean!, $includeAvailableQuantity: Boolean!) {
            product(id: $productGID) {
              variants(first: 250, after: $cursor, reverse: $reverse) {
                nodes {
                  ${mt}
                }
                pageInfo {
                  endCursor
                  hasNextPage
                }
              }
            }
          }
        `,
        {
          variables: {
            productGID: t.id,
            cursor: c,
            reverse: s,
            ...e
          }
        }
      ), { nodes: f, pageInfo: h } = u.product.variants;
      for (const p of f) {
        if (i.has(p.id)) {
          l = !1;
          break;
        }
        i.add(p.id), s ? a.push(p) : n.push(p);
      }
      h.hasNextPage || (l = !1), c = h.endCursor;
    }
  };
  return await Promise.all([
    o(!1),
    o(!0)
  ]), t.variants.nodes = [...n, ...a.reverse()], t;
}, at = (r, t) => {
  var s, l, c, u, f, h;
  const e = r.variants.nodes.map(
    ({ unitPriceMeasurement: p, ...m }) => {
      var b, w, g;
      return {
        id: Number(m.id.split("/").pop()),
        availableForSale: m.availableForSale,
        price: Math.round(Number(m.price.amount) * 100),
        compareAtPrice: m.compareAtPrice ? Math.round(Number(m.compareAtPrice.amount) * 100) : null,
        options: m.selectedOptions.map((k) => k.value),
        imageId: m.image ? Number(m.image.id.split("/").pop()) : null,
        image: ((b = m.image) == null ? void 0 : b.url) || null,
        sellingPlans: ((w = m.sellingPlanAllocations) == null ? void 0 : w.nodes.map((k) => ({
          id: Number(k.sellingPlan.id.split("/").pop()),
          price: k.priceAdjustments.length > 0 ? Math.round(Number(k.priceAdjustments[0].price.amount) * 100) : Math.round(Number(m.price.amount) * 100)
        }))) || [],
        inventoryManagement: null,
        // Storefront API does not return inventory management, only available in liquid
        inventoryPolicy: null,
        // Storefront API does not return inventory policy, only available in liquid
        inventoryQuantity: (g = m.quantityAvailable) != null ? g : null,
        unitPriceMeasurement: p != null && p.quantityUnit && (p != null && p.referenceUnit) ? {
          quantityValue: p.quantityValue,
          quantityUnit: p.quantityUnit.toLowerCase(),
          referenceValue: p.referenceValue,
          referenceUnit: p.referenceUnit.toLowerCase()
        } : null
      };
    }
  ), i = r.options.map((p, m) => {
    const b = p.optionValues.map((w) => {
      var g, k, _, B;
      return {
        id: Number(w.id.split("/").pop()),
        defaultName: w.name,
        name: w.name,
        swatch: {
          color: ((g = w.swatch) == null ? void 0 : g.color) || null,
          image: ((B = (_ = (k = w.swatch) == null ? void 0 : k.image) == null ? void 0 : _.previewImage) == null ? void 0 : B.url) || null
        }
      };
    });
    return {
      defaultName: p.name,
      name: p.name,
      position: m + 1,
      optionValues: Rt(b, m, e)
    };
  }), n = (p) => {
    const m = p.priceAdjustments[0];
    if (!m)
      return null;
    const b = m.adjustmentValue;
    switch (b.__typename) {
      case "SellingPlanPercentagePriceAdjustment":
        return {
          type: "percentage",
          value: b.adjustmentPercentage
        };
      case "SellingPlanFixedAmountPriceAdjustment":
        return {
          type: "fixed_amount",
          value: Number(b.adjustmentAmount.amount) * 100
        };
      case "SellingPlanFixedPriceAdjustment":
        return {
          type: "price",
          value: Number(b.price.amount) * 100
        };
      default:
        throw new Error(
          `Unknown price adjustment type: ${b.__typename}`
        );
    }
  }, a = ((s = r.sellingPlanGroups) == null ? void 0 : s.nodes.flatMap(
    (p) => p.sellingPlans.nodes.map((m) => ({
      id: Number(m.id.split("/").pop()),
      name: m.name,
      priceAdjustment: n(m)
    }))
  )) || [], o = r.variants.nodes.some(
    (p) => p.requiresComponents
  );
  return {
    id: Number(r.id.split("/").pop()),
    handle: r.handle,
    url: r.onlineStoreUrl || `https://${t}/products/${r.handle}`,
    availableForSale: r.availableForSale,
    createdAt: r.createdAt,
    title: r.title,
    image: ((l = r.featuredImage) == null ? void 0 : l.url) || null,
    collectionIds: r.collections.nodes.map(
      (p) => Number(p.id.split("/").pop())
    ),
    options: i,
    selectedVariantId: Number(
      r.variants.nodes[0].id.split("/").pop()
    ),
    variants: e,
    requiresSellingPlan: r.requiresSellingPlan,
    sellingPlans: a,
    isNativeBundle: o,
    metafields: {
      text: ((c = r.metafield) == null ? void 0 : c.value) || null,
      text2: ((u = r.metafield2) == null ? void 0 : u.value) || null,
      text3: ((f = r.metafield3) == null ? void 0 : f.value) || null,
      text4: ((h = r.metafield4) == null ? void 0 : h.value) || null
    }
  };
}, Rt = (r, t, e) => r.filter((i) => e.filter(
  (n) => n.options[t] === i.name
).length > 0), Gt = async (r, t, e) => {
  const i = t.map((a) => `gid://shopify/Product/${a}`), n = $({
    country: e == null ? void 0 : e.country,
    language: e == null ? void 0 : e.language
  });
  return (await r.query(
    `
      query FetchProductsInDefaultLanguage($productGIDs: [ID!]!) ${n} {
        nodes(ids: $productGIDs) {
          ... on Product {
            id
            options {
              name
              optionValues {
                id
                name
              }
            }
          }
        }
        localization {
          country {
            isoCode
          }
          language {
            isoCode
          }
        }
      }
    `,
    {
      variables: {
        productGIDs: i
      }
    }
  )).nodes.filter((a) => a != null).map(Ht);
}, Ht = (r) => {
  const t = r.options.map(
    (e, i) => ({
      defaultName: e.name,
      position: i + 1,
      optionValues: e.optionValues.map((n) => ({
        id: Number(n.id.split("/").pop()),
        defaultName: n.name
      }))
    })
  );
  return {
    id: Number(r.id.split("/").pop()),
    options: t
  };
}, Qt = (r, t) => {
  const e = [], i = r.filter(
    (s) => s.blockVisibility === "selected-products"
  );
  for (const s of i)
    s.selectedProductIds.map(Number).includes(t.id) && e.push(s);
  const n = r.filter(
    (s) => s.blockVisibility === "selected-collections"
  );
  for (const s of n)
    t.collectionIds.some(
      (l) => s.selectedCollectionIds.map(Number).includes(l)
    ) && e.push(s);
  const a = r.filter(
    (s) => s.blockVisibility === "excluded-products"
  );
  for (const s of a)
    !s.excludedProductIds.map(Number).includes(t.id) && !(s.excludedCollectionIds || []).some(
      (l) => t.collectionIds.includes(l)
    ) && e.push(s);
  const o = r.filter(
    (s) => s.blockVisibility === "all-products"
  );
  for (const s of o)
    e.push(s);
  return e;
}, zt = (r) => [
  ...Ut(r),
  ...jt(r),
  ...Jt(r),
  ...Kt(r),
  ...Wt(r),
  ...Xt(r),
  ...Yt(r),
  ...Zt(r),
  ...te(r),
  ...ee(r)
].filter((t) => t != null && !t.includes("placeholder")), Ut = (r) => r.dealBars.flatMap((t) => [t.mediaImageGID, t.badgeImageGID]).filter((t) => t != null), jt = (r) => r.dealBars.map(
  ({ freeGifts: t }) => (t || []).map((e) => e.mediaImageGID)
).reduce((t, e) => t.concat(e), []).filter((t) => t != null), Jt = (r) => r.dealBars.flatMap(
  ({ multipleGiftsSelectors: t }) => (t || []).map((e) => e.mediaImageGID)
).filter((t) => t != null), Kt = (r) => r.dealBars.map(({ upsells: t }) => (t || []).map((e) => e.mediaImageGID)).reduce((t, e) => t.concat(e), []).filter((t) => t != null), Wt = (r) => r.swatchOptions ? r.swatchOptions.reduce((t, e) => {
  const i = e.images.map((n) => n.mediaImageGID).filter((n) => n != null);
  return [...t, ...i];
}, []) : [], Xt = (r) => {
  if (!r.collectionBreaksEnabled || !r.collectionBreaks)
    return [];
  const t = r.collectionBreaks.mediaImageGID;
  return t ? [t] : [];
}, Yt = (r) => {
  var t, e, i;
  return r.progressiveGifts ? [
    ...((t = r.progressiveGifts.gifts) == null ? void 0 : t.map((n) => n.mediaImageGID)) || [],
    (e = r.progressiveGifts.style) == null ? void 0 : e.lockedMediaImageGID,
    (i = r.progressiveGifts.dealBarStyle) == null ? void 0 : i.lockedMediaImageGID
  ].filter((n) => n != null) : [];
}, Zt = (r) => !r.checkboxUpsellsEnabled || !r.checkboxUpsells ? [] : r.checkboxUpsells.upsells.flatMap((t) => [t.mediaImageGID, t.badgeImageGID]).filter((t) => t != null), te = (r) => r.dealBars.map((t) => {
  var e;
  return (e = t.productPersonalisation) == null ? void 0 : e.mediaImageGID;
}).filter((t) => t != null), ee = (r) => {
  var i, n;
  const t = r.dealBars.map((a) => {
    var o;
    return (o = a.highlights) == null ? void 0 : o.customIconGID;
  }).filter((a) => a != null), e = (n = (i = r.subscriptions) == null ? void 0 : i.highlights) == null ? void 0 : n.customIconGID;
  return e ? [...t, e] : t;
}, ie = (r) => {
  const t = [
    ...ne(r),
    ...re(r),
    ...ae(r),
    ...se(r),
    ...oe(r),
    ...le(r),
    ...ce(r),
    ...ue(r)
  ];
  return Array.from(new Set(t.filter((e) => e != null)));
}, ne = (r) => r.dealBars.flatMap(
  ({ freeGifts: t }) => t ? t.map((e) => e.productGID) : []
).filter((t) => t != null), re = (r) => r.dealBars.flatMap(
  ({ multipleGiftsSelectors: t }) => t ? t.flatMap(
    (e) => e.products ? e.products.map((i) => i.id) : []
  ) : []
).filter((t) => t != null), ae = (r) => {
  var t;
  return r.progressiveGiftsEnabled ? ((t = r.progressiveGifts) == null ? void 0 : t.gifts.map((e) => e.productGID).filter((e) => e != null)) || [] : [];
}, se = (r) => r.dealBars.flatMap(({ upsells: t }) => t ? t.map((e) => e.productGID) : []).filter((t) => t != null), oe = (r) => r.dealBars.filter((t) => t.dealBarType === "bundle").flatMap(
  ({ bundleProducts: t }) => t ? t.map((e) => e.productGID) : []
).filter((t) => t != null).filter((t) => t !== "default"), le = (r) => r.dealBars.filter((t) => t.dealBarType === "mix-and-match").flatMap(
  ({ bundleProducts: t }) => t ? t.flatMap((e) => {
    var i, n;
    return [
      e.productGID,
      ...(n = (i = e.selectedProducts) == null ? void 0 : i.map((a) => a.id)) != null ? n : []
    ];
  }) : []
).filter((t) => t != null).filter((t) => t !== "default"), ce = (r) => !r.checkboxUpsellsEnabled || !r.checkboxUpsells ? [] : r.checkboxUpsells.upsells.map((t) => t.productGID).filter((t) => t != null), ue = (r) => r.dealBars.filter((t) => t.dealBarType === "sku").flatMap(({ productGID: t }) => t ? [t] : []), M = "kachingBundlesSaveOverlayDismissed", de = "bundles.kachingappz.app", pe = () => {
  const r = document.createElement("div");
  return r.className = "kaching-bundles-save-overlay", r.setAttribute("role", "status"), r.setAttribute("tabindex", "0"), r.setAttribute(
    "aria-label",
    "Click Save in the top-right corner to activate the app. Press Escape or Enter to dismiss."
  ), r.innerHTML = `
    <div class="kaching-bundles-save-overlay__content">
      <div class="kaching-bundles-save-overlay__text">Click "Save" in the top-right corner.</div>
      <svg class="kaching-bundles-save-overlay__arrow" aria-hidden="true" width="42" height="36" viewBox="0 0 42 36" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M21.0235 30.0476C26.9813 26.0688 31.6367 20.3068 34.359 13.6647C34.5787 13.1287 34.7807 12.5866 34.9688 12.0407C34.9872 12.1286 35.0055 12.2166 35.0239 12.3045C35.6997 15.541 36.1871 18.9234 37.35 22.0252C37.7091 22.9828 39.2759 22.7067 39.9528 22.449C40.7647 22.1396 42.0725 21.3396 41.9969 20.292C41.7562 16.9608 40.8171 13.666 40.0928 10.414C39.3726 7.17983 38.6526 3.94569 37.9324 0.711381C37.7809 0.0312821 36.6451 -0.0343474 36.1453 0.0113582C35.3082 0.0879608 34.2573 0.50077 33.6973 1.15893C33.4368 1.46497 33.1749 1.76993 32.9143 2.07579C32.6324 2.30048 32.3929 2.56904 32.2294 2.87801C29.1225 6.52203 26.0063 10.1587 22.8826 13.7888C22.4856 14.2503 22.2166 14.9143 22.9177 15.2375C23.5886 15.5469 24.5829 15.0895 25.0594 14.6178C27.0866 12.6108 29.1155 10.6056 31.1471 8.60291C30.1175 12.9391 28.3489 17.1025 25.7631 20.7229C24.0598 23.1078 21.9 25.3178 19.6649 26.9826C17.264 28.771 14.6378 30.214 11.9792 31.178C10.3347 31.7744 8.62775 32.2461 6.92197 32.6287C5.09815 33.0377 3.24342 33.2486 1.42578 33.6781C0.857063 33.8125 -0.79524 35.2271 0.459136 35.5827C3.73503 36.5115 7.65457 35.7308 10.8601 34.7902C14.4641 33.7324 17.896 32.1362 21.0235 30.0476Z" fill="white"/>
      </svg>
    </div>
  `, r;
}, st = (r) => {
  r.classList.add("kaching-bundles-save-overlay--dismissed");
  try {
    sessionStorage.setItem(M, "true");
  } catch {
  }
  setTimeout(() => r.remove(), 300);
}, he = () => {
  if (sessionStorage.getItem(M))
    return;
  const r = pe();
  document.body.appendChild(r), requestAnimationFrame(() => {
    r.classList.add("kaching-bundles-save-overlay--visible"), r.focus();
  }), r.addEventListener("click", () => st(r)), r.addEventListener("keydown", (t) => {
    (t.key === "Escape" || t.key === "Enter") && st(r);
  });
}, fe = async ({
  appHost: r,
  shopifyDomain: t,
  themeId: e
}) => {
  try {
    if (sessionStorage.getItem(M))
      return !0;
  } catch {
  }
  const i = new URLSearchParams({ shop: t });
  e && i.set("theme_id", e.toString());
  const n = `${r}/public_api/app_embed?${i.toString()}`, a = await fetch(n);
  if (!a.ok)
    throw new Error(`API error: ${a.status}`);
  const o = await a.json();
  if (o.themeInaccessible) {
    try {
      sessionStorage.setItem(M, "true");
    } catch {
    }
    return !0;
  }
  if (o.active)
    try {
      sessionStorage.setItem(M, "true");
    } catch {
    }
  return o.active;
}, me = async ({
  customApiHost: r,
  shopifyDomain: t,
  themeId: e
}) => {
  const n = `https://${r != null ? r : de}`;
  try {
    await fe({
      appHost: n,
      shopifyDomain: t,
      themeId: e
    }) || he();
  } catch {
  }
};
function _e(r, t, e) {
  var n, a;
  return t ? ((a = (n = window.Shopify.currency) == null ? void 0 : n.active) != null ? a : e) === t.currencyCode ? 1 : 1 / t.currencyRate * r : r;
}
function ot(r) {
  const t = r.properties && typeof r.properties == "object" ? r.properties : {};
  for (const [i, n] of Object.entries(r)) {
    const a = i.match(/^properties\[(.+)\]$/);
    a && (t[a[1]] = n);
  }
  tt(t);
  const e = {
    id: Number(r.id),
    quantity: Number(r.quantity) || 1,
    properties: t
  };
  return r.selling_plan && (e.selling_plan = Number(r.selling_plan)), r.parent_id && (e.parent_id = Number(r.parent_id)), e;
}
function tt(r) {
  if (!r.__kaching_bundles) return;
  const t = r.__kaching_bundles;
  if (typeof t == "string")
    try {
      const e = atob(t);
      JSON.parse(e), r.__kaching_bundles = e;
    } catch {
    }
}
function z(r) {
  try {
    return JSON.parse(r), !1;
  } catch {
    return !0;
  }
}
function U(r) {
  const t = new URLSearchParams(r), e = new FormData();
  return t.forEach((i, n) => {
    e.append(n, i);
  }), e;
}
function ge(r) {
  const t = new URLSearchParams();
  return r.forEach((e, i) => {
    t.append(i, e);
  }), t.toString();
}
const be = (r) => /\/cart\/change(\.js)?(\?|$)/.test(r), ye = (r) => {
  const t = { id: null, line: null, quantity: null };
  if (r == null) return t;
  if (r instanceof FormData || r instanceof URLSearchParams)
    return K(r);
  if (typeof r == "string") {
    if (z(r))
      return K(U(r));
    try {
      const e = JSON.parse(r);
      return {
        id: e.id != null ? String(e.id) : null,
        line: e.line != null ? Number(e.line) : null,
        quantity: e.quantity != null ? Number(e.quantity) : null
      };
    } catch {
      return t;
    }
  }
  return t;
}, K = (r) => {
  const t = r.get("id"), e = r.get("line"), i = r.get("quantity");
  return {
    id: t,
    line: e != null ? Number(e) : null,
    quantity: i != null ? Number(i) : null
  };
}, Ce = (r, t) => {
  if (t.line != null && Number.isFinite(t.line)) {
    const e = t.line - 1;
    return e >= 0 && e < r.length ? e : -1;
  }
  if (t.id != null) {
    const e = r.findIndex((n) => n.key === t.id);
    if (e >= 0) return e;
    const i = Number(t.id);
    if (Number.isFinite(i))
      return r.findIndex((n) => n.id === i);
  }
  return -1;
}, ke = (r, t) => {
  var s;
  if (t.quantity == null || !Number.isFinite(t.quantity))
    return { rewrite: !1 };
  let e;
  try {
    e = JSON.parse(r);
  } catch {
    return { rewrite: !1 };
  }
  const i = e == null ? void 0 : e.items;
  if (!Array.isArray(i)) return { rewrite: !1 };
  const n = Ce(i, t);
  if (n < 0) return { rewrite: !1 };
  const a = i[n];
  return ((s = a.properties) == null ? void 0 : s.__kaching_bundles) ? a.quantity === t.quantity ? { rewrite: !1 } : (a.quantity = t.quantity, { rewrite: !0, body: JSON.stringify(e) }) : { rewrite: !1 };
};
function j(r) {
  return Array.from(r.keys()).some(
    (e) => e.startsWith("items[")
  ) ? we(r) : Ie(r);
}
function Ie(r) {
  const t = r.get("id");
  if (!t)
    return y("intercept_cart_request_error", {
      type: "processing",
      error: "Missing item id in form data",
      body: r
    }), null;
  const e = {};
  r.forEach((o, s) => {
    const l = s.match(/^properties\[(.+)\]$/);
    l && (e[l[1]] = o);
  }), tt(e);
  const i = {
    id: Number(t),
    quantity: Number(r.get("quantity")) || 1,
    properties: e
  }, n = r.get("selling_plan");
  n && (i.selling_plan = Number(n));
  const a = r.get("parent_id");
  return a && (i.parent_id = Number(a)), [i];
}
function we(r) {
  const t = /* @__PURE__ */ new Map();
  if (r.forEach((i, n) => {
    const a = n.match(/^items\[(\d+)\]\[(.+)\]$/);
    if (!a) return;
    const o = Number(a[1]), s = a[2];
    t.has(o) || t.set(o, { properties: {} });
    const l = t.get(o);
    switch (s) {
      case "id":
        l.id = Number(i);
        break;
      case "quantity":
        l.quantity = Number(i);
        break;
      case "selling_plan":
        l.selling_plan = Number(i);
        break;
      case "parent_id":
        l.parent_id = Number(i);
        break;
      default: {
        const c = s.match(/^properties\]\[(.+)$/);
        c && (l.properties[c[1]] = i);
      }
    }
  }), t.size === 0) return null;
  const e = [];
  for (const [, i] of t) {
    if (!i.id) continue;
    tt(i.properties);
    const n = {
      id: i.id,
      quantity: i.quantity || 1,
      properties: i.properties
    };
    i.selling_plan && (n.selling_plan = i.selling_plan), i.parent_id && (n.parent_id = i.parent_id), e.push(n);
  }
  return e.length > 0 ? e : null;
}
function lt(r, t) {
  const e = new FormData();
  if (r.forEach((i, n) => {
    ve(n) || e.append(n, i);
  }), t.length === 1) {
    const i = t[0];
    if (e.append("id", String(i.id)), e.append("quantity", String(i.quantity)), i.selling_plan && e.append("selling_plan", String(i.selling_plan)), i.parent_id && e.append("parent_id", String(i.parent_id)), i.properties)
      for (const [n, a] of Object.entries(i.properties))
        e.append(`properties[${n}]`, _t(a));
  } else
    t.forEach(
      (i, n) => Pe(e, i, n)
    );
  return e;
}
function ve(r) {
  return ["id", "quantity", "selling_plan", "parent_id"].includes(r) || // Some themes (e.g. Candy) submit both `id` and `id[]` with the same
  // variant id in their product form. Shopify treats `id[]` as a separate
  // add operation, so it must be stripped along with `id` — otherwise the
  // variant gets added a second time (with empty properties) alongside the
  // rewritten `items[N][...]` payload.
  ["id[]", "quantity[]", "selling_plan[]", "parent_id[]"].includes(r) || r.startsWith("properties[") || r.startsWith("items[");
}
function Pe(r, t, e) {
  if (r.append(`items[${e}][id]`, String(t.id)), r.append(`items[${e}][quantity]`, String(t.quantity)), t.selling_plan && r.append(`items[${e}][selling_plan]`, String(t.selling_plan)), t.parent_id && r.append(`items[${e}][parent_id]`, String(t.parent_id)), t.properties)
    for (const [i, n] of Object.entries(t.properties))
      r.append(
        `items[${e}][properties][${i}]`,
        _t(n)
      );
}
function _t(r) {
  return r instanceof Blob ? r : String(r);
}
function gt(r) {
  try {
    const t = JSON.parse(r);
    return !t || typeof t != "object" ? (y("intercept_cart_request_error", {
      type: "processing",
      error: "Failed to parse JSON body",
      body: r
    }), null) : Array.isArray(t.items) ? t.items.filter(
      (e) => e && typeof e == "object" && "id" in e
    ).map((e) => ot(e)) : t.id ? [ot(t)] : null;
  } catch {
    return y("intercept_cart_request_error", {
      type: "processing",
      error: "Failed to parse JSON body",
      body: r
    }), null;
  }
}
function Se(r, t) {
  try {
    const e = JSON.parse(r), i = [
      "id",
      "quantity",
      "selling_plan",
      "parent_id",
      "properties"
    ], n = {};
    for (const [a, o] of Object.entries(e))
      !i.includes(a) && a !== "items" && !a.startsWith("properties[") && (n[a] = o);
    return t.length === 1 ? Object.assign(n, t[0]) : n.items = t, JSON.stringify(n);
  } catch {
    return t.length === 1 ? JSON.stringify(t[0]) : JSON.stringify({ items: t });
  }
}
const Be = 100, Te = 1500;
class Ae {
  constructor() {
    this._inFlight = /* @__PURE__ */ new Map();
  }
  // Returns a stable key for a bundle add body, or null if this body either
  // isn't a bundle add or isn't a body shape we know how to dedupe. The cheap
  // string check up front means we don't parse (and don't trigger the parse-
  // error telemetry) for normal non-bundle adds.
  buildKey(t) {
    if (!Ee(t)) return null;
    const e = qe(t);
    return !(e != null && e.length) || !e.some((i) => i.properties.__kaching_bundles) ? null : Fe(e);
  }
  // Runs `send` and remembers the in-flight Response for `key`. If another
  // call comes in with the same key while the first is in flight, or for a
  // short window after it settles, the second call doesn't run — it gets a
  // clone of the first response and `deduped: true`.
  //
  // If the first request errors out, we don't replay the error: we re-enter
  // so this waiter either joins onto a sibling's fresh retry (if one already
  // started) or starts the retry itself. Without re-entering, three concurrent
  // waiters could each fire their own send after a failed first attempt and
  // double the cart all over again — the bug this guard exists to prevent.
  async dispatch(t, e) {
    const i = this._inFlight.get(t);
    if (i)
      try {
        const o = new Promise(
          (l, c) => setTimeout(() => {
            this._inFlight.get(t) === i && this._inFlight.delete(t), c(new Error("stale"));
          }, Te)
        );
        return { response: (await Promise.race([i, o])).clone(), deduped: !0 };
      } catch {
        return this.dispatch(t, e);
      }
    const n = e();
    return this._inFlight.set(t, n), n.then(
      () => {
        setTimeout(() => {
          this._inFlight.get(t) === n && this._inFlight.delete(t);
        }, Be);
      },
      () => {
        this._inFlight.get(t) === n && this._inFlight.delete(t);
      }
    ), { response: (await n).clone(), deduped: !1 };
  }
}
function Ee(r) {
  if (typeof r == "string")
    return r.includes("__kaching_bundles");
  if (r instanceof FormData) {
    for (const t of r.keys())
      if (t.includes("__kaching_bundles")) return !0;
    return !1;
  }
  return !1;
}
function qe(r) {
  try {
    return r instanceof FormData ? j(r) : z(r) ? j(U(r)) : gt(r);
  } catch {
    return null;
  }
}
function Fe(r) {
  const t = r.map((e) => {
    var i;
    return {
      id: e.id,
      quantity: e.quantity,
      sellingPlan: (i = e.selling_plan) != null ? i : null,
      properties: e.properties
    };
  }).sort((e, i) => {
    var o, s;
    if (e.id !== i.id) return e.id - i.id;
    const n = String((o = e.properties.__kaching_bundles) != null ? o : ""), a = String((s = i.properties.__kaching_bundles) != null ? s : "");
    return n.localeCompare(a);
  });
  return JSON.stringify(t);
}
const ct = /* @__PURE__ */ new WeakMap();
class De {
  constructor() {
    this._started = !1, this._registeredDeals = /* @__PURE__ */ new Map(), this._fallbackDeal = null, this._fallbackDealTimeout = null, this._rewriteCartChangeEnabled = !1, this._cartChangeDetectionReported = !1, this._dedupeEnabled = !0, this._dedupe = new Ae();
  }
  start() {
    this._started || (this._started = !0, this._interceptFetchRequests(), this._interceptXHRRequests(), this._interceptCartFormSubmits(), window.OpusNoATC = !0, d("CartInterceptor started"));
  }
  registerDeal(t, e, i) {
    const n = this._registeredDeals.get(t) || [];
    n.push({ getItems: i, product: e }), this._registeredDeals.set(t, n), d("CartInterceptor deal registered", {
      dealId: t,
      totalDeals: n.length
    });
  }
  setCartChangeRewriteEnabled(t) {
    this._rewriteCartChangeEnabled = t;
  }
  setDedupeEnabled(t) {
    this._dedupeEnabled = t;
  }
  setFallbackDeal(t, e) {
    d("CartInterceptor fallback deal set", { dealId: t }), this._fallbackDealTimeout && clearTimeout(this._fallbackDealTimeout), this._fallbackDeal = { dealId: t, product: e }, this._fallbackDealTimeout = window.setTimeout(() => {
      this._fallbackDeal = null, this._fallbackDealTimeout = null;
    }, 2e3);
  }
  _interceptFetchRequests() {
    const t = window.fetch.bind(window);
    window.fetch = async (e, i) => {
      var a;
      const n = Ne(e);
      if (!n) return t(e, i);
      if (this._isInterceptableUrl(n)) {
        const o = this._getModifiedBody(n, i == null ? void 0 : i.body), s = o != null ? o : i == null ? void 0 : i.body, l = this._dedupe.buildKey(s), c = () => this._sendInterceptableCartAdd(
          t,
          e,
          i,
          o
        );
        if (l && this._dedupeEnabled) {
          const { response: u, deduped: f } = await this._dedupe.dispatch(
            l,
            c
          );
          return f && y("intercept_cart_request_deduped", {
            theme: (a = window.Shopify.theme) == null ? void 0 : a.schema_name
          }), u;
        }
        return c();
      } else if (be(n)) {
        const o = await t(e, i);
        return this._maybeRewriteCartChangeResponse(o, i == null ? void 0 : i.body);
      }
      return t(e, i);
    };
  }
  async _sendInterceptableCartAdd(t, e, i, n) {
    var a, o;
    if (!n)
      return t(e, i);
    I("Intercepting cart/add request, merging bundle items"), y(
      "intercept_cart_request",
      {
        type: "fetch",
        theme: (a = window.Shopify.theme) == null ? void 0 : a.schema_name
      },
      0.01
    );
    try {
      return await t(e, { ...i, body: n });
    } catch (s) {
      return d("Modified request failed, retrying with original", { error: s }), y("intercept_cart_request_error", {
        type: "fetch",
        theme: (o = window.Shopify.theme) == null ? void 0 : o.schema_name,
        error: s instanceof Error ? s.message : String(s)
      }), t(e, i);
    }
  }
  async _maybeRewriteCartChangeResponse(t, e) {
    var a;
    if (!t.ok || !(t.headers.get("content-type") || "").includes("json")) return t;
    const n = ye(e);
    if (n.quantity == null || !this._rewriteCartChangeEnabled && this._cartChangeDetectionReported)
      return t;
    try {
      const s = await t.clone().text(), l = ke(s, n);
      if (!l.rewrite || (this._cartChangeDetectionReported || (this._cartChangeDetectionReported = !0, y("cart_change_rewrite_detected", {
        applied: this._rewriteCartChangeEnabled,
        theme: (a = window.Shopify.theme) == null ? void 0 : a.schema_name
      })), !this._rewriteCartChangeEnabled)) return t;
      const c = new Headers(t.headers);
      return c.delete("content-length"), new Response(l.body, {
        status: t.status,
        statusText: t.statusText,
        headers: c
      });
    } catch (o) {
      return d("Cart change response rewrite failed, returning original", {
        error: o
      }), t;
    }
  }
  _interceptXHRRequests() {
    var s, l, c, u;
    const t = XMLHttpRequest.prototype.open, e = XMLHttpRequest.prototype.send, i = function(f, h, p = !0, m, b) {
      return ct.set(this, h instanceof URL ? h.href : h), t.call(this, f, h, p, m, b);
    }, n = function(f) {
      var p, m;
      const h = ct.get(this);
      if (h) {
        const b = F._getModifiedBody(h, f);
        if (b) {
          I("Intercepting XHR cart/add request, merging bundle items"), y("intercept_cart_request", {
            type: "xhr",
            theme: (p = window.Shopify.theme) == null ? void 0 : p.schema_name
          });
          try {
            return e.call(this, b);
          } catch (w) {
            return d("Modified XHR request failed, retrying with original", {
              error: w
            }), y("intercept_cart_request_error", {
              type: "xhr",
              theme: (m = window.Shopify.theme) == null ? void 0 : m.schema_name,
              error: w instanceof Error ? w.message : String(w)
            }), e.call(this, f);
          }
        }
      }
      return e.call(this, f);
    }, a = Object.getOwnPropertyDescriptor(
      XMLHttpRequest.prototype,
      "open"
    ), o = Object.getOwnPropertyDescriptor(
      XMLHttpRequest.prototype,
      "send"
    );
    if ((a == null ? void 0 : a.configurable) === !1 || (o == null ? void 0 : o.configurable) === !1) {
      d("Cannot intercept XHR - prototype methods are not configurable");
      return;
    }
    Object.defineProperty(XMLHttpRequest.prototype, "open", {
      value: i,
      writable: (s = a == null ? void 0 : a.writable) != null ? s : !0,
      configurable: (l = a == null ? void 0 : a.configurable) != null ? l : !0
    }), Object.defineProperty(XMLHttpRequest.prototype, "send", {
      value: n,
      writable: (c = o == null ? void 0 : o.writable) != null ? c : !0,
      configurable: (u = o == null ? void 0 : o.configurable) != null ? u : !0
    });
  }
  _interceptCartFormSubmits() {
    const t = async (e) => {
      var s, l;
      if (e.defaultPrevented || !(e.target instanceof HTMLFormElement))
        return;
      const i = e.target, n = i.action;
      if (!n.includes("/cart/add"))
        return;
      const a = new FormData(i);
      if (this._getModifiedBody(n, a)) {
        e.preventDefault(), y("intercept_cart_request", {
          type: "form",
          theme: (s = window.Shopify.theme) == null ? void 0 : s.schema_name
        });
        try {
          const c = await fetch(n, {
            method: "POST",
            body: a
          });
          if (!c.ok)
            throw new Error(`HTTP ${c.status}`);
          window.location.href = "/cart";
        } catch (c) {
          d("Fetch request failed, submitting original form", {
            error: c
          }), y("intercept_cart_request_error", {
            type: "form",
            theme: (l = window.Shopify.theme) == null ? void 0 : l.schema_name,
            error: c instanceof Error ? c.message : String(c)
          }), i.submit();
        }
      }
    };
    document.addEventListener("submit", t), setTimeout(() => {
      document.removeEventListener("submit", t), document.addEventListener("submit", t);
    }, 3e3);
  }
  _getModifiedBody(t, e) {
    try {
      if (!this._isInterceptableUrl(t))
        return null;
      if (d("Request body", e), typeof e != "string" && !(e instanceof FormData))
        return y("intercept_cart_request_error", {
          type: "processing",
          error: "Invalid body type"
        }), null;
      const i = this._parseOriginalItems(e);
      if (d("Original items", i), !i)
        return null;
      const n = this._findBundleItems(i);
      if (d("Bundle items", n), !n)
        return null;
      const a = this._mergeItems(i, n);
      if (d("Merged items", a), JSON.stringify(i) === JSON.stringify(a))
        return null;
      const o = this._updateBody(e, a);
      return d("Updated body", o), o;
    } catch (i) {
      return d("CartInterceptor error, falling back to original request", {
        error: i
      }), y("intercept_cart_request_error", {
        type: "processing",
        error: i instanceof Error ? i.message : String(i)
      }), null;
    }
  }
  _isInterceptableUrl(t) {
    return t.includes("cart/add") && !t.includes("kaching_bundles=true") && !t.includes("kaching-cart=true") && !t.includes("kaching_popup=true");
  }
  _parseOriginalItems(t) {
    if (t instanceof FormData)
      return j(t);
    if (z(t)) {
      const e = U(t);
      return j(e);
    }
    return gt(t);
  }
  _findBundleItems(t) {
    var o, s;
    const e = t.find(
      (l) => l.properties.__kaching_bundles
    ), i = e ? JSON.parse(e.properties.__kaching_bundles).deal : (o = this._fallbackDeal) == null ? void 0 : o.dealId;
    if (!i)
      return null;
    const n = this._fallbackDeal;
    if (!e && n) {
      if (!t.some(
        (c) => n.product.variants.some((u) => u.id === c.id)
      ))
        return null;
      y("fallback_deal_used", {
        theme: (s = window.Shopify.theme) == null ? void 0 : s.schema_name
      });
    }
    const a = this._registeredDeals.get(i);
    if (!(a != null && a.length))
      return d("No registered deals found", { dealId: i }), null;
    for (const { getItems: l, product: c } of a) {
      const u = l();
      if (e ? u.some(
        (h) => t.some(
          (p) => p.id === h.id && p.properties.__kaching_bundles === h.properties.__kaching_bundles
        )
      ) : u.length > 0 && c.id === (n == null ? void 0 : n.product.id)) return u;
    }
    return d("No matching items found for deal", { dealId: i }), null;
  }
  _mergeItems(t, e) {
    t = t.map((s) => ({
      ...s
    }));
    const i = t.find(
      (s) => s.properties.__kaching_bundles
    );
    if (!i && this._fallbackDeal) {
      const s = t.filter(
        (l) => !this._fallbackDeal.product.variants.some((c) => c.id === l.id) && !e.some((c) => c.id === l.id)
      );
      return [...e, ...s];
    }
    const n = {};
    if (i) {
      for (const [l, c] of Object.entries(i.properties))
        l !== "__kaching_bundles" && (n[l] = c);
      const s = e.find(
        (l) => l.id === i.id && l.properties.__kaching_bundles === i.properties.__kaching_bundles
      );
      s && (i.quantity = s.quantity, s.selling_plan && (i.selling_plan = s.selling_plan));
    }
    return [...e.filter(
      (s) => !t.some(
        (l) => l.id === s.id && l.properties.__kaching_bundles === s.properties.__kaching_bundles
      )
    ).map((s) => {
      const l = JSON.parse(
        s.properties.__kaching_bundles
      );
      return l != null && l.main ? {
        ...s,
        properties: {
          ...n,
          ...s.properties
        }
      } : s;
    }), ...t];
  }
  _updateBody(t, e) {
    if (t instanceof FormData)
      return lt(t, e);
    if (z(t)) {
      const i = U(t), n = lt(i, e);
      return ge(n);
    }
    return Se(t, e);
  }
}
const Ne = (r) => typeof r == "string" ? r : r instanceof URL ? r.href : r && typeof r == "object" && "url" in r ? r.url : null, F = new De(), H = async (r, t, e, i) => {
  var l;
  if (!t || e.length === 0) return;
  const n = Oe(i);
  if (n.length === 0) return;
  const a = e.map((c) => c.id), o = (l = n.find((c) => c.localization)) == null ? void 0 : l.localization, s = new q(
    r,
    t
  );
  try {
    const c = await Gt(
      s,
      a,
      o
    );
    for (const u of e) {
      const f = c.find(
        (h) => h.id === u.id
      );
      f && Ve(u, f);
    }
  } catch (c) {
    console.error("[Kaching Bundles] Failed to fetch swatches", c), setTimeout(() => {
      throw c;
    }, 0);
  }
}, Oe = (r) => r.map((e) => e.swatchOptions || []).reduce((e, i) => e.concat(i), []).filter((e) => e != null).filter((e) => e.swatchType !== "default"), Ve = (r, t) => {
  for (const e of t.options) {
    const i = r.options.find(
      (n) => n.position === e.position
    );
    if (i) {
      i.defaultName = e.defaultName;
      for (const n of e.optionValues) {
        const a = i.optionValues.find(
          (o) => o.id === n.id
        );
        a && (a.defaultName = n.defaultName);
      }
    }
  }
}, ut = window;
class Me {
  constructor(t, e, i, n, a, o, s) {
    var l, c, u, f;
    if (this._items = [], this._clickedAddToCartBeforeFormSubmit = !1, this._isFirstVariantChange = !0, I("Deal block id:", a.id), I("Deal block settings", a), I("Config", i), I("Product", o), I("Deal block widget", { widget: t }), I("Cart form", { form: (l = e.addToCartForm()) == null ? void 0 : l.form }), I("Add to cart button", {
      button: (c = e.addToCartButton()) == null ? void 0 : c.button
    }), I("Quantity input", { input: e.quantityInput() }), I("Variant picker", {
      picker: (u = e.variantPicker()) == null ? void 0 : u.elements()
    }), this._dealBlockElement = t, this._productBlock = e, this._globalConfig = i, this._translations = n, this._dealBlockSettings = a, this._product = o, this._otherProductsFromLiquid = s, this._country = this._globalConfig.country, this._language = this._globalConfig.locale.split("-")[0].toUpperCase(), this._globalConfig.featureFlags.initialize_with_form_variant) {
      let h = this._product.selectedVariantId || this._product.variants[0].id;
      const p = (f = this._productBlock.addToCartForm()) == null ? void 0 : f.currentVariantId();
      p && this._product.variants.some((m) => m.id == p) && (h = p), this._currentVariantId = h;
    } else
      this._currentVariantId = this._product.selectedVariantId || this._product.variants[0].id;
    this._initialize();
  }
  _initialize() {
    S(
      this._dealBlockElement,
      "deal-block-id",
      this._dealBlockSettings.id
    ), S(
      this._dealBlockElement,
      "config",
      JSON.stringify(this._globalConfig)
    ), S(
      this._dealBlockElement,
      "translations",
      JSON.stringify(this._translations)
    ), S(
      this._dealBlockElement,
      "deal-block",
      JSON.stringify(this._dealBlockSettings)
    ), S(
      this._dealBlockElement,
      "product",
      JSON.stringify(this._product)
    ), S(
      this._dealBlockElement,
      "current-variant-id",
      String(this._currentVariantId)
    ), S(
      this._dealBlockElement,
      "other-products",
      JSON.stringify(this._otherProductsFromLiquid)
    ), this._loadMediaImagesAsync(), this._loadOtherProductsAsync(), this._loadCollectionBreaksProductsAsync(), this._loadComplementaryProductsAsync(), this._loadNativeBundleProductIdsAsync();
    const t = !!this._productBlock.addToCartForm(), e = !t && this._globalConfig.featureFlags.intercept_cart_request === !0 && !!this._globalConfig.customSelectors.addToCartButton;
    !t && !e || this._addEventListeners(e);
  }
  async _loadMediaImagesAsync() {
    if (!this._globalConfig.storefrontAccessToken)
      return;
    const t = new q(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken
    ), e = zt(this._dealBlockSettings), i = await $t(t, e, 300);
    S(
      this._dealBlockElement,
      "media-images",
      JSON.stringify(i)
    );
  }
  async _loadOtherProductsAsync() {
    if (!this._globalConfig.storefrontAccessToken)
      return;
    const t = ie(this._dealBlockSettings);
    if (!t.length)
      return;
    const e = new Set(
      this._otherProductsFromLiquid.map((s) => s.id)
    ), i = t.filter(
      (s) => !e.has(It(s))
    ), n = new q(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken
    ), a = i.length ? await G(n, {
      country: this._country,
      language: this._language,
      productIds: i,
      includeSellingPlans: this._globalConfig.includeSellingPlans,
      includeAvailableQuantity: this._globalConfig.includeAvailableQuantity,
      useExternalMetafieldNamespace: !1
    }) : [], o = [...this._otherProductsFromLiquid, ...a];
    await H(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken,
      o,
      [this._dealBlockSettings]
    ), S(
      this._dealBlockElement,
      "other-products",
      JSON.stringify(o)
    );
  }
  async _loadCollectionBreaksProductsAsync() {
    if (!this._globalConfig.storefrontAccessToken)
      return;
    const { collectionBreaksEnabled: t, collectionBreaks: e } = this._dealBlockSettings;
    if (!t || !e)
      return;
    const i = new q(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken
    );
    let n;
    e.visibility === "deal-products" ? n = await nt(i, {
      country: this._country,
      language: this._language,
      blockVisibility: this._dealBlockSettings.blockVisibility,
      excludedProductGIDs: (this._dealBlockSettings.excludedProductIds || []).map((o) => `gid://shopify/Product/${o}`),
      selectedProductGIDs: (this._dealBlockSettings.selectedProductIds || []).map((o) => `gid://shopify/Product/${o}`),
      selectedCollectionGIDs: (this._dealBlockSettings.selectedCollectionIds || []).map((o) => `gid://shopify/Collection/${o}`)
    }) : n = await nt(i, {
      country: this._country,
      language: this._language,
      blockVisibility: e.visibility,
      excludedProductGIDs: (e.excludedProducts || []).map(
        ({ id: o }) => o
      ),
      selectedProductGIDs: (e.selectedProducts || []).map(
        ({ id: o }) => o
      ),
      selectedCollectionGIDs: (e.selectedCollections || []).map(({ id: o }) => o)
    });
    let a = await G(i, {
      country: this._country,
      language: this._language,
      productIds: n.map((o) => Number(o.split("/").pop())),
      includeSellingPlans: this._globalConfig.includeSellingPlans,
      includeAvailableQuantity: this._globalConfig.includeAvailableQuantity,
      useExternalMetafieldNamespace: !1,
      batchSize: 20,
      onBatchError: (o) => {
        var s;
        return vt(o.message, (s = o.stack) != null ? s : "", 1);
      }
    });
    a = a.filter(
      (o) => o.availableForSale
    ), a.sort((o, s) => o.id === this._product.id ? -1 : s.id === this._product.id ? 1 : 0), await H(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken,
      a,
      [this._dealBlockSettings]
    ), S(
      this._dealBlockElement,
      "collection-breaks-products",
      JSON.stringify(a)
    ), setTimeout(() => {
      this._preloadImages(a);
    }, 1e3);
  }
  async _loadComplementaryProductsAsync() {
    var a, o;
    if (!(this._dealBlockSettings.dealBars.some(
      (s) => {
        var l;
        return (l = s.upsells) == null ? void 0 : l.some(
          (c) => c.productSource === "complementary"
        );
      }
    ) || ((o = (a = this._dealBlockSettings.checkboxUpsells) == null ? void 0 : a.upsells) == null ? void 0 : o.some(
      (s) => s.productSource === "complementary"
    ))) || !this._globalConfig.storefrontAccessToken)
      return;
    const e = new q(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken
    ), i = await Lt(
      e,
      {
        country: this._country,
        language: this._language,
        productId: this._product.id
      }
    );
    if (!i.length)
      return;
    let n = await G(e, {
      country: this._country,
      language: this._language,
      productIds: i.map(
        (s) => Number(s.split("/").pop())
      ),
      includeSellingPlans: this._globalConfig.includeSellingPlans,
      includeAvailableQuantity: this._globalConfig.includeAvailableQuantity,
      useExternalMetafieldNamespace: !1
    });
    n = n.filter(
      (s) => s.availableForSale
    ), await H(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken,
      n,
      [this._dealBlockSettings]
    ), S(
      this._dealBlockElement,
      "complementary-products",
      JSON.stringify(n)
    );
  }
  async _loadNativeBundleProductIdsAsync() {
    if (!this._globalConfig.storefrontAccessToken)
      return;
    const t = [
      this._product,
      ...this._otherProductsFromLiquid
    ].filter((n) => n.isNativeBundle === null);
    if (t.length === 0)
      return;
    const e = new q(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken
    ), i = await xt(
      e,
      t.map((n) => n.id)
    );
    i.length > 0 && S(
      this._dealBlockElement,
      "native-bundle-product-ids",
      JSON.stringify(i)
    );
  }
  _preloadImages(t) {
    for (const e of t) {
      const i = e.variants[0].image || e.image;
      if (i) {
        const n = new Image();
        n.src = i;
      }
    }
  }
  _addEventListeners(t) {
    if (this._listenForVariantUrlChange(), this._listenForQuantityInputChange(), this._listenForBlockVariantSelect(), this._listenForBlockDealBarSelect(), this._listenForBlockItemsChange(), this._listenForBlockAddToCartRequested(), t || (this._listenForFormVariantIdChange(), this._listenForFormSellingPlanChange()), this._listenForAmountDiscountExceedsPrice(), this._listenForUpsellSubscriptionInherited(), !window.kachingBundlesDisableAddToCartHandling) {
      if (this._globalConfig.featureFlags.intercept_cart_request) {
        F.setCartChangeRewriteEnabled(
          this._globalConfig.featureFlags.cart_change_response_rewrite === !0
        ), F.setDedupeEnabled(
          this._globalConfig.featureFlags.cart_interceptor_dedupe_disabled !== !0
        ), F.start();
        const e = this._dealBlockSettings.nanoId || this._dealBlockSettings.id;
        F.registerDeal(e, this._product, () => this._items);
      }
      this._listenForAddToCartClick();
    }
  }
  _listenForBlockAddToCartRequested() {
    D(
      this._dealBlockElement,
      "add-to-cart-requested",
      async (t) => {
        var n, a;
        const e = (n = t.detail) == null ? void 0 : n.items;
        if (!(e != null && e.length))
          return;
        d("add-to-cart-requested", e);
        const i = (a = this._productBlock.addToCartButton()) == null ? void 0 : a.button;
        if (i) {
          this._overrideItemsForNextAddToCart = e, i.click();
          return;
        }
        await this._makeAddToCartRequest({ items: e }), window.location.href = J("checkout");
      }
    );
  }
  /* Native variant change handling */
  _listenForVariantUrlChange() {
    wt(), D(ut, "locationchange", () => {
      const e = new URLSearchParams(ut.location.search).get("variant");
      e && (d("listenForVariantUrlChange", e), this._handleNativeVariantChange(Number(e)));
    });
  }
  _listenForFormVariantIdChange() {
    const t = this._productBlock.addToCartForm();
    t && t.onVariantIdChange((e) => {
      d("listenForFormVariantIdChange", e), this._handleNativeVariantChange(e);
    });
  }
  _handleNativeVariantChange(t) {
    if (d("handleNativeVariantChange", {
      variantId: t,
      currentVariantId: this._currentVariantId
    }), t != this._currentVariantId && this._product.variants.find((e) => e.id == t)) {
      if (this._globalConfig.featureFlags.remove_variant_change_delay ? window.kachingBundlesCurrentVariantChangeInProgress || (this._currentVariantId = t) : this._currentVariantId = t, this._globalConfig.featureFlags.remove_variant_change_delay) {
        if (window.kachingBundlesCurrentVariantChangeInProgress) {
          d("handleNativeVariantChange", "skipping");
          return;
        }
      } else if (this._dealBlockElement.dataset.nativeVariantChangeInProgress || window.kachingBundlesCurrentVariantChangeInProgress) {
        d("handleNativeVariantChange", "skipping");
        return;
      }
      this._dealBlockElement.dataset.nativeVariantChangeInProgress = "true", setTimeout(
        () => {
          delete this._dealBlockElement.dataset.nativeVariantChangeInProgress;
        },
        this._globalConfig.featureFlags.remove_variant_change_delay ? 1e3 : 500
      ), S(
        this._dealBlockElement,
        "current-variant-id",
        String(t)
      );
    }
  }
  _listenForFormSellingPlanChange() {
    if (!this._globalConfig.featureFlags.observe_form_selling_plan)
      return;
    const t = this._productBlock.addToCartForm();
    if (t) {
      try {
        !!A(
          'input[name="selling_plan"][type="radio"]',
          t.form
        ) && y("selling_plan_radio_detected", {
          dealBlockId: this._dealBlockSettings.id,
          productId: this._product.id
        });
      } catch {
      }
      t.onSellingPlanChange((e) => {
        d("listenForFormSellingPlanChange", e), S(
          this._dealBlockElement,
          "selling-plan-id",
          e ? String(e) : ""
        );
      });
    }
  }
  /* Native quantity input */
  _listenForQuantityInputChange() {
    this._productBlock.onQuantityInputChange((t) => {
      if (d("_listenForQuantityInputChange", t), !window.kachingBundlesQuantityChangeInProgress) {
        if (!this._globalConfig.keepQuantityInput || window.kachingBundlesCurrentVariantChangeInProgress || this._dealBlockElement.dataset.nativeVariantChangeInProgress) {
          this._changeQuantityInput();
          return;
        }
        this._globalConfig.keepQuantityInput && S(this._dealBlockElement, "quantity", String(t));
      }
    });
  }
  _changeQuantityInput() {
    const t = this._productBlock.quantityInput();
    if (!t || this._items.length === 0 || window.kachingBundlesDisableAddToCartHandling && !this._globalConfig.keepQuantityInput)
      return;
    const i = this._items.filter(
      (n) => this._isMainProductItem(n)
    ).reduce(
      (n, a) => n + a.quantity,
      0
    );
    this._setQuantityInputValue(t, i);
  }
  _setQuantityInputValue(t, e) {
    window.kachingBundlesQuantityChangeInProgress = !0, d("_setQuantityInputValue", e), t.value = String(e), this._globalConfig.shopifyDomain === "119a01-bf.myshopify.com" && t.dispatchEvent(new Event("input", { bubbles: !0 })), t.dispatchEvent(new Event("change", { bubbles: !0 })), setTimeout(() => {
      delete window.kachingBundlesQuantityChangeInProgress;
    }, 100);
  }
  /* Block variants change handling */
  _listenForBlockVariantSelect() {
    D(this._dealBlockElement, "variant-selected", (t) => {
      const { variantId: e } = t.detail;
      d("listenForBlockVariantSelect", e), this._changeCurrentVariant(e);
    });
  }
  _listenForBlockDealBarSelect() {
    this._globalConfig.webPixel && this._dealBlockElement.addEventListener("deal-bar-selected", (t) => {
      const { dealBarId: e } = t.detail, i = this._dealBlockSettings.dealBars.find(
        (a) => a.id === e
      ), n = (i == null ? void 0 : i.dealBarType) === "sku" && i.productGID ? Number(i.productGID.split("/").pop()) : this._product.id;
      ft(() => {
        window.Shopify.analytics.publish("kaching_deal_bar_selected", {
          product_id: n,
          deal_block_id: this._dealBlockSettings.id,
          deal_bar_id: e,
          ab_test_variant_id: this._dealBlockSettings.abTestVariantId
        });
      });
    });
  }
  _listenForBlockItemsChange() {
    D(this._dealBlockElement, "items-changed", () => {
      var n, a, o;
      clearTimeout(this._updateQuantityInputTimeoutHandle);
      const t = this._dealBlockElement.pricing();
      this._items = this._dealBlockElement.items(), I("Selected items changed", this._items);
      const e = this._items.filter(
        (s) => this._isMainProductItem(s)
      ), i = e.find((s) => s.id == this._currentVariantId) || e[0];
      if (i) {
        if (this._changeCurrentVariant(i.id), (n = this._productBlock.addToCartForm()) == null || n.updateItem(i), this._changeQuantityInput(), (a = this._productBlock.addToCartButton()) == null || a.updatePrice(t.discountedPrice, t.fullPrice), clearTimeout(this._updateAddToCartButtonPriceTimeoutHandle), this._updateAddToCartButtonPriceTimeoutHandle = setTimeout(
          () => {
            var s;
            return (s = this._productBlock.addToCartButton()) == null ? void 0 : s.updatePrice(t.discountedPrice, t.fullPrice);
          },
          2e3
        ), (o = this._productBlock.addToCartForm()) == null || o.toggleAcceleratedCheckoutButtons(
          this._shouldShowAcceleratedCheckoutButtons()
        ), this._isFirstVariantChange && (this._updateQuantityInputTimeoutHandle = setTimeout(() => {
          this._changeQuantityInput(), delete this._updateQuantityInputTimeoutHandle;
        }, 1e3), this._isFirstVariantChange = !1), this._dealBlockSettings.updateNativePrice) {
          clearTimeout(this._updateNativePriceTimeoutHandle);
          const s = this._dealBlockSettings.updateNativePriceType === "item" ? t.discountedPricePerItem : t.discountedPrice, l = this._dealBlockSettings.updateNativePriceType === "item" ? t.fullPricePerItem : t.fullPrice;
          this._productBlock.updatePrice(s, l), this._updateNativePriceTimeoutHandle = setTimeout(() => {
            this._productBlock.updatePrice(s, l);
          }, 1e3);
        }
        this._reconvertPrices();
      }
    });
  }
  _reconvertPrices() {
    var t, e, i, n;
    d("reconvertPrices");
    try {
      (t = window.bucksCC) != null && t.reConvert && window.bucksCC.reConvert(), (e = window.baCurr) != null && e.refreshConversion && window.baCurr.refreshConversion(), (i = window.DoublyGlobalCurrency) != null && i.convertAll && window.DoublyGlobalCurrency.convertAll(), (n = window.conversionBearAutoCurrencyConverter) != null && n.convertPricesOnPage && window.conversionBearAutoCurrencyConverter.convertPricesOnPage(), window.mlvedaload && window.mlvedaload();
    } catch (a) {
      console.error(a);
    }
  }
  _changeCurrentVariant(t) {
    const e = this._product.variants.find((a) => a.id == t);
    if (d("_changeCurrentVariant", {
      variantId: t,
      currentVariantId: this._currentVariantId
    }), this._currentVariantId == t || (this._currentVariantId = t, !e))
      return;
    const i = this._productBlock.variantPicker();
    if (!i)
      return;
    (this._globalConfig.featureFlags.remove_variant_change_delay ? !this._dealBlockElement.dataset.nativeVariantChangeInProgress : !0) && (clearTimeout(window.kachingBundlesCurrentVariantChangeInProgress), window.kachingBundlesCurrentVariantChangeInProgress = setTimeout(() => {
      delete window.kachingBundlesCurrentVariantChangeInProgress;
    }, 1e3));
    for (const [a, o] of e.options.entries()) {
      const s = this._product.options[a], l = s.name, c = s.optionValues.find(
        (u) => u.name === o
      ).id;
      i.select(
        a + 1,
        c,
        l,
        o,
        this._product.id,
        e.id
      );
    }
  }
  _listenForAmountDiscountExceedsPrice() {
    document.addEventListener(
      "kaching-bundles-amount-discount-exceeds-price",
      (t) => {
        var n;
        const { totalDiscount: e, fullOrderPrice: i } = t.detail;
        y("amount_discount_exceeds_price_v3", {
          dealBlockId: this._dealBlockSettings.id,
          productId: this._product.id,
          country: this._country,
          currency: (n = window.Shopify.currency) == null ? void 0 : n.active,
          totalDiscount: e,
          fullOrderPrice: i
        });
      },
      { once: !0 }
    );
  }
  _listenForUpsellSubscriptionInherited() {
    document.addEventListener(
      "kaching-bundles-upsell-subscription-inherited",
      (t) => {
        const { type: e } = t.detail;
        y("upsell_subscription_inherited", {
          dealBlockId: this._dealBlockSettings.id,
          productId: this._product.id,
          upsellType: e
        });
      },
      { once: !0 }
    );
  }
  /* Add to cart */
  _refreshItemsBeforeAddToCart() {
    var i, n;
    this._dealBlockElement.rotateBundleNonce(), this._overrideItemsForNextAddToCart ? (this._items = this._overrideItemsForNextAddToCart, this._overrideItemsForNextAddToCart = void 0) : this._items = this._dealBlockElement.items();
    const t = this._items.filter(
      (a) => this._isMainProductItem(a)
    ), e = (i = t.find((a) => a.id == this._currentVariantId)) != null ? i : t[0];
    e && ((n = this._productBlock.addToCartForm()) == null || n.updateItem(e));
  }
  _listenForAddToCartClick() {
    const t = this._productBlock.addToCartButton();
    if (!t)
      return;
    t.setValidation(() => {
      var a;
      return !this._dealBlockSettings.collectionBreaksEnabled || !((a = this._dealBlockSettings.collectionBreaks) != null && a.requireItemSelectionEnabled) ? !0 : this._dealBlockElement.validateItemSelection().valid;
    }), t.onClick(() => {
      if (this._globalConfig.featureFlags.intercept_cart_request) {
        const a = this._dealBlockSettings.nanoId || this._dealBlockSettings.id;
        F.setFallbackDeal(a, this._product);
      }
      this._refreshItemsBeforeAddToCart();
    });
    const e = () => window.kachingBundlesDisableAddToCartHandling ? !1 : this._dealBlockSettings.skipCart || this._isUpcartAppEnabled() || this._isOpusAppEnabled() || this._isKrakenCartAppEnabled() ? !0 : this._globalConfig.featureFlags.intercept_cart_request ? !1 : this._items.length > 1, i = async () => {
      var a;
      if (this._dealBlockSettings.skipCart) {
        await this._addAllItemsToCart(), window.kachingCartApi && (d("Kaching Cart update tiered promotions bar"), await window.kachingCartApi.updateTieredPromotionsBar()), window.location.href = J("checkout");
        return;
      }
      if (this._isUpcartAppEnabled()) {
        try {
          window.upcartOpenCart && window.upcartOpenCart();
        } catch (o) {
          console.error("upcartOpenCart error", o);
        }
        await this._addAllItemsToCart(), window.upcartRefreshCart && window.upcartRefreshCart();
        return;
      }
      if (this._isOpusAppEnabled()) {
        try {
          window.opusOpen && window.opusOpen();
        } catch (o) {
          console.error("opusOpen error", o);
        }
        await this._addAllItemsToCart(), window.opusRefreshCart && window.opusRefreshCart();
        return;
      }
      if (this._isKrakenCartAppEnabled()) {
        try {
          (a = window.KrakenCart) != null && a.toggleCart && window.KrakenCart.toggleCart(!0);
        } catch (o) {
          console.error("KrakenCart error", o);
        }
        await this._addAllItemsToCart();
        return;
      }
      return this._addItemsExceptCurrentToCart();
    }, n = () => this._dealBlockSettings.skipCart || this._isUpcartAppEnabled() || this._isOpusAppEnabled() || this._isKrakenCartAppEnabled();
    t.onClickIfConditionMet(
      e,
      i,
      n
    ), !this._globalConfig.featureFlags.intercept_cart_request && (this._setupUpcart(), this._setupOpus(), this._setupKrakenCart());
  }
  _setupUpcart() {
    window.upcartShouldSkipAddToCartInterceptor = !0;
    const t = window.upcartShouldSkipAddToCart;
    window.upcartShouldSkipAddToCart = (e) => typeof t == "function" && t(e) === !0 ? !0 : e.includes("kaching_bundles=true");
  }
  _setupOpus() {
    [
      "the-gloria-skincare.myshopify.com",
      "xzxihx-8t.myshopify.com",
      "e76602-61.myshopify.com"
    ].includes(this._globalConfig.shopifyDomain) && (window.OpusNoATC = !0);
  }
  _setupKrakenCart() {
    window.krakenCartIsFormATCEnabled = !1;
  }
  _isUpcartAppEnabled() {
    return this._globalConfig.featureFlags.intercept_cart_request || this._globalConfig.shopifyDomain === "qu1udi-ws.myshopify.com" ? !1 : !!A("#UpcartPopup") || !!window.upcartDocumentOrShadowRoot;
  }
  _isOpusAppEnabled() {
    return this._globalConfig.featureFlags.intercept_cart_request || ![
      "the-gloria-skincare.myshopify.com",
      "xzxihx-8t.myshopify.com",
      "e76602-61.myshopify.com"
    ].includes(this._globalConfig.shopifyDomain) ? !1 : window.opusActive || !1;
  }
  _isKrakenCartAppEnabled() {
    var t;
    return this._globalConfig.featureFlags.intercept_cart_request ? !1 : ((t = window.KrakenCart) == null ? void 0 : t.isActive) && window.KrakenCart.isActive() || !1;
  }
  async _addItemsExceptCurrentToCart() {
    var l;
    d("addItemsExceptCurrentToCart", this._items);
    const t = (l = this._productBlock.addToCartForm()) == null ? void 0 : l.currentVariantId();
    setTimeout(() => {
      t != this._currentVariantId && y("different_current_variant_v3", {
        form: t,
        object: this._currentVariantId
      });
    });
    const e = this._items.findIndex(
      (c) => this._isMainProductItem(c) && c.id == t
    ), i = this._items.filter(
      (c, u) => u !== e
    ), n = i.filter((c) => c.parent_id), a = i.filter((c) => !c.parent_id), o = [
      ...n.reverse(),
      ...a
    ].map(({ parent_id: c, ...u }) => u);
    I("Adding only extra items to cart", o);
    const s = e >= 0 ? this._items[e] : void 0;
    if (s) {
      const c = this._productBlock.quantityInput();
      c && this._setQuantityInputValue(c, s.quantity);
    }
    await this._makeAddToCartRequest({
      items: o,
      partial: !0
    });
  }
  async _addAllItemsToCart() {
    var e, i;
    d("addAllItemsToCart", this._items);
    let t = this._items;
    t.length === 0 && (t = [
      {
        id: (i = (e = this._productBlock.addToCartForm()) == null ? void 0 : e.currentVariantId()) != null ? i : this._currentVariantId,
        quantity: 1,
        properties: {}
      }
    ]), I("Adding all items to cart", t), await this._makeAddToCartRequest({ items: t });
  }
  _collectProperties() {
    const e = C(
      '[name^="properties"]'
    ).map((i) => [i.name.match(/properties\[(.*)\]/)[1], i.value]).filter(([i]) => i !== "__kaching_bundles");
    return Object.fromEntries(e);
  }
  _isMainProductItem(t) {
    const e = this._kachingBundlesProperty(t);
    return e ? e.main || !1 : !0;
  }
  _shouldShowAcceleratedCheckoutButtons() {
    var t;
    return this._items.length > 1 ? !1 : !this._dealBlockSettings.collectionBreaksEnabled || !((t = this._dealBlockSettings.collectionBreaks) != null && t.requireItemSelectionEnabled) ? !0 : this._dealBlockElement.isItemSelectionValid();
  }
  _kachingBundlesProperty(t) {
    return t.properties.__kaching_bundles ? JSON.parse(
      t.properties.__kaching_bundles
    ) : null;
  }
  async _makeAddToCartRequest({
    items: t,
    partial: e = !1
  }) {
    const i = this._collectProperties(), n = t.map((s) => {
      var l;
      return !this._isMainProductItem(s) && !((l = this._kachingBundlesProperty(s)) != null && l.collectionBreaksProduct) ? s : {
        ...s,
        properties: { ...i, ...s.properties }
      };
    });
    setTimeout(() => this._logCollectionBreakProperties(i));
    const a = { kaching_bundles: "true" };
    e && (a.partial = "true");
    const o = {
      "Content-Type": "application/json"
    };
    e || (o["X-Kaching-Cart-Ignore"] = "1"), await fetch(J("cart/add.js", a), {
      method: "POST",
      body: JSON.stringify({ items: n }),
      headers: o
    });
  }
  _logCollectionBreakProperties(t) {
    if (!this._dealBlockSettings.collectionBreaksEnabled)
      return;
    const e = Object.fromEntries(
      Object.entries(t).filter(
        ([i]) => !i.startsWith("__kaching_")
      )
    );
    Object.keys(e).length !== 0 && y("collection_break_properties", {
      properties: e
    });
  }
}
class Le {
  constructor(t) {
    this._submitInProgress = !1, this._ignoreClick = !1, this._clickHandler = null, this._onClickCallback = null, this._validationCallback = null, this._horizonAnimationDisabled = !1, this.button = t;
  }
  onClick(t) {
    this._onClickCallback = t;
  }
  setValidation(t) {
    this._validationCallback = t;
  }
  onClickIfConditionMet(t, e, i) {
    this._clickHandler = {
      condition: t,
      callback: e,
      shouldPreventDefault: i
    }, this._registerClickHandler();
  }
  replaceButton(t) {
    I("New add to cart button", { button: t }), this.button = t, this._clickHandler && this._registerClickHandler();
  }
  _registerClickHandler() {
    if (!this._clickHandler)
      return;
    this._setupHorizonThemeHandling();
    const t = async (i) => {
      const n = this._submitInProgress || this._ignoreClick;
      if (this._onClickCallback && !n && this._onClickCallback(), this._validationCallback && !this._validationCallback()) {
        i.preventDefault(), i.stopPropagation(), i.stopImmediatePropagation();
        return;
      }
      const a = this._clickHandler.condition(), o = this._clickHandler.shouldPreventDefault();
      if (this._ignoreClick || I("Add to cart button clicked"), d("AddToCartButton#interceptClick", {
        conditionMet: a,
        preventDefault: o,
        submitInProgress: this._submitInProgress,
        ignoreClick: this._ignoreClick
      }), !!a) {
        if (this._submitInProgress) {
          this._submitInProgress = !1;
          return;
        }
        if (!this._ignoreClick) {
          if (this._submitInProgress = !0, this._ignoreClick = !0, this.button.disabled = !0, setTimeout(() => {
            this._ignoreClick = !1;
          }, 1e3), i.preventDefault(), i.stopPropagation(), i.stopImmediatePropagation(), await this._clickHandler.callback(), this.button.disabled = !1, o) {
            this._submitInProgress = !1;
            return;
          }
          await new Promise((s) => setTimeout(s, 200)), this.button.click();
        }
      }
    };
    this.button.addEventListener("click", t, !0);
  }
  updatePrice(t, e) {
    const i = this._findAllAddToCartPriceElements(this.button);
    if (i.length === 0)
      return;
    const n = i.find(
      (o) => this._isCompareAtPriceElement(o)
    ), a = i.find((o) => o !== n) || i[0];
    a.innerHTML = t.amount > 0 ? t.formatted : "", n && n !== a && (e.amount > t.amount && t.amount > 0 ? (n.innerHTML = e.formatted, n.style.display = "") : n.innerHTML = "");
  }
  _setupHorizonThemeHandling() {
    const t = this.button.closest("add-to-cart-component");
    t && this.button.addEventListener(
      "pointerdown",
      () => {
        this._validationCallback && !this._validationCallback() ? (t.setAttribute("data-add-to-cart-animation", "false"), this._horizonAnimationDisabled = !0) : this._horizonAnimationDisabled && (t.setAttribute("data-add-to-cart-animation", "true"), this._horizonAnimationDisabled = !1);
      },
      !0
    );
  }
  _isPriceNode(t) {
    var i;
    const e = (i = t.childNodes[0]) == null ? void 0 : i.nodeValue;
    return !!(e && e.match(/\d/) && !e.match(/\p{L}{4}/u) && !e.includes("%"));
  }
  _findAllAddToCartPriceElements(t) {
    const e = [];
    if (!t.childNodes.length)
      return e;
    if (this._isPriceNode(t))
      return e.push(t), e;
    for (const i of t.childNodes)
      e.push(...this._findAllAddToCartPriceElements(i));
    return e;
  }
  _isCompareAtPriceElement(t) {
    let e = t;
    for (; e && e !== this.button; ) {
      const i = e.tagName;
      if (i === "S" || i === "DEL" || i === "STRIKE" || /compare/i.test(e.className || "") || getComputedStyle(e).textDecorationLine.includes("line-through"))
        return !0;
      e = e.parentElement;
    }
    return !1;
  }
}
class $e {
  constructor(t, e, i, n) {
    this._acceleratedCheckoutButtonsEnabled = !0, this._currentItem = null, this._variantIdChangeCallback = null, this._sellingPlanChangeCallback = null, this._variantIdIntervalId = null, this._sellingPlanObserver = null, this._sellingPlanChangeHandler = null, d("AddToCartForm", {
      form: t,
      addQuantityInput: e,
      allowSellingPlanUpdate: i
    }), this.form = t, this._addQuantityInput = e, this._allowSellingPlanUpdate = i, this._abTestRunning = n, this._addAbTestSessionId();
  }
  _addAbTestSessionId() {
    if (!this._abTestRunning)
      return;
    const t = this._findOrCreateInput(
      "properties[__kaching_session_id]"
    );
    t.value = W();
  }
  updateItem(t) {
    d("AddToCartForm#updateItem", [this.form, t]), this._currentItem = t, this._updateIdInput(t.id), this._updateQuantityInput(t.quantity), this._updateKachingBundlesPropertyInput(t.properties), this._updateSellingPlanInput(t.selling_plan);
  }
  currentVariantId() {
    const t = this._findVariantIdElement();
    if (t)
      return Number(t.value);
  }
  onVariantIdChange(t) {
    this._variantIdChangeCallback = t, this._registerVariantIdObserver();
  }
  _registerVariantIdObserver() {
    if (!this._variantIdChangeCallback)
      return;
    this._variantIdIntervalId !== null && (window.clearInterval(this._variantIdIntervalId), this._variantIdIntervalId = null);
    const t = this._variantIdChangeCallback, e = this._findVariantIdElement();
    if (e instanceof HTMLInputElement && X(e, "value", (i, n) => {
      i !== n && n && t(Number(n));
    }), e instanceof HTMLSelectElement) {
      let i;
      this._variantIdIntervalId = window.setInterval(() => {
        const n = e.value;
        i !== n && n && (i = n, t(Number(n)));
      }, 100);
    }
  }
  onSellingPlanChange(t) {
    this._sellingPlanChangeCallback = t, this._registerSellingPlanObserver();
  }
  _registerSellingPlanObserver() {
    if (this._allowSellingPlanUpdate || !this._sellingPlanChangeCallback)
      return;
    this._sellingPlanObserver && (this._sellingPlanObserver.disconnect(), this._sellingPlanObserver = null);
    const t = this._sellingPlanChangeCallback;
    let e;
    const i = (o) => {
      e !== o && (e = o, t(o ? Number(o) : void 0));
    };
    let n = null;
    const a = () => {
      var l;
      const o = this._findInput("selling_plan");
      o !== n && (n = o, o && X(o, "value", (c, u) => {
        i(u);
      })), this._sellingPlanChangeHandler || (this._sellingPlanChangeHandler = (c) => {
        const u = c.target;
        u.name === "selling_plan" && i(u.value);
      }, this.form.addEventListener("change", this._sellingPlanChangeHandler));
      const s = A(
        'input[name="selling_plan"]:checked',
        this.form
      );
      i((l = s == null ? void 0 : s.value) != null ? l : o == null ? void 0 : o.value);
    };
    a(), this._sellingPlanObserver = new MutationObserver((o) => {
      o.some((s) => s.type === "childList") && a();
    }), this._sellingPlanObserver.observe(this.form, {
      childList: !0,
      subtree: !0
    });
  }
  toggleAcceleratedCheckoutButtons(t) {
    const e = "kaching-bundles-form--different-variants-selected";
    this._acceleratedCheckoutButtonsEnabled = t, t ? this.form.classList.remove(e) : this.form.classList.add(e);
  }
  _cleanupObservers() {
    this._variantIdIntervalId !== null && (window.clearInterval(this._variantIdIntervalId), this._variantIdIntervalId = null), this._sellingPlanObserver && (this._sellingPlanObserver.disconnect(), this._sellingPlanObserver = null), this._sellingPlanChangeHandler && (this.form.removeEventListener("change", this._sellingPlanChangeHandler), this._sellingPlanChangeHandler = null);
  }
  replaceForm(t) {
    I("New add to cart form", { form: t }), this._cleanupObservers(), this.form = t, this._addAbTestSessionId(), this.toggleAcceleratedCheckoutButtons(
      this._acceleratedCheckoutButtonsEnabled
    ), this._currentItem && this.updateItem(this._currentItem), this._registerVariantIdObserver(), this._registerSellingPlanObserver();
  }
  _updateIdInput(t) {
    const e = this._findVariantIdElement() || this._createInput("id"), i = String(t);
    this._ensureSelectOptionExists(e, i), e.disabled = !1, e.value = i;
  }
  _updateQuantityInput(t) {
    d("AddToCartForm#_updateQuantityInput", t);
    let e = null;
    this._addQuantityInput ? e = this._findOrCreateInput("quantity") : e = this._findInput("quantity"), e && (e.disabled = !1, e.value = String(t));
  }
  _updateKachingBundlesPropertyInput(t) {
    var e, i;
    if (t.__kaching_bundles) {
      const n = this._findOrCreateInput(
        "properties[__kaching_bundles]"
      );
      n.disabled = !1, n.value = this._encodeBundlesProperty(
        t.__kaching_bundles
      );
      const a = (i = (e = window.Shopify.theme) == null ? void 0 : e.schema_name) == null ? void 0 : i.toLowerCase();
      a != null && a.includes("pipeline") && (n.dataset.morphSkip = "true");
    } else {
      const n = this._findInput("properties[__kaching_bundles]");
      n == null || n.remove();
    }
  }
  _encodeBundlesProperty(t) {
    var i, n;
    const e = (n = (i = window.Shopify.theme) == null ? void 0 : i.schema_name) == null ? void 0 : n.toLowerCase();
    return e != null && e.includes("shrine pro") || e != null && e.includes("ascendify") ? btoa(t) : t;
  }
  _updateSellingPlanInput(t) {
    if (this._allowSellingPlanUpdate)
      if (t) {
        const e = this._findOrCreateInput("selling_plan");
        e.disabled = !1, e.value = String(t);
      } else {
        const e = this._findInput("selling_plan");
        e == null || e.remove();
      }
  }
  _findOrCreateInput(t) {
    return this._findInput(t) || this._createInput(t);
  }
  _ensureSelectOptionExists(t, e) {
    if (!(t instanceof HTMLSelectElement)) return;
    if (!Array.from(t.options).some(
      (n) => n.value === e
    )) {
      const n = Q("option");
      n.value = e, n.text = "", t.appendChild(n);
    }
  }
  _findInput(t) {
    return A(
      `[name="${t}"]`,
      this.form
    );
  }
  _findVariantIdElement() {
    return Array.from(this.form.elements).find(
      (t) => (t instanceof HTMLInputElement || t instanceof HTMLSelectElement) && t.name === "id"
    ) || null;
  }
  _createInput(t) {
    const e = Q("input");
    return e.type = "hidden", e.name = t, this.form.prepend(e), e;
  }
}
const Y = "kaching-bundle, kaching-bundle-deals", bt = [
  'form[action*="/cart/add"]',
  "form[data-instant-form-product-url]",
  // Instant page builder
  'form[action$="/add"]'
], Z = [
  '[data-pf-type^="ProductATC"]',
  // PageFly sometimes uses ProductATC2
  "button.gp-button-atc",
  // Gempages
  "gp-product-button button",
  // Gempages v7
  "x-buy-button",
  // Minimog
  "button.button--addToCart",
  // Booster
  'button[type="submit"]',
  'input[type="submit"]'
], yt = [
  // Gempages
  [
    '[data-icon="gpicon-product-cartbutton"]',
    '[data-icon="gpicon-product-quantity"]'
  ],
  // Gempages v7
  ["gp-product-button", "gp-product-quantity"],
  // Dawn (and other free themes)
  ["product-form", ".product-form__quantity"],
  // Horizon
  [".buy-buttons-block", ".quantity-selector-wrapper"],
  // PageFly app
  ['[data-pf-type^="ProductATC"]', '[data-pf-type="ProductQuantity"]'],
  // PageFly sometimes uses ProductATC2
  // Debut
  [".product-form__item--submit", 'label[for="Quantity-product-template"]'],
  // Debutify
  [".product-single__add-to-cart", ".product-single__quantity"],
  // Impact
  [".product-info__buy-buttons", ".product-info__quantity-selector"],
  // Prestige
  [
    ".ProductForm__BuyButtons, .ProductForm__AddToCart",
    ".ProductForm__QuantitySelector"
  ],
  // Prestige (v7)
  ['[data-block-type="buy-buttons"]', '[data-block-type="quantity-selector"]'],
  // Envy
  [".product-page--submit-action", ".quantity-controls__outer"],
  // Warehouse
  [".product-form__payment-container", ".product-form__info-item--quantity"],
  // Atlantic
  ["[data-product-submit]", ".product-quantity-input"],
  // Empire
  [".product-form--atc", ".product-form--atc-qty"],
  // Turbo
  [".purchase-details", ".purchase-details__quantity"],
  // Expanse
  [".product-single__form .payment-buttons", ".product__quantity"],
  // Minimal
  [".product-form--wide", ".product-single__quantity"],
  // Brooklyn
  [".product-single__add-to-cart", ".product-single__quantity"],
  // Blockshop
  [".product-form--button-container", null],
  // Venture
  [".product-form__item--submit", ".product-form__item--quantity"],
  // Showcase
  [".product-detail__form__action", null],
  // Palo Alto
  [".product__submit__buttons", null],
  // Symmetry
  [".buy-buttons-row", ".quantity-wrapper"],
  // Kalles, Unsen
  [".t4s-product-form__buttons", "[data-quantity-wrapper]"],
  // Alchemy
  [".qty-wrapper--with-payment-button", ".product-qty"],
  // Baseline
  [".shopify-product-form", ".product-quantity-block"],
  // Shapes
  [".shopify-product-form", ".product-block-quantity-selector"],
  // Colors
  [".type_buy_buttons", ".type_quantity_selector"],
  // Motion
  [".product-single__form .add-to-cart", ".product__quantity"],
  // Avenue
  [".purchase-section", ".quantity.form"],
  // Ella
  [".product-form__buttons", ".quantity_selector"],
  // Booster
  [".product__atc", ".quantity--input"],
  // Focal
  [".product-form__payment-container", ".quantity-selector"],
  // EComposer
  [".ecom-product-single__add-to-cart", ".ecom-product-single__quantity"],
  // Solodrop
  [".product-form__submit", ".product__quantity"],
  // Enterprise
  [".product-info__add-to-cart", "quantity-input"],
  // Yuva
  [".yv-checkout-btn", ".yv-product-quantity"],
  // Reformation
  [".product-add-to-cart-container", "quantity-selector"],
  // Pipeline
  [".product__block__buttons", ".product__block__quantity"],
  // Minimog
  ["x-buy-button", "x-quantity-input"],
  // Xtra
  [".submit:has(.overlay-buy_button)", ".input-amount"],
  // Instant page builder
  [
    '[data-instant-action-type="redirect-to-cart"]',
    '[data-instant-type="container"]:has(> .instant-quantity-input)'
  ]
], xe = (r, t, e, i) => {
  if (d("_updateNativePrice", {
    discountedPrice: t,
    fullPrice: e
  }), e.amount > 0) {
    let n = C(
      "[data-kaching-price-compare]"
    );
    if (i.customSelectors.priceCompare && (n = C(
      i.customSelectors.priceCompare
    )), n.length > 0)
      for (const a of n)
        e.amount > t.amount ? (a.innerHTML = e.formatted, a.style.display = "") : a.style.display = "none";
    else {
      const a = [
        ".price--large .price__sale .price-item--regular",
        // Dawn, Shrine
        ".price--medium .price__sale .price-item--regular",
        // Be Yours
        ".lumin-price .price__sale .price-item--regular",
        // Architect, Beauty
        ".product-page-price .price__sale .price-item--regular",
        // Craft, Atlas
        ".f-price--large .f-price__sale .f-price-item--regular",
        // Sleek
        'gp-product-price div[type="compare"]',
        // Gempages
        "gp-product-price .gp-product-compare-price",
        // Gempages
        "product-price .compare-at-price",
        // Horizon
        ".pp-product-price .pp-price-item--sale",
        // Page Pilot
        ".product__price-and-badge .product__price--compare",
        // Palo Alto
        ".product-block--price span[data-compare-price]",
        // Impulse
        ".main-product__block-price .m-price__sale .m-price-item--regular",
        // Minimog
        ".product-info__price compare-at-price",
        // Impact
        '.product-info__block-item[data-block-type="price"] compare-at-price',
        // Prestige
        ".product-form__info-item .price--compare",
        // Warehouse
        '[data-product-type="compare_at_price"]',
        // PageFly
        ".product__price-wrapper .price__container .price__sale del",
        // Marble
        ".product__price-wrapper .price__container .product__price span:not(.visually-hidden)"
        // Marble
      ].flatMap((s) => C(s)), o = N(
        r,
        a
      );
      if (o) {
        o.innerHTML = e.formatted;
        const s = o.closest("gp-product-price");
        s instanceof HTMLElement && (s.dataset.hidden = e.amount > t.amount ? "false" : "true");
      }
    }
  }
  if (t.amount > 0) {
    let n = C("[data-kaching-price]");
    if (i.customSelectors.price && (n = C(
      i.customSelectors.price
    )), n.length > 0)
      for (const a of n)
        a.innerHTML = t.formatted;
    else {
      const a = [
        ".price--large .price__regular .price-item--regular",
        // Dawn, Shrine
        ".price--large .price__sale .price-item--sale",
        // Dawn, Shrine
        ".price--medium .price__regular .price-item--regular",
        // Be Yours
        ".price--medium .price__sale .price-item--sale",
        // Be Yours
        ".lumin-price .price__regular .price-item--regular",
        // Architect, Beauty
        ".lumin-price .price__sale .price-item--sale",
        // Architect, Beauty
        ".product-page-price .price__regular .price-item--regular",
        // Craft, Atlas
        ".product-page-price .price__sale .price-item--sale",
        // Craft, Atlas
        ".f-price--large .f-price__regular .f-price-item--regular",
        // Sleek
        ".f-price--large .f-price__sale .f-price-item--sale",
        // Sleek
        'gp-product-price div[type="regular"]',
        // Gempages
        "gp-product-price .gp-price:not(.gp-product-compare-price)",
        // Gempages
        "product-price .price",
        // Horizon
        ".pp-product-price .pp-price-item--regular",
        // Page Pilot
        ".product__price-and-badge .product__price--regular",
        // Palo Alto
        ".product-block--price span[data-product-price]",
        // Impulse
        ".main-product__block-price .m-price__sale .m-price-item--sale",
        // Minimog
        ".product-info__price sale-price",
        // Impact
        '.product-info__block-item[data-block-type="price"] sale-price',
        // Prestige
        ".product-form__info-item .price:not(.price--compare)",
        // Warehouse
        '[data-product-type="price"]',
        // PageFly
        ".product__price-wrapper .price__container .price__sale ins"
        // Marble
      ].flatMap((s) => C(s)), o = N(r, a);
      o && (o.innerHTML = t.formatted);
    }
  }
  if (t.amount > 0 && e.amount > 0) {
    const n = Math.round(
      (e.amount - t.amount) / e.amount * 100
    ), a = C("[data-kaching-price-badge]");
    if (a.length > 0)
      for (const o of a)
        n > 0 ? (o.innerHTML = o.innerHTML.replace(
          /\d+%/,
          `${n}%`
        ), o.style.display = "") : o.style.display = "none";
    else {
      const o = [
        ".price--large .price__badge-sale",
        // Dawn, Shrine
        ".lumin-price .price__badge-sale",
        // Architect
        ".product-page-price .price__badge-sale",
        // Craft, Atlas
        "gp-product-tag div[data-gp-text]",
        // Gempages
        ".product__price-and-badge span[data-price-off-amount]",
        // Palo Alto
        ".product-block--price span[data-save-price]",
        // Impulse
        ".product-info__price on-sale-badge"
        // Impact
      ].flatMap((l) => C(l)), s = N(r, o);
      s && (/\d/.test(s.innerHTML) && !s.innerHTML.includes("%") ? s.style.display = "none" : s.innerHTML = s.innerHTML.replace(/\d+%/, `${n}%`));
    }
  }
};
class L {
  static find(t, e) {
    let i = t.parentElement;
    for (; i; ) {
      if (e) {
        const o = C(
          e,
          i
        );
        if (o.length > 0)
          return new L(o);
      }
      const n = A(
        [
          "variant-selects",
          "variant-radios",
          "variant-picker",
          "product-variants",
          "gp-product-variants",
          ".gf_variants-wrapper",
          '[data-pf-type="ProductVariantSwatches"]',
          ".product-selectors",
          ".product-block-variant-picker",
          "dm-variant-selects",
          "simple-variant-picker"
        ].join(", "),
        i
      );
      if (n) return new L([n]);
      let a = C(
        [
          ".selector-wrapper",
          ".radio-wrapper",
          ".variant-wrapper",
          "div[data-product-option]",
          ".pp-variant-picker"
        ].join(", "),
        i
      );
      if (window.Shopify.shop && ["28212b.myshopify.com", "9bd9ad.myshopify.com"].includes(
        window.Shopify.shop
      ) && (a = C(
        ".selector-wrapper, .radio-wrapper, .variant-wrapper, .select-wrapper, div[data-product-option]",
        i
      )), a.length > 0) {
        const o = a.filter(
          (s) => !a.some(
            (l) => l !== s && l.contains(s)
          )
        );
        return new L(o);
      }
      i = i.parentElement;
    }
    return null;
  }
  constructor(t) {
    this._elements = t;
  }
  elements() {
    return this._elements;
  }
  hide() {
    for (const t of this._elements)
      t.style.display = "none", t.parentElement.classList.add(
        "kaching-bundles--variant-selects-hidden"
      );
  }
  select(t, e, i, n, a, o) {
    d("VariantPicker#select", [
      t,
      e,
      i,
      n
    ]), this._clickOptionWrapper(i, n) || this._clickRadioInput(
      t,
      e,
      i,
      n,
      a
    ) || this._setSelectValue(t, i, n) || this._setSelectVariantId(o) || this._clickButton(i, n);
  }
  // GemPages v7
  _clickOptionWrapper(t, e) {
    const n = this._elements.map((a) => C(".option-value-wrapper", a)).flat().find(
      (a) => a.getAttribute("option-data") === t && a.getAttribute("option-value") === e
    );
    return n ? (d("VariantPicker#_clickOptionWrapper", n), n.click(), !0) : !1;
  }
  _clickRadioInput(t, e, i, n, a) {
    const o = this._elements.map((c) => [...c.querySelectorAll("input")]).flat();
    let s = o.filter(
      (c) => [
        i,
        `${i}-${t}`,
        `options[${i}]`,
        `option${t}`,
        `option-${a}-${t - 1}`,
        `${a}-options-${i}`
      ].includes(c.name.trim())
    );
    s.length || (s = o.filter(
      (c) => c.dataset.optionPosition ? Number(c.dataset.optionPosition) === t : !1
    )), s.length || (s = o.filter((c) => c.type === "radio"));
    const l = s.find(
      (c) => c.value == n || c.value === String(e)
    );
    return l ? (d("VariantPicker#_clickRadioInput", l), l.click(), !0) : !1;
  }
  _setSelectValue(t, e, i) {
    const a = this._elements.map((s) => [...s.querySelectorAll("select")]).flat().find((s) => !!([`options[${e}]`, `option${t}`].includes(s.name) || s.dataset.index === `option${t}` || s.dataset.optionName === e || [
      `SingleOptionSelector-product-${t - 1}`,
      // PageFly
      `p-variant-dropdown-${t}`,
      // Gempages v6
      `option-${e.toLowerCase().replace(/ /g, "-")}`
    ].includes(s.id)));
    return !a || ![...a.options].find(
      (s) => s.value == i
    ) ? !1 : a.value === i ? (d("VariantPicker#_setSelectValue - already set", {
      variantSelect: a,
      optionValue: i
    }), !0) : (d("VariantPicker#_setSelectValue", { variantSelect: a, optionValue: i }), a.value = i, a.dispatchEvent(new Event("change", { bubbles: !0 })), !0);
  }
  _setSelectVariantId(t) {
    const i = this._elements.map((n) => [...n.querySelectorAll("select")]).flat().find(
      (n) => [...n.options].find((a) => Number(a.value) === t)
    );
    return i ? i.value === String(t) ? (d("VariantPicker#_setSelectVariantId - already set", {
      variantSelect: i,
      variantId: t
    }), !0) : (d("VariantPicker#_setSelectVariantId", { variantSelect: i, variantId: t }), i.value = String(t), i.dispatchEvent(new Event("change", { bubbles: !0 })), !0) : !1;
  }
  _clickButton(t, e) {
    const i = this._elements.find(
      (a) => a.getAttribute("data-product-option") === t
    );
    if (!i) return !1;
    const n = C("[data-value]", i).find(
      (a) => a.getAttribute("data-value") === e
    );
    return n ? (d("VariantPicker#_clickButton", n), n.click(), !0) : !1;
  }
}
class Re {
  constructor(t, e, i) {
    this._variantPicker = null, this._quantityInput = null, this._hiddenQuantityElement = null, this._onQuantityChange = null, this._addToCartForm = null, this._addToCartButton = null, this._placeholder = t, this._globalConfig = e, this._dealBlockSettings = i;
  }
  initialize() {
    this._findVariantPicker(), this._observeVariantPickerRemoval(), this._findQuantityInput(), this._listenForQuantityInputChange(), this._observeQuantityInputRemoval(), this._findAddToCartForm(), this._observeAddToCartFormRemoval(), this._findAddToCartButton(), this._moveAddToCartButtonOutOfQuantityElement(), this._observeAddToCartButtonRemoval();
  }
  variantPicker() {
    return this._variantPicker;
  }
  quantityInput() {
    return this._quantityInput;
  }
  addToCartForm() {
    return this._addToCartForm;
  }
  addToCartButton() {
    return this._addToCartButton;
  }
  onQuantityInputChange(t) {
    this._onQuantityChange = t;
  }
  updatePrice(t, e) {
    xe(
      this._placeholder,
      t,
      e,
      this._globalConfig
    );
  }
  _findVariantPicker() {
    const t = L.find(
      this._placeholder,
      this._globalConfig.customSelectors.variantPicker
    );
    t && (this._dealBlockSettings.hideVariantPicker && t.hide(), this._variantPicker = t);
  }
  _observeVariantPickerRemoval() {
    this._variantPicker && V(this._variantPicker.elements()[0], () => {
      var t, e;
      this._findVariantPicker(), I("New variant picker", {
        picker: (t = this._variantPicker) == null ? void 0 : t.elements()
      }), y(
        "variant_picker_removed",
        {
          recreated: !!this._variantPicker,
          theme: (e = window.Shopify.theme) == null ? void 0 : e.schema_name
        },
        0.01
      ), this._observeVariantPickerRemoval();
    });
  }
  _findQuantityInput() {
    const t = this._findQuantityElements(), i = N(
      this._placeholder,
      t,
      6
    );
    if (!i)
      return;
    this._globalConfig.keepQuantityInput || (this._hiddenQuantityElement = i, i.style.display = "none");
    const n = i.matches("input") ? i : i.querySelector("input");
    this._quantityInput = n;
  }
  _listenForQuantityInputChange() {
    this._quantityInput && (D(this._quantityInput, "change", () => {
      this._onQuantityChange && this._onQuantityChange(Number(this._quantityInput.value));
    }), X(this._quantityInput, "value", (t, e) => {
      t !== e && this._onQuantityChange && this._onQuantityChange(Number(e));
    }));
  }
  _observeQuantityInputRemoval() {
    this._quantityInput && V(this._quantityInput, () => {
      var t;
      this._findQuantityInput(), this._listenForQuantityInputChange(), this._moveAddToCartButtonOutOfQuantityElement(), I("New quantity input", {
        input: this._quantityInput
      }), y(
        "quantity_input_removed",
        {
          recreated: !!this._quantityInput,
          theme: (t = window.Shopify.theme) == null ? void 0 : t.schema_name
        },
        0.01
      ), this._observeQuantityInputRemoval();
    });
  }
  _findQuantityElements() {
    const t = this._globalConfig.customSelectors.quantity;
    if (t) {
      const e = C(t);
      if (e.length)
        return e;
    }
    for (const [e, i] of yt) {
      if (!i)
        continue;
      const n = C(i);
      if (n.length)
        return n;
    }
    return C(".product-form__quantity");
  }
  _findAddToCartForm() {
    const t = this._findCartForm();
    if (!t)
      return;
    const e = !!this._dealBlockSettings.subscriptionsEnabled || this._dealBlockSettings.dealBars.some(
      (i) => i.sellingPlanEnabled
    );
    this._addToCartForm = new $e(
      t,
      !this._quantityInput,
      e,
      !!this._dealBlockSettings.abTestVariantNumber
    );
  }
  _findCartForm() {
    let t = this._placeholder.parentElement;
    for (; t; ) {
      for (const e of bt)
        for (const i of [
          this._globalConfig.customSelectors.addToCartButton,
          ...Z,
          "button"
        ]) {
          if (!i)
            continue;
          const n = A(
            `${e} ${i}`,
            t
          );
          if (n) {
            const a = n.closest(
              e
            );
            if (!a) continue;
            return !a.contains(this._placeholder) && a.querySelector(Y) ? null : a;
          }
        }
      t = t.parentElement;
    }
    return null;
  }
  _observeAddToCartFormRemoval() {
    var e;
    const t = (e = this._addToCartForm) == null ? void 0 : e.form;
    window.Shopify.designMode || !t || V(t, () => {
      var n, a;
      const i = this._findCartForm();
      i && ((n = this._addToCartForm) == null || n.replaceForm(i), y(
        "cart_form_removed",
        {
          theme: (a = window.Shopify.theme) == null ? void 0 : a.schema_name
        },
        0.01
      ), this._observeAddToCartFormRemoval());
    });
  }
  _findAddToCartButton() {
    const t = this._findAddToCartButtonElement() || this._findFormlessAddToCartButtonElement();
    if (!t) {
      this._warnAboutMissingAddToCartButton(), this._addToCartButton = null;
      return;
    }
    this._addToCartButton = new Le(t);
  }
  _moveAddToCartButtonOutOfQuantityElement() {
    !this._hiddenQuantityElement || !this._addToCartButton || this._hiddenQuantityElement.contains(this._addToCartButton.button) && this._hiddenQuantityElement.after(this._addToCartButton.button);
  }
  _findAddToCartButtonElement() {
    var n;
    const t = (n = this.addToCartForm()) == null ? void 0 : n.form;
    if (!t)
      return null;
    if (this._globalConfig.customSelectors.addToCartButton) {
      const a = A(
        this._globalConfig.customSelectors.addToCartButton,
        t
      );
      if (a)
        return a;
    }
    const e = [];
    for (const a of Z) {
      const o = C(a, t);
      e.push(...o);
    }
    const i = N(
      this._placeholder,
      e
    );
    return i || t.querySelector("button");
  }
  _findFormlessAddToCartButtonElement() {
    if (this._addToCartForm || this._globalConfig.featureFlags.intercept_cart_request !== !0 || !this._globalConfig.customSelectors.addToCartButton)
      return null;
    const t = this._globalConfig.customSelectors.addToCartButton;
    if (!t)
      return null;
    const e = C(t);
    return e.length === 0 ? null : N(
      this._placeholder,
      e,
      3
    );
  }
  _observeAddToCartButtonRemoval() {
    this._addToCartButton && V(this._addToCartButton.button, () => {
      var e, i;
      if ((e = this._addToCartButton) != null && e.button.isConnected) {
        this._observeAddToCartButtonRemoval();
        return;
      }
      let t = this._findAddToCartButtonElement() || this._findFormlessAddToCartButtonElement();
      t ? (this._addToCartButton.replaceButton(t), this._moveAddToCartButtonOutOfQuantityElement()) : this._addToCartButton = null, y(
        "add_to_cart_button_removed",
        {
          recreated: !!t,
          theme: (i = window.Shopify.theme) == null ? void 0 : i.schema_name
        },
        0.01
      ), this._observeAddToCartButtonRemoval();
    });
  }
  _warnAboutMissingAddToCartButton() {
    new URLSearchParams(window.location.search).get("source") !== "visualPreviewInitialLoad" && console.log(
      "%c[Kaching Bundles] Add to cart button not found. Please add a selector to the settings page or contact support.",
      "background: #f8d7da; color: #721c24; padding: 8px; border-left: 4px solid #f5c6cb;"
    );
  }
}
const Ge = (r, t, e, i, n) => {
  if (!e.stickyAtcEnabled || t.offsetParent === null || document.querySelector(".kaching-bundles-sticky-atc-wrapper"))
    return;
  const a = document.createElement("div");
  a.classList.add("kaching-bundles-sticky-atc-wrapper"), document.body.appendChild(a);
  const o = document.createElement("div");
  o.classList.add("kaching-bundles-sticky-atc-spacer"), a.appendChild(o);
  const s = document.createElement("kaching-bundles-sticky-atc");
  s.setAttribute(
    "sticky-atc",
    JSON.stringify(e.stickyAtc)
  ), s.setAttribute("config", JSON.stringify(r)), s.setAttribute("translations", JSON.stringify(i)), s.setAttribute("product", JSON.stringify(n)), s.setAttribute("deal-block", JSON.stringify(e)), a.appendChild(s), s.addEventListener(
    "kaching-bundles-sticky-atc-clicked",
    () => {
      const h = t.getBoundingClientRect().top + window.scrollY - 100;
      window.scrollTo({
        top: h,
        behavior: "smooth"
      });
    }
  );
  let l = !1;
  const c = () => {
    const f = t.getBoundingClientRect().bottom < 0;
    f !== l && (l = f, f ? (s.style.display = "block", requestAnimationFrame(() => {
      l && s.classList.add("kaching-bundles-sticky-atc--visible");
    })) : s.classList.contains("kaching-bundles-sticky-atc--visible") && (s.classList.remove("kaching-bundles-sticky-atc--visible"), s.addEventListener(
      "transitionend",
      () => {
        l || (s.style.display = "");
      },
      { once: !0 }
    )));
  };
  requestAnimationFrame(c), window.addEventListener("scroll", c, { passive: !0 }), new ResizeObserver(() => {
    const f = s.offsetHeight;
    o.style.height = `${f}px`;
  }).observe(s);
};
class dt {
  constructor(t) {
    this._globalConfig = t, setTimeout(() => {
      const e = document.querySelector(
        'link[href*="kaching-bundles.css"]'
      );
      e && V(e, () => {
        var i;
        y(
          "css_removed",
          {
            theme: (i = window.Shopify.theme) == null ? void 0 : i.schema_name
          },
          0.01
        );
      });
    }, 100), this._detectEssentialPreorders();
  }
  // Measure Essentials adoption before designing the badge integration; polls in case their script loads after ours.
  _detectEssentialPreorders() {
    try {
      const t = (o) => {
        var l, c;
        const s = (c = (l = window.essentialPreorderConfigs) == null ? void 0 : l.kachingBundles) == null ? void 0 : c.preorderVariants;
        return s != null && s.length ? (y(
          "essential_preorders_detected_v6",
          {
            variantCount: s.length,
            badgeCount: s.filter((u) => u.badgeHtml).length,
            late: o
          },
          0.1
        ), !0) : !1;
      };
      if (t(!1)) return;
      const e = 500, i = 1e4, n = Date.now(), a = window.setInterval(() => {
        (t(!0) || Date.now() - n > i) && window.clearInterval(a);
      }, e);
    } catch (t) {
      console.error(t);
    }
  }
  initialize() {
    this._setupTranslations();
    const t = C(Y);
    this._addProductIdForPlaceholders(t), t.length === 0 && this._addPlaceholders(), this._initializePlaceholders(), this._globalConfig.abTestsRunning && Pt(), this._setupPlaceholderObserver();
  }
  _setupTranslations() {
    const t = R("script#kaching-bundles-translations") || [], e = t.find(
      (i) => i.locale === this._globalConfig.locale
    );
    this._translations = e == null ? void 0 : e.translations, At(t);
  }
  _addProductIdForPlaceholders(t) {
    const e = R("script.kaching-bundles-product[data-main]");
    if (e)
      for (const i of t)
        i.getAttribute("product-id") || i.setAttribute("product-id", e.id);
  }
  _addPlaceholders() {
    if (!A("script.kaching-bundles-deal-block-settings"))
      return;
    const t = this._findPosition();
    if (!t)
      return;
    const e = R("script.kaching-bundles-product[data-main]"), i = e && e.id || this._globalConfig.productId, n = Q("kaching-bundle");
    n.setAttribute("product-id", i), t.parentElement.insertBefore(n, t);
  }
  async _initializePlaceholders() {
    const t = [...C(Y)].filter(
      (s) => s.getAttribute("product-id")
    );
    if (d("_initializePlaceholders", t), t.length === 0) {
      window.kachingBundlesInitialized = !0, window.dispatchEvent(new CustomEvent("kaching-bundles-initialized"));
      return;
    }
    if (t.filter(
      (s) => !O(s).initialized
    ).length === 0)
      return;
    const i = await this._fetchPlaceholdersData(t);
    d("placeholdersData", i);
    const n = Array.from(i.values()).map(({ dealBlock: s }) => s).filter((s) => s != null), a = Array.from(i.values()).map(({ product: s }) => s).filter((s) => s != null);
    await H(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken,
      a,
      n
    );
    const o = W();
    for (const s of t) {
      const { product: l, dealBlock: c } = i.get(s);
      if (!l || !c) {
        O(s).initialized = "skipped";
        continue;
      }
      await this._initializePlaceholder(
        s,
        l,
        c,
        o
      );
    }
    window.kachingBundlesInitialized = !0, window.dispatchEvent(new CustomEvent("kaching-bundles-initialized"));
  }
  async _initializePlaceholder(t, e, i, n) {
    var p, m;
    const a = e.id;
    this._globalConfig.webPixel ? (d("Tracking view with web pixel", window.Shopify.analytics), ft(() => {
      window.Shopify.analytics.publish("kaching_bundle_viewed", {
        product_id: a,
        deal_block_id: i.id,
        ab_test_variant_id: i.abTestVariantId,
        session_id: n
      });
    })) : (d("Tracking view without web pixel (legacy)"), setTimeout(() => {
      St(
        this._globalConfig.shopifyDomain,
        i.id,
        a,
        i.abTestVariantId,
        n
      );
    }, 2e3));
    const o = {
      ...this._globalConfig.defaultTranslations,
      ...(p = this._translations) == null ? void 0 : p.system
    }, s = (m = this._translations) == null ? void 0 : m.dealBlocks[i.id], l = { ...o, ...s }, c = this._globalConfig.locale === this._globalConfig.liquidLocale ? C("script.kaching-bundles-product:not([data-main])").map((b) => JSON.parse(b.textContent)).filter((b) => b.variants.length < 250) : [];
    await import("./kaching-bundles-block.js");
    const u = { ...this._globalConfig };
    u.currencyRate = _e(
      this._globalConfig.currencyRate,
      i.currency,
      this._globalConfig.marketCurrencyCode
    ), i.dealBars.some(
      (b) => b.dealBarType === "quantity-break" && b.quantitySelector
    ) && (u.keepQuantityInput = !1);
    const f = new Re(t, u, i);
    f.initialize();
    const h = Q(
      "kaching-bundles-block"
    );
    for (h.setAttribute("data-instant-styles", "none"), new Me(
      h,
      f,
      u,
      l,
      i,
      e,
      c
    ); t.firstChild; )
      t.removeChild(t.firstChild);
    t.appendChild(h), O(t).initialized = "true", He(h), Ge(
      this._globalConfig,
      h,
      i,
      l,
      e
    );
  }
  _setupPlaceholderObserver() {
    if (window.Shopify.designMode)
      return;
    new MutationObserver((e) => {
      var n;
      e.some(
        (a) => Array.from(a.addedNodes).some((o) => {
          if (!(o instanceof HTMLElement)) return !1;
          const s = (l) => l.tagName === "KACHING-BUNDLE" && !O(l).initialized;
          return s(o) || Array.from(o.querySelectorAll("kaching-bundle")).some(
            (l) => s(l)
          );
        })
      ) && (this._globalConfig.featureFlags.reinitialize_morphed_placeholders ? (I("Initializing new kaching-bundle placeholder"), this._initializePlaceholders()) : document.querySelector(
        "#replo-fullpage-element, #replo-element-styles"
      ) || y(
        "kaching_bundle_added_v8",
        {
          theme: (n = window.Shopify.theme) == null ? void 0 : n.schema_name
        },
        0.01
      ));
    }).observe(document.body, {
      childList: !0,
      subtree: !0
    });
  }
  async _fetchPlaceholdersData(t) {
    var g, k;
    const e = t.map(
      (_) => Number(_.getAttribute("product-id"))
    ), i = new Map(
      this._globalConfig.locale === this._globalConfig.liquidLocale ? C("script.kaching-bundles-product[data-main]").map((_) => JSON.parse(_.textContent)).filter((_) => _.variants.length < 250).map((_) => [_.id, _]) : []
    ), n = e.filter(
      (_) => !i.has(_)
    ), a = C(
      "script.kaching-bundles-deal-block-settings"
    ), o = /* @__PURE__ */ new Map();
    for (const _ of e) {
      const B = a.filter(
        (E) => Number(O(E).productId) === _
      );
      B.length && o.set(
        _,
        B.map(
          (E) => E.textContent ? JSON.parse(E.textContent) : null
        )
      );
    }
    const s = e.filter(
      (_) => !o.has(_)
    ), l = this._globalConfig.storefrontAccessToken ? new q(
      this._globalConfig.shopifyDomain,
      this._globalConfig.storefrontAccessToken
    ) : null, c = l && n.length > 0 ? G(l, {
      country: this._globalConfig.country,
      language: this._globalConfig.locale.split("-")[0].toUpperCase(),
      productIds: n,
      includeSellingPlans: this._globalConfig.includeSellingPlans,
      includeAvailableQuantity: this._globalConfig.includeAvailableQuantity,
      useExternalMetafieldNamespace: !1
    }) : [], u = l && s.length > 0 ? Bt(l, {
      useExternalMetafieldNamespace: !1,
      useMetaobjects: this._globalConfig.featureFlags.storefront_metaobjects
    }) : [], [f, h] = await Promise.all([
      c,
      u
    ]), p = new Map(
      n.map((_) => [
        _,
        f.find((B) => B.id == _)
      ])
    ), m = new Map([...i, ...p]), b = W(), w = /* @__PURE__ */ new Map();
    for (const _ of t) {
      const B = Number(_.getAttribute("product-id")), E = m.get(B);
      if (!E)
        continue;
      const et = ((g = o.get(B)) == null ? void 0 : g.filter((v) => v)) || h;
      et.sort((v, T) => {
        const it = !!v.marketId, kt = !!T.marketId;
        return it === kt ? 0 : it ? -1 : 1;
      });
      let P = Qt(et, E);
      d("applicableDealBlocks", P), P = P.filter((v) => v.marketId ? v.marketId === this._globalConfig.marketId : !0), this._globalConfig.featureFlags.exclude_markets && (P = P.filter(
        (v) => {
          var T;
          return !((T = v.excludedMarketIds) != null && T.includes(this._globalConfig.marketId));
        }
      )), P = P.filter((v) => {
        if (!v.abTestVariantId)
          return !0;
        const T = Tt({
          kachingSessionId: b,
          abTestVariantsCount: v.abTestVariantsCount,
          abTestTrafficAllocation: v.abTestTrafficAllocation
        });
        return v.abTestVariantNumber === T;
      }), this._globalConfig.b2bCustomer && (P = P.filter(
        (v) => !v.excludeB2bCustomers
      )), this._globalConfig.requireCustomerLogin && !this._globalConfig.isLoggedIn && (P = []);
      const x = (k = _.getAttribute("manual-deal-block-id")) == null ? void 0 : k.trim();
      if (x) {
        const v = P.findIndex(
          (T) => T.id === x || T.nanoId === x
        );
        if (I("Manual deal override", {
          deal: P[v],
          manualDealBlockId: x,
          manualDealBlockIndex: v
        }), v > 0) {
          const [T] = P.splice(
            v,
            1
          );
          P.unshift(T);
        }
      }
      if (!P.length) {
        w.set(_, {
          product: E,
          dealBlock: null
        });
        continue;
      }
      w.set(_, {
        product: E,
        dealBlock: P[0]
      });
    }
    return w;
  }
  _findPosition() {
    const t = this._findGempagesPosition();
    if (t)
      return t;
    const e = this._findThemePosition();
    if (e)
      return e;
    const i = this._findDefaultPosition();
    return i || null;
  }
  // Temporary
  _findGempagesPosition() {
    const t = C("gp-product-button");
    for (const e of t)
      if (!e.closest("gp-sticky"))
        return e;
    return null;
  }
  _findThemePosition() {
    for (const t of yt) {
      const e = A(t[0]);
      if (e) {
        if (e.closest(
          ".dbtfy-sticky-addtocart, .cart-drawer, cart-drawer, cart-items"
        ))
          continue;
        return setTimeout(() => {
          var n;
          const i = e.closest(
            '[class*="cart"], [class*="Cart"]'
          );
          i && i.tagName.toLowerCase() !== "body" && !i.classList.toString().includes("add-to-cart") && !i.classList.toString().includes("AddToCart") && !i.classList.toString().includes("icartShopifyCartContent") && y(
            "theme_position_in_cart_drawer_v8",
            {
              selector: t[0],
              classes: i.classList.toString(),
              theme: (n = window.Shopify.theme) == null ? void 0 : n.schema_name
            },
            0.01
          );
        }), e;
      }
    }
    return null;
  }
  _findDefaultPosition() {
    for (const t of bt)
      for (const e of [
        this._globalConfig.customSelectors.addToCartButton,
        ...Z,
        "button"
      ]) {
        if (!e)
          continue;
        const i = A(
          `${t} ${e}`
        );
        if (i)
          return i.parentElement;
      }
    return null;
  }
}
function He(r) {
  const t = () => typeof window.FastClick != "undefined" || typeof window.T4SThemeSP != "undefined" && typeof window.T4SThemeSP.FastClick != "undefined" || typeof window.BEEThemeSP != "undefined" && typeof window.BEEThemeSP.FastClick != "undefined", e = setInterval(() => {
    t() && (clearInterval(e), C("*", r).forEach(
      (i) => Et(i, "needsclick")
    ));
  }, 500);
}
const pt = (r) => {
  var t;
  ((t = window.Shopify.theme) == null ? void 0 : t.theme_store_id) === 801 ? setTimeout(() => new dt(r).initialize(), 100) : new dt(r).initialize();
}, Ct = () => {
  var t;
  if (qt()) {
    const e = C(
      "style#kaching-bundles-custom-css"
    );
    for (const i of e)
      i.remove();
    return;
  }
  const r = R(
    "script#kaching-bundles-config"
  );
  r && (I("Shopify domain:", r.shopifyDomain), Ft(), Dt(r), window.kachingBundlesKeepQuantityInput && (r.keepQuantityInput = !0), pt(r), window.Shopify.designMode && (D(window, "shopify:section:load", () => {
    pt(r);
  }), r.isDeprecatedAppEmbed || me({
    customApiHost: r.customApiHost,
    shopifyDomain: r.shopifyDomain,
    themeId: (t = window.Shopify.theme) == null ? void 0 : t.id
  })), Vt(), Mt(), window.kachingBundlesApi = Nt(r), setTimeout(() => {
    Ot();
  }, 1e3));
};
window.__kachingBundlesInitializeInternal = Ct;
const ht = () => {
  window.kachingBundlesDisableAutoInitialize || Ct();
};
document.readyState === "loading" ? (d("Waiting for DOMContentLoaded"), document.addEventListener("DOMContentLoaded", ht)) : ht();
