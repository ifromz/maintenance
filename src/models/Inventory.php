<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Stevebauman\Maintenance\Models\BaseModel;

class Inventory extends BaseModel {
    
	use SoftDeletingTrait;
        
	protected $table = 'inventories';
	
        protected $fillable = array('user_id', 'metric_id', 'category_id', 'name', 'description');
        
        public function metric()
        {
            return $this->hasOne('Stevebauman\Maintenance\Models\Metric', 'id', 'metric_id');
        }
        
        public function stocks()
        {
            return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStock', 'inventory_id')->orderBy('quantity', 'DESC');
        }
        
        public function user()
        {
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
        
        public function category()
        {
		return $this->hasOne('Stevebauman\Maintenance\Models\Category', 'id', 'category_id');
	}
        
        /*
         * Filters query by the inputted inventory item name
         */
        public function scopeName($query, $name = NULL)
        {
            if($name){
                return $query->where('name', 'LIKE', '%'.$name.'%');
            }
        }
        
        /*
         * Filters query by the inputted inventory item description
         */
        public function scopeDescription($query, $description = NULL)
        {
            if($description){
                return $query->where('description', 'LIKE', '%'.$description.'%');
            }
        }
        
        /*
         * Filters query by the inputted inventory item stock quantity
         */
        public function scopeStock($query, $operator = NULL, $stock = NULL)
        {
            if($operator && $stock){
                //dd($operator);
                return $query->whereHas('stocks', function($query) use ($operator, $stock){
                    
                    if($output = $this->getOperator($operator)){
                        
                        return $query->where('quantity', $output[0], $stock); 
                    } else{
                        return $query;
                    }
                   
                });
            }
        }
        
        /*
         * Filters query by the inputted inventory item category
         */
        public function scopeCategory($query, $category = NULL)
        {
            if($category){
                $query->whereHas('category', function($query) use($category){
                    return $query->where('name', 'LIKE', '%'.$category.'%');
                });
            }
        }
        
        /*
         * Filters query by the inputted inventory item location
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
         * Mutator for showing a limited description for display in tables
         */
        public function getDescriptionShortAttribute()
        {
            return str_limit(strip_tags($this->attributes['description']), 30);
        }
        
        /*
         * Mutator for showing the total current stock of the inventory item
         */
        public function getCurrentStockAttribute()
        {
            if($this->stocks->count() > 0){
                return $this->stocks->sum('quantity');
            } return 0;
        }
}