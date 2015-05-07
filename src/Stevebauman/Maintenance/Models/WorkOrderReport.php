<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\HasUserTrait;

/**
 * Class WorkOrderReport.
 */
class WorkOrderReport extends BaseModel
{
    use HasUserTrait;

    protected $table = 'work_order_reports';

    protected $fillable = [
        'user_id',
        'work_order_id',
        'description',
    ];

    /**
     * The hasOne work order trait.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workOrder()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrder', 'id', 'work_order_id');
    }
}
