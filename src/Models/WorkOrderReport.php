<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Traits\Relationships\HasUserTrait;

class WorkOrderReport extends BaseModel
{
    use HasUserTrait;

    /**
     * The work order reports table.
     *
     * @var string
     */
    protected $table = 'work_order_reports';

    /**
     * The fillable work order report attributes.
     *
     * @var array
     */
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
