<?php

use DaveJamesMiller\Breadcrumbs\Generator;
use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;

Breadcrumbs::register('maintenance.locations.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Locations', route('maintenance.locations.index'));
});

Breadcrumbs::register('maintenance.locations.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.locations.index');
    $breadcrumbs->push('Create', route('maintenance.locations.create'));
});

Breadcrumbs::register('maintenance.locations.edit', function (Generator $breadcrumbs, $locationId) {
    $breadcrumbs->parent('maintenance.locations.index');
    $breadcrumbs->push("ID: $locationId");
    $breadcrumbs->push('Edit', route('maintenance.locations.edit', [$locationId]));
});

Breadcrumbs::register('maintenance.locations.nodes.create', function (Generator $breadcrumbs, $locationId) {
    $breadcrumbs->parent('maintenance.locations.index');
    $breadcrumbs->push('Sub-Location');
    $breadcrumbs->push('Create', route('maintenance.locations.nodes.create', [$locationId]));
});
