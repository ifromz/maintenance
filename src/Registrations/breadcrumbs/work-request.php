<?php

use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\Generator;

/*
 * Work Request crumbs
 */
Breadcrumbs::register('maintenance.work-requests.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Work Requests', route('maintenance.work-requests.index'));
});

Breadcrumbs::register('maintenance.work-requests.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-requests.index');
    $breadcrumbs->push('Create', route('maintenance.work-requests.create'));
});

Breadcrumbs::register('maintenance.work-requests.show', function (Generator $breadcrumbs, $workRequestId) {
    $breadcrumbs->parent('maintenance.work-requests.index');
    $breadcrumbs->push("ID: $workRequestId", route('maintenance.work-requests.show', [$workRequestId]));
});

Breadcrumbs::register('maintenance.work-requests.edit', function (Generator $breadcrumbs, $workRequestId) {
    $breadcrumbs->parent('maintenance.work-requests.show', $workRequestId);
    $breadcrumbs->push('Edit', route('maintenance.work-requests.edit', [$workRequestId]));
});
/*
 * End Work Request crumbs
 */
