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
        grey: '#F1F1F1',
        cyan: '#C4F3EF',
      },
      fontFamily: {
        sans: ['Hauora', 'Guaruja Grotesk', 'Neue Machina'],
      },
      fontSize: {
        'base': '1em',
        'lg': '1.125em',
        'xl': '1.5em',
        '2xl': '2em',
        '3xl': '3.375em',
      },
      letterSpacing: {
        normal: '-0.02em',
        wide: '0em',
      },
      lineHeight: {
        normal: '1.25em',
      },
      screens: {
        // eslint-disable-next-line quote-props
        'md': '834px',
        // eslint-disable-next-line quote-props
        'sm': '414px',
      },
    },
  },
  extract: {
    include: ['resources/**/**/*.{html,js,ts,jsx,tsx,blade.php}'],
    exclude: ['node_modules', '.git'],
  },
})
