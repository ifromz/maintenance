<?php

/*
 * Dashboard Routes
 */

Route::get('/', [
    'as' => 'maintenance.dashboard.index',
    'uses' => 'MaintenanceController@getIndex',
]);
