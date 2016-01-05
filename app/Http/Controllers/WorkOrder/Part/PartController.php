<?php

namespace App\Http\Controllers\WorkOrder\Part;

use App\Http\Controllers\Controller as BaseController;
use App\Repositories\WorkOrder\Repository as WorkOrderRepository;

class PartController extends BaseController
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

        return view('work-orders.parts.index', compact('workOrder'));
    }
}
