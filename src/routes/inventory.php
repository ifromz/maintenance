<?php

/*
 * Inventory Routes
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