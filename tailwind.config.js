/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        "th-orange": "#D4683E",        
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

