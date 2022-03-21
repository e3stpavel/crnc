import path from 'path'
import { defineConfig } from 'vite'
import WindiCSS from 'vite-plugin-windicss'

export default defineConfig({
  resolve: {
    alias: {
      '~/': `${path.resolve(__dirname, 'resources')}/`,
    },
  },
  plugins: [
    WindiCSS(),
  ],
  build: {
    manifest: true,
    rollupOptions: {
      input: 'resources/ts/main.ts',
    },
  },
  publicDir: 'public/',
})
