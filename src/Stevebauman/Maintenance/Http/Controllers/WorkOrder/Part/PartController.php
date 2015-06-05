<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder\Part;

use Stevebauman\Maintenance\Http\Requests\WorkOrder\Part\PutBackRequest;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class PartController extends Controller
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
