<?php

use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\Generator;

Breadcrumbs::register('maintenance.metrics.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Metrics', route('maintenance.metrics.index'));
});

Breadcrumbs::register('maintenance.metrics.create', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Metrics', route('maintenance.metrics.index'));
    $breadcrumbs->push('Create', route('maintenance.metrics.create'));
});
