import React, { useEffect, useRef, useState } from "react";
import { ensureTurnstileScript } from "../lib/ensureTurnstile.js";

export default function TurnstileField({ siteKey, onToken, onError, disabled, theme = "auto" }) {
  const containerRef = useRef(null);
  const widgetIdRef = useRef(null);
  const onTokenRef = useRef(onToken);
  const onErrorRef = useRef(onError);
  const [scriptError, setScriptError] = useState(null);

  onTokenRef.current = onToken;
  onErrorRef.current = onError;

  useEffect(() => {
    if (!siteKey || typeof siteKey !== "string" || !siteKey.trim()) {
      return;
    }

    let cancelled = false;

    const run = async () => {
      setScriptError(null);
      try {
        await ensureTurnstileScript();
      } catch (e) {
        if (!cancelled) {
          setScriptError(String(e?.message || e));
          onTokenRef.current?.(null);
          onErrorRef.current?.("script_load_failed");
        }
        return;
      }

      if (cancelled || !containerRef.current || !window.turnstile) {
        return;
      }

      widgetIdRef.current = window.turnstile.render(containerRef.current, {
        sitekey: siteKey.trim(),
        theme,
        retry: "never",
        callback: (token) => {
          if (!cancelled) {
            onTokenRef.current?.(token);
          }
        },
        "expired-callback": () => {
          if (!cancelled) {
            onTokenRef.current?.(null);
          }
        },
        "timeout-callback": () => {
          if (!cancelled) {
            onTokenRef.current?.(null);
          }
        },
        "error-callback": (code) => {
          if (!cancelled) {
            onTokenRef.current?.(null);
            onErrorRef.current?.(code != null ? String(code) : "widget_error");
          }
        },
      });
    };

    run();

    return () => {
      cancelled = true;
      const id = widgetIdRef.current;
      widgetIdRef.current = null;
      if (id != null && window.turnstile) {
        try {
          window.turnstile.remove(id);
        } catch {
          // ignore
        }
      }
    };
  }, [siteKey, theme]);

  if (!siteKey || !siteKey.trim()) {
    return null;
  }

  return (
    <div className="space-y-2">
      <div
        ref={containerRef}
        className={`min-h-[65px] flex items-center justify-center ${disabled ? "pointer-events-none opacity-50" : ""}`}
        aria-live="polite"
      />
      {scriptError && (
        <p className="text-sm text-red-600 dark:text-red-400">{scriptError}</p>
      )}
    </div>
  );
}
