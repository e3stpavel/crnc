import { defineConfig } from 'windicss/helpers';

export default defineConfig({
  theme: {
    extend: {
      colors: {
        blue: {
          100: "#F3F3F0",
          500: "#4b93ff",
        }
      }
    }
  },
  extract: {
    include: ['resources/**/**/*.{html,js,ts,jsx,tsx,blade.php}'],
    exclude: ['node_modules', '.git'],
  }
})