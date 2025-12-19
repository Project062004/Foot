module.exports = {
  content: ["./public/**/*.{php,html,js}", "./src/**/*.{php,html,js}"],
  theme: {
    extend: {
      colors: {
        terracotta: {
          50: '#fdf8f6',
          100: '#fbeee9',
          200: '#f8dccf',
          300: '#f2c1ad',
          400: '#ea9f82',
          500: '#e07a5f', // Main accent
          600: '#d05e42',
          700: '#ad4932',
          800: '#8e3e2d',
          900: '#733529',
        },
        primary: '#3D405B',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        serif: ['Playfair Display', 'serif'],
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0', transform: 'translateY(10px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        }
      }
    },
  },
  plugins: [],
}
