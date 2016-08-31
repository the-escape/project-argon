<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}">
    <title>CMS Admin Area</title>
    <link rel="stylesheet" href="/argon/js/jstree/style.min.css">
    <link rel="stylesheet" href="/argon/css/app.css">
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

<script src="/argon/js/jquery.min.js"></script>
<script src="/argon/js/bootstrap.min.js"></script>
<script src="/argon/js/ckeditor/ckeditor.js"></script>
<script src="/argon/js/jstree.min.js"></script>
<script src="/argon/js/argon.js"></script>

@foreach($assetsManager->outputScripts() as $script)
    <script src="{{$script}}"></script>
@endforeach

@section('footer')
@show

</body>
</html>
