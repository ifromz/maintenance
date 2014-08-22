<?php namespace Stevebauman\Maintenance\Models;

class Update extends \Eloquent {
	
	protected $table = 'updates';
	
	protected $fillable = array('user_id', 'work_order_id', 'content');
	
	public function user(){
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
	
	public function workOrder(){
		return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrder', 'id', 'work_order_id');
	}
}