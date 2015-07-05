<?php

use Illuminate\Support\Facades\Route;

/*
 * Asset Routes
 */
Route::group(['namespace' => 'Asset'], function () {

    /*
    * Category Routes
    */
    Route::get('assets/categories/json', [
            'as' => 'maintenance.assets.categories.json',
            'uses' => 'CategoryController@getJson',
        ]
    );

    Route::get('assets/categories/create/{categories?}', [
            'as' => 'maintenance.assets.categories.nodes.create',
            'uses' => 'CategoryController@create',
        ]
    );

    Route::post('assets/categories/move/{categories?}', [
        'as' => 'maintenance.assets.categories.nodes.move',
        'uses' => 'CategoryController@postMoveCategory',
    ]);

    Route::post('assets/categories/create/{categories?}', [
            'as' => 'maintenance.assets.categories.nodes.store',
            'uses' => 'CategoryController@store',
        ]
    );

    Route::resource('assets/categories', 'CategoryController', [
        'only' => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.assets.categories.index',
            'create' => 'maintenance.assets.categories.create',
            'store' => 'maintenance.assets.categories.store',
            'edit' => 'maintenance.assets.categories.edit',
            'update' => 'maintenance.assets.categories.update',
            'destroy' => 'maintenance.assets.categories.destroy',
        ],
    ]);
    /*
     * End Category Routes
     */

    /*
     * Asset Image Routes
     */
    Route::get('assets/{assets}/images/{images}/download', [
        'as' => 'maintenance.assets.images.download',
        'uses' => 'ImageController@download',
    ]);

    Route::resource('assets.images', 'ImageController', [
        'only' => [
            'index',
            'create',
            'store',
            'show',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.assets.images.index',
            'create' => 'maintenance.assets.images.create',
            'store' => 'maintenance.assets.images.store',
            'show' => 'maintenance.assets.images.show',
            'destroy' => 'maintenance.assets.images.destroy',
        ],
    ]);
    /*
     * End Upload Routes
     */

    /*
     * Asset Meter Routes
     */
    Route::group(['namespace' => 'Meter'], function () {

        Route::resource('assets.meters', 'MeterController', [
            'names' => [
                'store' => 'maintenance.assets.meters.store',
                'show' => 'maintenance.assets.meters.show',
                'edit' => 'maintenance.assets.meters.edit',
                'update' => 'maintenance.assets.meters.update',
                'destroy' => 'maintenance.assets.meters.destroy',
            ],
            'only' => [
                'store',
                'show',
                'edit',
                'update',
                'destroy',
            ],
        ]);

        Route::resource('assets.meters.readings', 'ReadingController', [
            'only' => [
                'store',
                'destroy',
            ],
            'names' => [
                'store' => 'maintenance.assets.meters.readings.store',
                'destroy' => 'maintenance.assets.meters.readings.destroy',
            ],
        ]);

    });
    /*
     * End Asset Meter Routes
     */

    /*
     * Asset Manual Upload Routes
     */
    Route::resource('assets.manuals', 'ManualController', [
        'only' => [
            'index',
            'create',
            'store',
            'destroy',
        ],
        'names' => [
            'index' => 'maintenance.assets.manuals.index',
            'create' => 'maintenance.assets.manuals.create',
            'store' => 'maintenance.assets.manuals.store',
            'destroy' => 'maintenance.assets.manuals.destroy',
        ],
    ]);
    /*
     * End Asset Manual Upload Routes
     */

    /*
     * Asset Event Routes
     */
    Route::resource('assets.events', 'EventController', [
        'names' => [
            'index' => 'maintenance.assets.events.index',
            'create' => 'maintenance.assets.events.create',
            'store' => 'maintenance.assets.events.store',
            'show' => 'maintenance.assets.events.show',
            'edit' => 'maintenance.assets.events.edit',
            'update' => 'maintenance.assets.events.update',
            'destroy' => 'maintenance.assets.events.destroy',
        ],
    ]);

    Route::get('assets/{assets}/work-orders', [
        'as' => 'maintenance.assets.work-orders.index',
        'uses' => 'WorkOrderController@index'
    ]);

    /*
     * Asset Routes
     */
    Route::resource('assets', 'Controller', [
        'names' => [
            'index' => 'maintenance.assets.index',
            'create' => 'maintenance.assets.create',
            'store' => 'maintenance.assets.store',
            'show' => 'maintenance.assets.show',
            'edit' => 'maintenance.assets.edit',
            'update' => 'maintenance.assets.update',
            'destroy' => 'maintenance.assets.destroy',
        ],
    ]);

});
