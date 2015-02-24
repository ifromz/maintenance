<?php

/**
 * The Work Order breadcrumbs
 */

/*
 * Work Order crumbs
 */
Breadcrumbs::register('maintenance.work-orders.index', function($breadcrumbs) {
    $breadcrumbs->push('Work Orders', route('maintenance.work-orders.index'));
});

Breadcrumbs::register('maintenance.work-orders.create', function($breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-orders.index');
    $breadcrumbs->push('Create', route('maintenance.work-orders.create'));
});

Breadcrumbs::register('maintenance.work-orders.show', function($breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.index');
    $breadcrumbs->push("ID: $workOrderId", route('maintenance.work-orders.show', array($workOrderId)));
});

Breadcrumbs::register('maintenance.work-orders.edit', function($breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Edit', route('maintenance.work-orders.edit', array($workOrderId)));
});
/*
 * End Work Order crumbs
 */

/*
 * Work Order part crumbs
 */
Breadcrumbs::register('maintenance.work-orders.parts.index', function($breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Parts', route('maintenance.work-orders.parts.index', array($workOrderId)));
});

Breadcrumbs::register('maintenance.work-orders.parts.stocks.index', function($breadcrumbs, $workOrderId, $partId) {
    $breadcrumbs->parent('maintenance.work-orders.parts.index', $workOrderId);
    $breadcrumbs->push("ID: $partId", route('maintenance.work-orders.parts.stocks.create', array($workOrderId, $partId)));
});

Breadcrumbs::register('maintenance.work-orders.parts.stocks.create', function($breadcrumbs, $workOrderId, $partId, $stockId) {
    $breadcrumbs->parent('maintenance.work-orders.parts.stocks.index', $workOrderId, $partId);
    $breadcrumbs->push('Enter Quantity', route('maintenance.work-orders.parts.stocks.create', array($workOrderId, $partId, $stockId)));
});
/*
 * End Work Order part crumbs
 */

/*
 * Work Order assigned crumbs
 */
Breadcrumbs::register('maintenance.work-orders.assigned.index', function($breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-orders.index');
    $breadcrumbs->push('Assigned', route('maintenance.work-orders.assigned.index'));
});
/*
 * End work order assigned crumbs
 */

/*
 * Work order event crumbs
 */
Breadcrumbs::register('maintenance.work-orders.events.index', function($breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Events', route('maintenance.work-orders.events.index', array($workOrderId)));
});

Breadcrumbs::register('maintenance.work-orders.events.create', function($breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.events.index', $workOrderId);
    $breadcrumbs->push('Create', route('maintenance.work-orders.events.create', array($workOrderId)));
});

Breadcrumbs::register('maintenance.work-orders.events.show', function($breadcrumbs, $workOrderId, $eventId) {
    $breadcrumbs->parent('maintenance.work-orders.events.index', $workOrderId);
    $breadcrumbs->push("ID: $eventId", route('maintenance.work-orders.events.show', array($workOrderId, $eventId)));
});

Breadcrumbs::register('maintenance.work-orders.events.edit', function($breadcrumbs, $workOrderId, $eventId) {
    $breadcrumbs->parent('maintenance.work-orders.events.show', $workOrderId, $eventId);
    $breadcrumbs->push('Edit', route('maintenance.work-orders.events.edit', array($workOrderId, $eventId)));
});
/*
 * End Work Order event crumbs
 */

/*
 * Work Order report crumbs
 */
Breadcrumbs::register('maintenance.work-orders.report.create', function($breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Create Report', route('maintenance.work-orders.report.create', array($workOrderId)));
});
/*
 * End Work Order report crumbs
 */

/*
 * Work Order attachment crumbs
 */
Breadcrumbs::register('maintenance.work-orders.attachments.index', function($breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.show', $workOrderId);
    $breadcrumbs->push('Attachments', route('maintenance.work-orders.attachments.index', array($workOrderId)));
});

Breadcrumbs::register('maintenance.work-orders.attachments.create', function($breadcrumbs, $workOrderId) {
    $breadcrumbs->parent('maintenance.work-orders.attachments.index', $workOrderId);
    $breadcrumbs->push('Add', route('maintenance.work-orders.attachments.create', array($workOrderId)));
});
/*
 * End Work Order attachment crumbs
 */