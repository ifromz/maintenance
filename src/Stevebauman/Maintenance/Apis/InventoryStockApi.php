<?php namespace Stevebauman\Maintenance\Apis;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Stevebauman\Maintenance\Services\Inventory\StockService;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Apis\BaseApiController;

class InventoryStockApi extends BaseApiController {
    
    public function __construct(InventoryService $inventory, StockService $inventoryStock) {
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
        $data = \Input::all();
        $data['inventory_id'] = $inventory_id;
        
        return $this->inventoryStock->setInput($data)->update($stock_id);
    }
    
    
}