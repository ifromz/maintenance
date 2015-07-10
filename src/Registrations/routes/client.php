<?php

/*
 * Maintenance Client Routes
 */

Route::group(['namespace' => 'Client'], function ()
{
    Route::resource('work-requests', 'WorkRequestController', [
        'names' => [
            'index' => 'maintenance.client.work-requests.index',
            'create' => 'maintenance.client.work-requests.create',
            'store' => 'maintenance.client.work-requests.store',
            'show' => 'maintenance.client.work-requests.show',
            'edit' => 'maintenance.client.work-requests.edit',
            'update' => 'maintenance.client.work-requests.update',
            'destroy' => 'maintenance.client.work-requests.destroy',
        ],
    ]);
});
