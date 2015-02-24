<?php

/**
 * The Work Request breadcrumbs registration file
 */

/*
 * Work Request crumbs
 */
Breadcrumbs::register('maintenance.work-requests.index', function($breadcrumbs) {
    $breadcrumbs->push('Work Requests', route('maintenance.work-requests.index'));
});

Breadcrumbs::register('maintenance.work-requests.create', function($breadcrumbs) {
    $breadcrumbs->parent('maintenance.work-requests.index');
    $breadcrumbs->push('Create', route('maintenance.work-requests.create'));
});

Breadcrumbs::register('maintenance.work-requests.show', function($breadcrumbs, $workRequestId) {
    $breadcrumbs->parent('maintenance.work-requests.index');
    $breadcrumbs->push("ID: $workRequestId", route('maintenance.work-requests.show', array($workRequestId)));
});
/*
 * End Work Request crumbs
 */