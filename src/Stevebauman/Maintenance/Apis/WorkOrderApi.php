<?php namespace Stevebauman\Maintenance\Apis;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Apis\BaseApiController;

class WorkOrderApi extends BaseApiController {
	
	public function __construct(WorkOrderService $workOrder){
		$this->workOrder = $workOrder;
	}
	
	public function get(){
		$records = $this->workOrder->get();
		
		return Response::json($records);
	}
	
	public function find($id){
		$record = $this->workOrder->find($id);
		
		return Response::json($record);
	}
	
	public function getMakes(){
		$records = $this->workOrder->getMakes(Input::get('query'));
		
		return Response::json($records->lists('make'));
	}
	
	public function getModels(){
		$records = $this->workOrder->getModels(Input::get('query'));
		
		return Response::json($records->lists('model'));
	}
	
	public function getSerials(){
		$records = $this->workOrder->getSerials(Input::get('query'));
		
		return Response::json($records->lists('serial'));
	}

}