function getTelegramWebApp() {
  if (typeof window === "undefined") return null;
  return window.Telegram?.WebApp ?? null;
}

export function initTelegramWebApp() {
  const tg = getTelegramWebApp();
  if (!tg) return;

  try {
    tg.ready();
    tg.expand();
    tg.setHeaderColor("secondary_bg_color");
  } catch {
    // Prevent Telegram-specific runtime errors from breaking the app.
  }
}

export function triggerTelegramHaptic(type = "impact", style = "light") {
  const tg = getTelegramWebApp();
  if (!tg?.HapticFeedback) return;

  try {
    if (type === "notification") {
      tg.HapticFeedback.notificationOccurred(style);
      return;
    }

    tg.HapticFeedback.impactOccurred(style);
  } catch {
    // Ignore unsupported haptic calls on non-Telegram browsers.
  }
}
