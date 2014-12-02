<?php 

namespace Stevebauman\Maintenance\Controllers\Inventory;

use Stevebauman\Maintenance\Validators\InventoryStockValidator;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Services\Inventory\StockService;
use Stevebauman\Maintenance\Controllers\BaseController;

class StockController extends BaseController {
    
        public function __construct(InventoryService $inventory, StockService $inventoryStock, InventoryStockValidator $inventoryStockValidator){
            $this->inventory = $inventory;
            $this->inventoryStock = $inventoryStock;
            $this->inventoryStockValidator = $inventoryStockValidator;
        }
        
        /**
         * Displays all inventory stock entries
         * 
         * @param type $inventory_id
         * @return type
         */
        public function index($inventory_id){
            $item = $this->inventory->find($inventory_id);

            return $this->view('maintenance::inventory.stocks.index', array(
                'title' => 'Current Stocks for Item: '.$item->name,
                'item' => $item,
            ));
        }
        
	/**
	 * Displays the form for creating a new stock entry for the inventory
	 *
	 * @return Response
	 */
	public function create($inventory_id){
            $item = $this->inventory->find($inventory_id);

            return $this->view('maintenance::inventory.stocks.create', array(
                'title' => 'Add Stock Location to: '.$item->name,
                'item' => $item,
            ));
               
	}


	/**
	 * Create a new stock entry for the inventory
	 *
	 * @return Response
	 */
	public function store($inventory_id){
            
            if($this->inventoryStockValidator->passes()){
                
                $item = $this->inventory->find($inventory_id);
                
                $data = $this->inputAll();
                $data['inventory_id'] = $item->id;
                
                $record = $this->inventoryStock->setInput($data)->create();
                
                if($record){
                    $this->message = 'Successfully added stock to this item';
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.inventory.show', array($item->id));

                } else{

                    $this->message = 'There was an error trying to add stock to this item. Please try again.';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.inventory.show', array($item->id));

                }
                
            } else{
                $this->errors = $this->inventoryStockValidator->getErrors();
            }
            
            return $this->response();
	}


	/**
	 * Displays the specified stock entry for the specified inventory
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($inventory_id, $stock_id)
	{
            $item = $this->inventory->find($inventory_id);

            $stock = $this->inventoryStock->find($stock_id);

            return $this->view('maintenance::inventory.stocks.show', array(
                'title' => sprintf('Viewing Stock for item: %s inside Location: %s', $item->name, renderNode($stock->location)),
                'item' => $item,
                'stock' => $stock,
            ));
            
	}


	/**
	 * Displays the edit form for the specified stock for the specified inventory
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($inventory_id, $stock_id){
            
            $item = $this->inventory->find($inventory_id);
            
            $stock = $this->inventoryStock->find($stock_id);

            return $this->view('maintenance::inventory.stocks.edit', array(
                'title' => sprintf('Update Stock for item: %s inside %s', $item->name, $stock->location->name),
                'stock' => $stock,
                'item'=>$item
            ));
	}


	/**
	 * Updates the specified stock for the specified inventory
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($inventory_id, $stock_id){
            
            if($this->inventoryStockValidator->passes()){
                
                    $item = $this->inventory->find($inventory_id);
                    
                    $stock = $this->inventoryStock->setInput($this->inputAll())->update($stock_id);
                    
                    if($stock){
                        $this->message = 'Successfully updated stock for item: '.$item->name;
                        $this->messageType = 'success';
                        $this->redirect = route('maintenance.inventory.show', array($item->id));
                    } else{
                        $this->message = 'There was an error trying to update the stock for this item. Please try again.';
                        $this->messageType = 'danger';
                        $this->redirect = route('maintenance.inventory.stock.edit', array($item->id, $stock_id));
                    }
                
            } else{
                $this->redirect = route('maintenance.inventory.stock.edit', array($inventory_id, $stock_id));
                $this->errors = $this->inventoryStockValidator->getErrors();
            }
            
            return $this->response();
	}


	/**
	 * Removes the specified stock from the specified inventory
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($inventory_id, $stock_id){
            
            if($this->inventoryStock->destroy($stock_id)){
                $this->message = 'Successfully deleted stock';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.inventory.show', array($inventory_id));
            } else{
                $this->message = 'There was an error trying to delete the stock for this item. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.inventory.show', array($inventory_id));
            }
            
            return $this->response();
	}
}
