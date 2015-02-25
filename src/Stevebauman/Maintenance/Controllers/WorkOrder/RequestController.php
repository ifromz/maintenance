<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Services\WorkRequestService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class RequestController
 * @package Stevebauman\Maintenance\Controllers\WorkOrder
 */
class RequestController extends BaseController
{
    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var WorkRequestService
     */
    protected $workRequest;

    /**
     * @param WorkOrderService $workOrder
     * @param WorkRequestService $workRequest
     */
    public function __construct(WorkOrderService $workOrder, WorkRequestService $workRequest)
    {
        $this->workOrder = $workOrder;
        $this->workRequest = $workRequest;
    }

    public function create($requestId)
    {
        $workRequest = $this->workRequest->find($requestId);

        return view('maintenance::work-orders.requests.create', array(
            'title' => 'Create Work Order from Request',
            'workRequest' => $workRequest,
        ));
    }

    public function store($requestId)
    {
        $workRequest = $this->workRequest->find($requestId);

        $workOrder = $this->workOrder->createFromWorkRequest($workRequest);

        if($workOrder)
        {
            $link = link_to_route('maintenance.work-orders.show', 'Show', array($workOrder->id));

            $this->message = "Successfully generated work order. $link";
            $this->messageType = 'success';
            $this->redirect = routeBack('maintenance.work-orders.show', array($workOrder->id));
        } else
        {
            $this->message = 'There was an issue trying to generate a work order. Please try again';
            $this->messageType = 'success';
            $this->redirect = routeBack('maintenance.work-orders.requests.create', array($requestId));
        }

        return $this->response();
    }
}