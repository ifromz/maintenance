<?php

/*
 * Dashboard Routes
 */

Route::get('/', ['as' => 'maintenance.dashboard.index', 'uses' => 'DashboardController@index']);
