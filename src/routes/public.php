<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(array('namespace' => 'Controllers'), function () {

    Route::resource('work-requests', 'PublicWorkOrderController', array(
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

});

