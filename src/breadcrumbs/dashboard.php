<?php

use DaveJamesMiller\Breadcrumbs\Generator;
use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;

Breadcrumbs::register('maintenance.dashboard.index', function(Generator $breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('maintenance.dashboard.index'));
});
