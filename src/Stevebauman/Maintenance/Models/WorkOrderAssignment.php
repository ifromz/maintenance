<?php

namespace Stevebauman\Maintenance\Models;

/**
 * Class WorkOrderAssignment
 * @package Stevebauman\Maintenance\Models
 */
class WorkOrderAssignment extends BaseModel
{
    protected $table = 'work_order_assignments';

    protected $fillable = array(
        'work_order_id',
        'by_user_id',
        'to_user_id'
    );

    protected $viewer = 'Stevebauman\Maintenance\Viewers\WorkOrder\AssignmentViewer';

    /**
     * The hasOne work order relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workOrder()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrder', 'id', 'work_order_id');
    }

    /**
     * The hasOne by user relationship indicating who assigned the 'toUser'
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function byUser()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'by_user_id');
    }

    /**
     * The hasOne to user relationship indicating who assigned user is
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function toUser()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'to_user_id');
    }

    /**
     * Returns an html label of the assigned user
     *
     * @return string
     */
    public function getLabelAttribute()
    {
        return sprintf('<span class="label label-default">%s</span>', $this->toUser->full_name);
    }
}