import { resolveBackendOrigin } from "./backendOrigin";

const backendOrigin = resolveBackendOrigin();

// Normalize any lingering hardcoded dev ports so assets always resolve locally.
const normalizePort = (url) => {
  if (!url) return url;
  return url
    .replace(/localhost:8001/gi, "localhost:8000")
    .replace(/127\.0\.0\.1:8001/g, "127.0.0.1:8000");
};

const hasFileExtension = (value) =>
  /\.(png|jpe?g|webp|gif|avif|svg|mp4|webm|ogg)$/i.test(String(value || ""));

const shouldRewritePrivateHost = (urlString) => {
  try {
    const parsed = new URL(urlString);
    const host = (parsed.hostname || "").toLowerCase();
    return (
      host === "localhost" ||
      host === "127.0.0.1" ||
      host === "host.docker.internal" ||
      host === "backend" ||
      /^10\./.test(host) ||
      /^192\.168\./.test(host) ||
      /^172\.(1[6-9]|2\d|3[0-1])\./.test(host)
    );
  } catch {
    return false;
  }
};

export function resolveImageUrl(imageUrl) {
  if (!imageUrl) return "/placeholder.svg";

  const sanitizedUrl = normalizePort(imageUrl);

  // Handle base64 data URIs (e.g., data:image/jpeg;base64,...)
  if (/^data:/i.test(sanitizedUrl)) return sanitizedUrl;

  // Rewrite localhost URLs so images also work on other devices.
  if (shouldRewritePrivateHost(sanitizedUrl)) {
    try {
      const parsed = new URL(sanitizedUrl);
      return `${backendOrigin}${parsed.pathname}`;
    } catch {
      return sanitizedUrl;
    }
  }

  // Handle external URLs
  if (/^https?:\/\//i.test(sanitizedUrl)) return sanitizedUrl;

  // Handle filename-only values from API (e.g. "abc123.png").
  if (!sanitizedUrl.includes("/") && hasFileExtension(sanitizedUrl)) {
    return `${backendOrigin}/storage/banners/${sanitizedUrl}`;
  }

  // common patterns: /storage/.., storage/.., public/storage/..
  const cleaned = sanitizedUrl.startsWith("/") ? sanitizedUrl : `/${sanitizedUrl}`;
  return `${backendOrigin}${cleaned}`;
}
