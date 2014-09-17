<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class WorkOrderSession extends Eloquent {
	
        protected $table = 'work_order_sessions';
        
        protected $fillable = array('user_id', 'work_order_id', 'in', 'out', 'hours');
        
        public function workOrder(){
            return $this->hasOne('Stevebauman\Maintenanace\Models\WorkOrder', 'work_order_id');
        }
        
        public function user(){
            return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
        }
        
        public function getHoursAttribute(){
            if($this->attributes['out']){
                $hours = abs(round((strtotime($this->attributes['in']) - strtotime($this->attributes['out']))/3600, 2));
                
                return $hours;
            } return NULL;
        }
}