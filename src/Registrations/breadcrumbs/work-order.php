<?php

use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\Generator;

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
    $breadcrumbs->push("ID: $partId", route('maintenance.work-orders.parts.stocks.index', [$workOrderId, $partId]));
});

Breadcrumbs::register('maintenance.work-orders.parts.stocks.take', function (Generator $breadcrumbs, $workOrderId, $partId, $stockId) {
    $breadcrumbs->parent('maintenance.work-orders.parts.stocks.index', $workOrderId, $partId);
    $breadcrumbs->push("ID: $stockId");
    $breadcrumbs->push('Enter Quantity', route('maintenance.work-orders.parts.stocks.take', [$workOrderId, $partId, $stockId]));
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
    $breadcrumbs->push('Upload', route('maintenance.work-orders.attachments.create', [$workOrderId]));
});

Breadcrumbs::register('maintenance.work-orders.attachments.show', function (Generator $breadcrumbs, $workOrderId, $attachmentId) {
    $breadcrumbs->parent('maintenance.work-orders.attachments.index', $workOrderId);
    $breadcrumbs->push("ID: $attachmentId", route('maintenance.work-orders.attachments.show', [$workOrderId, $attachmentId]));
});

Breadcrumbs::register('maintenance.work-orders.attachments.edit', function (Generator $breadcrumbs, $workOrderId, $attachmentId) {
    $breadcrumbs->parent('maintenance.work-orders.attachments.show', $workOrderId, $attachmentId);
    $breadcrumbs->push('Edit', route('maintenance.work-orders.attachments.edit', [$workOrderId, $attachmentId]));
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

Breadcrumbs::register('maintenance.work-orders.statuses.edit', function (Generator $breadcrumbs, $statusId) {
    $breadcrumbs->parent('maintenance.work-orders.statuses.index');
    $breadcrumbs->push("ID: $statusId");
    $breadcrumbs->push('Edit', route('maintenance.work-orders.statuses.edit', [$statusId]));
});
/*
 * End Work Order Status crumbs
 */

/*
 * Work Order Priority crumbs
 */
Breadcrumbs::register('maintenance.work-orders.priorities.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-orders.index');
    $breadcrumbs->push('Priorities', route('maintenance.work-orders.priorities.index'));
});

Breadcrumbs::register('maintenance.work-orders.priorities.edit', function (Generator $breadcrumbs, $priorityId) {
    $breadcrumbs->parent('maintenance.work-orders.priorities.index');
    $breadcrumbs->push("ID: $priorityId");
    $breadcrumbs->push('Edit', route('maintenance.work-orders.priorities.edit', [$priorityId]));
});
/*
 * End Work Order Priority crumbs
 */

/*
 * Work Order Category crumbs
 */
Breadcrumbs::register('maintenance.work-orders.categories.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-orders.index');
    $breadcrumbs->push('Categories', route('maintenance.work-orders.categories.index'));
});

Breadcrumbs::register('maintenance.work-orders.categories.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-orders.categories.index');
    $breadcrumbs->push('Create', route('maintenance.work-orders.categories.create'));
});

Breadcrumbs::register('maintenance.work-orders.categories.nodes.create', function (Generator $breadcrumbs, $categoryId) {
    $breadcrumbs->parent('maintenance.work-orders.categories.index');
    $breadcrumbs->push('Sub-Category');
    $breadcrumbs->push('Create', route('maintenance.work-orders.categories.nodes.create', [$categoryId]));
});
/*
 * End Work Order Category crumbs
 */

/*
 * Work Order Session crumbs
 */
Breadcrumbs::register('maintenance.work-orders.sessions.index', function (Generator $breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Sessions', route('maintenance.work-orders.sessions.index', [$workOrderId]));
});
/*
 * End Work Order Session crumbs
 */
