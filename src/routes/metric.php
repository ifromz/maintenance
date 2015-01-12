<?php

Route::resource('metrics', 'MetricController', array(
    'only' => array(
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy'
    ),
    'names' => array(
        'index' => 'maintenance.metrics.index',
        'create' => 'maintenance.metrics.create',
        'store' => 'maintenance.metrics.store',
        'edit' => 'maintenance.metrics.edit',
        'update' => 'maintenance.metrics.update',
        'destroy' => 'maintenance.metrics.destroy',
    ),
));