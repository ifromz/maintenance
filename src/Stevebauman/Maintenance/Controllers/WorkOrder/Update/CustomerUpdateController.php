<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder\Update;

use Stevebauman\Maintenance\Controllers\WorkOrder\Update\AbstractUpdateController;

class CustomerUpdateController extends AbstractUpdateController
{

    /**
     * Creates a new work order customer update
     *
     * @param int $workOrder_id
     * @return mixed
     */
    public function store($workOrder_id)
    {
        if ($this->updateValidator->passes()) {

            $workOrder = $this->workOrder->find($workOrder_id);

            $update = $this->update->setInput($this->inputAll())->create();

            $this->workOrder->saveCustomerUpdate($workOrder, $update);

            $this->message = 'Successfully added update';
            $this->messageType = 'success';
            $this->redirect = routeBack('maintenance.work-orders.show', array($workOrder->id));

        } else {
            $this->errors = $this->updateValidator->getErrors();
            $this->redirect = routeBack('maintenance.work-orders.show', array($workOrder_id));
        }

        return $this->response();
    }

}