<?php

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