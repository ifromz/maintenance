<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

/**
 * Class WorkRequest.
 */
class WorkRequest extends BaseModel
{
    use HasUserTrait;

    protected $table = 'work_requests';

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'best_time',
    ];

    protected $viewer = 'Stevebauman\Maintenance\Viewers\WorkRequestViewer';

    /**
     * The hasOne workOrder relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workOrder()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrder', 'request_id', 'id');
    }

    /**
     * The belongsToMany technician updates relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function updates()
    {
        return $this->belongsToMany('Stevebauman\Maintenance\Models\Update', 'work_request_updates', 'work_request_id', 'update_id')->withTimestamps();
    }
}
