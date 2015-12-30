<?php

namespace Stevebauman\Maintenance\Models;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Stevebauman\EloquentTable\TableTrait;
use Stevebauman\Maintenance\Viewers\GroupViewer;
use Stevebauman\Viewer\Traits\ViewableTrait;

class Role extends EloquentRole
{
    use TableTrait;

    use ViewableTrait;

    /**
     * The group viewer class.
     *
     * @var string
     */
    protected $viewer = GroupViewer::class;
}
