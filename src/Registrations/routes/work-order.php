<?php

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
