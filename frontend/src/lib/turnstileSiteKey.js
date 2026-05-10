function normalizeEnvValue(value) {
  if (typeof value !== "string") {
    return "";
  }

  const trimmed = value.trim();
  if (
    (trimmed.startsWith('"') && trimmed.endsWith('"')) ||
    (trimmed.startsWith("'") && trimmed.endsWith("'"))
  ) {
    return trimmed.slice(1, -1).trim();
  }

  return trimmed;
}

export const TURNSTILE_SITE_KEY = normalizeEnvValue(import.meta.env.VITE_TURNSTILE_SITE_KEY);

export function turnstileUiEnabled() {
  return Boolean(TURNSTILE_SITE_KEY);
}
