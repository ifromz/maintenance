<?php

use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\Generator;

/*
 * Client Work Request crumbs
 */
Breadcrumbs::register('maintenance.events.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Events', route('maintenance.events.index'));
});

Breadcrumbs::register('maintenance.events.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.events.index');
    $breadcrumbs->push('Create', route('maintenance.events.create'));
});

Breadcrumbs::register('maintenance.events.show', function (Generator $breadcrumbs, $eventId) {
    $breadcrumbs->parent('maintenance.events.index');
    $breadcrumbs->push("ID: $eventId", route('maintenance.events.show', [$eventId]));
});

Breadcrumbs::register('maintenance.events.edit', function (Generator $breadcrumbs, $eventId) {
    $breadcrumbs->parent('maintenance.events.show', $eventId);
    $breadcrumbs->push('Edit', route('maintenance.events.edit', [$eventId]));
});
/*
 * End Client Work Request crumbs
 */
