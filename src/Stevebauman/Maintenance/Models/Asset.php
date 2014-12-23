<?php namespace  Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Stevebauman\Maintenance\Traits\EventableTrait;
use Stevebauman\Maintenance\Models\BaseModel;

class Asset extends BaseModel {
    
	use SoftDeletingTrait;
        use EventableTrait;
        
	protected $table = 'assets';
	
        protected $viewer = 'Stevebauman\Maintenance\Viewers\AssetViewer';
        
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
		'price',
                'aquired_at',
                'end_of_life',
	);
        
        protected $revisionFormattedFieldNames = array(
            'location_id'   => 'Location',
            'asset_category_id'   => 'Category',
            'name'          => 'Name',
            'condition'     => 'Condition',
            'size'          => 'Size',
            'weight'        => 'Weight',
            'vendor'        => 'Vendor',
            'make'          => 'Make',
            'model'         => 'Model',
            'serial'        => 'Serial',
            'price'         => 'Price',
            'aquired_at'    => 'Aquired At',
            'end_of_life'   => 'End of Life',
        );
        
        public function user()
        {
            return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
        }
        
        public function location()
        {
            return $this->hasOne('Stevebauman\Maintenance\Models\Location', 'id', 'location_id');
        }
	
	public function category()
        {
            return $this->hasOne('Stevebauman\Maintenance\Models\AssetCategory', 'id', 'asset_category_id');
	}
	
	public function images()
        {
            return $this->belongsToMany('Stevebauman\Maintenance\Models\Attachment', 'asset_images', 'asset_id', 'attachment_id');
	}
        
        public function manuals()
        {
            return $this->belongsToMany('Stevebauman\Maintenance\Models\Attachment', 'asset_manuals', 'asset_id', 'attachment_id');
	}
        
        public function workOrders()
        {
            return $this->belongsToMany('Stevebauman\Maintenance\Models\WorkOrder', 'work_order_assets', 'asset_id', 'work_order_id')->withTimestamps();
        }
        
        public function meters(){
            return $this->belongsToMany('Stevebauman\Maintenance\Models\Meter', 'asset_meters', 'asset_id', 'meter_id')->withTimestamps();
        }
        
        /*
         * Filters query by the inputted asset name
         */
        public function scopeName($query, $name = NULL)
        {
            if($name){
                return $query->where('name', 'LIKE', '%'.$name.'%');
            }
        }
        
        /*
         * Filters query by the inputted asset condition
         */
        public function scopeCondition($query, $condition = NULL)
        {
            if($condition){
                return $query->where('condition', 'LIKE', '%'.$condition.'%');
            }
        }
        
        /*
         * Filters query by the inputted asset category
         */
        public function scopeCategory($query, $category = NULL)
        {
            if($category){
                $query->whereHas('category', function($query) use($category){
                    return $query->where('id', $category);
                });
            }
        }
        
        /*
         * Filters query by the inputted asset location
         */
        public function scopeLocation($query, $location = NULL)
        {
            if($location){
                $query->whereHas('location', function($query) use($location){
                    return $query->where('name', 'LIKE', '%'.$location.'%');
                });
            }
        }
        
        /*
         * Mutator for conversion of integer condition, to text condition through
         * translator
         */
	public function getConditionAttribute($attr)
        {
            return trans(sprintf('maintenance::assets.conditions.%s',$attr));
	}
        
        public function getConditionNumberAttribute()
        {
            return $this->attributes['condition'];
        }
        
        /*
         * Mutator for displaying a pretty link label for display in work orders
         */
        public function getLabelAttribute()
        {
            return sprintf(
                    '<a href="%s" class="label label-primary">%s</span></a>', 
                    route('maintenance.assets.show', array($this->attributes['id'])), 
                    $this->attributes['name']
                );
        }
        
        
}