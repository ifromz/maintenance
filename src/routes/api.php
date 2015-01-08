<?php

/*
 * API Routes
 */
Route::group(array('prefix'=>'v1', 'namespace'=>'v1'), function(){

    /*
     * Generic Events API
     */
    Route::group(array('prefix'=>'calendar'), function(){

        Route::resource('events', 'EventApi', array(
            'names'=> array(
                'index'	=> 'maintenance.api.calendar.events.index',
                'create'  	=> 'maintenance.api.calendar.events.create',
                'store'   	=> 'maintenance.api.calendar.events.store',
                'show'    	=> 'maintenance.api.calendar.events.show',
                'edit'    	=> 'maintenance.api.calendar.events.edit',
                'update'  	=> 'maintenance.api.calendar.events.update',
                'destroy' 	=> 'maintenance.api.calendar.events.destroy',
            ),
        ));

    });

    /*
     * Inventory API's
     */
    Route::group(array('prefix'=>'inventory'), function(){

        Route::resource('inventory.stocks', 'InventoryStockApi', array(
            'only' => array(
                'edit',
                'update'
            ),
            'names' => array(
                'edit'    	=> 'maintenance.api.inventory.stocks.edit',
                'update'  	=> 'maintenance.api.inventory.stocks.update',
            ),
        ));

    });

    /*
     * Asset API's
     */
    Route::group(array('prefix'=>'assets'), function(){

        Route::get('', array(
            'as'=>'maintenance.api.v1.assets.get',
            'uses'=>'AssetApi@get'
        ));

        Route::get('find/{assets}', array(
            'as'=>'maintenance.api.v1.assets.find',
            'uses'=>'AssetApi@find'
        ));

        /*
         * Asset Event API
         */
        Route::resource('events', 'AssetEventApi', array(
            'only' => array(
                'index',
                'show',
            ),
            'names'=> array(
                    'index' => 'maintenance.api.v1.assets.events.index',
                    'show' => 'maintenance.api.v1.assets.events.show',
            ),
        ));

    });

});