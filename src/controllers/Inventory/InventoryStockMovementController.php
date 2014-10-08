<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Services\InventoryStockService;
use Stevebauman\Maintenance\Services\InventoryStockMovementService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class InventoryStockMovementController extends AbstractController {
        
        public function __construct(InventoryService $inventory, InventoryStockService $inventoryStock, InventoryStockMovementService $inventoryStockMovement){
            $this->inventory = $inventory;
            $this->inventoryStock = $inventoryStock;
            $this->inventoryStockMovement = $inventoryStockMovement;
        }
        
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
