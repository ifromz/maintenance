<?php

/*
 * Asset Routes
 */
Route::group(array('namespace' => 'Asset'), function () {

    /*
    * Category Routes
    */
    Route::get('assets/categories/json', array(
            'as' => 'maintenance.assets.categories.json',
            'uses' => 'CategoryController@getJson',
        )
    );

    Route::get('assets/categories/create/{categories?}', array(
            'as' => 'maintenance.assets.categories.nodes.create',
            'uses' => 'CategoryController@create',
        )
    );

    Route::post('assets/categories/move/{categories?}', array(
        'as' => 'maintenance.assets.categories.nodes.move',
        'uses' => 'CategoryController@postMoveCategory'
    ));

    Route::post('assets/categories/create/{categories?}', array(
            'as' => 'maintenance.assets.categories.nodes.store',
            'uses' => 'CategoryController@store',
        )
    );

    Route::resource('assets/categories', 'CategoryController', array(
        'names' => array(
            'index' => 'maintenance.assets.categories.index',
            'create' => 'maintenance.assets.categories.create',
            'store' => 'maintenance.assets.categories.store',
            'show' => 'maintenance.assets.categories.show',
            'edit' => 'maintenance.assets.categories.edit',
            'update' => 'maintenance.assets.categories.update',
            'destroy' => 'maintenance.assets.categories.destroy',
        ),
    ));
    /*
     * End Category Routes
     */

    /*
     * Asset Image Routes
     */
    Route::group(array('namespace' => 'Image'), function () {

        Route::post('assets/images/uploads', array(
            'as' => 'maintenance.assets.images.uploads.store',
            'uses' => 'UploadController@store'
        ));

        Route::post('assets/images/uploads/destroy', array(
            'as' => 'maintenance.assets.images.uploads.destroy',
            'uses' => 'UploadController@destroy'
        ));

        Route::resource('assets.images', 'ImageController', array(
            'only' => array(
                'index',
                'create',
                'store',
                'show',
                'destroy'
            ),
            'names' => array(
                'index' => 'maintenance.assets.images.index',
                'create' => 'maintenance.assets.images.create',
                'store' => 'maintenance.assets.images.store',
                'show' => 'maintenance.assets.images.show',
                'destroy' => 'maintenance.assets.images.destroy',
            ),
        ));

    });
    /*
     * End Upload Routes
     */

    /*
     * Asset Meter Routes
     */
    Route::group(array('namespace' => 'Meter'), function () {

        Route::resource('assets.meters', 'MeterController', array(
            'names' => array(
                'index' => 'maintenance.assets.meters.index',
                'store' => 'maintenance.assets.meters.store',
                'show' => 'maintenance.assets.meters.show',
                'edit' => 'maintenance.assets.meters.edit',
                'update' => 'maintenance.assets.meters.update',
                'destroy' => 'maintenance.assets.meters.destroy',
            )
        ));

        Route::resource('assets.meters.readings', 'MeterReadingController', array(
            'only' => array(
                'store',
                'destroy',
            ),
            'names' => array(
                'store' => 'maintenance.assets.meters.readings.store',
                'destroy' => 'maintenance.assets.meters.readings.destroy'
            )
        ));

    });
    /*
     * End Asset Meter Routes
     */

    /*
     * Asset Manual Upload Routes
     */
    Route::group(array('namespace' => 'Manual'), function () {

        Route::group(array('prefix' => 'assets/manuals/uploads'), function () {

            Route::post('', array(
                'as' => 'maintenance.assets.manuals.uploads.store',
                'uses' => 'UploadController@store'
            ));

            Route::post('destroy', array(
                'as' => 'maintenance.assets.manuals.uploads.destroy',
                'uses' => 'UploadController@destroy'
            ));

        });

        Route::resource('assets.manuals', 'ManualController', array(
            'only' => array(
                'index',
                'create',
                'store',
                'destroy'
            ),
            'names' => array(
                'index' => 'maintenance.assets.manuals.index',
                'create' => 'maintenance.assets.manuals.create',
                'store' => 'maintenance.assets.manuals.store',
                'destroy' => 'maintenance.assets.manuals.destroy',
            ),
        ));

    });
    /*
     * End Asset Manual Upload Routes
     */

    /*
     * Asset Event Routes
     */
    Route::resource('assets.events', 'EventController', array(
        'names' => array(
            'index' => 'maintenance.assets.events.index',
            'create' => 'maintenance.assets.events.create',
            'store' => 'maintenance.assets.events.store',
            'show' => 'maintenance.assets.events.show',
            'edit' => 'maintenance.assets.events.edit',
            'update' => 'maintenance.assets.events.update',
            'destroy' => 'maintenance.assets.events.destroy',
        )
    ));

    /*
     * Asset Routes
     */
    Route::resource('assets', 'AssetController', array(
        'names' => array(
            'index' => 'maintenance.assets.index',
            'create' => 'maintenance.assets.create',
            'store' => 'maintenance.assets.store',
            'show' => 'maintenance.assets.show',
            'edit' => 'maintenance.assets.edit',
            'update' => 'maintenance.assets.update',
            'destroy' => 'maintenance.assets.destroy',
        ),
    ));

});

