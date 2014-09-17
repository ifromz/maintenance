<?php namespace Stevebauman\Maintenance\Http\Controllers;

use View;
use Input;
use Response;
use Request;
use Redirect;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Services\UpdateService;
use Stevebauman\Maintenance\Validators\UpdateValidator;

class WorkOrderUpdateController extends \BaseController {
	
	public function __construct(WorkOrderService $workOrder, UpdateService $update, UpdateValidator $updateValidator){
		$this->workOrder = $workOrder;
		$this->update = $update;
		$this->updateValidator = $updateValidator;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($workOrder_id){
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($workOrder_id){
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($workOrder_id){
		if($workOrder = $this->workOrder->find($workOrder_id)){
			$validator = new $this->updateValidator;
			
			if($validator->passes()){
                                    
				$update = $this->update->create(array(
                                    'content' => Input::get('update_content')
                                ));
				
                                $workOrder->customerUpdates()->save($update);
                                
				return Response::json(array(
					'updateCreated' => true,
					'message' => 'Successfully added update',
					'messageType' => 'success',
					'html' => View::make('maintenance::partials.update', compact('update'), compact('workOrder'))->render()
				));
			} else{
				return Response::json(array(
					'updateCreated' => false,
					'errors' => $validator->getJsonErrors(),
				));
			}
		}
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
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($workOrder_id, $update_id){
		if($workOrder = $this->workOrder->find($workOrder_id)){
			if($update = $this->update->find($update_id)){
				$update->delete();
				
				if(Request::ajax()){
					return Response::json(array(
						'updateDeleted' => true,
						'message' => 'Successfully deleted update',
						'messageType' => 'success'
					));
				} else{
					return Redirect::route('maintenance.work-orders.show', array($workOrder->id))
						->with('message', 'Successfully deleted message')
						->with('messageType', 'success');
				}
			}
		} else{
			
		}
	}


}
