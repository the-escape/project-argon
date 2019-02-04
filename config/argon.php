<?php

return [
    'admin_route_prefix' => '/admin',
    'client_logo_dark' => '/argon/images/logo.png',
    'client_logo_light' => '/argon/images/logo.png',
    'typography_styles' => '/css/typography.css',

    'block_preview_popover_template' => '<div class="popover" role="tooltip" style="max-width: 600px;"><div class="popover-arrow"></div><h3 class="popover-title"></h3><div class="popover-content"><div class="data-content"></div></div></div>',

    'admin_css' => '
        .argon-login h1 { background-color: #fff; }

        .navbar.bg-inverse { background-color: #373a3c; }

        a,
        .nav-link,
        .btn-link,
        .btn-primary-outline { color: #0275d8; }

        .btn-primary { background-color: #0275d8; }

        .btn-primary,
        .btn-primary-outline { border-color: #0275d8; }

        .btn-primary-outline:hover,
        .btn-primary-outline:focus,
        .btn-primary-outline:active,
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .open .btn-primary-outline.dropdown-toggle { background-color: #025aa5; }

        .btn-primary-outline:hover,
        .btn-primary-outline:focus,
        .btn-primary-outline:active,
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .open .btn-primary-outline.dropdown-toggle { border-color: #025aa5; }

        a:hover,
        .btn-link:hover,
        .btn-link:active,
        .btn-link:focus { color: #025aa5; }

        .logo-admin-login { width:auto; margin-bottom:auto; max-width:100%; }

        .navbar { padding-left:0; padding-top:0; padding-bottom:0; height:51px; }
        .navbar .navbar-nav { height:51px; }
        .navbar .navbar-nav .nav-item { height:51px; }
        .navbar .navbar-nav .nav-link { line-height:51px; padding-top:0; padding-bottom:0; }
        .navbar .navbar-brand { padding:0; margin:0; }
        .navbar .navbar-brand .logo-admin { height:51px; padding:0; margin:0; }
    ',

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

    'medialibrary' => [
        'perpage' => 20,
        'optimize' => [
            'enable' => env('IMAGE_OPTIM_ENABLE', true),
        ],
        'fix_thumbs' => false, // set to true on existing projects to update the thumb file name
    ],

    'dashboard_widgets' => [
        'order' => [
            'manage-site-content',
            'blog-and-media',
            'recent-activity',
            'analytics-link',
            'account-manager',
            'feedback-form',
        ],
        'create_blog_post_link' => '',
        'create_blog_post_label' => 'Create news article',
        'account_manager_name' => 'The Escape',
        'account_manager_phone' => '+44 (0) 1256 334567',
        'account_manager_email' => '',
    ]
];
