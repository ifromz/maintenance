<?php

namespace App\Models;

use App\Models\Traits\HasUserTrait;
use App\Viewers\WorkOrder\SessionViewer;

class WorkOrderSession extends Model
{
    use HasUserTrait;

    /**
     * The work order sessions table.
     *
     * @var string
     */
    protected $table = 'work_order_sessions';

    /**
     * The work order session viewer.
     *
     * @var string
     */
    protected $viewer = SessionViewer::class;

    /**
     * The fillable work order session attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'work_order_id',
        'in',
        'out',
        'hours',
    ];

    /**
     * The hasOne work order relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workOrder()
    {
        return $this->hasOne(WorkOrder::class, 'work_order_id');
    }

    /**
     * Returns the number of hours a session lasted with decimals.
     *
     * @return null|int
     */
    public function getHoursAttribute()
    {
        if (array_key_exists('out', $this->attributes)) {
            if ($this->attributes['out']) {
                $hours = abs(round((strtotime($this->attributes['in']) - strtotime($this->attributes['out'])) / 3600, 2));

                return $hours;
            }
        }

        return;
    }
}
