<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder\Update;

use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Services\UpdateService;
use Stevebauman\Maintenance\Validators\UpdateValidator;
use Stevebauman\Maintenance\Controllers\BaseController;

abstract class AbstractUpdateController extends BaseController {
    
    public function __construct(WorkOrderService $workOrder, UpdateService $update, UpdateValidator $updateValidator)
    {
        $this->workOrder = $workOrder;
        $this->update = $update;
        $this->updateValidator = $updateValidator;
    }
    
    /**
     * Destroys the specified work order customer update
     * 
     * @param int $workOrder_id
     * @return mixed
     */
    public function delete($workOrder_id, $update_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);
        $update = $this->update->find($update_id);

        if($update->delete()){
            $this->message = 'Successfully deleted update';
            $this->messageType = 'success';
        } else{
            $this->message = 'There was an error trying to delete this update, please try again.';
            $this->messageType = 'danger';
        }

        $this->redirect = routeBack('maintenance.work-orders.show', array($workOrder->id));

        return $this->response();
    }
    
}