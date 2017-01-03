<?php

$prefix = config('argon.admin_route_prefix');

Route::group(['prefix' => 'admin'], function () {

    Route::get('login', 'Escape\\Argon\\Authentication\\Http\\Controllers\\AuthController@getLogin');
    Route::post('login', 'Escape\\Argon\\Authentication\\Http\\Controllers\\AuthController@postLogin');
    Route::get(
        'logout',
        ['as' => 'logout', 'uses' => 'Escape\\Argon\\Authentication\\Http\\Controllers\\AuthController@getLogout']
    );
    Route::get('/', ['as' => 'dashboard', 'uses' => 'Escape\\Argon\\Core\\Controllers\\DashboardController@dashboard']);

    // TODO: Implement? Commented out since not present and breaks listing routes.
    // Route::get('settings', ['as' => 'settings', 'uses' => 'Escape\\Argon\\Controllers\\SettingsController@index']);
});
