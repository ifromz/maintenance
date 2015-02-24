<?php

/**
 * The Dashboard breadcrumbs registration file
 */

Breadcrumbs::register('maintenance.dashboard.index', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('maintenance.dashboard.index'));
});