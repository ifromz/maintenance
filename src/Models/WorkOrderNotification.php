<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

class WorkOrderNotification extends BaseModel
{
    use HasUserTrait;

    /**
     * The work order notifications table.
     *
     * @var string
     */
    protected $table = 'work_order_notifications';

    /**
     * The fillable work order notification attributes.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'work_order_id',
        'status',
        'priority',
        'parts',
        'customer_updates',
        'technician_updates',
        'completion_report',
    ];

    /**
     * The hasOne work order relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workOrder()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrder', 'id', 'work_order_id');
    }
}
