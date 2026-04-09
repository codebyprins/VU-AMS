import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [tailwindcss()],
  build: {
    manifest: true,
    outDir: 'public',
    rollupOptions: {
      input: {
        app: './resources/scripts/app.js',
      },
    },
  },
})