<?php

/*
 * Location Routes
 */

Route::get('locations/json', array(
        'as' => 'maintenance.locations.json',
        'uses' => 'LocationController@getJson',
    )
);

Route::get('locations/create/{categories?}', array(
        'as' => 'maintenance.locations.nodes.create',
        'uses' => 'LocationController@create',
    )
);

Route::post('locations/move/{categories?}', array(
    'as' => 'maintenance.locations.nodes.move',
    'uses' => 'LocationController@postMoveCategory'
));

Route::post('locations/create/{categories?}', array(
        'as' => 'maintenance.locations.nodes.store',
        'uses' => 'LocationController@store',
    )
);

Route::resource('locations', 'LocationController', array(
    'names' => array(
        'index' => 'maintenance.locations.index',
        'create' => 'maintenance.locations.create',
        'store' => 'maintenance.locations.store',
        'show' => 'maintenance.locations.show',
        'edit' => 'maintenance.locations.edit',
        'update' => 'maintenance.locations.update',
        'destroy' => 'maintenance.locations.destroy',
    ),
));