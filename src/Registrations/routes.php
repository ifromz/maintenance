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
        Route::group(['prefix' => 'work-orders', 'as' => 'work-orders.', 'namespace' => 'WorkOrder'], function ()
        {
            Route::resource('', 'Controller', [
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

            /*
             * Work Order Update Routes
             */
            Route::resource('updates', 'UpdateController', [
                'only' => [
                    'store',
                    'destroy',
                ],
                'names' => [
                    'store' => 'updates.store',
                    'destroy' => 'updates.destroy',
                ],
            ]);

            /*
             * Work Order Assignment Routes
             */
            Route::resource('assignments', 'AssignmentController', [
                'only' => [
                    'index',
                    'create',
                    'store',
                    'destroy',
                ],
                'names' => [
                    'index' => 'assignments.index',
                    'create' => 'assignments.create',
                    'store' => 'assignments.store',
                    'destroy' => 'assignments.destroy',
                ],
            ]);

            Route::get('assigned', ['as' => 'assigned.index', 'uses' => 'AssignedController@index']);

            /*
             * Work Order Priority Routes
             */
            Route::resource('priorities', 'PriorityController', [
                'only' => [
                    'index',
                    'create',
                    'store',
                    'edit',
                    'update',
                    'destroy',
                ],
                'names' => [
                    'index' => 'priorities.index',
                    'create' => 'priorities.create',
                    'store' => 'priorities.store',
                    'show' => 'priorities.show',
                    'edit' => 'priorities.edit',
                    'update' => 'priorities.update',
                    'destroy' => 'priorities.destroy',
                ],
            ]);

            /*
             * Work Order Status Routes
             */
            Route::resource('statuses', 'StatusController', [
                'only' => [
                    'index',
                    'create',
                    'store',
                    'edit',
                    'update',
                    'destroy',
                ],
                'names' => [
                    'index' => 'statuses.index',
                    'create' => 'statuses.create',
                    'store' => 'statuses.store',
                    'show' => 'statuses.show',
                    'edit' => 'statuses.edit',
                    'update' => 'statuses.update',
                    'destroy' => 'statuses.destroy',
                ],
            ]);

            /*
             * Work Order Request Generation Routes
             */
            Route::get('requests/create/{work_requests}', ['as' => 'requests.create', 'uses' => 'RequestController@create']);

            Route::put('requests/{work_requests}', ['as' => 'requests.store', 'uses' => 'RequestController@store']);

            /*
             * Work Order Category Routes
             */
            Route::resource('categories', 'CategoryController', [
                'only' => [
                    'index',
                    'create',
                    'store',
                    'edit',
                    'update',
                    'destroy',
                ],
                'names' => [
                    'index' => 'categories.index',
                    'create' => 'categories.create',
                    'store' => 'categories.store',
                    'edit' => 'categories.edit',
                    'update' => 'categories.update',
                    'destroy' => 'categories.destroy',
                ],
            ]);

            Route::get('categories/create/{categories}', ['as' => 'categories.nodes.create', 'uses' => 'CategoryController@create']);

            Route::post('categories/create/{categories?}', ['as' => 'categories.nodes.store', 'uses' => 'CategoryController@store']);

            /*
             * Nested Work Order Routes
             */
            Route::group(['prefix' => '{work_orders}'], function ()
            {
                /*
                 * Work Order Session Routes
                 */
                Route::get('sessions', ['as' => 'sessions.index', 'uses' => 'SessionController@index']);

                Route::post('sessions/start', ['as' => 'sessions.start', 'uses' => 'SessionController@postStart']);

                Route::post('sessions/end', ['as' => 'sessions.end', 'uses' => 'SessionController@postEnd']);

                /*
                 * Work Order Report Routes
                 */
                Route::resource('report', 'ReportController', [
                    'only' => [
                        'create',
                        'store',
                        'show',
                        'edit',
                        'update',
                        'destroy',
                    ],
                    'names' => [
                        'create' => 'report.create',
                        'store' => 'report.store',
                        'show' => 'report.show',
                        'edit' => 'report.edit',
                        'update' => 'report.update',
                        'destroy' => 'report.destroy',
                    ],
                ]);

                /*
                 * Work Order Attachment Routes
                 */
                Route::get('attachments/{attachments}/download', ['as' => 'attachments.download', 'uses' => 'AttachmentController@download']);

                Route::resource('attachments', 'AttachmentController', [
                    'names' => [
                        'index' => 'attachments.index',
                        'create' => 'attachments.create',
                        'store' => 'attachments.store',
                        'show' => 'attachments.show',
                        'edit' => 'attachments.edit',
                        'update' => 'attachments.update',
                        'destroy' => 'attachments.destroy',
                    ],
                ]);

                /*
                 * Work Order Notification Routes
                 */
                Route::resource('notifications', 'NotificationController', [
                    'only' => [
                        'store',
                        'update',
                    ],
                    'names' => [
                        'store' => 'notifications.store',
                        'update' => 'notifications.update',
                    ],
                ]);

                /*
                 * Work Order Event Routes
                 */
                Route::resource('events', 'EventController', [
                    'names' => [
                        'index' => 'events.index',
                        'create' => 'events.create',
                        'store' => 'events.store',
                        'show' => 'events.show',
                        'edit' => 'events.edit',
                        'update' => 'events.update',
                        'destroy' => 'events.destroy',
                    ],
                ]);

                /*
                 * Work Order Part Routes
                 */
                Route::group(['prefix' => 'parts', 'as' => 'parts.', 'namespace' => 'Part'], function ()
                {
                    Route::get('parts', ['as' => 'index', 'uses' => 'Controller@index']);

                    Route::get('{inventory}/stocks', ['as' => 'stocks.index', 'uses' => 'StockController@index']);

                    Route::get('{inventory}/stocks/{stocks}/take', ['as' => 'stocks.take', 'uses' => 'StockController@getTake']);

                    Route::post('{inventory}/stocks/{stocks}/take', ['as' => 'stocks.take', 'uses' => 'StockController@postTake']);

                    Route::get('{inventory}/stocks/{stocks}/put-back', ['as' => 'stocks.put', 'uses' => 'StockController@getPut']);

                    Route::post('{inventory}/stocks/{stocks}/put-back', ['as' => 'stocks.put', 'uses' => 'StockController@postPut']);
                });
            });
        });

        /*
         * Asset Routes
         */
        Route::group(['prefix' => 'assets', 'as' => 'asset.', 'namespace' => 'Asset'], function ()
        {
            /*
             * Asset Routes
             */
            Route::resource('', 'Controller', [
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

            /*
             * Asset Event Routes
             */
            Route::resource('events', 'EventController', [
                'names' => [
                    'index' => 'events.index',
                    'create' => 'events.create',
                    'store' => 'events.store',
                    'show' => 'events.show',
                    'edit' => 'events.edit',
                    'update' => 'events.update',
                    'destroy' => 'events.destroy',
                ],
            ]);

            /*
             * Category Routes
             */
            Route::resource('categories', 'CategoryController', [
                'only' => [
                    'index',
                    'create',
                    'store',
                    'edit',
                    'update',
                    'destroy',
                ],
                'names' => [
                    'index' => 'categories.index',
                    'create' => 'categories.create',
                    'store' => 'categories.store',
                    'edit' => 'categories.edit',
                    'update' => 'categories.update',
                    'destroy' => 'categories.destroy',
                ],
            ]);

            Route::get('categories/json', ['as' => 'categories.json', 'uses' => 'CategoryController@getJson']);

            Route::get('categories/create/{categories}', ['as' => 'categories.nodes.create', 'uses' => 'CategoryController@create']);

            Route::post('categories/create/{categories?}', ['as' => 'categories.nodes.store', 'uses' => 'CategoryController@store']);

            Route::post('categories/move/{categories?}', ['as' => 'categories.nodes.move', 'uses' => 'CategoryController@postMoveCategory']);

            /*
             * Nested Asset Routes
             */
            Route::group(['prefix' => '{assets}'], function ()
            {
                /*
                 * Asset Work Order Routes
                 */
                Route::get('work-orders', ['as' => 'work-orders.index', 'uses' => 'WorkOrderController@index']);

                Route::get('work-orders/attachable', ['as' => 'work-orders.attach.index', 'uses' => 'WorkOrderController@attach']);

                Route::post('work-orders/{work_orders}/attach', ['as' => 'work-orders.attach.store', 'uses' => 'WorkOrderController@store']);

                Route::post('work-orders/{work_orders}/detach', ['as' => 'work-orders.attach.remove', 'uses' => 'WorkOrderController@remove']);

                /*
                 * Asset Manual Routes
                 */
                Route::get('manuals/{manuals}/download', ['as' => 'manuals.download', 'uses' => 'ManualController@download']);

                Route::resource('manuals', 'ManualController', [
                    'names' => [
                        'index' => 'manuals.index',
                        'create' => 'manuals.create',
                        'store' => 'manuals.store',
                        'show' => 'manuals.show',
                        'edit' => 'manuals.edit',
                        'update' => 'manuals.update',
                        'destroy' => 'manuals.destroy',
                    ],
                ]);

                /*
                * Asset Image Routes
                */
                Route::get('images/{images}/download', ['as' => 'images.download', 'uses' => 'ImageController@download']);

                Route::resource('images', 'ImageController', [
                    'names' => [
                        'index' => 'images.index',
                        'create' => 'images.create',
                        'store' => 'images.store',
                        'show' => 'images.show',
                        'edit' => 'images.edit',
                        'update' => 'images.update',
                        'destroy' => 'images.destroy',
                    ],
                ]);

                /*
                 * Asset Meter Routes
                 */
                Route::group(['prefix' => 'meters', 'as' => 'meters.', 'namespace' => 'Meter'], function ()
                {
                    Route::resource('', 'Controller', [
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

                    Route::resource('readings', 'ReadingController', [
                        'only' => [
                            'store',
                            'destroy',
                        ],
                        'names' => [
                            'store' => 'readings.store',
                            'destroy' => 'readings.destroy',
                        ],
                    ]);
                });

            });
        });

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
