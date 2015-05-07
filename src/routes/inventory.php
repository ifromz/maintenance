<?php

/*
 * Inventory Routes
 */

Route::group(['namespace' => 'Inventory'], function () {

    /*
     * Category Routes
     */
    Route::get('inventory/categories/json', [
            'as' => 'maintenance.inventory.categories.json',
            'uses' => 'CategoryController@getJson',
        ]
    );

    Route::get('inventory/categories/create/{categories?}', [
            'as' => 'maintenance.inventory.categories.nodes.create',
            'uses' => 'CategoryController@create',
        ]
    );

    Route::post('inventory/categories/move/{categories?}', [
        'as' => 'maintenance.inventory.categories.nodes.move',
        'uses' => 'CategoryController@postMoveCategory',
    ]);

    Route::post('inventory/categories/create/{categories?}', [
            'as' => 'maintenance.inventory.categories.nodes.store',
            'uses' => 'CategoryController@store',
        ]
    );

    Route::resource('inventory/categories', 'CategoryController', [
        'names' => [
            'index' => 'maintenance.inventory.categories.index',
            'create' => 'maintenance.inventory.categories.create',
            'store' => 'maintenance.inventory.categories.store',
            'show' => 'maintenance.inventory.categories.show',
            'edit' => 'maintenance.inventory.categories.edit',
            'update' => 'maintenance.inventory.categories.update',
            'destroy' => 'maintenance.inventory.categories.destroy',
        ],
    ]);
    /*
     * End Category Routes
     */

    /*
     * Start Inventory SKU routes
     */
    Route::patch('inventory/{inventories}/sku/regenerate', [
        'as' => 'maintenance.inventory.sku.regenerate',
        'uses' => 'SkuController@regenerate',
    ]);
    /*
     * End Inventory SKU routes
     */

    /*
     * Start Inventory Routes
     */
    Route::resource('inventory', 'InventoryController', [
        'names' => [
            'index' => 'maintenance.inventory.index',
            'create' => 'maintenance.inventory.create',
            'store' => 'maintenance.inventory.store',
            'show' => 'maintenance.inventory.show',
            'edit' => 'maintenance.inventory.edit',
            'update' => 'maintenance.inventory.update',
            'destroy' => 'maintenance.inventory.destroy',
        ],
    ]);

    Route::resource('inventory.stocks', 'StockController', [
        'names' => [
            'index' => 'maintenance.inventory.stocks.index',
            'create' => 'maintenance.inventory.stocks.create',
            'store' => 'maintenance.inventory.stocks.store',
            'show' => 'maintenance.inventory.stocks.show',
            'edit' => 'maintenance.inventory.stocks.edit',
            'update' => 'maintenance.inventory.stocks.update',
            'destroy' => 'maintenance.inventory.stocks.destroy',
        ],
    ]);

    Route::resource('inventory.notes', 'NoteController', [
        'names' => [
            'create' => 'maintenance.inventory.notes.create',
            'store' => 'maintenance.inventory.notes.store',
            'edit' => 'maintenance.inventory.notes.edit',
            'update' => 'maintenance.inventory.notes.update',
            'destroy' => 'maintenance.inventory.notes.destroy',
        ],
        'only' => [
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
    ]);

    Route::post('inventory/{inventory}/stocks/{stocks}/movements/{movements}/rollback', [
        'as' => 'maintenance.inventory.stocks.movements.rollback',
        'uses' => 'StockMovementController@rollback',
    ]);

    Route::resource('inventory.stocks.movements', 'StockMovementController', [
        'only' => [
            'index',
            'show',
        ],
        'names' => [
            'index' => 'maintenance.inventory.stocks.movements.index',
            'show' => 'maintenance.inventory.stocks.movements.show',
        ],
    ]);

    Route::resource('inventory.events', 'EventController', [
        'names' => [
            'index' => 'maintenance.inventory.events.index',
            'create' => 'maintenance.inventory.events.create',
            'store' => 'maintenance.inventory.events.store',
            'show' => 'maintenance.inventory.events.show',
            'edit' => 'maintenance.inventory.events.edit',
            'update' => 'maintenance.inventory.events.update',
            'destroy' => 'maintenance.inventory.events.destroy',
        ],
    ]);
    /*
     * End Inventory Routes
     */

});
