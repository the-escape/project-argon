<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}">
    <title>CMS Admin Area</title>
    <link rel="stylesheet" href="/argon/css/old-cms.css">
    <link rel="stylesheet" href="/argon/css/main.css">
    <link rel="adminroot" href="/admin">
    @foreach ($assetsManager->outputStyles() as $styles)
        <link rel="stylesheet" href="{{$styles}}">
    @endforeach
    @section('styles')
    @show
    <style>
        .navbar.bg-inverse {
            background-color: {{config('argon.neutral_color', '#373a3c')}};
        }

        a,
        .nav-link,
        .btn-link,
        .btn-primary-outline {
            color: {{config('argon.highlight_color', '#0275d8')}};
        }

        .btn-primary {
            background-color: {{config('argon.highlight_color', '#0275d8')}};
        }

        .btn-primary,
        .btn-primary-outline {
            border-color: {{config('argon.highlight_color', '#0275d8')}};
        }

        .btn-primary-outline:hover,
        .btn-primary-outline:focus,
        .btn-primary-outline:active,
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .open .btn-primary-outline.dropdown-toggle {
            background-color: {{config('argon.highlight_color_darker', config('argon.highlight_color', '#025aa5'))}};
        }

        .btn-primary-outline:hover,
        .btn-primary-outline:focus,
        .btn-primary-outline:active,
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .open .btn-primary-outline.dropdown-toggle {
            border-color: {{config('argon.highlight_color_darker', config('argon.highlight_color', '#025aa5'))}};
        }

        a:hover,
        .btn-link:hover,
        .btn-link:active,
        .btn-link:focus {
            color: {{config('argon.highlight_color_darker', config('argon.highlight_color', '#025aa5'))}};
        }

    </style>
</head>

<body class="dashboard media-browser">


<div class="container-fluid">
    <div class="row">

        @yield('content')

    </div>
</div>

<div class="modals"></div>

<script src="/argon/vendor/ckeditor/ckeditor.js"></script>
<script src="/argon/vendor/jquery.min.js"></script>
<script src="/argon/vendor/jstree.min.js"></script>
<script src="/argon/js/bootstrap.min.js"></script>
<script src="/argon/js/argon.js"></script>

@foreach($assetsManager->outputScripts() as $script)
    <script src="{{$script}}"></script>
@endforeach

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
            loadjs(['/argon/vendor/promise.min.js', '/argon/vendor/fetch.js'], {
                success: fetchJs
            });
        } else {
            fetchJs();
        }
</script>

@section('footer')
@show

</body>
</html>
