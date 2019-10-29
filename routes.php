<?php

$prefix = config('argon.admin_route_prefix');

Route::group(['prefix' => 'admin', 'middleware' => ['web']], function () {
    Route::get('login', 'Escape\\Argon\\Authentication\\Controllers\\AuthController@showLoginForm');
    Route::post('login', 'Escape\\Argon\\Authentication\\Controllers\\AuthController@login');
    Route::get(
        'logout',
        ['as' => 'logout', 'uses' => 'Escape\\Argon\\Authentication\\Controllers\\AuthController@logout']
    );
    Route::get('/', ['as' => 'dashboard', 'uses' => 'Escape\\Argon\\Core\\Controllers\\DashboardController@dashboard']);

    // TODO: Implement? Commented out since not present and breaks listing routes.
    // Route::get('settings', ['as' => 'settings', 'uses' => 'Escape\\Argon\\Controllers\\SettingsController@index']);
});
