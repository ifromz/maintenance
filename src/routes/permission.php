<?php

/*
 * Permission Routes
 */

Route::get('permission-denied', array(
    'as'=>'maintenance.permission-denied.index',
    'uses'=>'Stevebauman\Maintenance\Controllers\PermissionDeniedController@getIndex'
));