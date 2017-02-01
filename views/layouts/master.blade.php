<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">
        <title>CMS</title>
        <link rel="stylesheet" href="{{ asset('argon/assets/css/app.css') }}">
    </head>
    <body class="@yield('class')">
        <div id="app">
            <div class="container-fluid full-height">
                <div class="row full-height">
                    @include('argon::partials.sidebar')
                    <div class="main">
                        @if (isset($tabs))
                            @include ('argon::partials.tabs')
                        @endif
                        <div class="container-fluid">
                            <div class="row full-height">
                                <div class="col-xs-10 col-xs-offset-1">
                                    <div class="main__content">
                                        @yield('body')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="application/javascript" src="{{ asset('argon/assets/js/app.js') }}"></script>
    </body>
</html>
