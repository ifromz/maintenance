<?php

/*
 * Registration Routes
 */

Route::group(array('prefix' => 'register', 'namespace' => 'Controllers'), function () {
    Route::get('', array(
        'as' => 'maintenance.register',
        'uses' => 'AuthController@getRegister',
    ));

    Route::get('why', array(
        'as' => 'maintenance.register.why',
        'uses' => 'AuthController@getWhyRegister',
    ));

    Route::post('', array(
        'as' => 'maintenance.register',
        'uses' => 'AuthController@postRegister',
    ));
});