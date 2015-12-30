<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;
use Stevebauman\Maintenance\Viewers\WorkRequestViewer;

class WorkRequest extends Model
{
    use HasUserTrait;

    /**
     * The work requests table.
     *
     * @var string
     */
    protected $table = 'work_requests';

    /**
     * The fillable work request attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'best_time',
    ];

    protected $viewer = WorkRequestViewer::class;

    /**
     * The hasOne workOrder relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workOrder()
    {
        return $this->hasOne(WorkOrder::class, 'request_id', 'id');
    }

    /**
     * The belongsToMany technician updates relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function updates()
    {
        return $this->belongsToMany(Update::class, 'work_request_updates', 'work_request_id', 'update_id');
    }
}
