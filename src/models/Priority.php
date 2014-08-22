<?php namespace Stevebauman\Maintenance\Models;

class Priority extends \Elouent {
	
	protected $table = 'priorities';
	
	public function workOrders(){
		return $this->hasMany('Stevebauman\Maintenance\Models\WorkOrder', 'priority_id');
	}
}