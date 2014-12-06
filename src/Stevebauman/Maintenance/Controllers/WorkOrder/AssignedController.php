<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Controllers\BaseController;

class AssignedController extends BaseController {
    
    public function __construct(WorkOrderService $workOrder)
    {
        $this->workOrder = $workOrder;
    }
    
    public function index()
    {
        $workOrders  = $this->workOrder->getUserAssignedWorkOrders();
         
        return view('maintenance::work-orders.assigned.index', array(
            'title' => 'Assigned Work Orders',
            'workOrders' => $workOrders
        ));
    }
    
}