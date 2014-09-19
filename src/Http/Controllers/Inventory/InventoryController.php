<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Http\Requests\InventoryRequest;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

class InventoryController extends BaseController {
        
        public function __construct(InventoryRequest $inventory){
            $this->inventory = $inventory;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
            return $this->inventory->index(Input::all());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
            return $this->inventory->create();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
            return $this->inventory->store(Input::all());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
            return $this->inventory->show($id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
            return $this->inventory->edit($id);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
            return $this->inventory->update($id, Input::all());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
            return $this->inventory->destroy($id);
	}


}
