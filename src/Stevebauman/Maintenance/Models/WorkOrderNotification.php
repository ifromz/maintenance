<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;
use Stevebauman\Maintenance\Models\BaseModel;

class WorkOrderNotification extends BaseModel
{

    use HasUserTrait;

    protected $table = 'work_order_notifications';

    protected $fillable = array(
        'user_id',
        'work_order_id',
        'status',
        'priority',
        'parts',
        'customer_updates',
        'technician_updates',
        'completion_report',
    );

    public function workOrder()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrder', 'id', 'work_order_id');
    }

}