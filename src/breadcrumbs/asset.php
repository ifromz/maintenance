<?php

/**
 * The Asset breadcrumbs registration file
 */

/*
 * Asset crumbs
 */
Breadcrumbs::register('maintenance.assets.index', function($breadcrumbs) {
    $breadcrumbs->push('Assets', route('maintenance.assets.index'));
});

Breadcrumbs::register('maintenance.assets.create', function($breadcrumbs) {
    $breadcrumbs->parent('maintenance.assets.index');
    $breadcrumbs->push('Create', route('maintenance.assets.index'));
});

Breadcrumbs::register('maintenance.assets.show', function($breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.index');
    $breadcrumbs->push("ID: $assetId", route('maintenance.assets.show', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.edit', function($breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.show', $assetId);
    $breadcrumbs->push('Edit', route('maintenance.assets.edit', [$assetId]));
});
/*
 * End Asset crumbs
 */

/*
 * Asset Event crumbs
 */
Breadcrumbs::register('maintenance.assets.events.index', function($breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.show', $assetId);
    $breadcrumbs->push('Events', route('maintenance.assets.events.index', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.events.create', function($breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.events.index', $assetId);
    $breadcrumbs->push('Create', route('maintenance.assets.events.create', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.events.show', function($breadcrumbs, $assetId, $eventId) {
    $breadcrumbs->parent('maintenance.assets.events.index', $assetId);
    $breadcrumbs->push("ID: $eventId", route('maintenance.assets.events.show', [$assetId, $eventId]));
});

Breadcrumbs::register('maintenance.assets.events.edit', function($breadcrumbs, $assetId, $eventId) {
    $breadcrumbs->parent('maintenance.assets.events.show', $assetId, $eventId);
    $breadcrumbs->push('Edit', route('maintenance.assets.events.edit', [$assetId, $eventId]));
});
/*
 * End Asset Event crumbs
 */

/*
 * Asset Manual crumbs
 */
Breadcrumbs::register('maintenance.assets.manuals.index', function($breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.show', $assetId);
    $breadcrumbs->push('Manuals', route('maintenance.assets.events.index', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.manuals.create', function($breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.manuals.index', $assetId);
    $breadcrumbs->push('Create', route('maintenance.assets.events.create', [$assetId]));
});
/*
 * End Asset Manual crumbs
 */

/*
 * Asset Category crumbs
 */
Breadcrumbs::register('maintenance.assets.categories.index', function($breadcrumbs) {
    $breadcrumbs->parent('maintenance.assets.index');
    $breadcrumbs->push('Categories', route('maintenance.assets.categories.index'));
});

Breadcrumbs::register('maintenance.assets.categories.create', function($breadcrumbs) {
    $breadcrumbs->parent('maintenance.assets.categories.index');
    $breadcrumbs->push('Create', route('maintenance.assets.categories.create'));
});
/*
 * End Asset Category crumbs
 */