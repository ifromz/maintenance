<?php

use DaveJamesMiller\Breadcrumbs\Generator;
use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;

/*
 * Work Order crumbs
 */
Breadcrumbs::register('maintenance.work-orders.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Work Orders', route('maintenance.work-orders.index'));
});

Breadcrumbs::register('maintenance.work-orders.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-orders.index');
    $breadcrumbs->push('Create', route('maintenance.work-orders.create'));
});

Breadcrumbs::register('maintenance.work-orders.show', function (Generator $breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.index');
    $breadcrumbs->push("ID: $workOrderId", route('maintenance.work-orders.show', [$workOrderId]));
});

Breadcrumbs::register('maintenance.work-orders.edit', function (Generator $breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Edit', route('maintenance.work-orders.edit', [$workOrderId]));
});
/*
 * End Work Order crumbs
 */

/*
 * Work Order part crumbs
 */
Breadcrumbs::register('maintenance.work-orders.parts.index', function (Generator $breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Parts', route('maintenance.work-orders.parts.index', [$workOrderId]));
});

Breadcrumbs::register('maintenance.work-orders.parts.stocks.index', function (Generator $breadcrumbs, $workOrderId, $partId) {
    $breadcrumbs->parent('maintenance.work-orders.parts.index', $workOrderId);
    $breadcrumbs->push("ID: $partId", route('maintenance.work-orders.parts.stocks.create', [$workOrderId, $partId]));
});

Breadcrumbs::register('maintenance.work-orders.parts.stocks.create', function (Generator $breadcrumbs, $workOrderId, $partId, $stockId) {
    $breadcrumbs->parent('maintenance.work-orders.parts.stocks.index', $workOrderId, $partId);
    $breadcrumbs->push('Enter Quantity', route('maintenance.work-orders.parts.stocks.create', [$workOrderId, $partId, $stockId]));
});
/*
 * End Work Order part crumbs
 */

/*
 * Work Order assigned crumbs
 */
Breadcrumbs::register('maintenance.work-orders.assigned.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-orders.index');
    $breadcrumbs->push('Assigned', route('maintenance.work-orders.assigned.index'));
});
/*
 * End work order assigned crumbs
 */

/*
 * Work order event crumbs
 */
Breadcrumbs::register('maintenance.work-orders.events.index', function (Generator $breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Events', route('maintenance.work-orders.events.index', [$workOrderId]));
});

Breadcrumbs::register('maintenance.work-orders.events.create', function (Generator $breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.events.index', $workOrderId);
    $breadcrumbs->push('Create', route('maintenance.work-orders.events.create', [$workOrderId]));
});

Breadcrumbs::register('maintenance.work-orders.events.show', function (Generator $breadcrumbs, $workOrderId, $eventId) {
    $breadcrumbs->parent('maintenance.work-orders.events.index', $workOrderId);
    $breadcrumbs->push("ID: $eventId", route('maintenance.work-orders.events.show', [$workOrderId, $eventId]));
});

Breadcrumbs::register('maintenance.work-orders.events.edit', function (Generator $breadcrumbs, $workOrderId, $eventId) {
    $breadcrumbs->parent('maintenance.work-orders.events.show', $workOrderId, $eventId);
    $breadcrumbs->push('Edit', route('maintenance.work-orders.events.edit', [$workOrderId, $eventId]));
});
/*
 * End Work Order event crumbs
 */

/*
 * Work Order report crumbs
 */
Breadcrumbs::register('maintenance.work-orders.report.create', function (Generator $breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Create Report', route('maintenance.work-orders.report.create', [$workOrderId]));
});
/*
 * End Work Order report crumbs
 */

/*
 * Work Order attachment crumbs
 */
Breadcrumbs::register('maintenance.work-orders.attachments.index', function (Generator $breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Attachments', route('maintenance.work-orders.attachments.index', [$workOrderId]));
});

Breadcrumbs::register('maintenance.work-orders.attachments.create', function (Generator $breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.attachments.index', $workOrderId);
    $breadcrumbs->push('Add', route('maintenance.work-orders.attachments.create', [$workOrderId]));
});
/*
 * End Work Order attachment crumbs
 */

/*
 * Work Order Status crumbs
 */
Breadcrumbs::register('maintenance.work-orders.statuses.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-orders.index');
    $breadcrumbs->push('Statuses', route('maintenance.work-orders.statuses.index'));
});
/*
 * End Work Order Status crumbs
 */
