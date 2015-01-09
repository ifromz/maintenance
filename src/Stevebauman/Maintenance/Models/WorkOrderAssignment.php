<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class WorkOrderAssignment extends BaseModel
{

    protected $table = 'work_order_assignments';

    protected $fillable = array(
        'work_order_id',
        'by_user_id',
        'to_user_id'
    );

    protected $viewer = 'Stevebauman\Maintenance\Viewers\WorkOrder\AssignmentViewer';

    public function workOrder()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrder', 'id', 'work_order_id');
    }

    public function byUser()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'by_user_id');
    }

    public function toUser()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'to_user_id');
    }

    public function getLabelAttribute()
    {
        return sprintf('<span class="label label-default">%s</span>', $this->toUser->full_name);
    }
}