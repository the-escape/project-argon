<?php

$prefix = config('argon.admin_route_prefix');

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', 'Escape\Argon\Authentication\Http\Controllers\AuthController@getLogin');
    Route::post('login', 'Escape\Argon\Authentication\Http\Controllers\AuthController@postLogin');
    Route::get(
        'logout',
        ['as' => 'logout', 'uses' => 'Escape\Argon\Authentication\Http\Controllers\AuthController@getLogout']
    );
});
