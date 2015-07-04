<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Viewers\GroupViewer;
use Stevebauman\EloquentTable\TableTrait;
use Stevebauman\Viewer\Traits\ViewableTrait;
use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroup;

class Group extends SentryGroup
{
    use TableTrait;

    use ViewableTrait;

    /**
     * The group table.
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * The fillable group attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'permissions'
    ];

    /**
     * The group viewer class.
     *
     * @var string
     */
    protected $viewer = GroupViewer::class;

    /**
     * The belongsToMany users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Stevebauman\Maintenance\Models\User', 'users_groups', 'group_id', 'user_id');
    }
}
