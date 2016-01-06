<?php

namespace App\Http\Controllers\WorkOrder;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkOrder\PartTakeRequest;
use App\Processors\WorkOrder\WorkOrderPartStockProcessor;
use Stevebauman\Inventory\Exceptions\NotEnoughStockException;

class WorkOrderPartStockController extends Controller
{
    /**
     * @var WorkOrderPartStockProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param WorkOrderPartStockProcessor $processor
     */
    public function __construct(WorkOrderPartStockProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Display Inventory item stocks per location
     * available to transfer into the work order.
     *
     * @param int|string $workOrderId
     * @param int|string $itemId
     *
     * @return \Illuminate\View\View
     */
    public function index($workOrderId, $itemId)
    {
        return $this->processor->index($workOrderId, $itemId);
    }

    /**
     * Displays the form for taking inventory stock
     * and attaching it to the specified work order.
     *
     * @param int|string $workOrderId
     * @param int|string $itemId
     * @param int|string $stockId
     *
     * @return \Illuminate\View\View
     */
    public function getTake($workOrderId, $itemId, $stockId)
    {
        return $this->processor->getTake($workOrderId, $itemId, $stockId);
    }

    /**
     * Processes taking quantity from the stock and
     * inserting it into the work order.
     *
     * @param PartTakeRequest $request
     * @param int|string      $workOrderId
     * @param int|string      $itemId
     * @param int|string      $stockId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTake(PartTakeRequest $request, $workOrderId, $itemId, $stockId)
    {
        try {
            if ($this->processor->postTake($request, $workOrderId, $itemId, $stockId)) {
                flash()->success('Success!', 'Successfully added parts to work order.');

                return redirect()->route('maintenance.work-orders.parts.index', [$workOrderId]);
            } else {
                flash()->error('Error!', 'There was an issue adding parts to this work order. Please try again.');

                return redirect()->route('maintenance.work-orders.parts.stocks.take', [$workOrderId, $itemId, $stockId]);
            }
        } catch (NotEnoughStockException $e) {
            flash()->error('Not Enough Stock', "There isn't enough stock available to take the requested quantity.");

            return redirect()->route('maintenance.work-orders.parts.stocks.take', [$workOrderId, $itemId, $stockId]);
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
