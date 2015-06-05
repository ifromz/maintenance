<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder\Part;

use Stevebauman\Maintenance\Http\Requests\WorkOrder\Part\ReturnRequest;
use Stevebauman\Maintenance\Http\Requests\WorkOrder\Part\TakeRequest;
use Stevebauman\Maintenance\Repositories\Inventory\Repository as InventoryRepository;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class StockController extends Controller
{
    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * @var InventoryRepository
     */
    protected $inventory;

    /**
     * Constructor.
     *
     * @param WorkOrderRepository $workOrder
     * @param InventoryRepository $inventory
     */
    public function __construct(WorkOrderRepository $workOrder, InventoryRepository $inventory)
    {
        $this->workOrder = $workOrder;
        $this->inventory = $inventory;
    }

    /**
     * Display Inventory item stocks per location
     * available to transfer into the work order.
     *
     * @param int|string $workOrderId
     * @param int|string $inventoryId
     *
     * @return \Illuminate\View\View
     */
    public function index($workOrderId, $inventoryId)
    {
        $workOrder = $this->workOrder->find($workOrderId);
        $item = $this->inventory->find($inventoryId);

        return view('maintenance::work-orders.parts.inventory.stocks.index', compact('workOrder', 'item'));
    }

    /**
     * Displays the form for taking inventory stock
     * and attaching it to the specified work order.
     *
     * @param int|string $workOrderId
     * @param int|string $inventoryId
     * @param int|string $stockId
     *
     * @return \Illuminate\View\View
     */
    public function getTake($workOrderId, $inventoryId, $stockId)
    {
        $workOrder = $this->workOrder->find($workOrderId);
        $item = $this->inventory->find($inventoryId);
        $stock = $item->stocks()->findOrFail($stockId);

        return view('maintenance::work-orders.parts.inventory.stocks.take', compact('workOrder', 'item', 'stock'));
    }

    public function postTake(TakeRequest $request, $workOrderId, $inventoryId, $stockId)
    {
        if($this->workOrder->takePart($request, $workOrderId, $stockId)) {

        } else {

        }
    }

    public function getPut($workOrderId, $inventoryId, $stockId)
    {
        $workOrder = $this->workOrder->find($workOrderId);
        $item = $this->inventory->find($inventoryId);
    }

    public function postPut(ReturnRequest $request, $workOrderId, $inventoryId, $stockId)
    {
        if($this->workOrder->returnPart($request, $workOrderId, $stockId)) {

        } else {

        }
    }
}
