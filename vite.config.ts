import path from 'path'
import { defineConfig } from 'vite'
import WindiCSS from 'vite-plugin-windicss'
import LiveReload from 'vite-plugin-live-reload'

export default defineConfig({
  resolve: {
    alias: {
      '~/': `${path.resolve(__dirname, 'resources')}/`,
    },
  },
  plugins: [
    WindiCSS(),
    LiveReload('resources/views/**/*.blade.php'),
  ],
  build: {
    manifest: true,
    rollupOptions: {
      input: 'resources/ts/main.ts',
    },
    outDir: 'public/',
    emptyOutDir: false,
    assetsDir: './',
  },
  publicDir: 'public/',
})
