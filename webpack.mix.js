const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    // postCss: [ tailwindcss('./path/to/your/tailwind.config.js') ],
    postCss: [ tailwindcss('./tailwind.config.js') ],
  })

// mix.postCss('resources/css/tw.css', 'public/css', [
//   require('tailwindcss'),
// ])
// .js('resources/js/app.js', 'public/js')
