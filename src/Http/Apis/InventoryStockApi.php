<?php namespace Stevebauman\Maintenance\Http\Apis;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;
use Stevebauman\Maintenance\Services\InventoryStockService;
use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Http\Requests\InventoryStockRequest;
use Stevebauman\Maintenance\Http\Apis\BaseApiController;

class InventoryStockApi extends BaseApiController {
    
    public function __construct(InventoryService $inventory, InventoryStockService $inventoryStock, InventoryStockRequest $inventoryStockRequest) {
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
        $this->inventoryStockRequest = $inventoryStockRequest;
    }
    
    public function edit($inventory_id, $stock_id){
        try{
            
            $item = $this->inventory->find($inventory_id);
            
            try{
                
                $stock = $this->inventoryStock->find($stock_id);
                
                return Response::json(array(
                    'html' => View::make('maintenance::inventory.modals.stocks.edit', array(
                            'item' => $item,
                            'stock' => $stock,
                        ))->render(),
                ));
                
            } catch (RecordNotFoundException $e) {
                return $this->inventoryStockRequest->inventoryStockNotFound();
            }
            
        } catch (RecordNotFoundException $e) {
            return $this->inventoryStockRequest->inventoryNotFound();
        }
    }
    
    public function update($inventory_id, $stock_id){
        return $this->inventoryStockRequest->update($inventory_id, $stock_id, Input::all());
    }
    
    
}