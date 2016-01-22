var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss', 'public/css', {
        includePaths: ['bower_components/bootstrap/scss']
    });

    mix.scripts(
        [
            'argon.js',
            'fields.js',
            'fields/boolean.js',
            'fields/text.js',
            'fields/wysiwyg.js',
            'localisations.js',
        ],
        'public/js/argon.js'
    )

    mix.copy('bower_components/jquery/dist/jquery.*', 'public/js');

    mix.copy('bower_components/jquery.ui/ui/core.js', 'public/js');
    mix.copy('bower_components/jquery.ui/ui/widget.js', 'public/js');
    mix.copy('bower_components/jquery.ui/ui/mouse.js', 'public/js');
    mix.copy('bower_components/jquery.ui/ui/accordion.js', 'public/js');
    mix.copy('bower_components/jquery.ui/ui/sortable.js', 'public/js');

    mix.copy('bower_components/bootstrap/dist/js/bootstrap.*', 'public/js');
    mix.copy('bower_components/tether/dist/js/tether.min.js', 'public/js');

    mix.copy('bower_components/jstree/dist/jstree.min.js', 'public/js');

    mix.copy('bower_components/jstree/dist/themes/default', 'public/js/jstree');
    mix.copy('bower_components/ckeditor', 'public/js/ckeditor');

    mix.copy('bower_components/dropzone/dist/min/dropzone.min.js', 'public/js');
});

