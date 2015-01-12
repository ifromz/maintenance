<?php

Route::group(array('namespace' => 'Event'), function () {

    Route::resource('events', 'EventController', array(
        'names' => array(
            'index' => 'maintenance.events.index',
            'create' => 'maintenance.events.create',
            'store' => 'maintenance.events.store',
            'show' => 'maintenance.events.show',
            'edit' => 'maintenance.events.edit',
            'update' => 'maintenance.events.update',
            'destroy' => 'maintenance.events.destroy',
        )
    ));

    Route::resource('events.report', 'ReportController', array(
        'only' => array(
            'store',
            'edit',
            'update',
            'destroy'
        ),
        'names' => array(
            'store' => 'maintenance.events.report.store',
            'edit' => 'maintenance.events.report.edit',
            'update' => 'maintenance.events.report.update',
            'destroy' => 'maintenance.events.report.destroy',
        )
    ));

});