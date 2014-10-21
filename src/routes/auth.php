<?php

/*
 * Authentication Routes
 */
    
Route::group(array('prefix'=>'login', 'namespace'=>'Controllers', 'before'=>'maintenance.notauth'), function(){

        Route::get('', array(
                'as' => 'maintenance.login',
                'uses'=>'AuthController@getLogin',
        ));

        Route::post('', array(
                'as' => 'maintenance.login',
                'uses'=>'AuthController@postLogin',
        ));

});

Route::group(array('namespace'=>'Controllers', 'before'=>'maintenance.auth'), function(){

    Route::get('logout', array(
            'as' => 'maintenance.logout',
            'uses'=>'AuthController@getLogout',
    ));

});
   