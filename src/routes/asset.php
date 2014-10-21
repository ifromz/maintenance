<?php

/*
 * Asset Routes
 */

Route::post('assets/images/uploads', array(
        'as' => 'maintenance.assets.images.uploads.store',
        'uses' => 'AssetImageUploadController@store'
));

Route::post('assets/images/uploads/destroy', array(
        'as' => 'maintenance.assets.images.uploads.destroy',
        'uses' => 'AssetImageUploadController@destroy'
));

Route::resource('assets.images', 'AssetImageController', array(
        'only' => array(
            'index',	
            'create', 
            'store',
            'show', 
            'destroy'
        ),
        'names'=> array(
                'index'		=> 'maintenance.assets.images.index',
                'create'  	=> 'maintenance.assets.images.create',
                'store'   	=> 'maintenance.assets.images.store',
                'show'    	=> 'maintenance.assets.images.show',
                'destroy' 	=> 'maintenance.assets.images.destroy',
        ),
));


Route::post('assets/manuals/uploads', array(
        'as' => 'maintenance.assets.manuals.uploads.store',
        'uses' => 'AssetManualUploadController@store'
));

Route::post('assets/manuals/uploads/destroy', array(
        'as' => 'maintenance.assets.manuals.uploads.destroy',
        'uses' => 'AssetManualUploadController@destroy'
));

Route::resource('assets.manuals', 'AssetManualController', array(
        'only' => array(
            'index',
            'create',
            'store',
            'destroy'
        ),
        'names'=> array(
                'index'		=> 'maintenance.assets.manuals.index',
                'create'  	=> 'maintenance.assets.manuals.create',
                'store'   	=> 'maintenance.assets.manuals.store',
                'destroy' 	=> 'maintenance.assets.manuals.destroy',
        ),
));
/*
 * End Asset Manual Upload Routes
 */

Route::resource('assets.events', 'AssetEventController', array(
    'names' => array(
                'index'		=> 'maintenance.assets.events.index',
                'create'  	=> 'maintenance.assets.events.create',
                'store'   	=> 'maintenance.assets.events.store',
                'show'    	=> 'maintenance.assets.events.show',
                'edit'    	=> 'maintenance.assets.events.edit',
                'update'  	=> 'maintenance.assets.events.update',
                'destroy' 	=> 'maintenance.assets.events.destroy',
    )
));

/*
 * Asset Routes
 */
Route::resource('assets', 'AssetController', array(
        'names'=> array(
                'index'		=> 'maintenance.assets.index',
                'create'  	=> 'maintenance.assets.create',
                'store'   	=> 'maintenance.assets.store',
                'show'    	=> 'maintenance.assets.show',
                'edit'    	=> 'maintenance.assets.edit',
                'update'  	=> 'maintenance.assets.update',
                'destroy' 	=> 'maintenance.assets.destroy',
        ),
));