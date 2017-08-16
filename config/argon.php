<?php

return [
    'admin_route_prefix' => '/admin',
    'client_logo_dark' => '/assets/img/logo-admin.png',
    'client_logo_light' => '/assets/img/logo-admin.png',
    'highlight_color' => '#009baa',
    'highlight_color_darker' => '#ff7b09',
    'neutral_color' => '#3F5463',
    'logo-admin-login' => 'width:auto; margin-bottom: 30px; max-width:100%;',
    'navbar' => 'padding-left: 0;padding-top: 0;padding-bottom: 0;height: 51px;',
    'navbar-nav' => 'height:51px;',
    'nav-item' => 'height:51px;',
    'nav-link' => 'line-height:51px; padding-top:0; padding-bottom:0;',
    'navbar-brand' => 'padding:0;margin:0;',
    'logo-admin' => 'height:30px; padding:0; margin:10px;',

    'sitemap_view' => 'argon::pages.sitemap',

    'client_name' => 'Sentinel Housing',

    /*
     * Options for jstree open on load:
     * " 'open_all' "
     * " 'close_all' "
     * " 'open_node', ['#node-1','#node-7'] "
     * */
    'jstree' => [
        'load' => [
            'open' => " 'open_node', ['#node-1'] ",
        ]
    ],

    'views' => [
        1 => 'pages.home',
        2 => 'pages.blocks',
        4 => 'pages.news',
        5 => 'pages.news-single',
        12 => 'pages.search',
        13 => 'pages.sitemap',
        14 => 'pages.property',
        15 => 'pages.development-listing',
        16 => 'pages.development',
    ],
];