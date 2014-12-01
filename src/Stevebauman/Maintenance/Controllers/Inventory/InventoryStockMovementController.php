<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Services\InventoryStockService;
use Stevebauman\Maintenance\Services\InventoryStockMovementService;
use Stevebauman\Maintenance\Controllers\BaseController;

class InventoryStockMovementController extends BaseController {
        
        public function __construct(InventoryService $inventory, InventoryStockService $inventoryStock, InventoryStockMovementService $inventoryStockMovement){
            $this->inventory = $inventory;
            $this->inventoryStock = $inventoryStock;
            $this->inventoryStockMovement = $inventoryStockMovement;
        }
        
        /**
         * Dispalys all the stock movement entries for the specified stock for the 
         * specified inventory
         * 
         * @param type $inventory_id
         * @param type $stock_id
         * @return type
         */
        public function index($inventory_id, $stock_id){
            
            $item = $this->inventory->find($inventory_id);
            $stock = $this->inventoryStock->find($stock_id);
            
            $data = $this->inputAll();
            $data['stock_id'] = $stock->id;
            
            $movements = $this->inventoryStockMovement->setInput($data)->getByPageWithFilter();

            return $this->view('maintenance::inventory.stocks.movements.index', array(
                'title' => "Viewing Stock Movements for Item: $item->name in Location: ".renderNode($stock->location),
                'item' => $item,
                'stock' => $stock,
                'movements' => $movements
            ));
            
	}
        
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($inventory_id, $stock_id, $movement_id){
            
	}


}
