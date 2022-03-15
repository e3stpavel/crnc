import { defineConfig } from 'windicss/helpers';

export default defineConfig({
  theme: {
    extend: {
      colors: {
        blue: "#F3F3F0"
      }
    }
  },
  extract: {
    include: ['resources/**/**/*.{html,blade.php}'],
    exclude: ['node_modules', '.git'],
  }
})