const COOKIE_KEY_EVENT_ID = '_axeid';
const QUERY_PARAM_ALEID = 'aleid';
const QUERY_PARAM_AXEID = 'axeid';

// Pixel log endpoint configuration
const PIXEL_LOG_ENDPOINT = 'https://b.applovin.com/v1/log';
const PIXEL_TYPE = 'shopify';

async function _sendPixelLog(level, message) {
  const logData = {
    pixel_type: PIXEL_TYPE,
    logs: [
      {
        level: level,
        timestamp: Date.now(),
        message: `${message} url: ${window?.location?.href || 'unknown'}`,
      },
    ],
  };

  await fetch(PIXEL_LOG_ENDPOINT, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(logData),
  });
}

async function _axGetCurrentCartAleId() {
  try {
    const cartResponse = await fetch((window?.Shopify?.routes?.root || '/') + 'cart.js');
    const cartData = await cartResponse.json();
    return cartData.attributes?._axon_event_id || null;
  } catch (error) {
    console.error('Error retrieving cart event ID:', error);
    return null;
  }
}

async function _axValidateAleId(expectedAleId) {
  if (!expectedAleId) {
    return;
  }

  const currentAleId = await _axGetCurrentCartAleId();
  if (!currentAleId) return;

  if (currentAleId !== expectedAleId) {
    throw new Error(
      `Event ID mismatch v2: expected ${expectedAleId}, got ${currentAleId}`
    );
  }
}

async function _axUpdateCartAttributes(aleid, maxRetries = 3, delay = 1000, attempt = 1) {
  try {
    const response = await fetch((window?.Shopify?.routes?.root || '/') + 'cart/update.js', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify({
        attributes: {
          _axon_event_id: aleid,
        },
      }),
    });

    if (!response.ok) {
      throw new Error(response.statusText + ' ' + response.status);
    }

    const result = await response.json();

    if (result.errors) {
      throw new Error(result.errors);
    }

    await _axValidateAleId(aleid);

    return result;
  } catch (error) {
    if (attempt < maxRetries) {
      setTimeout(
        async () => await _axUpdateCartAttributes(aleid, maxRetries, delay, attempt + 1),
        delay * attempt
      );
    } else {
      await _sendPixelLog('error', error.message);
      throw error;
    }
  }
}

function _axGetCookie(name) {
  try {
    const cookie = document.cookie.split('; ').find(row => row.startsWith(name + '='));
    return cookie ? cookie.split('=')[1] : null;
  } catch (error) {
    return null;
  }
}

function _axGetLocalStorage(name) {
  try {
    return window.localStorage.getItem(name);
  } catch (error) {
    return null;
  }
}

function _axGetUrlParameter(name) {
  try {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
  } catch (error) {
    return null;
  }
}

function _axGetAleid() {
  return (
    _axGetUrlParameter(QUERY_PARAM_ALEID) ||
    _axGetUrlParameter(QUERY_PARAM_AXEID) ||
    _axGetCookie(COOKIE_KEY_EVENT_ID) ||
    _axGetLocalStorage(COOKIE_KEY_EVENT_ID)
  );
}

const aleid = _axGetAleid();
if (aleid) {
  _axUpdateCartAttributes(aleid);
}
