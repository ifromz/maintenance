<?php

use DaveJamesMiller\Breadcrumbs\Generator;
use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;

/*
 * Inventory crumbs
 */
Breadcrumbs::register('maintenance.inventory.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Inventory', route('maintenance.inventory.index'));
});

Breadcrumbs::register('maintenance.inventory.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.inventory.index');
    $breadcrumbs->push('Create', route('maintenance.inventory.create'));
});

Breadcrumbs::register('maintenance.inventory.show', function (Generator $breadcrumbs, $inventoryId) {
    $breadcrumbs->parent('maintenance.inventory.index');
    $breadcrumbs->push("ID: $inventoryId", route('maintenance.inventory.show', [$inventoryId]));
});

Breadcrumbs::register('maintenance.inventory.edit', function (Generator $breadcrumbs, $inventoryId) {
    $breadcrumbs->parent('maintenance.inventory.show', $inventoryId);
    $breadcrumbs->push('Edit', route('maintenance.inventory.edit', [$inventoryId]));
});
/*
 * End Inventory crumbs
 */


/*
 * Inventory Category crumbs
 */
Breadcrumbs::register('maintenance.inventory.categories.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.inventory.index');
    $breadcrumbs->push('Categories', route('maintenance.inventory.categories.index'));
});

Breadcrumbs::register('maintenance.inventory.categories.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.inventory.categories.index');
    $breadcrumbs->push('Create', route('maintenance.inventory.categories.create'));
});

Breadcrumbs::register('maintenance.inventory.categories.nodes.create', function (Generator $breadcrumbs, $categoryId) {
    $breadcrumbs->parent('maintenance.inventory.categories.index');
    $breadcrumbs->push("ID: $categoryId");
    $breadcrumbs->push('Create', route('maintenance.inventory.categories.nodes.create', [$categoryId]));
});
/*
 * End Inventory Category crumbs
 */
Breadcrumbs::register('maintenance.inventory.notes.create', function (Generator $breadcrumbs, $inventoryId) {
    $breadcrumbs->parent('maintenance.inventory.show', $inventoryId);
    $breadcrumbs->push('Notes');
    $breadcrumbs->push('Create', route('maintenance.inventory.notes.create', [$inventoryId]));
});

Breadcrumbs::register('maintenance.inventory.notes.show', function (Generator $breadcrumbs, $inventoryId, $noteId) {
    $breadcrumbs->parent('maintenance.inventory.show', $inventoryId);
    $breadcrumbs->push('Notes');
    $breadcrumbs->push("ID: $noteId", route('maintenance.inventory.notes.show', [$inventoryId, $noteId]));
});

Breadcrumbs::register('maintenance.inventory.notes.edit', function (Generator $breadcrumbs, $inventoryId, $noteId) {
    $breadcrumbs->parent('maintenance.inventory.notes.show', $inventoryId, $noteId);
    $breadcrumbs->push('Edit');
});
/*
 * Inventory Note crumbs
 */

/*
 * End Inventory Note Crumbs
 */

/*
 * Inventory Variant crumbs
 */
Breadcrumbs::register('maintenance.inventory.variants.create', function (Generator $breadcrumbs, $inventoryId) {
    $breadcrumbs->parent('maintenance.inventory.show', $inventoryId);
    $breadcrumbs->push('Create Variant');
});
/*
 * End Inventory Variant crumbs
 */

/*
 * Inventory Stock crumbs
 */
Breadcrumbs::register('maintenance.inventory.stocks.index', function (Generator $breadcrumbs, $inventoryId) {
    $breadcrumbs->parent('maintenance.inventory.show', $inventoryId);
    $breadcrumbs->push('Stocks', route('maintenance.inventory.stocks.index', [$inventoryId]));
});

Breadcrumbs::register('maintenance.inventory.stocks.create', function (Generator $breadcrumbs, $inventoryId) {
    $breadcrumbs->parent('maintenance.inventory.stocks.index', $inventoryId);
    $breadcrumbs->push('Create', route('maintenance.inventory.stocks.create', [$inventoryId]));
});

Breadcrumbs::register('maintenance.inventory.stocks.show', function (Generator $breadcrumbs, $inventoryId, $stockId) {
    $breadcrumbs->parent('maintenance.inventory.stocks.index', $inventoryId);
    $breadcrumbs->push("ID: $stockId", route('maintenance.inventory.stocks.show', [$inventoryId, $stockId]));
});

Breadcrumbs::register('maintenance.inventory.stocks.edit', function (Generator $breadcrumbs, $inventoryId, $stockId) {
    $breadcrumbs->parent('maintenance.inventory.stocks.show', $inventoryId, $stockId);
    $breadcrumbs->push('Edit', route('maintenance.inventory.stocks.edit', [$inventoryId, $stockId]));
});
/*
 * End Inventory Stock Crumbs
 */

/*
 * Inventory Stock Movement crumbs
 */
Breadcrumbs::register('maintenance.inventory.stocks.movements.index', function (Generator $breadcrumbs, $inventoryId, $stockId) {
    $breadcrumbs->parent('maintenance.inventory.stocks.show', $inventoryId, $stockId);
    $breadcrumbs->push('Movements', route('maintenance.inventory.stocks.movements.index', [$inventoryId, $stockId]));
});

Breadcrumbs::register('maintenance.inventory.stocks.movements.show', function (Generator $breadcrumbs, $inventoryId, $stockId, $movementId) {
    $breadcrumbs->parent('maintenance.inventory.stocks.movements.index', $inventoryId, $stockId);
    $breadcrumbs->push("ID: $movementId", route('maintenance.inventory.stocks.movements.index', [$inventoryId, $stockId, $movementId]));
});
/*
 * End Inventory Stock Movement crumbs
 */

/*
 * Inventory Event crumbs
 */
Breadcrumbs::register('maintenance.inventory.events.index', function (Generator $breadcrumbs, $inventoryId) {
    $breadcrumbs->parent('maintenance.inventory.show', $inventoryId);
    $breadcrumbs->push('Events', route('maintenance.inventory.events.index', [$inventoryId]));
});

Breadcrumbs::register('maintenance.inventory.events.create', function (Generator $breadcrumbs, $inventoryId) {
    $breadcrumbs->parent('maintenance.inventory.events.index', $inventoryId);
    $breadcrumbs->push('Create', route('maintenance.inventory.events.create', [$inventoryId]));
});

Breadcrumbs::register('maintenance.inventory.events.show', function (Generator $breadcrumbs, $inventoryId, $eventId) {
    $breadcrumbs->parent('maintenance.inventory.events.index', $inventoryId);
    $breadcrumbs->push("ID: $eventId", route('maintenance.inventory.events.show', [$inventoryId, $eventId]));
});

Breadcrumbs::register('maintenance.inventory.events.edit', function (Generator $breadcrumbs, $inventoryId, $eventId) {
    $breadcrumbs->parent('maintenance.inventory.events.show', $inventoryId, $eventId);
    $breadcrumbs->push('Edit', route('maintenance.inventory.events.edit', [$inventoryId, $eventId]));
});
/*
 * End Inventory Event crumbs
 */
