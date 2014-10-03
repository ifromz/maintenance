<?php namespace Stevebauman\Maintenance\Http\Apis;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Stevebauman\Maintenance\Services\InventoryStockService;
use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Http\Apis\BaseApiController;

class InventoryStockApi extends BaseApiController {
    
    public function __construct(InventoryService $inventory, InventoryStockService $inventoryStock) {
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
    }
    
    public function edit($inventory_id, $stock_id){
            
        $item = $this->inventory->find($inventory_id);
                
        $stock = $this->inventoryStock->find($stock_id);

        return Response::json(array(
            'html' => View::make('maintenance::inventory.modals.stocks.edit', array(
                    'item' => $item,
                    'stock' => $stock,
                ))->render(),
        ));
    }
    
    public function update($inventory_id, $stock_id){
        return $this->inventoryStockRequest->update($stock_id);
    }
    
    
}