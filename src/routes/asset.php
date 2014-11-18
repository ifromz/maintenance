<?php

/*
 * Asset Routes
 */

/*
 * Category Routes
 */
Route::get('assets/categories/json', array(
                'as' => 'maintenance.assets.categories.json',
                'uses' => 'AssetCategoryController@getJson',
        )
);

Route::get('assets/categories/create/{categories?}', array(
                'as' => 'maintenance.assets.categories.nodes.create',
                'uses' => 'AssetCategoryController@create',
        )
);

Route::post('assets/categories/move/{categories?}', array(
        'as' => 'maintenance.assets.categories.nodes.move',
        'uses'=> 'AssetCategoryController@postMoveCategory'
));

Route::post('assets/categories/create/{categories?}', array(
                'as' => 'maintenance.assets.categories.nodes.store',
                'uses' => 'AssetCategoryController@store',
        )
);

Route::resource('assets/categories', 'AssetCategoryController', array(
        'names'=> array(
                'index'		=> 'maintenance.assets.categories.index',
                'create'  	=> 'maintenance.assets.categories.create',
                'store'   	=> 'maintenance.assets.categories.store',
                'show'    	=> 'maintenance.assets.categories.show',
                'edit'    	=> 'maintenance.assets.categories.edit',
                'update'  	=> 'maintenance.assets.categories.update',
                'destroy' 	=> 'maintenance.assets.categories.destroy',
        ),
));
/*
 * End Category Routes
 */

/*
 * Upload Routes
 */
Route::post('assets/images/uploads', array(
        'as' => 'maintenance.assets.images.uploads.store',
        'uses' => 'AssetImageUploadController@store'
));

Route::post('assets/images/uploads/destroy', array(
        'as' => 'maintenance.assets.images.uploads.destroy',
        'uses' => 'AssetImageUploadController@destroy'
));
/*
 * End Upload Routes
 */

/*
 * Asset Meter Routes
 */
Route::resource('assets.meters', 'AssetMeterController', array(
    'names' => array(
        'index'         => 'maintenance.assets.meters.index',
        'store'   	=> 'maintenance.assets.meters.store',
        'show'    	=> 'maintenance.assets.meters.show',
        'edit'    	=> 'maintenance.assets.meters.edit',
        'update'  	=> 'maintenance.assets.meters.update',
        'destroy' 	=> 'maintenance.assets.meters.destroy',
    )
));

Route::resource('assets.meters.readings', 'AssetMeterReadingController', array(
    'only' => array(
        'store',
        'destroy',
    ),
    'names' => array(
        'store'   	=> 'maintenance.assets.meters.readings.store',
        'destroy'       => 'maintenance.assets.meters.readings.destroy'
    )
));
/*
 * End Asset Meter Routes
 */

/*
 * Asset Image Routes
 */
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
/*
 * End Asset Image Routes
 */


/*
 * Asset Manual Upload Routes
 */
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

/*
 * Asset Calendar Routes
 */
Route::resource('assets.calendars', 'AssetCalendarController', array(
    'names' => array(
            'index'	=> 'maintenance.assets.calendars.index',
            'create'  	=> 'maintenance.assets.calendars.create',
            'store'   	=> 'maintenance.assets.calendars.store',
            'show'    	=> 'maintenance.assets.calendars.show',
            'edit'    	=> 'maintenance.assets.calendars.edit',
            'update'  	=> 'maintenance.assets.calendars.update',
            'destroy' 	=> 'maintenance.assets.calendars.destroy',
    )
));

/*
 * Asset Event Routes
 */
Route::delete('assets/{assets}/events/{events}/recurrence/{recurrence}', array(
    'as' => 'maintenance.assets.events.destroy-recurrence',
    'uses' => 'AssetEventController@destroyRecurrence'
));

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
 * End Asset Event Routes
 */

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