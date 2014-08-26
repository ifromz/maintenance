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
            return $this->workOrder->index();
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
		if($workOrder = $this->workOrder->find($id)){
			$statuses = $this->status->dropdown();
			
			$dateFormat = 'Y/m/d';
			$timeFormat = 'H:i A';
			
			$dates = array(
				'started'=>array(
					'date'=>($workOrder->started_at ? date($dateFormat, strtotime($workOrder->started_at)) : NULL),
					'time'=>($workOrder->started_at ? date($timeFormat, strtotime($workOrder->started_at)) : NULL),
				),
				'completed'=>array(
					'date'=>($workOrder->completed_at ? date($dateFormat, strtotime($workOrder->completed_at)) : NULL),
					'time'=>($workOrder->completed_at ? date($timeFormat, strtotime($workOrder->completed_at)) : NULL),
				),
			);
			
			$this->layout = View::make('maintenance::work-orders.edit')
				->with(compact('workOrder'))
				->with(compact('statuses'))
				->with(compact('dates'));
			$this->layout->title = 'Editing Work Order: ' . $workOrder->subject;
		} else {
			
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
		$validator = new $this->workOrderValidator;
		
		if($validator->passes()){
			$data = Input::all();
			
			$this->workOrder->update($id, $data);
			
			if(Request::ajax()){
				return Response::json(array(
					'workOrderEdited' => true,
					'message' => sprintf('Successfully edited work order. %s', HTML::link(route('maintenance.work-orders.show', array($id)), 'Show')),
					'messageType' => 'success',
				));
			}
		} else{
			if(Request::ajax()){
				return Response::json(array(
					'workOrderEdited' => false,
					'errors' => $validator->getJsonErrors(),
				));
			}
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
		if($this->workOrder->destroy($id)){
			if(Request::ajax()){
				return Response::json(array(
					'workOrderDeleted' => true,
					'message' => 'Successfully deleted work order',
					'messageType' => 'success'
				));
			} else{
				return Redirect::route('maintenance.work-orders.index')
					->with('message', 'Successfully deleted work order')
					->with('messageType', 'success');
			}
		}
	}
	
	
	public function getWorkOrdersBySlug($location, $hierarchy = NULL){
		if($location = $this->location->getLocationBySlug($location)){
			
			$categories = explode('/', $hierarchy);
			
			if($category = $this->category->getCategoryBySlugAndLocationId($location->id)){
				$workOrders = $this->workOrder->getByPageWithCategoryId($category->id);
				
				$this->layout = View::make('maintenance::work-orders.index', compact('workOrders'));
				$this->layout->title = sprintf('Work Orders <small>%s</small>', renderNode($category));
			} else{
			}
		}
	}


}
