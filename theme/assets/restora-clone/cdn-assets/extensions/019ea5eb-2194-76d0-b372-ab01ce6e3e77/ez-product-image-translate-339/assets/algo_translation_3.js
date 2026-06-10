(function () {
    "use strict";

    /**
     * EZ Product Image Translate - Front Replacement Script
     * Compatible avec le loader :
     * window.TRANSLATIONS_DATA = data;
     * window.dispatchEvent(new CustomEvent('translationsLoaded', { detail: data }));
     */

    const CONFIG = {
        FULL_SCAN_INTERVAL_MS: 3000,
        SRCSET_FIX_INTERVAL_MS: 1500,
        SHADOW_SCAN_INTERVAL_MS: 3000,
        OBSERVER_DEBOUNCE_MS: 0,
        PRELOAD_LIMIT: 16,
        CACHE_LIMIT: 3000,
        SESSION_CACHE_TTL_MS: 10 * 60 * 1000,
        INITIAL_RETRY_DELAYS: [16, 50, 150, 300, 700]
    };

    const mediaSelector = [
        'img[src]',
        'img[srcset]',
        'img[data-src]',
        'img[data-srcset]',
        'picture source[src]',
        'picture source[srcset]',
        'picture source[data-src]',
        'picture source[data-srcset]',
        'video',
        'iframe[src*="vimeo.com"]',
        'iframe[src*="youtube.com"]'
    ].join(', ');

    const fastMediaSelector = [
        'img[src]',
        'img[srcset]',
        'img[data-src]',
        'img[data-srcset]',
        'picture source[src]',
        'picture source[srcset]',
        'picture source[data-src]',
        'picture source[data-srcset]'
    ].join(', ');

    const observedAttributeFilter = [
        'src',
        'srcset',
        'data-src',
        'data-srcset',
        'poster'
    ];

    let isInternalMutation = false;
    let replaceTimer = null;
    let pendingRoots = new Set();

    let translationsVersion = 0;
    let cachedTranslationsVersion = -1;
    let cachedTranslationsRef = null;
    let cachedLangKey = null;
    let cachedMediaIndex = null;

    const fileNameCache = new Map();
    const srcsetCache = new Map();
    const originalAttrs = new WeakMap();
    const observedRoots = new WeakSet();
    const observedShadowRoots = [];

    function cacheSet(map, key, value) {
        if (map.size >= CONFIG.CACHE_LIMIT) {
            const firstKey = map.keys().next().value;

            if (firstKey !== undefined) {
                map.delete(firstKey);
            }
        }

        map.set(key, value);
    }

    function resetDynamicCaches() {
        cachedTranslationsVersion = -1;
        cachedTranslationsRef = null;
        cachedLangKey = null;
        cachedMediaIndex = null;
        srcsetCache.clear();
    }

    function getTranslationsStorageKey() {
        const shop = window.Shopify?.shop || window.SHOP_NAME || location.hostname;
        const locale = window.Shopify?.locale || document.documentElement?.lang || 'default';

        return `ez-image-translations:${shop}:${locale}`;
    }

    function cacheTranslationsData(data) {
        try {
            sessionStorage.setItem(getTranslationsStorageKey(), JSON.stringify({
                ts: Date.now(),
                data: data || {}
            }));
        } catch (error) {
            // Ignore storage failures.
        }
    }

    function getCachedTranslationsData() {
        try {
            const raw = sessionStorage.getItem(getTranslationsStorageKey());
            if (!raw) return null;

            const parsed = JSON.parse(raw);
            if (!parsed || typeof parsed !== "object") return null;

            if (!parsed.ts || Date.now() - parsed.ts > CONFIG.SESSION_CACHE_TTL_MS) {
                sessionStorage.removeItem(getTranslationsStorageKey());
                return null;
            }

            return parsed.data && typeof parsed.data === "object" ? parsed.data : null;
        } catch (error) {
            return null;
        }
    }

    function setTranslationsData(data, options = {}) {
        window.TRANSLATIONS_DATA = data || {};
        window.imageTranslations = data || {};

        if (!options.fromCache) {
            cacheTranslationsData(window.imageTranslations);
        }

        translationsVersion++;
        resetDynamicCaches();

        preloadTranslatedImages(CONFIG.PRELOAD_LIMIT);
        runInitialReplacement();

        CONFIG.INITIAL_RETRY_DELAYS.forEach(delay => {
            setTimeout(() => {
                safeReplaceAll();
            }, delay);
        });
    }

    function hasTranslations() {
        return !!window.imageTranslations && typeof window.imageTranslations === "object";
    }

    function getTranslationData(translation) {
        if (typeof translation === "object" && translation !== null) {
            return translation;
        }

        return {
            url: translation,
            alt: ""
        };
    }

    function rememberOriginalAttrs(element, attrs) {
        if (!element || originalAttrs.has(element)) return;

        const values = {};

        attrs.forEach(attr => {
            if (element.hasAttribute && element.hasAttribute(attr)) {
                values[attr] = element.getAttribute(attr);
            }
        });

        originalAttrs.set(element, values);
    }

    function getOriginalAttr(element, attr) {
        return originalAttrs.get(element)?.[attr] || null;
    }

    function extractFileName(url) {
        if (typeof url !== "string") return null;

        if (fileNameCache.has(url)) {
            return fileNameCache.get(url);
        }

        const originalUrl = url;
        const trimmedUrl = url.trim();

        if (
            !trimmedUrl ||
            trimmedUrl.startsWith('?') ||
            trimmedUrl.toLowerCase().startsWith('data:') ||
            trimmedUrl.toLowerCase().startsWith('blob:')
        ) {
            cacheSet(fileNameCache, originalUrl, null);
            return null;
        }

        try {
            const absoluteUrl = /^https?:\/\//i.test(trimmedUrl)
                ? trimmedUrl
                : trimmedUrl.startsWith('//')
                    ? `https:${trimmedUrl}`
                    : new URL(trimmedUrl, window.location.origin).toString();

            const urlObj = new URL(absoluteUrl);

            let lastSegment = urlObj.pathname.split('/').pop() || '';

            try {
                lastSegment = decodeURIComponent(lastSegment);
            } catch (error) {
                // Keep original segment.
            }

            lastSegment = lastSegment.replace(
                /_(small|medium|large|grande|compact|master|pico|icon|thumb|[0-9]+x(?:[0-9]+)?|x[0-9]+)(?=\.)/i,
                ''
            );

            if (lastSegment.toLowerCase().endsWith('.mp4')) {
                const parts = lastSegment.split('.');

                if (parts.length >= 3) {
                    lastSegment = parts[0] + ".mp4";
                }
            }

            const match = lastSegment.match(/([^\/]+\.(?:jpg|jpeg|png|gif|webp|mp4|svg|avif))$/i);
            const result = match ? match[1] : null;

            cacheSet(fileNameCache, originalUrl, result);
            return result;
        } catch (error) {
            cacheSet(fileNameCache, originalUrl, null);
            return null;
        }
    }

    function extractUrlsFromSrcset(srcset) {
        if (!srcset || typeof srcset !== "string") return [];

        return srcset
            .split(",")
            .map(candidate => candidate.trim().split(/\s+/)[0])
            .filter(Boolean);
    }

    function getCurrentLangKeys() {
        const shopifyLocale = window.Shopify?.locale;
        const htmlLang = document.documentElement?.lang;
        const lang = String(shopifyLocale || htmlLang || 'fr');

        const normalizedLang = lang.toLowerCase();
        const baseLang = normalizedLang.split('-')[0];

        return {
            lang,
            normalizedLang,
            baseLang
        };
    }

    function getMediaIndex() {
        const translations = window.imageTranslations || {};
        const { lang, normalizedLang, baseLang } = getCurrentLangKeys();

        const cacheKey = `${lang}|${normalizedLang}|${baseLang}`;

        if (
            cachedMediaIndex &&
            cachedTranslationsVersion === translationsVersion &&
            cachedTranslationsRef === translations &&
            cachedLangKey === cacheKey
        ) {
            return cachedMediaIndex;
        }

        const mediaToUse =
            translations?.[lang] ||
            translations?.[normalizedLang] ||
            translations?.[baseLang] ||
            translations?.['fr'] ||
            {};

        const index = Object.create(null);

        Object.keys(mediaToUse).forEach(key => {
            const data = getTranslationData(mediaToUse[key]);

            if (!data || !data.url) return;

            index[key] = data;

            const fileName = extractFileName(key);

            if (fileName && !index[fileName]) {
                index[fileName] = data;
            }
        });

        cachedMediaIndex = index;
        cachedTranslationsRef = translations;
        cachedTranslationsVersion = translationsVersion;
        cachedLangKey = cacheKey;

        return cachedMediaIndex;
    }

    function findTranslationFromUrls(urls, mediaIndex) {
        for (const url of urls) {
            if (!url) continue;

            if (mediaIndex[url]) {
                return mediaIndex[url];
            }

            const fileName = extractFileName(url);

            if (fileName && mediaIndex[fileName]) {
                return mediaIndex[fileName];
            }
        }

        return null;
    }

    function addWidthToUrl(url, width) {
        if (!url) return url;

        try {
            const absoluteUrl = /^https?:\/\//i.test(url)
                ? url
                : url.startsWith('//')
                    ? `https:${url}`
                    : new URL(url, window.location.origin).toString();

            const urlObj = new URL(absoluteUrl);
            urlObj.searchParams.set('width', width);

            if (url.startsWith('//')) {
                return urlObj.toString().replace(/^https:/, '');
            }

            return urlObj.toString();
        } catch (error) {
            const separator = url.includes('?') ? '&' : '?';
            return `${url}${separator}width=${width}`;
        }
    }

    function rebuildSrcset(oldSrcset, newUrl) {
        if (!oldSrcset || !newUrl) return newUrl;

        const cacheKey = `${oldSrcset}||${newUrl}`;

        if (srcsetCache.has(cacheKey)) {
            return srcsetCache.get(cacheKey);
        }

        const newCandidates = oldSrcset
            .split(",")
            .map(candidate => {
                const parts = candidate.trim().split(/\s+/);
                const descriptor = parts[1] || "";

                const widthMatch = descriptor.match(/^(\d+)w$/);

                if (widthMatch) {
                    return `${addWidthToUrl(newUrl, widthMatch[1])} ${descriptor}`;
                }

                return descriptor ? `${newUrl} ${descriptor}` : newUrl;
            })
            .filter(Boolean);

        const result = newCandidates.length ? newCandidates.join(", ") : newUrl;

        cacheSet(srcsetCache, cacheKey, result);

        return result;
    }

    function setAttrIfDifferent(element, attr, value) {
        if (!element || !attr || value === undefined || value === null || value === "") {
            return false;
        }

        const stringValue = String(value);

        if (element.getAttribute(attr) !== stringValue) {
            element.setAttribute(attr, stringValue);
            return true;
        }

        return false;
    }

    function replaceImage(img, mediaIndex) {
        rememberOriginalAttrs(img, ["src", "srcset", "data-src", "data-srcset", "alt"]);

        const mediaSrc = img.getAttribute("src");
        const mediaSrcset = img.getAttribute("srcset");
        const mediaDataSrc = img.getAttribute("data-src");
        const mediaDataSrcset = img.getAttribute("data-srcset");

        const originalSrc = getOriginalAttr(img, "src");
        const originalSrcset = getOriginalAttr(img, "srcset");
        const originalDataSrc = getOriginalAttr(img, "data-src");
        const originalDataSrcset = getOriginalAttr(img, "data-srcset");

        const newData = findTranslationFromUrls([
            originalSrc,
            originalDataSrc,
            mediaSrc,
            img.currentSrc,
            mediaDataSrc,
            ...extractUrlsFromSrcset(originalSrcset),
            ...extractUrlsFromSrcset(mediaSrcset),
            ...extractUrlsFromSrcset(originalDataSrcset),
            ...extractUrlsFromSrcset(mediaDataSrcset)
        ], mediaIndex);

        if (!newData) return false;

        let changed = false;

        const newUrl = newData.url;
        const newAlt = newData.alt;

        if (newUrl) {
            changed = setAttrIfDifferent(img, "src", newUrl) || changed;

            if (mediaSrcset || originalSrcset) {
                changed = setAttrIfDifferent(
                    img,
                    "srcset",
                    rebuildSrcset(originalSrcset || mediaSrcset, newUrl)
                ) || changed;
            }

            if (mediaDataSrc || originalDataSrc) {
                changed = setAttrIfDifferent(img, "data-src", newUrl) || changed;
            }

            if (mediaDataSrcset || originalDataSrcset) {
                changed = setAttrIfDifferent(
                    img,
                    "data-srcset",
                    rebuildSrcset(originalDataSrcset || mediaDataSrcset, newUrl)
                ) || changed;
            }
        }

        if (newAlt) {
            changed = setAttrIfDifferent(img, "alt", newAlt) || changed;
        }

        return changed;
    }

    function replacePictureSource(source, mediaIndex) {
        rememberOriginalAttrs(source, ["src", "srcset", "data-src", "data-srcset"]);

        const sourceSrc = source.getAttribute("src");
        const sourceSrcset = source.getAttribute("srcset");
        const sourceDataSrc = source.getAttribute("data-src");
        const sourceDataSrcset = source.getAttribute("data-srcset");

        const originalSrc = getOriginalAttr(source, "src");
        const originalSrcset = getOriginalAttr(source, "srcset");
        const originalDataSrc = getOriginalAttr(source, "data-src");
        const originalDataSrcset = getOriginalAttr(source, "data-srcset");

        const newData = findTranslationFromUrls([
            originalSrc,
            originalDataSrc,
            sourceSrc,
            sourceDataSrc,
            ...extractUrlsFromSrcset(originalSrcset),
            ...extractUrlsFromSrcset(sourceSrcset),
            ...extractUrlsFromSrcset(originalDataSrcset),
            ...extractUrlsFromSrcset(sourceDataSrcset)
        ], mediaIndex);

        if (!newData || !newData.url) return false;

        let changed = false;
        const newUrl = newData.url;

        if (sourceSrc || originalSrc) {
            changed = setAttrIfDifferent(source, "src", newUrl) || changed;
        }

        if (sourceSrcset || originalSrcset) {
            changed = setAttrIfDifferent(
                source,
                "srcset",
                rebuildSrcset(originalSrcset || sourceSrcset, newUrl)
            ) || changed;
        }

        if (sourceDataSrc || originalDataSrc) {
            changed = setAttrIfDifferent(source, "data-src", newUrl) || changed;
        }

        if (sourceDataSrcset || originalDataSrcset) {
            changed = setAttrIfDifferent(
                source,
                "data-srcset",
                rebuildSrcset(originalDataSrcset || sourceDataSrcset, newUrl)
            ) || changed;
        }

        return changed;
    }

    function replaceVideoPoster(video, mediaIndex) {
        rememberOriginalAttrs(video, ["poster", "aria-label"]);

        const poster = video.getAttribute("poster");
        const originalPoster = getOriginalAttr(video, "poster");

        const newData = findTranslationFromUrls([
            originalPoster,
            poster
        ], mediaIndex);

        if (!newData || !newData.url) return false;

        let changed = false;

        changed = setAttrIfDifferent(video, "poster", newData.url) || changed;

        if (newData.alt) {
            changed = setAttrIfDifferent(video, "aria-label", newData.alt) || changed;
        }

        return changed;
    }

    function replaceVideo(video, mediaIndex) {
        const sources = video.querySelectorAll('source[src], source[srcset]');
        let changed = false;
        let sourceChanged = false;

        sources.forEach(source => {
            rememberOriginalAttrs(source, ["src", "srcset"]);

            const sourceSrc = source.getAttribute('src');
            const sourceSrcset = source.getAttribute('srcset');

            const originalSrc = getOriginalAttr(source, "src");
            const originalSrcset = getOriginalAttr(source, "srcset");

            const newData = findTranslationFromUrls([
                originalSrc,
                sourceSrc,
                ...extractUrlsFromSrcset(originalSrcset),
                ...extractUrlsFromSrcset(sourceSrcset)
            ], mediaIndex);

            if (!newData || !newData.url) return;

            if (sourceSrc || originalSrc) {
                const didChange = setAttrIfDifferent(source, "src", newData.url);
                changed = didChange || changed;
                sourceChanged = didChange || sourceChanged;
            }

            if (sourceSrcset || originalSrcset) {
                const didChange = setAttrIfDifferent(
                    source,
                    "srcset",
                    rebuildSrcset(originalSrcset || sourceSrcset, newData.url)
                );

                changed = didChange || changed;
                sourceChanged = didChange || sourceChanged;
            }

            if (newData.alt) {
                changed = setAttrIfDifferent(video, "aria-label", newData.alt) || changed;
            }
        });

        changed = replaceVideoPoster(video, mediaIndex) || changed;

        if (sourceChanged) {
            video.load();
        }

        return changed;
    }

    function replaceIframe(iframe, mediaIndex) {
        rememberOriginalAttrs(iframe, ["src"]);

        const src = iframe.getAttribute("src");
        const originalSrc = getOriginalAttr(iframe, "src");

        const newData = findTranslationFromUrls([
            originalSrc,
            src
        ], mediaIndex);

        if (!newData || !newData.url) return false;

        return setAttrIfDifferent(iframe, "src", newData.url);
    }

    function getAllMediaElements(root = document) {
        const mediaElements = [];

        if (!root) return mediaElements;

        if (root.nodeType === Node.ELEMENT_NODE && root.matches?.(mediaSelector)) {
            mediaElements.push(root);
        }

        if (root.querySelectorAll) {
            root.querySelectorAll(mediaSelector).forEach(media => {
                mediaElements.push(media);
            });

            root.querySelectorAll('deferred-media template').forEach(template => {
                const templateContent = template.content || template;

                if (templateContent.querySelectorAll) {
                    templateContent.querySelectorAll(mediaSelector).forEach(media => {
                        mediaElements.push(media);
                    });
                }
            });
        }

        return mediaElements;
    }

    function replaceMedia(root = document) {
        if (!hasTranslations()) return;

        const mediaIndex = getMediaIndex();
        const mediaElements = getAllMediaElements(root);

        mediaElements.forEach(media => {
            if (!media || !media.tagName) return;

            const tag = media.tagName.toLowerCase();

            if (tag === "img") {
                replaceImage(media, mediaIndex);
                return;
            }

            if (tag === "source" && media.closest("picture")) {
                replacePictureSource(media, mediaIndex);
                return;
            }

            if (tag === "video") {
                replaceVideo(media, mediaIndex);
                return;
            }

            if (tag === "iframe") {
                replaceIframe(media, mediaIndex);
            }
        });
    }

    function fastInitialReplace(root = document) {
        if (!hasTranslations()) return;

        const mediaIndex = getMediaIndex();
        const elements = [];

        if (root.nodeType === Node.ELEMENT_NODE && root.matches?.(fastMediaSelector)) {
            elements.push(root);
        }

        if (root.querySelectorAll) {
            root.querySelectorAll(fastMediaSelector).forEach(element => {
                elements.push(element);
            });
        }

        elements.forEach(media => {
            if (!media || !media.tagName) return;

            const tag = media.tagName.toLowerCase();

            if (tag === "img") {
                replaceImage(media, mediaIndex);
            } else if (tag === "source" && media.closest("picture")) {
                replacePictureSource(media, mediaIndex);
            }
        });
    }

    function runInternalMutationProtected(callback) {
        if (isInternalMutation) return;

        isInternalMutation = true;

        try {
            callback();
        } finally {
            setTimeout(() => {
                isInternalMutation = false;
            }, 0);
        }
    }

    function runInitialReplacement() {
        runInternalMutationProtected(() => {
            fastInitialReplace(document);

            observedShadowRoots.forEach(root => {
                fastInitialReplace(root);
            });

            replaceMedia(document);

            observedShadowRoots.forEach(root => {
                replaceMedia(root);
            });
        });
    }

    function runFastReplacement(root = document) {
        if (!hasTranslations()) return;

        runInternalMutationProtected(() => {
            fastInitialReplace(root);
        });
    }

    function runReplacement(roots) {
        runInternalMutationProtected(() => {
            roots.forEach(root => {
                if (root) {
                    replaceMedia(root);
                }
            });
        });
    }

    function safeReplaceMedia(root = document) {
        runReplacement([root]);
    }

    function safeReplaceAll() {
        const roots = [document, ...observedShadowRoots];
        runReplacement(roots);
    }

    function scheduleReplace(root = document) {
        if (isInternalMutation) return;

        pendingRoots.add(root || document);

        if (replaceTimer) return;

        const flush = () => {
            replaceTimer = null;

            const roots = Array.from(pendingRoots);
            pendingRoots.clear();

            runReplacement(roots.length ? roots : [document]);
        };

        if (CONFIG.OBSERVER_DEBOUNCE_MS <= 0 && typeof queueMicrotask === 'function') {
            replaceTimer = true;
            queueMicrotask(flush);
            return;
        }

        replaceTimer = setTimeout(flush, CONFIG.OBSERVER_DEBOUNCE_MS);
    }

    function repairClickSrcsets(root = document) {
        const images = [];

        if (root.nodeType === Node.ELEMENT_NODE && root.matches?.('img[src]')) {
            images.push(root);
        }

        if (root.querySelectorAll) {
            root.querySelectorAll('img[src]').forEach(img => {
                images.push(img);
            });
        }

        images.forEach(img => {
            const srcValue = img.getAttribute('src');

            if (!srcValue || !srcValue.includes('.click')) return;

            setAttrIfDifferent(img, 'srcset', srcValue);
        });
    }

    function safeRepairClickSrcsets() {
        runInternalMutationProtected(() => {
            repairClickSrcsets(document);

            observedShadowRoots.forEach(root => {
                repairClickSrcsets(root);
            });
        });
    }

    function preloadTranslatedImages(limit = 12) {
        if (!hasTranslations()) return;

        const mediaIndex = getMediaIndex();
        const seen = new Set();
        let count = 0;

        Object.values(mediaIndex).forEach(data => {
            if (count >= limit) return;

            const translation = getTranslationData(data);

            if (!translation.url) return;
            if (seen.has(translation.url)) return;

            seen.add(translation.url);

            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'image';
            link.href = translation.url;
            document.head?.appendChild(link);

            const img = new Image();
            img.src = translation.url;

            count++;
        });
    }

    const mediaObserver = new MutationObserver(mutationsList => {
        if (isInternalMutation) return;

        mutationsList.forEach(mutation => {
            if (mutation.type === 'attributes') {
                const target = mutation.target;

                if (!target || target.nodeType !== Node.ELEMENT_NODE) return;

                if (target.matches?.(mediaSelector)) {
                    runFastReplacement(target);
                    scheduleReplace(target);
                    return;
                }

                const closestMedia = target.closest?.(mediaSelector);

                if (closestMedia) {
                    runFastReplacement(closestMedia);
                    scheduleReplace(closestMedia);
                }

                return;
            }

            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(node => {
                    if (!node || node.nodeType !== Node.ELEMENT_NODE) return;

                    observeShadowRootsInside(node);

                    if (node.matches?.(mediaSelector)) {
                        runFastReplacement(node);
                        scheduleReplace(node);
                        return;
                    }

                    if (node.querySelector?.(mediaSelector)) {
                        runFastReplacement(node);
                        scheduleReplace(node);
                        return;
                    }

                    if (
                        node.matches?.('deferred-media, template') ||
                        node.querySelector?.('deferred-media template')
                    ) {
                        runFastReplacement(node);
                        scheduleReplace(node);
                    }
                });
            }
        });
    });

    function observeRoot(root) {
        if (!root || observedRoots.has(root)) return;

        observedRoots.add(root);

        mediaObserver.observe(root, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: observedAttributeFilter
        });

        if (
            typeof ShadowRoot !== "undefined" &&
            root instanceof ShadowRoot &&
            !observedShadowRoots.includes(root)
        ) {
            observedShadowRoots.push(root);
        }
    }

    function observeShadowRootsInside(root = document) {
        if (!root) return;

        if (root.shadowRoot) {
            observeRoot(root.shadowRoot);
            scheduleReplace(root.shadowRoot);
        }

        if (!root.querySelectorAll) return;

        root.querySelectorAll('*').forEach(element => {
            if (element.shadowRoot) {
                observeRoot(element.shadowRoot);
                scheduleReplace(element.shadowRoot);
            }
        });
    }

    function startObservers() {
        if (document.documentElement) {
            observeRoot(document.documentElement);
        }

        if (document.body) {
            observeRoot(document.body);
        }

        observeShadowRootsInside(document);
    }

    function initializeTranslations() {
        const cachedData = getCachedTranslationsData();

        if (cachedData) {
            setTranslationsData(cachedData, { fromCache: true });
        }

        if (window.TRANSLATIONS_DATA) {
            setTranslationsData(window.TRANSLATIONS_DATA);
        }

        window.addEventListener('translationsLoaded', function (event) {
            setTranslationsData(event.detail || {});
        });

        window.addEventListener('translationsUpdated', function (event) {
            setTranslationsData(event.detail || {});
        });
    }

    if (document.readyState === 'loading') {
        startObservers();

        document.addEventListener('DOMContentLoaded', () => {
            startObservers();

            if (hasTranslations()) {
                safeReplaceAll();
            }
        });
    } else {
        startObservers();
    }

    initializeTranslations();

    setInterval(() => {
        safeReplaceAll();
    }, CONFIG.FULL_SCAN_INTERVAL_MS);

    setInterval(() => {
        safeRepairClickSrcsets();
    }, CONFIG.SRCSET_FIX_INTERVAL_MS);

    setInterval(() => {
        observeShadowRootsInside(document);
    }, CONFIG.SHADOW_SCAN_INTERVAL_MS);
})();