<?php

// Api Routes
Route::group(['prefix' => Config::get('maintenance.site.api-prefix'), 'namespace' => 'Stevebauman\Maintenance\Http\Apis'], function ()
{
    // Api v1 Routes
    Route::group(['namespace' => 'v1', 'prefix' => 'v1'], function()
    {
        // Work Order Api Routes
        Route::group(['namespace' => 'WorkOrder', 'prefix' => 'work-orders'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.grid', 'uses' => 'Controller@grid']);

            // Work Order Category Api Routes
            Route::group(['prefix' => 'categories'], function()
            {
                Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.categories.grid', 'uses' => 'CategoryController@grid']);

                Route::post('move/{id?}', ['as' => 'maintenance.api.v1.work-orders.categories.move', 'uses' => 'CategoryController@move']);
            });
        });

        // Work Request Api Routes
        Route::group(['namespace' => 'WorkRequest', 'prefix' => 'work-requests'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.work-requests.grid', 'uses' => 'Controller@grid']);
        });
    });

});
