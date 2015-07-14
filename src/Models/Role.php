<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Viewers\GroupViewer;
use Stevebauman\EloquentTable\TableTrait;
use Stevebauman\Viewer\Traits\ViewableTrait;
use Cartalyst\Sentinel\Roles\EloquentRole;

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
