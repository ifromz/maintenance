<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Controllers\BaseController;

class AssignedController extends BaseController
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

        return view('maintenance::work-orders.assigned.index', array(
            'title' => 'Assigned Work Orders',
            'workOrders' => $workOrders
        ));
    }
}
