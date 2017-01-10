<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CMS Admin Area</title>
        <link rel="stylesheet" href="{{ asset('argon/assets/css/libs.min.css') }}">
        <link rel="stylesheet" href="{{ asset('argon/assets/css/main.min.css') }}">
    </head>
    <body>
        <div class="container-fluid full-height">
            <div class="row full-height">
                @include('argon::partials.sidebar')
                <div class="main">
                    <div class="container-fluid bg-grey">
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div class="tabs">
                                    <div class="tabs__header">
                                        <h1>{{ $name }}</h1>
                                        <ul class="tabs__items">
                                            {!! $tabs !!}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        <script type="application/javascript" src="{{ asset('argon/assets/js/libs.min.js') }}"></script>
        <script type="application/javascript" src="{{ asset('argon/assets/js/main.min.js') }}"></script>
    </body>
</html>
