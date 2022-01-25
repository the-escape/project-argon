const mix = require('laravel-mix')

mix.sass('resources/assets/sass/app.scss', 'public/css', {
    sassOptions: {
        includePaths: ['../../../bower_components/bootstrap/scss']
    }
})

mix.scripts(
    [
        'resources/assets/js/argon.js',
        'resources/assets/js/fields.js',
        'resources/assets/js/fields/boolean.js',
        'resources/assets/js/fields/button.js',
        'resources/assets/js/fields/combo.js',
        'resources/assets/js/fields/datetime.js',
        'resources/assets/js/fields/file.js',
        'resources/assets/js/fields/item.js',
        'resources/assets/js/fields/select.js',
        'resources/assets/js/fields/text.js',
        'resources/assets/js/fields/wysiwyg.js',
        'resources/assets/js/fields/location.js',
        'resources/assets/js/localisations.js'
    ],
    'public/js/argon.js'
)

mix.copy('bower_components/font-awesome/fonts', 'public/fonts')
mix.copy('bower_components/jquery/dist/jquery.*', 'public/js')
mix.copy('bower_components/jquery.ui/ui/core.js', 'public/js')
mix.copy('bower_components/jquery.ui/ui/widget.js', 'public/js')
mix.copy('bower_components/jquery.ui/ui/mouse.js', 'public/js')
mix.copy('bower_components/jquery.ui/ui/accordion.js', 'public/js')
mix.copy('bower_components/jquery.ui/ui/sortable.js', 'public/js')
mix.copy('bower_components/bootstrap/dist/js/bootstrap.*', 'public/js')
mix.copy('bower_components/tether/dist/js/tether.min.js', 'public/js')
mix.copy('bower_components/jstree/dist/jstree.min.js', 'public/js')
mix.copy('bower_components/jstree/dist/themes/default', 'public/js/jstree')
mix.copy('bower_components/ckeditor', 'public/js/ckeditor')
mix.copy('bower_components/ace-builds/src-min', 'public/js/ace')
mix.copy('bower_components/dropzone/dist/min/dropzone.min.js', 'public/js')
mix.copy('bower_components/handlebars/handlebars.min.js', 'public/js')
mix.copy('bower_components/fancybox/source/jquery.fancybox.pack.js', 'public/js')
mix.copy('bower_components/fancybox/source', 'public/css/fancybox')
