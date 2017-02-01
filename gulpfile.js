let elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');

elixir(function (mix) {
    mix.webpack('app.js')
        .sass('app.scss')
        .copy('public/js/app.js', '../public/argon/assets/js/app.js')
        .copy('public/css/app.css', '../public/argon/assets/css/app.css');
});
