<?php

namespace Stevebauman\Maintenance\Validators;

use Illuminate\Support\Facades\Route;
use Stevebauman\Maintenance\Services\Inventory\StockService;

class WorkOrderPartStockQuantityValidator {
    
    public function __construct(StockService $inventoryStock){
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