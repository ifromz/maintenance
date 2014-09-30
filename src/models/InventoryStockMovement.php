<?php namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class InventoryStockMovement extends BaseModel {
	
	protected $table = 'inventory_stock_movements';
	
        protected $fillable = array(
            'stock_id', 
            'user_id',
            'before',
            'after',
            'cost',
            'reason',
        );
        
        public function user(){
		return $this->hasOne('Stevebauman\Maintenance\Models\User', 'id', 'user_id');
	}
        
        public function getCostAttribute($cost){
            if($cost == NULL){
                return '0.00';
            } return $cost;
        }
        
        public function getChangeAttribute(){
            if($this->before > $this->after){
                return sprintf('- %s', $this->before - $this->after);
            } else{
                return sprintf('+ %s', $this->after - $this->before);
            }
        }
        
}