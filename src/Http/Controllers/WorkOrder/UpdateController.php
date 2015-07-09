<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Stevebauman\Maintenance\Validators\UpdateValidator;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Services\UpdateService;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class UpdateController extends BaseController
{
    /**
     * @var UpdateService
     */
    protected $update;

    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var UpdateValidator
     */
    protected $updateValidator;

    /**
     * Constructor.
     *
     * @param UpdateService    $update
     * @param WorkOrderService $workOrder
     * @param UpdateValidator  $updateValidator
     */
    public function __construct(UpdateService $update, WorkOrderService $workOrder, UpdateValidator $updateValidator)
    {
        $this->update = $update;
        $this->workOrder = $workOrder;
        $this->updateValidator = $updateValidator;
    }

    /**
     * Creates a new work order customer update.
     *
     * @param string|int $workOrder_id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store($workOrder_id)
    {
        if ($this->updateValidator->passes()) {
            $workOrder = $this->workOrder->find($workOrder_id);

            $update = $this->update->setInput($this->inputAll())->create();

            $this->workOrder->saveUpdate($workOrder, $update);

            $this->message = 'Successfully added update';
            $this->messageType = 'success';
            $this->redirect = routeBack('maintenance.work-orders.show', [$workOrder->id]);
        } else {
            $this->errors = $this->updateValidator->getErrors();
            $this->redirect = routeBack('maintenance.work-orders.show', [$workOrder_id]);
        }

        return $this->response();
    }

    /**
     * Deletes a work order update.
     *
     * @param string|int $workOrderId
     * @param string|int $updateId
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($workOrderId, $updateId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        if ($this->update->destroy($updateId)) {
            $this->message = 'Successfully deleted update';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.show', [$workOrder->id, '#tab_updates']);
        } else {
            $this->message = 'There was an error trying to delete this update. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.show', [$workOrder->id, '#tab_updates']);
        }

        return $this->response();
    }
}
