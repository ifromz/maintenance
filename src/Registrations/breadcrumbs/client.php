<?php

use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\Generator;

/*
 * Client Work Request crumbs
 */
Breadcrumbs::register('maintenance.client.work-requests.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Work Requests', route('maintenance.client.work-requests.index'));
});

Breadcrumbs::register('maintenance.client.work-requests.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.client.work-requests.index');
    $breadcrumbs->push('Create', route('maintenance.client.work-requests.create'));
});

Breadcrumbs::register('maintenance.client.work-requests.show', function (Generator $breadcrumbs, $workRequestId) {
    $breadcrumbs->parent('maintenance.client.work-requests.index');
    $breadcrumbs->push("ID: $workRequestId", route('maintenance.work-requests.show', [$workRequestId]));
});

Breadcrumbs::register('maintenance.client.work-requests.edit', function (Generator $breadcrumbs, $workRequestId) {
    $breadcrumbs->parent('maintenance.client.work-requests.show', $workRequestId);
    $breadcrumbs->push('Edit', route('maintenance.client.work-requests.edit', [$workRequestId]));
});
/*
 * End Client Work Request crumbs
 */
