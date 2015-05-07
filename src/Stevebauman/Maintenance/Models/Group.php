<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\EloquentTable\TableTrait;
use Stevebauman\Viewer\Traits\ViewableTrait;
use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroup;

/**
 * Class Group.
 */
class Group extends SentryGroup
{
    use TableTrait;

    use ViewableTrait;

    protected $table = 'groups';

    protected $fillable = ['name', 'permissions'];

    protected $viewer = 'Stevebauman\Maintenance\Viewers\GroupViewer';

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
