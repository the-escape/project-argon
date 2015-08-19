<?php

$prefix = config('argon.admin_route_prefix');

Route::group(['prefix' => 'admin'], function () {

    Route::get('login', 'Escape\\Argon\\Authentication\\Controllers\\AuthController@getLogin');
    Route::post('login', 'Escape\\Argon\\Authentication\\Controllers\\AuthController@postLogin');
    Route::get(
        'logout',
        ['as' => 'logout', 'uses' => 'Escape\\Argon\\Authentication\\Controllers\\AuthController@getLogout']
    );
    Route::get('/', ['as' => 'dashboard', 'uses' => 'Escape\\Argon\\Core\\Controllers\\DashboardController@dashboard']);

    Route::get('settings', ['as' => 'settings', 'uses' => 'Escape\\Argon\\Controllers\\SettingsController@index']);
});
