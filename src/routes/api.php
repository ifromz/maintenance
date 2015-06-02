<?php

use Illuminate\Support\Facades\Route;

/*
 * API Routes
 */
Route::group(['prefix' => 'v1', 'namespace' => 'v1'], function () {
    /*
     * Generic Events API
     */
    Route::group(['prefix' => 'calendar'], function () {

        Route::resource('events', 'EventApi', [
            'names' => [
                'index' => 'maintenance.api.calendar.events.index',
                'create' => 'maintenance.api.calendar.events.create',
                'store' => 'maintenance.api.calendar.events.store',
                'show' => 'maintenance.api.calendar.events.show',
                'edit' => 'maintenance.api.calendar.events.edit',
                'update' => 'maintenance.api.calendar.events.update',
                'destroy' => 'maintenance.api.calendar.events.destroy',
            ],
        ]);

    });

    /*
     * Work Order API's
     */
    Route::group(['prefix' => 'work-orders', 'namespace' => 'WorkOrder'], function () {

        Route::resource('events', 'EventApi', [
            'only' => [
                'index',
                'show',
            ],
            'names' => [
                'index' => 'maintenance.api.v1.work-orders.events.index',
                'show' => 'maintenance.api.v1.work-orders.events.show',
            ],
        ]);

    });

    /*
     * Inventory API's
     */
    Route::group(['prefix' => 'inventory', 'namespace' => 'Inventory'], function () {

        /*
         * Inventory Event API
         */
        Route::resource('events', 'EventApi', [
            'only' => [
                'index',
                'show',
            ],
            'names' => [
                'index' => 'maintenance.api.v1.inventory.events.index',
                'show' => 'maintenance.api.v1.inventory.events.show',
            ],
        ]);

    });

    /*
     * Asset API's
     */
    Route::group(['prefix' => 'assets', 'namespace' => 'Asset'], function () {

        /*
         * Asset Event API
         */
        Route::resource('events', 'EventApi', [
            'only' => [
                'index',
                'show',
            ],
            'names' => [
                'index' => 'maintenance.api.v1.assets.events.index',
                'show' => 'maintenance.api.v1.assets.events.show',
            ],
        ]);

    });

});
