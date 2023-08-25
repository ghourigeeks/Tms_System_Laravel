const mix = require('laravel-mix');

mix.sass('resources/sass/plugins.bundle.scss', 'public/assets/css').version();
mix.sass('resources/sass/prismjs.bundle.scss', 'public/assets/css').version();
mix.sass('resources/sass/style.bundle.scss', 'public/assets/css').version();

mix.sass('resources/sass/app.scss', 'public/assets/css/').version();
mix.sass('resources/sass/datatables.bundle.scss', 'public/assets/css').version();

mix.sass('resources/sass/fullcalendar.bundle.scss', 'public/assets/css').version();

mix.js('resources/js/app.js', 'public/js');
   // mix.sass('resources/sass/app.scss', 'public/css');
