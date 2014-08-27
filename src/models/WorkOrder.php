<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class WorkOrder extends Eloquent {
	
	protected $table = 'work_orders';
	
	protected $fillable = array(
            'user_id', 
            'location_id', 
            'work_order_category_id', 
            'status_id', 
            'priority', 
            'subject', 
            'description', 
            'started_at', 
            'completed_at', 
            'hours'
        );
	
	public function status(){
		return $this->hasOne('Stevebauman\Maintenance\Models\Status', 'id', 'status_id');
	}
	
	public function updates(){
		return $this->hasMany('Stevebauman\Maintenance\Models\Update', 'work_order_id');
	}
        
        public function location(){
            return $this->hasOne('Stevebauman\Maintenance\Models\Location', 'id', 'location_id');
        }

	public function category(){
		return $this->hasOne('Stevebauman\Maintenance\Models\WorkOrderCategory', 'id', 'work_order_category_id');
	}
	
	public function user(){
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
        
        public function assets(){
            return $this->belongsToMany('Stevebauman\Maintenance\Models\Asset', 'work_order_assets', 'work_order_id', 'asset_id')->withTimestamps();
        }
        
        public function scopePriority($query, $priority = NULL){
            if($priority){
                return $query->where('priority', 'LIKE', '%'.$priority.'%');
            }
	}
        
        public function scopeSubject($query, $subject = NULL){
            if($subject){
                return $query->where('subject', 'LIKE', '%'.$subject.'%');
            }
	}
        
        public function scopeDescription($query, $desc = NULL){
            if($desc){
                return $query->where('description', 'LIKE', '%'.$desc.'%');
            }
	}
        
        public function scopeStatus($query, $status = NULL){
            if($status){
                return $query->whereHas('status', function($query) use($status){
                        $query->where('id', $status);
                });
            }
	}
        
        public function scopeCategory($query, $category = NULL){
            if($category){
                return $query->whereHas('category', function($query) use($category){
                        $query->where('id', $category);
                });
            }
	}
        
        public function scopeAssets($query, $assets = NULL){
            if($assets){
                return $query->whereHas('assets', function($query) use($assets){
                        $query->whereIn('asset_id', $assets);
                });
            }
        }
}