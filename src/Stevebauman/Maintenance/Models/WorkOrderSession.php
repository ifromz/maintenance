<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

/**
 * Class WorkOrderSession.
 */
class WorkOrderSession extends BaseModel
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
    protected $viewer = 'Stevebauman\Maintenance\Viewers\WorkOrder\SessionViewer';

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
        return $this->hasOne('Stevebauman\Maintenanace\Models\WorkOrder', 'work_order_id');
    }

    /**
     * Returns the number of hours a session lasted with decimals.
     *
     * @return null|int
     */
    public function getHoursAttribute()
    {
        if(array_key_exists('out', $this->attributes)) {
            if ($this->attributes['out']) {
                $hours = abs(round((strtotime($this->attributes['in']) - strtotime($this->attributes['out'])) / 3600, 2));

                return $hours;
            }
        }

        return null;
    }
}
