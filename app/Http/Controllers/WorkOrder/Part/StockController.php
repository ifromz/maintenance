<?php

namespace App\Http\Controllers\WorkOrder\Part;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\WorkOrder\Part\ReturnRequest;
use App\Http\Requests\WorkOrder\Part\TakeRequest;
use App\Models\InventoryStock;
use App\Repositories\Inventory\Repository as InventoryRepository;
use App\Repositories\WorkOrder\Repository as WorkOrderRepository;

class StockController extends BaseController
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

        return view('work-orders.parts.inventory.stocks.index', compact('workOrder', 'item'));
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

        $stock = $item->stocks()->find($stockId);

        if ($stock instanceof InventoryStock) {
            return view('work-orders.parts.inventory.stocks.take', compact('workOrder', 'item', 'stock'));
        }

        abort(404);
    }

    /**
     * Processes taking quantity from the stock and
     * inserting it into the work order.
     *
     * @param TakeRequest $request
     * @param int|string  $workOrderId
     * @param int|string  $inventoryId
     * @param int|string  $stockId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTake(TakeRequest $request, $workOrderId, $inventoryId, $stockId)
    {
        if ($this->workOrder->takePart($request, $workOrderId, $stockId)) {
            $message = 'Successfully added parts to work order.';

            return redirect()->route('maintenance.work-orders.parts.index', [$workOrderId])->withSuccess($message);
        } else {
            $message = 'There was an issue adding parts to this work order. Please try again.';

            return redirect()->route('maintenance.work-orders.parts.stocks.take', [$workOrderId, $inventoryId, $stockId])->withErrors($message);
        }
    }

    /**
     * Displays the form for returning parts to the inventory.
     *
     * @param int|string $workOrderId
     * @param int|string $inventoryId
     * @param int|string $stockId
     *
     * @return \Illuminate\View\View
     */
    public function getPut($workOrderId, $inventoryId, $stockId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        $stock = $workOrder->parts()->find($stockId);

        if ($stock instanceof InventoryStock) {
            $item = $stock->item;

            return view('work-orders.parts.inventory.stocks.put', compact('workOrder', 'item', 'stock'));
        }

        abort(404);
    }

    /**
     * Processes returning parts back into the inventory.
     *
     * @param ReturnRequest $request
     * @param int|string    $workOrderId
     * @param int|string    $inventoryId
     * @param int|string    $stockId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPut(ReturnRequest $request, $workOrderId, $inventoryId, $stockId)
    {
        if ($this->workOrder->returnPart($request, $workOrderId, $stockId)) {
            $message = 'Successfully returned parts to the inventory.';

            return redirect()->route('maintenance.work-orders.parts.index', [$workOrderId])->withSuccess($message);
        } else {
            $message = 'There was an issue returning parts into the inventory. Please try again.';

            return redirect()->route('maintenance.work-orders.parts.stocks.put', [$workOrderId])->withErrors($message);
        }
    }
}
