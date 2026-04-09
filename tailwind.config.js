/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./resources/scripts/**/*.js",
    "./resources/styles/**/*.css"
  ],
  theme: {
    extend: {
      colors: {
        primary: '#00B6CB',
        'primary-light': '#ABE0E6',
        secondary: '#F7C80C',
        'secondary-light': '#EDE1B4',
        accent: '#101935',
      },
      fontFamily: {
        sans: ['Heebo', 'sans-serif'],
      },
    },
  },
  plugins: [],
}