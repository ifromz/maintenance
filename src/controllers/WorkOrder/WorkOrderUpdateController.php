<?php namespace Stevebauman\Maintenance\Controllers;

use Illuminate\Support\Facades\Response;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Services\UpdateService;
use Stevebauman\Maintenance\Validators\UpdateValidator;
use Stevebauman\Maintenance\Controllers\AbstractController;

class WorkOrderUpdateController extends AbstractController {
	
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
            
            $validator = new $this->updateValidator;
            
            if($validator->passes()){
		
                if($workOrder = $this->workOrder->find($workOrder_id)){
			
                        $update = $this->update->create($this->inputAll());

                        $workOrder->customerUpdates()->save($update);
                        
                        return Response::json(array(
                                'updateCreated' => true,
                                'message' => 'Successfully added update',
                                'messageType' => 'success',
                                'html' => $this->view('maintenance::partials.update', array(
                                    'update' => $update,
                                    'workOrder' => $workOrder
                                ))
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
            $workOrder = $this->workOrder->find($workOrder_id);
            $update = $this->update->find($update_id);
                            
            if($update->delete()){
                $this->message = 'Successfully deleted update';
                $this->messageType = 'success';
            } else{
                $this->message = 'There was an error trying to delete this update, please try again.';
                $this->messageType = 'danger';
            }

            $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));

            return $this->response();
	}


}
