<?php namespace Stevebauman\Maintenance\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Inventory extends Eloquent {
	
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
        
        public function getDescriptionShortAttribute(){
            return str_limit(strip_tags($this->attributes['description']), 30);
        }
        
        public function getCurrentStockAttribute(){
            if($this->stocks->count() > 0){
                return $this->stocks->sum('quantity');
            } return 0;
        }
}