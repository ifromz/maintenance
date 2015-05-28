<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class AssignedController extends Controller
{
    /**
     * Constructor.
     *
     * @param WorkOrderService $workOrder
     */
    public function __construct(WorkOrderService $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Displays the all assigned work orders for the current user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $workOrders = $this->workOrder->getUserAssignedWorkOrders();

        return view('maintenance::work-orders.assigned.index', [
            'title' => 'Assigned Work Orders',
            'workOrders' => $workOrders,
        ]);
    }
}
