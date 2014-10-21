<?php

/*
 * Category Routes
 */

Route::get('categories/json', array(
                'as' => 'maintenance.categories.json',
                'uses' => 'CategoryController@getJson',
        )
);

Route::get('categories/create/{categories?}', array(
                'as' => 'maintenance.categories.nodes.create',
                'uses' => 'CategoryController@create',
        )
);

Route::post('categories/move/{categories?}', array(
        'as' => 'maintenance.categories.nodes.move',
        'uses'=> 'CategoryController@postMoveCategory'
));

Route::post('categories/create/{categories?}', array(
                'as' => 'maintenance.categories.nodes.store',
                'uses' => 'CategoryController@store',
        )
);

Route::resource('categories', 'CategoryController', array(
        'names'=> array(
                'index'		=> 'maintenance.categories.index',
                'create'  	=> 'maintenance.categories.create',
                'store'   	=> 'maintenance.categories.store',
                'show'    	=> 'maintenance.categories.show',
                'edit'    	=> 'maintenance.categories.edit',
                'update'  	=> 'maintenance.categories.update',
                'destroy' 	=> 'maintenance.categories.destroy',
        ),
));