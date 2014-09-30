<?php namespace Stevebauman\Maintenance\Http\Requests;

use Stevebauman\Maintenance\Validators\InventoryValidator;
use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Http\Requests\AbstractRequest;

class InventoryRequest extends AbstractRequest {
        
        public function __construct(InventoryService $inventory, InventoryValidator $inventoryValidator) {
            $this->inventory = $inventory;
            $this->inventoryValidator = $inventoryValidator;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($data){
            
            $items = $this->inventory->getByPageWithFilter($data);
            
            return $this->view('maintenance::inventory.index', array(
                'title' => 'Inventory',
                'items' => $items,
            ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
            return $this->view('maintenance::inventory.create', array(
                'title' => 'Add an Item to the Inventory',
            ));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($data){
            $validator = new $this->inventoryValidator;
            
            if($validator->passes()){
                
                if($record = $this->inventory->create($data)){
                    $this->message = sprintf('Successfully added item to the inventory: %s', link_to_route('maintenance.inventory.show', 'Show', array($record->id)));
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.inventory.index');
                } else{
                    $this->message = 'There was an error adding this item to the inventory. Please try again.';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.inventory.index');
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
	public function show($id){
            $item = $this->inventory->find($id);

            return $this->view('maintenance::inventory.show', array(
                'title' => 'Viewing Inventory Item: '.$item->name,
                'item' => $item,
            ));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
            $item = $this->inventory->find($id);

            return $this->view('maintenance::inventory.edit', array(
                'title' => 'Editing Inventory Item: '.$item->name,
                'item' => $item,
            ));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, $data){
            $validator = new $this->inventoryValidator;
            
            if($validator->passes()){

                if($item = $this->inventory->update($id, $data)){

                    $this->message = sprintf('Successfully updated item: %s', link_to_route('maintenance.inventory.show', 'Show', array($item->id)));
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.inventory.show', array($item->id));
                } else{
                    $this->message = 'There was an error trying to update this item. Please try again.';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.inventory.edit', array($item->id));
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
	public function destroy($id){
            $this->inventory->destroy($id);

            $this->redirect = route('maintenance.inventory.index');
            $this->message = 'Successfully deleted item';
            $this->messageType = 'success';

            return $this->response();
	}
}
