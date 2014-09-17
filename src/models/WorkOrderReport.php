<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class WorkOrderReport extends Eloquent {
    
    protected $table = 'work_order_reports';
    
    protected $fillable = array('user_id', 'work_order_id', 'description');
    
    public function user(){
        return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
    }
    
    public function workOrder(){
        return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrder', 'id', 'work_order_id');
    }
    
}