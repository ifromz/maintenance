<?php namespace Stevebauman\Maintenance\Models;

class WorkOrder extends \Eloquent {
	
	protected $table = 'work_orders';
	
	protected $fillable = array('user_id', 'location_id', 'category_id', 'status_id', 'subject', 'description', 'started_at', 'completed_at', 'hours');
	
	public function status(){
		return $this->hasOne('Stevebauman\Maintenance\Models\Status', 'id', 'status_id');
	}
	
	public function updates(){
		return $this->hasMany('Stevebauman\Maintenance\Models\Update', 'work_order_id');
	}

	public function category(){
		return $this->hasOne('Stevebauman\Maintenance\Models\Category', 'id', 'category_id');
	}
	
	public function user(){
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
}