<?php

/*
 * Permission Routes
 */

Route::get('permission-denied', [
    'as' => 'maintenance.permission-denied.index',
    'uses' => 'Controllers\PermissionDeniedController@getIndex',
]);
