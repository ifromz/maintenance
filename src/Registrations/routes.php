<?php

/*
 * Maintenance Application Routes
 */
Route::group(['prefix' => Config::get('maintenance.site.prefix'), 'as' => 'maintenance.', 'namespace' => 'Stevebauman\Maintenance\Http\Controllers'], function ()
{
    /*
     * Welcome Route
     */
    Route::get('/', ['as' => 'welcome.index', 'uses' => 'WelcomeController@index']);

    /*
     * Permission Denied Route
     */
    Route::get('permission-denied', ['as' => 'permission-denied.index', 'uses' => 'PermissionDeniedController@getIndex']);

    /*
     * Authentication Routes
     */
    Route::group(['prefix' => 'login', 'as' => 'login.', 'middleware' => ['maintenance.not-auth']], function ()
    {
        Route::get('/', ['uses' => 'AuthController@authenticate']);

        Route::post('/', ['uses' => 'AuthController@login']);

        Route::get('forgot-password', ['as' => 'forgot-password', 'uses' => 'PasswordController@getRequest']);

        Route::post('forgot-password', ['as' => 'forgot-password', 'uses' => 'PasswordController@postRequest']);

        Route::get('reset-password/{users}/{code}', ['as' => 'reset-password', 'uses' => 'PasswordController@getReset']);

        Route::post('reset-password/{users}/{code}', ['as' => 'reset-password', 'uses' => 'PasswordController@postReset']);
    });

    Route::group(['middleware' => ['maintenance.auth']], function ()
    {
        Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    });

    /*
     * Registration Routes
     */
    Route::group(['prefix' => 'register', 'middleware' => ['maintenance.notauth']], function ()
    {
        Route::get('', ['as' => 'register', 'uses' => 'AuthController@getRegister']);

        Route::post('', ['as' => 'register', 'uses' => 'AuthController@postRegister']);
    });

    /*
     * Client Routes
     */
    Route::group(['prefix' => 'client', 'as' => 'client.', 'namespace' => 'Client', 'middleware' => ['maintenance.auth', 'maintenance.permission']], function ()
    {
        Route::group(['namespace' => 'WorkRequest', 'as' => 'work-requests.'], function()
        {
            Route::resource('work-requests', 'Controller', [
                'names' => [
                    'index' => 'index',
                    'create' => 'create',
                    'store' => 'store',
                    'show' => 'show',
                    'edit' => 'edit',
                    'update' => 'update',
                    'destroy' => 'destroy',
                ],
            ]);

            Route::resource('work-requests.updates', 'UpdateController', [
                'only' => [
                    'store',
                    'destroy',
                ],
                'names' => [
                    'store' => 'updates.store',
                    'destroy' => 'updates.destroy',
                ],
            ]);
        });
    });

    /*
     * Management Routes
     */
    Route::group(['prefix' => 'management', 'middleware' => ['maintenance.auth', 'maintenance.permission']], function ()
    {
        Route::get('/', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

        /*
         * Event Routes
         */
        Route::group(['namespace' => 'Event', 'as' => 'events.',], function ()
        {
            Route::resource('events', 'Controller', [
                'names' => [
                    'index' => 'index',
                    'create' => 'create',
                    'store' => 'store',
                    'show' => 'show',
                    'edit' => 'edit',
                    'update' => 'update',
                    'destroy' => 'destroy',
                ],
            ]);

            Route::resource('events.report', 'ReportController', [
                'only' => [
                    'store',
                    'edit',
                    'update',
                    'destroy',
                ],
                'names' => [
                    'store' => 'report.store',
                    'edit' => 'report.edit',
                    'update' => 'report.update',
                    'destroy' => 'report.destroy',
                ],
            ]);
        });

        /*
         * Work Request Routes
         */
        Route::group(['namespace' => 'WorkRequest', 'as' => 'work-requests.'], function ()
        {
            Route::resource('work-requests', 'Controller', [
                'names' => [
                    'index' => 'index',
                    'create' => 'create',
                    'store' => 'store',
                    'show' => 'show',
                    'edit' => 'edit',
                    'update' => 'update',
                    'destroy' => 'destroy',
                ],
            ]);

            Route::resource('work-requests.updates', 'UpdateController', [
                'only' => [
                    'store',
                    'destroy',
                ],
                'names' => [
                    'store' => 'updates.store',
                    'destroy' => 'updates.destroy',
                ],
            ]);
        });

        /*
         * Work Order Routes
         */
        include 'routes/work-order.php';

        /*
         * Asset Routes
         */
        include 'routes/asset.php';

        /*
         * Inventory Routes
         */
        include 'routes/inventory.php';

        /*
         * Location Routes
         */
        include 'routes/location.php';

        /*
         * Metric Routes
         */
        include 'routes/metric.php';

        /*
         * Administration Route Group
         */
        Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function ()
        {
            /*
             * Administration Routes
             */
            include 'routes/admin.php';
        });
    });
}); /* End Maintenance Routes */
