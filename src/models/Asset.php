<?php namespace  Stevebauman\Maintenance\Models;

class Asset extends \Eloquent {
	
	protected $table = 'assets';
	
	protected $fillable = array(
		'user_id',
		'location_id', 
		'asset_category_id', 
		'name', 
		'condition', 
		'size', 
		'weight', 
		'vendor', 
		'make', 
		'model', 
		'serial', 
		'price'
	);
	
	public function category(){
		return $this->hasOne('Stevebauman\Maintenance\Models\AssetCategory', 'id', 'asset_category_id');
	}
	
	public function images(){
		return $this->belongsToMany('Stevebauman\Maintenance\Models\Attachment', 'asset_images', 'asset_id', 'attachment_id');
	}
        
        public function workOrders(){
            return $this->belongsToMany('Stevebauman\Maintenance\Models\WorkOrder', 'work_order_assets', 'asset_id', 'work_order_id')->withTimestamps();
        }
        
	public function getConditionAttribute($attr){
		return trans(sprintf('maintenance::assets.conditions.%s',$attr));
	}
	
}