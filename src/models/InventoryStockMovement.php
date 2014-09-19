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
        
        public function getChangeAttribute(){
            if($this->before > $this->after){
                return $this->before - $this->after;
            } else{
                return $this->after - $this->before;
            }
        }
        
}