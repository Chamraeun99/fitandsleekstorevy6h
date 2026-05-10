/**
 * Loads the Turnstile API once per page load (explicit render mode).
 */

let loadPromise = null;

export function ensureTurnstileScript() {
  if (typeof window === "undefined") {
    return Promise.reject(new Error("Turnstile requires a browser."));
  }
  if (window.turnstile) {
    return Promise.resolve();
  }
  if (loadPromise) {
    return loadPromise;
  }

  loadPromise = new Promise((resolve, reject) => {
    const cbName = "__fitandsleekTurnstileApiOnLoad";
    window[cbName] = () => {
      try {
        delete window[cbName];
      } catch {
        window[cbName] = undefined;
      }
      resolve();
    };

    const script = document.createElement("script");
    script.src = `https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit&onload=${cbName}`;
    script.async = true;
    script.defer = true;
    script.onerror = () => {
      loadPromise = null;
      reject(new Error("Turnstile script failed to load."));
    };
    document.head.appendChild(script);
  });

  return loadPromise;
}
