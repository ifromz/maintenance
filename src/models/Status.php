<?php namespace Stevebauman\Maintenance\Models;

class Status extends \Eloquent {
	
	protected $table = 'statuses';
	
	protected $fillable = array('user_id', 'name', 'color');
	
	public function workOrders(){
		return $this->hasMany('Stevebauman\Maintenance\Models\WorkOrder', 'status_id');
	}
}