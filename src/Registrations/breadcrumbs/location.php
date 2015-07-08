<?php

use DaveJamesMiller\Breadcrumbs\Generator;
use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;

Breadcrumbs::register('maintenance.locations.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Locations', route('maintenance.locations.index'));
});

Breadcrumbs::register('maintenance.locations.create', function (Generator $breadcrumbs, $locationId) {
    $breadcrumbs->parent('maintenance.locations.index');
    $breadcrumbs->push('Create', route('maintenance.locations.create', [$locationId]));
});

Breadcrumbs::register('maintenance.locations.show', function (Generator $breadcrumbs, $locationId) {
    $breadcrumbs->parent('maintenance.locations.index');
    $breadcrumbs->push("ID: $locationId");
});

Breadcrumbs::register('maintenance.locations.edit', function (Generator $breadcrumbs, $locationId) {
    $breadcrumbs->parent('maintenance.locations.show', $locationId);
    $breadcrumbs->push('Edit', route('maintenance.locations.edit', [$locationId]));
});

Breadcrumbs::register('maintenance.locations.nodes.create', function (Generator $breadcrumbs, $locationId = null) {
    $breadcrumbs->parent('maintenance.locations.show', $locationId);
    $breadcrumbs->push('Create-Sub', route('maintenance.locations.nodes.create', [$locationId]));
});
