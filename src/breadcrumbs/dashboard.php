<?php

use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;

Breadcrumbs::register('maintenance.dashboard.index', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('maintenance.dashboard.index'));
});
