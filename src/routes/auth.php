<?php

/*
 * Authentication Routes
 */
Route::group(['prefix' => 'login', 'namespace' => 'Controllers', 'before' => 'maintenance.notauth'], function ()
{
    Route::get('', [
        'as' => 'maintenance.login',
        'uses' => 'AuthController@getLogin',
    ]);

    Route::post('', [
        'as' => 'maintenance.login',
        'uses' => 'AuthController@postLogin',
    ]);

    Route::get('forgot-password', [
        'as' => 'maintenance.login.forgot-password',
        'uses' => 'PasswordController@getRequest',
    ]);

    Route::post('forgot-password', [
        'as' => 'maintenance.login.forgot-password',
        'uses' => 'PasswordController@postRequest',
    ]);

    Route::get('reset-password/{users}/{code}', [
        'as' => 'maintenance.login.reset-password',
        'uses' => 'PasswordController@getReset',
    ]);

    Route::post('reset-password/{users}/{code}', [
        'as' => 'maintenance.login.reset-password',
        'uses' => 'PasswordController@postReset',
    ]);
});

Route::group(['namespace' => 'Controllers', 'before' => 'maintenance.auth'], function ()
{
    Route::get('logout', [
        'as' => 'maintenance.logout',
        'uses' => 'AuthController@getLogout',
    ]);
});
   