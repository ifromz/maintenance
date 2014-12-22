<?php 

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;

class WorkOrderSelectComposer {
    
    public function __construct(WorkOrderService $workOrder){
        $this->workOrder = $workOrder;
    }
    
    public function compose($view)
    {
        $allWorkOrders = $this->workOrder->get()->lists('subject', 'id');
        
        return $view->with('allWorkOrders', $allWorkOrders);
    }
    
}
