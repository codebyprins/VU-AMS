import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'public',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: '/resources/scripts/app.js'
    }
  }
});