<?php

$prefix = config('argon.admin_route_prefix', 'admin');
$options = [
    'prefix' => $prefix,
    'middleware' => ['web']
];

if(legacyLv())
{
    unset($options['middleware']);
}

Route::group($options, function () {

    Route::get('login', [
        'as' => 'login',
        'uses' => legacyLv() ?
                    'Escape\\Argon\\Authentication\\Controllers\\LegacyAuthController@getLogin' :
                    'Escape\\Argon\\Authentication\\Controllers\\AuthController@showLoginForm'
    ]);
    Route::post('login', [
        'as' => 'login',
        'uses' => legacyLv() ?
                    'Escape\\Argon\\Authentication\\Controllers\\LegacyAuthController@postLogin' :
                    'Escape\\Argon\\Authentication\\Controllers\\AuthController@login'
    ]);
    Route::get('logout', [
        'as' => 'logout',
        'uses' => legacyLv() ?
                    'Escape\\Argon\\Authentication\\Controllers\\LegacyAuthController@getLogout' :
                    'Escape\\Argon\\Authentication\\Controllers\\AuthController@logout'
    ]);

    Route::group(['middleware' => 'auth'], function() {

        Route::get('/', [
            'as' => 'dashboard',
            'uses' => 'Escape\\Argon\\Core\\Controllers\\DashboardController@dashboard'
        ]);
        Route::post('/submit-feedback-form', [
            'as' => 'dashboard:submit-feedback',
            'uses' => 'Escape\\Argon\\Core\\Controllers\\DashboardController@submitFeedback'
        ]);

    });

    // TODO: Implement? Commented out since not present and breaks listing routes.
    // Route::get('settings', ['as' => 'settings', 'uses' => 'Escape\\Argon\\Controllers\\SettingsController@index']);
});
