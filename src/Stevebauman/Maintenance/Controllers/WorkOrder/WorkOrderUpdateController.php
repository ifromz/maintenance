<?php namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Services\UpdateService;
use Stevebauman\Maintenance\Validators\UpdateValidator;
use Stevebauman\Maintenance\Controllers\BaseController;

class WorkOrderUpdateController extends BaseController {
	
	public function __construct(WorkOrderService $workOrder, UpdateService $update, UpdateValidator $updateValidator){
		$this->workOrder = $workOrder;
		$this->update = $update;
		$this->updateValidator = $updateValidator;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($workOrder_id){
            
            if($this->updateValidator->passes()){
		
                $workOrder = $this->workOrder->find($workOrder_id);
			
                $update = $this->update->setInput($this->inputAll())->create();

                $this->workOrder->saveCustomerUpdate($workOrder, $update);

                $this->message = 'Successfully added update';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));
                
            } else{
                $this->errors = $this->updateValidator->getErrors();
                $this->redirect = route('maintenance.work-orders.show', array($workOrder_id));
            }
            
            return $this->response();
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
