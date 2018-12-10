<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>CMS Admin Area</title>
        <link rel="stylesheet" href="/argon/css/main.css">
        <link rel="adminroot" href="/admin">
    </head>
    <body class="c-login__bg">

        @section('header')
        @show

        @yield('content')

        <div class="modals">@yield('modals')</div>

        <script src="/argon/vendor/libs.js"></script>
        <script>
            function fetchJs() {
                fetch('/argon/js/manifest.json')
                    .then(function (data) {
                        return data.json();
                    })
                    .then(function (manifestfiles) {
                        if (!loadjs.isDefined('js')) {
                            var files = []

                            files.push('/argon' + manifestfiles['main.js'])

                            if(manifestfiles['vendor.js']){
                                files.push('/argon' + manifestfiles['vendor.js'])
                            }

                            loadjs(files, 'js', {
                                async: false
                            });
                        }
                    });
            }

            if (typeof window.fetch === "undefined") {
                loadjs(['/argon/vendor/polyfill.min.js', '/argon/vendor/fetch.js'], {
                    success: fetchJs
                });
            } else {
                fetchJs();
            }
        </script>
    </body>
</html>
