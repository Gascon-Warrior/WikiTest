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
      backgroundImage: {
       "van-sunset": "url('/img/van-sunset.webp')"
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

