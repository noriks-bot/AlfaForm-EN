"use strict";
(function () {
  // Metrics url
  // const metricsCaptureEndpoint = "https://oguzj351o7.execute-api.us-east-1.amazonaws.com/prod/errors";
  const metricsCaptureEndpoint = "https://0q7b8q723g.execute-api.us-east-1.amazonaws.com/prod/errors";
  const QUEUE_SIZE_LIMIT = 100;
  const FLUSH_THRESHOLD = 50;
  let isSendingMetrics = false;

  // send error metrics to server
  function sendErrorMetrics() {
    if (isSendingMetrics) return; // Avoid concurrent execution

    let errorData = JSON.parse(localStorage.getItem("via_error_logs")) || [];
    if (errorData.length) {
      isSendingMetrics = true;

      const records = errorData.map(error => ({
        "Data": encodeData(error)
      }));

      const reqBody = {
        "DeliveryStreamName": "ShopifyFrontEndErrorStream",
        "Records": records
      };
      fetch(metricsCaptureEndpoint, {
        method: "POST",
        keepalive: true,
        headers: {
          "Content-Type": "application/json",
          // "x-api-key": "ovk2vUJW7quU568VbDCjanL74MC8Gcl6BI73SxH6",
        },
        body: JSON.stringify(reqBody),
      }).then(() => {
        localStorage.removeItem("via_error_logs");
      }).catch(err => {
        console.warn("Error sending metrics:", err);
      }).finally(() => {
        isSendingMetrics = false; // Reset flag after completion
      });
    }
  }

  function encodeData(data) {
    const jsonString = JSON.stringify(data);
    const encoder = new TextEncoder();
    const encodedData = encoder.encode(jsonString);
    const base64String = btoa(String.fromCharCode(...encodedData));

    return base64String;
  }

  function dispatchErrorMetrics(errorJson, type) {
    let localStorageErrorLogs = JSON.parse(localStorage.getItem("via_error_logs")) || [];
    let errorSet = new Set(localStorageErrorLogs.map(err => err.message));
    const store = (errorJson.srcElement && errorJson.srcElement.Shopify)
      ? errorJson.srcElement.Shopify.shop
      : "Unknown store";
    const errorData = {
      type: type,
      message: errorJson.message || "Unknown error",
      filename: errorJson.filename || "Unknown source",
      error_details: JSON.stringify({
        line: errorJson.lineno || 0,
        column: errorJson.colno || 0,
        stack: errorJson.error ? errorJson.error.stack.toString() : "No error object"
      }),
      store_domain: store,
      page_url: window.location.href,
      theme_id: window.Shopify?.theme?.id,
      theme_type: window.Shopify?.theme?.schema_name,
      created_at: new Date().toISOString(),
      useragent: navigator.userAgent
    };
    const parsedErrorDetails = JSON.parse(errorData.error_details);
    const viaAppPaths = ["apps/via/", "apps/via_dev/"];
    if (!errorSet.has(errorData.message) && parsedErrorDetails.stack !== "No error object" &&
      viaAppPaths.some(path => errorData.filename.includes(path))) {
      localStorageErrorLogs.push(errorData);
    }
    // Set maximum number of errors localStorage can persist
    if (localStorageErrorLogs.length > QUEUE_SIZE_LIMIT) localStorageErrorLogs.shift();
    localStorage.setItem("via_error_logs", JSON.stringify(localStorageErrorLogs));
    // Flush the errors if limit is exceeded
    if (localStorageErrorLogs.length >= FLUSH_THRESHOLD) sendErrorMetrics();
  }

  function initialize() {
    window.addEventListener('error', (function (event) {
      dispatchErrorMetrics(event, 'error');
    }));

    window.addEventListener('unhandledrejection', (function (event) {
      dispatchErrorMetrics(event, 'unhandledrejection');
    }));

    // Send error metrics on tab close
    window.addEventListener("beforeunload", (function () {
      sendErrorMetrics();
    }));
  }

  // Add the event listeners
  initialize();
})();
