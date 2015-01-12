<?php

/*
 * Dashboard Routes
 */

Route::get('/', array(
    'as' => 'maintenance.dashboard.index',
    'uses' => 'MaintenanceController@getIndex',
));