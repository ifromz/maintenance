<?php

namespace App\Processors\WorkOrder;

use App\Http\Requests\WorkOrder\PartReturnRequest;
use App\Http\Requests\WorkOrder\PartTakeRequest;
use App\Http\Presenters\WorkOrder\WorkOrderPartStockPresenter;
use App\Jobs\WorkOrder\Part\Take;
use App\Models\Inventory;
use App\Models\WorkOrder;
use App\Processors\Processor;

class WorkOrderPartStockProcessor extends Processor
{
    /**
     * @var WorkOrder
     */
    protected $workOrder;

    /**
     * @var Inventory
     */
    protected $inventory;

    /**
     * Constructor.
     *
     * @param WorkOrder                   $workOrder
     * @param Inventory                   $inventory
     * @param WorkOrderPartStockPresenter $presenter
     */
    public function __construct(WorkOrder $workOrder, Inventory $inventory, WorkOrderPartStockPresenter $presenter)
    {
        $this->workOrder = $workOrder;
        $this->inventory = $inventory;
        $this->presenter = $presenter;
    }

    /**
     * Displays all stocks and variants available for selection.
     *
     * @param int|string $workOrderId
     * @param int|string $itemId
     *
     * @return \Illuminate\View\View
     */
    public function index($workOrderId, $itemId)
    {
        $workOrder = $this->workOrder->findOrFail($workOrderId);

        $item = $this->inventory->findOrFail($itemId);

        $stocks = $this->presenter->table($workOrder, $item);

        $variants = $this->presenter->tableVariants($workOrder, $item);

        return view('work-orders.parts.stocks.index', compact('stocks', 'variants'));
    }

    /**
     *
     *
     * @param int|string $workOrderId
     * @param int|string $itemId
     * @param int|string $stockId
     *
     * @return \Illuminate\View\View
     */
    public function getTake($workOrderId, $itemId, $stockId)
    {
        $workOrder = $this->workOrder->findOrFail($workOrderId);

        $item = $this->inventory->findOrFail($itemId);

        $stock = $item->stocks()->findOrFail($stockId);

        $form = $this->presenter->formTake($workOrder, $item, $stock);

        return view('work-orders.parts.stocks.take', compact('workOrder', 'item', 'stock', 'form'));
    }

    public function postTake(PartTakeRequest $request, $workOrderId, $itemId, $stockId)
    {
        $workOrder = $this->workOrder->findOrFail($workOrderId);

        $item = $this->inventory->findOrFail($itemId);

        $stock = $item->stocks()->findOrFail($stockId);

        return $this->dispatch(new Take($request, $workOrder, $stock));
    }

    public function getPut($workOrderId, $itemId, $stockId)
    {
        //
    }

    public function postPut(PartReturnRequest $request, $workOrderId, $itemId, $stockId)
    {
        //
    }
}
