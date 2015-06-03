<?php

Route::resource('metrics', 'MetricController', [
    'names' => [
        'index' => 'maintenance.metrics.index',
        'create' => 'maintenance.metrics.create',
        'store' => 'maintenance.metrics.store',
        'show' => 'maintenance.metrics.show',
        'edit' => 'maintenance.metrics.edit',
        'update' => 'maintenance.metrics.update',
        'destroy' => 'maintenance.metrics.destroy',
    ],
]);
