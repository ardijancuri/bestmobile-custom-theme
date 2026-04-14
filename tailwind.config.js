/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './assets/js/src/**/*.js',
    './template-parts/**/*.php',
    './woocommerce/**/*.php',
    './page-templates/**/*.php',
  ],
  theme: {
    extend: {
      screens: {
        'sm': '375px',
        'tablet-sm': '640px',
        'tablet': '768px',
        'md': '810px',
        'lg': '1024px',
        'xl': '1280px',
        'xxl': '1360px',
      },
      maxWidth: {
        'site': '1280px',
        'site-xxl': '1360px',
      },
      colors: {
        primary: {
          DEFAULT: 'var(--color-primary, #E15726)',
          light: 'var(--color-primary-light, #FCEEE9)',
        },
        gray: {
          50: '#F9FAFB',
          100: '#F3F4F6',
          200: '#E5E7EB',
          300: '#D1D5DB',
          400: '#9CA3AF',
          500: '#6B7280',
          600: '#4B5563',
          700: '#252525',
          800: '#1A1A1A',
          900: '#111827',
        },
        green: {
          DEFAULT: '#36B37E',
        },
        red: {
          DEFAULT: '#E34850',
        },
        'black-dark': '#1A1A1A',
        'black-light': '#4B4B4B',
        blue: {
          100: '#ECF3FF',
          500: '#4B7DF3',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
