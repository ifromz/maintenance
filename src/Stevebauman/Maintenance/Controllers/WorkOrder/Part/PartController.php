<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder\Part;

use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Controllers\BaseController;

class PartController extends BaseController
{

    public function __construct(WorkOrderService $workOrder, InventoryService $inventory)
    {
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

        return view('maintenance::work-orders.parts.index', [
            'title' => 'Add parts to Work Order: ' . $workOrder->subject,
            'workOrder' => $workOrder,
            'items' => $items,
        ]);

    }

}
