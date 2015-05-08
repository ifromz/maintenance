<?php

/*
 * Work Order Routes
 */

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'WorkOrder'], function () {

    Route::get('work-orders/assigned', [
        'as' => 'maintenance.work-orders.assigned.index',
        'uses' => 'AssignedController@index',
    ]);

    Route::resource('work-orders/priorities', 'PriorityController', [
        'only' => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.work-orders.priorities.index',
            'create' => 'maintenance.work-orders.priorities.create',
            'store' => 'maintenance.work-orders.priorities.store',
            'show' => 'maintenance.work-orders.priorities.show',
            'edit' => 'maintenance.work-orders.priorities.edit',
            'update' => 'maintenance.work-orders.priorities.update',
            'destroy' => 'maintenance.work-orders.priorities.destroy',
        ],
    ]);

    Route::resource('work-orders/statuses', 'StatusController', [
        'only' => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.work-orders.statuses.index',
            'create' => 'maintenance.work-orders.statuses.create',
            'store' => 'maintenance.work-orders.statuses.store',
            'show' => 'maintenance.work-orders.statuses.show',
            'edit' => 'maintenance.work-orders.statuses.edit',
            'update' => 'maintenance.work-orders.statuses.update',
            'destroy' => 'maintenance.work-orders.statuses.destroy',
        ],
    ]);

    Route::get('work-orders/categories/json', [
            'as' => 'maintenance.work-orders.categories.json',
            'uses' => 'CategoryController@getJson',
        ]
    );

    Route::get('work-orders/categories/create/{categories?}', [
            'as' => 'maintenance.work-orders.categories.nodes.create',
            'uses' => 'CategoryController@create',
        ]
    );

    Route::post('work-orders/categories/move/{categories?}', [
        'as' => 'maintenance.work-orders.categories.nodes.move',
        'uses' => 'CategoryController@postMoveCategory',
    ]);

    Route::post('work-orders/categories/create/{categories?}', [
            'as' => 'maintenance.work-orders.categories.nodes.store',
            'uses' => 'CategoryController@store',
        ]
    );

    Route::resource('work-orders/categories', 'CategoryController', [
        'only' => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.work-orders.categories.index',
            'create' => 'maintenance.work-orders.categories.create',
            'store' => 'maintenance.work-orders.categories.store',
            'edit' => 'maintenance.work-orders.categories.edit',
            'update' => 'maintenance.work-orders.categories.update',
            'destroy' => 'maintenance.work-orders.categories.destroy',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Maintenance Work Order Routes
    |--------------------------------------------------------------------------
    */
    Route::post('work-orders/{work_orders}/start-session', [
        'as' => 'maintenance.work-orders.session.start',
        'uses' => 'SessionController@postStart',
    ]);

    Route::post('work-orders/{work_orders}/end-session/{session}', [
        'as' => 'maintenance.work-orders.session.end',
        'uses' => 'SessionController@postEnd',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Maintenance Work Order Report Routes
    |--------------------------------------------------------------------------
    */
    Route::resource('work-orders/{work_orders}/report', 'ReportController', [
        'only' => [
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'create' => 'maintenance.work-orders.report.create',
            'store' => 'maintenance.work-orders.report.store',
            'show' => 'maintenance.work-orders.report.show',
            'edit' => 'maintenance.work-orders.report.edit',
            'update' => 'maintenance.work-orders.report.update',
            'destroy' => 'maintenance.work-orders.report.destroy',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Maintenance Work Order Request Routes
    |--------------------------------------------------------------------------
    */
    Route::get('work-orders/requests/create/{work_requests}', [
        'as' => 'maintenance.work-orders.requests.create',
        'uses' => 'RequestController@create',
    ]);

    Route::put('work-orders/requests/{work_requests}', [
        'as' => 'maintenance.work-orders.requests.store',
        'uses' => 'RequestController@store',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Maintenance Work Order Routes
    |--------------------------------------------------------------------------
    */
    Route::resource('work-orders', 'WorkOrderController', [
        'names' => [
            'index' => 'maintenance.work-orders.index',
            'create' => 'maintenance.work-orders.create',
            'store' => 'maintenance.work-orders.store',
            'show' => 'maintenance.work-orders.show',
            'edit' => 'maintenance.work-orders.edit',
            'update' => 'maintenance.work-orders.update',
            'destroy' => 'maintenance.work-orders.destroy',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Maintenance Work Order Update Routes
    |--------------------------------------------------------------------------
    */
    Route::resource('work-orders.updates', 'UpdateController', [
        'only' => [
            'store',
            'destroy',
        ],
        'names' => [
            'store' => 'maintenance.work-orders.updates.store',
            'destroy' => 'maintenance.work-orders.updates.destroy',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Maintenance Work Order Assignment Routes
    |--------------------------------------------------------------------------
    */
    Route::resource('work-orders.assignments', 'AssignmentController', [
        'only' => [
            'index',
            'create',
            'store',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.work-orders.assignments.index',
            'create' => 'maintenance.work-orders.assignments.create',
            'store' => 'maintenance.work-orders.assignments.store',
            'destroy' => 'maintenance.work-orders.assignments.destroy',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Maintenance Work Order Part / Supply Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['namespace' => 'Part'], function () {

        Route::get('work-orders/{work_orders}/parts', [
            'uses' => 'PartController@index',
            'as' => 'maintenance.work-orders.parts.index',
        ]);

        Route::get('work-orders/{work_orders}/parts/{inventory}/stocks', [
            'as' => 'maintenance.work-orders.parts.stocks.index',
            'uses' => 'StockController@index',
        ]);

        Route::get('work-orders/{work_orders}/parts/{inventory}/stocks/{stocks}/add', [
            'as' => 'maintenance.work-orders.parts.stocks.create',
            'uses' => 'StockController@create',
        ]);

        Route::post('work-orders/{work_orders}/parts/{inventory}/stocks/{stocks}', [
            'as' => 'maintenance.work-orders.parts.stocks.store',
            'uses' => 'StockController@store',
        ]);

        Route::post('work-orders/{work_orders}/parts/{inventory}/stocks/{stocks}/put-back', [
            'as' => 'maintenance.work-orders.parts.stocks.put-back',
            'uses' => 'StockController@postPutBack',
        ]);

        Route::post('work-orders/{work_orders}/parts/{inventory}/stocks/{stocks}/put-back-some', [
            'as' => 'maintenance.work-orders.parts.stocks.put-back-some',
            'uses' => 'StockController@postPutBackSome',
        ]);

    });

    /*
     * Work Order Attachment Upload Routes
     */
    Route::group(['namespace' => 'Attachment'], function () {

        Route::post('work-orders/attachments/uploads', [
            'as' => 'maintenance.work-orders.attachments.uploads.store',
            'uses' => 'UploadController@store',
        ]);

        Route::post('work-orders/attachments/uploads/destroy', [
            'as' => 'maintenance.work-orders.attachments.uploads.destroy',
            'uses' => 'UploadController@destroy',
        ]);

        Route::resource('work-orders.attachments', 'AttachmentController', [
            'only' => [
                'index',
                'create',
                'store',
                'show',
                'destroy',
            ],
            'names' => [
                'index' => 'maintenance.work-orders.attachments.index',
                'create' => 'maintenance.work-orders.attachments.create',
                'store' => 'maintenance.work-orders.attachments.store',
                'show' => 'maintenance.work-orders.attachments.show',
                'destroy' => 'maintenance.work-orders.attachments.destroy',
            ],
        ]);

    });

    Route::resource('work-orders.notifications', 'NotificationController', [
        'only' => [
            'store',
            'update',
        ],
        'names' => [
            'store' => 'maintenance.work-orders.notifications.store',
            'update' => 'maintenance.work-orders.notifications.update',
        ],
    ]);

    Route::resource('work-orders.events', 'EventController', [
        'names' => [
            'index' => 'maintenance.work-orders.events.index',
            'create' => 'maintenance.work-orders.events.create',
            'store' => 'maintenance.work-orders.events.store',
            'show' => 'maintenance.work-orders.events.show',
            'edit' => 'maintenance.work-orders.events.edit',
            'update' => 'maintenance.work-orders.events.update',
            'destroy' => 'maintenance.work-orders.events.destroy',
        ],
    ]);

});
