<?php

/**
 * The Location breadcrumbs registration file
 */
Breadcrumbs::register('maintenance.locations.index', function($breadcrumbs) {
    $breadcrumbs->push('Locations', route('maintenance.locations.index'));
});

Breadcrumbs::register('maintenance.locations.create', function($breadcrumbs, $locationId) {
    $breadcrumbs->parent('maintenance.locations.index');
    $breadcrumbs->push('Create', route('maintenance.locations.create', array($locationId)));
});

Breadcrumbs::register('maintenance.locations.show', function($breadcrumbs, $locationId) {
    $breadcrumbs->parent('maintenance.locations.index');
    $breadcrumbs->push("ID: $locationId");
});

Breadcrumbs::register('maintenance.locations.edit', function($breadcrumbs, $locationId) {
    $breadcrumbs->parent('maintenance.locations.show', $locationId);
    $breadcrumbs->push('Edit', route('maintenance.locations.edit', array($locationId)));
});

Breadcrumbs::register('maintenance.locations.nodes.create', function($breadcrumbs, $locationId) {
    $breadcrumbs->parent('maintenance.locations.show', $locationId);
    $breadcrumbs->push('Create-Sub', route('maintenance.locations.nodes.create', array($locationId)));
});