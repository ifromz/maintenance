<?php

// Api Routes
Route::group(['prefix' => Config::get('maintenance.site.api-prefix'), 'namespace' => 'Stevebauman\Maintenance\Http\Apis', 'before' => 'maintenance.auth'], function ()
{
    // Api v1 Routes
    Route::group(['namespace' => 'v1', 'prefix' => 'v1'], function()
    {
        // Event Api Routes
        Route::group(['prefix' => 'events'], function()
        {
            Route::get('between', ['as' => 'maintenance.api.v1.events.between', 'uses' => 'EventController@between']);

            Route::get('grid', ['as' => 'maintenance.api.v1.events.grid', 'uses' => 'EventController@grid']);

            Route::patch('move/{events}', ['as' => 'maintenance.api.v1.events.move', 'uses' => 'EventController@move']);
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

            // Work Order Part Api Routes
            Route::group(['prefix' => '{work_orders}/parts', 'namespace' => 'Part'], function()
            {
                Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.parts.grid', 'uses' => 'Controller@grid']);

                // Work Order Part Inventory Routes
                Route::group(['prefix' => 'inventory'], function()
                {
                    Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.parts.inventory.grid', 'uses' => 'InventoryController@grid']);

                    Route::get('{inventory}/variants/grid', ['as' => 'maintenance.api.v1.work-orders.parts.inventory.variants.grid', 'uses' => 'InventoryController@gridVariants']);

                    Route::get('{inventory}/stocks/grid', ['as' => 'maintenance.api.v1.work-orders.parts.inventory.stocks.grid', 'uses' => 'InventoryController@gridStocks']);
                });
            });

            // Work Order Session Api Routes
            Route::group(['prefix' => '{work_orders}/sessions'], function()
            {
                Route::get('grid', ['as' => 'maintenance.api.v1.work-orders.sessions.grid', 'uses' => 'SessionController@grid']);
            });
        });

        // Work Request Api Routes
        Route::group(['namespace' => 'WorkRequest', 'prefix' => 'work-requests'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.work-requests.grid', 'uses' => 'Controller@grid']);
        });

        // Inventory Api Routes
        Route::group(['namespace' => 'Inventory', 'prefix' => 'inventory'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.inventory.grid', 'uses' => 'Controller@grid']);

            Route::get('{inventory}/stocks/{stocks}/edit', [
                'as' => 'maintenance.api.v1.inventory.stocks.edit',
                'uses' => 'StockController@edit',
            ]);

            Route::patch('{inventory}/stocks/{stocks}', [
                'as' => 'maintenance.api.v1.inventory.stocks.update',
                'uses' => 'StockController@update',
            ]);

            // Inventory Category Api Routes
            Route::group(['prefix' => 'categories'], function()
            {
                Route::get('grid', ['as' => 'maintenance.api.v1.inventory.categories.grid', 'uses' => 'CategoryController@grid']);

                Route::post('move/{categories?}', ['as' => 'maintenance.api.v1.inventory.categories.move', 'uses' => 'CategoryController@move']);
            });
        });

        // Asset Api Routes
        Route::group(['namespace' => 'Asset', 'prefix' => 'assets'], function()
        {
            Route::get('grid', ['as' => 'maintenance.api.v1.assets.grid', 'uses' => 'Controller@grid']);

            Route::get('assets/{assets}/work-orders/grid', ['as' => 'maintenance.api.v1.assets.work-orders.grid', 'uses' => 'WorkOrderController@grid']);

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

        // Administrator Api Routes
        Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
        {
            // Administrator User Api Routes
            Route::group(['prefix' => 'users'], function()
            {
                Route::get('grid', ['as' => 'maintenance.api.v1.admin.users.grid', 'uses' => 'UserController@grid']);
            });

            // Administrator Group Api Routes
            Route::group(['prefix' => 'groups'], function()
            {
                Route::get('grid', ['as' => 'maintenance.api.v1.admin.groups.grid', 'uses' => 'GroupController@grid']);
            });

            // Administrator Archive Api Routes
            Route::group(['prefix' => 'archive', 'namespace' => 'Archive'], function()
            {
                Route::get('grid/work-orders', ['as' => 'maintenance.api.v1.admin.archive.work-orders.grid', 'uses' => 'WorkOrderController@grid']);

                Route::get('grid/inventory', ['as' => 'maintenance.api.v1.admin.archive.inventory.grid', 'uses' => 'InventoryController@grid']);
            });
        });
    });

});
