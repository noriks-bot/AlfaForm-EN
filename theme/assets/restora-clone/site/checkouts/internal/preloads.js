
    (function() {
      var preconnectOrigins = ["https://cdn.shopify.com","https://extensions.shopifycdn.com"];
      var scripts = ["/cdn/shopifycloud/checkout-web/assets/c1/polyfills-legacy.BrBVQSE2.js","/cdn/shopifycloud/checkout-web/assets/c1/app-legacy.Bdx16eK1.js","/cdn/shopifycloud/checkout-web/assets/c1/esnext-vendor-legacy.CMLPXcpl.js","/cdn/shopifycloud/checkout-web/assets/c1/browser-legacy.3CCSQGet.js","/cdn/shopifycloud/checkout-web/assets/c1/NotFound-legacy.BauASs2M.js","/cdn/shopifycloud/checkout-web/assets/c1/Theme-utilities-legacy.DiwL2WPH.js","/cdn/shopifycloud/checkout-web/assets/c1/images-payment-icon-legacy.BW3R3WiF.js","/cdn/shopifycloud/checkout-web/assets/c1/utilities-object-legacy.Dumv6AXk.js","/cdn/shopifycloud/checkout-web/assets/c1/purchasing-company-isValidPurchasingCompanyBillingAddress-legacy.Bn48u5Gl.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useShopPayCheckoutGqlVersion-legacy.DBaSLojj.js","/cdn/shopifycloud/checkout-web/assets/c1/FullScreenBackground-legacy.DR_UESWm.js","/cdn/shopifycloud/checkout-web/assets/c1/graphql-ShopPayCheckoutSessionQuery-legacy.QVsU3zv3.js","/cdn/shopifycloud/checkout-web/assets/c1/utils-getCommonShopPayExternalTelemetryAttributes-legacy.D-EKJxgL.js","/cdn/shopifycloud/checkout-web/assets/c1/graphql-UserPrivacySettingsSetMutation-legacy.CiTz9V7N.js","/cdn/shopifycloud/checkout-web/assets/c1/CaptureEvents-ButtonWithRegisterWebPixel-legacy.BiinX7cx.js","/cdn/shopifycloud/checkout-web/assets/c1/images-flag-icon-legacy.Bfupgm8k.js","/cdn/shopifycloud/checkout-web/assets/c1/locale-fr-legacy.CA8Atq4-.js","/cdn/shopifycloud/checkout-web/assets/c1/page-OnePage-legacy.CfP6AgsJ.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useWalletsTimeout-legacy.ByWwg_wv.js","/cdn/shopifycloud/checkout-web/assets/c1/remember-me-hooks-legacy.BsgAF870.js","/cdn/shopifycloud/checkout-web/assets/c1/OffsitePaymentFailed-legacy.Cg2bjho_.js","/cdn/shopifycloud/checkout-web/assets/c1/NoAddressLocationFullDetour-legacy.BdmY-Bty.js","/cdn/shopifycloud/checkout-web/assets/c1/SplitDeliveryMerchandiseContainer-legacy.Bt9mQONy.js","/cdn/shopifycloud/checkout-web/assets/c1/useShopPayButtonClassName-legacy.4LMyO6hr.js","/cdn/shopifycloud/checkout-web/assets/c1/ChangeCompanyLocationLink-legacy.BwoUo6K0.js","/cdn/shopifycloud/checkout-web/assets/c1/WalletsSandbox-WalletSandbox-legacy.BN0CjK7e.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useUnauthenticatedErrorModal-legacy.BSzVf0pE.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useForceShopPayUrl-legacy.tkrUVE7-.js","/cdn/shopifycloud/checkout-web/assets/c1/GooglePayButton-index-legacy.wWEKwlYZ.js","/cdn/shopifycloud/checkout-web/assets/c1/MarketsProDisclaimer-legacy.Bcglidvy.js","/cdn/shopifycloud/checkout-web/assets/c1/AutocompleteField-hooks-legacy.D6yib5xY.js","/cdn/shopifycloud/checkout-web/assets/c1/LocalizationExtensionField-legacy.lkv4nG8u.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useShopPayPaymentRequiredMethod-legacy.DucNn4xS.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useUpdateCheckoutAddress-legacy.CdrUixn1.js","/cdn/shopifycloud/checkout-web/assets/c1/WalletLogo-legacy.B0dvfmt9.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useGeneralPaymentErrorMessage-legacy.CxvVcLZL.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useShowShopPayOptin-legacy.6lGmEi6B.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useShowCreateMoreAccountsGdprTreatment-legacy.DICbYte1.js","/cdn/shopifycloud/checkout-web/assets/c1/types-index-legacy.tPrKCUnj.js","/cdn/shopifycloud/checkout-web/assets/c1/Section-legacy.BzQOCqt0.js","/cdn/shopifycloud/checkout-web/assets/c1/MobileOrderSummary-legacy.C3Iqz95A.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useOnePageFormSubmit-legacy.CMzesrYE.js","/cdn/shopifycloud/checkout-web/assets/c1/PayPalOverCaptureInfoBanner-legacy.BYMkQ0hj.js","/cdn/shopifycloud/checkout-web/assets/c1/utilities-get-negotiation-input-legacy.2VEzVXXI.js","/cdn/shopifycloud/checkout-web/assets/c1/shop-cash-constants-legacy.BFju_yfM.js","/cdn/shopifycloud/checkout-web/assets/c1/redemption-constants-legacy.CxiN0GmP.js","/cdn/shopifycloud/checkout-web/assets/c1/PaymentErrorBanner-legacy.DKayMZag.js","/cdn/shopifycloud/checkout-web/assets/c1/StockProblems-StockProblemsLineItemList-legacy.CBiE-xuZ.js","/cdn/shopifycloud/checkout-web/assets/c1/DutyOptions-legacy.B78G-tQR.js","/cdn/shopifycloud/checkout-web/assets/c1/ShipmentBreakdown-legacy.2We1XsHI.js","/cdn/shopifycloud/checkout-web/assets/c1/MerchandiseModal-legacy.C-6pA9US.js","/cdn/shopifycloud/checkout-web/assets/c1/extension-targets-shipping-options-legacy.B2xScnkt.js","/cdn/shopifycloud/checkout-web/assets/c1/StackedMerchandisePreview-legacy.BsIXPPJ8.js","/cdn/shopifycloud/checkout-web/assets/c1/ShippingGroupsSummaryLine-legacy.DaodvrKz.js","/cdn/shopifycloud/checkout-web/assets/c1/ShippingMethodSelector-legacy.oFHC8pal.js","/cdn/shopifycloud/checkout-web/assets/c1/SubscriptionPriceBreakdown-legacy.BM9frD8M.js","/cdn/shopifycloud/checkout-web/assets/c1/hooks-useSubscribeMessenger-legacy.BOUyzHdW.js","/cdn/shopifycloud/checkout-web/assets/c1/component-RuntimeExtension-legacy.BulIGFfn.js","/cdn/shopifycloud/checkout-web/assets/c1/AnnouncementRuntimeExtensions-legacy.B6z-S8DV.js","/cdn/shopifycloud/checkout-web/assets/c1/extension-targets-rendering-extension-targets-legacy.CSk4tKmi.js","/cdn/shopifycloud/checkout-web/assets/c1/dist-v4-legacy.hxLzMo8h.js","/cdn/shopifycloud/checkout-web/assets/c1/ExtensionsInner-legacy.BVujmlCJ.js"];
      var styles = [];
      var fontPreconnectUrls = [];
      var fontPrefetchUrls = [];
      var imgPrefetchUrls = ["https://cdn.shopify.com/s/files/1/0935/5054/3180/files/2_211bbed6-6aff-48dc-a8bf-505697964e25_x320.png?v=1760872277"];

      function preconnect(url, callback) {
        var link = document.createElement('link');
        link.rel = 'dns-prefetch preconnect';
        link.href = url;
        link.crossOrigin = '';
        link.onload = link.onerror = callback;
        document.head.appendChild(link);
      }

      function preconnectAssets() {
        var resources = preconnectOrigins.concat(fontPreconnectUrls);
        var index = 0;
        (function next() {
          var res = resources[index++];
          if (res) preconnect(res, next);
        })();
      }

      function prefetch(url, as, callback) {
        var link = document.createElement('link');
        if (link.relList.supports('prefetch')) {
          link.rel = 'prefetch';
          link.fetchPriority = 'low';
          link.as = as;
          if (as === 'font') link.type = 'font/woff2';
          link.href = url;
          link.crossOrigin = '';
          link.onload = link.onerror = callback;
          document.head.appendChild(link);
        } else {
          var xhr = new XMLHttpRequest();
          xhr.open('GET', url, true);
          xhr.onloadend = callback;
          xhr.send();
        }
      }

      function prefetchAssets() {
        var resources = [].concat(
          scripts.map(function(url) { return [url, 'script']; }),
          styles.map(function(url) { return [url, 'style']; }),
          fontPrefetchUrls.map(function(url) { return [url, 'font']; }),
          imgPrefetchUrls.map(function(url) { return [url, 'image']; })
        );
        var index = 0;
        function run() {
          var res = resources[index++];
          if (res) prefetch(res[0], res[1], next);
        }
        var next = (self.requestIdleCallback || setTimeout).bind(self, run);
        next();
      }

      function onLoaded() {
        try {
          if (parseFloat(navigator.connection.effectiveType) > 2 && !navigator.connection.saveData) {
            preconnectAssets();
            prefetchAssets();
          }
        } catch (e) {}
      }

      if (document.readyState === 'complete') {
        onLoaded();
      } else {
        addEventListener('load', onLoaded);
      }
    })();
  