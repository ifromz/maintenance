<?php

/**
 * The dashboard breadcrumbs
 */

Breadcrumbs::register('maintenance.dashboard.index', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('maintenance.dashboard.index'));
});