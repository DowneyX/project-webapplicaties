/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
    extend: {
      colors: {
        'primary': '#3f51b5',
        'secondary': '#f50057'
      },
      fontFamily: {
        'space-mono': ['"Space Mono"']
      }
    },
  },
  plugins: [],
}

