<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\InventoryStockValidator;
use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Services\InventoryStockService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class InventoryStockController extends AbstractController {
    
        public function __construct(InventoryService $inventory, InventoryStockService $inventoryStock, InventoryStockValidator $inventoryStockValidator){
            $this->inventory = $inventory;
            $this->inventoryStock = $inventoryStock;
            $this->inventoryStockValidator = $inventoryStockValidator;
        }
        
        public function index($inventory_id){
            $item = $this->inventory->find($inventory_id);

            return $this->view('maintenance::inventory.stocks.index', array(
                'title' => 'Current Stocks for Item: '.$item->name,
                'item' => $item,
            ));
        }
        
	/**
	 * Show the form for creating a new resource.
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($inventory_id){
            $validator = new $this->inventoryStockValidator;
            
            if($validator->passes()){
                
                $item = $this->inventory->find($inventory_id);
                
                $data = $this->inputAll();
                $data['inventory_id'] = $item->id;
                
                if($record = $this->inventoryStock->setInput($data)->create()){
                    $this->message = 'Successfully added stock to this item';
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.inventory.show', array($item->id));

                } else{

                    $this->message = 'There was an error trying to add stock to this item. Please try again.';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.inventory.show', array($item->id));

                }
                
            } else{
                $this->errors = $validator->getErrors();
            }
            
            return $this->response();
	}


	/**
	 * Display the specified resource.
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
	 * Show the form for editing the specified resource.
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($inventory_id, $stock_id){
            $validator = new $this->inventoryStockValidator;
            
            if($validator->passes()){
                
                    $item = $this->inventory->find($inventory_id);
                    
                    if($record = $this->inventoryStock->setInput($this->inputAll())->update($stock_id)){
                        $this->message = 'Successfully updated stock for item: '.$item->name;
                        $this->messageType = 'success';
                        $this->redirect = route('maintenance.inventory.show', array($item->id));
                    } else{
                        $this->message = 'There was an error trying to update the stock for this item. Please try again.';
                        $this->messageType = 'danger';
                        $this->redirect = route('maintenance.inventory.stock.edit', array($item->id, $stock_id));
                    }
                
            } else{
                $this->errors = $validator->getErrors();
            }
            
            return $this->response();
	}


	/**
	 * Remove the specified resource from storage.
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
