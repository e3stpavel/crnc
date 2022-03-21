import { defineConfig } from 'windicss/helpers'

export default defineConfig({
  theme: {
    extend: {
      colors: {
        blue: {
          100: '#F4F6F8',
          /* 500: '#4b93ff', */
        },
        gray: '#636364',
      },
      fontFamily: {
        sans: ['Hauora', 'Guaruja Grotesk', 'Neue Machina'],
      },
      fontSize: {
        'base': '1em',
        'lg': '1.125em',
        'xl': '1.5em',
        '2xl': '3.375em',
      },
      letterSpacing: {
        normal: '-0.02em',
        wide: '0em',
      },
      lineHeight: {
        normal: '1.25em',
      },
    },
  },
  extract: {
    include: ['resources/**/**/*.{html,js,ts,jsx,tsx,blade.php}'],
    exclude: ['node_modules', '.git'],
  },
})
