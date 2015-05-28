<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Stevebauman\Maintenance\Services\WorkRequestService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

/**
 * Class RequestController.
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
     * Constructor.
     *
     * @param WorkOrderService   $workOrder
     * @param WorkRequestService $workRequest
     */
    public function __construct(WorkOrderService $workOrder, WorkRequestService $workRequest)
    {
        $this->workOrder = $workOrder;
        $this->workRequest = $workRequest;
    }

    /**
     * Displays the form to create a work order from the
     * specified request.
     *
     * @param string|int $requestId
     *
     * @return \Illuminate\View\View
     */
    public function create($requestId)
    {
        $workRequest = $this->workRequest->find($requestId);

        return view('maintenance::work-orders.requests.create', [
            'title' => 'Create Work Order from Request',
            'workRequest' => $workRequest,
        ]);
    }

    /**
     * Creates a new work order for the specified
     * request.
     *
     * @param string|int $requestId
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store($requestId)
    {
        $workRequest = $this->workRequest->find($requestId);

        /*
         * If a work order already exists for this request, we'll return
         * an error and let the user know
         */
        if ($workRequest->workOrder) {
            $link = link_to_route('maintenance.work-orders.show', 'Show Work Order', [$workRequest->workOrder->id]);

            $this->message = "A work order already exists for this work request. $link";
            $this->messageType = 'warning';
            $this->redirect = routeBack('maintenance.work-requests.index');

            return $this->response();
        }

        $workOrder = $this->workOrder->createFromWorkRequest($workRequest);

        if ($workOrder) {
            $link = link_to_route('maintenance.work-orders.show', 'Show', [$workOrder->id]);

            $this->message = "Successfully generated work order. $link";
            $this->messageType = 'success';
            $this->redirect = routeBack('maintenance.work-orders.show', [$workOrder->id]);
        } else {
            $message = 'There was an issue trying to generate a work order for this request.
            If a work order was deleted that was attached to this request, it will have to be removed/recovered by
            an administrator before generating another work order.';

            $this->message = $message;
            $this->messageType = 'danger';
            $this->redirect = routeBack('maintenance.work-orders.requests.create', [$requestId]);
        }

        return $this->response();
    }
}
