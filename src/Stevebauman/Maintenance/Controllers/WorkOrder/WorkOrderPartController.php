<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\InventoryService;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class WorkOrderPartController extends AbstractController {
        
        public function __construct(WorkOrderService $workOrder, InventoryService $inventory){
            $this->workOrder = $workOrder;
            $this->inventory = $inventory;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($workOrder_id)
	{   
            $workOrder = $this->workOrder->find($workOrder_id);
            
            $items = $this->inventory->setInput($this->inputAll())->getByPageWithFilter();
            
            return $this->view('maintenance::work-orders.parts.index', array(
                'title' => 'Add parts to Work Order: '.$workOrder->subject,
                'workOrder' => $workOrder,
                'items' => $items,
            ));
            
	}

}
