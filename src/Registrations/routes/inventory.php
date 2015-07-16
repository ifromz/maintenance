<?php


/*
 * Inventory Routes
 */
Route::group(['prefix' => 'inventory', 'as' => 'inventory.', 'namespace' => 'Inventory'], function ()
{
    Route::resource('', 'Controller', [
        'names' => [
            'index' => 'index',
            'create' => 'create',
            'store' => 'store',
            'show' => '.show',
            'edit' => 'edit',
            'update' => 'update',
            'destroy' => 'destroy',
        ],
    ]);

    /*
     * Inventory Category Routes
     */
    Route::get('categories/json', ['as' => 'categories.json', 'uses' => 'CategoryController@getJson']);

    Route::get('categories/create/{categories}', ['as' => 'categories.nodes.create', 'uses' => 'CategoryController@create']);

    Route::post('categories/move/{categories?}', ['as' => 'categories.nodes.move', 'uses' => 'CategoryController@postMoveCategory']);

    Route::post('categories/create/{categories?}', ['as' => 'categories.nodes.store', 'uses' => 'CategoryController@store']);

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
            'index' => 'maintenance.inventory.categories.index',
            'create' => 'maintenance.inventory.categories.create',
            'store' => 'maintenance.inventory.categories.store',
            'edit' => 'maintenance.inventory.categories.edit',
            'update' => 'maintenance.inventory.categories.update',
            'destroy' => 'maintenance.inventory.categories.destroy',
        ],
    ]);

    /*
     * Nested Inventory Routes
     */
    Route::group(['prefix' => '{inventory}'], function ()
    {
        Route::patch('sku/regenerate', ['as' => 'maintenance.inventory.sku.regenerate', 'uses' => 'SkuController@regenerate']);

        /*
         * Inventory Variant Routes
         */
        Route::resource('variants', 'VariantController', [
            'only' => [
                'create',
                'store',
            ],
            'names' => [
                'create' => 'variants.create',
                'store' => 'variants.store',
            ],
        ]);

        /*
         * Inventory Event Routes
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
         * Inventory Note Routes
         */
        Route::resource('notes', 'NoteController', [
            'names' => [
                'create' => 'notes.create',
                'store' => 'notes.store',
                'show' => 'notes.show',
                'edit' => 'notes.edit',
                'update' => 'notes.update',
                'destroy' => 'notes.destroy',
            ],
            'only' => [
                'create',
                'store',
                'show',
                'edit',
                'update',
                'destroy'
            ],
        ]);

        /*
         * Inventory Stock Routes
         */
        Route::group(['prefix' => 'stocks', 'as' => 'stocks.'], function ()
        {
            Route::resource('', 'StockController', [
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
             * Nested Inventory Stock Routes
             */
            Route::group(['prefix' => '{stocks}'], function ()
            {
                /*
                 * Inventory Stock Movement Routes
                 */
                Route::group(['prefix' => 'movements', 'as' => 'movements.'], function()
                {
                    Route::resource('', 'StockMovementController', [
                        'only' => [
                            'index',
                            'show',
                        ],
                        'names' => [
                            'index' => 'index',
                            'show' => 'show',
                        ],
                    ]);

                    /*
                     * Nested Inventory Stock Movement Routes
                     */
                    Route::group(['prefix' => '{movements}'], function ()
                    {
                        Route::post('{movements}/rollback', ['as' => 'rollback', 'uses' => 'StockMovementController@rollback']);
                    });
                });
            });
        });
    });
});
