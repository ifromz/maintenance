<?php

Route::group(['namespace'=>'WorkRequest'], function()
{

    Route::resource('work-requests', 'WorkRequestController', [
        'names' => [
            'index' => 'maintenance.work-requests.index',
            'create' => 'maintenance.work-requests.create',
            'store' => 'maintenance.work-requests.store',
            'show' => 'maintenance.work-requests.show',
            'edit' => 'maintenance.work-requests.edit',
            'update' => 'maintenance.work-requests.update',
            'destroy' => 'maintenance.work-requests.destroy',
        ],
    ]);

    Route::resource('work-requests.updates', 'UpdateController', [
        'only' => [
            'store',
            'destroy',
        ],
        'names' => [
            'store' => 'maintenance.work-requests.updates.store',
            'destroy' => 'maintenance.work-requests.updates.destroy',
        ],
    ]);

});
