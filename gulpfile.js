let elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');

elixir(function (mix) {
    mix.webpack('app.js');
    mix.copy('public/js/app.js', '../public/argon/assets/js/app.js');
});
