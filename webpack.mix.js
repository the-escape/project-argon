const { mix } = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/argon/assets/js')
    .sass('resources/assets/sass/app.scss', 'public/argon/assets/css');

/*
mix.copy('public/assets/js/app.js', '../public/argon/assets/js/app.js');
mix.copy('public/assets/css/app.css', '../public/argon/assets/css/app.css');
*/