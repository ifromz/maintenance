<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class Inventory extends BaseModel {
	
	protected $table = 'inventories';
	
        protected $fillable = array('user_id', 'category_id', 'name', 'description');
        
        public function stocks(){
            return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStock', 'inventory_id')->orderBy('quantity', 'DESC');
        }
        
        public function user(){
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
        
        public function category(){
		return $this->hasOne('Stevebauman\Maintenance\Models\Category', 'id', 'category_id');
	}
        
        public function scopeName($query, $name = NULL){
            if($name){
                return $query->where('name', 'LIKE', '%'.$name.'%');
            }
        }
        
        public function scopeDescription($query, $description = NULL){
            if($description){
                return $query->where('description', 'LIKE', '%'.$description.'%');
            }
        }
        
        public function scopeStock($query, $operator = NULL, $stock = NULL){
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
        
        public function scopeLocation($query, $location_id = NULL){
            if($location_id){
                return $query->whereHas('stocks', function($query) use($location_id){
                    return $query->where('location_id', $location_id);
                });
            }
        }
        
        public function getDescriptionShortAttribute(){
            return str_limit(strip_tags($this->attributes['description']), 30);
        }
        
        public function getCurrentStockAttribute(){
            if($this->stocks->count() > 0){
                return $this->stocks->sum('quantity');
            } return 0;
        }
}