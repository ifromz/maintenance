<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Http\Requests\InventoryStockRequest;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

class InventoryStockController extends BaseController {
        
        public function __construct(InventoryStockRequest $inventoryStock){
            $this->inventoryStock = $inventoryStock;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($inventory_id){
            return $this->inventoryStock->index($inventory_id);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($inventory_id){
            return $this->inventoryStock->create($inventory_id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($inventory_id){
            return $this->inventoryStock->store($inventory_id, Input::all());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($inventory_id, $stock_id){
            return $this->inventoryStock->show($inventory_id, $stock_id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($inventory_id, $stock_id){
            return $this->inventoryStock->edit($inventory_id, $stock_id);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($inventory_id, $stock_id){
            return $this->inventoryStock->update($inventory_id, $stock_id, Input::all());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($inventory_id, $stock_id){
            return $this->inventoryStock->destroy($inventory_id, $stock_id);
	}


}
