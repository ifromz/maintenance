<?php

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
*/

$router->group(['middleware' => ['web']], function (Router $router) {
    Route::group(['as' => 'maintenance.'], function () {
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
        Route::group(['prefix' => 'login', 'as' => 'login.', 'middleware' => ['guest']], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'AuthController@login']);

            Route::post('/', ['as' => 'authenticate', 'uses' => 'AuthController@authenticate']);

            Route::get('forgot-password', ['as' => 'forgot-password', 'uses' => 'PasswordController@getRequest']);

            Route::post('forgot-password', ['as' => 'forgot-password', 'uses' => 'PasswordController@postRequest']);

            Route::get('reset-password/{users}/{code}', ['as' => 'reset-password', 'uses' => 'PasswordController@getReset']);

            Route::post('reset-password/{users}/{code}', ['as' => 'reset-password', 'uses' => 'PasswordController@postReset']);
        });

        Route::group(['middleware' => ['auth']], function () {
            Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
        });

        /*
         * Registration Routes
         */
        Route::group(['prefix' => 'register'], function () {
            Route::get('/', ['as' => 'register', 'uses' => 'AuthController@getRegister']);

            Route::post('/', ['as' => 'register', 'uses' => 'AuthController@postRegister']);
        });

        /*
         * Client Routes
         */
        Route::group(['prefix' => 'client', 'as' => 'client.', 'namespace' => 'Client', 'middleware' => ['auth']], function () {
            Route::group(['namespace' => 'WorkRequest', 'as' => 'work-requests.'], function () {
                Route::resource('work-requests', 'Controller', [
                    'names' => [
                        'index'   => 'index',
                        'create'  => 'create',
                        'store'   => 'store',
                        'show'    => 'show',
                        'edit'    => 'edit',
                        'update'  => 'update',
                        'destroy' => 'destroy',
                    ],
                ]);

                Route::resource('work-requests.updates', 'UpdateController', [
                    'only' => [
                        'store',
                        'destroy',
                    ],
                    'names' => [
                        'store'   => 'updates.store',
                        'destroy' => 'updates.destroy',
                    ],
                ]);
            });
        });

        /*
         * Management Routes
         */
        Route::group(['prefix' => 'management', 'middleware' => ['auth']], function () {
            Route::get('/', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

            /*
             * Event Routes
             */
            Route::group(['namespace' => 'Event', 'as' => 'events.'], function () {
                Route::resource('events', 'Controller', [
                    'names' => [
                        'index'   => 'index',
                        'create'  => 'create',
                        'store'   => 'store',
                        'show'    => 'show',
                        'edit'    => 'edit',
                        'update'  => 'update',
                        'destroy' => 'destroy',
                    ],
                ]);

                Route::resource('events.report', 'ReportController', [
                    'except' => [
                        'index',
                        'show',
                    ],
                    'names' => [
                        'store'   => 'report.store',
                        'edit'    => 'report.edit',
                        'update'  => 'report.update',
                        'destroy' => 'report.destroy',
                    ],
                ]);
            });

            /*
             * Work Request Routes
             */
            Route::group(['namespace' => 'WorkRequest', 'as' => 'work-requests.'], function () {
                Route::resource('work-requests', 'WorkRequestController', [
                    'names' => [
                        'index'   => 'index',
                        'create'  => 'create',
                        'store'   => 'store',
                        'show'    => 'show',
                        'edit'    => 'edit',
                        'update'  => 'update',
                        'destroy' => 'destroy',
                    ],
                ]);

                Route::resource('work-requests.updates', 'UpdateController', [
                    'only' => [
                        'store',
                        'destroy',
                    ],
                    'names' => [
                        'store'   => 'updates.store',
                        'destroy' => 'updates.destroy',
                    ],
                ]);
            });

            /*
             * Work Order Routes
             */
            Route::group(['as' => 'work-orders.', 'namespace' => 'WorkOrder'], function () {
                Route::group(['prefix' => 'work-orders'], function () {
                    Route::get('assigned', ['as' => 'assigned.index', 'uses' => 'WorkOrderAssignedController@index']);

                    /*
                     * Work Order Priority Routes
                     */
                    Route::resource('priorities', 'PriorityController', [
                        'except' => [
                            'show',
                        ],
                        'names' => [
                            'index'   => 'priorities.index',
                            'create'  => 'priorities.create',
                            'store'   => 'priorities.store',
                            'show'    => 'priorities.show',
                            'edit'    => 'priorities.edit',
                            'update'  => 'priorities.update',
                            'destroy' => 'priorities.destroy',
                        ],
                    ]);

                    /*
                     * Work Order Status Routes
                     */
                    Route::resource('statuses', 'StatusController', [
                        'except' => [
                            'show',
                        ],
                        'names' => [
                            'index'   => 'statuses.index',
                            'create'  => 'statuses.create',
                            'store'   => 'statuses.store',
                            'show'    => 'statuses.show',
                            'edit'    => 'statuses.edit',
                            'update'  => 'statuses.update',
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
                        'except' => [
                            'show',
                        ],
                        'names' => [
                            'index'   => 'categories.index',
                            'create'  => 'categories.create',
                            'store'   => 'categories.store',
                            'edit'    => 'categories.edit',
                            'update'  => 'categories.update',
                            'destroy' => 'categories.destroy',
                        ],
                    ]);

                    Route::get('categories/create/{categories}', ['as' => 'categories.nodes.create', 'uses' => 'CategoryController@create']);

                    Route::post('categories/create/{categories?}', ['as' => 'categories.nodes.store', 'uses' => 'CategoryController@store']);

                    /*
                     * Nested Work Order Routes
                     */
                    Route::group(['prefix' => '{work_orders}'], function () {
                        /*
                         * Work Order Session Routes
                         */
                        Route::get('sessions', ['as' => 'sessions.index', 'uses' => 'WorkOrderSessionController@index']);

                        Route::post('sessions/start', ['as' => 'sessions.start', 'uses' => 'WorkOrderSessionController@start']);

                        Route::post('sessions/end', ['as' => 'sessions.end', 'uses' => 'WorkOrderSessionController@end']);

                        /*
                         * Work Order Update Routes
                         */
                        Route::resource('updates', 'UpdateController', [
                            'only' => [
                                'store',
                                'destroy',
                            ],
                            'names' => [
                                'store'   => 'updates.store',
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
                                'index'   => 'assignments.index',
                                'create'  => 'assignments.create',
                                'store'   => 'assignments.store',
                                'destroy' => 'assignments.destroy',
                            ],
                        ]);

                        /*
                         * Work Order Report Routes
                         */
                        Route::resource('report', 'ReportController', [
                            'except' => [
                                'index',
                            ],
                            'names' => [
                                'create'  => 'report.create',
                                'store'   => 'report.store',
                                'show'    => 'report.show',
                                'edit'    => 'report.edit',
                                'update'  => 'report.update',
                                'destroy' => 'report.destroy',
                            ],
                        ]);

                        /*
                         * Work Order Attachment Routes
                         */
                        Route::get('attachments/{attachments}/download', ['as' => 'attachments.download', 'uses' => 'AttachmentController@download']);

                        Route::resource('attachments', 'AttachmentController', [
                            'names' => [
                                'index'   => 'attachments.index',
                                'create'  => 'attachments.create',
                                'store'   => 'attachments.store',
                                'show'    => 'attachments.show',
                                'edit'    => 'attachments.edit',
                                'update'  => 'attachments.update',
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
                                'store'  => 'notifications.store',
                                'update' => 'notifications.update',
                            ],
                        ]);

                        /*
                         * Work Order Event Routes
                         */
                        Route::resource('events', 'EventController', [
                            'names' => [
                                'index'   => 'events.index',
                                'create'  => 'events.create',
                                'store'   => 'events.store',
                                'show'    => 'events.show',
                                'edit'    => 'events.edit',
                                'update'  => 'events.update',
                                'destroy' => 'events.destroy',
                            ],
                        ]);

                        /*
                         * Work Order Part Routes
                         */
                        Route::group(['prefix' => 'parts', 'as' => 'parts.'], function () {
                            Route::get('/', ['as' => 'index', 'uses' => 'WorkOrderPartController@index']);

                            Route::group(['prefix' => '{inventory}/stocks'], function () {
                                Route::get('/', ['as' => 'stocks.index', 'uses' => 'WorkOrderPartStockController@index']);

                                Route::get('{stocks}/take', ['as' => 'stocks.take', 'uses' => 'WorkOrderPartStockController@getTake']);

                                Route::post('{stocks}/take', ['as' => 'stocks.take', 'uses' => 'WorkOrderPartStockController@postTake']);

                                Route::get('{stocks}/put-back', ['as' => 'stocks.put', 'uses' => 'WorkOrderPartStockController@getPut']);

                                Route::post('{stocks}/put-back', ['as' => 'stocks.put', 'uses' => 'WorkOrderPartStockController@postPut']);
                            });
                        });
                    });
                });

                /*
                 * Work Order Routes
                 */
                Route::resource('work-orders', 'WorkOrderController', [
                    'names' => [
                        'index'   => 'index',
                        'create'  => 'create',
                        'store'   => 'store',
                        'show'    => 'show',
                        'edit'    => 'edit',
                        'update'  => 'update',
                        'destroy' => 'destroy',
                    ],
                ]);
            });

            /*
             * Asset Routes
             */
            Route::group(['as' => 'assets.', 'namespace' => 'Asset'], function () {
                Route::group(['prefix' => 'assets'], function () {
                    /*
                     * Asset Event Routes
                     */
                    Route::resource('events', 'EventController', [
                        'names' => [
                            'index'   => 'events.index',
                            'create'  => 'events.create',
                            'store'   => 'events.store',
                            'show'    => 'events.show',
                            'edit'    => 'events.edit',
                            'update'  => 'events.update',
                            'destroy' => 'events.destroy',
                        ],
                    ]);

                    /*
                     * Category Routes
                     */
                    Route::resource('categories', 'CategoryController', [
                        'except' => [
                            'show',
                        ],
                        'names' => [
                            'index'   => 'categories.index',
                            'create'  => 'categories.create',
                            'store'   => 'categories.store',
                            'edit'    => 'categories.edit',
                            'update'  => 'categories.update',
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
                    Route::group(['prefix' => '{assets}'], function () {
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
                                'index'   => 'manuals.index',
                                'create'  => 'manuals.create',
                                'store'   => 'manuals.store',
                                'show'    => 'manuals.show',
                                'edit'    => 'manuals.edit',
                                'update'  => 'manuals.update',
                                'destroy' => 'manuals.destroy',
                            ],
                        ]);

                        /*
                        * Asset Image Routes
                        */
                        Route::get('images/{images}/download', ['as' => 'images.download', 'uses' => 'ImageController@download']);

                        Route::resource('images', 'ImageController', [
                            'names' => [
                                'index'   => 'images.index',
                                'create'  => 'images.create',
                                'store'   => 'images.store',
                                'show'    => 'images.show',
                                'edit'    => 'images.edit',
                                'update'  => 'images.update',
                                'destroy' => 'images.destroy',
                            ],
                        ]);

                        /*
                         * Asset Meter Routes
                         */
                        Route::group(['prefix' => 'meters', 'as' => 'meters.', 'namespace' => 'Meter'], function () {
                            Route::resource('', 'Controller', [
                                'names' => [
                                    'index'   => 'index',
                                    'create'  => 'create',
                                    'store'   => 'store',
                                    'show'    => 'show',
                                    'edit'    => 'edit',
                                    'update'  => 'update',
                                    'destroy' => 'destroy',
                                ],
                            ]);

                            Route::resource('readings', 'ReadingController', [
                                'only' => [
                                    'store',
                                    'destroy',
                                ],
                                'names' => [
                                    'store'   => 'readings.store',
                                    'destroy' => 'readings.destroy',
                                ],
                            ]);
                        });
                    });
                });

                /*
                 * Asset Routes
                 */
                Route::resource('assets', 'Controller', [
                    'names' => [
                        'index'   => 'index',
                        'create'  => 'create',
                        'store'   => 'store',
                        'show'    => 'show',
                        'edit'    => 'edit',
                        'update'  => 'update',
                        'destroy' => 'destroy',
                    ],
                ]);
            });

            /*
             * Inventory Routes
             */
            Route::group(['as' => 'inventory.', 'namespace' => 'Inventory'], function () {
                Route::group(['prefix' => 'inventory'], function () {
                    /*
                     * Inventory Category Routes
                     */
                    Route::get('categories/json', ['as' => 'categories.json', 'uses' => 'CategoryController@getJson']);

                    Route::get('categories/create/{categories}', ['as' => 'categories.nodes.create', 'uses' => 'CategoryController@create']);

                    Route::post('categories/move/{categories?}', ['as' => 'categories.nodes.move', 'uses' => 'CategoryController@postMoveCategory']);

                    Route::post('categories/create/{categories?}', ['as' => 'categories.nodes.store', 'uses' => 'CategoryController@store']);

                    Route::resource('categories', 'CategoryController', [
                        'except' => [
                            'show',
                        ],
                        'names' => [
                            'index'   => 'categories.index',
                            'create'  => 'categories.create',
                            'store'   => 'categories.store',
                            'edit'    => 'categories.edit',
                            'update'  => 'categories.update',
                            'destroy' => 'categories.destroy',
                        ],
                    ]);

                    /*
                     * Nested Inventory Routes
                     */
                    Route::group(['prefix' => '{inventory}'], function () {
                        Route::patch('sku/regenerate', ['as' => 'sku.regenerate', 'uses' => 'InventorySkuController@regenerate']);

                        /*
                         * Inventory Variant Routes
                         */
                        Route::resource('variants', 'InventoryVariantController', [
                            'only' => [
                                'create',
                                'store',
                            ],
                            'names' => [
                                'create' => 'variants.create',
                                'store'  => 'variants.store',
                            ],
                        ]);

                        /*
                         * Inventory Event Routes
                         */
                        Route::resource('events', 'EventController', [
                            'names' => [
                                'index'   => 'events.index',
                                'create'  => 'events.create',
                                'store'   => 'events.store',
                                'show'    => 'events.show',
                                'edit'    => 'events.edit',
                                'update'  => 'events.update',
                                'destroy' => 'events.destroy',
                            ],
                        ]);

                        /*
                         * Inventory Note Routes
                         */
                        Route::resource('notes', 'NoteController', [
                            'except' => [
                                'index',
                            ],
                            'names' => [
                                'create'  => 'notes.create',
                                'store'   => 'notes.store',
                                'show'    => 'notes.show',
                                'edit'    => 'notes.edit',
                                'update'  => 'notes.update',
                                'destroy' => 'notes.destroy',
                            ],
                        ]);

                        /*
                         * Inventory Stock Routes
                         */
                        Route::group(['as' => 'stocks.'], function () {
                            Route::resource('stocks', 'StockController', [
                                'names' => [
                                    'index'   => 'index',
                                    'create'  => 'create',
                                    'store'   => 'store',
                                    'show'    => 'show',
                                    'edit'    => 'edit',
                                    'update'  => 'update',
                                    'destroy' => 'destroy',
                                ],
                            ]);

                            /*
                             * Nested Inventory Stock Routes
                             */
                            Route::group(['prefix' => 'stocks/{stocks}'], function () {
                                /*
                                 * Inventory Stock Movement Routes
                                 */
                                Route::resource('movements', 'StockMovementController', [
                                    'only' => [
                                        'index',
                                        'show',
                                    ],
                                    'names' => [
                                        'index' => 'movements.index',
                                        'show'  => 'movements.show',
                                    ],
                                ]);

                                Route::group(['prefix' => 'movements', 'as' => 'movements.'], function () {
                                    /*
                                     * Nested Inventory Stock Movement Routes
                                     */
                                    Route::group(['prefix' => '{movements}'], function () {
                                        Route::post('rollback', ['as' => 'rollback', 'uses' => 'StockMovementController@rollback']);
                                    });
                                });
                            });
                        });
                    });
                });

                /*
                 * Inventory Routes
                 */
                Route::resource('inventory', 'InventoryController', [
                    'names' => [
                        'index'   => 'index',
                        'create'  => 'create',
                        'store'   => 'store',
                        'show'    => 'show',
                        'edit'    => 'edit',
                        'update'  => 'update',
                        'destroy' => 'destroy',
                    ],
                ]);
            });

            /*
             * Location Routes
             */
            Route::get('locations/json', ['as' => 'locations.json', 'uses' => 'LocationController@getJson']);

            Route::post('locations/move/{categories?}', ['as' => 'locations.nodes.move', 'uses' => 'LocationController@postMoveCategory']);

            Route::post('locations/create/{categories?}', ['as' => 'locations.nodes.store', 'uses' => 'LocationController@store']);

            Route::resource('locations', 'LocationController', [
                'except' => [
                    'show',
                ],
                'names' => [
                    'index'   => 'locations.index',
                    'create'  => 'locations.create',
                    'store'   => 'locations.store',
                    'edit'    => 'locations.edit',
                    'update'  => 'locations.update',
                    'destroy' => 'locations.destroy',
                ],
            ]);

            Route::get('locations/create/{categories}', ['as' => 'locations.nodes.create', 'uses' => 'LocationController@create']);

            /*
             * Metric Routes
             */
            Route::resource('metrics', 'MetricController', [
                'names' => [
                    'index'   => 'metrics.index',
                    'create'  => 'metrics.create',
                    'store'   => 'metrics.store',
                    'show'    => 'metrics.show',
                    'edit'    => 'metrics.edit',
                    'update'  => 'metrics.update',
                    'destroy' => 'metrics.destroy',
                ],
            ]);

            /*
             * Administration Route Group
             */
            Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
                /*
                 * Administration Routes
                 */
                Route::get('/', [
                    'as'   => 'admin.dashboard.index',
                    'uses' => 'DashboardController@getIndex',
                ]);

                // Log Management Routes
                Route::post('logs/{logs}/mark-read', [
                    'as'   => 'admin.logs.mark-read',
                    'uses' => 'LogController@markRead',
                ]);

                Route::resource('logs', 'LogController', [
                    'only' => [
                        'index',
                        'show',
                        'destroy',
                    ],
                    'names' => [
                        'index'   => 'admin.logs.index',
                        'show'    => 'admin.logs.show',
                        'destroy' => 'admin.logs.destroy',
                    ],
                ]);
                // End Log Management Routes

                // User Management Routes
                Route::group(['namespace' => 'User'], function () {
                    Route::resource('users', 'UserController', [
                        'names' => [
                            'index'   => 'admin.users.index',
                            'create'  => 'admin.users.create',
                            'store'   => 'admin.users.store',
                            'show'    => 'admin.users.show',
                            'edit'    => 'admin.users.edit',
                            'update'  => 'admin.users.update',
                            'destroy' => 'admin.users.destroy',
                        ],
                    ]);

                    Route::patch('users/{users}/password', [
                        'as'   => 'admin.users.password.update',
                        'uses' => 'PasswordController@update',
                    ]);

                    Route::post('users/{users}/check-access', [
                        'as'   => 'admin.users.check-access',
                        'uses' => 'AccessController@postCheck',
                    ]);
                });
                // End User Management Routes

                // Group Management Routes
                Route::resource('roles', 'RoleController', [
                    'names' => [
                        'index'   => 'admin.roles.index',
                        'create'  => 'admin.roles.create',
                        'store'   => 'admin.roles.store',
                        'show'    => 'admin.roles.show',
                        'edit'    => 'admin.roles.edit',
                        'update'  => 'admin.roles.update',
                        'destroy' => 'admin.roles.destroy',
                    ],
                ]);

                // Archive Routes
                Route::group(['namespace' => 'Archive'], function () {
                    // Asset Archive Routes
                    Route::post('archive/assets/{assets}/restore', [
                        'as'   => 'admin.archive.assets.restore',
                        'uses' => 'AssetController@restore',
                    ]);

                    Route::resource('archive/assets', 'AssetController', [
                        'only' => [
                            'index',
                            'show',
                            'destroy',
                        ],
                        'names' => [
                            'index'   => 'admin.archive.assets.index',
                            'show'    => 'admin.archive.assets.show',
                            'destroy' => 'admin.archive.assets.destroy',
                        ],
                    ]);

                    // Work Order Archive Routes
                    Route::post('archive/work-orders/{work_orders}/restore', [
                        'as'   => 'admin.archive.work-orders.restore',
                        'uses' => 'WorkOrderController@restore',
                    ]);

                    Route::resource('archive/work-orders', 'WorkOrderController', [
                        'only' => [
                            'index',
                            'show',
                            'destroy',
                        ],
                        'names' => [
                            'index'   => 'admin.archive.work-orders.index',
                            'show'    => 'admin.archive.work-orders.show',
                            'destroy' => 'admin.archive.work-orders.destroy',
                        ],
                    ]);

                    // Inventory Archive Routes
                    Route::post('archive/inventory/{inventory}/restore', [
                        'as'   => 'admin.archive.inventory.restore',
                        'uses' => 'InventoryController@restore',
                    ]);

                    Route::resource('archive/inventory', 'InventoryController', [
                        'only' => [
                            'index',
                            'show',
                            'destroy',
                        ],
                        'names' => [
                            'index'   => 'admin.archive.inventory.index',
                            'show'    => 'admin.archive.inventory.show',
                            'destroy' => 'admin.archive.inventory.destroy',
                        ],
                    ]);
                });
                // End Archive Routes

                // Setting Routes
                Route::group(['namespace' => 'Setting'], function () {
                    Route::resource('settings/site', 'SiteController', [
                        'only' => [
                            'index',
                            'store',
                        ],
                        'names' => [
                            'index' => 'admin.settings.site.index',
                            'store' => 'admin.settings.site.store',
                        ],
                    ]);
                });
            });
        });
    });
});
