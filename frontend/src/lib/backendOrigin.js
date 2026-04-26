function parseOrigin(input) {
    try {
        return new URL(input);
    } catch {
        return null;
    }
}

function getConfiguredValues() {
    return {
        backendOrigin: import.meta.env.VITE_BACKEND_ORIGIN,
        apiBaseUrl: import.meta.env.VITE_API_BASE_URL,
    };
}

function currentOriginFallback() {
    if (typeof window !== "undefined" && window.location?.origin) {
        return window.location.origin;
    }
    return "http://127.0.0.1:8000";
}

function normalizeConfiguredOrigin() {
    const { backendOrigin, apiBaseUrl } = getConfiguredValues();
    const primary = typeof backendOrigin === "string" ? backendOrigin.trim() : "";
    const secondary = typeof apiBaseUrl === "string" ? apiBaseUrl.trim() : "";
    const configured = primary || secondary || currentOriginFallback();

    if (configured.startsWith("/")) {
        return currentOriginFallback();
    }

    const parsed = parseOrigin(configured);
    if (!parsed) {
        return currentOriginFallback();
    }

    return `${parsed.protocol}//${parsed.host}`;
}

export function resolveBackendOrigin() {
    const configuredOrigin = normalizeConfiguredOrigin();
    return configuredOrigin;
}

export function resolveApiBaseUrl() {
    const { apiBaseUrl } = getConfiguredValues();
    if (typeof apiBaseUrl === "string" && apiBaseUrl.trim().startsWith("/")) {
        return apiBaseUrl.trim();
    }

    return `${resolveBackendOrigin()}/api`;
}
