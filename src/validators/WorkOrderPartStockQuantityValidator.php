<?php

namespace Stevebauman\Maintenance\Validators;

use Illuminate\Support\Facades\Route;
use Stevebauman\Maintenance\Services\InventoryStockService;

class WorkOrderPartStockQuantityValidator {
    
    public function __construct(InventoryStockService $inventoryStock){
        $this->inventoryStock = $inventoryStock;
    }
    
    public function validateEnoughQuantity($attribute, $quantity, $parameters){
        if(is_numeric($quantity)){
            $stock_id = Route::getCurrentRoute()->getParameter('stocks');

            $stock = $this->inventoryStock->find($stock_id);

            if($quantity > $stock->quantity){
                return false;
            } else{
                return true;
            }
        }
        
        return false;
    }
    
}