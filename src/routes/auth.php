<?php

/*
 * Authentication Routes
 */
Route::group(array('prefix' => 'login', 'namespace' => 'Controllers', 'before' => 'maintenance.notauth'), function ()
{
    Route::get('', array(
        'as' => 'maintenance.login',
        'uses' => 'AuthController@getLogin',
    ));

    Route::post('', array(
        'as' => 'maintenance.login',
        'uses' => 'AuthController@postLogin',
    ));

    Route::get('forgot-password', array(
        'as' => 'maintenance.login.forgot-password',
        'uses' => 'PasswordController@getRequest',
    ));

    Route::post('forgot-password', array(
        'as' => 'maintenance.login.forgot-password',
        'uses' => 'PasswordController@postRequest',
    ));

    Route::get('reset-password/{users}/{code}', array(
        'as' => 'maintenance.login.reset-password',
        'uses' => 'PasswordController@getReset',
    ));

    Route::post('reset-password/{users}/{code}', array(
        'as' => 'maintenance.login.reset-password',
        'uses' => 'PasswordController@postReset',
    ));
});

Route::group(array('namespace' => 'Controllers', 'before' => 'maintenance.auth'), function ()
{
    Route::get('logout', array(
        'as' => 'maintenance.logout',
        'uses' => 'AuthController@getLogout',
    ));
});
   