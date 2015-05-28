<?php

Route::group(['prefix' => Config::get('maintenance::site.api-prefix'), 'namespace' => 'Stevebauman\Maintenance\Http\Apis'], function ()
{
    Route::group(['namespace' => 'v1'], function()
    {
        Route::group(['namespace' => 'WorkOrder'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.grid', 'uses' => 'Controller@grid']);
        });

        Route::group(['namespace' => 'WorkRequest'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.work-requests.grid', 'uses' => 'Controller@grid']);
        });
    });

});
