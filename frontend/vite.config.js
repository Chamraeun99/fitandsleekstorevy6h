import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import path from "path";

const proxyTarget = process.env.VITE_PROXY_TARGET || "http://127.0.0.1:8000";

export default defineConfig({
  plugins: [react()],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "src"),
    },
  },
  server: {
    port: 5173,
    host: "localhost",
    strictPort: true,
    allowedHosts: [
      "gluten-judge-remedial.ngrok-free.dev",
      ".ngrok-free.dev",
      ".ngrok-free.app",
    ],
    hmr: {
      host: "localhost",
      port: 5173,
      protocol: "ws",
    },
    proxy: {
      "/api": {
        target: proxyTarget,
        changeOrigin: true,
        secure: false,
      },
      "/sanctum": {
        target: proxyTarget,
        changeOrigin: true,
        secure: false,
      },
      "/storage": {
        target: proxyTarget,
        changeOrigin: true,
        secure: false,
      },
    },
  },
});
