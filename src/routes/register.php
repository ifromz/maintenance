<?php

/*
 * Registration Routes
 */

Route::group(['prefix' => 'register', 'namespace' => 'Controllers'], function () {
    Route::get('', [
        'as' => 'maintenance.register',
        'uses' => 'AuthController@getRegister',
    ]);

    Route::get('why', [
        'as' => 'maintenance.register.why',
        'uses' => 'AuthController@getWhyRegister',
    ]);

    Route::post('', [
        'as' => 'maintenance.register',
        'uses' => 'AuthController@postRegister',
    ]);
});