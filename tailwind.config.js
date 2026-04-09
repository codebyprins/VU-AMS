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
        primary_light: '#ABE0E6',
        primary_dark: '#018898',
        secondary: '#F7C80C',
        secondary_light: '#EDE1B4',
        accent: '#101935',
      },
      fontFamily: {
        sans: ['Heebo', 'sans-serif'],
      },
      padding: {
        section_base: '80px',
        section_medium: '40px',
        section_small: '20px',
        container_base: '60px',
        container_small: '40px',
        container_large: '80px',
      },
      borderRadius: {
        'base': '12px',
      },
    },
  },
  plugins: [],
}