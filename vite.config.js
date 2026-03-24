import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  root: 'resources',
  server: {
    port: 5173,
    strictPort: true,
    watch: { usePolling: true },
    cors: true,
    hmr: {
      host: 'localhost',
      port: 5173,
    },
  },
  build: {
    outDir: '../public',
    emptyOutDir: true,
    rollupOptions: {
      input: path.resolve(__dirname, 'resources/scripts/app.js'),
      output: {
        entryFileNames: 'app.js',
        chunkFileNames: 'app-[name].js',
        assetFileNames: ({ name }) =>
          name && name.endsWith('.css') ? 'app.css' : '[name]-[hash][extname]',
      },
    },
  },
});