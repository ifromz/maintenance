<?php

use DaveJamesMiller\Breadcrumbs\Generator;
use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;

/*
 * Asset crumbs
 */
Breadcrumbs::register('maintenance.assets.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Assets', route('maintenance.assets.index'));
});

Breadcrumbs::register('maintenance.assets.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.assets.index');
    $breadcrumbs->push('Create', route('maintenance.assets.index'));
});

Breadcrumbs::register('maintenance.assets.show', function (Generator $breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.index');
    $breadcrumbs->push("ID: $assetId", route('maintenance.assets.show', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.edit', function (Generator $breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.show', $assetId);
    $breadcrumbs->push('Edit', route('maintenance.assets.edit', [$assetId]));
});
/*
 * End Asset crumbs
 */

/*
 * Asset Event crumbs
 */
Breadcrumbs::register('maintenance.assets.events.index', function (Generator $breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.show', $assetId);
    $breadcrumbs->push('Events', route('maintenance.assets.events.index', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.events.create', function (Generator $breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.events.index', $assetId);
    $breadcrumbs->push('Create', route('maintenance.assets.events.create', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.events.show', function (Generator $breadcrumbs, $assetId, $eventId) {
    $breadcrumbs->parent('maintenance.assets.events.index', $assetId);
    $breadcrumbs->push("ID: $eventId", route('maintenance.assets.events.show', [$assetId, $eventId]));
});

Breadcrumbs::register('maintenance.assets.events.edit', function (Generator $breadcrumbs, $assetId, $eventId) {
    $breadcrumbs->parent('maintenance.assets.events.show', $assetId, $eventId);
    $breadcrumbs->push('Edit', route('maintenance.assets.events.edit', [$assetId, $eventId]));
});
/*
 * End Asset Event crumbs
 */

/*
 * Asset Images crumbs
 */
Breadcrumbs::register('maintenance.assets.images.index', function (Generator $breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.show', $assetId);
    $breadcrumbs->push('Images', route('maintenance.assets.images.index', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.images.create', function (Generator $breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.images.index', $assetId);
    $breadcrumbs->push('Create', route('maintenance.assets.images.create', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.images.show', function (Generator $breadcrumbs, $assetId, $attachmentId) {
    $breadcrumbs->parent('maintenance.assets.images.index', $assetId);
    $breadcrumbs->push('ID: '.$attachmentId, route('maintenance.assets.images.show', [$assetId, $attachmentId]));
});

Breadcrumbs::register('maintenance.assets.images.edit', function (Generator $breadcrumbs, $assetId, $attachmentId) {
    $breadcrumbs->parent('maintenance.assets.images.show', $assetId, $attachmentId);
    $breadcrumbs->push('Edit', route('maintenance.assets.images.edit', $assetId, $attachmentId));
});
/*
 * End Asset Images crumbs
 */

/*
 * Asset Manual crumbs
 */
Breadcrumbs::register('maintenance.assets.manuals.index', function (Generator $breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.show', $assetId);
    $breadcrumbs->push('Manuals', route('maintenance.assets.manuals.index', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.manuals.create', function (Generator $breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.manuals.index', $assetId);
    $breadcrumbs->push('Create', route('maintenance.assets.manuals.create', [$assetId]));
});

Breadcrumbs::register('maintenance.assets.manuals.show', function (Generator $breadcrumbs, $assetId, $attachmentId) {
    $breadcrumbs->parent('maintenance.assets.manuals.index', $assetId);
    $breadcrumbs->push('ID: '.$attachmentId, route('maintenance.assets.manuals.show', [$assetId, $attachmentId]));
});
/*
 * End Asset Manual crumbs
 */

/*
 * Asset Category crumbs
 */
Breadcrumbs::register('maintenance.assets.categories.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.assets.index');
    $breadcrumbs->push('Categories', route('maintenance.assets.categories.index'));
});

Breadcrumbs::register('maintenance.assets.categories.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.assets.categories.index');
    $breadcrumbs->push('Create', route('maintenance.assets.categories.create'));
});

Breadcrumbs::register('maintenance.assets.categories.nodes.create', function (Generator $breadcrumbs, $categoryId) {
    $breadcrumbs->parent('maintenance.assets.categories.index');
    $breadcrumbs->push("Sub-Category");
    $breadcrumbs->push('Create', route('maintenance.assets.categories.nodes.create', [$categoryId]));
});
/*
 * End Asset Category crumbs
 */

/*
 * Asset Work Order crumbs
 */
Breadcrumbs::register('maintenance.assets.work-orders.index', function (Generator $breadcrumbs, $assetId) {
    $breadcrumbs->parent('maintenance.assets.show', $assetId);
    $breadcrumbs->push('Work Orders', route('maintenance.assets.work-orders.index'));
});
/*
 * End Asset Work Order crumbs
 */
