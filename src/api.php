<?php

// Api Routes
Route::group(['prefix' => Config::get('maintenance.site.api-prefix'), 'namespace' => 'Stevebauman\Maintenance\Http\Apis'], function ()
{
    // Api v1 Routes
    Route::group(['namespace' => 'v1', 'prefix' => 'v1'], function()
    {
        // Event Api Routes
        Route::group(['prefix' => 'events'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.events.grid', 'uses' => 'EventController@grid']);
        });

        // Work Order Api Routes
        Route::group(['namespace' => 'WorkOrder', 'prefix' => 'work-orders'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.grid', 'uses' => 'Controller@grid']);

            Route::get('assigned/grid', ['as' => 'maintenance.api.v1.work-orders.assigned.grid', 'uses' => 'AssignedController@grid']);

            // Work Order Status Api Routes
            Route::group(['prefix' => 'statuses'], function() {
                Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.statuses.grid', 'uses' => 'StatusController@grid']);
            });

            // Work Order Priority Api Routes
            Route::group(['prefix' => 'priorities'], function() {
                Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.priorities.grid', 'uses' => 'PriorityController@grid']);
            });

            // Work Order Category Api Routes
            Route::group(['prefix' => 'categories'], function()
            {
                Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.categories.grid', 'uses' => 'CategoryController@grid']);

                Route::post('move/{categories?}', ['as' => 'maintenance.api.v1.work-orders.categories.move', 'uses' => 'CategoryController@move']);
            });
        });

        // Work Request Api Routes
        Route::group(['namespace' => 'WorkRequest', 'prefix' => 'work-requests'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.work-requests.grid', 'uses' => 'Controller@grid']);
        });

        // Asset Api Routes
        Route::group(['namespace' => 'Asset', 'prefix' => 'assets'], function()
        {
            // Asset Category Api Routes
            Route::group(['prefix' => 'categories'], function()
            {
                Route::get('grid', ['as' => 'maintenance.api.v1.assets.categories.grid', 'uses' => 'CategoryController@grid']);

                Route::post('move/{categories?}', ['as' => 'maintenance.api.v1.assets.categories.move', 'uses' => 'CategoryController@move']);
            });
        });

        // Location Api Routes
        Route::group(['prefix' => 'locations'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.locations.grid', 'uses' => 'LocationController@grid']);

            Route::post('move/{categories?}', ['as' => 'maintenance.api.v1.locations.move', 'uses' => 'LocationController@move']);
        });

        // Metric Api Routes
        Route::group(['prefix' => 'metrics'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.metrics.grid', 'uses' => 'MetricController@grid']);
        });
    });

});
