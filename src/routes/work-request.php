<?php

Route::group(array('namespace'=>'WorkRequest'), function()
{

    Route::resource('work-requests', 'WorkRequestController', array(
        'names' => array(
            'index' => 'maintenance.work-requests.index',
            'create' => 'maintenance.work-requests.create',
            'store' => 'maintenance.work-requests.store',
            'show' => 'maintenance.work-requests.show',
            'edit' => 'maintenance.work-requests.edit',
            'update' => 'maintenance.work-requests.update',
            'destroy' => 'maintenance.work-requests.destroy',
        ),
    ));

    Route::resource('work-requests.updates', 'UpdateController', array(
        'only' => array(
            'store',
            'destroy',
        ),
        'names' => array(
            'store' => 'maintenance.work-requests.updates.store',
            'destroy' => 'maintenance.work-requests.updates.destroy',
        ),
    ));

});
