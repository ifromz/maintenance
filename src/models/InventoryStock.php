<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class InventoryStock extends BaseModel {
	
	protected $table = 'inventory_stocks';
	
        protected $fillable = array('inventory_id', 'location_id', 'quantity');
        
        public function location(){
            return $this->hasOne('Stevebauman\Maintenance\Models\Location', 'id', 'location_id');
        }
        
        public function movements(){
            return $this->hasMany('Stevebauman\Maintenance\Models\InventoryStockMovement', 'stock_id')->orderBy('created_at', 'DESC');
        }
        
        
        public function getLastMovementAttribute(){
            if($this->movements->count() > 0){
                
                $movement = $this->movements->first();
                
                if($movement->after > $movement->before){
                    return sprintf('%s were added (%s) - <b>Reason:</b> %s', $movement->change, $movement->created_at, $movement->reason);
                } else{
                    return sprintf('%s were removed (%s) - <b>Reason:</b> %s', $movement->change, $movement->created_at, $movement->reason);
                }
                
            } return NULL;
        }
        
        public function getLastMovementByAttribute(){
            if($this->movements->count() > 0){
                
                $movement = $this->movements->first();
                
                if($movement->user){
                   return $movement->user->full_name; 
                } else{
                    return NULL;
                }
                
            } return NULL;
        }
}