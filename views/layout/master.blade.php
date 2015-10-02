<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Argon Admin Area</title>
        <link rel="stylesheet" href="/argon/css/app.css">
        @section('styles')
        @show
    </head>

    <body class="dashboard">

        <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
            <ul class="nav navbar-nav pull-right">
                @if($currentUser->hasPermission('cms:settings'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('settings') }}">Settings</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" href="{{ route('cms:user:profile') }}">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
            </ul>
            <a class="navbar-brand" href="{{ route('dashboard') }}">Argon</a>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    @foreach ($plugins->getNavLinksForUser($currentUser) as $group)
                        <ul class="nav nav-pills nav-stacked">
                            @foreach ($group as $plugin)
                                <li class="nav-item"><a class="nav-link" href="{{$plugin->url}}">{{$plugin->name}}</a></li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>

                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="/argon/js/jquery.min.js"></script>
        <script src="/argon/js/bootstrap.min.js"></script>
        <script>
            $('#locale-select').change(function () {
                var val = $(this).val();
                var url = "{!! route('cms:locales:set', ['_ID_']) !!}";
                url = url.replace('_ID_', val);
                document.location = url + '?return=' + encodeURI(document.location);
            });

            // Add confirm class to elements that should trigger confirm window
            // To show custom text, add data-confirm attribute on html element
            $('.confirm').on('click', function(){
                return doubleCheck(this);
            });

            // Generic js confirm window wrapper.
            // To show confirm window, just add confirm class to html elements that should trigger confirm window.
            // To show custom text either pass it as a second parameter (text) or add data-confirm attribute on html element.
            function doubleCheck(el, text)
            {
                if(!text){
                    // get value of data-confirm attribute if present or use default confirm text
                    text = el.dataset.confirm || "Are you sure you want to continue?";
                }
                return confirm(text);
            }

        </script>
        @section('footer')
        @show

    </body>
</html>
