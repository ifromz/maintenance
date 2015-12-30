<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder\Part;

use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;

class Controller extends BaseController
{
    /**
     * Constructor.
     *
     * @param WorkOrderRepository $workOrder
     */
    public function __construct(WorkOrderRepository $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Displays all the work orders parts.
     *
     * @param int|string $workOrderId
     *
     * @return \Illuminate\View\View
     */
    public function index($workOrderId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        return view('maintenance::work-orders.parts.index', compact('workOrder'));
    }
}
