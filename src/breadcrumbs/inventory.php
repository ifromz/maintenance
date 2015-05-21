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

Breadcrumbs::register('maintenance.inventory.stocks.show', function (Generator $breadcrumbs, $inventoryId, $stockId) {
    $breadcrumbs->parent('maintenance.inventory.stocks.index', $inventoryId);
    $breadcrumbs->push("ID: $stockId", route('maintenance.inventory.stocks.show', [$inventoryId, $stockId]));
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
