<?php

Route::resource('metrics', 'MetricController', [
    'only' => [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ],
    'names' => [
        'index' => 'maintenance.metrics.index',
        'create' => 'maintenance.metrics.create',
        'store' => 'maintenance.metrics.store',
        'edit' => 'maintenance.metrics.edit',
        'update' => 'maintenance.metrics.update',
        'destroy' => 'maintenance.metrics.destroy',
    ],
]);
