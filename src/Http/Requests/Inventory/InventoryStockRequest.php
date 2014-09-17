<?php namespace Stevebauman\Maintenance\Http\Requests;

use Illuminate\Support\Facades\View;
use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;
use Stevebauman\Maintenance\Validators\InventoryStockValidator;
use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Services\InventoryStockService;
use Stevebauman\Maintenance\Http\Requests\AbstractRequest;

class InventoryStockRequest extends AbstractRequest {
    
        public function __construct(InventoryService $inventory, InventoryStockService $inventoryStock, InventoryStockValidator $inventoryStockValidator){
            $this->inventory = $inventory;
            $this->inventoryStock = $inventoryStock;
            $this->inventoryStockValidator = $inventoryStockValidator;
        }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($inventory_id){
            try{
                $item = $this->inventory->find($inventory_id);
                
                return View::make('maintenance::inventory.stocks.create', array(
                    'title' => 'Add Stock Location to: '.$item->name,
                    'item' => $item,
                ));
                
                
            } catch (RecordNotFoundException $e) {
                return $this->inventoryNotFound();
            }
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($inventory_id, $data){
            $validator = new $this->inventoryStockValidator;
            
            if($validator->passes()){
            
                try{
                    $item = $this->inventory->find($inventory_id);

                    $data['inventory_id'] = $item->id;

                    if($record = $this->inventoryStock->create($data)){
                        $this->message = 'Successfully added stock to this item';
                        $this->messageType = 'success';
                        $this->redirect = route('maintenance.inventory.show', array($item->id));

                    } else{

                        $this->message = 'There was an error trying to add stock to this item. Please try again.';
                        $this->messageType = 'danger';
                        $this->redirect = route('maintenance.inventory.show', array($item->id));

                    }

                } catch (RecordNotFoundException $e) {
                    return $this->inventoryNotFound();
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
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($inventory_id, $stock_id){
            try{
                
                $item = $this->inventory->find($inventory_id);
                
                try{
                  
                    $stock = $this->inventoryStock->find($stock_id);
                    
                    return View::make('maintenance::inventory.stocks.edit', array(
                        'title' => sprintf('Update Stock for item: %s inside %s', $item->name, $stock->location->name),
                        'stock' => $stock,
                        'item'=>$item
                    ));
                    
                } catch (RecordNotFoundException $e) {
                    return $this->inventoryStockNotFound($item->id);
                }
                
            } catch (RecordNotFoundException $e) {
                return $this->inventoryNotFound();
            }
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($inventory_id, $stock_id, $data){
            $validator = new $this->inventoryStockValidator;
            
            if($validator->passes()){
                
                try{
                    
                    $item = $this->inventory->find($inventory_id);

                    $data['inventory_id'] = $item->id;
                    
                    if($record = $this->inventoryStock->update($stock_id, $data)){
                        $this->message = 'Successfully updated stock for item: '.$item->name;
                        $this->messageType = 'success';
                        $this->redirect = route('maintenance.inventory.show', array($item->id));
                    } else{
                        $this->message = 'There was an error trying to update the stock for this item. Please try again.';
                        $this->messageType = 'danger';
                        $this->redirect = route('maintenance.inventory.stock.edit', array($item->id, $stock_id));
                    }
                    
                } catch (RecordNotFoundException $e) {
                    return $this->inventoryNotFound();
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
                $this->redirect = route('maintenace.inventory.show', array($inventory_id));
            } else{
                $this->message = 'There was an error trying to delete the stock for this item. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenace.inventory.show', array($inventory_id));
            }
            
            return $this->response();
	}
        
        public function inventoryStockNotFound($inventory_id){
            $this->message = 'Inventory stock record not found; It either does not exist, or has been deleted';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.inventory.show', array($inventory_id));
            
            return $this->response();
        }
        
        public function inventoryNotFound(){
            $this->message = 'Inventory item not found; It either does not exist, or has been deleted';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.inventory.index');
            
            return $this->response();
        }
}
