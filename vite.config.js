import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  root: './resources', // source folder
  base: './',           // relative paths for WordPress
  build: {
    outDir: path.resolve(__dirname, 'public'), // output folder
    emptyOutDir: true,
    rollupOptions: {
      input: {
        app: path.resolve(__dirname, 'resources/styles/app.css'), // Tailwind CSS entry
        main: path.resolve(__dirname, 'resources/scripts/app.js') // JS entry
      },
      output: {
        entryFileNames: 'js/[name].js',
        assetFileNames: 'css/[name].css',
      },
    },
  },
  css: {
    postcss: path.resolve(__dirname, 'postcss.config.js'),
  },
  server: {
    watch: {
      usePolling: true, // helpful for PHP/WordPress
    },
  },
});