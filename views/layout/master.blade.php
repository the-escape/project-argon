<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CMS Admin Area</title>
    @include('argon::inc.primary-colour-css-variable')
    <link rel="stylesheet" href="/argon/css/old-cms.css">
    <link rel="stylesheet" href="/argon/css/main.css">
    <link rel="adminroot" href="/admin">
    @foreach ($assetsManager->outputStyles() as $styles)
        <link rel="stylesheet" href="{{$styles}}">
    @endforeach
    @section('styles')
    @show
    <style>
        {{ config('argon.admin_css', '') }}
    </style>
</head>

<body id="@yield('body-id','')" class="@yield('body-class', 'dashboard')">

@include('argon::inc.nav')

@section('header')
@show

@yield('content')

<div class="modals">@yield('modals')</div>

<script src="/argon/vendor/jquery.min.js"></script>
<script src="/argon/js/core.js"></script>
<script src="/argon/js/widget.js"></script>
<script src="/argon/js/mouse.js"></script>
<script src="/argon/js/accordion.js"></script>
<script src="/argon/js/sortable.js"></script>
<script src="/argon/js/tether.min.js"></script>
<script src="/argon/js/bootstrap.min.js"></script>
<script src="/argon/vendor/ckeditor/ckeditor.js"></script>
<script src="/argon/vendor/jstree.min.js"></script>
<script src="/argon/js/bootstrap-datepicker.min.js"></script>
<script src="/argon/js/handlebars.min.js"></script>
<script src="/argon/js/jquery.fancybox.pack.js"></script>
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
            loadjs(['/argon/vendor/polyfill.min.js', '/argon/vendor/fetch.js'], {
                success: fetchJs
            });
        } else {
            fetchJs();
        }
</script>

@foreach($assetsManager->outputScripts() as $script)
    <script src="{{$script}}"></script>
@endforeach

@section('footer')
@show

</body>
</html>
