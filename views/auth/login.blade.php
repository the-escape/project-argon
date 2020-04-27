<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>CMS Admin Area</title>
    <meta name="description" content="CMS" />
    <meta name="author" content="The Escape" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/argon/css/app.css">
    <style>
        {{ config('argon.admin_css', '') }}
    </style>
</head>
<body class="argon-login">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-push-4 well login">

            <div style="padding: 20px 0 10px;">
                <h1>
                    <img class="logo-admin-login" src="{{config('argon.client_logo_dark', '/argon/images/logo.png')}}" alt="{{config('argon.client_name', 'Argon')}}">
                </h1>

                <h4>Login</h4>
            </div>

            <div class="login-box">
                @if(isset($errors) && !$errors->isEmpty())
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        {{$errors->get('email')[0]}}
                    </div>
                @endif
                <form action="/admin/login" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-submit">Login</button>
                </form>
            </div>

        </div>
    </div>



</div>

<script src="/argon/js/jquery.min.js"></script>
<script src="/argon/js/bootstrap.min.js"></script>

</body>
</html>
