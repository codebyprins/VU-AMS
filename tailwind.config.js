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
        section_md: '40px',
        section_sm: '20px',
        container_base: '60px',
        container_sm: '40px',
        container_lg: '80px',
      },
      borderRadius: {
        'base': '12px',
      },
      backgroundImage: {
        'primary-gradient': 'linear-gradient(90deg, #00B6CB 0%, #101935 100%)',
      },
    },
  },
  plugins: [],
}