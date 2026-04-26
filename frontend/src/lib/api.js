import axios from "axios";
import { getDeviceHeaders } from "./device";
import { resolveApiBaseUrl } from "./backendOrigin";

const baseURL = resolveApiBaseUrl();
const TOKEN_KEY = import.meta.env.VITE_TOKEN_KEY || "fs_token";

const api = axios.create({
  baseURL,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
  withCredentials: true, // Allow cookies for CSRF
});

const localAssetPattern =
  /^http:\/\/(localhost|127\.0\.0\.1|host\.docker\.internal|backend|10\.\d+\.\d+\.\d+|192\.168\.\d+\.\d+|172\.(1[6-9]|2\d|3[0-1])\.\d+\.\d+)(:\d+)?(\/.*)?$/i;

const rewriteLocalhostUrls = (value) => {
  if (typeof window === "undefined" || !window.location?.origin) return value;

  if (typeof value === "string") {
    const match = value.match(localAssetPattern);
    if (!match) return value;
    const path = match[3] || "";
    return `${window.location.origin}${path}`;
  }

  if (Array.isArray(value)) {
    return value.map((item) => rewriteLocalhostUrls(item));
  }

  if (value && typeof value === "object") {
    const next = {};
    Object.entries(value).forEach(([key, item]) => {
      next[key] = rewriteLocalhostUrls(item);
    });
    return next;
  }

  return value;
};

// Get CSRF token from meta tag
const getCsrfToken = () => {
  const meta = document.querySelector('meta[name="csrf-token"]');
  return meta ? meta.getAttribute("content") : null;
};

// Attach Bearer token to requests
api.interceptors.request.use((config) => {
  config.baseURL = resolveApiBaseUrl();
  const isNgrokBase = typeof config.baseURL === "string" && config.baseURL.includes("ngrok-free.");
  const isNgrokHost =
    typeof window !== "undefined" &&
    typeof window.location?.host === "string" &&
    window.location.host.includes("ngrok-free.");

  if (isNgrokBase || isNgrokHost) {
    config.headers["ngrok-skip-browser-warning"] = "true";
  }

  const token = localStorage.getItem(TOKEN_KEY);
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  // Add CSRF token if available
  const csrfToken = getCsrfToken();
  if (csrfToken) {
    config.headers["X-CSRF-TOKEN"] = csrfToken;
  }

  const deviceHeaders = getDeviceHeaders();
  Object.entries(deviceHeaders).forEach(([key, value]) => {
    config.headers[key] = value;
  });

  return config;
});

// Response interceptor to handle 401 errors
api.interceptors.response.use(
  (response) => {
    response.data = rewriteLocalhostUrls(response.data);
    return response;
  },
  async (error) => {
    const originalRequest = error.config;

    if (error.response?.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;

      // Clear invalid token and redirect to login
      localStorage.removeItem(TOKEN_KEY);
      window.location.href = "/login";
    }

    return Promise.reject(error);
  }
);

export { TOKEN_KEY };
export default api;

