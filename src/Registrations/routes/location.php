<?php

/*
 * Location Routes
 */

Route::get('locations/json', [
        'as' => 'maintenance.locations.json',
        'uses' => 'LocationController@getJson',
    ]
);

Route::post('locations/move/{categories?}', [
    'as' => 'maintenance.locations.nodes.move',
    'uses' => 'LocationController@postMoveCategory',
]);

Route::post('locations/create/{categories?}', [
        'as' => 'maintenance.locations.nodes.store',
        'uses' => 'LocationController@store',
    ]
);

Route::resource('locations', 'LocationController', [
    'only' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'names' => [
        'index' => 'maintenance.locations.index',
        'create' => 'maintenance.locations.create',
        'store' => 'maintenance.locations.store',
        'edit' => 'maintenance.locations.edit',
        'update' => 'maintenance.locations.update',
        'destroy' => 'maintenance.locations.destroy',
    ],
]);


Route::get('locations/create/{categories}', [
        'as' => 'maintenance.locations.nodes.create',
        'uses' => 'LocationController@create',
    ]
);

