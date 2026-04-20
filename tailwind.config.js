/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./resources/scripts/**/*.js",
    "./resources/styles/**/*.css"
  ],
  theme: {
    extend: {
      fontSize: {
        'base': '16px',
        'h1': '48px', 
        'h2': '36px',
        'h3': '30px',
        'h4': '24px',
        'h5': '20px',
        'h6': '18px',
      },
      colors: {
        primary: '#00B6CB',
        primary_light: '#ABE0E6',
        primary_dark: '#018898',
        secondary: '#F7C80C',
        secondary_light: '#EDE1B4',
        accent: '#101935',
        surface: '#F3F3F3',
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
        'primary-gradient': 'linear-gradient(90deg, #00B6CB 62%, #101935 100%)',
      },
      container: {
        center: true,
        screens: {
          sm: '640px',
          md: '768px',
          lg: '1024px',
          xl: '1280px',
          '2xl': '1280px',
        },
      },
    },
  },
  plugins: [],
}