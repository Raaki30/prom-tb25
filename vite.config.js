import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    host: true,
    hmr: {
      host: 'promtb-25-k95ii.ondigitalocean.app',
      protocol: 'wss', // ✅ Wajib untuk HTTPS
      port: 443, // ✅ Port standar HTTPS
    },
    watch: {
      usePolling: true // ✅ Penting jika pakai Docker/WSL
    }
  },
  plugins: [
    laravel([
      'resources/css/app.css',
      'resources/js/app.js',
    ]),
  ],
});