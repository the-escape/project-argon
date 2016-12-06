<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CMS Admin Area</title>
        <meta name="description" content="CMS" />
        <meta name="author" content="The Escape" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/argon/css/app.css">
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
            .logo-admin-login {
                {{config('argon.logo-admin-login')}}
            }


            /* NEW ^ */

            html, body {
                height: 100%;
                width: 100%;
            }
            body {
                padding: 0;
                background: url('/argon/images/bg.png') center / cover no-repeat;
            }
            .fill {
                height: 100%;
                max-height: 100%;
            }
            .login {
                height: 100%;
                width: 100%;
            }
            .login__box {
                position: absolute;
                top: 40%;
                left: 15px;
                right: 15px;
                transform: translateY(-40%);
                text-align: center;
            }
            .login__logo {
                margin: 0 auto 60px;
                display: block;
            }
            .login__form {
                /**/
            }
            .login__form-group {
                float: left;
                width: 100%;
                margin-bottom: 20px;
            }
            .login__form-group:last-of-type {
                margin-bottom: 0;
            }
            .login__btn {
                margin-top: 30px;
            }
            .text {
                border: 0;
            }
            a {
                display: block;
                text-decoration: underline;
                color: #FFFFFF;
                font-size: 14px;
                margin-top: 60px;
            }
            a:hover {
                color: #FFFFFF;
            }
            .margin__b--n {
                margin-bottom: 0;
            }
        </style>
    </head>
    <body>
        <div class="login">
            <div class="container fill">
                <div class="row margin__b--n fill">
                    <div class="col-sm-6 col-sm-offset-3 fill">
                        <div class="login__box">
                            <img class="login__logo" src="/argon/images/e.png" width="38" height="63" alt="logo">
                            <form class="login__form">
                                <div class="login__form-group">
                                    <input type="text" name="email" placeholder="Email*" class="input text" required>
                                </div>
                                <div class="login__form-group">
                                    <input type="password" name="emaipasswordl" placeholder="Password*" class="input text" required>
                                </div>
                                <button type="submit" class="login__btn button">SIGN IN</button>
                            </form>
                            <a href="#">Forgotten your password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!--
    <body class="argon-login">
        <div class="bg"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-md-push-4">
                    <div>
                        <img class="logo" src="/argon/images/e.png" width="38" height="63" alt="{{config('argon.client_name', 'Argon')}}">
                    </div>
                    <div class="login-box">
                        @if(!$errors->isEmpty())
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                {{$errors->get('email')[0]}}
                            </div>
                        @endif
                        <form action="/admin/login" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <input type="text" name="email" placeholder="Email*" class="input text" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password*" class="input text" required>
                            </div>
                            <button type="submit" class="button">SIGN IN</button>
                            <a href="#">Forgotten your password?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="/argon/js/jquery.min.js"></script>
        <script src="/argon/js/bootstrap.min.js"></script>
    </body>
    -->
</html>
