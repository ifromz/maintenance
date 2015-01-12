<?php

/*
 * Permission Routes
 */

Route::get('permission-denied', array(
    'as' => 'maintenance.permission-denied.index',
    'uses' => 'Controllers\PermissionDeniedController@getIndex'
));