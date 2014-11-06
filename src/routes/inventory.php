<?php

/*
 * Inventory Routes
 */

/*
 * Category Routes
 */
Route::get('inventory/categories/json', array(
                'as' => 'maintenance.inventory.categories.json',
                'uses' => 'InventoryCategoryController@getJson',
        )
);

Route::get('inventory/categories/create/{categories?}', array(
                'as' => 'maintenance.inventory.categories.nodes.create',
                'uses' => 'InventoryCategoryController@create',
        )
);

Route::post('inventory/categories/move/{categories?}', array(
        'as' => 'maintenance.inventory.categories.nodes.move',
        'uses'=> 'InventoryCategoryController@postMoveCategory'
));

Route::post('inventory/categories/create/{categories?}', array(
                'as' => 'maintenance.inventory.categories.nodes.store',
                'uses' => 'InventoryCategoryController@store',
        )
);

Route::resource('inventory/categories', 'InventoryCategoryController', array(
        'names'=> array(
                'index'		=> 'maintenance.inventory.categories.index',
                'create'  	=> 'maintenance.inventory.categories.create',
                'store'   	=> 'maintenance.inventory.categories.store',
                'show'    	=> 'maintenance.inventory.categories.show',
                'edit'    	=> 'maintenance.inventory.categories.edit',
                'update'  	=> 'maintenance.inventory.categories.update',
                'destroy' 	=> 'maintenance.inventory.categories.destroy',
        ),
));
/*
 * End Category Routes
 */

Route::resource('inventory', 'InventoryController', array(
        'names'=> array(
                'index'		=> 'maintenance.inventory.index',
                'create'  	=> 'maintenance.inventory.create',
                'store'   	=> 'maintenance.inventory.store',
                'show'    	=> 'maintenance.inventory.show',
                'edit'    	=> 'maintenance.inventory.edit',
                'update'  	=> 'maintenance.inventory.update',
                'destroy' 	=> 'maintenance.inventory.destroy',
        ),
));

Route::resource('inventory.stocks', 'InventoryStockController', array(
        'names'=> array(
                'index'		=> 'maintenance.inventory.stocks.index',
                'create'  	=> 'maintenance.inventory.stocks.create',
                'store'   	=> 'maintenance.inventory.stocks.store',
                'show'    	=> 'maintenance.inventory.stocks.show',
                'edit'    	=> 'maintenance.inventory.stocks.edit',
                'update'  	=> 'maintenance.inventory.stocks.update',
                'destroy' 	=> 'maintenance.inventory.stocks.destroy',
        ),
));


Route::resource('inventory.stocks.movements', 'InventoryStockMovementController', array(
        'only' => array(
            'index'
        ),
        'names'=> array(
                'index'		=> 'maintenance.inventory.stocks.movements.index',
        ),
));