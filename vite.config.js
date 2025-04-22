import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    host: true, // penting! biar bisa diakses dari luar
    hmr: {
      host: 'promtb-25-k95ii.ondigitalocean.app', // Ganti dengan domain DigitalOcean
    },
  },
  plugins: [
    laravel([
      'resources/css/app.css',
      'resources/js/app.js',
    ]),
  ],
});
