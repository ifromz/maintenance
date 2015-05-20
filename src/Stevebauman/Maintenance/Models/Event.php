<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasLocationTrait;
use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

/**
 * Class Event.
 */
class Event extends BaseModel
{
    use HasLocationTrait;
    use HasUserTrait;

    protected $table = 'events';

    protected $fillable = [
        'user_id',
        'parent_id',
        'api_id',
    ];

    protected $viewer = 'Stevebauman\Maintenance\Viewers\Event\EventViewer';

    /**
     * The hasOne report relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function report()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\EventReport', 'event_id');
    }

    /**
     * The belongsTo parent event relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentEvent()
    {
        return $this->belongsTo('Stevebauman\Maintenance\Models\Event', 'parent_id');
    }

    /**
     * The morphedByMany assets relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assets()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\Asset', 'eventable')->withTimestamps();
    }

    /**
     * The morphedByMany inventories relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inventories()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\Inventory', 'eventable')->withTimestamps();
    }

    /**
     * The morphedByMany work orders relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function workOrders()
    {
        return $this->morphedByMany('Stevebauman\Maintenance\Models\WorkOrder', 'eventable')->withTimestamps();
    }
}
