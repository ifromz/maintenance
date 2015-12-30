<?php

use DaveJamesMiller\Breadcrumbs\Facade as Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\Generator;

Breadcrumbs::register('maintenance.dashboard.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('maintenance.dashboard.index'));
});
