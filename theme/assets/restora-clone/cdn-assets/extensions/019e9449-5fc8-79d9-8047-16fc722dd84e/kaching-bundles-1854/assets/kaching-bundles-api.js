Array.prototype.flat || (Array.prototype.flat = function(t = 1) {
  return t > 0 ? (
    // @ts-expect-error - Polyfill for older browsers
    this.reduce(
      (e, s) => e.concat(Array.isArray(s) ? s.flat(t - 1) : s),
      []
    )
  ) : (
    // @ts-expect-error - Polyfill for older browsers
    this.slice()
  );
});
Array.prototype.flatMap || (Array.prototype.flatMap = function(t, e) {
  return this.map(t, e).flat();
});
const ht = (t) => {
  const e = window.Shopify.currency;
  e && (t.currencyRate = Number(e.rate));
  const s = window.Shopify.country;
  s && (t.country = s);
  const n = window.Shopify.locale;
  n && (t.locale = n);
}, J = () => {
  try {
    const t = "kaching_local_storage_test";
    return localStorage.setItem(t, t), localStorage.removeItem(t), !0;
  } catch {
    return !1;
  }
}, I = J() ? window.localStorage : window.sessionStorage, v = () => new URLSearchParams(window.location.search).get("kaching");
let E;
const yt = () => (E === void 0 && (E = v() === "off"), E);
let N;
const b = () => (N === void 0 && (N = v() === "debug"), N);
let G;
const F = () => (G === void 0 && (G = v() === "dev"), G);
let j;
const R = () => (j === void 0 && (j = v() === "info"), j), mt = async (t, e, s, n, o) => {
  try {
    const i = "kaching_visited_deal_blocks", a = I.getItem(i), u = a ? JSON.parse(a) : [];
    if (u.includes(e))
      return;
    u.push(e), I.setItem(i, JSON.stringify(u)), await fetch("https://bundles-stats.kachingappz.app/impressions", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        shopDomain: t,
        dealBlockId: e,
        productId: s,
        abTestVariantId: n,
        sessionId: o
      }),
      keepalive: !0
    });
  } catch (i) {
    console.error(i);
  }
}, C = /* @__PURE__ */ new Set(), Q = async (t, e = {}, s = 1) => {
  if (S("sendStorefrontEvent", { name: t, data: e }), C.has(t) || (C.add(t), Math.random() > s))
    return;
  const n = window.location.href;
  return await fetch(
    "https://storefront-events.kachingappz.app/bundles/events",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        event: { name: t, data: e, url: n, shop: window.Shopify.shop }
      })
    }
  );
};
let P = !1;
const U = async (t, e, s = 0.1) => {
  if (P || Math.random() > s || t === "Failed to fetch" || t && (t.includes(
    "Cannot define multiple custom elements with the same tag name"
  ) || t.includes(
    "Failed to execute 'define' on 'CustomElementRegistry'"
  ) || t.includes("CustomElementRegistry.define")))
    return;
  const n = window.location.href, o = window.Shopify.shop;
  return P = !0, await fetch(
    "https://storefront-events.kachingappz.app/bundles/errors",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        error: { message: t, stack: e, url: n, shop: o }
      })
    }
  );
}, gt = () => {
  const t = ["kaching-bundles.js", "kaching-bundles-block.js"];
  window.addEventListener("error", async function(e) {
    const s = async (n) => {
      const { filename: o, message: i, error: a } = n;
      for (const u of t)
        if (o.includes(u)) {
          if (b() || x()) {
            S("Error", n);
            return;
          }
          await U(i, a.stack);
        }
    };
    try {
      await s(e);
    } catch (n) {
      console.error(n);
    }
  }), window.addEventListener("unhandledrejection", async function(e) {
    const s = async (n) => {
      if (typeof n.reason != "object")
        return;
      const { message: o, stack: i } = n.reason;
      if (i) {
        for (const a of t)
          if (i.includes(a)) {
            if (b() || x()) {
              S("Unhandled rejection", n);
              return;
            }
            await U(o, i);
          }
      }
    };
    try {
      await s(e);
    } catch (n) {
      console.error(n);
    }
  });
};
function S(t, e = null) {
  !b() && !F() || console.debug("[Kaching Bundles]", t, e);
}
function It(t, e = null) {
  !R() && !b() && !F() || console.info("[Kaching Bundles]", t, e);
}
const wt = () => {
  const t = (n) => {
    window.dispatchEvent(new Event(n));
  }, e = history.pushState;
  history.pushState = function(...o) {
    const i = e.apply(this, o);
    return t("pushstate"), t("locationchange"), i;
  };
  const s = history.replaceState;
  history.replaceState = function(...o) {
    const i = s.apply(this, o);
    return t("replacestate"), t("locationchange"), i;
  }, X(window, "popstate", () => {
    t("locationchange");
  });
}, bt = (t, e, s, n = 0) => {
  const o = Object.getPrototypeOf(t);
  if (o.hasOwnProperty(e)) {
    const i = Object.getOwnPropertyDescriptor(
      o,
      e
    );
    if (!i.configurable)
      return;
    Object.defineProperty(t, e, {
      configurable: !0,
      get: function(...a) {
        return i.get.apply(this, a);
      },
      set: function(...a) {
        const u = this[e];
        i.set.apply(this, a);
        const l = this[e];
        return typeof s == "function" && setTimeout(s.bind(this, u, l), n), l;
      }
    });
  }
}, W = (t, e = document) => {
  try {
    return e.querySelector(t);
  } catch {
    return null;
  }
}, St = (t, e = document) => {
  try {
    return [...e.querySelectorAll(t)];
  } catch {
    return [];
  }
}, X = (t, e, s) => t.addEventListener(e, s), vt = (t) => document.createElement(t), Dt = (t, e) => t && t.classList.add(e), kt = (t, e, s) => t.setAttribute(e, s), Et = (t) => Number(t.split("/").pop()), Nt = (t) => t.dataset, Gt = (t) => {
  const e = W(t);
  if (!e)
    return;
  const s = JSON.parse(e.textContent);
  return S("jsonFromElement", s), s;
}, H = (t, e) => {
  let s = 0, n = t;
  for (; n && n !== e && n !== document.body; )
    s++, n = n.parentNode;
  return n !== e ? 1 / 0 : s;
}, Y = (t, e) => {
  if (t === e)
    return t;
  const s = /* @__PURE__ */ new Set();
  let n = t;
  for (; n; )
    s.add(n), n = n.parentElement;
  for (n = e; n; ) {
    if (s.has(n))
      return n;
    n = n.parentElement;
  }
  return document.documentElement;
}, jt = (t, e, s = 1 / 0) => {
  let n = null, o = 1 / 0;
  for (const i of e) {
    const a = Y(t, i);
    if (a === document.body || a === document.documentElement)
      continue;
    const u = H(t, a);
    u > s || u < o && (n = i, o = u);
  }
  return n;
}, x = () => {
  const t = document.currentScript;
  return t ? t.src.includes("kaching-bundles-dev") : !1;
}, K = (t, e = {}) => {
  const s = window.Shopify.routes, o = (s && s.root || "/") + t, i = new URLSearchParams();
  for (const [u, l] of Object.entries(e))
    i.append(u, l);
  const a = i.toString();
  return a ? `${o}?${a}` : o;
}, Ot = (t, e) => {
  new MutationObserver((n, o) => {
    for (const i of n)
      i.type === "childList" && i.removedNodes.forEach((a) => {
        a.contains(t) && (o.disconnect(), e());
      });
  }).observe(document.body, { childList: !0, subtree: !0 });
}, At = (t, e = 300, s = 100) => {
  let n = 0;
  const o = () => {
    window.Shopify.analytics ? t() : n < e ? (n++, setTimeout(o, s)) : Q(
      "shopify_analytics_missing",
      {
        userAgent: navigator.userAgent
      },
      0.1
    );
  };
  o();
}, Z = async (t, {
  useExternalMetafieldNamespace: e,
  useMetaobjects: s
}) => s ? tt(
  t
) : B(t), B = async (t, e) => {
  var n;
  const s = (n = (await t.query(
    `
      query FetchDealBlocks($metafieldNamespace: String!) {
        shop {
          metafield(namespace: $metafieldNamespace, key: "deal_blocks") {
            value
          }
        }
      }
    `,
    {
      variables: {
        metafieldNamespace: "$app:kaching_bundles"
      }
    }
  )).shop.metafield) == null ? void 0 : n.value;
  return s ? JSON.parse(s) : [];
}, tt = async (t, e) => {
  const s = "$app:deal_block", n = [];
  let o = null;
  for (; ; ) {
    const i = await t.query(
      `
        query FetchDealBlockMetaobjects($type: String!, $cursor: String) {
          metaobjects(type: $type, first: 250, after: $cursor) {
            nodes {
              fields {
                key
                value
              }
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
          type: s,
          cursor: o
        }
      }
    );
    for (const a of i.metaobjects.nodes) {
      const u = a.fields.find(
        (l) => l.key === "settings"
      );
      u != null && u.value && n.push(JSON.parse(u.value));
    }
    if (!i.metaobjects.pageInfo.hasNextPage)
      break;
    o = i.metaobjects.pageInfo.endCursor;
  }
  return n;
};
class et {
  constructor(e, s) {
    this.storefrontApiVersion = "2026-01", this.storefrontAccessToken = s, this.shopifyDomain = e;
  }
  async query(e, s) {
    var u, l;
    const n = (u = s == null ? void 0 : s.variables) != null ? u : {};
    let o = `https://${this.shopifyDomain}/api/${this.storefrontApiVersion}/graphql.json`;
    const i = (l = e.match(/query\s+(\w+)/)) == null ? void 0 : l[1];
    i && (o += `?operation_name=${i}`);
    const a = await (await fetch(o, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-Shopify-Storefront-Access-Token": this.storefrontAccessToken
      },
      body: JSON.stringify({
        query: e,
        variables: n
      })
    })).text();
    if (!a)
      throw new Error("Empty graphql response");
    return JSON.parse(a).data;
  }
}
class M extends Error {
  constructor(e) {
    super(e), this.name = "CartFetchError";
  }
}
const O = "kaching_session_id", Tt = async () => {
  try {
    nt();
    const t = L();
    await it() !== t && await at(t);
  } catch (t) {
    if (t instanceof M)
      console.error(t);
    else
      throw t;
  }
}, nt = () => {
  const t = new URL(window.location.href), e = new URLSearchParams(t.search), s = e.get("preview_kaching_session_id");
  s && (I.setItem(O, s), e.delete("preview_kaching_session_id"), t.search = e.toString(), window.history.replaceState({}, "", t.toString()));
}, L = () => I.getItem(O) || st(), st = () => {
  const t = rt();
  return I.setItem(O, t), t;
}, rt = () => typeof crypto != "undefined" && typeof crypto.randomUUID == "function" ? crypto.randomUUID() : ot(), ot = () => "10000000-1000-4000-8000-100000000000".replace(
  /[018]/g,
  (t) => (+t ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> +t / 4).toString(16)
), it = async () => {
  const t = await fetch(K("cart.js"));
  if (!t.ok)
    throw new M("Failed to fetch cart");
  return (await t.json()).attributes._kaching_session_id;
}, at = async (t) => await fetch(K("cart/update.js"), {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  },
  body: JSON.stringify({
    attributes: {
      _kaching_session_id: t
    }
  })
}), ct = ({
  kachingSessionId: t,
  abTestVariantsCount: e,
  abTestTrafficAllocation: s
}) => {
  const n = parseInt(t.replace(/-/g, "").slice(0, 4), 16) % 256, o = Math.floor(n * 100 / 256);
  if (!s)
    return ut(o, e);
  const i = 100 - s;
  if (o < i)
    return 1;
  const a = e - 1;
  if (a === 0)
    return 1;
  const u = s / a, l = Math.floor(
    (o - i) / u
  );
  return Math.min(l + 2, e);
}, ut = (t, e) => {
  const s = 100 / e, n = Math.floor(t / s);
  return Math.min(n + 1, e);
};
let h, m = null, z, $ = [];
const qt = (t) => {
  $ = t;
}, lt = async () => {
  if (m)
    return m;
  m = (async () => {
    if (!h.storefrontAccessToken)
      return;
    const t = new et(
      h.shopifyDomain,
      h.storefrontAccessToken
    );
    z = await Z(t, {
      useExternalMetafieldNamespace: !1,
      useMetaobjects: h.featureFlags.storefront_metaobjects
    });
  })();
  try {
    await m;
  } catch (t) {
    throw m = null, t;
  }
}, dt = async () => {
  var s;
  await lt();
  const t = z.filter((n) => {
    if (!n.abTestVariantId)
      return !0;
    const o = L(), i = ct({
      kachingSessionId: o,
      abTestVariantsCount: n.abTestVariantsCount,
      abTestTrafficAllocation: n.abTestTrafficAllocation
    });
    return n.abTestVariantNumber === i;
  }), e = (s = $.find(
    (n) => n.locale === h.locale
  )) == null ? void 0 : s.translations;
  return t.map((n) => {
    const o = (e == null ? void 0 : e.dealBlocks[n.id]) || {};
    return ft(n, o);
  });
}, ft = (t, e) => {
  var A, T, q, _, V;
  const s = (r) => {
    switch (r.dealBarType) {
      case void 0:
      case "quantity-break":
        return n(r);
      case "bxgy":
        return o(r);
      case "bundle":
        return i(r);
      case "sku":
        return a(r);
      default:
        return null;
    }
  }, n = (r) => ({
    id: r.id,
    title: e[r.title] || r.title,
    mediaImageGID: r.mediaImageGID,
    freeGifts: [
      ...l(r.freeGifts),
      ...y(r.id, t.progressiveGifts)
    ],
    upsells: w(r.upsells),
    dealBarType: "quantity-break",
    quantity: Number(r.quantity),
    discount: g(r.discountType, r.discountValue)
  }), o = (r) => ({
    id: r.id,
    title: e[r.title] || r.title,
    mediaImageGID: r.mediaImageGID,
    freeGifts: [
      ...l(r.freeGifts),
      ...y(r.id, t.progressiveGifts)
    ],
    upsells: w(r.upsells),
    dealBarType: "bxgy",
    buyQuantity: Number(r.buyQuantity),
    buyDiscount: g(
      r.buyDiscountType,
      r.buyDiscountValue
    ),
    getQuantity: Number(r.getQuantity),
    getDiscount: g(
      r.getDiscountType,
      r.getDiscountValue
    )
  }), i = (r) => ({
    id: r.id,
    title: e[r.title] || r.title,
    mediaImageGID: r.mediaImageGID,
    freeGifts: [
      ...l(r.freeGifts),
      ...y(r.id, t.progressiveGifts)
    ],
    upsells: w(r.upsells),
    dealBarType: "bundle",
    bundleProducts: u(r.bundleProducts)
  }), a = (r) => ({
    id: r.id,
    title: e[r.title] || r.title,
    mediaImageGID: r.mediaImageGID,
    freeGifts: [
      ...l(r.freeGifts),
      ...y(r.id, t.progressiveGifts)
    ],
    upsells: w(r.upsells),
    dealBarType: "sku"
  }), u = (r) => r.map((c) => {
    var d;
    return {
      id: c.id,
      productId: c.productGID === "default" ? "default" : p(c.productGID),
      variantId: c.variantGIDs && ((d = c.variantGIDs) != null && d[0]) ? p(c.variantGIDs[0]) : null,
      variantIds: c.variantGIDs ? c.variantGIDs.map(p) : null,
      quantity: Number(c.quantity),
      discount: g(
        c.discountType,
        c.discountValue
      )
    };
  }), l = (r) => r ? r.filter((d) => d.productGID).map((d) => {
    var D, k;
    return {
      id: d.id,
      productId: p(d.productGID),
      variantId: d.variantGIDs && ((D = d.variantGIDs) != null && D[0]) ? p(d.variantGIDs[0]) : null,
      variantIds: d.variantGIDs ? d.variantGIDs.map(p) : null,
      quantity: Number(d.quantity),
      applyOnlyForSubscriptions: (k = d.applyOnlyForSubscriptions) != null ? k : !1
    };
  }) : [], y = (r, c) => {
    if (!c)
      return [];
    const d = t.dealBars.findIndex((f) => f.id === r);
    return c.gifts.filter((f) => f.giftType === "product").filter((f) => f.productGID).filter(
      (f) => d + 1 >= f.unlockAtBar
    ).map((f) => ({
      id: f.id,
      productId: p(f.productGID),
      variantId: null,
      variantIds: null,
      quantity: 1,
      applyOnlyForSubscriptions: !1
    }));
  }, w = (r) => r ? r.map((c) => ({
    id: c.id,
    productId: c.productGID ? p(c.productGID) : null,
    variantId: c.variantGIDs && c.variantGIDs[0] ? p(c.variantGIDs[0]) : null,
    variantIds: c.variantGIDs ? c.variantGIDs.map(p) : null,
    quantity: Number(c.quantity),
    discount: g(c.discountType, c.discountValue)
  })) : [];
  return {
    id: t.id,
    nanoId: t.nanoId,
    discountName: (A = t.discountName) != null ? A : null,
    collectionBreaksEnabled: (T = t.collectionBreaksEnabled) != null ? T : !1,
    differentVariantsEnabled: t.differentVariantsEnabled,
    marketId: (q = t.marketId) != null ? q : null,
    excludedMarketIds: (_ = t.excludedMarketIds) != null ? _ : null,
    currency: (V = t.currency) != null ? V : null,
    dealBars: t.dealBars.filter((r) => "showAsSoldOutEnabled" in r ? !r.showAsSoldOutEnabled : !0).map(s).filter((r) => r !== null)
  };
}, g = (t, e) => !t || t === "default" ? null : {
  type: t,
  value: Number(e)
}, p = (t) => Number(t.split("/").pop()), _t = (t) => (h = t, {
  fetchDeals: dt
});
export {
  yt as A,
  gt as B,
  ht as C,
  _t as D,
  lt as E,
  kt as a,
  X as b,
  et as c,
  S as d,
  K as e,
  wt as f,
  Et as g,
  St as h,
  It as i,
  U as j,
  L as k,
  vt as l,
  jt as m,
  Ot as n,
  bt as o,
  Tt as p,
  W as q,
  Gt as r,
  Q as s,
  Nt as t,
  mt as u,
  Z as v,
  At as w,
  ct as x,
  qt as y,
  Dt as z
};
