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
                <div class="sidebar__container">
                    <div class="sidebar__overlay"></div>
                    <div class="sidebar">
                        <div class="sidebar__user">
                            <div class="sidebar__img">
                                <img src="{{ asset('argon/assets/img/user.png') }}" alt="user">
                            </div>
                            <span class="sidebar__name">Hannah Blue</span>
                        </div>
                        <ul class="sidebar__nav">
                            <li class="sidebar__nav-item">
                                <a class="sidebar__nav-link ic-da" href="#">
                                    <span>Dashboard</span>
                                    <span class="sidebar__nav-alert">2</span>
                                </a>
                            </li>
                            <li class="sidebar__nav-item">
                                <a class="sidebar__nav-link ic-si" href="#">
                                    <span>Sitemap</span>
                                </a>
                            </li>
                            <li class="sidebar__nav-item">
                                <a class="sidebar__nav-link ic-po" href="#">
                                    <span>Posts</span>
                                </a>
                            </li>
                            <li class="sidebar__nav-item">
                                <a class="sidebar__nav-link ic-me" href="#">
                                    <span>Media library</span>
                                </a>
                            </li>
                            <li class="sidebar__nav-item">
                                <a class="sidebar__nav-link ic-bl" href="#">
                                    <span>Blocks</span>
                                </a>
                            </li>
                            <li class="sidebar__nav-item">
                                <a class="sidebar__nav-link ic-fo" href="#">
                                    <span>Forms</span>
                                </a>
                            </li>
                            <li class="sidebar__nav-item">
                                <a class="sidebar__nav-link ic-re" href="#">
                                    <span>Redirects</span>
                                </a>
                            </li>
                            <li class="sidebar__nav-item">
                                <a class="sidebar__nav-link ic-us" href="#">
                                    <span>Users</span>
                                </a>
                            </li>
                        </ul>
                        <div class="sidebar__logo">
                            <img src="{{ asset('/argon/assets/img/e.png') }}" alt="logo">
                        </div>
                    </div>
                </div>
                <div class="main">
                    <div class="container-fluid bg-grey">
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <div class="tabs">
                                    <div class="tabs__header">
                                        <h1>Sitemap</h1>
                                        <ul class="tabs__items">
                                            <li class="tabs__item"><a href="#" class="active">PAGES</a></li>
                                            <li class="tabs__item"><a href="#">REVISIONS</a></li>
                                        </ul>
                                    </div>
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
