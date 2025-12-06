/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["public/*.{html,js,php}",
  "./node_modules/flowbite/**/*.js"
],
theme: {
  extend: {
    colors: {
      orange: {
        50: '#FFFAF0',
        100: '#FEEBC8',
        200: '#FBD38D',
        300: '#F6AD55',
        400: '#ED8936',
        500: '#DD6B20',
        600: '#C05621',
        700: '#9C4221',
        800: '#7B341E',
        900: '#652B19',
      },
    
    },
    
  },
},
  plugins: [ 
    require('@tailwindcss/forms'),
    require('flowbite/plugin'),
],
}
