<?php namespace Stevebauman\Maintenance\Controllers;

use View;
use Input;
use Response;
use Redirect;
use Request;
use HTML;
use Stevebauman\Maintenance\Controllers\BaseController;
use Stevebauman\Maintenance\Requests\WorkOrderRequest;
use Stevebauman\Maintenance\Services\WorkOrderCategoryService;
use Stevebauman\Maintenance\Services\StatusService;
use Stevebauman\Maintenance\Validators\WorkOrderValidator;

class WorkOrderController extends BaseController {
	
	public function __construct(
			WorkOrderRequest $workOrder,
			WorkOrderCategoryService $category, 
			StatusService $status, 
			WorkOrderValidator $workOrderValidator
		){
		$this->workOrder = $workOrder;
		$this->category = $category;
		$this->status = $status;
		$this->workOrderValidator = $workOrderValidator;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
            return $this->workOrder->index(Input::all());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
            return $this->workOrder->create();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
            return $this->workOrder->store(Input::all());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
            return $this->workOrder->show($id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
            return $this->workOrder->edit($id);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
            return $this->workOrder->update($id, Input::all());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
            return $this->workOrder->destroy($id);
	}

}
