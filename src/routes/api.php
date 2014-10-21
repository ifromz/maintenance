<?php

/*
 * API Routes
 */

Route::group(array('prefix'=>'v1', 'namespace'=>'v1'), function(){
                
    Route::group(array('prefix'=>'assets'), function(){

        Route::get('', array(
            'as'=>'maintenance.api.v1.assets.get',
            'uses'=>'AssetApi@get'
        ));

        Route::get('find/{assets}', array(
            'as'=>'maintenance.api.v1.assets.find',
            'uses'=>'AssetApi@find'
        ));

    });

});

Route::group(array('prefix'=>'notifications'), function(){

    Route::resource('notifications', 'NotificationApi', array(
        'only' => array('update'),
        'names' => array(
            'update' => 'maintenance.api.notifications.update'
        ),
    ));

});

    /*
    |--------------------------------------------------------------------------
    | Maintenance Work Order Api Routes
    |--------------------------------------------------------------------------
    */
    Route::group(array('prefix'=>'work-orders'), function(){
            Route::get('', array('as'=>'maintenance.api.work-orders.get', 'uses'=>'AssetApi@get'));

            Route::get('{work_orders}', array('as'=>'maintenance.api.work-orders.find', 'uses'=>'AssetApi@find'));
    });

    /*
    |--------------------------------------------------------------------------
    | Maintenance Asset Api Routes
    |--------------------------------------------------------------------------
    */
    Route::group(array('prefix'=>'assets'), function(){
            Route::get('', array('as'=>'maintenance.api.assets.get', 'uses'=>'AssetApi@get'));
            Route::get('q', array('as'=>'maintenance.api.assets.query', 'uses'=>'AssetApi@getByQuery'));
            Route::get('makes', array('as'=>'maintenance.api.assets.makes', 'uses'=>'AssetApi@getMakes'));
            Route::get('models', array('as'=>'maintenance.api.assets.models', 'uses'=>'AssetApi@getModels'));
            Route::get('serials', array('as'=>'maintenance.api.assets.serials', 'uses'=>'AssetApi@getSerials'));
    });

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

    /*
    |--------------------------------------------------------------------------
    | Maintenance Calendar Api Routes
    |--------------------------------------------------------------------------
    */
    Route::group(array('prefix'=>'calendar'), function(){

        Route::resource('events', 'EventApi', array(
            'names'=> array(
                    'index'		=> 'maintenance.api.calendar.events.index',
                    'create'  	=> 'maintenance.api.calendar.events.create',
                    'store'   	=> 'maintenance.api.calendar.events.store',
                    'show'    	=> 'maintenance.api.calendar.events.show',
                    'edit'    	=> 'maintenance.api.calendar.events.edit',
                    'update'  	=> 'maintenance.api.calendar.events.update',
                    'destroy' 	=> 'maintenance.api.calendar.events.destroy',
            ),
        ));

        Route::resource('events/assets', 'AssetEventApi', array(
            'only' => array(
                'index',
                'show',
            ),
            'names'=> array(
                    'index' => 'maintenance.api.calendar.events.assets.index',
                    'show' => 'maintenance.api.calendar.events.assets.show',
            ),
        ));

    });