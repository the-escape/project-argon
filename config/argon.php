<?php

return [
    'admin_route_prefix' => '/admin',
    'client_logo_dark' => '/argon/images/logo.png',
    'client_logo_light' => '/argon/images/logo.png',
    'highlight_color' => '#0275d8',
    'highlight_color_darker' => '#014c8c',
    'neutral_color' => '#373a3c',
    'logo-admin-login' => 'width:auto; margin-bottom:auto; max-width:100%',
    'navbar' => 'padding-left:0; padding-top:0; padding-bottom:0; height:51px;',
    'navbar-nav' => 'height:51px;',
    'nav-item' => 'height:51px;',
    'nav-link' => 'line-height:51px; padding-top:0; padding-bottom:0;',
    'navbar-brand' => 'padding:0; margin:0;',
    'logo-admin' => 'height:51px; padding:0; margin:0;',

    'sitemap_view' => 'argon::pages.sitemap',

    'client_name' => '',

    /*
     * Options for jstree open on load:
     * " 'open_all' "
     * " 'close_all' "
     * " 'open_node', ['#node-1','#node-7'] "
     * */
    'jstree' => [
        'load' => [
            'open' => " 'open_all' ",
        ]
    ],

    // content type Id to view template mapping
    'views' => [],
];
