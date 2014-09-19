<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Services\InventoryStockService;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Validator;

class InventoryStockLocationValidator extends Validator {
    
    public function __construct($translator, $data, $rules, $messages, InventoryStockService $inventoryStock) {
        $this->translator = $translator;
        $this->data = $data;
        $this->rules = $this->explodeRules($rules);
        $this->messages = $messages;
        
        $this->inventoryStock = $inventoryStock;
        
    }
    
     public function validateStockLocation($attribute, $location_id, $parameters){
         $item_id = Route::getCurrentRoute()->getParameter('inventory');
         $stock_id = Route::getCurrentRoute()->getParameter('stocks');
         
         if(isset($stock_id)){
             $stocks = $this->inventoryStock->where('inventory_id', $item_id)->where('id', '!=', $stock_id)->where('location_id', $location_id)->get();
         } else{
             $stocks = $this->inventoryStock->where('inventory_id', $item_id)->where('location_id', $location_id)->get();
         }
         
         if($stocks->count() > 0){
             return false;
         } return true;
     }
     
     protected function replaceStockLocation($message, $attribute, $rule, $parameters){
        return 'This location already has a stock entry for this item.';
    }
    
}